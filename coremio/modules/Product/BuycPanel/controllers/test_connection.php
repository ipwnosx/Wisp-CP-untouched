<?php
    if(!defined("CORE_FOLDER")) die();

    $lang       = $module->lang;
    $config     = $module->config;

    $login          = Filter::init("POST/login","hclear");
    $key            = Filter::init("POST/key","hclear");
    if($key && $key != "*****") $key = Crypt::encode($key,Config::get("crypt/system"));
    $test_mode      = (int) Filter::init("POST/test-mode","numbers");

    $sets       = [];

    if($login != $config["settings"]["login"])
        $sets["settings"]["login"] = $login;

    if($key != "*****" && $key != $config["settings"]["key"])
        $sets["settings"]["key"] = $key;

    if($test_mode != $config["settings"]["test-mode"])
        $sets["settings"]["test-mode"] = $test_mode;

    if(!$module->testConnection(array_replace_recursive($config,$sets)))
        die(Utility::jencode([
            'status' => "error",
            'message' => $module->error,
        ]));

    echo Utility::jencode(['status' => "successful",'message' => $lang["success2"]]);