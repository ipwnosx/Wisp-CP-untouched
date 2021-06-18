<?php
    $inc    = Filter::init("GET/bring","route");
    if($inc){

        die();
    }
?>
<!DOCTYPE html>
<html>
<head>
    <?php
        $privOperation  = Admin::isPrivilege("CONTACT_FORM_OPERATION");
        $privDelete     = Admin::isPrivilege("CONTACT_FORM_DELETE");
        $plugins        = ['dataTables'];
        include __DIR__.DS."inc".DS."head.php";
    ?>

    <style type="text/css">
        #datatable tbody tr td:nth-child(1),#datatable tbody tr td:nth-child(2) {
            text-align: left;
        }
    </style>
    <script>
        var table;
        $(document).ready(function() {


            $("#datatable").on("click",".read-msg",function(){

                open_modal('readMessage',{width:'800px'});

                var trElement   = $(this).parent().parent();

                var message     = $(".message-msg",trElement).html();
                message         = nl2br(message);
                var admin_message = $(".message-admin-msg",trElement).html();

                var name        = $(".message-name",trElement).html();
                var lang        = $(".message-lang",trElement).html();
                name            =  strip_tags(name);

                $("input[name=id]").val($(this).data("id"));
                $("#message-msg").html(html_entity_decode(message));
                $("#message-name").html(name);
                $("#message-lang").html(lang);
                if(admin_message == ''){
                    $("#admin_message").val('').removeAttr("disabled");
                    $("#replyMessage_disable").css("display","none");
                    $("#replyMessage_submit").css("display","block");
                }else{
                    $("#admin_message").val(admin_message).attr("disabled",true);
                    $("#replyMessage_submit").css("display","none");
                    $("#replyMessage_disable").css("display","block");
                }

            });


            table = $('#datatable').DataTable({
                "columnDefs": [
                    {
                        "targets": [0],
                        "visible":false,
                        "searchable": false
                    }
                ],
                "lengthMenu": [
                    [10, 25, 50, -1], [10, 25, 50, "<?php echo ___("needs/allOf"); ?>"]
                ],
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": "<?php echo $links["ajax"]; ?>",
                responsive: true,
                "oLanguage":<?php include __DIR__.DS."datatable-lang.php"; ?>
            });

        });

        function deleteMessage(id){

            if(typeof id == "object" && id.length>1){
                $("#password_wrapper").css("display","block");
            }else
                $("#password_wrapper").css("display","none");

            $("#password1").val('');

            var content = "<?php echo __("admin/manage-website/delete-are-you-sure"); ?>";
            $("#confirmModal_text").html(content);

            open_modal("ConfirmModal",{
                title:"<?php echo __("admin/manage-website/delete-messages-title"); ?>"
            });

            $("#delete_ok").click(function(){
                var password = $('#password1').val();
                var request = MioAjax({
                    button_element:$(this),
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    action: "<?php echo $links["controller"]; ?>",
                    method: "POST",
                    data: {operation:"delete_message",id:id,password:password}
                },true,true);

                request.done(function(result){
                    if(result){
                        if(result != ''){
                            var solve = getJson(result);
                            if(solve !== false){
                                if(solve.status == "error"){
                                    if(solve.message != undefined && solve.message != '')
                                        alert_error(solve.message,{timer:5000});
                                }else if(solve.status == "successful"){
                                    $("#password1").val('');
                                    alert_success(solve.message,{timer:3000});
                                    close_modal("ConfirmModal");
                                    table.ajax.reload();
                                }
                            }else
                                console.log(result);
                        }
                    }else console.log(result);
                });

            });

            $("#delete_no").click(function(){
                close_modal("ConfirmModal");
            });

        }

        function readMessage(id){
            var request = MioAjax({
                action: "<?php echo $links["controller"]; ?>",
                method: "POST",
                data: {operation:"read_message",id:id}
            },true,true);

            request.done(function(result){
                if(result){
                    if(result != ''){
                        var solve = getJson(result);
                        if(solve !== false){
                            if(solve.status == "error"){
                                if(solve.message != undefined && solve.message != '')
                                    alert_error(solve.message,{timer:5000});
                            }else if(solve.status == "successful"){
                                table.ajax.reload();
                            }
                        }else
                            console.log(result);
                    }
                }else console.log(result);
            });

        }

        function applySelection(element){
            var selection = $(element).val();
            if(selection == ''){

            }else{
                $(element).val('');

                var values = [],value;
                $('.selected-item:checked').each(function(){
                    value       = $(this).val();
                    if(value) values.push(value);
                });
                if(values.length==0) return false;

                if(selection == "delete"){
                    deleteMessage(values);
                }
            }
        }
    </script>

</head>
<body>

<div id="ConfirmModal" style="display: none;">
    <div class="padding20">
        <p id="confirmModal_text"></p>

        <div align="center">

            <div id="password_wrapper" style="display: none;">
                <label><?php echo ___("needs/permission-delete-item-password-desc"); ?><br><br><strong><?php echo ___("needs/permission-delete-item-password"); ?></strong> <br><input type="password" id="password1" value="" placeholder="********"></label>
                <div class="clear"></div>
                <br>
            </div>
        </div>
    </div>
    <div class="modal-foot-btn">
        <a id="delete_ok" href="javascript:void(0);" class="red lbtn"><?php echo ___("needs/yes"); ?></a>
    </div>
</div>

<div id="readMessage" style="display: none;" data-izimodal-title="<?php echo __("admin/manage-website/modal-read-message"); ?>">
    <div class="padding20">

        <form action="<?php echo $links["controller"]; ?>" method="post" id="replyMessage">
            <input type="hidden" name="operation" value="reply_message">
            <input type="hidden" name="id" value="0">

            <div class="formcon">
                <div class="yuzde30"><?php echo __("admin/manage-website/messages-name"); ?></div>
                <div class="yuzde70" id="message-name">
                </div>
            </div>

            <div class="formcon">
                <div class="yuzde30"><?php echo __("admin/manage-website/messages-message"); ?> (<span id="message-lang"></span>)</div>
                <div id="message-msg">
                </div>
            </div>

            <?php if($privOperation): ?>
                <div class="formcon" style="border:none">
                    <div class="yuzde30"><?php echo __("admin/manage-website/messages-reply-message"); ?></div>
                </div>

                <div class="formcon">
                    <textarea name="message" id="admin_message" rows="7"></textarea>
                    <span class="kinfo"><?php echo __("admin/manage-website/messages-reply-message-info"); ?></span>
                </div>

                <div class="clear"></div>
                <div style="float: right;" class="guncellebtn yuzde50">
                    <a id="replyMessage_submit" href="javascript:void(0);" class="gonderbtn yesilbtn"><?php echo __("admin/manage-website/button-reply-message"); ?></a>
                    <a id="replyMessage_disable" href="javascript:void(0);" style="display: none;" class="gonderbtn graybtn"><?php echo __("admin/manage-website/button-reply-message"); ?></a>
                </div>
            <?php endif; ?>

            <div class="clear"></div>

        </form>
        <script type="text/javascript">
            $(document).ready(function(){

                $("#replyMessage_submit").on("click",function(){
                    MioAjaxElement($(this),{
                        waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                        progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                        result:"replyMessage_handler",
                    });
                });

            });

            function replyMessage_handler(result){
                if(result != ''){
                    var solve = getJson(result);
                    if(solve !== false){
                        if(solve.status == "error"){
                            if(solve.for != undefined && solve.for != ''){
                                $("#replyMessage "+solve.for).focus();
                                $("#replyMessage "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                $("#replyMessage "+solve.for).change(function(){
                                    $(this).removeAttr("style");
                                });
                            }
                            if(solve.message != undefined && solve.message != '')
                                alert_error(solve.message,{timer:5000});
                        }else if(solve.status == "successful"){
                            alert_success(solve.message,{timer:2000});
                            table.ajax.reload();
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



    </div>
</div>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1>
                    <strong><?php echo __("admin/manage-website/page-messages-list");?></strong>
                </h1>

                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>


            <div class="clear"></div>

            <?php if($privDelete): ?>
                <select class="applyselect" id="selectApply" onchange="applySelection(this);">
                    <option value=""><?php echo __("admin/manage-website/apply-to-selected"); ?></option>
                    <?php if($privDelete): ?>
                        <option value="delete"><?php echo __("admin/manage-website/apply-to-selected-delete"); ?></option>
                    <?php endif; ?>
                </select>
                <div class="clear"></div>
            <?php endif; ?>

            <table width="100%" id="datatable" class="table table-striped table-borderedx table-condensed nowrap">
                <thead style="background:#ebebeb;">
                <tr>
                    <th align="left" data-orderable="false">#</th>
                    <?php
                        if($privDelete){
                            ?>
                            <th align="left" data-orderable="false">
                                <input type="checkbox" class="checkbox-custom" id="allSelect" onchange="$('.selected-item').prop('checked',$(this).prop('checked'));"><label for="allSelect" class="checkbox-custom-label"></label>
                            </th>
                            <?php
                        }
                    ?>
                    <th align="left" data-orderable="false"><?php echo __("admin/manage-website/messages-name"); ?></th>
                    <th align="center" data-orderable="false"><?php echo __("admin/manage-website/messages-email"); ?></th>
                    <th align="center" data-orderable="false"><?php echo __("admin/manage-website/messages-phone"); ?></th>
                    <th align="center" data-orderable="false"><?php echo __("admin/manage-website/messages-date"); ?></th>
                    <th align="center" data-orderable="false"><?php echo __("admin/manage-website/messages-ip"); ?></th>
                    <th align="center" data-orderable="false"></th>
                </tr>
                </thead>
                <tbody align="center" style="border-top:none;"></tbody>
            </table>

            <div class="clear"></div>

        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>