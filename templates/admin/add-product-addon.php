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
        var before_open_accordion = false;
        var selected_option_wrap = false;

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

            $("#addNewForm").bind("keypress", function(e) {
                if (e.keyCode == 13) $("#addNewForm_submit").click();
            });

            $("#addNewForm_submit").on("click",function(){
                var mcategory = $("select[name=mcategory]").val();

                MioAjaxElement($(this),{
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                    result:"addNewForm_handler",
                });
            });

            $(".options-sortable").on("click",".option-configurable-settings",function(){
                var lang = $(this).data("lang");
                selected_option_wrap = $(this).parent();

                if(before_open_accordion){
                    $(".module-accordion").accordion("destroy");
                }

                open_modal("configurable-option-params");

                var mcategory = $("select[name=mcategory]").val();
                mcategory     = mcategory.split("_");
                mcategory     = mcategory[0];

                var template    = $("#"+mcategory+"-configurable-option-params-accordions").html();

                template        = template.replace(/{lang}/g,lang);
                template        = $(template);

                var module_data = $(".option-module-data",selected_option_wrap).val();
                module_data     = json_decode(module_data);

                $("input",template).each(function(){

                    var module_param    = $(this).data("module-param");
                    var module_name     = $(this).data("module-name");

                    if(module_data[module_name] !== undefined)
                        if(module_data[module_name]["configurable"] !== undefined)
                            if(module_data[module_name]["configurable"][module_param] !== undefined)
                                template.find(this).attr("value",module_data[module_name]["configurable"][module_param]);
                });
                template = template.prop("outerHTML");

                $("#get_configurable_option_params").html(template);

                $(".module-accordion").accordion({
                    heightStyle: "content",
                    collapsible: true,
                    active:false,
                });
                before_open_accordion = true;
            });

            $("#configurable-option-params").on('click','#configurable-option-apply',function(){
                var lang        = $("#get_configurable_option_params .module-accordion").data("lang");
                var module_data = {};

                $("#get_configurable_option_params input").each(function(){
                    var module_param = $(this).data("module-param");
                    var module_name  = $(this).data("module-name");
                    var value        = $(this).val();


                    if(value !== ''){
                        if(module_data[module_name] !== undefined){
                            if(module_data[module_name]["configurable"] === undefined){
                                module_data[module_name]["configurable"] = {};
                                module_data[module_name]["configurable"][module_param] = value;
                            }else{
                                module_data[module_name]['configurable'][module_param] = value;
                            }
                        }else{
                            module_data[module_name] = {};
                            module_data[module_name]['configurable'] = {};
                            module_data[module_name]['configurable'][module_param] = value;
                        }
                    }

                });

                module_data         = json_encode(module_data);

                $(".option-module-data",selected_option_wrap).val(module_data);
                close_modal("configurable-option-params");
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

        function mcategory_trigger(){
            var selected = $("select[name=mcategory]").val();

            if(selected == ''){
                $("#requirements").html('');
                $(".option-configurable-settings").css("display","none");
            }else{

                var selected_split = selected.split("_");

                if(selected_split[0] === "special"){
                    if($("#special-configurable-option-params-accordions .configurable-option-input").length > 0)
                        $(".option-configurable-settings").css("display","inline-block");
                    else
                        $(".option-configurable-settings").css("display","none");
                }
                else if(selected === "server" || selected === "hosting"){
                    $(".option-configurable-settings").css("display","inline-block");
                }else{
                    $(".option-configurable-settings").css("display","none");
                }

                var selection = $("#"+selected+"_requirements");
                var options   = selection.html();

                if(options == null || options.replace(/\s/g,'') == '')
                    $("#requirements-wrap").css("display","none");
                else
                    $("#requirements-wrap").css("display","block");
                $("#requirements").html(options);

                if(selected === "server")
                    $("#requirements-wrap").css("display","none");
                else
                    $("#requirements-wrap").css("display","inline-block");


            }
        }

        function change_option_type(el,l_key){
            var selection   = $(el).val();
            var selected    = $(el).prop('checked');

            if(selection === 'quantity' && selected)
                $('#quantity-content-'+l_key).slideDown(250);
            else
                $('#quantity-content-'+l_key).slideUp(250);
        }
    </script>

</head>
<body>

<div id="hosting-configurable-option-params-accordions" style="display: none;">
    <div class="module-accordion" data-lang="{lang}">
        <?php
            if(isset($module_servers) && $module_servers){
                foreach($module_servers AS $mod => $module){
                    $mod_config = $module["config"];
                    $mod_lang   = $module["lang"];
                    if($mod_config["type"] != 'hosting') continue;
                    if(isset($mod_config["configurable-option-params"]) && $mod_config["configurable-option-params"]){
                        ?>
                        <h2><?php echo $mod; ?></h2>
                        <div>
                            <?php
                                foreach($mod_config["configurable-option-params"] AS $k=>$v){
                                    ?>
                                    <div class="formcon">
                                        <span class="yuzde30"><?php echo $v; ?></span>
                                        <input data-module-name="<?php echo $mod; ?>" data-module-param="<?php echo $v; ?>" type="text" class="yuzde70 configurable-option-input" placeholder="<?php echo Validation::isInt($k) ? ___("needs/value") : $k; ?>">
                                    </div>
                                    <?php
                                }
                            ?>
                        </div>
                        <?php
                    }
                }
            }
        ?>
    </div>
</div>
<div id="server-configurable-option-params-accordions" style="display: none;">
    <div class="module-accordion" data-lang="{lang}">
        <?php
            if(isset($module_servers) && $module_servers){
                foreach($module_servers AS $mod => $module){
                    $mod_config = $module["config"];
                    $mod_lang   = $module["lang"];
                    if($mod_config["type"] != 'virtualization') continue;
                    if(isset($mod_config["configurable-option-params"]) && $mod_config["configurable-option-params"]){
                        ?>
                        <h2><?php echo $mod; ?></h2>
                        <div>
                            <?php
                                foreach($mod_config["configurable-option-params"] AS $k=>$v){
                                    ?>
                                    <div class="formcon">
                                        <span class="yuzde30"><?php echo $v; ?></span>
                                        <input data-module-name="<?php echo $mod; ?>" data-module-param="<?php echo $v; ?>" type="text" class="yuzde70 configurable-option-input" placeholder="<?php echo Validation::isInt($k) ? ___("needs/value") : $k; ?>">
                                    </div>
                                    <?php
                                }
                            ?>
                        </div>
                        <?php
                    }
                }
            }
        ?>
    </div>
</div>
<div id="special-configurable-option-params-accordions" style="display: none;">
    <div class="module-accordion" data-lang="{lang}">
        <?php
            if(isset($module_products) && $module_products){
                foreach($module_products AS $mod => $module){
                    $mod_config = $module["config"];
                    $mod_lang   = $module["lang"];
                    if(isset($mod_config["configurable-option-params"]) && $mod_config["configurable-option-params"]){
                        ?>
                        <h2><?php echo $mod; ?></h2>
                        <div>
                            <?php
                                foreach($mod_config["configurable-option-params"] AS $k=>$v){
                                    ?>
                                    <div class="formcon">
                                        <span class="yuzde30"><?php echo $v; ?></span>
                                        <input data-module-name="<?php echo $mod; ?>" data-module-param="<?php echo $v; ?>" type="text" class="yuzde70 configurable-option-input" placeholder="<?php echo Validation::isInt($k) ? ___("needs/value") : $k; ?>">
                                    </div>
                                    <?php
                                }
                            ?>
                        </div>
                        <?php
                    }
                }
            }
        ?>
    </div>
</div>
<div id="configurable-option-params" data-izimodal-title="<?php echo __("admin/products/adjustments"); ?>" style="display: none;">
    <div class="padding20">

        <div id="get_configurable_option_params"></div>

        <div class="clear"></div>

        <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
            <a class="yesilbtn gonderbtn" id="configurable-option-apply" href="javascript:void(0);"><?php echo ___("needs/button-apply"); ?></a>
        </div>
        <div class="clear"></div>


    </div>
</div>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1><strong><?php echo __("admin/products/page-add-addon"); ?></strong></h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="clear"></div>
            
            <ul id="option-template" style="display: none">
                <li style="text-align:center;" data-lang="{lang}">
                    <input style="width:260px;" name="options[{lang}][name][]" type="text" placeholder="<?php echo __("admin/products/add-addon-option-name-ex"); ?>">
                    <input style="width:100px;" name="options[{lang}][period_time][]" type="text" placeholder="<?php echo __("admin/products/add-addon-option-period"); ?>"> -
                    <select style="width:150px;" name="options[{lang}][period][]">
                        <?php
                            foreach(___("date/periods") AS $k=>$v){
                                ?>
                                <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                <?php
                            }
                        ?>
                    </select> -
                    <input style="width:100px;" name="options[{lang}][amount][]" type="text" placeholder="<?php echo __("admin/products/add-addon-option-amount"); ?>"> -
                    <select style="width:150px;" name="options[{lang}][cid][]">
                        <?php
                            foreach(Money::getCurrencies() AS $curr){
                                ?>
                                <option value="<?php echo $curr["id"]; ?>"><?php echo $curr["name"]." (".$curr["code"].")"; ?></option>
                                <?php
                            }
                        ?>
                    </select>
                    <textarea style="display: none;" class="option-module-data" name="options[{lang}][module][]"></textarea>
                    <div class="option-configurable-content" style="display: none;"></div>
                    <a href="javascript:void(0);" class="sbtn option-configurable-settings" data-lang="{lang}"><i class="fa fa-cog"></i></a>
                    <a href="javascript:void(0);" class="sbtn option-bearer"><i class="fa fa-arrows-alt"></i></a>
                    <a href="javascript:void(0);" class="red sbtn option-delete" data-lang="{lang}"><i class="fa fa-trash"></i></a>

                </li>
            </ul>
            
            <form  enctype="multipart/form-data" action="<?php echo $links["controller"]; ?>" method="post" id="addNewForm" style="margin-top: 5px;">
                <input type="hidden" name="operation" value="add_new_addon">

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

                        <div class="adminpagecon">

                 

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/products/add-addon-name"); ?></div>
                                <div class="yuzde70">
                                    <input type="text" name="name[<?php echo $lkey; ?>]" id="field-name-<?php echo $lkey; ?>" value="">
                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/products/add-addon-description"); ?></div>
                                <div class="yuzde70">
                                    <textarea name="description[<?php echo $lkey; ?>]"></textarea>
                                </div>
                            </div>

                            <?php if($lang["local"]): ?>

                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/products/add-addon-category"); ?></div>
                                    <div class="yuzde70">
                                        <select name="category">
                                            <?php
                                                if(isset($categories) && $categories){
                                                    foreach($categories AS $category){
                                                        ?>
                                                        <option<?php echo $select_category && $select_category["id"] == $category["id"] ? ' selected' : ''; ?> value="<?php echo $category["id"]; ?>"><?php echo $category["title"]; ?></option>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>


                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/products/add-addon-main-category"); ?></div>
                                    <div class="yuzde70">
                                        <script type="text/javascript">
                                            $(document).ready(function(){
                                                mcategory_trigger();
                                            });
                                        </script>
                                        <select name="mcategory" onchange="mcategory_trigger();">
                                            <option value=""><?php echo ___("needs/none"); ?></option>
                                            <?php
                                                if(isset($main_categories) && $main_categories){
                                                    $mcategory = Filter::GET("mcategory");
                                                    foreach($main_categories AS $k=>$v){
                                                        ?>
                                                        <option<?php echo $mcategory == $k ? ' selected' : ''; ?> value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30">
                                        <?php echo __("admin/products/add-addon-product-link"); ?>
                                        <div class="clear"></div>
                                        <span class="kinfo"><?php echo __("admin/products/add-addon-product-link-info"); ?></span>
                                    </div>
                                    <div class="yuzde70">
                                        <?php
                                            $pservices = [];
                                        ?>
                                        <select name="product_link" id="product_link">
                                            <option value="" selected><?php echo ___("needs/none"); ?></option>
                                            <?php
                                                /*
                                                if(Config::get("options/pg-activation/hosting")){
                                                    ?>
                                                    <option disabled style="font-weight: bold;"><?php echo __("admin/financial/new-coupon-product-group-hosting"); ?></option>
                                                    <?php
                                                    $line   = "";
                                                    $products   = $functions["get_category_products"]("hosting",0);
                                                    if($products){
                                                        foreach ($products as $product) {
                                                            ?>
                                                            <option<?php echo in_array("hosting/".$product["id"],$pservices) ? ' selected' : ''; ?> value="hosting/<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                                            <?php
                                                        }
                                                    }

                                                    $get_pcategories = $functions["get_product_categories"]("products","hosting");
                                                    if($get_pcategories){
                                                        foreach($get_pcategories AS $row){
                                                            ?>
                                                            <option disabled><?php echo $row["title"]; ?></option>
                                                            <?php
                                                            preg_match('/\-+[- ]/',$row["title"],$match);
                                                            $line   = rtrim($match[0]);
                                                            $products   = $functions["get_category_products"]("hosting",$row["id"]);
                                                            if($products){
                                                                foreach ($products as $product) {
                                                                    ?>
                                                                    <option<?php echo in_array("hosting/".$product["id"],$pservices) ? ' selected' : ''; ?> value="hosting/<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                                                    <?php
                                                                }
                                                            }

                                                        }
                                                    }
                                                }

                                                if(Config::get("options/pg-activation/server")){
                                                    ?>
                                                    <option disabled style="font-weight: bold;"><?php echo __("admin/financial/new-coupon-product-group-server"); ?></option>
                                                    <?php
                                                    $line   = "";
                                                    $products   = $functions["get_category_products"]("server","0");
                                                    if($products){
                                                        foreach ($products as $product) {
                                                            ?>
                                                            <option<?php echo in_array("server/".$product["id"],$pservices) ? ' selected' : ''; ?> value="server/<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                                            <?php
                                                        }
                                                    }

                                                    $get_pcategories = $functions["get_product_categories"]("products","server");
                                                    if($get_pcategories){
                                                        foreach($get_pcategories AS $row){
                                                            ?>
                                                            <option disabled><?php echo $row["title"]; ?></option>
                                                            <?php
                                                            preg_match('/\-+[- ]/',$row["title"],$match);
                                                            $line   = rtrim($match[0]);
                                                            $products   = $functions["get_category_products"]("server",$row["id"]);
                                                            if($products){
                                                                foreach ($products as $product) {
                                                                    ?>
                                                                    <option<?php echo in_array("server/".$product["id"],$pservices) ? ' selected' : ''; ?> value="server/<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                                if(Config::get("options/pg-activation/software")){
                                                    ?>
                                                    <option disabled style="font-weight: bold;"><?php echo __("admin/financial/new-coupon-product-group-softwares"); ?></option>
                                                    <?php
                                                    $line = "";
                                                    $products   = $functions["get_category_products"]("software","0");
                                                    if($products){
                                                        foreach ($products as $product) {
                                                            ?>
                                                            <option<?php echo in_array("software/".$product["id"],$pservices) ? ' selected' : ''; ?> value="software/<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                                            <?php
                                                        }
                                                    }

                                                    $get_pcategories = $functions["get_product_categories"]("softwares");
                                                    if($get_pcategories){
                                                        foreach($get_pcategories AS $row){
                                                            ?>
                                                            <option disabled><?php echo " - ".$row["title"]; ?></option>
                                                            <?php
                                                            $line = "-";
                                                            $products   = $functions["get_category_products"]("software",$row["id"]);
                                                            if($products){
                                                                foreach ($products as $product) {
                                                                    ?>
                                                                    <option<?php echo in_array("software/".$product["id"],$pservices) ? ' selected' : ''; ?> value="software/<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                    }
                                                }

                                                if(Config::get("general/local")=="tr" && Config::get("options/pg-activation/sms")){
                                                    ?>
                                                    <option disabled style="font-weight: bold;"><?php echo __("admin/financial/new-coupon-product-group-sms"); ?></option>
                                                    <?php
                                                    $line   = "";
                                                    $products   = $functions["get_category_products"]("sms",0);
                                                    if($products){
                                                        foreach ($products as $product) {
                                                            ?>
                                                            <option<?php echo in_array("sms/".$product["id"],$pservices) ? ' selected' : ''; ?> value="sms/<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                }
                                                */
                                                $pspecialGroups = $functions["get_special_pgroups"]();
                                                if($pspecialGroups){
                                                    foreach($pspecialGroups AS $category){
                                                        ?>
                                                        <option disabled style="font-weight: bold;"><?php echo $category["title"]; ?></option>
                                                        <?php
                                                        preg_match('/\-+[- ]/',$category["title"],$match);
                                                        $line   = isset($match[0]) ? rtrim($match[0]) : '';
                                                        $products   = $functions["get_category_products"]("special",$category["id"]);
                                                        if($products){
                                                            foreach($products as $product){
                                                                ?>
                                                                <option<?php echo in_array("special/".$product["id"],$pservices) ? ' selected' : ''; ?> value="special/<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        $get_pcategories = $functions["get_product_categories"]("products","special",$category["id"]);
                                                        if($get_pcategories){
                                                            foreach($get_pcategories AS $row){
                                                                ?>
                                                                <option disabled><?php echo $row["title"]; ?></option>
                                                                <?php
                                                                preg_match('/\-+[- ]/',$row["title"],$match);
                                                                $line   = rtrim($match[0]);
                                                                $products   = $functions["get_category_products"]("special",$row["id"]);
                                                                if($products){
                                                                    foreach ($products as $product) {
                                                                        ?>
                                                                        <option<?php echo in_array("special/".$product["id"],$pservices) ? ' selected' : ''; ?> value="special/<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                                                        <?php
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }

                                                /*
                                                if(Config::get("options/pg-activation/domain")){
                                                    ?>
                                                    <option disabled style="font-weight: bold;"><?php echo __("admin/financial/new-coupon-product-domain"); ?></option>
                                                    <?php
                                                    $tlds   = $functions["get_tlds"];
                                                    $tlds   = $tlds();
                                                    if($tlds){
                                                        foreach($tlds AS $tld){
                                                            ?>
                                                            <option<?php echo in_array("domain/".$tld["id"],$pservices) ? ' selected' : ''; ?> value="domain/<?php echo $tld["id"]; ?>">» <?php echo $tld["name"]; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                }
                                                */
                                            ?>
                                        </select>
                                        <script type="text/javascript">
                                            $(document).ready(function(){
                                                $("#product_link").change(change_product_link);
                                                change_product_link();
                                            });

                                            function change_product_link(){
                                                var selection = $("#product_link").val();

                                                if(selection == ''){
                                                    $(".addon-options").fadeIn(200);
                                                }else{
                                                    $(".addon-options").fadeOut(200);
                                                }
                                            }
                                        </script>
                                    </div>
                                </div>

                                <div class="formcon" id="requirements-wrap" style="display: none">
                                    <div class="yuzde30">
                                        <?php echo __("admin/products/add-addon-requirements"); ?>
                                        <br>
                                        <span class="kinfo" style="font-weight: normal;"><?php echo __("admin/products/add-addon-requirements-desc"); ?></span>
                                    </div>
                                    <div class="yuzde70">
                                        <select name="requirements[]" id="requirements" size="7" multiple>

                                        </select>
                                        <?php
                                            $requirementswcat = $functions["get_requirements_with_category"];
                                            if(isset($main_categories) && $main_categories){
                                                foreach($main_categories AS $k=>$v){
                                                    ?>
                                                    <select style="display: none;" id="<?php echo $k."_requirements"; ?>" multiple>
                                                        <?php
                                                            if(isset($categories_rqs) && $categories_rqs){
                                                                foreach($categories_rqs AS $category){
                                                                    $requirements = $requirementswcat($k,$category["id"]);
                                                                    if($requirements){
                                                                        ?>
                                                                        <optgroup label="<?php echo $category["title"]; ?>">
                                                                            <?php
                                                                                foreach($requirements AS $k=>$requirement){
                                                                                    ?>
                                                                                    <option value="<?php echo $requirement["id"]; ?>"><?php echo $requirement["name"]; ?></option>
                                                                                    <?php
                                                                                }
                                                                            ?>
                                                                        </optgroup>
                                                                        <?php
                                                                    }
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                    <?php
                                                }
                                            }
                                        ?>
                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/products/add-addon-status"); ?></div>
                                    <div class="yuzde70">
                                        <select name="status" style="width: 150px">
                                            <option value="active"><?php echo __("admin/products/status-active"); ?></option>
                                            <option value="inactive"><?php echo __("admin/products/status-inactive"); ?></option>
                                        </select>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/products/add-addon-multiple-purchases"); ?></div>
                                <div class="yuzde70">
                                    <input checked type="checkbox" name="multiple_purchases[<?php echo $lkey; ?>]" value="1" id="multiple-purchases-<?php echo $lkey; ?>" class="checkbox-custom">
                                    <label class="checkbox-custom-label" for="multiple-purchases-<?php echo $lkey; ?>"><span class="kinfo"><?php echo __("admin/products/add-addon-multiple-purchases-label"); ?></span></label>
                                </div>
                            </div>


                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/products/add-addon-compulsory"); ?></div>
                                <div class="yuzde70">
                                    <input type="checkbox" name="compulsory[<?php echo $lkey; ?>]" value="1" id="compulsory-<?php echo $lkey; ?>" class="checkbox-custom">
                                    <label class="checkbox-custom-label" for="compulsory-<?php echo $lkey; ?>"><span class="kinfo"><?php echo __("admin/products/add-addon-compulsory-label"); ?></span></label>
                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/products/add-addon-show-by-product-period"); ?></div>
                                <div class="yuzde70">
                                    <input type="checkbox" name="show_by_pp[<?php echo $lkey; ?>]" value="1" id="show-by-product-period-<?php echo $lkey; ?>" class="checkbox-custom">
                                    <label class="checkbox-custom-label" for="show-by-product-period-<?php echo $lkey; ?>"><span class="kinfo"><?php echo __("admin/products/add-addon-show-by-product-period-label"); ?></span></label>
                                </div>
                            </div>

                            <?php if($lang["local"]):?>
                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/products/add-addon-rank"); ?></div>
                                    <div class="yuzde70">
                                        <input style="width: 50px;" type="text" name="rank" value="" onkeypress='return event.charCode>= 48 &&event.charCode<= 57'>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="formcon addon-options">
                                <div class="yuzde30"><?php echo __("admin/products/add-addon-type"); ?>
                                	<br><span class="kinfo" style="font-weight:normal"><?php echo __("admin/products/add-addon-type-desc"); ?></span>
                                </div>
                                <div style="font-weight:600;" class="yuzde70">

                                    <input checked type="radio" name="type[<?php echo $lkey; ?>]" value="select" id="type-select-<?php echo $lkey; ?>" class="radio-custom" onchange="change_option_type(this,'<?php echo $lkey; ?>');">
                                    <label class="radio-custom-label" for="type-select-<?php echo $lkey; ?>" style="margin-right:15px;"><?php echo __("admin/products/add-addon-type-select"); ?></label>

                                    <input type="radio" name="type[<?php echo $lkey; ?>]" value="radio" id="type-radio-<?php echo $lkey; ?>" class="radio-custom" onchange="change_option_type(this,'<?php echo $lkey; ?>');">
                                    <label class="radio-custom-label" for="type-radio-<?php echo $lkey; ?>" style="margin-right:15px;"><?php echo __("admin/products/add-addon-type-radio"); ?></label>

                                    <input type="radio" name="type[<?php echo $lkey; ?>]" value="checkbox" id="type-checkbox-<?php echo $lkey; ?>" class="radio-custom" onchange="change_option_type(this,'<?php echo $lkey; ?>');">
                                    <label class="radio-custom-label" for="type-checkbox-<?php echo $lkey; ?>" style="margin-right:15px;"><?php echo __("admin/products/add-addon-type-checkbox"); ?></label>

                                    <input type="radio" name="type[<?php echo $lkey; ?>]" value="quantity" id="type-quantity-<?php echo $lkey; ?>" class="radio-custom" onchange="change_option_type(this,'<?php echo $lkey; ?>');">
                                    <label class="radio-custom-label" for="type-quantity-<?php echo $lkey; ?>" style="margin-right:15px;"><?php echo __("admin/products/add-addon-type-quantity"); ?></label>

                                </div>

                                <div class="clear"></div><br>
                                <div id="quantity-content-<?php echo $lkey; ?>" style="display: none;">
                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/products/add-addon-quantity-min-value"); ?></div>
                                        <div class="yuzde70">
                                            <input min="0" type="number" name="min[<?php echo $lkey; ?>]" value="0" style="width: 80px;">
                                        </div>
                                    </div>
                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/products/add-addon-quantity-max-value"); ?></div>
                                        <div class="yuzde70">
                                            <input min="0" type="number" name="max[<?php echo $lkey; ?>]" value="0" style="width: 80px;">
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <div class="clear"></div>
                                <ul class="options-sortable" id="options_<?php echo $lkey; ?>" style="margin:0; padding: 0;">
                                    <li style="text-align:center;" data-lang="<?php echo $lkey; ?>">
                                        <input style="width:260px;" name="options[<?php echo $lkey; ?>][name][]" type="text" placeholder="<?php echo __("admin/products/add-addon-option-name-ex"); ?>">
                                        <input style="width:100px;" name="options[<?php echo $lkey; ?>][period_time][]" type="text" placeholder="<?php echo __("admin/products/add-addon-option-period"); ?>"> -
                                        <select style="width:150px;" name="options[<?php echo $lkey; ?>][period][]">
                                            <?php
                                                foreach(___("date/periods") AS $k=>$v){
                                                    ?>
                                                    <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                                    <?php
                                                }
                                            ?>
                                        </select> -
                                        <input style="width:100px;" name="options[<?php echo $lkey; ?>][amount][]" type="text" placeholder="<?php echo __("admin/products/add-addon-option-amount"); ?>"> -
                                        <select style="width:150px;" name="options[<?php echo $lkey; ?>][cid][]">
                                            <?php
                                                foreach(Money::getCurrencies() AS $curr){
                                                    ?>
                                                    <option value="<?php echo $curr["id"]; ?>"><?php echo $curr["name"]." (".$curr["code"].")"; ?></option>
                                                    <?php
                                                }
                                            ?>
                                        </select>
                                        <textarea style="display: none;" class="option-module-data" name="options[{lang}][module][]"></textarea>
                                        <div class="option-configurable-content" style="display: none;"></div>
                                        <a href="javascript:void(0);" class="sbtn option-configurable-settings" data-lang="<?php echo $lkey; ?>"><i class="fa fa-cog"></i></a>
                                        <a href="javascript:void(0);" class="sbtn option-bearer"><i class="fa fa-arrows-alt"></i></a>
                                        <a href="javascript:void(0);" class="red sbtn option-delete" data-lang="<?php echo $lkey; ?>"><i class="fa fa-trash"></i></a>

                                    </li>
                                </ul>

                                <div class="clear"></div>
                                <br>
                                <?php if($lang["local"]): ?>
                                    <input type="checkbox" name="override_usrcurrency" value="1" class="checkbox-custom" id="override_usrcurrency">
                                    <label class="checkbox-custom-label" for="override_usrcurrency"><?php echo __("admin/products/override-user-currency"); ?> <span class="kinfo"><?php echo __("admin/products/override-user-currency-desc"); ?></span></label>
                                <?php endif; ?>

                                <center><a href="javascript:void(0);" class="lbtn add-option" data-lang="<?php echo $lkey; ?>">+ <?php echo __("admin/products/add-addon-add-option"); ?></a></center>


                            </div>


                            <div class="clear"></div>
                        </div>


                        <div class="clear"></div>
                    </div>
                    <?php } ?>

                </div><!-- tab wrap content end -->

                <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                    <a class="yesilbtn gonderbtn" id="addNewForm_submit" href="javascript:void(0);"><?php echo __("admin/products/new-addon-button"); ?></a>
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