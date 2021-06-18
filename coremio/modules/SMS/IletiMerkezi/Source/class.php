<?php
    class IletiMerkeziLib {
        public $username; // This username
        public $password; // This Password
        public $error;	// This error message output
        public $timeout = 200; // This timeout
        public $rid; 		// This Report ID
        private $url;		// This Data URL


        public function __construct($username, $password) {
            $this->username = $username;
            $this->password = $password;
            $this->url 	  = "https://api.iletimerkezi.com/v1/";
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

            $receipents         = '';
            foreach($numbers AS $number) $receipents .= ' <number>'.$number.'</number>';

            $data               = '<request>
        <authentication>
                <username>'.$this->username.'</username>
                <password>'.$this->password.'</password>
        </authentication>
        <order>
                <sender>'.$title.'</sender>
                <message>
                        <text><![CDATA['.$message.']]></text>
                        <receipents>
                        '.$receipents.'
                        </receipents>
                </message>
        </order>

</request>';

            $outcome = $this->curl_use($this->url.'send-sms',$data);
            if($outcome){
                $parse      = Utility::xdecode($outcome,true);

                if(!isset($parse["status"]["code"])){
                        $this->error = 'Apiden gelen xml yanıtı ayrıştırılamadı';
                        return false;
                }

                if($parse["status"]["code"] != "200"){
                    $this->error = $parse["status"]["message"];
                    return false;
                }

                $this->rid = $parse["order"]["id"];

                return true;

            }elseif(!$this->error){
                $this->error = "Boş cevap döndü";
                return false;
            }

        }

        public function Balance(){
            $xml_data = '<request>
        <authentication>
                <username>'.$this->username.'</username>
                <password>'.$this->password.'</password>
        </authentication>

</request>';

            $outcome = $this->curl_use($this->url.'get-balance',$xml_data);
            if($outcome){
                $parse      = Utility::xdecode($outcome,true);

                if(!isset($parse["status"]["code"])){
                    $this->error = 'Apiden gelen xml yanıtı ayrıştırılamadı';
                    return 0;
                }

                if($parse["status"]["code"] != "200"){
                    $this->error = $parse["status"]["message"];
                    return 0;
                }

                return (int) $parse["balance"]["sms"];

            }else
                return 0;
        }

        public function report_page($rid=0,$page=1){
            $xml_data = '<request>
        <authentication>
                <username>'.$this->username.'</username>
                <password>'.$this->password.'</password>
        </authentication>
        <order>
                <id>'.$rid.'</id>
                <page>'.$page.'</page>
                <rowCount>1000</rowCount>
        </order>
</request>';

            $outcome = $this->curl_use($this->url.'get-report',$xml_data);
            if($outcome){
                $parse      = Utility::xdecode($outcome,true);

                if(!isset($parse["status"]["code"])){
                    $this->error = 'Apiden gelen xml yanıtı ayrıştırılamadı';
                    return false;
                }

                if($parse["status"]["code"] != "200"){
                    $this->error = $parse["status"]["message"];
                    return false;
                }

                if(isset($parse["order"]["message"])){
                    $result = $parse["order"]["message"];
                    if(sizeof($result) == 1000){
                        $get    = $this->report_page($rid,$page+1);
                        if($get) $result = array_merge($result,$get);
                    }
                    return $result;
                }else
                    return [];

            }else{
                $this->error = 'Rapor verisi boş döndü';
                return false;
            }
        }

        public function ReportLook($rid){

            $reports        = $this->report_page($rid);
            if($reports){
                $iletilen   = [];
                $bekleyen   = [];
                $hatali     = [];

                foreach($reports AS $row){
                    if($row){
                        $_s = $row["status"];
                        if($_s == 111 || $_s == 200 || $_s == 114)
                            $iletilen[] = $row["number"];
                        elseif($_s == 110 || $_s == 113)
                            $bekleyen[] = $row["number"];
                        else
                            $hatali[] = $row["number"];
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