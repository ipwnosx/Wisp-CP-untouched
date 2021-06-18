<?php
    $LANG                   = $module->lang;
    $established            = false;
    $options                = $order["options"];
    $creation_info          = isset($options["creation_info"]) ? $options["creation_info"] : [];
    $config                 = isset($options["config"]) ? $options["config"] : [];
    if(isset($config["package"]) && $config["package"]) $established = true;
    $details                = $module->get_details();

    if($established && $details && in_array($details["status"],["Active","Suspended","Cancelled","Terminated"])){
        ?>
        <div class="block_module_details-title formcon"><h4><?php echo $LANG["change-ip-address"]; ?></h4></div>
        <div class="hizmetblok" id="block_module_details_con">

            <script type="text/javascript">
                $(document).ready(function(){
                    var current_ip = '<?php echo $options["ip"]; ?>';

                    $("#ChangeForm").change(function(){
                        var changes          = false;
                        var get_ip           = $("input[name=change-ip]").val();


                        if(get_ip !== '' && get_ip !== current_ip) changes = true;

                        if(changes)
                            $("#apply_changes_btn").removeClass("graybtn").addClass("yesilbtn");
                        else
                            $("#apply_changes_btn").removeClass("yesilbtn").addClass("graybtn");

                    });

                    $("#apply_changes_btn").click(function(){
                        if($(this).hasClass("yesilbtn")){
                            var request = MioAjax({
                                waiting_text: '<?php echo __("website/others/button1-pending"); ?>',
                                method:$("#ChangeForm").attr("method"),
                                action:$("#ChangeForm").attr("action"),
                                data:$("#ChangeForm").serialize(),
                                button_element:$(this),
                            },true,true);

                            request.done(function(result){
                                if(result != ''){
                                    var solve = getJson(result);
                                    if(solve !== false){
                                        if(solve.status == "error"){
                                            if(solve.for != undefined && solve.for != ''){
                                                $("#ChangeForm "+solve.for).focus();
                                                $("#ChangeForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                                $("#ChangeForm "+solve.for).change(function(){
                                                    $(this).removeAttr("style");
                                                });
                                            }
                                            if(solve.message != undefined && solve.message != '')
                                                alert_error(solve.message,{timer:5000});
                                        }else if(solve.status == "successful"){
                                            alert_success(solve.message,{timer:2000});
                                            if(solve.redirect != undefined && solve.redirect !== ''){
                                                setTimeout(function(){
                                                    window.location.href = solve.redirect;
                                                },2000);
                                            }
                                        }
                                    }else
                                        console.log(result);
                                }
                            });
                        }
                    });

                });
            </script>
            <form action="<?php echo $controller_link; ?>?action=use_method&method=apply_changes" method="post" id="ChangeForm">

                <div class="formcon">
                    <div class="yuzde30"><?php echo $LANG["new-ip-address"]; ?></div>
                    <div class="yuzde70">
                        <input type="text" name="change-ip" value="" style="width: 150px;" onkeypress='return event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57' placeholder="127.0.0.1">
                        <span class="kinfo"><?php echo $LANG["change-ip-address-info"]; ?></span>
                    </div>
                </div>

                <div class="clear"></div>
                <a class="gonderbtn graybtn" href="javascript:void 0;" id="apply_changes_btn"><?php echo $LANG["apply-changes-button"]; ?></a>
            </form>


        </div>
        <?php
    }