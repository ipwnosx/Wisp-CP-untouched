<?php
    defined('CORE_FOLDER') OR exit('You can not get in here!');
    class MailerPHP
    {
        private $instance;
        public  $error=NULL,$lang=[],$config=[],$debug_text='';

        function __construct()
        {
            $config         = Modules::Config("Mail",__CLASS__);
            $this->lang     = Modules::Lang("Mail",__CLASS__);
            $this->config   = $config;
            $debug    = false;
            $type     = $config["type"];
            $host     = $config["host"];
            $username = $config["username"];
            $password = Crypt::decode($config["password"],Config::get("crypt/user"));
            $port     = $config["port"];
            $secure   = $config["secure"];
            $fromne   = $config["fname"];
            $timeout  = 10;

            $this->instance = new PHPMailer();
            if($type == "smtp")
                $this->instance->IsSMTP();
            elseif($type == "mail")
                $this->instance->IsMail();

            $this->instance->Timeout  = $timeout;
            $this->instance->CharSet = 'utf-8';
            $this->instance->From = $username;
            $this->instance->Host = $host;
            $this->instance->Port = $port;
            $this->instance->FromName = $fromne;
            $this->instance->SetFrom($username,$fromne);
            $this->instance->WordWrap = 50;
            $this->instance->IsHTML(true);
            if($debug) $this->instance->SMTPDebug  = 1;
            $this->instance->SMTPSecure = $secure;
            $this->instance->SMTPAutoTLS = false;
            if($username !=''){
                $this->instance->SMTPAuth = true;
                $this->instance->Username = $username;
                $this->instance->Password = $password;
            }
        }

        public function testConnect($type,$host,$secure,$port,$username,$password,$fname){
            if($type == "smtp")
                $this->instance->IsSMTP();
            elseif($type == "mail")
                $this->instance->IsMail();

            $this->instance->SMTPDebug = 3;
            $this->instance->Debugoutput = function($str, $level) {
                $this->debug_text .= nl2br(mb_convert_encoding($str, "UTF-8", "auto"))."\n";
            };
            $this->instance->From = $username;
            $this->instance->Host = $host;
            $this->instance->Port = $port;
            $this->instance->FromName = $fname;
            $this->instance->SetFrom($username,$fname);
            $this->instance->SMTPSecure = $secure;
            $this->instance->SMTPAutoTLS = false;
            if($username !=''){
                $this->instance->SMTPAuth = true;
                $this->instance->Username = $username;
                $this->instance->Password = $password;
            }

            if($this->instance->smtpConnect()){
                $this->instance->smtpClose();
                return true;
            }
            $error_text = $this->instance->ErrorInfo;
            if(!$error_text) $error_text = $this->debug_text;
            $this->error = $error_text;
            if(!$this->error) $this->error = 'Connection Failed';
            return false;

        }


        public function subject($arg=''){
            $this->address_reset();
            $this->instance->Subject = $arg;
            return $this;
        }

        public function body($text='',$template=false,$variables=[],$lang='',$user=0){
            if($template) {
                $look = View::notifications("mail",$template,$text,$variables,$lang,$user);
                if($look!==false && isset($look["subject"]) && isset($look["content"])){
                    $this->subject($look["subject"]);
                    $text = $look["content"];
                }
            }
            $this->instance->Body = $text;
            return $this;
        }

        public function AddAddress($arg1='',$arg2=''){
            if(is_array($arg1)){
                if(sizeof($arg1) > 1)
                    foreach($arg1 AS $address => $name) $this->instance->addBCC($address,$name);
                else
                    foreach($arg1 AS $address => $name) $this->instance->addAddress($address,$name);
            }else
                $this->instance->AddAddress($arg1,$arg2);
            return $this;
        }

        public function addAttachment($path='',$name=''){
            $this->instance->addAttachment($path,$name);
            return $this;
        }

        public function getAddresses(){
            $addresses = $this->instance->getAllRecipientAddresses();
            return $addresses ? array_keys($addresses) : [];
        }

        public function getSubject(){
            return $this->instance->Subject;
        }

        public function getBody(){
            return $this->instance->Body;
        }

        public function address_reset(){
            return $this->instance->clearAddresses();
        }

        public function submit($isthis=false){
            $send = $this->instance->Send();
            if(!$send) $this->error = $this->instance->ErrorInfo;
            return ($isthis) ? $this : $send;
        }
    }