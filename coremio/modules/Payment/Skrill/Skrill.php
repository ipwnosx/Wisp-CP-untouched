<?php
    class Skrill {
        public $checkout_id,$checkout;
        public $name,$commission=true;
        public $config=[],$lang=[],$page_type = "in-page",$callback_type="server-sided";
        public $payform=false;

        function __construct(){
            $this->config     = Modules::Config("Payment",__CLASS__);
            $this->lang       = Modules::Lang("Payment",__CLASS__);
            $this->name       = __CLASS__;
            $this->payform   = __DIR__.DS."pages".DS."payform";
        }

        public function get_auth_token(){
            $syskey = Config::get("crypt/system");
            $token  = md5(Crypt::encode("Skrill-Auth-Token=".$syskey,$syskey));
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

        public function get_fields($successful='',$failed=''){

            $checkout_items         = $this->checkout["items"];
            $checkout_data          = $this->checkout["data"];
            $user_data              = $checkout_data["user_data"];

            $callback_url           = Controllers::$init->CRLink("payment",['Skrill',$this->get_auth_token(),'callback']);

            $lang                   = strtolower(___("package/code"));


            $fields                         = [
                'pay_to_email'              => $this->config["settings"]["merchant_email"],
                'pay_from_email'            => $user_data["email"],
                'language'                  => $lang,
                'amount'                    => roun($checkout_data["total"],2),
                'currency'                  => $this->cid_convert_code($checkout_data["currency"]),
                'recipient_description'     => '',
                'detail1_description'       => '',
                'detail1_text'              => '',
                'return_url'                => $successful,
                'cancel_url'                => $failed,
                'status_url'                => $callback_url,
                'transaction_id'            => "SK".substr($this->checkout_id.time(),0,100),
                'firstname'                 => $user_data["name"],
                'lastname'                  => $user_data["surname"],
                'address'                   => $user_data["address"]["address"],
                'city'                      => $user_data["address"]["city"],
                'state'                     => $user_data["address"]["counti"],
                'postal_code'               => $user_data["address"]["zipcode"],
                'merchant_fields'           => 'platform,checkout_id',
                'platform'                  => '21477273',
                'checkout_id'               => $this->checkout_id,
            ];
            return $fields;
        }

        public function payment_result(){
            $checkout_id        = Filter::init("GET/checkout_id","numbers");
            $transaction_id     = Filter::init("GET/transaction_id","hclear");
            $merchant_id        = Filter::POST("merchant_id");
            $mb_amount          = Filter::POST("mb_amount");
            $amount             = Filter::POST("amount");
            $mb_currency        = Filter::POST("mb_currency");
            $currency           = Filter::POST("currency");
            $md5sig             = Filter::POST("md5sig");
            $status             = Filter::POST("status");

            $md5_secret         = strtoupper(md5($this->config["settings"]["secret_word"]));
            $hash               = strtoupper(md5($merchant_id.$transaction_id.$md5_secret.$mb_amount.$mb_currency.$status));

            if($hash != $md5sig)
                return [
                    'status'         => "ERROR",
                    'status_msg'     => "Hash matching failed.",
                    'return_msg'     => "Failure",
                ];

            $checkout           = Basket::get_checkout($checkout_id);

            if(!$checkout)
                return [
                    'status' => "ERROR",
                    'status_msg' => Bootstrap::$lang->get("errors/error6",Config::get("general/local")),
                    'return_msg' => "Unsuccessful",
                ];

            $this->set_checkout($checkout);

            $amount_paid    = number_format(Money::exChange($amount,$currency,$checkout["data"]["currency"]),2,'.','');
            $total_paid     = number_format($checkout["data"]["total"],2,'.','');

            if($amount_paid < $total_paid)
                return [
                    'checkout'    => $checkout,
                    'status' => "ERROR",
                    'status_msg' => Bootstrap::$lang->get("errors/error7",Config::get("general/local")),
                    'return_msg' => 'Failure',
                ];


            $invoice = Invoices::search_pmethod_msg('"txn_id":"'.$transaction_id.'"');

            if($invoice){
                $checkout["data"]["invoice_id"] = $invoice;
                $invoice = Invoices::get($invoice);
            }

            if($invoice && $invoice["status"] == "paid"){
                Basket::set_checkout($checkout["id"],['status' => "paid"]);
                return [
                    'status' => "SUCCESS",
                    'return_msg' => "Successful",
                ];
            }

            if($status == 2){
                Basket::set_checkout($checkout["id"],['status' => "paid"]);

                if($invoice){
                    Invoices::paid($checkout,"SUCCESS",$invoice["pmethod_msg"]);
                    return [
                        'status' => "SUCCESS",
                        'return_msg' => "Successful",
                    ];
                }else
                    return [
                        'status' => "SUCCESS",
                        'checkout'    => $checkout,
                        'status_msg' => Utility::jencode([
                            'txn_id' => $transaction_id,
                            'POST Total' => $amount." ".$currency,
                        ]),
                        'return_msg' => "Successful",
                    ];
            }
        }

    }