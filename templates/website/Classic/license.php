<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    $hoptions = [
        'page' => "license",
    ];
?>
<div id="wrapper">

    <div class="license-verify">

        <div class="pakettitle" style="margin-top:0px;">
            <h1><strong><?php echo __("website/license/page-name"); ?></strong></h1>
            <div class="line"></div>
            <h2><?php echo __("website/license/page-desc-1"); ?><br>
                <span style="font-size:18px;"><?php echo __("website/license/page-desc-2"); ?></span></h2>
        </div>

        <div class="clear"></div>
        <div class="license-verify-box">

            <form action="<?php echo $links["controller"]; ?>" method="post" id="checkingForm" one>
                <input type="hidden" name="operation" value="check">
                <input type="hidden" name="hash" value="">

                <input name="domain" type="text" placeholder="<?php echo __("website/license/page-enter-domain"); ?>">

                <?php if(isset($captcha) && $captcha): ?>
                    <div align="center" style="margin:5px;"><?php echo $captcha->getOutput(); ?></div>
                    <?php if($captcha->input): ?>
                        <input id="requiredinput" style="width:130px;" name="<?php echo $captcha->input_name; ?>" type="text" placeholder="<?php echo ___("needs/form-captcha-label"); ?>">
                    <?php endif; ?>
                <?php endif; ?>

                <a href="javascript:void(0);" id="checkingForm_submit" class="yesilbtn gonderbtn"><?php echo __("website/license/button-questioning"); ?></a>

                <div class="clear"></div>
                <div class="license-verification-result">
                    <div class="license-ok" id="license_ok" style="display:none">
                        <div class="padding30">
                            <i class="fa fa-check-square-o" aria-hidden="true"></i>
                            <h4><?php echo __("website/license/ok-msg"); ?></h4>
                        </div>
                    </div>
                    <div class="license-none" id="license_no" style="display:none">
                        <div class="padding30">
                            <i class="fa fa-ban" aria-hidden="true"></i>
                            <h4><?php echo __("website/license/err-msg"); ?></h4>
                            <a href="javascript:void(0);" id="report_button" class="gonderbtn"><?php echo __("website/license/button-report"); ?></a>
                        </div>
                    </div>
                </div>

            </form>
            <script type="text/javascript">
                $(document).ready(function(){

                    $('#checkingForm').on('keyup keypress', function(e) {
                        var keyCode = e.keyCode || e.which;
                        if (keyCode === 13) {
                            e.preventDefault();
                            $('#checkingForm_submit').click();
                        }
                    });

                    $("#checkingForm_submit").on("click",function(){
                        $("input[name=operation]").val("check");
                        MioAjaxElement($(this),{
                            waiting_text: '<?php echo addslashes(__("website/others/button1-pending")); ?>',
                            result:"checkingForm_handler",
                        });
                    });

                    $("#report_button").on("click",function(){
                        $("input[name=operation]").val("report");
                        MioAjaxElement($(this),{
                            waiting_text: '<?php echo addslashes(__("website/others/button1-pending")); ?>',
                            result:"reportForm_handler",
                        });
                    });

                });

                function checkingForm_handler(result){

                    <?php if(isset($captcha)) echo $captcha->submit_after_js(); ?>

                    if(result != ''){
                        var solve = getJson(result);
                        if(solve !== false){
                            if(solve.status == "error"){
                                if(solve.for != undefined && solve.for != ''){
                                    $("#checkingForm "+solve.for).focus();
                                    $("#checkingForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                    $("#checkingForm "+solve.for).change(function(){
                                        $(this).removeAttr("style");
                                    });
                                }
                                if(solve.message != undefined && solve.message != '')
                                    alert_error(solve.message,{timer:5000});
                            }else{

                                var status = solve.status;

                                if(status == "ok"){
                                    $("#license_ok").slideDown(300);
                                    $("#license_no").slideUp(300);
                                }else{
                                    $("#license_no").slideDown(300);
                                    $("#license_ok").slideUp(300);
                                    $("input[name=hash]").val(solve.hash);
                                }
                            }
                        }else
                            console.log(result);
                    }
                }

                function reportForm_handler(result){

                    <?php if(isset($captcha)) echo $captcha->submit_after_js(); ?>

                    if(result != ''){
                        var solve = getJson(result);
                        if(solve !== false){
                            if(solve.status == "error"){
                                if(solve.for != undefined && solve.for != ''){
                                    $("#checkingForm "+solve.for).focus();
                                    $("#checkingForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                    $("#checkingForm "+solve.for).change(function(){
                                        $(this).removeAttr("style");
                                    });
                                }
                                if(solve.message != undefined && solve.message != '')
                                    alert_error(solve.message,{timer:5000});
                            }else if(solve.status == "successful"){
                                $("html, body").animate({ scrollTop: $('.license-verify').offset().top},200);
                                alert_success(solve.message,{timer:5000});
                                $("#license_ok,#license_no").slideUp(300);
                                $("input[name=domain]").val('').focus();
                            }
                        }else
                            console.log(result);
                    }
                }
            </script>


        </div>
    </div>


    <div class="clear"></div>
</div>