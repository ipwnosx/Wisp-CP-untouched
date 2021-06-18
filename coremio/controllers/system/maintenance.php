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

            $this->takeDatas("language");

            $this->view->chose("system")->render("maintenance",$this->data);

        }
    }