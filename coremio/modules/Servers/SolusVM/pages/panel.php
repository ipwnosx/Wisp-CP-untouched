<?php
    //$module->unsuspend();
    $LANG       = $module->lang;
    $established    = false;
    $options        = $order["options"];
    $creation_info  = isset($options["creation_info"]) ? $options["creation_info"] : [];
    $config         = isset($options["config"]) ? $options["config"] : [];
    if($config && isset($config["vserverid"])) $established = true;

    $info           = $module->get_vserver_info();
    $vnc_info       = $module->get_vnc_info();
    $ip_addresses   = [];
    $statistics     = $module->get_statistics();

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
        return false;
    }
?>
<script type="text/javascript" src="<?php echo View::$init->get_resources_url('assets/plugins/js/jquery.countdown.min.js'); ?>"></script>
<script type="text/javascript">
    function solusvm_ajax_result(result){
        if(result !== ''){
            var solve = getJson(result);
            if(solve !== false){
                if(solve.status == "error")
                    alert_error(solve.message,{timer:4000});
                else if(solve.status == "successful"){
                    if(solve.message !== undefined)
                        alert_success(solve.message,{timer:2000});
                    if(solve.refresh !== undefined)
                        window.location.href = location.href;
                }
            }else
                console.log(result);
        }

    }
    $(document).ready(function(){

        var tab = gGET("action");
        if (tab != '' && tab != undefined) {
            $("#tab-action .tablinks[data-tab='" + tab + "']").click();

            if(tab === 'detail'){
                $('#edit_automation_form_submit').parent().css("display","block");
            }else{
                $('#edit_automation_form_submit').parent().css("display","none");
            }

        } else {
            $("#tab-action .tablinks:eq(0)").addClass("active");
            $("#tab-action .tabcontent:eq(0)").css("display", "block");
        }

        $("#tab-action .tablinks").click(function(){
            var section = $(this).data("tab");
            if(section === 'detail'){
                $('#edit_automation_form_submit').parent().css("display","block");
            }else{
                $('#edit_automation_form_submit').parent().css("display","none");
            }
        });

    });
</script>
<style type="text/css">
    #tab-action .tab li a {  padding: 14px 29px;  }
</style>

<div id="tab-action">
    <ul class="tab">
        <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'detail','action');" data-tab="detail"><i class="fa fa-info" aria-hidden="true"></i> <?php echo $LANG["tab-details"]; ?></a></li>

        <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'change-hostname','action');" data-tab="change-hostname"><i class="fa fa-user" aria-hidden="true"></i> <?php echo $LANG["tab-change-hostname"]; ?></a></li>

        <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'change-password','action');" data-tab="change-password"><i class="fa fa-key" aria-hidden="true"></i> <?php echo $LANG["tab-change-password"]; ?></a></li>

        <?php if(isset($ip_addresses) && sizeof($ip_addresses)>1): ?>
            <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'network','action');" data-tab="network"><i class="fa fa-globe" aria-hidden="true"></i> <?php echo $LANG["tab-network"]; ?></a></li>
        <?php endif; ?>

        <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'console','action');" data-tab="console"><i class="fa fa-terminal" aria-hidden="true"></i> Console</a></li>

        <?php if($vnc_info["status"]): ?>
            <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'vnc','action');" data-tab="vnc"><i class="fa fa-play" aria-hidden="true"></i> VNC</a></li>
        <?php endif; ?>

    </ul>

    <div id="action-detail" class="tabcontent">
        <div class="adminpagecon">

            <?php
                if($statistics){
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
                        <h5 style="font-size:16px;"><strong><?php echo $LANG["bandwidth"]; ?></strong></h5>
                        <div class="clear"></div>
                        <div class="progress-circle progress-<?php echo $statistics["bandwidth"]["percent"]; ?>"><span><?php echo $statistics["bandwidth"]["percent"]; ?></span></div>
                        <div class="clear"></div>
                        <h5 style="font-size:16px;"><?php echo $statistics["bandwidth"]["format-used"]; ?> / <?php echo $statistics["bandwidth"]["format-limit"]; ?></h5>
                    </div>

                    <?php
                }
            ?>
            <div class="clear"></div>

            <script type="text/javascript">
                $(document).ready(function(){

                    $("#SolusVM_operations_wrap").on("click",".SolusVM_operation_btn",function(){
                        var use_method  = $(this).data("use-method");
                        var button      = $(this);
                        var get_data    = {inc:"panel_operation_method",method:use_method};

                        if(use_method == "rebuild") get_data["rebuild_template"] = $("#rebuild_template").val();

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

                        request.done(solusvm_ajax_result);
                    });
                });
            </script>

            <div id="SolusVM_operations_wrap">

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
                                <strong>Template</strong>
                                <br>
                                <?php
                                    $templates      = $module->templates_by_types();
                                    $list_iso       = $module->list_iso();
                                ?>
                                <select name="rebuild_template" id="rebuild_template">
                                    <?php
                                        if(isset($templates[$creation_info["virtualization_type"]]) && $templates[$creation_info["virtualization_type"]]){
                                            foreach($templates[$creation_info["virtualization_type"]] AS $row){
                                                ?><option<?php echo $creation_info["template"] == $row["name"] ? " selected" : ''; ?> value="<?php echo $row["name"]; ?>"><?php echo $row["name"].($row["os"] ? " (".$row["os"].")" : ''); ?></option><?php
                                            }
                                        }elseif(!isset($list_iso[$creation_info["virtualization_type"]])){
                                            ?><option value=""><?php echo ___("needs/none"); ?></option><?php
                                        }
                                        if(isset($list_iso[$creation_info["virtualization_type"]])){
                                            foreach($list_iso[$creation_info["virtualization_type"]] AS $row){
                                                ?><option<?php echo $creation_info["template"] == $row ? " selected" : ''; ?> value="<?php echo $row; ?>"><?php echo $row; ?></option><?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>


                            <br><br>

                            <div class="yuzde50">
                                <a href="javascript:void 0;" class="gonderbtn turuncbtn SolusVM_operation_btn" data-use-method="rebuild"><i class="fa fa-check"></i> <?php echo ___("needs/iconfirm"); ?></a>
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
                                <a href="javascript:void 0;" class="gonderbtn yesilbtn SolusVM_operation_btn" data-use-method="reboot"><i class="fa fa-check"></i> <?php echo ___("needs/yes"); ?></a>
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
                                <a href="javascript:void 0;" class="gonderbtn redbtn SolusVM_operation_btn" data-use-method="shutdown"><i class="fa fa-check"></i> <?php echo ___("needs/yes"); ?></a>
                            </div>
                            <br><br>

                        </div>
                    </div>
                </div>

                <div class="serverblokbtn">

                    <a id="vpsreset" href="javascript:open_modal('rebuild_modal',{headerColor:'orange'});void 0;"><i class="fa fa-cogs" aria-hidden="true"></i> Rebuild</a>

                    <?php
                        if(isset($status) && $status){
                            ?>
                            <a id="vpsreboot" href="javascript:open_modal('reboot_modal');void 0;"><i class="fa fa-retweet" aria-hidden="true"></i> Reboot</a>
                            <a id="vpsPowerOff" href="javascript:open_modal('shutdown_modal',{headerColor:'red'});void 0;"><i class="fa fa-power-off" aria-hidden="true"></i> Shutdown</a>
                            <?php
                        }else{
                            ?>
                            <a id="vpsPowerOnn" href="javascript:void 0;" class="SolusVM_operation_btn" data-use-method="power-on"><i class="fa fa-leaf" aria-hidden="true"></i> Power On</a>
                            <?php
                        }
                    ?>
                </div>
            </div>

        </div>
    </div>

    <div id="action-change-hostname" class="tabcontent">
        <div class="adminpagecon">
            <script type="text/javascript">
                $(document).ready(function(){
                    $('#SolusVM_change_hostname_button').click(function(){
                        var request = MioAjax({
                            button_element:this,
                            waiting_text: '<?php echo __("website/others/button1-pending"); ?>',
                            action:"<?php echo Controllers::$init->ControllerURI(); ?>",
                            method:"POST",
                            data:{
                                inc:   "panel_operation_method",
                                method:  "change-hostname",
                                hostname:    $('#SolusVM_hostname').val(),
                            },
                        },true,true);

                        request.done(solusvm_ajax_result);

                    });
                });
            </script>

            <div class="formcon">
                <div class="yuzde30"><?php echo $LANG["new-hostname"]; ?></div>
                <div class="yuzde70">
                    <input type="text" id="SolusVM_hostname" value="" placeholder="">
                </div>
            </div>

            <div style="float:right;margin-bottom:20px;" class="guncellebtn yuzde30">
                <a id="SolusVM_change_hostname_button" class="yesilbtn gonderbtn" href="javascript:void(0);"><?php echo ___("needs/button-update"); ?></a>
            </div>

        </div>
    </div>
    <div id="action-change-password" class="tabcontent">
        <div class="adminpagecon">
            <script type="text/javascript">
                $(document).ready(function(){
                    $('#SolusVM_change_password_button').click(function(){
                        var request = MioAjax({
                            button_element:this,
                            waiting_text: '<?php echo __("website/others/button1-pending"); ?>',
                            action:"<?php echo Controllers::$init->ControllerURI(); ?>",
                            method:"POST",
                            data:{
                                inc:   "panel_operation_method",
                                method:  "change-password",
                                password:    $('#SolusVM_password').val(),
                            },
                        },true,true);

                        request.done(solusvm_ajax_result);

                    });
                });
            </script>

            <div class="formcon">
                <div class="yuzde30"><?php echo $LANG["new-password"]; ?></div>
                <div class="yuzde70">
                    <input type="password" id="SolusVM_password" value="" placeholder="">
                </div>
            </div>

            <div style="float:right;margin-bottom:20px;" class="guncellebtn yuzde30">
                <a id="SolusVM_change_password_button" class="yesilbtn gonderbtn" href="javascript:void(0);"><?php echo ___("needs/button-update"); ?></a>
            </div>

        </div>
    </div>

    <?php
        if(isset($ip_addresses) && sizeof($ip_addresses)>1){
            ?>
            <div id="action-network" class="tabcontent">
                <div class="adminpagecon">

                    <script type="text/javascript">
                        $(document).ready(function(){

                            $('#SolusVM_network_submit').click(function(){
                                var request = MioAjax({
                                    button_element:this,
                                    waiting_text: '<?php echo __("website/others/button1-pending"); ?>',
                                    action:"<?php echo Controllers::$init->ControllerURI(); ?>",
                                    method:"POST",
                                    data:{
                                        inc:   "panel_operation_method",
                                        method: "change-main-ip-address",
                                        value:      $('input[name=select_ip_address]:checked').val(),
                                    }
                                },true,true);
                                request.done(solusvm_ajax_result);
                            });
                        });
                    </script>


                    <div class="formcon">
                        <div class="yuzde30"><?php echo $LANG["change-main-ip-address"]; ?></div>
                        <div class="yuzde70">
                            <?php
                                $main_ip    = isset($info["mainipaddress"]) ? $info["mainipaddress"] : false;

                                foreach($ip_addresses AS $k=>$ip_address){
                                    $ip_address = trim($ip_address);
                                    ?>
                                    <input<?php echo $main_ip == $ip_address ? ' checked' : ''; ?> type="radio" name="select_ip_address" value="<?php echo $ip_address; ?>" class="radio-custom" id="select_ip_<?php echo $k; ?>">
                                    <label style="margin-bottom: 5px;" class="radio-custom-label" for="select_ip_<?php echo $k; ?>"><?php echo $ip_address; ?></label>
                                    <div class="clear"></div>
                                    <?php
                                }
                            ?>
                        </div>
                    </div>

                    <div style="float:right;margin-bottom:20px;" class="guncellebtn yuzde30">
                        <a id="SolusVM_network_submit" class="yesilbtn gonderbtn" href="javascript:void(0);"><?php echo ___("needs/button-update"); ?></a>
                    </div>

                </div>
            </div>
            <?php
        }
    ?>
    <div id="action-console" class="tabcontent">
        <script type="text/javascript">
            $(document).ready(function (){
                $("#SolusVM_create_session").click(function(){
                    var request = MioAjax({
                        button_element:this,
                        waiting_text: '<?php echo __("website/others/button1-pending"); ?>',
                        action:"<?php echo Controllers::$init->ControllerURI(); ?>",
                        method:"POST",
                        data:{
                            inc:   "panel_operation_method",
                            method: "serial-console",
                            value:      $('#SessionTime').val(),
                        }
                    },true,true);
                    request.done(solusvm_ajax_result);
                });
                $("#SolusVM_cancel_session").click(function(){
                    var request = MioAjax({
                        button_element:this,
                        waiting_text: '<?php echo __("website/others/button1-pending"); ?>',
                        action:"<?php echo Controllers::$init->ControllerURI(); ?>",
                        method:"POST",
                        data:{
                            inc:   "panel_operation_method",
                            method: "serial-console",
                            value:      1,
                            access: "disable",
                        }
                    },true,true);
                    request.done(solusvm_ajax_result);
                });
            });
        </script>
        <div class="adminpagecon">

            <?php
                $console_enable     = false;
                if(isset($options["console_info"]) && $options["console_info"]){
                    $co_info    = $options["console_info"];
                    $start      = $co_info["start"];
                    $finish     = $co_info["finish"];
                    $now_t      = DateManager::strtotime();
                    $finish_t   = DateManager::strtotime($finish);
                    if($finish_t > $now_t) $console_enable = true;
                    $html5_console_link = Controllers::$init->ControllerURI();
                    $html5_console_link .= "?inc=panel_operation_method&method=html5-console";
                }


                if($console_enable){
                    ?>
                    <div class="yuzde50">
                        <a class="gonderbtn redbtn" id="SolusVM_cancel_session" href="javascript:void 0;">Cancel Session</a>
                    </div>

                    <div class="clear"></div>
                    <br>

                    <div class="blue-info">
                        <div class="padding20">
                            The following connection details may be used in any local SSH client. For Windows you can download a free copy of Putty or for Mac/Linux open a terminal and use "ssh <?php echo $co_info["consoleusername"]; ?>@<?php echo $co_info["consoleip"]; ?> -p <?php echo $co_info["consoleport"]; ?>"
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30">Expires</div>
                        <div class="yuzde70">
                            <span id="get_expires"></span>
                            <script type="text/javascript">
                                $(document).ready(function(){
                                    $('#get_expires').countdown('<?php echo $finish; ?>', function(event) {
                                        $(this).html(event.strftime('%H:%M:%S'));
                                    });
                                });
                            </script>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30">Address</div>
                        <div class="yuzde70">
                            <?php echo $co_info["consoleip"]; ?>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30">Port</div>
                        <div class="yuzde70">
                            <?php echo $co_info["consoleport"]; ?>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30">Username</div>
                        <div class="yuzde70">
                            <?php echo $co_info["consoleusername"]; ?>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30">Password</div>
                        <div class="yuzde70">
                            <?php echo $co_info["consolepassword"]; ?>
                        </div>
                    </div>

                    <div class="yuzde50">
                        <a class="gonderbtn mavibtn" onclick="window.open('<?php echo $html5_console_link; ?>', 'htmlconsole', 'width=880,height=600,status=no,resizable=yes,copyhistory=no,location=no,toolbar=no,menubar=no,scrollbars=1')" href="javascript:void 0;">HTML5 Console</a>
                    </div>


                    <?php
                }else{
                    ?>
                    <div class="formcon">
                        <div class="yuzde30">Session Time</div>
                        <div class="yuzde70">
                            <select id="SessionTime" class="yuzde50">
                                <option value="1">1 Hour</option>
                                <option value="2">2 Hours</option>
                                <option value="3">3 Hours</option>
                                <option value="4">4 Hours</option>
                                <option value="5">5 Hours</option>
                                <option value="6">6 Hours</option>
                                <option value="7">7 Hours</option>
                                <option value="8">8 Hours</option>
                            </select>
                            <span class="yuzde50">
                         <a id="SolusVM_create_session" class="yesilbtn gonderbtn" href="javascript:void(0);">Create Session</a>
                    </span>

                        </div>
                    </div>
                    <?php
                }
            ?>


        </div>
    </div>

    <div id="action-vnc" class="tabcontent">
        <div class="adminpagecon">



            <div class="formcon">
                <a class="lbtn" href="https://www.tightvnc.com/release-jviewer2.php" target="_blank" style="margin-left: 5px;"><?php echo $LANG["vnc-text2"]; ?></a>
                <div class="clear"></div>
                <br>
            </div>

            <?php
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

</div>