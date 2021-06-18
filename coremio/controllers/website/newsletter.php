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
    class Controller extends Controllers
    {
        protected $params,$data=[];

        public function __construct($arg=[])
        {
            parent::__construct();
            $this->params       = $arg['params'];
        }

        private function postSubmit(){

            $param  = isset($this->params[0]) ? $this->params[0] : false;

            if($param == "unsubscribe") return $this->post_unsubscribe();

            $this->takeDatas("language");

            if(DEMO_MODE)
                die(Utility::jencode([
                    'status' => "error",
                    'message' => __("website/others/demo-mode-error")
                ]));

            if(!defined("DISABLE_CSRF")){
                $token = Filter::init("POST/token","hclear");
                if(!$token || !Validation::verify_csrf_token($token,'newsletter'))
                    die(Utility::jencode([
                        'status' => "error",
                        'message' => ___("needs/invalid-csrf-token"),
                    ]));
            }

            $content = Filter::init("POST/email","email");

            Helper::Load("BotShield");

            $captcha_status = Config::get("options/captcha/status") && Config::get("options/captcha/newsletter");
            if(!$captcha_status && Config::get("options/BotShield/status")){
                $captcha_status = BotShield::is_blocked("newsletter");
            }

            if($captcha_status){
                Helper::Load("Captcha");
                $captcha = Helper::get("Captcha");
                if(!$captcha->check())
                    die(Utility::jencode([
                        'status' => "error",
                        'for' => $captcha->input_name ? "input[name='".$captcha->input_name."']" : NULL,
                        'message' => ___("needs/submit-invalid-captcha"),
                    ]));
            }


            if(Validation::isEmpty($content))
                die(Utility::jencode([
                    'status' => "error",
                    'message' => __("website/newsletter/submit-empty-email")
                ]));

            if(!Validation::isEmail($content))
                die(Utility::jencode([
                    'status' => "error",
                    'message' => __("website/newsletter/submit-invalid-email")
                ]));



            if(DEMO_MODE)
                die(Utility::jencode([
                    'status' => "error",
                    'message' => __("website/others/demo-mode-error")
                ]));

            Helper::Load("User");

            $limit  = Config::get("options/limits/newsletter-sending");
            $glimit = Session::get("newsletter_attempt");
            $glimit = !$glimit ? 0 : $glimit;

            $blocking_time = Config::get("options/blocking-times/newsletter");
            if(User::CheckBlocked("newsletter-blocking",0,['ip'=>UserManager::GetIP()]))
                die(Utility::jencode([
                    'status' => "error",
                    'message' => __("website/newsletter/submit-blocking",['{blocking-time}' => DateManager::str_expression($blocking_time)])
                ]));

            if(User::email_check($content) || $this->model->SimilarityCheck("email",$content))
                die(Utility::jencode([
                    'status' => "error",
                    'message' => __("website/newsletter/submit-already-registered")
                ]));

            $added = $this->model->addNewsletter("email",$content,Bootstrap::$lang->clang);
            if($added){
                echo Utility::jencode([
                    'status' => "successful",
                ]);

                if(!$captcha_status && Config::get("options/BotShield/status")) BotShield::was_attempt("newsletter");

                if($limit != 0 && current($blocking_time)){
                    $glimit++;
                    Session::set("newsletter_attempt",$glimit);

                    if($limit == $glimit){
                        Session::delete("newsletter_attempt");
                        User::addBlocked("newsletter-blocking",0,[
                            'ip' => UserManager::GetIP()
                        ],DateManager::next_date($blocking_time));
                    }
                }
            }else
                echo Utility::jencode([
                    'status' => "error",
                    'message' => __("website/newsletter/submit-failed-message")
                ]);
        }

        private function post_unsubscribe(){
            $this->takeDatas("language");

            if(DEMO_MODE)
                die(Utility::jencode([
                    'status' => "error",
                    'message' => __("website/others/demo-mode-error")
                ]));

            if(!defined("DISABLE_CSRF")){
                $token = Filter::init("POST/token","hclear");
                if(!$token || !Validation::verify_csrf_token($token,'newsletter'))
                    die(Utility::jencode([
                        'status' => "error",
                        'message' => ___("needs/invalid-csrf-token"),
                    ]));
            }

            $content = Filter::init("POST/email","email");

            if(Validation::isEmpty($content))
                die(Utility::jencode([
                    'status' => "error",
                    'message' => __("website/newsletter/submit-empty-email")
                ]));

            if(!Validation::isEmail($content))
                die(Utility::jencode([
                    'status' => "error",
                    'message' => __("website/newsletter/submit-invalid-email")
                ]));

            Helper::Load("User");

            $user               = $this->model->db->select("id")->from("users")->where("type","=","member","&&")->where("email","=",$content);
            $user               = $user->build() ? $user->getObject()->id : false;
            $newsletter_id      = $this->model->SimilarityCheck("email",$content);

            if(!($newsletter_id || $user))
                die(Utility::jencode([
                    'status' => "error",
                    'message' => __("website/newsletter/submit-not-registered")
                ]));

            $remove             = false;
            if(isset($newsletter_id) && $newsletter_id) $remove = $this->model->removeNewsletter($newsletter_id);
            if(isset($user) && $user) $remove = User::setInfo($user,['email_notifications' => 0]);


            if(!$remove)
                die(Utility::jencode([
                    'status' => "error",
                    'message' => "Cannot delete newsletter.",
                ]));

            echo Utility::jencode(['status' => "successful"]);
        }

        private function main_unsubscribe(){

            $email = Filter::init("GET/email","email");

            if(Filter::GET("lang") == "auto"){
                $detect_lang = Bootstrap::$lang->detect_lang();
                Utility::redirect($this->CRLink("newsletter",false,$detect_lang)."/unsubscribe?email=".$email);
                exit;
            }

            $this->takeDatas([
                "sign-all",
                "language",
                "lang_list",
                "newsletter",
                "contacts",
                "socials",
                "header_menus",
                "footer_menus",
                "home_link",
                "canonical_link",
                "favicon_link",
                "header_logo_link",
                "footer_logo_link",
                "header_type",
                "meta_color",
                "footer_logos",
            ]);

            $this->addData("email",$email);

            $this->addData("newsletter_action",$this->CRLink("newsletter")."/unsubscribe");

            $this->view->chose("website")->render("newsletter-unsubscribe",$this->data);
        }
        
        public function main(){

            if(Config::get("theme/only-panel")){
                $this->main_404();
                die();
            }

            if(Filter::isPOST()) return $this->postSubmit();

            $param  = isset($this->params[0]) ? $this->params[0] : false;

            if($param == "unsubscribe") return $this->main_unsubscribe();

            $this->takeDatas([
                "sign-all",
                "language",
                "lang_list",
                "newsletter",
                "contacts",
                "socials",
                "header_menus",
                "footer_menus",
                "home_link",
                "canonical_link",
                "favicon_link",
                "header_logo_link",
                "footer_logo_link",
                "header_type",
                "meta_color",
                "footer_logos",
            ]);


            $email = Filter::init("GET/email","email");
            $this->addData("email",$email);

            $captcha_status = Config::get("options/captcha/status")==1 && Config::get("options/captcha/newsletter")==1;
            if(!$captcha_status && Config::get("options/BotShield/status")){
                Helper::Load("BotShield");
                $captcha_status = BotShield::is_blocked("newsletter");
            }

            if($captcha_status){
                Helper::Load("Captcha");
                $captcha = Helper::get("Captcha");
                $this->addData("captcha",$captcha);
            }

            $this->addData("newsletter_action",$this->CRLink("newsletter-send"));

            $this->view->chose("website")->render("newsletter",$this->data);

        }
    }