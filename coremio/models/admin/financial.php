<?php
    defined('CORE_FOLDER') OR exit('You can not get in here!');
    class Model extends Models
    {
        function __construct()
        {
            parent::__construct();
        }

        public function isit_used($id=0){
            $check1 = $this->db->select("id")->from("prices")->where("cid","=",$id)->build();
            return $check1;
        }

        public function check_currency_countries($lang='',$countries='',$id=0){
            $select = implode(",",[
                't2.name AS country_name',
                't3.name AS currency_name',
            ]);
            $stmt   = $this->db->select($select)->from("countries AS t1");
            $stmt->join("LEFT","countries_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $stmt->join("LEFT","currencies AS t3","t3.id!=".$id." AND FIND_IN_SET(t1.a2_iso,t3.countries)");
            $stmt->where("t2.id","IS NOT NULL","","&&");
            $stmt->where("t3.id","IS NOT NULL","","&&");
            $stmt->where("FIND_IN_SET(t1.a2_iso,'".$countries."')");
            return $stmt->build() ? $stmt->getAssoc() : false;
        }

        public function get_currency_countries($lang='',$countries='',$id=0){
            $select = implode(",",[
                't1.a2_iso AS code',
                't2.name',
                'CASE WHEN FIND_IN_SET(t1.a2_iso,"'.$countries.'") THEN 1 ELSE 0 END AS selected',
            ]);
            $stmt   = $this->db->select($select)->from("countries AS t1");
            $stmt->join("LEFT","countries_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $stmt->where("t2.id","IS NOT NULL");
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function set_coupon($id=0,$data=[]){
            return $this->db->update("coupons",$data)->where("id","=",$id)->save();
        }
        public function set_promotion($id=0,$data=[]){
            return $this->db->update("promotions",$data)->where("id","=",$id)->save();
        }

        public function delete_coupon($id=0){
            return $this->db->delete("coupons")->where("id","=",$id)->run();
        }
        public function delete_promotion($id=0){
            return $this->db->delete("promotions")->where("id","=",$id)->run();
        }

        public function get_coupon($id=0){
            $stmt =  $this->db->select()->from("coupons")->where("id","=",$id);
            return $stmt->build() ? $stmt->getAssoc() : false;
        }
        public function get_promotion($id=0){
            $stmt =  $this->db->select()->from("promotions")->where("id","=",$id);
            return $stmt->build() ? $stmt->getAssoc() : false;
        }

        public function get_coupon_list(){
            /*
            $case = "CASE ";
            $case .= "WHEN status = 'active' AND duedate != '1881-05-19 00:00:00' AND maxuses!=0 AND uses!=maxuses AND duedate > '".DateManager::Now()."' THEN 0 ";
            $case .= "WHEN status = 'active' AND duedate != '1881-05-19 00:00:00' AND maxuses=0 AND uses!=maxuses AND duedate > '".DateManager::Now()."' THEN 0 ";
            $case .= "WHEN status = 'active' AND duedate = '1881-05-19 00:00:00' AND maxuses!=0 AND uses!=maxuses THEN 0 ";
            $case .= "WHEN status = 'active' AND duedate = '1881-05-19 00:00:00' AND maxuses=0 THEN 0 ";
            $case .= "WHEN status = 'inactive' THEN 1 ";
            $case .= "WHEN duedate != '1881-05-19 00:00:00' AND duedate < '".DateManager::Now()."' THEN 1 ";
            $case .= "ELSE 2 ";
            $case .= "END AS rank";
            */
            $stmt   = $this->db->select()->from("coupons");
            $stmt->where("status","!=","delete");
            $stmt->order_by("id DESC");
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function get_promotion_list(){
            $case = "CASE ";
            $case .= "WHEN status = 'active' AND duedate != '1881-05-19 00:00:00' AND maxuses!=0 AND uses!=maxuses AND duedate > '".DateManager::Now()."' THEN 0 ";
            $case .= "WHEN status = 'active' AND duedate != '1881-05-19 00:00:00' AND maxuses=0 AND uses!=maxuses AND duedate > '".DateManager::Now()."' THEN 0 ";
            $case .= "WHEN status = 'active' AND duedate = '1881-05-19 00:00:00' AND maxuses!=0 AND uses!=maxuses THEN 0 ";
            $case .= "WHEN status = 'active' AND duedate = '1881-05-19 00:00:00' AND maxuses=0 THEN 0 ";
            $case .= "WHEN status = 'inactive' THEN 1 ";
            $case .= "WHEN duedate != '1881-05-19 00:00:00' AND duedate < '".DateManager::Now()."' THEN 1 ";
            $case .= "ELSE 2 ";
            $case .= "END AS rank";
            $stmt   = $this->db->select("*,".$case)->from("promotions");
            $stmt->where("status","!=","delete");
            $stmt->order_by("rank ASC,id DESC");
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function add_new_coupon($data=[]){
            return $this->db->insert("coupons",$data);
        }
        public function add_new_promotion($data=[]){
            return $this->db->insert("promotions",$data);
        }

        public function get_tlds(){
            $stmt   = $this->db->select("id,name")->from("tldlist");
            $stmt->order_by("id DESC");
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }


        public function get_software_categories(){
            $ll_lang    = Config::get("general/local");
            #$sd_lang    = Bootstrap::$lang->clang;
            $stmt = $this->db->select("c.id,cl.title")->from("categories AS c");
            $stmt->join("LEFT","categories_lang AS cl","cl.owner_id=c.id AND (cl.lang='".$ll_lang."')");
            $stmt->where("cl.id","IS NOT NULL","","&&");
            $stmt->where("c.parent","=","0","&&");
            $stmt->where("c.type","=","software");
            $stmt->order_by("c.id DESC");
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function get_product_group_categories($kind='',$parent=0,$line='-'){
            $ll_lang    = Config::get("general/local");
            //$sd_lang    = Bootstrap::$lang->clang;
            $stmt = $this->db->select("c.id,cl.title,c.parent")->from("categories AS c");
            $stmt->join("LEFT","categories_lang AS cl","cl.owner_id=c.id AND (cl.lang='".$ll_lang."')");
            $stmt->where("cl.id","IS NOT NULL","","&&");
            $stmt->where("c.parent","=",$parent,"&&");
            $stmt->where("c.kind","=",$kind,"&&");
            $stmt->where("c.type","=","products");
            $stmt->order_by("c.rank ASC");
            $result     = $stmt->build() ? $stmt->fetch_assoc() : [];
            $new_result = [];
            if($result){
                foreach($result AS $res){
                    $new    = $res;
                    $new["title"] = $line." ".$res["title"];
                    $new_result[] = $new;
                    $sub_result = $this->get_product_group_categories($kind,$res["id"],$line."-");
                    if($sub_result){
                        $new_result = array_merge($new_result,$sub_result);
                    }
                }
            }

            return $new_result;
        }

        public function get_product_special_groups($lang=''){
            if(!$lang) $lang = Config::get("general/local");
            $stmt = $this->db->select("c.id,cl.title")->from("categories AS c");
            $stmt->join("LEFT","categories_lang AS cl","cl.owner_id=c.id AND cl.lang='".$lang."'");
            $stmt->where("cl.id","IS NOT NULL","","&&");
            $stmt->where("c.parent","=","0","&&");
            $stmt->where("c.type","=","products","&&");
            $stmt->where("c.kind","=","special");
            $stmt->order_by("c.id DESC");
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function get_category_products($type='',$category=0){
            $ll_lang    = Config::get("general/local");
            //$sd_lang    = Bootstrap::$lang->clang;
            if($type == "software"){
                $stmt   = $this->db->select("t1.id,t2.title")->from("pages AS t1");
                $stmt->join("LEFT","pages_lang AS t2","t2.owner_id=t1.id AND (t2.lang='".$ll_lang."')");
                $stmt->where("t2.id","IS NOT NULL","","&&");
                $stmt->where("t1.type","=","software","&&");
                $stmt->where("(");
                $stmt->where("t1.category","=",$category,"||");
                $stmt->where("FIND_IN_SET(".$category.",t1.categories)");
                $stmt->where(")");
                $stmt->order_by("rank ASC");
                return $stmt->build() ? $stmt->fetch_assoc() : false;
            }else{
                $stmt   = $this->db->select("t1.id,t2.title")->from("products AS t1");
                $stmt->join("LEFT","products_lang AS t2","t2.owner_id=t1.id AND (t2.lang='".$ll_lang."')");
                $stmt->where("t2.id","IS NOT NULL","","&&");
                $stmt->where("t1.category","=",$category,"&&");
                $stmt->where("t1.type","=",$type);
                $stmt->order_by("rank ASC");
                return $stmt->build() ? $stmt->fetch_assoc() : false;
            }
        }

        public function get_currencies(){
            $case = "CASE ";
            $case .= "WHEN local = 1 THEN 0 ";
            $case .= "WHEN status = 'active' THEN 1 ";
            $case .= "WHEN status = 'inactive' THEN 2 ";
            $case .= "END AS rank";
            $stmt   = $this->db->select("*,".$case)->from("currencies");
            $stmt->where('status','=',"active","||");
            $stmt->where('status','=',"inactive");
            $stmt->order_by("rank ASC,id DESC");
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function get_currency($id=0){
            $stmt   = $this->db->select()->from("currencies");
            $stmt->where('id','=',$id);
            return $stmt->build() ? $stmt->getAssoc() : false;
        }

        public function set_currency($id=0,$data=[]){
            $stmt = $this->db->update("currencies",$data);
            if($id) $stmt->where("id","=",$id);
            return $stmt->save();
        }

    }