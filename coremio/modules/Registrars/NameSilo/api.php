<?php
    class NameSilo_Api {
        private $api_key        = NULL;
        private $test_mode      = NULL;
        private $curl           = false;
        public  $error          = NULL;
        private $_type          = "GET";
        private $topLink        = NULL;
        public $_query          = NULL;
        private $_params        = [];
        private $rType          = "xml";
        private $temp           = [];

        function __construct($api_key=NULL,$api_key_sandbox=NULL,$test_mode=false){
            if(($api_key == NULL && !$test_mode) || ($api_key_sandbox == NULL && $test_mode)){
                $this->error = "It is necessary to enter API information.";
            }
            $this->api_key      = $test_mode ? $api_key_sandbox : $api_key;
            $this->test_mode    = $test_mode;
            $this->topLink      = $test_mode ? "http://sandbox.namesilo.com/" : "http://www.namesilo.com/";
            $this->curl         = curl_init();
            curl_setopt($this->curl, CURLOPT_USERAGENT,'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)');
            curl_setopt($this->curl, CURLOPT_ENCODING, "gzip");
            curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($this->curl, CURLOPT_TIMEOUT,20);
            curl_setopt($this->curl, CURLOPT_HEADER, 0);
            @curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($this->curl,CURLOPT_HTTPHEADER,array("Content-Type: text/xml; charset=UTF-8"));

        }

        private function get($operation='',$rType="xml"){
            $this->_reset();
            $this->_type    = "GET";
            $this->rType    = $rType;
            $this->_query   = $this->topLink."api/".$operation;
            curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST,$this->_type);
            curl_setopt($this->curl, CURLOPT_POST,false);
            curl_setopt($this->curl, CURLOPT_POSTFIELDS,NULL);
            $this->addParam("version",1);
            $this->addParam("type",$this->rType);
            $this->addParam("key",$this->api_key);
            return $this;
        }

        private function addParam($key,$value){
            $this->_params[] = $key."=".urlencode($value);
            return $this;
        }

        private function build($nodecode=false){
            if(!$this->api_key){
                $this->error = "It is necessary to enter API information.";
                return false;
            }

            $query  = $this->_query;
            $fields = implode("&",$this->_params);
            if($this->_type == "GET")
                $query  .= "?".$fields;
            elseif($this->_type == "POST")
                curl_setopt($this->curl, CURLOPT_POSTFIELDS,$fields);
            curl_setopt($this->curl, CURLOPT_URL, $query);
            $result_x   = curl_exec($this->curl);
            $result     = $result_x;
            if(!$result || curl_errno($this->curl)){
                $curl_error = curl_error($this->curl);
                $this->error = "Curl Error: ".$curl_error;
                $result = false;
            }

            if($result && !$nodecode && !is_numeric($result)){
                if($this->rType == "json")
                    $result = Utility::jdecode($result,true);
                elseif($this->rType == "xml")
                    $result = Utility::xdecode($result,true);
                if(!$result){
                    $this->error = "The answer could not be solved.";
                    $result = false;
                }
            }

            Modules::save_log("Registrars","NameSilo",$this->_type."/ ".$this->_query,$this->_params,$result_x,$this->error ? $this->error : $result);

            return $result;
        }

        public function checkRegisterAvailability($params=[]){
            $sth = $this->get("checkRegisterAvailability");
            foreach($params AS $key=>$value) $this->addParam($key,$value);
            return $sth->build();
        }

        public function registerDomain($params=[]){
            $sth = $this->get("registerDomain");
            foreach($params AS $key=>$value) $this->addParam($key,$value);
            return $sth->build();
        }

        public function renewDomain($params=[]){
            $sth = $this->get("renewDomain");
            foreach($params AS $key=>$value) $this->addParam($key,$value);
            return $sth->build();
        }

        public function transferDomain($params=[]){
            $sth = $this->get("transferDomain");
            foreach($params AS $key=>$value) $this->addParam($key,$value);
            return $sth->build();
        }

        public function getDomainInfo($domain){
            if(isset($this->temp["getDomainInfo"][$domain])) $this->temp["getDomainInfo"][$domain];
            $data = $this->get("getDomainInfo")->addParam("domain",$domain)->build();
            if($data && $data["reply"]["code"] == 300) $this->temp["getDomainInfo"][$domain] = $data;
            return $data;
        }

        public function contactAdd($data=[]){
            $sth = $this->get("contactAdd");
            foreach($data AS $key=>$val) $sth->addParam($key,$val);
            return $sth->build();
        }

        public function contactUpdate($data=[]){
            $sth = $this->get("contactUpdate");
            foreach($data AS $key=>$val) $sth->addParam($key,$val);
            return $sth->build();
        }

        public function changeNameServers($data=[]){
            $sth = $this->get("changeNameServers");
            foreach($data AS $key=>$val) $sth->addParam($key,$val);
            return $sth->build();
        }

        public function listRegisteredNameServers($domain=''){
            if(isset($this->temp["listRegisteredNameServers"][$domain])) $this->temp["listRegisteredNameServers"][$domain];
            $data = $this->get("listRegisteredNameServers")->addParam("domain",$domain)->build();
            if($data && $data["reply"]["code"] == 300) $this->temp["listRegisteredNameServers"][$domain] = $data;
            return $data;
        }

        public function addRegisteredNameServer($data){
            $sth = $this->get("addRegisteredNameServer");
            foreach($data AS $key=>$val) $sth->addParam($key,$val);
            return $sth->build();
        }

        public function modifyRegisteredNameServer($data){
            $sth = $this->get("modifyRegisteredNameServer");
            foreach($data AS $key=>$val) $sth->addParam($key,$val);
            return $sth->build();
        }

        public function deleteRegisteredNameServer($data){
            $sth = $this->get("deleteRegisteredNameServer");
            foreach($data AS $key=>$val) $sth->addParam($key,$val);
            return $sth->build();
        }

        public function domainLock($domain=''){
            $sth = $this->get("domainLock");
            $sth->addParam("domain",$domain);
            return $sth->build();
        }

        public function domainUnlock($domain=''){
            $sth = $this->get("domainUnlock");
            $sth->addParam("domain",$domain);
            return $sth->build();
        }

        public function addPrivacy($domain=''){
            $sth = $this->get("addPrivacy");
            $sth->addParam("domain",$domain);
            return $sth->build();
        }

        public function removePrivacy($domain=''){
            $sth = $this->get("removePrivacy");
            $sth->addParam("domain",$domain);
            return $sth->build();
        }

        public function retrieveAuthCode($domain=''){
            $sth = $this->get("retrieveAuthCode");
            $sth->addParam("domain",$domain);
            return $sth->build();
        }

        public function contactList($id=0){
            $sth = $this->get("contactList");
            $sth->addParam("contact_id",$id);
            return $sth->build();
        }

        public function listDomains(){
            return $this->get("listDomains")->build();
        }

        public function getPrices($data=[]){
            $sth = $this->get("getPrices");
            foreach($data AS $key=>$val) $sth->addParam($key,$val);
            return $sth->build();
        }

        private function _reset(){
            $this->error          = NULL;
            $this->_type          = NULL;
            $this->_query         = NULL;
            $this->_params        = [];
            $this->rType          = "xml";
        }

        function __destruct(){
            if($this->curl) curl_close($this->curl);
        }
    }