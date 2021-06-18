<?php
    class WHMApi {
        private $whm_api_version = 1;
        private $cpanel_api_version=2;
        private $type = "json-api";
        private $topLink = NULL;
        private $ip;
        private $port;
        private $username;
        private $password;
        private $secure;
        private $curl;
        public  $error;
        private $_query;
        public $_full_query;
        private $_params;
        public $timeout=1200;

        function __construct($ip,$port,$username,$password,$secure){
            set_time_limit(0);
            $this->topLink      = $secure == 1 ? "https://" : "http://";
            $this->topLink      .= $ip.":".$port."/".$this->type."/";
            $header             = ["Authorization: Basic " . base64_encode($username.":".$password)."\n\r"];
            $this->ip           = $ip;
            $this->port         = $port;
            $this->username     = $username;
            $this->password     = $password;
            $this->secure       = $secure;

            $this->curl         = curl_init();
            curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER,0);
            curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST,0);
            curl_setopt($this->curl, CURLOPT_HEADER,0);
            curl_setopt($this->curl, CURLOPT_RETURNTRANSFER,1);
            curl_setopt($this->curl, CURLOPT_HTTPHEADER, $header);
        }

        private function query($api_type="WHM",$module="",$function=""){
            $this->_reset();
            if($api_type == "WHM")
                $this->_query = $this->topLink.$module."?api.version=".$this->whm_api_version;

            elseif($api_type == "cPanel")
                $this->_query = $this->topLink."cpanel?cpanel_jsonapi_user=user&cpanel_jsonapi_apiversion=".$this->cpanel_api_version."&cpanel_jsonapi_module=".$module."&cpanel_jsonapi_func=".$function;
            return $this;
        }

        private function user($username=''){
            $this->_query = str_replace("cpanel_jsonapi_user=user","cpanel_jsonapi_user=".$username,$this->_query);
            return $this;
        }

        private function addParam($key,$value){
            $this->_params .= "&".$key."=".urlencode($value);
            return $this;
        }

        private function build(){
            curl_setopt($this->curl, CURLOPT_CONNECTTIMEOUT,0);
            curl_setopt($this->curl, CURLOPT_TIMEOUT,$this->timeout);
            $this->_full_query = $this->_query . $this->_params;
            curl_setopt($this->curl, CURLOPT_URL, $this->_full_query);
            $resultx = curl_exec($this->curl);
            if(!$resultx || curl_errno($this->curl)){
                $curl_error = curl_error($this->curl);
                $this->error = "WHM API:: ".$curl_error;
                LogManager::core_error_log(500,"WHM API Curl Error: ".$this->_full_query,__FILE__,__LINE__);
                return false;
            }
            $result        = Utility::jdecode($resultx,true);
            if(!$result){
                $this->error = "WHM API:: Incoming data could not be resolved.";
                return false;
            }

            if(isset($result["metadata"])){
                if($result["metadata"]["result"] == 1){
                    return isset($result["data"]) ? $result["data"] : $result["metadata"]["reason"];
                }else{
                    $this->error = "WHM API:: ".$result["metadata"]["reason"];
                    return false;
                }
            }elseif(isset($result["cpanelresult"])){
                if(isset($result["cpanelresult"]["event"]["result"]) && $result["cpanelresult"]["event"]["result"] == 1 && !isset($result["cpanelresult"]["error"])){
                    return $result["cpanelresult"]["data"];
                }else{
                    if(isset($result["cpanelresult"]["data"]["reason"]))
                        $this->error = "WHM API:: ".$result["cpanelresult"]["data"]["reason"];
                    elseif(isset($result["cpanelresult"]["data"][0]["reason"]))
                        $this->error = "WHM API:: ".$result["cpanelresult"]["data"][0]["reason"];
                    elseif(isset($result["cpanelresult"]["error"]))
                        $this->error = "WHM API:: ".$result["cpanelresult"]["error"];
                    else
                        $this->error = "WHM API:: "."Unknown error message";
                    return false;
                }

            }elseif(isset($result["result"][0])){
                if($result["result"][0]["status"]){
                    return $result["result"];
                }else{
                    $this->error = "WHM API:: ".$result["result"][0]["statusmsg"];
                    return false;
                }
            }else{
                $this->error = "WHM API:: "."No result data";
                return false;
            }
            return $result;
        }

        public function list_users(){
            $result = $this->query("WHM","list_users");
            return $result->build();
        }

        public function createacct($params=[]){
            $result = $this->query("WHM","createacct");
            foreach ($params AS $k=>$v) $result->addParam($k,$v);
            return $result->build();
        }

        public function modifyacct($username='',$params=[]){
            $result = $this->query("WHM","modifyacct");
            $result->addParam("user",$username);
            foreach ($params AS $k=>$v) $result->addParam($k,$v);
            return $result->build();
        }

        public function setresellerlimits($user,$params=[]){
            $result = $this->query("WHM","setresellerlimits");
            $result->addParam("user",$user);
            foreach ($params AS $k=>$v) $result->addParam($k,$v);
            return $result->build();
        }

        public function setacls($user,$params=[]){
            $result = $this->query("WHM","setacls");
            $result->addParam("reseller",$user);
            foreach ($params AS $k=>$v) $result->addParam($k,$v);
            return $result->build();
        }

        public function removeacct($username=''){
            $result = $this->query("WHM","removeacct");
            $result->addParam("user",$username);
            return $result->build();
        }

        public function terminatereseller($username=''){
            $result = $this->query("WHM","terminatereseller");
            $result->addParam("user",$username);
            $result->addParam("terminatereseller",1);
            return $result->build();
        }

        public function setupreseller($username=''){
            $result = $this->query("WHM","setupreseller");
            $result->addParam("user",$username);
            $result->addParam("makeowner",1);
            return $result->build();
        }

        public function suspendacct($username=''){
            return $this->query("WHM","suspendacct")->addParam("user",$username)->addParam("reason","system")->build();
        }

        public function suspendreseller($username=''){
            return $this->query("WHM","suspendreseller")->addParam("user",$username)->addParam("reason","system")->build();
        }

        public function unsuspendacct($username=''){
            return $this->query("WHM","unsuspendacct")->addParam("user",$username)->build();
        }

        public function unsuspendreseller($username=''){
            return $this->query("WHM","unsuspendreseller")->addParam("user",$username)->build();
        }

        public function changepackage($username='',$plan=''){
            return $this->query("WHM","changepackage")
                ->addParam("user",$username)
                ->addParam("pkg",$plan)
                ->build();
        }

        public function editquota($username='',$quota=''){
            return $this->query("WHM","editquota")
                ->addParam("user",$username)
                ->addParam("quota",$quota)
                ->build();
        }

        public function limitbw($username='',$bwlimit=''){
            return $this->query("WHM","limitbw")
                ->addParam("user",$username)
                ->addParam("bwlimit",$bwlimit)
                ->build();
        }

        public function verify_new_username($username=''){
            return $this->query("WHM","verify_new_username")->addParam("user",$username)->build();
        }

        public function Email_listpopswithdisk($username){
            return $this->query("cPanel","Email","listpopswithdisk")->user($username)->addParam("api2_sort","0")->build();
        }

        public function Email_listforwards($username){
            return $this->query("cPanel","Email","listforwards")->user($username)->build();
        }

        public function Email_listmaildomains($user){
            return $this->query("cPanel","Email","listmaildomains")->user($user)->build();
        }

        public function Email_listmx($user){
            return $this->query("cPanel","Email","listmx")->user($user)->build();
        }

        public function Email_listmxs($user){
            return $this->query("cPanel","Email","listmxs")->user($user)->build();
        }

        public function Email_addpop($user,$domain,$email,$password,$quota){
            $result = $this->query("cPanel","Email","addpop")->user($user);
            $result->addParam("domain",$domain);
            $result->addParam("email",$email);
            $result->addParam("password",$password);
            $result->addParam("quota",$quota);
            return $result->build();
        }

        public function Email_addforward($user,$domain,$dest,$forward){
            $result = $this->query("cPanel","Email","addforward")->user($user);
            $result->addParam("domain",$domain);
            $result->addParam("email",$dest);
            $result->addParam("fwdopt","fwd");
            $result->addParam("fwdemail",$forward);
            return $result->build();
        }

        public function Email_passwdpop($user,$domain,$email,$password){
            $result     = $this->query("cPanel","Email","passwdpop")->user($user);
            $result->addParam("domain",$domain);
            $result->addParam("email",$email);
            $result->addParam("password",$password);
            return $result->build();
        }

        public function Email_editquota($user,$domain,$email,$quota){
            $result     = $this->query("cPanel","Email","editquota")->user($user);
            $result->addParam("domain",$domain);
            $result->addParam("email",$email);
            $result->addParam("quota",$quota);
            return $result->build();
        }

        public function Email_delpop($user,$domain,$email){
            $result = $this->query("cPanel","Email","delpop")->user($user);
            $result->addParam("domain",$domain);
            $result->addParam("email",$email);
            return $result->build();
        }

        public function Email_delforward($user,$dest,$forward){
            $result = $this->query("cPanel","Email","delforward")->user($user);
            $result->addParam("emaildest",$forward);
            $result->addParam("email",$dest);
            return $result->build();
        }


        public function showbw($search="",$search_type="user"){
            return $this->query("WHM","showbw")->addParam("searchtype",$search_type)->addParam("search",$search)->build();
        }

        public function listaccts($search="",$search_type="",$want=''){
            $stmt = $this->query("WHM","listaccts");
            if($search) $stmt->addParam("searchtype",$search_type);
            if($search_type) $stmt->addParam("search",$search);
            if($want) $stmt->addParam("want",$want);
            return $stmt->build();
        }

        public function accountsummary($username,$domain=''){
            $result = $this->query("WHM","accountsummary");
            if($domain == '')
                $result->addParam("user",$username);
            else
                $result->addParam("domain",$domain);
            return $result->build();
        }

        public function AddonDomain_listaddondomains($user){
            return $this->query("cPanel","AddonDomain","listaddondomains")->user($user)->build();
        }

        public function passwd($user,$newpw){
            return $this->query("WHM","passwd")->addParam("user",$user)->addParam("password",$newpw)->addParam("enabledigest","1")->build();
        }

        public function listpkgs($want=''){
            $stmt = $this->query("WHM","listpkgs");
            if($want) $stmt->addParam("want",$want);
            return $stmt->build();
        }

        public function listacls(){
            $stmt = $this->query("WHM","listacls");
            return $stmt->build();
        }
        public function myprivs(){
            $stmt = $this->query("WHM","myprivs");
            return $stmt->build();
        }

        public function create_user_session($params=[]){
            $this->timeout = 10;
            $stmt = $this->query("WHM","create_user_session");
            foreach($params AS $k=>$v) $this->addParam($k,$v);
            return $stmt->build();
        }

        public function Passwd_change_password($user,$oldpw,$newpw){
            return $this->query("cPanel","Passwd","change_password")->user($user)->addParam("oldpass",$oldpw)->addParam("newpass",$newpw)->build();
        }

        public function PasswdStrength_get_password_strength($user,$word){
            return $this->query("cPanel","PasswdStrength","get_password_strength")->user($user)->addParam("password",$word)->build();
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