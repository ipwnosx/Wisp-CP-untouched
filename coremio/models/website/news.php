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
            $sth->where("owner","=","news","&&");
            $sth->where("reason","=","header-background");
            if($sth->build())
                return $sth->getObject()->name;
            else
                return false;
        }

        public function get_list($clang,$start=0,$end=1){
            $format_convert = str_replace(['d','m','Y',],['%d','%m','%Y'],Config::get("options/date-format"));
            $this->db_start();
            $select = [
                't1.id',
                'DATE_FORMAT(t1.ctime,"'.$format_convert.'") AS ctime',
                't3.name AS image',
                't2.title',
                't2.content',
                't2.route',
            ];
            $sth = $this->db->select(implode(",",$select))->from("pages AS t1");
            $sth->join("LEFT","pages_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$clang."'");
            $sth->join("LEFT","pictures AS t3","t1.id=t3.owner_id AND t3.reason='cover'");
            $sth->where("t2.id","IS NOT NULL","","&&");
            $sth->where("t1.type","=","news","&&");
            $sth->where("t1.visibility","=","visible","&&");
            $sth->where("t1.status","=","active");
            $sth->order_by("t1.id DESC");
            $sth->limit($start,$end);
            return ($sth->build()) ? $sth->fetch_assoc() : false;
        }

        public function get_total_count($clang=''){
            $this->db_start();
            $sth = $this->db->select("t1.id")->from("pages AS t1");
            $sth->join("LEFT","pages_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$clang."'");
            $sth->where("t2.id","IS NOT NULL","","&&");
            $sth->where("t1.type","=","news","&&");
            $sth->where("t1.status","=","active","&&");
            $sth->where("t1.visibility","=","visible");
            return ($sth->build()) ? $sth->getCount() : 0;
        }

        public function get_sidebar(){
            $this->db_start();
            $clang = Bootstrap::$lang->clang;
            $sth = $this->db->select(implode(",",[
                't1.id',
                't2.title',
                't2.route',
            ]))->from("pages AS t1");
            $sth->join("LEFT","pages_lang AS t2","t1.id=t2.owner_id AND t2.lang='{$clang}'");
            $sth->where("type","=","news","&&");
            $sth->where("status","=","active","&&");
            $sth->where("t1.visibility","=","visible","&&");
            $sth->where("t2.id","IS NOT NULL");
            $sth->order_by("t2.id DESC");
            $sth->limit(Config::get("options/limits/sidebar-news-most-read"));
            return ($sth->build()) ? $sth->fetch_assoc() : false;
        }

    }