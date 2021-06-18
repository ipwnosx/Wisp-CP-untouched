<!DOCTYPE html>
<html>
<head>
    <?php
        $status         = $product["status"];
        $categoryy      = $product["category"];
        $pcategories    = explode(",",$product["categories"]);
        $rank           = $product["rank"];
        $invisibility   = $product["visibility"] == "visible" ? 0 : 1;
        $options        = $product["options"] ? Utility::jdecode($product["options"],true) : [];
        $popular        = isset($options["popular"]) && $options["popular"] ? $options["popular"] : false;
        $change_domain  = isset($options["change-domain"]) && $options["change-domain"] ? $options["change-domain"] : false;
        $ctoc_s_t       = false;
        $ctoc_s_t_l     = false;
        if(isset($options["ctoc-service-transfer"])){
            $ctoc_s_t       = $options["ctoc-service-transfer"]["status"];
            $ctoc_s_t_l     = $options["ctoc-service-transfer"]["limit"];
        }
        $external_link  = isset($options["external_link"]) && $options["external_link"] ? $options["external_link"] : false;
        $download_file  = isset($options["download_file"]) ? $options["download_file"] : false;
        if($download_file)
            $download_file  = Controllers::$init->AdminCRLink("download-id",["software-product",$product["id"]]);
        $demo_link          = isset($options["demo_link"]) ? $options["demo_link"] : false;
        $demo_admin_link    = isset($options["demo_admin_link"]) ? $options["demo_admin_link"] : false;
        $download_link      = isset($options["download_link"]) ? $options["download_link"] : false;
        $auto_approval      = isset($options["auto_approval"]) ? $options["auto_approval"] : false;
        $hide_domain        = isset($options["hide_domain"]) ? $options["hide_domain"] : false;
        $hide_hosting       = isset($options["hide_hosting"]) ? $options["hide_hosting"] : false;
        $buy_link       = Controllers::$init->CRLink("order-steps",["software",$product["id"]]);
        $notes          = $product["notes"];
        $paddons         = $product["addons"];
        $prequirements   = $product["requirements"];
        $r_s_h           = isset($options["renewal_selection_hide"]) && $options["renewal_selection_hide"];

        if(!$getHeaderBackground) $getHeaderBackground = $getHeaderBackgroundDeft;
        if(!$getListImage) $getListImage = $getListImageDeft;
        if(!$getMockupImage) $getMockupImage = $getMockupImageDeft;
        if(!$getMockupImage) $getMockupImage = $getMockupImageDeft;
        if(!$getOrderImage) $getOrderImage = $getOrderImageDeft;

        Utility::sksort($lang_list,"local");
        $plugins    = ['jquery-ui','tinymce-1','highlightjs','voucher_codes'];
        include __DIR__.DS."inc".DS."head.php";

        $checking_link   = APP_URI."/license/checking/".$token."/".$product["id"];
        $license_error_link = APP_URI."/license/error";


    ?>

    <script type="text/javascript">
        $(document).ready(function(){

            external_link_trigger();

            $("input[name=external_link]").change(external_link_trigger);

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

            /*$("#editForm").bind("keypress", function(e) {
                if (e.keyCode == 13) $("#editForm_submit").click();
            });*/

            $(".software-blocks-sortable").sortable({
                handle:".bearer",
            }).disableSelection();

            $(".software-blocks-sortable").on("click",".delete-block-item",function(){
                var elem = $(this).parent().parent();
                elem.remove();
                $(".software-blocks-sortable").sortable("refresh");
            });

            $("#editForm_submit").on("click",function(){
                MioAjaxElement($(this),{
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                    result:"editForm_handler",
                });
            });

            $(".accordion").accordion({
                heightStyle: "content"
            });

        });

        function external_link_trigger(){
            var value = $('input[name=external_link]').val();
            if(value){
                $("#settings-informations .adminpagecon,#settings-pricing .adminpagecon,#settings-optional-addons .adminpagecon,#settings-requirements .adminpagecon").addClass("tab-blur-content");
                $(".blur-text").fadeIn(100);
            }else{
                $("#settings-informations .adminpagecon,#settings-pricing .adminpagecon,#settings-optional-addons .adminpagecon,#settings-requirements .adminpagecon").removeClass("tab-blur-content");
                $(".blur-text").fadeOut(100);
            }

        }

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
                data:{
                    operation:"delete_product_hbackground",
                    id:<?php echo $product["id"]; ?>
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

        function listimg_delete(){
            $("#list_image").val('');
            $("#list_image_preview").attr("src","<?php echo $getListImageDeft; ?>");

            var request = MioAjax({
                action:"<?php echo $links["controller"]; ?>",
                method:"POST",
                data:{
                    operation:"delete_product_cover",
                    id:<?php echo $product["id"]; ?>
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

        function mockup_delete(){
            $("#mockup_image").val('');
            $("#mockup_image_preview").attr("src","<?php echo $getMockupImageDeft; ?>");

            var request = MioAjax({
                action:"<?php echo $links["controller"]; ?>",
                method:"POST",
                data:{
                    operation:"delete_product_mockup",
                    id:<?php echo $product["id"]; ?>
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

        function delete_download_file(){
            $("#download-file").val('');
            $("#download-file-button").css("display","none");
            $("#download-file-click").remove();

            var request = MioAjax({
                action:"<?php echo $links["controller"]; ?>",
                method:"POST",
                data:{
                    operation:"delete_product_download_file",
                    id:<?php echo $product["id"]; ?>,
                    type:'products'
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

        function orderimg_delete(){
            $("#order_image").val('');
            $("#order_image_preview").attr("src","<?php echo $getOrderImageDeft; ?>");

            var request = MioAjax({
                action:"<?php echo $links["controller"]; ?>",
                method:"POST",
                data:{
                    operation:"delete_product_order_image",
                    id:<?php echo $product["id"]; ?>
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

</head>
<body>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1><strong><?php echo __("admin/products/page-edit-software"); ?></strong></h1>
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

            <form action="<?php echo $links["controller"]; ?>" method="post" id="editForm" style="margin-top: 5px;">
                <input type="hidden" name="operation" value="edit_software">

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
                                $get_productl = $functions["get_product_with_lang"];
                                foreach($lang_list AS $lang) {
                                    $lkey = $lang["key"];
                                    $productl = $get_productl($lkey);
                                    if(!$productl) $productl = [];
                                    $title      = isset($productl["title"]) ? $productl["title"] : false;
                                    $route      = isset($productl["route"]) ? $productl["route"] : false;
                                    $optionsl   = isset($productl["options"]) ? Utility::jdecode($productl["options"],true) : [];
                                    $tag1       = isset($optionsl["tag1"]) ? $optionsl["tag1"] : false;
                                    $tag2       = isset($optionsl["tag2"]) ? $optionsl["tag2"] : false;
                                    $short_features = isset($optionsl["short_features"]) ? $optionsl["short_features"] : false;
                                    $requirementsx = isset($optionsl["requirements"]) ? $optionsl["requirements"] : false;
                                    $installation_instructions = isset($optionsl["installation_instructions"]) ? $optionsl["installation_instructions"] : false;
                                    $content    = isset($productl["content"]) ? $productl["content"] : false;
                                    $versions   = isset($optionsl["versions"]) ? $optionsl["versions"] : false;
                                    $feature_blocks = isset($optionsl["feature_blocks"]) ? $optionsl["feature_blocks"] : [];
                                    $seo_title  = isset($productl["seo_title"]) ? $productl["seo_title"] : false;
                                    $seo_keywords  = isset($productl["seo_keywords"]) ? $productl["seo_keywords"] : false;
                                    $seo_description  = isset($productl["seo_description"]) ? $productl["seo_description"] : false;
                                    ?>
                                    <div id="lang-<?php echo $lkey; ?>" class="tabcontent">

                                        <div class="adminpageconxx">

                                            <div class="accordion">
                                                <h3><?php echo __("admin/products/add-new-product-software-tab-general"); ?></h3>
                                                <div>

                                                    <div class="formcon">
                                                        <div class="yuzde30"><?php echo __("admin/products/add-new-category-title"); ?></div>
                                                        <div class="yuzde70">
                                                            <input name="title[<?php echo $lkey; ?>]" type="text" placeholder="" onchange="check_route('<?php echo $lkey; ?>',true);" onkeyup="$('input[name=\'route[<?php echo $lkey; ?>]\']').val(convertToSlug(this.value));" value="<?php echo $title; ?>">
                                                        </div>
                                                    </div>

                                                    <?php if(___("package/permalink",false,$lkey)): ?>
                                                        <div class="formcon" id="permalink-wrap-<?php echo $lkey; ?>" style="display: none;">
                                                            <div class="yuzde30"><?php echo __("admin/products/permalink"); ?></div>
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
                                                            <div class="yuzde30"><?php echo __("admin/products/add-new-product-demo-link"); ?></div>
                                                            <div class="yuzde70">
                                                                <input type="text" name="demo-link" value="<?php echo $demo_link; ?>">
                                                            </div>
                                                        </div>

                                                        <div class="formcon">
                                                            <div class="yuzde30"><?php echo __("admin/products/add-new-product-demo-admin-link"); ?></div>
                                                            <div class="yuzde70">
                                                                <input type="text" name="demo-admin-link" value="<?php echo $demo_admin_link; ?>">
                                                            </div>
                                                        </div>


                                                        <div class="formcon">
                                                            <div class="yuzde30"><?php echo __("admin/products/add-new-product-download-file"); ?></div>
                                                            <div class="yuzde70">

                                                                <input id="download-file" type="file" name="download-file" onchange="if($(this).val() == '') $('#download-file-button').hide(1); else $('#download-file-button').show(1); ">
                                                                <div id="download-file-button" style="<?php echo $download_file ? '' : 'display: none;'; ?>">
                                                                    <?php if($download_file): ?>
                                                                        <a id="download-file-click" href="<?php echo $download_file; ?>" target="_blank" class="blue sbtn"><i class="fa fa-download" aria-hidden="true"></i></a>
                                                                    <?php endif; ?>
                                                                    <a href="javascript:delete_download_file();void 0;" class="red sbtn"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                                </div>
                                                                <div class="clear"></div>
                                                                <span class="kinfo"><?php echo __("admin/products/add-new-product-download-file-desc"); ?></span>

                                                            </div>
                                                        </div>

                                                        <div class="formcon">
                                                            <div class="yuzde30"><?php echo __("admin/products/add-new-product-download-link"); ?></div>
                                                            <div class="yuzde70">
                                                                <input type="text" name="download-link" value="<?php echo $download_link; ?>">
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
                                                                                <option<?php echo $category["id"] == $categoryy || in_array($category["id"],$pcategories) ? ' selected' : ''; ?> value="<?php echo $category["id"]; ?>"><?php echo $category["title"]; ?></option>
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
                                                                    <option<?php echo $status == "active" ? ' selected' : ''; ?> value="active"><?php echo __("admin/products/status-active"); ?></option>
                                                                    <option<?php echo $status == "inactive" ? ' selected' : ''; ?> value="inactive"><?php echo __("admin/products/status-inactive"); ?></option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="formcon">
                                                            <div class="yuzde30"><?php echo __("admin/products/add-new-product-popular"); ?></div>
                                                            <div class="yuzde70">
                                                                <input<?php echo $popular ? ' checked' : ''; ?> type="checkbox" name="popular" value="1" class="checkbox-custom" id="popular">
                                                                <label class="checkbox-custom-label" for="popular"><?php echo __("admin/products/add-new-product-popular-label"); ?></label>
                                                            </div>
                                                        </div>


                                                        <div class="formcon">
                                                            <div class="yuzde30"><?php echo __("admin/products/add-new-product-rank"); ?></div>
                                                            <div class="yuzde70">
                                                                <input type="text" name="rank" value="<?php echo $rank; ?>" class="yuzde10">
                                                            </div>
                                                        </div>

                                                        <div class="formcon">
                                                            <div class="yuzde30"><?php echo __("admin/products/add-new-product-auto-approval"); ?></div>
                                                            <div class="yuzde70">

                                                                <input<?php echo $auto_approval ? ' checked' : ''; ?> id="auto-approval" type="checkbox" name="auto-approval" value="1" class="sitemio-checkbox">
                                                                <label for="auto-approval" class="sitemio-checkbox-label"></label>
                                                                <span class="kinfo"><?php echo __("admin/products/add-new-product-auto-approval-desc"); ?></span>

                                                            </div>
                                                        </div>

                                                        <div class="formcon">
                                                            <div class="yuzde30"><?php echo __("admin/products/add-new-product-hide-domain"); ?></div>
                                                            <div class="yuzde70">

                                                                <input<?php echo $hide_domain ? ' checked' : ''; ?> id="hide-domain" type="checkbox" name="hide-domain" value="1" class="checkbox-custom">
                                                                <label for="hide-domain" class="checkbox-custom-label">
                                                                    <span class="kinfo"><?php echo __("admin/products/add-new-product-hide-domain-desc"); ?></span>
                                                                </label>

                                                            </div>
                                                        </div>
                                                        <div class="formcon">
                                                            <div class="yuzde30"><?php echo __("admin/products/add-new-product-hide-hosting"); ?></div>
                                                            <div class="yuzde70">

                                                                <input<?php echo $hide_hosting ? ' checked' : ''; ?> id="hide-hosting" type="checkbox" name="hide-hosting" value="1" class="checkbox-custom">
                                                                <label for="hide-hosting" class="checkbox-custom-label">
                                                                    <span class="kinfo"><?php echo __("admin/products/add-new-product-hide-hosting-desc"); ?></span>
                                                                </label>

                                                            </div>
                                                        </div>

                                                    <?php endif; ?>

                                                    <div class="formcon">
                                                        <div class="yuzde30"><?php echo __("admin/products/add-new-product-tag1"); ?></div>
                                                        <div class="yuzde70">
                                                            <input type="text" name="tag1[<?php echo $lkey; ?>]" value="<?php echo $tag1; ?>" placeholder="<?php echo __("admin/products/add-new-product-tag1-pr"); ?>">
                                                        </div>
                                                    </div>

                                                    <div class="formcon">
                                                        <div class="yuzde30"><?php echo __("admin/products/add-new-product-tag2"); ?></div>
                                                        <div class="yuzde70">
                                                            <input type="text" name="tag2[<?php echo $lkey; ?>]" value="<?php echo $tag2; ?>" placeholder="<?php echo __("admin/products/add-new-product-tag2-pr"); ?>">
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
                                                            <textarea name="short-features[<?php echo $lkey; ?>]" rows="3" placeholder=""><?php echo $short_features; ?></textarea>
                                                        </div>
                                                    </div>


                                                    <div class="formcon">
                                                        <div class="yuzde30"><?php echo __("admin/products/add-new-product-software-requirements"); ?>
                                                            <br><span class="kinfo"><?php echo __("admin/products/add-new-product-software-requirements-desc"); ?></span>
                                                        </div>
                                                        <div class="yuzde70">
                                                            <textarea  name="requirement[<?php echo $lkey; ?>]" rows="3" placeholder=""><?php echo $requirementsx; ?></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="formcon">
                                                        <div class="yuzde30"><?php echo __("admin/products/add-new-product-content"); ?>
                                                            <br><span class="kinfo"><?php echo __("admin/products/add-new-product-content-pr"); ?></span></div>
                                                        <div class="yuzde70">
                                                            <textarea class="tinymce-1" name="content[<?php echo $lkey; ?>]" rows="3" placeholder=""><?php echo $content; ?></textarea>
                                                        </div>
                                                    </div>



                                                    <div class="formcon">
                                                        <div class="yuzde30"><?php echo __("admin/products/add-new-product-installation-instructions"); ?>
                                                            <br><span class="kinfo"><?php echo __("admin/products/add-new-product-installation-instructions-desc"); ?></span>
                                                        </div>
                                                        <div class="yuzde70">
                                                            <textarea class="tinymce-1" name="installation-instructions[<?php echo $lkey; ?>]" rows="3"><?php echo $installation_instructions; ?></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="formcon">
                                                        <div class="yuzde30"><?php echo __("admin/products/add-new-product-versions"); ?>
                                                            <br><span class="kinfo"><?php echo __("admin/products/add-new-product-versions-desc"); ?></span>
                                                        </div>
                                                        <div class="yuzde70">
                                                            <textarea class="tinymce-1" name="versions[<?php echo $lkey; ?>]" rows="3"><?php echo $versions; ?></textarea>
                                                        </div>
                                                    </div>

                                                </div>

                                                <?php if($lang["local"]): ?>
                                                    <h3><?php echo __("admin/products/add-new-product-software-tab-pictures"); ?></h3>
                                                    <div>


                                                        <div class="formcon">
                                                            <div class="yuzde30">
                                                                <?php echo __("admin/products/add-new-product-order-image"); ?>
                                                                <div class="clear"></div>
                                                                <span class="kinfo"><?php echo __("admin/products/add-new-product-order-image-desc"); ?></span>
                                                            </div>
                                                            <div class="yuzde70">
                                                                <div class="headerbgedit">
                                                                    <input type="file" name="order_image" id="order_image" style="display:none;" onchange="read_image_file(this,'order_image_preview');" data-default-image="<?php echo $getOrderImageDeft; ?>" />
                                                                    <div class="headbgeditbtn">
                                                                        <a href="javascript:orderimg_delete();void 0;" class="photosil"><i class="fa fa-trash"></i></a><br/>
                                                                        <a class="avatarguncelle" href="javascript:void(0);" onclick="$('#order_image').click();" ><i class="fa fa-camera" aria-hidden="true"></i></a>
                                                                    </div>
                                                                    <img src="<?php echo $getOrderImage; ?>" width="100%" style="    height: 130px;    width: 170px;" id="order_image_preview">
                                                                </div>
                                                                <div class="clear"></div>
                                                            </div>
                                                        </div>


                                                        <div class="formcon">
                                                            <div class="yuzde30">
                                                                <?php echo __("admin/products/add-new-product-header-background"); ?>
                                                                <div class="clear"></div>
                                                                <span class="kinfo"><?php echo __("admin/products/add-new-product-header-background-desc"); ?></span>
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
                                                                <div class="clear"></div>
                                                            </div>
                                                        </div>

                                                        <div class="formcon">
                                                            <div class="yuzde30">
                                                                <?php echo __("admin/products/add-new-product-list-image"); ?>
                                                                <div class="clear"></div>
                                                                <span class="kinfo"><?php echo __("admin/products/add-new-product-list-image-desc"); ?></span>
                                                            </div>
                                                            <div class="yuzde70">
                                                                <div class="headerbgedit">
                                                                    <input type="file" name="list_image" id="list_image" style="display:none;" onchange="read_image_file(this,'list_image_preview');" data-default-image="<?php echo $getHeaderBackgroundDeft; ?>" />
                                                                    <div class="headbgeditbtn">
                                                                        <a href="javascript:listimg_delete();void 0;" class="photosil"><i class="fa fa-trash"></i></a><br/>
                                                                        <a class="avatarguncelle" href="javascript:void(0);" onclick="$('#list_image').click();" ><i class="fa fa-camera" aria-hidden="true"></i></a>
                                                                    </div>
                                                                    <img src="<?php echo $getListImage; ?>" width="100%" style="    height: 130px;    width: 170px;" id="list_image_preview">
                                                                </div>
                                                                <div class="clear"></div>
                                                            </div>
                                                        </div>

                                                        <div class="formcon">
                                                            <div class="yuzde30">
                                                                <?php echo __("admin/products/add-new-product-mockup-image"); ?>
                                                                <div class="clear"></div>
                                                                <span class="kinfo"><?php echo __("admin/products/add-new-product-mockup-image-desc"); ?></span>
                                                            </div>
                                                            <div class="yuzde70">
                                                                <div class="headerbgedit">
                                                                    <input type="file" name="mockup_image" id="mockup_image" style="display:none;" onchange="read_image_file(this,'mockup_image_preview');" data-default-image="<?php echo $getMockupImageDeft; ?>" />
                                                                    <div class="headbgeditbtn">
                                                                        <a href="javascript:mockup_delete();void 0;" class="photosil"><i class="fa fa-trash"></i></a><br/>
                                                                        <a class="avatarguncelle" href="javascript:void(0);" onclick="$('#mockup_image').click();" ><i class="fa fa-camera" aria-hidden="true"></i></a>
                                                                    </div>
                                                                    <img src="<?php echo $getMockupImage; ?>" width="100%" id="mockup_image_preview">
                                                                </div>
                                                                <div class="clear"></div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                <?php endif; ?>


                                                <h3><?php echo __("admin/products/add-new-product-software-tab-feature-blocks"); ?></h3>
                                                <div>
                                                    <div class="formcon">

                                                        <?php echo __("admin/products/add-new-product-feature-blocks"); ?>
                                                        <ul id="blocks_<?php echo $lkey; ?>" class="software-blocks-sortable" style="display:block;margin:0;">
                                                            <?php
                                                                if($feature_blocks){
                                                                    foreach($feature_blocks AS $f){
                                                                        ?>
                                                                        <li>
                                                                            <div class="delmovebtns">
                                                                                <a class="bearer" style="cursor: move;"><i class="fa fa-arrows-alt"></i></a>
                                                                                <a class="delete-block-item" style="cursor:pointer;"><i class="fa fa-trash"></i></a>
                                                                            </div>
                                                                            <input class="yuzde15" name="feature-block[<?php echo $lkey; ?>][icon][]" type="text" placeholder="<?php echo __("admin/products/add-new-product-feature-block-icon"); ?>" value="<?php echo $f["icon"]; ?>"> -
                                                                            <input class="yuzde25" name="feature-block[<?php echo $lkey; ?>][title][]" type="text" placeholder="<?php echo __("admin/products/add-new-product-feature-block-title"); ?>" value="<?php echo $f["title"]; ?>"> -
                                                                            <input class="yuzde25" name="feature-block[<?php echo $lkey; ?>][description][]" type="text" placeholder="<?php echo __("admin/products/add-new-product-feature-block-description"); ?>" value="<?php echo $f["description"]; ?>"> -
                                                                            <input class="yuzde20" name="feature-block[<?php echo $lkey; ?>][detailed-description][]" type="text" placeholder="<?php echo __("admin/products/add-new-product-feature-block-detailed-description"); ?>" value="<?php echo $f["detailed-description"]; ?>">
                                                                        </li>
                                                                        <?php
                                                                    }
                                                                }
                                                            ?>
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
                                                                <input type="checkbox" name="renewal_selection_hide" value="1" id="renewal-selection-hide" class="checkbox-custom"<?php echo $r_s_h ? ' checked' : ''; ?>>
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

                                                                    <input<?php echo $product['affiliate_disable'] ? ' checked' : ''; ?> type="checkbox" class="checkbox-custom" id="affiliate-disable" name="affiliate_disable" value="1">
                                                                    <label class="checkbox-custom-label" for="affiliate-disable"><span class="kinfo"><?php echo __("admin/products/add-new-product-affiliate-disable-desc"); ?></span></label>
                                                                </div>

                                                                <div class="formcon">
                                                                    <strong style="width: 20%; display:inline-block;"><?php echo __("admin/products/add-new-product-affiliate-commission-rate"); ?></strong>
                                                                    <input type="text" name="affiliate_rate" value="<?php echo $product['affiliate_rate'] > 0.0 ? $product['affiliate_rate'] : ''; ?>" class="yuzde10" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57'>
                                                                    <span class="kinfo"><?php echo __("admin/products/add-new-product-affiliate-commission-rate-desc"); ?></span>
                                                                </div>


                                                            </div>
                                                        </div>

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

                                                        <div class="formcon">
                                                            <div class="yuzde30"><?php echo __("admin/products/add-new-product-change-domain"); ?></div>
                                                            <div class="yuzde70">

                                                                <input<?php echo $change_domain ? ' checked' : ''; ?> id="change-domain" type="checkbox" name="change-domain" value="1" class="sitemio-checkbox">
                                                                <label for="change-domain" class="sitemio-checkbox-label"></label>
                                                                <span class="kinfo"><?php echo __("admin/products/add-new-product-change-domain-desc"); ?></span>
                                                            </div>
                                                        </div>

                                                        <div class="formcon">
                                                            <div class="yuzde30"><?php echo __("admin/products/add-new-product-invisible"); ?></div>
                                                            <div class="yuzde70">

                                                                <input<?php echo $invisibility ? ' checked' : ''; ?> id="invisibility" type="checkbox" name="invisibility" value="1" class="sitemio-checkbox">
                                                                <label for="invisibility" class="sitemio-checkbox-label"></label>
                                                                <span class="kinfo"><?php echo __("admin/products/add-new-product-invisible-desc"); ?></span>
                                                            </div>
                                                        </div>

                                                        <div class="formcon">
                                                            <div class="yuzde30"><?php echo __("admin/products/add-new-product-buy-external-link"); ?></div>
                                                            <div class="yuzde70">
                                                                <input name="external_link" type="text" placeholder="http://www.example.com/buylink.html" value="<?php echo $external_link; ?>">
                                                                <br><span class="kinfo"><?php echo __("admin/products/add-new-product-buy-external-link-desc"); ?></span>
                                                            </div>
                                                        </div>

                                                        <div class="formcon">
                                                            <div class="yuzde30"><?php echo __("admin/products/edit-product-buy-link"); ?></div>
                                                            <div class="yuzde70">
                                                                <a href="<?php echo $buy_link; ?>" target="_blank"><?php echo $buy_link; ?></a>
                                                            </div>
                                                        </div>

                                                        <div class="formcon">
                                                            <div class="yuzde30"><?php echo __("admin/products/add-new-product-notes"); ?></div>
                                                            <div class="yuzde70">
                                                                <textarea name="notes" rows="5" placeholder="<?php echo __("admin/products/add-new-product-notes-ex"); ?>"><?php echo $notes; ?></textarea>
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
                                                    <input name="seo_title[<?php echo $lkey; ?>]" type="text" placeholder="<?php echo __("admin/products/seo-title-ex"); ?>" value="<?php echo $seo_title; ?>">
                                                    <br><span class="kinfo"><?php echo __("admin/products/seo-title-desc"); ?></span>
                                                </div>
                                            </div>

                                            <div class="formcon">
                                                <div class="yuzde30"><?php echo __("admin/products/seo-description"); ?></div>
                                                <div class="yuzde70">
                                                    <textarea name="seo_description[<?php echo $lkey; ?>]" cols="" rows="2" placeholder="<?php echo __("admin/products/seo-description-ex"); ?>"><?php echo $seo_description; ?></textarea>
                                                    <br><span class="kinfo"><?php echo __("admin/products/seo-description-desc"); ?></span>
                                                </div>
                                            </div>

                                            <div class="formcon">
                                                <div class="yuzde30"><?php echo __("admin/products/seo-keywords"); ?></div>
                                                <div class="yuzde70">
                                                    <input name="seo_keywords[<?php echo $lkey; ?>]" type="text" placeholder="<?php echo __("admin/products/seo-keywords-ex"); ?>" value="<?php echo $seo_keywords; ?>">
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

                                $(document).ready(function(){

                                    <?php if($paddons): $split  = explode(",",$paddons); foreach($split AS $s): ?>
                                    $("#addon_<?php echo $s; ?>").prop("checked",true).trigger("change");
                                    <?php endforeach; endif; ?>


                                });
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


                            <script type="text/javascript">
                                $(document).ready(function(){

                                    <?php if($prequirements): $split  = explode(",",$prequirements); foreach($split AS $s): ?>
                                    $("#requirement_<?php echo $s; ?>").prop("checked",true).trigger("change");
                                    <?php endforeach; endif; ?>


                                });
                            </script>

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
                                        <input type="hidden" name="delete_prices" value="">
                                        <script type="text/javascript">
                                            $(document).ready(function(){
                                                $("#pricing-list").sortable({
                                                    handle:'.period-bearer',
                                                }).disableSelection();

                                                $("#pricing-list").on("click",".period-delete",function(){
                                                    var id = $(this).data("id");
                                                    if(id != undefined) {
                                                        var before_ids = $("input[name=delete_prices]").val();
                                                        var new_ids = before_ids + "," + id;
                                                        $("input[name=delete_prices]").val(new_ids);
                                                    }
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
                                            <?php
                                                if($prices){
                                                    foreach($prices AS $price){
                                                        ?>
                                                        <li style="padding:0; margin:0;">
                                                            <input type="hidden" name="prices[id][]" value="<?php echo $price["id"]; ?>">
                                                            <input style="width:140px;" name="prices[time][]" type="text" placeholder="<?php echo __("admin/products/add-new-product-period-time"); ?>" value="<?php echo $price["period"] == "none" && $price["time"] == 1 ? '' : $price["time"];   ?>"> -
                                                            <select style="width:140px;" name="prices[period][]">
                                                                <?php
                                                                    foreach(___("date/periods") AS $k=>$v){
                                                                        ?>
                                                                        <option<?php echo $k == $price["period"] ? ' selected' : ''; ?> value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                                                        <?php
                                                                    }
                                                                ?>
                                                            </select> -
                                                            <input style="width:140px;" name="prices[amount][]" type="text" placeholder="<?php echo __("admin/products/add-new-product-period-amount"); ?>" value="<?php echo $price["amount"] ? Money::formatter($price["amount"],$price["cid"]) : ''; ?>" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57'> -
                                                            <select style="width:140px;" name="prices[cid][]">
                                                                <?php
                                                                    foreach(Money::getCurrencies($price["cid"]) AS $currency){
                                                                        $discount = $price["discount"] ? $price["discount"] : '';
                                                                        ?>
                                                                        <option<?php echo $price["cid"] == $currency["id"] ? ' selected' : ''; ?> value="<?php echo $currency["id"]; ?>"><?php echo $currency["name"]." (".$currency["code"].")"; ?></option>
                                                                        <?php
                                                                    }
                                                                ?>
                                                            </select> -
                                                            <span style="margin-right:20px;"><?php echo __("admin/products/add-new-product-period-discount",[
                                                                    '{input}' => '<input style="width:70px;"  name="prices[discount][]" type="text" placeholder="'.__("admin/products/add-new-product-period-discount-placeholder").'" onkeypress="return event.charCode>= 48 &&event.charCode<= 57" value="'.$discount.'">',
                                                                ]); ?></span>
                                                            <a style="line-height:normal;    padding: 7px 3px;" href="javascript:void(0);" class="sbtn period-bearer"><i class="fa fa-arrows-alt"></i></a>
                                                            <a style="line-height:normal;    padding: 7px 3px;" href="javascript:void(0);" class="red sbtn period-delete" data-id="<?php echo $price["id"]; ?>"><i class="fa fa-trash"></i></a>
                                                            <div class="clear"></div>
                                                        </li>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                        </ul>


                                    </div>

                                    <span class="kinfo"><?php echo __("admin/products/add-new-product-pricing-note"); ?></span>
                                    <div class="clear"></div>
                                    <br>
                                    <input<?php echo $product["override_usrcurrency"] ? ' checked' : ''; ?> type="checkbox" name="override_usrcurrency" value="1" class="checkbox-custom" id="override_usrcurrency">
                                    <label class="checkbox-custom-label" for="override_usrcurrency"><?php echo __("admin/products/override-user-currency"); ?> <span class="kinfo"><?php echo __("admin/products/override-user-currency-desc"); ?></span></label>
                                    <br>
                                    <input<?php echo $product["taxexempt"] ? ' checked' : ''; ?> type="checkbox" name="taxexempt" value="1" class="checkbox-custom" id="taxexempt">
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


                        <?php
                            $license_type   = isset($options["license_type"]) ? $options["license_type"] : '';
                            $parameters     = isset($options["license_parameters"]) ? $options["license_parameters"] : [];
                        ?>

                        <div class="licensemanagetype" style="<?php echo  $license_type ? 'display:none;' : 'display:block'; ?>">
                            <script type="text/javascript">
                                var parameter_index = <?php echo sizeof($parameters); ?>;
                                $(document).ready(function(){
                                    $(".licensemanagetype-box").click(function(){
                                        let name = $(this).data("name");

                                        $(".licensemanagetype-box").removeClass('active');

                                        $(this).addClass('active');

                                        $(".license-type-base-content").css("display","none");

                                        $("#"+name+"-based-content").css("display","block");

                                        $('input[name=license_type]').removeAttr("checked");
                                        $('input[value='+name+']').attr("checked",true);

                                        $('.licensemanagetype').css("display","none");

                                    });

                                    example_request_url();
                                });

                                function addParameter(){
                                    var template = $("#parameter-template").html();
                                    parameter_index++;

                                    template = template.replace(/{index}/g,parameter_index);

                                    $("#license_parameters").append(template);
                                }

                                function change_variable_name(el)
                                {
                                    var c_n_input,c_m_input,c_c_input,c_name,c_match,c_clientArea;
                                    var wrap        = $(el).parent().parent();
                                    var name        = $(el).val();

                                    if(name.length < 1) return false;

                                    c_n_input       = $(".parameter-name",wrap);
                                    c_m_input       = $(".parameter-match",wrap);
                                    c_c_input       = $(".parameter-clientArea",wrap);

                                    c_n_input.attr("name",c_n_input.data("name").replace("{name}",name));
                                    c_m_input.attr("name",c_m_input.data("name").replace("{name}",name));
                                    c_c_input.attr("name",c_c_input.data("name").replace("{name}",name));

                                    example_request_url();
                                }

                                function example_request_url()
                                {
                                    var key_separator = '';
                                    var key_name = '';
                                    var sample;
                                    var str = '<?php echo $checking_link; ?>';

                                    generate_license_key();

                                    $("#license_default_parameters input[name='variable_name[]'],#license_parameters input[name='variable_name[]']").each(function(k,v)
                                    {
                                        key_name = $(this).val();
                                        if(k === 0)
                                            key_separator = "?";
                                        else
                                            key_separator = '&';

                                        if(key_name === 'key')
                                            sample = $("#example-key").html();
                                        else if(key_name === 'ip')
                                            sample = '192.168.1.1';
                                        else
                                            sample = '&lt;variable value&gt;';

                                        str += (key_separator + key_name + '=<storng style="font-weight: 800;">'+sample+'</strong>');
                                    });
                                    $("#example_request_url").html(str);
                                }
                            </script>

                            <h2><?php echo __("admin/products/software-licensing-1"); ?></h2>
                            <h4><?php echo __("admin/products/software-licensing-2"); ?></h4>

                            <div class="licensemanagetype-box<?php echo $license_type == 'domain' ? ' active' : ''; ?>" data-name="domain">
                                <input<?php echo $license_type == 'domain' ? ' checked' : ''; ?> type="radio" name="license_type" value="domain" style="display: none;">
                                <div class="padding30">
                                    <i class="fa fa-globe" aria-hidden="true"></i>
                                    <h3><?php echo __("admin/products/software-licensing-3"); ?></h3>
                                    <p><?php echo __("admin/products/software-licensing-4"); ?></p>
                                </div>
                            </div>

                            <div class="licensemanagetype-box<?php echo $license_type == 'key' ? ' active' : ''; ?>" data-name="key">
                                <input<?php echo $license_type == 'key' ? ' checked' : ''; ?> type="radio" name="license_type" value="key" style="display: none;">
                                <div class="padding30">
                                    <i class="fa fa-desktop" aria-hidden="true"></i>
                                    <h3><?php echo __("admin/products/software-licensing-5"); ?></h3>
                                    <p><?php echo __("admin/products/software-licensing-6"); ?></p>
                                </div>
                            </div>

                        </div>



                        <div class="adminpagecon">
                            <div id="domain-based-content" class="license-type-base-content" style="<?php echo $license_type == "domain" ? '' : 'display: none;';?>">
                                <div class="green-info">
                                    <div class="padding15">
                                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                                        <p><?php echo __("admin/products/software-licensing-7"); ?></p>
                                    </div>
                                </div>


                                <div class="formcon" style="margin: 20px 0px;">
                                    <div class="yuzde30"><?php echo __("admin/products/software-licensing-1"); ?></div>
                                    <div class="yuzde70">
                                        <strong style="margin-right:15px;"><?php echo __("admin/products/software-licensing-3"); ?></strong>
                                        <a class="lbtn" href="javascript:void 0;" onclick="$('#domain-based-content').css('display','none'),$('.licensemanagetype').css('display','block');"><i class="fa fa-refresh" aria-hidden="true"></i><?php echo __("admin/products/software-licensing-8"); ?></a>
                                    </div>
                                </div>

                                <div class="clear"></div>
                                <div class="accordion">
                                    <h3><?php echo __("admin/products/product-license-checking-example-code"); ?></h3>
                                    <div>

                                        <div class="blue-info">
                                            <div class="padding15">
                                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                <p><?php echo __("admin/products/product-license-checking-example-code-desc"); ?></p>
                                            </div>
                                        </div>



                                        <div class="formcon" style="margin:10px 0px;">
                                            <div class="yuzde30">
                                                <?php echo __("admin/products/license-checking-time"); ?>      <br>
                                                <span class="kinfo"><?php echo __("admin/products/license-checking-time-desc"); ?></span>
                                            </div>

                                            <div class="yuzde70">
                                                <script type="text/javascript">
                                                    function change_extend_period(){
                                                        var duration = $("#extend_period_duration").val();
                                                        var period   = $("#extend_period").val();
                                                        $("#license_extend_period").html(duration+' '+period);
                                                        localStorage.setItem("extend_period_duration",duration);
                                                        localStorage.setItem("extend_period",period);
                                                    }
                                                    $(document).ready(function(){
                                                        var duration    = localStorage.getItem("extend_period_duration");
                                                        var period      = localStorage.getItem("extend_period");
                                                        if(duration !== null && duration !== '')
                                                        {
                                                            $("#extend_period_duration").val(duration);
                                                            $("#extend_period").val(period);
                                                            change_extend_period();
                                                        }
                                                    });
                                                </script>
                                                <input type="number" style="width:50px;" id="extend_period_duration" value="1" min="1" onchange="change_extend_period();">
                                                <select id="extend_period" style="width:150px;" onchange="change_extend_period();">
                                                    <?php
                                                        foreach(___("date/time-periods") AS $k=>$v){
                                                            ?>
                                                            <option<?php echo $k == "day" ? ' selected' : ''; ?> value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                                            <?php
                                                        }
                                                    ?>
                                                </select>

                                                <br><span class="kinfo"><?php echo __("admin/products/software-licensing-9"); ?> <strong style="    color: #f44336;"><?php echo __("admin/products/software-licensing-10"); ?></strong></span>
                                                <div class="clear"></div>

                                            </div>
                                        </div>

                                        <pre><code class="php selectalltext">&#x3C;?php

   if (!function_exists(&#x27;curl_init&#x27;) OR !function_exists(&#x27;curl_exec&#x27;) OR !function_exists(&#x27;curl_setopt&#x27;))
       die(&#x27;PHP Curl Library not found&#x27;);

   static $temp_lfile;


   function diff_day($start=&#x27;&#x27;,$end=&#x27;&#x27;){
       $dStart = new DateTime($start);
       $dEnd  = new DateTime($end);
       $dDiff = $dStart-&#x3E;diff($dEnd);
       return $dDiff-&#x3E;days;
   }

   function crypt_chip($action, $string,$salt=&#x27;&#x27;){
       if($salt != &#x27;<?php echo Crypt::encode($token,Config::get("crypt/system")); ?>&#x27;) return false;
       $key    = &#x22;0|.%J.MF4AMT$(.VU1J&#x22;.$salt.&#x22;O1SbFd$|N83JG&#x22;.str_replace(&#x22;www.&#x22;,&#x22;&#x22;,$_SERVER[&#x22;SERVER_NAME&#x22;]).&#x22;.~&#x26;/-_f?fge&#x26;&#x22;;
       $output = false;
       $encrypt_method = &#x22;AES-256-CBC&#x22;;
       if ($key === null)
           $secret_key = &#x22;NULL&#x22;;
       else
           $secret_key = $key;
       $secret_iv = &#x27;<?php echo substr(Crypt::encode($token,Config::get("crypt/system")),10,16); ?>&#x27;;
       $key = hash(&#x27;sha256&#x27;, $secret_key);
       $iv = substr(hash(&#x27;sha256&#x27;, $secret_iv), 0, 16);
       if ( $action === &#x27;encrypt&#x27; )
       {
           $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
           $output = base64_encode($output);
       }
       else if( $action === &#x27;decrypt&#x27; )
           $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
       return $output;
   }

   function get_license_file_data($reload=false){
       global $temp_lfile;
       if($reload || !$temp_lfile){
           if(!file_exists(__DIR__.DIRECTORY_SEPARATOR.&#x22;LICENSE&#x22;)){
               return false;
           }
           $checkingFileData   = file_get_contents(__DIR__.DIRECTORY_SEPARATOR.&#x22;LICENSE&#x22;);
           if($checkingFileData){
               $checkingFileData   = crypt_chip(&#x22;decrypt&#x22;,$checkingFileData,&#x22;<?php echo Crypt::encode($token,Config::get("crypt/system")); ?>&#x22;);
               if($checkingFileData){
                   $temp_lfile = json_decode($checkingFileData,true);
                   return $temp_lfile;
               }
           }
       }else return $temp_lfile;
       return false;
   }

   function license_run_check($licenseData=[]){
       if($licenseData){
           if(isset($licenseData[&#x22;next-check-time&#x22;])){
               $now_time   = date(&#x22;Y-m-d H:i:s&#x22;);
               $next_time  = date(&#x22;Y-m-d H:i:s&#x22;,strtotime($licenseData[&#x22;next-check-time&#x22;]));
               $difference = diff_day($next_time,$now_time);
               if($difference&#x3C;2){
                   $now_time   = strtotime(date(&#x22;Y-m-d H:i:s&#x22;));
                   $next_time  = strtotime($next_time);
                   if($next_time &#x3E; $now_time) return false;
               }
           }
       }
       return true;
   }

   function use_license_curl($address,&#x26;$error_msg){
       $ch=curl_init();
       curl_setopt($ch, CURLOPT_URL,$address);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
       curl_setopt($ch, CURLOPT_TIMEOUT,30);
       $result = @curl_exec($ch);
       if(curl_errno($ch)){
           $error_msg = curl_error($ch);
           return false;
       }
       curl_close($ch);
       return $result;
   }

   $license_data   = get_license_file_data();
   $run_check      = license_run_check($license_data);

   if($run_check){
       $domain     = str_replace(&#x22;www.&#x22;,&#x22;&#x22;,$_SERVER[&#x22;SERVER_NAME&#x22;]);
       $directory  = __DIR__;
       if(isset($_SERVER[&#x22;HTTP_CLIENT_IP&#x22;])){
           $ip = $_SERVER[&#x22;HTTP_CLIENT_IP&#x22;];
       }elseif(isset($_SERVER[&#x22;HTTP_X_FORWARDED_FOR&#x22;])){
           $ip = $_SERVER[&#x22;HTTP_X_FORWARDED_FOR&#x22;];
       }else{
           $ip = $_SERVER[&#x22;REMOTE_ADDR&#x22;];
       }

       $server_ip  =  $_SERVER[&#x22;SERVER_ADDR&#x22;];
       $entered    =  &#x22;http://&#x22;.$_SERVER[&#x22;HTTP_HOST&#x22;].$_SERVER[&#x22;REQUEST_URI&#x22;];
       $referer    =  isset($_SERVER[&#x22;HTTP_REFERER&#x22;]) ? $_SERVER[&#x22;HTTP_REFERER&#x22;] : &#x27;&#x27;;
       $address    =  &#x22;<?php echo $checking_link; ?>?&#x22;;
       $address    .= &#x22;domain=&#x22;.$domain;
       $address    .= &#x22;&#x26;server_ip=&#x22;.$server_ip;
       $address    .= &#x22;&#x26;user_ip=&#x22;.$ip;
       $address    .= &#x22;&#x26;entered_url=&#x22;.$entered;
       $address    .= &#x22;&#x26;referer_url=&#x22;.$referer;
       $address    .= &#x22;&#x26;directory=&#x22;.$directory;
       $resultErr  = false;
       $result     = use_license_curl($address,$resultErr);
       if($result == &#x22;OK&#x22;){
           // License check succeeded.

           $checkFileData      = crypt_chip(&#x22;encrypt&#x22;,json_encode([
               &#x27;last-check-time&#x27; =&#x3E; date(&#x22;Y-m-d H:i:s&#x22;),
               &#x27;next-check-time&#x27; =&#x3E; date(&#x22;Y-m-d H:i:s&#x22;,strtotime(&#x22;+<span id="license_extend_period" class="hljs-string">1 day</span>&#x22;)),
           ]),&#x22;<?php echo Crypt::encode($token,Config::get("crypt/system")); ?>&#x22;);
           file_put_contents(__DIR__.DIRECTORY_SEPARATOR.&#x22;LICENSE&#x22;,$checkFileData);

       }else{
           $err = use_license_curl(&#x22;<?php echo $license_error_link; ?>?user_ip=&#x22;.$ip,$resultErr);
           if($err == &#x27;&#x27;){
               $err = &#x27;LICENSE CURL CONNECTION ERROR&#x27;;
           }
           die($err);
       }

   }</code></pre>


                                    </div>

                                    <h3><?php echo __("admin/products/software-licensing-11"); ?></h3>
                                    <div>
                                        <div class="blue-info">
                                            <div class="padding15">
                                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                <p><?php echo __("admin/products/software-licensing-12"); ?></p>
                                            </div>
                                        </div>

                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/products/product-license-checking-url"); ?></div>
                                            <div class="yuzde70">
                                                <strong><a href="<?php echo $checking_link; ?>" target="_blank"><?php echo $checking_link; ?></a></strong>

                                                <br>     <span class="kinfo"><?php echo __("admin/products/software-licensing-13"); ?></span>

                                            </div>
                                        </div>

                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/products/product-license-checking-params"); ?>
                                                <div class="clear"></div>
                                                <span class="kinfo"><?php echo __("admin/products/product-license-checking-params-desc"); ?></span>
                                            </div>
                                            <div class="yuzde70">
                                                <table width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th align="left"><?php echo __("admin/products/products-license-checking-param-1"); ?></th>
                                                        <th align="left"><?php echo __("admin/products/products-license-checking-param-2"); ?></th>
                                                        <th align="left"><?php echo __("admin/products/products-license-checking-param-3"); ?></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    <tr>
                                                        <td align="left">domain</td>
                                                        <td align="left"><?php echo __("admin/products/product-license-checking-param-domain"); ?></td>
                                                        <td align="left">example.com</td>
                                                    </tr>

                                                    <tr>
                                                        <td align="left">server_ip</td>
                                                        <td align="left"><?php echo __("admin/products/product-license-checking-param-server-ip"); ?></td>
                                                        <td align="left">127.0.0.1</td>
                                                    </tr>

                                                    <tr>
                                                        <td align="left">user_ip</td>
                                                        <td align="left"><?php echo __("admin/products/product-license-checking-param-user-ip"); ?></td>
                                                        <td align="left">127.0.0.1</td>
                                                    </tr>

                                                    <tr>
                                                        <td align="left">entered_url</td>
                                                        <td align="left"><?php echo __("admin/products/product-license-checking-param-entered-url"); ?></td>
                                                        <td align="left">http://example.com</td>
                                                    </tr>

                                                    <tr>
                                                        <td align="left">referer_url</td>
                                                        <td align="left"><?php echo __("admin/products/product-license-checking-param-referer-url"); ?></td>
                                                        <td align="left">http://example.com</td>
                                                    </tr>

                                                    <tr>
                                                        <td align="left">directory</td>
                                                        <td align="left"><?php echo __("admin/products/product-license-checking-param-directory"); ?></td>
                                                        <td align="left">/home/username/public_html</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="license-type-base-content" id="key-based-content" style="<?php echo $license_type == "key" ? '' : 'display: none;';?>">

                                <div class="green-info">
                                    <div class="padding15">
                                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                                        <p><?php echo __("admin/products/software-licensing-28"); ?></p>
                                    </div>
                                </div>

                                <div class="formcon" style="margin: 20px 0px;">
                                    <div class="yuzde30"><?php echo __("admin/products/software-licensing-1"); ?></div>
                                    <div class="yuzde70">
                                        <strong style="margin-right:15px;"><?php echo __("admin/products/software-licensing-5"); ?></strong>
                                        <a class="lbtn" href="javascript:void 0;" onclick="$('#domain-based-content').css('display','none'),$('.licensemanagetype').css('display','block');"><i class="fa fa-refresh" aria-hidden="true"></i><?php echo __("admin/products/software-licensing-8"); ?></a>
                                    </div>
                                </div>

                                <div  class="clear"></div>

                                <div class="accordion">


                                    <h3><?php echo __("admin/products/software-licensing-14"); ?></h3>
                                    <div>

                                        <div class="blue-info">
                                            <div class="padding15">
                                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                <p><?php echo __("admin/products/software-licensing-15"); ?></p>
                                            </div>
                                        </div>


                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/products/software-licensing-16"); ?></div>
                                            <div class="yuzde70">
                                                <input id="key_prefix" style="width: 120px;" name="key_prefix" type="text" placeholder="Ex: MYSOFT" value="<?php echo isset($options["key_prefix"]) ? $options["key_prefix"] : ''; ?>">
                                                <span class="kinfo"><?php echo __("admin/products/software-licensing-17"); ?></span>
                                            </div>
                                        </div>

                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/products/software-licensing-18"); ?></div>
                                            <div class="yuzde70">
                                                <input style="width: 120px;" id="key_length" name="key_length" type="number" placeholder="Ex: 15" value="<?php echo isset($options["key_length"]) ? $options["key_length"] : ''; ?>" min="15">
                                                <span class="kinfo"><?php echo __("admin/products/software-licensing-19"); ?></span>
                                            </div>
                                        </div>

                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/products/software-licensing-20"); ?></div>
                                            <div class="yuzde70">
                                                <input<?php echo isset($options["key_l"]) && $options["key_l"] ? ' checked' : ''?> type="checkbox" name="key_l" value="1" class="checkbox-custom" id="key_l">
                                                <label class="checkbox-custom-label" for="key_l"><?php echo __("admin/products/software-licensing-22"); ?></label>
                                                <br>
                                                <input<?php echo  !isset($options["key_u"]) || $options["key_u"] ? ' checked' : ''?> type="checkbox" name="key_u" value="1" class="checkbox-custom" id="key_u">
                                                <label class="checkbox-custom-label" for="key_u"><?php echo __("admin/products/software-licensing-21"); ?></label>
                                                <br>
                                                <input<?php echo !isset($options["key_d"]) || $options["key_d"] ? ' checked' : ''?> type="checkbox" name="key_d" value="1" class="checkbox-custom" id="key_d">
                                                <label class="checkbox-custom-label" for="key_d"><?php echo __("admin/products/software-licensing-23"); ?></label>
                                                <br>
                                                <input<?php echo isset($options["key_s"]) && $options["key_s"] ? ' checked' : ''?> type="checkbox" name="key_s" value="1" class="checkbox-custom" id="key_s">
                                                <label class="checkbox-custom-label" for="key_s"><?php echo __("admin/products/software-licensing-24"); ?></label>
                                                <br>
                                                <input<?php echo !isset($options["key_dashes"]) || $options["key_dashes"] ? ' checked' : ''?> type="checkbox" name="key_dashes" value="1" class="checkbox-custom" id="key_dashes">
                                                <label class="checkbox-custom-label" for="key_dashes"><?php echo __("admin/products/software-licensing-29"); ?></label>
                                            </div>
                                        </div>

                                        <div class="formcon" style="padding: 15px 0px;">
                                            <div class="yuzde30"><?php echo __("admin/products/software-licensing-25"); ?></div>
                                            <div class="yuzde70">
                                                <script type="text/javascript">
                                                    $(document).ready(function(){

                                                        $("#key_prefix").on("ready load keyup keydown keypress change", function () {
                                                            var value = $(this).val().substr(0, 11).replace(/ö/g, "o").replace(/ç/g, "c").replace(/ş/g, "s").replace(/ğ/g, "g").replace(/ü/g, "u").replace(/Ö/g, "O").replace(/Ç/g, "C").replace(/Ş/g, "S").replace(/İ/g, "I").replace(/Ğ/g, "G").replace(/Ü/g, "U").replace(/([^a-zA-Z0-9 \.\-_])/g, "");
                                                            value = value.toUpperCase();
                                                            $(this).val(value);
                                                        });

                                                        $("#key_u,#key_l,#key_d,#key_s,#key_dashes").change(generate_license_key);
                                                        $("#key_prefix, #key_length").on("keyup change",generate_license_key);
                                                        generate_license_key();
                                                    });
                                                    function generate_license_key()
                                                    {
                                                        var prefix              = $("#key_prefix").val();
                                                        var character_sets      = '';
                                                        var dashes              = $("#key_dashes").prop('checked');
                                                        var character_length    = parseInt($("#key_length").val());
                                                        var character_l         = 'abcdefghijklmnopqrstuvwxyz';
                                                        var character_u         = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                                                        var character_d         = '0123456789';
                                                        var character_s         = '+*!@';

                                                        if($("#key_l").prop('checked')) character_sets += character_l;
                                                        if($("#key_u").prop('checked')) character_sets += character_u;
                                                        if($("#key_d").prop('checked')) character_sets += character_d;
                                                        if($("#key_s").prop('checked')) character_sets += character_s;

                                                        if(isNaN(character_length)) character_length = 15;

                                                        if(character_sets === '')
                                                        {
                                                            $("#example-key").html("<?php echo __("admin/products/software-licensing-30"); ?>");
                                                            return false;
                                                        }

                                                        if(prefix.length > 0)
                                                        {
                                                            prefix += "-";
                                                            character_length -= 1;
                                                        }

                                                        if(character_length < (15 - (prefix.length > 0 ? 1 : 0)))
                                                        {
                                                            $("#example-key").html("<?php echo __("admin/products/software-licensing-31"); ?>");
                                                            return false;
                                                        }

                                                        var key = voucher_codes.generate({length:character_length,charset: character_sets});
                                                        key     = key[0];

                                                        if(dashes)
                                                        {
                                                            var key_n    = '';
                                                            var key_c    = 0;
                                                            var key_r    = character_length;
                                                            $(key.split('')).each(function(k,v){
                                                                key_r--;
                                                                if(key_c === 4)
                                                                {
                                                                    key_n += key_r === 0 ? v : '-';
                                                                    key_c = 0;
                                                                }
                                                                else
                                                                {
                                                                    key_n += v;
                                                                    key_c++;
                                                                }
                                                            });
                                                            key             = key_n;
                                                            key             = key.rtrim('-');
                                                        }


                                                        if(prefix.length > 0)
                                                        key  = prefix + key;

                                                        $("#example-key,#example-key2").html(key);
                                                    }
                                                </script>
                                                <strong id="example-key"></strong>
                                                <br><span class="kinfo"><?php echo __("admin/products/software-licensing-27"); ?></span>
                                            </div>
                                        </div>

                                    </div>

                                    <h3><?php echo __("admin/products/software-licensing-32"); ?></h3>
                                    <div>

                                        <div class="green-info">
                                            <div class="padding15">
                                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                <p><?php echo __("admin/products/software-licensing-33"); ?></p>
                                            </div>
                                        </div>

                                        <div class="formcon" style="padding: 20px 0px;">
                                            <div class="yuzde30"><?php echo __("admin/products/product-license-checking-url"); ?></div>
                                            <div class="yuzde70">
                                                <strong> <a style="color: #f44336;" href="<?php echo $checking_link; ?>" target="_blank"><?php echo $checking_link; ?></a></strong>

                                                <br><span style="margin-top:10px;display:block;" class="kinfo"><strong><?php echo __("admin/products/software-licensing-34"); ?></strong></span>

                                            </div>
                                        </div>

                                        <div class="formcon" style="    padding: 20px 0px;">
                                            <div class="yuzde30"><?php echo __("admin/products/software-licensing-35"); ?><div class="clear"></div>
                                                <span class="kinfo"><?php echo __("admin/products/software-licensing-36"); ?></span>
                                            </div>
                                            <div class="yuzde70">
                                                <span style="    color: #f44336;" id="example_request_url">...</span>
                                                <br><span style="margin-top:10px;display:block;" class="kinfo"><?php echo __("admin/products/software-licensing-37"); ?></span>

                                            </div>
                                        </div>

                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/products/product-license-checking-params"); ?><div class="clear"></div>
                                                <span class="kinfo"><?php echo __("admin/products/software-licensing-38"); ?></span>
                                            </div>
                                            <div class="yuzde70">
                                                <table width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th align="center"><?php echo __("admin/products/software-licensing-53"); ?></th>
                                                        <th align="center"><?php echo __("admin/manage-website/list-th-title"); ?></th>
                                                        <th align="center"><?php echo __("admin/products/products-license-checking-param-3"); ?></th>
                                                        <th align="center"><?php echo __("admin/products/software-licensing-39"); ?> <a style="font-weight:normal" data-tooltip="<?php echo __("admin/products/software-licensing-40"); ?>"><i class="fa fa-question-circle-o" aria-hidden="true"></i></a></th>
                                                        <th align="center"><?php echo __("admin/products/software-licensing-41"); ?> <a style="font-weight:normal" data-tooltip="<?php echo __("admin/products/software-licensing-42"); ?>"><i class="fa fa-question-circle-o" aria-hidden="true"></i></a></th>
                                                        <th align="center"><?php echo __("admin/products/software-licensing-43"); ?></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="license_default_parameters">

                                                    <tr>
                                                        <td align="center">
                                                            <input style="text-align:center;" disabled name="variable_name[]" type="text" placeholder="key" value="key">
                                                        </td>
                                                        <td align="center">
                                                            <input style="text-align:center;" disabled name="key" type="text" placeholder="<?php echo __("admin/products/software-licensing-44"); ?>" value="">
                                                        </td>
                                                        <td align="center" id="example-key2">-</td>
                                                        <td align="center">-</td>
                                                        <td align="center">-</td>
                                                        <td align="center"><?php echo __("admin/products/software-licensing-45"); ?></td>
                                                    </tr>

                                                    <tr>
                                                        <td align="center">
                                                            <input style="text-align:center;" disabled name="variable_name[]" type="text" placeholder="ip" value="ip">
                                                        </td>
                                                        <td align="center">
                                                            <input style="text-align:center;" disabled name="ip" type="text" placeholder="<?php echo __("admin/orders/server-ip"); ?>" value="<?php echo __("admin/orders/server-ip"); ?>">
                                                        </td>
                                                        <td align="center">191.168.1.1</td>
                                                        <td align="center">
                                                            <input<?php echo isset($parameters["ip"]["match"]) && $parameters["ip"]["match"] ? ' checked' : ''; ?> type="checkbox" name="match[ip]" value="1" class="checkbox-custom" id="match_ip">
                                                            <label class="checkbox-custom-label" for="match_ip"></label>
                                                        </td>
                                                        <td align="center">
                                                            <input<?php echo isset($parameters["ip"]["clientArea"]) && $parameters["ip"]["clientArea"] ? ' checked' : ''; ?> type="checkbox" name="clientArea[ip]" value="1" class="checkbox-custom" id="clientArea-ip">
                                                            <label class="checkbox-custom-label" for="clientArea-ip"></label></td>
                                                        <td align="center"><?php echo __("admin/products/software-licensing-45"); ?></td>
                                                    </tr>

                                                    </tbody>
                                                    <tbody id="license_parameters">
                                                    <?php
                                                        if(isset($parameters) && $parameters)
                                                        {
                                                            $i = 1;
                                                            foreach($parameters AS $k => $p)
                                                            {
                                                                if($k == "ip") continue;
                                                                $i++;
                                                                ?>
                                                                <tr id="param-tr-<?php echo $i; ?>">
                                                                    <td align="center">
                                                                        <input style="text-align:center;" data-index="<?php echo $i; ?>" name="variable_name[]" class="license-variable-name" type="text" placeholder="macAddress" value="<?php echo $k; ?>" onchange="change_variable_name(this);">
                                                                    </td>
                                                                    <td align="center">
                                                                        <input style="text-align:center;" data-name="parameter_name[{name}]" name="parameter_name[<?php echo $k; ?>]"  type="text" placeholder="<?php echo __("admin/products/software-licensing-46"); ?>" value="<?php echo $p["name"]; ?>" class="parameter-name">
                                                                    </td>
                                                                    <td align="center">-</td>
                                                                    <td align="center">
                                                                        <input<?php echo $p["match"] ? ' checked' : ''; ?> type="checkbox" name="match[<?php echo $k; ?>]" data-name="match[{name}]" value="1" class="parameter-match checkbox-custom" id="match-param-<?php echo $i; ?>">
                                                                        <label class="checkbox-custom-label" for="match-param-<?php echo $i; ?>"></label>
                                                                    </td>
                                                                    <td align="center">
                                                                        <input<?php echo $p["clientArea"] ? ' checked' : ''; ?> type="checkbox" name="clientArea[<?php echo $k; ?>]" data-name="clientArea[{name}]" value="1" class="parameter-clientArea checkbox-custom" id="clientArea-param-<?php echo $i; ?>">
                                                                        <label class="checkbox-custom-label" for="clientArea-param-<?php echo $i; ?>"></label>
                                                                    </td>
                                                                    <td align="center"><?php echo __("admin/products/software-licensing-52"); ?></td>
                                                                </tr>
                                                                <?php
                                                            }
                                                        }
                                                    ?>
                                                    </tbody>
                                                    <tbody
                                                    <tr>
                                                        <td colspan="5" align="left">
                                                            <a href="javascript:void 0;" onclick="addParameter();" class="sbtn"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>




                                        <div class="formcon" style="padding: 15px 0px;">
                                            <strong><?php echo __("admin/products/software-licensing-47"); ?></strong>
                                            <ul>
                                                <li><?php echo __("admin/products/software-licensing-48"); ?></li>
                                                <li><?php echo __("admin/products/software-licensing-49"); ?></li>
                                                <li><?php echo __("admin/products/software-licensing-50"); ?></li>
                                                <li><?php echo __("admin/products/software-licensing-51"); ?></li>
                                            </ul>
                                        </div>

                                    </div>



                                </div>



                            </div>


                            <div class="clear"></div>
                        </div>

                        <div class="clear"></div>
                    </div><!-- tab content end -->


                </div><!-- tab wrap content end -->


                <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                    <a class="yesilbtn gonderbtn" id="editForm_submit" href="javascript:void(0);"><?php echo __("admin/products/edit-hosting-product-button"); ?></a>
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

            <table style="display: none">
                <tbody id="parameter-template">
                <tr id="param-tr-{index}">
                    <td align="center">
                        <input style="text-align:center;" data-index="{index}" name="variable_name[]" class="license-variable-name" type="text" placeholder="macAddress" value="" onchange="change_variable_name(this);">
                    </td>
                    <td align="center">
                        <input style="text-align:center;" data-name="parameter_name[{name}]"  type="text" placeholder="<?php echo __("admin/products/software-licensing-46"); ?>" value="" class="parameter-name">
                    </td>
                    <td align="center">-</td>
                    <td align="center">
                        <input type="checkbox" data-name="match[{name}]" value="1" class="parameter-match checkbox-custom" id="match-param-{index}">
                        <label class="checkbox-custom-label" for="match-param-{index}"></label>
                    </td>
                    <td align="center">
                        <input type="checkbox" data-name="clientArea[{name}]" value="1" class="parameter-clientArea checkbox-custom" id="clientArea-param-{index}">
                        <label class="checkbox-custom-label" for="clientArea-param-{index}"></label>
                    </td>
                    <td align="center"><?php echo __("admin/products/software-licensing-52"); ?></td>
                </tr>
                </tbody>
            </table>


            <div class="clear"></div>
        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>