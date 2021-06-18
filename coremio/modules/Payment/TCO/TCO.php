<?php
    class TCO {
        public $checkout_id,$checkout;
        public $name,$commission=true;
        public $config=[],$lang=[],$page_type = "in-page",$callback_type="client-sided";
        public $payform=false;

        function __construct(){
            $this->config     = Modules::Config("Payment",__CLASS__);
            $this->lang       = Modules::Lang("Payment",__CLASS__);
            $this->name       = __CLASS__;
            $this->payform   = __DIR__.DS."pages".DS."payform";
        }

        public function get_auth_token(){
            $syskey = Config::get("crypt/system");
            $token  = md5(Crypt::encode("TCO-Auth-Token=".$syskey,$syskey));
            return $token;
        }

        public function set_checkout($checkout){
            $this->checkout_id = $checkout["id"];
            $this->checkout    = $checkout;
        }

        public function commission_fee_calculator($amount){
            $rate = $this->config["settings"]["commission_rate"];
            $calculate = Money::get_discount_amount($amount,$rate);
            return $calculate;
        }


        public function get_commission_rate(){
            return $this->config["settings"]["commission_rate"];
        }

        public function cid_convert_code($id=0){
            Helper::Load("Money");
            $currency   = Money::Currency($id);
            if($currency) return $currency["code"];
            return false;
        }

        public function get_ip(){
            if( isset( $_SERVER["HTTP_CLIENT_IP"] ) ) {
                $ip = $_SERVER["HTTP_CLIENT_IP"];
            } elseif( isset( $_SERVER["HTTP_X_FORWARDED_FOR"] ) ) {
                $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
            } else {
                $ip = $_SERVER["REMOTE_ADDR"];
            }
            return $ip;
        }


        public function payment_result(){

            $hashSecretWord = Crypt::decode($this->config["settings"]["secret_word"],Config::get("crypt/system"));
            $hashSid        = $this->config["settings"]["sid"];
            $ct_id          = Filter::init($_REQUEST["merchant_order_id"]);
            $hashOrder      = Filter::numbers($_REQUEST['order_number']);
            $demo           = $this->config["settings"]["demo"];
            if($demo) $hashOrder = 1;

            $checkout           = Basket::get_checkout($ct_id);
            if(!$checkout)
                return [
                    'status' => "ERROR",
                    'status_msg' => Bootstrap::$lang->get("errors/error6",Config::get("general/local")),
                    'return_msg' => Bootstrap::$lang->get("errors/error6",Config::get("general/local")),
                ];

            $hashTotal      = (float) number_format($checkout["data"]["total"],2,'.','');

            $StringToHash   = strtoupper(md5($hashSecretWord . $hashSid . $hashOrder . $hashTotal));

            if($StringToHash != $_REQUEST['key']){
                return [
                    'status' => "ERROR",
                    'status_msg' => "Invalid HASH value",
                    'return_msg' => "Invalid HASH value",
                ];
            }

            if($_REQUEST["credit_card_processed"] !== "Y"){
                return [
                    'status' => "ERROR",
                    'status_msg' => "Credit Card not processed",
                    'return_msg' => "Credit Card not processed",
                ];
            }

            $this->set_checkout($checkout);
            Basket::set_checkout($checkout["id"],['status' => "paid"]);

            return [
                'status' => "SUCCESS",
                'checkout'    => $checkout,
            ];

        }
    }