<?php
    class CoinPayments {
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
            $token  = md5(Crypt::encode("CoinPayments-Auth-Token=".$syskey,$syskey));
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

            $callback_url           = Controllers::$init->CRLink("payment",['CoinPayments',$this->get_auth_token(),'callback']);


            $fields                 = [
                'cmd'               => '_pay_auto',
                'merchant'          => $this->config["settings"]["merchant_id"],
                'reset'             => '1',
                'invoice'           => $this->checkout_id,
                'item_name'         => "Payment",
                'amountf'           => number_format($checkout_data["total"], 2, '.', ''),
                'currency'          => $this->cid_convert_code($checkout_data["currency"]),
                'email'             => $user_data["email"],
                'first_name'        => $user_data["name"],
                'last_name'         => $user_data["surname"],
                'want_shipping'     => $this->config["settings"]["want_shipping"] ? 1 : 0,
                'ipn_url'           => $callback_url,
                'success_url'       => $successful,
                'cancel_url'        => $failed,
            ];

            if($this->config["settings"]["want_shipping"]){
                $fields['address1'] = $user_data["address"]["address"];
                $fields['city']     = $user_data["address"]["city"];
                $fields['state']    = $user_data["address"]["counti"];
                $fields['zip']      = $user_data["address"]["zipcode"];
                $fields['country']  = $user_data["address"]["country_code"];
                $fields['phone']    = $user_data["gsm"] ? $user_data["gsm_cc"].$user_data["gsm"] : '';
            }

            return $fields;
        }

        public function payment_result(){

            $checkout_id        = (int) Filter::POST("invoice");
            $checkout           = Basket::get_checkout($checkout_id);

            if(!$checkout)
                return [
                    'status' => "ERROR",
                    'status_msg' => Bootstrap::$lang->get("errors/error6",Config::get("general/local")),
                    'return_msg' => "IPN Error: ".Bootstrap::$lang->get("errors/error6",Config::get("general/local")),
                ];

            $this->set_checkout($checkout);

            if(Filter::POST('ipn_mode') !== "hmac")
                return [
                    'checkout'       => $checkout,
                    'status'         => "ERROR",
                    'status_msg'     => "Unsupported IPN verification mode!",
                    'return_msg'     => "IPN Error: Unsupported IPN verification mode!",
                ];

            if(!isset($_SERVER['HTTP_HMAC']) || !$_SERVER['HTTP_HMAC'])
                return [
                    'checkout'       => $checkout,
                    'status'         => "ERROR",
                    'status_msg'     => "No HMAC signature sent.",
                    'return_msg'     => "IPN Error: No HMAC signature sent.",
                ];


            $request    = file_get_contents('php://input');

            if(!$request)
                return [
                    'checkout'       => $checkout,
                    'status'         => "ERROR",
                    'status_msg'     => "Error reading POST data",
                    'return_msg'     => "IPN Error: Error reading POST data",
                ];

            $hmac = hash_hmac("sha512",$request,trim($this->config["settings"]["ipn_secret"]));

            if($hmac != $_SERVER['HTTP_HMAC'])
                return [
                    'checkout'       => $checkout,
                    'status'         => "ERROR",
                    'status_msg'     => "HMAC signature does not match",
                    'return_msg'     => "IPN Error: HMAC signature does not match",
                ];

            $ipn_type       = Filter::POST("ipn_type");
            $merchant       = Filter::POST("merchant");
            $status         = Filter::POST("status");
            $status_text    = Filter::POST("status_text");
            $txn_id         = Filter::POST("txn_id");
            $amount1        = Filter::POST("amount1");
            $amount2        = Filter::POST("amount2");
            $currency1      = Filter::POST("currency1");
            $currency2      = Filter::POST("currency2");

            if($ipn_type != "button" && $ipn_type != "simple")
                return [
                    'checkout'       => $checkout,
                    'status'         => "ERROR",
                    'status_msg'     => "Invalid IPN Type: ".Filter::html_clear($ipn_type),
                    'return_msg'     => "IPN Error: Invalid IPN Type: ".Filter::html_clear($ipn_type),
                ];

            if($merchant != trim($this->config["settings"]["merchant_id"]))
                return [
                    'checkout'       => $checkout,
                    'status'         => "ERROR",
                    'status_msg'     => "Invalid Merchant ID",
                    'return_msg'     => "IPN Error: Invalid Merchant ID",
                ];

            if($amount1 <= 0)
                return [
                    'checkout'       => $checkout,
                    'status'         => "ERROR",
                    'status_msg'     => "Invalid Amount",
                    'return_msg'     => "IPN Error: Invalid Amount",
                ];

            $amount_paid    = number_format(Money::exChange($amount1,$currency1,$checkout["data"]["currency"]),2,'.','');
            $total_paid     = number_format($checkout["data"]["total"],2,'.','');

            if($amount_paid < $total_paid)
                return [
                    'checkout'    => $checkout,
                    'status' => "ERROR",
                    'status_msg' => Bootstrap::$lang->get("errors/error7",Config::get("general/local")),
                    'return_msg' => Bootstrap::$lang->get("errors/error7",Config::get("general/local")),
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
                    'return_msg' => "OK",
                ];
            }

            if($status >= 100 || $status == 2){
                Basket::set_checkout($checkout["id"],['status' => "paid"]);
                if($invoice){
                    Invoices::paid($checkout,"SUCCESS",$invoice["pmethod_msg"]);
                    return [
                        'status' => "SUCCESS",
                        'return_msg' => "OK",
                    ];
                }else
                    return [
                        'status' => "SUCCESS",
                        'checkout'    => $checkout,
                        'status_msg' => Utility::jencode([
                            'txn_id' => $txn_id,
                            'Original Paid' => $amount1." ".$currency1,
                            'Coins Paid'    => $amount2." ".$currency2,
                        ]),
                        'return_msg' => "OK",
                    ];
            }elseif($status >= 0){
                if($invoice)
                    return [
                        'status' => "PENDING",
                        'return_msg' => "Pending",
                    ];
                else
                    return [
                        'status' => "PAPPROVAL",
                        'checkout'    => $checkout,
                        'status_msg' => Utility::jencode([
                            'txn_id' => $txn_id,
                            'Original Paid' => $amount1." ".$currency1,
                            'Coins Paid'    => $amount2." ".$currency2,
                        ]),
                        'return_msg' => "Pending",
                    ];
            }
            else
                return [
                    'checkout'    => $checkout,
                    'status' => "ERROR",
                    'status_msg' => Filter::html_clear($status_text),
                    'return_msg' => "IPN Error: ".Filter::html_clear($status_text),
                ];
        }
    }