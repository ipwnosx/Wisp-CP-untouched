<!DOCTYPE html>
<html>
<head>
    <?php
        $status         = $cfeedback["status"];

        if(!$getPicture) $getPicture = $getPictureDeft;

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

            $("#editForm_submit").on("click",function(){
                MioAjaxElement($(this),{
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                    result:"editForm_handler",
                });
            });

        });

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

        function delete_picture(){
            $("#picture").val('');
            $("#picture_preview").attr("src","<?php echo $getPictureDeft; ?>");

            var request = MioAjax({
                action:"<?php echo $links["controller"]; ?>",
                method:"POST",
                data:{operation:"delete_cfeedback_image"}
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
                <h1><strong><?php echo __("admin/manage-website/page-cfeedbacks-edit",['{title}' => $page_title]); ?></strong></h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="clear"></div>

            <form action="<?php echo $links["controller"]; ?>" method="post" id="editForm" style="margin-top: 5px;">
                <input type="hidden" name="operation" value="edit_cfeedback">

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
                        $full_name      = $cfeedback["full_name"];
                        $company_name   = $cfeedback["company_name"];
                        $email          = $cfeedback["email"];
                        $rank           = $cfeedback["rank"] ? $cfeedback["rank"] : NULL;
                        $get_cfeedbackl = $functions["get_cfeedback_with_lang"];
                        foreach($lang_list AS $lang) {
                            $lkey = $lang["key"];
                            $cfeedbackl      = $get_cfeedbackl($lkey);
                            if(!$cfeedbackl) $cfeedbackl = [];
                            $message     = isset($cfeedbackl["message"]) ? $cfeedbackl["message"] : false;
                            ?>
                            <div id="lang-<?php echo $lkey; ?>" class="tabcontent">

                                <div class="adminpageconxx">

                                    <?php if($lang["local"]): ?>

                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/manage-website/create-cfeedback-name"); ?></div>
                                            <div class="yuzde70">
                                                <input type="text" name="full_name" value="<?php echo $full_name; ?>">
                                            </div>
                                        </div>

                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/manage-website/create-cfeedback-company-name"); ?></div>
                                            <div class="yuzde70">
                                                <input type="text" name="company_name" value="<?php echo $company_name; ?>">
                                            </div>
                                        </div>

                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/manage-website/create-cfeedback-email"); ?></div>
                                            <div class="yuzde70">
                                                <input type="text" name="email" value="<?php echo $email; ?>">
                                            </div>
                                        </div>

                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/manage-website/create-status"); ?></div>
                                            <div class="yuzde70">
                                                <select name="status">
                                                    <option<?php echo $status == "approved" ? ' selected' : ''; ?> value="approved"><?php echo __("admin/manage-website/situations/approved"); ?></option>
                                                    <option<?php echo $status == "pending" ? ' selected' : ''; ?> value="pending"><?php echo __("admin/manage-website/situations/pending"); ?></option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/manage-website/create-rank"); ?></div>
                                            <div class="yuzde70">
                                                <input type="text" name="rank" value="<?php echo $rank; ?>" class="yuzde10">
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
                                                        <a href="javascript:delete_picture();void 0;" class="photosil"><i class="fa fa-trash"></i></a><br/>
                                                        <a class="avatarguncelle" href="javascript:void(0);" onclick="$('#picture').click();" ><i class="fa fa-camera" aria-hidden="true"></i></a>
                                                    </div>
                                                    <img src="<?php echo $getPicture; ?>" style="    height: 120px;    width: auto;"  id="picture_preview">
                                                </div>

                                            </div>
                                        </div>

                                    <?php endif; ?>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/manage-website/create-cfeedback-message"); ?></div>
                                        <div class="yuzde70">
                                            <textarea rows="7" name="message[<?php echo $lkey; ?>]"><?php echo $message; ?></textarea>
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
                    <a class="yesilbtn gonderbtn" id="editForm_submit" href="javascript:void(0);"><?php echo ___("needs/button-update"); ?></a>
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