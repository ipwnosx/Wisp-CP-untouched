<?php
    $items  = [];

    if(isset($list) && $list){
        foreach($list AS $i=>$row){
            $id     = $row["id"];
            $user_link = Controllers::$init->AdminCRLink("users-2",['detail',$row["user_id"]]);

            $user_name           = Utility::short_text($row["user_name"],0,21,true);
            $user_company_name   = Utility::short_text($row["user_company_name"],0,21,true);

            $user_detail         = '<a href="'.$user_link.'" target="_blank"><strong title="'.$row["user_name"].'">'.$user_name.'</strong></a><br><span class="mobcomname" title="'.$row["user_company_name"].'">'.$user_company_name.'</span>';

            $prereg_detail      = '';

            if($row["preregs"]){

                foreach($row["preregs"] AS $prereg){
                    $cc         = strtoupper($prereg["ccode"]);
                    $country    = AddressManager::get_id_with_cc($cc);
                    $country    = AddressManager::getCountry($country,"t2.name",Config::get("general/local"));
                    $country    = $country["name"];
                    $prereg_detail .= '<span>- '.$country.' ('.$situations[$prereg["status"]].')</span><br>';
                    $prereg_detail .= '
<div class="origin-'.$row["id"].'-prereg">
<input type="hidden" name="prereg_id" value="'.$prereg["id"].'">
<input type="hidden" name="country_name" value="'.$country.'">
<input type="hidden" name="status" value="'.$prereg["status"].'">
<textarea name="status_msg" style="display: none;">'.$prereg["status_msg"].'</textarea>';
                    $prereg_detail .= '<div class="attachments" style="display: none;">';
                    $attachmentsx = $prereg["attachments"] ? Utility::jdecode($prereg["attachments"],true) : [];
                    if($attachmentsx){
                        foreach($attachmentsx AS $attachment){
                            $link   = Utility::link_determiner($attachment["file_path"],RESOURCE_DIR."uploads".DS."attachments".DS,false);
                            $prereg_detail .= '<a class="sbtn" href="'.$link.'" title="'.$attachment["file_name"].'" target="_blank"><i class="fa fa-link" aria-hidden="true"></i></a> ';
                        }
                    }
                    $prereg_detail .= '</div>';

$prereg_detail .= '</div>';
                }

            }else
                $prereg_detail = ___("needs/none");


            $item   = [];
            array_push($item,$i);
            array_push($item,$user_detail);

            array_push($item,'<strong id="origin_'.$row["id"].'_name">'.$row["name"].'</strong>');
            array_push($item,$prereg_detail);

            $perms  = '';

            $perms .= '<a href="javascript:editOrigin('.$row["id"].');void 0;" data-tooltip="'.__("admin/products/edit").'" class="sbtn"><i class="fa fa-edit" aria-hidden="true"></i></a> ';

            if($privOperation)
                $perms .= '<a href="javascript:deleteOrigin('.$row["id"].');void 0;" data-tooltip="'.__("admin/products/delete").'" class="red sbtn"><i class="fa fa-trash-o" aria-hidden="true"></i></a> ';

            array_push($item,$perms);



            $items[] = $item;
        }
    }


    return $items;