<?php
    $items  = [];

    if(isset($list) && $list){
        foreach($list AS $i=>$row){
            $id     = $row["id"];
            $detail_link = Controllers::$init->AdminCRLink("manage-website-2",["cfeedbacks","edit"])."?id=".$id;

            $full_name           = Utility::short_text($row["full_name"],0,21,true);

            $user_detail        = '<span title="'.$row["full_name"].'">'.$full_name.'</span>';


            $item   = [];
            array_push($item,$i);
            if($privDelete)
                array_push($item,'<input type="checkbox" onchange="if($(\'.selected-item:not(:checked)\').length==0) $(\'#allSelect\').prop(\'checked\',true); else $(\'#allSelect\').prop(\'checked\',false);" class="checkbox-custom selected-item" id="row-'.$id.'-select" value="'.$id.'"><label for="row-'.$id.'-select" class="checkbox-custom-label"></label>');

            array_push($item,$user_detail);
            array_push($item,$row["email"]);
            array_push($item,$row["phone"]);

            $date               = DateManager::format("d/m/Y - H:i",$row["cdate"]);
            $message            = Utility::short_text($row["message"],0,30,true);
            $msg                = htmlspecialchars($row["message"],ENT_QUOTES);
            $admin_msg          = htmlspecialchars($row["admin_message"],ENT_QUOTES);
            array_push($item,$date);
            array_push($item,$row["ip"]);
            $perms  = '
            <span class="message-name" style="display: none">'.$user_detail.'</span>
            <span class="message-lang" style="display: none">'.strtoupper($row["lang"]).'</span>
            <span class="message-admin-msg" style="display: none">'.$admin_msg.'</span>
            <span class="message-msg" style="display: none">'.$msg.'</span>
            ';

            if(!$row["unread"] && $privOperation)
                $perms .= '<a href="javascript:readMessage('.$id.');void 0;" data-tooltip="'.__("admin/manage-website/button-read").'" class="green sbtn"><i class="fa fa-check"></i></a> ';

            $perms .= '<a href="javascript:void(0);" data-id="'.$id.'" data-tooltip="'.___("needs/button-detail").'" class="sbtn read-msg"><i class="fa fa-search"></i></a> ';


            if($privDelete)
                $perms .= '<a id="delete-'.$id.'" href="javascript:deleteMessage('.$id.');void 0;" data-tooltip="'.___("needs/button-delete").'" class="red sbtn"><i class="fa fa-trash"></i></a> ';

            array_push($item,$perms);



            $items[] = $item;
        }
    }


    return $items;