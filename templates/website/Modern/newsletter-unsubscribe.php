<?php defined('CORE_FOLDER') OR exit('You can not get in here!'); ?><!doctype html>
<html lang="<?php echo ___("package/code"); ?>">
<head>

    <?php
        $master_content_none = true;
        $meta = __("website/newsletter/meta-unsubscribe");

        $hoptions = [
            'page' => "newsletter",
        ];
        include __DIR__.DS."inc".DS."main-head.php";
    ?>

    <style>
.unsubscribecon {
    width: 750px;
    margin: auto;
}
       .unsubscribecon input {
    width: 300px;
    padding: 20px;
    margin-bottom: 25px;
}
.unsubscribecon h1 {margin-bottom:20px;}
@media only screen and (min-width:320px) and (max-width:1023px) {
.unsubscribecon {
    width: 95%;
}
  .unsubscribecon input {
    width: 95%;
}
}
    </style>
</head>
<body>

<div class="unsubscribecon">
    <div class="padding20" style="text-align:center;">

        <form action="<?php echo $newsletter_action;?>" method="POST" id="newsletter_email">
            <?php echo Validation::get_csrf_token('newsletter'); ?>

            <div class="padding15">
                <?php echo __("website/newsletter/unsubscribe-desc"); ?>
            </div>

            <input name="email" type="text" placeholder="<?php echo __("website/newsletter/form-email-placeholder2"); ?>" value="<?php echo $email; ?>">
            <div class="clear"></div>
            <a id="newsletter_submit" href="javascript:newsletter_submit();void 0;" class="lbtn"><?php echo __("website/newsletter/form-submit2"); ?></a>
            <div class="clear"></div>
            <div class="error" style="text-align: center; margin-top: 5px; display: none;" id="error_msg"></div>
        </form>

        <div id="Success" style="display: none;">
            <div style="margin-top:10px;margin-bottom:70px;text-align:center;">
                <i style="font-size:80px;" class="fa fa-check"></i>
                <h4 style="font-weight:bold;"><?php echo __("website/newsletter/form-output-success-title2"); ?></h4>
                <br>
                <h5><?php echo __("website/newsletter/form-output-success2"); ?></h5>
            </div>
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
        if(result != ''){
            var solve = getJson(result);
            if(solve !==false && solve != undefined && typeof(solve) == "object"){
                if(solve.status == "error"){
                    $("#newsletter_email input[name='email']").focus();
                    $("#error_msg").fadeIn(100).html(solve.message);
                }else if(solve.status == "successful"){
                    $("#newsletter_email").fadeOut(500,function(){
                        $("#Success").fadeIn(500);
                    });
                    $("#newsletter_email input[name='email']").val('');
                }
            }else
                console.log(result);
        }
    }
</script>

</body>
</html>