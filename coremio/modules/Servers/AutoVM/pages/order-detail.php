<?php
    $LANG           = $module->lang;
    $established    = false;
    $options        = $order["options"];
    $creation_info  = isset($options["creation_info"]) ? $options["creation_info"] : [];
    $config         = isset($options["config"]) ? $options["config"] : [];
    if($config && isset($config["vpsid"])) $established = true;
    
    if($creation_info){
        $username       = isset($options["login"]["username"]) ? $options["login"]["username"] : false;
        $password       = isset($options["login"]["password"]) ? $options["login"]["password"] : false;
        $server         = isset($creation_info["server"]) ? $creation_info["server"] : false;
        $os             = isset($creation_info["os"]) ? $creation_info["os"] : false;
        $plan           = isset($creation_info["plan"]) ? $creation_info["plan"] : false;
        $datastore      = isset($creation_info["datastore"]) ? $creation_info["datastore"] : false;
        $hard           = isset($creation_info["hard"]) ? $creation_info["hard"] : false;
        $bandwidth      = isset($creation_info["bandwidth"]) ? $creation_info["bandwidth"] : false;
        $ram            = isset($creation_info["ram"]) ? $creation_info["ram"] : false;
        $cpu            = isset($creation_info["cpu"]) ? $creation_info["cpu"] : false;
        $core           = isset($creation_info["core"]) ? $creation_info["core"] : false;
    }else{
        $username       = false;
        $password       = false;
        $server         = false;
        $os             = false;
        $plan           = false;
        $datastore      = false;
        $hard           = false;
        $bandwidth      = false;
        $ram            = false;
        $cpu            = false;
        $core           = false;
    }

    $get_info           = $module->get_info();

    $status             = isset($get_info["vps"]["status"]) && $get_info["vps"]["status"];

    if(isset($get_info["vps"])){
        $server             = $get_info["vps"]["server_id"];
        $datastore          = $get_info["vps"]["datastore_id"];
        $os                 = $get_info["vps"]["os_id"];
        $plan               = $get_info["vps"]["plan_id"];
        $ram                = $get_info["vps"]["vps_ram"];
        $cpu                = $get_info["vps"]["vps_cpu_mhz"];
        $core               = $get_info["vps"]["vps_cpu_core"];
        $hard               = $get_info["vps"]["vps_hard"];
        $bandwidth          = $get_info["vps"]["vps_band_width"];
    }


?>
<input type="hidden" id="AutoVM_use_method" name="use_method" value="">

<?php if($established): ?>

    <div class="formcon">
        <div class="yuzde30"><?php echo $LANG["server-status"]; ?></div>
        <div class="yuzde70">
            <?php
                if(!$get_info && $module->error){
                    ?>
                    <div class="red-info">
                        <div class="padding10"><?php echo $module->error; ?></div>
                    </div>
                    <?php
                }elseif($status){
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


    <div class="formcon" id="AutoVM_operations_wrap">
        <div class="yuzde30"><?php echo $LANG["operations"]; ?></div>
        <div class="yuzde70">

            <script type="text/javascript">
                $(document).ready(function(){

                    $("#AutoVM_operations_wrap").on("click",".AutoVM_operation_btn",function(){
                        var use_method = $(this).data("use-method");



                        $("#AutoVM_use_method").val(use_method);
                        $("#display_error").css("display","none");
                        MioAjaxElement($(this),{
                            waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                            progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                            result:"AutoVM_operation_handler",
                        });
                    });
                });

                function AutoVM_operation_handler(result){
                    $("#AutoVM_use_method").val('');
                    if(result !== ''){
                        var solve = getJson(result);
                        if(solve !== false){
                            if(solve.status == "error"){
                                if(solve.for !== undefined && solve.for === "delete") close_modal("delete_modal");
                                else if(solve.for !== undefined && solve.for === "rebuild") close_modal("rebuild_modal");
                                if(solve.message != undefined && solve.message != ''){
                                    $("#AutoVM_display_error").css("display","block");
                                    $("#AutoVM_display_error_text").html(solve.message);
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
                            <a href="javascript:void 0;" class="gonderbtn redbtn AutoVM_operation_btn" data-use-method="delete"><i class="fa fa-check"></i> <?php echo ___("needs/iconfirm"); ?></a>
                        </div>
                        <br>

                    </div>
                </div>
            </div>
            <div id="restart_modal" style="display:none;" data-izimodal-title="Restart">
                <div class="padding20">

                    <div align="center">
                        <p>
                            <b style="font-size:18px;"><?php echo ___("needs/apply-are-you-sure"); ?></b>
                            <br><br>
                        </p>

                        <div class="yuzde50">
                            <a href="javascript:void 0;" class="gonderbtn yesilbtn AutoVM_operation_btn" data-use-method="restart"><i class="fa fa-check"></i> <?php echo ___("needs/yes"); ?></a>
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
                            <a href="javascript:void 0;" class="gonderbtn redbtn AutoVM_operation_btn" data-use-method="power-off"><i class="fa fa-check"></i> <?php echo ___("needs/yes"); ?></a>
                        </div>
                        <br><br>

                    </div>
                </div>
            </div>

            <a class="lbtn" href="javascript:open_modal('delete_modal',{headerColor:'red'});void 0;"><i class="fa fa-trash" aria-hidden="true"></i> <?php echo $LANG["delete"]; ?></a>

            <?php
                if($status){
                    ?>
                    <a class="red lbtn" href="javascript:open_modal('power_off_modal',{headerColor:'red'});void 0;"><i class="fa fa-power-off" aria-hidden="true"></i> Power Off</a>

                    <a class="lbtn AutoVM_operation_btn" data-use-method="restart" href="javascript:void 0;"><i class="fa fa-refresh" aria-hidden="true"></i> Restart</a>
                    <?php
                }else{
                    ?>
                    <a class="green lbtn AutoVM_operation_btn" data-use-method="power-on" href="javascript:void 0;"><i class="fa fa-leaf" aria-hidden="true"></i> Power On</a>
                    <?php
                }
            ?>

            <a class="blue lbtn" target="_blank" href="<?php echo isset($get_info["url"]) ? $get_info["url"] : 'javascript:void 0;'; ?>"><i class="fa fa-sign-in" aria-hidden="true"></i> <?php echo $LANG["view"]; ?></a>

            <div class="clear"></div>
            <div class="red-info" style="display: none;" id="AutoVM_display_error">
                <div class="padding10" id="AutoVM_display_error_text"></div>
            </div>


        </div>
    </div>


    <div class="formcon">
        <?php
            $login = $module->admin_login();
            if($login){
                ?>
                <iframe src="<?php echo $login;?>" style="border:none;width:100%;height:650px;overflow:auto;"></iframe>
                <?php
            }else{
                ?>
                <div class="red-info">
                    <div class="padding10">
                        <?php echo $LANG["error1"]; ?>
                    </div>
                </div>
                <?php
            }
        ?>
    </div>

<?php endif; ?>

<div class="formcon">
    <div class="yuzde30">VPS ID</div>
    <div class="yuzde70">
        <input name="config[vpsid]" type="text" style="width:150px;" onkeypress='return event.charCode>= 48 &&event.charCode<= 57' value="<?php echo isset($config["vpsid"]) ? $config["vpsid"] : ''; ?>">
    </div>
</div>

<?php
    if(!$established){
        ?>
        <script type="text/javascript">
            $(document).ready(function(){

                $("#AutoVM_install_btn").click(function(){
                    $("#AutoVM_use_method").val('install');
                    $("#display_error").css("display","none");
                    MioAjaxElement($(this),{
                        waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                        progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                        result:"AutoVM_install_handler",
                    });
                });
            });

            function AutoVM_install_handler(result){
                $("#AutoVM_use_method").val('');
                if(result !== ''){
                    var solve = getJson(result);
                    if(solve !== false){
                        if(solve.status == "error"){
                            if(solve.message != undefined && solve.message != ''){
                                $("#AutoVM_display_error").css("display","block");
                                $("#AutoVM_display_error_text").html(solve.message);
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

                <a class="green lbtn" href="javascript:void 0;" id="AutoVM_install_btn"><i class="fa fa-cog"></i> <?php echo $LANG["install"]; ?></a>

                <div class="clear"></div>
                <div class="red-info" style="display: none;" id="AutoVM_display_error">
                    <div class="padding10" id="AutoVM_display_error_text"></div>
                </div>

            </div>
        </div>

        <div class="formcon">
            <div class="yuzde30"><?php echo $LANG["server"]; ?></div>
            <div class="yuzde70">
                <input<?php echo $established ? ' disabled' : ''; ?> name="creation_info[server]" value="<?php echo $server; ?>">
            </div>
        </div>

        <?php
        if(!$established){
            ?>
            <div class="formcon">
                <div class="yuzde30"><?php echo $LANG["select-ip"]; ?></div>
                <div class="yuzde70">
                    <select name="creation_info[ipId]">
                        <option value=""><?php echo $LANG["auto"]; ?></option>
                        <?php
                            if($ips = $module->ip_list()){
                                foreach($ips AS $ip_id=>$ip_val){
                                    ?>
                                    <option value="<?php echo $ip_id; ?>"><?php echo $ip_val; ?></option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
            <?php
        }
        ?>

        <div class="formcon">
            <div class="yuzde30"><?php echo $LANG["os"]; ?></div>
            <div class="yuzde70">
                <select<?php echo $established ? ' disabled' : ''; ?> name="creation_info[os]">
                    <option value=""><?php echo ___("needs/none"); ?></option>
                    <?php
                        if($os_list = $module->os_list()){
                            foreach($os_list->data AS $os_id=>$os_name){
                                ?>
                                <option<?php echo $os == $os_id ? ' selected' : '' ;?> value="<?php echo $os_id; ?>"><?php echo $os_name; ?></option>
                                <?php
                            }
                        }
                    ?>
                </select>
            </div>
        </div>

        <div class="formcon">
            <div class="yuzde30"><?php echo $LANG["plan"]; ?></div>
            <div class="yuzde70">
                <input<?php echo $established ? ' disabled' : ''; ?> name="creation_info[plan]" value="<?php echo $plan; ?>">
            </div>
        </div>

        <div class="formcon">
            <div class="yuzde30">Datastore ID</div>
            <div class="yuzde70">
                <input<?php echo $established ? ' disabled' : ''; ?> type="text" name="creation_info[datastore]" value="<?php echo $datastore; ?>" style="width: 100px;">
            </div>
        </div>

        <div class="formcon">
            <div class="yuzde30"><?php echo $LANG["disk-space"]; ?> (GB)</div>
            <div class="yuzde70">
                <input<?php echo $established ? ' disabled' : ''; ?> type="text" name="creation_info[hard]" value="<?php echo $hard; ?>" style="width: 100px;" onkeypress='return event.charCode>= 48 &&event.charCode<= 57'>
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
        <?php
    }
?>