<!DOCTYPE html>
<html>
<head>
    <?php
        Utility::sksort($lang_list,"local");
        $local_l    = Config::get("general/local");
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
                            $("#EditForm "+solve.for).focus();
                            $("#EditForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                            $("#EditForm "+solve.for).change(function(){
                                $(this).removeAttr("style");
                            });
                            }
                            if(solve.message != undefined && solve.message != '')
                                alert_error(solve.message,{timer:5000});
                    }else if(solve.status == "successful"){
                        alert_success(solve.message,{timer:2000});
                    }
                    if(solve.redirect != undefined && solve.redirect != ''){
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
                <h1><strong><?php echo $udata["full_name"]; ?></strong> (<?php echo __("admin/ac-settings/account-detail"); ?>)</h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>


            <div class="adminuyedetay">

                <?php
                    if(isset($GLOBALS["basic_password"]) && $GLOBALS["basic_password"])
                    {
                        ?>
                        <div class="red-info">
                            <div class="padding20">
                                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                <p><?php echo __("admin/ac-settings/error14"); ?></p>
                            </div>
                        </div>
                        <?php
                    }
                ?>


                <form action="<?php echo $links["controller"]; ?>" method="post" enctype="multipart/form-data" id="EditForm">
                    <?php echo Validation::get_csrf_token('admin-account'); ?>

                    <input type="hidden" name="operation" value="edit_account">

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/ac-settings/profile-image"); ?></div>
                        <div class="yuzde70">
                            <input type="file" name="avatar" id="avatar" style="display:none;" onchange="readURL(this)" />
                            <div class="uyeavatar">
                                <a class="avatarguncelle" href="javascript:void(0);" onclick="$('#avatar').click();" ><i class="fa fa-camera" aria-hidden="true"></i></a>
                                <img  src="<?php echo $account_info["avatar_image"]; ?>" id="avatar_image" />
                            </div>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/ac-settings/privilege-name"); ?></div>
                        <div class="yuzde70">
                            <strong><?php echo $udata["privilege_name"]; ?></strong>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/ac-settings/full-name"); ?></div>
                        <div class="yuzde70">
                            <input name="full_name" type="text" value="<?php echo $udata["full_name"]; ?>">
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/ac-settings/email"); ?></div>
                        <div class="yuzde70">
                            <input name="email" type="text" value="<?php echo $udata["email"]; ?>">
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/ac-settings/gsm"); ?></div>
                        <div class="yuzde70">
                            <input  id="gsm" type="text" value="<?php echo $udata["gsm_cc"] ? "+" : ""; echo $udata["gsm_cc"].$udata["gsm"]; ?>">
                        </div>
                    </div>

                    <?php if(Admin::isPrivilege("TICKETS_LOOK")): ?>
                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/ac-settings/signature"); ?></div>
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
                                    <textarea style="<?php echo $l_k == $local_l ? '' : 'display:none;';?>" rows="5" name="signature[<?php echo $l_k; ?>]" class="signature-values signature-value-<?php echo $l_k; ?>"><?php echo isset($udata['signature'][$l_k]) ? $udata['signature'][$l_k] : ($row['local'] ? $udata["signature"] : ''); ?></textarea>
                                    <?php
                                }
                            ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/ac-settings/select-language"); ?></div>
                        <div class="yuzde70">
                            <select name="lang">
                                <?php
                                    if(isset($lang_list) && is_array($lang_list)){
                                        foreach($lang_list AS $lang){
                                            ?><option value="<?php echo $lang["key"]; ?>" <?php echo $udata["lang"] == $lang["key"] ? " selected" : ''; ?>><?php echo $lang["cname"]." (".$lang["name"].")"; ?></option><?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>


                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/ac-settings/creation-time"); ?></div>
                        <div class="yuzde70">
                            <?php echo DateManager::format(Config::get("options/date-format")." H:i",$udata["creation_time"]); ?>
                        </div>
                    </div>

                    <div class="green-info" style="margin-top:20px;">
                        <i class="fa fa-shield" aria-hidden="true"></i>
                        <div class="padding15" style="position: relative;z-index: 12;">
                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/ac-settings/new-password"); ?></div>
                        <div class="yuzde70">
                            <input name="password" type="password" value="" placeholder="<?php echo __("admin/ac-settings/currentpassinfo"); ?>">
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/ac-settings/new-password2"); ?></div>
                        <div class="yuzde70">
                            <input name="password2" type="password" value="" placeholder="<?php echo __("admin/ac-settings/currentpassinfo"); ?>">
                        </div>
                    </div>
                            <div class="clear"></div>
                        </div>
                    </div>

                    <div class="red-info">
                        <i class="fa fa-lock" aria-hidden="true"></i>
                        <div class="padding15" style="position: relative;z-index: 12;">
                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/ac-settings/current-password"); ?></div>
                                <div class="yuzde70">
                                    <input name="passwordc" type="password" value="" placeholder="<?php echo __("admin/ac-settings/currentpassrequired"); ?>">
                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>




                    <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                        <a class="yesilbtn gonderbtn" id="submit1" href="javascript:void(0);"><?php echo __("admin/ac-settings/submit-button"); ?></a>
                    </div>
                    <div class="clear"></div>


                </form>

                <div class="clear"></div>

            </div>



        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>