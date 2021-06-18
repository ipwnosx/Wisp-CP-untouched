<?php
    $LANG           = $module->lang;
    $options        = $order["options"];
    $creation_info  = isset($options["creation_info"]) ? $options["creation_info"] : [];
    $config         = isset($options["config"]) ? $options["config"] : [];
    $established    = isset($config["user"]) && $config["user"];
    $buttons        =  $module->adminArea_buttons_output();
    $reseller       = isset($creation_info["reseller"]) && $creation_info["reseller"];
    $panel_data     = $reseller ? [] : $module->adminArea_data();
    $packages       = $module->adminArea_packages();
?>

<?php

    if($established)
    {
        if(!$reseller && $panel_data)
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
                        $server_status = isset($panel_data["status"]) ? $panel_data["status"] : false;
                        if(!$server_status && $module->error){
                            ?>
                            <div class="red-info">
                                <div class="padding10"><?php echo $module->error; ?></div>
                            </div>
                            <?php
                        }
                        elseif($server_status == "Online"){
                            ?>
                            <span class="statusonline"><?php echo $LANG["server-on"]; ?></span>
                            <?php
                        }
                        else{
                            ?>
                            <span style="color: #fff;background: #F44336;font-size: 13px;padding: 4px 20px;-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;font-weight: bold;"><?php echo $LANG["server-off"]; ?></span>
                            <?php
                        }
                    ?>
                </div>
            </div>

            <div class="formcon">
                <div class="yuzde30">Listen Live</div>
                <div class="yuzde70">
                    <div id="player_data">
                        <audio id="stream" controls preload="none" style="width: 400px;">
                            <source src="https://<?php echo $panel_data["ip"]; ?>/<?php echo $panel_data["port"]; ?>/stream" type="audio/mpeg">
                        </audio>
                    </div>
                </div>
            </div>


            <div class="formcon">
                <div class="yuzde30"><?php echo $LANG["statistics"]; ?></div>
                <div class="yuzde70">

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

                </div>
            </div>

            <div class="clear"></div>


            <div class="formcon">
                <div class="yuzde30">Radio IP</div>
                <div class="yuzde70"><?php echo $panel_data["ip"]; ?></div>
            </div>

            <div class="formcon">
                <div class="yuzde30">Radio Port</div>
                <div class="yuzde70"><?php echo $panel_data["port"]; ?></div>
            </div>

            <div class="clear"></div>
            <?php
        }
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



    <div id="package_details">
        <div id="SonicPanel_packages">
            <?php
                if($packages)
                {
                    foreach($packages AS $g_k => $g_packages)
                    {
                        foreach($g_packages AS $g_p_k => $g_p_v)
                        {
                            ?>
                            <div class="package-details group-<?php echo $g_k; ?>" id="package-<?php echo $g_k; ?>-<?php echo $g_p_k; ?>" style="<?php echo (isset($creation_info["reseller"]) && $creation_info["reseller"] && isset($creation_info["package_r"]) && $creation_info["package_r"] == $g_p_k) || ((!isset($creation_info["reseller"]) || !$creation_info["reseller"]) && isset($creation_info["package"]) && $creation_info["package"] == $g_p_k) ? '' : 'display:none;'; ?>">
                                <?php
                                    foreach($g_p_v["features"] AS $k => $v)
                                    {
                                        ?>
                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo $k; ?></div>
                                            <div class="yuzde70"><?php echo $v; ?></div>
                                        </div>
                                        <?php
                                    }
                                ?>

                            </div>
                            <?php
                        }
                    }
                }
                else
                    echo '<div class="red-info"><div class="padding5">'.$module->error.'</div></div>';
            ?>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
            if($("#el-item-reseller").prop('checked'))
                $("#wrap-el-package_r").css("display","block");
            else
                $("#wrap-el-package_r").css("display","none");

            $("#disk_limit_container").parent().css("display","none").before($("#package_details").html());
            $("#package_details").remove();
            $("#el-item-package").change(package_change);
            $("#el-item-package_r").change(package_r_change);
            $("#el-item-reseller").change(reseller_change);

            package_change();
            package_r_change();
            reseller_change();
        });

        function package_change(){
            let el = $("#el-item-package");

            if(!$('#el-item-reseller').prop('checked'))
            {
                let selection = el.val();
                $('.package-details').css("display","none");
                $("#package-normal-"+selection).css("display","block");
            }

        }
        function package_r_change(){
            let el = $("#el-item-package_r");
            if($('#el-item-reseller').prop('checked'))
            {
                let selection = el.val();
                $('.package-details').css("display","none");
                $("#package-reseller-"+selection).css("display","block");
            }
        }
        function reseller_change(){
            let el = $("#el-item-reseller");
            if(el.prop('checked'))
                $("#wrap-el-package_r").css("display","block");
            else
                $("#wrap-el-package_r").css("display","none");

            $("#el-item-package").trigger("change");
            $("#el-item-package_r").trigger("change");
        }
    </script>
    
    
    <?php
        if(method_exists($module,"adminArea_service_fields") && $config_options = $module->adminArea_service_fields())
            $module->config_options_output($config_options,'creation_info');
    ?>

    <?php
        if(method_exists($module,"config_options") && $config_options = $module->config_options($creation_info))
            $module->config_options_output($config_options,'creation_info');
    ?>