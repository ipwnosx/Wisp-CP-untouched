<?php
    if(!defined("CORE_FOLDER")) die();

    $lang           = $module->lang;
    $config         = $module->config;

    Helper::Load(["Money"]);

    $email               = Filter::init("POST/email","email");
    $subscription_s      = Filter::init("POST/subscription_status");
    $client_id           = Filter::init("POST/client_id");
    $secret_key          = Filter::init("POST/secret_key");
    $commission_rate     = Filter::init("POST/commission_rate","amount");
    $commission_rate     = str_replace(",",".",$commission_rate);
    $convert_to          = (int) Filter::init("POST/convert_to","numbers");
    $sandbox             = (bool) (int) Filter::init("POST/sandbox","numbers");


    $sets           = [];
    $remove_auth    = false;


    if($email != $config["settings"]["email"])
        $sets["settings"]["email"] = $email;

    if($subscription_s != $config["settings"]["subscription_status"])
        $sets["settings"]["subscription_status"] = $subscription_s;

    if($client_id != $config["settings"]["client_id"])
    {
        $sets["settings"]["client_id"] = $client_id;
        $remove_auth = true;
    }

    if($secret_key != $config["settings"]["secret_key"])
    {
        $sets["settings"]["secret_key"] = $secret_key;
        $remove_auth = true;
    }


    if($convert_to != $config["settings"]["convert_to"])
        $sets["settings"]["convert_to"] = $convert_to;

    if($sandbox != $config["settings"]["sandbox"])
        $sets["settings"]["sandbox"] = $sandbox;


    if($sets){
        $config_result  = array_replace_recursive($config,$sets);

        $test       = $module->testConnection($config_result);

        if(!$test)
        {
            die(Utility::jencode([
                'status' => "error",
                'message' => $module->error,
            ]));
        }

    }

    echo Utility::jencode([
        'status' => "successful",
        'message' => $lang["success2"],
    ]);