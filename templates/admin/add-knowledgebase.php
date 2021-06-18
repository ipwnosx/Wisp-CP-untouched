<!DOCTYPE html>
<html>
<head>
    <?php
        Utility::sksort($lang_list,"local");
        $plugins    = ['jquery-ui','tinymce-1','jQtags'];
        include __DIR__.DS."inc".DS."head.php";
    ?>

    <script type="text/javascript">
        $(document).ready(function(){

            $(".tags").tagsInput({
                'width':'100%',
                'height': '55px',
                'defaultText':'+ <?php echo ___("needs/button-add"); ?>',
                'interactive':true,
                'removeWithBackspace' : true,
            });


            var tab2 = _GET("lang");
            if (tab2 != '' && tab2 != undefined) {
                $("#tab-lang .tablinks[data-tab='" + tab2 + "']").click();
            } else {
                $("#tab-lang .tablinks:eq(0)").addClass("active");
                $("#tab-lang .tabcontent:eq(0)").css("display", "block");
            }

            $("#addNewForm_submit").on("click",function(){
                MioAjaxElement($(this),{
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                    result:"addNewForm_handler",
                });
            });

        });

        function addNewForm_handler(result){
            if(result != ''){
                var solve = getJson(result);
                if(solve !== false){
                    if(solve.status == "error"){
                        if(solve.for != undefined && solve.for != ''){
                            $("#addNewForm "+solve.for).focus();
                            $("#addNewForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                            $("#addNewForm "+solve.for).change(function(){
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
                <h1><strong><?php echo __("admin/knowledgebase/page-create"); ?></strong></h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="clear"></div>

            <form action="<?php echo $links["controller"]; ?>" method="post" id="addNewForm" style="margin-top: 5px;">
                <input type="hidden" name="operation" value="add">

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
                        foreach($lang_list AS $lang) {
                            $lkey = $lang["key"];

                            ?>
                            <div id="lang-<?php echo $lkey; ?>" class="tabcontent">

                                <div class="adminpageconxx">

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/manage-website/create-title"); ?></div>
                                        <div class="yuzde70">
                                            <input name="title[<?php echo $lkey; ?>]" type="text" onchange="check_route('<?php echo $lkey; ?>',true);" onkeyup="$('input[name=\'route[<?php echo $lkey; ?>]\']').val(convertToSlug(this.value));">
                                        </div>
                                    </div>

                                    <?php if(___("package/permalink",false,$lkey)): ?>
                                        <div class="formcon" id="permalink-wrap-<?php echo $lkey; ?>" style="display: none;">
                                            <div class="yuzde30"><?php echo __("admin/manage-website/permalink"); ?></div>
                                            <div class="yuzde70">
                                                <span class="kinfo warning-container" style="display: none;color:red;">
                                                    <span class="warning-container-text"></span>
                                                </span>
                                                <input onchange="this.value = convertToSlug(this.value),check_route('<?php echo $lkey; ?>');" name="route[<?php echo $lkey; ?>]" type="text" placeholder="">
                                            </div>
                                        </div>
                                    <?php endif; ?>


                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/manage-website/create-content"); ?></div>
                                        <div class="yuzde70">
                                            <textarea class="tinymce-1" name="content[<?php echo $lkey; ?>]" rows="3" placeholder=""></textarea>
                                        </div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30">
                                            <?php echo __("admin/knowledgebase/create-tags"); ?>
                                            <div class="clear"></div>
                                            <span class="kinfo"><?php echo __("admin/knowledgebase/create-tags-info"); ?></span>
                                        </div>
                                        <div class="yuzde70">
                                            <input name="tags[<?php echo $lkey; ?>]" type="text" class="tags">
                                        </div>
                                    </div>

                                    <?php if($lang["local"]): ?>

                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/manage-website/create-category"); ?></div>
                                            <div class="yuzde70">
                                                <select name="category" size="10">
                                                    <option value="0" selected><?php echo ___("needs/none"); ?></option>
                                                    <?php
                                                        if(isset($categories) && $categories){
                                                            foreach($categories AS $category){
                                                                ?>
                                                                <option value="<?php echo $category["id"]; ?>"><?php echo $category["title"]; ?></option>
                                                                <?php
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/knowledgebase/create-rank"); ?></div>
                                            <div class="yuzde70">
                                                <input type="text" name="rank" value="" class="yuzde10">
                                                <span class="kinfo"><?php echo __("admin/knowledgebase/create-rank-desc"); ?></span>
                                            </div>
                                        </div>

                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/knowledgebase/create-private"); ?></div>
                                            <div class="yuzde70">

                                                <input id="private" type="checkbox" name="private" value="1" class="sitemio-checkbox">
                                                <label for="private" class="sitemio-checkbox-label"></label>
                                                <span class="kinfo"><?php echo __("admin/knowledgebase/create-private-info"); ?></span>

                                            </div>
                                        </div>

                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/manage-website/create-sidebar"); ?></div>
                                            <div class="yuzde70">

                                                <input id="sidebar" type="checkbox" name="sidebar" value="1" class="sitemio-checkbox">
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
                                                        <a href="javascript:$('#hbackground').val('').trigger('change');void 0;" class="photosil"><i class="fa fa-trash"></i></a><br/>
                                                        <a class="avatarguncelle" href="javascript:void(0);" onclick="$('#hbackground').click();" ><i class="fa fa-camera" aria-hidden="true"></i></a>
                                                    </div>
                                                    <img src="<?php echo $getHeaderBackgroundDeft; ?>" width="100%" id="hbackground_preview">
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
                                            <input name="seo_title[<?php echo $lkey; ?>]" type="text" placeholder="<?php echo __("admin/manage-website/seo-title-ex"); ?>" value="">
                                            <br><span class="kinfo"><?php echo __("admin/manage-website/seo-title-desc"); ?></span>
                                        </div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/manage-website/seo-description"); ?></div>
                                        <div class="yuzde70">
                                            <textarea name="seo_description[<?php echo $lkey; ?>]" cols="" rows="2" placeholder="<?php echo __("admin/manage-website/seo-description-ex"); ?>"></textarea>
                                            <br><span class="kinfo"><?php echo __("admin/manage-website/seo-description-desc"); ?></span>
                                        </div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/manage-website/seo-keywords"); ?></div>
                                        <div class="yuzde70">
                                            <input name="seo_keywords[<?php echo $lkey; ?>]" type="text" placeholder="<?php echo __("admin/manage-website/seo-keywords-ex"); ?>">
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
                    <a class="yesilbtn gonderbtn" id="addNewForm_submit" href="javascript:void(0);"><?php echo ___("needs/button-create"); ?></a>
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