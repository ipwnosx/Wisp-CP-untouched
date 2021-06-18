<?php
    class ISPmanager_API
    {
        public $server;
        public $error;
        public $status_code;
        public $header;

        public function __construct($server=[])
        {
            $this->server = $server;
        }

        public function get_external_id($params) {
            return isset($params["user"]) ? $params["user"] : '';
        }

        public function request($func, $param)
        {
            global $op;
            $ip             = $this->server["ip"];
            $username       = $this->server["username"];
            $password       = $this->server["password"];

            if(!function_exists("ISPmanager_header_read"))
            {
                function ISPmanager_header_read($ch, $header)
                {
                    $GLOBALS["header"] = $header;

                    return strlen($header);
                }
            }


            $default_xml_string = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<doc/>\n";
            $default_xml_error_string = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<doc><error type=\"curl\"/></doc>\n";

            $url    = $this->server["secure"] ? "https://" : "http://";
            $url    .= $ip.":".$this->server["port"];
            $url    .= "/ispmgr";
            $postfields = array("out" => "xml", "func" => (string)$func, "authinfo" => (string)$username.":".(string)$password, );
            foreach ($param as $key => &$value) {
                $value = (string)$value;
            }

            $data       = array_merge($postfields, $param);

            $curl       = curl_init();

            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl,CURLOPT_TIMEOUT,60);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl, CURLOPT_POSTFIELDS,http_build_query($data));
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_HEADERFUNCTION, 'ISPmanager_header_read');
            $response           = curl_exec($curl);
            $this->status_code  = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $this->header       = $GLOBALS["header"];
            $err                = curl_error($curl);
            curl_close($curl);

            if($err)
            {
                $out = simplexml_load_string($default_xml_error_string);
                $out->error->addChild("msg", $err);
            }

            if(!$err && $this->status_code !== 200)
                $this->error = "Error Status code: ".$this->status_code;

            if(isset($data["authinfo"])) $data["authinfo"] = "*****HIDDEN*****";

            Modules::save_log("Servers","ISPmanager",$url." ".$func." - ".$op,$data,$err ? $err : htmlentities($response));

            if(!$err)
            {
                try {
                    $out = new SimpleXMLElement($response);
                } catch (Exception $e) {
                    $out = simplexml_load_string($default_xml_error_string);
                    $out->error->addChild("msg", $e->getMessage());
                }
            }

            return isset($out) ? $out : $response;
        }

        public function find_error($xml)
        {
            $error = "";
            if($this->error) return $this->error;
            if ($xml->error) {
                $error = $xml->error["type"].":".$xml->error->msg;
            }
            return $error;
        }

    }