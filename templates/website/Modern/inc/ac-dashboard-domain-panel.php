<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    if(!Config::get("options/pg-activation/domain")) return false;

    $currency_symbols = [];
    foreach(Money::getCurrencies() AS $currency){
        $symbol = $currency["prefix"] != '' ? trim($currency["prefix"]) : trim($currency["suffix"]);
        if(!$symbol) $symbol = $currency["code"];
        $currency_symbols[] = $symbol;
    }

    if(isset($first_tld_price)){
        $first_tld_price_amount = $first_tld_price["register"]["amount"];
        if($first_tld_price["promo_status"] && DateManager::strtotime($first_tld_price["promo_duedate"]." 23:59:59") > DateManager::strtotime() && $first_tld_price["promo_register_price"]>0){
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
<div class="alanadisorgu">
    <h1><?php echo __("website/domain/slogan",['{price}' => $first_price]); ?></h1>

    <div class="clear"></div>

    <form id="checkForm" action="<?php echo $domain_check_post; ?>" method="get">
        <input type="text" name="domain" placeholder="<?php echo __("website/index/domain-check-input-placeholder"); ?>">
        <a href="javascript:void(0);" id="checkButton" onclick="$('#checkForm').submit();" class="gonderbtn"><?php echo __("website/domain/check-it"); ?></a>
    </form>


</div>