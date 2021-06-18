<?php
    if(!defined("CORE_FOLDER")) die();
    $LANG           = $module->lang;
    $CONFIG         = $module->config;
?>
<form action="<?php echo Controllers::$init->getData("links")["controller"]; ?>" method="post" id="Skrill">
    <input type="hidden" name="operation" value="module_controller">
    <input type="hidden" name="module" value="Skrill">
    <input type="hidden" name="controller" value="settings">

    <div class="formcon">
        <div class="yuzde30"><?php echo $LANG["merchant_email"]; ?></div>
        <div class="yuzde70">
            <input type="text" name="merchant_email" value="<?php echo $CONFIG["settings"]["merchant_email"]; ?>">
            <span class="kinfo"><?php echo $LANG["merchant_email-desc"]; ?></span>
        </div>
    </div>

    <div class="formcon">
        <div class="yuzde30"><?php echo $LANG["secret_word"]; ?></div>
        <div class="yuzde70">
            <input type="text" name="secret_word" value="<?php echo $CONFIG["settings"]["secret_word"]; ?>">
            <span class="kinfo"><?php echo $LANG["secret_word-desc"]; ?></span>
        </div>
    </div>

    <div class="formcon">
        <div class="yuzde30"><?php echo $LANG["commission-rate"]; ?></div>
        <div class="yuzde70">
            <input type="text" name="commission_rate" value="<?php echo $CONFIG["settings"]["commission_rate"]; ?>" style="width: 80px;">
            <span class="kinfo"><?php echo $LANG["commission-rate-desc"]; ?></span>
        </div>
    </div>

    <div style="float:right;" class="guncellebtn yuzde30"><a id="Skrill_submit" href="javascript:void(0);" class="yesilbtn gonderbtn"><?php echo $LANG["save-button"]; ?></a></div>

</form>


<script type="text/javascript">
    $(document).ready(function(){

        $("#Skrill_submit").click(function(){
            MioAjaxElement($(this),{
                waiting_text:waiting_text,
                progress_text:progress_text,
                result:"Skrill_handler",
            });
        });

    });

    function Skrill_handler(result){
        if(result != ''){
            var solve = getJson(result);
            if(solve !== false){
                if(solve.status == "error"){
                    if(solve.for != undefined && solve.for != ''){
                        $("#Skrill "+solve.for).focus();
                        $("#Skrill "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                        $("#Skrill "+solve.for).change(function(){
                            $(this).removeAttr("style");
                        });
                    }
                    if(solve.message != undefined && solve.message != '')
                        alert_error(solve.message,{timer:5000});
                }else if(solve.status == "successful"){
                    alert_success(solve.message,{timer:2500});
                }
            }else
                console.log(result);
        }
    }
</script>