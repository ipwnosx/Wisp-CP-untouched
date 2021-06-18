<?php
    class BulkSMS_Library {
        private $username; // Username
        private $password; // Password
        public $error;	// This error message output
        public $timeout = 200; // This timeout
        public $rid; 		// This Report ID
        private $url    = 'https://api.bulksms.com/v1/';

        public function __construct($arg='',$arg2=''){
            $this->username   = $arg;
            $this->password   = $arg2;
        }

        private function send_message ($url,$post_body=''){
            $ch = curl_init( );
            $headers = array(
                'Content-Type:application/json',
                'Authorization:Basic '. base64_encode($this->username.":".$this->password)
            );
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt ( $ch, CURLOPT_URL, $url );
            curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
            if($post_body){
                curl_setopt ( $ch, CURLOPT_POST, 1 );
                curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post_body );
            }
            // Allow cUrl functions 20 seconds to execute
            curl_setopt ( $ch, CURLOPT_TIMEOUT, $this->timeout );
            // Wait 10 seconds while trying to connect
            curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, 10 );
            $output = array();
            $output['server_response'] = curl_exec( $ch );
            $curl_info = curl_getinfo( $ch );
            $output['http_status'] = $curl_info[ 'http_code' ];
            curl_close( $ch );
            return $output;
        }

        public function Balance(){
            $outcome = $this->send_message($this->url.'profile');
            $solve = Utility::jdecode($outcome["server_response"],true);
            if($solve){
                if(isset($solve["credits"])){
                    return $solve["credits"]["balance"];
                }else{
                    $this->error = print_r($solve,true);
                    return false;
                }
            }else{
                $this->error = "The API response could not be resolved.";
                return false;
            }
        }

        public function Submit($title = NULL,$message = NULL,$number = 0){
            $numbers	= is_array($number) ? $number : [$number];
            $data       = [];

            foreach($numbers AS $number) $data[] =  ['to' => $number, 'body' => $message];
            $json_data  = Utility::jencode($data);
            $outcome = $this->send_message($this->url.'messages',$json_data);
            if($outcome['http_status'] == 201){
                $this->rid = 0;
                return true;
            }else{
                $this->error = $outcome["server_response"];
                return false;
            }
        }

        public function ReportLook($rid){
            return false;
        }

        public function get_prices(){
            return false;
        }

    }