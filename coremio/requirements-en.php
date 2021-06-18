<?php
    @ob_start();
    @session_start();
    @set_time_limit(0);

    function get_phpinfo_content(){
        ob_start();
        phpinfo();
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

    $_session               = isset($_SESSION["testing"]) ? $_SESSION["testing"] : false;
    $_SESSION["testing"]    = "success";
    $php                    = version_compare(PHP_VERSION, '7.2.0', '>=');
    $php_v                  = phpversion();
    $phpinfo                = get_phpinfo_content();
    $ioncube                = $phpinfo ? true : false;
    $ioncube_v              = GetIonCubeLoaderVersion($phpinfo);
    $curl                   = false;
    $pdo                    = false;
    $zip                    = false;
    $mbstring               = false;
    $openssl                = false;
    $gd                     = false;
    $intl                   = false;
    $file_get_put           = true;
    $glob                   = function_exists("glob");
    $disk_free_space        = function_exists("disk_free_space");
    $disk_total_space       = function_exists("disk_total_space");
    $json                   = function_exists("json_encode") && function_exists("json_decode");
    $finfo                  = class_exists("finfo");
    $idn_to_ascii           = function_exists("idn_to_ascii");
    $mysqli                 = function_exists("mysqli_connect");
    $memory_limit           = false;
    $max_execution_time     = false;
    $session                = $_session == "success";
    $suggested_memory       = 128;
    $suggested_exe          = 60;


    $search = '<tr><td(.*?)>memory_limit<\/td><td(.*?)>(.*?)<\/td><td(.*?)>(.*?)<\/td><\/tr>';
    preg_match('/'.$search.'/',$phpinfo,$matches);
    $memory_limit_1_raw = $matches[3];
    $memory_limit_2_raw = $matches[5];
    
    $search                 = '<tr><td(.*?)>max_execution_time<\/td><td(.*?)>(.*?)<\/td><td(.*?)>(.*?)<\/td><\/tr>';
    preg_match('/'.$search.'/',$phpinfo,$matches);
    $max_execution_time_1   = $matches[3];
    $max_execution_time_2   = $matches[5];


    $memory_limit_1           = 0;
    if(preg_match('/^(\d+)(.)$/', $memory_limit_1_raw, $matches)){
        if ($matches[2] == 'G'){
            $memory_limit_1 = $matches[1] * 1024 * 1024 * 1024; // nnnG -> nnn GB
        }elseif ($matches[2] == 'M'){
            $memory_limit_1 = $matches[1] * 1024 * 1024; // nnnM -> nnn MB
        }elseif ($matches[2] == 'K'){
            $memory_limit_1 = $matches[1] * 1024; // nnnK -> nnn KB
        }elseif ($matches[2] == 'B'){
            $memory_limit_1 = $matches[1];
        }
    }

    $memory_limit_2           = 0;
    if(preg_match('/^(\d+)(.)$/', $memory_limit_2_raw, $matches)){
        if ($matches[2] == 'G'){
            $memory_limit_2 = $matches[1] * 1024 * 1024 * 1024; // nnnG -> nnn GB
        }elseif ($matches[2] == 'M'){
            $memory_limit_2 = $matches[1] * 1024 * 1024; // nnnM -> nnn MB
        }elseif ($matches[2] == 'K'){
            $memory_limit_2 = $matches[1] * 1024; // nnnK -> nnn KB
        }elseif ($matches[2] == 'B'){
            $memory_limit_2 = $matches[1];
        }
    }

    if($memory_limit_1_raw == '' || (substr($memory_limit_1_raw,0,2) !== '-1' && $memory_limit_1 > 0 && $memory_limit_1 < ($suggested_memory * 1024 * 1024)))
        $memory_limit = false;
    else
        $memory_limit = true;

    if($memory_limit_2_raw == '' || (substr($memory_limit_2_raw,0,2) !== '-1' && $memory_limit_2 > 0 && $memory_limit_2 < ($suggested_memory * 1024 * 1024)))
        $memory_limit = false;
    else
        $memory_limit = true;

    if($max_execution_time_1 == '' || ($max_execution_time_1 != '-1' && !($max_execution_time_1 >= $suggested_exe)))
        $max_execution_time = false;
    else
        $max_execution_time = true;

        if($max_execution_time_2 == '' || ($max_execution_time_2 != '-1' && !($max_execution_time_2 >= $suggested_exe)))
            $max_execution_time = false;
        else
            $max_execution_time = true;

    


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
    if(!class_exists("ZipArchive")) $zip = false;
    if(!function_exists('curl_init') OR !function_exists('curl_exec') OR !function_exists('curl_setopt')) $curl = false;
    if(!function_exists("fopen") || !function_exists("fwrite") || !function_exists("file_get_contents") || !function_exists("file_put_contents")) $file_get_put = false;

    if($ioncube) $ioncube = $ioncube_v >= 9.0;





    $conformity     = true;

    if($conformity && !$php) $conformity = false;
    if($conformity && !$phpinfo) $conformity = false;
    if($conformity && !$ioncube) $conformity = false;
    if($conformity && !$zip) $conformity = false;
    if($conformity && !$pdo) $conformity = false;
    if($conformity && !$curl) $conformity = false;
    if($conformity && !$mbstring) $conformity = false;
    if($conformity && !$openssl) $conformity = false;
    if($conformity && !$gd) $conformity = false;
    if($conformity && !$intl) $conformity = false;
    if($conformity && !$file_get_put) $conformity = false;
    if($conformity && !$glob) $conformity = false;
    if($conformity && !$disk_free_space) $conformity = false;
    if($conformity && !$disk_total_space) $conformity = false;
    if($conformity && !$json) $conformity = false;
    if($conformity && !$finfo) $conformity = false;
    if($conformity && !$idn_to_ascii) $conformity = false;
    if($conformity && !$mysqli) $conformity = false;
    if($conformity && !$memory_limit) $conformity = false;
    if($conformity && !$max_execution_time) $conformity = false;
    if($conformity && !$session) $conformity = false;


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>WISECP - Sistem Gereksinimleri</title>
    <link href="https://fonts.googleapis.com/css?family=Titillium+Web:200,300,400,600,700&amp;subset=latin-ext" rel="stylesheet">
    <link rel="stylesheet" href="https://demo.wisecp.com/templates/system/css/font-awesome.min.css">
    <link href="https://demo.wisecp.com/templates/system/css/style.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://demo.wisecp.com/resources/assets/plugins/iziModal/css/iziModal.min.css">

    <!-- Js -->
    <script type="text/javascript">
        var warning_modal_title = 'Uyarı';
    </script>
    <script src="https://demo.wisecp.com/templates/system/js/jquery-1.11.3.min.js"></script>
    <script src="https://demo.wisecp.com/resources/assets/plugins/iziModal/js/iziModal.min.js"></script>
    <script src="https://demo.wisecp.com/resources/assets/plugins/sweetalert2/dist/promise.min.js"></script>
    <script src="https://demo.wisecp.com/resources/assets/plugins/sweetalert2/dist/sweetalert2.min.js"></script>
    <script src="https://demo.wisecp.com/resources/assets/javascript/webmio.js"></script>
    <script src="https://use.fontawesome.com/aaf32c1a9b.js"></script>

    <!-- Js -->
</head>
<body>

<div id="wrapper">
    <div class="stage2">
    <div class="logo"><img src="https://demo.wisecp.com/templates/system/images/logo2.svg" /></div>
    <div class="title">Sistem Gereksinimleri</div>
    <div style="padding:25px;">

        <div class="notice">
            <i class="fa fa-info-circle" aria-hidden="true"></i>
            <div class="noticeinfo">
            In order for the system to work smoothly, the following features must be present on your server. If you do not have one or more of the specified features, you should get support from your hosting provider.
            </div>
        </div>

        <?php
        
            if(isset($_GET["checking"]) && $_GET["checking"])
            {
                if($conformity)
                {
                    ?>
                    <div style="margin-top:30px;margin-bottom:70px;text-align:center;">
                        <i style="font-size:70px;color: #4CAF50;" class="fa fa-check-circle-o"></i>
                        <h2 style="font-weight:bold;color: #4CAF50;">All is Well!</h2>
                        <h3>Your server meets the requirements.</h3>
                    </div>
                    <?php
                }
                else
                {

                    if(!$ioncube){
                        ?>
                        <div class="formcon">
                            <div class="yuzde30">Ioncube</div>
                            <div class="yuzde70">
                                <i style="color:#DB1E1E;font-size:20px;" class="fa fa-ban" aria-hidden="true"></i>
                                <strong><?php echo $ioncube_v; ?></strong>
                                <span style="font-size:14px;">(The Ioncube is out of date or is not active at all.)</span>
                            </div>
                        </div>
                        <?php
                    }
                    

                    if(!$php){
                        ?>
                        <div class="formcon">
                        <div class="yuzde30">PHP</div>
                        <div class="yuzde70">
                                <i style="color:#DB1E1E;font-size:20px;" class="fa fa-ban" aria-hidden="true"></i>
                                <strong><?php echo $php_v; ?></strong>
                                <span style="font-size:14px;">(Your version of PHP must be <strong>7.2</strong> or <strong>higher</strong>.)</span>
                            </div>
                        </div>
                        <?php
                    }

                    if(!$phpinfo){
                        ?>
                        <div class="formcon">
                        <div class="yuzde30">PHP Info</div>
                        <div class="yuzde70">
                                <i style="color:#DB1E1E;font-size:20px;" class="fa fa-ban" aria-hidden="true"></i>
                                <strong>phpinfo()</strong>
                                <span style="font-size:14px;">(System information cannot be read, because this function is inactive. Please activate it.)</span>
                            </div>
                        </div>
                        <?php
                    }


                    if(!$curl){
                        ?>
                        <div class="formcon">
                            <div class="yuzde30">cURL</div>
                            <div class="yuzde70">
                                <i style="color:#DB1E1E;font-size:20px;" class="fa fa-ban" aria-hidden="true"></i>
                                <span style="font-size:14px;">(The cURL library must be active.)</span>
                            </div>
                        </div>
                        <?php
                    }

                    if(!$pdo){
                        ?>
                        <div class="formcon">
                            <div class="yuzde30">PDO & MySQL</div>
                            <div class="yuzde70">
                                <i style="color:#DB1E1E;font-size:20px;" class="fa fa-ban" aria-hidden="true"></i>
                                <span style="font-size:14px;">(<a href='http://php.net/manual/en/book.pdo.php' target='_blank'>PDO/MySQL</a> must be active.)</span>
                            </div>
                        </div>
                        <?php
                    }

                    if(!$mysqli){
                        ?>
                        <div class="formcon">
                            <div class="yuzde30">MySQLi</div>
                            <div class="yuzde70">
                                <i style="color:#DB1E1E;font-size:20px;" class="fa fa-ban" aria-hidden="true"></i>
                                <span style="font-size:14px;">(<a href='http://php.net/manual/en/book.pdo.php' target='_blank'>PDO/MySQL</a> must be active.)</span>
                            </div>
                        </div>
                        <?php
                    }

                    if(!$zip){
                        ?>
                        <div class="formcon">
                            <div class="yuzde30">ZipArchive</div>
                            <div class="yuzde70">
                                <i style="color:#DB1E1E;font-size:20px;" class="fa fa-ban" aria-hidden="true"></i>
                                <span style="font-size:14px;">(<a href='http://php.net/manual/en/class.ziparchive.php' target='_blank'>ZipArchive</a> must be active.)</span>
                            </div>
                        </div>
                        <?php
                    }

                    if(!$mbstring){
                        ?>
                        <div class="formcon">
                            <div class="yuzde30">MUltiByte String</div>
                            <div class="yuzde70">
                                <i style="color:#DB1E1E;font-size:20px;" class="fa fa-ban" aria-hidden="true"></i>
                                <span style="font-size:14px;">(<a href='http://php.net/manual/en/book.mbstring.php' target='_blank'>MbString</a> must be active.)</span>
                            </div>
                        </div>
                        <?php
                    }

                    if(!$openssl){
                        ?>
                        <div class="formcon">
                            <div class="yuzde30">OpenSSL</div>
                            <div class="yuzde70">
                                <i style="color:#DB1E1E;font-size:20px;" class="fa fa-ban" aria-hidden="true"></i>
                                <span style="font-size:14px;">(<a href='http://php.net/manual/en/book.openssl.php' target='_blank'>OpenSSL</a> must be active.)</span>
                            </div>
                        </div>
                        <?php
                    }

                    if(!$gd){
                        ?>
                        <div class="formcon">
                            <div class="yuzde30">GD</div>
                            <div class="yuzde70">
                                <i style="color:#DB1E1E;font-size:20px;" class="fa fa-ban" aria-hidden="true"></i>
                                <span style="font-size:14px;">(<a href='http://php.net/manual/en/book.image.php' target='_blank'>GD Library</a> must be active.)</span>
                            </div>
                        </div>
                        <?php
                    }

                    if(!$intl){
                        ?>
                        <div class="formcon">
                            <div class="yuzde30">Intl</div>
                            <div class="yuzde70">
                                <i style="color:#DB1E1E;font-size:20px;" class="fa fa-ban" aria-hidden="true"></i>
                                <span style="font-size:14px;">(The <a href='http://php.net/manual/en/book.intl.php' target='_blank'>Intl Library</a> must be active.)</span>
                            </div>
                        </div>
                        <?php
                    }

                    if(!$file_get_put){
                        ?>
                        <div class="formcon">
                            <div class="yuzde30">Dosya Okuma/Yazma</div>
                            <div class="yuzde70">
                                <i style="color:#DB1E1E;font-size:20px;" class="fa fa-ban" aria-hidden="true"></i>
                                <strong>file_get_contents(), file_put_contents()</strong>
                                <span style="font-size:14px;">(The specified functions must be enabled.)</span>
                            </div>
                        </div>
                        <?php
                    }

                    if(!$glob){
                        ?>
                        <div class="formcon">
                            <div class="yuzde30">glob()</div>
                            <div class="yuzde70">
                                <i style="color:#DB1E1E;font-size:20px;" class="fa fa-ban" aria-hidden="true"></i>
                                <span style="font-size:14px;">(The specified function must be enabled.)</span>
                            </div>
                        </div>
                        <?php
                    }

                    if(!$disk_free_space || !$disk_total_space){
                        ?>
                        <div class="formcon">
                            <div class="yuzde30">Dizin Boyut Hesaplama</div>
                            <div class="yuzde70">
                                <i style="color:#DB1E1E;font-size:20px;" class="fa fa-ban" aria-hidden="true"></i>
                                <strong>disk_free_space(), disk_total_space()</strong>
                                <span style="font-size:14px;">(The specified functions must be enabled.)</span>
                            </div>
                        </div>
                        <?php
                    }

                    if(!$json){
                        ?>
                        <div class="formcon">
                            <div class="yuzde30">JSON</div>
                            <div class="yuzde70">
                                <i style="color:#DB1E1E;font-size:20px;" class="fa fa-ban" aria-hidden="true"></i>
                                <span style="font-size:14px;">(The specified function must be enabled.)</span>
                            </div>
                        </div>
                        <?php
                    }

                    if(!$finfo){
                        ?>
                        <div class="formcon">
                            <div class="yuzde30">Class finfo</div>
                            <div class="yuzde70">
                                <i style="color:#DB1E1E;font-size:20px;" class="fa fa-ban" aria-hidden="true"></i>
                                <span style="font-size:14px;">(The specified class must be enabled.)</span>
                            </div>
                        </div>
                        <?php
                    }

                    if(!$idn_to_ascii){
                        ?>
                        <div class="formcon">
                            <div class="yuzde30">idn_to_ascii</div>
                            <div class="yuzde70">
                                <i style="color:#DB1E1E;font-size:20px;" class="fa fa-ban" aria-hidden="true"></i>
                                <span style="font-size:14px;">(The specified class must be enabled.)</span>
                            </div>
                        </div>
                        <?php
                    }

                    if(!$memory_limit){
                        ?>
                        <div class="formcon">
                            <div class="yuzde30">memory_limit</div>
                            <div class="yuzde70">
                                <i style="color:#DB1E1E;font-size:20px;" class="fa fa-ban" aria-hidden="true"></i>
                                <strong>Local: <?php echo $memory_limit_1_raw; ?>, Master: <?php echo $memory_limit_2_raw; ?></strong>
                                <span style="font-size:14px;">(Minimum Value: Must be <?php echo $suggested_memory; ?>M)</span>
                            </div>
                        </div>
                        <?php
                    }

                    if(!$max_execution_time){
                        ?>
                        <div class="formcon">
                            <div class="yuzde30">max_execution_time</div>
                            <div class="yuzde70">
                                <i style="color:#DB1E1E;font-size:20px;" class="fa fa-ban" aria-hidden="true"></i>
                                <strong>Local: <?php echo $max_execution_time_1; ?>, Master: <?php echo $max_execution_time_2; ?></strong>
                                <span style="font-size:14px;">(Minimum Value: Must be <?php echo $suggested_exe; ?>)</span>
                            </div>
                        </div>
                        <?php
                    }

                    if(!$session){
                        ?>
                        <div class="formcon">
                            <div class="yuzde30">Session</div>
                            <div class="yuzde70">
                                <i style="color:#DB1E1E;font-size:20px;" class="fa fa-ban" aria-hidden="true"></i>
                                <span style="font-size:14px;">(Session data cannot be saved.)</span>
                            </div>
                        </div>
                        <?php
                    }




                    ?>
                    <div class="requirementnotice">
                        <h3 style="color:#f44336"><strong>Please complete the above-mentioned shortcomings.</strong></h3>
                    </div>

                    <div class="clear"></div>
                    
                    <div align="center">
                        <a class="button" href="">Refresh Page</a>
                    </div>
                    <?php
                }
            }
            else
            {
                ?>
                <div style="margin-top:30px;margin-bottom:70px;text-align:center;">
				<i style="font-size:70px;" class="fa fa-cogs"></i>
				<h2 style="font-weight:bold;">Requirement Controller</h2>
				<h4>Check the server system requirements</h4>
				<a class="button" href="?checking=true">Start Check</a>
				</div>
                
                <?php
            }

        ?>
        
    </div>

</div></div>
</body>
</html>