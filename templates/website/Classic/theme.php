<?php
    //define("DISABLE_CSRF",true);

    Class Classic_Theme {
        public $config=[],$name = 'Classic',$error=NULL,$language,$languages;

        function __construct()
        {
            if(!$this->languages) $this->languages = View::$init->theme_language_loader($this->name);
            if(!$this->language) $this->language = View::$init->theme_lang(Bootstrap::$lang->clang,$this->languages);

            $this->config   = include __DIR__.DS."theme-config.php";

            if(DEMO_MODE){
                $cookie_onlyPanel = Cookie::get("onlyPanel");
                if(isset($_GET["set_onlyPanel"])){
                    $set_onlyPanel = $_GET["set_onlyPanel"];
                    Cookie::set("onlyPanel",$set_onlyPanel ? 1 : 0);
                    $cookie_onlyPanel = $set_onlyPanel;
                }
                Config::set("theme",['only-panel' => $cookie_onlyPanel ? 1 : 0]);
            }
        }

        public function router($params=[]){
            $raw        = implode("/",$params);
            $page       = Filter::folder(isset($params[0]) ? $params[0] : '');

            if($raw == "templates/website/".$this->name."/css/wisecp.css"){
                $this->main_css();
                return true;
            }elseif($page && file_exists(__DIR__.DS."pages".DS.$page.".php"))
                return ['include_file' => __DIR__.DS."pages".DS.$page.".php"];
        }

        public function main_css(){
            $color1         = ltrim(Config::get("theme/color1"),"#");
            $color2         = ltrim(Config::get("theme/color2"),"#");
            $text_color     = ltrim(Config::get("theme/text-color"),"#");
            $config_theme   = CONFIG_DIR."theme.php";
            $config_file    = __DIR__.DS."theme-config.php";
            $css_file       = __DIR__.DS."css".DS."wisecp.php";

            $lastModified1 = filemtime($config_theme);
            $lastModified2 = file_exists($config_file) ? filemtime($config_file) : 0;
            $lastModified3 = filemtime($css_file);
            $lastModified  = $lastModified1;

            if($lastModified3 > $lastModified2) $lastModified = $lastModified3;
            elseif($lastModified3 > $lastModified1) $lastModified = $lastModified3;

            elseif($lastModified2 > $lastModified3) $lastModified = $lastModified2;
            elseif($lastModified2 > $lastModified1) $lastModified = $lastModified2;

            elseif($lastModified1 > $lastModified3) $lastModified = $lastModified1;
            elseif($lastModified1 > $lastModified2) $lastModified = $lastModified1;

            header("Content-Type:text/css;charset=UTF-8");
            header("Last-Modified: ".gmdate("D, d M Y H:i:s", $lastModified)." GMT");
            header('Cache-Control: public');

            include $css_file;

        }

        public function change_settings(){

            $settings           = isset($this->config["settings"]) ? $this->config["settings"] : [];

            $header_type        = (int) Filter::init("POST/header_type","numbers");
            $clientArea_type    = (int) Filter::init("POST/clientArea_type","numbers");
            $color1             = ltrim(Filter::init("POST/color1"),"#");
            $color2             = ltrim(Filter::init("POST/color2"),"#");
            $tcolor             = ltrim(Filter::init("POST/text_color"),"#");

            if($header_type != $settings["header-type"]) $settings["header-type"] = $header_type;
            if($clientArea_type != $settings["clientArea-type"]) $settings["clientArea-type"] = $clientArea_type;

            if($color1 != $settings["color1"]){
                $settings["color1"]         = $color1;
                $settings["meta-color"]     = "#".$color1;
            }

            if($color2 != $settings["color2"]) $settings["color2"] = $color2;


            if($tcolor != $settings["text-color"]) $settings["text-color"] = $tcolor;


            return $settings;
        }




    }