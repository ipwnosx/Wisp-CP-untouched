<?php
    $LANG           = $module->lang;
    $order          = isset($order) && $order ? $order : [];
    $options        = isset($order["options"]) ? $order["options"] : [];
    $config         = isset($options["config"]) ? $options["config"] : [];
    $creation_info  = isset($options["creation_info"]) ? $options["creation_info"] : [];
    $plann          = isset($creation_info["plan"]) ? $creation_info["plan"] : false;
    $reseller       = isset($creation_info["reseller"]) ? $creation_info["reseller"] : false;
    $enableaclmt    = isset($creation_info["enable_account_limit"]) ? $creation_info["enable_account_limit"] : false;
    $enablerslmts   = isset($creation_info["enable_resource_limits"]) ? $creation_info["enable_resource_limits"] : false;
    $aclmt          = isset($creation_info["account_limit"]) ? $creation_info["account_limit"] : false;
    $disk_limit     = isset($creation_info["disk_limit"]) ? $creation_info["disk_limit"] : false;
    $bandwidth_limit= isset($creation_info["bandwidth_limit"]) ? $creation_info["bandwidth_limit"] : false;
    $acllist        = isset($creation_info["acllist"]) ? $creation_info["acllist"] : false;
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

<?php if($module->config["owner"] == "root"): ?>
    <script type="text/javascript">
        $(document).mouseup(function(e){
            var rsdisk_limit_container       = $("#rslmts_disk_limit_container");
            var rsbandwidth_limit_container  = $("#rslmts_bandwidth_limit_container");
            var account_limit_container      = $("#aclmt_container");

            if(!rsdisk_limit_container.is(e.target) && rsdisk_limit_container.has(e.target).length === 0){
                if($('#rslmts_disk_limit').val()==''){
                    $('#rslmts_disk_limit').attr('readonly',true);
                    $('#rslmts_disk_limit_unlimited').prop('checked',true);
                }
            }

            if(!rsbandwidth_limit_container.is(e.target) && rsbandwidth_limit_container.has(e.target).length === 0){
                if($('#rslmts_bandwidth_limit').val()==''){
                    $('#rslmts_bandwidth_limit').attr('readonly',true);
                    $('#rslmts_bandwidth_limit_unlimited').prop('checked',true);
                }
            }

            if(!account_limit_container.is(e.target) && account_limit_container.has(e.target).length === 0){
                if($('#aclmt input').val()=='' && $("#enableaclmt").prop('checked')){
                    $("#enableaclmt").prop('checked',false).trigger("change");
                }
            }
        });

        $(document).ready(function(){
            <?php if($disk_limit): ?>
            $("#rslmts_disk_limit").val('<?php echo $disk_limit;?>').attr("readonly",false);
            $("#rslmts_disk_limit_unlimited").prop("checked",false);
            <?php endif; ?>
            <?php if($bandwidth_limit): ?>
            $("#rslmts_bandwidth_limit").val('<?php echo $bandwidth_limit;?>').attr("readonly",false);
            $("#rslmts_bandwidth_limit_unlimited").prop("checked",false);
            <?php endif; ?>

            var rvalue1,pvalue1,rvalue2,pvalue2,warning1,warning2,warning_text,notclick,sbutton;

            warning_text = '<?php echo nl2br(str_replace("'","\'",$LANG["limit-warning"])); ?>';

            $("#config_reseller").change(function(){
                if($(this).prop("checked")){
                    $("#disk_limit,#disk_limit_unlimited, #rslmts_disk_limit,#bandwidth_limit,#bandwidth_limit_unlimited, #rslmts_bandwidth_limit").change(function(){
                        rvalue1  = $("#rslmts_disk_limit").val();
                        pvalue1  = $("#disk_limit").val();

                        rvalue2  = $("#rslmts_bandwidth_limit").val();
                        pvalue2  = $("#bandwidth_limit").val();

                        rvalue1  = rvalue1 != '' ? parseInt(rvalue1) : 0;
                        rvalue2  = rvalue2 != '' ? parseInt(rvalue2) : 0;
                        pvalue1  = pvalue1 != '' ? parseInt(pvalue1) : 0;
                        pvalue2  = pvalue2 != '' ? parseInt(pvalue2) : 0;

                        warning1  = 0;
                        warning2  = 0;

                        if(rvalue1 == 0) warning1=0;
                        else if(pvalue1 >= rvalue1) warning1++;
                        else if(rvalue1 != 0 && pvalue1 == 0) warning1++;

                        if(rvalue2 == 0) warning2=0;
                        else if(pvalue2 >= rvalue2) warning2++;
                        else if(rvalue2 != 0 && pvalue2 == 0) warning2++;

                        if(!document.getElementById("not-click-button")){
                            if(document.getElementById("hostingForm")){
                                sbutton  = $("#hostingForm_submit");
                            }
                            notclick = sbutton.clone();
                            notclick.attr("id","not-click-button");
                            notclick.css("display","none");
                            sbutton.after(notclick);
                            notclick = $("#not-click-button");
                            notclick.click(function(){
                                $("#disk_limit_unlimited").focus();
                            });
                        }

                        if(warning1>0){
                            if(!document.getElementById("disk_limit_warning"))
                                $("label[for=disk_limit_unlimited]").after('<div id="disk_limit_warning" style="color:red;display: inline-block;"><i class="fa fa-info-circle" aria-hidden="true"></i> '+warning_text+'</div>');
                            else
                                $("#disk_limit_warning").fadeIn(150);
                            sbutton.css("display","none");
                            notclick.css("display","block");
                        }else{
                            sbutton.css("display","block");
                            notclick.css("display","none");
                            $("#disk_limit_warning").fadeOut(150);
                        }

                        if(warning2>0){
                            if(!document.getElementById("bandwidth_limit_warning"))
                                $("label[for=bandwidth_limit_unlimited]").after('<div id="bandwidth_limit_warning" style="color:red;display: inline-block;"><i class="fa fa-info-circle" aria-hidden="true"></i> '+warning_text+'</div>');
                            else
                                $("#bandwidth_limit_warning").fadeIn(150);
                            sbutton.css("display","none");
                            notclick.css("display","block");
                        }else{
                            if(warning1==0){
                                sbutton.css("display","block");
                                notclick.css("display","none");
                            }
                            $("#bandwidth_limit_warning").fadeOut(150);
                        }


                    });
                }
            });

            <?php if($reseller): ?>

            $('#config_reseller').prop('checked',true).trigger("change");

            <?php endif; ?>

        });

        function reseller_change(elem){
            if($(elem).prop('checked')){
                $('#reseller_limits').css('display','block');
            }else{
                $('#reseller_limits').css('display','none');
            }
        }
    </script>
    <div class="formcon" style="<?php echo $reseller ? 'display: none;' : ''; ?>">
        <div class="yuzde30"><?php echo $LANG["reseller-account"]; ?></div>
        <div class="yuzde70">
            <input type="checkbox" name="creation_info[reseller]" value="1" id="config_reseller" class="sitemio-checkbox" onchange="reseller_change(this);">
            <label for="config_reseller" class="sitemio-checkbox-label"></label>
        </div>
    </div>

    <div class="formcon" id="reseller_limits" style="<?php echo $reseller ? '' : 'display:none;'; ?>">

        <div class="yuzde30"><?php echo $LANG["reseller-settings"]; ?></div>
        <div class="yuzde70">

            <div class="formcon">
                <div class="yuzde30"><?php echo $LANG["account-open-limit-apply"]; ?></div>
                <div class="yuzde70">

                    <input<?php echo $enableaclmt ? ' checked' : ''; ?> type="checkbox" name="creation_info[enable_account_limit]" value="1" class="checkbox-custom" id="enableaclmt" onchange="if($(this).prop('checked')) $('#aclmt').css('display','block'); else $('#aclmt').css('display','none');">
                    <label class="checkbox-custom-label" for="enableaclmt"></label>

                </div>
            </div>

            <div class="formcon" id="aclmt" style="<?php echo $enableaclmt ? '' : 'display:none;'; ?>">
                <div class="yuzde30"><?php echo $LANG["account-open-limit"]; ?></div>
                <div class="yuzde70" id="aclmt_container">
                    <input type="number" name="creation_info[account_limit]" value="<?php echo $aclmt; ?>" onkeypress='return event.charCode>= 48 &&event.charCode<= 57' onkeyup="if($(this).val() != '' && $(this).val() == 0) $(this).val(1);" style="width: 80px;" min="1">
                </div>
            </div>

            <div class="formcon">
                <div class="yuzde30"><?php echo $LANG["limit-resource-usage"]; ?></div>
                <div class="yuzde70">

                    <input<?php echo $enablerslmts ? ' checked' : ''; ?> type="checkbox" name="creation_info[enable_resource_limits]" value="1" class="checkbox-custom" id="enablerslmts" onchange="if($(this).prop('checked')) $('#rslmts').css('display','block'); else $('#rslmts').css('display','none'),$('#rslmts_disk_limit_unlimited,#rslmts_bandwidth_limit_unlimited').prop('checked',true).trigger('change');">
                    <label class="checkbox-custom-label" for="enablerslmts"></label>

                </div>
            </div>

            <div id="rslmts" style="<?php echo $enablerslmts ? '' : 'display:none;'; ?>">

                <div class="formcon">
                    <div class="yuzde30"><?php echo __("admin/products/add-new-product-hosting-disk-limit"); ?></div>
                    <div class="yuzde70" id="rslmts_disk_limit_container">
                        <input readonly="readonly" style="width:80px;" name="creation_info[disk_limit]" id="rslmts_disk_limit" type="text" value="" onkeyup="if($(this).val().length>0) $('#rslmts_disk_limit_unlimited').prop('checked',false); else $('#rslmts_disk_limit_unlimited').prop('checked',true);" onkeypress='return event.charCode>= 48 &&event.charCode<= 57' onclick="if(!$('#rslmts_disk_limit_unlimited').prop('disabled')) $(this).attr('readonly',false).trigger('change'),$('#rslmts_disk_limit_unlimited').prop('checked',false);">
                        <input checked id="rslmts_disk_limit_unlimited" class="checkbox-custom" name="rslmts_disk_limit_unlimited" value="1" type="checkbox" onchange="if($(this).prop('checked')) $('#rslmts_disk_limit').attr('readonly',true).val('').trigger('change'); else $('#rslmts_disk_limit').attr('readonly',false).focus().trigger('change');">
                        <label style="margin-right:15px;" for="rslmts_disk_limit_unlimited" class="checkbox-custom-label"><span class="checktext"><?php echo __("admin/products/add-new-product-unlimited"); ?></span></label>
                    </div>
                </div>


                <div class="formcon">
                    <div class="yuzde30"><?php echo __("admin/products/add-new-product-hosting-bandwidth-limit"); ?></div>
                    <div class="yuzde70" id="rslmts_bandwidth_limit_container">
                        <input readonly="readonly" style="width:80px;" name="creation_info[bandwidth_limit]" id="rslmts_bandwidth_limit" type="text" value="" onkeyup="if($(this).val().length>0) $('#rslmts_bandwidth_limit_unlimited').prop('checked',false); else $('#rslmts_bandwidth_limit_unlimited').prop('checked',true);" onkeypress='return event.charCode>= 48 &&event.charCode<= 57' onclick="if(!$('#rslmts_bandwidth_limit_unlimited').prop('disabled')) $(this).attr('readonly',false).trigger('change'),$('#rslmts_bandwidth_limit_unlimited').prop('checked',false);">
                        <input checked id="rslmts_bandwidth_limit_unlimited" class="checkbox-custom" name="rslmts_bandwidth_limit_unlimited" value="1" type="checkbox" onchange="if($(this).prop('checked')) $('#rslmts_bandwidth_limit').attr('readonly',true).val('').trigger('change'); else $('#rslmts_bandwidth_limit').attr('readonly',false).focus().trigger('change');">
                        <label style="margin-right:15px;" for="rslmts_bandwidth_limit_unlimited" class="checkbox-custom-label"><span class="checktext"><?php echo __("admin/products/add-new-product-unlimited"); ?></span></label>
                    </div>
                </div>
            </div>

            <div class="formcon">
                <div class="yuzde30"><?php echo $LANG["reseller-acllist-apply"]; ?></div>
                <div class="yuzde70">
                    <select name="creation_info[acllist]">
                        <option value=""><?php echo $LANG["standard"]; ?></option>
                        <?php
                            $listAcls = $module->getListAcls();
                            if($listAcls){
                                foreach($listAcls AS $acl){
                                    ?><option<?php echo $acllist == $acl["name"] ? ' selected' : ''; ?>><?php echo $acl["name"]; ?></option><?php
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>



        </div>
    </div>

<?php endif; ?>

<div class="formcon" id="plans_wrap">
    <div class="yuzde30"><?php echo $LANG["select-plan"]; ?></div>
    <div class="yuzde70">
        <?php
            $plans  = $module->getPlans();
            if($plans){
                ?>
                <script type="text/javascript">
                    $(document).ready(function(){

                        <?php if($plann): ?>
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
                <select  name="creation_info[plan]" id="creation_info_plan">
                    <option value=""><?php echo ___("needs/none"); ?></option>
                    <?php
                        foreach($plans AS $plan){
                            if($plan["name"] == "default") continue;
                            ?>
                            <option<?php echo $plan["name"] == $plann ? ' selected' : ''; ?> value="<?php echo $plan["name"]; ?>"
                                                                                             data-maxpop="<?php echo $plan["MAXPOP"]; ?>"
                                                                                             data-maxsql="<?php echo $plan["MAXSQL"]; ?>"
                                                                                             data-maxftp="<?php echo $plan["MAXFTP"]; ?>"
                                                                                             data-bwlimit="<?php echo $plan["BWLIMIT"]; ?>"
                                                                                             data-quota="<?php echo $plan["QUOTA"]; ?>"
                                                                                             data-maxsub="<?php echo $plan["MAXSUB"]; ?>"
                                                                                             data-maxaddon="<?php echo $plan["MAXADDON"]; ?>"
                                                                                             data-maxpark="<?php echo $plan["MAXPARK"]; ?>"
                                                                                             data-max_email_per_hour="<?php echo $plan["MAX_EMAIL_PER_HOUR"]; ?>"
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
        ?>
    </div>
</div>
