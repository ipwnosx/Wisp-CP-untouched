<?php
    $LANG                   = $module->lang;
    $established            = false;
    $options                = $order["options"];
    $creation_info          = isset($options["creation_info"]) ? $options["creation_info"] : [];
    $config                 = isset($options["config"]) ? $options["config"] : [];
    $ip                     = isset($options["ip"]) ? $options["ip"] : "127.0.0.0";
    $product                = isset($creation_info["product"]) ? $creation_info["product"] : false;
    $Litespeed_cpu          = isset($creation_info["Litespeed_cpu"]) ? $creation_info["Litespeed_cpu"] : false;
    $get_products           = $module->get_products();
    $get_products_error     = $module->error;
    if(isset($config["package"]) && $config["package"]) $established = true;
    $details                = $module->get_details();


?>
    <div class="formcon">
        <div class="yuzde30"><?php echo $LANG["product"]; ?></div>
        <div class="yuzde70">
            <?php
                if($module->error && !$get_products){
                    ?>
                <input type="hidden" name="creation_info[product]" value="<?php echo $product; ?>">
                    <div class="red-info">
                        <div class="padding10">
                            <strong>ERROR::</strong> <?php echo $module->error; ?>
                        </div>
                    </div>
                <?php
                    }else{
                ?>
                    <script type="text/javascript">
                        function change_product(){
                            var s_product = $("select[name='creation_info[product]']").val();
                            var litespeed = false;

                            if(s_product === "Litespeed") litespeed = true;
                            else if(s_product === "Litespeedultra") litespeed = true;
                            else if(s_product === "Litespeedvps") litespeed = true;

                            if(litespeed)
                                $("#litespeed_wrap").css("display","block");
                            else
                                $("#litespeed_wrap").css("display","none");

                        }
                        $(document).ready(function(){
                            change_product();
                        });
                    </script>
                    <select<?php echo $established ? ' disabled' : ''; ?> name="creation_info[product]" onchange="change_product();">
                        <option value=""><?php echo ___("needs/select-your"); ?></option>
                        <?php
                            foreach($get_products AS $k=>$v){
                                if(is_array($v)){
                                    ?>
                                    <optgroup label="<?php echo $LANG["product-addons"]; ?>">
                                        <?php
                                            foreach($v AS $kk=>$vv){
                                                ?>
                                                <option<?php echo $product == $kk ? ' selected' : ''; ?> value="<?php echo $kk; ?>"><?php echo $vv; ?></option>
                                                <?php
                                            }
                                        ?>
                                    </optgroup>
                                    <?php
                                }else{
                                    ?>
                                    <option<?php echo strlen($product) && $k == $product ? ' selected' : ''; ?> value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                    <?php
                                }
                                ?>
                                <?php
                            }
                        ?>
                    </select>
                    <?php
                }
            ?>
        </div>
    </div>

    <div class="formcon" id="litespeed_wrap" style="display: none;">
        <div class="yuzde30">LiteSpeed CPU</div>
        <div class="yuzde70">
            <input<?php echo $established ? ' disabled' : ''; ?> type="number" name="creation_info[Litespeed_cpu]" value="<?php echo $Litespeed_cpu ? $Litespeed_cpu : ''; ?>">
        </div>
    </div>
<?php


    if(!$established){
        ?>
        <div class="formcon">
            <div class="yuzde30"><?php echo $LANG["actions"]; ?></div>
            <div class="yuzde70">
                <input type="checkbox" class="checkbox-custom" id="setup-checkbox" value="1" name="setup">
                <label class="checkbox-custom-label" for="setup-checkbox"><?php echo $LANG["setup-button"]; ?></label>
            </div>
        </div>
        <?php
    }

    if($established && !$details && $module->error){

        ?>
        <div class="clear"></div>
        <div class="red-info">
            <div class="padding15">
                <i class="fa fa-exclamation-triangle"></i>
                <?php echo $module->error; ?>
            </div>
        </div>
        <?php

    }else{

        ?>
        <div class="formcon">
            <div class="yuzde30"><?php echo $LANG["status"]; ?></div>
            <div class="yuzde70">
                <div class="listingstatus"><span><?php echo $details["status"]; ?></span></div>
            </div>
        </div>

        <div class="formcon">
            <div class="yuzde30"><?php echo $LANG["expire-date"]; ?></div>
            <div class="yuzde70">
                <?php echo $details["next_renewal"]; ?>
            </div>
        </div>

        <div class="formcon">
            <div class="yuzde30"><?php echo $LANG["license-key"]; ?></div>
            <div class="yuzde70">
                <span class="selectalltext">
                    <?php
                        if(isset($details["license_key"]) && $details["license_key"])
                            echo $details["license_key"];
                        else
                            echo $LANG["undefined"];
                    ?>
                </span>
            </div>
        </div>

        <div class="formcon">
            <div class="yuzde30"><?php echo $LANG["current-ip-address"]; ?></div>
            <div class="yuzde70">
                <strong><?php echo $details["ip"]; ?></strong>
            </div>
        </div>

        <div class="formcon">
            <div class="yuzde30"><?php echo $LANG["change-ip-address"]; ?></div>
            <div class="yuzde70">
                <input type="text" name="change-ip" value="" style="width: 150px;" onkeypress='return event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57'>
                <span class="kinfo"><?php echo $LANG["change-ip-address-info"]; ?></span>
            </div>
        </div>
        <?php
    }