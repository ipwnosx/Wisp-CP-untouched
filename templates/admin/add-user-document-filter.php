<!DOCTYPE html>
<html>
<head>
    <?php
        Utility::sksort($lang_list,"local");
        $plugins    = ['jquery-ui'];
        include __DIR__.DS."inc".DS."head.php";
    ?>

    <script type="text/javascript">
        var rule_last_id = -1;
        var field_last_id = [];
        $(document).ready(function(){

            var tab = _GET("lang");
            if (tab != '' && tab != undefined) {
                $("#tab-lang .tablinks[data-tab='" + tab + "']").click();
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

            add_filter_rule();
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

        function selected_filter(el){
            var el          = $(el);
            var section     = el.val();
            var fn_el       = $(el).parent().next();
            var cty_el      = $(".country-city-wrap",fn_el);
            var otr_el      = $("."+section+"-wrap",fn_el);

            if(section === "country-city"){
                cty_el.css("display","block");

                $(".country-item",cty_el).val('');

                $(".city-item",cty_el).attr("disabled",false);
                $(".city-item",cty_el).css("display","none");

            }
            else{
                cty_el.css("display","none");
                $(".country-item",cty_el).val('');
                $(".city-item",cty_el).val('');
            }

            $(".other-wrappers",fn_el).css("display","none");
            $("select,input",otr_el).attr("disabled",true);

            if(otr_el !== undefined){
                otr_el.css("display","block");
                $("select,input",otr_el).attr("disabled",false);
            }

        }
        function selected_field(el){
            var el          = $(el);
            var section     = el.val();
            var fn_el       = $(el).parent().parent().parent();

            var otr_el      = $("."+section+"-wrap",fn_el);
            var opts_el     = $(".options-wrap",fn_el);

            $(".other-wrappers",fn_el).css("display","none");

            if(in_array(section,['select','radio','checkbox'])){
                opts_el.css("display","block");
            }else{
                opts_el.css("display","none");
            }

            if(otr_el !== undefined){
                otr_el.css("display","block");
                $("select,input",otr_el).attr("disabled",false);
            }

        }

        function selected_country(el){
            var i_wrap = $(el).parent().parent().parent();
            var f_type = $(".yuzde30 select option:selected",i_wrap).val();

            var values      = cities_data[$(el).val()];
            var cities_el   = $(el).next(".city-item");


            if(f_type === "country-city"){
                cities_el.html('');
                cities_el.append('<option value=""><?php echo ___("needs/select-your"); ?></option>');
                $(values).each(function(){
                    cities_el.append('<option value="'+this.id+'">'+this.name+'</option>');
                });
                cities_el.attr("disabled",false);
                cities_el.css("display","block");
            }else{
                cities_el.attr("disabled",true);
                cities_el.css("display","none");
            }
        }

        function add_filter_rule(){
            var template = $("#template-rule-item").html();
            rule_last_id++;

            template = template.replace(/rules\[x\]/g,"rules["+rule_last_id+"]");

            $("#rules_wrapper").append(template);

        }
        function add_filter_field(l_key){
            var template = $("#template-field-item").html();
            if(typeof(field_last_id[l_key]) === "undefined") field_last_id[l_key] = -1;

            field_last_id[l_key]++;

            template = template.replace(/fields\[l\]\[x\]/g,"fields["+l_key+"]["+field_last_id[l_key]+"]");

            $("#"+l_key+"-fields_wrapper").append(template);
        }

        function add_option_in_field(el){
            var m_el            = $(el).parent().parent().parent().parent();
            var template        = $(".template-field-option",m_el).html();

            $(".field-options-wrap",m_el).append(template);
        }
    </script>
</head>
<body>

<div id="template-rule-item" style="display: none;">
    <div class="rule-item">
        <div class="yuzde30">
            <select name="rules[x][type]" onchange="selected_filter(this);">
                <option value=""><?php echo ___("needs/select-your"); ?></option>
                <?php
                    foreach($_rules AS $r_key => $_rule){
                        ?>
                        <option value="<?php echo $r_key; ?>"><?php echo $_rule; ?></option>
                        <?php
                    }
                ?>
            </select>
        </div>
        <div class="yuzde60">
            <div class="country-city-wrap" style="display: none;">
                <select name="rules[x][country]" class="yuzde50 country-item" onchange="selected_country(this);" style="float:left;">
                    <option value=""><?php echo ___("needs/select-your"); ?></option>
                    <?php
                        $cities = [];
                        foreach(AddressManager::getCountries("t1.id,t2.name") AS $row){
                            $cities[$row["id"]] = AddressManager::getCities($row["id"]);
                            ?>
                            <option value="<?php echo $row["id"]; ?>"><?php echo $row["name"]; ?></option>
                            <?php
                        }
                    ?>
                </select>
                <select name="rules[x][city]" class="yuzde50 city-item" style="display: none;">
                </select>
                <div class="clear"></div>
            </div>
            <div class="age-wrap other-wrappers" style="display: none;">
                <input type="number" name="rules[x][age]" value="18" placeholder="" style="width:50px;">
                <select name="rules[x][age_condition]" style="width: 100px;">
                    <option value="up"><?php echo __("admin/users/document-filter-rule-age-up"); ?></option>
                    <option value="down"><?php echo __("admin/users/document-filter-rule-age-down"); ?></option>
                </select>
            </div>
            <div class="last-login-diff-wrap other-wrappers" style="display: none;">
                <input type="number" name="rules[x][day]" value="30" placeholder="" style="width:50px;">
            </div>
            <div class="account-type-wrap other-wrappers" style="display: none;">
                <select name="rules[x][kind]" style="width: 180px;">
                    <option value="individual"><?php echo __("admin/users/create-ac-type-individual"); ?></option>
                    <option value="corporate"><?php echo __("admin/users/create-ac-type-corporate"); ?></option>
                </select>
            </div>
            <div class="ip-subnet-wrap other-wrappers" style="display: none;">
                <input type="text" name="rules[x][value]" value="" placeholder="<?php echo __("admin/users/document-filter-rule-ip-subnet-ex"); ?>" class="yuzde50">
            </div>
        </div>
        <div class="yuzde5"><a href="javascript:void 0;" onclick="$(this).parent().parent().remove();" class="sbtn red"><i class="fa fa-trash"></i></a></div>
    </div>
</div>
<div id="template-field-item" style="display: none;">
    <div class="field-item">
        <div class="template-field-option" style="display: none;">
            <div class="field-option-item">
                <div style="width: 98%;">
                    <input type="text" name="fields[l][x][options][]" placeholder="<?php echo __("admin/users/document-filter-f-option-name"); ?>" class="yuzde90">
                    <a class="sbtn red" href="javascript:void 0;" onclick="$(this).parent().remove();"><i class="fa fa-remove"></i></a>
                </div>
            </div>
        </div>

        <div class="fieldcon">
            <div class="fieldcon2">
                <input type="text" name="fields[l][x][name]" value="" placeholder="<?php echo Filter::html_clear(__("admin/users/document-filter-f-desc")); ?>">
            </div>
            <div class="fieldcon3">
                <select name="fields[l][x][type]" onchange="selected_field(this);">
                    <?php
                        foreach(['input','textarea','select','radio','checkbox','file'] AS $row){
                            ?>
                            <option value="<?php echo $row; ?>"><?php echo __("admin/users/document-filter-f-type-".$row); ?></option>
                            <?php
                        }
                    ?>
                </select>
                <a href="javascript:void 0;" onclick="$(this).parent().parent().parent().remove();" class="sbtn red"><i class="fa fa-trash"></i></a>

                <div class="options-wrap other-wrappers formcon" style="display: none;">
                    <div class="field-options-wrap">

                    </div>
                    <div class="clear"></div>
                    <br>
                    <a class="lbtn blue" href="javascript:void 0;" onclick="add_option_in_field(this);"><i class="fa fa-plus"></i> <?php echo __("admin/users/document-filter-f-add-option"); ?></a>

                </div>
                <div class="file-wrap other-wrappers formcon" style="display: none;">

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/users/document-filter-f-allowed-ext"); ?></div>
                        <div class="yuzde70">
                            <input type="text" name="fields[l][x][allowed_ext]" placeholder="<?php echo __("admin/users/document-filter-f-allowed-ext-info"); ?>">
                        </div>
                    </div>
                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/users/document-filter-f-max-upload-fsz"); ?></div>
                        <div class="yuzde70">
                            <input type="text" name="fields[l][x][max_file_size]" value="3">
                        </div>
                    </div>

                </div>
            </div>
        </div>


        <div class="clear"></div>
    </div>
</div>

<script type="text/javascript">
    var cities_data = <?php echo Utility::jencode($cities); ?>;
</script>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1><strong><?php echo __("admin/users/page-add-document-filter"); ?></strong></h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="clear"></div>

            <div class="adminpagecon">

                <form action="<?php echo $links["controller"]; ?>" method="post" id="addNewForm">
                    <input type="hidden" name="operation" value="add_document_filter">

                    <div class="formcon">
                        <div class="yuzde30">
                            <?php echo __("admin/users/add-document-filter-name"); ?>
                        </div>
                        <div class="yuzde70">
                            <input type="text" name="name">
                        </div>
                    </div>

                    <div class="biggroup">
                        <div class="padding20">
                            <h4 class="biggrouptitle"><?php echo __("admin/users/add-document-filter-rules"); ?> </h4>

                            <div class="clear"></div>

                            <div class="filterleft">
                                <span class="kinfo"><?php echo __("admin/users/add-document-filter-rules-info"); ?></span>
                            </div>

                            <div class="filterright">
                                <div id="rules_wrapper">
                                </div>

                                <div class="clear"></div>
                                <br>
                                <a href="javascript:void 0;" onclick="add_filter_rule();" class="sbtn green"><i class="fa fa-plus"></i></a>

                            </div>
                            <div class="clear"></div>

                        </div>
                    </div>

                    <div class="biggroup">
                        <div class="padding20">
                            <h4 class="biggrouptitle"><?php echo __("admin/users/add-document-filter-fields"); ?> </h4>
                            <div class="clear"></div>

                            <span class="kinfo" style="margin-top:15px;margin-bottom:25px;display:inline-block;"><?php echo __("admin/users/add-document-filter-fields-info"); ?></span>
                            
                            <div class="clear"></div>

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
                                    foreach($lang_list AS $lang){
                                        $lkey = $lang["key"];
                                        ?>
                                        <div id="lang-<?php echo $lkey; ?>" class="tabcontent">

                                            <div class="fieldcon fieldconhead">
                                                <div class="fieldcon2"><strong><?php echo __("admin/users/document-filter-f-desc"); ?></strong></div>
                                                <div class="fieldcon3"><strong><?php echo __("admin/users/document-filter-f-type"); ?></strong></div>
                                            </div>

                                            <div id="<?php echo $lkey; ?>-fields_wrapper">
                                                <?php
                                                    if($lang["local"]){
                                                        ?>
                                                        <script type="text/javascript">
                                                            $(document).ready(function(){
                                                                add_filter_field('<?php echo $lkey; ?>');
                                                            });
                                                        </script>
                                                        <?php
                                                    }
                                                ?>
                                            </div>

                                            <div class="clear"></div>
                                            <br>
                                            <a href="javascript:void 0;" onclick="add_filter_field('<?php echo $lkey; ?>');" class="sbtn green"><i class="fa fa-plus"></i></a>


                                        </div>
                                        <?php
                                    }

                                ?>
                            </div>

                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/users/document-filter-status"); ?></div>
                        <div class="yuzde70">
                            <input checked type="checkbox" name="status" value="1" class="sitemio-checkbox" id="status">
                            <label class="sitemio-checkbox-label" for="status"></label>
                        </div>
                    </div>



                    <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                        <a class="yesilbtn gonderbtn" id="addNewForm_submit" href="javascript:void(0);"><?php echo ___("needs/button-add"); ?></a>
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