<?php
    $items  = [];

    if(isset($list) && $list){
        foreach($list AS $i=>$row){
            $id     = $row["id"];

            $detail_link = Controllers::$init->AdminCRLink("knowledgebase-2",["categories","edit"])."?id=".$id;

            $catLink            = Controllers::$init->CRLink("kbase_category",[$row["route"]]);
            $catLink            = ' <a href="'.$catLink.'" target="_blank" class="targeturl sbtn"><i class="fa fa-external-link" aria-hidden="true"></i></a>';
            if($row["parent_route"] == '')
                $parent_catLink = NULL;
            else{
                $parent_catLink    = Controllers::$init->CRLink("kbase_category",[$row["parent_route"]]);
                $parent_catLink    = ' <a href="'.$parent_catLink.'" target="_blank" class="targeturl sbtn"><i class="fa fa-external-link" aria-hidden="true"></i></a>';
            }


            $item   = [];

            array_push($item,$i);

            array_push($item,$row["name"].$catLink);
            array_push($item,$row["parent_name"].$parent_catLink);
            array_push($item,$situations[$row["status"]]);
            $opeations = '<a href="'.$detail_link.'" class="sbtn"><i class="fa fa-edit"></i></a>';
            if($privOperation)
                $opeations .= ' <a href="javascript:deleteCategory('.$row["id"].');void 0;" title="'.___("needs/button-delete").'" class="red sbtn" id="delete_'.$row["id"].'"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
            array_push($item,$opeations);

            $items[] = $item;
        }
    }


    return $items;