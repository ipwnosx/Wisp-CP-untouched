<?php
    defined('CORE_FOLDER') OR exit('You can not get in here!');
    class Model extends Models
    {
        function __construct()
        {
            parent::__construct();
        }

        public function get_shared_servers(){
            $stmt   = $this->db->select()->from("servers");
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
                $stmt->order_by("t1.rank ASC");
                return $stmt->build() ? $stmt->fetch_assoc() : false;
            }else{
                $stmt   = $this->db->select("t1.id,t2.title")->from("products AS t1");
                $stmt->join("LEFT","products_lang AS t2","t2.owner_id=t1.id AND (t2.lang='".$ll_lang."')");
                $stmt->where("t2.id","IS NOT NULL","","&&");
                $stmt->where("t1.category","=",$category,"&&");
                $stmt->where("t1.type","=",$type);
                $stmt->order_by("t1.rank ASC");
                return $stmt->build() ? $stmt->fetch_assoc() : false;
            }
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

        public function get_report($id=0,$pid=0){
            $sth = $this->db->select("data")->from("sms_logs");
            $sth->where("owner_id","=",$pid,"&&");
            $sth->where("id","=",$id,"&&");
            $sth->where("reason","=","send-sms","&&");
            $sth->where("owner","=","users_products");
            return $sth->build() ? $sth->getAssoc() : false;
        }

        public function get_sms_reports($id=0,$searches='',$orders=[],$start=0,$end=1){
            $stmt = $this->db->select()->from("sms_logs");
            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];

                    $stmt->where("(");

                    $stmt->where("content","LIKE","%".$word."%","||");
                    $stmt->where("numbers","LIKE","%".$word."%");

                    $stmt->where(")","","","&&");
                }
            }
            $stmt->where("owner_id","=",$id,"&&");
            $stmt->where("reason","=","send-sms","&&");
            $stmt->where("owner","=","users_products");
            $stmt->order_by("id DESC");
            $stmt->limit($start,$end);
            $data   = $stmt->build() ? $stmt->fetch_assoc() : false;

            if($data){
                $keys = array_keys($data);
                $size = sizeof($keys)-1;
                for($i=0;$i<=$size;$i++){
                    $var = $data[$keys[$i]];
                    $data[$keys[$i]]["ctime"] = DateManager::format(Config::get("options/date-format")." - H:i",$var["ctime"]);
                    $data[$keys[$i]]["data"]  = Utility::jdecode($var["data"],true);
                }
            }
            return $data;
        }

        public function get_sms_reports_total($id=0,$searches=''){
            $stmt = $this->db->select("id")->from("sms_logs");
            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];

                    $stmt->where("(");

                    $stmt->where("content","LIKE","%".$word."%","||");
                    $stmt->where("numbers","LIKE","%".$word."%");

                    $stmt->where(")","","","&&");
                }
            }
            $stmt->where("owner_id","=",$id,"&&");
            $stmt->where("reason","=","send-sms","&&");
            $stmt->where("owner","=","users_products");
            $stmt->order_by("id DESC");
            return $stmt->build() ? $stmt->rowCounter() : 0;
        }

        public function set_origin($id=0,$data=[]){
            return $this->db->update("users_sms_origins",$data)->where("id","=",$id)->save();
        }

        public function delete_origin($id=0){
            $get = $this->get_origin($id);
            if(!$get) return false;
            if($get["attachments"]){
                $attachments    = Utility::jdecode($get["attachments"],true);
                foreach($attachments AS $attachment){
                    FileManager::file_delete(RESOURCE_DIR."uploads".DS."attachments".DS.$attachment["file_path"]);
                }
            }
            return $this->db->delete("users_sms_origins")->where("id","=",$id)->run();
        }

        public function get_origin($id=0){
            return $this->db->select()->from("users_sms_origins")->where("id","=",$id)->build() ? $this->db->getAssoc() : false;
        }

        public function get_origins($pid=0){
            $case = "CASE ";
            $case .= "WHEN status = 'waiting' THEN 1 ";
            $case .= "WHEN status = 'active' THEN 2 ";
            $case .= "ELSE 3 ";
            $case .= "END AS rank";
            $sth = $this->db->select("*,".$case)->from("users_sms_origins");
            $sth->where("pid","=",$pid);
            $sth->order_by("rank ASC,id DESC");
            return $sth->build() ? $sth->fetch_assoc() : false;
        }

        public function get_products_with_category($type='',$category=0){
            $ll_lang    = Config::get("general/local");
            $select     = "t1.id,t2.title,t1.module,t1.module_data";
            $stmt   = $this->db->select($select);
            if($type == "software"){
                $stmt->from("pages AS t1");
                $stmt->join("LEFT","pages_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$ll_lang."'");
            }else{
                $stmt->from("products AS t1");
                $stmt->join("LEFT","products_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$ll_lang."'");
            }
            $stmt->where("t2.id","IS NOT NULL","","&&");
            $stmt->where("t1.type","=",$type,"&&");
            $stmt->where("t1.category","=",$category);
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function get_addon($id=0){
            $stmt   = $this->db->select()->from("users_products_addons")->where("id","=",$id);
            return $stmt->build() ? $stmt->getAssoc() : false;
        }

        public function addons($id=0){
            $case = "CASE ";
            $case .= "WHEN status = 'inprocess' THEN 0 ";
            $case .= "WHEN status = 'waiting' THEN 1 ";
            $case .= "WHEN status = 'suspended' THEN 2 ";
            $case .= "WHEN status = 'active' THEN 3 ";
            $case .= "WHEN status = 'cancelled' THEN 4 ";
            $case .= "ELSE 5 ";
            $case .= "END AS rank";
            $stmt   = $this->db->select("*,".$case)->from("users_products_addons")->where("owner_id","=",$id);
            $stmt->order_by("rank ASC,id DESC");
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function delete_addon($id=0){
            return $this->db->delete("users_products_addons")->where("id","=",$id)->run();
        }

        public function set_addon($id=0,$data=[]){
            return $this->db->update("users_products_addons",$data)->where("id","=",$id)->save();
        }

        public function insert_addon($data=[]){
            return $this->db->insert("users_products_addons",$data) ? $this->db->lastID() : false;
        }

        public function get_requirement($id=0){
            $stmt   = $this->db->select()->from("users_products_requirements")->where("id","=",$id);
            return $stmt->build() ? $stmt->getAssoc() : false;
        }

        public function requirements($id=0){
            $stmt   = $this->db->select()->from("users_products_requirements")->where("owner_id","=",$id);
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function delete_requirement($id=0){
            return $this->db->delete("users_products_requirements")->where("id","=",$id)->run();
        }

        public function set_requirement($id=0,$data=[]){
            return $this->db->update("users_products_requirements",$data)->where("id","=",$id)->save();
        }

        public function insert_requirement($data=[]){
            return $this->db->insert("users_products_requirements",$data) ? $this->db->lastID() : false;
        }
        
        public function set_order($id=0,$data=[]){
            return $this->db->update("users_products",$data)->where("id","=",$id)->save();
        }

        public function set_invoice($id=0,$data=[]){
            return $this->db->update("invoices",$data)->where("id","=",$id)->save();
        }

        public function get_invoice($id=0){
            $stmt = $this->db->select("id,datepaid,pmethod")->from("invoices");
            $stmt->where("id","=",$id);
            return $stmt->build() ? $stmt->getAssoc() : false;
        }

        public function get_category($id=0){
            $ll_lang = Config::get("general/local");
            $stmt    = $this->db->select("t1.id,t2.title")->from("categories AS t1");
            $stmt->join("LEFT","categories_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$ll_lang."'");
            $stmt->where("t2.id","IS NOT NULL","","&&");
            $stmt->where("t1.id","=",$id);
            return $stmt->build() ? $stmt->getAssoc() : false;
        }

        public function get_select_categories($type='',$parent=0,$line='',$kind_id=0){
            $ll_lang    = Config::get("general/local");
            //$sd_lang    = Bootstrap::$lang->clang;

            $stmt = $this->db->select("c.id,c.parent,c.options,cl.title,cl.options AS optionsl")->from("categories AS c");
            $stmt->join("LEFT","categories_lang AS cl","cl.owner_id=c.id AND (cl.lang='".$ll_lang."')");
            $stmt->where("cl.id","IS NOT NULL","","&&");
            $stmt->where("c.parent","=",$parent,"&&");
            if($kind_id) $stmt->where("c.kind_id","=",$kind_id,"&&");
            if($type == "software"){
                $stmt->where("c.type","=",$type);
            }elseif($type == "addon"){
                $stmt->where("c.type","=",$type);
            }elseif($type == "requirement"){
                $stmt->where("c.type","=",$type);
            }else{
                $stmt->where("c.kind","=",$type,"&&");
                $stmt->where("c.type","=","products");
            }
            $stmt->order_by("c.rank ASC");
            $result     = $stmt->build() ? $stmt->fetch_assoc() : [];
            $new_result = [];
            if($result){
                foreach($result AS $res){
                    $new    = $res;
                    $new["title"] = $line." ".$res["title"];
                    $new_result[] = $new;
                    $sub_result = $this->get_select_categories($type,$res["id"],$line."-",$kind_id);
                    if($sub_result){
                        $new_result = array_merge($new_result,$sub_result);
                    }
                }
            }
            return $new_result;
        }

        public function select_users($search=''){
            $stmt = $this->db->select("t1.id,concat_ws(' - ',t1.full_name,t1.company_name) AS text")->from("users AS t1");
            if($search){

                $phone      = Filter::numbers($search);

                $stmt->where("(");

                $stmt->where("t1.full_name","LIKE","%".$search."%","||");
                $stmt->where("t1.email","=",$search,"||");

                if($phone && strlen($phone)>5) $stmt->where("t1.phone","LIKE","%".$phone."%","||");

                $stmt->where("t1.company_name","LIKE","%".$search."%","");

                $stmt->where(")","","","&&");
            }
            $stmt->where("t1.type","=","member");

            $stmt->order_by("id DESC");
            $stmt->limit(0,10);
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function select_domain_products($search=''){
            $stmt = $this->db->select("t1.id,t1.name AS text")->from("tldlist AS t1");
            if($search){
                $stmt->where("t1.name","LIKE","%".$search."%");
            }
            $stmt->order_by("t1.rank ASC");
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }
        public function select_software_products($search='',$category=0){
            $ll_lang    = Config::get("general/local");
            $stmt = $this->db->select("t1.id,t2.title AS text")->from("pages AS t1");
            $stmt->join("LEFT","pages_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$ll_lang."'");
            $stmt->where("t2.id","IS NOT NULL","","&&");
            if($search){
                $stmt->where("t2.title","LIKE","%".$search."%","&&");
            }
            $stmt->where("t1.category","=",$category,"&&");
            $stmt->where("t1.type","=","software");

            $stmt->order_by("t1.rank ASC");
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }
        public function select_products($search='',$type='',$type_id=0,$category=0){
            $ll_lang    = Config::get("general/local");
            $stmt = $this->db->select("t1.id,t2.title AS text")->from("products AS t1");
            $stmt->join("LEFT","products_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$ll_lang."'");
            $stmt->where("t2.id","IS NOT NULL","","&&");
            if($search){
                $stmt->where("t2.title","LIKE","%".$search."%","&&");
            }
            $stmt->where("t1.category","=",$category,"&&");
            $stmt->where("t1.type","=",$type,"&&");
            $stmt->where("t1.type_id","=",$type_id);

            $stmt->order_by("t1.rank ASC");
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function select_software_category_products($search='',$parent=0,$line=''){
            $ll_lang    = Config::get("general/local");
            //$sd_lang    = Bootstrap::$lang->clang;

            $stmt = $this->db->select("c.id,c.parent,cl.title")->from("categories AS c");
            $stmt->join("LEFT","categories_lang AS cl","cl.owner_id=c.id AND (cl.lang='".$ll_lang."')");
            $stmt->where("cl.id","IS NOT NULL","","&&");
            $stmt->where("c.parent","=",$parent,"&&");
            $stmt->where("c.type","=","software");
            $stmt->order_by("c.rank ASC");
            $result     = $stmt->build() ? $stmt->fetch_assoc() : [];
            $new_result = [];
            if($result){
                foreach($result AS $res){
                    $new    = $res;
                    $new["title"] = $line.$res["title"];
                    $new["products"] = $this->select_software_products($search,$res["id"]);
                    $new_result[] = $new;
                    $sub_result = $this->select_software_category_products($search,$res["id"],$line.$res["title"]." / ");
                    if($sub_result) $new_result = array_merge($new_result,$sub_result);
                }
            }
            return $new_result;
        }
        public function select_category_products($search='',$kind='',$kind_id=0,$parent=0,$line=''){
            $ll_lang    = Config::get("general/local");
            //$sd_lang    = Bootstrap::$lang->clang;

            $stmt = $this->db->select("c.id,c.parent,cl.title")->from("categories AS c");
            $stmt->join("LEFT","categories_lang AS cl","cl.owner_id=c.id AND (cl.lang='".$ll_lang."')");
            $stmt->where("cl.id","IS NOT NULL","","&&");
            if(($kind == "special" && $parent != 0) || $kind != "special")
                $stmt->where("c.parent","=",$parent,"&&");
            $stmt->where("c.type","=","products","&&");
            $stmt->where("c.kind","=",$kind,"&&");
            $stmt->where("c.kind_id","=",$kind_id);
            $stmt->order_by("c.rank ASC");
            $result     = $stmt->build() ? $stmt->fetch_assoc() : [];
            $new_result = [];
            if($result){
                foreach($result AS $res){
                    $new    = $res;
                    $new["title"] = $line.$res["title"];
                    $new["products"] = $this->select_products($search,$kind,$kind_id,$res["id"]);
                    $new_result[] = $new;
                    $sub_result = $this->select_category_products($search,$kind,$kind_id,$res["id"],$line.$res["title"]." / ");
                    if($sub_result) $new_result = array_merge($new_result,$sub_result);
                }
            }
            return $new_result;
        }

        public function get_order($id=0,$select=''){
            $stmt   = $this->db->select($select)->from("users_products")->where("id","=",$id);
            return $stmt->build() ? $stmt->getAssoc() : false;
        }

        public function get_updowngrade($id=0,$select=''){
            $stmt   = $this->db->select($select)->from("users_products_updowngrades")->where("id","=",$id);
            return $stmt->build() ? $stmt->getAssoc() : false;
        }

        public function delete_updowngrade($id=0){
            return $this->db->delete("users_products_updowngrades")->where("id","=",$id)->run();
        }

        public function set_updowngrade($id=0,$data=[]){
            return $this->db->update("users_products_updowngrades",$data)->where("id","=",$id)->save();
        }

        public function get_orders($status='',$group='',$searches=[],$orders=[],$start=0,$end=1){

            $l_type     = 'all';
            if(isset($searches['l_type'])) $l_type = $searches['l_type'];

            $case = "CASE ";
            $case .= "WHEN t1.status = 'waiting' THEN 0 ";
            $case .= "WHEN t1.status_msg != '' THEN 0 ";
            $case .= "WHEN t1.status = 'inprocess' THEN 1 ";
            $case .= "WHEN t1.status = 'active' THEN 2 ";
            $case .= "WHEN t1.status = 'suspended' THEN 3 ";
            $case .= "WHEN t1.status = 'cancelled' THEN 4 ";
            $case .= "ELSE 5 ";
            $case .= "END AS rank";
            $select =  [
                't1.id',
                't1.invoice_id',
                't1.type',
                't1.product_id',
                't1.name',
                't1.period',
                't1.period_time',
                't1.amount',
                't1.amount_cid',
                't1.status',
                't1.status_msg',
                't1.cdate',
                't1.renewaldate',
                't1.duedate',
                't1.module',
                't1.options',
                '(SELECT full_name FROM '.$this->pfx.'users WHERE id=t1.owner_id) AS user_name',
                '(SELECT company_name FROM '.$this->pfx.'users WHERE id=t1.owner_id) AS user_company_name',
                't1.owner_id AS user_id',
                $case,
            ];

            if($l_type == 'notifications')
                $select[] = "COUNT(evt.id) AS isEvent";
            else
                $select[] = "'0' AS isEvent";

            if($l_type == 'notifications'){
                $stmt   = $this->db->select(implode(",",$select))->from("events AS evt");
                $stmt->join("INNER","users_products AS t1","evt.owner_id=t1.id");

                $stmt->where("evt.name","!=","cancelled-product-request","&&");
                $stmt->where("evt.type","=","operation","&&");
                $stmt->where("evt.status","=","pending","&&");
                $stmt->where("evt.owner","=","order","&&");
                
                $stmt->where("(");
                $stmt->where("t1.id IS NOT NULL","","","||");
                $stmt->where("t1.status_msg","!=","","");
                $stmt->where(")","","","&&");
            }
            else{
                $stmt   = $this->db->select(implode(",",$select))->from("users_products AS t1");
            }

            if($group){
                if(substr($group,0,8) == "special-")
                    $stmt->where("t1.type","=","special","&&")->where("t1.type_id","=",substr($group,8),"&&");
                else
                    $stmt->where("t1.type","=",$group,"&&");
            }

            if($status == "inprocess"){
                $stmt->where("(");
                $stmt->where("t1.status","=","inprocess","||");
                $stmt->where("t1.status","=","waiting");
                $stmt->where(")","","","&&");
            }
            elseif($status == "overdue"){
                $stmt->where("t1.period","!=","none","&&");
                $stmt->where("t1.duedate","<",DateManager::Now(),"&&");
            }
            elseif($status) $stmt->where("t1.status","=",$status,"&&");

            if($searches){
                if(isset($searches["user_id"]) && $searches["user_id"]) $stmt->where("t1.owner_id","=",$searches["user_id"],"&&");
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $order_id   = (int) ltrim($word,"#");

                    $stmt->where("(");

                    if($order_id) $stmt->where("t1.id","=",$order_id,"||");
                    $stmt->where("t1.name","LIKE","%".$word."%","||");
                    $stmt->where("t1.options","LIKE","%".$word."%","||");
                    $stmt->where("(SELECT CONCAT_WS(full_name,' ',email,' ','company_name',' ',phone) FROM users WHERE id=t1.owner_id)","LIKE","%".$word."%","");

                    $stmt->where(")","","","&&");
                }
            }
            $stmt->where("t1.status","!=","none");
            $stmt->group_by("t1.id");

            if($orders) $stmt->order_by(implode(",",$orders));
            else $stmt->order_by("rank ASC,t1.renewaldate DESC");

            $stmt->limit($start,$end);

            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function get_orders_total($status='',$group='',$searches=[]){
            $l_type     = 'all';
            if(isset($searches['l_type'])) $l_type = $searches['l_type'];

            $select =  ["t1.id"];
            if($l_type == 'notifications')
            {
                $stmt   = $this->db->select(implode(",",$select))->from("events AS evt");
                $stmt->join("INNER","users_products AS t1","evt.owner_id=t1.id");

                $stmt->where("evt.name","!=","cancelled-product-request","&&");
                $stmt->where("evt.type","=","operation","&&");
                $stmt->where("evt.status","=","pending","&&");
                $stmt->where("evt.owner","=","order","&&");
                
                $stmt->where("(");
                $stmt->where("t1.id IS NOT NULL","","","||");
                $stmt->where("t1.status_msg","!=","","");
                $stmt->where(")","","","&&");
            }
            else
            {
                $stmt   = $this->db->select(implode(",",$select))->from("users_products AS t1");
            }

            if($l_type == 'notifications'){
                $stmt->join("LEFT","events AS t2","t2.type='operation' AND t2.status='pending' AND t2.owner='order' AND t2.owner_id=t1.id AND t2.name !='cancelled-product-request'");
                $stmt->where("(");
                $stmt->where("t1.status_msg","!=","","||");
                $stmt->where("t2.id","IS NOT NULL");
                $stmt->where(")","","","&&");
            }

            if($group){
                if(substr($group,0,8) == "special-")
                    $stmt->where("t1.type","=","special","&&")->where("t1.type_id","=",substr($group,8),"&&");
                else
                    $stmt->where("t1.type","=",$group,"&&");
            }

            if($status == "inprocess"){
                $stmt->where("(");
                $stmt->where("t1.status","=","inprocess","||");
                $stmt->where("t1.status","=","waiting");
                $stmt->where(")","","","&&");
            }
            elseif($status == "overdue"){
                $stmt->where("t1.period","!=","none","&&");
                $stmt->where("t1.duedate","<",DateManager::Now(),"&&");
            }
            elseif($status) $stmt->where("t1.status","=",$status,"&&");

            if($searches){
                if(isset($searches["user_id"]) && $searches["user_id"]) $stmt->where("t1.owner_id","=",$searches["user_id"],"&&");
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $order_id   = (int) ltrim($word,"#");

                    $stmt->where("(");

                    if($order_id) $stmt->where("t1.id","=",$order_id,"||");
                    $stmt->where("t1.name","LIKE","%".$word."%","||");
                    $stmt->where("t1.options","LIKE","%".$word."%","||");
                    $stmt->where("(SELECT CONCAT_WS(full_name,' ',email,' ','company_name',' ',phone) FROM users WHERE id=t1.owner_id)","LIKE","%".$word."%","");

                    $stmt->where(")","","","&&");
                }
            }

            $stmt->where("t1.status","!=","none");
            $stmt->group_by("t1.id");
            return $stmt->build() ? $stmt->rowCounter() : 0;
        }

        public function get_updowngrades($searches='',$orders=[],$start=0,$end=1){
            $case = "CASE ";
            $case .= "WHEN t1.status = 'inprocess' THEN 0 ";
            $case .= "WHEN t1.status = 'waiting' THEN 1 ";
            $case .= "WHEN t1.status = 'completed' THEN 2 ";
            $case .= "ELSE 3 ";
            $case .= "END AS rank";
            $select =  implode(",",[
                't1.*',
                't2.full_name AS user_name',
                '(SELECT content FROM '.$this->pfx.'users_informations WHERE name="company_name" AND owner_id=t2.id) AS user_company_name',
                $case,
            ]);
            $stmt   = $this->db->select($select)->from("users_products_updowngrades AS t1");
            $stmt->join("LEFT","users AS t2","t1.user_id=t2.id");

            if($searches && isset($searches["word"]))
                $stmt->join("RIGHT","users_informations AS t3","t3.owner_id=t2.id AND t2.id IS NOT NULL");

            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $invoice_id = (int) ltrim($word,"#");
                    $phone      = Filter::numbers($word);

                    $stmt->where("(");
                    if($invoice_id) $stmt->where("t1.invoice_id","=",$invoice_id,"||");
                    $stmt->where("t1.options","LIKE","%".$word."%","||");

                    $stmt->where("(");
                    $stmt->where("t2.full_name","LIKE","%".$word."%","||");
                    $stmt->where("t2.email","LIKE","%".$word."%");
                    $stmt->where(")","","","||");

                    if($phone && strlen($phone)>1){
                        $stmt->where("(");
                        $stmt->where("t3.name","=","phone","&&");
                        $stmt->where("t3.content","LIKE","%".$phone."%");
                        $stmt->where(")","","","||");
                    }

                    $stmt->where("(");
                    $stmt->where("t3.name","=","company_name","&&");
                    $stmt->where("t3.content","LIKE","%".$word."%");
                    $stmt->where(")");

                    $stmt->where(")","","","&&");
                }
            }
            $stmt->where("t2.id","IS NOT NULL");
            $stmt->order_by("rank ASC,t1.id DESC");
            $stmt->limit($start,$end);;
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function get_updowngrades_total($searches=[]){
            $select =  "t1.id";
            $stmt   = $this->db->select($select)->from("users_products_updowngrades AS t1");
            $stmt->join("LEFT","users AS t2","t1.user_id=t2.id AND t1.id IS NOT NULL");

            if($searches && isset($searches["word"]))
                $stmt->join("RIGHT","users_informations AS t3","t3.owner_id=t2.id AND t2.id IS NOT NULL");

            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $invoice_id = (int) ltrim($word,"#");
                    $phone      = Filter::numbers($word);

                    $stmt->where("(");
                    if($invoice_id) $stmt->where("t1.invoice_id","=",$invoice_id,"||");
                    $stmt->where("t1.options","LIKE","%".$word."%","||");

                    $stmt->where("t2.full_name","LIKE","%".$word."%","||");
                    $stmt->where("t2.email","LIKE","%".$word."%","||");

                    if($phone && strlen($phone)>1) $stmt->where("t2.phone","LIKE","%".$phone."%","||");

                    $stmt->where("t2.company_name","LIKE","%".$word."%","");

                    $stmt->where(")","","","&&");
                }
            }
            $stmt->where("t2.id","IS NOT NULL");
            return $stmt->build() ? $stmt->rowCounter() : 0;
        }

        public function get_events($params=[],$searches='',$orders=[],$start=0,$end=1){
            $case = "CASE ";
            $case .= "WHEN t1.status = 'pending' THEN 0 ";
            $case .= "WHEN t1.status = 'approved' THEN 1 ";
            $case .= "ELSE 2 ";
            $case .= "END AS rank";
            $select =  implode(",",[
                't1.*',
                't2.full_name AS user_name',
                't2.company_name AS user_company_name',
                $case,
            ]);
            $stmt   = $this->db->select($select)->from("events AS t1");
            $stmt->join("LEFT","users AS t2","t1.user_id=t2.id");

            if(isset($params["type"])) $stmt->where("t1.type","=",$params["type"],"&&");
            if(isset($params["owner"])) $stmt->where("t1.owner","=",$params["owner"],"&&");
            if(isset($params["owner_id"])) $stmt->where("t1.owner_id","=",$params["owner_id"],"&&");
            if(isset($params["name"])) $stmt->where("t1.name","=",$params["name"],"&&");

            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $owner_id   = (int) ltrim($word,"#");
                    $phone      = Filter::numbers($word);

                    $stmt->where("(");
                    if($owner_id) $stmt->where("t1.owner_id","=",$owner_id,"||");
                    $stmt->where("t1.data","LIKE","%".$word."%","||");

                    $stmt->where("t2.full_name","LIKE","%".$word."%","||");
                    $stmt->where("t2.email","LIKE","%".$word."%","||");

                    if($phone && strlen($phone)>1) $stmt->where("t2.phone","LIKE","%".$phone."%","||");

                    $stmt->where("t2.company_name","LIKE","%".$word."%","");

                    $stmt->where(")","","","&&");
                }
            }
            $stmt->where("t2.id","IS NOT NULL");

            $stmt->order_by("rank ASC,t1.id DESC");
            $stmt->limit($start,$end);
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function get_events_total($params=[],$searches=[]){
            $select =  "t1.id";
            $stmt   = $this->db->select($select)->from("events AS t1");

            $stmt->join("LEFT","users AS t2","t1.user_id=t2.id");

            if(isset($params["type"])) $stmt->where("t1.type","=",$params["type"],"&&");
            if(isset($params["owner"])) $stmt->where("t1.owner","=",$params["owner"],"&&");
            if(isset($params["owner_id"])) $stmt->where("t1.owner_id","=",$params["owner_id"],"&&");
            if(isset($params["name"])) $stmt->where("t1.name","=",$params["name"],"&&");

            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $owner_id   = (int) ltrim($word,"#");
                    $phone      = Filter::numbers($word);

                    $stmt->where("(");
                    if($owner_id) $stmt->where("t1.owner_id","=",$owner_id,"||");
                    $stmt->where("t1.data","LIKE","%".$word."%","||");

                    $stmt->where("t2.full_name","LIKE","%".$word."%","||");
                    $stmt->where("t2.email","LIKE","%".$word."%","||");

                    if($phone && strlen($phone)>1) $stmt->where("t2.phone","LIKE","%".$phone."%","||");

                    $stmt->where("t2.company_name","LIKE","%".$word."%","");

                    $stmt->where(")","","","&&");
                }
            }
            $stmt->where("t2.id","IS NOT NULL");

            return $stmt->build() ? $stmt->rowCounter() : 0;
        }

        public function get_addons($searches='',$orders=[],$start=0,$end=1){
            $l_type     = 'all';
            if(isset($searches['l_type'])) $l_type = $searches['l_type'];


            $case = "CASE ";
            $case .= "WHEN t1.status = 'inprocess' THEN 1 ";
            $case .= "WHEN t1.status = 'waiting' THEN 2 ";
            $case .= "WHEN t1.status = 'active' THEN 3 ";
            $case .= "WHEN t1.status = 'suspended' THEN 4 ";
            $case .= "WHEN t1.status = 'cancelled' THEN 5 ";
            $case .= "WHEN t1.status_msg !='' THEN 0 ";
            $case .= "ELSE 5 ";
            $case .= "END AS rank";

            $select =  [
                't1.*',
                't2.full_name AS user_name',
                't2.company_name AS user_company_name',
                't2.id AS user_id',
                $case,
            ];

            if($l_type == "all"){
                $select[] = "'0' AS isEvent";
                $stmt   = $this->db->select(implode(",",$select))->from("users_products_addons AS t1");

                $stmt->join("LEFT","users_products AS ord","t1.owner_id=ord.id");
                $stmt->join("LEFT","users AS t2","ord.owner_id=t2.id");

                $stmt->where("ord.id","IS NOT NULL","","&&");
            }
            elseif($l_type == "notifications"){
                $select[] = 'COUNT(t1.id) AS isEvent';
                $stmt   = $this->db->select(implode(",",$select))->from("events AS t3");
                $stmt->join("LEFT","users_products_addons AS t1","t3.owner_id=t1.id");
                $stmt->join("LEFT","users_products AS ord","t1.owner_id=ord.id");
                $stmt->join("LEFT","users AS t2","ord.owner_id=t2.id");

                $stmt->where("t3.type","=","operation","&&");
                $stmt->where("t3.status","=","pending","&&");
                $stmt->where("t3.owner","=","order-addon","&&");

                $stmt->where("ord.id","IS NOT NULL","","&&");
            }

            if($searches){
                if(isset($searches["order_id"])) $stmt->where("t1.owner_id","=",$searches["order_id"],"&&");
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $invoice_id = (int) ltrim($word,"#");
                    $phone      = Filter::numbers($word);

                    $stmt->where("(");
                    if($invoice_id) $stmt->where("t1.invoice_id","=",$invoice_id,"||");
                    $stmt->where("t1.addon_name","LIKE","%".$word."%","||");
                    $stmt->where("t1.option_name","LIKE","%".$word."%","||");
                    $stmt->where("ord.name","LIKE","%".$word."%","||");

                    $stmt->where("t2.full_name","LIKE","%".$word."%","||");
                    $stmt->where("t2.email","LIKE","%".$word."%","||");
                    if($phone && strlen($phone)>1) $stmt->where("t2.phone","LIKE","%".$phone."%","||");
                    $stmt->where("t2.company_name","LIKE","%".$word."%","");

                    $stmt->where(")","","","&&");
                }
            }
            $stmt->where("t2.id","IS NOT NULL","","");
            $stmt->group_by("t1.id");
            $stmt->order_by("rank ASC,t1.id DESC");
            $stmt->limit($start,$end);
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function get_addons_total($searches=[]){
            $l_type     = 'all';
            if(isset($searches['l_type'])) $l_type = $searches['l_type'];
            $select =  "t1.id";

            if($l_type == "all"){
                $stmt   = $this->db->select($select)->from("users_products_addons AS t1");

                $stmt->join("LEFT","users_products AS ord","t1.owner_id=ord.id");
                $stmt->join("LEFT","users AS t2","ord.owner_id=t2.id");
                $stmt->where("ord.id","IS NOT NULL","","&&");
            }
            elseif($l_type == "notifications"){
                $stmt   = $this->db->select($select)->from("events AS t3");
                $stmt->join("LEFT","users_products_addons AS t1","t3.owner_id=t1.id");
                $stmt->join("LEFT","users_products AS ord","t1.owner_id=ord.id");
                $stmt->join("LEFT","users AS t2","ord.owner_id=t2.id");

                $stmt->where("t3.type","=","operation","&&");
                $stmt->where("t3.status","=","pending","&&");
                $stmt->where("t3.owner","=","order-addon","&&");

                $stmt->where("ord.id","IS NOT NULL","","&&");
            }
            if($searches){
                if(isset($searches["order_id"])) $stmt->where("t1.owner_id","=",$searches["order_id"],"&&");
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $invoice_id = (int) ltrim($word,"#");
                    $phone      = Filter::numbers($word);

                    $stmt->where("(");
                    if($invoice_id) $stmt->where("t1.invoice_id","=",$invoice_id,"||");
                    $stmt->where("t1.addon_name","LIKE","%".$word."%","||");
                    $stmt->where("t1.option_name","LIKE","%".$word."%","||");
                    $stmt->where("ord.name","LIKE","%".$word."%","||");

                    $stmt->where("t2.full_name","LIKE","%".$word."%","||");
                    $stmt->where("t2.email","LIKE","%".$word."%","||");
                    if($phone && strlen($phone)>1) $stmt->where("t2.phone","LIKE","%".$phone."%","||");
                    $stmt->where("t2.company_name","LIKE","%".$word."%","");

                    $stmt->where(")","","","&&");
                }
            }
            $stmt->where("t2.id","IS NOT NULL","","");
            $stmt->group_by("t1.id");

            return $stmt->build() ? $stmt->rowCounter() : 0;
        }

    }