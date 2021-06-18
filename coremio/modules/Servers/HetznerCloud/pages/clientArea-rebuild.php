<div class="padding30">
    <h4 class="cleintArea-module-page-title"><strong><?php echo $module->lang["tx81"]; ?></strong></h4>
    <div class="line"></div>

    <div class="red-info">
        <div class="padding20">
            <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
            <p><?php echo $module->lang["tx85"]; ?></p>
        </div>
    </div>

    <div class="clear"></div>

    <form action="<?php echo $module->area_link; ?>" method="post" id="form-<?php echo $module->page; ?>">
        <input type="hidden" name="inc" value="panel_operation_method">
        <input type="hidden" name="method" value="<?php echo $module->page; ?>">

        <div class="formcon">
            <div class="yuzde30">Select Image</div>
            <div class="yuzde70">
                <script type="text/javascript">
                    $(document).ready(function(){
                        $("#rebuild_image").select2();
                    });
                </script>
                <select name="image" id="rebuild_image">
                    <?php
                        $_images = [];
                        if($images) foreach($images AS $image) $_images[$image["name"]] = $image["description"];
                        if($configuration["client_available_images"])
                        {
                            foreach($configuration["client_available_images"] AS $k)
                            {
                                $v = $_images[$k];
                                ?><option value="<?php echo $k; ?>"><?php echo $v; ?></option><?php
                            }
                        }
                        else
                        {
                            foreach($_images AS $k=>$v)
                            {
                                ?><option value="<?php echo $k; ?>"><?php echo $v; ?></option><?php
                            }
                        }
                    ?>
                </select>
            </div>
        </div>


        <div class="clear"></div>
        <div class="line"></div>


        <a href="javascript:reload_module_content('home'); void 0;" class="clientArea-module-page-btn"><i class="fa fa-chevron-circle-left"></i> <?php echo $module->lang["turn-back"]; ?></a>

        <div style="float:right;margin-bottom:20px;" class="guncellebtn yuzde30">
            <a class="yesilbtn gonderbtn" href="javascript:void(0);" id="form-<?php echo $module->page; ?>_submit"  onclick=' MioAjaxElement($(this),{"result":"t_form_handle", "waiting_text":"<?php echo addslashes(__("website/others/button1-pending")); ?>"});'><?php echo $module->lang["apply"]; ?></a>
        </div>


    </form>

    <div class="clear"></div>
</div>