<!DOCTYPE html>
<html>
<head>
    <?php
        $plugins    = ['jquery-ui','select2'];
        include __DIR__.DS."inc".DS."head.php";
    ?>
    <script type="text/javascript">
        $(document).ready(function(){

            $(".accordion").accordion({
                heightStyle: "content",
                collapsible: true,
                active:false,
            });


            $("#select-user").select2({
                placeholder: "<?php echo __("admin/orders/create-select-user"); ?>",
                ajax: {
                    url: '<?php echo $links["select-users.json"]; ?>',
                    dataType: 'json',
                    data: function (params) {
                        var query = {
                            search: params.term,
                            type: 'public'
                        }
                        return query;
                    }
                }
            });

            $("#addForm_submit").on("click",function(){
                MioAjaxElement($(this),{
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                    result:"addForm_handler",
                });
            });

        });

        function addForm_handler(result){
            if(result != ''){
                var solve = getJson(result);
                if(solve !== false){
                    if(solve.status == "error"){
                        if(solve.for != undefined && solve.for != ''){
                            $("#addForm "+solve.for).focus();
                            $("#addForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                            $("#addForm "+solve.for).change(function(){
                                $(this).removeAttr("style");
                            });
                        }
                        if(solve.message != undefined && solve.message != '')
                            alert_error(solve.message,{timer:5000});
                    }else if(solve.status == "successful"){
                        alert_success(solve.message,{timer:2000});
                        setTimeout(function(){
                            window.location.href = solve.redirect;
                        },2000);
                    }
                }else
                    console.log(result);
            }
        }

        $(document).ready(function(){
            $("#select-user").change(function(){
                var value = $(this).val();
                if(value == ''){
                    $("#continue_button").css("display","none");
                    $("#productGroupWrap").css("display","none");
                    $(".content-wrap").css("display","none");
                }else{
                    $("#productGroupWrap").css("display","block");
                }
            });
            $("#product-group").change(function(){
                var selected = $(this).val();
                if(selected =='')
                    $("#invoice-content,#order-status-wrap").css("display","none");
                else
                    $("#invoice-content,#order-status-wrap").css("display","block");

               if(selected == "special"){
                   var id = $("option:selected",$(this)).data("id");
                   $(".content-wrap").css("display","none");
                   $(".content-special input,.content-special select").attr("disabled",true);
                   $("#special-"+id).css("display","block");
                   $("#special-"+id+" input,#special-"+id+" select").removeAttr("disabled");
               }else{
                   $("#special-addons-wrap").css("display","none");
                   $("#special-addons").html('');
                    $(".content-wrap").css("display","none");
                    $(".content-"+selected).css("display","block");
                }

            });

            $("#domainCheckAvailability").click(function(){

                var request = MioAjax({
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    button_element:$(this),
                    action:"<?php echo $links["controller"]; ?>",
                    method:"POST",
                    data:{
                        operation:"check_domain_availability",
                        domain:$(".content-domain input[name=domain]").val(),
                        user_id:$("#select-user").val(),
                    },
                },true,true);

                request.done(function(result){
                    $("#registrar_module option").removeAttr("selected");
                    $("#registrar_module option[value='none']").attr("selected",true).trigger("change");
                    if(result != ''){
                        var solve = getJson(result);
                        if(solve !== false){
                            if(solve.status == "error"){
                                $("#domain-transaction,#domain-period-wrap,#domain_pricing").css("display","none");
                                $("#domain-transaction .radio-custom").prop("checked",false).trigger("change");

                                alert_error(solve.message,{timer:3000});

                            }else if(solve.status == "available"){
                                $("#domain-transaction").css("display","block");
                                $("#domain-transaction .radio-custom").prop("checked",false).trigger("change");
                                $("#transaction_register").prop("checked",true).trigger("change");

                                $("#status_unavailable,#transaction_transfer_label").css("display","none");
                                $("#status_available,#transaction_register_label").fadeIn(300);

                                if(solve.fees != undefined && solve.fees){
                                    $("#domain-period-wrap").css("display","block");
                                    var fees = '';
                                    $(solve.fees.register).each(function(k,v){
                                        var year = k+1;
                                        var selected = year == 1 ? ' selected' : '';
                                        fees += '<option'+selected+' value="'+year+'" data-amount="'+v.amount+'">'+year+' <?php echo ___("date/period-year"); ?> - '+v.format+'</option>';
                                    });
                                    $("#selectPeriod").html(fees).trigger("change");
                                }

                            }else if(solve.status == "unavailable"){
                                $("#domain-transaction").css("display","block");
                                $("#domain-transaction .radio-custom").prop("checked",false).trigger("change");
                                $("#transaction_transfer").prop("checked",true).trigger("change");

                                $("#status_available,#transaction_register_label").css("display","none");
                                $("#status_unavailable,#transaction_transfer_label").fadeIn(300);

                                if(solve.fees != undefined && solve.fees){
                                    $("#domain-period-wrap").css("display","block");
                                    var fees = '';
                                    $(solve.fees.transfer).each(function(k,v){
                                        var year = k+1;
                                        var selected = year == 1 ? ' selected' : '';
                                        fees += '<option'+selected+' value="'+year+'" data-amount="'+v.amount+'">'+year+' <?php echo ___("date/period-year"); ?> - '+v.format+'</option>';
                                    });
                                    $("#selectPeriod").html(fees).trigger("change");
                                }
                            }
                        }else
                            console.log(result);
                    }

                });

            });
        });
    </script>
</head>
<body>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1><strong><?php echo __("admin/orders/page-create"); ?></strong></h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="adminpagecon">
                <form action="<?php echo $links["controller"]; ?>" method="post" id="addForm">
                    <input type="hidden" name="operation" value="create">

                    <div class="green-info" style="margin-bottom:20px;">
                        <div class="padding15">
                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                            <p><?php echo __("admin/orders/create-info"); ?></p>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/orders/create-user"); ?></div>
                        <div class="yuzde70">
                            <select name="user_id" id="select-user" style="width: 100%;">
                                <?php
                                    if(isset($user) && $user){
                                        $name = $user["full_name"];
                                        if($user["company_name"]) $name .= " - ".$user["company_name"];
                                        ?>
                                        <option value="<?php echo $user["id"]; ?>"><?php echo $name; ?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="formcon" id="productGroupWrap" style="<?php echo isset($user) && $user ? '' : 'display: none;'; ?>">
                        <div class="yuzde30"><?php echo __("admin/orders/create-product-group"); ?></div>
                        <div class="yuzde70">
                            <select name="product_group" id="product-group">
                                <option value=""><?php echo ___("needs/select-your"); ?></option>
                                <?php
                                    $pgact = Config::get("options/pg-activation");
                                    if($pgact["domain"]){
                                        ?><option value="domain"><?php echo __("admin/orders/product-groups/domain"); ?></option><?php
                                    }
                                    if($pgact["hosting"]){
                                        ?><option value="hosting"><?php echo __("admin/orders/product-groups/hosting"); ?></option><?php
                                    }

                                    if($pgact["server"]){
                                        ?><option value="server"><?php echo __("admin/orders/product-groups/server"); ?></option><?php
                                    }

                                    if($pgact["software"]){
                                        ?><option value="software"><?php echo __("admin/orders/product-groups/software"); ?></option><?php
                                    }

                                    if($pgact["sms"]){
                                        ?><option value="sms"><?php echo __("admin/orders/product-groups/sms"); ?></option><?php
                                    }
                                    if($special_groups){
                                        foreach($special_groups AS $group){
                                            ?><option value="special" data-id="<?php echo $group["id"]; ?>"><?php echo $group["title"]; ?></option><?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>


                    <div class="content-wrap content-domain" style="display: none;"><!-- domain content start -->

                        <div class="formcon">
                            <div class="yuzde30"><?php echo __("admin/orders/create-domain"); ?></div>
                            <div class="yuzde70">
                                <input class="yuzde50" name="domain" placeholder="<?php echo __("admin/orders/create-domain-name"); ?>">
                                <a class="lbtn" id="domainCheckAvailability" href="javascript:void(0);"><i class="fa fa-search" aria-hidden="true"></i> <?php echo __("admin/orders/create-domain-check-availability"); ?></a>
                                <div id="check_status">
                                    <span style="display: none;" id="status_available"><?php echo __("admin/orders/create-domain-status-available"); ?></span>
                                    <span style="display: none;" id="status_unavailable"><?php echo __("admin/orders/create-domain-status-unavailable"); ?></span>
                                </div>
                            </div>
                        </div>


                        <div  id="domain-transaction" style="display: none;">

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/orders/create-domain-select-transaction"); ?></div>
                                <div class="yuzde70">
                                    <input onchange="if($(this).prop('checked')) $('#cdate-duedate-wrap,#tcode,#registrar_module_wrap').css('display','none');" type="radio" name="transaction" value="register" class="radio-custom" id="transaction_register">
                                    <label id="transaction_register_label" class="radio-custom-label" for="transaction_register" style="margin-right: 15px;"><?php echo __("admin/orders/create-domain-transaction-register"); ?></label>

                                    <div id="select-transfer-area">
                                        <input onchange="if($(this).prop('checked')) $('#cdate-duedate-wrap,#registrar_module_wrap').css('display','none'),$('#tcode').css('display','inline-block');" type="radio" name="transaction" value="transfer" class="radio-custom" id="transaction_transfer">
                                        <label id="transaction_transfer_label" class="radio-custom-label" for="transaction_transfer" style="margin-right: 15px;"><?php echo __("admin/orders/create-domain-transaction-transfer"); ?></label>

                                        <input type="text" name="tcode" value="" id="tcode" style="display: none;" placeholder="<?php echo __("admin/orders/create-domain-transfer-code"); ?>">
                                    </div>

                                    <input onchange="if($(this).prop('checked')) $('#cdate-duedate-wrap,#registrar_module_wrap').css('display','block'),$('#tcode').css('display','none');" type="radio" name="transaction" value="none" class="radio-custom" id="transaction_none">
                                    <label id="transaction_none_label" class="radio-custom-label" for="transaction_none"><?php echo __("admin/orders/create-domain-transaction-none"); ?></label>
                                </div>
                            </div>

                            <div id="domain-options">

                                <div class="formcon" style="display: none;" id="registrar_module_wrap">
                                    <div class="yuzde30"><?php echo __("admin/orders/create-domain-module"); ?></div>
                                    <div class="yuzde70">
                                        <script type="text/javascript">
                                            function change_registrar_module(elem){
                                                var domain = $("input[name=domain]").val();
                                                var module = $(elem).val();

                                                if(module == "none"){
                                                    $("#whois_privacy").removeAttr("disabled");
                                                    $("input[name=domain_ns1]").removeAttr("disabled").val('<?php echo Config::get("options/ns-addresses/ns1");?>');
                                                    $("input[name=domain_ns2]").removeAttr("disabled").val('<?php echo Config::get("options/ns-addresses/ns2");?>');
                                                    $("input[name=domain_ns3]").removeAttr("disabled").val('<?php echo Config::get("options/ns-addresses/ns3");?>');
                                                    $("input[name=domain_ns4]").removeAttr("disabled").val('<?php echo Config::get("options/ns-addresses/ns4");?>');
                                                    $("input[name=cdate]").removeAttr("disabled").val('');
                                                    $("input[name=duedate]").removeAttr("disabled").val('');
                                                }else{
                                                    $("#module_loader").css("display","block");
                                                    $("#module_error").html('').fadeOut(200);
                                                    var request = MioAjax({
                                                        action:"<?php echo $links["controller"]; ?>",
                                                        method:"POST",
                                                        data:{
                                                            operation:"create_domain_order_detail_module",
                                                            domain:domain,
                                                            module:module,
                                                        },
                                                    },true,true);

                                                    request.done(function(result){
                                                        if(result != ''){

                                                            $("#module_loader").css("display","none");

                                                            var solve = getJson(result);
                                                            if(solve !== false){

                                                                if(solve.status == "error"){
                                                                    $("#module_error").html(solve.message).fadeIn(200);

                                                                    $("#whois_privacy").attr("disabled",true);
                                                                    $("input[name=domain_ns1]").attr("disabled",true).val('');
                                                                    $("input[name=domain_ns2]").attr("disabled",true).val('');
                                                                    $("input[name=domain_ns3]").attr("disabled",true).val('');
                                                                    $("input[name=domain_ns4]").attr("disabled",true).val('');
                                                                    $("input[name=cdate]").attr("disabled",true).val('');
                                                                    $("input[name=duedate]").attr("disabled",true).val('');

                                                                }else if(solve.status == "successful"){

                                                                    var privacy = solve.whois_privacy == undefined ? false : solve.whois_privacy;

                                                                    $("#whois_privacy").attr("disabled",true).prop("checked",privacy);
                                                                    $("input[name=domain_ns1]").attr("disabled",true).val(solve.ns1 == undefined ? "" : solve.ns1);
                                                                    $("input[name=domain_ns2]").attr("disabled",true).val(solve.ns2 == undefined ? "" : solve.ns2);
                                                                    $("input[name=domain_ns3]").attr("disabled",true).val(solve.ns3 == undefined ? "" : solve.ns3);
                                                                    $("input[name=domain_ns4]").attr("disabled",true).val(solve.ns4 == undefined ? "" : solve.ns4);
                                                                    $("input[name=cdate]").val(solve.cdate).attr("disabled",true);
                                                                    $("input[name=duedate]").val(solve.duedate).attr("disabled",true);


                                                                }

                                                            }else
                                                                console.log(result);
                                                        }
                                                    });


                                                }
                                            }
                                        </script>
                                        <select name="module" id="registrar_module" onchange="change_registrar_module(this);">
                                            <option value="none"><?php echo ___("needs/none"); ?></option>
                                            <?php
                                                if(isset($registrars) && $registrars){
                                                    foreach($registrars AS $module){
                                                        ?>
                                                        <option value="<?php echo $module; ?>"><?php echo $module; ?></option>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                        <div id="module_loader" style="display: none;">
                                            <img src="<?php echo $sadress; ?>assets/images/loading.gif">
                                        </div>
                                        <div id="module_error" style="display: none;color:red;font-weight: bold;"></div>
                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/orders/create-domain-whois-privacy"); ?></div>
                                    <div class="yuzde70">
                                        <input type="checkbox" id="whois_privacy" name="whois_privacy" value="1" class="sitemio-checkbox">
                                        <label for="whois_privacy" class="sitemio-checkbox-label"></label>
                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/orders/create-domain-ns-addresses"); ?></div>
                                    <div class="yuzde70">
                                        <input type="text" name="domain_ns1" placeholder="ns1.example.com" value="<?php echo Config::get("options/ns-addresses/ns1");?>">
                                        <input type="text" name="domain_ns2" placeholder="ns2.example.com" value="<?php echo Config::get("options/ns-addresses/ns2");?>">
                                        <input type="text" name="domain_ns3" placeholder="ns3.example.com" value="<?php echo Config::get("options/ns-addresses/ns3");?>">
                                        <input type="text" name="domain_ns4" placeholder="ns4.example.com" value="<?php echo Config::get("options/ns-addresses/ns4");?>">
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="formcon" id="domain-period-wrap" style="display: none;">
                            <div class="yuzde30"><?php echo __("admin/orders/create-domain-select-period"); ?></div>
                            <div class="yuzde70">
                                <select id="selectPeriod" onchange="change_period(this);">
                                </select>
                                <script type="text/javascript">
                                    function change_period(elem){
                                        var item    = $("option:selected",elem);
                                        var amount  = item.data("amount");
                                        var year    = item.val();
                                        $("#domain_pricing").fadeIn(200);
                                        $("#domain_pricing input[name=domain_amount]").val(amount);
                                        $("#domain_pricing input[name=domain_period_time]").val(year);
                                    }
                                </script>
                            </div>
                        </div>

                        <div class="formcon" id="domain_pricing" style="display: none;">
                            <div class="yuzde30"><?php echo __("admin/orders/detail-pricing"); ?></div>
                            <div class="yuzde70">

                                <input class="yuzde15" name="domain_period_time" type="text" placeholder="<?php echo __("admin/orders/detail-pricing-period"); ?>" value=""> -
                                <input type="hidden" name="domain_period" value="year">
                                <select disabled class="yuzde15" name="period" disabled>
                                    <option><?php echo ___("date/period-year"); ?></option>
                                </select> -
                                <input class="yuzde15" name="domain_amount" type="text" placeholder="<?php echo __("admin/orders/detail-pricing-amount"); ?>" value=""> -
                                <select class="yuzde20" name="domain_amount_cid">
                                    <?php
                                        foreach(Money::getCurrencies() AS $curr){
                                            ?>
                                            <option value="<?php echo $curr["id"]; ?>"><?php echo $curr["name"]." (".$curr["code"].")"; ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                                <div class="clear"></div>
                            </div>
                        </div>

                        <div class="formcon" id="cdate-duedate-wrap" style="display: none;">
                            <div class="yuzde30"><?php echo __("admin/orders/create-domain-cdate-duedate"); ?></div>
                            <div class="yuzde70">
                                <input style="width: 200px;" type="date" name="cdate" value="">
                                <input style="width: 200px;" type="date" name="duedate" value="">
                            </div>
                        </div>

                    </div><!-- domain content end -->

                    <div class="content-wrap content-hosting" style="display: none;"><!-- hosting content start -->

                        <div class="formcon">
                            <div class="yuzde30"><?php echo __("admin/orders/create-product-domain"); ?></div>
                            <div class="yuzde70">
                                <input type="text" name="hosting_domain" value="">
                            </div>
                        </div>

                        <div class="formcon">
                            <div class="yuzde30"><?php echo __("admin/orders/create-select-product"); ?></div>
                            <div class="yuzde70">
                                <script type="text/javascript">
                                    function change_hosting_product(elem){
                                        var value = $(elem).val();
                                        var request = MioAjax({
                                            action:"<?php echo $links["controller"]; ?>",
                                            method:"POST",
                                            data:{
                                                operation:"get_create_product_info",
                                                type:"hosting",
                                                id:value,
                                                user_id:$("#select-user").val(),
                                            },
                                        },true,true);

                                        request.done(function(result){
                                            if(result != ''){
                                                var solve = getJson(result);
                                                if(solve !== false){
                                                    var prices = solve.prices != undefined ? solve.prices : false;
                                                    var addons = solve.addons != undefined ? solve.addons : false;

                                                    if(prices){
                                                        $("#hosting-product-periodicals-wrap").css("display","block");
                                                        var select = $("#hosting-product-periodicals");
                                                        var select_raw = '';
                                                        $(prices).each(function(k,v){
                                                            select_raw += '<option ';
                                                            if(k == 0) select_raw += 'selected ';
                                                            select_raw += 'value="'+k+'" ';
                                                            select_raw += 'data-amount="'+v.amount+'" ';
                                                            select_raw += 'data-period="'+v.period+'" ';
                                                            select_raw += 'data-time="'+v.time+'"';
                                                            select_raw += '>'+v.text+'</option>';
                                                        });
                                                        select.html(select_raw);
                                                        select.trigger("change");
                                                    }else
                                                        $("#hosting-product-periodicals-wrap").css("display","none");

                                                    if(addons){
                                                        $("#hosting-addons-wrap").css("display","inline-block");
                                                        var addons_raw = '';
                                                        $(addons).each(function(k,v){
                                                            addons_raw += '<div class="formcon">';
                                                            addons_raw += '<div class="yuzde30">'+v.name+'</div>';
                                                            addons_raw += '<div class="yuzde70">';

                                                            addons_raw += '<input checked type="radio" name="hosting_addons['+v.id+']" id="addon_'+v.id+'_option_none" class="radio-custom" value="none"><label class="radio-custom-label" for="addon_'+v.id+'_option_none"><?php echo ___("needs/none"); ?></label><div class="clear"></div>';
                                                            $(v.options).each(function(kk,vv){
                                                                addons_raw += '<input type="radio" name="hosting_addons['+v.id+']" id="addon_'+v.id+'_option_'+vv.id+'" class="radio-custom" value="'+vv.id+'"><label class="radio-custom-label" for="addon_'+v.id+'_option_'+vv.id+'">'+vv.text+'</label><div class="clear"></div>';
                                                            });

                                                            addons_raw += '</div>';
                                                            addons_raw += '</div>';


                                                        });
                                                        $("#hosting-addons").html(addons_raw);
                                                    }else
                                                        $("#hosting-addons-wrap").css("display","none");

                                                }else
                                                    console.log(result);
                                            }
                                        });

                                    }

                                    function change_hosting_period(elem){
                                        var option  = $("option:selected",$(elem));

                                        var amount  = option.data("amount");
                                        var period  = option.data("period");
                                        var time    = option.data("time");

                                        $("input[name=hosting_amount]").val(amount);
                                        $("select[name=hosting_period] option").removeAttr("selected");
                                        $("select[name=hosting_period] option[value='"+period+"']").attr("selected",true);
                                        $("input[name=hosting_period_time]").val(time);
                                    }
                                </script>
                                <select name="hosting_pid" size="10" onchange="change_hosting_product(this);">
                                    <?php
                                        $line   = "";
                                        $products   = $functions["get_category_products"]("hosting",0);
                                        if($products){
                                            foreach ($products as $product) {
                                                ?>
                                                <option value="<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                                <?php
                                            }
                                        }

                                        $get_pcategories = $functions["get_product_categories"]("products","hosting");
                                        if($get_pcategories){
                                            foreach($get_pcategories AS $row){
                                                ?>
                                                <optgroup label="<?php echo $row["title"]; ?>">
                                                    <?php
                                                        preg_match('/\-+[- ]/',$row["title"],$match);
                                                        $line   = rtrim(isset($match[0]) ? $match[0] : "");
                                                        $products   = $functions["get_category_products"]("hosting",$row["id"]);
                                                        if($products){
                                                            foreach ($products as $product) {
                                                                ?>
                                                                <option value="<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                                                <?php
                                                            }
                                                        }

                                                        }
                                                        }
                                                    ?>
                                                </optgroup>
                                </select>
                            </div>
                        </div>

                        <div class="formcon" id="hosting-product-periodicals-wrap" style="display: none;">
                            <div class="yuzde30"><?php echo __("admin/orders/create-product-periodicals"); ?></div>
                            <div class="yuzde70">
                                <select name="hosting_selected_price" id="hosting-product-periodicals" onchange="change_hosting_period(this);"></select>
                            </div>
                        </div>

                        <div class="formcon">
                            <div class="yuzde30"><?php echo __("admin/orders/detail-pricing"); ?></div>
                            <div class="yuzde70">

                                <input class="yuzde15" name="hosting_period_time" type="text" placeholder="<?php echo __("admin/orders/detail-pricing-period"); ?>" value=""> -
                                <select class="yuzde15" name="hosting_period">
                                    <?php
                                        foreach(___("date/periods") AS $k=>$v){
                                            ?>
                                            <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                            <?php
                                        }
                                    ?>
                                </select> -
                                <input class="yuzde15" name="hosting_amount" type="text" placeholder="<?php echo __("admin/orders/detail-pricing-amount"); ?>" value=""> -
                                <select class="yuzde20" name="hosting_amount_cid">
                                    <?php
                                        foreach(Money::getCurrencies() AS $curr){
                                            ?>
                                            <option value="<?php echo $curr["id"]; ?>"><?php echo $curr["name"]." (".$curr["code"].")"; ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                                <div class="clear"></div>

                            </div>
                        </div>

                    </div><!-- hosting content end -->

                    <div class="content-wrap content-server" style="display: none;"><!-- hosting content start -->

                        <div class="formcon">
                            <div class="yuzde30">Hostname</div>
                            <div class="yuzde70">
                                <input type="text" name="hostname">
                            </div>
                        </div>

                        <div class="formcon">
                            <div class="yuzde30">NS1</div>
                            <div class="yuzde70">
                                <input type="text" name="server_ns1" placeholder="ns1.example.com">
                            </div>
                        </div>

                        <div class="formcon">
                            <div class="yuzde30">NS2</div>
                            <div class="yuzde70">
                                <input type="text" name="server_ns2" placeholder="ns2.example.com">
                            </div>
                        </div>

                        <div class="formcon">
                            <div class="yuzde30">NS3</div>
                            <div class="yuzde70">
                                <input type="text" name="server_ns3" placeholder="ns3.example.com">
                            </div>
                        </div>

                        <div class="formcon">
                            <div class="yuzde30">NS4</div>
                            <div class="yuzde70">
                                <input type="text" name="server_ns4" placeholder="ns4.example.com">
                            </div>
                        </div>


                        <div class="formcon">
                            <div class="yuzde30"><?php echo __("admin/orders/create-select-product"); ?></div>
                            <div class="yuzde70">
                                <script type="text/javascript">
                                    function change_server_product(elem){
                                        var value = $(elem).val();
                                        var request = MioAjax({
                                            action:"<?php echo $links["controller"]; ?>",
                                            method:"POST",
                                            data:{
                                                operation:"get_create_product_info",
                                                type:"server",
                                                id:value,
                                                user_id:$("#select-user").val(),
                                            },
                                        },true,true);

                                        request.done(function(result){
                                            if(result != ''){
                                                var solve = getJson(result);
                                                if(solve !== false){
                                                    var prices = solve.prices != undefined ? solve.prices : false;
                                                    var addons = solve.addons != undefined ? solve.addons : false;

                                                    if(prices){
                                                        $("#server-product-periodicals-wrap").css("display","block");
                                                        var select = $("#server-product-periodicals");
                                                        var select_raw = '';
                                                        $(prices).each(function(k,v){
                                                            select_raw += '<option ';
                                                            if(k == 0) select_raw += 'selected ';
                                                            select_raw += 'value="'+k+'" ';
                                                            select_raw += 'data-amount="'+v.amount+'" ';
                                                            select_raw += 'data-period="'+v.period+'" ';
                                                            select_raw += 'data-time="'+v.time+'"';
                                                            select_raw += '>'+v.text+'</option>';
                                                        });
                                                        select.html(select_raw);
                                                        select.trigger("change");
                                                    }else
                                                        $("#server-product-periodicals-wrap").css("display","none");

                                                    if(addons){
                                                        $("#server-addons-wrap").css("display","inline-block");
                                                        var addons_raw = '';
                                                        $(addons).each(function(k,v){
                                                            addons_raw += '<div class="formcon">';
                                                            addons_raw += '<div class="yuzde30">'+v.name+'</div>';
                                                            addons_raw += '<div class="yuzde70">';

                                                            addons_raw += '<input checked type="radio" name="server_addons['+v.id+']" id="addon_'+v.id+'_option_none" class="radio-custom" value="none"><label class="radio-custom-label" for="addon_'+v.id+'_option_none"><?php echo ___("needs/none"); ?></label><div class="clear"></div>';
                                                            $(v.options).each(function(kk,vv){
                                                                addons_raw += '<input type="radio" name="server_addons['+v.id+']" id="addon_'+v.id+'_option_'+vv.id+'" class="radio-custom" value="'+vv.id+'"><label class="radio-custom-label" for="addon_'+v.id+'_option_'+vv.id+'">'+vv.text+'</label><div class="clear"></div>';
                                                            });

                                                            addons_raw += '</div>';
                                                            addons_raw += '</div>';


                                                        });
                                                        $("#server-addons").html(addons_raw);
                                                    }else
                                                        $("#server-addons-wrap").css("display","none");

                                                }else
                                                    console.log(result);
                                            }
                                        });

                                    }

                                    function change_server_period(elem){
                                        var option  = $("option:selected",$(elem));

                                        var amount  = option.data("amount");
                                        var period  = option.data("period");
                                        var time    = option.data("time");

                                        $("input[name=server_amount]").val(amount);
                                        $("select[name=server_period] option").removeAttr("selected");
                                        $("select[name=server_period] option[value='"+period+"']").attr("selected",true);
                                        $("input[name=server_period_time]").val(time);
                                    }
                                </script>
                                <select name="server_pid" size="10" onchange="change_server_product(this);">
                                    <?php
                                        $line   = "";
                                        $products   = $functions["get_category_products"]("server",0);
                                        if($products){
                                            foreach ($products as $product) {
                                                ?>
                                                <option value="<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                                <?php
                                            }
                                        }

                                        $get_pcategories = $functions["get_product_categories"]("products","server");
                                        if($get_pcategories){
                                        foreach($get_pcategories AS $row){
                                    ?>
                                    <optgroup label="<?php echo $row["title"]; ?>">
                                        <?php
                                            preg_match('/\-+[- ]/',$row["title"],$match);
                                            $line   = rtrim(isset($match[0]) ? $match[0] : "");
                                            $products   = $functions["get_category_products"]("server",$row["id"]);
                                            if($products){
                                                foreach ($products as $product) {
                                                    ?>
                                                    <option value="<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                                    <?php
                                                }
                                            }

                                            }
                                            }
                                        ?>
                                    </optgroup>
                                </select>
                            </div>
                        </div>

                        <div class="formcon" id="server-product-periodicals-wrap" style="display: none;">
                            <div class="yuzde30"><?php echo __("admin/orders/create-product-periodicals"); ?></div>
                            <div class="yuzde70">
                                <select name="server_selected_price" id="server-product-periodicals" onchange="change_server_period(this);"></select>
                            </div>
                        </div>

                        <div class="formcon">
                            <div class="yuzde30"><?php echo __("admin/orders/detail-pricing"); ?></div>
                            <div class="yuzde70">

                                <input class="yuzde15" name="server_period_time" type="text" placeholder="<?php echo __("admin/orders/detail-pricing-period"); ?>" value=""> -
                                <select class="yuzde15" name="server_period">
                                    <?php
                                        foreach(___("date/periods") AS $k=>$v){
                                            ?>
                                            <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                            <?php
                                        }
                                    ?>
                                </select> -
                                <input class="yuzde15" name="server_amount" type="text" placeholder="<?php echo __("admin/orders/detail-pricing-amount"); ?>" value=""> -
                                <select class="yuzde20" name="server_amount_cid">
                                    <?php
                                        foreach(Money::getCurrencies() AS $curr){
                                            ?>
                                            <option value="<?php echo $curr["id"]; ?>"><?php echo $curr["name"]." (".$curr["code"].")"; ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                                <div class="clear"></div>

                            </div>
                        </div>


                    </div><!-- server content end -->

                    <div class="content-wrap content-software" style="display: none;"><!-- software content start -->

                        <div class="formcon">
                            <div class="yuzde30"><?php echo __("admin/orders/create-product-domain"); ?></div>
                            <div class="yuzde70">
                                <input type="text" name="software_domain" value="">
                            </div>
                        </div>

                        <div class="formcon">
                            <div class="yuzde30"><?php echo __("admin/orders/create-select-product"); ?></div>
                            <div class="yuzde70">
                                <script type="text/javascript">
                                    function change_software_product(elem){
                                        var value = $(elem).val();
                                        var request = MioAjax({
                                            action:"<?php echo $links["controller"]; ?>",
                                            method:"POST",
                                            data:{
                                                operation:"get_create_product_info",
                                                type:"software",
                                                id:value,
                                                user_id:$("#select-user").val(),
                                            },
                                        },true,true);

                                        request.done(function(result){
                                            if(result != ''){
                                                var solve = getJson(result);
                                                if(solve !== false){
                                                    var prices = solve.prices != undefined ? solve.prices : false;
                                                    var addons = solve.addons != undefined ? solve.addons : false;

                                                    if(prices){
                                                        $("#software-product-periodicals-wrap").css("display","block");
                                                        var select = $("#software-product-periodicals");
                                                        var select_raw = '';
                                                        $(prices).each(function(k,v){
                                                            select_raw += '<option ';
                                                            if(k == 0) select_raw += 'selected ';
                                                            select_raw += 'value="'+k+'" ';
                                                            select_raw += 'data-amount="'+v.amount+'" ';
                                                            select_raw += 'data-period="'+v.period+'" ';
                                                            select_raw += 'data-time="'+v.time+'"';
                                                            select_raw += '>'+v.text+'</option>';
                                                        });
                                                        select.html(select_raw);
                                                        select.trigger("change");
                                                    }else
                                                        $("#software-product-periodicals-wrap").css("display","none");

                                                    if(addons){
                                                        $("#software-addons-wrap").css("display","inline-block");
                                                        var addons_raw = '';
                                                        $(addons).each(function(k,v){
                                                            addons_raw += '<div class="formcon">';
                                                            addons_raw += '<div class="yuzde30">'+v.name+'</div>';
                                                            addons_raw += '<div class="yuzde70">';

                                                            addons_raw += '<input checked type="radio" name="software_addons['+v.id+']" id="addon_'+v.id+'_option_none" class="radio-custom" value="none"><label class="radio-custom-label" for="addon_'+v.id+'_option_none"><?php echo ___("needs/none"); ?></label><div class="clear"></div>';
                                                            $(v.options).each(function(kk,vv){
                                                                addons_raw += '<input type="radio" name="software_addons['+v.id+']" id="addon_'+v.id+'_option_'+vv.id+'" class="radio-custom" value="'+vv.id+'"><label class="radio-custom-label" for="addon_'+v.id+'_option_'+vv.id+'">'+vv.text+'</label><div class="clear"></div>';
                                                            });

                                                            addons_raw += '</div>';
                                                            addons_raw += '</div>';


                                                        });
                                                        $("#software-addons").html(addons_raw);
                                                    }else
                                                        $("#software-addons-wrap").css("display","none");

                                                }else
                                                    console.log(result);
                                            }
                                        });

                                    }

                                    function change_software_period(elem){
                                        var option  = $("option:selected",$(elem));

                                        var amount  = option.data("amount");
                                        var period  = option.data("period");
                                        var time    = option.data("time");

                                        $("input[name=software_amount]").val(amount);
                                        $("select[name=software_period] option").removeAttr("selected");
                                        $("select[name=software_period] option[value='"+period+"']").attr("selected",true);
                                        $("input[name=software_period_time]").val(time);
                                    }
                                </script>
                                <select name="software_pid" size="10" onchange="change_software_product(this);">
                                    <?php
                                        $line   = "";
                                        $products   = $functions["get_category_products"]("software","0");
                                        if($products){
                                            foreach ($products as $product) {
                                                ?>
                                                <option value="<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                                <?php
                                            }
                                        }

                                        $get_pcategories = $functions["get_product_categories"]("softwares");
                                        if($get_pcategories){
                                        foreach($get_pcategories AS $row){
                                    ?>
                                    <optgroup label="<?php echo $row["title"]; ?>">
                                        <?php
                                            preg_match('/\-+[- ]/',$row["title"],$match);
                                            $line   = rtrim(isset($match[0]) ? $match[0] : "");
                                            $products   = $functions["get_category_products"]("software",$row["id"]);
                                            if($products){
                                                foreach ($products as $product) {
                                                    ?>
                                                    <option value="<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                                    <?php
                                                }
                                            }

                                            }
                                            }
                                        ?>
                                    </optgroup>
                                </select>
                            </div>
                        </div>

                        <div class="formcon" id="software-product-periodicals-wrap" style="display: none;">
                            <div class="yuzde30"><?php echo __("admin/orders/create-product-periodicals"); ?></div>
                            <div class="yuzde70">
                                <select name="software_selected_price" id="software-product-periodicals" onchange="change_software_period(this);"></select>
                            </div>
                        </div>

                        <div class="formcon">
                            <div class="yuzde30"><?php echo __("admin/orders/detail-pricing"); ?></div>
                            <div class="yuzde70">

                                <input class="yuzde15" name="software_period_time" type="text" placeholder="<?php echo __("admin/orders/detail-pricing-period"); ?>" value=""> -
                                <select class="yuzde15" name="software_period">
                                    <?php
                                        foreach(___("date/periods") AS $k=>$v){
                                            ?>
                                            <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                            <?php
                                        }
                                    ?>
                                </select> -
                                <input class="yuzde15" name="software_amount" type="text" placeholder="<?php echo __("admin/orders/detail-pricing-amount"); ?>" value=""> -
                                <select class="yuzde20" name="software_amount_cid">
                                    <?php
                                        foreach(Money::getCurrencies() AS $curr){
                                            ?>
                                            <option value="<?php echo $curr["id"]; ?>"><?php echo $curr["name"]." (".$curr["code"].")"; ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                                <div class="clear"></div>

                            </div>
                        </div>

                    </div><!-- software content end -->

                    <?php
                        $pspecialGroups = $functions["get_special_pgroups"]();
                        if($pspecialGroups){
                            foreach($pspecialGroups AS $category){
                                ?>
                                <div class="content-wrap content-special" id="special-<?php echo $category["id"]; ?>" style="display: none;"><!-- special content start -->
                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/orders/create-select-product"); ?></div>
                                        <div class="yuzde70">
                                            <script type="text/javascript">
                                                function change_special_<?php echo $category["id"]; ?>_product(elem){
                                                    var value = $(elem).val();
                                                    var request = MioAjax({
                                                        action:"<?php echo $links["controller"]; ?>",
                                                        method:"POST",
                                                        data:{
                                                            operation:"get_create_product_info",
                                                            type:"special",
                                                            id:value,
                                                            user_id:$("#select-user").val(),
                                                        },
                                                    },true,true);

                                                    request.done(function(result){
                                                        if(result != ''){
                                                            var solve = getJson(result);
                                                            if(solve !== false){
                                                                var prices = solve.prices != undefined ? solve.prices : false;
                                                                var addons = solve.addons != undefined ? solve.addons : false;

                                                                if(solve.show_domain != undefined && solve.show_domain === true)
                                                                    $("#special-<?php echo $category["id"]; ?> .special-domain-con").css("display","block");
                                                                else
                                                                    $("#special-<?php echo $category["id"]; ?> .special-domain-con").css("display","none");


                                                                if(prices){
                                                                    $("#special-<?php echo $category["id"]; ?> #special-product-periodicals-wrap").css("display","block");
                                                                    var select = $("#special-<?php echo $category["id"]; ?> #special-product-periodicals");
                                                                    var select_raw = '';
                                                                    $(prices).each(function(k,v){
                                                                        select_raw += '<option ';
                                                                        if(k == 0) select_raw += 'selected ';
                                                                        select_raw += 'value="'+k+'" ';
                                                                        select_raw += 'data-amount="'+v.amount+'" ';
                                                                        select_raw += 'data-period="'+v.period+'" ';
                                                                        select_raw += 'data-time="'+v.time+'"';
                                                                        select_raw += '>'+v.text+'</option>';
                                                                    });
                                                                    select.html(select_raw);
                                                                    select.trigger("change");
                                                                }
                                                                else
                                                                    $("#special-<?php echo $category["id"]; ?> #special-product-periodicals-wrap").css("display","none");

                                                                if(addons){
                                                                    $("#special-addons-wrap").css("display","inline-block");
                                                                    var addons_raw = '';
                                                                    $(addons).each(function(k,v){
                                                                        addons_raw += '<div class="formcon">';
                                                                        addons_raw += '<div class="yuzde30">'+v.name+'</div>';
                                                                        addons_raw += '<div class="yuzde70">';

                                                                        addons_raw += '<input checked type="radio" name="special_addons['+v.id+']" id="addon_'+v.id+'_option_none" class="radio-custom" value="none"><label class="radio-custom-label" for="addon_'+v.id+'_option_none"><?php echo ___("needs/none"); ?></label><div class="clear"></div>';
                                                                        $(v.options).each(function(kk,vv){
                                                                            addons_raw += '<input type="radio" name="special_addons['+v.id+']" id="addon_'+v.id+'_option_'+vv.id+'" class="radio-custom" value="'+vv.id+'"><label class="radio-custom-label" for="addon_'+v.id+'_option_'+vv.id+'">'+vv.text+'</label><div class="clear"></div>';
                                                                        });

                                                                        addons_raw += '</div>';
                                                                        addons_raw += '</div>';


                                                                    });
                                                                    $("#special-addons").html(addons_raw);
                                                                }
                                                                else{
                                                                    $("#special-addons-wrap").css("display","none");
                                                                    $("#special-addons").html('');
                                                                }

                                                            }else
                                                                console.log(result);
                                                        }
                                                    });

                                                }

                                                function change_special_<?php echo $category["id"]; ?>_period(elem){
                                                    var option  = $("option:selected",$(elem));

                                                    var amount  = option.data("amount");
                                                    var period  = option.data("period");
                                                    var time    = option.data("time");

                                                    $("#special-<?php echo $category["id"]; ?> input[name=special_amount]").val(amount);
                                                    $("#special-<?php echo $category["id"]; ?> select[name=special_period] option").removeAttr("selected");
                                                    $("#special-<?php echo $category["id"]; ?> select[name=special_period] option[value='"+period+"']").attr("selected",true);
                                                    $("#special-<?php echo $category["id"]; ?> input[name=special_period_time]").val(time);
                                                }
                                            </script>
                                            <select name="special_pid" size="10" onchange="change_special_<?php echo $category["id"]; ?>_product(this);">
                                                <?php
                                                    $line   = "";
                                                    $products   = $functions["get_category_products"]("special",$category["id"]);
                                                    if($products){
                                                        foreach ($products as $product) {
                                                            ?>
                                                            <option value="<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                                            <?php
                                                        }
                                                    }

                                                    $get_pcategories = $functions["get_product_categories"]("products","special",$category["id"]);
                                                    if($get_pcategories){
                                                    foreach($get_pcategories AS $row){
                                                ?>
                                                <optgroup label="<?php echo $row["title"]; ?>">
                                                    <?php
                                                        preg_match('/\-+[- ]/',$row["title"],$match);
                                                        $line   = rtrim(isset($match[0]) ? $match[0] : "");
                                                        $products   = $functions["get_category_products"]("special",$row["id"]);
                                                        if($products){
                                                            foreach ($products as $product) {
                                                                ?>
                                                                <option value="<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                                                <?php
                                                            }
                                                        }

                                                        }
                                                        }
                                                    ?>
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="formcon special-domain-con" style="display: none;">
                                        <div class="yuzde30"><?php echo __("admin/orders/create-product-domain"); ?></div>
                                        <div class="yuzde70">
                                            <input type="text" name="special_domain" value="">
                                        </div>
                                    </div>

                                    <div class="formcon" id="special-product-periodicals-wrap" style="display: none;">
                                        <div class="yuzde30"><?php echo __("admin/orders/create-product-periodicals"); ?></div>
                                        <div class="yuzde70">
                                            <select name="special_selected_price" id="special-product-periodicals" onchange="change_special_<?php echo $category["id"]; ?>_period(this);"></select>
                                        </div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/orders/detail-pricing"); ?></div>
                                        <div class="yuzde70">

                                            <input class="yuzde15" name="special_period_time" type="text" placeholder="<?php echo __("admin/orders/detail-pricing-period"); ?>" value=""> -
                                            <select class="yuzde15" name="special_period">
                                                <?php
                                                    foreach(___("date/periods") AS $k=>$v){
                                                        ?>
                                                        <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                                        <?php
                                                    }
                                                ?>
                                            </select> -
                                            <input class="yuzde15" name="special_amount" type="text" placeholder="<?php echo __("admin/orders/detail-pricing-amount"); ?>" value=""> -
                                            <select class="yuzde20" name="special_amount_cid">
                                                <?php
                                                    foreach(Money::getCurrencies() AS $curr){
                                                        ?>
                                                        <option value="<?php echo $curr["id"]; ?>"><?php echo $curr["name"]." (".$curr["code"].")"; ?></option>
                                                        <?php
                                                    }
                                                ?>
                                            </select>
                                            <div class="clear"></div>

                                        </div>
                                    </div>

                                </div><!-- special content end -->
                                <?php
                            }
                        }
                    ?>

                    <div class="content-wrap content-sms" style="display: none;"><!-- software content start -->

                        <div class="formcon">
                            <div class="yuzde30">Adınız Soyadınız</div>
                            <div class="yuzde70">
                                <input type="text" name="sms_name" value="">
                            </div>
                        </div>

                        <div class="formcon">
                            <div class="yuzde30">Doğum Tarihi</div>
                            <div class="yuzde70">
                                <input type="date" name="sms_birthday" value="">
                            </div>
                        </div>

                        <div class="formcon">
                            <div class="yuzde30">T.C Kimlik No</div>
                            <div class="yuzde70">
                                <input type="text" name="sms_identity" value="" maxlength="11" onkeypress="return event.charCode >= 48 && event.charCode<= 57">
                            </div>
                        </div>

                        <div class="formcon">
                            <div class="yuzde30"><?php echo __("admin/orders/create-select-product"); ?></div>
                            <div class="yuzde70">
                                <script type="text/javascript">
                                    function change_sms_product(elem){
                                        var value = $(elem).val();
                                        var request = MioAjax({
                                            action:"<?php echo $links["controller"]; ?>",
                                            method:"POST",
                                            data:{
                                                operation:"get_create_product_info",
                                                type:"sms",
                                                id:value,
                                                user_id:$("#select-user").val(),
                                            },
                                        },true,true);

                                        request.done(function(result){
                                            if(result != ''){
                                                var solve = getJson(result);
                                                if(solve !== false){
                                                    var prices = solve.prices;

                                                    $("input[name=sms_amount]").val(prices[0].amount);

                                                }else
                                                    console.log(result);
                                            }
                                        });

                                    }
                                </script>
                                <select name="sms_pid" size="10" onchange="change_sms_product(this);">
                                    <?php
                                        $products   = $functions["get_category_products"]("sms",0);
                                        if($products){
                                            foreach ($products as $product) {
                                                ?>
                                                <option value="<?php echo $product["id"]; ?>"><?php echo $product["title"]; ?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="formcon">
                            <div class="yuzde30"><?php echo __("admin/orders/detail-pricing"); ?></div>
                            <div class="yuzde70">
                                <input class="yuzde15" name="sms_amount" type="text" placeholder="<?php echo __("admin/orders/detail-pricing-amount"); ?>" value=""> -
                                <select class="yuzde20" name="sms_amount_cid">
                                    <?php
                                        foreach(Money::getCurrencies() AS $curr){
                                            ?>
                                            <option value="<?php echo $curr["id"]; ?>"><?php echo $curr["name"]." (".$curr["code"].")"; ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                                <div class="clear"></div>

                            </div>
                        </div>

                    </div><!-- SMS content end -->

                    <div class="formcon" id="order-status-wrap" style="display: none;">
                        <div class="yuzde30"><?php echo __("admin/orders/create-order-status"); ?></div>
                        <div class="yuzde70">

                            <select name="order-status">
                                <option value="waiting"><?php echo __("admin/orders/status-waiting"); ?></option>
                                <option value="inprocess"><?php echo __("admin/orders/status-inprocess"); ?></option>
                                <option value="active" selected><?php echo __("admin/orders/status-active"); ?></option>
                                <option value="suspended"><?php echo __("admin/orders/status-suspended"); ?></option>
                                <option value="cancelled"><?php echo __("admin/orders/status-cancelled"); ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="formcon" id="invoice-content" style="display: none;">
                        <div class="yuzde30"><?php echo __("admin/orders/create-invoice"); ?></div>
                        <div class="yuzde70">
                            <input onclick="$('#pmethods,#notification_wrap').css('display','block');" type="radio" name="invoice-option" value="paid" class="radio-custom" id="invoice-option-paid">
                            <label class="radio-custom-label" for="invoice-option-paid" style="margin-right:15px;"><?php echo __("admin/orders/create-invoice-option-paid"); ?></label>

                            <input onclick="$('#pmethods').css('display','none'),$('#notification_wrap').css('display','block');" type="radio" name="invoice-option" value="unpaid" class="radio-custom" id="invoice-option-unpaid">
                            <label class="radio-custom-label" for="invoice-option-unpaid" style="margin-right:15px;"><?php echo __("admin/orders/create-invoice-option-unpaid"); ?></label>

                            <input onclick="$('#pmethods,#notification_wrap').css('display','none');" type="radio" name="invoice-option" value="none" class="radio-custom" id="invoice-option-none" checked>
                            <label class="radio-custom-label" for="invoice-option-none" style="margin-right:15px;"><?php echo __("admin/orders/create-invoice-option-none"); ?></label>

                            <div class="formcon" id="pmethods" style="display: none;">
                                <div class="yuzde30"><?php echo __("admin/orders/create-invoice-payment-method"); ?>:</div>
                                <div class="yuzde70">
                                    <select name="pmethod">
                                        <option value="none"><?php echo ___("needs/none"); ?></option>
                                        <?php
                                            if($pmethods){
                                                foreach($pmethods AS $k=>$v){
                                                    ?><option value="<?php echo $k; ?>"><?php echo $v; ?></option><?php
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>

                            </div>

                            <div class="formcon" id="notification_wrap" style="display: none;">
                                <div class="yuzde30"><?php echo __("admin/orders/create-notification"); ?>:</div>
                                <div class="yuzde70">
                                    <input type="checkbox" name="notification" value="1" class="checkbox-custom" id="notification">
                                    <label for="notification" class="checkbox-custom-label"></label>
                                </div>

                            </div>

                        </div>
                    </div>

                    <div style="display: none;" class="content-wrap content-hosting">
                        <div class="accordion" id="hosting-addons-wrap" style="width:100%; margin-top:10px; display: none;">

                            <h3><?php echo __("admin/orders/create-product-addons"); ?></h3>
                            <div id="hosting-addons">

                            </div>
                        </div>
                    </div>

                    <div style="display: none;" class="content-wrap content-server">
                        <div class="accordion" id="server-addons-wrap" style="width:100%; margin-top:10px; display: none;">

                            <h3><?php echo __("admin/orders/create-product-addons"); ?></h3>
                            <div id="server-addons">

                            </div>
                        </div>
                    </div>

                    <div style="display: none;" class="content-wrap content-software">
                        <div class="accordion" id="software-addons-wrap" style="width:100%; margin-top:10px; display: none;">

                            <h3><?php echo __("admin/orders/create-product-addons"); ?></h3>
                            <div id="software-addons">

                            </div>
                        </div>
                    </div>

                    <div class="accordion" id="special-addons-wrap" style="width:100%; margin-top:10px; display: none;">

                        <h3><?php echo __("admin/orders/create-product-addons"); ?></h3>
                        <div id="special-addons"></div>
                    </div>



                    <div style="float:right;margin-top:10px;" id="continue_button" class="guncellebtn yuzde30">
                        <a class="yesilbtn gonderbtn" id="addForm_submit" href="javascript:void(0);"><?php echo __("admin/orders/create-button"); ?></a>
                    </div>
                    <div class="clear"></div>


                </form>
            </div>


        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>