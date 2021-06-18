<?php
    $LANG           = $module->lang;
    $order          = isset($order) && $order ? $order : [];
    $options        = isset($order["options"]) ? $order["options"] : [];
    $config         = isset($options["config"]) ? $options["config"] : [];
    $creation_info  = isset($options["creation_info"]) ? $options["creation_info"] : [];
    $selected_plan  = isset($creation_info["plan"]) ? $creation_info["plan"] : false;
    $selected_rplan = isset($creation_info["reseller_plan"]) ? $creation_info["reseller_plan"] : false;
    $owner          = $module->config["owner"];
    $reseller       = stristr($owner,"root") || stristr($owner,"administrator") || stristr($owner,"admin");
    $set_reseller   = $reseller && isset($creation_info["reseller"]) && $creation_info["reseller"];
    $reseller_ip    = isset($creation_info["reseller_ip"]) ? $creation_info["reseller_ip"] : false;

?>

<div class="formcon">
    <div class="yuzde30"><?php echo __("admin/orders/hosting-config-username"); ?></div>
    <div class="yuzde70">
        <input name="config[user]" type="text" value="<?php echo isset($config["user"]) ? $config["user"] : ''; ?>">
        <span class="kinfo"><?php echo __("admin/orders/hosting-config-username-info"); ?></span>
    </div>
</div>

<div class="formcon">
    <div class="yuzde30"><?php echo __("admin/orders/hosting-config-password"); ?></div>
    <div class="yuzde70">
        <input name="config[password]" type="text" placeholder="*******" value="<?php echo isset($config["password"]) ? Crypt::decode($config["password"],Config::get("crypt/user")) : ''; ?>">
        <span class="kinfo"><?php echo __("admin/orders/hosting-config-password-info"); ?></span>
    </div>
</div>

<?php if($reseller): ?>
    <script type="text/javascript">
        $(document).ready(function(){

            $("#creation_info_reseller").change(function(){
                if($(this).prop("checked")){
                    $("#reseller_container").css("display","block");
                    $("#plans_wrap").css("display","none");
                    $("#creation_info_plan").val('').trigger("change");
                    $("#creation_info_rplan").val('').trigger("change");
                }else{
                    $("#reseller_container").css("display","none");
                    $("#creation_info_rplan").val('').trigger("change");
                    $("#plans_wrap").css("display","block");
                    $("#creation_info_plan").val('').trigger("change");
                }
            });

        });
    </script>
    
    <div class="formcon" style="<?php echo $set_reseller ? 'display:none;' : ''; ?>">
        <div class="yuzde30"><?php echo $LANG["reseller-account"]; ?></div>
        <div class="yuzde70">
            <input<?php echo $set_reseller ? ' checked' : ''; ?> type="checkbox" name="creation_info[reseller]" value="1" id="creation_info_reseller" class="sitemio-checkbox">
            <label for="creation_info_reseller" class="sitemio-checkbox-label"></label>
        </div>
    </div>

    <div id="reseller_container" style="<?php echo $set_reseller ? '' : 'display:none;'; ?>">
        <?php
            if(!isset($config["user"]) || !$config["user"]){
                ?>
                <div class="formcon">
                    <div class="yuzde30"><?php echo $LANG["reseller-ip"]; ?></div>
                    <div class="yuzde70">
                        <select name="creation_info[reseller_ip]">
                            <option<?php echo  $reseller_ip == 'shared' ? ' selected' : ''; ?> value="shared">Shared</option>
                            <option<?php echo  $reseller_ip == 'sharedreseller' ? ' selected' : ''; ?> value="sharedreseller">Shared Reseller</option>
                            <option<?php echo  $reseller_ip == 'assign' ? ' selected' : ''; ?> value="assign">Assign</option>
                        </select>
                    </div>
                </div>
                <?php
            }
        ?>

        <div class="formcon">
            <div class="yuzde30"><?php echo $LANG["reseller-plan"]; ?></div>
            <div class="yuzde70">
                <?php
                    $plans  = $module->getResellerPlans();
                    if($reseller){
                        if($plans){
                            ?>
                            <script type="text/javascript">
                                $(document).ready(function(){

                                    $("#creation_info_rplan").change(creation_info_rplan_trigger);
                                });

                                function creation_info_rplan_trigger(){
                                    var selected = $("option:selected",$("#creation_info_rplan"));
                                    var name     = $("#creation_info_rplan").val();
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
                                    }
                                    else{
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
                            <select name="creation_info[reseller_plan]" id="creation_info_rplan">
                                <option value=""><?php echo ___("needs/none"); ?></option>
                                <?php
                                    foreach($plans AS $plan_name=>$plan){
                                        ?>
                                        <option<?php echo $plan_name == $selected_rplan ? ' selected' : ''; ?> value="<?php echo $plan_name; ?>"
                                                                                                               data-maxpop="<?php echo $plan["nemails"]; ?>"
                                                                                                               data-maxsql="<?php echo $plan["mysql"]; ?>"
                                                                                                               data-maxftp="<?php echo $plan["ftp"]; ?>"
                                                                                                               data-bwlimit="<?php echo $plan["bandwidth"]; ?>"
                                                                                                               data-quota="<?php echo $plan["quota"]; ?>"
                                                                                                               data-maxsub="<?php echo $plan["nsubdomains"]; ?>"
                                                                                                               data-maxaddon="<?php echo $plan["vdomains"]; ?>"
                                                                                                               data-maxpark="<?php echo $plan["domainptr"]; ?>"
                                                                                                               data-max_email_per_hour="<?php echo "unlimited"; ?>"
                                        ><?php echo $plan_name; ?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                            <?php
                        }
                    }

                ?>
            </div>
        </div>

    </div>

<?php endif; ?>


<div class="formcon" id="plans_wrap"<?php echo $set_reseller ? ' style="display:none;"' :''; ?>>
    <div class="yuzde30"><?php echo $LANG["service-plan"]; ?></div>
    <div class="yuzde70">
        <?php
            $plans  = $module->getPlans();
            if($plans){
                ?>
                <script type="text/javascript">
                    $(document).ready(function(){

                        <?php if($selected_plan): ?>
                        creation_info_plan_trigger();
                        <?php endif; ?>

                        $("#creation_info_plan").change(creation_info_plan_trigger);
                    });

                    function creation_info_plan_trigger(){
                        var selected = $("option:selected",$("#creation_info_plan"));
                        var name     = $("#creation_info_plan").val();
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
                <select name="creation_info[plan]" id="creation_info_plan">
                    <option value=""><?php echo ___("needs/none"); ?></option>
                    <?php
                        foreach($plans AS $plan_name=>$plan){
                            ?>
                            <option<?php echo $plan_name == $selected_plan ? ' selected' : ''; ?> value="<?php echo $plan_name; ?>"
                                                                                                  data-maxpop="<?php echo $plan["nemails"]; ?>"
                                                                                                  data-maxsql="<?php echo $plan["mysql"]; ?>"
                                                                                                  data-maxftp="<?php echo $plan["ftp"]; ?>"
                                                                                                  data-bwlimit="<?php echo $plan["bandwidth"]; ?>"
                                                                                                  data-quota="<?php echo $plan["quota"]; ?>"
                                                                                                  data-maxsub="<?php echo $plan["nsubdomains"]; ?>"
                                                                                                  data-maxaddon="<?php echo $plan["vdomains"]; ?>"
                                                                                                  data-maxpark="<?php echo $plan["domainptr"]; ?>"
                                                                                                  data-max_email_per_hour="<?php echo "unlimited"; ?>"
                            ><?php echo $plan_name; ?></option>
                            <?php
                        }
                    ?>
                </select>
                <?php
            }elseif(!$plans && $module->error){
                ?>
                <div class="red-info">
                    <div class="padding10">
                        Error: <strong><?php echo $module->error; ?></strong>
                    </div>
                </div>
                <?php
            }
        ?>
        <?php

        ?>
    </div>
</div>