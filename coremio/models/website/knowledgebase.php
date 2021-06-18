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

        public function get_most_popular($lang){
            $this->db_start();
            $select = [
                't1.id',
                't1.visit_count',
                't1.useful',
                't1.useless',
                't2.route',
                't2.title',
            ];
            $sth = $this->db->select(implode(",",$select))->from("knowledgebase AS t1");
            $sth->join("LEFT","knowledgebase_lang AS t2","t1.id=t2.owner_id AND t2.lang='".$lang."'");
            if(!UserManager::LoginCheck("member"))
                $sth->where("t1.private","=","0","&&");
            $sth->where("t2.id","IS NOT NULL","","");
            $sth->group_by("t1.id");
            $sth->order_by("t1.id DESC");
            $sth->limit(10);
            return $sth->build() ? $sth->fetch_assoc() : false;
        }

        public function category_route_check($route='',$lang=''){
            $this->db_start();
            $sth = $this->db->select("t1.id")->from("categories AS t1");
            $sth->join("LEFT","categories_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $sth->where("t2.id","IS NOT NULL","","&&");
            $sth->where("t1.type","=","knowledgebase","&&");
            $sth->where("t2.route","=",$route);
            if(!$sth->build()) return false;
            return $sth->getObject()->id;
        }

        public function get_category($id=0,$clang){
            $this->db_start();
            $sth = $this->db->select(implode(",",[
                't1.id',
                't1.parent',
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
            $sth->where("t1.type","=","knowledgebase","&&");
            $sth->where("t1.id","=",$id);
            return ($sth->build()) ? $sth->getAssoc() : false;
        }

        public function get_list($category=0,$clang,$start=0,$end=1){
            $this->db_start();
            $select = [
                't1.id',
                't1.visit_count',
                't1.useful',
                't1.useless',
                't2.title',
                't2.route',
            ];
            $sth = $this->db->select(implode(",",$select))->from("knowledgebase AS t1");
            $sth->join("LEFT","knowledgebase_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$clang."'");
            if(!UserManager::LoginCheck("member"))
                $sth->where("t1.private","=","0","&&");
            if($category !=0) {
                $sth->where("(");
                $sth->where("t1.category","=",$category,"||");
                $sth->where("FIND_IN_SET(" . $category . ",t1.categories)", "", "");
                $sth->where(")","","","&&");
            }
            $sth->where("t2.id","IS NOT NULL","","");


            $sth->group_by("t1.id");

            if($category==0)
                $sth->order_by("t1.visit_count DESC");
            else
                $sth->order_by("t1.rank ASC");
            $sth->limit($start,$end);
            return ($sth->build()) ? $sth->fetch_assoc() : false;
        }

        public function get_search_list($query='',$clang,$start=0,$end=1){
            $this->db_start();
            $select = [
                't1.id',
                't1.visit_count',
                't1.useful',
                't1.useless',
                't2.title',
                't2.route',
            ];
            $sth = $this->db->select(implode(",",$select))->from("knowledgebase AS t1");
            $sth->join("LEFT","knowledgebase_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$clang."'");
            $sth->where("t2.id","IS NOT NULL","","&&");
            if(!UserManager::LoginCheck("member"))
                $sth->where("t1.private","=","0","&&");
            $sth->where("(");
            $sth->where("t2.title","LIKE","%".$query."%","||");
            $sth->where("t2.content","LIKE","%".$query."%","||");
            $sth->where("t2.tags","LIKE","%".$query."%");
            $sth->where(")");

            $sth->group_by("t1.id");

            $sth->order_by("t1.rank ASC");
            $sth->limit($start,$end);
            return ($sth->build()) ? $sth->fetch_assoc() : false;
        }

        public function get_header_background($category=0){
            $this->db_start();
            $sth = $this->db->select("name")->from("pictures");
            if($category ==0){
                $sth->where("owner_id","=",0,"&&");
                $sth->where("owner","=","knowledgebase","&&");
                $sth->where("reason","=","header-background");
            }else{
                $sth->where("owner_id","=",$category,"&&");
                $sth->where("owner","=","categories","&&");
                $sth->where("reason","=","header-background");
            }
            if($sth->build())
                return $sth->getObject()->name;
            else
                return false;
        }

        public function get_total_list_count($category=0,$clang=''){
            $this->db_start();
            $sth = $this->db->select("t1.id")->from("knowledgebase AS t1");
            $sth->join("LEFT","knowledgebase_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$clang."'");
            if(!UserManager::LoginCheck("member"))
                $sth->where("t1.private","=","0","&&");
            if($category !=0) {
                $sth->where("(");
                $sth->where("t1.category","=",$category,"||");
                $sth->where("FIND_IN_SET(" . $category . ",t1.categories)", "", "");
                $sth->where(")","","","&&");
            }
            $sth->where("t2.id","IS NOT NULL","","");
            $sth->group_by("t1.id");
            return ($sth->build()) ? $sth->getCount() : 0;
        }

        public function get_total_search_list_count($query='',$clang=''){
            $this->db_start();
            $sth = $this->db->select("t1.id")->from("knowledgebase AS t1");
            $sth->join("LEFT","knowledgebase_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$clang."'");
            $sth->where("t2.id","IS NOT NULL","","&&");
            if(!UserManager::LoginCheck("member"))
                $sth->where("t1.private","=","0","&&");
            $sth->where("(");
            $sth->where("t2.title","LIKE","%".$query."%","||");
            $sth->where("t2.content","LIKE","%".$query."%","||");
            $sth->where("t2.tags","LIKE","%".$query."%");
            $sth->where(")");
            $sth->group_by("t1.id");
            return ($sth->build()) ? $sth->getCount() : 0;
        }

        public function article_count($lang,$ids='',$user=false){
            $stmt   = $this->db->select("t1.id")->from("knowledgebase AS t1");
            if(!$user) $stmt->where("t1.private","=","0","&&");
            $stmt->where("FIND_IN_SET(t1.category,'".$ids."')");
            $stmt->group_by("t1.id");
            return $stmt->build() ? $stmt->rowCounter() : 0;
        }

        public function get_category_sub($id=0,$data=[]){
            $stmt   = $this->db->select("id")->from("categories");
            $stmt->where("parent","=",$id);
            if($stmt->build()){
                foreach($stmt->fetch_assoc() AS $f){
                    $data[]     = $f["id"];
                    $children   = $this->get_category_sub($f["id"]);
                    if($children) $data = array_merge($data,$children);
                }
                return $data;
            }else
                return $data;
        }


        public function categories($parent=0,$clang){
            $select = [
                't1.id',
                't1.parent',
                't2.title',
                't2.route',
                't2.content',
            ];
            $sth = $this->db->select(implode(",",$select))->from("categories AS t1");
            $sth->join("LEFT","categories_lang AS t2","t1.id=t2.owner_id AND t2.lang='{$clang}'");
            $sth->where("type","=","knowledgebase","&&");
            $sth->where("status","=","active","&&");
            $sth->where("t2.id","IS NOT NULL","","&&");
            $sth->where("t1.parent","=",$parent);
            $sth->order_by("t1.rank ASC");
            $sth->limit(100);
            return $sth->build() ? $sth->fetch_assoc() : [];
        }

        public function get_header_background_default(){
            $this->db_start();
            $sth = $this->db->select("name")->from("pictures");
            $sth->where("owner","=","knowledgebase","&&");
            $sth->where("reason","=","header-background");
            if(!$sth->build()) return false;
            return $sth->getObject()->name;
        }

    }