<?php
    $LANG                   = $module->lang;
    $established            = false;
    $options                = $order["options"];
    $creation_info          = isset($options["creation_info"]) ? $options["creation_info"] : [];
    $config                 = isset($options["config"]) ? $options["config"] : [];
    $domain                 = isset($options["domain"]) ? $options["domain"] : "...";
    $product_id             = isset($creation_info["product-id"]) ? $creation_info["product-id"] : false;
    $csr_code               = isset($options["csr-code"]) ? $options["csr-code"] : '';
    $dcv_method             = isset($options["dcv-method"]) ? $options["dcv-method"] : false;
    $verification_email     = isset($options["verification-email"]) ? $options["verification-email"] : false;
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
    $email_types            = ['webmaster','hostmaster','admin','administrator','postmaster'];

    if($established){
        $ord_details             = $module->get_details();
        $ord_details_error       = $module->error;
        $cert_details            = $module->get_cert_details();
        $cert_details_error      = $module->error;
    }

?>
<script type="text/javascript">
    $(document).ready(function(){
        $(".accordion").accordion({
            heightStyle: "content",
            active:0,
        });

        var csr_code        = '<?php echo str_replace(EOL,'\n',$csr_code); ?>';
        var dcv_method      = '<?php echo $dcv_method; ?>';
        var vrf_email       = '<?php echo $verification_email; ?>';
        var vrf_email_ntf   = false;
        var reissue         = false;
        var content_changes = $(".content-changes input, .content-changes select").serialize();

        $("#ChangeForm").change(function(){
            var changes                 = false;
            var ntf_check               = $("input[name=verification-email-notification]").prop("checked");
            var reissue_check           = $("input[name=reissue]").prop("checked");
            var content_changes_check   = $(".content-changes input, .content-changes select").serialize();


            if($("select[name=dcv-method]").val() !== dcv_method) changes = true;
            if($("textarea[name=csr-code]").val() !== csr_code) changes = true;
            if($("select[name=verification-email]").val() !== vrf_email) changes = true;
            if(ntf_check) changes = true;
            if(reissue_check) changes = true;
            if(content_changes_check !== content_changes) changes = true;

            if(changes)
                $("#apply_changes_btn").removeClass("graybtn").addClass("yesilbtn");
            else
                $("#apply_changes_btn").removeClass("yesilbtn").addClass("graybtn");

        });

        $("#apply_changes_btn").click(function(){
            if($(this).hasClass("yesilbtn")){
                var request = MioAjax({
                    waiting_text: '<?php echo __("website/others/button1-pending"); ?>',
                    method:$("#ChangeForm").attr("method"),
                    action:$("#ChangeForm").attr("action"),
                    data:$("#ChangeForm").serialize(),
                    button_element:$(this),
                },true,true);

                request.done(function(result){
                    if(result != ''){
                        var solve = getJson(result);
                        if(solve !== false){
                            if(solve.status == "error"){
                                if(solve.for != undefined && solve.for != ''){
                                    $("#ChangeForm "+solve.for).focus();
                                    $("#ChangeForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                    $("#ChangeForm "+solve.for).change(function(){
                                        $(this).removeAttr("style");
                                    });
                                }
                                if(solve.message != undefined && solve.message != '')
                                    alert_error(solve.message,{timer:5000});
                            }else if(solve.status == "successful"){
                                alert_success(solve.message,{timer:2000});
                                if(solve.redirect != undefined && solve.redirect !== ''){
                                    setTimeout(function(){
                                        window.location.href = solve.redirect;
                                    },2000);
                                }
                            }
                        }else
                            console.log(result);
                    }
                });
            }
        });

    });
</script>
<form action="<?php echo $controller_link; ?>?action=use_method&method=apply_changes" method="post" id="ChangeForm">
    <div class="accordion" style="text-align: left;">
        <h1><?php echo $LANG["information"]; ?></h1>
        <div>

            <?php
                if($established){
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
                                            $("#csr-code-wrap").css("display","block");
                                            $("textarea[name=csr-code]").attr("disabled",false).val('').focus();
                                            $("input[name=verification-email]").removeAttr("disabled");
                                            $("#verification-email-notification-wrap").css("display","block");
                                            $("select[name=verification-email]").attr("disabled",false);
                                        }else{
                                            $("#csr-code-wrap").css("display","none");
                                            $("textarea[name=csr-code]").attr("disabled",true).val(old_csr_code);
                                            $("input[name=verification-email]").attr("disabled",true);
                                            $("#verification-email-notification-wrap").css("display","none");
                                            $("select[name=verification-email]").attr("disabled",true);

                                        }
                                    }
                                </script>
                            </div>
                        </div>
                        <?php
                    }
                }
            ?>
            <div class="formcon" id="csr-code-wrap" style="display: none;">
                <div class="yuzde30"><?php echo $LANG["csr-code"]; ?></div>
                <div class="yuzde70">
            <textarea<?php echo $established ? ' disabled' : ''; ?> rows="4" name="csr-code" placeholder="-----BEGIN CERTIFICATE REQUEST-----


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
                </div>
                <div class="yuzde70">

                    <select name="verification-email"<?php echo $established && $cert_details ? ' disabled' : ''; ?>>
                        <?php
                            if(!$verification_email){
                                ?>
                                <option value="" selected><?php echo ___("needs/unknown"); ?></option>
                                <?php
                            }

                            foreach($email_types AS $k=>$name){
                                $selected = $verification_email == $name;
                                ?>
                                <option<?php echo $selected ? ' selected' : ''; ?> value="<?php echo $name; ?>"><?php echo $name; ?>@<?php echo $domain; ?></option>
                                <?php
                            }
                        ?>
                    </select>

                    <?php
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
                <div class="content-changes">
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
                <div class="content-changes">

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

    <div class="clear"></div>
    <div style="float: right;margin-top: 15px;" class="yuzde30">
        <a class="gonderbtn graybtn" href="javascript:void 0;" id="apply_changes_btn"><?php echo $LANG["apply-changes-button"]; ?></a>
    </div>

</form>