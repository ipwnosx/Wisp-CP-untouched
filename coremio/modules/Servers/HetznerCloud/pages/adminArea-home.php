<?php
    $LANG           = $module->lang;
    $established    = false;
    $options        = $order["options"];
    $creation_info  = isset($options["creation_info"]) ? $options["creation_info"] : [];
    $config         = isset($options["config"]) ? $options["config"] : [];
    if($config && isset($config[$module->entity_id_name]) && $config[$module->entity_id_name]) $established = true;
    $buttons        =  $module->adminArea_buttons_output();

    if($established){
        $server_detail      = $module->server_detail();
        $server_status      = $module->server_status();
        $limits             = $module->addon_limits();

        ?>
        <style type="text/css">
            .hostbtn{width:150px;padding:17px 20px;background:#eee;display:inline-block;margin:5px;vertical-align:top;border-radius:3px;font-weight:600;text-align:center}
            .hostbtn i{margin-right:0;display:block;font-size:32px;margin-bottom:10px}
        </style>
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
                    if(!$server_status && $module->error)
                    {
                        ?>
                        <div class="red-info">
                            <div class="padding10"><?php echo $module->error; ?></div>
                        </div>
                        <?php
                    }

                    elseif($server_status == 'running')
                    {
                        ?>
                        <span class="statusonline"><?php echo $LANG["server-on"]; ?></span>
                        <?php
                    }
                    elseif($server_status == 'off')
                    {
                        ?>
                        <span style="color: #fff;background: #F44336;font-size: 13px;padding: 4px 20px;-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;font-weight: bold;"><?php echo $LANG["server-off"]; ?></span>
                        <?php
                    }
                    else
                    {
                        ?>
                        <span class="statusother"><?php echo Utility::ucfirst($server_status); ?></span>
                        <?php
                    }
                ?>
            </div>
        </div>


        <div class="formcon" id="hetzner_processes">
            <div class="yuzde30"><?php echo $LANG["processes"]; ?></div>
            <div class="yuzde70">
                <?php echo $buttons; ?>
            </div>
        </div>


        <div class="formcon" id="hetzner_management">
            <div class="yuzde30"><?php echo $LANG["management"]; ?></div>
            <div class="yuzde70">
                
                        <a href="javascript:void 0;" class="hostbtn" onclick="open_m_page('rebuild');"><i class="fa fa-wrench" aria-hidden="true"></i><?php echo $LANG["tx81"]; ?></a>

                        <a href="javascript:void 0;" class="hostbtn" onclick="open_m_page('console');"><i class="fa fa-window-maximize" aria-hidden="true"></i><?php echo $LANG["tx82"]; ?></a>

                        <a href="javascript:void 0;" class="hostbtn" onclick="open_m_page('reverse-dns');"><i class="fa fa-globe" aria-hidden="true"></i><?php echo $LANG["tx83"]; ?></a>

                        <a href="javascript:void 0;" class="hostbtn" onclick="open_m_page('floating-ips');"><i class="fa fa-wifi" aria-hidden="true"></i><?php echo $LANG["tx84"]; ?></a>

                        <a href="javascript:void 0;" class="hostbtn" onclick="open_m_page('backups');"><i class="fa fa-floppy-o" aria-hidden="true"></i><?php echo $LANG["tx86"]; ?></a>

                        <a href="javascript:void 0;" class="hostbtn" onclick="open_m_page('snapshots');"><i class="fa fa-camera-retro" aria-hidden="true"></i><?php echo $LANG["tx87"]; ?></a>

                        <a href="javascript:void 0;" class="hostbtn" onclick="open_m_page('isos');"><i class="fa fa-picture-o" aria-hidden="true"></i><?php echo $LANG["tx88"]; ?></a>

                <a href="javascript:void 0;" class="hostbtn" onclick="open_m_page('volumes');"><i class="fa fa-server" aria-hidden="true"></i><?php echo $LANG["tx117"]; ?></a>

                 </div>
        </div>

        <div class="clear"></div>

        <div class="formcon">
            <div class="yuzde30"><?php echo __("admin/orders/hosting-config-username"); ?></div>
            <div class="yuzde60">
                <?php echo isset($options["login"]["username"]) ? $options["login"]["username"] : 'root'; ?>
            </div>
        </div>

        <div class="formcon">
            <div class="yuzde30"><?php echo __("admin/orders/hosting-config-password"); ?></div>
            <div class="yuzde60">
                <?php echo isset($options["login"]["username"]) ? $module->hdc($options["login"]["password"]) : ___("needs/unknown"); ?>
            </div>
        </div>


        <div class="formcon">
            <div class="yuzde30">IPv4</div>
            <div class="yuzde60">
                <input style="width:200px;" type="text" name="ipv4_ip" value="<?php echo $options["ip"]; ?>">
            </div>
        </div>

        <div class="formcon">
            <div class="yuzde30">IPv6</div>
            <div class="yuzde60">
                <?php echo $server_detail["public_net"]["ipv6"]["ip"];  ?>
            </div>
        </div>

        <div class="formcon">
            <div class="yuzde30">Hostname</div>
            <div class="yuzde60">
                <?php echo $server_detail["public_net"]["ipv4"]["dns_ptr"]; ?>
            </div>
        </div>

        <div class="formcon">
            <div class="yuzde30"><?php echo $LANG["tx72"]; ?></div>
            <div class="yuzde60">
                <input style="width:50px;text-align: center;padding: 5px 0px;border-radius: 4px;font-weight: 600;" type="text" readonly value="<?php echo $limits['snapshots'] > 0 ? $limits['snapshots'] : '0'; ?>">
                <a class="sbtn" href="javascript:void $('.tablinks[data-tab=addons]').click(); void 0;"><i class="fa fa-pencil"></i></a>
                <span style="font-size:14px;" class="kinfo"><?php echo $LANG["tx73"]; ?></span>
            </div>
        </div>

        <div class="formcon">
            <div class="yuzde30"><?php echo $LANG["tx75"]; ?></div>
            <div class="yuzde60">
                <input style="width:50px;text-align: center;padding: 5px 0px;border-radius: 4px;font-weight: 600;" type="text" readonly value="<?php echo $limits['floating_ips'] > 0 ? $limits['floating_ips'] : '0'; ?>">
                <a class="sbtn" href="javascript:void $('.tablinks[data-tab=addons]').click(); void 0;"><i class="fa fa-pencil"></i></a>
                <span class="kinfo" style="font-size:14px;"><?php echo $LANG["tx76"]; ?></span>
            </div>
        </div>

        <div class="formcon">
            <div class="yuzde30"><?php echo $LANG["tx108"]; ?></div>
            <div class="yuzde60">
                <input style="width:50px;text-align: center;padding: 5px 0px;border-radius: 4px;font-weight: 600;" type="text" readonly value="<?php echo $limits['volume'] > 0 ? $limits['volume'] : '0'; ?>">
                <a class="sbtn" href="javascript:void $('.tablinks[data-tab=addons]').click(); void 0;"><i class="fa fa-pencil"></i></a>
                <span class="kinfo" style="font-size:14px;"><?php echo $LANG["tx118"]; ?></span>
            </div>
        </div>

        <div class="formcon">
            <div class="yuzde30"><?php echo $LANG["tx69"]; ?></div>
            <div class="yuzde60">
                <input<?php echo isset($server_detail["backup_window"]) && $server_detail["backup_window"] ? ' checked' :  ''; ?> type="checkbox" class="checkbox-custom" id="enable_backup" name="enable_backup" value="1">
                <label class="checkbox-custom-label" for="enable_backup"><span style="font-size:14px;" class="kinfo"><?php echo $LANG["tx70"]; ?></span></label>
                <?php echo isset($server_detail["backup_window"]) && $server_detail["backup_window"] ? '<br><span style="color:indianred;"><i class="fa fa-exclamation-circle"></i> '.$module->lang["tx103"].'</span>' : ''; ?>
            </div>
        </div>

        <div class="formcon">
            <div class="yuzde30"><?php echo $LANG["tx77"]; ?></div>
            <div class="yuzde60">
                <strong style="margin-right: 10px;"><?php echo isset($server_detail["server_type"]["description"]) ? $server_detail["server_type"]["description"] : '!'; ?></strong>
                <a class="lbtn" href="javascript:void $('.tablinks[data-tab=updown]').click();"><i class="fa fa-refresh" style="margin-right:5px;"></i> <?php echo $LANG["tx78"]; ?></a>
            </div>
        </div>

        <div class="formcon">
            <div class="yuzde30"><?php echo $LANG["tx131"]; ?></div>
            <div class="yuzde60">
                <strong style="margin-right:10px;"><?php echo isset($server_detail["image"]["description"]) ? $server_detail["image"]["description"] : ___("needs/unknown"); ?></strong>
                <a class="lbtn" href="javascript:void 0;" onclick="open_m_page('rebuild');"><i class="fa fa-wrench" style="margin-right:5px;"></i> <?php echo $LANG["tx81"]; ?></a>
            </div>
        </div>

        <div class="formcon">
            <div class="yuzde30"><?php echo $LANG["tx79"]; ?> / <?php echo $LANG["tx80"]; ?></div>
            <div class="yuzde60">
                <?php echo isset($server_detail["datacenter"]["location"]["city"]) ? $server_detail["datacenter"]["location"]["city"] : 'N/A'; ?> / <?php echo isset($server_detail["datacenter"]["name"]) ? $server_detail["datacenter"]["name"] : 'N/A'; ?>
            </div>
        </div>

        <div class="formcon">
            <div class="yuzde30"><?php echo $LANG["tx132"]; ?></div>
            <div class="yuzde60">
                <?php echo isset($server_detail["server_type"]["cores"]) ? $server_detail["server_type"]["cores"] : 'N/A'; ?>
            </div>
        </div>

        <div class="formcon">
            <div class="yuzde30"><?php echo $LANG["tx133"]; ?></div>
            <div class="yuzde60">
                <?php echo isset($server_detail["server_type"]["memory"]) ? $server_detail["server_type"]["memory"] : 'N/A'; ?> GB
            </div>
        </div>

        <div class="formcon">
            <div class="yuzde30"><?php echo $LANG["tx134"]; ?></div>
            <div class="yuzde60">
                <?php echo isset($server_detail["server_type"]["disk"]) ? $server_detail["server_type"]["disk"] : 'N/A'; ?> GB
            </div>
        </div>

        <div class="formcon">
            <div class="yuzde30"><?php echo $LANG["tx135"]; ?></div>
            <div class="yuzde60"><?php echo isset($options["server_features"]["bandwidth"]) ? $options["server_features"]["bandwidth"] : 'Unlimited'; ?></div>
        </div>


        <?php
    }

?>
<div class="clear"></div>

<div class="formcon">
    <div class="yuzde30">Server ID</div>
    <div class="yuzde70">
        <input style="width:200px;" type="text" name="config[<?php echo $module->entity_id_name; ?>]" value="<?php echo isset($config[$module->entity_id_name]) ? $config[$module->entity_id_name] : ''; ?>">
    </div>
</div>

<div style="<?php echo $established ? 'display:none;' : ''; ?>">
    <?php
        if(method_exists($module,"config_options") && $config_options = $module->config_options($creation_info))
            $module->config_options_output($config_options,'creation_info');
    ?>
</div>

<div class="clear"></div>
<div class="line"></div>