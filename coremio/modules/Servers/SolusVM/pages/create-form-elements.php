<?php
    $LANG           = $module->lang;
    $product        = isset($product) && $product ? $product : [];
    $module_data    = isset($product["module_data"]) ? Utility::jdecode($product["module_data"],true) : [];

    $nodes          = $module->nodes_by_types();
    $plans          = $module->plans_by_types();
    $templates      = $module->templates_by_types();
    $list_iso       = $module->list_iso();

    if($module_data){
        $virtualization_type    = isset($module_data["virtualization_type"]) ? $module_data["virtualization_type"] : false;
        $node                   = isset($module_data["node"]) ? $module_data["node"] : false;
        $plan                   = isset($module_data["plan"]) ? $module_data["plan"] : false;
        $template               = isset($module_data["template"]) ? $module_data["template"] : false;
        $extra_ip               = isset($module_data["extra_ip"]) ? $module_data["extra_ip"] : false;
        $use_def_lginfo         = isset($module_data["use_default_login_info"]) ? $module_data["use_default_login_info"] : false;
        $def_username           = isset($module_data["default_username"]) ? $module_data["default_username"] : false;
        $def_password           = isset($module_data["default_password"]) ? $module_data["default_password"] : false;
    }else{
        $virtualization_type    = false;
        $node                   = false;
        $plan                   = false;
        $template               = false;
        $extra_ip               = false;
        $def_username           = "";
        $def_password           = "";
        $use_def_lginfo         = false;
    }
?>
<script type="text/javascript">
    var vz_type     = "<?php echo $virtualization_type; ?>";
    var s_node      = "<?php echo $node; ?>";
    var s_plan      = "<?php echo $plan; ?>";
    var s_template  = "<?php echo $template; ?>";
    var nodes       = <?php echo $nodes ? Utility::jencode($nodes) : "{}"; ?>;
    var plans       = <?php echo $plans ? Utility::jencode($plans) : "{}"; ?>;
    var templates   = <?php echo $templates ? Utility::jencode($templates) : "{}"; ?>;
    var list_iso    = <?php echo $list_iso ? Utility::jencode($list_iso) : "{}"; ?>;
    $(document).ready(function(){
        fetch_nodes(vz_type,s_node);
        fetch_plans(vz_type,s_plan);
        fetch_templates(vz_type,s_template);

        $("#SolusVM_type").change(function(){
            fetch_nodes($(this).val(),s_node);
            fetch_plans($(this).val(),s_plan);
            fetch_templates($(this).val(),s_template);
        });
    });

    function fetch_nodes(type,selected){
        if(nodes[type]){
            $("#SolusVM_node").html('<option value=""><?php echo ___("needs/select-your"); ?></option>');
            $.each(nodes[type],function(k,v){
                $("#SolusVM_node").append('<option'+(selected === v ? ' selected' : '')+' value="'+v+'">'+v+'</option>');
            });
        }else
            $("#SolusVM_node").html('<option value=""><?php echo ___("needs/none"); ?></option>');
    }
    function fetch_plans(type,selected){
        if(plans[type]){
            $("#SolusVM_plan").html('<option value=""><?php echo ___("needs/select-your"); ?></option>');
            $.each(plans[type],function(k,v){
                $("#SolusVM_plan").append('<option'+(selected === v ? ' selected' : '')+' value="'+v+'">'+v+'</option>');
            });
        }else
            $("#SolusVM_plan").html('<option value=""><?php echo ___("needs/none"); ?></option>');
    }
    function fetch_templates(type,selected){
        var have=false,iso_group='';
        if(templates[type]){
            have = true;
            $("#SolusVM_template").html('<option value=""><?php echo ___("needs/select-your"); ?></option>');
            $.each(templates[type],function(k,v){
                $("#SolusVM_template").append('<option'+(selected === v.name ? ' selected' : '')+' value="'+v.name+'">'+v.name+(v.os != '' ? ' ('+v.os+')' : '')+'</option>');
            });
        }

        if(list_iso[type]){
            if(!have) $("#SolusVM_template").html('<option value=""><?php echo ___("needs/select-your"); ?></option>');
            have = true;
            iso_group = '<optgroup label="<?php echo $LANG["iso"]; ?>">';
            $.each(list_iso[type],function(k,v){
                iso_group += '<option'+(selected === v ? ' selected' : '')+' value="'+v+'">'+v+'</option>';
            });
            iso_group += '</optgroup>';

            $("#SolusVM_template").append(iso_group);
        }

        if(!have) $("#SolusVM_template").html('<option value=""><?php echo ___("needs/none"); ?></option>');
    }
</script>
<div class="formcon">
    <div class="yuzde30"><?php echo $LANG["virtualization_type"]; ?></div>
    <div class="yuzde70">
        <select name="module_data[virtualization_type]" id="SolusVM_type">
            <option value=""><?php echo ___("needs/select-your"); ?></option>
            <?php
                if($module->config["virtualization-types"]){
                    foreach($module->config["virtualization-types"] AS $vz_key => $vz_name){
                        ?>
                        <option<?php echo $virtualization_type == $vz_key ? " selected" : ''; ?> value="<?php echo $vz_key; ?>"><?php echo $vz_name; ?></option>
                        <?php
                    }
                }
            ?>
        </select>
    </div>
</div>

<div class="formcon">
    <div class="yuzde30"><?php echo $LANG["node"]; ?></div>
    <div class="yuzde70">
        <select name="module_data[node]" id="SolusVM_node"></select>
    </div>
</div>


<div class="formcon">
    <div class="yuzde30"><?php echo $LANG["plan"]; ?></div>
    <div class="yuzde70">
        <select name="module_data[plan]" id="SolusVM_plan"></select>
    </div>
</div>

<div class="formcon">
    <div class="yuzde30"><?php echo $LANG["template"]; ?></div>
    <div class="yuzde70">
        <select name="module_data[template]" id="SolusVM_template"></select>
    </div>
</div>

<div class="formcon">
    <div class="yuzde30"><?php echo $LANG["extra-ip"]; ?></div>
    <div class="yuzde70">
        <input type="number" name="module_data[extra_ip]" value="<?php echo $extra_ip; ?>" onkeypress='return event.charCode>= 48 &&event.charCode<= 57' style="width:100px;" min="0">
    </div>
</div>

<div class="formcon">
    <div class="yuzde30"><?php echo $LANG["use-default-login-info"]; ?></div>
    <div class="yuzde70">
        <input<?php echo $use_def_lginfo ? ' checked' : ''; ?> type="checkbox" name="module_data[use_default_login_info]" id="CyberVM_use_default_login_info" class="sitemio-checkbox" value="1" onchange="if($(this).prop('checked')) $('#use_default_login_info_wrap').fadeIn(); else $('#use_default_login_info_wrap').fadeOut();">
        <label class="sitemio-checkbox-label" for="CyberVM_use_default_login_info"></label>
        <span class="kinfo"><?php echo $LANG["use-default-login-info-desc"]; ?></span>
        <div id="use_default_login_info_wrap" style="<?php echo $use_def_lginfo ? '' : 'display:none;'; ?>">

            <div class="formcon">
                <div class="yuzde30"><?php echo $LANG["username"]; ?></div>
                <div class="yuzde70">
                    <input type="text" name="module_data[default_username]" value="<?php echo $def_username; ?>">
                </div>
            </div>

            <div class="formcon">
                <div class="yuzde30"><?php echo $LANG["password"]; ?></div>
                <div class="yuzde70">
                    <input type="text" name="module_data[default_password]" value="<?php echo $def_password; ?>">
                </div>
            </div>

        </div>
    </div>
</div>