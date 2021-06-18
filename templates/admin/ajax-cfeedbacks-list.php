<?php
    $items  = [];

    if(isset($list) && $list){
        foreach($list AS $i=>$row){
            $id     = $row["id"];
            $detail_link = Controllers::$init->AdminCRLink("manage-website-2",["cfeedbacks","edit"])."?id=".$id;

            $name                = Utility::short_text($row["full_name"],0,21,true);
            $company_name        = Utility::short_text($row["company_name"],0,21,true);

            $customer_detail     = '<span><strong title="'.$row["full_name"].'">'.$name.'</strong></a><br><span class="mobcomname" title="'.$row["company_name"].'">'.$company_name.'</span>';


            $item   = [];
            array_push($item,$i);
            array_push($item,$customer_detail);
            array_push($item,$row["email"]);
            array_push($item,DateManager::format("d/m/Y - H:i",$row["ctime"]));
            array_push($item,$situations[$row["status"]]);
            $perms  = '';

            $perms .= '<a href="'.$detail_link.'" data-tooltip="'.___("needs/button-edit").'" class="sbtn"><i class="fa fa-pencil"></i></a> ';

            if($privDelete)
                $perms .= '<a id="delete-'.$id.'" href="javascript:deleteCfeedback('.$id.');void 0;" data-tooltip="'.___("needs/button-delete").'" class="red sbtn"><i class="fa fa-trash"></i></a> ';

            array_push($item,$perms);



            $items[] = $item;
        }
    }


    return $items;