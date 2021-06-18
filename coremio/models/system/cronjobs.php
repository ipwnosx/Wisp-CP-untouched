<?php
    defined('CORE_FOLDER') OR exit('You can not get in here!');
    class Model extends Models
    {
        function __construct()
        {
            parent::__construct();
        }

        public function get_modular_tlds(){
            $stmt   = $this->db->select()->from("tldlist");
            $stmt->where("module","!=","none","&&");
            $stmt->where("status","=","active");
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function set_price($id=0,$data=[]){
            return $this->db->update("prices",$data)->where("id","=",$id)->save();
        }

        public function get_currencies(){
            $case = "CASE ";
            $case .= "WHEN local = 1 THEN 0 ";
            $case .= "WHEN status = 'active' THEN 1 ";
            $case .= "WHEN status = 'inactive' THEN 2 ";
            $case .= "END AS rank";
            $stmt   = $this->db->select("*,".$case)->from("currencies");
            $stmt->where('status','=',"active","||");
            $stmt->where('status','=',"inactive");
            $stmt->order_by("rank ASC,id DESC");
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }
        public function set_currency($id=0,$data=[]){
            $stmt = $this->db->update("currencies",$data);
            if($id) $stmt->where("id","=",$id);
            return $stmt->save();
        }
        public function remaining_orders($month='',$thn_month=''){
            if(!($month || $thn_month)) return [];
            $now                = DateManager::Now();
            $stmt               = $this->db->select("id,owner_id AS user_id,type,type_id,product_id,name,cdate,renewaldate,duedate,period,period_time,amount,amount_cid AS cid,options,subscription_id")->from("users_products AS t1");
            $stmt->where("period","!=","none","&&");
            $stmt->where("duedate","!=",DateManager::ata(),"&&");
            $stmt->where("(");
            $stmt->where("status","=","suspended","||");
            $stmt->where("status","=","active");
            $stmt->where(")","","","&&");

            $stmt->where("(");

            if($month){
                $stmt->where("(");
                $stmt->where("period","!=","hour","&&");
                $stmt->where("period","!=","year","&&");
                $stmt->where("DATEDIFF(duedate,'".$now."')","<=",$month);
                $stmt->where(")","","","||");
            }
            if($thn_month){
                $stmt->where("(");
                $stmt->where("period","=","year","&&");
                $stmt->where("DATEDIFF(duedate,'".$now."')","<=",$thn_month);
                $stmt->where(")","","","||");
            }

            $stmt->where("(");
            $stmt->where("period","=","hour","&&");
            $stmt->where("duedate","<",$now);
            $stmt->where(")","","","");

            $stmt->where(")");
            $stmt->order_by("id DESC");
            return $stmt->build() ? $stmt->fetch_assoc() : [];
        }
        public function remaining_addons($month='',$thn_month=''){
            if(!($month || $thn_month)) return [];
            $now                = DateManager::Now();
            $select             = [
                'ad.id',
                'ad.owner_id',
                'ad.addon_id',
                'ad.option_id',
                'ad.addon_name',
                'ad.option_name',
                'ad.option_quantity',
                'ad.cdate',
                'ad.renewaldate',
                'ad.duedate',
                'ad.period',
                'ad.period_time',
                'ad.amount',
                'ad.cid',
                'ad.subscription_id',
                'DATEDIFF(ad.duedate,ad.renewaldate) AS period_day',
                'DATEDIFF(ad.duedate,\''.$now.'\') AS remaining_day',
            ];
            $stmt               = $this->db->select(implode(',',$select))->from("users_products_addons AS ad");
            $stmt->where("ad.period","!=","none","&&");
            $stmt->where("ad.duedate","!=",DateManager::ata(),"&&");

            $stmt->where("(");
            $stmt->where("ad.status","=","suspended","||");
            $stmt->where("ad.status","=","completed","||");
            $stmt->where("ad.status","=","active");
            $stmt->where(")","","","&&");

            $stmt->where("(");

            if($month){
                $stmt->where("(");
                $stmt->where("DATEDIFF(ad.duedate,ad.renewaldate) <= 31","","","&&");
                $stmt->where("DATEDIFF(ad.duedate,'".$now."') <= ".$month);
                $stmt->where(")","","",($thn_month ? "||" : ""));
            }
            if($thn_month){
                $stmt->where("(");
                $stmt->where("DATEDIFF(ad.duedate,ad.renewaldate) > 31","","","&&");
                $stmt->where("DATEDIFF(ad.duedate,'".$now."') <= ".$thn_month);
                $stmt->where(")");
            }

            $stmt->where(")");
            $stmt->order_by("remaining_day ASC,ad.id DESC");
            return $stmt->build() ? $stmt->fetch_assoc() : [];
        }
        public function remaining_invoices($first=0,$second=0,$third=0){
            if(!($first || $second || $third)) return false;
            $now                = DateManager::Now();
            $select             = [
                'id',
                'cdate',
                'duedate',
                'DATEDIFF(duedate,\''.$now.'\') AS remaining_day',
            ];
            $stmt               = $this->db->select(implode(",",$select))->from("invoices");
            $stmt->where("status","=","unpaid","&&");
            $stmt->where("duedate","!=",DateManager::ata(),"&&");

            $stmt->where("(");
            if($first) $stmt->where('DATEDIFF(duedate,\''.$now.'\')',"=",$first,$second ? '||' : '');
            if($second) $stmt->where('DATEDIFF(duedate,\''.$now.'\')',"=",$second,$third ? '||' : '');
            if($third) $stmt->where('DATEDIFF(duedate,\''.$now.'\')',"=",$third);
            $stmt->where(")");

            $stmt->order_by("remaining_day ASC,id DESC");
            return $stmt->build() ? $stmt->fetch_assoc() : [];

        }
        public function overdue_invoices($first=0,$second=0,$third=0){
            if(!($first || $second || $third)) return false;
            $now                = DateManager::Now();
            $select             = [
                'id',
                'cdate',
                'duedate',
                'DATEDIFF(\''.$now.'\',duedate) AS delayed_day',
            ];
            $stmt               = $this->db->select(implode(",",$select))->from("invoices");
            $stmt->where("status","=","unpaid","&&");
            $stmt->where("duedate","!=",DateManager::ata(),"&&");
            $stmt->where("(");
            if($first) $stmt->where('DATEDIFF(\''.$now.'\',duedate)',"=",$first,$second ? '||' : '');
            if($second) $stmt->where('DATEDIFF(\''.$now.'\',duedate)',"=",$second,$third ? '||' : '');
            if($third) $stmt->where('DATEDIFF(\''.$now.'\',duedate)',"=",$third);
            $stmt->where(")");
            $stmt->order_by("delayed_day DESC,id DESC");
            return $stmt->build() ? $stmt->fetch_assoc() : [];

        }
        public function delayed_invoices($day=0){
            if(!$day) return false;
            $now                = DateManager::Now();
            $select             = [
                'id',
                'cdate',
                'duedate',
                'DATEDIFF(\''.$now.'\',duedate) AS delayed_day',
            ];
            $stmt               = $this->db->select(implode(",",$select))->from("invoices");
            $stmt->where("status","=","unpaid","&&");
            $stmt->where("duedate","!=",DateManager::ata(),"&&");
            $stmt->where('DATEDIFF(\''.$now.'\',duedate)',">=",$day);
            $stmt->order_by("delayed_day DESC,id DESC");
            return $stmt->build() ? $stmt->fetch_assoc() : [];
        }
        public function cancelled_invoices($day=0){
            if(!$day) return false;
            $now                = DateManager::Now();
            $select             = [
                'id',
                'cdate',
                'duedate',
                'DATEDIFF(\''.$now.'\',duedate) AS delayed_day',
            ];
            $stmt               = $this->db->select(implode(",",$select))->from("invoices");
            $stmt->where("status","=","cancelled","&&");
            $stmt->where("duedate","!=",DateManager::ata(),"&&");
            $stmt->where('DATEDIFF(\''.$now.'\',duedate)',">=",$day);
            $stmt->order_by("delayed_day DESC,id DESC");
            return $stmt->build() ? $stmt->fetch_assoc() : [];
        }
        public function delayed_orders($type='',$day=0,$hour=0,$status='',$mode=''){
            $now    = DateManager::Now();
            $day    = (string) $day;
            $hour   = (string) $hour;

            if($type == "order"){
                $stmt   = $this->db->select(implode(",",[
                    'id',
                    'owner_id AS user_id',
                    'type',
                    'product_id',
                    'name',
                    'cdate',
                    'renewaldate',
                    'duedate',
                    'suspend_date',
                    'cancel_date',
                    'period',
                    'period_time',
                    'amount',
                    'amount_cid AS cid',
                    'options',
                    'module',
                    'status',
                    'status_msg',
                    'DATEDIFF(duedate,renewaldate) AS period_day',
                    'DATEDIFF(\''.$now.'\',duedate) AS delayed_day',
                    "JSON_UNQUOTE(JSON_EXTRACT(usp.options,'$.server_id')) AS server_id",
                ]))->from("users_products AS usp");
                $stmt->where('duedate',"!=",DateManager::ata(),"&&");

                $stmt->where("(");
                if(strlen($hour) > 0)
                {
                    $stmt->where("(");
                    $stmt->where("period","=","hour","&&");
                    if($hour == 0)
                        $stmt->where("duedate","<",$now);
                    else
                        $stmt->where("DATE_SUB(duedate,INTERVAL -".$hour." HOUR)","<",$now);
                    $stmt->where(")","","","||");
                }

                $stmt->where('DATEDIFF(\''.$now.'\',duedate)',">=",$day);
                $stmt->where(")","","","&&");

                if($mode == "terminate"){
                    $stmt->where("(");
                    $stmt->where("type","=",'hosting','||');
                    $stmt->where("type","=",'server');
                    $stmt->where(")",'','',"&&");
                    $stmt->where("options","LIKE",'%"config"%',"&&");
                    $stmt->where("(SELECT id FROM ".$this->pfx."servers WHERE id=JSON_UNQUOTE(JSON_EXTRACT(usp.options,'$.server_id')) AND status='active')",">","0","&&");
                }

                $stmt->where("process_exemption_date","<",$now,"&&");

                if($status) $stmt->where("status","=",$status,"&&");
                $stmt->where("period","!=","none");
                $stmt->order_by("delayed_day DESC,id DESC");
                return $stmt->build() ? $stmt->fetch_assoc() : [];
            }
            elseif($type == "addon"){
                $stmt   = $this->db->select(implode(",",[
                    'id',
                    'owner_id',
                    '(SELECT owner_id FROM '.$this->pfx.'users_products WHERE id=ad.owner_id) AS user_id',
                    'addon_key',
                    'addon_id',
                    'option_id',
                    'addon_name',
                    'option_name',
                    'cdate',
                    'renewaldate',
                    'duedate',
                    'period',
                    'period_time',
                    'amount',
                    'cid',
                    'status',
                    'status_msg',
                    'DATEDIFF(duedate,renewaldate) AS period_day',
                    'DATEDIFF(\''.$now.'\',duedate) AS delayed_day',
                ]))->from("users_products_addons AS ad");
                $stmt->where('duedate',"!=",DateManager::ata(),"&&");

                $stmt->where("(");
                if(strlen($hour) > 0)
                {
                    $stmt->where("(");
                    $stmt->where("period","=","hour","&&");
                    if($hour == 0)
                        $stmt->where("duedate","<",$now);
                    else
                        $stmt->where("DATE_SUB(duedate,INTERVAL -".$hour." HOUR)","<",$now);
                    $stmt->where(")","","","||");
                }
                $stmt->where('DATEDIFF(\''.$now.'\',duedate)',">=",$day);
                $stmt->where(")","","","&&");

                if($status) $stmt->where("status","=",$status,"&&");
                $stmt->where("amount",">","0","&&");
                $stmt->where("period","!=","none");
                $stmt->order_by("delayed_day DESC,id DESC");
                return $stmt->build() ? $stmt->fetch_assoc() : [];
            }
        }
        public function delayed_orders_sc($type='suspend'){
            $now    = DateManager::Now("Y-m-d");
            $stmt   = $this->db->select(implode(",",[
                'id',
                'owner_id AS user_id',
                'type',
                'product_id',
                'name',
                'cdate',
                'renewaldate',
                'duedate',
                'suspend_date',
                'cancel_date',
                'period',
                'period_time',
                'amount',
                'amount_cid AS cid',
                'options',
                'module',
                'status',
                'status_msg',
            ]))->from("users_products");

            if($type == 'suspend'){
                $stmt->where("status","!=","suspended","&&");
                $stmt->where("status","!=","cancelled","&&");
            }
            elseif($type == 'cancel'){
                $stmt->where("status","!=","cancelled","&&");
            }

            $stmt->where($type."_date","!=","0000-00-00","&&");
            $stmt->where($type."_date","!=","1881-05-19","&&");
            $stmt->where($type."_date","<=",$now);

            $stmt->order_by("id DESC");

            return $stmt->build() ? $stmt->fetch_assoc() : [];
        }
        public function cancellation_request_orders(){
            $now    = DateManager::Now();
            $stmt   = $this->db->select(implode(",",[
                't1.id',
                't1.owner_id AS user_id',
                't1.type',
                't1.product_id',
                't1.name',
                't1.cdate',
                't1.renewaldate',
                't1.duedate',
                't1.period',
                't1.period_time',
                't1.amount',
                't1.amount_cid AS cid',
                't1.options',
                't1.module',
                't1.status',
                't2.id AS event_id',
                'DATEDIFF(t1.duedate,t1.renewaldate) AS period_day',
                'DATEDIFF(\''.$now.'\',t1.duedate) AS delayed_day',
            ]))->from("users_products AS t1");
            $stmt->join("LEFT","events AS t2","t2.name='cancelled-product-request' AND t2.owner_id=t1.id AND t2.owner='order' AND t2.status='approved' AND t2.data LIKE '%\"urgency\":\"period-ending\"%'");
            $stmt->where('t1.duedate',"!=",DateManager::ata(),"&&");
            $stmt->where('DATEDIFF(\''.$now.'\',t1.duedate)',">=","0","&&");
            $stmt->where("t1.status","!=","cancelled","&&");
            $stmt->where("t1.period","!=","none","&&");
            $stmt->where("t2.id","IS NOT NULL");
            $stmt->order_by("delayed_day DESC,t1.id DESC");
            return $stmt->build() ? $stmt->fetch_assoc() : [];
        }
        public function pending_orders($type='',$day=0){
            if(!$day) return [];
            $now    = DateManager::Now();
            if($type == "order"){
                $stmt   = $this->db->select(implode(",",[
                    'id',
                    'owner_id AS user_id',
                    'type',
                    'product_id',
                    'name',
                    'cdate',
                    'renewaldate',
                    'duedate',
                    'period',
                    'period_time',
                    'amount',
                    'amount_cid AS cid',
                    'DATEDIFF(\''.$now.'\',cdate) AS delayed_day',
                ]))->from("users_products");
                $stmt->where('DATEDIFF(\''.$now.'\',cdate)',">=",$day,"&&");
                $stmt->where("status","=","waiting");
                $stmt->order_by("delayed_day DESC,id DESC");
                return $stmt->build() ? $stmt->fetch_assoc() : [];
            }
            elseif($type == "addon"){
                $stmt   = $this->db->select(implode(",",[
                    'id',
                    'owner_id',
                    '(SELECT owner_id FROM '.$this->pfx.'users_products WHERE id=ad.owner_id) AS user_id',
                    'addon_id',
                    'option_id',
                    'addon_name',
                    'option_name',
                    'cdate',
                    'renewaldate',
                    'duedate',
                    'period',
                    'period_time',
                    'amount',
                    'cid',
                    'DATEDIFF(\''.$now.'\',cdate) AS delayed_day',
                ]))->from("users_products_addons AS ad");
                $stmt->where('DATEDIFF(\''.$now.'\',cdate)',">=",$day,"&&");
                $stmt->where("status","=","waiting");
                $stmt->order_by("delayed_day DESC,id DESC");
                return $stmt->build() ? $stmt->fetch_assoc() : [];
            }
        }
        public function pending_domain_transfer_orders(){
            $stmt   = $this->db->select(implode(",",[
                'id',
                'owner_id AS user_id',
                'name',
                'cdate',
                'renewaldate',
                'duedate',
                'period',
                'period_time',
                'module',
                'status',
                'options',
            ]))->from("users_products AS ordr");
            $stmt->where("type","=","domain","&&");
            $stmt->where("module","!=","none","&&");
            $stmt->where("(SELECT id FROM ".$this->pfx."events WHERE type='operation' AND owner='order' AND owner_id=ordr.id AND name='transfer-request-to-us-with-api' AND status='pending' LIMIT 1)");
            $stmt->order_by("id ASC");
            return $stmt->build() ? $stmt->fetch_assoc() : [];
        }
        public function domain_transfer_unlocked_orders(){
            $stmt   = $this->db->select(implode(",",[
                'id',
                'owner_id AS user_id',
                'name',
                'cdate',
                'renewaldate',
                'duedate',
                'period',
                'period_time',
                'module',
                'options',
            ]))->from("users_products AS ordr");
            $stmt->where("type","=","domain","&&");
            $stmt->where("status","=","active","&&");
            $stmt->where("module","!=","none","&&");
            $stmt->where("options","LIKE",'%"transferlock":false%');
            $stmt->order_by("id ASC");
            return $stmt->build() ? $stmt->fetch_assoc() : [];
        }
        public function replied_tickets($day=0,$locked=false){
            if(!$day) return [];
            $now    = DateManager::Now();
            $stmt   = $this->db->select("id,title,ctime,lastreply,DATEDIFF('".$now."',lastreply) AS delayed_day")->from("tickets");
            if($locked){
                $stmt->where("(");
                $stmt->where("status","=","replied","||");
                $stmt->where("status","=","solved");
                $stmt->where(")","","","&&");
                $stmt->where("locked","=","0","&&");
            }else
                $stmt->where("status","=","replied","&&");
            $stmt->where('DATEDIFF(\''.$now.'\',lastreply)',">=",$day);
            return $stmt->build() ? $stmt->fetch_assoc() : [];
        }
        public function unverified_accounts($day=0,$everify=0,$gverify=0){
            if(!$day) return [];
            if(!($everify || $gverify)) return [];
            $now        = DateManager::Now();
            $stmt       = $this->db->select("us.id,DATEDIFF('".$now."',us.creation_time) AS delayed_day")->from("users AS us");
            $stmt->join("LEFT","users_informations AS e_verify","e_verify.owner_id=us.id AND e_verify.name='verified-email'");
            $stmt->join("LEFT","users_informations AS g_verify","g_verify.owner_id=us.id AND g_verify.name='verified-gsm'");

            $stmt->where("us.type","=","member","&&");
            $stmt->where("DATEDIFF('".$now."',us.creation_time)",">=",$day,"&&");

            if($everify && $gverify){

                $stmt->where("!(");
                $stmt->where("e_verify.id","IS NOT NULL","","||");
                $stmt->where("g_verify.id","IS NOT NULL","","");
                $stmt->where(")","","","&&");

            }elseif($everify)
                $stmt->where("e_verify.id","IS NULL","","&&");
            elseif($gverify)
                $stmt->where("g_verify.id","IS NULL","","&&");

            $stmt->where("(SELECT id FROM users_products WHERE status!='waiting' AND owner_id=us.id LIMIT 1)","IS NULL","","&&");
            $stmt->where("(SELECT id FROM invoices WHERE user_id=us.id AND (status='paid' OR status='refund' OR status='cancelled') LIMIT 1)","IS NULL","","&&");

            $stmt->where("us.status","=","active");

            $stmt->group_by("us.id");
            return $stmt->build() ? $stmt->fetch_assoc() : [];
        }
        public function non_order_accounts($day=0){
            if(!$day) return [];
            $now        = DateManager::Now();
            $stmt       = $this->db->select("us.id,DATEDIFF('".$now."',us.creation_time) AS delayed_day")->from("users AS us");
            $stmt->where("us.type","=","member","&&");
            $stmt->where("DATEDIFF('".$now."',us.creation_time)",">=",$day,"&&");

            $stmt->where("(SELECT id FROM users_products WHERE status!='waiting' AND owner_id=us.id LIMIT 1)","IS NULL","","&&");
            $stmt->where("(SELECT id FROM invoices WHERE user_id=us.id AND (status='paid' OR status='refund' OR status='cancelled') LIMIT 1)","IS NULL","","&&");

            $stmt->where("us.status","=","active");
            $stmt->group_by("us.id");
            return $stmt->build() ? $stmt->fetch_assoc() : [];
        }
        public function low_balance_accounts(){
            $now        = DateManager::Now();
            $stmt       = $this->db->select(implode(",",[
                'us.id',
                'balance',
                'balance_min',
                'balance_currency',
                'DATEDIFF(\''.$now.'\',(SELECT ctime FROM mail_logs WHERE user_id=us.id AND reason=\'credit-fell-below-a-minimum\' ORDER BY id DESC LIMIT 1)) AS delayed_day',
            ]))->from("users AS us");

            $stmt->where("us.type","=","member","&&");

            $stmt->where("us.balance_min",">","0","&&");
            $stmt->where("us.balance","<= us.balance_min","","&&");

            $stmt->where("us.status","=","active");
            return $stmt->build() ? $stmt->fetch_assoc() : [];
        }
        public function delete_actions($day=0){
            if(!$day) return [];
            $now    = DateManager::Now();
            $this->db->delete("users_actions")->where('DATEDIFF(\''.$now.'\',ctime)',">=",$day)->run();
            $this->db->delete("users_last_logins")->where('DATEDIFF(\''.$now.'\',ctime)',">=",$day)->run();
            return true;
        }
        public function delete_checkouts($day=0){
            if(!$day) return [];
            $now    = DateManager::Now();
            return $this->db->delete("checkouts")->where("status","=","unpaid","&&")->where('DATEDIFF(\''.$now.'\',mdfdate)',">=",$day)->run();
        }
        public function delete_login_log($day=0){
            if(!$day) return [];
            $now    = DateManager::Now();
            return $this->db->delete("users_last_logins")->where('DATEDIFF(\''.$now.'\',ctime)',">=",$day)->run();
        }
        public function delete_notifications($day=0){
            if(!$day) return [];
            $now    = DateManager::Now();
            $stmt   = $this->db->delete("events")->where('DATEDIFF(\''.$now.'\',cdate)',">=",$day,"&&");

            $stmt->where("status","=","approved","&&");
            $stmt->where("unread","=","1","&&");

            $stmt->where("(");

            $stmt->where("(");
            $stmt->where("type","=","info","&&");
            $stmt->where("owner","=","system");
            $stmt->where(")","","","||");

            $stmt->where("(");
            $stmt->where("type","=","info","&&");
            $stmt->where("owner","=","tickets");
            $stmt->where(")");

            $stmt->where(")");

            $stmt   = $stmt->run();

            return $stmt;
        }
        public function get_reminders($type=''){
            $now            = DateManager::Now("Y-m-d H:i");
            $parse          = explode(" ",$now);
            $parse_date     = explode("-",$parse[0]);
            $parse_time     = explode(":",$parse[1]);
            $date           = $parse_date[0]."-".$parse_date[1]."-".$parse_date[2];
            $year           = (int) $parse_date[0];
            $month          = (int) $parse_date[1];
            $day            = (int) $parse_date[2];
            $time           = $parse_time[0].":".$parse_time[1];
            $hour           = (int) $parse_time[0];
            $minute         = (int) $parse_time[1];


            $stmt           = $this->db->select()->from("users_reminders");
            $stmt->where("status","=","active","&&");


            if($type == "waiting"){
                $stmt->where("(");

                $stmt->where("(");
                $stmt->where("period_month","!=","-1","&&");
                $stmt->where("period_day","!=","-1","&&");
                $stmt->where("period_month","=",$month,"&&");
                $stmt->where("period_day","=",$day);
                $stmt->where(")","","","||");

                $stmt->where("(");
                $stmt->where("period_day","=","-1","&&");
                $stmt->where("period_month","!=","-1","&&");
                $stmt->where("period_month","=",$month);
                $stmt->where(")","","","||");

                $stmt->where("(");
                $stmt->where("period_month","=","-1","&&");
                $stmt->where("period_day","!=","-1","&&");
                $stmt->where("period_day","=",$day);
                $stmt->where(")","","","||");

                $stmt->where("(");
                $stmt->where("period_month","=","-1","&&");
                $stmt->where("period_day","=","-1");
                $stmt->where(")");

                $stmt->where(")");
            }elseif($type == "past"){
                $stmt->where("period","=","onetime","&&");
                $stmt->where("period_datetime","<",$now.":00");
            }

            $stmt->order_by("id ASC");
            return $stmt->build() ? $stmt->fetch_assoc() : [];
        }
        public function get_notification_reminders($type=''){
            $now            = DateManager::Now("Y-m-d H:i");
            $parse          = explode(" ",$now);
            $parse_date     = explode("-",$parse[0]);
            $parse_time     = explode(":",$parse[1]);
            $date           = $parse_date[0]."-".$parse_date[1]."-".$parse_date[2];
            $year           = (int) $parse_date[0];
            $month          = (int) $parse_date[1];
            $day            = (int) $parse_date[2];
            $time           = $parse_time[0].":".$parse_time[1];
            $hour           = (int) $parse_time[0];
            $minute         = (int) $parse_time[1];


            $stmt           = $this->db->select()->from("notification_templates AS t1");
            $stmt->where("auto_submission","=","1","&&");


            if($type == "waiting"){
                $stmt->where("(");

                $stmt->where("(");
                $stmt->where("period_month","!=","-1","&&");
                $stmt->where("period_day","!=","-1","&&");
                $stmt->where("period_month","=",$month,"&&");
                $stmt->where("period_day","=",$day);
                $stmt->where(")","","","||");

                $stmt->where("(");
                $stmt->where("period_day","=","-1","&&");
                $stmt->where("period_month","!=","-1","&&");
                $stmt->where("period_month","=",$month);
                $stmt->where(")","","","||");

                $stmt->where("(");
                $stmt->where("period_month","=","-1","&&");
                $stmt->where("period_day","!=","-1","&&");
                $stmt->where("period_day","=",$day);
                $stmt->where(")","","","||");

                $stmt->where("(");
                $stmt->where("period_month","=","-1","&&");
                $stmt->where("period_day","=","-1");
                $stmt->where(")");

                $stmt->where(")");
            }
            elseif($type == "past"){
                $stmt->where("period","=","onetime","&&");
                $stmt->where("period_datetime","<=",$now.":00","&&");
                $stmt->where("NOT EXISTS(SELECT id FROM ".$this->pfx."notification_templates_logs WHERE owner_id=t1.id AND CONCAT_WS(' ',reminding_date,reminding_time) >= t1.period_datetime LIMIT 1)");
            }

            $stmt->order_by("id ASC");
            return $stmt->build() ? $stmt->fetch_assoc() : [];
        }
        public function get_periodic_outgoings(){
            $now            = DateManager::Now("Y-m-d H:i");
            $parse          = explode(" ",$now);
            $parse_date     = explode("-",$parse[0]);
            $parse_time     = explode(":",$parse[1]);
            $date           = $parse_date[0]."-".$parse_date[1]."-".$parse_date[2];
            $year           = (int) $parse_date[0];
            $month          = (int) $parse_date[1];
            $day            = (int) $parse_date[2];
            $time           = $parse_time[0].":".$parse_time[1];
            $hour           = (int) $parse_time[0];
            $minute         = (int) $parse_time[1];


            $stmt           = $this->db->select()->from("periodic_outgoings");

            $stmt->where("period_day","!=","-1","&&");
            $stmt->where("period_day","=",$day);
            $stmt->order_by("id ASC");
            return $stmt->build() ? $stmt->fetch_assoc() : [];
        }
        public function delete_events()
        {
            $delete = $this->db->delete("events");

            $delete->where("(");
            $delete->where("type","=","notification","&&");
            $delete->where("status","=","approved","");
            $delete->where(")","","","||");

            $delete->where("(");
            $delete->where("name","=","trackable_jobs","&&");
            $delete->where("status","=","error","");
            $delete->where(")","","","||");

            $delete->where("(");
            $delete->where("name","=","invoice-overdue","&&");
            $delete->where("status","=","approved","");
            $delete->where(")","","","||");

            $delete->where("(");
            $delete->where("name","=","trackable_jobs","&&");
            $delete->where("status","=","approved","");
            $delete->where(")","","","||");

            $delete->where("(");
            $delete->where("name","=","module-addon-error","&&");
            $delete->where("status","=","approved","");
            $delete->where(")","","","||");

            $delete->where("(");
            $delete->where("name","=","credit-fell-below-a-minimum","&&");
            $delete->where("status","=","approved","");
            $delete->where(")","","","||");

            $delete->where("(");
            $delete->where("name","=","order-has-been-cancelled","&&");
            $delete->where("status","=","approved","");
            $delete->where(")","","","||");

            $delete->where("(");
            $delete->where("name","=","order-addon-has-been-cancelled","&&");
            $delete->where("status","=","approved","");
            $delete->where(")","","","||");

            $delete->where("(");
            $delete->where("name","=","order-has-been-suspended","&&");
            $delete->where("status","=","approved","");
            $delete->where(")","","","||");

            $delete->where("(");
            $delete->where("name","=","order-addon-has-been-suspended","&&");
            $delete->where("status","=","approved","");
            $delete->where(")","","","||");

            $delete->where("(");
            $delete->where("name","=","order-terminate-error","&&");
            $delete->where("status","=","approved","");
            $delete->where(")","","","||");

            $delete->where("(");
            $delete->where("name","=","addon-service-time-renewed","&&");
            $delete->where("status","=","approved","");
            $delete->where(")","","","||");

            $delete->where("(");
            $delete->where("name","=","service-time-renewed","&&");
            $delete->where("status","=","approved","");
            $delete->where(")","","","||");

            $delete->where("(");
            $delete->where("name","=","transfer-request-to-us-with-api","&&");
            $delete->where("status","=","approved","");
            $delete->where(")","","","||");

            $delete->where("(");
            $delete->where("name","=","domain-extended","&&");
            $delete->where("status","=","approved","");
            $delete->where(")","","","||");

            $delete->where("(");
            $delete->where("name","=","invoice-created","&&");
            $delete->where("status","=","approved","");
            $delete->where(")","","","||");

            $delete->where("(");
            $delete->where("name","=","invoice-has-been-approved","&&");
            $delete->where("status","=","approved","");
            $delete->where(")","","","||");

            $delete->where("(");
            $delete->where("name","=","ticket-has-been-replied-by-admin","&&");
            $delete->where("status","=","approved","");
            $delete->where(")","","","||");

            $delete->where("(");
            $delete->where("name","=","ticket-has-been-resolved-automatic","&&");
            $delete->where("status","=","approved","");
            $delete->where(")","","","||");

            $delete->where("(");
            $delete->where("type","=","checking","&&");
            $delete->where("owner","=","order","&&");
            $delete->where("status","=","approved","");
            $delete->where(")","","","||");

            $delete->where("name","=","bill-payment-error","||");
            $delete->where("name","=","cart-payment-error","||");
            $delete->where("name","=","invoice-address-issue");

            return $delete->run();
        }
        public function check_cancelled_request($order_id=0,$renewal_date='')
        {
            $stmt       = $this->db->select("id")->from("events");
            $stmt->where("owner","=","order","&&");
            $stmt->where("owner_id","=",$order_id,"&&");
            $stmt->where("name","=","cancelled-product-request","&&");
            $stmt->where("data","LIKE",'%period-ending%',"&&");
            $stmt->where("status","=","approved","&&");
            $stmt->where("cdate",">",$renewal_date);
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }
        public function auto_payment_orders()
        {
            $now        = DateManager::Now();
            $stmt       = $this->db->select("t1.id,t1.user_id,t1.duedate,DATEDIFF(t1.duedate,'".$now."') AS day")->from("invoices AS t1");
            $stmt->join("LEFT","invoices_items AS t2","t2.owner_id=t1.id");
            $stmt->join("LEFT","users_products AS t3","t2.user_pid=t3.id");
            $stmt->where("t3.id IS NOT NULL","","","&&");
            $stmt->where("t3.auto_pay","=","1","&&");
            $stmt->where("FIND_IN_SET(DATEDIFF(t1.duedate,'".$now."'),'-1,0,1')","","","&&");
            $stmt->where("t1.status","=","unpaid");
            $stmt->group_by("t1.id");
            $stmt->order_by("t1.id ASC");
            return $stmt->build() ? $stmt->fetch_assoc() : [];
        }

        public function get_default_stored_card($user_id=0,$module='')
        {
            $stmt       = $this->db->select("id,ln4")->from("users_stored_cards");
            $stmt->where("user_id","=",$user_id,"&&");
            $stmt->where("as_default","=",1,"&&");
            $stmt->where("module","=",$module);
            return $stmt->build() ? $stmt->getAssoc() : false;
        }

        public function istdycc($invoice_id=0,$date='')
        {
            $stmt       = $this->db->select("id")->from("events");
            $stmt->where("type","=","log","&&");
            $stmt->where("owner","=","invoice","&&");
            $stmt->where("owner_id","=",$invoice_id,"&&");
            $stmt->where("name","=","credit-card-captured","&&");
            $stmt->where("cdate","LIKE","%".$date."%");
            return $stmt->build();
        }

        public function upcoming_subscriptions()
        {
            $stmt       = $this->db->select("sbs.*")->from("users_products_subscriptions AS sbs");
            $stmt->where("sbs.status","!=","cancelled","&&");
            $stmt->where("(");
            $stmt->where("(SELECT COUNT(id) FROM ".$this->pfx."users_products WHERE subscription_id=sbs.id)",">","0","||");
            $stmt->where("(SELECT COUNT(id) FROM ".$this->pfx."users_products_addons WHERE subscription_id=sbs.id)",">","0");
            $stmt->where(")","","","&&");
            $stmt->where("DATE_FORMAT(sbs.next_payable_date,'%Y-%m-%d')","<=",DateManager::Now("Y-m-d"),"&&");
            $stmt->where("DATE_ADD(DATE_FORMAT(sbs.next_payable_date,'%Y-%m-%d'), INTERVAL 5 DAY)",">=",DateManager::Now("Y-m-d"));
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }
        public function subscriptions()
        {
            $stmt       = $this->db->select("sbs.*")->from("users_products_subscriptions AS sbs");
            $stmt->where("sbs.status","!=","cancelled","&&");
            $stmt->where("(");
            $stmt->where("(SELECT COUNT(id) FROM ".$this->pfx."users_products WHERE subscription_id=sbs.id)",">","0","||");
            $stmt->where("(SELECT COUNT(id) FROM ".$this->pfx."users_products_addons WHERE subscription_id=sbs.id)",">","0");
            $stmt->where(")","","","&&");
            $stmt->where("sbs.items","IS NOT NULL");
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }
        public function subscription_modules()
        {
            $stmt       = $this->db->select("module")->from("users_products_subscriptions AS sbs");
            $stmt->where("sbs.status","!=","cancelled","&&");
            $stmt->where("(");
            $stmt->where("(SELECT COUNT(id) FROM ".$this->pfx."users_products WHERE subscription_id=sbs.id)",">","0","||");
            $stmt->where("(SELECT COUNT(id) FROM ".$this->pfx."users_products_addons WHERE subscription_id=sbs.id)",">","0");
            $stmt->where(")");
            $stmt->group_by("module");
            return $stmt->build() ? $stmt->fetch_object() : false;
        }

    }