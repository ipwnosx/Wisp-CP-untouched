<?php  
    defined('CORE_FOLDER') OR exit('You can not get in here!');
    $wide_content = true;

    $currency_symbols = [];
    foreach(Money::getCurrencies() AS $currency){
        $symbol = $currency["prefix"] != '' ? trim($currency["prefix"]) : trim($currency["suffix"]);
        if(!$symbol) $symbol = $currency["code"];
        $currency_symbols[] = $symbol;
    }

?>
<div class="wclientblockscon">
    <div id="clientAreaIndex-wrapper">

        <?php
            $menu_links = [
                'buy-domain'  => Controllers::$init->CRLink("domain"),
                'buy-hosting' => Controllers::$init->CRLink("products",["hosting"]),
                'buy-server'  => Controllers::$init->CRLink("products",["server"]),
                'buy-software' => Controllers::$init->CRLink("softwares"),
                'buy-sms'      => Controllers::$init->CRLink("products",["sms"]),
                'buy-sms-intl' => Controllers::$init->CRLink("international-sms"),
            ];

            if(Config::get("options/pg-activation/domain")){

                if(isset($first_tld_price)){
                    $first_tld_price_amount = $first_tld_price["register"]["amount"];
                    if($first_tld_price["promo_status"] && (substr($first_tld_price["promo_duedate"],0,4) == '1881' || DateManager::strtotime($first_tld_price["promo_duedate"]." 23:59:59") > DateManager::strtotime()) && $first_tld_price["promo_register_price"]>0){
                        $first_tld_price_amount = $first_tld_price["promo_register_price"];
                    }
    
                    $first_price = Money::formatter_symbol($first_tld_price_amount,$first_tld_price["register"]["cid"],!$domain_override_uscurrency);
    
                    if($first_price){
                        $first_price_symbol_position    = '';
                        $split_amount                   = explode(" ",$first_price);
                        $first_price_symbol             = '';
                        if(in_array(current($split_amount),$currency_symbols)){
                            $first_price_symbol_position = "left";
                            $first_price_symbol  = current($split_amount);
                            array_shift($split_amount);
                            $first_price                = implode(" ",$split_amount);
                        }elseif(in_array(end($split_amount),$currency_symbols)){
                            $first_price_symbol_position = "right";
                            $first_price_symbol  = end($split_amount);
                            array_pop($split_amount);
                            $first_price         = implode(" ",$split_amount);
                        }
                        $first_price            = '<div class="amount_spot_view"><i class="currpos'.$first_price_symbol_position.'">'.$first_price_symbol.'</i> '.$first_price.'</div>';
                    }
    
                }
                else
                    $first_price = 0;
                    
                ?>

<div class="homedomainarea-con" data-aos="zoom-out">
    <div class="homedomainarea">
        <div class="padding30">
            <div align="center">
                <h1><strong><?php echo __("website/index/domain-check-slogan"); ?></strong></h1>
                <form action="<?php echo $domain_check_post; ?>" method="get" id="DomainCheck">
                    <input name="domain" type="text" placeholder="<?php echo __("website/index/domain-check-input-placeholder"); ?>">
                    <input type="submit" value="<?php echo __("website/index/domain-check-query-button"); ?>">
                </form>
                <div class="clear"></div>

                <div class="popuzantilar">
                    <?php
                        if(isset($tldList) && is_array($tldList)){
                            foreach($tldList AS $row){

                                $is_img = false;
                                $is_svg = "images".DS."tldlogos".DS.$row["name"].".svg";
                                $is_png = "images".DS."tldlogos".DS.$row["name"].".png";
                                $is_jpg = "images".DS."tldlogos".DS.$row["name"].".jpg";
                                if(file_exists(View::$init->get_template_dir().$is_svg)) $is_img = $is_svg;
                                elseif(file_exists(View::$init->get_template_dir().$is_png)) $is_img = $is_png;
                                elseif(file_exists(View::$init->get_template_dir().$is_jpg)) $is_img = $is_jpg;

                                if($row["promo_status"] && (substr($row["promo_duedate"],0,4) == '1881' || DateManager::strtotime($row["promo_duedate"]." 23:59:59") > DateManager::strtotime()) && $row["promo_register_price"]>0){

                                    $amount1     = Money::formatter_symbol($row["reg_price"]["amount"],$row["reg_price"]["cid"],!$domain_override_uscurrency);
                                    $amount1_symbol_position = '';
                                    $split_amount   = explode(" ",$amount1);
                                    $amount1_symbol  = '';
                                    if(in_array(current($split_amount),$currency_symbols)){
                                        $amount1_symbol_position = "left";
                                        $amount1_symbol  = current($split_amount);
                                        array_shift($split_amount);
                                        $amount1         = implode(" ",$split_amount);
                                    }elseif(in_array(end($split_amount),$currency_symbols)){
                                        $amount1_symbol_position = "right";
                                        $amount1_symbol  = end($split_amount);
                                        array_pop($split_amount);
                                        $amount1         = implode(" ",$split_amount);
                                    }

                                    $amount2     = Money::formatter_symbol($row["promo_register_price"],$row["currency"],!$domain_override_uscurrency);
                                    $amount2_symbol_position = '';
                                    $split_amount   = explode(" ",$amount2);
                                    $amount2_symbol  = '';
                                    if(in_array(current($split_amount),$currency_symbols)){
                                        $amount2_symbol_position = "left";
                                        $amount2_symbol  = current($split_amount);
                                        array_shift($split_amount);
                                        $amount2         = implode(" ",$split_amount);
                                    }elseif(in_array(end($split_amount),$currency_symbols)){
                                        $amount2_symbol_position = "right";
                                        $amount2_symbol  = end($split_amount);
                                        array_pop($split_amount);
                                        $amount2         = implode(" ",$split_amount);
                                    }

                                    ?>
                                    <div class="uzantibox spotlight-tlds" data-name="<?php echo $row["name"]; ?>" style="position: relative;   ">

                                        <div  style="color:white;position: absolute; font-size: 14px;width: 100%;margin-top: -20px;"><span class="domdiscount" ><?php echo __("website/domain/promo"); ?></span>
                                        </div>

                                        <div style="padding:10px">
                                            <h4>
                                                <?php if($is_img): ?>
                                                    <img src="<?php echo Utility::image_link_determiner($tadress.$is_img); ?>" alt=".<?php echo $row["name"]; ?>">
                                                <?php else: ?>
                                                    .<?php echo $row["name"]; ?>
                                                <?php endif; ?>
                                            </h4>
                                            <h5>
                                                <!--div class="amount_spot_view doldprice"><i class="currpos<?php echo $amount1_symbol_position; ?>"><?php echo $amount1_symbol; ?></i> <?php echo $amount1; ?></div-->

                                            </h5>
                                        </div>
                                        <div class="dnewprice">
                                            <span class="ddiscountnewprice"><div class="amount_spot_view"><i class="currpos<?php echo $amount2_symbol_position; ?>"><?php echo $amount2_symbol; ?></i> <?php echo $amount2; ?></div></span>
                                        </div>
                                    </div>
                                    <?php
                                }else{

                                    $amount1     = Money::formatter_symbol($row["reg_price"]["amount"],$row["reg_price"]["cid"],!$domain_override_uscurrency);
                                    $amount1_symbol_position = '';
                                    $split_amount   = explode(" ",$amount1);
                                    $amount1_symbol  = '';
                                    if(in_array(current($split_amount),$currency_symbols)){
                                        $amount1_symbol_position = "left";
                                        $amount1_symbol  = current($split_amount);
                                        array_shift($split_amount);
                                        $amount1         = implode(" ",$split_amount);
                                    }elseif(in_array(end($split_amount),$currency_symbols)){
                                        $amount1_symbol_position = "right";
                                        $amount1_symbol  = end($split_amount);
                                        array_pop($split_amount);
                                        $amount1         = implode(" ",$split_amount);
                                    }

                                    ?>
                                    <div class="uzantibox spotlight-tlds" data-name="<?php echo $row["name"]; ?>">
                                        <div style="padding:10px">
                                            <h4>
                                                <?php if($is_img): ?>
                                                    <img src="<?php echo Utility::image_link_determiner($tadress.$is_img); ?>" alt=".<?php echo $row["name"]; ?>">
                                                <?php else: ?>
                                                    .<?php echo $row["name"]; ?>
                                                <?php endif; ?>
                                            </h4>
                                            <h5><div class="amount_spot_view"><i class="currpos<?php echo $amount1_symbol_position; ?>"><?php echo $amount1_symbol; ?></i> <?php echo $amount1; ?></div></h5>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                        }
                    ?>
                </div>


                <h4><?php echo __("website/index/domain-check-predicted-price",['{price}' => $first_price]); ?></h4>
            </div>
        </div>
    </div>
</div>


                <div class="product-group-item" data-aos="fade-up">
                    <a href="<?php echo $menu_links["buy-domain"]; ?>">
                    <span>
                        <?php
                            if(Config::get("options/category-icon/domain"))
                                echo '<i class="'.Config::get("options/category-icon/domain").'" aria-hidden="true"></i>';
                            elseif(isset($category_icon_domain) && $category_icon_domain)
                                echo '<img src="'.$category_icon_domain.'" class="product-group-icon">';
                            else
                                echo '<i class="fa fa-globe" aria-hidden="true"></i>';
                        ?>
                         <?php echo __("website/account/text17"); ?></span>
                    <p class="product-group-item-desc">
                        <?php echo __("website/index/domain-check-slogan"); ?>
                    </p>
                    </a>
                </div>
                <?php
            }

            if(Config::get("options/pg-activation/hosting")){
                ?>
               <div class="product-group-item" data-aos="fade-up">
                    <a href="<?php echo $menu_links["buy-hosting"]; ?>">
                        <span>
                            <?php
                                if(Config::get("options/category-icon/hosting"))
                                    echo '<i class="'.Config::get("options/category-icon/hosting").'" aria-hidden="true"></i>';
                                elseif(isset($category_icon_hosting) && $category_icon_hosting)
                                    echo '<img src="'.$category_icon_hosting.'" class="product-group-icon">';
                                else
                                    echo '<i class="fa fa-cloud" aria-hidden="true"></i>';
                            ?>
                            <?php echo __("website/account/text18"); ?></span>
                        <p class="product-group-item-desc">
                        <?php echo ___("constants/category-hosting/sub_title"); ?>
                        </p>
                    </a>
                </div>
                <?php
            }

            if(Config::get("options/pg-activation/server")){
                ?>
               <div class="product-group-item" data-aos="fade-up">
                    <a href="<?php echo $menu_links["buy-server"]; ?>">
                        <span>
                            <?php
                                if(Config::get("options/category-icon/server"))
                                    echo '<i class="'.Config::get("options/category-icon/server").'" aria-hidden="true"></i>';
                                elseif(isset($category_icon_server) && $category_icon_server)
                                    echo '<img src="'.$category_icon_server.'" class="product-group-icon">';
                                else
                                    echo '<i class="fa fa-server" aria-hidden="true"></i>';
                            ?>
                             <?php echo __("website/account/text19"); ?></span>
                        <p class="product-group-item-desc">
                        <?php echo ___("constants/category-server/sub_title"); ?>
                        </p>
                    </a>
                </div>
                <?php
            }

            if(Config::get("options/pg-activation/software")){
                ?>
                <div class="product-group-item" data-aos="fade-up">
                    <a href="<?php echo $menu_links["buy-software"]; ?>">
                        <span>
                            <?php
                                if(Config::get("options/category-icon/software"))
                                    echo '<i class="'.Config::get("options/category-icon/software").'" aria-hidden="true"></i>';
                                elseif(isset($category_icon_software) && $category_icon_software)
                                    echo '<img src="'.$category_icon_software.'" class="product-group-icon">';
                                else
                                    echo '<i class="fa fa-code" aria-hidden="true"></i>';
                            ?>
                             <?php echo __("website/account/text20"); ?></span>
                        <p class="product-group-item-desc">
                        <?php echo ___("constants/category-software/sub_title"); ?>
                        </p>
                    </a>
                </div>
                <?php
            }

            if(Config::get("options/pg-activation/international-sms")){
                ?>
                <div class="product-group-item" data-aos="fade-up">
                    <a href="<?php echo $menu_links["buy-sms-intl"]; ?>">
                        <span>
                            <?php
                                if(Config::get("options/category-icon/intl-sms"))
                                    echo '<i class="'.Config::get("options/category-icon/intl-sms").'" aria-hidden="true"></i>';
                                elseif(isset($category_icon_intl_sms) && $category_icon_intl_sms)
                                    echo '<img src="'.$category_icon_intl_sms.'" class="product-group-icon">';
                                else
                                    echo '<i class="fa fa-envelope" aria-hidden="true"></i>';
                            ?>
                             <?php echo __("website/account_sms/introduction-header-title"); ?></span>
                        <p class="product-group-item-desc">
                        <?php echo __("website/account_sms/introduction-header-description"); ?>
                        </p>
                    </a>
                </div>
                <?php
            }

            if(Config::get("options/pg-activation/sms") && ___("package/code") == "tr"){
                ?>
                <div class="product-group-item" data-aos="fade-up">
                    <a href="<?php echo $menu_links["buy-sms"]; ?>">
                        <span>
                            <?php
                                if(Config::get("options/category-icon/sms"))
                                    echo '<i class="'.Config::get("options/category-icon/sms").'" aria-hidden="true"></i>';
                                elseif(isset($category_icon_sms) && $category_icon_sms)
                                    echo '<img src="'.$category_icon_sms.'" class="product-group-icon">';
                                else
                                    echo '<i class="fa fa-envelope" aria-hidden="true"></i>';
                            ?>
                             <?php echo __("website/account/text21"); ?></span>
                        <p class="product-group-item-desc">
                        <?php echo ___("constants/category-sms/sub_title"); ?>
                        </p>
                    </a>
                </div>
                <?php
            }

            $g_icon = $functions["get_category_icon"];
            if($s_groups = Products::special_groups()){
                foreach($s_groups AS $group){
                    $group["options"] = Utility::jdecode($group["options"],true);

                    ?>
                    <div class="product-group-item" data-aos="fade-up">
                        <a href="<?php echo Controllers::$init->CRLink("products",[$group["route"]]); ?>">
                            <span>
                                <?php
                                    if(isset($group["options"]["icon"]) && $group["options"]["icon"])
                                        echo '<i class="'.$group["options"]["icon"].'" aria-hidden="true"></i>';
                                    elseif($icon_img = $g_icon($group["id"]))
                                        echo '<img src="'.$icon_img.'" class="product-group-icon">';
                                    else
                                        echo '<i class="fa fa-cube	
" aria-hidden="true"></i>';
                                ?>
                                 <?php echo $group["title"]; ?></span>
                            <p class="product-group-item-desc">
                            <?php echo $group["sub_title"]; ?>
                            </p>
                        </a>
                    </div>
                    <?php
                }
            }


            if(isset($blocks["news-articles"]) && $blocks["news-articles"]["status"] == 1 && $blocks["news-articles"]["news"] == 1)
            {
                ?>
                <div class="clean-theme-home-news" data-aos="fade-up">
                    <div id="wrapper">

                        <div class="mpaneltitle">
                            <h4><strong><i class="fa fa-bullhorn" aria-hidden="true"></i> <?php echo __("website/account/dashboard-news-title"); ?></strong></h4>
                        </div>

                        <?php
                            $news = !isset($news) || !is_array($news) ? [] : $news;
                            foreach($news AS $new)
                            {
                                $image_link = $new["image"];
                                $link = $new["route"];
                                $date = $new["date"];
                                $title = $new["title"];
                                $short_title = Utility::short_text($new["title"],0,60,true);
                                $short_content = Filter::html_clear($new["content"]);
                                $short_content = Utility::short_text($short_content,0,230,true);
                                ?>
                                <div class="mpanelhaber">
                                    <a href="<?php echo $link;?>"><h5><?php echo $short_title; ?></h5></a>
                                    <span><?php echo $short_content; ?> <a style="font-weight:600;" href="<?php echo $link;?>"><?php echo __("theme/more"); ?></a> (<?php echo $date;?>)</span>
                                </div>
                                <?php
                            }
                        ?>
                    </div>
                </div>
                <?php
            }

        ?>

    </div>

</div>