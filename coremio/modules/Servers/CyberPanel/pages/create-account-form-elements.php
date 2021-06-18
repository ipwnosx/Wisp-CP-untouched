<?php
    $LANG           = $module->lang;
    $product        = isset($product) && $product ? $product : [];
    $module_data    = isset($product["module_data"]) ? Utility::jdecode($product["module_data"],true) : [];
    $create_account = isset($module_data["create_account"]) ? $module_data["create_account"] : $module_data;
    $selected_plan  = isset($create_account["plan"]) ? $create_account["plan"] : "Default";
    $websitesLimit  = isset($create_account["websitesLimit"]) ? $create_account["websitesLimit"] : 1;
    $acl            = isset($create_account["acl"]) ? $create_account["acl"] : 'user';

?>
<div class="formcon">
    <div class="yuzde30"><?php echo $LANG["plan-name"]; ?></div>
    <div class="yuzde70">
        <input type="text" name="module_data[plan]" value="<?php echo $selected_plan; ?>" placeholder="Default">
    </div>
</div>

<div class="formcon">
    <div class="yuzde30">Website Limit</div>
    <div class="yuzde70">
        <input type="text" name="module_data[websitesLimit]" value="<?php echo $websitesLimit; ?>" placeholder="1">
    </div>
</div>

<div class="formcon">
    <div class="yuzde30">ACL</div>
    <div class="yuzde70">
        <input type="text" name="module_data[acl]" value="<?php echo $acl; ?>" placeholder="1">
    </div>
</div>