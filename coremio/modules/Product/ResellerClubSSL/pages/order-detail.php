<?php
    $LANG                   = $module->lang;
    $established            = false;
    $options                = $order["options"];
    $creation_info          = isset($options["creation_info"]) ? $options["creation_info"] : [];
    $config                 = isset($options["config"]) ? $options["config"] : [];
    $domain                 = isset($options["domain"]) ? $options["domain"] : "...";
    $plan_id                = isset($creation_info["plan-id"]) ? $creation_info["plan-id"] : false;
    $csr_code               = isset($options["csr-code"]) ? $options["csr-code"] : '';
    $verification_email     = isset($options["verification-email"]) ? $options["verification-email"] : false;
    $get_plans              = $module->get_plans();
    $get_plans_error        = $module->error;
    if(isset($config["order_id"]) && $config["order_id"]) $established = true;
    if(isset($options["checking-ssl-enroll"])) $module->checking_enroll();
?>
<div class="formcon">
    <div class="yuzde30"><?php echo $LANG["certificate-type"]; ?></div>
    <div class="yuzde70">
        <?php
            if($get_plans_error && !$get_plans){
                ?>
                <input type="hidden" name="creation_info[plan-id]" value="<?php echo $plan_id; ?>">
                <div class="red-info">
                    <div class="padding10">
                        <strong>ERROR::</strong> <?php echo $module->error; ?>
                    </div>
                </div>
                <?php
            }else{
                if($established){
                    ?>
                    <input type="hidden" name="creation_info[plan-id]" value="<?php echo $plan_id; ?>">
                    <?php
                }
                ?>
                <select name="creation_info[plan-id]"<?php echo $established ? ' disabled' : ''; ?>>
                    <option value="0"><?php echo ___("needs/select-your"); ?></option>
                    <?php
                        foreach($get_plans AS $k=>$v){
                            ?>
                            <option<?php echo $k == $plan_id ? ' selected' : ''; ?> value="<?php echo $k; ?>"><?php echo $v; ?></option>
                            <?php
                        }
                    ?>
                </select>
                <?php
            }
        ?>
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
?>

<?php
    if($established){
        $ord_details             = $module->get_details();
        $ord_details_error       = $module->error;
        $cert_details            = $module->get_cert_details();
        $cert_details_error      = $module->error;
        ?>
        <div class="formcon">
            <div class="yuzde30"><?php echo $LANG["api-order-status"]; ?></div>
            <div class="yuzde70">
                <?php
                    if($ord_details_error && !$ord_details){
                        ?>
                        <div class="red-info">
                            <div class="padding15">
                                <?php echo $ord_details_error; ?>
                            </div>
                        </div>
                        <?php
                    }else{
                        if($cert_details){
                            ?>
                            <div class="listingstatus"><span class="active"><?php echo $LANG["completed"]; ?></span></div>
                            <?php
                        }else{
                            ?>
                            <div class="listingstatus"><span class="process"><?php echo $LANG["verification-email-awaiting"]; ?></span></div>
                            <?php
                        }
                    }
                ?>
            </div>
        </div>
        <?php

        if($cert_details){
            ?>
            <div class="formcon">
                <div class="yuzde30"><?php echo $LANG["actions"]; ?></div>
                <div class="yuzde70">
                    <input onchange="change_reissue(this);" type="checkbox" class="checkbox-custom" id="reissue-checkbox" value="1" name="reissue">
                    <label class="checkbox-custom-label" for="reissue-checkbox"><?php echo $LANG["reissue-button"]; ?></label>

                    <script type="text/javascript">
                        var old_csr_code = '';
                        function change_reissue(el){
                            if(old_csr_code === '') old_csr_code = $("textarea[name=csr-code]").val();

                            if($(el).prop("checked")){
                                $("textarea[name=csr-code]").attr("disabled",false).val('').focus();
                                $("input[name=verification-email]").removeAttr("disabled");
                                $("#verification-email-notification-wrap").css("display","block");
                                $("input[name=verification-email]").not(":checked").next("label").css("display","block");
                            }else{
                                $("textarea[name=csr-code]").attr("disabled",true).val(old_csr_code);
                                $("input[name=verification-email]").attr("disabled",true);
                                $("#verification-email-notification-wrap").css("display","none");
                                $("input[name=verification-email]").not(":checked").next("label").css("display","none");

                            }
                        }
                    </script>
                </div>
            </div>
            <?php
        }

    }
?>


<div class="formcon">
    <div class="yuzde30">
        <?php echo $LANG["csr-code"]; ?>
        <div class="clear"></div>
        <span class="kinfo"><?php echo $LANG["csr-code-desc"]; ?></span>
    </div>
    <div class="yuzde70">
        <textarea<?php echo $established ? ' disabled' : ''; ?> name="csr-code" rows="5" placeholder="-----BEGIN CERTIFICATE REQUEST-----



-----END CERTIFICATE REQUEST-----"><?php echo $csr_code; ?></textarea>
    </div>
</div>

<div class="formcon">
    <div class="yuzde30">
        <?php echo $LANG["verification-email"]; ?>
        <div class="clear"></div>
        <span class="kinfo"><?php echo $LANG["verification-email-desc"]; ?></span>
    </div>
    <div class="yuzde70">

        <?php

            $names = ['webmaster','hostmaster','admin','administrator','postmaster'];

            foreach($names AS $k=>$name){
                $selected = $verification_email == $name;
                ?>
                <input<?php echo $established && $cert_details ? ' disabled' : ''; ?><?php echo $selected ? ' checked' : ''; ?> type="radio" class="radio-custom" id="verification-email-<?php echo $k; ?>" name="verification-email" value="<?php echo $name; ?>">
                <label class="radio-custom-label" for="verification-email-<?php echo $k; ?>" style="margin-bottom: 5px;<?php echo $established && $cert_details && !$selected ? 'display:none;' : ''; ?>"><?php echo $name; ?>@<?php echo $domain; ?></label>
                <div class="clear"></div>
                <?php
            }

            if($established && !$cert_details){
                ?>
                <div id="verification-email-notification-wrap" style="margin-top:20px;">
                    <input type="checkbox" id="verification-email-notification" class="checkbox-custom" value="1" name="verification-email-notification">
                    <label for="verification-email-notification" class="checkbox-custom-label"><?php echo $LANG["verification-email-notification"]; ?></label>
                </div>
                <?php
            }
        ?>
    </div>
</div>