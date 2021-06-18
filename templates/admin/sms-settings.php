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

            $(".op_notes-sortable").sortable({
                handle:".bearer",
            }).disableSelection();

            $(".op_notes-sortable").on("click",".delete-op_notes-item",function(){
                var elem = $(this).parent().parent();
                elem.remove();
                $(".op_notes-sortable").sortable("refresh");
            });


            $("#updateForm_submit").on("click",function(){
                MioAjaxElement($(this),{
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                    result:"updateForm_handler",
                });
            });

        });

        function updateForm_handler(result){
            if(result != ''){
                var solve = getJson(result);
                if(solve !== false){
                    if(solve.status == "error"){
                        if(solve.for != undefined && solve.for != ''){
                            $("#updateForm "+solve.for).focus();
                            $("#updateForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                            $("#updateForm "+solve.for).change(function(){
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

        function add_op_notes(lang) {
            var template    = $("#op_notes_item_template").html();
            template        = template.replace(/{lang}/g,lang);

            $("#op_notes_"+lang).append(template);
            $("#op_notes_"+lang).sortable('refresh');
        }
    </script>
</head>
<body>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1><strong><?php echo __("admin/products/page-sms-settings"); ?></strong></h1>
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

            <form action="<?php echo $links["controller"]; ?>" method="post" id="updateForm">
                <input type="hidden" name="operation" value="update_sms_settings">



                <div id="tab-lang"><!-- tab wrap content start -->
                    <ul class="tab">
                        <?php
                            $ctoc_s_t       = Config::get("options/ctoc-service-transfer/sms/status");
                            $ctoc_s_t_l     = Config::get("options/ctoc-service-transfer/sms/limit");

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

                            $category   = ___("constants/category-sms",false,$lkey);
                            $seo        = __("website/products/meta-sms",false,$lkey);
                            ?>
                            <div id="lang-<?php echo $lkey; ?>" class="tabcontent">

                                <div class="adminpagecon">

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/products/add-new-category-title"); ?></div>
                                        <div class="yuzde70">
                                            <input name="title[<?php echo $lkey; ?>]" type="text" placeholder="<?php echo __("admin/products/add-new-category-title-ex"); ?>" value="<?php echo $category["title"]; ?>">
                                        </div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/products/add-new-category-subtitle"); ?></div>
                                        <div class="yuzde70">
                                            <input name="sub_title[<?php echo $lkey; ?>]" type="text" placeholder="<?php echo __("admin/products/add-new-category-subtitle-ex")?>" value="<?php echo $category["sub_title"]; ?>">
                                        </div>
                                    </div>

                                    <?php if($lang["local"]): ?>
                                        <?php
                                        if(!$getIconImage) $getIconImage = $getIconImageDeft;
                                        ?>
                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/products/add-new-category-icon-image"); ?>
                                                <br>
                                                <span class="kinfo" style="font-weight: normal;"><?php echo ___("needs/select-icon-help"); ?></span>
                                            </div>
                                            <div class="yuzde70">
                                                <input type="text" name="icon" value="<?php echo Config::get("options/category-icon/sms"); ?>" placeholder="fa fa-server">
                                                <div class="clear"></div>
                                                <span style="margin-top:15px; display:inline-block;"><?php echo __("admin/products/add-new-category-icon-or"); ?></span>
                                                <div class="clear"></div>
                                                <div class="headerbgedit">
                                                    <input type="file" name="icon_image" id="icon_image" style="display:none;" onchange="read_image_file(this,'icon_image_preview');" data-default-image="<?php echo $getIconImageDeft; ?>" />
                                                    <div class="headbgeditbtn">
                                                        <script type="text/javascript">
                                                            function icon_image_delete(){
                                                                $("#icon_image").val('');
                                                                $("#icon_image_preview").attr("src","<?php echo $getIconImageDeft; ?>");

                                                                var request = MioAjax({
                                                                    action:"<?php echo $links["controller"]; ?>",
                                                                    method:"POST",
                                                                    data:{
                                                                        operation:"delete_category_icon_image",
                                                                        id:6
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
                                                        </script>
                                                        <a href="javascript:icon_image_delete();" class="photosil"><i class="fa fa-trash"></i></a><br/>
                                                        <a class="avatarguncelle" href="javascript:void(0);" onclick="$('#icon_image').click();" ><i class="fa fa-camera" aria-hidden="true"></i></a>
                                                    </div>
                                                    <img src="<?php echo $getIconImage; ?>" width="100%" id="icon_image_preview">
                                                </div>
                                                <div class="clear"></div>
                                                <span class="kinfo"><?php echo __("admin/products/add-new-category-icon-image-desc"); ?></span>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/products/category-group-settings-color"); ?></div>
                                        <div class="yuzde70">
                                            <input type="text" name="color[<?php echo $lkey; ?>]" class="jscolor" value="<?php echo substr($category["options"]["color"],1); ?>">
                                        </div>
                                    </div>



                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/products/add-new-category-content"); ?></div>
                                        <div class="yuzde70">
                                            <textarea name="content[<?php echo $lkey; ?>]" cols="" rows="3" placeholder="<?php echo __("admin/products/add-new-category-content-ex"); ?>"><?php echo $category["content"]; ?></textarea>
                                            <br><span class="kinfo"><?php echo __("admin/products/add-new-category-content-desc"); ?></span>
                                        </div>
                                    </div>

                                    <?php
                                        if($lang["local"]){
                                            ?>
                                            <div class="formcon" style="<?php echo !Config::get("options/ctoc-service-transfer/status") ? 'display:none;' : ''; ?>">
                                                <div class="yuzde30"><?php echo __("admin/products/add-new-product-ctoc-service-transfer"); ?></div>
                                                <div class="yuzde70">
                                                    <input<?php echo $ctoc_s_t ? ' checked' : ''; ?> type="checkbox" name="ctoc-service-transfer" value="1" id="ctoc-service-transfer" class="checkbox-custom" onchange="if($(this).prop('checked')) $('#ctoc-service-transfer-wrap').css('display','block'); else $('#ctoc-service-transfer-wrap').css('display','none');">
                                                    <label class="checkbox-custom-label" for="ctoc-service-transfer"><span class="kinfo"><?php echo __("admin/products/add-new-product-ctoc-service-transfer-desc"); ?></span></label>

                                                    <div class="clear"></div>
                                                    <div id="ctoc-service-transfer-wrap" style="<?php echo $ctoc_s_t ? '' : 'display:none;'; ?>">
                                                        <div class="formcon">
                                                            <div class="yuzde30" style="width: 50px;"><?php echo __("admin/products/add-new-product-limit"); ?></div>
                                                            <div class="yuzde70">
                                                                <input type="text" style="width: 10%;" name="ctoc-service-transfer-limit" value="<?php echo $ctoc_s_t_l; ?>">
                                                                <span class="kinfo"><?php echo __("admin/products/add-new-product-limit-ctoc-service-transfer"); ?></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <?php
                                        }
                                    ?>

                                    <div class="clear"></div>
                                    <div class="faqaccordion">
                                        <div class="accordion">
                                            <h3>Operatör Notu Şablonları <span class="kinfo">(SMS Başlıklarının durumu hakkında müşterilerinize bilgi vermek adına, hazır notlar tanımlayabilirsiniz.)</span></span></h3>
                                            <div>

                                                <style>
                                                    .op_notes-sortable li:hover .delmovebtns{display:block;width:30px;margin-top:5px}

                                                </style>

                                                <ul id="op_notes_<?php echo $lkey; ?>" class="op_notes-sortable faq-sortable" style="display:block;margin:0;">
                                                    <?php
                                                        $op_notes = isset($category["op_notes"]) ? $category["op_notes"] : [];
                                                        if($op_notes){
                                                            foreach($op_notes AS $f){
                                                                ?>
                                                                <li>
                                                                    <div class="delmovebtns">
                                                                        <a class="bearer" style="cursor: move;"><i class="fa fa-arrows-alt"></i></a>
                                                                        <a class="delete-op_notes-item" style="cursor:pointer;"><i class="fa fa-trash"></i></a>
                                                                    </div>
                                                                    <input name="op_notes[<?php echo $lkey; ?>][title][]" type="text" placeholder="Başlık" value="<?php echo $f["title"]; ?>">
                                                                    <textarea name="op_notes[<?php echo $lkey; ?>][description][]"  placeholder="Açıklama"><?php echo $f["description"]; ?></textarea>
                                                                </li>
                                                                <?php
                                                            }
                                                        }
                                                    ?>
                                                </ul>
                                                <div class="clear"></div>
                                                <a href="javascript:add_op_notes('<?php echo $lkey; ?>');void 0;" style="margin-top:5px;" class="lbtn">+ Yeni Şablon Ekle</a>

                                            </div>

                                            <h3><?php echo __("admin/products/add-new-category-faq"); ?> <span class="kinfo">(<?php echo __("admin/products/add-new-category-faq-desc"); ?>)</span></h3>
                                            <div>

                                                <ul id="faq_<?php echo $lkey; ?>" class="faq-sortable" style="display:block;margin:0;">
                                                    <?php
                                                        $faq = $category["faq"];
                                                        if($faq){
                                                            foreach($faq AS $f){
                                                                ?>
                                                                <li>
                                                                    <div class="delmovebtns">
                                                                        <a class="bearer" style="cursor: move;"><i class="fa fa-arrows-alt"></i></a>
                                                                        <a class="delete-faq-item" style="cursor:pointer;"><i class="fa fa-trash"></i></a>
                                                                    </div>
                                                                    <input name="faq[<?php echo $lkey; ?>][title][]" type="text" placeholder="<?php echo __("admin/products/add-faq-title"); ?>" value="<?php echo $f["title"]; ?>">
                                                                    <textarea name="faq[<?php echo $lkey; ?>][description][]"  placeholder="<?php echo __("admin/products/add-faq-description"); ?>"><?php echo $f["description"]; ?></textarea>
                                                                </li>
                                                                <?php
                                                            }
                                                        }
                                                    ?>
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
                                            <input name="seo_title[<?php echo $lkey; ?>]" type="text" placeholder="<?php echo __("admin/products/seo-title-ex"); ?>" value="<?php echo $seo["title"]; ?>">
                                            <br><span class="kinfo"><?php echo __("admin/products/seo-title-desc"); ?></span>
                                        </div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/products/seo-description"); ?></div>
                                        <div class="yuzde70">
                                            <textarea name="seo_description[<?php echo $lkey; ?>]" cols="" rows="2" placeholder="<?php echo __("admin/products/seo-description-ex"); ?>"><?php echo $seo["description"]; ?></textarea>
                                            <br><span class="kinfo"><?php echo __("admin/products/seo-description-desc"); ?></span>
                                        </div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/products/seo-keywords"); ?></div>
                                        <div class="yuzde70">
                                            <input name="seo_keywords[<?php echo $lkey; ?>]" type="text" placeholder="<?php echo __("admin/products/seo-keywords-ex"); ?>" value="<?php echo $seo["keywords"]; ?>">
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
                    <a class="yesilbtn gonderbtn" id="updateForm_submit" href="javascript:void(0);"><?php echo __("admin/products/update-settings-button"); ?></a>
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

            <ul id="op_notes_item_template" style="display: none;">
                <li>
                    <div class="delmovebtns"><a class="bearer" style="cursor: move;"><i class="fa fa-arrows-alt"></i></a>
                        <a class="delete-op_notes-item" style="cursor:pointer;"><i class="fa fa-trash"></i></a></div>
                    <input name="op_notes[{lang}][title][]" type="text" placeholder="Başlık">
                    <textarea name="op_notes[{lang}][description][]" placeholder="Açıklama"></textarea>
                </li>
            </ul>


            <div class="clear"></div>
        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>