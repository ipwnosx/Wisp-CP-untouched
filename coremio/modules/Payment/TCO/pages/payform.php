<?php
    $ok_link                = $links["successful-page"];
    $fail_link              = $links["failed-page"];

    $checkout_items         = $module->checkout["items"];
    $checkout_data          = $module->checkout["data"];
    $user_data              = $checkout_data["user_data"];

    $currency               = $module->cid_convert_code($checkout_data["currency"]);
    $email                  = $user_data["email"];
    $user_name              = $user_data["full_name"];
    if($user_data["company_name"]) $user_name .= " ".$user_data["company_name"];
    $payable_total          = number_format($checkout_data["total"], 2, '.', '');
    $sandbox                = $module->config["settings"]["sandbox"];

?>
<script src="https://www.2checkout.com/static/checkout/javascript/direct.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){

        setTimeout(function(){
            $("#submit_button").trigger("click");
        },1000);

        inline_2Checkout.subscribe('checkout_closed', function(data) {
            window.location.href = '<?php echo $links["back"]; ?>';
        });

    });
</script>

<div align="center">
    <div class="progresspayment">
        
            <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
       
        <br><h3 id="progressh3"><?php echo $module->lang["redirect-message"]; ?></h3>
        <h4>
            <div class='angrytext'>
                <strong><?php echo __("website/others/loader-text2"); ?></strong>
            </div>
        </h4>

    </div>
</div>

<form action='<?php echo  "https://2checkout.com/checkout/purchase"; ?>' method='post' id="saleForm">
    <input type='hidden' name='sid' value='<?php echo $module->config["settings"]["sid"]; ?>' >
    <input type='hidden' name='mode' value='2CO' >

    <input type='hidden' name='card_holder_name' value='<?php echo $user_name; ?>'>
    <input type='hidden' name='street_address' value='<?php echo Utility::short_text($user_data["address"]["address"],0,64); ?>'>
    <input type='hidden' name='street_address2' value='<?php echo Utility::short_text($user_data["address"]["address"],64,64); ?>' >
    <input type='hidden' name='city' value='<?php echo Utility::short_text($user_data["address"]["city"],0,64); ?>' >
    <input type='hidden' name='state' value='<?php echo $user_data["address"]["counti"]; ?>' >
    <input type='hidden' name='zip' value='<?php echo $user_data["address"]["zipcode"]; ?>' >
    <input type='hidden' name='country' value='<?php echo $user_data["address"]["country_code"]; ?>' >
    <input type='hidden' name='email' value='<?php echo $email; ?>' >
    <input type='hidden' name='phone' value='<?php echo $user_data["gsm"]; ?>' >
    <input type='hidden' name='phone_extension' value='<?php echo $user_data["gsm_cc"]; ?>' >
    <input type='hidden' name='currency_code' value='<?php echo $currency; ?>'>
    <input type='hidden' name='lang' value='<?php echo Utility::short_text($user_data["lang"],0,2); ?>'>
    <input type='hidden' name='merchant_order_id' value='<?php echo $module->checkout["id"]; ?>'>

    <?php
        $items          = [];
        if($checkout_items && is_array($checkout_items)){
            foreach($checkout_items AS $k=>$item){
                $options            = $item["options"];
                $items[] = [
                    'name'          => $item["name"],
                    'description'   => $item["options"]["category"],
                    'price'         => $item["amount"],
                    'quantity'      => $item["quantity"],
                ];

                if(isset($options["addons"]) && $options["addons"]){
                    foreach($options["addons"] AS $ad=>$selected){
                        $addon  = Products::addon($ad);
                        if($addon){
                            $adopts = $addon["options"];
                            foreach($adopts AS $opt){
                                if($selected == $opt["id"]){
                                    $ad_amount     = Money::formatter($opt["amount"],$opt["cid"],true);
                                    $ad_amount     = Money::deformatter($ad_amount);

                                    if(!$ad_amount) continue;
                                    $periodic   = View::period($opt["period_time"],$opt["period"]);
                                    $name       = $opt["name"];
                                    $show_name  = $addon["name"]." - ".$name;

                                    $items[] = [
                                        'name' => "- ".$show_name,
                                        'price' => $ad_amount,
                                    ];
                                }
                            }
                        }
                    }
                }
            }

            $total_discount_amount = 0;
            if(isset($checkout_data["discounts"])){
                $discounts = $checkout_data["discounts"] ? $checkout_data["discounts"] : [];
                if($discounts){
                    $itemsx  = $discounts["items"];
                    if(isset($itemsx["coupon"]) && $itemsx["coupon"])
                        foreach($itemsx["coupon"] AS $item) $total_discount_amount += $item["amountd"];

                    if(isset($itemsx["dealership"]) && $itemsx["dealership"])
                        foreach($itemsx["dealership"] AS $item) $total_discount_amount += $item["amountd"];
                }
            }
            if($total_discount_amount){
                $items[] = [
                    'type' => "coupon",
                    'name' => "Discount",
                    'price' => $total_discount_amount,
                ];
            }

            if(isset($checkout_data["sendbta_amount"]) && $checkout_data["sendbta_amount"]>0){
                $items[] = [
                    'name' => __("website/basket/send-bill-to-address"),
                    'price' => $checkout_data["sendbta_amount"],
                ];
            }

            if(isset($checkout_data["pmethod_commission"]) && $checkout_data["pmethod_commission"]>0){
                $items[] = [
                    'name' => __("website/basket/payment-method-commission",['{name}' => $module->lang['invoice-name']])." (%".$checkout_data["pmethod_commission_rate"].")",
                    'price' => $checkout_data["pmethod_commission"],
                ];
            }

            if(isset($checkout_data["tax"]) && $checkout_data["tax"]>0){
                $items[] = [
                    'type' => "tax",
                    'name' => __("website/basket/tax-amount",['{rate}' => $checkout_data["taxrate"]]),
                    'price' => $checkout_data["tax"],
                ];
            }



            if($items){
                foreach($items AS $k=>$item){
                    ?>

                    <input type='hidden' name='li_<?php echo $k; ?>_type' value='<?php echo isset($item["type"]) ? $item["type"] : "product"; ?>' >
                    <input type='hidden' name='li_<?php echo $k; ?>_name' value='<?php echo $item["name"]; ?>' >
                    <?php
                    if(isset($item["description"])){
                        ?><input type='hidden' name='li_<?php echo $k; ?>_description' value='<?php echo $item["description"]; ?>' ><?php
                    }

                    ?>

                    <input type='hidden' name='li_<?php echo $k; ?>_price' value='<?php echo number_format($item["price"],2,'.',''); ?>'>
                    <input type='hidden' name='li_<?php echo $k; ?>_quantity' value='<?php echo isset($item["quantity"]) ? $item["quantity"] : 1; ?>' >
                    <input type='hidden' name='li_<?php echo $k; ?>_tangible' value='N' >

                    <?php
                }
            }

        }
        if($sandbox)
        {
            ?><input type="hidden" name="demo" value="Y" /><?php
        }
    ?>
    <input style="display: none" id="submit_button" type='submit' value='Checkout' >
</form>