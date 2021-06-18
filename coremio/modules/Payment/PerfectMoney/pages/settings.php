<?php
    if(!defined("CORE_FOLDER")) die();
    $LANG           = $module->lang;
    $CONFIG         = $module->config;
    $callback_url   = Controllers::$init->CRLink("payment",['PerfectMoney',$module->get_auth_token(),'callback'],"none");
?>
<form action="<?php echo Controllers::$init->getData("links")["controller"]; ?>" method="post" id="PerfectMoney">
    <input type="hidden" name="operation" value="module_controller">
    <input type="hidden" name="module" value="PerfectMoney">
    <input type="hidden" name="controller" value="settings">

    <div class="formcon">
        <div class="yuzde30"><?php echo $LANG["id"]; ?></div>
        <div class="yuzde70">
            <input type="text" name="id" value="<?php echo $CONFIG["settings"]["id"]; ?>">
            <span class="kinfo"><?php echo $LANG["id-desc"]; ?></span>
        </div>
    </div>

    <div class="formcon">
        <div class="yuzde30"><?php echo $LANG["password"]; ?></div>
        <div class="yuzde70">
            <input type="text" name="password" value="<?php echo $CONFIG["settings"]["password"]; ?>">
            <span class="kinfo"><?php echo $LANG["password-desc"]; ?></span>
        </div>
    </div>

    <div class="formcon">
        <div class="yuzde30"><?php echo $LANG["currency"]; ?></div>
        <div class="yuzde70">
            <select name="currency">
                <?php
                    foreach(Money::getCurrencies($CONFIG["settings"]["currency"]) AS $currency){
                        ?>
                        <option<?php echo $currency["id"] == $CONFIG["settings"]["currency"] ? ' selected' : ''; ?> value="<?php echo $currency["id"]; ?>"><?php echo $currency["name"]." (".$currency["code"].")"; ?></option>
                        <?php
                    }
                ?>
            </select>
            <span class="kinfo"><?php echo $LANG["currency-desc"]; ?></span>
        </div>
    </div>


    <div class="formcon">
        <div class="yuzde30"><?php echo $LANG["commission-rate"]; ?></div>
        <div class="yuzde70">
            <input type="text" name="commission_rate" value="<?php echo $CONFIG["settings"]["commission_rate"]; ?>" style="width: 80px;">
            <span class="kinfo"><?php echo $LANG["commission-rate-desc"]; ?></span>
        </div>
    </div>

    <div style="float:right;" class="guncellebtn yuzde30"><a id="PerfectMoney_submit" href="javascript:void(0);" class="yesilbtn gonderbtn"><?php echo $LANG["save-button"]; ?></a></div>

</form>


<script type="text/javascript">
    $(document).ready(function(){

        $("#PerfectMoney_submit").click(function(){
            MioAjaxElement($(this),{
                waiting_text:waiting_text,
                progress_text:progress_text,
                result:"PerfectMoney_handler",
            });
        });

    });

    function PerfectMoney_handler(result){
        if(result != ''){
            var solve = getJson(result);
            if(solve !== false){
                if(solve.status == "error"){
                    if(solve.for != undefined && solve.for != ''){
                        $("#PerfectMoney "+solve.for).focus();
                        $("#PerfectMoney "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                        $("#PerfectMoney "+solve.for).change(function(){
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