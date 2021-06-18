<?php
    $types          = $module->config["types"];
    $LANG           = $module->lang;
    $established    = false;
    $options        = $order["options"];
    $creation_info  = isset($options["creation_info"]) ? $options["creation_info"] : [];
    $config         = isset($options["config"]) ? $options["config"] : [];
    if($config && isset($config[$module->entity_id_name])) $established = true;
    $buttons        =  $module->adminArea_buttons_output();

    $types          = $module->config["types"];
    $m_bits         = [
        '128' => '128 KB/s (1 Mbit)',
        '256' => '256 KB/s (2 Mbit)',
        '384' => '384 KB/s (3 Mbit)',
        '512' => '512 KB/s (4 Mbit)',
        '640' => '640 KB/s (5 Mbit)',
        '768' => '768 KB/s (6 Mbit)',
        '896' => '896 KB/s (7 Mbit)',
        '1024' => '1024 KB/s (8 Mbit)',
        '1152' => '1152 KB/s (9 Mbit)',
        '1280' => '1280 KB/s (10 Mbit)',
        '1920' => '1920 KB/s (15 Mbit)',
        '2560' => '2560 KB/s (20 Mbit)',
        '3840' => '3840 KB/s (30 Mbit)',
        '5120' => '5120 KB/s (40 Mbit)',
        '6400' => '6400 KB/s (50 Mbit)',
        '7680' => '7680 KB/s (60 Mbit)',
        '8960' => '8960 KB/s (70 Mbit)',
        '10240' => '10240 KB/s (80 Mbit)',
        '11520' => '11520 KB/s (90 Mbit)',
        '12800' => '12800 KB/s (100 Mbit)',
        '128000' => '128000 KB/s (1000 Mbit)',
        '1280000' => '1280000 KB/s (10000 Mbit)',
    ];
    $types_reverse  = array_flip($types);

    if($creation_info){
        $type               = isset($creation_info["type"]) ? $creation_info["type"] : '';
        $slave_server       = isset($creation_info["slave_server"]) ? $creation_info["slave_server"] : '';
        $plan               = isset($creation_info["plan"]) ? $creation_info["plan"] : '';
        $osid               = isset($creation_info["osid"]) ? $creation_info["osid"] : '';
        $disk_space         = isset($creation_info["disk_space"]) ? $creation_info["disk_space"] : '';
        $ram                = isset($creation_info["ram"]) ? $creation_info["ram"] : '';
        $burst_ram          = isset($creation_info["burst_ram"]) ? $creation_info["burst_ram"] : '';
        $swap_ram           = isset($creation_info["swap_ram"]) ? $creation_info["swap_ram"] : '';
        $bandwidth          = isset($creation_info["bandwidth"]) ? $creation_info["bandwidth"] : '';
        $network_speed      = isset($creation_info["network_speed"]) ? $creation_info["network_speed"] : '';
        $upload_speed       = isset($creation_info["upload_speed"]) ? $creation_info["upload_speed"] : '';
        $cpu_units          = isset($creation_info["cpu_units"]) ? $creation_info["cpu_units"] : '';
        $cpu_cores          = isset($creation_info["cpu_cores"]) ? $creation_info["cpu_cores"] : '';
        $cpu_percent        = isset($creation_info["cpu_percent"]) ? $creation_info["cpu_percent"] : '';
        $priority           = isset($creation_info["priority"]) ? $creation_info["priority"] : '';
        $ips                = isset($creation_info["ips"]) ? $creation_info["ips"] : '';
        $ips6_subnet        = isset($creation_info["ips6_subnet"]) ? $creation_info["ips6_subnet"] : '';
        $ips6               = isset($creation_info["ips6"]) ? $creation_info["ips6"] : '';
        $ips_int            = isset($creation_info["ips_int"]) ? $creation_info["ips_int"] : '';
        $virtio             = isset($creation_info["virtio"]) ? $creation_info["virtio"] : '';
        $vnc                = isset($creation_info["vnc"]) ? $creation_info["vnc"] : '';
        $mgs                = isset($creation_info["mgs"]) ? $creation_info["mgs"] : [];
        $band_suspend       = isset($creation_info["band_suspend"]) ? $creation_info["band_suspend"] : '';
        $dns                = isset($creation_info["dns"]) ? $creation_info["dns"] : [];
        $dns_plan           = isset($creation_info["dns_plan"]) ? $creation_info["dns_plan"] : '';
        $tuntap             = isset($creation_info["tuntap"]) ? $creation_info["tuntap"] : '';
        $osreinstall_limit  = isset($creation_info["osreinstall_limit"]) ? $creation_info["osreinstall_limit"] : '';
        $admin_managed      = isset($creation_info["admin_managed"]) ? $creation_info["admin_managed"] : '';

    }
    else{
        $type               = $types[0];
        $slave_server       = '';
        $plan               = '';
        $osid               = '';
        $disk_space         = '';
        $ram                = '';
        $burst_ram          = '';
        $swap_ram           = '';
        $bandwidth          = '';
        $network_speed      = '';
        $upload_speed       = '';
        $cpu_units          = '';
        $cpu_cores          = '';
        $cpu_percent        = '';
        $priority           = '';
        $ips                = '';
        $ips6_subnet        = '';
        $ips6               = '';
        $ips_int            = '';
        $virtio             = '';
        $vnc                = '';
        $mgs                = [];
        $band_suspend       = '';
        $dns                = [];
        $dns_plan           = '';
        $tuntap             = '';
        $osreinstall_limit  = '';
        $admin_managed      = '';
    }

    $type_key                   = $types[$type];
    if(!$established)
    {
        $servers                = $module->server_list();
        $server_groups          = $module->server_groups();
        $plans                  = $module->get_plans();
        $os_templates           = $module->os_templates();
        $media_groups           = $module->media_groups();
        $dns_plans              = $module->dns_plans();
    }

?>

<?php
    if($buttons){
        ?>
        <div class="formcon">
            <?php echo $buttons; ?>
        </div>
        <div class="clear"></div>
        <?php
    }
?>
<div class="clear"></div>

<div class="formcon">
    <div class="yuzde30"><?php echo $module->entity_id_name; ?></div>
    <div class="yuzde70">
        <input class="yuzde10" type="text" name="config[<?php echo $module->entity_id_name; ?>]" value="<?php echo isset($config[$module->entity_id_name]) ? $config[$module->entity_id_name] : ''; ?>">
    </div>
</div>

<script type="text/javascript">
    function change_plan(el){
        var values = $("option:selected",el).data("values");

        var disk_space              = '';
        var ram                     = '';
        var os_id                   = '';
        var ips                     = '';
        var bandwidth               = '';
        var cpu_cores               = '';
        var network_speed           = '';
        var mgs                     = '';
        var cpu_units               = '';
        var burst_ram               = '';
        var swap_ram                = '';
        var cpu_percent             = '';
        var vnc                     = '';
        var ips6                    = '';
        var ips6_subnet             = '';
        var band_suspend            = '';
        var tuntap                  = '';
        var ips_int                 = '';
        var virtio                  = '';
        var upload_speed            = '';
        var dns                     = '';
        var osreinstall_limit       = '';
        var admin_managed           = '';

        if(typeof values !== 'undefined' && Object.length2(values) > 0){
            disk_space          = values.space;
            ram                 = values.ram;
            os_id               = values.osid;
            ips                 = values.ips;
            bandwidth           = values.bandwidth;
            cpu_cores           = values.cores;
            network_speed       = values.network_speed;
            mgs                 = values.mgs.split(",");
            cpu_units           = values.cpu;
            burst_ram           = values.burst;
            swap_ram            = values['swap'];
            cpu_percent         = values.cpu_percent;
            vnc                 = values.vnc;
            ips6                = values.ips6;
            ips6_subnet         = values.ips6_subnet;
            band_suspend        = values.band_suspend;
            tuntap              = values.tuntap;
            ips_int             = values.ips_int;
            virtio              = values.virtio;
            upload_speed        = values.upload_speed;
            dns                 = values.dns_nameserver;
            osreinstall_limit   = values.osreinstall_limit;
            admin_managed       =  values.admin_managed;
        }


        $("input[name='creation_info[disk_space]']").val(disk_space);
        $("input[name='creation_info[ram]']").val(ram);
        $("select[name='creation_info[osid]']").val(os_id);
        $("input[name='creation_info[ips]']").val(ips);
        $("input[name='creation_info[bandwidth]']").val(bandwidth);
        $("input[name='creation_info[cpu_cores]']").val(cpu_cores);
        $("input[name='creation_info[network_speed]']").val(network_speed);
        $("select[name='creation_info[mgs][]']").val(mgs);
        $("input[name='creation_info[cpu_units]']").val(cpu_units);
        $("input[name='creation_info[burst_ram]']").val(burst_ram);
        $("input[name='creation_info[swap_ram]']").val(swap_ram);
        $("input[name='creation_info[cpu_percent]']").val(cpu_percent);
        $("input[name='creation_info[ips6]']").val(ips6);
        $("input[name='creation_info[ips6_subnet]']").val(ips6_subnet);
        $("input[name='creation_info[ips_int]']").val(ips_int);
        $("input[name='creation_info[virtio]']").val(virtio);
        $("input[name='creation_info[upload_speed]']").val(upload_speed);
        $("input[name='creation_info[osreinstall_limit]']").val(osreinstall_limit);

        $("#dns-items").html('');
        $(dns).each(function(k,v){
            add_dns_item(v);
        });


        $("input[name='creation_info[band_suspend]']").prop('checked',band_suspend === '1');
        $("input[name='creation_info[vnc]']").prop('checked',vnc === '1');
        $("input[name='creation_info[virtio]']").prop('checked',virtio === '1');
        $("input[name='creation_info[tuntap]']").prop('checked',tuntap === '1');
        $("input[name='creation_info[admin_managed]']").prop('checked',admin_managed === '1');


    }

    function change_type(el){
        var opt = $("option:selected",el);

        var key = opt.data("key");

        if(key !== undefined){

            $(".slave-server-types").not('#slave-server-'+key).css("display","none");
            $(".plan-types").not('#plan-'+key).css("display","none");
            $(".os-types").not('#os-'+key).css("display","none");
            $(".mg-types").not('#os-'+key).css("display","none");
            $("#burs_ram_wrap").css("display","none");
            $("#io_priority_wrap").css("display","none");
            $("#virtio_wrap").css("display","none");
            $("#vnc_wrap").css("display","none");
            $("#tuntap_wrap").css("display","none");


            $("#select_slave_server").val('auto');
            $("#select_plan").val(0);
            $("#select_os").val('');
            $("#select_mgs").val('');


            $("#slave-server-"+key).css("display","block");
            $("#plan-"+key).css("display","block");
            $("#os-"+key).css("display","block");
            $("#mg-"+key).css("display","block");
            $("#no_plans_wrap ."+key).css("display","block");

        }
    }
</script>
<div style="<?php echo $established ?  'display:none;' : ''; ?>">
    <div class="formcon">
        <div class="yuzde30">Type</div>
        <div class="yuzde70">
            <select name="creation_info[type]" onchange="change_type(this);">
                <option value=""><?php echo ___("needs/select-your"); ?></option>
                <?php
                    foreach($types AS $row=>$k){
                        ?>
                        <option<?php echo $row == $type ? ' selected' : ''; ?> value="<?php echo $row; ?>" data-key="<?php echo $k; ?>"><?php echo $row; ?></option>
                        <?php
                    }
                ?>
            </select>
        </div>
    </div>

    <div class="formcon">
        <div class="yuzde30">Slave Server</div>
        <div class="yuzde70">
            <select name="creation_info[slave_server]" id="select_slave_server">
                <option value="auto">Auto Select Server</option>
                <optgroup label="Groups">
                    <?php
                        if(isset($server_groups) && $server_groups){
                            foreach($server_groups AS $_group){
                                $k = "G|".$_group["sgid"];
                                ?>
                                <option<?php echo $k == $slave_server ? ' selected' : ''; ?> value="<?php echo $k; ?>"><?php echo $_group["sgid"]." | ".$_group["sg_name"]; ?></option>
                                <?php
                            }
                        }
                    ?>
                </optgroup>
                <?php
                    if($servers){
                        foreach($servers AS $_type => $_servers){
                            if($_servers){
                                $_type_name = $types_reverse[$_type];
                                $_type_name = explode(" ",$_type_name);
                                $_type_name = $_type_name[0];
                                ?>
                                <optgroup label="<?php echo $_type_name; ?>" class="slave-server-types" id="slave-server-<?php echo $_type; ?>"<?php echo $type_key != $_type ? ' style="display:none;"' : ''; ?>>
                                    <?php
                                        foreach($_servers AS $_server){
                                            ?>
                                            <option<?php echo $_type == $types[$type] && $slave_server !== '' && $slave_server === $_server["serid"] ? ' selected' : ''; ?> value="<?php echo $_server["serid"]; ?>"><?php echo $_server["serid"]." | ".$_server["server_name"]; ?></option>
                                            <?php
                                        }
                                    ?>
                                </optgroup>
                                <?php
                            }
                        }
                    }
                ?>
            </select>
        </div>
    </div>

    <div class="formcon">
        <div class="yuzde30">Plan</div>
        <div class="yuzde70">
            <select name="creation_info[plan]" onchange="change_plan(this);" id="select_plan">
                <option value="0"><?php echo ___("needs/none"); ?></option>
                <?php
                    if($plans){
                        foreach($plans AS $_type => $_plans){
                            if($_plans){
                                $_type_name = $types_reverse[$_type];
                                $_type_name = explode(" ",$_type_name);
                                $_type_name = $_type_name[0];
                                ?>
                                <optgroup label="<?php echo $_type_name; ?>" class="plan-types" id="plan-<?php echo $_type; ?>"<?php echo $type_key != $_type ? ' style="display:none;"' : ''; ?>>
                                    <?php
                                        foreach($_plans AS $_plan){
                                            $_plan["dns_nameserver"] = unserialize($_plan["dns_nameserver"]);
                                            $_plan_data = Utility::jencode($_plan);
                                            ?>
                                            <option<?php echo $plan == $_plan["plid"] ? ' selected' : ''; ?> value="<?php echo $_plan["plid"]; ?>" data-values='<?php echo htmlentities($_plan_data,ENT_QUOTES); ?>'><?php echo $_plan["plid"]." | ".$_plan["plan_name"]; ?></option>
                                            <?php
                                        }
                                    ?>
                                </optgroup>
                                <?php
                            }
                        }
                    }
                ?>
            </select>
        </div>
    </div>

    <div id="other_settings">

        <div class="formcon">
            <div class="yuzde30"><?php echo $LANG["os"]; ?></div>
            <div class="yuzde70">
                <select name="creation_info[osid]" id="select_os">
                    <option value=""><?php echo ___("needs/none"); ?></option>
                    <?php
                        if($os_templates){
                            foreach($os_templates AS $_type => $_os_templates){
                                if($_os_templates){
                                    $_type_name = $types_reverse[$_type];
                                    $_type_name = explode(" ",$_type_name);
                                    $_type_name = $_type_name[0];
                                    ?>
                                    <optgroup label="<?php echo $_type_name; ?>" class="os-types" id="os-<?php echo $_type; ?>"<?php echo $type_key != $_type ? ' style="display:none;"' : ''; ?>>
                                        <?php
                                            foreach($_os_templates AS $_os){
                                                ?>
                                                <option<?php echo $osid == $_os["osid"] ? ' selected' : ''; ?> value="<?php echo $_os["osid"]; ?>"><?php echo $_os["osid"]." | ".$_os["name"]; ?></option>
                                                <?php
                                            }
                                        ?>
                                    </optgroup>
                                    <?php
                                }
                            }
                        }
                    ?>
                </select>
            </div>
        </div>

        <div class="formcon">
            <div class="yuzde30"><?php echo $LANG["disk-space"]; ?> (GB)</div>
            <div class="yuzde70">
                <input type="text" name="creation_info[disk_space]" value="<?php echo $disk_space; ?>" style="width: 100px;" onkeypress='return event.charCode>= 48 &&event.charCode<= 57'>
            </div>
        </div>

        <div class="formcon">
            <div class="yuzde30">RAM (MB)</div>
            <div class="yuzde70">
                <input type="text" name="creation_info[ram]" value="<?php echo $ram; ?>" style="width: 100px;" onkeypress='return event.charCode>= 48 &&event.charCode<= 57'>
            </div>
        </div>

        <div class="formcon kvm xen xcp lxc vzk vzo proxk proxo proxl" id="swap_ram_wrap" style="<?php echo !in_array($type_key,['kvm','xen','xcp','lxc','vzk','vzo','proxk','proxo','proxl']) ? 'display:none;' :'' ;?>">
            <div class="yuzde30">Swap RAM (MB)</div>
            <div class="yuzde70">
                <input type="text" name="creation_info[swap_ram]" value="<?php echo $swap_ram; ?>" style="width: 100px;" onkeypress='return event.charCode>= 48 &&event.charCode<= 57'>
            </div>
        </div>

        <div class="formcon openvz" id="burs_ram_wrap" style="<?php echo !in_array($type_key,['openvz']) ? 'display:none;' :'' ;?>">
            <div class="yuzde30">Burstable RAM (MB)</div>
            <div class="yuzde70">
                <input type="text" name="creation_info[burst_ram]" value="<?php echo $burst_ram; ?>" style="width: 100px;" onkeypress='return event.charCode>= 48 &&event.charCode<= 57'>
            </div>
        </div>

        <div class="formcon">
            <div class="yuzde30"><?php echo $LANG["bandwidth"]; ?> (GB)</div>
            <div class="yuzde70">
                <input type="text" name="creation_info[bandwidth]" value="<?php echo $bandwidth; ?>" style="width: 100px;" onkeypress='return event.charCode>= 48 &&event.charCode<= 57'>
                <span class="kinfo"><?php echo $LANG["unlmt-desc"]; ?></span>
            </div>
        </div>

        <div class="formcon">
            <div class="yuzde30">Network Speed (KB/s)</div>
            <div class="yuzde70">
                <input type="text" name="creation_info[network_speed]" id="network_speed_input" value="<?php echo $network_speed; ?>" style="width: 100px;" onkeypress='return event.charCode>= 48 &&event.charCode<= 57'>
                <select onchange="$('#network_speed_input').val(this.options[this.selectedIndex].value);" style="width: 150px;">
                    <option value="" selected="selected">No Restriction</option>
                    <?php
                        foreach($m_bits AS $k=>$v){
                            ?>
                            <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                            <?php
                        }
                    ?>
                </select>
                <div class="clear"></div>
                <span class="kinfo"><?php echo $LANG["unlmt-desc2"]; ?></span>
            </div>
        </div>

        <div class="formcon">
            <div class="yuzde30">CPU Units</div>
            <div class="yuzde70">
                <input type="text" name="creation_info[cpu_units]" value="<?php echo $cpu_units; ?>" style="width: 100px;" onkeypress='return event.charCode>= 48 &&event.charCode<= 57'>
            </div>
        </div>

        <div class="formcon">
            <div class="yuzde30">CPU Cores</div>
            <div class="yuzde70">
                <input type="text" name="creation_info[cpu_cores]" value="<?php echo $cpu_cores; ?>" style="width: 100px;" onkeypress='return event.charCode>= 48 &&event.charCode<= 57'>
            </div>
        </div>

        <div class="formcon">
            <div class="yuzde30">CPU %</div>
            <div class="yuzde70">
                <input type="text" name="creation_info[cpu_percent]" value="<?php echo $cpu_percent; ?>" style="width: 100px;" onkeypress='return event.charCode>= 48 &&event.charCode<= 57'>
                <span class="kinfo"><?php echo $LANG["unlmt-desc"]; ?></span>
            </div>
        </div>

        <div class="formcon openvz vzo vzk proxo" id="io_priority_wrap" style="<?php echo !in_array($type_key,['openvz','vzo','vzk','proxo']) ? 'display:none;' :'' ;?>">
            <div class="yuzde30">I/O priority</div>
            <div class="yuzde70">
                <select name="creation_info[priority]" style="width: 100px;">
                    <?php
                        foreach(range(0,7) AS $i){
                            ?><option<?php echo $i == $priority ? ' selected' : ''; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option><?php
                        }
                    ?>
                </select>
            </div>
        </div>

        <div class="formcon">
            <div class="yuzde30">Number of IPs</div>
            <div class="yuzde70">
                <input type="text" name="creation_info[ips]" value="<?php echo $ips; ?>" style="width: 100px;" onkeypress='return event.charCode>= 48 &&event.charCode<= 57'>
            </div>
        </div>

        <div class="formcon">
            <div class="yuzde30">Number of IPv6 Subnets</div>
            <div class="yuzde70">
                <input type="text" name="creation_info[ips6_subnet]" value="<?php echo $ips6_subnet; ?>" style="width: 100px;" onkeypress='return event.charCode>= 48 &&event.charCode<= 57'>
            </div>
        </div>

        <div class="formcon">
            <div class="yuzde30">Number of IPv6 Addresses</div>
            <div class="yuzde70">
                <input type="text" name="creation_info[ips6]" value="<?php echo $ips6; ?>" style="width: 100px;" onkeypress='return event.charCode>= 48 &&event.charCode<= 57'>
            </div>
        </div>


        <div class="formcon">
            <div class="yuzde30">Number of Internal IPs</div>
            <div class="yuzde70">
                <input type="text" name="creation_info[ips_int]" value="<?php echo $ips_int; ?>" style="width: 100px;" onkeypress='return event.charCode>= 48 &&event.charCode<= 57'>
            </div>
        </div>

        <div class="formcon kvm" id="virtio_wrap" style="<?php echo !in_array($type_key,['kvm']) ? 'display:none;' :'' ;?>">
            <div class="yuzde30">Enable Virtio</div>
            <div class="yuzde70">
                <input type="checkbox" name="creation_info[virtio]" class="checkbox-custom" id="enable_virtio"<?php echo $virtio ? ' checked' : ''; ?> value="1">
                <label class="checkbox-custom-label" for="enable_virtio"></label>
            </div>
        </div>

        <div class="formcon kvm xen xenhvm xcp xcphvm proxk vzk vzo" id="vnc_wrap" style="<?php echo !in_array($type_key,['kvm','xen','xcp','proxk','vzk','vzo']) ? 'display:none;' :'' ;?>">
            <div class="yuzde30">Enable VNC</div>
            <div class="yuzde70">
                <input type="checkbox" name="creation_info[vnc]" class="checkbox-custom" id="enable_vnc"<?php echo $vnc ? ' checked' : ''; ?> value="1">
                <label class="checkbox-custom-label" for="enable_vnc"></label>
            </div>
        </div>


        <div class="formcon">
            <div class="yuzde30">Media Groups</div>
            <div class="yuzde70">
                <select multiple name="creation_info[mgs][]" id="select_mgs">
                    <?php
                        if($media_groups){
                            foreach($media_groups AS $_type => $_media_groups){
                                if($_media_groups){
                                    $_type_name = $types_reverse[$_type];
                                    $_type_name = explode(" ",$_type_name);
                                    $_type_name = $_type_name[0];
                                    ?>
                                    <optgroup label="<?php echo $_type_name; ?>" class="mg-types" id="mg-<?php echo $_type; ?>"<?php echo $type_key != $_type ? ' style="display:none;"' : ''; ?>>
                                        <?php
                                            foreach($_media_groups AS $_mg){
                                                ?>
                                                <option<?php echo in_array($_mg["mgid"],$mgs) ? ' selected' : ''; ?> value="<?php echo $_mg["mgid"]; ?>"><?php echo $_mg["mgid"]." | ".$_mg["mg_name"]; ?></option>
                                                <?php
                                            }
                                        ?>
                                    </optgroup>
                                    <?php
                                }
                            }
                        }
                    ?>
                </select>
            </div>
        </div>

        <script type="text/javascript">
            $(document).ready(function(){
                $("#VirtualizorAccordion").accordion({
                    heightStyle: "content",
                    collapsible:true,
                    active:false,
                });
            });
        </script>

        <div class="clear"></div>

        <div class="formcon">
            <div id="VirtualizorAccordion">

                <!-- accordion item start -->
                <h3>Network Settings</h3>
                <div>

                    <div class="formcon">
                        <div class="yuzde30">Upload Speed</div>
                        <div class="yuzde70">
                            <input type="text" name="creation_info[upload_speed]" id="upload_speed_input" value="<?php echo $upload_speed; ?>" style="width: 100px;" onkeypress='return event.charCode>= 48 &&event.charCode<= 57'>
                            <select onchange="$('#upload_speed_input').val(this.options[this.selectedIndex].value);" style="width: 150px;">
                                <option value="" selected="selected">No Restriction</option>
                                <?php
                                    foreach($m_bits AS $k=>$v){
                                        ?>
                                        <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                            <div class="clear"></div>
                            <span class="kinfo"><?php echo $LANG["unlmt-desc2"]; ?></span>

                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30">Bandwidth suspend</div>
                        <div class="yuzde70">
                            <input type="checkbox" name="creation_info[band_suspend]" class="checkbox-custom" id="band_suspend"<?php echo $band_suspend ? ' checked' : ''; ?> value="1">
                            <label class="checkbox-custom-label" for="band_suspend"></label>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30">DNS Plan</div>
                        <div class="yuzde70">
                            <select name="creation_info[dns_plan]" id="select_dns_plan">
                                <option value="0"><?php echo ___("needs/none"); ?></option>
                                <?php
                                    if($dns_plans){
                                        foreach($dns_plans AS $_dns_plan){
                                            ?>
                                            <option<?php echo $dns_plan == $_dns_plan["dnsplid"] ? ' selected' : ''; ?> value="<?php echo $_dns_plan["dnsplid"]; ?>"><?php echo $_dns_plan["dnsplid"]." | ".$_dns_plan["plan_name"]; ?></option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30">
                            DNS Nameservers
                            <br>
                            <span class="kinfo">If not aware then use 4.2.2.1 and 4.2.2.2</span>
                        </div>
                        <div class="yuzde70">

                            <script type="text/javascript">
                                function add_dns_item(value){
                                    var template =
                                        '<div class="dns-item">\n' +
                                        '<input type="text" name="dns[]" value="'+value+'" style="width:200px;margin-right:10px;">\n' +
                                        '<a style="width: 40px;" href="javascript:void 0;" class="sbtn red" onclick="remove_dns_item(this);"><i class="fa fa-trash" aria-hidden="true"></i></a>\n' +
                                        '</div>';

                                    $("#dns-items").append(template);
                                }

                                function remove_dns_item(el){
                                    $(el).parent().remove();
                                }

                            </script>

                            <div id="dns-items">
                                <?php
                                    if($dns){
                                        foreach($dns AS $dn){
                                            ?>
                                            <div class="dns-item">
                                                <input type="text" name="dns[]" value="<?php echo $dn; ?>" style="width:200px; margin-right:10px;">
                                                <a style="width: 40px;" href="javascript:void 0;" class="sbtn red" onclick="remove_dns_item(this);"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                            </div>
                                            <?php
                                        }
                                    }
                                ?>
                            </div>
                            <div class="clear"></div>
                            <br>
                            <a class="lbtn green" onclick="add_dns_item();"><i class="fa fa-plus" aria-hidden="true"></i></a>

                        </div>
                    </div>

                    <div class="clear"></div>
                </div>
                <!-- accordion item end -->

                <!-- accordion item start -->
                <h3>Advanced Options</h3>
                <div>

                    <div class="formcon openvz" id="tuntap_wrap" style="<?php echo !in_array($type_key,['openvz']) ? 'display:none;' :'' ;?>">
                        <div class="yuzde30">Enable Tun/Tap</div>
                        <div class="yuzde70">
                            <input type="checkbox" name="creation_info[tuntap]" class="checkbox-custom" id="tuntap"<?php echo $tuntap ? ' checked' : ''; ?> value="1">
                            <label class="checkbox-custom-label" for="tuntap"></label>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30">OS Reinstall Limit</div>
                        <div class="yuzde70">
                            <input type="text" name="creation_info[osreinstall_limit]" value="<?php echo $osreinstall_limit; ?>" style="width: 100px;" onkeypress='return event.charCode>= 48 &&event.charCode<= 57'>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30">Managed by Admin</div>
                        <div class="yuzde70">
                            <input type="checkbox" name="creation_info[admin_managed]" class="checkbox-custom" id="admin_managed"<?php echo $admin_managed ? ' checked' : ''; ?> value="1">
                            <label class="checkbox-custom-label" for="admin_managed">
                                <span class="kinfo">If checked, VPS can not be managed from Enduser Panel.</span>
                            </label>
                        </div>
                    </div>

                    <div class="clear"></div>
                </div>
                <!-- accordion item end -->

            </div>
        </div>



    </div>
</div>
