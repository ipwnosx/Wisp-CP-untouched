<?php

    if(Bootstrap::$lang->clang != "tr" || Config::get("general/country") != "tr") unset($templates["sms"]);
?>
<!DOCTYPE html>
<html>
<head>

    <?php
        Utility::sksort($lang_list,"local");
        $plugins    = ['jquery-ui','jquery-nestable','isotope'];
        include __DIR__.DS."inc".DS."head.php";
    ?>
    
    <script type="text/javascript">
        function delete_header_logo(){
            $("#header-logo").val('');
            $("#header-logo-preview").attr("src","<?php echo $settings["header-logo-default"]; ?>");

            var request = MioAjax({
                action:"<?php echo $links["controller"]; ?>",
                method:"POST",
                data:{operation:"delete_header_logo"}
            },true,true);

            request.done(function(result){
            });
        }

        function delete_footer_logo(){
            $("#footer-logo").val('');
            $("#footer-logo-preview").attr("src","<?php echo $settings["footer-logo-default"]; ?>");

            var request = MioAjax({
                action:"<?php echo $links["controller"]; ?>",
                method:"POST",
                data:{operation:"delete_footer_logo"}
            },true,true);

            request.done(function(result){

            });
        }

        $(function () {
            var $container = $('.bildirimsablonlari');
            $container.isotope({
                itemSelector: '.bildirimsablon'
            });
        });
    </script>
    
</head>
<body>

<div id="settings" style="display: none;" data-izimodal-title="<?php echo __("admin/notifications/templates-settings"); ?>">
    <div class="padding20">

        <form action="<?php echo $links["controller"]; ?>" method="post" id="settingsForm" enctype="multipart/form-data">
            <input type="hidden" name="operation" value="edit_settings">

            <div class="formcon">
                <div class="yuzde30"><?php echo __("admin/notifications/templates-settings-header-logo"); ?>
                    <div class="clear"></div>
                    <span class="kinfo"><?php echo __("admin/notifications/templates-settings-header-logo-desc"); ?></span>
                </div>
                <div class="yuzde70">
                    <input style="margin-bottom:5px;" type="file" name="header-logo" id="header-logo" onchange="read_image_file(this,'header-logo-preview');" data-default-image="<?php echo $settings["header-logo-default"]; ?>" />
                    <img src="<?php echo $settings["header-logo"]; ?>" width="100%" style="  float:left;    width: 170px;" id="header-logo-preview">
                    <a href="javascript:delete_header_logo();void 0;" class="red sbtn"><i class="fa fa-trash"></i></a>
                </div>
            </div>

            <div class="formcon">
                <div class="yuzde30"><?php echo __("admin/notifications/templates-settings-footer-logo"); ?>
                    <div class="clear"></div>
                    <span class="kinfo"><?php echo __("admin/notifications/templates-settings-footer-logo-desc"); ?></span>
                </div>
                <div class="yuzde70">
                    <input style="margin-bottom:5px;" type="file" name="footer-logo" id="footer-logo" onchange="read_image_file(this,'footer-logo-preview');" data-default-image="<?php echo $settings["footer-logo-default"]; ?>" />
                    <img src="<?php echo $settings["footer-logo"]; ?>" width="100%" style=" float:left;     width: 170px;" id="footer-logo-preview">
                    <a href="javascript:delete_footer_logo();void 0;" class="red sbtn"><i class="fa fa-trash"></i></a>
                </div>
            </div>


            <div class="formcon" style="display:none">
                <div class="yuzde30">
                    <?php echo __("admin/notifications/templates-settings-header"); ?>
                    <div class="clear"></div>
                    <span class="kinfo"><?php echo __("admin/notifications/templates-settings-header-info"); ?></span>
                </div>
                <div class="yuzde70">
                    <textarea name="header"><?php echo $settings["header"]; ?></textarea>
                </div>
            </div>

            <div class="formcon">
                <div class="yuzde30">
                    <?php echo __("admin/notifications/templates-settings-content"); ?>
                    <div class="clear"></div>
                    <span class="kinfo"><?php echo __("admin/notifications/templates-settings-content-info"); ?></span>
                </div>
                <div class="yuzde70">
                    <textarea style="font-size:13px;" rows="9" name="content"><?php echo $settings["content"]; ?></textarea>
                </div>
            </div>

            <div class="formcon" style="display:none">
                <div class="yuzde30">
                    <?php echo __("admin/notifications/templates-settings-footer"); ?>
                    <div class="clear"></div>
                    <span class="kinfo"><?php echo __("admin/notifications/templates-settings-footer-info"); ?></span>
                </div>
                <div class="yuzde70">
                    <textarea name="footer"><?php echo $settings["footer"]; ?></textarea>
                </div>
            </div>

            <div class="formcon">
                <div class="yuzde30">
                    <?php echo __("admin/notifications/templates-settings-variables"); ?>
                    <div class="clear"></div>
                    <span class="kinfo"><?php echo __("admin/notifications/templates-settings-variables-info"); ?></span>
                </div>
                <div class="yuzde70" id="template-variables">
                    <span>{notifi_header_logo}</span>
                    <span>{notifi_footer_logo}</span>
                    <span>{notifi_body}</span>
                    <span>{website_header_logo}</span>
                    <span>{website_footer_logo}</span>
                    <span>{website_url}</span>
                    <span>{website_title}</span>
                    <span>{website_infos}</span>
                    <span>{website_emails}</span>
                    <span>{website_phones}</span>
                    <span>{website_address}</span>
                </div>
            </div>

            <div class="guncellebtn yuzde30" style="float: right;">
                <a href="javascript:void(0);" id="settingsForm_submit" class="gonderbtn yesilbtn"><?php echo ___("needs/button-save"); ?></a>
            </div>


            <div class="clear"></div>

        </form>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#settingsForm_submit").on("click",function(){
                    MioAjaxElement($(this),{
                        waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                        progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                        result:"settingsForm_handler",
                    });
                });
            });

            function settingsForm_handler(result){
                if(result != ''){
                    var solve = getJson(result);
                    if(solve !== false){
                        if(solve.status == "error"){
                            if(solve.for != undefined && solve.for != ''){
                                $("#settingsForm "+solve.for).focus();
                                $("#settingsForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                $("#settingsForm "+solve.for).change(function(){
                                    $(this).removeAttr("style");
                                });
                            }
                            if(solve.message != undefined && solve.message != '')
                                alert_error(solve.message,{timer:5000});
                        }else if(solve.status == "successful"){
                            alert_success(solve.message,{timer:2000});
                            if(solve.redirect != undefined && solve.redirect != ''){
                                setTimeout(function(){
                                    window.location.href = solve.redirect;
                                },2000);
                            }
                        }
                    }else
                        console.log(result);
                }
            }
        </script>


        <div class="clear"></div>
    </div>
</div>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1><strong><?php echo __("admin/notifications/page-templates"); ?></strong></h1>
                <a href="javascript:open_modal('settings',{width:'800px'});void 0;" class="lbtn"><?php echo __("admin/notifications/templates-settings"); ?></a>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>


            <div class="bildirimsablonlari">

                <?php
                    if($templates){
                        foreach($templates AS $template){
                            ?>
                            <div class="bildirimsablon">
                                <div class="padding15">
                                    <h4><?php echo $template["name"]; ?></h4>

                                    <?php
                                        if($template["items"]){
                                            foreach($template["items"] AS $key=>$item){
                                                $detail_link = Controllers::$init->AdminCRLink("notifications-2",["templates","edit"])."?group=".$template["key"]."&key=".$key;
                                                $name = __("admin/notifications/templates/".$key);
                                                if(!$name) $name = $key;
                                                $status = Config::get("notifications/".$template["key"]."/".$key."/status");
                                                ?>
                                                <div class="formcon">
                                                    <div class="yuzde70">
                                                        <?php if($status): ?>
                                                            <i class="fa fa-check-circle" title="<?php echo __("admin/notifications/situations/active"); ?>"></i>
                                                        <?php else: ?>
                                                            <i class="fa fa-power-off" title="<?php echo __("admin/notifications/situations/inactive"); ?>"></i>
                                                        <?php endif; ?>

                                                        <?php echo $name; ?>
                                                    </div>
                                                    <div class="yuzde30"><a href="<?php echo $detail_link; ?>" data-tooltip="<?php echo ___("needs/button-edit"); ?>" class="sbtn"><i class="fa fa-edit"></i></a></div>
                                                </div>
                                                <?php
                                            }
                                        }
                                    ?>

                                    <div class="clear"></div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                ?>


            </div>
            <div class="clear"></div>

        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>