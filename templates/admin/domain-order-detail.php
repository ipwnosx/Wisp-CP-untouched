<!DOCTYPE html>
<html>
<head>
    <?php
        $options    = $order["options"];
        Utility::sksort($lang_list,"local");
        $plugins    = ['jquery-ui','select2','voucher_codes','dataTables'];
        include __DIR__.DS."inc".DS."head.php";

        $cancellation_request = false;

        if(isset($pending_events) && $pending_events)
        {
            foreach($pending_events AS $k=>$event)
            {
                if($event['name'] == "cancelled-product-request")
                {
                    $cancellation_request = $event;
                    unset($pending_events[$k]);
                }
            }
        }

        $pendingTransferwthApi = isset($pending_events[0]["name"]) && $pending_events[0]["name"] == "transfer-request-to-us-with-api" && $order["status"] == "inprocess" && $order["module"] != "none";

    ?>

    <script type="text/javascript">
        $(document).ready(function(){

            var tab = _GET("content");
            if (tab != '' && tab != undefined) {
                $("#tab-content .tablinks[data-tab='" + tab + "']").click();
            } else {
                $("#tab-content .tablinks:eq(0)").addClass("active");
                $("#tab-content .tabcontent:eq(0)").css("display", "block");
            }

            $("#transferUser").select2({
                placeholder: "<?php echo __("admin/orders/detail-transfer-to-another-user-select"); ?>",
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

            $("#linkedProduct").select2({
                placeholder: "<?php echo ___("needs/none"); ?>",
                ajax: {
                    url: '<?php echo $links["controller"]; ?>?operation=select-linked-products.json',
                    dataType: 'json',
                    data: function (params) {
                        var query = {
                            search: params.term,
                            type: 'public',
                            none: 'true',
                        }
                        return query;
                    }
                }
            });

            $("#detailForm_submit").on("click",function(){
                MioAjaxElement($(this),{
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                    result:"detailForm_handler",
                });
            });

            <?php if(!$privOperation): ?>
            $("#detailForm input,#detailForm select,textarea").attr("disabled",true);
            <?php endif; ?>

        });

        function detailForm_handler(result){
            $("#detailForm input[name=from]").val("detail");
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

        function applyOperation(type){
            $("#content-detail").addClass("tab-blur-content");
            $("#operation-loading").fadeIn(500,function(){
            });

            var request = MioAjax({
                action: "<?php echo $links["list"]; ?>",
                method: "POST",
                data: {operation:"apply_operation",from:"detail",type:type,id:<?php echo $order["id"]; ?>}
            },true,true);

            request.done(function(result){

                $("#operation-loading").fadeOut(500,function(){
                    $("#content-detail").removeClass("tab-blur-content");
                });

                if(result){
                    if(result != ''){
                        var solve = getJson(result);
                        if(solve !== false){
                            if(solve.status == "error"){
                                if(solve.message != undefined && solve.message != ''){

                                    alert_error(solve.message,{timer:5000});

                                    if(solve.for != undefined && solve.for == "status"){
                                        $("#statusMsg").css("display","block");
                                        $("#statusMsg .statusMsg_text").html(solve.message);
                                    }
                                }

                            }else if(solve.status == "successful"){
                                $("#statusMsg").css("display","none");
                                alert_success(solve.message,{timer:3000});
                                if(solve.redirect != undefined && solve.redirect){
                                    setTimeout(function(){
                                        window.location.href = solve.redirect;
                                    },3000);
                                }
                            }
                        }else
                            console.log(result);
                    }
                }else console.log(result);
            });

        }

        function applyDelete(){
            open_modal("deleteModal",{
                title:"<?php echo __("admin/orders/delete-modal-title-list"); ?>"
            });

            $("#delete_ok").click(function(){
                var password = $('#password1').val();
                var request = MioAjax({
                    action: "<?php echo $links["controller"]; ?>",
                    method: "POST",
                    data: {operation:"apply_operation",from:"detail",type:"delete",id:<?php echo $order["id"]; ?>}
                },true,true);

                request.done(function(result){
                    if(result){
                        if(result != ''){
                            var solve = getJson(result);
                            if(solve !== false){
                                if(solve.status == "error"){

                                    if(solve.message != undefined && solve.message != ''){

                                        alert_error(solve.message,{timer:5000});

                                        if(solve.for != undefined && solve.for == "status"){
                                            $("#statusMsg").css("display","block");
                                            $("#statusMsg .statusMsg_text").html(solve.message);
                                        }
                                    }
                                }else if(solve.status == "successful"){
                                    $("#statusMsg").css("display","none");
                                    alert_success(solve.message,{timer:3000});
                                    close_modal("deleteModal");
                                    if(solve.redirect != undefined && solve.redirect){
                                        setTimeout(function(){
                                            window.location.href = solve.redirect;
                                        },3000);
                                    }
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

        function _EventOK(id,el){
            var request = MioAjax({
                waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                button_element:el !== undefined ? el : $("#event_"+id+" .event-ok-button"),
                action:"<?php echo $links["controller"]; ?>",
                method:"POST",
                data:{operation:"event_ok",id:id}
            },true,true);
            request.done(function(result){
                if(result != ''){
                    var solve = getJson(result);
                    if(solve !== false){
                        if(solve.status == "error")
                        {
                            if(solve.message != undefined && solve.message != '')
                                alert_error(solve.message,{timer:5000});
                        }
                        else if(solve.status == "successful"){
                            $("#event_"+id).fadeOut(300);
                            if(id === <?php echo  $cancellation_request ? $cancellation_request["id"] : 0; ?>)
                                $(".cancellation_request_operations").fadeOut(300);
                        }
                    }else
                        console.log(result);
                }
            });
        }
        function _EventDel(id,el){
            var request = MioAjax({
                waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                button_element:el !== undefined ? el : $("#event_"+id+" .event-ok-button"),
                action:"<?php echo $links["controller"]; ?>",
                method:"POST",
                data:{operation:"event_del",id:id}
            },true,true);
            request.done(function(result){
                if(result != ''){
                    var solve = getJson(result);
                    if(solve !== false){
                        if(solve.status == "error")
                        {
                            if(solve.message != undefined && solve.message != '')
                                alert_error(solve.message,{timer:5000});
                        }
                        else if(solve.status == "successful"){
                            $("#event_"+id).fadeOut(300);
                            if(id === <?php echo  $cancellation_request ? $cancellation_request["id"] : 0; ?>)
                                $("#CancellationRequestWrap").fadeOut(300);
                        }
                    }else
                        console.log(result);
                }
            });
        }

        function MsgOK(){
            var request = MioAjax({
                waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                button_element:$("#statusMsg_OK"),
                action:"<?php echo $links["controller"]; ?>",
                method:"POST",
                data:{operation:"msg_ok"}
            },true,true);
            request.done(function(result){
                if(result != ''){
                    var solve = getJson(result);
                    if(solve !== false){
                        if(solve.status == "error"){
                            if(solve.message != undefined && solve.message != '')
                                alert_error(solve.message,{timer:5000});
                        }else if(solve.status == "successful"){
                            $("#statusMsg").fadeOut(300,function(){
                                $("#statusMsg_text").html('');
                            });
                        }
                    }else
                        console.log(result);
                }
            });
        }
    </script>
</head>
<body>

<div id="invoices_modal" style="display: none;" data-izimodal-title="<?php echo __("admin/orders/detail-all-invoices"); ?>">
    <script type="text/javascript">
        var invoices;
        function view_all_invoices_btn(){
            open_modal("invoices_modal",{width:'1200px'});
            if(invoices) invoices.destroy();
            if(!invoices){
                invoices = $('#invoicesTable').DataTable({
                    "columnDefs": [
                        {
                            "targets": [0],
                            "visible":false,
                        },
                    ],
                    "lengthMenu": [
                        [10, 25, 50, -1], [10, 25, 50, "<?php echo ___("needs/allOf"); ?>"]
                    ],
                    "searching" : false,
                    responsive: true,
                    "language":{"url":"<?php echo APP_URI; ?>/<?php echo ___("package/code"); ?>/datatable/lang.json"}
                });
            }
        }
    </script>
    <div class="padding20">
        <table width="100%" id="invoicesTable">
            <thead style="background:#ebebeb;">
            <tr>
                <th align="left">#</th>
                <th align="center" data-orderable="false"><?php echo __("admin/invoices/bills-th-id"); ?></th>
                <th align="center" data-orderable="false"><?php echo __("admin/invoices/bills-th-amount"); ?></th>
                <th align="center" data-orderable="false"><?php echo __("admin/invoices/bills-th-date"); ?></th>
                <th align="center" data-orderable="false"><?php echo __("admin/invoices/bills-th-status"); ?></th>
                <th align="center" data-orderable="false"></th>
            </tr>
            </thead>
            <tbody align="center" style="border-top:none;">
            <?php
                if(isset($invoices) && $invoices){
                    foreach($invoices AS $k=>$row){
                        $id     = $row["id"];
                        $amount_detail       = Money::formatter_symbol($row["subtotal"],$row["currency"]);
                        if($row["status"] != "unpaid")
                            $amount_detail   = Money::formatter_symbol($row["total"],$row["currency"]);

                        if($row["status"] == "paid" || $row["status"] == "taxed" || $row["status"] == "untaxed")
                            $date_detail = DateManager::format(Config::get("options/date-format")." - H:i",$row["datepaid"]);
                        elseif($row["status"] == "unpaid")
                            $date_detail = DateManager::format(Config::get("options/date-format")." - H:i",$row["duedate"]);
                        elseif($row["status"] == "cancelled-refund"){
                            if(substr($row["refunddate"],0,4) == "1881")
                                $date_detail = DateManager::format(Config::get("options/date-format")." - H:i",$row["duedate"]);
                            else
                                $date_detail = DateManager::format(Config::get("options/date-format")." - H:i",$row["refunddate"]);
                        }
                        else{
                            if($row["status"] == "paid") $date_detail = '<strong>'.__("admin/invoices/bills-th-datepaid").'</strong><br>'.DateManager::format(Config::get("options/date-format")." - H:i",$row["datepaid"]);
                            elseif($row["status"] == "unpaid" || $row["status"] == "waiting") $date_detail = '<strong>'.__("admin/invoices/bills-th-duedate").'</strong><br>'.DateManager::format(Config::get("options/date-format")." - H:i",$row["duedate"]);
                            elseif($row["status"] == "refund") $date_detail = '<strong>'.__("admin/invoices/bills-th-refunddate").'</strong><br>'.DateManager::format(Config::get("options/date-format")." - H:i",$row["refunddate"]);
                            else
                                $date_detail = '<strong>'.__("admin/invoices/bills-th-cdate").'</strong><br>'.DateManager::format(Config::get("options/date-format")." - H:i",$row["cdate"]);
                        }

                        $detail_link = Controllers::$init->AdminCRLink("invoices-2",["detail",$id]);
                        ?>
                        <tr>
                            <td><?php echo $k; ?></td>
                            <td><?php echo "#".$id; ?></td>
                            <td><?php echo $amount_detail; ?></td>
                            <td><?php echo $date_detail; ?></td>
                            <td><?php echo $invoice_situations[$row["status"]]; ?></td>
                            <td><a href="<?php echo $detail_link; ?>" target="_blank" data-tooltip="<?php echo ___("needs/button-edit"); ?>" class="sbtn"><i class="fa fa-edit" aria-hidden="true"></i></a></td>
                        </tr>
                        <?php
                    }
                }
            ?>
            </tbody>
        </table>

    </div>
</div>

<div id="deleteModal" style="display: none;">
    <div class="padding20">
        <div align="center">
            <p id="deleteModal_text1"><?php echo __("admin/orders/delete-are-youu-sure-list"); ?></p>
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
                <h1><strong><?php echo __("admin/orders/page-domain-detail",['{name}' => $order["name"]]); ?></strong></h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>


            <div id="tab-content"><!-- tab wrap content start -->
                <ul class="tab">
                    <li>
                        <a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'detail','content')" data-tab="detail"><i class="fa fa-info" aria-hidden="true"></i>  <?php echo __("admin/orders/detail-content-tab-detail"); ?></a>
                    </li>

                    <li>
                        <a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'whois','content')" data-tab="whois"><i class="fa fa-user" aria-hidden="true"></i>  <?php echo __("admin/orders/detail-content-tab-whois"); ?></a>
                    </li>

                    <li>
                        <a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'dns','content')" data-tab="dns"><i class="fa fa-globe" aria-hidden="true"></i>  <?php echo __("admin/orders/detail-content-tab-dns"); ?></a>
                    </li>

                    <li>
                        <a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'history','content')" data-tab="history"><i class="fa fa-history" aria-hidden="true"></i>  <?php echo __("admin/orders/detail-content-tab-history"); ?></a>
                    </li>

                </ul>

                <div id="operation-loading" class="blur-text" style="display: none">
                    <i class="fa fa-cog loadingicon" aria-hidden="true"></i>
                    <div class="clear"></div>
                    <strong><?php echo __("admin/orders/list-row-operation-processing"); ?></strong>
                </div>

                <div id="content-detail" class="tabcontent"><!-- detail tab content start -->

                    <?php
                        if($cancellation_request)
                        {
                            $cancellation_request["data"] = Utility::jdecode($cancellation_request["data"],true);
                            ?>
                            <div class="red-info" id="CancellationRequestWrap">
                                <div class="padding20">
                                    <i class="fa fa-meh-o"></i>

                                    <p>
                                        <strong style="display: block;margin-bottom: 10px;font-size: 18px;"><?php echo __("admin/events/cancelled-product-request"); ?></strong>
                                        <span style="display: block;margin-bottom: 10px;">   <strong><?php echo __("admin/orders/cancellation-reason"); ?></strong>: <?php echo $cancellation_request["data"]["reason"]; ?></span>

                                        <span style="display: block;"> <strong><?php echo __("admin/orders/cancellation-urgency"); ?></strong>: <?php echo __("admin/orders/cancellation-urgency-".$cancellation_request["data"]["urgency"]); ?></span>
                                        <span style="display:block;margin-bottom:15px;">
                                                <strong><?php echo __("admin/tools/reminders-creation-date"); ?></strong>: <?php echo DateManager::format(Config::get("options/date-format")." - H:i",$cancellation_request["cdate"])?></span>

                                        <a style="<?php echo $cancellation_request["status"] == "approved" ? "display: none;" : ''; ?>" class="red lbtn cancellation_request_operations" href="javascript:void 0;" onclick="_EventOK(<?php echo $event["id"]; ?>,this);"><?php echo __("admin/orders/detail-operation-button-approve"); ?></a>
                                        <a class="green lbtn" href="javascript:void 0;" onclick="_EventDel(<?php echo $event["id"]; ?>,this);"><?php echo ___("needs/button-delete"); ?></a>
                                        <a class="lbtn" href="<?php echo Controllers::$init->AdminCRLink("tickets-1",["create"]); ?>?user_id=<?php echo $order["owner_id"]; ?>&order_id=<?php echo $order["id"]; ?>"><?php echo __("admin/index/menu-tickets-create"); ?></a>

                                    </p>

                                </div>
                            </div>
                            <?php
                        }
                    ?>

                    <div class="adminpagecon">

                        <form action="<?php echo $links["controller"]; ?>" method="post" id="detailForm" enctype="multipart/form-data">
                            <input type="hidden" name="operation" value="update_detail">
                            <input type="hidden" name="from" value="detail">

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/orders/detail-content-tab-detail-user"); ?></div>
                                <div class="yuzde70">
                                    <a href="<?php echo $links["detail-user-link"]; ?>" target="_blank">
                                        <strong><?php echo $user["full_name"]; ?></strong>
                                        <?php echo $user["company_name"] ? "(".$user["company_name"].")" : ''; ?>
                                        <?php
                                            if($user['blacklist']){
                                                ?>
                                                <span class="flaggeduser"><i class="fa fa-exclamation-circle" aria-hidden="true"></i><?php echo __("admin/orders/user-blacklist"); ?></span>
                                                <?php
                                            }
                                        ?>
                                    </a>
                                </div>
                            </div>

                              <?php if($privOperation && $order["status"] != "waiting"): ?>
                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/orders/detail-transfer-to-another-user"); ?></div>
                                    <div class="yuzde70">
                                        <select name="transfer_user" id="transferUser" style="width: 100%;"></select>
                                    </div>
                                </div>

                                  <div class="formcon">
                                      <div class="yuzde30"><?php echo __("admin/orders/detail-linked-product"); ?></div>
                                      <div class="yuzde70">
                                          <select name="product_id" id="linkedProduct" style="width: 100%;">
                                              <?php
                                                  if(isset($product) && $product){
                                                      ?>
                                                      <option value="<?php echo $product["id"]; ?>"><?php echo $product["name"]; ?></option>
                                                      <?php
                                                  }
                                              ?>
                                          </select>
                                      </div>
                                  </div>
                            <?php endif; ?>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/orders/detail-content-tab-detail-invoice"); ?></div>
                                <div class="yuzde70">
                                    <?php if(isset($invoice) && $invoice): ?>
                                        <a href="<?php echo $links["invoice-link"]; ?>" target="_blank">
                                            <?php echo "#".$invoice["id"]; ?>
                                        </a>
                                    <?php endif;?>

                                    <a class="lbtn" href="javascript:void 0;" onclick="view_all_invoices_btn();"><?php echo __("admin/orders/detail-view-all-invoices"); ?></a>


                                    <?php
                                        if($order["period"] !== "none"){
                                            ?>
                                            <a class="lbtn" href="javascript:void 0;" onclick="generate_renew_invoice_btn(this);"><?php echo __("admin/orders/detail-generate-renew-invoice"); ?></a>

                                            <script type="text/javascript">
                                                function generate_renew_invoice_btn(btn_el){
                                                    var request = MioAjax({
                                                        waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                                                        progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                                                        button_element: btn_el,
                                                        action:"<?php echo $links["controller"]; ?>",
                                                        method:"POST",
                                                        data:{operation:"generate_renew_invoice"}
                                                    },true,true);

                                                    request.done(function(result){
                                                        if(result !== ''){
                                                            var solve = getJson(result);
                                                            if(solve !== false){
                                                                if(solve.status == "error"){
                                                                    if(solve.message != undefined && solve.message != '')
                                                                        alert_error(solve.message,{timer:5000});
                                                                }else if(solve.status == "successful"){
                                                                    alert_success(solve.message,{timer:2000});
                                                                    if(solve.redirect !== undefined && solve.redirect !== ''){
                                                                        setTimeout(function(){
                                                                            window.location.href = solve.redirect;
                                                                        },2000);
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    });
                                                }
                                            </script>
                                            <?php
                                        }
                                    ?>
                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/orders/detail-ordernum"); ?></div>
                                <div class="yuzde70">
                                    #<?php echo $order["id"]; ?>
                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/orders/detail-content-tab-detail-domain-module"); ?></div>
                                <div class="yuzde70">
                                  <select name="module">
                                      <option value="none"><?php echo ___("needs/none"); ?></option>
                                      <?php
                                          if(isset($registrar_modules) && $registrar_modules){
                                              foreach($registrar_modules AS $k=>$v){
                                                  $selected = $order["module"] == $k ? ' selected' : '';
                                                  ?>
                                                  <option<?php echo $selected; ?> value="<?php echo $k; ?>"><?php echo $v["lang"]["name"]; ?></option>
                                                  <?php
                                              }
                                          }
                                      ?>
                                  </select>
                                </div>
                            </div>


                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/orders/detail-status"); ?></div>
                                <div class="yuzde70">
                                    <?php echo $situations[$order["status"]]; ?>
                                    <div class="clear"></div>
                                    <div class="red-info" id="statusMsg" style="<?php echo $order["status_msg"] ? '' : 'display:none;'; ?>">
                                        <div class="padding20">
                                            <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                            <p class="statusMsg_text"><?php echo $order["status_msg"]; ?></p>
                                            <a class="lbtn" id="statusMsg_OK" href="javascript:MsgOK();void 0;"><?php echo ___("needs/ok"); ?></a>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                    <?php
                                        if($pending_events){
                                            foreach($pending_events AS $k=>$event){
                                                ?>
                                                <div class="order-event-item" id="event_<?php echo $event["id"]; ?>">
                                                    <?php echo Events::getMessage($event); ?>
                                                    <?php if(!($event["name"] == "transfer-request-to-us-with-manuel" || $event["name"] == "transfer-request-to-us-with-api")): ?>
                                                        <a class="lbtn event-ok-button" href="javascript:_EventOK(<?php echo $event["id"]; ?>);void 0;"><?php echo ___("needs/ok"); ?></a>
                                                    <?php endif; ?>
                                                </div>
                                                <?php
                                            }
                                        }
                                    ?>

                                </div>
                            </div>


                            <?php if($privOperation): ?>
                                <div class="formcon" id="applyOperation_wrap">
                                    <div class="yuzde30"><?php echo __("admin/orders/detail-operation"); ?></div>
                                    <div class="yuzde70">

                                        <?php if($order["status"] == "waiting" && !$pendingTransferwthApi): ?>
                                            <input type="radio" class="radio-custom" id="apply_approve" name="apply" value="approve">
                                            <label class="radio-custom-label" for="apply_approve" style="margin-left: 10px;"><?php echo __("admin/orders/detail-operation-button-approve"); ?></label>
                                        <?php endif; ?>

                                        <?php if($order["status"] != "waiting" && $order["status"] != "active" && !$pendingTransferwthApi): ?>
                                            <input <?php echo $order["status"] != "suspended" ? 'data-supported="true"' : ''; ?> type="radio" class="radio-custom" id="apply_active" name="apply" value="active">
                                            <label class="radio-custom-label" for="apply_active" style="margin-left: 10px;"><?php echo __("admin/orders/detail-operation-button-active"); ?></label>
                                        <?php endif; ?>

                                        <?php if($order["status"] != "suspended" && $order["status"] != "waiting"): ?>
                                            <input type="radio" class="radio-custom" id="apply_suspended" name="apply" value="suspended">
                                            <label class="radio-custom-label" for="apply_suspended" style="margin-left: 10px;"><?php echo __("admin/orders/detail-operation-button-suspended"); ?></label>
                                        <?php endif; ?>

                                        <?php if($order["status"] != "cancelled" && $order["status"] != "waiting"): ?>
                                            <input type="radio" class="radio-custom" id="apply_cancelled" name="apply" value="cancelled">
                                            <label class="radio-custom-label" for="apply_cancelled" style="margin-left: 10px;"><?php echo __("admin/orders/detail-operation-button-cancelled"); ?></label>
                                        <?php endif; ?>

                                        <?php if($privDelete): ?>
                                            <input type="radio" class="radio-custom" id="apply_delete" name="apply" value="delete">
                                            <label class="radio-custom-label" for="apply_delete" style="margin-left: 10px;"><?php echo __("admin/orders/detail-operation-button-delete"); ?></label>
                                        <?php endif; ?>

                                        <div class="clear"></div>
                                        <div id="apply_note_cancelled" style="display: none;" class="red-info apply-notes">
                                            <div class="padding15">
                                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                <p><?php echo __("admin/orders/detail-operation-cancelled-info"); ?></p>
                                            </div>
                                        </div>

                                        <script type="text/javascript">
                                            $(document).ready(function(){
                                                $("input[name=apply]").change(function(){
                                                    var val = $(this).val();
                                                    $(".apply-notes").css("display","none");
                                                    if(document.getElementById("apply_note_"+val))
                                                        $("#apply_note_"+val).fadeIn(300);
                                                });
                                            });
                                        </script>

                                        <?php if($order["module"] != "none"): ?>
                                            <div class="clear"></div>
                                            <div style="margin-top: 10px;margin-left: 10px;" id="module_permission">
                                                <input checked name="apply_on_module" type="checkbox" class="sitemio-checkbox" id="apply-module" value="1">
                                                <label class="sitemio-checkbox-label" for="apply-module"></label>
                                                <span class="kinfo"><?php echo __("admin/orders/apply-on-module"); ?></span>
                                            </div>
                                            <script type="text/javascript">
                                                $(document).ready(function(){
                                                    checkApplyOperationSelected();
                                                    $("#applyOperation_wrap input").change(checkApplyOperationSelected);
                                                });
                                                function checkApplyOperationSelected(){
                                                    var s_el = $("#applyOperation_wrap input:checked");
                                                    if(s_el.data("supported"))
                                                        $("#module_permission").css("display","inline-block");
                                                    else
                                                        $("#module_permission").css("display","none");
                                                }
                                            </script>
                                        <?php endif; ?>

                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if(isset($options["tcode"])): ?>
                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/orders/domain-incoming-transfer-code"); ?></div>
                                    <div class="yuzde70">
                                        <input type="text" name="tcode" value="<?php echo htmlentities($options["tcode"],ENT_QUOTES); ?>" style="width: 200px;">
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if($order["status"] == "active" && !isset($module)): ?>
                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/orders/domain-transfer-code"); ?></div>
                                    <div class="yuzde70">
                                        <script type="text/javascript">
                                            function send_transfer_code(element){
                                                var input,code;
                                                input = $("input[name=transfer-code]");
                                                code = input.val();
                                                if(code == ''){
                                                    alert_error("<?php echo htmlspecialchars(__("admin/orders/error11")); ?>",{timer:3000});
                                                    input.focus();
                                                    return false;
                                                }

                                                var request = MioAjax({
                                                    action:"<?php echo $links["controller"]; ?>",
                                                    method:"POST",
                                                    data:{operation:"domain_send_transfer_code",code:code},
                                                    button_element:element,
                                                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                                                    progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                                                },true,true);
                                                request.done(function(result){
                                                    detailForm_handler(result);
                                                });

                                            }

                                            function generate_transfer_code(element){
                                                var input = $('input[name=transfer-code]');
                                                var code = voucher_codes.generate({length:12,charset: '0123456789*-+ABCDEFGHIJKLMNOPQRSTUVWXYZ'});
                                                input.val(code);
                                                $("#detailForm input[name=from]").val("transfer-code");
                                                $("#detailForm_submit").trigger("click");
                                            }
                                        </script>
                                        <input<?php echo $order["module"] != "none" ? ' readonly' : ''; ?> type="text" name="transfer-code" value="<?php echo isset($options["transfer-code"]) ? htmlentities($options["transfer-code"],ENT_QUOTES) : ''; ?>" style="width: 200px;">
                                        <a href="javascript:void(0);" onclick="generate_transfer_code(this);" class="lbtn"><i class="fa fa-refresh"></i> <?php echo __("admin/orders/auto-generate-button"); ?></a>
                                        <a href="javascript:void(0);" onclick="send_transfer_code(this);" class="lbtn"><?php echo __("admin/orders/domain-send-transfer-code"); ?></a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        

                            <?php if($order["status"] == "active"): ?>
                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/orders/domain-transfer-lock"); ?></div>
                                    <div class="yuzde70">
                                        <input<?php echo isset($options["transferlock"]) && $options["transferlock"] ? ' checked' : ''; ?> type="checkbox" class="sitemio-checkbox" name="transferlock" value="1" id="transferLock">
                                        <label for="transferLock" class="sitemio-checkbox-label"></label>
                                    </div>
                                </div>
                            <?php endif; ?>


                          

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/orders/detail-product-name"); ?></div>
                                <div class="yuzde70">
                                    <input name="name" type="text" value="<?php echo $order["name"]; ?>">
                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/orders/detail-product-group"); ?></div>
                                <div class="yuzde70">
                                    <a href="<?php echo $links["group-link"]; ?>" target="_blank">
                                        <?php echo $order["options"]["local_group_name"]; ?>
                                    </a>
                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/orders/detail-cdate"); ?></div>
                                <div class="yuzde70">
                                    <input class="yuzde25" id="cdate" name="cdate" type="date" value="<?php echo DateManager::format("Y-m-d",$order["cdate"])?>" placeholder="YYYY-MM-DD">
                                    <input class="yuzde25" onkeypress='return event.charCode==58 || event.charCode>= 48 &&event.charCode<= 57' maxlength="5" type="time" name="ctime" value="<?php echo DateManager::format("H:i",$order["cdate"]); ?>">
                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/orders/detail-renewaldate"); ?></div>
                                <div class="yuzde70">
                                    <input class="yuzde25" id="renewaldate" name="renewaldate" type="date" value="<?php echo substr($order["renewaldate"],0,4) != "1881" ? DateManager::format("Y-m-d",$order["renewaldate"]) : ''; ?>" placeholder="YYYY-MM-DD">
                                    <input class="yuzde25" onkeypress='return event.charCode==58 || event.charCode>= 48 &&event.charCode<= 57' maxlength="5" type="time" name="renewaltime" value="<?php echo substr($order["renewaldate"],0,4) != "1881" ? DateManager::format("H:i",$order["renewaldate"]) : ''; ?>">
                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/orders/detail-duedate"); ?></div>
                                <div class="yuzde70">
                                    <input class="yuzde25" id="duedate" name="duedate" type="date" value="<?php echo substr($order["duedate"],0,4) != "1881" ? DateManager::format("Y-m-d",$order["duedate"]) : '';?>" placeholder="YYYY-MM-DD">
                                    <input class="yuzde25" onkeypress='return event.charCode==58 || event.charCode>= 48 &&event.charCode<= 57' maxlength="5" type="time" name="duetime" value="<?php echo substr($order["duedate"],0,4) != "1881" ? DateManager::format("H:i",$order["duedate"]) : ''; ?>">
                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/orders/detail-process-exemption"); ?></div>
                                <div class="yuzde70">
                                    <input class="yuzde50" id="process_exemption_date" name="process_exemption_date" type="date" value="<?php echo substr($order["process_exemption_date"],0,4) != "1881" ? DateManager::format("Y-m-d",$order["process_exemption_date"]) : '';?>" placeholder="YYYY-MM-DD">
                                    <div class="clear"></div>
                                    <span class="kinfo"><?php echo __("admin/orders/detail-process-exemption-info"); ?></span>

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
                                                    ?><option<?php echo $k == $order["pmethod"] ? ' selected' : ''; ?> value="<?php echo $k; ?>"><?php echo $v; ?></option><?php
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <?php
                                if(isset($subscription) && $subscription)
                                {
                                    ?>
                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/orders/link-subscription"); ?></div>
                                        <div class="yuzde70" id="subscription_content">

                                            <div id="subscription_loader">
                                                <div class="load-wrapp">
                                                    <p style="margin-bottom:20px"><strong><?php echo ___("needs/processing"); ?>...</strong><br><?php echo ___("needs/please-wait"); ?></p>
                                                    <div class="load-7">
                                                        <div class="square-holder">
                                                            <div class="square"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <script type="text/javascript">
                                        $(document).ready(function(){
                                            $.get("<?php echo $links["controller"]; ?>?bring=subscription_detail",function(res){
                                                $("#subscription_loader").html(res);
                                            });
                                        });
                                        function cancel_subscription(el)
                                        {
                                            if(!confirm("<?php echo ___("needs/apply-are-you-sure"); ?>")) return false;
                                            var request = MioAjax({
                                                button_element:el,
                                                waiting_text: "<?php echo __("website/others/button1-pending"); ?>",
                                                action: "<?php echo $links["controller"]; ?>",
                                                method: "POST",
                                                data:{
                                                    operation: "cancel_subscription",
                                                    id: <?php echo $subscription["id"]; ?>,
                                                    order_id: <?php echo $order["id"]; ?>
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
                                                        window.location.href = '<?php echo $links["controller"]; ?>';
                                                    }
                                                }
                                            });
                                        }
                                    </script>
                                <?php
                                    }
                                    else
                                    {
                                ?>
                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/orders/subscription-identifier"); ?></div>
                                        <div class="yuzde70">
                                            <input type="text" name="subscription[identifier]" placeholder="" value="">
                                        </div>
                                    </div>
                                    <?php
                                }
                            ?>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/orders/detail-pricing-type"); ?></div>
                                <div class="yuzde70">
                                    <select name="pricing-type">
                                        <?php
                                            $pricing_type = false;
                                            if(isset($options["pricing-type"]))
                                                $pricing_type = $options["pricing-type"];
                                        ?>
                                        <option value="1"<?php echo !$pricing_type || $pricing_type == 1 ? ' selected' : ''; ?>><?php echo __("admin/orders/detail-pricing-type-1"); ?></option>
                                        <option value="2"<?php echo $pricing_type == 2 ? ' selected' : ''; ?>><?php echo __("admin/orders/detail-pricing-type-2"); ?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/orders/detail-pricing"); ?></div>
                                <div class="yuzde70">

                                    <input class="yuzde15" name="period_time" type="text" placeholder="<?php echo __("admin/orders/detail-pricing-period"); ?>" value="<?php echo $order["period_time"]; ?>"> -
                                    <input type="hidden" name="period" value="year">
                                    <select disabled class="yuzde15" name="period">
                                        <?php
                                            foreach(___("date/periods") AS $k=>$v){
                                                ?>
                                                <option<?php echo $order["period"] == $k ? ' selected' : ''; ?> value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                                <?php
                                            }
                                        ?>
                                    </select> -
                                    <input class="yuzde15" name="amount" type="text" placeholder="<?php echo __("admin/orders/detail-pricing-amount"); ?>" value="<?php echo $order["amount"] ? Money::formatter($order["amount"],$order["amount_cid"]) : ''; ?>" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57'> -
                                    <select class="yuzde20" name="amount_cid">
                                        <?php
                                            foreach(Money::getCurrencies($order["amount_cid"]) AS $curr){
                                                ?>
                                                <option<?php echo $order["amount_cid"] == $curr["id"] ? ' selected' : ''; ?> value="<?php echo $curr["id"]; ?>"><?php echo $curr["name"]." (".$curr["code"].")"; ?></option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                    <div class="clear"></div>

                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/orders/detail-notes"); ?></div>
                                <div class="yuzde70">
                                    <textarea name="notes" placeholder="<?php echo __("admin/orders/detail-notes-ex"); ?>"><?php echo $order["notes"]; ?></textarea>
                                </div>
                            </div>


                            <?php if($privOperation): ?>
                                <div style="float:right;margin-bottom:20px;" class="guncellebtn yuzde30">
                                    <a id="detailForm_submit" class="yesilbtn gonderbtn" href="javascript:void(0);"><?php echo __("admin/orders/update-button"); ?></a>
                                </div>
                            <?php endif; ?>


                        </form>


                        <div class="clear"></div>
                    </div>


                    <div class="clear"></div>
                </div><!-- detail tab content end -->

                <div id="content-whois" class="tabcontent"><!-- whois tab content start -->

                    <div class="adminpagecon">

                            <div class="green-info" style="margin-bottom:20px;">
                                <div class="padding15">
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                    <p><?php echo __("admin/orders/update-whois-info-desc"); ?></p>
                                </div>
                            </div>



                        <script type="text/javascript">
                            $(document).ready(function(){
                                $("#whoisInfoForm_submit").on("click",function(){
                                    MioAjaxElement($(this),{
                                        waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                                        progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                                        result:"whoisInfoForm_handler",
                                    });
                                });
                            });

                            function whoisInfoForm_handler(result){
                                if(result != ''){
                                    var solve = getJson(result);
                                    if(solve !== false){
                                        if(solve.status == "error"){
                                            if(solve.for != undefined && solve.for != ''){
                                                $("#whoisInfoForm "+solve.for).focus();
                                                $("#whoisInfoForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                                $("#whoisInfoForm "+solve.for).change(function(){
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
                        <form action="<?php echo $links["controller"]; ?>" method="post" id="whoisInfoForm">
                            <input type="hidden" name="operation" value="update_whois">

                            <input name="Name" value="<?php echo $whois["Name"]; ?>" type="text" class="yuzde33" placeholder="<?php echo __("website/account_products/whois-full_name"); ?>">
                            <input name="Company" value="<?php echo $whois["Company"]; ?>" type="text" class="yuzde33" placeholder="<?php echo __("website/account_products/whois-company_name"); ?>">
                            <input name="EMail" value="<?php echo $whois["EMail"]; ?>" type="text" class="yuzde33" placeholder="<?php echo __("website/account_products/whois-email"); ?>">
                            <input name="PhoneCountryCode" value="<?php echo $whois["PhoneCountryCode"]; ?>" type="text" class="yuzde33" placeholder="<?php echo __("website/account_products/whois-phoneCountryCode"); ?>">
                            <input name="Phone" type="text" value="<?php echo $whois["Phone"]; ?>" class="yuzde33" placeholder="<?php echo __("website/account_products/whois-phone"); ?>">
                            <input name="FaxCountryCode" type="text" value="<?php echo $whois["FaxCountryCode"]; ?>" class="yuzde33" placeholder="<?php echo __("website/account_products/whois-faxCountryCode"); ?>">
                            <input name="Fax" type="text" value="<?php echo $whois["Fax"]; ?>" class="yuzde33" placeholder="<?php echo __("website/account_products/whois-fax"); ?>">
                            <input name="City" type="text" value="<?php echo $whois["City"]; ?>" class="yuzde33" placeholder="<?php echo __("website/account_products/whois-city"); ?>">
                            <input name="State" type="text" value="<?php echo $whois["State"]; ?>" class="yuzde33" placeholder="<?php echo __("website/account_products/whois-state"); ?>">
                            <input name="Address" type="text" value="<?php echo $whois["Address"]; ?>" class="yuzde33" placeholder="<?php echo __("website/account_products/whois-address"); ?>">
                            <input name="Country" type="text" value="<?php echo $whois["Country"]; ?>" class="yuzde33" placeholder="<?php echo __("website/account_products/whois-CountryCode"); ?>">
                            <input name="ZipCode" type="text" value="<?php echo $whois["ZipCode"]; ?>" class="yuzde33" placeholder="<?php echo __("website/account_products/whois-zipcode"); ?>">

                            <a href="javascript:void(0);" id="whoisInfoForm_submit" class="yesilbtn gonderbtn"><?php echo __("admin/orders/update-whois-info-button"); ?></a>

                        </form>

                        <script type="text/javascript">
                            $(document).ready(function(){

                                $("#whois_privacy_purchase").on("click","#whoisPrivacyForm_submit",function(){
                                    MioAjaxElement($(this),{
                                        waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                                        progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                                        result:"whoisPrivacyForm_handler",
                                    });
                                });

                                $("#wprivacy_show").click(function(){
                                    var request = MioAjax({
                                        button_element:$(this),
                                        waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                                        progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                                        action:"<?php echo $links["controller"]; ?>",
                                        method:"POST",
                                        data:{operation:"update_whois_privacy",status:"disable"},
                                    },true,true);

                                    request.done(function(result){
                                        whoisPrivacyForm_handler(result);
                                    });

                                });

                                $("#wprivacy_hide").click(function(){
                                    var wprivacy_purchase = <?php echo $wprivacy_purchase ? 'true' : 'false'; ?>;

                                    if(wprivacy_purchase){
                                        open_modal('whois_privacy_purchase');
                                    }else{

                                        var request = MioAjax({
                                            button_element:$(this),
                                            waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                                            progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                                            action:"<?php echo $links["controller"]; ?>",
                                            method:"POST",
                                            data:{operation:"update_whois_privacy",status:"enable"},
                                        },true,true);

                                        request.done(function(result){
                                            whoisPrivacyForm_handler(result);
                                        });

                                    }
                                });

                            });

                            function whoisPrivacyForm_handler(result){
                                if(result != ''){
                                    var solve = getJson(result);
                                    if(solve !== false){
                                        if(solve.status == "error"){
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

                        <div id="whois_privacy_purchase" style="display: none" data-izimodal-title="<?php echo __("admin/orders/domain-whois-hide"); ?>">
                            <div class="padding20">

                                <form action="<?php echo $links["controller"]; ?>" method="post" id="whoisPrivacyForm">
                                    <input type="hidden" name="operation" value="update_whois_privacy">
                                    <input type="hidden" name="status" value="enable">

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/orders/domain-whois-privacy-price"); ?></div>
                                        <div class="yuzde70">
                                            <?php echo $wprivacy_price; ?>
                                        </div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/orders/domain-whois-privacy-invoice"); ?></div>
                                        <div class="yuzde70">
                                            <input onclick="$('#pmethods').fadeOut(200);" type="radio" name="invoice_status" value="unpaid" id="wprivacy-invoice-unpaid" class="radio-custom">
                                            <label for="wprivacy-invoice-unpaid" class="radio-custom-label" style="margin-right: 15px;"><?php echo __("admin/orders/invoice-unpaid"); ?></label>

                                            <input onclick="$('#pmethods').fadeIn(200);" type="radio" name="invoice_status" value="paid" id="wprivacy-invoice-paid" class="radio-custom">
                                            <label for="wprivacy-invoice-paid" class="radio-custom-label" style="margin-right: 15px;"><?php echo __("admin/orders/invoice-paid"); ?></label>
                                        </div>
                                    </div>

                                    <div class="formcon" id="pmethods" style="display: none;">
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

                                    <?php if($privOperation): ?>

                                        <a href="javascript:void(0);" id="whoisPrivacyForm_submit" class="yesilbtn gonderbtn"> <?php echo __("admin/orders/save-button"); ?></a>
                                    <?php endif; ?>

                                </form>


                                <div class="clear"></div>
                            </div>
                        </div>

                        

                        <?php if($wprivacy): ?>
                            <a href="javascript:void(0);" id="wprivacy_show" class="turuncbtn gonderbtn"><?php echo __("admin/orders/domain-whois-show"); ?></a>
                        <?php else: ?>
                            <a href="javascript:void(0);" id="wprivacy_hide" class="mavibtn gonderbtn"><i class="fa fa-user-secret" aria-hidden="true"></i> <?php echo __("admin/orders/domain-whois-hide"); ?></a>
                        <?php endif; ?>
                        <br>
                        <?php if($wprivacy_endtime): ?>
                           <span class="kinfo" style="margin-left:15px;"> <?php echo __("admin/orders/domain-whois-privacy-endtime"); ?>: <strong><?php echo $wprivacy_endtime; ?></strong></span>
                        <?php endif; ?>
                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                </div><!-- whois tab content end -->

                <div id="content-dns" class="tabcontent"><!-- dns tab content start -->

                    <div class="adminpagecon">

                    	<div class="green-info" style="margin-bottom:20px;">
                                <div class="padding15">
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                    <p><?php echo __("admin/orders/domain-dns-operation-desc"); ?></p>
                                </div>
                            </div>
 

                        <div style="text-align:center;">

                        <div class="ModifyDns">
                            <div class="padding20">
                        <form action="<?php echo $links["controller"]; ?>" method="post" id="ModifyDns">
                            <input type="hidden" name="operation" value="domain_modify_dns">
                            <span><strong><?php echo __("admin/orders/domain-current-dns"); ?></strong></span>
                            <div class="clear"></div>
                            <input name="dns[]" value="<?php echo isset($options["ns1"]) ? $options["ns1"] : false; ?>" type="text" class="" placeholder="<?php echo __("website/account_products/domain-dns"); ?>"><br>
                            <input name="dns[]" value="<?php echo isset($options["ns2"]) ? $options["ns2"] : false; ?>" type="text" class="" placeholder="<?php echo __("website/account_products/domain-dns"); ?>"><br>
                            <input name="dns[]" value="<?php echo isset($options["ns3"]) ? $options["ns3"] : false; ?>" type="text" class="" placeholder="<?php echo __("website/account_products/domain-dns"); ?>"><br>
                            <input name="dns[]" value="<?php echo isset($options["ns4"]) ? $options["ns4"] : false; ?>" type="text" class="" placeholder="<?php echo __("website/account_products/domain-dns"); ?>">

                            <div class="clear"></div>
                            <a id="ModifyDns_submit" style="width:240px;" href="javascript:void(0);" class="mavibtn gonderbtn"><?php echo __("admin/orders/save-button"); ?></a>
                        </form>
                        </div>
                    </div>
                        <script type="text/javascript">
                            $(document).ready(function(){
                                $("#ModifyDns_submit").on("click",function(){
                                    MioAjaxElement($(this),{
                                        waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                                        progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                                        result:"ModifyDns_handler",
                                    });
                                });
                            });

                            function ModifyDns_handler(result){
                                if(result != ''){
                                    var solve = getJson(result);
                                    if(solve !== false){
                                        if(solve.status == "error"){
                                            if(solve.for != undefined && solve.for != ''){
                                                $("#ModifyDns "+solve.for).focus();
                                                $("#ModifyDns "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                                $("#ModifyDns "+solve.for).change(function(){
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


                        <div class="ModifyDns">
                            <div class="padding20">
                            <span><strong><?php echo __("admin/orders/domain-cns-management"); ?></strong></span>

                            <form action="<?php echo $links["controller"]; ?>" method="post" id="addCNS">
                                    <input type="hidden" name="operation" value="domain_add_cns">
                                    <input name="ns" type="text" class="yuzde50" placeholder="ns1.example.com">
                                    <input name="ip" type="text" class="yuzde50" placeholder="192.168.1.1">
                                    <a style="width:240px;" id="addCNS_submit" href="javascript:void(0);" class="yesilbtn gonderbtn"><?php echo __("admin/orders/domain-add-ns-button"); ?></a>
                                </form>

                        
                                
                                <script type="text/javascript">
                                    $(document).ready(function(){
                                        $("#addCNS_submit").on("click",function(){
                                            MioAjaxElement($(this),{
                                                waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                                                progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                                                result:"CNS_handler",
                                            });
                                        });

                                        $("#modifyCNS_submit").on("click",function(){
                                            MioAjaxElement($(this),{
                                                waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                                                progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                                                result:"CNS_handler",
                                            });
                                        });

                                    });

                                    function deleteCNS(id){
                                        if(!confirm("<?php echo htmlspecialchars(__("admin/orders/delete-are-youu-sure-cns")); ?>")) return false;

                                        var request = MioAjax({
                                            action:"<?php echo $links["controller"]; ?>",
                                            method:"POST",
                                            data:{operation:"domain_delete_cns",id:id},
                                        },true,true);
                                        request.done(function(result){
                                            CNS_handler(result);
                                        });
                                    }

                                    function CNS_handler(result){
                                        if(result != ''){
                                            var solve = getJson(result);
                                            if(solve !== false){
                                                if(solve.status == "error"){
                                                    if(solve.for != undefined && solve.for != ''){
                                                        $("#addCNS "+solve.for).focus();
                                                        $("#addCNS "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                                        $("#addCNS "+solve.for).change(function(){
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

                                <div class="clear"></div>
                                <br>
                                <?php if(isset($options["cns_list"]) && sizeof($options["cns_list"])): ?>
                                    <form action="<?php echo $links["controller"]; ?>" method="post" id="modifyCNS">
                                        <input type="hidden" name="operation" value="domain_modify_cns">

                                        <?php
                                            foreach($options["cns_list"] AS $id=>$row){
                                                ?>
                                                <input type="hidden" name="cns[id][]" value="<?php echo $id; ?>">
                                                <div style="display:inline-block;width:100%;">
                                                    <input name="cns[ns][]" type="text" class="yuzde25" placeholder="ns1.example.com" value="<?php echo $row["ns"]; ?>">
                                                    <input name="cns[ip][]" type="text" class="yuzde25" placeholder="192.168.1.1" value="<?php echo $row["ip"]; ?>">
                                                    <div class="yuzde10">
                                                        <a href="javascript:void(0);deleteCNS(<?php echo $id; ?>);" class="red sbtn"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        ?>

                                        <div class="clear"></div>

                                        <a style="width:240px;" id="modifyCNS_submit" href="javascript:void(0);" class="mavibtn gonderbtn"><?php echo __("admin/orders/save-button"); ?></a>
                                    </form>

                                <?php else: ?>
                                    <div align="center" style="margin-top:25px;"><?php echo __("admin/orders/domain-none-cns"); ?></div>
                                <?php endif; ?>
                    
                 </div>
                 </div>

                 </div>



                    </div>


                        <div class="clear"></div>
                    </div>

                <div id="content-history" class="tabcontent"><!-- history tab content start -->

                    <script type="text/javascript">
                        $(document).ready(function(){
                            $('#history-table').DataTable({
                                "columnDefs": [
                                    {
                                        "targets": [0],
                                        "visible":false,
                                        "searchable": false
                                    },
                                ],
                                "aaSorting" : [[0, 'asc']],
                                "lengthMenu": [
                                    [10, 25, 50, -1], [10, 25, 50, "<?php echo ___("needs/allOf"); ?>"]
                                ],
                                responsive: true,
                                "language":{"url":"<?php echo APP_URI; ?>/<?php echo ___("package/code"); ?>/datatable/lang.json"}
                            });
                        });
                    </script>
                    <table width="100%" id="history-table" class="table table-striped table-borderedx table-condensed nowrap">
                        <thead style="background:#ebebeb;">
                        <tr>
                            <th align="left">#</th>
                            <th data-orderable="false" align="left"><?php echo __("admin/orders/detail-history-th-by"); ?></th>
                            <th data-orderable="false" align="left"><?php echo __("admin/orders/detail-history-th-desc"); ?></th>
                            <th data-orderable="false" align="center"><?php echo __("admin/orders/detail-history-th-date"); ?></th>
                            <th data-orderable="false" align="center"><?php echo __("admin/users/detail-actions-th-ip"); ?></th>
                        </tr>
                        </thead>
                        <tbody align="center" style="border-top:none;">
                        <?php
                            $users = [];
                            $list = Events::getList('log','order',$order["id"],false,false,0,'id DESC');
                            if($list){
                                foreach($list AS $i => $row){
                                    $row['data'] = Utility::jdecode($row['data'],true);
                                    $user_detail    = ___("needs/system");
                                    $user           = [];
                                    if($row["user_id"] > 0)
                                    {
                                        if(isset($users[$row['user_id']]))
                                            $user = $users[$row['user_id']];
                                        else
                                        {
                                            $users[$row['user_id']] = User::getData($row['user_id'],'type,full_name','assoc');
                                            $user = $users[$row['user_id']];
                                        }
                                    }

                                    if($user){
                                        $user_detail = $user["full_name"];
                                        if($user["type"] == "admin")
                                            $user_detail = "<a href='".Controllers::$init->AdminCRLink("admins-dl",[$row["user_id"]])."' target='_blank' style='color:green;'>".$user_detail."</a>";
                                        elseif($user["type"] == "member")
                                            $user_detail = "<a href='".Controllers::$init->AdminCRLink("users-2",["detail",$row["user_id"]])."' target='_blank'>".$user_detail."</a>";
                                    }
                                    ?>
                                    <tr>
                                        <td align="left"><?php echo $i; ?></td>
                                        <td align="left">
                                            <?php
                                                echo $user_detail;
                                            ?>
                                        </td>
                                        <td align="left">
                                            <?php
                                                echo Events::order_log_description($row);
                                            ?>
                                        </td>
                                        <td align="center">
                                            <?php echo DateManager::format(Config::get("options/date-format")." H:i",$row["cdate"])?>
                                        </td>
                                        <td align="center">
                                            <?php echo isset($row['data']['ip']) ? $row['data']['ip'] : '-'; ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                        ?>
                        </tbody>
                    </table>
                    <div class="clear"></div>

                </div><!-- history tab content end -->

                    <div class="clear"></div>
                </div><!-- dns tab content end -->


            </div><!-- tab wrap content end -->


            <div class="clear"></div>
        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>