<?php
    if(!isset($LANG)) $LANG = [];
    if(!isset($buttons)) $buttons = [];
    if(!isset($detail)) $detail = [];
    if(!isset($configuration)) $configuration = [];
    if(!isset($limits)) $limits = [];
    if(!isset($limits)) $limits = [];
    if(!isset($root_password)) $root_password = '';
    $status         = isset($detail["status"]) ? $detail["status"] : false;
?>
<script type="text/javascript">
    $(document).ready(function(){
        $(".service-status-con").css("display","none");

        <?php if($status == "running"): ?>
        $("#server_status_online").css("display","block");
        <?php elseif($status == 'off'): ?>
        $("#server_status_offline").css("display","block");
        <?php else: ?>
        $("#server_status_other").css("display","block").html('<span class="statusother"><?php echo ucfirst($status); ?></span>');
        <?php endif; ?>

    });
</script>

<div class="serverserviceblock">

    <div class="serverserviceblock-title"><h4><?php echo $LANG["tx138"]; ?></h4></div>

    <?php echo $buttons; ?>

</div>
<div class="serverserviceblock">

    <div class="serverserviceblock-title"><h4><?php echo $LANG["tx139"]; ?></h4></div>

    <?php
        if($configuration["client_rebuild"])
        {
            ?>
            <a href="javascript:void 0;" class="hostbtn" onclick="reload_module_content('rebuild');"><i class="fa fa-wrench" aria-hidden="true"></i><?php echo $LANG["tx81"]; ?></a>
            <?php
        }

        if($configuration["client_console"])
        {
            ?>
            <a href="javascript:void 0;" class="hostbtn" onclick="reload_module_content('console');"><i class="fa fa-window-maximize" aria-hidden="true"></i><?php echo $LANG["tx82"]; ?></a>
            <?php
        }


        if($configuration["client_reverse_dns"])
        {
            ?>
            <a href="javascript:void 0;" class="hostbtn" onclick="reload_module_content('reverse-dns');"><i class="fa fa-globe" aria-hidden="true"></i><?php echo $LANG["tx83"]; ?></a>
            <?php
        }

        if($limits['floating_ips'] > 0)
        {
            ?>
            <a href="javascript:void 0;" class="hostbtn" onclick="reload_module_content('floating-ips');"><i class="fa fa-wifi" aria-hidden="true"></i><?php echo $LANG["tx84"]; ?></a>
            <?php
        }

        if($limits['backup'] && isset($detail["backup_window"]) && $detail["backup_window"])
        {
            ?>
            <a href="javascript:void 0;" class="hostbtn" onclick="reload_module_content('backups');"><i class="fa fa-floppy-o" aria-hidden="true"></i><?php echo $LANG["tx86"]; ?></a>
            <?php
        }

        if($limits['snapshots'] > 0)
        {
            ?>
            <a href="javascript:void 0;" class="hostbtn" onclick="reload_module_content('snapshots');"><i class="fa fa-camera-retro" aria-hidden="true"></i><?php echo $LANG["tx87"]; ?></a>
            <?php
        }
    ?>

    <?php
        if($configuration["client_iso"])
        {
            ?>
            <a href="javascript:void 0;" class="hostbtn" onclick="reload_module_content('isos');"><i class="fa fa-picture-o" aria-hidden="true"></i><?php echo $LANG["tx88"]; ?></a>
            <?php
        }
    ?>

</div>
<div class="serverserviceblock">

    <div class="serverserviceblock-title"><h4><?php echo $LANG["tx130"]; ?></h4></div>

    <div class="formcon">
        <div class="serverdetailleft"><?php echo __("website/account_products/server-login-username"); ?></div>
        <div class="serverdetailright"><?php echo isset($order_options["login"]["username"]) ? $order_options["login"]["username"] : 'root'; ?></div>
    </div>

    <div class="formcon">
        <div class="serverdetailleft"><?php echo __("website/account_products/server-login-password"); ?></div>
        <div class="serverdetailright"><?php echo isset($order_options["login"]["password"]) ? $root_password : 'root'; ?></div>
    </div>

    <div class="formcon">
        <div class="serverdetailleft">IPv4</div>
        <div class="serverdetailright"><?php echo isset($detail["public_net"]["ipv4"]["ip"]) ? $detail["public_net"]["ipv4"]["ip"] : ___("needs/unknown"); ?></div>
    </div>

    <div class="formcon">
        <div class="serverdetailleft">IPv6</div>
        <div class="serverdetailright"><?php echo isset($detail["public_net"]["ipv6"]["ip"]) ? $detail["public_net"]["ipv6"]["ip"] : ___("needs/unknown"); ?></div>
    </div>

    <div class="formcon">
        <div class="serverdetailleft"><?php echo $LANG["tx140"]; ?></div>
        <div class="serverdetailright"><?php echo isset($detail["public_net"]["ipv4"]["dns_ptr"]) ? $detail["public_net"]["ipv4"]["dns_ptr"] : ___("needs/unknown"); ?></div>
    </div>

    <?php
        if($limits['snapshots'] > 0 || $configuration["order_step_snapshots"])
        {
            ?>
            <div class="formcon">
                <div class="serverdetailleft"><?php echo $LANG["tx72"]; ?></div>
                <div class="serverdetailright">
                    <?php echo $limits["snapshots"] > 0 ? $limits["snapshots"] : ___("needs/none"); ?>
                    <?php
                        if($configuration["order_step_snapshots"]){
                            ?><a href="javascript:$('.tablinks[data-tab=addons]').click();$('html,body').scrollTop(0);void 0;" class="sbtn green"><i class="fa fa-plus"></i> <?php echo $LANG["tx136"]; ?></a><?php
                        }
                    ?>
                </div>
            </div>
            <?php
        }

        if($limits['floating_ips'] > 0 || $configuration["order_step_floating_ips"])
        {
            ?>
            <div class="formcon">
                <div class="serverdetailleft"><?php echo $LANG["tx75"]; ?></div>
                <div class="serverdetailright">
                    <?php echo $limits["floating_ips"] > 0 ? $limits["floating_ips"] : ___("needs/none"); ?>
                    <?php
                        if($configuration["order_step_floating_ips"]){
                            ?><a href="javascript:$('.tablinks[data-tab=addons]').click();$('html,body').scrollTop(0);void 0;" class="sbtn green"><i class="fa fa-plus"></i> <?php echo $LANG["tx136"]; ?></a><?php
                        }
                    ?>
                </div>
            </div>
            <?php
        }

        if($limits['volume'] > 0 || $configuration["order_step_volume"])
        {
            ?>
            <div class="formcon">
                <div class="serverdetailleft"><?php echo $LANG["tx108"]; ?></div>
                <div class="serverdetailright">
                    <?php echo $limits["volume"] > 0 ? $limits["volume"] : ___("needs/none"); ?>
                    <?php
                        if($configuration["order_step_volume"]){
                            ?><a href="javascript:$('.tablinks[data-tab=addons]').click();$('html,body').scrollTop(0);void 0;" class="sbtn green"><i class="fa fa-plus"></i> <?php echo $LANG["tx136"]; ?></a><?php
                        }
                    ?>
                </div>
            </div>
            <?php
        }

        if($configuration["order_step_backup"] || $limits['backup'])
        {
            ?>
            <div class="formcon">
                <div class="serverdetailleft"><?php echo $LANG["tx69"]; ?></div>
                <div class="serverdetailright">
                    <?php echo isset($detail["backup_window"]) && $detail["backup_window"] ? ___("needs/yes") : ___("needs/no"); ?>
                    <?php
                        if((!isset($detail["backup_window"]) || !$detail["backup_window"]) && $configuration["order_step_backup"])
                        {
                            ?>
                            <a href="javascript:$('.tablinks[data-tab=addons]').click();$('html,body').scrollTop(0);void 0;" class="sbtn green"><i class="fa fa-check"></i> <?php echo $LANG["tx137"]; ?></a>
                            <?php
                        }
                    ?>
                </div>
            </div>
            <?php
        }
    ?>

    <div class="formcon">
        <div class="serverdetailleft"><?php echo $LANG["tx131"]; ?></div>
        <div class="serverdetailright">
            <?php echo isset($detail["image"]["description"]) ? $detail["image"]["description"] : ___("needs/unknown"); ?>
            <?php
                if($configuration['client_rebuild'])
                {
                    ?><a class="sbtn" href="javascript:void 0;" onclick="reload_module_content('rebuild');"><i class="fa fa-wrench"></i> <?php echo $LANG["tx81"]; ?></a><?php
                }
            ?>
        </div>
    </div>

    <div class="formcon">
        <div class="serverdetailleft"><?php echo $LANG["tx132"]; ?></div>
        <div class="serverdetailright"><?php echo isset($detail["server_type"]["cores"]) ? $detail["server_type"]["cores"] : 'N/A'; ?></div>
    </div>

    <div class="formcon">
        <div class="serverdetailleft"><?php echo $LANG["tx133"]; ?></div>
        <div class="serverdetailright"><?php echo isset($detail["server_type"]["memory"]) ? $detail["server_type"]["memory"] : 'N/A'; ?> GB</div>
    </div>

    <div class="formcon">
        <div class="serverdetailleft"><?php echo $LANG["tx134"]; ?></div>
        <div class="serverdetailright"><?php echo isset($detail["server_type"]["disk"]) ? $detail["server_type"]["disk"]  : 'N/A'; ?> GB</div>
    </div>

    <div class="formcon">
        <div class="serverdetailleft"><?php echo $LANG["tx135"]; ?></div>
        <div class="serverdetailright"><?php echo isset($order_options["server_features"]["bandwidth"]) ? $order_options["server_features"]["bandwidth"] : 'Unlimited'; ?></div>
    </div>

</div>





<style>
    .serverserviceblock{display:inline-block;width:100%;margin-bottom:30px}
    .serverserviceblock .formcon{padding:12px 0px;font-size:15px;border-bottom: 1px solid #eee;}
    .serverserviceblock .formcon .yuzde40{text-align:right;font-weight:600;width:49%;margin-right:15px}
    .serverserviceblock .formcon .yuzde50{text-align:left}
    .serverserviceblock-title{border-bottom:1px solid #eee;padding-bottom:15px;margin-bottom:35px}
    .serverserviceblock-title h4{display:inline-block;background:white;margin-top:-11px;position:absolute;left:0;right:0;margin-left:auto;margin-right:auto;width:240px;padding:10px 0px;font-weight:bold}
    .serverdetailleft{float:left;width:48%;text-align:right;font-weight:bold}
    .serverdetailright{float:right;width:49%;text-align:left}
</style>
