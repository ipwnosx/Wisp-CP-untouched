<?php
    if(!defined("CORE_FOLDER")) die();
    $LANG   = $module->lang;
    $CONFIG = $module->config;
?>

<div class="green-info" style="margin-bottom:20px;">
    <div class="padding15">
        <i class="fa fa-info-circle" aria-hidden="true"></i>
        <p><?php echo $LANG["mailjetdesc"]; ?></p>
    </div>
</div>

<form action="<?php echo Controllers::$init->getData("links")["controller"]; ?>" method="post" id="MailjetSettings">
    <input type="hidden" name="operation" value="module_controller">
    <input type="hidden" name="module" value="Mailjet">
    <input type="hidden" name="controller" value="settings">

    <div class="formcon">
        <div class="yuzde30">API KEY</div>
        <div class="yuzde70">
            <input type="password" name="api-key-public" value="<?php echo $CONFIG["api-key-public"] ? "*****" : ""; ?>">
            <span class="kinfo"><?php echo $LANG["api-key-public-desc"]; ?></span>
        </div>
    </div>

    <div class="formcon">
        <div class="yuzde30">SECRET KEY</div>
        <div class="yuzde70">
            <input type="password" name="api-key-private" value="<?php echo $CONFIG["api-key-private"] ? "*****" : ""; ?>">
            <span class="kinfo"><?php echo $LANG["api-key-private-desc"]; ?></span>
        </div>
    </div>

    <div class="formcon">
        <div class="yuzde30"><?php echo $LANG["settings-from-email"]; ?></div>
        <div class="yuzde70">
            <input type="text" name="femail" value="<?php echo $CONFIG["femail"]; ?>">
            <span class="kinfo"><?php echo $LANG["settings-from-email-desc"]; ?></span>
        </div>
    </div>

    <div class="formcon">
        <div class="yuzde30"><?php echo $LANG["settings-from-name"]; ?></div>
        <div class="yuzde70">
            <input type="text" name="fname" value="<?php echo $CONFIG["fname"]; ?>">
            <span class="kinfo"><?php echo $LANG["settings-from-name-desc"]; ?></span>
        </div>
    </div>


    <div style="float:right;" class="guncellebtn yuzde30"><a id="MailjetSettings_submit" href="javascript:void(0);" class="yesilbtn gonderbtn"><?php echo $LANG["save-button"]; ?></a></div>

</form>
<script type="text/javascript">
    $(document).ready(function(){
        $("#MailjetSettings_submit").click(function(){
            MioAjaxElement($(this),{
                waiting_text:waiting_text,
                progress_text:progress_text,
                result:"MailjetSettings_handler",
            });
        });
    });

    function MailjetSettings_handler(result){
        if(result != ''){
            var solve = getJson(result);
            if(solve !== false){
                if(solve.status == "error"){
                    if(solve.for != undefined && solve.for != ''){
                        $("#MailjetSettings "+solve.for).focus();
                        $("#MailjetSettings "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                        $("#MailjetSettings "+solve.for).change(function(){
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