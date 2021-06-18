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
    <!-- Meta Tags -->


    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo $tadress; ?>css/admio.css?v=<?php echo License::get_version(); ?>">
    <link rel="stylesheet" href="<?php echo $tadress; ?>css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Titillium+Web:200,300,500,400,600,700&amp;subset=latin-ext" rel="stylesheet">
    <?php
        View::admin_main_style();
    ?>
    <!-- CSS -->

    <!-- JS -->
    <script src="<?php echo $tadress; ?>js/jquery-1.11.3.min.js"></script>
    <script src="<?php echo $tadress; ?>js/admio-login.js?v=<?php echo License::get_version(); ?>"></script>
    <?php
        View::admin_main_script();
    ?>
    <!-- JS -->

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
            $("#ResetPasswordForm").on("submit",function(e){
                e.preventDefault()
                MioAjaxElement($("#LoginButton"),{
                    type:"direct",
                    method:"POST",
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    result:"Login_Handler",
                });
            });

            $("#ResetPasswordForm input:first").focus();

        });


        function Login_Handler(result){
            if(result != ''){
                var solve = getJson(result);
                if(solve !== false){
                    if(solve.status == "error"){
                        if(solve.for != undefined && solve.for != ''){
                            $("#ResetPasswordForm "+solve.for).focus();
                            $("#ResetPasswordForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                            $("#ResetPasswordForm "+solve.for).change(function(){
                                $(this).removeAttr("style");
                            });
                        }
                        if(solve.message != undefined && solve.message != '')
                            alert_error(solve.message,{timer:5000});
                    }else if(solve.status == "successful"){
                        if(solve.redirect !== undefined){

                            if(solve.message !== undefined && solve.message != '')
                                alert_success(solve.message,{timer:5000});

                            setTimeout(function(){
                                window.location.href = solve.redirect;
                            },5000);
                        }
                    }
                }else
                    console.log(result);
            }
        }

    </script>
    <!-- JS -->
</head>
<body id="loginbg">

<video poster="<?php echo $tadress; ?>images/loginposter.jpg?v=<?php echo License::get_version(); ?>" id="bgvid" playsinline autoplay muted loop>
    <source src="<?php echo $tadress; ?>images/loginvideo.mp4?v=<?php echo License::get_version(); ?>" type="video/mp4">
</video>

<div id="wrapper">

    <div id="login">

        <div class="adminlogo"><img src="<?php echo Utility::image_link_determiner("resources/uploads/logo/admin-logo.svg"); ?>?v=<?php echo License::get_version(); ?>" width="250" height="auto"></div>

        <div class="loginpanel">

            <div class="padding20">
                <?php
                    if(isset($user_id) && $user_id){
                        ?>
                        <form action="<?php echo $controller_link; ?>" method="post" id="ResetPasswordForm" autocomplete="off">
                            <?php echo Validation::get_csrf_token('admin-sign'); ?>

                            <div class="logininputs">
                                <input name="password" type="password"  placeholder="<?php echo __("website/sign/up-form-password"); ?>" required="required">
                                <input name="password_again" type="password"  placeholder="<?php echo __("website/sign/up-form-password_again"); ?>" required="required">
                            </div>
                            <input type="submit" style="display: none;" id="login_submit">
                            <a href="javascript:$('#login_submit').click();void 0;" id="LoginButton" class="gonderbtn"><?php echo __("website/sign/rstpswd-text3"); ?></a>
                        </form>
                        <?php

                    }
                    else{
                        ?>
                        <div style="margin-top:30px;margin-bottom:70px;text-align:center;">
                            <i style="font-size:80px;" class="fa fa-info-circle"></i>
                            <br>
                            <br>
                            <h4 style="font-weight:bold;border:none;"><?php echo __("website/sign/rstpswd-text1"); ?></h4>
                            <h5 style="font-size:16px;"><?php echo __("website/sign/rstpswd-text2"); ?></h5>
                        </div>
                        <?php
                    }
                ?>
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