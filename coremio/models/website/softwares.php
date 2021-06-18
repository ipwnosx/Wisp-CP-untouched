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
            $sth->where("t1.type","=","software","&&");
            $sth->where("t2.route","=",$route);
            if(!$sth->build()) return false;
            return $sth->getObject()->id;
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
                '(SELECT name FROM '.$this->pfx.'pictures WHERE owner=\'category\' AND reason=\'header-background\' AND owner_id=t1.id) AS header_background',
            ];
            $sth = $this->db->select(implode(",",$select))->from("categories AS t1");
            $sth->join("LEFT","categories_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $sth->where("t2.id","IS NOT NULL","","&&");
            $sth->where("t1.status","=","active","&&");
            $sth->where("t1.type","=","software","&&");
            $sth->where("t1.parent","=",0,"&&");
            $sth->where("t1.id","=",$id);
            if(!$sth->build())  return false;
            return $sth->getAssoc();
        }

        public function get_header_background_default(){
            $this->db_start();
            $sth = $this->db->select("name")->from("pictures");
            $sth->where("owner","=","softwares","&&");
            $sth->where("reason","=","header-background");
            if(!$sth->build()) return false;
            return $sth->getObject()->name;
        }

        public function get_categories($lang){
            $this->db_start();
            $select = implode(",",[
                't1.id',
                't2.title',
                't2.route',
                '(SELECT COUNT(p.id) FROM '.$this->pfx.'pages AS p WHERE (t1.id=p.category OR FIND_IN_SET(t1.id,p.categories)) AND p.status="active" AND p.visibility="visible") AS count'
            ]);
            $sth = $this->db->select($select)->from("categories AS t1");
            $sth->join("LEFT","categories_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $sth->where("t2.id","IS NOT NULL","","&&");
            $sth->where("t1.type","=","software","&&");
            $sth->where("t1.status","=","active","&&");
            $sth->where("t1.visibility","=","visible","&&");
            $sth->where("t1.parent","=",0);
            $sth->order_by("t1.rank ASC");
            if(!$sth->build())  return false;
            return $sth->fetch_assoc();
        }

        public function get_total($category=0,$term='',$lang){
            $this->db_start();
            $sth = $this->db->select("t1.id")->from("pages AS t1");
            $sth->join("LEFT","pages_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            if($category!=0){
                $sth->where("(");
                $sth->where("t1.category","=",$category,"||");
                $sth->where("FIND_IN_SET(" . $category . ",t1.categories)", "", "");
                $sth->where(")","","","&&");
            }
            if($term){
                $sth->where("(");
                $sth->where("t2.title","LIKE","%".$term."%","||");
                $sth->where("t2.content","LIKE","%".$term."%","");
                $sth->where(")","","","&&");
            }
            $sth->where("t2.id","IS NOT NULL","","&&");
            $sth->where("t1.type","=","software","&&");
            $sth->where("t1.status","=","active","&&");
            $sth->where("t1.visibility","=","visible");
            if(!$sth->build()) return 0;
            return $sth->rowCounter();
        }

        public function get_list($category=0,$term='',$start=0,$end=1,$lang){
            $this->db_start();
            $select = implode(",",[
                't1.id',
                't1.override_usrcurrency',
                't2.route',
                't2.title',
                't1.options',
                't2.options AS optionsl',
                't3.name AS cover_image',
            ]);
            $sth = $this->db->select($select)->from("pages AS t1");
            $sth->join("LEFT","pages_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $sth->join("LEFT","pictures AS t3","t3.owner='page_software' AND t1.id=t3.owner_id AND t3.reason='cover'");
            if($category!=0){
                $sth->where("(");
                $sth->where("t1.category","=",$category,"||");
                $sth->where("FIND_IN_SET(" . $category . ",t1.categories)", "", "");
                $sth->where(")","","","&&");
            }
            if($term){
                $sth->where("(");
                $sth->where("t2.title","LIKE","%".$term."%","||");
                $sth->where("t2.content","LIKE","%".$term."%","");
                $sth->where(")","","","&&");
            }
            $sth->where("t2.id","IS NOT NULL","","&&");
            $sth->where("t1.type","=","software","&&");
            $sth->where("t1.status","=","active","&&");
            $sth->where("t1.visibility","=","visible");
            $sth->group_by("t1.id");
            if($category!=0){
                $sth->order_by("t1.rank ASC");
            }else{
                $sth->order_by("t1.id DESC");
            }
            $sth->limit($start,$end);
            if(!$sth->build()) return 0;
            return $sth->fetch_assoc();
        }

    }