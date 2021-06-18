<?php
    class customer extends PleskApi\Operator {

        public function create($params=[]){
            $packet     = $this->client->get_packet();
            $wrap       = $packet->addChild($this->wrap_name);
            $add        = $wrap->addChild("add");
            $gen_info   = $add->addChild("gen_info");
            if($params){
                foreach($params AS $name=>$value){
                    if($name == "passwd") $value = $this->filter_value($value);
                    $gen_info->addChild($name,$value);
                }
            }

            $request     = $this->client->request($packet);
            $response     = $request->{$this->wrap_name}->add->result;

            if(isset($response->status) && $response->status == "ok") return $response;

            throw new \PleskApi\Exception("Could not create Customer Account.");
        }
        public function edit($id=0,$params=[]){
            $packet     = $this->client->get_packet();
            $wrap       = $packet->addChild($this->wrap_name);
            $set        = $wrap->addChild("set");
            $filter     = $set->addChild("filter");
            if(is_string($id)) $filter->addChild("login",$id);
            else $filter->addChild("id",$id);
            $values     = $set->addChild("values");

            if(isset($params["gen_info"])){
                $gen_info = $values->addChild("gen_info");
                foreach($params["gen_info"] AS $name=>$value) $gen_info->addChild($name,$value);
            }

            $request     = $this->client->request($packet);
            $response     = $request->{$this->wrap_name}->set->result;

            if(isset($response->status) && $response->status == "ok") return $response;

            throw new \PleskApi\Exception("Could not edit Customer Account");

        }
        public function convert_reseller($id=0,$plan=''){
            $packet     = $this->client->get_packet();
            $wrap       = $packet->addChild($this->wrap_name);
            $convert    = $wrap->addChild("convert-to-reseller");
            $filter     = $convert->addChild("filter");
            if(is_string($id)) $filter->addChild("login",$id);
            else $filter->addChild("id",$id);

            if($plan) $convert->addChild("reseller-plan-name",$plan);

            $request     = $this->client->request($packet);
            $response     = $request->{$this->wrap_name}->{"convert-to-reseller"}->result;

            if(isset($response->status) && $response->status == "ok") return $response;

            throw new \PleskApi\Exception("Customer Account could not be converted into a reseller account.");
        }
    }