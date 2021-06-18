<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    $breadcrumbs = [];
    if(isset($panel_breadcrumb) && $panel_breadcrumb){
        if(sizeof($panel_breadcrumb)>0){
            foreach($panel_breadcrumb AS $crumb){
                $breadcrumbs[] = ($crumb["link"] == '') ? '<a>'.$crumb["title"].'</a>' : '<a href="'.$crumb["link"].'">'.$crumb["title"].'</a>';
            }
            echo implode(' / ',$breadcrumbs);
        }
    }