<?php
    class webspace extends PleskApi\Operator {

        public function create($params=[]){
            $packet     = $this->client->get_packet();
            $wrap       = $packet->addChild($this->wrap_name);
            $add        = $wrap->addChild("add");
            $gen_setup  = $add->addChild("gen_setup");
            if(isset($params["gen_setup"])) foreach($params["gen_setup"] AS $key=>$val) $gen_setup->addChild($key,$val);


            if(isset($params["properties"])){
                $hosting = $add->addChild("hosting");

                $htype   = $hosting->addChild($params["gen_setup"]["htype"]);
                foreach($params["properties"] AS $name=>$value){
                    if($name == "ftp_password") $value = $this->filter_value($value);
                    $property = $htype->addChild("property");
                    $property->addChild("name",$name);
                    $property->addChild("value",$value);
                }
                $htype->addChild("ip_address",$params["ip_address"]);

                if(!isset($params["plan"]) || !$params["plan"] && isset($params["limits"]) && $params["limits"]){
                    $limits = $add->addChild("limits");
                    $limits->addChild("overuse","block");
                    foreach($params["limits"] as $name=>$value){
                        $limit  = $limits->addChild("limit");
                        $limit->addChild("name",$name);
                        $limit->addChild("value",$value);
                    }
                }
            }

            if(isset($params["plan"]) && $params["plan"]) $add->addChild("plan-name",$params["plan"]);

            $request     = $this->client->request($packet);
            $response     = $request->{$this->wrap_name}->add->result;

            if(isset($response->status) && $response->status == "ok") return $response;

            throw new \PleskApi\Exception("Could not create Subscription Account");
        }
        public function edit($id=0,$params=[]){
            $packet     = $this->client->get_packet();
            $wrap       = $packet->addChild($this->wrap_name);
            $set        = $wrap->addChild("set");
            $filter     = $set->addChild("filter");
            if(is_string($id))
                $filter->addChild("owner-login",$id);
            else
                $filter->addChild("id",$id);
            $values     = $set->addChild("values");

            if(isset($params["gen_setup"])){
                $gen_setup  = $values->addChild("gen_setup");
                if(isset($params["gen_setup"])) foreach($params["gen_setup"] AS $key=>$val) $gen_setup->addChild($key,$val);
            }

            if((!isset($params["plan"]) || !$params["plan"]) && isset($params["limits"]) && $params["limits"]){
                $limits = $values->addChild("limits");
                $limits->addChild("overuse","block");
                foreach($params["limits"] as $name=>$value){
                    $limit  = $limits->addChild("limit");
                    $limit->addChild("name",$name);
                    $limit->addChild("value",$value);
                }
            }
            if(isset($params["plan"]) && $params["plan"]) $values->addChild("plan-name",$params["plan"]);

            if(isset($params["hosting"])){
                $hosting = $values->addChild("hosting");
                $htype  = $hosting->addChild($params["hosting"]["htype"]);
                foreach($params["hosting"]["properties"] AS $name=>$value){
                    $property = $htype->addChild("property");
                    $property->addChild("name",$name);
                    $property->addChild("value",$value);
                }
            }


            $request     = $this->client->request($packet);
            $response     = $request->{$this->wrap_name}->set->result;

            if(isset($response->status) && $response->status == "ok") return $response;

            throw new \PleskApi\Exception("Could not edit Subscription Account");
        }
        public function change_plan($id=0,$plan=''){
            $packet     = $this->client->get_packet();
            $wrap       = $packet->addChild($this->wrap_name);
            $switch     = $wrap->addChild("switch-subscription");
            $filter     = $switch->addChild("filter");
            if(is_string($id))
                $filter->addChild("owner-login",$id);
            else
                $filter->addChild("id",$id);

            if($plan == '') $switch->addChild("no-plan");
            else $switch->addChild("plan-guid",$plan);

            $request     = $this->client->request($packet);
            $response     = $request->{$this->wrap_name}->{"switch-subscription"}->result;

            if(isset($response->status) && $response->status == "ok") return $response;

            throw new \PleskApi\Exception("Could not change plan subscription account");
        }

    }