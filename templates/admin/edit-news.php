<!DOCTYPE html>
<html>
<head>
    <?php
        $status         = $page["status"];
        $categoryy      = $page["category"];
        $visibility     = $page["visibility"] == "visible" ? 1 : 0;
        $visible_to_user= $page["visible_to_user"];
        $sidebar        = $page["sidebar"] == "disable" ? 1 : 0;
        $options        = $page["options"] ? Utility::jdecode($page["options"],true) : [];
        $hide_comments  = isset($options["hide_comments"]) ? $options["hide_comments"] : false;

        if(!$getHeaderBackground) $getHeaderBackground = $getHeaderBackgroundDeft;
        if(!$getListImage) $getListImage = $getListImageDeft;

        Utility::sksort($lang_list,"local");
        $plugins    = ['jquery-ui','tinymce-1'];
        include __DIR__.DS."inc".DS."head.php";
    ?>

    <script type="text/javascript">
        $(document).ready(function(){

            var tab2 = _GET("lang");
            if (tab2 != '' && tab2 != undefined) {
                $("#tab-lang .tablinks[data-tab='" + tab2 + "']").click();
            } else {
                $("#tab-lang .tablinks:eq(0)").addClass("active");
                $("#tab-lang .tabcontent:eq(0)").css("display", "block");
            }

            $("#editForm_submit").on("click",function(){
                MioAjaxElement($(this),{
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                    result:"editForm_handler",
                });
            });

        });

        function editForm_handler(result){
            if(result != ''){
                var solve = getJson(result);
                if(solve !== false){
                    if(solve.status == "error"){
                        if(solve.for != undefined && solve.for != ''){
                            $("#editForm "+solve.for).focus();
                            $("#editForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                            $("#editForm "+solve.for).change(function(){
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

        function hbackground_delete(){
            $("#hbackground").val('');
            $("#hbackground_preview").attr("src","<?php echo $getHeaderBackgroundDeft; ?>");

            var request = MioAjax({
                action:"<?php echo $links["controller"]; ?>",
                method:"POST",
                data:{operation:"delete_page_hbackground"}
            },true,true);

            request.done(function(result){
                if(result != ''){
                    var solve = getJson(result);
                    if(solve !== false){
                        if(solve.status == "successful"){
                            alert_success(solve.message,{timer:2000});
                        }
                    }else
                        console.log(result);
                }
            });
        }

        function listimg_delete(){
            $("#list_image").val('');
            $("#list_image_preview").attr("src","<?php echo $getListImageDeft; ?>");

            var request = MioAjax({
                action:"<?php echo $links["controller"]; ?>",
                method:"POST",
                data:{operation:"delete_page_cover"}
            },true,true);

            request.done(function(result){
                if(result != ''){
                    var solve = getJson(result);
                    if(solve !== false){
                        if(solve.status == "successful"){
                            alert_success(solve.message,{timer:2000});
                        }
                    }else
                        console.log(result);
                }
            });
        }

        function check_route(lang,wrap_hidden){
            var operation   = $("input[name='operation']").val();
            var value       = $("input[name='route["+lang+"]']").val();
            var request     = MioAjax({
                action:"<?php echo $links["controller"]; ?>",
                method:"GET",
                data:{
                    operation:operation,
                    slug:value,
                    lang:lang,
                }
            },true,true);
            request.done(function(result){
                if(result != ''){
                    var solve = getJson(result);
                    if(solve !== false){
                        if(solve.status == "successful"){
                            if(wrap_hidden) $("#permalink-wrap-"+lang).slideUp(200);
                            $("#permalink-wrap-"+lang+" .warning-container").css("display","none");
                            $("#permalink-wrap-"+lang+" .warning-container-text").html('');
                        }else{
                            $("#permalink-wrap-"+lang+" .warning-container").css("display","block");
                            $("#permalink-wrap-"+lang+" .warning-container-text").html(solve.message);
                            $("#permalink-wrap-"+lang).slideDown(200);
                        }
                    }else
                        console.log(result);
                }
            });
        }
    </script>

</head>
<body>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1><strong><?php echo __("admin/manage-website/page-news-edit",['{title}' => $page["title"]]); ?></strong></h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="clear"></div>

            <form action="<?php echo $links["controller"]; ?>" method="post" id="editForm" style="margin-top: 5px;">
                <input type="hidden" name="operation" value="edit_news_page">

                <div id="tab-lang"><!-- tab wrap content start -->
                    <ul class="tab">
                        <?php
                            foreach($lang_list AS $lang){
                                ?>
                                <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, '<?php echo $lang["key"]; ?>','lang')" data-tab="<?php echo $lang["key"]; ?>"> <?php echo strtoupper($lang["key"]); ?></a></li>
                                <?php
                            }
                        ?>
                    </ul>

                    <?php
                        $get_pagel = $functions["get_page_with_lang"];
                        foreach($lang_list AS $lang) {
                            $lkey = $lang["key"];
                            $pagel      = $get_pagel($lkey);
                            if(!$pagel) $pagel = [];
                            $title      = isset($pagel["title"]) ? $pagel["title"] : false;
                            $route      = isset($pagel["route"]) ? $pagel["route"] : false;
                            $optionsl   = isset($pagel["options"]) ? Utility::jdecode($pagel["options"],true) : [];
                            $content    = isset($pagel["content"]) ? $pagel["content"] : false;
                            $seo_title  = isset($pagel["seo_title"]) ? $pagel["seo_title"] : false;
                            $seo_keywords  = isset($pagel["seo_keywords"]) ? $pagel["seo_keywords"] : false;
                            $seo_description  = isset($pagel["seo_description"]) ? $pagel["seo_description"] : false;
                            ?>
                            <div id="lang-<?php echo $lkey; ?>" class="tabcontent">

                                <div class="adminpageconxx">

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/manage-website/create-title"); ?></div>
                                        <div class="yuzde70">
                                            <input name="title[<?php echo $lkey; ?>]" type="text" onchange="check_route('<?php echo $lkey; ?>',true);" onkeyup="$('input[name=\'route[<?php echo $lkey; ?>]\']').val(convertToSlug(this.value));" value="<?php echo $title; ?>">
                                        </div>
                                    </div>

                                    <?php if(___("package/permalink",false,$lkey)): ?>
                                        <div class="formcon" id="permalink-wrap-<?php echo $lkey; ?>" style="display: none;">
                                            <div class="yuzde30"><?php echo __("admin/manage-website/permalink"); ?></div>
                                            <div class="yuzde70">
                                                <span class="kinfo warning-container" style="display: none;color:red;">
                                                    <span class="warning-container-text"></span>
                                                </span>
                                                <input value="<?php echo $route; ?>" onchange="this.value = convertToSlug(this.value),check_route('<?php echo $lkey; ?>');" name="route[<?php echo $lkey; ?>]" type="text" placeholder="">
                                            </div>
                                        </div>
                                    <?php endif; ?>


                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/manage-website/create-content"); ?></div>
                                        <div class="yuzde70">
                                            <textarea class="tinymce-1" name="content[<?php echo $lkey; ?>]" rows="3" placeholder=""><?php echo $content; ?></textarea>
                                        </div>
                                    </div>

                                    <?php if($lang["local"]): ?>

                                        <!--<div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/manage-website/create-category"); ?></div>
                                            <div class="yuzde70">
                                                <select name="category" size="10">
                                                    <option value="0" selected><?php echo ___("needs/none"); ?></option>
                                                    <?php
                                            if(isset($categories) && $categories){
                                                foreach($categories AS $category){
                                                    ?>
                                                                <option<?php echo $category["id"] == $categoryy ? ' selected' : ''; ?> value="<?php echo $category["id"]; ?>"><?php echo $category["title"]; ?></option>
                                                                <?php
                                                }
                                            }
                                        ?>
                                                </select>
                                            </div>
                                        </div>-->

                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/manage-website/create-status"); ?></div>
                                            <div class="yuzde70">
                                                <select name="status">
                                                    <option<?php echo $status == "active" ? ' selected' : ''; ?> value="active"><?php echo __("admin/manage-website/situations/active"); ?></option>
                                                    <option<?php echo $status == "inactive" ? ' selected' : ''; ?> value="inactive"><?php echo __("admin/manage-website/situations/inactive"); ?></option>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/manage-website/create-visible-general"); ?></div>
                                            <div class="yuzde70">

                                                <input<?php echo $visibility ? ' checked' : ''; ?> id="visibility" type="checkbox" name="visibility" value="1" class="sitemio-checkbox">
                                                <label for="visibility" class="sitemio-checkbox-label"></label>
                                                <span class="kinfo"><?php echo __("admin/manage-website/create-visible-general-info"); ?></span>

                                            </div>
                                        </div>

                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/manage-website/create-visible-to-user"); ?></div>
                                            <div class="yuzde70">

                                                <input<?php echo $visible_to_user ? ' checked' : ''; ?> id="visible_to_user" type="checkbox" name="visible_to_user" value="1" class="sitemio-checkbox">
                                                <label for="visible_to_user" class="sitemio-checkbox-label"></label>
                                                <span class="kinfo"><?php echo __("admin/manage-website/create-visible-to-user-info"); ?></span>

                                            </div>
                                        </div>

                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/manage-website/create-hide-comments"); ?></div>
                                            <div class="yuzde70">

                                                <input<?php echo $hide_comments ? ' checked' : ''; ?> id="hide_comments" type="checkbox" name="hide_comments" value="1" class="sitemio-checkbox">
                                                <label for="hide_comments" class="sitemio-checkbox-label"></label>
                                                <span class="kinfo"><?php echo __("admin/manage-website/create-hide-comments-info"); ?></span>

                                            </div>
                                        </div>

                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/manage-website/create-sidebar"); ?></div>
                                            <div class="yuzde70">

                                                <input<?php echo $sidebar ? ' checked' : ''; ?> id="sidebar" type="checkbox" name="sidebar" value="1" class="sitemio-checkbox">
                                                <label for="sidebar" class="sitemio-checkbox-label"></label>
                                                <span class="kinfo"><?php echo __("admin/manage-website/create-sidebar-info"); ?></span>

                                            </div>
                                        </div>

                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/manage-website/header-background"); ?>
                                                <br><span class="kinfo"><?php echo __("admin/manage-website/header-background-desc"); ?></span>
                                            </div>
                                            <div class="yuzde70">
                                                <div class="headerbgedit">
                                                    <input type="file" name="hbackground" id="hbackground" style="display:none;" onchange="read_image_file(this,'hbackground_preview');" data-default-image="<?php echo $getHeaderBackgroundDeft; ?>" />
                                                    <div class="headbgeditbtn">
                                                        <a href="javascript:hbackground_delete();void 0;" class="photosil"><i class="fa fa-trash"></i></a><br/>
                                                        <a class="avatarguncelle" href="javascript:void(0);" onclick="$('#hbackground').click();" ><i class="fa fa-camera" aria-hidden="true"></i></a>
                                                    </div>
                                                    <img src="<?php echo $getHeaderBackground; ?>" width="100%" id="hbackground_preview">
                                                </div>

                                            </div>
                                        </div>


                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/manage-website/create-list-image"); ?>
                                                <div class="clear"></div>
                                                <span class="kinfo"><?php echo __("admin/manage-website/create-list-image-desc"); ?></span>
                                            </div>

                                            <div class="yuzde70">
                                                <div class="headerbgedit">
                                                    <input type="file" name="list_image" id="list_image" style="display:none;" onchange="read_image_file(this,'list_image_preview');" data-default-image="<?php echo $getHeaderBackgroundDeft; ?>" />
                                                    <div class="headbgeditbtn">
                                                        <a href="javascript:listimg_delete();void 0;" class="photosil"><i class="fa fa-trash"></i></a><br/>
                                                        <a class="avatarguncelle" href="javascript:void(0);" onclick="$('#list_image').click();" ><i class="fa fa-camera" aria-hidden="true"></i></a>
                                                    </div>
                                                    <img src="<?php echo $getListImage; ?>" width="100%" id="list_image_preview">
                                                </div>
                                            </div>
                                        </div>

                                    <?php endif; ?>

                                    <div class="clear"></div>
                                    <br>

                                    <div class="formcon">
                                        <div class="blue-info">
                                            <div class="padding15">
                                                <?php echo __("admin/manage-website/seo-desc"); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/manage-website/seo-title"); ?></div>
                                        <div class="yuzde70">
                                            <input name="seo_title[<?php echo $lkey; ?>]" type="text" placeholder="<?php echo __("admin/manage-website/seo-title-ex"); ?>" value="<?php echo $seo_title; ?>">
                                            <br><span class="kinfo"><?php echo __("admin/manage-website/seo-title-desc"); ?></span>
                                        </div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/manage-website/seo-description"); ?></div>
                                        <div class="yuzde70">
                                            <textarea name="seo_description[<?php echo $lkey; ?>]" cols="" rows="2" placeholder="<?php echo __("admin/manage-website/seo-description-ex"); ?>"><?php echo $seo_description; ?></textarea>
                                            <br><span class="kinfo"><?php echo __("admin/manage-website/seo-description-desc"); ?></span>
                                        </div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/manage-website/seo-keywords"); ?></div>
                                        <div class="yuzde70">
                                            <input name="seo_keywords[<?php echo $lkey; ?>]" type="text" placeholder="<?php echo __("admin/manage-website/seo-keywords-ex"); ?>" value="<?php echo $seo_keywords; ?>">
                                            <br><span class="kinfo"><?php echo __("admin/manage-website/seo-keywords-desc"); ?></span>
                                        </div>
                                    </div>


                                </div>

                                <div class="clear"></div>
                            </div>
                            <?php
                        }
                    ?>


                </div><!-- tab wrap content end -->


                <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                    <a class="yesilbtn gonderbtn" id="editForm_submit" href="javascript:void(0);"><?php echo ___("needs/button-update"); ?></a>
                </div>
                <div class="clear"></div>
            </form>


            <div class="clear"></div>
        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>