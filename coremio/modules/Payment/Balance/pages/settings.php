<?php
    if(!defined("CORE_FOLDER")) die();
    $LANG       = $module->lang;
    $CONFIG     = $module->config;
    Helper::Load("Money");
?>

<form action="<?php echo Controllers::$init->getData("links")["controller"]; ?>" method="post" id="Balance">
    <input type="hidden" name="operation" value="module_controller">
    <input type="hidden" name="module" value="Balance">
    <input type="hidden" name="controller" value="settings">

    <div class="blue-info" style="margin-bottom:20px;">
        <div class="padding15">
            <i class="fa fa-info-circle" aria-hidden="true"></i>
            <p><?php echo $LANG["description"]; ?></p>
        </div>
    </div>


    <div class="formcon">
        <div class="yuzde30"><?php echo $LANG["status"]; ?></div>
        <div class="yuzde70">
            <input<?php echo $CONFIG["settings"]["status"] ? ' checked' : ''; ?> type="checkbox" name="status" class="sitemio-checkbox" value="1" id="Balance_status">
            <label for="Balance_status" class="sitemio-checkbox-label"></label>
            <span class="kinfo"><?php echo $LANG["status-desc"]; ?></span>
        </div>
    </div>

    <div class="formcon">
        <div class="yuzde30"><?php echo $LANG["min-amount"]; ?></div>

        <div class="yuzde70">
            <input style="width:50px;" type="text" name="min-amount" value="<?php echo Money::formatter($CONFIG["settings"]["min-amount"],$CONFIG["settings"]["min-amount-cid"]); ?>">
            <select style="width:120px;" name="min-amount-cid">
                <?php
                    $currencies = Money::getCurrencies($CONFIG["settings"]["min-amount-cid"]);
                    foreach($currencies AS $currency){
                        $selected   = $CONFIG["settings"]["min-amount-cid"] == $currency["id"];
                        ?>
                        <option<?php echo $selected ? ' selected' : '' ?> value="<?php echo $currency["id"]; ?>"><?php echo $currency["name"]." (".$currency['code'].")"; ?></option>
                        <?php
                    }
                ?>
            </select>
            <div class="clear"></div>
            <span class="kinfo"><?php echo $LANG["min-amount-desc"]; ?></span>
        </div>
    </div>

    <div class="formcon">
        <div class="yuzde30"><?php echo $LANG["auto-payment"]; ?></div>
        <div class="yuzde70">
            <input<?php echo $CONFIG["settings"]["auto-payment"] ? ' checked' : ''; ?> type="checkbox" name="auto-payment" class="sitemio-checkbox" value="1" id="Balance_auto-payment">
            <label for="Balance_auto-payment" class="sitemio-checkbox-label"></label>
            <span class="kinfo"><?php echo $LANG["auto-payment-desc"]; ?></span>
        </div>
    </div>


    <div style="float:right;" class="guncellebtn yuzde30"><a id="Balance_submit" href="javascript:void(0);" class="yesilbtn gonderbtn"><?php echo $LANG["save-button"]; ?></a></div>

</form>


<script type="text/javascript">
    $(document).ready(function(){

        $("#Balance_submit").click(function(){
            MioAjaxElement($(this),{
                waiting_text:waiting_text,
                progress_text:progress_text,
                result:"Balance_handler",
            });
        });

    });

    function Balance_handler(result){
        if(result != ''){
            var solve = getJson(result);
            if(solve !== false){
                if(solve.status == "error"){
                    if(solve.for != undefined && solve.for != ''){
                        $("#Balance "+solve.for).focus();
                        $("#Balance "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                        $("#Balance "+solve.for).change(function(){
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