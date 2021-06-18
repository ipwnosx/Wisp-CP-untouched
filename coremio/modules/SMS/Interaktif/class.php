<?php
  class InteraktifLib {

      public $username; // This username
      public $password; // This Password
      public $secret; // This Secret
      public $error;	// This error message output
      public $timeout = 200; // This timeout
      public $rid; 		// This Report ID
      private $url;		// This Data URL

      public function __construct($username, $password,$secret='') {
          $this->username = $username;
          $this->password = $password;
          $this->secret   = $secret;
          $this->url 	  = "http://panel.1sms.com.tr:8080/";
      }
      private function curl_use ($site_url,$post_data=''){
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL,$site_url);
          if($post_data){
              curl_setopt($ch, CURLOPT_POST, 1);
              curl_setopt($ch, CURLOPT_POSTFIELDS,$post_data);
              curl_setopt($ch,CURLOPT_HTTPHEADER,array("Content-Type: text/xml; charset=UTF-8"));
          }
          curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
          curl_setopt($ch, CURLOPT_HEADER, 0);
          curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
          curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
          $result = curl_exec($ch);
          curl_close($ch);
          return $result;
      }
      public function Submit($title = NULL,$message = NULL,$number = 0){
          if(is_array($number)){
              $numbers = $number;
          }else{
              $numbers = array($number);
          }

          $password = $this->secret ? $this->secret : $this->password;

          $postData  = "".
              "<sms>".
              "<username>".$this->username."</username>".
              "<password>".$password."</password>".
              "<header>".trim($title)."</header>".
              "<validity>2880</validity>".
              "<message>".
              "<gsm>";

          foreach($numbers AS $number) $postData .= "<no>".$number."</no>";
          $postData .= "".
              "</gsm>".
              "<msg><![CDATA[".$message."]]></msg>".
              "</message>".
              "</sms>";

          $outcome = $this->curl_use($this->url.'api/smspost/v1',$postData);
          if($outcome){
              $response = explode(" ",$outcome);
              if($response[0] == "00"){
                  $this->rid = $response[1];
                  return true;
              }else{
                  $this->error = "Gönderim Yapılamadı. Hata Kodu: ".$response[0];
                  return false;
              }
          }else{
              $this->error = "Servis sağlayıcı tarafından cevap dönmedi.";
              return false;
          }
      }
      public function Balance(){
          $data = http_build_query([
              'username' => $this->username,
              'password' => $this->secret ? $this->secret : $this->password,
          ]);

          $outcome      = $this->curl_use($this->url.'api/credit/v1?'.$data);
          $response     = explode(" ",$outcome);
          if($response[0] == "00"){
              return $response[1];
          }else{
              $this->error = "Bakiye çekilemedi. Hata Kodu: ".$response[0];
              return false;
          }
      }
      public function ReportLook($rid){

          $data = http_build_query([
              'username' => $this->username,
              'password' => $this->secret ? $this->secret : $this->password,
              'id'       => $rid,
          ]);

          $outcome      = $this->curl_use($this->url.'api/dlr/v1?'.$data);
          if(strlen($outcome)== 2){
              $this->error = "Rapor Sorgulanamadı. Hata Kodu: ".$outcome;
              return false;
          }else
              return $outcome;
	}
      public function getOrigins(){

          $data = http_build_query([
              'username' => $this->username,
              'password' => $this->secret ? $this->secret : $this->password,
          ]);

          $outcome      = $this->curl_use($this->url.'api/originator/v1?'.$data);
          if(strlen($outcome)== 2){
              $this->error = "Başlık Sorgulanamadı. Hata Kodu: ".$outcome;
              return false;
          }else{
              $response     = explode(" ",$outcome);
              if($response[0] == "00") return explode("|",$response[1]);
              else $this->error = "Başlık Sorgulanamadı. Hata Kodu: ".$outcome;
          }
	}
}