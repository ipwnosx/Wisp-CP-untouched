<?php
    $LANG           = $module->lang;
    $order          = isset($order) && $order ? $order : [];
    $options        = isset($order["options"]) ? $order["options"] : [];
    $config         = isset($options["config"]) ? $options["config"] : [];
    $creation_info  = isset($options["creation_info"]) ? $options["creation_info"] : [];
    $selected_plan  = isset($creation_info["plan"]) ? $creation_info["plan"] : 'default';
    $ssh_access     = isset($creation_info["ssh_access"]) ? $creation_info["ssh_access"] : false;
    $ip_address     = isset($creation_info["ip_address"]) ? $creation_info["ip_address"] : false;

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

<?php
    if(!isset($config["user"]) || !$config["user"]){
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
                <input type="text" value="<?php echo $ip_address; ?>" name="creation_info[ip_address]">
            </div>
        </div>
        <?php
    }
?>

<div class="formcon">
    <div class="yuzde30"><?php echo $LANG["plan-name"]; ?></div>
    <div class="yuzde70">
        <input type="text" name="creation_info[plan]" value="<?php echo $selected_plan; ?>" placeholder="default">
    </div>
</div>