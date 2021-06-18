<?php
    $LANG           = $module->lang;
    $product        = isset($product) && $product ? $product : [];
    $module_data    = isset($product["module_data"]) ? Utility::jdecode($product["module_data"],true) : [];

    $server         = isset($module_data["server"]) ? $module_data["server"] : false;
    $iso            = isset($module_data["iso"]) ? $module_data["iso"] : false;
    $rebuild_iso    = isset($module_data["rebuild_iso"]) ? $module_data["rebuild_iso"] : false;

    if($module_data){
        $os             = isset($module_data["os"]) ? $module_data["os"] : false;
        $datastore      = isset($module_data["datastore"]) ? $module_data["datastore"] : false;
        $space          = isset($module_data["space"]) ? $module_data["space"] : false;
        $bandwidth      = isset($module_data["bandwidth"]) ? $module_data["bandwidth"] : false;
        $ram            = isset($module_data["ram"]) ? $module_data["ram"] : false;
        $cpu            = isset($module_data["cpu"]) ? $module_data["cpu"] : false;
        $core           = isset($module_data["core"]) ? $module_data["core"] : false;
        $vnc            = isset($module_data["vnc"]) ? $module_data["vnc"] : false;
        $prefix         = isset($module_data["prefix"]) ? $module_data["prefix"] : false;
        $use_def_lginfo = isset($module_data["use_default_login_info"]) ? $module_data["use_default_login_info"] : false;
        $def_username   = isset($module_data["default_username"]) ? $module_data["default_username"] : false;
        $def_password   = isset($module_data["default_password"]) ? $module_data["default_password"] : false;
    }else{
        $os             = '';
        $datastore      = "datastore1";
        $space          = "1";
        $bandwidth      = "";
        $ram            = "1024";
        $cpu            = "";
        $core           = "1";
        $vnc            = false;
        $prefix         = "WiseCP";
        $def_username   = "";
        $def_password   = "";
        $use_def_lginfo = false;
    }

?>

<div class="formcon">
    <div class="yuzde30"><?php echo $LANG["server"]; ?></div>
    <div class="yuzde70">
        <script type="text/javascript">
            var selected_server     = '<?php echo $server?>';
            var selected_iso        = '<?php echo $iso?>';
            var rebuild_iso         = <?php echo $rebuild_iso ? Utility::jencode($rebuild_iso) : '{}'; ?>;
            function CyberVM_change_server(elem){
                var option  = $("select[name='module_data[server]'] option:selected");
                var iso     = option.data("iso");

                var iso_list        = '<option value=""><?php echo ___("needs/none"); ?></option>';
                var rbd_iso_list    = '';

                if(iso){
                    $(iso).each(function(k,i){
                        iso_list += '<option'+((selected_iso && i.name == selected_iso) ? ' selected' : '')+' value="'+i.name+'">'+i.name+'</option>';
                        rbd_iso_list += '<option'+((rebuild_iso && in_array(i.name,rebuild_iso)) ? ' selected' : '')+' value="'+i.name+'">'+i.name+'</option>';
                    });
                }

                $("select[name='module_data[iso]']").html(iso_list);
                $("#rebuild_iso").html(rbd_iso_list);
            }

            $(document).ready(function(){
                if(selected_server) $("select[name='module_data[server]'] option[value='"+selected_server+"']").prop("selected",true).trigger("change");
            });
        </script>
        <select name="module_data[server]" onchange="CyberVM_change_server();">
            <option value=""><?php echo ___("needs/select-your"); ?></option>
            <?php
                $servers            = $module->server_list();
                $iso_list           = $module->iso_list();
                $server_iso_list    = [];
                if($iso_list) foreach($iso_list AS $item) $server_iso_list[$item["server"]][] = $item;

                if($servers){
                    foreach($servers AS $server){
                        $split          = explode("_",$server);
                        $server_id      = $split[0];
                        $server_name    = $split[1];
                        ?>
                        <option value="<?php echo $server; ?>" data-iso='<?php echo isset($server_iso_list[$server_name]) ? Utility::jencode($server_iso_list[$server_name]) : ''; ?>'><?php echo $server_id." | ".$server_name; ?></option>
                        <?php
                    }
                }
            ?>
        </select>
        <?php
            if(!$servers && $module->error){
                ?>
                <div class="red-info">
                    <div class="padding10"><?php echo $module->error; ?></div>
                </div>
                <?php
            }
        ?>
    </div>
</div>

<div class="formcon">
    <div class="yuzde30"><?php echo $LANG["iso"]; ?></div>
    <div class="yuzde70">
        <select name="module_data[iso]">
            <option value=""><?php echo ___("needs/none"); ?></option>
        </select>
    </div>
</div>

<div class="formcon">
    <div class="yuzde30">
        <?php echo $LANG["allowed-iso"]; ?>
        <div class="clear"></div>
        <span class="kinfo"><?php echo $LANG["allowed-iso-info"]; ?></span>
    </div>
    <div class="yuzde70">
        <select id="rebuild_iso" name="module_data[rebuild_iso][]" multiple style="height: 200px;"></select>
    </div>
</div>


<div class="formcon">
    <div class="yuzde30"><?php echo $LANG["os"]; ?></div>
    <div class="yuzde70">
        <select name="module_data[os]">
            <option value=""><?php echo ___("needs/none"); ?></option>
            <?php
                if($module->config["os-list"]){
                    foreach($module->config["os-list"] AS $os_name){
                        $selected = $os == $os_name;
                        ?><option<?php echo  $selected ? ' selected' : ''; ?> value="<?php echo $os_name; ?>"><?php echo $os_name; ?></option><?php
                    }
                }
            ?>
        </select>
    </div>
</div>

<div class="formcon">
    <div class="yuzde30">Datastore</div>
    <div class="yuzde70">
        <input type="text" name="module_data[datastore]" value="<?php echo $datastore; ?>">
    </div>
</div>

<div class="formcon">
    <div class="yuzde30"><?php echo $LANG["disk-space"]; ?> (GB)</div>
    <div class="yuzde70">
        <input type="text" name="module_data[space]" value="<?php echo $space; ?>" style="width: 100px;" onkeypress='return event.charCode>= 48 &&event.charCode<= 57'>
    </div>
</div>

<div class="formcon">
    <div class="yuzde30"><?php echo $LANG["bandwidth"]; ?> (GB)</div>
    <div class="yuzde70">
        <input type="text" name="module_data[bandwidth]" value="<?php echo $bandwidth; ?>" style="width: 100px;" onkeypress='return event.charCode>= 48 &&event.charCode<= 57'>
        <span class="kinfo"><?php echo $LANG["unlmt-desc"]; ?></span>
    </div>
</div>

<div class="formcon">
    <div class="yuzde30">RAM (MB)</div>
    <div class="yuzde70">
        <input type="text" name="module_data[ram]" value="<?php echo $ram; ?>" style="width: 100px;" onkeypress='return event.charCode>= 48 &&event.charCode<= 57'>
    </div>
</div>

<div class="formcon">
    <div class="yuzde30">CPU (Mhz)</div>
    <div class="yuzde70">
        <input type="text" name="module_data[cpu]" value="<?php echo $cpu; ?>" style="width: 100px;" onkeypress='return event.charCode>= 48 &&event.charCode<= 57'>
        <span class="kinfo"><?php echo $LANG["unlmt-desc"]; ?></span>
    </div>
</div>

<div class="formcon">
    <div class="yuzde30">CPU Core</div>
    <div class="yuzde70">
        <input type="text" name="module_data[core]" value="<?php echo $core; ?>" style="width: 100px;" onkeypress='return event.charCode>= 48 &&event.charCode<= 57'>
        <span class="kinfo"><?php echo $LANG["core-desc"]; ?></span>
    </div>
</div>

<div class="formcon">
    <div class="yuzde30"><?php echo $LANG["vnc"]; ?></div>
    <div class="yuzde70">
        <input<?php echo $vnc ? ' checked' : ''; ?> type="checkbox" class="sitemio-checkbox" name="module_data[vnc]" value="1" id="CyberVM_vnc">
        <label class="sitemio-checkbox-label" for="CyberVM_vnc"></label>
    </div>
</div>


<div class="formcon">
    <div class="yuzde30">VPS Prefix</div>
    <div class="yuzde70">
        <input type="text" name="module_data[prefix]" value="<?php echo $prefix; ?>">
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