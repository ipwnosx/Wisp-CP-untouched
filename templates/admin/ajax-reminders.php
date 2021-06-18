<?php
    $items  = [];

    if(isset($list) && $list){
        foreach($list AS $i=>$row){
            $id         = $row["id"];

            $item   = [];

            $zero_month     = $row["period_month"];
            $zero_day       = $row["period_day"];
            $zero_hour      = $row["period_hour"];
            $zero_minute    = $row["period_minute"];

            if($row["period_month"]>-1 && $row["period_month"] < 10) $zero_month = "0".$row["period_month"];
            if($row["period_day"]>-1 && $row["period_day"] < 10) $zero_day = "0".$row["period_day"];
            if($row["period_hour"]>-1 && $row["period_hour"] < 10) $zero_hour = "0".$row["period_hour"];
            if($row["period_minute"]>-1 && $row["period_minute"] < 10) $zero_minute = "0".$row["period_minute"];

            $period             = __("admin/tools/reminders-period-".$row["period"]);

            if($row["period"] == "onetime"){
                $period .= "<br>";
                $period .= DateManager::format(Config::get("options/date-format")." H:i",$row["period_datetime"]);
            }
            elseif($row["period"] == "recurring"){
                $period .= "<br>";
                if($zero_month == -1)
                    $period .= ___("date/every-month");
                else
                    $period .= DateManager::month_name($zero_month);

                $period .= " / ";

                if($zero_day == -1)
                    $period .= ___("date/every-day");
                else
                    $period .= $zero_day.". ".___("date/day");

                $period .= " / ";

                $period .= $zero_hour.":".$zero_minute;

            }


            $short_note        = Utility::short_text($row["note"],0,50,true);

            if($row["period_hour"]>-1 && $row["period_minute"]>-1)
                $hour_minute = $zero_hour.":".$zero_minute;
            else
                $hour_minute = '';


            $perms              = '<form id="row_'.$id.'" style="display: none;">';
            $perms              .= '<textarea name="note">'.$row["note"].'</textarea>';
            $perms              .= '<input type="hidden" name="period" value="'.$row["period"].'">';
            $perms              .= '<input type="hidden" name="period_datetime" value="'.(substr($row["period_datetime"],0,4) == "1881" ? '' : str_replace(" ","T",substr($row["period_datetime"],0,-3)) ).'">';
            $perms              .= '<input type="hidden" name="status" value="'.$row["status"].'">';
            $perms              .= '<input type="hidden" name="period_month" value="'.$row["period_month"].'">';
            $perms              .= '<input type="hidden" name="period_day" value="'.$row["period_day"].'">';
            $perms              .= '<input type="hidden" name="period_hour_minute" value="'.$hour_minute.'">';
            $perms              .= '</form>';

            $perms              .= '<a href="javascript:detail_reminder('.$id.');" data-tooltip="'.___("needs/view").'" class="sbtn"><i class="fa fa-search"></i></a>';

            $perms          .= ' <a href="javascript:void 0;" onclick="deleteReminder('.$id.');" data-tooltip="'.___("needs/button-delete").'" class="red sbtn"><i class="fa fa-trash"></i></a>';

            array_push($item,$i);
            array_push($item,'<span title="'.htmlentities($row["note"],ENT_QUOTES).'">'.$short_note.'</span>');
            array_push($item,DateManager::format(Config::get("options/date-format")." H:i",$row["creation_time"]));
            array_push($item,$period);
            array_push($item,$situations[$row["status"]]);
            array_push($item,$perms);

            $items[] = $item;
        }
    }


    return $items;