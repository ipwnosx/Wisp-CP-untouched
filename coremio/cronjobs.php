<?php
    define("CRON",true);
    if(!isset($_SERVER["SERVER_ADDR"])) $_SERVER["SERVER_ADDR"] = "0.0.0.0";
    if(!isset($_SERVER["DOCUMENT_ROOT"]) || $_SERVER["DOCUMENT_ROOT"] == '')
        $_SERVER["DOCUMENT_ROOT"] = realpath("..".DIRECTORY_SEPARATOR);
    if(!isset($_SERVER["PHP_SELF"]) || $_SERVER["PHP_SELF"] == '')
        $_SERVER["PHP_SELF"] = str_replace($_SERVER["DOCUMENT_ROOT"],"",__FILE__);
    if(!isset($_SERVER["REQUEST_URI"]))
        $_SERVER["REQUEST_URI"] = $_SERVER["PHP_SELF"];

    include dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR."index.php";