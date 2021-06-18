<?php
    $items  = [];

    if(isset($list) && $list){
        foreach($list AS $i=>$row){
            $id     = $row["id"];

            $view_numbers   = '';
            $split_numbers  = explode(",",$row["numbers"]);
            if(sizeof($split_numbers) > 1){
                $view_numbers = "+".$split_numbers[0];
                $view_numbers .= '<a href="javascript:void 0;" style="margin-left:5px;" class="sbtn view-numbers" data-id="'.$id.'" title="'.___("needs/allOf").'"><i class="fa fa-list"></i></a>';
                $view_numbers .= '<div id="numbers_'.$id.'" style="display:none;">';
                $view_numbers .= "<span>+".implode("</span><br> <span>+",$split_numbers);
                $view_numbers .='</div>';
            }else
                $view_numbers = "+".$row["numbers"];

            $message        = '';

            if(Utility::strlen($row["content"])>70){
                $message = Utility::short_text($row["content"],0,70,true);
                $message .= '<a href="javascript:void 0;" style="margin-left:5px; font-size:12px; font-weight:bold;" class="view-message" data-id="'.$id.'">'.__("admin/tools/more").'</a>';
                $message .= '<div id="message_'.$id.'" style="display:none;">';
                $message .= Filter::link_convert(nl2br($row["content"]),true);
                $message .= '</div>';
            }else
                $message = $row["content"];


            $item   = [];
            array_push($item,$i);
            array_push($item,$row["title"]);
            array_push($item,$message);
            array_push($item,$view_numbers);
            array_push($item,DateManager::format(Config::get("options/date-format")." - H:i",$row["ctime"]));
            array_push($item,$row["ip"]);

            $items[] = $item; 
        }
    }


    return $items;