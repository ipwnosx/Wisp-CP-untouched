<?php
    if(!defined("CORE_FOLDER")) die();

    $lang           = $module->lang;
    $config         = $module->config;

    Helper::Load(["Money"]);

    $sid                 = Filter::init("POST/sid","numbers");
    $secret_word         = Filter::init("POST/secret_word","hclear");
    $commission_rate     = Filter::init("POST/commission_rate","amount");
    $commission_rate     = str_replace(",",".",$commission_rate);
    $demo                = (bool) (int) Filter::init("POST/demo","numbers");
    $sandbox             = (bool) (int) Filter::init("POST/sandbox","numbers");

    if($secret_word != "*****" && $secret_word != '')
        $secret_word     = Crypt::encode($secret_word,Config::get("crypt/system"));


    $sets               = [];

    if($sid != $config["settings"]["sid"])
        $sets["settings"]["sid"] = $sid;

    if($secret_word != "*****" && $secret_word != $config["settings"]["secret_word"])
        $sets["settings"]["secret_word"] = $secret_word;



    if($test_mode != $config["settings"]["test_mode"])
        $sets["settings"]["test_mode"] = $test_mode;

    if($demo != $config["settings"]["demo"])
        $sets["settings"]["demo"] = $demo;

    if($sandbox != $config["settings"]["sandbox"])
        $sets["settings"]["sandbox"] = $sandbox;

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