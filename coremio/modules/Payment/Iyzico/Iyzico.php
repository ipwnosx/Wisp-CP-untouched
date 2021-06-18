<?php
    class Iyzico {
        private $options;
        private $test=false;
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
            $token  = md5(Crypt::encode("Iyzico-Auth-Token=".$syskey,$syskey));
            return $token;
        }

        public function set_checkout($checkout){
            $this->checkout_id = $checkout["id"];
            $this->checkout    = $checkout;
        }

        public function get_callback_url(){
            return Controllers::$init->CRLink("payment",["Iyzico",$this->get_auth_token(),"callback"]);
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


        private function init(){
            if(!class_exists("IyzipayBootstrap")){
                require_once(__DIR__.DS."Source".DS."IyzipayBootstrap.php");
                IyzipayBootstrap::init();

                $this->options = new \Iyzipay\Options();
                $this->options->setApiKey($this->config["settings"]["api_key"]);
                $this->options->setSecretKey($this->config["settings"]["secret_key"]);

                if($this->test)
                    $this->options->setBaseUrl("https://sandbox-api.iyzipay.com/");
                else
                    $this->options->setBaseUrl("https://api.iyzipay.com/");
            }
        }

        public function inline_form(){
            if(!$this->checkout) $this->checkout = Basket::get_checkout($this->checkout_id);
            if(!$this->checkout){
                echo "Checkout Data Not Found";
                return false;
            }
            $checkout_items         = $this->checkout["items"];
            $checkout_data          = $this->checkout["data"];
            $user_data              = $checkout_data["user_data"];

            $currency               = $this->cid_convert_code($checkout_data["currency"]);
            $user_ip                = $this->get_ip();
            $email                  = $user_data["email"];
            $payment_amount         = number_format($checkout_data["total"], 2, '.', '');
            $user_basket            = "";
            $user_name              = $user_data["full_name"];
            if($user_data["company_name"]) $user_name .= " ".$user_data["company_name"];
            $user_address           = $user_data["address"]["country_name"];
            $user_address           .= " / ".$user_data["address"]["city"];
            $user_address           .= " / ".$user_data["address"]["counti"];
            $user_address           .= " / ".$user_data["address"]["address"];
            $user_phone             = $user_data["gsm_cc"].$user_data["gsm"];
            $lang                   = strtolower(___("package/code"));


            $this->init();

            # create request class
            $request = new \Iyzipay\Request\CreateCheckoutFormInitializeRequest();
            if(Bootstrap::$lang->clang == "tr") $request->setLocale(\Iyzipay\Model\Locale::TR);
            else $request->setLocale(\Iyzipay\Model\Locale::EN);

            $request->setConversationId("65465464646");
            $request->setPrice($payment_amount);
            $request->setPaidPrice($payment_amount);
            $request->setBasketId($this->checkout_id);
            //$request->setBasketId("BI101");
            $request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT);
            $request->setCallbackUrl($this->get_callback_url());
            $buyer = new \Iyzipay\Model\Buyer();
            $buyer->setId("BY789");
            $buyer->setName($user_data["name"]);
            $buyer->setSurname($user_data["surname"]);
            if($user_phone) $buyer->setGsmNumber($user_phone);
            $buyer->setEmail($email);
            $buyer->setIdentityNumber(isset($user_data["identity"]) ? $user_data["identity"] : "74300864791");
            $buyer->setRegistrationAddress($user_address);
            $buyer->setIp($user_ip);
            $buyer->setCity($user_data["address"]["city"]);
            $buyer->setCountry($user_data["address"]["country_name"]);
            $buyer->setZipCode($user_data["address"]["zipcode"]);
            $request->setBuyer($buyer);

            $shippingAddress = new \Iyzipay\Model\Address();
            $shippingAddress->setContactName($user_name);
            $shippingAddress->setCity($user_data["address"]["city"]);
            $shippingAddress->setCountry($user_data["address"]["country_name"]);
            $shippingAddress->setAddress($user_address);
            $shippingAddress->setZipCode($user_data["address"]["zipcode"]);
            $request->setShippingAddress($shippingAddress);

            $billingAddress = new \Iyzipay\Model\Address();
            $billingAddress->setContactName($user_name);
            $billingAddress->setCity($user_data["address"]["city"]);
            $billingAddress->setCountry($user_data["address"]["country_name"]);
            $billingAddress->setAddress($user_address);
            $billingAddress->setZipCode($user_data["address"]["zipcode"]);
            $request->setbillingAddress($billingAddress);
            $basketItems = array();
            $firstBasketItem = new \Iyzipay\Model\BasketItem();
            $firstBasketItem->setId("BI101");
            $firstBasketItem->setName("Basket");
            $firstBasketItem->setCategory1("Basket Category 1");
            $firstBasketItem->setCategory2("Basket Category 2");
            $firstBasketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
            $firstBasketItem->setPrice($payment_amount);
            $basketItems[0] = $firstBasketItem;
            $request->setBasketItems($basketItems);
            $request->setCurrency($currency);
            $request->setLocale($lang);
            $result     = \Iyzipay\Model\CheckoutFormInitialize::create($request,$this->options);
            $status	= $result->getstatus();

            if($status == 'success'){
                $returnText = '';
                $returnText .= '<div style="width: 80%;margin-top: 20px;">';
                $returnText .= '<div id="iyzipay-checkout-form" class="responsive"></div>';
                $returnText .= '</div>';
                $returnText .= $result->getCheckoutFormContent();
                return $returnText;
            }else return $result->geterrorMessage();
        }

        public function payment_result(){
            $this->init();

            # create request class
            $request = new \Iyzipay\Request\RetrieveCheckoutFormRequest();
            if(Bootstrap::$lang->clang == "tr") $request->setLocale(\Iyzipay\Model\Locale::TR);
            else $request->setLocale(\Iyzipay\Model\Locale::EN);
            $request->setConversationId("65465464646");
            $request->setToken(Filter::POST("token"));

            # make request
            $checkoutForm = \Iyzipay\Model\CheckoutForm::retrieve($request,$this->options);

            $ctid               = (int) $checkoutForm->getBasketId();
            $checkout           = Basket::get_checkout($ctid);

            if($checkoutForm->getstatus() == "success" && $checkoutForm->getPaymentStatus() == "SUCCESS"){
                if(!$checkout)
                    return [
                        'status' => "ERROR",
                        'status_msg' => Bootstrap::$lang->get("errors/error6",Config::get("general/local")),
                    ];

                $this->set_checkout($checkout);

                Basket::set_checkout($checkout["id"],['status' => "paid"]);

                return [
                    'status' => "SUCCESS",
                    'checkout'    => $checkout,
                ];
            }
            else{
                return [
                    'checkout' => $checkout,
                    'status' => "ERROR",
                    'status_msg' => "Error Code: ".$checkoutForm->geterrorCode()."\nMessage: ".$checkoutForm->geterrorMessage(),
                ];
            }
        }
    }