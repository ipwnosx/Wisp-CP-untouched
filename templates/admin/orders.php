<!DOCTYPE html>
<html>
<head>
    <?php
        $show_group     = '';

        if($group && isset($product_groups[$group]) && $product_groups[$group])
            $show_group = ' ('.$product_groups[$group].')';

        $privOperation  = Admin::isPrivilege("ORDERS_OPERATION");
        $privDelete     = Admin::isPrivilege("ORDERS_DELETE");
        $plugins        = ['dataTables'];
        include __DIR__.DS."inc".DS."head.php";
    ?>

    <style type="text/css">

        .datatable-item tbody .tr-have-event {
            background-color:#fc928738;
        }
        #tab-content .bubble-count {color:#9d0006; font-weight: bold};
    </style>
    <script>
        var table_all,table_notifications,automation_in_selected;
        $(document).ready(function() {

            var tab1 = _GET("content");
            if (tab1 != '' && tab1 != undefined) {
                $("#tab-content .tablinks[data-tab='" + tab1 + "']").click();
            } else {
                $("#tab-content .tablinks:eq(0)").addClass("active");
                $("#tab-content .tabcontent:eq(0)").css("display", "block");
            }
            

            $(".datatable-item").on("click",".status-msg",function(){
                var message = $(this).data("message");
                open_modal('statusMessage');
                $("#statusMessage .status-message-text").html(message);
            });

            table_all = $('#datatable-all').DataTable({
                'createdRow': function( row, data, dataIndex ) {

                    if($(".have-event",row).length>0)
                        $(row).addClass('tr-have-event');
                },
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
                "sAjaxSource": "<?php echo $links["ajax-list"]; ?>&l_type=all",
                responsive: true,
                "oLanguage":<?php include __DIR__.DS."datatable-lang.php"; ?>
            });
            table_notifications = $('#datatable-notifications').DataTable({
                'createdRow': function( row, data, dataIndex ) {

                    if($(".have-event",row).length>0)
                        $(row).addClass('tr-have-event');
                },
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
                "sAjaxSource": "<?php echo $links["ajax-list"]; ?>&l_type=notifications",
                responsive: true,
                "oLanguage":<?php include __DIR__.DS."datatable-lang.php"; ?>
            });

        });

        function deleteOrder(id){

            if(typeof id == "object" && id.length>1){
                $("#password_wrapper").css("display","block");
            }else
                $("#password_wrapper").css("display","none");

            if(typeof id != "object"){
                var automation = $("#delete-"+id).data("automation");
            }else{
                var automation = automation_in_selected;
            }

            $("#password1").val('');
            var content1 = "<?php echo __("admin/orders/delete-are-youu-sure-list"); ?>";
            $("#deleteModal_text1").html(content1);
            if(automation)
                $("#deleteModal_text2").css("display","inline-block");
            else
                $("#deleteModal_text2").css("display","none");

            open_modal("deleteModal",{
                title:"<?php echo __("admin/orders/delete-modal-title-list"); ?>"
            });

            $("#delete_ok").click(function(){
                var password = $('#password1').val();
                var request = MioAjax({
                    button_element:this,
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    action: "<?php echo $links["controller"]; ?>",
                    method: "POST",
                    data: {
                        operation:"apply_operation",
                        from:"list",
                        type:"delete",
                        id:id,
                        password:password,
                        apply_on_module: $("#delete-apply-on-module").prop('checked') ? 1 : 0,
                    }
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
                                    table_all.ajax.reload();
                                    table_notifications.ajax.reload();
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

        function applyOperation(type,id,aom){
            $("#OrdersList").addClass("tab-blur-content");
            $("#operation-loading").fadeIn(500,function(){
            });

            var request = MioAjax({
                action: "<?php echo $links["controller"]; ?>",
                method: "POST",
                data: {
                    operation:"apply_operation",
                    from:"list",
                    type:type,
                    id:id,
                    apply_on_module:aom
                }
            },true,true);

            request.done(function(result){

                $("#operation-loading").fadeOut(500,function(){
                    $("#OrdersList").removeClass("tab-blur-content");
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

                                table_all.ajax.reload();
                                table_notifications.ajax.reload();

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
            if(selection === '')
            {
            }
            else
            {
                var el_val  = $(element).val();
                var el_text = $("option[value="+el_val+"]",element).text();
                $(element).val('');

                automation_in_selected=false;
                var values = [],value,automation;
                $('.selected-item:checked').each(function(){
                    value       = $(this).val();
                    if(value){
                        automation = $("#delete-"+value).data("automation");
                        if(automation != undefined && automation) automation_in_selected = true;
                        values.push(value);
                    }
                });
                if(values.length === 0) return false;

                if(selection === "approve" || selection === "mark-read" || selection === "active" || selection === "cancelled" || selection === "suspended")
                {
                    open_modal("confirmModal",{title:el_text});

                    $("#confirm_ok").click(function(){
                        close_modal("confirmModal");
                        applyOperation(selection,values,$("#confirm-apply-on-module").prop('checked') ? 1 : 0);
                    });

                    $("#confirm_no").click(function(){
                        close_modal("confirmModal");
                    });
                }
                else if(selection === "delete"){
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

<div id="deleteModal" style="display: none;">
    <div class="padding20">
        <div align="center">

            <p id="deleteModal_text1"></p>
            <div style="width: 30%; display:inline-block; margin-bottom: 10px;" id="deleteModal_text2">
                <input checked type="checkbox" class="checkbox-custom" id="delete-apply-on-module" value="1">
                <label class="checkbox-custom-label" for="delete-apply-on-module"><span class="kinfo"><?php echo __("admin/orders/apply-on-module"); ?></span></label>
            </div>

            <div id="password_wrapper" style="display: none;">
                <label><?php echo ___("needs/permission-delete-item-password-desc"); ?><br><br><strong><?php echo ___("needs/permission-delete-item-password"); ?></strong> <br><input type="password" id="password1" value="" placeholder="********"></label>
                <div class="clear"></div>
                <br>
            </div>
            <div class="clear"></div>
        </div>

    </div>
    <div class="modal-foot-btn">
        <a href="javascript:void(0);" id="delete_ok" class="red lbtn"><?php echo __("admin/orders/delete-ok"); ?></a>
    </div>
</div>

<div id="confirmModal" style="display: none;">
    <div class="padding20">
        <div align="center">

            <p><?php echo ___("needs/apply-are-you-sure"); ?></p>
            <div class="clear"></div>

            <input checked type="checkbox" class="checkbox-custom" id="confirm-apply-on-module" value="1">
            <label class="checkbox-custom-label" for="confirm-apply-on-module"><span class="kinfo"><?php echo __("admin/orders/apply-on-module"); ?></span></label>
            <div class="clear"></div>
            <br>


            <div class="yuzde50">
                <a href="javascript:void(0);" id="confirm_ok" class="gonderbtn yesilbtn"><i class="fa fa-check"></i> <?php echo ___("needs/yes"); ?></a>
            </div>
            <div class="yuzde50">
                <a href="javascript:void(0);" id="confirm_no" class="gonderbtn redbtn"><i class="fa fa-ban"></i> <?php echo ___("needs/no"); ?></a>
            </div>
        </div>

    </div>
</div>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1>
                    <strong><?php echo $status ? __("admin/orders/page-list-".$status) : __("admin/orders/page-list"); echo $show_group;  ?></strong>
                </h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>


            <?php
                if(isset($sql_mode) && $sql_mode)
                {
                    ?>
                    <div class="red-info">
                        <div class="padding20">
                            <i class="fa fa-exclamation-circle"></i>
                            <p><?php echo ___("errors/admin-sql-mode"); ?></p>
                        </div>
                    </div>
                    <?php
                }
            ?>

            <div id="operation-loading" class="blur-text" style="display: none">
                <i class="fa fa-cog loadingicon" aria-hidden="true"></i>
                <div class="clear"></div>
                <strong><?php echo __("admin/orders/list-row-operation-processing"); ?></strong>
            </div>

            <div id="OrdersList">

                <?php if($privOperation): ?>
                    <select class="applyselect" id="selectApply" onchange="applySelection(this);">
                        <option value=""><?php echo __("admin/orders/list-apply-to-selected"); ?></option>
                        <option value="approve"><?php echo __("admin/orders/list-apply-to-selected-approve"); ?></option>
                        <option value="active"><?php echo __("admin/orders/list-apply-to-selected-active"); ?></option>
                        <option value="mark-read"><?php echo __("admin/orders/list-apply-to-selected-mark-read"); ?></option>
                        <option value="cancelled"><?php echo __("admin/orders/list-apply-to-selected-cancelled"); ?></option>
                        <option value="suspended"><?php echo __("admin/orders/list-apply-to-selected-suspended"); ?></option>
                        <?php if($privDelete): ?>
                            <option value="delete"><?php echo __("admin/orders/list-apply-to-selected-delete"); ?></option>
                        <?php endif; ?>
                    </select>
                <?php endif; ?>

                <div class="orderheadbts">
                    <?php if($privOperation): ?>
                        <a href="<?php echo $links["create-new-order"]; ?>" id="neworderbtn"><i class="fa fa-plus"></i> <?php echo __("admin/orders/create-new-order-button"); ?></a>
                    <?php endif; ?>

                    <select class="applyselect" onchange="location = this.options[this.selectedIndex].value;">
                        <option value="<?php echo $links["controller"]; ?>"><?php echo ___("needs/allOf"); ?></option>
                        <?php
                            foreach($product_groups AS $k => $g)
                            {
                                ?>
                                <option<?php echo $group == $k ? ' selected' : '' ; ?> value="<?php echo $links["controller"]; ?>?group=<?php echo $k; ?>"><?php echo $g; ?></option>
                                <?php
                            }
                        ?>
                    </select>

                    <select class="applyselect" onchange="location = this.options[this.selectedIndex].value;">
                        <option value="<?php echo $links["all"]; ?>"><?php echo ___("needs/allOf"); ?></option>
                        <?php
                            foreach(['active','inprocess','suspended','cancelled','overdue'] AS $k)
                            {
                                ?>
                                <option<?php echo $status == $k ? ' selected' : ''; ?> value="<?php echo $links[$k].($group ? '?group='.$group : ''); ?>"><?php echo __("admin/orders/page-list-".$k); ?></option>
                                <?php
                            }
                        ?>
                    </select>

                </div>



                <div class="clear"></div>
                <br>

                <div id="tab-content">
                    <ul class="tab">
                        <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'all','content')" data-tab="all"><?php echo ___("needs/allOf"); ?></a></li>
                        <li>
                            <a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'notifications','content')" data-tab="notifications">
                                <?php
                                    echo __("admin/index/critical-transaction-notifications");
                                    if(isset($bubble_count) && $bubble_count>0)
                                        echo ' <span class="bubble-count">('.$bubble_count.')</span>';
                                ?>
                            </a>
                        </li>
                    </ul>

                    <div id="content-all" class="tabcontent">
                        <table width="100%" id="datatable-all" class="datatable-item table table-striped table-borderedx table-condensed nowrap">
                            <thead style="background:#ebebeb;">
                            <tr>
                                <th align="left">#</th>
                                <th align="left" data-orderable="false">
                                    <input type="checkbox" class="checkbox-custom" id="allSelect" onchange="$('.selected-item').prop('checked',$(this).prop('checked'));"><label for="allSelect" class="checkbox-custom-label"></label>
                                </th>
                                <th align="left" data-orderable="false"><?php echo __("admin/orders/list-customer-name"); ?></th>
                                <th align="left" data-orderable="false"><?php echo __("admin/orders/list-product-name"); ?></th>
                                <th align="left" data-orderable="false"><?php echo __("admin/orders/list-product-group"); ?></th>
                                <th align="center"><?php echo __("admin/orders/list-create-date"); ?></th>
                                <th align="center" data-orderable="false"><?php echo __("admin/orders/list-amount-period"); ?></th>
                                <th align="center" data-orderable="false"><?php echo __("admin/orders/list-status"); ?></th>
                                <th align="center" data-orderable="false"></th>
                            </tr>
                            </thead>
                            <tbody align="center" style="border-top:none;"></tbody>
                        </table>
                    </div>

                    <div id="content-notifications" class="tabcontent">
                        <table width="100%" id="datatable-notifications" class="datatable-item table table-striped table-borderedx table-condensed nowrap">
                            <thead style="background:#ebebeb;">
                            <tr>
                                <th align="left">#</th>
                                <th align="left" data-orderable="false">
                                    <input type="checkbox" class="checkbox-custom" id="allSelect" onchange="$('.selected-item').prop('checked',$(this).prop('checked'));"><label for="allSelect" class="checkbox-custom-label"></label>
                                </th>
                                <th align="left" data-orderable="false"><?php echo __("admin/orders/list-customer-name"); ?></th>
                                <th align="left" data-orderable="false"><?php echo __("admin/orders/list-product-name"); ?></th>
                                <th align="left" data-orderable="false"><?php echo __("admin/orders/list-product-group"); ?></th>
                                <th align="center"><?php echo __("admin/orders/list-create-date"); ?></th>
                                <th align="center" data-orderable="false"><?php echo __("admin/orders/list-amount-period"); ?></th>
                                <th align="center" data-orderable="false"><?php echo __("admin/orders/list-status"); ?></th>
                                <th align="center" data-orderable="false"></th>
                            </tr>
                            </thead>
                            <tbody align="center" style="border-top:none;"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="clear"></div>

        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>