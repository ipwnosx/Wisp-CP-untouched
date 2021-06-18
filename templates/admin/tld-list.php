<?php
    if(Filter::GET("bring") == "adjustments"){
        ?>
        <style type="text/css">
        </style>
        <script type="text/javascript">
            $(document).ready(function(){
                $('#sortable-body').dragSort({
                    targetEle: '.sortable-item',
                    replaceStyle: {'padding': '0',},
                    dragStyle: {
                        'position': 'fixed',
                        'box-shadow': '10px 10px 20px 0 #eee'
                    }});


            });
        </script>
        <form action="<?php echo $links["controller"]; ?>" method="post" id="adjustmentsForm">
            <input type="hidden" name="operation" value="update_tld_adjustments">


            <div id="adjustments_table">

                <div class="adjustments_table-title">
                    <div class="yuzde33x"><?php echo __("admin/products/domain-list-name"); ?></div>
                    <div class="yuzde33x"><?php echo __("admin/products/domain-list-max-years"); ?></div>
                    <div class="yuzde33x">
                        <?php echo __("admin/products/domain-list-currency"); ?>
                        <div class="clear"></div>
                        <select id="currency_all">
                            <option value=""><?php echo ___("needs/select-your"); ?></option>
                            <?php
                                foreach(Money::getCurrencies() AS $currency){
                                    ?>
                                    <option value="<?php echo $currency["id"]; ?>"><?php echo $currency["name"]." (".$currency["code"].")"; ?></option>
                                    <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div class="yuzde33x">
                        <?php echo __("admin/products/domain-list-dns-manage"); ?>
                        <div class="clear"></div>
                        <input type="checkbox" id="dns_manage_all" class="checkbox-custom">
                        <label for="dns_manage_all" class="checkbox-custom-label"></label>
                    </div>
                    <div class="yuzde33x">
                        <?php echo __("admin/products/domain-list-whois-privacy"); ?>
                        <div class="clear"></div>
                        <input type="checkbox" id="whois_privacy_all" class="checkbox-custom">
                        <label for="whois_privacy_all" class="checkbox-custom-label"></label>
                    </div>
                    <div class="yuzde33x">
                        <?php echo __("admin/products/domain-list-epp-code"); ?>
                        <div class="clear"></div>
                        <input type="checkbox" id="epp_code_all" class="checkbox-custom">
                        <label for="epp_code_all" class="checkbox-custom-label"></label>
                    </div>
                    <div class="yuzde33x">
                        <?php echo __("admin/products/domain-list-paperwork"); ?>
                        <div class="clear"></div>
                        <input type="checkbox" id="paperwork_all" class="checkbox-custom">
                        <label for="paperwork_all" class="checkbox-custom-label"></label>
                    </div>
                    <div class="yuzde33x"><?php echo __("admin/products/domain-list-sort"); ?></div>
                </div>

                <div id="sortable-body">

                    <?php
                        if(isset($list) && $list){
                            foreach($list as $k=>$row){
                                $id = $row["id"];
                                ?>

                                <div class="formcon sortable-item">
                                    <div class="yuzde33x">.<?php echo $row["name"]; ?></div>
                                    <div class="yuzde33x"><input type="text" name="values[max_years][<?php echo $id; ?>]" value="<?php echo $row["max_years"]; ?>" onkeypress='return event.charCode>= 48 &&event.charCode<= 57' style="width: 50px;"></div>
                                    <div class="yuzde33x">
                                        <select name="values[currency][<?php echo $id; ?>]" class="currency-item">
                                            <?php
                                                foreach(Money::getCurrencies() AS $currency){
                                                    ?>
                                                    <option<?php echo $row["currency"] == $currency["id"] ? ' selected' : ''; ?> value="<?php echo $currency["id"]; ?>"><?php echo $currency["name"]." (".$currency["code"].")"; ?></option>
                                                    <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="yuzde33x">
                                        <input<?php echo $row["dns_manage"] ? ' checked' : ''; ?> type="checkbox" class="checkbox-custom dns-manage-item" name="values[dns-manage][<?php echo $id; ?>]" value="1" id="tld-<?php echo $id; ?>-dns-manage">
                                        <label for="tld-<?php echo $id; ?>-dns-manage" class="checkbox-custom-label"></label>
                                    </div>
                                    <div class="yuzde33x">
                                        <input<?php echo $row["whois_privacy"] ? ' checked' : ''; ?> type="checkbox" class="checkbox-custom whois-privacy-item" name="values[whois-privacy][<?php echo $id; ?>]" value="1" id="tld-<?php echo $id; ?>-whois-privacy"><label for="tld-<?php echo $id; ?>-whois-privacy" class="checkbox-custom-label"></label>
                                    </div>
                                    <div class="yuzde33x">
                                        <input<?php echo $row["epp_code"] ? ' checked' : ''; ?> type="checkbox" class="checkbox-custom epp-code-item" name="values[epp-code][<?php echo $id; ?>]" value="1" id="tld-<?php echo $id; ?>-epp-code"><label for="tld-<?php echo $id; ?>-epp-code" class="checkbox-custom-label"></label>
                                    </div>
                                    <div class="yuzde33x">
                                        <input<?php echo $row["paperwork"] ? ' checked' : ''; ?> type="checkbox" class="checkbox-custom paperwork-item" name="values[paperwork][<?php echo $id; ?>]" value="1" id="tld-<?php echo $id; ?>-paperwork"><label for="tld-<?php echo $id; ?>-paperwork" class="checkbox-custom-label"></label>
                                    </div>
                                    <div class="yuzde33x">
                                        <input type="hidden" name="values[id][]" value="<?php echo $row["id"]; ?>">
                                        <a class="bearer" style="cursor: move;"><i class="fa fa-sort" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                    ?>

                </div>

            </div>

            <div class="clear"></div>

            <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                <a class="yesilbtn gonderbtn" id="adjustmentsForm_submit" href="javascript:void(0);"><?php echo __("admin/products/update-settings-button"); ?></a>
            </div>

            <div class="clear"></div>

        </form>

        <?php

        return false;
    }
?>
<!DOCTYPE html>
<html>
<head>
    <?php
        $privOperation  = Admin::isPrivilege("PRODUCTS_OPERATION");
        $plugins        = [
                'jquery-ui',
            'dataTables',
            'drag-sort',
            //'Sortable',
        ];
        include __DIR__.DS."inc".DS."head.php";
    ?>
    <script type="text/javascript">

        var table,sortable;
        $(document).ready(function() {

            table = $('#datatable').DataTable({
                "columnDefs": [
                    {
                        "targets": [0],
                        "visible":false,
                        "searchable": false
                    },
                ],
                "aaSorting" : [[0, 'asc']],
                "pageLength" : 20,
                "lengthMenu": [
                    [20, 50, -1], [20, 50, "<?php echo ___("needs/allOf"); ?>"]
                ],
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": "<?php echo $links["ajax"]; ?>",
                responsive: true,
                "oLanguage":<?php include __DIR__.DS."datatable-lang.php"; ?>
            });

            $("#updateForm_submit").on("click",function(){
                $('#datatable input[type=checkbox]:not(:checked)').each(function(){
                    $('<input type="hidden" name="'+$(this).attr("name")+'" value="0" class="unchecked-input">').insertBefore(this);
                });

                MioAjaxElement($(this),{
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                    result:"updateForm_handler",
                });
            });

            $("#adjustments_content").on("click","#adjustmentsForm_submit",function(){
                $('#adjustments_table input[type=checkbox]:not(:checked)').each(function(){
                    $('<input type="hidden" name="'+$(this).attr("name")+'" value="0" class="unchecked-input">').insertBefore(this);
                });

                MioAjaxElement($(this),{
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                    result:"updateForm_handler",
                });
            });

            $("#add_new_tld_modal").on("click","#addNewTLDForm_submit",function(){
                MioAjaxElement($(this),{
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                    result:"updateForm_handler",
                });
            });

            $("#deleteSelected_submit").on("click",function(){

                if(!confirm('<?php echo htmlentities(___("needs/delete-are-you-sure"),ENT_QUOTES);?>')) return false;

                var get_ids = $(".selected-item:checked").map(function(){return $(this).val();}).get();
                var request = MioAjax({
                    action : "<?php echo $links["controller"]; ?>",
                    method : "POST",
                    data:{
                        operation: "deleteSelected_tlds",
                        ids:get_ids
                    },
                    button_element:this,
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                },true,true)
                request.done(updateForm_handler);
            });

            $("#adjustments_content").on("change","#dns_manage_all",function(){
                var checked = $(this).prop("checked");
                $("#adjustments_content .dns-manage-item").prop("checked",checked);
            });

            $("#adjustments_content").on("change","#currency_all",function(){
                var value = $("option:selected",this).val();
                if(value === ''){

                }
                else{
                    $("#adjustments_content .currency-item").val(value);
                }
            });

            $("#adjustments_content").on("change","#whois_privacy_all",function(){
                var checked = $(this).prop("checked");
                $("#adjustments_content .whois-privacy-item").prop("checked",checked);
            });

            $("#adjustments_content").on("change","#epp_code_all",function(){
                var checked = $(this).prop("checked");
                $("#adjustments_content .epp-code-item").prop("checked",checked);
            });

            $("#adjustments_content").on("change","#paperwork_all",function(){
                var checked = $(this).prop("checked");
                $("#adjustments_content .paperwork-item").prop("checked",checked);
            });

            $("#datatable").on("change","#module_all",function(){
                var value = $(this).val();
                $("#datatable .module-item option").removeAttr("selected");
                $("#datatable .module-item option[value='"+value+"']").attr("selected",true);
            });
        });

        function updateForm_handler(result){
            $('.unchecked-input').remove();
            if(result !== ''){
                var solve = getJson(result);
                if(solve !== false){
                    if(solve.status == "error"){
                        if(solve.message != undefined && solve.message != '')
                            alert_error(solve.message,{timer:5000});
                    }else if(solve.status == "successful"){
                        alert_success(solve.message,{timer:2000});
                        table.ajax.reload(null,false);
                        $("#module_all").val('');
                        $("#allSelect").prop('checked',false);
                    }
                }else
                    console.log(result);
            }
        }

        function updateProfitRates(el){
            var proft_rate   = $("#profit-rate").val();

            var request = MioAjax({
                button_element:el,
                waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                action:"<?php echo $links["controller"]; ?>",
                method:"POST",
                data:{
                    operation:"update_domain_settings",
                    profit_rate:proft_rate,
                },
            },true,true);
            request.done(updateForm_handler);
        }

        function addNewTLD(){
            open_modal("add_new_tld_modal");
            $("#promo_content_x").css("display","none");
        }

        function adjustments(){

            if($("#updateForm").css("display") === "none"){

                $("#adjustments_btn").html("<i class='fa fa-cogs'></i> <?php echo __("admin/products/adjustments"); ?>");

                $("#adjustments_content").animate({opacity:0},500,function(){
                    $(this).css({display:"none",opacity:1});
                    table.ajax.reload();
                    $("#updateForm").fadeIn(300);
                });

                return true;
            }
            else
            {
                $("#adjustments_btn").html("<i class='fa fa-chevron-left'></i> <?php echo __("admin/tools/button-turn-back"); ?>");
            }

            $("#updateForm").animate({opacity:0.3},500,function(){
                $(this).css({display:"none",opacity:1});
                $("#adjustments_loader").fadeIn(200);
                $("#adjustments_content").html('').css("display","none");

                var request = MioAjax({
                    action: "<?php echo $links["controller"]; ?>?bring=adjustments",
                    method: "GET",
                },true,true);

                request.done(function(result){
                    $("#adjustments_loader").animate({opacity:0},600,function(){
                        $(this).css({display:"none",opacity:1});
                        $("#adjustments_content").html(result).fadeIn(300);
                    });
                });

            });
        }

        function setPricing(id){
            var name     = $("input[name='values[name]["+id+"]']").val();

            var currcy   = $("input[name='values[currency]["+id+"]']"),
                reg_cost = $("input[name='values[register-cost]["+id+"]']"),
                ren_cost = $("input[name='values[renewal-cost]["+id+"]']"),
                tra_cost = $("input[name='values[transfer-cost]["+id+"]']");

            var reg_price = $("input[name='values[register-price]["+id+"]']"),
                ren_price = $("input[name='values[renewal-price]["+id+"]']"),
                tra_price = $("input[name='values[transfer-price]["+id+"]']");

            var affiliate_disable   = $("input[name='values[affiliate-disable]["+id+"]']");
            var affiliate_rate      = $("input[name='values[affiliate-rate]["+id+"]']");



            var newTitle = '<?php echo htmlspecialchars(__("admin/products/domain-list-pricing-modal-title")); ?>';
            newTitle = newTitle.replace("{name}",name);
            $("#setPricing_modal").attr("data-iziModal-title",newTitle);
            open_modal("setPricing_modal");

            var currency       = $("#currency");
            var
                register_cost  = $("#register-cost"),
                renewal_cost   = $("#renewal-cost"),
                transfer_cost  = $("#transfer-cost");

            var
                register_price = $("#register-price"),
                renewal_price  = $("#renewal-price"),
                transfer_price = $("#transfer-price");

            var aff_disable     = $("#aff-disable");
            var aff_rate        = $("#aff-rate");

            $("option",currency).removeAttr("selected");
            $("option[value='"+currcy.val()+"']",currency).attr("selected",true);
            
            register_cost.val(reg_cost.val());
            renewal_cost.val(ren_cost.val());
            transfer_cost.val(tra_cost.val());

            register_price.val(reg_price.val());
            renewal_price.val(ren_price.val());
            transfer_price.val(tra_price.val());

            aff_disable.prop('checked',affiliate_disable.val() === '1');
            aff_rate.val(affiliate_rate.val());


            currency.change(function(){currcy.val($(this).val());});
            register_cost.change(function(){reg_cost.val($(this).val());});
            renewal_cost.change(function(){ren_cost.val($(this).val());});
            transfer_cost.change(function(){tra_cost.val($(this).val());});
            register_price.change(function(){reg_price.val($(this).val());});
            renewal_price.change(function(){ren_price.val($(this).val());});
            transfer_price.change(function(){tra_price.val($(this).val());});
            aff_disable.change(function(){affiliate_disable.val(aff_disable.prop('checked') ? 1 : 0);});
            aff_rate.change(function(){affiliate_rate.val($(this).val());});
        }
        function setPromotion(id){
            var name     = $("input[name='values[name]["+id+"]']").val();

            var promo_stat      = $("input[name='values[promo-status]["+id+"]']"),
                promo_reg_price = $("input[name='values[promo-register-price]["+id+"]']"),
                promo_tra_price = $("input[name='values[promo-transfer-price]["+id+"]']"),
                promo_duedat    = $("input[name='values[promo-duedate]["+id+"]']");

            var newTitle = '<?php echo htmlspecialchars(__("admin/products/domain-list-promotion-modal-title")); ?>';
            newTitle = newTitle.replace("{name}",name);
            $("#setPromotion_modal").attr("data-iziModal-title",newTitle);
            open_modal("setPromotion_modal");

            var
                promo_status          = $("#promo-status"),
                promo_register_price  = $("#promo-register-price"),
                promo_transfer_price  = $("#promo-transfer-price"),
                promo_duedate         = $("#promo-duedate");



            promo_status.prop("checked",promo_stat.val() == 1 ? true : false);
            promo_register_price.val(promo_reg_price.val());
            promo_transfer_price.val(promo_tra_price.val());
            promo_duedate.val(promo_duedat.val());

            if(promo_stat.val() == 1)
                $("#promo_content").css("display","block");
            else
                $("#promo_content").css("display","none");


            promo_status.change(function(){promo_stat.val(promo_status.prop("checked") ? "1" : "0");});
            promo_register_price.change(function(){promo_reg_price.val($(this).val());});
            promo_transfer_price.change(function(){promo_tra_price.val($(this).val());});
            promo_duedate.change(function(){promo_duedat.val($(this).val());});

        }
    </script>

</head>
<body>

<div id="add_new_tld_modal" data-izimodal-title="<?php echo __("admin/products/add-new-tld-button"); ?>" style="display: none;">
    <div class="padding20">

        <form action="<?php echo $links["controller"]; ?>" method="post" id="addNewTLDForm">
            <input type="hidden" name="operation" value="add_new_tld">

            <div class="formcon">
                <div class="yuzde30"><?php echo __("admin/products/domain-list-name"); ?></div>
                <div class="yuzde70">
                    <input type="text" name="name" value="" placeholder=".com">
                </div>
            </div>

            <div class="formcon">
                <div class="yuzde30"><?php echo __("admin/products/domain-list-status"); ?></div>
                <div class="yuzde70">

                    <input checked type="checkbox" class="sitemio-checkbox" id="tld-status" name="status" value="1">
                    <label for="tld-status" style="float:none;display:inline-block;text-align:left;" class="sitemio-checkbox-label"></label>

                </div>
            </div>

            <div class="formcon">
                <div class="yuzde30"><?php echo __("admin/products/domain-list-dns-manage"); ?></div>
                <div class="yuzde70">
                    <input type="checkbox" name="dns_manage" value="1" class="checkbox-custom" id="tld_dns_manage">
                    <label class="checkbox-custom-label" for="tld_dns_manage"></label>
                </div>
            </div>

            <div class="formcon">
                <div class="yuzde30"><?php echo __("admin/products/domain-list-whois-privacy"); ?></div>
                <div class="yuzde70">
                    <input type="checkbox" name="whois_privacy" value="1" class="checkbox-custom" id="tld_whois_privacy">
                    <label class="checkbox-custom-label" for="tld_whois_privacy"></label>
                </div>
            </div>

            <div class="formcon">
                <div class="yuzde30"><?php echo __("admin/products/domain-list-epp-code"); ?></div>
                <div class="yuzde70">
                    <input type="checkbox" name="epp_code" value="1" class="checkbox-custom" id="tld_epp_code">
                    <label class="checkbox-custom-label" for="tld_epp_code"></label>
                </div>
            </div>

            <div class="formcon">
                <div class="yuzde30"><?php echo __("admin/products/domain-list-paperwork"); ?></div>
                <div class="yuzde70">
                    <input type="checkbox" name="paperwork" value="1" class="checkbox-custom" id="tld_paperwork">
                    <label class="checkbox-custom-label" for="tld_paperwork"></label>
                </div>
            </div>

            <div class="formcon">
                <div class="yuzde30"><?php echo __("admin/products/domain-list-module"); ?></div>
                <div class="yuzde70">
                    <select name="module">
                        <option value="none"><?php echo __("admin/products/domain-list-module-none"); ?></option>
                        <?php
                            if(isset($registrars) && $registrars){
                                foreach($registrars AS $registrar){
                                    ?>
                                    <option><?php echo $registrar; ?></option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>


            <div class="formcon">
                <div class="yuzde30"><?php echo __("admin/products/domain-list-currency"); ?></div>
                <div class="yuzde70">
                    <select name="currency">
                        <?php
                            foreach(Money::getCurrencies() AS $currency){
                                ?>
                                <option value="<?php echo $currency["id"]; ?>"><?php echo $currency["name"]." (".$currency["code"].")"; ?></option>
                                <?php
                            }
                        ?>
                    </select>
                </div>
            </div>

            <div class="formcon">
                <div class="yuzde30">
                    <span><?php echo __("admin/products/domain-list-cost-annual"); ?></span>
                </div>

                <div class="yuzde20">
                    <?php echo __("admin/products/domain-list-register"); ?>
                    <input name="register_cost" type="text" placeholder="<?php echo __("admin/products/domain-list-price-placeholder"); ?>" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57'>
                </div>

                <div class="yuzde20">
                    <?php echo __("admin/products/domain-list-renewal"); ?>
                    <input name="renewal_cost" type="text" placeholder="<?php echo __("admin/products/domain-list-price-placeholder"); ?>" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57'>
                </div>

                <div class="yuzde20">
                    <?php echo __("admin/products/domain-list-transfer"); ?>
                    <input name="transfer_cost" type="text" placeholder="<?php echo __("admin/products/domain-list-price-placeholder"); ?>" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57'>
                </div>

            </div>

            <div class="formcon">
                <div class="yuzde30">
                    <span><?php echo __("admin/products/domain-list-sales-annual"); ?></span>
                </div>

                <div class="yuzde20">
                    <?php echo __("admin/products/domain-list-register"); ?>
                    <input name="register_price" type="text" placeholder="<?php echo __("admin/products/domain-list-price-placeholder"); ?>" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57'>
                </div>

                <div class="yuzde20">
                    <?php echo __("admin/products/domain-list-renewal"); ?>
                    <input name="renewal_price" type="text" placeholder="<?php echo __("admin/products/domain-list-price-placeholder"); ?>" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57'>
                </div>

                <div class="yuzde20">
                    <?php echo __("admin/products/domain-list-transfer"); ?>
                    <input name="transfer_price" type="text" placeholder="<?php echo __("admin/products/domain-list-price-placeholder"); ?>" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57'>
                </div>

            </div>

            <div class="formcon">
                <div class="yuzde30"><?php echo __("admin/products/domain-promo-status"); ?></div>
                <div class="yuzde70">
                    <input name="promo_status" class="sitemio-checkbox" type="checkbox" id="promo-status-x" value="1" onchange="if($(this).prop('checked')) $('#promo_content_x').slideDown(250); else $('#promo_content_x').slideUp(250);">
                    <label class="sitemio-checkbox-label" for="promo-status-x"></label>
                </div>
            </div>

            <div id="promo_content_x" style="display: none;">

                <div class="formcon">
                    <div class="yuzde30">
                        <span><?php echo __("admin/products/domain-list-sales-annual"); ?></span>
                    </div>

                    <div class="yuzde20">
                        <?php echo __("admin/products/domain-list-register"); ?>
                        <input name="promo_register_price" type="text" placeholder="<?php echo __("admin/products/domain-list-price-placeholder"); ?>" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57'>
                    </div>

                    <div class="yuzde20">
                        <?php echo __("admin/products/domain-list-transfer"); ?>
                        <input name="promo_transfer_price" type="text" placeholder="<?php echo __("admin/products/domain-list-price-placeholder"); ?>" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57'>
                    </div>
                </div>

                <div class="formcon">
                    <div class="yuzde30"><?php echo __("admin/products/domain-promo-duedate"); ?></div>
                    <div class="yuzde70">
                        <input name="promo_duedate" type="date" placeholder="YYYY-MM-DD">
                    </div>
                </div>

            </div>

            <div class="formcon"  style="display: none;">
                <div class="yuzde30">
                    <?php echo __("admin/products/add-new-product-affiliate"); ?>
                </div>
                <div class="yuzde70">

                    <div class="formcon">
                        <strong style="width: 20%; display:inline-block;"><?php echo __("admin/products/add-new-product-affiliate-disable"); ?></strong>

                        <input type="checkbox" class="checkbox-custom" id="affiliate-disable" name="affiliate_disable" value="1">
                        <label class="checkbox-custom-label" for="affiliate-disable"><span class="kinfo"><?php echo __("admin/products/add-new-product-affiliate-disable-desc"); ?></span></label>
                    </div>

                    <div class="formcon">
                        <strong style="width: 40%; display:inline-block;"><?php echo __("admin/products/add-new-product-affiliate-commission-rate"); ?></strong>
                        <input type="text" name="affiliate_rate" value="" class="yuzde20" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57'>
                        <div class="clear"></div>
                        <span class="kinfo"><?php echo __("admin/products/add-new-product-affiliate-commission-rate-desc"); ?></span>
                    </div>


                </div>
            </div>


            <div class="clear"></div>

            <div style="float:right;" class="guncellebtn yuzde30"><a id="addNewTLDForm_submit" href="javascript:void(0);" class="yesilbtn gonderbtn"><?php echo ___("needs/button-create"); ?></a></div>

            <div class="clear"></div>


        </form>

        <div class="clear"></div>
    </div>
</div>

<div id="setPricing_modal" style="display: none">
    <div class="padding20">

        <div class="formcon">
            <div class="yuzde30"><?php echo __("admin/products/domain-list-currency"); ?></div>
            <div class="yuzde70">
                <select id="currency">
                    <?php
                        foreach(Money::getCurrencies() AS $currency){
                            ?>
                            <option value="<?php echo $currency["id"]; ?>"><?php echo $currency["name"]." (".$currency["code"].")"; ?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>
        </div>

        <div class="formcon">
            <div class="yuzde30">
                <span><?php echo __("admin/products/domain-list-cost-annual"); ?></span>
            </div>

            <div class="yuzde20">
                <?php echo __("admin/products/domain-list-register"); ?>
                <input id="register-cost" type="text" placeholder="<?php echo __("admin/products/domain-list-price-placeholder"); ?>" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57'>
            </div>

            <div class="yuzde20">
                <?php echo __("admin/products/domain-list-renewal"); ?>
                <input id="renewal-cost" type="text" placeholder="<?php echo __("admin/products/domain-list-price-placeholder"); ?>" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57'>
            </div>

            <div class="yuzde20">
                <?php echo __("admin/products/domain-list-transfer"); ?>
                <input id="transfer-cost" type="text" placeholder="<?php echo __("admin/products/domain-list-price-placeholder"); ?>" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57'>
            </div>

        </div>

        <div class="formcon">
            <div class="yuzde30">
                <span><?php echo __("admin/products/domain-list-sales-annual"); ?></span>
            </div>

            <div class="yuzde20">
                <?php echo __("admin/products/domain-list-register"); ?>
                <input id="register-price" type="text" placeholder="<?php echo __("admin/products/domain-list-price-placeholder"); ?>" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57'>
            </div>

            <div class="yuzde20">
                <?php echo __("admin/products/domain-list-renewal"); ?>
                <input id="renewal-price" type="text" placeholder="<?php echo __("admin/products/domain-list-price-placeholder"); ?>" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57'>
            </div>

            <div class="yuzde20">
                <?php echo __("admin/products/domain-list-transfer"); ?>
                <input id="transfer-price" type="text" placeholder="<?php echo __("admin/products/domain-list-price-placeholder"); ?>" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57'>
            </div>

        </div>

        <div class="formcon" style="display: none;">
            <div class="yuzde30">
                <?php echo __("admin/products/add-new-product-affiliate"); ?>
            </div>
            <div class="yuzde70">

                <div class="formcon">
                    <strong style="width: 20%; display:inline-block;"><?php echo __("admin/products/add-new-product-affiliate-disable"); ?></strong>

                    <input type="checkbox" class="checkbox-custom" id="aff-disable" value="1">
                    <label class="checkbox-custom-label" for="aff-disable"><span class="kinfo"><?php echo __("admin/products/add-new-product-affiliate-disable-desc"); ?></span></label>
                </div>

                <div class="formcon">
                    <strong style="width: 40%; display:inline-block;"><?php echo __("admin/products/add-new-product-affiliate-commission-rate"); ?></strong>
                    <input type="text" id="aff-rate" value="" class="yuzde20" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57'>
                    <div class="clear"></div>
                    <span class="kinfo"><?php echo __("admin/products/add-new-product-affiliate-commission-rate-desc"); ?></span>
                </div>


            </div>
        </div>

        <div class="clear"></div>
    </div>

</div>
<div id="setPromotion_modal" style="display: none">
    <div class="padding20">

        <div class="formcon">
            <div class="yuzde30"><?php echo __("admin/products/domain-promo-status"); ?></div>
            <div class="yuzde70">
                <input class="sitemio-checkbox" type="checkbox" id="promo-status" value="1" onchange="if($(this).prop('checked')) $('#promo_content').slideDown(250); else $('#promo_content').slideUp(250);">
                <label class="sitemio-checkbox-label" for="promo-status"></label>
            </div>
        </div>

        <div id="promo_content" style="display: none;">

            <div class="formcon">
                <div class="yuzde30">
                    <span><?php echo __("admin/products/domain-list-sales-annual"); ?></span>
                </div>

                <div class="yuzde20">
                    <?php echo __("admin/products/domain-list-register"); ?>
                    <input id="promo-register-price" type="text" placeholder="<?php echo __("admin/products/domain-list-price-placeholder"); ?>" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57'>
                </div>

                <div class="yuzde20">
                    <?php echo __("admin/products/domain-list-transfer"); ?>
                    <input id="promo-transfer-price" type="text" placeholder="<?php echo __("admin/products/domain-list-price-placeholder"); ?>" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57'>
                </div>
            </div>

            <div class="formcon">
                <div class="yuzde30"><?php echo __("admin/products/domain-promo-duedate"); ?></div>
                <div class="yuzde70">
                    <input id="promo-duedate" type="date" placeholder="YYYY-MM-DD">
                </div>
            </div>

        </div>
        <div class="clear"></div>

    </div>

</div>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1>
                    <strong><?php echo __("admin/products/page-domain-list"); ?></strong>
                    <a href="<?php echo $links["domain-redirect"]; ?>" target="_blank" class="sbtn"><i class="fa fa-external-link" aria-hidden="true"></i></a>
                </h1>
                <?php
                $ui_help_link = 'https://docs.wisecp.com/en/kb/domain-name-service-management';
                if($ui_lang == "tr") $ui_help_link = 'https://docs.wisecp.com/tr/kb/alan-adi-hizmet-yonetimi';
                ?>
                <a title="<?php echo __("admin/help/usage-guide"); ?>" target="_blank" class="pagedocslink" href="<?php echo $ui_help_link; ?>"><i class="fa fa-life-ring" aria-hidden="true"></i></a>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <a href="<?php echo $links["settings"]; ?>" class="lbtn"><i class="fa fa-cog"></i> <?php echo __("admin/products/category-group-settings-button"); ?></a>

            <a href="javascript:void 0;" class="lbtn" onclick="adjustments();" id="adjustments_btn"><i class="fa fa-cogs"></i> <?php echo __("admin/products/adjustments"); ?></a>

            <div class="domainpricingsetting" style="float:right;">
                <?php echo __("admin/products/update-all-of-profit-rates"); ?><input style="width:100px;" name="profit-rate" id="profit-rate" type="text" placeholder="<?php echo __("admin/products/update-all-of-profit-rates-label"); ?>" onkeypress="return event.charCode>= 48 && event.charCode<= 57" value="<?php echo Config::get("options/domain-profit-rate");?>"> <a href="javascript:void 0;" onclick="updateProfitRates(this);" class="blue lbtn"><?php echo __("admin/products/update-button"); ?></a>
            </div>


            <div class="clear"></div>

            <div class="line"></div>

            <form action="<?php echo $links["controller"]; ?>" method="post" id="updateForm">
                <input type="hidden" name="operation" value="update_tld_list">
                <input id="updateForm_from" type="hidden" name="from" value="list">

                <div class="domainpricinglist">

                    <table width="100%" id="datatable" class="table table-striped table-borderedx table-condensed nowrap">
                        <thead style="background:#ebebeb;">
                        <tr>
                            <th align="left">#</th>
                            <th data-orderable="false" align="left"><?php echo __("admin/products/domain-list-name"); ?></th>
                            <th data-orderable="false" align="center"><?php echo __("admin/products/domain-list-pricing"); ?></th>
                            <th data-orderable="false" align="center"><?php echo __("admin/products/domain-list-promotion"); ?></th>
                            <th data-orderable="false" align="center">
                                <?php echo __("admin/products/domain-list-module"); ?>
                                <div class="clear"></div>
                                <select id="module_all" style="background: transparent;">
                                    <option value=""><?php echo ___("needs/select-your"); ?></option>
                                    <option value="none"><?php echo __("admin/products/domain-list-module-none"); ?></option>
                                    <?php
                                        if(isset($registrars) && $registrars){
                                            foreach($registrars AS $registrar){
                                                ?>
                                                <option><?php echo $registrar; ?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </th>
                            <th data-orderable="false" align="center">
                                <?php echo __("admin/products/domain-list-status"); ?>
                                <div class="clear"></div>
                                <input type="checkbox" class="sitemio-checkbox" id="allStatus" onchange="$('.tld-situations').prop('checked',$(this).prop('checked'));"><label for="allStatus" class="sitemio-checkbox-label"></label>
                            </th>
                            <th data-orderable="false" align="center">
                                <input type="checkbox" class="checkbox-custom" id="allSelect" onchange="$('.selected-item').prop('checked',$(this).prop('checked'));"><label for="allSelect" class="checkbox-custom-label"></label>
                            </th>
                        </tr>
                        </thead>
                        <tbody align="center" style="border-top:none;"></tbody>
                    </table>

                    <div class="clear"></div>

                    <div class="line"></div>

                    <div style="float: left;">
                        <a style="float: none;" href="javascript:addNewTLD();void 0;" class="blue lbtn">+ <?php echo __("admin/products/add-new-tld-button"); ?></a>
                    </div>
                    <div style="float: right;width:49%;text-align:right;">
                        <a id="deleteSelected_submit" style="float: none;" href="javascript:void(0);" class="red lbtn"><i class="fa fa-trash"></i> <?php echo __("admin/orders/list-apply-to-selected-delete"); ?></a>
                        <a id="updateForm_submit" style="width: 200px;margin-left: 20px;" href="javascript:void(0);" class="gonderbtn yesilbtn"><?php echo __("admin/products/domain-list-update-button"); ?></a>
                    </div>

                    <div class="clear"></div>
                    <br>
                </div>
            </form>

            <div id="adjustments_loader" style="display: none;">
                <div align="center">
                    <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
                </div>
            </div>
            <div id="adjustments_content" style="display: none;"></div>


            <div class="clear"></div>
        </div>


    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>