<!DOCTYPE html>
<html>
<head>
    <?php
        Utility::sksort($lang_list,"local");
        $plugins    = ['tinymce-1'];
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
    </script>
</head>
<body>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1><strong><?php echo __("admin/manage-website/page-pages-contracts"); ?></strong></h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="clear"></div>

            <form action="<?php echo $links["controller"]; ?>" method="post" id="updateForm">
                <input type="hidden" name="operation" value="update_contracts">



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

                            $category   = ___("constants/category-sms",false,$lkey);
                            $seo        = __("website/products/meta-sms",false,$lkey);
                            ?>
                            <div id="lang-<?php echo $lkey; ?>" class="tabcontent">

                                <div class="adminpagecon">

                                    <div class="formcon">
                                        <div style="font-weight: bold; margin-bottom: 10px;"><?php echo __("admin/manage-website/contract1"); ?></div>
                                        <textarea class="tinymce-1" name="contract1[<?php echo $lkey; ?>]" rows="3" placeholder=""><?php echo ___("constants/contract1",false,$lkey); ?></textarea>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/manage-website/contract-link"); ?></div>
                                        <div class="yuzdde70">
                                            <?php $link = Controllers::$init->CRLink("contract1",false,$lkey); ?>
                                            <a href="<?php echo $link; ?>" target="_blank"><?php echo $link; ?></a>
                                        </div>
                                    </div>

                                    <div class="clear"></div>
                                    <br>
                                    <br>

                                    <div class="formcon">
                                        <div style="font-weight: bold; margin-bottom: 10px;"><?php echo __("admin/manage-website/contract2"); ?></div>
                                        <textarea class="tinymce-1" name="contract2[<?php echo $lkey; ?>]" rows="3" placeholder=""><?php echo ___("constants/contract2",false,$lkey); ?></textarea>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/manage-website/contract-link"); ?></div>
                                        <div class="yuzdde70">
                                            <?php $link = Controllers::$init->CRLink("contract2",false,$lkey); ?>
                                            <a href="<?php echo $link; ?>" target="_blank"><?php echo $link; ?></a>
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
                    <a class="yesilbtn gonderbtn" id="updateForm_submit" href="javascript:void(0);"><?php echo ___("needs/button-update"); ?></a>
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