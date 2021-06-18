<?php
    $LANG           = $module->lang;
    $product        = isset($product) && $product ? $product : [];
    $module_data    = isset($product["module_data"]) ? Utility::jdecode($product["module_data"],true) : [];
    $create_account = isset($module_data["create_account"]) ? $module_data["create_account"] : $module_data;
    $plann          = isset($create_account["plan"]) ? $create_account["plan"] : false;
    $rplann         = isset($create_account["reseller_plan"]) ? $create_account["reseller_plan"] : false;
    $reseller       = in_array($module->config["owner"],["root","administrator","admin"]);
    $set_reseller   = $reseller && isset($create_account["reseller"]) && $create_account["reseller"];
    $aclmt          = isset($create_account["account_limit"]) ? $create_account["account_limit"] : false;
    $domlmt         = isset($create_account["domain_limit"]) ? $create_account["domain_limit"] : false;
?>

<script>
    reseller = <?php echo $set_reseller ? "true": "false"; ?>;
</script>

<?php if($reseller): ?>
    <script type="text/javascript">
        $(document).ready(function(){

            $("#module_data_reseller").change(function(){
                if($(this).prop("checked")){
                    $("#reseller_container").css("display","block");
                    $("#service_plan").css("display","none");
                    $("#service_plan select").val('');
                }else{
                    $("#reseller_container").css("display","none");
                    $("#service_plan").css("display","block");
                }
            });

            <?php if($set_reseller): ?>

            $('#module_data_reseller').prop('checked',true).trigger("change");

            <?php endif; ?>

        });
    </script>
    <div class="formcon">
        <div class="yuzde30"><?php echo $LANG["reseller-account"]; ?></div>
        <div class="yuzde70">
            <input type="checkbox" name="module_data[reseller]" value="1" id="module_data_reseller" class="sitemio-checkbox">
            <label for="module_data_reseller" class="sitemio-checkbox-label"></label>
        </div>
    </div>

    <div id="reseller_container" style="<?php echo $set_reseller ? '' : 'display:none;'; ?>">

        <div class="formcon">
            <div class="yuzde30"><?php echo $LANG["account-open-limit"]; ?></div>
            <div class="yuzde70">
                <input type="number" id="clmt" name="module_data[account_limit]" value="<?php echo $aclmt; ?>" onkeypress='return event.charCode>= 48 &&event.charCode<= 57' onkeyup="if($(this).val() != '' && $(this).val() == 0) $(this).val(1);" style="width: 80px;" min="1">
            </div>
        </div>

        <div class="formcon">
            <div class="yuzde30"><?php echo $LANG["domain-limit"]; ?></div>
            <div class="yuzde70">
                <input type="number" id="domlmt" name="module_data[domain_limit]" value="<?php echo $domlmt; ?>" onkeypress='return event.charCode>= 48 &&event.charCode<= 57' onkeyup="if($(this).val() != '' && $(this).val() == 0) $(this).val(1);" style="width: 80px;" min="1">
            </div>
        </div>

        <div class="formcon">
            <div class="yuzde30"><?php echo $LANG["reseller-plan"]; ?></div>
            <div class="yuzde70">
                <?php
                    if($reseller){
                        $plans  = $module->getResellerPlans();
                        if($plans){
                            ?>
                            <script type="text/javascript">
                                $(document).ready(function(){
                                    <?php if($rplann): ?>
                                    module_data_rplan_trigger();
                                    <?php endif; ?>

                                    $("#module_data_rplan").change(module_data_rplan_trigger);
                                });

                                function module_data_rplan_trigger(){
                                    var selected = $("option:selected",$("#module_data_rplan"));
                                    var name     = $("#module_data_rplan").val();
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
                                        var maxcl               = selected.data("maxcl");
                                        var maxdom              = selected.data("maxdom");



                                        $("#clmt").val(maxcl).attr("readonly",true);
                                        $("#domlmt").val(maxdom).attr("readonly",true);

                                    }else{

                                        $("#clmt").val('').attr("readonly",false);
                                        $("#domlmt").val('').attr("readonly",false);

                                    }
                                }

                            </script>
                            <select  name="module_data[reseller_plan]" id="module_data_rplan">
                                <option value=""><?php echo ___("needs/none"); ?></option>
                                <?php
                                    foreach($plans AS $plan){
                                        ?>
                                        <option<?php echo $plan["name"] == $rplann ? ' selected' : ''; ?> value="<?php echo $plan["name"]; ?>"
                                                                                                          data-maxpop="<?php echo $plan["maxpop"]; ?>"
                                                                                                          data-maxsql="<?php echo $plan["maxdb"]; ?>"
                                                                                                          data-maxftp="<?php echo $plan["maxftp"]; ?>"
                                                                                                          data-bwlimit="<?php echo $plan["max_traffic"]; ?>"
                                                                                                          data-quota="<?php echo $plan["disk_space"]; ?>"
                                                                                                          data-maxsub="<?php echo $plan["maxsubdomain"]; ?>"
                                                                                                          data-maxcl="<?php echo $plan["max_cl"]; ?>"
                                                                                                          data-maxdom="<?php echo $plan["max_dom"]; ?>"
                                        ><?php echo $plan["name"]; ?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                            <?php
                        }elseif($module->error){
                            ?>
                            <div class="red-info">
                                <div class="padding10">
                                    Error: <strong><?php echo $module->error; ?></strong>
                                </div>
                            </div>
                            <?php
                        }
                    }
                ?>
            </div>
        </div>

    </div>

<?php endif; ?>

<div class="formcon" id="service_plan">
    <div class="yuzde30"><?php echo $LANG["service-plan"]; ?></div>
    <div class="yuzde70">
        <?php
            $plans  = $module->getPlans();
            if($plans){
                ?>
                <script type="text/javascript">
                    $(document).ready(function(){

                        <?php if($plann): ?>
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
                    <option value=""><?php echo ___("needs/none"); ?></option>
                    <?php
                        foreach($plans AS $plan){
                            ?>
                            <option<?php echo $plan["name"] == $plann ? ' selected' : ''; ?> value="<?php echo $plan["name"]; ?>"
                                                                                             data-maxpop="<?php echo $plan["maxpop"]; ?>"
                                                                                             data-maxsql="<?php echo $plan["maxdb"]; ?>"
                                                                                             data-maxftp="<?php echo $plan["maxftp"]; ?>"
                                                                                             data-bwlimit="<?php echo $plan["max_traffic"]; ?>"
                                                                                             data-quota="<?php echo $plan["disk_space"]; ?>"
                                                                                             data-maxsub="<?php echo $plan["maxsubdomain"]; ?>"
                                                                                             data-maxaddon="<?php echo $plan["maxaddon"]; ?>"
                            ><?php echo $plan["name"]; ?></option>
                            <?php
                        }
                    ?>
                </select>
                <?php
            }
            elseif($module->error){
                ?>
                <div class="red-info">
                    <div class="padding10">
                        Error: <strong><?php echo $module->error; ?></strong>
                    </div>
                </div>
                <?php
            }
        ?>
    </div>
</div>