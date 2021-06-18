<?php
    $LANG           = $module->lang;
    $product        = isset($product) && $product ? $product : [];
    $module_data    = isset($product["module_data"]) ? Utility::jdecode($product["module_data"],true) : [];
    $packages       = $module->adminArea_packages();
?>
<div id="package_details">
    <div id="SonicPanel_packages">
        <?php
            if($packages)
            {
                foreach($packages AS $g_k => $g_packages)
                {
                    foreach($g_packages AS $g_p_k => $g_p_v)
                    {
                        ?>
                        <div class="package-details group-<?php echo $g_k; ?>" id="package-<?php echo $g_k; ?>-<?php echo $g_p_k; ?>" style="<?php echo (isset($module_data["reseller"]) && $module_data["reseller"] && isset($module_data["package_r"]) && $module_data["package_r"] == $g_p_k) || ((!isset($module_data["reseller"]) || !$module_data["reseller"]) && isset($module_data["package"]) && $module_data["package"] == $g_p_k) ? '' : 'display:none;'; ?>">
                            <?php
                                foreach($g_p_v["features"] AS $k => $v)
                                {
                                    ?>
                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo $k; ?></div>
                                        <div class="yuzde70"><?php echo $v; ?></div>
                                    </div>
                                    <?php
                                }
                            ?>

                        </div>
                        <?php
                    }
                }
            }
            else
                echo '<div class="red-info"><div class="padding5">'.$module->error.'</div></div>';
        ?>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        if($("#el-item-reseller").prop('checked'))
            $("#wrap-el-package_r").css("display","block");
        else
            $("#wrap-el-package_r").css("display","none");

        $("#disk_limit_container").parent().css("display","none").before($("#package_details").html());
        $("#package_details").remove();
        $("#el-item-package").change(package_change);
        $("#el-item-package_r").change(package_r_change);
        $("#el-item-reseller").change(reseller_change);

        package_change();
        package_r_change();
        reseller_change();
    });

    function package_change(){
        let el = $("#el-item-package");

        if(!$('#el-item-reseller').prop('checked'))
        {
            let selection = el.val();
            $('.package-details').css("display","none");
            $("#package-normal-"+selection).css("display","block");
        }

    }
    function package_r_change(){
        let el = $("#el-item-package_r");
        if($('#el-item-reseller').prop('checked'))
        {
            let selection = el.val();
            $('.package-details').css("display","none");
            $("#package-reseller-"+selection).css("display","block");
        }
    }
    function reseller_change(){
        let el = $("#el-item-reseller");
        if(el.prop('checked'))
            $("#wrap-el-package_r").css("display","block");
        else
            $("#wrap-el-package_r").css("display","none");

        $("#el-item-package").trigger("change");
        $("#el-item-package_r").trigger("change");
    }
</script>
<?php

    if(method_exists($module,"config_options") && $config_options = $module->config_options($module_data)) return $module->config_options_output($config_options,'module_data');
?>
