<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    $haveStock = $product["haveStock"];
    $hoptions = [
        'page' => "order-steps-server",
        'jquery-ui',
        'ion.rangeSlider',
        'intlTelInput',
    ];
?>
<script type="text/javascript">
    $(document).ready(function(){
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

    <?php if($haveStock && $step == "configuration"): ?>
        <form action="<?php echo $links["step"]; ?>" method="post" id="StepForm1" enctype="multipart/form-data">
            <?php echo Validation::get_csrf_token('order-steps'); ?>

            <div class="sunucukonfigurasyonu">

                <div class="sungenbil">

                    <?php if(Config::get("options/hidsein")): ?>
                        <div class="skonfiginfo" id="configInfo" style="margin-bottom:20px;">
                            <div style="padding:20px;">
                                <h4><?php echo __("website/osteps/server-set-informations"); ?></h4>
                                <table width="100%" border="0">

                                    <tr>
                                        <td width="30%">
                                            <label for="hostname">
                                                <?php echo __("website/osteps/hostname"); ?>
                                            </label>
                                        </td>
                                        <td width="70%">
                                            <input type="text" name="hostname" id="hostname" placeholder="<?php echo __("website/osteps/ex-placeholder"); ?>: server.example.com">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td width="30%">
                                            <label for="ns1">
                                                <?php echo __("website/osteps/server-ns1"); ?>
                                            </label>
                                        </td>
                                        <td width="70%">
                                            <input type="text" name="ns1" id="ns1" placeholder="<?php echo __("website/osteps/ex-placeholder"); ?>: ns1.example.com">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td width="30%">
                                            <label for="ns2">
                                                <?php echo __("website/osteps/server-ns2"); ?>
                                            </label>
                                        </td>
                                        <td width="70%">
                                            <input type="text" name="ns2" id="ns2" placeholder="<?php echo __("website/osteps/ex-placeholder"); ?>: ns2.example.com">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td width="30%">
                                            <label for="password">
                                                <?php echo __("website/osteps/server-password"); ?>
                                            </label>
                                        </td>
                                        <td width="70%">
                                            <input type="text" name="password" id="password" placeholder="<?php echo __("website/osteps/server-password-info"); ?>">
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if($addons): ?>
                        <div class="skonfiginfo" style="margin-bottom:20px;">
                            <div style="padding:20px;">
                                <h4><?php echo __("website/osteps/adjustable-options"); ?></h4>
                                <table width="100%" border="0">

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
                                                        <strong>  <?php echo $addon["name"]; ?></strong>
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
                                                                    $("#addon-<?php echo $addon["id"]; ?>-selection").change(function() {
                                                                        if( $(this).val() === '') {
                                                                            $('#addon-<?php echo $addon["id"]; ?>-slider-content').slideUp(250);
                                                                        }else{
                                                                            $('#addon-<?php echo $addon["id"]; ?>-slider-content').slideDown(250);
                                                                        }
                                                                    });
                                                                    $("#addon-<?php echo $addon["id"]; ?>-slider-value").ionRangeSlider({
                                                                        min: <?php echo $min; ?>,
                                                                        max: <?php echo $max; ?>,
                                                                        from:<?php echo $min; ?>,
                                                                        step:<?php echo $stp; ?>,
                                                                        grid: true,
                                                                        skin: "big",
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
                                </table>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if(isset($requirements) && $requirements): ?>

                        <div class="skonfiginfo" style="margin-bottom:20px;">
                            <div style="padding:20px;">
                                <h4><?php echo __("website/osteps/necessary-information2"); ?></h4>

                                <table width="100%" border="0" align="center">
                                    <?php
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
                                    ?>
                                </table>

                            </div>
                        </div>

                    <?php endif; ?>

                </div>

                <?php
                    $price     = $step1_data["selection"];
                    if($price){
                        $amount     = Money::formatter_symbol($price["amount"],$price["cid"],!$product["override_usrcurrency"]);
                        $period     = View::period($price["time"],$price["period"]);
                    }else{
                        $amount = ___("needs/free-amount");
                        $period = NULL;
                    }
                ?>
                <div class="sunucusipside">
                    <div class="skonfigside" style="width: 100%;">
                        <div style="padding:20px;">
                            <h4><?php echo __("website/osteps/order-summary"); ?></h4>
                            <strong><?php echo $product["title"]; echo $period ? ' | '.$period : ''; ?></strong>
                            <strong style="float: right"><?php echo $amount; ?></strong>
                            <br>
                            <?php echo $product["category_title"]; ?>
                            <div class="line"></div>
                            <div id="service_amounts"></div>
                            <div class="line"></div>
                            <div class="sunucretler">
                                <h3><span><?php echo __("website/osteps/total-amount"); ?>: <strong id="total_amount">0</strong></span></h3>
                            </div>
                        </div>
                    </div>

                    <a class="gonderbtn mio-ajax-submit" mio-ajax-options='{"result":"StepForm1_submit","waiting_text":"<?php echo addslashes(__("website/others/button1-pending")); ?>","progress_text":"<?php echo addslashes(__("website/others/button1-upload")); ?>"}' href="javascript:void(0);"><?php echo __("website/osteps/continue-button2"); ?></a>
                    <div class="clear"></div>
                    <div style="text-align: center; margin-top: 5px; display: none;" id="result" class="error"></div>
                </div>
                <script type="text/javascript">
                    $(document).ready(function(){
                        var changes = true;
                        ReloadOrderSummary();

                        $("#StepForm1").change(function(){
                            changes = true;
                        });
                        setInterval(function(){
                            if(changes)
                            {
                                ReloadOrderSummary();
                                changes = false;
                            }
                        },500);
                    });

                    function ReloadOrderSummary(){
                        var form_data = $("#StepForm1").serialize();
                        form_data = "OrderSummary=1&"+form_data;
                        var request = MioAjax({
                            action: "<?php echo $links["step"]; ?>",
                            method: "POST",
                            data:form_data
                        },true,true);

                        request.done(function (result){
                            if(result){
                                var solve = getJson(result),content='';
                                if(solve){
                                    if(solve.status == "successful"){
                                        $("#service_amounts").html('');
                                        if(solve.data != undefined){
                                            $(solve.data).each(function(key,item){
                                                content = '<span>- ';
                                                content += item.name;
                                                content += '\t<strong>'+item.amount+'</strong>';
                                                content += '</span>';
                                                $("#service_amounts").append(content);
                                            });
                                        }

                                        if(solve.total_amount != undefined)
                                            $("#total_amount").html(solve.total_amount);
                                    }else
                                        console.log(solve);
                                }else console.log(result);
                            }else console.log("Result not found");
                        });

                    }
                </script>

            </div>
        </form>
        <script type="text/javascript">
            function StepForm1_submit(result) {
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
                        }else if(solve.status == "successful")
                            window.location.href = solve.redirect;
                    }else
                        console.log(result);
                }
            }
        </script>
    <?php endif; ?>
</div>