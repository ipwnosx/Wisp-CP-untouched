<!DOCTYPE html>
<html>
<head>
    <?php
        $plugins    = ['dataTables'];
        include __DIR__.DS."inc".DS."head.php";
    ?>
    <script type="text/javascript">
        var list_table;

        $(document).ready(function(){

            list_table = $('#list_table').DataTable({
                "columnDefs": [
                    {
                        "targets": [0],
                        "visible":false,
                        "searchable": false
                    }
                ],
                paging: true,
                info: true,
                searching: true,
                responsive: true,
                "language":{"url":"<?php echo APP_URI; ?>/<?php echo ___("package/code"); ?>/datatable/lang.json"}
            });

            $("#settingsForm").bind("keypress", function(e) {
                if (e.keyCode == 13) $("#settings_submit").click();
            });

            $("#settings_submit").on("click",function(){
                MioAjaxElement($(this),{
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                    result:"submit_handler",
                });
            });

            $("#taxRatesForm_submit").on("click",function(){
                MioAjaxElement($(this),{
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                    result:"submit_handler",
                });
            });

            $("#taxation").change(function(){
                if(!$(this).prop("checked")){
                    $("#sebilltad_status").prop("checked",false);
                    $("input[name=rate]").val('0');
                }
            });

            var tab = _GET("tab");
            if(tab != '' && tab != undefined){
                $("#tab-tab .tablinks[data-tab='"+tab+"']").click();
            }else{
                $("#tab-tab .tablinks:eq(0)").addClass("active");
                $("#tab-tab .tabcontent:eq(0)").css("display","block");
            }

        });

        function submit_handler(result){
            if(result !== ''){
                var solve = getJson(result);
                if(solve !== false){
                    if(solve.status == "error"){
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

        function new_tax_rule(){
            open_modal('new_tax_rule_modal');
            $("#DefineNewCity_con").css("display","none");
            $("#DefineNewCity_con input").val('');
            $("#selectCity").css("display","none");
            $("#cityCon").css("display","none");
        }

        function delete_tax_rule(el,country_id,city_id){
            if(!confirm('<?php echo htmlentities(___("needs/delete-are-you-sure")); ?>')) return false;
            var bfr_el_val = $(el).html();

            $(el).html('<i class="fa fa-spinner" style="-webkit-animation:fa-spin 2s infinite linear;animation: fa-spin 2s infinite linear;"></i>');

            var request = MioAjax({
                action:"<?php echo $links["controller"]; ?>",
                method:"POST",
                data:{
                    operation: "delete_tax_rule",
                    country_id: country_id,
                    city_id: city_id
                }
            },true,true);

            request.done(function(result){
                $(el).html(bfr_el_val);
                if(result !== ''){
                    var solve = getJson(result);
                    if(solve !== false){
                        if(solve.status == "error"){
                            if(solve.message != undefined && solve.message != '')
                                alert_error(solve.message,{timer:5000});
                        }else if(solve.status == "successful"){
                            alert_success(solve.message,{timer:2000});
                            list_table.row($(el).parent().parent()).remove().draw();
                        }
                    }else
                        console.log(result);
                }
            });

        }

    </script>
</head>
<body>

<div id="new_tax_rule_modal" style="display: none;" data-izimodal-title="<?php echo __("admin/financial/button-add-new-tax-rate-rule"); ?>">
    <div class="padding20">

        <script type="text/javascript">
            $(document).ready(function(){

                $("#addNewTaxRuleForm_submit").on("click",function(){
                    MioAjaxElement($(this),{
                        waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                        progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                        result:"submit_handler",
                    });
                });

                $("#selectCountry").on("change",function(){
                    var cities = $("option:selected",$(this)).data("cities");

                    if($(this).val() === ''){
                        $("#cityCon").css("display","none");
                    }else{
                        $("#cityCon").css("display","block");
                    }

                    if(cities.length>0){
                        $("#DefineNewCity_con").css("display","none");
                        $("#DefineNewCity_con input").val('');
                        $("#selectCity").css("display","block").html('');
                        $("#selectCity").append('<option value=""><?php echo ___("needs/select-your"); ?></option>');
                        $(cities).each(function(){
                            $("#selectCity").append('<option value="'+this.id+'">'+this.name+'</option>');
                        });
                        $("#selectCity").append('<option value="add-new-city"><?php echo __("admin/financial/add-new-city"); ?></option>');
                    }else{
                        $("#selectCity").css("display","none").html('');
                        $("#DefineNewCity_con").css("display","block");
                    }
                });

                $("#selectCity").on("change",function(){
                    var selection = $("option:selected",$(this)).val();

                    if(selection === "add-new-city"){
                        $("#DefineNewCity_con").css("display","block");
                    }else{
                        $("#DefineNewCity_con").css("display","none");
                        $("#DefineNewCity_con input").val('');
                    }

                });

            });
        </script>
        <form action="<?php echo $links["controller"]; ?>" method="post" id="addNewTaxRuleForm">
            <input type="hidden" name="operation" value="add_new_tax_rule">

            <div class="formcon">
                <div class="yuzde30"><?php echo __("admin/financial/tax-rates-th-country"); ?></div>
                <div class="yuzde70">
                    <select name="country" id="selectCountry">
                        <option value=""><?php echo ___("needs/select-your"); ?></option>
                        <?php
                            if(isset($countries) && $countries){
                                foreach($countries AS $v){
                                    $cities = AddressManager::getCities($v["id"]);
                                    ?>
                                    <option value="<?php echo $v["id"]; ?>" data-cities='<?php echo htmlentities(Utility::jencode($cities),ENT_QUOTES); ?>'><?php echo $v["name"]; ?></option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="formcon" id="cityCon">
                <div class="yuzde30"><?php echo __("admin/financial/tax-rates-th-city"); ?></div>
                <div class="yuzde70">
                    <select name="city_id" id="selectCity" style="display: none;">
                        <option value=""><?php echo ___("needs/select-your"); ?></option>
                        <option value="add-new-city"><?php echo __("admin/financial/add-new-city"); ?></option>
                    </select>
                    <div class="clear"></div>
                    <div id="DefineNewCity_con" style="display: none;">
                        <input type="text" name="city_name" value="" id="define_city" placeholder="<?php echo __("admin/financial/add-new-city-placeholder"); ?>">
                    </div>

                </div>
            </div>

            <div class="formcon">
                <div class="yuzde30"><?php echo __("admin/financial/tax-rate"); ?></div>
                <div class="yuzde70">
                    <input type="text" name="rate" value="" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57' style="width: 50px;">
                </div>
            </div>

            <div class="clear"></div>

            <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                <a class="yesilbtn gonderbtn" id="addNewTaxRuleForm_submit" href="javascript:void(0);"><?php echo ___("needs/button-create"); ?></a>
            </div>

        </form>

        <div class="clear"></div>
    </div>
</div>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1><strong><?php echo __("admin/financial/page-taxation"); ?></strong></h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div id="tab-tab">
                <ul class="tab">

                    <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'detail','tab')" data-tab="detail"> <?php echo __("admin/financial/tab-detail"); ?> </a></li>
                    <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'tax-rates','tab')" data-tab="tax-rates"> <?php echo __("admin/financial/tab-tax-rates"); ?></a></li>
                </ul>

                <div id="tab-detail" class="tabcontent">

                    <div class="adminpagecon">


                        <div class="green-info" style="margin-bottom:20px;">
                            <div class="padding15">
                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                                <p><?php echo __("admin/financial/taxation-desc"); ?></p>
                            </div>
                        </div>

                        <form action="<?php echo $links["controller"]; ?>" method="post" id="settingsForm">
                            <input type="hidden" name="operation" value="taxation_settings">

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/financial/taxation-status"); ?></div>
                                <div class="yuzde70">
                                    <input type="checkbox" class="sitemio-checkbox" id="taxation" name="status" value="1"<?php echo $settings["status"] ? ' checked' : NULL; ?>>
                                    <label class="sitemio-checkbox-label" for="taxation"></label>
                                    <span class="kinfo"><?php echo __("admin/financial/taxation-status-desc"); ?></span>
                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/financial/taxation-type"); ?></div>
                                <div class="yuzde70">
                                    <input<?php echo $settings["taxation-type"] == "exclusive" ? ' checked' : ''; ?> type="radio" name="taxation_type" value="exclusive" class="radio-custom" id="taxation_type_exclusive">
                                    <label class="radio-custom-label" for="taxation_type_exclusive" style="margin-bottom:10px;"><?php echo __("admin/financial/taxation-type-exclusive"); ?> <span class="kinfo"><?php echo __("admin/financial/taxation-type-exclusive-info"); ?></span></label>
                                    <div class="clear"></div>

                                    <input<?php echo $settings["taxation-type"] == "inclusive" ? ' checked' : ''; ?> type="radio" name="taxation_type" value="inclusive" class="radio-custom" id="taxation_type_inclusive">
                                    <label class="radio-custom-label" for="taxation_type_inclusive" style="margin-bottom:10px;"><?php echo __("admin/financial/taxation-type-inclusive"); ?> <span class="kinfo"><?php echo __("admin/financial/taxation-type-inclusive-info"); ?></span></label>
                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/financial/taxation-rate"); ?></div>
                                <div class="yuzde70">
                                    <input type="text" style="width:35px;" name="rate" value="<?php echo $settings["rate"]; ?>">
                                    <span class="kinfo"><?php echo __("admin/settings/taxation-rate-desc"); ?></span>
                                </div>
                            </div>

                            <?php
                                if(Config::get("general/country") == "tr"){
                                    ?>
                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/financial/send-bill-to-address-status"); ?></div>
                                        <div class="yuzde70">
                                            <input type="checkbox" onclick="if($(this).prop('checked')) $('#sebilltad_con').slideDown(); else $('#sebilltad_con').slideUp();" class="sitemio-checkbox" id="sebilltad_status" name="sebilltad_status" value="1"<?php echo $settings["sebilltad"]["status"] ? ' checked' : NULL; ?>>
                                            <label class="sitemio-checkbox-label" for="sebilltad_status"></label>
                                            <span class="kinfo"><?php echo __("admin/financial/send-bill-to-address-status-desc"); ?></span>

                                            <div class="formcon" id="sebilltad_con" style="<?php echo $settings["sebilltad"]["status"] ? ''  : 'display:none;'; ?>">
                                                <div class="yuzde30"><?php echo __("admin/financial/send-bill-to-address-amount"); ?></div>

                                                <input type="text" style="width:50px;" name="sebilltad_amount" value="<?php echo Money::formatter($settings["sebilltad"]["amount"],$settings["sebilltad"]["cid"]); ?>" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57'>


                                                <select style="width:150px;" name="sebilltad_cid">
                                                    <?php
                                                        if($currencies = Money::getCurrencies($settings["sebilltad"]["cid"])){
                                                            foreach($currencies AS $currency){
                                                                ?>
                                                                <option value="<?php echo $currency["id"]; ?>"<?php echo $currency["id"] == $settings["sebilltad"]["cid"] ? ' selected' : NULL; ?>><?php echo $currency["name"]." (".$currency["code"].")"; ?></option>
                                                                <?php
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                                <span class="kinfo"><?php echo __("admin/financial/send-bill-to-address-desc"); ?></span>
                                            </div>

                                        </div>
                                    </div>
                                    <?php
                                }
                            ?>


                            <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                                <a class="yesilbtn gonderbtn" id="settings_submit" href="javascript:void(0);"><?php echo __("admin/financial/save-settings"); ?></a>
                            </div>
                            <div class="clear"></div>


                        </form>
                    </div>

                </div>

                <div id="tab-tax-rates" class="tabcontent">

                    <div class="adminpagecon">
                        <div class="green-info" style="margin-bottom:20px;">
                            <div class="padding15">
                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                                <p><?php echo __("admin/financial/tax-rates-desc"); ?></p>
                            </div>
                        </div>

                        <div class="clear"></div>

                        <a onclick="new_tax_rule();" class="lbtn green" href="javascript:void 0;" style="margin-bottom:5px;">+ <?php echo __("admin/financial/button-add-new-tax-rate-rule"); ?></a>
                        <div class="clear"></div>

                        <form action="<?php echo $links["controller"]; ?>" method="post" id="taxRatesForm">
                            <input type="hidden" name="operation" value="update_tax_rates">

                            <table width="100%" id="list_table" class="table table-striped table-borderedx table-condensed nowrap">
                                <thead style="background:#ebebeb;">
                                <tr>
                                    <th align="center" style="opacity: 0;">#</th>
                                    <th align="left"><?php echo __("admin/financial/tax-rates-th-country"); ?></th>
                                    <th align="left"><?php echo __("admin/financial/tax-rates-th-city"); ?></th>
                                    <th data-orderable="false" align="center"><?php echo __("admin/financial/tax-rate"); ?></th>
                                    <th data-orderable="false" align="center">&nbsp;</th>
                                </tr>
                                </thead>
                                <tbody align="Center" style="border-top:none;">
                                <?php
                                    if(isset($countries) && $countries){
                                        $i=0;
                                        foreach($countries AS $k=>$row){
                                            $i+1;
                                            $cities = $get_primary_cities($row["id"]);
                                            ?>
                                            <tr>
                                                <td align="center"><?php echo $i; ?></td>
                                                <td align="left"><?php echo $row["name"]; ?></td>
                                                <td align="left"> - </td>
                                                <td align="center">
                                                    <input type="text" name="country_rates[<?php echo $row["id"]; ?>]" value="<?php echo $row["tax_rate"]; ?>" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57' style="width: 50px;">
                                                </td>
                                                <td align="center"></td>
                                            </tr>
                                            <?php

                                            if($cities && is_array($cities)){
                                                foreach($cities AS $k2=>$row2){
                                                    ?>
                                                    <tr>
                                                        <td align="center"><?php echo $i; ?></td>
                                                        <td align="left"><?php echo $row["name"]; ?></td>
                                                        <td align="left"><?php echo $row2["name"]; ?></td>
                                                        <td align="center">
                                                            <input type="text" name="city_rates[<?php echo $row["id"]; ?>][<?php echo $row2["id"]; ?>]" value="<?php echo $row2["tax_rate"]; ?>" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57' style="width: 50px;">
                                                        </td>
                                                        <td align="center">
                                                            <a class="sbtn red" href="javascript:void 0;" data-tooltip="<?php echo ___("needs/button-delete"); ?>" onclick="delete_tax_rule(this,<?php echo $row["id"]; ?>,<?php echo $row2["id"]; ?>);"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            }

                                        }
                                    }
                                ?>
                                </tbody>
                            </table>

                            <div class="clear"></div>

                            <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                                <a class="yesilbtn gonderbtn" id="taxRatesForm_submit" href="javascript:void(0);"><?php echo __("admin/financial/save-settings"); ?></a>
                            </div>

                        </form>

                    </div>

                </div>

            </div>



        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>