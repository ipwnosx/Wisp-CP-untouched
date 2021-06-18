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

        public function main(){
            $param0 = isset($this->params[0]) ? $this->params[0] : false;
            $param1 = isset($this->params[1]) ? $this->params[1] : false;
            $param2 = isset($this->params[2]) ? $this->params[2] : false;
            $param3 = isset($this->params[3]) ? $this->params[3] : false;

            if($param0 == "website" && in_array($param1,['images','css','js'])){
                $http       = Utility::isSSL() ? 'https' : 'http';
                $path       = $_SERVER["REQUEST_URI"];
                $path       = str_replace("templates/website/","templates/website/".$this->view->theme_name."/",$path);
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: ".$http."://".$_SERVER["HTTP_HOST"].$path);
            }
            elseif($param0 == "website" && $param1 == "css" && $param2 == "wisecp.css"){

                $this->addData("color1",Config::get("theme/color1"));
                $this->addData("color2",Config::get("theme/color2"));
                $this->addData("text_color",Config::get("theme/text-color"));

                $lastModified = filemtime(CONFIG_DIR."theme.php");

                header("Content-Type:text/css;charset=UTF-8");
                header("Last-Modified: ".gmdate("D, d M Y H:i:s", $lastModified)." GMT");
                header('Cache-Control: public');

                echo $this->view->chose("website")->render("css".DS."wisecp",$this->data,true);
            }elseif($param0 == "website" && $param1 == $this->view->theme_name && $param2 == "css" && $param3 == "wisecp.css"){

                $this->addData("color1",Config::get("theme/color1"));
                $this->addData("color2",Config::get("theme/color2"));
                $this->addData("text_color",Config::get("theme/text-color"));

                $lastModified = filemtime(CONFIG_DIR."theme.php");

                header("Content-Type:text/css;charset=UTF-8");
                header("Last-Modified: ".gmdate("D, d M Y H:i:s", $lastModified)." GMT");
                header('Cache-Control: public');

                echo $this->view->chose("website")->render("css".DS."wisecp",$this->data,true);
            }else
                return $this->main_404();


        }
    }