<?php
    Class Events {
        static $message;
        private static $list_limit=false;

        static function get($id=0){
            $stmt   = Models::$init->db->select()->from("events");
            $stmt->where("id","=",$id);
            $data   = $stmt->build() ? $stmt->getAssoc() : false;
            if($data){
                if($data["data"]) $data["data"] = Utility::jdecode($data["data"],true);
            }
            return $data;
        }

        static function getMessage($event=[]){
            $locall     = Config::get("general/local");
            $data       = $event["data"] ? Utility::jdecode($event["data"],true) : [];
            $message    = NULL;
            if($event["owner"] == "order" && $event["name"] == "domain-extend-request"){
                $message = Bootstrap::$lang->get_cm("admin/events/domain-extend-request",[
                    '{start_date}'  => DateManager::format(Config::get("options/date-format"),$data["start"]),
                    '{end_date}'    => DateManager::format(Config::get("options/date-format"),$data["end"]),
                    '{year}'        => $data["year"],
                    '{domain}'      => $data["domain"],
                ],$locall);
            }elseif($event["owner"] == "order" && $event["name"] == "domain-extended"){
                $message = Bootstrap::$lang->get_cm("admin/events/domain-extended",[
                    '{start_date}'  => DateManager::format(Config::get("options/date-format"),$data["start"]),
                    '{end_date}'    => DateManager::format(Config::get("options/date-format"),$data["end"]),
                    '{year}'        => $data["year"],
                    '{domain}'      => $data["domain"],
                ],$locall);
            }elseif($event["owner"] == "order" && $event["name"] == "service-time-renewed"){
                $period = View::period($data["period_time"],$data["period"]);
                $message = Bootstrap::$lang->get_cm("admin/events/service-time-renewed",[
                    '{period}' => $period,
                ],$locall);
            }elseif($event["owner"] == "order-addon" && $event["name"] == "addon-service-time-renewed"){
                $period = View::period($data["period_time"],$data["period"]);
                $message = Bootstrap::$lang->get_cm("admin/events/addon-service-time-renewed",[
                    '{period}' => $period,
                ],$locall);
            }elseif($event["owner"] == "order" && $event["name"] == "modify-domain-transferlock"){
                $message = Bootstrap::$lang->get_cm("admin/events/modify-domain-transferlock-".$data["status"],[
                    '{domain}'      => $data["domain"],
                ],$locall);
            }elseif($event["owner"] == "order" && $event["name"] == "domain-send-transfer-code"){
                $message = Bootstrap::$lang->get_cm("admin/events/domain-send-transfer-code",[
                    '{domain}'      => $data["domain"],
                ],$locall);
            }elseif($event["owner"] == "order" && $event["name"] == "modify-whois-privacy-enable-request"){
                $message = Bootstrap::$lang->get_cm("admin/events/modify-whois-privacy-enable-request",[
                    '{domain}' => $data["domain"],
                ],$locall);
            }elseif($event["owner"] == "order" && $event["name"] == "modify-whois-privacy"){
                $message = Bootstrap::$lang->get_cm("admin/events/modify-whois-privacy-".$data["status"],[
                    '{domain}' => $data["domain"],
                ],$locall);
            }elseif($event["owner"] == "order" && $event["name"] == "modify-domain-dns"){
                $message = Bootstrap::$lang->get_cm("admin/events/modify-domain-dns",[
                    '{domain}' => $data["domain"],
                ],$locall);
            }elseif($event["owner"] == "order" && $event["name"] == "modify-domain-cns"){
                if($data["transaction"] == "add")
                    $message = Bootstrap::$lang->get_cm("admin/events/added-domain-cns",[
                        '{name}' => $data["ns"],
                        '{ip}' => $data["ip"],
                        '{domain}' => $data["domain"],
                    ],$locall);
                elseif($data["transaction"] == "edit")
                    $message = Bootstrap::$lang->get_cm("admin/events/edited-domain-cns",[
                        '{old-name}' => $data["old-ns"],
                        '{old-ip}' => $data["old-ip"],
                        '{new-name}' => $data["new-ns"],
                        '{new-ip}' => $data["new-ip"],
                        '{domain}' => $data["domain"],
                    ],$locall);
                elseif($data["transaction"] == "delete")
                    $message = Bootstrap::$lang->get_cm("admin/events/deleted-domain-cns",[
                        '{name}' => $data["ns"],
                        '{ip}' => $data["ip"],
                        '{domain}' => $data["domain"],
                    ],$locall);
            }elseif($event["owner"] == "order" && $event["name"] == "uploading-new-credit"){
                $message = Bootstrap::$lang->get_cm("admin/events/sms-uploading-new-credit",[
                    '{order_id}' => $data["id"],
                    '{product_name}' => $data["name"],
                ],$locall);
            }elseif($event["owner"] == "order" && $event["name"] == "order-terminate-error"){
                $message = Bootstrap::$lang->get_cm("admin/events/".$event["name"],[
                    '{message}' => $data["message"],
                ],$locall);
            }else
                $message = Bootstrap::$lang->get_cm("admin/events/".$event["name"],[],$locall);

            return $message ? $message : $event["name"];
        }

        static function set_list_limit($limit){
            self::$list_limit = $limit;
        }

        static function getList($type='',$owner='',$owner_id=0,$name='',$status='',$user_id=0,$order=''){
            $stmt   = Models::$init->db->select()->from("events");
            if($user_id) $stmt->where("user_id","=",$user_id,"&&");
            if($owner) $stmt->where("owner","=",$owner,"&&");
            if($owner_id) $stmt->where("owner_id","=",$owner_id,"&&");
            if($name) $stmt->where("name","=",$name,"&&");
            if($status) $stmt->where("status","=",$status,"&&");
            $stmt->where("type","=",$type);
            if($order)
                $stmt->order_by($order);
            else
                $stmt->order_by("id ASC");
            if(self::$list_limit) $stmt->limit(self::$list_limit);
            return $stmt->build() ? $stmt->fetch_assoc() : [];
        }
        static function readAll($type='',$owner='',$owner_id=0,$name='',$status='',$user_id=0,$order=''){
            $stmt   = Models::$init->db->update("events",[
                'unread' => 1,
                'status' => 'approved',
            ]);
            if($user_id) $stmt->where("user_id","=",$user_id,"&&");
            if($owner) $stmt->where("owner","=",$owner,"&&");
            if($owner_id) $stmt->where("owner_id","=",$owner_id,"&&");
            if($name) $stmt->where("name","=",$name,"&&");
            if($status) $stmt->where("status","=",$status,"&&");
            $stmt->where("type","=",$type);
            return $stmt->save();
        }

        static function isCreated($type='',$owner='',$owner_id=0,$name='',$status='',$user_id=0,$returnData=false){
            $stmt   = Models::$init->db->select($returnData ? "" : "id")->from("events");
            if($user_id) $stmt->where("user_id","=",$user_id,"&&");
            if($owner) $stmt->where("owner","=",$owner,"&&");
            if($owner_id) $stmt->where("owner_id","=",$owner_id,"&&");
            if($name) $stmt->where("name","=",$name,"&&");
            if($status) $stmt->where("status","=",$status,"&&");
            $stmt->where("type","=",$type);
            $stmt->order_by("id DESC");
            if(!$stmt->build()) return false;
            $returnContent = $returnData ? $stmt->getAssoc() : $stmt->getObject()->id;

            if($returnData && $returnContent){
                $returnContent["data"] = $returnContent["data"] ? Utility::jdecode($returnContent["data"],true) : [];
            }

            return $returnContent;
        }

        static function apply_approved($type='',$owner='',$owner_id=0,$name='',$status='',$user_id=0){
            $stmt   = Models::$init->db->update("events",[
                'status' => "approved",
                'unread' => 1,
            ]);
            if($user_id) $stmt->where("user_id","=",$user_id,"&&");
            if($owner) $stmt->where("owner","=",$owner,"&&");
            if($owner_id) $stmt->where("owner_id","=",$owner_id,"&&");
            if($name) $stmt->where("name","=",$name,"&&");
            if($status) $stmt->where("status","=",$status,"&&");
            $stmt->where("type","=",$type);
            return $stmt->save();
        }

        static function set($id=0,$data=[]){
            if(isset($data["data"])) $data["data"] = Utility::jencode($data["data"]);
            return Models::$init->db->update("events",$data)->where("id","=",$id)->save();
        }

        static function create($data=[]){
            if(!isset($data["cdate"])) $data["cdate"] = DateManager::Now();
            if(isset($data["data"])) $data["data"] = Utility::jencode($data["data"]);
            return Models::$init->db->insert("events",$data) ? Models::$init->db->lastID() : false;
        }

        static function approved($id=0){
            $event  = is_array($id) ? $id : self::get($id);
            if(!$event) return false;

            if($event["type"] == "operation" && $event["owner"] == "order" && $event["status"] == "pending"){
                Helper::Load(["Orders"]);
                $order  = Orders::get($event["owner_id"]);
                if($order){
                    if($order["status_msg"]) Orders::set($order["id"],['unread' => 1,'status_msg' => '']);
                }
            }
            elseif($event["type"] == "transaction" && $event["owner"] == "order" && $event["name"] == "ctoc-service-transfer"){
                Helper::Load(["Orders"]);
                $order  = Orders::get($event["owner_id"]);
                if($order && $event["status"] == 'pending'){
                    Orders::set($order["id"],['owner_id' => $event["data"]["to_id"]]);
                    self::create([
                        'type'          => "log",
                        'owner'         => "order",
                        'owner_id'      => $order["id"],
                        'name'          => "ctoc-service-transfer",
                        'status'        => "approved",
                        'data'          => $event["data"],
                        'unread'        => 1,
                    ]);
                    $o_requests = self::getList('transaction','order',$order["id"],'ctoc-service-transfer','pending');
                    if($o_requests)
                        foreach($o_requests AS $o_request)
                            if($o_request["id"] != $event["id"])
                                self::set($o_request["id"],['status' => 'cancelled','unread' => 1]);
                }
            }
            elseif($event["type"] == "operation" && $event["owner"] == "order-addon" && $event["status"] == "pending"){
                Helper::Load(["Orders"]);
                $addon  = Orders::get_addon($event["owner_id"],"id,unread");
                if($addon && $addon["unread"]==0) Orders::set_addon($event["owner_id"],['unread' => 1]);
            }

            return self::set($event["id"],['status' => "approved",'unread' => 1]);
        }

        static function delete($id=0){
            return Models::$init->db->delete("events")->where("id","=",$id)->run();
        }

        static function add_scheduled_operation($info=[]){
            $event = self::isCreated("scheduled-operations",$info["owner"],$info["owner_id"],$info["name"],"pending");
            if(!$event){
                $data = [
                    'type'              => "scheduled-operations",
                    'owner'             => $info["owner"],
                    'owner_id'          => $info["owner_id"],
                    'name'              => $info["name"],
                    'data'              => [
                        'period'        => $info["period"],
                        'time'          => $info["time"],
                    ],
                ];
                if(isset($info["module"])) $data['data']['module']      = $info["module"];
                if(isset($info["command"])) $data['data']['command']    = $info["command"];
                if(isset($info["needs"])) $data['data']['needs']        = $info["needs"];
                return self::create($data);
            }
            return $event;
        }

        static function run_scheduled_operation($event=[],$force_run=false){
            if(!is_array($event)) $event = self::get($event);
            if(!$event) return false;
            $data           = is_array($event["data"]) ? $event["data"] : Utility::jdecode($event["data"],true);
            if($event["owner"] == "order"){
                $order          = Orders::get($event["owner_id"]);
                $options        = $order["options"];
            }

            $period             = isset($data["period"]) && $data["period"] ? $data["period"] : "none";
            $time               = isset($data["time"]) && $data["time"] ? $data["time"] : 1;
            $now_unix           = DateManager::strtotime();
            $status             = 'pending';
            $status_msg         = '';
            $error_attempt      = isset($data["error_attempt"]) ? $data["error_attempt"] : 0;
            $next_run_time      = isset($data["next-run-time"]) ? $data["next-run-time"] : 0;

            if(!$next_run_time && $period !== 'none' && $time)
                $next_run_time = DateManager::next_date([$event["cdate"],$period => $time]);

            if($force_run || $period == "none" || (!$next_run_time || $now_unix > DateManager::strtotime($next_run_time))){
                ## Terminate Server for Upgrade or Downgrade START ##
                if(isset($order) && $order && $event["name"] == "remove-server-for-updowngrade"){

                    if($force_run || $error_attempt < 6){
                        $operation = Orders::ModuleHandler($order,false,"terminate",[
                            'remove-server-for-updowngrade' => true,
                        ]);

                        if(!$operation || $operation === "failed"){
                            $period                 = "hour";
                            $time                   = 1;
                            $data["period"]         = $period;
                            $data["time"]           = $time;
                            $status                 = "error";
                            $status_msg             = Orders::$message;
                            $error_attempt          +=1;
                            $data["error_attempt"]  = $error_attempt;
                        }
                        elseif($operation === "successful" || $operation){
                            if(isset($data["error_attempt"])) unset($data["error_attempt"]);
                            $status = 'approved';
                        }
                    }else{
                        $status_msg = $event["status_msg"];
                        $status     = $event["status"];
                    }
                }
                ## Terminate Server for Upgrade or Downgrade END ##

                ## Run action for order module START ##
                elseif(isset($order) && $order && $event["name"] == "run-action-for-order-module"){
                    if($force_run || $error_attempt < 6){
                        $operation = Orders::ModuleHandler($order,false,"run-action",$data);

                        if($operation !== "continue"){
                            if(!$operation || $operation === "failed"){
                                $period                 = "hour";
                                $time                   = 1;
                                $data["period"]         = $period;
                                $data["time"]           = $time;
                                $status                 = "error";
                                $status_msg             = Orders::$message;
                                $error_attempt          +=1;
                                $data["error_attempt"]  = $error_attempt;
                            }
                            elseif($operation === "successful" || $operation){
                                if(isset($data["error_attempt"])) unset($data["error_attempt"]);
                                $status = 'approved';
                            }
                        }
                    }else{
                        $status_msg = $event["status_msg"];
                        $status     = $event["status"];
                    }
                }
                ## Run action for order module END ##

                ## refund-on-payment-module START ##
                elseif($event["name"] == "refund-on-payment-module"){
                    if($force_run || $error_attempt < 3){
                        $m_name     = isset($data["module"]) ? $data["module"] : '';
                        if($m_name)
                        {
                            if(!class_exists("Basket")) Helper::Load("Basket");
                            Modules::Load("Payment",$m_name);
                            if(class_exists($m_name))
                            {
                                $module     = new $m_name;
                                $checkout   = Basket::get_checkout($data["needs"]["checkout_id"],0,false,'paid');

                                if($checkout && method_exists($module,'refund'))
                                {
                                    $refund = $module->refund($checkout);
                                    if($refund)
                                    {
                                        if(isset($data["error_attempt"])) unset($data["error_attempt"]);
                                        $status = 'approved';
                                    }
                                    else
                                    {
                                        Modules::save_log('Payment',__CLASS__,'refund','Checkout ID: '.$checkout["id"],$module->error);
                                        $status                 = "error";
                                        $status_msg             = $module->error;
                                        $error_attempt          +=1;
                                        $data["error_attempt"]  = $error_attempt;
                                    }
                                }
                            }
                        }
                    }
                    else{
                        $status_msg = $event["status_msg"];
                        $status     = $event["status"];
                    }
                }
                ## refund-on-payment-module END ##
                else{
                    $data["status"]         = "approved";
                    $data["status_msg"]     = '';
                }

                if($period != "none"){
                    $data["last-run-time"] = DateManager::Now();
                    $data["next-run-time"] = DateManager::next_date([$period => $time]);
                }

                Events::set($event["id"],[
                    'status' => $status,
                    'status_msg' => $status_msg,
                    'unread' => $status == "approved" ? 1 : 0,
                    'data' => $data
                ]);
            }
        }

        static function order_log_description($evt = [],$lang=false){
            $evt['data'] = Utility::jdecode($evt['data'],true);
            $variables   = [];
            if($evt['data']) foreach($evt['data'] AS $k => $v) $variables['{'.$k.'}'] = $v;
            if($evt['name'] == 'order-user-changed')
            {
                $variables['{old}'] = '<a href="'.Controllers::$init->AdminCRLink("users-2",["detail",$evt['data']['old_id']]).'">'.$evt['data']['old_name'].'</a>';
                $variables['{new}'] = '<a href="'.Controllers::$init->AdminCRLink("users-2",["detail",$evt['data']['new_id']]).'">'.$evt['data']['new_name'].'</a>';
            }
            $desc       = __("admin/events/".$evt["name"],$variables,$lang);
            if(!$desc) $desc = $evt["name"];
            return $desc;
        }

    }