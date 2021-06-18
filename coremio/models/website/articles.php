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


        public function category_route_check($route='',$lang=''){
            $this->db_start();
            $sth = $this->db->select("t1.id")->from("categories AS t1");
            $sth->join("LEFT","categories_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $sth->where("t2.id","IS NOT NULL","","&&");
            $sth->where("t1.type","=","articles","&&");
            $sth->where("t2.route","=",$route);
            if(!$sth->build()) return false;
            return $sth->getObject()->id;
        }

        public function get_list($category=0,$clang,$start=0,$end=1){
            $format_convert = str_replace(['d','m','Y',],['%d','%m','%Y'],Config::get("options/date-format"));
            $this->db_start();
            $select = [
                't1.id',
                'DATE_FORMAT(t1.ctime,"'.$format_convert.'") AS ctime',
                't3.name AS image',
                't2.title',
                't2.content',
                't2.route',
                't4.title AS category_name',
                't4.route AS category_route',
            ];
            $sth = $this->db->select(implode(",",$select))->from("pages AS t1");
            $sth->join("LEFT","pages_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$clang."'");
            $sth->join("LEFT","pictures AS t3","t1.id=t3.owner_id AND t3.reason='cover'");
            $sth->join("LEFT","categories_lang AS t4","t1.category=t4.owner_id AND t4.lang='".$clang."'");
            $sth->where("t2.id","IS NOT NULL","","&&");
            $sth->where("t1.type","=","articles","&&");
            if($category !=0) {
                $sth->where("(");
                $sth->where("t1.category","=",$category,"||");
                $sth->where("FIND_IN_SET(" . $category . ",t1.categories)", "", "");
                $sth->where(")","","","&&");
            }
            $sth->where("t1.visibility","=","visible","&&");
            $sth->where("t1.status","=","active");
            $sth->order_by("t1.id DESC");
            $sth->limit($start,$end);
            return ($sth->build()) ? $sth->fetch_assoc() : false;
        }

        public function get_total_count($category=0,$clang=''){
            $this->db_start();
            $sth = $this->db->select("t1.id")->from("pages AS t1");
            $sth->join("LEFT","pages_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$clang."'");
            $sth->where("t2.id","IS NOT NULL","","&&");
            $sth->where("t1.type","=","articles","&&");
            if($category !=0) {
                $sth->where("(");
                $sth->where("t1.category","=",$category,"||");
                $sth->where("FIND_IN_SET(" . $category . ",t1.categories)", "", "");
                $sth->where(")","","","&&");
            }
            $sth->where("t1.visibility","=","visible","&&");
            $sth->where("t1.status","=","active");
            return ($sth->build()) ? $sth->getCount() : 0;
        }

        public function get_category($id=0,$clang){
            $this->db_start();
            $sth = $this->db->select(implode(",",[
                't1.id',
                't1.type',
                't1.status',
                't2.route',
                't2.title',
                't2.content',
                't2.seo_title',
                't2.seo_keywords',
                't2.seo_description',
                '(SELECT name FROM '.$this->pfx.'pictures WHERE owner=\'category\' AND reason=\'header-background\' AND owner_id=t1.id) AS header_background',
            ]))->from("categories AS t1");
            $sth->join("LEFT","categories_lang AS t2","t1.id=t2.owner_id AND t2.lang='{$clang}'");
            $sth->where("t2.id","IS NOT NULL","","&&");
            $sth->where("t1.type","=","articles","&&");
            $sth->where("t1.visibility","=","visible","&&");
            $sth->where("t1.id","=",$id);
            return ($sth->build()) ? $sth->getAssoc() : false;
        }


        public function get_sidebar($type=''){
            $this->db_start();
            if($type == "most_read")
                return $this->most_read();
            elseif($type == "categories")
                return $this->categories();
        }

        public function most_read(){
            $clang = Bootstrap::$lang->clang;
            $sth = $this->db->select(implode(",",[
                't1.id',
                't2.title',
                't2.route',
            ]))->from("pages AS t1");
            $sth->join("LEFT","pages_lang AS t2","t1.id=t2.owner_id AND t2.lang='{$clang}'");
            $sth->where("type","=","articles","&&");
            $sth->where("status","=","active","&&");
            $sth->where("t1.visibility","=","visible","&&");
            $sth->where("t2.id","IS NOT NULL");
            $sth->order_by("t1.id DESC");
            $sth->limit(Config::get("options/limits/sidebar-articles-most-read"));
            return ($sth->build()) ? $sth->fetch_assoc() : false;
        }

        public function categories(){
            $clang = Bootstrap::$lang->clang;
            $sth = $this->db->select(implode(",",[
                't1.id',
                't2.title',
                't2.route',
            ]))->from("categories AS t1");
            $sth->join("LEFT","categories_lang AS t2","t1.id=t2.owner_id AND t2.lang='{$clang}'");
            $sth->where("type","=","articles","&&");
            $sth->where("status","=","active","&&");
            $sth->where("t2.id","IS NOT NULL","","&&");
            $sth->where("t1.visibility","=","visible","&&");
            $sth->where("t1.parent","=",0);
            $sth->order_by("t1.rank ASC");
            $sth->limit(Config::get("options/limits/sidebar-categories"));
            return ($sth->build()) ? $sth->fetch_assoc() : false;
        }

        public function get_header_background_default(){
            $this->db_start();
            $sth = $this->db->select("name")->from("pictures");
            $sth->where("owner","=","articles","&&");
            $sth->where("reason","=","header-background");
            if(!$sth->build()) return false;
            return $sth->getObject()->name;
        }

    }