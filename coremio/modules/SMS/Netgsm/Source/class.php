<?php
    class NetgsmLibrary {
        public $username; // This username
        public $password; // This Password
        public $error;	// This error message output
        public $timeout = 200; // This timeout
        public $rid; 		// This Report ID
        private $url;		// This Data URL


        public function __construct($username, $password) {
            $this->username = $username;
            $this->password = $password;
            $this->url 	  = "https://api.netgsm.com.tr/";
        }

        /*
        * variable: site_url (string value)
        * variable: post_data: (array and string value)
        @return: (string value)
        */
        private function curl_use ($site_url,$post_data){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$site_url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$post_data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
            $result = curl_exec($ch);
            return $result;
        }


        public function Submit($title = NULL,$message = NULL,$number = 0,$kara_liste = NULL){
            if(is_array($number)){
                $numbers = $number;
            }else{
                $numbers = array($number);
            }

            $xml_data  = '<?xml version="1.0" encoding="UTF-8"?>'.
                '<mainbody>'.
                '<header>'.
                '<company>Netgsm</company>'.
                '<usercode>'.$this->username.'</usercode>'.
                '<password>'.$this->password.'</password>'.
                '<startdate></startdate>'.
                '<stopdate></stopdate>'.
                '<type>1:n</type>'.
                '<msgheader>'.$title.'</msgheader>'.
                '</header>'.
                '<body><msg><![CDATA['.str_replace(EOL,"\\n",$message).']]></msg>';
            foreach($numbers AS $number){
                $xml_data .= '<no>'.$number.'</no>';
            }
            $xml_data .= '</body></mainbody>';

            $outcome = $this->curl_use($this->url.'sms/send/xml',$xml_data);
            if($outcome){
                $exp    = explode(" ",$outcome);
                if($exp[0] == "00"){
                    $this->rid = $exp[1];
                    return true;
                }elseif($exp[0] == "30"){
                    $this->error = "Geçersiz kullanıcı adı , şifre veya kullanıcının API erişim izni yok.";
                    return false;
                }elseif($exp[0] == "40"){
                    $this->error = "Mesaj başlığınızın (gönderici adınızın) sistemde tanımlı değildir. ::".$title.":: ";
                    return false;
                }else{
                    $this->error = "Bilinmeyen hata : ".$exp[0];
                    return false;
                }
            }else{
                $this->error = "Boş cevap döndü.";
                return false;
            }

        }

        public function Balance(){
            $xml_data = '<?xml version=\'1.0\'?><mainbody><header><company>Netgsm</company><usercode>'.$this->username.'</usercode><password>'.$this->password.'</password><stip>1</stip></header></mainbody>';

            $outcome = $this->curl_use($this->url.'balance/list/xml',$xml_data);
            if($outcome){

                if($outcome == 30){
                    $this->error = "Geçersiz kullanıcı adı , şifre veya kullanıcı API erişim izini bulunmuyor.";
                    return false;
                }
                $exp    = explode(" ",$outcome);
                return $exp[0];
            }else
                return 0;
        }

        public function ReportLook($rid){
            $data = [
                'usercode' => $this->username,
                'password' => $this->password,
                'bulkid'   => $rid,
                'type'     => 0,
                'version'  => 2,
            ];
            $outcome = $this->curl_use($this->url.'httpbulkrapor.asp?'.http_build_query($data),false);

            if($outcome){
                $list       = explode("<br>",$outcome);
                $iletilen   = [];
                $bekleyen   = [];
                $hatali     = [];

                foreach($list AS $row){
                    if($row){
                        $split  = explode(" ",$row);
                        $durum  = $split[1];
                        $numara = $split[0];
                        if($durum == 0)
                            $bekleyen[] = $numara;
                        elseif($durum == 1)
                            $iletilen[] = $numara;
                        elseif($durum != 100)
                            $hatali[] = $numara;
                    }
                }
                return [
                    'iletilen' => $iletilen,
                    'bekleyen' => $bekleyen,
                    'hatali'   => $hatali,
                ];
            }else{
                $this->error = "Sonuç boş döndü.";
                return false;
            }

            //return $outcome;
        }
    }