<!DOCTYPE html>
<html>
<head>
    <?php
        $plugins    = ['jquery-ui','select2'];
        include __DIR__.DS."inc".DS."head.php";
    ?>

    <script type="text/javascript">
        var before_term = false;

        escapeStringRegExp.matchOperatorsRe = /[|\\{}()[\]^$+*?.]/g;
        function escapeStringRegExp(str) {
            return str.replace(escapeStringRegExp.matchOperatorsRe, '\\$&');
        }

        $(document).ready(function(){


            $("#select-language").select2({
                templateResult: format_select2,
                templateSelection: format_select2,
            });

            $("#updateForm_submit").on("click",function(){
                $(".search-item textarea").not(".is-changed").attr("disabled",true);
                MioAjaxElement($(this),{
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                    result:"updateForm_handler",
                });
            });


            $("#search-box").on("keyup",function(e){

                var value = $(this).val();
                var term = escapeStringRegExp(value);
                var found_count = 0;

                if(value.length>2){
                    if(term != before_term){
                        before_term = term;
                        found_count = 0;

                        $('.search-item').each(function(){
                            var key_text    = $(".key-item",this).text();
                            var value_text  = $(".value-item",this).val();
                            var search1     = key_text.search(term);
                            var search2     = value_text.search(term);
                            if(search1 != -1 || search2 != -1){
                                found_count++;
                                $(this).addClass("is-found");
                            }else{
                                $(this).removeClass("is-found");
                            }
                        });

                        if(found_count>0){
                            $(".search-item").css("display","none");
                            $("#not-found").css("display","none");
                            $(".is-found").css("display","block");
                            $("#updateButton").css("display","block");

                            $("#is-found").css("display","block");
                            var is_found_text = "<?php echo str_replace('"','\"',__("admin/languages/find-and-replace-is-found-match")); ?>";
                            value = $('<div />').text(value).html();
                            is_found_text = is_found_text.replace("{word}",value);
                            is_found_text = is_found_text.replace("{count}",found_count);
                            $("#is-found-text").html(is_found_text);

                        }else{
                            $("#is-found").css("display","none");
                            $(".search-item").css("display","none");
                            $("#not-found").css("display","block");
                            var not_found_text = "<?php echo str_replace('"','\"',__("admin/languages/find-and-replace-not-found-match")); ?>";
                            value = $('<div />').text(value).html();
                            not_found_text = not_found_text.replace("{word}",value);
                            $("#not-found-text").html(not_found_text);
                            $("#updateButton").css("display","none");
                        }
                    }
                }else{
                    $("#is-found").css("display","none");
                    $("#not-found").css("display","none");
                    $(".search-item").css("display","none").removeClass("is-found");
                    $("#updateButton").css("display","none");
                }
            });

            $(".search-item textarea").change(function(){
                $(this).addClass("is-changed");
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

                        $(".search-item textarea").attr("disabled",false);
                        $(".search-item textarea").removeClass("is-changed");

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

        function format_select2(state) {
            if (!state.id) { return state.text; }
            var originalOption = state.element;
            var image_url = $(originalOption).data('image');
            if(image_url == undefined) return state.text;
            return $("<span><img class='select2-flag' src='" + image_url + "' /> "+state.text+"</span>");
        }
    </script>

</head>
<body>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1><strong><?php echo __("admin/languages/page-find-and-replace"); ?></strong></h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="clear"></div>



            <div class="adminpagecon">

                <div class="green-info">
                    <div class="padding20">
                        <i class="fa fa-info-circle"></i>
                        <p><?php echo __("admin/languages/find-and-replace-description"); ?></p>
                    </div>
                </div><br><br>

                <div class="formcon">
                    <div class="yuzde30"><?php echo __("admin/languages/find-and-replace-select-language"); ?></div>
                    <div class="yuzde70">
                        <select id="select-language" onchange="window.location.href=this.options[this.selectedIndex].value;">>
                            <?php
                                if(isset($languages) && $languages){
                                    foreach($languages AS $lang){
                                        $flag       = $lang["country-id"] ? strtolower($lang["country-code"]) : "en";
                                        $selected   = isset($package) && $key == $lang["key"] ? ' selected' : '';
                                        ?>
                                        <option<?php echo $selected; ?> value="<?php echo $links["controller"]."?key=".$lang["key"]; ?>" data-image="<?php echo $sadress."assets/images/flags/".$flag.".svg"; ?>"><?php echo $lang["country-name"]." (".$lang["show-name"].")"; ?></option>
                                        <?php
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <?php if(isset($package) && $package): ?>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/languages/find-and-replace-search"); ?></div>
                        <div class="yuzde70">
                            <input id="search-box" type="search" value="" placeholder="<?php echo __("admin/languages/find-and-replace-search-placeholder"); ?>">
                        </div>
                    </div>

                    <div class="clear"></div>
                    <div id="not-found" class="red-info" style="display: none;margin-top:20px;font-weight:600;    line-height: 35px;">
                        <div class="padding20">
                            <i class="fa fa-ban" aria-hidden="true"></i>
                            <span id="not-found-text"></span><div class="clear"></div>
                        </div>
                    </div>

                    <div class="clear"></div>

                    <div id="is-found" class="blue-info" style="display: none;margin-top:20px;font-weight:600;    line-height: 35px;">
                        <div class="padding20">
                            <i class="fa fa-quote-left" aria-hidden="true"></i>
                            <p><span id="is-found-text"></span><div class="clear"></div></p>
                        </div>
                    </div>

                    <div class="clear"></div>

                    <form action="<?php echo $links["controller"]; ?>?key=<?php echo $key; ?>" method="post" id="updateForm">
                        <input type="hidden" name="operation" value="update_language">
                        <?php
                            if(isset($values) && $values){
                                $i=0;
                                foreach($values AS $k=>$v){
                                    $i++;
                                    if(is_array($v)){
                                        $content    = isset($v["content"]) ? $v["content"] : NULL;
                                        $variables  = isset($v["variables"]) ? $v["variables"] : NULL;
                                    }else{
                                        $content    = $v;
                                        $variables  = NULL;
                                    }
                                    ?>
                                    <div class="formcon search-item" style="display: none;">
                                        <div class="yuzde30 key-item"><?php echo $k; ?></div>
                                        <div class="yuzde70">
                                            <textarea name="values[<?php echo $k; echo $variables ? '/content' : ''; ?>]" rows="2" class="value-item"><?php echo $content; ?></textarea>
                                            <?php if($variables): ?>
                                                <span class="kinfo"><?php echo __("admin/languages/find-and-replace-variables"); ?>: <?php echo is_array($variables) ? implode(",",$variables) : $variables; ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                        ?>



                        <div style="float:right;margin-top:10px; display: none;" class="guncellebtn yuzde30" id="updateButton">
                            <a class="yesilbtn gonderbtn" id="updateForm_submit" href="javascript:void(0);"><?php echo __("admin/languages/edit-button"); ?></a>
                        </div>
                        <div class="clear"></div>
                    </form>

                <?php endif; ?>


            </div>


            <div class="clear"></div>
        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>