<?php
    defined('CORE_FOLDER') OR exit('You can not get in here!');
    class Model extends Models
    {
        function __construct()
        {
            parent::__construct();
        }

        public function get_currencies(){
            $stmt   = $this->db->select()->from("currencies");
            $stmt->where('status','=',"active","||");
            $stmt->where('status','=',"inactive");
            $stmt->order_by("local DESC");
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function set_currency($id=0,$data=[]){
            return $this->db->update("currencies",$data)->where("id","=",$id)->save();
        }


        public function set_picture_data($owner='',$reason='',$name=''){
            $stmt   = $this->db->update("pictures",['name' => $name]);
            $stmt->where("owner","=",$owner,"&&");
            $stmt->where("reason","=",$reason);
            return $stmt->save();
        }

        public function get_picture_data($owner='',$reason=''){
            $stmt   = $this->db->select()->from("pictures")->where("owner","=",$owner,"&&");
            $stmt->where("reason","=",$reason);
            $stmt->order_by("id DESC");
            return $stmt->build() ? $stmt->getAssoc() : false;
        }


        public function get_countries($lang=''){
            $stmt = $this->db->select("t1.id,t1.a2_iso,t2.name")->from("countries AS t1");
            $stmt->join("LEFT","countries_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $stmt->where("t2.id","IS NOT NULL");
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function currencies(){
            $stmt   = $this->db->select("id,code,name")->from("currencies");
            $stmt->where("status","!=","delete");
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function get_product_groups(){
            $stmt = $this->db->select("c.id,cl.title,cl.lang")->from("categories AS c");
            $stmt->join("LEFT","categories_lang AS cl","cl.owner_id=c.id");
            $stmt->where("cl.id","IS NOT NULL","","&&");
            $stmt->where("c.parent","=","0","&&");
            $stmt->where("c.type","=","products","&&");
            $stmt->where("c.kind","=","special");
            $stmt->order_by("c.id DESC");
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function get_product_group_categories($parent=0,$lang = '',$parent_name=''){

            if($parent_name == NULL && !Validation::isInt($parent)){
                $kind   = $parent;
                $parent = 0;
            }else{
                $kind = "special";
            }

            $stmt = $this->db->select("c.id,cl.title AS text,c.parent")->from("categories AS c");
            $stmt->join("LEFT","categories_lang AS cl","cl.owner_id=c.id AND cl.lang='".$lang."'");
            $stmt->where("cl.id","IS NOT NULL","","&&");
            $stmt->where("c.parent","=",$parent,"&&");
            if($parent_name == NULL) $stmt->where("c.kind","=",$kind,"&&");
            $stmt->where("c.type","=","products");
            $stmt->order_by("c.rank ASC");
            $result = $stmt->build() ? $stmt->fetch_assoc() : [];
            if($result){
                $keys   = array_keys($result);
                $size   = sizeof($keys)-1;
                for($i=0;$i<=$size;$i++){
                    $res = $result[$keys[$i]];
                    if($parent_name!=''){
                        $new_parent_name = $parent_name." / ".$res["text"];
                        $result[$keys[$i]]["text"] = $new_parent_name;
                    }else
                        $new_parent_name = $res["text"];
                    $sub_result = $this->get_product_group_categories($res["id"],$lang,$new_parent_name);
                    if($sub_result){
                        $result = array_merge($result,$sub_result);
                    }
                }
            }

            return $result;
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

        public function add_block_picture($picture,$key){
            $stmt   = $this->db->insert("pictures",[
                'owner' => "block",
                'reason' => $key,
                'name' => $picture
            ]);
            return $stmt ? $this->db->lastID() : false;
        }

        public function get_software($id=0,$lang=''){
            $stmt = $this->db->select("t1.id,t2.title")->from("pages AS t1");
            $stmt->join("LEFT","pages_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $stmt->where("t2.id","IS NOT NULL","","&&");
            $stmt->where("t1.type","=","software","&&");
            $stmt->where("t1.id","=",$id);
            return $stmt->build() ? $stmt->getObject() : false;
        }

        public function get_softwares($lang,$query=''){
            $stmt = $this->db->select("t1.id,t2.title AS text")->from("pages AS t1");
            $stmt->join("LEFT","pages_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $stmt->where("t2.id","IS NOT NULL","","&&");
            $stmt->where("t1.type","=","software","&&");
            $stmt->where("t2.title","LIKE","%".$query."%");
            $stmt->order_by("id DESC");
            $stmt->limit(30);
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function get_tlds($query=''){
            $stmt   = $this->db->select("name AS text,name AS id")->from("tldlist");
            if($query != '') $stmt->where("name","LIKE","%".$query."%");
            $stmt->order_by("id DESC");
            $stmt->limit(30);
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function check_tld($name=''){
            $stmt   = $this->db->select("id")->from("tldlist");
            $stmt->where("name","=",$name);
            return $stmt->build();
        }

        private  $category_names = [];
        public function get_product_category($id=0,$lang='',$first=true){
            if($id==0) return false;
            $stmt   = $this->db->select("t1.id,t1.kind,t1.parent,t2.title")->from("categories AS t1");
            $stmt->join("LEFT","categories_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $stmt->where("t2.id","IS NOT NULL","","&&");
            $stmt->where("t1.type","=","products","&&");
            $stmt->where("t1.id","=",$id);
            $result     = $stmt->build() ? $stmt->getObject() : false;
            if($result){
                if($first) $this->category_names = [$result->title];
                if(!$first && $result->parent) $this->category_names[] = $result->title;
                if(!$first && !$result->parent && $result->kind != "special") $this->category_names[] = $result->title;
                if($result->parent) $this->get_product_category($result->parent,$lang,false);
                if($first){
                    $result->title = implode(" / ",array_reverse($this->category_names));
                }
            }
            return $result;
        }

        public function users_custom_fields($lang=NULL){
            $stmt   = $this->db->select()->from("users_custom_fields AS t1")->where("lang","=",$lang);
            $stmt->order_by("t1.rank ASC");
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function add_user_custom_field($lang=''){
            $rank   = $this->db->select("t1.rank")->from("users_custom_fields AS t1")->order_by("t1.rank DESC")->limit(1);
            $rank   = $rank->build() ? $rank->getObject()->rank+1 : 0;
            return $this->db->insert("users_custom_fields",['lang' => $lang,'rank' => $rank]) ? $this->db->lastID() : false;
        }

        public function check_custom_field($id=0){
            return $this->db->select("id")->from("users_custom_fields")->where("id","=",$id)->build();
        }

        public function set_custom_field($id=0,$data=[]){
            return $this->db->update("users_custom_fields",$data)->where("id","=",$id)->save();
        }

        public function delete_custom_field($id=0){
            return $this->db->delete("users_custom_fields")->where("id","=",$id)->run();
        }

        public function clear_blocking_data(){
            return $this->db->delete("blocked")->run();
        }

        public function page_list()
        {
            $lang    = Bootstrap::$lang->clang;
            $pages   = $this->db->select("t1.id,t2.title")->from("pages AS t1");
            $pages->join("LEFT","pages_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $pages->where("t1.type","=","normal");
            $pages->order_by("t1.id DESC");
            $pages = $pages->build() ? $pages->fetch_assoc() : [];
            return $pages;
        }

    }