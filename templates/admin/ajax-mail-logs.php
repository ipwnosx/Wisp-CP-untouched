<?php
    $items  = [];

    if(isset($list) && $list){
        foreach($list AS $i=>$row){
            $id     = $row["id"];

            $view_addresses   = '';
            $split_addresses  = explode(",",$row["addresses"]);
            if(sizeof($split_addresses) > 1){
                $view_addresses = "+".$split_addresses[0];
                $view_addresses .= '<a href="javascript:void 0;" style="margin-left:5px;" class="sbtn view-addresses" data-id="'.$id.'" title="'.___("needs/allOf").'"><i class="fa fa-list"></i></a>';
                $view_addresses .= '<div id="addresses_'.$id.'" style="display:none;">';
                $view_addresses .= "<span>".implode("</span><br> <span>",$split_addresses);
                $view_addresses .='</div>';
            }else
                $view_addresses = $row["addresses"];

            $message        = '';

            $filtered_content = Filter::html_clear($row["content"]);

            if(Utility::strlen($filtered_content)>70){
                $message    = Utility::short_text($filtered_content,0,70,true);
                $message    .= '<a href="javascript:void 0;" style="margin-left:5px; font-size:12px; font-weight:bold;" class="view-message" data-id="'.$id.'" data-subject="'.$row["subject"].'">'.__("admin/tools/more").'</a>';
                $message    .= '<div id="message_'.$id.'" style="display:none;">';
                $message    .= $row["content"];
                $message    .= '</div>';
            }else
                $message = $filtered_content;


            $item   = [];
            array_push($item,$i);
            array_push($item,$row["subject"]);
            array_push($item,$message);
            array_push($item,$view_addresses);
            array_push($item,DateManager::format(Config::get("options/date-format")." - H:i",$row["ctime"]));
            array_push($item,$row["ip"]);

            $items[] = $item;
        }
    }


    return $items;