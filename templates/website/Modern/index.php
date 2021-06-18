<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    $hoptions = [
        'counterup',
        'aos',
        'dataTables',
        'page' => "index",
    ];

    $currency_symbols = [];
    foreach(Money::getCurrencies() AS $currency){
        $symbol = $currency["prefix"] != '' ? trim($currency["prefix"]) : trim($currency["suffix"]);
        if(!$symbol) $symbol = $currency["code"];
        $currency_symbols[] = $symbol;
    }


    (!is_array($blocks)) ? $blocks = [] : false;
    $get_pcategory  = $functions["get_product_category"];
    $get_products   = $functions["get_products"];
    $get_picture    = $functions["get_picture"];
    $folder         = Config::get("pictures/blocks/folder");

    foreach ($blocks AS $name=>$item){
        $background_picture = false;
        $background_video   = false;
        if(isset($item["pic_id"])) $background_picture = $get_picture("block",$item["pic_id"]);
        if(isset($item["video"]) && $item["video"]) $background_video    = Utility::link_determiner($folder.$item["video"],false,false);

        if($name == "home-domain-check" && $item["status"]==1 && $pg_activation["domain"]){
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
            <div class="homedomainarea-con" data-aos="fade-up">
                <div class="homedomainarea">
                    <div class="padding30">
                        <div align="center">
                            <h1><strong><?php echo __("website/index/domain-check-slogan"); ?></strong></h1>
                            <form action="<?php echo $domain_check_post; ?>" method="get" id="DomainCheck">
                                <input name="domain" type="text" placeholder="<?php echo __("website/index/domain-check-input-placeholder"); ?>">
                                <input type="submit" value="<?php echo __("website/index/domain-check-query-button"); ?>">
                            </form>
                            <div class="clear"></div>

                            <?php
                                if(isset($tldList) && is_array($tldList) && sizeof($tldList)>0){
                                    for($i=0; $i<=7; $i++){
                                        if(isset($tldList[$i])){
                                            $list = $tldList[$i];
                                            $amount = $list["reg_price"]["amount"];

                                            if($list["promo_status"] && (substr($list["promo_duedate"],0,4) == '1881' || DateManager::strtotime($list["promo_duedate"]." 23:59:59") > DateManager::strtotime()) && $list["promo_register_price"]>0){
                                                $amount = $list["promo_register_price"];
                                            }

                                            $amount     = Money::formatter_symbol($amount,$list["reg_price"]["cid"],!$domain_override_uscurrency);
                                            $amount_symbol_position = '';
                                            $split_amount   = explode(" ",$amount);
                                            $amount_symbol  = '';
                                            if(in_array(current($split_amount),$currency_symbols)){
                                                $amount_symbol_position = "left";
                                                $amount_symbol  = current($split_amount);
                                                array_shift($split_amount);
                                                $amount         = implode(" ",$split_amount);
                                            }elseif(in_array(end($split_amount),$currency_symbols)){
                                                $amount_symbol_position = "right";
                                                $amount_symbol  = end($split_amount);
                                                array_pop($split_amount);
                                                $amount         = implode(" ",$split_amount);
                                            }

                                            $is_img = false;
                                            $is_svg = "images".DS."tldlogos".DS.$list["name"].".svg";
                                            $is_png = "images".DS."tldlogos".DS.$list["name"].".png";
                                            $is_jpg = "images".DS."tldlogos".DS.$list["name"].".jpg";
                                            if(file_exists(View::$init->get_template_dir().$is_svg)) $is_img = $is_svg;
                                            elseif(file_exists(View::$init->get_template_dir().$is_png)) $is_img = $is_png;
                                            elseif(file_exists(View::$init->get_template_dir().$is_jpg)) $is_img = $is_jpg;
                                            ?>
                                            <div class="spottlds">
                                                <?php if($is_img): ?>
                                                    <img src="<?php echo Utility::image_link_determiner($tadress.$is_img); ?>" alt=".<?php echo $list["name"]; ?>">
                                                <?php else: ?>
                                                    .<?php echo $list["name"]; ?>
                                                <?php endif; ?>
                                                <h5><div class="amount_spot_view"><i class="currpos<?php echo $amount_symbol_position; ?>"><?php echo $amount_symbol; ?></i> <?php echo $amount; ?></div></h5>
                                            </div>
                                            <?php
                                        }
                                    }
                                }
                            ?>

                            <h4><?php echo __("website/index/domain-check-predicted-price",['{price}' => $first_price]); ?></h4>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }

        if($name == "about-us" && $item["status"]==1){
            ?>
            <div class="anatanitim"<?php echo $background_video ? '' : 'style="background-image: url('.$background_picture.');"'; ?>>
                <?php
                    if($background_video){
                        ?>
                        <video autoplay="" loop="" muted="" poster="<?php echo $background_picture; ?>">
                            <source src="<?php echo $background_video; ?>" type="video/mp4">
                        </video>
                        <?php
                    }
                ?>
                <div id="wrapper">
                    <div class="tanslogan aos-init aos-animate" data-aos="fade-right">
                        <h2><strong><?php echo $item["title"];?></strong></h2>
                        <p><?php echo nl2br($item["description"]);?></p>
                    </div><div class="clearmob"></div>
                    <?php
                        $istarget = ($item["button_target"] != '') ?  ' target="'.$item["button_target"].'"' : '';
                        echo ($item["button_name"] != '') ? '<a href="'.Utility::link_determiner($item["button_link"]).'" class="gonderbtn aos-init"'.$istarget.' data-aos="fade-left">'.$item["button_name"].'</a>' : '';
                    ?>
                </div>
            </div>
            <div class="clear"></div>
            <?php
        }

        if(isset($item["owner"]) && ($item["owner"] == "product-group" || ($item["owner"] == "hosting" && $pg_activation["hosting"]) || ($item["owner"] == "server" && $pg_activation["server"]) || ($item["owner"] == "sms" && $pg_activation["sms"])) && $item["status"]==1){

            $list_limit     = isset($item["listing_limit"]) && $item["listing_limit"] ? $item["listing_limit"] : 3;

            if($item["owner"] == "hosting" || $item["owner"] == "server" || $item["owner"] == "sms")
                $group      = [
                    'id' => $item["owner"],
                    'title' => NULL,
                    'sub_title' => NULL,
                    'options' => ___("constants/category-".$item["owner"]."/options"),
                    'background_image' => $background_picture ? $background_picture : NULL,
                ];
            else
                $group          = $get_pcategory($item["id"]);

            if($group){
                $goptions   = $group["options"];
                $citems     = isset($item["items"]) ? $item["items"] : [];
                $categories = [];
                foreach($citems AS $citem){
                    $ccategory = $get_pcategory($citem);
                    if($ccategory) $categories[] = $ccategory;
                }
                $cat_size   = sizeof($categories);

                if($item["owner"] == "server" || $item["owner"] == "sms" || $item["owner"] == "product-group" || $item["owner"] == "hosting"){
                    $group_title        = isset($item["title"]) ? $item["title"] : $group["title"];
                    $group_link         = '';

                    if($item["owner"] == "product-group"){
                        $get_group = Products::getCategory($group["id"]);
                        $group_link = Controllers::$init->CRLink("products",[$get_group["route"]]);
                    }else{
                        $group_link = Controllers::$init->CRLink("products",[$group["id"]]);
                    }


                    ?>
                    <div id="group_<?php echo $group["id"]; ?>">
                        <div class="tablopaketler products_list">
                            <div id="wrapper">

                                <div class="pakettitle" data-aos="fade-up">
                                    <h1><strong><?php echo isset($item["title"]) ? $item["title"] : $group["title"]; ?></strong></h1>
                                    <h2><?php echo isset($item["description"]) ? $item["description"] : $group["sub_title"]; ?></h2>
                                </div>

                                <?php if($categories): ?>
                                    <div style="text-align:center;margin-bottom:40px;<?php echo $cat_size==1 ? ' display:none;' : NULL; ?>" class="miotab-labels" data-aos="fade-up">
                                        <?php
                                            $products   = [];
                                            $cats       = [];
                                            foreach($categories AS $category){
                                                $gproducts  = $get_products($category["id"],$list_limit);
                                                if($gproducts) $products[$category["id"]] = $gproducts;
                                                $cats[$category["id"]] = $category;
                                                // $background_picture  || $category["background_image"]
                                                ?>
                                                <a href="javascript:void(0);" class="gonderbtn"
                                                   data-target="cat<?php echo $category["id"]; ?>"
                                                ><?php echo $category["title"]; ?></a>
                                                <?php
                                            }
                                        ?>
                                    </div>
                                    <?php
                                else:
                                    $products   = [];
                                    $gproducts  = $get_products($group["id"],$list_limit);
                                    if($gproducts) $products[$group["id"]] = $gproducts;
                                endif;
                                ?>

                                <div class="clear"></div>

                                <?php if(isset($products) && $products): ?>
                                    <div class="miotab-contents">
                                        <?php
                                            foreach($products AS $key=>$xproducts){
                                                if(isset($cats[$key]["optionsl"]["columns"]))
                                                    $columns = $cats[$key]["optionsl"]["columns"];
                                                else
                                                    $columns = [];

                                                $list_template  = isset($cats[$key]["options"]["list_template"]) ? $cats[$key]["options"]["list_template"] : 1;

                                                ?>
                                                <div class="miotab-content" id="cat<?php echo $key; ?>">
                                                    <?php
                                                        if($item["owner"] == "server" && $list_template == 2){

                                                            static $include_DataTables = false;

                                                            if(!$include_DataTables){
                                                                $include_DataTables = true;
                                                                ?>
                                                            <script type="text/javascript">
                                                                $(document).ready(function() {
                                                                    $('.horizontal-list').DataTable({
                                                                        paging:false,
                                                                        lengthChange: false,
                                                                        responsive: true,
                                                                        info: false,
                                                                        searching: false,
                                                                        oLanguage:<?php include __DIR__.DS."datatable-lang.php"; ?>
                                                                    });
                                                                });
                                                            </script>
                                                                <?php
                                                            }
                                                            ?>
                                                            <table class="horizontal-list" width="100%" border="0" data-order='[[6, "asc"]]'>
                                                                <thead style="background:#ebebeb;">
                                                                <tr>
                                                                    <th data-orderable="false" align="center" bgcolor="#ebebeb"><strong><?php echo __("website/products/server-list-title"); ?></strong></td>
                                                                    <th data-orderable="false" align="center" bgcolor="#ebebeb"><strong><?php echo __("website/products/server-list-processor"); ?></strong></th>
                                                                    <th data-orderable="false" align="center" bgcolor="#ebebeb"><strong><?php echo __("website/products/server-list-ram"); ?></strong></th>
                                                                    <th data-orderable="false" align="center" bgcolor="#ebebeb"><strong><?php echo __("website/products/server-list-disk"); ?></strong></th>
                                                                    <th data-orderable="false" align="center" bgcolor="#ebebeb"><strong><?php echo __("website/products/server-list-bandwidth"); ?></strong></th>
                                                                    <th data-orderable="false" align="center" bgcolor="#ebebeb"><strong><?php echo __("website/products/server-list-location"); ?></strong></th>
                                                                    <th align="center" bgcolor="#ebebeb"><strong><?php echo __("website/products/server-list-amount"); ?></strong></th>
                                                                    <th data-orderable="false" align="center" bgcolor="#ebebeb"><strong><?php echo __("website/products/server-list-buy"); ?></strong></td>
                                                                </tr>
                                                                </thead>

                                                                <tbody>
                                                                <?php
                                                                    foreach($xproducts AS $k=>$product):
                                                                        $opt  = $product["options1"];
                                                                        $optl = $product["options2"];
                                                                        $p_n  = 0;
                                                                        $prices     = (!isset($product["prices"])) ? [] : $product["prices"];
                                                                        if(isset($prices[0]) && $prices[0]["amount"]){
                                                                            $period = View::period($prices[0]["time"],$prices[0]["period"]);
                                                                            $price      = Money::formatter_symbol($prices[0]["amount"],$prices[0]["cid"],!$product["override_usrcurrency"]);
                                                                            $p_n        = round(Money::exChange($prices[0]["amount"],$prices[0]["cid"],!$product["override_usrcurrency"] ? Money::getUCID() : false),2);
                                                                        }
                                                                        else{
                                                                            $price = ___("needs/free-amount");
                                                                            $period = NULL;
                                                                        }

                                                                        ?>
                                                                        <tr>
                                                                            <td align="center" valign="middle">
                                                                                <?php echo $product["title"]; ?><br>
                                                                                <?php if($product["cover_image"]): ?>
                                                                                    <img src="<?php echo $product["cover_image"];?>" width="auto" height="42">
                                                                                <?php endif; ?>
                                                                                <?php if(!$product["haveStock"]): ?>
                                                                                    <div class="sunucustok" id="tukendi"><?php echo __("website/products/out-of-stock2"); ?></div>
                                                                                <?php endif; ?>
                                                                            </td>
                                                                            <td align="center" valign="middle"><?php echo (isset($opt["processor"]) && $opt["processor"] != '') ? $opt["processor"] : "-"; ?></td>
                                                                            <td align="center" valign="middle"><?php echo (isset($opt["ram"]) && $opt["ram"] != '') ? $opt["ram"] : "-"; ?></td>
                                                                            <td align="center" valign="middle"><?php echo (isset($opt["disk-space"]) && $opt["disk-space"] != '') ? $opt["disk-space"] : "-"; ?></td>
                                                                            <td align="center" valign="middle"><?php echo (isset($opt["bandwidth"]) && $opt["bandwidth"] != '') ? $opt["bandwidth"] : "-"; ?></td>
                                                                            <td align="center" valign="middle"><?php echo (isset($optl["location"]) && $optl["location"] != '') ? $optl["location"] : "-"; ?></td>
                                                                            <td align="center" valign="middle" data-order="<?php echo $p_n; ?>">
                                                                                <h4>
                                                                                    <strong><?php echo $price; ?></strong>
                                                                                    <?php if($period): ?>
                                                                                        <br><span style="font-size: 16px;">(<?php echo $period; ?>)</span>
                                                                                    <?php endif; ?>
                                                                                </h4>
                                                                            </td>
                                                                            <td align="center" valign="middle">
                                                                                <?php if($product["haveStock"]){ ?>
                                                                                    <a class="green lbtn" href="<?php echo $product["buy_link"]; ?>"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <?php echo __("website/products/buy-button2"); ?></a>
                                                                                <?php }else{ ?>
                                                                                    <a id="sunucutukenbtn" class="green lbtn"><i class="fa fa-ban" aria-hidden="true"></i> <?php echo __("website/products/out-of-stock"); ?></a>
                                                                                <?php } ?>
                                                                            </td>
                                                                        </tr>
                                                                    <?php endforeach; ?>
                                                                </tbody>

                                                            </table>
                                                            <?php
                                                        }
                                                        else{
                                                            foreach($xproducts AS $product){
                                                                $popular            = false;
                                                                $product_amount     = 0;
                                                                $product_period     = '';
                                                                $prices     = (!isset($product["prices"])) ? [] : $product["prices"];
                                                                if(isset($prices[0]) && $prices[0]>0){
                                                                    $amount = $prices[0]["amount"];
                                                                    $cid    = $prices[0]["cid"];
                                                                    $product_amount = Money::formatter_symbol($amount,$cid,!$product["override_usrcurrency"]);
                                                                    $amount_symbol_position = '';
                                                                    $split_amount   = explode(" ",$product_amount);
                                                                    $amount_symbol  = '';
                                                                    if(in_array(current($split_amount),$currency_symbols)){
                                                                        $amount_symbol_position = "left";
                                                                        $amount_symbol  = current($split_amount);
                                                                        array_shift($split_amount);
                                                                        $product_amount = implode(" ",$split_amount);
                                                                    }elseif(in_array(end($split_amount),$currency_symbols)){
                                                                        $amount_symbol_position = "right";
                                                                        $amount_symbol  = end($split_amount);
                                                                        array_pop($split_amount);
                                                                        $product_amount = implode(" ",$split_amount);
                                                                    }
                                                                }

                                                                if(isset($prices[0])){
                                                                    $product_period = View::period($prices[0]["time"],$prices[0]["period"]);
                                                                }

                                                                if(isset($product["options1"]["popular"]) && $product["options1"]["popular"]) $popular = true;


                                                                ?>
                                                                <div class="tablepaket<?php echo $popular ? ' active' : '' ?>" data-aos="fade-up">

                                                                    <?php
                                                                        if($popular){
                                                                            ?>
                                                                            <div class="tablepopular"><?php echo __("website/products/popular"); ?></div>
                                                                            <?php
                                                                        }
                                                                    ?>

                                                                    <div class="tpakettitle"><?php echo $product["title"]; ?></div>
                                                                    <div class="paketline"></div>
                                                                    <h4><?php echo $product_period; ?></h4>
                                                                    <h3><div class="amount_spot_view"><i class="currpos<?php echo $amount_symbol_position; ?>"><?php echo $amount_symbol; ?></i> <?php echo $product_amount; ?></div></h3>
                                                                    <div class="paketline"></div>
                                                                    <?php
                                                                        $json       = Utility::jdecode($product["features"],true);
                                                                        if($json){
                                                                            if(isset($columns) && $columns){
                                                                                foreach($columns AS $column){
                                                                                    $val = isset($json[$column["id"]]) ? $json[$column["id"]] : NULL;
                                                                                    if($val != NULL){
                                                                                        ?><span><?php echo $column["name"]." <strong>".$val."</strong>"; ?></span><?php
                                                                                    }

                                                                                }
                                                                                if($columns){
                                                                                    ?>
                                                                                    <div class="paketline"></div>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                        }else{
                                                                            $features = $product["features"];
                                                                            ?>
                                                                            <div class="clear"></div>
                                                                            <div class="products_features">
                                                                                <?php echo nl2br($features); ?>
                                                                            </div>
                                                                            <div class="clear"></div>
                                                                            <?php
                                                                            if($features){
                                                                                ?>
                                                                                <div class="paketline"></div>
                                                                                <?php
                                                                            }
                                                                        }
                                                                    ?>

                                                                    <?php if($product["buy_link"] != ''): ?>

                                                                        <?php if($product["haveStock"]){ ?>
                                                                            <a class="gonderbtn" href="<?php echo $product["buy_link"]; ?>">
                                                                                <?php echo isset($product["optionsl"]["buy_button_name"]) && $product["optionsl"]["buy_button_name"] ? $product["optionsl"]["buy_button_name"] : __("website/index/add-basket-button"); ?>
                                                                            </a>
                                                                        <?php }else{ ?>
                                                                            <a id="sunucutukenbtn" class="gonderbtn"><i class="fa fa-ban" aria-hidden="true"></i> <?php echo __("website/products/out-of-stock"); ?></a>
                                                                        <?php } ?>
                                                                        

                                                                    <?php endif; ?>

                                                                </div>
                                                                <?php
                                                            }
                                                        }
                                                    ?>
                                                </div>
                                                <?php
                                            }
                                        ?>
                                    </div>

                                    <h4 class="tableslogan" data-aos="fade-in"><?php echo __("website/index/product-group-link",[
                                            '{group_link}' => $group_link,
                                            'group_title'  => $group_title,
                                        ]); ?></h4>

                                <?php endif; ?>


                            </div>
                        </div>
                    </div>
                    <?php

                }
            }

        }

        if($name=="home-softwares" && $item["status"]==1 && $pg_activation["software"]){
            $background_picture = $background_picture ? ' style="background-image: url('.$background_picture.');"' : '';
            ?>
            <?php
            if(!empty($item["title"]) || !empty($item["description"])):
                ?>
                <div id="wrapper">
                    <div class="pakettitle" data-aos="fade-in">
                        <?php
                            if(!empty($item["title"])):
                                ?>
                                <h1><strong><?php echo $item["title"]; ?></strong></h1>
                                <?php
                            endif;
                            if(!empty($item["description"])):
                                ?>
                                <h2><?php echo $item["description"]; ?></h2>
                            <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
            <div class="anascript">
                <div id="wrapper">

                    <?php
                        if(isset($softwares) && $softwares){
                            foreach($softwares AS $software){
                                $amount     = Money::formatter_symbol($software["price"]["amount"],$software["price"]["cid"],!$software["override_usrcurrency"]);

                                $split_amount       = explode(" ",$amount);
                                $symbol             = '';
                                $symbol_position    = '';
                                if(in_array(current($split_amount),$currency_symbols)){
                                    $symbol_position = "left";
                                    $symbol  = current($split_amount);
                                    array_shift($split_amount);
                                    $amount = implode(" ",$split_amount);
                                }elseif(in_array(end($split_amount),$currency_symbols)){
                                    $symbol_position = "right";
                                    $symbol  = end($split_amount);
                                    array_pop($split_amount);
                                    $amount = implode(" ",$split_amount);
                                }

                                $opl    = $software["optionsl"];
                                ?>
                                <div class="anascriptlist" data-aos="fade-up">
                                    <div class="scripthoverinfo">
                                        <a href="<?php echo $software["route"]; ?>" title="<?php echo __("website/index/software-see"); ?>" class="sbtn"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                        <a href="<?php echo $software["buy_link"]; ?>" title="<?php echo __("website/index/add-basket"); ?>" class="sbtn"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a>
                                    </div>
                                    <?php
                                        if(isset($opl["tag1"]) && $opl["tag1"]){
                                            ?>
                                            <span class="scriptozellk"><?php echo $opl["tag1"]; ?></span>
                                            <?php
                                        }
                                        if(isset($opl["tag2"]) && $opl["tag2"]){
                                            ?>
                                            <span class="scriptozellk" id="mobiluyum"><?php echo $opl["tag2"]; ?></span>
                                            <?php
                                        }
                                    ?>
                                    <div class="padding5">
                                        <a href="<?php echo $software["route"]; ?>"><img src="<?php echo $software["cover_image"]; ?>" width="auto" height="auto" title="<?php echo $software["title"]; ?>" alt="<?php echo $software["title"]; ?>"></a>
                                        <h4><strong><?php echo $software["title"]; ?></strong></h4>
                                        <h5><div class="amount_spot_view"><i class="currpos<?php echo $symbol_position; ?>"><?php echo $symbol; ?></i> <?php echo $amount; ?></div></h5>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                    ?>
                    <div class="clear"></div>
                    <div align="center">
                        <h4 class="tableslogan" data-aos="fade-in"><?php echo __("website/index/all-softwares",[
                                '{link}' => $softwares_link,
                            ]); ?></h4>
                    </div>
                </div>
            </div>

            <div class="clear"></div>
            <?php
        }

        if($name=="features" && $item["status"]==1){
            $background_picture = $background_picture ? ' style="background-image: url('.$background_picture.');"' : '';
            ?>
            <div class="nedenbiz"<?php echo $background_picture;?>>
                <div id="wrapper">
                    <?php
                        if(!empty($item["title"]) || !empty($item["description"])):
                            ?>
                            <div class="pakettitle" data-aos="fade-in">
                                <?php
                                    if(!empty($item["title"])):
                                        ?>
                                        <h1><strong><?php echo $item["title"]; ?></strong></h1>
                                        <?php
                                    endif;
                                    if(!empty($item["description"])):
                                        ?>
                                        <div class="line"></div>
                                        <h2><?php echo $item["description"]; ?></h2>
                                    <?php endif; ?>
                            </div>
                        <?php endif; ?>

                    <?php
                        if(isset($item["items"]) && is_array($item["items"])){
                            $features = $item["items"];
                            $size     = sizeof($features);
                            if($size>0){
                                foreach($features AS $feature){
                                    ?>
                                    <div class="ozellik" data-aos="flip-left">
                                        <?php
                                            if(!empty($feature["icon"])):
                                                ?>
                                                <span class="servisikon">
                                            <span class="servisikonalt">
                                            <i class="<?php echo $feature["icon"]; ?>"></i>
                                            </span>
                                        </span>
                                            <?php endif;
                                            if(!empty($feature["title"]) || !empty($feature["description"])):
                                                ?>
                                                <div class="servisinfos">
                                                    <?php
                                                        echo (!empty($feature["title"])) ? '<h4>'.$feature["title"].'</h4>' : '';
                                                        echo (!empty($feature["description"])) ? '<p>'.$feature["description"].'</p>' : ''; ?>
                                                </div>
                                            <?php endif; ?>

                                    </div>
                                    <?php
                                }
                            }
                        }
                    ?>

                </div>
            </div>

            <div class="clear"></div>
            <?php
        }

        if($name=="customer-feedback" && $item["status"]==1){
            ?>
            <?php if($item["send-opinion"] == 1): ?>
                <div id="gorusgonder" style="display: none;" data-izimodal-title="<?php echo __("website/cfeedback/add_title"); ?>">
                    <div class="padding10">
                        <form action="<?php echo $cfeedback_form_action;?>" method="POST" id="FeedbackForm" enctype="multipart/form-data">
                            <?php echo Validation::get_csrf_token('cfeedback'); ?>

                            <!--h2><?php echo __("website/cfeedback/add_title"); ?></h2-->
                            <p><?php echo __("website/cfeedback/add_info"); ?></p>
                            <input class="yuzde30" name="full_name" type="text" placeholder="<?php echo __("website/cfeedback/form-fullname"); ?>">
                            <input class="yuzde30" name="company_name" type="text" placeholder="<?php echo __("website/cfeedback/form-company_name"); ?>">
                            <input class="yuzde30" name="email" type="text" placeholder="<?php echo __("website/cfeedback/form-email"); ?>">
                            <textarea style="width: 98%;    height: 90px;resize: none;" maxlength="425" name="message" placeholder="<?php echo __("website/cfeedback/form-message"); ?>"></textarea>
                            <?php echo __("website/cfeedback/form-image"); ?>: <input style="width:200px" name="image" type="file">
                            <div class="clear"></div>
                            <?php if(isset($captcha) && $captcha): ?>
                                <div style="float:left;margin-right:5px;"><?php echo $captcha->getOutput(); ?></div>
                                <?php if($captcha->input): ?>
                                    <input class="captchainput" name="<?php echo $captcha->input_name; ?>" type="text" placeholder="<?php echo ___("needs/form-captcha-label"); ?>">
                                <?php endif; ?>
                            <?php endif; ?>

                            <hr>
                            <a style="float:right;" class="gonderbtn" id="FeedbackForm_submit" href="javascript:void(0);"><?php echo __("website/cfeedback/form-submit"); ?></a>

                            <div id="FeedbackForm_output" style="display:none;color:red;font-weight:bold;"></div>
                        </form>

                        <!-- SUCCESS -->
                        <div id="FeeadbackForm_Successful" style="display: none">
                            <div style="margin-top:30px;margin-bottom:70px;text-align:center;">
                                <i style="font-size:80px;color:green;" class="fa fa-check"></i>
                                <h4 style="color:green;font-weight:bold;"><?php echo __("website/cfeedback/successful-text1"); ?></h4>
                                <br>
                                <h5><?php echo __("website/cfeedback/successful-text2"); ?></h5>
                            </div>
                        </div>
                        <!-- SUCCESS -->

                        <script type="text/javascript">
                            $(document).ready(function(){

                                $("#FeedbackForm_submit").on("click",function(){
                                    MioAjaxElement($(this),{
                                        waiting_text: '<?php echo __("website/others/button1-pending"); ?>',
                                        progress_text: '<?php echo __("website/others/button1-upload"); ?>',
                                        result:"feedback_result",
                                    });
                                });

                            });
                            function feedback_result(result) {
                                <?php if(isset($captcha)) echo $captcha->submit_after_js(); ?>
                                if(result != ''){
                                    var solve = getJson(result);
                                    if(solve !== false){
                                        if(solve.status == "error"){
                                            if(solve.for != undefined && solve.for != ''){
                                                $("#FeedbackForm "+solve.for).focus();
                                                $("#FeedbackForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                                $("#FeedbackForm "+solve.for).change(function(){
                                                    $(this).removeAttr("style");
                                                });
                                            }

                                            if(solve.message != undefined && solve.message != '')
                                                $("#FeedbackForm_output").fadeIn(500).html(solve.message);
                                            else
                                                $("#FeedbackForm_output").fadeOut(500).html('');
                                        }else if(solve.status == "successful"){
                                            $("#FeedbackForm_output").fadeOut(500).html('');
                                            $("#FeedbackForm").slideUp(200,function(){
                                                $("#FeeadbackForm_Successful").slideDown(200);
                                            });
                                        }
                                    }else
                                        console.log(result);
                                }
                            }
                        </script>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="musterigorusleri">
                <div id="wrapper">
                    <?php
                        if(!empty($item["title"]) || !empty($item["description"])):
                            ?>
                            <div class="pakettitle" data-aos="fade-in">
                                <?php
                                    if(!empty($item["title"])):
                                        ?>
                                        <h1><strong><?php echo $item["title"]; ?></strong></h1>
                                        <?php
                                    endif;
                                    if(!empty($item["description"])):
                                        ?>
                                        <h2><?php echo $item["description"]; ?></h2>
                                    <?php endif; ?>

                                <div class="clear"></div>
                                <?php if($item["send-opinion"] == 1): ?>
                                    <a class="gonderbtn" href="javascript:void 0;" onclick="open_modal('gorusgonder');"><?php echo __("website/cfeedback/btn1"); ?></a>
                                <?php endif; ?>


                            </div>
                        <?php endif; ?>
                    <div class="clear"></div>
                    <div class="list_carousel" data-aos="fade-up">
                        <ul id="foo2">

                            <?php
                                (!isset($cfeedbacks) || !is_array($cfeedbacks)) ? $cfeedbacks = [] : false;
                                foreach($cfeedbacks AS $feed){
                                    $image_link = $feed['image'];
                                    $length     = Utility::strlen($feed["message"]);
                                    $message    = Utility::short_text($feed["message"],0,435,true);
                                    ?>
                                    <li>
                                        <div class="musyorum" style="<?php echo $length >=345 ? 'font-size:17px;' : '';?>">
                                            <div style="padding:20px;">
                                                <?php echo $message; ?>
                                            </div>
                                        </div>
                                        <div class="yorumyapan">
                                            <div id="mgorusarrow"><i class="ion-android-arrow-dropdown"></i></div>
                                            <img src="<?php echo $image_link; ?>" alt="<?php echo $feed["full_name"];?>" title="<?php echo $feed["full_name"];?>" width="80" height="80">

                                            <?php if($feed["full_name"] != ''): ?><h3><?php echo $feed["full_name"];?></h3><?php endif; ?>
                                            <?php if($feed["company_name"] != ''): ?><h4><?php echo $feed["company_name"];?></h4><?php endif; ?>
                                        </div>
                                    </li>
                                    <?php
                                }
                            ?>

                        </ul>
                        <div class="clearfix"></div>
                        <div id="pager2" class="pager"></div>
                    </div>
                </div>
            </div>


            <div class="clear"></div>
            <?php
        }

        if($name=="news-articles" && $item["status"]==1){
            $background_picture = $background_picture ? ' style="background-image: url('.$background_picture.');"' : '';
            ?>
            <div class="blogvehaber"<?php echo $background_picture;?>>
                <div id="wrapper">

                    <?php if($item["news"]==1): ?>
                        <div class="haberblog" data-aos="fade-up">
                            <div style="padding:25px;">
                                <div class="haberbloktitle">
                                    <div id="pager3" class="pager"></div>
                                    <h4><i style="margin-right:10px;" class="fa fa-bullhorn" aria-hidden="true"></i> <a href="<?php echo $news_link;?>"><?php echo __("website/index/news-title"); ?></a></h4>
                                </div>

                                <div class="list_carousel">
                                    <ul id="foo3">
                                        <?php
                                            (!isset($news) || !is_array($news)) ? $news = [] : false;
                                            foreach($news AS $new){
                                                $image_link = $new["image"];
                                                $link = $new["route"];
                                                $date = $new["date"];
                                                $title = $new["title"];
                                                $short_title = Utility::short_text($new["title"],0,60,true);
                                                $short_content = Filter::html_clear($new["content"]);
                                                $short_content = Utility::short_text($short_content,0,230,true);
                                                ?>
                                                <li> <a href="<?php echo $link;?>"><img src="<?php echo $image_link; ?>" width="176" height="113" alt="<?php echo $title; ?>" title="<?php echo $title; ?>"></a>
                                                    <h4><a href="<?php echo $link; ?>"><?php echo $short_title; ?></a><br><span>(<?php echo $date;?>)</span></h4>
                                                    <div class="clear"></div>
                                                    <p><?php echo $short_content; ?></p>
                                                </li>
                                                <?php
                                            }
                                        ?>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>

                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if($item["articles"]==1): ?>
                        <div class="haberblog"  data-aos="fade-up">
                            <div style="padding:25px;">
                                <div class="haberbloktitle">
                                    <div id="pager4" class="pager"></div>
                                    <h4><i style="margin-right:10px;" class="fa fa-rss" aria-hidden="true"></i> <a href="<?php echo $articles_link;?>"><?php echo __("website/index/articles-title"); ?></a></h4>
                                </div>

                                <div class="list_carousel">
                                    <ul id="foo4">
                                        <?php
                                            (!isset($articles) || !is_array($articles)) ? $articles = [] : false;
                                            foreach($articles AS $article){
                                                $image_link = $article["image"];
                                                $link = $article["route"];
                                                $date = $article["date"];
                                                $title = $article["title"];
                                                $short_title = Utility::short_text($article["title"],0,60,true);
                                                $short_content = Filter::html_clear($article["content"]);
                                                $short_content = Utility::short_text($short_content,0,230,true);
                                                ?>
                                                <li> <a href="<?php echo $link;?>"><img src="<?php echo $image_link; ?>" width="176" height="113" alt="<?php echo $title; ?>" title="<?php echo $title; ?>"></a>
                                                    <h4><a href="<?php echo $link; ?>"><?php echo $short_title; ?></a><br><span>(<?php echo $date;?>)</span></h4>
                                                    <div class="clear"></div>
                                                    <p><?php echo $short_content; ?></p>
                                                </li>
                                                <?php
                                            }
                                        ?>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>


            <div class="clear"></div>
            <?php
        }

        if($name=="statistics-by-numbers" && $item["status"]==1){
            ?>
            <div class="rakamlarlabiz">
                <div id="wrapper">
                    <?php
                        if(!empty($item["title"]) || !empty($item["description"])):
                            ?>
                            <div class="pakettitle" data-aos="fade-in">
                                <?php
                                    if(!empty($item["title"])):
                                        ?>
                                        <h1><strong><?php echo $item["title"]; ?></strong></h1>
                                        <?php
                                    endif;
                                    if(!empty($item["description"])):
                                        ?>
                                        <h2><?php echo $item["description"]; ?></h2>
                                    <?php endif; ?>
                            </div>
                        <?php endif; ?>

                    <?php
                        if(isset($item["items"])){
                            $statistics = $item["items"];
                            $size = sizeof($statistics);
                            if($size>0){
                                foreach($statistics AS $statistic){
                                    ?>
                                    <div class="istatistik" data-aos="zoom-in">
                                        <h1 class="counter"><?php echo $statistic["number"];?></h1>
                                        <h2><?php echo $statistic["title"];?></h2>
                                        <i class="<?php echo $statistic["icon"]; ?>" aria-hidden="true"></i>
                                    </div>
                                    <?php
                                }
                            }
                        }
                    ?>

                </div>
            </div>
            <?php
        }
    }
?>
