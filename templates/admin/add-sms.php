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
    </script>

</head>
<body>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1><strong><?php echo __("admin/products/page-add-sms"); ?></strong></h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="clear"></div>

            <form action="<?php echo $links["controller"]; ?>" method="post" id="addNewForm" style="margin-top: 5px;">
                <input type="hidden" name="operation" value="add_new_sms">

                <div id="tab-settings"><!-- tab wrap content start -->
                    <ul class="tab" style="display: none;">
                        <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'detail','settings')" data-tab="detail"><i class="fa fa-info" aria-hidden="true"></i>  <?php echo __("admin/products/add-new-product-settings-detail"); ?></a></li>
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

                                        <div class="adminpagecon">

                                            <div class="formcon">
                                                <div class="yuzde30"><?php echo __("admin/products/add-new-product-hosting-title"); ?></div>
                                                <div class="yuzde70">
                                                    <input name="title[<?php echo $lkey; ?>]" type="text">
                                                </div>
                                            </div>

                                            <div class="formcon">
                                                <div class="yuzde30"><?php echo __("admin/products/add-new-product-features"); ?></div>
                                                <div class="yuzde70">
                                                    <textarea rows="4" name="features[<?php echo $lkey; ?>]" placeholder="<?php echo __("admin/products/add-new-product-features-desc"); ?>"></textarea>
                                                </div>
                                            </div>

                                            <?php if($lang["local"]): ?>

                                                <div class="formcon">
                                                    <div class="yuzde30"><?php echo __("admin/products/add-new-product-module"); ?></div>
                                                    <div class="yuzde70">
                                                        <select name="module">
                                                            <option value="none"><?php echo ___("needs/none"); ?></option>
                                                            <?php
                                                                if(isset($modules) && $modules){
                                                                    foreach($modules AS $key=>$module){
                                                                        if(!$module["config"]["meta"]["international"]){
                                                                            $name = $module["lang"]["name"];
                                                                            ?>
                                                                            <option value="<?php echo $key; ?>"><?php echo $name; ?></option>
                                                                            <?php
                                                                        }
                                                                    }
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="formcon">
                                                    <div class="yuzde30"><?php echo __("admin/products/add-new-product-amount"); ?></div>
                                                    <div class="yuzde70">
                                                        <input type="text" name="amount" value="" style="width: 100px;">
                                                        <select style="width:140px;" name="cid">
                                                            <?php
                                                                foreach(Money::getCurrencies() AS $currency){
                                                                    ?>
                                                                    <option value="<?php echo $currency["id"]; ?>"><?php echo $currency["name"]." (".$currency["code"].")"; ?></option>
                                                                    <?php
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="formcon">
                                                    <div class="yuzde30"><?php echo __("admin/products/override-user-currency"); ?></div>
                                                    <div class="yuzde70">
                                                        <input type="checkbox" name="override_usrcurrency" value="1" class="checkbox-custom" id="override_usrcurrency">
                                                        <label class="checkbox-custom-label" for="override_usrcurrency"><span class="kinfo"><?php echo __("admin/products/override-user-currency-desc"); ?></span></label>
                                                    </div>
                                                </div>

                                                <div class="formcon">
                                                    <div class="yuzde30"><?php echo __("admin/products/taxexempt"); ?></div>
                                                    <div class="yuzde70">
                                                        <input type="checkbox" name="taxexempt" value="1" class="checkbox-custom" id="taxexempt">
                                                        <label class="checkbox-custom-label" for="taxexempt"><span class="kinfo"><?php echo __("admin/products/taxexempt-desc"); ?></span></label>
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
                                                    <div class="yuzde30"><?php echo __("admin/products/renewal-selection-hide"); ?></div>
                                                    <div class="yuzde70">
                                                        <input type="checkbox" name="renewal_selection_hide" value="1" id="renewal-selection-hide" class="checkbox-custom">
                                                        <label class="checkbox-custom-label" for="renewal-selection-hide">
                                                            <span class="kinfo"><?php echo __("admin/products/renewal-selection-hide-desc"); ?></span>
                                                        </label>
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
                                                    <div class="yuzde30"><?php echo __("admin/products/add-new-product-invisible"); ?></div>
                                                    <div class="yuzde70">

                                                        <input id="invisibility" type="checkbox" name="invisibility" value="1" class="sitemio-checkbox">
                                                        <label for="invisibility" class="sitemio-checkbox-label"></label>
                                                        <span class="kinfo"><?php echo __("admin/products/add-new-product-invisible-desc"); ?></span>

                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                            <div class="formcon">
                                                <div class="yuzde30"><?php echo __("admin/products/add-new-product-buy-external-link"); ?></div>
                                                <div class="yuzde70">
                                                    <input name="external_link[<?php echo $lkey; ?>]" type="text" class="input-external-link" placeholder="http://www.example.com/buylink.html">
                                                    <br><span class="kinfo"><?php echo __("admin/products/add-new-product-buy-external-link-desc"); ?></span>
                                                </div>
                                            </div>

                                            <?php if($lang["local"]): ?>

                                                <div class="formcon">
                                                    <div class="yuzde30"><?php echo __("admin/products/add-new-product-hosting-notes"); ?></div>
                                                    <div class="yuzde70">
                                                        <textarea name="notes" placeholder="<?php echo __("admin/products/add-new-product-hosting-notes-ex"); ?>"></textarea>
                                                    </div>
                                                </div>
                                            <?php endif; ?>


                                        </div>

                                        <div class="clear"></div>
                                    </div>
                                    <?php
                                }
                            ?>


                        </div><!-- tab wrap content end -->

                    </div><!-- detail tab content end -->

                </div><!-- tab wrap content end -->


                <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                    <a class="yesilbtn gonderbtn" id="addNewForm_submit" href="javascript:void(0);"><?php echo __("admin/products/new-hosting-product-button"); ?></a>
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