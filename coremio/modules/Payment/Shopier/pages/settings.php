<?php
    if(!defined("CORE_FOLDER")) die();
    $LANG       = $module->lang;
    $CONFIG     = $module->config;
    $notify_url = Controllers::$init->CRLink("payment",['Shopier',$module->get_auth_token(),'callback'],"none");
?>

<form action="<?php echo Controllers::$init->getData("links")["controller"]; ?>" method="post" id="Shopier">
    <input type="hidden" name="operation" value="module_controller">
    <input type="hidden" name="module" value="Shopier">
    <input type="hidden" name="controller" value="settings">

    <div class="formcon">
        <div class="yuzde30">Api Key</div>
        <div class="yuzde70">
            <input type="text" name="api_key" value="<?php echo $CONFIG["settings"]["api_key"]; ?>">
        </div>
    </div>

    <div class="formcon">
        <div class="yuzde30">Api Secret</div>
        <div class="yuzde70">
            <input type="text" name="api_secret" value="<?php echo $CONFIG["settings"]["api_secret"]; ?>">
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



    <div style="float:right;" class="guncellebtn yuzde30"><a id="Shopier_submit" href="javascript:void(0);" class="yesilbtn gonderbtn"><?php echo $LANG["save-button"]; ?></a></div>

</form>


<script type="text/javascript">
    $(document).ready(function(){

        $("#Shopier_submit").click(function(){
            MioAjaxElement($(this),{
                waiting_text:waiting_text,
                progress_text:progress_text,
                result:"Shopier_handler",
            });
        });

    });

    function Shopier_handler(result){
        if(result != ''){
            var solve = getJson(result);
            if(solve !== false){
                if(solve.status == "error"){
                    if(solve.for != undefined && solve.for != ''){
                        $("#Shopier "+solve.for).focus();
                        $("#Shopier "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                        $("#Shopier "+solve.for).change(function(){
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