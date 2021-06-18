<div class="hizmetblok" id="block_module_details_con">
    <div class="block_module_details-title formcon">
        <h4><?php echo $module->lang[$module->page]; ?></h4>
    </div>

    <div class="clear"></div>
    <br>

    <form action="<?php echo $module->area_link; ?>" method="post" id="form-<?php echo $module->page; ?>">
        <input type="hidden" name="inc" value="panel_operation_method">
        <input type="hidden" name="method" value="<?php echo $module->page; ?>">

        <input name="password" class="yuzde50inpt" type="text" placeholder="<?php echo __("website/account_products/hosting-change-password-input"); ?>" rel="aselect" id="change_password_<?php echo $module->_name; ?>">


        <div class="yuzde50">
            <a href="javascript:void(0);" onclick="$('#change_password_<?php echo $module->_name; ?>').val(randString({characters:'A-Z,a-z,0-9,#'})); void 0;" class="incelebtn"><i class="fa fa-refresh"></i> <?php echo __("website/account_products/new-random-password"); ?></a>
        </div>

        <div class="clear"></div>
        <br>

        <a href="javascript:void(0);" id="form-<?php echo $module->page; ?>_submit" class="yesilbtn gonderbtn" onclick=' MioAjaxElement($(this),{"result":"t_form_handle", "waiting_text":"<?php echo addslashes(__("website/others/button5-pending")); ?>"});'>
            <?php echo $module->lang["apply"]; ?>
        </a>
    </form>