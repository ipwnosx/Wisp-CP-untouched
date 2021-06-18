<?php
    if(!defined("CORE_FOLDER")) die();
    $LANG       = $module->lang;
    $CONFIG     = $module->config;
?>
<form action="<?php echo Controllers::$init->getData("links")["controller"]; ?>" method="post" id="ClickatellSettings">
    <input type="hidden" name="operation" value="module_controller">
    <input type="hidden" name="module" value="Clickatell">
    <input type="hidden" name="controller" value="settings">

    <div class="formcon">
        <div class="yuzde30">Api Key</div>
        <div class="yuzde70">
            <input type="text" name="api-key" value="<?php echo $CONFIG["api-key"]; ?>">
        </div>
    </div>

    <div class="formcon">
        <div class="yuzde30">From Number</div>
        <div class="yuzde70">
            <input type="text" name="from-number" value="<?php echo isset($CONFIG["from-number"]) ? $CONFIG["from-number"] : ''; ?>">
        </div>
    </div>


    <div class="formcon">
        <div class="yuzde30"><?php echo $LANG["balance-info"]; ?></div>
        <div class="yuzde70" id="Clickatell_get_credit"><?php echo $LANG["balance-info-desc"]; ?></div>
    </div>


    <div style="float:right;" class="guncellebtn yuzde30"><a id="Clickatell_submit" href="javascript:void(0);" class="yesilbtn gonderbtn"><?php echo $LANG["save-button"]; ?></a></div>

</form>
<script type="text/javascript">

    var value   = $("#Clickatell_get_credit").html();
    var loadBalanceClickatell;

    $(document).ready(function(){

        setInterval(function(){
            var display = $("#module-Clickatell").css("display");
            if(display != "none"){
                if(!loadBalanceClickatell){

                    var request = MioAjax({
                        action:window.location.href,
                        method:"POST",
                        data:{
                            operation:"module_controller",
                            module:"Clickatell",
                            controller:"get-credit"
                        }
                    },true,true);

                    request.done(function(result){
                        Clickatell_get_credit(result);
                    });

                    loadBalanceClickatell = true;
                }
            }
        },300);

        $("#Clickatell_get_credit").html(window.value.replace("{credit}",'<?php echo ___("needs/loading-element"); ?>'));

        $("#Clickatell_submit").click(function(){
            MioAjaxElement($(this),{
                waiting_text:waiting_text,
                progress_text:progress_text,
                result:"ClickatellSettings_handler",
            });
        });
    });

    function Clickatell_get_credit(result) {
        if(result != ''){
            var solve = getJson(result);
            if(solve !== false){
                $("#Clickatell_get_credit").html(window.value.replace("{credit}",solve.credit));

            }else
                console.log(result);
        }
    }

    function ClickatellSettings_handler(result){
        if(result != ''){
            var solve = getJson(result);
            if(solve !== false){
                if(solve.status == "error"){
                    if(solve.for != undefined && solve.for != ''){
                        $("#ClickatellSettings "+solve.for).focus();
                        $("#ClickatellSettings "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                        $("#ClickatellSettings "+solve.for).change(function(){
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