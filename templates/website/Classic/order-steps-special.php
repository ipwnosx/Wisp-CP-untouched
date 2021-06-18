<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    $haveStock = $product["haveStock"];
    $hoptions = [
        'page' => "order-steps-special",
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

        $(window).keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
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

    <?php

        if(!$haveStock){
            ?>
            <!-- out of stock -->
            <div style="margin-top: 70px;margin-bottom:70px;text-align:center;display: inline-block;width: 100%;">
                <i style="font-size:70px;margin-bottom: 15px;" class="fa fa-info-circle"></i>
                <h2 style="font-weight:bold;"><?php echo __("website/osteps/out-of-stock-1"); ?></h2>
                <br>
                <h4><?php echo __("website/osteps/out-of-stock-2"); ?>  <br> <br><strong><?php echo __("website/osteps/out-of-stock-3"); ?></strong></h4>
            </div>
            <!-- out of stock end-->
            <?php
        }
    ?>

    <?php if($haveStock && $step == 1): ?>
        <div class="pakettitle" style="margin-top:0px;">
            <h1><strong><?php echo __("website/osteps/service-time-selection"); ?></strong></h1>
            <div class="line"></div>
            <h2><?php echo __("website/osteps/service-time-selection-note"); ?></h2>
        </div>



        <div class="siparisbilgileri">

            <form action="<?php echo $links["step"]; ?>" method="post" id="StepForm1">
                <?php echo Validation::get_csrf_token('order-steps'); ?>

                <style>
                    .orderperiodblock.active{border:2px solid #<?php echo Config::get("theme/color1"); ?>}.active .periodselectbox{border:2px solid #<?php echo Config::get("theme/color1"); ?>;background:#<?php echo Config::get("theme/color1");?>;} .orderperiodblock h3 {color:#<?php echo Config::get("theme/color1"); ?>;}
                    .ribbonperiod span{background:linear-gradient(#<?php echo Config::get("theme/color1");?> 0%,#<?php echo Config::get("theme/color1");?> 100%)}
                    .ribbonperiod span::before{border-left:3px solid #<?php echo Config::get("theme/color1");?>;border-top:3px solid #<?php echo Config::get("theme/color1");?>}
                    .ribbonperiod span::after{border-right:3px solid #<?php echo Config::get("theme/color1");?>;border-top:3px solid #<?php echo Config::get("theme/color1");?>}
                </style>
                <div class="orderperiodblock-con">
                    <input type="hidden" name="selection" value="0">
                    <?php
                        $selectp = (int) substr(Filter::init("GET/select","rnumbers"),0,1);
                        if(isset($product["price"]) && $product["price"]){
                            foreach ($product["price"] AS $k=>$pe){
                                $amount     = Money::formatter_symbol($pe["amount"],$pe["cid"],!$product["override_usrcurrency"]);
                                $period     = View::period($pe["time"],$pe["period"]);
                                $discount   = $pe["discount"]>0 ? '<div class="ribbonperiod"><span>'.__("website/osteps/rate-discount",['{rate}' => $pe["discount"]]).'</span></div>' : NULL;
                                ?>
                                <div class="orderperiodblock" id="price-<?php echo $pe["id"]; ?>" data-value="<?php echo $k; ?>">
                                    <?php echo $discount; ?>
                                    <h3><?php echo $period; ?></h3>
                                    <h2><?php echo $amount; ?></h2>
                                    <div class="periodselectbox"><i class="fa fa-check" aria-hidden="true"></i></div>
                                </div>
                                <?php
                            }
                        }
                    ?>
                    <script type="text/javascript">
                        $(document).ready(function(){
                            $(".orderperiodblock").click(function(){
                                if($(this).hasClass("active")) return false;
                                $(".orderperiodblock").removeClass("active");
                                $(this).addClass("active");
                                $("#StepForm1 input[name=selection]").val($(this).data("value"));
                            });
                            var selected_price = <?php echo $selectp ? (string) $selectp : "0"; ?>;
                            $(".orderperiodblock:eq("+selected_price+") .periodselectbox").trigger("click");
                        });
                    </script>

                    <div class="clear"></div>
                <div style="margin-top:55px;    margin-bottom: 25px;"><a style="float:none" href="javascript:void(0);" class="btn mio-ajax-submit" mio-ajax-options='{"result":"StepForm1_submit","waiting_text":"<?php echo addslashes(__("website/others/button1-pending")); ?>"}'
                ><strong><?php echo __("website/osteps/continue-button"); ?> <i class="ion-android-arrow-dropright"></i></strong></a></div>
                </div>
                
                <div class="clear"></div>
                <div class="error" id="result" style="text-align: center; margin-top: 5px; display: none;"></div>
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
                                window.location.href = solve.redirect;
                            }
                        }else
                            console.log(result);
                    }
                }
            </script>

        </div>
    <?php endif; ?>

    <?php if($haveStock && $step == "domain"): ?>
        <div class="pakettitle" style="margin-top:0px;">
            <h1><strong><?php echo __("website/osteps/identify-your-domain"); ?></strong></h1>
            <div class="line"></div>
            <h2><?php echo __("website/osteps/identify-your-domain-note"); ?></h2>
        </div>
        <div class="clear"></div>

        <div class="siparisbilgileri">
            <div class="domainsec">
                <div id="accordion">

                    <?php if(isset($firstTLD) && is_array($firstTLD) && Config::get("options/pg-activation/domain")): ?>
                        <h3><strong><?php echo __("website/osteps/iwill-register-a-new-domain"); ?></strong></h3>
                        <div style="overflow: hidden;">
                            <table width="100%" border="0" align="center">
                                <tr>
                                    <td style="border:none;" colspan="2">
                                        <div class="alanadisorgu">
                                            <form action="<?php echo $links["domain_check"]; ?>" method="post" id="DomainCheck">
                                                <?php echo Validation::get_csrf_token('domain-check'); ?>

                                                <input type="hidden" name="operation" value="check">
                                                <input type="hidden" name="from" value="order_steps">
                                                <input type="hidden" name="product_type" value="<?php echo $product["type"]; ?>">
                                                <input type="hidden" name="product_id" value="<?php echo $product["id"]; ?>">
                                                <input type="hidden" name="selected_period" value="<?php echo isset($selected_period) ? $selected_period["id"] : 0; ?>">
                                                <input  id="domainInput" name="domain" type="text" placeholder="<?php echo __("website/osteps/domain-placeholder"); ?>">
                                                <a href="javascript:void(0);" class="gonderbtn mio-ajax-submit" mio-ajax-options='{"result":"DomainCheckSubmit","before_function":"DomainCheckBefore","waiting_text":"<?php echo addslashes(__("website/others/button1-pending")); ?>"}' id="button1"><?php echo __("website/osteps/check-it-button"); ?></a>

                                                <script type="text/javascript">
                                                    $(document).ready(function(){
                                                        $("#DomainCheck").keydown(function(event){
                                                            if(event.keyCode == 13){
                                                                $("#DomainCheck #button1").trigger("click");
                                                            }
                                                        });
                                                    });
                                                </script>

                                                <div class="error" id="result" style="display: none;margin-top:5px;"></div>
                                            </form>
                                            <script type="text/javascript">
                                                function DomainCheckBefore() {
                                                    $(".result-content").hide(1);
                                                    $("#tescilsonuc").slideUp(400);
                                                    return true;
                                                }
                                                function DomainCheckSubmit(result) {
                                                    if(result != ''){
                                                        var solve = getJson(result);
                                                        if(solve !== false){
                                                            if(solve.status == "error"){
                                                                if(solve.for != undefined && solve.for != ''){
                                                                    $(solve.for).focus();
                                                                    $(solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                                                    $(solve.for).change(function(){
                                                                        $(this).removeAttr("style");
                                                                    });
                                                                }
                                                                if(solve.message != undefined && solve.message != '')
                                                                    alert_error(solve.message,{timer:3000});
                                                            }else if(solve.status == "successful"){
                                                                var ListData = solve.data != undefined ? solve.data : false;
                                                                if(ListData){
                                                                    var result = ListData[0];
                                                                    var status = result.status;
                                                                    if(status == "available"){
                                                                        $("#sadeckyinfo,#sadeckyinfo_free").css("display","none");
                                                                        $("#register-amount").html(result.reg_price[0]);
                                                                        if(result.reg_price[0] === 0)
                                                                            $("#sadeckyinfo_free").css("display","block");
                                                                        else
                                                                            $("#sadeckyinfo").css("display","block");
                                                                    }
                                                                    $("#"+status+"_content").show(1);
                                                                    $("#tescilsonuc").slideDown(400);
                                                                    $(".domain-name").html(result.domain);
                                                                }
                                                            }
                                                        }else
                                                            console.log(result);
                                                    }
                                                }
                                            </script>
                                            <?php
                                                $firstTLD_amount = $firstTLD["register"]["amount"];
                                                if($firstTLD["promo_status"] && (substr($firstTLD["promo_duedate"],0,4) == '1881' || DateManager::strtotime($firstTLD["promo_duedate"]." 23:59:59") > DateManager::strtotime()) && $firstTLD["promo_register_price"]>0) $firstTLD_amount = $firstTLD["promo_register_price"];
                                            ?>
                                            <h5><?php echo __("website/domain/slogan",['{price}' => Money::formatter_symbol($firstTLD_amount,$firstTLD["register"]["cid"],!$domain_override_usrcurrency)]); ?></h5>
                                        </div>



                                        <div class="tescilsonuc" id="tescilsonuc" style="display: none; transition-property: all; transition-duration: 0s; transition-timing-function: ease; opacity: 1;">
                                            <table width="80%" border="0" align="center">

                                                <tr class="result-content" id="unknown_content" style="display: none;">
                                                    <td align="center">
                                                        <div class="error"><?php echo __("website/osteps/unknown-message"); ?></div>
                                                    </td>
                                                </tr>

                                                <tr class="result-content" id="available_content" style="display: none;">
                                                    <td align="center">
                                                        <h4><strong><?php echo __("website/osteps/available-message1"); ?></strong></h4>
                                                        <span class="sadeckyinfo" id="sadeckyinfo" style="display: none;"><?php echo __("website/osteps/available-message2"); ?></span>
                                                        <span class="sadeckyinfo" id="sadeckyinfo_free" style="display: none;"><?php echo __("website/osteps/available-message3"); ?></span>
                                                        <a href="javascript:void(0);" onclick="GoStep('registrar',this);" class="gonderbtn" id="button1"><?php echo __("website/osteps/select-and-continue"); ?></a>
                                                        <div class="clear"></div>
                                                    </td>
                                                </tr>

                                                <tr class="result-content" id="unavailable_content" style="display:none;">
                                                    <td align="center">
                                                        <h4 style="color:red;"><strong><i class="fa fa-ban" aria-hidden="true"></i> <?php echo __("website/osteps/unavailable-message1"); ?></strong></h4>
                                                        <span class="sadeckyinfo"><?php echo __("website/osteps/unavailable-message2"); ?></span>
                                                    </td>
                                                </tr>

                                            </table>
                                        </div>



                                    </td>
                                </tr>
                            </table>
                        </div>
                    <?php endif; ?>


                    <h3><strong><?php echo __("website/osteps/current-my-domain"); ?></strong></h3>
                    <div>
                        <table width="100%" border="0" align="center">
                            <tr>
                                <td style="border:none;" colspan="2">
                                    <div class="alanadisorgu" id="licendedomain_form">
                                        <input name="domain" id="special_domain" type="text" placeholder="<?php echo __("website/osteps/domain-placeholder"); ?>">
                                        <a href="javascript:void(0);" onclick="GoStep('normal',this);" class="gonderbtn" id="button2"><?php echo __("website/osteps/use-button"); ?></a>
                                        <script type="text/javascript">
                                            $(document).ready(function(){
                                                $("#licendedomain_form").keydown(function(event){
                                                    if(event.keyCode == 13){
                                                        $("#licendedomain_form #button2").trigger("click");
                                                    }
                                                });
                                            });
                                        </script>
                                        <div class="clear"></div>
                                        <h5><?php echo __("website/osteps/write-your-current-domain"); ?></h5>
                                    </div>


                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            function GoStep(type,elem) {
                if(type == "registrar")
                    var domain   = $("#DomainCheck input[name=domain]").val();
                else
                    var domain   = $("#special_domain").val();



                var request = MioAjax({
                    button_element:elem,
                    waiting_text:"<?php echo addslashes(__("website/others/button1-pending")); ?>",
                    action: "<?php echo $links["step"]; ?>",
                    method: "POST",
                    data: {
                        type:type,
                        domain:domain,
                        token:'<?php echo Validation::get_csrf_token('order-steps',false); ?>',
                    }
                },true,true);

                request.done(function(result){
                    if(!result){
                        console.log("HTTP Request failed.");
                    }else{
                        var solve = getJson(result);
                        if(solve){
                            if(solve.status == "error"){
                                if(solve.for != undefined && solve.for != ''){
                                    $(solve.for).focus();
                                    $(solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                    $(solve.for).change(function(){
                                        $(this).removeAttr("style");
                                    });
                                }
                                if(solve.message != undefined && solve.message != '')
                                    alert_error(solve.message,{timer:3000});

                            }else if(solve.status == "successful"){
                                if(solve.redirect != undefined && solve.redirect != '')
                                    window.location.href = solve.redirect;
                            }
                        }else
                            console.log("Http request data could not be resolved.");
                    }
                });
            }
        </script>
    <?php endif; ?>

    <?php if($haveStock && $step == "addons"): ?>
        <div class="pakettitle" style="margin-top:0px;">
            <h1><strong><?php echo __("website/osteps/additional-services"); ?></strong></h1>
            <div class="line"></div>
            <h2><?php echo __("website/osteps/additional-services-note"); ?></h2>
        </div>


        <div class="siparisbilgileri">

            <form action="<?php echo $links["step"]; ?>" method="post" id="StepForm1" enctype="multipart/form-data">
                <?php echo Validation::get_csrf_token('order-steps'); ?>

                <table width="100%" border="0" align="center">

                    <tr>
                        <td bgcolor="#ebebeb"><strong><?php echo __("website/osteps/additional-service"); ?></strong></td>
                        <td bgcolor="#ebebeb"><strong><?php echo __("website/osteps/additional-service-amount"); ?></strong></td>
                    </tr>

                    <?php
                        foreach($addons AS $addon){
                            $options  = $addon["options"];
                            $properties = $addon["properties"];
                            $compulsory = isset($properties["compulsory"]) && $properties["compulsory"];
                            ?>
                            <tr>
                                <td width="50%">
                                    <?php if($compulsory): ?>
                                        <span class="zorunlu">*</span>
                                    <?php endif; ?>
                                    <label for="addon-<?php echo $addon["id"]; ?>">
                                       <strong> <?php echo $addon["name"]; ?></strong>
                                        <?php if($addon["description"]): ?>
                                            <br>
                                            <span style="font-size: 14px;"><?php echo $addon["description"]; ?></span>
                                        <?php endif; ?>
                                    </label>
                                </td>
                                <td width="50%">
                                    <?php
                                        if($addon["type"] == "radio"){
                                        ?>
                                        <?php if(!$compulsory): ?>
                                    <input checked id="addon-<?php echo $addon["id"]."-none"; ?>" class="radio-custom" name="addons[<?php echo $addon["id"]; ?>]" value="" type="radio">
                                        <label style="margin-right:30px;" for="addon-<?php echo $addon["id"]."-none"; ?>" class="radio-custom-label"><?php echo ___("needs/idont-want"); ?></label>
                                    <br>
                                    <?php endif; ?>
                                        <?php
                                    foreach ($options AS $k=>$opt){
                                        $amount     = Money::formatter_symbol($opt["amount"],$opt["cid"],!$addon["override_usrcurrency"]);
                                        if(!$opt["amount"]) $amount = ___("needs/free-amount");
                                        $periodic   = View::period($opt["period_time"],$opt["period"]);
                                        $name       = $opt["name"];
                                        $show_name  = $name." <strong>".$amount."</strong>";
                                        if(($opt["amount"] && $opt["period"] == "none") || $opt["amount"])
                                            $show_name .= " | <strong>".$periodic."</strong>";
                                        ?>
                                    <input<?php echo $compulsory && $k==0 ? ' checked' : ''; ?> id="addon-<?php echo $addon["id"]."-".$k; ?>" class="radio-custom" name="addons[<?php echo $addon["id"]; ?>]" value="<?php echo $opt["id"]; ?>" type="radio">
                                        <label style="margin-right:30px;" for="addon-<?php echo $addon["id"]."-".$k; ?>" class="radio-custom-label"><?php echo $show_name; ?></label>
                                    <br>
                                    <?php
                                        }
                                        }
                                        elseif($addon["type"] == "checkbox"){
                                    ?>
                                    <?php if(!$compulsory): ?>
                                    <input checked id="addon-<?php echo $addon["id"]."-none"; ?>" class="checkbox-custom" name="addons[<?php echo $addon["id"]; ?>]" value="" type="radio">
                                        <label style="margin-right:30px;" for="addon-<?php echo $addon["id"]."-none"; ?>" class="checkbox-custom-label"><?php echo ___("needs/idont-want"); ?></label>
                                    <br>
                                    <?php endif; ?>
                                        <?php
                                    foreach ($options AS $k=>$opt){
                                        $amount     = Money::formatter_symbol($opt["amount"],$opt["cid"],!$addon["override_usrcurrency"]);
                                        if(!$opt["amount"]) $amount = ___("needs/free-amount");
                                        $periodic = View::period($opt["period_time"],$opt["period"]);
                                        $name       = $opt["name"];
                                        $show_name  = $name." <strong>".$amount."</strong>";
                                        if(($opt["amount"] && $opt["period"] == "none") || $opt["amount"])
                                            $show_name .= " | <strong>".$periodic."</strong>";
                                        ?>
                                    <input<?php echo $compulsory && $k==0 ? ' checked' : ''; ?> id="addon-<?php echo $addon["id"]."-".$k; ?>" class="checkbox-custom" name="addons[<?php echo $addon["id"]; ?>]" value="<?php echo $opt["id"]; ?>" type="radio">
                                        <label style="margin-right:30px;" for="addon-<?php echo $addon["id"]."-".$k; ?>" class="checkbox-custom-label"><?php echo $show_name; ?></label>
                                    <br>
                                    <?php
                                        }
                                        }
                                        elseif($addon["type"] == "select"){
                                    ?>
                                        <select name="addons[<?php echo $addon["id"]; ?>]">
                                            <?php if(!$compulsory): ?>
                                                <option value=""><?php echo ___("needs/idont-want"); ?></option>
                                            <?php endif; ?>
                                            <?php
                                                foreach ($options AS $k=>$opt){
                                                    $amount     = Money::formatter_symbol($opt["amount"],$opt["cid"],!$addon["override_usrcurrency"]);
                                                    if(!$opt["amount"]) $amount = ___("needs/free-amount");
                                                    $periodic = View::period($opt["period_time"],$opt["period"]);
                                                    $name       = $opt["name"];
                                                    $show_name  = $name." <strong>".$amount."</strong>";
                                                    if(($opt["amount"] && $opt["period"] == "none") || $opt["amount"])
                                                        $show_name .= " | <strong>".$periodic."</strong>";
                                                    ?>
                                                    <option value="<?php echo $opt["id"]; ?>"><?php echo $show_name; ?></option>

                                                    <?php
                                                }
                                            ?>
                                        </select>
                                    <?php
                                        }
                                        elseif($addon["type"] == "quantity"){
                                        $min = isset($properties["min"]) ? $properties["min"] : '0';
                                        $max = isset($properties["max"]) ? $properties["max"] : '0';
                                        $stp = isset($properties["step"]) ? $properties["step"] : '1';
                                        if($min == 0) $min = 1;
                                    ?>
                                        <select name="addons[<?php echo $addon["id"]; ?>]" id="addon-<?php echo $addon["id"]; ?>-selection" style="margin-bottom: 5px;">
                                            <?php if(!$compulsory): ?>
                                                <option value=""><?php echo ___("needs/idont-want"); ?></option>
                                            <?php endif; ?>
                                            <?php
                                                foreach ($options AS $k=>$opt){
                                                    $amount     = Money::formatter_symbol($opt["amount"],$opt["cid"],!$addon["override_usrcurrency"]);
                                                    if(!$opt["amount"]) $amount = ___("needs/free-amount");
                                                    $periodic = View::period($opt["period_time"],$opt["period"]);
                                                    $name       = $opt["name"];
                                                    $show_name  = $name." <strong>".$amount."</strong>";
                                                    if(($opt["amount"] && $opt["period"] == "none") || $opt["amount"])
                                                        $show_name .= " | <strong>".$periodic."</strong>";
                                                    ?>
                                                    <option value="<?php echo $opt["id"]; ?>"><?php echo $show_name; ?></option>

                                                    <?php
                                                }
                                            ?>
                                        </select>
                                        <script type="text/javascript">
                                            $(document).ready(function(){
                                                $("#addon-<?php echo $addon["id"]; ?>-slider-value").ionRangeSlider({
                                                    min: <?php echo $min; ?>,
                                                    max: <?php echo $max; ?>,
                                                    from:<?php echo $min; ?>,
                                                    step:<?php echo $stp; ?>,
                                                    grid: true,
                                                    skin: "big",
                                                });

                                                $("#addon-<?php echo $addon["id"]; ?>-selection").change(function() {
                                                    if( $(this).val() === '') {
                                                        $('#addon-<?php echo $addon["id"]; ?>-slider-content').slideUp(250);
                                                    }else{
                                                        $('#addon-<?php echo $addon["id"]; ?>-slider-content').slideDown(250);
                                                    }

                                                });
                                            });
                                        </script>
                                        <div id="addon-<?php echo $addon["id"]; ?>-slider-content" style="<?php echo $compulsory ? '' : 'display: none;'; ?>">
                                            <input id="addon-<?php echo $addon["id"]; ?>-slider-value" name="addons_values[<?php echo $addon["id"]; ?>]" type="range" min="<?php echo $min; ?>" max="<?php echo $max; ?>" step="<?php echo $stp; ?>" value="<?php echo $min; ?>">

                                        </div>
                                        <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php
                        }
                    ?>

                    <tr>
                        <td style="border:none;" align="center" colspan="2">
                            <a href="javascript:void(0);" class="btn mio-ajax-submit" mio-ajax-options='{"result":"StepForm1_submit","waiting_text":"<?php echo addslashes(__("website/others/button1-pending")); ?>"}'><strong><?php echo __("website/osteps/continue-button"); ?> <i class="ion-android-arrow-dropright"></i></strong></a>
                            <div class="clear"></div>
                            <div id="result" class="error" style="display: none;text-align: center;margin-top: 5px;"></div>
                        </td>
                    </tr>
                </table>
            </form>



        </div>
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
    <?php endif; ?>

    <?php if($haveStock && $step == "requirements"): ?>
        <div class="pakettitle" style="margin-top:0px;">
            <h1><strong><?php echo __("website/osteps/necessary-information2"); ?></strong></h1>
            <div class="line"></div>
            <h2><?php echo __("website/osteps/necessary-information-note"); ?></h2>
        </div>



        <div class="siparisbilgileri">

            <form action="<?php echo $links["step"]; ?>" method="post" id="StepForm1" enctype="multipart/form-data">
                <?php echo Validation::get_csrf_token('order-steps'); ?>

                <table width="100%" border="0" align="center">
                    <tr>
                        <td colspan="2" bgcolor="#ebebeb"><strong><?php echo __("website/osteps/necessary-information3"); ?></strong></td>
                    </tr>

                    <?php
                        if(isset($requirements) && $requirements){
                            foreach($requirements AS $requirement){
                                $options    = $requirement["options"];
                                $properties = $requirement["properties"];
                                $wrap_invisible  = false;
                                if(isset($properties["wrap_visibility"]) && $properties["wrap_visibility"] == "invisible")
                                    $wrap_invisible = 'style="display:none;"';
                                ?>
                                <tr id="requirement-<?php echo $requirement["id"]; ?>-wrap" <?php echo $wrap_invisible; ?>>
                                    <td width="50%">
                                        <?php if(isset($properties["compulsory"]) && $properties["compulsory"]){ ?><span class="zorunlu">*</span><?php } ?>
                                        <label for="requirement-<?php echo $requirement["id"]; ?>">
                                            <strong><?php echo $requirement["name"]; ?></strong>
                                            <?php if($requirement["description"]): ?>
                                                <br>
                                                <span style="font-size: 14px;"><?php echo nl2br($requirement["description"]); ?></span>
                                            <?php endif; ?>
                                        </label>
                                    </td>
                                    <td width="50%">
                                        <?php
                                            if($requirement["type"] == "input"){
                                                ?>
                                                <input type="text" name="requirements[<?php echo $requirement["id"]; ?>]" id="requirement-<?php echo $requirement["id"]; ?>" placeholder="<?php echo isset($properties["placeholder"]) ? $properties["placeholder"] : ''; ?>">
                                                <?php
                                            }
                                            elseif($requirement["type"] == "textarea"){
                                                ?>
                                                <textarea name="requirements[<?php echo $requirement["id"]; ?>]" id="requirement-<?php echo $requirement["id"]; ?>" placeholder="<?php echo isset($properties["placeholder"]) ? $properties["placeholder"] : ''; ?>"></textarea>
                                                <?php
                                            }
                                            elseif($requirement["type"] == "radio"){
                                                foreach ($options AS $k=>$opt){
                                                    ?>
                                                    <input id="requirement-<?php echo $requirement["id"]."-".$k; ?>" class="radio-custom" name="requirements[<?php echo $requirement["id"]; ?>]" value="<?php echo $opt["id"]; ?>" type="radio">
                                                    <label style="margin-right:30px;" for="requirement-<?php echo $requirement["id"]."-".$k; ?>" class="radio-custom-label"><span class="checktext"><?php echo $opt["name"]; ?></span></label>
                                                    <br>
                                                    <?php
                                                }
                                            }
                                            elseif($requirement["type"] == "checkbox"){
                                                foreach ($options AS $k=>$opt){
                                                    ?>
                                                    <input id="requirement-<?php echo $requirement["id"]."-".$k; ?>" class="checkbox-custom" name="requirements[<?php echo $requirement["id"]; ?>][]" value="<?php echo $opt["id"]; ?>" type="checkbox">
                                                    <label style="margin-right:30px;" for="requirement-<?php echo $requirement["id"]."-".$k; ?>" class="checkbox-custom-label"><span class="checktext"><?php echo $opt["name"]; ?></span></label>
                                                    <br>
                                                    <?php
                                                }
                                            }
                                            elseif($requirement["type"] == "select"){
                                                ?>
                                                <select name="requirements[<?php echo $requirement["id"]; ?>]" id="requirement-<?php echo $requirement["id"]; ?>">
                                                    <option value=""><?php echo __("website/osteps/select-your-option"); ?></option>
                                                    <?php
                                                        foreach ($options AS $k=>$opt){
                                                            ?>
                                                            <option value="<?php echo $opt["id"]; ?>"><?php echo $opt["name"]; ?></option>
                                                            <?php
                                                        }
                                                    ?>
                                                </select>
                                                <?php
                                            }
                                            elseif($requirement["type"] == "file"){
                                                ?>
                                                <input type="file" name="requirement-<?php echo $requirement["id"]; ?>[]" id="requirement-<?php echo $requirement["id"]; ?>" multiple>
                                                <?php
                                            }

                                            if(isset($properties["define_end_of_element"]))
                                                if($properties["define_end_of_element"])
                                                    echo $properties["define_end_of_element"];
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                    ?>


                    <tr>
                        <td style="border:none;" align="center" colspan="2">
                            <a href="javascript:void(0);" class="btn mio-ajax-submit" mio-ajax-options='{"result":"StepForm1_submit","waiting_text":"<?php echo addslashes(__("website/others/button1-pending")); ?>","progress_text":"<?php echo addslashes(__("website/others/button1-upload")); ?>"}'><strong><?php echo __("website/osteps/continue-button"); ?></strong></a>
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
<div class="clear"></div>