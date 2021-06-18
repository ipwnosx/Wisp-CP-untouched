<?php
    $items  = [];

    if(isset($list) && $list){
        foreach($list AS $i=>$row){
            $id     = $i;

            $type           = $row["_type"];
            $error_type     = '';
            $file           = '';

            $detail_con = '';
            $detail_con .= '<div id="detail_con_'.$id.'" style="display:none;">';

            $detail_con .= '<h4>REQUEST</h4>';
            $detail_con .= '<pre><code>'.$row['request_uri'].'</code></pre>';

            if($type == 'Database'){
                $detail_con .= '<h4>QUERY</h4>';
                $detail_con .= '<pre><code>'.$row['query'].'</code></pre>';
                $detail_con .= '<h4>PARAM VALUES</h4>';
                $detail_con .= '<pre><code>'.print_r($row['params'],true).'</code></pre>';

                $detail_con .= '<h4>MESSAGE</h4>';
                $detail_con .= '<pre><code>'.$row['messg'].'</code></pre>';

                $detail_con .= '<h4>FILE</h4>';
                $detail_con .= '<pre>'.$row['file'].'</pre>';

                $detail_con .= '<h4>LINE</h4>';
                $detail_con .= '<pre>'.$row['line'].'</pre>';

            }else{
                $detail_con .= '<h4>MESSAGE</h4>';
                $detail_con .= '<pre><code>'.$row['errstr'].'</code></pre>';

                $detail_con .= '<h4>FILE</h4>';
                $detail_con .= '<pre>'.$row['errfile'].'</pre>';

                $detail_con .= '<h4>LINE</h4>';
                $detail_con .= '<pre>'.$row['errline'].'</pre>';

            }

            $detail_con .= '</div>';


            if($type == 'Database')
            {
                $file           = '<span title="'.$row["file"].'">'.Utility::short_text($row["file"],0,100,true).'</span>';
                $file           .= '<br><b>Line:</b> <span>'.$row["line"].'</span>';
                $file           .= '<br><b>Request:</b> <span title="'.$row["request_uri"].'">'.Utility::short_text($row["request_uri"],0,80,true).'</span>';
                $error_type     = $row["code"];
            }
            else
            {
                $file           = '<span title="'.$row["errfile"].'">'.Utility::short_text($row["errfile"],0,100,true).'</span>';
                $file           .= '<br><b>Line:</b> <span>'.$row["errline"].'</span>';
                $file           .= '<br><b>Request:</b> <span title="'.$row["request_uri"].'">'.Utility::short_text($row["request_uri"],0,80,true).'</span>';
                $error_type     = $row["errtype"];
            }



            $item   = [];
            array_push($item,$i);
            array_push($item,$type);
            array_push($item,$error_type);
            array_push($item,$file);
            array_push($item,DateManager::format("d/m/Y H:i",$row["date"]));
            array_push($item,$detail_con.'<a data-tooltip="'.__("admin/tools/actions-details").'" class="sbtn" onclick="details('.$id.'); " href="javascript:void 0;"><i class="fa fa-search"></i></a>');

            $items[] = $item;
        }
    }


    return $items;