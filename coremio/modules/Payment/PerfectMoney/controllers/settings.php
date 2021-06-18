<?php
    if(!defined("CORE_FOLDER")) die();

    $lang           = $module->lang;
    $config         = $module->config;

    Helper::Load(["Money"]);

    $id                         = Filter::init("POST/id","hclear");
    $password                   = Filter::init("POST/password","hclear");
    $currency                   = (int) Filter::init("POST/currency","numbers");
    $commission_rate            = Filter::init("POST/commission_rate","amount");
    $commission_rate            = str_replace(",",".",$commission_rate);


    $sets           = [];

    if($id != $config["settings"]["id"])
        $sets["settings"]["id"] = $id;
    
    if($password != $config["settings"]["password"])
        $sets["settings"]["password"] = $password;

    if($currency != $config["settings"]["currency"])
        $sets["settings"]["currency"] = $currency;

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