<?php
    if(!defined("CORE_FOLDER")) die();
    $LANG       = $module->lang;
    $CONFIG     = $module->config;
?>
<form action="<?php echo Controllers::$init->getData("links")["controller"]; ?>" method="post" id="NetgsmSettings">
    <input type="hidden" name="operation" value="module_controller">
    <input type="hidden" name="module" value="Netgsm">
    <input type="hidden" name="controller" value="settings">


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

    <div class="formcon">
        <div class="yuzde30"><?php echo $LANG["balance-info"]; ?></div>
        <div class="yuzde70" id="Netgsm_get_credit"><?php echo $LANG["balance-info-desc"]; ?></div>
    </div>


    <div style="float:right;" class="guncellebtn yuzde30"><a id="Netgsm_submit" href="javascript:void(0);" class="yesilbtn gonderbtn"><?php echo $LANG["save-button"]; ?></a></div>

</form>
<script type="text/javascript">
    var value       = $("#Netgsm_get_credit").html();
    var loadBalanceNetgsm = false;

    $(document).ready(function(){

        $("#Netgsm_get_credit").html(window.value.replace("{credit}",'<?php echo ___("needs/loading-element"); ?>'));

        setInterval(function(){
            var display = $("#module-Netgsm").css("display");
            if(display != "none"){
                if(!loadBalanceNetgsm){

                    var request = MioAjax({
                        action:window.location.href,
                        method:"POST",
                        data:{
                            operation:"module_controller",
                            module:"Netgsm",
                            controller:"get-credit"
                        }
                    },true,true);

                    request.done(function(result){
                        netgsm_get_credit(result);
                    });
                    loadBalanceNetgsm = true;
                }
            }
        },300);

        $("#Netgsm_submit").click(function(){
            MioAjaxElement($(this),{
                waiting_text:waiting_text,
                progress_text:progress_text,
                result:"NetgsmSettings_handler",
            });
        });
    });

    function netgsm_get_credit(result) {
        if(result != ''){
            var solve = getJson(result);
            if(solve !== false){
                $("#Netgsm_get_credit").html(window.value.replace("{credit}",solve.credit));

            }else
                console.log(result);
        }
    }

    function NetgsmSettings_handler(result){
        if(result != ''){
            var solve = getJson(result);
            if(solve !== false){
                if(solve.status == "error"){
                    if(solve.for != undefined && solve.for != ''){
                        $("#NetgsmSettings "+solve.for).focus();
                        $("#NetgsmSettings "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                        $("#NetgsmSettings "+solve.for).change(function(){
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