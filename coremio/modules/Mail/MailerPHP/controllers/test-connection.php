<?php
    if(!defined("CORE_FOLDER")) die();

    $lang       = $module->lang;
    $config     = $module->config;

    $type       = (string) Filter::init("POST/type","letters");
    $host       = (string) Filter::init("POST/host","domain");
    $secure     = (string) Filter::init("POST/secure","letters");
    $port       = (int) Filter::init("POST/port","numbers");
    $username   = (string) Filter::init("POST/username","email");
    $password   = (string) Filter::init("POST/password","password");
    if($password == "*****") $password = Crypt::decode($config["password"],Config::get("crypt/user"));
    $fname      = (string) Filter::init("POST/fname","hclear");

    $test       = $module->testConnect($type,$host,$secure,$port,$username,$password,$fname);

    if($test){
        echo Utility::jencode(['status' => "successful",'message' => $lang["success1"] ]);
    }else{
        $msg = $lang["error1"];
        if($module->error) $msg .= " - ".$module->error;

        echo Utility::jencode([
            'status' => "error",
            'message' => $msg,
        ]);
    }