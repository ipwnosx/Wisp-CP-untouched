<?php
    class Shopier {
        public $name,$commission=true;
        public $config=[],$lang=[],$page_type = "in-page",$callback_type="client-sided";
        public $payform=false;
        private $checkout_id=0,$checkout;

        function __construct(){
            $this->config     = Modules::Config("Payment",__CLASS__);
            $this->lang       = Modules::Lang("Payment",__CLASS__);
            $this->name       = __CLASS__;
            $this->payform    = __DIR__.DS."pages".DS."payform";
        }

        public function get_auth_token(){
            $syskey = Config::get("crypt/system");
            $token  = md5(Crypt::encode("Shopier-Auth-Token=".$syskey,$syskey));
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

        private function cid_convert_code($id=0){
            Helper::Load("Money");
            $currency   = Money::Currency($id);
            if($currency) return $currency["code"];
            return false;
        }

        public function get_form_data($ok_url,$fail_url){
            if(!$this->checkout) $this->checkout = Basket::get_checkout($this->checkout_id);
            if(!$this->checkout){
                echo "Checkout Data Not Found";
                return false;
            }

            $checkout_items         = $this->checkout["items"];
            $checkout_data          = $this->checkout["data"];
            $user_data              = $checkout_data["user_data"];
            $user_data              = array_merge($user_data,User::getData($user_data["id"],"creation_time","array"));

            $address           = $user_data["address"]["country_name"];
            $address           .= " / ".$user_data["address"]["city"];
            $address           .= " / ".$user_data["address"]["counti"];
            $address           .= " / ".$user_data["address"]["address"];
            $user_registered   = $user_data["creation_time"];
            $time_elapsed      = time() - strtotime($user_registered);
            $buyer_account_age = (int) ($time_elapsed/86400);
            $product_info      = "Sepet";
            if($checkout_items && is_array($checkout_items)){
                $user_basket = [];
                foreach($checkout_items AS $item) $user_basket[] = str_replace(['"','&quot;'],'',$item["name"]);
                $product_info = implode(" / ",$user_basket);
            }

            if($checkout_data["currency"] == 4) $currency = 1;
            elseif($checkout_data["currency"] == 5) $currency = 2;
            else $currency = 0;

            if(strtolower(___("package/code")) == "tr") $current_lang = 0;
            else $current_lang = 1;
            $modul_version  = '1.4';
            $version = false;
            srand(time());
            $random_nr = rand(100000,999999);

            $post_fields = array(
                'API_key' => $this->config["settings"]["api_key"],
                'website_index' => 1,
                'platform_order_id' => $this->checkout_id,
                'product_name' => $product_info,
                'product_type' => 1,
                'buyer_name'   => $user_data["name"],
                'buyer_surname' => $user_data["surname"],
                'buyer_email' => $user_data["email"],
                'buyer_account_age' => $buyer_account_age,
                'buyer_id_nr' => $user_data["id"],
                'buyer_phone' => $user_data["gsm_cc"].$user_data["gsm"],
                'billing_address' => $address,
                'billing_city' => $user_data["address"]["city"],
                'billing_country' => $user_data["address"]["country_name"],
                'billing_postcode' => $user_data["address"]["zipcode"],
                'shipping_address' => 'NA',
                'shipping_city' => 'NA',
                'shipping_country' => 'NA',
                'shipping_postcode' => 'NA',
                'total_order_value' => number_format($checkout_data["total"], 2, '.', ''),
                'currency' => $currency,
                'current_language' => $current_lang,
                'modul_version' => $modul_version,
                'version'  => $version,
                'platform' => 4,
                'is_in_frame' => 0,
                'random_nr' => $random_nr
            );

            $data = $post_fields["random_nr"].$post_fields['platform_order_id'].$post_fields['total_order_value'].$post_fields['currency'];
            $signature = hash_hmac('SHA256', $data, $this->config["settings"]['api_secret'],true);
            $signature = base64_encode($signature);
            $post_fields['signature'] = $signature;
            $url = $this->config['settings']['payment_url'];

            return [
                'url'       => $url,
                'params'    => $post_fields,
            ];
        }

        public function payment_result(){
            $status             = Filter::POST("status");
            $checkout_id        = (int) Filter::POST("platform_order_id");
            $signature          = Filter::POST("signature");
            $random_nr          = Filter::POST("random_nr");

            $checkout           = Basket::get_checkout($checkout_id);

            if(!$checkout)
                return [
                    'status' => "ERROR",
                    'status_msg' => Bootstrap::$lang->get("errors/error6",Config::get("general/local")),
                    'return_msg' => Bootstrap::$lang->get("errors/error6",Config::get("general/local")),
                ];

            $signature          = base64_decode($signature);
            $data               = $random_nr.$checkout_id;
            $expected           = hash_hmac('SHA256', $data, $this->config["settings"]['api_secret'], true);
            if($signature === $expected){
                $status = strtolower($status);
                if($status != "success")
                    return [
                        'checkout'       => $checkout,
                        'status' => "ERROR",
                        'status_msg' => "Status not successful",
                        'return_msg' => "Status not successful",
                    ];
            }else
                return [
                    'checkout'       => $checkout,
                    'status' => "ERROR",
                    'status_msg' => "Bad signature. '".$signature."' == '".$expected."'",
                    'return_mssg' => "Bad signature. '".$signature."' == '".$expected."'",
                ];

            $this->set_checkout($checkout);

            Basket::set_checkout($checkout["id"],['status' => "paid"]);

            return [
                'status'         => "SUCCESS",
                'checkout'       => $checkout,
            ];

        }


    }