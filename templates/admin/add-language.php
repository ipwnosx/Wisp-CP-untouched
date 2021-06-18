<!DOCTYPE html>
<html>
<head>
    <?php
        $plugins    = ['jquery-ui','select2'];
        include __DIR__.DS."inc".DS."head.php";
    ?>

    <script type="text/javascript">

        function format_select2(state) {
            if (!state.id) { return state.text; }
            var originalOption = state.element;
            var image_url = $(originalOption).data('image');
            if(image_url == undefined) return state.text;
            return $("<span><img class='select2-flag' src='" + image_url + "' /> "+state.text+"</span>");
        }

        function format(state) {
            if (!state.id) return state.text; // optgroup
            return "<img class='' src='images/flags/" + state.id.toLowerCase() + ".png'/>" + state.text;
        }

        var currencies;

        $(document).ready(function(){

            $("#countries,#copy-language").select2({
                templateResult: format_select2,
                templateSelection: format_select2,
            });

            currencies = $("#currencies").select2();

            $("#addNewForm").bind("keypress", function(e) {
                if (e.keyCode == 13) $("#addNewForm_submit").click();
            });

            $("#countries").change(function(){

                var value       = $(this).val();

                if(value == '' || value == 0){
                    $("#select_lang_wrap").fadeOut(100);
                }else{

                    var a2_iso      = $("option:selected",this).data("a2-iso");
                    var languages   = $("option:selected",this).data("languages");
                    var pcode       = $("option:selected",this).data("phone-code");

                    $("#country-code").val(a2_iso);
                    $("#phone-code").val(pcode);

                    $(".select-language-content").fadeOut(1);

                    if(languages.search(",")==-1)
                        languages   = [languages];
                    else
                        languages   = languages.split(",");

                    var v,size        = languages.length-1;
                    for(i=0;i<=size;i++){
                        v = languages[i];
                        $("#lang_"+v+"_wrap").fadeIn(1);
                        if(i == 0) $("#lang_"+v).prop("checked",true);
                    }

                    $("#select_lang_wrap").fadeIn(100);
                }

            });

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
                <h1><strong><?php echo __("admin/languages/page-add"); ?></strong></h1>
                <?php
                $ui_help_link = 'https://docs.wisecp.com/en/kb/creating-a-new-language';
                if($ui_lang == "tr") $ui_help_link = 'https://docs.wisecp.com/tr/kb/yeni-dil-olusturmak';
                ?>
                <a title="<?php echo __("admin/help/usage-guide"); ?>" target="_blank" class="pagedocslink" href="<?php echo $ui_help_link; ?>"><i class="fa fa-life-ring" aria-hidden="true"></i></a>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="clear"></div>

            <div class="green-info">
                <div class="padding20">
                    <i class="fa fa-info-circle"></i>
                    <p><?php echo __("admin/languages/add-description"); ?></p>
                </div>
            </div>

            <div class="adminuyedetay">

                <form action="<?php echo $links["controller"]; ?>" method="post" id="addNewForm">
                    <input type="hidden" name="operation" value="add_new_language">

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/languages/add-select-country"); ?></div>
                        <div class="yuzde70">
                            <select name="country-id" id="countries">
                                <option value="0"><?php echo __("admin/languages/add-please-select"); ?></option>
                                <?php
                                    foreach($countries AS $country){
                                        ?>
                                        <option value="<?php echo $country["id"]; ?>" data-image="<?php echo $sadress."assets/images/flags/".strtolower($country["a2_iso"]).".svg"; ?>" data-languages="<?php echo $country["languages"]; ?>" data-a2-iso="<?php echo $country["a2_iso"]; ?>" data-phone-code="<?php echo $country["calling_code"]; ?>"><?php echo $country["name"]; ?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                            <span class="kinfo"><?php echo __("admin/languages/add-select-country-desc"); ?></span>
                        </div>
                    </div>

                    <div class="formcon" id="select_lang_wrap" style="display: none;">
                        <div class="yuzde30"><?php echo __("admin/languages/add-select-language"); ?></div>
                        <div class="yuzde70">
                            <?php
                                foreach($_languages AS $code=>$name){
                                    $code = strtolower($code);
                                    ?>
                                    <div id="lang_<?php echo $code; ?>_wrap" class="select-language-content" style="display:none;float: left; margin-right: 15px;">
                                        <input type="radio" class="radio-custom" name="language" value="<?php echo $code; ?>" id="lang_<?php echo $code; ?>">
                                        <label class="radio-custom-label" for="lang_<?php echo $code; ?>"><?php echo $name; ?></label>
                                    </div>
                                    <?php
                                }
                            ?>
                            <div class="clear"></div>
                            <span class="kinfo"><?php echo __("admin/languages/add-select-language-desc"); ?></span>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/languages/add-copy-language"); ?></div>
                        <div class="yuzde70">
                            <select name="copy_lang" id="copy-language">
                                <?php
                                    foreach($current_languages AS $lang){
                                        $flag       = $lang["country-id"] ? strtolower($lang["country-code"]) : "en";
                                        $selected   = isset($package) && $key == $lang["key"] ? ' selected' : '';
                                        ?>
                                        <option<?php echo $selected; ?> value="<?php echo $lang["key"]; ?>" data-image="<?php echo $sadress."assets/images/flags/".$flag.".svg"; ?>"><?php echo $lang["country-name"]." (".$lang["show-name"].")"; ?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                            <span class="kinfo"><?php echo __("admin/languages/add-copy-language-desc"); ?></span>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/languages/add-native-name"); ?></div>
                        <div class="yuzde70">
                            <input type="text" name="show-name" value="">
                            <span class="kinfo"><?php echo __("admin/languages/add-native-name-desc"); ?></span>
                        </div>
                    </div>

                    <div class="formcon" style="display: none;">
                        <div class="yuzde30"><?php echo __("admin/languages/add-country-code"); ?></div>
                        <div class="yuzde70">
                            <input type="text" readonly name="country-code" value="" id="country-code" style="width: 80px;">
                            <span class="kinfo"><?php echo __("admin/languages/add-country-code-desc"); ?></span>
                        </div>
                    </div>

                    <div class="formcon" style="display: none;">
                        <div class="yuzde30"><?php echo __("admin/languages/add-phone-code"); ?></div>
                        <div class="yuzde70">
                            <input type="text" readonly name="phone-code" value="" id="phone-code" style="width: 80px;">
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/languages/add-rtl"); ?></div>
                        <div class="yuzde70">
                            <input id="rtl" type="checkbox" name="rtl" value="1" class="checkbox-custom">
                            <label for="rtl" class="checkbox-custom-label"><span class="kinfo"><?php echo __("admin/languages/add-rtl-active"); ?></span></label>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/languages/add-rank"); ?></div>
                        <div class="yuzde70">
                            <input type="text" name="rank" value="" style="width: 80px;">
                            <span class="kinfo"><?php echo __("admin/languages/add-rank-desc"); ?></span>
                        </div>
                    </div>



                    <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                        <a class="yesilbtn gonderbtn" id="addNewForm_submit" href="javascript:void(0);"><?php echo __("admin/languages/add-new-button"); ?></a>
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