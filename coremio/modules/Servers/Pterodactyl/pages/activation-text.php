<?php
    if(isset($options["ip"]) && $options["ip"]){

        echo "IP: ";
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
        echo "Username: ";
        echo $options["login"]["username"];
        echo "\n";
    }

    if(isset($options["login"]["password"]) && $options["login"]["password"]){
        echo "Password: ";
        echo $options["login"]["password"];
        echo "\n";
    }
    if(isset($options["descriptions"]) && $options["descriptions"]){
        echo $options["descriptions"];
        echo "\n";
    }