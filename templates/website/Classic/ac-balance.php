<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    $hoptions = ["datatables","iziModal"];
?>
<script type="text/javascript">
    function updateSettings(){
        var autopbc = $("#auto_payment_by_credit:checked").prop("checked");
        if(autopbc == undefined) autopbc = 0;
        if(autopbc) autopbc = 1;
        var balance_min = $("input[name=balance_min]").val();
        balance_min     = parseInt(balance_min);
        var result = MioAjax({
            action: "<?php echo $links["controller"]; ?>",
            method: "POST",
            data: {
                operation:"update_settings",
                auto_payment_by_credit:autopbc,
                balance_min:balance_min,
                token: "<?php echo Validation::get_csrf_token('account',false); ?>",
            }
        },true);

        if(result != ''){
            var solve = getJson(result);
            if(solve !== false){
                if(solve.status == "error"){
                    if(solve.for != undefined && solve.for != ''){
                        $(solve.for).focus();
                        $(solve.for).attr("style","border-bottom:2px solid red; color:red;");
                        $(solve.for).change(function(){
                            $(this).removeAttr("style");
                        });
                    }
                    if(solve.message != undefined && solve.message != '')
                        $("#result1").fadeIn(300).html(solve.message);
                    else
                        $("#result1").fadeOut(300).html('');
                }else if(solve.status == "successful"){

                    swal({
                        title: '<?php echo __("website/balance/settings-modal-title"); ?>',
                        text: '<?php echo __("website/balance/settings-modal-message"); ?>',
                        timer: 1200,
                        type: 'success',
                        showConfirmButton:false
                    });
                    setTimeout(function(){
                        window.location.href = "<?php echo $links["controller"]; ?>";
                    },1000);
                }
            }else
                console.log(result);
        }

    }

    function BuyCredit(convert,confirm) {
        var amount      = $("input[name='new_balance']").val();
        var currency    = $("select[name='currency']").val();
        amount          = amount == '' ? 0 : parseInt(amount);
        var request     = MioAjax({
            action: "<?php echo $links["controller"]; ?>",
            method: "POST",
            data: {
                operation:"buy_credit",
                amount:amount,
                currency:currency,
                convert:convert ? 1 : 0,
                confirm:confirm ? 1 : 0,
                token: "<?php echo Validation::get_csrf_token('account',false); ?>",
            }
        },true,true);

        request.done(function (result){
            if(result != ''){
                var solve = getJson(result);
                if(solve !== false){
                    if(solve.status == "error"){
                        if(solve.for != undefined && solve.for != ''){
                            $(solve.for).focus();
                            $(solve.for).attr("style","border-bottom:2px solid red; color:red;");
                            $(solve.for).change(function(){
                                $(this).removeAttr("style");
                            });
                        }
                        if(solve.message != undefined && solve.message != ''){
                            swal({
                                title: '<?php echo __("website/balance/boy-modal-title"); ?>',
                                text: solve.message,
                                type: 'error',
                            });
                        }
                    }else if(solve.status == "convert"){
                        var bodyText = "<?php echo __("website/balance/convert-modal-body"); ?>";
                        bodyText = bodyText.replace("{current_currency}",solve.current_currency);
                        bodyText = bodyText.replace("{new_currency}",solve.new_currency);
                        bodyText = bodyText.replace("{current_credit}",solve.current_credit);
                        bodyText = bodyText.replace("{buy_credit}",solve.buy_credit);
                        bodyText = bodyText.replace("{new_credit}",solve.new_credit);

                        $("#ConvertBody").html(bodyText);
                        open_modal("Convert");
                    }else if(solve.status == "confirm"){
                        open_modal("Confirm");
                    }else if(solve.status == "successful"){
                        window.location.href = solve.redirect;
                    }
                }else
                    console.log(result);
            }
        });

    }
</script>
<div class="mpanelrightcon">

    <div class="mpaneltitle">
        <div class="sayfayolu"><?php include $tpath."inc".DS."panel-breadcrumb.php"; ?></div>
        <h4><strong><i class="fa fa-money" aria-hidden="true"></i> <?php echo $header_title; ?></strong></h4>
    </div>

    <br>
    <div class="balancepage">

        <div class="green-info">
            <div class="padding20">
                <i class="fa fa-info-circle" aria-hidden="true"></i>
               
                  <p>  <?php echo __("website/balance/balanceinfo");?></p>
               
            </div>
        </div>

        <div class="hesapbilgilerim">
            <table width="100%" border="0" align="center">
                <tr>
                    <td width="30%"><?php echo __("website/balance/currentcredit");?></td>
                    <td><H5><strong><?php echo $user_balance; ?></strong></H5></td>
                </tr>

                <?php if($pay_latest_balance): ?>
                    <tr>
                        <td width="30%"><?php echo __("website/balance/creditloadingtime");?></td>
                        <td><?php echo $pay_latest_balance; ?></td>
                    </tr>
                <?php endif; ?>

                <?php if($visibility_auto_payment): ?>
                    <tr>
                        <td width="30%"><?php echo __("website/balance/creditautopay");?></td>
                        <td>
                            <input id="auto_payment_by_credit" class="checkbox-custom" name="auto_payment_by_credit" value="1" type="checkbox" style="width:100px;"<?php echo $auto_payment_by_credit ? ' checked' : NULL; ?>>
                            <label for="auto_payment_by_credit" class="checkbox-custom-label"><span class="checktext"><?php echo __("website/balance/creditautopayinfo");?></span></label>
                        </td>
                    </tr>
                <?php endif; ?>

                <tr>
                    <td width="30%"><?php echo __("website/balance/balancewarning");?></td>
                    <td>
                        <?php
                            $context = "";
                            $symbol_text = '<strong>'.$currency["symbol"].'</strong>';
                            $context     .= $currency["position"] == "LEFT" ? $symbol_text : NULL;
                            $context .= ' <input onkeypress=\'return event.charCode >= 48 && event.charCode <= 57\' style="text-align: center;width:95px;" class="yuzde20" name="balance_min" type="text" placeholder="'.__("website/balance/amounteg").'" value="'.$balance_min.'"> ';
                            $context     .= $currency["position"] == "RIGHT" ? $symbol_text : NULL;
                            echo __("website/balance/balwarninginfo",['{input}' => $context]);
                        ?>
                    </td>
                </tr>

                <tr>
                    <td></td>
                    <td>
                        <a href="javascript:updateSettings();void 0;" class="lbtn"><?php echo __("website/balance/creditupdate");?></a>
                        <div class="clear"></div>
                        <div id="result1" class="error" style="margin-top: 5px; display: none;"></div>
                    </td>
                </tr>

                <tr>
                    <td colspan="2"><H5><strong><?php echo __("website/balance/loadcredit");?></strong></H5></td>
                </tr>
                <tr>
                    <td><?php echo __("website/balance/creditamount");?></td>
                    <td>
                        <input style="width:95px;" name="new_balance" type="text" placeholder="<?php echo __("website/balance/amounteg");?>" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                        <select name="currency" style="width: 150px;">
                            <?php
                                $currencies = Money::getCurrencies($udata["balance_currency"]);
                                if($currencies){
                                    foreach($currencies AS $curr){
                                        ?>
                                        <option<?php echo $curr["id"] == $udata["balance_currency"] ? ' selected' : ''; ?> value="<?php echo $curr["id"]; ?>"><?php echo $curr["name"]." (".$curr["code"].")"; ?></option>
                                        <?php
                                    }
                                }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td><a href="javascript:BuyCredit();void 0;" class="green lbtn"><i class="fa fa-check" aria-hidden="true"></i> <?php echo __("website/balance/loadcredit");?></a></td>
                </tr>
            </table>
        </div>

    </div>

    <div class="clear"></div>
</div>
<div id="Convert" data-izimodal-title="<?php echo __("website/balance/convert-modal-title") ?>" style="display: none;">
    <div class="padding30">
        <p style="    font-size: inherit;" id="ConvertBody"></p>  

        <div class="line"></div>

        <div align="center">
            <a style="width:240px;" href="javascript:close_modal('Convert'),BuyCredit(true);void 0;" class="yesilbtn gonderbtn"><?php echo __("website/balance/convert-modal-ok"); ?></a>
        </div>
       

        <div class="clear"></div>
    </div>
</div>
<div id="Confirm" data-izimodal-title="<?php echo __("website/balance/confirm-modal-title") ?>" style="display: none;">
    <div class="padding30">
      <p> <?php echo __("website/balance/confirm-modal-content") ?></p>
<div class="line"></div>
        <div align="center" class="">
            <a style="width: 240px;" href="javascript:close_modal('Confirm'),BuyCredit(true,true);void 0;" class="yesilbtn gonderbtn"><?php echo __("website/balance/confirm-modal-ok"); ?></a>
        </div>
      

        <div class="clear"></div>
    </div>
</div>