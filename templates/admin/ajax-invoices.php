<?php
    $items  = [];
    $visibility_sendbta = Config::get("options/send-bill-to-address/status");
    $visibility_taxed   = Config::get("options/taxation");

    if(isset($list) && $list){
        foreach($list AS $i=>$row){
            $id     = $row["id"];
            $user_id = $row["user_id"];
            $user_link = Controllers::$init->AdminCRLink("users-2",['detail',$user_id]);
            $detail_link = Controllers::$init->AdminCRLink("invoices-2",["detail",$id]);



            $token      = Crypt::encode(Utility::jencode([
                'user_id' => $row["user_id"],
                'id'      => $row["id"],
            ]),Config::get("crypt/user"));

            $preview = Controllers::$init->CRLink("share-invoice")."?token=".$token;

            $user_data     = $row["user_data"] ? Utility::jdecode($row["user_data"],true) : [];


            $user_name           = Utility::short_text($user_data["full_name"],0,21,true);
            $user_company_name   = Utility::short_text($user_data["company_name"],0,21,true);

            $user_detail         = '<a href="'.$user_link.'"><strong title="'.$user_data["full_name"].'">'.$user_name.'</strong></a><br><span class="mobcomname" title="'.$user_data["company_name"].'">'.$user_company_name.'</span>';

            $amount_detail   = Money::formatter_symbol($row["total"],$row["currency"]);

            if($status == "paid" || $status == "taxed" || $status == "untaxed")
                $date_detail = DateManager::format(Config::get("options/date-format")." - H:i",$row["datepaid"]);
            elseif($status == "unpaid")
                $date_detail = DateManager::format(Config::get("options/date-format")." - H:i",$row["duedate"]);
            elseif($status == "cancelled-refund"){
                if(substr($row["refunddate"],0,4) == "1881")
                    $date_detail = DateManager::format(Config::get("options/date-format")." - H:i",$row["duedate"]);
                else
                    $date_detail = DateManager::format(Config::get("options/date-format")." - H:i",$row["refunddate"]);
            }else{
                if($row["status"] == "paid") $date_detail = '<strong>'.__("admin/invoices/bills-th-datepaid").'</strong><br>'.DateManager::format(Config::get("options/date-format")." - H:i",$row["datepaid"]);
                elseif($row["status"] == "unpaid" || $row["status"] == "waiting") $date_detail = '<strong>'.__("admin/invoices/bills-th-duedate").'</strong><br>'.DateManager::format(Config::get("options/date-format")." - H:i",$row["duedate"]);
                elseif($row["status"] == "refund") $date_detail = '<strong>'.__("admin/invoices/bills-th-refunddate").'</strong><br>'.DateManager::format(Config::get("options/date-format")." - H:i",$row["refunddate"]);
                else
                    $date_detail = '<strong>'.__("admin/invoices/bills-th-cdate").'</strong><br>'.DateManager::format(Config::get("options/date-format")." - H:i",$row["cdate"]);
            }

            if($row["taxed"])
                $taxed_detail = '<span style="color:green;">'.__("admin/invoices/create-taxed").'</span>';
            else
                $taxed_detail = '<span style="color:red;">'.__("admin/invoices/create-untaxed").'</span>';

            if(!$row["legal"])
                $taxed_detail = '<span>'.__("admin/invoices/tax-free").'</span>';

            if($row["sendbta"])
                $sendbta_detail = '<span style="font-size: 24px;color: #81c04e;"><i class="fa fa-check-square-o"></i></span>';
            else
                $sendbta_detail = '<span style="font-size: 24px;color:#CCC;"><i class="fa fa-ban"></i></span>';

            $item   = [];
            array_push($item,$i);

            array_push($item,'<input type="checkbox" onchange="if($(\'.selected-item:not(:checked)\').length==0) $(\'#allSelect\').prop(\'checked\',true); else $(\'#allSelect\').prop(\'checked\',false);" class="checkbox-custom selected-item" id="order-'.$id.'-select" value="'.$id.'"><label for="order-'.$id.'-select" class="checkbox-custom-label"></label>');
            array_push($item,$row["number"] ? $row["number"] : "#".$id);
            if($from != "user")
                array_push($item,$user_detail);
            array_push($item,$amount_detail);
            array_push($item,$date_detail);
            if($visibility_sendbta) array_push($item,$sendbta_detail);
            if($visibility_taxed && (!$status || $status == "paid" || $status == "taxed" || $status == "untaxed")) array_push($item,$taxed_detail);
            array_push($item,$situations[$row["status"]]);

            $perms  = '';

            if($from != "user")
                if($privOperation && $row["status"] == "unpaid" || $row["status"] == "waiting")
                    $perms .= '<a href="javascript:applyOperation(\'paid\','.$id.');void 0;" data-tooltip="'.__("admin/invoices/paid-button").'" class="green sbtn"><i class="fa fa-check"></i></a> ';


            $perms .= '<a href="'.$detail_link.'" data-tooltip="'.___("needs/button-edit").'" class="sbtn"><i class="fa fa-edit" aria-hidden="true"></i></a> ';


            $perms .= '<a target="_blank" href="'.$preview.'" data-tooltip="'.__("admin/invoices/preview-button").'" class="sbtn"><i class="fa fa-search" aria-hidden="true"></i></a> ';

            if($privDelete)
                $perms .= '<a href="javascript:deleteInvoice('.$id.');void 0;" data-tooltip="'.__("admin/invoices/delete-button").'" class="red sbtn"><i class="fa fa-trash"></i></a> ';

            array_push($item,$perms);

            $items[] = $item;
        }
    }


    return $items;