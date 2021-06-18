<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    $wide_content = true;
    include $tpath."common-needs.php";
    $hoptions = ["datatables","jquery-ui"];
?>
<style type="text/css"></style>
<script type="text/javascript">
    function password_check(id){
        var value = $("#"+id).val();
        var check = checkStrength(value);
        $("#strength_"+id+" div").css("display","none");
        $("#strength_"+id+" #"+check).css("display","block");
    }

    function openTab(evt, tabName) {
        var gtab,dtab,link,tab;
        $(".tabcontent").css("display","none");
        $(".tablinks").removeClass("active");
        $("#"+tabName).css("display","block");
        $(evt).addClass("active");
        gtab     = gGET("tab");
        dtab     = $(evt).attr("data-tab");
        if((gtab == '' || gtab == null || gtab == undefined) && dtab == 1){
            link    = window.location.href;
        }else{
            link     = sGET("tab",dtab);
        }
        window.history.pushState("object or string", $("title").html(),link);
    }

    $(document).ready(function(){
        var tab = gGET("tab");
        if(tab == '' || tab == undefined){
            $(".tablinks:eq(0)").click();
        }else{
            $(".tablinks[data-tab='"+tab+"']").click();
        }

        var accordionx = gGET("accordion");
        if(accordionx == null){
            accordionx = false;
        }else
            accordionx -=1;

        $( "#accordion" ).accordion({
            heightStyle: "content",
            active:accordionx,
            collapsible: true,
        });
    });
</script>

<div class="mpanelrightcon">

    <div class="mpaneltitle">
        <div class="sayfayolu"><?php include $tpath."inc".DS."panel-breadcrumb.php"; ?></div>
        <h4><strong><i class="fa fa-globe" aria-hidden="true"></i> <?php echo $proanse["name"]; ?> (<?php echo __("website/account_products/service-groups/domain"); ?>)</strong></h4>
    </div>


    <ul class="tab">
        <li><a href="javascript:void(0)" class="tablinks" onclick="openTab(this, 'ozet')" data-tab="1"><i class="fa fa-info" aria-hidden="true"></i> <?php echo __("website/account_products/detail"); ?></a></li>
        <?php if($proanse["status"] == "active"): ?>

            <?php if(isset($options["whois_manage"]) && $options["whois_manage"]): ?>
                <li><a href="javascript:void(0)" class="tablinks" onclick="openTab(this, 'whoisbilgileri')" data-tab="whois"><i class="fa fa-user" aria-hidden="true"></i> <?php echo __("website/account_products/whois-manager"); ?></a></li>
            <?php endif; ?>

            <?php if(isset($options["dns_manage"]) && $options["dns_manage"]): ?>
                <li><a href="javascript:void(0)" class="tablinks" onclick="openTab(this, 'dnsbilgileri')" data-tab="dns"><i class="fa fa-globe" aria-hidden="true"></i> <?php echo __("website/account_products/dns-manager"); ?></a></li>
            <?php endif; ?>

            <li><a href="javascript:void(0)" class="tablinks" onclick="openTab(this, 'guvenlik')" data-tab="security"><i class="fa fa-shield" aria-hidden="true"></i> <?php echo __("website/account_products/security-manager"); ?></a></li>

            <?php if($proanse["status"] == "active" && $ctoc_service_transfer): ?>
                <li><a href="javascript:void(0)" class="tablinks" onclick="openTab(this, 'transfer-service')" data-tab="transfer-service"><i class="fa fa-exchange" aria-hidden="true"></i> <?php echo __("website/account_products/transfer-service"); ?></a></li>
            <?php endif; ?>

            <li><a href="javascript:void(0)" class="tablinks" onclick="openTab(this, 'transfer')" data-tab="transfer"><i class="fa fa-random" aria-hidden="true"></i> <?php echo __("website/account_products/transfer-manager"); ?></a></li>


        <?php endif; ?>

        <div class="orderidno"><span><?php echo __("website/account_products/table-ordernum"); ?></span><strong>#<?php echo $proanse["id"]; ?></strong></div>

    </ul>


    <div id="ozet" class="tabcontent">

        <div class="hizmetblok">
            <div class="service-first-block" style="border:none;min-height:auto; padding:30px 0px;">

                 <div id="order_image" style="    position: relative;display: inline-block;margin-right: 32px;">
                 		<img style="width:130px;" src="<?php echo $tadress."images/domain-order-cover.jpg"; ?>" width="auto" height="auto">
                 </div>

                <div style="display: inline-block;vertical-align: top;margin-top: 10px;   position:relative;">

                <h4 style="font-size: 24px;"><strong><?php echo $options["domain"]; ?></strong></h4>
                <?php if($proanse["status"] == "active" || $proanse["status"] == "suspended" || $proanse["status"] == "inprocess"){ ?>
                    <h4 style="margin-bottom:10px;"><?php echo __("website/account_products/remaining-day"); ?>: <strong><?php echo $remaining_day; ?></strong></h4>
                <?php } ?>
                <?php

                ?>

                    <?php if(isset($options["whois_privacy"]) && $options["whois_privacy"]): ?>

                        <div class="service-status-con" style="display:block;" id="server_status_other"><span class="statusother"><i class="fa fa-shield" aria-hidden="true" style="margin-right: 5px;"></i> <?php echo __("website/account_products/whois-hidden"); ?></span>
                        </div>
                    <?php endif; ?>

                </div>

            </div>
        </div>


        <div class="hizmetblok" style="border:none;min-height:auto;padding-bottom: 25px;">
            <div id="order-service-detail-btns">
                <?php
                    if((!isset($subscription) || $subscription["status"] == "cancelled"))
                    {
                        if($proanse["status"] == "active" || $proanse["status"] == "suspended"){
                            ?>
                            <div id="renewal_list" style="display:none;">
                                <select id="selection_renewal">
                                    <option value=""><?php echo __("website/account_products/renewal-list-option"); ?></option>
                                    <?php
                                        if(isset($renewal_list) && $renewal_list){
                                            foreach($renewal_list AS $year=>$cash){
                                                ?>
                                                <option value="<?php echo $year; ?>">(<?php echo $year." ".__("website/account_products/registration-year");?>) <?php echo $cash; ?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                                <script type="text/javascript">
                                    $(document).ready(function(){
                                        $("#selection_renewal").change(function(){
                                            var selection = $(this).val();
                                            if(selection != ''){
                                                var result = MioAjax({
                                                    action: "<?php echo $links["controller"]; ?>",
                                                    method: "POST",
                                                    data:{operation:"domain_renewal",period:selection}
                                                },true);

                                                if(result){
                                                    var solve = getJson(result);
                                                    if(solve){
                                                        if(solve.status == "successful"){
                                                            window.location.href = solve.redirect;
                                                        }
                                                    }
                                                }
                                            }
                                        });
                                    });
                                </script>
                            </div>
                            <a href="javascript:$('#renewal_list').slideToggle(400);void 0;" class="metalbtn gonderbtn"><i class="fa fa-refresh"></i> <?php echo __("website/account_products/renewal-now-button"); ?></a>
                            <?php
                        }
                        else
                        {
                            ?>
                            <a class="graybtn gonderbtn" style="cursor:no-drop;"><?php echo __("website/account_products/renewal-now-button"); ?></a>
                            <?php
                        }
                    }
                ?>

                 <a href="javascript:void(0)" onclick="openTab(this, 'dnsbilgileri')" data-tab="dns" class="turuncbtn gonderbtn"><i class="fa fa-globe" aria-hidden="true"></i> <?php echo __("website/account_products/dns-manager"); ?></a>

                 <a href="javascript:void(0)" onclick="openTab(this, 'whoisbilgileri')" data-tab="whois" class="mavibtn gonderbtn"><i class="fa fa-user" aria-hidden="true"></i> <?php echo __("website/account_products/whois-manager"); ?></a>

                 
                </div>
              </div>

        <div class="hizmetblok">
            <table width="100%" border="0">
                <tr>
                    <td colspan="2" bgcolor="#ebebeb">
                        <strong style="float: left;"><?php echo __("website/account_products/general-info"); ?></strong>
                        <?php
                            if(isset($invoice) && $invoice)
                            {
                                ?>
                                <span style="float:right;"><?php echo __("website/account_invoices/invoice-num"); ?> <a href="<?php echo $invoice["detail_link"]; ?>" target="_blank"><strong><?php echo $invoice["number"] ? $invoice["number"] : "#".$invoice["id"]; ?></strong></a></span>
                                <?php
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><strong><?php echo __("website/account_products/service-group"); ?></strong></td>
                    <td><?php echo __("website/account_products/service-groups/domain"); ?></td>
                </tr>

                <tr>
                    <td><strong><?php echo __("website/account_products/service-name"); ?></strong></td>
                    <td><?php echo $proanse["name"]; ?></td>
                </tr>
                <tr>
                    <td><strong><?php echo __("website/account_products/service-status"); ?></strong></td>
                    <td><?php echo $product_situations[$proanse["status"]]; ?></td>
                </tr>

                <?php

                    if(isset($subscription) && $subscription["status"] != "cancelled")
                    {
                        ?>
                        <tr>
                            <td><strong><?php echo __("website/account_products/auto-pay-1"); ?></strong></td>
                            <td>
                                <div id="subscription_status">
                                    <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
                                </div>
                                <script type="text/javascript">
                                    $(document).ready(function(){
                                        $.get("<?php echo $links["controller"]; ?>?operation=subscription_detail",function(data){
                                            $("#subscription_status").html(data);
                                        });
                                    });
                                </script>
                            </td>
                        </tr>
                        <?php
                    }

                    if(!isset($subscription) || $subscription["status"] == "cancelled")
                    {
                        $c_s_m = Config::get("modules/card-storage-module");
                        if($c_s_m && $c_s_m != "none")
                        {
                            $o_a_p = isset($proanse["auto_pay"]) ? $proanse["auto_pay"]  : 0;
                            ?>
                            <tr>
                                <td><strong><?php echo __("website/account_products/auto-pay-1"); ?></strong></td>
                                <td>
                                    <input onchange="change_auto_pay_status(this);" type="checkbox" class="sitemio-checkbox" id="auto_pay" value="1"<?php echo $o_a_p ? ' checked' : ''; ?>>
                                    <label class="sitemio-checkbox-label" for="auto_pay"></label>

                                    <script type="text/javascript">
                                        function change_auto_pay_status(el){
                                            let status = $(el).prop('checked') ? 1 : 0;

                                            if(status === 1 && '<?php echo isset($stored_cards) && $stored_cards ? "true" : "false"; ?>' === "false")
                                            {
                                                alert_error("<?php echo __("website/account_products/auto-pay-3"); ?>",{timer:5000});
                                                $(el).prop('checked',false);
                                                return false;
                                            }

                                            MioAjax({
                                                action:"<?php echo $links["controller"]; ?>",
                                                method:"POST",
                                                data:{operation:"set_auto_pay_status",status:status}
                                            },true,true);
                                            alert_success("<?php echo __("website/account_products/auto-pay-4"); ?>",{timer:3000});
                                        }
                                    </script>

                                </td>
                            </tr>
                            <?php
                        }
                    }
                ?>

                <tr>
                    <td><strong><?php echo __("website/account_products/payment-period"); ?></strong></td>
                    <td><?php echo View::period($proanse["period_time"],$proanse["period"]); ?></td>
                </tr>
                <tr align="center" class="tutartd">
                    <td colspan="2"><strong><?php echo __("website/account_products/register-amount"); ?> : <?php echo $amount; ?></strong></td>
                </tr>
            </table>
        </div>


        <div class="hizmetblok">
            <table width="100%" border="0">
                <tr>
                    <td colspan="2" bgcolor="#ebebeb" ><strong><?php echo __("website/account_products/payment-details"); ?></strong></td>
                </tr>

                <tr>
                    <td><strong><?php echo __("website/account_products/registration-date"); ?></strong></td>
                    <td><?php echo DateManager::format(Config::get("options/date-format"),$proanse["cdate"]); ?></td>
                </tr>

                <?php if(substr($proanse["duedate"],0,4) != "1881" && substr($proanse["duedate"],0,4) != "1970"): ?>
                    <tr>
                        <td><strong><?php echo __("website/account_products/due-date"); ?></strong></td>
                        <td><?php echo DateManager::format(Config::get("options/date-format"),$proanse["duedate"]); ?></td>
                    </tr>
                <?php endif; ?>

                <?php if(substr($proanse["renewaldate"],0,4) != "1881" && substr($proanse["renewaldate"],0,4) != "1970"): ?>
                    <tr>
                        <td><strong><?php echo __("website/account_products/last-paid-date"); ?></strong></td>
                        <td><?php echo DateManager::format(Config::get("options/date-format"),$proanse["renewaldate"]); ?></td>
                    </tr>
                <?php endif; ?>

                <?php if($proanse["period_time"]): ?>
                    <tr>
                        <td><strong><?php echo __("website/account_products/registration-period"); ?></strong></td>
                        <td><?php echo $proanse["period_time"]." ".__("website/account_products/registration-year"); ?></td>
                    </tr>
                <?php endif; ?>

                <tr align="center" class="tutartd">
                    <td colspan="2"><strong><?php echo __("website/account_products/renewal-amount"); ?> : <?php echo $renewal_amount; ?></strong></td>
                </tr>
                </tr>

            </table>

        </div>
    </div>

    <?php if($proanse["status"] == "active" && isset($options["whois_manage"]) && $options["whois_manage"]){ ?>
        <div id="whoisbilgileri" class="tabcontent">
            <div class="tabcontentcon">
                <div class="green-info" style="margin-bottom:20px;">
                    <div class="padding15">
                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                        <p><?php echo __("admin/orders/update-whois-info-desc"); ?></p>
                    </div>
                </div>
                <span><strong><?php echo __("website/account_products/current-whois"); ?></strong></span>
                <div class="clear"></div>
                <form action="<?php echo $links["controller"]; ?>" method="post" id="ModifyWhois">
                    <input type="hidden" name="operation" value="domain_modify_whois">
                    <input name="Name" value="<?php echo $whois["Name"]; ?>" type="text" class="yuzde33" placeholder="<?php echo __("website/account_products/whois-full_name"); ?>">
                    <input name="Company" value="<?php echo $whois["Company"]; ?>" type="text" class="yuzde33" placeholder="<?php echo __("website/account_products/whois-company_name"); ?>">
                    <input name="EMail" value="<?php echo $whois["EMail"]; ?>" type="text" class="yuzde33" placeholder="<?php echo __("website/account_products/whois-email"); ?>">
                    <input name="PhoneCountryCode" value="<?php echo $whois["PhoneCountryCode"]; ?>" type="text" class="yuzde33" placeholder="<?php echo __("website/account_products/whois-phoneCountryCode"); ?>">
                    <input name="Phone" type="text" value="<?php echo $whois["Phone"]; ?>" class="yuzde33" placeholder="<?php echo __("website/account_products/whois-phone"); ?>">
                    <input name="FaxCountryCode" type="text" value="<?php echo $whois["FaxCountryCode"]; ?>" class="yuzde33" placeholder="<?php echo __("website/account_products/whois-faxCountryCode"); ?>">
                    <input name="Fax" type="text" value="<?php echo $whois["Fax"]; ?>" class="yuzde33" placeholder="<?php echo __("website/account_products/whois-fax"); ?>">
                    <input name="City" type="text" value="<?php echo $whois["City"]; ?>" class="yuzde33" placeholder="<?php echo __("website/account_products/whois-city"); ?>">
                    <input name="State" type="text" value="<?php echo $whois["State"]; ?>" class="yuzde33" placeholder="<?php echo __("website/account_products/whois-state"); ?>">
                    <input name="Address" type="text" value="<?php echo $whois["Address"]; ?>" class="yuzde33" placeholder="<?php echo __("website/account_products/whois-address"); ?>">
                    <input name="Country" type="text" value="<?php echo $whois["Country"]; ?>" class="yuzde33" placeholder="<?php echo __("website/account_products/whois-CountryCode"); ?>">
                    <input name="ZipCode" type="text" value="<?php echo $whois["ZipCode"]; ?>" class="yuzde33" placeholder="<?php echo __("website/account_products/whois-zipcode"); ?>">

                    <a href="javascript:void(0);" class="yesilbtn gonderbtn mio-ajax-submit" mio-ajax-options='{"result":"ModifyWhois_submit","waiting_text":"<?php echo addslashes(__("website/others/button1-pending")); ?>"}'><?php echo __("website/account_products/whois-modify-button"); ?></a>

                </form>
                <script type="text/javascript">
                    function ModifyWhois_submit(result) {
                        if(result != ''){
                            var solve = getJson(result);
                            if(solve !== false){
                                if(solve.status == "error"){
                                    if(solve.for != undefined && solve.for != ''){
                                        $("#ModifyWhois "+solve.for).focus();
                                        $("#ModifyWhois "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                        $("#ModifyWhois "+solve.for).change(function(){
                                            $(this).removeAttr("style");
                                        });
                                    }
                                    if(solve.message != undefined && solve.message != '')
                                        alert_error(solve.message,{timer:5000});
                                }else if(solve.status == "successful"){
                                    alert_success(solve.message,{timer:4000});
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
                </script>

                <script type="text/javascript">
                    $(document).ready(function(){

                        $("#whois_privacy_button").click(function(){
                            var status = $(this).data("status");
                            var request = MioAjax({
                                button_element:this,
                                action:'<?php echo $links["controller"]; ?>',
                                data:{
                                    operation:"domain_whois_privacy",
                                    status:status,
                                },
                                method:"POST",
                                waiting_text:'<?php echo addslashes(__("website/others/button1-pending")); ?>',
                            },true,true);

                            request.done(function (result){
                                if(result != ''){
                                    var solve = getJson(result);
                                    if(solve !== false){
                                        if(solve.status == "error"){
                                            if(solve.message != undefined && solve.message != '')
                                                alert_error(solve.message,{timer:5000});
                                        }else if(solve.status == "successful"){

                                            if(solve.message != undefined && solve.message != '' && solve.message != 'go-to-basket')
                                                alert_success(solve.message,{timer:3000});

                                            if(solve.redirect != undefined && solve.redirect != ''){
                                                setTimeout(function(){
                                                    window.location.href = solve.redirect;
                                                },solve.message == "go-to-basket" ? 1 : 3000);
                                            }
                                        }
                                    }else
                                        console.log(result);
                                }
                            });
                        });

                    });
                </script>

                <?php
                    if($wprivacy){
                        ?>
                        <a href="javascript:void(0);" id="whois_privacy_button" data-status="disable" class="turuncbtn gonderbtn"><?php echo __("website/account_products/domain-whois-show"); ?></a>
                        <?php
                    }else{
                        ?>
                        <a href="javascript:void(0);" id="whois_privacy_button" data-status="enable" class="mavibtn gonderbtn"><i class="fa fa-user-secret" aria-hidden="true"></i> <?php echo __("website/account_products/domain-whois-hide"); ?></a>
                        <?php
                    }
                ?>

                <?php if(isset($wprivacy_purchase) && isset($wprivacy_price) && $wprivacy_purchase && $wprivacy_price != ''): ?>
                    <br><span style="font-size:14px;color:#777; margin-left: 15px;"><?php echo __("website/account_products/domain-whois-privacy-amount",['{price}' => $wprivacy_price]); ?></span>
                <?php endif; ?>

                <?php if(isset($wprivacy_endtime) && $wprivacy_endtime): ?>
                    <br><span class="kinfo" style="margin-left:15px;"> <?php echo __("website/account_products/domain-whois-privacy-endtime"); ?>: <strong><?php echo $wprivacy_endtime; ?></strong></span>
                <?php endif; ?>

                <br>

            </div>
        </div>
    <?php } ?>

    <?php if($proanse["status"] == "active" && isset($options["dns_manage"]) && $options["dns_manage"]){ ?>
        <div id="dnsbilgileri" class="tabcontent">
            <div class="tabcontentcon">

                <div class="green-info" style="margin-bottom:20px;">
                    <div class="padding15">
                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                        <p><?php echo __("admin/orders/domain-dns-operation-desc"); ?></p>
                    </div>
                </div>

                <div class="ModifyDns">
                    <div class="padding20">
                        <form action="<?php echo $links["controller"]; ?>" method="post" id="ModifyDns">
                            <input type="hidden" name="operation" value="domain_modify_dns">
                            <span><strong><?php echo __("website/account_products/domain-current-dns"); ?></strong></span>
                            <div class="clear"></div>
                            <input name="dns[]" value="<?php echo isset($options["ns1"]) ? $options["ns1"] : false; ?>" type="text" class="" placeholder="<?php echo __("website/account_products/domain-dns"); ?>">
                            <input name="dns[]" value="<?php echo isset($options["ns2"]) ? $options["ns2"] : false; ?>" type="text" class="" placeholder="<?php echo __("website/account_products/domain-dns"); ?>">
                            <input name="dns[]" value="<?php echo isset($options["ns3"]) ? $options["ns3"] : false; ?>" type="text" class="" placeholder="<?php echo __("website/account_products/domain-dns"); ?>">
                            <input name="dns[]" value="<?php echo isset($options["ns4"]) ? $options["ns4"] : false; ?>" type="text" class="" placeholder="<?php echo __("website/account_products/domain-dns"); ?>">

                            <a style="float:none;display:inline-block" href="javascript:void(0);" class="mavibtn gonderbtn mio-ajax-submit" mio-ajax-options='{"result":"ModifyDns_submit","waiting_text":"<?php echo addslashes(__("website/others/button1-pending")); ?>"}'><?php echo __("website/account_products/domain-dns-update"); ?></a>
                        </form>
                    </div></div>
                <script type="text/javascript">
                    function ModifyDns_submit(result) {
                        if(result != ''){
                            var solve = getJson(result);
                            if(solve !== false){
                                if(solve.status == "error"){
                                    if(solve.for != undefined && solve.for != ''){
                                        $("#ModifyDns "+solve.for).focus();
                                        $("#ModifyDns "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                        $("#ModifyDns "+solve.for).change(function(){
                                            $(this).removeAttr("style");
                                        });
                                    }
                                    if(solve.message != undefined && solve.message != '')
                                        alert_error(solve.message,{timer:5000});
                                }else if(solve.status == "successful"){
                                    alert_success(solve.message,{timer:3000});
                                    if(solve.redirect != undefined && solve.redirect != ''){
                                        setTimeout(function(){
                                            window.location.href = solve.redirect;
                                        },3000);
                                    }
                                }
                            }else
                                console.log(result);
                        }
                    }
                </script>


                <div class="ModifyDns">
                    <div class="padding20">
                        <span><strong><?php echo __("admin/orders/domain-cns-management"); ?></strong></span>
                        <form action="<?php echo $links["controller"]; ?>" method="post" id="addCNS">
                            <input type="hidden" name="operation" value="domain_add_cns">
                            <input name="ns" type="text" class="yuzde50" placeholder="ns1.example.com">
                            <input name="ip" type="text" class="yuzde50" placeholder="192.168.1.1">
                            <a style="width:240px;float:none;" href="javascript:void(0);" class="yesilbtn gonderbtn mio-ajax-submit" mio-ajax-options='{"result":"addCNS_submit","waiting_text":"<?php echo addslashes(__("website/others/button1-pending")); ?>"}'><?php echo __("website/account_products/add-ns-button"); ?></a>
                        </form>
                        <script type="text/javascript">
                            function addCNS_submit(result) {
                                if(result != ''){
                                    var solve = getJson(result);
                                    if(solve !== false){
                                        if(solve.status == "error"){
                                            if(solve.for != undefined && solve.for != ''){
                                                $("#addCNS "+solve.for).focus();
                                                $("#addCNS "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                                $("#addCNS "+solve.for).change(function(){
                                                    $(this).removeAttr("style");
                                                });
                                            }
                                            if(solve.message != undefined && solve.message != '')
                                                alert_error(solve.message,{timer:5000});
                                        }else if(solve.status == "successful"){
                                            alert_success(solve.message,{timer:3000});
                                            if(solve.redirect != undefined && solve.redirect != ''){
                                                setTimeout(function(){
                                                    window.location.href = solve.redirect;
                                                },3000);
                                            }
                                        }
                                    }else
                                        console.log(result);
                                }
                            }
                        </script>

                        <div class="clear"></div>
                        <br>
                        <?php if(isset($options["cns_list"]) && sizeof($options["cns_list"])): ?>

                            <?php
                        foreach($options["cns_list"] AS $id=>$row){
                            ?>
                            <form action="<?php echo $links["controller"]; ?>" method="post" id="ModifyCns<?php echo $id; ?>">
                                <input type="hidden" name="operation" value="domain_modify_cns">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">

                                <input name="ns" type="text" class="ucte1" placeholder="ns1.example.com" value="<?php echo $row["ns"]; ?>">
                                <input name="ip" type="text" class="ucte1" placeholder="192.168.1.1" value="<?php echo $row["ip"]; ?>">
                                <a href="javascript:void(0);" class="lbtn mio-ajax-submit" mio-ajax-options='{"result":"ModifyCNS","waiting_text":"<?php echo addslashes(__("website/others/button4-pending")); ?>"}'><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                <a href="javascript:void(0);" class="lbtn mio-ajax-submit" mio-ajax-options='{"action":"<?php echo $links["controller"];?>","method":"POST","data":{"operation":"domain_delete_cns","id":"<?php echo $id;?>"},"type":"direct","result":"DeleteCNS","waiting_text":"<?php echo addslashes(__("website/others/button4-pending")); ?>","before_function":"delete_confirm"}'><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                            </form>
                        <?php
                            }
                        ?>
                            <script type="text/javascript">
                                function delete_confirm() {
                                    var co = confirm("<?php echo __("website/account_products/delete-are-you-sure"); ?>");
                                    return co;
                                }
                                function DeleteCNS(result) {
                                    if(result != ''){
                                        var solve = getJson(result);
                                        if(solve !== false){
                                            if(solve.status == "error"){
                                                swal(
                                                    '<?php echo __("website/account_products/modal-error-title"); ?>',
                                                    solve.message,
                                                    'error'
                                                )
                                            }else if(solve.status == "successful"){
                                                swal({
                                                    type: 'success',
                                                    title: '<?php echo __("website/account_products/modal-success-title"); ?>',
                                                    text: '<?php echo __("website/account_products/deleted-domain-cns"); ?>',
                                                    showConfirmButton: false,
                                                    timer: 1500
                                                });
                                                setTimeout(function(){
                                                    var link = "<?php echo $links["controller"]; ?>";
                                                    link = sGET("tab","dns",link);
                                                    window.location.href = link;
                                                },1500);
                                            }
                                        }else
                                            console.log(result);
                                    }
                                }
                                function ModifyCNS(result) {
                                    if(result != ''){
                                        var solve = getJson(result);
                                        if(solve !== false){
                                            if(solve.status == "error"){
                                                swal(
                                                    '<?php echo __("website/account_products/modal-error-title"); ?>',
                                                    solve.message,
                                                    'error'
                                                )
                                            }else if(solve.status == "successful"){
                                                swal({
                                                    type: 'success',
                                                    title: '<?php echo __("website/account_products/modal-success-title"); ?>',
                                                    text: '<?php echo __("website/account_products/changed-domain-cns"); ?>',
                                                    showConfirmButton: false,
                                                    timer: 1500
                                                });
                                                setTimeout(function(){
                                                    var link = "<?php echo $links["controller"]; ?>";
                                                    link = sGET("tab","dns",link);
                                                    link = sGET("accordion","1",link);
                                                    window.location.href = link;
                                                },1500);
                                            }
                                        }else
                                            console.log(result);
                                    }
                                }
                            </script>

                        <?php else: ?>
                            <div align="center" style="margin-top:20px;"><?php echo __("website/account_products/none-cns"); ?></div>
                        <?php endif; ?>
                    </div>
                </div>


            </div>
        </div>
    <?php } ?>

    <?php if($proanse["status"] == "active" && $ctoc_service_transfer): ?>
        <div id="transfer-service" class="tabcontent">
            <div class="tabcontentcon">
                <div class="blue-info" style="margin-bottom:20px;">
                    <div class="padding15">
                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                        <p><?php echo __("website/account_products/transfer-service-desc"); ?></p>
                    </div>
                </div>

                <?php
                    if(isset($ctoc_limit) && strlen($ctoc_limit) > 0){
                        ?>
                        <div class="clear"></div>
                        <div class="formcon">
                            <div class="yuzde30"><?php echo __("website/account_products/limit-info"); ?></div>
                            <div class="yuzde70" style="color: #F44336;"><?php echo ($ctoc_limit - $ctoc_used); ?></div>
                        </div>
                        <div class="clear"></div>
                        <?php
                    }
                ?>

                <div id="TransferService_wrap" style="<?php echo $ctoc_has_expired ? 'display:none;' : ''; ?>">

                    <form action="<?php echo $links["controller"]; ?>" method="post" id="TransferService">
                        <input type="hidden" name="operation" value="transfer_service">

                        <input type="text" name="email" placeholder="<?php echo __("website/account_products/transfer-service-client-email"); ?>">

                        <input type="password" name="password" placeholder="<?php echo __("website/account_products/transfer-service-your-account-password"); ?>">

                        <a href="javascript:void(0);" class="yesilbtn gonderbtn mio-ajax-submit" mio-ajax-options='{"result":"TransferService_handle","waiting_text":"<?php echo addslashes(__("website/others/button5-pending")); ?>"}'><?php echo __("website/account_products/transfer-button"); ?></a>
                        <div class="clear"></div>
                    </form>


                    <h4 style="margin-bottom:7px;    font-size: 18px;"><strong><?php echo __("website/account_products/transfer-service-pending-list"); ?></strong></h4>

                    <table id="ctoc_s_t_list" width="100%" border="0" style="<?php echo isset($ctoc_s_t_list) && is_array($ctoc_s_t_list) && sizeof($ctoc_s_t_list)>0 ? '' : 'display:none;'; ?>">
                        <thead style="background:#ebebeb;">
                        <tr>
                            <th align="left"><?php echo __("website/account_products/transfer-service-list-th-user"); ?></th>
                            <th align="center"><?php echo __("website/account_products/transfer-service-list-th-email"); ?></th>
                            <th align="center"><?php echo __("website/account_products/transfer-service-list-th-date"); ?></th>
                            <th align="center"> </th>
                        </tr>
                        </thead>

                        <tbody align="center" style="border-top:none;">
                        <?php
                            if(isset($ctoc_s_t_list) && is_array($ctoc_s_t_list) && sizeof($ctoc_s_t_list)>0){
                                foreach($ctoc_s_t_list AS $ctoc_s_t_r){
                                    $ctoc_s_t_r["data"]     = Utility::jdecode($ctoc_s_t_r["data"],true);
                                    $evt_data               = $ctoc_s_t_r["data"];
                                    $full_name              = $evt_data["to_full_name"];
                                    $name_length            = Utility::strlen($full_name);
                                    $name_length            -= 2;
                                    $full_name              = Utility::substr($full_name,0,2).str_repeat("*",$name_length);
                                    ?>
                                    <tr style="background:none;" id="ctoc_s_t_<?php echo $ctoc_s_t_r["id"]; ?>">
                                        <td align="left"><?php echo $full_name; ?></td>
                                        <td align="center"><?php echo $evt_data["to_email"]; ?></td>
                                        <td align="center"><?php echo DateManager::format(Config::get("options/date-format")." H:i",$ctoc_s_t_r["cdate"]); ?></td>
                                        <td align="center" width="140">
                                            <a href="javascript:void 0;" onclick="remove_ctoc_s_t(<?php echo $ctoc_s_t_r["id"]; ?>,this);" class="sbtn red" data-tooltip="<?php echo ___("needs/button-delete"); ?>"><i class="fa fa-times"></i></a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                        ?>
                        </tbody>
                    </table>
                    <div id="ctoc_s_t_no_list" class="error" style="<?php echo !(isset($ctoc_s_t_list) && is_array($ctoc_s_t_list) && sizeof($ctoc_s_t_list)>0) ? '' : 'display:none;' ?>"><?php echo __("website/account_products/transfer-service-no-list"); ?></div>


                </div>
                <div id="TransferService_success" style="display: none;">
                    <div style="margin-top:30px;margin-bottom:70px;text-align:center;">
                        <i style="font-size:80px;" class="fa fa-check"></i>
                        <h4><?php echo __("website/account_products/transfer-service-successful"); ?></h4>
                        <br>
                    </div>
                </div>
                <script type="text/javascript">
                    function TransferService_handle(result){
                        if(result != ''){
                            var solve = getJson(result);
                            if(solve !== false){
                                if(solve.status == "error"){
                                    if(solve.for != undefined && solve.for != ''){
                                        $("#TransferService "+solve.for).focus();
                                        $("#TransferService "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                        $("#TransferService "+solve.for).change(function(){
                                            $(this).removeAttr("style");
                                        });
                                    }
                                    if(solve.message != undefined && solve.message != '')
                                        alert_error(solve.message,{timer:3000});
                                }else if(solve.status == "successful"){
                                    $("#TransferService_wrap").fadeOut(400,function(){
                                        $("#TransferService_success").fadeIn(400);
                                        $("html,body").animate({scrollTop:200},600);
                                    });
                                    if(solve.reload !== undefined){
                                        setTimeout(function(){
                                            location.href = '<?php echo $links["controller"]; ?>?tab=transfer-service';
                                        },3000);
                                    }
                                }
                            }else
                                console.log(result);
                        }
                    }
                    function remove_ctoc_s_t(id,btn){
                        swal({
                            title: '<?php echo ___("needs/delete-are-you-sure"); ?>',
                            text: "",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: '<?php echo __("website/others/notification-confirm"); ?>',
                            cancelButtonText: '<?php echo __("website/others/notification-cancel"); ?>',
                        }).then(function(value){
                            if(value){
                                var request = MioAjax({
                                    waiting_text: '<i style="-webkit-animation:fa-spin 2s infinite linear;animation: fa-spin 2s infinite linear;" class="fa fa-spinner" aria-hidden="true"></i>',
                                    button_element: btn,
                                    action: "<?php echo $links["controller"]; ?>",
                                    method: "POST",
                                    data:{
                                        operation: "remove_transfer_service",
                                        id: id
                                    },
                                },true,true);
                                request.done(function(result){
                                    if(result !== ''){
                                        var solve = getJson(result);
                                        if(solve.status === 'error')
                                            Swal.fire(
                                                '<?php echo __("website/others/notification-error"); ?>',
                                                solve.message,
                                                'error'
                                            );
                                        else if(solve.status === 'successful'){
                                            swal(
                                                '<?php echo __("website/others/notification-success"); ?>',
                                                solve.message,
                                                'success'
                                            );
                                            $(btn).parent().parent().remove();
                                            if($("#ctoc_s_t_list tbody tr").length < 1){
                                                $("#ctoc_s_t_list").css("display","none");
                                                $("#ctoc_s_t_no_list").css("display","block");
                                            }
                                        }
                                    }
                                });
                            }
                        });
                    }
                </script>
            </div>
        </div>
    <?php endif; ?>

    <?php
        if($proanse["status"] == "active"){
            ?>
            <div id="guvenlik" class="tabcontent">
                <div class="tabcontentcon">


                    <div class="green-info" style="margin-bottom:20px;">
                        <div class="padding15">
                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                            <p><?php echo __("website/account_products/transferlock-note"); ?></p>
                        </div>
                    </div>

                    <?php if(isset($options["transferlock"]) && $options["transferlock"]): ?>
                        <h5><strong><?php echo __("website/account_products/transferlock"); ?></strong> <strong style="color:#8bc34a;margin-left:10px;"><i class="fa fa-lock" aria-hidden="true"></i> <?php echo __("website/account_products/transferlock-active"); ?></strong></h5>

                        <br><a href="javascript:void(0);" class="redbtn gonderbtn mio-ajax-submit" mio-ajax-options='{"data":{"operation":"domain_modify_transferlock"},"action":"<?php echo $links["controller"]; ?>","method":"POST","type":"direct","result":"Transferlock_submit","waiting_text":"<?php echo addslashes(__("website/others/button1-pending")); ?>"}'><?php echo __("website/account_products/transferlock-passive-button"); ?></a>

                    <?php else: ?>
                        <h5><strong><?php echo __("website/account_products/transferlock"); ?></strong> <strong style="color:#E21D1D;margin-left:10px;"><i class="fa fa-unlock" aria-hidden="true"></i> <?php echo __("website/account_products/transferlock-passive"); ?></strong></h5>

                        <br><a href="javascript:void(0);" class="yesilbtn gonderbtn mio-ajax-submit" mio-ajax-options='{"data":{"operation":"domain_modify_transferlock"},"action":"<?php echo $links["controller"]; ?>","method":"POST","type":"direct","result":"Transferlock_submit","waiting_text":"<?php echo addslashes(__("website/others/button1-pending")); ?>"}'><?php echo __("website/account_products/transferlock-active-button"); ?></a>
                    <?php endif; ?>

                    <script type="text/javascript">
                        function Transferlock_submit(result) {
                            if(result != ''){
                                var solve = getJson(result);
                                if(solve !== false){
                                    if(solve.status == "error"){
                                        swal(
                                            '<?php echo __("website/account_products/modal-error-title"); ?>',
                                            solve.message,
                                            'error'
                                        )
                                    }else if(solve.status == "successful"){
                                        swal({
                                            type: 'success',
                                            title: '<?php echo __("website/account_products/modal-success-title"); ?>',
                                            text: '<?php echo __("website/account_products/changed-transferlock"); ?>',
                                            showConfirmButton: false,
                                            timer: 1500
                                        });
                                        setTimeout(function(){
                                            var link = "<?php echo $links["controller"]; ?>";
                                            link = sGET("tab","security",link);
                                            window.location.href = link;
                                        },1500);
                                    }
                                }else
                                    console.log(result);
                            }

                        }
                    </script>

                </div>
                <div class="clear"></div>
            </div>
            <div id="transfer" class="tabcontent">
                <div class="tabcontentcon">

                    <div class="green-info" style="margin-bottom:20px;">
                        <div class="padding15">
                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                            <p><?php echo __("website/account_products/transfer-code-note"); ?></p>
                        </div>
                    </div>

                    <div id="transfercode_submit">

                        <?php echo __("website/account_products/transfer-code-note2"); ?>
                        <a style="width:250px;" href="javascript:void(0);" class="mavibtn gonderbtn mio-ajax-submit" mio-ajax-options='{"data":{"operation":"domain_transfer_code_submit"},"action":"<?php echo $links["controller"]; ?>","method":"POST","type":"direct","result":"TransferCode_submit","waiting_text":"<?php echo addslashes(__("website/others/button1-pending")); ?>"}'><?php echo __("website/account_products/transfer-code-submit"); ?></a>
                    </div>

                    <div id="TransferCode_success1" style="display: none;">
                        <div style="margin-top:30px;margin-bottom:70px;text-align:center;">
                            <i style="font-size:80px;color:green;" class="fa fa-check"></i>
                            <h2 style="color:green;font-weight:bold;"><?php echo __("website/account_products/transfer-code-sent1"); ?></h2>
                            <br/>
                            <h4><?php echo __("website/account_products/transfer-code-sent2"); ?></h4>
                        </div>
                    </div>

                    <div id="TransferCode_success2" style="display: none;">
                        <div style="margin-top:30px;margin-bottom:70px;text-align:center;">
                            <i style="font-size:80px;color:green;" class="fa fa-check"></i>
                            <h2 style="color:green;font-weight:bold;"><?php echo __("website/account_products/transfer-code-sent1"); ?></h2>
                            <br/>
                            <h4><?php echo __("website/account_products/transfer-code-sent3"); ?></h4>
                        </div>
                    </div>

                    <script type="text/javascript">
                        function TransferCode_submit(result) {
                            if(result != ''){
                                var solve = getJson(result);
                                if(solve !== false){
                                    if(solve.status == "error"){
                                        swal(
                                            '<?php echo __("website/account_products/modal-error-title"); ?>',
                                            solve.message,
                                            'error'
                                        )
                                    }else if(solve.status == "successful"){

                                        $("#transfercode_submit").fadeOut(400,function(){
                                            if(solve.type != undefined && solve.type == "request")
                                                $("#TransferCode_success2").fadeIn(400);
                                            else
                                                $("#TransferCode_success1").fadeIn(400);
                                            $("html,body").animate({scrollTop:200},600);
                                        });
                                    }
                                }else
                                    console.log(result);
                            }
                        }
                    </script>



                </div>
                <div class="clear"></div>
            </div>
            <?php
        }
    ?>


    <div class="clear"></div>
</div>