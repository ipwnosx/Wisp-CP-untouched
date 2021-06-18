<?php
    if(!defined("CORE_FOLDER")) die();

    $lang           = $module->lang;
    $config         = $module->config;

    Helper::Load(["Money"]);

    $api_key            = Filter::init("POST/api_key","hclear");
    $api_secret         = Filter::init("POST/api_secret","hclear");
    $commission_rate     = Filter::init("POST/commission_rate","amount");
    $commission_rate     = str_replace(",",".",$commission_rate);

    $sets               = [];

    if($api_key != $config["settings"]["api_key"])
        $sets["settings"]["api_key"] = $api_key;

    if($api_secret != $config["settings"]["api_secret"])
        $sets["settings"]["api_secret"] = $api_secret;

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