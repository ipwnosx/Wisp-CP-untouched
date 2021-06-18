<!DOCTYPE html>
<html>
<head>
    <?php
        $status         = $slide["status"];

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

        function delete_video(){
            var request = MioAjax({
                button_element:$("#video_remove"),
                waiting_text:'<i class="fa fa-spinner" style="-webkit-animation:fa-spin 2s infinite linear;animation: fa-spin 2s infinite linear;"></i>',
                action:"<?php echo $links["controller"]; ?>",
                method:"POST",
                data:{
                    "operation":"delete_slide_video",
                    "id": <?php echo $slide["id"]; ?>
                }
            },true,true);

            request.done(function(result){
                if(result != ''){
                    var solve = getJson(result);
                    if(solve !== false){
                        if(solve.status == "error"){
                            if(solve.message != undefined && solve.message != '')
                                alert_error(solve.message,{timer:5000});
                        }else if(solve.status == "successful"){
                            $("#video_play").remove();
                            $("#video_remove").remove();
                            $("input[name=video_duration]").val('');
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
                <h1><strong><?php echo __("admin/manage-website/page-slides-edit",['{title}' => $page_title]); ?></strong></h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="clear"></div>

            <form action="<?php echo $links["controller"]; ?>" method="post" id="editForm" style="margin-top: 5px;">
                <input type="hidden" name="operation" value="edit_slide">

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
                        $rank       = $slide["rank"] ? $slide["rank"] : NULL;
                        $extra      = $slide["extra"] ? Utility::jdecode($slide["extra"],true) : [];
                        $get_slidel = $functions["get_slide_with_lang"];
                        foreach($lang_list AS $lang) {
                            $lkey = $lang["key"];
                            $slidel      = $get_slidel($lkey);
                            if(!$slidel) $slidel = [];
                            $title      = isset($slidel["title"]) ? $slidel["title"] : false;
                            $description    = isset($slidel["description"]) ? $slidel["description"] : false;
                            $link       = isset($slidel["link"]) ? $slidel["link"] : false;
                            ?>
                            <div id="lang-<?php echo $lkey; ?>" class="tabcontent">

                                <div class="adminpageconxx">

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/manage-website/create-title"); ?></div>
                                        <div class="yuzde70">
                                            <input name="title[<?php echo $lkey; ?>]" type="text" value="<?php echo $title; ?>">
                                        </div>
                                    </div>


                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/manage-website/create-description"); ?></div>
                                        <div class="yuzde70">
                                            <textarea class="tinymce-1" name="description[<?php echo $lkey; ?>]" rows="3" placeholder=""><?php echo $description; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/manage-website/create-slide-link"); ?></div>
                                        <div class="yuzde70">
                                            <input type="text" name="link[<?php echo $lkey; ?>]" value="<?php echo $link; ?>">
                                            <span class="kinfo"><?php echo __("admin/manage-website/create-slide-link-desc"); ?></span>
                                        </div>
                                    </div>

                                    <?php if($lang["local"]): ?>

                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/manage-website/create-rank"); ?></div>
                                            <div class="yuzde70">
                                                <input type="text" name="rank" value="<?php echo $rank; ?>" class="yuzde10">
                                                <span class="kinfo"><?php echo __("admin/manage-website/create-rank-slide-desc"); ?></span>
                                            </div>
                                        </div>

                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/manage-website/create-status"); ?></div>
                                            <div class="yuzde70">
                                                <select name="status">
                                                    <option<?php echo $status == "active" ? ' selected' : ''; ?> value="active"><?php echo __("admin/manage-website/situations/active"); ?></option>
                                                    <option<?php echo $status == "inactive" ? ' selected' : ''; ?> value="inactive"><?php echo __("admin/manage-website/situations/inactive"); ?></option>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/manage-website/create-slide-image"); ?>
                                                <br><span class="kinfo"><?php echo __("admin/manage-website/create-slide-image-desc"); ?></span>
                                            </div>
                                            <div class="yuzde70">
                                                <div class="headerbgedit">
                                                    <input type="file" name="picture" id="picture" style="display:none;" onchange="read_image_file(this,'picture_preview');" data-default-image="<?php echo $getPictureDeft; ?>" />
                                                    <div class="headbgeditbtn">
                                                        <br/>
                                                        <a class="avatarguncelle" href="javascript:void(0);" onclick="$('#picture').click();" ><i class="fa fa-camera" aria-hidden="true"></i></a>
                                                    </div>
                                                    <img src="<?php echo $getPicture; ?>" width="100%" id="picture_preview">
                                                </div>

                                            </div>
                                        </div>

                                        <?php
                                        ?>

                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/manage-website/create-slide-video"); ?>
                                                <br><span class="kinfo"><?php echo __("admin/manage-website/create-slide-video-desc"); ?></span>
                                            </div>
                                            <div class="yuzde70">
                                                <input type="file" name="video" id="video" />
                                                <?php
                                                    if(isset($extra["video"]["file"])){
                                                        $file = Config::get("pictures/slides/folder").$extra["video"]["file"];
                                                        $file = Utility::link_determiner($file,false,false);
                                                        ?>
                                                        <div class="clear" style="margin-top:5px;"></div>
                                                        <a id="video_play" target="_blank" href="<?php echo $file; ?>" class="blue sbtn" data-tooltip="<?php echo ___("needs/view"); ?>"><i class="fa fa-play"></i></a>
                                                        <a id="video_remove" href="javascript:delete_video();void 0;" class="red sbtn" data-tooltip="<?php echo ___("needs/button-delete"); ?>"><i class="fa fa-trash-o"></i></a>
                                                        <?php
                                                    }
                                                ?>

                                                <div class="formcon">
                                                    <div class="yuzde30"><?php echo __("admin/manage-website/create-slide-video-duration"); ?></div>
                                                    <div class="yuzde70">
                                                        <input value="<?php echo isset($extra["video"]["duration"]) ? $extra["video"]["duration"] : ''; ?>" style="width: 80px;" type="text" name="video_duration" id="video_duration" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57' />
                                                    </div>
                                                </div>

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