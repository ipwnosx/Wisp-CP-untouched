<?php
    $items  = [];

    if(isset($list) && $list){
        foreach($list AS $i=>$row){
            $id     = $row["id"];
            $user_id = $row["user_id"];
            $user_link = Controllers::$init->AdminCRLink("users-2",['detail',$user_id]);

            $browser = new Browser($row["user_agent"]);


            $user_name           = Utility::short_text($row["full_name"],0,21,true);
            $user_company_name   = Utility::short_text($row["company_name"],0,21,true);

            if($l_type == "client")
                $user_detail         = '<a href="'.$user_link.'"><strong title="'.$row["full_name"].'">'.$user_name.'</strong></a>';
            else
                $user_detail         = '<strong title="'.$row["full_name"].'">'.$user_name.'</strong>';

            $user_detail       .= '<br><span class="mobcomname" title="'.$row["company_name"].'">'.$user_company_name.'</span>';

            if($row["country_code"]){
                $cc = $row["country_code"];
                $country = '<img src="'.$sadress.'assets/images/flags/'.$cc.'.svg" height="15"> '.AddressManager::get_country_name($cc);
            }
            else
                $country =  ___("needs/unknown");


            $item   = [];
            array_push($item,$i);
            array_push($item,$user_detail);
            array_push($item,DateManager::format(Config::get("options/date-format")." - H:i",$row["ctime"]));
            array_push($item,$browser->getPlatform());
            array_push($item,$browser->getBrowser()." ".$browser->getVersion());
            array_push($item,'<u><a referrerpolicy="no-referrer" href="https://check-host.net/ip-info?host='.$row["ip"].'" target="_blank">'.$row["ip"].'</a></u>');
            array_push($item,$country);
            array_push($item,$row["city"] ? $row["city"] :  ___("needs/unknown"));

            $items[] = $item;
        }
    }


    return $items;