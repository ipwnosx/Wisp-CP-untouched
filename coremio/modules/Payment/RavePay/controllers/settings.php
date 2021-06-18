<?php
    if(!defined("CORE_FOLDER")) die();

    $lang           = $module->lang;
    $config         = $module->config;
    
    $public_key             = Filter::init("POST/public_key","hclear");
    $secret_key             = Filter::init("POST/secret_key","hclear");
    $commission_rate        = Filter::init("POST/commission_rate","amount");
    $commission_rate        = str_replace(",",".",$commission_rate);


    $sets           = [];

    if($public_key != $config["settings"]["public_key"])
        $sets["settings"]["public_key"] = $public_key;

    if($secret_key != $config["settings"]["secret_key"])
        $sets["settings"]["secret_key"] = $secret_key;

    if($commission_rate != $config["settings"]["commission_rate"])
        $sets["settings"]["commission_rate"] = $commission_rate;


    if($sets){
        $config_result  = array_replace_recursive($config,$sets);
        $array_export   = Utility::array_export($config_result,['pwith' => true]);

        $file           = dirname(__DIR__).DS."config.php";
        $write          = FileManager::file_write($file,$array_export);

        $adata          = UserManager::LoginData("admin");
        User::addAction($adata["id"],"alteration","changed-payment-module-settings",[
            'module' => $config["meta"]["name"],
            'name'   => $lang["name"],
        ]);
    }

    echo Utility::jencode([
        'status' => "successful",
        'message' => $lang["success1"],
    ]);