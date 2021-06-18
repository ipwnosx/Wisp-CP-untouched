<?php
    $items  = [];
    Helper::Load(["Events"]);

    if(isset($list) && $list){
        foreach($list AS $i=>$row){
            $id     = $row["id"];
            $user_link = Controllers::$init->AdminCRLink("users-2",['detail',$row["user_id"]]);
            $invoice_link = Controllers::$init->AdminCRLink("invoices-2",["detail",$row["invoice_id"]]);

            $list_cdatetime     = substr($row["cdate"],0,4)!="1881" ? DateManager::format(Config::get("options/date-format"),$row["cdate"]) : '-';
            $list_rdatetime     = substr($row["renewaldate"],0,4)!="1881" ? DateManager::format(Config::get("options/date-format"),$row["renewaldate"]) : '-';
            $list_duedatetime   = substr($row["duedate"],0,4)!="1881" ? DateManager::format(Config::get("options/date-format"),$row["duedate"]) : '-';

            $status = $situations[$row["status"]];

            if(!Validation::isEmpty($row["status_msg"])){
                $status_msg = htmlspecialchars($row["status_msg"],ENT_QUOTES);
                $status     .= '<br><a href="javascript:void(0);" class="status-msg have-event" data-message=""><i class="fa fa-exclamation-triangle"></i></i></a><div class="status-msg-content" style="display: none;">'.$status_msg.'</div>';
            }

            if($row["isEvent"]>0){
                $status     .= '<br><a class="have-event open-event" href="javascript:void(0);" data-id="'.$id.'" data-balloon="'.__("admin/orders/there-are-pending-events2",['{count}' => $row["isEvent"]]).'" data-balloon-pos="up"><i class="fa fa-info-circle"></i></i></a>';
            }

            $order              = Orders::get($row["owner_id"],"id,name");

            $order_detail       = '<a href="'.Controllers::$init->AdminCRLink("orders-2",["detail",$order["id"]]).'">'.$order["name"].'</a>';

            if($row["invoice_id"])
                $order_detail .= "<br> ".__("admin/orders/my-addons-invoice").": <a href='".$invoice_link."'>#".$row["invoice_id"]."</a><br>";

            $amount = $row["amount"]>0 ? Money::formatter_symbol($row["amount"],$row["cid"]) : ___("needs/free-amount");
            $period = NULL;

            if($row["amount"]>0){
                $period = View::period($row["period_time"],$row["period"]);
            }
            $amount_period  = "<strong>".$amount."</strong>";
            if($period) $amount_period.= "<br>".$period."";

            $user_name           = Utility::short_text($row["user_name"],0,21,true);
            $user_company_name   = Utility::short_text($row["user_company_name"],0,21,true);

            $user_detail         = '<a href="'.$user_link.'"><strong title="'.$row["user_name"].'">'.$user_name.'</strong></a><br><span class="mobcomname" title="'.$row["user_company_name"].'">'.$user_company_name.'</span>';

            if(stristr($row["option_name"],'x '))
            {
                $split = explode("x ",$row["option_name"]);
                $row["option_quantity"] = $split[0];
                $row["option_name"] = $split[1];
            }


            $item   = [];
            array_push($item,$i);
            if(!$order_id){
                array_push($item,'<input type="checkbox" onchange="if($(\'.selected-item:not(:checked)\').length==0) $(\'#allSelect\').prop(\'checked\',true); else $(\'#allSelect\').prop(\'checked\',false);" class="checkbox-custom selected-item" id="order-'.$id.'-select" value="'.$id.'"><label for="order-'.$id.'-select" class="checkbox-custom-label"></label>');
                array_push($item,$user_detail);
                array_push($item,$order_detail);
            }
            array_push($item,$row["addon_name"]."<br>".($row["option_quantity"] > 0 ? $row["option_quantity"].'x ' : '').$row["option_name"]);
            array_push($item,$list_rdatetime."<br>".$list_duedatetime);
            array_push($item,$amount_period);
            array_push($item,$status);

            $cdatetime          = explode(" ",$row["cdate"]);
            $duedatetime        = explode(" ",$row["duedate"]);
            $renewaldatetime    = explode(" ",$row["renewaldate"]);
            $cdate              = $cdatetime[0];
            $ctime              = substr($cdatetime[1],0,5);
            $renewaldate        = $renewaldatetime[0];
            $renewaltime        = substr($renewaldatetime[1],0,5);
            $duedate            = substr($duedatetime[0],0,4) == "1881" ? '' : $duedatetime[0];
            $duetime            = substr($duedatetime[0],0,4) == "1881" ? '' : substr($duedatetime[1],0,5);

            $subscription       = $row["subscription_id"] ? Orders::get_subscription($row["subscription_id"]) : false;


            $perms  = '
            <div id="addon-'.$row["id"].'" style="display:none;">
            <input type="hidden" name="addon_name" value="'.$row["addon_name"].'">
            <input type="hidden" name="option_name" value="'.$row["option_name"].'">
            <input type="hidden" name="option_quantity" value="'.$row["option_quantity"].'">
            <input type="hidden" name="amount" value="'.Money::formatter($row["amount"],$row["cid"]).'">
            <input type="hidden" name="cid" value="'.$row["cid"].'">
            <input type="hidden" name="period" value="'.$row["period"].'">
            <input type="hidden" name="period_time" value="'.$row["period_time"].'">
            <input type="hidden" name="status" value="'.$row["status"].'">
            <input type="hidden" name="cdate" value="'.$cdate.'">
            <input type="hidden" name="ctime" value="'.$ctime.'">
            <input type="hidden" name="renewaldate" value="'.$renewaldate.'">
            <input type="hidden" name="renewaltime" value="'.$renewaltime.'">
            <input type="hidden" name="duedate" value="'.$duedate.'">
            <input type="hidden" name="duetime" value="'.$duetime.'">
            <input type="hidden" name="pmethod" value="'.$row["pmethod"].'">
            
            <div class="subscription-data">
            
            ';

            if(isset($subscription) && $subscription)
            {

                $perms .= ' <div class="formcon">
                                        <div class="yuzde30">'.__("admin/orders/link-subscription").'</div>
                                        <div class="yuzde70">';

                $perms .= '<div class="subscription-content">
<div class="load-wrapp">
                                                    <p style="margin-bottom:20px"><strong>'.___("needs/processing").'...</strong><br>'.___("needs/please-wait").'</p>
                                                    <div class="load-7">
                                                        <div class="square-holder">
                                                            <div class="square"></div>
                                                        </div>
                                                    </div>
                                                </div>
</div>';

                $perms .= '';



                $perms .= '</div>
                                    </div>';

            }
            else
            {
                $perms .= '<div class="formcon">
                                        <div class="yuzde30">'.__("admin/orders/subscription-identifier").'</div>
                                        <div class="yuzde70">
                                            <input type="text" name="subscription[identifier]" placeholder="" value="">
                                        </div>
                                    </div>';
            }


            $perms .= '
            </div>
            
            <div class="event-data">
                <div style="text-align: center">
            ';

            $p_events   = Events::getList("operation","order-addon",$row["id"],false,"pending");

            if($p_events){
                foreach($p_events AS $k=>$event){
                    $perms .= '<div class="order-event-item" id="event_'.$event["id"].'">';
                    $perms .= Events::getMessage($event);
                    $perms .= ' <br><br><a class="lbtn event-ok-button" href="javascript:AddonEventOK('.$event["id"].');void 0;">'.___("needs/ok").'</a>';
                    $perms .= '</div>';
                }
            }

            $perms  .= '
                    </div>
                </div>
            </div>
            ';

            if($privOperation && $row["status"] != "active" && $row["status"] != "completed")
                $perms .= '<a href="javascript:applyAddonOperation(\'active\','.$id.');void 0;" data-tooltip="'.__("admin/orders/list-row-operation-active").'" class="green sbtn"><i class="fa fa-check"></i></a> ';

            $perms .= '<a href="javascript:editMyAddon('.$row["id"].');void 0;" class="sbtn" data-tooltip="'.__("admin/orders/list-row-operation-edit").'"><i class="fa fa-edit" aria-hidden="true"></i></a> ';

            if($privDelete)
                $perms .= '<a id="delete-'.$id.'" href="javascript:deleteAddon('.$id.');void 0;" data-tooltip="'.__("admin/orders/list-row-operation-delete").'" class="red sbtn"><i class="fa fa-trash"></i></a> ';

            array_push($item,$perms);



            $items[] = $item;
        }
    }


    return $items;