<?php
    class mail extends PleskApi\Operator {

        public function getItems($infoTag = 'mailbox',$filters = []){

            $packet = $this->client->get_packet();
            $wrap   = $packet->addChild($this->wrap_name);
            $getTag = $wrap->addChild('get_info');

            $filterTag = $getTag->addChild('filter');
            if($filters) foreach($filters AS $field=>$value) $filterTag->addChild($field, $value);

            if(is_array($infoTag)) foreach($infoTag AS $row) $getTag->addChild($row);
            else $getTag->addChild($infoTag);

            $response = $this->client->request($packet);

            $items = $response->xpath('//result');

            return $items;
        }

        public function create($params=[]){
            $packet     = $this->client->get_packet();
            $wrap       = $packet->addChild($this->wrap_name);
            $create     = $wrap->addChild("create");
            $filter     = $create->addChild("filter");

            $filter->addChild("site-id",$params["site_id"]);
            $mailname   = $filter->addChild("mailname");
            $mailname->addChild("name",$params["username"]);
            $mailbox    = $mailname->addChild("mailbox");
            $mailbox->addChild("enabled","true");
            $mailbox->addChild("quota",$params["quota"]);
            $password   = $mailname->addChild("password");
            $password->addChild("value",$this->filter_value($params["password"]));
            $password->addChild("type","plain");

            $request     = $this->client->request($packet);
            $response     = $request->{$this->wrap_name}->create->result;

            if(isset($response->status) && (string) $response->status == "ok") return $response;

            throw new \PleskApi\Exception("Could not create Email Address");

        }

        public function edit_set($site_id=0,$name='',$params=[]){
            $packet = $this->client->get_packet();
            $wrap       = $packet->addChild($this->wrap_name);
            $update     = $wrap->addChild("update");
            $set        = $update->addChild("set");
            $filter     = $set->addChild("filter");
            $filter->addChild("site-id",$site_id);
            $mailname   = $filter->addChild("mailname");
            $mailname->addChild("name",$name);

            if(isset($params["password"])){
                $password   = $mailname->addChild("password");
                $password->addChild("value",$params["password"]);
            }

            if(isset($params["quota"])){
                $mailbox   = $mailname->addChild("mailbox");
                $mailbox->addChild("enabled","true");
                $mailbox->addChild("quota",$params["quota"]);
            }

            $request     = $this->client->request($packet);
            $response     = $request->{$this->wrap_name}->update->set->result;

            return isset($response->status) && (string) $response->status == "ok";

        }
        public function edit_add($site_id=0,$name='',$params=[]){
            $packet = $this->client->get_packet();
            $wrap       = $packet->addChild($this->wrap_name);
            $update     = $wrap->addChild("update");
            $add        = $update->addChild("add");
            $filter     = $add->addChild("filter");
            $filter->addChild("site-id",$site_id);
            $mailname   = $filter->addChild("mailname");
            $mailname->addChild("name",$name);

            if(isset($params["forward"])){
                $forwarding   = $mailname->addChild("forwarding");
                $forwarding->addChild("enabled","true");
                $forwarding->addChild("address",$params["forward"]);
            }

            $request     = $this->client->request($packet);
            $response     = $request->{$this->wrap_name}->update->add->result;

            return isset($response->status) && (string) $response->status == "ok";
        }
        public function edit_remove($site_id=0,$name='',$params=[]){
            $packet = $this->client->get_packet();
            $wrap       = $packet->addChild($this->wrap_name);
            $update     = $wrap->addChild("update");
            $remove     = $update->addChild("remove");
            $filter     = $remove->addChild("filter");
            $filter->addChild("site-id",$site_id);
            $mailname   = $filter->addChild("mailname");
            $mailname->addChild("name",$name);

            if(isset($params["forward"])){
                $forwarding   = $mailname->addChild("forwarding");
                $forwarding->addChild("address",$params["forward"]);
            }

            $request     = $this->client->request($packet);
            $response     = $request->{$this->wrap_name}->update->remove->result;

            return isset($response->status) && (string) $response->status == "ok";
        }

        public function delete($site_id=0,$name=''){
            $packet = $this->client->get_packet();
            $wrap       = $packet->addChild($this->wrap_name);
            $remove     = $wrap->addChild("remove");
            $filter     = $remove->addChild("filter");

            $filter->addChild("site-id",$site_id);
            $filter->addChild("name",$name);

            $request     = $this->client->request($packet);
            $response     = $request->{$this->wrap_name}->remove->result;

            return isset($response->status) && (string) $response->status == "ok";

        }

    }