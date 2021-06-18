<?php
    $items  = [];

    $users  = [];

    if(isset($list) && $list){
        foreach($list AS $i=>$row){
            $id     = $row["id"];

            $appointees = [];

            if($row["appointees"]){
                $appointees_arr = explode(",",$row["appointees"]);
                foreach($appointees_arr AS $ap){
                    if(!isset($users[$ap])){
                        $user         = User::getData($ap,"full_name","array");
                        if($user) $users[$ap]   = $user["full_name"];
                    }

                    $admin_link   = Controllers::$init->AdminCRLink("admins-dl",[$ap]);
                    $appointees[] = "<a href='".$admin_link."' target='_blank'>".$users[$ap]."</a>";

                }
            }

            $appointees       = $appointees ? implode("<br>",$appointees) : ___("needs/none");


            $item   = [];
            array_push($item,$i);
            array_push($item,$row["name"]);
            array_push($item,$appointees);
            $perms  = '';

            $perms .= '<a href="javascript:editDepartment('.$id.');void 0;" data-tooltip="'.___("needs/button-edit").'" class="sbtn"><i class="fa fa-pencil"></i></a> ';

            $perms .= '<a id="delete-'.$id.'" href="javascript:deleteDepartment('.$id.');void 0;" data-tooltip="'.___("needs/button-delete").'" class="red sbtn"><i class="fa fa-trash"></i></a> ';

            array_push($item,$perms);



            $items[] = $item;
        }
    }


    return $items;