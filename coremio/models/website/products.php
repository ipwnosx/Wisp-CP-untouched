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
            $sth->where("t1.type","=","products","&&");
            $sth->where("t2.route","=",$route);
            return $sth->build() ? $sth->getObject()->id : false;
        }

        public function get_prices($type,$owner,$owner_id,$lang='none'){
            $this->db_start();
            $sth = $this->db->select("period,time,amount,discount,cid")->from("prices");
            $sth->where("type","=",$type,"&&");
            $sth->where("owner","=",$owner,"&&");
            $sth->where("owner_id","=",$owner_id);
            //$sth->where("lang","=",$lang);
            $sth->order_by("rank ASC");
            if(!$sth->build())  return [];
            return $sth->fetch_assoc();
        }

        public function get_price($type,$owner,$owner_id,$lang='none'){
            $this->db_start();
            $sth = $this->db->select("period,time,amount,discount,cid")->from("prices");
            $sth->where("type","=",$type,"&&");
            $sth->where("owner","=",$owner,"&&");
            $sth->where("owner_id","=",$owner_id,"&&");
            $sth->where("lang","=",$lang);
            $sth->order_by("rank ASC");
            if(!$sth->build())  return [];
            return $sth->getAssoc();
        }

        public function get_list($category=0,$kind='',$clang=''){
            $this->db_start();
            $select = [
                't1.id',
                't1.override_usrcurrency',
                't1.type',
                't1.options',
                't2.options AS options_lang',
                't2.title',
                't2.features',
                '(SELECT name FROM '.$this->pfx.'pictures WHERE owner=\'products\' AND owner_id=t1.id AND reason=\'cover\') AS cover_image',
                'CASE
                WHEN stock = "" THEN 1 
                WHEN stock IS NULL THEN 1 
                ELSE stock 
                END AS haveStock',
            ];
            $sth = $this->db->select(implode(",",$select))->from("products AS t1");
            $sth->join("LEFT","products_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$clang."'");
            $sth->where("t2.id","IS NOT NULL","","&&");
            if($kind)
                $sth->where("t1.type","=",$kind,"&&");
            $sth->where("(");
            $sth->where("FIND_IN_SET(t1.category,'".$category."')", "", "","||");
            $sth->where("FIND_IN_SET(t1.categories,'".$category."')", "", "","");
            $sth->where(")","","","&&");
            $sth->where("t1.status","=","active","&&");
            $sth->where("t1.visibility","=","visible");
            $sth->order_by("t1.rank ASC");
            if(!$sth->build()) return [];
            return $sth->fetch_assoc();
        }

        public function get_categories($group=0,$kind='',$lang){
            $this->db_start();
            $select = implode(",",[
                't1.id',
                't1.parent',
                't1.kind',
                't2.title',
                't2.route',
                't1.options',
                't2.options AS options_lang',
                't3.name AS icon',
            ]);
            $sth = $this->db->select($select)->from("categories AS t1");
            $sth->join("LEFT","categories_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $sth->join("LEFT","pictures AS t3","t3.owner='category' AND t3.owner_id=t1.id AND t3.reason='icon'");
            $sth->where("t2.id","IS NOT NULL","","&&");
            $sth->where("t1.type","=","products","&&");
            if($kind)
                $sth->where("t1.kind","=",$kind,"&&");
            $sth->where("t1.status","=","active","&&");
            $sth->where("t1.visibility","=","visible","&&");
            $sth->where("t1.parent","=",$group);
            $sth->order_by("t1.rank ASC");
            if(!$sth->build())  return false;
            return $sth->fetch_assoc();
        }

        public function get_list_category($id=0,$lang){
            $select = implode(",",[
                't1.id',
                't1.kind',
                't2.title',
                't2.route',
                't1.options',
                't2.options AS optionsl',
                't3.name AS icon',
            ]);
            $sth = $this->db->select($select)->from("categories AS t1");
            $sth->join("LEFT","categories_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $sth->join("LEFT","pictures AS t3","t3.owner='category' AND t3.owner_id=t1.id AND t3.reason='icon'");
            $sth->where("t2.id","IS NOT NULL","","&&");
            $sth->where("t1.status","=","active","&&");
            $sth->where("t1.visibility","=","visible","&&");
            $sth->where("t1.id","=",$id);
            if(!$sth->build())  return false;
            return $sth->getAssoc();
        }

        public function get_first_category_id($kind=''){
            $lang = Bootstrap::$lang->clang;
            $stmt = $this->db->select("t1.id")->from("categories AS t1");
            $stmt->join("LEFT","categories_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $stmt->where("t2.id","IS NOT NULL","","&&");
            $stmt->where("t1.type","=","products","&&");
            $stmt->where("t1.kind","=",$kind,"&&");
            $stmt->where("t1.parent","=",0);
            $stmt->limit(1);
            $stmt->order_by("rank ASC");
            return $stmt->build() ? $stmt->getObject()->id : false;
        }

        public function get_category($id=0,$lang){
            $this->db_start();
            $select = [
                't1.id',
                't1.kind',
                't1.parent',
                't2.title',
                't2.sub_title',
                't2.content',
                't2.seo_title',
                't2.seo_keywords',
                't2.seo_description',
                't2.route',
                't1.options',
                't2.options AS options_lang',
                't2.faq',
                't3.name AS header_background',
                't4.name AS icon',
            ];
            $sth = $this->db->select(implode(",",$select))->from("categories AS t1");
            $sth->join("LEFT","categories_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $sth->join("LEFT","pictures AS t3","t3.owner='category' AND t3.owner_id=t1.id AND t3.reason='header-background'");
            $sth->join("LEFT","pictures AS t4","t4.owner='category' AND t4.owner_id=t1.id AND t4.reason='icon'");
            $sth->where("t2.id","IS NOT NULL","","&&");
            $sth->where("t1.status","=","active","&&");
            $sth->where("t1.type","=","products","&&");
            $sth->where("t1.id","=",$id);
            if(!$sth->build())  return false;
            return $sth->getAssoc();
        }

        public function get_header_background_default($kind){
            $this->db_start();
            $sth = $this->db->select("name")->from("pictures");
            $sth->where("owner","=",$kind,"&&");
            $sth->where("reason","=","header-background");
            return $sth->build() ? $sth->getObject()->name : false;
        }

        public function get_header_background($category=0){
            $this->db_start();
            $sth = $this->db->select("name")->from("pictures");
            $sth->where("owner","=","category","&&");
            $sth->where("owner_id","=",$category,"&&");
            $sth->where("reason","=","header-background");
            if(!$sth->build()) return false;
            return $sth->getObject()->name;
        }


        public function get_sub_categories($parent=0,$kind='',$lang,$temp=[]){
            $sth = $this->db->select("t1.id")->from("categories AS t1");
            $sth->join("LEFT","categories_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $sth->where("t2.id","IS NOT NULL","","&&");
            $sth->where("t1.type","=","products","&&");
            $sth->where("t1.kind","=",$kind,"&&");
            $sth->where("t1.status","=","active","&&");
            $sth->where("t1.visibility","=","visible","&&");
            $sth->where("t1.parent","=",$parent);
            $sth->order_by("t1.rank ASC");
            $result = $sth->build() ? $sth->fetch_assoc() : [];
            if($result){
                foreach($result AS $res){
                    $temp[] = $res["id"];
                    $temp = $this->get_sub_categories($res["id"],$kind,$lang,$temp);
                }
            }
            return $temp;
        }

        public function get_parent_categories($id=0,$kind='',$lang,$temp=[]){
            $sth = $this->db->select("t1.id,t1.parent")->from("categories AS t1");
            $sth->join("LEFT","categories_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $sth->where("t2.id","IS NOT NULL","","&&");
            $sth->where("t1.type","=","products","&&");
            $sth->where("t1.kind","=",$kind,"&&");
            $sth->where("t1.status","=","active","&&");
            $sth->where("t1.visibility","=","visible","&&");
            $sth->where("t1.id","=",$id);
            $result = $sth->build() ? $sth->getAssoc() : [];
            if($result){
                if($result["parent"]){
                    $temp[] = $result["parent"];
                    $temp = $this->get_parent_categories($result["parent"], $kind, $lang, $temp);
                }
            }
            return $temp;
        }


    }