<?php
    $items  = [];

    if(isset($list) && $list){
        foreach($list AS $i=>$row){
            $u_detail_link  = Controllers::$init->AdminCRLink("users-2",["detail",$row["user_id"]]);
            $detail_link    = Controllers::$init->AdminCRLink("users-2",["document-verification","records"])."?detail=".$row["user_id"];

            $user_name           = Utility::short_text($row["user_full_name"],0,21,true);
            $user_company_name   = Utility::short_text($row["user_company_name"],0,21,true);

            $user_detail         = '<a href="'.$u_detail_link.'" target="_blank"><strong title="'.$row["user_full_name"].'">'.$user_name.'</strong></a><br><span class="mobcomname" title="'.$row["user_company_name"].'">'.$user_company_name.'</span>';

            $status     = $row["status"];
            if(stristr($row["situations"],'awaiting')) $status = 'awaiting';
            elseif(stristr($row["situations"],'unverified')) $status = 'unverified';

            $item   = [];
            array_push($item,$i);
            array_push($item,$user_detail);
            array_push($item,DateManager::format("Y-m-d - H:i",$row["created_at"]));
            array_push($item,DateManager::format("Y-m-d - H:i",$row["updated_at"]));
            array_push($item,$situations[$status]);
            $perms  = '';

            $perms .= '<a href="'.$detail_link.'" data-tooltip="'.__("admin/users/button-detail").'" class="sbtn"><i class="fa fa-search"></i></a> ';

            array_push($item,$perms);

            $items[] = $item;
        }
    }


    return $items;