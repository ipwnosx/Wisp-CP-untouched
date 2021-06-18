<div class="formcon">
    <div class="yuzde30"><?php echo __("admin/orders/subscription-identifier"); ?></div>
    <div class="yuzde70">
        <input type="text" name="subscription[identifier]" placeholder="" value="<?php echo $subscription["identifier"]; ?>">
    </div>
</div>

<?php
    $cancel_str     = $subscription["status"] != "cancelled" ? ' <a class="lbtn red" style="margin-left:5px;" href="javascript:void 0;" onclick="cancel_subscription_addon(this,'.$subscription["id"].','.$addon["id"].');">'.__("admin/orders/subscription-cancel-btn").'</a>' : '';
    ?>
<div class="formcon">
    <div class="yuzde30"><?php echo __("admin/orders/subscription-status"); ?></div>
    <div class="yuzde70">
        <?php echo $subscription_situations[$subscription["status"]]; ?>
        <?php echo $cancel_str; ?>

        <?php
            if($subscription["status_msg"])
            {
                ?>
                <p><?php echo $subscription["status_msg"]; ?></p>
                <?php
            }
        ?>

    </div>
</div>


<?php
    $y = substr($subscription["created_at"],0,4);
    if($y != "0000" && $y != "1881")
    {
        $y_c = DateManager::format(Config::get("options/date-format")." H:i",$subscription["created_at"]);
    }
    else
        $y_c = ___("needs/unknown");
?>
<div class="formcon">
    <div class="yuzde30"><?php echo __("admin/orders/subscription-first-payment"); ?></div>
    <div class="yuzde70">
        <strong><?php echo Money::formatter_symbol($subscription["first_paid_fee"],$subscription["currency"]); ?></strong>
        -
        <span><?php echo $y_c; ?></span>
    </div>
</div>


<?php
    $y = substr($subscription["last_paid_date"],0,4);
    if($y != "0000" && $y != "1881")
    {
        $y_c = DateManager::format(Config::get("options/date-format")." H:i",$subscription["last_paid_date"]);
    }
    else
        $y_c = ___("needs/unknown");
?>


<div class="formcon">
    <div class="yuzde30"><?php echo __("admin/orders/subscription-last-payment"); ?></div>
    <div class="yuzde70">
        <strong>
            <?php echo Money::formatter_symbol($subscription["last_paid_fee"],$subscription["currency"]); ?>
        </strong>
        -
        <span>
            <?php echo $y_c; ?>
        </span>
    </div>
</div>


<?php
    $y = substr($subscription["next_payable_date"],0,4);
    if($y != "0000" && $y != "1881")
    {
        $y_c = DateManager::format(Config::get("options/date-format")." H:i",$subscription["next_payable_date"]);
    }
    else
        $y_c = ___("needs/unknown");
?>
<div class="formcon">
    <div class="yuzde30"><?php echo __("admin/orders/subscription-next-payment"); ?></div>
    <div class="yuzde70">
        <strong>
            <?php echo Money::formatter_symbol($subscription["next_payable_fee"],$subscription["currency"]); ?>
        </strong>
        -
        <span><?php echo $y_c; ?></span>
    </div>
</div>