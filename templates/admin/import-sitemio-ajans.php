<!DOCTYPE html>
<html>
<head>
    <?php
        $plugins    = [];
        include __DIR__.DS."inc".DS."head.php";
    ?>
    <script type="text/javascript">
        var table;
        $(document).ready(function(){

        });
    </script>
</head>
<body>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1><strong>Sitemio Ajans'dan içeri Aktar</strong></h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>



            <div class="clear"></div>


            <div class="green-info" style="margin-bottom:20px;">
                <div class="padding15">
                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                    <p>Sitemio Ajans-Hosting-Web Paket scripti kullanıyor ve mevcut verilerinizi WiseCP'ye aktarmak istiyorsanız, bu aracı kullanarak verilerinizi kolaylıkla WiseCP'ye aktarabilirsiniz. Bu işlemi, WiseCP kurulumundan hemen sonra yapmanız gerekmektedir. İşlem öncesinde mevcut WiseCP veri tabanını yedeklemenizi öneririz. İçe aktarma işleminde eski sitenize ait görseller yeni sisteme transfer olmayacaktır. Görselleri tekrar yüklemeniz gerekir. WiseCP'yi farklı bir dizine kurup, eski siteniz ile karşılaştırma yapabilirsiniz.</p>
                </div>
            </div>

            <div class="clear"></div>

            <div class="adminpagecon">

                <form action="<?php echo $links["controller"]; ?>" method="post" id="infoForm" enctype="multipart/form-data">
                    <input type="hidden" name="operation" value="fetch_sitemio_ajans_import_data">
                    <input type="hidden" name="apply" value="0">
                    <input type="hidden" name="part" value="0">

                    <div id="infoForm_layout">

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
                                <input type="text" name="db_password" value="" placeholder="">
                            </div>
                        </div>

                        <div class="formcon">
                            <div class="yuzde30"><?php echo __("admin/tools/import-db-name"); ?></div>
                            <div class="yuzde70">
                                <input type="text" name="db_name" value="" placeholder="">
                            </div>
                        </div>

                        <div class="clear"></div>

                        <div style="float: right;" class="yuzde30 guncellebtn">
                            <a class="yesilbtn gonderbtn" style="cursor: pointer;" id="infoForm_submit"><?php echo __("admin/tools/button-preview"); ?></a>
                        </div>

                    </div>

                    <div id="importDetails" style="display: none;">

                        <div class="formcon">
                            <div class="yuzde50"><?php echo __("admin/tools/import-result-hosting-categories"); ?></div>
                            <div class="yuzde50">
                                <span id="hosting_categories_count">0</span>
                            </div>
                        </div>

                        <div class="formcon">
                            <div class="yuzde50"><?php echo __("admin/tools/import-result-software-categories"); ?></div>
                            <div class="yuzde50">
                                <span id="software_categories_count">0</span>
                            </div>
                        </div>

                        <div class="formcon">
                            <div class="yuzde50"><?php echo __("admin/tools/import-result-pages"); ?></div>
                            <div class="yuzde50">
                                <span id="normal_pages_count">0</span>
                            </div>
                        </div>

                        <div class="formcon">
                            <div class="yuzde50"><?php echo __("admin/tools/import-result-articles"); ?></div>
                            <div class="yuzde50">
                                <span id="articles_pages_count">0</span>
                            </div>
                        </div>

                        <div class="formcon">
                            <div class="yuzde50"><?php echo __("admin/tools/import-result-references"); ?></div>
                            <div class="yuzde50">
                                <span id="references_pages_count">0</span>
                            </div>
                        </div>

                        <div class="formcon">
                            <div class="yuzde50"><?php echo __("admin/tools/import-result-software"); ?></div>
                            <div class="yuzde50">
                                <span id="software_pages_count">0</span>
                            </div>
                        </div>

                        <!--div class="formcon">
                            <div class="yuzde50"><?php echo __("admin/tools/import-result-tlds"); ?></div>
                            <div class="yuzde50">
                                <span id="tlds_count">0</span>
                            </div>
                        </div-->

                        <div class="formcon">
                            <div class="yuzde50"><?php echo __("admin/tools/import-result-hosting-products"); ?></div>
                            <div class="yuzde50">
                                <span id="hosting_products_count">0</span>
                            </div>
                        </div>

                        <div class="formcon">
                            <div class="yuzde50"><?php echo __("admin/tools/import-result-users"); ?></div>
                            <div class="yuzde50">
                                <span id="users_count">0</span>
                            </div>
                        </div>

                        <div class="formcon">
                            <div class="yuzde50"><?php echo __("admin/tools/import-result-tickets"); ?></div>
                            <div class="yuzde50">
                                <span id="tickets_count">0</span>
                            </div>
                        </div>

                        <div class="formcon">
                            <div class="yuzde50"><?php echo __("admin/tools/import-result-orders"); ?></div>
                            <div class="yuzde50">
                                <span id="orders_count">0</span>
                            </div>
                        </div>

                        <div class="formcon">
                            <div class="yuzde50"><?php echo __("admin/tools/import-result-invoices"); ?></div>
                            <div class="yuzde50">
                                <span id="invoices_count">0</span>
                            </div>
                        </div>

                        <div class="clear"></div>

                        <div style="float: left;" class="yuzde30 guncellebtn">
                            <a class="redbtn gonderbtn" style="cursor: pointer;" onclick="turnBackForm();"><?php echo __("admin/tools/button-turn-back"); ?></a>
                        </div>

                        <div style="float: right;" class="yuzde30 guncellebtn">
                            <a class="yesilbtn gonderbtn" style="cursor: pointer;" id="import_submit"><?php echo __("admin/tools/button-import"); ?></a>
                        </div>


                    </div>

                    <div id="importProcessing" style="display: none;">
                        <div style="margin-top:30px;margin-bottom:70px;text-align:center;">
                            <i style="font-size:80px;color: #00bcd4; -webkit-animation:fa-spin 2s infinite linear;animation: fa-spin 2s infinite linear;" class="fa fa-cog"></i>
                            <h4 style="font-weight:bold;color: #00bcd4;">İçeri Aktarılıyor.</h4>
                            <p id="part-message" style="font-weight: bold;">Kategoriler - Ürün/Hizmetler - Sayfalar Aktarılıyor...</p>
                            <p>Bu işlem bir kaç dakika sürebilir. Lütfen bekleyiniz.</p>
                        </div>
                    </div>


                    <div id="importCompleted" style="display: none;">
                        <div style="margin-top:30px;margin-bottom:70px;text-align:center;">
                            <i style="font-size:80px;" class="fa fa-check"></i>
                            <h4 style="font-weight:bold;">İçeri Aktarım Tamamlandı.</h4>
                            <p></p>
                        </div>
                    </div>


                    <div class="clear"></div>

                    <script type="text/javascript">
                        $(document).ready(function(){
                            $("#infoForm_submit").on("click",function(){
                                $("#infoForm input[name=apply]").val('0');
                                MioAjaxElement($(this),{
                                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                                    progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                                    result:"infoForm_handler",
                                });
                            });

                            $("#import_submit").on("click",function(){
                                $("#infoForm input[name=apply]").val('1');
                                $("#importDetails").fadeOut(300,function(){
                                    $("#importProcessing").fadeIn(300);
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
                                        if(solve.for != undefined && solve.for != ''){
                                            $("#infoForm "+solve.for).focus();
                                            $("#infoForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                            $("#infoForm "+solve.for).change(function(){
                                                $(this).removeAttr("style");
                                            });
                                        }
                                        if(solve.message != undefined && solve.message != '')
                                            alert_error(solve.message,{timer:5000});
                                    }else if(solve.status == "successful"){

                                        $("#hosting_categories_count").html(solve.count.hosting_categories);
                                        $("#software_categories_count").html(solve.count.software_categories);
                                        $("#normal_pages_count").html(solve.count.normal_pages);
                                        $("#articles_pages_count").html(solve.count.articles_pages);
                                        $("#references_pages_count").html(solve.count.references_pages);
                                        $("#software_pages_count").html(solve.count.software_pages);
                                        //$("#tlds_count").html(solve.count.tlds);
                                        $("#hosting_products_count").html(solve.count.hosting_products);
                                        $("#users_count").html(solve.count.users);
                                        $("#tickets_count").html(solve.count.tickets);
                                        $("#orders_count").html(solve.count.orders);
                                        $("#invoices_count").html(solve.count.invoices);

                                        $("#infoForm_layout").fadeOut(300,function(){
                                            $("#importDetails").fadeIn(300);
                                        });

                                        if(solve.message != undefined && solve.message != '')
                                            alert_success(solve.message,{timer:2000});

                                    }
                                }else
                                    console.log(result);
                            }
                        }
                        function import_handler(result){
                            if(result != ''){
                                var solve = getJson(result);
                                if(solve !== false){
                                    if(solve.status == "error"){
                                        $("#importProcessing").fadeOut(300,function(){
                                            $("#importDetails").fadeIn(300);
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
                                        console.log(solve);
                                        var message;
                                        if(solve.part == 2) message = "Müşteriler Aktarılıyor...";
                                        else if(solve.part == 3) message = "Siparişler Aktarılıyor...";
                                        else if(solve.part == 4) message = "Faturalar Aktarılıyor...";
                                        else if(solve.part == 5) message = "Destek Talepleri Aktarılıyor...";
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
                                        },3000);
                                    }
                                }else
                                    console.log(result);
                            }
                        }

                        function turnBackForm(){
                            $("#importDetails").fadeOut(300,function(){
                                $("#infoForm_layout").fadeIn(300);
                            });
                        }
                    </script>
                </form>

            </div>


        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>