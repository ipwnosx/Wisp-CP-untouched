<!DOCTYPE html>
<html>
<head>
    <?php
        Utility::sksort($lang_list,"local");
        $plugins    = ['jquery-ui','tinymce-1'];
        include __DIR__.DS."inc".DS."head.php";
    ?>

    <script type="text/javascript">
        $(document).ready(function(){

            $("input[name=external_link]").change(function(){
                var value = $(this).val();
                if(value){
                    $("#settings-pricing .adminpagecon,#settings-optional-addons .adminpagecon,#settings-requirements .adminpagecon").addClass("tab-blur-content");
                    $(".blur-text").fadeIn(100);
                }else{
                    $("#settings-informations .adminpagecon,#settings-pricing .adminpagecon,#settings-optional-addons .adminpagecon,#settings-requirements .adminpagecon").removeClass("tab-blur-content");
                    $(".blur-text").fadeOut(100);
                }

            });

            var tab = _GET("settings");
            if (tab != '' && tab != undefined) {
                $("#tab-settings .tablinks[data-tab='" + tab + "']").click();
            } else {
                $("#tab-settings .tablinks:eq(0)").addClass("active");
                $("#tab-settings .tabcontent:eq(0)").css("display", "block");
            }

            var tab2 = _GET("lang");
            if (tab2 != '' && tab2 != undefined) {
                $("#tab-lang .tablinks[data-tab='" + tab2 + "']").click();
            } else {
                $("#tab-lang .tablinks:eq(0)").addClass("active");
                $("#tab-lang .tabcontent:eq(0)").css("display", "block");
            }

            var tab3 = _GET("lang2");
            if (tab3 != '' && tab3 != undefined) {
                $("#tab-lang2 .tablinks[data-tab='" + tab3 + "']").click();
            } else {
                $("#tab-lang2 .tablinks:eq(0)").addClass("active");
                $("#tab-lang2 .tabcontent:eq(0)").css("display", "block");
            }

            /*$("#addNewForm").bind("keypress", function(e) {
                if (e.keyCode == 13) $("#addNewForm_submit").click();
            });*/

            $(".software-blocks-sortable").sortable({ 
                handle:".bearer",
            }).disableSelection();

            $(".software-blocks-sortable").on("click",".delete-block-item",function(){
                var elem = $(this).parent().parent();
                elem.remove();
                $(".software-blocks-sortable").sortable("refresh");
            });

            $("#addNewForm_submit").on("click",function(){
                MioAjaxElement($(this),{
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                    result:"addNewForm_handler",
                });
            });

            $(".accordion").accordion({
                heightStyle: "content"
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

        function add_block(lang) {
            var template    = $("#block_item_template").html();
            template        = template.replace(/{lang}/g,lang);

            $("#blocks_"+lang).append(template);
            $("#blocks_"+lang).sortable('refresh');
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
                <h1><strong><?php echo __("admin/products/page-add-software"); ?></strong></h1>
                <?php
                $ui_help_link = 'https://docs.wisecp.com/en/kb/create-a-software-product';
                if($ui_lang == "tr") $ui_help_link = 'https://docs.wisecp.com/tr/kb/yazilim-urunu-olustur';
                ?>
                <a title="<?php echo __("admin/help/usage-guide"); ?>" target="_blank" class="pagedocslink" href="<?php echo $ui_help_link; ?>"><i class="fa fa-life-ring" aria-hidden="true"></i></a>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="clear"></div>

            <ul id="block_item_template" style="display:none;">
                <li>
                    <div class="delmovebtns">
                        <a class="bearer" style="cursor: move;"><i class="fa fa-arrows-alt"></i></a>
                        <a class="delete-block-item" style="cursor:pointer;"><i class="fa fa-trash"></i></a>
                    </div>
                    <input class="yuzde15" name="feature-block[{lang}][icon][]" type="text" placeholder="<?php echo __("admin/products/add-new-product-feature-block-icon"); ?>"> -
                    <input class="yuzde25" name="feature-block[{lang}][title][]" type="text" placeholder="<?php echo __("admin/products/add-new-product-feature-block-title"); ?>"> -
                    <input class="yuzde25" name="feature-block[{lang}][description][]" type="text" placeholder="<?php echo __("admin/products/add-new-product-feature-block-description"); ?>"> -
                    <input class="yuzde20" name="feature-block[{lang}][detailed-description][]" type="text" placeholder="<?php echo __("admin/products/add-new-product-feature-block-detailed-description"); ?>">
                </li>
            </ul>

            <form action="<?php echo $links["controller"]; ?>" method="post" id="addNewForm" style="margin-top: 5px;">
                <input type="hidden" name="operation" value="add_new_software">

                <div id="tab-settings"><!-- tab wrap content start -->
                    <ul class="tab">
                        <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'detail','settings')" data-tab="detail"><i class="fa fa-info" aria-hidden="true"></i>  <?php echo __("admin/products/add-new-product-settings-detail"); ?></a></li>


                        <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'optional-addons','settings')" data-tab="optional-addons"><i class="fa fa-plus" aria-hidden="true"></i> <?php echo __("admin/products/add-new-product-settings-optional-addons"); ?></a></li>

                        <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'requirements','settings')" data-tab="requirements"><i class="fa fa-check-square-o" aria-hidden="true"></i> <?php echo __("admin/products/add-new-product-settings-requirements"); ?></a></li>

                        <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'pricing','settings')" data-tab="pricing"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <?php echo __("admin/products/add-new-product-settings-pricing"); ?></a></li>

                        <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'license','settings')" data-tab="license"><i class="fa fa-code" aria-hidden="true"></i> <?php echo __("admin/products/add-new-product-settings-license"); ?></a></li>
                    </ul>

                    <div id="settings-detail" class="tabcontent"><!-- detail tab content start -->

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

                                            <div class="accordion">
                                                <h3><?php echo __("admin/products/add-new-product-software-tab-general"); ?></h3>
                                                <div>

                                                    <div class="formcon">
                                                        <div class="yuzde30"><?php echo __("admin/products/add-new-product-hosting-title"); ?></div>
                                                        <div class="yuzde70">
                                                            <input name="title[<?php echo $lkey; ?>]" type="text" onchange="check_route('<?php echo $lkey; ?>',true);" onkeyup="$('input[name=\'route[<?php echo $lkey; ?>]\']').val(convertToSlug(this.value));">
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



                                                    <?php if($lang["local"]): ?>

                                                        <div class="formcon">
                                                            <div class="yuzde30"><?php echo __("admin/products/add-new-product-demo-link"); ?></div>
                                                            <div class="yuzde70">
                                                                <input type="text" name="demo-link" value="">
                                                            </div>
                                                        </div>

                                                        <div class="formcon">
                                                            <div class="yuzde30"><?php echo __("admin/products/add-new-product-demo-admin-link"); ?></div>
                                                            <div class="yuzde70">
                                                                <input type="text" name="demo-admin-link" value="">
                                                            </div>
                                                        </div>


                                                        <div class="formcon">
                                                            <div class="yuzde30"><?php echo __("admin/products/add-new-product-download-file"); ?></div>
                                                            <div class="yuzde70">

                                                                <input id="download-file" type="file" name="download-file" style="width: 200px;" onchange="if($(this).val() == '') $('#download-file-button').hide(1); else $('#download-file-button').show(1); ">
                                                                <a style="display: none;" id="download-file-button" href="javascript:$('#download-file').val('').trigger('change');void 0;" class="red sbtn"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                                <div class="clear"></div>
                                                                <span class="kinfo"><?php echo __("admin/products/add-new-product-download-file-desc"); ?></span>

                                                            </div>
                                                        </div>

                                                        <div class="formcon">
                                                            <div class="yuzde30"><?php echo __("admin/products/add-new-product-download-link"); ?></div>
                                                            <div class="yuzde70">
                                                                <input type="text" name="download-link" value="">
                                                                <div class="clear"></div>
                                                                <span class="kinfo"><?php echo __("admin/products/add-new-product-download-link-desc"); ?></span>
                                                            </div>
                                                        </div>

                                                        <div class="formcon">
                                                            <div class="yuzde30"><?php echo __("admin/products/add-new-product-category"); ?></div>
                                                            <div class="yuzde70">
                                                                <select name="category[]" size="10" multiple>
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
                                                            <div class="yuzde30"><?php echo __("admin/products/add-new-product-status"); ?></div>
                                                            <div class="yuzde70">
                                                                <select name="status">
                                                                    <option value="active"><?php echo __("admin/products/status-active"); ?></option>
                                                                    <option value="inactive"><?php echo __("admin/products/status-inactive"); ?></option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="formcon">
                                                            <div class="yuzde30"><?php echo __("admin/products/add-new-product-popular"); ?></div>
                                                            <div class="yuzde70">
                                                                <input type="checkbox" name="popular" value="1" class="checkbox-custom" id="popular">
                                                                <label class="checkbox-custom-label" for="popular"><?php echo __("admin/products/add-new-product-popular-label"); ?></label>
                                                            </div>
                                                        </div>


                                                        <div class="formcon">
                                                            <div class="yuzde30"><?php echo __("admin/products/add-new-product-rank"); ?></div>
                                                            <div class="yuzde70">
                                                                <input type="text" name="rank" value="" class="yuzde10">
                                                            </div>
                                                        </div>

                                                        <div class="formcon">
                                                            <div class="yuzde30"><?php echo __("admin/products/add-new-product-auto-approval"); ?></div>
                                                            <div class="yuzde70">

                                                                <input checked id="auto-approval" type="checkbox" name="auto-approval" value="1" class="sitemio-checkbox">
                                                                <label for="auto-approval" class="sitemio-checkbox-label"></label>
                                                                <span class="kinfo"><?php echo __("admin/products/add-new-product-auto-approval-desc"); ?></span>

                                                            </div>
                                                        </div>

                                                        <div class="formcon">
                                                            <div class="yuzde30"><?php echo __("admin/products/add-new-product-hide-domain"); ?></div>
                                                            <div class="yuzde70">

                                                                <input id="hide-domain" type="checkbox" name="hide-domain" value="1" class="checkbox-custom">
                                                                <label for="hide-domain" class="checkbox-custom-label">
                                                                    <span class="kinfo"><?php echo __("admin/products/add-new-product-hide-domain-desc"); ?></span>
                                                                </label>

                                                            </div>
                                                        </div>
                                                        <div class="formcon">
                                                            <div class="yuzde30"><?php echo __("admin/products/add-new-product-hide-hosting"); ?></div>
                                                            <div class="yuzde70">

                                                                <input id="hide-hosting" type="checkbox" name="hide-hosting" value="1" class="checkbox-custom">
                                                                <label for="hide-hosting" class="checkbox-custom-label">
                                                                    <span class="kinfo"><?php echo __("admin/products/add-new-product-hide-hosting-desc"); ?></span>
                                                                </label>

                                                            </div>
                                                        </div>

                                                    <?php endif; ?>

                                                    <div class="formcon">
                                                        <div class="yuzde30"><?php echo __("admin/products/add-new-product-tag1"); ?></div>
                                                        <div class="yuzde70">
                                                            <input type="text" name="tag1[<?php echo $lkey; ?>]" value="" placeholder="<?php echo __("admin/products/add-new-product-tag1-pr"); ?>">
                                                        </div>
                                                    </div>

                                                    <div class="formcon">
                                                        <div class="yuzde30"><?php echo __("admin/products/add-new-product-tag2"); ?></div>
                                                        <div class="yuzde70">
                                                            <input type="text" name="tag2[<?php echo $lkey; ?>]" value="" placeholder="<?php echo __("admin/products/add-new-product-tag2-pr"); ?>">
                                                        </div>
                                                    </div>


                                                </div>

                                                <h3><?php echo __("admin/products/add-new-product-software-tab-descriptions"); ?></h3>
                                                <div>

                                                    <div class="formcon">
                                                        <div class="yuzde30"><?php echo __("admin/products/add-new-product-short-features"); ?>
                                                            <br><span class="kinfo"><?php echo __("admin/products/add-new-product-short-features-pr"); ?></span>
                                                        </div>
                                                        <div class="yuzde70">
                                                            <textarea  name="short-features[<?php echo $lkey; ?>]" rows="3" placeholder=""></textarea>
                                                        </div>
                                                    </div>


                                                    <div class="formcon">
                                                        <div class="yuzde30"><?php echo __("admin/products/add-new-product-software-requirements"); ?>
                                                            <br><span class="kinfo"><?php echo __("admin/products/add-new-product-software-requirements-desc"); ?></span>
                                                        </div>
                                                        <div class="yuzde70">
                                                            <textarea name="requirement[<?php echo $lkey; ?>]" rows="3" placeholder=""></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="formcon">
                                                        <div class="yuzde30"><?php echo __("admin/products/add-new-product-content"); ?>
                                                            <br><span class="kinfo"><?php echo __("admin/products/add-new-product-content-pr"); ?></span></div>
                                                        <div class="yuzde70">
                                                            <textarea class="tinymce-1" name="content[<?php echo $lkey; ?>]" rows="3" placeholder=""></textarea>
                                                        </div>
                                                    </div>



                                                    <div class="formcon">
                                                        <div class="yuzde30"><?php echo __("admin/products/add-new-product-installation-instructions"); ?>
                                                            <br><span class="kinfo"><?php echo __("admin/products/add-new-product-installation-instructions-desc"); ?></span>
                                                        </div>
                                                        <div class="yuzde70">
                                                            <textarea class="tinymce-1" name="installation-instructions[<?php echo $lkey; ?>]" rows="3"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="formcon">
                                                        <div class="yuzde30"><?php echo __("admin/products/add-new-product-versions"); ?>
                                                            <br><span class="kinfo"><?php echo __("admin/products/add-new-product-versions-desc"); ?></span>
                                                        </div>
                                                        <div class="yuzde70">
                                                            <textarea class="tinymce-1" name="versions[<?php echo $lkey; ?>]" rows="3"></textarea>
                                                        </div>
                                                    </div>

                                                </div>

                                                <?php if($lang["local"]): ?>
                                                    <h3><?php echo __("admin/products/add-new-product-software-tab-pictures"); ?></h3>
                                                    <div>


                                                        <div class="formcon">
                                                            <div class="yuzde30"><?php echo __("admin/products/add-new-product-order-image"); ?>
                                                                <div class="clear"></div>
                                                                <span class="kinfo"><?php echo __("admin/products/add-new-product-order-image-desc"); ?></span>
                                                            </div>
                                                            <div class="yuzde70">
                                                                <div class="headerbgedit">
                                                                    <input type="file" name="order_image" id="order_image" style="display:none;" onchange="read_image_file(this,'order_image_preview');" data-default-image="<?php echo $getOrderImageDeft; ?>" />
                                                                    <div class="headbgeditbtn">
                                                                        <a href="javascript:$('#order_image').val('').trigger('change');void 0;" class="photosil"><i class="fa fa-trash"></i></a><br/>
                                                                        <a class="avatarguncelle" href="javascript:void(0);" onclick="$('#order_image').click();" ><i class="fa fa-camera" aria-hidden="true"></i></a>
                                                                    </div>
                                                                    <img src="<?php echo $getOrderImageDeft; ?>" style="    height: 130px;    width: 170px;" width="100%" id="order_image_preview">
                                                                </div>

                                                            </div>
                                                        </div>


                                                        <div class="formcon">
                                                            <div class="yuzde30"><?php echo __("admin/products/add-new-product-header-background"); ?>
                                                                <br><span class="kinfo"><?php echo __("admin/products/add-new-product-header-background-desc"); ?></span>
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

                                                        <div class="formcon">
                                                            <div class="yuzde30"><?php echo __("admin/products/add-new-product-list-image"); ?>
                                                                <div class="clear"></div>
                                                                <span class="kinfo"><?php echo __("admin/products/add-new-product-list-image-desc"); ?></span>
                                                            </div>
                                                            <div class="yuzde70">
                                                                <div class="headerbgedit">
                                                                    <input type="file" name="list_image" id="list_image" style="display:none;" onchange="read_image_file(this,'list_image_preview');" data-default-image="<?php echo $getListImageDeft; ?>" />
                                                                    <div class="headbgeditbtn">
                                                                        <a href="javascript:$('#list_image').val('').trigger('change');void 0;" class="photosil"><i class="fa fa-trash"></i></a><br/>
                                                                        <a class="avatarguncelle" href="javascript:void(0);" onclick="$('#list_image').click();" ><i class="fa fa-camera" aria-hidden="true"></i></a>
                                                                    </div>
                                                                    <img src="<?php echo $getListImageDeft; ?>" style="    height: 130px;    width: 170px;" width="100%" id="list_image_preview">
                                                                </div>

                                                            </div>
                                                        </div>

                                                        <div class="formcon">
                                                            <div class="yuzde30"><?php echo __("admin/products/add-new-product-mockup-image"); ?>
                                                                <div class="clear"></div>
                                                                <span class="kinfo"><?php echo __("admin/products/add-new-product-mockup-image-desc"); ?></span>
                                                            </div>
                                                            <div class="yuzde70">
                                                                <div class="headerbgedit">
                                                                    <input type="file" name="mockup_image" id="mockup_image" style="display:none;" onchange="read_image_file(this,'mockup_image_preview');" data-default-image="<?php echo $getMockupImageDeft; ?>" />
                                                                    <div class="headbgeditbtn">
                                                                        <a href="javascript:$('#mockup_image').val('').trigger('change');void 0;" class="photosil"><i class="fa fa-trash"></i></a><br/>
                                                                        <a class="avatarguncelle" href="javascript:void(0);" onclick="$('#mockup_image').click();" ><i class="fa fa-camera" aria-hidden="true"></i></a>
                                                                    </div>
                                                                    <img src="<?php echo $getMockupImageDeft; ?>" width="100%" id="mockup_image_preview">
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>


                                                <h3><?php echo __("admin/products/add-new-product-software-tab-feature-blocks"); ?></h3>
                                                <div>
                                                    <div class="formcon">

                                                        <?php echo __("admin/products/add-new-product-feature-blocks"); ?>
                                                        <ul id="blocks_<?php echo $lkey; ?>" class="software-blocks-sortable" style="display:block;margin:0;">
                                                            <li>
                                                                <div class="delmovebtns">
                                                                    <a class="bearer" style="cursor: move;"><i class="fa fa-arrows-alt"></i></a>
                                                                    <a class="delete-block-item" style="cursor:pointer;"><i class="fa fa-trash"></i></a>
                                                                </div>
                                                                <input class="yuzde15" name="feature-block[<?php echo $lkey; ?>][icon][]" type="text" placeholder="<?php echo __("admin/products/add-new-product-feature-block-icon"); ?>"> -
                                                                <input class="yuzde25" name="feature-block[<?php echo $lkey; ?>][title][]" type="text" placeholder="<?php echo __("admin/products/add-new-product-feature-block-title"); ?>"> -
                                                                <input class="yuzde25" name="feature-block[<?php echo $lkey; ?>][description][]" type="text" placeholder="<?php echo __("admin/products/add-new-product-feature-block-description"); ?>"> -
                                                                <input class="yuzde20" name="feature-block[<?php echo $lkey; ?>][detailed-description][]" type="text" placeholder="<?php echo __("admin/products/add-new-product-feature-block-detailed-description"); ?>">
                                                            </li>
                                                        </ul>
                                                        <div class="clear"></div>
                                                        <a href="javascript:add_block('<?php echo $lkey; ?>');void 0;" style="margin-top:5px;" class="lbtn">+ <?php echo __("admin/products/add-new-product-add-feature-block"); ?></a>
                                                    </div>
                                                </div>

                                                <?php if($lang["local"]): ?>
                                                    <h3><?php echo __("admin/products/add-new-product-software-tab-other-settings"); ?></h3>
                                                    <div>

                                                        <div class="formcon">
                                                            <div class="yuzde30"><?php echo __("admin/products/renewal-selection-hide"); ?></div>
                                                            <div class="yuzde70">
                                                                <input type="checkbox" name="renewal_selection_hide" value="1" id="renewal-selection-hide" class="checkbox-custom">
                                                                <label class="checkbox-custom-label" for="renewal-selection-hide">
                                                                    <span class="kinfo"><?php echo __("admin/products/renewal-selection-hide-desc"); ?></span>
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="formcon">
                                                            <div class="yuzde30">
                                                                <?php echo __("admin/products/add-new-product-affiliate"); ?>
                                                            </div>
                                                            <div class="yuzde70">

                                                                <div class="formcon">
                                                                    <strong style="width: 20%; display:inline-block;"><?php echo __("admin/products/add-new-product-affiliate-disable"); ?></strong>

                                                                    <input type="checkbox" class="checkbox-custom" id="affiliate-disable" name="affiliate_disable" value="1">
                                                                    <label class="checkbox-custom-label" for="affiliate-disable"><span class="kinfo"><?php echo __("admin/products/add-new-product-affiliate-disable-desc"); ?></span></label>
                                                                </div>

                                                                <div class="formcon">
                                                                    <strong style="width: 20%; display:inline-block;"><?php echo __("admin/products/add-new-product-affiliate-commission-rate"); ?></strong>
                                                                    <input type="text" name="affiliate_rate" value="" class="yuzde10" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57'>
                                                                    <span class="kinfo"><?php echo __("admin/products/add-new-product-affiliate-commission-rate-desc"); ?></span>
                                                                </div>


                                                            </div>
                                                        </div>

                                                        <div class="formcon" style="<?php echo !Config::get("options/ctoc-service-transfer/status") ? 'display:none;' : ''; ?>">
                                                            <div class="yuzde30"><?php echo __("admin/products/add-new-product-ctoc-service-transfer"); ?></div>
                                                            <div class="yuzde70">
                                                                <input type="checkbox" name="ctoc-service-transfer" value="1" id="ctoc-service-transfer" class="checkbox-custom" onchange="if($(this).prop('checked')) $('#ctoc-service-transfer-wrap').css('display','block'); else $('#ctoc-service-transfer-wrap').css('display','none');">
                                                                <label class="checkbox-custom-label" for="ctoc-service-transfer"><span class="kinfo"><?php echo __("admin/products/add-new-product-ctoc-service-transfer-desc"); ?></span></label>

                                                                <div class="clear"></div>
                                                                <div id="ctoc-service-transfer-wrap" style="display:none;">
                                                                    <div class="formcon">
                                                                        <div class="yuzde30" style="width: 50px;"><?php echo __("admin/products/add-new-product-limit"); ?></div>
                                                                        <div class="yuzde70">
                                                                            <input type="text" style="width: 10%;" name="ctoc-service-transfer-limit" value="">
                                                                            <span class="kinfo"><?php echo __("admin/products/add-new-product-limit-ctoc-service-transfer"); ?></span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>



                                                        <div class="formcon">
                                                            <div class="yuzde30"><?php echo __("admin/products/add-new-product-change-domain"); ?></div>
                                                            <div class="yuzde70">

                                                                <input id="change-domain" type="checkbox" name="change-domain" value="1" class="sitemio-checkbox">
                                                                <label for="change-domain" class="sitemio-checkbox-label"></label>
                                                                <span class="kinfo"><?php echo __("admin/products/add-new-product-change-domain-desc"); ?></span>

                                                            </div>
                                                        </div>


                                                        <div class="formcon">
                                                            <div class="yuzde30"><?php echo __("admin/products/add-new-product-invisible"); ?></div>
                                                            <div class="yuzde70">

                                                                <input id="invisibility" type="checkbox" name="invisibility" value="1" class="sitemio-checkbox">
                                                                <label for="invisibility" class="sitemio-checkbox-label"></label>
                                                                <span class="kinfo"><?php echo __("admin/products/add-new-product-invisible-desc"); ?></span>

                                                            </div>
                                                        </div>

                                                        <div class="formcon">
                                                            <div class="yuzde30"><?php echo __("admin/products/add-new-product-notes"); ?></div>
                                                            <div class="yuzde70">
                                                                <textarea name="notes" rows="5" placeholder="<?php echo __("admin/products/add-new-product-notes-ex"); ?>"></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="formcon">
                                                            <div class="yuzde30"><?php echo __("admin/products/add-new-product-buy-external-link"); ?></div>
                                                            <div class="yuzde70">
                                                                <input name="external_link" type="text" placeholder="http://www.example.com/buylink.html">
                                                                <br><span class="kinfo"><?php echo __("admin/products/add-new-product-buy-external-link-desc"); ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>


                                            </div>



                                            <div class="clear"></div>
                                            <br>

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

                    </div><!-- detail tab content end -->


                    <div id="settings-optional-addons" class="tabcontent"><!-- tab content start -->
                        <div class="blur-text" style="display:none;">
                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                            <div class="clear"></div>
                            <?php echo __("admin/products/add-new-product-blur-text"); ?>
                        </div>

                        <div class="adminpagecon">


                            <div class="green-info">
                                <div class="padding15">
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                    <?php echo __("admin/products/add-new-product-addons-desc"); ?>
                                </div>
                            </div><br><br>

                            <script type="text/javascript">
                                function allof_addons(id,element){
                                    var checked = $(element).prop('checked');

                                    if(checked){
                                        $('#category_'+id+' .addon-item')
                                            .prop('checked',true)
                                            .each(function(){
                                                $(this).trigger("change");
                                            });
                                        $('label[for=category_'+id+'_allof],#category_'+id+' label').css('opacity',1);

                                    }else{
                                        $('#category_'+id+' .addon-item')
                                            .prop('checked',false)
                                            .each(function(){
                                                $(this).trigger("change");
                                            });
                                        $('label[for=category_'+id+'_allof],#category_'+id+' label')
                                            .css('opacity',0.7);
                                    }
                                }
                                function auto_select_requirements(ids,element){
                                    var split,checked = $(element).prop("checked");
                                    ids += ",";
                                    split = ids.split(",");
                                    $(split).each(function(k,v){
                                        if(v != ''){
                                            //$("#requirement_"+v).prop("checked",checked).trigger("change");
                                        }
                                    });
                                }
                            </script>

                            <ul class="addons-categories">
                                <?php
                                    $get_addons = $functions["get_addons_with_category"];
                                    if(isset($addon_categories) && $addon_categories){
                                        foreach($addon_categories AS $category){
                                            $addons = $get_addons($category["id"]);
                                            if($addons){
                                                ?>
                                                <li style="border-bottom:solid 1px #eee;padding:10px;" id="category_<?php echo $category["id"]; ?>">
                                                    <input onchange="allof_addons(<?php echo $category["id"]; ?>,this)" type="checkbox" class="allOf-trigger checkbox-custom" id="category_<?php echo $category["id"]; ?>_allof">
                                                    <label for="category_<?php echo $category["id"]; ?>_allof" class="checkbox-custom-label" style="font-weight: bold; opacity:0.7;"><?php echo $category["name"]; ?></label>
                                                    <div class="clear"></div>
                                                    <div class="padding10">
                                                        <ul class="addons" id="category_<?php echo $category["id"]; ?>_addons">
                                                            <?php
                                                                foreach ($addons AS $addon){
                                                                    $desc = $addon["description"] ? '('.$addon["description"].')' : '';
                                                                    ?>
                                                                    <li>
                                                                        <input onchange="auto_select_requirements('<?php echo $addon["requirements"]; ?>',this); if($('#category_<?php echo $category["id"]; ?>_addons input:not(:checked)').length==0) $('#category_<?php echo $category["id"]; ?>_allof').prop('checked',true),$('label[for=category_<?php echo $category["id"]; ?>_allof]').css('opacity',1); else $('#category_<?php echo $category["id"]; ?>_allof').prop('checked',false),$('label[for=category_<?php echo $category["id"]; ?>_allof]').css('opacity',0.7); if($(this).prop('checked')) $('label[for=addon_<?php echo $addon["id"]; ?>]').css('opacity',1); else $('label[for=addon_<?php echo $addon["id"]; ?>]').css('opacity',0.7);" type="checkbox" class="addon-item checkbox-custom" id="addon_<?php echo $addon["id"]; ?>" name="addons[]" value="<?php echo $addon["id"]; ?>">
                                                                        <label for="addon_<?php echo $addon["id"]; ?>" class="checkbox-custom-label" style="font-weight: 600; opacity:0.7;"><?php echo $addon["name"]; ?> <span style="font-weight:normal;"><?php echo $desc; ?></span></label>
                                                                    </li>
                                                                    <?php
                                                                }
                                                            ?>
                                                        </ul>
                                                    </div>
                                                    <div class="clear"></div>
                                                </li>
                                                <?php

                                            }
                                        }
                                    }
                                ?>
                            </ul>
                            <div class="clear"></div>

                            <a href="<?php echo $links["add-new-addon"]."?mcategory=software"; ?>" class="lbtn">+ <?php echo __("admin/products/add-new-addon"); ?></a>

                        </div>

                        <div class="clear"></div>
                    </div><!-- tab content end -->


                    <div id="settings-requirements" class="tabcontent"><!-- tab content start -->
                        <div class="blur-text" style="display:none;">
                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                            <div class="clear"></div>
                            <?php echo __("admin/products/add-new-product-blur-text"); ?>
                        </div>

                        <div class="adminpagecon">


                            <div class="green-info">
                                <div class="padding15">
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                    <?php echo __("admin/products/add-new-product-requirements-desc"); ?>
                                </div>
                            </div><br><br>



                            <ul class="requirements-categories">
                                <?php
                                    $get_requirements = $functions["get_requirements_with_category"];
                                    if(isset($requirement_categories) && $requirement_categories){
                                        foreach($requirement_categories AS $category){
                                            $requirements = $get_requirements($category["id"]);
                                            if($requirements){

                                                ?>
                                                <li style="border-bottom:solid 1px #eee;padding:10px;" id="category_<?php echo $category["id"]; ?>">
                                                    <input onchange="if($(this).prop('checked')) $('#category_<?php echo $category["id"]; ?> input').prop('checked',true),$('label[for=category_<?php echo $category["id"]; ?>_allof],#category_<?php echo $category["id"]; ?> label').css('opacity',1); else $('#category_<?php echo $category["id"]; ?> input').prop('checked',false),$('label[for=category_<?php echo $category["id"]; ?>_allof],#category_<?php echo $category["id"]; ?> label').css('opacity',0.7);" type="checkbox" class="allOf-trigger checkbox-custom" id="category_<?php echo $category["id"]; ?>_allof">
                                                    <label for="category_<?php echo $category["id"]; ?>_allof" class="checkbox-custom-label" style="font-weight: bold; opacity:0.7;"><?php echo $category["name"]; ?></label>
                                                    <div class="clear"></div>
                                                    <div class="padding10">
                                                        <ul class="requirements" id="category_<?php echo $category["id"]; ?>_requirements">
                                                            <?php
                                                                foreach ($requirements AS $requirement){
                                                                    $desc = $requirement["description"] ? '('.$requirement["description"].')' : '';
                                                                    ?>
                                                                    <li>
                                                                        <input onchange="if($('#category_<?php echo $category["id"]; ?>_requirements input:not(:checked)').length==0) $('#category_<?php echo $category["id"]; ?>_allof').prop('checked',true),$('label[for=category_<?php echo $category["id"]; ?>_allof]').css('opacity',1); else $('#category_<?php echo $category["id"]; ?>_allof').prop('checked',false),$('label[for=category_<?php echo $category["id"]; ?>_allof]').css('opacity',0.7); if($(this).prop('checked')) $('label[for=requirement_<?php echo $requirement["id"]; ?>]').css('opacity',1); else $('label[for=requirement_<?php echo $requirement["id"]; ?>]').css('opacity',0.7);" type="checkbox" class="checkbox-custom" id="requirement_<?php echo $requirement["id"]; ?>" name="requirements[]" value="<?php echo $requirement["id"]; ?>">
                                                                        <label for="requirement_<?php echo $requirement["id"]; ?>" class="checkbox-custom-label" style="font-weight: 600; opacity:0.7;"><?php echo $requirement["name"]; ?> <span style="font-weight:normal;"><?php echo $desc; ?></span></label>
                                                                    </li>
                                                                    <?php
                                                                }
                                                            ?>
                                                        </ul>
                                                    </div>
                                                    <div class="clear"></div>
                                                </li>
                                                <?php

                                            }
                                        }
                                    }
                                ?>
                            </ul>
                            <div class="clear"></div>

                            <a href="<?php echo $links["add-new-requirement"]."?mcategory=software"; ?>" class="lbtn">+ <?php echo __("admin/products/add-new-requirement"); ?></a>

                        </div>

                        <div class="clear"></div>
                    </div><!-- tab content end -->


                    <div id="settings-pricing" class="tabcontent"><!-- tab content start -->
                        <div class="blur-text" style="display:none;">
                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                            <div class="clear"></div>
                            <?php echo __("admin/products/add-new-product-blur-text"); ?>
                        </div>

                        <div class="adminpagecon">

                            <div class="green-info">
                                <div class="padding15">
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                    <?php echo __("admin/products/add-new-product-pricing-desc"); ?>
                                </div>
                            </div><br><br>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/products/add-new-product-pricing"); ?></div>
                                <div class="clear"></div>
                                <div id="bigmobil">

                                    <div class="middle" style="line-height:45px;">
                                        <script type="text/javascript">
                                            $(document).ready(function(){
                                                $("#pricing-list").sortable({
                                                    handle:'.period-bearer',
                                                }).disableSelection();

                                                $("#pricing-list").on("click",".period-delete",function(){
                                                    $(this).parent().remove();
                                                    $("#pricing-list").sortable("refresh");
                                                });

                                            });

                                            function addPeriod(){
                                                var template = $("#price-item-template").html();

                                                $("#pricing-list").append(template);
                                                $("#pricing-list").sortable("refresh");

                                            }
                                        </script>
                                        <ul id="pricing-list" style="padding:0;margin:0;">

                                            <li style="padding:0; margin:0;">
                                                <input style="width:140px;" name="prices[time][]" type="text" placeholder="<?php echo __("admin/products/add-new-product-period-time"); ?>"> -
                                                <select style="width:140px;" name="prices[period][]">
                                                    <?php
                                                        foreach(___("date/periods") AS $k=>$v){
                                                            ?>
                                                            <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                                            <?php
                                                        }
                                                    ?>
                                                </select> -
                                                <input style="width:140px;" name="prices[amount][]" type="text" placeholder="<?php echo __("admin/products/add-new-product-period-amount"); ?>"> -
                                                <select style="width:140px;" name="prices[cid][]">
                                                    <?php
                                                        foreach(Money::getCurrencies() AS $currency){
                                                            ?>
                                                            <option value="<?php echo $currency["id"]; ?>"><?php echo $currency["name"]." (".$currency["code"].")"; ?></option>
                                                            <?php
                                                        }
                                                    ?>
                                                </select> -
                                                <span style="margin-right:20px;"><?php echo __("admin/products/add-new-product-period-discount",[
                                                        '{input}' => '<input style="width:70px;"  name="prices[discount][]" type="text" placeholder="'.__("admin/products/add-new-product-period-discount-placeholder").'" onkeypress="return event.charCode>= 48 &&event.charCode<= 57">',
                                                    ]); ?></span>
                                                <a style="line-height:normal;    padding: 7px 3px;" href="javascript:void(0);" class="sbtn period-bearer"><i class="fa fa-arrows-alt"></i></a>
                                                <a style="line-height:normal;    padding: 7px 3px;" href="javascript:void(0);" class="red sbtn period-delete"><i class="fa fa-trash"></i></a>
                                                <div class="clear"></div>
                                            </li>

                                        </ul>


                                    </div>
                                    <span class="kinfo"><?php echo __("admin/products/add-new-product-pricing-note"); ?></span>
                                    <div class="clear"></div>
                                    <br>
                                    <input type="checkbox" name="override_usrcurrency" value="1" class="checkbox-custom" id="override_usrcurrency">
                                    <label class="checkbox-custom-label" for="override_usrcurrency"><?php echo __("admin/products/override-user-currency"); ?> <span class="kinfo"><?php echo __("admin/products/override-user-currency-desc"); ?></span></label>

                                    <br>
                                    <input type="checkbox" name="taxexempt" value="1" class="checkbox-custom" id="taxexempt">
                                    <label class="checkbox-custom-label" for="taxexempt"><?php echo __("admin/products/taxexempt"); ?> <span class="kinfo"><?php echo __("admin/products/taxexempt-desc"); ?></span></label>

                                    <div class="clear"></div>

                                    <a href="javascript:addPeriod();void 0;" style="margin-top:15px;" class="lbtn">+ <?php echo __("admin/products/add-new-product-add-new-period"); ?></a>
                                </div>
                            </div>

                            <div class="clear"></div>
                        </div>

                        <div class="clear"></div>
                    </div><!-- tab content end -->

                    <div id="settings-license" class="tabcontent"><!-- tab content start -->

                        <div class="blur-text">
                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                            <div class="clear"></div>
                            <?php echo __("admin/products/add-new-product-license-note"); ?>
                        </div>

                        <div class="adminpagecon tab-blur-content">

                            <div class="green-info">
                                <div class="padding15">
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                    <?php echo __("admin/products/product-license-desc"); ?>
                                </div>
                            </div>
                            <br>
                            <br>
                            <br>


                            <div class="clear"></div>
                        </div>

                        <div class="clear"></div>
                    </div><!-- tab content end -->


                </div><!-- tab wrap content end -->


                <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                    <a class="yesilbtn gonderbtn" id="addNewForm_submit" href="javascript:void(0);"><?php echo __("admin/products/new-hosting-product-button"); ?></a>
                </div>
                <div class="clear"></div>
            </form>

            <ul id="price-item-template" style="display: none;">
                <li style="padding:0; margin:0;">
                    <input style="width:140px;" name="prices[time][]" type="text" placeholder="<?php echo __("admin/products/add-new-product-period-time"); ?>"> -
                    <select style="width:140px;" name="prices[period][]">
                        <?php
                            foreach(___("date/periods") AS $k=>$v){
                                ?>
                                <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                <?php
                            }
                        ?>
                    </select> -
                    <input style="width:140px;" name="prices[amount][]" type="text" placeholder="<?php echo __("admin/products/add-new-product-period-amount"); ?>"> -
                    <select style="width:140px;" name="prices[cid][]">
                        <?php
                            foreach(Money::getCurrencies() AS $currency){
                                ?>
                                <option value="<?php echo $currency["id"]; ?>"><?php echo $currency["name"]." (".$currency["code"].")"; ?></option>
                                <?php
                            }
                        ?>
                    </select> -
                    <span style="margin-right:20px;"> <?php echo __("admin/products/add-new-product-period-discount",[
                            '{input}' => '<input style="width:70px;"  name="prices[discount][]" type="text" placeholder="'.__("admin/products/add-new-product-period-discount-placeholder").'" onkeypress="return event.charCode>= 48 &&event.charCode<= 57">',
                        ]); ?></span>
                    <a style="line-height:normal;    padding: 7px 3px;" href="javascript:void(0);" class="sbtn period-bearer"><i class="fa fa-arrows-alt"></i></a>
                    <a style="line-height:normal;    padding: 7px 3px;" href="javascript:void(0);" class="red sbtn period-delete"><i class="fa fa-trash"></i></a>
                    <div class="clear"></div>
                </li>
            </ul>


            <div class="clear"></div>
        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>