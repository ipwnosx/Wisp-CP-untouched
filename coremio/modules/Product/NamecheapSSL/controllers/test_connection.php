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

    if(!$module->testConnection(array_replace_recursive($config,$sets)))
        die(Utility::jencode([
            'status' => "error",
            'message' => $module->error,
        ]));

    echo Utility::jencode(['status' => "successful",'message' => $lang["success2"]]);