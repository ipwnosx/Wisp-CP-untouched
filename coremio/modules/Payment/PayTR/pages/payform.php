<?php

    if($module->config["settings"]["payment_type"] == "direct")
    {
        $stored_cards       = $checkout["data"]["type"] != "card-identification" ? $module->stored_cards($checkout) : [];

        ?>
        <script type="text/javascript">
            $(document).ready(function(){ 

                $("#payment-screen-content").next('.clear').remove();
                $("#payment-screen-content").next('.lbtn').css("margin-top","20px");

                <?php if($checkout["data"]["type"] == "pay"): ?>
                let back_btn = $("<div />").append($(".sepetrightshadow").next("br").next(".lbtn").clone()).html();
                $(".sepetrightshadow").next("br").next(".lbtn").after($("#payBtns").html() + '<div class="clear"></div><br>' + back_btn);
                $(".sepetrightshadow").next("br").next(".lbtn").remove();
                $(".sepetrightshadow").next("br").remove();
                $("#payBtns").remove();
                <?php endif; ?>

                let
                    card = document.querySelector('.card'),
                    ccNameInput   = document.querySelector('#i_card_name'),
                    ccNumberInput = document.querySelector('#i_card_num'),
                    cacheNumInt   = '',
                    ccNumberPattern = /^\d{0,16}$/g,
                    ccNumberSeparator = " ",
                    ccNumberInputOldValue,
                    ccNumberInputOldCursor,
                    ccExpiryInput = document.querySelector('#i_card_expiry'),
                    ccExpiryPattern = /^\d{0,4}$/g,
                    ccExpirySeparator = "/",
                    ccExpiryInputOldValue,
                    ccExpiryInputOldCursor,
                    ccCVCInput = document.querySelector('#i_card_cvc'),
                    ccCVCPattern = /^\d{0,3}$/g,
                    mask = (value, limit, separator) => {
                        var output = [];
                        for (let i = 0; i < value.length; i++) {
                            if ( i !== 0 && i % limit === 0) {
                                output.push(separator);
                            }

                            output.push(value[i]);
                        }

                        return output.join("");
                    },
                    unmask = (value) => value.replace(/[^\d]/g, ''),
                    checkSeparator = (position, interval) => Math.floor(position / (interval + 1)),
                    ccNumberInputKeyDownHandler = (e) => {
                        let el = e.target;
                        ccNumberInputOldValue = el.value;
                        ccNumberInputOldCursor = el.selectionEnd;
                    },
                    binChecker = (value) => {
                        let numberArr =  value.split(" ");
                        let numberCount = numberArr.length;
                        let numberHTML = '';

                        for(let i = 0; i<=3; i++)
                        {
                            if(typeof numberArr[i] === "string")
                            {
                                let numberString    = numberArr[i];
                                numberString += '•'.repeat(4 - numberString.length);
                                numberHTML +=  '<h5>'+numberString+'</h5>';
                            }
                            else
                            {
                                numberHTML += '<h5>••••</h5>';
                            }
                        }
                        $("#card_number").html(numberHTML);

                        let numInt  = value.replace(" ","");

                        if((numInt.length === 6 || numInt.length >= 18 && cacheNumInt !== numInt) || parseInt($("#stored_card").val()) !== 0)
                        {
                            cacheNumInt = numInt;
                            let request = MioAjax({
                                action:"<?php echo $module->links["getBin"]; ?>",
                                method: "POST",
                                data:{
                                    identification  : <?php echo $checkout["data"]["type"] == "card-identification" ? 1 : 0; ?>,
                                    chid            : '<?php echo $checkout["id"]; ?>',
                                    number          : numInt,
                                    stored_card     : $("#stored_card").val()
                                }
                            },true,true);
                            request.done(function(result){
                                if(result !== ''){
                                    var solve = getJson(result);
                                    if(solve !== false){
                                        if(solve.status === "error")
                                        {
                                            alert_error(solve.message,{timer:3000});

                                            if(numInt.length >= 18)
                                            {
                                                $("#continue_go").css("display","block");
                                                $("#continue_block").css("display","none");
                                                $("#savedcard_wrap").css("display","none");
                                                $("#savedcard").prop('checked',false);
                                            }
                                            else
                                            {
                                                $("#continue_go").css("display","none");
                                                $("#continue_block").css("display","block");
                                            }
                                        }
                                        else if(solve.status === "successful")
                                        {
                                            let img_url = '<?php echo APP_URI; ?>/resources/assets/images/creditcardlogos/';
                                            let bank_logo_img = '';

                                            if(solve.card_type === "debit")
                                            {
                                                if(solve.bank_name.match(/kredi/i))
                                                    bank_logo_img = img_url + 'yapikredi.png';
                                                else if(solve.bank_name.match(/Akbank/i))
                                                    bank_logo_img = img_url + 'akbank.png';
                                                else if(solve.bank_name.match(/İş Bank/i))
                                                    bank_logo_img = img_url + 'isbankasi.png';
                                                else if(solve.bank_name.match(/Finansbank/i))
                                                    bank_logo_img = img_url + 'finansbank.png';
                                                else if(solve.bank_name.match(/Halkbank/i))
                                                    bank_logo_img = img_url + 'halkbank.png';
                                                else if(solve.bank_name.match(/HSBC/i))
                                                    bank_logo_img = img_url + 'HSBC.png';
                                                else if(solve.bank_name.match(/Ziraat/i))
                                                    bank_logo_img = img_url + 'ziraat-bankasi.png';
                                                else if(solve.bank_name.match(/Garanti/i))
                                                    bank_logo_img = img_url + 'garanti.png';
                                                $("#cardauto").prop('checked',false);

                                                $("#cardauto_wrap").css("display","none");

                                                if(parseInt($("#stored_card_ctoken").val()) === 0)
                                                    $("#savedcard_wrap").css("display","block");
                                            }
                                            else
                                            {
                                                if(solve.bank_name.match(/kredi/i))
                                                    bank_logo_img = img_url + 'world-yapikredi.png';
                                                else if(solve.bank_name.match(/Akbank/i))
                                                    bank_logo_img = img_url + 'axess-akbank.png';
                                                else if(solve.bank_name.match(/İş Bank/i))
                                                    bank_logo_img = img_url + 'maximum-isbankasi.png';
                                                else if(solve.bank_name.match(/Finansbank/i))
                                                    bank_logo_img = img_url + 'cardfinans-finansbank.png';
                                                else if(solve.bank_name.match(/Halkbank/i))
                                                    bank_logo_img = img_url + 'paraf-halkbank.png';
                                                else if(solve.bank_name.match(/HSBC/i))
                                                    bank_logo_img = img_url + 'advantage-HSBC.png';
                                                else if(solve.bank_name.match(/Ziraat/i))
                                                    bank_logo_img = img_url + 'bankkart-ziraat.png';
                                                else if(solve.bank_name.match(/Garanti/i))
                                                    bank_logo_img = img_url + 'bonus-garanti.png';

                                                $("#cardauto_wrap").css("display","block");

                                                if(parseInt($("#stored_card_ctoken").val()) === 0)
                                                    $("#savedcard_wrap").css("display","block");
                                            }

                                            if(bank_logo_img === '')
                                            {
                                                $("#bank_logo").css("display","none");
                                                $("#bank_logo_t").css("display","block").html(solve.bank_name);
                                            }
                                            else
                                            {
                                                $("#bank_logo_t").css("display","none");
                                                $("#bank_logo").css("display","block").attr('src',bank_logo_img);
                                            }
                                            let schema_img = '';

                                            $("#i_card_cvc").attr("maxlength","3");

                                            if(solve.schema.match(/visa/i))
                                                schema_img = img_url + 'visa.png';
                                            else if(solve.schema.match(/master/i))
                                                schema_img = img_url + 'mastercard.png';
                                            else if(solve.schema.match(/express/i) || solve.schema.match(/amex/i))
                                            {
                                                schema_img = img_url + 'american-express.png';
                                                $("#i_card_cvc").attr("maxlength","4");
                                            }
                                            else if(solve.schema.match(/discover/i))
                                                schema_img = img_url + 'Discover.png';
                                            else if(solve.schema.match(/diners/i))
                                                schema_img = img_url + 'Diners-Club.png';
                                            else if(solve.schema.match(/jcb/i))
                                                schema_img = img_url + 'JCB.png';
                                            else if(solve.schema.match(/union/i))
                                                schema_img = img_url + 'UnionPay.png';
                                            else if(solve.schema.match(/troy/i))
                                                schema_img = img_url + 'troy-logo.png';

                                            if(schema_img === '')
                                                $('#card_type').css("display","none");
                                            else
                                            {
                                                $("#card_type").attr("src",schema_img);
                                                $("#card_type").attr("alt",solve.schema);
                                                $("#card_type").css("display","block");
                                            }
                                            $('#bank_name').html(solve.bank_name);

                                            if(typeof solve.installments !== "undefined")
                                            {
                                                let tbody_data = '';
                                                tbody_data +=
                                                    '<tr>' +
                                                    '<td>' +
                                                    '<input id="installment_0" class="radio-custom" name="installment" value="0" type="radio" data-tp="'+solve.total_payable+'" data-tp-uf="'+solve.total_payable_uf+'" checked>\n' +
                                                    '<label for="installment_0" class="radio-custom-label"><span class="checktext"><strong><?php echo $module->lang["card-tx21"]; ?></strong></span></label>'+
                                                    '</td>'+
                                                    '<td align="center">'+solve.total_payable+'</td>'+
                                                    '<td align="center">'+solve.total_payable+'</td>'+
                                                    '</tr>'
                                                ;
                                                let rate0 = '';
                                                $(solve.installments).each(function(){
                                                    rate0 = '';

                                                    if(this.rate < 1)
                                                        rate0 = '<span class="noinstallmentcomm"><?php echo $module->lang["card-tx23"]; ?></span>';

                                                    tbody_data +=
                                                        '<tr>'+
                                                        '<td>'+
                                                        '<input id="installment_'+this.quantity+'" class="radio-custom" name="installment" value="'+this.quantity+'" type="radio" data-tp="'+this.total_fee+'" data-tp-uf="'+this.total_fee_uf+'">' +
                                                        '<label for="installment_'+this.quantity+'" class="radio-custom-label"><span class="checktext"><strong>'+this.quantity+' <?php echo $module->lang["card-tx22"]; ?></strong></span>'+rate0+'</label>'+

                                                        '</td>'+
                                                        '<td align="center">'+this.fee+'</td>'+
                                                        '<td align="center">'+this.total_fee+'</td>'+
                                                        '</tr>'
                                                    ;

                                                });
                                                $("#installments_tbody").html(tbody_data);
                                                $("#installments").css("display","block");
                                            }
                                            else
                                                $("#installments").css("display","none");

                                            $("#continue_go").css("display","block");
                                            $("#continue_block").css("display","none");
                                        }
                                    }else
                                        console.log(result);
                                }
                            });
                        }
                    },
                    ccNumberInputHandler = (e) => {
                        let el = e.target,
                            newValue = unmask(el.value),
                            newCursorPosition;

                        if ( newValue.match(ccNumberPattern) ) {
                            newValue = mask(newValue, 4, ccNumberSeparator);

                            newCursorPosition =
                                ccNumberInputOldCursor - checkSeparator(ccNumberInputOldCursor, 4) +
                                checkSeparator(ccNumberInputOldCursor + (newValue.length - ccNumberInputOldValue.length), 4) +
                                (unmask(newValue).length - unmask(ccNumberInputOldValue).length);

                            el.value = (newValue !== "") ? newValue : "";
                        } else {
                            el.value = ccNumberInputOldValue;
                            newCursorPosition = ccNumberInputOldCursor;
                        }

                        el.setSelectionRange(newCursorPosition, newCursorPosition);
                        binChecker(el.value);
                    },
                    ccExpiryInputKeyDownHandler = (e) => {
                        let el = e.target;
                        ccExpiryInputOldValue = el.value;
                        ccExpiryInputOldCursor = el.selectionEnd;
                    },
                    ccExpiryInputHandler = (e) => {
                        let el = e.target,
                            newValue = el.value;

                        newValue = unmask(newValue);
                        if ( newValue.match(ccExpiryPattern) ) {
                            newValue = mask(newValue, 2, ccExpirySeparator);
                            el.value = newValue;
                        } else {
                            el.value = ccExpiryInputOldValue;
                        }
                        $("#card_expiry").html(el.value);
                    },
                    ccCVCInputKeyDownHandler = (e) => {},
                    ccCVCInputHandler = (e) => {
                        let el = e.target;
                        $("#card_cvc").html(el.value);
                    },
                    ccNameInputKeyDownHandler = (e) => {},
                    ccNameInputHandler = (e) => {
                        let el = e.target;
                        el.value =  el.value.replace("i","İ");
                        el.value =  el.value.toUpperCase().replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, '');
                        $("#card_name").html(el.value);
                    };

                ccNumberInput.addEventListener('keydown', ccNumberInputKeyDownHandler);
                ccNumberInput.addEventListener('change', ccNumberInputKeyDownHandler);
                ccNumberInput.addEventListener('input', ccNumberInputHandler);

                ccExpiryInput.addEventListener('keydown', ccExpiryInputKeyDownHandler);
                ccExpiryInput.addEventListener('change', ccExpiryInputKeyDownHandler);
                ccExpiryInput.addEventListener('input', ccExpiryInputHandler);

                ccCVCInput.addEventListener('keydown',ccCVCInputKeyDownHandler);
                ccCVCInput.addEventListener('change',ccCVCInputKeyDownHandler);
                ccCVCInput.addEventListener('input',ccCVCInputHandler);

                ccNameInput.addEventListener('keydown',ccNameInputKeyDownHandler);
                ccNameInput.addEventListener('change',ccNameInputKeyDownHandler);
                ccNameInput.addEventListener('input',ccNameInputHandler);
                card.addEventListener( 'click', function() {
                    card.classList.toggle('is-flipped');
                });
                ccCVCInput.onblur = function() {
                    card.classList.remove('is-flipped');
                };
                ccCVCInput.onfocus = function() {
                    card.classList.add('is-flipped');
                };

                $("#installments_tbody").on('change','input[name=installment]',function(){
                    let total_payable       = $(this).attr("data-tp");
                    let total_payable_uf    = $(this).attr("data-tp-uf");
                    $("#total_fee").html(total_payable);
                    let i_c =  $("<div />").append($("#total-amount-payable .amount_spot_view i").clone()).html();
                    $("#total-amount-payable .amount_spot_view").html(i_c + ' '+total_payable_uf);
                });

                $("#continue_go").click(function(){
                    if($(this).attr("data-pending") === "true") return false;
                    $(this).attr("data-pending","true");
                    let btn     = $(this);
                    let btn_b   = $(this).html();
                    $(this).html('<i class="fa fa-spinner" style="-webkit-animation:fa-spin 2s infinite linear;animation: fa-spin 2s infinite linear;"></i> <?php echo __("website/others/button1-pending"); ?>');

                    let request = MioAjax({
                        action:"<?php echo $module->links["generateForm"]; ?>",
                        method: "POST",
                        data: {
                            identification  : <?php echo $checkout["data"]["type"] == "card-identification" ? 1 : 0; ?>,
                            chid            : '<?php echo $checkout["id"]; ?>',
                            card_num        : $("#i_card_num").val(),
                            card_name       : $("#i_card_name").val(),
                            card_expiry     : $("#i_card_expiry").val(),
                            card_cvc        : $("#i_card_cvc").val(),
                            installment     : $("input[name=installment]:checked").val(),
                            save_card       : $("#savedcard").prop('checked') ? 1 : 0,
                            auto_card       : $("#cardauto").prop('checked') ? 1 : 0,
                            ok_url          : "<?php echo $links["successful-page"]; ?>",
                            fail_url        : "<?php echo $links["failed-page"]; ?>",
                            stored_card     : $("#stored_card").val(),
                            ctoken          : $("#stored_card_ctoken").val()
                        }
                    },true,true);
                    request.done(function(result){
                        btn.attr("data-pending","false").html(btn_b);
                        if(result !== ''){
                            var solve = getJson(result);
                            if(solve !== false){
                                if(solve.status === "error")
                                    alert_error(solve.message,{timer:3000});
                                else if(solve.status === "successful")
                                {
                                    let formElements = '';
                                    btn.html('<i class="fa fa-spinner" style="-webkit-animation:fa-spin 2s infinite linear;animation: fa-spin 2s infinite linear;"></i> <?php echo __("website/others/button1-pending"); ?>');
                                    let keys = Object.keys(solve.data)
                                    let keys_count = keys.length -1;
                                    for(let i = 0; i<= keys_count; i++){
                                        let k = keys[i];
                                        let v = solve.data[k];
                                        formElements += '<input type="hidden" name="'+k+'" value="'+v+'">';
                                        formElements += "\n";
                                    }
                                    $("#PAYTR_redirect_form").html(formElements).submit();
                                }
                            }else
                                console.log(result);
                        }
                    });
                });

                $("#select_stored_card").change(function(){
                    let opt     = $('option:selected',$(this));
                    let val     = $(this).val();
                    let ct      = opt.data("ctoken");

                    if(val === 'new')
                    {
                        $("#stored_card").val('0');
                        $("#stored_card_ctoken").val('');

                        $(ccNumberInput).val('').removeAttr("readonly");
                        $(ccNameInput).val('').removeAttr("readonly");
                        $(ccExpiryInput).val('').removeAttr("readonly");
                        $(ccCVCInput).val('').removeAttr("readonly");

                        $("#savedcard_wrap").css("display","block");

                        $("#installments_tbody").html('');
                        $("#installments").css("display","none");
                        $("#bank_logo").css("display","none");
                        $("#bank_logo").css("display","none");
                        $("#card_type").css("display","none");
                        $("#card_number").html('<h5>••••</h5><h5>••••</h5><h5>••••</h5><h5>••••</h5>');
                        $("#card_expiry").html('••/••');
                        $("#card_cvc").html('•••');
                        $("#card_name").html('');
                        $("#bank_name").html('');

                        if(ccNumberInput.value.length > 1)
                        {
                            $("#continue_block").css("display","none");
                            $("#continue_go").css("display","block");
                        }
                        else
                        {
                            $("#continue_block").css("display","block");
                            $("#continue_go").css("display","none");
                        }
                    }
                    else
                    {
                        $("#stored_card").val(val);
                        $("#stored_card_ctoken").val(ct);

                        $(ccNumberInput).val('•••• •••• •••• '+opt.data("ln4")).attr("readonly",true);
                        $(ccNameInput).val(opt.data("name")).attr("readonly",true);
                        $(ccExpiryInput).val(opt.data("expirym")+'/'+opt.data("expiryy")).attr("readonly",true);

                        if(parseInt(opt.data("requirecvc")) === 1)
                            $(ccCVCInput).val('').removeAttr("readonly");
                        else
                            $(ccCVCInput).val('•••').attr("readonly",true);

                        $("#card_name").html(opt.data("name"));
                        $("#card_expiry").html(opt.data("expirym")+'/'+opt.data("expiryy"));

                        $("#savedcard_wrap").css("display","none");
                        $("#savedcard").prop('checked',false);

                        binChecker(ccNumberInput.value);

                    }

                });

            });
        </script>

        <div class="creditcardpaypage">

            <div class="securityinfo">

                <div class="securityinfo-con">

                    <div class="securityinfo-left">
                        <i class="fa fa-shield" aria-hidden="true"></i>
                    </div>

                    <div class="securityinfo-right">
                        <h5><?php echo $module->lang["card-tx1"]; ?></h5>
                        <ul>
                            <li><?php echo $module->lang["card-tx2"]; ?> </li>
                            <li><?php echo $module->lang["card-tx3"]; ?></li>
                            <li><?php echo $module->lang["card-tx4"]; ?></li>
                        </ul>
                    </div>

                </div>
            </div>


             <div class="clear"></div>


            <div class="creditcardinfo">
                <div class="creditcardinfo-con">
                    <?php
                        if($stored_cards && $checkout["data"]["type"] != "card-identification")
                        {
                            ?>
                            <div class="my-registered-cards">
                                <h5><?php echo $module->lang["card-tx15"]; ?></h5>
                                <p><?php echo $module->lang["card-tx16"]; ?></p>
                                <select id="select_stored_card">
                                    <option value="new">+ <?php echo $module->lang["card-tx17"]; ?></option>
                                    <?php
                                        foreach($stored_cards AS $stored_card)
                                        {
                                            ?>
                                            <option value="<?php echo $stored_card["id"]; ?>" data-ctoken="<?php echo $stored_card["token"]["ctoken"]; ?>" data-ln4="<?php echo $stored_card["ln4"]; ?>" data-name="<?php echo $stored_card["name"]; ?>" data-expirym="<?php echo $stored_card["expiry_month"]; ?>" data-expiryy="<?php echo $stored_card["expiry_year"]; ?>" data-requirecvc="<?php echo $stored_card["require_cvc"]; ?>">**** **** **** <?php echo $stored_card["ln4"]; ?> - <?php echo $stored_card["name"]; ?> - <?php echo $stored_card["bank_name"]; ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                            <?php
                        }
                    ?>
                    <div class="creditcardform-con">
                        <input type="hidden" id="stored_card" value="0">
                        <input type="hidden" id="stored_card_ctoken" value="">

                        <div class="creditcardinfo-left">
                            <label>
                                <span class="kinfo"><?php echo $module->lang["card-tx5"]; ?></span>
                                <input inputmode="numeric" name="card_num" id="i_card_num" placeholder="••••  ••••  ••••  ••••" type="text" value="">
                            </label>
                            <label>
                                <span class="kinfo"><?php echo $module->lang["card-tx6"]; ?></span>
                                <input name="card_name" id="i_card_name" placeholder="<?php echo $module->lang["card-tx18"]; ?>" type="text" value="">
                            </label>
                            <div class="yuzde50">
                                <label >
                                    <span class="kinfo"><?php echo $module->lang["card-tx7"]; ?></span>
                                    <input inputmode="numeric" name="card_expiry" id="i_card_expiry" placeholder="<?php echo $module->lang["card-tx19"]; ?>" type="text" value="">
                                </label></div>
                            <div class="yuzde50">
                                <label class="yuzde50">
                                    <span class="kinfo"><?php echo $module->lang["card-tx8"]; ?> <a data-tooltip="<?php echo $module->lang["card-tx9"]; ?>"> <i style="margin-left: 10px;" class="fa fa-info-circle" aria-hidden="true"></i></a></span>
                                    <input inputmode="numeric" name="card_cvc" id="i_card_cvc" placeholder="CVC/CVV" type="text" maxlength="3" value="" onkeypress='return event.charCode>= 48 &&event.charCode<= 57'>
                                </label>
                            </div>

                        </div>




                        <div class="creditcardinfo-right">

                            <div class="scene scene--card">
                                <div class="card">
                                    <div class="card__face card__face--front">
                                        <div class="creditcardbox">
                                            <div class="creditcardbox-con">
                                                <img class="banklogo" id="bank_logo" src="#" alt="" style="display: none;">
                                                <div class="banknologo" id="bank_logo_t" style="display: none;">Bank Name</div>

                                                <img class="visamaster" id="card_type" src="<?php echo APP_URI; ?>/resources/assets/images/creditcardlogos/visa.png" alt="Visa" style="display: none;">

                                                <img class="cardchip" src="<?php echo APP_URI; ?>/resources/assets/images/creditcardlogos/chipicon.png" alt="">
                                                <div class="creditcardbox-numbers" id="card_number"><h5>••••</h5><h5>••••</h5><h5>••••</h5><h5>••••</h5></div>
                                                <div class="creditcardbox-validdate" id="card_expiry">••/••</div>
                                                <div class="creditcardbox-fullname" id="card_name"> </div>
                                                <div class="clear"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card__face card__face--back">

                                        <div class="creditcardbox">
                                            <div class="creditcardbox-behind-bank-brand" id="bank_name"> </div>
                                            <div class="creditcardbox-band"></div>
                                            <div class="creditcardbox-CCW"><span>xxxx - <strong id="card_cvc">***</strong></span></div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>


                        <div class="yuzde100" style="font-weight:600;">

                            <?php if($module->config["settings"]["save_card"] && $checkout["data"]["type"] != "card-identification"): ?>
                                <div id="savedcard_wrap">
                                    <input id="savedcard" class="checkbox-custom" name="card_storage" value="1" type="checkbox">
                                    <label style="padding:0;" for="savedcard" class="checkbox-custom-label"><span class="checktext"><?php echo $module->lang["card-tx10"]; ?> </span></label>
                                </div>
                            <?php endif; ?>
                            <div class="clear"></div>

                            <?php if($module->config["settings"]["auto_pay"] && $checkout["data"]["type"] != "card-identification"): ?>
                                <div id="cardauto_wrap">
                                    <input id="cardauto" class="checkbox-custom" name="auto_payment" value="1" type="checkbox">
                                    <label for="cardauto" class="checkbox-custom-label"><span class="checktext"><?php echo $module->lang["card-tx11"]; ?></span><br>
                                        <span class="kinfo"><?php echo $module->lang["card-tx20"]; ?></span></label>
                                </div>
                            <?php endif; ?>
                        </div>

                    </div>

                    <div class="installment-options" id="installments" style="display: none;">

                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <thead>
                            <tr>
                                <td><h5><strong><?php echo $module->lang["card-tx12"]; ?></strong></h5></td>
                                <td align="center"><strong><?php echo $module->lang["card-tx13"]; ?></strong></td>
                                <td align="center"><strong><?php echo $module->lang["card-tx14"]; ?></strong></td>
                            </tr>
                            </thead>
                            <tbody id="installments_tbody"></tbody>
                        </table>
                    </div>


                    <?php
                        if($checkout["data"]["type"] == "card-identification")
                        {
                            ?>
                            <div class="yuzde30" style="margin:0;padding: 0;">
                                <a id="continue_block" style="float:left;margin-top:20px;" class="graybtn btn"><?php echo __("website/account_info/stored-cards-10"); ?></a>

                                <a id="continue_go" style="display:none;float:left;margin-top:20px;" href="javascript:void 0;" class="yesilbtn btn"><?php echo __("website/account_info/stored-cards-10"); ?></a>
                            </div>

                            <div class="clear"></div>
                            <br><span class="kinfo"><?php echo __("website/account_info/stored-cards-11",['{amount}' => Money::formatter_symbol($checkout["data"]["total"],$checkout["data"]["currency"])]); ?></span>
                            <?php
                        }
                    ?>


                </div>
            </div>

            <?php
                if($checkout["data"]["type"] != "card-identification")
                {
                    ?>
                    <div class="yuzde50" style="float: right;<?php echo $checkout["data"]["type"] == "basket"  ? ' display:none' : ''; ?>" id="payBtns">
                        <a href="javascript:void 0;" style="display: none;" class="yesilbtn gonderbtn" id="continue_go"><?php echo __("website/basket/pay-button"); ?></a>
                        <a class="graybtn gonderbtn" id="continue_block" style="background: #CCCCCC; cursor: no-drop;"><?php echo __("website/basket/pay-button"); ?></a>
                    </div>
                    <?php
                }
            ?>


        </div>
        <form action="https://www.paytr.com/odeme" method="post" id="PAYTR_redirect_form"></form>
        <?php
    }
    else
    {
        ?>
        <div align="center">
            <?php
                $module->get_iframe($links["successful-page"],$links["failed-page"]);
            ?>
            <?php if(isset($links["back"])){ ?>
                <div class="clear"></div>
                <a class="lbtn" href="<?php echo $links["back"]; ?>"><i class="fa fa-angle-double-left" aria-hidden="true"></i> <?php echo $_LANG["turn-back"]; ?></a>
                <div class="clear"></div>
            <?php } ?>
        </div>
        <br>
        <?php
    }