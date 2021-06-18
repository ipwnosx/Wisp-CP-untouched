<?php
    class ResellerClub_Api {
        private $test_mode      = false;
        private $user_id        = 0;
        private $api_key        = NULL;
        private $curl           = false;
        public  $error          = NULL;
        private $_type          = "GET";
        private $topLink        = NULL;
        public $_query          = NULL;
        private $_params        = [];
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
        }

        private function start_curl()
        {
            $this->curl         = curl_init();
            curl_setopt($this->curl, CURLOPT_USERAGENT,'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)');
            curl_setopt($this->curl, CURLOPT_ENCODING, "gzip");
            curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
            return $this;
        }

        private function get($type="api",$command='',$rType="json"){
            $this->_reset();
            $this->start_curl();

            $this->_type    = "GET";
            $this->rType    = $rType;
            $this->_query   = $this->topLink;
            if($command == "premium/available") $this->_query = "https://domaincheck.httpapi.com/";
            $this->_query   .= "api/".$type."/".$command.".".$this->rType;
            curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST,$this->_type);
            curl_setopt($this->curl, CURLOPT_POST,false);
            curl_setopt($this->curl, CURLOPT_POSTFIELDS,NULL);
            $this->addParam("auth-userid",$this->user_id);
            $this->addParam("api-key",$this->api_key);
            return $this;
        }

        private function post($type="domains",$command='',$rType="json"){
            $this->_reset();

            $this->start_curl();

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
            $query = $this->_query;
            if($this->_type == "GET")
                $this->_query = $this->_query."?".$fields;
            elseif($this->_type == "POST")
                curl_setopt($this->curl, CURLOPT_POSTFIELDS,$fields);

            curl_setopt($this->curl, CURLOPT_URL, $this->_query);
            $result_x = curl_exec($this->curl);
            $result = $result_x;
            if(!$result || curl_errno($this->curl)){
                $curl_error = curl_error($this->curl);
                $this->error = "Curl Error: ".$curl_error;
                $result = false;
            }
            if($this->curl) curl_close($this->curl);

            if($result && !$nodecode && !is_numeric($result)){
                if($this->rType == "json")
                    $result = Utility::jdecode($result,true);
                elseif($this->rType == "xml")
                    $result = Utility::xdecode($result,true);
                if(!$result) $this->error = "The answer could not be solved.";

                if(isset($result["status"]) && strtoupper($result["status"]) == "ERROR"){
                    $this->error = isset($result["message"]) ? $result["message"] : $result["error"];
                    $result = false;
                }
                elseif(isset($result["entry"]["string"][0]) && $result["entry"]["string"][0] == "Error"){
                    $this->error = $result["entry"]["string"][1];
                    $result = false;
                }
            }
            Modules::save_log("Registrars","ResellerClub",$this->_type."/ ".$query,$fields,$result_x,$this->error ? $this->error : $result);
            return $result;
        }

        public function renewal($params=[]){
            $sth = $this->post("domains","renew");
            foreach($params AS $key=>$value){
                if($key == "dns"){
                    if(isset($value["ns1"])) $this->addParam("ns",$value["ns1"]);
                    if(isset($value["ns2"])) $this->addParam("ns",$value["ns2"]);
                    if(isset($value["ns3"])) $this->addParam("ns",$value["ns3"]);
                    if(isset($value["ns4"])) $this->addParam("ns",$value["ns4"]);
                }else $this->addParam($key,$value);
            }
            return $sth->build();
        }

        public function register($params=[]){
            $sth = $this->post("domains","register");
            foreach($params AS $key=>$value){
                if($key == "dns"){
                    if(isset($value["ns1"])) $this->addParam("ns",$value["ns1"]);
                    if(isset($value["ns2"])) $this->addParam("ns",$value["ns2"]);
                    if(isset($value["ns3"])) $this->addParam("ns",$value["ns3"]);
                    if(isset($value["ns4"])) $this->addParam("ns",$value["ns4"]);
                }else $this->addParam($key,$value);
            }
            return $sth->build();
        }

        public function transfer($params=[]){
            $sth = $this->post("domains","transfer");
            foreach($params AS $key=>$value){
                if($key == "dns"){
                    if(isset($value["ns1"])) $this->addParam("ns",$value["ns1"]);
                    if(isset($value["ns2"])) $this->addParam("ns",$value["ns2"]);
                    if(isset($value["ns3"])) $this->addParam("ns",$value["ns3"]);
                    if(isset($value["ns4"])) $this->addParam("ns",$value["ns4"]);
                }else $this->addParam($key,$value);
            }
            return $sth->build();
        }

        public function available($sld,$tlds=[]){
            $sth = $this->get("domains","available");
            $sth->addParam("domain-name",$sld);
            foreach($tlds AS $t) $sth->addParam("tlds",$t);
            return $sth->build();
        }

        public function available_premium($sld,$tlds=[]){
            $sth = $this->get("domains","premium/available","xml");
            $sth->addParam("key-word=domain",$sld);
            foreach($tlds AS $t) $sth->addParam("tlds",$t);
            return $sth->build();
        }

        public function getOrderId($domain){
            $sth = $this->get("domains","orderid");
            $sth->addParam("domain-name",$domain);
            return $sth->build();
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
        public function cost_prices(){
            $sth = $this->get("products","reseller-cost-price");
            return $sth->build();
        }
        public function promo_prices(){
            $sth = $this->get("resellers","promo-details");
            return $sth->build();
        }
        public function product_keys(){
            $sth = $this->get("products","category-keys-mapping");
            return $sth->build();
        }
        public function getDetails($order_id=0,$options='',$reload=true){
            if(!isset($this->_storage["details"][$order_id][$options]) || $reload){
                $sth = $this->get("domains","details");
                $sth->addParam("order-id",$order_id);
                $sth->addParam("options",$options);
                $result = $sth->build();
                $this->_storage["details"][$order_id][$options] = $result;
                return $result;
            }else return $this->_storage["details"][$order_id][$options];
        }

        public function addContact($customer_id=0,$data=[],$tld){
            $sth = $this->post("contacts","add");
            $sth->addParam("customer-id",$customer_id);
            $sth->addParam("type",$this->contact_type($tld));
            foreach($data AS $key=>$val) $sth->addParam($key,$val);
            return $sth->build();
        }

        public function ModifyContact($order_id,$regCID,$adminCID,$techCID,$BillingCID){
            $sth = $this->post("domains","modify-contact");
            $sth->addParam("order-id",$order_id);
            $sth->addParam("reg-contact-id",$regCID);
            $sth->addParam("admin-contact-id",$adminCID);
            $sth->addParam("tech-contact-id",$techCID);
            $sth->addParam("billing-contact-id",$BillingCID);
            return $sth->build();
        }

        public function ModifyDns($order_id=0,$dns=[]){
            $sth = $this->post("domains","modify-ns");
            $sth->addParam("order-id",$order_id);
            foreach($dns AS $ns) if($ns) $this->addParam("ns",$ns);
            return $sth->build();
        }

        public function addCNS($order_id=0,$ns='',$ip=''){
            $sth = $this->post("domains","add-cns");
            $sth->addParam("order-id",$order_id);
            $sth->addParam("cns",$ns);
            $sth->addParam("ip",$ip);
            return $sth->build();
        }

        public function modifyCNsName($order_id=0,$old_cns='',$new_cns=''){
            $sth = $this->post("domains","modify-cns-name");
            $sth->addParam("order-id",$order_id);
            $sth->addParam("old-cns",$old_cns);
            $sth->addParam("new-cns",$new_cns);
            return $sth->build();
        }

        public function modifyCNsIP($order_id=0,$cns='',$old_ip=0,$new_ip=0){
            $sth = $this->post("domains","modify-cns-ip");
            $sth->addParam("order-id",$order_id);
            $sth->addParam("cns",$cns);
            $sth->addParam("old-ip",$old_ip);
            $sth->addParam("new-ip",$new_ip);
            return $sth->build();
        }

        public function deleteCNS($order_id=0,$cns='',$ip=''){
            $sth = $this->post("domains","delete-cns-ip");
            $sth->addParam("order-id",$order_id);
            $sth->addParam("cns",$cns);
            $sth->addParam("ip",$ip);
            return $sth->build();
        }

        public function modifyTransferLock($order_id=0,$type){
            $sth = $this->post("domains",$type."-theft-protection");
            $sth->addParam("order-id",$order_id);
            return $sth->build();
        }

        public function modifyAuthCode($order_id=0,$authCode=''){
            $sth = $this->post("domains","modify-auth-code");
            $sth->addParam("order-id",$order_id);
            $sth->addParam("auth-code",$authCode);
            return $sth->build();
        }

        public function modifyPrivacyProtection($order_id=0,$status=''){
            $sth = $this->post("domains","modify-privacy-protection");
            $sth->addParam("order-id",$order_id);
            $sth->addParam("protect-privacy",$status);
            $sth->addParam("reason","somereason");
            return $sth->build();
        }

        public function purchasePrivacy($order_id=0){
            //purchase-privacy.json?auth-userid=0&api-key=key&order-id=0&invoice-option=NoInvoice
            $sth = $this->post("domains","purchase-privacy");
            $sth->addParam("order-id",$order_id);
            $sth->addParam("invoice-option","NoInvoice");
            return $sth->build();
        }

        public function contact_type($tld){
            $types	= array(
                'br' => 'BrContact',
                'ca' => 'CaContact',
                'cn' => 'CnContact',
                'co' => 'CoContact',
                'de' => 'DeContact',
                'es' => 'EsContact',
                'eu' => 'EuContact',
                'mx' => 'MxContact',
                'nl' => 'NlContact',
                'nyc' => 'NycContact',
                'ru' => 'RuContact',
                'uk' => 'UkContact',
            );
            $result	= isset($types[$tld]) ? $types[$tld] : NULL;
            return ($result == NULL) ? 'Contact' : $result;
        }

        public function search($params=[]){
            $sth = $this->get("domains","search");
            foreach($params AS $key=>$value) $this->addParam($key,$value);
            return $sth->build();
        }

        public function search_dns_records($domain='',$type='',$nor=50,$page=1){
            $sth = $this->get("dns/manage","search-records");
            $this->addParam("domain-name",$domain);
            $this->addParam("type",$type);
            $this->addParam("no-of-records",$nor);
            $this->addParam("page-no",$page);
            return $sth->build();
        }

        private function _reset(){
            if($this->curl) curl_close($this->curl);
            $this->error          = NULL;
            $this->_type          = NULL;
            $this->_query         = NULL;
            $this->_params        = [];
            $this->rType          = "json";
        }

        function __destruct(){}
    }