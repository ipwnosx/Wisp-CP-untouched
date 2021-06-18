<?php
    @ob_start();
    @session_start();
    @set_time_limit(0);
    date_default_timezone_set("Europe/Istanbul");

    define("DS",DIRECTORY_SEPARATOR);
    define("CORE_FOLDER","coremio");
    define("ROOT_DIR",__DIR__.DS);
    define("CORE_DIR",ROOT_DIR.CORE_FOLDER.DS);
    define("TEMPLATE_DIR",ROOT_DIR."templates".DS."system".DS);
    define("CONFIG_DIR",ROOT_DIR.CORE_FOLDER.DS."configuration".DS);
    define("LOCALE_DIR",ROOT_DIR.CORE_FOLDER.DS."locale".DS);

    if(!file_exists(CONFIG_DIR."general.php")) die(CONFIG_DIR."general.php File Not Found.");

    $general_file = CONFIG_DIR."general.php";
    $general    = include $general_file;
    $general    = $general["general"];
    $clang      = $general["local"];

    $s_lang     = isset($_SESSION["lang"]) ? $_SESSION["lang"] : false;
    if($s_lang) $clang  = $s_lang;
    else $_SESSION["lang"] = $clang;

    $lfile      = LOCALE_DIR.$clang.DS."cm".DS."system".DS."install.php";

    if(!file_exists($lfile))
        die($lfile." Language File Not Found.");
    $lang       = include $lfile;

    function wcp_glob($pattern, $flags = 0,$recursive=false){
        if(!function_exists("glob")) return false;
        if ($recursive){
            if(!function_exists('glob_recursive')){
                // Does not support flag GLOB_BRACE
                function glob_recursive($pattern, $flags = 0){
                    $files = glob($pattern, $flags);
                    foreach (glob(dirname($pattern).DS.'*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir)
                        $files = array_merge($files, glob_recursive($dir.DS.basename($pattern), $flags));
                    return $files;
                }
            }
            return glob_recursive($pattern,$flags);
        }else
            return glob($pattern,$flags);
    }

    function isSSL(){
        if(isset($_SERVER['https']) && $_SERVER['https'] == 'on' || isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')
            return true;
        elseif(isset($_SERVER['HTTP_X_FORWARDED_PORT']) && $_SERVER['HTTP_X_FORWARDED_PORT'] == '443')
            return true;
        elseif(!empty( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' )
            return true;

        return false;
    }
    function get_phpinfo_content(){
        ob_start();
        phpinfo(INFO_GENERAL);
        $aux = str_replace('&nbsp;', ' ', ob_get_clean());
        if($aux !== false){
            return $aux;
        }
        return false;
    }
    function GetIonCubeLoaderVersion($aux=''){
        if($aux !== false)
        {
            $pos = stripos($aux, 'ionCube PHP Loader');
            if($pos !== false)
            {
                $aux = substr($aux, $pos + 18);
                $aux = substr($aux, stripos($aux, ' v') + 2);

                $version = '';
                $c = 0;
                $char = substr($aux, $c++, 1);
                while(strpos('0123456789.', $char) !== false)
                {
                    $version .= $char;
                    $char = substr($aux, $c++, 1);
                }
                return $version;
            }
        }
        return false;
    }
    function requirement_tester(){
        global $address;
        $php                = version_compare(PHP_VERSION, '7.2.0', '>=');
        $php_v              = phpversion();
        $phpinfo            = get_phpinfo_content();
        $ioncube            = $phpinfo ? true : false;
        $ioncube_v          = GetIonCubeLoaderVersion($phpinfo);
        $curl               = false;
        $pdo                = false;
        $zip                = false;
        $mbstring           = false;
        $openssl            = false;
        $gd                 = false;
        $intl               = false;
        $file_get_put       = true;
        $glob               = false;


        foreach(get_loaded_extensions() as $name){
            $name   = strtolower($name);
            if($name == "ioncube loader") $ioncube = true;
            elseif($name == "zlib") $zip = true;
            elseif($name == "pdo_mysql") $pdo = true;
            elseif($name == "curl") $curl = true;
            elseif($name == "mbstring") $mbstring = true;
            elseif($name == "openssl") $openssl = true;
            elseif($name == "gd") $gd = true;
            elseif($name == "intl") $intl = true;
        }
        if(function_exists("glob")) $glob = true;
        if(!function_exists('curl_init') OR !function_exists('curl_exec') OR !function_exists('curl_setopt')) $curl = false;
        if(!function_exists("fopen") || !function_exists("fwrite") || !function_exists("file_get_contents") || !function_exists("file_put_contents")) $file_get_put = false;

        if($ioncube) $ioncube = $ioncube_v >= 9.0;

        $files              = [];
        $files[]            = ROOT_DIR."resources".DS."uploads";
        $files[]            = ROOT_DIR."temp";
        $files[]            = ROOT_DIR."templates".DS."notifications";
        $files[]            = ROOT_DIR.CORE_FOLDER;

        $file_permissions   = [];

        foreach($files AS $file)
        {
            $chd =  is_readable($file) && is_writable($file);
            if(!is_file($chd))
            {
                $sub_files = wcp_glob(rtrim($file,DS).DS."*",0,true);
                
                if($sub_files)
                {
                    foreach($sub_files AS $f)
                    {
                        if(!(is_readable($file) && is_writable($f)))
                        {
                            $chd = false;
                        }
                    }
                }
            }
            if(!$chd) $file_permissions[] = $file;
        }

        $conformity     = true;

        if($conformity && !$php) $conformity = false;
        if($conformity && !$ioncube) $conformity = false;
        if($conformity && !$zip) $conformity = false;
        if($conformity && !$pdo) $conformity = false;
        if($conformity && !$curl) $conformity = false;
        if($conformity && !$mbstring) $conformity = false;
        if($conformity && !$openssl) $conformity = false;
        if($conformity && !$gd) $conformity = false;
        if($conformity && !$intl) $conformity = false;
        if($conformity && $file_permissions) $conformity = false;
        if($conformity && !$file_get_put) $conformity = false;
        if($conformity && !$glob) $conformity = false;


        return [
            'php'               => $php,
            'php_v'             => $php_v,
            'phpinfo'           => $phpinfo,
            'ioncube'           => $ioncube,
            'ioncube_v'         => $ioncube_v,
            'curl'              => $curl,
            'pdo'               => $pdo,
            'zip'               => $zip,
            'mbstring'          => $mbstring,
            'openssl'           => $openssl,
            'gd'                => $gd,
            'intl'              => $intl,
            'file_get_put'      => $file_get_put,
            'file_permissions'  => [],
            'glob'              => $glob,
            'file_permissions'  => $file_permissions,
            'conformity'        => $conformity,
        ];
    }
    function isQuoted($offset, $text)
    {
        if ($offset > strlen($text))
            $offset = strlen($text);

        $isQuoted = false;
        for ($i = 0; $i < $offset; $i++) {
            if ($text[$i] == "'")
                $isQuoted = !$isQuoted;
            if ($text[$i] == "\\" && $isQuoted)
                $i++;
        }
        return $isQuoted;
    }
    function clearSQL($sql, &$isMultiComment)
    {
        if ($isMultiComment) {
            if (preg_match('#\*/#sUi', $sql)) {
                $sql = preg_replace('#^.*\*/\s*#sUi', '', $sql);
                $isMultiComment = false;
            } else {
                $sql = '';
            }
            if(trim($sql) == ''){
                return $sql;
            }
        }

        $offset = 0;
        while (preg_match('{--\s|#|/\*[^!]}sUi', $sql, $matched, PREG_OFFSET_CAPTURE, $offset)) {
            list($comment, $foundOn) = $matched[0];
            if (isQuoted($foundOn, $sql)) {
                $offset = $foundOn + strlen($comment);
            } else {
                if (substr($comment, 0, 2) == '/*') {
                    $closedOn = strpos($sql, '*/', $foundOn);
                    if ($closedOn !== false) {
                        $sql = substr($sql, 0, $foundOn) . substr($sql, $closedOn + 2);
                    } else {
                        $sql = substr($sql, 0, $foundOn);
                        $isMultiComment = true;
                    }
                } else {
                    $sql = substr($sql, 0, $foundOn);
                    break;
                }
            }
        }
        return $sql;
    }
    function query($sql){
        global $db;
        try{
            $db->query($sql);
            return true;
        }catch(PDOException $e){
            throw new PDOException($e->getMessage(),$e->getCode(),$e->getPrevious());
            return false;
        }
    }
    function sqlImport($file)
    {

        $delimiter = ';';
        $file = fopen($file, 'r');
        $isFirstRow = true;
        $isMultiLineComment = false;
        $sql = '';

        while (!feof($file)) {

            $row = fgets($file);

            // remove BOM for utf-8 encoded file
            if ($isFirstRow) {
                $row = preg_replace('/^\x{EF}\x{BB}\x{BF}/', '', $row);
                $isFirstRow = false;
            }

            // 1. ignore empty string and comment row
            if (trim($row) == '' || preg_match('/^\s*(#|--\s)/sUi', $row)) {
                continue;
            }

            // 2. clear comments
            $row = trim(clearSQL($row, $isMultiLineComment));

            // 3. parse delimiter row
            if (preg_match('/^DELIMITER\s+[^ ]+/sUi', $row)) {
                $delimiter = preg_replace('/^DELIMITER\s+([^ ]+)$/sUi', '$1', $row);
                continue;
            }

            // 4. separate sql queries by delimiter
            $offset = 0;
            while (strpos($row, $delimiter, $offset) !== false) {
                $delimiterOffset = strpos($row, $delimiter, $offset);
                if (isQuoted($delimiterOffset, $row)) {
                    $offset = $delimiterOffset + strlen($delimiter);
                } else {
                    $sql = trim($sql . ' ' . trim(substr($row, 0, $delimiterOffset)));
                    if(!query($sql))
                        return false;

                    $row = substr($row, $delimiterOffset + strlen($delimiter));
                    $offset = 0;
                    $sql = '';
                }
            }
            $sql = trim($sql . ' ' . $row);
        }
        if (strlen($sql) > 0) {
            if(!query($row))
                return false;
        }

        fclose($file);
    }

    $way        = $_SERVER["REQUEST_URI"];
    if(stristr($way,"?")){
        $split  = explode("?",$way);
        $way    = $split[0];
    }
    $way        = str_replace("install.php","",$way);
    $address    = isSSL() ? "https" : "http";
    $address    .= "://".$_SERVER["HTTP_HOST"].$way;

    $taddress   = $address."templates/system/";
    $saddress   = $address."resources/";

    $ses_stage  = isset($_SESSION["stage"]) ? (int) $_SESSION["stage"] : false;
    $stage      = isset($_GET["stage"]) ? $_GET["stage"] : false;

    if($general["established-date"] != "0000-00-00 00:00:00" && $ses_stage < 4){
        header("Refresh:2;URL=index.php");
        echo "The installation has already been done.";
        exit();
    }

    $act        = isset($_GET["act"]) ? $_GET["act"] : false;

    if($act){

        if($act == "stage1"){
            $_SESSION["stage"] = 1;
            header("Location:".$address."install.php?stage=1");
        }
        elseif($act == "stage2"){
            $tester = requirement_tester();
            if(!$tester["conformity"]) exit();
            $_SESSION["stage"] = 2;
            header("Location:".$address."install.php?stage=2");
        }
        elseif($act == "stage3"){
            $db_host        = $_POST["db_host"];
            $db_name        = $_POST["db_name"];
            $db_username    = $_POST["db_username"];
            $db_password    = $_POST["db_password"];

            if(!$db_host) $db_host = "localhost";

            if(!$db_name)
                die(json_encode([
                    'status' => "error",
                    'for'    => "input[name=db_name]",
                    'message' => $lang["error1"],
                ]));

            if(!$db_username)
                die(json_encode([
                    'status' => "error",
                    'for'    => "input[name=db_username]",
                    'message' => $lang["error2"],
                ]));

            if(!$db_password)
                die(json_encode([
                    'status' => "error",
                    'for'    => "input[name=db_password]",
                    'message' => $lang["error3"],
                ]));


            try{
                $db = new PDO('mysql:dbname='.$db_name.';host='.$db_host.';charset=utf8',$db_username,$db_password,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
                $db->exec("SET names utf8");
                $db->exec("SET character_set_connection = 'utf8' ");
            }catch(PDOException $e){
                die(json_encode([
                    'status' => "error",
                    'message' => $lang["error4"].$e->getMessage(),
                ]));
            }

            try{
                $statement = $db->query("SHOW TABLES");
            }catch(PDOException $e){
                die(json_encode([
                    'status' => "error",
                    'message' => $lang["error5"].$e->getMessage(),
                ]));
            }

            $is_import  = true;

            $tables = $statement->fetchAll(PDO::FETCH_NUM);
            if($tables) foreach($tables as $table) if($table[0] == "users_informations") $is_import = false;

            if($is_import){
                $sql_file   = __DIR__.DS."install.sql";

                if(!file_exists($sql_file))
                    die(json_encode([
                        'status' => "error",
                        'message' => $lang["error6"],
                    ]));

                try{
                    sqlImport($sql_file);
                }catch(PDOException $e){
                    die(json_encode([
                        'status' => "error",
                        'message' => $lang["error5"].$e->getMessage(),
                    ]));
                }

                if($db){
                    sleep(5);
                    $db->query("UPDATE currencies SET rate='0' WHERE local=1");
                    $db->query("UPDATE currencies SET local='0'");
                    $db->query("UPDATE currencies SET local='1',rate='1' WHERE id=".$general["currency"]);
                }

            }

            $db_file    = __DIR__.DS.CORE_FOLDER.DS."configuration".DS."database.php";

            if(!file_exists($db_file))
                die(json_encode([
                    'status' => "error",
                    'message' => $lang["error7"],
                ]));

            $database   = include $db_file;

            $database["database"]["host"]       = $db_host;
            $database["database"]["name"]       = $db_name;
            $database["database"]["username"]   = $db_username;
            $database["database"]["password"]   = $db_password;
            $export                             = var_export($database,true);
            $export                             = '<?php
    defined(\'CORE_FOLDER\') OR exit(\'You can not get in here!\');
    return '.$export.';';

            if(!file_put_contents($db_file,$export))
                die(json_encode([
                    'status' => "error",
                    'message' => "Database information could not be saved.",
                ]));

            $_SESSION["stage"] = 3;

            sleep(3);

            echo json_encode([
                'status' => "successful",
                'redirect' => $address."install.php?stage=3",
            ]);
        }
        exit();
    }

    if($stage == 1 && $ses_stage >= 1){
        $tester   = requirement_tester();
        extract($tester);

        if($conformity) header("Location:".$address."install.php?act=stage2");
    }
    elseif($stage == 2 && $ses_stage >= 2){
        $tester   = requirement_tester();

        extract($tester);
    }
    elseif($stage == 3 && $ses_stage >= 3){
        $database   = include __DIR__.DS.CORE_FOLDER.DS."configuration".DS."database.php";
        $database   = $database["database"];

        try{
            $db = new PDO('mysql:dbname='.$database["name"].';host='.$database["host"].';charset=utf8',$database["username"],$database["password"],array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            $db->exec("SET names utf8");
            $db->exec("SET character_set_connection = 'utf8' ");
        }catch(PDOException $e){
            $db = null;
        }

        if($db){
            $admin  = $db->query("SELECT id,email FROM users WHERE id=1");
            $admin  = $admin->fetch(PDO::FETCH_ASSOC);
            $admin_email = isset($admin["email"]) ? $admin["email"] : '';
        }

        unset($_SESSION["lang"]);
        unset($_SESSION["stage"]);
        unlink(__DIR__.DS."install.php");
        unlink(__DIR__.DS."install.sql");

        $now = (new DateTime())->format("Y-m-d H:i:s");

        $general["established-date"]        = $now;
        $general                            = ['general' => $general];
        $export                             = var_export($general,true);
        $export                             = '<?php
    defined(\'CORE_FOLDER\') OR exit(\'You can not get in here!\');
    return '.$export.';';
        if(!file_put_contents($general_file,$export))
            die(json_encode([
                'status' => "error",
                'message' => "General settings could not be saved.",
            ]));

    }
    else $stage = false;

    include TEMPLATE_DIR."install.php";