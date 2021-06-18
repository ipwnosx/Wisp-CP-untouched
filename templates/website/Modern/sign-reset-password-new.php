<?php defined('CORE_FOLDER') OR exit('You can not get in here!'); ?><!DOCTYPE html>
<html lang="<?php echo ___("package/code"); ?>">
<head>

    <?php
        $master_content_none = true;
        $hoptions = ['page' => "sign-in"];
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

        });
    </script>

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
#uyeolgiris input{border-radius:5px}
.signup-stages-block.active{background:#<?php echo Config::get("theme/color1");?>;color:white}
.clean-theme-signup-box .yuzde50{width:47%}
.signin-signup-foot-btn{text-align:center;margin-top: 35px;}
.signin-signup-foot-btn button{font-family:'Titillium Web',sans-serif;float:none;width:250px;cursor:pointer;outline:none;-webkit-transition:all 0.3s ease-out;-moz-transition:all 0.3s ease-out;-ms-transition:all 0.3s ease-out;-o-transition:all 0.3s ease-out;transition:all 0.3s ease-out;}
.signin-signup-foot-btn button:hover {background:#77a83f;}
.signup-stages{float:left;margin-bottom:20px;width:100%;text-align:center}
.signup-stages-block{background:#eee;width:85px;height:85px;display:inline-block;border-radius:100%;text-align:center;line-height:85px;margin:0px 7%;font-weight:300;font-size:32px}
.signup-stage-line{width:100%;height:10px;background:#eee;margin-top:50px;float:left;margin-bottom:-55px;border-radius:3px}
#Reset_Password_Form{width:70%;margin:auto;margin-top:105px}
#Reset_Password_Form input{margin-bottom:20px}
#Signforget_Form{width:70%;margin:auto;margin-top:105px}
#Signforget_Form input{margin-bottom:20px}

@media only screen and (min-width:320px) and (max-width:1024px){
.uyeolgirishead{width:100%;margin-top:15%}
.uyeolgirishead .logo {    margin-bottom: 25px;}
.uyeolgirisyap{width:100%}
#wrapper{width:90%}
.uyeol{width:100%;position:relative;border-right:none}
.signupcon{position:relative}
#uyeolgiris{overflow-x:auto;background-size:auto 120%;background-position:center}
.uyeolgirisslogan{text-align:center;width:100%}
.uyeolgirisslogan h4{width:90%;font-size:17px;margin:auto;margin-top:25px}
.uyeolgirisslogan-con{width:90%;margin:auto;margin-top:55px}
.signupcon .padding30 {    padding: 0px;}
.socialconnect {    margin-bottom: 20px;    width: 100%;}
.signup-stages-block{width:75px;height:75px;line-height:75px;margin:0px 4%;font-size:28px}
.signup-stage-line {    margin-bottom: -45px;}
.clean-theme-signup-box .yuzde50 {    width: 46%;}
#Reset_Password_Form {    width: 100%;}
.captcha-content{width:310px;transform:scale(0.8);margin-left:auto;margin-top:0;margin-bottom:10px}
.signin-signup-foot-btn{margin-bottom:25px}
}

</style>

</head>

<body id="uyeolgirisbody">

    
            <!--h1><?php echo __("website/sign/reset-password-title"); ?></h1-->


<div id="uyeolgiris">
    <div id="new-signin-signup"> 


        <div class="uyeolgirisyapx">

             <div class="uyeolgirisslogan">

                <div class="uyeolgirisslogan-con">

                <div class="logo"> 
                    <a href="<?php echo $home_link; ?>"><img title="" alt="" src="<?php echo $sign_logo_link;?>" width="253" height="auto"></a>
                </div>

                <h4><?php echo __("website/sign/in-text1"); if($sign_up) echo __("website/sign/in-text2");?></h4>
                <?php if($sign_up): ?>
                <a href="<?php echo $register_link;?>" class="gonderbtn"><?php echo __("website/sign/in-button-up"); ?></a>
                <?php endif; ?>

            </div>
            </div>


           <div class="uyeol">
                <div class="signupcon">
                    <div class="padding30">
                   <h1 class="signinsignup-title"><?php echo __("website/sign/rstpswd-text6"); ?></h1>
                   <div class="line"></div>
                    <?php
                        if(isset($user_id) && $user_id){

                            ?>
                            <form action="<?php echo $controller_link;?>" method="POST" class="mio-ajax-form" id="Reset_Password_Form">
                                <?php echo Validation::get_csrf_token('sign'); ?>


                                <!-- Information FORM -->
                                <div id="Information">


                                    <h4><strong><?php echo __("website/sign/rstpswd-text7"); ?></strong></h4>

                                    <p style="font-size: 20px;"><?php echo __("website/sign/rstpswd-text8"); ?></p>
                                   

                                        <?php
                                            if(isset($by_name) && $by_name == "mobile" && isset($security_question)){
                                                ?>
                                               
                                                        <div><input name="security_question_answer" type="text" placeholder="<?php echo $security_question; ?>" required></div>
                                                   
                                                <?php
                                            }
                                        ?>

                                      
                                                <div><input name="password" type="password" placeholder="<?php echo __("website/sign/up-form-password"); ?>" required></div>
                                                <div><input name="password_again" type="password" placeholder="<?php echo __("website/sign/up-form-password_again"); ?>" required></div>
                                       


                                       
                                               <div class="signin-signup-foot-btn">
                                                    <button type="button" class="yesilbtn gonderbtn mio-ajax-submit" mio-ajax-options='{"result":"reset_password_submit","waiting_text":"<?php echo addslashes(__("website/others/button1-pending")); ?>"}'><?php echo __("website/sign/rstpswd-text3"); ?></button>
                                                    <div class="clear"></div>
                                                    <div class="error" id="FormOutput" align="center" style="display:none;font-weight:bold;"></div>
                                                </div>
                                       
                                </div>
                                <!-- Information FORM -->
                            </form>

                            <!-- SUCCESS -->
                            <div id="Success_div" style="display:none">
                                <div style="margin-top:15%;margin-bottom:70px;text-align:center;">
                                    <i style="font-size:80px;" class="fa fa-check"></i>
                                    <h4 style="font-weight:bold;    font-size: 26px;border:none;"><?php echo __("website/sign/rstpswd-text4"); ?></h4>
                                    <h5><?php echo __("website/sign/rstpswd-text5"); ?></h5>
                                </div>
                            </div>
                            <!-- SUCCESS -->

                            <script type="text/javascript">
                                function reset_password_submit(result){
                                    if(result != ''){
                                        var solve = getJson(result);
                                        if(solve !==false && solve != undefined && typeof(solve) == "object"){
                                            if(solve.status == "error"){
                                                if(solve.for != undefined && solve.for != ''){
                                                    $("#Reset_Password_Form "+solve.for).focus();
                                                    $("#Reset_Password_Form "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                                    $("#Reset_Password_Form "+solve.for).change(function(){
                                                        $(this).removeAttr("style");
                                                    });
                                                }
                                                if(solve.message != undefined && solve.message != '')
                                                    $("#FormOutput").fadeIn(750).html(solve.message);
                                                else if(solve.message == undefined)
                                                    $("#FormOutput").fadeOut(750).html('');
                                                else
                                                    $("#FormOutput").fadeOut(750).html('');

                                            }else if(solve.status == "successful"){
                                                $("#FormOutput").fadeOut(750).html('');
                                                $("#Reset_Password_Form").fadeOut(750,function(){
                                                    $("#Success_div").fadeIn(750);
                                                    if(solve.redirect != undefined){
                                                        setTimeout(function(){
                                                            window.location.href = solve.redirect;
                                                        },5000);
                                                    }
                                                });
                                            }
                                        }else
                                            console.log(result);
                                    }
                                }
                            </script>
                            <?php

                        }
                        else{
                            ?>
                            <div style="margin-top:15%;margin-bottom:70px;text-align:center;">
                                <i style="font-size:80px;" class="fa fa-info-circle"></i>
                                <br>
                                <br>
                                <h4 style="font-weight:bold; font-size: 26px;border:none;"><?php echo __("website/sign/rstpswd-text1"); ?></h4>
                                <h5><?php echo __("website/sign/rstpswd-text2"); ?></h5>
                            </div>
                            <?php
                        }
                    ?>


                    </div>
                </div>
            </div>
        </div>


    </div>
</div>

<?php include $tpath."inc/sign-footer.php"; ?>