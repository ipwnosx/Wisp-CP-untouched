<?php
    class GogetSSL_Api {
        private $test_mode      = false;
        private $username       = 0;
        private $password       = NULL;
        private $key            = NULL;
        private $curl           = false;
        public  $error          = NULL;
        private $_type          = "GET";
        private $topLink        = NULL;
        public $_query          = NULL;
        private $_params        = [];
        private $_storage       = [];

        function __construct($username='',$password=NULL,$key='',$test_mode=false){

            $this->username     = $username;
            $this->password     = $password;
            $this->key          = $key;
            $this->test_mode    = $test_mode;
            $this->topLink      = "https://my.gogetssl.com/api";
            $this->curl         = curl_init();
            curl_setopt($this->curl, CURLOPT_USERAGENT,'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)');
            curl_setopt($this->curl, CURLOPT_ENCODING, "gzip");
            curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
            Curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);
        }

        public function get_auth_key(){
            $response = $this->call('/auth/');
            $response->addParam("user",$this->username);
            $response->addParam("pass",$this->password);
            $response   = $response->build();
            if(isset($response['key']) && $response['key']) $response = $response['key'];
            return $response;
        }

        private function call($command=''){
            $this->_reset();
            if($this->key && $command != '/auth/') $command .= "?auth_key=".$this->key;
            $this->_type    = "POST";
            $this->_query   = $this->topLink.$command;
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

            $resultx = curl_exec($this->curl);
            $result = $resultx;
            if(!$result || curl_errno($this->curl)){
                $curl_error = curl_error($this->curl);
                $this->error = "Curl Error: ".$curl_error;
                $result = false;
            }
            if($result && !$nodecode && !is_numeric($result)){

                $result = Utility::jdecode($result,true);

                if(!$result){
                    $this->error = "The answer could not be solved.";
                    $result = false;
                }

                if(isset($result["error"]) && isset($result["message"]) && $result["error"]){
                    $this->error = $result["message"].(isset($result["description"]) ? ": ".$result["description"] : '');
                    $result = false;
                }

            }

            Modules::save_log('Product','GogetSSL',$this->_query,$fields,$resultx,$this->error ? $this->error : $result);
            return $result;
        }

        public function getAllProducts(){
            return $this->call("/products/")->build();
        }
        public function getWebServers($supplier_id=1){
            return $this->call("/tools/webservers/".$supplier_id)->build();
        }
        public function addSSLOrder($params=[]){
            $sth = $this->call("/orders/add_ssl_order/");
            foreach($params AS $key=>$val) $sth->addParam($key,$val);
            return $sth->build();
        }

        public function getSSLOrderId($domain=''){
            $stmt   = $this->post("getSSLOrderId")->addParam("domain",$domain)->build();
            return $stmt && isset($stmt["orderid"]) ? $stmt["orderid"] : false;
        }
        public function getOrderStatus($order_id=0){
            return $this->call("/orders/status/".$order_id)->build();
        }
        public function getSSLCert($order_id=0){
            return $this->post("getSSLCert")->addParam("orderid",$order_id)->build(false,true);
        }
        public function addSSLRenewOrder($params=[]){
            $sth = $this->call("/orders/add_ssl_renew_order/");
            foreach($params AS $key=>$val) $sth->addParam($key,$val);
            return $sth->build();
        }
        public function addSSLSANOrder($params=[]){
            $sth = $this->call("/orders/add_ssl_san_order/");
            foreach($params AS $key=>$val) $sth->addParam($key,$val);
            return $sth->build();
        }
        public function cancelSSLOrder($order_id=0,$reason='cessation of service'){
            return $this->call("/orders/cancel_ssl_order/")
                ->addParam("order_id",$order_id)
                ->addParam("reason",$reason)
                ->build();
        }
        public function changeValidationEmail($order_id=0,$params=[]){
            $sth = $this->call("/orders/ssl/change_validation_email/".$order_id);
            foreach($params AS $key=>$val) $sth->addParam($key,$val);
            return $sth->build();
        }
        public function resendValidationEmail($order_id=0){
            return $this->call("/orders/ssl/resend_validation_email/".$order_id)->build();
        }
        public function Revalidate($order_id=0,$domain=''){
            return $this->call("/orders/ssl/revalidate/".$order_id)->addParam("domain",$domain)->build();
        }
        public function reissueSSLOrder($order_id=0,$params=[]){
            $sth = $this->call("/orders/ssl/reissue/".$order_id);
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