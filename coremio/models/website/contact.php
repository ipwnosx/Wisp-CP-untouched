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

        public function get_header_background(){
            $this->db_start();
            $sth = $this->db->select("name")->from("pictures");
            $sth->where("owner_id","=",0,"&&");
            $sth->where("owner","=","contact","&&");
            $sth->where("reason","=","header-background");
            if($sth->build())
                return $sth->getObject()->name;
            else
                return false;
        }

        public function add($data=[]){
            $data['cdate'] = DateManager::Now();
            return $this->db->insert("contact_messages",$data);
        }

    }