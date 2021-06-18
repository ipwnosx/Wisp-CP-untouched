<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    $hoptions = [
        'page' => "international-sms-introduction",
        'jquery-ui',
        'select2',
    ];
?>
<script type="text/javascript">
    var countries_select,selected_currency;
    $(document).ready(function(){

        countries_select = $("#countries").select2({
            templateResult: format_select2,
            templateSelection: format_select2,
        });

        country_change(document.getElementById("countries"));

        $("#countries").change(function(){
            country_change(this);
        });

    });

    function setCurrency(code){
        $(".currency-button").removeClass("active");
        $("#currency-button-"+code).addClass("active");
        selected_currency = code;
        $(".currency-content").css("display","none");
        $("#currency-"+code).css("display","block");
        $("#download_prices").attr("href",'<?php echo $download_prices; ?>/'+code);
    }

    function format_select2(state) {
        if (!state.id) { return state.text; }
        var originalOption = state.element;
        var image_url = $(originalOption).data('image');
        if(image_url == undefined) return state.text;
        return $("<span><img class='select2-flag' src='" + image_url + "' /> "+state.text+"</span>");
    }

    function country_change(element){
        if(!selected_currency) selected_currency = $("#defCurrency").val();
        element = $(element);
        if(element.val() == '') $("#calculateResult").css("display","none");
        else{
            var option = $("option:selected",element),prices,pre_register;
            $("#calculateResult").css("display","block");
            $("#country-name").html(option.text());
            prices = option.attr("data-prices");
            prices = getJson(prices);
            pre_register = option.data("pre-register");
            var keys = Object.keys(prices),amount,amount2,amount_thousands;
            $(keys).each(function(k,v){
                amount  = prices[v].one;
                amount_thousands = prices[v].thousands;
                amount2 = amount_thousands;
                var comma_split = amount_thousands.split(",");
                var point_split = amount_thousands.split(".");

                if(comma_split[1] != undefined){
                    var decimal = comma_split[1];
                    if(decimal.length==4){
                        decimal     = decimal.substr(0,2);
                        amount2     = comma_split[0]+","+decimal;
                    }
                }else if(point_split[1] != undefined){
                    var decimal = point_split[1];
                    if(decimal.length==4){
                        decimal     = decimal.substr(0,2);
                        amount2     = point_split[0]+"."+decimal;
                    }
                }
                $("#calculate-"+v+"-amount").html(amount);
                $("#calculate-"+v+"-amount-thousands").html(amount2);
            });
            if(pre_register)
                $("#country_pre_register").css("display","block");
            else
                $("#country_pre_register").css("display","none");
        }
    }
</script>
<div id="wrapper">

    <div class="internationalsmspage">

        <div class="leftblock">
            <h3><?php echo __("website/account_sms/introduction-slogan"); ?></h3>

            <h4><?php echo __("website/account_sms/introduction-desc"); ?></h4>

            <?php if($api_service): ?>
                <h4><?php echo __("website/account_sms/introduction-api-desc"); ?></h4>
                <a style="width:230px;" class="yesilbtn gonderbtn " href="<?php echo __("website/account_sms/introduction-api-link"); ?>" target="_blank"><i style="margin-right:7px;" class="fa fa-cogs" aria-hidden="true"></i> <?php echo __("website/account_sms/introduction-api-button"); ?></a>
            <?php endif; ?>
        </div>

        <div class="rightblock" style="background-image: url(<?php echo $tadress;?>images/map.svg);">

            <h2 class="rightblocktitle"><?php echo __("website/account_sms/introduction-calculate-title"); ?></h2>

            <select id="countries">
                <option value=""><?php echo __("website/account_sms/introduction-calculate-select-country"); ?></option>
                <?php
                    foreach($country_prices AS $country){
                        $cc     = $country["cc"];
                        $prices = $country["prices"];
                        ?>
                        <option
                            <?php echo $default_country == $cc ? 'selected' : ''; ?>
                                value="<?php echo $cc; ?>"
                                data-prices='<?php echo Utility::jencode($prices); ?>'
                                data-pre-register="<?php echo $country["pre-register"] ? 'true' : 'false'; ?>"
                                data-image="<?php echo $sadress."assets/images/flags/".$cc.".svg"; ?>"><?php echo $country["name"]; ?></option>
                        <?php
                    }
                ?>
            </select>
            <div id="calculateResult" style="display: none;">
                <br>
                <?php echo __("website/account_sms/introduction-calculate-note"); ?>
                <br><br>
                <?php
                    $currs          = [];
                    $defCurr        = '';
                    $currencies     = [];

                    foreach(Money::getCurrencies() AS $row){
                        if($row["id"] == $ucid) array_unshift($currencies,$row);
                        else array_push($currencies,$row);
                    }


                    foreach($currencies AS $curr){
                        $currs[] = $curr["code"];
                        if($curr["id"] == $ucid) $defCurr = $curr["code"];
                        ?>
                        <a id="currency-button-<?php echo $curr["code"]; ?>" class="<?php echo $curr["id"] == $ucid ? 'active ' : ''; ?>lbtn currency-button" href="javascript:setCurrency('<?php echo $curr["code"]; ?>');void 0;"><?php echo $curr["code"]; ?></a>
                        <?php
                    }
                ?>
                <br><br>
                <h2 style="color:#009595"><strong id="country-name">?</strong></h2>
                <h2 style="color:#4d4d4d;">
                    <?php
                        foreach ($currs AS $curr){
                            ?>
                            <span id="currency-<?php echo $curr; ?>"<?php echo $defCurr == $curr ? '' : ' style="display: none;"'; ?> class="currency-content">
                                1 SMS = <span id="calculate-<?php echo $curr; ?>-amount">0</span> <span style="font-size:20px;"><?php echo $curr; ?></span><br>
                                <span class="amount-thousands">(1000 SMS = <span id="calculate-<?php echo $curr; ?>-amount-thousands">0</span> <?php echo $curr; ?>)</span>
                            </span>
                            <?php
                        }
                    ?>
                </h2>
                <span style="font-size:13px;display:none;" id="country_pre_register"><?php echo __("website/account_sms/introduction-calculate-pre-register-note"); ?></span>

                <input type="hidden" id="defCurrency" value="<?php echo $defCurr; ?>">
            </div>


            <div style="width:70%;float:none;display:inline-block;" class="line"></div>
            <div class="clear"></div>
            <br>
            <a class="gonderbtn" href="<?php echo $download_prices; ?>/<?php echo $defCurr; ?>" id="download_prices" target="_blank"><?php echo __("website/account_sms/introduction-download-prices"); ?></a>
        </div>
    </div>

    <?php echo $content; ?>

    <div class="clear"></div>
    <?php if(isset($faq) && $faq): ?>
        <script type="text/javascript">
            $(document).ready(function(){
                $( "#accordion" ).accordion({
                    heightStyle: "content"
                });
            });
        </script>
        <div class="sss">
            <h4><strong><?php echo __("website/others/faq"); ?></strong></h4>
            <div id="accordion">
                <?php foreach($faq AS $f): ?>
                    <h3><?php echo $f["title"]; ?></h3>
                    <div><?php echo $f["description"]; ?></div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>
<div class="clear"></div>