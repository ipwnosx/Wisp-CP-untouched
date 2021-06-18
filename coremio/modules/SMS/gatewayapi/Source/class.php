<?php
  class gatewayapiLib {
      public $utoken; // User token
	  public $error;	// This error message output
      public $timeout = 5; // This timeout
	  public $rid; 		// This Report ID
	  private $url = "https://gatewayapi.com/"; // This Data URL

      public function __construct($utoken='') {
          $this->utoken   = $utoken;
      }

      private function curl_use ($site_url,$post_data=''){
          $ch = curl_init();
          curl_setopt($ch,CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
          curl_setopt($ch, CURLOPT_URL,$site_url);
          if($post_data){
              curl_setopt($ch, CURLOPT_POST, 1);
              curl_setopt($ch, CURLOPT_POSTFIELDS,$post_data);
          }
          curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
          curl_setopt($ch, CURLOPT_HEADER, 0);
          //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
          curl_setopt($ch,CURLOPT_USERPWD, $this->utoken.":");
          curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
          $result = curl_exec($ch);
          return $result;
      }

      public function Submit($title = NULL,$message = NULL,$number = 0){
          $numbers	= is_array($number) ? $number : [$number];

          $json_data  = [
              'sender'      => $title,
              'message'     => $message,
              'recipients'  => [],
          ];
          foreach ($numbers as $msisdn) $json_data['recipients'][] = ['msisdn' => $msisdn];

          $outcome = $this->curl_use($this->url.'rest/mtsms',Utility::jencode($json_data));
          $solve = Utility::jdecode($outcome,true);
          
          if($solve){

              if(isset($solve["code"]) && isset($solve["message"])){
                  $this->error = "Error: <".$solve["code"]."> ".$solve["message"];
                  return false;
              }

              if(!isset($solve["ids"][0])){
                  $this->error = print_r($solve,true);
                  return false;
              }

              $rid 		    = $solve["ids"][0];

              $this->rid    = $rid;

              return true;

          }else{
              $this->error = "The API response could not be resolved.";
              return false;
          }
      }

      public function Balance(){
          $outcome = $this->curl_use($this->url.'rest/me');
          $solve = Utility::jdecode($outcome,true);
          if($solve){
              if(isset($solve["credit"]) && isset($solve["currency"])){
                  return [
                      'balance'  => $solve["credit"],
                      'currency' => $solve["currency"],
                  ];
              }else{
                  $this->error = "Information is missing";
                  return false;
              }
          }else{
              $this->error = "The API response could not be resolved.";
              return false;
          }
      }

      public function ReportLook($rid){

          $outcome = $this->curl_use($this->url.'rest/mtsms/'.$rid);
          $solve = Utility::jdecode($outcome,true);
          if($solve){

              if(isset($solve["code"]) && isset($solve["message"])){
                  $this->error = "Error: <".$solve["code"]."> ".$solve["message"];
                  return false;
              }

              if(isset($solve["recipients"])){

                  $result   = [
                      'enroute'     => [
                          'data' => [],
                          'count' => 0,
                      ],
                      'delivered'   => [
                          'data' => [],
                          'count' => 0,
                      ],
                      'undelivered' => [
                          'data' => [],
                          'count' => 0,
                      ],
                  ];

                  foreach($solve["recipients"] AS $recipient){
                      $number = $recipient["msisdn"];
                      if($recipient["dsnstatus"] == "ENROUTE"){
                          $result["enroute"]["data"][] = $number;
                          $result["enroute"]["count"]++;
                      }
                      elseif($recipient["dsnstatus"] == "DELIVERED"){
                          $result["delivered"]["data"][] = $number;
                          $result["delivered"]["count"]++;
                      }
                      elseif($recipient["dsnstatus"] == "UNDELIVERABLE"){
                          $result["undelivered"]["data"][] = $number;
                          $result["undelivered"]["count"]++;
                      }
                  }

                  return $result;
              }else{
                  $this->error = "not found recipients";
                  return false;
              }

              /*

              if(isset($solve["status"]) && $solve["status"] == "success"){
                  return [
                      'enroute'  => $solve["enroute"],
                      'delivered' => $solve["delivered"],
                      'undelivered' => $solve["undelivered"],
                  ];
              }else{
                  $this->error = $solve["message"];
                  return false;
              }
              */

          }else{
              $this->error = "The API response could not be resolved.";
              return false;
          }
      }

      private function download_remote_file($url, $localPathname){
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_HEADER, 0);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

          $data = curl_exec($ch);
          curl_close($ch);

          if ($data) {
              $fp = fopen($localPathname, 'wb');

              if ($fp) {
                  fwrite($fp, $data);
                  fclose($fp);
              } else {
                  fclose($fp);
                  return false;
              }
          } else {
              return false;
          }
          return true;
      }

      public function get_prices(){
          $localfnm      = __DIR__.DS."prices.xlsx";
          if(!$this->download_remote_file("https://gatewayapi.com/api/prices/list/sms/xlsx",$localfnm)){
              $this->error = "XLSX Dosyası İndirilemedi.";
              return false;
          }

          require_once CLASS_DIR.'PHPExcel'.DS.'IOFactory.php';

          $objReader = PHPExcel_IOFactory::createReader('Excel2007');
          $objReader->setReadDataOnly(true);

          $objPHPExcel = $objReader->load($localfnm);
          $objWorksheet = $objPHPExcel->getActiveSheet();

          $highestRow = $objWorksheet->getHighestRow();
          $highestColumn = $objWorksheet->getHighestColumn();
          $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
          $nrows    = array();
          $rows     = array();
          for ($row = 1; $row <= $highestRow; ++$row) {
              for ($col = 0; $col <= $highestColumnIndex; ++$col) {
                  $rows[$col] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
              }
              if($row>2){
                  $dkk = (float) str_replace(",",".",$rows[3]);
                  $eur = (float) str_replace(",",".",$rows[4]);

                  $nrows[] = [
                      'countryCode' => $rows[0],
                      'prices' => [
                          'DKK' => $dkk,
                          'EUR' => $eur,
                      ],
                  ];
              }
          }
          return $nrows;
      }

}