<?php
    class BuycPanel_Api {
        private $test_mode      = false;
        private $login          = '';
        private $key            = NULL;
        private $curl           = false;
        public  $error          = NULL;
        private $_type          = "GET";
        private $topLink        = NULL;
        private $topLink2       = NULL;
        public $_query          = NULL;
        public $_params         = [];
        private $_storage       = [];

        function __construct($login='',$key='',$test_mode=false){

            $this->login        = $login;
            $this->key          = $key;
            $this->test_mode    = $test_mode;
            $this->topLink      = "https://www.buycpanel.com/api/";
            $this->topLink2     = "https://www.buycpanel.com/api/2/";
            $this->curl         = curl_init();
            curl_setopt($this->curl, CURLOPT_USERAGENT,'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)');
            curl_setopt($this->curl, CURLOPT_ENCODING, "gzip");
            curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
            Curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);
        }
        private function _reset(){
            $this->error          = NULL;
            $this->_type          = NULL;
            $this->_query         = NULL;
            $this->_params        = [];
        }
        private function call($command='',$v2=false){
            $command .= ".php";
            $command .= "?login=".$this->login."&key=".$this->key."&test=".($this->test_mode ? 1 : 0);
            $this->_reset();
            $this->_type    = "POST";
            $this->_query   = ($v2 ? $this->topLink2 : $this->topLink).$command;
            curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST,$this->_type);
            curl_setopt($this->curl, CURLOPT_POST,true);
            return $this;
        }
        private function addParam($key,$value){
            $this->_params[] = $key."=".urlencode($value);
            return $this;
        }
        private function build($nodecode=false){
            $fields = implode("&",$this->_params);
            if($this->_type == "GET")
                $this->_query = $this->_query."&".$fields;
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

                $result = Utility::jdecode($result,true);

                if(!$result){
                    $this->error = "The answer could not be solved.";
                    if(LOG_SAVE) LogManager::core_error_log(500,$this->error." | ".$this->_query,__FILE__,__LINE__);
                    return false;
                }

                if(isset($result["success"]) && !$result["success"] && isset($result["faultstring"])){
                    $this->error = $result["faultstring"];
                    return false;
                }elseif(isset($result["result"])) $result = $result["result"];
            }
            return $result;
        }

        public function export($params=[]){
            $stmt = $this->call("export");
            if($params) foreach ($params AS $k=>$v) $stmt->addParam($k,$v);
            return $stmt->build();
        }

        public function export_products(){
            $stmt = $this->call("export_products",true);
            return $stmt->build();
        }

        public function order($params=[]){
            $stmt = $this->call("order");
            if($params) foreach($params AS $k=>$v) $stmt->addParam($k,$v);
            return $stmt->build();
        }
        public function changeip($short_code,$ip='',$new_ip=''){
            $stmt = $this->call("changeip");
            $stmt->addParam("currentip",$ip);
            $stmt->addParam("newip",$new_ip);
            if($short_code !== "cpanel"){
                $stmt->addParam("change","addons");
                $stmt->addParam($short_code,"1");
            }
            return $stmt->build();
        }
        public function cancel($short_code,$ip=''){
            $stmt = $this->call("cancel");
            $stmt->addParam("currentip",$ip);
            if($short_code !== "cpanel"){
                $stmt->addParam("cancel","addons");
                $stmt->addParam($short_code,"1");
            }
            return $stmt->build();
        }

        function __destruct(){
            if($this->curl) curl_close($this->curl);
        }
    }