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

        public function get_total_invoices($uid=0,$searches=[]){
            $sth = $this->db->select("COUNT(id) AS total")->from("invoices");
            $sth->where("user_id","=",$uid,"&&");
            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $date       = DateManager::datetime_format_ifin($word);
                    $sth->where("(");
                    $sth->where("id","=",$word,"||");
                    $sth->where("cdate","LIKE","%".$date."%","||");
                    $sth->where("duedate","LIKE","%".$date."%");
                    $sth->where(")","","","&&");
                }
            }
            $sth->where("(");
            $sth->where("status","=","waiting","||");
            $sth->where("status","=","refund","||");
            $sth->where("status","=","paid","||");
            $sth->where("status","=","unpaid","||");
            $sth->where("status","=","cancelled");
            $sth->where(")");
            return $sth->build() ? $this->db->getObject()->total : 0;
        }

        public function get_invoices($user_id=0,$searches=[],$orders=[],$start=0,$end=1){
            $case = "CASE ";
            $case .= "WHEN status = 'waiting' THEN 0 ";
            $case .= "WHEN status = 'unpaid' THEN 2 ";
            $case .= "WHEN status = 'paid' THEN 3 ";
            $case .= "ELSE 4 ";
            $case .= "END AS rank";
            $sth = $this->db->select("id,number,status,cdate,duedate,subtotal,total,currency,".$case)->from("invoices");
            $sth->where("user_id","=",$user_id,"&&");
            if($searches){
                if(isset($searches["word"])){
                    $word   = $searches["word"];
                    $date       = DateManager::datetime_format_ifin($word);
                    $sth->where("(");
                    $sth->where("id","=",$word,"||");
                    $sth->where("cdate","LIKE","%".$date."%","||");
                    $sth->where("duedate","LIKE","%".$date."%");
                    $sth->where(")","","","&&");
                }
            }
            $sth->where("(");
            $sth->where("status","=","waiting","||");
            $sth->where("status","=","refund","||");
            $sth->where("status","=","paid","||");
            $sth->where("status","=","unpaid","||");
            $sth->where("status","=","cancelled");
            $sth->where(")");
            if($orders) $sth->order_by(implode(",",$orders).",id DESC");
            else $sth->order_by("rank ASC,id DESC");
            $sth->limit($start,$end);
            return ($sth->build()) ? $sth->fetch_assoc() : false;
        }

        public function get_unpaid_invoices($user_id=0){
            $sth = $this->db->select()->from("invoices");
            $sth->where("user_id","=",$user_id,"&&");
            $sth->where("status","=","unpaid");
            $sth->order_by("subtotal ASC");
            return ($sth->build()) ? $sth->fetch_assoc() : false;
        }

    }