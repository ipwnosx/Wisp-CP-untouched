<?php
    class SonicPanelAPI
    {
        private $server;
        public $error;
        public $status_code = 0;

        public function __construct($server = [])
        {
            $this->server = $server;
        }

        public function getHostname($add_port=true)
        {
            $url    = $this->server["secure"] ? "https://" : "http://";
            $url    .= $this->server["ip"];
            if($add_port) $url .= ":".$this->server["port"];
            return $url;
        }

        public function call($cmd = '',$data = [],$dontLog=false)
        {
           $url         = $this->getHostname().'/api/sonic_api.php';
            $params = [
                'cmd'       => $cmd,
                'owner'     => $this->server["username"],
                'key'       => $this->server["access_hash"],

            ];
            if($data) $params     = array_merge($params,$data);

            $ch             = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($params));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_URL, $url);

            $retval             = curl_exec($ch);
            $this->status_code  = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            if (curl_errno($ch))
            {
                $this->error    = 'Unable to connect to the server:' . $this->server["ip"] . ' - ' . curl_errno($ch) . ' - ' . curl_error($ch);
                if(!$dontLog) Modules::save_log("Servers","SonicPanel",$url." - ".$cmd,$params,$this->error);
                curl_close($ch);
                return false;
            }
            elseif($this->status_code == 401)
            {
                $this->error = "SonicPanel Server Invalid API Key! Check your username and API Key(Password) in your billing software server settings for this active server ".$this->server["ip"].". Multiple login failures in 1 hour will get your website IP banned for 1 hour.";
                if(!$dontLog) Modules::save_log("Servers","SonicPanel",$url." - ".$cmd,$params,$this->error);
                curl_close($ch);
                return false;
            }
            elseif($this->status_code == 500)
            {
                $this->error = "Multiple API Login Failures Detected: Your website IP is blocked for 1 hour to login. Read the limits and security in SonicPanel under the Billing and API page";
                if(!$dontLog) Modules::save_log("Servers","SonicPanel",$url." - ".$cmd,$params,$this->error);
                curl_close($ch);
                return false;
            }
            curl_close($ch);
            if($decode = Utility::jdecode($retval,true)) $retval = $decode;

            if(!$dontLog) Modules::save_log("Servers","SonicPanel",$url." - ".$cmd,$params,$retval);

            return $retval;
        }


    }