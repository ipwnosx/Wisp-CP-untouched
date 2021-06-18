<?php
    class BankTransfer {
        public $config = [];
        public $lang=[],$name,$commission=false;
        public $page_type="in-page",$payform=__DIR__.DS."pages".DS."payform",$callback_type="client-sided";
        public $call_function=[];
        public $links;
        private $accounts,$checkout_id=0,$checkout;

        function __construct(){
            $this->config     = Modules::Config("Payment",__CLASS__);
            $this->lang       = Modules::Lang("Payment",__CLASS__);
            $this->name       = __CLASS__;
            $functions        = [];
            $links            = [
                'notification' => Controllers::$init->CRLink("payment",[__CLASS__,$this->get_auth_token(),"notification"]),
            ];
            $functions['notification'] = function (){
                $bank           = Filter::init("POST/bank","numbers");
                $sender_name    = Filter::init("POST/sender_name","hclear");

                if(Validation::isEmpty(Filter::POST("bank")))
                    die(Utility::jencode([
                        'status' => "error",
                        'for' => "select[name='bank']",
                        'message' => $this->lang["error1"],
                    ]));

                if(Validation::isEmpty($sender_name))
                    die(Utility::jencode([
                        'status' => "error",
                        'for' => "input[name='sender_name']",
                        'message' => $this->lang["error2"],
                    ]));

                $gbank      = $this->get_bank($bank);
                if(!$gbank)
                    die(Utility::jencode([
                        'status' => "error",
                        'for' => "select[name='bank']",
                        'message' => $this->lang["error1"],
                    ]));

                $rce    = $this->get_rce();

                Session::set("banktransfer_data",Utility::jencode([
                    'bank_id' => $bank,
                    'bank_name' => $gbank["name"],
                    'sender_name' => $sender_name,
                    'rce' => $rce,
                ]));

                $this->delete_rce(Session::get("banktransfer_ctid"));

                $callback = Controllers::$init->CRLink("payment",[__CLASS__,$this->get_auth_token(),"callback"]);
                echo Utility::jencode(['status' => "successful",'redirect' => $callback]);

            };
            $this->links         = $links;
            $this->call_function = $functions;

        }

        public function get_auth_token(){
            return 'none';
        }

        public function set_checkout($checkout){
            $this->checkout_id = $checkout["id"];
            $this->checkout    = $checkout;
            Session::set("banktransfer_ctid",$this->checkout_id);
            $this->set_rce($this->checkout_id);
        }

        public function rce_generating(){
            return rand(100000,999999);
        }

        public function get_rce(){
            if(Session::get("banktransfer_ctid")){
                $ctid = Session::get("banktransfer_ctid");
                if(Session::get("banktransfer_rce_".$ctid)) return Session::get("banktransfer_rce_".$ctid);
            }
            return false;
        }

        public function delete_rce($ctid=0){
            if(Session::get("banktransfer_rce_".$ctid)) Session::delete("banktransfer_rce_".$ctid);
        }

        public function set_rce($ctid=0,$rce=''){
            $rce    = $rce == '' ? $this->rce_generating() : $rce;
            if(!Session::get("banktransfer_rce_".$ctid)) Session::set("banktransfer_rce_".$ctid,$rce);
        }

        public function accounts(){
            if(!$this->accounts){
                $lang   = Bootstrap::$lang->clang;
                $data   = FileManager::file_read(__DIR__.DS."bank-accounts-".$lang.".json");
                if($data) $data   = Utility::jdecode($data,true);
                if($data){
                    $way  = RESOURCE_DIR."uploads".DS."modules".DS."Payment".DS.__CLASS__.DS;
                    $keys = array_keys($data);
                    $size = sizeof($keys)-1;
                    for($i=0;$i<=$size;$i++){
                        $var = $data[$keys[$i]];
                        if($var["status"]){
                            if(isset($var["image"]) && $var["image"] != ''){
                                $data[$keys[$i]]["image"] = Utility::image_link_determiner($var["image"],$way);
                            }
                        }else{
                            unset($data[$keys[$i]]);
                        }
                    }
                    $data = array_values($data);
                    $this->accounts = $data;
                    return $data;
                }
            }else return $this->accounts;
        }

        public function get_bank($id=false){
            $list = $this->accounts();
            foreach($list AS $k=>$v) if($id == $v["id"]) return $v;
            return false;
        }

        public function payment_result(){
            $ctid   = Session::get("banktransfer_ctid");
            $data   = Session::get("banktransfer_data");
            Session::delete("banktransfer_ctid");
            Session::delete("banktransfer_data");

            $checkout_id        = (int) $ctid;
            $checkout           = Basket::get_checkout($checkout_id);
            if(!$checkout)
                return [
                    'status' => "ERROR",
                    'status_msg' => Bootstrap::$lang->get("errors/error6",Config::get("general/local")),
                ];

            $this->set_checkout($checkout);

            Basket::set_checkout($checkout["id"],['status' => "paid"]);

            if($checkout["type"] == "invoice-bulk-payment"){
                $data = Utility::jdecode($data,true);
                $data["bulk_payment"] = true;
                $data["payable_amount"] = $checkout["data"]["total"];
                $data["payable_amount_cid"] = $checkout["data"]["currency"];
                $data = Utility::jencode($data);
            }


            $result = [
                'checkout' => $checkout,
                'status' => "PAPPROVAL",
                'status_msg' => $data,
            ];
            return $result;
        }

    }