<?php
    if(!defined("CORE_FOLDER")) die();

    $lang           = $module->lang;
    $config         = $module->config;

    Helper::Load(["Money"]);

    $live_publishable_key           = Filter::init("POST/live_publishable_key","hclear");
    $test_publishable_key           = Filter::init("POST/test_publishable_key","hclear");
    $live_secret_key                = Filter::init("POST/live_secret_key","hclear");
    $test_secret_key                = Filter::init("POST/test_secret_key","hclear");
    $endpoint_secret                = Filter::init("POST/endpoint_secret","hclear");
    $commission_rate                = Filter::init("POST/commission_rate","amount");
    $commission_rate                = str_replace(",",".",$commission_rate);
    $test_mode                      = (bool) (int) Filter::init("POST/test_mode","numbers");

    $sets               = [];

    if($live_publishable_key != $config["settings"]["live_publishable_key"])
        $sets["settings"]["live_publishable_key"] = $live_publishable_key;

    if($test_publishable_key != $config["settings"]["test_publishable_key"])
        $sets["settings"]["test_publishable_key"] = $test_publishable_key;

    if($live_secret_key != $config["settings"]["live_secret_key"])
        $sets["settings"]["live_secret_key"] = $live_secret_key;

    if($test_secret_key != $config["settings"]["test_secret_key"])
        $sets["settings"]["test_secret_key"] = $test_secret_key;

    if($endpoint_secret != $config["settings"]["endpoint_secret"])
        $sets["settings"]["endpoint_secret"] = $endpoint_secret;
    
    
    if($test_mode != $config["settings"]["test_mode"])
        $sets["settings"]["test_mode"] = $test_mode;
    

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