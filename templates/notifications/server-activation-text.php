<?php
    if(isset($options["ip"]) && $options["ip"]){

        echo Bootstrap::$lang->get_cm("website/account_products/server-info-notification-ip",false,$udata["lang"]).": ";
        echo $options["ip"];
        echo "\n";
    }

    if(isset($options["hostname"]) && $options["hostname"]){
        echo "Hostname: ";
        echo $options["hostname"];
        echo "\n";
    }

    if(isset($options["ns1"]) && $options["ns1"]){
        echo "NS1: ";
        echo $options["ns1"];
        echo "\n";
    }

    if(isset($options["ns2"]) && $options["ns2"]){
        echo "NS2: ";
        echo $options["ns2"];
        echo "\n";
    }

    if(isset($options["login"]["username"]) && $options["login"]["username"]){
        echo Bootstrap::$lang->get_cm("website/account_products/server-info-notification-username",false,$udata["lang"]).": ";
        echo $options["login"]["username"];
        echo "\n";
    }

    if(isset($options["login"]["password"]) && $options["login"]["password"]){
        echo Bootstrap::$lang->get_cm("website/account_products/server-info-notification-password",false,$udata["lang"]).": ";
        echo $options["login"]["password"];
        echo "\n";
    }

    if(isset($options["descriptions"]) && $options["descriptions"]){
        echo "\n";
        echo $options["descriptions"];
        echo "\n";
    }