<?php
    if(!defined("CORE_FOLDER")) die();
    $LANG   = $module->lang;
    $CONFIG = $module->config;
?>
<form action="<?php echo Controllers::$init->getData("links")["controller"]; ?>" method="post" id="PHPMailerSettings">
    <input type="hidden" name="operation" value="module_controller">
    <input type="hidden" name="module" value="MailerPHP">
    <input type="hidden" name="controller" value="settings">


    <div class="formcon">
        <div class="yuzde30"><?php echo $LANG["settings-type"]; ?></div>
        <div class="yuzde70">
            <input<?php echo $CONFIG["type"] == "smtp" ? ' checked' : NULL; ?> type="radio" name="type" value="smtp" class="radio-custom" id="PHPMailer_type_smtp">
            <label style="margin-right:15px;" for="PHPMailer_type_smtp" class="radio-custom-label">SMTP</label>

            <input<?php echo $CONFIG["type"] == "mail" ? ' checked' : NULL; ?> type="radio" name="type" value="mail" class="radio-custom" id="PHPMailer_type_mail">
            <label style="margin-right:15px;" for="PHPMailer_type_mail" class="radio-custom-label">Mail</label>

        </div>
    </div>

    <div class="formcon">
        <div class="yuzde30"><?php echo $LANG["settings-host"]; ?></div>
        <div class="yuzde70">
            <input type="text" name="host" value="<?php echo $CONFIG["host"]; ?>">
            <span class="kinfo"><?php echo $LANG["settings-host-desc"]; ?></span>
        </div>
    </div>

    <div class="formcon">
        <div class="yuzde30"><?php echo $LANG["settings-secure"]; ?></div>
        <div class="yuzde70">
            <script type="text/javascript">
                $(document).ready(function(){
                    $("#PHPMailerSettings input[name=secure]").change(function(){
                        var val = $(this).val();
                        if(val === "ssl")
                            $("#PHPMailerSettings input[name=port]").val(465);
                        else
                            $("#PHPMailerSettings input[name=port]").val('');

                        $("#PHPMailerSettings input[name=port]").focus();

                    });
                });
            </script>
            <input<?php echo !$CONFIG["secure"] ? ' checked' : NULL; ?> type="radio" name="secure" value="" class="radio-custom" id="PHPMailer_secure_none">
            <label style="margin-right:15px;" for="PHPMailer_secure_none" class="radio-custom-label"><?php echo $LANG["settings-secure-none"]; ?></label>

            <input<?php echo $CONFIG["secure"] == "tls" ? ' checked' : NULL; ?> type="radio" name="secure" value="tls" class="radio-custom" id="PHPMailer_secure_tls">
            <label style="margin-right:15px;" for="PHPMailer_secure_tls" class="radio-custom-label">TLS</label>

            <input<?php echo $CONFIG["secure"] == "ssl" ? ' checked' : NULL; ?> type="radio" name="secure" value="ssl" class="radio-custom" id="PHPMailer_secure_ssl">
            <label style="margin-right:15px;" for="PHPMailer_secure_ssl" class="radio-custom-label">SSL</label>
            
            <br>
            <span class="kinfo"><?php echo $LANG["settings-secure-desc"]; ?></span>
        </div>
    </div>

    <div class="formcon">
        <div class="yuzde30"><?php echo $LANG["settings-port"]; ?></div>
        <div class="yuzde70">
            <input type="text" class="yuzde10" name="port" value="<?php echo $CONFIG["port"] ? $CONFIG["port"] : ''; ?>">
            <span class="kinfo"><?php echo $LANG["settings-port-desc"]; ?></span>
        </div>
    </div>

    <div class="formcon">
        <div class="yuzde30"><?php echo $LANG["settings-username"]; ?></div>
        <div class="yuzde70">
            <input type="text" name="username" value="<?php echo $CONFIG["username"]; ?>">
            <span class="kinfo"><?php echo $LANG["settings-username-desc"]; ?></span>
        </div>
    </div>

    <div class="formcon">
        <div class="yuzde30"><?php echo $LANG["settings-password"]; ?></div>
        <div class="yuzde70">
            <input type="password" name="password" value="<?php echo $CONFIG["password"] ? "*****" : NULL; ?>">
            <span class="kinfo"><?php echo $LANG["settings-password-desc"]; ?></span>
        </div>
    </div>

    <div class="formcon">
        <div class="yuzde30"><?php echo $LANG["settings-from-name"]; ?></div>
        <div class="yuzde70">
            <input type="text" name="fname" value="<?php echo $CONFIG["fname"]; ?>">
            <span class="kinfo"><?php echo $LANG["settings-from-name-desc"]; ?></span>
        </div>
    </div>

    <div class="formcon">
        <div>
            <a style="cursor: pointer;" id="PHPMailer_TestSMTPConnect" class="lbtn"><i class="fa fa-plug"></i> <?php echo $LANG["test-smtp-connect"]; ?></a>
        </div>
    </div>

    <div style="float:right;" class="guncellebtn yuzde30"><a id="PHPMailerSettings_submit" href="javascript:void(0);" class="yesilbtn gonderbtn"><?php echo $LANG["save-settings-button"]; ?></a></div>

</form>

<script type="text/javascript">
    $(document).ready(function(){
        $("#PHPMailer_TestSMTPConnect").click(function(){
            $("#PHPMailerSettings input[name='controller']").val('test-connection');
            MioAjaxElement($(this),{
                waiting_text:waiting_text,
                progress_text:progress_text,
                result:"PHPMailerSettings_handler",
            });
        });

        $("#PHPMailerSettings_submit").click(function(){
            $("#PHPMailerSettings input[name='controller']").val('settings');
            MioAjaxElement($(this),{
                waiting_text:waiting_text,
                progress_text:progress_text,
                result:"PHPMailerSettings_handler",
            });
        });
    });

    function PHPMailerSettings_handler(result){
        if(result != ''){
            var solve = getJson(result);
            if(solve !== false){
                if(solve.status == "error"){
                    if(solve.for != undefined && solve.for != ''){
                        $("#PHPMailerSettings "+solve.for).focus();
                        $("#PHPMailerSettings "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                        $("#PHPMailerSettings "+solve.for).change(function(){
                            $(this).removeAttr("style");
                        });
                        }
                        if(solve.message != undefined && solve.message != '')
                            alert_error(solve.message,{timer:5000});
                }else if(solve.status == "successful")
                    alert_success(solve.message,{timer:2500});
            }else
                console.log(result);
        }
    }
</script>