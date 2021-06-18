<?php
    defined('CORE_FOLDER') OR exit('You can not get in here!');
    class Model extends Models
    {
        function __construct()
        {
            parent::__construct();
        }

        public function get_sms_origin($pid=0,$name='',$id=0){
            $sth = $this->db->select("id,name")->from("users_sms_origins");
            if($id) $sth->where("id","=",$id,"&&");
            if($name) $sth->where("name","=",$name,"&&");
            if($pid) $sth->where("pid","=",$pid,"&&");
            $sth->where("status","=","active");
            return $sth->build() ? $sth->getAssoc() : false;
        }

        public function get_intl_sms_origin($name='',$uid=0){
            $sth = $this->db->select("id,name")->from("users_sms_origins");
            $sth->where("name","=",$name,"&&");
            $sth->where("user_id","=",$uid,"&&");
            $sth->where("status","=","active");
            return $sth->build() ? $sth->getAssoc() : false;
        }

        public function check_origin_prereg($origin=0,$country=''){
            $sth = $this->db->select("status")->from("users_sms_origin_prereg");
            $sth->where("origin_id","=",$origin,"&&");
            $sth->where("ccode","=",$country);
            return $sth->build() ? $sth->getObject()->status == "active" : false;
        }

        public function get_sms_report($id=0,$pid=0){
            $sth = $this->db->select("data")->from("sms_logs");
            $sth->where("owner_id","=",$pid,"&&");
            $sth->where("id","=",$id,"&&");
            $sth->where("reason","=","send-sms","&&");
            $sth->where("owner","=","users_products");
            return $sth->build() ? $sth->getAssoc() : false;
        }

        public function get_intl_sms_report($id=0,$uid=0){
            $sth = $this->db->select("data")->from("sms_logs");
            $sth->where("user_id","=",$uid,"&&");
            $sth->where("owner_id","=",0,"&&");
            $sth->where("id","=",$id,"&&");
            $sth->where("reason","=","send-sms","&&");
            $sth->where("owner","=","international_sms");
            return $sth->build() ? $sth->getAssoc() : false;
        }

    }