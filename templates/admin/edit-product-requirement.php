<!DOCTYPE html>
<html>
<head>
    <?php
        Utility::sksort($lang_list,"local");
        $plugins    = ['jquery-ui'];
        include __DIR__.DS."inc".DS."head.php";
    ?>

    <style type="text/css">
        .option-highlight {
            background: #FFF;
            height:50px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){

            var tab = _GET("lang");
            if (tab != '' && tab != undefined) {
                $("#tab-lang .tablinks[data-tab='" + tab + "']").click();
            } else {
                $("#tab-lang .tablinks:eq(0)").addClass("active");
                $("#tab-lang .tabcontent:eq(0)").css("display", "block");
            }

            $(".options-sortable").sortable({
                placeholder: "option-highlight",
                handle:".option-bearer",
            }).disableSelection();

            $(".options-sortable").on("click",".option-delete",function(){
                var lang = $(this).data("lang");
                var wrap = $(this).parent();
                wrap.remove();
                $(".options-sortable").sortable("refresh");
            });

            $(".add-option").click(function(){
                var lang        = $(this).data("lang");
                var template    = $("#option-template").html();

                template        = template.replace(/{lang}/g,lang);

                $("#options_"+lang).append(template).sortable("refresh");
            });

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

            $('select[name=mcategory]').change(mcategory_trigger);

            mcategory_trigger();

        });

        function mcategory_trigger(){
            let selection = $('select[name=mcategory]').val();
            let selection_s = selection.split("_");
            if(selection_s.length > 1) selection = 'special';

            $("#module_wrap").css("display","none");
            $(".configurable-option-params-wrap").css("display","none");
            $(".module-key-wrap").css("display","none");

            if(selection === 'hosting' || selection === 'server' || selection === 'special')
            {
                $("#module_wrap").css("display","block");
                $("#"+selection+"-configurable-option-params").css("display","block");
                $(".module-key-wrap").css("display","inline-block");
            }

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

    </script>

</head>
<body>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1><strong><?php echo __("admin/products/page-edit-requirement"); ?></strong></h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="clear"></div>

            <ul id="option-template" style="display: none">
                <li style="text-align:center;">
                    <input style="width:260px;" name="options[{lang}][name][]" type="text" placeholder="<?php echo __("admin/products/add-requirement-option-name-ex"); ?>">
                    <div class="module-key-wrap" style="display: none;width:260px;">
                        <input style="width: 200px;" class="module-key" name="options[{lang}][mkey][]" type="text" placeholder="<?php echo __("admin/products/add-requirement-option-mkey"); ?>">
                        <a data-tooltip="<?php echo __("admin/products/add-requirement-option-mkey-ex"); ?>"><i class="fa fa-info-circle"></i></a>
                    </div>
                    <a href="javascript:void(0);" class="sbtn option-bearer"><i class="fa fa-arrows-alt"></i></a>
                    <a href="javascript:void(0);" class="red sbtn option-delete" data-lang="{lang}"><i class="fa fa-trash"></i></a>

                </li>
            </ul>

            <form action="<?php echo $links["controller"]; ?>" method="post" id="editForm" style="margin-top: 5px;">
                <input type="hidden" name="operation" value="edit_requirement">

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
                        $requirementl = $functions["get_requirement_wlang"];
                        foreach($lang_list AS $lang) {
                            $lkey       = $lang["key"];
                            $requirementx     = $requirementl($lkey);
                            if(!$requirementx) $requirementx = [];

                            $name           = isset($requirementx["name"]) ? $requirementx["name"] : false;
                            $description    = isset($requirementx["description"]) ? $requirementx["description"] : false;
                            $type           = isset($requirementx["type"]) ? $requirementx["type"] : false;
                            $options        = isset($requirementx["options"]) ? Utility::jdecode($requirementx["options"],true) : [];
                            $properties     = isset($requirementx["properties"]) ? Utility::jdecode($requirementx["properties"],true) : [];
                            $compulsory     = isset($properties["compulsory"]) ? $properties["compulsory"] : false;

                            if($lang["local"]){
                                $status     = $requirement["status"];
                                $rank       = $requirement["rank"];
                            }

                            ?>
                            <div id="lang-<?php echo $lkey; ?>" class="tabcontent">

                                <div class="adminpagecon">

                                  

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/products/add-requirement-name"); ?></div>
                                        <div class="yuzde70">
                                            <input type="text" name="name[<?php echo $lkey; ?>]" id="field-name-<?php echo $lkey; ?>" value="<?php echo $name; ?>">
                                        </div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/products/add-requirement-description"); ?></div>
                                        <div class="yuzde70">
                                            <textarea name="description[<?php echo $lkey; ?>]"><?php echo $description; ?></textarea>
                                        </div>
                                    </div>

                                    <?php if($lang["local"]): ?>

                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/products/add-requirement-category"); ?></div>
                                            <div class="yuzde70">
                                                <select name="category">
                                                    <?php
                                                        if(isset($categories) && $categories){
                                                            foreach($categories AS $category){
                                                                ?>
                                                                <option<?php echo $requirement["category"] == $category["id"] ? ' selected' : ''; ?> value="<?php echo $category["id"]; ?>"><?php echo $category["title"]; ?></option>
                                                                <?php
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/products/add-requirement-main-category"); ?></div>
                                            <div class="yuzde70">
                                                <select name="mcategory">
                                                    <option value=""><?php echo ___("needs/none"); ?></option>
                                                    <?php
                                                        if(isset($main_categories) && $main_categories){
                                                            foreach($main_categories AS $k=>$v){
                                                                ?>
                                                                <option<?php echo $requirement["mcategory"] == $k ? ' selected' : ''; ?> value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                                                <?php
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/products/add-requirement-status"); ?></div>
                                            <div class="yuzde70">
                                                <select name="status" style="width: 150px">
                                                    <option<?php echo $status=="active" ? ' selected' : ''; ?> value="active"><?php echo __("admin/products/status-active"); ?></option>
                                                    <option<?php echo $status=="inactive" ? ' selected' : ''; ?> value="inactive"><?php echo __("admin/products/status-inactive"); ?></option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/products/add-addon-rank"); ?></div>
                                            <div class="yuzde70">
                                                <input style="width: 50px;" type="text" name="rank" value="<?php echo $rank; ?>" onkeypress='return event.charCode>= 48 &&event.charCode<= 57'>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/products/add-requirement-compulsory"); ?></div>
                                        <div class="yuzde70">
                                            <input<?php echo $compulsory ? ' checked' : ''; ?> type="checkbox" name="compulsory[<?php echo $lkey; ?>]" value="1" id="compulsory-<?php echo $lkey; ?>" class="checkbox-custom">
                                            <label class="checkbox-custom-label" for="compulsory-<?php echo $lkey; ?>"><span class="kinfo"><?php echo __("admin/products/add-requirement-compulsory-label"); ?></span></label>
                                        </div>
                                    </div>

                                    <?php if($lang["local"]): ?>
                                        <?php
                                            $module_co_names = Utility::jdecode($requirement["module_co_names"],true);
                                            if(!$module_co_names) $module_co_names = [];
                                        ?>
                                        <div class="formcon" id="module_wrap" style="display: none;">
                                            <div class="yuzde30"><?php echo __("admin/products/module-co-names-1"); ?></div>
                                            <div class="yuzde70">
                                                <div class="blue-info">
                                                    <div class="padding20">
                                                        <i class="fa fa-info-circle"></i>
                                                        <p><?php echo __("admin/products/module-co-names-2"); ?></p>
                                                    </div>
                                                </div>
                                                <div class="clcear"></div>

                                                <div id="hosting-configurable-option-params" class="configurable-option-params-wrap" style="display: none;">

                                                    <?php
                                                        if(isset($module_servers) && $module_servers){
                                                            foreach($module_servers AS $mod => $module){
                                                                $mod_config = $module["config"];
                                                                $mod_lang   = $module["lang"];
                                                                if($mod_config["type"] != 'hosting') continue;
                                                                if(isset($mod_config["configurable-option-params"]) && $mod_config["configurable-option-params"]){
                                                                    $s_co_n = isset($module_co_names[$mod]) ? $module_co_names[$mod] : '';
                                                                    ?>
                                                                    <div class="formcon">
                                                                        <div class="yuzde30"><?php echo $mod; ?></div>
                                                                        <div class="yuzde70">
                                                                            <select name="module_co_names[<?php echo $mod; ?>]">
                                                                                <option value=""><?php echo ___("needs/none"); ?></option>
                                                                                <?php
                                                                                    foreach($mod_config["configurable-option-params"] AS $k=>$v){
                                                                                        ?>
                                                                                        <option<?php echo $s_co_n == $v ? ' selected' : ''; ?> value="<?php echo $v; ?>"><?php echo $v; ?></option>
                                                                                        <?php
                                                                                    }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                    ?>

                                                </div>
                                                <div class="clear"></div>
                                                <div id="server-configurable-option-params" class="configurable-option-params-wrap" style="display: none;">

                                                    <?php
                                                        if(isset($module_servers) && $module_servers){
                                                            foreach($module_servers AS $mod => $module){
                                                                $mod_config = $module["config"];
                                                                $mod_lang   = $module["lang"];
                                                                if($mod_config["type"] == 'hosting') continue;
                                                                if(isset($mod_config["configurable-option-params"]) && $mod_config["configurable-option-params"]){
                                                                    $s_co_n = isset($module_co_names[$mod]) ? $module_co_names[$mod] : '';
                                                                    ?>
                                                                    <div class="formcon">
                                                                        <div class="yuzde30"><?php echo $mod; ?></div>
                                                                        <div class="yuzde70">
                                                                            <select name="module_co_names[<?php echo $mod; ?>]">
                                                                                <option value=""><?php echo ___("needs/none"); ?></option>
                                                                                <?php
                                                                                    foreach($mod_config["configurable-option-params"] AS $k=>$v){
                                                                                        ?>
                                                                                        <option<?php echo $s_co_n == $v ? ' selected' : ''; ?> value="<?php echo $v; ?>"><?php echo $v; ?></option>
                                                                                        <?php
                                                                                    }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                    ?>

                                                </div>
                                                <div class="clear"></div>
                                                <div id="special-configurable-option-params" class="configurable-option-params-wrap" style="display: none;">

                                                    <?php
                                                        if(isset($module_products) && $module_products){
                                                            foreach($module_products AS $mod => $module){
                                                                $mod_config = $module["config"];
                                                                $mod_lang   = $module["lang"];
                                                                if(isset($mod_config["configurable-option-params"]) && $mod_config["configurable-option-params"]){
                                                                    $s_co_n = isset($module_co_names[$mod]) ? $module_co_names[$mod] : '';
                                                                    ?>
                                                                    <div class="formcon">
                                                                        <div class="yuzde30"><?php echo $mod; ?></div>
                                                                        <div class="yuzde70">
                                                                            <select name="module_co_names[<?php echo $mod; ?>]">
                                                                                <option value=""><?php echo ___("needs/none"); ?></option>
                                                                                <?php
                                                                                    foreach($mod_config["configurable-option-params"] AS $k=>$v){
                                                                                        ?>
                                                                                        <option<?php echo $s_co_n == $v ? ' selected' : ''; ?> value="<?php echo $v; ?>"><?php echo $v; ?></option>
                                                                                        <?php
                                                                                    }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <?php

                                                                }
                                                            }
                                                        }
                                                    ?>

                                                </div>

                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/products/add-requirement-type"); ?>
                                            <br><span class="kinfo" style="font-weight:normal"><?php echo __("admin/products/add-requirement-type-desc"); ?></span>
                                        </div>
                                        <div style="font-weight:600;" class="yuzde70">

                                            <input<?php echo $type=="input" ? ' checked' : ''; ?> type="radio" name="type[<?php echo $lkey; ?>]" value="input" id="type-input-<?php echo $lkey; ?>" class="radio-custom" onchange="if($(this).prop('checked')) $('#options_wrap_<?php echo $lkey; ?>').css('display','none'); else $('#options_wrap_<?php echo $lkey; ?>').css('display','block');">
                                            <label class="radio-custom-label" for="type-input-<?php echo $lkey; ?>" style="margin-right:15px;"><?php echo __("admin/products/add-requirement-type-input"); ?></label>

                                            <input<?php echo $type=="textarea" ? ' checked' : ''; ?> type="radio" name="type[<?php echo $lkey; ?>]" value="textarea" id="type-textarea-<?php echo $lkey; ?>" class="radio-custom" onchange="if($(this).prop('checked')) $('#options_wrap_<?php echo $lkey; ?>').css('display','none'); else $('#options_wrap_<?php echo $lkey; ?>').css('display','block');">
                                            <label class="radio-custom-label" for="type-textarea-<?php echo $lkey; ?>" style="margin-right:15px;"><?php echo __("admin/products/add-requirement-type-textarea"); ?></label>

                                            <input<?php echo $type=="file" ? ' checked' : ''; ?> type="radio" name="type[<?php echo $lkey; ?>]" value="file" id="type-file-<?php echo $lkey; ?>" class="radio-custom" onchange="if($(this).prop('checked')) $('#options_wrap_<?php echo $lkey; ?>').css('display','none'); else $('#options_wrap_<?php echo $lkey; ?>').css('display','block');">
                                            <label class="radio-custom-label" for="type-file-<?php echo $lkey; ?>" style="margin-right:15px;"><?php echo __("admin/products/add-requirement-type-file"); ?></label>

                                            <input<?php echo $type=="select" ? ' checked' : ''; ?> type="radio" name="type[<?php echo $lkey; ?>]" value="select" id="type-select-<?php echo $lkey; ?>" class="radio-custom" onchange="if($(this).prop('checked')) $('#options_wrap_<?php echo $lkey; ?>').css('display','block'); else $('#options_wrap_<?php echo $lkey; ?>').css('display','none');">
                                            <label class="radio-custom-label" for="type-select-<?php echo $lkey; ?>" style="margin-right:15px;"><?php echo __("admin/products/add-requirement-type-select"); ?></label>

                                            <input<?php echo $type=="radio" ? ' checked' : ''; ?>  type="radio" name="type[<?php echo $lkey; ?>]" value="radio" id="type-radio-<?php echo $lkey; ?>" class="radio-custom" onchange="if($(this).prop('checked')) $('#options_wrap_<?php echo $lkey; ?>').css('display','block'); else $('#options_wrap_<?php echo $lkey; ?>').css('display','none');">
                                            <label class="radio-custom-label" for="type-radio-<?php echo $lkey; ?>" style="margin-right:15px;"><?php echo __("admin/products/add-requirement-type-radio"); ?></label>

                                            <input<?php echo $type=="checkbox" ? ' checked' : ''; ?> type="radio" name="type[<?php echo $lkey; ?>]" value="checkbox" id="type-checkbox-<?php echo $lkey; ?>" class="radio-custom" onchange="if($(this).prop('checked')) $('#options_wrap_<?php echo $lkey; ?>').css('display','block'); else $('#options_wrap_<?php echo $lkey; ?>').css('display','none');">
                                            <label class="radio-custom-label" for="type-checkbox-<?php echo $lkey; ?>" style="margin-right:15px;"><?php echo __("admin/products/add-requirement-type-checkbox"); ?></label>

                                        </div>

                                        <div id="options_wrap_<?php echo $lkey; ?>"<?php echo $type == "select" || $type == "radio" || $type == "checkbox" ? '' : ' style="display:none;"'; ?>>

                                            <div class="clear"></div><br>
                                            <ul class="options-sortable" id="options_<?php echo $lkey; ?>" style="margin:0; padding: 0;">
                                                <?php
                                                    if($options){
                                                        foreach($options AS $option){
                                                            ?>
                                                            <li style="text-align:center;">
                                                                <input type="hidden" name="options[<?php echo $lkey; ?>][id][]" value="<?php echo $option["id"]; ?>">
                                                                <input style="width:260px;" name="options[<?php echo $lkey; ?>][name][]" type="text" placeholder="<?php echo __("admin/products/add-requirement-option-name-ex"); ?>" value="<?php echo $option["name"]; ?>">

                                                                <div class="module-key-wrap" style="display: none;width:260px;">
                                                                    <input style="width: 200px;" class="module-key" name="options[<?php echo $lkey; ?>][mkey][]" type="text" placeholder="<?php echo __("admin/products/add-requirement-option-mkey"); ?>" value="<?php echo isset($option["mkey"]) ? $option["mkey"] : ''; ?>">
                                                                    <a data-tooltip="<?php echo __("admin/products/add-requirement-option-mkey-ex"); ?>"><i class="fa fa-info-circle"></i></a>
                                                                </div>

                                                                <a href="javascript:void(0);" class="sbtn option-bearer"><i class="fa fa-arrows-alt"></i></a>
                                                                <a href="javascript:void(0);" class="red sbtn option-delete" data-lang="<?php echo $lkey; ?>"><i class="fa fa-trash"></i></a>

                                                            </li>
                                                            <?php
                                                        }
                                                    }
                                                ?>
                                            </ul>

                                            <div class="clear"></div>
                                            <br>

                                            <center><a href="javascript:void(0);" class="lbtn add-option" data-lang="<?php echo $lkey; ?>">+ <?php echo __("admin/products/add-requirement-add-option"); ?></a></center>
                                        </div>


                                    </div>


                                    <div class="clear"></div>
                                </div>


                                <div class="clear"></div>
                            </div>
                        <?php } ?>

                </div><!-- tab wrap content end -->

                <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                    <a class="yesilbtn gonderbtn" id="editForm_submit" href="javascript:void(0);"><?php echo __("admin/products/edit-requirement-button"); ?></a>
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