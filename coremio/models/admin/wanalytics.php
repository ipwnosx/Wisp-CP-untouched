<?php
    defined('CORE_FOLDER') OR exit('You can not get in here!');
    class Model extends Models
    {
        function __construct()
        {
            parent::__construct();
        }

        public function get_product_special_groups($lang=''){
            if(!$lang) $lang = Config::get("general/local");
            $stmt = $this->db->select("c.id,cl.title")->from("categories AS c");
            $stmt->join("LEFT","categories_lang AS cl","cl.owner_id=c.id AND cl.lang='".$lang."'");
            $stmt->where("cl.id","IS NOT NULL","","&&");
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

        public function get_tlds(){
            $stmt   = $this->db->select("id,name")->from("tldlist");
            $stmt->order_by("id DESC");
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function get_online_client_count(){
            $select = ['COUNT(id) AS count'];
            $sth = $this->db->select(implode(",",$select))->from("users");
            $sth->where("type","=","member","&&");
            $sth->where("'".DateManager::Now()."' < online");
            return $sth->build() ? $sth->getObject()->count : 0;
        }

        public function get_online_client_cities($lang=''){
            $select = [
                'COUNT(ull.city) AS count',
                'ull.country_code',
                'ull.city AS city_name',
                'ctsl.name AS country_name',
                'ull.latlng',
            ];
            $sth = $this->db->select(implode(",",$select))->from("users AS t1");
            $sth->join("LEFT","users_last_logins AS ull",'ull.id=(SELECT ullx.id FROM '.$this->pfx.'users_last_logins AS ullx WHERE ullx.owner_id=t1.id ORDER BY ullx.id DESC LIMIT 1)');
            $sth->join("LEFT","countries AS cts",'cts.a2_iso=UPPER(ull.country_code)');
            $sth->join("LEFT","countries_lang AS ctsl","ctsl.owner_id=cts.id AND ctsl.lang='".$lang."'");
            $sth->where("t1.type","=","member","&&");
            $sth->where("ull.id","IS NOT NULL","","&&");
            $sth->where("ull.latlng","IS NOT NULL","","&&");
            $sth->where("ull.latlng","!=","","&&");
            $sth->where("'".DateManager::Now()."' < t1.online");
            $sth->group_by("ull.city");
            return $sth->build() ? $sth->fetch_assoc() : [];
        }

        public function get_online_client_list($lang=''){
            $select = [
                't1.id',
                't1.full_name',
                'ull.city AS city_name',
                'ctsl.name AS country_name',
                'uis.content AS last_visited_page',
            ];
            $sth = $this->db->select(implode(",",$select))->from("users AS t1");
            $sth->join("LEFT","users_last_logins AS ull",'ull.id=(SELECT ullx.id FROM '.$this->pfx.'users_last_logins AS ullx WHERE ullx.owner_id=t1.id ORDER BY ullx.id DESC LIMIT 1)');
            $sth->join("LEFT","countries AS cts",'cts.a2_iso=UPPER(ull.country_code)');
            $sth->join("LEFT","countries_lang AS ctsl","ctsl.owner_id=cts.id AND ctsl.lang='".$lang."'");
            $sth->join("LEFT","users_informations AS uis","uis.owner_id=t1.id AND uis.name='last_visited_page'");
            $sth->where("t1.type","=","member","&&");
            $sth->where("ull.id","IS NOT NULL","","&&");
            $sth->where("ull.latlng","IS NOT NULL","","&&");
            $sth->where("ull.latlng","!=","","&&");
            $sth->where("'".DateManager::Now()."' < t1.online");
            $sth->order_by("t1.last_login_time DESC");
            return $sth->build() ? $sth->fetch_assoc() : [];
        }

        public function get_clients_overview($from='',$to=''){
            $select = [
                "DATE_FORMAT(creation_time,'%Y-%m-%d') AS date",
                "COUNT(DATE_FORMAT(creation_time,'%Y-%m-%d')) as count",
            ];

            $stmt   = $this->db->select(implode(",",$select))->from("users");
            if($from && $to)
                $stmt->where("DATE_FORMAT(creation_time,'%Y-%m-%d') BETWEEN '".$from."' AND '".$to."'",'','','&&');
            $stmt->where("type","=","member");
            $stmt->group_by("DATE_FORMAT(creation_time,'%Y-%m-%d')");
            $stmt->order_by("creation_time ASC");
            return $stmt->build() ? $stmt->fetch_assoc() : [];
        }
        public function get_clients_by_languages($from='',$to='',$lang=''){
            $select = [
                "lang",
                "COUNT(lang) as count",
            ];

            $stmt   = $this->db->select(implode(",",$select))->from("users");
            if($from && $to)
                $stmt->where("DATE_FORMAT(creation_time,'%Y-%m-%d') BETWEEN '".$from."' AND '".$to."'",'','','&&');
            if($lang) $stmt->where("lang","=",$lang,"&&");
            $stmt->where("type","=","member");
            $stmt->group_by("lang");
            return $stmt->build() ? $stmt->fetch_assoc() : [];
        }
        public function get_clients_by_countries($from='',$to='',$country=0){
            $select = [
                "country",
                "COUNT(country) as count",
            ];

            $stmt   = $this->db->select(implode(",",$select))->from("users");
            if($from && $to)
                $stmt->where("DATE_FORMAT(creation_time,'%Y-%m-%d') BETWEEN '".$from."' AND '".$to."'",'','','&&');
            if($country) $stmt->where("country","=",$country,"&&");
            $stmt->where("type","=","member");
            $stmt->group_by("country");
            return $stmt->build() ? $stmt->fetch_assoc() : [];
        }
        public function get_clients_group_countries(){
            return $this->db
                ->select("country")
                ->from("users")
                ->where("type","=","member")
                ->group_by("country")
                ->build() ? $this->db->fetch_assoc() : [];
        }
        public function get_clients_by_high_trade_volume($currency=0){
            $select = [
                'u.id',
                'u.full_name AS user_name',
                'SUM(bl.total) AS trade_volume',
            ];
            $stmt   = $this->db->select(implode(",",$select))->from("invoices AS bl");
            $stmt->join("LEFT","users AS u",'bl.user_id=u.id');
            $stmt->where('u.id IS NOT NULL','','','&&');
            $stmt->where('u.type','=','member','&&');
            $stmt->where('bl.pmethod','!=','Balance','&&');
            $stmt->where('bl.status','=','paid','&&');
            $stmt->where('bl.currency','=',$currency,'&&');
            $stmt->where('bl.total','>',"0");
            $stmt->group_by("u.id");
            $stmt->order_by("trade_volume DESC");
            return $stmt->build() ? $stmt->fetch_assoc() : [];
        }
        public function get_clients_by_credits_available($currency=0){
            $select = [
                'id',
                'full_name AS user_name',
                'balance',
            ];
            $stmt   = $this->db->select(implode(",",$select))->from("users");
            $stmt->where("type","=","member","&&");
            $stmt->where('balance_currency','=',$currency,'&&');
            $stmt->where('balance','>',"0");
            $stmt->order_by("balance DESC");
            return $stmt->build() ? $stmt->fetch_assoc() : [];
        }
        public function get_clients_blocked(){
            $select = [
                'id',
                'full_name',
            ];
            $stmt   = $this->db->select(implode(",",$select))->from("users");
            $stmt->where("type","=","member","&&");
            $stmt->where('status','!=','active');
            $stmt->order_by("id DESC");
            return $stmt->build() ? $stmt->fetch_assoc() : [];
        }
        public function get_clients_non_orders(){
            $select = [
                'id',
                'full_name',
                'last_login_time',
            ];
            $stmt   = $this->db->select(implode(",",$select))->from("users AS t1");
            $stmt->where("type","=","member","&&");
            $stmt->where("(SELECT COUNT(id) FROM users_products WHERE owner_id=t1.id)",'=','0');
            $stmt->order_by("id DESC");
            return $stmt->build() ? $stmt->fetch_assoc() : [];
        }
        public function get_sales_overview($from='',$to='',$currency=0,$country=0){
            $select = [
                "DATE_FORMAT(bill.datepaid,'%Y-%m-%d') AS date",
                "COUNT(i.id) AS count",
                "SUM(IF( bill.taxrate > 0,i.total_amount+(i.total_amount * bill.taxrate / 100),i.total_amount)) AS total",
            ];

            $stmt   = $this->db->select(implode(",",$select))->from("invoices AS bill");
            $stmt->join("LEFT","invoices_items AS i","i.owner_id=bill.id");
            $stmt->join("LEFT","users_products AS usp","i.user_pid=usp.id");

            $stmt->where("i.id","IS NOT NULL",'','&&');
            $stmt->where("usp.id",'IS NOT NULL','','&&');

            if($from && $to)
                $stmt->where("DATE_FORMAT(bill.datepaid,'%Y-%m-%d') BETWEEN '".$from."' AND '".$to."'",'','','&&');

            if($country) $stmt->where('bill.user_data','LIKE','%"country_id":"'.$country.'"%','&&');

            $stmt->where("bill.currency",'=',$currency,'&&');
            $stmt->where("bill.pmethod",'!=','Balance','&&');
            $stmt->where("i.total_amount",'>','0','&&');
            $stmt->where("bill.status",'=','paid');

            $stmt->group_by("DATE_FORMAT(bill.datepaid,'%Y-%m-%d')");
            $stmt->order_by("bill.datepaid ASC");
            return $stmt->build() ? $stmt->fetch_assoc() : [];
        }
        public function get_sales_overview_group_countries($from='',$to='',$currency=0){
            $select = [
                "usr.country",
            ];

            $stmt   = $this->db->select(implode(",",$select))->from("invoices AS bill");
            $stmt->join("LEFT","invoices_items AS i","i.owner_id=bill.id");
            $stmt->join("LEFT","users_products AS usp","i.user_pid=usp.id");
            $stmt->join("LEFT","users AS usr",'bill.user_id=usr.id');

            $stmt->where("i.id","IS NOT NULL",'','&&');
            $stmt->where("usp.id",'IS NOT NULL','','&&');
            $stmt->where("usr.id",'IS NOT NULL','','&&');

            if($from && $to)
                $stmt->where("DATE_FORMAT(bill.datepaid,'%Y-%m-%d') BETWEEN '".$from."' AND '".$to."'",'','','&&');

            $stmt->where("bill.currency",'=',$currency,'&&');
            $stmt->where("bill.pmethod",'!=','Balance','&&');
            $stmt->where("i.total_amount",'>','0','&&');
            $stmt->where("bill.status",'=','paid');

            $stmt->group_by("usr.country");
            return $stmt->build() ? $stmt->fetch_assoc() : [];
        }
        public function get_sales_product_based($from='',$to='',$currency=0,$country=0,$product=[],$period=[],$status=''){
            if($status == 'cancelled'){
                $select = [
                    "usp.duedate AS date",
                    "COUNT(usp.id) AS count",
                    "SUM(usp.total_amount) AS total",
                ];

                $stmt   = $this->db->select(implode(",",$select))->from("users_products AS usp");

                if($from && $to)
                    $stmt->where("DATE_FORMAT(usp.duedate,'%Y-%m-%d') BETWEEN '".$from."' AND '".$to."'",'','','&&');

                if($product){
                    $stmt->where("usp.type","=",$product["type"],"&&");
                    $stmt->where("usp.product_id","=",$product["id"],"&&");
                }

                if($period){
                    $stmt->where("(");
                    $stmt->where("usp.period","=",$period["period"],"&&");
                    $stmt->where("FIND_IN_SET(usp.period_time,'0,".$period["time"]."')");
                    $stmt->where(")",'','','&&');
                }

                if($status) $stmt->where("usp.status","=",$status,'&&');

                $stmt->where("usp.amount_cid",'=',$currency,'&&');
                $stmt->where("usp.pmethod",'!=','Balance','&&');
                $stmt->where("usp.total_amount",'>','0');

                $stmt->group_by("DATE_FORMAT(usp.duedate,'%Y-%m-%d')");
                $stmt->order_by("usp.duedate ASC");
                return $stmt->build() ? $stmt->fetch_assoc() : [];
            }
            else{
                $select = [
                    "DATE_FORMAT(IF(bill.datepaid = '1881-05-19',bill.duedate,bill.datepaid),'%Y-%m-%d') AS date",
                    "COUNT(i.id) AS count",
                    "SUM(IF( bill.taxrate > 0,i.total_amount+(i.total_amount * bill.taxrate / 100),i.total_amount)) AS total",
                ];

                $stmt   = $this->db->select(implode(",",$select))->from("invoices AS bill");
                $stmt->join("LEFT","invoices_items AS i","i.owner_id=bill.id");
                $stmt->join("LEFT","users_products AS usp","i.user_pid=usp.id");

                $stmt->where("i.id","IS NOT NULL",'','&&');
                $stmt->where("usp.id",'IS NOT NULL','','&&');

                if($from && $to)
                    $stmt->where("DATE_FORMAT(bill.datepaid,'%Y-%m-%d') BETWEEN '".$from."' AND '".$to."'",'','','&&');

                if($country) $stmt->where('bill.user_data','LIKE','%"country_id":"'.$country.'"%','&&');

                if($product){
                    $stmt->where("usp.type","=",$product["type"],"&&");
                    $stmt->where("usp.product_id","=",$product["id"],"&&");
                }

                if($period){
                    $stmt->where("(");

                    $stmt->where("(");
                    $stmt->where("usp.period","=",$period["period"],"&&");
                    $stmt->where("FIND_IN_SET(usp.period_time,'0,".$period["time"]."')");
                    $stmt->where(")",'','','||');

                    $stmt->where("(");
                    $stmt->where("i.options","LIKE",'"period":"'.$period["period"].'","time":"'.$period["time"].'"',"||");
                    $stmt->where("i.options","LIKE",'"period":"'.$period["period"].'","period_time":"'.$period["time"].'"',"||");
                    $stmt->where("i.options","LIKE",'"period":"'.$period["period"].'","period_time":'.$period["time"].',',"");
                    $stmt->where(")");

                    $stmt->where(")","","","&&");
                }

                if($status) $stmt->where("usp.status","=",$status,'&&');

                $stmt->where("bill.currency",'=',$currency,'&&');
                $stmt->where("bill.pmethod",'!=','Balance','&&');
                $stmt->where("i.total_amount",'>','0','&&');
                if($status == 'cancelled')
                    $stmt->where("bill.status",'=','cancelled');
                else
                    $stmt->where("bill.status",'=','paid');

                $stmt->group_by("DATE_FORMAT(bill.datepaid,'%Y-%m-%d')");
                $stmt->order_by("bill.datepaid ASC");
                return $stmt->build() ? $stmt->fetch_assoc() : [];
            }
        }
        public function get_sales_product_based_group_countries($from='',$to='',$currency=0,$product=[],$period=[],$status=''){
            $select = [
                "usr.country",
            ];

            $stmt   = $this->db->select(implode(",",$select))->from("invoices AS bill");
            $stmt->join("LEFT","invoices_items AS i","i.owner_id=bill.id");
            $stmt->join("LEFT","users_products AS usp","i.user_pid=usp.id");
            $stmt->join("LEFT","users AS usr",'bill.user_id=usr.id');

            $stmt->where("i.id","IS NOT NULL",'','&&');
            $stmt->where("usp.id",'IS NOT NULL','','&&');
            $stmt->where("usr.id",'IS NOT NULL','','&&');

            if($from && $to)
                $stmt->where("DATE_FORMAT(bill.datepaid,'%Y-%m-%d') BETWEEN '".$from."' AND '".$to."'",'','','&&');

            if($product){
                $stmt->where("usp.type","=",$product["type"],"&&");
                $stmt->where("usp.product_id","=",$product["id"],"&&");
            }

            if($period){
                $stmt->where("(");

                $stmt->where("(");
                $stmt->where("usp.period","=",$period["period"],"&&");
                $stmt->where("FIND_IN_SET(usp.period_time,'0,".$period["time"]."')");
                $stmt->where(")",'','','||');

                $stmt->where("(");
                $stmt->where("i.options","LIKE",'"period":"'.$period["period"].'","time":"'.$period["time"].'"',"||");
                $stmt->where("i.options","LIKE",'"period":"'.$period["period"].'","period_time":"'.$period["time"].'"',"||");
                $stmt->where("i.options","LIKE",'"period":"'.$period["period"].'","period_time":'.$period["time"].',',"");
                $stmt->where(")");

                $stmt->where(")","","","&&");
            }

            if($status) $stmt->where("usp.status","=",$status,'&&');

            $stmt->where("bill.currency",'=',$currency,'&&');
            $stmt->where("bill.pmethod",'!=','Balance','&&');
            $stmt->where("i.total_amount",'>','0','&&');
            if($status == 'cancelled')
                $stmt->where("bill.status",'=','cancelled');
            else
                $stmt->where("bill.status",'=','paid');

            $stmt->group_by("usr.country");
            return $stmt->build() ? $stmt->fetch_assoc() : [];
        }
        public function get_financial_invoices($from='',$to='',$currency=0,$country=0,$status='cancelled',$method=''){
            $select = [
                $status == 'paid' ? 
                "DATE_FORMAT(bill.datepaid,'%Y-%m-%d') AS date" : 
                "DATE_FORMAT(bill.cdate,'%Y-%m-%d') AS date",
                "COUNT(bill.id) AS count",
                "SUM(bill.total) AS total",
            ];

            $stmt   = $this->db->select(implode(",",$select))->from("invoices AS bill");

            if($status == 'paid' && $from && $to)
                $stmt->where("DATE_FORMAT(bill.datepaid,'%Y-%m-%d') BETWEEN '".$from."' AND '".$to."'",'','','&&');
            elseif($from && $to)
                $stmt->where("DATE_FORMAT(bill.cdate,'%Y-%m-%d') BETWEEN '".$from."' AND '".$to."'",'','','&&');


            if($country) $stmt->where('bill.user_data','LIKE','%"country_id":"'.$country.'"%','&&');

            $stmt->where("bill.currency",'=',$currency,'&&');
            $stmt->where("bill.total",'>','0','&&');

            if($method)
                $stmt->where("bill.pmethod","=",$method,"&&");
            else
                $stmt->where("bill.pmethod",'!=','Balance','&&');

            $stmt->where("bill.status",'=',$status);

            if($status == "paid")
                $stmt->group_by("DATE_FORMAT(bill.datepaid,'%Y-%m-%d')");
            else
                $stmt->group_by("DATE_FORMAT(bill.cdate,'%Y-%m-%d')");
            $stmt->order_by("bill.cdate ASC");
            return $stmt->build() ? $stmt->fetch_assoc() : [];
        }
        public function get_financial_invoices_group_countries($from='',$to='',$currency=0,$status='cancelled',$method=''){
            $select = [
                "usr.country",
            ];

            $stmt   = $this->db->select(implode(",",$select))->from("invoices AS bill");
            $stmt->join("LEFT","users AS usr",'bill.user_id=usr.id');
            $stmt->where("usr.id",'IS NOT NULL','','&&');

            if($status == 'paid' && $from && $to)
                $stmt->where("DATE_FORMAT(bill.datepaid,'%Y-%m-%d') BETWEEN '".$from."' AND '".$to."'",'','','&&');
            elseif($from && $to)
                $stmt->where("DATE_FORMAT(bill.cdate,'%Y-%m-%d') BETWEEN '".$from."' AND '".$to."'",'','','&&');

            $stmt->where("bill.currency",'=',$currency,'&&');
            $stmt->where("bill.pmethod",'!=','Balance','&&');
            $stmt->where("bill.total",'>','0','&&');

            if($method) $stmt->where("bill.pmethod","=",$method,"&&");

            $stmt->where("bill.status",'=',$status);

            $stmt->group_by("usr.country");
            return $stmt->build() ? $stmt->fetch_assoc() : [];
        }
        public function get_financial_inex_reports($type='income',$from='',$to='',$currency=0){
            $select = [
                "DATE_FORMAT(cdate,'%Y-%m-%d') AS date",
                "COUNT(id) AS count",
                "SUM(amount) AS total",
            ];

            $stmt   = $this->db->select(implode(",",$select))->from("income_expense");

            if($from && $to)
                $stmt->where("DATE_FORMAT(cdate,'%Y-%m-%d') BETWEEN '".$from."' AND '".$to."'",'','','&&');

            $stmt->where("currency",'=',$currency,'&&');
            $stmt->where("amount",'>','0','&&');
            $stmt->where("type",'=',$type);

            $stmt->group_by("DATE_FORMAT(cdate,'%Y-%m-%d')");
            $stmt->order_by("cdate ASC");
            return $stmt->build() ? $stmt->fetch_assoc() : [];
        }
        public function get_financial_profit_loss_analysis($from='',$to='',$currency=0){
            $select = [
                "DATE_FORMAT(cdate,'%Y-%m-%d') AS date",
                "SUM(IF(type = 'income',1,0)) AS income_count",
                "SUM(IF(type = 'expense',1,0)) AS expense_count",
                "SUM(IF(type = 'income',amount,0)) AS income",
                "SUM(IF(type = 'expense',amount,0)) AS expense",
                "(SUM(IF(type = 'income',amount,0)) - SUM(IF(type = 'expense',amount,0))) AS total",
            ];

            $stmt   = $this->db->select(implode(",",$select))->from("income_expense");

            if($from && $to)
                $stmt->where("DATE_FORMAT(cdate,'%Y-%m-%d') BETWEEN '".$from."' AND '".$to."'",'','','&&');

            $stmt->where("currency",'=',$currency,'&&');
            $stmt->where("amount",'>','0');

            $stmt->group_by("DATE_FORMAT(cdate,'%Y-%m-%d')");
            $stmt->order_by("cdate ASC");
            return $stmt->build() ? $stmt->fetch_assoc() : [];
        }
        public function get_financial_vat_accrual($from='',$to='',$currency=0){
            $select = [
                "DATE_FORMAT(bill.datepaid,'%Y-%m-%d') AS date",
                "COUNT(bill.id) AS count",
                "SUM(bill.tax) AS total",
            ];

            $stmt   = $this->db->select(implode(",",$select))->from("invoices AS bill");

            if($from && $to)
                $stmt->where("DATE_FORMAT(bill.datepaid,'%Y-%m-%d') BETWEEN '".$from."' AND '".$to."'",'','','&&');

            $stmt->where("bill.currency",'=',$currency,'&&');
            $stmt->where("bill.tax",'>','0','&&');

            $stmt->where("bill.status",'=','paid','&&');
            $stmt->where("bill.taxed",'=','1');

            $stmt->group_by("DATE_FORMAT(bill.datepaid,'%Y-%m-%d')");
            $stmt->order_by("bill.datepaid ASC");
            return $stmt->build() ? $stmt->fetch_assoc() : [];
        }
        public function get_tickets_overview($from='',$to='',$product=[]){
            $select = [
                "DATE_FORMAT(t1.ctime,'%Y-%m-%d') AS date",
                "COUNT(DATE_FORMAT(t1.ctime,'%Y-%m-%d')) as count",
            ];

            $stmt   = $this->db->select(implode(",",$select))->from("tickets AS t1");
            $stmt->join("LEFT","users AS usr","t1.user_id=usr.id");
            if($product) $stmt->join("LEFT","users_products AS usp","t1.service=usp.id");

            if($from && $to)
                $stmt->where("DATE_FORMAT(t1.ctime,'%Y-%m-%d') BETWEEN '".$from."' AND '".$to."'",'','','&&');

            if($product){
                $stmt->where("usp.type","=",$product["type"],"&&");
                $stmt->where("usp.product_id","=",$product["id"],"&&");
            }

            $stmt->where("usr.id","IS NOT NULL");

            $stmt->group_by("DATE_FORMAT(t1.ctime,'%Y-%m-%d')");
            $stmt->order_by("t1.ctime ASC");
            return $stmt->build() ? $stmt->fetch_assoc() : [];
        }
        public function get_tickets_client_based($from='',$to=''){
            $select = [
                "t1.ctime AS date",
                "usr.id",
                "usr.full_name",
                "COUNT(t1.id) AS count",
            ];

            $stmt   = $this->db->select(implode(",",$select))->from("tickets AS t1");
            $stmt->join("LEFT","users AS usr","t1.user_id=usr.id");

            if($from && $to)
                $stmt->where("DATE_FORMAT(t1.ctime,'%Y-%m-%d') BETWEEN '".$from."' AND '".$to."'",'','','&&');


            $stmt->where("usr.id","IS NOT NULL");

            $stmt->group_by("usr.id");
            $stmt->order_by("t1.ctime ASC");
            return $stmt->build() ? $stmt->fetch_assoc() : [];
        }


    }