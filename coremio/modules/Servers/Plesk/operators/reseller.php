<?php
    class reseller extends PleskApi\Operator {

        public function create($params=[],$options=[]){
            $packet     = $this->client->get_packet();
            $wrap       = $packet->addChild($this->wrap_name);
            $add        = $wrap->addChild("add");
            $gen_info   = $add->addChild("gen-info");
            if($params){
                foreach($params AS $name=>$value){
                    if($name == "passwd") $value = $this->filter_value($value);
                    $gen_info->addChild($name,$value);
                }
            }

            if(isset($options["plan"]) && $options["plan"]) $add->addChild("plan-name",$options["plan"]);
            elseif(isset($options["limits"]) && $options["limits"]){
                $limits = $add->addChild("limits");
                $resource_policy =  $limits->addChild("resource-policy");
                $resource_policy->addChild("overuse","block");
                foreach($options["limits"] as $name=>$value){
                    $limit  = $limits->addChild("limit");
                    $limit->addChild("name",$name);
                    $limit->addChild("value",$value);
                }
            }

            $request     = $this->client->request($packet);
            $response     = $request->{$this->wrap_name}->add->result;

            if(isset($response->status) && $response->status == "ok") return $response;

            throw new \PleskApi\Exception("Could not create Reseller Account.");
        }
        public function edit($id=0,$params=[]){
            $packet     = $this->client->get_packet();
            $wrap       = $packet->addChild($this->wrap_name);
            $set        = $wrap->addChild("set");
            $filter     = $set->addChild("filter");
            if(is_string($id)) $filter->addChild("login",$id);
            else $filter->addChild("id",$id);
            $values     = $set->addChild("values");

            if(isset($params["gen-info"])){
                $gen_info = $values->addChild("gen-info");
                foreach($params["gen-info"] AS $name=>$value) $gen_info->addChild($name,$value);
            }

            if(isset($params["limits"]) && $params["limits"]){
                $limits = $values->addChild("limits");
                $resource_policy =  $limits->addChild("resource-policy");
                $resource_policy->addChild("overuse","block");
                foreach($params["limits"] as $name=>$value){
                    $limit  = $limits->addChild("limit");
                    $limit->addChild("name",$name);
                    $limit->addChild("value",$value);
                }
            }

            $request     = $this->client->request($packet);
            $response     = $request->{$this->wrap_name}->set->result;

            if(isset($response->status) && $response->status == "ok") return $response;

            throw new \PleskApi\Exception("Could not edit Reseller Account");

        }
        public function change_plan($id=0,$plan=''){
            $packet     = $this->client->get_packet();
            $wrap       = $packet->addChild($this->wrap_name);
            $switch     = $wrap->addChild("switch-subscription");
            $filter     = $switch->addChild("filter");
            if(is_string($id))
                $filter->addChild("login",$id);
            else
                $filter->addChild("id",$id);

            if($plan == '') $switch->addChild("no-plan");
            else $switch->addChild("plan-guid",$plan);

            $request     = $this->client->request($packet);

            $response     = $request->{$this->wrap_name}->{"switch-subscription"}->result;

            if(isset($response->status) && $response->status == "ok") return $response;

            throw new \PleskApi\Exception("Could not change reseller plan");
        }
        public function convert_customer($id=0){
            $packet     = $this->client->get_packet();
            $wrap       = $packet->addChild($this->wrap_name);
            $convert    = $wrap->addChild("convert-to-customer");
            $filter     = $convert->addChild("filter");
            if(is_string($id)) $filter->addChild("login",$id);
            else $filter->addChild("id",$id);

            $request     = $this->client->request($packet);
            $response     = $request->{$this->wrap_name}->{"convert-to-customer"}->result;

            if(isset($response->status) && $response->status == "ok") return $response;

            throw new \PleskApi\Exception("Reseller Account could not be converted into a customer account.");
        }

    }