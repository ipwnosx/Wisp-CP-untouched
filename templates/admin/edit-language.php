<!DOCTYPE html>
<html>
<head>
    <?php
        $plugins    = ['jquery-ui','select2'];
        include __DIR__.DS."inc".DS."head.php";
    ?>

    <script type="text/javascript">
        $(document).ready(function(){

            $("#editForm").bind("keypress", function(e) {
                if (e.keyCode == 13) $("#editForm_submit").click();
            });

            $("#editForm_submit").on("click",function(){
                MioAjaxElement($(this),{
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                    result:"editForm_handler",
                });
            });

            $("#countries").select2({
                templateResult: format_select2,
                templateSelection: format_select2,
            });

        });

        function format_select2(state) {
            if (!state.id) { return state.text; }
            var originalOption = state.element;
            var image_url = $(originalOption).data('image');
            if(image_url == undefined) return state.text;
            return $("<span><img class='select2-flag' src='" + image_url + "' /> "+state.text+"</span>");
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

        function exportFile(element){
            var val = $(element).val(),name,icon;
            if(val == ''){
                icon = "fa fa-cloud-upload";
                name = "<?php echo __("admin/languages/edit-upload-file"); ?>";
            }else{
                icon = "fa fa-check-square-o";
                name = val;
                if(name.search(/\\/i)>0){
                    name = name.split("\\");
                    name = name.slice(-1)[0];
                }
            }
            $("#upload-icon").removeAttr("class");
            $("#upload-icon").attr("class",icon);
            $("#show-file-name").html(name);
        }
    </script>

</head>
<body>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1><strong><?php echo __("admin/languages/page-edit"); ?></strong></h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="clear"></div>

            

            <div class="adminuyedetay">

                <form action="<?php echo $links["controller"]; ?>" method="post" id="editForm" enctype="multipart/form-data">
                    <input type="hidden" name="operation" value="edit_language">


                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/languages/add-select-country"); ?></div>
                        <div class="yuzde70">
                            <select name="country-id" id="countries">
                                <option value="0"><?php echo ___("needs/none"); ?></option>
                                <?php
                                    if(isset($countries) && $countries)
                                    {
                                        foreach($countries AS $country){
                                            ?>
                                            <option<?php echo isset($package["country-id"]) && $package["country-id"] == $country["id"] ? ' selected' : ''; ?> value="<?php echo $country["id"]; ?>" data-image="<?php echo $sadress."assets/images/flags/".strtolower($country["a2_iso"]).".svg"; ?>" data-languages="<?php echo $country["languages"]; ?>" data-a2-iso="<?php echo $country["a2_iso"]; ?>" data-phone-code="<?php echo $country["calling_code"]; ?>"><?php echo $country["name"]; ?></option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                            <span class="kinfo"><?php echo __("admin/languages/add-select-country-desc"); ?></span>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/languages/edit-language-info"); ?></div>
                        <div class="yuzde70">
                            <?php echo $package["name"]; ?>
                        </div>
                    </div>

                    <?php if(isset($package["copied"])): ?>
                        <div class="formcon">
                            <div class="yuzde30"><?php echo __("admin/languages/edit-copied-language"); ?></div>
                            <div class="yuzde70">
                                <?php echo $package["copied"]; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/languages/add-native-name"); ?></div>
                        <div class="yuzde70">
                            <input type="text" name="show-name" value="<?php echo $package["show-name"]; ?>">
                            <span class="kinfo"><?php echo __("admin/languages/add-native-name-desc"); ?></span>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/languages/edit-local"); ?></div>
                        <div class="yuzde70">
                            <input<?php echo $package["local"] ? ' checked' : ''; ?> type="radio" value="1" name="local" id="local" class="radio-custom">
                            <label class="radio-custom-label" for="local"><span class="kinfo"><?php echo __("admin/languages/edit-local-desc"); ?></span></label>
                            
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/languages/add-rtl"); ?></div>
                        <div class="yuzde70">
                            <input<?php echo isset($package["rtl"]) && $package["rtl"] ? ' checked' : ''; ?> id="rtl" type="checkbox" name="rtl" value="1" class="checkbox-custom">
                            <label for="rtl" class="checkbox-custom-label"><span class="kinfo"><?php echo __("admin/languages/add-rtl-active"); ?></span></label>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/languages/add-rank"); ?></div>
                        <div class="yuzde70">
                            <input type="text" name="rank" value="<?php echo $package["rank"] ? $package["rank"] : ''; ?>" style="width: 80px;">
                            <span class="kinfo"><?php echo __("admin/languages/add-rank-desc"); ?></span>
                        </div>
                    </div>


                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/languages/edit-status"); ?></div>
                        <div class="yuzde70">
                            <input<?php echo $package["status"] ? ' checked' : ''; ?> type="checkbox" name="status" value="1" class="sitemio-checkbox" id="status">
                            <label class="sitemio-checkbox-label" for="status"></label>
                        </div>
                    </div>


                    <div class="langupdown">
                    <div class="green-info" style="margin-top:20px;">
                        <div class="padding15">
                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/languages/edit-import"); ?></div>
                        <div class="yuzde70">
                            <input type="file" name="export-file" id="export-file" style="display: none;" onchange="exportFile(this);">


                            <div class="langupdownbts">
                                <a style="font-size:76px;    line-height: 25px;color:#4caf50;" href="javascript:$('#export-file').click();void 0;">
                                    <i id="upload-icon" class="fa fa-cloud-upload" aria-hidden="true"></i>
                                    <div class="clear"></div>
                                   <div style="font-size:15px;" id="show-file-name"><?php echo __("admin/languages/edit-upload-file"); ?></div>
                               </a>

                            </div>

                          <p><?php echo __("admin/languages/edit-import-desc"); ?></p>

                        </div>
                    </div>

                            <div class="clear"></div>
                        </div>
                    </div>



                    <div class="blue-info" style="margin-top:20px;">
                        <div class="padding15">
                    <div class="formcon" style="border:none;">
                        <div class="yuzde30"><?php echo __("admin/languages/edit-export"); ?></div>



                        <div class="yuzde70">

                            <div class="landdownloadbtns">

                            <div class="landdownload">
                                <a style="font-size:76px;    line-height: 25px;">
                                    <i class="fa fa-cloud-download" aria-hidden="true"></i>
                                    <div class="clear"></div>
                                   <div style="font-size:15px;"><?php echo __("admin/languages/edit-download-file"); ?></div>
                               </a>
                            </div>

                            <div class="landdownloadbtn">
                                <br>
                               <a href="<?php echo $links["export-excel"]; ?>" target="_blank" class="blue btn">EXCEL</a><br>
                            </div>

                         </div>

                          <p><?php echo __("admin/languages/edit-export-desc"); ?></p>

                        </div>
                    </div>

                            <div class="clear"></div>
                        </div>
                    </div>
                    </div>



                    <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                        <a class="yesilbtn gonderbtn" id="editForm_submit" href="javascript:void(0);"><?php echo __("admin/languages/edit-button"); ?></a>
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