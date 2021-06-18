<?php
    $items  = [];

    if(isset($list) && $list){
        foreach($list AS $i=>$row){
            $id     = $row["id"];

            $data   = $row["data"];
            if($data){
                $json   = Utility::jdecode($data,true);
                if($json) $data = $json;
            }

            $detail = $row["locale_detail"] ? $row["locale_detail"] : User::action_desc($row["detail"],$data);

            if(!$detail) $detail = ___("needs/unknown")." #".$id;

            $user_detail    = ___("needs/system");

            if($row["user_name"]){
                $user_detail = $row["user_name"];
                if($row["user_type"] == "admin")
                    $user_detail = "<a href='".Controllers::$init->AdminCRLink("admins-dl",[$row["owner_id"]])."' target='_blank' style='color:green;'>".$user_detail."</a>";
                elseif($row["user_type"] == "member")
                    $user_detail = "<a href='".Controllers::$init->AdminCRLink("users-2",["detail",$row["owner_id"]])."' target='_blank'>".$user_detail."</a>";
            }

            if(Utility::strlen($detail)>70){
                $detail = '<a data-balloon="'.htmlentities($detail,ENT_QUOTES).'" data-balloon-pos="up">'.Utility::short_text($detail,0,70,true).'</a>';
            }


            $item   = [];
            array_push($item,$i);
            if($admins) array_push($item,$user_detail);
            array_push($item,$detail);
            array_push($item,$row["date"]);
            array_push($item,$row["ip"]);

            $items[] = $item;
        }
    }


    return $items;