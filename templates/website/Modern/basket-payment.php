<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    $hoptions = [
        'page' => "basket-payment",
    ];
    $ipInfo = UserManager::ip_info();

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
                    if((int_balance==0 && total_payable !== 0) || total_payable < 0.00 || int_balance < total_payable){
                        open_modal("InsufficientBalance");
                    }else{
                        var text = '<?php echo str_replace("'",'&apos;',__("website/basket/balance-warning-text",[EOL => '\n'])); ?>';
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

                            if(solve.use_coupon !== undefined){
                                if(solve.use_coupon) $("#use_coupon").fadeIn(1);
                                else $("#use_coupon").fadeOut(1);
                            }else $("#use_coupon").fadeOut(1);


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

        function getCountries(){
            var local_cc = "<?php echo strtoupper($ipInfo ? $ipInfo["countryCode"] : ___("package/code")); ?>";
            var request = MioAjax({
                action: "<?php echo $links["bring-info"]."country-list"; ?>",
                method: "GET"
            },true,true);

            request.done(function(result){
                if(result){
                    var solve = getJson(result),content;
                    if(solve){
                        if(solve.status == "successful"){
                            $("#country_list").val('');
                            $(solve.data).each(function(key,item){
                                content = "<option value='"+item.id+"'";
                                content += ' data-code="'+item.code+'"';
                                content += "\n>";
                                content += item.name;
                                content += "</option>\n";
                                $("#country_list").append(content);
                            });

                            setTimeout(function(){
                                $("#country_list option[data-code="+local_cc+"]").attr("selected",true).trigger("change");
                            },500);

                        }
                    }else console.log(result);
                }else console.log("Countries list result is empty");
            });
        }
        function getCities(country){

            $("#addNewAddressForm select[name=city]").html('').css("display","none").attr("disabled",true);
            $("#addNewAddressForm input[name=city]").val('').css("display","block").attr("disabled",false);

            $("#addNewAddressForm select[name=counti]").html('').css("display","none").attr("disabled",true);
            $("#addNewAddressForm input[name=counti]").val('').css("display","block").attr("disabled",false);

            var request = MioAjax({
                action:"<?php echo $links["ac-info"];?>",
                method:"POST",
                data:{operation:"getCities",country:country},
            },true,true);

            request.done(function(result){
                if(result || result !== undefined){
                    if(result != ''){
                        var solve = getJson(result);
                        if(solve !== false){
                            if(solve.status == "successful"){
                                $("#addNewAddressForm select[name=city]").html('');
                                $("#addNewAddressForm select[name='city']").append($('<option>', {
                                    value: '',
                                    text: "<?php echo ___("needs/select-your"); ?>",
                                }));
                                $(solve.data).each(function (index,elem) {
                                    $("#addNewAddressForm select[name='city']").append($('<option>', {
                                        value: elem.id,
                                        text: elem.name
                                    }));
                                });
                                $("#addNewAddressForm select[name='city']").css("display","block").attr("disabled",false);
                                $("#addNewAddressForm input[name='city']").css("display","none").attr("disabled",true);
                            }else{
                                $("#addNewAddressForm select[name='city']").css("display","none").attr("disabled",true);
                                $("#addNewAddressForm input[name='city']").css("display","block").attr("disabled",false);
                                $("#addNewAddressForm input[name='city']").focus();
                            }
                        }else
                            console.log(result);
                    }
                }
            });
        }
        function getCounties(city){
            if(city !== ''){
                var request = MioAjax({
                    action:"<?php echo $links["ac-info"];?>",
                    method:"POST",
                    data:{operation:"getCounties",city:city},
                },true,true);

                request.done(function(result){
                    if(result || result != undefined){
                        if(result != ''){
                            var solve = getJson(result);
                            if(solve !== false){
                                if(solve.status == "successful"){
                                    $("#addNewAddressForm select[name=counti]").html('');
                                    $("#addNewAddressForm select[name='counti']").append($('<option>', {
                                        value: '',
                                        text: "<?php echo ___("needs/select-your"); ?>",
                                    }));
                                    $(solve.data).each(function (index,elem) {
                                        $("#addNewAddressForm select[name='counti']").append($('<option>', {
                                            value: elem.id,
                                            text: elem.name
                                        }));
                                    });
                                    $("#addNewAddressForm select[name=counti]").css("display","block").attr("disabled",false);
                                    $("#addNewAddressForm input[name=counti]").val('').css("display","none").attr("disabled",true);
                                }else{
                                    $("#addNewAddressForm select[name=counti]").css("display","none").attr("disabled",true);
                                    $("#addNewAddressForm input[name=counti]").val('').css("display","block").attr("disabled",false);
                                    $("#addNewAddressForm input[name='counti']").focus();
                                }
                            }else
                                console.log(result);
                        }
                    }
                });
            }
            else{
                $("#addNewAddressForm select[name=counti]").html('').css("display","none").attr("disabled",true);
                $("#addNewAddressForm input[name=counti]").val('').css("display","block").attr("disabled",false);
            }
        }
        function addNewAddress_submit(result) {
            if(result != ''){
                var solve = getJson(result);
                if(solve !== false){
                    if(solve.status == "error"){
                        if(solve.for != undefined && solve.for != ''){
                            $("#addNewAddressForm "+solve.for).focus();
                            $("#addNewAddressForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                            $("#addNewAddressForm "+solve.for).change(function(){
                                $(this).removeAttr("style");
                            });
                        }

                        if(solve.message != undefined && solve.message != ''){
                            $("#addNewAddressForm #FormOutput").fadeIn(200).html(solve.message);
                        }
                    }else if(solve.status == "successful"){
                        $("#addNewAddressForm #FormOutput").fadeOut(200).html('');
                        ReloadAddressList(solve.id);
                        OrderSummary();
                    }else
                        $("#addNewAddressForm #FormOutput").fadeOut(200).html('');
                }else
                    console.log(result);
            }
        }


        function ReloadAddressList(select_address){
            if(select_address) address = select_address;
            var request = MioAjax({
                action: "<?php echo $links["bring-info"]."address-list"; ?>",
                method: "GET"
            },true,true);

            request.done(function(result){
                if(result){
                    var solve = getJson(result),content;
                    if(solve){
                        if(solve.status == "successful"){
                            $("#bill_loader").fadeOut(100);
                            if(solve.data != undefined){
                                $("#noAddress,#newAddress").hide(1);
                                $("#haveAddress").fadeIn(1);
                                $("#address_list").html('');
                                $(solve.data).each(function(key,item){
                                    content = "<option value='"+item.id+"'";
                                    if(select_address != 0){
                                        if(select_address == item.id) content += " selected";
                                    }else{
                                        if(item.detouse == 1){
                                            address = item.id;
                                            content += " selected";
                                        }
                                    }
                                    content += "\n>";
                                    content += item.name+" ("+item.address_line+")";
                                    content += "</option>\n";
                                    $("#address_list").append(content);
                                });
                            }
                        }else if(solve.status == "error"){
                            $("#bill_loader,#haveAddress,#newAddress").hide(1);
                            $("#noAddress,#newAddress").fadeIn(1);
                        }
                    }else console.log(result);
                }else console.log("Address list result is empty");
            });
        }

        function balance_warning(response){
            if(response == "ok"){
                pay_ok = true;
                close_modal("BalanceWarning");
                OrderSummary("pay");
            }else{
                close_modal("BalanceWarning");
            }
        }

        function coupon_check(value){
            if(value != '' && value.length>=3){
                var request = MioAjax({
                    action: "<?php echo $links["bring"]."coupon-check"; ?>",
                    method: "POST",
                    data:{code:value}
                },true,true);

                request.done(function (result) {
                    if(result){
                        var solve = getJson(result);
                        if(solve){

                            if(solve.status == "error"){

                                $("#coupon_result").html(solve.message).fadeIn(200);

                            }else if(solve.status == "successful"){

                                $("#coupon_result").html('').fadeOut(1);
                                $("#kuponkodu").slideUp(400,function(){
                                    $("#coupon_code").val('');
                                    OrderSummary();
                                });
                            }else{
                                $("#coupon_result").html('').fadeOut(1);
                            }
                        }else{
                            $("#coupon_result").html('').fadeOut(1);
                            console.log(result);
                        }
                    }else{
                        $("#coupon_result").html('').fadeOut(1);
                        console.log("Coupon check result is empty");
                    }
                });
            }
        }

        $(document).ready(function(){

            $("#coupon_code").keyup(function(e){
                var ithis = this;
                var isBackspaceOrDelete = (e.keyCode == 8 || e.keyCode == 9 || e.keyCode == 46 || e.keyCode == 32);
                var check = isBackspaceOrDelete || (e.keyCode>=33 && e.keyCode < 254);
                var inputValue = $(ithis).val();
                if(inputValue.length<3) $("#coupon_result").html('').fadeOut(1);
                if(check && inputValue.length>=3){
                    var ithis = this;
                    var ie    = e;
                    setTimeout(function(){
                        coupon_check(inputValue);
                    },600);
                }
            });

            $("#coupon_code").bind("paste", function(e){
                var pastedData = e.originalEvent.clipboardData.getData('text');
                coupon_check(pastedData);
            });


            if(gGET("status") != null){
                var url = sGET("status",'');
                history.pushState(false, "", url);
            }

            $("#address_list").change(function(){
                address = $(this).val();
            });

            $("#address_list,#sendbta-checkbox").change(function(){
                OrderSummary();
            });

            $("#payment_methods").on("change","input[type='radio']",function(){
                OrderSummary();
            });

            setTimeout(function(){
                OrderSummary();
            });

            ReloadAddressList();
            getCountries();
        });
    </script>
<?php if(Filter::GET("status") == "success"): ?>
    <script>
        swal(
            '<?php echo __("website/account_invoices/successx"); ?>',
            '<?php echo __("website/account_invoices/success"); ?>',
            'success'
        )
    </script>

<?php elseif(Filter::GET("status") == "fail"): ?>
    <script>
        swal(
            '<?php echo __("website/account_invoices/errorx"); ?>',
            '<?php echo __("website/account_invoices/error2"); ?>',
            'error'
        )
    </script>
<?php endif; ?>
<div id="BalanceWarning" style="display: none;" data-izimodal-title="<?php echo __("website/basket/pay-button"); ?>">
        <div class="padding20">

            <center>
                <p></p>
                <div class="clear"></div>
                <div class="line"></div>
                <a href="javascript:balance_warning('ok');void 0;" class="gonderbtn yesilbtn"><?php echo __("website/basket/balance-warning-ok"); ?></a>
            </center>

        </div>
    </div>
<div id="InsufficientBalance" style="display: none;" data-izimodal-title="<?php echo __("website/basket/pay-button"); ?>">
        <div class="padding20">

            <center>
                <p><?php echo __("website/basket/insufficient-balance"); ?></p>
                <div class="clear"></div>
                <div class="line"></div>
                <a href="<?php echo $links["balance-page"]; ?>" class="gonderbtn yesilbtn"><?php echo __("website/basket/button-balance-page"); ?></a>
            </center>

        </div>
    </div>

<div id="wrapper">

    <div class="sepet">

        <div class="sepetleft">

            <div class="sepetbaslik">
                <div style="padding:0px 15px;">
                    <div class="yuzde70"><?php echo __("website/basket/invoice-information"); ?></div>
                </div>
            </div>


            <div class="sepetlist">
                <div class="sepetlistcon">
                    <div class="faturabilgisi">

                        <div id="bill_loader" style="margin-top: 10px; text-align: center;">
                            <div class="spinner"></div>
                        </div>

                        <div id="haveAddress" style="display:none;">
                            <a style="float:right;" href="javascript:$('#newAddress').slideToggle(200);void 0;"><strong><?php echo __("website/basket/add-new-address"); ?></strong></a>
                            <h5><strong><?php echo __("website/basket/defined-invoice-address"); ?></strong></h5>
                            <select name="billing_address" id="address_list"></select>
                        </div>

                        <div id="noAddress" style="display:none;">
                            <h5><?php echo __("website/basket/no-address"); ?></h5>
                            <br>
                        </div>

                        <div id="newAddress" style="display:none;">
                            <br>
                            <h3><?php echo __("website/basket/add-new-address2"); ?></h3>
                            <div class="line"></div>
                            <form action="<?php echo $links["ac-info"]; ?>" method="post" id="addNewAddressForm">
                                <?php echo Validation::get_csrf_token('account'); ?>
                                
                                <input type="hidden" name="operation" value="addNewAddress">
                                <table width="100%" border="0">
                                    <tr>
                                        <td colspan="2">

                                            <div class="yuzde30">
                                                <strong><?php echo __("website/account_info/country"); ?></strong>
                                                <select name="country" id="country_list" onchange="getCities(this.options[this.selectedIndex].value);">
                                                    <option value=""><?php echo __("website/account_info/select-your"); ?></option>
                                                </select>
                                            </div>

                                            <div id="cities" class="yuzde30">
                                                <strong><?php echo __("website/account_info/city"); ?></strong>
                                                <select name="city" onchange="getCounties($(this).val());" disabled style="display: none;"></select>
                                                <input type="text" name="city" placeholder="<?php echo __("website/account_info/city-placeholder"); ?>">
                                            </div>
                                            <div id="counti" class="yuzde25">
                                                <strong><?php echo __("website/account_info/counti"); ?></strong>
                                                <select name="counti" disabled style="display: none;"></select>
                                                <input type="text" name="counti" placeholder="<?php echo __("website/account_info/counti-placeholder"); ?>">
                                            </div>

                                            <div id="zipcode" class="yuzde15">
                                                <strong><?php echo __("website/account_info/zipcode"); ?></strong>
                                                <input name="zipcode" type="text" placeholder="<?php echo __("website/account_info/zipcode-placeholder"); ?>">
                                            </div>

                                            <div id="address" style="width:100%;margin-top:15px;">
                                                <strong><?php echo __("website/account_info/address"); ?></strong>
                                                <input name="address" type="text" placeholder="<?php echo __("website/account_info/address-placeholder"); ?>">
                                            </div>


                                        </td>
                                    </tr>
                                </table>
                                <a href="javascript:void(0);" class="yesilbtn gonderbtn mio-ajax-submit" mio-ajax-options='{"waiting_text":"<?php echo addslashes(__("website/others/button1-pending")); ?>","result":"addNewAddress_submit"}'><?php echo __("website/account_info/add-address-submit-button"); ?></a>
                                <div id="FormOutput" class="error" style="display: none; margin-top: 10px; text-align: center;"></div>
                            </form>
                        </div>

                        <div class="clear"></div>
                        <div id="sendbta" style="display: none">
                            <br>
                            <input id="sendbta-checkbox" class="checkbox-custom" name="sendbta" value="1" type="checkbox">
                            <label for="sendbta-checkbox" class="checkbox-custom-label"><strong><?php echo __("website/basket/sendbta"); ?></strong> <span id="sendbta_amount">0</span></label>
                        </div>

                    </div>
                    <div class="clear"></div>
                </div>

            </div>



            <div class="sepetbaslik">
                <div style="padding:0px 15px;">
                    <div class="uhinfo"><?php echo __("website/basket/payment-method"); ?></div>
                </div>
            </div>


            <div class="sepetlist">
                <div class="sepetlistcon">
                    <div id="pmethods_loader" style="margin-top: 10px; text-align: center;">
                        <div class="spinner"></div>
                    </div>
                    <div id="no_address_selected" style="display:none; text-align: center;" class="error"><?php echo __("website/basket/no-address-selected"); ?></div>
                    <div id="payment_methods" style="display:none;"></div>

                    <div class="clear"></div>
                </div>
            </div>

            <div class="sepetbaslik">
                <div style="padding:0px 15px;">
                    <div class="uhinfo"><?php echo __("website/basket/contracts"); ?></div>
                </div>
            </div>
            <div class="sepetlist">
                <div class="sepetlistcon">
                    <div id="pmethods_loader" style="margin-top: 10px; text-align: center; display: none;">
                        <div class="spinner"></div>
                    </div>

                    <input id="contract1" class="checkbox-custom" value="1" type="checkbox">
                    <label for="contract1" class="checkbox-custom-label"><?php echo __("website/basket/contract1"); ?></label>
                    <div class="clear"></div>
                    <input id="contract2" class="checkbox-custom" value="1" type="checkbox">
                    <label for="contract2" class="checkbox-custom-label"><?php echo __("website/basket/contract2"); ?></label>

                    <div class="clear"></div>
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

                        <tr id="use_coupon" style="display: none;">
                            <td colspan="2" align="center">
                                <a href="javascript:$('#kuponkodu').slideToggle();void 0"><i class="fa fa-ticket" aria-hidden="true"></i> <?php echo __("website/basket/use-coupon-code"); ?></a>
                                <div class="kuponkodu" id="kuponkodu" style="display: none; transition-property: all; transition-duration: 0s; transition-timing-function: ease; opacity: 1;">
                                    <input id="coupon_code" name="coupon_code" type="text" placeholder="<?php echo __("website/basket/coupon-code-pholder"); ?>" onchange="coupon_check($(this).val());">
                                    <div style="text-align: center; margin-top: 5px; display: none;" class="error" id="coupon_result"></div>
                                </div>
                            </td>
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
            <a href="javascript:OrderSummary('pay'); void 0" style="display: none" class="gonderbtn" id="pay_button"><?php echo __("website/basket/continue-button"); ?></a>
            <a class="graybtn gonderbtn" id="block_button" style="display:none;background: #CCCCCC; cursor: no-drop;"><?php echo __("website/basket/continue-button"); ?></a>
            <div class="clear"></div>
            <div id="pay_result" class="error" style="text-align: center; margin-top: 5px; display: none;"></div>

            <br><a class="lbtn" href="<?php echo $links["basket"]; ?>"><i class="fa fa-angle-double-left" aria-hidden="true"></i> <?php echo __("website/basket/turn-back"); ?></a>

        </div>
    </div>
</div>

<div id="contract1_modal" style="display: none;" data-izimodal-title="<?php echo htmlentities(__("website/basket/contract1-title"),ENT_QUOTES); ?>">
    <div class="padding20">
        <?php echo ___("constants/contract1"); ?>
    </div>
</div>

<div id="contract2_modal" style="display: none;" data-izimodal-title="<?php echo htmlentities(__("website/basket/contract2-title"),ENT_QUOTES); ?>">
    <div class="padding20">
        <?php echo ___("constants/contract2"); ?>
    </div>
</div>