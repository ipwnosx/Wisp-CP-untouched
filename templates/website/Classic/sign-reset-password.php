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
 ::-webkit-input-placeholder{color:rgba(255,255,255,0.75)}
:-moz-placeholder{color:rgba(255,255,255,0.75)}
::-moz-placeholder{color:rgba(255,255,255,0.75)}
:-ms-input-placeholder{color:rgba(255,255,255,0.75)}
::-webkit-scrollbar-track{-webkit-box-shadow:inset 0 0 6px rgba(0,0,0,0.3);background-color:#F5F5F5}
::-webkit-scrollbar{width:9px;background-color:#F5F5F5}
::-webkit-scrollbar-thumb{background-color:#607D8B}
video{position:fixed;top:50%;left:50%;min-width:100%;min-height:100%;width:auto;height:auto;z-index:-100;transform:translateX(-50%) translateY(-50%);background-size:cover;transition:1s opacity;opacity:.4;filter:alpha(opacity=40)}
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
#uyeolgiris{position:fixed;overflow:auto;margin-bottom:0;width:100%;height:100%;bottom:0px;background-image:url(<?php echo $tadress;?>images/noisebg.png);background-color:#4872868f;background-repeat:repeat}
#uyeolgirisbody .footer{display:none}
.uyeolgirisyap{float:none;width:400px;margin:auto;border-radius:27px}
.uyeol{display:inline-block;width:100%;margin:auto;float:none;border-radius:10px;margin-bottom:0px;background:rgba(0,0,0,0.25);box-shadow:0 5px 30px rgba(0,0,0,0.26);color:rgba(255, 255, 255, 0.75)}
.uyeolgirisslogan{float:left;width:100%;text-align:left;margin-top:0;display:none}
.uyeolgirishead{text-align:center;width:100%;margin-top:10%;margin-bottom:0;float:none}
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
.socialconnect{display:inline-block;border:none;margin-top:10px;padding-bottom:0px;margin-bottom:0px}
.footsosyal{margin-top:15px}
.footsosyal a{color:#a1a1a1}
.footsosyal a:hover{background:#eee}
#girisyapright h4{display:none}
.footsosyal{display:none}
.createnewaccountlink{color:rgba(255,255,255,0.58);font-weight:600}
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

<video poster="<?php echo $tadress;?>images/uyeolgirisbg.jpg" id="bgvid" playsinline autoplay muted loop>
    <source src="<?php echo $tadress;?>images/uyeolgirisbg.mp4" type="video/mp4">
</video>


<div id="uyeolgiris">
    <div id="wrapper">
        <div class="uyeolgirishead">
            <div class="logo"> <a href="<?php echo $home_link; ?>"><img title="Logo" alt="Logo" src="<?php echo $sign_logo_link;?>" width="253" height="auto"></a></div>
            <h1><?php echo __("website/sign/reset-password-title"); ?></h1>
        </div>


        <div class="uyeolgirisyap">

            <div class="uyeolgirisslogan">
                <h4><?php echo __("website/sign/up-text1"); echo __("website/sign/up-text2"); ?></h4>
                <br><br>
                <a href="<?php echo $login_link; ?>" class="gonderbtn"><?php echo __("website/sign/up-button-in"); ?></a>
            </div>


            <div class="uyeol">
                <div style="padding:20px;">
                    <h4><strong><?php echo __("website/sign/rstpswd-text6"); ?></strong></h4>
                    <?php
                        if(isset($user_id) && $user_id){

                            ?>
                            <form action="<?php echo $controller_link;?>" method="POST" class="mio-ajax-form" id="Reset_Password_Form">
                                <?php echo Validation::get_csrf_token('sign'); ?>


                                <!-- Information FORM -->
                                <div id="Information">
                                    <table width="100%" border="0">
                                        <tbody>

                                        <?php
                                            if(isset($by_name) && $by_name == "mobile" && isset($security_question)){
                                                ?>
                                                <tr>
                                                    <td colspan="2">
                                                        <div><input name="security_question_answer" type="text" placeholder="<?php echo $security_question; ?>" required></div>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        ?>

                                        <tr>
                                            <td colspan="2">
                                                <div><input name="password" type="password" placeholder="<?php echo __("website/sign/up-form-password"); ?>" required></div>
                                                <div><input name="password_again" type="password" placeholder="<?php echo __("website/sign/up-form-password_again"); ?>" required></div>
                                            </td>
                                        </tr>


                                        <tr>
                                            <td style="border:none">
                                                <div class="clear" style="margin-bottom: 15px;"></div>
                                                <div align="center">
                                                    <button type="button" style="float:none;" class="btn mio-ajax-submit" mio-ajax-options='{"result":"reset_password_submit","waiting_text":"<?php echo addslashes(__("website/others/button1-pending")); ?>"}'><?php echo __("website/sign/rstpswd-text3"); ?></button>
                                                    <div class="clear"></div>
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
                                    <h4 style="font-weight:bold;border:none;"><?php echo __("website/sign/rstpswd-text4"); ?></h4>
                                    <h5 style="font-size:16px;"><?php echo __("website/sign/rstpswd-text5"); ?></h5>
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
            </div>
        </div>


    </div>
</div>

<?php include $tpath."inc/sign-footer.php"; ?>