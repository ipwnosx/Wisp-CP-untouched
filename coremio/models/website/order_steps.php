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

        public function get_header_background_default($type=''){
            $stmt   = $this->db->select("name")->from("pictures");
            if($type == "software"){
                $stmt->where("owner","=","page_software","&&");
                $stmt->where("owner_id","=","0");
            }else
                $stmt->where("owner","=",$type);

            return $stmt->build() ? $stmt->getObject()->name : false;
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

        public function get_software_product($id=0){
            $select = implode(",",[
                't1.id',
                't1.category',
                '(SELECT name FROM '.$this->pfx.'pictures WHERE owner=\'page_software\' AND reason=\'header-background\' AND owner_id=t1.id LIMIT 1) AS header_background',
            ]);
            $stmt   = $this->db->select($select)->from("pages AS t1");
            $stmt->where("t1.id","=",$id);
            return $stmt->build() ? $stmt->getAssoc() : false;
        }

        public function get_product($id=0){
            $select = implode(",",[
                'id',
                'category',
            ]);
            $stmt   = $this->db->select($select)->from("products");
            $stmt->where("id","=",$id);
            return $stmt->build() ? $stmt->getAssoc() : false;
        }

        public function get_product_software($id=0,$lang=''){
            $select = implode(",",[
                't1.id',
                't2.title',
                't2.route',
                't1.options',
                't1.override_usrcurrency',
                't2.options AS optionsl',
                't3.title AS category_title',
                't3.route AS category_route',
            ]);
            $sth = $this->db->select($select)->from("pages AS t1");
            $sth->join("LEFT","pages_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $sth->join("LEFT","categories_lang AS t3","t3.owner_id=t1.category AND t3.lang='".$lang."'");
            $sth->where("t2.id","IS NOT NULL","","&&");
            $sth->where("t1.type","=","software","&&");
            $sth->where("t1.status","=","active","&&");
            $sth->where("t1.id","=",$id);
            return $sth->build() ? $sth->getAssoc() : false;
        }

        public function header_background(){
            $sth = $this->db->select("name")->from("pictures");
            $sth->where("owner","=","order-steps","&&");
            $sth->where("reason","=","header-background");
            $sth->order_by("id DESC");
            return $sth->build() ? $sth->getObject()->name : false;
        }

        public function getTLD($name='',$rank='0'){
            $select = implode(",",[
                'id',
                'name',
                'promo_status',
                'promo_duedate',
                'promo_register_price',
            ]);
            $sth = $this->db->select($select)->from("tldlist");
            $sth->where("status","=","active","&&");
            if($name != '') $sth->where("name","=",$name);
            elseif(!is_string($rank)) $sth->where("rank","=",$rank);
            return $sth->build() ? $sth->getAssoc() : false;
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
            return $sth->build() ? $sth->getAssoc() : [];
        }

        public function getCategoriesHosting($parent=0,$lang=''){
            $sth = $this->db->select("t1.id,t2.title,t2.route")->from("categories AS t1");
            $sth->join("LEFT","categories_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $sth->where("t2.id","IS NOT NULL","","&&");
            $sth->where("t1.parent","=",$parent,"&&");
            $sth->where("t1.type","=","products","&&");
            $sth->where("t1.kind","=","hosting","&&");
            $sth->where("t1.status","=","active","&&");
            $sth->where("t1.visibility","=","visible");
            $sth->order_by("t1.rank ASC");
            return $sth->build() ? $sth->fetch_assoc() : false;
        }

        public function getProductsHosting($category=0,$lang=''){
            $sth = $this->db->select("t1.id,t1.override_usrcurrency,t2.title,t1.options,t2.options AS optionsl,t1.module_data")->from("products AS t1");
            $sth->join("LEFT","products_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $sth->where("t2.id","IS NOT NULL","","&&");
            $sth->where("(");
            $sth->where("t1.category","=",$category,"||");
            $sth->where("FIND_IN_SET(" . $category . ",t1.categories)", "", "");
            $sth->where(")","","","&&");
            $sth->where("t1.type","=","hosting","&&");
            $sth->where("t1.status","=","active","&&");
            $sth->where("t1.visibility","=","visible");
            $sth->order_by("t1.rank ASC");
            return $sth->build() ? $sth->fetch_assoc() : false;
        }

        public function getProductHosting($id=0,$lang=''){
            $sth = $this->db->select("t1.id,t1.category,t1.override_usrcurrency,t2.title,t1.module,t1.module_data,t1.options")->from("products AS t1");
            $sth->join("LEFT","products_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $sth->where("t2.id","IS NOT NULL","","&&");
            $sth->where("t1.type","=","hosting","&&");
            $sth->where("t1.status","=","active","&&");
            $sth->where("t1.visibility","=","visible","&&");
            $sth->where("t1.id","=",$id);
            return $sth->build() ? $sth->getAssoc() : false;
        }

        public function getTopCategory($cat_id=0,$lang){
            $sth = $this->db->select("t1.id,t1.parent,t2.title,t2.route")->from("categories AS t1");
            $sth->join("LEFT","categories_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $sth->where("t2.id","IS NOT NULL","","&&");
            $sth->where("t1.id","=",$cat_id);
            if($sth->build()){
                $get = $sth->getAssoc();
                if($get["parent"] != 0)
                    return $this->getTopCategory($get["parent"],$lang);
                else
                    return $get;
            }else
                return false;
        }

        public function getCategory($cat_id=0,$lang){
            $sth = $this->db->select("t1.id,t1.parent,t2.title,t2.route")->from("categories AS t1");
            $sth->join("LEFT","categories_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $sth->where("t2.id","IS NOT NULL","","&&");
            $sth->where("t1.id","=",$cat_id);
            return $sth->build() ? $sth->getAssoc() : false;
        }

        public function addAttachment_Origin($data=[]){
            return $this->db->insert("users_sms_origin_attachments",$data) ? $this->db->lastID() : false;
        }

        public function get_addon($lang='',$id=0){
            $stmt    = $this->db->select("t1.id,t1.override_usrcurrency,t2.name,t2.description,t2.type,t2.options")->from("products_addons AS t1");
            $stmt->join("LEFT","products_addons_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $stmt->where("t2.id","IS NOT NULL","","&&");
            $stmt->where("t1.status","=","active","&&");
            $stmt->where("t1.id","=",$id);
            return $stmt->build() ? $stmt->getAssoc() : false;
        }

        public function get_requirement($lang='',$id=0){
            $stmt    = $this->db->select("t1.id,t2.name,t2.description,t2.type,t2.properties,t2.options")->from("products_requirements AS t1");
            $stmt->join("LEFT","products_requirements_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $stmt->where("t2.id","IS NOT NULL","","&&");
            $stmt->where("t1.status","=","active","&&");
            $stmt->where("t1.id","=",$id);
            return $stmt->build() ? $stmt->getAssoc() : false;
        }

        public function get_addons($lang='',$ids=''){
            $stmt    = $this->db->select("t1.id,t1.product_type_link,t1.product_id_link,t1.override_usrcurrency,t1.requirements,t2.name,t2.description,t2.type,t2.properties,t2.options")->from("products_addons AS t1");
            $stmt->join("LEFT","products_addons_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $stmt->where("t2.id","IS NOT NULL","","&&");
            $stmt->where("t1.status","=","active","&&");
            $stmt->where("FIND_IN_SET(t1.id,'".$ids."')");
            $stmt->order_by("t1.rank ASC,t1.id ASC");
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function get_requirements($lang='',$ids=''){
            $stmt    = $this->db->select("t1.id,t2.name,t2.description,t2.type,t2.properties,t2.options")->from("products_requirements AS t1");
            $stmt->join("LEFT","products_requirements_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $stmt->where("t2.id","IS NOT NULL","","&&");
            $stmt->where("t1.status","=","active","&&");
            $stmt->where("FIND_IN_SET(t1.id,'".$ids."')");
            $stmt->order_by("t1.rank ASC,id ASC");
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function check_hosting($domain='')
        {
            $sth    = $this->db->select("id")->from("users_products");
            $sth->where("type","=","hosting","&&");
            $sth->where("FIND_IN_SET(status,'active,suspended')","","","&&");
            $sth->where("options","LIKE","%".$domain."%");
            $sth->limit(1);
            return $sth->build() ? $sth->getObject()->id : false;
        }

    }