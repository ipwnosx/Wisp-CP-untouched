<?php
    class RavePay {
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
            $token  = md5(Crypt::encode("RavePay-Auth-Token=".$syskey,$syskey));
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

        public function payment_link($url=[]){

            $checkout_items         = $this->checkout["items"];
            $checkout_data          = $this->checkout["data"];
            $user_data              = $checkout_data["user_data"];

            $publicKey = $this->config["settings"]["public_key"];
            $secretKey = $this->config["settings"]["secret_key"];

            $testMode = stristr($publicKey,"TEST");

            if($testMode)
                $payBaseUrl = '<script type="text/javascript" src="http://flw-pms-dev.eu-west-1.elasticbeanstalk.com/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>';
            else
                $payBaseUrl = '<script type="text/javascript" src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script> ';


            $invoiceId          = $this->checkout_id;
            $description         = 'Bill Payment';
            $amount             = number_format($checkout_data["total"], 2, '.', '');
            $currencyCode       = $this->cid_convert_code($checkout_data["currency"]);
            $firstname          = $user_data["name"];
            $lastname           = $user_data["surname"];
            $email              = $user_data["email"];
            $phone              = $user_data["gsm_cc"] ? "+".$user_data["gsm_cc"].$user_data["gsm"] : '';
            
            $callbackUrl        = Controllers::$init->CRLink("payment",['RavePay',$this->get_auth_token(),'callback']);

            $txRef          = md5(uniqid(rand(),true));
            $koboAmount     = $amount*100;

            $jqueryUrl = '<script  src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="  crossorigin="anonymous"></script>';

            $postfields = array();
            $postfields['PBFPubKey'] = $publicKey;
            $postfields['txref'] = $txRef;
            $postfields['amount'] = $koboAmount;
            $postfields['username'] = '';
            $postfields['currency'] = strtoupper($currencyCode);
            $postfields['country'] = $user_data["address"]["country_code"];
            $postfields['customer_email'] = $email;
            $postfields['customer_firstname'] = $firstname;
            $postfields['customer_lastname'] = $lastname;
            $postfields['redirect_url'] = $url["successful-page"];
            $postfields['customer_phone'] = $phone;
            // optional Params
            $postfields['pay_button_text'] = "";
            $postfields['custom_title'] = "";
            $postfields['custom_description'] = "";
            $postfields['custom_logo'] = "";
            $postfields['meta-invoice_id'] = $invoiceId;
            $postfields['meta-description'] = $description;
            $postfields['meta-address1'] = $user_data["address"]["address"];
            $postfields['meta-address2'] = '';
            $postfields['meta-city'] = $user_data["address"]["city"];
            $postfields['meta-state'] = $user_data["address"]["counti"];
            $postfields['meta-postcode'] = $user_data["address"]["zipcode"];

            $htmlOutput = $payBaseUrl;
            $htmlOutput .= $jqueryUrl;
            $htmlOutput .= '<script>
              function setupRavepay(){
                getpaidSetup({
                    customer_email: "'.$email.'",
                    customer_lastname: "'.$lastname.'",
                    customer_firstname: "'.$firstname.'",
                    currency: "'.strtoupper($currencyCode).'",
                    amount: "'.$amount.'",
                    txref: "'.$txRef.'",
                    PBFPubKey: "'.$publicKey.'",

                    onclose:function(){
                        ravepayClosed();
                    },
                    callback:function(response){
                        console.log("d:",response);
                        if (response.tx) {
                            $("#ravepayMsg").html("<h5>Transaction status: "+response.tx.status+". </h5><h5>Transaction ref is "+response.tx.txRef+". </h5><h5>Response: "+response.tx.vbvrespmessage+". </h5>Please wait while we process your Invoice ...");
                            verifyRavepayPayment(response.tx.flwRef);
                        } else {
                            $("#ravepayMsg").html("<h5>Transaction status: "+response.data.data.status+". </h5><h5>Response: "+response.data.data.message+". </h5>");
                        }

                    }
                });
              }
              function verifyRavepayPayment(ref){
                $.post("'.$callbackUrl.'",
                {   flw_ref: ref,
                    txref: "'.$txRef.'",
                    amount: "'.$amount.'",
                    invoice_id: "'.$invoiceId.'"
                },
                function(data, status){
                    $("#ravepayMsg").html(data);
                    if(status === "Successful" || status === "success")
                        window.location.href = "'.$url["successful-page"].'";
                    else
                        window.location.href = "'.$url["failed-page"].'";
                });
              }

              function ravepayClosed(){
                 '.(isset($url["back"]) ? 'window.location.href = "'.$url["back"].'";' : 'window.history.back();').'
              }

            </script>

            <div id="ravepayMsg"></div>
            <div id="ravepayCloseMsg"></div>
               
            <div align="center">
                <div class="progresspayment">
                    <div style="width: 100px; height: 50px; display: block; margin-left: auto; margin-right: auto;    margin-bottom: 20px;">
                        <div data-aos="zoom-in-up" class="cssload-hourglass"></div>
                    </div>
                    <br>
                    <h3 id="progressh3" style="font-weight:bold;">'.$this->lang["redirect-message"].'</h3>
                    <h4>
                        <div class=\'angrytext\'>
                            <strong>'.__("website/others/loader-text2").'</strong>
                        </div>
                    </h4>
                </div>
            </div>

<script type="text/javascript">
    setTimeout(function(){
        setupRavepay();
    },1);
</script>
            
            ';

            return $htmlOutput;

        }

        public function payment_result(){
            $success        = false;
            $txRef          = $_POST["txref"];
            $flw_ref        = $_POST["flw_ref"];
            $invoiceId      = $_POST["invoice_id"];
            $paymentAmount  = $_POST["amount"];
            $verifyStatus   = false;

            $checkout           = Basket::get_checkout($invoiceId);

            if(!$checkout)
                return [
                    'status' => "ERROR",
                    'status_msg' => Bootstrap::$lang->get("errors/error6",Config::get("general/local")),
                    'return_msg' => Bootstrap::$lang->get("errors/error6",Config::get("general/local")),
                ];


            $publicKey = $this->config["settings"]["public_key"];
            $secretKey = $this->config["settings"]["secret_key"];

            $testMode = stristr($publicKey,"TEST");

            if($testMode)
                $verifyUrl = 'http://flw-pms-dev.eu-west-1.elasticbeanstalk.com/flwv3-pug/getpaidx/api/verify';
            else
                $verifyUrl = 'https://api.ravepay.co/flwv3-pug/getpaidx/api/verify';

            $reqBody = array();
            $reqBody["SECKEY"] = $secretKey;
            $reqBody["flw_ref"] = $flw_ref;

            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $verifyUrl,
                CURLOPT_POST => 1,
                CURLOPT_POSTFIELDS => http_build_query($reqBody)
            ));

            $rdata = curl_exec($ch);
            $chinfo = curl_getinfo ($ch);

            if(curl_error($ch))
            {
                return [
                    'checkout'      => $checkout,
                    'status'        => "ERROR",
                    'status_msg'    => "Server connection is failed. ".curl_error($ch),
                    'return_msg'    => "Server connection is failed. ".curl_error($ch),
                ];
            }

            curl_close($ch);

            $output = json_decode($rdata);

            $verifyStatus = $output->status;
            $verifyMessage = $output->message;
            $txStatus = $output->data->status;
            $txAmount = $output->data->amount;
            $paymentFee = $output->data->appfee;

            if ($verifyStatus == 'success') {

                if ($txStatus == 'successful' && $txAmount == $paymentAmount)
                {
                    $success = true;
                }
            }
            else {
                $success = false;
            }

            if(!$success){
                return [
                    'checkout'      => $checkout,
                    'status'        => "ERROR",
                    'status_msg'    => "Verify Status: ".$verifyStatus.", Message: ".$verifyMessage,
                    'return_msg'    => "Verify Status: ".$verifyStatus.", Message: ".$verifyMessage,
                ];
            }

            Basket::set_checkout($checkout["id"],['status' => "paid"]);

            return [
                'status' => "SUCCESS",
                'checkout'    => $checkout,
                'status_msg'  => '',
                'return_msg' => "Successful",
            ];

        }

    }