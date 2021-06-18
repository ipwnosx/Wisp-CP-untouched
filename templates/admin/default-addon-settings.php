<form action="<?php echo $request_uri; ?>?module=<?php echo $module->_name; ?>" method="post" id="<?php echo $module->_name; ?>_settingsForm">
    <input type="hidden" name="operation" value="get_addon_content">
    <input type="hidden" name="module_operation" value="save_config">

    <?php
        if(isset($fields) && $fields) $module->fields_output($fields);
    ?>

    <div class="formcon">
        <div class="yuzde30"><?php echo __("admin/tools/access-control"); ?></div>
        <div class="yuzde70">
            <span class="kinfo"><?php echo __("admin/tools/access-control-desc"); ?></span>
            <div class="clear"></div>
            <?php
                if(isset($privileges) && $privileges){
                    foreach((array) $privileges AS $privilege){
                        ?>
                        <input<?php echo in_array($privilege['id'],$access_ps) ? ' checked' : ''; ?> type="checkbox" name="access_ps[]" value="<?php echo $privilege["id"]; ?>" class="checkbox-custom" id="access-ps-<?php echo $privilege["id"]; ?>">
                        <label class="checkbox-custom-label" style="width:200px; margin-right: 5px;" for="access-ps-<?php echo $privilege["id"]; ?>"><?php echo $privilege["name"]; ?></label>
                        <?php
                    }
                }
            ?>
        </div>
    </div>

    <div class="clear"></div>

    <div class="guncellebtn yuzde30" style="float: right;">
        <a href="javascript:void 0;" class="gonderbtn yesilbtn" id="<?php echo $module->_name; ?>_submit_button"><?php echo ___("needs/button-save"); ?></a>
    </div>
    <div class="clear"></div>

</form>
<script type="text/javascript">
    $(document).ready(function(){

        $("#<?php echo $module->_name; ?>_submit_button").click(function(){
            MioAjaxElement($(this),{
                waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                result:"<?php echo $module->_name; ?>_settingsForm_handler",
            });
        });

    });

    function <?php echo $module->_name; ?>_settingsForm_handler(result){
        if(result !== ''){
            var solve = getJson(result);
            if(solve !== false){
                if(solve.status == "error"){
                    if(solve.message != undefined && solve.message != '')
                        alert_error(solve.message,{timer:10000});
                }else if(solve.status == "successful"){
                    if(solve.message != undefined) alert_success(solve.message,{timer:3000});
                    if(solve.redirect != undefined && solve.redirect != '') window.location.href = solve.redirect;
                }
            }else
                console.log(result);
        }
    }
</script>