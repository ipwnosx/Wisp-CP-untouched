<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    $hoptions = [
        'page' => "order-steps-sms",
        'jquery-ui',
        'ion.rangeSlider',
        'intlTelInput',
    ];
?>
<script>
        $( function() {
            $( "#accordion" ).accordion({
                heightStyle: "content"
            });
        });
    </script>
<div id="wrapper">
    <?php if(isset($steps) && sizeof($steps)>0): ?>
        <div class="asamaline"></div>
        <div class="ilanasamalar">
            <?php
                foreach ($steps AS $r=>$s){
                    $rank = $r+1;
                    ?>
                    <div class="ilanasamax"<?php echo $step == $s["id"] ? 'id="asamaaktif"' : ''; ?>><div align="center"><h3><?php echo $rank; ?></h3><div class="clear"></div><?php echo $s["name"]; ?></div></div>
                    <?php
                }
            ?>
        </div>
    <?php endif; ?>

    <?php if($step == 1): ?>
        <div class="pakettitle" style="margin-top:0px;">
            <h1><strong><?php echo __("website/osteps/compulsory-information2"); ?></strong></h1>
            <div class="line"></div>
            <h2><?php echo __("website/osteps/compulsory-information-note"); ?></h2>
        </div>



        <div class="siparisbilgileri">

            <form action="<?php echo $links["step"]; ?>" method="post" id="StepForm1" enctype="multipart/form-data">
                <?php echo Validation::get_csrf_token('order-steps'); ?>

                <table width="100%" border="0" align="center">
                    <tr>
                        <td colspan="2" bgcolor="#ebebeb"><strong><?php echo __("website/osteps/compulsory-information3"); ?></strong></td>
                    </tr>

                    <tr>
                        <td width="30%">
                            <label for="requirement-">
                                <span class="zorunlu">*</span> <strong>Adınız Soyadınız</strong>
                            </label>
                        </td>
                        <td>
                            <input type="text" name="name">
                        </td>
                    </tr>

                    <tr>
                        <td width="30%">
                            <span class="zorunlu">*</span> <strong>Doğum Tarihi</strong>
                        </td>
                        <td>
                            <script type="text/javascript" src="<?php echo $sadress."assets/plugins/js/i18n/datepicker-tr.js"; ?>"></script>

                            <script type="text/javascript"></script>
                            <script>
                                $(function(){
                                    $( "#birthday" ).datepicker({
                                        yearRange: "-100:+0",
                                        dateFormat:"dd/mm/yy",
                                        changeDay:true,
                                        changeMonth: true,
                                        changeYear: true
                                    });
                                });
                            </script>
                            <input type="text" name="birthday" id="birthday">
                        </td>
                    </tr>

                    <tr>
                        <td width="30%"><span class="zorunlu">*</span> <strong>T.C Kimlik Numarası</strong></td>
                        <td>
                            <input type="text" name="identity" value="" maxlength="11" onkeypress='return event.charCode>= 48 &&event.charCode<= 57'>
                        </td>
                    </tr>


                    <tr>
                        <td style="border:none;" align="center" colspan="2">
                            <a href="javascript:void(0);" class="btn mio-ajax-submit" mio-ajax-options='{"result":"StepForm1_submit","waiting_text":"<?php echo addslashes(__("website/others/button1-pending")); ?>","progress_text":"<?php echo addslashes(__("website/others/button1-upload")); ?>"}'><strong><?php echo __("website/osteps/continue-button"); ?> <i class="ion-android-arrow-dropright"></i></strong></a>

                            <div style="text-align: left; margin-top: 5px; display: none;" id="result" class="error"></div>
                        </td>
                    </tr>
                </table>
            </form>
            <script type="text/javascript">
                function StepForm1_submit(result) {
                    if(result != ''){
                        var solve = getJson(result);
                        if(solve !== false){
                            if(solve.status == "error"){
                                if(solve.for != undefined && solve.for != ''){
                                    $("#StepForm1 "+solve.for).focus();
                                    $("#StepForm1 "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                    $("#StepForm1 "+solve.for).change(function(){
                                        $(this).removeAttr("style");
                                    });
                                }
                                if(solve.message != undefined && solve.message != '')
                                    $("#StepForm1 #result").fadeIn(300).html(solve.message);
                                else
                                    $("#StepForm1 #result").fadeOut(300).html('');
                            }else if(solve.status == "successful"){
                                $("#StepForm1 #result").fadeOut(300).html('');
                                if(solve.redirect != undefined && solve.redirect != '') window.location.href = solve.redirect;
                            }
                        }else
                            console.log(result);
                    }
                }
            </script>
        </div>
    <?php endif; ?>

    <?php if($step == "origin"): ?>
        <div class="pakettitle" style="margin-top:0px;">
            <h1><strong><?php echo __("website/osteps/set-your-origin"); ?></strong></h1>
            <div class="line"></div>
            <h2><?php echo __("website/osteps/set-your-origin-note"); ?></h2>
        </div>



        <div class="siparisbilgileri">

            <form action="<?php echo $links["step"]; ?>" method="post" id="StepForm1" enctype="multipart/form-data">
                <?php echo Validation::get_csrf_token('order-steps'); ?>

                <table width="100%" border="0" align="center">
                    <tr>
                        <td colspan="2" bgcolor="#ebebeb"><strong><?php echo __("website/osteps/origin-informations"); ?></strong></td>
                    </tr>

                    <tr>
                        <td  colspan="2"><SPAN style="font-size:15px; color:red"><?php echo __("website/osteps/set-your-origin-note2"); ?></SPAN></td>
                    </tr>

                    <tr>
                        <td width="30%"><span class="zorunlu">*</span> <?php echo __("website/osteps/sender-title"); ?>: </td>
                        <td><input class="notr" name="origin" type="text" placeholder="<?php echo __("website/osteps/origin-placeholder"); ?>" size="11" maxlength="11" style="text-transform:uppercase"></td>
                    </tr>

                    <script type="text/javascript">
                        // başlık tanımlamalarında türkçe karakter kullanılmasın..
                        $(".notr").on("ready load keyup keydown keypress change", function () {
                            var baslik = $(this).val().substr(0, 11).toUpperCase().replace(/Ö/g, "O").replace(/Ç/g, "C").replace(/Ş/g, "S").replace(/İ/g, "i").replace(/Ğ/g, "G").replace(/Ü/g, "U").replace(/([^a-zA-Z0-9 \.\-_])/g, "");
                            $(this).val(baslik);
                            if (baslik.length > 3) {
                                $("li.baslikkarakter i").removeClass("fa-dot-circle-o").addClass("fa-check");
                            }else {
                                $("li.baslikkarakter i").removeClass("fa-check").addClass("fa-dot-circle-o");
                            }
                            if (baslik.replace(/([0-9]+)/, "").length != 0) {
                                $("li.baslikrakam i").removeClass("fa-dot-circle-o").addClass("fa-check");
                                titleInNumber = false;
                            }else {
                                $("li.baslikrakam i").removeClass("fa-check").addClass("fa-dot-circle-o");
                                titleInNumber = true;
                            }
                            $(".total").html(11 - baslik.length);
                        });
                    </script>

                    <tr>
                        <td width="30%"><span class="zorunlu">*</span> <?php echo __("website/osteps/origin-attachments"); ?>: </td>
                        <td><input style="font-size:15px;" name="attachments[]" type="file">
                            <SPAN style="font-size:15px; color:green"><?php echo __("website/osteps/origin-attachments-note"); ?></SPAN>
                        </td>
                    </tr>

                    <tr>
                        <td style="border:none;" align="center" colspan="2">
                            <a href="javascript:void(0);" class="btn mio-ajax-submit" mio-ajax-options='{"result":"StepForm1_submit","waiting_text":"<?php echo addslashes(__("website/others/button1-pending")); ?>","progress_text":"<?php echo addslashes(__("website/others/button1-upload")); ?>"}'><strong><?php echo __("website/osteps/continue-button"); ?> <i class="ion-android-arrow-dropright"></i></strong></a>

                            <div style="text-align: left; margin-top: 5px; display: none;" id="result" class="error"></div>
                        </td>
                    </tr>
                </table>
            </form>
            <script type="text/javascript">
                function StepForm1_submit(result) {
                    if(result != ''){
                        var solve = getJson(result);
                        if(solve !== false){
                            if(solve.status == "error"){
                                if(solve.for != undefined && solve.for != ''){
                                    $("#StepForm1 "+solve.for).focus();
                                    $("#StepForm1 "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                    $("#StepForm1 "+solve.for).change(function(){
                                        $(this).removeAttr("style");
                                    });
                                }
                                if(solve.message != undefined && solve.message != '')
                                    $("#StepForm1 #result").fadeIn(300).html(solve.message);
                                else
                                    $("#StepForm1 #result").fadeOut(300).html('');
                            }else if(solve.status == "successful"){
                                $("#StepForm1 #result").fadeOut(300).html('');
                                if(solve.redirect != undefined && solve.redirect != '') window.location.href = solve.redirect;
                            }
                        }else
                            console.log(result);
                    }
                }
            </script>

        </div>
    <?php endif; ?>

</div>