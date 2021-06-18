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

        public function get_total_tickets($user_id,$searches=[]){
            $sth = $this->db->select("COUNT(id) AS total")->from("tickets");
            $sth->where("user_id","=",$user_id,"&&");
            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $date       = DateManager::datetime_format_ifin($word);
                    $sth->where("(");
                    $sth->where("id","=",$word,"||");
                    $sth->where("title","LIKE","%".$word."%","||");
                    $sth->where("ctime","LIKE","%".$date."%","||");
                    $sth->where("lastreply","LIKE","%".$date."%");
                    $sth->where(")","","","&&");
                }
            }
            $sth->where("status","!=","delete");
            return $sth->build(true) ? $this->db->getObject()->total : 0;
        }

        public function get_tickets($user_id=0,$searches=[],$orders=[],$start=0,$end=10){
            $case = "CASE ";
            $case .= "WHEN status = 'process' THEN 1 ";
            $case .= "WHEN status = 'waiting' THEN 2 ";
            $case .= "WHEN status = 'replied' THEN 3 ";
            $case .= "WHEN status = 'solved' THEN 4 ";
            $case .= "END AS rank";
            $sth = $this->db->select("id,service,title,status,locked,ctime,lastreply,userunread,".$case)->from("tickets");
            $sth->where("user_id","=",$user_id,"&&");
            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $date       = DateManager::datetime_format_ifin($word);
                    $sth->where("(");
                    $sth->where("id","=",$word,"||");
                    $sth->where("title","LIKE","%".$word."%","||");
                    $sth->where("ctime","LIKE","%".$date."%","||");
                    $sth->where("lastreply","LIKE","%".$date."%");
                    $sth->where(")","","","&&");
                }
            }
            $sth->where("status","!=","delete");
            if($orders) $sth->order_by(implode(",",$orders).",lastreply DESC");
            else $sth->order_by("rank ASC,lastreply DESC");
            $sth->limit($start,$end);
            return ($sth->build()) ? $sth->fetch_assoc() : false;
        }

        public function getDepartments($lang){
            $sth = $this->db->select("t1.id,t2.name,t2.description")->from("tickets_departments AS t1")->join("LEFT","tickets_departments_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $sth->order_by("rank ASC");
            return ($sth->build()) ? $sth->fetch_assoc() : false;
        }

        public function foundKnowledgeBase($word='',$lang=''){
            if($word != ''){
                $explode    = explode(" ",$word);
                $sth    = $this->db->select("t1.id,t2.route,t2.title")->from("knowledgebase AS t1")->join("LEFT","knowledgebase_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
                $sth->where("t2.id","IS NOT NULL","","&&");
                $sth->where("t2.tags","LIKE","%".$word."%");
                $sth->order_by("t1.id DESC");
                $sth->limit(5);
                return ($sth->build()) ? $sth->fetch_assoc() : false;
            }
        }

        public function create_request($data=[]){
            return $this->db->insert("tickets",$data) ? $this->db->lastID() : false;
        }

        public function update_request($data=[],$id=0){
            return $this->db->update("tickets",$data)->where("id","=",$id)->save();
        }

        public function send_reply($data=[]){
            return $this->db->insert("tickets_replies",$data) ? $this->db->lastID() : 0;
        }

        public function getDepartment($id=0,$lang){
            if($id != 0){
                $sth    = $this->db->select("t1.id,t1.appointees,t2.name,t2.description");
                $sth->from("tickets_departments AS t1")->join("LEFT","tickets_departments_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
                $sth->where("t1.id","=",$id,"&&");
                $sth->where("t2.id","IS NOT NULL");
                return ($sth->build()) ? $sth->getAssoc() : false;
            }
        }

        public function getService($id=0){
            return ['name' => "None"];
        }

        public function getTicket($id=0,$user_id=0){
            $sth = $this->db->select("id")->from("tickets");
            $sth->where("id","=",$id,"&&");
            $sth->where("user_id","=",$user_id);
            $sth =  ($sth->build()) ? $sth->getAssoc() : false;
            return $sth ? Tickets::get_request($id) : false;
        }

        public function getReplies($id=0){
            $format_convert = str_replace(['d','m','Y',],['%d','%m','%Y'],Config::get("options/date-format"));
            $sth = $this->db->select("*,DATE_FORMAT(ctime,'".$format_convert." %H:%i') AS date")->from("tickets_replies");
            $sth->where("owner_id","=",$id);
            $sth->order_by("id DESC");
            return $sth->build() ? $sth->fetch_assoc() : false;
        }

        public function getAttachments($id=0){
            $sth = $this->db->select("id,file_name")->from("tickets_attachments");
            $sth->where("reply_id","=",$id);
            return ($sth->build()) ? $sth->fetch_assoc() : false;
        }

        public function getAttachment($id=0){
            $sth = $this->db->select("id,file_name")->from("tickets_attachments");
            $sth->where("id","=",$id);
            return ($sth->build()) ? $sth->getAssoc() : false;
        }

        public function addAttachment($data=[]){
            return $this->db->insert("tickets_attachments",$data) ? $this->db->lastID() : false;
        }

        public function userRead($id=0){
            $apply = $this->db->update("tickets",['userunread'=>1])->where("id","=",$id)->save();
            if($apply)
                $this->db->update("events")
                    ->set(['unread' => 1,'status' => 'approved'])
                    ->where("type","=","notification","&&")
                    ->where("owner","=","ticket","&&")
                    ->where("owner_id","=",$id,"&&")
                    ->where("unread","=","0")
                    ->save();

            return $apply;
        }

        public function ntobCheck($user_id=0){
            return $this->db->select("id")->from("tickets")->where("user_id","=",$user_id,"&&")->where("status","!=","solved")->build();
        }
    }