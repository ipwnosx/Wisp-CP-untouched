<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    $hoptions = [
        'page' => "sms-products",
        'jquery-ui',
        'dataTables',
    ];

    $currency_symbols = [];
    foreach(Money::getCurrencies() AS $currency){
        $symbol = $currency["prefix"] != '' ? trim($currency["prefix"]) : trim($currency["suffix"]);
        if(!$symbol) $symbol = $currency["code"];
        $currency_symbols[] = $symbol;
    }
    $GLOBALS["currency_symbols"] = $currency_symbols;

    $GLOBALS["tadress"]  = $tadress;
    $products = function($cat=[],$list){
        global $tadress,$currency_symbols;
        if($list){
            ?>
            <div class="tablopaketler" style="background: none;" id="category_<?php echo $cat["id"]; ?>">
                <?php
                    foreach($list AS $product){
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

                        if(isset($product["options"]["popular"]) && $product["options"]["popular"]) $popular = true;


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
                                <a href="<?php echo $product["buy_link"]; ?>" class="gonderbtn"><?php echo isset($product["optionsl"]["buy_button_name"]) && $product["optionsl"]["buy_button_name"] ? $product["optionsl"]["buy_button_name"] : __("website/index/add-basket-button"); ?></a>
                            <?php endif; ?>

                        </div>
                        <?php
                    }
                ?>
            </div>
            <?php
        }
    }

?>
<script>

    $( function() {
        $( "#accordion" ).accordion({
            heightStyle: "content"
        });
    } );

    $(document).ready(function() {
        $('.datatable').DataTable({
            responsive: true,
            info: false,
            searching: false,
            "language":{
                "url":"<?php echo APP_URI."/".___("package/code")."/datatable/lang.json";?>"
            }
        });
    });
</script>
<?php if(isset($header_background) && $header_background != ''): ?>
    <meta property="og:image" content="<?php echo $header_background; ?>">
<?php endif; ?>
<div id="wrapper">

    <div class="pakettitle" style="margin-top:0px;" data-aos="fade-up">
        <h1><strong><?php echo $showCategory["title"]; ?></strong></h1>
        <h2><?php echo $showCategory["sub_title"]; ?></h2>
    </div>

    <div class="clear"></div>
    <?php
        if(!isset($category2) || !$category2){
            $list = $get_list($showCategory["id"],$showCategory["kind"]);
            $products($showCategory,$list);
        }

        $categories = $get_categories($category["id"],$category["kind"]);
        if($categories){
            $category_products  = [];
            $categories_list    = [];
            ?>
            <div class="categoriesproduct" data-aos="fade-up">
                <?php
                    $selection = isset($category2) ? $category2 : false;
                    foreach($categories AS $k=>$cat){
                        $list           = $get_list($cat["id"],$cat["kind"]);
                        $subs           = $get_categories($cat["id"],$cat["kind"]);

                        $category_products[$cat["id"]] = $list;
                        $categories_list[$cat["id"]] = $subs;

                        if(!$list && !$subs) continue;
                        $selected = false;

                        if($category["id"])
                            $cat["route"] = $category_tab_route($cat["route"]);
                        else
                            $cat["route"] = $category_route($cat["route"]);

                        if($category["id"]){
                            if(!$selection && $k == 0) $selection = $cat;
                            if($selection && $cat["id"] == $selection["id"]) $selected = true;
                        }
                        ?>
                        <a href="<?php echo $cat["route"]; ?>" class="lbtn"<?php echo $selected ? ' style="background:#777;color:white;"' : ''; ?>>
                            <?php if(isset($cat["options"]["icon"]) && $cat["options"]["icon"]): ?>
                                <i class="<?php echo $cat["options"]["icon"]; ?>" aria-hidden="true"></i>
                            <?php elseif(isset($cat["icon"]) && $cat["icon"]): ?>
                                <img src="<?php echo $cat["icon"]; ?>" width="250" height="200">
                            <?php endif; ?>
                            <?php echo $cat["title"]; ?>
                        </a>
                        <?php
                    }
                ?>
            </div>
            <?php
        }

        if($category["id"] && isset($selection) && $selection){
            if(isset($category_products[$selection["id"]])){
                $list = $category_products[$selection["id"]];
                $products($selection,$list);
                $categories = isset($categories_list[$selection["id"]]) ? $categories_list[$selection["id"]] : false;
                if($categories){
                    foreach($categories AS $cat){
                        $list = $get_list($cat["id"],$cat["kind"]);
                        if($list){
                            ?><h5 style="font-weight: bold;font-size: 24px;"><?php echo $cat["title"]; ?></h5><?php
                            $products($cat,$list);
                        }
                    }
                }
            }
        }
    ?>

    <div class="clear"></div>


</div>
<div id="wrapper">

    <div class="detail-products-features" data-aos="fade-up"><?php echo $content; ?></div>
    <div class="clear"></div><br>

    <?php if(isset($faq) && $faq): ?>
        <div class="sss"  data-aos="fade-up">
            <h4><strong><?php echo __("website/others/faq"); ?></strong></h4>
            <div id="accordion">
                <?php foreach($faq AS $f): ?>
                    <h3><?php echo $f["title"]; ?></h3>
                    <div><?php echo $f["description"]; ?></div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>


</div>
<div class="clear"></div>