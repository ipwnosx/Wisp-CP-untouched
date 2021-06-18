<?php
    $items  = [];

    if(isset($list) && $list){
        foreach($list AS $i=>$row){
            $id     = $row["id"];

            $data   = $row["data"];
            if($data){
                $json   = Utility::jdecode($data,true);
                if($json) $data = $json;
            }


            $detail_con = '';
            $detail_con .= '<div id="detail_con_'.$id.'" style="display:none;">';

            $request    = isset($data["request"]) ? $data["request"] : '';
            $request_j  = Utility::jdecode($request,true);
            $request    = $request_j ? json_encode($request_j, JSON_PRETTY_PRINT) : $request;

            $response    = isset($data["response"]) ? $data["response"] : '';
            $response_j  = Utility::jdecode($response,true);
            $response    = $response_j ? json_encode($response_j, JSON_PRETTY_PRINT) : $response;

            $processed    = isset($data["processed"]) ? $data["processed"] : '';
            $processed_j  = Utility::jdecode($processed,true);
            $processed    = $processed_j ? json_encode($processed_j, JSON_PRETTY_PRINT) : $processed;


            $detail_con .= '<h4>REQUEST</h4>';
            $detail_con .= '<pre><code>'.($request ? $request : ___("needs/null")).'</code></pre>';


            $detail_con .= '<h4>RESPONSE</h4>';
            $detail_con .= '<pre><code>'.($response ? $response : ___("needs/null")).'</code></pre>';
        

            $detail_con .= '<h4>PROCESSED</h4>';
            $detail_con .= '<pre><code>'.($processed ? $processed : ___("needs/null")).'</code></pre>';

            $detail_con .= '</div>';


            $item   = [];
            array_push($item,$i);
            array_push($item,isset($data['type']) ? $data['type'] : '-');
            array_push($item,$data['module']);
            array_push($item,isset($data["method"]) ? $data["method"] : (isset($data["action"]) ? $data["action"] : '-'));
            array_push($item,$row["date"]);
            array_push($item,$row["ip"]);
            array_push($item,$detail_con.'<a data-tooltip="'.__("admin/tools/actions-details").'" class="sbtn" onclick="details('.$id.'); " href="javascript:void 0;"><i class="fa fa-search"></i></a>');

            $items[] = $item;
        }
    }


    return $items;