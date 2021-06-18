<!DOCTYPE html>
<html>
<head>
    <?php
        $plugins    = ['jquery-ui'];
        include __DIR__.DS."inc".DS."head.php";
    ?>

    <script type="text/javascript">
        $(document).ready(function(){
            $("#addNewForm").bind("keypress", function(e) {
                if (e.keyCode == 13) $("#addNewForm_submit").click();
            });

            $("#addNewForm_submit").on("click",function(){
                $("input[name=operation]").val('add_new_hosting_shared_server');
                MioAjaxElement($(this),{
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                    result:"addNewForm_handler",
                });
            });

            $("#testConnect").on("click",function(){
                $("input[name=operation]").val('test_shared_server_connect');
                MioAjaxElement($(this),{
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                    result:"testConnect_handler",
                });
            });


            $("select[name=type]").change(function(){
                var checker     = $("option:selected",this).data("checker");
                var have_port   = $("option:selected",this).data("have-port");
                var access_hash = $("option:selected",this).data("access-hash");
                var nport       = $("option:selected",this).data("port");
                var sport       = $("option:selected",this).data("secure-port");
                var type        = $("option:selected",this).data("type");
                var secure      = $("#secure").prop("checked");

                if(type === "virtualization"){
                    $(".virtualization-content").css("display","block");
                }else{
                    $(".virtualization-content").css("display","none");
                }

                if(checker != undefined && checker){
                    $("#checker-wrap").fadeIn(100);
                }else{
                    $("#checker-wrap").fadeOut(100);
                }

                if(have_port != undefined && have_port){
                    $("input[name=port]").val(secure ? sport : nport).attr("readonly",true);
                    $("#custom_port").prop("checked",false);
                    $("#port-wrap").fadeIn(100);
                }else{
                    $("input[name=port]").val('').attr("readonly",true);
                    $("#custom_port").prop("checked",false);
                    $("#port-wrap").fadeOut(100);
                }

                if(access_hash !== undefined && access_hash){
                    $("#access-hash-wrap").fadeIn(100);
                }else{
                    $("#access-hash-wrap").fadeOut(100);
                }

            });

        });

        function testConnect_handler(result){
            if(result != ''){
                var solve = getJson(result);
                if(solve !== false){
                    if(solve.status == "error"){
                        if(solve.for != undefined && solve.for != ''){
                            $("#addNewForm "+solve.for).focus();
                            $("#addNewForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                            $("#addNewForm "+solve.for).change(function(){
                                $(this).removeAttr("style");
                            });
                        }
                        if(solve.message != undefined && solve.message != '')
                            alert_error(solve.message,{timer:5000});
                    }else if(solve.status == "successful"){
                        alert_success(solve.message,{timer:2000});
                        if(solve.redirect != undefined && solve.redirect != ''){
                            setTimeout(function(){
                                window.location.href = solve.redirect;
                            },2000);
                        }
                    }
                }else
                    console.log(result);
            }
        }

        function change_secure(elem){
            var check   = $(elem).prop("checked");
            var type    = $("select[name=type] option:selected");

            if(check)
                $('input[name=port]').val(type.data("secure-port"));
            else
                $('input[name=port]').val(type.data("port"));
        }

        function addNewForm_handler(result){
            if(result != ''){
                var solve = getJson(result);
                if(solve !== false){
                    if(solve.status == "error"){
                        if(solve.for != undefined && solve.for != ''){
                            $("#addNewForm "+solve.for).focus();
                            $("#addNewForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                            $("#addNewForm "+solve.for).change(function(){
                                $(this).removeAttr("style");
                            });
                        }
                        if(solve.message != undefined && solve.message != '')
                            alert_error(solve.message,{timer:5000});
                    }else if(solve.status == "successful"){
                        alert_success(solve.message,{timer:2000});
                        if(solve.redirect != undefined && solve.redirect != ''){
                            setTimeout(function(){
                                window.location.href = solve.redirect;
                            },2000);
                        }
                    }
                }else
                    console.log(result);
            }
        }
    </script>

</head>
<body>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1><strong><?php echo __("admin/products/page-add-hosting-shared-server"); ?></strong></h1>
                <?php
                $ui_help_link = 'https://docs.wisecp.com/en/kb/shared-server-settings';
                if($ui_lang == "tr") $ui_help_link = 'https://docs.wisecp.com/tr/kb/paylasimli-sunucu-ayarlari';
                ?>
                <a title="<?php echo __("admin/help/usage-guide"); ?>" target="_blank" class="pagedocslink" href="<?php echo $ui_help_link; ?>"><i class="fa fa-life-ring" aria-hidden="true"></i></a>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="clear"></div>

            <div class="adminuyedetay">

                <form action="<?php echo $links["controller"]; ?>" method="post" id="addNewForm">
                    <input type="hidden" name="operation" value="">

                    
                    <div class="clear"></div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/products/add-hosting-shared-server-name"); ?></div>
                        <div class="yuzde70">
                            <input type="text" name="name" value="" placeholder="<?php echo __("admin/products/add-hosting-shared-server-name-desc"); ?>">
                            
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/products/add-hosting-shared-server-dns"); ?><br><span style="font-weight:normal" class="kinfo"><?php echo __("admin/products/add-hosting-shared-server-dns-desc"); ?></span></div>
                        <div class="yuzde70">
                            <input type="text" name="ns1" value="" placeholder="ns1.example.com">
                            <input type="text" name="ns2" value="" placeholder="ns2.example.com">
                            <input type="text" name="ns3" value="" placeholder="ns3.example.com">
                            <input type="text" name="ns4" value="" placeholder="ns4.example.com">
                            
                        </div>
                    </div>

                    <!--div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/products/add-hosting-shared-server-maxaccounts"); ?></div>
                        <div class="yuzde70">
                            <input type="text" name="maxaccounts" value="" style="width: 50px;">
                            <span class="kinfo"><?php echo __("admin/products/add-hosting-shared-server-maxaccounts-desc"); ?></span>
                        </div>
                    </div-->

                    <div class="clear"></div>
                    <br>

                    <div class="blue-info">
                        <div class="padding20">
                            <i class="fa fa-cogs" aria-hidden="true"></i>
                         <p>  <strong> <?php echo __("admin/products/add-hosting-shared-server-information-desc"); ?></strong></p>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/products/add-hosting-shared-server-type"); ?></div>
                        <div class="yuzde70">
                            <select name="type">
                                <?php
                                    if(isset($server_modules) && $server_modules){
                                        $i=0;
                                        foreach($server_modules AS $k=>$v){
                                            $i++;


                                            $checker = isset($v["config"]["server-info-checker"]) ? $v["config"]["server-info-checker"] : false;
                                            $havePort = isset($v["config"]["server-info-port"]) ? $v["config"]["server-info-port"] : false;
                                            $port = isset($v["config"]["server-info-not-secure-port"]) ? $v["config"]["server-info-not-secure-port"] : 0;
                                            $sport = isset($v["config"]["server-info-secure-port"]) ? $v["config"]["server-info-secure-port"] : 0;
                                            $access_hash = isset($v["config"]["access-hash"]) ? $v["config"]["access-hash"] : false;

                                            if($i == 1){
                                                $first_module = [
                                                    'type'          => $v["config"]["type"],
                                                    'port'          => $port,
                                                    'secure-port'   => $sport,
                                                    'have-port'     => $havePort,
                                                    'checker'       => $checker,
                                                    'access-hash'   => $access_hash,
                                                ];
                                            }
                                            ?>
                                            <option data-type="<?php echo $v["config"]["type"]; ?>" data-access-hash="<?php echo $access_hash; ?>" data-secure-port="<?php echo $sport; ?>" data-port="<?php echo $port; ?>" data-have-port="<?php echo $havePort ? 'true' : 'false'; ?>" data-checker="<?php echo $checker ? 'true' : 'false'; ?>"><?php echo $k; ?></option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                            <div class="clear"></div>
                            <span class="kinfo"><?php echo __("admin/products/add-hosting-shared-server-type-desc"); ?></span>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/products/add-hosting-shared-server-ip"); ?></div>
                        <div class="yuzde70">
                            <input type="text" name="ip" value="" placeholder="<?php echo __("admin/products/add-hosting-shared-server-ip-desc"); ?>">
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/products/add-hosting-shared-server-username"); ?></div>
                        <div class="yuzde70">
                            <input type="text" name="username" value="" placeholder="<?php echo __("admin/products/add-hosting-shared-server-username-desc"); ?>">
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/products/add-hosting-shared-server-password"); ?></div>
                        <div class="yuzde70">
                            <input type="text" name="password" value="" placeholder="<?php echo __("admin/products/add-hosting-shared-server-password-desc"); ?>">
                        </div>
                    </div>

                    <div class="formcon" id="access-hash-wrap"<?php echo $first_module["access-hash"] ? '' : 'style="display:none;"'; ?>>
                        <div class="yuzde30"><?php echo __("admin/products/add-hosting-shared-server-access-hash"); ?></div>
                        <div class="yuzde70">
                            <textarea rows="8" name="access-hash" placeholder="<?php echo __("admin/products/add-hosting-shared-server-access-hash-desc"); ?>"></textarea>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/products/add-hosting-shared-server-secure"); ?></div>
                        <div class="yuzde70">
                            <input type="checkbox" name="secure" value="1" class="checkbox-custom" id="secure" onchange="change_secure(this);">
                            <label class="checkbox-custom-label" for="secure"><?php echo __("admin/products/add-hosting-shared-server-secure-desc"); ?></label>
                        </div>
                    </div>

                    <div class="formcon" id="port-wrap"<?php echo $first_module["have-port"] ? '' : 'style="display:none;"'; ?>>
                        <div class="yuzde30"><?php echo __("admin/products/add-hosting-shared-server-port"); ?></div>
                        <div class="yuzde70">
                            <input readonly type="text" name="port" value="<?php echo $first_module["port"]; ?>" style="width: 50px;">
                            <input onchange="if($(this).prop('checked')) $('input[name=port]').removeAttr('readonly').focus(); else $('input[name=port]').attr('readonly',true);" type="checkbox" id="custom_port" class="checkbox-custom">
                            <label class="checkbox-custom-label" for="custom_port"><?php echo __("admin/products/add-hosting-shared-port-custom"); ?></label>
                        </div>
                    </div>

                    <div class="formcon virtualization-content" style="<?php echo isset($first_module["type"]) && $first_module["type"] == "virtualization" ? '' : 'display: none;'; ?>">
                        <div class="yuzde30">
                            <?php echo __("admin/products/shared-server-updowngrade-settings"); ?>
                            <div class="clear"></div>
                            <span class="kinfo"><?php echo __("admin/products/shared-server-updowngrade-settings-desc"); ?></span>
                        </div>
                        <div class="yuzde70">

                            <div style="margin-bottom: 5px;">

                                <input checked type="radio" name="updowngrade_remove_server" class="radio-custom" id="updowngrade_remove_server_1" value="then">
                                <label class="radio-custom-label" for="updowngrade_remove_server_1"><?php echo __("admin/products/shared-server-updowngrade-settings-1",[
                                        '{input}' => '<input type="text" name="updowngrade_remove_server_day" class="yuzde10" value="2" onkeypress="return event.charCode>= 48 &&event.charCode<= 57">',
                                    ]); ?></label>
                            </div>
                            <div class="clear"></div>

                            <div style="margin-bottom: 5px;">
                                <input type="radio" name="updowngrade_remove_server" class="radio-custom" id="updowngrade_remove_server_2" value="now">
                                <label class="radio-custom-label" for="updowngrade_remove_server_2"><?php echo __("admin/products/shared-server-updowngrade-settings-2"); ?></label>
                            </div>
                            <div class="clear"></div>

                            <div style="margin-bottom: 5px;">
                                <input type="radio" name="updowngrade_remove_server" class="radio-custom" id="updowngrade_remove_server_3" value="none">
                                <label class="radio-custom-label" for="updowngrade_remove_server_3"><?php echo __("admin/products/shared-server-updowngrade-settings-3"); ?></label>
                            </div>

                            <div class="clear"></div>

                        </div>
                    </div>


                    <div class="formcon" id="checker-wrap"<?php echo $first_module["checker"] ? '' : 'style="display:none"'; ?>>
                        <div class="yuzde30"><?php echo __("admin/products/add-hosting-shared-server-info-check"); ?></div>
                        <div class="yuzde70">
                            <a href="javascript:void(0);" id="testConnect" class="lbtn"><i class="fa fa-plug" aria-hidden="true"></i> <?php echo __("admin/products/add-hosting-shared-server-info-check-button"); ?></a>
                        </div>
                    </div>


                    <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                        <a class="yesilbtn gonderbtn" id="addNewForm_submit" href="javascript:void(0);"><?php echo __("admin/products/add-new-shared-server-button"); ?></a>
                    </div>
                    <div class="clear"></div>


                </form>

            </div>


            <div class="clear"></div>
        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>