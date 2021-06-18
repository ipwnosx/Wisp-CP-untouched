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
    session_start();
    if(isset($_SERVER["REQUEST_URI"]) && stristr($_SERVER["REQUEST_URI"],'/callback')) header('Set-Cookie: ' . session_name() . '=' . session_id() . '; SameSite=None; Secure',false);
    class Session {

        static function set($key, $value,$crypt=false){
            $_SESSION[$key] = ($crypt) ?  Crypt::Encode($value,Config::get("crypt/session")) : $value;
            return true;
        }

        static function get($key,$crypt=false){
            if(isset($_SESSION[$key]))
                return ($crypt) ? Crypt::Decode($_SESSION[$key],Config::get("crypt/session")): $_SESSION[$key];
            else
                return false;
        }

        static function delete($key){
            if(isset($_SESSION[$key])) {
                unset($_SESSION[$key]);
                return true;
            } else
                return false;
        }

        static function getSession(){
            return $_SESSION;
        }

        static function clear(){
            session_destroy();
            $_SESSION = array();
            return true;
        }
    }