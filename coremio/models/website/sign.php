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
    class Model extends Models
    {
        function __construct()
        {
            parent::__construct();
        }

        public function isNewsletter($type='',$content=''){
            $this->db_start();
            $sth = $this->db->select("id")->from("newsletters")->where("type","=",$type,"&&")->where("content","=",$content)->build();
            return $sth;
        }

        public function DeleteNewsletter($type='',$content=''){
            $this->db_start();
            $sth = $this->db->delete("newsletters")->where("type","=",$type,"&&")->where("content","=",$content)->run();
            return $sth;
        }

        public function register($data=[]){
            $this->db_start();
            $db = $this->db;
            if(sizeof($data)>0){
                $insert = $db->insert("users",$data);
                if(!$insert)
                    return false;
                else
                    return $db->lastID();
            }else
                return false;
        }

        public function get_user_info($email=''){
            $this->db_start();
            $db = $this->db;
            $sth = $db->select("id")->from("users");
            $sth->where("type","=","member","&&");
            $sth->where("email","=",$email);
            return ($sth->build()) ? $sth->getObject() : false;
        }

    }