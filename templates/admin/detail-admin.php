<!DOCTYPE html>
<html>
<head>
    <?php
        Utility::sksort($lang_list,"local");
        $local_l    = Config::get("general/local");
        $accountConf = Admin::isPrivilege("ADMIN_CONFIGURE");
        $plugins    = ['intlTelInput'];
        include __DIR__.DS."inc".DS."head.php";
    ?>
    <script type="text/javascript">
        $(document).ready(function(){

            var telInput = $("#gsm");
            telInput.intlTelInput({
                geoIpLookup: function(callback) {
                    callback('<?php if($ipInfo = UserManager::ip_info()) echo $ipInfo["countryCode"]; else echo 'us'; ?>');
                },
                autoPlaceholder: "on",
                formatOnDisplay: true,
                initialCountry: "auto",
                hiddenInput: "gsm",
                nationalMode: false,
                placeholderNumberType: "MOBILE",
                preferredCountries: ['us', 'gb', 'ch', 'ca', 'de', 'it'],
                separateDialCode: true,
                utilsScript: "<?php echo $sadress;?>assets/plugins/phone-cc/js/utils.js"
            });


            $("#submit1").on("click",function(){
                MioAjaxElement($(this),{
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                    result:"submit1_handler",
                });
            });

            $(".change-lang-buttons a").click(function(){
                var _wrap   = $(this).parent();
                var _type   = $(_wrap).data("type");
                var k       = $(this).data("key");

                if($(this).attr("id") === "lang-active") return false;
                window[_type+"_selected_lang"] = k;
                $("."+_type+"-names").css("display","none");
                $("."+_type+"-name-"+k).css("display","block");

                $("."+_type+"-values").css("display","none");
                $("."+_type+"-value-"+k).css("display","block");

                $("a",_wrap).removeAttr("id");
                $(this).attr("id","lang-active");
            });

        });

        function submit1_handler(result){
            if(result != ''){
                var solve = getJson(result);
                if(solve !== false){
                    if(solve.status == "error"){
                        if(solve.for != undefined && solve.for != ''){
                            $("#editForm "+solve.for).focus();
                            $("#editForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                            $("#editForm "+solve.for).change(function(){
                                $(this).removeAttr("style");
                            });
                        }
                        if(solve.message != undefined && solve.message != '')
                            alert_error(solve.message,{timer:5000});
                    }else if(solve.status == "successful"){
                        alert_success(solve.message,{timer:2000});
                        setTimeout(function(){
                            window.location.href = solve.redirect;
                        },2000);
                    }
                }else
                    console.log(result);
            }
        }

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#avatar_image')
                        .attr('src', e.target.result)
                        .width(130)
                        .height(128);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

    </script>
</head>
<body>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1><strong><?php echo $admin["full_name"]; ?></strong> (<?php echo __("admin/admins/detail-page-name"); ?>)</h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="adminuyedetay">
                <form action="<?php echo $links["controller"]; ?>" method="post" id="editForm" enctype="multipart/form-data">
                    <?php echo Validation::get_csrf_token('admin-staff'); ?>

                    <input type="hidden" name="operation" value="edit">


                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/admins/form-field-avatar"); ?></div>
                        <div class="yuzde70">
                            <input type="file" name="avatar" id="avatar" style="display:none;" onchange="readURL(this)" />
                            <div class="uyeavatar">
                                <a class="avatarguncelle" href="javascript:void(0);" onclick="$('#avatar').click();" ><i class="fa fa-camera" aria-hidden="true"></i></a>
                                <img  src="<?php echo $admin["avatar_image"] == NULL ? Utility::image_link_determiner("default.jpg",Config::get("pictures/admin-profile-image/folder")) : Utility::image_link_determiner($admin["avatar_image"],Config::get("pictures/admin-profile-image/folder")); ?>" id="avatar_image" />
                            </div>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/admins/form-field-privilege"); ?></div>
                        <div class="yuzde70">
                            <select name="privilege">
                                <option value=""><?php echo ___("needs/none"); ?></option>
                                <?php
                                    if(isset($privileges) && $privileges){
                                        foreach ($privileges AS $privilege){
                                            ?>
                                            <option <?php echo $privilege["id"] == $admin["privilege"] ? "selected " : NULL; ?>value="<?php echo $privilege["id"]; ?>"><?php echo $privilege["name"]; ?></option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/admins/form-field-full-name"); ?></div>
                        <div class="yuzde70">
                            <input name="full_name" type="text" value="<?php echo $admin["full_name"]; ?>">
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/admins/form-field-email"); ?></div>
                        <div class="yuzde70">
                            <input name="email" type="text" value="<?php echo $admin["email"]; ?>">
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/admins/form-field-gsm"); ?></div>
                        <div class="yuzde70">
                            <input  id="gsm" type="text" value="<?php echo $admin["gsm_cc"].$admin["gsm"]; ?>">
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/admins/form-field-password"); ?></div>
                        <div class="yuzde70">
                            <input name="password" type="password" value="">
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/admins/form-field-password2"); ?></div>
                        <div class="yuzde70">
                            <input name="password2" type="password" value="">
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/admins/form-field-departments"); ?></div>
                        <div class="yuzde70">
                            <?php
                                if(isset($departments) && $departments){
                                    foreach ($departments AS $row){
                                        $appointees = explode(",",$row["appointees"]);
                                        $isHave = false;
                                        if(in_array($admin["id"],$appointees)) $isHave = true;
                                        ?>
                                        <input id="department-<?php echo $row["id"]; ?>" type="checkbox" class="checkbox-custom" name="departments[]" value="<?php echo $row["id"]; ?>" <?php echo $isHave ? ' checked' : NULL; ?>>
                                        <label style="margin-left:15px;" for="department-<?php echo $row["id"]; ?>" class="checkbox-custom-label"><?php echo $row["name"]; ?></label>
                                        <?php
                                    }
                                }else
                                    echo __("admin/admins/no-departments");
                            ?>
                        </div>
                    </div>


                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/admins/form-field-signature"); ?></div>
                        <div class="yuzde70">
                            <div class="change-lang-buttons" data-type="signature">
                                <?php
                                    foreach($lang_list AS $row){
                                        ?>
                                        <a class="lbtn"<?php echo $local_l == $row["key"] ? ' id="lang-active"' : ''; ?> href="javascript:void 0;" data-key="<?php echo $row["key"]; ?>"><?php echo strtoupper($row["key"]); ?></a>
                                        <?php
                                    }
                                ?>
                            </div>

                            <?php
                                foreach($lang_list AS $row){
                                    $l_k = $row["key"];
                                    ?>
                                    <textarea style="<?php echo $l_k == $local_l ? '' : 'display:none;';?>" rows="5" name="signature[<?php echo $l_k; ?>]" class="signature-values signature-value-<?php echo $l_k; ?>"><?php echo isset($admin['signature'][$l_k]) ? $admin['signature'][$l_k] : ($row['local'] ? $admin["signature"] : ''); ?></textarea>
                                    <?php
                                }
                            ?>


                            <div class="formcon">
                                <div class="yuzde30">
                                    <?php echo __("admin/notifications/edit-user-variables"); ?>
                                    <div class="clear"></div>
                                    <span class="kinfo"><?php echo __("admin/notifications/edit-user-variables-info"); ?></span>
                                </div>
                                <div class="yuzde70" id="template-variables">
                                    <span>{FULL_NAME}</span>
                                    <span>{NAME}</span>
                                    <span>{SURNAME}</span>
                                    <span>{EMAIL}</span>
                                    <span>{PHONE}</span>
                                    <span>{SERVICE}</span>
                                    <span>{DOMAIN}</span>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/admins/form-field-language"); ?></div>
                        <div class="yuzde70">
                            <select name="lang">
                                <?php
                                    if(isset($lang_list) && is_array($lang_list)){
                                        foreach($lang_list AS $lang){
                                            ?><option <?php echo $admin["lang"] == $lang["key"] ? 'selected ' : NULL; ?>value="<?php echo $lang["key"]; ?>"><?php echo $lang["cname"]." (".$lang["name"].")"; ?></option><?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/admins/form-field-status"); ?></div>
                        <div class="yuzde70">
                            <select name="status">
                                <?php
                                    $situations = ['active','inactive','blocked'];
                                    foreach($situations AS $status){
                                        ?>
                                        <option value="<?php echo $status; ?>"<?php echo $admin["status"] == $status ? ' selected' : NULL; ?>><?php echo __("admin/admins/status-".$status); ?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </div>






                    <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                        <a class="yesilbtn gonderbtn" id="submit1" href="javascript:void(0);"><i class="fa fa-save"></i> <?php echo __("admin/admins/save-button"); ?></a>
                    </div>
                    <div class="clear"></div>


                </form>
            </div>


        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>