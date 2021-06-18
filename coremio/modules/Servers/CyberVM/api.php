<?php
    class VMPanel_API {

        var $apiusernme = '';
        var $apipassword = '';
        var $ip = '';
        var $port = 873;
        var $protocol = 'http';
        var $error = NULL;
        var $query      = '';
        var $params     = false;

        /**
         * Contructor
         *
         * @param        string $ip IP of the VMPanel
         * @param $apiusernme
         * @param        string $apipassword The API Password of your VMPanel
         * @param        int $port (Optional) The port to connect to. Port 873 is the default.(Other Ports : 2021 , 2022 , 2023 , 2082 , 2222 )
         * @param bool $protocol
         * @return VMPanel_API
         * @internal param string $apiusername The API Username of your VMPanel
         */
        function __construct($ip, $apiusernme, $apipassword, $port = 873,$protocol=false){
            $this->apiusernme = $apiusernme;
            $this->apipassword = $apipassword;
            $this->ip = $ip;
            $this->port = $port;
            $this->protocol = $protocol ? "https" : "http";
        }

        /**
         * Unserializes a string
         *
         * @param        string $str The serialized string
         * @return       array The unserialized array on success OR false on failure
         */
        public function _unserialize($str){
            $var        = unserialize($str);

            Modules::save_log("Servers","CyberVM",isset($this->params["action"]) ? $this->params["action"] : 'unknown',$this->params,$str,$this->error ? $this->error : $var);

            return empty($var) ? [] : $var;
        }

        public function cyberhttpPost($params)
        {
            $url = $this->protocol."://".$this->ip.":".$this->port."/?loadapi=1&";

            $params['api'] = true ;
            $params['REMOTE_ADDR'] = $_SERVER['REMOTE_ADDR'] ;
            $params['SERVER_ADDR'] = $_SERVER['SERVER_ADDR'] ;
            $params['HTTP_HOST'] = $_SERVER['HTTP_HOST'] ;
            $params['SERVER_NAME'] = $_SERVER['SERVER_NAME'] ;
            $params['MODULE_VER'] = '2.7' ;

            $ch = curl_init();

            curl_setopt($ch,CURLOPT_URL,$url);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($ch,CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_POST,true);
            curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($params));

            $output=curl_exec($ch);

            if(curl_errno($ch)) $this->error = "cURL Error( ".curl_error($ch)." )";

            curl_close($ch);
            $this->query    = $url;
            $this->params   = $params;
            return $output;
        }

        public function checklogin()
        {

            $postfilds = array();
            $postfilds['user'] = $this->apiusernme ;
            $postfilds['pass'] = $this->apipassword ;
            $postfilds['action'] = 'check' ;

            $data = $this->cyberhttpPost($postfilds);

            $data = $this->_unserialize($data);

            if($data['ok'] == true) return true;

            if(isset($data["des"]) && $data["des"]) $this->error = strip_tags($data["des"]);

            return false ;
        }

        public function isolist()
        {


            $postfilds = array();
            $postfilds['user'] = $this->apiusernme ;
            $postfilds['pass'] = $this->apipassword ;
            $postfilds['action'] = 'isolist' ;

            $data = $this->cyberhttpPost($postfilds);
            $data = $this->_unserialize($data);

            return $data ;
        }

        public function serverlist()
        {


            $postfilds = array();
            $postfilds['user'] = $this->apiusernme ;
            $postfilds['pass'] = $this->apipassword ;
            $postfilds['action'] = 'serverlist' ;

            $data = $this->cyberhttpPost($postfilds);
            $data = $this->_unserialize($data);

            return $data ;
        }


        public function createvps($useremail,$userpassword,$firstname,$lastname,$hostname,$server,$ram,$space,$cpumhz,$bandwidth,$vnc,$datastore,$os,$useros,$cores='1',$nic_type='e1000',$osreinstall='0',$resouce_pools='',$iso='',$prefix='')
        {


            $postfilds = array();
            $postfilds['user'] = $this->apiusernme ;
            $postfilds['pass'] = $this->apipassword ;
            $postfilds['action'] = 'create' ;
            $postfilds['prefix'] = $prefix ; // Prefix For Create VPS

            $data['email'] = $useremail ;
            $data['userpassword'] = $userpassword ;
            $data['firstname'] = $firstname ;
            $data['lastname'] = $lastname ;
            $data['hostname'] = $hostname ;
            $data['server'] = $server ;
            $data['ram'] = $ram ;
            $data['space'] = $space ;
            $data['cpu'] = $cpumhz ;
            $data['bandwidth'] = $bandwidth ;
            $data['os'] = $os ;
            $data['iso'] = $iso;
            if(!empty($vnc)){
                $data['vnc'] = 'on' ;
            }else{
                $data['vnc'] = '' ;
            }
            $data['ds'] = $datastore ;
            $data['useros'] = $useros ;
            $data['cores'] = $cores ;
            $data['nic_type'] = $nic_type ;
            $data['osreinstall'] = $osreinstall ;
            $data['resouce_pools'] = $resouce_pools ;

            $postfilds['data'] = base64_encode(serialize($data)); ;


            $data = $this->cyberhttpPost($postfilds);
            $data = $this->_unserialize($data);


            return $data;
        }

        public function rebuildvps($vmid,$newos=''){


            $postfilds = array();
            $postfilds['user'] = $this->apiusernme ;
            $postfilds['pass'] = $this->apipassword ;
            $postfilds['action'] = 'rebuild' ;
            $postfilds['vmid'] = $vmid ;

            $data['newos'] = $newos ;

            $postfilds['data'] = base64_encode(serialize($data)); ;


            $data = $this->cyberhttpPost($postfilds);
            $data = $this->_unserialize($data);


            return $data;
        }


        public function getAllVmInfo()
        {


            $postfilds = array();
            $postfilds['user'] = $this->apiusernme ;
            $postfilds['pass'] = $this->apipassword ;
            $postfilds['action'] = 'vpslist' ;

            $data = $this->cyberhttpPost($postfilds);
            $data = $this->_unserialize($data);

            return $data ;
        }

        public function getSummaryInfo( $vmid )
        {

            $postfilds = array();
            $postfilds['user'] = $this->apiusernme ;
            $postfilds['pass'] = $this->apipassword ;
            $postfilds['action'] = 'getsummary' ;
            $postfilds['datatype'] = 'array' ;
            $postfilds['vmid'] = $vmid ;

            $data = $this->cyberhttpPost($postfilds);

            $data = $this->_unserialize($data);

            return $data;
        }

        public function getGuestInfo( $vmid ){

            $postfilds = array();
            $postfilds['user'] = $this->apiusernme ;
            $postfilds['pass'] = $this->apipassword ;
            $postfilds['action'] = 'getguestinfo' ;
            $postfilds['datatype'] = 'array' ;
            $postfilds['vmid'] = $vmid ;

            $data = $this->cyberhttpPost($postfilds);

            $data = $this->_unserialize($data);

            return $data ;
        }

        public function getDataStoreInfo( $vmid )
        {

            $postfilds = array();
            $postfilds['user'] = $this->apiusernme ;
            $postfilds['pass'] = $this->apipassword ;
            $postfilds['datatype'] = 'array' ;
            $postfilds['action'] = 'getdatastore' ;
            $postfilds['vmid'] = $vmid ;

            $data = $this->cyberhttpPost($postfilds);

            $data = $this->_unserialize($data);

            return $data ;
        }
        //// Open VNC Ports On ESXI //////
        public function gdbserver( $vmid )
        {

            $postfilds = array();
            $postfilds['user'] = $this->apiusernme ;
            $postfilds['pass'] = $this->apipassword ;
            $postfilds['action'] = 'gdbserver' ;
            $postfilds['vmid'] = $vmid ;

            $data = $this->cyberhttpPost($postfilds);

            $data = $this->_unserialize($data);

            if($data['status'] == 'action-success' ){
                return true;
            }

            return false;

        }

        public function getvncconf( $vmid ){
            $postfilds = array();
            $postfilds['user'] = $this->apiusernme ;
            $postfilds['pass'] = $this->apipassword ;
            $postfilds['action'] = 'getvncconf' ;
            $postfilds['vmid'] = $vmid ;

            $data = $this->cyberhttpPost($postfilds);


            $data = $this->_unserialize($data);

            return $data ;
        }

        public function getnovnc( $vmid ){

            $postfilds = array();
            $postfilds['user'] = $this->apiusernme ;
            $postfilds['pass'] = $this->apipassword ;
            $postfilds['action'] = 'novnc' ;
            $postfilds['vmid'] = $vmid ;

            $data = $this->cyberhttpPost($postfilds);
            $data = $this->_unserialize($data);

            return $data ;
        }

        public function enablevnc( $vmid ){


            $postfilds = array();
            $postfilds['user'] = $this->apiusernme ;
            $postfilds['pass'] = $this->apipassword ;
            $postfilds['action'] = 'setvncconf' ;
            $postfilds['vmid'] = $vmid ;

            $data = $this->cyberhttpPost($postfilds);
            $data = $this->_unserialize($data);

            if($data['enabled'] == "TRUE"){
                return true;
            }
            return false;
        }


        public function resetvncpass( $vmid )
        {


            $postfilds = array();
            $postfilds['user'] = $this->apiusernme ;
            $postfilds['pass'] = $this->apipassword ;
            $postfilds['action'] = 'setvncpass' ;
            $postfilds['vmid'] = $vmid ;

            $data = $this->cyberhttpPost($postfilds);
            $data = $this->_unserialize($data);

            if($data['enabled'] == "TRUE"){
                return true;
            }
            return false;

        }

        public function poweroff( $vmid ){

            $postfilds = array();
            $postfilds['user'] = $this->apiusernme ;
            $postfilds['pass'] = $this->apipassword ;
            $postfilds['action'] = 'poweroff' ;
            $postfilds['vmid'] = $vmid ;

            $data = $this->cyberhttpPost($postfilds);
            $data = $this->_unserialize($data);

            if($data['status'] == "action-success"){
                return true ;
            }

            return false;
        }

        public function poweron( $vmid )
        {

            $postfilds = array();
            $postfilds['user'] = $this->apiusernme ;
            $postfilds['pass'] = $this->apipassword ;
            $postfilds['action'] = 'poweron' ;
            $postfilds['vmid'] = $vmid ;

            $data = $this->cyberhttpPost($postfilds);
            $data = $this->_unserialize($data);

            if($data['status'] == "action-success"){
                return true ;
            }

            return false;
        }

        public function resetvps( $vmid )
        {

            $postfilds = array();
            $postfilds['user'] = $this->apiusernme ;
            $postfilds['pass'] = $this->apipassword ;
            $postfilds['action'] = 'reset' ;
            $postfilds['vmid'] = $vmid ;

            $data = $this->cyberhttpPost($postfilds);
            $data = $this->_unserialize($data);

            if($data['status'] == "action-success"){
                return true ;
            }

            return false;
        }

        public function suspend( $vmid )
        {

            $postfilds = array();
            $postfilds['user'] = $this->apiusernme ;
            $postfilds['pass'] = $this->apipassword ;
            $postfilds['action'] = 'suspend' ;
            $postfilds['vmid'] = $vmid ;

            $data = $this->cyberhttpPost($postfilds);
            $data = $this->_unserialize($data);

            if($data['status'] == "action-success"){
                return true ;
            }

            return false;
        }

        public function unsuspend( $vmid )
        {

            $postfilds = array();
            $postfilds['user'] = $this->apiusernme ;
            $postfilds['pass'] = $this->apipassword ;
            $postfilds['action'] = 'unsuspend' ;
            $postfilds['vmid'] = $vmid ;

            $data = $this->cyberhttpPost($postfilds);
            $data = $this->_unserialize($data);

            if($data['status'] == "action-success"){
                return true ;
            }

            return false;
        }

        public function rebootos( $vmid )
        {

            $postfilds = array();
            $postfilds['user'] = $this->apiusernme ;
            $postfilds['pass'] = $this->apipassword ;
            $postfilds['action'] = 'reboot' ;
            $postfilds['vmid'] = $vmid ;

            $data = $this->cyberhttpPost($postfilds);
            $data = $this->_unserialize($data);

            if($data['status'] == "action-success"){
                return true ;
            }

            return false;
        }


        public function shutdownos( $vmid )
        {

            $postfilds = array();
            $postfilds['user'] = $this->apiusernme ;
            $postfilds['pass'] = $this->apipassword ;
            $postfilds['action'] = 'shutdown' ;
            $postfilds['vmid'] = $vmid ;

            $data = $this->cyberhttpPost($postfilds);
            $data = $this->_unserialize($data);

            if($data['status'] == "action-success"){
                return true ;
            }

            return false;
        }

        public function mountvmtool( $vmid )
        {

            $postfilds = array();
            $postfilds['user'] = $this->apiusernme ;
            $postfilds['pass'] = $this->apipassword ;
            $postfilds['action'] = 'vmtool' ;
            $postfilds['vmid'] = $vmid ;

            $data = $this->cyberhttpPost($postfilds);
            $data = $this->_unserialize($data);

            if($data['status'] == "action-success"){
                return true ;
            }

            return false;
        }

        public function getstate( $vmid )
        {

            $postfilds = array();
            $postfilds['user'] = $this->apiusernme ;
            $postfilds['pass'] = $this->apipassword ;
            $postfilds['action'] = 'getstatus' ;
            $postfilds['datatype'] = 'array' ;
            $postfilds['vmid'] = $vmid ;

            $data = $this->cyberhttpPost($postfilds);
            $data = $this->_unserialize($data);

            if(!empty($data)){
                return $data ;
            }

            return false;
        }

        public function getvminfo( $vmid )
        {
            $postfilds = array();
            $postfilds['user'] = $this->apiusernme ;
            $postfilds['pass'] = $this->apipassword ;
            $postfilds['action'] = 'importantinfo' ;
            $postfilds['vmid'] = $vmid ;

            $data = $this->cyberhttpPost($postfilds);
            $data = $this->_unserialize($data);

            if(empty($data)){
                return true ;
            }

            if(isset($data["powerstate"]) && trim($data["powerstate"]) == "UnKnown") return false;

            $info = array( );
            $info['vmid'] = $vmid;
            $info['memorySize'] = intval( $data['ram'] );
            $info['memoryUsage'] = intval( $data['memoryUsage'] );
            $info['cpuMax'] = intval( $data['cpu'] );
            $info['bootTime'] = $data['bootTime'];

            $info['os'] = $data['os'];
            $info['osFullName'] = trim( $data['os_name'] );
            $info['hostname'] = $data['hostname'];
            $info['vmPathName'] = $data['vmPathName'];
            $info['ip'] = $data['ip'];

            $info['powerState'] = strtolower( trim( $data['powerstate'] ) );
            $info['cpuUsage'] = intval( $data['cpuUsage'] );
            $info['uptime'] = intval( $data['uptime'] );

            $info['hd'] = $data['disks']['size'];
            $info['hardUsage'] = $data['hardUsage'];
            $info['hardFree'] = round($info['hd']-$info['hardUsage']);
            $info['hardNums'] = $data['hardNums'];

            return $info;
        }

        public function terminatevps( $vmid )
        {

            $postfilds = array();
            $postfilds['user'] = $this->apiusernme ;
            $postfilds['pass'] = $this->apipassword ;
            $postfilds['action'] = 'terminate' ;
            $postfilds['vmid'] = $vmid ;

            $data = $this->cyberhttpPost($postfilds);
            $data = $this->_unserialize($data);

            if($data['status'] == "action-success"){
                return true ;
            }

            return $data['status'];
        }

    }