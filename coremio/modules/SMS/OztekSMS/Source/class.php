<?php
    class OztekSMSLib {
        public $username; // This username
        public $username_id; // This username ID
        public $password; // This Password
        public $error;	// This error message output
        public $timeout = 200; // This timeout
        public $rid; 		// This Report ID
        private $url;		// This Data URL


        public function __construct($username_id,$username, $password) {
            $this->username_id = $username_id;
            $this->username = $username;
            $this->password = $password;
            $this->url 	  = "http://www.ozteksms.com/panel/";
        }

        private function curl_use($site_url='',$post_data=''){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$site_url);
            if($post_data){
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS,$post_data);
            }
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
            $result = curl_exec($ch);
            if(curl_errno($ch)){
                $this->error = curl_error($ch);
                $result = false;
            }
            return $result;
        }


        public function Submit($title = NULL,$message = NULL,$numbers = []){
            if(!is_array($numbers)) $numbers = [$numbers];

            $xmlString='data=<sms>
<kno>'. $this->username_id .'</kno> 
<kulad>'. $this->username .'</kulad> 
<sifre>'.$this->password .'</sifre>    
<gonderen>'.  $title .'</gonderen> 
<mesaj>'. $message .'</mesaj> 
<numaralar>'.implode(",",$numbers).'</numaralar>
<tur>Normal</tur>
</sms>';


            $outcome = $this->curl_use($this->url.'smsgonder1Npost.php',$xmlString);
            if($outcome){
                $parse      = explode(":",$outcome);
                if($parse[0] != 1){
                    $this->error = $parse[1];
                    return false;
                }

                $this->rid = $parse[1];

                return true;
            }elseif(!$this->error){
                $this->error = "Boş cevap döndü";
                return false;
            }

        }

        public function Balance(){
           return 0;
        }

        public function ReportLook($rid){
            $xml_data = 'data=<smsrapor>
<kulad>'. $this->username .'</kulad> 
<sifre>'. $this->password .'</sifre> 
<ozelkod>'.$rid .'</ozelkod>    
</smsrapor>';

            $reports    = [];

            $outcome = $this->curl_use($this->url.'smstakippost.php',$xml_data);
            if($outcome){
                $reports        = explode("<br>",$outcome);
            }else{
                $this->error = 'Rapor verisi boş döndü';
                return false;
            }
            if($reports){
                $iletilen   = [];
                $bekleyen   = [];
                $hatali     = [];

                foreach($reports AS $row){
                    if(strlen($row) >= 5){
                        $split  = explode(" ",$row);
                        $num    = $split[0];
                        $s      = isset($split[1]) ? $split[1] : 0;

                        if($s == 0 || $s == 3) $bekleyen[] = $num;
                        elseif($s == 1) $iletilen[] = $num;
                        elseif($s == 2) $hatali[] = $num;
                    }
                }
                return [
                    'iletilen' => $iletilen,
                    'bekleyen' => $bekleyen,
                    'hatali'   => $hatali,
                ];
            }else return false;
        }
    }