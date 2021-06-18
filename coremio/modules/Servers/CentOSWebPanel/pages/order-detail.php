<?php
    $LANG           = $module->lang;
    $order          = isset($order) && $order ? $order : [];
    $options        = isset($order["options"]) ? $order["options"] : [];
    $config         = isset($options["config"]) ? $options["config"] : [];
    $creation_info  = isset($options["creation_info"]) ? $options["creation_info"] : [];
    $selected_plan  = isset($creation_info["plan"]) ? $creation_info["plan"] : false;
    $inode          = isset($creation_info["inode"]) ? $creation_info["inode"] : "0";
    $limit_nproc    = isset($creation_info["limit_nproc"]) ? $creation_info["limit_nproc"] : "40";
    $limit_nofile   = isset($creation_info["limit_nofile"]) ? $creation_info["limit_nofile"] : "150";
    $backup         = isset($creation_info["backup"]) ? $creation_info["backup"] : false;
    $reseller       = isset($creation_info["reseller"]) ? $creation_info["reseller"] : false;
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

<div class="formcon">
    <div class="yuzde30">Reseller</div>
    <div class="yuzde70">
        <input<?php echo $reseller ? ' checked' : ''; ?> type="checkbox" name="creation_info[reseller]" value="1" id="cwp_reseller" class="checkbox-custom">
        <label class="checkbox-custom-label" for="cwp_reseller"></label>
    </div>
</div>

<div class="formcon">
    <div class="yuzde30">Inode</div>
    <div class="yuzde70">
        <input type="number" name="creation_info[inode]" value="<?php echo $inode; ?>" style="width: 60px;" onkeypress='return event.charCode>= 48 &&event.charCode<= 57'>
        <span class="kinfo" style="margin-left: 5px;"><?php echo $LANG["define-zero-for-unlimited"]; ?></span>
    </div>
</div>

<div class="formcon">
    <div class="yuzde30"><?php echo $LANG["process-limit"]; ?></div>
    <div class="yuzde70">
        <input type="number" name="creation_info[limit_nproc]" value="<?php echo $limit_nproc; ?>" style="width: 60px;" onkeypress='return event.charCode>= 48 &&event.charCode<= 57'>
    </div>
</div>

<div class="formcon">
    <div class="yuzde30">Open Files</div>
    <div class="yuzde70">
        <input type="number" name="creation_info[limit_nofile]" value="<?php echo $limit_nofile; ?>" style="width: 60px;" onkeypress='return event.charCode>= 48 &&event.charCode<= 57'>
    </div>
</div>

<div class="formcon">
    <div class="yuzde30">Additional Options</div>
    <div class="yuzde70">
        <input<?php echo $backup ? ' checked' : ''; ?> type="checkbox" class="checkbox-custom" name="creation_info[backup]" value="1" id="data-backup">
        <label class="checkbox-custom-label" for="data-backup" style="margin-bottom: 5px;">Backup user account</label>
        <div class="clear"></div>
    </div>
</div>

<div class="formcon" id="plans_wrap">
    <div class="yuzde30"><?php echo $LANG["select-plan"]; ?></div>
    <div class="yuzde70">
        <?php
            $plans      = $module->getPlans();
            $plans_r    = $module->getPlans(true);

            if($plans || $plans_r){
                ?>
                <script type="text/javascript">
                    $(document).ready(function(){

                        <?php if($selected_plan): ?>
                        creation_info_plan_trigger();
                        <?php endif; ?>

                        $("#creation_info_plan_r").change(creation_info_plan_trigger);
                        $("#creation_info_plan").change(creation_info_plan_trigger);

                        $("#cwp_reseller").change(function(){
                            if($(this).prop('checked'))
                            {
                                $("#creation_info_plan").attr("disabled",true).css("display","none");
                                $("#creation_info_plan_r").removeAttr("disabled").css("display","inline-block");
                            }
                            else
                            {
                                $("#creation_info_plan").removeAttr("disabled").css("display","inline-block");
                                $("#creation_info_plan_r").attr("disabled",true)..css("display","none");
                            }
                            creation_info_plan_trigger();
                        });

                    });

                    function creation_info_plan_trigger(){
                        var selected,name;

                        if($('#cwp_reseller').prop('checked'))
                        {
                            selected    = $("option:selected",$("#creation_info_plan_r"));
                            name        = $("#creation_info_plan_r").val();
                        }
                        else
                        {
                            selected    = $("option:selected",$("#creation_info_plan"));
                            name        = $("#creation_info_plan").val();
                        }

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
                <select<?php echo $reseller ? ' disabled style="display:none"' : ''; ?> name="creation_info[plan]" id="creation_info_plan">
                    <?php
                        if($plans)
                        {
                            foreach($plans AS $plan){
                                ?>
                                <option<?php echo $plan["id"] == $selected_plan ? ' selected' : ''; ?> value="<?php echo $plan["id"]; ?>"
                                                                                                       data-maxpop="<?php echo $plan["email_accounts"]; ?>"
                                                                                                       data-maxsql="<?php echo $plan["databases"]; ?>"
                                                                                                       data-maxftp="<?php echo $plan["ftp_accounts"]; ?>"
                                                                                                       data-bwlimit="<?php echo $plan["bandwidth"]; ?>"
                                                                                                       data-quota="<?php echo $plan["disk_quota"]; ?>"
                                                                                                       data-maxsub="<?php echo $plan["sub_domains"]; ?>"
                                                                                                       data-maxaddon="<?php echo $plan["addons_domains"]; ?>"
                                                                                                       data-maxpark="<?php echo $plan["parked_domains"]; ?>"
                                                                                                       data-max_email_per_hour="<?php echo $plan["hourly_emails"]; ?>"
                                ><?php echo $plan["package_name"]; ?></option>
                                <?php
                            }
                        }
                    ?>
                </select>
                <select<?php echo $reseller ? '' : ' disabled style="display:none;"'; ?> name="creation_info[plan]" id="creation_info_plan_r">
                    <?php
                        if($plans)
                        {
                            foreach($plans AS $plan){
                                ?>
                                <option<?php echo $plan["id"] == $selected_plan ? ' selected' : ''; ?> value="<?php echo $plan["id"]; ?>"
                                                                                                       data-maxpop="<?php echo $plan["email_accounts"]; ?>"
                                                                                                       data-maxsql="<?php echo $plan["databases"]; ?>"
                                                                                                       data-maxftp="<?php echo $plan["ftp_accounts"]; ?>"
                                                                                                       data-bwlimit="<?php echo $plan["bandwidth"]; ?>"
                                                                                                       data-quota="<?php echo $plan["disk_quota"]; ?>"
                                                                                                       data-maxsub="<?php echo $plan["sub_domains"]; ?>"
                                                                                                       data-maxaddon="<?php echo $plan["addons_domains"]; ?>"
                                                                                                       data-maxpark="<?php echo $plan["parked_domains"]; ?>"
                                                                                                       data-max_email_per_hour="<?php echo $plan["hourly_emails"]; ?>"
                                ><?php echo $plan["package_name"]; ?></option>
                                <?php
                            }
                        }
                    ?>
                </select>
            <?php
            }
            elseif((!$plans || $plans_r) && $module->error){
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