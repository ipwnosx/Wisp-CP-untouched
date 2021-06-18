<?php
    $LANG           = $module->lang;
    $product        = isset($product) && $product ? $product : [];
    $module_data    = isset($product["module_data"]) ? Utility::jdecode($product["module_data"],true) : [];
    $create_account = isset($module_data["create_account"]) ? $module_data["create_account"] : $module_data;
    $selected_plan  = isset($create_account["plan"]) ? $create_account["plan"] : "default";
    $set_reseller   = isset($create_account["reseller"]) ? $create_account["reseller"] : false;

?>

<div class="formcon">
    <div class="yuzde30"><?php echo $LANG["reseller-account"]; ?></div>
    <div class="yuzde70">
        <input<?php echo $set_reseller ? ' checked' : '';?> type="checkbox" name="module_data[reseller]" value="1" id="module_data_reseller" class="sitemio-checkbox">
        <label for="module_data_reseller" class="sitemio-checkbox-label"></label>
    </div>
</div>

<div class="formcon">
    <div class="yuzde30"><?php echo $LANG["plan-name"]; ?></div>
    <div class="yuzde70">
        <input type="text" name="module_data[plan]" value="<?php echo $selected_plan; ?>" placeholder="default">
    </div>
</div>