<?php
    defined('CORE_FOLDER') OR exit('You can not get in here!');
    class Controller extends Controllers
    {
        protected $params,$data=[];

        public function __construct($arg=[])
        {
            parent::__construct();
            $this->params       = $arg['params'];
        }

        private function domain_parser($domain){
            if(preg_match("/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i", $domain, $matches)){
                return $matches['domain'];
            } else {
                return $domain;
            }
        }

        private function report(){

            $this->takeDatas("language");

            if(DEMO_MODE)
                die(Utility::jencode([
                    'status' => "error",
                    'message' => __("website/others/demo-mode-error")
                ]));

            if(!$check = Session::get("license_check",true)) return false;

            $get_hash   = Filter::init("POST/hash","letters_numbers");
            if(!$get_hash) return false;

            $check      = Utility::jdecode($check,true);
            if(!$check) return false;


            if($get_hash != $check["hash"]) return false;

            Helper::Load(["Events"]);

            $checkLog   = Events::isCreated("error","license",0,$check["domain"]);
            if(!$checkLog)
                Events::create([
                    'type' => "error",
                    'owner' => "license",
                    'owner_id' => 0,
                    'name' => $check["url"],
                    'data' => [
                        'server_ip' => '',
                        'user_ip' => UserManager::GetIP(),
                        'entered_url' => '',
                        'referer_url' => '',
                        'directory' => '',
                    ],
                ]);

            echo Utility::jencode([
                'status' => "successful",
                'message' => __("website/license/success1"),
            ]);

            Session::delete("license_check");

        }

        private function check(){
            $this->takeDatas("language");

            $captcha_status = Config::get("options/captcha/status") && Config::get("options/captcha/software-license");
            if(!$captcha_status && Config::get("options/BotShield/status")){
                Helper::Load("BotShield");
                $captcha_status = BotShield::is_blocked("software-license");
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

            $url        = Filter::init("POST/domain","domain");
            $domain     = $this->domain_parser($url);
            $parse      = Utility::domain_parser($domain);

            if(Validation::isEmpty($domain) || !$parse || !isset($parse["tld"]))
                die(Utility::jencode([
                    'status' => "error",
                    'for' => "input[name='domain']",
                    'message' => __("website/license/error1"),
                ]));

            $checking   = $this->model->checking($domain);

            if(!$checking){
                $check_hash   = md5("report_".microtime());

                Session::set("license_check",Utility::jencode([
                    'url' => $url,
                    'domain' => $domain,
                    'hash' => $check_hash,
                ]),true);
            }

            $output     = ['status' => $checking ? "ok" : "no"];

            if(!$checking) $output["hash"] = $check_hash;

            if(isset($captcha)) $captcha->refresh();

            if(!$captcha_status && Config::get("options/BotShield/status")) BotShield::was_attempt("software-license");

            echo Utility::jencode($output);
        }

        private function operationMain($operation=''){

            if($operation == "check") return $this->check();
            if($operation == "report") return $this->report();

            echo "Not found operation : ".$operation;
        }

        public function main(){

            $type   = isset($this->params[0]) ? $this->params[0] : false;
            
            if($type == "error"){
                $this->takeDatas("language");
                $user_ip    = Filter::init("GET/user_ip","ip");
                $lang       = Bootstrap::$lang->clang;
                if($user_ip)
                    $dlang  = Bootstrap::$lang->detect_lang($user_ip);
                else
                    $dlang  = Bootstrap::$lang->clang;

                if(!$dlang) $dlang = Config::get("general/local");


                $content   = FileManager::file_read(LANG_DIR.$dlang.DS."license-error.html");

                View::variables_handler("mail",0,[],$content,$lang);

                echo $content;
            }

            if($type == "checking"){
                $get_token      = isset($this->params[1]) ? Filter::letters_numbers($this->params[1]) : false;
                $get_pid        = isset($this->params[2]) ? Filter::numbers($this->params[2]) : false;

                if(!$get_token || !$get_pid) die("ERROR 1");

                $pattern    = Config::get("crypt/license-pattern");
                $pattern    = Utility::text_replace($pattern,['{pid}' => $get_pid]);
                $token      = md5(Crypt::encode($pattern,Config::get("crypt/system")));
                if($get_token != $token) die("ERROR 2");

                Helper::Load("Products");

                $product        = Products::get("software",$get_pid);
                if(!$product)
                    $product = Products::get("software",$get_pid,false,'inactive');

                if(!$product)
                {
                    echo "ERROR";
                    return false;
                }

                $license_type = "domain";

                if(isset($product["options"]["license_type"]) && $product["options"]["license_type"])
                    $license_type = $product["options"]["license_type"];

                if($license_type == "domain")
                {
                    // Get Params
                    $domain         = Filter::init("GET/domain","domain");
                    $domain         = $this->domain_parser($domain);
                    $server_ip      = Filter::init("GET/server_ip","ip");
                    $user_ip        = Filter::init("GET/user_ip","ip");
                    $entered        = Filter::init("GET/entered_url","hclear");
                    $referer        = Filter::init("GET/referer_url","hclear");
                    $directory      = Filter::init("GET/directory","hclear");

                    if(Validation::isEmpty($domain) || Validation::isEmpty($user_ip) || Validation::isEmpty($directory)) die("ERROR 3");

                    $checking   = $this->model->checking($domain,$get_pid);
                    if($checking) die("OK");

                    Helper::Load(["Events"]);

                    $checkLog   = $this->model->db->select("id")->from("events");
                    $checkLog->where("type","=","error","&&");
                    $checkLog->where("owner","=","license","&&");
                    $checkLog->where("owner_id","=",$get_pid,"&&");
                    $checkLog->where("(");
                    $checkLog->where("name","=",$domain,"||");
                    $checkLog->where("data","LIKE","%".str_replace("/","\/",$directory)."%");
                    $checkLog->where(")");
                    $checkLog   = $checkLog->build();

                    if(!$checkLog)
                        Events::create([
                            'type' => "error",
                            'owner' => "license",
                            'owner_id' => $get_pid,
                            'name' => $domain,
                            'data' => [
                                'server_ip' => $server_ip,
                                'user_ip' => $user_ip,
                                'entered_url' => $entered,
                                'referer_url' => $referer,
                                'directory' => $directory,
                            ],
                        ]);

                    echo "ERROR";
                }

                elseif($license_type == "key")
                {
                    $key            = Filter::init("REQUEST/key","hclear");
                    $ip             = substr(Filter::init("REQUEST/ip","ip"),0,30);
                    $parameters     = isset($product["options"]["license_parameters"]) ? $product["options"]["license_parameters"] : [];
                    $_parameters    = [];
                    $match_params   = [];
                    if(!$ip) $ip = UserManager::GetIP();

                    if($parameters)
                    {
                        foreach($parameters AS $k => $v)
                        {
                            if($k == "ip") continue;
                            $g_p = Filter::html_clear(Filter::REQUEST($k));
                            if($g_p)
                            {
                                $_parameters[$k] = $g_p;
                                if($v["match"]) $match_params[$k] = $g_p;
                            }
                        }
                    }

                    $checking       = $this->model->checking_key($key,$get_pid);

                    if(!$checking)
                    {
                        echo 'FAILED';
                        return false;
                    }

                    $set_options    = false;
                    $options        = Utility::jdecode($checking["options"],true);

                    if(isset($parameters["ip"]["match"]) && $parameters["ip"]["match"] && isset($options["ip"]) && $options["ip"] && $options["ip"] != $ip)
                    {
                        echo "FAILED";
                        return false;
                    }

                    if($match_params)
                    {
                        foreach($match_params AS $k => $v)
                        {
                            if(isset($options["license_parameters"][$k]) && $options["license_parameters"][$k])
                            {
                                if($options["license_parameters"][$k] != $v)
                                {
                                    echo "FAILED";
                                    return false;
                                }
                            }
                        }
                    }

                    if(!isset($options["ip"]) || !$options["ip"])
                    {
                        $set_options = true;
                        $options["ip"] = $ip;
                    }

                    if($_parameters)
                    {
                        foreach($_parameters as $k => $v)
                        {
                            if(!isset($options["license_parameters"][$k]) || !$options["license_parameters"][$k])
                            {
                                $set_options = true;
                                $options["license_parameters"][$k] = $v;
                                if($k == "domain") $options["domain"] = $v;
                            }
                        }
                    }

                    if($set_options)
                    {
                        Helper::Load("Orders");
                        Orders::set($checking["id"],['options' => Utility::jencode($options)]);
                    }

                    echo "OK";

                }

            }

            if(!$type){
                if(Filter::POST("operation")) return $this->operationMain(Filter::init("POST/operation","route"));
                if(Filter::GET("operation")) return $this->operationMain(Filter::init("GET/operation","route"));

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
                    "account_header_info",
                ]);

                Helper::Load("BotShield");

                $captcha_status = Config::get("options/captcha/status")==1 && Config::get("options/captcha/software-license")==1;
                if(!$captcha_status && Config::get("options/BotShield/status")){
                    $captcha_status = BotShield::is_blocked("software-license");
                }

                if($captcha_status){
                    Helper::Load("Captcha");
                    $captcha = Helper::get("Captcha");
                    $this->addData("captcha",$captcha);
                }

                $this->addData("links",[
                    'controller' => $this->ControllerURI(),
                ]);

                $hfolder    = Config::get("pictures/header-background/folder");
                $header_background  = Models::$init->db->select("name")->from("pictures")
                    ->where("owner","=","license","&&")
                    ->where("reason","=","header-background")->build() ? Models::$init->db->getObject()->name : false;
                if($header_background) $header_background  = Utility::image_link_determiner($header_background,$hfolder);

                $this->addData("meta",__("website/license/meta"));
                $this->addData("header_title",__("website/license/header-title"));
                $this->addData("header_description",__("website/license/header-description"));
                $this->addData("header_background",Utility::image_link_determiner($header_background));
                $this->view->chose("website")->render("license",$this->data);

            }

        }
    }