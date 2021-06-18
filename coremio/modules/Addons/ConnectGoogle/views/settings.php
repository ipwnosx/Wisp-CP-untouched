<script type="text/javascript">
    $(document).ready(function(){

        $("#ConnectGoogle_submit_button").click(function(){
            MioAjaxElement($(this),{
                waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                result:"ConnectGoogle_settingsForm_handler",
            });
        });

    });

    function ConnectGoogle_settingsForm_handler(result){
        if(result != ''){
            var solve = getJson(result);
            if(solve !== false){
                if(solve.status == "error"){
                    if(solve.for != undefined && solve.for != ''){
                        $("#ConnectGoogle_settingsForm "+solve.for).focus();
                        $("#ConnectGoogle_settingsForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                        $("#ConnectGoogle_settingsForm "+solve.for).change(function(){
                            $(this).removeAttr("style");
                        });
                    }
                    if(solve.message != undefined && solve.message != '')
                        alert_error(solve.message,{timer:10000});
                }else if(solve.status == "successful"){
                    if(solve.message != undefined){
                        alert_success(solve.message,{timer:3000});
                    }
                    if(solve.redirect != undefined && solve.redirect != '') window.location.href = solve.redirect;
                }
            }else
                console.log(result);
        }
    }
</script>
<form action="<?php echo $request_uri; ?>?module=ConnectGoogle" method="post" id="ConnectGoogle_settingsForm">
    <input type="hidden" name="operation" value="get_addon_content">
    <input type="hidden" name="module_operation" value="save_config">


    <div class="formcon">
        <div class="yuzde30">Client ID</div>
        <div class="yuzde70">
            <input type="text" name="client_id" value="<?php echo $config["settings"]["client_id"]; ?>">
        </div>
    </div>

    <div class="formcon">
        <div class="yuzde30">Client Secret</div>
        <div class="yuzde70">
            <input type="text" name="client_secret" value="<?php echo $config["settings"]["client_secret"]; ?>">
        </div>
    </div>


    <div class="clear"></div>

    <div class="guncellebtn yuzde30" style="float: right;">
        <a href="javascript:void 0;" class="gonderbtn yesilbtn" id="ConnectGoogle_submit_button"><?php echo ___("needs/button-save"); ?></a>
    </div>
    <div class="clear"></div>

</form>