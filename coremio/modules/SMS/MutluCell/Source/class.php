<?php
    class MutluCellLib {
        public $username; // This username
        public $password; // This Password
        public $error;	// This error message output
        public $timeout = 200; // This timeout
        public $rid; 		// This Report ID
        private $url;		// This Data URL


        public function __construct($username, $password) {
            $this->username = $username;
            $this->password = $password;
            $this->url 	  = "https://smsgw.mutlucell.com/smsgw-ws/";
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

            $data               = '<?xml version="1.0" encoding="UTF-8"?><smspack ka="'.$this->username.'" pwd="'.$this->password.'" org="'.$title.'">
<mesaj><metin>'.html_entity_decode($message).'</metin><nums>'.implode(",",$numbers).'</nums></mesaj></smspack>';

            $outcome = $this->curl_use($this->url.'sndblkex',$data);
            if($outcome){
                $error = $this->getErrorMessage($outcome);
                if($error)
                {
                    $this->error = $error;
                    return false;
                }

                if(substr($outcome,0,1) != "$"){
                    $this->error = htmlentities($outcome);
                    return false;
                }

                $response    = substr($outcome,1);
                $response    = explode("#",$response);

                $this->rid = $response[0];

                return true;

            }elseif(!$this->error){
                $this->error = "Boş cevap döndü";
                return false;
            }

        }

        public function Balance(){
            $xml_data = '<?xml version="1.0" encoding="UTF-8"?><smskredi ka="'.$this->username.'" pwd="'.$this->password.'" />';

            $outcome = $this->curl_use($this->url.'gtcrdtex',$xml_data);
            if($outcome){
                if($this->error = $this->getErrorMessage($outcome)) return false;

                if(substr($outcome,0,1) == "$") $outcome = substr($outcome,1);

                return $outcome;

            }else
                return 0;
        }

        public function ReportLook($rid){

            $xml_data = '<?xml version="1.0" encoding="UTF-8"?><smsrapor ka="'.$this->username.'" pwd="'.$this->password.'" id="'.$rid.'" />';

            $report = $this->curl_use($this->url.'gtblkrprtex',$xml_data);
            if(!$report){
                $this->error = 'Rapor verisi boş döndü';
                return false;
            }

            if($report){

                if($this->error = $this->getErrorMessage($report)) return false;

                $iletilen   = [];
                $bekleyen   = [];
                $hatali     = [];

                $report     = explode("\n",$report);

                if($report){
                    foreach($report AS $row){
                        if(strlen($row) >= 5){
                            $parse  = explode(" ",$row);
                            $num    = $parse[0];
                            $stat   = $parse[1];

                            if($stat == 2 || $stat == 3)
                                $iletilen[] = $num;
                            elseif($stat == 1 || $stat == 4)
                                $bekleyen[] = $num;
                            else
                                $hatali[] = $num;
                        }
                    }
                }

                return [
                    'iletilen' => $iletilen,
                    'bekleyen' => $bekleyen,
                    'hatali'   => $hatali,
                ];
            }else return false;
        }

        private function getErrorMessage($code=0){
            if($code == 20)
                return 'Post edilen xml eksik veya hatalı.';
            elseif($code == 23)
                return 'Kullanıcı adı ya da parolanız hatalı';
            elseif($code == 30)
                return 'Hesap Aktivasyonu sağlanmamış.';
            else
                return false;
        }
    }