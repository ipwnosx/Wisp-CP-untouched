<?php
    class AddressManager {
        private static $cache;

        private static $postal_code_formats         = [
            'AF' => 'NNNN',
            'AX' => 'NNNNN, CC-NNNNN',
            'AL' => 'NNNN',
            'DZ' => 'NNNNN',
            'AS' => 'NNNNN, NNNNN-NNNN',
            'AD' => 'CCNNN',
            'AO' => '',
            'AI' => 'AI-2640',
            'AG' => '',
            'AR' => 'NNNN',
            'AM' => 'NNNN',
            'AW' => '',
            'AU' => 'NNNN',
            'AT' => 'NNNN',
            'AZ' => 'CC NNNN',
            'BS' => '',
            'BH' => 'NNN, NNNN',
            'BD' => 'NNNN',
            'BB' => 'CCNNNNN',
            'BY' => 'NNNNNN',
            'BE' => 'NNNN',
            'BZ' => '',
            'BJ' => '',
            'BM' => '',
            'BT' => 'NNNNN',
            'BO' => '',
            'BQ' => '',
            'BA' => 'NNNNN',
            'BW' => '',
            'BR' => 'NNNNN, NNNNN-NNN',
            'AQ' => 'BIQQ 1ZZ',
            'IO' => 'BBND 1ZZ',
            'VG' => 'CCNNNN',
            'BN' => 'AANNNN',
            'BG' => 'NNNN',
            'BF' => '',
            'BI' => '',
            'KH' => 'NNNNN',
            'CM' => '',
            'CA' => 'ANA NAN',
            'CV' => 'NNNN',
            'KY' => 'CCN-NNNN',
            'CF' => '',
            'TD' => '',
            'CL' => 'NNNNNNN, NNN-NNNN',
            'CN' => 'NNNNNN',
            'CX' => 'NNNN',
            'CC' => 'NNNN',
            'CO' => 'NNNNNN',
            'KM' => '',
            'CG' => '',
            'CD' => '',
            'CK' => '',
            'CR' => 'NNNNN',
            'CI' => '',
            'HR' => 'NNNNN',
            'CU' => 'NNNNN',
            'CW' => '',
            'CY' => 'NNNN',
            'CZ' => 'NNN NN',
            'DK' => 'NNNN',
            'DJ' => '',
            'DM' => '',
            'DO' => 'NNNNN',
            'TL' => '',
            'EC' => 'NNNNNN',
            'SV' => 'NNNN',
            'EG' => 'NNNNN',
            'GQ' => '',
            'ER' => '',
            'EE' => 'NNNNN',
            'ET' => 'NNNN',
            'FK' => 'FIQQ 1ZZ',
            'FO' => 'NNN',
            'FJ' => '',
            'FI' => 'NNNNN',
            'FR' => 'NNNNN',
            'GF' => '973NN',
            'PF' => '987NN',
            'TF' => '',
            'GA' => '',
            'GM' => '',
            'GE' => 'NNNN',
            'DE' => 'NNNNN',
            'GH' => '',
            'GI' => 'GX11 1AA',
            'GR' => 'NNN NN',
            'GL' => 'NNNN',
            'GD' => '',
            'GP' => '971NN',
            'GU' => 'NNNNN, NNNNN-NNNN',
            'GT' => 'NNNNN',
            'GG' => 'AAN NAA, AANN NAA',
            'GN' => 'NNN',
            'GW' => 'NNNN',
            'GY' => '',
            'HT' => 'NNNN',
            'HM' => '',
            'HN' => 'AANNNN, NNNNN',
            'HK' => '',
            'HU' => 'NNNN',
            'IS' => 'NNN',
            'IN' => 'NNNNNN,
NNN NNN',
            'ID' => 'NNNNN',
            'IR' => 'NNNNNNNNNN',
            'IQ' => 'NNNNN',
            'IE' => '',
            'IM' => 'CCN NAA, CCNN NAA',
            'IL' => 'NNNNNNN',
            'IT' => 'NNNNN',
            'JM' => 'NN',
            'JP' => 'NNN-NNNN',
            'JE' => 'CCN NAA, CCNN NAA',
            'JO' => 'NNNNN',
            'KZ' => 'NNNNNN',
            'KE' => 'NNNNN',
            'KI' => '',
            'KP' => '',
            'KR' => 'NNNNN',
            'XK' => 'NNNNN',
            'KW' => 'NNNNN',
            'KG' => 'NNNNNN',
            'LA' => 'NNNNN',
            'LV' => 'CC-NNNN',
            'LB' => 'NNNNN, NNNN NNNN',
            'LS' => 'NNN',
            'LR' => 'NNNN',
            'LY' => '',
            'LI' => 'NNNN',
            'LT' => 'CC-NNNNN',
            'LU' => 'NNNN',
            'MO' => '',
            'MK' => 'NNNN',
            'MG' => 'NNN',
            'MW' => '',
            'MY' => 'NNNNN',
            'MV' => 'NNNNN',
            'ML' => '',
            'MT' => 'AAA NNNN',
            'MH' => 'NNNNN, NNNNN-NNNN',
            'MR' => '',
            'MU' => 'NNNNN',
            'MQ' => '972NN',
            'YT' => '976NN',
            'MX' => 'NNNNN',
            'FM' => 'NNNNN, NNNNN-NNNN',
            'MD' => 'CCNNNN, CC-NNNN',
            'MC' => '980NN',
            'MN' => 'NNNNN',
            'ME' => 'NNNNN',
            'MS' => 'MSR 1110-1350',
            'MA' => 'NNNNN',
            'MZ' => 'NNNN',
            'MM' => 'NNNNN',
            'NA' => '',
            'NR' => '',
            'NP' => 'NNNNN',
            'NL' => '',
            'NC' => '988NN',
            'NZ' => 'NNNN',
            'NI' => 'NNNNN',
            'NE' => 'NNNN',
            'NG' => 'NNNNNN',
            'NU' => '',
            'NF' => 'NNNN',
            'MP' => 'NNNNN, NNNNN-NNNN',
            'NO' => 'NNNN',
            'OM' => 'NNN',
            'PK' => 'NNNNN',
            'PW' => 'NNNNN, NNNNN-NNNN',
            'PS' => 'NNN',
            'PA' => 'NNNN',
            'PG' => 'NNN',
            'PY' => 'NNNN',
            'PE' => 'NNNNN, CC NNNN',
            'PH' => 'NNNN',
            'PN' => 'PCRN 1ZZ',
            'PL' => 'NN-NNN',
            'PT' => 'NNNN-NNN',
            'PR' => 'NNNNN, NNNNN-NNNN',
            'QA' => '',
            'RE' => '974NN',
            'RO' => 'NNNNNN',
            'RW' => '',
            'RU' => 'NNNNNN',
            'BL' => '97133',
            'SH' => 'AAAA 1ZZ',
            'KN' => '',
            'LC' => 'CCNN  NNN',
            'MF' => '97150',
            'PM' => '97500',
            'VC' => 'CCNNNN',
            'WS' => 'CCNNNN',
            'SM' => '4789N',
            'ST' => '',
            'SA' => 'NNNNN-NNNN, NNNNN',
            'SN' => 'NNNNN',
            'RS' => 'NNNNN',
            'SC' => '',
            'SL' => '',
            'SX' => '',
            'SG' => 'NNNNNN',
            'SK' => 'NNN NN',
            'SI' => 'NNNN, CC-NNNN',
            'SB' => '',
            'SO' => 'AA NNNNN',
            'ZA' => 'NNNN',
            'GS' => 'SIQQ 1ZZ',
            'ES' => 'NNNNN',
            'LK' => 'NNNNN',
            'SD' => 'NNNNN',
            'SR' => '',
            'SZ' => 'ANNN',
            'SE' => 'NNN NN',
            'CH' => 'NNNN',
            'SJ' => 'NNNN',
            'SY' => '',
            'TW' => 'NNN, NNN-NN',
            'TJ' => 'NNNNNN',
            'TZ' => 'NNNNN',
            'TH' => 'NNNNN',
            'TG' => '',
            'TK' => '',
            'TO' => '',
            'TT' => 'NNNNNN',
            'TN' => 'NNNN',
            'TR' => 'NNNNN',
            'TM' => 'NNNNNN',
            'TC' => 'TKCA 1ZZ',
            'TV' => '',
            'UG' => '',
            'UA' => 'NNNNN',
            'AE' => '',
            'GB' => 'A[A]N[A/N]',
            'US' => 'NNNNN, NNNNN-NNNN',
            'UY' => 'NNNNN',
            'VI' => 'NNNNN, NNNNN-NNNN',
            'UZ' => 'NNNNNN',
            'VU' => '',
            'VA' => '00120',
            'VE' => 'NNNN, NNNN-A',
            'VN' => 'NNNNNN',
            'WF' => '986NN',
            'YE' => '',
            'ZM' => 'NNNNN',
            'ZW' => '',
        ];

        private static $city_name_log       = [];
        private static $city_id_log         = [];
        private static $counti_name_log     = [];
        private static $country_log         = [];
        private static $country_name_log    = [];


        static function generate_postal_code($cc=''){
            $code   = self::$postal_code_formats[$cc];
            if(!$code) return NULL;

            $code   = preg_replace_callback('/'.preg_quote("A").'/',function(){
                $chr1 = chr(rand(65,90));
                $chr2 = chr(rand(65,90));
                return $chr1 == "C" || $chr2 == "N" ? $chr2 : $chr1;
            }, $code);
            $code   = str_replace("CC",$cc,$code);
            $code   = preg_replace_callback('/'.preg_quote("N").'/',function(){
                return rand(0,9);
            }, $code);

            return $code;
        }

        static function LocalCountryID(){
            $LocCountryID = Config::get("general/country");
            $LocCountryID = self::get_id_with_cc($LocCountryID);
            return $LocCountryID;
        }

        static function getCountiName($id=0){
            if(isset(self::$counti_name_log[$id])) return self::$counti_name_log[$id];
            $sth    = Models::$init->db->select("name")->from("counties")->where("id","=",$id);
            $name   = $sth->build() ? $sth->getObject()->name : false;
            if($name) self::$counti_name_log[$id] = $name;
            return $name;
        }

        static function getCityName($id=0){
            if(isset(self::$city_name_log[$id])) return self::$city_name_log[$id];
            $sth = Models::$init->db->select("name")->from("cities")->where("id","=",$id);
            $name   = $sth->build() ? $sth->getObject()->name : false;
            if($name) self::$city_name_log[$id] = $name;
            return $name;
        }
        static function getCityID($country=0,$name=''){
            if(isset(self::$city_id_log[$country][$name])) return self::$city_id_log[$country][$name];
            $sth = Models::$init->db->select("id")->from("cities");
            if($country) $sth->where("country_id","=",$country,"&&");
            $sth->where("name","LIKE",$name);
            $sth   = $sth->build() ? $sth->getObject()->id : 0;
            if($sth) self::$city_id_log[$country][$name] = $sth;
            return $sth;
        }

        static function getCountry($id=0,$fields='',$lang=''){
            if(!$lang) $lang = Bootstrap::$lang->clang;
            if(isset(self::$country_log[$id][$lang][$fields])) return self::$country_log[$id][$lang][$fields];
            $sth = Models::$init->db->select($fields)->from("countries AS t1")->join("LEFT","countries_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $sth->where("t2.id","IS NOT NULL","","&&");
            $sth->where("t1.id","=",$id);
            $data =  $sth->build() ? $sth->getAssoc() : false;
            if($data) self::$country_log[$id][$lang][$fields] = $data;
            return $data;
        }
        static function getCountries($fields='',$lang=''){
            if(!$lang) $lang = Bootstrap::$lang->clang;
            $sth = Models::$init->db->select($fields)->from("countries AS t1")->join("LEFT","countries_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $sth->where("t2.id","IS NOT NULL","");
            $sth->order_by("id ASC");
            $data =  $sth->build() ? $sth->fetch_assoc() : false;
            return $data;
        }

        static function get_cc_with_id($id=0,$type="a2"){
            $id     = (int) $id;
            if(isset(self::$cache["get_cc_with_id"][$id][$type])) return self::$cache["get_cc_with_id"][$id][$type];
            $stmt   = Models::$init->db->select($type."_iso AS code")->from("countries");
            $stmt->where("id","=",$id);
            $result = $stmt->build() ? $stmt->getObject()->code : false;
            self::$cache["get_cc_with_id"][$id][$type] = $result;
            return $result;
        }

        static function get_id_with_cc($cc=0){
            $cc     = (string) $cc;
            $cc     = strtoupper($cc);
            if(isset(self::$cache["get_id_with_cc"][$cc])) return self::$cache["get_id_with_cc"][$cc];

            $stmt   = Models::$init->db->select("id")->from("countries");
            $size   = strlen($cc);
            if($size==2) $stmt->where("a2_iso","=",$cc);
            else $stmt->where("a3_iso","=",$cc);
            $result = $stmt->build() ? $stmt->getObject()->id : false;
            self::$cache["get_id_with_cc"][$cc] = $result;
            return $result;
        }

        static function get_country_name($cc='',$lang=''){
            $lang   = !$lang ? Bootstrap::$lang->clang : $lang;
            $cc     = strtoupper($cc);
            if(isset(self::$country_name_log[$cc][$lang])) return self::$country_name_log[$cc][$lang];
            $stmt   = Models::$init->db->select("t2.name")->from("countries AS t1");
            $stmt->join("LEFT","countries_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $stmt->where("a2_iso","=",$cc);
            $name   = $stmt->build() ? $stmt->getObject()->name : false;
            if($name) self::$country_name_log[$cc][$lang] = $name;
            return $name;
        }

        static function getAddress($id=0,$uid=0){
            $sth = Models::$init->db->select()->from("users_addresses");
            if($id) $sth->where("id","=",$id);
            else $sth->where("owner_id","=",$uid,"&&")->where("detouse","=","1");
            $data = $sth->build() ? $sth->getAssoc() : false;
            if($data){
                if(Validation::isInt($data["counti"])){
                    $counti = self::getCountiName($data["counti"]);
                    if($counti) $data["counti"] = $counti;
                }

                if(Validation::isInt($data["city"])){
                    $city = self::getCityName($data["city"]);
                    if($city){
                        $data["city_id"]    = $data["city"];
                        $data["city"]       = $city;
                    }
                }

                if($data["country_id"] != 0){
                    $country = self::getCountry($data["country_id"],"t1.a2_iso AS code,t2.name","en");
                    if(!$country) $country = self::getCountry($data["country_id"],"t1.a2_iso AS code,t2.name",Config::get("general/local"));

                    if($country){
                        $data["country_code"] = $country["code"];
                        $data["country_name"] = $country["name"];
                    }
                }
                unset($data["owner_id"]);
            }
            return $data;
        }

        static function CheckAddress($id=0,$uid=0){
            $check      = Models::$init->db->select("id")->from("users_addresses");
            if($uid) $check->where("owner_id","=",$uid,"&&");
            $check->where("id","=",$id,"&&");
            $check->where("status","=","active");
            return $check->build();
        }

        static function CheckCountry($id=0){
            $sth = Models::$init->db->select("id")->from("countries")->where("id","=",$id);
            return $sth->build();
        }

        static function CheckCity($id=0){
            $sth = Models::$init->db->select("id")->from("cities")->where("id","=",$id);
            return $sth->build();
        }

        static function CheckCounti($id=0){
            $sth = Models::$init->db->select("id")->from("counties")->where("id","=",$id);
            return $sth->build();
        }


        static function getCountryList($lang=''){
            if(!$lang) $lang = Bootstrap::$lang->clang;
            $sth = Models::$init->db->select("t1.id,t1.a2_iso AS code,t2.name")->from("countries AS t1")->join("LEFT","countries_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $sth->where("t2.id","IS NOT NULL");
            $sth->order_by("t1.id ASC");
            return $sth->build() ? $sth->fetch_assoc() : false;
        }

        static function getCities($country=0){
            $sth = Models::$init->db->select()->from("cities");
            $sth->where("country_id","=",$country);
            $sth->order_by("name ASC");
            return $sth->build() ? $sth->fetch_assoc() : [];
        }

        static function getCounties($city=0){
            $sth = Models::$init->db->select("id,name")->from("counties");
            $sth->where("city_id","=",$city);
            $sth->order_by("name ASC");
            return $sth->build() ? $sth->fetch_assoc() : false;
        }

    }