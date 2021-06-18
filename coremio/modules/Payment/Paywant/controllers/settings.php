<?php
    if(!defined("CORE_FOLDER")) die();

    $lang           = $module->lang;
    $config         = $module->config;

    Helper::Load(["Money"]);

    $api_key        = Filter::init("POST/api_key","hclear");
    $api_secret_key       = Filter::init("POST/api_secret_key","hclear");
    $commission_type     = Filter::init("POST/commission_type","numbers");
    $commission_multiplier     = Filter::init("POST/commission_multiplier","amount");
    // $commission_multiplier     = str_replace(",",".",$commission_rate);

    $sets               = [];

    if($api_key != $config["settings"]["api_key"])
        $sets["settings"]["api_key"] = $api_key;

    if($api_secret_key != $config["settings"]["api_secret_key"])
        $sets["settings"]["api_secret_key"] = $api_secret_key;

    if($commission_type != $config["settings"]["commission_type"])
        $sets["settings"]["commission_type"] = $commission_type;
	   
	 if($commission_multiplier != $config["settings"]["commission_multiplier"])
        $sets["settings"]["commission_multiplier"] = $commission_multiplier;
	
    

    if($sets){
        $config_result  = array_replace_recursive($config,$sets);
        $array_export   = Utility::array_export($config_result,['pwith' => true]);

        $file           = dirname(__DIR__).DS."config.php";
        $write          = FileManager::file_write($file,$array_export);

        $adata          = UserManager::LoginData("admin");
        User::addAction($adata["id"],"alteration","changed-payment-module-settings",[
            'module' => $config["meta"]["name"],
            'name'   => $lang["name"],
        ]);
    }

    echo Utility::jencode([
        'status' => "successful",
        'message' => $lang["success1"],
    ]);