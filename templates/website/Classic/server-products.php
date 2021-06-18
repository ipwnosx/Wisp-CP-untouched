<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    $hoptions = [
        'page' => "server-products",
        'dataTables',
        'jquery-ui',
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
            $ltemplate = isset($cat["options"]["list_template"]) ? $cat["options"]["list_template"] : 2;
            ?>
            <?php if($ltemplate == 1): ?>
                <h5 class="servercattitle" data-aos="fade-up"><?php echo $cat["title"]; ?></h5>
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
                                    }
                                    else
                                    {
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
                    ?>
                </div>
            <?php elseif($ltemplate== 2): ?>
                <div class="sunucular" data-aos="fade-up">

                    <h5 class="servercattitle" data-aos="fade-up"><?php echo $cat["title"]; ?></h5>

                    <div>
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
                                foreach($list AS $k=>$product):
                                    $opt  = $product["options"];
                                    $optl = $product["options_lang"];

                                    $p_n        = 0;
                                    $prices     = (!isset($product["prices"])) ? [] : $product["prices"];
                                    if(isset($prices[0]) && $prices[0]["amount"]){
                                        $period = View::period($prices[0]["time"],$prices[0]["period"]);
                                        $price      = Money::formatter_symbol($prices[0]["amount"],$prices[0]["cid"],!$product["override_usrcurrency"]);
                                        $p_n        = Money::formatter($prices[0]["amount"],$prices[0]["cid"],false,!$product["override_usrcurrency"]);
                                    }
                                    else{
                                        $price = ___("needs/free-amount");
                                        $period = NULL;
                                    }

                                    ?>
                                    <tr>
                                        <td align="center" valign="middle">
                                            <strong><?php echo $product["title"]; ?></strong>
                                            <?php if($product["cover_image"]): ?>
                                                <br>
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
                                                    <span style="font-size: 16px;">(<?php echo $period; ?>)</span>
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
                    </div>
                </div>
            <?php endif; ?>
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

    $(document).ready(function()
    {
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
            $catSize = sizeof($categories);
            $category_products  = [];
            $categories_list    = [];
            ?>
            <div class="categoriesproduct"<?php echo $catSize==1 ? 'style="display:none;"' : ''; ?> data-aos="fade-up">
                <?php
                    $selection = isset($category2) && $category2 ? $showCategory : false;
                    foreach($categories AS $k=>$cat){
                        $list           = $get_list($cat["id"],$cat["kind"]);
                        $subs           = $get_categories($cat["id"],$cat["kind"]);

                        $category_products[$cat["id"]] = $list;
                        $categories_list[$cat["id"]] = $subs;

                        if(!$list && !$subs) continue;
                        $selected = false;

                        if($list)
                            $cat["route"] = $category_tab_route($cat["route"]);
                        else
                            $cat["route"] = $category_route($cat["route"]);

                        if($category["id"]){
                            if(!$selection && $k == 0) $selection = $cat;
                            if($selection && $cat["id"] == $selection["id"]) $selected = true;
                        }else{
                            if(isset($category2) && $category2 && $category2["id"] == $cat["id"]){
                                $selected = true;
                                $selection = $cat;
                            }elseif(!$selection && $category_products[$cat["id"]] && $k == 0){
                                $selected = true;
                                $selection = $cat;
                            }
                            elseif(!$selection && $k == 0){
                                $category = $cat;
                                $selected = true;
                                $selection = $cat;
                            }
                        }
                        ?>
                        <a href="<?php echo $cat["route"]; ?>" class="lbtn"<?php echo $selected ? ' id="category-button-active"' : ''; ?>>
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

        if(isset($selection) && $selection){
            if(isset($category_products[$selection["id"]])){
                $list = $category_products[$selection["id"]];
                $products($selection,$list);
                if($category["id"]){
                    $categories = isset($categories_list[$selection["id"]]) ? $categories_list[$selection["id"]] : false;
                    if($categories){
                        foreach($categories AS $cat){
                            $list = $get_list($cat["id"],$cat["kind"]);
                            if($list){
                                $products($cat,$list);
                            }
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