<?php
    defined('CORE_FOLDER') OR exit('You can not get in here!');
    class Model extends Models
    {
        function __construct()
        {
            parent::__construct();
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
            $this->db->delete("cy,cyl","categories cy")
                ->join("INNER","categories_lang cyl","cyl.owner_id=cy.id")
                ->where("cy.id","=",$id)->run();

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
                    }
                }
            }
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

        public function category_route_check($route='',$lang='',$type=''){
            $sth = $this->db->select("t1.id")->from("categories AS t1");
            $sth->join("LEFT","categories_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $sth->where("t2.id","IS NOT NULL","","&&");
            $sth->where("t1.type","=",$type,"&&");
            $sth->where("t2.route","=",$route);
            return $sth->build() ? $sth->getObject()->id : false;
        }

        public function get_categories($type='',$searches='',$orders=[],$start=0,$end=1){

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

            $sth->where("t1.type","=",$type);

            if($orders) $sth->order_by(implode(",",$orders).",t1.id DESC");
            else $sth->order_by("t1.id DESC");
            $sth->limit($start,$end);
            return $sth->build() ? $sth->fetch_assoc() : false;
        }

        public function get_categories_total($type='',$searches=[]){
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
            $sth->where("t1.type","=",$type);
            return $sth->build() ? $sth->rowCounter() : 0;
        }

        public function delete_picture($owner='',$owner_id=0,$reason=''){
            $stmt   = $this->db->delete("pictures");
            $stmt->where("owner","=",$owner,"&&");
            $stmt->where("owner_id","=",$owner_id,"&&");
            $stmt->where("reason","=",$reason);
            return $stmt->run();
        }

        public function get_picture($owner='',$owner_id=0,$reason=''){
            $stmt   = $this->db->select("name")->from("pictures");
            $stmt->where("owner","=",$owner,"&&");
            $stmt->where("owner_id","=",$owner_id,"&&");
            $stmt->where("reason","=",$reason);
            return $stmt->build() ? $stmt->getObject()->name : false;
        }

        public function delete($pid){
            $type = "knowledgebase";

            // Header Background

            $folder1    = Config::get("pictures/header-background/folder");
            $folder2    = $folder1."thumb".DS;

            $pic1       = $this->db->select("id,name")->from("pictures");
            $pic1->where("owner","=","page_".$type,"&&");
            $pic1->where("owner_id","=",$pid,"&&");
            $pic1->where("reason","=","header-background");
            $pic1       = $pic1->build() ? $pic1->getAssoc() : false;
            if($pic1){
                FileManager::file_delete($folder1.$pic1["name"]);
                FileManager::file_delete($folder2.$pic1["name"]);
                $this->db->delete("pictures")->where("id","=",$pic1["id"])->run();
            }

            return $this->db->delete("ps,psl","knowledgebase ps")
                ->join("INNER","knowledgebase_lang psl","psl.owner_id=ps.id")
                ->where("ps.id","=",$pid)
                ->run();
        }

        public function get($id=0){
            $lang = Config::get("general/local");
            return $this->db->select("t1.*,t2.title")
                ->from("knowledgebase AS t1")
                ->join("LEFT","knowledgebase_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'")
                ->where("t1.id","=",$id)
                ->build() ? $this->db->getAssoc() : false;
        }

        public function get_lang($id=0,$lang=''){
            return $this->db->select()
                ->from("knowledgebase_lang")
                ->where("owner_id","=",$id,"&&")
                ->where("lang","=",$lang)->build() ? $this->db->getAssoc() : false;
        }

        public function insert_picture($owner='',$owner_id=0,$reason='',$name=''){
            return $this->db->insert("pictures",[
                'owner_id' => $owner_id,
                'owner' => $owner,
                'reason' => $reason,
                'name' => $name,
            ]) ? $this->db->lastID() : false;
        }

        public function insert($data=[]){
            return $this->db->insert("knowledgebase",$data) ? $this->db->lastID() : false;
        }

        public function set($id,$data=[]){
            return $this->db->update("knowledgebase",$data)->where("id","=",$id)->save();
        }

        public function insert_lang($data=[]){
            return $this->db->insert("knowledgebase_lang",$data) ? $this->db->lastID() : false;
        }

        public function set_lang($id,$data=[]){
            return $this->db->update("knowledgebase_lang",$data)->where("id","=",$id)->save();
        }

        public function get_list($searches='',$orders=[],$start=0,$end=1){
            $ll_lang    = Config::get("general/local");
            $sd_lang    = Bootstrap::$lang->clang;

            $select = implode(",",[
                't1.id',
                't2.title',
                't2.route',
                't1.ctime',
                't1.useful',
                't1.useless',
                't1.visit_count',
                't1.category AS category_id',
                't3.title AS category',
                't3.route AS category_route',
            ]);
            $sth = $this->db->select($select)->from("knowledgebase AS t1");
            $sth->join("LEFT","knowledgebase_lang AS t2","t2.owner_id=t1.id AND (t2.lang='".$ll_lang."')");
            $sth->join("LEFT","categories_lang AS t3","t3.owner_id=t1.category AND (t3.lang='".$ll_lang."')");

            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $sth->where("(");
                    $sth->where("t1.id","=",$word,"||");
                    $sth->where("t2.title","LIKE","%".$word."%","||");
                    $sth->where("t2.tags","LIKE","%".$word."%","||");
                    $sth->where("t3.title","LIKE","%".$word."%");
                    $sth->where(")","","","");
                }
            }
            $sth->group_by("t1.id");
            $sth->order_by("t1.id DESC");
            $sth->limit($start,$end);
            return $sth->build() ? $sth->fetch_assoc() : false;
        }

        public function get_list_total($searches=''){
            $ll_lang    = Config::get("general/local");
            $sd_lang    = Bootstrap::$lang->clang;

            $select = "t1.id";
            $sth = $this->db->select($select)->from("knowledgebase AS t1");
            $sth->join("LEFT","knowledgebase_lang AS t2","t2.owner_id=t1.id AND (t2.lang='".$ll_lang."')");
            $sth->join("LEFT","categories_lang AS t3","t3.owner_id=t1.category AND (t3.lang='".$ll_lang."')");

            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $sth->where("(");
                    $sth->where("t1.id","=",$word,"||");
                    $sth->where("t2.title","LIKE","%".$word."%","||");
                    $sth->where("t2.tags","LIKE","%".$word."%","||");
                    $sth->where("t3.title","LIKE","%".$word."%");
                    $sth->where(")","","","");
                }
            }
            return $sth->build() ? $sth->rowCounter() : 0;
        }

        public function get_select_categories($type='',$parent=0,$line=''){
            $ll_lang    = Config::get("general/local");
            //$sd_lang    = Bootstrap::$lang->clang;

            $stmt = $this->db->select("c.id,c.parent,c.options,cl.title,cl.options AS optionsl")->from("categories AS c");
            $stmt->join("LEFT","categories_lang AS cl","cl.owner_id=c.id AND (cl.lang='".$ll_lang."')");
            $stmt->where("cl.id","IS NOT NULL","","&&");
            $stmt->where("c.parent","=",$parent,"&&");
            $stmt->where("c.type","=",$type);
            $stmt->order_by("c.rank ASC");
            $result     = $stmt->build() ? $stmt->fetch_assoc() : [];
            $new_result = [];
            if($result){
                foreach($result AS $res){
                    $new    = $res;
                    $new["title"] = $line." ".$res["title"];
                    $new_result[] = $new;
                    $sub_result = $this->get_select_categories($type,$res["id"],$line."-");
                    if($sub_result){
                        $new_result = array_merge($new_result,$sub_result);
                    }
                }
            }
            return $new_result;
        }

        public function route_check($route='',$lang=''){
            $sth = $this->db->select("t1.id")->from("knowledgebase AS t1");
            $sth->join("LEFT","knowledgebase_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $sth->where("t2.id","IS NOT NULL","","&&");
            $sth->where("t2.route","=",$route);
            return $sth->build() ? $sth->getObject()->id : false;
        }

    }