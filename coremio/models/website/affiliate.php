<?php
    defined('CORE_FOLDER') OR exit('You can not get in here!');
    class Model extends Models
    {
        function __construct()
        {
            parent::__construct();
        }

        public function product_commissions($type='hosting',$cat_id=0)
        {
            $_type  = $type == 'software' ? "pages" : "products";
            $select = "t1.id,t1.category,t1.type,t1.affiliate_rate,t2.title";
            if($_type == "products") $select .= ",t1.type_id";
            $lang   = Bootstrap::$lang->clang;
            $stmt   = $this->db->select($select)->from($_type." AS t1");
            $stmt->join("LEFT",$_type."_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            if($cat_id) $stmt->where("t1.category","=",$cat_id,"&&");
            $stmt->where("t1.status","=","active","&&");
            $stmt->where("t1.type","=",$type,"&&");
            $stmt->where("t1.visibility","=","visible","&&");
            $stmt->where("t1.affiliate_disable","=","0","&&");
            $stmt->where("t1.affiliate_rate",">","0.00");
            $stmt->order_by("id ASC");
            return $stmt->build() ? $stmt->fetch_assoc() : [];
        }

        public function referrer($str='',$aff_id=0)
        {
            $stmt       = $this->db->select("id")->from("users_affiliate_referrers");
            $stmt->where("affiliate_id","=",$aff_id,"&&");
            $stmt->where("referrer","=",$str);
            return $stmt->build() ? $stmt->getObject()->id : 0;
        }

        public function insert_referrer($data=[])
        {
            return $this->db->insert("users_affiliate_referrers",$data) ? $this->db->lastID() : 0;
        }

        public function insert_hit($data=[])
        {
            return $this->db->insert("users_affiliate_hits",$data) ? $this->db->lastID() : 0;
        }

        public function pending_withdrawal($aff_id=0)
        {
            $stmt       = $this->db->select()->from("users_affiliate_withdrawals");
            $stmt->where("affiliate_id","=",$aff_id,"&&");
            $stmt->where("(");
            $stmt->where("status","=","awaiting","||");
            $stmt->where("status","=","process");
            $stmt->where(")");
            return $stmt->build() ? $stmt->getAssoc() : false;
        }

        public function insert_withdrawal($data=[]){
            return $this->db->insert("users_affiliate_withdrawals",$data) ? $this->db->lastID() : 0;
        }

    }