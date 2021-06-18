<!DOCTYPE html>
<html>
<head>
    <?php

        $invoice_modules_logos = Hook::run("InvoiceModulesLogos");

        $place_holder_amount = Money::formatter(1.11,Config::get("general/currency"));
        $place_holder_amount = str_replace("1","0",$place_holder_amount);

        $place_holder_amount_format = Money::formatter_symbol(1.11,Config::get("general/currency"));
        $place_holder_amount_format = str_replace("1","0",$place_holder_amount_format);

        $plugins    = [
            'select2',
            'Sortable'
        ];
        include __DIR__.DS."inc".DS."head.php";
    ?>
    <script type="text/javascript">
        $(document).ready(function(){

            $("#select-user").select2({
                placeholder: "<?php echo __("admin/invoices/create-select-user"); ?>",
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
                $("#addForm input[name=operation]").val("create");
                MioAjaxElement($(this),{
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                    result:"addForm_handler",
                });
            });

            $("#status-unpaid").prop("checked",true).trigger("change");

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

        var item_last_id = -1;

        $(document).ready(function(){

            var el = document.getElementById('items');
            var sortable = Sortable.create(el,{
                sort: true,
                animation: 150,
                draggable: ".middle",
                handle: ".bearer",
                forceFallback: true,
            });


            add_item();

            $("#items").on("click",".delete-item",function(){

                var index = $(this).data("index");

                if($("#items tr").length === 1){
                    return false;
                }
                $(this).parent().parent().remove();
                calculate();

            });

            $(".faturakalemleri").on("keyup change","input[data-calculate-amount=true]",calculate);
            $("#select-user").change(calculate);


        });

        function calculate(){
            $("#addForm input[name=operation]").val("calculate");
            var request = MioAjax({
                form:$("#addForm")
            },true,true);

            request.done(function(result){
                if(result != ''){
                    var solve = getJson(result);
                    if(solve !== false){
                        if(solve.status == "successful"){

                            var view_tax_rate = '<?php echo __("admin/invoices/create-tax"); ?>';
                            view_tax_rate = view_tax_rate.replace("{rate}",solve.tax_rate);

                            $("#get_tax_rate").html(view_tax_rate);
                            $("#subtotal_result").html(solve.subtotal);
                            $("#tax_result").html(solve.tax);
                            $("#total_result").html(solve.total);

                        }
                    }else
                        console.log(result);
                }
            });
        }

        function add_item(){
            var template = $("#template-item").html();
            var index    = item_last_id;
            if(index == -1)
                index = 0;
            else
                index+=1;

            item_last_id = index;

            template     = template.replace(/{index}/g,index);

            $("#items").append(template);
        }
    </script>
</head>
<body>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1><strong><?php echo __("admin/invoices/page-create"); ?></strong>
                    <?php
                        if($invoice_modules_logos){
                            foreach($invoice_modules_logos AS $logo){
                                if($logo){
                                    ?>
                                    <img style="width: 110px;height:auto;margin-left: 15px;display: inline-block;margin-bottom: -3px;" src="<?php echo $logo; ?>">
                                    <?php
                                }
                            }
                        }
                    ?>
                </h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="adminpagecon">

                <table style="display: none;">
                    <tbody id="template-item" style="display: none;">
                    <tr>
                        <td align="center">
                            -
                        </td>
                        <td align="center">
                            <input data-calculate-amount="true" type="checkbox" name="items[{index}][taxexempt]" class="checkbox-custom" id="tax-exempt-{index}" value="1">
                            <label class="checkbox-custom-label" for="tax-exempt-{index}"></label>
                        </td>
                        <td width="40%">
                            <input name="items[{index}][description]" type="text" value="">
                        </td>
                        <td width="20%" align="center">
                            <input style="text-align:center;" name="items[{index}][amount]" type="text" value="" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57' data-calculate-amount="true">
                        </td>
                        <td align="center">
                            <a href="javascript:void 0;" style="cursor: move;display: none;" class="lbtn bearer"><i class="fa fa-arrows-alt" aria-hidden="true"></i></a>
                            <a href="javascript:void 0;" class="lbtn red delete-item" data-index="{index}"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                    </tbody>
                </table>


                <form action="<?php echo $links["controller"]; ?>" method="post" id="addForm" enctype="multipart/form-data">
                    <input type="hidden" name="operation" value="create">

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/invoices/create-user"); ?></div>
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

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/invoices/create-status"); ?></div>
                        <div class="yuzde70">
                            <?php
                                foreach(__("admin/invoices/create-situations") AS $k=>$v){
                                    if($k != "waiting" && $k != "cancelled" && $k != "refund"){
                                        ?>
                                        <input id="status-<?php echo $k; ?>" class="radio-custom" name="status" onchange="change_status(this);" value="<?php echo $k; ?>" type="radio">
                                        <label style="margin-right:15px;" for="status-<?php echo $k; ?>" class="radio-custom-label"><span class="checktext"><?php echo $v; ?></span></label>
                                        <?php
                                    }
                                }
                            ?>

                            <script type="text/javascript">
                                function change_status(elem){
                                    $('.change-status-wrap').css("display","none");
                                    var status = elem.value;
                                    $(".is-"+status).each(function(){
                                        if($(this)[0].tagName === "TR")
                                            $(this).css("display","table-row");
                                        else
                                            $(this).css("display","block");
                                    });

                                    if(status == "paid"){
                                        $("input[name=datepaid]").val('<?php echo DateManager::format("Y-m-d"); ?>');
                                        $("input[name=timepaid]").val('<?php echo DateManager::format("H:i"); ?>');
                                    }else{
                                        $("input[name=taxed]").prop("checked",false);
                                        $("#taxed-status-no").prop("checked",true);

                                        $("input[name=datepaid]").val('');
                                        $("input[name=timepaid]").val('');
                                    }

                                    if(status == "refund"){
                                        $("input[name=refunddate]").val('<?php echo DateManager::format("Y-m-d"); ?>');
                                        $("input[name=refundtime]").val('<?php echo DateManager::format("H:i"); ?>');
                                    }else{
                                        $("input[name=refunddate]").val('');
                                        $("input[name=refundtime]").val('');
                                    }

                                }
                            </script>
                        </div>
                    </div>

                    <?php
                        if(Config::get("options/taxation")){
                            ?>
                            <div class="formcon change-status-wrap is-paid" style="display: none;">
                                <div class="yuzde30"><?php echo __("admin/invoices/create-taxed-status"); ?></div>
                                <div class="yuzde70">

                                    <input id="taxed-status-yes" class="radio-custom" name="taxed" onchange="change_taxed(this);" value="1" type="radio">
                                    <label style="margin-right:15px;" for="taxed-status-yes" class="radio-custom-label"><span class="checktext"><?php echo __("admin/invoices/create-taxed"); ?></span></label>

                                    <input checked id="taxed-status-no" class="radio-custom" name="taxed" onchange="change_taxed(this);" value="0" type="radio">
                                    <label style="margin-right:15px;" for="taxed-status-no" class="radio-custom-label"><span class="checktext"><?php echo __("admin/invoices/create-untaxed"); ?></span></label>

                                    <input id="taxed-status-free" class="radio-custom" name="taxed" onchange="change_taxed(this);" value="free" type="radio">
                                    <label style="margin-right:15px;" for="taxed-status-free" class="radio-custom-label"><span class="checktext"><?php echo __("admin/invoices/tax-free"); ?></span></label>

                                    <script type="text/javascript">
                                        function change_taxed(elem){
                                            $('.change-taxed-status-wrap').css("display","none");
                                            var status = elem.value;
                                            if(status == 1)
                                                $("#taxed-file-wrap").css("display","block");
                                            calculate();
                                        }
                                    </script>
                                    <div class="clear"></div>
                                    <div class="change-taxed-status-wrap" id="taxed-file-wrap" style="display: none;">
                                        <!--input type="file" name="taxed_file" class="width200"-->
                                    </div>

                                </div>
                            </div>
                            <?php
                        }
                    ?>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/invoices/create-cdate"); ?></div>
                        <div class="yuzde70">
                            <input type="date" name="cdate" class="width200" value="<?php echo DateManager::Now("Y-m-d"); ?>">
                            <input type="time" name="ctime" class="width200" value="<?php echo DateManager::Now("H:i"); ?>">
                        </div>
                    </div>

                    <div class="formcon change-status-wrap is-unpaid is-paid is-refund is-waiting" id="duedate-wrap" style="display: none;">
                        <div class="yuzde30"><?php echo __("admin/invoices/create-duedate"); ?></div>
                        <div class="yuzde70">
                            <input type="date" name="duedate" class="width200" value="<?php echo DateManager::Now("Y-m-d"); ?>">
                            <input type="time" name="duetime" class="width200" value="23:59">
                        </div>
                    </div>

                    <div class="formcon change-status-wrap is-paid is-refund is-waiting" id="datepaid-wrap" style="display: none;">
                        <div class="yuzde30"><?php echo __("admin/invoices/create-datepaid"); ?></div>
                        <div class="yuzde70">
                            <input type="date" name="datepaid" class="width200" value="">
                            <input type="time" name="timepaid" class="width200" value="">
                        </div>
                    </div>

                    <div class="formcon change-status-wrap is-refund" id="refunddate-wrap" style="display: none;">
                        <div class="yuzde30"><?php echo __("admin/invoices/create-refunddate"); ?></div>
                        <div class="yuzde70">
                            <input type="date" name="refunddate" class="width200">
                            <input type="time" name="refundtime" class="width200">
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/financial/taxation-type"); ?></div>
                        <div class="yuzde70">
                            <?php
                                echo __("admin/financial/taxation-type-".Invoices::getTaxationType());
                            ?>
                        </div>
                    </div>

                    <div class="formcon change-status-wrap is-paid is-refund is-waiting" id="pmethod-wrap" style="display: none;">
                        <div class="yuzde30"><?php echo __("admin/invoices/create-pmethod"); ?></div>
                        <div class="yuzde70">
                            <select name="pmethod" class="width200" onchange="change_pmethod(this);">
                                <option value="none"><?php echo ___("needs/none"); ?></option>
                                <?php
                                    if($pmethods){
                                        foreach($pmethods AS $k=>$v){
                                            ?><option value="<?php echo $k; ?>"><?php echo $v; ?></option><?php
                                        }
                                    }
                                ?>
                            </select>
                            <script type="text/javascript">
                                function change_pmethod(elem){
                                    calculate();

                                }
                            </script>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/invoices/create-currency"); ?></div>
                        <div class="yuzde70">
                            <select name="currency" style="width: 200px;" onchange="calculate();">
                                <?php
                                    foreach(Money::getCurrencies() AS $curr){
                                        ?>
                                        <option value="<?php echo $curr["id"]; ?>"><?php echo $curr["name"]." (".$curr["code"].")"; ?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </div>


                    <div class="faturakalemleri">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <thead>
                            <tr>
                            <tr>
                                <td align="center" bgcolor="#eee"><?php echo __("admin/invoices/select"); ?> <span data-balloon="<?php echo __("admin/invoices/select-desc"); ?>" data-balloon-pos="up"><i class="fa fa-question-circle-o"></i></span></td>
                                <td align="center" bgcolor="#eee"><?php echo __("admin/invoices/tax-exempt"); ?> <span data-balloon="<?php echo __("admin/invoices/tax-exempt-desc"); ?>" data-balloon-pos="up"><i class="fa fa-question-circle-o"></i></span></td>
                                <td width="40%" bgcolor="#eee"><?php echo __("admin/invoices/create-description"); ?></td>
                                <td width="20%" align="center" bgcolor="#eee"><?php echo __("admin/invoices/create-amount-info"); ?></td>
                                <td bgcolor="#eee" align="center"></td>
                            </tr>
                            </thead>
                            <tbody id="items">
                            </tbody>

                            <tbody>

                            <?php
                                if(Config::get("options/send-bill-to-address/status")){
                                    ?>
                                    <tr class="change-status-wrap is-paid is-refund is-waiting" id="sendbta-wrap" style="display: none;">
                                        <td colspan="3" align="right" bgcolor="#eee">
                                            <?php echo __("admin/invoices/create-sendbta"); ?>
                                        </td>
                                        <td align="center">
                                            <input class="yuzde20" style="width:100px;" name="sendbta" placeholder="<?php echo $place_holder_amount; ?>" type="text" value="" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57' data-calculate-amount="true">
                                        </td>
                                    </tr>
                                    <?php
                                }
                            ?>

                            <tr>
                                <td colspan="3" align="right" bgcolor="#eee">
                                    <a class="lbtn invoicesplitbtn" href="javascript:add_item(); void 0;"><i class="fa fa-plus" aria-hidden="true"></i></a>

                                    <?php echo __("admin/invoices/create-subtotal"); ?></td>
                                <td align="center"><h5 id="subtotal_result"><?php echo $place_holder_amount_format; ?></h5></td>
                            </tr>
                            <?php
                                if(Config::get("options/taxation")){
                                    ?>
                                    <tr>
                                        <td colspan="3" align="right" bgcolor="#eee" id="get_tax_rate"><?php echo __("admin/invoices/create-tax",['{rate}' => 0]); ?></td>
                                        <td align="center"><h5 id="tax_result"><?php echo $place_holder_amount_format; ?></h5></td>
                                    </tr>
                                    <?php
                                }
                            ?>
                            <tr>
                                <td colspan="3" align="right" bgcolor="#eee"><?php echo __("admin/invoices/create-total"); ?></td>
                                <td align="center"><h4 id="total_result"><?php echo $place_holder_amount_format; ?></h4></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>


                    <div class="sendinvoicenoti">
                        <input type="checkbox" name="notification" value="1" id="notification" class="checkbox-custom">
                        <label for="notification" class="checkbox-custom-label"><?php echo __("admin/invoices/send-notification"); ?></label>
                    </div>


                    <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                        <a class="yesilbtn gonderbtn" id="addForm_submit" href="javascript:void(0);"><?php echo __("admin/invoices/create-button"); ?></a>
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