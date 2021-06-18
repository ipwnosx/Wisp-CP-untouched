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
    class MioException {
        protected $view;

        static $error_type       = [
            500                  => "Software Error",
            E_ERROR              => 'Error',
            E_WARNING            => 'Warning',
            E_PARSE              => 'Parsing Error',
            E_NOTICE             => 'Notice',
            E_CORE_ERROR         => 'Core Error',
            E_CORE_WARNING       => 'Core Warning',
            E_COMPILE_ERROR      => 'Compile Error',
            E_COMPILE_WARNING    => 'Compile Warning',
            E_USER_ERROR         => 'User Error',
            E_USER_WARNING       => 'User Warning',
            E_USER_NOTICE        => 'User Notice',
            E_STRICT             => 'Runtime Notice',
            E_RECOVERABLE_ERROR  => 'Catchable Fatal Error',
        ];
        static $error_hide       = false;

        public function __construct()
        {
            $this->view = new View();

            @ini_set("display_errors",false);
            error_reporting(0);

            register_shutdown_function(array($this,"shutdown_error_handler"));
            set_error_handler(array($this,'error_handler'));
        }

        public function error_handler($errno,$errstr,$errfile,$errline){
            if(LOG_SAVE && !self::$error_hide) LogManager::core_error_log($errno,$errstr,$errfile,$errline);
            if(ERROR_DEBUG && !self::$error_hide) echo self::$error_type[$errno]." {{ ".$errstr." }} -- {{ ".$errfile." }} Line: ".$errline."\n ";
            //print_r(debug_backtrace());
        }

        public function shutdown_error_handler(){
            $error = error_get_last();
            if($error && in_array($error['type'],[E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_USER_ERROR, E_RECOVERABLE_ERROR, E_CORE_WARNING, E_COMPILE_WARNING, E_PARSE])){
                $errno   = $error["type"];
                $errfile = $error["file"];
                $errline = $error["line"];
                $errstr  = $error["message"];
                header("HTTP/1.1 200 OK");
                die($this->error_handler($errno,$errstr,$errfile,$errline));
            }
        }

        public function errorDB($arg=null){
            echo $this->view->chose("system")->render("database-error",['exception' => $arg],true);
        }

    }