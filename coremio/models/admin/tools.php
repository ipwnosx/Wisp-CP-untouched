<?php
    defined('CORE_FOLDER') OR exit('You can not get in here!');
    class Model extends Models
    {
        private $error_log_total=0,$error_log_filtered_total=0;
        function __construct()
        {
            parent::__construct();
        }

        public function get_contact_list($user_type,$type,$user_groups,$departments,$countries,$languages,$services,$servers,$addons,$services_ss,$without_products,$client_ss,$birthday_marketing)
        {
            Helper::Load("User");
            return User::bulk_notification_contact_list($user_type,$type,$user_groups,$departments,$countries,$languages,$services,$servers,$addons,$services_ss,$without_products,$client_ss,$birthday_marketing);
        }

        public function get_total_user_count($type=''){

            $stmt   = $this->db->select("COUNT(t1.id) AS total")->from("users_informations AS t2");
            $stmt->join("LEFT","users AS t1","t1.id=t2.owner_id");

            $stmt->where("t1.id","IS NOT NULL","","&&");

            if($type == "email"){
                $stmt->where("t2.name","=","email_notifications","&&");
            }
            elseif($type == "gsm"){
                $stmt->where("t2.name","=","sms_notifications","&&");
                $stmt->where("t1.phone","!=","","&&");
            }

            $stmt->where("t2.content","=","1","&&");

            $stmt->where("t1.type","=","member","&&");

            $stmt->where("t1.status","=","active","");


            return $stmt->build() ? $stmt->getObject()->total : 0;
        }

        public function newsletters($type='',$lang=''){
            $stmt   = $this->db->select()->from("newsletters")->where("type","=",$type,"&&");
            $stmt->where("lang","=",$lang);
            return $stmt->build() ? $stmt->fetch_assoc() : [];
        }

        public function get_product_special_groups($lang=''){
            if(!$lang) $lang = Config::get("general/local");
            $stmt = $this->db->select("c.id,cl.title")->from("categories AS c");
            $stmt->join("LEFT","categories_lang AS cl","cl.owner_id=c.id AND cl.lang='".$lang."'");
            $stmt->where("cl.id","IS NOT NULL","","&&");
            $stmt->where("c.status","=","active","&&");
            $stmt->where("c.parent","=","0","&&");
            $stmt->where("c.type","=","products","&&");
            $stmt->where("c.kind","=","special");
            $stmt->order_by("c.id DESC");
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function get_software_categories(){
            $ll_lang    = Config::get("general/local");
            #$sd_lang    = Bootstrap::$lang->clang;
            $stmt = $this->db->select("c.id,cl.title")->from("categories AS c");
            $stmt->join("LEFT","categories_lang AS cl","cl.owner_id=c.id AND (cl.lang='".$ll_lang."')");
            $stmt->where("cl.id","IS NOT NULL","","&&");
            $stmt->where("c.parent","=","0","&&");
            $stmt->where("c.type","=","software");
            $stmt->order_by("c.id DESC");
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function get_product_group_categories($kind='',$parent=0,$line='-'){
            $ll_lang    = Config::get("general/local");
            //$sd_lang    = Bootstrap::$lang->clang;
            $stmt = $this->db->select("c.id,cl.title,c.parent")->from("categories AS c");
            $stmt->join("LEFT","categories_lang AS cl","cl.owner_id=c.id AND (cl.lang='".$ll_lang."')");
            $stmt->where("cl.id","IS NOT NULL","","&&");
            $stmt->where("c.parent","=",$parent,"&&");
            $stmt->where("c.kind","=",$kind,"&&");
            $stmt->where("c.type","=","products");
            $stmt->order_by("c.rank ASC");
            $result     = $stmt->build() ? $stmt->fetch_assoc() : [];
            $new_result = [];
            if($result){
                foreach($result AS $res){
                    $new    = $res;
                    $new["title"] = $line." ".$res["title"];
                    $new_result[] = $new;
                    $sub_result = $this->get_product_group_categories($kind,$res["id"],$line."-");
                    if($sub_result){
                        $new_result = array_merge($new_result,$sub_result);
                    }
                }
            }

            return $new_result;
        }

        public function get_tlds(){
            $stmt   = $this->db->select("id,name")->from("tldlist");
            $stmt->order_by("id DESC");
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function get_category_products($type='',$category=0){
            $ll_lang    = Config::get("general/local");
            //$sd_lang    = Bootstrap::$lang->clang;
            if($type == "software"){
                $stmt   = $this->db->select("t1.id,t2.title")->from("pages AS t1");
                $stmt->join("LEFT","pages_lang AS t2","t2.owner_id=t1.id AND (t2.lang='".$ll_lang."')");
                $stmt->where("t2.id","IS NOT NULL","","&&");
                $stmt->where("t1.type","=","software","&&");
                $stmt->where("(");
                $stmt->where("t1.category","=",$category,"||");
                $stmt->where("FIND_IN_SET(".$category.",t1.categories)");
                $stmt->where(")");
                $stmt->order_by("rank ASC");
                return $stmt->build() ? $stmt->fetch_assoc() : false;
            }else{
                $stmt   = $this->db->select("t1.id,t2.title")->from("products AS t1");
                $stmt->join("LEFT","products_lang AS t2","t2.owner_id=t1.id AND (t2.lang='".$ll_lang."')");
                $stmt->where("t2.id","IS NOT NULL","","&&");
                $stmt->where("t1.category","=",$category,"&&");
                $stmt->where("t1.type","=",$type);
                $stmt->order_by("rank ASC");
                return $stmt->build() ? $stmt->fetch_assoc() : false;
            }
        }

        public function user_groups(){
            $select = implode(",",[
                '*',
                '(SELECT COUNT(id) FROM '.$this->pfx.'users WHERE group_id=t1.id AND status=\'active\') AS user_count'
            ]);
            return $this->db->select($select)->from("users_groups AS t1")->build() ? $this->db->fetch_assoc() : false;
        }

        public function departments(){
            $lang   = Config::get("general/local");
            $select = implode(",",[
                't1.*',
                't2.name',
                '(SELECT COUNT(id) FROM '.$this->pfx.'users WHERE FIND_IN_SET(id,t1.appointees) AND status=\'active\') AS user_count'
            ]);
            $stmt = $this->db->select($select)->from("tickets_departments AS t1");
            $stmt->join("LEFT","tickets_departments_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $stmt->order_by("t1.rank ASC");
            return $stmt->build() ? $this->db->fetch_assoc() : false;
        }

        public function get_btk_reports_list($searches='',$orders=[],$start=0,$end=1){
            $select     = [
                't1.id',
                't1.type',
                't1.name',
                't1.options',
                't1.cdate',
                't1.duedate',
                't2.full_name AS user_name',
                '(SELECT content FROM '.$this->pfx.'users_informations WHERE name="company_name" AND owner_id=t2.id) AS user_company_name',
                't2.id AS user_id',
            ];
            $select     = implode(",",$select);
            $stmt       = $this->db->select($select)->from("users_products AS t1");
            $stmt->join("LEFT","users AS t2","t2.id=t1.owner_id");

            $stmt->where("(");
            $stmt->where("t1.type","=","domain","||");
            $stmt->where("t1.type","=","hosting");
            $stmt->where(")","","","&&");

            if($searches){
                if(isset($searches["start"]) && isset($searches["end"]))
                    $stmt
                        ->where("(")
                        ->where("t1.cdate","LIKE","%".$searches["start"]."%","||")
                        ->where("(t1.cdate BETWEEN '".$searches["start"]."' AND '".$searches["end"]."')","","","||")
                        ->where("t1.cdate","LIKE","%".$searches["end"]."%")
                        ->where(")","","","&&");
            }
            $stmt->where("t1.status","!=","cancelled");
            $stmt->order_by("t1.cdate DESC");
            $data  = $stmt->build() ? $stmt->fetch_assoc() : false;
            if($data){
                $new_data   = [];
                $domains    = [];
                $hosting    = [];
                foreach($data AS $datum){
                    if($datum["type"] == "domain")
                        $domains[$datum["name"]] = $datum;
                    elseif($datum["type"] == "hosting"){
                        $opt    = Utility::jdecode($datum["options"],true);
                        $hosting[$opt["domain"]] = $datum;
                    }
                }

                if($domains){
                    foreach($domains AS $domain=>$datum){
                        if(isset($hosting[$domain])){
                            $datum["desc_type"] = "domain-hosting";
                            unset($hosting[$domain]);
                        }else
                            $datum["desc_type"] = "only-domain";

                        if(($searches["type"] == 2 && $datum["desc_type"] == "only-domain") || ($searches["type"] == 1 && $datum["desc_type"] == "domain-hosting")) $new_data[] = $datum;
                    }
                }

                if($hosting){
                    foreach($hosting AS $domain=>$datum){
                        $datum["desc_type"] = "only-hosting";
                        if($searches["type"] == 1 && ($datum["desc_type"] == "domain-hosting" || $datum["desc_type"] == "only-hosting")) $new_data[] = $datum;
                    }
                }

                $size   = sizeof($new_data);
                $start  = $start > $size ? 0 : $start;
                $end    = $end>$size ? $size : $end;

                $new_data   = array_slice($new_data,$start,$end);
                $data = $new_data;
            }
            return $data;
        }
        public function get_btk_reports_list_total($searches=''){
            $select     = [
                't1.type',
                't1.name',
                't1.options',
            ];
            $select     = implode(",",$select);
            $stmt       = $this->db->select($select)->from("users_products AS t1");
            $stmt->join("LEFT","users AS t2","t2.id=t1.owner_id");
            $stmt->where("t2.id","IS NOT NULL","","&&");

            $stmt->where("(");
            $stmt->where("t1.type","=","domain","||");
            $stmt->where("t1.type","=","hosting");
            $stmt->where(")","","","&&");

            if($searches){
                if(isset($searches["start"]) && isset($searches["end"]))
                    $stmt
                        ->where("(")
                        ->where("t1.cdate","LIKE","%".$searches["start"]."%","||")
                        ->where("(t1.cdate BETWEEN '".$searches["start"]."' AND '".$searches["end"]."')","","","||")
                        ->where("t1.cdate","LIKE","%".$searches["end"]."%")
                        ->where(")","","","&&");
            }
            $stmt->where("t1.status","!=","cancelled");
            $stmt->order_by("t1.cdate DESC");
            $data  = $stmt->build() ? $stmt->fetch_assoc() : false;
            if($data){
                $new_data   = [];
                $domains    = [];
                $hosting    = [];
                foreach($data AS $datum){
                    if($datum["type"] == "domain")
                        $domains[$datum["name"]] = $datum;
                    elseif($datum["type"] == "hosting"){
                        $opt    = Utility::jdecode($datum["options"],true);
                        $hosting[$opt["domain"]] = $datum;
                    }
                }

                if($domains){
                    foreach($domains AS $domain=>$datum){
                        if(isset($hosting[$domain])){
                            $datum["desc_type"] = "domain-hosting";
                            unset($hosting[$domain]);
                        }else
                            $datum["desc_type"] = "only-domain";

                        if(($searches["type"] == 2 && $datum["desc_type"] == "only-domain") || ($searches["type"] == 1 && $datum["desc_type"] == "domain-hosting")) $new_data[] = $datum;
                    }
                }

                if($hosting){
                    foreach($hosting AS $domain=>$datum){
                        $datum["desc_type"] = "only-hosting";
                        if($searches["type"] == 1 && ($datum["desc_type"] == "domain-hosting" || $datum["desc_type"] == "only-hosting")) $new_data[] = $datum;
                    }
                }

                $data = sizeof($new_data);
            }
            return $data ? $data : 0;
        }

        public function get_tasks($searches='',$orders=[],$start=0,$end=1){
            $local_l    = Config::get("general/local");
            $case = "CASE ";
            $case .= "WHEN t1.status = 'waiting' THEN 1 ";
            $case .= "WHEN t1.status = 'inprocess' THEN 2 ";
            $case .= "WHEN t1.status = 'postponed' THEN 3 ";
            $case .= "WHEN t1.status = 'completed' THEN 4 ";
            $case .= "ELSE 5 ";
            $case .= "END AS rank";
            $select     = [
                't1.*',
                't2.full_name AS user_name',
                't2.company_name AS user_company_name',
                't3.full_name AS admin_name',
                $case,
            ];
            $select     = implode(",",$select);
            $stmt       = $this->db->select($select)->from("users_tasks AS t1");
            $stmt->join("LEFT","users AS t2","t2.id=t1.user_id");
            $stmt->join("LEFT","users AS t3","t3.id=t1.admin_id");

            if($searches){
                if(isset($searches["word"]) && $searches["word"]){
                    $stmt->where("(");
                    $stmt->where("t1.title","LIKE","%".$searches["word"]."%","||");
                    $stmt->where("t1.description","LIKE","%".$searches["word"]."%","");
                    $stmt->where(")","","","&&");
                }

                if(isset($searches["is_full_admin"]) && $searches["is_full_admin"]){
                    $stmt->where("t1.owner_id","!=","0");
                }else{
                    $stmt->where("(");
                    if(isset($searches["my_departments"]) && $searches["my_departments"])
                        $stmt->where("FIND_IN_SET('".implode(",",$searches["my_departments"])."',t1.departments)","","","||");
                    $stmt->where("t1.owner_id","=",$searches["owner_id"],"||");
                    $stmt->where("t1.admin_id","=",$searches["owner_id"],"");
                    $stmt->where(")");
                }

            }

            $stmt->order_by("rank ASC,t1.id DESC");
            $stmt->limit($start,$end);
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }
        public function get_tasks_total($searches='',$nosearch=false){
            $select     = "COUNT(t1.id) AS total";
            $stmt       = $this->db->select($select)->from("users_tasks AS t1");

            if($searches){
                if(!$nosearch && isset($searches["word"]) && $searches["word"]){
                    $stmt->where("(");
                    $stmt->where("t1.title","LIKE","%".$searches["word"]."%","||");
                    $stmt->where("t1.description","LIKE","%".$searches["word"]."%","");
                    $stmt->where(")","","","&&");
                }

                if(isset($searches["is_full_admin"]) && $searches["is_full_admin"]){
                    $stmt->where("t1.owner_id","!=","0");
                }else{
                    $stmt->where("(");
                    if(isset($searches["my_departments"]) && $searches["my_departments"])
                        $stmt->where("FIND_IN_SET('".implode(",",$searches["my_departments"])."',t1.departments)","","","||");
                    $stmt->where("t1.owner_id","=",$searches["owner_id"],"||");
                    $stmt->where("t1.admin_id","=",$searches["owner_id"],"");
                    $stmt->where(")");
                }

            }

            return $stmt->build() ? $stmt->getObject()->total : 0;
        }

        public function get_reminders($searches='',$orders=[],$start=0,$end=1){
            $local_l    = Config::get("general/local");
            $case = "CASE ";
            $case .= "WHEN status = 'active' THEN 1 ";
            $case .= "WHEN status = 'inactive' THEN 2 ";
            $case .= "ELSE 3 ";
            $case .= "END AS rank";
            $select     = [
                '*',
                $case,
            ];
            $select     = implode(",",$select);
            $stmt       = $this->db->select($select)->from("users_reminders");

            if($searches){
                if(isset($searches["word"]) && $searches["word"])
                    $stmt->where("note","LIKE","%".$searches["word"]."%","&&");
                $stmt->where("owner_id","=",$searches["owner_id"]);
            }

            $stmt->order_by("rank ASC,id DESC");
            $stmt->limit($start,$end);
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function get_reminders_total($searches='',$nosearch=false){
            $select     = "COUNT(id) AS total";
            $stmt       = $this->db->select($select)->from("users_reminders");

            if($searches){
                if(!$nosearch && isset($searches["word"]) && $searches["word"])
                    $stmt->where("note","LIKE","%".$searches["word"]."%","&&");
                $stmt->where("owner_id","=",$searches["owner_id"]);
            }

            return $stmt->build() ? $stmt->getObject()->total : 0;
        }

        public function get_sms_logs($searches='',$orders=[],$start=0,$end=1){
            $local_l    = Config::get("general/local");
            $stmt       = $this->db->select()->from("sms_logs");

            if($searches){
                if(isset($searches["word"]) && $searches["word"]){
                   $stmt->where("(");
                    $stmt->where("content","LIKE","%".$searches["word"]."%","||");
                    $stmt->where("numbers","LIKE","%".str_replace("+",'',$searches["word"])."%");
                   $stmt->where(")","","","&&");
                }
            }

            $stmt->where("private","=","0");

            $stmt->order_by("id DESC");
            $stmt->limit($start,$end);
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }
        public function get_sms_logs_total($searches='',$nosearch=false){
            $stmt       = $this->db->select("id")->from("sms_logs");
            if(!$nosearch && $searches){
                if(isset($searches["word"]) && $searches["word"]){
                    $stmt->where("(");
                    $stmt->where("content","LIKE","%".$searches["word"]."%","||");
                    $stmt->where("numbers","LIKE","%".str_replace("+",'',$searches["word"])."%");
                    $stmt->where(")","","","&&");
                }
            }

            $stmt->where("private","=","0");
            return $stmt->build() ? $stmt->rowCounter() : 0;
        }

        public function get_mail_logs($searches='',$orders=[],$start=0,$end=1){
            $local_l    = Config::get("general/local");
            $stmt       = $this->db->select()->from("mail_logs");

            if($searches){
                if(isset($searches["word"]) && $searches["word"]){
                    $stmt->where("(");
                    $stmt->where("content","LIKE","%".$searches["word"]."%","||");
                    $stmt->where("addresses","LIKE","%".$searches["word"]."%");
                    $stmt->where(")","","","&&");
                }
            }

            $stmt->where("private","=","0");

            $stmt->order_by("id DESC");
            $stmt->limit($start,$end);
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }
        public function get_mail_logs_total($searches='',$nosearch=false){
            $stmt       = $this->db->select("id")->from("mail_logs");
            if(!$nosearch && $searches){
                if(isset($searches["word"]) && $searches["word"]){
                    $stmt->where("(");
                    $stmt->where("content","LIKE","%".$searches["word"]."%","||");
                    $stmt->where("addresses","LIKE","%".$searches["word"]."%");
                    $stmt->where(")","","","&&");
                }
            }

            $stmt->where("private","=","0");
            return $stmt->build() ? $stmt->rowCounter() : 0;
        }

        public function get_actions($reason='',$searches=[],$orders=[],$start=0,$end=1){
            if($reason == 'error-log'){
                $word           = NULL;
                if($searches) if(isset($searches["word"])) $word = $searches["word"];

                $files      = array_merge(FileManager::glob(LOG_DIR."system".DS."*.log"),FileManager::glob(LOG_DIR."database".DS."*.log"));
                $result     = [];
                if($files){
                    foreach($files AS $file){
                        $file_date      = filemtime($file);
                        $content        = FileManager::file_read($file);
                        $rows           = $content ? Utility::jdecode($content,true) : [];
                        if($rows){
                            foreach($rows AS $row){

                                if(!isset($row['date'])){
                                    $row['date_unix'] = $file_date;
                                    $row['date']      = DateManager::timetostr('Y-m-d H:i:s',$file_date);
                                }
                                else
                                    $row['date_unix'] = DateManager::strtotime($row['date']);
                                $row['_type'] = stristr($file,'database') ? 'Database' : 'Software';

                                $r_str = '';
                                foreach(array_keys($row) AS $r_k) if(is_string($row[$r_k])) $r_str .= ' '.$row[$r_k];
                                $this->error_log_total += 1;
                                if(!$word || ($word && stristr($r_str,$word))){
                                    $this->error_log_filtered_total += 1;
                                    $result[] = $row;
                                }
                            }
                        }
                    }
                }
                if($result){
                    Utility::sksort($result,'date_unix');
                    $result     = array_slice($result,$start,$end);

                    return $result;
                }
            }
            elseif($reason == 'login-log')
            {
                $_type = $searches["type"] == "client" ? "member" : "admin";
                $sth = $this->db->select("l.*,u.full_name,u.company_name,u.id AS user_id")->from("users_last_logins AS l");
                $sth->join("LEFT","users AS u","u.id=l.owner_id");

                if(isset($searches["word"]) && $searches["word"]){

                    $word       = trim($searches["word"]);
                    $number     = Filter::numbers($word);

                    $sth->where("(");

                    if($number) $sth->where("u.id","=",$number,"||");

                    $sth->where("l.user_agent","LIKE","%".$word."%","||");
                    $sth->where("l.ip","LIKE","%".$word."%","||");
                    $sth->where("l.city","LIKE","%".$word."%","||");

                    $sth->where("u.full_name","LIKE","%".$word."%","||");
                    $sth->where("u.email","LIKE","%".$word."%","||");

                    if($number && strlen($number)>=5) $sth->where("u.phone","LIKE","%".$number."%","||");

                    $sth->where("u.company_name","LIKE","%".$word."%","");
                    $sth->where(")","","","&&");
                }
                $sth->where("u.type","=",$_type);

                $sth->order_by("l.id DESC");
                $sth->limit($start,$end);
                return $sth->build() ? $sth->fetch_assoc() : [];
            }
            else{
                $format_convert = str_replace(['d','m','Y',],['%d','%m','%Y'],Config::get("options/date-format"));
                $sth = $this->db->select("t1.*,DATE_FORMAT(t1.ctime,'".$format_convert." %H:%i') AS date")->from("users_actions AS t1");
                if($searches){
                    if(isset($searches["word"])){
                        $word       = $searches["word"];
                        $date       = DateManager::datetime_format_ifin($word);
                        $sth->where("(");
                        $sth->where("t1.reason","LIKE","%".$word."%","||");
                        $sth->where("t1.data","LIKE","%".$word."%","||");
                        $sth->where("t1.detail","LIKE","%".$word."%","||");
                        $sth->where("t1.locale_detail","LIKE","%".$word."%","||");
                        $sth->where("t1.ip","LIKE","%".$word."%","||");
                        $sth->where("t1.ctime","LIKE","%".$date."%","");

                        $sth->where(")","","","&&");
                    }
                }
                $sth->where("t1.reason","=",$reason);


                $sth->order_by("t1.id DESC");
                $sth->limit($start,$end);
                return $sth->build() ? $sth->fetch_assoc() : false;
            }
        }

        public function get_actions_total($reason='',$searches=[]){
           if($reason == 'error-log'){
               return $searches ? $this->error_log_filtered_total : $this->error_log_total;
           }
           elseif($reason == 'login-log')
           {
               $_type = $searches["type"] == "client" ? "member" : "admin";
               $sth = $this->db->select("l.id")->from("users_last_logins AS l");
               $sth->join("LEFT","users AS u","u.id=l.owner_id");

               if(isset($searches["word"]) && $searches["word"]){

                   $word       = trim($searches["word"]);
                   $number     = Filter::numbers($word);

                   $sth->where("(");

                   if($number) $sth->where("u.id","=",$number,"||");

                   $sth->where("l.user_agent","LIKE","%".$word."%","||");
                   $sth->where("l.ip","LIKE","%".$word."%","||");
                   $sth->where("l.city","LIKE","%".$word."%","||");

                   $sth->where("u.full_name","LIKE","%".$word."%","||");
                   $sth->where("u.email","LIKE","%".$word."%","||");

                   if($number && strlen($number)>=5) $sth->where("u.phone","LIKE","%".$number."%","||");
                   $sth->where("u.company_name","LIKE","%".$word."%","");
                   $sth->where(")","","","&&");

               }
               $sth->where("u.type","=",$_type);
               return $sth->build() ? $sth->rowCounter() : 0;
           }
           else
           {
               $sth = $this->db->select("t1.id")->from("users_actions AS t1");
               if($searches){
                   if(isset($searches["word"])){
                       $word       = $searches["word"];
                       $date       = DateManager::datetime_format_ifin($word);
                       $sth->where("(");
                       $sth->where("t1.reason","LIKE","%".$word."%","||");
                       $sth->where("t1.data","LIKE","%".$word."%","||");
                       $sth->where("t1.detail","LIKE","%".$word."%","||");
                       $sth->where("t1.locale_detail","LIKE","%".$word."%","||");
                       $sth->where("t1.ip","LIKE","%".$word."%","||");
                       $sth->where("t1.ctime","LIKE","%".$date."%","");

                       $sth->where(")","","","&&");
                   }
               }
               $sth->where("t1.reason","=",$reason);
               return $sth->build() ? $sth->rowCounter() : 0;
           }
        }

    }