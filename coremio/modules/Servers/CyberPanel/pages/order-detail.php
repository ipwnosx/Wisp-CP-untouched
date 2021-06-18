<?php
    $LANG           = $module->lang;
    $order          = isset($order) && $order ? $order : [];
    $options        = isset($order["options"]) ? $order["options"] : [];
    $config         = isset($options["config"]) ? $options["config"] : [];
    $creation_info  = isset($options["creation_info"]) ? $options["creation_info"] : [];
    $selected_plan  = isset($creation_info["plan"]) ? $creation_info["plan"] : 'Default';
    $websitesLimit  = isset($creation_info["websitesLimit"]) ? $creation_info["websitesLimit"] : 1;
    $acl            = isset($creation_info["acl"]) ? $creation_info["acl"] : 'user';
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
    <div class="yuzde30"><?php echo $LANG["plan-name"]; ?></div>
    <div class="yuzde70">
        <input type="text" name="creation_info[plan]" value="<?php echo $selected_plan; ?>" placeholder="Default">
    </div>
</div>

<div class="formcon">
    <div class="yuzde30">Website Limit</div>
    <div class="yuzde70">
        <input type="text" name="creation_info[websitesLimit]" value="<?php echo $websitesLimit; ?>" placeholder="1">
    </div>
</div>

<div class="formcon">
    <div class="yuzde30">ACL</div>
    <div class="yuzde70">
        <input type="text" name="creation_info[acl]" value="<?php echo $acl; ?>" placeholder="1">
    </div>
</div>