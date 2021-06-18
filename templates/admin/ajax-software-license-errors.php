<?php
    $items      = [];
    $products   = [];

    if(isset($list) && $list){
        foreach($list AS $i=>$row){
            $item = [];

            $data   = $row["data"] ? Utility::jdecode($row["data"],true) : [];

            $domain = $row["name"];

            if(!$data["server_ip"])
                $domain = "<span class='license-report'>".__("admin/products/license-errors-report")."</span> ".$domain;

            $url    = NULL;
            if(isset($data["entered_url"]) && $data["entered_url"])
                $url    .= "<br><strong>".__("admin/products/license-errors-entered-url")."</strong> : <span title='".$data["entered_url"]."'>".Utility::short_text($data["entered_url"],0,40,true)."</span><br>";
            if(isset($data["referer_url"]) && $data["referer_url"])
                $url    .= "<strong>".__("admin/products/license-errors-referer-url")."</strong> : <span title='".$data["referer_url"]."'>".Utility::short_text($data["referer_url"],0,40,true)."</span>";
            $product    = ___("needs/unknown");

            if($row["owner_id"]){
                if(!isset($products[$row["owner_id"]]))
                    $products[$row["owner_id"]] = Products::get("software",$row["owner_id"],Config::get("general/local"));
                if(isset($products[$row["owner_id"]]["title"]))
                    $product    = $products[$row["owner_id"]]["title"];
            }

            $ip     = $data["server_ip"] ? $data["server_ip"] : ' - ';
            $ip     .= "/ ";
            $ip     .= $data["user_ip"] ? $data["user_ip"] : '-';

            array_push($item,$i);
            array_push($item,$domain.$url);
            array_push($item,$data["directory"]);
            array_push($item,$product);
            array_push($item,$ip);
            array_push($item,DateManager::format(Config::get("options/date-format")." - H:i",$row["cdate"]));
            $opeations = '';
            if($privOperation)
                $opeations .= ' <a href="javascript:deleteError('.$row["id"].');void 0;" title="'.__("admin/products/delete").'" class="red sbtn" id="delete_'.$row["id"].'"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
            array_push($item,$opeations);


            $items[] = $item;
        }
    }

    return $items;