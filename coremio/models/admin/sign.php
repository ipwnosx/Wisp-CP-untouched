<?php
    defined('CORE_FOLDER') OR exit('You can not get in here!');
    class Model extends Models
    {
        function __construct()
        {
            parent::__construct();
        }

        public function get_user_info($email=''){
            $db = $this->db;
            $sth = $db->select("id")->from("users");
            $sth->where("type","=","admin","&&");
            $sth->where("email","=",$email);
            return ($sth->build()) ? $sth->getObject() : false;
        }

    }