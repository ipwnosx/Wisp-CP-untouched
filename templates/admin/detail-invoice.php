<!DOCTYPE html>
<html>
<head>
    <?php
        $invoice_modules_logos = Hook::run("InvoiceModulesLogos");

        $place_holder_amount = Money::formatter(1.11,Config::get("general/currency"));
        $place_holder_amount = str_replace("1","0",$place_holder_amount);

        $place_holder_amount_format = Money::formatter_symbol(1.11,Config::get("general/currency"));
        $place_holder_amount_format = str_replace("1","0",$place_holder_amount_format);

        $sendbta_amount = $invoice["sendbta_amount"];
        if($invoice["taxation_type"] == "inclusive")
            $sendbta_amount -= Money::get_exclusive_tax_amount($sendbta_amount,$invoice["currency"]);


        $user_id    = $user_info["id"];
        $user_name  = $user_info["full_name"];
        if($user_info["company_name"]) $user_name = "<strong>".$user_name."</strong> (".$user_info["company_name"].")";


        $total_discounts_amount = 0;
        $discounts              = $invoice["discounts"] ? Utility::jdecode($invoice["discounts"],true) : [];
        $is_discount            = isset($discounts["items"]) && $discounts["items"];


        $plugins    = [
            'select2',
            'intlTelInput',
            'Sortable',
        ];
        include __DIR__.DS."inc".DS."head.php";
    ?>
    <script type="text/javascript">
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
                        setTimeout(function(){
                            window.location.href = solve.redirect;
                        },2000);
                    }
                }else
                    console.log(result);
            }
        }

        function calculate(){
            $("#editForm input[name=operation]").val("calculate");
            var request = MioAjax({
                form:$("#editForm")
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
                            $("#discount_result").html("-"+solve.discount);
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

        function remind_invoice(el){
            var bfr_el = $(el).html();

            $(el).html('<i class="fa fa-spinner" style="-webkit-animation:fa-spin 2s infinite linear;animation: fa-spin 2s infinite linear;"></i>');

            var request = MioAjax({
                action:"<?php echo $links["controller"]; ?>",
                method:"POST",
                data:{
                    operation:"apply_operation",
                    type:"remind",
                    id:<?php echo $invoice["id"]; ?>,
                    from:"detail",
                },
            },true,true);

            request.done(function(result){
                $(el).html(bfr_el);
                if(result != ''){
                    var solve = getJson(result);
                    if(solve !== false){
                        if(solve.status == "successful"){
                            alert_success(solve.message,{timer:3000});
                        }else
                            alert_error(solve.message,{timer:5000});
                    }else
                        console.log(result);
                }
            });

        }

        var item_last_id = -1;

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

            $("#editForm_submit").on("click",function(){
                $("#editForm input[name=operation]").val("edit_detail");
                MioAjaxElement($(this),{
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                    result:"editForm_handler",
                });
            });

            $("#split_submit").on("click",function(){
                $("#editForm input[name=operation]").val("split_selected_items");
                MioAjaxElement($(this),{
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                    result:"editForm_handler",
                });
            });

            var el = document.getElementById('items');
            var sortable = Sortable.create(el,{
                sort: true,
                animation: 150,
                draggable: "tr",
                handle: ".bearer",
                forceFallback: true,
            });

            $("#items").on("click",".delete-item",function(){

                var index = $(this).data("index");

                if($("#items tr").length === 1){
                    $(".select-item").prop('checked',false).trigger('change');
                    return false;
                }
                $(this).parent().parent().remove();

                if($("#items tr").length === 1) $(".select-item").prop('checked',false).trigger('change');

                calculate();

            });

            $(".select-item").change(function(){
                var selected_count      = $(".select-item:checked").length;
                var unselected_count    = $(".select-item").not(":checked").length;
                if(unselected_count === 0) $(this).prop('checked',false);
                selected_count          = $(".select-item:checked").length;

                if(selected_count > 0)
                    $("#split_submit").css("display","inline-block");
                else
                    $("#split_submit").css("display","none");

            });

            $(".faturakalemleri").on("keyup change","input[data-calculate-amount=true]",calculate);
            $("input[data-calculate-amount=true]").on("keyup",calculate);


            var tab = _GET("tab");
            if (tab != '' && tab != undefined) {
                $("#tab-tab .tablinks[data-tab='" + tab + "']").click();
            } else {
                $("#tab-tab .tablinks:eq(0)").addClass("active");
                $("#tab-tab .tabcontent:eq(0)").css("display", "block");
            }

            $("#status-<?php echo $invoice["status"]; ?>").prop("checked",true).trigger("change");
            var taxed   = <?php echo $invoice["taxed"] ? 1 : 0; ?>;
            var pmethod = "<?php echo $invoice["pmethod"]; ?>";
            var legal   = <?php echo $invoice["legal"]; ?>;

            if(legal){
                if(taxed) $("#taxed-status-yes").prop("checked",true).trigger("change");
                else $("#taxed-status-no").prop("checked",true).trigger("change");
            }
            else{
                $("#taxed-status-free").prop("checked",true).trigger("change");
            }

            $("select[name=pmethod] option[value='"+pmethod+"']").attr("selected",true).trigger("change");

            $("input[name=cdate]").val('<?php echo substr($invoice["cdate"],0,4) == "1881" ? '' : DateManager::format("Y-m-d",$invoice["cdate"]); ?>');
            $("input[name=duedate]").val('<?php echo substr($invoice["duedate"],0,4) == "1881" ? '' : DateManager::format("Y-m-d",$invoice["duedate"]); ?>');
            $("input[name=duetime]").val('<?php echo substr($invoice["duedate"],0,4) == "1881" ? '' : DateManager::format("H:i",$invoice["duedate"]); ?>');
            $("input[name=datepaid]").val('<?php echo substr($invoice["datepaid"],0,4) == "1881" ? '' : DateManager::format("Y-m-d",$invoice["datepaid"]); ?>');
            $("input[name=refunddate]").val('<?php echo substr($invoice["refunddate"],0,4) == "1881" ? '' : DateManager::format("Y-m-d",$invoice["refunddate"]); ?>');

            $("input[name=ctime]").val('<?php echo substr($invoice["cdate"],0,4) == "1881" ? '' : DateManager::format("H:i",$invoice["cdate"]); ?>');
            $("input[name=timepaid]").val('<?php echo substr($invoice["datepaid"],0,4) == "1881" ? '' : DateManager::format("H:i",$invoice["datepaid"]); ?>');
            $("input[name=refundtime]").val('<?php echo substr($invoice["refunddate"],0,4) == "1881" ? '' : DateManager::format("H:i",$invoice["refunddate"]); ?>');

            $("input[name=sendbta]").val('<?php echo $invoice["sendbta"] && $invoice["sendbta_amount"]>0 ? Money::formatter($invoice["sendbta_amount"],$invoice["currency"]) : ''; ?>');

            <?php if($invoice["pmethod_commission"]>0): ?>
            $("#pmethod_commission_wrap").css("display","block");
            $("input[name=pmethod_commission]").val('<?php echo $invoice["pmethod_commission"]>0 ? Money::formatter($invoice["pmethod_commission"],$invoice["currency"]) : ''; ?>');
            <?php endif; ?>


        });
    </script>
</head>
<body>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1><strong><?php echo __("admin/invoices/page-detail",['{id}' => $num]); ?></strong>

                   <a id="inoivedetailheadbtn" target="_blank" class="sbtn tooltip-right" href="<?php echo $links["share"]; ?>" data-tooltip="<?php echo __("admin/invoices/preview-button"); ?>"><i class="fa fa-search" aria-hidden="true"></i></a>
                    <?php
                        if($invoice["status"] == "unpaid"){
                            ?>
                            <a id="inoivedetailheadbtn" class="sbtn tooltip-right" href="javascript: void 0;" onclick="remind_invoice(this);" data-tooltip="<?php echo __("admin/invoices/remind-button"); ?>"><i class="fa fa-paper-plane" aria-hidden="true"></i></a>
                            <?php
                        }
                    ?>

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

            <div id="tab-tab"><!-- tab wrap content start -->

                <ul class="tab">
                    <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'detail','tab')" data-tab="detail"> <i class="fa fa-info" aria-hidden="true"></i> <?php echo __("admin/invoices/tab-detail"); ?></a></li>

                    <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'informations','tab')" data-tab="informations"><i class="fa fa-address-card" aria-hidden="true"></i> <?php echo __("admin/invoices/tab-informations"); ?></a></li>
                </ul>

                <div id="tab-detail" class="tabcontent"><!-- tab content 1 start -->
                    <div class="adminpagecon">
                        <table style="display: none;">
                            <tbody id="template-item" style="display: none;">
                            <tr>
                                <td>-</td>
                                <td align="center">
                                    <input data-calculate-amount="true" type="checkbox" name="items[{index}][taxexempt]" class="checkbox-custom" id="tax-exempt-{index}" value="1">
                                    <label class="checkbox-custom-label" for="tax-exempt-{index}"></label>
                                </td>
                                <td width="40%">
                                    <input name="items[{index}][description]" type="text" value="">
                                </td>
                                <td>-</td>
                                <td width="20%" align="center">
                                    <input style="text-align:center;" name="items[{index}][amount]" type="text" value="" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57' data-calculate-amount="true">
                                </td>
                                <td align="center">
                                    <a href="javascript:void 0;" style="cursor: move; display: none;" class="lbtn bearer"><i class="fa fa-arrows-alt" aria-hidden="true"></i></a>
                                    <a href="javascript:void 0;" class="lbtn red delete-item" data-index="{index}"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                            </tbody>
                        </table>


                        <form action="<?php echo $links["controller"]; ?>" method="post" id="editForm" enctype="multipart/form-data">
                            <input type="hidden" name="operation" value="edit_detail">

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/invoices/create-user"); ?></div>
                                <div class="yuzde70">
                                    <?php
                                        if($user){
                                            ?>
                                            <a href="<?php echo $links["user"]; ?>"><?php echo $user_name; ?></a>
                                            <?php
                                        }else{
                                            ?>
                                            <strong><?php echo ___("needs/deleted"); ?></strong>
                                            <?php
                                        }
                                    ?>
                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/invoices/create-status"); ?></div>
                                <div class="yuzde70">
                                    <?php
                                        foreach(__("admin/invoices/create-situations") AS $k=>$v){
                                            if($k != "waiting" || ($k == "waiting" && $invoice["status"] == "waiting")){
                                                if($k == "unpaid" && $invoice["taxed"]) continue;
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
                                            }else if(status != "refund" && status != "cancelled"){
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

                            <div class="<?php echo Config::get("options/taxation") ? 'formcon change-status-wrap is-paid' : ''; ?>" id="taxed_wrap<?php echo Config::get("options/taxation") ? '' : 'x'; ?>" style="display: none;">
                                <div class="yuzde30"><?php echo __("admin/invoices/create-taxed-status"); ?></div>
                                <div class="yuzde70">

                                    <input id="taxed-status-yes" class="radio-custom" name="taxed" onchange="change_taxed(this);" value="1" type="radio">
                                    <label style="margin-right:15px;" for="taxed-status-yes" class="radio-custom-label"><span class="checktext"><?php echo __("admin/invoices/create-taxed"); ?></span></label>

                                    <input id="taxed-status-no" class="radio-custom" name="taxed" onchange="change_taxed(this);" value="0" type="radio">
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

                                        function delete_taxed_file(){
                                            $("#taxed-file").val('');
                                            $("#taxed-file-operation").css("display","none");
                                            $("#taxed-file-download").remove();

                                            var request = MioAjax({
                                                action:"<?php echo $links["controller"]; ?>",
                                                method:"POST",
                                                data:{
                                                    operation:"delete_taxed_file",
                                                }
                                            },true,true);

                                            request.done(function(result){
                                                if(result != ''){
                                                    var solve = getJson(result);
                                                    if(solve !== false){
                                                        if(solve.status == "successful"){
                                                            alert_success(solve.message,{timer:2000});
                                                        }
                                                    }else
                                                        console.log(result);
                                                }
                                            });
                                        }
                                    </script>
                                    <div class="clear"></div>
                                    <div class="change-taxed-status-wrap" id="taxed-file-wrap" style="display: none;">
                                        <input type="file" id="taxed-file" name="taxed_file" class="width200" style="display:inline-block" onchange="if($(this).val() == '') $('#taxed-file-operation').hide(1); else $('#taxed-file-operation').show(1); ">
                                        <div class="width200" id="taxed-file-operation"  style="display:inline-block;<?php echo isset($taxed_file) && $taxed_file ? '' : 'display: none;'; ?>">
                                            <a class="red sbtn" href="javascript:delete_taxed_file();void 0;"><i class="fa fa-trash"></i></a>
                                            <?php if(isset($taxed_file) && $taxed_file): ?>
                                                <a href="<?php echo $taxed_file; ?>" target="_blank" class="blue sbtn"><i class="fa fa-download"></i></a>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/invoices/create-cdate"); ?></div>
                                <div class="yuzde70">
                                    <input type="date" name="cdate" class="width200">
                                    <input type="time" name="ctime" class="width200">
                                </div>
                            </div>

                            <div class="formcon change-status-wrap is-unpaid is-paid is-refund is-waiting is-cancelled" id="duedate-wrap" style="display: none;">
                                <div class="yuzde30"><?php echo __("admin/invoices/create-duedate"); ?></div>
                                <div class="yuzde70">
                                    <input type="date" name="duedate" class="width200">
                                    <input type="time" name="duetime" class="width200">
                                </div>
                            </div>

                            <div class="formcon change-status-wrap is-paid is-refund is-waiting is-cancelled" id="datepaid-wrap" style="display: none;">
                                <div class="yuzde30"><?php echo __("admin/invoices/create-datepaid"); ?></div>
                                <div class="yuzde70">
                                    <input type="date" name="datepaid" class="width200">
                                    <input type="time" name="timepaid" class="width200">
                                </div>
                            </div>

                            <div class="formcon change-status-wrap is-refund" id="refunddate-wrap" style="display: none;">
                                <div class="yuzde30"><?php echo __("admin/invoices/create-refunddate"); ?></div>
                                <div class="yuzde70">
                                    <input type="date" name="refunddate" class="width200">
                                    <input type="time" name="refundtime" class="width200">
                                </div>
                            </div>

                            <div class="formcon change-status-wrap is-paid is-refund is-waiting is-cancelled" id="pmethod-wrap" style="display: none;">
                                <div class="yuzde30"><?php echo __("admin/invoices/create-pmethod"); ?></div>
                                <div class="yuzde70">
                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/invoices/payment-type"); ?></div>
                                        <select name="pmethod" class="width200" onchange="change_pmethod(this);">
                                            <option value="none"><?php echo ___("needs/none"); ?></option>
                                            <?php
                                                if($pmethods){
                                                    foreach($pmethods AS $k=>$v){
                                                        ?><option<?php #echo $k == $invoice["pmethod"] ? ' selected' : ''; ?> value="<?php echo $k; ?>"><?php echo $v; ?></option><?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                        <script type="text/javascript">
                                            function change_pmethod(elem){
                                                var value = elem.value;
                                                calculate();
                                            }
                                        </script>
                                    </div>

                                    <?php
                                        if(isset($payment_transaction_id) && $payment_transaction_id){
                                            ?>
                                            <div class="formcon">
                                                <div class="yuzde30"><?php echo __("admin/invoices/detail-transaction-id"); ?></div>
                                                <div class="yuzde70">
                                                    <?php echo $payment_transaction_id; ?>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    ?>

                                    <?php
                                        if(isset($stored_card_ln4) && $stored_card_ln4){
                                            ?>
                                            <div class="formcon">
                                                <?php echo __("admin/invoices/paid-by-credit-card-".$is_auto_pay,['{ln4}' => $stored_card_ln4]); ?>
                                            </div>
                                            <?php
                                        }
                                    ?>

                                    <?php
                                        if(isset($support_refund) && $support_refund){
                                            ?>
                                            <div class="formcon change-status-wrap is-refund">
                                                <input checked type="checkbox" id="refund_via_module" name="refund_via_module" class="checkbox-custom" value="1">
                                                <label class="checkbox-custom-label" for="refund_via_module"><?php echo __("admin/invoices/refund-via-module"); ?></label>
                                            </div>
                                            <?php
                                        }
                                    ?>

                                    <?php if($invoice["status"] != "unpaid" && isset($banktransfer_info) && $banktransfer_info): ?>

                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/invoices/detail-banktfr-bank-name"); ?></div>
                                            <div class="yuzde70">
                                                <input type="text" name="pmethod_msg[bank_name]" value="<?php echo $banktransfer_info["bank_name"]; ?>">
                                            </div>
                                        </div>

                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/invoices/detail-banktfr-sender-name"); ?></div>
                                            <div class="yuzde70">
                                                <input type="text" name="pmethod_msg[sender_name]" value="<?php echo $banktransfer_info["sender_name"]; ?>">
                                            </div>
                                        </div>

                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/invoices/detail-banktfr-rce"); ?></div>
                                            <div class="yuzde70">
                                                <input type="text" name="pmethod_msg[rce]" value="<?php echo $banktransfer_info["rce"]; ?>">
                                            </div>
                                        </div>
                                        <?php
                                        if(isset($banktransfer_info["bulk_payment"])){
                                            ?>
                                            <div class="blue-info">
                                                <div class="padding15">
                                                    <i class="fa fa-info-circle"></i>
                                                    <p><?php echo __("admin/invoices/detail-banktfr-bulk-payment-info",[
                                                            '{amount}' => Money::formatter_symbol($banktransfer_info["payable_amount"],$banktransfer_info["payable_amount_cid"]),
                                                        ]); ?></p>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>

                                    <?php endif; ?>

                                    <?php
                                        if($invoice["pmethod"] != "BankTransfer" && ($invoice["status"] == "unpaid" || $invoice["status"] == "waiting")){
                                            $pmethod_msg = $invoice["pmethod_msg"];
                                            $pmethod_msg_ar = Utility::jdecode($pmethod_msg,true);
                                            if(!$pmethod_msg_ar && $pmethod_msg){
                                                ?><div class="red-info">
                                                <div class="padding10">
                                                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                                    <?php echo __("admin/invoices/pay-error"); ?>
                                                    <br>
                                                    <?php echo $pmethod_msg; ?>

                                                </div></div><?php
                                            }
                                        }
                                    ?>


                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/financial/taxation-type"); ?></div>
                                <div class="yuzde70">
                                    <?php
                                        echo __("admin/financial/taxation-type-".$invoice["taxation_type"]);
                                    ?>
                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/invoices/create-currency"); ?></div>
                                <div class="yuzde70">
                                    <select name="currency" style="width: 200px;" onchange="calculate();">
                                        <?php
                                            foreach(Money::getCurrencies() AS $curr){
                                                ?>
                                                <option<?php echo $invoice["currency"] == $curr["id"] ? ' selected' : ''; ?> value="<?php echo $curr["id"]; ?>"><?php echo $curr["name"]." (".$curr["code"].")"; ?></option>
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
                                        <td align="center" bgcolor="#eee"><?php echo __("admin/invoices/select"); ?> <span data-balloon="<?php echo __("admin/invoices/select-desc"); ?>" data-balloon-pos="up"><i class="fa fa-question-circle-o"></i></span></td>
                                        <td align="center" bgcolor="#eee"><?php echo __("admin/invoices/tax-exempt"); ?> <span data-balloon="<?php echo __("admin/invoices/tax-exempt-desc"); ?>" data-balloon-pos="up"><i class="fa fa-question-circle-o"></i></span></td>
                                        <td width="40%" bgcolor="#eee"><?php echo __("admin/invoices/create-description"); ?></td>
                                        <td align="center" bgcolor="#eee"><?php echo __("admin/invoices/create-discount"); ?></td>
                                        <td width="20%" align="center" bgcolor="#eee"><?php echo __("admin/invoices/create-amount-info"); ?></td>
                                        <td bgcolor="#eee" align="center"></td>
                                    </tr>
                                    </thead>
                                    <tbody id="items">
                                    <?php
                                        foreach($items AS $k => $item){
                                            if($invoice["taxation_type"] == "inclusive" && !$item["taxexempt"])
                                                $item["total_amount"] += Money::get_exclusive_tax_amount($item["total_amount"],$invoice["taxrate"]);
                                            ?>
                                            <tr>
                                                <td align="center">
                                                    <?php
                                                        if($invoice["status"] == "unpaid")
                                                        {
                                                            ?>
                                                            <input name="selected[]" type="checkbox" class="checkbox-custom select-item" id="selected-<?php echo $item["id"]; ?>" value="<?php echo $item["id"]; ?>">
                                                            <label class="checkbox-custom-label" for="selected-<?php echo $item["id"]; ?>"></label>
                                                            <?php
                                                        }
                                                        else
                                                            echo "-";
                                                    ?>
                                                </td>

                                                <td align="center">
                                                    <input data-calculate-amount="true" type="checkbox" name="items[<?php echo $item["id"]; ?>][taxexempt]" class="checkbox-custom" id="tax-exempt-<?php echo $item["id"]; ?>" value="1"<?php echo $item["taxexempt"] ? ' checked' : ''; ?>>
                                                    <label class="checkbox-custom-label" for="tax-exempt-<?php echo $item["id"]; ?>"></label>
                                                </td>
                                                <td width="40%">
                                                    <?php
                                                        if(isset($item["options"]["addons"]) && $item["options"]["addons"]){
                                                            ?>
                                                            <textarea style="height:35px;" name="items[<?php echo $item["id"]; ?>][description]" ><?php echo $item["description"]; ?></textarea>
                                                            <?php
                                                        }
                                                        else{
                                                            ?>
                                                            <input name="items[<?php echo $item["id"]; ?>][description]" type="text" value="<?php echo htmlentities($item["description"],ENT_QUOTES); ?>">
                                                            <?php
                                                        }
                                                    ?>
                                                </td>

                                                <td align="center">
                                                    <?php
                                                        if($is_discount)
                                                        {
                                                            ?>
                                                            <?php
                                                            $d_v = false;
                                                            foreach($discounts["items"] AS $d_type => $d_vs)
                                                            {
                                                                foreach($d_vs AS $v_k => $v)
                                                                {
                                                                    if($v_k != $item["id"]) continue;
                                                                    unset($discounts[$d_type][$item["id"]]);
                                                                    $d_v = true;
                                                                    $total_discounts_amount += $v["amountd"];
                                                                    ?>
                                                                    <div class="formcon">
                                                                        <span class="kinfo"><?php echo $v["name"].(isset($v["rate"]) && $v["rate"] > 0.00 ? " - %".$v["rate"] : ''); ?></span>
                                                                        <input style="width:100px;" name="discounts[<?php echo $d_type; ?>][<?php echo $v_k; ?>]" placeholder="<?php echo $place_holder_amount; ?>" type="text" value="<?php echo Money::formatter($v["amountd"],$invoice["currency"]); ?>" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57' data-calculate-amount="true">
                                                                    </div>
                                                                    <?php
                                                                }
                                                            }
                                                            if(!$d_v) echo "-";
                                                            ?>
                                                            <?php
                                                        }else
                                                            echo "-";
                                                    ?>
                                                </td>

                                                <td width="20%" align="center">
                                                    <input style="text-align:center;" name="items[<?php echo $item["id"]; ?>][amount]" type="text" value="<?php echo Money::formatter($item["total_amount"],$item["currency"],false,$invoice["currency"]); ?>" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57' data-calculate-amount="true">
                                                </td>
                                                <td align="center">
                                                    <a href="javascript:void 0;" style="cursor: move; display: none;" class="lbtn bearer"><i class="fa fa-arrows-alt" aria-hidden="true"></i></a>
                                                    <a href="javascript:void 0;" class="lbtn red delete-item" data-index="<?php echo $item["id"]; ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                            <?php

                                        }
                                    ?>
                                    </tbody>

                                    <tbody>

                                    <?php
                                        if(Config::get("options/send-bill-to-address/status") || $invoice["sendbta_amount"]>0){
                                            if($invoice["taxation_type"] == "inclusive" && $invoice["taxrate"] > 0)
                                                $invoice["sendbta_amount"] += Money::get_exclusive_tax_amount($invoice["sendbta_amount"],$invoice["taxrate"]);
                                            ?>
                                            <tr class="change-status-wrap is-paid is-refund is-waiting" id="sendbta-wrap" style="display: none;">
                                                <td colspan="4" align="right" bgcolor="#eee">
                                                    <?php echo __("admin/invoices/create-sendbta"); ?>
                                                </td>
                                                <td align="center">
                                                    <input class="yuzde20" style="width:100px;" name="sendbta" placeholder="<?php echo $place_holder_amount; ?>" type="text" value="<?php echo $invoice["sendbta"] && $sendbta_amount>0 ? Money::formatter($sendbta_amount,$invoice["currency"]) : ''; ?>" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57' data-calculate-amount="true">
                                                </td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <?php
                                        }
                                    ?>

                                    <tr id="pmethod-commission-wrap" style="<?php echo $invoice["pmethod_commission"]>0 ? '' : 'display: none;'; ?>">
                                        <td colspan="4" align="right" bgcolor="#eee">
                                            <?php echo __("admin/invoices/create-pmethod-comn"); ?>
                                        </td>
                                        <td align="center">
                                            <input class="yuzde20" style="width:100px;" name="pmethod_commission" placeholder="<?php echo $place_holder_amount; ?>" type="text" value="<?php echo $invoice["pmethod_commission"]>0 ? Money::formatter($invoice["pmethod_commission"],$invoice["currency"]) : ''; ?>" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57' data-calculate-amount="true">
                                        </td>
                                        <td>&nbsp;</td>
                                    </tr>


                                    <tr>
                                        <td colspan="4" align="right" bgcolor="#eee">
                                            <a class="lbtn invoicesplitbtn" href="javascript:add_item(); void 0;"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                            <a style="display: none;" class="lbtn invoicesplitbtn" id="split_submit" href="javascript:void(0);"><?php echo __("admin/invoices/split"); ?></a>


                                            <?php echo __("admin/invoices/create-subtotal"); ?></td>
                                        <td align="center"><h5 id="subtotal_result"><?php echo $place_holder_amount_format; ?></h5></td>
                                        <td>&nbsp;</td>
                                    </tr>

                                    <?php
                                        if($total_discounts_amount > 0.00)
                                        {
                                            ?>
                                            <tr>
                                                <td colspan="4" align="right" bgcolor="#eee">
                                                    <?php echo __("admin/invoices/create-total-discount"); ?></td>
                                                <td align="center"><h5 id="discount_result">-<?php echo Money::formatter_symbol($total_discounts_amount,$invoice["currency"]); ?></h5></td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <?php
                                        }
                                        elseif(isset($discounts["items"]) && $discounts["items"]){
                                            foreach($discounts["items"] AS $d_type => $d_vs)
                                            {
                                                foreach($d_vs AS $d_k => $d_v)
                                                {
                                                    $name   = $d_v["name"];
                                                    if(isset($d_v["rate"]) && $d_v["rate"] > 0.00)
                                                        $name .= " - %".$d_v["rate"];

                                                    ?>
                                                    <tr>
                                                        <td colspan="4" align="right" bgcolor="#eee">
                                                            <?php echo $name; ?>
                                                        </td>
                                                        <td align="center">
                                                            <input class="yuzde20" style="width:100px;" name="discounts[<?php echo $d_type; ?>][<?php echo $d_k; ?>]" placeholder="<?php echo $place_holder_amount; ?>" type="text" value="<?php echo Money::formatter($d_v["amountd"],$invoice["currency"]); ?>" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57' data-calculate-amount="true">
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                        }
                                    ?>

                                    <?php
                                        if(Config::get("options/taxation") || (!Config::get("options/taxation") && $invoice["status"] !== "unpaid" && $invoice["tax"]>0)){
                                            ?>
                                            <tr>
                                                <td colspan="4" align="right" bgcolor="#eee" id="get_tax_rate"><?php echo __("admin/invoices/create-tax",['{rate}' => $invoice["taxrate"]]); ?></td>
                                                <td align="center"><h5 id="tax_result"><?php echo $place_holder_amount_format; ?></h5></td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <?php
                                        }
                                    ?>
                                    <tr>
                                        <td colspan="4" align="right" bgcolor="#eee"><?php echo __("admin/invoices/create-total"); ?></td>
                                        <td align="center"><h4 id="total_result"><?php echo $place_holder_amount_format; ?></h4></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>



                            <div class="sendinvoicenoti">
                                <input type="checkbox" name="notification" value="1" id="notification" class="checkbox-custom">
                                <label for="notification" class="checkbox-custom-label"><?php echo __("admin/invoices/send-notification"); ?></label>
                            </div>

                            <div style="float:left;margin-top:10px;display: none;" class="guncellebtn yuzde30">
                                <a class="yesilbtn gonderbtn" id="split_submit" href="javascript:void(0);"><?php echo __("admin/invoices/split"); ?></a>
                            </div>

                            <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                                <a class="yesilbtn gonderbtn" id="editForm_submit" href="javascript:void(0);"><?php echo __("admin/invoices/save-button"); ?></a>
                            </div>
                            <div class="clear"></div>


                        </form>
                    </div>
                    <div class="clear"></div>
                </div><!-- tab 1 content end -->

                <div id="tab-informations" class="tabcontent">
                    <?php
                        $user_data  = $invoice["user_data"];
                    ?>
                    <div class="adminpagecon">
                        <form action="<?php echo $links["controller"]; ?>" method="post" id="informationsForm">
                            <input type="hidden" name="operation" value="update_informations">

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/users/create-ac-type"); ?></div>
                                <div class="yuzde70">
                                    <input onclick="$('.ac-type-wrap').not('.individual-wrap').css('display','none'),$('.individual-wrap').css('display','block');" id="kind-individual" class="radio-custom" name="kind" value="individual" type="radio">
                                    <label for="kind-individual" class="radio-custom-label" style="margin-right: 28px;"><span class="checktext"><?php echo __("admin/users/create-ac-type-individual"); ?></span></label>
                                    <input id="kind-corporate" onclick="$('.ac-type-wrap').not('.corporate-wrap').css('display','none'),$('.corporate-wrap').css('display','block');" class="radio-custom" name="kind" value="corporate" type="radio">
                                    <label for="kind-corporate" class="radio-custom-label" style="margin-right: 28px;"><span class="checktext"><?php echo __("admin/users/create-ac-type-corporate"); ?></span></label>
                                </div>
                            </div>

                            <div class="formcon ac-type-wrap individual-wrap">
                                <div class="yuzde30"><?php echo __("admin/users/create-name"); ?></div>
                                <div class="yuzde70">
                                    <input name="full_name" type="text" value="<?php echo $user_data["full_name"]; ?>">
                                </div>
                            </div>

                            <div class="formcon ac-type-wrap corporate-wrap" style="display: none;">
                                <div class="yuzde30"><?php echo __("admin/users/create-company-name"); ?></div>
                                <div class="yuzde70">
                                    <input name="company_name" type="text" value="<?php echo $user_data["company_name"]; ?>">
                                </div>
                            </div>

                            <?php if($invoice["user_data"]["address"]["country_id"] == 227): ?>
                                <div class="formcon">
                                    <div class="yuzde30">T.C Kimlik No</div>
                                    <div class="yuzde70">
                                        <input name="identity" type="text" value="<?php echo isset($user_data["identity"]) ? $user_data["identity"] : ''; ?>" maxlength="11" class="width200" onkeypress="return event.charCode>= 48 &amp;&amp;event.charCode<= 57">
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="formcon ac-type-wrap corporate-wrap" style="display: none;">
                                <div class="yuzde30"><?php echo __("admin/users/create-company-tax-number"); ?></div>
                                <div class="yuzde70">
                                    <input name="company_tax_number" type="text" value="<?php echo $user_data["company_tax_number"]; ?>" onkeypress="return event.charCode>= 48 &amp;&amp;event.charCode<= 57">
                                </div>
                            </div>

                            <div class="formcon ac-type-wrap corporate-wrap" style="display: none;">
                                <div class="yuzde30"><?php echo __("admin/users/create-company-tax-office"); ?></div>
                                <div class="yuzde70">
                                    <input name="company_tax_office" type="text" value="<?php echo $user_data["company_tax_office"]; ?>">
                                </div>
                            </div>


                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/users/create-email"); ?></div>
                                <div class="yuzde70">
                                    <input name="email" type="email" value="<?php echo $user_data["email"]; ?>" required="required">
                                </div>
                            </div>

                            <div class="formcon ac-type-wrap individual-wrap">
                                <div class="yuzde30"><?php echo __("admin/users/create-phone"); ?></div>
                                <div class="yuzde70">
                                    <script type="text/javascript">
                                        $(document).ready(function(){
                                            var telInput = $("#gsm");
                                            telInput.intlTelInput({
                                                geoIpLookup: function(callback) {
                                                    callback('<?php if($ipInfo = UserManager::ip_info()) echo $ipInfo["countryCode"]; else echo 'us'; ?>');
                                                },
                                                autoPlaceholder: "on",
                                                formatOnDisplay: true,
                                                initialCountry: "auto",
                                                hiddenInput: "gsm",
                                                nationalMode: false,
                                                placeholderNumberType: "MOBILE",
                                                preferredCountries: ['us', 'gb', 'ch', 'ca', 'de', 'it'],
                                                separateDialCode: true,
                                                utilsScript: "<?php echo $sadress;?>assets/plugins/phone-cc/js/utils.js"
                                            });
                                        });
                                    </script>
                                    <input  id="gsm" type="text" value="<?php echo $user_data["gsm"] ? '+'.$user_data["gsm_cc"].$user_data["gsm"] : ''; ?>" onkeypress="return event.charCode>= 48 &amp;&amp;event.charCode<= 57">
                                </div>
                            </div>


                            <div class="formcon ac-type-wrap corporate-wrap">
                                <div class="yuzde30"><?php echo __("admin/users/create-landline-phone"); ?></div>
                                <div class="yuzde70">
                                    <input name="landline_phone" type="text" value="<?php echo $user_data["landline_phone"]; ?>" onkeypress="return event.charCode>= 48 &amp;&amp;event.charCode<= 57">
                                </div>
                            </div>

                            <div class="clear"></div>
                            <br>

                            <?php
                                $address = $user_data["address"];
                                if(isset($countryList) && $countryList){
                                    ?>
                                    <div class="yuzde25">
                                        <strong><?php echo __("website/account_info/country"); ?></strong>
                                        <select name="country" onchange="getCities(this.options[this.selectedIndex].value);">
                                            <option value=""><?php echo __("website/account_info/select-your"); ?></option>
                                            <?php
                                                foreach($countryList as $country){
                                                    ?><option<?php echo $address["country_code"] == $country["code"] ? ' selected' : ''; ?> value="<?php echo $country["id"];?>" data-code="<?php echo $country["code"]; ?>"><?php echo $country["name"];?></option><?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <?php
                                }
                            ?>
                            <div id="cities" class="yuzde25">
                                <strong><?php echo __("admin/users/create-city"); ?></strong>
                                <input type="text" name="city" placeholder="<?php echo __("admin/users/create-city-placeholder"); ?>" value="<?php echo $address["city"]; ?>">
                            </div>
                            <div id="counti" class="yuzde25" >
                                <strong><?php echo __("admin/users/create-counti"); ?></strong>
                                <input type="text" name="counti" placeholder="<?php echo __("admin/users/create-counti-placeholder"); ?>" value="<?php echo $address["counti"]; ?>">
                            </div>
                            <div id="zipcode" class="yuzde25" style="margin-left:5px;">
                                <strong><?php echo __("admin/users/create-zipcode"); ?></strong>
                                <input name="zipcode" type="text" placeholder="<?php echo __("admin/users/create-zipcode-placeholder"); ?>" value="<?php echo $address["zipcode"]; ?>">
                            </div>
                            <div id="address" class="yuzde100" style="margin-top:20px;">
                                <strong><?php echo __("admin/users/create-address"); ?></strong>
                                <input name="address" type="text" placeholder="<?php echo __("admin/users/create-address-placeholder"); ?>" value="<?php echo $address["address"]; ?>">
                            </div>



                            <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                                <a class="yesilbtn gonderbtn" id="informationsForm_submit" href="javascript:void(0);"><?php echo __("admin/invoices/save-button"); ?></a>
                            </div>

                        </form>
                        <script type="text/javascript">
                            function getCities(country) {
                                $("#manageAddressForm select[name='counti']").replaceWith('<input type="text" name="counti" placeholder="<?php echo __("admin/users/create-counti-placeholder"); ?>">');
                                if(country != ''){
                                    var data;
                                    var request = MioAjax({
                                        action:"<?php echo $links["users"]; ?>",
                                        method:"POST",
                                        data:{operation:"getCities",country:country},
                                    },true,true);

                                    request.done(function(result){
                                        if(result || result != undefined){
                                            if(result != ''){
                                                var solve = getJson(result);
                                                if(solve !== false){
                                                    if(solve.status == "successful"){
                                                        data = solve.data;
                                                        $("#manageAddressForm input[name='city']").replaceWith('<select name="city" onchange="getCounties(this.options[this.selectedIndex].value);"></select>');
                                                        $("#manageAddressForm select[name='city']").append($('<option>', {
                                                            value: '',
                                                            text: "<?php echo ___("needs/select-your"); ?>",
                                                        }));
                                                        $(data).each(function (index,elem) {
                                                            $("#manageAddressForm select[name='city']").append($('<option>', {
                                                                value: elem.id,
                                                                text: elem.name
                                                            }));
                                                        });
                                                    }else{
                                                        $("#manageAddressForm select[name='city']").replaceWith('<input type="text" name="city" placeholder="<?php echo __("admin/users/create-city-placeholder"); ?>">');
                                                        $("#manageAddressForm input[name='city']").focus();
                                                    }
                                                }else
                                                    console.log(result);
                                            }
                                        }
                                    });

                                }
                            }
                            function getCounties(city) {
                                if(city != ''){
                                    var data;
                                    var request = MioAjax({
                                        action:"<?php echo $links["users"]; ?>",
                                        method:"POST",
                                        data:{operation:"getCounties",city:city},
                                    },true,true);

                                    request.done(function(result){
                                        if(result || result != undefined){
                                            if(result != ''){
                                                var solve = getJson(result);
                                                if(solve !== false){
                                                    if(solve.status == "successful"){
                                                        data = solve.data;
                                                        $("#manageAddressForm input[name='counti']").replaceWith('<select name="counti"></select>');
                                                        $("#manageAddressForm select[name='counti']").append($('<option>', {
                                                            value: '',
                                                            text: "<?php echo ___("needs/select-your"); ?>",
                                                        }));
                                                        $(data).each(function (index,elem) {
                                                            $("#manageAddressForm select[name='counti']").append($('<option>', {
                                                                value: elem.id,
                                                                text: elem.name
                                                            }));
                                                        });
                                                    }else{
                                                        $("#manageAddressForm select[name='counti']").replaceWith('<input type="text" name="counti" placeholder="<?php echo __("admin/users/create-counti-placeholder"); ?>">');
                                                        $("#manageAddressForm input[name='counti']").focus();
                                                    }
                                                }else
                                                    console.log(result);
                                            }
                                        }
                                    });
                                }
                            }

                            function informationsForm_handler(result){
                                if(result != ''){
                                    var solve = getJson(result);
                                    if(solve !== false){
                                        if(solve.status == "error"){
                                            if(solve.for != undefined && solve.for != ''){
                                                $("#informationsForm "+solve.for).focus();
                                                $("#informationsForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                                $("#informationsForm "+solve.for).change(function(){
                                                    $(this).removeAttr("style");
                                                });
                                            }
                                            if(solve.message != undefined && solve.message != '')
                                                alert_error(solve.message,{timer:5000});
                                        }else if(solve.status == "successful"){
                                            if(solve.message != undefined) alert_success(solve.message,{timer:4000});
                                            if(solve.redirect != undefined && solve.redirect != ''){
                                                setTimeout(function(){
                                                    window.location.href = solve.redirect;
                                                },4000);
                                            }
                                        }
                                    }else
                                        console.log(result);
                                }
                            }

                            $(document).ready(function(){
                                $("input[name=kind][value='<?php echo $user_data["kind"]; ?>']").prop("checked",true).trigger("click");

                                var country = $("#manageAddressForm select[name='country'] option:selected").val();
                                if(country != ''){
                                    getCities(country);
                                }

                                $("#informationsForm_submit").on("click",function(){
                                    MioAjaxElement($(this),{
                                        waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                                        progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                                        result:"informationsForm_handler",
                                    });

                                });

                            });
                        </script>


                    </div>
                    <div class="clear"></div>
                </div>

            </div><!-- tab wrap content end -->


        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>