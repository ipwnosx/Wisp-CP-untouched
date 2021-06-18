<?php
    class OnlineNICSSL_Api {
        private $test_mode      = false;
        private $username       = 0;
        private $password       = NULL;
        private $api_key        = NULL;
        private $token          = NULL;
        private $curl           = false;
        public  $error          = NULL;
        private $_type          = "GET";
        private $topLink        = NULL;
        public $_query          = NULL;
        private $_params        = [];
        private $_storage       = [];

        function __construct($username='',$password=NULL,$api_key='',$test_mode=false){
            if($test_mode){
                $username = "10578";
                $password = "654123";
                $api_key  = 'v}k5s(`ipc$G~koH';
            }

            $this->username      = $username;
            $this->password      = $password;
            $this->api_key       = $api_key;
            $this->test_mode    = $test_mode;
            $this->topLink      = $test_mode ? "https://ote.onlinenic.com/" : "https://api.onlinenic.com/";
            $this->curl         = curl_init();
            curl_setopt($this->curl, CURLOPT_USERAGENT,'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)');
            curl_setopt($this->curl, CURLOPT_ENCODING, "gzip");
            curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        }

        private function get($command=''){
            $this->_reset();
            $this->_type    = "GET";
            $this->_query   = $this->topLink."api4/domain/index.php?command=".$command;
            curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST,$this->_type);
            curl_setopt($this->curl, CURLOPT_POST,false);
            curl_setopt($this->curl, CURLOPT_POSTFIELDS,NULL);

            $timestamp      = DateManager::strtotime(DateManager::next_date(['minutes' => 10],"Y-m-d H:i:s"));
            $token          = $this->token($timestamp,$command);
            $this->addParam("user",$this->username);
            $this->addParam("timestamp",$timestamp);
            $this->addParam("apikey",$this->api_key);
            $this->addParam("token",$token);
            return $this;
        }

        private function post($command=''){
            $this->_reset();
            $this->_type    = "POST";
            $this->_query   = $this->topLink."api4/ssl/index.php?command=".$command;
            curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST,$this->_type);
            curl_setopt($this->curl, CURLOPT_POST,true);

            $timestamp      = DateManager::strtotime(DateManager::next_date(['minutes' => 10],"Y-m-d H:i:s"));
            $token          = $this->token($timestamp,$command);
            $this->addParam("user",$this->username);
            $this->addParam("timestamp",$timestamp);
            $this->addParam("apikey",$this->api_key);
            $this->addParam("token",$token);
            return $this;
        }

        private function token($timestamp,$command=''){
            return strtolower(md5($this->username.md5($this->password).$timestamp.$command));
        }

        private function addParam($key,$value){
            $this->_params[] = $key."=".urlencode($value);
            return $this;
        }

        private function build($nodecode=false,$noData=false){
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
                if(LOG_SAVE) LogManager::core_error_log(500,$this->error." | ".$this->_query." | ".$this->_params,__FILE__,__LINE__);
                return false;
            }

            if(!$nodecode && !is_numeric($result)){

                $result = Utility::jdecode($result,true);

                if(!$result){
                    $this->error = "The answer could not be solved.";
                    if(LOG_SAVE) LogManager::core_error_log(500,$this->error." | ".$this->_query." | ",__FILE__,__LINE__);
                    return false;
                }

                // Find Error
                if(isset($result["code"]) && isset($result["msg"]) && $result["code"] != "1000"){
                    $this->error = $result["code"].": ".$result["msg"];
                    return false;
                }elseif(!$noData && isset($result["data"])) $result = $result["data"];
            }

            return $result;
        }

        public function getSSLProductDetails($page=1){
            $stmt   = $this->post("getSSLProductDetails");
            $stmt->addParam("page",$page);
            return $stmt->build();
        }
        public function getSSLOrderList($page=1){
            $stmt   = $this->post("getSSLOrderList");
            $stmt->addParam("page",$page);
            return $stmt->build();
        }
        public function getSSLOrderId($domain=''){
            $stmt   = $this->post("getSSLOrderId")->addParam("domain",$domain)->build();
            return $stmt && isset($stmt["orderid"]) ? $stmt["orderid"] : false;
        }
        public function getSSLOrderInfo($order_id=0){
            return $this->post("getSSLOrderInfo")->addParam("orderid",$order_id)->build();
        }
        public function getSSLCert($order_id=0){
            return $this->post("getSSLCert")->addParam("orderid",$order_id)->build(false,true);
        }
        public function orderSSL($params=[]){
            $sth = $this->post("orderSSL");
            foreach($params AS $key=>$val) $sth->addParam($key,$val);
            return $sth->build();
        }
        public function renewSSL($params=[]){
            $sth = $this->post("renewSSL");
            foreach($params AS $key=>$val) $sth->addParam($key,$val);
            return $sth->build();
        }
        public function cancelSSL($order_id=0,$reason='cessation of service'){
            return $this->post("cancelSSL")->addParam("orderid",$order_id)->addParam("reason",$reason)->build();
        }
        public function changeValidationEmail($params=[]){
            $sth = $this->post("changeValidationEmail");
            foreach($params AS $key=>$val) $sth->addParam($key,$val);
            return $sth->build();
        }
        public function resendApprovalEmail($params=[]){
            $sth = $this->post("resendApprovalEmail");
            foreach($params AS $key=>$val) $sth->addParam($key,$val);
            return $sth->build();
        }
        public function reissueSSL($params=[]){
            $sth = $this->post("reissueSSL");
            foreach($params AS $key=>$val) $sth->addParam($key,$val);
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