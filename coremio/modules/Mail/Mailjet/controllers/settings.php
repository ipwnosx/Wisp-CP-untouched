<?php
    if(!defined("CORE_FOLDER")) die();

    $lang       = $module->lang;
    $config     = $module->config;
    
    $api_key_public     = Filter::init("POST/api-key-public","hclear");
    $api_key_private    = Filter::init("POST/api-key-private","hclear");
    $femail             = Filter::init("POST/femail","email");
    $fname              = Filter::init("POST/fname","hclear");

    if($api_key_public && $api_key_public != "*****") $api_key_public = Crypt::encode($api_key_public,Config::get("crypt/user"));
    if($api_key_private && $api_key_private != "*****") $api_key_private = Crypt::encode($api_key_private,Config::get("crypt/user"));

    $sets       = [];
    
    if($api_key_public != "*****" && $api_key_public !=  $config["api-key-public"]) $sets["api-key-public"] = $api_key_public;
    if($api_key_private !=  $config["api-key-private"]) $sets["api-key-private"] = $api_key_private;
    if($femail != $config["femail"]) $sets["femail"] = $femail;
    if($fname != $config["fname"]) $sets["fname"] = $fname;

    if($sets){
        $config_result  = array_replace_recursive($config,$sets);
        $array_export   = Utility::array_export($config_result,['pwith' => true]);
        $file           = dirname(__DIR__).DS."config.php";
        $write          = FileManager::file_write($file,$array_export);

        $adata          = UserManager::LoginData("admin");
        User::addAction($adata["id"],"alteration","changed-mail-module-settings",[
            'module' => $config["meta"]["name"],
            'name'   => $lang["name"],
        ]);
    }

    echo Utility::jencode([
        'status' => "successful",
        'message' => $lang["success1"],
    ]);