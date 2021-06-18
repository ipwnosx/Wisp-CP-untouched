<!DOCTYPE html>
<html>
<head>

    <!-- Meta Tags -->
    <title><?php echo $meta["title"]; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="robots" content="none" />
    <link rel="canonical" href="<?php echo $canonical_link;?>" />
    <link rel="icon" type="image/x-icon" href="<?php echo $favicon_link;?>" />
    <meta name="theme-color" content="#2c5062">
    <!-- Meta Tags -->


    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo $tadress; ?>css/admio.css?v=<?php echo License::get_version(); ?>">
    <link rel="stylesheet" href="<?php echo $tadress; ?>css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Titillium+Web:200,300,500,400,600,700&amp;subset=latin-ext" rel="stylesheet">
    <?php
        View::admin_main_style();
    ?>
    <style type="text/css">
        .verificationcontent {padding:30px;}
        .verificationcontent p {font-size:18px;text-align:center;}
        .verificationcontent h1 {text-align:center;font-size:24px;font-weight:bold;    color: #8bc34a;}
        .verificationcontent h1 i{    font-size: 80px;}
        .verificationcontent form {text-align:center;}
        .verificationcontent input {
            text-align: center;
            width: 200px;
            font-size: 16px;
            font-weight: bold;
        }
        .secureoptions {width:265px;margin:auto;margin-top: 35px;font-size: 16px;font-weight: 600;margin-bottom: 15px;}
        .notverification {
            font-size: 13px;
            color: #b5b5b5;
            width: 100%;
            text-align: center;
            display: inline-block;
            margin-top: 20px;
        }
        .notverification a {color: #b5b5b5;font-weight:600;}
    </style>
    <!-- CSS -->

    <!-- JS -->
    <script src="<?php echo $tadress; ?>js/jquery-1.11.3.min.js"></script>
    <script src="<?php echo $tadress; ?>js/admio-login.js"></script>
    <?php
        View::admin_main_script();
    ?>
    <!-- JS -->

    <script src="<?php echo $sadress; ?>assets/plugins/js/jquery.countdown.min.js"></script>

    <script type="text/javascript">
        var vid = document.getElementById("bgvid");

        $(document).ready(function(){
            if (window.matchMedia('(prefers-reduced-motion)').matches) {
                if(vid !== null){
                    vid.removeAttr("autoplay");
                    vid.pause();
                }
            }
        });

        function vidFade() {
            vid.classList.add("stopfade");
        }

        $(document).ready(function(){
            $("#LoginForm").on("submit",function(e){
                e.preventDefault()
                MioAjaxElement($("#LoginButton"),{
                    type:"direct",
                    method:"POST",
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    result:"Login_Handler",
                });
            });

            $("#ForgetForm").on("submit",function(e){
                e.preventDefault();
                MioAjaxElement($("#ForgetButton"),{
                    type:"direct",
                    method:"POST",
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    result:"Forget_Handler",
                });
            });

            $("#LoginForm input:first").focus();

        });


        function Login_Handler(result){
            if(result != ''){
                var solve = getJson(result);
                if(solve !== false){
                    if(solve.status == "error"){
                        if(solve.for != undefined && solve.for != ''){
                            $("#LoginForm "+solve.for).focus();
                            $("#LoginForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                            $("#LoginForm "+solve.for).change(function(){
                                $(this).removeAttr("style");
                            });
                            }
                            if(solve.message != undefined && solve.message != '')
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
                    else if(solve.status == "successful"){
                        window.location.href = solve.redirect;
                    }
                }else
                    console.log(result);
            }
        }

        function Forget_Handler(result) {
            if(result != ''){
                var solve = getJson(result);
                if(solve !== false){
                    if(solve.status == "error"){
                        if(solve.for != undefined && solve.for != ''){
                            $("#ForgetForm "+solve.for).focus();
                            $("#ForgetForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                            $("#ForgetForm "+solve.for).change(function(){
                                $(this).removeAttr("style");
                            });
                            }
                        if(solve.message != undefined && solve.message != '')
                            alert_error(solve.message,{timer:5000});
                    }else if(solve.status == "successful"){
                        $("#ForgetForm input[name='email']").val('');
                        alert_success(solve.message);
                    }
                }else
                    console.log(result);
            }
        }

        function getForget(){
            $("#LoginForm").fadeOut(250,function(){
                $("#ForgetForm").fadeIn(250);
                $("#ForgetForm input:first").focus();
            })
        }

        function getLogin() {
            $("#ForgetForm").fadeOut(250,function(){
                $("#LoginForm").fadeIn(250);
                $("#LoginForm input:first").focus();
            })
        }

    </script>
    <!-- JS -->
</head>
<body id="loginbg">

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
                    result:"Login_Handler",
                });
            });

            $("#btn_resend").click(function(){
                $("#TwoFactorForm input[name=action]").val("two-factor-resend");
                MioAjaxElement(this,{
                    waiting_text: "<?php echo addslashes(__("website/others/button1-pending")); ?>",
                    form: $("#TwoFactorForm"),
                    result:"Login_Handler",
                });
            });

        });
    </script>

    <div class="padding20 verificationcontent">
        <h1><i class="fa fa-shield" aria-hidden="true"></i><br><?php echo __("website/sign/security-check"); ?></h1>
        <p><?php echo __("website/sign/security-check-text1"); ?></p>
        <p><?php echo __("website/sign/security-check-text2"); ?><br><strong id="two_factor_phone">*********0000</strong></p>

        <form action="<?php echo $links["controller"];?>" method="post" id="TwoFactorForm">
            <?php echo Validation::get_csrf_token('admin-sign'); ?>


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
                    result:"Login_Handler",
                });
            });

            $("#btn_resend2").click(function(){
                $("#Location_Verification_Form input[name=apply]").val("resend");
                MioAjaxElement(this,{
                    waiting_text: "<?php echo addslashes(__("website/others/button1-pending")); ?>",
                    form: $("#Location_Verification_Form"),
                    result:"Login_Handler",
                });
            });

        });
    </script>
    <div class="padding20 verificationcontent">
        <h1><i class="fa fa-lock" aria-hidden="true"></i><br><?php echo __("website/sign/security-check"); ?></h1>
        <p><?php echo __("website/sign/security-check-text7"); ?></p>
        <p><?php echo __("website/sign/security-check-text8"); ?></p>


        <form action="<?php echo $links["controller"]; ?>" method="post" id="Location_Verification_Form">
            <?php echo Validation::get_csrf_token('admin-sign'); ?>


            <div id="method_selections" style="display: none; text-align: left;">
                <div class="secureoptions">

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
    </div>
</div>

<video poster="<?php echo $tadress; ?>images/loginposter.jpg?v=<?php echo License::get_version(); ?>" id="bgvid" playsinline autoplay muted loop>
    <source src="<?php echo $tadress; ?>images/loginvideo.mp4?v=<?php echo License::get_version(); ?>" type="video/mp4">
</video>


<div id="wrapper">
    <div id="login">

        <div class="adminlogo"><img src="<?php echo Utility::image_link_determiner("resources/uploads/logo/admin-logo.svg"); ?>?v=<?php echo License::get_version(); ?>" width="250" height="auto"></div>

        <div class="loginpanel">

            <div class="padding20">



                <form action="<?php echo $links["controller"]; ?>" method="post" id="LoginForm" autocomplete="off">
                    <?php echo Validation::get_csrf_token('admin-sign'); ?>

                    <div class="logininputs">
                        <input name="email" type="email"  placeholder="<?php echo __("admin/sign/your-email-address"); ?>" required="required">
                        <input name="password" type="password"  placeholder="<?php echo __("admin/sign/your-password"); ?>" required="required">
                        <input id="checkbox-remember" class="checkbox-custom" name="remember" value="1" type="checkbox">
                        <label for="checkbox-remember" class="checkbox-custom-label" style="margin-bottom: 8px;"><?php echo __("admin/sign/remember-me"); ?></label>
                        <a href="javascript:getForget();void 0;" class="parolabtn"><?php echo __("admin/sign/remind-password"); ?></a>
                    </div>
                    <input type="submit" style="display: none;" id="login_submit">
                    <a href="javascript:$('#login_submit').click();void 0;" id="LoginButton" class="gonderbtn"><?php echo __("admin/sign/login-button"); ?></a>
                </form>

                <form action="<?php echo $links["forget"]; ?>" method="post" id="ForgetForm" style="display: none;">
                    <?php echo Validation::get_csrf_token('admin-sign'); ?>

                    <input name="email" type="email"  placeholder="<?php echo __("admin/sign/your-email-address"); ?>" required="required">
                    <a href="javascript:getLogin();void 0;" class="parolabtn"><?php echo __("admin/sign/get-login"); ?></a>
                    <input type="submit" style="display: none;" id="forget_submit">
                    <div class="clear"></div>
                    <br>
                    <a href="javascript:$('#forget_submit').click();void 0;" id="ForgetButton" class="gonderbtn"><?php echo __("admin/sign/forget-button"); ?></a>
                </form>

            </div>

            <div class="loginslogan" style="display:none">
                <h4><strong><?php echo __("admin/sign/sidebar-slogan1"); ?></strong><br><br>
                    <?php echo __("admin/sign/sidebar-slogan2"); ?>
                </h4>
            </div>

        </div>
        <div class="adminlogincpyright">Copyright © <?php echo date("Y"); ?> All Rights Reserved. Powered by <a href="https://www.wisecp.com" target="_blank">WISECP</a></div>
    </div>
</div>

</body>
</html>