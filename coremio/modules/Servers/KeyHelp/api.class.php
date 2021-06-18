<?php
    class KeyHelp_API
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
            $url    = $this->server["secure"] ? "https://" : "http://";
            $url    .= $this->server["ip"];
            return $url;
        }

        public function call($endpoint='',$data = [],$method='GET',$dontLog=false)
        {

            if(!function_exists("KeyHelp_header_read"))
            {
                function KeyHelp_header_read($ch, $header)
                {
                    $GLOBALS["header"] = $header;

                    return strlen($header);
                }
            }

            $url        = $this->getHostname()."/api/v1/";
            $curl       = curl_init();

            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl,CURLOPT_TIMEOUT,30);


            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);

            if($method != "GET" && $data)
            {
                $data           = Utility::jencode($data);
                curl_setopt($curl, CURLOPT_POSTFIELDS,$data);
            }


            // OPTIONS:
            curl_setopt($curl, CURLOPT_URL, $url.$endpoint.($method == "GET" ? "?".http_build_query($data) : ''));
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'X-API-Key: '.$this->server["access_hash"],
                'Content-Type: application/json',
            ));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($curl, CURLOPT_HEADERFUNCTION, 'KeyHelp_header_read');



            // EXECUTE:

            $result             = curl_exec($curl);
            $error              = curl_errno($curl) ? curl_error($curl) : '';
            $this->status_code  = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);

            /// Parse Result
            if($dc = Utility::jdecode($result,true)) $result = $dc;

            $this->header       = $GLOBALS["header"];
            if($error) $this->error = 'Unable to connect to the server:' . $this->server["ip"] . ' - ' . $error;

            if(!$this->error)
            {
                if($this->status_code == 302)
                    $this->error = '302 - Found: If there is, try connecting with hostname and SSL connection.';
                elseif($this->status_code == 400)
                    $this->error = '400 - Bad Request: The request was unacceptable, due to an malformed request, invalid parameter value or a missing required parameter.';
                elseif($this->status_code == 401)
                    $this->error = '401 - Unauthorized: Invalid API key provided';
                elseif($this->status_code == 403)
                    $this->error = '403 - Forbidden: API access is denied.';
                elseif($this->status_code == 403)
                    $this->error = '403 - Forbidden: API access is denied.';
                elseif($this->status_code == 404)
                    $this->error = '404 - Not Found: The resource was not found / The requested endpoint was not found.';
                elseif($this->status_code == 405)
                    $this->error = '405 - Method Not Allowed: The HTTP method for the requested endpoint is not allowed.';
                elseif($this->status_code == 406)
                    $this->error = '406 - Not Acceptable: Invalid Accept header value. Mime type not supported';
                elseif($this->status_code >= 500)
                    $this->error = $this->status_code.' - Server error: Something went wrong on KeyHelp\'s end.';
            }

            if(isset($result["code"]) && isset($result["message"]) && $result["message"])
                $this->error = $result["code"].": ".$result["message"];

            if($this->error)
            {
                if(!$dontLog) Modules::save_log("Servers","KeyHelp",$method." / ".$url.$endpoint,$data,$result ? $result : $this->error,$result ? $this->error : '');
                return false;
            }

            if(!$dontLog) Modules::save_log("Servers","KeyHelp",$method." / ".$url.$endpoint,$data,$result);

            return $result;
        }


    }