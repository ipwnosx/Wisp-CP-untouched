<?php if(!$reseller && isset($panel_data) && $panel_data): ?>
<div class="clear"></div>
<?php
    $limit          = substr($panel_data["disk_limit"],0,-3);
    $used           = substr($panel_data["disk_used"],0,-3);
    $percent        = $limit > 0 ? Utility::getPercent((int) $used,(int) $limit) : 0;
    if($percent > 100) $percent = 100;
?>
<div style="margin:20px;display:inline-block;text-align: center;">
    <h5 style="font-size:16px;"><strong>Disk</strong></h5>
    <div class="clear"></div>
    <div class="progress-circle progress-<?php echo $percent; ?>"><span><?php echo $percent; ?></span></div>
    <div class="clear"></div>
    <h5 style="font-size:16px;"><?php echo $used == '' ? '0 MB' : $used.' MB'; ?> / <?php echo $limit > 0 ? $limit.' MB' : '∞'; ?></h5>
</div>

<?php
    $limit          = substr($panel_data["bandwidth_limit"],0,-3);
    $used           = substr($panel_data["bandwidth_used"],0,-3);
    $percent        = $limit > 0 ? Utility::getPercent((int) $used,(int) $limit) : 0;
    if($percent > 100) $percent = 100;
?>
<div style="margin:20px;display:inline-block;text-align: center;">
    <h5 style="font-size:16px;"><strong>Bandwidth</strong></h5>
    <div class="clear"></div>
    <div class="progress-circle progress-<?php echo $percent; ?>"><span><?php echo $percent; ?></span></div>
    <div class="clear"></div>
    <h5 style="font-size:16px;"><?php echo $used == '' ? '0 MB' : $used.' MB'; ?> / <?php echo $limit > 0 ? $limit.' MB' : '∞'; ?></h5>
</div>

<?php
    $limit          = $panel_data["listeners_limit"];
    $used           = $panel_data["listeners_used"];
    $percent        = $limit > 0 ? Utility::getPercent((int) $used,(int) $limit) : 0;
    if($percent > 100) $percent = 100;

?>

<div style="margin:20px;display:inline-block;text-align: center;">
    <h5 style="font-size:16px;"><strong>Listeners</strong></h5>
    <div class="clear"></div>
    <div class="progress-circle progress-<?php echo $percent; ?>"><span><?php echo $percent; ?></span></div>
    <div class="clear"></div>
    <h5 style="font-size:16px;"><?php echo $used == '' ? '0' : $used; ?> / <?php echo $limit > 0 ? $limit : '∞'; ?></h5>
</div>

<?php
    $limit          = substr($panel_data["bitrate_limit"],0,-5);
    $used           = substr($panel_data["bitrate_used"],0,-5);
    $percent        = $limit > 0 ? Utility::getPercent((int) $used,(int) $limit) : 0;
    if($percent > 100) $percent = 100;
?>
<div style="margin:20px;display:inline-block;text-align: center;">
    <h5 style="font-size:16px;"><strong>Bitrate</strong></h5>
    <div class="clear"></div>
    <div class="progress-circle progress-<?php echo $percent; ?>"><span><?php echo $percent; ?></span></div>
    <div class="clear"></div>
    <h5 style="font-size:16px;"><?php echo $used == '' ? '0 KBPS' : $used.' KBPS'; ?> / <?php echo $limit > 0 ? $limit.' KBPS' : '∞'; ?></h5>
</div>
<?php endif; ?>
<div class="clear"></div>
<?php
    echo $buttons;
?>
<div class="clear"></div>
<br>
<?php if(!$reseller && isset($panel_data) && $panel_data): ?>
    <script type="text/javascript">
        $(document).ready(function(){
            $(".service-status-con").css("display","none");

            <?php if($panel_data["status"] == "Online"): ?>
            $("#server_status_online").css("display","block");
            <?php else: ?>
            $("#server_status_offline").css("display","block");
            <?php endif; ?>

        });
    </script>
<?php endif; ?>

<div class="formcon">
    <div class="yuzde30"><?php echo __("website/account_products/server-login-username"); ?></div>
    <div class="yuzde70">
        <?php echo $config["user"]; ?>
    </div>
</div>

<div class="formcon">
    <div class="yuzde30"><?php echo __("website/account_products/server-login-password"); ?></div>
    <div class="yuzde70">
        <?php echo $config["password"]; ?>
    </div>
</div>

<?php if(!$reseller && isset($panel_data) && $panel_data): ?>
<div class="formcon">
    <div class="yuzde30">Radio IP</div>
    <div class="yuzde70"><?php echo $panel_data["ip"]; ?></div>
</div>

<div class="formcon">
    <div class="yuzde30">Radio Port</div>
    <div class="yuzde70"><?php echo $panel_data["port"]; ?></div>
</div>
<?php endif; ?>

<?php
    if(isset($package) && $package)
    {
        array_pop($package["features"]);
        array_pop($package["features"]);

        foreach($package["features"] AS $k=>$v)
        {
            ?>
            <div class="formcon">
                <div class="yuzde30"><?php echo $k; ?></div>
                <div class="yuzde70"><?php echo $v; ?></div>
            </div>
            <?php
        }
    }
?>