<?php
    $items  = [];

    if(isset($list) && $list){
        foreach($list AS $i=>$row){
            $id     = $row["id"];
            $user_link = Controllers::$init->AdminCRLink("users-2",['detail',$row["user_id"]]);
            $detail_link = Controllers::$init->AdminCRLink("tickets-2",["detail",$id]);
            if($row["service"]) $service_link = Controllers::$init->AdminCRLink("orders-2",["detail",$row["service"]]);

            $user_name           = Utility::short_text($row["user_name"],0,21,true);
            $user_company_name   = Utility::short_text($row["user_company_name"],0,21,true);

            if($privUser)
                $user_detail         = '<a href="'.$user_link.'"><strong title="'.$row["user_name"].'">'.$user_name.'</strong></a><br><span class="mobcomname" title="'.$row["user_company_name"].'">'.$user_company_name.'</span>';
            else
                $user_detail         = '<span><strong title="'.$row["user_name"].'">'.$user_name.'</strong></span><br><span class="mobcomname" title="'.$row["user_company_name"].'">'.$user_company_name.'</span>';

            $short_title        = Utility::short_text($row["title"],0,35,true);
            if(Utility::strlen($row["title"])>35)
                $long_title = " data-balloon-pos='up' data-balloon='".htmlentities($row["title"],ENT_QUOTES)."'";
            else
                $long_title = '';

            if(!$row["adminunread"]) $short_title = '<strong>'.$short_title.'</strong>';

            $subject_detail     = "<a href='".$detail_link."'><span".$long_title.">".$short_title."</span> (#".$row["id"].")</a>";
            if($row["service"]){
                $service        = Orders::get($row["service"],"id,type,name,options");
                if($service){
                    $service_name   = Utility::short_text(Orders::detail_name($service),0,40,true);

                    if($privOrder)
                        $subject_detail .= "<br><a href='".$service_link."' target='_blank'>".$service_name."</a>";
                    else
                        $subject_detail .= "<br><span>".$service_name."</span>";
                }
            }

            $department         = $row["did"] ? Tickets::get_department($row["did"],Config::get("general/local"),"t2.name") : false;
            if($department) $department_detail  = $department["name"];
            else $department_detail  = ___("needs/other");

            $assigned_detail    = ___("needs/none");
            if($row["assigned"]){
                $assigned       = User::getData($row["assigned"],"id,full_name","array");
                if($assigned){
                    $assigned_link  = Controllers::$init->AdminCRLink("users-2",['detail',$assigned["id"]]);
                    $assigned_name  = Utility::short_text($assigned["full_name"],0,21,true);
                    if($privUser)
                        $assigned_detail = '<a href="'.$assigned_link.'" target="_blank" title="'.$assigned["full_name"].'">'.$assigned_name.'</a>';
                    else
                        $assigned_detail = '<span title="'.$assigned["full_name"].'">'.$assigned_name.'</span>';
                }
            }

            $item   = [];
            array_push($item,$i);
            if($from != "user")
                array_push($item,$user_detail);
            array_push($item,$subject_detail);
            array_push($item,$department_detail);
            array_push($item,$assigned_detail);

            array_push($item,DateManager::format(Config::get("options/date-format")." - H:i",$row["ctime"]));

            array_push($item,$row["userunread"] ? '<div class="goruldu"><i title="'.__("admin/tickets/request-detail-user-viewed").'" class="ion-android-done-all"></i></div>' : '<i title="'.__("admin/tickets/request-detail-user-unviewed").'" class="ion-android-done-all"></i>');

            array_push($item,$situations[$row["status"]]);
            $perms  = '';

            $perms .= '<a href="'.$detail_link.'" data-tooltip="'.__("admin/tickets/requests-td-detail-button").'" class="sbtn"><i class="fa fa-search"></i></a> ';

            if($privDelete)
                $perms .= '<a id="delete-'.$id.'" href="javascript:deleteRequest('.$id.');void 0;" data-tooltip="'.__("admin/tickets/requests-td-delete-button").'" class="red sbtn"><i class="fa fa-trash"></i></a> ';

            array_push($item,$perms);



            $items[] = $item;
        }
    }


    return $items;