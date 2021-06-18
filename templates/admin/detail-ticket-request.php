<!DOCTYPE html>
<html>
<head>
    <?php

        $privOperation  = Admin::isPrivilege("TICKETS_OPERATION");
        $privDelete     = Admin::isPrivilege("TICKETS_DELETE");
        $privOrder      = Admin::isPrivilege("ORDERS_LOOK");
        $privUser       = Admin::isPrivilege("USERS_LOOK");

        if(isset($user)){
            $user_name  = "<strong>".$user["full_name"]."</strong>";
            if($user["company_name"]) $user_name .= " (".$user["company_name"].")";
        }
        $plugins    = [
            'tinymce' => ["height" => 258],
            'tinymce-1',
            'jquery-ui',
            'select2',
        ];
        include __DIR__.DS."inc".DS."head.php";
    ?>
    <link rel="stylesheet" href="<?php echo $tadress; ?>css/ionicons.min.css">

    <script type="text/javascript">
        var process_assign_me = false;
        var device_mobile=false;
        var last_reply_id = 0;
        var last_admin_reply_id = 0;
        var last_userunread=false;
        var last_assigned = <?php echo $ticket["assigned"]; ?>;
        var auto_save_msg_key = 'admin_ticket_<?php echo $ticket["id"]; ?>';
        var awaiting_auto_saved=false;
        var changed_status=false;
        var temp_get_replies = false;
        $(document).ready(function(){
            <?php if(Config::get("options/ticket-assignable")): ?>
                <?php if(!$is_assigned): ?>$('#reply_wrap').css("display","none");<?php endif; ?>
            <?php endif; ?>

            <?php if($is_assigned && Utility::strlen($ticket["notes"]) > 1): ?>
            open_modal("staff_note_modal");

            $("#staff_note_modal").on("click","#update_staff_info_form_submit",function(){
                MioAjaxElement($(this),{
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                    result:"update_staff_info_form_handler",
                });
            });
            <?php endif; ?>

            device_mobile = $("#mobile_open_reply").css("display") == "block";

            if(device_mobile){
                $(".input-is-mobile").val('1');
                tinymce.remove("#reply_message");
                $("#reply_message").css({"display":"block","visibility":"visible"});
                var message = $("#admin_signature").html();
                message     = "\n\n" + message.replace(/<br.*>/g, '');
                $("#reply_message").val(message);
                $("html, body").animate({ scrollTop: $("#messageTop").offset().top - 20},1000);
            }

            var auto_save_msg = localStorage.getItem(auto_save_msg_key);

            if(auto_save_msg !== undefined && auto_save_msg !== '' && auto_save_msg !== false && strip_tags(auto_save_msg) !== ''){
                var value = auto_save_msg;
                if(device_mobile){
                    value     = value.replace(/<br.*>/g, '\n');
                    value     = value.replace(/<(?:.|\n)*?>/gm, '');
                }
                else
                    tinymce.get('reply_message').setContent(value);

                $("#reply_message").val(value);
            }


            $("select[name=predefined-reply]").select2({width:'100%'});

            change_department();

            $("#SelectDepartment").change(change_department);

            $("#reply_request_submit,#mobile_reply_request_submit").click(function(){
                $("#editForm input[name=operation]").val("reply_request");
                MioAjaxElement($(this),{
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                    result:"requestForm_handler",
                });
            });

            $("#edit_request_submit").on("click",function(){
                edit_request_submit_btn(this);
            });

            $("#ticketCustomFields").on("click","#edit_request_submit2",function(){
                edit_request_submit_btn(this);
            });

            $("#mobile_edit_request_submit").click(function(){
                $("#editForm input[name=operation]").val("edit_request");
                $("#editForm input[name='attachments[]']").val('');
                MioAjaxElement($(this),{
                    waiting_text: '<i class="fa fa-spinner" aria-hidden="true" style="-webkit-animation:fa-spin 2s infinite linear;animation: fa-spin 2s infinite linear;"></i>',
                    progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                    result:"requestForm_handler",
                });
            });

            $("#mobile_open_reply").click(function(){
                $("#mobanswerarea").slideToggle(250);
            });

            $(document).on('focusin', function(e) {
                if ($(event.target).closest(".mce-window").length) {
                    e.stopImmediatePropagation();
                }
            });

            $("#reply_message").keyup(change_reply_message);
            $("#reply_message").change(change_reply_message);

            if(!device_mobile){
                tinymce.get('reply_message').on('keyup change',change_reply_message);
            }
            get_replies();
            setInterval(get_replies,3000);
        });
        function change_reply_message(){
            var message_el = $("#reply_message");
            localStorage.setItem(auto_save_msg_key,message_el.val());
            var auto_saved_el = $("#auto_saved");
            if(!awaiting_auto_saved){
                awaiting_auto_saved = true;
                auto_saved_el.css("opacity","1").fadeIn(500,function(){
                    auto_saved_el.animate({opacity:0},{duration:3000,complete:function(){
                            auto_saved_el.css("display","none");
                            awaiting_auto_saved = false;
                        }});
                });
            }
        }
        function edit_request_submit_btn(el){
            $("#editForm input[name=operation]").val("edit_request");
            $("#editForm input[name='attachments[]']").val('');
            MioAjaxElement($(el),{
                waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                result:"requestForm_handler",
            });
        }
        function get_replies(){
            if(temp_get_replies === true) return false;
            if(windowActive !== "on") return false;
            temp_get_replies = true;
            var request = MioAjax({
                action:"<?php echo $links["controller"];?>",
                method:"POST",
                data:{
                    operation:"get-replies",
                    last_reply_id:last_reply_id,
                },
            },true,true);
            request.done(function(result){
                temp_get_replies = false;
                if(result !== ''){
                    var solve = getJson(result);
                    if(solve !== false){

                        if(solve.user_is_typing !== undefined){
                            if(solve.user_is_typing)
                                $("#user_is_typing").fadeIn(500);
                            else
                                $("#user_is_typing").fadeOut(500);
                        }

                        if(solve.status !== undefined && !changed_status){
                            $("#get_status option").removeAttr("selected");
                            $("#get_status option[value='"+solve.status+"']").attr("selected",true);
                        }

                        if(solve.lastreply !== undefined && solve.lastreply != '')
                            $("#get_lastreply").html(solve.lastreply);

                        if(last_reply_id > 0 && last_admin_reply_id !== solve.last_admin_reply_id)
                            $("#Reply"+last_admin_reply_id+" .goruldu").html('');

                        if(solve.content != undefined && solve.content !== ''){

                            setTimeout(function(){
                                $(".new-reply").removeClass('new-reply');
                            },5000);

                            if(last_reply_id > 0) {
                                $("#detailTicketReplies").prepend(solve.content);
                                $("html, body").animate({ scrollTop: $("#messageTop").offset().top - 300},200);
                            }else{
                                $("#detailTicketReplies").animate({opacity: 0}, 500,function(){
                                    $("#detailTicketReplies").html(solve.content);
                                    $("#detailTicketReplies").animate({opacity: 1}, 500);
                                });
                            }
                            last_reply_id           = solve.last_reply_id;
                        }

                        if(last_admin_reply_id !== solve.last_admin_reply_id || last_userunread !== solve.userunread){
                            var last_admin_reply = $("#Reply"+solve.last_admin_reply_id+" .goruldu");
                            if(solve.userunread)
                                last_admin_reply.html(
                                    '<i title="<?php echo htmlentities(__("admin/tickets/request-detail-user-viewed"),ENT_QUOTES); ?>" class="ion-android-done-all"></i>'
                                );
                            else
                                last_admin_reply.html(
                                    '<i title="<?php echo htmlentities(__("admin/tickets/request-detail-user-unviewed"),ENT_QUOTES); ?>" class="gorulmedi ion-android-done-all"></i>'
                                );
                        }

                        <?php if(Config::get("options/ticket-assignable")): ?>
                        if(last_assigned !== parseInt(solve.assigned))
                        {
                            console.log(last_assigned);
                            console.log(solve.assigned);
                            $("html, body").animate({ scrollTop: $("#assign_wrap").offset().top - 300},200);
                            $("select[name=assigned]").val(solve.assigned);

                            if(solve.is_assigned)
                            {
                                $("#assign_wrap").css("display","none");
                                $("#reply_wrap").css("display","inline-block");
                                if(device_mobile) $("#mobile_open_reply_wrap").css("display","block");
                                else $("#reply_request_submit").css("display","block");
                                $("#auto_saved_wrap").css("display","block");

                            }
                            else
                            {
                                $("#assign_wrap").css("display","block");
                                $("#reply_wrap").css("display","none");
                                if(device_mobile) $("#mobile_open_reply_wrap").css("display","none");
                                else $("#reply_request_submit").css("display","none");
                                if(solve.assigned > 0)
                                {
                                    $("#assign_type_2").css("display","block");
                                    $("#assign_type_1").css("display","none");
                                    $("#assigned_link").attr("href",solve.assigned_link);
                                    $("#assigned_name").html(solve.assigned_name);
                                }
                                else
                                {
                                    $("#assign_type_1").css("display","block");
                                    $("#assign_type_2").css("display","none");
                                }
                                $("#auto_saved_wrap").css("display","none");
                            }


                        }
                        <?php endif; ?>



                        last_admin_reply_id     = solve.last_admin_reply_id;
                        last_userunread         = solve.userunread;
                        last_assigned           = parseInt(solve.assigned);

                    }
                }
            });
        }
        function requestForm_handler(result){
            if(result != ''){
                var solve = getJson(result);
                if(solve !== false){
                    if(solve.status == "error"){
                        if(solve.for != undefined && solve.for != ''){
                            $("#detailForm "+solve.for).focus();
                            $("#detailForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                            $("#detailForm "+solve.for).change(function(){
                                $(this).removeAttr("style");
                            });
                        }
                        if(solve.message != undefined && solve.message != '')
                        {
                            if(process_assign_me === false) alert_error(solve.message,{timer:5000});
                        }
                    }
                    else if(solve.status == "successful"){

                        get_replies();


                        if($("#editForm input[name=operation]").val() === "reply_request")
                        {
                            var value = '';
                            if(device_mobile){
                                var signature = "\n\n" + $("#admin_signature").html();
                                value     += signature.replace(/<br.*>/g, '');
                            }
                            else{
                                value     += "<br><br>"+$("#admin_signature").html();
                                tinymce.get('reply_message').setContent(value);
                            }

                            $("#reply_message").val(value).trigger("change");
                            localStorage.removeItem(auto_save_msg_key);

                            if(device_mobile) $("#mobanswerarea").slideUp(250);
                        }
                        else
                        {
                            if(process_assign_me === false) alert_success(solve.message,{timer:2000});
                        }

                        changed_status = false;
                        $("#get_status").attr("name","status_x");
                    }
                }else
                    console.log(result);
                process_assign_me = false;
            }
        }
        function change_predefined_reply(elem){
            var value = $(elem).val();
            if(device_mobile){
                value     = value.replace(/<br.*>/g, '\n');
                value     = value.replace(/<(?:.|\n)*?>/gm, '');
                var signature = "\n\n" + $("#admin_signature").html();
                value     += signature.replace(/<br.*>/g, '');
            }else{
                value     += $("#admin_signature").html();
                tinymce.get('reply_message').setContent(value);
            }

            $("#reply_message").val(value).trigger("change");
        }
        function editReply(id){
            var value = $("#Reply"+id+" .reply-message").html();
            if(device_mobile){
                value     = value.replace(/<br(.*?)>/g, '\n');
                value     = value.replace(/\n\n/g, '\n');

                value     = value.replace(/<(?:.|\n)*?>/gm, '');
                value     = value.trim();
                value     = html_entity_decode(value);
                $('#editReply_'+id+'_msg').css("display","block");
            }else
                tinymce.get('editReply_'+id+'_msg').setContent(value);
            $('#editReply_'+id+'_msg').val(value).trigger("change");
            $("#Reply"+id+" .reply-message").fadeOut(250,function(){
                $("#editReply_"+id).fadeIn(250);
            });

            $("#editReply_"+id+" .edit-btn-ok").click(function(){
                if(device_mobile){
                    var content     = $('#editReply_'+id+'_msg').val();
                }else
                    var content =  tinymce.get('editReply_'+id+'_msg').getContent();

                $("#editReplyForm input[name=id]").val(id);
                $("#editReplyForm textarea[name=message]").val(content);

                MioAjaxElement($(this),{
                    form:$("#editReplyForm"),
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    result:"editReplyForm_handler",
                });

            });

            $("#editReply_"+id+" .edit-btn-cancel").click(function(){
                $("#editReply_"+id).fadeOut(250,function(){
                    $("#Reply"+id+" .reply-message").fadeIn(250);
                });
            });

        }
        function editReplyForm_handler(result){
            if(result != ''){
                var solve = getJson(result);
                if(solve !== false){
                    var id  = $("#editReplyForm input[name=id]").val();
                    if(solve.status == "error"){
                        if(solve.message != undefined && solve.message != '')
                            alert_error(solve.message,{timer:5000});
                    }else if(solve.status == "successful"){

                        var content = $("#editReplyForm textarea[name=message]").val();
                        if(device_mobile){
                            content = html_entities(content);
                            content = nl2br(content);
                        }

                        $("#Reply"+id+" .reply-message").html(content);
                        $("#editReply_"+id).fadeOut(250,function(){
                            $("#Reply"+id+" .reply-message").fadeIn(250);
                        });

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
        function deleteReply(id){
            if(confirm("<?php echo __("admin/tickets/delete-are-youu-sure"); ?>")){
                var request = MioAjax({
                    action:"<?php echo $links["controller"]; ?>",
                    method:"POST",
                    data:{
                        operation:"delete_reply",
                        id:id,
                    },
                },true,true);

                request.done(function(result){
                    if(result != ''){
                        var solve = getJson(result);
                        if(solve !== false){
                            if(solve.status == "error"){
                                if(solve.message != undefined && solve.message != '')
                                    alert_error(solve.message,{timer:5000});
                            }else if(solve.status == "successful"){
                                $(".reply-item-"+id).remove();
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
                });
            }
        }
        function change_department(){
            var el          = $("#SelectDepartment");
            var val         = el.val();

            if(val !== '' && document.getElementsByClassName("department-"+val+"-field")){
                $(".department-fields").css("display","none");
                $(".department-" + val + "-field").css("display", "block");
                $("#ticketCustomFields_btn").fadeIn(500);
            }else{
                $(".department-fields").css("display","none");
                $("#ticketCustomFields_btn").fadeOut(500);
            }
        }
        function change_status(){
            changed_status = true;
            $("#get_status").attr("name","status");
        }
        function update_staff_info_form_handler(result){
            if(result != ''){
                var solve = getJson(result);
                if(solve !== false){
                    if(solve.status == "error"){
                        if(solve.for != undefined && solve.for != ''){
                            $("#update_staff_info_form "+solve.for).focus();
                            $("#update_staff_info_form "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                            $("#update_staff_info_form "+solve.for).change(function(){
                                $(this).removeAttr("style");
                            });
                        }
                            if(solve.message != undefined && solve.message != '')
                                alert_error(solve.message,{timer:3000});
                    }
                    else if(solve.status == "successful")
                    {
                        alert_success(solve.message,{timer:3000});
                        $("#editForm textarea[name=notes]").val($("#staff_note_modal #update_staff_info_form textarea[name=notes]").val());
                        if($("#staff_note_modal #update_staff_info_form input[type=checkbox]").prop("checked"))
                            $("#editForm select[name=assigned]").val(0);
                        else
                            $("#editForm select[name=assigned]").val($("#staff_note_modal #update_staff_info_form select[name=assigned]").val());
                    }
                }else
                    console.log(result);
            }

        }
        function assign_me(el)
        {
            process_assign_me = true;
            $("select[name=assigned]").val(<?php echo $udata["id"]; ?>);
            edit_request_submit_btn(el);
        }
    </script>
</head>
<body>

<div id="staff_note_modal" style="display: none;" data-izimodal-title="<?php echo __("admin/tickets/staff-note-info"); ?>">
    <div class="padding20">

        <form action="<?php echo $links["controller"]; ?>" method="post" id="update_staff_info_form">
            <input type="hidden" name="operation" value="update_staff_info">

            <textarea name="notes" rows="8" style="font-size:14px;" placeholder="<?php echo __("admin/tickets/request-detail-notes-i"); ?>"><?php echo isset($ticket["notes"]) ? $ticket["notes"] : ''; ?></textarea>

            <div class="formcon">

                <div class="yuzde40">
                    <input type="checkbox" name="dont-show-it-again" id="dont-show-it-again" value="1" class="checkbox-custom">
                    <label class="checkbox-custom-label" for="dont-show-it-again"><?php echo __("admin/tickets/dont-show-it-again"); ?></label>
                </div>


                <div class="yuzde60">
                   
                        <div class="yuzde40"><?php echo __("admin/tickets/request-detail-assigned"); ?></div>
                        <div class="yuzde60">
                            <select<?php echo $privOperation ? '' : ' disabled'; ?> name="assigned">
                                <option value="0"><?php echo ___("needs/none"); ?></option>
                                <?php
                                    if(isset($assignable_users) && $assignable_users){
                                        foreach($assignable_users AS $row){
                                            ?>
                                            <option<?php echo $ticket["assigned"] == $row["id"] ? " selected" : ""; ?> value="<?php echo $row["id"]; ?>"><?php echo $row["full_name"]; ?></option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                   
                </div>

                <div class="clear"></div>

                

            </div>

            <a style="    margin: 20px 0px;    float: right;" class="lbtn" href="javascript:void(0);" id="update_staff_info_form_submit"><?php echo __("admin/tickets/request-detail-button-update"); ?></a>

        </form>

    </div>
</div>

<form action="<?php echo $links["controller"]; ?>" method="post" id="editReplyForm" style="display: none">
    <input type="hidden" name="operation" value="edit_reply">
    <input type="hidden" name="id" value="0">
    <input type="hidden" name="mobile" value="0" class="input-is-mobile">
    <textarea name="message"></textarea>
</form>

<div id="admin_signature" style="display: none;"><?php echo $admin_signature; ?></div>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1><strong><?php echo __("admin/tickets/page-request-detail",['{id}' => $ticket["id"],'{subject}' => $ticket["title"]]); ?></strong> (#<?php echo $ticket["id"]; ?>)</h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="destekdetay">
                <form action="<?php echo $links["controller"]; ?>" method="post" id="editForm" enctype="multipart/form-data">
                    <input type="hidden" name="operation" value="reply_request">
                    <input type="hidden" name="mobile" value="0" class="input-is-mobile">


                    <?php
                        if($h_contents = Hook::run("TicketAdminAreaViewDetail",$ticket))
                            foreach($h_contents AS $h_content)
                                if($h_content) echo $h_content;
                    ?>


                    <!-- right sidebar start -->
                    <div class="yuzde48">

                        <?php
                            if($h_contents = Hook::run("TicketAdminAreaViewDetailSidebar",$ticket))
                                foreach($h_contents AS $h_content)
                                    if($h_content) echo $h_content;
                        ?>

                       

                       <div class="formcon">
                            <div class="yuzde30"><?php echo __("admin/tickets/request-detail-service"); ?>
                                <a id="browse_website" data-tooltip="<?php echo __("admin/tickets/request-detail-browse-website"); ?>" style="margin-left:5px;<?php echo isset($service) && isset($service["options"]["domain"]) ? '' : 'display: none;';?>" href="<?php echo isset($service) && isset($service["options"]["domain"]) ? 'http://'.$service["options"]["domain"] : '#';?>" referrerpolicy="no-referrer" target="_blank"><i class="fa fa-external-link" aria-hidden="true"></i></a>

                                <a id="view_order" data-tooltip="<?php echo __("admin/tickets/request-detail-view-order"); ?>" style="margin-left:5px;<?php echo isset($service) && $service ? '' : 'display: none;';?>" href="<?php echo isset($service) && $service ? Controllers::$init->AdminCRLink('orders-2',['detail',$service["id"]]) : '#';?>" target="_blank"><i class="fa fa-search" aria-hidden="true"></i></a>

                            </div>
                            <div class="yuzde70">
                                <select<?php echo $privOperation ? '' : ' disabled' ?> name="service">
                                    <option value="0"><?php echo ___("needs/none"); ?></option>
                                    <?php
                                        if(isset($services) && $services){
                                            foreach($services AS $group){
                                                ?>
                                                <optgroup label="<?php echo $group["name"]; ?>">
                                                    <?php
                                                        foreach($group["items"] AS $row){
                                                            ?>
                                                            <option<?php echo isset($service) && $service["id"] == $row["id"] ? ' selected' : ''; ?> value="<?php echo $row["id"]; ?>"><?php echo $row["name"]; ?></option>
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

                        

                        <div class="formcon couplediv">
                            <div class="yuzde30"><?php echo __("admin/tickets/request-detail-department"); ?></div>
                            <div class="yuzde70">
                                <select<?php echo $privOperation ? '' : ' disabled'; ?> name="department" id="SelectDepartment">
                                    <?php
                                        if(isset($departments) && $departments){
                                            foreach($departments AS $row){
                                                ?>
                                                <option<?php echo $ticket["did"] == $row["id"] ? ' selected' : ''; ?> value="<?php echo $row["id"]; ?>"><?php echo $row["name"]; ?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                                    <option<?php echo $ticket["did"] == 0 ? ' selected' : ''; ?> value="0"><?php echo ___("needs/other"); ?></option>
                                </select>
                            </div>
                        </div>

                        <div class="formcon couplediv">
                            <div class="yuzde30"><?php echo __("admin/tickets/request-detail-priority"); ?></div>
                            <div class="yuzde70">
                                <select<?php echo $privOperation ? '' : ' disabled'; ?> name="priority">
                                    <?php
                                        foreach(__("admin/tickets/priorities") AS $key=>$value){
                                            ?>
                                            <option<?php echo $key == $ticket["priority"] ? ' selected' : ''; ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>

                        

                        <div class="formcon couplediv">
                            <div class="yuzde30"><?php echo __("admin/tickets/request-detail-cdate"); ?></div>
                            <div class="yuzde70">
                                <?php echo DateManager::format(Config::get("options/date-format")." - H:i",$ticket["ctime"]); ?>
                            </div>
                        </div>

                        <div class="formcon couplediv">
                            <div class="yuzde30"><?php echo __("admin/tickets/request-detail-ldate"); ?></div>
                            <div class="yuzde70" id="get_lastreply">
                                <?php echo DateManager::format(Config::get("options/date-format")." - H:i",$ticket["lastreply"]); ?>
                            </div>
                        </div>


                         <div class="formcon">
                            <div class="yuzde30"><?php echo __("admin/tickets/request-detail-status"); ?></div>
                            <div class="yuzde70">
                                <select<?php echo $privOperation ? '' : ' disabled'; ?> name="status_x" id="get_status" onchange="change_status();">
                                    <?php
                                        foreach(__("admin/tickets/situations") AS $key=>$row){
                                            if($key == 'active' || $key == 'inactive') continue;
                                            ?>
                                            <option<?php echo $ticket["status"] == $key ? ' selected' : ''; ?> value="<?php echo $key; ?>"><?php echo $row; ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        

                        <div class="formcon">
                            <div class="yuzde30"><?php echo __("admin/tickets/request-detail-assigned"); ?></div>
                            <div class="yuzde70">
                                <select<?php echo $privOperation ? '' : ' disabled'; ?> name="assigned">
                                    <option value="0"><?php echo ___("needs/none"); ?></option>
                                    <?php
                                        if(isset($assignable_users) && $assignable_users){
                                            foreach($assignable_users AS $row){
                                                ?>
                                                <option<?php echo $ticket["assigned"] == $row["id"] ? ' selected' : ''; ?> value="<?php echo $row["id"]; ?>"><?php echo $row["full_name"]; ?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <?php if($privOperation && $privUser): ?>
                            <div class="formcon nomobile">
                                <div class="yuzde30" style="width:100%;font-weight:600;"><?php echo __("admin/tickets/request-detail-notes"); ?></div>
                                <textarea name="notes" rows="5" style="font-size:13px;" placeholder="<?php echo __("admin/tickets/request-detail-notes-i"); ?>"><?php echo isset($ticket["notes"]) ? $ticket["notes"] : ''; ?></textarea>
                            </div>
                        <?php endif; ?>


                        <div class="formcon">
                            <div class="yuzde30"><?php echo __("admin/tickets/request-detail-locked"); ?></div>
                            <div class="yuzde70">
                                <input<?php echo $privOperation ? '' : ' disabled'; ?><?php echo $ticket["locked"] ? ' checked' : ''; ?> id="locked" class="checkbox-custom" name="locked" value="1" type="checkbox">
                                <label for="locked" class="checkbox-custom-label" style="margin-right: 5px;"></label> <span class="kinfo"><?php echo __("admin/tickets/request-detail-locked-i"); ?></span>
                            </div>
                        </div>


                         <div class="formcon">
                            <div class="yuzde30"><?php echo __("admin/users/detail-summary-add-bill"); ?></div>
                            <div class="yuzde70">
                                <a href="<?php echo $links["add-bill"]; ?>" class="lbtn"><i class="fa fa-plus" aria-hidden="true"></i> <?php echo __("admin/invoices/create-new-bill-button"); ?></a>
                            </div>
                        </div>

                       

                    </div>
                    <!-- right sidebar end -->

                    <!-- left sidebar start -->
                    <div class="yuzde50">

                        <?php if(Config::get("options/ticket-assignable")): ?>
                            <div class="formcon" id="assign_wrap" style="<?php echo $is_assigned ? 'display:none;' : ''; ?>">
                                <div style="text-align:center;margin: 60px 0px;">

                                    <div id="assign_type_1" style="<?php echo !isset($assigned) || !$assigned ? '' : 'display:none;'; ?>">
                                        <a class="yesilbtn gonderbtn" href="javascript:void(0);" onclick="assign_me(this);" style="    width: 250px; margin: 20px 0px;"><i class="fa fa-check" aria-hidden="true" style="margin-right: 5px;"></i> <?php echo __("admin/tickets/assign-me"); ?></a>
                                        <h5 style="    font-size: 16px;"><strong><?php echo __("admin/tickets/assign-text2"); ?></strong><br><?php echo __("admin/tickets/assign-text3"); ?></h5>
                                    </div>

                                    <div id="assign_type_2" style="<?php echo isset($assigned) && $assigned ? '' : 'display:none;'; ?>">
                                        <h5 style="font-size: 16px;"><?php echo __("admin/tickets/assign-text1",['{staff}' => '<a href="'.(isset($assigned_link) && $assigned_link ? $assigned_link : '#').'" target="_blank" id="assigned_link"><strong id="assigned_name">'.(isset($assigned) && $assigned ? $assigned["full_name"] : '?').'</strong></a>']); ?></h5>
                                        <a class="yesilbtn gonderbtn" href="javascript:void(0);" onclick="assign_me(this);" style="width: 250px;margin: 20px 0px;"><i class="fa fa-check" aria-hidden="true" style="margin-right: 5px;"></i> <?php echo __("admin/tickets/assign-me"); ?></a>
                                    </div>

                                </div>
                            </div>
                        <?php endif; ?>


                        <div id="reply_wrap">
                            <?php
                                if($privOperation){
                                    ?>


                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/tickets/request-detail-user"); ?></div>
                                        <div class="yuzde70">
                                            <?php if(isset($user_name)): ?>
                                                <?php if($privUser): ?>
                                                    <a href="<?php echo $user_link; ?>"><?php echo $user_name; ?></a>
                                                    -
                                                    <a href="<?php echo $user_link; ?>?tab=tickets" target="_blank">(<?php echo __("admin/tickets/request-detail-user-all-of-requests"); ?>)</a>
                                                    <?php
                                                    if(isset($user_blacklist) && $user_blacklist){
                                                        ?>
                                                        <span class="flaggeduser"><i class="fa fa-exclamation-circle" aria-hidden="true"></i><?php echo __("admin/orders/user-blacklist"); ?></span>
                                                        <?php
                                                    }
                                                    ?>
                                                <?php else: ?>
                                                    <?php echo $user_name; ?>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <strong><?php echo ___("needs/deleted"); ?></strong>
                                            <?php endif; ?>
                                        </div>
                                    </div>



                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/tickets/request-detail-predefined-replies"); ?></div>
                                        <div class="yuzde70">
                                            <select<?php echo $privOperation ? '' : ' disabled' ?> name="predefined-reply" onchange="change_predefined_reply(this);">
                                                <option value=""><?php echo ___("needs/select-your"); ?></option>
                                                <?php
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
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <?php
                                }
                            ?>

                            <div class="formcon" id="mobanswerarea">
                                <div id="wrapper">

                                    <div class="mobanswerarea-con">
                                        <div class="mobanswerarea-pad">
                                            <textarea id="reply_message" class="tinymce-1" rows="10" name="message"><?php echo ($admin_signature ? "<br><br>" : '').$admin_signature; ?></textarea>
                                        </div>
                                    </div>



                                    <a class="mobanswerbtn" href="javascript:void(0);" id="mobile_reply_request_submit"><?php echo __("admin/tickets/request-detail-button-reply"); ?></a>

                                </div>

                            </div>


                            <div class="formcon">
                                <?php if($privOperation): ?>
                                    <div class="yuzde30"><?php echo __("admin/tickets/request-detail-add-attachments"); ?></div>
                                    <div class="yuzde70"><input name="attachments[]" type="file" multiple><br>
                                        <span style="font-size:13px;">(<?php echo __("admin/tickets/request-detail-allowed-exts"); ?>: <?php echo $allowed_attachment_extensions; ?>)</span></div>
                                <?php endif; ?>
                            </div>

                        </div>

                        <div class="ticketdetailbtns">
                            <?php
                                if(isset($custom_fields_values) && $custom_fields_values){
                                    ?>
                                    <a class="lbtn nomobile" href="javascript:void 0;" onclick="open_modal('ticketCustomFields');" style="display:none" id="ticketCustomFields_btn"><i class="fa fa-info-circle" aria-hidden="true"></i><?php echo __("admin/tickets/request-detail-view-custom-fields"); ?></a>
                                    <?php
                                }
                            ?>

                            <?php if($privOperation): ?>

                                <div id="moboperation">

                                    <div style="float:right;" class="guncellebtn">
                                        <a class="yesilbtn gonderbtn nomobile" href="javascript:void(0);" id="reply_request_submit" style="<?php echo !Config::get("options/ticket-assignable") || $is_assigned ? '' : 'display:none;'; ?>"><?php echo __("admin/tickets/request-detail-button-reply"); ?></a>
                                    </div>

                                    <div style="<?php echo $is_assigned ? '' : 'display:none;'; ?>" id="auto_saved_wrap">
                                        <span id="auto_saved" style="display: none;"><?php echo __("website/account_tickets/auto-saved"); ?></span>
                                    </div>

                                    <a class="lbtn nomobile" href="javascript:void(0);" id="edit_request_submit"><?php echo __("admin/tickets/request-detail-button-update"); ?></a>


                                    <a href="javascript:void(0);" id="mobile_edit_request_submit" class="mobilupbtn"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                                    <span id="mobile_open_reply_wrap" style="<?php echo !Config::get("options/ticket-assignable") || $is_assigned ? '' : 'display:none;'; ?>">
                                        <a class="mobilanswerbtn" id="mobile_open_reply" href="javascript:void(0);"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                    </span>

                                </div>

                            <?php endif; ?>

                            <div class="clienttyping" style="display: none;" id="user_is_typing">
                                <?php echo __("admin/tickets/request-detail-user-is-typing",[
                                    '{name}' => $user["name"],
                                    '{surname}' => $user["surname"],
                                    '{full_name}' => $user["full_name"],
                                ]); ?>
                                <div class="spinner">
                                    <div class="bounce1"></div>
                                    <div class="bounce2"></div>
                                    <div class="bounce3"></div>

                                    <style>
                                        .clienttyping{display:inline-block;width:30%;    margin-top: 25px;color:#aeaeae;text-align:center}
                                        .spinner{display:inline-block;width:auto;height:auto;    margin-left: 5px;}
                                        .spinner>div{width:10px;height:10px;background-color:#ccc;border-radius:100%;display:inline-block;-webkit-animation:sk-bouncedelay 1.4s infinite ease-in-out both;animation:sk-bouncedelay 1.4s infinite ease-in-out both}
                                        .spinner .bounce1{-webkit-animation-delay:-0.32s;animation-delay:-0.32s}
                                        .spinner .bounce2{-webkit-animation-delay:-0.16s;animation-delay:-0.16s}
                                        @-webkit-keyframes sk-bouncedelay{0%,80%,100%{-webkit-transform:scale(0)}
                                            40%{-webkit-transform:scale(1.0)}
                                        }
                                        @keyframes sk-bouncedelay{0%,80%,100%{-webkit-transform:scale(0);transform:scale(0)}
                                            40%{-webkit-transform:scale(1.0);transform:scale(1.0)}
                                        }

                                    </style>
                                </div>
                            </div>


                        </div>



                        <div id="messageTop"></div>

                        <div id="detailTicketReplies">

                            <div align="center">
                                <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
                            </div>




                        </div>


                    </div>
                    <!-- left sidebar end -->

                    <div class="clear"></div>




                    <div id="ticketCustomFields" style="display: none;" data-izimodal-title="<?php echo __("admin/tickets/request-detail-view-custom-fields"); ?>">
                        <div class="padding20">
                            <?php
                                if(isset($custom_fields) && $custom_fields){
                                    foreach($custom_fields AS $field){
                                        $options    = $field["options"];
                                        $properties = $field["properties"];
                                        $wrap_invisible  = false;

                                        if($options) $options = Utility::jdecode($options,true);
                                        if(isset($properties["wrap_visibility"]) && $properties["wrap_visibility"] == "invisible")
                                            $wrap_invisible = 'style="display:none;"';

                                        $rtype    = $field["type"];
                                        $response = NULL;
                                        if(isset($custom_fields_values[$field["id"]]) && $custom_fields_values[$field["id"]])
                                            $response = $custom_fields_values[$field["id"]]["value"];
                                        ?>
                                        <div class="ticketcustomitem department-<?php echo $field["did"]; ?>-field department-fields" id="field-<?php echo $field["id"]; ?>-wrap" <?php echo $wrap_invisible; ?>>
                                            <div class="yuzde50">
                                                <?php if(isset($properties["compulsory"]) && $properties["compulsory"]){ ?><span class="zorunlu">*</span><?php } ?>
                                                <label for="field-<?php echo $field["id"]; ?>">
                                                    <strong><?php echo $field["name"]; ?></strong>
                                                    <?php if($field["description"]): ?>
                                                        <br>
                                                        <span class="kinfo"><?php echo nl2br($field["description"]); ?></span>
                                                    <?php endif; ?>
                                                </label>
                                            </div>
                                            <div class="yuzde50">
                                                <?php
                                                    if($rtype == "file" && $response){
                                                        foreach($response AS $k=>$re){
                                                            $link = $links["controller"]."?operation=field-file-download&fid=".$field["id"]."&key=".$k;
                                                            ?><a href="<?php echo $link; ?>" target="_blank" class="lbtn"><i class="fa fa-external-link" aria-hidden="true"></i> <?php echo Utility::short_text($re["file_name"],0,30,true); ?></a> <?php
                                                        }
                                                    }
                                                    elseif($rtype == "input" || $rtype == "select" || $rtype == "radio"){
                                                        ?>
                                                        <input type="text" name="fields[<?php echo $field["id"]; ?>]" value="<?php echo str_replace('"','\"',$response); ?>">
                                                        <?php
                                                    }
                                                    elseif($rtype == "textarea"){
                                                        ?>
                                                        <textarea name="fields[<?php echo $field["id"]; ?>]"><?php echo $response; ?></textarea>
                                                        <?php
                                                    }
                                                    elseif($rtype == "checkbox"){
                                                        if($response){
                                                            $response_n = [];
                                                            $response   = explode(",",$response);
                                                            foreach($options AS $opt){
                                                                if(!in_array($opt["id"],$response)) continue;
                                                                ?>
                                                                <input type="text" name="fields[<?php echo $field["id"]; ?>][]" value="<?php echo str_replace('"','\"',$opt["name"]); ?>">
                                                                <?php
                                                            }
                                                            ?>

                                                            <?php
                                                        }
                                                    }

                                                    if(isset($properties["define_end_of_element"]))
                                                        if($properties["define_end_of_element"])
                                                            echo $properties["define_end_of_element"];
                                                ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                            ?>


                            <div class="clear"></div>

                            <div style="float:right;" class="guncellebtn yuzde30">
                                <a style="width: 100%;" class="yesilbtn gonderbtn" href="javascript:void(0);" id="edit_request_submit2"><?php echo __("admin/tickets/request-detail-button-update"); ?></a>
                            </div>
                            <div class="clear"></div>

                        </div>
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