<?php
    $items  = [];

    if(isset($list) && $list){
        Money::$digit=4;
        foreach($list AS $i=>$row){

            $row["data"]  = Utility::jdecode($row["data"],true);

            if($row["user_id"]){
                $user_link           = Controllers::$init->AdminCRLink("users-2",['detail',$row["user_id"]]);
                $user_name           = Utility::short_text($row["user_name"],0,21,true);
                $user_company_name   = Utility::short_text($row["user_company_name"],0,21,true);

                $user_detail         = '<a href="'.$user_link.'" target="_blank"><strong title="'.$row["user_name"].'">'.$user_name.'</strong></a><br><span class="mobcomname" title="'.$row["user_company_name"].'">'.$user_company_name.'</span>';
            }else{
                $user_detail = ___("needs/system");
            }

            $long_content = $row["content"];

            $item = [];
            array_push($item,$i);
            array_push($item,$user_detail);

            array_push($item,DateManager::format(Config::get("options/date-format")." - H:i",$row["ctime"]));
            array_push($item,$row["title"]);
            if(Validation::isEmpty($long_content))
                $content = ___("needs/null");
            else{
                $content    = Utility::short_text($long_content,0,20,true);
                if($row["data"]["length"]>20) $content .= '<br> <a href="javascript:showMessage('.$row["id"].');void 0;" class="lbtn"> '.__("website/account_sms/report-message-content").'</a><br>';
            }
            $content .= ' ('.$row["data"]["part"].' SMS - '.$row["data"]["length"].' '.__("website/account_sms/dimension-character").')';

            $content .= '<p style="display: none;" id="show_message_'.$row["id"].'">'.nl2br($long_content).'</p>';


            array_push($item,$content);
            array_push($item,isset($row["data"]["count"]) ? $row["data"]["count"] : ___("needs/none"));
            array_push($item,Money::formatter_symbol($row["data"]["total_credit"],$row["data"]["credit_cid"]));
            $countries = '';
            if(isset($row["data"]["countries"]) && $row["data"]["countries"]){
                foreach($row["data"]["countries"] AS $country){
                    $countries .= '<img src="'.$sadress.'assets/images/flags/'.$country["code"].'.svg" width="20" style="float: left;"> ('.$country["total_part"].' SMS - '.Money::formatter_symbol($country["total_price"],$row["data"]["credit_cid"]).')<br>';
                }
            }
            array_push($item,$countries);

            array_push($item,'<a href="javascript:getReportDetail('.$row["id"].');void 0;" class="lbtn"><i class="fa fa-search"></i> '.__("admin/products/get-sms-detail-report").'</a>');
            $items[] = $item;
        }
    }

    return $items;