<?php
    class Basket {
        private static $storage = false;
        private static $name = "basket";
        private static $items=[];
        private static $discounts=[];

        private static function init(){
            if(!is_array(self::$storage) && !self::$storage){
                if(Session::get("basket")){
                    $storage = Session::get(self::$name,true);
                    $storage = Utility::jdecode($storage,true);
                    if(!$storage) self::$storage = [];
                    else self::$storage = $storage;
                }else self::$storage = [];
                if(isset(self::$storage["items"])) self::$items = self::$storage["items"];
                if(isset(self::$storage["discounts"])) self::$discounts = self::$storage["discounts"];
            }
        }
        static function get_checkout($id=0,$uid=0,$type='',$status='unpaid'){
            $stmt   = Models::$init->db->select()->from("checkouts");
            if($id && $uid)
                $stmt->where("id","=",$id,"&&")->where("user_id","=",$uid,"&&");
            else
                $stmt->where("id","=",$id,"&&");
            if($type) $stmt->where("type","=",$type,"&&");
            $stmt->where("status","=",$status);

            $data =  $stmt->build() ? $stmt->getAssoc() : false;
            if($data){
                $mdfnext       = DateManager::next_date([$data["mdfdate"],'day' => 1]);
                $elapsed       = DateManager::strtotime($mdfnext);
                $nowtime       = DateManager::strtotime();
                if($elapsed < $nowtime && $data["status"] != "paid" && $status != "paid"){
                    self::delete_checkout($data["id"]);
                    return false;
                }
                $data["items"] = $data["items"] ? Utility::jdecode($data["items"],true) : [];
                $data["data"]  = $data["data"] ? Utility::jdecode($data["data"],true) : [];
            }

            return $data;
        }

        static function add_checkout($data=[]){
            $data["id"] = rand(1000000000,9999999999);
            return Models::$init->db->insert("checkouts",$data) ? Models::$init->db->lastID() : false;
        }

        static function set_checkout($id=0,$data=[]){
            return Models::$init->db->update("checkouts",$data)->where("id","=",$id)->save();
        }

        static function delete_checkout($id=0){
            return Models::$init->db->delete("checkouts")->where("id","=",$id)->run();
        }


        static function setUnique($name,$options=[]){
            return md5(serialize([$name,$options]));
        }

        static function get($unique,$id=0){
            self::init();
            if(Validation::isInt($unique)){
                if(isset(self::$items[$unique])) return self::$items[$unique];
                return false;
            }

            $items = is_array(self::$items) ? self::$items : [];
            foreach($items AS $item) if($item["unique"] == $unique || ($id && $id == $item["id"])) return $item;

            return false;
        }

        static function set($key=false,$name='',$options=[],$plural="none",$quantity="none"){
            self::init();
            $unique     = $key ? $key : self::setUnique($name,$options);
            $check      = self::unique_check($unique);
            $unique     = self::setUnique($name,$options);
            $check_type = gettype($check);
            if($check_type == "boolean" && !$check){
                $id         = rand(10000,99999);
                $plural     = $plural == "none" ? true : $plural;
                $quantity   = $quantity == "none" ? 1 : $quantity;
            }else{
                $id         = self::$items[$check]["id"];
                $unique     = md5(serialize([$name,$options]));
                $plural     = $plural == "none" ? self::$items[$check]["plural"] : $plural;
                $quantityd  = self::$items[$check]["quantity"];
                $quantityx  = $plural == true ? $quantityd+1 : $quantityd;
                $quantity   = $quantity == "none" ? $quantityx : $quantity;
            }
            $data       = [
                'id'     => $id,
                'unique' => $unique,
                'name' => $name,
                'options' => $options,
                'plural' => $plural,
                'quantity' =>$quantity,
            ];

            if($check_type == "boolean" && !$check)
                array_push(self::$items,$data);
            else
                self::$items[$check] = $data;

            return $unique;
        }

        static function listing(){
            self::init();
            $data = self::$items;
            return $data;
        }

        static function unique_check($unique){
            $items = is_array(self::$items) ? self::$items : [];
            foreach($items AS $k=>$item) if($item["unique"] == $unique) return (int)$k;
            return false;
        }

        static function delete($unique=0,$id=0){
            self::init();
            $items = is_array(self::$items) ? self::$items : [];
            foreach($items AS $k=>$item){
                if($item["unique"] == $unique || ($id && $id == $item["id"])){
                    unset(self::$items[$k]);
                    return true;
                }
            }
            return false;
        }

        static function clear(){
            self::init();
            if(self::$storage){
                self::$storage      = [];
                self::$items        = [];
                self::$discounts    = [];
                Session::delete(self::$name);
            }
        }

        static function count(){
            self::init();
            return is_array(self::$items) ? sizeof(self::$items) : 0;
        }


        static function save($storage=false){
            $data = is_array($storage) ? $storage : self::$storage;
            $data["items"] = array_values(self::$items);
            $data["discounts"] = self::$discounts;
            $cdata = Utility::jencode($data);
            Session::set(self::$name,$cdata,true);
            return true;
        }


    }