<?php
    defined('CORE_FOLDER') OR exit('You can not get in here!');
    class Model extends Models
    {
        function __construct()
        {
            parent::__construct();
        }

        public function getTLD($name='',$rank='0'){
            $sth = $this->db->select()->from("tldlist");
            $sth->where("status","=","active","&&");
            if($name != '') $sth->where("name","=",$name);
            elseif(!is_string($rank)) $sth->where("rank","=",$rank);
            return $sth->build() ? $sth->getAssoc() : false;
        }

        public function get_total_activity($user_id=0){
            $this->db_start();
            $sth = $this->db->select("COUNT(id) AS count")->from("users_actions");
            $sth->where("owner_id","=",$user_id);
            if(!$sth->build()) return false;
            return $sth->getObject()->count;
        }

        public function get_activity($user_id=0,$start,$end){
            $this->db_start();
            $sth = $this->db->select()->from("users_actions");
            $sth->where("owner_id","=",$user_id);
            $sth->order_by("id DESC");
            $sth->limit($start,$end);
            if(!$sth->build()) return false;
            return $sth->fetch_assoc();
        }

        public function get_total_news($lang){
            $this->db_start();
            $sth = $this->db->select("COUNT(t1.id) AS count")->from("pages AS t1");
            $sth->join("LEFT","pages_lang AS t2","t2.owner_id=t1.id AND lang='{$lang}'");
            $sth->where("t2.id","IS NOT NULL","","&&");
            $sth->where("status","=","active","&&");
            $sth->where("t1.visible_to_user","=","1");
            if(!$sth->build()) return false;
            return $sth->getObject()->count;
        }

        public function get_news($lang,$start,$end){
            $format_convert = str_replace(['d','m','Y',],['%d','%m','%Y'],Config::get("options/date-format"));
            $this->db_start();
            $sth = $this->db->select("t1.type,DATE_FORMAT(t1.ctime,'".$format_convert."') AS date,t2.id,t2.title,t2.content,t3.name AS image,t2.route")->from("pages AS t1");
            $sth->join("LEFT","pages_lang AS t2","t2.owner_id=t1.id AND lang='{$lang}'");
            $sth->join("LEFT","pictures AS t3","t1.id=t3.owner_id AND t3.owner=concat('page_',t1.type) AND t3.reason='cover'");
            $sth->where("t2.id","IS NOT NULL","","&&");
            $sth->where("status","=","active","&&");
            $sth->where("t1.visible_to_user","=","1");
            $sth->order_by("t1.ctime DESC");
            $sth->limit($start,$end);
            if(!$sth->build()) return false;
            return $sth->fetch_assoc();
        }

        public function get_tickets($user_id=0,$searches=[],$orders=[],$start=0,$end=5){
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

        public function get_products($uid=0,$type='',$pids=''){
            $format_convert = str_replace(['d','m','Y',],['%d','%m','%Y'],Config::get("options/date-format"));
            $case = "CASE ";
            $case .= "WHEN status = 'waiting' THEN 1 ";
            $case .= "WHEN status = 'inprocess' THEN 2 ";
            $case .= "WHEN status = 'active' THEN 3 ";
            $case .= "ELSE 4 ";
            $case .= "END AS rank";
            $sth = $this->db->select("id,type,product_id,name,status,period,period_time,amount,amount_cid,DATE_FORMAT(cdate,'".$format_convert." %H:%i') AS cdate,duedate,options,".$case)->from("users_products");
            if($pids != '')
                $sth->where("FIND_IN_SET(product_id,'".$pids."')","","","&&");
            if($type == ''){
                $sth->where("owner_id","=",$uid,"&&");
                $sth->where("type","!=","domain");
            }else{
                $sth->where("owner_id","=",$uid,"&&");
                $sth->where("type","=",$type);
            }
            $sth->order_by("rank ASC,id DESC");
            $sth->limit(0,5);
            return $sth->build() ? $sth->fetch_assoc() : false;
        }

    }