<?php
    $LANG           = $module->lang;
    $product        = isset($product) && $product ? $product : [];
    $module_data    = isset($product["module_data"]) ? Utility::jdecode($product["module_data"],true) : [];
    $product_name     = isset($module_data["product-name"]) ? $module_data["product-name"] : false;
    $get_products   = $module->get_products();
?>
<div class="formcon">
    <div class="yuzde30"><?php echo $LANG["product"]; ?></div>
    <div class="yuzde70">
        <?php
            if($module->error && !$get_products){
                ?>
                <input type="hidden" name="module_data[product-name]" value="<?php echo $product_name; ?>">
                <div class="red-info">
                    <div class="padding10">
                        <strong>ERROR::</strong> <?php echo $module->error; ?>
                    </div>
                </div>
                <?php
            }else{
                ?>
                <select name="module_data[product-name]">
                    <option value="0"><?php echo ___("needs/select-your"); ?></option>
                    <?php
                        foreach($get_products AS $k=>$v){
                            ?>
                            <option<?php echo $k == $product_name ? ' selected' : ''; ?> value="<?php echo $k; ?>"><?php echo $v; ?></option>
                            <?php
                        }
                    ?>
                </select>
                <?php
            }
        ?>
    </div>
</div>