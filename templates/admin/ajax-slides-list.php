<?php
    $items  = [];

    if(isset($list) && $list){
        foreach($list AS $i=>$row){
            $id     = $row["id"];
            $detail_link = Controllers::$init->AdminCRLink("manage-website-2",["slides","edit"])."?id=".$id;
            $link          = Utility::link_determiner($row["link"],false,false);
            $link_short    = Utility::short_text($link,0,50,true);

            $title              = Utility::short_text($row["title"],0,50,true);

            if(!$title) $title  = ___("needs/untitled");

            $item   = [];
            array_push($item,$i);
            array_push($item,'<span title="'.htmlspecialchars($row["title"],ENT_QUOTES).'">'.$title.'</span>');
            if(!$row["link"] || $row["link"] == "#") array_push($item,___("needs/none"));
            else array_push($item,'<a target="_blank" href="'.$link.'">'.$link_short.'</a>');
            array_push($item,DateManager::format(Config::get("options/date-format")." - H:i",$row["ctime"]));
            $perms  = '';

            $perms .= '<a href="'.$detail_link.'" data-tooltip="'.___("needs/button-edit").'" class="sbtn"><i class="fa fa-pencil"></i></a> ';

            if($privDelete)
                $perms .= '<a id="delete-'.$id.'" href="javascript:deleteSlide('.$id.');void 0;" data-tooltip="'.___("needs/button-delete").'" class="red sbtn"><i class="fa fa-trash"></i></a> ';

            array_push($item,$perms);



            $items[] = $item;
        }
    }


    return $items;