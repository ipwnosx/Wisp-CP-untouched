<?php

    class Clickatell
    {
        public $international=true,$lang,$config,$error;
        private $instance,$title,$body,$numbers=[];
        public function __construct($external_config=[])
        {
            if(!class_exists("Clickatell_Library")) include __DIR__.DS."Source".DS."class.php";
            $config             = Modules::Config("SMS",__CLASS__);
            $this->config       = $config;
            $this->lang         = Modules::Lang("SMS",__CLASS__);
            $external           = $external_config ? $external_config : [];
            $config             = array_merge($config,$external);
            $this->config       = $config;
            $api_key            = $config["api-key"];
            $from_number        = $config["from-number"];
            $this->instance = new Clickatell_Library($api_key,$from_number);
        }

        public function title($arg=''){
            $this->title = $arg;
            return $this;
        }

        public function body($text='',$template=false,$variables=[],$lang='',$user=0){
            $this->numbers_reset();
            if($template) {
                $look = View::notifications("sms",$template,$text,$variables,$lang,$user);
                if($look!==false && isset($look["content"])){
                    if(isset($look["title"]))
                        $this->title($look["title"]);
                    $text = $look["content"];
                }
            }

            if(!class_exists("Money")) Helper::Load("Money");
            $currencies = Money::getCurrencies();

            foreach($currencies AS $row){
                if(($row["prefix"] && substr($row["prefix"],-1,1) == ' ') || ($row["suffix"] && substr($row["suffix"],0,1) == ' '))
                    $code = $row["code"];
                else
                    $code = $row["prefix"] ? $row["code"].' ' : ' '.$row["code"];

                $row["prefix"] = Utility::text_replace($row["prefix"],[' ' => '']);
                $row["suffix"] = Utility::text_replace($row["suffix"],[' ' => '']);
                if(!Validation::isEmpty($row["prefix"]) && $row["prefix"])
                    $text = Utility::text_replace($text,[$row["prefix"] => $code]);
                elseif(!Validation::isEmpty($row["suffix"]) && $row["suffix"])
                    $text = Utility::text_replace($text,[$row["suffix"] => $row["code"]]);
            }

            $this->body = $text;
            return $this;
        }

        public function AddNumber($arg=0,$cc=NULL){
            if(!is_array($arg)){
                if($cc != NULL) $arg = [$cc."|".$arg];
                else $arg = [$arg];
            }
            foreach($arg AS $num){
                if(strstr($num,"|")){
                    $split  = explode("|",$num);
                    $cc     = $split[0];
                    $no     = $split[1];
                    $num    = $cc.$no;
                }
                if(substr($num,0,1) != "+") $num = "+".$num;
                if(!array_search($num,$this->numbers)) $this->numbers[] = $num;
            }
            return $this;
        }

        public function getBalance(){
            $balance = $this->instance->Balance();

            if(!$balance && $this->instance->error){
                $this->error = $this->instance->error;
                return false;
            }
            return $balance;
        }

        public function getReportID(){
            return $this->instance->rid;
        }

        public function getReport($id=0){
            return false;
        }

        public function getNumbers(){
            return $this->numbers;
        }

        public function getTitle(){
            return $this->title;
        }

        public function getBody(){
            return $this->body;
        }

        public function getError(){
            return $this->error;
        }

        public function numbers_reset(){
            return $this->numbers = array();
        }

        public function submit($isthis=false){

            if(Validation::isEmpty($this->body)){
                $this->error = "Message content can not be left blank!";
                return false;
            }

            if(!$this->numbers){
                $this->error = "Enter the phone number to be sent.";
                return false;
            }

            $send = $this->instance->Submit($this->title,$this->body,$this->numbers);
            $this->error = $this->instance->error;

            if(!$send) echo (ERROR_DEBUG) ? $this->getError() : NULL;
            return ($isthis) ? $this : $send;
        }

        public function get_prices(){
            return false;
        }

    }