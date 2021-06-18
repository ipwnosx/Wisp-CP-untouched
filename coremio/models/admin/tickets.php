<?php
    defined('CORE_FOLDER') OR exit('You can not get in here!');
    class Model extends Models
    {
        function __construct()
        {
            parent::__construct();
        }

        public function get_reply($id=0,$lang=''){
            $stmt   = $this->db->select("t1.*,t2.id AS lid,t2.name,t2.message")->from("tickets_predefined_replies AS t1");
            $stmt->join("LEFT","tickets_predefined_replies_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $stmt->where("t2.id","IS NOT NULL","","&&");
            $stmt->where("t1.id","=",$id);
            return $stmt->build() ? $stmt->getAssoc() : false;
        }

        public function get_c_field($id=0){
            $ll_lang    = Config::get("general/local");
            //$sd_lang  = Bootstrap::$lang->clang;
            $stmt       = $this->db->select("c.*,cl.name")->from("tickets_custom_fields AS c");
            $stmt->join("LEFT","tickets_custom_fields_lang AS cl","cl.owner_id=c.id AND (cl.lang='".$ll_lang."')");
            $stmt->where("cl.id","IS NOT NULL","","&&");
            $stmt->where("c.id","=",$id);
            return $stmt->build() ? $stmt->getAssoc() : false;
        }

        public function get_c_field_wlang($id=0,$lang=''){
            $stmt       = $this->db->select()->from("tickets_custom_fields_lang");
            $stmt->where("lang","=",$lang,"&&");
            $stmt->where("owner_id","=",$id);
            return $stmt->build() ? $stmt->getAssoc() : false;
        }

        public function delete_category($type='',$id=0){
            if($type == "predefined_replies" && $id){
                $this->db->delete("cy,cyl","categories cy")
                    ->join("INNER","categories_lang cyl","cyl.owner_id=cy.id")
                    ->where("cy.id","=",$id)->run();

                $this->db->delete("prers,prersl","tickets_predefined_replies prers")
                    ->join("INNER","tickets_predefined_replies_lang prersl","prersl.owner_id=prers.id")
                    ->where("prers.category","=",$id)->run();
                return true;
            }
            return false;
        }

        public function delete_predefined_reply($id=0){
            return $this->db->delete("prers,prersl","tickets_predefined_replies prers")
                ->join("INNER","tickets_predefined_replies_lang prersl","prersl.owner_id=prers.id")
                ->where("prers.id","=",$id)->run();
        }

        public function insert_category($data){
            return $this->db->insert("categories",$data) ? $this->db->lastID() : false;
        }

        public function set_category($id=0,$data){
            return $this->db->update("categories",$data)->where("id","=",$id)->save();
        }

        public function insert_category_lang($data){
            return $this->db->insert("categories_lang",$data) ? $this->db->lastID() : false;
        }

        public function set_category_lang($id=0,$data){
            return $this->db->update("categories_lang",$data)->where("id","=",$id)->save();
        }

        public function insert_predefined_reply($data){
            return $this->db->insert("tickets_predefined_replies",$data) ? $this->db->lastID() : false;
        }

        public function insert_predefined_reply_lang($data){
            return $this->db->insert("tickets_predefined_replies_lang",$data) ? $this->db->lastID() : false;
        }

        public function set_predefined_reply($id=0,$data){
            return $this->db->update("tickets_predefined_replies",$data)->where("id","=",$id)->save();
        }

        public function set_predefined_reply_lang($id=0,$data){
            return $this->db->update("tickets_predefined_replies_lang",$data)->where("id","=",$id)->save();
        }

        public function get_predefined_reply_categories(){
            $lang = Config::get("general/local");
            $data = $this->db->select("t1.id,t1.parent,t2.title,t3.title AS parent_title")->from("categories AS t1");
            $data->join("LEFT","categories_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $data->join("LEFT","categories_lang AS t3","t3.owner_id=t1.parent AND t3.lang='".$lang."'");
            $data->where("t2.title","IS NOT NULL","","&&");
            $data->where("t1.type","=","predefined_replies");
            $data->order_by("t1.id DESC");
            $data = $data->build() ? $data->fetch_assoc() : false;
            if($data){
                $keys   = array_keys($data);
                $size   = sizeof($keys)-1;
                for($i=0;$i<=$size;$i++){
                    $var = $data[$keys[$i]];
                    $data[$keys[$i]]["edit_link"] = Controllers::$init->AdminCRLink("tickets-2",[
                        "predefined-replies","edit"
                    ])."?id=".$var["id"];
                }
            }
            return $data;
        }

        public function get_requests($status='',$searches='',$orders=[],$start=0,$end=1){
            $case = "CASE ";
            $case .= "WHEN t1.status = 'waiting' THEN 1 ";
            $case .= "WHEN t1.status = 'process' THEN 2 ";
            $case .= "WHEN t1.status = 'replied' THEN 3 ";
            $case .= "WHEN t1.status = 'solved' THEN 4 ";
            $case .= "END AS rank";
            $select = implode(",",[
                't1.id',
                't1.user_id',
                't1.did',
                't1.userunread',
                't1.assigned',
                't1.assignedBy',
                't1.title',
                't1.status',
                't1.locked',
                't1.ctime',
                't1.lastreply',
                't1.service',
                't2.full_name AS user_name',
                't2.company_name AS user_company_name',
                't1.userunread',
                't1.adminunread',
                $case
            ]);
            $sth = $this->db->select($select)->from("tickets AS t1");

            $sth->join("LEFT","users AS t2","t2.id=t1.user_id");

            if($searches){
                if(isset($searches["user_id"]) && $searches["user_id"]) $sth->where("t1.user_id","=",$searches["user_id"],"&&");
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $date       = DateManager::datetime_format_ifin($word);
                    $rid        = (int) ltrim($word,"#");

                    $sth->where("(");

                    if ($rid) $sth->where("t1.id","=",$rid,"||");
                    $sth->where("t1.title","LIKE","%".$word."%","||");
                    $sth->where("t1.ctime","LIKE","%".$date."%","||");
                    $sth->where("t2.full_name","LIKE","%".$word."%","||");
                    $sth->where("t2.company_name","LIKE","%".$word."%","||");

                    $sth->where("t1.lastreply","LIKE","%".$date."%","");

                    $sth->where(")","","","&&");
                }
            }
            $sth->where("t1.status","!=","delete");

            $sth->order_by("rank ASC,t1.lastreply DESC");
            $sth->limit($start,$end);
            return $sth->build() ? $sth->fetch_assoc() : false;
        }

        public function get_requests_total($status='',$searches=[]){
            $sth = $this->db->select("t1.id")->from("tickets AS t1");
            $sth->join("LEFT","users AS t2","t2.id=t1.user_id");

            if($searches){
                if(isset($searches["user_id"]) && $searches["user_id"]) $sth->where("t1.user_id","=",$searches["user_id"],"&&");
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $date       = DateManager::datetime_format_ifin($word);
                    $rid        = (int) ltrim($word,"#");

                    $sth->where("(");

                    if ($rid) $sth->where("t1.id","=",$rid,"||");
                    $sth->where("t1.title","LIKE","%".$word."%","||");
                    $sth->where("t1.ctime","LIKE","%".$date."%","||");

                    $sth->where("t2.full_name","LIKE","%".$word."%","||");
                    $sth->where("t2.company_name","LIKE","%".$word."%","||");

                    $sth->where("t1.lastreply","LIKE","%".$date."%","");

                    $sth->where(")","","","&&");
                }
            }
            $sth->where("t1.status","!=","delete");
            return $sth->build() ? $sth->rowCounter() : 0;
        }

        public function set_ticket($id=0,$data=[]){
            return $this->db->update("tickets",$data)->where("id","=",$id)->save();
        }

        public function insert_custom_field($data=[]){
            return $this->db->insert("tickets_custom_fields",$data) ? $this->db->lastID() : false;
        }

        public function insert_custom_field_lang($data=[]){
            return $this->db->insert("tickets_custom_fields_lang",$data) ? $this->db->lastID() : false;
        }

        public function set_custom_field($id=0,$data=[]){
            return $this->db->update("tickets_custom_fields",$data)->where("id","=",$id)->save();
        }

        public function set_custom_field_lang($id=0,$data=[]){
            return $this->db->update("tickets_custom_fields_lang",$data)->where("id","=",$id)->save();
        }

        public function delete_custom_field($id=0){
            $this->db->delete("tickets_custom_fields")->where("id","=",$id)->run();
            $this->db->delete("tickets_custom_fields_lang")->where("owner_id","=",$id)->run();
            return true;
        }

    }