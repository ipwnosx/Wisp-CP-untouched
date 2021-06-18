<?php
    $LANG           = $module->lang;
    $established    = false;
    $options        = $order["options"];
    $creation_info  = isset($options["creation_info"]) ? $options["creation_info"] : [];
    $config         = isset($options["config"]) ? $options["config"] : [];
    if($config && isset($config["vserverid"])) $established = true;

    $nodes          = $module->nodes_by_types();
    $plans          = $module->plans_by_types();
    $templates      = $module->templates_by_types();
    $list_iso       = $module->list_iso();

    if($creation_info){
        $virtualization_type    = isset($creation_info["virtualization_type"]) ? $creation_info["virtualization_type"] : false;
        $node                   = isset($creation_info["node"]) ? $creation_info["node"] : false;
        $plan                   = isset($creation_info["plan"]) ? $creation_info["plan"] : false;
        $template               = isset($creation_info["template"]) ? $creation_info["template"] : false;
        $extra_ip               = isset($creation_info["extra_ip"]) ? $creation_info["extra_ip"] : false;
    }
    else{
        $virtualization_type    = false;
        $node                   = false;
        $plan                   = false;
        $template               = false;
        $extra_ip               = false;
    }

    if($established){
        $info           = $module->get_vserver_info();
        $vnc_info       = $module->get_vnc_info();
        $ip_addresses   = [];
        if(isset($info["ipaddresses"]) && $info["ipaddresses"]) $ip_addresses = explode(",",$info["ipaddresses"]);
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

        var tab = _GET("action");
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
<div id="tab-action">
    <ul class="tab">
        <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'detail','action');" data-tab="detail"><i class="fa fa-info" aria-hidden="true"></i> <?php echo $LANG["tab-details"]; ?></a></li>

        <?php if($established): ?>

        <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'settings','action');" data-tab="settings"><i class="fa fa-cog" aria-hidden="true"></i> <?php echo $LANG["tab-settings"]; ?></a></li>

        <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'change-hostname','action');" data-tab="change-hostname"><i class="fa fa-user" aria-hidden="true"></i> <?php echo $LANG["tab-change-hostname"]; ?></a></li>

        <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'change-password','action');" data-tab="change-password"><i class="fa fa-key" aria-hidden="true"></i> <?php echo $LANG["tab-change-password"]; ?></a></li>

            <?php if(isset($ip_addresses) && sizeof($ip_addresses)>1): ?>
                <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'network','action');" data-tab="network"><i class="fa fa-globe" aria-hidden="true"></i> <?php echo $LANG["tab-network"]; ?></a></li>
            <?php endif; ?>

            <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'console','action');" data-tab="console"><i class="fa fa-terminal" aria-hidden="true"></i> Console</a></li>

        <?php endif; ?>

        <?php if($established && $vnc_info["status"]): ?>
            <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'vnc','action');" data-tab="vnc"><i class="fa fa-play" aria-hidden="true"></i> VNC</a></li>
        <?php endif; ?>

    </ul>

    <div id="action-detail" class="tabcontent">

        <div class="adminpagecon">

            <input type="hidden" id="SolusVM_use_method" name="use_method" value="">
            <?php
                if($established){
                    ?>
                    <input type="hidden" name="creation_info[virtualization_type]" value="<?php echo $virtualization_type; ?>">
                    <input type="hidden" name="creation_info[node]" value="<?php echo $node; ?>">
                    <input type="hidden" name="creation_info[plan]" value="<?php echo $plan; ?>">
                    <input type="hidden" name="creation_info[template]" value="<?php echo $template; ?>">
                    <input type="hidden" name="creation_info[extra_ip]" value="<?php echo $extra_ip; ?>">
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
                                    <h5 style="font-size:16px;"><strong><?php echo $LANG["bandwidth"]; ?></strong></h5>
                                    <div class="clear"></div>
                                    <div class="progress-circle progress-<?php echo $statistics["bandwidth"]["percent"]; ?>"><span><?php echo $statistics["bandwidth"]["percent"]; ?></span></div>
                                    <div class="clear"></div>
                                    <h5 style="font-size:16px;"><?php echo $statistics["bandwidth"]["format-used"]; ?> / <?php echo $statistics["bandwidth"]["format-limit"]; ?></h5>
                                </div>
                                <?php
                            }

                        ?>

                    </div>
                </div>

                <div class="formcon" id="SolusVM_operations_wrap">
                    <div class="yuzde30"><?php echo $LANG["operations"]; ?></div>
                    <div class="yuzde70">

                        <script type="text/javascript">
                            $(document).ready(function(){

                                $("#SolusVM_operations_wrap").on("click",".SolusVM_operation_btn",function(){
                                    var use_method = $(this).data("use-method");
                                    $("#SolusVM_use_method").val(use_method);
                                    $("#display_error").css("display","none");
                                    MioAjaxElement($(this),{
                                        waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                                        progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                                        result:"SolusVM_operation_handler",
                                    });
                                });

                                $(document).on('opening', '#rebuild_modal', function (e) {
                                    $("#rebuild_template").removeAttr("disabled").html($("select[name='creation_info[template]']").html());
                                });

                            });

                            function SolusVM_operation_handler(result){
                                $("#SolusVM_use_method").val('');
                                if(result !== ''){
                                    var solve = getJson(result);
                                    if(solve !== false){
                                        if(solve.status == "error"){
                                            if(solve.for !== undefined && solve.for === "delete") close_modal("delete_modal");
                                            else if(solve.for !== undefined && solve.for === "rebuild") close_modal("rebuild_modal");
                                            if(solve.message != undefined && solve.message != ''){
                                                $("#SolusVM_display_error").css("display","block");
                                                $("#SolusVM_display_error_text").html(solve.message);
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
                                        <a href="javascript:void 0;" class="gonderbtn redbtn SolusVM_operation_btn" data-use-method="delete"><i class="fa fa-check"></i> <?php echo ___("needs/iconfirm"); ?></a>
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
                                        <strong>Template</strong>
                                        <br>
                                        <select disabled name="rebuild_template" id="rebuild_template"></select>
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
                        <div id="reset_vnc_password_modal" style="display:none;" data-izimodal-title="<?php echo $LANG["reset-vnc-password"]; ?>">
                            <div class="padding20">

                                <div align="center">
                                    <p>
                                        <b style="font-size:18px;"><?php echo ___("needs/apply-are-you-sure"); ?></b>
                                        <br><br>
                                    </p>

                                    <div class="yuzde50">
                                        <a href="javascript:void 0;" class="gonderbtn redbtn SolusVM_operation_btn" data-use-method="reset-vnc-password"><i class="fa fa-check"></i> <?php echo ___("needs/yes"); ?></a>
                                    </div>
                                    <br><br>

                                </div>
                            </div>
                        </div>

                        <a class="lbtn" href="javascript:open_modal('delete_modal',{headerColor:'red'});void 0;"><i class="fa fa-trash" aria-hidden="true"></i> <?php echo $LANG["delete"]; ?></a>

                        <a class="lbtn orange" href="javascript:open_modal('rebuild_modal',{headerColor:'orange'});void 0;"><i class="fa fa-cogs" aria-hidden="true"></i> Rebuild</a>

                        <?php if($server_status): ?>
                            <a class="lbtn" href="javascript:open_modal('reboot_modal',{headerColor:'red'});void 0;"><i class="fa fa-retweet" aria-hidden="true"></i> Reboot</a>
                            <a class="red lbtn" href="javascript:open_modal('shutdown_modal',{headerColor:'red'});void 0;"><i class="fa fa-power-off" aria-hidden="true"></i> Shutdown</a>
                        <?php else: ?>
                            <a class="green lbtn SolusVM_operation_btn" data-use-method="power-on" href="javascript:void 0;"><i class="fa fa-leaf" aria-hidden="true"></i> Power On</a>
                        <?php endif; ?>

                        <?php if($vnc_info["status"]): ?>
                            <a class="lbtn" href="javascript:open_modal('reset_vnc_password_modal',{headerColor:'red'});void 0;"><?php echo $LANG["reset-vnc-password"]; ?></a>
                        <?php endif; ?>

                        <div class="clear"></div>
                        <div class="red-info" style="display: none;" id="SolusVM_display_error">
                            <div class="padding10" id="SolusVM_display_error_text"></div>
                        </div>


                    </div>
                </div>
            <?php endif; ?>

            <div class="formcon">
                <div class="yuzde30">Virtual Server ID</div>
                <div class="yuzde70">
                    <input type="text" name="config[vserverid]" value="<?php echo isset($config["vserverid"]) ? $config["vserverid"] : ''; ?>" style="width: 100px;">
                </div>
            </div>

            <?php
                if(!$established){
                ?>
                    <script type="text/javascript">
                        $(document).ready(function(){

                            $("#SolusVM_install_btn").click(function(){
                                $("#SolusVM_use_method").val('install');
                                $("#display_error").css("display","none");
                                MioAjaxElement($(this),{
                                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                                    progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                                    result:"SolusVM_install_handler",
                                });
                            });
                        });

                        function SolusVM_install_handler(result){
                            $("#SolusVM_use_method").val('');
                            if(result !== ''){
                                var solve = getJson(result);
                                if(solve !== false){
                                    if(solve.status == "error"){
                                        if(solve.message != undefined && solve.message != ''){
                                            $("#SolusVM_display_error").css("display","block");
                                            $("#SolusVM_display_error_text").html(solve.message);
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

                            <a class="green lbtn" href="javascript:void 0;" id="SolusVM_install_btn"><i class="fa fa-cog"></i> <?php echo $LANG["install"]; ?></a>

                            <div class="clear"></div>
                            <div class="red-info" style="display: none;" id="SolusVM_display_error">
                                <div class="padding10" id="SolusVM_display_error_text"></div>
                            </div>

                        </div>
                    </div>
                    <?php
                }
            ?>

            <script type="text/javascript">
                var vz_type     = "<?php echo $virtualization_type; ?>";
                var s_node      = "<?php echo $node; ?>";
                var s_plan      = "<?php echo $plan; ?>";
                var s_template  = "<?php echo $template; ?>";
                var nodes       = <?php echo $nodes ? Utility::jencode($nodes) : "{}"; ?>;
                var plans       = <?php echo $plans ? Utility::jencode($plans) : "{}"; ?>;
                var templates   = <?php echo $templates ? Utility::jencode($templates) : "{}"; ?>;
                var list_iso    = <?php echo $list_iso ? Utility::jencode($list_iso) : "{}"; ?>;
                $(document).ready(function(){
                    fetch_nodes(vz_type,s_node);
                    fetch_plans(vz_type,s_plan);
                    fetch_templates(vz_type,s_template);

                    $("#SolusVM_type").change(function(){
                        fetch_nodes($(this).val(),s_node);
                        fetch_plans($(this).val(),s_plan);
                        fetch_templates($(this).val(),s_template);
                    });
                });

                function fetch_nodes(type,selected){
                    if(nodes[type]){
                        $("#SolusVM_node").html('<option value=""><?php echo ___("needs/select-your"); ?></option>');
                        $.each(nodes[type],function(k,v){
                            $("#SolusVM_node").append('<option'+(selected === v ? ' selected' : '')+' value="'+v+'">'+v+'</option>');
                        });
                    }else
                        $("#SolusVM_node").html('<option value=""><?php echo ___("needs/none"); ?></option>');
                }
                function fetch_plans(type,selected){
                    if(plans[type]){
                        $("#SolusVM_plan").html('<option value=""><?php echo ___("needs/select-your"); ?></option>');
                        $.each(plans[type],function(k,v){
                            $("#SolusVM_plan").append('<option'+(selected === v ? ' selected' : '')+' value="'+v+'">'+v+'</option>');
                        });
                    }else
                        $("#SolusVM_plan").html('<option value=""><?php echo ___("needs/none"); ?></option>');
                }
                function fetch_templates(type,selected){
                    var have=false,iso_group='';
                    if(templates[type]){
                        have = true;
                        $("#SolusVM_template").html('<option value=""><?php echo ___("needs/select-your"); ?></option>');
                        $.each(templates[type],function(k,v){
                            $("#SolusVM_template").append('<option'+(selected === v.name ? ' selected' : '')+' value="'+v.name+'">'+v.name+(v.os != '' ? ' ('+v.os+')' : '')+'</option>');
                        });
                    }

                    if(list_iso[type]){
                        if(!have) $("#SolusVM_template").html('<option value=""><?php echo ___("needs/select-your"); ?></option>');
                        have = true;
                        iso_group = '<optgroup label="<?php echo $LANG["iso"]; ?>">';
                        $.each(list_iso[type],function(k,v){
                            iso_group += '<option'+(selected === v ? ' selected' : '')+' value="'+v+'">'+v+'</option>';
                        });
                        iso_group += '</optgroup>';

                        $("#SolusVM_template").append(iso_group);
                    }

                    if(!have) $("#SolusVM_template").html('<option value=""><?php echo ___("needs/none"); ?></option>');
                }
            </script>

            <div class="formcon">
                <div class="yuzde30"><?php echo $LANG["virtualization_type"]; ?></div>
                <div class="yuzde70">
                    <select<?php echo $established ? ' disabled' : ''; ?> name="creation_info[virtualization_type]" id="SolusVM_type">
                        <option value=""><?php echo ___("needs/select-your"); ?></option>
                        <?php
                            if($module->config["virtualization-types"]){
                                foreach($module->config["virtualization-types"] AS $vz_key => $vz_name){
                                    ?>
                                    <option<?php echo $virtualization_type == $vz_key ? " selected" : ''; ?> value="<?php echo $vz_key; ?>"><?php echo $vz_name; ?></option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>

            <div class="formcon">
                <div class="yuzde30"><?php echo $LANG["node"]; ?></div>
                <div class="yuzde70">
                    <select<?php echo $established ? ' disabled' : ''; ?> name="creation_info[node]" id="SolusVM_node"></select>
                </div>
            </div>

            <div class="formcon">
                <div class="yuzde30"><?php echo $LANG["plan"]; ?></div>
                <div class="yuzde70">
                    <select name="creation_info[plan]" id="SolusVM_plan"></select>
                </div>
            </div>

            <div class="formcon">
                <div class="yuzde30"><?php echo $LANG["template"]; ?></div>
                <div class="yuzde70">
                    <select<?php echo $established ? ' disabled' : ''; ?> name="creation_info[template]" id="SolusVM_template"></select>
                </div>
            </div>

            <div class="formcon" style="<?php echo $established ? 'display: none;' : ''; ?>">
                <div class="yuzde30"><?php echo $LANG["extra-ip"]; ?></div>
                <div class="yuzde70">
                    <input<?php echo $established ? ' disabled' : ''; ?> type="number" name="creation_info[extra_ip]" value="<?php echo $extra_ip; ?>" onkeypress='return event.charCode>= 48 &&event.charCode<= 57' style="width:100px;" min="0">
                </div>
            </div>

        </div>

    </div>

    <?php if($established): ?>
        <div id="action-settings" class="tabcontent">
            <div class="adminpagecon">
                <script type="text/javascript">
                    $(document).ready(function(){

                        $('#SolusVM_changeHDD').click(function(){
                            var request = MioAjax({
                                button_element:this,
                                waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                                action:"<?php echo Controllers::$init->ControllerURI(); ?>",
                                method:"POST",
                                data:{
                                    operation:  "operation_server_automation",
                                    use_method: "change-hdd",
                                    value:      $('#SolusVM_hdd_limit').val(),
                                }
                            },true,true);
                            request.done(solusvm_ajax_result);
                        });
                        $('#SolusVM_changeBandwidth').click(function(){
                            var request = MioAjax({
                                button_element:this,
                                waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                                action:"<?php echo Controllers::$init->ControllerURI(); ?>",
                                method:"POST",
                                data:{
                                    operation:  "operation_server_automation",
                                    use_method: "change-bandwidth",
                                    value:      $('#SolusVM_bandwidth_limit').val(),
                                }
                            },true,true);
                            request.done(solusvm_ajax_result);
                        });
                        $('#SolusVM_changeMemory').click(function(){
                            var request = MioAjax({
                                button_element:this,
                                waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                                action:"<?php echo Controllers::$init->ControllerURI(); ?>",
                                method:"POST",
                                data:{
                                    operation:  "operation_server_automation",
                                    use_method: "change-memory",
                                    value:      $('#SolusVM_memory_limit').val(),
                                }
                            },true,true);
                            request.done(solusvm_ajax_result);
                        });
                        $('#SolusVM_changeCpu').click(function(){
                            var request = MioAjax({
                                button_element:this,
                                waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                                action:"<?php echo Controllers::$init->ControllerURI(); ?>",
                                method:"POST",
                                data:{
                                    operation:  "operation_server_automation",
                                    use_method: "change-cpu",
                                    value:      $('#SolusVM_cpu_limit').val(),
                                }
                            },true,true);
                            request.done(solusvm_ajax_result);
                        });
                        $('#SolusVM_changeNspeed').click(function(){
                            var request = MioAjax({
                                button_element:this,
                                waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                                action:"<?php echo Controllers::$init->ControllerURI(); ?>",
                                method:"POST",
                                data:{
                                    operation:  "operation_server_automation",
                                    use_method: "change-nspeed",
                                    value:      $('#SolusVM_nspeed_limit').val(),
                                }
                            },true,true);
                            request.done(solusvm_ajax_result);
                        });


                    });
                </script>

                <div class="formcon">
                    <div class="yuzde30"><?php echo $LANG["change-hdd"]; ?></div>
                    <div class="yuzde30">
                       <input type="number" id="SolusVM_hdd_limit" min="0" style="width: 80px;">
                        <span>GB</span>
                    </div>
                    <div class="yuzde40">
                        <a class="lbtn blue" href="javascript:void 0;" id="SolusVM_changeHDD"><?php echo ___("needs/button-update"); ?></a>
                    </div>
                </div>
                <div class="formcon">
                    <div class="yuzde30"><?php echo $LANG["change-bandwidth"]; ?></div>
                    <div class="yuzde30">
                        <input type="number" id="SolusVM_bandwidth_limit" min="0" style="width: 80px;">
                        <span>GB</span>
                    </div>
                    <div class="yuzde40">
                        <a class="lbtn blue" href="javascript:void 0;" id="SolusVM_changeBandwidth"><?php echo ___("needs/button-update"); ?></a>
                    </div>
                </div>
                <div class="formcon">
                    <div class="yuzde30"><?php echo $LANG["change-memory"]; ?></div>
                    <div class="yuzde30">
                       <input type="number" id="SolusVM_memory_limit" min="0" style="width: 80px;">
                        <span>MB</span>
                    </div>
                    <div class="yuzde40">
                        <a class="lbtn blue" href="javascript:void 0;" id="SolusVM_changeMemory"><?php echo ___("needs/button-update"); ?></a>
                    </div>
                </div>
                <div class="formcon">
                    <div class="yuzde30"><?php echo $LANG["change-cpu"]; ?></div>
                    <div class="yuzde30">
                       <input type="number" id="SolusVM_cpu_limit" min="1" max="128" style="width: 80px;">
                        <span> </span>
                    </div>
                    <div class="yuzde40">
                        <a class="lbtn blue" href="javascript:void 0;" id="SolusVM_changeCpu"><?php echo ___("needs/button-update"); ?></a>
                    </div>
                </div>
                <div class="formcon">
                    <div class="yuzde30"><?php echo $LANG["change-nspeed"]; ?></div>
                    <div class="yuzde30">
                       <input type="number" id="SolusVM_nspeed_limit" min="0" style="width: 80px;">
                        <span> </span>
                    </div>
                    <div class="yuzde40">
                        <a class="lbtn blue" href="javascript:void 0;" id="SolusVM_changeNspeed"><?php echo ___("needs/button-update"); ?></a>
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
                                waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                                action:"<?php echo Controllers::$init->ControllerURI(); ?>",
                                method:"POST",
                                data:{
                                    operation:   "operation_server_automation",
                                    use_method:  "change-hostname",
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
                                waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                                action:"<?php echo Controllers::$init->ControllerURI(); ?>",
                                method:"POST",
                                data:{
                                    operation:   "operation_server_automation",
                                    use_method:  "change-password",
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
    <?php endif; ?>

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
                                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                                    action:"<?php echo Controllers::$init->ControllerURI(); ?>",
                                    method:"POST",
                                    data:{
                                        operation:  "operation_server_automation",
                                        use_method: "change-main-ip-address",
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

        if($established){
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
                                    operation:  "operation_server_automation",
                                    use_method: "serial-console",
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
                                    operation:  "operation_server_automation",
                                    use_method: "serial-console",
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
                            $html5_console_link .= "?operation=operation_server_automation&use_method=html5-console";
                        }


                        if($console_enable){
                            ?>
                            <div align="center">
                                <div class="yuzde30">
                                    <a class="gonderbtn redbtn" id="SolusVM_cancel_session" href="javascript:void 0;">Cancel Session</a>
                                </div>
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

                            <div align="center">
                                <div class="yuzde30">
                                    <a class="gonderbtn mavibtn" onclick="window.open('<?php echo $html5_console_link; ?>', 'htmlconsole', 'width=880,height=600,status=no,resizable=yes,copyhistory=no,location=no,toolbar=no,menubar=no,scrollbars=1')" href="javascript:void 0;">HTML5 Console</a>
                                </div>
                            </div>


                            <?php
                        }else{
                            ?>
                            <div class="formcon">
                                <div class="yuzde30">Session Time</div>
                                <div class="yuzde70">
                                    <select id="SessionTime" class="yuzde30">
                                        <option value="1">1 Hour</option>
                                        <option value="2">2 Hours</option>
                                        <option value="3">3 Hours</option>
                                        <option value="4">4 Hours</option>
                                        <option value="5">5 Hours</option>
                                        <option value="6">6 Hours</option>
                                        <option value="7">7 Hours</option>
                                        <option value="8">8 Hours</option>
                                    </select>
                                    <span class="yuzde50" style="margin-left: 10px;">
                                        <span class="yuzde50">
                                            <a id="SolusVM_create_session" class="yesilbtn gonderbtn" href="javascript:void(0);">Create Session</a>
                                        </span>
                    </span>

                                </div>
                            </div>
                            <?php
                        }
                    ?>


                </div>
            </div>
            <?php
        }
    ?>

    <?php if($established && $vnc_info["status"]): ?>
        <div id="action-vnc" class="tabcontent">
            <div class="adminpagecon">

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
                <a class="lbtn" href="https://www.tightvnc.com/release-jviewer2.php" target="_blank" style="margin-left: 5px;"><?php echo $LANG["vnc-text2"]; ?></a>

            </div>
        </div>
    <?php endif; ?>


</div>