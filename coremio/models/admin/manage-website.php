<?php
    defined('CORE_FOLDER') OR exit('You can not get in here!');
    class Model extends Models
    {
        function __construct()
        {
            parent::__construct();
        }

        public function delete_menu($id=0){
            return $this->db->delete("mns,mnsl","menus mns")
                ->join("LEFT","menus_lang mnsl","mnsl.owner_id=mns.id")
                ->where("mns.id","=",$id)
                ->run();
        }

        public function get_menu($id=0){
            $lang = Config::get("general/local");
            return $this->db->select("t1.*,t2.title")
                ->from("menus AS t1")
                ->join("LEFT","menus_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'")
                ->where("t2.id","IS NOT NULL","","&&")
                ->where("t1.id","=",$id)
                ->build() ? $this->db->getAssoc() : false;
        }

        public function get_menu_lang($id=0,$lang=''){
            return $this->db->select()
                ->from("menus_lang")
                ->where("owner_id","=",$id,"&&")
                ->where("lang","=",$lang)->build() ? $this->db->getAssoc() : false;
        }

        public function get_menu_sub($id=0,$data=[]){
            $stmt   = $this->db->select("id")->from("menus");
            $stmt->where("parent","=",$id);
            if($stmt->build()){
                foreach($stmt->fetch_assoc() AS $f){
                    $data[]     = $f["id"];
                    $children   = $this->get_menu_sub($f["id"]);
                    if($children) $data = array_merge($data,$children);
                }
                return $data;
            }else
                return $data;
        }

        public function insert_menu($data=[]){
            return $this->db->insert("menus",$data) ? $this->db->lastID() : false;
        }

        public function insert_menu_lang($data=[]){
            return $this->db->insert("menus_lang",$data) ? $this->db->lastID() : false;
        }

        public function set_menu($id=0,$data=[]){
            return $this->db->update("menus",$data)->where("id","=",$id)->save();
        }

        public function set_menu_lang($id=0,$data=[]){
            return $this->db->update("menus_lang",$data)->where("id","=",$id)->save();
        }

        public function select_pages(){
            $lang   = Config::get("general/local");
            $result = [];

            $result['home']         = __("admin/manage-website/select-pages-home");

            $pages   = $this->db->select("t1.id,t2.title")->from("pages AS t1");
            $pages->join("LEFT","pages_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $pages->where("t1.type","=","normal");
            $pages->order_by("t1.id DESC");
            $pages = $pages->build() ? $pages->fetch_assoc() : [];
            if($pages){
                $result["disabled-pages-normal"] = __("admin/manage-website/select-pages-normal");
                foreach($pages AS $page) $result["pages/".$page["id"]] = "- ".$page["title"];
            }

            if(Config::get("options/pg-activation/domain"))
                $result["product-group/domain"] = __("admin/manage-website/select-pages-product-group-domain");

            if(Config::get("options/pg-activation/hosting")){
                $result["product-group/hosting"] = __("admin/manage-website/select-pages-product-group-hosting");
                if($categories = $this->get_select_categories("products",0,"hosting","-"))
                    foreach($categories AS $category)
                        $result["category/".$category["id"]] = $category["title"];
            }

            if(Config::get("options/pg-activation/server")){
                $result["product-group/server"] = __("admin/manage-website/select-pages-product-group-server");
                if($categories = $this->get_select_categories("products",0,"server","-"))
                    foreach($categories AS $category)
                        $result["category/".$category["id"]] = $category["title"];
            }

            if(Config::get("options/pg-activation/software")){
                $result["product-group/software"] = __("admin/manage-website/select-pages-product-group-software");
                if($categories = $this->get_select_categories("software",0,"","-")){
                    foreach($categories AS $category){
                        $result["category/".$category["id"]] = $category["title"];

                        $pages   = $this->db->select("t1.id,t2.title")->from("pages AS t1");
                        $pages->join("LEFT","pages_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
                        $pages->where("t1.type","=","software","&&");
                        $pages->where("t1.category","=",$category["id"]);
                        $pages->order_by("t1.id DESC");
                        $pages = $pages->build() ? $pages->fetch_assoc() : [];
                        if($pages) foreach($pages AS $page) $result["pages/".$page["id"]] = $category["line"]."> ".$page["title"];

                    }
                }

                $pages   = $this->db->select("t1.id,t2.title")->from("pages AS t1");
                $pages->join("LEFT","pages_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
                $pages->where("t1.type","=","software","&&");
                $pages->where("t1.category","=","0");
                $pages->order_by("t1.id DESC");
                $pages = $pages->build() ? $pages->fetch_assoc() : [];
                if($pages) foreach($pages AS $page) $result["pages/".$page["id"]] = "> ".$page["title"];
            }

            if(Config::get("options/pg-activation/sms") && Config::get("general/country") == "tr")
                $result["product-group/sms"] = __("admin/manage-website/select-pages-product-group-sms");

            if(Config::get("options/pg-activation/international-sms"))
                $result["product-group/international-sms"] = __("admin/manage-website/select-pages-product-group-intl-sms");

            if($categories = $this->get_select_categories("products",0,"special"))
                foreach($categories AS $category)
                    $result["category/".$category["id"]] = $category["title"];

            $pages   = $this->db->select("t1.id,t2.title")->from("pages AS t1");
            $pages->join("LEFT","pages_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $pages->where("t1.type","=","news");
            $pages->order_by("t1.id DESC");
            $pages = $pages->build() ? $pages->fetch_assoc() : [];
            if($pages){
                $result["news"] = __("admin/manage-website/select-pages-news");
                foreach($pages AS $page) $result["pages/".$page["id"]] = "- ".$page["title"];
            }


            if($categories = $this->get_select_categories("articles",0,"","-")){
                $result["articles"] = __("admin/manage-website/select-pages-articles");
                foreach($categories AS $category) {
                    $result["category/" . $category["id"]] = $category["title"];
                    $pages   = $this->db->select("t1.id,t2.title")->from("pages AS t1");
                    $pages->join("LEFT","pages_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
                    $pages->where("t1.type","=","articles","&&");
                    $pages->where("t1.category","=",$category["id"]);
                    $pages->order_by("t1.id DESC");
                    $pages = $pages->build() ? $pages->fetch_assoc() : [];
                    if($pages) foreach($pages AS $page) $result["pages/".$page["id"]] = $category["line"]."> ".$page["title"];
                    
                }
            }

            $pages   = $this->db->select("t1.id,t2.title")->from("pages AS t1");
            $pages->join("LEFT","pages_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $pages->where("t1.type","=","articles","&&");
            $pages->where("t1.category","=","0");
            $pages->order_by("t1.id DESC");
            $pages = $pages->build() ? $pages->fetch_assoc() : [];
            if($pages){
                if(!isset($result["articles"])) $result["articles"] = __("admin/manage-website/select-pages-articles");
                foreach($pages AS $page) $result["pages/".$page["id"]] = "> ".$page["title"];
            }


            if($categories = $this->get_select_categories("references",0,"","-")){
                $result["references"] = __("admin/manage-website/select-pages-references");
                foreach($categories AS $category) {
                    $result["category/" . $category["id"]] = $category["title"];
                    $pages   = $this->db->select("t1.id,t2.title")->from("pages AS t1");
                    $pages->join("LEFT","pages_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
                    $pages->where("t1.type","=","references","&&");
                    $pages->where("t1.category","=",$category["id"]);
                    $pages->order_by("t1.id DESC");
                    $pages = $pages->build() ? $pages->fetch_assoc() : [];
                    if($pages) foreach($pages AS $page) $result["pages/".$page["id"]] = $category["line"]."> ".$page["title"];

                }
            }

            $pages   = $this->db->select("t1.id,t2.title")->from("pages AS t1");
            $pages->join("LEFT","pages_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $pages->where("t1.type","=","references","&&");
            $pages->where("t1.category","=","0");
            $pages->order_by("t1.id DESC");
            $pages = $pages->build() ? $pages->fetch_assoc() : [];
            if($pages){
                if(!isset($result["references"])) $result["references"] = __("admin/manage-website/select-pages-references");
                foreach($pages AS $page) $result["pages/".$page["id"]] = "> ".$page["title"];
            }

            if(Config::get("options/kbase-system")){
                if($categories = $this->get_select_categories("knowledgebase",0,"","-")){
                    $result["kbase"] = __("admin/manage-website/select-pages-kbase");
                    foreach($categories AS $category) {
                        $result["category/" . $category["id"]] = $category["title"];
                        $pages   = $this->db->select("t1.id,t2.title")->from("knowledgebase AS t1");
                        $pages->join("LEFT","knowledgebase_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
                        $pages->where("t1.category","=",$category["id"]);
                        $pages->order_by("t1.id DESC");
                        $pages = $pages->build() ? $pages->fetch_assoc() : [];
                        if($pages) foreach($pages AS $page) $result["kbase-page/".$page["id"]] = $category["line"]."> ".$page["title"];

                    }
                }

                $pages   = $this->db->select("t1.id,t2.title")->from("knowledgebase AS t1");
                $pages->join("LEFT","knowledgebase_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
                $pages->where("t1.category","=","0");
                $pages->order_by("t1.id DESC");
                $pages = $pages->build() ? $pages->fetch_assoc() : [];
                if($pages){
                    if(!isset($result["kbase"])) $result["kbase"] = __("admin/manage-website/select-pages-kbase");
                    foreach($pages AS $page) $result["kbase-page/".$page["id"]] = "> ".$page["title"];
                }
            }

            $result["contact"] = __("admin/manage-website/select-pages-contact");
            if(Config::get("options/basket-system"))
                $result["basket"] = __("admin/manage-website/select-pages-basket");

            if(Config::get("options/pg-activation/software"))
                $result["license"] = __("admin/manage-website/select-pages-license");

            $result["contract1"] = __("admin/manage-website/select-pages-contract1");
            $result["contract2"] = __("admin/manage-website/select-pages-contract2");

            $result["login-account"]    = __("admin/manage-website/select-pages-login-account");
            $result["create-account"]   = __("admin/manage-website/select-pages-create-account");
            $result["ca-dashboard"]     = __("admin/manage-website/select-pages-ca-dashboard");

            if(Config::get("options/ticket-system")){
                $result["ca-tickets"] = __("admin/manage-website/select-pages-ca-tickets");
                $result["ca-open-ticket"] = __("admin/manage-website/select-pages-ca-open-ticket");
            }

            $result["ca-orders"]            = __("admin/manage-website/select-pages-ca-services");

            if(Config::get("options/pg-activation/domain"))
                $result["ca-domains"]       = __("admin/manage-website/select-pages-ca-domains");

            if(Config::get("options/pg-activation/international-sms"))
                $result["ca-intl-sms"]      = __("admin/manage-website/select-pages-ca-intl-sms");

            $result["ca-invoices"]          = __("admin/manage-website/select-pages-ca-invoices");
            $result["ca-ac-information"]    = __("admin/manage-website/select-pages-ca-ac-information");
            $result["ca-messages"]          = __("admin/manage-website/select-pages-ca-messages");
            $result["ca-addons"]            = __("admin/manage-website/select-pages-ca-addons");
            $result["ca-affiliate"]         = __("admin/manage-website/select-pages-ca-affiliate");
            $result["ca-reseller"]         = __("admin/manage-website/select-pages-ca-reseller");

            return $result;
        }

        public function get_menus($type='',$status='',$parent=0){
            $lang   = Config::get("general/local");

            $stmt   = $this->db->select("t1.*,t2.title")->from("menus AS t1");
            $stmt->join("LEFT","menus_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $stmt->where("t2.id","IS NOT NULL","","&&");
            $stmt->where("t1.type","=",$type,"&&");
            $stmt->where("t1.parent","=",$parent,"&&");
            $stmt->where("t1.status","=",$status);
            $stmt->order_by("t1.rank ASC,t1.id ASC");
            if($stmt->build()){
                $result = $stmt->fetch_assoc();
                $keys   = array_keys($result);
                $size   = sizeof($keys)-1;
                for($i=0;$i<=$size;$i++){
                    $row = $result[$keys[$i]];
                    $children   = $this->get_menus($type,$status,$row["id"]);
                    if($children) $result[$keys[$i]]["children"] = $children;
                }
                return $result;
            }else
                return false;
        }

        public function get_cfeedback($id=0){
            return $this->db->select("*,CASE WHEN company_name = '' THEN full_name ELSE CONCAT_WS(' - ',full_name,company_name) END AS name")
                ->from("customer_feedbacks")
                ->where("id","=",$id)
                ->build() ? $this->db->getAssoc() : false;
        }

        public function get_message($id=0){
            return $this->db->select()->from("contact_messages")->where("id","=",$id)->build() ? $this->db->getAssoc() : false;
        }

        public function set_message($id,$data){
            return $this->db->update("contact_messages",$data)->where("id","=",$id)->save();
        }

        public function get_cfeedback_lang($id=0,$lang=''){
            return $this->db->select()
                ->from("customer_feedbacks_lang")
                ->where("owner_id","=",$id,"&&")
                ->where("lang","=",$lang)->build() ? $this->db->getAssoc() : false;
        }

        public function delete_cfeedback($id){

            $folder1    = Config::get("pictures/customer-feedback/folder");

            $pic1       = $this->db->select("id,name")->from("pictures");
            $pic1->where("owner","=","customer_feedback","&&");
            $pic1->where("owner_id","=",$id,"&&");
            $pic1->where("reason","=","image");
            $pic1       = $pic1->build() ? $pic1->getAssoc() : false;
            if($pic1){
                FileManager::file_delete($folder1.$pic1["name"]);
                $this->db->delete("pictures")->where("id","=",$pic1["id"])->run();
            }

            return $this->db->delete("cfdbck,cfdbckl","customer_feedbacks cfdbck")
                ->join("LEFT","customer_feedbacks_lang cfdbckl","cfdbckl.owner_id=cfdbck.id")
                ->where("cfdbck.id","=",$id)
                ->run();
        }

        public function delete_message($id){
            return $this->db->delete("contact_messages")->where("id","=",$id)->run();
        }

        public function insert_cfeedback($data=[]){
            return $this->db->insert("customer_feedbacks",$data) ? $this->db->lastID() : false;
        }

        public function insert_cfeedback_lang($data=[]){
            return $this->db->insert("customer_feedbacks_lang",$data) ? $this->db->lastID() : false;
        }

        public function set_cfeedback($id,$data=[]){
            return $this->db->update("customer_feedbacks",$data)->where("id","=",$id)->save();
        }

        public function set_cfeedback_lang($id,$data=[]){
            return $this->db->update("customer_feedbacks_lang",$data)->where("id","=",$id)->save();
        }

        public function delete_slide($id){

            $folder1    = Config::get("pictures/slides/folder");
            $folder2    = $folder1."thumb".DS;

            $pic1       = $this->db->select("id,name")->from("pictures");
            $pic1->where("owner","=","slides","&&");
            $pic1->where("owner_id","=",$id,"&&");
            $pic1->where("reason","=","main-image");
            $pic1       = $pic1->build() ? $pic1->getAssoc() : false;
            if($pic1){
                FileManager::file_delete($folder1.$pic1["name"]);
                FileManager::file_delete($folder2.$pic1["name"]);
                $this->db->delete("pictures")->where("id","=",$pic1["id"])->run();
            }

            return $this->db->delete("sldr,sldrl","slides sldr")
                ->join("LEFT","slides_lang sldrl","sldrl.owner_id=sldr.id")
                ->where("sldr.id","=",$id)
                ->run();
        }

        public function insert_slide($data=[]){
            return $this->db->insert("slides",$data) ? $this->db->lastID() : false;
        }

        public function set_slide($id,$data=[]){
            return $this->db->update("slides",$data)->where("id","=",$id)->save();
        }

        public function insert_slide_lang($data=[]){
            return $this->db->insert("slides_lang",$data) ? $this->db->lastID() : false;
        }

        public function set_slide_lang($id,$data=[]){
            return $this->db->update("slides_lang",$data)->where("id","=",$id)->save();
        }

        public function get_slide($id=0){
            $lang = Config::get("general/local");
            return $this->db->select("t1.*,t2.title")
                ->from("slides AS t1")
                ->join("LEFT","slides_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'")
                ->where("t1.id","=",$id)
                ->build() ? $this->db->getAssoc() : false;
        }

        public function get_slide_lang($id=0,$lang=''){
            return $this->db->select()
                ->from("slides_lang")
                ->where("owner_id","=",$id,"&&")
                ->where("lang","=",$lang)->build() ? $this->db->getAssoc() : false;
        }

        public function get_category_sub($id=0,$data=[]){
            $stmt   = $this->db->select("id")->from("categories");
            $stmt->where("parent","=",$id);
            if($stmt->build()){
                foreach($stmt->fetch_assoc() AS $f){
                    $data[]     = $f["id"];
                    $children   = $this->get_category_sub($f["id"]);
                    if($children) $data = array_merge($data,$children);
                }
                return $data;
            }else
                return $data;
        }

        public function delete_category($id){
            $this->db->delete("cy,cyl","categories cy")
                ->join("INNER","categories_lang cyl","cyl.owner_id=cy.id")
                ->where("cy.id","=",$id)->run();

            $pics = $this->db->select("id,name,reason")->from("pictures");
            $pics->where("owner_id","=",$id,"&&");
            $pics->where("owner","=","category");
            if($pics->build()){
                foreach($pics->fetch_assoc() AS $row){
                    if($row["reason"] == "header-background"){
                        $folder1 = Config::get("pictures/header-background/folder");
                        $folder2 = $folder1."thumb".DS;
                        $this->db->delete("pictures")->where("id","=",$row["id"])->run();
                        FileManager::file_delete($folder1.$row["name"]);
                        FileManager::file_delete($folder2.$row["name"]);
                    }
                }
            }
        }

        public function insert_category($data){
            return $this->db->insert("categories",$data) ? $this->db->lastID() : false;
        }

        public function insert_category_lang($data){
            return $this->db->insert("categories_lang",$data) ? $this->db->lastID() : false;
        }

        public function set_category($id=0,$data=[]){
            return $this->db->update("categories",$data)->where("id","=",$id)->save();
        }

        public function set_category_lang($id=0,$data=[]){
            return $this->db->update("categories_lang",$data)->where("id","=",$id)->save();
        }

        public function get_category_wlang($id=0,$lang=''){
            $stmt       = $this->db->select()->from("categories_lang");
            $stmt->where("lang","=",$lang,"&&");
            $stmt->where("owner_id","=",$id);
            return $stmt->build() ? $stmt->getAssoc() : false;
        }

        public function get_category($id=0){
            $ll_lang    = Config::get("general/local");
            //$sd_lang  = Bootstrap::$lang->clang;
            $stmt       = $this->db->select("c.*,cl.title,cl.route,cl.options AS optionsl")->from("categories AS c");
            $stmt->join("LEFT","categories_lang AS cl","cl.owner_id=c.id AND (cl.lang='".$ll_lang."')");
            //$stmt->where("cl.id","IS NOT NULL","","&&");
            $stmt->where("c.id","=",$id);
            return $stmt->build() ? $stmt->getAssoc() : false;
        }

        public function get_categories($type='',$searches='',$orders=[],$start=0,$end=1){

            $ll_lang    = Config::get("general/local");
            $sd_lang    = Bootstrap::$lang->clang;

            $case = "CASE ";
            $case .= "WHEN status = 'active' THEN 1 ";
            $case .= "WHEN status = 'inactive' THEN 2 ";
            $case .= "ELSE 3 ";
            $case .= "END AS rank";
            $select = implode(",",[
                't1.id',
                't1.parent',
                't1.status',
                't2.title AS name',
                't2.route',
                't3.route AS parent_route',
                't3.title AS parent_name',
                $case,
            ]);
            $sth = $this->db->select($select)->from("categories AS t1");
            $sth->join("LEFT","categories_lang AS t2","t2.owner_id=t1.id AND (t2.lang='".$ll_lang."')");
            $sth->join("LEFT","categories_lang AS t3","t3.owner_id=t1.parent AND (t3.lang='".$ll_lang."')");
            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $sth->where("(");
                    $sth->where("t1.id","=",$word,"||");
                    $sth->where("t2.title","LIKE","%".$word."%","||");
                    $sth->where("t3.title","LIKE","%".$word."%");
                    $sth->where(")","","","&&");
                }
            }

            $sth->where("t1.type","=",$type);

            if($orders) $sth->order_by(implode(",",$orders).",t1.id DESC");
            else $sth->order_by("t1.id DESC");
            $sth->limit($start,$end);
            return $sth->build() ? $sth->fetch_assoc() : false;
        }

        public function get_categories_total($type='',$searches=[]){
            $ll_lang    = Config::get("general/local");
            $sd_lang    = Bootstrap::$lang->clang;

            $sth = $this->db->select("t1.id")->from("categories AS t1");
            $sth->join("LEFT","categories_lang AS t2","t2.owner_id=t1.id AND (t2.lang='".$ll_lang."')");
            $sth->join("LEFT","categories_lang AS t3","t3.owner_id=t1.parent AND (t3.lang='".$ll_lang."')");
            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $sth->where("(");
                    $sth->where("t1.id","=",$word,"||");
                    $sth->where("t2.title","LIKE","%".$word."%","||");
                    $sth->where("t3.title","LIKE","%".$word."%");
                    $sth->where(")","","","&&");
                }
            }
            $sth->where("t1.type","=",$type);
            return $sth->build() ? $sth->rowCounter() : 0;
        }

        public function get_select_categories($type='',$parent=0,$kind='',$line=''){
            $ll_lang    = Config::get("general/local");
            //$sd_lang    = Bootstrap::$lang->clang;

            $stmt = $this->db->select("c.id,c.parent,c.options,cl.title,cl.options AS optionsl")->from("categories AS c");
            $stmt->join("LEFT","categories_lang AS cl","cl.owner_id=c.id AND (cl.lang='".$ll_lang."')");
            $stmt->where("cl.id","IS NOT NULL","","&&");
            $stmt->where("c.parent","=",$parent,"&&");
            if($kind) $stmt->where("c.kind","=",$kind,"&&");
            $stmt->where("c.type","=",$type);
            $stmt->order_by("c.rank ASC");
            $result     = $stmt->build() ? $stmt->fetch_assoc() : [];
            $new_result = [];
            if($result){
                foreach($result AS $res){
                    $new    = $res;
                    $new["title"] = $line." ".$res["title"];
                    $new["line"] = $line;
                    $new_result[] = $new;
                    $sub_result = $this->get_select_categories($type,$res["id"],$kind,$line."-");
                    if($sub_result){
                        $new_result = array_merge($new_result,$sub_result);
                    }
                }
            }
            return $new_result;
        }

        public function delete_picture($owner='',$owner_id=0,$reason=''){
            $stmt   = $this->db->delete("pictures");
            $stmt->where("owner","=",$owner,"&&");
            $stmt->where("owner_id","=",$owner_id,"&&");
            $stmt->where("reason","=",$reason);
            return $stmt->run();
        }

        public function get_picture($owner='',$owner_id=0,$reason=''){
            $stmt   = $this->db->select("name")->from("pictures");
            $stmt->where("owner","=",$owner,"&&");
            $stmt->where("owner_id","=",$owner_id,"&&");
            $stmt->where("reason","=",$reason);
            return $stmt->build() ? $stmt->getObject()->name : false;
        }

        public function delete_page($type,$pid){

            // Header Background

            $folder1    = Config::get("pictures/header-background/folder");
            $folder2    = $folder1."thumb".DS;

            $pic1       = $this->db->select("id,name")->from("pictures");
            $pic1->where("owner","=","page_".$type,"&&");
            $pic1->where("owner_id","=",$pid,"&&");
            $pic1->where("reason","=","header-background");
            $pic1       = $pic1->build() ? $pic1->getAssoc() : false;
            if($pic1){
                FileManager::file_delete($folder1.$pic1["name"]);
                FileManager::file_delete($folder2.$pic1["name"]);
                $this->db->delete("pictures")->where("id","=",$pic1["id"])->run();
            }

            // Cover Image
            $folder1    = Config::get("pictures/page-".$type."/folder");
            $folder2    = $folder1."thumb".DS;

            $pic1       = $this->db->select("id,name")->from("pictures");
            $pic1->where("owner","=","page_".$type,"&&");
            $pic1->where("owner_id","=",$pid,"&&");
            $pic1->where("reason","=","cover");
            $pic1       = $pic1->build() ? $pic1->getAssoc() : false;
            if($pic1){
                FileManager::file_delete($folder1.$pic1["name"]);
                FileManager::file_delete($folder2.$pic1["name"]);
                $this->db->delete("pictures")->where("id","=",$pic1["id"])->run();
            }

            $pic2       = $this->db->select("id,name")->from("pictures");
            $pic2->where("owner","=","page_".$type,"&&");
            $pic2->where("owner_id","=",$pid,"&&");
            $pic2->where("reason","=","mockup");
            $pic2       = $pic2->build() ? $pic2->getAssoc() : false;
            if($pic2){
                FileManager::file_delete($folder1.$pic2["name"]);
                FileManager::file_delete($folder2.$pic2["name"]);
                $this->db->delete("pictures")->where("id","=",$pic2["id"])->run();
            }

            return $this->db->delete("ps,psl","pages ps")
                ->join("INNER","pages_lang psl","psl.owner_id=ps.id")
                ->where("ps.id","=",$pid)
                ->run();
        }

        public function get_page($id=0){
            $lang = Config::get("general/local");
            return $this->db->select("t1.*,t2.title")
                ->from("pages AS t1")
                ->join("LEFT","pages_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'")
                ->where("t1.id","=",$id)
                ->build() ? $this->db->getAssoc() : false;
        }

        public function get_page_lang($id=0,$lang=''){
            return $this->db->select()
                ->from("pages_lang")
                ->where("owner_id","=",$id,"&&")
                ->where("lang","=",$lang)->build() ? $this->db->getAssoc() : false;
        }

        public function insert_picture($owner='',$owner_id=0,$reason='',$name=''){
            return $this->db->insert("pictures",[
                'owner_id' => $owner_id,
                'owner' => $owner,
                'reason' => $reason,
                'name' => $name,
            ]) ? $this->db->lastID() : false;
        }

        public function insert_page($data=[]){
            return $this->db->insert("pages",$data) ? $this->db->lastID() : false;
        }

        public function set_page($id,$data=[]){
            return $this->db->update("pages",$data)->where("id","=",$id)->save();
        }

        public function insert_page_lang($data=[]){
            return $this->db->insert("pages_lang",$data) ? $this->db->lastID() : false;
        }

        public function set_page_lang($id,$data=[]){
            return $this->db->update("pages_lang",$data)->where("id","=",$id)->save();
        }

        public function category_route_check($route='',$lang='',$type=''){
            $sth = $this->db->select("t1.id")->from("categories AS t1");
            $sth->join("LEFT","categories_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $sth->where("t2.id","IS NOT NULL","","&&");
            $sth->where("t1.type","=",$type,"&&");
            $sth->where("t2.route","=",$route);
            return $sth->build() ? $sth->getObject()->id : false;
        }

        public function page_route_check($route='',$lang=''){
            $sth = $this->db->select("t1.id")->from("pages AS t1");
            $sth->join("LEFT","pages_lang AS t2","t2.owner_id=t1.id AND t2.lang='".$lang."'");
            $sth->where("t2.id","IS NOT NULL","","&&");
            $sth->where("t2.route","=",$route);
            return $sth->build() ? $sth->getObject()->id : false;
        }

        public function get_pages($type='',$searches='',$orders=[],$start=0,$end=1){
            $ll_lang    = Config::get("general/local");
            $sd_lang    = Bootstrap::$lang->clang;

            $case = "CASE ";
            $case .= "WHEN status = 'active' THEN 1 ";
            $case .= "WHEN status = 'inactive' THEN 2 ";
            $case .= "ELSE 3 ";
            $case .= "END AS rank";
            $select = implode(",",[
                't1.id',
                't1.status',
                't2.title',
                't2.route',
                't1.ctime',
                't1.category AS category_id',
                't3.title AS category',
                't3.route AS category_route',
                $case,
            ]);
            $sth = $this->db->select($select)->from("pages AS t1");
            $sth->join("LEFT","pages_lang AS t2","t2.owner_id=t1.id AND (t2.lang='".$ll_lang."')");
            $sth->join("LEFT","categories_lang AS t3","t3.owner_id=t1.category AND (t3.lang='".$ll_lang."')");

            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $sth->where("(");
                    $sth->where("t1.id","=",$word,"||");
                    $sth->where("t2.title","LIKE","%".$word."%","||");
                    $sth->where("t3.title","LIKE","%".$word."%");
                    $sth->where(")","","","&&");
                }
            }
            $sth->where("t1.type","=",$type);
            $sth->order_by("rank ASC,t1.id DESC");
            $sth->limit($start,$end);
            return $sth->build() ? $sth->fetch_assoc() : false;
        }

        public function get_pages_total($type='',$searches=[]){
            $ll_lang    = Config::get("general/local");
            $sd_lang    = Bootstrap::$lang->clang;

            $select     = "t1.id";
            $sth = $this->db->select($select)->from("pages AS t1");
            $sth->join("LEFT","pages_lang AS t2","t2.owner_id=t1.id AND (t2.lang='".$ll_lang."')");
            $sth->join("LEFT","categories_lang AS t3","t3.owner_id=t1.category AND (t3.lang='".$ll_lang."')");

            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $sth->where("(");
                    $sth->where("t1.id","=",$word,"||");
                    $sth->where("t2.title","LIKE","%".$word."%","||");
                    $sth->where("t3.title","LIKE","%".$word."%");
                    $sth->where(")","","","&&");
                }
            }
            $sth->where("t1.type","=",$type);
            return $sth->build() ? $sth->rowCounter() : 0;
        }

        public function get_slides($searches='',$orders=[],$start=0,$end=1){
            $ll_lang    = Config::get("general/local");
            $sd_lang    = Bootstrap::$lang->clang;

            $case = "CASE ";
            $case .= "WHEN status = 'active' THEN 1 ";
            $case .= "WHEN status = 'inactive' THEN 2 ";
            $case .= "ELSE 3 ";
            $case .= "END AS rank";
            $select = implode(",",[
                't1.id',
                't1.status',
                't1.ctime',
                't2.title',
                't2.description',
                't2.link',
                $case,
            ]);
            $sth = $this->db->select($select)->from("slides AS t1");
            $sth->join("LEFT","slides_lang AS t2","t2.owner_id=t1.id AND (t2.lang='".$ll_lang."')");

            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $sth->where("(");
                    $sth->where("t1.id","=",$word,"||");
                    $sth->where("t2.title","LIKE","%".$word."%","||");
                    $sth->where("t2.description","LIKE","%".$word."%","||");
                    $sth->where("t2.link","LIKE","%".$word."%");
                    $sth->where(")");
                }
            }
            $sth->order_by("rank ASC,t1.id DESC");
            $sth->limit($start,$end);
            return $sth->build() ? $sth->fetch_assoc() : false;
        }

        public function get_slides_total($searches=''){
            $ll_lang    = Config::get("general/local");
            $sd_lang    = Bootstrap::$lang->clang;

            $select     = "t1.id";
            $sth = $this->db->select($select)->from("slides AS t1");
            $sth->join("LEFT","slides_lang AS t2","t2.owner_id=t1.id AND (t2.lang='".$ll_lang."')");

            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $sth->where("(");
                    $sth->where("t1.id","=",$word,"||");
                    $sth->where("t2.title","LIKE","%".$word."%","||");
                    $sth->where("t2.description","LIKE","%".$word."%","||");
                    $sth->where("t2.link","LIKE","%".$word."%");
                    $sth->where(")");
                }
            }
            return $sth->build() ? $sth->rowCounter() : 0;
        }

        public function get_cfeedbacks($searches='',$orders=[],$start=0,$end=1){
            $case = "CASE ";
            $case .= "WHEN t1.status = 'pending' THEN 0 ";
            $case .= "WHEN t1.status = 'approved' THEN 1 ";
            $case .= "ELSE 2 ";
            $case .= "END AS rank";
            $select = "t1.*,".$case;
            $sth = $this->db->select($select)->from("customer_feedbacks AS t1");
            if($searches){
                if(isset($searches["word"])){
                    $sth->join("LEFT","customer_feedbacks_lang AS t2","t2.owner_id=t1.id");
                    $word       = $searches["word"];
                    $sth->where("(");
                    $sth->where("t1.full_name","LIKE","%".$word."%","||");
                    $sth->where("t1.company_name","LIKE","%".$word."%","||");
                    $sth->where("t1.email","LIKE","%".$word."%","||");
                    $sth->where("t1.ip","LIKE","%".$word."%","||");
                    $sth->where("t2.message","LIKE","%".$word."%");
                    $sth->where(")");
                }
            }
            $sth->order_by("rank ASC,t1.id DESC");
            $sth->limit($start,$end);
            $data = $sth->build() ? $sth->fetch_assoc() : false;
            if($data) foreach($data AS $row) if(!$row["unread"]) $this->set_cfeedback($row["id"],['unread' => 1]);
            return $data;
        }

        public function get_cfeedbacks_total($searches=''){
            $select = "t1.id";
            $sth = $this->db->select($select)->from("customer_feedbacks AS t1");
            if($searches){
                if(isset($searches["word"])){
                    $sth->join("LEFT","customer_feedbacks_lang AS t2","t2.owner_id=t1.id");
                    $word       = $searches["word"];
                    $sth->where("(");
                    $sth->where("t1.full_name","LIKE","%".$word."%","||");
                    $sth->where("t1.company_name","LIKE","%".$word."%","||");
                    $sth->where("t1.email","LIKE","%".$word."%","||");
                    $sth->where("t1.ip","LIKE","%".$word."%","||");
                    $sth->where("t2.message","LIKE","%".$word."%");
                    $sth->where(")");
                }
            }
            return $sth->build() ? $sth->rowCounter() : 0;
        }

        public function get_messages($searches='',$orders=[],$start=0,$end=1){
            $case = "CASE ";
            $case .= "WHEN unread = '0' THEN 0 ";
            $case .= "ELSE 1 ";
            $case .= "END AS rank";
            $select = "*,".$case;
            $sth = $this->db->select($select)->from("contact_messages");
            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $sth->where("ip","LIKE","%".$word."%","||");
                    $sth->where("full_name","LIKE","%".$word."%","||");
                    $sth->where("email","LIKE","%".$word."%","||");
                    $sth->where("phone","LIKE","%".$word."%","||");
                    $sth->where("message","LIKE","%".$word."%");
                }
            }
            $sth->order_by("rank ASC,id DESC");
            $sth->limit($start,$end);
            return $sth->build() ? $sth->fetch_assoc() : false;
        }

        public function get_messages_total($searches=''){
            $select = "COUNT(id) AS count";
            $sth = $this->db->select($select)->from("contact_messages");
            if($searches){
                if(isset($searches["word"])){
                    $word       = $searches["word"];
                    $sth->where("ip","LIKE","%".$word."%","||");
                    $sth->where("full_name","LIKE","%".$word."%","||");
                    $sth->where("email","LIKE","%".$word."%","||");
                    $sth->where("phone","LIKE","%".$word."%","||");
                    $sth->where("message","LIKE","%".$word."%");
                }
            }
            return $sth->build() ? $sth->getObject()->count : 0;
        }

    }