<?php
    $LANG           = $module->lang;
    $product        = isset($product) && $product ? $product : [];
    $module_data    = isset($product["module_data"]) ? Utility::jdecode($product["module_data"],true) : [];

    if($module_data){
        $server         = isset($module_data["server"]) ? $module_data["server"] : false;
        $os             = isset($module_data["os"]) ? $module_data["os"] : false;
        $plan           = isset($module_data["plan"]) ? $module_data["plan"] : false;
        $datastore      = isset($module_data["datastore"]) ? $module_data["datastore"] : false;
        $hard           = isset($module_data["hard"]) ? $module_data["hard"] : false;
        $bandwidth      = isset($module_data["bandwidth"]) ? $module_data["bandwidth"] : false;
        $ram            = isset($module_data["ram"]) ? $module_data["ram"] : false;
        $cpu            = isset($module_data["cpu"]) ? $module_data["cpu"] : false;
        $core           = isset($module_data["core"]) ? $module_data["core"] : false;
    }else{
        $server         = "";
        $os             = "";
        $plan           = "";
        $datastore      = "";
        $hard           = "1";
        $bandwidth      = "";
        $ram            = "1024";
        $cpu            = "";
        $core           = "1";
    }

?>

<div class="formcon">
    <div class="yuzde30"><?php echo $LANG["server"]; ?></div>
    <div class="yuzde70">
        <input type="text" name="module_data[server]" value="<?php echo $server; ?>" style="width: 100px;" onkeypress='return event.charCode>= 48 &&event.charCode<= 57'>
    </div>
</div>

<div class="formcon">
    <div class="yuzde30"><?php echo $LANG["os"]; ?></div>
    <div class="yuzde70">
        <select name="module_data[os]">
            <option value=""><?php echo ___("needs/none"); ?></option>
            <?php
                if($os_list = $module->os_list()){
                    foreach($os_list->data AS $os_id=>$os_name){
                        ?>
                        <option<?php echo $os_id == $os ? ' selected' : ''; ?> value="<?php echo $os_id; ?>"><?php echo $os_name; ?></option>
                        <?php
                    }
                }
            ?>
        </select>
    </div>
</div>

<div class="formcon">
    <div class="yuzde30"><?php echo $LANG["plan"]; ?></div>
    <div class="yuzde70">
        <input type="text" name="module_data[plan]" value="<?php echo $plan; ?>" style="width: 100px;" onkeypress='return event.charCode>= 48 &&event.charCode<= 57'>
    </div>
</div>

<div class="formcon">
    <div class="yuzde30">Datastore ID</div>
    <div class="yuzde70">
        <input type="text" name="module_data[datastore]" value="<?php echo $datastore; ?>" style="width: 100px;">
    </div>
</div>

<div class="formcon">
    <div class="yuzde30"><?php echo $LANG["disk-space"]; ?> (GB)</div>
    <div class="yuzde70">
        <input type="text" name="module_data[hard]" value="<?php echo $hard; ?>" style="width: 100px;" onkeypress='return event.charCode>= 48 &&event.charCode<= 57'>
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