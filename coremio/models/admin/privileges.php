<?php
    defined('CORE_FOLDER') OR exit('You can not get in here!');
    class Model extends Models
    {
        function __construct()
        {
            parent::__construct();
        }

        public function privileges_list(){
            $selecet = [
                'p.id',
                'p.name',
                'GROUP_CONCAT(u.id) AS appointees_ids',
                'GROUP_CONCAT(u.full_name) AS appointees_names'
            ];
            $sth = $this->db->select(implode(",",$selecet))->from("privileges AS p");
            $sth->join("LEFT","users AS u","p.id=u.privilege AND u.type='admin' GROUP BY p.id");
            $sth->order_by("id DESC");
            return $sth->build() ? $sth->fetch_assoc() : false;
        }

        public function add_new_privileges($name='',$perms=''){
            return $this->db->insert("privileges",[
                'name' => $name,
                'privileges' => $perms,
            ]);
        }

        public function update_privileges($id=0,$name='',$perms=''){
            return $this->db->update("privileges",[
                'name' => $name,
                'privileges' => $perms,
            ])->where("id","=",$id)->save();
        }

        public function delete_privileges($id=0){
            return $this->db->delete("privileges")->where("id","=",$id)->run();
        }

        public function checkPrivileges($id=0){
            return $this->db->select("id")->from("privileges")->where("id","=",$id)->build();
        }

    }