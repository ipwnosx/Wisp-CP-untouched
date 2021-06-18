<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    if(Config::get("theme/new-login-area"))
    {
        include __DIR__.DS."sign-up-new.php";
        return false;
    }
    $master_content_none = true;
    $connectionButtons = Hook::run("ClientAreaConnectionButtons","register");
?>
<!DOCTYPE html>
<html lang="<?php echo ___("package/code"); ?>">
<head>
    <?php
        $hoptions = [
            'page' => "sign-in",
            'intlTelInput'
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
#uyeolgiris input{background:transparent;color:rgba(255,255,255,0.75);border-bottom-color:rgba(255,255,255,0.58)}
.uyeolgirisyap .btn{width:200px;background:transparent;    padding: 12px 0px;}
.clientcopyright{width:100%;text-align:center;font-size:13px;margin-top:15px;margin-bottom:30px;color:#b4b4b4;display:inline-block}
.clientcopyright a{color:#b4b4b4}
.socialconnect{display:inline-block;border:none;padding-bottom:0px;margin-bottom:0px}
.footsosyal{margin-top:15px}
.footsosyal a{color:#a1a1a1}
.footsosyal a:hover{background:#eee}
#girisyapright h4{display:none}
.footsosyal{display:none}
.createnewaccountlink{color:rgba(255,255,255,0.58);font-weight:600;margin-bottom:10px;display:inline-block}
.createnewaccountlink:hover{color:rgba(255,255,255,1.58)}
.checktext a{color:rgba(255,255,255,0.58)}
.checktext a:hover{color:rgba(255,255,255,1.58)}
.country-name{color:#999}
.selected-dial-code{color:rgba(255, 255, 255, 0.75)}
#uyeolgiris #gsm {
    padding-left: 90px;
}

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
#gsm {width: 100%;padding-left:90px;}
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

<video poster="<?php echo $tadress;?>images/signbg.jpg" id="bgvid" playsinline autoplay muted loop>
    <source src="<?php echo $tadress;?>images/signbg.mp4" type="video/mp4">
</video>


<div id="uyeolgiris">
    <div id="wrapper">
        <div class="uyeolgirishead">
            <div class="logo"> <a href="<?php echo $home_link; ?>"><img title="" alt="" src="<?php echo $sign_logo_link;?>" width="253" height="auto"></a></div>
            <h1><?php echo __("website/sign/up-title"); ?></h1>
        </div>


        <div class="uyeolgirisyap">

            <div class="uyeolgirisslogan"><h4><?php echo __("website/sign/up-text1");
            if($sign_in) echo __("website/sign/up-text2"); ?> 
                 </h4><div class="clear"></div>
                <?php if($sign_in): ?>
              
                <a href="<?php echo $login_link; ?>" class="gonderbtn"><?php echo __("website/sign/up-button-in"); ?></a>
                <?php endif; ?>
            </div>


           
            <div class="uyeol">
                 
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


                    <form action="<?php echo $register_link;?>" method="POST" class="mio-ajax-form" id="Signup_Form">
                        <?php echo Validation::get_csrf_token('sign'); ?>

                        <input type="hidden" name="stage" value="1">

                        <!-- Information FORM -->
                        <div id="Information" style="overflow:hidden;">                         

                            <table width="100%" border="0">
                                <tbody>

                                <?php
                                    if($kind_status):
                                ?>
                                <tr style="display:none;">
                                    <td height="50" style="border-bottom: 1px solid #ccc;    line-height: 35px;">
                                        <span style="margin-right:30px;float:left;"><?php echo __("website/sign/up-form-kind"); ?></span>
                                        <div class="clearmob"></div>
                                        <input id="kind_1" class="radio-custom" name="kind" value="individual" type="radio" checked>
                                        <label for="kind_1" class="radio-custom-label" style="margin-right: 28px;"><span class="checktext"><?php echo __("website/sign/up-form-kind-1"); ?></span></label>

                                        <input id="kind_2" class="radio-custom" name="kind" value="corporate" type="radio">
                                        <label for="kind_2" class="radio-custom-label" style="margin-right: 28px;"><span class="checktext"><?php echo __("website/sign/up-form-kind-2"); ?></span></label>
                                    </td>
                                </tr>
                                <?php endif; ?>

                                <tr>
                                    <td><input name="full_name" type="text" placeholder="<?php echo __("website/sign/up-form-full_name"); ?>" required></td>
                                </tr>
                                <tr>
                                    <td><input name="email" type="text" placeholder="<?php echo __("website/sign/up-form-email"); echo ($email_verify_status) ? " ".__("website/sign/up-form-email-verify") : ''; ?>" required></td>
                                </tr>
                                <?php
                                    if($gsm_status):
                                ?>
                                <tr>
                                    <td>
                                        <input id="gsm" type="text"<?php echo ($gsm_required) ? ' required' : '' ?> placeholder="<?php echo __("website/sign/up-form-gsm"); echo ($sms_verify_status) ? " ".__("website/sign/up-form-gsm-verify") : ''; ?>" onkeypress="return event.charCode>= 48 &amp;&amp;event.charCode<= 57">
                                    </td>
                                </tr>
                                <?php endif; ?>

                                <?php if($kind_status): ?>
                                <tr class="kind-content kind_2" style="display:none;">
                                    <td>
                                        <input name="company_name" type="text" placeholder="<?php echo __("website/sign/up-form-cname"); ?>" required>
                                    </td>
                                </tr>

                                <tr class="kind-content kind_2" style="display:none;">
                                    <td>
                                        <div class="yuzde50"><input name="company_tax_number" type="text" placeholder="<?php echo __("website/sign/up-form-ctaxno"); ?>" required></div>
                                        <div class="yuzde50"><input name="company_tax_office" type="text" id="vergi_dairesi" placeholder="<?php echo __("website/sign/up-form-ctaxoff"); ?>" required></div>
                                    </td>
                                </tr>
                                <?php endif; ?>

                                <tr>
                                    <td colspan="2">
                                        <div class="yuzde50"><input name="password" type="password" placeholder="<?php echo __("website/sign/up-form-password"); ?>" required></div>
                                        <div class="yuzde50"><input name="password_again" type="password" placeholder="<?php echo __("website/sign/up-form-password_again"); ?>" required></div>
                                    </td>
                                </tr>


                                <tr>
                                    <td style="padding-top:7px;text-align:center;padding-top:10px;">
                                        <input id="checkbox-5" class="checkbox-custom" name="contract" value="1" type="checkbox" required>
                                        <label for="checkbox-5" class="checkbox-custom-label"><span class="checktext"><?php echo __("website/sign/up-form-contract"); ?></span></label>
                                    </td>
                                </tr>

                                <?php if(isset($captcha) && $captcha): ?>
                                    <tr>
                                        <td colspan="2">
                                            <div class="captcha-content">
                                                <div><?php echo $captcha->getOutput(); ?></div>
                                                <?php if($captcha->input): ?>
                                                    <input class="captchainput" name="<?php echo $captcha->input_name; ?>" type="text" placeholder="<?php echo ___("needs/form-captcha-label"); ?>">
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>

                                <tr>
                                    <td style="border:none">
                                        <div class="clear" style="margin-bottom: 15px;"></div>
                                        <div align="center">
                                            <button type="button" style="float:none;" class="btn mio-ajax-submit" mio-ajax-options='{"result":"signup_submit","waiting_text":"<?php echo addslashes(__("website/others/button1-pending")); ?>"}'><?php echo __("website/sign/up-form-submit"); ?></button>
                                            <div class="clear"></div>
                                            <div class="clear"></div>
                                            <?php if($sign_in): ?>
                                                <a href="<?php echo $login_link; ?>" class="createnewaccountlink"><i class="fa fa-sign-in" aria-hidden="true"></i> <?php echo __("website/sign/up-button-in"); ?></a>
                                            <?php endif; ?>
                                            <div class="error" id="FormOutput" align="center" style="display:none;font-weight:bold;"></div>
                                        </div>
                                    </td>
                                </tr>
                                </tbody></table>
                        </div>
                        <!-- Information FORM -->
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

                    <script type="text/javascript">
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


    </div>
</div>

<?php include __DIR__.DS."inc".DS."sign-footer.php"; ?>