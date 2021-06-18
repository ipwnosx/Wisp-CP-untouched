<?php
    defined('CORE_FOLDER') OR exit('You can not get in here!');
    $hoptions = ["jquery-ui"];
?>
<script type="text/javascript">
    var selected_payment_method;
    $(function(){

        $("#accordion").accordion({
            heightStyle: "content",
        });

        setTimeout(function(){
            <?php if(isset($payment_screen)): ?>
            reload_selection_result('<?php echo $selected_pmethod; ?>');
            <?php else: ?>
            reload_selection_result();
            <?php endif; ?>
        },200);

        $("#accordion").on("change","input",function(){
            reload_selection_result();
        });

        $(".selected-invoices").on("change",function(){
            $("#checkedAll").prop('checked',$(".selected-invoices").not(":checked").length < 1);
            reload_selection_result();
        });

        $("#checkedAll").change(function(){
            var isSelected = $(this).prop("checked");
            $(".selected-invoices").prop('checked',isSelected);

            reload_selection_result();
        });

        $("#continue_button").click(function(){
            if(selected_payment_method === false || selected_payment_method === undefined)
                return false;

            $(this).html('<?php echo __("website/others/button2-pending"); ?>');
            var selected_pmethod = $("#payment_methods input[name=pmethod]:checked").val();
            $("#payment_screen_redirect input[name=pmethod]").val(selected_pmethod);
            $("#payment_screen_redirect").submit();
        });

    });

    function reload_selection_result(x_selected_pmethod){
        $("#pmethods_loader").fadeOut(200);

        var selected_pmethod = $("#payment_methods input[name=pmethod]:checked").val();

        if(x_selected_pmethod !== undefined) selected_pmethod = x_selected_pmethod;

        var selected_invoices = $(".selected-invoices:checked").map(function(){
            return $(this).val();
        }).toArray();
        $("#payment_screen_redirect input[name=invoices]").val(selected_invoices.join(","));


        var request         = MioAjax({
            action: "<?php echo $links["controller"]; ?>",
            method: "POST",
            data:{
                operation:"selection-result",
                pmethod:selected_pmethod ? selected_pmethod : '',
                invoices:selected_invoices,

            },
        },true,true);

        request.done(function(result){
            if(result != ''){
                var solve = getJson(result);
                if(solve !== false){

                    $("#payment_methods").fadeIn(200).html('');

                    if(solve.status !== undefined && solve.status === "error")
                    {
                        $("#payment_methods").html('<div class="invoice-detail-pp-sb-enabled">'+solve.message+'</div>');
                        $("#continue_button").attr("style","cursor: no-drop;background: #b0b0b0;").addClass('graybtn');
                        return false;
                    }

                    var content,amount,see_fee,checked_status;
                    $(solve.pmethods).each(function(key,item){
                        if(item.balance != undefined){
                            see_fee =  ' ('+item.balance+')';
                        }else if(item.commission_fee != undefined){
                            see_fee = ' (+'+item.commission_fee+')';
                        }else
                            see_fee = '';

                        if(item.selected != undefined){
                            selected_payment_method = item.name;
                            checked_status = ' checked';
                        }
                        else
                            checked_status = '';

                        content = '<input id="method-'+key+'" class="checkbox-custom" name="pmethod" value="'+item.method+'" type="radio"'+checked_status+'>';
                        content += '<label for="method-'+key+'" class="checkbox-custom-label"><strong>'+item.option_name+'</strong>'+see_fee+'</label>';
                        $("#payment_methods").append(content);
                    });

                    if(solve.tax != undefined && parseInt(solve.tax) != 0){
                        $("#tax_wrap").css("display","table-row");
                        $("#tax_fee").html(solve.tax);
                    }else
                        $("#tax_wrap").css("display","none");

                    if(solve.total != undefined){
                        $("#total_wrap").css("display","table-row");
                        $("#total_fee").html(solve.total);
                    }else
                        $("#total_wrap").css("display","none");

                    if(solve.subtotal != undefined) $("#subtotal_fee").html(solve.subtotal);

                    if(solve.pcommission != 0){
                        $("#pmethod_commission_wrap").css("display","table-row");
                        var label_text = '<?php echo __("website/account_invoices/pmethod_commission"); ?>';
                        label_text = label_text.replace("{method}",selected_payment_method);
                        label_text += " (%"+solve.pcommission_rate+")";
                        $("#pmethod_commission_label").html(label_text);
                        $("#pmethod_commission_fee").html(solve.pcommission);
                    }else
                        $("#pmethod_commission_wrap").css("display","none");


                }else
                    console.log(result);
            }
        });
    }
</script>
<div class="mpanelrightcon">

    <div class="mpaneltitle">
        <div class="sayfayolu"><?php include __DIR__.DS."inc/panel-breadcrumb.php"; ?></div>
        <h4><strong><i class="fa fa-file-text-o"></i> <?php echo __("website/account_invoices/page-bulk-payment"); ?></strong></h4>
    </div>

    <div class="bulkpayment">
        <style>
            .bulkpayment table tr td {padding:10px;border-bottom:1px solid #ccc;}
        </style>

        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td width="5%" align="center" bgcolor="#eee">
                    <input type="checkbox" id="checkedAll" value="1" checked class="checkbox-custom">
                    <label class="checkbox-custom-label" for="checkedAll"></label>
                </td>
                <td width="50%" bgcolor="#eee"><strong><?php echo __("website/account_invoices/bulk-payment-text1"); ?></strong></td>
                <td width="25%" align="center" bgcolor="#eee"><strong><?php echo __("website/account_invoices/bulk-payment-text2"); ?></strong></td>
            </tr>

            <?php
                $currency       = Money::getUCID();
                $subtotal       = 0;
                $tax            = 0;
                if(isset($unpaid_invoices) && $unpaid_invoices){
                    foreach($unpaid_invoices AS $invoice){
                        $selected   = isset($invoice["selected"]) ? $invoice["selected"] : true;
                        $us_data    = Utility::jdecode($invoice["user_data"],true);
                        $invoice["discounts"] = Utility::jdecode($invoice["discounts"],true);

                        $_subtotal   = Money::exChange($invoice["subtotal"],$invoice["currency"],$currency);

                        if(isset($invoice["discounts"]["items"]["dealership"]) && $invoice["discounts"]["items"]["dealership"]){
                            foreach($invoice["discounts"]["items"]["dealership"] AS $d){
                                $_subtotal -= $d["amountd"];
                            }
                        }

                        if(isset($invoice["discounts"]["items"]["coupon"]) && $invoice["discounts"]["items"]["coupon"]){
                            foreach($invoice["discounts"]["items"]["coupon"] AS $d){
                                $_subtotal -= $d["amountd"];
                            }
                        }


                        if($invoice["local"] && $invoice["legal"]){
                            $invoice_tax = Money::get_tax_amount($_subtotal,$invoice["taxrate"]);
                            $invoice_tax = Money::exChange($invoice_tax,$invoice["currency"],$currency);
                            $tax         += $invoice_tax;
                        }

                        $items      = Invoices::item_listing($invoice["id"]);


                        if($selected) $subtotal += $_subtotal;

                        $bill_link  = Controllers::$init->CRLink("ac-ps-detail-invoice",[$invoice["id"]]);
                        ?>
                        <tr>
                            <td align="center">
                                <input<?php echo $selected ? ' checked' : ''; ?> id="checkbox-<?php echo $invoice["id"]; ?>" type="checkbox" class="selected-invoices checkbox-custom" value="<?php echo $invoice["id"]; ?>"><label class="checkbox-custom-label" for="checkbox-<?php echo $invoice["id"]; ?>"></label>
                            </td>
                            <td>
                                <strong>
                                    <a href="<?php echo $bill_link; ?>" target="_blank"><?php echo __("website/account_invoices/invoice-num"); ?> #<?php echo $invoice["id"]; ?></a>
                                </strong>
                                <br />
                                <?php
                                    foreach($items AS $item){
                                        $amount = $item["amount"];
                                        $cid    = isset($item["currency"]) ? $item["currency"] : $item["cid"];
                                        echo implode("<br>",explode(EOL,$item["description"]));
                                    }
                                ?>
                            </td>
                            <td align="center"><?php echo Money::formatter_symbol($amount,$cid,true); ?></td>
                        </tr>
                        <?php
                    }
                }

                $total = $subtotal + $tax;
            ?>

            <tr id="pmethod_commission_wrap" style="display: none;">
                <td align="center" bgcolor="#eee"></td>
                <td align="right" bgcolor="#EEE"><strong id="pmethod_commission_label"><?php echo __("website/account_invoices/pmethod_commission"); ?> (%0)</strong></td>
                <td align="center" bgcolor="#EEE"><strong id="pmethod_commission_fee">0</strong></td>
            </tr>

            <tr id="subtotal_wrap">
                <td align="center" bgcolor="#eee"></td>
                <td align="right" bgcolor="#EEE"><strong><?php echo __("website/account_invoices/bulk-payment-text3"); ?></strong></td>
                <td align="center" bgcolor="#EEE"><strong id="subtotal_fee" <?php echo Money::formatter_symbol($subtotal,$currency); ?></strong></td>
            </tr>


            <tr id="tax_wrap" style="<?php echo $tax > 0 ? '' : 'display: none;'; ?>">
                <td align="center" bgcolor="#eee"></td>
                <td align="right" bgcolor="#EEE"><strong><?php echo ___("needs/tax"); ?></strong></td>
                <td align="center" bgcolor="#EEE"><strong id="tax_fee"><?php echo Money::formatter_symbol($tax,$currency)?></strong></td>
            </tr>
            <tr id="total_wrap">
                <td align="center" bgcolor="#4CAF50"></td>
                <td align="right" bgcolor="#4CAF50"><strong style="font-size:16px;color:white;"><?php echo __("website/account_invoices/bulk-payment-text5"); ?></strong></td>
                <td align="center" bgcolor="#4CAF50"><strong style="font-size:18px;color:white;" id="total_fee"><?php echo Money::formatter_symbol($total,$currency)?></strong></td>
            </tr>
        </table>

        <div class="clear"></div>

        <div id="payment-screen" style="<?php echo isset($payment_screen) ? '' : 'display:none;'; ?>margin-top:10px;">
            <div id="payment-screen-content">
                <?php echo isset($payment_screen['content']) ? $payment_screen['content'] : ''; ?>
            </div>
            <div class="clear"></div>
            <a class="lbtn" href="<?php echo $links["controller"]; ?>"><?php echo __("website/account_invoices/payment-turn-back"); ?></a>
        </div>

        <div id="selection-methods" class="tabcontentcon" style="width:100%;<?php echo isset($payment_screen) ? 'display:none;' : ''; ?>">
            <div class="clear"></div>
            <div id="accordion" style="margin-top: 25px;">

                <h3><?php echo __("website/account_invoices/bulk-payment-text6"); ?></h3>
                <div>
                    <div class="odemeyontem">
                        <h5><strong><?php echo __("website/account_invoices/payment-method"); ?></strong></h5>
                        <div class="clear"></div>

                        <div id="pmethods_loader" style="margin-top: 10px; text-align: center;">
                            <div class="spinner"></div>
                        </div>
                        <div id="payment_methods" style="display:none;"></div>

                        <div class="clear"></div>
                    </div>

                    <div class="clear"></div>
                    <div class="line"></div>
                    <form id="payment_screen_redirect" action="<?php echo $links["controller"]; ?>" method="post">
                        <input type="hidden" name="operation" value="payment-screen">
                        <input type="hidden" name="pmethod" value="<?php echo isset($selected_pmethod) ? $selected_pmethod : 'none'; ?>">
                        <input type="hidden" name="invoices" value="">
                    </form>
                    <a href="javascript:void(0);" id="continue_button" class="yesilbtn gonderbtn"><?php echo __("website/account_invoices/continue-button"); ?></a>
                    <div class="clear"></div>
                </div>
            </div>
        </div>


    </div>

    <div class="clear"></div>
</div>