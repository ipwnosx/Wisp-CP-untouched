<?php
    class PerfectMoney {
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
            $token  = md5(Crypt::encode("PerfectMoney-Auth-Token=".$syskey,$syskey));
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

            $gateway_curr           = $this->config["settings"]["currency"];

            $callback_url           = Controllers::$init->CRLink("payment",['PerfectMoney',$this->get_auth_token(),'callback']);
            $exchange_total         = Money::exChange($checkout_data["total"],$checkout_data["currency"],$gateway_curr);

            $fields                         = [
                'SUGGESTED_MEMO'            => 'Payment',
                'PAYMENT_ID'                => $this->checkout_id,
                'PAYMENT_AMOUNT'            => number_format($exchange_total, 2, '.', ''),
                'PAYMENT_UNITS'             => $this->cid_convert_code($gateway_curr),
                'PAYEE_ACCOUNT'             => $this->config["settings"]["id"],
                'PAYEE_NAME'                => __("website/index/meta/title"),
                'STATUS_URL'               => $callback_url,
                'PAYMENT_URL'              => $successful,
                'PAYMENT_URL_METHOD'        => "LINK",
                'NOPAYMENT_URL'             => $failed,
                'NOPAYMENT_URL_METHOD'     => "LINK",
            ];
            return $fields;
        }

        public function payment_result(){
            $string         = Filter::POST("PAYMENT_ID").':'.Filter::POST("PAYEE_ACCOUNT").':';
            $string         .= Filter::POST("PAYMENT_AMOUNT").':'.Filter::POST("PAYMENT_UNITS").':';
            $string         .= Filter::POST("PAYMENT_BATCH_NUM").':';
            $string         .= Filter::POST("PAYER_ACCOUNT").':'.strtoupper(md5($this->config["settings"]["password"])).':';
            $string         .= Filter::POST("TIMESTAMPGMT");
            $hash           = strtoupper(md5($string));
            $checkout_id    = Filter::POST("PAYMENT_ID");
            $txn_id         = Filter::POST("PAYMENT_BATCH_NUM");
            $payment_amount = Filter::POST("PAYMENT_AMOUNT");
            $payment_curr   = Filter::POST("PAYMENT_UNITS");
            $payment_curr_c = $this->cid_convert_code($payment_curr);
            $gateway_curr   = $this->config["settings"]["currency"];
            $gateway_curr_c = $this->cid_convert_code($gateway_curr);

            if(!$payment_curr_c || !$gateway_curr_c)
                return [
                    'status' => "ERROR",
                    'status_msg' => "Currencies are not equal.",
                    'return_msg' => "Unsuccessful",
                ];

            $checkout           = Basket::get_checkout($checkout_id);

            if(!$checkout)
                return [
                    'status' => "ERROR",
                    'status_msg' => Bootstrap::$lang->get("errors/error6",Config::get("general/local")),
                    'return_msg' => "Unsuccessful",
                ];

            $this->set_checkout($checkout);

            if($hash    != Filter::POST("V2_HASH"))
                return [
                    'checkout'       => $checkout,
                    'status'         => "ERROR",
                    'status_msg'     => "Hash matching failed.",
                    'return_msg'     => "Unsuccessful",
                ];

            if(Filter::POST("PAYEE_ACCOUNT") != $this->config["settings"]["id"] || $payment_curr_c != $gateway_curr_c)
                return [
                    'checkout'       => $checkout,
                    'status'         => "ERROR",
                    'status_msg'     => "Use of counterfeit data",
                    'return_msg'     => "Unsuccessful",
                ];

            $gateway_paid       = Money::exChange($payment_amount,$payment_curr,$gateway_curr);
            $amount_paid        = Money::exChange($checkout["data"]["total"],$checkout["data"]["currency"],$gateway_curr);
            $gateway_paid       = number_format($gateway_paid,2,'.','');
            $amount_paid        = number_format($amount_paid,2,'.','');

            if($gateway_paid < $amount_paid)
                return [
                    'checkout'    => $checkout,
                    'status' => "ERROR",
                    'status_msg' => Bootstrap::$lang->get("errors/error7",Config::get("general/local")),
                    'return_msg' => "Unsuccessful",
                ];

            $invoice = Invoices::search_pmethod_msg('"txn_id":"'.$txn_id.'"');

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
                        'txn_id' => $txn_id,
                        'POST Total' => $payment_amount." ".$payment_curr,
                    ]),
                    'return_msg' => "Successful",
                ];
        }

    }