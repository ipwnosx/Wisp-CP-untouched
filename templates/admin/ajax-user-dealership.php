<?php
    $items  = [];

    if(isset($list) && $list){
        foreach($list AS $i=>$row){
            $id     = $row["id"];
            $detail_link = Controllers::$init->AdminCRLink("users-2",["detail",$id])."?tab=dealership";

            $user_name           = Utility::short_text($row["full_name"],0,21,true);
            $user_company_name   = Utility::short_text($row["company_name"],0,21,true);

            $user_detail         = '<a href="'.$detail_link.'"><strong title="'.$row["full_name"].'">'.$user_name.'</strong></a><br><span class="mobcomname" title="'.$row["company_name"].'">'.$user_company_name.'</span>';

            $d_info             = Utility::jdecode($row["d_info"],true);

            $date               = $row["creation_time"];

            if(isset($d_info['activation_time']) && $d_info['activation_time'])
                $date = $d_info['activation_time'];

            $date       = DateManager::format("d/m/Y H:i",$date);

            $totals     = User::dealership_statistics($id,$d_info);

            $turnover   = Money::formatter_symbol($totals['turnover'],$totals['currency']);
            $discounts  = Money::formatter_symbol($totals['discounts'],$totals['currency']);


            $item   = [];
            array_push($item,$i);
            array_push($item,$user_detail);
            array_push($item,$date);
            array_push($item,$turnover);
            array_push($item,$discounts);
            $perms  = '';

            $perms .= '<a href="'.$detail_link.'" data-tooltip="'.__("admin/users/button-detail").'" class="sbtn"><i class="fa fa-search"></i></a> ';

            array_push($item,$perms);



            $items[] = $item;
        }
    }


    return $items;