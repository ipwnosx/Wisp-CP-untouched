<!DOCTYPE html>
<html>
<head>
    <?php
        $privOperation  = Admin::isPrivilege("ORDERS_OPERATION");
        $privDelete     = Admin::isPrivilege("ORDERS_DELETE");
        $plugins        = ['dataTables'];
        include __DIR__.DS."inc".DS."head.php";
    ?>

    <style type="text/css">
        #datatable tbody tr td:nth-child(1),#datatable tbody tr td:nth-child(2),#datatable tbody tr td:nth-child(3) {
            text-align: left;
        }
    </style>
    <script>
        var table;
        $(document).ready(function() {

            $("#datatable").on("click",".status-msg",function(){
                var message = $(this).data("message");
                open_modal('statusMessage');
                $("#statusMessage .status-message-text").html(message);
            });

            $("#datatable").on("click",".reason-msg",function(){
                var message = $(this).data("message");
                message     = nl2br(message);
                open_modal('reasonMessage');
                $("#reasonMessage .reason-message-text").html(message);
            });

            table = $('#datatable').DataTable({
                "columnDefs": [
                    {
                        "targets": [0<?php echo !$privOperation ? ',1' : ''; ?>],
                        "visible":false,
                        "searchable": false
                    },
                ],
                "aaSorting" : [[0, 'asc']],
                "lengthMenu": [
                    [10, 25, 50, -1], [10, 25, 50, "<?php echo ___("needs/allOf"); ?>"]
                ],
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": "<?php echo $links["ajax-cancellation-requests"]; ?>",
                responsive: true,
                "oLanguage":<?php include __DIR__.DS."datatable-lang.php"; ?>
            });
        });

        function deleteRequest(id){

            if(typeof id == "object" && id.length>1){
                $("#password_wrapper").css("display","block");
            }else
                $("#password_wrapper").css("display","none");

            $("#password1").val('');
            var content1 = "<?php echo __("admin/orders/delete-are-youu-sure-cancellation-requests"); ?>";
            $("#deleteModal_text1").html(content1);

            open_modal("deleteModal",{
                title:"<?php echo __("admin/orders/delete-modal-title-cancellation"); ?>"
            });

            $("#delete_ok").click(function(){
                var password = $('#password1').val();
                var request = MioAjax({
                    button_element:this,
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    action: "<?php echo $links["controller"]; ?>",
                    method: "POST",
                    data: {operation:"apply_operation_cancellation",type:"delete",id:id,password:password}
                },true,true);

                request.done(function(result){
                    if(result){
                        if(result != ''){
                            var solve = getJson(result);
                            if(solve !== false){
                                if(solve.status == "error"){
                                    $("#password1").val('');
                                    if(solve.message != undefined && solve.message != '')
                                        alert_error(solve.message,{timer:5000});
                                }else if(solve.status == "successful"){
                                    $("#password1").val('');
                                    alert_success(solve.message,{timer:3000});
                                    close_modal("deleteModal");
                                    table.ajax.reload();
                                }
                            }else
                                console.log(result);
                        }
                    }else console.log(result);
                });

            });

            $("#delete_no").click(function(){
                close_modal("deleteModal");
                $("#password1").val('');
            });

        }

        function applyOperation(type,id){
            $("#RequestList").addClass("tab-blur-content");
            $("#operation-loading").fadeIn(500,function(){
            });

            var request = MioAjax({
                action: "<?php echo $links["controller"]; ?>",
                method: "POST",
                data: {operation:"apply_operation_cancellation",type:type,id:id}
            },true,true);

            request.done(function(result){

                $("#operation-loading").fadeOut(500,function(){
                    $("#RequestList").removeClass("tab-blur-content");
                });

                if(result){
                    if(result != ''){
                        var solve = getJson(result);
                        if(solve !== false){
                            if(solve.status == "error"){
                                if(solve.message != undefined && solve.message != '')
                                    alert_error(solve.message,{timer:5000});
                                table.ajax.reload();
                            }else if(solve.status == "successful"){

                                table.ajax.reload();

                                alert_success(solve.message,{timer:3000});
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
                    if(value){
                        values.push(value);
                    }
                });
                if(values.length==0) return false;

                if(selection == "approve")
                    applyOperation(selection,values);
                else if(selection == "delete"){
                    deleteOrder(values);
                }
            }
        }
    </script>

</head>
<body>

<div id="statusMessage" style="display: none;" data-izimodal-title="<?php echo __("admin/orders/modal-status-message"); ?>">
    <div class="padding20">
        <div class="status-message-text"></div>
    </div>
</div>

<div id="reasonMessage" style="display: none;" data-izimodal-title="<?php echo __("admin/orders/modal-reason-message"); ?>">
    <div class="padding20">
        <div class="reason-message-text"></div>
    </div>
</div>

<div id="deleteModal" style="display: none;">
    <div class="padding20">
        <div align="center">

            <p id="deleteModal_text1"></p>
            <p id="deleteModal_text2"></p>

            <div id="password_wrapper" style="display: none;">
                <label><?php echo ___("needs/permission-delete-item-password-desc"); ?><br><br><strong><?php echo ___("needs/permission-delete-item-password"); ?></strong> <br><input type="password" id="password1" value="" placeholder="********"></label>
                <div class="clear"></div>
                <br>
            </div>
        </div>

    </div>
    <div class="modal-foot-btn">
        <a href="javascript:void(0);" id="delete_ok" class="red lbtn"><?php echo __("admin/orders/delete-ok"); ?></a>
    </div>
</div>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1>
                    <strong><?php echo __("admin/orders/page-cancellation-requests"); ?></strong>
                </h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>


            <div id="operation-loading" class="blur-text" style="display: none">
                <i class="fa fa-cog loadingicon" aria-hidden="true"></i>
                <div class="clear"></div>
                <strong><?php echo __("admin/orders/list-row-operation-processing"); ?></strong>
            </div>

            <div id="RequestList">

                <?php if($privOperation): ?>
                    <select class="applyselect" id="selectApply" onchange="applySelection(this);">
                        <option value=""><?php echo __("admin/orders/list-apply-to-selected"); ?></option>
                        <option value="completed"><?php echo __("admin/orders/list-apply-to-selected-approve"); ?></option>
                        <?php if($privDelete): ?>
                            <option value="delete"><?php echo __("admin/orders/list-apply-to-selected-delete"); ?></option>
                        <?php endif; ?>
                    </select>
                <?php endif; ?>

                <div class="clear"></div>
                <br>

                <table width="100%" id="datatable" class="table table-striped table-borderedx table-condensed nowrap">
                    <thead style="background:#ebebeb;">
                    <tr>
                        <th align="left">#</th>
                        <th align="left">
                            <input type="checkbox" class="checkbox-custom" id="allSelect" onchange="$('.selected-item').prop('checked',$(this).prop('checked'));"><label for="allSelect" class="checkbox-custom-label"></label>
                        </th>
                        <th data-orderable="false" align="left"><?php echo __("admin/orders/list-customer-name"); ?></th>
                        <th data-orderable="false" align="left"><?php echo __("admin/orders/cancellation-order"); ?></th>
                        <th data-orderable="false" align="center"><?php echo __("admin/orders/cancellation-cdate"); ?></th>
                        <th data-orderable="false" align="center"><?php echo __("admin/orders/cancellation-urgency"); ?></th>
                        <th data-orderable="false" align="center"><?php echo __("admin/orders/cancellation-reason"); ?></th>
                        <th data-orderable="false" align="center"><?php echo __("admin/orders/cancellation-status"); ?></th>
                        <th data-orderable="false" align="center"></th>
                    </tr>
                    </thead>
                    <tbody align="center" style="border-top:none;"></tbody>
                </table>
            </div>
            <div class="clear"></div>

        </div>
    </div>

</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>