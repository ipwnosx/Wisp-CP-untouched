<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    $hoptions = [
        'page' => "softwares",
        'jquery-ui',
    ];

    $currency_symbols = [];
    foreach(Money::getCurrencies() AS $currency){
        $symbol = $currency["prefix"] != '' ? trim($currency["prefix"]) : trim($currency["suffix"]);
        if(!$symbol) $symbol = $currency["code"];
        $currency_symbols[] = $symbol;
    }

?>
<script>
    $( function() {
        $( "#accordion" ).accordion({
            heightStyle: "content"
        });
    } );
</script>
<div class="anascript" id="scriptlistesi">
    <div id="wrapper">


        <div class="anascripler" >

            <h4 class="scriptlisttitle"><strong><?php echo (isset($category)) ? $category["title"] : ___("constants/category-software/title"); ?></strong></h4>



            <?php
                if(isset($list) && is_array($list) && sizeof($list)>0){
                    foreach($list AS $software){
                        ?>
                        <div class="anascriptlist" data-aos="fade-up">
                            <div class="scripthoverinfo">
                                <a href="<?php echo $software["route"]; ?>" title="<?php echo __("website/index/software-see"); ?>" class="sbtn"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                <a href="<?php echo $software["buy_link"]; ?>" title="<?php echo __("website/index/add-basket"); ?>" class="sbtn"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a>
                            </div>
                            <?php
                                $amount        = Money::formatter_symbol($software["price"]["amount"],$software["price"]["cid"],!$software["override_usrcurrency"]);

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
                }else{ ?>
                    <div class="error"><?php echo __("website/softwares/no-content"); ?></div>
                <?php } ?>


            <div class="urunozellikleri" data-aos="fade-up">
                <div class="urunozellik">
                    <i class="<?php echo __("website/softwares/feature-1-icon"); ?>" aria-hidden="true"></i>
                    <h4><?php echo __("website/softwares/feature-1-text"); ?></h4>
                </div>
                <i class="fa fa-caret-right" aria-hidden="true"></i>
                <div class="urunozellik">
                    <i class="<?php echo __("website/softwares/feature-2-icon"); ?>" aria-hidden="true"></i>
                    <h4><?php echo __("website/softwares/feature-2-text"); ?></h4>
                </div>
                <i class="fa fa-caret-right" aria-hidden="true"></i>
                <div class="urunozellik">
                    <i class="<?php echo __("website/softwares/feature-3-icon"); ?>"></i>
                    <h4><?php echo __("website/softwares/feature-3-text"); ?></h4>
                </div>
                <i class="fa fa-check-circle" aria-hidden="true"></i>
                <div class="clear"></div>
            </div>


            <div class="clear"></div>
            <?php echo (isset($pagination)) ? $pagination : false; ?>
        </div>

        <div style="float: left;width: 23%;margin-top: 15px;">
            <form action="<?php echo $link; ?>" method="get" id="searchForm">
                <input type="search" id="SearchTerm" value="<?php echo isset($search_term) ? $search_term : ''; ?>" placeholder="<?php echo __("website/softwares/search-placeholder"); ?>" class="yuzde80" name="search_term">
                <a href="javascript:void 0;" onclick="$('#searchForm').submit();" class="sbtn yuzde20"><i class="fa fa-search" aria-hidden="true"></i></a>
            </form>
        </div>

        <?php if(is_array($categories) && sizeof($categories)>0): ?>
            <div class="scriptkategoriler">
                <h4 class="scriptlisttitle"><strong><?php echo __("website/softwares/categories"); ?></strong></h4>
                <?php foreach($categories AS $cat): ?>
                    <a href="<?php echo $cat["route"];?>"<?php echo (isset($category) && $category["id"]==$cat["id"]) ? ' id="scataktif"' : ''; ?>><?php echo $cat["title"];?> <span>(<?php echo $cat["count"];?>)</span></a>
                <?php endforeach; ?>
                <a href="<?php echo $all_software_link;?>"<?php echo (!isset($category)) ? ' id="scataktif"' : ''; ?>><?php echo __("website/softwares/all-software"); ?></a>
            </div>
        <?php endif; ?>

        <div class="clear"></div>
        <div data-aos="fade-up"><?php echo $content; ?></div>
        <div class="clear"></div>

        <?php if(isset($faq) && $faq): ?>
            <div class="sss" style="margin-top:40px;" data-aos="fade-up">
                <h4><strong><?php echo __("website/others/faq"); ?></strong></h4>
                <div id="accordion">
                    <?php foreach($faq AS $f): ?>
                        <h3><?php echo $f["title"]; ?></h3>
                        <div><?php echo $f["description"]; ?></div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="clear"></div>
        <?php echo isset($category) && $category["content"] ? $category["content"] : NULL; ?>


    </div>
</div>
<div class="clear"></div>