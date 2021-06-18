<?php
    $LANG           = $module->lang;
    $established    = false;
    $options        = $order["options"];
    $creation_info  = isset($options["creation_info"]) ? $options["creation_info"] : [];
    $config         = isset($options["config"]) ? $options["config"] : [];
    if($config && isset($config[$module->entity_id_name])) $established = true;
    $buttons        =  $module->adminArea_buttons_output();
    $statistics     = $module->adminArea_statistics();

?>

<?php

    if($established)
    {
        ?>
        <div class="formcon">
            <div class="yuzde30"><?php echo $LANG["server-status"]; ?></div>
            <div class="yuzde70">
                <style type="text/css">
                    .statusonline{color:#fff;background: #8bc34a;font-size:13px;padding:4px 20px;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;font-weight:bold;animation:shadow-pulse 1s infinite;}
                    @keyframes shadow-pulse{0%{box-shadow: 0 0 0 0px rgb(158 215 92 / 67%);}
                        100%{box-shadow: 0 0 0 8px rgb(0 0 0 / 0%);}
                    }
                </style>
                <?php
                    $server_status = $module->get_status();
                    if(!$server_status && $module->error){
                        ?>
                        <div class="red-info">
                            <div class="padding10"><?php echo $module->error; ?></div>
                        </div>
                        <?php
                    }elseif($server_status){
                        ?>
                        <span class="statusonline"><?php echo $LANG["server-on"]; ?></span>
                        <?php
                    }else{
                        ?>
                        <span style="color: #fff;background: #F44336;font-size: 13px;padding: 4px 20px;-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;font-weight: bold;"><?php echo $LANG["server-off"]; ?></span>
                        <?php
                    }
                ?>
            </div>
        </div>
        <?php
    }

    if($established && $statistics)
    {
        extract($statistics);
        ?>
        <div class="clear"></div>
        <div class="formcon">
            <div class="yuzde30"><?php echo $LANG["statistics"]; ?></div>
            <div class="yuzde70">


                <?php
                    $limit          = $hdd_limit;
                    $used           = $hdd_used;
                    $percent        = $hdd_limit > 0 ? Utility::getPercent($used,$limit) : 0;
                    if($percent > 100) $percent = 100;

                ?>
                <div style="margin:20px; display:inline-block;text-align: center;">
                    <h5 style="font-size:16px;"><strong>HDD</strong></h5>
                    <div class="clear"></div>
                    <div class="progress-circle progress-<?php echo $percent; ?>"><span><?php echo $percent; ?></span></div>
                    <div class="clear"></div>
                    <h5 style="font-size:16px;"><?php echo $used.' MB'; ?> / <?php echo $limit > 0 ? $limit.' MB' : '∞'; ?></h5>
                </div>

                <?php
                    $limit          = $ram_limit;
                    $used           = $ram_used;
                    $percent        = $ram_limit > 0 ? Utility::getPercent($used,$limit) : 0;
                    if($percent > 100) $percent = 100;

                ?>
                <div style="margin:20px; display:inline-block;text-align: center;">
                    <h5 style="font-size:16px;"><strong>RAM</strong></h5>
                    <div class="clear"></div>
                    <div class="progress-circle progress-<?php echo $percent; ?>"><span><?php echo $percent; ?></span></div>
                    <div class="clear"></div>
                    <h5 style="font-size:16px;"><?php echo $used.' MB'; ?> / <?php echo $limit > 0 ? $limit.' MB' : '∞'; ?></h5>
                </div>

                <?php
                    $limit          = $cpu_limit;
                    $used           = $cpu_used;
                    $percent        = $cpu_limit > 0 ? Utility::getPercent($used,$limit) : 0;
                    if($percent > 100) $percent = 100;

                ?>
                <div style="margin:20px; display:inline-block;text-align: center;">
                    <h5 style="font-size:16px;"><strong>CPU</strong></h5>
                    <div class="clear"></div>
                    <div class="progress-circle progress-<?php echo $percent; ?>"><span><?php echo $percent; ?></span></div>
                    <div class="clear"></div>
                    <h5 style="font-size:16px;"><?php echo $used.' Mhz'; ?> / <?php echo $limit > 0 ? $limit.' Mhz' : '∞'; ?></h5>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <?php
    }

    if($buttons){
        ?>
        <div class="formcon">
            <div class="yuzde30"><?php echo $LANG["operations"]; ?></div>
            <div class="yuzde70">
                <?php echo $buttons; ?>
            </div>
        </div>
        <div class="clear"></div>
        <?php
    }
?>
<div class="clear"></div>

<div class="formcon">
    <div class="yuzde30">VM ID</div>
    <div class="yuzde70">
        <input class="yuzde10" type="text" name="config[<?php echo $module->entity_id_name; ?>]" value="<?php echo isset($config[$module->entity_id_name]) ? $config[$module->entity_id_name] : ''; ?>">
    </div>
</div>

<div class="formcon">
    <div class="yuzde30">Client Secret Key</div>
    <div class="yuzde70">
        <input type="text" class="yuzde50" name="config[client_secret_key]" value="<?php echo isset($config["client_secret_key"]) ? $config["client_secret_key"] : ''; ?>">
        <?php
            if(!isset($config["client_secret_key"]) || !$config["client_secret_key"] && isset($options["login"]["username"]) && $options["login"]["username"])
            {
                ?>
                <a href="javascript:void 0;" onclick="if(confirm('<?php echo addslashes(___("needs/apply-are-you-sure")); ?>')) run_transaction('generate_client_secret_key',this);" class="lbtn"><i style="margin-right: 7px;" class="fa fa-refresh"></i><?php echo $LANG["new-client-secret-key"]; ?></a>
                <?php
            }
        ?>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        <?php if($established): ?>
        $('#configurable_wrap > .yuzde50').not("#wrap-el-cpu,#wrap-el-disk,#wrap-el-memory,#wrap-el-swap,#wrap-el-io,#wrap-el-databases,#wrap-el-backups,#wrap-el-allocations,#wrap-el-oom_disabled").css({
            'opacity'           : '.5',
            'cursor'            : 'not-allowed',
            'pointer-events'    : 'none',
        });
        <?php endif; ?>
    });
</script>


<div class="formcon">
    <div class="yuzde30"><?php echo $LANG["change-password"]; ?></div>
    <div class="yuzde70">
        <input type="text" class="yuzde30" name="creation_info[new_password]" value="">

        <a href="javascript:void(0);" onclick="$('input[name=\'creation_info[new_password]\']').val(randString({characters:'A-Z,a-z,0-9,#'})); void 0;" class="lbtn"><?php echo __("website/account_products/new-random-password"); ?></a>

    </div>
</div>

<?php if($established): ?>
    <div class="blue-info" style="    margin-top: 25px;    font-weight: 600;">
        <div class="padding20">
            <i class="fa fa-info-circle" style="    font-size: 34px;    margin: -5px 25px 15px 10px;"></i>
            <p><?php echo $LANG["change-warning"]; ?></p>
        </div>
    </div>
<?php endif; ?>


<?php
    if(method_exists($module,"adminArea_service_fields") && $config_options = $module->adminArea_service_fields())
        $module->config_options_output($config_options,'creation_info');
?>
<div class="clear"></div>

<div id="configurable_wrap">
    <?php
        if(method_exists($module,"config_options") && $config_options = $module->config_options($creation_info))
            $module->config_options_output($config_options,'creation_info');
    ?>

</div>