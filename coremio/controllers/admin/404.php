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

            $this->takeDatas([
                "dashboard-link",
                "admin-sign-all",
                "language",
                "lang_list",
                "home_link",
                "canonical_link",
                "favicon_link",
                "header_type",
                "header_logo_link",
                "meta_color",
                "admin_info",
            ]);

            $this->addData("meta",__("admin/404/meta"));

            $this->view->chose("admin")->render("404",$this->data);

        }
    }