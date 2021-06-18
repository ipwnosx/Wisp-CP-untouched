<?php
    class CentOSWebPanel_Api {
        private $topLink = NULL;
        private $ip;
        private $port;
        private $username;
        private $password;
        private $access_hash;
        private $secure;
        private $curl;
        public  $error;
        private $_query;
        public $_full_query;
        private $_params;

        function __construct($ip,$port,$username,$password,$access_hash,$secure){
            set_time_limit(0);
            $this->ip           = $ip;
            $this->port         = $port;
            $this->username     = $username;
            $this->password     = $password;
            $this->access_hash  = $access_hash;
            $this->secure       = $secure;

            $this->topLink      = "https://";
            $this->topLink      .= $this->ip.":".$this->port."/";

            $this->curl         = curl_init();
            curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER,0);
            curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST,0);
            curl_setopt($this->curl, CURLOPT_HEADER,0);
            curl_setopt($this->curl, CURLOPT_RETURNTRANSFER,1);
            $this->set_timeout(200);
        }

        private function query($query='',$action=''){
            $this->_reset();
            $this->_query = $this->topLink."v1/".$query;
            $this->addParam("key",$this->access_hash);
            if($action) $this->addParam("action",$action);
            return $this;
        }

        private function addParam($key,$value){
            $this->_params .= "&".$key."=".urlencode($value);
            return $this;
        }

        private function build($parse=true){
            $this->_full_query = $this->_query;
            curl_setopt($this->curl, CURLOPT_URL, $this->_full_query);
            curl_setopt($this->curl,CURLOPT_POST,1);
            curl_setopt($this->curl,CURLOPT_POSTFIELDS,$this->_params);
            $resultx    = curl_exec($this->curl);

            if(curl_errno($this->curl)){
                $curl_error = curl_error($this->curl);
                if($curl_error){
                    $this->error = "cURL Error: ".$curl_error;
                    $resultx = false;
                }
            }

            if(!$resultx){
                $this->error = "API: ".'The API did not return any data.';
                return false;
            }
            if($parse){
                if(stristr($resultx,'<pre>')){
                    $split      = explode('<pre>',$resultx);
                    $resultx    = $split[0];
                }
                $result        = Utility::jdecode($resultx,true);
                if(!$result){
                    $this->error = "API: "."Incoming data could not be resolved.";
                    $result = false;
                }
                if($result && isset($result["status"]) && $result["status"] == "Error" && isset($result["msj"])){
                    $this->error = "API: ".$result["msj"];
                    $result = false;
                }
            }
            else
                $result = $resultx;

            Modules::save_log('Servers','CentOSWebPanel',$this->_full_query,$this->_params,$resultx,$this->error ? $this->error : $result);

            return $result;
        }

        public function account_list(){
            return $this->query("account","list")->build();
        }
        public function user_session($user = ''){
            return $this->query("user_session","list")->addParam('user',$user)->build();
        }
        public function account_add($data=[]){
            $stmt =  $this->query("account","add");
            foreach($data AS $k=>$v) $stmt->addParam($k,$v);
            return $stmt->build();
        }
        public function account_udp($data=[]){
            $stmt =  $this->query("account","udp");
            foreach($data AS $k=>$v) $this->addParam($k,$v);
            return $stmt->build();
        }
        public function account_susp($user=''){
            return $this->query("account","susp")->addParam("user",$user)->build();
        }
        public function account_unsp($user=''){
            return $this->query("account","unsp")->addParam("user",$user)->build();
        }
        public function account_del($user=''){
            return $this->query("account","del")->addParam("user",$user)->build();
        }
        public function accountdetail_list($user=''){
            return $this->query("accountdetail","list")->addParam("user",$user)->build();
        }
        public function accountquota_list($user=''){
            return $this->query("accountquota","list")->addParam("User",$user)->build();
        }
        public function account_metadata_list($user=''){
            return $this->query("account_metadata","list")->addParam("user",$user)->build();
        }
        public function quotalimit_list($user=''){
            return $this->query("quotalimit","list")->addParam("user",$user)->build();
        }
        public function changepass_udp($user='',$pass=''){
            return $this->query("changepass","udp")->addParam("user",$user)->addParam("pass",$pass)->build();
        }
        public function changepack_udp($user='',$package=''){
            return $this->query("changepack","udp")->addParam("user",$user)->addParam("package",$package)->build();
        }
        public function packages_list($reseller=false){
            $stmt =  $this->query("packages","list");
            if($reseller) $stmt->addParam("reseller",1);
            return $stmt->build();
        }

        public function set_timeout($num=0){
            curl_setopt($this->curl, CURLOPT_CONNECTTIMEOUT,0);
            curl_setopt($this->curl, CURLOPT_TIMEOUT,$num);
            return $this;
        }

        function __destruct(){
            curl_close($this->curl);
        }

        private function _reset(){
            $this->_query = NULL;
            $this->_params = NULL;
            $this->_full_query = NULL;
        }

    }