<?php
    $LANG                   = $module->lang;
    $established            = false;
    $options                = $order["options"];
    $creation_info          = isset($options["creation_info"]) ? $options["creation_info"] : [];
    $config                 = isset($options["config"]) ? $options["config"] : [];
    $domain                 = isset($options["domain"]) ? $options["domain"] : "...";
    $product_id                = isset($creation_info["product-id"]) ? $creation_info["product-id"] : false;
    $csr_code               = isset($options["csr-code"]) ? $options["csr-code"] : '';
    $verification_email     = isset($options["verification-email"]) ? $options["verification-email"] : false;
    if(isset($config["order_id"]) && $config["order_id"]) $established = true;
    if(isset($options["checking-ssl-enroll"])) $module->checking_enroll();
?>

<div class="block_module_details-title formcon"><h4><?php echo $LANG["other-info"]; ?></h4></div>
<div class="hizmetblok" id="block_module_details_con">
    <script type="text/javascript">
        $(document).ready(function(){
            var csr_code        = '<?php echo str_replace(EOL,'\n',$csr_code); ?>';
            var vrf_email       = '<?php echo $verification_email; ?>';
            var vrf_email_ntf   = false;
            var reissue         = false;

            $("#ChangeForm").change(function(){
                var changes          = false;
                var ntf_check        = $("input[name=verification-email-notification]").prop("checked");
                var reissue_check    = $("input[name=reissue]").prop("checked");


                if($("textarea[name=csr-code]").val() !== csr_code) changes = true;
                if($("select[name=verification-email]").val() !== vrf_email) changes = true;
                if(ntf_check) changes = true;
                if(reissue_check) changes = true;

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
        <?php
            if($established){
                $cert_details            = $module->get_cert_details();
                $cert_details_error      = $module->error;


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

                        $names = ['webmaster','hostmaster','admin','administrator','postmaster'];

                        foreach($names AS $k=>$name){
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
        <div class="clear"></div>
        <a class="gonderbtn graybtn" href="javascript:void 0;" id="apply_changes_btn"><?php echo $LANG["apply-changes-button"]; ?></a>
    </form>
</div>