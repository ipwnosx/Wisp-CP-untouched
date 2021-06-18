<?php
    if(!defined("CORE_FOLDER")) die();

    $lang       = $module->lang;
    $config     = $module->config;

    $payment_id         = Filter::init("POST/payment-id","hclear");
    $coupon             = Filter::init("POST/coupon","hclear");
    $auto_renew         = Filter::init("POST/auto-renew","numbers");
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

    if($payment_id != $config["settings"]["payment-id"])
        $sets["settings"]["payment-id"] = $payment_id;

    if($coupon != $config["settings"]["coupon"])
        $sets["settings"]["coupon"] = $coupon;

    if($auto_renew != $config["settings"]["auto-renew"])
        $sets["settings"]["auto-renew"] = $auto_renew;

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