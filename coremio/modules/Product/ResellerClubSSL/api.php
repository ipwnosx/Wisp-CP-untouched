<?php
    class ResellerClubSSL_Api {
        private $test_mode      = false;
        private $user_id        = 0;
        private $api_key        = NULL;
        private $curl           = false;
        public  $error          = NULL;
        private $_type          = "GET";
        private $topLink        = NULL;
        public $_query          = NULL;
        public $_params        = [];
        private $_storage       = [];
        private $rType          = "json";

        function __construct($user_id=0,$api_key=NULL,$test_mode=false){
            if($user_id == 0 || $api_key == NULL){
                $this->error = "It is necessary to enter API information.";
            }

            $this->user_id      = $user_id;
            $this->api_key      = $api_key;
            $this->test_mode    = $test_mode;
            $this->topLink      = $test_mode ? "https://test.httpapi.com/" : "https://httpapi.com/";
            $this->curl         = curl_init();
            curl_setopt($this->curl, CURLOPT_USERAGENT,'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)');
            curl_setopt($this->curl, CURLOPT_ENCODING, "gzip");
            curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);

        }

        private function get($type="api",$command='',$rType="json"){
            $this->_reset();
            $this->_type    = "GET";
            $this->rType    = $rType;
            $this->_query   = $this->topLink."api/".$type."/".$command.".".$this->rType;
            curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST,$this->_type);
            curl_setopt($this->curl, CURLOPT_POST,false);
            curl_setopt($this->curl, CURLOPT_POSTFIELDS,NULL);
            $this->addParam("auth-userid",$this->user_id);
            $this->addParam("api-key",$this->api_key);
            return $this;
        }

        private function post($type="domains",$command='',$rType="json"){
            $this->_reset();
            $this->_type    = "POST";
            $this->rType    = $rType;
            $this->_query   = $this->topLink."api/".$type."/".$command.".".$this->rType;
            curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST,$this->_type);
            curl_setopt($this->curl, CURLOPT_POST,true);
            $this->addParam("auth-userid",$this->user_id);
            $this->addParam("api-key",$this->api_key);
            return $this;
        }

        private function addParam($key,$value){
            $this->_params[] = $key."=".urlencode($value);
            return $this;
        }

        private function build($nodecode=false){
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
                if($this->rType == "json")
                    $result = Utility::jdecode($result,true);
                elseif($this->rType == "xml")
                    $result = Utility::xdecode($result,true);
                if(!$result){
                    $this->error = "The answer could not be solved.";
                    if(LOG_SAVE) LogManager::core_error_log(500,$this->error." | ".$this->_query." | ".$this->_params,__FILE__,__LINE__);
                    return false;
                }

                if(isset($result["status"]) && strtoupper($result["status"]) == "ERROR"){
                    $this->error = isset($result["message"]) ? $result["message"] : $result["error"];
                    if(LOG_SAVE) LogManager::core_error_log(500,$this->error." | ".$this->_query." | ".print_r($this->_params,true),__FILE__,__LINE__);
                    return false;
                }elseif(isset($result["entry"]["string"][0]) && $result["entry"]["string"][0] == "Error"){
                    $this->error = $result["entry"]["string"][1];
                    if(LOG_SAVE) LogManager::core_error_log(500,$this->error." | ".$this->_query." | ".$this->_params,__FILE__,__LINE__);
                    return false;
                }
            }
            return $result;
        }

        public function getOrderId($domain){
            $sth = $this->get("sslcert","orderid","xml");
            $sth->addParam("domain-name",$domain);
            $result = $sth->build();
            if($result) $result = (int) current($result);
            return $result;
        }
        public function getCustomerDetail($email=''){
            $sth = $this->get("customers","details");
            $sth->addParam("username",$email);
            return $sth->build();
        }
        public function addCustomer($params=[]){
            $sth = $this->post("customers","signup","xml");
            foreach($params AS $key=>$val) $sth->addParam($key,$val);
            return $sth->build();
        }
        public function details($order_id=0,$reload=true){
            if(!isset($this->_storage["details"][$order_id]) || $reload){
                $sth = $this->get("sslcert","details");
                $sth->addParam("order-id",$order_id);
                $result = $sth->build();
                $this->_storage["details"][$order_id] = $result;
                return $result;
            }else return $this->_storage["details"][$order_id];
        }
        public function get_cert_details($order_id=0,$reload=true){
            if(!isset($this->_storage["get_cert_details"][$order_id]) || $reload){
                $sth = $this->get("sslcert","get-cert-details","xml");
                $sth->addParam("order-id",$order_id);
                $result = $sth->build();
                $this->_storage["get_cert_details"][$order_id] = $result;
                return $result;
            }else return $this->_storage["get_cert_details"][$order_id];
        }
        public function search($params=[]){
            $sth = $this->get("sslcert","search");
            foreach($params AS $key=>$value) $this->addParam($key,$value);
            return $sth->build();
        }
        public function products_plan_details(){
            $sth = $this->get("products","plan-details");
            return $sth->build();
        }
        public function add($params=[]){
            $sth = $this->post("sslcert","add");
            foreach($params AS $key=>$val) $sth->addParam($key,$val);
            return $sth->build();
        }
        public function renew($params=[]){
            $sth = $this->get("sslcert","renew","xml");
            foreach($params AS $key=>$val) $sth->addParam($key,$val);
            return $sth->build();
        }
        public function enroll($params=[]){
            $sth = $this->post("sslcert","enroll");
            foreach($params AS $key=>$val) $sth->addParam($key,$val);
            return $sth->build();
        }
        public function reissue($params=[]){
            $sth = $this->post("sslcert","reissue","xml");
            foreach($params AS $key=>$val) $sth->addParam($key,$val);
            return $sth->build();
        }
        public function change_verification_email($params=[]){
            $sth = $this->post("sslcert","change-verification-email","xml");
            foreach($params AS $key=>$val) $sth->addParam($key,$val);
            return $sth->build();
        }
        public function delete($order_id=0){
            return $this->post("sslcert","delete","xml")->addParam('order-id',$order_id)->build();
        }

        private function _reset(){
            $this->error          = NULL;
            $this->_type          = NULL;
            $this->_query         = NULL;
            $this->_params        = [];
            $this->rType          = "json";
        }

        function __destruct(){
            if($this->curl) curl_close($this->curl);
        }
    }