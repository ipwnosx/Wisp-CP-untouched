<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    $wide_content   = true;
    $proanse_amount = $amount;

    include $tpath."common-needs.php";
    $hoptions = ["datatables","jquery-ui","select2","ion.rangeSlider"];

    if(isset($module) && $module && isset($proanse["hide_module_details"]) && $proanse["hide_module_details"]) $module = false;

?>
<div id="template-loader" style="display: none;">
    <div id="block_module_loader">
        <div class="load-wrapp">
            <p style="margin-bottom:20px;font-size:17px;"><strong><?php echo ___("needs/processing"); ?>...</strong><br><?php echo ___("needs/please-wait"); ?></p>
            <div class="load-7">
                <div class="square-holder">
                    <div class="square"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<style type="text/css">
    .hostbtn{width:150px;padding:10px 20px;background:#eee;display:inline-block;margin:5px;vertical-align:top;border-radius:3px}
    .hostbtn:hover {background:#dbdbdb;}
</style>
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
<?php
    if(isset($module) && $module){
        ?>
        <script type="text/javascript">
            function run_transaction(btn_k,btn_el,post_fields){
                var data1   = {action: "use_method",method:btn_k};
                var data2   = $(btn_el).attr("data-fields");

                if(typeof data2 == "undefined") data2 = {};
                if(typeof data2 !== 'object' && data2 !== undefined && data2.length > 0) data2 = getJson(data2);
                if(typeof data2 !== 'object' || data2 === undefined || data2 === false) data2 = {};
                var data3   = post_fields === undefined || post_fields === false ? {} : post_fields;
                let _data   = Object.assign(data1,data2,data3);

                var icon_w  = false;

                if(btn_el !== undefined && $("i",btn_el).length > 0) icon_w = true;

                var request = MioAjax({
                    button_element:btn_el,
                    waiting_text: icon_w ? '<?php echo __("website/others/button2-pending"); ?>' : '<?php echo __("website/others/button1-pending"); ?>',
                    action:"<?php echo $links["controller"]; ?>",
                    method:"POST",
                    data:_data,
                },true,true);
                request.done(t_form_handle);
            }
            function reload_module_content(page){
                if(page === undefined) page = "<?php echo isset($m_page) ? $m_page : false; ?>";
                else $("#block_module_details_con").html($("#template-loader").html());

                if(page !== ''){
                    window.history.pushState("object or string", $("title").html(),'<?php echo $links["controller"]; ?>?m_page='+page);
                }

                var request = MioAjax({
                    action:"<?php echo $links["controller"]; ?>",
                    method:"POST",
                    data:{
                        action:        "get_details",
                        m_page:     page,
                    },
                },true,true);

                request.done(function(result){
                    if(result !== ''){
                        $("#block_module_details_con").html(result);
                    }
                });
            }
            function t_form_handle(result){
                if(result !== ''){
                    var solve = getJson(result);
                    if(solve !== false){
                        if(solve.status === "error"){
                            alert_error(solve.message,{timer:3000});
                        }
                        else if(solve.status === "successful"){
                            alert_success(solve.message,{timer:3000});
                        }
                        if(solve.timeRedirect !== undefined){
                            setTimeout(function(){
                                window.location.href = solve.timeRedirect.url === undefined ? location.href : solve.timeRedirect.url;
                            },solve.timeRedirect.duration);
                        }
                        else if(solve.redirect !== undefined){
                            window.location.href = solve.redirect;
                        }
                        if(solve.javascript_code) eval(solve.javascript_code);
                    }else
                        console.log(result);
                }
            }

            $(document).ready(function(){
                $("#block_module_details_con").html($("#template-loader").html());
                setTimeout(reload_module_content,500);
            });
        </script>
        <?php
    }
?>
<div class="mpanelrightcon">

    <div class="mpaneltitle">
        <div class="sayfayolu"><?php include $tpath."inc".DS."panel-breadcrumb.php"; ?></div>
        <h4><strong><i class="fa fa-cube" aria-hidden="true"></i> <?php echo $proanse["name"]; ?></strong></h4>
    </div>


    <ul class="tab">
        <li><a href="javascript:void(0)" class="tablinks" onclick="openTab(this, 'ozet')" data-tab="1"><i class="fa fa-info" aria-hidden="true"></i> <?php echo __("website/account_products/detail"); ?></a></li>

        <li><a href="javascript:void(0)" class="tablinks" onclick="openTab(this, 'addons')" data-tab="addons"><i class="fa fa-rocket" aria-hidden="true"></i> <?php echo __("website/account_products/tab-addons"); ?></a></li>

        <?php if(isset($requirements) && $requirements): ?>
            <li><a href="javascript:void(0)" class="tablinks" onclick="openTab(this, 'requirements')" data-tab="requirements"><i class="fa fa-check-square" aria-hidden="true"></i> <?php echo __("website/account_products/tab-requirements"); ?></a></li>
        <?php endif; ?>

        <?php if($proanse["status"] == "active" && $proanse["period"] != "none" && $upgrade): ?>
            <li><a href="javascript:void(0)" class="tablinks" onclick="openTab(this, 'upgrade')" data-tab="upgrade"><i class="ion-speedometer" aria-hidden="true"></i> <?php echo __("website/account_products/special-tab-upgrade"); ?></a></li>
        <?php endif; ?>

        <?php if($proanse["status"] == "active" && $ctoc_service_transfer): ?>
            <li><a href="javascript:void(0)" class="tablinks" onclick="openTab(this, 'transfer-service')" data-tab="transfer-service"><i class="fa fa-exchange" aria-hidden="true"></i> <?php echo __("website/account_products/transfer-service"); ?></a></li>
        <?php endif; ?>

        <?php if($proanse["status"] == "active" && $proanse["period"] != "none"): ?>
            <li><a href="javascript:void(0)" class="tablinks" onclick="openTab(this, 'iptaltalebi')" data-tab="cancellation"><i class="fa fa-ban" aria-hidden="true"></i> <?php echo __("website/account_products/cancellation-request"); ?></a></li>
        <?php endif; ?>

        <div class="orderidno"><span><?php echo __("website/account_products/table-ordernum"); ?></span><strong>#<?php echo $proanse["id"]; ?></strong></div>
    </ul>


    <div id="ozet" class="tabcontent">

        <div<?php echo isset($module) && $module ? ' id="block_modulewidth50"' : ''; ?> class="hizmetblok">

            <div class="cpanelebmail">
                <?php if(isset($options["product_image"]) && $options["product_image"]): ?>
                    <img style="  max-height: 90px;width:auto;" src="<?php echo $options["product_image"]; ?>" width="200" height="auto">
                <?php else: ?>
                    <i style="font-size:100px;" class="fa fa-rocket"></i>
                <?php endif; ?>

                <?php
                    if(isset($options["domain"]) && $options["domain"]){
                        ?>
                        <h4><strong><?php echo $options["domain"]; ?></strong></h4>
                        <?php
                    }

                    if(isset($options["ip"]) && $options["ip"]){
                        ?>
                        <h4><strong><?php echo $options["ip"]; ?></strong></h4>
                        <?php
                    }
                ?>

                <?php
                    if(isset($options["delivery_title_name"]) && isset($options["delivery_title_description"]) && $options["delivery_title_name"] && $options["delivery_title_description"]){
                        ?>
                        <H5><br><strong><?php echo $options["delivery_title_name"]; ?></strong><br><?php echo $options["delivery_title_description"]; ?></H5>
                        <?php
                    }elseif(isset($options["delivery_title_name"]) && $options["delivery_title_name"]){
                        ?>
                        <H5><strong><?php echo $options["delivery_title_name"]; ?></strong></H5>
                        <?php
                    }elseif(isset($options["delivery_title_description"]) && $options["delivery_title_description"]){
                        ?>
                        <H5><?php echo $options["delivery_title_description"]; ?></H5>
                        <?php
                    }

                    if(isset($options["delivery_file_button_title"]) && isset($download_link) && $options["delivery_file_button_title"] && $download_link){
                        ?>
                        <a<?php echo $proanse["status"] != "active" ? "" : ' href="'.$download_link.'"'; ?> class="<?php echo $proanse["status"] != "active" ? "graybtn" : "yesilbtn"; ?> gonderbtn"><?php echo $options["delivery_file_button_title"]; ?></a>
                        <?php
                    }elseif(isset($download_link) && $download_link != ''){
                        ?>
                        <a <?php echo $proanse["status"] != "active" ? "" : 'href="'.$download_link.'"'; ?> class="<?php echo $proanse["status"] != "active" ? "graybtn" : "yesilbtn"; ?> gonderbtn"><?php echo __("website/account_products/download-button"); ?></a>
                        <?php
                    }
                ?>

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
                           class="mavibtn gonderbtn"><?php echo __("website/account_products/renewal-now-button"); ?></a>
                        <div class="clear"></div>
                        <?php
                    }
                ?>

            </div>
        </div>

        <div<?php echo isset($module) && $module ? ' id="block_modulewidth50"' : ''; ?> class="hizmetblok">
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

                <?php if(substr($proanse["renewaldate"],0,4) != "1881" && substr($proanse["renewaldate"],0,4) != "1970"): ?>
                    <tr>
                        <td><strong><?php echo __("website/account_products/renewal-date"); ?></strong></td>
                        <td><?php echo DateManager::format(Config::get("options/date-format"),$proanse["renewaldate"]); ?></td>
                    </tr>
                <?php endif; ?>

                <?php if(substr($proanse["duedate"],0,4) != "1881" && substr($proanse["duedate"],0,4) != "1970"): ?>
                    <tr>
                        <td><strong><?php echo __("website/account_products/due-date"); ?></strong></td>
                        <td><?php echo DateManager::format(Config::get("options/date-format"),$proanse["duedate"]); ?></td>
                    </tr>
                <?php endif; ?>

                <tr align="center" class="tutartd">
                    <td colspan="2"><strong><?php echo __("website/account_products/amount"); ?> : <?php echo $proanse_amount; ?></strong></td>
                </tr>
            </table>

        </div>

        <?php
            if(isset($module) && $module){
                ?>
                <div class="clear"></div>

                <div class="block_module_details" id="get_details_module_content">
                    <div class="hizmetblok" id="block_module_details_con"></div>
                </div>

                <div class="clear"></div>
                <?php
            }
        ?>


        <?php
            if(isset($options["blocks"]) && $options["blocks"]){
                foreach($options["blocks"] AS $block){
                    ?>
                    <div class="hizmetblok block-item">
                        <div class="block_module_details-title formcon"><h4><?php echo $block["title"]; ?></h4></div>
                        <div class="block-item-desc"><div class="padding10"><?php echo Filter::link_convert(nl2br($block["description"])); ?></div></div>
                    </div>
                    <?php
                }
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

    <?php if($proanse["status"] == "active" && $proanse["period"] != "none" && $upgrade): ?>
        <div id="upgrade" class="tabcontent">

            <div class="tabcontentcon content-updown">

                <div class="green-info" style="margin-bottom:25px;">
                    <div class="padding20">
                        <i class="ion-speedometer" aria-hidden="true"></i>
                        <?php echo __("website/account_products/special-upgrade-info"); ?>
                    </div>
                </div>

                <div class="formcon">
                    <div class="yuzde30" style="vertical-align:top;"><?php echo __("website/account_products/upgrade-order-statistics"); ?>
                        <div class="clear"></div>
                        <span class="kinfo"><?php echo __("website/account_products/upgrade-order-statistics-info"); ?></span>
                    </div>
                    <div class="yuzde70">

                        <div class="yuzde50" style="vertical-align:top;">

                            <div class="formcon">
                                <span><?php echo __("website/account_products/upgrade-product-name"); ?>:</span>
                                <strong><?php echo $proanse["name"]; ?></strong>
                            </div>

                            <div class="formcon">
                                <span><?php echo __("website/account_products/upgrade-renewaldate"); ?>:</span>
                                <strong> <?php echo DateManager::format(Config::get("options/date-format"),$proanse["renewaldate"]); ?></strong>
                            </div>

                            <div class="formcon">
                                <span><?php echo __("website/account_products/upgrade-duedate"); ?>:</span>
                                <strong><?php echo DateManager::format(Config::get("options/date-format"),$proanse["duedate"]); ?>     </strong>
                            </div>


                            <div class="formcon">
                                <span><?php echo __("website/account_products/upgrade-times-used"); ?>:</span>
                                <strong> <?php echo $upgrade_times_used ." ". ___("date/day"); ?></strong> <!-- <?php echo $upgrade_times_used_amount; ?> -->
                            </div>

                            <div class="formcon">
                                <span><?php echo __("website/account_products/upgrade-remaining-day"); ?>:</span>
                                <strong><?php echo $upgrade_remaining_day ." ". ___("date/day"); ?></strong> <!--<?php echo $upgrade_remaining_amount; ?>-->
                            </div>

                        </div>

                    </div>
                </div>


                <?php if(isset($upgproducts) && $upgproducts["categories"]): ?>

                    <div id="upgradeConfirm" data-izimodal-title="<?php echo __("website/account_products/special-tab-upgrade"); ?>" style="display: none">
                        <div class="padding20">
                            <div align="center">
                                <span id="upgradeConfirm_text"></span>

                                <div class="clear"></div><div class="line"></div>

                                <a style="float:none" href="javascript:void(0);" id="upgradeConfirm_ok" class="gonderbtn yesilbtn"><i class="fa fa-check"></i> <?php echo ___("needs/iconfirm"); ?></a>
                                <div class="clear"></div>

                            </div>

                        </div>

                    </div>

                    <script type="text/javascript">
                        function selected_category(id){
                            $(".upgrade-products").fadeOut(300);
                            $("#category_"+id).fadeIn(300);
                        }

                        function upgradeProduct(id){
                            var selectedPrice = $("#product_"+id+"_price").val();
                            var name          = $("#product_"+id+"_name").val();
                            var payable       = $("#product_"+id+"_price option:selected").data("payable");

                            open_modal("upgradeConfirm");

                            var confirm_text = '<?php echo str_replace("\n","<br>",__("website/account_products/special-upgrade-confirm-text")); ?>';
                            confirm_text     = confirm_text.replace("{name}",name);
                            confirm_text     = confirm_text.replace("{payable}",payable);

                            $("#upgradeConfirm_text").html(confirm_text);

                            $("#upgradeConfirm_ok").on("click",function(){

                                var request       = MioAjax({
                                    button_element:$("#upgradeConfirm_ok"),
                                    waiting_text: '<?php echo addslashes(__("website/others/button5-pending")); ?>',
                                    action:"<?php echo $links["controller"]; ?>",
                                    method:"POST",
                                    data:{operation:"set_upgrade_product",product_id:id,pirce_id:selectedPrice},
                                },true,true);

                                request.done(function(result){
                                    if(result != ''){
                                        var solve = getJson(result);
                                        if(solve !== false){
                                            if(solve.status == "error"){
                                                if(solve.message != undefined && solve.message != '')
                                                    alert_error(solve.message,{timer:5000});
                                            }else if(solve.status == "successful"){
                                                if(solve.message != undefined) alert_success(solve.message,{timer:2000});
                                                if(solve.redirect != undefined && solve.redirect != ''){
                                                    window.location.href = solve.redirect;
                                                }
                                            }
                                        }else
                                            console.log(result);
                                    }
                                });

                            });

                        }

                        $(document).ready(function(){
                            <?php
                            if($upgproducts["categories"]){
                            $keys = array_keys($upgproducts["categories"]);
                            ?>$('#upgrade_selected_product option[value=<?php echo $keys[0]; ?>]').attr("selected",true).trigger("change");<?php
                            }
                            ?>
                        });
                    </script>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("website/account_products/upgrade-select-packages"); ?>
                            <div class="clear"></div>
                        </div>
                        <div class="yuzde70">
                            <select name="product" id="upgrade_selected_product" onchange="selected_category(this.options[this.selectedIndex].value);">
                                <?php
                                    if(isset($upgproducts) && $upgproducts){
                                        if($upgproducts["categories"]){
                                            foreach($upgproducts["categories"] AS $caid=>$val){
                                                ?>
                                                <option value="<?php echo $caid; ?>"><?php echo $val["title"]; ?></option>
                                                <?php
                                            }
                                        }
                                    }
                                ?>
                            </select>

                        </div>
                    </div>

                    <div class="tablopaketler" style="background: none;">

                        <?php
                            foreach($upgproducts["categories"] AS $caid=>$cat){
                                $products   = isset($upgproducts["products"][$caid]) ? $upgproducts["products"][$caid] : false;
                                $cat["options"]     = Utility::jdecode($cat["options"],true);
                                $cat["optionsl"]    = Utility::jdecode($cat["optionsl"],true);

                                if(isset($cat["optionsl"]["columns"]))
                                    $columns = $cat["optionsl"]["columns"];
                                else
                                    $columns = [];

                                ?>

                                <div id="category_<?php echo $caid; ?>" style="display:none;" class="upgrade-products">
                                    <?php
                                        foreach($products AS $product){
                                            $prices     = $upgproducts["prices"][$product["id"]];

                                            $opt  = Utility::jdecode($product["options"],true);
                                            $optl = Utility::jdecode($product["options_lang"],true);
                                            $isCurrent = $product["id"] == $proanse["product_id"];
                                            if($isCurrent) continue;

                                            $popular            = false;

                                            if(isset($opt["popular"]) && $opt["popular"]) $popular = true;

                                            ?>
                                            <div class="tablepaket<?php echo $popular ? ' active' : '' ?>">
                                                <?php
                                                    if($popular){
                                                        ?>
                                                        <div class="tablepopular"><?php echo __("website/products/popular"); ?></div>
                                                        <?php
                                                    }
                                                ?>
                                                <div class="tpakettitle"><?php echo $product["title"]; ?></div>
                                                <div class="paketline"></div>
                                                <div class="clear"></div>
                                                <div class="products_features">
                                                    <?php
                                                        $json       = Utility::jdecode($product["features"],true);
                                                        if($json){
                                                            if(isset($columns) && $columns){
                                                                foreach($columns AS $column){
                                                                    $val = isset($json[$column["id"]]) ? $json[$column["id"]] : NULL;
                                                                    if($val != NULL){
                                                                        ?><span><?php echo $column["name"]." <strong>".$val."</strong>"; ?></span><?php
                                                                    }
                                                                }
                                                            }
                                                        }else{
                                                            $features = ($product["features"]) ? explode("\n",$product["features"]) : [];
                                                            foreach($features AS $fea){
                                                                ?><span><?php echo $fea; ?></span><?php
                                                            }
                                                        }

                                                        if($features){
                                                            ?>
                                                            <div class="paketline"></div>
                                                            <?php
                                                        }
                                                    ?>
                                                </div>
                                                <div class="clear"></div>

                                                <input type="hidden" id="product_<?php echo $product["id"]; ?>_name" value="<?php echo $product["title"]; ?>">
                                                <select id="product_<?php echo $product["id"]; ?>_price">
                                                    <?php
                                                        foreach($prices AS $k=>$price){

                                                            if($foreign_user) $payable =$price["payable"];
                                                            else $payable = $price["taxed_payable"];
                                                            $payable = Money::formatter_symbol($payable,$price["cid"]);

                                                            if($price["amount"]>0){
                                                                $amount     = Money::formatter_symbol($price["amount"],$price["cid"],!$product["override_usrcurrency"]);
                                                                $period = View::period($price["time"],$price["period"]);
                                                            }else{
                                                                $amount = ___("needs/free-amount");
                                                                $period = NULL;
                                                            }
                                                            $show_price = $amount;
                                                            if($period) $show_price .= " (".$period.")";
                                                            ?>
                                                            <option value="<?php echo $k; ?>" data-payable="<?php echo $payable; ?>"><?php echo $show_price; ?></option>
                                                            <?php
                                                        }
                                                    ?>
                                                </select>
                                                <?php if($product["haveStock"]): ?>
                                                    <a href="javascript:upgradeProduct(<?php echo $product["id"]; ?>);void 0;" class="gonderbtn" id="product_upgrade_<?php echo $product["id"]; ?>"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <?php echo __("website/account_products/button-upgrade"); ?></a>
                                                <?php else: ?>
                                                    <a id="sunucutukenbtn" class="gonderbtn"><i class="fa fa-ban" aria-hidden="true"></i> <?php echo __("website/products/out-of-stock2"); ?></a>
                                                <?php endif; ?>
                                            </div>
                                            <?php
                                        }
                                    ?>
                                </div>
                                <?php
                            }
                        ?>

                    </div>

                <?php else: ?>
                    <div class="clear"></div>
                    <div id="upgrade-product-none">
                        <?php echo __("website/account_products/ugrade-product-none"); ?>
                    </div>
                <?php endif; ?>

            </div>

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
                    <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                    <h4><?php echo __("website/account_products/canceled-sent"); ?></h4>
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