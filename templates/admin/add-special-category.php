<!DOCTYPE html>
<html>
<head>
    <?php
        Utility::sksort($lang_list,"local");
        $plugins    = ['jquery-ui','jscolor'];
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

            $(".faq-sortable").sortable({
                handle:".bearer",
            }).disableSelection();

            $(".faq-sortable").on("click",".delete-faq-item",function(){
                var elem = $(this).parent().parent();
                elem.remove();
                $(".faq-sortable").sortable("refresh");
            });

            $(".columns-sortable").sortable({
                handle:".bearer",
            }).disableSelection();

            $(".columns-sortable").on("click",".delete-column-item",function(){
                var elem = $(this).parent().parent();
                elem.remove();
                $(".columns-sortable").sortable("refresh");
            });

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

        function add_faq(lang) {
            var template    = $("#faq_item_template").html();
            template        = template.replace(/{lang}/g,lang);

            $("#faq_"+lang).append(template);
            $("#faq_"+lang).sortable('refresh');
        }

        function add_column(lang) {
            var template    = $("#column_item_template").html();
            template        = template.replace(/{lang}/g,lang);

            $("#columns_"+lang).append(template);
            $("#columns_"+lang).sortable('refresh');
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
                <h1><strong><?php echo __("admin/products/page-add-special-category",[
                            '{group-name}' => $group["title"],
                        ]); ?></strong></h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="clear"></div>

            <script>
                $( function() {
                    $( ".accordion" ).accordion({
                        heightStyle: "content",
                        active: false,
                        collapsible: true,
                    });
                } );
            </script>

            <form  enctype="multipart/form-data" action="<?php echo $links["controller"]; ?>" method="post" id="addNewForm" style="margin-top: 5px;">
                <input type="hidden" name="operation" value="add_new_special_category">

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

                                <div class="adminpagecon">

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/products/add-new-category-title"); ?></div>
                                        <div class="yuzde70">
                                            <input name="title[<?php echo $lkey; ?>]" type="text" placeholder="<?php echo __("admin/products/add-new-category-title-ex"); ?>" onchange="check_route('<?php echo $lkey; ?>',true),seo_creator('<?php echo $lkey; ?>');" onkeyup="$('input[name=\'route[<?php echo $lkey; ?>]\']').val(convertToSlug(this.value));">
                                        </div>
                                    </div>

                                    <?php if(___("package/permalink",false,$lkey)): ?>
                                        <div class="formcon" id="permalink-wrap-<?php echo $lkey; ?>" style="display: none;">
                                            <div class="yuzde30"><?php echo __("admin/products/permalink"); ?></div>
                                            <div class="yuzde70">
                                                <span class="kinfo warning-container" style="display: none;color:red;">
                                                    <span class="warning-container-text"></span>
                                                </span>
                                                <input onchange="this.value = convertToSlug(this.value),check_route('<?php echo $lkey; ?>');" name="route[<?php echo $lkey; ?>]" type="text" placeholder="">
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/products/add-new-category-subtitle"); ?></div>
                                        <div class="yuzde70">
                                            <input name="sub_title[<?php echo $lkey; ?>]" type="text" placeholder="<?php echo __("admin/products/add-new-category-subtitle-ex")?>" onchange="seo_creator('<?php echo $lkey; ?>');">
                                        </div>
                                    </div>

                                    <?php if($lang["local"]): ?>

                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/products/add-new-category-list-template"); ?></div>
                                            <div class="yuzde70">

                                                <input checked type="radio" class="radio-custom" name="list_template" value="1" id="list-template-1" onclick="$('.category-columns').slideUp(100);">
                                                <label for="list-template-1" class="radio-custom-label" style="margin-right:15px;"><?php echo __("admin/products/add-new-category-list-template-1"); ?></label>

                                                <input type="radio" class="radio-custom" name="list_template" value="2" id="list-template-2" onclick="$('.category-columns').slideDown(100);">
                                                <label for="list-template-2" class="radio-custom-label" style="margin-right:15px;"><?php echo __("admin/products/add-new-category-list-template-2"); ?></label>

                                            </div>
                                        </div>
                                    <?php endif; ?>


                                    <div class="formcon category-columns" style="display:none;">
                                        <div class="yuzde30"><?php echo __("admin/products/add-new-category-columns"); ?>
                                            <br><span class="kinfo"><?php echo __("admin/products/add-new-category-columns-desc"); ?></span>
                                        </div>
                                        <div class="yuzde70">

                                            <ul id="columns_<?php echo $lkey; ?>" class="columns-sortable" style="display:block;margin:0;">
                                                <li>
                                                    <div class="delmovebtns">
                                                        <a class="bearer" style="cursor: move;"><i class="fa fa-arrows-alt"></i></a>
                                                        <a class="delete-column-item" style="cursor:pointer;"><i class="fa fa-trash"></i></a>
                                                    </div>
                                                    <input name="columns[<?php echo $lkey; ?>][name][]" type="text" placeholder="<?php echo __("admin/products/add-column-name"); ?>">
                                                </li>
                                            </ul>
                                            <div class="clear"></div>
                                            <a href="javascript:add_column('<?php echo $lkey; ?>');void 0;" style="margin-top:5px;" class="lbtn">+ <?php echo __("admin/products/add-new-category-add-column"); ?></a>
                                        </div>
                                    </div>

                                    <?php if($lang["local"]): ?>


                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/products/add-new-category-status"); ?></div>
                                            <div class="yuzde70">
                                                <select name="status">
                                                    <option value="active"><?php echo __("admin/products/status-active"); ?></option>
                                                    <option value="inactive"><?php echo __("admin/products/status-inactive"); ?></option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/products/add-new-category-rank"); ?></div>
                                            <div class="yuzde70">
                                                <input type="text" name="rank" value="" class="yuzde10">
                                                <span class="kinfo"><?php echo __("admin/products/add-new-category-rank-desc"); ?></span>
                                            </div>
                                        </div>

                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/products/add-new-category-parent"); ?></div>
                                            <div class="yuzde70">
                                                <select name="parent" size="10">
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
                                                <br><span class="kinfo"><?php echo __("admin/products/add-new-category-parent-desc"); ?></span>
                                            </div>
                                        </div>

                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/products/add-new-category-icon-image"); ?>
                                                <br>
                                                <span class="kinfo" style="font-weight: normal;"><?php echo ___("needs/select-icon-help"); ?></span>
                                            </div>
                                            <div class="yuzde70">
                                                <input type="text" name="icon" value="" placeholder="fa fa-server">
                                                <div class="clear"></div>
                                                <span style="margin-top:15px; display:inline-block;"><?php echo __("admin/products/add-new-category-icon-or"); ?></span>
                                                <div class="clear"></div>
                                                <div class="headerbgedit">
                                                    <input type="file" name="icon_image" id="icon_image" style="display:none;" onchange="read_image_file(this,'icon_image_preview');" data-default-image="<?php echo $getIconImageDeft; ?>" />
                                                    <div class="headbgeditbtn">
                                                        <a href="javascript:$('#icon_image').val('').trigger('change');void 0;" class="photosil"><i class="fa fa-trash"></i></a><br/>
                                                        <a class="avatarguncelle" href="javascript:void(0);" onclick="$('#icon_image').click();" ><i class="fa fa-camera" aria-hidden="true"></i></a>
                                                    </div>
                                                    <img src="<?php echo $getIconImageDeft; ?>" width="100%" id="icon_image_preview">
                                                </div>
                                                <div class="clear"></div>
                                                <span class="kinfo"><?php echo __("admin/products/add-new-category-icon-image-desc"); ?></span>
                                            </div>
                                        </div>

                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/products/add-new-category-header-background"); ?></div>
                                            <div class="yuzde70">
                                                <div class="headerbgedit">
                                                    <input type="file" name="hbackground" id="hbackground" style="display:none;" onchange="read_image_file(this,'hbackground_preview');" data-default-image="<?php echo $getHeaderBackgroundDeft; ?>" />
                                                    <div class="headbgeditbtn">
                                                        <a href="javascript:$('#hbackground').val('').trigger('change');void 0;" class="photosil"><i class="fa fa-trash"></i></a><br/>
                                                        <a class="avatarguncelle" href="javascript:void(0);" onclick="$('#hbackground').click();" ><i class="fa fa-camera" aria-hidden="true"></i></a>
                                                    </div>
                                                    <img src="<?php echo $getHeaderBackgroundDeft; ?>" width="100%" id="hbackground_preview">
                                                </div>
                                                <div class="clear"></div>
                                                <span class="kinfo"><?php echo __("admin/products/add-new-category-header-background-desc"); ?></span>
                                            </div>
                                        </div>

                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/products/add-new-category-color"); ?></div>
                                            <div class="yuzde70">
                                                <input type="text" name="color" class="jscolor" value="">
                                            </div>
                                        </div>

                                    <?php endif; ?>




                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/products/add-new-category-content"); ?></div>
                                        <div class="yuzde70">
                                            <textarea name="content[<?php echo $lkey; ?>]" cols="" rows="3" placeholder="<?php echo __("admin/products/add-new-category-content-ex"); ?>"></textarea>
                                            <br><span class="kinfo"><?php echo __("admin/products/add-new-category-content-desc"); ?></span>
                                        </div>
                                    </div>




                                    <div class="clear"></div>
                                    <div class="faqaccordion">
                                        <div class="accordion">
                                            <h3><?php echo __("admin/products/add-new-category-faq"); ?> <span class="kinfo">(<?php echo __("admin/products/add-new-category-faq-desc"); ?>)</span></h3>
                                            <div>

                                                <ul id="faq_<?php echo $lkey; ?>" class="faq-sortable" style="display:block;margin:0;">
                                                    <li>
                                                        <div class="delmovebtns"><a class="bearer" style="cursor: move;"><i class="fa fa-arrows-alt"></i></a>
                                                            <a class="delete-faq-item" style="cursor:pointer;"><i class="fa fa-trash"></i></a></div>
                                                        <input name="faq[<?php echo $lkey; ?>][title][]" type="text" placeholder="<?php echo __("admin/products/add-faq-title"); ?>">
                                                        <textarea name="faq[<?php echo $lkey; ?>][description][]" placeholder="<?php echo __("admin/products/add-faq-description"); ?>"></textarea>
                                                    </li>
                                                </ul>
                                                <div class="clear"></div>
                                                <a href="javascript:add_faq('<?php echo $lkey; ?>');void 0;" style="margin-top:5px;" class="lbtn">+ <?php echo __("admin/products/add-new-category-add-fag"); ?></a>

                                            </div>
                                        </div>
                                    </div>


                                    <div class="formcon">
                                        <div class="blue-info">
                                            <div class="padding15">
                                                <?php echo __("admin/products/seo-desc"); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/products/seo-title"); ?></div>
                                        <div class="yuzde70">
                                            <input name="seo_title[<?php echo $lkey; ?>]" type="text" placeholder="<?php echo __("admin/products/seo-title-ex"); ?>" value="">
                                            <br><span class="kinfo"><?php echo __("admin/products/seo-title-desc"); ?></span>
                                        </div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/products/seo-description"); ?></div>
                                        <div class="yuzde70">
                                            <textarea name="seo_description[<?php echo $lkey; ?>]" cols="" rows="2" placeholder="<?php echo __("admin/products/seo-description-ex"); ?>"></textarea>
                                            <br><span class="kinfo"><?php echo __("admin/products/seo-description-desc"); ?></span>
                                        </div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/products/seo-keywords"); ?></div>
                                        <div class="yuzde70">
                                            <input name="seo_keywords[<?php echo $lkey; ?>]" type="text" placeholder="<?php echo __("admin/products/seo-keywords-ex"); ?>">
                                            <br><span class="kinfo"><?php echo __("admin/products/seo-keywords-desc"); ?></span>
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
                    <a class="yesilbtn gonderbtn" id="addNewForm_submit" href="javascript:void(0);"><?php echo __("admin/products/new-category-button"); ?></a>
                </div>
                <div class="clear"></div>
            </form>

            <ul id="faq_item_template" style="display: none;">
                <li>
                    <div class="delmovebtns"><a class="bearer" style="cursor: move;"><i class="fa fa-arrows-alt"></i></a>
                        <a class="delete-faq-item" style="cursor:pointer;"><i class="fa fa-trash"></i></a></div>
                    <input name="faq[{lang}][title][]" type="text" placeholder="<?php echo __("admin/products/add-faq-title"); ?>">
                    <textarea name="faq[{lang}][description][]" placeholder="<?php echo __("admin/products/add-faq-description"); ?>"></textarea>
                </li>
            </ul>

            <ul id="column_item_template" style="display: none;">
                <li>
                    <div class="delmovebtns">
                        <a class="bearer" style="cursor: move;"><i class="fa fa-arrows-alt"></i></a>
                        <a class="delete-column-item" style="cursor:pointer;"><i class="fa fa-trash"></i></a></div>
                    <input name="columns[{lang}][name][]" type="text" placeholder="<?php echo __("admin/products/add-column-name"); ?>">
                </li>
            </ul>


            <div class="clear"></div>
        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>