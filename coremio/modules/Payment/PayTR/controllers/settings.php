<?php
    if(!defined("CORE_FOLDER")) die();

    $lang           = $module->lang;
    $config         = $module->config;

    Helper::Load(["Money"]);

    $payment_type       = Filter::init("POST/payment_type","letters");
    $merchant_id        = Filter::init("POST/merchant_id","letters_numbers");
    $merchant_key       = Filter::init("POST/merchant_key","letters_numbers");
    $merchant_salt      = Filter::init("POST/merchant_salt","letters_numbers");
    $save_card          = (int) Filter::init("POST/save_card","numbers");
    $auto_pay           = (int) Filter::init("POST/auto_pay","numbers");
    $test_mode          = (int) Filter::init("POST/test_mode","numbers");
    $debug_on           = (int) Filter::init("POST/debug_on","numbers");
    $installment        = (int) Filter::init("POST/installment","numbers");
    $max_installment    = (int) Filter::init("POST/max_installment","numbers");
    if($installment) $no_installment = 0;
    else $no_installment = 1;
    $commission_rate     = Filter::init("POST/commission_rate","amount");
    $commission_rate     = str_replace(",",".",$commission_rate);
    $installment_rates   = Filter::POST("installment_rates");

    $sets               = [];

    if(!isset($config["settings"]["payment_type"]) || $payment_type != $config["settings"]["payment_type"])
        $sets["settings"]["payment_type"] = $payment_type;

    if($merchant_id != $config["settings"]["merchant_id"])
        $sets["settings"]["merchant_id"] = $merchant_id;

    if($merchant_key != $config["settings"]["merchant_key"])
        $sets["settings"]["merchant_key"] = $merchant_key;

    if($merchant_salt != $config["settings"]["merchant_salt"])
        $sets["settings"]["merchant_salt"] = $merchant_salt;

    if(!isset($config["settings"]["save_card"]) || $save_card != $config["settings"]["save_card"])
        $sets["settings"]["save_card"] = $save_card;

    if(!isset($config["settings"]["auto_pay"]) || $auto_pay != $config["settings"]["auto_pay"])
        $sets["settings"]["auto_pay"] = $auto_pay;
    
    if($test_mode != $config["settings"]["test_mode"])
        $sets["settings"]["test_mode"] = $test_mode;

    if($debug_on != $config["settings"]["debug_on"])
        $sets["settings"]["debug_on"] = $debug_on;

    if($no_installment != $config["settings"]["no_installment"]) 
        $sets["settings"]["no_installment"] = $no_installment;

    if($max_installment != $config["settings"]["max_installment"])
        $sets["settings"]["max_installment"] = $max_installment;

    if($commission_rate != $config["settings"]["commission_rate"])
        $sets["settings"]["commission_rate"] = $commission_rate;

    if($installment_rates && is_array($installment_rates))
    {
        $installment_rates = Utility::jencode($installment_rates);
        FileManager::file_write(dirname(__DIR__).DS."installment-rates.json",$installment_rates);
    }


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