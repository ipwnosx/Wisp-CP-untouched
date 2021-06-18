<?php
    Helper::Load("Money");
    $primary_product = $promotion["primary_product"] ? explode(",",$promotion["primary_product"]) : [];
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
                <h1><strong><?php echo __("admin/financial/page-edit-promotion"); ?></strong></h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="clear"></div>

            <div class="adminuyedetay">

                <form action="<?php echo $links["controller"]; ?>" method="post" id="editForm">
                    <input type="hidden" name="operation" value="edit_promotion">
                    <input type="hidden" name="id" value="<?php echo $promotion["id"]; ?>">

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/financial/new-promotion-name"); ?></div>
                        <div class="yuzde70">
                            <input type="text" name="name" value="<?php echo $promotion["name"]; ?>">
                        </div>
                    </div>


                    <div class="biggroup">
                    <div class="padding20">
                    <h4 class="biggrouptitle"><?php echo __("admin/financial/promotion-groupname1"); ?></h4>
                    
                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/financial/new-promotion-product"); ?></div>
                        <div class="yuzde70">
                            <select name="primary_product[]" multiple size="10">
                                <?php
                                    if(Config::get("options/pg-activation/hosting")){
                                        ?>
                                        <option<?php echo in_array("allOf/hosting",$primary_product) ? ' selected' : ''; ?> value="allOf/hosting" style="font-weight: bold;"><?php echo __("admin/financial/new-coupon-product-group-hosting"); ?></option>
                                        <?php
                                        $line   = "";
                                        $products   = $functions["get_category_products"]("hosting",0);
                                        if($products){
                                            foreach ($products as $product) {
                                                ?>
                                                <option<?php echo in_array("product/hosting/0/".$product["id"],$primary_product) ? ' selected' : ''; ?> value="product/hosting/0/<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                                <?php
                                            }
                                        }

                                        $get_pcategories = $functions["get_product_categories"]("products","hosting");
                                        if($get_pcategories){
                                            foreach($get_pcategories AS $row){
                                                ?>
                                                <option<?php echo in_array("category/hosting/".$row["id"],$primary_product) ? ' selected' : ''; ?> value="category/hosting/<?php echo $row["id"]; ?>"><?php echo $row["title"]; ?></option>
                                                <?php
                                                preg_match('/\-+[- ]/',$row["title"],$match);
                                                $line   = rtrim($match[0]);
                                                $products   = $functions["get_category_products"]("hosting",$row["id"]);
                                                if($products){
                                                    foreach ($products as $product) {
                                                        ?>
                                                        <option<?php echo in_array("product/hosting/".$row["id"]."/".$product["id"],$primary_product) ? ' selected' : ''; ?> value="product/hosting/<?php echo $row["id"]; ?>/<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                                        <?php
                                                    }
                                                }

                                            }
                                        }
                                    }
                                    if(Config::get("options/pg-activation/server")){
                                        ?>
                                        <option<?php echo in_array("allOf/server",$primary_product) ? ' selected' : ''; ?> value="allOf/server" style="font-weight: bold;"><?php echo __("admin/financial/new-coupon-product-group-server"); ?></option>
                                        <?php
                                        $line   = "";
                                        $products   = $functions["get_category_products"]("server","0");
                                        if($products){
                                            foreach ($products as $product) {
                                                ?>
                                                <option<?php echo in_array("product/server/0/".$product["id"],$primary_product) ? ' selected' : ''; ?> value="product/server/0/<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                                <?php
                                            }
                                        }

                                        $get_pcategories = $functions["get_product_categories"]("products","server");
                                        if($get_pcategories){
                                            foreach($get_pcategories AS $row){
                                                ?>
                                                <option<?php echo in_array("category/server/".$row["id"],$primary_product) ? ' selected' : ''; ?> value="category/server/<?php echo $row["id"]; ?>"><?php echo $row["title"]; ?></option>
                                                <?php
                                                preg_match('/\-+[- ]/',$row["title"],$match);
                                                $line   = rtrim($match[0]);
                                                $products   = $functions["get_category_products"]("server",$row["id"]);
                                                if($products){
                                                    foreach ($products as $product) {
                                                        ?>
                                                        <option<?php echo in_array("product/server/".$row["id"]."/".$product["id"],$primary_product) ? ' selected' : ''; ?> value="product/server/<?php echo $row["id"]; ?>/<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                                        <?php
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    if(Config::get("options/pg-activation/software")){
                                        ?>
                                        <option<?php echo in_array("allOf/software",$primary_product) ? ' selected' : ''; ?> value="allOf/software" style="font-weight: bold;"><?php echo __("admin/financial/new-coupon-product-group-softwares"); ?></option>
                                        <?php
                                        $line = "";
                                        $products   = $functions["get_category_products"]("software","0");
                                        if($products){
                                            foreach ($products as $product) {
                                                ?>
                                                <option<?php echo in_array("product/software/0/".$product["id"],$primary_product) ? ' selected' : ''; ?> value="product/software/0/<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                                <?php
                                            }
                                        }

                                        $get_pcategories = $functions["get_product_categories"]("softwares");
                                        if($get_pcategories){
                                            foreach($get_pcategories AS $row){
                                                ?>
                                                <option<?php echo in_array("category/software/".$row["id"],$primary_product) ? ' selected' : ''; ?> value="category/software/<?php echo $row["id"]; ?>"><?php echo " - ".$row["title"]; ?></option>
                                                <?php
                                                $line = "-";
                                                $products   = $functions["get_category_products"]("software",$row["id"]);
                                                if($products){
                                                    foreach ($products as $product) {
                                                        ?>
                                                        <option<?php echo in_array("product/software/".$row["id"]."/".$product["id"],$primary_product) ? ' selected' : ''; ?> value="product/software/<?php echo $row["id"]; ?>/<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                                        <?php
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    if(Config::get("general/local")=="tr" && Config::get("options/pg-activation/sms")){
                                        ?>
                                        <option<?php echo in_array("allOf/sms",$primary_product) ? ' selected' : ''; ?> value="allOf/sms"  style="font-weight: bold;"><?php echo __("admin/financial/new-coupon-product-group-sms"); ?></option>
                                        <?php
                                        $line   = "";
                                        $products   = $functions["get_category_products"]("sms",0);
                                        if($products){
                                            foreach ($products as $product) {
                                                ?>
                                                <option<?php echo in_array("product/sms/0/".$product["id"],$primary_product) ? ' selected' : ''; ?> value="product/sms/0/<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                                <?php
                                            }
                                        }
                                    }
                                    $pspecialGroups = $functions["get_special_pgroups"]();
                                    if($pspecialGroups){
                                        foreach($pspecialGroups AS $category){
                                            ?>
                                            <option<?php echo in_array("allOf/special/".$category["id"],$primary_product) ? ' selected' : ''; ?> value="allOf/special/<?php echo $category["id"]; ?>" style="font-weight: bold;"><?php echo $category["title"]; ?></option>
                                            <?php
                                            preg_match('/\-+[- ]/',$category["title"],$match);
                                            $line   = isset($match[0]) ? rtrim($match[0]) : '';
                                            $products   = $functions["get_category_products"]("special",$category["id"]);
                                            if($products){
                                                foreach ($products as $product) {
                                                    ?>
                                                    <option<?php echo in_array("product/special/".$category["id"]."/".$product["id"],$primary_product) ? ' selected' : ''; ?> value="product/special/<?php echo $category["id"]; ?>/<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                                    <?php
                                                }
                                            }
                                            $get_pcategories = $functions["get_product_categories"]("products","special",$category["id"]);
                                            if($get_pcategories){
                                                foreach($get_pcategories AS $row){
                                                    ?>
                                                    <option<?php echo in_array("category/special/".$category["id"]."/".$row["id"],$primary_product) ? ' selected' : ''; ?> value="category/special/<?php echo $category["id"]; ?>/<?php echo $row["id"]; ?>"><?php echo $row["title"]; ?></option>
                                                    <?php
                                                    preg_match('/\-+[- ]/',$row["title"],$match);
                                                    $line   = rtrim($match[0]);
                                                    $products   = $functions["get_category_products"]("special",$row["id"]);
                                                    if($products){
                                                        foreach ($products as $product) {
                                                            ?>
                                                            <option<?php echo in_array("product/special/".$category["id"]."/".$product["id"],$primary_product) ? ' selected' : ''; ?> value="product/special/<?php echo $category["id"]; ?>/<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    if(Config::get("options/pg-activation/domain")){
                                        ?>
                                        <option<?php echo in_array("allOf/domain",$primary_product) ? ' selected' : ''; ?> value="allOf/domain" style="font-weight: bold;"><?php echo __("admin/financial/new-coupon-product-domain"); ?></option>
                                        <?php
                                        $tlds   = $functions["get_tlds"];
                                        $tlds   = $tlds();
                                        if($tlds){
                                            foreach($tlds AS $tld){
                                                ?>
                                                <option<?php echo in_array("product/domain/0/".$tld["id"],$primary_product) ? ' selected' : ''; ?> value="product/domain/0/<?php echo $tld["id"]; ?>">» <?php echo $tld["name"]; ?></option>
                                                <?php
                                            }
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/financial/new-promotion-product-period"); ?></div>
                        <div class="yuzde70">
                            <input class="yuzde15" name="period_time1" type="text" placeholder="<?php echo __("admin/orders/detail-pricing-period"); ?>" value="<?php echo $promotion["period_time1"] > 1 ? $promotion["period_time1"] : ''; ?>">
                            <select class="yuzde15" name="period1">
                                <option value=""><?php echo ___("needs/none"); ?></option>
                                <?php
                                    foreach(___("date/periods") AS $k=>$v){
                                        ?>
                                        <option<?php echo $promotion["period1"] == $k ? ' selected' : ''; ?> value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                            <div class="clear"></div>
                            <span class="kinfo"><?php echo __("admin/financial/new-promotion-product-period-desc"); ?></span>
                        </div>
                    </div>

                    </div>
                    </div>

                    
                    <div class="biggroup">
                    <div class="padding20">
                    <h4 class="biggrouptitle"><?php echo __("admin/financial/promotion-groupname2"); ?></h4>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/financial/new-promotion-product2"); ?></div>
                        <div class="yuzde70">
                            <select name="product" size="10">
                                <?php
                                    if(Config::get("options/pg-activation/hosting")){
                                        ?>
                                        <option<?php echo in_array("allOf/hosting",[$promotion["product"]]) ? ' selected' : ''; ?> value="allOf/hosting" style="font-weight: bold;"><?php echo __("admin/financial/new-coupon-product-group-hosting"); ?></option>
                                        <?php
                                        $line   = "";
                                        $products   = $functions["get_category_products"]("hosting",0);
                                        if($products){
                                            foreach ($products as $product) {
                                                ?>
                                                <option<?php echo in_array("product/hosting/0/".$product["id"],[$promotion["product"]]) ? ' selected' : ''; ?> value="product/hosting/0/<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                                <?php
                                            }
                                        }

                                        $get_pcategories = $functions["get_product_categories"]("products","hosting");
                                        if($get_pcategories){
                                            foreach($get_pcategories AS $row){
                                                ?>
                                                <option<?php echo in_array("category/hosting/".$row["id"],[$promotion["product"]]) ? ' selected' : ''; ?> value="category/hosting/<?php echo $row["id"]; ?>"><?php echo $row["title"]; ?></option>
                                                <?php
                                                preg_match('/\-+[- ]/',$row["title"],$match);
                                                $line   = rtrim($match[0]);
                                                $products   = $functions["get_category_products"]("hosting",$row["id"]);
                                                if($products){
                                                    foreach ($products as $product) {
                                                        ?>
                                                        <option<?php echo in_array("product/hosting/".$row["id"]."/".$product["id"],[$promotion["product"]]) ? ' selected' : ''; ?> value="product/hosting/<?php echo $row["id"]; ?>/<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                                        <?php
                                                    }
                                                }

                                            }
                                        }
                                    }
                                    if(Config::get("options/pg-activation/server")){
                                        ?>
                                        <option<?php echo in_array("allOf/server",[$promotion["product"]]) ? ' selected' : ''; ?> value="allOf/server" style="font-weight: bold;"><?php echo __("admin/financial/new-coupon-product-group-server"); ?></option>
                                        <?php
                                        $line   = "";
                                        $products   = $functions["get_category_products"]("server","0");
                                        if($products){
                                            foreach ($products as $product) {
                                                ?>
                                                <option<?php echo in_array("product/server/0/".$product["id"],[$promotion["product"]]) ? ' selected' : ''; ?> value="product/server/0/<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                                <?php
                                            }
                                        }

                                        $get_pcategories = $functions["get_product_categories"]("products","server");
                                        if($get_pcategories){
                                            foreach($get_pcategories AS $row){
                                                ?>
                                                <option<?php echo in_array("category/server/".$row["id"],[$promotion["product"]]) ? ' selected' : ''; ?> value="category/server/<?php echo $row["id"]; ?>"><?php echo $row["title"]; ?></option>
                                                <?php
                                                preg_match('/\-+[- ]/',$row["title"],$match);
                                                $line   = rtrim($match[0]);
                                                $products   = $functions["get_category_products"]("server",$row["id"]);
                                                if($products){
                                                    foreach ($products as $product) {
                                                        ?>
                                                        <option<?php echo in_array("product/server/".$row["id"]."/".$product["id"],[$promotion["product"]]) ? ' selected' : ''; ?> value="product/server/<?php echo $row["id"]; ?>/<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                                        <?php
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    if(Config::get("options/pg-activation/software")){
                                        ?>
                                        <option<?php echo in_array("allOf/software",[$promotion["product"]]) ? ' selected' : ''; ?> value="allOf/software" style="font-weight: bold;"><?php echo __("admin/financial/new-coupon-product-group-softwares"); ?></option>
                                        <?php
                                        $line = "";
                                        $products   = $functions["get_category_products"]("software","0");
                                        if($products){
                                            foreach ($products as $product) {
                                                ?>
                                                <option<?php echo in_array("product/software/0/".$product["id"],[$promotion["product"]]) ? ' selected' : ''; ?> value="product/software/0/<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                                <?php
                                            }
                                        }

                                        $get_pcategories = $functions["get_product_categories"]("softwares");
                                        if($get_pcategories){
                                            foreach($get_pcategories AS $row){
                                                ?>
                                                <option<?php echo in_array("category/software/".$row["id"],[$promotion["product"]]) ? ' selected' : ''; ?> value="category/software/<?php echo $row["id"]; ?>"><?php echo " - ".$row["title"]; ?></option>
                                                <?php
                                                $line = "-";
                                                $products   = $functions["get_category_products"]("software",$row["id"]);
                                                if($products){
                                                    foreach ($products as $product) {
                                                        ?>
                                                        <option<?php echo in_array("product/software/".$row["id"]."/".$product["id"],[$promotion["product"]]) ? ' selected' : ''; ?> value="product/software/<?php echo $row["id"]; ?>/<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                                        <?php
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    if(Config::get("general/local")=="tr" && Config::get("options/pg-activation/sms")){
                                        ?>
                                        <option<?php echo in_array("allOf/sms",[$promotion["product"]]) ? ' selected' : ''; ?> value="allOf/sms"  style="font-weight: bold;"><?php echo __("admin/financial/new-coupon-product-group-sms"); ?></option>
                                        <?php
                                        $line   = "";
                                        $products   = $functions["get_category_products"]("sms",0);
                                        if($products){
                                            foreach ($products as $product) {
                                                ?>
                                                <option<?php echo in_array("product/sms/0/".$product["id"],[$promotion["product"]]) ? ' selected' : ''; ?> value="product/sms/0/<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                                <?php
                                            }
                                        }
                                    }
                                    $pspecialGroups = $functions["get_special_pgroups"]();
                                    if($pspecialGroups){
                                        foreach($pspecialGroups AS $category){
                                            ?>
                                            <option<?php echo in_array("allOf/special/".$category["id"],[$promotion["product"]]) ? ' selected' : ''; ?> value="allOf/special/<?php echo $category["id"]; ?>" style="font-weight: bold;"><?php echo $category["title"]; ?></option>
                                            <?php
                                            preg_match('/\-+[- ]/',$category["title"],$match);
                                            $line   = isset($match[0]) ? rtrim($match[0]) : '';
                                            $products   = $functions["get_category_products"]("special",$category["id"]);
                                            if($products){
                                                foreach ($products as $product) {
                                                    ?>
                                                    <option<?php echo in_array("product/special/".$category["id"]."/".$product["id"],[$promotion["product"]]) ? ' selected' : ''; ?> value="product/special/<?php echo $category["id"]; ?>/<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                                    <?php
                                                }
                                            }
                                            $get_pcategories = $functions["get_product_categories"]("products","special",$category["id"]);
                                            if($get_pcategories){
                                                foreach($get_pcategories AS $row){
                                                    ?>
                                                    <option<?php echo in_array("category/special/".$category["id"]."/".$row["id"],[$promotion["product"]]) ? ' selected' : ''; ?> value="category/special/<?php echo $category["id"]; ?>/<?php echo $row["id"]; ?>"><?php echo $row["title"]; ?></option>
                                                    <?php
                                                    preg_match('/\-+[- ]/',$row["title"],$match);
                                                    $line   = rtrim($match[0]);
                                                    $products   = $functions["get_category_products"]("special",$row["id"]);
                                                    if($products){
                                                        foreach ($products as $product) {
                                                            ?>
                                                            <option<?php echo in_array("product/special/".$category["id"]."/".$product["id"],[$promotion["product"]]) ? ' selected' : ''; ?> value="product/special/<?php echo $category["id"]; ?>/<?php echo $product["id"]; ?>"><?php echo $line."» ".$product["title"]; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    if(Config::get("options/pg-activation/domain")){
                                        ?>
                                        <option<?php echo in_array("allOf/domain",[$promotion["product"]]) ? ' selected' : ''; ?> value="allOf/domain" style="font-weight: bold;"><?php echo __("admin/financial/new-coupon-product-domain"); ?></option>
                                        <?php
                                        $tlds   = $functions["get_tlds"];
                                        $tlds   = $tlds();
                                        if($tlds){
                                            foreach($tlds AS $tld){
                                                ?>
                                                <option<?php echo in_array("product/domain/0/".$tld["id"],[$promotion["product"]]) ? ' selected' : ''; ?> value="product/domain/0/<?php echo $tld["id"]; ?>">» <?php echo $tld["name"]; ?></option>
                                                <?php
                                            }
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/financial/new-promotion-product-period2"); ?></div>
                        <div class="yuzde70">
                            <input class="yuzde15" name="period_time2" type="text" placeholder="<?php echo __("admin/orders/detail-pricing-period"); ?>" value="<?php echo $promotion["period_time2"] > 1 ? $promotion["period_time2"] : ''; ?>">
                            <select class="yuzde15" name="period2">
                                <?php
                                    foreach(___("date/periods") AS $k=>$v){
                                        ?>
                                        <option<?php echo $promotion["period2"] == $k ? ' selected' : ''; ?> value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    </div>
                    </div>


                    <div class="biggroup">
                    <div class="padding20">
                    <h4 class="biggrouptitle"><?php echo __("admin/financial/promotion-groupname3"); ?></h4>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/financial/new-coupon-type"); ?></div>
                        <div class="yuzde70">

                            <input<?php echo $promotion["type"] == "percentage" ? ' checked' : ''; ?> type="radio" class="radio-custom" name="type" value="percentage" id="type_percentage" onclick="$('input[name=amount]').val(''),$('.new-type-content').fadeOut(1,function(){$('.percentage-content').fadeIn(1);});">
                            <label for="type_percentage" class="radio-custom-label" style="margin-right:15px;"><?php echo __("admin/financial/new-coupon-type-percentage"); ?></label>

                            <input<?php echo $promotion["type"] == "amount" ? ' checked' : ''; ?> type="radio" class="radio-custom" name="type" value="amount" id="type_amount" onclick="$('input[name=rate]').val(''),$('.new-type-content').fadeOut(1,function(){$('.amount-content').fadeIn(1);});">
                            <label for="type_amount" class="radio-custom-label" style="margin-right:15px;"><?php echo __("admin/financial/new-coupon-type-amount"); ?></label>

                            <input<?php echo $promotion["type"] == "free" ? ' checked' : ''; ?> type="radio" class="radio-custom" name="type" value="free" id="type_free" onclick="$('input[name=rate],input[name=amount]').val(''),$('.new-type-content').css('display','none');">
                            <label for="type_free" class="radio-custom-label" style="margin-right:15px;"><?php echo __("admin/financial/new-coupon-type-free"); ?></label>

                        </div>
                    </div>

                    <div class="formcon percentage-content new-type-content"<?php echo $promotion["type"] != "percentage" ? ' style="display: none;"' : ''; ?>>
                        <div class="yuzde30"><?php echo __("admin/financial/new-coupon-percentage-rate"); ?></div>
                        <div class="yuzde70">
                            <input type="text" name="rate" class="yuzde15" value="<?php echo $promotion["rate"]; ?>">
                            <span style="line-height: 45px;    font-weight: bold;    font-size: 18px;">%</span>
                        </div>
                    </div>

                    <div class="formcon amount-content new-type-content"<?php echo $promotion["type"] != "amount" ? ' style="display: none;"' : ''; ?>>
                        <div class="yuzde30"><?php echo __("admin/financial/new-coupon-select-amount"); ?></div>
                        <div class="yuzde70">
                            <input type="text" name="amount" class="yuzde15" value="<?php echo Money::formatter($promotion["amount"],$promotion["currency"]); ?>" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57'>
                            <select name="cid" class="width200">
                                <?php
                                    $currencies = Money::getCurrencies($promotion["currency"]);
                                    foreach ($currencies AS $currencyx){
                                        $checked = $currencyx["id"] == $promotion["currency"];
                                        ?>
                                        <option<?php echo $checked ? ' selected' : ''; ?> value="<?php echo $currencyx["id"]; ?>"><?php echo $currencyx["name"]." - ".$currencyx["code"]; ?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </div>


                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/financial/new-coupon-due-date"); ?></div>
                        <div class="yuzde70">
                            <input type="date" name="duedate" id="duedate" style="width:150px;" placeholder="YYYY-MM-DD" value="<?php echo $promotion["duedate"] == "1881-05-19 00:00:00" ? '' : DateManager::format("Y-m-d",$promotion["duedate"]); ?>">
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/financial/new-coupon-maxuses"); ?></div>
                        <div class="yuzde70">
                            <input type="text" name="maxuses" style="width: 50px;" value="<?php echo $promotion["maxuses"] == 0 ? '' : $promotion["maxuses"]; ?>">
                            <span class="kinfo"><?php echo __("admin/financial/new-coupon-maxuses-desc"); ?></span>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/financial/new-coupon-applyonce"); ?></div>
                        <div class="yuzde70">
                            <input<?php echo $promotion["applyonce"] ? ' checked' : ''; ?> type="checkbox" class="checkbox-custom" name="applyonce" id="applyonce" value="1">
                            <label for="applyonce" class="checkbox-custom-label kinfo"><?php echo __("admin/financial/new-coupon-applyonce-desc2"); ?></label>
                        </div>
                    </div>


                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/financial/new-coupon-notes"); ?></div>
                        <div class="yuzde70">
                            <textarea name="notes"><?php echo $promotion["notes"]; ?></textarea>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/financial/new-coupon-status"); ?></div>
                        <div class="yuzde70">
                            <input<?php echo $promotion["status"] == "active" ? ' checked' : ''; ?> type="checkbox" class="sitemio-checkbox" name="status" id="status" value="1">
                            <label for="status" class="sitemio-checkbox-label"></label>
                            <span class="kinfo"><?php echo __("admin/financial/new-coupon-status-desc"); ?></span>
                        </div>
                    </div>

                    </div>
                    </div>


                    <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                        <a class="yesilbtn gonderbtn" id="editForm_submit" href="javascript:void(0);"><?php echo __("admin/financial/edit-promotion-button"); ?></a>
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