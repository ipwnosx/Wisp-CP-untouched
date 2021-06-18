<?php defined('CORE_FOLDER') OR exit('You can not get in here!');

    $currency_symbols = [];
    foreach(Money::getCurrencies() AS $currency){
        $symbol = $currency["prefix"] != '' ? trim($currency["prefix"]) : trim($currency["suffix"]);
        if(!$symbol) $symbol = $currency["code"];
        $currency_symbols[] = $symbol;
    }

    $price  = $page["price"];
    $amount = Money::formatter_symbol($price["amount"],$price["cid"],!$page["override_usrcurrency"]);
    $period = View::period($price["time"],$price["period"]);
    if(!$amount){
        $amount = ___("needs/free-amount");
        $period = NULL;
    }

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

    $hoptions = [
        'page' => "page-detail-software",
        'jquery-ui',
    ];
?>
<script>
    $( function() {
        $( "#accordion" ).accordion({
            heightStyle: "content"
        });
    } );
</script>
<?php if(isset($page["mockup"]) && $page["mockup"] != ''): ?>
    <meta property="og:image" content="<?php echo $page["mockup"]; ?>">
<?php endif; ?>

<div id="wrapper">

    <div class="scriptrightside">

        <div class="clear"></div>

        <?php if(isset($optionsl["short_features"])): ?>
            <?php
            $descs = explode(EOL,$optionsl["short_features"]);
            foreach($descs AS $desc):
                ?>
                <h4><?php echo $desc; ?></h4>
            <?php endforeach; endif; ?>

        <div class="scriptpaylas paypasbutonlar">
            <?php include __DIR__.DS."inc".DS."social_share.php"; ?>
        </div>

        <div class="clear"></div>

        <div class="scriptfiyat">
            <h1>
                <div class="amount_spot_view">
                    <i class="currpos<?php echo $amount_symbol_position; ?>"><?php echo $amount_symbol; ?></i>
                    <?php echo $amount; ?>
                </div>
                <?php echo $period ? ' <div class="clear"></div><span>('.$period.')</span>' : ''; ?></h1>
        </div>
        <?php if(isset($options["demo_link"]) && $options["demo_link"] != ''): ?>
            <a target="_blank" class="btn" href="<?php echo $options["demo_link"]; ?>" id="urundemolink"><i class="fa fa-eye" style="margin-right:5px;"></i> <?php echo __("website/softwares/demo-site"); ?></a>
        <?php endif; ?>

        <?php if(isset($options["demo_admin_link"]) && $options["demo_admin_link"] != ''): ?>
            <a target="_blank" class="btn" href="<?php echo $options["demo_admin_link"]; ?>" id="urundemoadminlink"><i class="fa fa-cog" style="margin-right:5px;"></i> <?php echo __("website/softwares/demo-admin"); ?></a>
        <?php endif; ?>

        <?php if(isset($buy_link) && $buy_link != ''): ?>
            <a class="btn" href="<?php echo $buy_link; ?>" id="urunsatinlink"><i class="fa fa-shopping-cart" style="margin-right:5px;"></i> <?php echo __("website/softwares/buy-button"); ?></a>
        <?php endif; ?>

        <?php if(isset($requirements) && $requirements != ''): ?>
            <div class="sunucugereksinim">
            <span>
                <strong><?php echo __("website/softwares/requirements"); ?></strong>
                <br>
                <?php echo nl2br($requirements); ?>
            </span>
            </div>
        <?php endif; ?>



    </div>

    <div class="scriptdetayinfo">
        <?php if(isset($page["mockup"]) && $page["mockup"] != ''): ?>
            <img src="<?php echo $page["mockup"]; ?>" width="1000" height="auto">
            <div class="clear"></div>
        <?php endif; ?>

        <?php
            if(isset($optionsl["feature_blocks"]) && is_array($optionsl["feature_blocks"])):
                foreach($optionsl["feature_blocks"] AS $block):
                    ?>
                    <div class="scriptozellks">
                        <div style="padding:10px;">
                            <span class="ozellkiconxx"><i class="<?php echo $block["icon"] ? $block["icon"] : "fa fa-check";?>" aria-hidden="true"></i></span>
                            <div class="scriptozellkinfo">
                                <h3><?php echo $block["title"];?></h3>
                                <p><?php echo $block["description"];?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; endif; ?>

        <?php echo $page["content"]; ?>


        <div class="surumgecmisi">
            <div id="accordion">

                <?php if(isset($optionsl["installation_instructions"]) && $optionsl["installation_instructions"] != ''): ?>
                    <h3><?php echo __("website/softwares/installation-instructions"); ?></h3>
                    <div>
                        <div style="height:250px;overflow-y:scroll;">
                            <?php echo $optionsl["installation_instructions"]; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if(isset($optionsl["versions"]) && $optionsl["versions"] != ''): ?>
                    <h3><?php echo __("website/softwares/update-version-history"); ?></h3>
                    <div>
                        <div style="height:250px;overflow-y:scroll;">
                            <?php echo $optionsl["versions"]; ?>
                        </div>
                    </div>
                <?php endif; ?>


            </div>
        </div>
    </div>


    <div class="clear"></div>
    <?php if(isset($most_popular) && is_array($most_popular)): ?>
        <div class="scriptdetaybenzer">
            <h4 class="scriptlisttitle"><strong><?php echo __("website/softwares/most-popular-softwares"); ?></strong></h4>
            <?php foreach($most_popular AS $software): ?>
                <div class="anascriptlist">
                    <div class="scripthoverinfo">
                        <a href="<?php echo $software["route"]; ?>" title="<?php echo __("website/index/software-see"); ?>" class="sbtn"><i class="fa fa-eye" aria-hidden="true"></i></a>
                        <a href="<?php echo $software["buy_link"]; ?>" title="<?php echo __("website/index/add-basket"); ?>" class="sbtn"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a>
                    </div>
                    <?php
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

                        $amount = Money::formatter_symbol($software["price"]["amount"],$software["price"]["cid"],true);
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

                    ?>
                    <div class="padding5">
                        <a href="<?php echo $software["route"]; ?>"><img src="<?php echo $software["cover_image"]; ?>" width="auto" height="auto" title="<?php echo $software["title"]; ?>" alt="<?php echo $software["title"]; ?>"></a>
                        <h4><strong><?php echo $software["title"]; ?></strong></h4>
                        <h5><strong>
                                <div class="amount_spot_view">
                                    <i class="currpos<?php echo $amount_symbol_position; ?>"><?php echo $amount_symbol; ?></i>
                                    <?php echo $amount; ?>
                                </div>
                            </strong></h5>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>