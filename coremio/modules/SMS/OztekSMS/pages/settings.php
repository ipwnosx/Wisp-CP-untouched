<?php
    if(!defined("CORE_FOLDER")) die();
    $LANG       = $module->lang;
    $CONFIG     = $module->config;
?>
<form action="<?php echo Controllers::$init->getData("links")["controller"]; ?>" method="post" id="OztekSMSSettings">
    <input type="hidden" name="operation" value="module_controller">
    <input type="hidden" name="module" value="OztekSMS">
    <input type="hidden" name="controller" value="settings">


    <div class="formcon">
        <div class="yuzde30"><?php echo $LANG["username_id"]; ?></div>
        <div class="yuzde70">
            <input type="text" name="username_id" value="<?php echo $CONFIG["username_id"]; ?>">
            <span class="kinfo"><?php echo $LANG["username_id-desc"]; ?></span>
        </div>
    </div>

    <div class="formcon">
        <div class="yuzde30"><?php echo $LANG["username"]; ?></div>
        <div class="yuzde70">
            <input type="text" name="username" value="<?php echo $CONFIG["username"]; ?>">
            <span class="kinfo"><?php echo $LANG["username-desc"]; ?></span>
        </div>
    </div>

    <div class="formcon">
        <div class="yuzde30"><?php echo $LANG["password"]; ?></div>
        <div class="yuzde70">
            <input type="text" name="password" value="<?php echo $CONFIG["password"]; ?>">
            <span class="kinfo"><?php echo $LANG["password-desc"]; ?></span>
        </div>
    </div>

    <div class="formcon">
        <div class="yuzde30"><?php echo $LANG["origin-name"]; ?></div>
        <div class="yuzde70">
            <input type="text" name="origin" value="<?php echo $CONFIG["origin"]; ?>">
            <span class="kinfo"><?php echo $LANG["origin-name-desc"]; ?></span>
        </div>
    </div>

    <div class="formcon" style="display: none;">
        <div class="yuzde30"><?php echo $LANG["balance-info"]; ?></div>
        <div class="yuzde70" id="OztekSMS_get_credit"><?php echo $LANG["balance-info-desc"]; ?></div>
    </div>


    <div style="float:right;" class="guncellebtn yuzde30"><a id="OztekSMS_submit" href="javascript:void(0);" class="yesilbtn gonderbtn"><?php echo $LANG["save-button"]; ?></a></div>

</form>
<script type="text/javascript">
    var value       = $("#OztekSMS_get_credit").html();
    var loadBalanceOztekSMS = false;

    $(document).ready(function(){

        $("#OztekSMS_get_credit").html(window.value.replace("{credit}",'<?php echo ___("needs/loading-element"); ?>'));

        setInterval(function(){
            var display = $("#module-OztekSMS").css("display");
            if(display != "none"){
                if(!loadBalanceOztekSMS){

                    var request = MioAjax({
                        action:window.location.href,
                        method:"POST",
                        data:{
                            operation:"module_controller",
                            module:"OztekSMS",
                            controller:"get-credit"
                        }
                    },true,true);

                    request.done(function(result){
                       OztekSMS_get_credit(result);
                    });
                    loadBalanceOztekSMS = true;
                }
            }
        },300);

        $("#OztekSMS_submit").click(function(){
            MioAjaxElement($(this),{
                waiting_text:waiting_text,
                progress_text:progress_text,
                result:"OztekSMSSettings_handler",
            });
        });
    });

    function OztekSMS_get_credit(result) {
        if(result != ''){
            var solve = getJson(result);
            if(solve !== false){
                $("#OztekSMS_get_credit").html(window.value.replace("{credit}",solve.credit));

            }else
                console.log(result);
        }
    }

    function OztekSMSSettings_handler(result){
        if(result != ''){
            var solve = getJson(result);
            if(solve !== false){
                if(solve.status == "error"){
                    if(solve.for != undefined && solve.for != ''){
                        $("#OztekSMSSettings "+solve.for).focus();
                        $("#OztekSMSSettings "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                        $("#OztekSMSSettings "+solve.for).change(function(){
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