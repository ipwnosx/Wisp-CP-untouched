<?php
    $items  = [];

    if(isset($list) && $list){
        foreach($list AS $i=>$row){
            $id     = $row["id"];
            $user_link = Controllers::$init->AdminCRLink("users-2",['detail',$row["user_id"]]);
            $invoice_link = Controllers::$init->AdminCRLink("invoices-2",["detail",$row["invoice_id"]]);
            $options      = $row["options"] ? Utility::jdecode($row["options"],true) : [];
            
            $cdatetime    = DateManager::format(Config::get("options/date-format")." H:i",$row["cdate"]);
            $cdatetime    = explode(" ",$cdatetime);
            $cdate        = $cdatetime[0];
            $ctime        = $cdatetime[1];
            $refund       = __("admin/orders/updown-refund-".$row["refund"]);

            if($options["old_amount"]){
                $old_period     = View::period($options["old_period_time"],$options["old_period"]);
                $old_price      = Money::formatter_symbol($options["old_amount"],$options["currency"]);
            }else{
                $old_price = ___("needs/free-amount");
                $old_period = NULL;
            }
            $old_amount_period = "".$old_price."";
            if($old_period) $old_amount_period .= " (".$old_period.")";

            if($options["new_amount"]){
                $new_period     = View::period($options["new_period_time"],$options["new_period"]);
                $new_price      = Money::formatter_symbol($options["new_amount"],$options["currency"]);
            }else{
                $new_price = ___("needs/free-amount");
                $new_period = NULL;
            }
            $new_amount_period = "".$new_price."";
            if($new_period) $new_amount_period .= " (".$new_period.")";
            

            $status = $situations[$row["status"]];
            $status_msg = "";
            if(!Validation::isEmpty($row["status_msg"])){
                $status_msg = htmlspecialchars($row["status_msg"],ENT_QUOTES);
                $status_msg = '<br><a href="javascript:void(0);" class="status-msg" data-message="'.$status_msg.'"><i class="fa fa-exclamation-triangle"></i></i></a>';
            }

            $taxation   = false;
            if($row["invoice_id"]){
                $invoice        = Invoices::get($row["invoice_id"],['select' => "status,tax,currency"]);
                $bill_status    = $invoice["status"];
                $invoice_detail = "<a href='".$invoice_link."' target='_blank'>#".$row["invoice_id"]."</a><br>";
                if($bill_status == "paid"){
                    $invoice_detail .= "<span style='color:green;'>".__("admin/orders/invoice-paid")."</span>";
                    if($invoice["tax"]){
                        $tax        = Money::exChange($invoice["tax"],$invoice["currency"],$options["currency"]);
                        $options["difference_amount"] += $tax;
                        $taxation = true;
                    }
                }else
                    $invoice_detail .= "<span style='color:red;'>".__("admin/orders/invoice-unpaid")."</span>";
            }else
                $invoice_detail = ___("needs/none");

            $type_detail    = "".__("admin/orders/updown-type-".$row["type"])."";

            $old_detail         = '<a href="'.Controllers::$init->AdminCRLink("orders-2",["detail",$row["owner_id"]]).'" target="_blank">'.$options["old_name"].'</a>';

            $order              = Orders::get($row["owner_id"],"type,type_id");
            $new_detail         = '<a href="'.Controllers::$init->AdminCRLink("products-2",[$order["type"].($order["type"] == "special" ? "-".$order["type_id"] : ''),"edit"])."?id=".$row["new_pid"].'" target="_blank">'.$options["new_name"].'</a>';

            $difference_amount = Money::formatter_symbol($options["difference_amount"],$options["currency"]);

            $user_name           = Utility::short_text($row["user_name"],0,21,true);
            $user_company_name   = Utility::short_text($row["user_company_name"],0,21,true);

            $user_detail         = '<a href="'.$user_link.'" target="_blank"><strong title="'.$row["user_name"].'">'.$user_name.'</strong></a><br><span class="mobcomname" title="'.$row["user_company_name"].'">'.$user_company_name.'</span>';

            $item   = [];
            array_push($item,$i);
            array_push($item,'<input type="checkbox" onchange="if($(\'.selected-item:not(:checked)\').length==0) $(\'#allSelect\').prop(\'checked\',true); else $(\'#allSelect\').prop(\'checked\',false);" class="checkbox-custom selected-item" id="order-'.$id.'-select" value="'.$id.'"><label for="order-'.$id.'-select" class="checkbox-custom-label"></label>');
            array_push($item,$user_detail);

            array_push($item,$old_detail."<br>".$old_amount_period);
            array_push($item,$new_detail."<br>".$new_amount_period);
            array_push($item,"<strong>".$difference_amount."</strong>");
            array_push($item,$type_detail);
            array_push($item,$invoice_detail);
            array_push($item,$status.$status_msg);
            $perms  = '';
            if($privOperation && $row["status"] != "completed")
                $perms .= '<a href="javascript:applyOperation(\'completed\','.$id.');void 0;" data-tooltip="'.__("admin/orders/list-row-operation-approve").'" class="green sbtn"><i class="fa fa-check"></i></a> ';

            $perms .= '<a href="javascript:details('.$id.');void 0;" data-tooltip="'.___("needs/button-detail").'" class="sbtn"><i class="fa fa-search"></i></a> ';

            $perms .= '<span style="display: none" id="row_'.$id.'_old_product">'.$options["old_name"].'</span>';
            $perms .= '<span style="display: none" id="row_'.$id.'_old_renewaldate">'.DateManager::format(Config::get("options/date-format"),$options["old_renewaldate"]).'</span>';
            $perms .= '<span style="display: none" id="row_'.$id.'_old_duedate">'.DateManager::format(Config::get("options/date-format"),$options["old_duedate"]).'</span>';
            $perms .= '<span style="display: none" id="row_'.$id.'_times_used_day">'.$options["times_used"].'</span>';
            $perms .= '<span style="display: none" id="row_'.$id.'_times_used_amount">'.Money::formatter_symbol($options["times_used_amount"],$options["currency"]).'</span>';
            $perms .= '<span style="display: none;" id="row_'.$id.'_remaining_day">'.$options["remaining_day"].'</span>';
            $perms .= '<span style="display: none;" id="row_'.$id.'_remaining_amount">'.Money::formatter_symbol($options["remaining_amount"],$options["currency"]).'</span>';
            $perms .= '<span style="display: none;" id="row_'.$id.'_new_product">'.$options["new_name"].'</span>';
            $perms .= '<span style="display: none;" id="row_'.$id.'_old_amount_period">'.$old_amount_period.'</span>';
            $perms .= '<span style="display: none;" id="row_'.$id.'_new_amount_period">'.$new_amount_period.'</span>';
            $perms .= '<span style="display: none;" id="row_'.$id.'_difference_amount">'.$difference_amount.'</span>';
            $perms .= '<span style="display: none;" id="row_'.$id.'_type">'.$row["type"].'</span>';
            $perms .= '<span style="display: none;" id="row_'.$id.'_taxation">'.(int) $taxation.'</span>';
            $perms .= '<span style="display: none;" id="row_'.$id.'_status">'.$status.'</span>';
            $perms .= '<span style="display: none;" id="row_'.$id.'_ctime">'.$cdate." - ".$ctime.'</span>';
            $perms .= '<span style="display: none;" id="row_'.$id.'_refund">'.$refund.'</span>';


            if($privDelete)
                $perms .= '<a id="delete-'.$id.'" href="javascript:deleteOrder('.$id.');void 0;" data-tooltip="'.__("admin/orders/list-row-operation-delete").'" class="red sbtn"><i class="fa fa-trash"></i></a> ';

            array_push($item,$perms);



            $items[] = $item;
        }
    }


    return $items;