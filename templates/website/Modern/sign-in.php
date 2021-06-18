<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    if(Config::get("theme/new-login-area"))
    {
        include __DIR__.DS."sign-in-new.php";
        return false;
    }
    $master_content_none = true;
    $connectionButtons = Hook::run("ClientAreaConnectionButtons","login");

    if(Config::get("options/crtacwshop")) $sign_up = false;

?>
<!DOCTYPE html>
<html lang="<?php echo ___("package/code"); ?>">
<head>

    <?php
        $contact_link = Controllers::$init->CRLink("contact");
        $hoptions = [
            'page' => "sign-in",
            'jquery.countdown',
        ];
        include __DIR__.DS."inc".DS."main-head.php";
    ?>

    <script type="text/javascript">
        var vid = document.getElementById("bgvid");

        $(document).ready(function(){
            if (window.matchMedia('(prefers-reduced-motion)').matches) {
                if(vid !== null){
                    console.log(vid);
                    vid.removeAttr("autoplay");
                    vid.pause();
                }
            }
        });

        function vidFade() {
            vid.classList.add("stopfade");
        }

        $(document).ready(function(){

            $("#Signin_Form input:first").focus();

            $("#Signin_Form").bind("keypress", function(e) {
                if(e.keyCode == 13) $("#Signin_Form .mio-ajax-submit").click();
            });

            $("#Signforget_Form").bind("keypress", function(e){
                if (e.keyCode == 13) $("#Signforget_Form .mio-ajax-submit").click();
            });

        });
    </script>

   <style>
 ::-webkit-input-placeholder{color:rgba(255,255,255,0.75)}
:-moz-placeholder{color:rgba(255,255,255,0.75)}
::-moz-placeholder{color:rgba(255,255,255,0.75)}
:-ms-input-placeholder{color:rgba(255,255,255,0.75)}
::-webkit-scrollbar-track{-webkit-box-shadow:inset 0 0 6px rgba(0,0,0,0.3);background-color:#F5F5F5}
::-webkit-scrollbar{width:9px;background-color:#F5F5F5}
::-webkit-scrollbar-thumb{background-color:#607D8B}
video{position:fixed;top:50%;left:50%;min-width:100%;min-height:100%;width:auto;height:auto;z-index:-100;transform:translateX(-50%) translateY(-50%);background-size:cover;transition:1s opacity;opacity:.50;filter:alpha(opacity=50)}
.stopfade{opacity:.5}
.verificationcontent{padding:30px}
.verificationcontent p{font-size:18px;text-align:center}
.verificationcontent h1{text-align:center;font-size:24px;font-weight:bold;color:#8bc34a}
.verificationcontent h1 i{font-size:80px}
.verificationcontent form{text-align:center}
.verificationcontent input{text-align:center;width:200px;font-size:16px;font-weight:bold}
.secureoptions{width:265px;margin:auto;margin-top:35px;font-size:16px;font-weight:600;margin-bottom:15px}
.notverification{font-size:13px;color:#b5b5b5;width:100%;text-align:center;display:inline-block;margin-top:20px}
.notverification a{color:#b5b5b5;font-weight:600}
#uyeolgiris{position:fixed;overflow:auto;margin-bottom:0;width:100%;height:100%;bottom:0px;background-image:url(<?php echo $tadress;?>images/noisebg.png);background-color:rgba(50, 90, 108, 0.55);background-repeat:repeat}
#uyeolgirisbody .footer{display:none}
.uyeolgirisyap{float:none;width:400px;margin:auto;border-radius:27px;    -webkit-animation-name: fadeIn;
  animation-name: fadeIn;
  -webkit-animation-duration: 2s;
  animation-duration: 2s;
  -webkit-animation-fill-mode: both;
  animation-fill-mode: both;}
  @-webkit-keyframes fadeIn {
  0% {opacity: 0;}
  100% {opacity: 1;}
  }
  @keyframes fadeIn {
  0% {opacity: 0;}
  100% {opacity: 1;}
  }
.uyeol{display:inline-block;width:100%;margin:auto;float:none;border-radius:10px;margin-bottom:0px;background:rgba(0,0,0,0.25);box-shadow:0 5px 30px rgba(0,0,0,0.26);color:rgba(255, 255, 255, 0.75)}
.uyeolgirisslogan{float:left;width:100%;text-align:left;margin-top:0;display:none}
.uyeolgirishead{text-align:center;width:100%;margin-top:9%;margin-bottom:0;float:none; -webkit-animation-name: fadeIn;
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
#uyeolgiris input{background:transparent;color:rgba(255,255,255,0.75);border-bottom-color:rgba(255,255,255,0.58)}
#uyeolgiris #gsm {padding-left: 90px;}
.uyeolgirisyap .btn{width:200px;background:transparent;    padding: 12px 0px;}
.clientcopyright{width:100%;text-align:center;font-size:13px;margin-top:15px;margin-bottom:30px;color:#b4b4b4;display:inline-block}
.clientcopyright a{color:#b4b4b4}
.socialconnect{display:inline-block;border:none;padding-bottom:0px;margin-bottom:0px}
.footsosyal{margin-top:15px}
.footsosyal a{color:#a1a1a1}
.footsosyal a:hover{background:#eee}
#girisyapright h4{display:none}
.footsosyal{display:none}
.createnewaccountlink{color:rgba(255,255,255,0.58);font-weight:600;margin-bottom:10px;display:inline-block;}
.createnewaccountlink:hover{color:rgba(255,255,255,1.58)}
.checktext a{color:rgba(255,255,255,0.58)}
.checktext a:hover{color:rgba(255,255,255,1.58)}
.country-name{color:#999}
.selected-dial-code{color:rgba(255, 255, 255, 0.75)}

@media only screen and (min-width:320px) and (max-width:1024px){
.uyeolgirishead{width:100%;margin-top:15%}
.uyeolgirishead .logo {    margin-bottom: 25px;}
.uyeolgirisyap{width:100%}
#wrapper{width:90%}
.uyeol{width:100%;position:relative;border-right:none}
.signupcon{position:relative}
#uyeolgiris{overflow-x:auto}
.uyeolgirisslogan{text-align:center}
.uyeolgirisslogan h4{width:90%;font-size:17px;margin:auto;margin-top:25px}
}
</style>

</head>
<body id="uyeolgirisbody">

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
                    result:"signin_submit",
                });
            });

            $("#btn_resend").click(function(){
                $("#TwoFactorForm input[name=action]").val("two-factor-resend");
                MioAjaxElement(this,{
                    waiting_text: "<?php echo addslashes(__("website/others/button1-pending")); ?>",
                    form: $("#TwoFactorForm"),
                    result:"signin_submit",
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
                    result:"signin_submit",
                });
            });

            $("#btn_resend2").click(function(){
                $("#Location_Verification_Form input[name=apply]").val("resend");
                MioAjaxElement(this,{
                    waiting_text: "<?php echo addslashes(__("website/others/button1-pending")); ?>",
                    form: $("#Location_Verification_Form"),
                    result:"signin_submit",
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


<video poster="<?php echo $tadress;?>images/signbg.jpg" id="bgvid" playsinline autoplay muted loop>
    <source src="<?php echo $tadress;?>images/signbg.mp4" type="video/mp4">
</video>


<div id="uyeolgiris">
    <div id="wrapper">
        <div class="uyeolgirishead">
            <div class="logo"> <a href="<?php echo $home_link; ?>"><img title="" alt="" src="<?php echo $sign_logo_link;?>" width="253" height="auto"></a></div>
            <h1><?php echo __("website/sign/in-title"); ?></h1>
        </div>



        <div class="uyeolgirisyap">

            <div style="display:none" id="uyegirisloganleft" class="uyeolgirisslogan"><h4><?php echo __("website/sign/in-text1"); if($sign_up) echo __("website/sign/in-text2");?></h4>
                <?php if($sign_up): ?>
                <a href="<?php echo $register_link;?>" class="gonderbtn"><?php echo __("website/sign/in-button-up"); ?></a>
                <?php endif; ?>
            </div>


            <div class="uyeol" id="girisyapright">
                <div class="signupcon">
                    <div class="padding30">

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


                    <?php if(!Filter::GET("open") || Filter::GET("open") == "login"): ?>

                    <!-- Form Start -->
                    <form action="<?php echo $login_link;?>" method="POST" id="Signin_Form">
                        <?php echo Validation::get_csrf_token('sign'); ?>

                            <table width="100%" border="0">
                                <tbody>
                                <tr>
                                    <td>
                                        <h4><i class="fa fa-sign-in" aria-hidden="true"></i> <strong><?php echo __("website/sign/in-form-title"); ?></strong></h4>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <input name="email" type="text" placeholder="<?php echo __("website/sign/in-form-email"); ?>" autocomplete="off"></td>
                                </tr>

                                <tr>
                                    <td>
                                        <input name="password" type="password" placeholder="<?php echo __("website/sign/in-form-password"); ?>" autocomplete="off"></td>
                                </tr>

                                <tr>
                                    <td style="padding-top:10px;" colspan="2">
                                        <input id="checkbox-4" class="checkbox-custom" name="remember" value="1" type="checkbox" style="width:100px;">
                                        <label for="checkbox-4" class="checkbox-custom-label"><span class="checktext"><?php echo __("website/sign/in-form-remember"); ?></span></label>
                                        <a class="sifreunuttulink" href="javascript:void(0);" onclick="forget_password();"><?php echo __("website/sign/in-form-forget"); ?></a>
                                    </td>
                                </tr>

                                <?php if(isset($captcha_sign_in) && $captcha_sign_in): ?>
                                    <tr>
                                        <td>
                                            <div class="captcha-content">
                                                <div><?php echo $captcha_sign_in->getOutput(); ?></div>
                                                <?php if($captcha_sign_in->input): ?>
                                                    <input class="captchainput" name="<?php echo $captcha_sign_in->input_name; ?>" type="text" placeholder="<?php echo ___("needs/form-captcha-label"); ?>">
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>


                                <tr>
                                    <td style="border:none">
                                        <div class="clear" style="margin-bottom: 15px;"></div>
                                        <div align="center">
                                            <button type="button" style="float:none;" mio-ajax-options='{"waiting_text":"<?php echo addslashes(__("website/others/button1-pending")); ?>","result":"signin_submit"}' class="btn mio-ajax-submit"><?php echo __("website/sign/in-form-submit"); ?></button>
                                            <div class="clear"></div>
                                            <?php if($sign_up): ?>
                                                <a href="<?php echo $register_link;?>" class="createnewaccountlink">+ <?php echo __("website/sign/in-button-up"); ?></a>
                                            <?php endif; ?>
                                        </div>

                                        
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                    </form>
                    <!-- Form End -->
                    <?php endif; ?>

                    <?php if(((!isset($captcha_sign_forget) || !isset($captcha_sign_in)) && !Filter::GET("open")) || Filter::GET("open") == "forget"): ?>
                    <form action="<?php echo $forget_password_link;?>" method="POST" id="Signforget_Form"<?php echo Filter::GET("open") == "forget" ? '' : ' style="display: none";'; ?>>
                        <?php echo Validation::get_csrf_token('sign'); ?>

                        <table width="100%" border="0" id="forget_table">
                            <tbody>
                            <tr>
                                <td><h4><i class="fa fa-sign-in" aria-hidden="true"></i> <strong><?php echo __("website/sign/forget-form-title"); ?></strong></h4></td>
                            </tr>

                            <tr>
                                <td>
                                    <input name="email" type="text" placeholder="<?php echo __("website/sign/forget-form-email"); ?>"></td>
                            </tr>

                            <tr>
                                <td style="padding-top:10px;" colspan="2">
                                    <a class="sifreunuttulink" href="javascript:void(0);" onclick="login();"><?php echo __("website/sign/forget-form-login"); ?></a>
                                </td>
                            </tr>

                            <?php if(isset($captcha_sign_forget) && $captcha_sign_forget): ?>
                                <tr>
                                    <td>
                                        <div class="captcha-content" style="width:304px;margin:auto;">
                                            <div style="float:left;"> <?php echo $captcha_sign_forget->getOutput(); ?></div>
                                            <?php if($captcha_sign_forget->input): ?>
                                                <input class="captchainput" name="<?php echo $captcha_sign_forget->input_name; ?>" type="text" placeholder="<?php echo ___("needs/form-captcha-label"); ?>">
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>


                            <tr>
                                <td style="border:none">
                                    <div class="clear" style="margin-bottom: 15px;"></div>
                                    <div align="center">
                                        <button type="button" style="float:none;" mio-ajax-options='{"waiting_text":"<?php echo addslashes(__("website/others/button1-pending")); ?>","result":"forget_submit"}' class="btn mio-ajax-submit"><?php echo __("website/sign/forget-form-submit"); ?></button>
                                        <div class="clear"></div>
                                        <div class="error" id="Signforget_Form_output" align="center" style="display:none;font-weight:bold;"></div>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <!-- Success Div -->
                        <div id="forget_success" style="display:none">
                            <div style="margin-top:30px;margin-bottom:70px;text-align:center;">
                                <i style="font-size:80px;    margin-bottom: 25px;" class="fa fa-check"></i>
                                <h4 style="font-weight:bold;"><?php echo __("website/sign/forget-success-title"); ?></h4>
                                <br>
                                <h5><?php echo __("website/sign/forget-success-content"); ?></h5>
                            </div>
                        </div>
                        <!-- Success Div -->

                    </form>
                    <!-- Form END -->
                    <?php endif; ?>

                    <!-- Success Div -->
                    <div id="Success_Div" style="display:none">
                        <div style="margin-top:30px;margin-bottom:70px;text-align:center;">
                            <i style="font-size:80px;color:green;" class="fa fa-check"></i>
                            <h4 style="color:green;font-weight:bold;"><?php echo __("website/sign/in-success-title"); ?></h4>
                            <br>
                            <h5><?php echo __("website/sign/in-success-content"); ?></h5>
                        </div>
                    </div>
                    <!-- Success Div -->

                    <script type="text/javascript">
                        function forget_password() {
                            <?php if(isset($captcha_sign_in) && isset($captcha_sign_forget)): ?>
                            window.location.href = "<?php echo $login_link; ?>?open=forget";
                            <?php else: ?>
                            $("#Signin_Form").fadeOut(100,function () {
                                $("#Signforget_Form").fadeIn(100);
                            });
                            <?php endif; ?>
                        }
                        function login() {
                            <?php if(isset($captcha_sign_in) && isset($captcha_sign_forget)): ?>
                            window.location.href = "<?php echo $login_link; ?>?open=login";
                            <?php else: ?>
                            $("#Signforget_Form").fadeOut(100,function () {
                                $("#Signin_Form").fadeIn(100);
                            });
                            <?php endif; ?>
                        }
                        function signin_submit(result) {
                            <?php if(isset($captcha_sign_in)) echo $captcha_sign_in->submit_after_js(); ?>
                            if(result != ''){
                                var solve = getJson(result);
                                if(solve !==false && solve != undefined && typeof(solve) == "object"){
                                    if(solve.status == "error"){
                                        if(solve.js != undefined && solve.js != '') eval(solve.js);
                                        if(solve.for != undefined && solve.for != ''){
                                            $("#Signin_Form "+solve.for).focus();
                                            $("#Signin_Form "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                            $("#Signin_Form "+solve.for).change(function(){
                                                $(this).removeAttr("style");
                                            });
                                        }

                                        if(solve.message != undefined && solve.message != '')
                                            alert_error(solve.message,5000);

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
                                    else if(solve.status == "successful"){
                                        window.location.href = solve.redirect;
                                    }
                                }
                            }
                        }
                        function forget_submit(result) {
                            <?php if(isset($captcha_sign_forget)) echo $captcha_sign_forget->submit_after_js(); ?>
                            if(result != ''){
                                var solve = getJson(result);
                                if(solve !==false && solve != undefined && typeof(solve) == "object"){
                                    if(solve.status == "error"){
                                        if(solve.js != undefined && solve.js != '') eval(solve.js);
                                        if(solve.for != undefined && solve.for != ''){
                                            $("#Signforget_Form "+solve.for).focus();
                                            $("#Signforget_Form "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                            $("#Signforget_Form "+solve.for).change(function(){
                                                $(this).removeAttr("style");
                                            });
                                        }

                                        if(solve.message != undefined && solve.message != '')
                                            alert_error(solve.message,{timer:4000});
                                    }else if(solve.status == "sent"){
                                        $("#forget_table").fadeOut(750,function() {
                                            $("#forget_success").fadeIn(750);
                                        })
                                    }
                                }
                            }
                        }
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

                </div>


            </div>


            </div>

        </div>


    </div><div class="clear"></div>
</div>

<?php include __DIR__.DS."inc".DS."sign-footer.php"; ?>