<?php
    if(!defined("CORE_FOLDER")) die();
    $LANG       = $module->lang;
    $CONFIG     = $module->config;
?>
<form action="<?php echo Controllers::$init->getData("links")["controller"]; ?>" method="post" id="BulkSMSSettings">
    <input type="hidden" name="operation" value="module_controller">
    <input type="hidden" name="module" value="BulkSMS">
    <input type="hidden" name="controller" value="settings">

    <div class="formcon">
        <div class="yuzde30"><?php echo $LANG["username"]; ?></div>
        <div class="yuzde70">
            <input type="text" name="username" value="<?php echo $CONFIG["username"]; ?>">
        </div>
    </div>

    <div class="formcon">
        <div class="yuzde30"><?php echo $LANG["password"]; ?></div>
        <div class="yuzde70">
            <input type="password" name="password" value="<?php echo $CONFIG["password"]; ?>">
        </div>
    </div>


    <div class="formcon">
        <div class="yuzde30"><?php echo $LANG["balance-info"]; ?></div>
        <div class="yuzde70" id="BulkSMS_get_credit"><?php echo $LANG["balance-info-desc"]; ?></div>
    </div>


    <div style="float:right;" class="guncellebtn yuzde30"><a id="BulkSMS_submit" href="javascript:void(0);" class="yesilbtn gonderbtn"><?php echo $LANG["save-button"]; ?></a></div>

</form>
<script type="text/javascript">

    var value   = $("#BulkSMS_get_credit").html();
    var loadBalanceBulkSMS;

    $(document).ready(function(){

        setInterval(function(){
            var display = $("#module-BulkSMS").css("display");
            if(display != "none"){
                if(!loadBalanceBulkSMS){

                    var request = MioAjax({
                        action:window.location.href,
                        method:"POST",
                        data:{
                            operation:"module_controller",
                            module:"BulkSMS",
                            controller:"get-credit"
                        }
                    },true,true);

                    request.done(function(result){
                        BulkSms_get_credit(result);
                    });

                    loadBalanceBulkSMS = true;
                }
            }
        },300);

        $("#BulkSMS_get_credit").html(window.value.replace("{credit}",'<?php echo ___("needs/loading-element"); ?>'));

        $("#BulkSMS_submit").click(function(){
            MioAjaxElement($(this),{
                waiting_text:waiting_text,
                progress_text:progress_text,
                result:"BulkSMSSettings_handler",
            });
        });
    });

    function BulkSms_get_credit(result) {
        if(result != ''){
            var solve = getJson(result);
            if(solve !== false){
                $("#BulkSMS_get_credit").html(window.value.replace("{credit}",solve.credit));
            }else
                console.log(result);
        }
    }

    function BulkSMSSettings_handler(result){
        if(result != ''){
            var solve = getJson(result);
            if(solve !== false){
                if(solve.status == "error"){
                    if(solve.for != undefined && solve.for != ''){
                        $("#BulkSMSSettings "+solve.for).focus();
                        $("#BulkSMSSettings "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                        $("#BulkSMSSettings "+solve.for).change(function(){
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