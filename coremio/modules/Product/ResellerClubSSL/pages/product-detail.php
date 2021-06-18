<?php
    $LANG           = $module->lang;
    $product        = isset($product) && $product ? $product : [];
    $module_data    = isset($product["module_data"]) ? Utility::jdecode($product["module_data"],true) : [];
    $plan_id        = isset($module_data["plan-id"]) ? $module_data["plan-id"] : false;
    $get_plans      = $module->get_plans();
?>
    <div class="formcon">
        <div class="yuzde30"><?php echo $LANG["certificate-type"]; ?></div>
        <div class="yuzde70">
            <?php
                if($module->error && !$get_plans){
                    ?>
                    <input type="hidden" name="module_data[plan-id]" value="<?php echo $plan_id; ?>">
                    <div class="red-info">
                        <div class="padding10">
                            <strong>ERROR::</strong> <?php echo $module->error; ?>
                        </div>
                    </div>
                    <?php
                }else{
                    ?>
                    <select name="module_data[plan-id]">
                        <option value="0"><?php echo ___("needs/select-your"); ?></option>
                        <?php
                            foreach($get_plans AS $k=>$v){
                                ?>
                                <option<?php echo $k == $plan_id ? ' selected' : ''; ?> value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                <?php
                            }
                        ?>
                    </select>
                    <?php
                }
            ?>
        </div>
    </div>