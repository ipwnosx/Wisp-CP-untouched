<!DOCTYPE html>
<html>
<head>
    <?php

        Utility::sksort($lang_list,"local");
        $plugins    = ['jquery-ui','tinymce-1','select2'];
        include __DIR__.DS."inc".DS."head.php";
    ?>

    <script type="text/javascript">
        $(document).ready(function(){

            $(".select2-element").select2();

            var tab2 = _GET("lang");
            if (tab2 != '' && tab2 != undefined) {
                $("#tab-lang .tablinks[data-tab='" + tab2 + "']").click();
            } else {
                $("#tab-lang .tablinks:eq(0)").addClass("active");
                $("#tab-lang .tabcontent:eq(0)").css("display", "block");
            }

            $("#editForm_submit").on("click",function(){
                MioAjaxElement($(this),{
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                    result:"editForm_handler",
                });
            });

            $(".accordions").accordion({
                heightStyle: "content",
                collapsible: true,
                active:0,
            });

        });

        function editForm_handler(result){
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
                        if(solve.redirect != undefined && solve.redirect != ''){
                            setTimeout(function(){
                                window.location.href = solve.redirect;
                            },2000);
                        }
                    }
                }else
                    console.log(result);
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
                <h1><strong><?php echo $page_title; ?></strong></h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="clear"></div>

            <form action="<?php echo $links["controller"]; ?>" method="post" id="editForm" style="margin-top: 5px;">
                <input type="hidden" name="operation" value="edit_template">

                <div id="tab-lang"><!-- tab wrap content start -->
                    <ul class="tab">
                        <?php
                            foreach($lang_list AS $lang){
                                ?>
                                <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, '<?php echo $lang["key"]; ?>','lang')" data-tab="<?php echo $lang["key"]; ?>"> <?php echo strtoupper($lang["key"]); ?></a></li>
                                <?php
                            }
                        ?>
                    </ul>

                    <?php
                        foreach($lang_list AS $lang) {
                            $lkey   = $lang["key"];
                            $ldata  = $get_lang_data($lkey);
                            ?>
                            <div id="lang-<?php echo $lkey; ?>" class="tabcontent">

                                <div class="adminpagecon">

                                    <?php if($lang["local"]): ?>
                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/notifications/edit-status"); ?></div>
                                            <div class="yuzde70">
                                                <input<?php echo $template["status"] ? ' checked' : ''; ?> name="status" type="checkbox" class="sitemio-checkbox" id="status" value="1">
                                                <label for="status" class="sitemio-checkbox-label"></label>
                                            </div>
                                        </div>

                                        <div class="formcon">
                                            <div class="yuzde30"><?php echo __("admin/notifications/edit-departments"); ?><br>
                                                 <span class="kinfo"><?php echo __("admin/notifications/edit-departments-info"); ?></span>
                                            </div>
                                            <div class="yuzde70">
                                                <select class="select2-element" name="departments[]" multiple style="width: 100%;">
                                                    <?php
                                                        if($departments){
                                                            foreach($departments AS $row){
                                                                ?>
                                                                <option<?php echo is_array($template["departments"]) && in_array($row["id"],$template["departments"]) ? ' selected' : ''; ?> value="<?php echo $row["id"]; ?>"><?php echo $row["name"];?></option>
                                                                <?php
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                               
                                            </div>
                                        </div>

                                    <?php endif; ?>

                                    <div class="clear"></div>
                                    <br>

                                    <div class="accordions">

                                        <h3><?php echo __("admin/notifications/edit-notification-mail"); ?></h3>
                                        <div><!-- accordion content start -->

                                            <?php if($lang["local"]): ?>

                                                <div class="formcon">
                                                    <div class="yuzde30"><?php echo __("admin/notifications/edit-submit-mail-to-user"); ?></div>
                                                    <div class="yuzde70">
                                                        <input<?php echo $template["user-mail"] ? ' checked' : ''; ?> name="user-mail" type="checkbox" class="sitemio-checkbox" id="user-mail" value="1">
                                                        <label for="user-mail" class="sitemio-checkbox-label"></label>
                                                    </div>
                                                </div>

                                                <div class="formcon">
                                                    <div class="yuzde30"><?php echo __("admin/notifications/edit-submit-mail-to-admin"); ?></div>
                                                    <div class="yuzde70">
                                                        <input<?php echo $template["admin-mail"] ? ' checked' : ''; ?> name="admin-mail" type="checkbox" class="sitemio-checkbox" id="admin-mail" value="1">
                                                        <label for="admin-mail" class="sitemio-checkbox-label"></label>
                                                    </div>
                                                </div>

                                                <div class="formcon">
                                                    <div class="yuzde30"><?php echo __("admin/notifications/edit-external-email-addresses"); ?></div>
                                                    <div class="yuzde70">
                                                        <input name="emails" type="text" value="<?php echo $template["emails"]; ?>">
                                                        <span class="kinfo"><?php echo __("admin/notifications/edit-external-email-addresses-info"); ?></span>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                            <div class="formcon">
                                                <div class="yuzde30"><?php echo __("admin/notifications/edit-mail-subject"); ?></div>
                                                <div class="yuzde70">
                                                    <input name="mail-subject[<?php echo $lkey; ?>]" type="text" value="<?php echo $ldata["info"]["subject"]; ?>">
                                                </div>
                                            </div>

                                            <div class="formcon">
                                                <textarea class="tinymce-1" name="mail-content[<?php echo $lkey; ?>]"><?php echo $ldata["mail-content"]; ?></textarea>
                                            </div>

                                        </div><!-- accordion content end -->

                                        <h3><?php echo __("admin/notifications/edit-notification-sms"); ?></h3>
                                        <div><!-- accordion content start -->

                                            <?php if($lang["local"]): ?>

                                                <div class="formcon">
                                                    <div class="yuzde30"><?php echo __("admin/notifications/edit-submit-sms-to-user"); ?></div>
                                                    <div class="yuzde70">
                                                        <input<?php echo $template["user-sms"] ? ' checked' : ''; ?> name="user-sms" type="checkbox" class="sitemio-checkbox" id="user-sms" value="1">
                                                        <label for="user-sms" class="sitemio-checkbox-label"></label>
                                                    </div>
                                                </div>

                                                <div class="formcon">
                                                    <div class="yuzde30"><?php echo __("admin/notifications/edit-submit-sms-to-admin"); ?></div>
                                                    <div class="yuzde70">
                                                        <input<?php echo $template["admin-sms"] ? ' checked' : ''; ?> name="admin-sms" type="checkbox" class="sitemio-checkbox" id="admin-sms" value="1">
                                                        <label for="admin-sms" class="sitemio-checkbox-label"></label>
                                                    </div>
                                                </div>

                                                <div class="formcon">
                                                    <div class="yuzde30"><?php echo __("admin/notifications/edit-external-phone-numbers"); ?></div>
                                                    <div class="yuzde70">
                                                        <input name="phones" type="text" value="<?php echo $template["phones"]; ?>">
                                                        <span class="kinfo"><?php echo __("admin/notifications/edit-external-phone-numbers-info"); ?></span>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                            <div class="formcon">
                                                <textarea placeholder="<?php echo __("admin/notifications/edit-sms-content-pholder"); ?>" name="sms-content[<?php echo $lkey; ?>]" rows="10"><?php echo $ldata["sms-content"]; ?></textarea>
                                            </div>

                                        </div><!-- accordion content end -->

                                    </div>

                                    <div class="clear"></div>

                                    <div class="formcon">
                                        <div class="yuzde30">
                                            <?php echo __("admin/notifications/edit-variables"); ?>
                                            <div class="clear"></div>
                                            <span class="kinfo"><?php echo __("admin/notifications/edit-variables-info"); ?></span>
                                        </div>
                                        <div class="yuzde70" id="template-variables">
                                            <?php
                                                $variables = $template["variables"] ? explode(",",$template["variables"]) : [];
                                                if($variables){
                                                    foreach($variables AS $row){
                                                        ?>
                                                        <span><?php echo $row; ?></span>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                        </div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30">
                                            <?php echo __("admin/notifications/edit-website-variables"); ?>
                                            <div class="clear"></div>
                                            <span class="kinfo"><?php echo __("admin/notifications/edit-website-variables-info"); ?></span>
                                        </div>
                                        <div class="yuzde70" id="template-variables">
                                            <span>{website_header_logo}</span>
                                            <span>{website_footer_logo}</span>
                                            <span>{notifi_header_logo}</span>
                                            <span>{notifi_footer_logo}</span>
                                            <span>{notifi_body}</span>
                                            <span>{website_url}</span>
                                            <span>{website_title}</span>
                                            <span>{website_infos}</span>
                                            <span>{website_emails}</span>
                                            <span>{website_phones}</span>
                                            <span>{website_address}</span>
                                        </div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30">
                                            <?php echo __("admin/notifications/edit-user-variables"); ?>
                                            <div class="clear"></div>
                                            <span class="kinfo"><?php echo __("admin/notifications/edit-user-variables-info"); ?></span>
                                        </div>
                                        <div class="yuzde70" id="template-variables">
                                            <span>{user_id}</span>
                                            <span>{user_login_link}</span>
                                            <span>{user_full_name}</span>
                                            <span>{user_name}</span>
                                            <span>{user_surname}</span>
                                            <span>{user_company_name}</span>
                                            <span>{user_email}</span>
                                            <span>{user_pass}</span>
                                            <span>{user_phone}</span>
                                            <span>{user_country}</span>
                                            <span>{user_city}</span>
                                            <span>{user_counti}</span>
                                            <span>{user_address}</span>
                                            <span>{user_zipcode}</span>
                                            <span>{user_ip}</span>
                                        </div>
                                    </div>


                                </div>

                                <div class="clear"></div>
                            </div>
                            <?php
                        }
                    ?>


                </div><!-- tab wrap content end -->


                <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                    <a class="yesilbtn gonderbtn" id="editForm_submit" href="javascript:void(0);"><?php echo ___("needs/button-update"); ?></a>
                </div>
                <div class="clear"></div>
            </form>


            <div class="clear"></div>
        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>