<?php
    defined('CORE_FOLDER') OR exit('You can not get in here!');
    class Controller extends Controllers
    {
        protected $params,$data=[];

        public function __construct($arg=[])
        {
            parent::__construct();
            $this->params       = $arg['params'];
            if(!UserManager::LoginCheck("admin")) die();
            Helper::Load("Admin");
            if(!Admin::isPrivilege(["UPLOAD_EDITOR_PICTURE"])){
                header("HTTP/1.1 406 Access Denied");
                return;
            }
        }

        public function main(){

            if(DEMO_MODE){
                die();
            }

            /*******************************************************
             * Only these origins will be allowed to upload images *
             ******************************************************/
            $origin = Utility::isSSL() ? "https://" : "http://";
            $origin .= Utility::www_check();
            $origin .= str_replace("www.","",Utility::getDomain());
            $accepted_origins = array($origin);

            /*********************************************
             * Change this line to set the upload folder *
             *********************************************/
            $imageFolder = RESOURCE_DIR."uploads".DS."editor".DS;


            reset ($_FILES);
            $temp = current($_FILES);
            if (is_uploaded_file($temp['tmp_name'])){
                
                /*if (isset($_SERVER['HTTP_ORIGIN'])) {
                    // same-origin requests won't set an origin. If the origin is set, it must be valid.
                    if (in_array($_SERVER['HTTP_ORIGIN'], $accepted_origins)) {
                        header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
                    } else {
                        header("HTTP/1.1 403 Origin Denied");
                        return;
                    }
                } */

                /*
                  If your script needs to receive cookies, set images_upload_credentials : true in
                  the configuration and enable the following two headers.
                */
                // header('Access-Control-Allow-Credentials: true');
                // header('P3P: CP="There is no P3P policy."');

                $name   = Filter::route($temp["name"]);

                // Sanitize input
                if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $name)) {
                    header("HTTP/1.1 400 Invalid file name.");
                    return;
                }

                // Verify extension
                $extension = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                if (!in_array($extension, array("gif", "jpg","jpeg","png","webp"))) {
                    header("HTTP/1.1 400 Invalid extension.");
                    return;
                }

                $name   = md5(rand(1000000000,9999999999)).".".$extension;

                // Accept upload if there was no origin, or if it is an accepted origin
                $filetowrite = $imageFolder . $name;
                $uploading = move_uploaded_file($temp['tmp_name'], $filetowrite);

                if(!$uploading){
                    header("HTTP/1.1 400 The image file could not be uploaded.");
                    return;
                }

                // Respond to the successful upload with JSON.
                // Use a location key to specify the path to the saved image resource.
                // { location : '/your/uploaded/image/file'}
                echo json_encode(array(
                    'location' => Utility::image_link_determiner($filetowrite)
                ));
            } else {
                // Notify editor that the upload failed
                header("HTTP/1.1 500 Server Error");
            }

        }
    }