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
                separateDialCode: true,
                utilsScript: "<?php echo $sadress; ?>assets/plugins/phone-cc/js/utils.js"
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

            $(".stage-click").click(function(){
                let stage = $(this).data("stage");

                $(".signup-stages-block").removeClass("active");
                $(".signup-stages-block",$(this)).addClass("active");
                $('.stage-content').hide(1);
                $("#stage-content-"+stage).show(1);

                if(stage === 3)
                {
                    $("#nextStepBtn").css("display","none");
                    $("#signUpBtn").css("display","inline-block");
                }
                else
                {
                    $("#nextStepBtn").css("display","inline-block");
                    $("#signUpBtn").css("display","none");
                }

            });

            $("#nextStepBtn").click(function(){
                let active_stage = parseInt($('.signup-stages-block.active').parent().data("stage"));
                let new_stage    = active_stage+1;
                $(".stage-click[data-stage="+new_stage+"]").click();

                if(new_stage === 3)
                {
                    $("#nextStepBtn").css("display","none");
                    $("#signUpBtn").css("display","inline-block");
                }
                else
                {
                    $("#nextStepBtn").css("display","inline-block");
                    $("#signUpBtn").css("display","none");
                }

            });

        });
    </script>

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

<style>
::-webkit-scrollbar-track{-webkit-box-shadow:inset 0 0 6px rgba(0,0,0,0.3);background-color:#F5F5F5}
::-webkit-scrollbar{width:9px;background-color:#F5F5F5}
::-webkit-scrollbar-thumb{background-color:#607D8B}
.verificationcontent{padding:30px}
.verificationcontent p{font-size:18px;text-align:center}
.verificationcontent h1{text-align:center;font-size:24px;font-weight:bold;color:#8bc34a}
.verificationcontent h1 i{font-size:80px}
.verificationcontent form{text-align:center}
.verificationcontent input{text-align:center;width:200px;font-size:16px;font-weight:bold}
.secureoptions{width:265px;margin:auto;margin-top:35px;font-size:16px;font-weight:600;margin-bottom:15px}
.notverification{font-size:13px;color:#b5b5b5;width:100%;text-align:center;display:inline-block;margin-top:20px}
.notverification a{color:#b5b5b5;font-weight:600}
#uyeolgiris{position:fixed;overflow:auto;margin-bottom:0;width:100%;height:100%;bottom:0px;background-image:url(<?php echo $tadress;?>images/signinsignupbg2020.jpg);background-color:rgba(50, 90, 108, 0.55);background-repeat:no-repeat;    background-size: 100%;}
#uyeolgirisbody .footer{display:none}
.uyeol{position:absolute;width:50%;border-radius:0;margin-bottom:0px;right:0;top:0;bottom:0}
.uyeolgirisslogan{float:left;width:50%;text-align:left;margin-top:0;}
.uyeolgirishead{text-align:center;width:100%;margin-top:5%;margin-bottom:0;float:none; -webkit-animation-name: fadeIn;
  animation-name: fadeIn;
  -webkit-animation-duration: 2s;
  animation-duration: 2s;
  -webkit-animation-fill-mode: both;
  animation-fill-mode: both;}
.padding30{padding:10px 30px}
.sifreunuttulink{color:rgba(255,255,255,0.58)}
.sifreunuttulink:hover{color:rgba(255,255,255,1.00)}
.uyeolgirishead h1{display:none}
.logo{float:none;margin-top:0px;margin-bottom:40px;position:relative}
.uyeolgirisyap .gonderbtn{margin-top:30px}
.logo img{width:200px}
.uyeolgirisslogan h4{width:80%}
.uyeolgirisyap .btn{width:200px;background:transparent;    padding: 12px 0px;}
.clientcopyright{width:100%;text-align:center;font-size:13px;margin-top:15px;margin-bottom:30px;color:#b4b4b4;display:inline-block}
.clientcopyright a{color:#b4b4b4}
.socialconnect{float:right;border:none;padding-bottom:0px;margin-bottom:0px;width:55%}
.footsosyal{margin-top:15px}
.footsosyal a{color:#a1a1a1}
.footsosyal a:hover{background:#eee}
#girisyapright h4{display:none}
.footsosyal{display:none}
.createnewaccountlink{color:rgba(255,255,255,0.58);font-weight:600;margin-bottom:10px;display:inline-block}
.createnewaccountlink:hover{color:rgba(255,255,255,1.58)}
.country-name{color:#999}
.uyeolgirisslogan-con{width:70%;margin:auto;margin-top:35%;}
.uyeolgirisslogan-con .gonderbtn{color:#fff;border:2px solid #fff;margin-top:35px}
.uyeolgirisslogan-con .gonderbtn:hover{color:#333;background:white}
.signupcon{padding:20px;    background: white;}
.socialconnect a{color:#7c7c7c;font-size:14px;background:#e7e7e7}
.socialconnect .facebookconnect{color:#7c7c7c;background:#eee}
.socialconnect .facebookconnect:hover{color:#fff}
.socialconnect .googleconnect{background:#eee;color:#7c7c7c}
.socialconnect .googleconnect:hover{color:#fff}
.signinsignup-title{display:inline-block;font-size:28px;font-weight:600;margin-top:12px}
::-webkit-input-placeholder{color:#7898ae}
:-moz-placeholder{color:#7898ae}
::-moz-placeholder{color:#7898ae}
:-ms-input-placeholder{color:#7898ae}
#uyeolgiris input{border-radius:5px;padding-left: 7px;padding-top:12px;padding-bottom:12px;}
#uyeolgiris #gsm{padding-left:100px;}
.signup-stages-block.active{background:#<?php echo Config::get("theme/color1");?>;color:white}
.clean-theme-signup-box .yuzde50{width:47%}
.signin-signup-foot-btn{text-align:center}
.signin-signup-foot-btn button{font-family:'Titillium Web',sans-serif;float:none;width:250px;cursor:pointer;outline:none;-webkit-transition:all 0.3s ease-out;-moz-transition:all 0.3s ease-out;-ms-transition:all 0.3s ease-out;-o-transition:all 0.3s ease-out;transition:all 0.3s ease-out;}
.signin-signup-foot-btn button:hover {background:#77a83f;}
.signup-stages{float:left;margin-bottom:20px;width:100%;text-align:center;}
.signup-stages-block{background:#eee;width:75px;height:75px;display:inline-block;border-radius:100%;text-align:center;line-height:75px;margin:0px 7%;font-weight:300;font-size:30px}
.signup-stage-line{width:100%;height:10px;background:#eee;margin-top:35px;float:left;margin-bottom:-55px;border-radius:3px}
.captcha-content {margin-top:0;}

@media only screen and (min-width:320px) and (max-width:1024px){
.uyeolgirishead{width:100%;margin-top:15%}
.uyeolgirishead .logo {    margin-bottom: 25px;}
.uyeolgirisyap{width:100%}
#wrapper{width:90%}
.uyeol{width:100%;position:relative;border-right:none}
.signupcon{position:relative;}
#uyeolgiris{overflow-x:auto;background-size:auto 120%;background-position:center}
.uyeolgirisslogan{text-align:center;width:100%}
.uyeolgirisslogan h4{width:90%;font-size:17px;margin:auto;margin-top:25px}
.uyeolgirisslogan-con{width:90%;margin:auto;margin-top:55px}
.signupcon .padding30 {    padding: 0px;}
.socialconnect {    margin-bottom: 20px;    width: 100%;}
.signup-stages-block{width:75px;height:75px;line-height:75px;margin:0px 4%;font-size:28px}
.signup-stage-line {    margin-bottom: -45px;}
.clean-theme-signup-box .yuzde50 {    width: 46%;}
.captcha-content{width:310px;transform:scale(0.8);margin-left:auto;margin-top:0;margin-bottom:10px}
.signin-signup-foot-btn{margin-bottom:30px}

}

</style>


</head>

<body id="uyeolgirisbody">

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

<div id="uyeolgiris">
    <div id="new-signin-signup">


        <div class="uyeolgirisyapx">

            <div class="uyeolgirisslogan">

                <div class="uyeolgirisslogan-con">

                    <div class="logo">
                        <a href="<?php echo $home_link; ?>"><img title="" alt="" src="<?php echo $sign_logo_link;?>" width="253" height="auto"></a>
                    </div>

                    <h4><?php echo __("website/sign/up-text1");
                            if($sign_in) echo __("website/sign/up-text2"); ?>
                    </h4><div class="clear"></div>
                    <?php if($sign_in): ?>

                        <a href="<?php echo $login_link; ?>" class="gonderbtn"><?php echo __("website/sign/up-button-in"); ?></a>
                    <?php endif; ?>
                </div>

            </div>

            <div class="uyeol">

                <div class="signupcon">
                    <div class="padding30">
                        <h1 class="signinsignup-title"><?php echo __("website/sign/up-title"); ?></h1>


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


                        <div class="line"></div>

                        <div class="signup-stages">

                            <div class="signup-stage-line"></div>

                            <a href="javascript:void 0;" class="stage-click stage-clicks" data-stage="1">
                                <div class="signup-stages-block active">
                                    1
                                </div>
                            </a>

                            <a href="javascript:void 0;" class="stage-click stage-clicks" data-stage="2">
                                <div class="signup-stages-block">
                                    2
                                </div>
                            </a>

                            <a href="javascript:void 0;" class="stage-click stage-clicks" data-stage="3">
                                <div class="signup-stages-block">
                                    3
                                </div>
                            </a>

                        </div>

                        <div class="clear"></div>

                        <form action="<?php echo $register_link;?>" method="POST" class="mio-ajax-form" id="Signup_Form">
                            <!-- Information FORM -->

                            <?php echo Validation::get_csrf_token('sign'); ?>

                            <input type="hidden" name="stage" value="1">

                            <!-- Information FORM -->
                            <div id="Information">


                                <div class="stage-content" id="stage-content-1" style="display:block;">

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

                                </div>

                                <div class="stage-content" id="stage-content-2" style="display:none;">

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

                                </div>

                                <div class="stage-content" id="stage-content-3" style="display:none;">

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

                                    <div class="clean-theme-signup-box" style="display: none;">
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


                                    <div class="clean-theme-signup-box" style="    padding-bottom: 10px;">
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


                                </div>

                                <div class="signin-signup-foot-btn">


                                    <button type="button" class="yesilbtn gonderbtn" id="nextStepBtn"><?php echo __("website/osteps/continue-button2"); ?></button>

                                    <button type="button" class="yesilbtn gonderbtn mio-ajax-submit" mio-ajax-options='{"result":"signup_submit","waiting_text":"<?php echo addslashes(__("website/others/button1-pending")); ?>"}' id="signUpBtn" style="display: none;"><?php echo __("website/sign/up-form-submit"); ?></button>

                                    <div class="clear"></div>
                                    <div class="error" id="FormOutput" align="center" style="display:none;font-weight:bold;"></div>
                                </div>

                            </div>

                        </form>

                    <!-- SUCCESS -->
                    <div id="Success_div" style="display:none">
                        <div style="margin-top:15%;margin-bottom:70px;text-align:center;">
                            <i style="font-size:80px;" class="fa fa-check"></i>
                            <h4 style="font-weight:bold;border:none;font-size: 26px;"><?php echo __("website/sign/up-success-title"); ?></h4>
                            <h5><?php echo __("website/sign/up-success-content"); ?></h5>
                        </div>
                    </div>
                    <!-- SUCCESS -->

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


                    <?php if($socialsc>0 && is_array($socials)){ ?>
                        <div class="footsosyal">
                            <?php
                                foreach($socials AS $row){
                                    if($row["url"] != ''){
                                        echo '<a href="'.$row["url"].'" target="_blank" title="'.$row["name"].'"><i class="'.$row["icon"].'" aria-hidden="true"></i></a>';
                                    }
                                }
                            ?>
                        </div>
                    <?php } ?>
                    <div class="clear"></div>
                </div>
            </div>
        </div>


    </div>


</div>


<?php include __DIR__.DS."inc".DS."sign-footer.php"; ?>