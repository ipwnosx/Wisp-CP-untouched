<?php defined('CORE_FOLDER') OR exit('You can not get in here!'); ?><!doctype html>
<html lang="<?php echo ___("package/code"); ?>">
<head>

    <?php
        $master_content_none = true;
        $meta = __("website/newsletter/meta");

        $hoptions = [
            'page' => "newsletter",
        ];
        include __DIR__.DS."inc".DS."main-head.php";
    ?>
</head>
<body>

<div class="padding20" style="text-align:center;">

    <div class="green-info"><div class="padding15"><?php echo __("website/newsletter/news-desc"); ?></div></div>
    <br><br>
    <form action="<?php echo $newsletter_action;?>" method="POST" id="newsletter_email">
        <?php echo Validation::get_csrf_token('newsletter'); ?>

        <i class="fa fa-envelope-o" aria-hidden="true"></i>
        <input style="width:90%;margin-bottom:20px;" name="email" type="text" placeholder="<?php echo __("website/newsletter/form-email-placeholder2"); ?>" value="<?php echo $email; ?>">
        <?php if(isset($captcha) && $captcha): ?>
            <div class="captcha-content" style="width:304px;margin:auto;">
                <?php echo $captcha->getOutput(); ?><br>
                <?php if($captcha->input): ?>
                    <input class="captchainput" style="margin-bottom:15px;" name="<?php echo $captcha->input_name; ?>" type="text" placeholder="<?php echo ___("needs/form-captcha-label"); ?>">
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <a id="newsletter_submit" href="javascript:newsletter_submit();void 0;" class="lbtn"><?php echo __("website/newsletter/form-submit"); ?></a>
        <div class="clear"></div>
        <div class="error" style="text-align: center; margin-top: 5px; display: none;" id="error_msg"></div>
    </form>

    <div id="Success" style="display: none;">
        <div style="margin-top:10px;margin-bottom:70px;text-align:center;">
            <i style="font-size:80px;color:green;" class="fa fa-check"></i>
            <h4 style="color:green;font-weight:bold;"><?php echo __("website/newsletter/form-output-success-title"); ?></h4>
            <br>
            <h5><?php echo __("website/newsletter/form-output-success"); ?></h5>
        </div>
    </div>

</div>

<script type="text/javascript">
    function newsletter_submit() {
        MioAjaxElement($("#newsletter_submit"),{
            waiting_text:"<?php echo addslashes(__("website/others/button3-pending")); ?>",
            result:"newsletter_result",
        });
    }
    function newsletter_result(result) {
        <?php if(isset($captcha)) echo $captcha->submit_after_js(); ?>
        if(result != ''){
            var solve = getJson(result);
            if(solve !==false && solve != undefined && typeof(solve) == "object"){
                if(solve.status == "error"){
                    $("#newsletter_email input[name='email']").focus();
                    $("#error_msg").fadeIn(100).html(solve.message);
                }else if(solve.status == "successful"){
                    $("#newsletter_email").slideUp(150,function(){
                        $("#Success").slideDown(150);
                    });
                    $("#newsletter_email input[name='email']").val('');
                    setTimeout(function(){
                        window.close();
                    },3000);
                }
            }else
                console.log(result);
        }
    }
</script>

</body>
</html>