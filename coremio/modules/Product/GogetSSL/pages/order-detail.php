<?php
    $controller_link        = Controllers::$init->AdminCRLink("orders-2",["detail",$order["id"]]);
    $LANG                   = $module->lang;
    $established            = false;
    $options                = $order["options"];
    $creation_info          = isset($options["creation_info"]) ? $options["creation_info"] : [];
    $config                 = isset($options["config"]) ? $options["config"] : [];
    $domain                 = isset($options["domain"]) ? $options["domain"] : "";
    $product_id             = isset($creation_info["product-id"]) ? $creation_info["product-id"] : false;
    $csr_code               = isset($options["csr-code"]) ? $options["csr-code"] : '';
    $verification_email     = isset($options["verification-email"]) ? $options["verification-email"] : false;
    $dcv_method             = isset($options["dcv-method"]) ? $options["dcv-method"] : false;
    $get_products           = $module->get_products();
    $get_products_error     = $module->error;
    if(isset($config["order_id"]) && $config["order_id"]) $established = true;
    if(isset($options["checking-ssl-enroll"])) $module->checking_enroll();
    $additional_domains     = $module->get_additional_domains();
    $additional_sans_count  = $module->get_additional_sans_count();
    $included_sans_count    = isset($creation_info["included_sans"]) ? $creation_info["included_sans"] : 0;
    $total_sans             = $included_sans_count + $additional_sans_count;
    $dcv_methods            = [
        'email' => "EMAIL",
        'http'  => "HTTP",
        'https' => "HTTPS",
        'dns'   => "DNS",
    ];

    if(isset($creation_info["disable_dcv_m"]) && $creation_info["disable_dcv_m"])
        foreach($creation_info["disable_dcv_m"] AS $m) unset($dcv_methods[strtolower($m)]);

    $email_types            = ['webmaster','hostmaster','admin','administrator','postmaster'];
?>
<script type="text/javascript">
    $(document).ready(function(){
        $(".accordion").accordion({
            heightStyle: "content",
            active:0,
        });
    });
</script>

<div class="clear"></div>
<div class="accordion">
    <h1><?php echo $LANG["information"]; ?></h1>
    <!-- information -->
    <div>
        <div class="formcon">
            <div class="yuzde30"><?php echo $LANG["product"]; ?></div>
            <div class="yuzde70">
                <?php
                    if($get_products_error && !$get_products){
                        ?>
                        <input type="hidden" name="creation_info[product-id]" value="<?php echo $product_id; ?>">
                        <div class="red-info">
                            <div class="padding10">
                                <strong>ERROR::</strong> <?php echo $module->error; ?>
                            </div>
                        </div>
                        <?php
                    }else{
                        if($established){
                            ?>
                            <input type="hidden" name="creation_info[product-id]" value="<?php echo $product_id; ?>">
                            <?php
                        }
                        ?>
                        <select name="creation_info[product-id]"<?php echo $established ? ' disabled' : ''; ?>>
                            <option value="0"><?php echo ___("needs/select-your"); ?></option>
                            <?php
                                foreach($get_products AS $k=>$v){
                                    ?>
                                    <option<?php echo $k == $product_id ? ' selected' : ''; ?> value="<?php echo $k; ?>"><?php echo $v; ?></option>
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
                                if(isset($ord_details["status"]) && in_array($ord_details["status"],['cancelled','expired','incomplete','unpaid','pending','rejected'])){
                                    ?>
                                    <div class="listingstatus"><span class="error"><?php echo $ord_details["status"].(isset($ord_details["status_description"]) && $ord_details["status_description"] ? " - ".$ord_details["status_description"] : ''); ?></span></div>
                                    <?php
                                }
                                elseif($cert_details){
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
                <?php echo $LANG["dcv-method"]; ?>
                <div class="clear"></div>
                <span class="kinfo"><?php echo $LANG["dcv-method-desc"]; ?></span>
            </div>
            <div class="yuzde70">
                <select<?php echo $established && $cert_details ? ' disabled' : ''; ?> name="dcv-method" onchange="if($(this).val() === 'email') $('#verification-email-wrap').slideDown(); else $('#verification-email-wrap').slideUp();">
                    <?php
                        foreach($dcv_methods AS $k=>$name){
                            ?>
                            <option<?php echo $k == $dcv_method || !$dcv_method ? ' selected' : ''; ?> value="<?php echo $k; ?>"><?php echo $name; ?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>
        </div>

        <div class="formcon" id="verification-email-wrap"<?php echo !$dcv_method || $dcv_method == "email" ? '' : ' style="display:none;"'; ?>>
            <div class="yuzde30">
                <?php echo $LANG["verification-email"]; ?>
                <div class="clear"></div>
                <span class="kinfo"><?php echo $LANG["verification-email-desc"]; ?></span>
            </div>
            <div class="yuzde70">

                <?php
                    foreach($email_types AS $k=>$name){
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

    </div>

    <?php
        if($additional_domains || $total_sans){
            ?>
            <h1><?php echo $LANG["additional-domains"]; ?> <span class="kinfo">(<?php echo $LANG["additional-domains-desc"]; ?>)</span></h1>
            <div>
                <div class="blue-info" style="margin-bottom: 30px;">
                    <div class="padding20">
                        <p><?php echo $LANG["additional-domains-note"]; ?></p>
                    </div>
                </div>
                <div class="clear"></div>
                <div style="width: 150px; display: inline-block;">
                    <?php echo $LANG["included-sans"]; ?>:
                    <strong><?php echo $included_sans_count; ?></strong>
                </div>
                <div style="width: 150px; display: inline-block;">
                    <?php echo $LANG["additional-sans"]; ?>:
                    <strong><?php echo $additional_sans_count; ?></strong>
                </div>

                <div class="clear"></div>
                <br>
                <div class="formcon">
                    <div class="yuzde50"><?php echo $LANG["domain"]; ?></div>
                    <div class="yuzde50"><?php echo $LANG["dcv-method"]; ?></div>
                </div>

                <?php
                    $default_ad = [
                        'domain' => '',
                        'dcv-method' => 'email',
                        'verification-email' => 'admin',
                    ];
                    for($i=0;$i<=$total_sans-1;$i++){
                        $ad             = isset($additional_domains[$i]) ? $additional_domains[$i] : $default_ad;
                        $ad_domain      = $ad["domain"];
                        $ad_dcv_method  = $ad["dcv-method"];
                        $ad_vfeml       = $ad["verification-email"];
                        ?>
                        <div class="formcon">
                            <div class="yuzde50">
                                <input type="text" name="additional-domains[<?php echo $i; ?>][domain]" placeholder="example.com" value="<?php echo $ad_domain; ?>">
                            </div>
                            <div class="yuzde50">
                                <select name="additional-domains[<?php echo $i; ?>][dcv-method]" onchange="if($(this).val() === 'email') $(this).next('.select-verification-email').css('visibility','visible'); else $(this).next('.select-verification-email').css('visibility','hidden');" style="width: 30%;">
                                    <?php
                                        foreach($dcv_methods AS $k=>$name){
                                            ?>
                                            <option<?php echo $k == $ad_dcv_method || !$ad_dcv_method ? ' selected' : ''; ?> value="<?php echo $k; ?>"><?php echo $name; ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                                <select style="width: 60%;<?php echo $ad_dcv_method == "email" ? '' : 'visibility:hidden;'; ?>" name="additional-domains[<?php echo $i; ?>][verification-email]" class="select-verification-email">
                                    <?php
                                        foreach($email_types AS $k=>$name){
                                            $selected = $ad_vfeml == $name;
                                            ?>
                                            <option<?php echo $selected ? ' selected' : ''; ?> value="<?php echo $name; ?>"><?php echo $name; ?>@<?php echo '*****.***'; ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <?php
                    }
                ?>

                <div class="clear"></div>
            </div>
            <?php
        }

        if($established){
            ?>
            <h1><?php echo $LANG["validation"]; ?></h1>
            <div>

                <?php
                    $g_dcv_method = isset($ord_details["dcv_method"]) ? $ord_details["dcv_method"] : $dcv_method;
                    if(!in_array($g_dcv_method,array_keys($dcv_methods))) $g_dcv_method = $dcv_method;
                ?>
                <div class="formcon">
                    <div class="yuzde30"><?php echo $domain; ?></div>
                    <div class="yuzde70">

                        <div class="formcon">
                            <div class="yuzde30">Method</div>
                            <div class="yuzde70"><?php echo $dcv_methods[$g_dcv_method]; ?></div>
                        </div>

                        <?php
                            if($g_dcv_method == "email"){
                                ?>
                                <div class="formcon">
                                    <div class="yuzde30"><?php echo $LANG["verification-email"]; ?></div>
                                    <div class="yuzde70">
                                        <?php echo $ord_details["approver_email"]; ?>
                                    </div>
                                </div>
                                <?php
                            }
                            elseif($g_dcv_method == "http" || $g_dcv_method == "https" || $g_dcv_method == "dns"){
                                if(isset($ord_details["approver_method"][$g_dcv_method])){
                                    $dcv_data = $ord_details["approver_method"][$g_dcv_method];
                                    if($g_dcv_method == "dns"){
                                        ?>
                                        <div class="formcon">
                                            <div class="yuzde30">DNS CNAME Record</div>
                                            <div class="yuzde70 selectalltext"><?php echo $dcv_data["record"]; ?></div>
                                        </div>

                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo $LANG["verify-again-button"]; ?></div>
                                            <div class="yuzde70">
                                                <input type="checkbox" class="checkbox-custom" name="revalidate[]" id="revalidate_c_select" value="<?php echo $domain; ?>">
                                                <label class="checkbox-custom-label" for="revalidate_c_select"></label>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    else{
                                        ?>
                                        <div class="formcon">
                                            <div class="yuzde30">Hash File</div>
                                            <div class="yuzde70 selectalltext"><?php echo $dcv_data["link"]; ?></div>
                                        </div>

                                        <div class="formcon">
                                            <div class="yuzde30">File Name</div>
                                            <div class="yuzde70 selectalltext"><?php echo $dcv_data["filename"]; ?></div>
                                        </div>

                                        <div class="formcon">
                                            <div class="yuzde30">Content</div>
                                            <div class="yuzde70 selectalltext"><?php echo $dcv_data["content"]; ?></div>
                                        </div>

                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo $LANG["verify-again-button"]; ?></div>
                                            <div class="yuzde70">
                                                <input type="checkbox" class="checkbox-custom" name="revalidate[]" id="revalidate_c_select" value="<?php echo $domain; ?>">
                                                <label class="checkbox-custom-label" for="revalidate_c_select"></label>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                            }
                        ?>
                    </div>
                </div>

                <?php
                    if(isset($ord_details["san"]) && $ord_details["san"]){
                        foreach($ord_details["san"] AS $i=>$row){
                            $g_dcv_method = isset($row["validation_method"]) ? $row["validation_method"] : $dcv_method;
                            if(stristr($g_dcv_method,'@')) $g_dcv_method = "email";
                            if(!in_array($g_dcv_method,array_keys($dcv_methods))) $g_dcv_method = $dcv_method;
                            ?>
                            <div class="formcon">
                                <div class="yuzde30"><?php echo $row["san_name"]; ?></div>
                                <div class="yuzde70">

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo $LANG["api-order-status"]; ?></div>
                                        <div class="yuzde70"><?php echo $row["status_description"]; ?></div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30">Method</div>
                                        <div class="yuzde70"><?php echo $dcv_methods[$g_dcv_method]; ?></div>
                                    </div>

                                    <?php
                                        if($g_dcv_method == "email"){
                                            ?>
                                            <div class="formcon">
                                                <div class="yuzde30"><?php echo $LANG["verification-email"]; ?></div>
                                                <div class="yuzde70">
                                                    <?php echo $row["validation"]["email"]; ?>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        elseif($g_dcv_method == "http" || $g_dcv_method == "https" || $g_dcv_method == "dns"){
                                            if(isset($row["validation"][$g_dcv_method])){
                                                $dcv_data = $row["validation"][$g_dcv_method];
                                                if($g_dcv_method == "dns"){
                                                    ?>
                                                    <div class="formcon">
                                                        <div class="yuzde30">DNS CNAME Record</div>
                                                        <div class="yuzde70 selectalltext"><?php echo $dcv_data["record"]; ?></div>
                                                    </div>

                                                    <div class="formcon">
                                                        <div class="yuzde30"><?php echo $LANG["verify-again-button"]; ?></div>
                                                        <div class="yuzde70">
                                                            <input type="checkbox" class="checkbox-custom" name="revalidate[]" id="revalidate_<?php echo $i; ?>_select" value="<?php echo $row["san_name"]; ?>">
                                                            <label class="checkbox-custom-label" for="revalidate_<?php echo $i; ?>_select"></label>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                else{
                                                    ?>
                                                    <div class="formcon">
                                                        <div class="yuzde30">Hash File</div>
                                                        <div class="yuzde70 selectalltext"><?php echo $dcv_data["link"]; ?></div>
                                                    </div>

                                                    <div class="formcon">
                                                        <div class="yuzde30">File Name</div>
                                                        <div class="yuzde70 selectalltext"><?php echo $dcv_data["filename"]; ?></div>
                                                    </div>

                                                    <div class="formcon">
                                                        <div class="yuzde30">Content</div>
                                                        <div class="yuzde70 selectalltext"><?php echo $dcv_data["content"]; ?></div>
                                                    </div>

                                                    <div class="formcon">
                                                        <div class="yuzde30"><?php echo $LANG["verify-again-button"]; ?></div>
                                                        <div class="yuzde70">
                                                            <input type="checkbox" class="checkbox-custom" name="revalidate[]" id="revalidate_<?php echo $i; ?>_select" value="<?php echo $row["san_name"]; ?>">
                                                            <label class="checkbox-custom-label" for="revalidate_<?php echo $i; ?>_select"></label>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                            <?php
                        }
                    }
                ?>

            </div>
            <?php
        }
    ?>
</div>