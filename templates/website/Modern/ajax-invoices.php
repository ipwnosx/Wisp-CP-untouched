<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    $items  = [];

    if(isset($list) && $list){
        foreach($list AS $i=>$row){
            $amount = $row["total"];
            $item = [];
            array_push($item,$row["number"] ? $row["number"] : "#".$row["id"]);
            array_push($item,$row["creation_date"]);
            array_push($item,"".$row["due_date"]."");
            array_push($item,Money::formatter_symbol($amount,$row["currency"]));
            array_push($item,$situations[$row["status"]]);
            array_push($item,'<a href="'.$row["detail_link"].'" class="incelebtn"><i class="fa fa-search" aria-hidden="true"></i> '.__("website/account_products/view-button").'</a>');

            $items[] = $item;
        }
    }

    return $items;