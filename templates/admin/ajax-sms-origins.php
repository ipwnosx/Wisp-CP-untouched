<?php
    $items  = [];

    if(isset($list) && $list){
        foreach($list AS $i=>$row){
            $id     = $row["id"];
            $user_link = Controllers::$init->AdminCRLink("users-2",['detail',$row["user_id"]]);

            $status = $situations[$row["status"]];

            $order              = Orders::get($row["pid"],"id,name");

            $order_detail       = '<a href="'.Controllers::$init->AdminCRLink("orders-2",["detail",$order["id"]]).'" target="_blank">'.$order["name"].'</a>';

            $user_name           = Utility::short_text($row["user_name"],0,21,true);
            $user_company_name   = Utility::short_text($row["user_company_name"],0,21,true);

            $user_detail         = '<a href="'.$user_link.'" target="_blank"><strong title="'.$row["user_name"].'">'.$user_name.'</strong></a><br><span class="mobcomname" title="'.$row["user_company_name"].'">'.$user_company_name.'</span>';

            $ctime       = DateManager::format("Y-m-d H:i",$row["ctime"]);
            $approved    = DateManager::format("Y-m-d H:i",$row["approved_date"]);
            $ctime       = str_replace(" ","T",$ctime);
            $approved    = str_replace(" ","T",$approved);
            $apped       = substr($row["approved_date"],0,4)=="1881" ? false : true;
            $approved    = $apped ? $approved : '';
            $item   = [];
            array_push($item,$i);
            array_push($item,$user_detail);
            array_push($item,$order_detail);

            array_push($item,'<strong>'.$row["name"].'</strong>');

            $attachmentsx = $row["attachments"] ? Utility::jdecode($row["attachments"],true) : [];
            $attachments  = '';
            if($attachmentsx){
                foreach($attachmentsx AS $attachment){
                    $link   = Utility::link_determiner($attachment["file_path"],RESOURCE_DIR."uploads".DS."attachments".DS,false);
                    $attachments .= '<a class="sbtn" href="'.$link.'" title="'.$attachment["file_name"].'" target="_blank"><i class="fa fa-link" aria-hidden="true"></i></a> ';
                }
            }

            $status_msg = "";
            $short_msg  = Utility::short_text(Filter::html_clear($row["status_message"]),0,50,true);
            $long_msg_btn = "";
            if(Utility::strlen($row["status_message"])>50){
                $status_msg .= '<div id="long_msg_'.$row["id"].'" data-title="'.$row["name"].'" style="display: none;"><div class="padding15">'.$row["status_message"].'</div></div>';
                $long_msg_btn = " onclick='open_long_msg(\"long_msg_".$row["id"]."\");' style='cursor:pointer;'";
            }

            $status_msg .=  '<span'.$long_msg_btn.'>'.$short_msg.'</span>';

            $unread = '';

            array_push($item,$attachments);
            array_push($item,$status_msg);
            array_push($item,$situations[$row["status"]].$unread);

            $perms  = '
            
            <input type="hidden" id="origin_'.$row["id"].'_name" value="'.$row["name"].'">
            <input type="hidden" id="origin_'.$row["id"].'_status" value="'.$row["status"].'">
            <textarea style="display: none;" id="origin_'.$row["id"].'_status_message">'.$row["status_message"].'</textarea>
            <input type="hidden" id="origin_'.$row["id"].'_cdate" value="'.$ctime.'">
            <input type="hidden" id="origin_'.$row["id"].'_approved_date" value="'.$approved.'">
            
            ';

            if($privOperation && $row["status"] != "active")
                $perms .= '<a href="javascript:activeOrigin('.$row["id"].');void 0;" data-tooltip="Onayla" class="green sbtn"><i class="fa fa-check" aria-hidden="true"></i></a> ';

            if($privOperation && $row["status"] != "inactive")
                $perms .= '<a href="javascript:inactiveOrigin('.$row["id"].');void 0;" data-tooltip="Pasif Et" class="orange sbtn"><i class="fa fa-ban" aria-hidden="true"></i></a> ';

            $perms .= '<a href="javascript:editOrigin('.$row["id"].');void 0;" data-tooltip="Düzenle" class="sbtn"><i class="fa fa-edit" aria-hidden="true"></i></a> ';

            if($privDelete)
                $perms .= '<a href="javascript:deleteOrigin('.$row["id"].');void 0;" data-tooltip="Sil" class="red sbtn"><i class="fa fa-trash-o" aria-hidden="true"></i></a> ';

            array_push($item,$perms);



            $items[] = $item;
        }
    }


    return $items;