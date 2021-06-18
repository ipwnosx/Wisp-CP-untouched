<?php
    if(!defined("CORE_FOLDER")) die();
    $LANG           = $module->lang;
    $CONFIG         = $module->config;
    $callback_url   = Controllers::$init->CRLink("payment",['CoinPayments',$module->get_auth_token(),'callback'],"none");
?>
<form action="<?php echo Controllers::$init->getData("links")["controller"]; ?>" method="post" id="CoinPayments">
    <input type="hidden" name="operation" value="module_controller">
    <input type="hidden" name="module" value="CoinPayments">
    <input type="hidden" name="controller" value="settings">

    <div class="formcon">
        <div class="yuzde30"><?php echo $LANG["merchant_id"]; ?></div>
        <div class="yuzde70">
            <input type="text" name="merchant_id" value="<?php echo $CONFIG["settings"]["merchant_id"]; ?>">
            <span class="kinfo"><?php echo $LANG["merchant_id-desc"]; ?></span>
        </div>
    </div>

    <div class="formcon">
        <div class="yuzde30"><?php echo $LANG["ipn_secret"]; ?></div>
        <div class="yuzde70">
            <input type="text" name="ipn_secret" value="<?php echo $CONFIG["settings"]["ipn_secret"]; ?>">
            <span class="kinfo"><?php echo $LANG["ipn_secret-desc"]; ?></span>
        </div>
    </div>

    <div class="formcon">
        <div class="yuzde30"><?php echo $LANG["email"]; ?></div>
        <div class="yuzde70">
            <input type="text" name="email" value="<?php echo $CONFIG["settings"]["email"]; ?>">
            <span class="kinfo"><?php echo $LANG["email-desc"]; ?></span>
        </div>
    </div>

    <div class="formcon">
        <div class="yuzde30"><?php echo $LANG["want_shipping"]; ?></div>
        <div class="yuzde70">
            <input type="checkbox" id="CoinPayments_want_shipping" class="sitemio-checkbox" name="want_shipping" value="1"<?php echo $CONFIG["settings"]["want_shipping"] ? ' checked' : ''; ?>>
            <label for="CoinPayments_want_shipping" class="sitemio-checkbox-label"></label>
            <span class="kinfo"><?php echo $LANG["want_shipping-desc"]; ?></span>
        </div>
    </div>


    <div class="formcon">
        <div class="yuzde30"><?php echo $LANG["commission-rate"]; ?></div>
        <div class="yuzde70">
            <input type="text" name="commission_rate" value="<?php echo $CONFIG["settings"]["commission_rate"]; ?>" style="width: 80px;">
            <span class="kinfo"><?php echo $LANG["commission-rate-desc"]; ?></span>
        </div>
    </div>






    <div style="float:right;" class="guncellebtn yuzde30"><a id="CoinPayments_submit" href="javascript:void(0);" class="yesilbtn gonderbtn"><?php echo $LANG["save-button"]; ?></a></div>

</form>


<script type="text/javascript">
    $(document).ready(function(){

        $("#CoinPayments_submit").click(function(){
            MioAjaxElement($(this),{
                waiting_text:waiting_text,
                progress_text:progress_text,
                result:"CoinPayments_handler",
            });
        });

    });

    function CoinPayments_handler(result){
        if(result != ''){
            var solve = getJson(result);
            if(solve !== false){
                if(solve.status == "error"){
                    if(solve.for != undefined && solve.for != ''){
                        $("#CoinPayments "+solve.for).focus();
                        $("#CoinPayments "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                        $("#CoinPayments "+solve.for).change(function(){
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