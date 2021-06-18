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

        public function header_background(){
            $sth = $this->db->select("name")->from("pictures");
            $sth->where("owner","=","domain","&&");
            $sth->where("owner_id","=",0,"&&");
            $sth->where("reason","=","header-background");
            return $sth->build() ? $sth->getObject()->name : false;
        }

        public function TLDList(){
            $sth = $this->db->select()->from("tldlist");
            $sth->where("status","=","active");
            $sth->order_by("rank ASC");
            return $sth->build() ? $sth->fetch_assoc() : false;
        }

        public function getTLD($name='',$rank='0'){
            $sth = $this->db->select()->from("tldlist");
            $sth->where("status","=","active","&&");
            if($name != '') $sth->where("name","=",$name);
            elseif(!is_string($rank)) $sth->where("rank","=",$rank);
            return $sth->build() ? $sth->getAssoc() : false;
        }


    }