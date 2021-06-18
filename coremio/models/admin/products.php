<?php
    defined('CORE_FOLDER') OR exit('You can not get in here!');

    class Model extends Models
    {
        function __construct()
        {
            parent::__construct();
        }

        public function get_tlds2(){
            $stmt   = $this->db->select("id,name")->from("tldlist");
            $stmt->order_by("rank ASC");
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

        public function get_product_special_groups($lang=''){
            if(!$lang) $lang = Config::get("general/local");
            $stmt = $this->db->select("c.id,cl.title")->from("categories AS c");
            $stmt->join("LEFT","categories_lang AS cl","cl.owner_id=c.id AND cl.lang='".$lang."'");
            $stmt->where("cl.id","IS NOT NULL","","&&");
            $stmt->where("c.parent","=","0","&&");
            $stmt->where("c.type","=","products","&&");
            $stmt->where("c.status","=","active","&&");
            $stmt->where("c.kind","=","special");
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

        public function get_events($params=[],$searches='',$orders=[],$start=0,$end=1){
            $case = "CASE ";
            $case .= "WHEN t1.status = 'pending' THEN 0 ";
            $case .= "WHEN t1.status = 'approved' THEN 1 ";
            $case .= "ELSE 2 ";
            $case .= "END AS rank";
            $select =  implode(",",[
                't1.*',
                $case,
            ]);
            $stmt   = $this->db->select($select)->from("events AS t1");

            if(isset($params["type"])) $stmt->where("t1.type","=",$params["type"],"&&");
            if(isset($params["owner"])) $stmt->where("t1.owner","=",$params["owner"],"&&");
            if(isset($params["owner_id"])) $stmt->where("t1.owner_id","=",$params["owner_id"],"&&");
            if(isset($params["name"])) $stmt->where("t1.name","=",$params["name"],"&&");

            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $owner_id   = (int) ltrim($word,"#");

                    $stmt->where("(");
                    if($owner_id) $stmt->where("t1.owner_id","=",$owner_id,"||");
                    $stmt->where("t1.name","LIKE","%".$word."%","||");
                    $stmt->where("t1.data","LIKE","%".$word."%");

                    $stmt->where(")","","","&&");
                }
            }
            $stmt->where("t1.data","IS NOT NULL");
            $stmt->order_by("rank ASC,t1.id DESC");
            $stmt->limit($start,$end);
            $data =  $stmt->build() ? $stmt->fetch_assoc() : false;
            if($data) foreach($data AS $row) if(!$row["unread"]) $this->db->update("events",['unread' => 1])->where("id","=",$row["id"])->save();
            return $data;
        }

        public function get_events_total($params=[],$searches=[]){
            $select =  "t1.id";
            $stmt   = $this->db->select($select)->from("events AS t1");

            $stmt   = $this->db->select($select)->from("events AS t1");

            if(isset($params["type"])) $stmt->where("t1.type","=",$params["type"],"&&");
            if(isset($params["owner"])) $stmt->where("t1.owner","=",$params["owner"],"&&");
            if(isset($params["owner_id"])) $stmt->where("t1.owner_id","=",$params["owner_id"],"&&");
            if(isset($params["name"])) $stmt->where("t1.name","=",$params["name"],"&&");

            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $owner_id   = (int) ltrim($word,"#");

                    $stmt->where("(");
                    if($owner_id) $stmt->where("t1.owner_id","=",$owner_id,"||");
                    $stmt->where("t1.name","LIKE","%".$word."%","||");
                    $stmt->where("t1.data","LIKE","%".$word."%");

                    $stmt->where(")","","","&&");
                }
            }
            $stmt->where("t1.data","IS NOT NULL");

            return $stmt->build() ? $stmt->rowCounter() : 0;
        }

        public function get_hosting_categories($server=[],$parent=0,$line=''){
            $ll_lang    = Config::get("general/local");
            //$sd_lang    = Bootstrap::$lang->clang;

            $stmt = $this->db->select("c.id,c.kind,c.parent,cl.title")->from("categories AS c");
            $stmt->join("LEFT","categories_lang AS cl","cl.owner_id=c.id AND (cl.lang='".$ll_lang."')");
            $stmt->where("cl.id","IS NOT NULL","","&&");
            $stmt->where("c.parent","=",$parent,"&&");
            $stmt->where("c.kind","=","hosting","&&");
            $stmt->where("c.type","=","products");

            $stmt->order_by("c.rank ASC");
            $result     = $stmt->build() ? $stmt->fetch_assoc() : [];
            $new_result = [];
            if($result){
                foreach($result AS $res){
                    $new    = $res;
                    $new["items"] = $this->get_category_hosting_products($res["id"],$server);
                    $new["title"] = $line." ".$res["title"];
                    $new_result[] = $new;
                    $sub_result = $this->get_hosting_categories($server,$res["id"],$line."-");
                    if($sub_result){
                        $new_result = array_merge($new_result,$sub_result);
                    }
                }
            }
            return $new_result;
        }
        public function get_server_categories($server=[],$parent=0,$line=''){
            $ll_lang    = Config::get("general/local");
            //$sd_lang    = Bootstrap::$lang->clang;

            $stmt = $this->db->select("c.id,c.kind,c.parent,cl.title")->from("categories AS c");
            $stmt->join("LEFT","categories_lang AS cl","cl.owner_id=c.id AND (cl.lang='".$ll_lang."')");
            $stmt->where("cl.id","IS NOT NULL","","&&");
            $stmt->where("c.parent","=",$parent,"&&");
            $stmt->where("c.kind","=","server","&&");
            $stmt->where("c.type","=","products");

            $stmt->order_by("c.rank ASC");
            $result     = $stmt->build() ? $stmt->fetch_assoc() : [];
            $new_result = [];
            if($result){
                foreach($result AS $res){
                    $new    = $res;
                    $new["items"] = $this->get_category_server_products($res["id"],$server);
                    $new["title"] = $line." ".$res["title"];
                    $new_result[] = $new;
                    $sub_result = $this->get_server_categories($server,$res["id"],$line."-");
                    if($sub_result){
                        $new_result = array_merge($new_result,$sub_result);
                    }
                }
            }
            return $new_result;
        }

        public function get_category_products($type='',$category=0,$get_price=false){
            $ll_lang    = Config::get("general/local");
            //$sd_lang    = Bootstrap::$lang->clang;
            if($type == "software"){
                $stmt   = $this->db->select("t1.id,t2.title")->from("pages AS t1");
                $stmt->join("LEFT","pages_lang AS t2","t2.owner_id=t1.id AND (t2.lang='".$ll_lang."')");
                $stmt->where("t2.id","IS NOT NULL","","&&");
                $stmt->where("t1.type","=","software","&&");
                $stmt->where("t1.status","=","active","&&");
                $stmt->where("(");
                $stmt->where("t1.category","=",$category,"||");
                $stmt->where("FIND_IN_SET(".$category.",t1.categories)");
                $stmt->where(")");
                $stmt->order_by("rank ASC");
                $data = $stmt->build() ? $stmt->fetch_assoc() : false;
            }else{
                $stmt   = $this->db->select("t1.id,t2.title")->from("products AS t1");
                $stmt->join("LEFT","products_lang AS t2","t2.owner_id=t1.id AND (t2.lang='".$ll_lang."')");
                $stmt->where("t2.id","IS NOT NULL","","&&");
                $stmt->where("t1.category","=",$category,"&&");
                $stmt->where("t1.status","=","active","&&");
                $stmt->where("t1.type","=",$type);
                $stmt->order_by("rank ASC");
                $data = $stmt->build() ? $stmt->fetch_assoc() : false;
            }
            if($data && $get_price){
                $keys = array_keys($data);
                $size = sizeof($keys)-1;
                for($i=0;$i<=$size;$i++){
                    $row = $data[$keys[$i]];
                    $data[$keys[$i]]["price"] = Products::get_prices("periodicals","products",$row["id"]);
                }
            }
            return $data;
        }
        public function get_category_hosting_products($category=0,$server=[]){
            $ll_lang    = Config::get("general/local");
            //$sd_lang    = Bootstrap::$lang->clang;
            $serverIDs  = $this->db->select("id")->from("servers")->where("ip","=",$server["ip"]);
            $serverIDs  = $serverIDs->build() ? $serverIDs->fetch_assoc() : false;
            if(!$serverIDs) return [];
            $serverIDs_c = sizeof($serverIDs)-1;

            $stmt   = $this->db->select("t1.id,t2.title")->from("products AS t1");
            $stmt->join("LEFT","products_lang AS t2","t2.owner_id=t1.id AND (t2.lang='".$ll_lang."')");
            $stmt->where("t2.id","IS NOT NULL","","&&");
            $stmt->where("t1.type","=","hosting","&&");
            $stmt->where("(");
            foreach($serverIDs AS $k=>$ser)
            {
                if($k == $serverIDs_c)
                {
                    $stmt->where("(");
                    $stmt->where("t1.options","LIKE",'%"server_id":"'.$ser["id"].'"%',"||");
                    $stmt->where("t1.module_data","LIKE",'%"server_id":"'.$ser["id"].'"%');
                    $stmt->where(")");
                }
                else
                {
                    $stmt->where("(");
                    $stmt->where("t1.options","LIKE",'%"server_id":"'.$ser["id"].'"%',"||");
                    $stmt->where("t1.module_data","LIKE",'%"server_id":"'.$ser["id"].'"%');
                    $stmt->where(")","","","||");
                }
            }
            $stmt->where(")","","","&&");
            $stmt->where("(");
            $stmt->where("t1.category","=",$category,"||");
            $stmt->where("FIND_IN_SET(".$category.",t1.categories)");
            $stmt->where(")");
            $stmt->order_by("rank ASC");
            $data = $stmt->build() ? $stmt->fetch_assoc() : false;

            if($data){
                $keys = array_keys($data);
                $size = sizeof($keys)-1;
                for($i=0;$i<=$size;$i++){
                    $row = $data[$keys[$i]];
                    $data[$keys[$i]]["price"] = Products::get_prices("periodicals","products",$row["id"]);
                }
            }
            return $data;
        }
        public function get_category_server_products($category=0,$server=[]){
            $ll_lang    = Config::get("general/local");
            //$sd_lang    = Bootstrap::$lang->clang;
            $serverIDs  = $this->db->select("id")->from("servers")->where("ip","=",$server["ip"]);
            $serverIDs  = $serverIDs->build() ? $serverIDs->fetch_assoc() : false;
            if(!$serverIDs) return [];
            $serverIDs_c = sizeof($serverIDs)-1;

            $stmt   = $this->db->select("t1.id,t2.title")->from("products AS t1");
            $stmt->join("LEFT","products_lang AS t2","t2.owner_id=t1.id AND (t2.lang='".$ll_lang."')");
            $stmt->where("t2.id","IS NOT NULL","","&&");
            $stmt->where("t1.type","=","server","&&");
            $stmt->where("(");
            foreach($serverIDs AS $k=>$ser)
                if($k == $serverIDs_c)
                    $stmt->where("t1.options","LIKE",'%"server_id":"'.$ser["id"].'"%',"");
                else
                    $stmt->where("t1.options","LIKE",'%"server_id":"'.$ser["id"].'"%',"||");
            $stmt->where(")","","","&&");
            $stmt->where("(");
            $stmt->where("t1.category","=",$category,"||");
            $stmt->where("FIND_IN_SET(".$category.",t1.categories)");
            $stmt->where(")");
            $stmt->order_by("rank ASC");
            $data = $stmt->build() ? $stmt->fetch_assoc() : false;

            if($data){
                $keys = array_keys($data);
                $size = sizeof($keys)-1;
                for($i=0;$i<=$size;$i++){
                    $row = $data[$keys[$i]];
                    $data[$keys[$i]]["price"] = Products::get_prices("periodicals","products",$row["id"]);
                }
            }
            return $data;
        }

        public function sync_hosting($domain='',$user='',$server=[]){
            $module = $server["type"];
            $stmt   = $this->db->select("id,owner_id AS user_id,product_id,name,options,cdate,duedate,amount,amount_cid,period,period_time")->from("users_products");
            $stmt->where("(");
            if($domain) $stmt->where("options","LIKE",'%"domain":"'.$domain.'"%',"||");
            $stmt->where("options","LIKE",'%"user":"'.$user.'"%');
            $stmt->where(")","","","&&");
            $stmt->where("options","LIKE",'%"server_id":"'.$server['id'].'"%','&&');
            $stmt->where("type","=","hosting","&&");
            $stmt->where("module","=",$module);
            return $stmt->build() ? $stmt->getAssoc() : false;
        }
        public function sync_server($server=[],$sync_terms=[]){
            $module = $server['type'];
            $stmt   = $this->db->select("id,owner_id AS user_id,product_id,name,options,cdate,duedate,amount,amount_cid,period,period_time")->from("users_products");
            if($sync_terms){
                $stmt->where("(");
                foreach($sync_terms AS $term) $stmt->where($term["column"],$term["mark"],$term["value"],$term["logical"]);
                $stmt->where(")","","","&&");
            }
            $stmt->where("type","=","server","&&");
            $stmt->where("(");
            $stmt->where("options","LIKE",'%"server_id":"'.$server['id'].'"%','||');
            $stmt->where("options","LIKE",'%"server_id":'.$server['id'].'%','');
            $stmt->where(")","","","&&");
            $stmt->where("module","=",$module);
            return $stmt->build() ? $stmt->getAssoc() : false;
        }

        public function get_intl_report($id=0){
            $sth = $this->db->select("data")->from("sms_logs")->where("id","=",$id);
            return $sth->build() ? $sth->getAssoc() : false;
        }

        public function delete_intl_sms_origin($id=0){
            $sth = $this->db->delete("users_sms_origins")->where("id","=",$id)->run();
            $preregs    = $this->db->select("id,attachments")->from("users_sms_origin_prereg");
            $preregs->where("origin_id","=",$id);
            $preregs    = $preregs->build() ? $preregs->fetch_assoc() : false;
            if($preregs){
                foreach($preregs AS $prereg){
                    if($prereg["attachments"]){
                        $attachments    = Utility::jdecode($prereg["attachments"],true);
                        foreach($attachments AS $attachment){
                            FileManager::file_delete(RESOURCE_DIR."uploads".DS."attachments".DS.$attachment["file_path"]);
                        }
                    }
                    $this->db->delete("users_sms_origin_prereg")->where("id","=",$prereg["id"])->run();
                }
            }
            return $sth;
        }

        public function set_origin($id=0,$data=[]){
            return $this->db->update("users_sms_origins",$data)->where("id","=",$id)->save();
        }

        public function set_origin_prereg($id=0,$data=[]){
            return $this->db->update("users_sms_origin_prereg",$data)->where("id","=",$id)->save();
        }

        public function get_origin_prereg($id=0){
            return $this->db->select()->from("users_sms_origin_prereg")->where("id","=",$id)->build() ? $this->db->getAssoc() : false;
        }

        public function get_origin($id=0){
            $sth = $this->db->select()->from("users_sms_origins");
            $sth->where("id","=",$id,"&&");
            $sth->where("pid","=",0);
            return $sth->build() ? $sth->getAssoc() : false;
        }

        public function delete_origin($id=0,$data=[]){
            return $this->db->delete("users_products_origins")->where("id","=",$id)->run();
        }


        public function get_origins($searches='',$orders=[],$start=0,$end=1){
            $case = "CASE ";
            $case .= "WHEN t1.status = 'waiting' THEN 0 ";
            $case .= "WHEN t1.status = 'active' THEN 1 ";
            $case .= "WHEN t1.status = 'inactive' THEN 2 ";
            $case .= "END AS rank";
            $select =  implode(",",[
                't1.*',
                't2.full_name AS user_name',
                't2.company_name AS user_company_name',
                $case,
            ]);
            $stmt   = $this->db->select($select)->from("users_sms_origins AS t1");
            $stmt->join("LEFT","users AS t2","t2.id=t1.user_id");

            $stmt->where("t2.id","IS NOT NULL","","&&");
            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $phone      = Filter::numbers($word);

                    $stmt->where("(");
                    $stmt->where("t1.name","LIKE","%".$word."%","||");
                    $stmt->where("t1.status_message","LIKE","%".$word."%","||");

                    $stmt->where("t2.full_name","LIKE","%".$word."%","||");
                    $stmt->where("t2.company_name","LIKE","%".$word."%","||");
                    if($phone && strlen($phone)>=5) $stmt->where("t2.phone","LIKE","%".$phone."%","||");
                    $stmt->where("t2.email","LIKE","%".$word."%","");
                    $stmt->where(")","","","&&");
                }
            }

            $stmt->where("t1.pid","!=","0","");
            $stmt->order_by("rank ASC,t1.id DESC");
            $stmt->limit($start,$end);
            $data = $stmt->build() ? $stmt->fetch_assoc() : false;
            if($data) foreach($data AS $row) if(!$row["unread"]) $this->set_origin($row["id"],['unread' => 1]);
            return $data;
        }

        public function get_origins_total($searches=[]){
            $select =  "t1.id";
            $stmt   = $this->db->select($select)->from("users_sms_origins AS t1");
            $stmt->join("LEFT","users AS t2","t2.id=t1.user_id");
            $stmt->where("t2.id","IS NOT NULL","","&&");

            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $phone      = Filter::numbers($word);

                    $stmt->where("(");
                    $stmt->where("t1.name","LIKE","%".$word."%","||");
                    $stmt->where("t1.status_message","LIKE","%".$word."%","||");

                    $stmt->where("t2.full_name","LIKE","%".$word."%","||");
                    $stmt->where("t2.company_name","LIKE","%".$word."%","||");
                    if($phone && strlen($phone)>=5) $stmt->where("t2.phone","LIKE","%".$phone."%","||");
                    $stmt->where("t2.email","LIKE","%".$word."%","");
                    $stmt->where(")","","","&&");
                }
            }
            $stmt->where("t1.pid","!=","0","");
            return $stmt->build() ? $stmt->rowCounter() : 0;
        }

        public function get_reports($searches='',$orders=[],$start=0,$end=1){
            $select =  implode(",",[
                't1.*',
                't2.full_name AS user_name',
                't2.company_name AS user_company_name',
            ]);
            $stmt   = $this->db->select($select)->from("sms_logs AS t1");
            $stmt->join("LEFT","users AS t2","t1.user_id=t2.id");
            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $phone      = Filter::numbers($word);

                    $stmt->where("(");
                    $stmt->where("t1.title","LIKE","%".$word."%","||");
                    $stmt->where("t1.content","LIKE","%".$word."%","||");
                    $stmt->where("t1.numbers","LIKE","%".$word."%","||");

                    $stmt->where("t2.full_name","LIKE","%".$word."%","||");
                    $stmt->where("t2.company_name","LIKE","%".$word."%","||");
                    if($phone && strlen($phone)>1) $stmt->where("t2.phone","LIKE","%".$phone."%","||");
                    $stmt->where("t2.email","LIKE","%".$word."%");

                    $stmt->where(")","","","&&");
                }
            }

            $stmt->where("t1.owner_id","!=","0","&&");
            $stmt->where("t1.reason","=","send-sms","&&");
            $stmt->where("t1.owner","=","users_products");

            $stmt->order_by("t1.id DESC");
            $stmt->limit($start,$end);
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function get_reports_total($searches=[]){
            $select =  "t1.id";
            $stmt   = $this->db->select($select)->from("sms_logs AS t1");
            $stmt->join("LEFT","users AS t2","t1.user_id=t2.id");

            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $phone      = Filter::numbers($word);

                    $stmt->where("(");
                    $stmt->where("t1.title","LIKE","%".$word."%","||");
                    $stmt->where("t1.content","LIKE","%".$word."%","||");
                    $stmt->where("t1.numbers","LIKE","%".$word."%","||");

                    $stmt->where("t2.full_name","LIKE","%".$word."%","||");
                    $stmt->where("t2.company_name","LIKE","%".$word."%","||");
                    if($phone && strlen($phone)>1) $stmt->where("t2.phone","LIKE","%".$phone."%","||");
                    $stmt->where("t2.email","LIKE","%".$word."%");

                    $stmt->where(")","","","&&");
                }
            }

            $stmt->where("t1.owner_id","!=","0","&&");
            $stmt->where("t1.reason","=","send-sms","&&");
            $stmt->where("t1.owner","=","users_products");

            return $stmt->build() ? $stmt->rowCounter() : 0;
        }

        public function get_origins_intl($searches='',$orders=[],$start=0,$end=1){
            $select =  implode(",",[
                't1.*',
                't2.full_name AS user_name',
                't2.company_name AS user_company_name',
                't1.user_id',
            ]);
            $stmt   = $this->db->select($select)->from("users_sms_origins AS t1");
            $stmt->join("LEFT","users AS t2","t1.user_id=t2.id");
            $stmt->where("t2.id","IS NOT NULL","","&&");
            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $phone      = Filter::numbers($word);

                    $stmt->where("(");

                    $stmt->where("t1.name","LIKE","%".$word."%","||");
                    $stmt->where("t2.full_name","LIKE","%".$word."%","||");
                    $stmt->where("t2.email","LIKE","%".$word."%","||");
                    if($phone && strlen($phone)>1) $stmt->where("t2.phone","LIKE","%".$phone."%","||");
                    $stmt->where("t2.company_name","LIKE","%".$word."%","");

                    $stmt->where(")","","","&&");
                }
            }
            $stmt->where("t1.pid","=","0");

            $stmt->order_by("t1.id DESC");
            $stmt->limit($start,$end);
            $data = $stmt->build() ? $stmt->fetch_assoc() : false;

            if($data){
                $keys   = array_keys($data);
                $size   = sizeof($keys)-1;
                for($i=0;$i<=$size;$i++){
                    $dat = $data[$keys[$i]];

                    if(!$dat["unread"]) $this->set_origin($dat["id"],['unread' => 1]);

                    $case = "CASE ";
                    $case .= "WHEN status = 'waiting' THEN 1 ";
                    $case .= "WHEN status = 'active' THEN 2 ";
                    $case .= "ELSE 3 ";
                    $case .= "END AS rank";
                    $preregs    = $this->db->select("*,".$case)->from("users_sms_origin_prereg");
                    $preregs->where("origin_id","=",$dat["id"]);
                    $preregs->order_by("rank ASC,id DESC");
                    $preregs    = $preregs->build() ? $preregs->fetch_assoc() : [];
                    $data[$keys[$i]]["preregs"] = $preregs;
                }
            }
            return $data;
        }

        public function get_origins_intl_total($searches=[]){
            $select =  "t1.id";
            $stmt   = $this->db->select($select)->from("users_sms_origins AS t1");

            $stmt->join("LEFT","users AS t2","t1.user_id=t2.id");
            $stmt->where("t2.id","IS NOT NULL","","&&");
            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $phone      = Filter::numbers($word);

                    $stmt->where("(");

                    $stmt->where("t1.name","LIKE","%".$word."%","||");
                    $stmt->where("t2.full_name","LIKE","%".$word."%","||");
                    $stmt->where("t2.email","LIKE","%".$word."%","||");
                    if($phone && strlen($phone)>1) $stmt->where("t2.phone","LIKE","%".$phone."%","||");
                    $stmt->where("t2.company_name","LIKE","%".$word."%","");

                    $stmt->where(")","","","&&");
                }
            }
            $stmt->where("t1.pid","=","0");

            return $stmt->build() ? $stmt->rowCounter() : 0;
        }

        public function get_reports_intl($searches='',$orders=[],$start=0,$end=1){
            $select =  implode(",",[
                't1.*',
                't2.full_name AS user_name',
                't2.company_name AS user_company_name',
            ]);
            $stmt   = $this->db->select($select)->from("sms_logs AS t1");
            $stmt->join("LEFT","users AS t2","t1.user_id=t2.id AND t1.id IS NOT NULL");

            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $phone      = Filter::numbers($word);

                    $stmt->where("(");
                    $stmt->where("t1.title","LIKE","%".$word."%","||");
                    $stmt->where("t1.content","LIKE","%".$word."%","||");
                    $stmt->where("t1.numbers","LIKE","%".$word."%","||");

                    $stmt->where("t2.full_name","LIKE","%".$word."%","||");
                    $stmt->where("t2.email","LIKE","%".$word."%","||");

                    if($phone && strlen($phone)>1)
                        $stmt->where("t2.phone","LIKE","%".$word."%","||");

                    $stmt->where("t2.company_name","LIKE","%".$word."%","");

                    $stmt->where(")","","","&&");
                }
            }

            $stmt->where("t1.owner_id","=",0,"&&");
            $stmt->where("t1.reason","=","send-sms","&&");
            $stmt->where("t1.owner","=","international_sms");

            $stmt->order_by("t1.id DESC");
            $stmt->limit($start,$end);
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function get_reports_intl_total($searches=[]){
            $select =  "t1.id";
            $stmt   = $this->db->select($select)->from("sms_logs AS t1");
            $stmt->join("LEFT","users AS t2","t1.user_id=t2.id AND t1.id IS NOT NULL");

            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $phone      = Filter::numbers($word);

                    $stmt->where("(");
                    $stmt->where("t1.title","LIKE","%".$word."%","||");
                    $stmt->where("t1.content","LIKE","%".$word."%","||");
                    $stmt->where("t1.numbers","LIKE","%".$word."%","||");

                    $stmt->where("t2.full_name","LIKE","%".$word."%","||");
                    $stmt->where("t2.email","LIKE","%".$word."%","||");

                    if($phone && strlen($phone)>1)
                        $stmt->where("t2.phone","LIKE","%".$word."%","||");

                    $stmt->where("t2.company_name","LIKE","%".$word."%","");

                    $stmt->where(")","","","&&");
                }
            }

            $stmt->where("t1.owner_id","=",0,"&&");
            $stmt->where("t1.reason","=","send-sms","&&");
            $stmt->where("t1.owner","=","international_sms");

            return $stmt->build() ? $stmt->rowCounter() : 0;
        }

        public function set_tld($id=0,$data=[]){
            return $this->db->update("tldlist",$data)->where("id","=",$id)->save();
        }

        public function insert_domain($data=[]){
            return $this->db->insert("tldlist",$data) ? $this->db->lastID() : false;
        }

        public function delete_domain($id=0){
            return $this->db->delete("tld,pcs","tldlist tld")
                ->join("INNER","prices pcs","pcs.owner='tld' AND pcs.owner_id=tld.id")
                ->where("tld.id","=",$id)
                ->run();
        }

        public function get_tlds($searches=[],$orders=[],$start=0,$end=10){
            $case = "CASE ";
            $case .= "WHEN status = 'active' THEN 0 ";
            $case .= "ELSE 1 ";
            $case .= "END AS sort_rank";
            $select = implode(",",[
                '*',
                $case,
            ]);
            $sth = $this->db->select($select)->from("tldlist");
            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $sth->where("(");
                    $sth->where("id","=",$word,"||");
                    $sth->where("module","=",$word,"||");
                    $sth->where("name","LIKE","%".$word."%");
                    $sth->where(")");
                }
            }
            $sth->order_by("sort_rank ASC,rank ASC");
            $sth->limit($start,$end);
            return $sth->build() ? $sth->fetch_assoc() : false;
        }
        public function get_tlds_total($searches=[]){
            $sth = $this->db->select("id")->from("tldlist");
            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $sth->where("(");
                    $sth->where("id","=",$word,"||");
                    $sth->where("module","=",$word,"||");
                    $sth->where("name","LIKE","%".$word."%");
                    $sth->where(")");
                }
            }
            return $sth->build() ? $sth->rowCounter() : 0;
        }

        public function page_route_check($route='',$lang=''){
            $sth = $this->db->select("t1.id")->from("pages AS t1");
            $sth->join("LEFT","pages_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $sth->where("t2.id","IS NOT NULL","","&&");
            $sth->where("t2.route","=",$route);
            return $sth->build() ? $sth->getObject()->id : false;
        }

        public function category_route_check($route='',$lang='',$type='',$kind=''){
            $sth = $this->db->select("t1.id")->from("categories AS t1");
            $sth->join("LEFT","categories_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $sth->where("t2.id","IS NOT NULL","","&&");
            $sth->where("t1.type","=",$type,"&&");
            if($kind) $sth->where("t1.kind","=",$kind,"&&");
            $sth->where("t2.route","=",$route);
            return $sth->build() ? $sth->getObject()->id : false;
        }

        public function delete_shared_server($id=0){
            return $this->db->delete("servers")->where("id","=",$id)->run();
        }

        public function get_shared_server($id=0){
            return $this->db->select()->from("servers")->where("id","=",$id)->build() ? $this->db->getAssoc() : false;
        }

        public function check_shared_server_ip($ip='',$username=''){
            return $this->db->select("id")->from("servers")->where("ip","=",$ip,"&&")->where("username","=",$username)->build();
        }

        public function insert_shared_server($data=[]){
            return $this->db->insert("servers",$data) ? $this->db->lastID() : false;
        }

        public function set_shared_server($id=0,$data=[]){
            return $this->db->update("servers",$data)->where("id","=",$id)->save();
        }

        public function get_shared_server_list_total($searches=[]){

            $sth = $this->db->select("id")->from("servers");
            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $sth->where("(");
                    $sth->where("id","=",$word,"||");
                    $sth->where("name","LIKE","%".$word."%","||");
                    $sth->where("ip","LIKE","%".$word."%","||");
                    $sth->where("type","LIKE","%".$word."%");
                    $sth->where(")","","");
                }
            }
            return $sth->build() ? $sth->rowCounter() : 0;
        }

        public function get_shared_server_list($searches='',$orders=[],$start=0,$end=1){
            $case = "CASE ";
            $case .= "WHEN status = 'active' THEN 1 ";
            $case .= "WHEN status = 'inactive' THEN 2 ";
            $case .= "ELSE 3 ";
            $case .= "END AS rank";
            $select = implode(",",[
                'id',
                'status',
                'name',
                'ip',
                'type',
                $case,
            ]);
            $sth = $this->db->select($select)->from("servers");
            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $sth->where("(");
                    $sth->where("id","=",$word,"||");
                    $sth->where("name","LIKE","%".$word."%","||");
                    $sth->where("ip","LIKE","%".$word."%","||");
                    $sth->where("type","LIKE","%".$word."%");
                    $sth->where(")","","");
                }
            }
            if($orders) $sth->order_by(implode(",",$orders).",id DESC");
            else $sth->order_by("id DESC");
            $sth->limit($start,$end);
            return $sth->build() ? $sth->fetch_assoc() : false;
        }


        public function get_product_module($id=0){
            $stmt   = $this->db->select("module,module_data")->from("products");
            $stmt->where("id","=",$id);
            return $stmt->build() ? $stmt->getAssoc() : false;
        }

        public function get_product($id=0,$type='products'){
            $ll_lang    = Config::get("general/local");
            //$sd_lang  = Bootstrap::$lang->clang;
            if($type == "products"){
                $stmt       = $this->db->select("t1.*,t2.title")->from("products AS t1");
                $stmt->join("LEFT","products_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$ll_lang."'");
                $stmt->where("t2.id","IS NOT NULL","","&&");
                $stmt->where("t1.id","=",$id);
            }elseif($type == "software"){
                $stmt       = $this->db->select("t1.*,t2.title")->from("pages AS t1");
                $stmt->join("LEFT","pages_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$ll_lang."'");
                $stmt->where("t2.id","IS NOT NULL","","&&");
                $stmt->where("t1.id","=",$id);
            }
            return $stmt->build() ? $stmt->getAssoc() : false;
        }
        public function set_page($id,$data=[]){
            return $this->db->update("pages",$data)->where("id","=",$id)->save();
        }


        public function get_product_wlang($id=0,$lang=''){
            $stmt       = $this->db->select()->from("products_lang");
            $stmt->where("lang","=",$lang,"&&");
            $stmt->where("owner_id","=",$id);
            return $stmt->build() ? $stmt->getAssoc() : false;
        }

        public function insert_product($data=[]){
            return $this->db->insert("products",$data) ? $this->db->lastID() : false;
        }

        public function set_product($id=0,$data=[]){
            return $this->db->update("products",$data)->where("id","=",$id)->save();
        }

        public function insert_product_lang($data=[]){
            return $this->db->insert("products_lang",$data) ? $this->db->lastID() : false;
        }

        public function set_product_lang($id=0,$data=[]){
            return $this->db->update("products_lang",$data)->where("id","=",$id)->save();
        }


        public function get_product_software($id=0){
            $ll_lang    = Config::get("general/local");
            //$sd_lang  = Bootstrap::$lang->clang;
            $stmt       = $this->db->select("t1.*,t2.title")->from("pages AS t1");
            $stmt->join("LEFT","pages_lang AS t2","t2.owner_id=t1.id AND (t2.lang='".$ll_lang."')");
            $stmt->where("t2.id","IS NOT NULL","","&&");
            $stmt->where("t1.id","=",$id);
            return $stmt->build() ? $stmt->getAssoc() : false;
        }

        public function get_product_software_wlang($id=0,$lang=''){
            $stmt       = $this->db->select()->from("pages_lang");
            $stmt->where("lang","=",$lang,"&&");
            $stmt->where("owner_id","=",$id);
            return $stmt->build() ? $stmt->getAssoc() : false;
        }

        public function insert_product_software($data=[]){
            return $this->db->insert("pages",$data) ? $this->db->lastID() : false;
        }

        public function set_product_software($id=0,$data=[]){
            return $this->db->update("pages",$data)->where("id","=",$id)->save();
        }

        public function insert_product_software_lang($data=[]){
            return $this->db->insert("pages_lang",$data) ? $this->db->lastID() : false;
        }

        public function set_product_software_lang($id=0,$data=[]){
            return $this->db->update("pages_lang",$data)->where("id","=",$id)->save();
        }

        public function insert_price($data=[]){
            return $this->db->insert("prices",$data) ? $this->db->lastID() : false;
        }

        public function delete_price($id=0){
            return $this->db->delete("prices")->where("id","=",$id)->run();
        }

        public function get_price($type,$owner,$owner_id,$lang='none'){
            $this->db_start();
            $sth = $this->db->select("id,period,time,amount,discount,cid")->from("prices");
            $sth->where("type","=",$type,"&&");
            $sth->where("owner","=",$owner,"&&");
            $sth->where("owner_id","=",$owner_id);
            //$sth->where("lang","=",$lang);
            if(!$sth->build())  return [];
            return $sth->getAssoc();
        }

        public function get_prices($type='',$owner='',$owner_id=0){
            $stmt   = $this->db->select()->from("prices");
            $stmt->where("owner","=",$owner,"&&");
            $stmt->where("owner_id","=",$owner_id,"&&");
            $stmt->where("type","=",$type);
            $stmt->order_by("rank ASC");
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function set_price($id=0,$data=[]){
            return $this->db->update("prices",$data)->where("id","=",$id)->save();
        }

        public function get_addons_with_category($mcategory='',$category=0){
            $ll_lang    = Config::get("general/local");
            $sd_lang    = Bootstrap::$lang->clang;

            $stmt   = $this->db->select("t1.id,t1.requirements,t2.name,t2.description,t2.type,t2.properties,t2.options")->from("products_addons AS t1");
            $stmt->join("LEFT","products_addons_lang AS t2","t2.owner_id=t1.id AND (t2.lang='".$ll_lang."')");
            if($mcategory) $stmt->where("t1.mcategory","=",$mcategory,"&&");
            if($category) $stmt->where("t1.category","=",$category,"&&");
            $stmt->where("t2.id","IS NOT NULL","","");
            $stmt->order_by("t1.rank ASC");
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function get_addon_categories_total($searches=[]){
            $ll_lang    = Config::get("general/local");
            $sd_lang    = Bootstrap::$lang->clang;

            $sth = $this->db->select("t1.id")->from("categories AS t1");
            $sth->join("LEFT","categories_lang AS t2","t2.owner_id=t1.id AND (t2.lang='".$ll_lang."')");
            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $sth->where("(");
                    $sth->where("t1.id","=",$word,"||");
                    $sth->where("t2.title","LIKE","%".$word."%");
                    $sth->where(")","","","&&");
                }
            }
            $sth->where("t1.type","=","addon");
            return $sth->build() ? $sth->rowCounter() : 0;
        }

        public function get_addon_categories($searches='',$orders=[],$start=0,$end=1){
            $ll_lang    = Config::get("general/local");
            $sd_lang    = Bootstrap::$lang->clang;

            $select = implode(",",[
                't1.id',
                't2.title AS name',
            ]);
            $sth = $this->db->select($select)->from("categories AS t1");
            $sth->join("LEFT","categories_lang AS t2","t2.owner_id=t1.id AND (t2.lang='".$ll_lang."')");
            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $sth->where("(");
                    $sth->where("t1.id","=",$word,"||");
                    $sth->where("t2.title","LIKE","%".$word."%");
                    $sth->where(")","","","&&");
                }
            }
            $sth->where("t1.type","=","addon");
            if($orders) $sth->order_by(implode(",",$orders).",t1.id DESC");
            else $sth->order_by("t1.id DESC");
            $sth->limit($start,$end);
            return $sth->build() ? $sth->fetch_assoc() : false;
        }

        public function get_addon($id=0){
            $ll_lang    = Config::get("general/local");
            //$sd_lang  = Bootstrap::$lang->clang;
            $stmt       = $this->db->select("c.*,cl.name")->from("products_addons AS c");
            $stmt->join("LEFT","products_addons_lang AS cl","cl.owner_id=c.id AND (cl.lang='".$ll_lang."')");
            $stmt->where("cl.id","IS NOT NULL","","&&");
            $stmt->where("c.id","=",$id);
            return $stmt->build() ? $stmt->getAssoc() : false;
        }

        public function get_addon_wlang($id=0,$lang=''){
            $stmt       = $this->db->select()->from("products_addons_lang");
            $stmt->where("lang","=",$lang,"&&");
            $stmt->where("owner_id","=",$id);
            return $stmt->build() ? $stmt->getAssoc() : false;
        }

        public function insert_addon($data){
            return $this->db->insert("products_addons",$data) ? $this->db->lastID() : false;
        }

        public function insert_addon_lang($data){
            return $this->db->insert("products_addons_lang",$data) ? $this->db->lastID() : false;
        }

        public function set_addon($id=0,$data=[]){
            return $this->db->update("products_addons",$data)->where("id","=",$id)->save();
        }

        public function set_addon_lang($id=0,$data=[]){
            return $this->db->update("products_addons_lang",$data)->where("id","=",$id)->save();
        }

        public function delete_addon($id=0){
            $delete  = $this->db->delete("pds,pdsl","products_addons pds")
                ->join("INNER","products_addons_lang pdsl","pdsl.owner_id=pds.id")
                ->where("pds.id","=",$id)
                ->run();
            return $delete;
        }

        public function get_addons_total($searches=[],$category=0){
            $ll_lang    = Config::get("general/local");
            $sd_lang    = Bootstrap::$lang->clang;

            $sth = $this->db->select("t1.id")->from("products_addons AS t1");
            $sth->join("LEFT","products_addons_lang AS t2","t2.owner_id=t1.id AND (t2.lang='".$ll_lang."')");
            $sth->where("t2.id","IS NOT NULL","","&&");
            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $sth->where("(");
                    $sth->where("t1.id","=",$word,"||");
                    $sth->where("t2.name","LIKE","%".$word."%","||");
                    $sth->where("t2.description","LIKE","%".$word."%","||");
                    $sth->where("t2.options","LIKE","%".$word."%");
                    $sth->where(")","","","&&");
                }
            }
            $sth->where("t1.category","=",$category);
            return $sth->build() ? $sth->rowCounter() : 0;
        }

        public function get_addons($searches='',$orders=[],$start=0,$end=1,$category=0){

            $ll_lang    = Config::get("general/local");
            $sd_lang    = Bootstrap::$lang->clang;

            $case = "CASE ";
            $case .= "WHEN status = 'active' THEN 1 ";
            $case .= "WHEN status = 'inactive' THEN 2 ";
            $case .= "ELSE 3 ";
            $case .= "END AS rank";
            $select = implode(",",[
                't1.id',
                't1.status',
                't2.name',
                't2.description',
                't3.title AS category_name',
                't1.mcategory',
                $case,
            ]);
            $sth = $this->db->select($select)->from("products_addons AS t1");
            $sth->join("LEFT","products_addons_lang AS t2","t2.owner_id=t1.id AND (t2.lang='".$ll_lang."')");
            $sth->join("LEFT","categories_lang AS t3","t1.category=t3.owner_id AND (t3.lang='".$ll_lang."')");
            $sth->where("t2.id","IS NOT NULL","","&&");
            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $sth->where("(");
                    $sth->where("t1.id","=",$word,"||");
                    $sth->where("t2.name","LIKE","%".$word."%","||");
                    $sth->where("t2.description","LIKE","%".$word."%","||");
                    $sth->where("t3.title","LIKE","%".$word."%","||");
                    $sth->where("t2.options","LIKE","%".$word."%");
                    $sth->where(")","","","&&");
                }
            }
            $sth->where("t1.category","=",$category);

            if($orders) $sth->order_by(implode(",",$orders).",t1.id DESC");
            else $sth->order_by("t1.id DESC");
            $sth->limit($start,$end);
            return $sth->build() ? $sth->fetch_assoc() : false;
        }


        public function get_requirements_with_category($mcategory='',$category=0){
            $ll_lang    = Config::get("general/local");
            $sd_lang    = Bootstrap::$lang->clang;

            $stmt   = $this->db->select("t1.id,t2.name,t2.description,t2.type,t2.options")->from("products_requirements AS t1");
            $stmt->join("LEFT","products_requirements_lang AS t2","t2.owner_id=t1.id AND (t2.lang='".$ll_lang."')");
            if($mcategory) $stmt->where("t1.mcategory","=",$mcategory,"&&");
            if($category) $stmt->where("t1.category","=",$category,"&&");
            $stmt->where("t2.id","IS NOT NULL","","");
            $stmt->order_by("t1.rank ASC");
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function get_requirement_categories_total($searches=[]){
            $ll_lang    = Config::get("general/local");
            $sd_lang    = Bootstrap::$lang->clang;

            $sth = $this->db->select("t1.id")->from("categories AS t1");
            $sth->join("LEFT","categories_lang AS t2","t2.owner_id=t1.id AND (t2.lang='".$ll_lang."')");
            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $sth->where("(");
                    $sth->where("t1.id","=",$word,"||");
                    $sth->where("t2.title","LIKE","%".$word."%");
                    $sth->where(")","","","&&");
                }
            }
            $sth->where("t1.type","=","requirement");
            return $sth->build() ? $sth->rowCounter() : 0;
        }

        public function get_requirement_categories($searches='',$orders=[],$start=0,$end=1){
            $ll_lang    = Config::get("general/local");
            $sd_lang    = Bootstrap::$lang->clang;

            $select = implode(",",[
                't1.id',
                't2.title AS name',
            ]);
            $sth = $this->db->select($select)->from("categories AS t1");
            $sth->join("LEFT","categories_lang AS t2","t2.owner_id=t1.id AND (t2.lang='".$ll_lang."')");
            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $sth->where("(");
                    $sth->where("t1.id","=",$word,"||");
                    $sth->where("t2.title","LIKE","%".$word."%");
                    $sth->where(")","","","&&");
                }
            }
            $sth->where("t1.type","=","requirement");
            if($orders) $sth->order_by(implode(",",$orders).",t1.id DESC");
            else $sth->order_by("t1.id DESC");
            $sth->limit($start,$end);
            return $sth->build() ? $sth->fetch_assoc() : false;
        }

        public function get_requirement($id=0){
            $ll_lang    = Config::get("general/local");
            //$sd_lang  = Bootstrap::$lang->clang;
            $stmt       = $this->db->select("c.*,cl.name")->from("products_requirements AS c");
            $stmt->join("LEFT","products_requirements_lang AS cl","cl.owner_id=c.id AND (cl.lang='".$ll_lang."')");
            $stmt->where("cl.id","IS NOT NULL","","&&");
            $stmt->where("c.id","=",$id);
            return $stmt->build() ? $stmt->getAssoc() : false;
        }

        public function get_requirement_wlang($id=0,$lang=''){
            $stmt       = $this->db->select()->from("products_requirements_lang");
            $stmt->where("lang","=",$lang,"&&");
            $stmt->where("owner_id","=",$id);
            return $stmt->build() ? $stmt->getAssoc() : false;
        }

        public function insert_requirement($data){
            return $this->db->insert("products_requirements",$data) ? $this->db->lastID() : false;
        }

        public function insert_requirement_lang($data){
            return $this->db->insert("products_requirements_lang",$data) ? $this->db->lastID() : false;
        }

        public function set_requirement($id=0,$data=[]){
            return $this->db->update("products_requirements",$data)->where("id","=",$id)->save();
        }

        public function set_requirement_lang($id=0,$data=[]){
            return $this->db->update("products_requirements_lang",$data)->where("id","=",$id)->save();
        }

        public function delete_requirement($id=0){
            $delete  = $this->db->delete("prs,prsl","products_requirements prs")
                ->join("INNER","products_requirements_lang prsl","prsl.owner_id=prs.id")
                ->where("prs.id","=",$id)
                ->run();
            return $delete;
        }

        public function get_requirements_total($searches=[],$category=0){
            $ll_lang    = Config::get("general/local");
            $sd_lang    = Bootstrap::$lang->clang;

            $sth = $this->db->select("t1.id")->from("products_requirements AS t1");
            $sth->join("LEFT","products_requirements_lang AS t2","t2.owner_id=t1.id AND (t2.lang='".$ll_lang."')");
            $sth->where("t2.id","IS NOT NULL","","&&");
            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $sth->where("(");
                    $sth->where("t1.id","=",$word,"||");
                    $sth->where("t2.name","LIKE","%".$word."%","||");
                    $sth->where("t2.description","LIKE","%".$word."%","||");
                    $sth->where("t2.options","LIKE","%".$word."%");
                    $sth->where(")","","","&&");
                }
            }
            $sth->where("t1.category","=",$category);
            return $sth->build() ? $sth->rowCounter() : 0;
        }

        public function get_requirements($searches='',$orders=[],$start=0,$end=1,$category=0){

            $ll_lang    = Config::get("general/local");
            $sd_lang    = Bootstrap::$lang->clang;

            $case = "CASE ";
            $case .= "WHEN status = 'active' THEN 1 ";
            $case .= "WHEN status = 'inactive' THEN 2 ";
            $case .= "ELSE 3 ";
            $case .= "END AS rank";
            $select = implode(",",[
                't1.id',
                't1.status',
                't2.name',
                't2.description',
                't3.title AS category_name',
                't1.mcategory',
                $case,
            ]);
            $sth = $this->db->select($select)->from("products_requirements AS t1");
            $sth->join("LEFT","products_requirements_lang AS t2","t2.owner_id=t1.id AND (t2.lang='".$ll_lang."')");
            $sth->join("LEFT","categories_lang AS t3","t1.category=t3.owner_id AND (t3.lang='".$ll_lang."')");
            $sth->where("t2.id","IS NOT NULL","","&&");
            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $sth->where("(");
                    $sth->where("t1.id","=",$word,"||");
                    $sth->where("t2.name","LIKE","%".$word."%","||");
                    $sth->where("t2.description","LIKE","%".$word."%","||");
                    $sth->where("t3.title","LIKE","%".$word."%","||");
                    $sth->where("t2.options","LIKE","%".$word."%");
                    $sth->where(")","","","&&");
                }
            }
            $sth->where("t1.category","=",$category);
            if($orders) $sth->order_by(implode(",",$orders).",t1.id DESC");
            else $sth->order_by("t1.id DESC");
            $sth->limit($start,$end);
            return $sth->build() ? $sth->fetch_assoc() : false;
        }

        public function get_shared_servers(){
            $stmt   = $this->db->select()->from("servers");
            $stmt->order_by("id DESC");
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function delete_picture($owner='',$owner_id=0,$reason=''){
            $stmt   = $this->db->delete("pictures");
            $stmt->where("owner","=",$owner,"&&");
            $stmt->where("owner_id","=",$owner_id,"&&");
            $stmt->where("reason","=",$reason);
            return $stmt->run();
        }

        public function set_picture_data($owner='',$owner_id=0,$reason='',$name=''){
            $stmt   = $this->db->update("pictures",['name' => $name]);
            $stmt->where("owner","=",$owner,"&&");
            $stmt->where("owner_id","=",$owner_id,"&&");
            $stmt->where("reason","=",$reason);
            return $stmt->save();
        }

        public function get_picture($owner='',$owner_id=0,$reason=''){
            $stmt   = $this->db->select("name")->from("pictures");
            $stmt->where("owner","=",$owner,"&&");
            $stmt->where("owner_id","=",$owner_id,"&&");
            $stmt->where("reason","=",$reason);
            return $stmt->build() ? $stmt->getObject()->name : false;
        }

        public function get_category_wlang($id=0,$lang=''){
            $stmt       = $this->db->select()->from("categories_lang");
            $stmt->where("lang","=",$lang,"&&");
            $stmt->where("owner_id","=",$id);
            return $stmt->build() ? $stmt->getAssoc() : false;
        }

        public function get_category($id=0){
            $ll_lang    = Config::get("general/local");
            //$sd_lang  = Bootstrap::$lang->clang;
            $stmt       = $this->db->select("c.*,cl.title,cl.route,cl.options AS optionsl")->from("categories AS c");
            $stmt->join("LEFT","categories_lang AS cl","cl.owner_id=c.id AND (cl.lang='".$ll_lang."')");
            $stmt->where("cl.id","IS NOT NULL","","&&");
            $stmt->where("c.id","=",$id);
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

        public function get_products_total($type='',$searches=[],$type_id=0){
            $ll_lang    = Config::get("general/local");
            //$sd_lang    = Bootstrap::$lang->clang;

            if($type == "software"){
                $sth = $this->db->select("t1.id")->from("pages AS t1");
                $sth->join("LEFT","pages_lang AS t2","t2.owner_id=t1.id AND (t2.lang='".$ll_lang."')");
            }else{
                $sth = $this->db->select("t1.id")->from("products AS t1");
                $sth->join("LEFT","products_lang AS t2","t2.owner_id=t1.id AND (t2.lang='".$ll_lang."')");
            }
            $sth->join("LEFT","categories_lang AS t3","t3.owner_id=t1.category AND (t3.lang='".$ll_lang."')");
            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $sth->where("(");
                    $sth->where("t1.id","=",$word,"||");
                    $sth->where("t2.title","LIKE","%".$word."%","||");
                    $sth->where("t3.title","LIKE","%".$word."%");
                    $sth->where(")","","","&&");
                }
            }
            if($type_id) $sth->where("t1.type_id","=",$type_id,"&&");
            $sth->where("t1.type","=",$type);
            $sth->group_by("t1.id");
            return $sth->build() ? $sth->rowCounter() : 0;
        }

        public function get_products($type='',$searches='',$orders=[],$start=0,$end=1,$type_id=0){

            $ll_lang    = Config::get("general/local");
            $sd_lang    = Bootstrap::$lang->clang;

            $case = "CASE ";
            $case .= "WHEN t1.status = 'active' THEN 1 ";
            $case .= "WHEN t1.status = 'inactive' THEN 2 ";
            $case .= "ELSE 3 ";
            $case .= "END AS rank";
            $select = implode(",",[
                't1.id',
                't1.status',
                't2.title AS name',
                't1.category AS category_id',
                't3.title AS category',
                't3.route AS category_route',
                't4.period','t4.time','t4.amount','t4.cid',
                $case,
            ]);
            if($type == "software"){
                $sth = $this->db->select($select)->from("pages AS t1");
                $sth->join("LEFT","pages_lang AS t2","t2.owner_id=t1.id AND (t2.lang='".$ll_lang."')");
            }else{
                $sth = $this->db->select($select)->from("products AS t1");
                $sth->join("LEFT","products_lang AS t2","t2.owner_id=t1.id AND (t2.lang='".$ll_lang."')");
            }
            $sth->join("LEFT","categories_lang AS t3","t3.owner_id=t1.category AND (t3.lang='".$ll_lang."')");
            if($type == "software")
                $sth->join("LEFT","prices AS t4","t4.owner='softwares' AND t4.owner_id=t1.id AND t4.type='periodicals' AND t4.rank=0");
            elseif($type == "sms")
                $sth->join("LEFT","prices AS t4","t4.owner='products' AND t4.owner_id=t1.id AND t4.type='sale' AND t4.rank=0");
            else
                $sth->join("LEFT","prices AS t4","t4.owner='products' AND t4.owner_id=t1.id AND t4.type='periodicals' AND t4.rank=0");

            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $sth->where("(");
                    $sth->where("t1.id","=",$word,"||");
                    $sth->where("t2.title","LIKE","%".$word."%","||");
                    $sth->where("t3.title","LIKE","%".$word."%");
                    $sth->where(")","","","&&");
                }
            }
            if($type_id) $sth->where("t1.type_id","=",$type_id,"&&");
            $sth->where("t1.type","=",$type);

            $sth->group_by("t1.id");

            if($orders) $sth->order_by(implode(",",$orders).",t1.id DESC");
            else $sth->order_by("t1.id DESC");

            $sth->limit($start,$end);
            return $sth->build() ? $sth->fetch_assoc() : false;
        }

        public function get_categories_total($type='',$searches=[],$kind_id=0){
            $ll_lang    = Config::get("general/local");
            $sd_lang    = Bootstrap::$lang->clang;

            $sth = $this->db->select("t1.id")->from("categories AS t1");
            $sth->join("LEFT","categories_lang AS t2","t2.owner_id=t1.id AND (t2.lang='".$ll_lang."')");
            $sth->join("LEFT","categories_lang AS t3","t3.owner_id=t1.parent AND (t3.lang='".$ll_lang."')");
            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $sth->where("(");
                    $sth->where("t1.id","=",$word,"||");
                    $sth->where("t2.title","LIKE","%".$word."%","||");
                    $sth->where("t3.title","LIKE","%".$word."%");
                    $sth->where(")","","","&&");
                }
            }
            if($kind_id) $sth->where("t1.kind_id","=",$kind_id,"&&");
            if($type == "software"){
                $sth->where("t1.type","=",$type);
            }else{
                $sth->where("t1.type","=","products","&&");
                $sth->where("t1.kind","=",$type);
            }
            return $sth->build() ? $sth->rowCounter() : 0;
        }

        public function get_categories($type='',$searches='',$orders=[],$start=0,$end=1,$kind_id=0){

            $ll_lang    = Config::get("general/local");
            $sd_lang    = Bootstrap::$lang->clang;

            $case = "CASE ";
            $case .= "WHEN status = 'active' THEN 1 ";
            $case .= "WHEN status = 'inactive' THEN 2 ";
            $case .= "ELSE 3 ";
            $case .= "END AS rank";
            $select = implode(",",[
                't1.id',
                't1.parent',
                't1.status',
                't2.title AS name',
                't2.route',
                't3.route AS parent_route',
                't3.title AS parent_name',
                $case,
            ]);
            $sth = $this->db->select($select)->from("categories AS t1");
            $sth->join("LEFT","categories_lang AS t2","t2.owner_id=t1.id AND (t2.lang='".$ll_lang."')");
            $sth->join("LEFT","categories_lang AS t3","t3.owner_id=t1.parent AND (t3.lang='".$ll_lang."')");
            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $sth->where("(");
                    $sth->where("t1.id","=",$word,"||");
                    $sth->where("t2.title","LIKE","%".$word."%","||");
                    $sth->where("t3.title","LIKE","%".$word."%");
                    $sth->where(")","","","&&");
                }
            }
            if($kind_id) $sth->where("t1.kind_id","=",$kind_id,"&&");
            if($type == "software"){
                $sth->where("t1.type","=",$type);
            }else{
                $sth->where("t1.type","=","products","&&");
                $sth->where("t1.kind","=",$type);
            }
            if($orders) $sth->order_by(implode(",",$orders).",t1.id DESC");
            else $sth->order_by("t1.id DESC");
            $sth->limit($start,$end);
            return $sth->build() ? $sth->fetch_assoc() : false;
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

        public function delete_category($id){

            $category       = $this->get_category($id);

            $this->db->delete("cy,cyl","categories cy")
                ->join("INNER","categories_lang cyl","cyl.owner_id=cy.id")
                ->where("cy.id","=",$id)->run();

            if($category["type"] == "requirement"){
                $this->db->delete("prs,prsl","products_requirements prs")
                    ->join("INNER","products_requirements_lang prsl","prsl.owner_id=prs.id")
                    ->where("prs.category","=",$id)->run();
            }elseif($category["type"] == "addon"){
                $this->db->delete("pds,pdsl","products_addons pds")
                    ->join("INNER","products_addons_lang pdsl","pdsl.owner_id=pds.id")
                    ->where("pds.category","=",$id)->run();
            }

            $pics = $this->db->select("id,name,reason")->from("pictures");
            $pics->where("owner_id","=",$id,"&&");
            $pics->where("owner","=","category");
            if($pics->build()){
                foreach($pics->fetch_assoc() AS $row){
                    if($row["reason"] == "header-background"){
                        $folder1 = Config::get("pictures/header-background/folder");
                        $folder2 = $folder1."thumb".DS;
                        $this->db->delete("pictures")->where("id","=",$row["id"])->run();
                        FileManager::file_delete($folder1.$row["name"]);
                        FileManager::file_delete($folder2.$row["name"]);
                    }elseif($row["reason"] == "icon"){
                        $folder1 = Config::get("pictures/category-icon/folder");
                        $this->db->delete("pictures")->where("id","=",$row["id"])->run();
                        FileManager::file_delete($folder1.$row["name"]);
                    }
                }
            }
        }

        public function delete_product($type,$id,$category=0){
            if($category){
                if($type == "software")
                    $pids   = $this->db->select("GROUP_CONCAT(id) AS ids")->from("pages");
                else
                    $pids   = $this->db->select("GROUP_CONCAT(id) AS ids")->from("products");
                $pids->where("type","=",$type,"&&");
                $pids->where("category","=",$category);
                $pids   = $pids->build() ? $pids->getObject()->ids : false;
                if($pids) $pids = explode(",",$pids);
            }else
                $pids = [$id];

            if($pids){
                foreach($pids AS $pid){
                    if($type == "software"){

                        $this->db->delete("pages")->where("id","=",$pid)->run();
                        $this->db->delete("pages_lang")->where("owner_id","=",$pid)->run();
                        $this->db->delete("prices")->where("owner","=","softwares","&&")
                            ->where("owner_id","=",$pid)
                            ->run();

                        // Header Background

                        $folder1    = RESOURCE_DIR."uploads".DS."header-background".DS;
                        $folder2    = RESOURCE_DIR."uploads".DS."header-background".DS."thumb".DS;

                        $pic1       = $this->db->select("id,name")->from("pictures");
                        $pic1->where("owner","=","page_software","&&");
                        $pic1->where("owner_id","=",$pid,"&&");
                        $pic1->where("reason","=","header-background");
                        $pic1       = $pic1->build() ? $pic1->getAssoc() : false;
                        if($pic1){
                            FileManager::file_delete($folder1.$pic1["name"]);
                            FileManager::file_delete($folder2.$pic1["name"]);
                            $this->db->delete("pictures")->where("id","=",$pic1["id"])->run();
                        }

                        // Cover Image & Mockup Image
                        $folder1    = RESOURCE_DIR."uploads".DS."software".DS;
                        $folder2    = RESOURCE_DIR."uploads".DS."software".DS."thumb".DS;

                        $pic1       = $this->db->select("id,name")->from("pictures");
                        $pic1->where("owner","=","page_software","&&");
                        $pic1->where("owner_id","=",$pid,"&&");
                        $pic1->where("reason","=","cover");
                        $pic1       = $pic1->build() ? $pic1->getAssoc() : false;
                        if($pic1){
                            FileManager::file_delete($folder1.$pic1["name"]);
                            FileManager::file_delete($folder2.$pic1["name"]);
                            $this->db->delete("pictures")->where("id","=",$pic1["id"])->run();
                        }

                        $pic2       = $this->db->select("id,name")->from("pictures");
                        $pic2->where("owner","=","page_software","&&");
                        $pic2->where("owner_id","=",$pid,"&&");
                        $pic2->where("reason","=","mockup");
                        $pic2       = $pic2->build() ? $pic2->getAssoc() : false;
                        if($pic2){
                            FileManager::file_delete($folder1.$pic2["name"]);
                            FileManager::file_delete($folder2.$pic2["name"]);
                            $this->db->delete("pictures")->where("id","=",$pic2["id"])->run();
                        }

                    }
                    else{
                        $this->db->delete("products")->where("id","=",$pid)->run();
                        $this->db->delete("products_lang")->where("owner_id","=",$pid)->run();
                        $this->db->delete("prices")->where("owner","=","products","&&")
                            ->where("owner_id","=",$pid)
                            ->run();
                    }
                }
            }
        }

        public function copy_product($type,$id=0){
            $id = (int) $id;
            if(!$id) return false;

            if($type == "software"){

                // Get the columns
                $product_cols       = [];
                $product_lang_cols  = [];
                $prices_cols        = [];

                $result = $this->db->query("SHOW COLUMNS FROM ".$this->pfx."pages");
                $result = $result ? $this->db->fetch_assoc($result) : false;
                if($result) foreach($result AS $row) $product_cols[] = $row["Field"];

                $result = $this->db->query("SHOW COLUMNS FROM ".$this->pfx."pages_lang");
                $result = $result ? $this->db->fetch_assoc($result) : false;
                if($result) foreach($result AS $row) $product_lang_cols[] = $row["Field"];

                $result = $this->db->query("SHOW COLUMNS FROM ".$this->pfx."prices");
                $result = $result ? $this->db->fetch_assoc($result) : false;
                if($result) foreach($result AS $row) $prices_cols[] = $row["Field"];

                $product    = $this->db->select()->from("pages")->where("id","=",$id)->build() ? $this->db->getAssoc() : false;
                if(!$product) return false;


                $new_product_data = [];
                foreach($product_cols AS $col) if($col != "id") $new_product_data[$col] = $product[$col];

                if($new_product_data["options"]){
                    $new_product_data["options"] = Utility::jdecode($new_product_data["options"],true);
                    if($new_product_data["options"]["download_file"]) unset($new_product_data["options"]["download_file"]);
                    $new_product_data["options"] = Utility::jencode($new_product_data["options"]);
                }

                $new_product      = $this->db->insert("pages",$new_product_data);
                if(!$new_product)
                    die(Utility::jencode([
                        'status' => "error",
                        'message' => "Unable to copy product",
                    ]));

                $new_product_id = $this->db->lastID();

                $product_languages = $this->db->select()->from("pages_lang");
                $product_languages->where("owner_id","=",$product["id"]);
                $product_languages = $product_languages->build() ? $product_languages->fetch_assoc() : false;

                if($product_languages){
                    foreach($product_languages AS $product_language){
                        $new_product_lang_data = [];
                        foreach($product_lang_cols AS $col)
                            if($col != "id") $new_product_lang_data[$col] = $product_language[$col];
                        $new_product_lang_data["owner_id"] = $new_product_id;
                        $new_product_lang_data["route"] = $product_language["route"]."_".$new_product_id;
                        $this->db->insert("pages_lang",$new_product_lang_data);
                    }
                }

                $product_prices = $this->db->select()->from("prices");
                $product_prices->where("owner","=","softwares","&&");
                $product_prices->where("owner_id","=",$product["id"]);
                $product_prices->order_by("id ASC");
                $product_prices = $product_prices->build() ? $product_prices->fetch_assoc() : false;

                if($product_prices){
                    foreach($product_prices AS $product_price){
                        $new_product_price_data = [];
                        foreach($prices_cols AS $col)
                            if($col != "id") $new_product_price_data[$col] = $product_price[$col];
                        $new_product_price_data["owner_id"] = $new_product_id;
                        $this->db->insert("prices",$new_product_price_data);
                    }
                }

                return $new_product_id;
            }
            else
            {

                // Get the columns
                $product_cols       = [];
                $product_lang_cols  = [];
                $prices_cols        = [];

                $result = $this->db->query("SHOW COLUMNS FROM ".$this->pfx."products");
                $result = $result ? $this->db->fetch_assoc($result) : false;
                if($result) foreach($result AS $row) $product_cols[] = $row["Field"];

                $result = $this->db->query("SHOW COLUMNS FROM ".$this->pfx."products_lang");
                $result = $result ? $this->db->fetch_assoc($result) : false;
                if($result) foreach($result AS $row) $product_lang_cols[] = $row["Field"];

                $result = $this->db->query("SHOW COLUMNS FROM ".$this->pfx."prices");
                $result = $result ? $this->db->fetch_assoc($result) : false;
                if($result) foreach($result AS $row) $prices_cols[] = $row["Field"];

                $product    = $this->db->select()->from("products")->where("id","=",$id)->build() ? $this->db->getAssoc() : false;
                if(!$product) return false;


                $new_product_data = [];
                foreach($product_cols AS $col) if($col != "id") $new_product_data[$col] = $product[$col];

                $new_product      = $this->db->insert("products",$new_product_data);
                if(!$new_product)
                    die(Utility::jencode([
                        'status' => "error",
                        'message' => "Unable to copy product",
                    ]));

                $new_product_id = $this->db->lastID();

                $product_languages = $this->db->select()->from("products_lang");
                $product_languages->where("owner_id","=",$product["id"]);
                $product_languages = $product_languages->build() ? $product_languages->fetch_assoc() : false;

                if($product_languages){
                    foreach($product_languages AS $product_language){
                        $new_product_lang_data = [];
                        foreach($product_lang_cols AS $col)
                            if($col != "id") $new_product_lang_data[$col] = $product_language[$col];
                        $new_product_lang_data["owner_id"] = $new_product_id;
                        $this->db->insert("products_lang",$new_product_lang_data);
                    }
                }

                $product_prices = $this->db->select()->from("prices");
                $product_prices->where("owner","=","products","&&");
                $product_prices->where("owner_id","=",$product["id"]);
                $product_prices->order_by("id ASC");
                $product_prices = $product_prices->build() ? $product_prices->fetch_assoc() : false;

                if($product_prices){
                    foreach($product_prices AS $product_price){
                        $new_product_price_data = [];
                        foreach($prices_cols AS $col)
                            if($col != "id") $new_product_price_data[$col] = $product_price[$col];
                        $new_product_price_data["owner_id"] = $new_product_id;
                        $this->db->insert("prices",$new_product_price_data);
                    }
                }
                return $new_product_id;
            }
        }


        public function insert_picture($owner='',$owner_id=0,$reason='',$name=''){
            return $this->db->insert("pictures",[
                'owner_id' => $owner_id,
                'owner' => $owner,
                'reason' => $reason,
                'name' => $name,
            ]) ? $this->db->lastID() : false;
        }

        public function insert_category($data){
            return $this->db->insert("categories",$data) ? $this->db->lastID() : false;
        }

        public function insert_category_lang($data){
            return $this->db->insert("categories_lang",$data) ? $this->db->lastID() : false;
        }

        public function set_category($id=0,$data=[]){
            return $this->db->update("categories",$data)->where("id","=",$id)->save();
        }

        public function set_category_lang($id=0,$data=[]){
            return $this->db->update("categories_lang",$data)->where("id","=",$id)->save();
        }

        public function get_main_special_categories(){
            $ll_lang    = Config::get("general/local");
            $sd_lang    = Bootstrap::$lang->clang;
            $stmt   = $this->db->select("t1.id,t2.title")->from("categories AS t1");
            $stmt->join("LEFT","categories_lang AS t2","t2.owner_id=t1.id AND (t2.lang='".$ll_lang."')");
            $stmt->where("t1.parent","=",0,"&&");
            $stmt->where("t2.id","IS NOT NULL","","&&");
            $stmt->where("t1.type","=","products","&&");
            $stmt->where("t1.kind","=","special");
            $stmt->order_by("t1.id ASC");
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function upgradeable_products($group_type='',$category=0,$remove_id=0)
        {
            $lang   = Config::get("general/local");
            $sth    = $this->db->select("t1.id,t2.title")->from("products AS t1");
            $sth->join("LEFT","products_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $sth->where("t1.category","=",$category,"&&");
            if($remove_id) $sth->where("t1.id","!=",$remove_id,"&&");
            if(substr($group_type,0,7) == 'special')
            {
                $sth->where("t1.type","=","special","&&");
                $sth->where("t1.type_id","=",substr($group_type,8));
            }else
                $sth->where("t1.type","=",$group_type);

            $sth->order_by("t1.rank ASC,t1.id ASC");
            return $sth->build() ? $sth->fetch_assoc() : [];
        }

    }