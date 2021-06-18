<?php
    class NamecheapSSL_Api {
        private $username       = NULL;
        private $api_key        = NULL;
        private $test_mode      = NULL;
        private $curl           = false;
        public  $error          = NULL;
        private $_type          = "GET";
        private $topLink        = NULL;
        public $_query          = NULL;
        public $_params        = [];
        private $temp           = [];

        function __construct($username=NULL,$api_key=NULL,$username_sandbox=NULL,$api_key_sandbox=NULL,$test_mode=false){
            if((($username == '' || $api_key == '') && !$test_mode) || (($username_sandbox == '' || $api_key_sandbox == '') && $test_mode)){
                $this->error = "It is necessary to enter API information.";
            }
            $this->username     = $test_mode ? $username_sandbox : $username;
            $this->api_key      = $test_mode ? $api_key_sandbox : $api_key;
            $this->test_mode    = $test_mode;
            $this->topLink      = $test_mode ? "https://api.sandbox.namecheap.com/xml.response" : "https://api.namecheap.com/xml.response";
            $this->curl         = curl_init();
            curl_setopt($this->curl, CURLOPT_USERAGENT,'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)');
            curl_setopt($this->curl, CURLOPT_ENCODING, "gzip");
            curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($this->curl, CURLOPT_TIMEOUT,300);
            curl_setopt($this->curl, CURLOPT_HEADER, 0);
            curl_setopt($this->curl,CURLOPT_HTTPHEADER,array("Content-Type: text/xml; charset=UTF-8"));
        }

        private function get($command=''){
            $client_ip  = UserManager::GetIP();
            if($client_ip == "UNKNOWN" || !$client_ip) $client_ip = $_SERVER["SERVER_ADDR"];

            $this->_reset();
            $this->_type    = "GET";
            $this->_query   = $this->topLink;
            curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST,$this->_type);
            curl_setopt($this->curl, CURLOPT_POST,false);
            curl_setopt($this->curl, CURLOPT_POSTFIELDS,NULL);
            $this->addParam("ApiUser",$this->username);
            $this->addParam("UserName",$this->username);
            $this->addParam("ApiKey",$this->api_key);
            $this->addParam("ClientIp",$client_ip);
            $this->addParam("Command",$command);
            return $this;
        }

        private function addParam($key,$value){
            $this->_params[] = $key."=".urlencode($value);
            return $this;
        }

        private function build($nodecode=false){
            if(!$this->username || !$this->api_key){
                $this->error = "It is necessary to enter API information.";
                return false;
            }


            $fields = implode("&",$this->_params);
            if($this->_type == "GET")
                $this->_query = $this->_query."?".$fields;
            elseif($this->_type == "POST")
                curl_setopt($this->curl, CURLOPT_POSTFIELDS,$fields);
            curl_setopt($this->curl, CURLOPT_URL, $this->_query);
            $result = curl_exec($this->curl);
            if(!$result || curl_errno($this->curl)){
                $curl_error = curl_error($this->curl);
                $this->error = "Curl Error: ".$curl_error;
                if(LOG_SAVE) LogManager::core_error_log(500,$this->error." | ".$this->_query,__FILE__,__LINE__);
                return false;
            }

            if(!$nodecode && !is_numeric($result)){
                $result = Utility::xdecode($result,true);

                if(!$result){
                    $this->error = "The answer could not be solved.";
                    if(LOG_SAVE) LogManager::core_error_log(500,$this->error." | ".$this->_query." | ".$this->_params,__FILE__,__LINE__);
                    return false;
                }

                if(isset($result["@attributes"]["Status"]) && $result["@attributes"]["Status"] == "ERROR"){
                    $this->error = implode(", ",$result["Errors"]);
                    return false;
                }elseif(isset($result["Warnings"]) && $result["Warnings"]){
                    $this->error = implode(", ",$result["Warnings"]);
                    return false;
                }

                if(isset($result["CommandResponse"])) $result = $result["CommandResponse"];

            }
            return $result;
        }

        public function ssl_getInfo($order_id=0){
            return $this->get("namecheap.ssl.getInfo")
                ->addParam("CertificateID",$order_id)
                ->addParam("Returncertificate","true")->build();
        }
        public function ssl_create($params=[]){
            $sth = $this->get("namecheap.ssl.create");
            foreach($params AS $key=>$value) $this->addParam($key,$value);
            return $sth->build();
        }
        public function ssl_activate($params=[]){
            $sth = $this->get("namecheap.ssl.activate");
            foreach($params AS $key=>$value) $this->addParam($key,$value);
            return $sth->build();
        }
        public function ssl_renew($params=[]){
            $sth = $this->get("namecheap.ssl.renew");
            foreach($params AS $key=>$value) $this->addParam($key,$value);
            return $sth->build();
        }
        public function ssl_editdcvmethod($params=[]){
            $sth = $this->get("namecheap.ssl.editdcvmethod");
            foreach($params AS $key=>$value) $this->addParam($key,$value);
            return $sth->build();
        }
        public function ssl_revokecertificate($order_id=0,$product=''){
            return $this->get("namecheap.ssl.revokecertificate")
                ->addParam("CertificateID",$order_id)
                ->addParam("CertificateType",$product)
                ->build();
        }
        public function ssl_resendApproverEmail($order_id=0){
            return $this->get("namecheap.ssl.resendApproverEmail")->addParam("CertificateID",$order_id)->build();
        }
        public function ssl_reissue($params=[]){
            $sth = $this->get("namecheap.ssl.reissue");
            foreach($params AS $key=>$value) $this->addParam($key,$value);
            return $sth->build();
        }
        public function ssl_getList($page=1,$pageSize=100){
            $data = $this->get("namecheap.ssl.getList");
            $data->addParam("Page",$page);
            $data->addParam("PageSize",$pageSize);
            $data->addParam("SortBy","CREATEDATE_DESC");
            return $data->build();
        }


        private function _reset(){
            $this->error          = NULL;
            $this->_type          = NULL;
            $this->_query         = NULL;
            $this->_params        = [];
        }

        function __destruct(){
            if($this->curl) curl_close($this->curl);
        }
    }