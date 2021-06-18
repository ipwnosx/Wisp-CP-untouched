<?php
    defined('CORE_FOLDER') OR exit('You can not get in here!');
    class Model extends Models
    {
        function __construct()
        {
            parent::__construct();
        }

        public function clear_visits(){
            return $this->db->delete("visitors")->run();
        }

        public function pending_approval_invoices(){
            $select     = implode(",",[
                't1.id',
                't1.total',
                't1.currency',
                't2.full_name AS user_name',
                't2.company_name AS user_company_name',
                't2.id AS user_id',
                't1.cdate',
                't1.duedate',
            ]);
            $stmt       = $this->db->select($select)->from("invoices AS t1");
            $stmt->join("LEFT","users AS t2","t2.id=t1.user_id");
            $stmt->where("t2.id","IS NOT NULL","","&&");
            $stmt->where("t1.duedate",">=",DateManager::Now("Y-m-d"),"&&");
            $stmt->where("t1.duedate","<=",DateManager::next_date(['day' => 8],"Y-m-d"),"&&");
            $stmt->where("t1.status","=","unpaid");

            $stmt->order_by("t1.id DESC");
            $stmt->limit(5);
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function pending_replying_tickets(){
            $case = "CASE ";
            $case .= "WHEN t1.status = 'waiting' THEN 1 ";
            $case .= "WHEN t1.status = 'process' THEN 2 ";
            $case .= "WHEN t1.status = 'replied' THEN 3 ";
            $case .= "WHEN t1.status = 'solved' THEN 4 ";
            $case .= "END AS rank";

            $select     = implode(",",[
                't1.id',
                't1.title',
                't1.ctime',
                't1.lastreply',
                't2.full_name AS user_name',
                '(SELECT content FROM '.$this->pfx.'users_informations WHERE name="company_name" AND owner_id=t2.id) AS user_company_name',
                't1.status',
                't2.id AS user_id',
                $case
            ]);
            $stmt       = $this->db->select($select)->from("tickets AS t1");
            $stmt->join("LEFT","users AS t2","t2.id=t1.user_id");
            $stmt->where("t2.id","IS NOT NULL","","&&");
            $stmt->where("(");
            $stmt->where("t1.status","=","waiting","||");
            $stmt->where("t1.status","=","process");
            $stmt->where(")");
            $stmt->order_by("rank ASC,t1.lastreply DESC");
            $stmt->limit(5);
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function online_list($client=false){
            $select = [
                't1.id',
                't1.ip',
                't1.full_name',
                't2.name AS avatar_image',
                $client ? '"" AS group_name' : 't3.name AS group_name',
                't1.online',
            ];
            $sth = $this->db->select(implode(",",$select))->from("users AS t1");
            $sth->join("LEFT","pictures AS t2","t2.owner_id=t1.id AND t2.owner='user' AND t2.reason='profile-image'");
            $sth->join("LEFT","privileges AS t3","t3.id=t1.privilege");
            $sth->where("t1.type","=",($client ? "member" : "admin"),"&&");
            $sth->where("'".DateManager::Now()."' < t1.online");
            $sth->order_by("t1.last_login_time DESC");
            return $sth->build() ? $sth->fetch_assoc() : false;
        }

        public function get_statistic_overdue_invoices(){
            $result     = [
                'count' => 0,
                'amount' => [],
            ];

            $invoices   = $this->db->select("currency,SUM(total) AS sum_total,COUNT(id) AS total_count")->from("invoices");
            $invoices->where("duedate","<",DateManager::Now(),"&&");
            $invoices->where("status","=","unpaid");
            $invoices->group_by("currency");
            $invoices   = $invoices->build() ? $invoices->fetch_assoc() : false;

            if($invoices){
                foreach($invoices AS $row){
                    $result["count"] += $row["total_count"];
                    if(isset($result["amount"][$row["currency"]])) $result["amount"][$row["currency"]] += $row["sum_total"];
                    else $result["amount"][$row["currency"]] = $row["sum_total"];
                }
            }
            return $result;
        }
        public function get_statistic_upds(){
            $result     = [
                'count' => 0,
                'amount' => [],
            ];

            $invoices   = $this->db->select("currency,SUM(total) AS sum_total,COUNT(id) AS total_count")->from("invoices");
            $invoices->where("duedate",">=",DateManager::Now(),"&&");
            $invoices->where("duedate","<=",DateManager::next_date(['day' => 8]),"&&");
            $invoices->where("status","=","unpaid");
            $invoices->group_by("currency");
            $invoices   = $invoices->build() ? $invoices->fetch_assoc() : false;

            if($invoices){
                foreach($invoices AS $row){
                    $result["count"] += $row["total_count"];
                    if(isset($result["amount"][$row["currency"]])) $result["amount"][$row["currency"]] += $row["sum_total"];
                    else $result["amount"][$row["currency"]] = $row["sum_total"];
                }
            }
            return $result;
        }
        public function get_statistic_seps(){
            $result     = [
                'count' => 0,
                'amount' => [],
            ];

            $orders   = $this->db->select("amount_cid AS currency,SUM(total_amount) AS sum_total,COUNT(id) AS total_count")->from("users_products");
            $orders->where("status","=","inprocess");
            $orders->group_by("amount_cid");
            $orders   = $orders->build() ? $orders->fetch_assoc() : false;

            if($orders){
                foreach($orders AS $row){
                    $result["count"] += $row["total_count"];
                    if(isset($result["amount"][$row["currency"]])) $result["amount"][$row["currency"]] += $row["sum_total"];
                    else $result["amount"][$row["currency"]] = $row["sum_total"];
                }
            }
            return $result;
        }
        public function get_statistic_tyrs($user_id=0){
            $total      = 0;
            $stmt       = $this->db->select("id")->from("users_reminders");
            $stmt->where("status","=","active","&&");

            $stmt->where("(");
                $stmt->where("period","=","onetime","&&");
                $stmt->where("period_datetime","LIKE","%".DateManager::Now("Y-m-d")."%");
            $stmt->where(")","","","||");

            $stmt->where("(");
                $stmt->where("period","=","recurring","&&");

                $stmt->where("(");

                    $stmt->where("(");
                        $stmt->where("period_month","=",(int) DateManager::Now("m"),"&&");
                        $stmt->where("period_day","=","-1");
                    $stmt->where(")","","","||");

                    $stmt->where("(");
                        $stmt->where("period_month","=","-1","&&");
                        $stmt->where("period_day","=",(int) DateManager::Now("d"));
                    $stmt->where(")","","","||");

                    $stmt->where("(");
                        $stmt->where("period_month","=",(int) DateManager::Now("m"),"&&");
                        $stmt->where("period_day","=",(int) DateManager::Now("d"));
                    $stmt->where(")","","","");

                $stmt->where(")");

            $stmt->where(")","","","&&");

            $stmt->where("owner_id","=",$user_id);

            $total      += $stmt->build() ? $stmt->rowCounter() : 0;
            return $total;
        }
        public function get_statistic_income($period=''){
            if($period == "today") $date = DateManager::Now("Y-m-d");
            elseif($period == "yesterday") $date = DateManager::old_date(["day" => 1],"Y-m-d");
            elseif($period == "monthly") $date = DateManager::Now("Y-m");
            elseif($period == "last-month") $date = DateManager::last_month("Y-m",DateManager::format("Y-m-d"));

            $result     = [];

            $invoices   = $this->db->select("currency,SUM(total) AS sum_total")->from("invoices");
            $invoices->where("datepaid","LIKE","%".$date."%","&&");
            $invoices->where("status","=","paid","&&");
            $invoices->where("pmethod","!=","Balance");
            $invoices->group_by("currency");
            $invoices   = $invoices->build() ? $invoices->fetch_assoc() : false;

            if($invoices){
                foreach($invoices AS $row){
                    if(isset($result[$row["currency"]])) $result[$row["currency"]] += $row["sum_total"];
                    else $result[$row["currency"]] = $row["sum_total"];
                }
            }

            $incexp   = $this->db->select("currency,SUM(amount) AS sum_total")->from("income_expense");
            $incexp->where("cdate","LIKE","%".$date."%","&&");
            $incexp->where("type","=","income","&&");
            $incexp->where("invoice_id","=","0");
            $incexp->group_by("currency");
            $incexp   = $incexp->build() ? $incexp->fetch_assoc() : false;

            if($incexp){
                foreach($incexp AS $row){
                    if(isset($result[$row["currency"]])) $result[$row["currency"]] += $row["sum_total"];
                    else $result[$row["currency"]] = $row["sum_total"];
                }
            }
            return $result;
        }

        public function get_statistic_cash($period=''){
            if($period == "this-month-outgoing" || $period == "this-month-income")
                $date = DateManager::Now("Y-m");
            elseif($period == "previous-month-income" || $period == "previous-month-outgoing")
                $date = DateManager::last_month("Y-m",DateManager::format("Y-m-d"));
            elseif($period == "today-outgoing")
                $date = DateManager::format("Y-m-d");
            elseif($period == "yesterday-outgoing")
                $date = DateManager::old_date(["day" => 1],"Y-m-d");

            $result     = [];

            $incexp   = $this->db->select("currency,SUM(amount) AS sum_total")->from("income_expense");
            if($period == "this-month-outgoing" || $period == "previous-month-outgoing" || $period == "today-outgoing" || $period == "yesterday-outgoing"){
                $incexp->where("cdate","LIKE","%".$date."%","&&");
                $incexp->where("type","=","expense","");
            }elseif($period == "total-income"){
                $incexp->where("type","=","income");
            }elseif($period == "this-month-income" || $period == "previous-month-income"){
                $incexp->where("cdate","LIKE","%".$date."%","&&");
                $incexp->where("type","=","income","");
            }elseif($period == "total-outgoing"){
                $incexp->where("type","=","expense");
            }
            $incexp->group_by("currency");
            $incexp   = $incexp->build() ? $incexp->fetch_assoc() : false;

            if($incexp){
                foreach($incexp AS $row){
                    if(isset($result[$row["currency"]])) $result[$row["currency"]] += $row["sum_total"];
                    else $result[$row["currency"]] = $row["sum_total"];
                }
            }
            return $result;
        }

        public function get_statistic_user($period){
            $sth    = $this->db->select("COUNT(id) AS total")->from("users");
            if($period == "this-month"){
                $date = DateManager::Now("Y-m");
                $sth->where("creation_time","LIKE","%".$date."%","&&");
            }elseif($period == "previous-month"){
                $date = DateManager::last_month("Y-m",DateManager::format("Y-m-d"));
                $sth->where("creation_time","LIKE","%".$date."%","&&");
            }elseif($period == "today"){
                $date = DateManager::format("Y-m-d");
                $sth->where("creation_time","LIKE","%".$date."%","&&");
            }elseif($period == "yesterday"){
                $date = DateManager::old_date(['day' => 1],"Y-m-d");
                $sth->where("creation_time","LIKE","%".$date."%","&&");
            }
            $sth->where("type","=","member");
            return $sth->build() ? $sth->getObject()->total : 0;
        }

        public function get_statistic_tickets($status=''){
            $sth    = $this->db->select("COUNT(id) AS total")->from("tickets");
            if($status == "waiting"){
                $sth->where("status","=","waiting","||");
                $sth->where("status","=","process");
            }elseif($status == "solved")
                $sth->where("status","=","solved");
            elseif($status == "today-opened"){
                $date = DateManager::format("Y-m-d");
                $sth->where("ctime","LIKE","%".$date."%");
            }elseif($status == "yesterday-opened"){
                $date = DateManager::old_date(['day' => 1],"Y-m-d");
                $sth->where("ctime","LIKE","%".$date."%");
            }elseif($status == "this-month-solved"){
                $date = DateManager::format("Y-m");
                $sth->where("ctime","LIKE","%".$date."%","&&");
                $sth->where("status","=","solved");
            }elseif($status == "previous-month-solved"){
                $date = DateManager::last_month("Y-m",DateManager::format("Y-m-d"));
                $sth->where("ctime","LIKE","%".$date."%","&&");
                $sth->where("status","=","solved");
            }

            return $sth->build() ? $sth->getObject()->total : 0;
        }

        public function get_statistic_visit($period=''){
            $date   = false;
            $sth    = $this->db->select("SUM(total) AS total")->from("visitors");
            if($period == "daily"){
                $date = DateManager::Now("Y-m-d");
            }elseif($period == "yesterday"){
                $date = DateManager::old_date(["day" => 1],"Y-m-d");
            }elseif($period == "this-month"){
                $date = DateManager::format("Y-m");
            }elseif($period == "previous-month"){
                $date = DateManager::last_month("Y-m",DateManager::format("Y-m-d"));
            }
            if($date) $sth->where("cdate","LIKE","%".$date."%","&&");
            $sth->where("owner","=","general");
            $total = $sth->build() ? $sth->getObject()->total : 0;
            return $total>0 ? $total : 0;
        }

        public function top_reminders($uid=0){
            $stmt           = $this->db->select()->from("users_reminders");
            $stmt->where("owner_id","=",$uid,"&&");
            $stmt->where("status","=","active");

            $stmt->order_by("id DESC");
            $stmt->limit(5);
            return $stmt->build() ? $stmt->fetch_assoc() : [];
        }
        public function top_tasks($uid=0,$is_full_admin,$my_dids=[]){
            $case = "CASE ";
            $case .= "WHEN t1.status = 'waiting' THEN 1 ";
            $case .= "WHEN t1.status = 'inprocess' THEN 2 ";
            $case .= "WHEN t1.status = 'postponed' THEN 3 ";
            $case .= "WHEN t1.status = 'completed' THEN 4 ";
            $case .= "ELSE 5 ";
            $case .= "END AS rank";

            $stmt   = $this->db->select("t1.*,".$case)->from("users_tasks AS t1");
            if($is_full_admin){
                $stmt->where("t1.owner_id","!=","0");
            }else{
                $stmt->where("(");
                if($my_dids) $stmt->where("FIND_IN_SET('".implode(",",$my_dids)."',t1.departments)","","","||");
                $stmt->where("t1.owner_id","=",$uid,"||");
                $stmt->where("t1.admin_id","=",$uid,"");
                $stmt->where(")");
            }
            $stmt->order_by("rank ASC,t1.id DESC");
            $stmt->limit(5);
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }
        public function top_orders($limit=5){

            $case = "CASE ";
            $case .= "WHEN t1.status = 'waiting' THEN 0 ";
            $case .= "WHEN t1.status_msg != '' THEN 0 ";
            $case .= "WHEN t1.status = 'inprocess' THEN 1 ";
            $case .= "WHEN t1.status = 'active' THEN 2 ";
            $case .= "WHEN t1.status = 'suspended' THEN 3 ";
            $case .= "WHEN t1.status = 'cancelled' THEN 4 ";
            $case .= "ELSE 5 ";
            $case .= "END AS rank";

            $select =  [
                't1.id',
                't1.invoice_id',
                't1.type',
                't1.product_id',
                't1.name',
                't1.period',
                't1.period_time',
                't1.amount',
                't1.amount_cid',
                't1.status',
                't1.status_msg',
                't1.cdate',
                't1.renewaldate',
                't1.duedate',
                't1.module',
                't1.options',
                '(SELECT full_name FROM '.$this->pfx.'users WHERE id=t1.owner_id) AS user_name',
                '(SELECT company_name FROM '.$this->pfx.'users WHERE id=t1.owner_id) AS user_company_name',
                't1.owner_id AS user_id',
                '"0" AS isEvent',
                $case,
            ];

            $stmt   = $this->db->select(implode(",",$select))->from("users_products AS t1");

            $stmt->group_by("t1.id");
            $stmt->order_by("rank ASC,t1.renewaldate DESC");
            $stmt->limit(0,$limit);

            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function smartSearch_orders($term='',$domain=false){
            if(!$term) return [];
            $term       = trim($term);
            $is_int     = $term && Validation::isInt($term);
            $term_int   = (int) Filter::numbers($term);

            $case = "CASE ";
            $case .= "WHEN t1.status = 'waiting' THEN 0 ";
            $case .= "WHEN t1.status = 'inprocess' THEN 1 ";
            $case .= "WHEN t1.status = 'active' THEN 2 ";
            $case .= "WHEN t1.status = 'suspended' THEN 3 ";
            $case .= "WHEN t1.status = 'cancelled' THEN 4 ";
            $case .= "ELSE 5 ";
            $case .= "END AS sort_rank";

            $select     = [
                't1.id',
                't1.type',
                't1.name',
                't1.options',
                't1.status',
                't2.full_name AS user_name',
                $case,
            ];


            $stmt       = $this->db->select(implode(",",$select))->from("users_products AS t1");
            $stmt->join("LEFT","users AS t2",'t2.id=t1.owner_id');

            if($domain)
                $stmt->where("t1.type","=","domain","&&");
            else
                $stmt->where("t1.type","!=","domain","&&");

            $stmt->where("(");
            if($is_int && $term_int) $stmt->where("t1.id","=",$term_int,"||");
            $stmt->where("t1.options","LIKE",'%"domain":"'.$term.'"%',"||");
            $stmt->where("t1.options","LIKE",'%"hostname":"'.$term.'"%',"||");
            $stmt->where("t1.options","LIKE",'%"ip":"'.$term.'"%',"||");
            $stmt->where("t1.options","LIKE",'%'.$term.'%',"||");
            if($term != "none") $stmt->where("t1.module","=",$term,"||");

            $stmt->where("(SELECT id FROM ".$this->pfx."users_products_subscriptions WHERE id=t1.subscription_id AND identifier LIKE '%".$term."%' LIMIT 1)",">","0","||");

            $stmt->where("t1.name","LIKE","%".$term."%");
            $stmt->where(")");

            $stmt->group_by("t1.id");
            $stmt->order_by("sort_rank ASC,t1.renewaldate DESC,t1.id DESC");
            $stmt->limit(50);

            return $stmt->build() ? $stmt->fetch_assoc() : [];
        }
        public function smartSearch_orders_addons($term='',$pre_orders=[]){
            if(!$term) return [];
            $term       = trim($term);
            $is_int     = $term && Validation::isInt($term);
            $term_int   = (int) Filter::numbers($term);

            $ids        = [];

            if($pre_orders) foreach($pre_orders AS $p_o) $ids[] = $p_o["id"];
            $ids        = implode(",",$ids);

            $case = "CASE ";
            $case .= "WHEN t1.status = 'waiting' THEN 0 ";
            $case .= "WHEN t1.status = 'inprocess' THEN 1 ";
            $case .= "WHEN t1.status = 'active' THEN 2 ";
            $case .= "WHEN t1.status = 'suspended' THEN 3 ";
            $case .= "WHEN t1.status = 'cancelled' THEN 4 ";
            $case .= "ELSE 5 ";
            $case .= "END AS sort_rank";

            $select     = [
                't1.id',
                't1.type',
                't1.name',
                't1.options',
                't1.status',
                't2.full_name AS user_name',
                $case,
            ];

            $stmt       = $this->db->select(implode(",",$select))->from("users_products_addons AS t3");
            $stmt->join("LEFT","users_products AS t1",'t3.owner_id=t1.id');
            $stmt->join("LEFT","users AS t2",'t2.id=t1.owner_id');

            $stmt->where("t1.id","IS NOT NULL","","&&");
            $stmt->where("t1.type","!=","domain","&&");
            $stmt->where("!FIND_IN_SET(t1.id,'".$ids."')","","","&&");

            $stmt->where("(");
            $stmt->where("t3.addon_name","LIKE",'%'.$term.'%',"||");
            $stmt->where("t3.option_name","LIKE",'%'.$term.'%');
            $stmt->where(")");

            $stmt->group_by("t1.id");
            $stmt->order_by("sort_rank ASC,t1.renewaldate DESC,t1.id DESC");
            $stmt->limit(50);
            return $stmt->build() ? $stmt->fetch_assoc() : [];
        }
        public function smartSearch_invoices($term=''){
            if(!$term) return [];
            $term       = trim($term);
            $is_int     = $term && Validation::isInt($term);
            $term_int   = (int) Filter::numbers($term);

            $case       = "CASE ";
            $case       .= "WHEN t2.status='waiting' THEN 0 ";
            $case       .= "WHEN t2.status='unpaid' THEN 1 ";
            $case       .= "WHEN t2.status='paid' THEN 2 ";
            $case       .= "WHEN t2.status='refund' THEN 3 ";
            $case       .= "WHEN t2.status='cancelled' THEN 4 ";
            $case       .= "ELSE 5 ";
            $case       .= "END AS sort_rank";

            $select     = [
                't1.description',
                't2.id',
                't2.status',
                't3.full_name AS user_name',
                $case,
            ];


            $stmt       = $this->db->select(implode(",",$select))->from("invoices_items AS t1");
            $stmt->join("LEFT","invoices AS t2",'t2.id=t1.owner_id');
            $stmt->join("LEFT","users AS t3",'t2.id IS NOT NULL AND t3.id=t2.user_id');

            if($is_int && $term_int) $stmt->where("t1.owner_id","=",$term_int,"||");

            $stmt->where("t1.description","LIKE","%".$term."%");

            $stmt->order_by("sort_rank ASC,t2.id DESC,t2.cdate DESC");
            $stmt->group_by("t1.owner_id");
            $stmt->limit(50);

            return $stmt->build() ? $stmt->fetch_assoc() : [];
        }
        public function smartSearch_users($term=''){
            if(!$term) return [];
            $term       = trim($term);
            $is_int     = $term && Validation::isInt($term);
            $term_int   = (int) Filter::numbers($term);

            $case       = "CASE ";
            $case       .= "WHEN status='active' THEN 0 ";
            $case       .= "ELSE 1 ";
            $case       .= "END AS rank";

            $select     = [
                't1.id',
                't1.status',
                't1.full_name',
                't1.company_name',
                't1.email',
                "t1.phone",
                $case,
            ];


            $stmt       = $this->db->select(implode(",",$select))->from("users AS t1");

            $stmt->where("t1.type","=","member","&&");

            $stmt->where("(");

            if($is_int && $term_int) $stmt->where("t1.id","=",$term_int,"||");

            if($is_int && $term_int) $stmt->where("t1.phone","LIKE","%".$term_int."%","||");

            $stmt->where("t1.email","LIKE","%".$term."%","||");

            $stmt->where("t1.company_name","LIKE","%".$term."%","||");

            if(filter_var($term,FILTER_VALIDATE_IP)){
                $stmt->where("t1.ip","=",$term,"||");
                $stmt->where("(SELECT id FROM ".$this->pfx."users_last_logins WHERE owner_id=t1.id AND ip='".$term."' LIMIT 1)","IS NOT NULL","","||");
            }

            $stmt->where("t1.full_name","LIKE","%".$term."%");

            $stmt->where(")");

            $stmt->order_by("rank ASC,t1.creation_time DESC");

            $stmt->limit(50);

            return $stmt->build() ? $stmt->fetch_assoc() : [];
        }
        public function smartSearch_tickets($term=''){
            if(!$term) return [];
            $term       = trim($term);
            $is_int     = $term && Validation::isInt($term);
            $term_int   = (int) Filter::numbers($term);

            $case       = "CASE ";
            $case       .= "WHEN t2.status='waiting' THEN 0 ";
            $case       .= "WHEN t2.status='process' THEN 1 ";
            $case       .= "WHEN t2.status='replied' THEN 2 ";
            $case       .= "ELSE 3 ";
            $case       .= "END AS rank";

            $select     = [
                't2.status',
                't2.id',
                't2.title',
                't3.full_name AS user_name',
                $case,
            ];


            $stmt       = $this->db->select(implode(",",$select))->from("tickets_replies AS t1");
            $stmt->join("LEFT","tickets AS t2","t2.id=t1.owner_id");
            $stmt->join("LEFT","users AS t3","t2.id IS NOT NULL AND t3.id=t2.user_id");

            if($is_int && $term_int) $stmt->where("t1.owner_id","=",$term_int,"||");

            $stmt->where("t2.title","LIKE","%".$term."%","||");

            $stmt->where("t1.message","LIKE","%".$term."%");


            $stmt->order_by("rank ASC,t2.lastreply DESC,t2.id DESC");

            $stmt->group_by("t1.owner_id");

            $stmt->limit(50);

            return $stmt->build() ? $stmt->fetch_assoc() : [];
        }

    }