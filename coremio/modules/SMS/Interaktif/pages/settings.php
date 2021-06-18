<?php
    if(!defined("CORE_FOLDER")) die();
    $LANG       = $module->lang;
    $CONFIG     = $module->config;
?>
<form action="<?php echo Controllers::$init->getData("links")["controller"]; ?>" method="post" id="InteraktifSettings">
    <input type="hidden" name="operation" value="module_controller">
    <input type="hidden" name="module" value="Interaktif">
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
        <div class="yuzde30">Api Secret</div>
        <div class="yuzde70">
            <input type="text" name="secret" value="<?php echo $CONFIG["secret"]; ?>">
            <span class="kinfo"></span>
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
        <div class="yuzde70" id="Interaktif_get_credit"><?php echo $LANG["balance-info-desc"]; ?></div>
    </div>


    <div style="float:right;" class="guncellebtn yuzde30"><a id="Interaktif_submit" href="javascript:void(0);" class="yesilbtn gonderbtn"><?php echo $LANG["save-button"]; ?></a></div>

</form>
<script type="text/javascript">
    var value   = $("#Interaktif_get_credit").html();
    var loadBalance_Interaktif;

    $(document).ready(function(){

        $("#Interaktif_get_credit").html(window.value.replace("{credit}",'<?php echo ___("needs/loading-element"); ?>'));

        setInterval(function(){
            var display = $("#module-Interaktif").css("display");
            if(display != "none"){
                if(!loadBalance_Interaktif){

                    var request = MioAjax({
                        action:window.location.href,
                        method:"POST",
                        data:{
                            operation:"module_controller",
                            module:"Interaktif",
                            controller:"get-credit"
                        }
                    },true,true);

                    request.done(function (result){
                        Interaktif_get_creditt(result);
                    });

                    loadBalance_Interaktif = true;
                }
            }
        },300);

        $("#Interaktif_submit").click(function(){
            MioAjaxElement($(this),{
                waiting_text:waiting_text,
                progress_text:progress_text,
                result:"InteraktifSettings_handler",
            });
        });
    });

    function Interaktif_get_creditt(result) {
        if(result != ''){
            var solve = getJson(result);
            if(solve !== false){
                $("#Interaktif_get_credit").html(window.value.replace("{credit}",solve.credit));

            }else
                console.log(result);
        }
    }

    function InteraktifSettings_handler(result){
        if(result != ''){
            var solve = getJson(result);
            if(solve !== false){
                if(solve.status == "error"){
                    if(solve.for != undefined && solve.for != ''){
                        $("#InteraktifSettings "+solve.for).focus();
                        $("#InteraktifSettings "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                        $("#InteraktifSettings "+solve.for).change(function(){
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