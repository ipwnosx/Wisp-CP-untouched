<!DOCTYPE html>
<html>
<head>
    <?php
        $plugins    = ['jquery-ui','intlTelInput','voucher_codes'];
        include __DIR__.DS."inc".DS."head.php";
    ?>

    <script type="text/javascript">
        $(document).ready(function(){

            $("#addNewForm_submit").on("click",function(){
                MioAjaxElement($(this),{
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                    result:"addNewForm_handler",
                });
            });

        });

        function addNewForm_handler(result){
            if(result != ''){
                var solve = getJson(result);
                if(solve !== false){
                    if(solve.status == "error"){
                        if(solve.for != undefined && solve.for != ''){
                            $("#addNewForm "+solve.for).focus();
                            $("#addNewForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                            $("#addNewForm "+solve.for).change(function(){
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
    </script>

    <script>
  $( function() {
    $( "#accordion" ).accordion({
       heightStyle: "content",
     active: false,
     collapsible: true,
    });
  } );
  </script>

</head>
<body>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1><strong><?php echo __("admin/users/page-create"); ?></strong></h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="clear"></div>

            <div class="adminpagecon">

                <form action="<?php echo $links["controller"]; ?>" method="post" id="addNewForm">
                    <input type="hidden" name="operation" value="add_new_user">


                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/users/create-ac-type"); ?></div>
                        <div class="yuzde70">
                            <input checked onclick="$('.ac-type-wrap').not('.individual-wrap').css('display','none'),$('.individual-wrap').css('display','block');" id="kind-individual" class="radio-custom" name="kind" value="individual" type="radio">
                            <label for="kind-individual" class="radio-custom-label" style="margin-right: 28px;"><span class="checktext"><?php echo __("admin/users/create-ac-type-individual"); ?></span></label>
                            <input id="kind-corporate" onclick="$('.ac-type-wrap').not('.corporate-wrap').css('display','none'),$('.corporate-wrap').css('display','block');" class="radio-custom" name="kind" value="corporate" type="radio">
                            <label for="kind-corporate" class="radio-custom-label" style="margin-right: 28px;"><span class="checktext"><?php echo __("admin/users/create-ac-type-corporate"); ?></span></label>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/users/create-name"); ?></div>
                        <div class="yuzde70">
                            <input name="full_name" type="text" value="">
                        </div>
                    </div>

                    <?php if(Config::get("general/country") == "tr"): ?>
                        <div class="formcon">
                            <div class="yuzde30">T.C Kimlik No</div>
                            <div class="yuzde70">
                                <input name="identity" type="text" value="" maxlength="11" class="width200" onkeypress="return event.charCode>= 48 &amp;&amp;event.charCode<= 57">
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/users/create-birthday"); ?></div>
                        <div class="yuzde70">
                            <input type="date" name="birthday" value="" class="width200">
                        </div>
                    </div>


                    <div class="formcon ac-type-wrap corporate-wrap" style="display: none;">
                        <div class="yuzde30"><?php echo __("admin/users/create-company-name"); ?></div>
                        <div class="yuzde70">
                            <input name="company_name" type="text" value="">
                        </div>
                    </div>

                    <div class="formcon ac-type-wrap corporate-wrap" style="display: none;">
                        <div class="yuzde30"><?php echo __("admin/users/create-company-tax-number"); ?></div>
                        <div class="yuzde70">
                            <input name="company_tax_number" type="text" value="">
                        </div>
                    </div>

                    <div class="formcon ac-type-wrap corporate-wrap" style="display: none;">
                        <div class="yuzde30"><?php echo __("admin/users/create-company-tax-office"); ?></div>
                        <div class="yuzde70">
                            <input name="company_tax_office" type="text" value="">
                        </div>
                    </div>


                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/users/create-email"); ?></div>
                        <div class="yuzde70">
                            <input name="email" type="email" value="" required="required">
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/users/create-phone"); ?></div>
                        <div class="yuzde70">
                            <script type="text/javascript">
                                $(document).ready(function(){
                                    var telInput = $("#gsm");
                                    telInput.intlTelInput({
                                        geoIpLookup: function(callback) {
                                            var countryCode = '<?php if($ipInfo = UserManager::ip_info()) echo $ipInfo["countryCode"]; else echo 'us'; ?>';
                                            $("select[name=country] option[data-code="+countryCode+"]").attr("selected",true).trigger("change");
                                            callback(countryCode);
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
                            <input  id="gsm" type="text" value="" onkeypress="return event.charCode>= 48 &amp;&amp;event.charCode<= 57">
                        </div>
                    </div>


                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/users/create-landline-phone"); ?></div>
                        <div class="yuzde70">
                            <input name="landline_phone" type="text" value="" onkeypress="return event.charCode>= 48 &amp;&amp;event.charCode<= 57">
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/users/create-notification-permissions"); ?></div>
                        <div class="yuzde70">
                            <input id="email_notifications" class="checkbox-custom" name="email_notifications" value="1" type="checkbox" checked>
                            <label for="email_notifications" class="checkbox-custom-label" style="margin-right: 28px;"><span class="checktext"><?php echo __("admin/users/create-notification-email"); ?></span></label>
                            <input id="sms_notifications" class="checkbox-custom" name="sms_notifications" value="1" type="checkbox" checked>
                            <label for="sms_notifications" class="checkbox-custom-label" style="margin-right: 28px;"><span class="checktext"><?php echo __("admin/users/create-notification-sms"); ?></span></label>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/users/create-ac-status"); ?></div>
                        <div class="yuzde70">
                            <input id="status_active" class="radio-custom" name="status" value="active" type="radio" checked>
                            <label for="status_active" class="radio-custom-label" style="margin-right: 28px;"><span class="checktext"><?php echo __("admin/users/situations/active"); ?></span></label>
                            <input id="status_inactive" class="radio-custom" name="status" value="inactive" type="radio">
                            <label for="status_inactive" class="radio-custom-label" style="margin-right: 28px;"><span class="checktext"><?php echo __("admin/users/situations/inactive"); ?></span></label>

                            <input id="status_blocked" class="radio-custom" name="status" value="blocked" type="radio">
                            <label for="status_blocked" class="radio-custom-label" style="margin-right: 28px;"><span class="checktext"><?php echo __("admin/users/situations/blocked"); ?></span></label>
                        </div>
                    </div>


                     <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/users/create-group"); ?></div>
                        <div class="yuzde70">
                            <select name="group_id" style="width:101%;">
                                <option value=""><?php echo ___("needs/select-your"); ?></option>
                                <?php
                                    if(isset($groups) && $groups){
                                        foreach($groups AS $group){
                                            ?>
                                            <option value="<?php echo $group["id"]; ?>"><?php echo $group["name"]; ?></option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/users/create-language"); ?></div>
                        <div class="yuzde70">
                            <select name="lang" style="width:101%;">
                               
                                <?php
                                    foreach($lang_list AS $row){
                                        ?>
                                        <option value="<?php echo $row["key"];?>"><?php echo $row["cname"]." (".$row["name"].")"; ?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/users/create-currency"); ?></div>
                        <div class="yuzde70">
                            <select name="currency" style="width:101%;">
                               
                                <?php
                                    foreach(Money::getCurrencies() AS $row){
                                        ?>
                                        <option value="<?php echo $row["id"]; ?>"><?php echo $row["name"]." (".$row["code"].")"; ?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </div>



                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/users/create-ticket-restricted"); ?></div>
                        <div class="yuzde70">
                            <input id="ticket_restricted" name="ticket_restricted" value="1" type="checkbox" class="sitemio-checkbox">
                            <label for="ticket_restricted" class="sitemio-checkbox-label"></label>
                            <span class="kinfo">(<?php echo __("admin/users/create-ticket-restricted-info"); ?>)</span>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/users/create-ticket-blocked"); ?></div>
                        <div class="yuzde70">
                            <input id="ticket_blocked" name="ticket_blocked" value="1" type="checkbox" class="sitemio-checkbox">
                            <label for="ticket_blocked" class="sitemio-checkbox-label"></label>
                            <span class="kinfo">(<?php echo __("admin/users/create-ticket-blocked-info"); ?>)</span>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/users/create-ticket-tax-exemption"); ?></div>
                        <div class="yuzde70">
                            <input id="taxation" name="taxation" value="1" type="checkbox" class="sitemio-checkbox">
                            <label for="taxation" class="sitemio-checkbox-label"></label>
                            <span class="kinfo">(<?php echo __("admin/users/create-ticket-tax-examption-info"); ?>)</span>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/users/create-never-suspend"); ?></div>
                        <div class="yuzde70">
                            <input id="never_suspend" name="never_suspend" value="1" type="checkbox" class="checkbox-custom">
                            <label for="never_suspend" class="checkbox-custom-label"><span class="kinfo">(<?php echo __("admin/users/create-never-suspend-info"); ?>)</span></label>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/users/create-never-cancel"); ?></div>
                        <div class="yuzde70">
                            <input id="never_cancel" name="never_cancel" value="1" type="checkbox" class="checkbox-custom">
                            <label for="never_cancel" class="checkbox-custom-label"><span class="kinfo">(<?php echo __("admin/users/create-never-cancel-info"); ?>)</span></label>
                        </div>
                    </div>

                   


                   

                    <div class="clear"></div>

                    <div id="accordion" style="margin-top:15px;">
                        <h3><?php echo __("admin/users/create-address-info"); ?></h3>
                        <div>
                            <script type="text/javascript">
                                city_request = false,counti_request=false;
                                function getCities(country,call_request){

                                    $("select[name=city]").html('').css("display","none").attr("disabled",true);
                                    $("input[name=city]").val('').css("display","block").attr("disabled",false);

                                    $("select[name=counti]").html('').css("display","none").attr("disabled",true);
                                    $("input[name=counti]").val('').css("display","block").attr("disabled",false);

                                    if(call_request) city_request = false;

                                    var request = MioAjax({
                                        action:"<?php echo $links["controller"]; ?>",
                                        method:"POST",
                                        data:{operation:"getCities",country:country},
                                    },true,true);

                                    request.done(function(result){
                                        if(call_request) city_request = "done";

                                        if(result || result !== undefined){
                                            if(result != ''){
                                                var solve = getJson(result);
                                                if(solve !== false){
                                                    if(solve.status == "successful"){
                                                        $("select[name=city]").html('');
                                                        $("select[name='city']").append($('<option>', {
                                                            value: '',
                                                            text: "<?php echo ___("needs/select-your"); ?>",
                                                        }));
                                                        $(solve.data).each(function (index,elem) {
                                                            $("select[name='city']").append($('<option>', {
                                                                value: elem.id,
                                                                text: elem.name
                                                            }));
                                                        });
                                                        $("select[name='city']").css("display","block").attr("disabled",false);
                                                        $("input[name='city']").css("display","none").attr("disabled",true);
                                                    }else{
                                                        $("select[name='city']").css("display","none").attr("disabled",true);
                                                        $("input[name='city']").css("display","block").attr("disabled",false);
                                                        $("input[name='city']").focus();
                                                    }
                                                }else
                                                    console.log(result);
                                            }
                                        }
                                    });
                                }

                                function getCounties(city,call_request){

                                if(call_request) counti_request = false;

                                if(city !== ''){
                                    var request = MioAjax({
                                        action:"<?php echo $links["controller"]; ?>",
                                        method:"POST",
                                        data:{operation:"getCounties",city:city},
                                    },true,true);

                                    request.done(function(result){
                                        if(call_request) counti_request = "done";
                                        if(result || result != undefined){
                                            if(result != ''){
                                                var solve = getJson(result);
                                                if(solve !== false){
                                                    if(solve.status == "successful"){
                                                        $("select[name=counti]").html('');
                                                        $("select[name='counti']").append($('<option>', {
                                                            value: '',
                                                            text: "<?php echo ___("needs/select-your"); ?>",
                                                        }));
                                                        $(solve.data).each(function (index,elem) {
                                                            $("select[name='counti']").append($('<option>', {
                                                                value: elem.id,
                                                                text: elem.name
                                                            }));
                                                        });
                                                        $("select[name=counti]").css("display","block").attr("disabled",false);
                                                        $("input[name=counti]").val('').css("display","none").attr("disabled",true);
                                                    }else{
                                                        $("select[name=counti]").css("display","none").attr("disabled",true);
                                                        $("input[name=counti]").val('').css("display","block").attr("disabled",false);
                                                        $("input[name='counti']").focus();
                                                    }
                                                }else
                                                    console.log(result);
                                            }
                                        }
                                    });
                                }
                                else{
                                    $("select[name=counti]").html('').css("display","none").attr("disabled",true);
                                    $("input[name=counti]").val('').css("display","block").attr("disabled",false);
                                    if(call_request) counti_request = "done";
                                }
                                }

                                $(document).ready(function(){
                                    var country = $("select[name='country'] option:selected").val();
                                    if(country !== ''){
                                        getCities(country);
                                    }
                                });
                            </script>

                            <?php
                                $IPData         = UserManager::ip_info();
                                $countryCode    = isset($IPData["countryCode"]) ? $IPData["countryCode"] : '';
                                $countryCode    = strtoupper($countryCode);

                                if(isset($countryList) && is_array($countryList)){
                                    ?>
                                    <div class="yuzde25">
                                        <strong><?php echo __("website/account_info/country"); ?></strong>
                                        <select name="country" onchange="getCities(this.options[this.selectedIndex].value);">
                                            <option value=""><?php echo __("website/account_info/select-your"); ?></option>
                                            <?php
                                                foreach($countryList as $country){
                                                    ?><option<?php echo $countryCode == $country["code"] ? ' selected' : ''; ?> value="<?php echo $country["id"];?>" data-code="<?php echo $country["code"]; ?>"><?php echo $country["name"];?></option><?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <?php
                                }
                            ?>
                            <div id="cities" class="yuzde25">
                                <strong><?php echo __("admin/users/create-city"); ?></strong>
                                <select name="city" disabled id="selectCity" onchange="getCounties($(this).val());" style="display:none;"></select>
                                <input type="text" name="city" placeholder="<?php echo __("admin/users/create-city-placeholder"); ?>">
                            </div>
                            <div id="counti" class="yuzde25" >
                                <strong><?php echo __("admin/users/create-counti"); ?></strong>
                                <select name="counti" disabled id="selectCounti" style="display:none;"></select>
                                <input type="text" name="counti" placeholder="<?php echo __("admin/users/create-counti-placeholder"); ?>">
                            </div>
                            <div id="zipcode" class="yuzde25">
                                <strong><?php echo __("admin/users/create-zipcode"); ?></strong>
                                <input name="zipcode" type="text" placeholder="<?php echo __("admin/users/create-zipcode-placeholder"); ?>">
                            </div>
                            <div id="address" class="yuzde100" style="margin-top:20px;">
                                <strong><?php echo __("admin/users/create-address"); ?></strong>
                                <input name="address" type="text" placeholder="<?php echo __("admin/users/create-address-placeholder"); ?>">
                            </div>

                        </div>
                    </div>


                     <div class="clear"></div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/users/create-password"); ?></div>
                        <div class="yuzde70">
                            <input name="password" type="text" value="" placeholder="" style="width: 170px;">
                            <a class="lbtn " href="javascript:void 0;" onclick="$('#password_primary').attr('type','text'); $('input[name=password]').val(voucher_codes.generate({length:16,charset: 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*()-_=+[]\|;:,./?'})).trigger('change');"><i class="fa fa-refresh"></i> <?php echo __("website/account_products/new-random-password"); ?></a>

                            <script type="text/javascript">
                                $(document).ready(function(){
                                    $("input[name=password]").bind('paste keypress keyup keydown change',function(){
                                        var pw1 = $("input[name=password]").val();

                                        var level = checkStrength(pw1);

                                        $('.level-block').css("display","none");
                                        $("#"+level).css("display","block");
                                    });
                                });
                            </script>
                            <div id="password_strength">
                                <div id="weak" style="display:block;" class="level-block"><?php echo __("website/sign/up-form-password-level"); ?>: <strong><?php echo __("website/sign/up-form-password-level1"); ?></strong></div>
                                <div id="good" class="level-block" style="display:none"><?php echo __("website/sign/up-form-password-level"); ?>: <strong><?php echo __("website/sign/up-form-password-level2"); ?></strong></div>
                                <div id="strong" class="level-block" style="display: none;"><?php echo __("website/sign/up-form-password-level"); ?>: <strong><?php echo __("website/sign/up-form-password-level3"); ?></strong></div>
                            </div>


                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/users/create-notification"); ?></div>
                        <div class="yuzde70">
                            <input type="checkbox" name="notification" value="1" class="checkbox-custom" id="notification">
                            <label class="checkbox-custom-label" for="notification"></label>
                        </div>
                    </div>


                    <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                        <a class="yesilbtn gonderbtn" id="addNewForm_submit" href="javascript:void(0);"><?php echo __("admin/users/button-create"); ?></a>
                    </div>
                    <div class="clear"></div>


                </form>

            </div>


            <div class="clear"></div>
        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>