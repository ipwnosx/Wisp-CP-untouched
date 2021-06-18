<!DOCTYPE html>
<html>
<head>
    <?php
        $gateways           = Config::get("options/affiliate/payment-gateways");
        $gateways_lid       = Config::get("options/affiliate/payment-gateways-lid");
        $local_l            = Config::get("general/local");
        $currency           = Money::Currency(Config::get("general/currency"));
        $currency_s         = Money::getSymbol(Config::get("general/currency"));
        $affiliate_min_p_a  = Config::get("options/affiliate/min-payment-amount");
        $redirect_url       = Config::get("options/affiliate/redirect");
        $plugins            = ['dataTables','select2','tinymce-1'];
        Utility::sksort($lang_list,'local');
        include __DIR__.DS."inc".DS."head.php";
    ?>
</head>
<body>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1>
                    <strong><?php echo __("admin/users/page-affiliate-settings");?></strong>
                </h1>

                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="adminpagecon">

               
                <div class="clear"></div>

                <script type="text/javascript">
                    var gateways_lid = <?php echo $gateways_lid; ?>;
                    $(document).ready(function(){

                        $(".change-lang-buttons a").click(function(){
                            var _wrap   = $(this).parent();
                            var _type   = $(_wrap).data("type");
                            var k       = $(this).data("key");

                            if($(this).attr("id") === "lang-active") return false;
                            window[_type+"_selected_lang"] = k;

                            $("."+_type+"-names").css("display","none");
                            $("."+_type+"-name-"+k).css("display","block");

                            $("."+_type+"-values").css("display","none");
                            $("."+_type+"-value-"+k).css("display","inline-block");

                            $("a",_wrap).removeAttr("id");
                            $(this).attr("id","lang-active");
                        });

                        $("#AffiliateSettingsForm_submit").on("click",function(){
                            MioAjaxElement($(this),{
                                waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                                progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                                result:"AffiliateSettingsForm_handler",
                            });
                        });

                    });
                    function AffiliateSettingsForm_handler(result){
                        if(result !== ''){
                            var solve = getJson(result);
                            if(solve !== false){
                                if(solve.status == "error"){
                                    if(solve.for != undefined && solve.for != ''){
                                        $("#AffiliateSettingsForm "+solve.for).focus();
                                        $("#AffiliateSettingsForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                        $("#AffiliateSettingsForm "+solve.for).change(function(){
                                            $(this).removeAttr("style");
                                        });
                                    }
                                    if(solve.message != undefined && solve.message != '')
                                        alert_error(solve.message,{timer:5000});
                                }else if(solve.status == "successful"){
                                    alert_success(solve.message,{timer:2000});
                                    if(solve.redirect != undefined && solve.redirect != ''){
                                        setTimeout(function(){
                                            window.location.href = solve.redirect;
                                        },2000);
                                    }
                                }
                            }else
                                console.log(result);
                        }
                    }
                    function add_payment_gateway(){
                        var template = $('#template-payment-gateway-item').html();
                        gateways_lid += 1;
                        $("#gateways-lid").val(gateways_lid);
                        template = template.replace(/\[x\]/g,"["+gateways_lid+"]");

                        $("#wrap_payment_gateways").append(template);
                    }
                </script>

                <ul id="template-payment-gateway-item" style="display: none;">
                    <li>
                        <?php
                            foreach($lang_list AS $lang)
                            {
                                $l_k = $lang['key'];
                                ?>
                                <input type="text" name="payment-gateways[x][<?php echo $l_k; ?>]" value="" class="yuzde50 lcon-values lcon-value-<?php echo $l_k; ?>" style="<?php echo $l_k == $local_l ? '' : 'display:none;'; ?>">
                                <?php
                            }
                        ?>
                        <div class="yuzde10">
                            <a class="sbtn red" onclick="$(this).parent().parent().remove();"><i class="fa fa-times"></i></a>
                        </div>
                    </li>
                </ul>

                <form action="<?php echo $links["controller"]; ?>" method="post" id="AffiliateSettingsForm">
                    <input type="hidden" name="operation" value="update_affiliate_settings">


                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/users/affiliate-status"); ?></div>
                        <div class="yuzde70">
                            <input<?php echo Config::get("options/affiliate/status") ? ' checked' : ''; ?> type="checkbox" name="status" value="1" id="affiliate-status" class="sitemio-checkbox">
                            <label for="affiliate-status" class="sitemio-checkbox-label"></label>
                            <span class="kinfo"><?php echo __("admin/users/affiliate-status-desc"); ?></span>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/users/affiliate-view-without-membership"); ?></div>
                        <div class="yuzde70">
                            <input<?php echo Config::get("options/affiliate/view-without-membership") ? ' checked' : ''; ?> type="checkbox" name="view-without-membership" value="1" id="affiliate-view-without-membership" class="sitemio-checkbox">
                            <label for="affiliate-view-without-membership" class="sitemio-checkbox-label"></label>
                            <span class="kinfo"><?php echo __("admin/users/affiliate-view-without-membership-desc"); ?></span>
                        </div>
                    </div>


                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/users/affiliate-show-p-commission-rates"); ?></div>
                        <div class="yuzde70">
                            <input<?php echo Config::get("options/affiliate/show-p-commission-rates") ? ' checked' : ''; ?> type="checkbox" name="show-p-commission-rates" value="1" id="affiliate-show-p-commission-rates" class="sitemio-checkbox">
                            <label for="affiliate-show-p-commission-rates" class="sitemio-checkbox-label"></label>
                            <span class="kinfo"><?php echo __("admin/users/affiliate-show-p-commission-rates-desc"); ?></span>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/users/affiliate-min-payment-amount"); ?></div>
                        <div class="yuzde70">
                    <span class="infochar">
                        <?php echo $currency_s['symbol'] ? $currency_s['symbol'] : $currency['code']; ?>
                    </span>
                            <input type="text" name="min-payment-amount" value="<?php echo $affiliate_min_p_a ? Money::formatter($affiliate_min_p_a,$currency['id']) : ''; ?>" placeholder="0.00" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57' class="yuzde10">
                            <span class="kinfo"><?php echo __("admin/users/affiliate-min-payment-amount-desc"); ?></span>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/users/affiliate-commission-period"); ?></div>
                        <div class="yuzde70">
                            <input<?php echo Config::get("options/affiliate/commission-period") == 'lifetime' ? ' checked' : ''; ?> type="radio" name="commission-period" value="lifetime" class="radio-custom" id="commission-period-lifetime">
                            <label  style="margin-right: 10px;" class="radio-custom-label" for="commission-period-lifetime"><?php echo __("admin/users/affiliate-commission-period-lifetime"); ?></label>

                            <input<?php echo Config::get("options/affiliate/commission-period") == 'onetime' ? ' checked' : ''; ?> type="radio" name="commission-period" value="onetime" class="radio-custom" id="commission-period-onetime">
                            <label class="radio-custom-label" for="commission-period-onetime"><?php echo __("admin/users/affiliate-commission-period-onetime"); ?></label>

                            <div class="clear"></div>
                            <span class="kinfo"><?php echo __("admin/users/affiliate-commission-period-desc"); ?></span>
                        </div>
                    </div>


                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/users/affiliate-rate"); ?></div>
                        <div class="yuzde70">
                    <span class="infochar">
                        %
                    </span>
                            <input type="text" name="rate" value="<?php echo Config::get("options/affiliate/rate"); ?>" placeholder="1" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57' class="yuzde10">
                            <span class="kinfo"><?php echo __("admin/users/affiliate-rate-desc"); ?></span>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/users/affiliate-commission-delay"); ?></div>
                        <div class="yuzde70">
                            <input type="text" name="commission-delay" value="<?php echo Config::get("options/affiliate/commission-delay"); ?>" placeholder="" onkeypress='return event.charCode>= 48 &&event.charCode<= 57' class="yuzde10">
                            <span class="kinfo"><?php echo __("admin/users/affiliate-commission-delay-desc"); ?></span>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/users/affiliate-cookie-duration"); ?></div>
                        <div class="yuzde70">
                            <input type="text" name="cookie-duration" value="<?php echo Config::get("options/affiliate/cookie-duration"); ?>" placeholder="" onkeypress='return event.charCode>= 48 &&event.charCode<= 57' class="yuzde10">
                            <span class="kinfo"><?php echo __("admin/users/affiliate-cookie-duration-desc"); ?></span>
                        </div>
                    </div>


                    <div class="change-lang-buttons" data-type="lcon">
                        <?php
                            foreach($lang_list AS $row){
                                ?>
                                <a class="lbtn"<?php echo $local_l == $row["key"] ? ' id="lang-active"' : ''; ?> href="javascript:void 0;" data-key="<?php echo $row["key"]; ?>"><?php echo strtoupper($row["key"]); ?></a>
                                <?php
                            }
                        ?>
                    </div>
                    <div class="clear"></div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/users/affiliate-payment-gateways"); ?>
                            <div class="clear"></div>
                            <span class="kinfo"><?php echo __("admin/users/affiliate-payment-gateways-desc"); ?></span>
                        </div>
                        <div class="yuzde70">
                            <input type="hidden" id="gateways-lid" name="gateways-lid" value="<?php echo $gateways_lid; ?>">
                            <ul id="wrap_payment_gateways" style="padding:0px;">
                                <?php
                                    if($gateways)
                                    {
                                        foreach((array) $gateways AS $k => $gateway)
                                        {
                                            ?>
                                            <li>
                                                <?php
                                                    foreach($lang_list AS $lang)
                                                    {
                                                        $l_k = $lang['key'];
                                                        ?>
                                                        <input type="text" name="payment-gateways[<?php echo $k; ?>][<?php echo $l_k; ?>]" value="<?php echo isset($gateway[$l_k]) ? $gateway[$l_k] : ''; ?>" class="yuzde50 lcon-values lcon-value-<?php echo $l_k; ?>" style="<?php echo $l_k == $local_l ? '' : 'display:none;'; ?>">
                                                        <?php
                                                    }
                                                ?>
                                                <div class="yuzde10">
                                                    <a class="sbtn red" onclick="$(this).parent().parent().remove();"><i class="fa fa-times"></i></a>
                                                </div>
                                            </li>
                                            <?php
                                        }
                                    }
                                ?>
                            </ul>
                            <a class="sbtn" onclick="add_payment_gateway();"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/users/affiliate-redirect"); ?></div>
                        <div class="yuzde70">
                            <input type="text" name="redirect" value="<?php echo $redirect_url; ?>" placeholder="ex: https://www.example.com/">
                            <div class="clear"></div>
                            <span class="kinfo"><?php echo __("admin/users/affiliate-redirect-desc"); ?></span>
                        </div>
                    </div>

                    <div class="formcon">
                        <strong><?php echo __("admin/users/affiliate-content"); ?></strong>
                        <div class="clear"></div>
                        <span class="kinfo"><?php echo __("admin/users/affiliate-content-desc"); ?></span>
                        <div class="clear" style="margin-bottom:10px;"></div>
                        <?php
                            foreach($lang_list AS $lang){
                                $l_k = $lang['key'];
                                ?>
                                <div class="lcon-values lcon-value-<?php echo $l_k; ?>" style="width: 100%;<?php echo $l_k == $local_l ? 'display:inline-block;' : 'display:none;'; ?>">
                                    <textarea class="tinymce-1" name="content[<?php echo $l_k; ?>]"><?php echo Config::get("options/affiliate/content/".$l_k); ?></textarea>
                                </div>
                                <?php
                            }
                        ?>
                    </div>


                    <div class="clear"></div>

                    <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                        <a class="yesilbtn gonderbtn" id="AffiliateSettingsForm_submit" href="javascript:void(0);"><?php echo ___("needs/button-update"); ?></a>
                    </div>
                    <div class="clear"></div>


                </form>

            </div>
            <div class="clear"></div>

        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>