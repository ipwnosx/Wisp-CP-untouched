<?php
    class HetznerCloud_API
    {
        private $server;
        public $error;
        public $status_code = 0;
        public $header;

        public function __construct($server = [])
        {
            $this->server = $server;
        }

        public function getHostname()
        {
            return "https://api.hetzner.cloud/v1/";
        }

        public function call($endpoint='',$data = [],$method='GET',$dontLog=false)
        {

            if(!function_exists("HetznerCloud_header_read"))
            {
                function HetznerCloud_header_read($ch, $header)
                {
                    $GLOBALS["header"] = $header;

                    return strlen($header);
                }
            }

            $url        = $this->getHostname();
            $curl       = curl_init();

            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl,CURLOPT_TIMEOUT,30);


            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);

            if($data && $method != "GET")
            {
                $data           = Utility::jencode($data);
                curl_setopt($curl, CURLOPT_POSTFIELDS,$data);
            }


            // OPTIONS:
            curl_setopt($curl, CURLOPT_URL, $url.$endpoint.($method == "GET" && $data ? "?".http_build_query($data) : ''));
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer '.$this->server["access_hash"],
                'Content-Type: application/json',
            ));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($curl, CURLOPT_HEADERFUNCTION, 'HetznerCloud_header_read');



            // EXECUTE:

            $result             = curl_exec($curl);
            $error              = curl_errno($curl) ? curl_error($curl) : '';
            $this->status_code  = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);

            /// Parse Result
            if($dc = Utility::jdecode($result,true)) $result = $dc;

            $this->header       = $GLOBALS["header"];
            if($error) $this->error = 'Unable to connect to the server:' .$error;

            if(isset($result["error"]["message"]) && $result["error"]["message"])
            {
                $this->error = $result["error"]["code"].": ".$result["error"]["message"];
            }


            if($this->error)
            {
                if(!$dontLog) Modules::save_log("Servers","HetznerCloud",$method." / ".$url.$endpoint,$data,$result ? $result : $this->error,$result ? $this->error : '');
                return false;
            }

            if(!$dontLog) Modules::save_log("Servers","HetznerCloud",$method." / ".$url.$endpoint,$data,$result);

            return $result;
        }
        public function call_all($endpoint='',$data = [],$method='GET',$dontLog=false)
        {
            if(!is_array($data) && !$data) $data = [];
            $next_page          = 1;
            $response           = [];
            while($next_page > 0)
            {
                $data["page"]       = $next_page;
                $data["per_page"]   = 50;

                $request            = $this->call($endpoint,$data,$method,$dontLog);
                if(!$request)
                {
                    return false;
                    break;
                }
                $next_page      = (int) $request["meta"]["pagination"]["next_page"];
                $response       = array_merge_recursive($response,$request);
            }
            return $response;
        }


    }