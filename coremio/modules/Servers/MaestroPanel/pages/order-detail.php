<?php
    $LANG           = $module->lang;
    $order          = isset($order) && $order ? $order : [];
    $options        = isset($order["options"]) ? $order["options"] : [];
    $config         = isset($options["config"]) ? $options["config"] : [];
    $creation_info  = isset($options["creation_info"]) ? $options["creation_info"] : [];
    $selected_plan  = isset($creation_info["plan"]) ? $creation_info["plan"] : 'default';
    $ssh_access     = isset($creation_info["ssh_access"]) ? $creation_info["ssh_access"] : false;
    $ip_address     = isset($creation_info["ip_address"]) ? $creation_info["ip_address"] : false;
    $set_reseller   = isset($creation_info["reseller"]) ? $creation_info["reseller"] : false;

?>

<div class="formcon">
    <div class="yuzde30"><?php echo __("admin/orders/hosting-config-username"); ?></div>
    <div class="yuzde70">
        <input name="config[user]" type="text" value="<?php echo isset($config["user"]) ? $config["user"] : ''; ?>">
        <span class="kinfo"><?php echo __("admin/orders/hosting-config-username-info"); ?></span>
    </div>
</div>

<div class="formcon">
    <div class="yuzde30"><?php echo __("admin/orders/hosting-config-password"); ?></div>
    <div class="yuzde70">
        <input name="config[password]" type="text" placeholder="*******" value="<?php echo isset($config["password"]) ? Crypt::decode($config["password"],Config::get("crypt/user")) : ''; ?>">
        <span class="kinfo"><?php echo __("admin/orders/hosting-config-password-info"); ?></span>
    </div>
</div>

<div class="formcon">
    <div class="yuzde30"><?php echo $LANG["reseller-account"]; ?></div>
    <div class="yuzde70">
        <input<?php echo $set_reseller ? ' checked' : '';?> type="checkbox" name="creation_info[reseller]" value="1" id="creation_info_reseller" class="sitemio-checkbox">
        <label for="creation_info_reseller" class="sitemio-checkbox-label"></label>
        <span class="kinfo"><?php echo $LANG['reseller-account-desc']; ?></span>
    </div>
</div>

<div class="formcon">
    <div class="yuzde30"><?php echo $LANG["plan-name"]; ?></div>
    <div class="yuzde70">
        <input type="text" name="creation_info[plan]" value="<?php echo $selected_plan; ?>" placeholder="default">
    </div>
</div>