<?php
    if(!defined("CORE_FOLDER")) die();

    $lang       = $module->lang;
    $config     = $module->config;

    $serverHost         = Filter::init("POST/serverHost","hclear");
    $serverUsername     = Filter::init("POST/serverUsername","hclear");
    $serverPassword     = Filter::init("POST/serverPassword","password");
    if($serverPassword && $serverPassword != "*****") $serverPassword = Crypt::encode($serverPassword,Config::get("crypt/system"));
    $serverContext      = Filter::init("POST/serverContext","hclear");
    $nameServers        = Filter::init("POST/nameServers");
    $domainMX           = Filter::init("POST/domainMX","hclear");
    $domainIP           = Filter::init("POST/domainIP","hclear");
    $adminContact       = Filter::init("POST/adminContact","hclear");

    $whidden_amount     = (float) Filter::init("POST/whidden-amount","amount");
    $whidden_curr       = (int) Filter::init("POST/whidden-currency","numbers");
    $test_mode          = (int) Filter::init("POST/test-mode","numbers");

    $sets       = [];

    if($serverHost != $config["settings"]["serverHost"])
        $sets["settings"]["serverHost"] = $serverHost;

    if($serverUsername != $config["settings"]["serverUsername"])
        $sets["settings"]["serverUsername"] = $serverUsername;

    if($serverPassword != "*****" && $serverPassword != $config["settings"]["serverPassword"])
        $sets["settings"]["serverPassword"] = $serverPassword;

    if($serverContext != $config["settings"]["serverContext"])
        $sets["settings"]["serverContext"] = $serverContext;

    if($nameServers != $config["settings"]["nameServers"])
        $sets["settings"]["nameServers"] = $nameServers;

    if($domainMX != $config["settings"]["domainMX"])
        $sets["settings"]["domainMX"] = $domainMX;

    if($domainIP != $config["settings"]["domainIP"])
        $sets["settings"]["domainIP"] = $domainIP;

    if($adminContact != $config["settings"]["adminContact"])
        $sets["settings"]["adminContact"] = $adminContact;


    if($whidden_amount != $config["settings"]["whidden-amount"])
        $sets["settings"]["whidden-amount"] = $whidden_amount;

    if($whidden_curr != $config["settings"]["whidden-currency"])
        $sets["settings"]["whidden-currency"] = $whidden_curr;

    if($test_mode != $config["settings"]["test-mode"])
        $sets["settings"]["test-mode"] = $test_mode;


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