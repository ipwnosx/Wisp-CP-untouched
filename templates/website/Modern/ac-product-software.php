<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    $wide_content   = true;

    $renewalDateSub     = substr($proanse["renewaldate"],0,4);
    $duedateSub         = substr($proanse["duedate"],0,4);

    include $tpath."common-needs.php";
    $hoptions = ["datatables","jquery-ui","select2","ion.rangeSlider"];




?>
<style type="text/css"></style>
<script type="text/javascript">
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

    });

</script>
<div class="mpanelrightcon">

    <div class="mpaneltitle">
        <div class="sayfayolu"><?php include $tpath."inc".DS."panel-breadcrumb.php"; ?></div>
        <h4><strong><i class="fa fa-check" aria-hidden="true"></i> <?php echo $proanse["name"];?></strong></h4>
    </div>

    <ul class="tab">
        <li><a href="javascript:void(0)" class="tablinks" onclick="openTab(this, 'detail')" data-tab="1"><i class="fa fa-info" aria-hidden="true"></i> <?php echo __("website/account_products/tab-detail"); ?></a></li>

        <li><a href="javascript:void(0)" class="tablinks" onclick="openTab(this, 'addons')" data-tab="addons"><i class="fa fa-rocket" aria-hidden="true"></i> <?php echo __("website/account_products/tab-addons"); ?></a></li>

        <?php if(isset($requirements) && $requirements): ?>
            <li><a href="javascript:void(0)" class="tablinks" onclick="openTab(this, 'requirements')" data-tab="requirements"><i class="fa fa-check-square" aria-hidden="true"></i> <?php echo __("website/account_products/tab-requirements"); ?></a></li>
        <?php endif; ?>

        <?php
            if(isset($product["optionsl"]["requirements"]) && Filter::html_clear($product["optionsl"]["requirements"]))
            {
                ?>
                <li><a href="javascript:void(0)" class="tablinks" onclick="openTab(this, 'software_requirements')" data-tab="software_requirements"><i class="fa fa-info" aria-hidden="true"></i> <?php echo __("website/account_products/tab-software-requirements"); ?></a></li>
                <?php
            }

            if(isset($product["optionsl"]["installation_instructions"]) && Filter::html_clear($product["optionsl"]["installation_instructions"]))
            {
                ?>
                <li><a href="javascript:void(0)" class="tablinks" onclick="openTab(this, 'installation')" data-tab="installation"><i class="fa fa-info" aria-hidden="true"></i> <?php echo __("website/account_products/tab-software-installation"); ?></a></li>
                <?php
            }

            if(isset($product["optionsl"]["versions"]) && Filter::html_clear($product["optionsl"]["versions"]))
            {
                ?>
                <li><a href="javascript:void(0)" class="tablinks" onclick="openTab(this, 'versions')" data-tab="versions"><i class="fa fa-info" aria-hidden="true"></i> <?php echo __("website/account_products/tab-software-versions"); ?></a></li>
                <?php
            }
        ?>


        <?php if($proanse["status"] == "active" && $ctoc_service_transfer): ?>
            <li><a href="javascript:void(0)" class="tablinks" onclick="openTab(this, 'transfer-service')" data-tab="transfer-service"><i class="fa fa-exchange" aria-hidden="true"></i> <?php echo __("website/account_products/transfer-service"); ?></a></li>
        <?php endif; ?>

        <?php if($proanse["status"] == "active" && $proanse["period"] != "none"): ?>
            <li><a href="javascript:void(0)" class="tablinks" onclick="openTab(this, 'iptaltalebi')" data-tab="cancellation"><i class="fa fa-ban" aria-hidden="true"></i> <?php echo __("website/account_products/cancellation-request"); ?></a></li>
        <?php endif; ?>

        <div class="orderidno"><span><?php echo __("website/account_products/table-ordernum"); ?></span><strong>#<?php echo $proanse["id"]; ?></strong></div>
    </ul>

    <div id="detail" class="tabcontent">

        <div<?php echo $change_domain ? ' id="block_modulewidth50"' : ''; ?> class="hizmetblok">

            <div class="service-first-block">

                <div id="order_image">
                    <?php if(isset($options["product_image"])): ?>
                        <img  src="<?php echo $options["product_image"]; ?>" width="200" height="auto">
                    <?php else: ?>
                        <img style="width:120px;margin-bottom:15px;" src="<?php echo $tadress."images/software-order-cover.png"; ?>" width="auto" height="auto">
                    <?php endif; ?>
                </div>

                <h4><strong><?php echo $proanse["name"]; ?></strong></h4>

                <?php if(isset($options["domain"]) && $options["domain"] != ''): ?>
                    <H5 style="margin-top:15px;"><?php echo __("website/account_products/license-domain"); ?><br>
                        <strong><?php echo $options["domain"]; ?></strong></H5>
                <?php endif; ?>

                 <div id="order-service-detail-btns" style="margin-top: 20px;">
                <?php if(isset($download_link) && $download_link != ''): ?>
                    <a <?php echo $proanse["status"] != "active" ? "" : 'href="'.$download_link.'"'; ?> class="<?php echo $proanse["status"] != "active" ? "graybtn" : "yesilbtn"; ?> gonderbtn"><i class="fa fa-cloud-download" aria-hidden="true"></i> <?php echo __("website/account_products/download-button"); ?></a>
                <?php endif; ?>

                <?php
                    if((!isset($subscription) || $subscription["status"] == "cancelled") && isset($product) && $product && $proanse["period"] != "none" && ($proanse["status"] == "active" || $proanse["status"] == "suspended") && (!isset($proanse["disable_renewal"]) || !$proanse["disable_renewal"]) && (!isset($proanse["options"]["disable_renewal"]) || !$proanse["options"]["disable_renewal"])){
                        ?>
                        <div class="clear"></div>
                        <div id="renewal_list" style="display:none;">
                            <select id="selection_renewal">
                                <option value=""><?php echo __("website/account_products/renewal-list-option"); ?></option>
                                <?php
                                    if(isset($product["price"])){
                                        foreach($product["price"] AS $k=>$v){
                                            ?>
                                            <option value="<?php echo $k; ?>"><?php
                                                    echo View::period($v["time"],$v["period"]);
                                                    echo " ";
                                                    echo Money::formatter_symbol($v["amount"],$v["cid"],true);
                                                ?></option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                            <script type="text/javascript">
                                $(document).ready(function () {
                                    $("#selection_renewal").change(function () {
                                        var selection = $(this).val();
                                        if (selection != '') {
                                            var result = MioAjax({
                                                action: "<?php echo $links["controller"]; ?>",
                                                method: "POST",
                                                data: {operation: "order_renewal", period: selection}
                                            }, true);

                                            if (result) {
                                                var solve = getJson(result);
                                                if (solve) {
                                                    if (solve.status == "successful") {
                                                        window.location.href = solve.redirect;
                                                    }
                                                }
                                            }
                                        }
                                    });
                                });
                            </script>
                        </div>
                        <a href="javascript:$('#renewal_list').slideToggle(400);void 0;"
                           class="mavibtn gonderbtn"><i class="fa fa-refresh"></i> <?php echo __("website/account_products/renewal-now-button"); ?></a>
                        <div class="clear"></div>
                        <?php
                    }

                ?>
                </div>

            </div>
        </div>

        <div<?php echo $change_domain ? ' id="block_modulewidth50"' : ''; ?> class="hizmetblok">
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
                    <td><?php echo $options["group_name"]; ?></td>
                </tr>

                <tr>
                    <td><strong><?php echo __("website/account_products/service-name"); ?></strong></td>
                    <td><?php echo $proanse["name"]; ?></td>
                </tr>
                <tr>
                    <td><strong><?php echo __("website/account_products/license-status"); ?></strong></td>
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

                <?php if($proanse["period"] != "none" && $renewalDateSub != "1881" && $renewalDateSub != "1970"): ?>
                    <tr>
                        <td><strong><?php echo __("website/account_products/last-paid-date"); ?></strong></td>
                        <td><?php echo DateManager::format(Config::get("options/date-format"),$proanse["renewaldate"]); ?></td>
                    </tr>
                <?php endif; ?>

                <tr>
                    <td><strong><?php echo __("website/account_products/purchase-date"); ?></strong></td>
                    <td><?php echo DateManager::format(Config::get("options/date-format"),$proanse["cdate"]); ?></td>
                </tr>

                <?php if($duedateSub != "1881"): ?>
                    <tr>
                        <td><strong><?php echo __("website/account_products/last-payment-date"); ?></strong></td>
                        <td><?php echo DateManager::format(Config::get("options/date-format"),$proanse["duedate"]); ?></td>
                    </tr>
                <?php endif; ?>

                </tr>
                <tr align="center" class="tutartd">
                    <td colspan="2"><strong><?php echo __("website/account_products/amount"); ?> : <?php echo $amount; ?></strong></td>
                </tr>
            </table>

        </div>


        <?php
            $p_options = $product["options"];
            if(isset($p_options["license_type"]) && $p_options["license_type"] == "key")
            {
                $license_parameters     = isset($p_options["license_parameters"]) ? $p_options["license_parameters"] : [];
                $license_parameters_o   = isset($options["license_parameters"]) ? $options["license_parameters"] : [];

                ?>
                <div class="block_module_details">
                    <div class="order-detail-service-block">

                        <div class="order-detail-service-block-title"><h4><?php echo __("website/account_products/license-information"); ?></h4></div>


                        <div class="formcon">
                            <div class="order-detail-service-left"><?php echo __("website/account_products/license-key"); ?></div>
                            <div class="order-detail-service-right">
                                <?php echo isset($options["code"]) ? $options["code"] : __("website/account_products/license-param-no-result"); ?>
                            </div>
                        </div>

                        <?php
                            if(isset($license_parameters["ip"]["clientArea"]) && $license_parameters["ip"]["clientArea"])
                            {
                                ?>
                                <div class="formcon">
                                    <div class="order-detail-service-left"><?php echo __("website/account_products/server-info-notification-ip"); ?></div>
                                    <div class="order-detail-service-right">
                                        <?php echo isset($options["ip"]) ? $options["ip"] : __("website/account_products/license-param-no-result"); ?>
                                    </div>
                                </div>
                                <?php
                            }

                            if($license_parameters)
                            {
                                foreach($license_parameters AS $k => $v)
                                {
                                    if($k == "ip") continue;
                                    if(!isset($v["clientArea"]) || !$v["clientArea"]) continue;
                                    $p_name     = $v["name"];
                                    $p_value    = isset($license_parameters_o[$k]) ? $license_parameters_o[$k] : __("website/account_products/license-param-no-result");
                                    ?>
                                    <div class="formcon">
                                        <div class="order-detail-service-left"><?php echo $p_name; ?></div>
                                        <div class="order-detail-service-right">
                                            <?php echo $p_value; ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                        ?>

                        <div class="formcon">
                            <div class="order-detail-service-left"><?php echo __("website/account_products/license-reissue-1"); ?>
                                <br><span class="kinfo"><?php echo __("website/account_products/license-reissue-2"); ?></span>
                            </div>
                            <div class="order-detail-service-right">
                                <a class="green sbtn" href="javascript:void 0;" onclick="reissue(this);"><i class="fa fa-refresh" aria-hidden="true"></i> <?php echo __("website/account_products/license-reissue-3"); ?></a>

                            </div>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    function reissue(el)
                    {
                        if(confirm("<?php echo ___("needs/apply-are-you-sure"); ?>"))
                        {
                            var request = MioAjax({
                                waiting_text:"<i class='fa fa-spinner' style='-webkit-animation:fa-spin 2s infinite linear;animation: fa-spin 2s infinite linear;'></i> <?php echo __("website/others/button1-pending"); ?>",
                                button_element: el,
                                action: "<?php echo $links["controller"]; ?>",
                                method: "POST",
                                data:{operation: "reissue_software"}
                            },true,true);
                            request.done(function(result){
                                result = getJson(result);
                                if(result !== false)
                                {
                                    if(result.status === "error")
                                        alert_error(result.message,{timer:3000});
                                    else if(result.status === "successful")
                                        window.location.href = '<?php echo $links["controller"]; ?>';
                                }
                            });
                        }
                    }
                </script>
                <?php

            }
            elseif(isset($p_options["license_type"]) && $p_options["license_type"] == "domain" && $change_domain)
            {
                ?>
                <div class="clear"></div>
                <div class="block_module_details" style="text-align:left;">
                    <div class="hizmetblok" id="block_module_details_con">
                        <div class="block_module_details-title formcon">
                            <h4><?php echo __("website/account_products/block-change-domain"); ?></h4>
                        </div>

                        <?php
                            if(isset($change_domain_limit) && strlen($change_domain_limit) > 0){
                                ?>
                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("website/account_products/limit-info"); ?></div>
                                    <div class="yuzde70" style="color: #F44336;"><?php echo ($change_domain_limit - $change_domain_used); ?></div>
                                </div>
                                <?php
                            }
                        ?>

                        <form action="<?php echo $links["controller"]; ?>" method="post" id="changeDomainForm" onsubmit="$('#changeDomainForm_btn').click(); return false;" style="<?php echo $change_domain_has_expired ? 'display:none;' : ''; ?>">
                            <input type="hidden" name="operation" value="change_software_domain">
                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("website/account_products/block-change-domain-define-new-domain"); ?></div>
                                <div class="yuzde70">
                                    <input type="text" name="domain" placeholder="example.com">
                                </div>
                            </div>

                            <div class="clear"></div>
                            <a class="gonderbtn yesilbtn" href="javascript:void 0;" id="changeDomainForm_btn"><?php echo ___("needs/button-apply"); ?></a>
                        </form>
                        <script type="text/javascript">
                            $(document).ready(function(){
                                $("#changeDomainForm_btn").click(function(){
                                    MioAjaxElement(this,{
                                        "result":"changeDomainForm_handler",
                                        "waiting_text":"<?php echo addslashes(__("website/others/button5-pending")); ?>",
                                    });
                                });
                            });

                            function changeDomainForm_handler(result){
                                if(result !== ''){
                                    var solve = getJson(result);
                                    if(solve !== false){
                                        if(solve.status == "error"){
                                            if(solve.for != undefined && solve.for != ''){
                                                $("#changeDomainForm "+solve.for).focus();
                                                $("#changeDomainForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                                $("#changeDomainForm "+solve.for).change(function(){
                                                    $(this).removeAttr("style");
                                                });
                                            }
                                            if(solve.message != undefined && solve.message !== '')
                                                alert_error(solve.message,{timer:3000});
                                        }else if(solve.status == "successful"){
                                            window.location.href = '<?php echo $links["controller"]; ?>';
                                        }
                                    }else
                                        console.log(result);
                                }
                            }
                        </script>


                    </div>
                </div>
                <?php
            }

        ?>


    </div>

    <div id="addons" class="tabcontent">

        <script type="text/javascript">
            $(document).ready(function(){

                $('#addons_table').DataTable({
                    "columnDefs": [
                        {
                            "targets": [0],
                            "visible":false,
                            "searchable": false
                        },
                    ],
                    paging: false,
                    info:     false,
                    searching: false,
                    responsive: true,
                    "oLanguage":<?php include __DIR__.DS."datatable-lang.php"; ?>
                });
            });
        </script>


        <style>
            .buyaddservice {display:inline-block;width:100%;margin-bottom:30px;}
            .addservicetitle {font-weight: 600;font-size: 22px;padding:15px 0px;margin-bottom:15px;border-bottom:1px solid #eee;}
            .buyaddservice .sunucukonfigurasyonu {margin-bottom:0;}
            .buyaddservice .skonfigside {background: #<?php echo Config::get("theme/color1"); ?>}
        </style>


        <?php
            if(isset($product_addons) && $product_addons)
            {
                ?>
                <div class="buyaddservice">

                    <h4 class="addservicetitle"><?php echo __("website/account_products/buy-service"); ?></h4>


                    <div class="sunucukonfigurasyonu">

                        <form action="<?php echo $links["controller"]; ?>" method="post" id="BuyAddons">
                            <input type="hidden" name="operation" value="buy_addons_summary">

                            <div class="sungenbil">


                                <div class="skonfiginfo">
                                    <div style="padding:20px;">


                                        <table width="100%" border="0">

                                            <?php
                                                foreach($product_addons AS $addon){
                                                    $options  = $addon["options"];
                                                    $properties = $addon["properties"];
                                                    $compulsory = false;
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
                            </div>
                            <div class="sunucusipside">
                                <div class="skonfigside" style="width: 100%;">
                                    <div style="padding:20px;">
                                        <h4><?php echo __("website/osteps/order-summary"); ?></h4>
                                        <div id="service_amounts">

                                        </div>
                                        <div class="line"></div>
                                        <div class="sunucretler">
                                            <h3><span><?php echo __("website/osteps/total-amount"); ?>: <strong id="total_amount">0</strong></span></h3>
                                        </div>
                                    </div>
                                </div>
                                <a href="javascript:void 0;" style="cursor: no-drop" class="graybtn gonderbtn" id="BuyAddons_submit_disable"><?php echo __("website/osteps/continue-button"); ?></a>
                                <a style="display: none;" href="javascript:void 0;" class="gonderbtn" id="BuyAddons_submit"><?php echo __("website/osteps/continue-button"); ?></a>
                                <div class="clear"></div>
                            </div>

                        </form>


                        <script type="text/javascript">
                            $(document).ready(function(){
                                var changes = true;
                                ReloadOrderSummary();

                                $("#BuyAddons").change(function(){
                                    changes = true;
                                });
                                setInterval(function(){
                                    if(changes)
                                    {
                                        ReloadOrderSummary();
                                        changes = false;
                                    }
                                },500);

                                $("#BuyAddons_submit").click(function(){
                                    $("#BuyAddons input[name=operation]").val("buy_addons");
                                    MioAjaxElement(this,{
                                        waiting_text: "<?php echo __("website/others/button1-pending"); ?>",
                                        result: "t_form_handle",
                                    })
                                });

                            });

                            function ReloadOrderSummary(){
                                $("#BuyAddons input[name=operation]").val("buy_addons_summary");
                                var form_data = $("#BuyAddons").serialize();
                                var request = MioAjax({
                                    action: "<?php echo $links["controller"]; ?>",
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
                                                    $("#BuyAddons_submit").css("display","inline-block");
                                                    $("#BuyAddons_submit_disable").css("display","none");
                                                }
                                                else
                                                {
                                                    $("#BuyAddons_submit").css("display","none");
                                                    $("#BuyAddons_submit_disable").css("display","inline-block");
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


                </div>
                <?php
            }
        ?>


        <h4 class="addservicetitle"><?php echo __("website/account_products/purchased-services"); ?></h4>

        <table width="100%" id="addons_table" class="table table-striped table-borderedx table-condensed nowrap">
            <thead style="background:#ebebeb;">
            <tr>
                <th align="left">#</th>
                <th align="left"><?php echo __("website/account_products/addons-table-addon-info"); ?></th>
                <th align="center"><?php echo __("website/account_products/addons-table-date"); ?></th>
                <th align="center"><?php echo __("website/account_products/addons-table-amount"); ?></th>
                <th align="center"><?php echo __("website/account_products/addons-table-status"); ?></th>
            </tr>
            </thead>
            <tbody align="center" style="border-top:none;">
            <?php
                if(isset($addons) && $addons)
                {
                    foreach($addons AS $k=>$row){
                        $list_cdatetime     = substr($row["cdate"],0,4)!="1881" ? DateManager::format(Config::get("options/date-format"),$row["cdate"]) : '-';
                        $list_rdatetime     = substr($row["renewaldate"],0,4)!="1881" ? DateManager::format(Config::get("options/date-format"),$row["renewaldate"]) : '-';
                        $list_duedatetime   = substr($row["duedate"],0,4)!="1881" ? DateManager::format(Config::get("options/date-format"),$row["duedate"]) : '-';
                        $status = $product_situations[$row["status"]];

                        $amount = $row["amount"]>0 ? Money::formatter_symbol($row["amount"],$row["cid"]) : ___("needs/free-amount");
                        $period = NULL;

                        if($row["amount"]>0){
                            $period = View::period($row["period_time"],$row["period"]);
                        }
                        $amount_period  = "<strong>".$amount."</strong>";
                        if($period) $amount_period.= "<br>".$period."";

                        if(stristr($row["option_name"],'x '))
                        {
                            $split = explode("x ",$row["option_name"]);
                            $row["option_quantity"] = $split[0];
                            $row["option_name"] = $split[1];
                        }

                        ?>
                        <tr>
                            <td align="left"><?php echo $k; ?></td>
                            <td align="left"><?php echo $row["addon_name"]."<br>".($row["option_quantity"] > 0 ? $row["option_quantity"]."x " : '').$row["option_name"]; ?></td>
                            <td align="center"><?php echo $list_rdatetime."<br>".$list_duedatetime; ?></td>
                            <td align="center"><?php echo $amount_period; ?></td>
                            <td align="center"><?php echo $status; ?></td>
                        </tr>
                        <?php
                    }
                }
            ?>
            </tbody>
        </table>



    </div>

    <?php if(isset($requirements) && $requirements): ?>
        <div id="requirements" class="tabcontent">

            <?php
                foreach($requirements AS $requirement){
                    $response = $requirement["response"];
                    $rtype    = $requirement["response_type"];

                    if($rtype == "select" || $rtype == "radio" || $rtype == "checkbox" || $rtype == "file")
                        $response_j   = Utility::jdecode($response,true);

                    if(($rtype == "select" || $rtype == "radio") && is_array($response_j))
                        $response = htmlentities($response_j[0], ENT_QUOTES);
                    else
                        $response = htmlentities($response,ENT_QUOTES);


                    ?>
                    <div class="formcon">
                        <div class="yuzde30"><?php echo $requirement["requirement_name"]; ?></div>
                        <div class="yuzde70">
                            <?php
                                if($rtype == "file"){
                                    foreach($response_j AS $k=>$re){
                                        $link = $links["controller"]."?operation=requirement-file-download&rid=".$requirement["id"]."&key=".$k;
                                        ?><a href="<?php echo $link; ?>" target="_blank" class="lbtn"><i class="fa fa-external-link" aria-hidden="true"></i> <?php echo Utility::short_text($re["file_name"],0,30,true); ?></a> <?php
                                    }
                                }elseif($rtype == "checkbox"){
                                    if($response_j) echo implode(" , ",$response_j);
                                }else
                                    echo nl2br(Filter::link_convert($response));
                            ?>
                        </div>
                    </div>
                    <?php
                }
            ?>


        </div>
    <?php endif; ?>

    <?php if(isset($product["optionsl"]["requirements"]) && Filter::html_clear($product["optionsl"]["requirements"])): ?>
        <div id="software_requirements" class="tabcontent">
            <div class="tabcontentcon">
                <?php echo $product["optionsl"]["requirements"]; ?>
            </div>
            <div class="clear"></div>
        </div>
    <?php endif; ?>

    <?php if(isset($product["optionsl"]["installation_instructions"]) && Filter::html_clear($product["optionsl"]["installation_instructions"])): ?>
        <div id="installation" class="tabcontent">
            <div class="tabcontentcon">
                <?php echo $product["optionsl"]["installation_instructions"]; ?>
            </div>
            <div class="clear"></div>
        </div>
    <?php endif; ?>

    <?php if(isset($product["optionsl"]["versions"]) && Filter::html_clear($product["optionsl"]["versions"])): ?>
        <div id="versions" class="tabcontent">
            <div class="tabcontentcon">
                <?php echo $product["optionsl"]["versions"]; ?>
            </div>
            <div class="clear"></div>
        </div>
    <?php endif; ?>



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
                        <div class="formcon">
                            <div class="yuzde30"><?php echo __("website/account_products/limit-info"); ?></div>
                            <div class="yuzde70" style="color: #F44336;"><?php echo ($ctoc_limit - $ctoc_used); ?></div>
                        </div>
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
                        <thead>
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

    <?php if($proanse["status"] == "active" && $proanse["period"] != "none"): ?>
        <div id="iptaltalebi" class="tabcontent">
            <div class="tabcontentcon">
                <div class="red-info" style="margin-bottom:20px;">
                    <div class="padding15">
                        <i class="fa fa-meh-o" aria-hidden="true"></i>
                        <p><?php echo __("website/account_products/canceled-desc"); ?></p>
                    </div>
                </div>
                <form action="<?php echo $links["controller"]; ?>" method="post" id="CanceledProduct" style="<?php echo isset($p_cancellation) && $p_cancellation ? 'display:none;' : ''; ?>">
                    <input type="hidden" name="operation" value="canceled_product">

                    <textarea name="reason" cols="" rows="3" placeholder="<?php echo __("website/account_products/canceled-reason"); ?>"></textarea>
                    <select name="urgency">
                        <option value="now"><?php echo __("website/account_products/canceled-urgency-now"); ?></option>
                        <option value="period-ending"><?php echo __("website/account_products/canceled-urgency-period-ending"); ?></option>
                    </select>
                    <a href="javascript:void(0);" class="redbtn gonderbtn mio-ajax-submit" mio-ajax-options='{"result":"CanceledProduct_submit","waiting_text":"<?php echo addslashes(__("website/others/button5-pending")); ?>"}'><?php echo __("website/account_products/canceled-button"); ?></a>
                    <div class="clear"></div>
                </form>
                <div id="CanceledProduct_success" style="display: none;">
                    <div style="margin-top:30px;margin-bottom:70px;text-align:center;">
                        <i style="font-size:80px;color:green;" class="fa fa-check"></i>
                        <h4><?php echo __("website/account_products/canceled-sent"); ?></h4>
                        <br>
                    </div>
                </div>
                <script type="text/javascript">
                    function CanceledProduct_submit(result) {
                        if(result != ''){
                            var solve = getJson(result);
                            if(solve !== false){
                                if(solve.status == "error"){
                                    if(solve.for != undefined && solve.for != ''){
                                        $("#CanceledProduct "+solve.for).focus();
                                        $("#CanceledProduct "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                        $("#CanceledProduct "+solve.for).change(function(){
                                            $(this).removeAttr("style");
                                        });
                                    }
                                    if(solve.message != undefined && solve.message != '')
                                        alert_error(solve.message,{timer:3000});
                                }else if(solve.status == "successful"){
                                    $("#CanceledProduct").fadeOut(400,function(){
                                        $("#CanceledProduct_success").fadeIn(400);
                                        $("html,body").animate({scrollTop:200},600);
                                    });
                                }
                            }else
                                console.log(result);
                        }
                    }
                </script>

                <?php
                    if(isset($p_cancellation) && $p_cancellation)
                    {
                        $p_cancellation["data"] = Utility::jdecode($p_cancellation["data"],true);
                        ?>
                        <div style="margin-top:30px;margin-bottom:70px;text-align:center;">
                            <i class="fa fa-info-circle" aria-hidden="true" style="font-size: 54px;margin-bottom: 15px;"></i>
                            <h4 style="margin-bottom: 15px;"><strong><?php echo __("admin/events/cancelled-product-request"); ?></strong></h4>
                            <div class="line"></div>
                            <h5><strong><?php echo __("admin/orders/modal-reason-message"); ?></strong><br><?php echo $p_cancellation["data"]["reason"]; ?></h5>
                            <div class="line"></div>
                            <h5><strong><?php echo __("admin/tools/reminders-creation-date"); ?></strong><br><?php echo DateManager::format(Config::get("options/date-format")." - H:i",$p_cancellation["cdate"]); ?></h5>
                            <?php
                                if($p_cancellation["status"] != "approved")
                                {
                                    ?>
                                    <a class="green lbtn" onclick="remove_cancelled_product(this);" href="javascript:void 0;" style="margin-top: 25px;"><?php echo __("website/account_products/remove-cancellation-request"); ?></a>
                                    <script type="text/javascript">
                                        function remove_cancelled_product(el){
                                            var request = MioAjax({
                                                button_element:el,
                                                waiting_text:"<?php echo addslashes(__("website/others/button1-pending")); ?>",
                                                action: "<?php echo $links["controller"]; ?>",
                                                method: "POST",
                                                data:{operation:"remove_cancelled_product"}
                                            },true,true);
                                            request.done(function(result){
                                                if(result !== ''){
                                                    var solve = getJson(result);
                                                    if(solve !== false)
                                                    {
                                                        if(solve.status === "error")
                                                            alert_error(solve.message,{timer:3000});
                                                        else if(solve.status === "successful")
                                                            window.location.href = location.href;
                                                    }
                                                }
                                                else console.log(result);
                                            });
                                        }
                                    </script>
                                    <?php
                                }
                            ?>
                        </div>
                        <?php
                    }
                ?>


            </div>
        </div>
    <?php endif; ?>

    <div class="clear"></div>
</div>