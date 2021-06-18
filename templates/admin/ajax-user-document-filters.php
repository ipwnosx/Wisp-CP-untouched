<?php
    $items  = [];

    if(isset($list) && $list){
        foreach($list AS $i=>$row){
            $id     = $row["id"];
            $detail_link = Controllers::$init->AdminCRLink("users-2",["document-verification","filters"])."?page=edit&id=".$id;

            $name           = Utility::short_text($row["name"],0,21,true);
            $detail_name    = '<span title="'.$row["name"].'">'.$name.'</span>';


            $item   = [];
            array_push($item,$i);
            array_push($item,$detail_name);
            array_push($item,$situations[$row["status"]]);

            $perms  = '';

            $perms .= '<a href="'.$detail_link.'" data-tooltip="'.___("needs/button-edit").'" class="sbtn"><i class="fa fa-pencil"></i></a> ';

            $perms .= '<a id="delete-'.$id.'" href="javascript:deleteFilter('.$id.');void 0;" data-tooltip="'.__("admin/users/button-delete").'" class="red sbtn"><i class="fa fa-trash"></i></a> ';


            array_push($item,$perms);



            $items[] = $item;
        }
    }


    return $items;