<?php
    class Pterodactyl_API
    {
        public $server = [];
        public $error;
        public $status_code;
        public $client_secret_key = '';

        function __construct($server = [])
        {
            $this->server = $server;
        }
        public function GetHostname()
        {
            if(Validation::NSCheck($this->server["name"]))
                $hostname = $this->server["name"];
            else
                $hostname = $this->server["ip"];

            $hostname = ($this->server['secure'] ? 'https://' : 'http://') . $hostname;
            return rtrim($hostname, '/');
        }
        public function call($endpoint, array $data = [], $method = "GET", $dontLog = false,$client = '')
        {
            if(!$data) $data = [];
            if(!$method) $method = 'GET';

            $url = $this->GetHostname() . '/api/'.($client != '' ? 'client' : 'application').'/' . $endpoint;

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($curl, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
            curl_setopt($curl, CURLOPT_USERAGENT, "Pterodactyl-WISECP");
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($curl, CURLOPT_TIMEOUT, 5);

            $headers = [
                "Authorization: Bearer " . ($client != '' ? $client : $this->server['password']),
                "Accept: Application/vnd.pterodactyl.v1+json",
            ];

            if($method === 'POST' || $method === 'PATCH')
            {
                $jsonData = json_encode($data);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
                array_push($headers, "Content-Type: application/json");
                array_push($headers, "Content-Length: " . strlen($jsonData));
            }

            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($curl);
            $responseData = $response ? json_decode($response, true) : [];
            $responseData['status_code'] = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            $error          = '';
            $status_code    = $responseData['status_code'];
            $this->status_code = $status_code;

            if($status_code=== 0 && !$dontLog)
            {
                $error = curl_error($curl);
                Modules::save_log("Servers","Pterodactyl",$method." / ".$url,"cURL - ".$data,$error);
            }

            curl_close($curl);

            if(!$dontLog) Modules::save_log("Servers","Pterodactyl", $method . " / " . $url,$data,$responseData);

            if(in_array($status_code,[400,401,403,404,422,500]))
            {
                $code       = isset($responseData["code"]) ? $responseData["code"] : '';
                $detail     = isset($responseData["detail"]) ? $responseData["detail"] : '';

                if(isset($responseData["errors"]) && $responseData["errors"])
                {
                    foreach($responseData["errors"] AS $v)
                    {
                        $code           = $v["code"];
                        $detail         = $v["detail"];
                    }
                }

                $error      = 'Code:'.$code;
                if($detail) $error .=  ' - '.$detail;
            }

            if($error)
            {
                $this->error = $error;
                return false;
            }

            return $responseData;
        }
        public function client_call($endpoint, array $data = [], $method = "GET", $dontLog = false)
        {
            return $this->call($endpoint,$data,$method,$dontLog,$this->client_secret_key);
        }

        public function GetServerID($id,$raw = false)
        {
            $serverResult = $this->call('servers/external/' . $id, [], 'GET',true);
            if(!$serverResult && $this->error) return false;

            if($raw) return $serverResult;
            else return $serverResult['attributes']['id'];
        }
        public function GetServerDetail($id = 0)
        {
            $serverResult = $this->call('servers/' . $id, [], 'GET',true);
            if(!$serverResult && $this->error) return false;
            return $serverResult;
        }

        public function GenerateUsername($length = 8) {
            return Utility::generate_hash($length,false,'lud');
        }
    }