<?php
    $LANG           = $module->lang;
    $product        = isset($product) && $product ? $product : [];
    $module_data    = isset($product["module_data"]) ? Utility::jdecode($product["module_data"],true) : [];
    $create_account = isset($module_data["create_account"]) ? $module_data["create_account"] : $module_data;
    $selected_plan  = isset($create_account["plan"]) ? $create_account["plan"] : "default";
    $ssh_access     = isset($create_account["ssh_access"]) ? $create_account["ssh_access"] : false;
    $ip_address     = isset($create_account["ip_address"]) ? $create_account["ip_address"] : false;

?>
<div class="formcon">
    <div class="yuzde30">SSH Access</div>
    <div class="yuzde70">
        <input<?php echo $ssh_access ? ' checked' : ''; ?> type="checkbox" class="sitemio-checkbox" id="ssh_access" value="1" name="module_data[ssh_access]">
        <label class="sitemio-checkbox-label" for="ssh_access"></label>
    </div>
</div>

<div class="formcon">
    <div class="yuzde30">IP Address (Optional)</div>
    <div class="yuzde70">
        <input type="text" value="<?php echo $ip_address; ?>" name="module_data[ip_address]">
    </div>
</div>


<div class="formcon">
    <div class="yuzde30"><?php echo $LANG["plan-name"]; ?></div>
    <div class="yuzde70">
        <input type="text" name="module_data[plan]" value="<?php echo $selected_plan; ?>" placeholder="default">
    </div>
</div>