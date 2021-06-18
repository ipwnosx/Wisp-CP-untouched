<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    $master_content_none = true;
    $connectionButtons = Hook::run("ClientAreaConnectionButtons","register");
?>
<!DOCTYPE html>
<html lang="<?php echo ___("package/code"); ?>">
<head>
    <?php
        $hoptions = [
            'page' => "sign-in",
            'intlTelInput',
            'voucher_codes',
        ];
        include __DIR__.DS."inc".DS."main-head.php";
    ?>

    <script type="text/javascript">
        var countryCode;
        $(document).ready(function(){

            countryCode = '<?php if($ipInfo = UserManager::ip_info()) echo $ipInfo["countryCode"]; else echo 'us'; ?>';
            $('select[name=country] option').prop('selected',false);
            $("select[name=country] option[data-code='"+(countryCode.toUpperCase())+"']").prop('selected',true).parent().trigger('change');

            var telInput = $("#gsm");
            telInput.intlTelInput({
                geoIpLookup: function(callback) {
                    callback(countryCode);
                },
                autoPlaceholder: "on",
                formatOnDisplay: true,
                initialCountry: "auto",
                hiddenInput: "gsm",
                nationalMode: false,
                placeholderNumberType: "MOBILE",
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
    </script>

    <?php if($kind_status): ?>
        <script type="text/javascript">
        $(document).ready(function(){
            $("input[name='kind']").change(function(){
                var id = $(this).attr("id");
                $(".kind-content").fadeOut(100,function () {
                    $("."+id).fadeIn(100);
                });
            });

            $("input[name='kind']:checked").each(function () {
                var id = $(this).attr("id");
                $(".kind-content").fadeOut(100,function () {
                    $("."+id).fadeIn(100);
                });
            });

        });
    </script>
    <?php endif; ?>

  

</head>

<body id="clean-theme-client">

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

<?php include __DIR__.DS."inc".DS."lang-currency-modal.php"; ?>
<?php include __DIR__.DS."inc".DS."main-header.php"; ?>

    <div class="clear"></div>

    <div id="wrapper">

        <div class="clean-theme-signinup-con" id="clean-theme-sign-up">


            <div class="clean-theme-signinup-right">

                <form action="<?php echo $register_link;?>" method="POST" class="mio-ajax-form" id="Signup_Form">
                    <?php echo Validation::get_csrf_token('sign'); ?>

                    <input type="hidden" name="stage" value="1">

                    <div class="clean-theme-signinup-right-title">
                        <h4><?php echo __("website/sign/up"); ?></h4>

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
                    </div>


                    <?php if($kind_status): ?>
                        <div class="clean-theme-signup-box">

                            <div class="clean-theme-signup-box-title"><?php echo __("website/sign/up-form-kind"); ?></div>


                            <input id="kind_1" class="radio-custom" name="kind" value="individual" type="radio" checked>
                            <label for="kind_1" class="radio-custom-label" style="margin-right: 28px;"><span class="checktext"><?php echo __("website/sign/up-form-kind-1"); ?></span></label>

                            <input id="kind_2" class="radio-custom" name="kind" value="corporate" type="radio">
                            <label for="kind_2" class="radio-custom-label" style="margin-right: 28px;"><span class="checktext"><?php echo __("website/sign/up-form-kind-2"); ?></span></label>
                        </div>
                    <?php endif; ?>

                    <div class="clean-theme-signup-box">
                        <div class="clean-theme-signup-box-title"><?php echo __("website/account_info/personal-informations"); ?></div>

                        <div class="yuzde50">
                            <input name="full_name" type="text" placeholder="<?php echo __("website/sign/up-form-full_name"); ?>">
                        </div>

                        <div class="yuzde50">
                            <input name="email" type="text" placeholder="<?php echo __("website/sign/up-form-email"); echo ($email_verify_status) ? " ".__("website/sign/up-form-email-verify") : ''; ?>" required>
                        </div>

                        <?php if($gsm_status): ?>
                            <div class="yuzde100">
                                <input id="gsm" type="text"<?php echo ($gsm_required) ? ' required' : '' ?> placeholder="<?php echo __("website/sign/up-form-gsm"); echo ($sms_verify_status) ? " ".__("website/sign/up-form-gsm-verify") : ''; ?>" onkeypress="return event.charCode>= 48 &amp;&amp;event.charCode<= 57">
                            </div>
                        <?php endif; ?>

                    </div>

                    <div class="clean-theme-signup-box">
                        <div class="clean-theme-signup-box-title"><?php echo __("website/account_info/billing-information"); ?></div>


                        <div class="yuzde100 kind-content kind_2"  style="display:none;">
                            <input name="company_name" type="text" placeholder="<?php echo __("website/sign/up-form-cname"); ?>" required>
                        </div>

                        <div class="yuzde50 kind-content kind_2" style="display:none;">
                            <input name="company_tax_number" type="text" placeholder="<?php echo __("website/sign/up-form-ctaxno"); ?>" required>
                        </div>
                        <div class="yuzde50 kind-content kind_2" style="display:none;">
                            <input name="company_tax_office" type="text" placeholder="<?php echo __("website/sign/up-form-ctaxoff"); ?>" required>
                        </div>


                        <?php $countryList = AddressManager::getCountryList(); ?>
                        <div class="yuzde50">
                            <select name="country" onchange="getCities(this.options[this.selectedIndex].value);">
                                <?php
                                    foreach($countryList as $country){
                                        ?><option value="<?php echo $country["id"];?>" data-code="<?php echo $country["code"]; ?>"><?php echo $country["name"];?></option><?php
                                    }
                                ?>
                            </select>
                        </div>

                        <div class="yuzde50">
                            <select name="city" onchange="getCounties($(this).val());" disabled style="display: none;"></select>
                            <input type="text" name="city" placeholder="<?php echo __("admin/users/create-city-placeholder"); ?>">
                        </div>

                        <div class="yuzde50">
                            <select name="counti" disabled style="display: none;"></select>
                            <input type="text" name="counti" placeholder="<?php echo __("admin/users/create-counti-placeholder"); ?>">
                        </div>

                        <div class="yuzde50">
                            <input name="zipcode" type="text" placeholder="<?php echo __("admin/users/create-zipcode-placeholder"); ?>">
                        </div>

                        <div class="yuzde100">
                            <input name="address" type="text" placeholder="<?php echo __("admin/users/create-address-placeholder"); ?>">
                        </div>


                    </div>

                    <div class="clean-theme-signup-box">
                        <div class="clean-theme-signup-box-title"><?php echo __("website/account_info/set-a-password"); ?></div>
                        <div class="yuzde50">
                            <input name="password" type="password" id="password_primary" placeholder="<?php echo __("website/sign/up-form-password"); ?>" required>
                        </div>
                        <div class="yuzde50">
                            <input name="password_again" type="password" id="password_again" placeholder="<?php echo __("website/sign/up-form-password_again"); ?>" required>
                        </div>
                        <div class="yuzde50">
                            <a class="sbtn" href="javascript:void 0;" onclick="$('#password_primary').attr('type','text'); $('#password_primary,#password_again').val(voucher_codes.generate({length:16,charset: 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*()-_=+[]\|;:,./?'})).trigger('change');"><i class="fa fa-refresh"></i> <?php echo __("website/account_products/new-random-password"); ?></a>
                        </div>
                        <div class="yuzde50">
                            <div id="weak" style="display:block;" class="level-block"><?php echo __("website/sign/up-form-password-level"); ?>: <strong><?php echo __("website/sign/up-form-password-level1"); ?></strong></div>
                            <div id="good" class="level-block" style="display:none"><?php echo __("website/sign/up-form-password-level"); ?>: <strong><?php echo __("website/sign/up-form-password-level2"); ?></strong></div>
                            <div id="strong" class="level-block" style="display: none;"><?php echo __("website/sign/up-form-password-level"); ?>: <strong><?php echo __("website/sign/up-form-password-level3"); ?></strong></div>
                        </div>

                    </div>

                    <div class="clean-theme-signup-box">
                        <div class="clean-theme-signup-box-title"><?php echo __("admin/users/create-notification-permissions"); ?></div>

                        <div class="yuzde100">
                            <input id="email_notifications" class="checkbox-custom" name="email_notifications" value="1" type="checkbox" checked="">
                            <label for="email_notifications" class="checkbox-custom-label"></label>
                            <?php echo __("website/account_info/email-notifications"); ?>
                        </div>
                        <div class="yuzde100">
                            <input id="sms_notifications" class="checkbox-custom" name="sms_notifications" value="1" type="checkbox" checked="">
                            <label for="sms_notifications" class="checkbox-custom-label"></label>
                            <?php echo __("website/account_info/sms-notifications"); ?>
                        </div>

                    </div>


                    <div class="clean-theme-signup-box">
                        <div class="clean-theme-signup-box-title"><?php echo __("website/basket/contracts"); ?></div>
                        <div class="yuzde100">
                            <input id="checkbox-5" class="checkbox-custom" name="contract" value="1" type="checkbox" required>
                            <label for="checkbox-5" class="checkbox-custom-label"><span class="checktext"><?php echo __("website/sign/up-form-contract"); ?></span></label>
                        </div>

                    </div>

                    <div class="clear"></div>

                    <?php if(isset($captcha) && $captcha): ?>

                        <div class="captcha-content">
                            <?php echo $captcha->getOutput(); ?>
                            <?php if($captcha->input): ?>
                                <input class="captchainput" name="<?php echo $captcha->input_name; ?>" type="text" placeholder="<?php echo ___("needs/form-captcha-label"); ?>">
                            <?php endif; ?>
                        </div>

                    <?php endif; ?>

                    <div class="clean-theme-adduser-btn">
                        <button class="mio-ajax-submit" type="button" mio-ajax-options='{"result":"signup_submit","waiting_text":"<?php echo addslashes(__("website/others/button1-pending")); ?>"}'><?php echo __("website/sign/up-form-submit"); ?></button>
                    </div>

                </form>

                <!-- SUCCESS -->
                <div id="Success_div" style="display:none">
                    <div style="margin-top:30px;margin-bottom:70px;text-align:center;">
                        <i style="font-size:80px;" class="fa fa-check"></i>
                        <h4 style="font-weight:bold;border:none;"><?php echo __("website/sign/up-success-title"); ?></h4>
                        <h5 style="font-size:16px;"><?php echo __("website/sign/up-success-content"); ?></h5>
                    </div>
                </div>
                <!-- SUCCESS -->

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

                <script type="text/javascript">
                    var city_request = false,counti_request=false;

                    function getCities(country,call_request){

                        $("select[name=city]").html('').css("display","none").attr("disabled",true);
                        $("input[name=city]").val('').css("display","block").attr("disabled",false);

                        $("select[name=counti]").html('').css("display","none").attr("disabled",true);
                        $("input[name=counti]").val('').css("display","block").attr("disabled",false);

                        if(call_request) city_request = false;

                        var request = MioAjax({
                            action:"<?php echo Controllers::$init->CRLink("ac-ps-info"); ?>",
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
                                        }
                                        else
                                        {
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
                                action:"<?php echo Controllers::$init->CRLink("ac-ps-info"); ?>",
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
                    function signup_submit(result){
                        <?php if(isset($captcha)) echo $captcha->submit_after_js(); ?>
                        if(result != ''){
                            var solve = getJson(result);
                            if(solve !==false && solve != undefined && typeof(solve) == "object"){
                                if(solve.type == "alert"){
                                    alert(solve.message);
                                }

                                if(solve.type == "information"){
                                    if(solve.status == "error"){
                                        if(solve.for != undefined && solve.for != ''){
                                            $("#Signup_Form "+solve.for).focus();
                                            $("#Signup_Form "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                            $("#Signup_Form "+solve.for).change(function(){
                                                $(this).removeAttr("style");
                                            });
                                        }
                                        if(solve.message != undefined && solve.message != '')
                                            alert_error(solve.message,{timer:4000});
                                    }
                                }

                                if(solve.type == "register"){
                                    if(solve.status == "successful"){
                                        $("#FormOutput").fadeOut(500).html('');
                                        $("#Signup_Form").slideUp(500,function(){
                                            $("#Success_div").slideDown(500);
                                            if(solve.redirect != undefined){
                                                setTimeout(function(){
                                                    window.location.href = solve.redirect;
                                                },7000);
                                            }
                                        });
                                    }else if(solve.status == "error")
                                        alert_error(solve.message,{timer:4000});
                                }
                            }else
                                console.log(result);
                        }
                    }

                    $(document).ready(function(){
                        $("#password_primary,#password_again").bind('paste keypress keyup keydown change',function(){
                            var pw1 = $("#password_primary").val();
                            var pw2 = $("#password_again").val();

                            var level = checkStrength(pw1);

                            if(pw1 !== pw2) level = 'weak';

                            $('.level-block').css("display","none");
                            $("#"+level).css("display","block");
                        });

                        $("select[name=country] option[data-code=<?php echo isset($ipInfo["countryCode"]) ? strtoupper($ipInfo["countryCode"]) : 'US'; ?>]").attr("selected",true);
                        $("select[name=country]").trigger("change");

                    });
                </script>
            </div>


            <div class="clean-theme-signinup-left">
                <img data-aos="zoom-out" src="<?php echo $tadress; ?>images/home-shield.svg" alt="" title="" width="auto" height="50">
                <h4><?php echo __("website/sign/up-text1");
                        if($sign_in) echo __("website/sign/up-text2"); ?>
                </h4><div class="clear"></div>
                <?php if($sign_in): ?>

                    <a href="<?php echo $login_link; ?>" class="clean-theme-btn"><?php echo __("website/sign/up-button-in"); ?></a>
                <?php endif; ?>
            </div>


        </div>


    </div>

<?php include __DIR__.DS."inc".DS."main-footer.php"; ?>

<?php include __DIR__.DS."inc".DS."sign-footer.php"; ?>