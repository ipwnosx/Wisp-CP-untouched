<?php
    class VestaApi
    {
        private $server;
        public $error;

        public function __construct($server)
        {
            $this->server = $server;
        }


        public function call($command='',$post = [],$return_format='text')
        {
            $post['user']       = $this->server["username"];
            $post['password']   = $this->server["password"];
            $post['cmd']        = $command;


            $url  = (($this->server["secure"]) ? "https" : "http"). "://".$this->server["ip"].":".$this->server["port"]."/api/";
            $call = curl_init();
            curl_setopt($call, CURLOPT_URL, $url);
            curl_setopt($call, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($call, CURLOPT_POST, true);
            curl_setopt($call, CURLOPT_POSTFIELDS, http_build_query($post));
            curl_setopt($call, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($call, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($call,CURLOPT_TIMEOUT,120);

            // Fire api
            $result = curl_exec($call);

            if(curl_errno($call)){
                $this->error = curl_error($call);
                return false;
            }

            if(stristr($result,'Error:')){
                $this->error = $result;
                return false;
            }

            if($return_format == 'json'){
                $result = json_decode($result,true);

                if(!$result){
                    $this->error = 'Unable to parse the response returned from the API.';
                    return false;
                }
            }

            if(!$result){
                $this->error = "Connection Failed";
                return false;
            }

            curl_close($call);

            // Return data
            return $result;
        }


    }