<?php
    $items  = [];

    if(isset($list) && $list){
        foreach($list AS $i=>$row){
            $id         = $row["id"];
            $i          +=1;


            $row["register_price"]      = Products::get_price("register","tld",$id);
            $row["renewal_price"]       = Products::get_price("renewal","tld",$id);
            $row["transfer_price"]      = Products::get_price("transfer","tld",$id);

            $aff_rate                   = $row["affiliate_rate"] > 0.0 ? $row["affiliate_rate"] : '';

            $item       = [];

            array_push($item,$i);

            $name_content       = '<input name="values[name]['.$id.']" type="text" placeholder="'.__("admin/products/domain-list-name-placeholder").'" value=".'.$row["name"].'">';

            $name_content .= '<input type="hidden" name="values[currency]['.$id.']" value="'.$row["currency"].'">';

            $name_content .= '<input type="hidden" name="values[register-cost]['.$id.']" value="'.($row["register_cost"] ? Money::formatter($row["register_cost"],$row["currency"]) : '').'">';

            $name_content .= '<input type="hidden" name="values[renewal-cost]['.$id.']" value="'.($row["renewal_cost"] ? Money::formatter($row["renewal_cost"],$row["currency"]) : '').'">';

            $name_content .= '<input type="hidden" name="values[transfer-cost]['.$id.']" value="'.($row["transfer_cost"] ? Money::formatter($row["transfer_cost"],$row["currency"]) : '').'">';

            $name_content .= '<input type="hidden" name="values[register-price]['.$id.']" value="'.($row["register_price"]["amount"] ? Money::formatter($row["register_price"]["amount"],$row["currency"]) : '').'">';

            $name_content .= '<input type="hidden" name="values[renewal-price]['.$id.']" value="'.($row["renewal_price"]["amount"] ? Money::formatter($row["renewal_price"]["amount"],$row["currency"]) : '').'">';

            $name_content .= '<input type="hidden" name="values[transfer-price]['.$id.']" value="'.($row["transfer_price"]["amount"] ? Money::formatter($row["transfer_price"]["amount"],$row["currency"]) : '').'">';

            $name_content .= '<input type="hidden" name="values[promo-status]['.$id.']" value="'.$row["promo_status"].'">';

            $name_content .= '<input type="hidden" name="values[promo-register-price]['.$id.']" value="'.($row["promo_register_price"]>0 ? Money::formatter($row["promo_register_price"],$row["currency"]) : '').'">';

            $name_content .= '<input type="hidden" name="values[promo-transfer-price]['.$id.']" value="'.($row["promo_transfer_price"]>0 ? Money::formatter($row["promo_transfer_price"],$row["currency"]) : '').'">';

            $name_content .= '<input type="hidden" name="values[affiliate-disable]['.$id.']" value="'.$row["affiliate_disable"].'">';
            $name_content .= '<input type="hidden" name="values[affiliate-rate]['.$id.']" value="'.$aff_rate.'">';

            $name_content .= '<input type="hidden" name="values[promo-duedate]['.$id.']" value="'.($row["promo_duedate"] == substr(DateManager::ata(),0,10) ? '' : $row["promo_duedate"]).'">';

            $name_content .= '<input type="hidden" name="values[id][]" value="'.$row["id"].'">';

            array_push($item,$name_content);

            array_push($item,'<a class="lbtn" href="javascript:setPricing(\''.$id.'\');void 0;">'.__("admin/products/domain-list-pricing-button").'</a>');
            array_push($item,'<a class="lbtn" href="javascript:setPromotion(\''.$id.'\');void 0;">'.__("admin/products/domain-list-promotion-button").'</a>');

            $module_content = '<select name="values[module]['.$id.']" class="module-item">';
            $module_content .= '<option value="none">'.__("admin/products/domain-list-module-none").'</option>';
            if(isset($registrars) && $registrars){
                foreach($registrars AS $registrar){
                    $module_content .= '<option'.($row["module"] == $registrar ? ' selected' : '').' value="'.$registrar.'">'.$registrar.'</option>';
                }
            }
            $module_content .= '</select>';



            array_push($item,$module_content);

            array_push($item,'<input'.($row["status"] == "active" ? ' checked' : '').' type="checkbox" class="tld-situations sitemio-checkbox" id="tld-'.$id.'-status" name="values[status]['.$row["id"].']" value="1"><label for="tld-'.$id.'-status" style="float:none;display:inline-block;" class="sitemio-checkbox-label"></label>');

            array_push($item,'<input type="checkbox" onchange="if($(\'.selected-item:not(:checked)\').length==0) $(\'#allSelect\').prop(\'checked\',true); else $(\'#allSelect\').prop(\'checked\',false);" class="checkbox-custom selected-item" id="tld-'.$id.'-select" value="'.$id.'"><label for="tld-'.$id.'-select" class="checkbox-custom-label"></label>');

            $items[] = $item;
        }
    }

    return $items;