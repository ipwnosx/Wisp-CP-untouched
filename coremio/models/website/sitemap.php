<?php
    defined('CORE_FOLDER') OR exit('You can not get in here!');
    class Model extends Models
    {
        function __construct()
        {
            parent::__construct();
        }

        public function categories($lang=''){
            $stmt   = $this->db->select("t1.id,t1.type,t1.kind,t1.kind_id,t2.title,t2.route")->from("categories AS t1");
            $stmt->join("LEFT","categories_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $stmt->where("t2.id","IS NOT NULL","","&&");
            $stmt->where("t1.status","=","active","&&");
            $stmt->where("t1.visibility","=","visible","&&");
            $stmt->where("(");
            $stmt->where("t1.type","=","articles","||");
            $stmt->where("t1.type","=","products","||");
            $stmt->where("t1.type","=","software","||");
            $stmt->where("t1.type","=","knowledgebase","||");
            $stmt->where("t1.type","=","references");
            $stmt->where(")");

            $stmt->order_by("t1.type,t1.rank ASC");
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function pages($lang=''){
            $stmt   = $this->db->select("t1.id,t1.type,t2.title,t2.route")->from("pages AS t1");
            $stmt->join("LEFT","pages_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $stmt->where("t2.id","IS NOT NULL","","&&");
            $stmt->where("t1.status","=","active","&&");
            $stmt->where("t1.visibility","=","visible","&&");
            $stmt->where("(");
            $stmt->where("t1.type","=","normal","||");
            $stmt->where("t1.type","=","news","||");
            $stmt->where("t1.type","=","articles","||");
            $stmt->where("t1.type","=","software","||");
            $stmt->where("t1.type","=","references");
            $stmt->where(")");

            $stmt->order_by("t1.type,t1.rank ASC");
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function kbase($lang=''){
            $stmt   = $this->db->select("t1.id,t2.title,t2.route")->from("knowledgebase AS t1");
            $stmt->join("LEFT","knowledgebase_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $stmt->where("t2.id","IS NOT NULL","","&&");
            $stmt->where("t1.private","=","0");

            $stmt->order_by("t1.rank ASC");
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }


    }