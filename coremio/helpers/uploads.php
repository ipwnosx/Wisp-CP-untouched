<?php
    defined('CORE_FOLDER') OR exit('You can not get in here!');
    class Uploads
    {
        public $multiple=false,$error='',$operands=[];
        private $today,$image_upload=false,$file_name=false,$files=[],$allowed_ext=[],$upload_folder;
        private $width=false,$height=false,$background_color=true,$rotate=false,$watermark=false;
        private $image_extensions = [".jpg",".jpeg",".gif",".png",".JPG",".JPEG",".GIF",".PNG"],$max_file_size=false,$original_folder;

        public function __construct()
        {
            if(!class_exists("Upload")) include __DIR__.DSEPARATOR."libraries".DSEPARATOR."Uploads".DSEPARATOR."class.upload.php";
            return $this;
        }

        public function init($files=[],$opt=[])
        {
            $this->reset();
            if(isset($opt["date"]) && !$opt["date"])
                $this->today = false;
            else
                $this->today = DateManager::Now("Y-m-d");

            if (isset($opt["image-upload"]))
                $this->image_upload = $opt["image-upload"];

            if (isset($opt["file-name"]))
                $this->file_name($opt["file-name"]);

            if (isset($opt["width"]))
                $this->width = $opt["width"];

            if (isset($opt["height"]))
                $this->height = $opt["height"];

            if (isset($opt["background-color"]))
                $this->background_color = $opt["background-color"];

            if (isset($opt["rotate"]))
                $this->rotate = $opt["rotate"];

            if (isset($opt["watermark"]))
                $this->watermark = $opt["watermark"];

            if (isset($opt["multiple"]))
                $this->multiple = $opt["multiple"];

            if (isset($opt["max-file-size"]))
                $this->max_file_size = $opt["max-file-size"];

            if ($files && is_array($files))
                $this->files = $files;
            else{
                $this->error .= "No file selected!";
                return false;
            }

            if (isset($opt["allowed-ext"]) && $opt["allowed-ext"] == "image/*")
                $this->allowed_ext = array($opt["allowed-ext"]);
            elseif (isset($opt["allowed-ext"]) && $opt["allowed-ext"] != ''){
                if(stristr($opt["allowed-ext"],"jpg")) $opt["allowed-ext"] .= ",.JPG";
                if(stristr($opt["allowed-ext"],"jpeg")) $opt["allowed-ext"] .= ",.JPEG";
                if(stristr($opt["allowed-ext"],"png")) $opt["allowed-ext"] .= ",.PNG";
                if(stristr($opt["allowed-ext"],"gif")) $opt["allowed-ext"] .= ",.GIF";
                $this->allowed_ext = explode(",",preg_replace('/\s+/', '',str_replace(".","",$opt["allowed-ext"])));
            }

            if(isset($opt["folder"]))
                $this->folder($opt["folder"]);

            return $this;
        }

        public function folder($arg=''){
            $this->original_folder = $arg;
            $this->upload_folder = $arg;
            return $this;
        }

        public function file_name($name=''){
            $this->file_name = $name;
            return $this;
        }

        private function getExt($filename=''){
            $value = explode(".", $filename);
            $extension = strtolower(array_pop($value));
            return $extension;
        }

        public function multiple_regular($arg=[]){
            $files = array();
            foreach ($arg as $k => $l) {
                foreach ($l as $i => $v) {
                    if (!array_key_exists($i, $files))
                        $files[$i] = array();
                    $files[$i][$k] = $v;
                }
            }
            return $files;
        }

        public function processed(){

            $folder     = ($this->today) ? $this->upload_folder.$this->today.DSEPARATOR : $this->upload_folder;
            if(!$this->folder_check($folder)) return false;

            $this->upload_folder = $folder;

            $uploading = ($this->multiple) ? $this->Multiple_Upload() : $this->Single_Upload();
            if(!$uploading){
                foreach($this->operands AS $ope){
                    $filepath = $this->original_folder.$ope["file_path"];
                    if(file_exists($filepath)){
                        unlink($filepath);
                    }
                }
            }
            return $uploading;
        }

        private function Multiple_Upload(){
            $regular = $this->multiple_regular($this->files);
            foreach($regular AS $file){
                $upload = ($this->image_upload) ? $this->image_uploaded($file) : $this->file_uploaded($file);
                if(!$upload) return false;
            }
            return true;
        }

        private function Single_Upload(){
            return $this->image_upload && @pathinfo($this->files["name"],PATHINFO_EXTENSION) != "svg" ? $this->image_uploaded($this->files) : $this->file_uploaded($this->files);
        }

        private function image_uploaded($file=[]){

            $image = new Upload($file);
            if($image->uploaded) {

                $image->file_overwrite = true;
                if($this->file_name && $this->file_name == "random")
                    $image->file_new_name_body = $this->random_name();
                elseif($this->file_name && $this->file_name == "current")
                    $image->file_new_name_body = false;
                elseif($this->file_name)
                    $image->file_new_name_body = $this->file_name;

                // Image background color
                //$config_color = Config::get("options/upload/background-color");
                //if($config_color && $this->background_color) $image->image_background_color = $config_color;

                // Image allowed extension
                $image->allowed = $this->allowed_ext;

                $jpeg_quality = Config::get("options/upload/jpeg-quality");
                if($jpeg_quality) $image->jpeg_quality = $jpeg_quality;

                //$image->image_ratio_fill = true;

                if($this->width == true OR $this->height == true){
                    $image->image_resize = true;
                    if($this->width != false AND $this->height != false){
                        $image->image_x = $this->width;
                        $image->image_y = $this->height;
                    }elseif($this->width != false AND $this->height == false){
                        $image->image_x = $this->width;
                        $image->image_ratio_y = true;
                    }elseif($this->height != false AND $this->width == false){
                        $image->image_y = $this->height;
                        $image->image_ratio_x = true;
                    }
                }

                if($this->rotate && $this->rotate != 0)
                    $image->image_rotate = $this->rotate;

                if($this->watermark != false && $this->watermark != ''){
                    $image->image_watermark = $this->watermark;
                    $image->image_watermark_position = 'L';
                }

                $image->Process($this->upload_folder);

                if($image->processed){
                    $this->operands[] = [
                        'size' => $file["size"],
                        'file_name' => $file["name"],
                        'name' => $image->file_dst_name,
                        'file_path' => ($this->today) ? $this->today."/".$image->file_dst_name : $image->file_dst_name,
                    ];
                    return true;
                }else{
                    $this->error = $image->error;
                    return false;
                }

            }else{
                $this->error = $image->error;
                return false;
            }
        }

        private function file_uploaded($file=[]){
            if($this->max_file_size && $file["size"] > $this->max_file_size){
                $this->error = "Maximum file size limit exceeded.";
                return false;
            }
            $ext    = $this->getExt($file["name"]);
            $ext2   = @pathinfo($file["name"],PATHINFO_EXTENSION);
            if(in_array($ext,$this->image_extensions) && in_array($ext2,$this->image_extensions))
                return $this->image_uploaded($file);
            else
            {
                if($this->extension_check($ext) && $this->extension_check($ext2)){
                    if($this->file_name && $this->file_name == "random")
                        $filename = $this->random_name().".".$ext;
                    elseif($this->file_name && $this->file_name == "current")
                        $filename = $file["name"];
                    elseif($this->file_name)
                        $filename = $this->file_name;

                    $ex   = @pathinfo( $filename,PATHINFO_EXTENSION);

                    if($ex == '') $filename .= ".".$ext;

                    $upload     = move_uploaded_file($file["tmp_name"],$this->upload_folder.$filename);
                    if(!$upload){
                        $this->error = "File upload failed!";
                        return false;
                    }
                    $this->operands[] = [
                        'size' => $file["size"],
                        'file_name' => $file["name"],
                        'name' => $filename,
                        'file_path' => ($this->today) ? $this->today."/".$filename : $filename,
                    ];
                    return true;
                }else{
                    $this->error = "Invalid file extension. File: ".$file["name"];
                    return false;
                }
            }
        }

        private function extension_check($ext=''){
            if($ext == '') return false;
            return (!$this->allowed_ext || in_array($ext,$this->allowed_ext));
        }

        private function folder_check($folder=''){
            if(!is_dir($folder)){
                if(!mkdir($folder, 0755, true)){
                    $this->error = "The mkdir() function did not work.";
                    return false;
                }
            }
            if(!file_exists($folder."index.html")){
                if(!touch($folder."index.html")){
                    $this->error = "The touch() function did not work.";
                    return false;
                }
            }
            return true;
        }

        private function random_name(){
            return strtolower(substr(md5(uniqid(rand())), 0,23));
        }

        public function reset(){
            $this->upload_folder = '';
            $this->error = '';
            $this->watermark = '';
            $this->file_name = '';
            $this->image_upload = false;
            $this->today  = false;
            $this->height = false;
            $this->width = false;
            $this->rotate = false;
            $this->multiple = false;
            $this->original_folder = false;
            $this->max_file_size = false;
            $this->background_color = true;
            $this->operands = [];
            $this->files = [];
            $this->allowed_ext = [];
            return true;
        }


    }