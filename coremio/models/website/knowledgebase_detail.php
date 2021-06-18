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

        public function route_check($route='',$lang=''){
            $this->db_start();
            $sth = $this->db->select("owner_id")->from("knowledgebase_lang");
            $sth->where("route","=",$route,"&&");
            $sth->where("lang","=",$lang);
            if(!$sth->build()) return false;
            return $sth->getObject()->owner_id;
        }

        public function increase_visit($id=0){
            $this->db_start();
            $sth = $this->db->update("knowledgebase");
            $sth->set(['visit_count' => "visit_count+1"],true);
            $sth->where("id","=",$id);
            return $sth->save();
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


        public function article_count($lang,$ids='',$user=false){
            $stmt   = $this->db->select("COUNT(t1.id) AS count")->from("knowledgebase AS t1");
            $stmt->join("LEFT","knowledgebase_lang AS t2","t1.id=t2.owner_id AND t2.lang='".$lang."'");
            if(!$user) $stmt->where("t1.private","=","0","&&");
            $stmt->where("FIND_IN_SET(t1.category,'".$ids."')");
            return $stmt->build() ? $stmt->getObject()->count : 0;
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
            return ($sth->build()) ? $sth->fetch_assoc() : false;
        }

        public function vote($id=0,$vote='',$clang=''){
            $this->db_start();
            $sth = $this->db->update("knowledgebase");
            $sth->set([$vote => $vote."+1"],true);
            $sth->where("id","=",$id);
            return $sth->save();
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
            $sth->order_by("t1.id DESC");
            $sth->limit(10);
            return $sth->build() ? $sth->fetch_assoc() : false;
        }


        public function get_page($id=0,$clang){
            $user_check = UserManager::LoginCheck("member");
            $sth = $this->db->select(implode(",",[
                't1.id',
                't1.sidebar',
                't1.useful',
                't1.useless',
                't1.visit_count',
                't1.category',
                't2.route',
                't2.title',
                't2.content',
                't2.seo_title',
                't2.seo_keywords',
                't2.seo_description',
                '(SELECT name FROM '.$this->pfx.'pictures WHERE owner=\'page_knowledgebase\' AND reason=\'header-background\' AND owner_id=t1.id) AS header_background',
            ]))->from("knowledgebase AS t1");
            $sth->join("LEFT","knowledgebase_lang AS t2","t1.id=t2.owner_id AND t2.lang='{$clang}'");
            $sth->where("t2.id","IS NOT NULL","","&&");
            if(!$user_check) $sth->where("t1.private","=","0","&&");
            $sth->where("t1.id","=",$id);
            return ($sth->build()) ? $sth->getAssoc() : false;
        }

        public function get_category_header_background($category=0){
            $this->db_start();
            $sth = $this->db->select("name")->from("pictures");
            $sth->where("owner_id","=",$category,"&&");
            $sth->where("owner","=","category","&&");
            $sth->where("reason","=","header-background");
            if($sth->build())
                return $sth->getObject()->name;
            else
                return false;
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

        public function get_header_background_default(){
            $this->db_start();
            $sth = $this->db->select("name")->from("pictures");
            $sth->where("owner_id","=",0,"&&");
            $sth->where("owner","=","knowledgebase","&&");
            $sth->where("reason","=","header-background");
            if($sth->build())
                return $sth->getObject()->name;
            else
                return false;
        }



    }