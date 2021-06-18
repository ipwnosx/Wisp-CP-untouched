<?php
    defined('CORE_FOLDER') OR exit('You can not get in here!');
    class Controller extends Controllers
    {
        protected $params;
        public function __construct($arg=[])
        {
            parent::__construct();
            $this->params       = $arg['params'];
        }

        public function main(){

            return $this->main_404();

        }
    }