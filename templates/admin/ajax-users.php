<?php
    $items  = [];

    if(isset($list) && $list){
        foreach($list AS $i=>$row){
            $id     = $row["id"];
            $detail_link = Controllers::$init->AdminCRLink("users-2",["detail",$id]);

            $user_name           = Utility::short_text($row["full_name"],0,21,true);
            $user_company_name   = Utility::short_text($row["company_name"],0,21,true);

            $user_detail         = '<a href="'.$detail_link.'"><strong title="'.$row["full_name"].'">'.$user_name.'</strong></a><br><span class="mobcomname" title="'.$row["company_name"].'">'.$user_company_name.'</span>';

            $date_detail        = "<span data-balloon-pos='up' data-balloon='".__("admin/users/detail-info-cdate").": ".DateManager::format(Config::get("options/date-format")." - H:i",$row["creation_time"])."'>".DateManager::date_convert_ago($row["creation_time"])."</span><br>";
            $date_detail        .= "<span data-balloon-pos='up' data-balloon='".__("admin/users/detail-info-ldate").": ".DateManager::format(Config::get("options/date-format")." - H:i",$row["last_login_time"])."'>".DateManager::date_convert_ago($row["last_login_time"])."</span>";

            $phone      = $row["phone"] ? "<br>+".$row["phone"] : NULL;
            $cc_cy      = $row["country_code"] ? '<span data-balloon="'.$row["country_name"].'" data-balloon-pos="up"><img class="userlist-flag" src="'.$sadress.'assets/images/flags/'.strtolower($row["country_code"]).'.svg"></span> <span">'.$row["country_code"].' - '.$row["currency_code"].'</span>' : '-';



            $item   = [];
            array_push($item,$i);
            array_push($item,$user_detail);
            array_push($item,$row["email"].$phone);
            array_push($item,$cc_cy);
            array_push($item,$row["group_name"] ? $row["group_name"] : '-');
            array_push($item,$date_detail);
            array_push($item,$situations[$row["status"]]);
            $perms  = '';

            $perms .= '<a href="'.$detail_link.'" data-tooltip="'.__("admin/users/button-detail").'" class="sbtn"><i class="fa fa-search"></i></a> ';

            if($privDelete)
                $perms .= '<a id="delete-'.$id.'" href="javascript:deleteUser('.$id.');void 0;" data-tooltip="'.__("admin/users/button-delete").'" class="red sbtn"><i class="fa fa-trash"></i></a> ';

            array_push($item,$perms);



            $items[] = $item;
        }
    }


    return $items;