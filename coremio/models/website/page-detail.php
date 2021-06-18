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

        public function articles_most_read(){
            $clang = Bootstrap::$lang->clang;
            $sth = $this->db->select(implode(",",[
                't1.id',
                't2.title',
                't2.route',
            ]))->from("pages AS t1");
            $sth->join("LEFT","pages_lang AS t2","t1.id=t2.owner_id AND t2.lang='{$clang}'");
            $sth->where("type","=","articles","&&");
            $sth->where("status","=","active","&&");
            $sth->where("t2.id","IS NOT NULL");
            $sth->order_by("t1.id DESC");
            $sth->limit(Config::get("options/limits/sidebar-articles-most-read"));
            return ($sth->build()) ? $sth->fetch_assoc() : false;
        }

        public function articles_categories(){
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
            $sth->where("t1.parent","=",0);
            $sth->order_by("t1.rank ASC");
            $sth->limit(Config::get("options/limits/sidebar-categories"));
            return ($sth->build()) ? $sth->fetch_assoc() : false;
        }

        public function get_articles_sidebar($type=''){
            $this->db_start();
            if($type == "most_read")
                return $this->articles_most_read();
            elseif($type == "categories")
                return $this->articles_categories();
        }

        public function route_check($route='',$lang=''){
            $this->db_start();
            $sth = $this->db->select("owner_id")->from("pages_lang");
            $sth->where("route","=",$route,"&&");
            $sth->where("lang","=",$lang);
            if(!$sth->build()) return false;
            return $sth->getObject()->owner_id;
        }

        public function get_category_header_background($category=0){
            $this->db_start();
            $sth = $this->db->select("t1.id,t1.parent,t2.name")->from("categories AS t1");
            $sth->join("LEFT","pictures AS t2","t2.owner_id=t1.id AND t2.owner='category' AND t2.reason='header-background'");
            $sth->where("t1.id","=",$category);
            if($sth->build()){
                $data = $sth->getObject();
                return $data->parent != 0 && !$data->name ? $this->get_category_header_background($data->parent) : $data->name;
            }else
                return false;
        }

        public function get_header_background_default($type){
            $this->db_start();
            $sth = $this->db->select("name")->from("pictures");
            $sth->where("owner_id","=",0,"&&");
            $sth->where("owner","=","page_".$type,"&&");
            $sth->where("reason","=","header-background");
            if($sth->build())
                return $sth->getObject()->name;
            else
                return false;
        }

        public function get_sidebar($type,$limit=10){
            $this->db_start();
            $clang = Bootstrap::$lang->clang;
            $sth = $this->db->select(implode(",",[
                't1.id',
                't2.title',
                't2.route',
            ]))->from("pages AS t1");
            $sth->join("LEFT","pages_lang AS t2","t1.id=t2.owner_id AND t2.lang='{$clang}'");
            $sth->where("t1.type","=",$type,"&&");
            $sth->where("t1.status","=","active","&&");
            $sth->where("t2.id","IS NOT NULL");
            $sth->order_by("t1.id DESC");
            $sth->limit($limit);
            return ($sth->build()) ? $sth->fetch_assoc() : false;
        }

        public function get_page($id=0,$clang){
            $this->db_start();
            $sth = $this->db->select(implode(",",[
                't1.id',
                't1.category',
                't1.type',
                't1.status',
                't1.visibility',
                't1.visible_to_user',
                't1.sidebar',
                't1.override_usrcurrency',
                't2.route',
                't2.title',
                't2.content',
                't2.seo_title',
                't2.seo_keywords',
                't2.seo_description',
                't1.options',
                't2.options AS optionsl',
                't3.title AS category_title',
                't3.route AS category_route',
                '(SELECT name FROM '.$this->pfx.'pictures WHERE owner=\'page_\'+t1.type AND reason=\'header-background\' AND owner_id=t1.id LIMIT 1) AS header_background',
                '(SELECT name FROM '.$this->pfx.'pictures WHERE owner=\'page_\'+t1.type AND reason=\'mockup\' AND owner_id=t1.id LIMIT 1) AS mockup',
                '(SELECT name FROM '.$this->pfx.'pictures WHERE owner=\'page_\'+t1.type AND reason=\'cover\' AND owner_id=t1.id LIMIT 1) AS cover',
            ]))->from("pages AS t1");
            $sth->join("LEFT","pages_lang AS t2","t1.id=t2.owner_id AND t2.lang='{$clang}'");
            $sth->join("LEFT","categories_lang AS t3","t1.category=t3.owner_id AND t3.lang='{$clang}'");
            $sth->where("t1.status","=","active","&&");
            $sth->where("t2.id","IS NOT NULL","","&&");
            $sth->where("t1.id","=",$id);
            return ($sth->build()) ? $sth->getAssoc() : false;
        }

        public function get_prices($type,$owner,$owner_id,$lang='none'){
            $this->db_start();
            $sth = $this->db->select("period,time,amount,discount,cid")->from("prices");
            $sth->where("type","=",$type,"&&");
            $sth->where("owner","=",$owner,"&&");
            $sth->where("owner_id","=",$owner_id);
            //$sth->where("lang","=",$lang);
            if(!$sth->build())  return [];
            return $sth->fetch_assoc();
        }

        public function get_price($type,$owner,$owner_id,$lang='none'){
            $this->db_start();
            $sth = $this->db->select("period,time,amount,discount,cid")->from("prices");
            $sth->where("type","=",$type,"&&");
            $sth->where("owner","=",$owner,"&&");
            $sth->where("owner_id","=",$owner_id);
            //$sth->where("lang","=",$lang);
            if(!$sth->build())  return [];
            return $sth->getAssoc();
        }

        public function get_most_popular($type,$limit,$lang,$category=0){
            $this->db_start();
            $select = [
                't1.id',
                't2.route',
                't2.title',
                't1.options',
                't2.options AS optionsl',
                '(SELECT name FROM '.$this->pfx.'pictures WHERE owner=\'page_\'+t1.type AND owner_id=t1.id AND reason=\'cover\') AS cover_image',
                't4.title AS category_name',
                't4.route AS category_route',
            ];
            $sth = $this->db->select(implode(",",$select))->from("pages AS t1");
            $sth->join("LEFT","pages_lang AS t2","t1.id=t2.owner_id AND t2.lang='".$lang."'");
            $sth->join("LEFT","categories_lang AS t4","t1.category=t4.owner_id AND t4.lang='".$lang."'");
            $sth->where("t2.id","IS NOT NULL","","&&");
            $sth->where("t1.type","=",$type,"&&");
            $sth->where("t1.status","=","active","&&");
            if($type == "software") $sth->where("t1.options","LIKE",'%"popular":true%',"&&");
            if($type == "references" && $category) $sth->where("t1.category","=",$category,"&&");
            $sth->where("t1.visibility","=","visible");
            $sth->order_by("RAND()");
            $sth->limit(0,$limit);
            if(!$sth->build())  return false;
            return $sth->fetch_assoc();
        }

    }