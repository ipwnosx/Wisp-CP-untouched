<?php
    $items  = [];

    if(isset($list) && $list){
        foreach($list AS $i=>$row){
            $id         = $row["id"];
            $user_link  = Controllers::$init->AdminCRLink("users-2",['detail',$row["user_id"]]);
            $order_link = Controllers::$init->AdminCRLink("orders-2",["detail",$row["owner_id"]]);
            $order      = Orders::get($row["owner_id"],"id,type,name,options");

            $data         = $row["data"] ? Utility::jdecode($row["data"],true) : [];
            $options      = $order["options"] ? Utility::jdecode($order["options"],true) : [];


            $order_name = ___("needs/deleted");
            $order_name_sub = NULL;
            if($order){
                $order_name = Utility::short_text($order["name"],0,25,true);
                if(isset($options["domain"]) && $order["type"] != "domain")
                    $order_name_sub = $options["domain"];
                if(isset($options["hostname"])){
                    $order_name_sub = $options["hostname"];
                    if(isset($options["ip"]))
                        $order_name_sub .= $options["ip"];
                }
            }

            $cdate        = DateManager::format(Config::get("options/date-format")." - H:i",$row["cdate"]);

            $status = $situations[$row["status"]];

            $status_msg = "";
            if(!Validation::isEmpty($row["status_msg"])){
                $status_msg = htmlspecialchars($row["status_msg"],ENT_QUOTES);
                $status_msg = '<br><a href="javascript:void(0);" class="status-msg" data-message="'.$status_msg.'"><i class="fa fa-exclamation-triangle"></i></i></a>';
            }


            $reason = Utility::short_text($data["reason"],0,30,true);


            if($row["owner_id"]){
                $order_detail = "<a href='".$order_link."' target='_blank' title='".$order["name"]."'>".$order_name."</a><br>".$order_name_sub;
            }else
                $order_detail = ___("needs/none");


            $user_name           = Utility::short_text($row["user_name"],0,21,true);
            $user_company_name   = Utility::short_text($row["user_company_name"],0,21,true);

            $user_detail         = '<a href="'.$user_link.'" target="_blank"><strong title="'.$row["user_name"].'">'.$user_name.'</strong></a><br><span class="mobcomname" title="'.$row["user_company_name"].'">'.$user_company_name.'</span>';

            $item   = [];
            array_push($item,$i);
            array_push($item,'<input type="checkbox" onchange="if($(\'.selected-item:not(:checked)\').length==0) $(\'#allSelect\').prop(\'checked\',true); else $(\'#allSelect\').prop(\'checked\',false);" class="checkbox-custom selected-item" id="order-'.$id.'-select" value="'.$id.'"><label for="order-'.$id.'-select" class="checkbox-custom-label"></label>');
            array_push($item,$user_detail);

            array_push($item,$order_detail);
            array_push($item,$cdate);
            array_push($item,__("admin/orders/cancellation-urgency-".$data["urgency"]));


            $reason_msg = htmlspecialchars($data["reason"],ENT_QUOTES);
            $reason_msg = '<a href="javascript:void(0);" class="reason-msg" data-message="'.$reason_msg.'">'.$reason.'</a>';

            array_push($item,$reason_msg);
            array_push($item,$status.$status_msg);
            $perms  = '';
            if($privOperation && $row["status"] != "approved")
                $perms .= '<a href="javascript:applyOperation(\'approve\','.$id.');void 0;" data-tooltip="'.__("admin/orders/list-row-operation-approve").'" class="green sbtn"><i class="fa fa-check"></i></a> ';
            if($privDelete)
                $perms .= '<a id="delete-'.$id.'" href="javascript:deleteRequest('.$id.');void 0;" data-tooltip="'.__("admin/orders/list-row-operation-delete").'" class="red sbtn"><i class="fa fa-trash"></i></a> ';

            array_push($item,$perms);



            $items[] = $item;
        }
    }


    return $items;