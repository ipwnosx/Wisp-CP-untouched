<?php
    $items  = [];

    if(isset($list) && $list){
        foreach($list AS $i=>$row){
            $id     = $row["id"];
            $detail_link = Controllers::$init->AdminCRLink("users-2",["detail",$id]);

            $user_name           = Utility::short_text($row["full_name"],0,21,true);
            $user_company_name   = Utility::short_text($row["company_name"],0,21,true);

            $user_detail         = '<a href="'.$detail_link.'"><strong title="'.$row["full_name"].'">'.$user_name.'</strong></a><br><span class="mobcomname" title="'.$row["company_name"].'">'.$user_company_name.'</span>';

            $phone      = $row["phone"] ? "<br>+".$row["phone"] : NULL;

            $infoX     = User::getInfo($id,['blacklist_reason','blacklist_time','blacklist_by_admin']);

            if($infoX['blacklist_reason'])
                $reason     = '<p style="display: none;" id="reason_'.$id.'">'.nl2br($infoX['blacklist_reason']).'</p><a class="sbtn" href="javascript:void 0;" onclick="readMsg('.$id.');"><i class="fa fa-info"></i></a>';
            else
                $reason     = '';
            $getAdmin       = User::getData($infoX['blacklist_by_admin'],['full_name'],'assoc');

            $by_admin       = $getAdmin ? '<a target="_blank" href="'.Controllers::$init->AdminCRLink('admins-dl',[$infoX["blacklist_by_admin"]]).'">'.$getAdmin['full_name'].'</a>' : ($row["blacklist"] == 2 ? 'WFraud® DB' : '-');



            $item   = [];
            array_push($item,$i);
            array_push($item,$user_detail);
            array_push($item,$row["email"].$phone);
            array_push($item,$by_admin);
            array_push($item,DateManager::format('d/m/Y - H:i',$infoX["blacklist_time"]));
            array_push($item,$reason);
            $perms  = '';

            $perms .= '<a href="'.$detail_link.'" data-tooltip="'.__("admin/users/button-detail").'" class="sbtn"><i class="fa fa-search"></i></a> ';

            if($row["blacklist"] != 2)
                $perms .= '<a id="delete-'.$id.'" href="javascript:deleteBlackList('.$id.');void 0;" data-tooltip="'.__("admin/users/button-delete").'" class="red sbtn"><i class="fa fa-trash"></i></a> ';

            array_push($item,$perms);



            $items[] = $item;
        }
    }


    return $items;