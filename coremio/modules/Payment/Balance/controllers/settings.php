<?php
    if(!defined("CORE_FOLDER")) die();

    $lang           = $module->lang;
    $config         = $module->config;

    Helper::Load(["Money"]);

    $status             = (bool) Filter::init("POST/status","numbers");
    $auto_payment       = (bool) Filter::init("POST/auto-payment","numbers");
    $min_amount         = Filter::init("POST/min-amount","amount");
    $min_amount_cid     = (int) Filter::init("POST/min-amount-cid","numbers");
    $min_amount         = Money::deformatter($min_amount,$min_amount_cid);

    $sets               = [];

    if($status != $config["settings"]["status"])
        $sets["settings"]["status"] = $status;

    if($auto_payment != $config["settings"]["auto-payment"])
        $sets["settings"]["auto-payment"] = $auto_payment;

    if($min_amount != $config["settings"]["min-amount"])
        $sets["settings"]["min-amount"] = $min_amount;

    if($min_amount_cid != $config["settings"]["min-amount-cid"])
        $sets["settings"]["min-amount-cid"] = $min_amount_cid;


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