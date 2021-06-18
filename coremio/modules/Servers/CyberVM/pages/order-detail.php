<?php
    $LANG           = $module->lang;
    $established    = false;
    $options        = $order["options"];
    $creation_info  = isset($options["creation_info"]) ? $options["creation_info"] : [];
    $config         = isset($options["config"]) ? $options["config"] : [];
    if($config && isset($config["vpsid"])) $established = true;

    $server         = isset($creation_info["server"]) ? $creation_info["server"] : false;
    $iso            = isset($creation_info["iso"]) ? $creation_info["iso"] : false;
    $allowed_iso    = isset($creation_info["allowed_iso"]) ? $creation_info["allowed_iso"] : false;

    if($creation_info){
        $os             = isset($creation_info["os"]) ? $creation_info["os"] : false;
        $datastore      = isset($creation_info["datastore"]) ? $creation_info["datastore"] : false;
        $space          = isset($creation_info["space"]) ? $creation_info["space"] : false;
        $bandwidth      = isset($creation_info["bandwidth"]) ? $creation_info["bandwidth"] : false;
        $ram            = isset($creation_info["ram"]) ? $creation_info["ram"] : false;
        $cpu            = isset($creation_info["cpu"]) ? $creation_info["cpu"] : false;
        $core           = isset($creation_info["core"]) ? $creation_info["core"] : false;
        $vnc            = isset($creation_info["vnc"]) ? $creation_info["vnc"] : false;
        $prefix         = isset($creation_info["prefix"]) ? $creation_info["prefix"] : false;
    }else{
        $os             = "";
        $datastore      = "";
        $space          = "";
        $bandwidth      = "";
        $ram            = "";
        $cpu            = "";
        $core           = "";
        $vnc            = false;
        $prefix         = "";
    }

    if($established){
        $vnc_info       = $module->get_vnc_info();
    }

?>
<input type="hidden" id="CyberVM_use_method" name="use_method" value="">
<?php
    if($established){
        ?>
        <input type="hidden" name="creation_info[server]" value="<?php echo $server; ?>">
        <input type="hidden" name="creation_info[iso]" value="<?php echo $iso; ?>">
        <input type="hidden" name="creation_info[os]" value="<?php echo $os; ?>">
        <input type="hidden" name="creation_info[datastore]" value="<?php echo $datastore; ?>">
        <input type="hidden" name="creation_info[space]" value="<?php echo $space; ?>">
        <input type="hidden" name="creation_info[bandwidth]" value="<?php echo $bandwidth; ?>">
        <input type="hidden" name="creation_info[ram]" value="<?php echo $ram; ?>">
        <input type="hidden" name="creation_info[cpu]" value="<?php echo $cpu; ?>">
        <input type="hidden" name="creation_info[core]" value="<?php echo $core; ?>">
        <input type="hidden" name="creation_info[vnc]" value="<?php echo $vnc; ?>">
        <input type="hidden" name="creation_info[prefix]" value="<?php echo $prefix; ?>">
        <?php
    }
?>

<?php if($established): ?>
    <div class="formcon">
        <div class="yuzde30"><?php echo $LANG["server-status"]; ?></div>
        <div class="yuzde70">
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
                    <span style="color: #fff;background: #4CAF50;font-size: 13px;padding: 4px 20px;-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;font-weight: bold;"><?php echo $LANG["power-on"]; ?></span>
                    <?php
                }else{
                    ?>
                    <span style="color: #fff;background: #F44336;font-size: 13px;padding: 4px 20px;-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;font-weight: bold;"><?php echo $LANG["power-off"]; ?></span>
                    <?php
                }
            ?>
        </div>
    </div>

    <div class="formcon">
        <div class="yuzde30"><?php echo $LANG["statistics"]; ?></div>
        <div class="yuzde70">

            <?php
                $statistics = $module->get_statistics();
                if(!$statistics && $module->error){
                    ?>
                    <div class="red-info">
                        <div class="padding10"><?php echo $module->error; ?></div>
                    </div>
                    <?php
                }else{
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

        </div>
    </div>

    <div class="formcon" id="CyberVM_operations_wrap">
        <div class="yuzde30"><?php echo $LANG["operations"]; ?></div>
        <div class="yuzde70">

            <script type="text/javascript">
                $(document).ready(function(){

                    $("#CyberVM_operations_wrap,#rebuild_modal").on("click",".CyberVM_operation_btn",function(){
                        var use_method = $(this).data("use-method");



                        $("#CyberVM_use_method").val(use_method);
                        $("#display_error").css("display","none");
                        MioAjaxElement($(this),{
                            waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                            progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                            result:"CyberVM_operation_handler",
                        });
                    });

                    $(document).on('opening', '#rebuild_modal', function (e) {
                        $("#rebuild_iso").removeAttr("disabled").html($("select[name='creation_info[iso]']").html());
                    });

                });

                function CyberVM_operation_handler(result){
                    $("#CyberVM_use_method").val('');
                    if(result !== ''){
                        var solve = getJson(result);
                        if(solve !== false){
                            if(solve.status == "error"){
                                if(solve.for !== undefined && solve.for === "delete") close_modal("delete_modal");
                                else if(solve.for !== undefined && solve.for === "rebuild") close_modal("rebuild_modal");
                                if(solve.message != undefined && solve.message != ''){
                                    $("#CyberVM_display_error").css("display","block");
                                    $("#CyberVM_display_error_text").html(solve.message);
                                }
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
                }
            </script>

            <div id="delete_modal" style="display:none;" data-izimodal-title="<?php echo $LANG["delete"]; ?>">
                <div class="padding20">

                    <div align="center">
                        <p>
                            <b><?php echo $LANG["delete-1"]; ?></b>
                            <br><br>
                            <?php echo $LANG["delete-2"]; ?>
                            <br>
                        </p>

                        <div class="yuzde50">
                            <a href="javascript:void 0;" class="gonderbtn redbtn CyberVM_operation_btn" data-use-method="delete"><i class="fa fa-check"></i> <?php echo ___("needs/iconfirm"); ?></a>
                        </div>
                        <br>

                    </div>
                </div>
            </div>

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
                            <select disabled name="rebuild_iso" id="rebuild_iso"></select>
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
            <div id="reset_vnc_password_modal" style="display:none;" data-izimodal-title="<?php echo $LANG["reset-vnc-password"]; ?>">
                <div class="padding20">

                    <div align="center">
                        <p>
                            <b style="font-size:18px;"><?php echo ___("needs/apply-are-you-sure"); ?></b>
                            <br><br>
                        </p>

                        <div class="yuzde50">
                            <a href="javascript:void 0;" class="gonderbtn redbtn CyberVM_operation_btn" data-use-method="reset-vnc-password"><i class="fa fa-check"></i> <?php echo ___("needs/yes"); ?></a>
                        </div>
                        <br><br>

                    </div>
                </div>
            </div>



            <a class="lbtn" href="javascript:open_modal('delete_modal',{headerColor:'red'});void 0;"><i class="fa fa-trash" aria-hidden="true"></i> <?php echo $LANG["delete"]; ?></a>

            <a class="lbtn orange" href="javascript:open_modal('rebuild_modal',{headerColor:'orange'});void 0;"><i class="fa fa-cogs" aria-hidden="true"></i> Rebuild</a>

            <?php if($server_status): ?>
                <a class="lbtn CyberVM_operation_btn" data-use-method="reset" href="javascript:void 0;"><i class="fa fa-refresh" aria-hidden="true"></i> Reset</a>
                <a class="lbtn" href="javascript:open_modal('reboot_modal',{headerColor:'red'});void 0;"><i class="fa fa-retweet" aria-hidden="true"></i> Reboot</a>
                <a class="blue lbtn" href="javascript:open_modal('shutdown_modal',{headerColor:'red'});void 0;"><i class="fa fa-ban" aria-hidden="true"></i> Shutdown</a>
                <a class="red lbtn" href="javascript:open_modal('power_off_modal',{headerColor:'red'});void 0;"><i class="fa fa-power-off" aria-hidden="true"></i> Power Off</a>
            <?php else: ?>
                <a class="green lbtn CyberVM_operation_btn" data-use-method="power-on" href="javascript:void 0;"><i class="fa fa-leaf" aria-hidden="true"></i> Power On</a>
            <?php endif; ?>

            <?php if($vnc_info["status"]): ?>
                <a class="lbtn" href="javascript:open_modal('reset_vnc_password_modal',{headerColor:'red'});void 0;"><?php echo $LANG["reset-vnc-password"]; ?></a>
            <?php else: ?>
                <a class="lbtn CyberVM_operation_btn" data-use-method="enable-vnc" href="javascript:void 0;"><?php echo $LANG["vnc"]; ?></a>
            <?php endif; ?>

            <div class="clear"></div>
            <div class="red-info" style="display: none;" id="CyberVM_display_error">
                <div class="padding10" id="CyberVM_display_error_text"></div>
            </div>


        </div>
    </div>
<?php endif; ?>

<div class="formcon">
    <div class="yuzde30">VPS</div>
    <div class="yuzde70">
        <?php
        $list   = $module->list_vps();
        ?>
        <select name="config[vpsid]" size="10">
            <option value=""><?php echo ___("needs/none"); ?></option>
        <?php
            if($list){
                foreach($list AS $row){
                    $selected = isset($config["vpsid"]) && $config["vpsid"] == $row["access_data"]["config"]["vpsid"];
                    ?><option<?php echo $selected ? ' selected' : ''; ?> value="<?php echo $row["access_data"]["config"]["vpsid"]; ?>"><?php echo "ID: ".$row["access_data"]["config"]["vpsid"]." | ".$row["hostname"]." | ".$row["ip"]; ?></option><?php
                }
            }else{
                if(isset($config["vpsid"]) && $config["vpsid"]){
                    ?><option selected value="<?php echo $config["vpsid"]; ?>"><?php echo $options["hostname"]." - ".$options["ip"]; ?></option><?php
                }
            }
        ?>
        </select>
        <?php
            if(!$list && $module->error){
                ?>
                <div class="red-info">
                    <div class="padding10"><?php echo $module->error; ?></div>
                </div>
                <?php
            }
        ?>
    </div>
</div>

<div class="formcon">
    <div class="yuzde30"><?php echo $LANG["server"]; ?></div>
    <div class="yuzde70">
        <script type="text/javascript">
            var selected_server     = '<?php echo $server?>';
            var selected_iso        = '<?php echo $iso?>';
            var allowed_iso         = <?php echo $allowed_iso ? Utility::jencode($allowed_iso) : '{}'; ?>;

            function CyberVM_change_server(elem){
                var option  = $("select[name='creation_info[server]'] option:selected");
                var iso     = option.data("iso");

                var iso_list = '',alw_iso_list = '';

                if(iso){
                    $(iso).each(function(k,i){
                        iso_list += '<option'+((selected_iso && i.name == selected_iso) ? ' selected' : '')+' value="'+i.name+'">'+i.name+'</option>';
                        alw_iso_list += '<option'+((allowed_iso && in_array(i.name,allowed_iso)) ? ' selected' : '')+' value="'+i.name+'">'+i.name+'</option>';
                    });
                }

                $("select[name='creation_info[iso]']").html(iso_list);
                $("#allowed_iso").html(alw_iso_list);
            }

            $(document).ready(function(){
                if(selected_server) $("select[name='creation_info[server]'] option[value='"+selected_server+"']").prop("selected",true).trigger("change");
            });
        </script>
        <select<?php echo $established ? ' disabled' : ''; ?> name="creation_info[server]" onchange="CyberVM_change_server();">
            <option value=""><?php echo ___("needs/select-your"); ?></option>
            <?php
                $servers_error      = NULL;
                $iso_error          = NULL;
                $servers            = $module->server_list();
                if(!$server && $module->error) $servers_error = $module->error;

                if($servers && !$servers_error){
                    $iso_list           = $module->iso_list();
                    if(!$iso_list && $module->error) $iso_error = $module->error;
                    $server_iso_list    = [];
                    if($iso_list) foreach($iso_list AS $item) $server_iso_list[$item["server"]][] = $item;

                    foreach($servers AS $server){
                        $split          = explode("_",$server);
                        $server_id      = $split[0];
                        $server_name    = $split[1];
                        ?>
                        <option value="<?php echo $server; ?>" data-iso='<?php echo isset($server_iso_list[$server_name]) ? Utility::jencode($server_iso_list[$server_name]) : ''; ?>'><?php echo $server_id." | ".$server_name; ?></option>
                        <?php
                    }
                }
            ?>
        </select>
        <?php
            if($servers_error){
                ?>
                <div class="red-info">
                    <div class="padding10"><?php echo $servers_error; ?></div>
                </div>
                <?php
            }
        ?>
    </div>
</div>

<?php
    if(!$established){
        ?>
        <script type="text/javascript">
            $(document).ready(function(){

                $("#CyberVM_install_btn").click(function(){
                    $("#CyberVM_use_method").val('install');
                    $("#display_error").css("display","none");
                    MioAjaxElement($(this),{
                        waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                        progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                        result:"CyberVM_install_handler",
                    });
                });
            });

            function CyberVM_install_handler(result){
                $("#CyberVM_use_method").val('');
                if(result !== ''){
                    var solve = getJson(result);
                    if(solve !== false){
                        if(solve.status == "error"){
                            if(solve.message != undefined && solve.message != ''){
                                $("#CyberVM_display_error").css("display","block");
                                $("#CyberVM_display_error_text").html(solve.message);
                            }
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
            }
        </script>
        <div class="formcon">
            <div class="yuzde30"><?php echo $LANG["operations"]; ?></div>
            <div class="yuzde70">

                <a class="green lbtn" href="javascript:void 0;" id="CyberVM_install_btn"><i class="fa fa-cog"></i> <?php echo $LANG["install"]; ?></a>

                <div class="clear"></div>
                <div class="red-info" style="display: none;" id="CyberVM_display_error">
                    <div class="padding10" id="CyberVM_display_error_text"></div>
                </div>

            </div>
        </div>
        <?php
    }
?>


<div class="formcon">
    <div class="yuzde30"><?php echo $LANG["iso"]; ?></div>
    <div class="yuzde70">
        <select<?php echo $established ? ' disabled' : ''; ?> name="creation_info[iso]">
            <option value=""><?php echo ___("needs/none"); ?></option>
        </select>
        <?php
            if($iso_error){
                ?>
                <div class="red-info">
                    <div class="padding10"><?php echo $iso_error; ?></div>
                </div>
                <?php
            }
        ?>
    </div>
</div>

<div class="formcon">
    <div class="yuzde30">
        <?php echo $LANG["allowed-iso"]; ?>
        <div class="clear"></div>
        <span class="kinfo"><?php echo $LANG["allowed-iso-info"]; ?></span>
    </div>
    <div class="yuzde70">
        <select id="allowed_iso" name="creation_info[allowed_iso][]" multiple style="height: 200px;"></select>
    </div>
</div>

<div class="formcon">
    <div class="yuzde30"><?php echo $LANG["os"]; ?></div>
    <div class="yuzde70">
        <select<?php echo $established ? ' disabled' : ''; ?> name="creation_info[os]">
            <option value=""><?php echo ___("needs/none"); ?></option>
            <?php
                if($module->config["os-list"]){
                    foreach($module->config["os-list"] AS $os_name){
                        $selected = $os == $os_name;
                        ?><option<?php echo  $selected ? ' selected' : ''; ?> value="<?php echo $os_name; ?>"><?php echo $os_name; ?></option><?php
                    }
                }
            ?>
        </select>
    </div>
</div>

<div class="formcon">
    <div class="yuzde30">Datastore</div>
    <div class="yuzde70">
        <input<?php echo $established ? ' disabled' : ''; ?> type="text" name="creation_info[datastore]" value="<?php echo $datastore; ?>">
    </div>
</div>

<div class="formcon">
    <div class="yuzde30"><?php echo $LANG["disk-space"]; ?> (GB)</div>
    <div class="yuzde70">
        <input<?php echo $established ? ' disabled' : ''; ?> type="text" name="creation_info[space]" value="<?php echo $space; ?>" style="width: 100px;" onkeypress='return event.charCode>= 48 &&event.charCode<= 57'>
    </div>
</div>

<div class="formcon">
    <div class="yuzde30"><?php echo $LANG["bandwidth"]; ?> (GB)</div>
    <div class="yuzde70">
        <input<?php echo $established ? ' disabled' : ''; ?> type="text" name="creation_info[bandwidth]" value="<?php echo $bandwidth; ?>" style="width: 100px;" onkeypress='return event.charCode>= 48 &&event.charCode<= 57'>
        <span class="kinfo"><?php echo $LANG["unlmt-desc"]; ?></span>
    </div>
</div>

<div class="formcon">
    <div class="yuzde30">RAM (MB)</div>
    <div class="yuzde70">
        <input<?php echo $established ? ' disabled' : ''; ?> type="text" name="creation_info[ram]" value="<?php echo $ram; ?>" style="width: 100px;" onkeypress='return event.charCode>= 48 &&event.charCode<= 57'>
    </div>
</div>

<div class="formcon">
    <div class="yuzde30">CPU (Mhz)</div>
    <div class="yuzde70">
        <input<?php echo $established ? ' disabled' : ''; ?> type="text" name="creation_info[cpu]" value="<?php echo $cpu; ?>" style="width: 100px;" onkeypress='return event.charCode>= 48 &&event.charCode<= 57'>
        <span class="kinfo"><?php echo $LANG["unlmt-desc"]; ?></span>
    </div>
</div>

<div class="formcon">
    <div class="yuzde30">CPU Core</div>
    <div class="yuzde70">
        <input<?php echo $established ? ' disabled' : ''; ?> type="text" name="creation_info[core]" value="<?php echo $core; ?>" style="width: 100px;" onkeypress='return event.charCode>= 48 &&event.charCode<= 57'>
        <span class="kinfo"><?php echo $LANG["core-desc"]; ?></span>
    </div>
</div>

<div class="formcon" style="<?php echo $established ? 'display: none;' : ''; ?>">
    <div class="yuzde30"><?php echo $LANG["vnc"]; ?></div>
    <div class="yuzde70">
        <input<?php echo $established ? ' disabled' : ''; ?><?php echo $vnc ? ' checked' : ''; ?> type="checkbox" class="sitemio-checkbox" name="creation_info[vnc]" value="1" id="CyberVM_vnc">
        <label class="sitemio-checkbox-label" for="CyberVM_vnc"></label>
    </div>
</div>


<div class="formcon">
    <div class="yuzde30">VPS Prefix</div>
    <div class="yuzde70">
        <input<?php echo $established ? ' disabled' : ''; ?> type="text" name="creation_info[prefix]" value="<?php echo $prefix; ?>">
    </div>
</div>

<?php if($established && $vnc_info["status"]): ?>
    <div class="formcon">
        <div class="yuzde30">VNC Info</div>
        <div class="yuzde70">
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

            <div class="clear"></div>
            <br>

            <a class="lbtn" href="?operation=operation_server_automation&use_method=vnc-viewer&server_id=<?php echo $options["server_id"]; ?>" target="_blank"><?php echo $LANG["vnc-text1"]; ?></a>
            <a class="lbtn" href="https://www.tightvnc.com/release-jviewer2.php" target="_blank" style="margin-left: 5px;"><?php echo $LANG["vnc-text2"]; ?></a>

        </div>
    </div>
<?php endif; ?>