<?php
    defined('CORE_FOLDER') OR exit('You can not get in here!');
    class Model extends Models
    {
        function __construct()
        {
            parent::__construct();
        }

        public function get_privileges(){
            return $this->db->select("id,name")->from("privileges")->order_by("id DESC")->build() ? $this->db->fetch_assoc() : false;
        }

        public function checkPrivilege($id=0){
            return $this->db->select("id")->from("privileges")->where("id","=",$id)->build();
        }

        public function get_departments($lang=''){
            $sth    = $this->db->select("d.id,d.appointees,dl.name")->from("tickets_departments AS d");
            $sth->join("LEFT","tickets_departments_lang AS dl","dl.owner_id=d.id AND dl.lang='".$lang."'");
            $sth->where("dl.id","IS NOT NULL");
            return $sth->build() ? $sth->fetch_assoc() : false;
        }

        public function admins_list($lang=''){
            $selecet = [
                'u.id',
                'u.email',
                'u.full_name',
                'u.status',
                'GROUP_CONCAT(dl.name) AS departments',
                'p.name AS privilege_name'
            ];
            $sth = $this->db->select(implode(",",$selecet))->from("users AS u");
            $sth->join("LEFT","tickets_departments AS d","FIND_IN_SET(u.id,d.appointees)");
            $sth->join("LEFT","tickets_departments_lang AS dl","dl.owner_id=d.id AND dl.lang='".$lang."'");
            $sth->join("LEFT","privileges AS p","p.id=u.privilege");
            $sth->where("u.type","=","admin");
            $sth->group_by("u.id");
            $sth->order_by("u.id DESC");
            return $sth->build() ? $sth->fetch_assoc() : false;
        }

        public function checkAdmin($id=0){
            $sth = $this->db->select("id")->from("users")->where("type","=","admin","&&")->where("id","=",$id);
            return $sth->build();
        }

        public function delete_admin($id=0){
            $this->db->delete("users")->where("id","=",$id)->run();
            $this->db->delete("users_actions")->where("owner_id","=",$id)->run();
            $this->db->delete("users_informations")->where("owner_id","=",$id)->run();
            $this->db->delete("users_last_logins")->where("owner_id","=",$id)->run();
            $data  = $this->db->select("name")->from("pictures");
            $data->where("owner","=","user","&&");
            $data->where("owner_id","=",$id,"&&");
            $data->where("reason","=","profile-image");
            if($data->build()){
                $row = $data->getAssoc();
                FileManager::file_delete(Config::get("pictures/admin-profile-image/folder").$row["name"]);
                $this->db->delete("pictures")->where("owner","=","user","&&")->where("owner_id","=",$id,"&&")->where("reason","=","profile-image")->run();
            }
            $data = $this->db->select("id,appointees")->from("tickets_departments");
            $data->where("FIND_IN_SET(".$id.",appointees)");
            if($data->build()){
                foreach($data->fetch_assoc() AS $row){
                    $appointees     = $row["appointees"] ? explode(",",$row["appointees"]) : [];
                    if(false !== $key = array_search($id,$appointees)) unset($appointees[$key]);
                    $appointees     = $appointees ? implode(",",$appointees) : NULL;
                    $this->db->update("tickets_departments",['appointees' => $appointees])->where("id","=",$row["id"])->save();
                }
            }
            return true;
        }

        public function add_admin($datas=[]){
            return $this->db->insert("users",$datas) ? $this->db->lastID() : false;
        }

        public function add_profile_image($uid,$name=''){
            return $this->db->insert("pictures",[
                'owner' => "user",
                'owner_id' => $uid,
                'reason' => "profile-image",
                'name' => $name,
            ]);
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
                $insert = $this->add_profile_image($uid,$name);

            return $check ? ['name' => $check->name] : $insert;
        }

        public function get_department($id=0,$lang){
            $sth    = $this->db->select("d.id,d.appointees,dl.name")->from("tickets_departments AS d");
            $sth->join("LEFT","tickets_departments_lang AS dl","dl.owner_id=d.id AND dl.lang='".$lang."'");
            $sth->where("dl.id","IS NOT NULL","","&&");
            $sth->where("d.id","=",$id);
            return $sth->build() ? $sth->getAssoc() : false;
        }

        public function set_department($id=0,$data=[]){
            return $this->db->update("tickets_departments",$data)->where("id","=",$id)->save();
        }


    }