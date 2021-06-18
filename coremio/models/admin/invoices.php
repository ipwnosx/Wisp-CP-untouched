<?php
    defined('CORE_FOLDER') OR exit('You can not get in here!');
    class Model extends Models
    {
        function __construct()
        {
            parent::__construct();
        }

        public function delete_inex($id=0){
            return $this->db->delete("income_expense")->where("id","=",$id)->run();
        }

        public function set_inex($id=0,$data=[]){
            return $this->db->update("income_expense",$data)->where("id","=",$id)->save();
        }

        public function insert_inex($data=[]){
            return $this->db->insert("income_expense",$data) ? $this->db->lastID() : false;
        }

        public function get_cash_list($searches='',$orders=[],$start=0,$end=1){
            $stmt   = $this->db->select()->from("income_expense");
            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $invoice_id = (int) ltrim($word,"#");

                    $stmt->where("(");
                    if($invoice_id) $stmt->where("invoice_id","=",$invoice_id,"||");
                    $stmt->where("description","LIKE","%".$word."%");
                    $stmt->where(")","","","&&");
                }
                if(isset($searches["start"]) && isset($searches["end"]))
                    $stmt
                        ->where("(")
                        ->where("cdate","LIKE","%".$searches["start"]."%","||")
                        ->where("(cdate BETWEEN '".$searches["start"]."' AND '".$searches["end"]."')","","","||")
                        ->where("cdate","LIKE","%".$searches["end"]."%")
                        ->where(")","","","&&");
                elseif(isset($searches["start"]))
                    $stmt->where("cdate","LIKE","%".$searches["start"]."%","&&");
                elseif(isset($searches["end"]))
                    $stmt->where("cdate","LIKE","%".$searches["end"]."%","&&");
            }
            $stmt->where("id","!=","0");
            $stmt->order_by("id DESC");
            $stmt->limit($start,$end);
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function get_cash_list_total($searches=[]){
            $stmt   = $this->db->select("id")->from("income_expense");
            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $invoice_id = (int) ltrim($word,"#");

                    $stmt->where("(");
                    if($invoice_id) $stmt->where("invoice_id","=",$invoice_id,"||");
                    $stmt->where("description","LIKE","%".$word."%");
                    $stmt->where(")","","","&&");
                }
                if(isset($searches["start"]) && isset($searches["end"]))
                    $stmt
                        ->where("(")
                        ->where("cdate","LIKE","%".$searches["start"]."%","||")
                        ->where("(cdate BETWEEN '".$searches["start"]."' AND '".$searches["end"]."')","","","||")
                        ->where("cdate","LIKE","%".$searches["end"]."%")
                        ->where(")","","","&&");
                elseif(isset($searches["start"]))
                    $stmt->where("cdate","LIKE","%".$searches["start"]."%","&&");
                elseif(isset($searches["end"]))
                    $stmt->where("cdate","LIKE","%".$searches["end"]."%","&&");
            }
            $stmt->where("id","!=","0");

            return $stmt->build() ? $stmt->rowCounter() : 0;
        }

        public function get_bills($status='',$user_id=0,$searches='',$orders=[],$start=0,$end=1){

            if(isset($searches["start"]) && $searches["start"])
                $searches["start"] = DateManager::old_date([$searches["start"],"day" => 1],'Y-m-d');

            if(isset($searches["end"]) && $searches["end"])
                $searches["end"] = DateManager::next_date([$searches["end"],"day" => 1],'Y-m-d');

            $case = "CASE ";
            $case .= "WHEN t1.status = 'waiting' THEN 0 ";
            $case .= "WHEN t1.status = 'unpaid' THEN 1 ";
            $case .= "WHEN t1.status = 'paid' THEN 2 ";
            $case .= "ELSE 3 ";
            $case .= "END AS rank";

            $select =  implode(",",[
                't1.*',
                $case,
            ]);
            $stmt   = $this->db->select($select)->from("invoices AS t1");

            if($user_id) $stmt->where("t1.user_id","=",$user_id,"&&");

            if($searches){
                if(isset($searches["start"]) && isset($searches["end"]))
                    $stmt
                        ->where("(")
                        ->where("t1.datepaid","LIKE","%".$searches["start"]."%","||")
                        ->where("t1.datepaid BETWEEN '".$searches["start"]."' AND '".$searches["end"]."'","","","||")
                        ->where("t1.datepaid","LIKE","%".$searches["end"]."%")
                        ->where(")","","","&&");

                if(isset($searches["taxed"])) $stmt->where("t1.legal","=","1","&&")->where("t1.taxed","=","1","&&");

                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $invoice_id = (int) ltrim($word,"#");

                    $stmt->where("(");
                    if($invoice_id) $stmt->where("t1.id","=",$invoice_id,"||");
                    $stmt->where("t1.number","LIKE","%".$word."%","||");
                    $stmt->where("t1.user_data","LIKE","%".$word."%");
                    $stmt->where(")","","","&&");
                }
            }

            if($status == "paid")
                $stmt->where("t1.status","=",$status,"&&");
            elseif($status == "cancelled-refund")
                $stmt->where("(","","","")
                    ->where("t1.status","=","cancelled","||")
                    ->where("t1.status","=","refund")
                    ->where(")","","","&&");
            elseif($status == "unpaid")
                $stmt->where("(","","","")
                    ->where("t1.status","=","unpaid","||")
                    ->where("t1.status","=","waiting")
                    ->where(")","","","&&");
            elseif($status == "taxed")
                $stmt->where("t1.taxed","=","1","&&")->where("t1.legal","=","1","&&");
            elseif($status == "untaxed")
                $stmt
                    ->where("t1.legal","=","1","&&")
                    ->where("t1.status","=","paid","&&")
                    ->where("t1.taxed","=","0","&&");
            elseif($status == "upcoming")
                $stmt
                    ->where("t1.duedate",">=",DateManager::Now(),"&&")
                    ->where("t1.duedate","<=",DateManager::next_date(['day' => 8]),"&&")
                    ->where("t1.status","=","unpaid","&&");
            elseif($status == "overdue")
                $stmt
                    ->where("t1.duedate","<",DateManager::Now(),"&&")
                    ->where("t1.status","=","unpaid","&&");

            $stmt->where("t1.id","IS NOT NULL");

            $stmt->group_by("t1.id");
            if($status == "overdue" || $status == "upcoming")
                $stmt->order_by("t1.duedate ASC");
            elseif($status == "cancelled-refund")
                $stmt->order_by("t1.duedate DESC");
            else
                $stmt->order_by("rank ASC,t1.datepaid DESC,t1.id DESC");
            $stmt->limit($start,$end);

            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function get_bills_total($status='',$user_id=0,$searches=[]){
            $select =  "t1.id";
            $stmt   = $this->db->select($select)->from("invoices AS t1");

            if($user_id) $stmt->where("t1.user_id","=",$user_id,"&&");

            if($searches){

                if(isset($searches["start"]) && isset($searches["end"]))
                    $stmt
                        ->where("(")
                        ->where("t1.datepaid","LIKE","%".$searches["start"]."%","||")
                        ->where("(t1.datepaid BETWEEN '".$searches["start"]."' AND '".$searches["end"]."')","","","||")
                        ->where("t1.datepaid","LIKE","%".$searches["end"]."%")
                        ->where(")","","","&&");

                if(isset($searches["taxed"])) $stmt->where("t1.legal","=","1","&&")->where("t1.taxed","=","1","&&");

                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $invoice_id = (int) ltrim($word,"#");

                    $stmt->where("(");
                    if($invoice_id) $stmt->where("t1.id","=",$invoice_id,"||");
                    $stmt->where("t1.number","LIKE","%".$word."%","||");
                    $stmt->where("t1.user_data","LIKE","%".$word."%");
                    $stmt->where(")","","","&&");
                }
            }

            if($status == "paid")
                $stmt->where("t1.status","=",$status,"&&");
            elseif($status == "cancelled-refund")
                $stmt->where("(","","","")
                    ->where("t1.status","=","cancelled","||")
                    ->where("t1.status","=","refund")
                    ->where(")","","","&&");
            elseif($status == "unpaid")
                $stmt->where("(","","","")
                    ->where("t1.status","=","unpaid","||")
                    ->where("t1.status","=","waiting")
                    ->where(")","","","&&");
            elseif($status == "taxed")
                $stmt->where("t1.taxed","=","1","&&")->where("t1.legal","=","1","&&");
            elseif($status == "untaxed")
                $stmt
                    ->where("t1.legal","=","1","&&")
                    ->where("t1.status","=","paid","&&")
                    ->where("t1.taxed","=","0","&&");
            elseif($status == "upcoming")
                $stmt
                    ->where("t1.duedate",">=",DateManager::Now(),"&&")
                    ->where("t1.duedate","<=",DateManager::next_date(['day' => 8]),"&&")
                    ->where("t1.status","=","unpaid","&&");
            elseif($status == "overdue")
                $stmt
                    ->where("t1.duedate","<",DateManager::Now(),"&&")
                    ->where("t1.status","=","unpaid","&&");

            $stmt->where("t1.id","IS NOT NULL");

            $stmt->group_by("t1.id");
            return $stmt->build() ? $stmt->rowCounter() : 0;
        }

        public function get_paid_taxes($user_id=0,$word='',$start='',$end=''){
            $stmt   = $this->db->select("COUNT(t1.id) AS total_bill,SUM(t1.tax) AS sum_tax,t1.currency")->from("invoices AS t1");
            $stmt->where("t1.taxed","=","1","&&");
            $stmt->where("t1.legal","=","1","&&");
            if($user_id) $stmt->where("t1.user_id","=",$user_id,"&&");
            if($word){
                $stmt->join("INNER","invoices_items AS t2","t2.owner_id=t1.id");
                $stmt->where("t2.description","LIKE","%".$word."%","&&");
            }
            if($start && $end) $stmt->where("(")
                ->where("t1.datepaid","LIKE","%".$start."%","||")
                ->where("(t1.datepaid BETWEEN '".$start."' AND '".$end."')","","","||")
                ->where("t1.datepaid","LIKE","%".$end."%")
                ->where(")","","");
            else $stmt->where("t1.datepaid","LIKE","%".$start."%");
            $stmt->group_by("t1.currency");
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }
        public function get_total_unpaid($status=''){
            $stmt   = $this->db->select("COUNT(t1.id) AS b_count,SUM(t1.total) AS b_total,t1.currency")->from("invoices AS t1");
            if($status == "upcoming")
                $stmt
                    ->where("t1.duedate",">=",DateManager::Now(),"&&")
                    ->where("t1.duedate","<=",DateManager::next_date(['day' => 8]),"&&")
                    ->where("t1.status","=","unpaid");
            elseif($status == "overdue")
                $stmt
                    ->where("t1.duedate","<",DateManager::Now(),"&&")
                    ->where("t1.status","=","unpaid");
            else
                $stmt->where("status","=","unpaid");

            $stmt->group_by("t1.currency");
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function get_inex_amount($type='',$word='',$start='',$end=''){
            $stmt   = $this->db->select("SUM(amount) AS sum_total,currency")->from("income_expense");
            $stmt->where("type","=",$type,"&&");
            if($word) $stmt->where("description","LIKE","%".$word."%","&&");
            if($start && $end) $stmt->where("(")
                ->where("cdate","LIKE","%".$start."%","||")
                ->where("(cdate BETWEEN '".$start."' AND '".$end."')","","","||")
                ->where("cdate","LIKE","%".$end."%")
                ->where(")","","","&&");
            else $stmt->where("cdate","LIKE","%".$start."%","&&");
            $stmt->where("currency","!=","0");
            $stmt->group_by("currency");
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function get_this_inex_amount($type=''){
            $stmt   = $this->db->select("SUM(amount) AS sum_total,currency")->from("income_expense");
            $stmt->where("type","=",$type);
            $stmt->group_by("currency");
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function get_periodic_outgoings(){
            $stmt   = $this->db->select()->from("periodic_outgoings");
            return $stmt->build() ? $stmt->fetch_assoc() : [];
        }

    }