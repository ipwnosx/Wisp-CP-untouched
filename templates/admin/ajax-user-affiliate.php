<?php
    $items  = [];

    if(isset($list) && $list){
        foreach($list AS $i=>$row){
            $id     = $row["user_id"];
            $detail_link = Controllers::$init->AdminCRLink("users-2",["detail",$id])."?tab=affiliate";

            $user_name           = Utility::short_text($row["full_name"],0,21,true);
            $user_company_name   = Utility::short_text($row["company_name"],0,21,true);

            $user_detail         = '<a href="'.$detail_link.'"><strong title="'.$row["full_name"].'">'.$user_name.'</strong></a><br><span class="mobcomname" title="'.$row["company_name"].'">'.$user_company_name.'</span>';


            $item   = [];
            array_push($item,$i);
            array_push($item,$user_detail);
            array_push($item,DateManager::format(Config::get("options/date-format").' - H:i',$row["date"]));
            array_push($item,$row["references"]);
            array_push($item,$row["hits"]);
            array_push($item,Money::formatter_symbol($row["balance"],$row["currency"]));
            array_push($item,Money::formatter_symbol($row["withdrawals"],$row["currency"]));
            $perms  = '';

            $perms .= '<a href="'.$detail_link.'" data-tooltip="'.__("admin/users/button-detail").'" class="sbtn"><i class="fa fa-search"></i></a> ';

            array_push($item,$perms);

            $items[] = $item;
        }
    }


    return $items;