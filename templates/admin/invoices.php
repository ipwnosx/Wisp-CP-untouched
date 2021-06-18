<!DOCTYPE html>
<html>
<head>
    <?php

        $invoice_modules_logos = Hook::run("InvoiceModulesLogos");
        $search_query   = [];
        if(isset($search) && $search){
            $search_query["search"] = "true";
            if(isset($user_id) && $user_id) $search_query["user_id"] = $user_id;
            if(isset($word) && $word) $search_query["word"] = $word;
            if(isset($start) && $start) $search_query["start"] = $start;
            if(isset($end) && $end) $search_query["end"] = $end;
            if(isset($taxed) && $taxed) $search_query["taxed"] = $taxed;
        }
        $search_query = http_build_query($search_query);
        $privOperation  = Admin::isPrivilege("INVOICES_OPERATION");
        $privDelete     = Admin::isPrivilege("INVOICES_DELETE");
        $plugins        = ['dataTables','select2','mio-icons'];
        include __DIR__.DS."inc".DS."head.php";
    ?>


    <script>
        var table,select_user;
        $(document).ready(function() {
            select_user = $("#select-user");
            select_user.select2({
                placeholder: "<?php echo __("admin/invoices/create-select-user"); ?>",
                ajax: {
                    url: '<?php echo $links["select-users.json"]; ?>',
                    dataType: 'json',
                    data: function (params) {
                        var query = {
                            search: params.term,
                            type: 'public',
                            none:true,
                        };
                        return query;
                    }
                }
            });

            table = $('#datatable').DataTable({
                "columnDefs": [
                    {
                        "targets": [0<?php echo !$privOperation ? ',1' : ''; ?>],
                        "visible":false,
                    },
                ],
                "pageLength": 30,
                "bLengthChange" : false,
                "bInfo":false,
                "searching": false,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": "<?php echo $links["ajax"]; echo $search_query ?  "&".$search_query : ''; ?>",
                responsive: true,
                "oLanguage":<?php include __DIR__.DS."datatable-lang.php"; ?>
            });
        });

        function deleteInvoice(id){

            if(typeof id == "object" && id.length>1){
                $("#password_wrapper").css("display","block");
            }else
                $("#password_wrapper").css("display","none");

            $("#password1").val('');

            open_modal("deleteModal",{
                title:"<?php echo __("admin/invoices/delete-modal-title-bills"); ?>"
            });

            $("#delete_ok").click(function(){
                var password = $('#password1').val();
                var request = MioAjax({
                    button_element:this,
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    action: "<?php echo $links["controller"]; ?>",
                    method: "POST",
                    data: {operation:"apply_operation",from:"list",type:"delete",id:id,password:password}
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
            $("#Bills").addClass("tab-blur-content");
            $("#operation-loading").fadeIn(500,function(){
            });

            var request = MioAjax({
                action: "<?php echo $links["controller"]; ?>",
                method: "POST",
                data: {operation:"apply_operation",from:"list",type:type,id:id}
            },true,true);

            request.done(function(result){

                $("#operation-loading").fadeOut(500,function(){
                    $("#Bills").removeClass("tab-blur-content");
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
                    if(value) values.push(value);
                });
                if(values.length==0) return false;

                if(selection === "delete")
                    deleteInvoice(values);
                else
                    applyOperation(selection,values);
            }
        }
    </script>

</head>
<body>

<div id="deleteModal" style="display: none;">
    <div class="padding20">
        <div align="center">

            <p><?php echo __("admin/invoices/delete-are-youu-sure-bills"); ?></p>

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

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1>
                    <strong><?php echo $status ? __("admin/invoices/page-bills-".$status) : __("admin/invoices/page-bills"); ?></strong>
                    <?php
                        if($invoice_modules_logos){
                            foreach($invoice_modules_logos AS $logo){
                                if($logo){
                                    ?>
                                    <img style="width: 110px;height:auto;margin-left: 15px;display: inline-block;margin-bottom: -3px;" src="<?php echo $logo; ?>">
                                    <?php
                                }
                            }
                        }
                    ?>
                </h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>


            <div id="operation-loading" class="blur-text" style="display: none">
                <i class="fa fa-cog loadingicon" aria-hidden="true"></i>
                <div class="clear"></div>
                <strong><?php echo __("admin/invoices/bills-row-operation-processing"); ?></strong>
            </div>


            <div id="Bills">

                <div class="faturalinks">

                    <?php if($privOperation): ?>
                        <select class="applyselect" id="selectApply" onchange="applySelection(this);">
                            <option value=""><?php echo __("admin/invoices/bills-apply-to-selected"); ?></option>
                            <option value="paid"><?php echo __("admin/invoices/bills-apply-to-selected-paid"); ?></option>
                            <option value="unpaid"><?php echo __("admin/invoices/bills-apply-to-selected-unpaid"); ?></option>
                            <option value="remind"><?php echo __("admin/invoices/bills-apply-to-selected-remind"); ?></option>
                            <?php if($privDelete): ?>
                                <option value="delete"><?php echo __("admin/invoices/bills-apply-to-selected-delete"); ?></option>
                            <?php endif; ?>
                            <?php if($privOperation): ?>
                                <option value="cancelled"><?php echo __("admin/invoices/bills-apply-to-selected-cancelled"); ?></option>
                            <?php endif; ?>
                        </select>

                        <a href="<?php echo $links["create"]; ?>" class="green lbtn">+ <?php echo __("admin/invoices/create-new-bill-button"); ?></a>

                    <?php endif; ?>

                    <a href="javascript:$('#advanced-search').slideToggle();void 0;" id="gelarama" class="lbtn"><i class="fa fa-search" aria-hidden="true"></i> <?php echo __("admin/invoices/advanced-search-button"); ?></a>

                    <select class="applyselect" style="float: right;" onchange="location = this.options[this.selectedIndex].value;">
                        <option value="<?php echo $links["all"]; ?>"><?php echo ___("needs/allOf"); ?></option>
                        <?php
                            foreach(['paid','unpaid','cancelled-refund','taxed','untaxed','overdue','upcoming'] AS $k)
                            {
                                ?>
                                <option<?php echo $k == $status ? ' selected' : ''; ?> value="<?php echo $links[$k]; ?>"><?php echo __("admin/invoices/page-bills-".$k); ?></option>
                                <?php
                            }
                        ?>
                    </select>
                </div>

                <div class="clear"></div>

                <div id="advanced-search" style="<?php echo $search ? '' : 'display:none;'; ?>float:left;width:100%;padding:5px 0px;    margin-top: 10px;border-top:1px solid #eee; transition-property: all; transition-duration: 0s; transition-timing-function: ease; opacity: 1;">
                    <form action="<?php echo $links["controller"]; ?>" method="get" id="searchForm">
                        <input type="hidden" name="search" value="true">
                        <select class="width200" name="user_id" id="select-user">
                            <?php echo isset($user_id) ? '<option selected value="'.$user_id.'">'.$user_name.'</option>' : ''; ?>
                        </select>
                        <input class="width200" name="word" type="search" placeholder="<?php echo __("admin/invoices/bills-search-word"); ?>" value="<?php echo isset($word) ? htmlentities($word,ENT_QUOTES) : ''; ?>">

                        <?php if(!$status || ($status != "unpaid" && $status != "recurring")): ?>
                            <?php echo __("admin/invoices/bills-search-start-date"); ?>
                            <input class="width200" name="start" type="date" value="<?php echo isset($start) ? $start : ''; ?>">
                            <?php echo __("admin/invoices/bills-search-end-date"); ?>
                            <input class="width200" name="end" type="date" value="<?php echo isset($end) ? $end : ''; ?>">

                            <?php if($status != "taxed" && $status != "untaxed"): ?>
                                <?php echo __("admin/invoices/bills-search-taxed"); ?>
                                <input<?php echo isset($taxed) && $taxed ? ' checked'  : ''; ?> type="checkbox" class="checkbox-custom" name="taxed" value="1" id="taxed">
                                <label for="taxed" class="checkbox-custom-label"></label>
                            <?php endif; ?>

                        <?php endif; ?>

                        <a href="javascript:$('#searchForm').submit();void 0;" title="<?php echo __("admin/invoices/bills-search-find"); ?>" class="sbtn"><i class="fa fa-search" aria-hidden="true"></i></a>
                    </form>
                </div>

                <?php
                    if((!$status || $status == 'paid' || $status == 'unpaid' || $status == 'taxed' || $status == 'untaxed') && Config::get("options/taxation") && !$search){
                        ?>
                        <div class="kdvinfo">
                            <?php if(isset($total_paid_taxes_amount) && isset($total_paid_taxes_count)): ?>
                                <h5><?php echo __("admin/invoices/bills-total-paid-taxes"); ?>: <strong><?php echo isset($total_paid_taxes_amount) ? $total_paid_taxes_amount : 0; ?></strong> (<?php echo isset($total_paid_taxes_count) ? $total_paid_taxes_count : 0; ?>)</h5>
                            <?php elseif(isset($search) && $search): ?>

                            <?php else: ?>
                                <h5><?php echo __("admin/invoices/bills-last-month-taxes",['{month}' => '<strong>'.$last_month_name.'</strong>']); ?>: <strong><?php echo isset($last_month_taxes_amount) ? $last_month_taxes_amount : 0; ?></strong> (<?php echo isset($last_month_taxes_count) ? $last_month_taxes_count : 0; ?>)</h5>
                                <h5><?php echo __("admin/invoices/bills-now-month-taxes",['{month}' => '<strong>'.$now_month_name.'</strong>']); ?>: <strong><?php echo isset($now_month_taxes_amount) ? $now_month_taxes_amount : 0; ?></strong> (<?php echo isset($now_month_taxes_count) ? $now_month_taxes_count : 0; ?>)</h5>
                            <?php endif; ?>

                            <h5 style="float: right;"><?php echo __("admin/invoices/bills-total-unpaid-invoices"); ?>: <strong><?php echo isset($total_unpaid_invoices_amount) ? $total_unpaid_invoices_amount : '0'; ?></strong> (<?php echo isset($total_unpaid_invoices_count) ? $total_unpaid_invoices_count : '0'; ?>)</h5>

                        </div>
                        <?php
                    }
                    elseif($status == "upcoming")
                    {
                        ?>
                        <div class="kdvinfo">
                            <h5 style="float: left;"><?php echo __("admin/invoices/page-bills-upcoming"); ?>: <strong><?php echo isset($total_unpaid_invoices_amount) ? $total_unpaid_invoices_amount : '0'; ?></strong> (<?php echo isset($total_unpaid_invoices_count) ? $total_unpaid_invoices_count : '0'; ?>)</h5>
                        </div>
                        <?php
                    }
                    elseif($status == "overdue")
                    {
                        ?>
                        <div class="kdvinfo">
                            <h5 style="float: left;"><?php echo __("admin/invoices/page-bills-overdue"); ?>: <strong><?php echo isset($total_unpaid_invoices_amount) ? $total_unpaid_invoices_amount : '0'; ?></strong> (<?php echo isset($total_unpaid_invoices_count) ? $total_unpaid_invoices_count : '0'; ?>)</h5>
                        </div>
                        <?php
                    }
                    elseif(!Config::get("options/taxation") && !$search){
                        ?>
                        <div class="kdvinfo">
                            <h5 style="float: right;"><?php echo __("admin/invoices/bills-total-unpaid-invoices"); ?>: <strong><?php echo isset($total_unpaid_invoices_amount) ? $total_unpaid_invoices_amount : '0'; ?></strong> (<?php echo isset($total_unpaid_invoices_count) ? $total_unpaid_invoices_count : '0'; ?>)</h5>
                        </div>
                        <?php
                    }
                    else{
                        ?>
                        <div class="clear"></div>
                        <br>
                        <?php
                    }
                ?>
                <div class="clear"></div>


                <table width="100%" id="datatable" class="table table-striped table-borderedx table-condensed nowrap">
                    <thead style="background:#ebebeb;">
                    <tr>
                        <th align="left">#</th>
                        <th align="left" data-orderable="false" style="width:5px;">
                            <input type="checkbox" class="checkbox-custom" id="allSelect" onchange="$('.selected-item').prop('checked',$(this).prop('checked'));"><label for="allSelect" class="checkbox-custom-label"></label>
                        </th>
                        <th align="center" data-orderable="false"><?php echo __("admin/invoices/bills-th-id"); ?></th>
                        <th align="left" data-orderable="false"><?php echo __("admin/invoices/bills-th-customer"); ?></th>
                        <th align="center" data-orderable="false"><?php echo __("admin/invoices/bills-th-amount"); ?></th>
                        <?php if(!$status): ?>
                            <th align="center" data-orderable="false"><?php echo __("admin/invoices/bills-th-date"); ?></th>
                        <?php elseif($status == "unpaid" || $status == "upcoming" || $status == "overdue"): ?>
                            <th align="center" data-orderable="false"><?php echo __("admin/invoices/bills-th-duedate"); ?></th>
                        <?php elseif($status == "paid" || $status == "taxed" || $status == "untaxed"): ?>
                            <th align="center" data-orderable="false"><?php echo __("admin/invoices/bills-th-datepaid"); ?></th>
                        <?php elseif($status == "cancelled-refund"): ?>
                            <th align="center" data-orderable="false"><?php echo __("admin/invoices/bills-th-refunddate"); ?></th>
                        <?php endif; ?>

                        <?php if(Config::get("options/send-bill-to-address/status")): ?>
                            <th align="center" data-orderable="false"><?php echo __("admin/invoices/bills-th-sendbta"); ?></th>
                        <?php endif; ?>

                        <?php if(Config::get("options/taxation") && (!$status || $status == "paid" || $status == "taxed" || $status == "untaxed")): ?>
                            <th align="center" data-orderable="false"><?php echo __("admin/invoices/bills-th-taxed"); ?></th>
                        <?php endif; ?>

                        <th align="center" data-orderable="false"><?php echo __("admin/invoices/bills-th-status"); ?></th>
                        <th align="center" data-orderable="false"></th>
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