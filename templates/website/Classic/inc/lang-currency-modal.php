<?php defined('CORE_FOLDER') OR exit('You can not get in here!'); ?>
<?php if($lang_count > 1): ?>
    <div id="selectLang" class="selectLangCurrency">
        <a class="langcurclose" href="javascript:close_modal('selectLang');void 0;">X</a>
        <div class="padding20">
            <div class="langandcur">
                <h4><?php echo __("website/index/select-your-language"); ?></h4>

                <?php
                    $selected_l = false;
                    foreach($lang_list AS $row){
                        $selected   = $row["selected"];
                        if($selected) $selected_l = $row;
                        $link = $row["link"];
                        if(!stristr($link,"?")) $link .= "?chl=true";
                        ?>
                        <a<?php echo $selected ? ' class="activelangcur"' : ' href="'.$link.'"'; ?> rel="nofollow"><img title="<?php echo $row["cname"]." (".$row["name"].")"; ?>" alt="<?php echo $row["cname"]." (".$row["name"].")"; ?>" src="<?php echo $row["flag-img"]; ?>"><?php echo $row["cname"]." (".$row["name"].")"; ?></a>
                        <?php
                    }
                ?>

                <div class="clear"></div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
<?php endif; ?>
<?php if($currencies_count > 1): ?>
    <div id="selectCurrency" class="selectLangCurrency">
        <a class="langcurclose" href="javascript:close_modal('selectCurrency');void 0;">X</a>
        <div class="padding20">
            <div class="langandcur">
                <div class="currencyitems">
                    <h4 style="margin-top:25px;"><?php echo __("website/index/select-your-currency"); ?></h4>
                    <?php

                        foreach($currencies AS $row){
                            $selected   = $row["id"] == $selected_currency;
                            $link = $canonical_link;
                            if(stristr($link,"?")){
                                $parse  = explode("?",$link);
                                $link   = $parse[0];
                            }
                            $link .= (isset($parse[1]) ? "?".$parse[1].'&' : '?')."chc=".$row["id"];
                            $symbol_info    = Money::getSymbol($row["id"]);
                            $symbol         = $symbol_info["symbol"];
                            if(!$symbol)
                                $symbol     = $row["code"];
                            $row['symbol'] = $symbol;

                            if($selected) $selected_c = $row;
                            ?>
                            <a<?php echo $selected ? ' class="activelangcur"' : ' href="'.$link.'"'; ?> rel="nofollow"><strong><?php echo $symbol; ?></strong> <?php echo $row["name"]; ?></a>
                            <?php
                        }
                    ?>
                </div>
            </div>
            <div class="clear"></div>
        </div>

        <div class="clear"></div>
    </div>
<?php endif; ?>