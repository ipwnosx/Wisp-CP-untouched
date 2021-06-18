<?php
    if(!defined("CORE_FOLDER")) die();

    $lang       = $module->lang;
    $config     = $module->config;

    $username           = Filter::init("POST/username","hclear");
    $username_sandbox   = Filter::init("POST/username-sandbox","hclear");
    $coupon             = Filter::init("POST/coupon","hclear");
    $api_key            = Filter::init("POST/api-key","hclear");
    $api_key_sandbox    = Filter::init("POST/api-key-sandbox","hclear");
    if($api_key && $api_key != "*****") $api_key = Crypt::encode($api_key,Config::get("crypt/system"));
    if($api_key_sandbox && $api_key_sandbox != "*****") $api_key_sandbox = Crypt::encode($api_key_sandbox,Config::get("crypt/system"));
    $test_mode      = (int) Filter::init("POST/test-mode","numbers");
    $whidden_amount = (float) Filter::init("POST/whidden-amount","amount");
    $whidden_curr   = (int) Filter::init("POST/whidden-currency","numbers");
    $adp            = (bool) (int) Filter::init("POST/adp","numbers");
    $cost_cid       = 4;

    $sets           = [];

    if($api_key != "*****" && $api_key != $config["settings"]["api-key"])
        $sets["settings"]["api-key"] = $api_key;

    if($api_key_sandbox != "*****" && $api_key_sandbox != $config["settings"]["api-key-sandbox"])
        $sets["settings"]["api-key-sandbox"] = $api_key_sandbox;

    if($test_mode != $config["settings"]["test-mode"])
        $sets["settings"]["test-mode"] = $test_mode;

    if($username != $config["settings"]["username"])
        $sets["settings"]["username"] = $username;

    if($username_sandbox != $config["settings"]["username-sandbox"])
        $sets["settings"]["username-sandbox"] = $username_sandbox;

    if($coupon != $config["settings"]["coupon"])
        $sets["settings"]["coupon"] = $coupon;

    if($whidden_amount != $config["settings"]["whidden-amount"])
        $sets["settings"]["whidden-amount"] = $whidden_amount;

    if($whidden_curr != $config["settings"]["whidden-currency"])
        $sets["settings"]["whidden-currency"] = $whidden_curr;

    if(!isset($config["settings"]["adp"]) || $adp != $config["settings"]["adp"])
        $sets["settings"]["adp"] = $adp;

    if(!isset($config["settings"]["cost-currency"]) || $cost_cid != $config["settings"]["cost-currency"])
        $sets["settings"]["cost-currency"] = $cost_cid;

    if(!$module->testConnection(array_replace_recursive($config,$sets)))
        die(Utility::jencode([
            'status' => "error",
            'message' => $module->error,
        ]));

    $profit_rate    = (float) Filter::init("POST/profit-rate","amount");
    $export = Utility::array_export(Config::set("options",["domain-profit-rate" => $profit_rate]),['pwith' => true]);
    FileManager::file_write(CONFIG_DIR."options.php",$export);



    if($sets){
        $config_result  = array_replace_recursive($config,$sets);
        $array_export   = Utility::array_export($config_result,['pwith' => true]);
        $file           = dirname(__DIR__).DS."config.php";
        $write          = FileManager::file_write($file,$array_export);

        $adata          = UserManager::LoginData("admin");
        User::addAction($adata["id"],"alteration","changed-registrars-module-settings",[
            'module' => $config["meta"]["name"],
            'name'   => $lang["name"],
        ]);
    }

    echo Utility::jencode([
        'status' => "successful",
        'message' => $lang["success1"],
    ]);