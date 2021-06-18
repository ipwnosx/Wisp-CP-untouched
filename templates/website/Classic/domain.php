<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    $hoptions = [
        'page' => "domain",
        'jquery-ui',
    ];

    $currency_symbols = [];
    foreach(Money::getCurrencies() AS $currency){
        $symbol = $currency["prefix"] != '' ? trim($currency["prefix"]) : trim($currency["suffix"]);
        if(!$symbol) $symbol = $currency["code"];
        $currency_symbols[] = $symbol;
    }
?>
<script type="text/javascript">
    var disabled_style = "background:none; color:#333; cursor:no-drop; opacity:0.3;";
    var situations = [],loading_template;
    situations['unknown'] = '<?php echo __("website/domain/situations-unknown"); ?>';
    situations['premium'] = '<?php echo __("website/domain/situations-premium"); ?>';
    situations['available'] = '<?php echo __("website/domain/situations-available"); ?>';
    situations['unavailable'] = '<?php echo __("website/domain/situations-unavailable"); ?>';
    var contact_button            = '<a href="<?php echo $contact_link; ?>" class="incelebtn green" style="display: unset;"><?php echo __("website/domain/contact-us"); ?></a>';

    $(document).ready(function(){

        loading_template = $("#loading-template").html();

        var gDomain     = gGET("domain");
        var gTransfer   = gGET("transfer");
        if(gDomain != null && gDomain != '' && gDomain != undefined){
            $("#domainInput").val(gDomain);

            if(gTransfer != null && gTransfer != '' && gTransfer !== undefined)
            {
                $(".transfercode").slideToggle();
                $(".transfercode input").focus();
            }
            else
                checkButton(document.getElementById("checkButton"));
        }

        $("#transferbtn").click(function(){
            $(".transfercode").slideToggle();
        });

        $("#checkButton").click(function(){
            checkButton(this);
        });

        $("#transferButton").click(function(){
            transferButton(this);
        });

        $("#OrderForm").on("change","input[type=checkbox]",function(){
            var count = $("#OrderForm input[type=checkbox]:checked").length;
            if(count>0)
                $("#ContinueButton").removeAttr("style");
            else
                $("#ContinueButton").attr("style",disabled_style);
        });

    });

    function transfer_handler(result){
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
                        alert_error(solve.message,{timer:5000});
                }else if(solve.status == "successful"){
                    if(solve.message != undefined) alert_success(solve.message,{timer:2000});
                    if(solve.redirect != undefined && solve.redirect != '')
                        window.location.href = solve.redirect;
                }
            }else
                console.log(result);
        }
    }

    function scrollDown(){
        $("html, body").animate({ scrollTop: $('.popuzantilar').offset().top + 20  },1000);
    }

    function scrollUp(){
        $("html, body").animate({ scrollTop: - ($('.popuzantilar').offset().top + 20)  },1000);
    }

    function get_spotlight_results(tld){
        if(tld != false) $(".lookcolumlist[data-name='"+tld+"']:not(#domainResult)").remove();

        $("#checkForm input[name=type]").val("spotlight");

        var request  = MioAjax({
            action:"<?php echo $links["controller"]; ?>",
            form:$("#checkForm"),
            method:"POST",
        },true,true);


        request.done(function(result){
            if(result != ''){
                var solve = getJson(result);
                if(solve !== false){
                    if(solve.status == "successful"){
                        if(solve.data != undefined && solve.data.length>0){
                            $(solve.data).each(function(key,item){

                                (function(i) {
                                    var t = setTimeout(function() {
                                        var price_to_year  = " - ";
                                        var select_content = " - ";
                                        if(item.status == "available"){
                                            select_content = '<input id="selected-'+key+'" class="checkbox-custom" name="select['+item.sld+'.'+item.tld+']" value="1" type="checkbox" onchange="if($(\'#LookupList input[type=checkbox]:not(:checked)\').length>0) $(\'#selectAll\').prop(\'checked\',false); else $(\'#selectAll\').prop(\'checked\',true);">' +
                                                '<label for="selected-'+key+'" style="border-radius:0px;" class="checkbox-custom-label"></label>';
                                            if(item.premium !== undefined && item.premium) select_content = contact_button;


                                            if(item.reg_price != undefined && item.reg_price.length>0){
                                                price_to_year = "";
                                                var i=0;
                                                price_to_year += '<select id="tesclsure" name="period['+item.sld+'.'+item.tld+']">';
                                                $(item.reg_price).each(function(k,price){
                                                    i+=1;
                                                    price_to_year += '<option value="'+i+'">'+price+' ('+i+' <?php echo __("website/domain/year"); ?>)</option>';
                                                });
                                                price_to_year += '</select>';
                                            }
                                        }
                                        else
                                        {
                                            select_content = '<a href="javascript:transferModal(\''+item.domain+'\');" class="lbtn transfer-btn"><?php echo __("website/domain/transfer-btn"); ?></a> <a href="javascript:void 0;" onclick="openWhois(\''+item.domain+'\');" class="lbtn whois-btn"><?php echo __("website/domain/whois-btn"); ?></a> ';
                                        }

                                        $(".lookcolumlist[data-name='"+item.tld+"'] .tld-name").addClass("tldhere").html('<strong>'+item.sld+'.'+item.tld+'</strong>');
                                        $(".lookcolumlist[data-name='"+item.tld+"'] .tld-status").fadeOut(300,function(){
                                            if(item.premium !== undefined && item.premium)
                                                $(this).attr("id","tldok").html(situations['premium']);
                                            else if(item.status == "available")
                                                $(this).attr("id","tldok").html(situations[item.status]);
                                            else
                                                $(this).attr("id","tldno").html(situations[item.status]);

                                            $(this).fadeIn(300);
                                        });

                                        $(".lookcolumlist[data-name='"+item.tld+"'] .tld-prices").fadeOut(300,function(){
                                            $(this)
                                                .html(price_to_year)
                                                .fadeIn(300);
                                        });
                                        $(".lookcolumlist[data-name='"+item.tld+"'] .tld-select").fadeOut(function(){
                                            $(this).html(select_content).fadeIn(300);
                                        });
                                    }, 200 * i);
                                })(key);


                            });
                        }
                    }
                }else
                    console.log(result);
            }
        });
    }

    function checkButton(elem){

        var button = $(elem);

        if(button.attr("data-pending") == "true") return false;
        button.attr("data-pending","true");

        var domain = $("#domainInput").val();
        $("#checkForm input[name=domain]").val(domain);
        $("#checkForm input[name=tcode]").val('');

        if(domain != ''){
            scrollDown();
            $("#LookupResults").css("display","block");
            $("#showTLDStatusLoader").css("display","block");
            $("#OrderForm").fadeIn(300);

            $("#LookupList .lookcolumlist:not(#domainResult)").remove();
            var count = $(".spotlight-tlds").length,content;
            if(count>0){
                count -=1;
                for(var i=0;i<=count;i++){
                    var name  = $(".spotlight-tlds:eq("+i+")").data("name");
                    content = '<div class="lookcolumlist" data-name="'+name+'">';
                    content += '<div class="lookcolum tld-name">'+loading_template+'</div>';
                    content += '<div class="lookcolum tld-status">'+loading_template+'</div>';
                    content += '<div class="lookcolum tld-prices">'+loading_template+'</div>';
                    content += '<div class="lookcolum tld-select"> - </div>';
                    content += '</div>';
                    $("#LookupList").append(content);
                }
            }

        }

        <?php
        /*if(!isset($captcha) || !$captcha){
            echo 'if(count>0) get_spotlight_results(false);';
        }*/
        ?>

        $("#checkForm input[name=type]").val("domain");

        $("#selectAll").prop('checked',false);
        $("#transfercode").slideUp(200);
        $("#ContinueButton").attr("style",disabled_style);
        $("#showTLDStatusUnavailable").css("display","none");
        $("#showTLDStatusAvailable").css("display","none");


        $("#domainResult").removeAttr("data-name");
        $("#domainResult .tld-name").removeClass("tldhere").html(loading_template);
        $("#domainResult .tld-status").removeAttr("id").html(loading_template);
        $("#domainResult .tld-prices").html(loading_template);
        $("#domainResult .tld-select").html(" - ");


        var request  = MioAjax({
            action:"<?php echo $links["controller"]; ?>",
            form:$("#checkForm"),
            method:"POST",
        },true,true);

        request.done(function(result){
            <?php if(isset($captcha)) echo $captcha->submit_after_js(); ?>

            button.removeAttr("data-pending");

            $("#showTLDStatusLoader").css("display","none");

            if(result != ''){
                var solve = getJson(result);
                if(solve !== false){
                    if(solve.status == "error"){

                        $("#LookupResults").css("display","none");

                        scrollUp();
                        $("#domainInput").attr("style","border-bottom:2px solid red; color:red;")
                            .focus()
                            .change(function(){
                                $(this).removeAttr("style");
                            });



                        if(solve.for != undefined && solve.for != ''){
                            $(solve.for).focus();
                            $(solve.for).attr("style","border-bottom:2px solid red; color:red;");
                            $(solve.for).change(function(){
                                $(this).removeAttr("style");
                            });
                        }
                        if(solve.message != undefined && solve.message != '')
                            alert_error(solve.message,{timer:2000});
                    }else if(solve.status == "successful"){

                        if(solve.data != undefined && solve.data.length>0){

                            $(solve.data).each(function(key,item){
                                var price_to_year  = " - ";
                                var select_content = " - ";
                                if(item.status == "available"){
                                    select_content = '<input checked id="selected-x0" class="checkbox-custom" name="select['+item.sld+'.'+item.tld+']" value="1" type="checkbox" onchange="if($(\'#LookupList input[type=checkbox]:not(:checked)\').length>0) $(\'#selectAll\').prop(\'checked\',false); else $(\'#selectAll\').prop(\'checked\',true);">' +
                                        '<label for="selected-x0" style="border-radius:0px;" class="checkbox-custom-label"></label>';

                                    if(item.premium !== undefined && item.premium) select_content = contact_button;

                                    if(item.reg_price != undefined && item.reg_price.length>0){
                                        price_to_year = "";
                                        var i=0;
                                        price_to_year += '<select id="tesclsure" name="period['+item.sld+'.'+item.tld+']">';
                                        $(item.reg_price).each(function(k,price){
                                            i+=1;
                                            price_to_year += '<option value="'+i+'">'+price+' ('+i+' <?php echo __("website/domain/year"); ?>)</option>';
                                        });
                                        price_to_year += '</select>';
                                    }
                                }
                                else
                                {
                                    select_content = '<a href="javascript:transferModal(\''+item.domain+'\');" class="lbtn transfer-btn"><?php echo __("website/domain/transfer-btn"); ?></a> <a href="javascript:void 0;" onclick="openWhois(\''+item.domain+'\');" class="lbtn whois-btn"><?php echo __("website/domain/whois-btn"); ?></a> ';
                                }

                                $("#domainResult").attr("data-name",item.tld);

                                $("#domainResult .tld-name").fadeOut(300,function(){
                                    $(this).addClass("tldhere").attr("data-name",item.tld).html('<strong>'+item.sld+'.'+item.tld+'</strong>').fadeIn(300);
                                });

                                $("#domainResult .tld-status").fadeOut(300,function(){
                                    if(item.premium !== undefined && item.premium) {
                                        $(this).attr("id", "tldok").html(situations['premium']);
                                        $("#ContinueButton").removeAttr("style");
                                    }
                                    else if(item.status == "available"){
                                        $(this).attr("id", "tldok").html(situations[item.status]);
                                        $("#ContinueButton").removeAttr("style");
                                    }else
                                        $(this).attr("id","tldno").html(situations[item.status]);
                                    $(this).fadeIn(300);
                                });

                                $("#domainResult .tld-prices").fadeOut(300,function(){
                                    $(this).html(price_to_year).fadeIn(300);
                                });
                                $("#domainResult .tld-select").fadeOut(300,function(){
                                    $(this).html(select_content).fadeIn(300);
                                });

                                if(item.status == "available")
                                    var LookupDomainStatus = '<?php echo str_replace("'",'&#x27;',__("website/domain/lookup-domain-status-available",[
                                        "'" => "\'",
                                    ])); ?>';
                                else if(item.status == "unknown")
                                    var LookupDomainStatus = situations["unknown"];
                                else
                                    var LookupDomainStatus = '<?php echo str_replace("'",'&#x27;',__("website/domain/lookup-domain-status-unavailable")); ?>';

                                LookupDomainStatus = LookupDomainStatus.replace("{domain}",item.domain);
                                if(item.status == "available"){
                                    $("#showTLDStatusUnavailable").fadeOut(300,function(){
                                        $("#showTLDStatusAvailable").fadeIn(300).html(LookupDomainStatus);
                                    });
                                }else{
                                    $("#showTLDStatusAvailable").fadeOut(300,function(){
                                        $("#showTLDStatusUnavailable").fadeIn(300).html(LookupDomainStatus);
                                    });
                                }

                                <?php
                                echo 'if(count>0) get_spotlight_results(item.tld);';
                                /*if(isset($captcha) && $captcha){
                                    echo 'if(count>0) get_spotlight_results(item.tld);';
                                }else{
                                    echo 'if(count>0) $(".lookcolumlist[data-name=\'"+item.tld+"\']:not(#domainResult)").remove();';
                                }*/
                                ?>
                            });
                        }
                    }
                }else
                    console.log(result);
            }
        });

    }

    function transferButton(elem)
    {
        $("#checkForm input[name=domain]").val($("#domainInput").val());
        $("#checkForm input[name=tcode]").val($("#transfer_code").val());
        $("#checkForm input[name=type]").val("transfer");
        MioAjaxElement($(elem),{
            form:$("#checkForm"),
            waiting_text: '<?php echo __("website/others/button3-pending"); ?>',
            result:"transfer_handler",
        });
    }

    function OrderForm_before_submit(){
        var count = $("#OrderForm input[type=checkbox]:checked").length;
        return count>0 ? true : false;
    }
    function OrderForm_submit(result) {
        if(result != ''){
            var solve = getJson(result);
            if(solve !== false){
                if(solve.status == "error"){
                    if(solve.for != undefined && solve.for != ''){
                        $("#OrderForm "+solve.for).focus();
                        $("#OrderForm "+solve.for).attr("style","");
                        $("#OrderForm "+solve.for).change(function(){
                            $(this).removeAttr("style");
                        });
                    }
                    if(solve.message != undefined && solve.message != '')
                        alert_error(solve.message,{timer:3000});

                }else if(solve.status == "successful"){
                    $("#OrderForm #result").fadeOut(300).html('');
                    if(solve.redirect != undefined && solve.redirect != '') window.location.href = solve.redirect;
                }
            }else
                console.log(result);
        }

    }

    function openWhois(domain)
    {
        var title = 'WHOIS';
        var url = '<?php echo $links["controller"]; ?>?whois='+domain+"&token=<?php echo Validation::get_csrf_token('domain-check',false); ?>";
        var w   = 1090;
        var h   = 600;
        var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
        var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;
        var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;
        var left = ((width / 2) - (w / 2)) + dualScreenLeft;
        var top = ((height / 2) - (h / 2)) + dualScreenTop;
        /*--------------*/
        window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
    }

    function transferModal(domain)
    {
        scrollUp();
        $("#domainInput").val(domain);
        $(".transfercode").slideDown();
        $(".transfercode input").focus();

    }
</script>
<div id="wrapper" class="wclientdomainpage">

    <?php
        $first_tld_price_amount = $first_tld_price["register"]["amount"];
        if($first_tld_price["promo_status"] && (substr($first_tld_price["promo_duedate"],0,4) == '1881' || DateManager::strtotime($first_tld_price["promo_duedate"]." 23:59:59") > DateManager::strtotime()) && $first_tld_price["promo_register_price"]>0){
            $first_tld_price_amount = $first_tld_price["promo_register_price"];
        }

        $first_price = Money::formatter_symbol($first_tld_price_amount,$first_tld_price["currency"],!$override_usrcurrency);

        if($first_price){
            $first_price_symbol_position    = '';
            $split_amount                   = explode(" ",$first_price);
            $first_price_symbol             = '';
            if(in_array(current($split_amount),$currency_symbols)){
                $first_price_symbol_position = "left";
                $first_price_symbol  = current($split_amount);
                array_shift($split_amount);
                $first_price                = implode(" ",$split_amount);
            }elseif(in_array(end($split_amount),$currency_symbols)){
                $first_price_symbol_position = "right";
                $first_price_symbol  = end($split_amount);
                array_pop($split_amount);
                $first_price         = implode(" ",$split_amount);
            }
            $first_price            = '<div class="amount_spot_view"><i class="currpos'.$first_price_symbol_position.'">'.$first_price_symbol.'</i> '.$first_price.'</div>';
        }

    ?>
    <div class="alanadisorgu">
        <h1><?php echo __("website/domain/slogan",['{price}' => $first_price]); ?></h1>

        <input id="domainInput" type="text" placeholder="<?php echo __("website/domain/domain-placeholder"); ?>">
        <a href="javascript:void(0);" id="checkButton" class="gonderbtn"><?php echo __("website/domain/check-it"); ?></a>
        <a href="javascript:void(0);" class="gonderbtn" id="transferbtn"><?php echo __("website/domain/transfer"); ?></a>

        <div class="clear"></div>

        <form id="checkForm" action="<?php echo $links["controller"]; ?>" method="post" onsubmit="return false;">
            <?php echo Validation::get_csrf_token('domain-check'); ?>

            <input type="hidden" name="operation" value="check">
            <input type="hidden" name="type" value="domain">
            <input type="hidden" name="domain" value="">
            <input type="hidden" name="tcode" value="">
            <?php if(isset($captcha) && $captcha): ?>
                <div class="captcha-content" style=" margin:auto; margin-top: 20px;">
                    <div><?php echo $captcha->getOutput(); ?></div>
                    <?php if($captcha->input): ?>
                        <input id="captchainput" name="<?php echo $captcha->input_name; ?>" type="text" placeholder="<?php echo ___("needs/form-captcha-label"); ?>">
                    <?php endif; ?>
                </div>
                <div class="clear"></div>
            <?php endif; ?>
        </form>


    </div>


    <div class="clear"></div>

    <div id="transfercode" class="transfercode">
        <h5><strong><?php echo __("website/domain/transfer-text1"); ?></strong></h5>

        <input id="transfer_code" type="text" placeholder="<?php echo __("website/domain/transfer-code"); ?>">
        <a href="javascript:void(0);" id="transferButton" class="green lbtn"><?php echo __("website/domain/transfer-continue-button"); ?></a>
    </div>

    <div class="clear"></div>

    <div class="popuzantilar">
        <?php
            if(isset($box_tldList) && is_array($box_tldList)){
                foreach($box_tldList AS $row){

                    $is_img = false;
                    $is_svg = "images".DS."tldlogos".DS.$row["name"].".svg";
                    $is_png = "images".DS."tldlogos".DS.$row["name"].".png";
                    $is_jpg = "images".DS."tldlogos".DS.$row["name"].".jpg";
                    if(file_exists(View::$init->get_template_dir().$is_svg)) $is_img = $is_svg;
                    elseif(file_exists(View::$init->get_template_dir().$is_png)) $is_img = $is_png;
                    elseif(file_exists(View::$init->get_template_dir().$is_jpg)) $is_img = $is_jpg;

                    if($row["promo_status"] && (substr($row["promo_duedate"],0,4) == '1881' || DateManager::strtotime($row["promo_duedate"]." 23:59:59") > DateManager::strtotime()) && $row["promo_register_price"]>0){

                        $amount1     = Money::formatter_symbol($row["reg_price"]["amount"],$row["reg_price"]["cid"],!$override_usrcurrency);
                        $amount1_symbol_position = '';
                        $split_amount   = explode(" ",$amount1);
                        $amount1_symbol  = '';
                        if(in_array(current($split_amount),$currency_symbols)){
                            $amount1_symbol_position = "left";
                            $amount1_symbol  = current($split_amount);
                            array_shift($split_amount);
                            $amount1         = implode(" ",$split_amount);
                        }elseif(in_array(end($split_amount),$currency_symbols)){
                            $amount1_symbol_position = "right";
                            $amount1_symbol  = end($split_amount);
                            array_pop($split_amount);
                            $amount1         = implode(" ",$split_amount);
                        }

                        $amount2     = Money::formatter_symbol($row["promo_register_price"],$row["currency"],!$override_usrcurrency);
                        $amount2_symbol_position = '';
                        $split_amount   = explode(" ",$amount2);
                        $amount2_symbol  = '';
                        if(in_array(current($split_amount),$currency_symbols)){
                            $amount2_symbol_position = "left";
                            $amount2_symbol  = current($split_amount);
                            array_shift($split_amount);
                            $amount2         = implode(" ",$split_amount);
                        }elseif(in_array(end($split_amount),$currency_symbols)){
                            $amount2_symbol_position = "right";
                            $amount2_symbol  = end($split_amount);
                            array_pop($split_amount);
                            $amount2         = implode(" ",$split_amount);
                        }

                        ?>
                        <div class="uzantibox spotlight-tlds" data-name="<?php echo $row["name"]; ?>" style="position: relative;   ">

                            <div  style="color:white;position: absolute; font-size: 14px;width: 100%;margin-top: -20px;"><span class="domdiscount" ><?php echo __("website/domain/promo"); ?></span>
                            </div>

                            <div style="padding:10px">
                                <h4>
                                    <?php if($is_img): ?>
                                        <img src="<?php echo Utility::image_link_determiner($tadress.$is_img); ?>" alt=".<?php echo $row["name"]; ?>">
                                    <?php else: ?>
                                        .<?php echo $row["name"]; ?>
                                    <?php endif; ?>
                                </h4>
                                <h5>
                                    <!--div class="amount_spot_view doldprice"><i class="currpos<?php echo $amount1_symbol_position; ?>"><?php echo $amount1_symbol; ?></i> <?php echo $amount1; ?></div-->

                                </h5>
                            </div>
                            <div class="dnewprice">
                                <span class="ddiscountnewprice"><div class="amount_spot_view"><i class="currpos<?php echo $amount2_symbol_position; ?>"><?php echo $amount2_symbol; ?></i> <?php echo $amount2; ?></div></span>
                            </div>
                        </div>
                        <?php
                    }else{

                        $amount1     = Money::formatter_symbol($row["reg_price"]["amount"],$row["reg_price"]["cid"],!$override_usrcurrency);
                        $amount1_symbol_position = '';
                        $split_amount   = explode(" ",$amount1);
                        $amount1_symbol  = '';
                        if(in_array(current($split_amount),$currency_symbols)){
                            $amount1_symbol_position = "left";
                            $amount1_symbol  = current($split_amount);
                            array_shift($split_amount);
                            $amount1         = implode(" ",$split_amount);
                        }elseif(in_array(end($split_amount),$currency_symbols)){
                            $amount1_symbol_position = "right";
                            $amount1_symbol  = end($split_amount);
                            array_pop($split_amount);
                            $amount1         = implode(" ",$split_amount);
                        }

                        ?>
                        <div class="uzantibox spotlight-tlds" data-name="<?php echo $row["name"]; ?>">
                            <div style="padding:10px">
                                <h4>
                                    <?php if($is_img): ?>
                                        <img src="<?php echo Utility::image_link_determiner($tadress.$is_img); ?>" alt=".<?php echo $row["name"]; ?>">
                                    <?php else: ?>
                                        .<?php echo $row["name"]; ?>
                                    <?php endif; ?>
                                </h4>
                                <h5><div class="amount_spot_view"><i class="currpos<?php echo $amount1_symbol_position; ?>"><?php echo $amount1_symbol; ?></i> <?php echo $amount1; ?></div></h5>
                            </div>
                        </div>
                        <?php
                    }
                }
            }
        ?>
    </div>


    <div class="domainlookuplist" style="display: none;" id="LookupResults">

        <div class="tldavailable">
            <div class="spinnertld" style="display: none;" id="showTLDStatusLoader">
                <div class="bounce1"></div>
                <div class="bounce2"></div>
                <div class="bounce3"></div>
            </div>

            <h4 id="showTLDStatusAvailable" style="display: none;"></h4>
            <h4 id="showTLDStatusUnavailable" style="display: none;"></h4>
        </div>

        <form action="<?php echo $links["controller"]; ?>" method="post" id="OrderForm" style="display: none;">
            <?php echo Validation::get_csrf_token('order-steps'); ?>

            <input type="hidden" name="operation" value="order_step">

            <div class="lookcolumtitle">
                <div class="lookcolum"><?php echo __("website/domain/check-result-tld"); ?></div>
                <div class="lookcolum"><?php echo __("website/domain/check-result-status"); ?></div>
                <div class="lookcolum"><?php echo __("website/domain/check-result-amount"); ?></div>
                <div class="lookcolum">

                    <input type="checkbox" id="selectAll" class="checkbox-custom" onchange="if($('#LookupList input[type=checkbox]').length>0) $('#LookupList input[type=checkbox]').prop('checked',$(this).prop('checked')); else $(this).prop('checked',false);">
                    <label for="selectAll" class="checkbox-custom-label" style="border-radius:0px;"> </label>
                </div>
            </div>

            <div id="loading-template" style="display: none;">
                <div class="spinnertld">
                    <div class="bounce1"></div>
                    <div class="bounce2"></div>
                    <div class="bounce3"></div>
                </div>
            </div>

            <div id="LookupList">

                <div class="lookcolumlist" id="domainResult">
                    <div class="lookcolum tld-name"></div>
                    <div class="lookcolum tld-status"></div>
                    <div class="lookcolum tld-prices"></div>
                    <div class="lookcolum tld-select">	- </div>
                </div>


            </div>


            <div class="lookcolumlist tldlistfoot">
                <div class="lookcolum" style="float:right;">
                    <a style="background:none; color:#333; cursor:no-drop; opacity:0.3;" class="yesilbtn gonderbtn mio-ajax-submit" href="javascript:void(0);" mio-ajax-options='{"before_function":"OrderForm_before_submit","result":"OrderForm_submit","waiting_text":"<?php echo addslashes(__("website/others/button1-pending")); ?>"}' id="ContinueButton"><?php echo __("website/domain/check-result-continue"); ?></a>
                </div>
            </div>


        </form>


        <div class="clear"></div>
    </div>



</div>


<?php if(!Validation::isEmpty(strip_tags($content))): ?>
    <?php echo $content; ?>
    <div class="clear"></div>
<?php endif; ?>

<div id="wrapper">
    <div class="tescilucretleri">
        <h4><strong><?php echo __("website/domain/tld-price-list"); ?></strong></h4>


        <table width="100%" border="0" style="border-collapse: collapse;">
            <thead>
            <tr>
                <th bgcolor="#F2F2F2"><strong><?php echo __("website/domain/tld-name"); ?></strong></th>
                <th align="center" bgcolor="#F2F2F2"><strong><?php echo __("website/domain/tld-register"); ?></strong></th>
                <th align="center" bgcolor="#F2F2F2"><strong><?php echo __("website/domain/tld-renewal"); ?></strong></th>
                <th align="center" bgcolor="#F2F2F2"><strong><?php echo __("website/domain/tld-transfer"); ?></strong></th>
            </tr>
            </thead>
            <tbody>

            <?php
                if(isset($tldList) && is_array($tldList) && sizeof($tldList)){
                    foreach($tldList AS $row){

                        if($row["promo_status"] && (substr($row["promo_duedate"],0,4) == '1881' || DateManager::strtotime($row["promo_duedate"]." 23:59:59") > DateManager::strtotime())){
                            ?>
                            <tr style="background: #eeeeee5e;border-bottom: 1px solid #dfdfdf;">
                                <td><strong style="font-weight:bold;color: #8BC34A;font-size: 18px;">.<?php echo $row["name"]; ?></strong>
                                    <?php if($row["paperwork"]): ?>
                                        <strong><a data-tooltip="<?php echo __("website/domain/docsrequired"); ?>"> <i style="margin-left: 10px;"  class="fa fa-file-text-o" aria-hidden="true"></i></a></strong>
                                    <?php endif; ?>
                                </td>
                                <?php
                                    if($row["promo_register_price"] > 0){
                                        ?>
                                        <td align="center"><div style="text-decoration:line-through;"><?php echo Money::formatter_symbol($row["reg_price"]["amount"],$row["reg_price"]["cid"],!$override_usrcurrency); ?></div><div style="font-weight:bold;color: #8BC34A;font-size: 18px;"><?php echo Money::formatter_symbol($row["promo_register_price"],$row["currency"],!$override_usrcurrency); ?></div></td>
                                        <?php
                                    }else{
                                        ?>
                                        <td align="center"><?php echo Money::formatter_symbol($row["reg_price"]["amount"],$row["reg_price"]["cid"],!$override_usrcurrency); ?></td>
                                        <?php
                                    }
                                ?>

                                <td align="center"><?php echo Money::formatter_symbol($row["ren_price"]["amount"],$row["ren_price"]["cid"],!$override_usrcurrency); ?></td>

                                <?php
                                    if($row["promo_transfer_price"] > 0){
                                        ?>
                                        <td align="center"><div style="text-decoration:line-through;"><?php echo Money::formatter_symbol($row["tra_price"]["amount"],$row["tra_price"]["cid"],!$override_usrcurrency); ?></div><div style="font-weight:bold;color: #8BC34A;font-size: 18px;"><?php echo Money::formatter_symbol($row["promo_transfer_price"],$row["currency"],!$override_usrcurrency); ?></div></td>
                                        <?php
                                    }else{
                                        ?>
                                        <td align="center"><?php echo Money::formatter_symbol($row["tra_price"]["amount"],$row["tra_price"]["cid"],!$override_usrcurrency); ?></td>
                                        <?php
                                    }
                                ?>
                            </tr>
                            <?php
                        }else{
                            ?>
                            <tr>
                                <td><strong>.<?php echo $row["name"]; ?></strong>
                                    <?php if($row["paperwork"]): ?>
                                        <strong><a data-tooltip="<?php echo __("website/domain/docsrequired"); ?>"> <i style="margin-left: 10px;"  class="fa fa-file-text-o" aria-hidden="true"></i></a></strong>
                                    <?php endif; ?>
                                </td>
                                <td align="center"><?php echo Money::formatter_symbol($row["reg_price"]["amount"],$row["reg_price"]["cid"],!$override_usrcurrency); ?></td>
                                <td align="center"><?php echo Money::formatter_symbol($row["ren_price"]["amount"],$row["ren_price"]["cid"],!$override_usrcurrency); ?></td>
                                <td align="center"><?php echo Money::formatter_symbol($row["tra_price"]["amount"],$row["tra_price"]["cid"],!$override_usrcurrency); ?></td>
                            </tr>
                            <?php
                        }

                    }
                }
            ?>

            </tbody></table>
    </div>
</div>

<?php if(isset($faq) && $faq): ?>
    <script type="text/javascript">
        $(document).ready(function(){
            $( "#accordion" ).accordion({
                heightStyle: "content"
            });
        });
    </script>
    <div id="wrapper">
        <div class="sss">
            <h4><strong><?php echo __("website/others/faq"); ?></strong></h4>
            <div id="accordion">
                <?php foreach($faq AS $f): ?>
                    <h3><?php echo $f["title"]; ?></h3>
                    <div><?php echo $f["description"]; ?></div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="clear"></div>