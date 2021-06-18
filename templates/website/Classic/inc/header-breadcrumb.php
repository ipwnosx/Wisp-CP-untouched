<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    $breadcrumbs = [];
    if(isset($breadcrumb) && $breadcrumb){
        foreach($breadcrumb AS $crumb){
            $breadcrumbs[] = ($crumb["link"] == '') ? '<a>'.$crumb["title"].'</a>' : '<a href="'.$crumb["link"].'">'.$crumb["title"].'</a>';
        }
        if(isset($_theme_name) && $_theme_name == "Classic")
            echo implode(' / ',$breadcrumbs);
        else
            echo implode('<i class="fa fa-caret-right" aria-hidden="true"></i>',$breadcrumbs);
    }