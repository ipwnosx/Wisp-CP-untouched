<?php
    if(!defined("CORE_FOLDER")) die();
    $LANG   = $module->lang;
    $CONFIG = $module->config;
    Helper::Load("Money");
?>
<form action="<?php echo Controllers::$init->getData("links")["controller"]; ?>" method="post" id="BuycPanelSettings">
    <input type="hidden" name="operation" value="module_controller">
    <input type="hidden" name="module" value="BuycPanel">
    <input type="hidden" name="controller" value="settings">

    <div class="formcon">
        <div class="yuzde30"><?php echo $LANG["fields"]["login"]; ?></div>
        <div class="yuzde70">
            <input type="text" name="login" value="<?php echo $CONFIG["settings"]["login"]; ?>">
        </div>
    </div>

    <div class="formcon">
        <div class="yuzde30"><?php echo $LANG["fields"]["key"]; ?></div>
        <div class="yuzde70">
            <input type="password" name="key" value="<?php echo $CONFIG["settings"]["key"] ? "*****" : ""; ?>">
        </div>
    </div>

    <div class="formcon">
        <div class="yuzde30"><?php echo $LANG["fields"]["test-mode"]; ?></div>
        <div class="yuzde70">
            <input<?php echo $CONFIG["settings"]["test-mode"] ? ' checked' : ''; ?> type="checkbox" name="test-mode" value="1" id="BuycPanel_test-mode" class="checkbox-custom">
            <label class="checkbox-custom-label" for="BuycPanel_test-mode">
                <span class="kinfo"><?php echo $LANG["desc"]["test-mode"]; ?></span>
            </label>
        </div>
    </div>

    <div class="clear"></div>
    <br>

    <div style="float:left;" class="guncellebtn yuzde30"><a id="BuycPanel_testConnect" href="javascript:void(0);" class="lbtn"><i class="fa fa-plug" aria-hidden="true"></i> <?php echo $LANG["test-button"]; ?></a></div>


    <div style="float:right;" class="guncellebtn yuzde30"><a id="BuycPanel_submit" href="javascript:void(0);" class="yesilbtn gonderbtn"><?php echo $LANG["save-button"]; ?></a></div>

</form>
<script type="text/javascript">
    $(document).ready(function(){
        $("#BuycPanel_testConnect").click(function(){
            $("#BuycPanelSettings input[name=controller]").val("test_connection");
            MioAjaxElement($(this),{
                waiting_text:waiting_text,
                progress_text:progress_text,
                result:"BuycPanel_handler",
            });
        });

        $("#BuycPanel_submit").click(function(){
            $("#BuycPanelSettings input[name=controller]").val("settings");
            MioAjaxElement($(this),{
                waiting_text:waiting_text,
                progress_text:progress_text,
                result:"BuycPanel_handler",
            });
        });
    });

    function BuycPanel_handler(result){
        if(result != ''){
            var solve = getJson(result);
            if(solve !== false){
                if(solve.status == "error"){
                    if(solve.for != undefined && solve.for != ''){
                        $("#BuycPanelSettings "+solve.for).focus();
                        $("#BuycPanelSettings "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                        $("#BuycPanelSettings "+solve.for).change(function(){
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