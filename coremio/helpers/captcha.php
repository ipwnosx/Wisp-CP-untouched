<?php
    /**
    * @author Sitemio Bilişim Teknolojileri Tic. Ltd. Şti.
    * @project Sitemio Temel Kaynak Kod Çekirdek Yapısı
    * @date 2017-07-01 09:00 AM
    * @contract http://www.sitemio.com/hizmet-sozlesmesi.html
    * @copyright Tüm Hakları Sitemio Bilişim Teknolojileri Tic. Ltd. Şti. adına saklıdır
    * @warning Lisanssız kopyalanamaz, dağıtılamaz ve kullanılamaz.
    **/
    defined('CORE_FOLDER') OR exit('You can not get in here!');
    class Captcha {
        private $settings=[];
        private $type=false;
        public $captcha_key="captcha_code";
        public $input=false;
        public $input_name=false;

        function __construct($options=[]){
            if(isset($options["type"]))
                $this->type = $options["type"];
            else
                $this->type = Config::get("options/captcha/type");

            if($this->type == "default"){
                $this->settings = [
                    'background-color' => '',
                    'text-color'       => '#132525',
                    'width'            => 133,
                    'height'           => 41,
                ];
                $this->input = true;
                $this->input_name = "answer";
            }elseif($this->type == "Google-reCaptcha"){

                if(isset($GLOBALS["google_recaptcha_count"])){
                    $GLOBALS["google_recaptcha_count"]++;
                }else{
                    $GLOBALS["google_recaptcha_count"] = 1;
                }

                $this->settings = Config::get("options/captcha/Google-reCaptcha");
                $this->input = false;
            }
            return $this;
        }

        private function rgb($hex='#FFF'){
            return sscanf($hex, "#%02x%02x%02x");
        }

        public function generate(){
            if($this->type && $this->type == "default"){
                if(!class_exists("CaptchaBuilder"))
                    require __DIR__.DSEPARATOR."libraries".DSEPARATOR."Captcha".DSEPARATOR."autoload.php";
                $builder = new Gregwar\Captcha\CaptchaBuilder();

                $settings = $this->settings;

                $bg_color = $settings["background-color"];
                $tx_color = $settings["text-color"];

                if($bg_color != ''){
                    list($r,$g,$b) = $this->rgb($bg_color);
                    $builder->setBackgroundColor($r,$g,$b);
                }else{
                    if(function_exists("finfo_open")) {
                        $builder->setIgnoreAllEffects(true);
                        $builder->setBackgroundImages(array(__DIR__ . DSEPARATOR . "libraries" . DSEPARATOR . "Captcha" . DSEPARATOR . "images" . DSEPARATOR . "captcha_bg.png"));
                    }
                }

                if($tx_color != ''){
                    list($r,$g,$b) = $this->rgb($tx_color);
                    $builder->setTextColor($r,$g,$b);
                }

                $builder->setMaxFrontLines(0);
                $builder->setMaxBehindLines(0);

                $builder->build($settings["width"],$settings["height"]);
                Session::set($this->captcha_key,$builder->getPhrase());
                header('Content-type: image/jpeg');
                $builder->output(100);

            }elseif($this->type == "Google-reCaptcha"){

            }
            return $this;
        }

        public function refresh(){
            if($this->type=="default"){
                Session::delete($this->captcha_key);
            }
        }

        public function check(){
            if($this->type == "default"){
                $code1  = strtolower(Filter::init("POST/".$this->input_name,"letters_numbers"));
                $code2 = strtolower(Session::get($this->captcha_key));
                return ($code1 != '' && $code2 != '' && $code1==$code2);
            }elseif($this->type == "Google-reCaptcha"){
                $response   = Filter::init("POST/g-recaptcha-response","hclear");
                $url = 'https://www.google.com/recaptcha/api/siteverify';
                $data = [
                    'secret' => $this->settings["secret-key"],
                    'response' => $response,
                ];

                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_TIMEOUT, 10);
                curl_setopt($curl, CURLOPT_POSTFIELDS,$data);
                curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.16) Gecko/20110319 Firefox/3.6.16");
                $verify = curl_exec($curl);
                curl_close($curl);

                $result             = json_decode($verify,true);
                return $result["success"];
            }
        }

        public function submit_after_js(){
            if($this->type == "Google-reCaptcha"){
                $output = NULL;
                $output .= "grecaptcha.reset();";
                return $output;
            }
        }

        public function getOutput($name=''){
            $output = NULL;
            if($this->type == "default"){
                $output = '<img src="'.Controllers::$init->CRLink("captcha").'?type=default" width="'.$this->settings["width"].'" height="'.$this->settings["height"].'">';
            }elseif($this->type == "Google-reCaptcha"){
                if(isset($GLOBALS["google_recaptcha_element"])) $GLOBALS["google_recaptcha_element"]++;
                else $GLOBALS["google_recaptcha_element"] = 1;

                $rid    = $GLOBALS["google_recaptcha_element"];
                $output .= '<div class="g-recaptcha" id="recaptcha-'.$rid.'" data-sitekey="'.$this->settings["site-key"].'"></div>';
                if($rid == 1){
                    $output .= EOL.'<script src="https://www.google.com/recaptcha/api.js"></script>'.EOL;
                }
            }
            return $output;
        }

    }