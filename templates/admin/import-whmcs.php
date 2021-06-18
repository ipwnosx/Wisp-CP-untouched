<!DOCTYPE html>
<html>
<head>
    <?php
        $plugins    = [];
        include __DIR__.DS."inc".DS."head.php";
    ?>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#infoForm_submit").on("click",function(){
                $("#infoForm input[name=apply]").val('0');
                $("#infoForm input[name=part]").val('0');

                MioAjaxElement($(this),{
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                    result:"infoForm_handler",
                });
            });

            $("#import_submit").on("click",function(){
                $("#infoForm input[name=apply]").val('1');
                $("#infoForm input[name=part]").val('0');

                $("#importDetails").fadeOut(250,function (){
                    $("#importProcessing").fadeIn(250);
                });

                MioAjaxElement($(this),{
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                    result:"import_handler",
                });
            });
        });

        function infoForm_handler(result){
            if(result != ''){
                var solve = getJson(result);
                if(solve !== false){
                    if(solve.status == "error"){

                        $("#ExportProcessing").fadeOut(250,function(){
                            $("#infoForm_layout").fadeIn(250);
                        });

                        if(solve.for != undefined && solve.for != ''){
                            $("#infoForm "+solve.for).focus();
                            $("#infoForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                            $("#infoForm "+solve.for).change(function(){
                                $(this).removeAttr("style");
                            });
                        }
                        if(solve.message != undefined && solve.message != '')
                            alert_error(solve.message,{timer:5000});

                    }else if(solve.status == "next-part"){
                        if(solve.part == 1){
                            $("#infoForm_layout").fadeOut(250,function(){
                                $("#ExportProcessing").fadeIn(250);
                            });
                        }

                        var message;
                        if(solve.part == 1) message = "<?php echo __("admin/tools/import-text7"); ?>...";
                        else if(solve.part == 2) message = "<?php echo __("admin/tools/import-text8"); ?>...";
                        else if(solve.part == 3) message = "<?php echo __("admin/tools/import-text9"); ?>...";
                        else if(solve.part == 4) message = "<?php echo __("admin/tools/import-text10"); ?>...";
                        else if(solve.part == 5) message = "<?php echo __("admin/tools/import-text11"); ?>...";
                        $("#ExportProcessing .processing-note").html(message);
                        $("input[name=part]").val(solve.part);

                        var request = MioAjax({
                            form:$("#infoForm"),
                        },true,true);
                        request.done(function(result){
                            return infoForm_handler(result);
                        });

                    }else if(solve.status == "successful"){


                        $("#product_categories_count").html(solve.count.product_categories);
                        $("#products_count").html(solve.count.products);
                        $("#users_count").html(solve.count.users);
                        $("#tickets_count").html(solve.count.tickets);
                        $("#orders_count").html(solve.count.orders);
                        $("#invoices_count").html(solve.count.invoices);

                        $("#infoForm_layout,#ExportProcessing").fadeOut(250,function(){
                            $("#importDetails").fadeIn(300);
                        });

                        if(solve.message != undefined && solve.message != '')
                            alert_success(solve.message,{timer:5000});

                    }
                }
            }else{
                $("#ExportProcessing").fadeOut(250,function(){
                    $("#infoForm_layout").fadeIn(300);
                });

                alert_error("<?php echo __("admin/tools/error11"); ?>",{timer:30000});

            }
        }
        function import_handler(result){
            if(result != ''){
                var solve = getJson(result);
                if(solve !== false){
                    if(solve.status == "error"){

                        $("#importProcessing").fadeOut(250,function(){
                            $("#importDetails").fadeIn(250);
                        });

                        if(solve.for != undefined && solve.for != ''){
                            $("#infoForm "+solve.for).focus();
                            $("#infoForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                            $("#infoForm "+solve.for).change(function(){
                                $(this).removeAttr("style");
                            });
                        }
                        if(solve.message != undefined && solve.message != '')
                            alert_error(solve.message,{timer:5000});
                    }
                    else if(solve.status == "next-part"){
                        var message;
                        if(solve.part == 2) message = "<?php echo __("admin/tools/import-text3"); ?>...";
                        else if(solve.part == 3) message = "<?php echo __("admin/tools/import-text4"); ?>...";
                        else if(solve.part == 4) message = "<?php echo __("admin/tools/import-text5"); ?>...";
                        else if(solve.part == 5) message = "<?php echo __("admin/tools/import-text6"); ?>...";
                        $("#part-message").html(message);
                        $("input[name=part]").val(solve.part);

                        var request = MioAjax({
                            form:$("#infoForm"),
                        },true,true);
                        request.done(function(result){
                            return import_handler(result);
                        });

                    }
                    else if(solve.status == "successful"){

                        $("#importProcessing").fadeOut(300,function(){
                            $("#importCompleted").fadeIn(300);
                        });

                        setTimeout(function(){
                            window.location.href = "<?php echo $dashboard_link; ?>";
                        },5000);
                    }
                }else
                    console.log(result);
            }else{
                close_modal("importProcessing");
                alert_error("<?php echo __("admin/tools/error11"); ?>",{timer:30000});
            }
        }
        function turnBackForm(){
            $("#importDetails").fadeOut(300,function(){
                $("#infoForm_layout").fadeIn(300);
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
                <h1><strong><?php echo __("admin/tools/whmcs-to-wisecp"); ?></strong></h1>
                <?php
                $ui_help_link = 'https://docs.wisecp.com/en/kb/import-from-whmcs';
                if($ui_lang == "tr") $ui_help_link = 'https://docs.wisecp.com/tr/kb/whmcsden-iceri-aktarma';
                ?>
                <a title="<?php echo __("admin/help/usage-guide"); ?>" target="_blank" class="pagedocslink" href="<?php echo $ui_help_link; ?>"><i class="fa fa-life-ring" aria-hidden="true"></i></a>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="clear"></div>

            <div class="importcon">

                <div id="notice_info"><!-- notice start -->
                    <script type="text/javascript">
                        function notice_submit(){
                            $("#notice_info").fadeOut(250,function(){
                                $("#infoForm_layout").fadeIn(250);
                            });
                        }
                    </script>

                    <div class="icerikbaslik">
                        <h1><?php echo __("admin/tools/import-notice-title"); ?></h1>
                    </div>
                    <div class="padding30">
                        <?php echo __("admin/tools/import-from-whmcs-desc"); ?>

                        <div style="text-align:center;display:block;margin:auto" class="yuzde30 guncellebtn">
                            <a class="yesilbtn gonderbtn" style="cursor: pointer;" onclick="notice_submit();"><?php echo __("admin/orders/continue-button"); ?></a>
                        </div>



                        <div class="clear"></div>
                    </div>
                </div><!-- notice end -->

                <form action="<?php echo $links["controller"]; ?>" method="post" id="infoForm" enctype="multipart/form-data">
                    <input type="hidden" name="operation" value="fetch_whmcs_import_data">
                    <input type="hidden" name="apply" value="0">
                    <input type="hidden" name="part" value="0">

                    <div id="infoForm_layout" style="display: none">
                        <div class="icerikbaslik">
                            <h1><?php echo __("admin/tools/import-database-title"); ?></h1>
                        </div>

                        <div class="padding30">

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/tools/import-db-host"); ?></div>
                                <div class="yuzde70">
                                    <input type="text" name="db_host" value="" placeholder="<?php echo __("admin/tools/import-db-host-info"); ?>">
                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/tools/import-db-username"); ?></div>
                                <div class="yuzde70">
                                    <input type="text" name="db_username" value="" placeholder="">
                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/tools/import-db-password"); ?></div>
                                <div class="yuzde70">
                                    <input type="password" name="db_password" value="" placeholder="">
                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/tools/import-db-name"); ?></div>
                                <div class="yuzde70">
                                    <input type="text" name="db_name" value="" placeholder="">
                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/tools/import-encryption-key"); ?></div>
                                <div class="yuzde70">
                                    <input type="text" name="encryption_key" value="" placeholder="">
                                    <span class="kinfo">
                                    <?php echo __("admin/tools/import-encryption-key-info"); ?>
                                </span>
                                </div>
                            </div>

                            <div class="clear"></div>

                            <div style="text-align:center;display:block;margin:auto" class="yuzde30 guncellebtn">
                                <a class="yesilbtn gonderbtn" style="cursor: pointer;" id="infoForm_submit"><?php echo __("admin/tools/button-preview"); ?></a>
                            </div>

                            <div class="clear"></div>
                        </div>
                    </div>

                    <div id="importDetails" style="display: none;">

                        <div class="icerikbaslik">
                            <h1><?php echo __("admin/tools/import-info-title"); ?></h1>
                        </div>
                        <div class="padding30">

                            <div class="formcon">
                                <div class="yuzde50"><?php echo __("admin/tools/import-result-product-categories"); ?></div>
                                <div class="yuzde50">
                                    <span id="product_categories_count" style="font-weight: bold;">0</span>
                                </div>
                            </div>


                            <div class="formcon">
                                <div class="yuzde50"><?php echo __("admin/tools/import-result-products"); ?></div>
                                <div class="yuzde50">
                                    <span id="products_count" style="font-weight: bold;">0</span>
                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde50"><?php echo __("admin/tools/import-result-users"); ?></div>
                                <div class="yuzde50">
                                    <span id="users_count" style="font-weight: bold;">0</span>
                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde50"><?php echo __("admin/tools/import-result-orders"); ?></div>
                                <div class="yuzde50">
                                    <span id="orders_count" style="font-weight: bold;">0</span>
                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde50"><?php echo __("admin/tools/import-result-invoices"); ?></div>
                                <div class="yuzde50">
                                    <span id="invoices_count" style="font-weight: bold;">0</span>
                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde50"><?php echo __("admin/tools/import-result-tickets"); ?></div>
                                <div class="yuzde50">
                                    <span id="tickets_count" style="font-weight: bold;">0</span>
                                </div>
                            </div>

                            <div class="clear"></div>
                            

                            <div style="float: left;display:none" class="yuzde30 guncellebtn">
                                <a class="redbtn gonderbtn" style="cursor: pointer;" onclick="turnBackForm();"><?php echo __("admin/tools/button-turn-back"); ?></a>
                            </div>

                            <div style="display:block;    margin: auto;" class="yuzde30 guncellebtn">
                                <a class="yesilbtn gonderbtn" style="cursor: pointer;" id="import_submit"><?php echo __("admin/tools/button-import"); ?></a>
                            </div>
                            <div class="clear"></div>
                        </div>

                    </div>
                    <div id="importProcessing" style="display: none;">

                        <div class="icerikbaslik">
                            <h1><?php echo __("admin/tools/import-text1"); ?></h1>
                        </div>

                        <div class="padding30">
                            <div style="text-align:center;">
                                <!-- loader -->
                                <div align="center">
                                    <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
                                </div>
                                <!-- loader -->
                                <p id="part-message" style="font-size:18px; font-weight: bold;"><?php echo __("admin/tools/import-text2"); ?>...</p>
                                <div class="line"></div>
                                <p><?php echo __("admin/tools/import-result-please-wait"); ?></p>
                            </div>
                        </div>

                    </div>
                    <div id="ExportProcessing" style="display: none">
                        <div class="icerikbaslik">
                            <h1><?php echo __("admin/tools/import-data-processing"); ?></h1>
                        </div>
                        <div class="padding30">
                            <div style="text-align:center;">
                                <!-- loader -->
                                <div align="center">
                                    <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
                                </div>
                                <!-- loader -->
                                <p class="processing-note" style="font-size:18px; font-weight: bold;"></p>
                                <div class="line"></div>
                                <p><?php echo __("admin/tools/import-result-please-wait"); ?></p>
                            </div>
                        </div>

                    </div>
                    <div id="importCompleted" style="display: none;">
                        <div class="icerikbaslik">
                            <h1><?php echo __("admin/tools/import-completed-title"); ?></h1>
                        </div>
                        <div class="padding30">
                            <div style="width: 100%;    display: inline-block;margin-top:25px;margin-bottom:70px;text-align:center;line-height: 55px;">
                                <i style="font-size:80px;COLOR: #81c04e;" class="fa fa-thumbs-o-up"></i>
                                <h1 style="font-weight: bold;color: #81c04e;"><?php echo __("admin/tools/import-text12"); ?></h1>
                                <h3><?php echo __("admin/tools/import-text13"); ?></h3>
                                <h3 style="font-weight: bold;"><?php echo __("admin/tools/import-text14"); ?></h3>
                            </div>
                        </div>
                    </div>

                    <div class="clear"></div>
                </form>


            </div>


            <div class="clear"></div>


        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>