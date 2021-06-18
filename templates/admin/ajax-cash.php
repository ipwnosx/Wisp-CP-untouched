<?php
    $items  = [];

    if(isset($list) && $list){
        foreach($list AS $i=>$row){
            $id     = $row["id"];

            $detail_link = Controllers::$init->AdminCRLink("invoices-2",["detail",$row["invoice_id"]]);

            $description_detail = '<span title="'.htmlentities($row["description"],ENT_QUOTES).'">'.Utility::short_text($row["description"],0,100,true).'</span>';


            if($row["type"] == "income")
                $type_detail = '<span style="color:green">'.__("admin/invoices/cash-row-type-income").'</span>';
            if($row["type"] == "expense")
                $type_detail = '<span style="color:red">'.__("admin/invoices/cash-row-type-expense").'</span>';
            if($row["type"] == "refund")
                $type_detail = '<span style="color:red">'.__("admin/invoices/cash-row-type-refund").'</span>';
            if($row["type"] == "cancelled")
                $type_detail = '<span style="color:red">'.__("admin/invoices/cash-row-type-cancelled").'</span>';

            $item   = [];
            $cdatetime = DateManager::format(Config::get("options/date-format")." - H:i",$row["cdate"]);
            $cdate     = DateManager::format("Y-m-d",$row["cdate"]);
            $ctime     = DateManager::format("H:i",$row["cdate"]);
            array_push($item,$i);
            array_push($item,$description_detail);
            array_push($item,$type_detail);
            array_push($item,Money::formatter_symbol($row["amount"],$row["currency"]));
            array_push($item,$cdatetime);
            $perms  = '
                <div id="manage_'.$row["id"].'" style="display:none;">
                    <input type="hidden" name="amount" value="'.Money::formatter($row["amount"],$row["currency"]).'">
                    <input type="hidden" name="currency" value="'.$row["currency"].'">
                    <input type="hidden" name="type" value="'.$row["type"].'">
                    <textarea name="description">'.$row["description"].'</textarea>
                    <input type="hidden" name="cdate" value="'.$cdate.'">
                    <input type="hidden" name="ctime" value="'.$ctime.'">
                </div>
            ';

            if($row["invoice_id"]){
                $perms .= '<a href="'.$detail_link.'" target="_blank" data-tooltip="'.___("needs/button-edit").'" class="sbtn"><i class="fa fa-pencil"></i></a> ';
            }else{
                $perms .= '<a href="javascript:editCash('.$row["id"].');void 0;" data-tooltip="'.___("needs/button-edit").'" class="sbtn"><i class="fa fa-pencil"></i></a> ';
            }

            if($privDelete)
                $perms .= '<a id="delete-'.$id.'" href="javascript:deleteCash('.$id.');void 0;" data-tooltip="'.___("needs/button-delete").'" class="red sbtn"><i class="fa fa-trash"></i></a> ';

            array_push($item,$perms);



            $items[] = $item;
        }
    }


    return $items;