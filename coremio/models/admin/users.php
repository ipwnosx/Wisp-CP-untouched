<?php
    defined('CORE_FOLDER') OR exit('You can not get in here!');
    class Model extends Models
    {
        function __construct()
        {
            parent::__construct();
        }

        public function delete($id=0){ 
            return User::delete($id);
        }

        public function get_messages($id=0,$searches=[],$orders=[],$start=0,$end=1){
            $format_convert = str_replace(['d','m','Y',],['%d','%m','%Y'],Config::get("options/date-format"));
            $sth = $this->db->select("id,subject,content,DATE_FORMAT(ctime,'".$format_convert." %H:%i') AS date")->from("mail_logs");
            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $date       = DateManager::datetime_format_ifin($word);
                    $sth->where("(");
                    $sth->where("subject","LIKE","%".$word."%","||");
                    $sth->where("content","LIKE","%".$word."%","||");
                    $sth->where("ctime","LIKE","%".$date."%");
                    $sth->where(")","","","&&");
                }
            }
            $sth->where("user_id","=",$id);
            $sth->order_by("id DESC");
            $sth->limit($start,$end);
            return $sth->build() ? $sth->fetch_assoc() : false;
        }

        public function get_messages_total($id=0,$searches=[]){
            $sth = $this->db->select("COUNT(id) AS total")->from("mail_logs");
            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $date       = DateManager::datetime_format_ifin($word);
                    $sth->where("(");
                    $sth->where("subject","LIKE","%".$word."%","||");
                    $sth->where("content","LIKE","%".$word."%","||");
                    $sth->where("ctime","LIKE","%".$date."%");
                    $sth->where(")","","","&&");
                }
            }
            $sth->where("user_id","=",$id);
            return $sth->build() ? $sth->getObject()->total : false;
        }

        public function get_actions($id=0,$searches=[],$orders=[],$start=0,$end=1){
            $format_convert = str_replace(['d','m','Y',],['%d','%m','%Y'],Config::get("options/date-format"));
            $sth = $this->db->select("t1.id,t1.owner_id,t1.data,t1.detail,locale_detail,t1.ip,DATE_FORMAT(t1.ctime,'".$format_convert." %H:%i') AS date,t2.full_name AS user_name,t2.type AS user_type")->from("users_actions AS t1");
            $sth->join("LEFT","users AS t2","t1.owner_id!=0 AND t1.owner_id=t2.id");
            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $date       = DateManager::datetime_format_ifin($word);
                    $sth->where("(");
                    $sth->where("t1.detail","LIKE","%".$word."%","||");
                    $sth->where("t1.locale_detail","LIKE","%".$word."%","||");
                    $sth->where("t1.ip","LIKE","%".$word."%","||");
                    $sth->where("t1.ctime","LIKE","%".$date."%","||");


                    $sth->where("(");
                    $sth->where("t2.full_name","LIKE","%".$word."%","||");
                    $sth->where("t2.email","LIKE","%".$word."%");
                    $sth->where(")","","");

                    $sth->where(")","","","&&");
                }
            }

            $sth->where("t1.reason","!=","module-log","&&");

            if($id)
                $sth->where("t1.owner_id","=",$id);
            else
                $sth->where("t1.detail","!=",'');


            $sth->order_by("t1.id DESC");
            $sth->limit($start,$end);
            return $sth->build() ? $sth->fetch_assoc() : false;
        }

        public function get_actions_total($id=0,$searches=[]){
            $sth = $this->db->select("t1.id")->from("users_actions AS t1");
            $sth->join("LEFT","users AS t2","t1.owner_id!=0 AND t1.owner_id=t2.id");
            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $date       = DateManager::datetime_format_ifin($word);
                    $sth->where("(");
                    $sth->where("t1.detail","LIKE","%".$word."%","||");
                    $sth->where("t1.locale_detail","LIKE","%".$word."%","||");
                    $sth->where("t1.ip","LIKE","%".$word."%","||");
                    $sth->where("t1.ctime","LIKE","%".$date."%","||");


                    $sth->where("(");
                    $sth->where("t2.full_name","LIKE","%".$word."%","||");
                    $sth->where("t2.email","LIKE","%".$word."%");
                    $sth->where(")","","");

                    $sth->where(")","","","&&");
                }
            }

            $sth->where("t1.reason","!=","module-log","&&");

            if($id)
                $sth->where("t1.owner_id","=",$id);
            else
                $sth->where("t1.detail","!=",'');

            return $sth->build() ? $sth->rowCounter() : 0;
        }

        public function get_invoices($status='',$id=0){
            $now    = DateManager::Now();
            $stmt   = $this->db->select('id,DATEDIFF(duedate,\''.$now.'\') AS remaining_day')->from("invoices");
            $stmt->where("user_id","=",$id,$status ? "&&" : '');
            if($status) $stmt->where("status","=",$status);
            $stmt->order_by("id DESC");
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function get_credit($id=0){
            $stmt   = $this->db->select()->from("users_credit_logs");
            $stmt->where("id","=",$id);
            return $stmt->build() ? $stmt->getAssoc() : false;
        }
        public function get_credits($uid=0){
            $stmt   = $this->db->select()->from("users_credit_logs");
            $stmt->where("user_id","=",$uid);
            $stmt->order_by("id DESC");
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function insert_credit($data=[]){
            return $this->db->insert("users_credit_logs",$data) ? $this->db->lastID() : false;
        }

        public function set_credit($id=0,$data=[]){
            return $this->db->update("users_credit_logs",$data)->where("id","=",$id)->save();
        }

        public function delete_credit($id=0){
            return $this->db->delete("users_credit_logs")->where("id","=",$id)->run();
        }

        public function get_invoice_statistics($uid=0){
            $localc = Config::get("general/currency");
            $result = [];


            $paid   = $this->db->select("SUM(total) AS tt,COUNT(id) AS qt,currency")->from("invoices");
            $paid->where("user_id","=",$uid,"&&");
            $paid->where("status","=","paid","&&");
            $paid->where("pmethod","!=","Balance");
            $paid->group_by("currency");
            $paid   = $paid->build() ? $paid->fetch_assoc() : false;
            if($paid){
                foreach($paid AS $row){
                    $exch   = Money::exChange($row["tt"],$row["currency"],$localc);
                    if(isset($result["paid"])){
                        $result["paid"]["amount"] += $exch;
                        $result["paid"]["quantity"] += $row["qt"];
                    }else{
                        $result["paid"]["amount"] = $exch;
                        $result["paid"]["quantity"] = $row["qt"];
                    }
                }
            }else{
                $result["paid"]["amount"] = 0;
                $result["paid"]["quantity"] = 0;
            }

            $unpaid   = $this->db->select("SUM(total) AS tt,COUNT(id) AS qt,currency")->from("invoices");
            $unpaid->where("user_id","=",$uid,"&&");
            $unpaid->where("pmethod","!=","Balance","&&");
            $unpaid->where("status","=","unpaid");
            $unpaid->group_by("currency");
            $unpaid   = $unpaid->build() ? $unpaid->fetch_assoc() : false;
            if($unpaid){
                foreach($unpaid AS $row){
                    $exch   = Money::exChange($row["tt"],$row["currency"],$localc);
                    if(isset($result["unpaid"])){
                        $result["unpaid"]["amount"] += $exch;
                        $result["unpaid"]["quantity"] += $row["qt"];
                    }else{
                        $result["unpaid"]["amount"] = $exch;
                        $result["unpaid"]["quantity"] = $row["qt"];
                    }
                }
            }
            else{
                $result["unpaid"]["amount"] = 0;
                $result["unpaid"]["quantity"] = 0;
            }

            $refund   = $this->db->select("SUM(total) AS tt,COUNT(id) AS qt,currency")->from("invoices");
            $refund->where("user_id","=",$uid,"&&");
            $refund->where("pmethod","!=","Balance","&&");
            $refund->where("status","=","refund");
            $refund->group_by("currency");
            $refund   = $refund->build() ? $refund->fetch_assoc() : false;
            if($refund){
                foreach($refund AS $row){
                    $exch   = Money::exChange($row["tt"],$row["currency"],$localc);
                    if(isset($result["refund"])){
                        $result["refund"]["amount"] += $exch;
                        $result["refund"]["quantity"] += $row["qt"];
                    }else{
                        $result["refund"]["amount"] = $exch;
                        $result["refund"]["quantity"] = $row["qt"];
                    }
                }
            }
            else{
                $result["refund"]["amount"] = 0;
                $result["refund"]["quantity"] = 0;
            }

            return $result;
        }

        public function get_order_statistics($uid=0,$type='',$type_id=0){
            $localc = Config::get("general/currency");
            $result = ['amount' => 0,'quantity' => 0];
            $stmt   = $this->db->select("SUM(amount) AS tt,COUNT(id) AS qt,amount_cid")->from("users_products");
            $stmt->where("owner_id","=",$uid,"&&");
            $stmt->where("status","!=","cancelled","&&");
            $stmt->where("status","!=","waiting","&&");
            if($type_id) $stmt->where("type_id","=",$type_id,"&&");
            $stmt->where("type","=",$type);
            $stmt->group_by("amount_cid");
            $stmt   = $stmt->build() ? $stmt->fetch_assoc() : false;
            if($stmt){
                foreach($stmt AS $row){
                    $exch   = Money::exChange($row["tt"],$row["amount_cid"],$localc);
                    $result["amount"] += $exch;
                    $result["quantity"] += $row["qt"];
                }
            }
            return $result;
        }

        public function get_login_logs($id=0){
            return $this->db->select()->from("users_last_logins")->where("owner_id","=",$id)->order_by("id DESC")->build() ? $this->db->fetch_assoc() : false;
        }

        public function get_custom_field($id=0){
            $stmt   = $this->db->select()->from("users_custom_fields");
            $stmt->where("status","=","active","&&");
            $stmt->where("id","=",$id);
            return $stmt->build() ? $stmt->getAssoc() : false;
        }

        public function totalAddress($uid=0){
            $sth      = $this->db->select("COUNT(id) AS count")->from("users_addresses");
            $sth->where("status","=","active","&&");
            $sth->where("owner_id","=",$uid);
            return ($sth->build()) ? $sth->getObject()->count : 0;
        }

        public function delete_address($id=0){
            return $this->db->delete("users_addresses")->where("id","=",$id)->run();
        }

        public function getAddresses($id=0){
            $sth = $this->db->select()->from("users_addresses");
            $sth->where("status","=","active","&&");
            $sth->where("owner_id","=",$id);
            $sth->order_by("detouse DESC");
            if(!$sth->build()) return false;
            return $sth->fetch_assoc();
        }

        public function getAddress($id=0){
            $sth = $this->db->select()->from("users_addresses");
            $sth->where("id","=",$id);
            return $sth->build() ? $sth->getAssoc() : false;
        }

        public function insert($data=[]){
            return $this->db->insert("users",$data) ? $this->db->lastID() : false;
        }

        public function set_address($id=0,$data=[]){
            return $this->db->update("users_addresses",$data)->where("id","=",$id)->save();
        }

        public function addNewAddress($data){
            if(sizeof($data)>0){
                $insert = $this->db->insert("users_addresses",$data);
                return ($insert) ? $this->db->lastID() : false;
            }
        }

        public function get_custom_fields($lang=''){
            $stmt   = $this->db->select()->from("users_custom_fields");
            $stmt->where("status","=","active","&&");
            $stmt->where("lang","=",$lang);
            $stmt->order_by("rank ASC");
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function set_group($id=0,$data=[]){
            return $this->db->update("users_groups",$data)->where("id","=",$id)->save();
        }

        public function insert_group($data=[]){
            return $this->db->insert("users_groups",$data) ? $this->db->lastID() : false;
        }

        public function delete_group($id=0){
            return $this->db->delete("users_groups")->where("id","=",$id)->run();
        }

        public function get_group($id=0){
            $stmt = $this->db->select()->from("users_groups")->where("id","=",$id);
            return $stmt->build() ? $stmt->getAssoc() : false;
        }

        public function groups(){
            return $this->db->select()->from("users_groups")->build() ? $this->db->fetch_assoc() : false;
        }

        public function get_blacklist($searches='',$orders=[],$start=0,$end=1){
            $lang   = Config::get("general/local");
            $select =  implode(",",[
                't1.id',
                't1.full_name',
                't1.email',
                't1.country',
                't1.currency',
                't1.ip',
                't1.status',
                't1.creation_time',
                't1.last_login_time',
                't1.phone',
                't1.blacklist',
                't1.company_name',
                '(SELECT a2_iso FROM '.$this->pfx.'countries WHERE id=t1.country) AS country_code',
                '(SELECT name FROM '.$this->pfx.'countries_lang WHERE owner_id=t1.country AND lang=\''.$lang.'\') AS country_name',
                '(SELECT code FROM '.$this->pfx.'currencies WHERE id=t1.currency) AS currency_code',
                '(SELECT name FROM '.$this->pfx.'users_groups WHERE id=t1.group_id) AS group_name',
            ]);
            $stmt   = $this->db->select($select)->from("users AS t1");

            if($searches){

                if(isset($searches["word"])){

                    $word       = trim($searches["word"]);
                    $number     = Filter::numbers($word);
                    $ip         = Filter::ip($word);
                    if($ip && !filter_var($ip, FILTER_VALIDATE_IP)) $ip = false;

                    $stmt->where("(");

                    if($number) $stmt->where("t1.id","=",$number,"||");

                    $stmt->where("t1.full_name","LIKE","%".$word."%","||");

                    if($ip) $stmt->where("t1.ip","=",$ip,"||");

                    $stmt->where("t1.email","LIKE","%".$word."%","||");

                    if($number && strlen($number)>=5) $stmt->where("t1.phone","LIKE","%".$number."%","||");

                    $stmt->where("(SELECT a2_iso FROM ".$this->pfx."countries WHERE id=t1.country)","=",$word,"||");
                    $stmt->where("(SELECT name FROM ".$this->pfx."countries_lang WHERE owner_id=t1.country AND lang='".$lang."')","LIKE","%".$word."%","||");
                    $stmt->where("(SELECT code FROM ".$this->pfx."currencies WHERE id=t1.currency)","=",$word,"||");
                    $stmt->where("(SELECT name FROM ".$this->pfx."users_groups WHERE id=t1.group_id)","LIKE","%".$word."%","||");


                    $stmt->where("t1.company_name","LIKE","%".$word."%","");

                    $stmt->where(")","","","&&");
                }

                if(isset($searches["group_id"])) $stmt->where("t1.group_id","=",$searches["group_id"],"&&");
            }

            $stmt->where("t1.blacklist","!=","0","&&");
            $stmt->where("t1.type","=","member");
            $stmt->order_by("t1.id DESC");
            $stmt->limit($start,$end);
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function get_blacklist_total($searches=[]){
            $lang   = Config::get("general/local");
            $select =  "t1.id";
            $stmt   = $this->db->select($select)->from("users AS t1");

            if($searches){

                if(isset($searches["word"])){

                    $word       = trim($searches["word"]);
                    $number     = Filter::numbers($word);
                    $ip         = Filter::ip($word);
                    if($ip && !filter_var($ip, FILTER_VALIDATE_IP)) $ip = false;

                    $stmt->where("(");

                    if($number) $stmt->where("t1.id","=",$number,"||");

                    $stmt->where("t1.full_name","LIKE","%".$word."%","||");

                    if($ip) $stmt->where("t1.ip","=",$ip,"||");

                    $stmt->where("t1.email","LIKE","%".$word."%","||");

                    if($number && strlen($number)>=5) $stmt->where("t1.phone","LIKE","%".$number."%","||");

                    $stmt->where("(SELECT a2_iso FROM ".$this->pfx."countries WHERE id=t1.country)","=",$word,"||");
                    $stmt->where("(SELECT name FROM ".$this->pfx."countries_lang WHERE owner_id=t1.country AND lang='".$lang."')","LIKE","%".$word."%","||");
                    $stmt->where("(SELECT code FROM ".$this->pfx."currencies WHERE id=t1.currency)","=",$word,"||");
                    $stmt->where("(SELECT name FROM ".$this->pfx."users_groups WHERE id=t1.group_id)","LIKE","%".$word."%","||");


                    $stmt->where("t1.company_name","LIKE","%".$word."%","");

                    $stmt->where(")","","","&&");
                }

                if(isset($searches["group_id"])) $stmt->where("t1.group_id","=",$searches["group_id"],"&&");
            }

            $stmt->where("t1.blacklist","!=","0","&&");
            $stmt->where("t1.type","=","member");

            $stmt->order_by("t1.id DESC");
            return $stmt->build() ? $stmt->rowCounter() : 0;
        }

        public function get_affiliates($searches='',$orders=[],$start=0,$end=1){
            $select =  implode(",",[
                'aff.id',
                't1.id AS user_id',
                't1.full_name',
                't1.company_name',
                'aff.balance',
                'aff.currency',
                'aff.date',
                '(SELECT COUNT(id) FROM '.$this->pfx.'users WHERE aff_id=aff.id) AS "references"',
                '(SELECT COUNT(id) FROM '.$this->pfx.'users_affiliate_hits WHERE affiliate_id=aff.id) AS "hits"',
                '(SELECT SUM(amount) FROM '.$this->pfx.'users_affiliate_withdrawals WHERE affiliate_id=aff.id AND status="completed") AS "withdrawals"',
            ]);
            $stmt   = $this->db->select($select)->from("users_affiliates AS aff");
            $stmt->join("LEFT","users AS t1","aff.owner_id=t1.id");

            if($searches){

                if(isset($searches["word"])){

                    $word       = trim($searches["word"]);
                    $number     = Filter::numbers($word);

                    $stmt->where("(");

                    if($number) $stmt->where("aff.id","=",$number,"||");
                    if($number) $stmt->where("t1.id","=",$number,"||");

                    $stmt->where("t1.full_name","LIKE","%".$word."%","||");
                    $stmt->where("t1.email","LIKE","%".$word."%","||");

                    if($number && strlen($number)>=5) $stmt->where("t1.phone","LIKE","%".$number."%","||");


                    $stmt->where("t1.company_name","LIKE","%".$word."%","");
                    $stmt->where(")","","","&&");
                }
            }
            $stmt->where("t1.id IS NOT NULL");

            $stmt->order_by("aff.date DESC");
            $stmt->limit($start,$end);
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function get_affiliates_total($searches=[]){
            $select =  "aff.id";
            $stmt   = $this->db->select($select)->from("users_affiliates AS aff");
            $stmt->join("LEFT","users AS t1","aff.owner_id=t1.id");

            if($searches){

                if(isset($searches["word"])){

                    $word       = trim($searches["word"]);
                    $number     = Filter::numbers($word);

                    $stmt->where("(");

                    if($number) $stmt->where("aff.id","=",$number,"||");
                    if($number) $stmt->where("t1.id","=",$number,"||");

                    $stmt->where("t1.full_name","LIKE","%".$word."%","||");
                    $stmt->where("t1.email","LIKE","%".$word."%","||");

                    if($number && strlen($number)>=5) $stmt->where("t1.phone","LIKE","%".$number."%","||");


                    $stmt->where("t1.company_name","LIKE","%".$word."%","");
                    $stmt->where(")","","","&&");
                }
            }
            $stmt->where("t1.id","IS NOT NULL");

            return $stmt->build() ? $stmt->rowCounter() : 0;
        }

        public function get_affiliate_withdrawals($searches='',$orders=[],$start=0,$end=1){
            $case = "CASE ";
            $case .= "WHEN wl.status = 'awaiting' THEN 0 ";
            $case .= "WHEN wl.status = 'process' THEN 1 ";
            $case .= "WHEN wl.status = 'completed' THEN 2 ";
            $case .= "ELSE 3 ";
            $case .= "END AS rank";

            $select =  implode(",",[
                'wl.*',
                't1.full_name',
                't1.company_name',
                't1.id AS "user_id"',
                $case,
            ]);
            $stmt   = $this->db->select($select)->from("users_affiliate_withdrawals AS wl");
            $stmt->join("LEFT","users_affiliates AS aff","wl.affiliate_id=aff.id");
            $stmt->join("LEFT","users AS t1","aff.owner_id=t1.id");

            if($searches){

                if(isset($searches['aff_id']) && $searches['aff_id'])
                    $stmt->where("wl.affiliate_id","=",$searches['aff_id'],"&&");

                if(isset($searches["word"])){

                    $word       = trim($searches["word"]);
                    $number     = Filter::numbers($word);

                    $stmt->where("(");

                    if($number) $stmt->where("aff.id","=",$number,"||");
                    if($number) $stmt->where("t1.id","=",$number,"||");
                    if($number) $stmt->where("wl.id","=",$number,"||");

                    $stmt->where("wl.gateway_info","LIKE","%".$word."%","||");

                    $stmt->where("t1.full_name","LIKE","%".$word."%","||");
                    $stmt->where("t1.email","LIKE","%".$word."%","||");

                    if($number && strlen($number)>=5) $stmt->where("t1.phone","LIKE","%".$number."%","||");


                    $stmt->where("t1.company_name","LIKE","%".$word."%","");
                    $stmt->where(")","","","&&");
                }
            }
            $stmt->where("t1.id IS NOT NULL");

            $stmt->group_by("wl.id");
            $stmt->order_by("rank ASC,wl.id DESC");
            $stmt->limit($start,$end);
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function get_affiliate_withdrawals_total($searches=[]){
            $select =  "wl.id";
            $stmt   = $this->db->select($select)->from("users_affiliate_withdrawals AS wl");
            $stmt->join("LEFT","users_affiliates AS aff","wl.affiliate_id=aff.id");
            $stmt->join("LEFT","users AS t1","aff.owner_id=t1.id");

            if($searches){

                if(isset($searches['aff_id']) && $searches['aff_id'])
                    $stmt->where("wl.affiliate_id","=",$searches['aff_id'],"&&");

                if(isset($searches["word"])){

                    $word       = trim($searches["word"]);
                    $number     = Filter::numbers($word);

                    $stmt->where("(");

                    if($number) $stmt->where("aff.id","=",$number,"||");
                    if($number) $stmt->where("t1.id","=",$number,"||");
                    if($number) $stmt->where("wl.id","=",$number,"||");

                    $stmt->where("wl.gateway_info","LIKE","%".$word."%","||");

                    $stmt->where("t1.full_name","LIKE","%".$word."%","||");
                    $stmt->where("t1.email","LIKE","%".$word."%","||");

                    if($number && strlen($number)>=5) $stmt->where("t1.phone","LIKE","%".$number."%","||");


                    $stmt->where("t1.company_name","LIKE","%".$word."%","");
                    $stmt->where(")","","","&&");
                }
            }
            $stmt->where("t1.id IS NOT NULL");

            $stmt->group_by("wl.id");
            return $stmt->build() ? $stmt->rowCounter() : 0;
        }

        public function get_dealerships($searches='',$orders=[],$start=0,$end=1){
            $select =  implode(",",[
                't1.id',
                't1.full_name',
                't1.status',
                't1.creation_time',
                't1.company_name',
                'uif.content AS d_info',
            ]);
            $stmt   = $this->db->select($select)->from("users_informations AS uif");
            $stmt->join("LEFT","users AS t1","t1.id=uif.owner_id");

            $stmt->where("uif.name","=","dealership","&&");
            $stmt->where("uif.content","LIKE",'%"status":"active"%',"&&");

            if($searches){

                if(isset($searches["word"])){

                    $word       = trim($searches["word"]);
                    $number     = Filter::numbers($word);
                    $ip         = Filter::ip($word);
                    if($ip && !filter_var($ip, FILTER_VALIDATE_IP)) $ip = false;

                    $stmt->where("(");

                    if($number) $stmt->where("t1.id","=",$number,"||");

                    $stmt->where("t1.full_name","LIKE","%".$word."%","||");

                    if($ip) $stmt->where("t1.ip","=",$ip,"||");

                    $stmt->where("t1.email","LIKE","%".$word."%","||");

                    if($number && strlen($number)>=5) $stmt->where("t1.phone","LIKE","%".$number."%","||");
                    $stmt->where("(SELECT name FROM ".$this->pfx."users_groups WHERE id=t1.group_id)","LIKE","%".$word."%","||");

                    $stmt->where("t1.company_name","LIKE","%".$word."%","");

                    $stmt->where(")","","","&&");
                }

                if(isset($searches["group_id"])) $stmt->where("t1.group_id","=",$searches["group_id"],"&&");
            }

            $stmt->where("t1.type","=","member");
            $stmt->group_by("t1.id");
            $stmt->order_by("t1.id DESC");
            $stmt->limit($start,$end);
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function get_dealerships_total($searches=[]){
            $select =  "t1.id";
            $stmt   = $this->db->select($select)->from("users_informations AS uif");
            $stmt->join("LEFT","users AS t1","t1.id=uif.owner_id");

            $stmt->where("uif.name","=","dealership","&&");
            $stmt->where("uif.content","LIKE",'%"status":"active"%',"&&");

            if($searches){

                if(isset($searches["word"])){

                    $word       = trim($searches["word"]);
                    $number     = Filter::numbers($word);
                    $ip         = Filter::ip($word);
                    if($ip && !filter_var($ip, FILTER_VALIDATE_IP)) $ip = false;

                    $stmt->where("(");

                    if($number) $stmt->where("t1.id","=",$number,"||");

                    $stmt->where("t1.full_name","LIKE","%".$word."%","||");

                    if($ip) $stmt->where("t1.ip","=",$ip,"||");

                    $stmt->where("t1.email","LIKE","%".$word."%","||");

                    if($number && strlen($number)>=5) $stmt->where("t1.phone","LIKE","%".$number."%","||");
                    $stmt->where("(SELECT name FROM ".$this->pfx."users_groups WHERE id=t1.group_id)","LIKE","%".$word."%","||");

                    $stmt->where("t1.company_name","LIKE","%".$word."%","");

                    $stmt->where(")","","","&&");
                }

                if(isset($searches["group_id"])) $stmt->where("t1.group_id","=",$searches["group_id"],"&&");
            }

            $stmt->where("t1.type","=","member");
            $stmt->group_by("t1.id");
            return $stmt->build() ? $stmt->rowCounter() : 0;
        }

        public function get_users($searches='',$orders=[],$start=0,$end=1){
            $lang   = Config::get("general/local");
            $select =  implode(",",[
                't1.id',
                't1.full_name',
                't1.email',
                't1.country',
                't1.currency',
                't1.ip',
                't1.status',
                't1.creation_time',
                't1.last_login_time',
                't1.phone',
                't1.company_name',
                '(SELECT a2_iso FROM '.$this->pfx.'countries WHERE id=t1.country LIMIT 1) AS country_code',
                '(SELECT name FROM '.$this->pfx.'countries_lang WHERE owner_id=t1.country AND lang=\''.$lang.'\' LIMIT 1) AS country_name',
                '(SELECT code FROM '.$this->pfx.'currencies WHERE id=t1.currency LIMIT 1) AS currency_code',
                '(SELECT name FROM '.$this->pfx.'users_groups WHERE id=t1.group_id LIMIT 1) AS group_name',
            ]);
            $stmt   = $this->db->select($select)->from("users AS t1");

            if($searches){

                if(isset($searches["word"])){

                    $word       = trim($searches["word"]);
                    $number     = Filter::numbers($word);
                    $ip         = Filter::ip($word);
                    if($ip && !filter_var($ip, FILTER_VALIDATE_IP)) $ip = false;

                    $stmt->where("(");

                    if($number) $stmt->where("t1.id","=",$number,"||");

                    $stmt->where("t1.full_name","LIKE","%".$word."%","||");

                    if($ip) $stmt->where("t1.ip","=",$ip,"||");

                    $stmt->where("t1.email","LIKE","%".$word."%","||");

                    if($number && strlen($number)>=5) $stmt->where("t1.phone","LIKE","%".$number."%","||");

                    $stmt->where("(SELECT a2_iso FROM ".$this->pfx."countries WHERE id=t1.country)","=",$word,"||");
                    $stmt->where("(SELECT name FROM ".$this->pfx."countries_lang WHERE owner_id=t1.country AND lang='".$lang."')","LIKE","%".$word."%","||");
                    $stmt->where("(SELECT code FROM ".$this->pfx."currencies WHERE id=t1.currency)","=",$word,"||");
                    $stmt->where("(SELECT name FROM ".$this->pfx."users_groups WHERE id=t1.group_id)","LIKE","%".$word."%","||");


                    $stmt->where("t1.company_name","LIKE","%".$word."%","");

                    $stmt->where(")","","","&&");
                }

                if(isset($searches["group_id"])) $stmt->where("t1.group_id","=",$searches["group_id"],"&&");
            }

            $stmt->where("t1.type","=","member");
            $stmt->order_by("t1.id DESC");
            $stmt->limit($start,$end);
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function get_users_total($searches=[]){
            $lang   = Config::get("general/local");
            $select =  "t1.id";
            $stmt   = $this->db->select($select)->from("users AS t1");

            if($searches){

                if(isset($searches["word"])){

                    $word       = trim($searches["word"]);
                    $number     = Filter::numbers($word);
                    $ip         = Filter::ip($word);
                    if($ip && !filter_var($ip, FILTER_VALIDATE_IP)) $ip = false;

                    $stmt->where("(");

                    if($number) $stmt->where("t1.id","=",$number,"||");

                    $stmt->where("t1.full_name","LIKE","%".$word."%","||");

                    if($ip) $stmt->where("t1.ip","=",$ip,"||");

                    $stmt->where("t1.email","LIKE","%".$word."%","||");

                    if($number && strlen($number)>=5) $stmt->where("t1.phone","LIKE","%".$number."%","||");

                    $stmt->where("(SELECT a2_iso FROM ".$this->pfx."countries WHERE id=t1.country)","=",$word,"||");
                    $stmt->where("(SELECT name FROM ".$this->pfx."countries_lang WHERE owner_id=t1.country AND lang='".$lang."')","LIKE","%".$word."%","||");
                    $stmt->where("(SELECT code FROM ".$this->pfx."currencies WHERE id=t1.currency)","=",$word,"||");
                    $stmt->where("(SELECT name FROM ".$this->pfx."users_groups WHERE id=t1.group_id)","LIKE","%".$word."%","||");


                    $stmt->where("t1.company_name","LIKE","%".$word."%","");

                    $stmt->where(")","","","&&");
                }

                if(isset($searches["group_id"])) $stmt->where("t1.group_id","=",$searches["group_id"],"&&");
            }

            $stmt->where("t1.type","=","member");

            $stmt->order_by("t1.id DESC");
            return $stmt->build() ? $stmt->rowCounter() : 0;
        }

        public function get_document_records($searches='',$orders=[],$start=0,$end=1000){
            $lang   = Config::get("general/local");

            $case = "CASE ";
            $case .= "WHEN t1.status = 'awaiting' THEN 0 ";
            $case .= "WHEN t1.status = 'verified' THEN 1 ";
            $case .= "ELSE 2 ";
            $case .= "END AS rank";

            $select = implode(',',[
                't1.*',
                'us.full_name AS user_full_name',
                'us.company_name AS user_company_name',
                'GROUP_CONCAT(t1.status) AS situations',
                $case
            ]);
            $stmt   = $this->db->select($select)->from("users_document_records AS t1");
            $stmt->join("LEFT","users AS us","us.id=t1.user_id");

            if($searches){
                if(isset($searches["word"])){

                    $word       = trim($searches["word"]);
                    $number     = Filter::numbers($word);

                    $stmt->where("(");

                    if($number) $stmt->where("us.id","=",$number,"||");

                    $stmt->where("field_name","LIKE","%".$word."%","||");
                    $stmt->where("field_value","LIKE","%".$word."%","||");
                    $stmt->where("us.full_name","LIKE","%".$word."%","||");
                    $stmt->where("us.company_name","LIKE","%".$word."%");

                    $stmt->where(")","","","&&");
                }
            }

            $stmt->where("us.id","IS NOT NULL");

            $stmt->group_by("t1.user_id");
            $stmt->order_by("rank ASC");
            $stmt->limit($start,$end);
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }
        public function get_document_records_total($searches=[]){
            $lang   = Config::get("general/local");
            $select =  "us.id";

            $stmt   = $this->db->select($select)->from("users_document_records AS t1");
            $stmt->join("LEFT","users AS us","us.id=t1.user_id");

            if($searches){
                if(isset($searches["word"])){

                    $word       = trim($searches["word"]);
                    $number     = Filter::numbers($word);

                    $stmt->where("(");

                    if($number) $stmt->where("us.id","=",$number,"||");

                    $stmt->where("field_name","LIKE","%".$word."%","||");
                    $stmt->where("field_value","LIKE","%".$word."%","||");
                    $stmt->where("us.full_name","LIKE","%".$word."%","||");
                    $stmt->where("us.company_name","LIKE","%".$word."%");

                    $stmt->where(")","","","&&");
                }
            }

            $stmt->where("us.id","IS NOT NULL");

            $stmt->group_by("t1.user_id");
            return $stmt->build() ? $stmt->rowCounter() : 0;
        }

        public function get_document_filters($searches='',$orders=[],$start=0,$end=1000){
            $lang   = Config::get("general/local");
            $select = '';
            $stmt   = $this->db->select($select)->from("users_document_filters");

            if($searches){

                if(isset($searches["word"])){

                    $word       = trim($searches["word"]);
                    $number     = Filter::numbers($word);

                    $stmt->where("(");

                    if($number) $stmt->where("id","=",$number,"||");

                    $stmt->where("name","LIKE","%".$word."%");

                    $stmt->where(")","","","");
                }
            }

            $stmt->order_by("id DESC");
            $stmt->limit($start,$end);
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }
        public function get_document_filters_total($searches=[]){
            $lang   = Config::get("general/local");
            $select =  "id";
            $stmt   = $this->db->select($select)->from("users_document_filters");

            if($searches){

                if(isset($searches["word"])){

                    $word       = trim($searches["word"]);
                    $number     = Filter::numbers($word);

                    $stmt->where("(");

                    if($number) $stmt->where("id","=",$number,"||");

                    $stmt->where("name","LIKE","%".$word."%");

                    $stmt->where(")","","","");
                }
            }

            $stmt->order_by("id DESC");
            return $stmt->build() ? $stmt->rowCounter() : 0;
        }

        public function add_document_filter($data=[]){
            $stmt   = $this->db->insert("users_document_filters",$data);
            return $stmt ? $this->db->lastID() : false;
        }

        public function edit_document_filter($id=0,$data=[]){
            return $this->db->update("users_document_filters",$data)->where("id","=",$id)->save();
        }

        public function delete_document_filter($id=0){
            return $this->db->delete("users_document_filters")->where("id","=",$id)->run();
        }

        public function get_document_filter($id=0){
            $data   = $this->db->select()->from("users_document_filters")->where("id","=",$id);
            $data   = $data->build() ? $data->getAssoc() : false;
            if($data){
                $data["rules"]  = Utility::jdecode($data["rules"],true);
                $data["fields"] = Utility::jdecode($data["fields"],true);
            }
            return $data;
        }

        public function document_records($id=0){
            $stmt   = $this->db->select()->from("users_document_records")->where("user_id","=",$id);
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function set_document_record($id=0,$data=[]){
            return $this->db->update("users_document_records",$data)->where("id","=",$id)->save();
        }

        public function get_affiliate_withdrawal($id=0){
            $data   = $this->db->select()->from("users_affiliate_withdrawals")->where("id","=",$id);
            $data   = $data->build() ? $data->getAssoc() : false;
            return $data;
        }
        public function set_affiliate_withdrawal($id=0,$data=[]){
            return $this->db->update("users_affiliate_withdrawals",$data)->where("id","=",$id)->save();
        }
        public function delete_affiliate_withdrawal($id=0){
            return $this->db->delete("users_affiliate_withdrawals")->where("id","=",$id)->run();
        }

        public function products($type='hosting',$cat_id=0)
        {
            if($type == 'domain')
            {
                $stmt       = $this->db->select("id,'0' AS category,'domain' AS type,name AS title")->from("tldlist");
                return $stmt->build() ? $stmt->fetch_assoc() : [];
            }
            else
            {
                $_type  = $type == 'software' ? "pages" : "products";
                $select = "t1.id,t1.category,t1.type,t2.title";
                if($_type == "products") $select .= ",t1.type_id";
                $lang   = Bootstrap::$lang->clang;
                $stmt   = $this->db->select($select)->from($_type." AS t1");
                $stmt->join("LEFT",$_type."_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
                if($cat_id) $stmt->where("t1.category","=",$cat_id,"&&");
                $stmt->where("t1.type","=",$type);
                $stmt->order_by("category ASC,id ASC");
                return $stmt->build() ? $stmt->fetch_assoc() : [];
            }
        }


    }