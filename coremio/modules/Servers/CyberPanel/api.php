<?php
    class CyberApi
    {
        private $server;
        public $error;

        public function __construct($server)
        {
            $this->server = $server;
        }

        private function callUrl($url)
        {
            return (($this->server["secure"]) ? "https" : "http"). "://".$this->server["ip"].":".$this->server["port"]."/api/".$url;
        }


        private function call_cyberpanel($url,$post = array())
        {
            $url_x = $this->callUrl($url);
            $call = curl_init();
            curl_setopt($call, CURLOPT_URL, $url_x);
            curl_setopt($call, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($call, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($call, CURLOPT_POST, true);
            curl_setopt($call, CURLOPT_POSTFIELDS, json_encode($post));
            curl_setopt($call, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($call, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($call,CURLOPT_TIMEOUT,120);

            // Fire api
            $result_x   = curl_exec($call);
            $result     = $result_x;

            if(curl_errno($call)){
                $this->error = curl_error($call);
                $result = false;
            }

            if(!$result && !$this->error){
                $this->error = "Connection Failed";
            }

            curl_close($call);

            if($result)
            {
                $result = json_decode($result,true);
                if(!$result) $this->error = 'Unable to parse the response returned from the API.';

                if(isset($result["error_message"]) && $result["error_message"]){
                    if($result["error_message"] != "None"){
                        $this->error = $result["error_message"];
                        $result = false;
                    }
                }
            }

            Modules::save_log('Servers','CyberPanel',($post ? 'POST/ ' : 'GET/ ').$url_x,$post,$result_x,$this->error ? $this->error : $result);

            // Return data
            return $result;
        }

        public function create_new_account($domainName, $ownerEmail, $packageName, $websiteOwner, $ownerPassword,$websitesLimit = 1,$acl = 'user')
        {
            $url = "createWebsite";
            $postParams =
                [
                    "adminUser" => $this->server["username"],
                    "adminPass" => $this->server["password"],
                    "domainName" => $domainName,
                    "ownerEmail" => $ownerEmail,
                    "packageName" => $packageName,
                    "websiteOwner" => $websiteOwner,
                    "ownerPassword" => $ownerPassword,
                    "websitesLimit" => $websitesLimit,
                    "acl"           => $acl,
                ];
            $result = $this->call_cyberpanel($url, $postParams);
            return $result;
        }

        // Suspend Account
        public function change_account_status($domainName, $status)
        {
            $url = "submitWebsiteStatus";
            $postParams =
                [
                    "adminUser" => $this->server["username"],
                    "adminPass" => $this->server["password"],
                    "websiteName" => $domainName,
                    "state" => $status,
                ];
            $result = $this->call_cyberpanel($url, $postParams);
            return $result;
        }

        // Test connection
        public function verify_connection()
        {
            $url = "verifyConn";
            $postParams =
                [
                    "adminUser" => $this->server["username"],
                    "adminPass" => $this->server["password"],
                ];
            $result = $this->call_cyberpanel($url, $postParams);
            return $result;
        }
        public function terminate_account($domainName)
        {
            $url = "deleteWebsite";
            $postParams =
                [
                    "adminUser" => $this->server["username"],
                    "adminPass" => $this->server["password"],
                    "domainName"=> $domainName
                ];
            $result = $this->call_cyberpanel($url, $postParams);
            return $result;
        }
        public function change_account_password($websiteOwner, $ownerPassword)
        {
            $url = "changeUserPassAPI";
            $postParams =
                [
                    "adminUser" => $this->server["username"],
                    "adminPass" => $this->server["password"],
                    "websiteOwner"=> $websiteOwner,
                    "ownerPassword"=> $ownerPassword
                ];
            $result = $this->call_cyberpanel($url, $postParams);
            return $result;
        }
        public function change_account_package($domainName, $packageName)
        {
            $url = "changePackageAPI";
            $postParams =
                [
                    "adminUser" => $this->server["username"],
                    "adminPass" => $this->server["password"],
                    "websiteName"=> $domainName,
                    "packageName"=> $packageName
                ];
            $result = $this->call_cyberpanel($url, $postParams);
            return $result;
        }
        public function getUserInfo($userName)
        {
            $url = "getUserInfo";
            $postParams =
                [
                    "adminUser" => $this->server["username"],
                    "adminPass" => $this->server["password"],
                    "username"  => $userName,
                ];
            $result = $this->call_cyberpanel($url, $postParams);
            return $result;
        }
    }