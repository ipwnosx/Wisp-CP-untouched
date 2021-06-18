<?php
    if(!defined("CORE_FOLDER")) die();

    $lang           = $module->lang;
    $config         = $module->config;

    Helper::Load(["Money"]);

    $merchant_email             = Filter::init("POST/merchant_email","hclear");
    $secret_word                   = Filter::init("POST/secret_word","hclear");
    $currency                   = (int) Filter::init("POST/currency","numbers");
    $commission_rate            = Filter::init("POST/commission_rate","amount");
    $commission_rate            = str_replace(",",".",$commission_rate);


    $sets           = [];

    if($merchant_email != $config["settings"]["merchant_email"])
        $sets["settings"]["merchant_email"] = $merchant_email;
    
    if($secret_word != $config["settings"]["secret_word"])
        $sets["settings"]["secret_word"] = $secret_word;

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