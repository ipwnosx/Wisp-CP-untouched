<?php
    namespace PleskApi;
    use function GuzzleHttp\Psr7\str;

    class Client {

        protected
            $host,
            $port,
            $protocol,
            $username,
            $password,
            $secretKey,
            $version = '1.6.9.0',
            $endpoint = '/enterprise/control/agent.php';

        function __construct($host='',$port='8443',$protocol='https')
        {
            $this->host     = $host;
            $this->port     = $port;
            $this->protocol = $protocol;
        }

        public function set_version($arg=''){
            $this->version = $arg;
            return $this;
        }

        public function get_packet(){
            $packet   = "<?xml version='1.0' encoding='UTF-8' ?><packet />";
            return new \SimpleXMLElement($packet);
        }

        public function set_credentials($username='',$password='',$secret_key=''){
            $this->username     = $username;
            $this->password     = $password;
            $this->secretKey   = $secret_key;
            return $this;
        }

        public function request($data=''){
            $headers = [
                'Content-Type: text/xml',
                'HTTP_PRETTY_PRINT: TRUE',
            ];

            if($this->username && $this->password){
                $headers[] = "HTTP_AUTH_LOGIN: ".$this->username;
                $headers[] = "HTTP_AUTH_PASSWD: ".$this->password;
            }
            elseif($this->secretKey != '')
                $headers[] = "KEY: ".$this->secretKey;

            if($data instanceof \SimpleXMLElement) $data = $data->asXml();

            $ch     = curl_init();
            curl_setopt($ch, CURLOPT_URL,$this->protocol.'://'.$this->host.':'.$this->port.$this->endpoint);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch,CURLOPT_TIMEOUT,30);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

            $response   = curl_exec($ch);

            if($response === false && curl_errno($ch)) throw new Exception(curl_error($ch), curl_errno($ch));
            curl_close($ch);

            if(stristr($response,"302 Found")) throw new Exception("Cannot Connect to Server. 302 Found Error");
            if(stristr($response,"301 Moved Permanently")) throw new Exception("Cannot Connect to Server. 301 Moved Permanently");
            $xml    = new \SimpleXMLElement($response);
            if(!$xml) throw new Exception("XML Format is invalid.");

            if($xml->system && $xml->system->status && (string) $xml->system->status == 'error')
                throw new Exception( (string) $xml->system->errtext, (int) $xml->system->errcode);

            if($xml->xpath('//status[text()="error"]') && $xml->xpath('//errcode') && $xml->xpath('//errtext'))
                throw new Exception( (string) $xml->xpath('//errtext')[0], (int) $xml->xpath('//errcode')[0]);

            return $xml;
        }

        /**
         * @param string $name
         * @return mixed
         */
        public function operator($name=''){
            $filter_name = str_replace("-","_",$name);
            if(!class_exists($filter_name)) include __DIR__.DIRECTORY_SEPARATOR."operators".DIRECTORY_SEPARATOR.$name.".php";
            return new $filter_name($this,$name);
        }

    }