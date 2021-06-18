<?php
    $items  = [];

    if(isset($list) && $list){
        foreach($list AS $i=>$row){
            $item = [];
            array_push($item,$i);
            array_push($item,$row["ctime"]);
            array_push($item,$row["title"]);

            array_push($item,$row["data"]["count"]);

            $long_content = $row["content"];

            if(Validation::isEmpty($long_content)) $content = ___("needs/null");
            else{
                $content = "";
                if($row["data"]["length"]>20) $content .= "<br>".'<a href="javascript:showMessage('.$row["id"].');void 0;" class="lbtn"> '.__("website/account_products/report-message-content").'</a>';
            }

            $content .= ' ('.$row["data"]["length"].' Karakter - '.$row["data"]["credit"].' SMS)';

            $content .= '<p style="display: none;" id="show_message_'.$row["id"].'">'.nl2br($long_content).'</p>';

            array_push($item,$content);

            array_push($item,$row["data"]["total_credit"]);
            array_push($item,'<a href="javascript:getReportDetail('.$row["id"].');void 0;" class="lbtn"><i class="fa fa-search"></i> '.__("website/account_products/get-sms-detail-report").'</a>');
            $items[] = $item;
        }
    }

    return $items;