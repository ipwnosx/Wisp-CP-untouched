<?php
    Helper::Load("Money");
    $pservices = $coupon["pservices"] ? explode(",",$coupon["pservices"]) : [];
?>
<!DOCTYPE html>
<html>
<head>
    <?php
        $plugins    = ['jquery-ui','voucher_codes'];
        include __DIR__.DS."inc".DS."head.php";
    ?>

    <script type="text/javascript">
        $(document).ready(function(){

            $("#editForm").bind("keypress", function(e) {
                if (e.keyCode == 13) $("#editForm_submit").click();
            });

            $("#editForm_submit").on("click",function(){
                MioAjaxElement($(this),{
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                    result:"editForm_handler",
                });
            });

        });

        function editForm_handler(result){
            if(result != ''){
                var solve = getJson(result);
                if(solve !== false){
                    if(solve.status == "error"){
                        if(solve.for != undefined && solve.for != ''){
                            $("#editForm "+solve.for).focus();
                            $("#editForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                            $("#editForm "+solve.for).change(function(){
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
    </script>

</head>
<body>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1><strong><?php echo __("admin/financial/page-edit-coupon"); ?></strong></h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="clear"></div>

            <div class="adminuyedetay">

                <form action="<?php echo $links["controller"]; ?>" method="post" id="editForm">
                    <input type="hidden" name="operation" value="edit_coupon">
                    <input type="hidden" name="id" value="<?php echo $coupon["id"]; ?>">

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/financial/new-coupon-code"); ?></div>
                        <div class="yuzde70">
                            <input type="text"  name="code" value="<?php echo $coupon["code"]; ?>" style="width: 150px;">
                            <a href="javascript:$('input[name=code]').val(voucher_codes.generate({length:6,charset: '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'}));void 0;" class="lbtn"><i class="fa fa-refresh"></i> <?php echo __("admin/financial/refrefsh-coupon-code"); ?></a>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/financial/new-coupon-type"); ?></div>
                        <div class="yuzde70">

                            <input<?php echo $coupon["type"] == "percentage" ? ' checked' : ''; ?> type="radio" class="radio-custom" name="type" value="percentage" id="type_percentage" onclick="$('input[name=amount]').val(''),$('.new-type-content').fadeOut(1,function(){$('.percentage-content').fadeIn(1);});">
                            <label for="type_percentage" class="radio-custom-label" style="margin-right:15px;"><?php echo __("admin/financial/new-coupon-type-percentage"); ?></label>

                            <input<?php echo $coupon["type"] == "amount" ? ' checked' : ''; ?> type="radio" class="radio-custom" name="type" value="amount" id="type_amount" onclick="$('input[name=rate]').val(''),$('.new-type-content').fadeOut(1,function(){$('.amount-content').fadeIn(1);});">
                            <label for="type_amount" class="radio-custom-label" style="margin-right:15px;"><?php echo __("admin/financial/new-coupon-type-amount"); ?></label>

                        </div>
                    </div>

                    <div class="formcon percentage-content new-type-content"<?php echo $coupon["type"] != "percentage" ? ' style="display: none;"' : ''; ?>>
                        <div class="yuzde30"><?php echo __("admin/financial/new-coupon-percentage-rate"); ?></div>
                        <div class="yuzde70">
                            <input type="text" name="rate" class="yuzde15" value="<?php echo $coupon["rate"]; ?>">
                            <span style="line-height: 45px;    font-weight: bold;    font-size: 18px;">%</span>
                        </div>
                    </div>

                    <div class="formcon amount-content new-type-content"<?php echo $coupon["type"] != "amount" ? ' style="display: none;"' : ''; ?>>
                        <div class="yuzde30"><?php echo __("admin/financial/new-coupon-select-amount"); ?></div>
                        <div class="yuzde70">
                            <input type="text" name="amount" class="yuzde15" value="<?php echo Money::formatter($coupon["amount"],$coupon["currency"]); ?>" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57'>
                            <select name="cid" class="width200">
                                <?php
                                    $currencies = Money::getCurrencies($coupon["currency"]);
                                    foreach ($currencies AS $currencyx){
                                        $checked = $currencyx["id"] == $coupon["currency"];
                                        ?>
                                        <option<?php echo $checked ? ' selected' : ''; ?> value="<?php echo $currencyx["id"]; ?>"><?php echo $currencyx["name"]." - ".$currencyx["code"]; ?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/financial/new-coupon-pservices"); ?></div>
                        <div class="yuzde70">
                            <select name="pservices[]" multiple style="height: 250px;">

                                <?php if(Config::get("options/pg-activation/hosting")): ?>
                                    <option<?php echo in_array("allOf/hosting",$pservices) ? ' selected' : ''; ?> value="allOf/hosting" style="font-weight: bold;"><?php echo __("admin/financial/new-coupon-product-group-hosting"); ?></option>
                                    <?php
                                    $line   = "";
                                    $products   = $functions["get_category_products"]("hosting","0");
                                    if($products){
                                        foreach ($products as $product) {
                                            ?>
                                            <option<?php echo in_array("product/hosting/0/".$product["id"],$pservices) ? ' selected' : ''; ?> value="product/hosting/0/<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                            <?php
                                        }
                                    }

                                    $get_pcategories = $functions["get_product_categories"]("products","hosting");
                                    if($get_pcategories){
                                        foreach($get_pcategories AS $row){
                                            ?>
                                            <option<?php echo in_array("category/hosting/".$row["id"],$pservices) ? ' selected' : ''; ?> value="category/hosting/<?php echo $row["id"]; ?>"><?php echo $row["title"]; ?></option>
                                            <?php
                                            preg_match('/\-+[- ]/',$row["title"],$match);
                                            $line   = rtrim($match[0]);
                                            $products   = $functions["get_category_products"]("hosting",$row["id"]);
                                            if($products){
                                                foreach ($products as $product) {
                                                    ?>
                                                    <option<?php echo in_array("product/hosting/".$row["id"]."/".$product["id"],$pservices) ? ' selected' : ''; ?> value="product/hosting/<?php echo $row["id"]; ?>/<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                                    <?php
                                                }
                                            }

                                        }
                                    }
                                    ?>
                                <?php endif; ?>

                                <?php if(Config::get("options/pg-activation/server")): ?>
                                    <option<?php echo in_array("allOf/server",$pservices) ? ' selected' : ''; ?> value="allOf/server" style="font-weight: bold;"><?php echo __("admin/financial/new-coupon-product-group-server"); ?></option>
                                    <?php
                                    $line   = "";
                                    $products   = $functions["get_category_products"]("server","0");
                                    if($products){
                                        foreach ($products as $product) {
                                            ?>
                                            <option<?php echo in_array("product/server/0/".$product["id"],$pservices) ? ' selected' : ''; ?> value="product/server/0/<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                            <?php
                                        }
                                    }

                                    $get_pcategories = $functions["get_product_categories"]("products","server");
                                    if($get_pcategories){
                                        foreach($get_pcategories AS $row){
                                            ?>
                                            <option<?php echo in_array("category/server/".$row["id"],$pservices) ? ' selected' : ''; ?> value="category/server/<?php echo $row["id"]; ?>"><?php echo $row["title"]; ?></option>
                                            <?php
                                            preg_match('/\-+[- ]/',$row["title"],$match);
                                            $line   = rtrim($match[0]);
                                            $products   = $functions["get_category_products"]("server",$row["id"]);
                                            if($products){
                                                foreach ($products as $product) {
                                                    ?>
                                                    <option<?php echo in_array("product/server/".$row["id"]."/".$product["id"],$pservices) ? ' selected' : ''; ?> value="product/server/<?php echo $row["id"]; ?>/<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                                    <?php
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                <?php endif; ?>

                                <?php if(Config::get("options/pg-activation/software")): ?>
                                    <option<?php echo in_array("allOf/software",$pservices) ? ' selected' : ''; ?> value="allOf/software" style="font-weight: bold;"><?php echo __("admin/financial/new-coupon-product-group-softwares"); ?></option>
                                    <?php
                                    $line = "";
                                    $products   = $functions["get_category_products"]("software","0");
                                    if($products){
                                        foreach ($products as $product) {
                                            ?>
                                            <option<?php echo in_array("product/software/0/".$product["id"],$pservices) ? ' selected' : ''; ?> value="product/software/0/<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                            <?php
                                        }
                                    }

                                    $get_pcategories = $functions["get_product_categories"]("softwares");
                                    if($get_pcategories){
                                        foreach($get_pcategories AS $row){
                                            ?>
                                            <option<?php echo in_array("category/software/".$row["id"],$pservices) ? ' selected' : ''; ?> value="category/software/<?php echo $row["id"]; ?>"><?php echo " - ".$row["title"]; ?></option>
                                            <?php
                                            $line = "-";
                                            $products   = $functions["get_category_products"]("software",$row["id"]);
                                            if($products){
                                                foreach ($products as $product) {
                                                    ?>
                                                    <option<?php echo in_array("product/software/".$row["id"]."/".$product["id"],$pservices) ? ' selected' : ''; ?> value="product/software/<?php echo $row["id"]; ?>/<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                                    <?php
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                <?php endif; ?>

                                <?php if(Config::get("general/local")=="tr" && Config::get("options/pg-activation/sms")): ?>
                                    <option<?php echo in_array("allOf/sms",$pservices) ? ' selected' : ''; ?> value="allOf/sms"  style="font-weight: bold;"><?php echo __("admin/financial/new-coupon-product-group-sms"); ?></option>
                                    <?php
                                    $line   = "";
                                    $products   = $functions["get_category_products"]("sms",0);
                                    if($products){
                                        foreach ($products as $product) {
                                            ?>
                                            <option<?php echo in_array("product/sms/0/".$product["id"],$pservices) ? ' selected' : ''; ?> value="product/sms/0/<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                <?php endif; ?>

                                <?php
                                    $pspecialGroups = $functions["get_special_pgroups"]();
                                    if($pspecialGroups){
                                        foreach($pspecialGroups AS $category){
                                            ?>
                                            <option<?php echo in_array("allOf/special/".$category["id"],$pservices) ? ' selected' : ''; ?> value="allOf/special/<?php echo $category["id"]; ?>" style="font-weight: bold;"><?php echo $category["title"]; ?></option>
                                            <?php
                                            preg_match('/\-+[- ]/',$category["title"],$match);
                                            $line   = isset($match[0]) ? rtrim($match[0]) : '';
                                            $products   = $functions["get_category_products"]("special",$category["id"]);
                                            if($products){
                                                foreach ($products as $product) {
                                                    ?>
                                                    <option<?php echo in_array("product/special/".$category["id"]."/".$product["id"],$pservices) ? ' selected' : ''; ?> value="product/special/<?php echo $category["id"]; ?>/<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                                    <?php
                                                }
                                            }
                                            $get_pcategories = $functions["get_product_categories"]("products","special",$category["id"]);
                                            if($get_pcategories){
                                                foreach($get_pcategories AS $row){
                                                    ?>
                                                    <option<?php echo in_array("category/special/".$category["id"]."/".$row["id"],$pservices) ? ' selected' : ''; ?> value="category/special/<?php echo $category["id"]; ?>/<?php echo $row["id"]; ?>"><?php echo $row["title"]; ?></option>
                                                    <?php
                                                    preg_match('/\-+[- ]/',$row["title"],$match);
                                                    $line   = rtrim($match[0]);
                                                    $products   = $functions["get_category_products"]("special",$row["id"]);
                                                    if($products){
                                                        foreach ($products as $product) {
                                                            ?>
                                                            <option<?php echo in_array("product/special/".$category["id"]."/".$product["id"],$pservices) ? ' selected' : ''; ?> value="product/special/<?php echo $category["id"]; ?>/<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                ?>

                                <?php if(Config::get("options/pg-activation/domain")): ?>
                                    <option<?php echo in_array("allOf/domain",$pservices) ? ' selected' : ''; ?> value="allOf/domain" style="font-weight: bold;"><?php echo __("admin/financial/new-coupon-product-domain"); ?></option>
                                    <?php
                                    $tlds   = $functions["get_tlds"];
                                    $tlds   = $tlds();
                                    if($tlds){
                                        foreach($tlds AS $tld){
                                            ?>
                                            <option<?php echo in_array("product/domain/0/".$tld["id"],$pservices) ? ' selected' : ''; ?> value="product/domain/0/<?php echo $tld["id"]; ?>">» <?php echo $tld["name"]; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                <?php endif; ?>

                            </select>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/financial/select-period-coupon"); ?></div>
                        <div class="yuzde70">
                            <input class="yuzde15" name="period_duration" type="text" placeholder="<?php echo __("admin/orders/detail-pricing-period"); ?>" value="<?php echo $coupon["period_duration"]; ?>">
                            <select class="yuzde15" name="period_type">
                                <option value=""><?php echo ___("needs/none"); ?></option>
                                <?php
                                    foreach(___("date/periods") AS $k=>$v){
                                        ?>
                                        <option<?php echo $coupon['period_type'] == $k ? ' selected' : ''; ?> value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                            <div class="clear"></div>
                            <span class="kinfo"><?php echo __("admin/financial/select-period-coupon-desc"); ?></span>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/financial/new-coupon-due-date"); ?></div>
                        <div class="yuzde70">
                            <input type="date" name="duedate" id="duedate" style="width:150px;" placeholder="YYYY-MM-DD" value="<?php echo $coupon["duedate"] == "1881-05-19 00:00:00" ? '' : DateManager::format("Y-m-d",$coupon["duedate"]); ?>">
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/financial/new-coupon-maxuses"); ?></div>
                        <div class="yuzde70">
                            <input type="text" name="maxuses" style="width: 50px;" value="<?php echo $coupon["maxuses"] == 0 ? '' : $coupon["maxuses"]; ?>">
                            <span class="kinfo"><?php echo __("admin/financial/new-coupon-maxuses-desc"); ?></span>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/financial/coupon-untaxed"); ?></div>
                        <div class="yuzde70">
                            <input<?php echo $coupon["taxfree"] ? ' checked' : ''; ?> type="checkbox" class="checkbox-custom" name="taxfree" id="coupon-untaxed" value="1">
                            <label for="coupon-untaxed" class="checkbox-custom-label kinfo"><?php echo __("admin/financial/coupon-untaxed-desc"); ?></label>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/financial/new-coupon-applyonce"); ?></div>
                        <div class="yuzde70">
                            <input<?php echo $coupon["applyonce"] ? ' checked' : ''; ?> type="checkbox" class="checkbox-custom" name="applyonce" id="applyonce" value="1">
                            <label for="applyonce" class="checkbox-custom-label kinfo"><?php echo __("admin/financial/new-coupon-applyonce-desc"); ?></label>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/financial/new-coupon-newsignups"); ?></div>
                        <div class="yuzde70">
                            <input<?php echo $coupon["newsignups"] ? ' checked' : ''; ?> type="checkbox" class="checkbox-custom" name="newsignups" id="newsignups" onchange="if($(this).prop('checked')) $('#existingcustomer').prop('checked',false);" value="1">
                            <label for="newsignups" class="checkbox-custom-label kinfo"><?php echo __("admin/financial/new-coupon-newsignups-desc"); ?></label>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/financial/new-coupon-existingcustomer"); ?></div>
                        <div class="yuzde70">
                            <input<?php echo $coupon["existingcustomer"] ? ' checked' : ''; ?> type="checkbox" class="checkbox-custom" name="existingcustomer" id="existingcustomer" onchange="if($(this).prop('checked')) $('#newsignups').prop('checked',false);" value="1">
                            <label for="existingcustomer" class="checkbox-custom-label kinfo"><?php echo __("admin/financial/new-coupon-existingcustomer-desc"); ?></label>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/financial/new-coupon-dealership"); ?></div>
                        <div class="yuzde70">
                            <input<?php echo $coupon["dealership"] ? ' checked' : ''; ?> type="checkbox" class="checkbox-custom" name="dealership" id="dealership" value="1">
                            <label for="dealership" class="checkbox-custom-label kinfo"><?php echo __("admin/financial/new-coupon-dealership-desc"); ?></label>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/financial/new-coupon-use-merge"); ?></div>
                        <div class="yuzde70">
                            <input<?php echo $coupon["use_merge"] ? ' checked' : ''; ?> type="checkbox" class="checkbox-custom" name="use_merge" id="use_merge" value="1">
                            <label for="use_merge" class="checkbox-custom-label kinfo"><?php echo __("admin/financial/new-coupon-use-merge-desc"); ?></label>
                        </div>
                    </div>


                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/financial/new-coupon-notes"); ?></div>
                        <div class="yuzde70">
                            <textarea name="notes"><?php echo $coupon["notes"]; ?></textarea>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/financial/new-coupon-status"); ?></div>
                        <div class="yuzde70">
                            <input<?php echo $coupon["status"] == "active" ? ' checked' : ''; ?> type="checkbox" class="sitemio-checkbox" name="status" id="status" value="1">
                            <label for="status" class="sitemio-checkbox-label"></label>
                            <span class="kinfo"><?php echo __("admin/financial/new-coupon-status-desc"); ?></span>
                        </div>
                    </div>


                    <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                        <a class="yesilbtn gonderbtn" id="editForm_submit" href="javascript:void(0);"><?php echo __("admin/financial/edit-coupon-button"); ?></a>
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