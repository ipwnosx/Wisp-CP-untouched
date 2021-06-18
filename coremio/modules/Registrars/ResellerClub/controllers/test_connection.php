<?php
    if(!defined("CORE_FOLDER")) die();

    $lang       = $module->lang;
    $config     = $module->config;

    $auth_userid = Filter::init("POST/auth-userid","numbers");
    $api_key     = Filter::init("POST/api-key","hclear");
    if($api_key && $api_key != "*****") $api_key = Crypt::encode($api_key,Config::get("crypt/system"));
    $whidden_amount = (float) Filter::init("POST/whidden-amount","amount");
    $whidden_curr   = (int) Filter::init("POST/whidden-currency","numbers");
    $test_mode      = (int) Filter::init("POST/test-mode","numbers");
    $adp            = (bool) (int) Filter::init("POST/adp","numbers");
    $cost_cid       = (int) Filter::init("POST/cost-currency","numbers");

    $sets       = [];

    if($auth_userid != $config["settings"]["auth-userid"])
        $sets["settings"]["auth-userid"] = $auth_userid;

    if($api_key != "*****" && $api_key != $config["settings"]["api-key"])
        $sets["settings"]["api-key"] = $api_key;


    if($whidden_amount != $config["settings"]["whidden-amount"])
        $sets["settings"]["whidden-amount"] = $whidden_amount;

    if($whidden_curr != $config["settings"]["whidden-currency"])
        $sets["settings"]["whidden-currency"] = $whidden_curr;

    if($test_mode != $config["settings"]["test-mode"])
        $sets["settings"]["test-mode"] = $test_mode;

    if($adp != $config["settings"]["adp"])
        $sets["settings"]["adp"] = $adp;

    if($cost_cid != $config["settings"]["cost-currency"])
        $sets["settings"]["cost-currency"] = $cost_cid;

    if(!$module->testConnection(array_replace_recursive($config,$sets)))
        die(Utility::jencode([
            'status' => "error",
            'message' => $module->error,
        ]));

    echo Utility::jencode(['status' => "successful",'message' => $lang["success2"]]);