<?php
    if(!defined("CORE_FOLDER")) die();
    $LANG       = $module->lang;
    $CONFIG     = $module->config;
    $images_url = RESOURCE_DIR."uploads".DS."modules".DS."Payment".DS."BankTransfer".DS;


    $lang_list  = Bootstrap::$lang->rank_list();
    Utility::sksort($lang_list,"local");

    Helper::Load("Uploads");
    $upload = Helper::get("Uploads");


    foreach($lang_list AS $k=>$lang){
        $lkey = $lang["key"];

        $accountsw  = dirname(__DIR__).DS."bank-accounts-".$lkey.".json";
        $accounts   = FileManager::file_read($accountsw);
        if($accounts) $accounts   = Utility::jdecode($accounts,true);
        else $accounts = [];
        $count      = sizeof($accounts);

        $deleted    = Filter::POST("deleted/".$lkey);
        $type       = Filter::POST("type/".$lkey);
        $status     = Filter::POST("status/".$lkey);
        $name       = Filter::POST("name/".$lkey);
        $swiftc     = Filter::POST("swiftc/".$lkey);
        $iban       = Filter::POST("iban/".$lkey);
        $anumber    = Filter::POST("account_number/".$lkey);
        $buyer_name = Filter::POST("buyer_name/".$lkey);
        $branch_nc  = Filter::POST("branch_nc/".$lkey);
        $cimages    = [];

        for($i=0;$i<=$count-1;$i++){
            if(isset($accounts[$i])){
                $ac = $accounts[$i];
                if($deleted && in_array($ac["id"],$deleted)){
                    if(!Validation::isEmpty($ac["image"])) FileManager::file_delete($images_url.$ac["image"]);
                    unset($accounts[$i]);
                }else{
                    if($ac["image"] != '') $cimages[$ac["id"]] = $ac["image"];
                }
            }
        }
        $accounts       = array_values($accounts);

        $new_accounts   = [];
        if($type){
            foreach($type AS $id=>$t){
                $id             = (int) $id;
                $u_status       = isset($status[$id]) ? $status[$id] : false;
                $u_name         = $name[$id];
                $u_swiftc       = $swiftc[$id];
                $u_iban         = $iban[$id];
                $u_anumber      = $anumber[$id];
                $u_buyer_name   = $buyer_name[$id];
                $u_branch_nc    = $branch_nc[$id];
                $u_image        = Filter::FILES($lkey."-image-".$id);
                if($u_image){
                    $upload->init($u_image,[
                        'image-upload' => true,
                        'date' => false,
                        'folder' => $images_url,
                        'width'  => 175,
                        'height' => false,
                        'allowed-ext' => "image/*",
                        'file-name' => "random",
                    ]);
                    if(!$upload->processed())
                        die(Utility::jencode([
                            'status' => "error",
                            'for' => "#banktransfer-".$lkey." input[name='image["+$id+"]']",
                            'message' => "Upload Error : ".$upload->error
                        ]));
                    $picture = current($upload->operands);
                    $u_image = $picture["file_path"];

                }else{
                    if($t == "current" && isset($cimages[$id])) $u_image = $cimages[$id];
                }

                $new_accounts[] = [
                    'id' => $id,
                    'status' => $u_status,
                    'image' => $u_image,
                    'name' => $u_name,
                    'swiftc' => $u_swiftc,
                    'iban' => $u_iban,
                    'buyer_name' => $u_buyer_name,
                    'account_number' => $u_anumber,
                    'branch_nc' => $u_branch_nc,
                ];
            }
            $accounts = $new_accounts;
        }

        $accounts               = Utility::jencode($accounts);

        $write                  = FileManager::file_write($accountsw,$accounts);
    }


    $adata      = UserManager::LoginData("admin");
    User::addAction($adata["id"],"alteration","changed-module-settings",[
        'type' => "Payment",
        'module' => "BankTransfer",
    ]);


    echo Utility::jencode([
        'status' => "successful",
        'message' => $LANG["success1"]
    ]);