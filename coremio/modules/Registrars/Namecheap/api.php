<?php
    class Namecheap_Api {
        private $username       = NULL;
        private $api_key        = NULL;
        private $test_mode      = NULL;
        private $curl           = false;
        public  $error          = NULL;
        private $_type          = "GET";
        private $topLink        = NULL;
        public $_query          = NULL;
        private $_params        = [];
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

            $query  = $this->_query;
            $fields = implode("&",$this->_params);
            if($this->_type == "GET")
                $this->_query = $this->_query."?".$fields;
            elseif($this->_type == "POST")
                curl_setopt($this->curl, CURLOPT_POSTFIELDS,$fields);
            curl_setopt($this->curl, CURLOPT_URL, $this->_query);
            $result_x   = curl_exec($this->curl);
            $result     = $result_x;
            if(!$result || curl_errno($this->curl)){
                $curl_error = curl_error($this->curl);
                $this->error = "Curl Error: ".$curl_error;
                Modules::save_log('Registrars','Namecheap',$query,print_r($this->_params,true),htmlentities($result_x),$this->error);
                return false;
            }

            if(!$nodecode && !is_numeric($result)){
                $result = Utility::xdecode($result,true);

                if(!$result){
                    $this->error = "The answer could not be solved.";
                    Modules::save_log('Registrars','Namecheap',$query,print_r($this->_params,true),htmlentities($result_x),$this->error);
                    return false;
                }

                if(isset($result["@attributes"]["Status"]) && $result["@attributes"]["Status"] == "ERROR"){
                    $this->error = implode(", ",$result["Errors"]);
                    Modules::save_log('Registrars','Namecheap',$query,print_r($this->_params,true),htmlentities($result_x),$this->error);
                    return false;
                }elseif(isset($result["Warnings"]) && $result["Warnings"]){
                    $this->error = implode(", ",$result["Warnings"]);
                    Modules::save_log('Registrars','Namecheap',$query,print_r($this->_params,true),htmlentities($result_x),$this->error);
                    return false;
                }

                if(isset($result["CommandResponse"])) $result = $result["CommandResponse"];

            }

            Modules::save_log('Registrars','Namecheap',$query,print_r($this->_params,true),htmlentities($result_x),$result);

            return $result;
        }

        public function domains_check($params=[]){
            $sth = $this->get("namecheap.domains.check");
            foreach($params AS $key=>$value) $this->addParam($key,$value);
            return $sth->build();
        }

        public function domains_create($params=[]){
            $sth = $this->get("namecheap.domains.create");
            foreach($params AS $key=>$value) $this->addParam($key,$value);
            return $sth->build();
        }

        public function domains_transfer_create($params=[]){
            $sth = $this->get("namecheap.domains.transfer.create");
            foreach($params AS $key=>$value) $this->addParam($key,$value);
            return $sth->build();
        }

        public function domains_renew($params=[]){
            $sth = $this->get("namecheap.domains.renew");
            foreach($params AS $key=>$value) $this->addParam($key,$value);
            return $sth->build();
        }

        public function transferDomain($params=[]){
            $sth = $this->get("transferDomain");
            foreach($params AS $key=>$value) $this->addParam($key,$value);
            return $sth->build();
        }

        public function domains_getInfo($domain){
            if(isset($this->temp["domains_getInfo"][$domain])) $this->temp["domains_getInfo"][$domain];
            $data = $this->get("namecheap.domains.getInfo")->addParam("DomainName",$domain)->build();
            if($data) $this->temp["domains_getInfo"][$domain] = $data;
            return $data;
        }

        public function domains_getRegistrarLock($domain=''){
            $sth = $this->get("namecheap.domains.getRegistrarLock");
            $sth->addParam("DomainName",$domain);
            return $sth->build();
        }

        public function domains_getContacts($domain=''){
            $sth = $this->get("namecheap.domains.getContacts");
            $sth->addParam("DomainName",$domain);
            return $sth->build();
        }

        public function domains_setContacts($data=[]){
            $sth = $this->get("namecheap.domains.setContacts");
            foreach($data AS $key=>$val) $sth->addParam($key,$val);
            return $sth->build();
        }

        public function domains_dns_getList($sld='',$tld=''){
            $sth = $this->get("namecheap.domains.dns.getList");
            $sth->addParam("SLD",$sld);
            $sth->addParam("TLD",$tld);
            return $sth->build();
        }

        public function domains_dns_setCustom($data=[]){
            $sth = $this->get("namecheap.domains.dns.setCustom");
            foreach($data AS $key=>$val) $sth->addParam($key,$val);
            return $sth->build();
        }

        public function domains_dns_getHosts($sld='',$tld=''){
            return $this->get("namecheap.domains.dns.getHosts")->addParam("SLD",$sld)->addParam("TLD",$tld)->build();
        }

        public function domains_ns_create($data){
            $sth = $this->get("namecheap.domains.ns.create");
            foreach($data AS $key=>$val) $sth->addParam($key,$val);
            return $sth->build();
        }
        public function domains_ns_getInfo($data){
            $sth = $this->get("namecheap.domains.ns.getInfo");
            foreach($data AS $key=>$val) $sth->addParam($key,$val);
            return $sth->build();
        }

        public function domains_ns_update($data){
            $sth = $this->get("namecheap.domains.ns.update");
            foreach($data AS $key=>$val) $sth->addParam($key,$val);
            return $sth->build();
        }

        public function domains_ns_delete($data){
            $sth = $this->get("namecheap.domains.ns.delete");
            foreach($data AS $key=>$val) $sth->addParam($key,$val);
            return $sth->build();
        }

        public function domains_setRegistrarLock($data){
            $sth = $this->get("namecheap.domains.setRegistrarLock");
            foreach($data AS $key=>$val) $sth->addParam($key,$val);
            return $sth->build();
        }

        public function whoisguard_enable($data){
            $sth = $this->get("namecheap.whoisguard.enable");
            foreach($data AS $key=>$val) $sth->addParam($key,$val);
            return $sth->build();
        }

        public function whoisguard_disable($data){
            $sth = $this->get("namecheap.whoisguard.disable");
            foreach($data AS $key=>$val) $sth->addParam($key,$val);
            return $sth->build();
        }

        public function whoisguard_renew($data){
            $sth = $this->get("namecheap.whoisguard.renew");
            foreach($data AS $key=>$val) $sth->addParam($key,$val);
            return $sth->build();
        }

        public function retrieveAuthCode($domain=''){
            $sth = $this->get("retrieveAuthCode");
            $sth->addParam("domain",$domain);
            return $sth->build();
        }

        public function domains_getList($page=1,$pageSize=100){
            $data = $this->get("namecheap.domains.getList");
            $data->addParam("Page",$page);
            $data->addParam("PageSize",$pageSize);
            $data->addParam("SortBy","CREATEDATE_DESC");
            return $data->build();
        }

        public function users_getPricing($data=[]){
            $sth = $this->get("namecheap.users.getPricing");
            foreach($data AS $key=>$val) $sth->addParam($key,$val);
            return $sth->build();
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