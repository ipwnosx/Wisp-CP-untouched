<?php
    defined('CORE_FOLDER') OR exit('You can not get in here!');

    include __DIR__.DS."source".DS."Client.php";
    include __DIR__.DS."source".DS."Config.php";
    include __DIR__.DS."source".DS."Request.php";
    include __DIR__.DS."source".DS."Resources.php";
    include __DIR__.DS."source".DS."Response.php";

    use \Mailjet\Resources;

    class Mailjet
    {

        private $addresses=[],$addressesx=[],$public_key,$private_key,$subject,$body,$attachments=[];
        public  $error=NULL,$lang=[],$config=[];

        function __construct()
        {
            $config          = Modules::Config("Mail",__CLASS__);
            $this->lang      = Modules::Lang("Mail",__CLASS__);
            $this->config    = $config;

            $key            = Config::get("crypt/user");

            if($this->config["api-key-public"])
                $this->config["api-key-public"] = Crypt::decode($this->config["api-key-public"],$key);

            if($this->config["api-key-private"])
                $this->config["api-key-private"] = Crypt::decode($this->config["api-key-private"],$key);

            $this->public_key = $this->config["api-key-public"];
            $this->private_key = $this->config["api-key-private"];
        }

        public function subject($arg=''){
            $this->address_reset();
            $this->subject = $arg;
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
            $this->body = $text;
            return $this;
        }

        public function AddAddress($arg1='',$arg2=''){
            if(is_array($arg1)){
                foreach($arg1 AS $address => $name){
                    $this->addresses[$address] = $name;
                    $this->addressesx[] = ['Email' => $address,'Name' => $name];
                }
            }else{
                $this->addresses[$arg1] = $arg2;
                $this->addressesx[] = ['Email' => $arg1,'Name' => $arg2];
            }
            return $this;
        }

        public function addAttachment($filepath='',$name=''){
            if(!file_exists($filepath)) return $this;

            $file_name    = basename($filepath);

            if(!$name) $name = $file_name;
            $mime_type        = mime_content_type($filepath);
            $content          = base64_encode(FileManager::file_read($filepath));

            $this->attachments[] = [
                'Content-type' => $mime_type,
                'Filename'    => $name,
                'content'     => $content,
            ];

            return $this;
        }

        public function getAddresses(){
            $addresses = $this->addresses;
            return $addresses ? array_keys($addresses) : [];
        }

        public function getSubject(){
            return $this->subject;
        }

        public function getBody(){
            return $this->body;
        }

        public function address_reset(){
            $this->addresses    = [];
            $this->addressesx   = [];
            $this->attachments = [];
            return $this;
        }

        public function submit($isthis=false){

            $recipients = $this->addressesx;

            $mj         = new \Mailjet\Client($this->public_key, $this->private_key);
            $mj->setTimeout(100);
            $body = [
                'FromEmail' => $this->config["femail"],
                'FromName' => $this->config["fname"],
                'Subject' => $this->subject,
                'Text-part' => NULL,
                'Html-part' => $this->body,
                'Recipients' => $recipients,
            ];
            if($this->attachments) $body["Attachments"] = $this->attachments;
            try
            {
                $response   = $mj->post(Resources::$Email, ['body' => $body]);
                $send       = $response->success();

                if($send === false){
                    $data = $response->getReasonPhrase();
                    $this->error = print_r($data,true);
                }
            }
            catch (Exception $e) {
                $this->error = $e->getMessage();
                return false;
            }

            return $isthis ? $this : $send;
        }
    }