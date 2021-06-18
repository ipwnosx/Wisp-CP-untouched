<?php
    if(!defined("CORE_FOLDER")) die();

    $lang           = $module->lang;
    $config         = $module->config;

    Helper::Load(["Money"]);

    $merchant_id                = Filter::init("POST/merchant_id","hclear");
    $ipn_secret                 = Filter::init("POST/ipn_secret","hclear");
    $email                      = Filter::init("POST/email","hclear");
    $want_shipping              = (bool) (int) Filter::init("POST/want_shipping","numbers");
    $commission_rate            = Filter::init("POST/commission_rate","amount");
    $commission_rate            = str_replace(",",".",$commission_rate);


    $sets           = [];

    if($merchant_id != $config["settings"]["merchant_id"])
        $sets["settings"]["merchant_id"] = $merchant_id;
    
    if($ipn_secret != $config["settings"]["ipn_secret"])
        $sets["settings"]["ipn_secret"] = $ipn_secret;

    if($want_shipping != $config["settings"]["want_shipping"])
        $sets["settings"]["want_shipping"] = $want_shipping;

    if($email != $config["settings"]["email"])
        $sets["settings"]["email"] = $email;

    if($commission_rate != $config["settings"]["commission_rate"])
        $sets["settings"]["commission_rate"] = $commission_rate;


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