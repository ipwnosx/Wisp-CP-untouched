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
    if(isset($_SERVER["REQUEST_URI"]) && stristr($_SERVER["REQUEST_URI"],'/callback')) header('Set-Cookie: ' . session_name() . '=' . session_id() . '; SameSite=None; Secure', false);
    ob_start();
    class Cookie {

        static function set($name="",$content,$expire=0,$encode=false){
            self::delete($name);
            if($content && $encode) $content = Crypt::encode($content,Config::get("crypt/cookie"));
            $_COOKIE[$name] = $content;
            return setcookie($name,$content,$expire, '/');
        }

        static function get($name="",$decode=false){
            $data = isset($_COOKIE[$name]) ? $_COOKIE[$name] : false;
            if($data && $decode) $data = Crypt::decode($data,Config::get("crypt/cookie"));
            return $data;
        }


        static function delete($key){
            if(isset($_COOKIE[$key])){
                unset($_COOKIE[$key]);
                setcookie($key,"",time()-1000);
                setcookie($key,"",time()-1000,'/');
                return true;
            }else
                return false;
        }

        static function GetCookie(){
            return $_COOKIE;
        }

        static function clear(){
            if (isset($_SERVER['HTTP_COOKIE'])) {
                $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
                foreach($cookies as $cookie) {
                    $parts = explode('=', $cookie);
                    $name = trim($parts[0]);
                    setcookie($name, '', time()-1000);
                    setcookie($name, '', time()-1000, '/');
                }
            }
            $_COOKIE = array();
            return true;
        }



    }