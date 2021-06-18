<?php
    if(!defined("INTL_IDNA_VARIANT_UTS46") && defined("INTL_IDNA_VARIANT_2003")) define("INTL_IDNA_VARIANT_UTS46",INTL_IDNA_VARIANT_2003);

    if(!function_exists("idn_to_ascii"))
    {
        function idn_to_ascii($str='',$arg='')
        {
            return $str;
        }
    }
    if(!function_exists("mime_content_type"))
    {
        function mime_content_type($filename)
        {
            if(!class_exists("finfo")) return false;
            $result = new finfo();

            if (is_resource($result) === true) {
                return $result->file($filename, FILEINFO_MIME_TYPE);
            }
            return false;
        }
    }
    if(!function_exists("mb_substr"))
    {
        function mb_substr($str, $start, $length = null)
        {
            return substr($str,$start,$length);
        }
    }
    if(!function_exists("mb_strlen"))
    {
        function mb_strlen ($str)
        {
            return strlen($str);
        }
    }