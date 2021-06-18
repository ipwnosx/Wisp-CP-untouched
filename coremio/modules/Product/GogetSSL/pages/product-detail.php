<?php
    $LANG           = $module->lang;
    $product        = isset($product) && $product ? $product : [];
    $module_data    = isset($product["module_data"]) ? Utility::jdecode($product["module_data"],true) : [];
    $product_id     = isset($module_data["product-id"]) ? $module_data["product-id"] : false;
    $sans_status    = isset($module_data["sans_status"]) ? $module_data["sans_status"] : false;
    $disable_dcv_m  = isset($module_data["disable_dcv_m"]) ? $module_data["disable_dcv_m"] : [];
    $included_sans  = isset($module_data["included_sans"]) ? $module_data["included_sans"] : false;
    $get_products   = $module->get_products();
?>
<div class="formcon">
    <div class="yuzde30"><?php echo $LANG["product"]; ?></div>
    <div class="yuzde70">
        <?php
            if($module->error && !$get_products){
                ?>
                <input type="hidden" name="module_data[product-id]" value="<?php echo $product_id; ?>">
                <div class="red-info">
                    <div class="padding10">
                        <strong>ERROR::</strong> <?php echo $module->error; ?>
                    </div>
                </div>
                <?php
            }else{
                ?>
                <select name="module_data[product-id]">
                    <option value="0"><?php echo ___("needs/select-your"); ?></option>
                    <?php
                        foreach($get_products AS $k=>$v){
                            ?>
                            <option<?php echo $k == $product_id ? ' selected' : ''; ?> value="<?php echo $k; ?>"><?php echo $v; ?></option>
                            <?php
                        }
                    ?>
                </select>
                <?php
            }
        ?>
    </div>
</div>

<div class="formcon">
    <div class="yuzde30"><?php echo $LANG["disable-dcv-m"]; ?></div>
    <div class="yuzde70">
        <select name="module_data[disable_dcv_m][]" multiple>
            <?php
                foreach (['EMAIL','HTTP','HTTPS','DNS'] as $m)
                {
                    ?>
                    <option<?php echo $disable_dcv_m  && in_array($m,$disable_dcv_m) ? ' selected' : ''; ?> value="<?php echo $m; ?>"><?php echo $m; ?></option>
                    <?php
                }
            ?>
        </select>
    </div>
</div>

<div class="formcon">
    <div class="yuzde30"><?php echo $LANG["enable-sans"]; ?></div>
    <div class="yuzde70">
        <input<?php echo $sans_status ? ' checked' : ''; ?> type="checkbox" name="module_data[sans_status]" value="1" id="enable_sans" class="sitemio-checkbox">
        <label for="enable_sans" class="sitemio-checkbox-label"></label>
    </div>
</div>

<div class="formcon">
    <div class="yuzde30"><?php echo $LANG["included-sans"]; ?></div>
    <div class="yuzde70">
        <input type="number" style="width: 80px;" name="module_data[included_sans]" value="<?php echo $included_sans; ?>">
    </div>
</div>