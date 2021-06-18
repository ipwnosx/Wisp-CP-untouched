<!DOCTYPE html>
<html>
<head>
    <?php
        $plugins    = ['select2','tinymce-1'];
        include __DIR__.DS."inc".DS."head.php";
        $order_id = (int) Filter::init("GET/order_id","numbers");
    ?>

    <script type="text/javascript">
        $(document).ready(function(){

            $(".select2").select2();

            $("#addNewForm_submit").on("click",function(){
                MioAjaxElement($(this),{
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                    result:"addNewForm_handler",
                });
            });

            $("#select-user").select2({
                placeholder: "<?php echo __("admin/orders/create-select-user"); ?>",
                ajax: {
                    url: '<?php echo $links["select-users.json"]; ?>',
                    dataType: 'json',
                    data: function (params) {
                        var query = {
                            search: params.term,
                            type: 'public'
                        }
                        return query;
                    }
                }
            });

        });

        function change_user(elem){
            var value = $(elem).val();

            window.location.href = "<?php echo $links["controller"]; ?>?user_id="+value;

        }

        function change_predefined_reply(elem){
            var value = $(elem).val();
            value += $("#admin_signature").html();
            tinymce.get('reply_message').setContent(value);
            $("#reply_message").val(value).trigger("change");
        }

        function addNewForm_handler(result){
            if(result != ''){
                var solve = getJson(result);
                if(solve !== false){
                    if(solve.status == "error"){
                        if(solve.for != undefined && solve.for != ''){
                            $("#addNewForm "+solve.for).focus();
                            $("#addNewForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                            $("#addNewForm "+solve.for).change(function(){
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

<div id="admin_signature" style="display: none;"><?php echo $admin_signature; ?></div>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1><strong><?php echo __("admin/tickets/page-create"); ?></strong></h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="clear"></div>

            <div class="destekdetay">
                <form action="<?php echo $links["controller"]; ?>" method="post" id="addNewForm" enctype="multipart/form-data">
                    <input type="hidden" name="operation" value="add_request">

                    <div class="clear"></div>
                    <?php
                        if($h_contents = Hook::run("TicketAdminAreaViewCreate"))
                            foreach($h_contents AS $h_content)
                                if($h_content) echo $h_content;
                    ?>
                    <div class="clear"></div>

                    <div class="yuzde50">
                        <div class="formcon">
                            <div class="yuzde30"><?php echo __("admin/tickets/request-detail-user"); ?></div>
                            <div class="yuzde70">

                                <select onchange="change_user(this);" name="user_id" id="select-user" style="width: 100%;">
                                    <?php
                                        if(isset($user) && $user){
                                            $name = $user["full_name"];
                                            if($user["company_name"]) $name .= " - ".$user["company_name"];
                                            ?>
                                            <option value="<?php echo $user["id"]; ?>"><?php echo $name; ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>

                            </div>
                        </div>



                        <div class="formcon">
                            <div class="yuzde30"><?php echo __("admin/tickets/request-detail-service"); ?>
                                <a id="browse_website" title="<?php echo __("admin/tickets/request-detail-browse-website"); ?>" style="margin-left:5px;<?php echo isset($service) && isset($service["options"]["domain"]) ? '' : 'display: none;';?>" href="<?php echo isset($service) && isset($service["options"]["domain"]) ? 'http://'.$service["options"]["domain"] : '#';?>" referrerpolicy="no-referrer" target="_blank"><i class="fa fa-external-link" aria-hidden="true"></i></a>
                            </div>
                            <div class="yuzde70">
                                <select name="service" class="select2">
                                    <option value="0"><?php echo ___("needs/none"); ?></option>
                                    <?php
                                        if(isset($services) && $services){
                                            foreach($services AS $group){
                                                ?>
                                                <optgroup label="<?php echo $group["name"]; ?>">
                                                    <?php
                                                        foreach($group["items"] AS $row){
                                                            ?>
                                                            <option<?php echo (isset($service) && $service["id"] == $row["id"]) || $order_id == $row["id"] ? ' selected' : ''; ?> value="<?php echo $row["id"]; ?>"><?php echo $row["name"]; ?></option>
                                                            <?php
                                                        }
                                                    ?>
                                                </optgroup>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="formcon">
                            <div class="yuzde30"><?php echo __("admin/tickets/request-detail-status"); ?></div>
                            <div class="yuzde70">
                                <select name="status">
                                    <?php
                                        foreach(__("admin/tickets/situations") AS $key=>$row){
                                            if($key == 'active' || $key == 'inactive') continue;
                                            ?>
                                            <option value="<?php echo $key; ?>"><?php echo $row; ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="formcon">
                            <div class="yuzde30"><?php echo __("admin/tickets/request-detail-predefined-replies"); ?></div>
                            <div class="yuzde70">
                                <select name="predefined-reply" class="select2" onchange="change_predefined_reply(this);">
                                    <option value=""><?php echo ___("needs/select-your"); ?></option>
                                    <?php
                                        if(isset($predefined_replies) && $predefined_replies)
                                        {
                                            foreach($predefined_replies AS $category){
                                                if($category["items"]){
                                                    ?>
                                                    <optgroup label="<?php echo $category["title"]; ?>">
                                                        <?php
                                                            foreach($category["items"] AS $item){
                                                                ?><option value="<?php echo htmlspecialchars($item["message"],ENT_QUOTES); ?>"><?php echo $item["name"]; ?></option><?php
                                                            }
                                                        ?>
                                                    </optgroup>
                                                    <?php
                                                }
                                            }foreach($predefined_replies AS $category){
                                            if($category["items"]){
                                                ?>
                                                <optgroup label="<?php echo $category["title"]; ?>">
                                                    <?php
                                                        foreach($category["items"] AS $item){
                                                            ?><option value="<?php echo htmlspecialchars($item["message"],ENT_QUOTES); ?>"><?php echo $item["name"]; ?></option><?php
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
                            <textarea id="reply_message" class="tinymce-1" name="message"><?php echo $admin_signature; ?></textarea>
                        </div>

                    </div>


                    <div class="yuzde48">

                        <div class="clear"></div>
                        <?php
                            if($h_contents = Hook::run("TicketAdminAreaViewCreateSidebar"))
                                foreach($h_contents AS $h_content)
                                    if($h_content) echo $h_content;
                        ?>
                        <div class="clear"></div>

                        <div class="formcon">
                            <div class="yuzde30"><?php echo __("admin/tickets/request-detail-subject"); ?></div>
                            <div class="yuzde70">
                                <input type="text" name="subject" value="">
                            </div>
                        </div>


                        <div class="formcon">
                            <div class="yuzde30"><?php echo __("admin/tickets/request-detail-department"); ?></div>
                            <div class="yuzde70">
                                <select name="department">
                                    <?php
                                        if(isset($departments) && $departments){
                                            foreach($departments AS $row){
                                                ?>
                                                <option value="<?php echo $row["id"]; ?>"><?php echo $row["name"]; ?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                                    <option selected value="0"><?php echo ___("needs/other"); ?></option>
                                </select>
                            </div>
                        </div>

                        <div class="formcon">
                            <div class="yuzde30"><?php echo __("admin/tickets/request-detail-priority"); ?></div>
                            <div class="yuzde70">
                                <select name="priority">
                                    <?php
                                        foreach(__("admin/tickets/priorities") AS $key=>$value){
                                            ?>
                                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="formcon">
                            <div class="yuzde30"><?php echo __("admin/tickets/request-detail-assigned"); ?></div>
                            <div class="yuzde70">
                                <select name="assigned">
                                    <option value="0"><?php echo ___("needs/none"); ?></option>
                                    <?php
                                        if(isset($assignable_users) && $assignable_users){
                                            foreach($assignable_users AS $row){
                                                ?>
                                                <option value="<?php echo $row["id"]; ?>"><?php echo $row["full_name"]; ?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>



                        <div class="formcon">
                            <div class="yuzde30"><?php echo __("admin/tickets/request-detail-locked"); ?></div>
                            <div class="yuzde70">
                                <input id="locked" class="checkbox-custom" name="locked" value="1" type="checkbox">
                                <label for="locked" class="checkbox-custom-label" style="margin-right: 5px;"></label> <span class="kinfo"><?php echo __("admin/tickets/request-detail-locked-i"); ?></span>
                            </div>
                        </div>

                        <?php if(isset($user)): ?>
                            <div class="formcon">
                                <div class="yuzde30" style="width:100%;font-weight:600;"><?php echo __("admin/tickets/request-detail-notes"); ?></div>
                                <textarea name="notes" rows="4" style="font-size:13px;" placeholder="<?php echo __("admin/tickets/request-detail-notes-i"); ?>"><?php echo $user["notes"]; ?></textarea>
                            </div>
                        <?php endif; ?>

                        <div class="formcon">
                            <label>
                                <?php echo __("admin/tickets/request-detail-add-attachments"); ?>:
                                <input style="width:50%" name="attachments[]" type="file" multiple><br>
                                <span style="font-size:13px;">(<?php echo __("admin/tickets/request-detail-allowed-exts"); ?>: <?php echo $allowed_attachment_extensions; ?>)</span></label></div>

                    </div>

                    <div class="clear"></div>

                    <div class="yuzde40" style="float:right;">
                        <div style="float:right;" class="guncellebtn yuzde30">
                            <a class="yesilbtn gonderbtn" href="javascript:void(0);" id="addNewForm_submit"><?php echo __("admin/tickets/button-create"); ?></a>
                        </div>
                    </div>



                </form>
            </div>


                <div class="clear"></div>
        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>