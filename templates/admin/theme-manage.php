<?php
    $backgroundsConfigure   = Admin::isPrivilege(['SETTINGS_BACKGROUNDS_CONFIGURE']);
    $homeConfigure          = Admin::isPrivilege(['SETTINGS_HOME_CONFIGURE']);
?>
<!DOCTYPE html>
<html>
<head>
    <?php
        $plugins    = ['jquery-ui','spectrum-color','select2','jQtags'];
        include __DIR__.DS."inc".DS."head.php";
    ?>
    <script type="text/javascript">
        var
            waiting_text  = '<?php echo ___("needs/button-waiting"); ?>',
            progress_text = '<?php echo ___("needs/button-uploading"); ?>';
        var is_uploading=false;

        $(document).ready(function(){

            $("#submit1").on("click",function(){
                MioAjaxElement($(this),{
                    waiting_text: waiting_text,
                    progress_text: progress_text,
                    result:"submit1_handler",
                });
            });

            $("#submit2").on("click",function(){
                MioAjaxElement($(this),{
                    waiting_text: waiting_text,
                    progress_text: progress_text,
                    result:"submit2_handler",
                });
            });

            $(".theme-settings").on('click','.settingsForm_submit',function(){
                MioAjaxElement($(this),{
                    waiting_text: waiting_text,
                    progress_text: progress_text,
                    result:"submit1_handler",
                });
            });

            $("#select_theme_file_icon").click(function(){
                $("#upload_theme_file").trigger("click");
            });

            $('#upload_theme_file').change(function(e){
                if(e.target.files.length > 0){
                    var name = e.target.files[0].name;
                    if(name.length > 30) name = name.substr(0,30)+"...";
                    $("#upload_theme_file_name").html(name).fadeIn(200);
                    $("#upload_theme_file_btn").removeClass("graybtn");
                }else{
                    $("#upload_theme_file_name").fadeOut(200).html('');
                    $("#upload_theme_file_btn").addClass("graybtn");
                }
            });

            $("#upload_theme_file_btn").click(function(){
                if(is_uploading) return false;

                if(document.getElementById("upload_theme_file").files.length < 1){
                    $("#upload_theme_file").trigger("click");
                    return false;
                }

                is_uploading = true;

                $("#select_theme_file_icon").animate({opacity:0},300,function(){
                    $(this).css("display","none");
                    $("#uploading_theme_file").css("display","block").animate({opacity:1},300);
                });

                $(this).addClass("graybtn");

                MioAjaxElement($(this),{
                    waiting_text: waiting_text,
                    progress_text: progress_text,
                    result:"upload_theme_handler",
                });
            });


            $(".select2").select2({width: '100%'});
            $(".extension-tags").tagsInput({
                'width':'100%',
                'height': '50px',
                'interactive':true,
                'defaultText':'<?php echo __("admin/settings/add-file-extension"); ?>',
                'removeWithBackspace' : true,
                'placeholderColor' : '#007a7a'
            });

            var tab = _GET("group");
            if(tab != '' && tab != undefined){
                $("#tab-group .tablinks[data-tab='"+tab+"']").click();
            }else{
                $("#tab-group .tablinks:eq(0)").addClass("active");
                $("#tab-group .tabcontent:eq(0)").css("display","block");
            }

            var open_theme_details = _GET("open");

            if(open_theme_details !== undefined && open_theme_details !== null && open_theme_details !== '')
                theme_details(open_theme_details);

        });

        function upload_theme_handler(result){
            is_uploading = false;
            $("#upload_theme_file_btn").removeClass("graybtn");
            $("#upload_theme_file").val('').trigger("change");

            $("#uploading_theme_file").animate({opacity:0},300,function(){
                $(this).css("display","none");
                $("#select_theme_file_icon").css("display","block").animate({opacity:1},300);
            });

            if(result !== ''){
                var solve = getJson(result);
                if(solve !== false){
                    if(solve.status == "error"){
                        if(solve.message != undefined && solve.message != '')
                            alert_error(solve.message,{timer:5000});
                    }else if(solve.status == "successful"){
                        if(solve.redirect != undefined) window.location.href = solve.redirect;
                        if(solve.message !== undefined) alert_success(solve.message,{timer:2000});
                    }
                }else
                    console.log(result);
            }
        }
        function submit1_handler(result){
            if(result != ''){
                var solve = getJson(result);
                if(solve !== false){
                    if(solve.status == "error"){
                        if(solve.for != undefined && solve.for != ''){
                            $("#form1 "+solve.for).focus();
                            $("#form1 "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                            $("#form1 "+solve.for).change(function(){
                                $(this).removeAttr("style");
                            });
                        }
                        if(solve.message != undefined && solve.message != '')
                            alert_error(solve.message,{timer:5000});
                    }else if(solve.status == "successful"){
                        if(solve.redirect != undefined){
                            setTimeout(function(){
                                window.location.href = solve.redirect;
                            },2000);
                        }
                        alert_success(solve.message,{timer:2000});
                    }
                }else
                    console.log(result);
            }
        }
        function submit2_handler(result){
            if(result != ''){
                var solve = getJson(result);
                if(solve !== false){
                    if(solve.status == "error"){
                        if(solve.for != undefined && solve.for != ''){
                            $("#form2 "+solve.for).focus();
                            $("#form2 "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                            $("#form2 "+solve.for).change(function(){
                                $(this).removeAttr("style");
                            });
                        }
                        if(solve.message != undefined && solve.message != '')
                            alert_error(solve.message,{timer:5000});
                    }else if(solve.status == "successful"){
                        if(solve.redirect != undefined){
                            setTimeout(function(){
                                window.location.href = solve.redirect;
                            },2000);
                        }
                        alert_success(solve.message,{timer:2000});
                    }
                }else
                    console.log(result);
            }
        }
        function delete_background_video(lang,key){
            var request = MioAjax({
                button_element:$("#block_background_video_remove_"+lang+"_"+key),
                waiting_text:'<i class="fa fa-spinner" style="-webkit-animation:fa-spin 2s infinite linear;animation: fa-spin 2s infinite linear;"></i>',
                action:"<?php echo $links["controller"]; ?>",
                method:"POST",
                data:{
                    "operation":"delete_block_background_video",
                    "lang":lang,
                    "key":key
                }
            },true,true);

            request.done(function(result){
                if(result != ''){
                    var solve = getJson(result);
                    if(solve !== false){

                        if(solve.status == "error"){
                            if(solve.message != undefined && solve.message != '')
                                alert_error(solve.message,{timer:5000});
                        }else if(solve.status == "successful"){
                            $("#block_background_video_play_"+lang+"_"+key).remove();
                            $("#block_background_video_remove_"+lang+"_"+key).remove();
                        }

                    }else
                        console.log(result);
                }
            });

        }
        function theme_details(key){

            var theme_details = $("div[data-key='"+key+"'] .theme-details").html();

            open_modal("theme_details_modal");

            $("#get_theme_details").html(theme_details);

        }
        function theme_settings(key){
            $(".jscolor").spectrum("destroy");
            open_modal(key+"_settings_modal",{width:'800px'});

            $(".jscolor").spectrum({
                preferredFormat: "hex",
                showInput: true,
                showInitial: true,
                allowEmpty: true
            });
        }
        function download_theme(key,elem){
            var link = "<?php echo $links["controller"]."?operation=download_theme&key="; ?>"+key;
            window.open(link, '_blank');
        }
        function upgrade_theme_version(key,elem){
            var request = MioAjax({
                button_element:elem,
                waiting_text:waiting_text,
                action: "<?php echo $links["controller"]; ?>",
                method: "POST",
                data:{
                    operation:"upgrade_theme_version",
                    key:key,
                },
            },true,true);

            request.done(function(result){
                if(result !== ''){
                    var solve = getJson(result);
                    if(solve !== false){
                        if(solve.status == "error"){
                            if(solve.message != undefined && solve.message != '')
                                alert_error(solve.message,{timer:5000});
                        }else if(solve.status == "successful"){
                            alert_success(solve.message,{timer:2000});
                            if(solve.redirect !== undefined){
                                setTimeout(function(){
                                    window.location.href = solve.redirect;
                                },2000);
                            }
                        }
                    }else
                        console.log(result);
                }
            });
        }
        function remove_theme(key,elem){
            var before_btn_html = $(elem).html();

            if(!confirm('<?php echo ___("needs/delete-are-you-sure"); ?>'))
                return false;

            $(elem).html('<i class="fa fa-spinner" aria-hidden="true" style="-webkit-animation:fa-spin 2s infinite linear;animation: fa-spin 2s infinite linear;"></i>');

            var request = MioAjax({
                action: "<?php echo $links["controller"]; ?>",
                method: "POST",
                data:{
                    operation:"remove_theme",
                    key:key,
                },
            },true,true);

            request.done(function(result){
                $(elem).html(before_btn_html);
                if(result !== ''){
                    var solve = getJson(result);
                    if(solve !== false){
                        if(solve.status == "error"){
                            if(solve.message != undefined && solve.message != '')
                                alert_error(solve.message,{timer:5000});
                        }else if(solve.status == "successful"){
                            $(elem).parent().parent().hide("explode",1000);
                        }
                    }else
                        console.log(result);
                }
            });
        }
        function apply_theme(key,elem){
            var before_btn_html = $(elem).html();

            $(elem).html('<i class="fa fa-spinner" aria-hidden="true" style="-webkit-animation:fa-spin 2s infinite linear;animation: fa-spin 2s infinite linear;"></i>');

            var request = MioAjax({
                action: "<?php echo $links["controller"]; ?>",
                method: "POST",
                data:{
                    operation:"apply_theme",
                    key:key,
                },
            },true,true);

            request.done(function(result){
                $(elem).html(before_btn_html);
                if(result !== ''){
                    var solve = getJson(result);
                    if(solve !== false){
                        if(solve.status == "error"){
                            if(solve.message != undefined && solve.message != '')
                                alert_error(solve.message,{timer:5000});
                        }else if(solve.status == "successful"){
                            setTimeout(function(){
                                window.location.href = "<?php echo $links["controller"]; ?>?group=theme";
                            },2000);
                            alert_success(solve.message,{timer:2000});
                        }
                    }else
                        console.log(result);
                }
            });
        }
    </script>

    <style type="text/css">
        .mio-state-highlight { background: #EEEEEE;}
        .mio-state-highlight2 { background: #EEEEEE; width:100%;min-height:55px;float:left;}
    </style>

</head>
<body>

<div id="theme_details_modal" data-izimodal-title="<?php echo __("admin/settings/theme-manage-theme-details"); ?>" style="display: none;">
    <div class="padding20">
        <div id="get_theme_details"></div>
        <div class="clear"></div>
    </div>
</div>
<div id="theme_settings_modal" data-izimodal-title="" style="display: none;">

</div>


<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1><?php echo __("admin/settings/page-theme-manage"); ?></h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div id="tab-group">
                <ul class="tab">

                    <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'logo','group')" data-tab="logo"> <?php echo __("admin/settings/theme-manage-tab-logo"); ?> </a></li>
                    <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'theme','group')" data-tab="theme"> <?php echo __("admin/settings/theme-manage-tab-theme"); ?></a></li>
                    <?php if($backgroundsConfigure): ?>
                        <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'backgrounds','group')" data-tab="backgrounds"> <?php echo __("admin/settings/theme-manage-tab-backgrounds"); ?></a></li>
                    <?php endif; ?>

                    <?php if($homeConfigure): ?>
                        <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'home','group')" data-tab="home"> <?php echo __("admin/settings/theme-manage-tab-home"); ?></a></li>
                    <?php endif; ?>

                    <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'other','group')" data-tab="other"> <?php echo __("admin/settings/theme-manage-tab-other"); ?> </a></li>

                </ul>

                <div id="group-logo" class="tabcontent"><!-- tab content start -->

                    <div class="adminpagecon">

                        <form action="<?php echo $links["controller"]; ?>" method="post" enctype="multipart/form-data" id="form1">
                            <input type="hidden" name="operation" value="update_logo">

                            <div class="formcon">


                                <div style="text-align:center;">

                                <div class="adblok">
                                    <div class="adblokcon">
                                        <h4 class="adltitle"><?php echo __("admin/settings/header-logo-upload"); ?></h4>
                                        <input name="header_logo" type="file" onchange="read_image_file(this,'header_logo_preview');">
                                        <div style="text-align:center;"><img src="<?php echo $header_logo_link; ?>?time=<?php echo time(); ?>" width="150" height="auto" id="header_logo_preview"></div>
                                    </div>
                                </div>

                                <div class="adblok">
                                    <div class="adblokcon">
                                        <h4 class="adltitle"><?php echo __("admin/settings/footer-logo-upload"); ?></h4>
                                        <input name="footer_logo" type="file" onchange="read_image_file(this,'footer_logo_preview');">
                                        <div style="text-align:center;"><img src="<?php echo $footer_logo_link; ?>?time=<?php echo time(); ?>" width="150" height="auto" id="footer_logo_preview"></div>
                                    </div>
                                </div>

                                <div class="clear"></div>

                                <div class="adblok">
                                    <div class="adblokcon">
                                        <h4 class="adltitle"><?php echo __("admin/settings/clientArea-logo-upload"); ?></h4>
                                        <input name="clientArea_logo" type="file" onchange="read_image_file(this,'clientArea_logo_preview');">
                                        <div style="text-align:center;"><img src="<?php echo $clientArea_logo_link; ?>?time=<?php echo time(); ?>" width="150" height="auto" id="clientArea_logo_preview"></div>
                                    </div>
                                </div>

                                <div class="adblok">
                                    <div class="adblokcon">
                                        <h4 class="adltitle"><?php echo __("admin/settings/favicon-logo-upload"); ?></h4>
                                        <input name="favicon_logo" type="file" onchange="read_image_file(this,'favicon_logo_preview');">
                                        <div style="text-align:center;"><img src="<?php echo $favicon_link; ?>?time=<?php echo time(); ?>" width="15" height="15" id="favicon_logo_preview"></div>
                                    </div>
                                </div>

                            </div>


                            </div>


                            <div style="float:right;" class="guncellebtn yuzde30"><a id="submit1" href="javascript:void(0);" class="yesilbtn gonderbtn"><?php echo __("admin/settings/update-button1"); ?></a></div>

                        </form>


                    </div>


                    <div class="clear"></div>
                </div><!-- tab content end -->
                <div id="group-theme" class="tabcontent"><!-- tab content start -->
                        <div class="thememanage">


                            <div class="themeblock" id="themeupload">
                                <form id="ThemeUploadForm" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="operation" value="upload_theme">
                                    <input style="display: none;" type="file" name="theme" id="upload_theme_file" accept=".zip">

                                    <i style="cursor: pointer;" id="select_theme_file_icon" title="<?php echo __("admin/settings/theme-manage-button-select-theme-file"); ?>" class="fa fa-cloud-upload" aria-hidden="true"></i>
                                    <div id="uploading_theme_file" style="opacity:0;display: none;">
                                        <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
                                    </div>
                                    <h5 id="upload_theme_file_name" style="display: none;"></h5>

                                    <a href="javascript:void 0;" class="graybtn lbtn" id="upload_theme_file_btn"><?php echo __("admin/settings/theme-manage-button-upload-theme"); ?></a>
                                </form>
                            </div>


                            <?php
                                if(isset($themes) && $themes){
                                    foreach($themes AS $k=>$theme){
                                        $preview_theme  = APP_URI."/index?preview_theme=".$theme["key"];
                                        ?>
                                        <div class="themeblock"<?php echo $theme["active"] ? ' id="tblockactive"' : ''; ?> data-key="<?php echo $theme["key"]; ?>">
                                            <div class="theme-details" style="display: none;">
                                                <div class="formcon">
                                                    <div class="yuzde30"><?php echo __("admin/settings/theme-manage-theme-name"); ?></div>
                                                    <div class="yuzde70"><?php echo $theme["config"]["meta"]["name"]; ?></div>
                                                </div>
                                                <div class="formcon">
                                                    <div class="yuzde30"><?php echo __("admin/settings/theme-manage-version"); ?></div>
                                                    <div class="yuzde70">
                                                        v<?php echo $theme["config"]["meta"]["version"]; ?>

                                                        <?php
                                                            if(isset($theme["new-update"])){
                                                                ?>
                                                                <a href="javascript:void 0;" onclick="upgrade_theme_version('<?php echo $theme["key"]; ?>',this);" class="green lbtn" style="margin-left:10px;"><?php echo __("admin/settings/theme-manage-button-upgrade-version",['{version}' => $theme["new-update"]["version"]]); ?></a>

                                                                <?php
                                                                    if(isset($theme["new-update"]["details_url"]) && $theme["new-update"]["details_url"])
                                                                    {
                                                                        ?>
                                                                        <a href="<?php echo $theme["new-update"]["details_url"]; ?>" target="_blank" class="lbtn" style="margin-left:10px;"><?php echo __("admin/settings/theme-manage-button-version-details"); ?></a>
                                                                        <?php
                                                                    }
                                                                ?>

                                                                <?php
                                                            }
                                                        ?>

                                                    </div>
                                                </div>

                                                <div class="formcon">
                                                    <div class="yuzde30"><?php echo __("admin/settings/theme-manage-provider"); ?></div>
                                                    <div class="yuzde70"><?php echo $theme["config"]["meta"]["provider"]; ?></div>
                                                </div>

                                                <?php
                                                    if(isset($theme["config"]["meta"]["description"]) && $theme["config"]["meta"]["description"]){
                                                        ?>
                                                        <div class="formcon">
                                                            <div class="yuzde30"><?php echo __("admin/settings/theme-manage-descriptions"); ?></div>
                                                            <div class="yuzde70">
                                                                <?php echo Filter::link_convert(nl2br(Filter::html_clear($theme["config"]["meta"]["description"]),true)); ?>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                ?>

                                                <div class="formcon">
                                                    <div class="yuzde30">
                                                        <?php echo __("admin/settings/theme-manage-links"); ?>
                                                    </div>
                                                    <div class="yuzde70">
                                                        <?php
                                                            if(isset($theme["config"]["meta"]["website"]) && $theme["config"]["meta"]["website"]){
                                                                ?>
                                                                <a href="<?php echo $theme["config"]["meta"]["website"]; ?>" class="lbtn" referrerpolicy="no-referrer" target="_blank"><?php echo __("admin/settings/theme-manage-button-website"); ?></a>
                                                                <?php
                                                            }
                                                            if(!$theme["active"]){
                                                                ?>
                                                                <a href="<?php echo $preview_theme; ?>" class="lbtn" referrerpolicy="no-referrer" target="_blank"><?php echo __("admin/settings/theme-manage-preview-theme"); ?></a>
                                                                <?php
                                                            }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>


                                            <?php
                                                if(isset($theme["page_settings"]) && $theme["page_settings"]){
                                                    ?>
                                                    <div style="display: none;" data-izimodal-title="<?php echo $theme["config"]["meta"]["name"]; ?> - <?php echo __("admin/settings/theme-manage-button-settings"); ?>" class="theme-settings" id="<?php echo $theme["key"]."_settings_modal"; ?>">
                                                        <div class="padding20">

                                                            <form action="<?php echo $links["controller"]; ?>" method="post" id="<?php echo $k; ?>_settingsForm">
                                                                <input type="hidden" name="operation" value="update_theme_settings">
                                                                <input type="hidden" name="key" value="<?php echo $theme["key"]; ?>">

                                                                <?php echo $theme["page_settings"]; ?>

                                                                <div class="clear"></div>

                                                                <div style="float:right;" class="guncellebtn yuzde30">
                                                                    <a href="javascript:void(0);" class="settingsForm_submit yesilbtn gonderbtn"><?php echo __("admin/settings/update-button1"); ?></a>
                                                                </div>
                                                            </form>
                                                            <div class="clear"></div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            ?>

                                            <div class="tblockhover">
                                                <?php
                                                    if(!$theme["active"] && !$theme["disable_remove_btn"]){
                                                        ?>
                                                        <a data-balloon-pos="left" data-balloon="<?php echo __("admin/settings/theme-manage-remove-theme"); ?>" class="themedel" href="javascript:void 0;" onclick="remove_theme('<?php echo $theme["key"]; ?>',this);">
                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                        </a>
                                                        <?php
                                                    }
                                                ?>
                                                <a data-balloon-pos="left" data-balloon="<?php echo __("admin/settings/theme-manage-download-theme"); ?>" class="themedownload" href="javascript:void 0;" onclick="download_theme('<?php echo $theme["key"]; ?>',this);">
                                                    <i class="fa fa-download" aria-hidden="true"></i>
                                                </a>

                                                <a class="tblockdetail" href="javascript:void 0;" onclick="theme_details('<?php echo $theme["key"]; ?>');">
                                                    <?php echo __("admin/settings/theme-manage-theme-details"); ?>
                                                </a>
                                            </div>
                                            <img src="<?php echo $theme["config"]["meta"]["image"]; ?>">
                                            <div class="tblocktitle">
                                                <?php echo $theme["config"]["meta"]["name"]; ?>
                                                <span data-balloon-pos="right" data-balloon="<?php echo __("admin/settings/theme-manage-used-theme"); ?>" class="active_con" style="<?php echo $theme["active"] ? '' : 'display:none;'; ?>"><i class="fa fa-check-circle-o" aria-hidden="true"></i></span>
                                            </div>
                                            <div class="tblockbtn">
                                                <a onclick="theme_settings('<?php echo $theme["key"]; ?>');" class="settings_btn" style="<?php echo $theme["active"] && $theme["view_settings_btn"] ? '' : 'display:none;'; ?>" href="javascript:void 0;"><?php echo __("admin/settings/theme-manage-button-settings"); ?></a>

                                                <a class="preview_btn" style="<?php echo $theme["active"] ? 'display:none;' : ''; ?>" href="<?php echo $preview_theme; ?>"><?php echo __("admin/settings/theme-manage-preview-theme"); ?></a>

                                                <a onclick="apply_theme('<?php echo $theme["key"]; ?>',this);" class="apply_btn" style="<?php echo !$theme["active"] && !$theme["disable_apply_btn"] ? '' : 'display:none;'; ?>" href="javascript:void 0;"><?php echo ___("needs/button-apply"); ?></a>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                            ?>


                       </div>

              


                    <div class="clear"></div>
                </div><!-- tab content end -->

                <?php if($backgroundsConfigure): ?>
                    <div id="group-backgrounds" class="tabcontent"><!-- tab start -->

                        <div class="adminuyedetay">

                            <div class="green-info" style="margin-bottom:20px;">
                                <div class="padding15">
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                    <p><?php echo __("admin/settings/header-background-desc"); ?></p>
                                </div>
                            </div>

                            <form action="<?php echo $links["controller"]; ?>" method="post" enctype="multipart/form-data" id="backgroundsForm">
                                <input type="hidden" name="operation" value="update_backgrounds_settings">
                                <?php
                                    $get_picture = $functions["get_picture"];
                                ?>

                                <div class="headerbgedit">
                                    <?php
                                        $picture = $get_picture("page_normal","header-background");
                                    ?>
                                    <input type="file" name="page-normal-header-background" id="page-normal-header-background" style="display:none;" onchange="read_image_file(this,'page-normal-header-background_preview');" />
                                    <div class="headbgeditbtn">
                                        <span> <?php echo __("admin/settings/background-page-normal"); ?></span><br/>
                                        <a class="avatarguncelle" href="javascript:void(0);" onclick="$('#page-normal-header-background').click();" ><i class="fa fa-camera" aria-hidden="true"></i></a>
                                    </div>
                                    <img src="<?php echo $picture ? $picture["link"] : $tadress."images/no-image-wide.jpg"; ?>?time=<?php echo time(); ?>" width="100%" id="page-normal-header-background_preview">
                                </div>

                                <div class="headerbgedit">
                                    <?php
                                        $picture = $get_picture("page_articles","header-background");
                                    ?>
                                    <input type="file" name="page-articles-header-background" id="page-articles-header-background" style="display:none;" onchange="read_image_file(this,'page-articles-header-background_preview');" />
                                    <div class="headbgeditbtn">
                                        <span> <?php echo __("admin/settings/background-page-articles"); ?></span><br/>
                                        <a class="avatarguncelle" href="javascript:void(0);" onclick="$('#page-articles-header-background').click();" ><i class="fa fa-camera" aria-hidden="true"></i></a>
                                    </div>
                                    <img src="<?php echo $picture ? $picture["link"] : $tadress."images/no-image-wide.jpg"; ?>?time=<?php echo time(); ?>" width="100%" id="page-articles-header-background_preview">
                                </div>

                                <div class="headerbgedit">
                                    <?php
                                        $picture = $get_picture("page_news","header-background");
                                    ?>
                                    <input type="file" name="page-news-header-background" id="page-news-header-background" style="display:none;" onchange="read_image_file(this,'page-news-header-background_preview');" />
                                    <div class="headbgeditbtn">
                                        <span> <?php echo __("admin/settings/background-page-news"); ?></span><br/>
                                        <a class="avatarguncelle" href="javascript:void(0);" onclick="$('#page-news-header-background').click();" ><i class="fa fa-camera" aria-hidden="true"></i></a>
                                    </div>
                                    <img src="<?php echo $picture ? $picture["link"] : $tadress."images/no-image-wide.jpg"; ?>?time=<?php echo time(); ?>" width="100%" id="page-news-header-background_preview">
                                </div>

                                <div class="headerbgedit">
                                    <?php
                                        $picture = $get_picture("page_software","header-background");
                                    ?>
                                    <input type="file" name="page-software-header-background" id="page-software-header-background" style="display:none;" onchange="read_image_file(this,'page-software-header-background_preview');" />
                                    <div class="headbgeditbtn">
                                        <span> <?php echo __("admin/settings/background-page-software"); ?></span><br/>
                                        <a class="avatarguncelle" href="javascript:void(0);" onclick="$('#page-software-header-background').click();" ><i class="fa fa-camera" aria-hidden="true"></i></a>
                                    </div>
                                    <img src="<?php echo $picture ? $picture["link"] : $tadress."images/no-image-wide.jpg"; ?>?time=<?php echo time(); ?>" width="100%" id="page-software-header-background_preview">
                                </div>

                                <div class="headerbgedit">
                                    <?php
                                        $picture = $get_picture("articles","header-background");
                                    ?>
                                    <input type="file" name="articles-header-background" id="articles-header-background" style="display:none;" onchange="read_image_file(this,'articles-header-background_preview');" />
                                    <div class="headbgeditbtn">
                                        <span> <?php echo __("admin/settings/background-articles"); ?></span><br/>
                                        <a class="avatarguncelle" href="javascript:void(0);" onclick="$('#articles-header-background').click();" ><i class="fa fa-camera" aria-hidden="true"></i></a>
                                    </div>
                                    <img src="<?php echo $picture ? $picture["link"] : $tadress."images/no-image-wide.jpg"; ?>?time=<?php echo time(); ?>" width="100%" id="articles-header-background_preview">
                                </div>

                                <div class="headerbgedit">
                                    <?php
                                        $picture = $get_picture("references","header-background");
                                    ?>
                                    <input type="file" name="references-header-background" id="references-header-background" style="display:none;" onchange="read_image_file(this,'references-header-background_preview');" />
                                    <div class="headbgeditbtn">
                                        <span> <?php echo __("admin/settings/background-references"); ?></span><br/>
                                        <a class="avatarguncelle" href="javascript:void(0);" onclick="$('#references-header-background').click();" ><i class="fa fa-camera" aria-hidden="true"></i></a>
                                    </div>
                                    <img src="<?php echo $picture ? $picture["link"] : $tadress."images/no-image-wide.jpg"; ?>?time=<?php echo time(); ?>" width="100%" id="references-header-background_preview">
                                </div>

                                <div class="headerbgedit">
                                    <?php
                                        $picture = $get_picture("news","header-background");
                                    ?>
                                    <input type="file" name="news-header-background" id="news-header-background" style="display:none;" onchange="read_image_file(this,'news-header-background_preview');" />
                                    <div class="headbgeditbtn">
                                        <span> <?php echo __("admin/settings/background-news"); ?></span><br/>
                                        <a class="avatarguncelle" href="javascript:void(0);" onclick="$('#news-header-background').click();" ><i class="fa fa-camera" aria-hidden="true"></i></a>
                                    </div>
                                    <img src="<?php echo $picture ? $picture["link"] : $tadress."images/no-image-wide.jpg"; ?>?time=<?php echo time(); ?>" width="100%" id="news-header-background_preview">
                                </div>

                                <div class="headerbgedit">
                                    <?php
                                        $picture = $get_picture("softwares","header-background");
                                    ?>
                                    <input type="file" name="softwares-header-background" id="softwares-header-background" style="display:none;" onchange="read_image_file(this,'softwares-header-background_preview');" />
                                    <div class="headbgeditbtn">
                                        <span> <?php echo __("admin/settings/background-softwares"); ?></span><br/>
                                        <a class="avatarguncelle" href="javascript:void(0);" onclick="$('#softwares-header-background').click();" ><i class="fa fa-camera" aria-hidden="true"></i></a>
                                    </div>
                                    <img src="<?php echo $picture ? $picture["link"] : $tadress."images/no-image-wide.jpg"; ?>?time=<?php echo time(); ?>" width="100%" id="softwares-header-background_preview">
                                </div>

                                <div class="headerbgedit">
                                    <?php
                                        $picture = $get_picture("knowledgebase","header-background");
                                    ?>
                                    <input type="file" name="knowledgebase-header-background" id="knowledgebase-header-background" style="display:none;" onchange="read_image_file(this,'knowledgebase-header-background_preview');" />
                                    <div class="headbgeditbtn">
                                        <span> <?php echo __("admin/settings/background-knowledgebase"); ?></span><br/>
                                        <a class="avatarguncelle" href="javascript:void(0);" onclick="$('#knowledgebase-header-background').click();" ><i class="fa fa-camera" aria-hidden="true"></i></a>
                                    </div>
                                    <img src="<?php echo $picture ? $picture["link"] : $tadress."images/no-image-wide.jpg"; ?>?time=<?php echo time(); ?>" width="100%" id="knowledgebase-header-background_preview">
                                </div>

                                <div class="headerbgedit">
                                    <?php
                                        $picture = $get_picture("contact","header-background");
                                    ?>
                                    <input type="file" name="contact-header-background" id="contact-header-background" style="display:none;" onchange="read_image_file(this,'contact-header-background_preview');" />
                                    <div class="headbgeditbtn">
                                        <span> <?php echo __("admin/settings/background-contact"); ?></span><br/>
                                        <a class="avatarguncelle" href="javascript:void(0);" onclick="$('#contact-header-background').click();" ><i class="fa fa-camera" aria-hidden="true"></i></a>
                                    </div>
                                    <img src="<?php echo $picture ? $picture["link"] : $tadress."images/no-image-wide.jpg"; ?>?time=<?php echo time(); ?>" width="100%" id="contact-header-background_preview">
                                </div>

                                <div class="headerbgedit">
                                    <?php
                                        $picture = $get_picture("domain","header-background");
                                    ?>
                                    <input type="file" name="domain-header-background" id="domain-header-background" style="display:none;" onchange="read_image_file(this,'domain-header-background_preview');" />
                                    <div class="headbgeditbtn">
                                        <span> <?php echo __("admin/settings/background-domain"); ?></span><br/>
                                        <a class="avatarguncelle" href="javascript:void(0);" onclick="$('#domain-header-background').click();" ><i class="fa fa-camera" aria-hidden="true"></i></a>
                                    </div>
                                    <img src="<?php echo $picture ? $picture["link"] : $tadress."images/no-image-wide.jpg"; ?>?time=<?php echo time(); ?>" width="100%" id="domain-header-background_preview">
                                </div>

                                <div class="headerbgedit">
                                    <?php
                                        $picture = $get_picture("basket","header-background");
                                    ?>
                                    <input type="file" name="basket-header-background" id="basket-header-background" style="display:none;" onchange="read_image_file(this,'basket-header-background_preview');" />
                                    <div class="headbgeditbtn">
                                        <span> <?php echo __("admin/settings/background-basket"); ?></span><br/>
                                        <a class="avatarguncelle" href="javascript:void(0);" onclick="$('#basket-header-background').click();" ><i class="fa fa-camera" aria-hidden="true"></i></a>
                                    </div>
                                    <img src="<?php echo $picture ? $picture["link"] : $tadress."images/no-image-wide.jpg"; ?>?time=<?php echo time(); ?>" width="100%" id="basket-header-background_preview">
                                </div>

                                <div class="headerbgedit">
                                    <?php
                                        $picture = $get_picture("order-steps","header-background");
                                    ?>
                                    <input type="file" name="order-steps-header-background" id="order-steps-header-background" style="display:none;" onchange="read_image_file(this,'order-steps-header-background_preview');" />
                                    <div class="headbgeditbtn">
                                        <span> <?php echo __("admin/settings/background-order-steps"); ?></span><br/>
                                        <a class="avatarguncelle" href="javascript:void(0);" onclick="$('#order-steps-header-background').click();" ><i class="fa fa-camera" aria-hidden="true"></i></a>
                                    </div>
                                    <img src="<?php echo $picture ? $picture["link"] : $tadress."images/no-image-wide.jpg"; ?>?time=<?php echo time(); ?>" width="100%" id="order-steps-header-background_preview">
                                </div>

                                <div class="headerbgedit">
                                    <?php
                                        $picture = $get_picture("account","header-background");
                                    ?>
                                    <input type="file" name="account-header-background" id="account-header-background" style="display:none;" onchange="read_image_file(this,'account-header-background_preview');" />
                                    <div class="headbgeditbtn">
                                        <span> <?php echo __("admin/settings/background-account"); ?></span><br/>
                                        <a class="avatarguncelle" href="javascript:void(0);" onclick="$('#account-header-background').click();" ><i class="fa fa-camera" aria-hidden="true"></i></a>
                                    </div>
                                    <img src="<?php echo $picture ? $picture["link"] : $tadress."images/no-image-wide.jpg"; ?>?time=<?php echo time(); ?>" width="100%" id="account-header-background_preview">
                                </div>

                                <div class="headerbgedit">
                                    <?php
                                        $picture = $get_picture("account_sms","header-background");
                                    ?>
                                    <input type="file" name="account-sms-header-background" id="account-sms-header-background" style="display:none;" onchange="read_image_file(this,'account-sms-header-background_preview');" />
                                    <div class="headbgeditbtn">
                                        <span> <?php echo __("admin/settings/background-account-sms"); ?></span><br/>
                                        <a class="avatarguncelle" href="javascript:void(0);" onclick="$('#account-sms-header-background').click();" ><i class="fa fa-camera" aria-hidden="true"></i></a>
                                    </div>
                                    <img src="<?php echo $picture ? $picture["link"] : $tadress."images/no-image-wide.jpg"; ?>?time=<?php echo time(); ?>" width="100%" id="account-sms-header-background_preview">
                                </div>

                                <div class="headerbgedit">
                                    <?php
                                        $picture = $get_picture("hosting","header-background");
                                    ?>
                                    <input type="file" name="hosting-header-background" id="hosting-header-background" style="display:none;" onchange="read_image_file(this,'hosting-header-background_preview');" />
                                    <div class="headbgeditbtn">
                                        <span> <?php echo __("admin/settings/background-hosting"); ?></span><br/>
                                        <a class="avatarguncelle" href="javascript:void(0);" onclick="$('#hosting-header-background').click();" ><i class="fa fa-camera" aria-hidden="true"></i></a>
                                    </div>
                                    <img src="<?php echo $picture ? $picture["link"] : $tadress."images/no-image-wide.jpg"; ?>?time=<?php echo time(); ?>" width="100%" id="hosting-header-background_preview">
                                </div>

                                <div class="headerbgedit">
                                    <?php
                                        $picture = $get_picture("server","header-background");
                                    ?>
                                    <input type="file" name="server-header-background" id="server-header-background" style="display:none;" onchange="read_image_file(this,'server-header-background_preview');" />
                                    <div class="headbgeditbtn">
                                        <span> <?php echo __("admin/settings/background-server"); ?></span><br/>
                                        <a class="avatarguncelle" href="javascript:void(0);" onclick="$('#server-header-background').click();" ><i class="fa fa-camera" aria-hidden="true"></i></a>
                                    </div>
                                    <img src="<?php echo $picture ? $picture["link"] : $tadress."images/no-image-wide.jpg"; ?>?time=<?php echo time(); ?>" width="100%" id="server-header-background_preview">
                                </div>

                                <div class="headerbgedit">
                                    <?php
                                        $picture = $get_picture("special-products","header-background");
                                    ?>
                                    <input type="file" name="special-products-header-background" id="special-products-header-background" style="display:none;" onchange="read_image_file(this,'special-products-header-background_preview');" />
                                    <div class="headbgeditbtn">
                                        <span> <?php echo __("admin/settings/background-special-products"); ?></span><br/>
                                        <a class="avatarguncelle" href="javascript:void(0);" onclick="$('#special-products-header-background').click();" ><i class="fa fa-camera" aria-hidden="true"></i></a>
                                    </div>
                                    <img src="<?php echo $picture ? $picture["link"] : $tadress."images/no-image-wide.jpg"; ?>?time=<?php echo time(); ?>" width="100%" id="special-products-header-background_preview">
                                </div>

                                <div class="headerbgedit">
                                    <?php
                                        $picture = $get_picture("license","header-background");
                                    ?>
                                    <input type="file" name="license-header-background" id="license-header-background" style="display:none;" onchange="read_image_file(this,'license-header-background_preview');" />
                                    <div class="headbgeditbtn">
                                        <span> <?php echo __("admin/settings/background-license"); ?></span><br/>
                                        <a class="avatarguncelle" href="javascript:void(0);" onclick="$('#license-header-background').click();" ><i class="fa fa-camera" aria-hidden="true"></i></a>
                                    </div>
                                    <img src="<?php echo $picture ? $picture["link"] : $tadress."images/no-image-wide.jpg"; ?>?time=<?php echo time(); ?>" width="100%" id="license-header-background_preview">
                                </div>

                                <div class="headerbgedit">
                                    <?php
                                        $picture = $get_picture("404","header-background");
                                    ?>
                                    <input type="file" name="404-header-background" id="404-header-background" style="display:none;" onchange="read_image_file(this,'404-header-background_preview');" />
                                    <div class="headbgeditbtn">
                                        <span> <?php echo __("admin/settings/background-404"); ?></span><br/>
                                        <a class="avatarguncelle" href="javascript:void(0);" onclick="$('#404-header-background').click();" ><i class="fa fa-camera" aria-hidden="true"></i></a>
                                    </div>
                                    <img src="<?php echo $picture ? $picture["link"] : $tadress."images/no-image-wide.jpg"; ?>?time=<?php echo time(); ?>" width="100%" id="404-header-background_preview">
                                </div>

                                <?php if($settings["other"]["country"] == "tr"): ?>
                                    <div class="headerbgedit">
                                        <?php
                                            $picture = $get_picture("sms","header-background");
                                        ?>
                                        <input type="file" name="sms-header-background" id="sms-header-background" style="display:none;" onchange="read_image_file(this,'sms-header-background_preview');" />
                                        <div class="headbgeditbtn">
                                            <span> <?php echo __("admin/settings/background-sms"); ?></span><br/>
                                            <a class="avatarguncelle" href="javascript:void(0);" onclick="$('#sms-header-background').click();" ><i class="fa fa-camera" aria-hidden="true"></i></a>
                                        </div>
                                        <img src="<?php echo $picture ? $picture["link"] : $tadress."images/no-image-wide.jpg"; ?>?time=<?php echo time(); ?>" width="100%" id="sms-header-background_preview">
                                    </div>
                                <?php endif; ?>



                                <div class="clear"></div>

                                <div style="float:right;" class="guncellebtn yuzde30"><a id="backgrounds_submit" href="javascript:void(0);" class="yesilbtn gonderbtn"><?php echo __("admin/settings/update-button1"); ?></a></div>

                            </form>
                        </div>

                        <script type="text/javascript">
                            $(document).ready(function(){
                                $("#backgrounds_submit").on("click",function(){
                                    MioAjaxElement($(this),{
                                        waiting_text: waiting_text,
                                        progress_text: progress_text,
                                        result:"backgrounds_submit_handler",
                                    });
                                });
                            });

                            function backgrounds_submit_handler(result){
                                if(result != ''){
                                    var solve = getJson(result);
                                    if(solve !== false){
                                        if(solve.status == "error"){
                                            if(solve.for != undefined && solve.for != ''){
                                                $("#backgroundsForm "+solve.for).focus();
                                                $("#backgroundsForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                                $("#backgroundsForm "+solve.for).change(function(){
                                                    $(this).removeAttr("style");
                                                });
                                            }
                                            if(solve.message != undefined && solve.message != '')
                                                alert_error(solve.message,{timer:5000});
                                        }else if(solve.status == "successful"){
                                            if(solve.redirect != undefined){
                                                setTimeout(function(){
                                                    window.location.href = solve.redirect;
                                                },2000);
                                            }
                                            alert_success(solve.message,{timer:2000});
                                        }
                                    }else
                                        console.log(result);
                                }
                            }
                        </script>

                        <div class="clear"></div>
                    </div><!-- tab content end -->
                <?php endif; ?>

                <?php if($homeConfigure): ?>
                    <div id="group-home" class="tabcontent"><!-- tab start -->

                        <script type="text/javascript">
                            $(function(){

                                var tab = _GET("blocksl");
                                if(tab != '' && tab != undefined){
                                    $("#tab-blocksl .tablinks[data-tab='"+tab+"']").click();
                                }else{
                                    $("#tab-blocksl .tablinks:eq(0)").addClass("active");
                                    $("#tab-blocksl .tabcontent:eq(0)").css("display","block");
                                }

                                var sortable = ".blocks";
                                $(sortable).sortable({
                                    handle: ".bearer",
                                    placeholder: "mio-state-highlight",
                                    update: function(event, ui) {
                                        var lang = $(ui.item[0]).attr("data-lang");
                                        var ranking = $("#blocksl-"+lang+" input.blocks-ranking").map(function(){return $(this).val();}).get();
                                        console.log(ranking);
                                        var result = MioAjax({
                                            action:"<?php echo $links["controller"]; ?>",
                                            method:"POST",
                                            data:{
                                                lang:lang,
                                                operation:"update_blocks_ranking",
                                                ranking:ranking,
                                            },
                                        },true);
                                        if(result != ''){
                                            var solve = getJson(result);
                                            if(solve !== false){
                                                if(solve.status == "error"){
                                                    if(solve.message != undefined && solve.message != '')
                                                        alert_error(solve.message,{timer:5000});
                                                }else if(solve.status == "successful"){
                                                    //alert_success(solve.message,{timer:3000});
                                                }
                                            }else
                                                console.log(result);
                                        }
                                    },
                                }).disableSelection();

                                $(".blocks-status-trigger").change(function(){
                                    var lang = $(this).attr("data-lang");
                                    var situations = $("#blocksl-"+lang+" input.blocks-status-trigger:checked").map(function(){return $(this).val();}).get();
                                    var result = MioAjax({
                                        action:"<?php echo $links["controller"]; ?>",
                                        method:"POST",
                                        data:{
                                            lang:lang,
                                            operation:"update_blocks_status",
                                            situations:situations,
                                        },
                                    },true);
                                    if(result != ''){
                                        var solve = getJson(result);
                                        if(solve !== false){
                                            if(solve.status == "error"){
                                                if(solve.message != undefined && solve.message != '')
                                                    alert_error(solve.message,{timer:5000});
                                            }else if(solve.status == "successful"){
                                                //alert_success(solve.message,{timer:3000});
                                            }
                                        }else
                                            console.log(result);
                                    }
                                });

                            });
                        </script>

                        <div id="tab-blocksl">

                            <div style="margin:15px;">
                                <div class="green-info">
                                    <div class="padding15">
                                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                                        <p> <?php echo __("admin/settings/blocks-info"); ?> </p>
                                    </div>
                                </div>
                            </div>

                            <ul class="tab">
                                <?php
                                    foreach($lang_list AS $lang){
                                        $lkey = $lang["key"];
                                        ?>
                                        <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, '<?php echo $lang["key"]; ?>','blocksl')" data-tab="<?php echo $lang["key"]; ?>"> <?php echo strtoupper($lkey); ?></a></li>
                                        <?php
                                    }
                                ?>
                            </ul>

                            <?php
                                $blocks_modal = [];
                                foreach ($lang_list AS $lang){
                                    $lkey = $lang["key"];
                                    ?>
                                    <div id="blocksl-<?php echo $lkey; ?>" class="tabcontent">
                                        <div class="adminuyedetay">
                                            <ul class="blocks">
                                                <?php
                                                    $blocks     = ___("blocks",false,$lkey);
                                                    $pgroups    = isset($settings["block"]["product_groups"][$lkey]) ? $settings["block"]["product_groups"][$lkey] : false;
                                                    if($pgroups){
                                                        foreach($pgroups AS $group){
                                                            if(!isset($blocks["product-group__".$group["id"]])){
                                                                $blocks["product-group__".$group["id"]] = [
                                                                    'status' => 0,
                                                                    'owner' => "product-group",
                                                                    'id'    => $group["id"],
                                                                    'title' => NULL,
                                                                    'description' => NULL,
                                                                    'items' => [],
                                                                    'pic_id' => 0,
                                                                    'listing_limit' => NULL,
                                                                ];
                                                            }
                                                        }
                                                    }

                                                    foreach($blocks AS $key=>$block){
                                                        $name = false;

                                                        if($key == "home-domain-check" && !$settings["options"]["pg-activation"]["domain"])
                                                            continue;

                                                        if($key == "home-softwares" && !$settings["options"]["pg-activation"]["software"])
                                                            continue;

                                                        if(isset($block["owner"])){
                                                            $owner      = $block["owner"];
                                                            $id         = $block["id"];
                                                            if($owner == "product-group"){
                                                                if(isset($pgroups[$id]))
                                                                    $name        = $pgroups[$id]["title"];
                                                                else continue;
                                                            }
                                                            if($owner == "hosting" && !$settings["options"]["pg-activation"]["hosting"])
                                                                continue;

                                                            if($owner == "server" && !$settings["options"]["pg-activation"]["server"])
                                                                continue;

                                                            if($owner == "sms" && !$settings["options"]["pg-activation"]["sms"])
                                                                continue;

                                                            if($settings["other"]["country"] != "tr" && $owner == "sms")
                                                                continue;

                                                        }else
                                                            $owner      = false;
                                                        if(!$name) $name       = __("admin/settings/block-".$key);
                                                        $status         = $block["status"];

                                                        if(!$name) $name = $key;
                                                        $block["key"] = $key;
                                                        $block["lang"] = $lkey;
                                                        $blocks_modal[$lkey."_".$key] = $block;
                                                        $set_opt = true;
                                                        ?>
                                                        <li data-lang="<?php echo $lkey; ?>">
                                                            <input type="hidden" class="blocks-ranking" value="<?php echo $key; ?>">
                                                            <div class="yuzde70" >
                                                                <strong><?php echo $name; ?></strong>
                                                            </div>

                                                            <div class="yuzde10">
                                                                <input type="checkbox" data-lang="<?php echo $lkey; ?>" value="<?php echo $key; ?>" <?php echo $status ? ' checked' : NULL; ?> id="<?php echo $lkey."_".$key; ?>-status" class="blocks-status-trigger sitemio-checkbox">
                                                                <label for="<?php echo $lkey."_".$key; ?>-status" class="sitemio-checkbox-label"></label>
                                                            </div>
                                                            <div class="yuzde20" style="text-align: right;">
                                                                <?php if(isset($set_opt) && $set_opt): ?>
                                                                    <?php if($key == "home-domain-check"): ?>
                                                                        <a class="lbtn" href="<?php echo Controllers::$init->AdminCRLink("products-2",["domain","settings"]); ?>" target="_blank"><?php echo __("admin/settings/set-options"); ?></a>
                                                                    <?php else: ?>
                                                                        <a class="lbtn" href="javascript:open_modal('block_options_<?php echo $lkey."_".$key; ?>',{title:'<?php echo $name; ?>'});void 0;"><?php echo __("admin/settings/set-options"); ?></a>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                                <a class="lbtn bearer" style="cursor: move;"> <i class="fa fa-arrows-alt"></i> </a>
                                                            </div>
                                                        </li>
                                                        <?php
                                                    }
                                                ?>
                                            </ul>
                                        </div>

                                    </div>
                                    <?php
                                }
                            ?>
                        </div>

                    </div><!-- tab content end -->
                <?php endif; ?>

                <div id="group-other" class="tabcontent">
                    <div class="adminpagecon">

                        <form action="<?php echo $links["controller"]; ?>" method="post" enctype="multipart/form-data" id="form2">
                            <input type="hidden" name="operation" value="update_theme_other_settings">

                            <div class="formcon">
                                <div class="yuzde30">Only Client Panel</div>
                                <div class="yuzde70">
                                    <input <?php echo $settings["theme"]["onlyPanel"] ? 'checked ' : NULL; ?>type="checkbox" class="sitemio-checkbox" name="only-panel" value="1" id="only-panel">
                                    <label class="sitemio-checkbox-label" for="only-panel"></label>
                                    <span class="kinfo"><?php echo __("admin/settings/only-panel-desc"); ?></span>
                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/settings/client-index-show-products"); ?></div>
                                <div class="yuzde70">
                                    <input type="checkbox" class="sitemio-checkbox" id="ctixswps" name="ctixswps" value="1"<?php echo $settings["options"]["ctixswps"] ? ' checked' : NULL; ?>>
                                    <label class="sitemio-checkbox-label" for="ctixswps"></label>
                                    <span class="kinfo"><?php echo __("admin/settings/client-index-show-products-desc"); ?></span>
                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/settings/maintenance-mode"); ?></div>
                                <div class="yuzde70">
                                    <input <?php echo $settings["theme"]["maintenance_mode"] ? 'checked ' : NULL; ?>type="checkbox" class="sitemio-checkbox" name="maintenance-mode" value="1" id="maintenance-mode">
                                    <label class="sitemio-checkbox-label" for="maintenance-mode"></label>
                                    <span class="kinfo"><?php echo __("admin/settings/maintenance-mode-desc"); ?></span>
                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/settings/padeno"); ?></div>
                                <div class="yuzde70">
                                    <input <?php echo $settings["theme"]["padeno"] ? 'checked ' : NULL; ?>type="checkbox" class="sitemio-checkbox" name="padeno" value="1" id="padeno">
                                    <label class="sitemio-checkbox-label" for="padeno"></label>
                                    <span class="kinfo"><?php echo __("admin/settings/padeno-desc"); ?></span>
                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/settings/padenews"); ?></div>
                                <div class="yuzde70">
                                    <input <?php echo $settings["theme"]["padenews"] ? 'checked ' : NULL; ?>type="checkbox" class="sitemio-checkbox" name="padenews" value="1" id="padenews">
                                    <label class="sitemio-checkbox-label" for="padenews"></label>
                                    <span class="kinfo"><?php echo __("admin/settings/padenews-desc"); ?></span>
                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/settings/padeart"); ?></div>
                                <div class="yuzde70">
                                    <input <?php echo $settings["theme"]["padeart"] ? 'checked ' : NULL; ?>type="checkbox" class="sitemio-checkbox" name="padeart" value="1" id="padeart">
                                    <label class="sitemio-checkbox-label" for="padeart"></label>
                                    <span class="kinfo"><?php echo __("admin/settings/padeart-desc"); ?></span>
                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/settings/padekbs"); ?></div>
                                <div class="yuzde70">
                                    <input <?php echo $settings["theme"]["padekbs"] ? 'checked ' : NULL; ?>type="checkbox" class="sitemio-checkbox" name="padekbs" value="1" id="padekbs">
                                    <label class="sitemio-checkbox-label" for="padekbs"></label>
                                    <span class="kinfo"><?php echo __("admin/settings/padekbs-desc"); ?></span>
                                </div>
                            </div>

                            <div style="float:right;" class="guncellebtn yuzde30"><a id="submit2" href="javascript:void(0);" class="yesilbtn gonderbtn"><?php echo __("admin/settings/update-button1"); ?></a></div>

                        </form>


                    </div>


                    <div class="clear"></div>
                </div>


            </div>


        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

<?php
    if(isset($blocks_modal) && $blocks_modal){
        $picfunc        = $functions["get_block_picture"];
        $getSoftware    = $functions["get_software"];
        $getCategory     = $functions["get_product_group_category"];
        foreach($blocks_modal AS $modal_id=>$block){
            $def_picture    = $picfunc(0);
            if(isset($block["pic_id"])){
                $picture        = $picfunc($block["pic_id"]);
            }else
                $picture = $def_picture;
            if(!isset($block["owner"])) $block["owner"] = false;
            ?>
            <div id="block_options_<?php echo $modal_id; ?>" style="display: none;">
                <script type="text/javascript">
                    var doneTheStuff;
                    $(function(){
                        var $div = $("#block_options_<?php echo $modal_id; ?>");
                        var observer = new MutationObserver(function(mutations) {
                            mutations.forEach(function(mutation) {
                                if (mutation.attributeName === "class") {
                                    var attributeValue = $(mutation.target).prop(mutation.attributeName);
                                    if(attributeValue.search("iziModal transitionIn")>-1){
                                        if (!doneTheStuff) {
                                            doneTheStuff = true;
                                        }
                                    }
                                }
                            });
                        });
                        observer.observe($div[0], {
                            attributes: true
                        });
                    });
                </script>
                <div class="padding20">

                    <form action="<?php echo $links["controller"]; ?>" method="post" enctype="multipart/form-data" id="block_options_<?php echo $modal_id; ?>_form">
                        <input type="hidden" name="operation" value="update_block_options">
                        <input type="hidden" name="lang" value="<?php echo $block["lang"]; ?>">
                        <input type="hidden" name="key" value="<?php echo $block["key"]; ?>">


                        <?php if($block["key"] == "about-us" || $block["key"] == "features" || $block["key"] == "statistics-by-numbers" || $block["key"] == "customer-feedback" || $block["key"] == "home-softwares" || $block["key"] == "group-hosting" || $block["key"] == "group-server" || $block["key"] == "group-sms" || $block["owner"] == "product-group"): ?>
                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/settings/block-form-slogan"); ?></div>
                                <div class="yuzde70">
                                    <input name="title" type="text" placeholder="" value="<?php echo $block["title"]; ?>">
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if($block["key"] == "about-us" || $block["key"] == "statistics-by-numbers" || $block["key"] == "customer-feedback" || $block["key"] == "home-softwares" || $block["key"] == "group-hosting" || $block["key"] == "group-server" || $block["key"] == "group-sms" || $block["owner"] == "product-group"): ?>
                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/settings/block-form-description"); ?></div>
                                <div class="yuzde70">
                                    <textarea rows="2" name="description" placeholder=""><?php echo $block["description"]; ?></textarea>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if($block["key"] == "about-us" || $block["key"] == "features" || $block["key"] == "news-articles" || $block["key"] == "home-softwares" || $block["key"] == "group-hosting" || $block["key"] == "group-server" || $block["key"] == "group-sms" || $block["owner"] == "product-group"): ?>
                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/settings/block-form-background-image"); ?></div>
                                <div class="yuzde70">
                                    <input type="file" name="picture" onchange="read_image_file(this,'<?php echo $modal_id."_picture"; ?>');"><br>
                                    <img width="235" src="<?php echo $picture; ?>" id="<?php echo $modal_id."_picture"; ?>">
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if($block["key"] == "about-us"): ?>
                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/settings/block-form-background-video"); ?></div>
                                <div class="yuzde70">
                                    <input type="file" name="video"><br>
                                    <?php
                                        if(isset($block["video"]) && $block["video"]){
                                            $video_file = Config::get("pictures/blocks/folder").$block["video"];
                                            $video_file = Utility::link_determiner($video_file,false,false);
                                            ?>
                                            <div class="clear" style="margin-top:5px;"></div>
                                            <a id="block_background_video_play_<?php echo $block["lang"]; ?>_<?php echo $block["key"]; ?>" target="_blank" href="<?php echo $video_file; ?>" class="blue sbtn" data-tooltip="<?php echo ___("needs/view"); ?>"><i class="fa fa-play"></i></a>
                                            <a id="block_background_video_remove_<?php echo $block["lang"]; ?>_<?php echo $block["key"]; ?>" href="javascript:delete_background_video('<?php echo $block["lang"]; ?>','<?php echo $block["key"]; ?>');void 0;" class="red sbtn" data-tooltip="<?php echo ___("needs/button-delete"); ?>"><i class="fa fa-trash-o"></i></a>
                                            <?php
                                        }
                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>


                        <?php if($block["owner"] == "product-group" || $block["key"] == "group-hosting" || $block["key"] == "group-server" || $block["key"] == "group-sms"): ?>


                            <?php if($block["owner"] == "hosting" || $block["owner"] == "server"): ?>
                            <script type="text/javascript">
                                var get_categories_<?php echo $block["owner"]; ?> = false;
                                $(document).ready(function(){

                                    if(doneTheStuff){
                                        var select2_element = $('.get-categories-<?php echo $block["owner"]; ?>');
                                        if(get_categories_<?php echo $block["owner"]; ?>){
                                            select2_element.select2("destroy").next('.select2-container').remove();
                                            get_categories_<?php echo $block["owner"]; ?> = false;
                                        }

                                        if(!get_categories_<?php echo $block["owner"]; ?>){
                                            select2_element.select2({
                                                ajax: {
                                                    url: '<?php echo $links["get-group-categories-json"]; ?>',
                                                    data: function (params) {
                                                        var query = {
                                                            id: "<?php echo $block["owner"]; ?>",
                                                            lang: "<?php echo $block["lang"]; ?>",
                                                            type: 'public'
                                                        };
                                                        return query;
                                                    }
                                                }
                                            });
                                            select2_sortable(select2_element);
                                            get_categories_<?php echo $block["owner"]; ?> = true;
                                        }
                                    }
                                });
                            </script>
                        <?php endif; ?>

                        <?php if($block["owner"] == "product-group"): ?>
                            <script type="text/javascript">
                                var get_categories_<?php echo $block["id"]; ?> = false;
                                $(document).ready(function(){
                                    if(doneTheStuff){
                                        var select2_element = $('.get-categories-<?php echo $block["id"]; ?>');
                                        if(get_categories_<?php echo $block["id"]; ?>){
                                            select2_element.select2("destroy").next('.select2-container').remove();
                                            get_categories_<?php echo $block["id"]; ?> = false;
                                        }

                                        if(!get_categories_<?php echo $block["id"]; ?>){
                                            select2_element.select2({
                                                ajax: {
                                                    url: '<?php echo $links["get-group-categories-json"]; ?>',
                                                    data: function (params) {
                                                        var query = {
                                                            id: "<?php echo $block["id"]; ?>",
                                                            lang: "<?php echo $block["lang"]; ?>",
                                                            type: 'public'
                                                        };
                                                        return query;
                                                    }
                                                }
                                            });
                                            select2_sortable(select2_element);
                                            get_categories_<?php echo $block["id"]; ?> = true;
                                        }
                                    }
                                });
                            </script>
                        <?php endif; ?>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/settings/block-form-listing-limit"); ?></div>
                                <div class="yuzde70">
                                    <input type="text" name="listing_limit" placeholder="" value="<?php echo $block["listing_limit"]; ?>">
                                </div>
                            </div>

                        <?php if($block["owner"] == "hosting" || $block["owner"] == "server" || $block["owner"] == "product-group"): ?>
                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/settings/block-form-categories"); ?></div>
                                <div class="yuzde70">
                                    <select name="items[]" class="get-categories-<?php echo $block["owner"] == "hosting" || $block["owner"] == "server" ? $block["owner"] : $block["id"]; ?>" multiple>
                                        <?php
                                            if(isset($block["items"]) && is_array($block["items"])){
                                                foreach($block["items"] AS $item){
                                                    $cat    = $getCategory($item,$block["lang"]);
                                                    if($cat){
                                                        $name = $cat->title;
                                                        ?>
                                                        <option value="<?php echo $item; ?>" selected><?php echo $name; ?></option>
                                                        <?php
                                                    }
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        <?php endif; ?>


                        <?php endif; ?>

                        <?php if($block["key"] == "home-softwares"): ?>
                            <script type="text/javascript">
                                $(function() {
                                    if(window.doneTheStuff) {
                                        var select2_element = $('#get-softwares-con-<?php echo $block["lang"]; ?> .get-softwares');

                                        select2_element.select2({
                                            ajax: {
                                                url: '<?php echo $links["get-softwares-json"]; ?>',
                                                data: function (params) {
                                                    var query = {
                                                        lang: "<?php echo $block["lang"]; ?>",
                                                        search: params.term,
                                                        type: 'public'
                                                    };
                                                    return query;
                                                }
                                            }
                                        });
                                        select2_sortable(select2_element);

                                        $('#get-softwares-con-<?php echo $block["lang"]; ?> .select2-container').slice(1).remove();

                                    }
                                });
                            </script>
                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/settings/block-form-software-items"); ?></div>
                                <div class="yuzde70" id="get-softwares-con-<?php echo $block["lang"]; ?>">
                                    <select name="items[]" class="get-softwares" multiple>
                                        <?php
                                            if(isset($block["items"]) && is_array($block["items"])){
                                                foreach($block["items"] AS $item){
                                                    $software   = $getSoftware($item,$block["lang"]);
                                                    if($software){
                                                        $name = $software->title;
                                                        ?>
                                                        <option value="<?php echo $item; ?>" selected><?php echo $name; ?></option>
                                                        <?php
                                                    }
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if($block["key"] == "customer-feedback"): ?>
                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/settings/block-form-send-opinion"); ?></div>
                                <div class="yuzde70">
                                    <input type="checkbox" name="send-opinion" value="1" class="sitemio-checkbox" id="block_options_<?php echo $modal_id; ?>_send-opinion"<?php echo $block["send-opinion"] ? ' checked' : NULL; ?>>
                                    <label class="sitemio-checkbox-label" for="block_options_<?php echo $modal_id; ?>_send-opinion"></label>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if($block["key"] == "news-articles"): ?>
                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/settings/block-form-news-status"); ?></div>
                                <div class="yuzde70">
                                    <input type="checkbox" name="news" value="1" class="sitemio-checkbox" id="block_options_<?php echo $modal_id; ?>_news"<?php echo $block["news"] ? ' checked' : NULL; ?>>
                                    <label class="sitemio-checkbox-label" for="block_options_<?php echo $modal_id; ?>_news"></label>
                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/settings/block-form-articles-status"); ?></div>
                                <div class="yuzde70">
                                    <input type="checkbox" name="articles" value="1" class="sitemio-checkbox" id="block_options_<?php echo $modal_id; ?>_articles"<?php echo $block["articles"] ? ' checked' : NULL; ?>>
                                    <label class="sitemio-checkbox-label" for="block_options_<?php echo $modal_id; ?>_articles"></label>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if($block["key"] == "about-us"): ?>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/settings/block-form-button-name"); ?></div>
                                <div class="yuzde70">
                                    <input name="button_name" type="text" placeholder="" value="<?php echo $block["button_name"]; ?>">
                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/settings/block-form-button-link"); ?></div>
                                <div class="yuzde70">
                                    <input name="button_link" type="text" placeholder="" value="<?php echo $block["button_link"]; ?>">
                                </div>
                            </div>

                        <?php endif; ?>

                        <?php if($block["key"] == "features"): ?>
                            <script type="text/javascript">
                                $(function(){

                                    if(window.doneTheStuff){
                                        $("#<?php echo $modal_id;?>_items").sortable({
                                            placeholder: "mio-state-highlight",
                                            connectWith: "ul",
                                        }).disableSelection();
                                    }

                                    $("#block_options_<?php echo $modal_id; ?> .add-new-block-feature").click(function(){
                                        var template = $("#block_options_<?php echo $modal_id; ?> .sortable-item-template").html();
                                        var el = $("#<?php echo $modal_id;?>_items").append(template);
                                        $("#<?php echo $modal_id;?>_items").sortable( "refresh");

                                    });

                                    $("#block_options_<?php echo $modal_id; ?>").on("click",".delete-sortable-item",function(){
                                        $(this).parent().parent().remove();
                                    });

                                });
                            </script>
                            <div class="clear"></div>


                            <ul class="block-feature-items" id="<?php echo $modal_id;?>_items">
                                <?php
                                    if(isset($block["items"]) && $block["items"]){
                                        foreach($block["items"] AS $item){
                                            ?>
                                            <li>
                                                <div class="padding10">
                                                    <a href="javascript:void(0);" class="delete-sortable-item" style="font-size:20px;float:right;color:#CCCCCC;margin-bottom: -10px;margin-top: -10px;"><i class="fa fa-trash"></i></a>
                                                    <div class="formcon">
                                                        <div class="yuzde30"><?php echo __("admin/settings/block-feature-title"); ?></div>
                                                        <div class="yuzde70">
                                                            <input name="items[title][]" type="text" placeholder="" value="<?php echo $item["title"]; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="formcon">
                                                        <div class="yuzde30"><?php echo __("admin/settings/block-feature-description"); ?></div>
                                                        <div class="yuzde70">
                                                            <textarea rows="2" name="items[description][]" placeholder=""><?php echo $item["description"]; ?></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="formcon">
                                                        <div class="yuzde30"><?php echo __("admin/settings/block-feature-icon"); ?></div>
                                                        <div class="yuzde70">
                                                            <input type="text" name="items[icon][]" value="<?php echo $item["icon"];?>">
                                                            <span style="font-size:13px;"><?php echo ___("needs/select-icon-help"); ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="clear"></div>
                                                </div>


                                            </li>
                                            <?php
                                        }
                                    }
                                ?>
                            </ul>

                            <div class="clear"></div>
                            <a href="javascript:void(0);" class="add-new-block-feature sbtn" style="width: 100%;"> <i class="fa fa-plus"></i> </a>

                            <div class="clear"></div>
                        <?php endif; ?>


                        <?php if($block["key"] == "statistics-by-numbers"): ?>
                            <script type="text/javascript">
                                $(function(){

                                    if(window.doneTheStuff){

                                        $("#<?php echo $modal_id;?>_items").sortable({
                                            placeholder: "mio-state-highlight",
                                            connectWith: "ul",
                                        }).disableSelection();
                                    }

                                    $("#block_options_<?php echo $modal_id; ?> .add-new-block-item").click(function(){
                                        var template = $("#block_options_<?php echo $modal_id; ?> .sortable-item-template").html();
                                        var el = $("#<?php echo $modal_id;?>_items").append(template);
                                        $("#<?php echo $modal_id;?>_items").sortable( "refresh");

                                    });

                                    $("#block_options_<?php echo $modal_id; ?>").on("click",".delete-sortable-item",function(){
                                        $(this).parent().parent().remove();
                                    });

                                });
                            </script>
                            <div class="clear"></div>


                            <ul class="block-items" id="<?php echo $modal_id;?>_items">
                                <?php
                                    if(isset($block["items"]) && $block["items"]){
                                        foreach($block["items"] AS $item){
                                            ?>
                                            <li>
                                                <div class="padding10">
                                                    <a href="javascript:void(0);" class="delete-sortable-item" style="font-size:20px;float:right;color:#CCCCCC;margin-bottom: -10px;margin-top: -10px;"><i class="fa fa-trash"></i></a>
                                                    <div class="formcon">
                                                        <div class="yuzde30"><?php echo __("admin/settings/block-feature-title"); ?></div>
                                                        <div class="yuzde70">
                                                            <input name="items[title][]" type="text" placeholder="" value="<?php echo $item["title"]; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="formcon">
                                                        <div class="yuzde30"><?php echo __("admin/settings/block-item-number"); ?></div>
                                                        <div class="yuzde70">
                                                            <input type="text" name="items[number][]" placeholder="" value="<?php echo $item["number"]; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="formcon">
                                                        <div class="yuzde30"><?php echo __("admin/settings/block-feature-icon"); ?></div>
                                                        <div class="yuzde70">
                                                            <input type="text" name="items[icon][]" value="<?php echo $item["icon"];?>">
                                                            <span style="font-size:13px;"><?php echo ___("needs/select-icon-help"); ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="clear"></div>
                                                </div>


                                            </li>
                                            <?php
                                        }
                                    }
                                ?>
                            </ul>

                            <div class="clear"></div>
                            <a href="javascript:void(0);" class="add-new-block-item sbtn" style="width: 100%;"> <i class="fa fa-plus"></i> </a>

                            <div class="clear"></div>
                        <?php endif; ?>


                        <div class="mio-result error" style="float:left;margin-top: 20px;display: none;"></div>

                        <div style="float:right;" class="guncellebtn yuzde30"><a href="javascript:void(0);" class="submit-button yesilbtn gonderbtn"><?php echo __("admin/settings/update-button1"); ?></a></div>

                    </form>

                    <?php if($block["key"] == "features"): ?>
                        <div style="display: none;" class="sortable-item-template">
                            <li>
                                <div class="padding10">
                                    <a href="javascript:void(0);" class="delete-sortable-item" style="font-size:20px;float:right;color:#CCCCCC;margin-bottom: -10px;margin-top: -10px;"><i class="fa fa-trash"></i></a>
                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/settings/block-feature-title"); ?></div>
                                        <div class="yuzde70">
                                            <input name="items[title][]" type="text" placeholder="" value="">
                                        </div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/settings/block-feature-description"); ?></div>
                                        <div class="yuzde70">
                                            <textarea rows="2" name="items[description][]" placeholder=""></textarea>
                                        </div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/settings/block-feature-icon"); ?></div>
                                        <div class="yuzde70">
                                            <input type="text" name="items[icon][]" value="">
                                            <span style="font-size:13px;"><?php echo ___("needs/select-icon-help"); ?></span>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            </li>
                        </div>
                    <?php endif; ?>

                    <?php if($block["key"] == "statistics-by-numbers"): ?>
                        <div style="display: none;" class="sortable-item-template">
                            <li>
                                <div class="padding10">
                                    <a href="javascript:void(0);" class="delete-sortable-item" style="font-size:20px;float:right;color:#CCCCCC;margin-bottom: -10px;margin-top: -10px;"><i class="fa fa-trash"></i></a>
                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/settings/block-feature-title"); ?></div>
                                        <div class="yuzde70">
                                            <input name="items[title][]" type="text" placeholder="" value="">
                                        </div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/settings/block-item-number"); ?></div>
                                        <div class="yuzde70">
                                            <input type="text" name="items[number][]">
                                        </div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/settings/block-feature-icon"); ?></div>
                                        <div class="yuzde70">
                                            <input type="text" name="items[icon][]">
                                            <span style="font-size:13px;"><?php echo ___("needs/select-icon-help"); ?></span>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            </li>
                        </div>
                    <?php endif; ?>


                    <script type="text/javascript">
                        $(document).ready(function(){

                            $("#block_options_<?php echo $modal_id; ?>_form .submit-button").on("click",function(){
                                MioAjaxElement($(this),{
                                    waiting_text: waiting_text,
                                    progress_text: progress_text,
                                    result:"block_options_<?php echo str_replace("-","_",$modal_id); ?>_handler",
                                });
                            });
                        });

                        function block_options_<?php echo str_replace("-","_",$modal_id); ?>_handler(result){
                            if(result != ''){
                                var solve = getJson(result);
                                if(solve !== false){
                                    if(solve.status == "error"){
                                        if(solve.for != undefined && solve.for != ''){
                                            $("#block_options_<?php echo $modal_id; ?>_form "+solve.for).focus();
                                            $("#block_options_<?php echo $modal_id; ?>_form "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                            $("#block_options_<?php echo $modal_id; ?>_form "+solve.for).change(function(){
                                                $(this).removeAttr("style");
                                            });
                                        }
                                        if(solve.message != undefined && solve.message != '')
                                            $("#block_options_<?php echo $modal_id; ?>_form .mio-result").fadeIn(200).html(solve.message);
                                    }else if(solve.status == "successful"){
                                        $("#block_options_<?php echo $modal_id; ?>_form .mio-result").fadeOut(200).html('');
                                        window.location.href = location.href;
                                        alert_success(solve.message,{timer:2000});
                                    }
                                }else
                                    console.log(result);
                            }
                        }
                    </script>

                    <div class="clear"></div>

                </div>
            </div>
            <?php
        }
    }
?>

</body>
</html>