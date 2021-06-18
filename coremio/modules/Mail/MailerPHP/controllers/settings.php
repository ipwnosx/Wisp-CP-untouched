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
    $fname      = (string) Filter::init("POST/fname","hclear");

    $sets       = [];

    if($type != $config["type"]) $sets["type"] = $type;
    if($host != $config["host"]) $sets["host"] = $host;
    if($secure != $config["secure"]) $sets["secure"] = $secure;
    if($port != $config["port"]) $sets["port"] = $port;
    if($username != $config["username"]) $sets["username"] = $username;
    if($password != "*****" && $password != Crypt::decode($config["password"],Config::get("crpyt/user")))
        $sets["password"] = Crypt::encode($password,Config::get("crypt/user"));
    if($fname != $config["fname"]) $sets["fname"] = $fname;

    if($sets){
        $config_result  = array_replace_recursive($config,$sets);
        $array_export   = Utility::array_export($config_result,['pwith' => true]);
        $file           = dirname(__DIR__).DS."config.php";
        $write          = FileManager::file_write($file,$array_export);

        $adata          = UserManager::LoginData("admin");
        User::addAction($adata["id"],"alteration","changed-mail-module-settings",[
            'module' => $config["meta"]["name"],
            'name'   => $lang["name"],
        ]);
    }

    echo Utility::jencode([
        'status' => "successful",
        'message' => $lang["settings-save-successful"],
    ]);