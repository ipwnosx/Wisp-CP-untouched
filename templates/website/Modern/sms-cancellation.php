<?php defined('CORE_FOLDER') OR exit('You can not get in here!'); ?><!doctype html>
<html lang="<?php echo ___("package/code"); ?>">
<head>

    <?php
        $master_content_none = true;
        $meta = ['title' => "SMS İptali"];

        $hoptions = [
            'page' => "newsletter",
        ];
        include __DIR__.DS."inc".DS."main-head.php";
    ?>
</head>
<body>

<div class="padding20" style="text-align:center;">

    <div class="green-info">
        <div class="padding15">
            SMS listemizden çıkmak için gsm numaranızı giriniz.
        </div>
    </div>
    <br><br>

    <form action="" method="POST" id="form">
        <i class="fa fa-mobile-phone" aria-hidden="true"></i>
        <input style="width:90%;margin-bottom:20px;" name="phone" type="text" placeholder="05XX XXX XX XX" value="">

        <a id="form_submit" href="javascript:form_submit();void 0;" class="lbtn">ÇIKAR</a>
        <div class="clear"></div>
        <div class="error" style="text-align: center; margin-top: 5px; display: none;" id="error_msg"></div>
    </form>

    <div id="Success" style="display: none;">
        <div style="margin-top:10px;margin-bottom:70px;text-align:center;">
            <i style="font-size:80px;color:green;" class="fa fa-check"></i>
            <h4 style="color:green;font-weight:bold;">İşlem Başarıyla Gerçekleştirilmiştir.</h4>
            <br>
            <h5></h5>
        </div>
    </div>

</div>

<script type="text/javascript">
    function form_submit() {
        MioAjaxElement($("#form_submit"),{
            waiting_text:"<?php echo addslashes(__("website/others/button3-pending")); ?>",
            result:"form_submit_handler",
        });
    }
    function form_submit_handler(result) {
        if(result != ''){
            var solve = getJson(result);
            if(solve !==false && solve != undefined && typeof(solve) == "object"){
                if(solve.status == "error"){
                    $("#form input[name='phone']").focus();
                    $("#error_msg").fadeIn(100).html(solve.message);
                }else if(solve.status == "successful"){
                    $("#error_msg").fadeOut(100).html('');
                    $("#form").slideUp(150,function(){
                        $("#Success").slideDown(150);
                    });
                    $("#form input[name='phone']").val('');
                }else
                    $("#error_msg").fadeOut(100).html('');
            }else
                console.log(result);
        }
    }
</script>

</body>
</html>