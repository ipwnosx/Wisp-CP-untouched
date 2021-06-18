<?php
    class Clickatell_Library {
        public $api_key; // Api Key
        public $from_number; // From Number
        public $error;	// This error message output
        public $timeout = 200; // This timeout
        public $rid; 		// This Report ID
        private $url    = 'https://platform.clickatell.com/';

        public function __construct($api_key='',$from_number=''){
            $this->api_key   = $api_key;
            $this->from_number = $from_number;
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
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: '.$this->api_key,
            ]);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
            $result = curl_exec($ch);
            return $result;
        }

        public function Balance(){
            $outcome = $this->curl_use($this->url.'public-client/balance');
            $solve = Utility::jdecode($outcome,true);
            if($solve){
                if(isset($solve["balance"])){
                    return [
                        'balance'  => $solve["balance"],
                        'currency' => $solve["currency"],
                    ];
                }else{
                    $this->error = isset($solve[0]["error"]) ? $solve[0]["error"] : $solve["error"];
                    return false;
                }
            }else{
                $this->error = "The API response could not be resolved.";
                return false;
            }
        }

        public function Submit($title = NULL,$message = NULL,$number = 0){
            $numbers	= is_array($number) ? $number : [$number];

            $json_data  = Utility::jencode([
                'content'   => $message,
                'from'      => $this->from_number,
                'to'        => $numbers,
                'charset'   => 'UTF-8',
            ]);

            $outcome = $this->curl_use($this->url.'messages',$json_data);
            $solve = Utility::jdecode($outcome,true);

            if($solve){
                if(isset($solve["messages"]) && $solve["messages"]){
                    $this->rid = 0;
                    return true;
                }else{
                    $this->error = isset($solve["error"]) ? $solve["error"] : "Message could not be sent.";
                    return false;
                }
            }else{
                $this->error = "The API response could not be resolved.";
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