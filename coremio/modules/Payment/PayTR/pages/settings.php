<?php
    if(!defined("CORE_FOLDER")) die();
    $LANG       = $module->lang;
    $CONFIG     = $module->config;
    $notify_url = Controllers::$init->CRLink("payment",['PayTR',$module->get_auth_token(),'callback'],"none");
    $installment_rates = $module->installment_rates();
    $cards      = $module->installment_cards; 
?>

<div id="DirectAPI_Warning" style="display: none;" data-izimodal-title="PAYTR Direkt API">
<div class="padding20" style="text-align:center;padding: 45px 55px;">
<i class="fa fa-exclamation-circle" aria-hidden="true" style="
    font-size: 70px;
    /* color: #F44336; */
"></i>
    <h3 style="
    margin: 20px 0px;
    font-size: 26px;
"><strong>Önemli Uyarı!</strong></h3>
    <h5 style="
    font-size: 16px;
"><strong>Direkt API kullanımı için PAYTR mağazınızın Direkt API ve 2D yetkisi etkin durumda olmalıdır. </strong>
        <br><br>Direkt API ve 2D yetkisinin etkinleştirilmesi için PAYTR ödeme kuruluşu ile iletişime geçmelisiniz. Aksi taktirde ödeme işlemlerinde sistematik sorunlar meydana gelecektir. Mağazanız için yetkilendirme sağlanamıyorsa "Iframe" ödeme türünü kullanabilirsiniz.</h5>
    
    <a href="javascript:void 0;" onclick="close_modal('DirectAPI_Warning');" class="gonderbtn yesilbtn" style="
    width: 210px;
    margin-top: 33px;
">Tamam</a>

    </div>
</div>

<form action="<?php echo Controllers::$init->getData("links")["controller"]; ?>" method="post" id="PayTR">
    <input type="hidden" name="operation" value="module_controller">
    <input type="hidden" name="module" value="PayTR">
    <input type="hidden" name="controller" value="settings">


    <script type="text/javascript">
        function PayTR_open_tab(elem, tabName){
            var owner = "PayTR_tab";
            $("#"+owner+" .modules-tabs-content").css("display","none");
            $("#"+owner+" .modules-tabs .modules-tab-item").removeClass("active");
            $("#"+owner+"-"+tabName).css("display","block");
            $("#"+owner+" .modules-tabs .modules-tab-item[data-tab='"+tabName+"']").addClass("active");
        }
    </script>

    <div id="PayTR_tab">
        <ul class="modules-tabs">
            <li><a href="javascript:PayTR_open_tab(this,'settings');" data-tab="settings" class="modules-tab-item active"><?php echo $LANG["tab-settings"]; ?></a></li>
            <li style="<?php echo !(isset($CONFIG["settings"]["payment_type"]) && $CONFIG["settings"]["payment_type"] == "direct") ? 'display:none;' : ''; ?>" id="tab_installment"><a href="javascript:PayTR_open_tab(this,'installment');" data-tab="installment" class="modules-tab-item"><?php echo $LANG["tab-installment"]; ?></a></li>
        </ul>

        <div id="PayTR_tab-settings" class="modules-tabs-content" style="display: block">


            <div class="blue-info" style="margin-bottom:20px;">
                <div class="padding15">
                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                    <p><?php echo $LANG["description"]; ?></p>
                </div>
            </div>

            <div class="formcon">
                <div class="yuzde30">Ödeme Türü</div>
                <div class="yuzde70">
                    <input<?php echo !isset($CONFIG["settings"]["payment_type"]) || $CONFIG["settings"]["payment_type"] == "iframe" ? ' checked' : ''; ?> type="radio" name="payment_type" value="iframe" class="radio-custom" id="payment_type_iframe">
                    <label class="radio-custom-label" for="payment_type_iframe" style="margin-right: 5px;">Iframe</label>

                    <input<?php echo isset($CONFIG["settings"]["payment_type"]) && $CONFIG["settings"]["payment_type"] == "direct" ? ' checked' : ''; ?> type="radio" name="payment_type" value="direct" class="radio-custom" id="payment_type_direct">
                    <label class="radio-custom-label" for="payment_type_direct">Direkt</label>

                    <script type="text/javascript">
                        $(document).ready(function(){
                            $("input[name=payment_type]").change(function(){
                                if($(this).val() === "direct")
                                {
                                    $(".type_direct").css('display','block');
                                    $("#tab_installment").css("display","block");

                                    open_modal('DirectAPI_Warning');
                                }
                                else
                                {
                                    $("#tab_installment").css("display","none");
                                    $(".type_direct").css('display','none');
                                }
                            });
                        });
                    </script>
                </div>
            </div>

            <div class="formcon">
                <div class="yuzde30">Merchant ID</div>
                <div class="yuzde70">
                    <input type="text" name="merchant_id" value="<?php echo $CONFIG["settings"]["merchant_id"]; ?>">
                    <span class="kinfo"><?php echo $LANG["merchant-id-desc"]; ?></span>
                </div>
            </div>

            <div class="formcon">
                <div class="yuzde30">Merchant Key</div>
                <div class="yuzde70">
                    <input type="text" name="merchant_key" value="<?php echo $CONFIG["settings"]["merchant_key"]; ?>">
                    <span class="kinfo"><?php echo $LANG["merchant-key-desc"]; ?></span>
                </div>
            </div>

            <div class="formcon">
                <div class="yuzde30">Merchant Salt</div>
                <div class="yuzde70">
                    <input type="text" name="merchant_salt" value="<?php echo $CONFIG["settings"]["merchant_salt"]; ?>">
                    <span class="kinfo"><?php echo $LANG["merchant-salt-desc"]; ?></span>
                </div>
            </div>

            <div class="formcon type_direct" style="<?php echo isset($CONFIG["settings"]["payment_type"]) && $CONFIG["settings"]["payment_type"] != "direct" ? 'display:none;' : ''; ?>">
                <div class="yuzde30"><?php echo $LANG["card-tx29"]; ?></div>
                <div class="yuzde70">
                    <input<?php echo isset($CONFIG["settings"]["save_card"]) && $CONFIG["settings"]["save_card"] ? ' checked' : ''; ?> type="checkbox" name="save_card" class="sitemio-checkbox" value="1" id="paytr_save_card" onchange="if(!$(this).prop('checked')) $('#paytr_auto_pay').prop('checked',false);">
                    <label for="paytr_save_card" class="sitemio-checkbox-label"></label>
                    <span class="kinfo"><?php echo $LANG["card-tx30"]; ?></span>
                </div>
            </div>

            <div class="formcon type_direct" style="<?php echo isset($CONFIG["settings"]["payment_type"]) && $CONFIG["settings"]["payment_type"] != "direct" ? 'display:none;' : ''; ?>">
                <div class="yuzde30"><?php echo $LANG["card-tx31"]; ?></div>
                <div class="yuzde70">
                    <input<?php echo isset($CONFIG["settings"]["auto_pay"]) && $CONFIG["settings"]["auto_pay"] ? ' checked' : ''; ?> type="checkbox" name="auto_pay" class="sitemio-checkbox" value="1" id="paytr_auto_pay" onchange="if($(this).prop('checked')) $('#paytr_save_card').prop('checked',true);">
                    <label for="paytr_auto_pay" class="sitemio-checkbox-label"></label>
                    <span class="kinfo"><?php echo $LANG["card-tx32"]; ?></span>
                    <div class="clear"></div>
                    <span class="kinfo"><?php echo $LANG["card-tx33"]; ?></span>
                </div>
            </div>

            <div class="formcon">
                <div class="yuzde30"><?php echo $LANG["installment"]; ?></div>
                <div class="yuzde70">
                    <input<?php echo $CONFIG["settings"]["no_installment"] ? '' : ' checked'; ?> type="checkbox" name="installment" class="sitemio-checkbox" value="1" id="paytr_installment" onchange="if($(this).prop('checked')) $('#max_installment_content').slideDown(); else $('#max_installment_content').slideUp();">
                    <label for="paytr_installment" class="sitemio-checkbox-label"></label>
                    <span class="kinfo"><?php echo $LANG["installment-desc"]; ?></span>
                    <div class="clear"></div>
                    <div id="max_installment_content" style="<?php echo $CONFIG["settings"]["no_installment"] ? 'display:none;' : ''; ?>">
                        <select class="yuzde10" name="max_installment">
                            <?php
                                for($i=1;$i<=12;$i++){
                                    $checked = $i == $CONFIG["settings"]["max_installment"] || ($i == 9 && $CONFIG["settings"]["max_installment"] == 0);
                                    ?>
                                    <option<?php echo $checked ? ' selected' : ''; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php
                                }
                            ?>
                        </select>
                        <span class="kinfo"><?php echo $LANG["max-installment-desc"]; ?></span>
                    </div>

                </div>
            </div>


            <div class="formcon">
                <div class="yuzde30"><?php echo $LANG["commission-rate"]; ?></div>
                <div class="yuzde70">
                    <input type="text" name="commission_rate" value="<?php echo $CONFIG["settings"]["commission_rate"]; ?>" style="width: 80px;">
                    <span class="kinfo"><?php echo $LANG["commission-rate-desc"]; ?></span>
                </div>
            </div>

            <div class="formcon">
                <div class="yuzde30"><?php echo $LANG["test-mode"]; ?></div>
                <div class="yuzde70">
                    <input<?php echo $CONFIG["settings"]["test_mode"] ? ' checked' : ''; ?> type="checkbox" name="test_mode" class="sitemio-checkbox" value="1" id="paytr_test_mode">
                    <label for="paytr_test_mode" class="sitemio-checkbox-label"></label>
                    <span class="kinfo"><?php echo $LANG["test-mode-desc"]; ?></span>
                </div>
            </div>

            <div class="formcon">
                <div class="yuzde30"><?php echo $LANG["debug-mode"]; ?></div>
                <div class="yuzde70">
                    <input<?php echo $CONFIG["settings"]["debug_on"] ? ' checked' : ''; ?> type="checkbox" name="debug_on" class="sitemio-checkbox" value="1" id="paytr_debug_on">
                    <label for="paytr_debug_on" class="sitemio-checkbox-label"></label>
                    <span class="kinfo"><?php echo $LANG["debug-mode-desc"]; ?></span>
                </div>
            </div>

            <div class="formcon">
                <div class="yuzde30" style=" color: #f44336;"><?php echo $LANG["notify-url"]; ?></div>
                <div class="yuzde70">
                    <span class="selectalltext" style="font-size:13px;font-weight:600;    color: #f44336;"><?php echo $notify_url; ?></span>
                    <div class="clear"></div>
                    <span class="kinfo"><?php echo $LANG["notify-url-desc"]; ?></span>
                </div>
            </div>



        </div>

        <div id="PayTR_tab-installment" class="modules-tabs-content" style="display: none">

            <div class="blue-info" style="margin-bottom:20px;">
                <div class="padding15">
                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                    <p><?php echo $LANG["card-tx34"]; ?> </p>
                    <ul>
                        <li>- <?php echo $LANG["card-tx35"]; ?> </li>
                        <li>- <?php echo $LANG["card-tx36"]; ?> </li>
                    </ul>

                </div>
            </div>

            <div class="pay-gat-installments">

                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td colspan="9" align="center">
                            <h5 style="display: inline-block;"><strong><?php echo $LANG["card-tx37"]; ?></strong> (%)</h5>
                            <a data-tooltip="API Üzerinden Otomatik Güncelle" href="javascript:void 0;" id="PAYTR_updateInstallmentRates_btn" class="lbtn" style="float:right;"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">&nbsp;</td>
                        <td align="center"><img height="20" src="<?php echo APP_URI; ?>/resources/assets/images/creditcardlogos/world-yapikredi.png"></td>
                        <td align="center"><img height="20" src="<?php echo APP_URI; ?>/resources/assets/images/creditcardlogos/axess-akbank.png"></td>
                        <td align="center"><img height="20" src="<?php echo APP_URI; ?>/resources/assets/images/creditcardlogos/maximum-isbankasi.png"></td>
                        <td align="center"><img height="20" src="<?php echo APP_URI; ?>/resources/assets/images/creditcardlogos/cardfinans-finansbank.png"></td>
                        <td align="center"><img height="20" src="<?php echo APP_URI; ?>/resources/assets/images/creditcardlogos/paraf-halkbank.png"></td>
                        <td align="center"><img height="20" src="<?php echo APP_URI; ?>/resources/assets/images/creditcardlogos/advantage-HSBC.png"></td>

                        <td align="center"><img height="20" src="<?php echo APP_URI; ?>/resources/assets/images/creditcardlogos/bankkart-ziraat.png"></td>

                        <td align="center"><img height="20" src="<?php echo APP_URI; ?>/resources/assets/images/creditcardlogos/bonus-garanti.png"></td>

                    </tr>


                    <?php
                        for($i=2;$i<=12;$i++)
                        {
                            ?>
                            <tr>
                                <td align="center"><?php echo $i; ?> Taksit</td>
                                <?php
                                    foreach($cards AS $card)
                                    {
                                        $rate = isset($installment_rates[$card]["taksit_".$i]) ? $installment_rates[$card]["taksit_".$i] : '';
                                        if(strlen($rate) >= 1) $rate = round($rate,2);
                                        ?>
                                        <td align="center"><input name="installment_rates[<?php echo $card; ?>][taksit_<?php echo $i; ?>]" type="text" value="<?php echo $rate; ?>"></td>
                                        <?php
                                    }
                                ?>
                            </tr>
                            <?php
                        }
                    ?>
                </table>



            </div>

        </div>

    </div>


    <div style="float:right;margin-top:25px;" class="guncellebtn yuzde30"><a id="PayTR_submit" href="javascript:void(0);" class="yesilbtn gonderbtn"><?php echo $LANG["save-button"]; ?></a></div>

</form>


<script type="text/javascript">
    $(document).ready(function(){

        $("#PayTR_submit").click(function(){
            MioAjaxElement($(this),{
                waiting_text:waiting_text,
                progress_text:progress_text,
                result:"PayTR_handler",
            });
        });

        $("#PAYTR_updateInstallmentRates_btn").click(function(){
            let btn = $(this);

            let request = MioAjax({
                action  : "<?php echo Controllers::$init->getData("links")["controller"]; ?>",
                method  : "POST",
                data    :
                {
                    operation   : "module_controller",
                    module      : "PayTR",
                    controller  : "update_installment_rates",
                },
            },true,true);

            request.done(function(result)
            {
                if(result != ''){
                    var solve = getJson(result);
                    if(solve !== false){
                        if(solve.status === "error")
                        {
                            alert_error(solve.message,{timer:3000});
                        }
                        else if(solve.status === "successful")
                        {
                            alert_success("Başarıyla Güncellendi",{timer:3000});
                            setTimeout(function(){
                                window.location.href = location.href;
                            },3000);
                        }
                    }else
                        console.log(result);
                }
            });
        });

    });

    function PayTR_handler(result){
        if(result != ''){
            var solve = getJson(result);
            if(solve !== false){
                if(solve.status == "error"){
                    if(solve.for != undefined && solve.for != ''){
                        $("#PayTR "+solve.for).focus();
                        $("#PayTR "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                        $("#PayTR "+solve.for).change(function(){
                            $(this).removeAttr("style");
                        });
                    }
                    if(solve.message != undefined && solve.message != '')
                        alert_error(solve.message,{timer:5000});
                }else if(solve.status == "successful"){
                    alert_success(solve.message,{timer:2500});
                }
            }else
                console.log(result);
        }
    }
</script>