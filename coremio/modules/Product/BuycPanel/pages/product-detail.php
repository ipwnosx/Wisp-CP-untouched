<?php
    $LANG           = $module->lang;
    $product        = isset($product) && $product ? $product : [];
    $module_data    = isset($product["module_data"]) ? Utility::jdecode($product["module_data"],true) : [];
    $product        = isset($module_data["product"]) ? $module_data["product"] : false;
    $Litespeed_cpu  = isset($module_data["Litespeed_cpu"]) ? $module_data["Litespeed_cpu"] : false;
    $get_products   = $module->get_products();
?>
<div class="formcon">
    <div class="yuzde30"><?php echo $LANG["product"]; ?></div>
    <div class="yuzde70">
        <?php
            if($module->error && !$get_products){
                ?>
                <input type="hidden" name="module_data[product]" value="<?php echo $product; ?>">
                <div class="red-info">
                    <div class="padding10">
                        <strong>ERROR::</strong> <?php echo $module->error; ?>
                    </div>
                </div>
                <?php
            }else{
                ?>
                <script type="text/javascript">
                    function change_product(){
                        var s_product = $("select[name='module_data[product]']").val();
                        var litespeed = false;

                        if(s_product === "Litespeed") litespeed = true;
                        else if(s_product === "Litespeedultra") litespeed = true;
                        else if(s_product === "Litespeedvps") litespeed = true;

                        if(litespeed)
                            $("#litespeed_wrap").css("display","block");
                        else
                            $("#litespeed_wrap").css("display","none");

                    }
                    $(document).ready(function(){
                        change_product();
                    });
                </script>
                <select name="module_data[product]" onchange="change_product();">
                    <option value=""><?php echo ___("needs/select-your"); ?></option>
                    <?php
                        foreach($get_products AS $k=>$v){
                            if(is_array($v)){
                                ?>
                                <optgroup label="<?php echo $LANG["product-addons"]; ?>">
                                    <?php
                                        foreach($v AS $kk=>$vv){
                                            ?>
                                            <option<?php echo $product == $kk ? ' selected' : ''; ?> value="<?php echo $kk; ?>"><?php echo $vv; ?></option>
                                            <?php
                                        }
                                    ?>
                                </optgroup>
                                <?php
                            }else{
                                ?>
                                <option<?php echo strlen($product) && $k == $product ? ' selected' : ''; ?> value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                <?php
                            }
                            ?>
                            <?php
                        }
                    ?>
                </select>
                <?php
            }
        ?>
    </div>
</div>

<div class="formcon" id="litespeed_wrap" style="display: none;">
    <div class="yuzde30">LiteSpeed CPU</div>
    <div class="yuzde70">
        <input type="number" name="module_data[Litespeed_cpu]" value="<?php echo $Litespeed_cpu ? $Litespeed_cpu : ''; ?>">
    </div>
</div>