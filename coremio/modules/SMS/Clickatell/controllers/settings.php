<?php
    if(!defined("CORE_FOLDER")) die();

    $lang           = $module->lang;
    $config         = $module->config;

    $api_key        = (string) Filter::init("POST/api-key","hclear");
    $from_number    = (string) Filter::init("POST/from-number","hclear");

    $sets       = [];

    $sets["api-key"] = $api_key;
    $sets["from-number"] = $from_number;

    if($sets){
        $config_result  = array_replace_recursive($config,$sets);
        $array_export   = Utility::array_export($config_result,['pwith' => true]);
        $file           = dirname(__DIR__).DS."config.php";
        $write          = FileManager::file_write($file,$array_export);

        $adata          = UserManager::LoginData("admin");
        User::addAction($adata["id"],"alteration","changed-sms-module-settings",[
            'module' => $config["meta"]["name"],
            'name'   => $lang["name"],
        ]);
    }

    echo Utility::jencode([
        'status' => "successful",
        'message' => $lang["success1"],
    ]);