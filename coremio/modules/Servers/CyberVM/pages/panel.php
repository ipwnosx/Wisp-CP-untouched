<?php
    $order          = $module->order;
    $product        = $module->product;
    $LANG           = $module->lang;
    $statistics     = $module->get_statistics();
    $rebuild_iso    = isset($product["module_data"]["rebuild_iso"]) ? $product["module_data"]["rebuild_iso"] : [];
    if($rebuild_iso && $order["options"]["creation_info"]["server"] != $product["module_data"]["server"]) $rebuild_iso = [];

    if(isset($order["options"]["creation_info"]["allowed_iso"]) && $order["options"]["creation_info"]["allowed_iso"])
        $rebuild_iso = $order["options"]["creation_info"]["allowed_iso"];


    if($module->error){
        ?>
        <div class="red-info">
            <div class="padding10">
                <?php echo $module->error; ?>
            </div>
        </div>
        <div class="clear"></div>
        <br>
        <?php
    }



    if(!$module->error){
        ?>
        <div style="margin-bottom:20px;display:inline-block;text-align: center;">
            <h5 style="font-size:16px;"><strong>HDD</strong></h5>
            <div class="clear"></div>
            <div class="progress-circle progress-<?php echo $statistics["space"]["percent"]; ?>"><span><?php echo $statistics["space"]["percent"]; ?></span></div>
            <div class="clear"></div>
            <h5 style="font-size:16px;"><?php echo $statistics["space"]["format-used"]; ?> / <?php echo $statistics["space"]["format-limit"]; ?></h5>
        </div>

        <div style="margin-bottom:20px;display:inline-block;text-align: center;">
            <h5 style="font-size:16px;"><strong>RAM</strong></h5>
            <div class="clear"></div>
            <div class="progress-circle progress-<?php echo $statistics["ram"]["percent"]; ?>"><span><?php echo $statistics["ram"]["percent"]; ?></span></div>
            <div class="clear"></div>
            <h5 style="font-size:16px;"><?php echo $statistics["ram"]["format-used"]; ?> / <?php echo $statistics["ram"]["format-limit"]; ?></h5>
        </div>

        <div style="margin-bottom:20px;display:inline-block;text-align: center;">
            <h5 style="font-size:16px;"><strong>CPU</strong></h5>
            <div class="clear"></div>
            <div class="progress-circle progress-<?php echo $statistics["cpu"]["percent"]; ?>"><span><?php echo $statistics["cpu"]["percent"]; ?></span></div>
            <div class="clear"></div>
            <h5 style="font-size:16px;"><?php echo $statistics["cpu"]["format-used"]; ?> / <?php echo $statistics["cpu"]["format-limit"]; ?></h5>
        </div>

        <?php
    }
?>
<div class="clear"></div>

<script type="text/javascript">
    $(document).ready(function(){

        $("#CyberVM_operations_wrap,#rebuild_modal").on("click",".CyberVM_operation_btn",function(){
            var use_method  = $(this).data("use-method");
            var button      = $(this);
            var get_data    = {inc:"panel_operation_method",method:use_method};

            if(use_method == "rebuild") get_data["rebuild_iso"] = $("#rebuild_iso").val();

            button.attr("style","background-color:#eee;");
            var request = MioAjax({
                button_element:button,
                action:"<?php echo $controller_link; ?>",
                method:"POST",
                data:get_data,
                waiting_text: '<div class="spinner3">\n' +
                '  <div class="bounce1"></div>\n' +
                '  <div class="bounce2"></div>\n' +
                '  <div class="bounce3"></div>\n' +
                '</div>',
                progress_text: '<?php echo ___("needs/button-uploading"); ?>',
            },true,true);

            request.done(function(result){
                button.removeAttr("style");
                if(result !== ''){
                    var solve = getJson(result);
                    if(solve !== false){
                        if(solve.status == "error"){
                            if(solve.message != undefined && solve.message != '') alert_error(solve.message,{timer:5000});
                        }else if(solve.status == "successful"){
                            if(solve.message != undefined && solve.message != '')
                                alert_success(solve.message,{timer:2000});

                            setTimeout(function(){
                                window.location.href = window.location.href;
                            },2000);
                        }
                    }else
                        console.log(result);
                }
            });
        });
    });
</script>

<div id="CyberVM_operations_wrap">
    <div id="rebuild_modal" style="display:none;" data-izimodal-title="Rebuild">
        <div class="padding20">

            <div align="center">
                <p>
                    <b style="font-size:18px;"><?php echo $LANG["rebuild-1"]; ?></b>
                    <br><br>
                    <?php echo $LANG["delete-2"]; ?>
                    <br><br>
                </p>


                <div class="yuzde50">
                    <strong><?php echo $LANG["os"]; ?></strong>
                    <br>
                    <select name="rebuild_iso" id="rebuild_iso">
                        <?php
                            $servers            = $module->server_list();
                            $iso_list           = $module->iso_list();
                            $server_iso_list    = [];
                            if($iso_list) foreach($iso_list AS $item) $server_iso_list[$item["server"]][] = $item;
                            if($servers){
                                foreach($servers AS $server){
                                    $split          = explode("_",$server);
                                    $server_id      = $split[0];
                                    $server_name    = $split[1];
                                    if($options["creation_info"]["server"] == $server && isset($server_iso_list[$server_name])){
                                        foreach($server_iso_list[$server_name] AS $iso){
                                            if(!$rebuild_iso || in_array($iso["name"],$rebuild_iso)){
                                                ?>
                                                <option value="<?php echo $iso["name"]; ?>"><?php echo $iso["name"]; ?></option>
                                                <?php
                                            }
                                        }
                                    }
                                }
                            }

                        ?>
                    </select>
                </div>


                <br><br>

                <div class="yuzde50">
                    <a href="javascript:void 0;" class="gonderbtn turuncbtn CyberVM_operation_btn" data-use-method="rebuild"><i class="fa fa-check"></i> <?php echo ___("needs/iconfirm"); ?></a>
                </div>
                <br><br>

            </div>
        </div>
    </div>
    <div id="reboot_modal" style="display:none;" data-izimodal-title="Reboot">
        <div class="padding20">

            <div align="center">
                <p>
                    <b style="font-size:18px;"><?php echo ___("needs/apply-are-you-sure"); ?></b>
                    <br><br>
                </p>

                <div class="yuzde50">
                    <a href="javascript:void 0;" class="gonderbtn yesilbtn CyberVM_operation_btn" data-use-method="reboot"><i class="fa fa-check"></i> <?php echo ___("needs/yes"); ?></a>
                </div>
                <br><br>

            </div>
        </div>
    </div>
    <div id="shutdown_modal" style="display:none;" data-izimodal-title="Shutdown">
        <div class="padding20">

            <div align="center">
                <p>
                    <b style="font-size:18px;"><?php echo ___("needs/apply-are-you-sure"); ?></b>
                    <br><br>
                </p>

                <div class="yuzde50">
                    <a href="javascript:void 0;" class="gonderbtn redbtn CyberVM_operation_btn" data-use-method="shutdown"><i class="fa fa-check"></i> <?php echo ___("needs/yes"); ?></a>
                </div>
                <br><br>

            </div>
        </div>
    </div>
    <div id="power_off_modal" style="display:none;" data-izimodal-title="Power Off">
        <div class="padding20">

            <div align="center">
                <p>
                    <b style="font-size:18px;"><?php echo ___("needs/apply-are-you-sure"); ?></b>
                    <br><br>
                </p>

                <div class="yuzde50">
                    <a href="javascript:void 0;" class="gonderbtn redbtn CyberVM_operation_btn" data-use-method="power-off"><i class="fa fa-check"></i> <?php echo ___("needs/yes"); ?></a>
                </div>
                <br><br>

            </div>
        </div>
    </div>
    <div id="vnc_modal" style="display:none;" data-izimodal-title="VNC">
        <div class="padding20">

            <div class="formcon">
                <a class="lbtn" href="<?php echo $controller_link; ?>?inc=panel_operation_method&method=vnc-viewer" target="_blank"><?php echo $LANG["vnc-text1"]; ?></a>
                <a class="lbtn" href="https://www.tightvnc.com/release-jviewer2.php" target="_blank" style="margin-left: 5px;"><?php echo $LANG["vnc-text2"]; ?></a>

                <div class="clear"></div>
                <br>
            </div>

            <?php
                $vnc_info       = $module->get_vnc_info();
                if(isset($vnc_info["status"]) && $vnc_info["status"]){
                    ?>
                    <div align="left">
                        <div class="formcon">
                            <div class="yuzde30">IP</div>
                            <div class="yuzde70"><?php echo $vnc_info["ip"]; ?></div>
                        </div>

                        <div class="formcon">
                            <div class="yuzde30">Port</div>
                            <div class="yuzde70"><?php echo $vnc_info["port"]; ?></div>
                        </div>

                        <div class="formcon">
                            <div class="yuzde30">Password</div>
                            <div class="yuzde70"><?php echo $vnc_info["password"]; ?></div>
                        </div>
                    </div>
                    <?php
                }
            ?>
            <div class="clear"></div>
        </div>
    </div>
    <div class="serverblokbtn">

        <a id="vpsreset" href="javascript:open_modal('rebuild_modal',{headerColor:'orange'});void 0;"><i class="fa fa-cogs" aria-hidden="true"></i> Rebuild</a>

        <?php
            if(isset($status) && $status){
                ?>
                <a id="vpsreset" href="javascript:void 0;" class="CyberVM_operation_btn" data-use-method="reset"><i class="fa fa-refresh" aria-hidden="true"></i> Reset</a>
                <a id="vpsreboot" href="javascript:open_modal('reboot_modal');void 0;"><i class="fa fa-retweet" aria-hidden="true"></i> Reboot</a>
                <a id="vpsShutdown" href="javascript:open_modal('shutdown_modal',{headerColor:'red'});void 0;"><i class="fa fa-ban" aria-hidden="true"></i> Shutdown</a>
                <a id="vpsPowerOff" href="javascript:open_modal('power_off_modal',{headerColor:'red'});void 0;"><i class="fa fa-power-off" aria-hidden="true"></i> Power Off</a>
                <?php
            }else{
                ?>
                <a id="vpsPowerOnn" href="javascript:void 0;" class="CyberVM_operation_btn" data-use-method="power-on"><i class="fa fa-leaf" aria-hidden="true"></i> Power On</a>
                <?php
            }

            if(isset($vnc_info["status"]) && $vnc_info["status"]){
                ?>
                <a href="javascript:open_modal('vnc_modal');void 0;"><i class="fa fa-eye" aria-hidden="true"></i> VNC</a>
                <?php
            }
        ?>
    </div>
</div>