<?php
    if(!defined("CORE_FOLDER")) die();

    $lang       = $module->lang;
    $config     = $module->config;

    $username   = Filter::init("POST/username","hclear");
    $password   = Filter::init("POST/password","hclear");
    if($password && $password != "*****") $password = Crypt::encode($password,Config::get("crypt/system"));
    $test_mode      = (int) Filter::init("POST/test-mode","numbers");

    $sets       = [];

    if($username != $config["settings"]["username"])
        $sets["settings"]["username"] = $username;

    if($password != "*****" && $password != $config["settings"]["password"])
        $sets["settings"]["password"] = $password;

    if($test_mode != $config["settings"]["test-mode"])
        $sets["settings"]["test-mode"] = $test_mode;

    if(!$module->testConnection(array_replace_recursive($config,$sets)))
        die(Utility::jencode([
            'status' => "error",
            'message' => $module->error,
        ]));

    echo Utility::jencode(['status' => "successful",'message' => $lang["success2"]]);