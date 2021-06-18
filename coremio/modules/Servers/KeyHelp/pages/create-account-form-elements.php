<?php
    $LANG               = $module->lang;
    $product            = isset($product) && $product ? $product : [];
    $module_data        = isset($product["module_data"]) ? Utility::jdecode($product["module_data"],true) : [];
    $config_options     = $module->config_options($module_data);
    $selected_plan      = isset($module_data["plan"]) ? $module_data["plan"] : '';
?>
<div class="formcon" id="plans_wrap">
    <div class="yuzde30"><?php echo $LANG["select-plan"]; ?></div>
    <div class="yuzde70">
        <?php
            if($config_options["plans"])
            {
                ?>
                <script type="text/javascript">
                    $(document).ready(function(){

                        <?php if($selected_plan): ?>
                        module_data_plan_trigger();
                        <?php endif; ?>

                        $("#module_data_plan").change(module_data_plan_trigger);
                    });

                    function module_data_plan_trigger(){
                        var selected = $("option:selected",$("#module_data_plan"));
                        var name     = $("#module_data_plan").val();
                        if(name){
                            var disk_limit          = selected.data("quota");
                            var bandwidth_limit     = selected.data("bwlimit");
                            var email_limit         = selected.data("maxpop");
                            var database_limit      = selected.data("maxsql");
                            var addons_limit        = selected.data("maxaddon");
                            var subdomain_limit     = selected.data("maxsub");
                            var ftp_limit           = selected.data("maxftp");
                            var park_limit          = selected.data("maxpark");
                            var max_email_per_hour  = selected.data("max_email_per_hour");

                            $("#disk_limit").attr("readonly",true);
                            $("#disk_limit_unlimited").attr("disabled",true);
                            if(disk_limit == "unlimited"){
                                $("#disk_limit").val('');
                                $("#disk_limit_unlimited").prop("checked",true);
                            }else{
                                $("#disk_limit").val(disk_limit);
                                $("#disk_limit_unlimited").prop("checked",false);
                            }

                            $("#bandwidth_limit").attr("readonly",true);
                            $("#bandwidth_limit_unlimited").attr("disabled",true);
                            if(bandwidth_limit == "unlimited"){
                                $("#bandwidth_limit").val('');
                                $("#bandwidth_limit_unlimited").prop("checked",true);
                            }else{
                                $("#bandwidth_limit").val(bandwidth_limit);
                                $("#bandwidth_limit_unlimited").prop("checked",false);
                            }

                            $("#email_limit").attr("readonly",true);
                            $("#email_limit_unlimited").attr("disabled",true);
                            if(email_limit == "unlimited"){
                                $("#email_limit").val('');
                                $("#email_limit_unlimited").prop("checked",true);
                            }else{
                                $("#email_limit").val(email_limit);
                                $("#email_limit_unlimited").prop("checked",false);
                            }

                            $("#database_limit").attr("readonly",true);
                            $("#database_limit_unlimited").attr("disabled",true);
                            if(database_limit == "unlimited"){
                                $("#database_limit").val('');
                                $("#database_limit_unlimited").prop("checked",true);
                            }else{
                                $("#database_limit").val(database_limit);
                                $("#database_limit_unlimited").prop("checked",false);
                            }

                            $("#addons_limit").attr("readonly",true);
                            $("#addons_limit_unlimited").attr("disabled",true);
                            if(addons_limit == "unlimited"){
                                $("#addons_limit").val('');
                                $("#addons_limit_unlimited").prop("checked",true);
                            }else{
                                $("#addons_limit").val(addons_limit);
                                $("#addons_limit_unlimited").prop("checked",false);
                            }


                            $("#subdomain_limit").attr("readonly",true);
                            $("#subdomain_limit_unlimited").attr("disabled",true);
                            if(subdomain_limit == "unlimited"){
                                $("#subdomain_limit").val('');
                                $("#subdomain_limit_unlimited").prop("checked",true);
                            }else{
                                $("#subdomain_limit").val(subdomain_limit);
                                $("#subdomain_limit_unlimited").prop("checked",false);
                            }

                            $("#ftp_limit").attr("readonly",true);
                            $("#ftp_limit_unlimited").attr("disabled",true);
                            if(ftp_limit == "unlimited"){
                                $("#ftp_limit").val('');
                                $("#ftp_limit_unlimited").prop("checked",true);
                            }else{
                                $("#ftp_limit").val(ftp_limit);
                                $("#ftp_limit_unlimited").prop("checked",false);
                            }

                            $("#park_limit").attr("readonly",true);
                            $("#park_limit_unlimited").attr("disabled",true);
                            if(park_limit == "unlimited"){
                                $("#park_limit").val('');
                                $("#park_limit_unlimited").prop("checked",true);
                            }else{
                                $("#park_limit").val(park_limit);
                                $("#park_limit_unlimited").prop("checked",false);
                            }

                            $("#max_email_per_hour").attr("readonly",true);
                            $("#max_email_per_hour_unlimited").attr("disabled",true);
                            if(max_email_per_hour == "unlimited"){
                                $("#max_email_per_hour").val('');
                                $("#max_email_per_hour_unlimited").prop("checked",true);
                            }else{
                                $("#max_email_per_hour").val(max_email_per_hour);
                                $("#max_email_per_hour_unlimited").prop("checked",false);
                            }
                        }else{
                            $("#disk_limit").val('').attr("readonly",true);
                            $("#disk_limit_unlimited").prop("checked",true).attr("disabled",false);

                            $("#bandwidth_limit").val('').attr("readonly",true);
                            $("#bandwidth_limit_unlimited").prop("checked",true).attr("disabled",false);

                            $("#email_limit").val('').attr("readonly",true);
                            $("#email_limit_unlimited").prop("checked",true).attr("disabled",false);

                            $("#database_limit").val('').attr("readonly",true);
                            $("#database_limit_unlimited").prop("checked",true).attr("disabled",false);

                            $("#addons_limit").val('').attr("readonly",true);
                            $("#addons_limit_unlimited").prop("checked",true).attr("disabled",false);

                            $("#subdomain_limit").val('').attr("readonly",true);
                            $("#subdomain_limit_unlimited").prop("checked",true).attr("disabled",false);

                            $("#ftp_limit").val('').attr("readonly",true);
                            $("#ftp_limit_unlimited").prop("checked",true).attr("disabled",false);

                            $("#park_limit").val('').attr("readonly",true);
                            $("#park_limit_unlimited").prop("checked",true).attr("disabled",false);

                            $("#max_email_per_hour").val('').attr("readonly",true);
                            $("#max_email_per_hour_unlimited").prop("checked",true).attr("disabled",false);

                        }
                    }

                </script>
                <select  name="module_data[plan]" id="module_data_plan">
                    <?php
                        foreach($config_options["plans"] AS $plan){
                            ?>
                            <option<?php echo $plan["id"] == $selected_plan ? ' selected' : ''; ?> value="<?php echo $plan["id"]; ?>"
                                                                                                   data-maxpop="<?php echo $plan["resources"]["email_accounts"] == "-1" ? "unlimited" : $plan["resources"]["email_accounts"]; ?>"
                                                                                                   data-maxsql="<?php echo $plan["resources"]["databases"] == "-1" ? "unlimited" : $plan["resources"]["databases"]; ?>"
                                                                                                   data-maxftp="<?php echo $plan["resources"]["ftp_users"] == "-1" ? "unlimited" : $plan["resources"]["ftp_users"]; ?>"
                                                                                                   data-bwlimit="<?php echo $plan["resources"]["traffic"] == "-1" ? "unlimited" : FileManager::showMB($plan["resources"]["traffic"]); ?>"
                                                                                                   data-quota="<?php echo $plan["resources"]["disk_space"] == "-1" ? "unlimited" : FileManager::showMB($plan["resources"]["disk_space"]); ?>"
                                                                                                   data-maxsub="<?php echo $plan["resources"]["subdomains"] == "-1" ? "unlimited" : $plan["resources"]["subdomains"]; ?>"
                                                                                                   data-maxaddon="<?php echo $plan["resources"]["domains"] == "-1" ? "unlimited" : $plan["resources"]["domains"]; ?>"
                                                                                                   data-maxpark="unlimited"
                                                                                                   data-max_email_per_hour="unlimited"
                            ><?php echo $plan["name"]; ?></option>
                            <?php
                        }
                    ?>
                </select>
            <?php
            }
            elseif($config_options["plans_error"]){
            ?>
                <div class="red-info">
                    <div class="padding10">
                        Error: <strong><?php echo $config_options["plans_error"]; ?></strong>
                    </div>
                </div>
                <?php
            }
        ?>
    </div>
</div>
