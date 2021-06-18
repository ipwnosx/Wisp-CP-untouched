<!DOCTYPE html>
<html>
<head>
    <?php
        Utility::sksort($lang_list,"local");
        $plugins    = ['jquery-ui','jscolor','select2'];
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

        $( function() {
            $( ".accordion" ).accordion({
                heightStyle: "content",
                active: false,
                collapsible: true,
            });
        } );
    </script>
</head>
<body>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1><strong><?php echo __("admin/products/page-domain-settings"); ?></strong></h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="clear"></div>

            <form action="<?php echo $links["controller"]; ?>" method="post" id="updateForm">
                <input type="hidden" name="operation" value="update_domain_settings">



                <div id="tab-lang"><!-- tab wrap content start -->
                    <ul class="tab">
                        <?php
                            $ctoc_s_t       = Config::get("options/ctoc-service-transfer/domain/status");
                            $ctoc_s_t_l     = Config::get("options/ctoc-service-transfer/domain/limit");

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

                            $category   = __("website/domain",false,$lkey);
                            $seo        = __("website/domain/meta",false,$lkey);
                            ?>
                            <div id="lang-<?php echo $lkey; ?>" class="tabcontent">

                                <div class="adminpagecon">

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/products/domain-settings-header-title"); ?></div>
                                        <div class="yuzde70">
                                            <input name="title[<?php echo $lkey; ?>]" type="text" placeholder="" value="<?php echo $category["header-title"]; ?>">
                                        </div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/products/domain-settings-header-sub-title"); ?></div>
                                        <div class="yuzde70">
                                            <input name="sub_title[<?php echo $lkey; ?>]" type="text" placeholder="" value="<?php echo $category["header-description"]; ?>">
                                        </div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/products/domain-settings-slogan"); ?></div>
                                        <div class="yuzde70">
                                            <input name="slogan[<?php echo $lkey; ?>]" type="text" placeholder="" value="<?php echo $category["slogan"]["content"]; ?>">
                                        </div>
                                    </div>

                                    <?php if($lang["local"]): ?>

                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/products/domain-whois-hidden-amount"); ?></div>
                                            <div class="yuzde70">
                                                <input type="text" onkeypress='return event.charCode==46  || event.charCode>= 48 &&event.charCode<= 57' name="wprivacy_amount" value="<?php echo Money::formatter($settings["whois-privacy"]["amount"],$settings["whois-privacy"]["cid"]); ?>" style="width: 100px;">
                                                <select name="wprivacy_cid" style="width: 150px;">
                                                    <?php
                                                        foreach(Money::getCurrencies($settings["whois-privacy"]["cid"]) AS $currency){
                                                            ?>
                                                            <option<?php echo $currency["id"] == $settings["whois-privacy"]["cid"] ? ' selected' : ''; ?> value="<?php echo $currency["id"]; ?>"><?php echo $currency["name"]." (".$currency["code"].")"; ?></option>
                                                            <?php
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                    <?php endif; ?>

                                    <script type="text/javascript">
                                        $(document).ready(function(){

                                            select2_sortable($('#home-spotlight-tlds-<?php echo $lkey; ?>').select2());
                                            select2_sortable($('#page-spotlight-tlds-<?php echo $lkey; ?>').select2());

                                        });
                                    </script>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/products/home-spotlight-tlds"); ?></div>
                                        <div class="yuzde70">
                                            <select name="home-spotlight[<?php echo $lkey; ?>][]" id="home-spotlight-tlds-<?php echo $lkey; ?>" multiple style="width: 100%;">
                                                <?php
                                                    $spotlights  = ___("blocks/home-domain-check/items",false,$lkey);
                                                    if($tlds){
                                                        foreach($tlds AS $row){
                                                            $name       = $row["name"];
                                                            $selected   = in_array($name,$spotlights);
                                                            if(!$selected){
                                                                ?>
                                                                <option value="<?php echo $name; ?>">.<?php echo $name; ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        foreach($spotlights AS $name){
                                                            ?>
                                                            <option value="<?php echo $name; ?>" selected>.<?php echo $name; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/products/page-spotlight-tlds"); ?></div>
                                        <div class="yuzde70">
                                            <select name="page-spotlight[<?php echo $lkey; ?>][]" id="page-spotlight-tlds-<?php echo $lkey; ?>" multiple style="width: 100%;">
                                                <?php
                                                    $spotlights  = __("website/domain/spotlight-tlds",false,$lkey);
                                                    if($tlds){
                                                        foreach($tlds AS $row){
                                                            $name       = $row["name"];
                                                            $selected   = in_array($name,$spotlights);
                                                            if(!$selected){
                                                                ?>
                                                                <option value="<?php echo $name; ?>">.<?php echo $name; ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        foreach($spotlights AS $name){
                                                            ?>
                                                            <option value="<?php echo $name; ?>" selected>.<?php echo $name; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                ?>

                                            </select>
                                        </div>
                                    </div>


                                    <?php if($lang["local"]): ?>

                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/products/add-new-product-hide-hosting"); ?></div>
                                            <div class="yuzde70">

                                                <input<?php echo Config::get("options/domain-hide-hosting") ? ' checked' : ''; ?> id="hide-hosting" type="checkbox" name="hide-hosting" value="1" class="checkbox-custom">
                                                <label for="hide-hosting" class="checkbox-custom-label">
                                                    <span class="kinfo"><?php echo __("admin/products/add-new-product-hide-hosting-desc"); ?></span>
                                                </label>

                                            </div>
                                        </div>

                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/products/override-usrcurrency"); ?></div>
                                            <div class="yuzde70">
                                                <input<?php echo $settings["override_usrcurrency"] ? ' checked' : ''; ?> type="checkbox" class="checkbox-custom" id="override_usrcurrency" name="override_usrcurrency" value="1">
                                                <label style="font-size:13px;" class="checkbox-custom-label" for="override_usrcurrency"><?php echo __("admin/products/override-usrcurrency-label"); ?></label>
                                            </div>
                                        </div>

                                        <div class="formcon">
                                            <div class="yuzde30">
                                                <?php echo __("admin/settings/name-servers"); ?><br>
                                                <span style="font-size:13px;font-weight:normal;"><?php echo __("admin/settings/name-servers-desc"); ?></span>
                                            </div>
                                            <div class="yuzde70">
                                                <input type="text" name="ns1" value="<?php echo $settings["options"]["ns1"]; ?>" placeholder="NS1">
                                                <input type="text" name="ns2" value="<?php echo $settings["options"]["ns2"]; ?>" placeholder="NS2">
                                                <input type="text" name="ns3" value="<?php echo $settings["options"]["ns3"]; ?>" placeholder="NS3">
                                                <input type="text" name="ns4" value="<?php echo $settings["options"]["ns4"]; ?>" placeholder="NS4">
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



                                        <?php
                                        if(!$getIconImage) $getIconImage = $getIconImageDeft;
                                        ?>
                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/products/add-new-category-icon-image"); ?>
                                                <br>
                                                <span class="kinfo" style="font-weight: normal;"><?php echo ___("needs/select-icon-help"); ?></span>
                                            </div>
                                            <div class="yuzde70">
                                                <input type="text" name="icon" value="<?php echo Config::get("options/category-icon/domain"); ?>" placeholder="fa fa-server">
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
                                                                        id:3
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
                                        <div class="yuzde30"><?php echo __("admin/products/add-new-category-content"); ?></div>
                                        <div class="yuzde70">
                                            <textarea name="content[<?php echo $lkey; ?>]" cols="" rows="3" placeholder="<?php echo __("admin/products/add-new-category-content-ex"); ?>"><?php echo FileManager::file_read(LANG_DIR.$lkey.DS."domain-content.html"); ?></textarea>
                                            <br><span class="kinfo"><?php echo __("admin/products/add-new-category-content-desc"); ?></span>
                                        </div>
                                    </div>

									  <div class="clear"></div>
									  <div class="faqaccordion">
									  <div class="accordion">
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


            <div class="clear"></div>
        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>