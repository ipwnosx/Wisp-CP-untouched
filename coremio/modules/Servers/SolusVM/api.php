<?php
    class SolusVM_Api {
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

        function __construct($ip,$username,$password,$port,$secure){
            $this->topLink      = $secure == 1 ? "https://" : "http://";
            $this->topLink      .= $ip.":".$port."/api/";
            $this->ip           = $ip;
            $this->port         = $port;
            $this->username     = $username;
            $this->password     = $password;
            $this->secure       = $secure;

            $this->curl         = curl_init();
            curl_setopt($this->curl, CURLOPT_RETURNTRANSFER,1);
            curl_setopt($this->curl, CURLOPT_CONNECTTIMEOUT,0);
            curl_setopt($this->curl, CURLOPT_POST, 1);
            curl_setopt($this->curl, CURLOPT_TIMEOUT, 200);
            curl_setopt($this->curl, CURLOPT_FRESH_CONNECT, 1);
            curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($this->curl, CURLOPT_HTTPHEADER, array("Expect:"));
            curl_setopt($this->curl, CURLOPT_HEADER, 0);
        }

        private function query($mode="client",$action='',$r_type='json'){
            $this->_reset();
            $this->_query = $this->topLink.$mode."/command.php";

            $this->addParam("id",$this->username);
            $this->addParam("key",$this->password);
            $this->addParam("action",$action);
            $this->addParam("rdtype",$r_type);

            return $this;
        }

        private function addParam($key,$value){
            $this->_params .= "&".$key."=".urlencode($value);
            return $this;
        }

        private function build($r_type="json"){
            $this->_full_query = $this->_query;
            curl_setopt($this->curl, CURLOPT_URL, $this->_full_query);
            curl_setopt($this->curl, CURLOPT_POSTFIELDS, $this->_params);
            $resultx = curl_exec($this->curl);
            if(curl_errno($this->curl)){
                $curl_error = "CURL Error: ".curl_error($this->curl);
                $this->error = $curl_error;
                return false;
            }

            $result = $resultx;
            if($r_type == "json") $result = Utility::jdecode($result,true);

            if(!$result){
                $this->error = "Incoming data could not be resolved. | ".$this->_full_query." |  ".htmlentities($resultx);
                return false;
            }

            if(isset($result["status"]) && $result["status"] == "error"){
                $this->error = $result["statusmsg"];
                return false;
            }

            return $result;
        }

        public function vserver_info_all($vserver_id=0,$nographs=false){
            $stmt   = $this->query("admin","vserver-infoall");
            $stmt->addParam("vserverid",$vserver_id);
            if($nographs) $stmt->addParam("nographs","false");
            return $stmt->build();
        }
        public function vncpass_vserver($vserver_id=0,$password=''){
            $stmt   = $this->query("admin","vserver-vncpass");
            $stmt->addParam("vserverid",$vserver_id);
            $stmt->addParam("vncpassword",$password);
            return $stmt->build();
        }
        public function boot_vserver($vserver_id=0){
            $stmt   = $this->query("admin","vserver-boot");
            $stmt->addParam("vserverid",$vserver_id);
            return $stmt->build();
        }
        public function shutdown_vserver($vserver_id=0){
            $stmt   = $this->query("admin","vserver-shutdown");
            $stmt->addParam("vserverid",$vserver_id);
            return $stmt->build();
        }
        public function reboot_vserver($vserver_id=0){
            $stmt   = $this->query("admin","vserver-reboot");
            $stmt->addParam("vserverid",$vserver_id);
            return $stmt->build();
        }
        public function terminate_vserver($vserver_id=0){
            $stmt   = $this->query("admin","vserver-terminate");
            $stmt->addParam("vserverid",$vserver_id);
            $stmt->addParam("deleteclient","false");
            return $stmt->build();
        }
        public function suspend($vserver_id=0){
            $stmt   = $this->query("admin","vserver-suspend");
            $stmt->addParam("vserverid",$vserver_id);
            return $stmt->build();
        }
        public function unsuspend($vserver_id=0){
            $stmt   = $this->query("admin","vserver-unsuspend");
            $stmt->addParam("vserverid",$vserver_id);
            return $stmt->build();
        }
        public function rebuild_vserver($vserver_id=0,$template=''){
            $stmt   = $this->query("admin","vserver-rebuild");
            $stmt->addParam("vserverid",$vserver_id);
            $stmt->addParam("template",$template);
            return $stmt->build();
        }
        public function vnc_info($vserver_id=0){
            $stmt   = $this->query("admin","vserver-vnc");
            $stmt->addParam("vserverid",$vserver_id);
            return $stmt->build();
        }
        public function list_iso($type=''){
            $stmt   = $this->query("admin","listiso");
            if($type) $stmt->addParam("type",$type);
            return $stmt->build();
        }
        public function list_templates($type=''){
            $stmt   = $this->query("admin","listtemplates");
            if($type) $stmt->addParam("type",$type);
            return $stmt->build();
        }
        public function client_list(){
            $stmt   = $this->query("admin","client-list");
            return $stmt->build();
        }
        public function list_plans($type=''){
            $stmt   = $this->query("admin","listplans");
            if($type) $stmt->addParam("type",$type);
            return $stmt->build();
        }
        public function list_vservers($node_id=0){
            $stmt   = $this->query("admin","node-virtualservers");
            $stmt->addParam("nodeid",$node_id);
            return $stmt->build();
        }
        public function list_nodes_by_id($type=''){
            $stmt   = $this->query("admin","node-idlist");
            if($type) $stmt->addParam("type",$type);
            return $stmt->build();
        }
        public function list_nodes_by_name($type=''){
            $stmt   = $this->query("admin","listnodes");
            if($type) $stmt->addParam("type",$type);
            return $stmt->build();
        }
        public function list_servers($nodeid=''){
            $stmt   = $this->query("admin","node-virtualservers");
            if($nodeid) $stmt->addParam("nodeid",$nodeid);
            return $stmt->build();
        }
        public function create_client($params=[]){
            $stmt = $this->query("admin","client-create");
            foreach($params AS $k=>$v) $this->addParam($k,$v);
            return $stmt->build();
        }
        public function vserver_create($params=[]){
            $stmt = $this->query("admin","vserver-create");
            foreach($params AS $k=>$v) $this->addParam($k,$v);
            return $stmt->build();
        }
        public function vserver_hostname($vserver_id=0,$hostname=''){
            $stmt = $this->query("admin","vserver-hostname");
            $stmt->addParam("vserverid",$vserver_id);
            $stmt->addParam("hostname",$hostname);
            return $stmt->build();
        }
        public function vserver_rootpassword($vserver_id=0,$password=''){
            $stmt = $this->query("admin","vserver-rootpassword");
            $stmt->addParam("vserverid",$vserver_id);
            $stmt->addParam("rootpassword",$password);
            return $stmt->build();
        }
        public function vserver_change($vserver_id=0,$plan=''){
            $stmt = $this->query("admin","vserver-change");
            $stmt->addParam("vserverid",$vserver_id);
            $stmt->addParam("plan",$plan);
            return $stmt->build();
        }
        public function vserver_change_hdd($vserver_id=0,$value=''){
            $stmt = $this->query("admin","vserver-change-hdd");
            $stmt->addParam("vserverid",$vserver_id);
            $stmt->addParam("hdd",$value);
            return $stmt->build();
        }
        public function vserver_change_memory($vserver_id=0,$value=''){
            $stmt = $this->query("admin","vserver-change-memory");
            $stmt->addParam("vserverid",$vserver_id);
            $stmt->addParam("memory",$value);
            return $stmt->build();
        }
        public function vserver_change_cpu($vserver_id=0,$value=''){
            $stmt = $this->query("admin","vserver-change-cpu");
            $stmt->addParam("vserverid",$vserver_id);
            $stmt->addParam("cpu",$value);
            return $stmt->build();
        }
        public function vserver_change_nspeed($vserver_id=0,$value=''){
            $stmt = $this->query("admin","vserver-change-nspeed");
            $stmt->addParam("vserverid",$vserver_id);
            $stmt->addParam("customnspeed",$value);
            return $stmt->build();
        }
        public function vserver_bandwidth($vserver_id=0,$value=''){
            $stmt = $this->query("admin","vserver-bandwidth");
            $stmt->addParam("vserverid",$vserver_id);
            $stmt->addParam("limit",$value);
            return $stmt->build();
        }
        public function vserver_mainip($vserver_id=0,$value=''){
            $stmt = $this->query("admin","vserver-mainip");
            $stmt->addParam("vserverid",$vserver_id);
            $stmt->addParam("ipv4addr",$value);
            return $stmt->build();
        }
        public function vserver_console($vserver_id=0,$value='',$access='enable'){
            $stmt = $this->query("admin","vserver-console");
            $stmt->addParam("vserverid",$vserver_id);
            $stmt->addParam("access",$access);
            $stmt->addParam("time",$value);
            return $stmt->build();
        }
        public function client_key_login($username=''){
            $stmt   = $this->query("admin","client-key-login");
            $stmt->addParam("username",$username);
            return $stmt->build();
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