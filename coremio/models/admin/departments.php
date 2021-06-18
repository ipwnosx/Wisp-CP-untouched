<?php
    defined('CORE_FOLDER') OR exit('You can not get in here!');
    class Model extends Models
    {
        function __construct()
        {
            parent::__construct();
        }

        public function delete_department($id=0){
            return $this->db->delete("dps,dpsl","tickets_departments dps")
                ->join("LEFT","tickets_departments_lang dpsl","dpsl.owner_id=dps.id")
                ->where("dps.id","=",$id)
                ->run();
        }

        public function get_department($id=0){
            $lang = Config::get("general/local");
            return $this->db->select("t1.*,t2.name")
                ->from("tickets_departments AS t1")
                ->join("LEFT","tickets_departments_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'")
                ->where("t2.id","IS NOT NULL","","&&")
                ->where("t1.id","=",$id)
                ->build() ? $this->db->getAssoc() : false;
        }

        public function get_department_lang($id=0,$lang=''){
            return $this->db->select()
                ->from("tickets_departments_lang")
                ->where("owner_id","=",$id,"&&")
                ->where("lang","=",$lang)->build() ? $this->db->getAssoc() : false;
        }

        public function insert_department($data=[]){
            return $this->db->insert("tickets_departments",$data) ? $this->db->lastID() : false;
        }

        public function insert_department_lang($data=[]){
            return $this->db->insert("tickets_departments_lang",$data) ? $this->db->lastID() : false;
        }

        public function set_department($id=0,$data=[]){
            return $this->db->update("tickets_departments",$data)->where("id","=",$id)->save();
        }

        public function set_department_lang($id=0,$data=[]){
            return $this->db->update("tickets_departments_lang",$data)->where("id","=",$id)->save();
        }

        public function get_departments($searches='',$orders=[],$start=0,$end=1){
            $ll_lang    = Config::get("general/local");
            $sd_lang    = Bootstrap::$lang->clang;

            $select = implode(",",[
                't1.id',
                't1.appointees',
                't2.name',
                't2.description',
            ]);
            $sth = $this->db->select($select)->from("tickets_departments AS t1");
            $sth->join("LEFT","tickets_departments_lang AS t2","t2.owner_id=t1.id AND (t2.lang='".$ll_lang."')");

            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $sth->where("(");
                    $sth->where("t1.id","=",$word,"||");
                    $sth->where("t2.name","LIKE","%".$word."%","||");
                    $sth->where("t2.description","LIKE","%".$word."%","");
                    $sth->where(")","","","&&");
                }
            }
            $sth->order_by("t1.id DESC");
            $sth->limit($start,$end);
            return $sth->build() ? $sth->fetch_assoc() : false;
        }

        public function get_departments_total($searches=''){
            $ll_lang    = Config::get("general/local");
            $sd_lang    = Bootstrap::$lang->clang;

            $select = 't1.id';
            $sth = $this->db->select($select)->from("tickets_departments AS t1");
            $sth->join("LEFT","tickets_departments_lang AS t2","t2.owner_id=t1.id AND (t2.lang='".$ll_lang."')");

            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $sth->where("(");
                    $sth->where("t1.id","=",$word,"||");
                    $sth->where("t2.name","LIKE","%".$word."%","||");
                    $sth->where("t2.description","LIKE","%".$word."%","");
                    $sth->where(")","","","&&");
                }
            }
            return $sth->build() ? $sth->rowCounter() : 0;
        }

        public function select_admins(){
            $stmt   = $this->db->select("id,full_name")->from("users");
            $stmt->where("type","=","admin");
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

    }