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

        public function getAddress($id=0,$uid=0){
            $sth = $this->db->select()->from("users_addresses");
            $sth->where("id","=",$id,"&&");
            $sth->where("owner_id","=",$uid);
            return $sth->build() ? $sth->getAssoc() : false;
        }

        public function get_verify_code($uid,$type,$data){
            if($type == "email"){
                $stmt   = $this->db->select("data")->from("mail_logs")->where("user_id","=",$uid,"&&");
                $stmt->where("reason","=","email-activation","&&");
                $stmt->where("addresses","=",$data,"&&");
                $stmt->where("DATE_SUB('".DateManager::Now()."', INTERVAL 1 DAY) < ctime");
                $stmt->order_by("id DESC");
            }
            if($type == "gsm"){
                $stmt   = $this->db->select("data")->from("sms_logs");
                $stmt->where("user_id","=",$uid,"&&");
                $stmt->where("reason","=","gsm-activation","&&");
                $stmt->where("(");
                $stmt->where("numbers","=",$data,"||");
                $stmt->where("numbers","=","+".$data);
                $stmt->where(")","","","&&");
                
                $stmt->where("DATE_SUB('".DateManager::Now()."', INTERVAL 1 DAY) < ctime");
                $stmt->order_by("id DESC");
            }
            $result = $stmt->build() ? $stmt->getObject()->data : false;
            return $result;
        }

        public function get_custom_fields($lang=''){
            $stmt   = $this->db->select()->from("users_custom_fields");
            $stmt->where("status","=","active","&&");
            $stmt->where("lang","=",$lang);
            $stmt->order_by("rank ASC");
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function get_custom_field($id=0){
            $stmt   = $this->db->select()->from("users_custom_fields");
            $stmt->where("status","=","active","&&");
            $stmt->where("id","=",$id);
            return $stmt->build() ? $stmt->getAssoc() : false;
        }

        public function getAddresses($id=0){
            $sth = $this->db->select()->from("users_addresses");
            $sth->where("status","=","active","&&");
            $sth->where("owner_id","=",$id);
            $sth->order_by("detouse DESC,id DESC");
            if(!$sth->build()) return false;
            return $sth->fetch_assoc();
        }

        public function getCounti($id=0){
            $sth = $this->db->select("name")->from("counties")->where("id","=",$id);
            if($sth->build()){
                return $sth->getObject()->name;
            }else
                return false;
        }

        public function getCity($id=0){
            $sth = $this->db->select("name")->from("cities")->where("id","=",$id);
            if($sth->build())
                return $sth->getObject()->name;
            else
                return false;
        }

        public function getCountry($id=0,$lang=''){
            $sth = $this->db->select("t2.name")->from("countries AS t1")->join("LEFT","countries_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $sth->where("t2.id","IS NOT NULL","","&&");
            $sth->where("t1.id","=",$id);
            if($sth->build())
                return $sth->getObject()->name;
            else
                return false;
        }

        public function CheckAddress($id=0,$uid=0){
            $check      = $this->db->select("id")->from("users_addresses");
            $check->where("status","=","active","&&");
            $check->where("owner_id","=",$uid,"&&");
            $check->where("id","=",$id);
            return $check->build();
        }

        public function DeleteAddress($id=0){
            return $this->db->update("users_addresses")->set(['status' => "delete"])->where("id","=",$id)->save();
        }

        public function totalAddress($uid=0){
            $sth      = $this->db->select("COUNT(id) AS count")->from("users_addresses");
            $sth->where("status","=","active","&&");
            $sth->where("owner_id","=",$uid);
            return ($sth->build()) ? $sth->getObject()->count : 0;
        }

        public function getCountryList($lang){
            $sth = $this->db->select("t1.id,t1.a2_iso AS code,t2.name")->from("countries AS t1")->join("LEFT","countries_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $sth->where("t2.id","IS NOT NULL");
            $sth->order_by("t1.id ASC");
            return $sth->build() ? $sth->fetch_assoc() : false;
        }

        public function getCities($country=0){
            $sth = $this->db->select("id,name")->from("cities");
            $sth->where("country_id","=",$country);
            $sth->order_by("name ASC");
            return $sth->build() ? $sth->fetch_assoc() : false;
        }

        public function getCounties($city=0){
            $sth = $this->db->select("id,name")->from("counties");
            $sth->where("city_id","=",$city);
            $sth->order_by("id ASC");
            return $sth->build() ? $sth->fetch_assoc() : false;
        }

        public function CheckCountry($id=0){
            $sth = $this->db->select("id")->from("countries")->where("id","=",$id);
            return $sth->build();
        }

        public function CheckCity($id=0){
            $sth = $this->db->select("id")->from("cities")->where("id","=",$id);
            return $sth->build();
        }

        public function CheckCounti($id=0){
            $sth = $this->db->select("id")->from("counties")->where("id","=",$id);
            return $sth->build();
        }

        public function addNewAddress($data){
            if(sizeof($data)>0){
                $insert = $this->db->insert("users_addresses",$data);
                return ($insert) ? $this->db->lastID() : false;
            }
        }

        public function setAddress($id=0,$data=[]){
            return $this->db->update("users_addresses",$data)->where("id","=",$id)->save();
        }

        public function updateAddress($id=0,$data=[]){
            $sth = $this->db->update("users_addresses",$data)->where("id","=",$id);
            return $sth->save();
        }

    }