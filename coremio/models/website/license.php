<?php
    defined('CORE_FOLDER') OR exit('You can not get in here!');
    class Model extends Models
    {
        function __construct()
        {
            parent::__construct();
        }

        public function checking($domain='',$pid=0){
            $stmt   = $this->db->select("id")->from("users_products");
            #$stmt->where("options","LIKE",'%"domain":"'.$domain.'"%',"&&"); // No subdomain support
            $stmt->where("options","LIKE",'%'.$domain.'%',"&&"); //  subdomain supported

            if($pid) $stmt->where("product_id","=",$pid,"&&");

            $stmt->where("(");
            $stmt->where("duedate","=",DateManager::ata(),"||");
            $stmt->where("duedate",">",DateManager::Now());
            $stmt->where(")","","","&&");

            $stmt->where("status","=","active","&&");
            $stmt->where("type","=","software");

            return $stmt->build() ? $stmt->getAssoc() : false;
        }
        public function checking_key($key='',$pid=0){
            $stmt   = $this->db->select("id,options")->from("users_products");
            $stmt->where('JSON_EXTRACT(options, "$.code")','=',$key,"&&");

            if($pid) $stmt->where("product_id","=",$pid,"&&");

            $stmt->where("(");
            $stmt->where("duedate","=",DateManager::ata(),"||");
            $stmt->where("duedate",">",DateManager::Now());
            $stmt->where(")","","","&&");

            $stmt->where("status","=","active","&&");
            $stmt->where("type","=","software");
            return $stmt->build() ? $stmt->getAssoc() : false;
        }

    }