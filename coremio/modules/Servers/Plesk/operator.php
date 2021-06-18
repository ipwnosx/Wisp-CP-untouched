<?php
    namespace PleskApi;
    use function GuzzleHttp\Psr7\str;

    class Operator {

        protected
            $client,
            $wrap_name;

        function __construct(Client $client, $name='')
        {
            $this->client       = $client;
            $this->wrap_name    = $name;
        }

        public function filter_value($value=''){
            return str_replace(['&','<','>'],['&amp;','&lt;','&gt;'], $value);
        }

        public function _delete($method_name = 'del',$field, $value){
            $packet     = $this->client->get_packet();
            $wrap       = $packet->addChild($this->wrap_name);
            $method     = $wrap->addChild($method_name);
            $filter     = $method->addChild("filter");
            $filter->addChild($field,$value);

            $response = $this->client->request($packet);
            return isset($response->status) && (string) $response->status == "ok";
        }

        public function _get($infoTag='',$filters=[]){
            return $this->_getItems($infoTag ? $infoTag : 'gen_info',$filters);
        }

        public function _getItems($infoTag='',$filters=[]){
            $packet = $this->client->get_packet();
            $wrap   = $packet->addChild($this->wrap_name);
            $getTag = $wrap->addChild('get');

            $filterTag = $getTag->addChild('filter');
            if($filters) foreach($filters AS $field=>$value) $filterTag->addChild($field, $value);

            if($infoTag && $this->wrap_name == "reseller-plan"){
                if(is_array($infoTag)) foreach($infoTag AS $row) $getTag->addChild($row);
                else $getTag->addChild($infoTag);
            }elseif($infoTag){
                $data_set = $getTag->addChild('dataset');
                if(is_array($infoTag)) foreach($infoTag AS $row) $data_set->addChild($row);
                else $data_set->addChild($infoTag);
            }

            $response = $this->client->request($packet);

            $items = $response->xpath('//result');

            return $items;
        }

    }