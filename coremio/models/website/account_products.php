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

        public function buy_addons_get_addons($lang='',$ids=''){
            $stmt    = $this->db->select("t1.id,t1.product_type_link,t1.product_id_link,t1.override_usrcurrency,t1.requirements,t2.name,t2.description,t2.type,t2.properties,t2.options")->from("products_addons AS t1");
            $stmt->join("LEFT","products_addons_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $stmt->where("t2.id","IS NOT NULL","","&&");
            $stmt->where("t1.status","=","active","&&");
            $stmt->where("FIND_IN_SET(t1.id,'".$ids."')");
            $stmt->order_by("t1.rank ASC,t1.id ASC");
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }


        public function get_requirement($id=0){
            $stmt   = $this->db->select()->from("users_products_requirements")->where("id","=",$id);
            return $stmt->build() ? $stmt->getAssoc() : false;
        }

        public function get_picture($owner='',$owner_id=0,$reason=''){
            $stmt   = $this->db->select("name")->from("pictures");
            $stmt->where("owner","=",$owner,"&&");
            $stmt->where("owner_id","=",$owner_id,"&&");
            $stmt->where("reason","=",$reason);
            return $stmt->build() ? $stmt->getObject()->name : false;
        }

        public function get_products_with_category($type='',$category=0){
            $ll_lang    = Bootstrap::$lang->clang;
            $select     = implode(",",[
                't1.id',
                't1.override_usrcurrency',
                't1.type',
                't1.options',
                't1.module',
                't1.module_data',
                't2.options AS options_lang',
                't2.title',
                't2.features',
                'CASE
                WHEN stock = "" THEN 1 
                WHEN stock IS NULL THEN 1 
                ELSE stock 
                END AS haveStock',
            ]);
            $stmt   = $this->db->select($select)->from("products AS t1");
            $stmt->join("LEFT","products_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$ll_lang."'");
            $stmt->where("t2.id","IS NOT NULL","","&&");
            $stmt->where("t1.type","=",$type,"&&");
            $stmt->where("t1.status","=","active","&&");
            $stmt->where("t1.visibility","=","visible","&&");
            $stmt->where("t1.category","=",$category);
            $stmt->order_by("t1.rank ASC");
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function get_products($uid=0,$type='',$pids=''){
            $format_convert = str_replace(['d','m','Y',],['%d','%m','%Y'],Config::get("options/date-format"));
            $case = "CASE ";
            $case .= "WHEN status = 'waiting' THEN 1 ";
            $case .= "WHEN status = 'inprocess' THEN 2 ";
            $case .= "WHEN status = 'active' THEN 3 ";
            $case .= "ELSE 4 ";
            $case .= "END AS rank";
            $sth = $this->db->select("id,type,product_id,name,status,period,period_time,amount,amount_cid,DATE_FORMAT(cdate,'".$format_convert." %H:%i') AS cdate,duedate,options,auto_pay,".$case)->from("users_products");
            if($pids != '')
                $sth->where("FIND_IN_SET(product_id,'".$pids."')","","","&&");
            if($type == ''){
                $sth->where("owner_id","=",$uid,"&&");
                $sth->where("type","!=","domain");
            }else{
                $sth->where("owner_id","=",$uid,"&&");
                $sth->where("type","=",$type);
            }
            $sth->order_by("rank ASC,id DESC");
            $sth->limit(0,99999);
            return $sth->build() ? $sth->fetch_assoc() : false;
        }

        public function isCategory($id=0,$lang){
            $sth = $this->db->select("t1.id,t2.title")->from("categories AS t1");
            $sth->join("LEFT","categories_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $sth->where("t2.id","IS NOT NULL","","&&");
            $sth->where("t1.type","=","products","&&");
            $sth->where("t1.id","=",$id);
            return $sth->build() ? $sth->getAssoc() : false;
        }

        public function product_category($pid=0,$lang=''){
            $pro = $this->db->select("category")->from("products")->where("id","=",$pid);
            if(!$pro->build()) return false;
            $pro = $pro->getObject();
            if($pro->category != 0){
                return $this->getTopCategory($pro->category,$lang);
            }
            return false;
        }

        public function getTopCategory($cat_id=0,$lang){
            $sth = $this->db->select("t1.id,t1.parent,t2.title")->from("categories AS t1");
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

        public function getProanSe($uid=0,$id=0){
            $sth = $this->db->select()->from("users_products");
            $sth->where("owner_id","=",$uid,"&&");
            $sth->where("id","=",$id);
            return $sth->build() ? $sth->getAssoc() : false;
        }

        public function getSoftwareProduct($id=0,$lang=''){
            $sth = $this->db->select("t1.id,t1.category,t2.title")->from("pages AS t1");
            $sth->join("LEFT","pages_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $sth->where("t2.id","IS NOT NULL","","&&");
            $sth->where("t1.id","=",$id);
            return $sth->build() ? $sth->getAssoc() : false;
        }

        public function getMainProduct($id=0,$lang=''){
            $sth = $this->db->select("t1.id,t1.category,t2.title")->from("products AS t1");
            $sth->join("LEFT","products_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $sth->where("t2.id","IS NOT NULL","","&&");
            $sth->where("t1.id","=",$id);
            return $sth->build() ? $sth->getAssoc() : false;
        }

        public function getGroups($uid=0,$pid=0){
            $sth = $this->db->select("id,name,numbers")->from("users_sms_groups");
            $sth->where("user_id","=",$uid,"&&");
            $sth->where("pid","=",$pid);
            return $sth->build() ? $sth->fetch_assoc() : false;
        }

        public function add_new_group($data=[]){
            return $this->db->insert("users_sms_groups",$data) ? $this->db->lastID() : false;
        }
        public function change_group_numbers($pid=0,$group=0,$uid=0,$numbers=NULL){
            $sth = $this->db->update("users_sms_groups",['numbers' => $numbers]);
            $sth->where("id","=",$group,"&&");
            $sth->where("user_id","=",$uid,"&&");
            $sth->where("pid","=",$pid);
            return $sth->save();
        }

        public function delete_group($pid=0,$group_id=0,$uid=0){
            $sth = $this->db->delete("users_sms_groups");
            $sth->where("user_id","=",$uid,"&&");
            $sth->where("pid","=",$pid,"&&");
            $sth->where("id","=",$group_id);
            return $sth->run();
        }

        public function group_check($pid=0,$group_id=0,$uid=0){
            $sth = $this->db->select("id")->from("users_sms_groups");
            $sth->where("user_id","=",$uid,"&&");
            $sth->where("pid","=",$pid,"&&");
            $sth->where("id","=",$group_id);
            return $sth->build();
        }

        public function check_origin_name($name='',$pid=0){
            $sth = $this->db->select()->from("users_sms_origins");
            $sth->where("name","=",$name,"&&");
            $sth->where("pid","=",$pid,"");
            return $sth->build() ? $sth->getAssoc() : false;
        }

        public function get_origin($id=0,$pid=0){
            $sth = $this->db->select()->from("users_sms_origins");
            $sth->where("id","=",$id,"&&");
            $sth->where("pid","=",$pid,"");
            return $sth->build() ? $sth->getAssoc() : false;
        }

        public function set_origin($id=0,$data=[]){
            return $this->db->update("users_sms_origins",$data)->where("id","=",$id)->save();
        }

        public function get_origins($uid=0,$pid=0){
            $case = "CASE ";
            $case .= "WHEN status = 'waiting' THEN 1 ";
            $case .= "WHEN status = 'active' THEN 2 ";
            $case .= "ELSE 3 ";
            $case .= "END AS rank";
            $sth = $this->db->select("*,".$case)->from("users_sms_origins");
            $sth->where("user_id","=",$uid,"&&");
            $sth->where("pid","=",$pid);
            $sth->order_by("rank ASC,id DESC");
            return $sth->build() ? $sth->fetch_assoc() : false;
        }

        public function update_product($pid=0,$uid=0,$data=[]){
            return $this->db->update("users_products",$data)->where("id","=",$pid,"&&")->where("owner_id","=",$uid)->save();
        }

        public function getOrigin($uid=0,$pid=0,$id=0){
            if($id != 0){
                $sth = $this->db->select("name")->from("users_sms_origins");
                $sth->where("id","=",$id,"&&");
                $sth->where("user_id","=",$uid,"&&");
                $sth->where("pid","=",$pid,"&&");
                $sth->where("status","=","active");
                return $sth->build() ? $sth->getObject()->name : false;
            }
            return false;
        }

        public function reports_total($uid=0,$pid=0){
            $sth = $this->db->select("COUNT(id) AS total")->from("sms_logs");
            $sth->where("user_id","=",$uid,"&&");
            $sth->where("owner_id","=",$pid,"&&");
            $sth->where("reason","=","send-sms","&&");
            $sth->where("owner","=","users_products");
            return $sth->build() ? $sth->getObject()->total : 0;
        }

        public function get_reports($uid=0,$pid=0){
            $sth = $this->db->select()->from("sms_logs");
            $sth->where("user_id","=",$uid,"&&");
            $sth->where("owner_id","=",$pid,"&&");
            $sth->where("reason","=","send-sms","&&");
            $sth->where("owner","=","users_products");
            $sth->order_by("id DESC");
            return $sth->build() ? $sth->fetch_assoc() : false;
        }

        public function get_report($id=0,$pid=0){
            $sth = $this->db->select("data")->from("sms_logs");
            $sth->where("owner_id","=",$pid,"&&");
            $sth->where("id","=",$id,"&&");
            $sth->where("reason","=","send-sms","&&");
            $sth->where("owner","=","users_products");
            return $sth->build() ? $sth->getAssoc() : false;
        }

        public function addAttachment($data=[]){
            return $this->db->insert("users_sms_origin_attachments",$data) ? $this->db->lastID() : false;
        }

        public function new_origin_request($data=[]){
            return $this->db->insert("users_sms_origins",$data) ? $this->db->lastID() : false;
        }

        public function getServer($id=0){
            return $this->db->select()->from("servers")->where("id","=",$id)->build() ? $this->db->getAssoc() : false;
        }

        public function getTLD($id=0,$name='',$lang=''){
            $sth = $this->db->select()->from("tldlist");
            if($name != '') $sth->where("name","=",$name);
            else $sth->where("id","=",$id);
            return $sth->build() ? $this->db->getAssoc() : false;
        }

        public function get_prices($type,$owner,$owner_id,$lang='none'){
            $this->db_start();
            $sth = $this->db->select("period,time,amount,discount,cid")->from("prices");
            $sth->where("type","=",$type,"&&");
            $sth->where("owner","=",$owner,"&&");
            $sth->where("owner_id","=",$owner_id);
            //$sth->where("lang","=",$lang);
            return $sth->build() ? $sth->fetch_assoc() : false;
        }

        public function get_price($type,$owner,$owner_id,$lang='none'){
            $sth = $this->db->select("period,time,amount,discount,cid")->from("prices");
            $sth->where("type","=",$type,"&&");
            $sth->where("owner","=",$owner,"&&");
            $sth->where("owner_id","=",$owner_id);
            //$sth->where("lang","=",$lang);
            return $sth->build() ? $sth->getAssoc() : [];
        }

        public function get_sms_products($lang=''){
            $select =  [
                't1.id',
                't2.title',
            ];
            $sth = $this->db->select(implode(",",$select))->from("products AS t1");
            $sth->join("LEFT","products_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $sth->where("t2.id","IS NOT NULL","","&&");
            $sth->where("t1.type","=","sms","&&");
            $sth->where('t1.status',"=","active","&&");
            $sth->where('t1.visibility',"=","visible");
            $sth->order_by("t1.rank ASC");
            return $sth->build() ? $this->db->fetch_assoc() : false;
        }

    }