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
        .datatable-item tbody tr td:nth-child(1),.datatable-item tbody tr td:nth-child(2),.datatable-item tbody tr td:nth-child(3),.datatable-item tbody tr td:nth-child(4) {
            text-align: left;
        }

        .datatable-item tbody .tr-have-event {
            background-color:#fc928738;
        }
        #tab-content .bubble-count {color:#9d0006; font-weight: bold};
    </style>
    <script>
        var table_all,table_notifications;
        $(document).ready(function() {

            var tab1 = _GET("content");
            if (tab1 != '' && tab1 != undefined) {
                $("#tab-content .tablinks[data-tab='" + tab1 + "']").click();
            } else {
                $("#tab-content .tablinks:eq(0)").addClass("active");
                $("#tab-content .tabcontent:eq(0)").css("display", "block");
            }

            $(".datatable-item").on("click",".status-msg",function(){
                var message = $('.status-msg-content',$(this).parent()).html();
                open_modal('statusMessage');
                $("#statusMessage .status-message-text").html(message);
            });

            $(".datatable-item").on("click",".open-event",function(){
                var id = $(this).data("id");;
                open_modal('EventModal');
                var content = $("#addon-"+id+" .event-data").html();
                $("#EventModal_content").html(content);
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
                    {
                        "targets": [1,2,3,4,5,6,7,8],
                        "orderable": false
                    }
                ],
                "aaSorting" : [[0, 'asc']],
                "lengthMenu": [
                    [10, 25, 50, -1], [10, 25, 50, "<?php echo ___("needs/allOf"); ?>"]
                ],
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": "<?php echo $links["ajax-addons"]; ?>&l_type=all",
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
                    {
                        "targets": [1,2,3,4,5,6,7,8],
                        "orderable": false
                    }
                ],
                "aaSorting" : [[0, 'asc']],
                "lengthMenu": [
                    [10, 25, 50, -1], [10, 25, 50, "<?php echo ___("needs/allOf"); ?>"]
                ],
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": "<?php echo $links["ajax-addons"]; ?>&l_type=notifications",
                responsive: true,
                "oLanguage":<?php include __DIR__.DS."datatable-lang.php"; ?>
            });
        });

        function deleteAddon(id){

            if(typeof id == "object" && id.length>1){
                $("#password_wrapper").css("display","block");
            }else
                $("#password_wrapper").css("display","none");

            $("#password1").val('');
            var content1 = "<?php echo __("admin/orders/delete-are-youu-sure-addons"); ?>";
            $("#deleteModal_text1").html(content1);

            open_modal("deleteModal",{
                title:"<?php echo __("admin/orders/delete-modal-title-addons"); ?>"
            });

            $("#delete_ok").click(function(){
                var password = $('#password1').val();
                var request = MioAjax({
                    button_element:this,
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    action: "<?php echo $links["controller"]; ?>",
                    method: "POST",
                    data: {operation:"apply_operation_addons",type:"delete",id:id,password:password}
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

        function applyAddonOperation(type,id){
            $("#OrdersList").addClass("tab-blur-content");
            $("#operation-loading").fadeIn(500,function(){
            });

            var request = MioAjax({
                action: "<?php echo $links["controller"]; ?>",
                method: "POST",
                data: {operation:"apply_operation_addons",type:type,id:id}
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
                                table_all.ajax.reload();
                                table_notifications.ajax.reload();
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

                if(selection == "active")
                    applyAddonOperation(selection,values);
                else if(selection == "delete"){
                    deleteAddon(values);
                }
                $('#allSelect').prop("checked",false);
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

<div id="EventModal" style="display: none;" data-izimodal-title="<?php echo __("admin/orders/modal-events"); ?>">
    <script type="text/javascript">
        function AddonEventOK(id){
            var button = $("#event_"+id+" .event-ok-button");
            var request = MioAjax({
                waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                button_element:button,
                action:"<?php echo $links["controller"]; ?>",
                method:"POST",
                data:{operation:"event_ok",id:id}
            },true,true);
            request.done(function(result){
                if(result != ''){
                    var solve = getJson(result);
                    if(solve !== false){
                        if(solve.status == "error"){
                            if(solve.message != undefined && solve.message != '')
                                alert_error(solve.message,{timer:5000});
                        }else if(solve.status == "successful"){
                            $("#event_"+id).remove();

                            if($("#EventModal_content .order-event-item").length==0){
                                close_modal("EventModal");
                                table_all.ajax.reload();
                                table_notifications.ajax.reload();
                            }
                        }
                    }else
                        console.log(result);
                }
            });
        }
    </script>
    <div class="padding20">

        <div id="EventModal_content"></div>

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

<div id="editMyAddon" style="display: none;">
    <div class="padding20">

        <script type="text/javascript">
            function editMyAddon(id){
                var addon_name  = $("#addon-"+id+" input[name=addon_name]").val();
                var modal_title = "<?php echo __("admin/orders/my-addons-edit")?>";
                modal_title = modal_title.replace("{name}",addon_name);

                $("#editMyAddon").attr("data-iziModal-title",modal_title);
                open_modal('editMyAddon');

                var option_name  = $("#addon-"+id+" input[name=option_name]").val();
                var option_q    = $("#addon-"+id+" input[name=option_quantity]").val();
                var amount       = $("#addon-"+id+" input[name=amount]").val();
                var cid          = $("#addon-"+id+" input[name=cid]").val();
                var period       = $("#addon-"+id+" input[name=period]").val();
                var period_time  = $("#addon-"+id+" input[name=period_time]").val();
                var status       = $("#addon-"+id+" input[name=status]").val();
                var cdate        = $("#addon-"+id+" input[name=cdate]").val();
                var ctime        = $("#addon-"+id+" input[name=ctime]").val();
                var renewaldate  = $("#addon-"+id+" input[name=renewaldate]").val();
                var renewaltime  = $("#addon-"+id+" input[name=renewaltime]").val();
                var duedate      = $("#addon-"+id+" input[name=duedate]").val();
                var duetime      = $("#addon-"+id+" input[name=duetime]").val();
                var pmethod      = $("#addon-"+id+" input[name=pmethod]").val();
                var subscription = $("#addon-"+id+" .subscription-data").html();

                $("#editMyAddon input[name=addon_name]").val(addon_name);
                $("#editMyAddon input[name=option_name]").val(option_name);
                $("#editMyAddon input[name=option_quantity]").val(option_q);
                $("#editMyAddon input[name=amount]").val(amount);
                $("#editMyAddon select[name=pmethod]").removeAttr("selected");
                $("#editMyAddon select[name=cid]").removeAttr("selected");
                $("#editMyAddon select[name=pmethod] option[value='"+pmethod+"']").attr("selected",true);
                $("#editMyAddon select[name=cid] option[value='"+cid+"']").attr("selected",true);
                $("#editMyAddon select[name=period]").removeAttr("selected");
                $("#editMyAddon select[name=period] option[value='"+period+"']").attr("selected",true);
                $("#editMyAddon input[name=period_time]").val(period_time);
                $("#editMyAddon select[name=status]").removeAttr("selected");
                $("#editMyAddon select[name=status] option[value='"+status+"']").attr("selected",true);
                $("#editMyAddon input[name=cdate]").val(cdate);
                $("#editMyAddon input[name=ctime]").val(ctime);
                $("#editMyAddon input[name=renewaldate]").val(renewaldate);
                $("#editMyAddon input[name=renewaltime]").val(renewaltime);
                $("#editMyAddon input[name=duedate]").val(duedate);
                $("#editMyAddon input[name=duetime]").val(duetime);
                $("#editMyAddon input[name=addon_id]").val(id);
                $("#editMyAddon #subscription_wrap").html(subscription);

                if($("#editMyAddon #subscription_wrap .subscription-content").length > 0)
                {
                    $.get("<?php echo $links["controller"]; ?>?operation=addon_subscription_detail&addon_id="+id,function(data){
                        $("#editMyAddon #subscription_wrap .subscription-content").html(data);
                    });
                }

            }
            function deleteMyAddon(id){
                swal({
                    title: '<?php echo __("admin/orders/my-addons-delete-alert-title"); ?>',
                    text: '<?php echo __("admin/orders/my-addons-delete-alert-body"); ?>',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '<?php echo __("admin/orders/delete-ok"); ?>',
                    cancelButtonText: '<?php echo __("admin/orders/delete-no"); ?>',
                }).then(function(){
                    var request = MioAjax({
                        action:"<?php echo $links["controller"]; ?>",
                        method:"POST",
                        data:{operation:"delete_addon",id:id}
                    },true,true);

                    request.done(function(res){
                        if(res != ''){
                            var solve = getJson(res);
                            if(solve && typeof solve == "object"){
                                if(solve.status == "error"){
                                    swal({
                                        title: 'Hata!',
                                        text: solve.message,
                                        type: 'error',
                                        showConfirmButton: false,
                                        timer: 3000,
                                    });
                                }else if(solve.status == "successful"){
                                    var timer = 1500;
                                    setTimeout(function(){
                                        window.location.href = window.location.href;
                                    },timer);
                                    swal({
                                        title: '<?php echo __("admin/orders/my-addons-delete-alert-success-title"); ?>',
                                        text: '<?php echo __("admin/orders/my-addons-delete-alert-success-body"); ?>',
                                        type: 'success',
                                        showConfirmButton: false,
                                        timer: timer,
                                    });
                                }
                            }else
                                console.log(res);
                        }
                    });
                });
            }
        </script>
        <form id="editMyAddonForm" action="<?php echo $links["controller"]; ?>" method="post">
            <input type="hidden" name="operation" value="edit_addon">
            <input type="hidden" name="addon_id" value="0">

            <div class="formcon">
                <div class="yuzde30"><?php echo __("admin/orders/my-addons-addon-name"); ?></div>
                <div class="yuzde70">
                    <input type="text" name="addon_name" value="">
                </div>
            </div>

            <div class="formcon">
                <div class="yuzde30"><?php echo __("admin/orders/my-addons-option-name"); ?></div>
                <div class="yuzde70">
                    <input name="option_quantity" type="number" class="yuzde20" placeholder="<?php echo __("admin/products/add-addon-type-quantity"); ?>" value="1" min="1">
                    <span class="yuzde5" style="font-weight: 600; text-align: center; margin-top:13px;">x</span>
                    <input class="yuzde75" type="text" name="option_name" value="">
                </div>
            </div>

            <div class="formcon">
                <div class="yuzde30"><?php echo __("admin/orders/my-addons-cdate"); ?></div>
                <div class="yuzde70">
                    <input style="width: 150px;" name="cdate" type="date" value="<?php echo DateManager::Now("Y-m-d"); ?>" placeholder="00/00/0000">
                    <input style="width:100px;" onkeypress='return event.charCode==58 || event.charCode>= 48 &&event.charCode<= 57' maxlength="5" type="time" name="ctime" value="">
                </div>
            </div>

            <div class="formcon">
                <div class="yuzde30"><?php echo __("admin/orders/my-addons-renewaldate"); ?></div>
                <div class="yuzde70">
                    <input style="width: 150px;" name="renewaldate" type="date" value="<?php echo DateManager::Now("Y-m-d"); ?>" placeholder="00/00/0000">
                    <input style="width:100px;" onkeypress='return event.charCode==58 || event.charCode>= 48 &&event.charCode<= 57' maxlength="5" type="time" name="renewaltime" value="">
                </div>
            </div>

            <div class="formcon">
                <div class="yuzde30"><?php echo __("admin/orders/my-addons-duedate"); ?></div>
                <div class="yuzde70">
                    <input style="width: 150px;" name="duedate" type="date" value="" placeholder="00/00/0000">
                    <input style="width:100px;" onkeypress='return event.charCode==58 || event.charCode>= 48 &&event.charCode<= 57' maxlength="5" type="time" name="duetime" value="">
                </div>
            </div>

            <div class="formcon">
                <div class="yuzde30"><?php echo __("admin/orders/my-addons-status"); ?></div>
                <div class="yuzde70">
                    <select name="status">
                        <?php
                            foreach($situations AS $k=>$v){
                                $v = Filter::html_clear($v);
                                ?>
                                <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                <?php
                            }
                        ?>
                    </select>
                </div>
            </div>

            <div class="formcon">
                <div class="yuzde30"><?php echo __("admin/orders/detail-pmethod"); ?></div>
                <div class="yuzde70">
                    <select name="pmethod">
                        <option value="none"><?php echo ___("needs/none"); ?></option>
                        <?php
                            if($pmethods){
                                foreach($pmethods AS $k=>$v){
                                    ?><option value="<?php echo $k; ?>"><?php echo $v; ?></option><?php
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>

            <div id="subscription_wrap"></div>


            <div class="formcon">
                <div class="yuzde30"><?php echo __("admin/orders/detail-pricing"); ?></div>
                <div class="yuzde70">

                    <input style="width:80px;" name="period_time" type="text" placeholder="<?php echo __("admin/orders/detail-pricing-period"); ?>" value=""> -
                    <select style="width:130px;" name="period">
                        <?php
                            foreach(___("date/periods") AS $k=>$v){
                                ?>
                                <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                <?php
                            }
                        ?>
                    </select><div class="clear"></div>
                    <input style="width:80px;" name="amount" type="text" placeholder="<?php echo __("admin/orders/detail-pricing-amount"); ?>" value=""> -
                    <select style="width:130px;" name="cid">
                        <?php
                            foreach(Money::getCurrencies() AS $curr){
                                ?>
                                <option value="<?php echo $curr["id"]; ?>"><?php echo $curr["name"]." (".$curr["code"].")"; ?></option>
                                <?php
                            }
                        ?>
                    </select>
                    <div class="clear"></div>
                </div>
            </div>

            <div class="formcon" id="addon-edit-notification_wrap">
                <div class="yuzde30"><?php echo __("admin/orders/create-notification"); ?></div>
                <div class="yuzde70">
                    <input type="checkbox" name="notification" value="1" class="checkbox-custom" id="addon-edit--notification">
                    <label for="addon-edit--notification" class="checkbox-custom-label"></label>
                </div>

            </div>


            <?php if($privOperation): ?>
                <div style="float:right;margin-bottom:20px;" class="guncellebtn yuzde30">
                    <a id="editMyAddonForm_submit" class="yesilbtn gonderbtn" href="javascript:void(0);"><?php echo __("admin/orders/save-button"); ?></a>
                </div>
            <?php endif; ?>

        </form>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#editMyAddonForm_submit").on("click",function(){
                    MioAjaxElement($(this),{
                        waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                        progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                        result:"editMyAddonForm_handler",
                    });
                });
            });

            function editMyAddonForm_handler(result){
                if(result != ''){
                    var solve = getJson(result);
                    if(solve !== false){
                        if(solve.status == "error"){
                            if(solve.for != undefined && solve.for != ''){
                                $("#editMyAddonForm "+solve.for).focus();
                                $("#editMyAddonForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                $("#editMyAddonForm "+solve.for).change(function(){
                                    $(this).removeAttr("style");
                                });
                            }
                            if(solve.message != undefined && solve.message != '')
                                alert_error(solve.message,{timer:5000});
                        }else if(solve.status == "successful"){
                            alert_success(solve.message,{timer:2000});
                            table_all.ajax.reload();
                            table_notifications.ajax.reload();
                        }
                    }else
                        console.log(result);
                }
            }

            function cancel_subscription_addon(el,sub_id,ad_id)
            {
                if(!confirm("<?php echo ___("needs/apply-are-you-sure"); ?>")) return false;
                var request = MioAjax({
                    button_element:el,
                    waiting_text: "<?php echo __("website/others/button1-pending"); ?>",
                    action: "<?php echo $links["controller"]; ?>",
                    method: "POST",
                    data:{
                        operation: "cancel_subscription",
                        id: sub_id,
                        addon_id: ad_id
                    }
                },true,true);
                request.done(function(result){
                    var solve = getJson(result);
                    if(solve !== undefined && solve !== false)
                    {
                        if(solve.status === "error")
                            alert_error(solve.message,{timer:4000});
                        else if(solve.status === "successful")
                        {
                            close_modal("editMyAddon");
                            window.location.href = location.href;
                        }
                    }
                });
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
                    <strong><?php echo __("admin/orders/page-addons"); ?></strong>
                </h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>




            <div id="operation-loading" class="blur-text" style="display: none">
                <i class="fa fa-cog loadingicon" aria-hidden="true"></i>
                <div class="clear"></div>
                <strong><?php echo __("admin/orders/list-row-operation-processing"); ?></strong>
            </div>

            <div id="OrdersList">

                <?php if($privOperation): ?>
                    <select class="applyselect" id="selectApply" onchange="applySelection(this);">
                        <option value=""><?php echo __("admin/orders/list-apply-to-selected"); ?></option>
                        <option value="active"><?php echo __("admin/orders/list-apply-to-selected-active"); ?></option>
                        <?php if($privDelete): ?>
                            <option value="delete"><?php echo __("admin/orders/list-apply-to-selected-delete"); ?></option>
                        <?php endif; ?>
                    </select>
                <?php endif; ?>

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
                                <th align="left">
                                    <input type="checkbox" class="checkbox-custom" id="allSelect" onchange="$('.selected-item').prop('checked',$(this).prop('checked'));"><label for="allSelect" class="checkbox-custom-label"></label>
                                </th>
                                <th align="left"><?php echo __("admin/orders/list-customer-name"); ?></th>
                                <th align="left"><?php echo __("admin/orders/my-addons-order"); ?></th>
                                <th align="left"><?php echo __("admin/orders/my-addons-addon-info"); ?></th>
                                <th align="center"><?php echo __("admin/orders/my-addons-cdate"); ?> / <?php echo __("admin/orders/my-addons-duedate"); ?></th>
                                <th align="center"><?php echo __("admin/orders/my-addons-amount"); ?></th>
                                <th align="center"><?php echo __("admin/orders/my-addons-status"); ?></th>
                                <th align="center"></th>
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
                                <th align="left">
                                    <input type="checkbox" class="checkbox-custom" id="allSelect" onchange="$('.selected-item').prop('checked',$(this).prop('checked'));"><label for="allSelect" class="checkbox-custom-label"></label>
                                </th>
                                <th align="left"><?php echo __("admin/orders/list-customer-name"); ?></th>
                                <th align="left"><?php echo __("admin/orders/my-addons-order"); ?></th>
                                <th align="left"><?php echo __("admin/orders/my-addons-addon-info"); ?></th>
                                <th align="center"><?php echo __("admin/orders/my-addons-cdate"); ?> / <?php echo __("admin/orders/my-addons-duedate"); ?></th>
                                <th align="center"><?php echo __("admin/orders/my-addons-amount"); ?></th>
                                <th align="center"><?php echo __("admin/orders/my-addons-status"); ?></th>
                                <th align="center"></th>
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