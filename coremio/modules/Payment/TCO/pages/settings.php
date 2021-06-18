<?php
    $LANG       = $module->lang;
    $CONFIG     = $module->config;
    $notify_url = Controllers::$init->CRLink("payment",['TCO',$module->get_auth_token(),'callback'],"none");
    $success_url = Controllers::$init->CRLink("pay-successful",false,"none");
    $failed_url  = Controllers::$init->CRLink("pay-failed",false,"none");
?>
<form action="<?php echo Controllers::$init->getData("links")["controller"]; ?>" method="post" id="TCO">
    <input type="hidden" name="operation" value="module_controller">
    <input type="hidden" name="module" value="TCO">
    <input type="hidden" name="controller" value="settings">


    <div class="formcon">
        <div class="yuzde30"><?php echo $LANG["seller-id"]; ?></div>
        <div class="yuzde70">
            <input type="text" name="sid" value="<?php echo $CONFIG["settings"]["sid"]; ?>">
            <span class="kinfo"><?php echo $LANG["seller-id-desc"]; ?></span>
        </div>
    </div>

    <div class="formcon">
        <div class="yuzde30"><?php echo $LANG["secret-word"]; ?></div>
        <div class="yuzde70">
            <input type="password" name="secret_word" value="<?php echo $CONFIG["settings"]["secret_word"] ? "*****" : ''; ?>">
            <span class="kinfo"><?php echo $LANG["secret-word-desc"]; ?></span>
        </div>
    </div>

    <div class="formcon">
        <div class="yuzde30"><?php echo $LANG["demo-mode"]; ?></div>
        <div class="yuzde70">
            <input<?php echo $CONFIG["settings"]["demo"] ? ' checked' : ''; ?> type="checkbox" name="demo" class="sitemio-checkbox" value="1" id="tco_demo">
            <label for="tco_demo" class="sitemio-checkbox-label"></label>
            <span class="kinfo"><?php echo $LANG["demo-mode-desc"]; ?></span>
        </div>
    </div>

    <div class="formcon">
        <div class="yuzde30"><?php echo $LANG["sandbox"]; ?></div>
        <div class="yuzde70">
            <input<?php echo $CONFIG["settings"]["sandbox"] ? ' checked' : ''; ?> type="checkbox" name="sandbox" class="sitemio-checkbox" value="1" id="tco_sandbox">
            <label for="tco_sandbox" class="sitemio-checkbox-label"></label>
            <span class="kinfo"><?php echo $LANG["sandbox-desc"]; ?></span>
        </div>
    </div>


    <div class="formcon">
        <div class="yuzde30"><?php echo $LANG["commission-rate"]; ?></div>
        <div class="yuzde70">
            <input type="text" name="commission_rate" value="<?php echo $CONFIG["settings"]["commission_rate"]; ?>" style="width: 80px;">
            <span class="kinfo"><?php echo $LANG["commission-rate-desc"]; ?></span>
        </div>
    </div>


    <div class="formcon">
        <div class="yuzde30" style=" color: #f44336;"><?php echo $LANG["notify-url"]; ?></div>
        <div class="yuzde70">
            <span class="selectalltext" style="font-size:13px;font-weight:600;    color: #f44336;"><?php echo $notify_url; ?></span>
            <div class="clear"></div>
            <span class="kinfo"><?php echo $LANG["notify-url-desc"]; ?></span>
        </div>
    </div>


    <div style="float:right;" class="guncellebtn yuzde30"><a id="TCO_submit" href="javascript:void(0);" class="yesilbtn gonderbtn"><?php echo $LANG["save-button"]; ?></a></div>

</form>


<script type="text/javascript">
    $(document).ready(function(){

        $("#TCO_submit").click(function(){
            MioAjaxElement($(this),{
                waiting_text:waiting_text,
                progress_text:progress_text,
                result:"TCO_handler",
            });
        });

    });

    function TCO_handler(result){
        if(result != ''){
            var solve = getJson(result);
            if(solve !== false){
                if(solve.status == "error"){
                    if(solve.for != undefined && solve.for != ''){
                        $("#TCO "+solve.for).focus();
                        $("#TCO "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                        $("#TCO "+solve.for).change(function(){
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