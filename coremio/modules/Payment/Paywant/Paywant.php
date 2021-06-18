<?php
class Paywant
{
    public $name, $commission = true;
    public $config = [], $lang = [], $page_type = "in-page", $callback_type = "server-sided";
    public $payform = false;
    private $checkout_id = 0, $checkout;

    function __construct()
    {
        $this->config = Modules::Config("Payment", __CLASS__);
        $this->lang = Modules::Lang("Payment", __CLASS__);
        $this->name = __CLASS__;
        $this->payform = __DIR__ . DS . "pages" . DS . "payform";
    }

    public function get_auth_token()
    {
        $syskey = Config::get("crypt/system");
        $token = md5(Crypt::encode("Paywant-Auth-Token=" . $syskey, $syskey));
        return $token;
    }

    public function set_checkout($checkout)
    {
        $this->checkout_id = $checkout["id"];
        $this->checkout = $checkout;
    }
    public function get_ip()
    {
        if (isset($_SERVER["HTTP_CLIENT_IP"]))
        {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        }
        elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
        {
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        }
        else
        {
            $ip = $_SERVER["REMOTE_ADDR"];
        }
        return $ip;
    }

    private function cid_convert_code($id = 0)
    {
        Helper::Load(["Money", "User"]);
        $currency = Money::Currency($id);
        if ($currency) return $currency["code"];
        return false;
    }

    public function get_iframe($ok_url, $fail_url)
    {
        if (!$this->checkout) $this->checkout = Basket::get_checkout($this->checkout_id);
        if (!$this->checkout)
        {
            echo "Checkout Data Not Found";
            return false;
        }
        $checkout_items = $this->checkout["items"];
        $checkout_data = $this->checkout["data"];
        $user_data = $checkout_data["user_data"];
        if ($this->cid_convert_code($checkout_data["currency"]) == "TRY")
        {
            $apiKey = $this->config["settings"]["api_key"];
            $secretKey = $this->config["settings"]["api_secret_key"];
            $userIPAdresi = $this->get_ip();
            $userEmail = $user_data["email"];
            $payment_amount = number_format($checkout_data["total"], 2, '.', '');
            if ($this->config["settings"]["commission_multiplier"] === false || $this->config["settings"]["commission_multiplier"] == 0 || $this->config["settings"]["commission_multiplier"] == "")
            {
                $paywant_amount = $payment_amount;
            }
            else
            {
                $paywant_amount = $payment_amount * $this->config["settings"]["commission_multiplier"];
            }
            $productData = array(
                "name" => $this->checkout_id . " Fatura Ödemesi",
                "amount" => number_format($paywant_amount, 2) * 100,
                "extraData" => $this->checkout_id,
                "paymentChannel" => $this->config["settings"]["payment_channel"],
                "commissionType" => $this->config["settings"]["commission_type"]
            );
            $Hash = base64_encode(hash_hmac('sha256', "$userEmail|$userEmail|" . $user_data["id"] . $apiKey, $secretKey, true));
            $postData = array(
                'apiKey' => $apiKey,
                'hash' => $Hash,
                'returnData' => $userEmail,
                'userEmail' => $userEmail,
                'userIPAddress' => $userIPAdresi,
                'userID' => $user_data["id"],
                'proApi' => true,
                'productData' => $productData
            );
            $postData = http_build_query($postData);
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "http://api.paywant.com/gateway.php",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $postData,
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err)
            {
                $printIt = "cURL Error #:" . $err;
            }
            else
            {
                $jsonDecode = json_decode($response, false);
                if ($jsonDecode->Status == 100)
                {
                    if (!strpos($jsonDecode->Message, "https"))
                    {
                        $jsonDecode->Message = str_replace("http", "https", $jsonDecode->Message);
                    } ?>					
					<iframe seamless="seamless" style="display:block; width:1000px; height:100vh;" frameborder="0" scrolling='yes' src="<?php echo $jsonDecode->Message ?>" id='odemeFrame'></iframe>					<?php
                }
                else
                {
                    echo $response;
                }
            }
        }
        else
        {
            echo "<strong><font color='red'>Paywant ile sadece Türk Lirası türünden ödeme yapılabilir.</font></strong>";
        }
    }

    public function payment_result()
    {
		
		$SiparisID = Filter::POST("SiparisID");
		$ExtraData= Filter::POST("ExtraData");
		$UserID= Filter::POST("UserID");
		$ReturnData= Filter::POST("ReturnData");
		$Status= Filter::POST("Status");
		$OdemeKanali= Filter::POST("OdemeKanali");
		$UrunFiyati= Filter::POST("UrunTutari");
		$OdemeTutari= Filter::POST("OdemeTutari");
		$NetKazanc= Filter::POST("NetKazanc");
		$Hash= @$_POST["Hash"];
			  
		if($SiparisID == "" || $UrunFiyati == "" || $ExtraData == "" || $UserID == "" || $ReturnData == "" || $Status == "" || $OdemeKanali == "" || $OdemeTutari == "" || $NetKazanc == "" || $Hash == "")
		{
			return [
                'status'         => "ERROR",
                'status_msg' => "eksik_veri",
                'return_msg'     => "ERROR_DATA",
            ];
		}

		$apiKey = $this->config["settings"]["api_key"];
		$secretKey = $this->config["settings"]["api_secret_key"];

		$hashKontrol = base64_encode(hash_hmac('sha256',"$SiparisID|$ExtraData|$UserID|$ReturnData|$Status|$OdemeKanali|$OdemeTutari|$NetKazanc".$apiKey,$secretKey,true));
		if($Hash != $hashKontrol){
			return [
                'status'         => "ERROR",
                'status_msg' => "hash hatali",
                'return_msg'     => "ERROR_HASH",
            ];
		}

        $checkout_id = $ExtraData;
        $checkout = Basket::get_checkout($checkout_id);

        if (!$checkout){
			return [
                'status'         => "ERROR",
                'status_msg' => Bootstrap::$lang->get("errors/error6",Config::get("general/local")),
                'return_msg'     => "OK",
            ];
		}

        $this->set_checkout($checkout);

        Basket::set_checkout($checkout["id"], ['status' => "paid"]);
		
		return [
                'status'         => "SUCCESS",
                'checkout'       => $checkout,
                'return_msg'     => "OK2",
            ];
    }

}

