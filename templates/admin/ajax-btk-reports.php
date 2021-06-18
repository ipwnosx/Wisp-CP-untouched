<?php
    $items  = [];

    if(isset($list) && $list){
        foreach($list AS $i=>$row){
            $id         = $row["id"];
            $options    = Utility::jdecode($row["options"],true);
            $item   = [];

            $desc_msg = [
                'domain-hosting' => "Domain ve Hosting Birlikte.",
                'only-domain'    => "Sadece Domain.",
                'only-hosting'   => "Sadece Hosting.",
            ];

            $user_link = Controllers::$init->AdminCRLink("users-2",['detail',$row["user_id"]]);

            /*
            $cdate         = $row["type"] == "domain" ? DateManager::format("d/m/Y",$row["cdate"]) : ___("needs/none");
            $duedate       = $row["type"] == "domain" ? DateManager::format("d/m/Y",$row["duedate"]) : ___("needs/none");
            */
            $cdate         = DateManager::format("d/m/Y",$row["cdate"]);
            $duedate       = DateManager::format("d/m/Y",$row["duedate"]);

            $user_name           = Utility::short_text($row["user_name"],0,21,true);
            $user_company_name   = Utility::short_text($row["user_company_name"],0,21,true);
            $user_data           = User::getData($row["user_id"],"id,email","array");
            $user_data           = array_merge($user_data,User::getInfo($row["user_id"],["phone","landline_phone"]));

            $phone               = NULL;
            if($user_data["phone"]) $phone = "+".$user_data["phone"];
            if(!$phone && $user_data["landline_phone"]) $phone = "+".$user_data["landline_phone"];
            if(!$phone) $phone  = ___("needs/none");


            $user_detail         = '<a href="'.$user_link.'" target="_blank"><strong title="'.$row["user_name"].'">'.$user_name.'</strong></a><br><span class="mobcomname" title="'.$row["user_company_name"].'">'.$user_company_name.'</span>';


            if($row["type"] == "domain") $domain = $row["name"];
            elseif($row["type"] == "hosting") $domain = $options["domain"];

            array_push($item,$i);
            array_push($item,$domain);
            array_push($item,$user_detail);
            array_push($item,$phone);
            array_push($item,$user_data["email"]);
            array_push($item,$cdate);
            array_push($item,$duedate);
            array_push($item,$desc_msg[$row["desc_type"]]);

            $items[] = $item;
        }
    }


    return $items;