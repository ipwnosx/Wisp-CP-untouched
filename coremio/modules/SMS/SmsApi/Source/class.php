<?php
    class SmsApi_Library {
        public $api_token; // Api Token
        public $error;	// This error message output
        public $timeout = 200; // This timeout
        public $rid; 		// This Report ID
        private $url    = 'https://api.smsapi.com/';

        public function __construct($api_token=''){
            $this->api_token   = $api_token;
        }
        private function curl_use ($site_url,$post_data=''){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$site_url);
            if($post_data){
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS,$post_data);
            }
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch,CURLOPT_HTTPHEADER,[
                'Accept: application/json',
                'Authorization: Bearer '.$this->api_token,
            ]);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
            $result = curl_exec($ch);
            return $result;
        }
        public function Balance(){
            $outcome = $this->curl_use($this->url.'profile');
            $solve = Utility::jdecode($outcome,true);
            if($solve){
                if(isset($solve["points"])){
                    return $solve["points"];
                }else{
                    $this->error = isset($solve["message"]) ? $solve["message"] : "Failed fetch credit";
                    return false;
                }
            }else{
                $this->error = "The API response could not be resolved.";
                return false;
            }
        }
        public function Submit($title = NULL,$message = NULL,$number = 0){
            $numbers	= is_array($number) ? $number : [$number];

            $post_data  = http_build_query([
                'from'      => $title,
                'message'   => $message,
                'to'        => implode(",",$numbers),
                'encoding'  => "UTF-8",
            ]);

            $outcome = $this->curl_use($this->url.'sms.do',$post_data);

            if($outcome){
               $solve   = explode(":",$outcome);
                if($solve[0] == "OK"){
                    $this->rid = $solve[1];
                    return true;
                }else{
                    $this->error = $outcome;
                    return false;
                }
            }else{
                $this->error = "No response from API.";
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