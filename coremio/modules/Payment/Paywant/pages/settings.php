<?php
    if(!defined("CORE_FOLDER")) die();
    $LANG       = $module->lang;
    $CONFIG     = $module->config;
    $notify_url = Controllers::$init->CRLink("payment",['Paywant',$module->get_auth_token(),'callback'],"none");
?>

<form action="<?php echo Controllers::$init->getData("links")["controller"]; ?>" method="post" id="Paywant">
    <input type="hidden" name="operation" value="module_controller">
    <input type="hidden" name="module" value="Paywant">
    <input type="hidden" name="controller" value="settings">

    <div class="blue-info" style="margin-bottom:20px;">
        <div class="padding15">
            <i class="fa fa-info-circle" aria-hidden="true"></i>
            <p><?php echo $LANG["description"]; ?></p>
        </div>
    </div>

    <div class="formcon">
        <div class="yuzde30">Api Key</div>
        <div class="yuzde70">
            <input type="text" name="api_key" value="<?php echo $CONFIG["settings"]["api_key"]; ?>">
            <span class="kinfo"><?php echo $LANG["api-key-desc"]; ?></span>
        </div>
    </div>

    <div class="formcon">
        <div class="yuzde30">Api Secret Key</div>
        <div class="yuzde70">
            <input type="text" name="api_secret_key" value="<?php echo $CONFIG["settings"]["api_secret_key"]; ?>">
            <span class="kinfo"><?php echo $LANG["api-secret-key-desc"]; ?></span>
        </div>
    </div>


    <div class="formcon">
        <div class="yuzde30"><?php echo $LANG["commission-type-desc"]; ?></div>
        <div class="yuzde70">

			<input<?php echo $CONFIG["settings"]["commission_type"] == 1 ? ' checked' : ''; ?> type="radio" name="commission_type" class="radio-custom" value="1" id="commission_type_1" onchange="if($(this).prop('checked'))">

            <label for="commission_type_1" class="radio-custom-label" style="margin-right: 10px;"><?php echo $LANG["commission-type-1"]; ?></label>



            <input<?php echo $CONFIG["settings"]["commission_type"] == 2 ? ' checked' : ''; ?> type="radio" name="commission_type" class="radio-custom" value="2" id="commission_type_2" onchange="if($(this).prop('checked'))">

            <label for="commission_type_2" class="radio-custom-label"><?php echo $LANG["commission-type-2"]; ?></label>

        </div>
    </div>
	
	<div class="formcon">
        <div class="yuzde30">Komisyon Çarpanı</div>
        <div class="yuzde70">
            <input type="text" name="commission_multiplier" value="<?php echo $CONFIG["settings"]["commission_multiplier"]; ?>" style="width: 80px;">
            <span class="kinfo"><?php echo $LANG["commission-multipler-desc"]; ?></span>
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



    <div style="float:right;" class="guncellebtn yuzde30"><a id="Paywant_submit" href="javascript:void(0);" class="yesilbtn gonderbtn"><?php echo $LANG["save-button"]; ?></a></div>

</form>


<script type="text/javascript">
    $(document).ready(function(){

        $("#Paywant_submit").click(function(){
            MioAjaxElement($(this),{
                waiting_text:waiting_text,
                progress_text:progress_text,
                result:"Paywant_handler",
            });
        });

    });

    function Paywant_handler(result){
        if(result != ''){
            var solve = getJson(result);
            if(solve !== false){
                if(solve.status == "error"){
                    if(solve.for != undefined && solve.for != ''){
                        $("#Paywant "+solve.for).focus();
                        $("#Paywant "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                        $("#Paywant "+solve.for).change(function(){
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