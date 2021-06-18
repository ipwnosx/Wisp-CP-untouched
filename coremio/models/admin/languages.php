<?php
    /**
    * @author Sitemio Bilişim Teknolojileri Tic. Ltd. Şti.
    * @project Sitemio Temel Kaynak Kod Çekirdek Yapısı
    * @date 2017-07-01 09:00 AM
    * @contract http://www.sitemio.com/hizmet-sozlesmesi.html
    * @copyright Tüm Hakları Sitemio Bilişim Teknolojileri Tic. Ltd. Şti. adına saklıdır
    * @warning Lisanssız kopyalanamaz, dağıtılamaz ve kullanılamaz.
    **/

    defined('CORE_FOLDER') OR exit('You can not get in here!');
    class Model extends Models
    {
        function __construct()
        {
            parent::__construct();
        }

        public function get_country_name($id=0){
            $local  = Config::get("general/local");
            $stmt   = $this->db->select("name")->from("countries_lang");
            $stmt->where("owner_id","=",$id,"&&");
            $stmt->where("lang","=",$local);
            return $stmt->build() ? $stmt->getObject()->name : false;
        }

        public function get_countries(){
            $local  = Config::get("general/local");
            $stmt   = $this->db->select("t1.*,t2.name")->from("countries AS t1");
            $stmt->join("LEFT","countries_lang AS t2","t2.owner_id=t1.id AND (t2.lang='".$local."')");
            $stmt->where("t2.id","IS NOT NULL");
            $stmt->order_by("t2.name ASC");
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function get_currencies(){
            $stmt   = $this->db->select("id,code,name")->from("currencies");
            return $stmt->build() ? $stmt->fetch_assoc() : false;
        }

        public function copy_lang_tables($src,$dst){
            $GLOBALS["src"] = $src;
            $GLOBALS["dst"] = $dst;

            foreach(Config::get("database/language-tables") AS $table){
                $columns    = [];
                $db_name    = Config::get("database/name");
                $stmt       = $this->db->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '".$db_name."' AND TABLE_NAME = '".$this->pfx.$table."';",true);
                if($stmt->rowCounter()) foreach($stmt->fetch_assoc() AS $column) $columns[] = $column["COLUMN_NAME"];
                if($columns){
                    foreach($columns AS $k => $v)
                    {
                        if($v == "id"){
                            unset($columns[$k]);
                        }
                    }
                    $columns = array_values($columns);

                    $_columns   = implode(",",$columns);
                    $_columns_v = implode(",",array_map(function($val){
                        $src = $GLOBALS["src"];
                        $dst = $GLOBALS["dst"];
                        return $val == "lang" ? "REPLACE(lang, '".$src."', '".$dst."') AS lang" : $val;
                    },$columns));
                    $this->db->query('INSERT INTO '.$this->pfx.$table.'('.$_columns.') SELECT '.$_columns_v.' FROM '.$this->pfx.$table.' WHERE lang=\''.$src.'\' ');
                }
            }
        }

        public function remove_lang_tables($key){
            foreach(Config::get("database/language-tables") AS $table){
                $this->db->delete($table)->where("lang","=",$key)->run();
            }
        }


    }