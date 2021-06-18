<!DOCTYPE html>
<html>
<head>
    <?php
        $privOperation  = Admin::isPrivilege("PRODUCTS_OPERATION");
        $plugins        = ['jquery-ui','dataTables','select2'];
        include __DIR__.DS."inc".DS."head.php";
    ?>
    <script>
        var table;
        $(document).ready(function() {

            table = $('#datatable').DataTable({
                "columnDefs": [
                    {
                        "targets": [0],
                        "visible":false,
                        "searchable": false
                    },
                    {
                        "targets": [1,2,3,4],
                        orderable:false,
                    },
                ],
                //"aaSorting" : [[4, 'asc']],
                "lengthMenu": [
                    [10, 25, 50, -1], [10, 25, 50, "<?php echo ___("needs/allOf"); ?>"]
                ],
                paging: false,
                info: false,
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

            $("#AutomationSettings").on("click","#settingsForm_submit",function(){
                MioAjaxElement($(this),{
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                    result:"settingsForm_handler",
                });
            });

            $("#updateCosts").click(function(){
                MioAjaxElement($(this),{
                    form:$("#updateCosts_form"),
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                    result:"settingsForm_handler",
                });
            });

        });

        function settingsForm_handler(result){
            if(result != ''){
                var solve = getJson(result);
                if(solve !== false){
                    if(solve.status == "error"){
                        if(solve.for != undefined && solve.for != ''){
                            $("#settingsForm "+solve.for).focus();
                            $("#settingsForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                            $("#settingsForm "+solve.for).change(function(){
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

        function updateForm_handler(result){
            $('.unchecked-input').remove();
            if(result != ''){
                var solve = getJson(result);
                if(solve !== false){
                    if(solve.status == "error"){
                        if(solve.for != undefined && solve.for != ''){
                            $("#settingsForm "+solve.for).focus();
                            $("#settingsForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                            $("#settingsForm "+solve.for).change(function(){
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

        function updateProfitRates(){
            var prft_rate   = $("#profit-rate").val();
            if(prft_rate == '') prft_rate = 0;
            prft_rate       = parseInt(prft_rate);

            $("#datatable tbody tr").each(function(){
                var cost        = $(".cost-item",this).val();
                if(cost == '') cost = 0;
                cost            = cost.replace(/\,/g,".");
                cost            = parseFloat(cost);
                var price       = (cost * prft_rate) / 100 + cost;
                price           = price.toFixed(4);
                $(".amount-item",this).val(price);
            });

            var request = MioAjax({
                action:"<?php echo $links["controller"]; ?>",
                method:"POST",
                data:{
                    operation:"update_international_sms_automation_settings",
                    profit_rate:prft_rate,
                },
            },true,true);
        }
    </script>

</head>
<body>

<form id="updateCosts_form" action="<?php echo $links["controller"]; ?>" method="post"><input type="hidden" name="operation" value="update_international_sms_costs"></form>

<div id="AutomationSettings" data-izimodal-title="<?php echo __("admin/products/intl-sms-automation-settings-button"); ?>" style="display: none;">
    <div class="padding20">

        <form action="<?php echo $links["controller"]; ?>" method="post" id="settingsForm">
            <input type="hidden" name="operation" value="update_international_sms_automation_settings">

            <div class="formcon">
                <div class="yuzde40"><?php echo __("admin/products/domain-active-module"); ?></div>
                <div class="yuzde60">
                    <span><?php echo $settings["module"] == "none" ? ___("needs/none") : $settings["module"]; ?></span>
                    <a href="<?php echo  $links["modules-redirect"]; ?>" class="sbtn"><i class="fa fa-cog"></i></a>
                </div>
            </div>

            <div class="formcon">
                <div class="yuzde40"><?php echo __("admin/products/intl-sms-auto-update"); ?></div>
                <div class="yuzde60">
                    <input<?php echo $settings["cron"]["status"] ? ' checked' : ''; ?> type="checkbox" class="checkbox-custom" id="auto_update" name="auto_update" value="1">
                    <label style="font-size:13px;" class="checkbox-custom-label" for="auto_update"><br><?php echo __("admin/products/intl-sms-auto-update-desc"); ?></label>
                </div>
            </div>

            <div class="formcon">
                <div class="yuzde40"><?php echo __("admin/products/intl-sms-primary-currency"); ?></div>
                <div class="yuzde60">
                    <select name="primary-currency">
                        <option value=""><?php echo ___("needs/none"); ?></option>
                        <?php
                            foreach(Money::getCurrencies($settings["primary-currency"]) AS $currency){
                                ?>
                                <option<?php echo $currency["id"] == $settings["primary-currency"] ? ' selected' : ''; ?> value="<?php echo $currency["id"]; ?>"><?php echo $currency["name"]." (".$currency["code"].")"; ?></option>
                                <?php
                            }
                        ?>
                    </select>
                    <span class="kinfo"><?php echo __("admin/products/intl-sms-primary-currency-desc"); ?></span>
                </div>
            </div>


            <div style="float:right;" class="guncellebtn yuzde30"><a id="settingsForm_submit" href="javascript:void(0);" class="yesilbtn gonderbtn"><?php echo __("admin/products/save-button"); ?></a></div>

        </form>

        <div class="clear"></div>
    </div>
</div>


<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1>
                    <strong><?php echo __("admin/products/page-intl-sms"); ?></strong>
                    <a href="<?php echo $links["page-redirect"]; ?>" target="_blank" class="sbtn"><i class="fa fa-external-link" aria-hidden="true"></i></a>
                </h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>



            <a href="javascript:open_modal('AutomationSettings');void 0;" class="green lbtn"><i class="fa fa-cog"></i> <?php echo __("admin/products/intl-sms-automation-settings-button"); ?></a>

            <a href="<?php echo $links["settings"]; ?>" class="lbtn"><i class="fa fa-cog"></i> <?php echo __("admin/products/category-group-settings-button"); ?></a>

            <a href="javascript:void(0);" id="updateCosts" class="blue lbtn"><i class="fa fa-refresh"></i> <?php echo __("admin/products/intl-sms-update-costs-button"); ?></a>

            <div class="domainpricingsetting" style="float:right;">
                <strong><?php echo __("admin/products/update-all-of-profit-rates"); ?></strong> <input style="width:100px;" name="profit-rate" id="profit-rate" type="text" placeholder="<?php echo __("admin/products/update-all-of-profit-rates-label"); ?>" onkeypress="return event.charCode>= 48 && event.charCode<= 57" value="<?php echo $settings["profit-rate"]; ?>"> <a href="javascript:updateProfitRates();void 0;" class="blue lbtn"><?php echo __("admin/products/update-button"); ?></a>
            </div>


            <div class="clear"></div>

            <div class="line"></div>

            <form action="<?php echo $links["controller"]; ?>" method="post" id="updateForm">
                <input type="hidden" name="operation" value="update_international_sms">

                <div class="domainpricinglist">

                    <table width="100%" id="datatable" class="table table-striped table-borderedx table-condensed nowrap">
                        <thead style="background:#ebebeb;">
                        <tr>
                            <th align="left">#</th>
                            <th align="left"><?php echo __("admin/products/intl-sms-country-name"); ?></th>
                            <th align="center"><?php echo __("admin/products/intl-sms-cost"); ?></th>
                            <th align="center"><?php echo __("admin/products/intl-sms-amount"); ?></th>
                            <th align="center"><?php echo __("admin/products/intl-sms-status"); ?></th>
                        </tr>
                        </thead>
                        <tbody align="center" style="border-top:none;">
                        <?php
                            if($list){
                                $i=0;
                                foreach($list AS $k=>$row){
                                    if(!isset($row["name"])) continue;
                                    $i++;
                                    $status = isset($row["status"]) ? $row["status"] : true;
                                    ?>
                                    <tr>
                                        <td align="left"><?php echo $i; ?></td>
                                        <td align="left"><?php echo $row["name"]; ?></td>

                                        <td align="center">
                                            <input class="cost-item" name="values[<?php echo $k;?>][cost]" type="text" placeholder="<?php echo __("admin/products/intl-sms-cost-placeholder"); ?>" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57' value="<?php echo isset($row["cost"]) ? Money::formatter($row["cost"],$row["cid"]) : ''; ?>">
                                            <select name="values[<?php echo $k; ?>][cid]">
                                                <?php
                                                    foreach(Money::getCurrencies() AS $currency){
                                                        ?>
                                                        <option<?php echo $currency["id"] == $row["cid"] ? ' selected' : ''; ?> value="<?php echo $currency["id"]; ?>"><?php echo $currency["name"]." (".$currency["code"].")"; ?></option>
                                                        <?php
                                                    }
                                                ?>
                                            </select>
                                        </td>
                                        <td align="center">
                                            <input class="amount-item" name="values[<?php echo $k; ?>][amount]" type="text" placeholder="<?php echo __("admin/products/intl-sms-amount-placeholder"); ?>" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57' value="<?php echo $row["amount"] ? Money::formatter($row["amount"],$row["cid"]) : ''; ?>">
                                        </td>
                                        <td align="center">
                                            <input<?php echo $status ? ' checked' : ''; ?> type="checkbox" class="sitemio-checkbox" id="country-<?php echo $k; ?>-status" name="values[<?php echo $k; ?>][status]" value="1">
                                            <label for="country-<?php echo $k; ?>-status" style="float:none;display:inline-block;" class="sitemio-checkbox-label"></label>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                        ?>
                        </tbody>
                    </table>
                    <br>

                    <div style="float:right;" class="guncellebtn yuzde30"><a id="updateForm_submit" href="javascript:void(0);" class="yesilbtn gonderbtn"><?php echo __("admin/products/intl-sms-update-button"); ?></a></div>
                </div>
            </form>

            <div class="clear"></div>
        </div>


    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>