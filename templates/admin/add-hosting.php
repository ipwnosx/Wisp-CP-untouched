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

            $("#settings-informations .tab-blur-content").click(false);

            $(".input-external-link").change(function(){
                var value = $(this).val();
                if(value){
                    $("#settings-informations .adminpagecon,#settings-optional-addons .adminpagecon,#settings-requirements .adminpagecon").addClass("tab-blur-content");
                    $(".blur-text").fadeIn(100);
                }else{
                    $("#settings-informations .adminpagecon,#settings-optional-addons .adminpagecon,#settings-requirements .adminpagecon").removeClass("tab-blur-content");
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
                            if(solve.for == "createTestAccount" && solve.message == "select-plan"){
                                open_modal('createTestAccount');
                                solve.message = '';
                            }else{
                                $("#addNewForm "+solve.for).focus();
                                $("#addNewForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                $("#addNewForm "+solve.for).change(function(){
                                    $(this).removeAttr("style");
                                });
                            }
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

<div id="createTestAccount" style="display: none;" data-izimodal-title="<?php echo htmlspecialchars(__("admin/products/error31"),ENT_QUOTES); ?>">
    <div class="padding20">

        <div align="center">

            <p id="createTestAccount_message"><?php echo __("admin/products/error32"); ?></p>
            <div class="clear"></div>
            <div class="yuzde50">
                <a href="javascript:close_modal('createTestAccount');void 0;" class="gonderbtn yesilbtn"><i class="fa fa-check"></i> <?php echo __("admin/products/confirm-ok"); ?></a>
            </div>
        </div>

    </div>
</div>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1><strong><?php echo __("admin/products/page-add-hosting"); ?></strong></h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="clear"></div>

            <form action="<?php echo $links["controller"]; ?>" method="post" id="addNewForm" style="margin-top: 5px;">
                <input type="hidden" name="operation" value="add_new_hosting">

                <div id="tab-settings"><!-- tab wrap content start -->
                    <ul class="tab">
                        <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'detail','settings')" data-tab="detail"><i class="fa fa-info" aria-hidden="true"></i>  <?php echo __("admin/products/add-new-product-settings-detail"); ?></a></li>
                        <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'informations','settings')" data-tab="informations"><i class="fa fa-server" aria-hidden="true"></i></i> <?php echo __("admin/products/add-new-hosting-settings-informations"); ?></a></li>

                        <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'optional-addons','settings')" data-tab="optional-addons"><i class="fa fa-plus" aria-hidden="true"></i> <?php echo __("admin/products/add-new-product-settings-optional-addons"); ?></a></li>

                        <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'requirements','settings')" data-tab="requirements"><i class="fa fa-check-square-o" aria-hidden="true"></i> <?php echo __("admin/products/add-new-product-settings-requirements"); ?></a></li>

                        <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'upgradeable','settings')" data-tab="upgradeable"><i class="fa fa-angle-double-up" aria-hidden="true"></i> <?php echo __("admin/products/add-new-product-settings-upgradeable-products"); ?></a></li>


                        <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'pricing','settings')" data-tab="pricing"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <?php echo __("admin/products/add-new-product-settings-pricing"); ?></a></li>
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
                                                    <div class="yuzde30"><?php echo __("admin/products/add-new-product-status"); ?></div>
                                                    <div class="yuzde70">
                                                        <select name="status">
                                                            <option value="active"><?php echo __("admin/products/status-active"); ?></option>
                                                            <option value="inactive"><?php echo __("admin/products/status-inactive"); ?></option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="formcon">
                                                    <div class="yuzde30"><?php echo __("admin/products/add-new-product-category"); ?></div>
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
                                                    <div class="yuzde30"><?php echo __("admin/products/add-new-product-hide-domain"); ?></div>
                                                    <div class="yuzde70">

                                                        <input id="hide-domain" type="checkbox" name="hide-domain" value="1" class="checkbox-custom">
                                                        <label for="hide-domain" class="checkbox-custom-label">
                                                            <span class="kinfo"><?php echo __("admin/products/add-new-product-hide-domain-desc"); ?></span>
                                                        </label>

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
                                                    <input name="external_link[<?php echo $lkey; ?>]" class="input-external-link" type="text" placeholder="http://www.example.com/buylink.html">
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

                    <div id="settings-informations" class="tabcontent"><!-- informations tab content start -->

                        <div class="blur-text" style="display:none;">
                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                            <div class="clear"></div>
                            <?php echo __("admin/products/add-new-product-blur-text"); ?>
                        </div>

                        <div class="adminpagecon">

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/products/add-new-product-hosting-shared-server"); ?></div>
                                <div class="yuzde70">
                                    <script type="text/javascript">
                                        $(document).mouseup(function(e){
                                            var disk_limit_container         = $("#disk_limit_container");
                                            var bandwidth_limit_container    = $("#bandwidth_limit_container");
                                            var email_limit_container        = $("#email_limit_container");
                                            var database_limit_container     = $("#database_limit_container");
                                            var addons_limit_container       = $("#database_limit_container");
                                            var subdomain_limit_container    = $("#subdomain_limit_container");
                                            var ftp_limit_container          = $("#ftp_limit_container");
                                            var park_limit_container         = $("#park_limit_container");
                                            var max_email_per_hour_container = $("#max_email_per_hour_container");

                                            if(!disk_limit_container.is(e.target) && disk_limit_container.has(e.target).length === 0){
                                                if($('#disk_limit').val()==''){
                                                    $('#disk_limit').attr('readonly',true);
                                                    $('#disk_limit_unlimited').prop('checked',true);
                                                }
                                            }

                                            if(!bandwidth_limit_container.is(e.target) && bandwidth_limit_container.has(e.target).length === 0){
                                                if($('#bandwidth_limit').val()==''){
                                                    $('#bandwidth_limit').attr('readonly',true);
                                                    $('#bandwidth_limit_unlimited').prop('checked',true);
                                                }
                                            }

                                            if(!email_limit_container.is(e.target) && email_limit_container.has(e.target).length === 0){
                                                if($('#email_limit').val()==''){
                                                    $('#email_limit').attr('readonly',true);
                                                    $('#email_limit_unlimited').prop('checked',true);
                                                }
                                            }

                                            if(!database_limit_container.is(e.target) && database_limit_container.has(e.target).length === 0){
                                                if($('#database_limit').val()==''){
                                                    $('#database_limit').attr('readonly',true);
                                                    $('#database_limit_unlimited').prop('checked',true);
                                                }
                                            }

                                            if(!addons_limit_container.is(e.target) && addons_limit_container.has(e.target).length === 0){
                                                if($('#addons_limit').val()==''){
                                                    $('#addons_limit').attr('readonly',true);
                                                    $('#addons_limit_unlimited').prop('checked',true);
                                                }
                                            }

                                            if(!subdomain_limit_container.is(e.target) && subdomain_limit_container.has(e.target).length === 0){
                                                if($('#subdomain_limit').val()==''){
                                                    $('#subdomain_limit').attr('readonly',true);
                                                    $('#subdomain_limit_unlimited').prop('checked',true);
                                                }
                                            }

                                            if(!ftp_limit_container.is(e.target) && ftp_limit_container.has(e.target).length === 0){
                                                if($('#ftp_limit').val()==''){
                                                    $('#ftp_limit').attr('readonly',true);
                                                    $('#ftp_limit_unlimited').prop('checked',true);
                                                }
                                            }

                                            if(!park_limit_container.is(e.target) && park_limit_container.has(e.target).length === 0){
                                                if($('#park_limit').val()==''){
                                                    $('#park_limit').attr('readonly',true);
                                                    $('#park_limit_unlimited').prop('checked',true);
                                                }
                                            }

                                            if(!max_email_per_hour_container.is(e.target) && max_email_per_hour_container.has(e.target).length === 0){
                                                if($('#max_email_per_hour').val()==''){
                                                    $('#max_email_per_hour').attr('readonly',true);
                                                    $('#max_email_per_hour_unlimited').prop('checked',true);
                                                }
                                            }


                                        });

                                        $(document).ready(function(){

                                            $("select[name=server_id]").change(function(){
                                                var id      = $(this).val();
                                                var type    = $("option:selected",this).data("type");

                                                if(id==0){
                                                    $(".panel-types")
                                                        .attr("disabled",false)
                                                        .prop("checked",false)
                                                        .trigger("change")
                                                        .next("label")
                                                        .css("display","inline-block");

                                                    $("#module_data_content").fadeOut(1).html('');
                                                    $("#auto_install_wrap").css("display","none");
                                                    $("#disk_limit").val('').attr("readonly",true);
                                                    $("#disk_limit_unlimited").prop("checked",true).attr("disabled",false);

                                                    $("#bandwidth_limit").val('').attr("readonly",true);
                                                    $("#bandwidth_limit_unlimited").prop("checked",true).attr("disabled",false);

                                                    $("#email_limit").val('').attr("readonly",true);
                                                    $("#email_limit_unlimited").prop("checked",true).attr("disabled",false);

                                                    $("#database_limit").val('').attr("readonly",true);
                                                    $("#database_limit_unlimited").prop("checked",true).attr("disabled",false);

                                                    $("#addons_limit").val('').attr("readonly",true);
                                                    $("#addons_limit_unlimited").prop("checked",true).attr("disabled",false);

                                                    $("#subdomain_limit").val('').attr("readonly",true);
                                                    $("#subdomain_limit_unlimited").prop("checked",true).attr("disabled",false);

                                                    $("#ftp_limit").val('').attr("readonly",true);
                                                    $("#ftp_limit_unlimited").prop("checked",true).attr("disabled",false);

                                                    $("#park_limit").val('').attr("readonly",true);
                                                    $("#park_limit_unlimited").prop("checked",true).attr("disabled",false);

                                                    $("#max_email_per_hour").val('').attr("readonly",true);
                                                    $("#max_email_per_hour_unlimited").prop("checked",true).attr("disabled",false);

                                                    $("#dns_content").fadeIn(1);

                                                    $('.panel-types').parent().parent().css("display","inline-block");

                                                }
                                                else{
                                                    $(".panel-types")
                                                        .attr("disabled",true)
                                                        .prop("checked",false)
                                                        .trigger("change")
                                                        .next("label")
                                                        .css("display","none");


                                                    if(!document.getElementById("panel-type-"+type)) type = 'other';

                                                    $("#panel-type-"+type)
                                                        .prop("checked",true)
                                                        .trigger("change")
                                                        .next("label")
                                                        .css("display","inline-block");

                                                    if(type === 'other')
                                                        $("#panel-type-"+type).parent().parent().css("display","none");
                                                    else
                                                        $("#panel-type-"+type).parent().parent().css("display","inline-block");

                                                    $("#module_data_content").html($("#module_data_loader").html()).fadeIn(1);
                                                    var request = MioAjax({
                                                        action:"<?php echo $links["controller"]; ?>",
                                                        method:"POST",
                                                        data:{
                                                            operation:"get_shared_server_mdata",
                                                            server_id:id,
                                                        }
                                                    },true,true);

                                                    request.done(function(result){
                                                        $("#dns_content").fadeOut(1);
                                                        $("#module_data_content").fadeIn(1).html(result);
                                                        $("#auto_install_wrap").css("display","block");
                                                    });
                                                }

                                            });
                                        });
                                    </script>
                                    <select name="server_id" id="select-shared-server">
                                        <option value="0"><?php echo ___("needs/none"); ?></option>
                                        <?php
                                            if(isset($shared_servers) && $shared_servers){
                                                foreach($shared_servers AS $server){
                                                    ?>
                                                    <option value="<?php echo $server["id"]; ?>" data-type="<?php echo $server["type"]; ?>"><?php echo $server["name"]." - ".$server["ip"]." - ".$server["type"]; ?></option>
                                                    <?php
                                                }
                                            }
                                        ?>
                                    </select>

                                    <div id="module_data_loader" style="display: none;text-align:center;">
                                        <center><i style="font-size:24px;padding:20px;" class="loadingicon fa fa-cog" aria-hidden="true"></i></center>
                                    </div>
                                    <div id="module_data_content" style="display: none;"></div>

                                    <div class="formcon" style="display: none;" id="auto_install_wrap">
                                        <div class="yuzde30"><?php echo __("admin/products/add-new-product-auto-install-label"); ?></div>
                                        <div class="yuzde70">
                                            <input checked type="checkbox" name="auto_install" value="1" id="auto_install" class="sitemio-checkbox">
                                            <label class="sitemio-checkbox-label" for="auto_install"></label>
                                            <span class="kinfo"><?php echo __("admin/products/add-new-product-auto-install-desc"); ?></span>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/products/add-new-product-hosting-panel-type"); ?></div>
                                <div class="yuzde70">

                                    <?php
                                        $panel_types    = Config::get("options/panel-types");
                                        if($panel_types){
                                            foreach ($panel_types AS $type){
                                                ?>
                                                <input id="panel-type-<?php echo $type; ?>" class="panel-types radio-custom" name="panel_type" value="<?php echo $type; ?>" type="radio" onchange="if($(this).prop('checked')) $('#panel_other_content').css('display','none');">
                                                <label style="margin-right:15px;" for="panel-type-<?php echo $type; ?>" class="radio-custom-label"><span class="checktext"><?php echo $type; ?></span></label>
                                                <?php
                                            }
                                        }
                                    ?>

                                    <input id="panel-type-other" class="panel-types radio-custom" name="panel_type" value="other" type="radio" onchange="if($(this).prop('checked')) $('#panel_other_content').css('display','block');">
                                    <label style="margin-right:15px;" for="panel-type-other" class="radio-custom-label"><span class="checktext"><?php echo __("admin/products/add-new-product-hosting-panel-type-other"); ?></span></label>

                                    <br><span class="kinfo"><?php echo __("admin/products/add-new-product-hosting-panel-type-desc"); ?></span>
                                    <div class="clear"></div>
                                    <div id="panel_other_content" style="display:none;">
                                        <div class="yuzde30"><?php echo __("admin/orders/server-panel-link"); ?></div>
                                        <div class="yuzde70">
                                            <input type="text" name="panel_link" value="">
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/products/add-new-product-hosting-disk-limit"); ?></div>
                                <div class="yuzde70" id="disk_limit_container">
                                    <input readonly="readonly" style="width:80px;" name="disk_limit" id="disk_limit" type="text" value="" onkeyup="if($(this).val().length>0) $('#disk_limit_unlimited').prop('checked',false); else $('#disk_limit_unlimited').prop('checked',true);" onkeypress='return event.charCode>= 48 &&event.charCode<= 57' onclick="if(!$('#disk_limit_unlimited').prop('disabled')) $(this).attr('readonly',false).trigger('change'),$('#disk_limit_unlimited').prop('checked',false);">
                                    <input checked id="disk_limit_unlimited" class="checkbox-custom" name="disk_limit_unlimited" value="1" type="checkbox" onchange="if($(this).prop('checked')) $('#disk_limit').attr('readonly',true).val('').trigger('change'); else $('#disk_limit').attr('readonly',false).focus().trigger('change');">
                                    <label style="margin-right:15px;" for="disk_limit_unlimited" class="checkbox-custom-label"><span class="checktext"><?php echo __("admin/products/add-new-product-unlimited"); ?></span></label>
                                </div>
                            </div>


                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/products/add-new-product-hosting-bandwidth-limit"); ?></div>
                                <div class="yuzde70" id="bandwidth_limit_container">
                                    <input readonly="readonly" style="width:80px;" name="bandwidth_limit" id="bandwidth_limit" type="text" value="" onkeyup="if($(this).val().length>0) $('#bandwidth_limit_unlimited').prop('checked',false); else $('#bandwidth_limit_unlimited').prop('checked',true);" onkeypress='return event.charCode>= 48 &&event.charCode<= 57' onclick="if(!$('#bandwidth_limit_unlimited').prop('disabled')) $(this).attr('readonly',false).trigger('change'),$('#bandwidth_limit_unlimited').prop('checked',false);">
                                    <input checked id="bandwidth_limit_unlimited" class="checkbox-custom" name="bandwidth_limit_unlimited" value="1" type="checkbox" onchange="if($(this).prop('checked')) $('#bandwidth_limit').attr('readonly',true).val('').trigger('change'); else $('#bandwidth_limit').attr('readonly',false).focus().trigger('change');">
                                    <label style="margin-right:15px;" for="bandwidth_limit_unlimited" class="checkbox-custom-label"><span class="checktext"><?php echo __("admin/products/add-new-product-unlimited"); ?></span></label>
                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/products/add-new-product-hosting-email-limit"); ?></div>
                                <div class="yuzde70" id="email_limit_container">
                                    <input readonly="readonly" style="width:80px;" name="email_limit" id="email_limit" type="text" value="" onkeyup="if($(this).val().length>0) $('#email_limit_unlimited').prop('checked',false); else $('#email_limit_unlimited').prop('checked',true);" onkeypress='return event.charCode>= 48 &&event.charCode<= 57' onclick="if(!$('#email_limit_unlimited').prop('disabled')) $(this).attr('readonly',false),$('#email_limit_unlimited').prop('checked',false);">
                                    <input checked id="email_limit_unlimited" class="checkbox-custom" name="email_limit_unlimited" value="1" type="checkbox" onchange="if($(this).prop('checked')) $('#email_limit').attr('readonly',true).val(''); else $('#email_limit').attr('readonly',false),$('#email_limit').focus();">
                                    <label style="margin-right:15px;" for="email_limit_unlimited" class="checkbox-custom-label"><span class="checktext"><?php echo __("admin/products/add-new-product-unlimited"); ?></span></label>
                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/products/add-new-product-hosting-database-limit"); ?></div>
                                <div class="yuzde70" id="database_limit_container">
                                    <input readonly="readonly" style="width:80px;" name="database_limit" id="database_limit" type="text" value="" onkeyup="if($(this).val().length>0) $('#database_limit_unlimited').prop('checked',false); else $('#database_limit_unlimited').prop('checked',true);" onkeypress='return event.charCode>= 48 &&event.charCode<= 57' onclick="if(!$('#database_limit_unlimited').prop('disabled')) $(this).attr('readonly',false),$('#database_limit_unlimited').prop('checked',false);">
                                    <input checked id="database_limit_unlimited" class="checkbox-custom" name="database_limit_unlimited" value="1" type="checkbox" onchange="if($(this).prop('checked')) $('#database_limit').attr('readonly',true).val(''); else $('#database_limit').attr('readonly',false),$('#database_limit').focus();">
                                    <label style="margin-right:15px;" for="database_limit_unlimited" class="checkbox-custom-label"><span class="checktext"><?php echo __("admin/products/add-new-product-unlimited"); ?></span></label>
                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/products/add-new-product-hosting-addons-limit"); ?></div>
                                <div class="yuzde70" id="addons_limit_container">
                                    <input readonly="readonly" style="width:80px;" name="addons_limit" id="addons_limit" type="text" value="" onkeyup="if($(this).val().length>0) $('#addons_limit_unlimited').prop('checked',false); else $('#addons_limit_unlimited').prop('checked',true);" onkeypress='return event.charCode>= 48 &&event.charCode<= 57' onclick="if(!$('#addons_limit_unlimited').prop('disabled')) $(this).attr('readonly',false),$('#addons_limit_unlimited').prop('checked',false);">
                                    <input checked id="addons_limit_unlimited" class="checkbox-custom" name="addons_limit_unlimited" value="1" type="checkbox" onchange="if($(this).prop('checked')) $('#addons_limit').attr('readonly',true).val(''); else $('#addons_limit').attr('readonly',false),$('#addons_limit').focus();">
                                    <label style="margin-right:15px;" for="addons_limit_unlimited" class="checkbox-custom-label"><span class="checktext"><?php echo __("admin/products/add-new-product-unlimited"); ?></span></label>
                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/products/add-new-product-hosting-subdomain-limit"); ?></div>
                                <div class="yuzde70" id="subdomain_limit_container">
                                    <input readonly="readonly" style="width:80px;" name="subdomain_limit" id="subdomain_limit" type="text" value="" onkeyup="if($(this).val().length>0) $('#subdomain_limit_unlimited').prop('checked',false); else $('#subdomain_limit_unlimited').prop('checked',true);" onkeypress='return event.charCode>= 48 &&event.charCode<= 57' onclick="if(!$('#subdomain_limit_unlimited').prop('disabled')) $(this).attr('readonly',false),$('#subdomain_limit_unlimited').prop('checked',false);">
                                    <input checked id="subdomain_limit_unlimited" class="checkbox-custom" name="subdomain_limit_unlimited" value="1" type="checkbox" onchange="if($(this).prop('checked')) $('#subdomain_limit').attr('readonly',true).val(''); else $('#subdomain_limit').attr('readonly',false),$('#subdomain_limit').focus();">
                                    <label style="margin-right:15px;" for="subdomain_limit_unlimited" class="checkbox-custom-label"><span class="checktext"><?php echo __("admin/products/add-new-product-unlimited"); ?></span></label>
                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/products/add-new-product-hosting-ftp-limit"); ?></div>
                                <div class="yuzde70" id="ftp_limit_container">
                                    <input readonly="readonly" style="width:80px;" name="ftp_limit" id="ftp_limit" type="text" value="" onkeyup="if($(this).val().length>0) $('#ftp_limit_unlimited').prop('checked',false); else $('#ftp_limit_unlimited').prop('checked',true);" onkeypress='return event.charCode>= 48 &&event.charCode<= 57' onclick="if(!$('#ftp_limit_unlimited').prop('disabled')) $(this).attr('readonly',false),$('#ftp_limit_unlimited').prop('checked',false);">
                                    <input checked id="ftp_limit_unlimited" class="checkbox-custom" name="ftp_limit_unlimited" value="1" type="checkbox" onchange="if($(this).prop('checked')) $('#ftp_limit').attr('readonly',true).val(''); else $('#ftp_limit').attr('readonly',false),$('#ftp_limit').focus();">
                                    <label style="margin-right:15px;" for="ftp_limit_unlimited" class="checkbox-custom-label"><span class="checktext"><?php echo __("admin/products/add-new-product-unlimited"); ?></span></label>
                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/products/add-new-product-hosting-park-limit"); ?></div>
                                <div class="yuzde70" id="park_limit_container">
                                    <input readonly="readonly" style="width:80px;" name="park_limit" id="park_limit" type="text" value="" onkeyup="if($(this).val().length>0) $('#park_limit_unlimited').prop('checked',false); else $('#park_limit_unlimited').prop('checked',true);" onkeypress='return event.charCode>= 48 &&event.charCode<= 57' onclick="if(!$('#park_limit_unlimited').prop('disabled')) $(this).attr('readonly',false),$('#park_limit_unlimited').prop('checked',false);">
                                    <input checked id="park_limit_unlimited" class="checkbox-custom" name="park_limit_unlimited" value="1" type="checkbox" onchange="if($(this).prop('checked')) $('#park_limit').attr('readonly',true).val(''); else $('#park_limit').attr('readonly',false),$('#park_limit').focus();">
                                    <label style="margin-right:15px;" for="park_limit_unlimited" class="checkbox-custom-label"><span class="checktext"><?php echo __("admin/products/add-new-product-unlimited"); ?></span></label>
                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/products/add-new-product-hosting-max-email-per-hour"); ?></div>
                                <div class="yuzde70" id="max_email_per_hour_container">
                                    <input readonly="readonly" style="width:80px;" name="max_email_per_hour" id="max_email_per_hour" type="text" value="" onkeyup="if($(this).val().length>0) $('#max_email_per_hour_unlimited').prop('checked',false); else $('#max_email_per_hour_unlimited').prop('checked',true);" onkeypress='return event.charCode>= 48 &&event.charCode<= 57' onclick="if(!$('#max_email_per_hour_unlimited').prop('disabled')) $(this).attr('readonly',false),$('#max_email_per_hour_unlimited').prop('checked',false);">
                                    <input checked id="max_email_per_hour_unlimited" class="checkbox-custom" name="max_email_per_hour_unlimited" value="1" type="checkbox" onchange="if($(this).prop('checked')) $('#max_email_per_hour').attr('readonly',true).val(''); else $('#max_email_per_hour').attr('readonly',false),$('#max_email_per_hour').focus();">
                                    <label style="margin-right:15px;" for="max_email_per_hour_unlimited" class="checkbox-custom-label"><span class="checktext"><?php echo __("admin/products/add-new-product-unlimited"); ?></span></label>
                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/products/add-new-product-hosting-cpu-limit"); ?></div>
                                <div class="yuzde70">
                                    <input name="cpu_limit" type="text" style="width:100px;margin-right:15px;" value="" placeholder="<?php echo __("admin/products/add-new-product-hosting-cpu-limit-ex"); ?>">
                                    <span class="kinfo"><?php echo __("admin/products/add-new-product-hosting-cpu-limit-desc"); ?></span>
                                </div>
                            </div>

                            <!--
                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/products/add-new-product-hosting-server-features"); ?></div>
                                <div class="yuzde70">
                                    <?php
                                        $sfeatures  = Config::get("options/server-features");
                                        if($sfeatures){
                                            foreach($sfeatures AS $feature){
                                                ?>
                                                <input id="feature-<?php echo $feature; ?>" class="checkbox-custom" name="server_features[]" value="<?php echo $feature; ?>" type="checkbox">
                                                <label style="margin-right:15px;" for="feature-<?php echo $feature; ?>" class="checkbox-custom-label"><span class="checktext"><?php echo $feature; ?></span></label>
                                                <?php
                                            }
                                        }
                                    ?>
                                    <br><span class="kinfo"><?php echo __("admin/products/add-new-product-hosting-server-features-desc"); ?></span>
                                </div>
                            </div>
                            -->


                            <div class="formcon" id="dns_content">
                                <div class="yuzde30"><?php echo __("admin/products/add-new-product-hosting-nameserver"); ?></div>
                                <div class="yuzde70">
                                    <input class="yuzde50" name="dns[ns1]" type="text" placeholder="ns1.example.com">
                                    <input class="yuzde50" name="dns[ns2]" type="text" placeholder="ns2.example.com">
                                    <input class="yuzde50" name="dns[ns3]" type="text" placeholder="ns3.example.com">
                                    <input class="yuzde50" name="dns[ns4]" type="text" placeholder="ns4.example.com">
                                </div>
                            </div>


                            <div class="clear"></div>
                        </div>

                        <div class="clear"></div>
                    </div><!-- informations tab content end -->

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
                                    <p><?php echo __("admin/products/add-new-product-addons-desc"); ?></p>
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

                            <a href="<?php echo $links["add-new-addon"]."?mcategory=hosting"; ?>" class="lbtn">+ <?php echo __("admin/products/add-new-addon"); ?></a>

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
                                   <p> <?php echo __("admin/products/add-new-product-requirements-desc"); ?></p>
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

                            <a href="<?php echo $links["add-new-requirement"]."?mcategory=hosting"; ?>" class="lbtn">+ <?php echo __("admin/products/add-new-requirement"); ?></a>

                        </div>

                        <div class="clear"></div>
                    </div><!-- tab content end -->

                    <div id="settings-upgradeable" class="tabcontent"><!-- tab content start -->
                        <div class="adminpagecon">

                            <div class="green-info">
                                <div class="padding15">
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                   <p> <?php echo __("admin/products/add-new-product-settings-upgradeable-products-desc"); ?></p>
                                </div>
                            </div><br><br>

                            <select name="upgradeable-products[]" multiple style="height: 240px;">
                                <?php
                                    if(isset($upgradeable_products) && $upgradeable_products)
                                    {
                                        foreach($upgradeable_products AS $g_id => $g)
                                        {
                                            ?>
                                            <optgroup label="<?php echo $g['title']; ?>">
                                                <?php
                                                    foreach($g['products'] AS $p)
                                                    {
                                                        ?>
                                                        <option value="<?php echo $p["id"]; ?>"><?php echo $p["title"]; ?></option>
                                                        <?php
                                                    }
                                                ?>
                                            </optgroup>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>



                        </div>
                    </div><!-- tab content end -->

                    <div id="settings-pricing" class="tabcontent"><!-- tab content start -->
                        <div class="adminpagecon">

                            <div class="green-info">
                                <div class="padding15">
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                   <p> <?php echo __("admin/products/add-new-product-pricing-desc"); ?></p>
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