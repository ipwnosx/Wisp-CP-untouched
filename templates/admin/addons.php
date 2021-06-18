<!DOCTYPE html>
<html>
<head>
    <?php
        $plugins    = [
            'select2',
            'jquery-ui',
            'dataTables',
        ];
        include __DIR__.DS."inc".DS."head.php";
    ?>

    <script type="text/javascript">
        var temp_content = [];
        $(document).ready(function(){

            $(".change-addon-status-trigger").change(function(){
                var elem = $(this);
                var key = elem.data("module");
                var status = elem.prop("checked") ? 1 : 0;

                var request = MioAjax({
                    action:"<?php echo Controllers::$init->ControllerURI(); ?>",
                    method:"POST",
                    data:{
                        operation:"set_addon_status",
                        module:key,
                        status:status,
                    },
                },true,true);
                request.done(function(result){
                    if(result != ''){
                        var solve = getJson(result);
                        if(solve !== false){
                            if(solve.status == "error"){
                                if(status == 1) elem.prop("checked",false);
                                else elem.prop("checked",true);

                                if(solve.message != undefined && solve.message != '')
                                    alert_error(solve.message,{timer:5000});
                            }else if(solve.status == "successful"){
                                alert_success(solve.message,{timer:2000});
                                if(solve.redirect != undefined && solve.redirect != '') window.location.href = solve.redirect;
                            }
                        }else
                            console.log(result);
                    }
                });

            });


        });

        function open_addon(key,type){
            if(type == "modal"){

                open_modal("open_addon_modal",{
                    title:$("#addon_"+key+" .addon-name").html(),
                    width:'900px',
                });
                $("#open_addon_modal_loader").css("display","block");
                $("#open_addon_modal_content").css("display","none").html('');

                var request = MioAjax({
                    action:"<?php echo Controllers::$init->ControllerURI(); ?>",
                    method:"GET",
                    data:{
                        operation:"get_addon_content",
                        module:key,
                    },
                },true,true);
                request.done(function(result){
                    $("#open_addon_modal_loader").css("display","none");
                    $("#open_addon_modal_content").html(result).fadeIn(1);
                });
            }else if(type == "normal"){
                $("#addons_list").fadeOut(500,function(){
                    var addon_content = $("#addon_"+key).html();
                    temp_content[key] = addon_content;

                    $("#addon_inline_content").html(addon_content);
                    $("#addon_"+key).html('');
                    $("#addon_inline_content .open-addon-btn").remove();
                    $("#addon_inline_content .addoncontrol").remove();
                    $("#addon_inline_content .close-addon-btn").css("display","none");

                    $(".addon-settings-inline,.addon-settings-inline-loader").css("display","none");
                    $(".addon-settings-inline-content").html('');

                    $("#addon_inline_content .addon-settings-inline").css("display","block");

                    $("#addon_inline_content .addon-settings-inline-loader").css("display","block");

                    $("#addon_inline_content").fadeIn(1000);

                    $("html, body").animate({ scrollTop: $('#addons_list').offset().top},100);

                    setTimeout(function(){
                       var request = MioAjax({
                           action:"<?php echo Controllers::$init->ControllerURI(); ?>",
                           method:"GET",
                           data:{
                               operation:"get_addon_content",
                               module:key,
                           },
                       },true,true);

                        $("#addon_inline_content .close-addon-btn").css("display","inline-block");

                       request.done(function(result){
                           $("#addon_inline_content .addon-settings-inline-loader").fadeOut(300,function(){
                               $("#addon_inline_content .addon-settings-inline-content").html(result).fadeIn(200);
                           });
                       });
                   },1000);
                });

            }
        }

        function close_addon(key, type){

            if(type == "modal") close_modal("open_addon_modal");
            else if(type == "normal"){
                $("#addon_inline_content").fadeOut(500,function(){
                    $(this).html('');
                    $("#addon_"+key).html(temp_content[key]);
                    temp_content[key]
                    $("#addons_list").fadeIn(500);
                });
            }

        }
    </script>
</head>
<body>

<div id="open_addon_modal" style="display: none;">
    <div class="padding20">
        <div id="open_addon_modal_loader" align="center">
            <img src="<?php echo $sadress; ?>assets/images/loading.gif">
        </div>
        <div id="open_addon_modal_content" style="display: none;"></div>
    </div>
</div>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1><strong><?php echo $module ? $page_title : __("admin/tools/page-addons"); ?></strong></h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="clear"></div>

            <div id="addon_inline_content" style="display: none;">

            </div>

            <div id="addons_list">
                <?php
                    if(isset($modules) && $modules){
                        foreach($modules AS $key=>$module){
                            $config     = $module["config"];
                            $lang       = $module["lang"];
                            $ms_folder  = CORE_FOLDER.DS.MODULES_FOLDER.DS."Addons".DS;
                            $folder     = $ms_folder.$key.DS;
                            $logo       = isset($config["meta"]["logo"]) ? $config["meta"]["logo"] : NULL;
                            $logo       = Utility::image_link_determiner($logo,$folder);
                            if($logo == '') $logo   = Utility::image_link_determiner("default-logo.svg",$ms_folder);
                            $version    = isset($config["meta"]["version"]) ? $config["meta"]["version"] : "1.0";
                            $op_type    = isset($config["meta"]["opening-type"]) ? $config["meta"]["opening-type"] : "none";

                            ?>
                            <div class="addonlist" id="addon_<?php echo $key; ?>">
                                <div class="addonimage">
                                    <img height="75" src="<?php echo $logo; ?>"/>
                                    <h5>V<?php echo $version; ?></h5>

                                    <?php if($op_type != "none"): ?>
                                        <a href="javascript:open_addon('<?php echo $key; ?>','<?php echo $op_type; ?>');void 0;" class="lbtn open-addon-btn"><i class="fa fa-cog" aria-hidden="true"></i> <?php echo __("admin/tools/addons-settings-button"); ?></a>
                                    <?php endif; ?>

                                </div>
                                <div class="addoninfo">
                                    <h4 class="addon-name"><?php echo isset($lang["meta"]["name"]) ? $lang["meta"]["name"] : $config["meta"]["name"]; ?></h4>
                                    <p><?php echo isset($lang["meta"]["descriptions"]) ? $lang["meta"]["descriptions"] : 'No Descriptions...'; ?></p>
                                </div>
                                <div class="addoncontrol">
                                    <input<?php echo isset($config["status"]) && $config["status"] ? ' checked' : ''; ?> type="checkbox" value="1" id="<?php echo $key; ?>-status" class="change-addon-status-trigger sitemio-checkbox" data-module="<?php echo $key; ?>">
                                    <label for="<?php echo $key; ?>-status" class="sitemio-checkbox-label"></label>
                                </div>

                                <div class="addon-settings-inline adminpagecon" style="display: none;">
                                    <a href="javascript:close_addon('<?php echo $key; ?>','<?php echo $op_type; ?>');void 0;" class="lbtn red close-addon-btn"><i class="fa fa-angle-left"></i> <?php echo __("admin/tools/button-turn-back"); ?></a>
                                    <div class="clear"></div>
                                    <div class="addon-settings-inline-loader" align="center" style="width: 100%;">
                                        <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
                                    </div>
                                    <div class="addon-settings-inline-content" style="display: none;width: 100%;"></div>
                                </div>

                            </div>
                            <?php
                        }

                        ?>
                        <?php
                    }

                    echo $module_content;

                ?>
            </div>





            <div class="clear"></div>
        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>