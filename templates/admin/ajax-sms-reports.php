<?php
    $items  = [];

    if(isset($list) && $list){
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

            $order              = Orders::get($row["owner_id"],"id,name");
            if($order){
                $order_detail       = '<a href="'.Controllers::$init->AdminCRLink("orders-2",["detail",$row["owner_id"]]).'" target="_blank">'.$order["name"].'</a>';
            }else $order_detail = ___("needs/deleted");

            $report_link    = Controllers::$init->AdminCRLink("orders-2",["detail",$row["owner_id"]]);

            $long_content   = $row["content"];

            $item = [];
            array_push($item,$i);
            array_push($item,$user_detail);
            array_push($item,$order_detail);
            array_push($item,DateManager::format(Config::get("options/date-format")." - H:i",$row["ctime"]));
            array_push($item,$row["title"]);
            array_push($item,$row["data"]["count"]);
            if(Validation::isEmpty($long_content)) $content = ___("needs/null");
            else{
                $content = "";
                if($row["data"]["length"]>20) $content .= "<br>".'<a href="javascript:showMessage('.$row["id"].');void 0;" class="lbtn"> '.__("website/account_products/report-message-content").'</a>';
            }

            $content .= ' ('.$row["data"]["length"].' Karakter - '.$row["data"]["credit"].' SMS)';
            $content .= '<p style="display: none;" id="show_message_'.$row["id"].'">'.nl2br($long_content).'</p>';

            array_push($item,$content);
            array_push($item,$row["data"]["total_credit"]);
            array_push($item,'<a href="javascript:getReportDetail('.$row["id"].',\''.$report_link.'\');void 0;" class="lbtn"><i class="fa fa-search"></i> '.__("admin/products/get-sms-detail-report").'</a>');
            $items[] = $item;
        }
    }

    return $items;