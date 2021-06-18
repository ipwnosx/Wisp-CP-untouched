<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    $hoptions = [
        'page' => "basket-payment",
        'intlTelInput',
    ];

    $currency_symbols = [];

    foreach(Money::getCurrencies() AS $currency){
        $symbol = $currency["prefix"] != '' ? trim($currency["prefix"]) : trim($currency["suffix"]);
        if(!$symbol) $symbol = $currency["code"];
        $currency_symbols[$symbol] = $currency["id"];
    }
?>
<script type="text/javascript">
    var currency_symbols = <?php echo Utility::jencode($currency_symbols); ?>;

    var pay_ok,current_balance=0,changing_balance=0,address,int_balance,total_payable;
    var default_country;

    function amount_divider(str){
        var visible_amount      = str;
        var split_amount        = visible_amount.split(" ");
        var amount_symbol       = '';
        var amount_symbol_pos   = '';
        var split_amount_last   = split_amount.length-1;

        if(currency_symbols[split_amount[0]]){
            amount_symbol_pos   = 'left';
            amount_symbol       = split_amount[0];
            split_amount.shift();
            visible_amount      = split_amount.join(" ");
        }else if(currency_symbols[split_amount[split_amount_last]]){
            amount_symbol_pos   = 'right';
            amount_symbol       = split_amount[split_amount_last];
            split_amount.pop();
            visible_amount      = split_amount.join(" ");
        }
        return {
            amount      : visible_amount,
            symbol_pos  : amount_symbol_pos,
            symbol      : amount_symbol
        };
    }

    function OrderSummary(options) {

        var sendbta = $("#sendbta-checkbox:checked").val();
        var pmethod = $("input[name=payment_method]:checked").val();
        if(options == "pay") var pay  = 1;
        else var pay = 0;

        if(pay == 1){

            var contract1   = $("#contract1").prop("checked");
            var contract2   = $("#contract2").prop("checked");

            if(contract1 == undefined || !contract1 || contract2 == undefined || !contract2){
                alert_error('<?php echo htmlentities(__("website/basket/error16"),ENT_QUOTES); ?>',{timer:3000});
                return false;
            }

            if(pay == 1 && pmethod == "Balance" && !pay_ok){
                if(int_balance==0 && total_payable != 0){
                    open_modal("InsufficientBalance");
                }else{
                    var text = '<?php echo __("website/basket/balance-warning-text",[EOL => '\n']); ?>';
                    text = text.replace(/{currenct_balance}/g,current_balance);
                    text = text.replace(/{changing_balance}/g,changing_balance);

                    $("#BalanceWarning p").html(text);
                    open_modal("BalanceWarning");
                }
                return false;
            }
        }else{
            pay_ok = false;
        }

        $("#OrderSummary_loader").css("display","block");
        $("#OrderSummaryContent").css("display","none");
        $("#continue_go").css("display","none");

        var request = MioAjax({
            action: "<?php echo $links["bring"]."order-summary"; ?>",
            method: "POST",
            data: {
                payment:1,
                address:address,
                sendbta:sendbta,
                pmethod:pmethod,
                pay:pay,
                contract1:contract1,
                contract2:contract2,
            },
        },true,true);

        request.done(function (result){

            $("#OrderSummary_loader").fadeOut(500,function(){
                $("#OrderSummaryContent").fadeIn();
            });
            $("#continue_go").css("display","block");

            var solve = false,content = '';
            if(result){
                solve = getJson(result);
                if(solve){

                    if(solve.type != undefined && solve.type == "pay"){

                        if(solve.status == "successful"){
                            if(solve.redirect != undefined && solve.redirect != '')
                                window.location.href = solve.redirect;
                        }else if(solve.status == "error"){
                            alert_error(solve.message,{timer:3000});
                        }
                    }else{

                        if(solve.total_amount != undefined){
                            var amount_info = amount_divider(solve.total_amount);
                            $("#total-amount").html('<div class="amount_spot_view"><i class="currpos'+amount_info.symbol_pos+'">'+amount_info.symbol+'</i> '+amount_info.amount+'</div>');
                        }
                        else $("#total-amount").html('-');

                        if(solve.dealership_discounts != undefined && solve.dealership_discounts.length){
                            $("#dealership_discounts").html('').fadeIn(1);
                            var d_content = '';
                            var d_see = '<?php echo __("website/basket/dealership-discount", ['']); ?>';
                            var d_seee = '';
                            $(solve.dealership_discounts).each(function(dkey,ditem){
                                var amount_info = amount_divider(ditem.amount);
                                d_content  = '<tr>';
                                d_seee     = d_see.replace('{rate}',ditem.rate);
                                d_content += '<td><strong>'+d_seee+'</strong><br>('+ditem.name+') </td>';
                                d_content += '<td align="right"><h5><div class="amount_spot_view"><i class="currpos'+amount_info.symbol_pos+'">'+amount_info.symbol+'</i> -'+amount_info.amount+'</div></h5></td>';
                                d_content += '</tr>';
                                $("#dealership_discounts").append(d_content);
                            });
                        }else $("#dealership_discounts").html('').fadeOut(1);

                        if(solve.coupon_discounts != undefined && solve.coupon_discounts.length){
                            $("#coupon_discounts").html('').fadeIn(1);
                            var d_content = '';
                            var d_see = '<?php echo __("website/basket/coupon-discount", ['']); ?>';
                            var d_seee = '';
                            $(solve.coupon_discounts).each(function(dkey,ditem){
                                d_content  = '<tr>';
                                d_seee     = d_see.replace('{value}',ditem.dvalue);
                                d_content += '<td><strong>'+d_seee+'</strong><br>('+ditem.name+') <a style="color:#777;margin-left:5px;" title="<?php echo __("website/basket/delete-coupon"); ?>" href="javascript:deleteCoupon('+ditem.id+');void 0;"><i class="fa fa-trash" aria-hidden="true"></i></a></td>';
                                var amount_info = amount_divider(ditem.amount);
                                d_content += '<td align="right"><h5><div class="amount_spot_view"><i class="currpos'+amount_info.symbol_pos+'">'+amount_info.symbol+'</i> -'+amount_info.amount+'</div></h5></td>';
                                d_content += '</tr>';
                                $("#coupon_discounts").append(d_content);
                            });
                        }else $("#coupon_discounts").html('').fadeOut(1);


                        if(solve.taxation != undefined && solve.taxation){
                            $("#tax_content").fadeIn(1);
                            var see,see_text;
                            see     = $("#tax-see");
                            see_text = '<?php echo __("website/basket/tax-amount"); ?>';
                            see_text = see_text.replace('{rate}',solve.tax_rate);
                            see.html(see_text);
                            if(solve.total_tax_amount != undefined){
                                var amount_info = amount_divider(solve.total_tax_amount);
                                $("#tax-amount").html('<div class="amount_spot_view"><i class="currpos'+amount_info.symbol_pos+'">'+amount_info.symbol+'</i> '+amount_info.amount+'</div>');
                            }else $("#tax-amount").html('-');
                        }else $("#tax_content").fadeOut(1);

                        if(solve.total_amount_payable != undefined){
                            var amount_info = amount_divider(solve.total_amount_payable);
                            $("#total-amount-payable").html('<div class="amount_spot_view"><i class="currpos'+amount_info.symbol_pos+'">'+amount_info.symbol+'</i> '+amount_info.amount+'</div>');
                            total_payable = solve.int_total_amount_payable;
                        }
                        else
                            $("#total-amount-payable").html('-');

                        if(solve.sendbta_visible != undefined && solve.sendbta_visible){
                            if(solve.sendbta_price != undefined && solve.sendbta_price != ''){
                                $("#sendbta_amount").html("(+"+solve.sendbta_price+")");

                                if(solve.sendbta_selected != undefined && solve.sendbta_selected){
                                    $("#sendbta_select").fadeIn(100);
                                    var amount_info = amount_divider(solve.sendbta_price);
                                    $("#sendbta_amount2").html('<div class="amount_spot_view"><i class="currpos'+amount_info.symbol_pos+'">'+amount_info.symbol+'</i> '+amount_info.amount+'</div>');
                                }else{
                                    $("#sendbta-checkbox").prop("checked",false);
                                    $("#sendbta_select").fadeOut(100);
                                }

                            }
                            $("#sendbta").fadeIn(100);
                        }else{
                            $("#sendbta_select").fadeOut(100);
                            $("#sendbta-checkbox").prop("checked",false);
                            $("#sendbta").fadeOut(1);
                        }

                        if(solve.payment_methods != undefined && solve.payment_methods){
                            $("#pmethods_loader,#no_address_selected").fadeOut(100);
                            $("#payment_methods").html('');
                            var amount,see_fee,checked_status;
                            $(solve.payment_methods).each(function(key,item){
                                if(item.balance != undefined){
                                    current_balance  = item.balance;
                                    int_balance = item.int_balance;
                                    changing_balance = item.changing_balance;
                                    see_fee =  ' ('+item.balance+')';
                                }else if(item.commission_fee != undefined){
                                    see_fee = ' ('+item.commission_fee+')';
                                }else
                                    see_fee = '';

                                if(solve.select_pmethod == item.method){
                                    pmethod = item.method;
                                    checked_status = ' checked';
                                }else
                                    checked_status = '';

                                content = '<input id="method-'+key+'" class="checkbox-custom" name="payment_method" value="'+item.method+'" type="radio"'+checked_status+'>';
                                content += '<label for="method-'+key+'" class="checkbox-custom-label"><strong>'+item.option_name+'</strong>'+see_fee+'</label>';
                                $("#payment_methods").append(content);
                            });
                            $("#payment_methods").fadeIn(100);
                        }else{
                            $("#pmethods_loader").fadeOut(100);
                            $("#no_address_selected").fadeIn(100);
                        }

                        if(solve.pm_commission != undefined && solve.pm_commission != ''){
                            $("#pmethod_name").html(solve.pm_commission+" (%"+solve.pm_commission_rate+")");

                            var amount_info = amount_divider(solve.pm_commission_amount);

                            $("#pm_commission_amount").html('<div class="amount_spot_view"><i class="currpos'+amount_info.symbol_pos+'">'+amount_info.symbol+'</i> '+amount_info.amount+'</div>');
                            $("#pmethod_select").fadeIn(100);
                        }else{
                            $("#pmethod_select").fadeOut(100);
                            $("#pmethod_name").html('');
                            $("#pm_commission_amount").html('');
                        }

                        if(pmethod == null || pmethod == ''){
                            $("#pay_button").fadeOut(250,function(){
                                $("#block_button").fadeIn(250);
                            });
                        }else{
                            $("#block_button").fadeOut(250,function(){
                                $("#pay_button").fadeIn(250);
                            });
                        }

                    }

                }else console.log("Can not resolved : "+result);
            }else console.log("Failed loaded in basket to order summary");
        });
    }

    function deleteCoupon(id){
        if(id != 0 && id != null){

            var request = MioAjax({
                action: "<?php echo $links["bring"]."delete-coupon"; ?>",
                method: "POST",
                data:{coupon_id:id}
            },true,true);

            request.done(function(result){
                if(result){
                    var solve = getJson(result);
                    if(solve){
                        if(solve.status == "successful"){
                            OrderSummary();
                        }
                    }else console.log(result);
                }else console.log("Coupon check result is empty");
            });
        }
    }

    $(document).ready(function(){
        setTimeout(function(){
            OrderSummary();
        });
    });
</script>

<div id="two-factor-verification" style="display: none;">
    <script type="text/javascript">
        $(document).ready(function(){

            $("#TwoFactorForm").bind("keypress", function(e) {
                if (e.keyCode == 13) $("#btn_check").click();
            });

            $("#btn_check").click(function(){
                $("#TwoFactorForm input[name=action]").val("two-factor-check");
                MioAjaxElement(this,{
                    waiting_text: "<?php echo addslashes(__("website/others/button1-pending")); ?>",
                    form: $("#TwoFactorForm"),
                    result:"SubmitStepAccount_handler",
                });
            });

            $("#btn_resend").click(function(){
                $("#TwoFactorForm input[name=action]").val("two-factor-resend");
                MioAjaxElement(this,{
                    waiting_text: "<?php echo addslashes(__("website/others/button1-pending")); ?>",
                    form: $("#TwoFactorForm"),
                    result:"SubmitStepAccount_handler",
                });
            });

        });
    </script>

    <div class="padding20 verificationcontent">
        <h1><i class="fa fa-shield" aria-hidden="true"></i><br><?php echo __("website/sign/security-check"); ?></h1>
        <p><?php echo __("website/sign/security-check-text1"); ?></p>
        <p><?php echo __("website/sign/security-check-text2"); ?><br><strong id="two_factor_phone">*********0000</strong></p>

        <form action="<?php echo $login_link;?>" method="post" id="TwoFactorForm">
            <?php echo Validation::get_csrf_token('sign'); ?>

            <div class="yuzde70">
                <input type="text" name="code" placeholder="<?php echo __("website/sign/security-check-text3"); ?>">
            </div>
            <div class="yuzde70" style="margin-top: 15px;font-size: 17px;display: inline-block;"><strong><i class="fa fa-clock-o" aria-hidden="true"></i> <span id="countdown1">00:00</span></strong></div>
            <input type="hidden" name="action" value="two-factor-check">
        </form>

        <div class="line"></div>

        <div align="center" class="yuzde100">
            <div class="yuzde50"><a class="gonderbtn yesilbtn " id="btn_check" href="javascript:void 0;"><?php echo __("website/sign/security-check-text4"); ?></a>
                <a class="lbtn" id="btn_resend" href="javascript:void 0;" style="display: none;margin-top: 20px;"><?php echo __("website/sign/security-check-text5"); ?></a>
            </div>
        </div>

        <div class="notverification"><?php echo __("website/sign/security-check-text6",[
                '{link}' => $contact_link,
            ]); ?></a></div>

    </div>
</div>

<div id="location-verification" style="display: none;">
    <script type="text/javascript">
        $(document).ready(function(){

            $("#Location_Verification_Form").bind("keypress", function(e) {
                if (e.keyCode == 13) $("#btn_continue").click();
            });

            $("#btn_continue").click(function(){
                if($("#Location_Verification_Form #method_selections").css("display") == "block")
                    $("#Location_Verification_Form input[name=apply]").val("selection");
                else
                    $("#Location_Verification_Form input[name=apply]").val("check");

                MioAjaxElement(this,{
                    waiting_text: "<?php echo addslashes(__("website/others/button1-pending")); ?>",
                    form: $("#Location_Verification_Form"),
                    result:"SubmitStepAccount_handler",
                });
            });

            $("#btn_resend2").click(function(){
                $("#Location_Verification_Form input[name=apply]").val("resend");
                MioAjaxElement(this,{
                    waiting_text: "<?php echo addslashes(__("website/others/button1-pending")); ?>",
                    form: $("#Location_Verification_Form"),
                    result:"SubmitStepAccount_handler",
                });
            });

        });
    </script>
    <div class="padding20 verificationcontent">
        <h1><i class="fa fa-lock" aria-hidden="true"></i><br><?php echo __("website/sign/security-check"); ?></h1>
        <p><?php echo __("website/sign/security-check-text7"); ?></p>
        <p><?php echo __("website/sign/security-check-text8"); ?></p>


        <form action="<?php echo $login_link; ?>" method="post" id="Location_Verification_Form">
            <?php echo Validation::get_csrf_token('sign'); ?>

            <div id="method_selections" style="display: none; text-align: left;">
                <div class="secureoptions">

                    <input id="method_security_question" class="radio-custom" name="selected_method" value="security_question" type="radio">
                    <label style="margin-right:10px;" for="method_security_question" class="radio-custom-label"><span class="checktext"><?php echo __("website/sign/security-check-text9"); ?></span></label>

                    <div class="clear"></div>

                    <input id="method_phone" class="radio-custom" name="selected_method" value="phone" type="radio">
                    <label style="margin-right:10px;" for="method_phone" class="radio-custom-label"><span class="checktext"><?php echo __("website/sign/security-check-text10"); ?></span></label>

                </div>
            </div>

            <div id="method_security_question_con" style="display: none;">
                <p><br><strong id="security_question_text">*****?</strong></p>

                <div class="yuzde70">
                    <input type="text" name="security_question_answer" placeholder="<?php echo __("website/sign/security-check-text11"); ?>"><br>
                </div>
            </div>


            <div id="method_phone_con" style="display: none;">
                <p><br><?php echo __("website/sign/security-check-text2"); ?><br><strong id="phone_text">*********0000</strong></p>

                <div class="yuzde70">
                    <input type="text" name="code" placeholder="<?php echo __("website/sign/security-check-text3"); ?>">
                </div>
                <div class="yuzde70" style="margin-top: 15px;font-size: 17px;display: inline-block;"><strong><i class="fa fa-clock-o" aria-hidden="true"></i> <span id="countdown2">00:00</span></strong><br></div>

            </div>

            <div class="line"></div>

            <div align="center" class="yuzde100">
                <div class="yuzde50">
                    <a class="gonderbtn yesilbtn" id="btn_continue" href="javascript:void 0;"><?php echo __("website/sign/security-check-text4"); ?></a>
                    <a class="lbtn" id="btn_resend2" href="javascript:void 0;" style="display: none;margin-top: 20px;"><?php echo __("website/sign/security-check-text5"); ?></a>
                </div>
            </div>

            <input type="hidden" name="action" value="location-verification">
            <input type="hidden" name="apply" value="selection">
        </form>


        <div class="notverification"><?php echo __("website/sign/security-check-text6",[
                '{link}' => $contact_link,
            ]); ?></a></div>
    </div>
</div>

<div id="wrapper">
    <div class="sepet">

        <div class="sepetleft">

            <div class="sepetbaslik">
                <div style="padding:0px 15px;">
                    <div class="yuzde70"><?php echo __("website/osteps/account"); ?></div>
                </div>
            </div>

            <div class="sepetlist">
                <div class="sepetlistcon">
                    <div class="userverification" style="display:block">

                        <div class="orderuserlogin">
                            <h2><?php echo __("website/osteps/account-desc"); ?></h2>


                            <form action="<?php echo $register_link; ?>?from=order_steps" method="post" id="SubmitStepAccount" enctype="multipart/form-data">
                                <?php echo Validation::get_csrf_token('sign'); ?>

                                <?php
                                    $contact_link = Controllers::$init->CRLink("contact");
                                ?>
                                <input checked type="radio" name="account_transaction" id="account-transaction-register" value="register" class="radio-custom">
                                <label class="radio-custom-label" for="account-transaction-register"><?php echo __("website/sign/up-title"); ?></label>

                                <input type="radio" name="account_transaction" id="account-transaction-login" value="login" class="radio-custom">
                                <label class="radio-custom-label" for="account-transaction-login"><?php echo __("website/sign/in-title"); ?></label>

                                <div class="clear"></div>

                                <script type="text/javascript">
                                    $(document).ready(function(){

                                        $("input[name=account_transaction]").change(function(){
                                            if($(this).val() === 'register'){
                                                $("#form_login_content").fadeOut(150,function(){
                                                    $("#form_register_content").fadeIn(150);
                                                    $("#SubmitStepAccount").attr("action","<?php echo $register_link; ?>?from=order_steps");
                                                    $("#form_forget_content input[name=email]").attr("disabled",true);
                                                    $("#form_login_content input[name=email]").attr("disabled",true);
                                                    $("#form_login_content input[name=password]").attr("disabled",true);
                                                    $("#form_register_content input[name=email]").removeAttr("disabled");
                                                    $("#form_register_content input[name=password]").removeAttr("disabled");
                                                });
                                            }else if($(this).val() === 'login'){
                                                $("#form_register_content").fadeOut(150,function(){
                                                    $("#form_login_content").fadeIn(150);
                                                    $("#SubmitStepAccount").attr("action","<?php echo $login_link; ?>?from=order_steps");
                                                    $("#form_forget_content input[name=email]").attr("disabled",true);
                                                    $("#form_register_content input[name=email]").attr("disabled",true);
                                                    $("#form_register_content input[name=password]").attr("disabled",true);
                                                    $("#form_login_content input[name=email]").removeAttr("disabled");
                                                    $("#form_login_content input[name=password]").removeAttr("disabled");
                                                });
                                            }
                                        });

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

                                        var reset = function() {
                                            telInput.removeClass("error");
                                        };
                                        telInput.on("keyup change",reset);
                                        telInput.blur(function() {
                                            reset();
                                            if($.trim(telInput.val())){
                                                if (telInput.intlTelInput("isValidNumber")) telInput.removeClass("error");
                                                else telInput.addClass("error");
                                            }
                                        });
                                    });

                                    function forget_password(){
                                        $("#form_login_content").fadeOut(150,function(){
                                            $("#form_forget_content").fadeIn(150);
                                            $("#SubmitStepAccount").attr("action","<?php echo $forget_password_link; ?>?from=order_steps");

                                            $("#form_forget_content input[name=email]").removeAttr("disabled");
                                            $("#form_login_content input[name=email]").attr("disabled",true);
                                            $("#form_register_content input[name=email]").attr("disabled",true);

                                        });
                                        $("#forget_active").val('1');
                                    }

                                    function login(){
                                        $("#forget_active").val('0');
                                        $("#form_forget_content").fadeOut(150,function(){
                                            $("#form_login_content").fadeIn(150);
                                            $("#SubmitStepAccount").attr("action","<?php echo $login_link; ?>?from=order_steps");
                                            $("#form_forget_content input[name=email]").attr("disabled",true);
                                            $("#form_login_content input[name=email]").removeAttr("disabled");
                                            $("#form_register_content input[name=email]").attr("disabled",true);

                                        });
                                    }
                                </script>

                                <div id="form_register_content">
                                    <?php
                                        $connectionButtons = Hook::run("ClientAreaConnectionButtons","register");
                                    ?>
                                    <?php if($kind_status): ?>
                                        <script type="text/javascript">
                                            $(document).ready(function(){
                                                $("input[name='kind']").change(function(){
                                                    var id = $(this).attr("id");
                                                    $(".kind-content").slideUp(100,function () {
                                                        $("."+id).slideDown(100);
                                                    });
                                                });

                                                $("input[name='kind']:checked").each(function () {
                                                    var id = $(this).attr("id");
                                                    $(".kind-content").slideUp(100,function () {
                                                        $("."+id).slideDown(100);
                                                    });
                                                });

                                            });
                                        </script>
                                    <?php endif; ?>


                                    <div id="contract1_modal" style="display: none;" data-izimodal-title="<?php echo htmlentities(__("website/sign/contract1-title"),ENT_QUOTES); ?>">
                                        <div class="padding20">
                                            <?php echo ___("constants/contract1"); ?>
                                        </div>
                                    </div>

                                    <div id="contract2_modal" style="display: none;" data-izimodal-title="<?php echo htmlentities(__("website/sign/contract2-title"),ENT_QUOTES); ?>">
                                        <div class="padding20">
                                            <?php echo ___("constants/contract2"); ?>
                                        </div>
                                    </div>

                                    <?php
                                        if($connectionButtons){
                                            ?>
                                            <div class="socialconnect">
                                                <?php
                                                    foreach($connectionButtons AS $button) echo $button;
                                                ?>

                                            </div>
                                            <?php
                                        }
                                    ?>
                                    <table width="100%" border="0" align="center">
                                        <tbody>

                                        <?php if($kind_status): ?>
                                            <tr>
                                                <td width="30%"><?php echo __("website/sign/up-form-kind"); ?></td>
                                                <td>
                                                    <div class="clearmob"></div>
                                                    <input id="kind_1" class="radio-custom" name="kind" value="individual" type="radio" checked>
                                                    <label for="kind_1" class="radio-custom-label" style="margin-right: 28px;"><span class="checktext"><?php echo __("website/sign/up-form-kind-1"); ?></span></label>

                                                    <input id="kind_2" class="radio-custom" name="kind" value="corporate" type="radio">
                                                    <label for="kind_2" class="radio-custom-label" style="margin-right: 28px;"><span class="checktext"><?php echo __("website/sign/up-form-kind-2"); ?></span></label>

                                                </td>
                                            </tr>
                                        <?php endif; ?>

                                        <tr>
                                            <td width="30%"><?php echo __("website/sign/up-form-full_name"); ?></td>
                                            <td><input name="full_name" type="text" placeholder=""></td>
                                        </tr>

                                        <tr>
                                            <td width="30%"><?php echo __("website/sign/up-form-email"); ?></td>
                                            <td><input name="email" type="email" placeholder="<?php echo ($email_verify_status) ? " ".__("website/sign/up-form-email-verify") : ''; ?>"></td>
                                        </tr>

                                        <?php if($gsm_status): ?>
                                            <tr>
                                                <td width="30%"><?php echo __("website/sign/up-form-gsm"); echo ($sms_verify_status) ? " ".__("website/sign/up-form-gsm-verify") : ''; ?></td>
                                                <td>
                                                    <input id="gsm" type="text" placeholder="" onkeypress="return event.charCode>= 48 &amp;&amp;event.charCode<= 57">
                                                </td>
                                            </tr>
                                        <?php endif; ?>


                                        <?php if($kind_status): ?>
                                            <tr class="kind-content kind_2" style="display:none;">
                                                <td width="30%"><?php echo __("website/sign/up-form-cname"); ?></td>
                                                <td>
                                                    <input name="company_name" type="text" placeholder="">
                                                </td>
                                            </tr>

                                            <?php if(Config::get("options/sign/up/kind/corporate/company_tax_number") || Config::get("options/sign/up/kind/corporate/company_tax_office")): ?>
                                                <tr class="kind-content kind_2" style="display:none;">
                                                    <td width="30%">
                                                        <?php echo  Config::get("options/sign/up/kind/corporate/company_tax_number") ? __("website/sign/up-form-ctaxno") : ''; ?>
                                                        <?php echo Config::get("options/sign/up/kind/corporate/company_tax_number") && Config::get("options/sign/up/kind/corporate/company_tax_office") ? " / " : ''; ?>
                                                        <?php echo Config::get("options/sign/up/kind/corporate/company_tax_office") ? __("website/sign/up-form-ctaxoff") : ''; ?></td>
                                                    <td>
                                                        <?php if(Config::get("options/sign/up/kind/corporate/company_tax_number")): ?>
                                                            <div class="yuzde50"><input name="company_tax_number" type="text"></div>
                                                        <?php endif; ?>
                                                        <?php if(Config::get("options/sign/up/kind/corporate/company_tax_office")): ?>
                                                            <div class="yuzde50"><input name="company_tax_office" type="text" id="vergi_dairesi"></div>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        <?php endif; ?>


                                        <tr>
                                            <td width="30%"><?php echo __("website/sign/up-form-password"); ?></td>
                                            <td>
                                                <input name="password" type="password">

                                            </td>
                                        </tr>

                                        <tr>
                                            <td width="30%"><?php echo __("website/sign/up-form-password_again"); ?></td>
                                            <td>
                                                <input name="password_again" type="password">
                                            </td>
                                        </tr>

                                        <tr>

                                            <td colspan="2" style="border:none">
                                                <input id="checkbox-5" class="checkbox-custom" name="contract" value="1" type="checkbox" required>
                                                <label for="checkbox-5" class="checkbox-custom-label"><span class="checktext"><?php echo str_replace("<br>","",__("website/sign/up-form-contract")); ?></span></label>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div id="form_login_content" style="display: none">
                                    <?php
                                        $connectionButtons = Hook::run("ClientAreaConnectionButtons","login");

                                        if($connectionButtons){
                                            ?>
                                            <div class="socialconnect">
                                                <?php
                                                    foreach($connectionButtons AS $button) echo $button;
                                                ?>

                                            </div>
                                            <?php
                                        }

                                    ?>
                                    <table width="100%" border="0" align="center">
                                        <tbody>

                                        <tr>
                                            <td width="30%"><?php echo __("website/sign/in-form-email"); ?></td>
                                            <td>
                                                <input disabled name="email" type="email" placeholder="" value="<?php echo DEMO_MODE ? 'demo@example.com' : ''; ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="30%"><?php echo __("website/sign/in-form-password"); ?></td>
                                            <td>
                                                <input disabled name="password" type="password" value="<?php echo DEMO_MODE ? 'demo' : ''; ?>">
                                            </td>
                                        </tr>

                                        <tr>
                                            <td width="30%"  style="border:none"></td>
                                            <td  style="border:none">

                                                <input id="checkbox-4" class="checkbox-custom" name="remember" value="1" type="checkbox" style="width:100px;">
                                                <label for="checkbox-4" class="checkbox-custom-label"><span class="checktext"><?php echo __("website/sign/in-form-remember"); ?></span></label>
                                                <a class="sifreunuttulink" href="javascript:void(0);" onclick="forget_password();"><?php echo __("website/sign/in-form-forget"); ?></a>

                                            </td>
                                        </tr>


                                        </tbody>
                                    </table>
                                </div>
                                <div id="form_forget_content" style="display: none">
                                    <table width="100%" border="0" align="center">
                                        <tbody>

                                        <tr>
                                            <td width="30%"><?php echo __("website/sign/in-form-email"); ?></td>
                                            <td>
                                                <input type="hidden" id="forget_active" name="forget_active" value="0">
                                                <input disabled name="email" type="text">
                                            </td>
                                        </tr>

                                        <tr>
                                            <td width="30%"  style="border:none"></td>
                                            <td  style="border:none">
                                                <a class="sifreunuttulink" href="javascript:void(0);" onclick="login();"><?php echo __("website/sign/forget-form-login"); ?></a>
                                            </td>
                                        </tr>


                                        </tbody>
                                    </table>
                                </div>


                                <div class="clear"></div>

                                <div align="center">
                                    <a href="javascript:void(0);" class="yesilbtn gonderbtn mio-ajax-submit" mio-ajax-options='{"result":"SubmitStepAccount_handler","waiting_text":"<?php echo addslashes(__("website/others/button1-pending")); ?>","progress_text":"<?php echo addslashes(__("website/others/button1-upload")); ?>"}'><strong><?php echo __("website/osteps/continue-button"); ?></strong></a>
                                </div>


                            </form>
                            <script type="text/javascript">
                                function SubmitStepAccount_handler(result) {
                                    if(result !== ''){
                                        var solve = getJson(result);
                                        if(solve !== false){
                                            if(solve.status === "error"){
                                                if(solve.for != undefined && solve.for != ''){
                                                    $("#SubmitStepAccount "+solve.for).focus();
                                                    $("#SubmitStepAccount "+solve.for).not(":disabled").attr("style","border-bottom:2px solid red; color:red;");
                                                    $("#SubmitStepAccount "+solve.for).change(function(){
                                                        $(this).removeAttr("style");
                                                    });
                                                }

                                                if(solve.message != undefined && solve.message !== '')
                                                    alert_error(solve.message,{timer:5000});
                                            }
                                            else if(solve.status === "two-factor"){

                                                if($("#two-factor-verification").css("display") !== "block")
                                                    open_modal("two-factor-verification");

                                                $('#two-factor-verification #countdown1').countdown(solve.expire)
                                                    .on('update.countdown', function(event){
                                                        var $this = $(this);
                                                        $this.html(event.strftime('%M:%S'));
                                                    })
                                                    .on('finish.countdown', function(event){
                                                        var $this = $(this);
                                                        $this.html(event.strftime('%M:%S'));
                                                        $("#two-factor-verification #btn_resend").fadeIn(500);
                                                    });

                                                $("#two-factor-verification #two_factor_phone").html(solve.phone);
                                                $("#two-factor-verification #btn_resend").fadeOut(500);

                                            }
                                            else if(solve.status === "location-verification"){

                                                if($("#location-verification").css("display") !== "block")
                                                    open_modal("location-verification");

                                                var s_method        = solve.selected_method;
                                                var methods         = solve.methods;

                                                $("#method_selections").css("display","none");
                                                $("#method_phone_con").css("display","none");
                                                $("#method_security_question_con").css("display","none");

                                                if(s_method === false){
                                                    $("#method_selections").css("display","block");
                                                }else if(s_method === "phone"){

                                                    $("#method_phone_con").css("display","block");
                                                    $('#location-verification #countdown2').countdown(solve.expire)
                                                        .on('update.countdown', function(event){
                                                            var $this = $(this);
                                                            $this.html(event.strftime('%M:%S'));
                                                        })
                                                        .on('finish.countdown', function(event){
                                                            var $this = $(this);
                                                            $this.html(event.strftime('%M:%S'));
                                                            $("#location-verification #btn_resend2").fadeIn(500);
                                                        });

                                                    $("#location-verification #phone_text").html(solve.phone);
                                                    $("#location-verification #btn_resend2").fadeOut(500);

                                                }else if(s_method == "security_question"){
                                                    $("#method_security_question_con").css("display","block");
                                                    $("#location-verification #security_question_text").html(solve.security_question);
                                                }
                                            }
                                            else if(solve.status === "successful" || solve.status === "sent"){
                                                if(solve.message !== undefined){
                                                    alert_success(solve.message,{timer:3000});
                                                    if(solve.redirect !== undefined){
                                                        setTimeout(function(){
                                                            window.location.href = solve.redirect;
                                                        },3000);
                                                    }
                                                }
                                                else if(solve.redirect !== undefined)
                                                    window.location.href = solve.redirect;
                                            }
                                        }else
                                            console.log(result);
                                    }
                                }
                            </script>

                        </div>

                    </div>

                </div>
            </div>


            <div class="paymentlogos">
                <img class="plogos1" src="<?php echo $tadress;?>images/credit-cards.png">
                <img class="plogos2" src="<?php echo $tadress;?>images/ssl-secure.svg">
                <div class="clear"></div>
                <span><?php echo __("website/basket/basketsecnotice"); ?></span>
            </div>

        </div>

        <div class="sepetright">
            <div class="sepetrightshadow">
                <div class="sepetbaslik">
                    <div style="padding:0px 12px;text-align:right;">
                        <?php echo __("website/basket/order-summary"); ?>
                    </div>
                </div>

                <div class="sepetrightcon" id="OrderSummaryContent" style="display: none;">

                    <table class="sepetsipinfo" width="100%" border="0">
                        <tr>
                            <td><strong><?php echo __("website/basket/total-order-amount"); ?></strong></td>
                            <td align="right"><h5 id="total-amount">0</h5></td>
                        </tr>

                        <tbody id="dealership_discounts"></tbody>

                        <tbody id="coupon_discounts" style="display: none;"></tbody>

                        <tr id="sendbta_select" style="display: none;">
                            <td><strong><?php echo __("website/basket/send-bill-to-address"); ?></strong></td>
                            <td align="right"><h5 id="sendbta_amount2"></h5></td>
                        </tr>

                        <tr id="pmethod_select" style="display: none;">
                            <td><strong id="pmethod_name"></strong></td>
                            <td align="right"><h5 id="pm_commission_amount"></h5></td>
                        </tr>

                        <tr id="tax_content" style="display:none;">
                            <td><strong id="tax-see"><?php echo __("website/basket/tax-amount"); ?></strong></td>
                            <td align="right"><h5 id="tax-amount">0</h5></td>
                        </tr>

                        <tr>
                            <td class="totalamountinfo" align="center" colspan="2">
                                <strong ><?php echo __("website/basket/total-amount-payable"); ?></strong><br>
                                <h5 id="total-amount-payable">0</h5>
                            </td>
                        </tr>

                    </table>



                    <div class="clear"></div>
                </div>

                <div class="clear"></div>

                <div id="OrderSummary_loader">
                    <div class="spinner"></div>
                    <div class="clear"></div>
                    <br>
                </div>
                <div class="clear"></div>

            </div>
            <br><a class="lbtn" href="<?php echo $links["basket"]; ?>"><i class="fa fa-angle-double-left" aria-hidden="true"></i> <?php echo __("website/basket/turn-back"); ?></a>

        </div>
    </div>
</div>