<?php
    $items  = [];

    if(isset($list) && $list){
        foreach($list AS $i=>$row){
            $id         = $row["id"];

            $item   = [];

            $user_link      = Controllers::$init->AdminCRLink("users-2",['detail',$row["user_id"]]);

            $user_name           = Utility::short_text($row["user_name"],0,21,true);
            $user_company_name   = Utility::short_text($row["user_company_name"],0,21,true);

            $user_detail         = '<a href="'.$user_link.'" target="_blank"><strong title="'.$row["user_name"].'">'.$user_name.'</strong></a><br><span class="mobcomname" title="'.$row["user_company_name"].'">'.$user_company_name.'</span>';

            if(!$row["user_name"]) $user_detail = ___("needs/none");

            $pers_deps          = ___("needs/none");
            $c_date_d_date      = DateManager::format(Config::get("options/date-format"),$row["c_date"]);


            if($row["departments"]){
                $split_deps = explode(",",$row["departments"]);
                $pers_deps  = [];
                foreach($split_deps As $dep) if(isset($departments[$dep])) $pers_deps[] = $departments[$dep]["name"];
                $pers_deps          = implode(", ",$pers_deps);
                $short_pers_deps    = Utility::short_text($pers_deps,0,21,true);
                $pers_deps          = '<strong title="'.$pers_deps.'">'.$short_pers_deps.'</strong>';
            }elseif($row["admin_id"]){
                $admin_name = Utility::short_text($row["admin_name"],0,21,true);
                $pers_deps = '<strong title="'.$row["admin_name"].'">'.$admin_name.'</strong>';
            }

            $short_title        = Utility::short_text($row["title"],0,21,true);

            if(substr($row["due_date"],0,4) != "1881") $c_date_d_date  .= " <br> ".DateManager::format(Config::get("options/date-format"),$row["due_date"]);

            $detail_link        = Controllers::$init->AdminCRLink("tools-2",["tasks","detail"])."?id=".$id;

            $perms              = '';

            if($row["status"] != "completed"){
                $perms          .= '<a href="javascript:void 0;" onclick="applyOperation(this,\'completed\');" data-id="'.$id.'" data-tooltip="'.__("admin/tools/button-completed").'" class="green sbtn"><i class="fa fa-check"></i></a> ';
            }

            $perms              .= '<a href="'.$detail_link.'" data-tooltip="'.___("needs/view").'" class="sbtn"><i class="fa fa-search"></i></a>';

            if((isset($is_full_admin) && $is_full_admin) || $row["owner_id"] == $udata["id"]){
                $perms          .= ' <a href="javascript:void 0;" onclick="applyOperation(this,\'delete\');" data-id="'.$id.'" data-tooltip="'.___("needs/button-delete").'" class="red sbtn"><i class="fa fa-trash"></i></a>';
            }


            array_push($item,$i);
            array_push($item,'<span title="'.$row["title"].'">'.$short_title.'</span>');
            array_push($item,$pers_deps);
            array_push($item,$user_detail);
            array_push($item,$c_date_d_date);
            array_push($item,$situations[$row["status"]]);
            array_push($item,$perms);

            $items[] = $item;
        }
    }


    return $items;