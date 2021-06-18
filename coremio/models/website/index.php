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

        public function getTLD($name='',$rank='0'){
            $sth = $this->db->select()->from("tldlist");
            $sth->where("status","=","active","&&");
            if($name != '') $sth->where("name","=",$name);
            elseif(!is_string($rank)) $sth->where("rank","=",$rank);
            return $sth->build() ? $sth->getAssoc() : false;
        }

        public function get_software($id=0,$lang){
            $this->db_start();
            $select = [
                't1.id',
                't2.route',
                't2.title',
                't1.options',
                't1.override_usrcurrency',
                't2.options AS optionsl',
                't3.name AS cover_image',
            ];
            $sth = $this->db->select(implode(",",$select))->from("pages AS t1");
            $sth->join("LEFT","pages_lang AS t2","t1.id=t2.owner_id AND t2.lang='".$lang."'");
            $sth->join("LEFT","pictures AS t3","t3.owner='page_software' AND t1.id=t3.owner_id AND t3.reason='cover'");
            $sth->where("t2.id","IS NOT NULL","","&&");
            $sth->where("t1.type","=","software","&&");
            $sth->where("t1.status","=","active","&&");
            $sth->where("t1.visibility","=","visible","&&");
            $sth->where("t1.id","=",$id);
            return $sth->build() ? $sth->getAssoc() : false;
        }

        public function get_product_category($id=0,$clang=''){
            $this->db_start();
            $select = [
                't1.id',
                't1.type',
                't1.kind',
                't1.options',
                't2.options AS optionsl',
                't2.title',
                't2.sub_title',
                't2.route',
                't3.name AS background_image',
            ];
            $sth = $this->db->select(implode(",",$select))->from("categories AS t1");
            $sth->join("LEFT","categories_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$clang."'");
            $sth->join("LEFT","pictures AS t3","t3.owner='category' AND t3.owner_id=t1.id AND t3.reason='background-image'");
            $sth->where("t2.id","IS NOT NULL","","&&");
            $sth->where("t1.type","=","products","&&");
            $sth->where("t1.status","=","active","&&");
            $sth->where("t1.visibility","=","visible","&&");
            $sth->where("t1.id","=",$id);
            return $sth->build() ? $sth->getAssoc() : false;
        }

        public function get_products_groups($kind,$clang=''){
            $this->db_start();
            $select = [
                't1.id',
                't1.type',
                't1.kind',
                't1.options',
                't2.options AS optionsl',
                't2.title',
                't2.sub_title',
                't2.route',
                't3.name AS background_image',
            ];
            $sth = $this->db->select(implode(",",$select))->from("categories AS t1");
            $sth->join("LEFT","categories_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$clang."'");
            $sth->join("LEFT","pictures AS t3","t3.owner='category' AND t3.owner_id=t1.id AND t3.reason='background-image'");
            $sth->where("t2.id","IS NOT NULL","","&&");
            $sth->where("t1.type","=","products","&&");
            $kinds = explode(",",$kind);
            $i      = 0;
            $sumki  = sizeof($kinds);
            $sth->where("(");
            foreach($kinds AS $ki){
                $i++;$sth->where("t1.kind","=",$ki,$i == $sumki ? '' : "||");
            }
            $sth->where(")","","","&&");
            $sth->where("t1.parent","=","0","&&");
            $sth->where("t1.status","=","active","&&");
            $sth->where("t1.options","LIKE",'%"home_shown":true%');
            $sth->order_by("t1.rank ASC");
            if(!$sth->build())  return [];
            return $sth->fetch_assoc();
        }

        public function get_products_categories($kind,$group_id=0,$limit,$clang){
            $this->db_start();
            $select = [
                't1.id',
                't1.options',
                't2.title',
                't2.sub_title',
                't2.route',
                't3.name AS background_image',
            ];
            $sth = $this->db->select(implode(",",$select))->from("categories AS t1");
            $sth->join("LEFT","categories_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$clang."'");
            $sth->join("LEFT","pictures AS t3","t3.owner='category' AND t3.owner_id=t1.id AND t3.reason='background-image'");
            $sth->where("t2.id","IS NOT NULL","","&&");
            $sth->where("t1.type","=","products","&&");
            $sth->where("t1.kind","=",$kind,"&&");
            $sth->where("t1.parent","=",$group_id,"&&");
            $sth->where("t1.status","=","active","&&");
            $sth->where("t1.options","LIKE",'%"home_shown":true%');
            $sth->order_by("t1.rank ASC");
            $sth->limit($limit);
            if(!$sth->build())  return [];
            return $sth->fetch_assoc();
        }

        public function get_products($category=0,$limit,$clang=''){
            $select = [
                't1.id',
                't1.type',
                't1.options AS options1',
                't2.options AS options2',
                't2.title',
                't2.features',
                't3.name AS cover_image',
                't1.override_usrcurrency',
                'CASE
                WHEN stock = "" THEN 1 
                WHEN stock IS NULL THEN 1 
                ELSE stock 
                END AS haveStock',
            ];
            $sth = $this->db->select(implode(",",$select))->from("products AS t1");
            $sth->join("LEFT","products_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$clang."'");
            $sth->join("LEFT","pictures AS t3","t3.owner='products' AND t3.owner_id=t1.id AND t3.reason='cover'");
            $sth->where("t2.id","IS NOT NULL","","&&");
            if(Validation::isInt($category)){
                $sth->where("(");
                $sth->where("t1.category","=",$category,"||");
                $sth->where("FIND_IN_SET(" . $category . ",t1.categories)", "", "");
                $sth->where(")","","","&&");
            }else{
                $sth->where("t1.type","=",$category,"&&");
            }
            $sth->where("t1.status","=","active","&&");
            $sth->where("t1.visibility","=","visible");
            $sth->order_by("t1.rank ASC");
            $sth->limit($limit);
            return $sth->build() ? $sth->fetch_assoc() : false;
        }

        public function slides(){
            $this->db_start();
            $lang = Bootstrap::$lang->clang;
            $statement = $this->db->select("t1.*,t2.title,t2.description,t2.link,t3.name AS image")
                ->from("slides AS t1")
                ->join("LEFT","slides_lang AS t2","t1.id=t2.owner_id")
                ->join("LEFT","pictures AS t3","t1.id=t3.owner_id AND t3.owner='slides' AND t3.reason='main-image'")
                ->where('t2.id','IS NOT NULL','','&&')
                ->where('t3.id','IS NOT NULL','','&&')
                ->where('t1.status','=',"active",'&&')
                ->where('t2.lang','=',$lang)
                ->order_by("t1.rank ASC")
                ->build();
            if(!$statement)
                return false;
            $fetch = $this->db->fetch_assoc();
            return $fetch;
        }

        public function cfeedbacks($lang=''){
            $this->db_start();
            $sth = $this->db->select("t1.*,t2.message,t3.name AS image")->from("customer_feedbacks AS t1");
            $sth->join("LEFT","customer_feedbacks_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $sth->join("LEFT","pictures AS t3","t1.id=t3.owner_id AND t3.owner='customer_feedback' AND t3.reason='image'");
            $sth->where("t2.id","IS NOT NULL","","&&");
            $sth->where("status","=","approved");
            $sth->order_by("t1.rank ASC,id DESC");
            $sth->limit(5);
            return $sth->build() ? $sth->fetch_assoc() : false;
        }

        public function page_short_list($type,$limit=1){
            $format_convert = str_replace(['d','m','Y',],['%d','%m','%Y'],Config::get("options/date-format"));
            $this->db_start();
            $clang = Bootstrap::$lang->clang;
            $select = implode(",",[
                't1.id',
                't1.visible_to_user',
                'DATE_FORMAT(t1.ctime,"'.$format_convert.'") AS date',
                't2.route',
                't2.title',
                't2.content',
                't3.name AS image'
            ]);
            $sth = $this->db->select($select)->from("pages AS t1");
            $sth->join("LEFT","pages_lang AS t2","t1.id=t2.owner_id AND t2.lang='".$clang."'");
            $sth->join("LEFT","pictures AS t3","t1.id=t3.owner_id AND t3.owner='page_".$type."' AND t3.reason='cover'");
            $sth->where("t2.id","IS NOT NULL","","&&");
            $sth->where("type","=",$type,"&&");
            $sth->where("status","=","active","&&");
            $sth->where("t1.visibility","=","visible");
            $sth->order_by("t1.id DESC")->limit($limit)->build();
            if(!$sth)
                return false;
            $fetch = $this->db->fetch_assoc();
            return $fetch;
        }

        public function get_picture($id=0){
            if($id==0) return false;
            $this->db_start();
            $statement = $this->db->select("name")
                ->from("pictures")
                ->where('id',"=",$id)
                ->order_by("id ASC");
            return $statement->build() ? $statement->getObject()->name : false;
        }
    }