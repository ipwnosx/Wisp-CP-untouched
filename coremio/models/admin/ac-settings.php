<?php
    defined('CORE_FOLDER') OR exit('You can not get in here!');
    class Model extends Models
    {
        function __construct()
        {
            parent::__construct();
        }

        public function set_profile_image($uid=0,$name=''){
            $check = $this->db->select("id,name")->from("pictures");
            $check->where("owner","=","user","&&");
            $check->where("owner_id","=",$uid,"&&");
            $check->where("reason","=","profile-image");
            if($check->build())
                $check = $check->getObject();
            else
                $check = false;

            $update     = false;

            if($check) $this->db->update("pictures",['name' => $name])->where("id","=",$check->id)->save();
            else
                $insert = $this->db->insert("pictures",[
                    'owner' => "user",
                    'owner_id' => $uid,
                    'reason' => "profile-image",
                    'name' => $name,
                ]);

            return $check ? ['name' => $check->name] : $insert;
        }

    }