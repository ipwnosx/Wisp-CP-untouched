<?php
    $lang               = Bootstrap::$lang->clang;
    $l_lang             = Config::get("general/local");
    $items  = [];

    if(isset($list) && $list){
        foreach($list AS $i=>$row){
            $id     = $row["user_id"];
            $detail_link = Controllers::$init->AdminCRLink("users-2",["detail",$id])."?tab=affiliate";

            $user_name           = Utility::short_text($row["full_name"],0,21,true);
            $user_company_name   = Utility::short_text($row["company_name"],0,21,true);

            $user_detail         = '<a href="'.$detail_link.'"><strong title="'.$row["full_name"].'">'.$user_name.'</strong></a><br><span class="mobcomname" title="'.$row["company_name"].'">'.$user_company_name.'</span>';

            $gateway            = Config::get("options/affiliate/payment-gateways/".$row["gateway"]."/".$lang);
            if(!$gateway)
                $gateway        = Config::get("options/affiliate/payment-gateways/".$row["gateway"]."/".$l_lang);

            $staus_desc         = '';

            if($row['status'] == "completed") $staus_desc .= '<br>('.DateManager::format(Config::get("options/date-format")." H:i",$row["completed_time"]).')';
            if($row['status_msg'] != "") $staus_desc .= '<br>'.$row["status_msg"];


            $item   = [];
            array_push($item,$i);
            if(!$aff_id) array_push($item,$user_detail);
            array_push($item,DateManager::format(Config::get("options/date-format").' - H:i',$row["ctime"]));
            array_push($item,$gateway ? $gateway : ___("needs/unknown"));
            array_push($item,Money::formatter_symbol($row["amount"],$row["currency"]));
            array_push($item,$situations[$row["status"]].$staus_desc);
            $perms  = '';

            $perms .= '<a href="javascript:void 0;" onclick="detail_withdrawal('.$row["id"].');" data-tooltip="'.__("admin/users/button-detail").'" class="sbtn"><i class="fa fa-search"></i></a> ';

            $perms .= '<a href="javascript:void 0;" onclick="delete_withdrawal('.$row["id"].');" data-tooltip="'.__("admin/users/button-delete").'" class="sbtn red"><i class="fa fa-trash"></i></a> ';

            $perms .=
                '<span id="withdrawal_'.$row["id"].'" style="display:none;">'.
                '<span class="wl-affiliate">'.$user_detail.'</span>'.
                '<span class="wl-status">'.$row["status"].'</span>'.
                '<span class="wl-status_msg">'.$row["status_msg"].'</span>'.
                '<span class="wl-ctime">'.DateManager::format(Config::get("options/date-format")." H:i",$row["ctime"]).'</span>'.
                '<span class="wl-gateway">'.($gateway ? $gateway : ___("needs/unknown")).'</span>'.
                '<span class="wl-gateway-info">'.($row["gateway_info"] ? nl2br($row["gateway_info"]) : ___("needs/unknown")).'</span>'.
                '<span class="wl-amount">'.Money::formatter_symbol($row["amount"],$row["currency"]).'</span>'.
                '</div>';


            array_push($item,$perms);

            $items[] = $item;
        }
    }


    return $items;