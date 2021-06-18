<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    $breadcrumbs = [];
    if(isset($breadcrumb) && $breadcrumb){
        foreach($breadcrumb AS $crumb){
            $breadcrumbs[] = ($crumb["link"] == '') ? ''.$crumb["title"].'' : '<a href="'.$crumb["link"].'">'.$crumb["title"].'</a>';
        }
        echo implode('<i class="fa fa-caret-right" aria-hidden="true"></i>',$breadcrumbs);
    }