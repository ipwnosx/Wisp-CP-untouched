<?php
    defined('CORE_FOLDER') OR exit('You can not get in here!');
    class Controller extends Controllers
    {
        protected $params,$data=[];

        public function __construct($arg=[])
        {
            parent::__construct();
            $this->params       = $arg['params'];
        }

        public function main(){

            $hide_pages  = Config::get("theme/only-panel");


            header("Content-Type:text/xml; Charset=utf8");

            $output =  '<?xml version="1.0" encoding="UTF-8"?>'.EOL;
            $output .= '<urlset '.EOL;
            $output .= 'xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" '.EOL;
            $output .= 'xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" '.EOL;
            $output .= 'xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">'.EOL;
            $lang       = Bootstrap::$lang->clang;

            $links = [];

            $categories = $this->model->categories($lang);
            if($categories){
                foreach($categories AS $row){
                    $link = NULL;

                    if($row["type"] == "products" && $row["kind"] == "hosting" && !Config::get("options/pg-activation/hosting"))
                        continue;
                    elseif($row["type"] == "products" && $row["kind"] == "server" && !Config::get("options/pg-activation/server"))
                        continue;
                    elseif($row["type"] == "products" && $row["kind"] == "sms" && !Config::get("options/pg-activation/sms"))
                        continue;

                    elseif($row["type"] == "articles" && !$hide_pages)
                        $link = Controllers::$init->CRLink("articles_category",[$row["route"]]);
                    elseif($row["type"] == "knowledgebase" && Config::get("options/kbase-system"))
                        $link = Controllers::$init->CRLink("kbase_category",[$row["route"]]);
                    elseif($row["type"] == "products")
                        $link = Controllers::$init->CRLink("products",[$row["route"]]);
                    elseif($row["type"] == "software")
                        $link = Controllers::$init->CRLink("softwares_cat",[$row["route"]]);
                    elseif($row["type"] == "references" && !$hide_pages)
                        $link = Controllers::$init->CRLink("references_category",[$row["route"]]);

                    if($link) $links[] = $link;
                }
            }

            $pages  = $this->model->pages($lang);
            if($pages){
                foreach($pages AS $row){
                    if($hide_pages && in_array($row["type"],['news','articles','references'])) continue;
                    $links[] = Controllers::$init->CRLink($row["type"]."_detail",[$row["route"]]);
                }
            }

            if(Config::get("options/kbase-system")){
                $pages  = $this->model->kbase($lang);
                if($pages){
                    foreach($pages AS $row){
                        $links[] = Controllers::$init->CRLink("kbase_detail",[$row["route"]]);
                    }
                }
            }

            $hide_normal_page = Config::get("theme/only-panel") ? true : false;

            if(!$hide_normal_page) $links[]   = $this->CRLink("news");
            if(!$hide_normal_page) $links[]   = $this->CRLink("articles");
            if(!$hide_normal_page) $links[]   = $this->CRLink("references");

            $links[]   = $this->CRLink("contact");

            if(Config::get("options/kbase-system"))
                $links[]   = $this->CRLink("kbase");

            if(Config::get("options/pg-activation/software"))
                $links[]   = $this->CRLink("softwares");

            if(Config::get("options/pg-activation/domain"))
                $links[]   = $this->CRLink("domain");

            if(Config::get("options/sign/up/status"))
                $links[]   = $this->CRLink("sign-up");

            if(Config::get("options/sign/in/status"))
                $links[]   = $this->CRLink("sign-in");

            if(Config::get("options/pg-activation/international-sms"))
                $links[]   = $this->CRLink("international-sms");

            if($links){
                foreach($links AS $link){
                    $output .= "<url>";
                    $output .= "<loc>".$link."</loc>";
                    $output .= "<changefreq>always</changefreq>";
                    $output .= "</url>";
                }
            }


            $output .= '</urlset>';

            echo $output;
        }
    }