<?php
    if(!defined("CORE_FOLDER")) die();

    $lang       = $module->lang;
    $config     = $module->config;

    $auth_userid = Filter::init("POST/auth-userid","numbers");
    $api_key     = Filter::init("POST/api-key","hclear");
    if($api_key && $api_key != "*****") $api_key = Crypt::encode($api_key,Config::get("crypt/system"));
    $test_mode      = (int) Filter::init("POST/test-mode","numbers");

    $sets       = [];

    if($auth_userid != $config["settings"]["auth-userid"])
        $sets["settings"]["auth-userid"] = $auth_userid;

    if($api_key != "*****" && $api_key != $config["settings"]["api-key"])
        $sets["settings"]["api-key"] = $api_key;


    if($test_mode != $config["settings"]["test-mode"])
        $sets["settings"]["test-mode"] = $test_mode;


    if(!$module->testConnection(array_replace_recursive($config,$sets)))
        die(Utility::jencode([
            'status' => "error",
            'message' => $module->error,
        ]));

    echo Utility::jencode(['status' => "successful",'message' => $lang["success2"]]);