<?php

    class PayPalClient
    {
        private $client_id,$secret_key,$sandbox,$access_token='',$auth = [];
        public $error,$status_code = 0,$header;

        public function __construct($client_id='',$secret_key='',$sandbox=false)
        {
            $this->client_id            = $client_id;
            $this->secret_key           = $secret_key;
            $this->sandbox              = $sandbox;
            if(file_exists(__DIR__.DS."auth.php"))
                $this->auth                 = include __DIR__.DS."auth.php";
        }

        public function call($endpoint='',$data = [],$method='GET',$dontLog=false)
        {

            if($endpoint != 'oauth2/token')
            {
                if($this->auth)
                {
                    $expires    = $this->auth["created_at"] + $this->auth["expires_in"];
                    $now        = DateManager::strtotime();
                    if($now < $expires) $this->access_token = $this->auth["access_token"];
                }

                if(!$this->access_token)
                {
                    $request = $this->call('oauth2/token',false,'POST');
                    if(!$request) return false;
                    $this->auth = $request;
                    $this->auth["created_at"] = DateManager::strtotime();
                    $this->access_token = $this->auth["access_token"];
                    FileManager::file_write(__DIR__.DS."auth.php",Utility::array_export($this->auth,['pwith' => true]));
                }
            }

            if(!function_exists("PayPalClient_header_read"))
            {
                function PayPalClient_header_read($ch, $header)
                {
                    $GLOBALS["header"] = $header;

                    return strlen($header);
                }
            }

            if($this->sandbox)
                $url = "https://api-m.sandbox.paypal.com/v1/";
            else
                $url = "https://api.paypal.com/v1/";

            $curl       = curl_init();

            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl,CURLOPT_TIMEOUT,30);


            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);

            // Header
            $header = [
                'Content-Type: application/json'
            ];

            if($endpoint == 'oauth2/token')
            {
                curl_setopt($curl, CURLOPT_POSTFIELDS,'grant_type=client_credentials');
                curl_setopt($curl, CURLOPT_USERPWD ,$this->client_id.":".$this->secret_key);
                curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            }
            else
            {
                curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                $header[] = 'Authorization: Bearer '.$this->access_token;
            }

            if($data && $method != "GET")
            {
                $data           = Utility::jencode($data);
                curl_setopt($curl, CURLOPT_POSTFIELDS,$data);
            }


            // OPTIONS:
            curl_setopt($curl, CURLOPT_URL, $url.$endpoint.($method == "GET" && $data ? "?".http_build_query($data) : ''));
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_HEADERFUNCTION, 'PayPalClient_header_read');



            // EXECUTE:

            $result_x           = curl_exec($curl);
            $result             = $result_x;
            $error              = curl_errno($curl) ? curl_error($curl) : '';
            $this->status_code  = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);

            /// Parse Result
            if($dc = Utility::jdecode($result,true)) $result = $dc;

            $this->header       = $GLOBALS["header"];
            if($error)
            {
                $this->error = 'Unable to connect to the address:' .$error;
                $result      = false;
            }

            if(isset($result["error"]) && isset($result["error_description"]) && $result["error"])
            {
                $this->error = $result["error_description"];
                return false;
            }

            if(isset($result["name"]) && isset($result["message"]) && $result["name"] && $result["message"])
            {
                $this->error = $result["message"];
                $result = false;
            }


            if(!$dontLog) Modules::save_log("Payment","PayPal",$method." / ".$url.$endpoint,$data,$result_x,$this->error ? $this->error : $result);

            return $result;
        }
        public function call_all($endpoint='',$data = [],$method='GET',$dontLog=false,$next_page=1)
        {
            if(!is_array($data) && !$data) $data = [];
            $response           = [];
            while($next_page > 0)
            {
                $endpoint_x         = $endpoint;

                if(strpos($endpoint,'?') !== false)
                    $endpoint_x .= '&';
                else
                    $endpoint_x .= '?';

                $request            = $this->call($endpoint_x."page_size=20&page=".$next_page,$data,$method,$dontLog);
                if(!$request) return false;
                if(isset($request["links"]) && $request["links"])
                {
                    foreach($request["links"] AS $l)
                    {
                        $next_page_x      = (int) substr($l["href"],strpos($l["href"],'page=')+5);
                        if($next_page_x == $next_page) $next_page = 0;
                        else $next_page = $next_page_x;
                    }
                }
                $response       = array_merge_recursive($response,$request);
            }
            return $response;
        }


    }