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
    class Image
    {

        static function set($paf,$folder=NULL,$name=NULL,$x = false,$y = false,$options=[]){

            if(!class_exists("Upload")) include __DIR__.DSEPARATOR."libraries".DSEPARATOR."Uploads".DSEPARATOR."class.upload.php";

            if($folder && isset($options["folder-date-detect"]) && $options["folder-date-detect"]){
                preg_match('/([0-9]{4})-([0-9]{2})-([0-9]{2})/',$paf,$matches);
                if($matches){
                    $date = $matches[0];
                    $folder = $folder.$date;
                   if(!file_exists($folder)){
                       @mkdir($folder,0777);
                       @touch($folder.DS."index.html");
                   }
                }
            }

            $image = new Upload($paf);
            if ($image->uploaded) {
                $image->file_overwrite = true;

                if($name){
                    $image->file_new_name_body = $name;
                }
                //$image->image_background_color = '#eeeeee';
                $image->allowed = array ( 'image/*' );
                $image->jpeg_quality = 100;


                if($x == true OR $y == true){

                    $image->image_resize = true;
                    if(isset($options["ratio_fill"])) $image->image_ratio_fill = true;

                    if($x != false AND $y != false){
                        $image->image_x = $x;
                        $image->image_y = $y;
                    }elseif($x != false AND $y == false){
                        $image->image_x = $x;
                        $image->image_ratio_y = true;
                    }elseif($y != false AND $x == false){
                        $image->image_y = $y;
                        $image->image_ratio_x = true;
                    }
                }

                if(isset($options["rotate"]))
                    $image->image_rotate = $options["rotate"];

                if(isset($options["watermark"])){
                    $image->image_watermark = $options["watermark"];
                    $image->image_watermark_position = 'L';
                    if(isset($options["watermark_position"]))
                        $image->image_watermark_position = $options["watermark_position"];
                }

                $image->Process($folder);

                if($image->processed){
                    return true;
                }else{
                    return false;
                }
            }
        }

        static function picture($owner='',$owner_id=0,$reason=''){
            $stmt   = Models::$init->db->select("name")->from("pictures");
            $stmt->where("owner","=",$owner,"&&");
            $stmt->where("owner_id","=",$owner_id,"&&");
            $stmt->where("reason","=",$reason);
            return $stmt->build() ? $stmt->getObject()->name : false;
        }

    }