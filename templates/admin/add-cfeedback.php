<!DOCTYPE html>
<html>
<head>
    <?php
        Utility::sksort($lang_list,"local");
        $plugins    = ['jquery-ui'];
        include __DIR__.DS."inc".DS."head.php";
    ?>

    <script type="text/javascript">
        $(document).ready(function(){

            var tab2 = _GET("lang");
            if (tab2 != '' && tab2 != undefined) {
                $("#tab-lang .tablinks[data-tab='" + tab2 + "']").click();
            } else {
                $("#tab-lang .tablinks:eq(0)").addClass("active");
                $("#tab-lang .tabcontent:eq(0)").css("display", "block");
            }

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
                <h1><strong><?php echo __("admin/manage-website/page-cfeedbacks-create"); ?></strong></h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="clear"></div>

            <form action="<?php echo $links["controller"]; ?>" method="post" id="addNewForm" style="margin-top: 5px;">
                <input type="hidden" name="operation" value="add_cfeedback">

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


                                    <?php if($lang["local"]): ?>

                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/manage-website/create-cfeedback-name"); ?></div>
                                            <div class="yuzde70">
                                                <input type="text" name="full_name" value="">
                                            </div>
                                        </div>

                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/manage-website/create-cfeedback-company-name"); ?></div>
                                            <div class="yuzde70">
                                                <input type="text" name="company_name" value="">
                                            </div>
                                        </div>

                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/manage-website/create-cfeedback-email"); ?></div>
                                            <div class="yuzde70">
                                                <input type="text" name="email" value="">
                                            </div>
                                        </div>

                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/manage-website/create-status"); ?></div>
                                            <div class="yuzde70">
                                                <select name="status">
                                                    <option value="approved"><?php echo __("admin/manage-website/situations/approved"); ?></option>
                                                    <option value="pending"><?php echo __("admin/manage-website/situations/pending"); ?></option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/manage-website/create-rank"); ?></div>
                                            <div class="yuzde70">
                                                <input type="text" name="rank" value="" class="yuzde10">
                                                <span class="kinfo"><?php echo __("admin/manage-website/create-rank-cfeedback-desc"); ?></span>
                                            </div>
                                        </div>


                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/manage-website/create-cfeedback-image"); ?>
                                                <br><span class="kinfo"><?php echo __("admin/manage-website/create-cfeedback-image-desc"); ?></span>
                                            </div>
                                            <div class="yuzde70">
                                                <div class="headerbgedit">
                                                    <input type="file" name="picture" id="picture" style="display:none;" onchange="read_image_file(this,'picture_preview');" data-default-image="<?php echo $getPictureDeft; ?>" />
                                                    <div class="headbgeditbtn">
                                                        <a href="javascript:$('#picture').val('').trigger('change');void 0;" class="photosil"><i class="fa fa-trash"></i></a><br/>
                                                        <a class="avatarguncelle" href="javascript:void(0);" onclick="$('#picture').click();" ><i class="fa fa-camera" aria-hidden="true"></i></a>
                                                    </div>
                                                    <img src="<?php echo $getPictureDeft; ?>" style="    height: 120px;    width: auto;" id="picture_preview">
                                                </div>

                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/manage-website/create-cfeedback-message"); ?></div>
                                        <div class="yuzde70">
                                            <textarea rows="7" name="message[<?php echo $lkey; ?>]"></textarea>
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
                    <a class="yesilbtn gonderbtn" id="addNewForm_submit" href="javascript:void(0);"><?php echo ___("needs/button-create"); ?></a>
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