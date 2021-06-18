<?php
    if(!defined("CORE_FOLDER")) die();
    $LANG       = $module->lang;
    $CONFIG     = $module->config;
    $webhook    = Controllers::$init->CRLink("payment",['Stripe',$module->get_auth_token(),'callback']);
?>
<form action="<?php echo Controllers::$init->getData("links")["controller"]; ?>" method="post" id="Stripe">
    <input type="hidden" name="operation" value="module_controller">
    <input type="hidden" name="module" value="Stripe">
    <input type="hidden" name="controller" value="settings">


    <div class="formcon">
        <div class="yuzde30"><?php echo $LANG["mode"]; ?></div>
        <div class="yuzde70">
            <script>
                function change_test_mode(status) {
                    if(status){
                        $(".live_content").css("display","none");
                        $(".test_content").fadeIn(250);
                    }else{
                        $(".test_content").css("display","none");
                        $(".live_content").fadeIn(250);
                    }
                }
            </script>
            <input<?php echo !$CONFIG["settings"]["test_mode"] ? ' checked' : ''; ?> type="radio" name="test_mode" class="radio-custom" value="0" id="Stripe_test_mode_0" onchange="if($(this).prop('checked')) change_test_mode(false);">
            <label for="Stripe_test_mode_0" class="radio-custom-label" style="margin-right: 10px;"><?php echo $LANG["live"]; ?></label>

            <input<?php echo $CONFIG["settings"]["test_mode"] ? ' checked' : ''; ?> type="radio" name="test_mode" class="radio-custom" value="1" id="Stripe_test_mode_1" onchange="if($(this).prop('checked')) change_test_mode(true);">
            <label for="Stripe_test_mode_1" class="radio-custom-label"><?php echo $LANG["test"]; ?></label>
        </div>
    </div>


    <div class="formcon live_content" style="<?php echo $CONFIG["settings"]["test_mode"] ? 'display:none;' : ''; ?>">
        <div class="yuzde30">Live Publishable Key</div>
        <div class="yuzde70">
            <input type="text" name="live_publishable_key" value="<?php echo $CONFIG["settings"]["live_publishable_key"]; ?>">
            <span class="kinfo"><?php echo $LANG["api-keys-desc"]; ?></span>
        </div>
    </div>

    <div class="formcon test_content" style="<?php echo $CONFIG["settings"]["test_mode"] ? '' : 'display:none;'; ?>">
        <div class="yuzde30">Test Publishable Key</div>
        <div class="yuzde70">
            <input type="text" name="test_publishable_key" value="<?php echo $CONFIG["settings"]["test_publishable_key"]; ?>">
            <span class="kinfo"><?php echo $LANG["api-keys-desc"]; ?></span>
        </div>
    </div>

    <div class="formcon live_content" style="<?php echo $CONFIG["settings"]["test_mode"] ? 'display:none;' : ''; ?>">
        <div class="yuzde30">Live Secret Key</div>
        <div class="yuzde70">
            <input type="text" name="live_secret_key" value="<?php echo $CONFIG["settings"]["live_secret_key"]; ?>">
            <span class="kinfo"><?php echo $LANG["api-keys-desc"]; ?></span>
        </div>
    </div>

    <div class="formcon test_content" style="<?php echo $CONFIG["settings"]["test_mode"] ? '' : 'display:none;'; ?>">
        <div class="yuzde30">Test Secret Key</div>
        <div class="yuzde70">
            <input type="text" name="test_secret_key" value="<?php echo $CONFIG["settings"]["test_secret_key"]; ?>">
            <span class="kinfo"><?php echo $LANG["api-keys-desc"]; ?></span>
        </div>
    </div>

    <div class="formcon">
        <div class="yuzde30">Webhook</div>
        <div class="yuzde70">

            <span style="width: 150px; float: left;display:inline-block;">URL to be called</span>
            <strong class="selectalltext" style="font-size: 10px;"><?php echo $webhook; ?></strong>
            <div class="clear"></div>

            <span style="width: 150px; float: left;display:inline-block;">Webhook version</span>
            <strong>Latest</strong>
            <div class="clear"></div>

            <span style="width: 150px; float: left;display:inline-block;">Filter event</span>
            <strong>Send all event types</strong>
            <div class="clear"></div>

            <span style="width: 150px; float: left;display:inline-block;margin-top:5px;">Endpoint Secret</span>
            <input type="text" name="endpoint_secret" value="<?php echo isset($CONFIG["settings"]["endpoint_secret"]) ? $CONFIG["settings"]["endpoint_secret"] : ''; ?>" style="width: 300px;">
            <div class="clear"></div>

        </div>
    </div>


    <div class="formcon">
        <div class="yuzde30"><?php echo $LANG["commission-rate"]; ?></div>
        <div class="yuzde70">
            <input type="text" name="commission_rate" value="<?php echo $CONFIG["settings"]["commission_rate"]; ?>" style="width: 80px;">
            <span class="kinfo"><?php echo $LANG["commission-rate-desc"]; ?></span>
        </div>
    </div>


    <div style="float:right;" class="guncellebtn yuzde30"><a id="Stripe_submit" href="javascript:void(0);" class="yesilbtn gonderbtn"><?php echo $LANG["save-button"]; ?></a></div>

</form>


<script type="text/javascript">
    $(document).ready(function(){

        $("#Stripe_submit").click(function(){
            MioAjaxElement($(this),{
                waiting_text:waiting_text,
                progress_text:progress_text,
                result:"Stripe_handler",
            });
        });

    });

    function Stripe_handler(result){
        if(result != ''){
            var solve = getJson(result);
            if(solve !== false){
                if(solve.status == "error"){
                    if(solve.for != undefined && solve.for != ''){
                        $("#Stripe "+solve.for).focus();
                        $("#Stripe "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                        $("#Stripe "+solve.for).change(function(){
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