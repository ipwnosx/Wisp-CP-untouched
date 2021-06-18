<?php
    /**
    * @author Sitemio Bilişim Teknolojileri Tic. Ltd. Şti.
    * @project Sitemio Temel Kaynak Kod Çekirdek Yapısı
    * @date 2017-07-01 09:00 AM
    * @contract http://www.sitemio.com/hizmet-sozlesmesi.html
    * @copyright Tüm Hakları Sitemio Bilişim Teknolojileri Tic. Ltd. Şti. adına saklıdır
    * @warning Lisanssız kopyalanamaz, dağıtılamaz ve kullanılamaz.
    **/

    defined('CORE_FOLDER') OR exit('You can not get in here!');
    class Model extends Models
    {
        function __construct()
        {
            parent::__construct();
        }

        public function reports_statistic($date='',$uid){
            $sth = $this->db->select("data")->from("sms_logs");
            $sth->where("user_id","=",$uid,"&&");
            $sth->where("owner_id","=",0,"&&");
            $sth->where("reason","=","send-sms","&&");
            if($date) $sth->where("ctime","LIKE","%".$date."%","&&");
            $sth->where("owner","=","international_sms");
            $sth->order_by("id DESC");
            return $sth->build() ? $sth->fetch_assoc() : false;
        }

        public function header_background(){
            $sth = $this->db->select("name")->from("pictures");
            $sth->where("owner","=","account_sms","&&");
            $sth->where("reason","=","header-background");
            $sth->order_by("id DESC");
            return $sth->build() ? $sth->getObject()->name : false;
        }

        public function check_origin_prereg($origin=0,$country=''){
            $sth = $this->db->select("status")->from("users_sms_origin_prereg");
            $sth->where("origin_id","=",$origin,"&&");
            $sth->where("ccode","=",$country);
            return $sth->build() ? $sth->getObject()->status == "active" : false;
        }

        public function get_origin($id=0,$uid=0){
            $sth = $this->db->select("id,name,orkey")->from("users_sms_origins");
            if($uid) $sth->where("user_id","=",$uid,"&&");
            $sth->where("id","=",$id,"&&");
            $sth->where("pid","=",0,"&&");
            $sth->where("status","=","active");
            return $sth->build() ? $sth->getAssoc() : false;
        }

        public function get_origins($uid=0){
            $case = "CASE ";
            $case .= "WHEN status = 'waiting' THEN 1 ";
            $case .= "WHEN status = 'active' THEN 2 ";
            $case .= "END AS rak";
            $sth = $this->db->select("id,name,status,orkey,".$case)->from("users_sms_origins");
            $sth->where("user_id","=",$uid,"&&");
            $sth->where("pid","=",0,"&&");
            $sth->where("status","!=","delete");
            $sth->order_by("rak ASC,id DESC");
            return $sth->build() ? $sth->fetch_assoc() : false;
        }

        public function get_report($id=0,$uid=0){
            $sth = $this->db->select("data")->from("sms_logs");
            $sth->where("user_id","=",$uid,"&&");
            $sth->where("owner_id","=",0,"&&");
            $sth->where("id","=",$id,"&&");
            $sth->where("reason","=","send-sms","&&");
            $sth->where("owner","=","international_sms");
            return $sth->build() ? $sth->getAssoc() : false;
        }

        public function get_reports($uid=0){
            $sth = $this->db->select()->from("sms_logs");
            $sth->where("user_id","=",$uid,"&&");
            $sth->where("owner_id","=",0,"&&");
            $sth->where("reason","=","send-sms","&&");
            $sth->where("owner","=","international_sms");
            $sth->order_by("id DESC");
            return $sth->build() ? $sth->fetch_assoc() : false;
        }

        public function getGroups($uid=0){
            $sth = $this->db->select("id,name,numbers")->from("users_sms_groups");
            $sth->where("user_id","=",$uid,"&&");
            $sth->where("pid","=",0);
            return $sth->build() ? $sth->fetch_assoc() : false;
        }

        public function add_new_group($data=[]){
            return $this->db->insert("users_sms_groups",$data) ? $this->db->lastID() : false;
        }

        public function change_group_numbers($group=0,$uid=0,$numbers=NULL){
            $sth = $this->db->update("users_sms_groups",['numbers' => $numbers]);
            $sth->where("id","=",$group,"&&");
            $sth->where("user_id","=",$uid,"&&");
            $sth->where("pid","=",0);
            return $sth->save();
        }

        /*public function delete_origin($id=0,$uid=0){
            $sth = $this->db->update("users_sms_origins",['status' => "delete"])->where("id","=",$id,"&&")->where("user_id","=",$uid);
            $sth->save();
            if($sth) $this->db->update("users_sms_origin_prereg")->set(['status' => "delete"])->where("origin_id","=",$id)->save();
            return $sth;
        }*/

        public function delete_group($group_id=0,$uid=0){
            $sth = $this->db->delete("users_sms_groups");
            $sth->where("user_id","=",$uid,"&&");
            $sth->where("pid","=",0,"&&");
            $sth->where("id","=",$group_id);
            return $sth->run();
        }

        public function group_check($group_id=0,$uid=0){
            $sth = $this->db->select("id")->from("users_sms_groups");
            $sth->where("user_id","=",$uid,"&&");
            $sth->where("pid","=",0,"&&");
            $sth->where("id","=",$group_id);
            return $sth->build();
        }

        public function get_pre_registereds($oid=0,$lang=''){
            $case = "CASE ";
            $case .= "WHEN t1.status = 'waiting' THEN 1 ";
            $case .= "WHEN t1.status = 'active' THEN 2 ";
            $case .= "END AS rak";
            $selecet = [
                't1.id',
                't1.status',
                't1.status_msg',
                $case,
                '(SELECT cl.name FROM '.$this->pfx.'countries AS c LEFT JOIN '.$this->pfx.'countries_lang AS cl ON cl.owner_id=c.id AND cl.lang="'.$lang.'"  WHERE c.a2_iso=t1.ccode) AS cname',
            ];
            $sth = $this->db->select(implode(",",$selecet))->from("users_sms_origin_prereg AS t1");
            $sth->where("origin_id","=",$oid,"&&");
            $sth->where("status","!=","delete");
            $sth->order_by("rak ASC,id DESC");
            return $sth->build() ? $sth->fetch_assoc() : false;
        }

        public function get_pre_register_countries($codes='',$lang=''){
            $select = [
                'c.id',
                'c.a2_iso AS code',
                'cl.name',
                'CASE WHEN c.a2_iso = "'.$lang.'" THEN 0 ELSE 1 END AS rak',
            ];
            $sth = $this->db->select(implode(",",$select))->from("countries AS c");
            $sth->join("LEFT","countries_lang AS cl","cl.owner_id=c.id AND cl.lang='".$lang."'");
            $sth->where("cl.id","IS NOT NULL","","&&");
            $sth->where('FIND_IN_SET(c.a2_iso,"'.$codes.'")');
            $sth->order_by("rak,cl.name ASC");
            return $sth->build() ? $sth->fetch_assoc() : false;
        }

        public function add_new_origin($data=[]){
            return $this->db->insert("users_sms_origins",$data) ? $this->db->lastID() : false;
        }


        public function get_user_origin($id=0,$uid=0){
            $sth = $this->db->select("id,name")->from("users_sms_origins")->where("id","=",$id,"&&")->where("user_id","=",$uid);
            return $sth->build() ? $sth->getAssoc() : false;
        }

        public function PreRegOriginAlreadyExist($oid=0,$ccode=''){
            $sth = $this->db->select("id")->from("users_sms_origin_prereg");
            $sth->where("origin_id","=",$oid,"&&");
            $sth->where("ccode","=",$ccode,"&&");
            $sth->where("(");
            $sth->where("status","=","active","||");
            $sth->where("status","=","waiting");
            $sth->where(")");
            return $sth->build() ? $sth->getObject()->id : false;
        }

        public function add_origin_prereg_country($data=[]){
            return $this->db->insert("users_sms_origin_prereg",$data);
        }

        public function update_origin_prereg_country($data=[],$id=0){
            return $this->db->update("users_sms_origin_prereg",$data)->where("id","=",$id)->save();
        }


    }