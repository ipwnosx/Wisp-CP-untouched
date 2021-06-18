<!DOCTYPE html>
<html>
<head>
    <?php
        $privOperation  = Admin::isPrivilege("KNOWLEDGEBASE_OPERATION");
        if(!$getHeaderBackground) $getHeaderBackground = $getHeaderBackgroundDeft;
        $options = $cat["options"] ? Utility::jdecode($cat["options"],true) : [];
        $status = $cat["status"];
        $rank   = $cat["rank"] ? $cat["rank"] : NULL;
        $parent = $cat["parent"];


        Utility::sksort($lang_list,"local");
        $plugins    = ['jquery-ui','tinymce-1'];
        include __DIR__.DS."inc".DS."head.php";
    ?>

    <script type="text/javascript">
        $(document).ready(function(){

            var tab = _GET("lang");
            if (tab != '' && tab != undefined) {
                $("#tab-lang .tablinks[data-tab='" + tab + "']").click();
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

        function hbackground_delete(){
            $("#hbackground").val('');
            $("#hbackground_preview").attr("src","<?php echo $getHeaderBackgroundDeft; ?>");

            var request = MioAjax({
                action:"<?php echo $links["controller"]; ?>",
                method:"POST",
                data:{
                    operation:"delete_category_hbackground",
                    id:<?php echo $cat["id"]; ?>
                }
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

        function editForm_handler(result){
            if(result != ''){
                var solve = getJson(result);
                if(solve !== false){
                    if(solve.status == "error"){
                        if(solve.route_check != undefined){
                            $("input[name='route["+solve.lang+"]']").val(solve.route);
                            check_route(solve.lang);
                        }
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
                <h1><strong><?php echo __("admin/knowledgebase/page-edit-category",['{title}' => $cat["title"]]); ?></strong></h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="clear"></div>

            <form  enctype="multipart/form-data" action="<?php echo $links["controller"]; ?>" method="post" id="editForm" style="margin-top: 5px;">
                <input type="hidden" name="operation" value="edit_category">

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
                        $getCatInfo     = $functions["get_category_with_lang"];
                        foreach($lang_list AS $lang) {
                            $lkey       = $lang["key"];
                            $catInfo    = $getCatInfo($lkey);
                            if(!$catInfo) $catInfo = [];
                            $title      = isset($catInfo["title"]) ? $catInfo["title"] : false;
                            $route      = isset($catInfo["route"]) ? $catInfo["route"] : false;
                            $sub_title  = isset($catInfo["sub_title"]) ? $catInfo["sub_title"] : false;
                            $optionsl   = isset($catInfo["options"]) && $catInfo["options"] ? Utility::jdecode($catInfo["options"],true) : [];
                            $content    = isset($catInfo["content"]) ? $catInfo["content"] : false;

                            $seo_title  = isset($catInfo["seo_title"]) ? $catInfo["seo_title"] : false;
                            $seo_keywords  = isset($catInfo["seo_keywords"]) ? $catInfo["seo_keywords"] : false;
                            $seo_description  = isset($catInfo["seo_description"]) ? $catInfo["seo_description"] : false;
                            ?>
                            <div id="lang-<?php echo $lkey; ?>" class="tabcontent">

                                <div class="adminpagecon">



                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/manage-website/create-category-name"); ?></div>
                                        <div class="yuzde70">
                                            <input name="title[<?php echo $lkey; ?>]" type="text" placeholder="" onchange="check_route('<?php echo $lkey; ?>',true),seo_creator('<?php echo $lkey; ?>');" onkeyup="$('input[name=\'route[<?php echo $lkey; ?>]\']').val(convertToSlug(this.value));" value="<?php echo $title; ?>">
                                        </div>
                                    </div>

                                    <?php if(___("package/permalink",false,$lkey)): ?>
                                        <div class="formcon" id="permalink-wrap-<?php echo $lkey; ?>" style="display: none;">
                                            <div class="yuzde30"><?php echo __("admin/manage-website/permalink"); ?></div>
                                            <div class="yuzde70">
                                                <span class="kinfo warning-container" style="display: none;color:red;">
                                                    <span class="warning-container-text"></span>
                                                </span>
                                                <input onchange="this.value = convertToSlug(this.value),check_route('<?php echo $lkey; ?>');" name="route[<?php echo $lkey; ?>]" type="text" placeholder="" value="<?php echo $route; ?>">
                                            </div>
                                        </div>
                                    <?php endif; ?>


                                    <?php if($lang["local"]): ?>

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
                                            <div class="yuzde30"><?php echo __("admin/manage-website/create-rank"); ?></div>
                                            <div class="yuzde70">
                                                <input type="text" name="rank" value="<?php echo $rank; ?>" class="yuzde10">
                                                <span class="kinfo"><?php echo __("admin/manage-website/create-rank-desc"); ?></span>
                                            </div>
                                        </div>

                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/manage-website/create-category-parent"); ?></div>
                                            <div class="yuzde70">
                                                <select name="parent" size="10">
                                                    <option value="0" selected><?php echo ___("needs/none"); ?></option>
                                                    <?php
                                            if(isset($categories) && $categories){
                                                foreach($categories AS $category){
                                                    if($category["parent"] == $cat["id"]) continue;
                                                    $selected = $category["id"] == $parent ? ' selected' : '';
                                                    ?>
                                                                <option<?php echo $selected; ?> value="<?php echo $category["id"]; ?>"><?php echo $category["title"]; ?></option>
                                                                <?php
                                                }
                                            }
                                        ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/manage-website/header-background"); ?></div>
                                            <div class="yuzde70">
                                                <div class="headerbgedit">
                                                    <input type="file" name="hbackground" id="hbackground" style="display:none;" onchange="read_image_file(this,'hbackground_preview');" data-default-image="<?php echo $getHeaderBackgroundDeft; ?>" />
                                                    <div class="headbgeditbtn">
                                                        <a href="javascript:hbackground_delete();void 0;" class="photosil"><i class="fa fa-trash"></i></a><br/>
                                                        <a class="avatarguncelle" href="javascript:void(0);" onclick="$('#hbackground').click();" ><i class="fa fa-camera" aria-hidden="true"></i></a>
                                                    </div>
                                                    <img src="<?php echo $getHeaderBackground; ?>" width="100%" id="hbackground_preview">
                                                </div>
                                                <div class="clear"></div>
                                                <span class="kinfo"><?php echo __("admin/manage-website/header-background-desc"); ?></span>
                                            </div>
                                        </div>

                                    <?php endif; ?>


                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/manage-website/create-content"); ?></div>
                                        <div class="yuzde70">
                                            <textarea class="tinymce-1" name="content[<?php echo $lkey; ?>]" cols="" rows="3"><?php echo $content; ?></textarea>
                                        </div>
                                    </div>


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


                <?php if($privOperation): ?>
                    <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                        <a class="yesilbtn gonderbtn" id="editForm_submit" href="javascript:void(0);"><?php echo ___("needs/button-update"); ?></a>
                    </div>
                <?php endif; ?>

                <div class="clear"></div>
            </form>

            <div class="clear"></div>
        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>