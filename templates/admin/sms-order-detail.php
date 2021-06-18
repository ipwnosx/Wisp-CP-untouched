<!DOCTYPE html>
<html>
<head>
    <?php
        $options    = $order["options"];
        Utility::sksort($lang_list,"local");
        $plugins    = ['jquery-ui','select2','dataTables'];
        include __DIR__.DS."inc".DS."head.php";
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

        function delete_delivery_file(){
            $("#delivery-file").val('');
            $("#delivery-file-button").css("display","none");
            $("#delivery-file-click").remove();

            var request = MioAjax({
                action:"<?php echo $links["controller"]; ?>",
                method:"POST",
                data:{
                    operation:"delete_delivery_file",
                }
            },true,true);

            request.done(function(result){
                if(result != ''){
                    var solve = getJson(result);
                    if(solve !== false){
                        if(solve.status == "successful"){
                            alert_success(solve.message,{timer:2000});
                        }
                    }else
                        console.log(result);
                }
            });
        }

        function applyOperation(type){
            $("#content-detail").addClass("tab-blur-content");
            $("#operation-loading").fadeIn(500,function(){
            });

            if(type == "cancelled") close_modal("cancelled_confirm");

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

        function EventOK(id){
            var request = MioAjax({
                waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                button_element:$("#event_"+id+" .event-ok-button"),
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
                            $("#event_"+id).fadeOut(300);
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
            <?php if(isset($order["options"]["module"])): ?>
                <p id="deleteModal_text2"><?php echo __("admin/orders/delete-are-youu-sure-list-note"); ?></p>
            <?php endif; ?>
            <div class="clear"></div>
            <div class="yuzde50">
                <a href="javascript:void(0);" id="delete_ok" class="gonderbtn redbtn"><i class="fa fa-check"></i> <?php echo __("admin/orders/delete-ok"); ?></a>
            </div>
            <div class="yuzde50">
                <a href="javascript:void(0);" id="delete_no" class="gonderbtn yesilbtn"><i class="fa fa-ban"></i> <?php echo __("admin/orders/delete-no"); ?></a>
            </div>
        </div>

    </div>
</div>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1><strong><?php echo __("admin/orders/page-sms-detail",['{name}' => $order["name"]]); ?></strong></h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>


            <div id="tab-content"><!-- tab wrap content start -->
                <ul class="tab">
                    <li>
                        <a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'detail','content')" data-tab="detail"><i class="fa fa-info" aria-hidden="true"></i>  <?php echo __("admin/orders/detail-content-tab-detail"); ?></a>
                    </li>

                    <li>
                        <a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'origins','content')" data-tab="origins"><i class="fa fa-id-card-o" aria-hidden="true"></i>  <?php echo __("admin/orders/detail-content-tab-origins"); ?></a>
                    </li>

                    <li>
                        <a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'reports','content')" data-tab="reports"><i class="fa fa-bar-chart" aria-hidden="true"></i>  <?php echo __("admin/orders/detail-content-tab-reports"); ?></a>
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

                    <div class="adminpagecon">

                        <form action="<?php echo $links["controller"]; ?>" method="post" id="detailForm" enctype="multipart/form-data">
                            <input type="hidden" name="operation" value="update_detail">

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
                                                    <option value="<?php echo $product["id"]; ?>"><?php echo $product["title"]; ?></option>
                                                    <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if(isset($invoice) && $invoice): ?>
                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/orders/detail-content-tab-detail-invoice"); ?></div>
                                    <div class="yuzde70">
                                        <a href="<?php echo $links["invoice-link"]; ?>" target="_blank">
                                            <?php echo "#".$invoice["id"]; ?>
                                        </a>

                                        <a id="view_all_invoices_btn" class="lbtn" href="javascript:void 0;" onclick="view_all_invoices_btn();"><?php echo __("admin/orders/detail-view-all-invoices"); ?></a>
                                    </div>
                                </div>
                            <?php endif;?>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/orders/detail-ordernum"); ?></div>
                                <div class="yuzde70">
                                    #<?php echo $order["id"]; ?>
                                </div>
                            </div>

                            <?php if($privOperation): ?>
                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/orders/detail-operation"); ?></div>
                                    <div class="yuzde70">

                                        <?php if($order["status"] == "waiting"): ?>
                                            <input type="radio" class="radio-custom" id="apply_approve" name="apply" value="approve">
                                            <label class="radio-custom-label" for="apply_approve" style="margin-left: 10px;"><?php echo __("admin/orders/detail-operation-button-approve"); ?></label>
                                        <?php endif; ?>

                                        <?php if($order["status"] != "waiting" && $order["status"] != "active"): ?>
                                            <input type="radio" class="radio-custom" id="apply_active" name="apply" value="active">
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
                                    </div>
                                </div>

                            <?php endif; ?>


                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/orders/detail-status"); ?></div>
                                <div class="yuzde70">
                                    <?php echo $situations[$order["status"]]; ?>
                                    <div class="clear"></div>
                                    <div class="red-info" id="statusMsg" style="<?php echo $order["status_msg"] ? '' : 'display:none;'; ?>">
                                        <div class="padding10">
                                            <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                            <span class="statusMsg_text"><?php echo $order["status_msg"]; ?></span>
                                            <a class="lbtn" id="statusMsg_OK" href="javascript:MsgOK();void 0;"><?php echo ___("needs/ok"); ?></a>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                    <?php
                                        if(isset($pending_events) && $pending_events){
                                            foreach($pending_events AS $k=>$event){
                                                ?>
                                                <div class="order-event-item" id="event_<?php echo $event["id"]; ?>">
                                                    <?php echo Events::getMessage($event); ?>
                                                    <a class="lbtn event-ok-button" href="javascript:EventOK(<?php echo $event["id"]; ?>);void 0;"><?php echo ___("needs/ok"); ?></a>
                                                </div>
                                                <?php
                                            }
                                        }
                                    ?>

                                </div>
                            </div>

                            <script type="text/javascript">
                                $(document).ready(function(){
                                    var smodule = "<?php echo $order["module"]; ?>";

                                    $("#selectModule option[value='"+smodule+"']").attr("selected",true).trigger("change");

                                });

                                function loadConfigData(module){
                                    if(module == "none"){

                                        $("#config_data_loader").css("display","none");
                                        $("#config_data").html('').css("display","none");

                                        return false;
                                    }

                                    $("#config_data_loader").css("display","block");
                                    $("#config_data").html('').css("display","none");

                                    var request = MioAjax({
                                        action:"<?php echo $links["controller"]; ?>",
                                        method:"POST",
                                        data:{
                                            operation:"get_sms_config_data",
                                            module:module,
                                        }
                                    },true,true);

                                    request.done(function(result){
                                        $("#config_data_loader").css("display","none");
                                        $("#config_data").html(result).css("display","block");
                                    });
                                }
                            </script>
                            <div class="formcon">
                                <div class="yuzde30">API Modül</div>
                                <div class="yuzde70">
                                    <select name="module" id="selectModule" onchange="loadConfigData(this.options[this.selectedIndex].value);">
                                        <option value="none"><?php echo ___("needs/none"); ?></option>
                                        <?php
                                            if(isset($modules) && $modules){
                                                foreach($modules AS $key=>$module){
                                                    if(!$module["config"]["meta"]["international"]){
                                                        $name = $module["lang"]["name"];
                                                        ?>
                                                        <option value="<?php echo $key; ?>"><?php echo $name; ?></option>
                                                        <?php
                                                    }
                                                }
                                            }
                                        ?>
                                    </select>
                                    <div class="clear"></div>

                                    <div id="config_data_loader" style="display:none;text-align:center;">
                                        <center><i style="font-size:24px;padding:20px;" class="loadingicon fa fa-cog" aria-hidden="true"></i></center>
                                    </div>
                                    <div id="config_data"></div>

                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30">Kimlik Bilgileri</div>
                                <div class="yuzde70">

                                    <div class="formcon">
                                        <div class="yuzde30">Adı Soyadı</div>
                                        <div class="yuzde70">
                                            <input type="text" name="id_name" value="<?php echo isset($options["name"]) ? $options["name"] : ''; ?>">
                                        </div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30">Doğum Tarihi</div>
                                        <div class="yuzde70">
                                            <input type="date" name="birthday" value="<?php echo isset($options["birthday"]) && substr($options["birthday"],0,4) != "1881" ? $options["birthday"] : ''; ?>">
                                        </div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30">T.C Kimlik No</div>
                                        <div class="yuzde70">
                                            <input type="text" name="identity" value="<?php echo isset($options["identity"]) ? $options["identity"] : ''; ?>" maxlength="11" onkeypress='return event.charCode>= 48 &&event.charCode<= 57'>
                                        </div>
                                    </div>


                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30">Secret Key</div>
                                <div class="yuzde70">
                                    <?php
                                        echo Crypt::encode($order["id"],Config::get("crypt/system"));
                                    ?>
                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30">Kayıtlı Bakiye</div>
                                <div class="yuzde70">
                                    <input style="width:100px;" name="balance" type="text" value="<?php echo isset($order["options"]["balance"]) ? $order["options"]["balance"] : ''; ?>">
                                </div>
                            </div>



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
                                <div class="yuzde30">
                                    <?php echo __("admin/orders/detail-suspend-date"); ?>
                                    <div class="clear"></div>
                                    <span class="kinfo"><?php echo __("admin/orders/detail-suspend-date-info"); ?></span>
                                </div>
                                <div class="yuzde70">
                                    <input class="yuzde25" id="suspend_date" name="suspend_date" type="date" value="<?php echo substr($order["suspend_date"],0,4) == "0000" || substr($order["suspend_date"],0,4) == "1881" ? '' : $order["suspend_date"]; ?>" placeholder="YYYY-MM-DD">
                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30">
                                    <?php echo __("admin/orders/detail-cancel-date"); ?>
                                    <div class="clear"></div>
                                    <span class="kinfo"><?php echo __("admin/orders/detail-cancel-date-info"); ?></span>
                                </div>
                                <div class="yuzde70">
                                    <input class="yuzde25" id="cancel_date" name="cancel_date" type="date" value="<?php echo substr($order["cancel_date"],0,4) == "0000" || substr($order["cancel_date"],0,4) == "1881" ? '' : $order["cancel_date"]; ?>" placeholder="YYYY-MM-DD">
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
                                    <input type="hidden" name="period" value="none">
                                    <select class="yuzde15" name="period" disabled>
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


                <div id="content-origins" class="tabcontent"><!-- origins tab content start -->

                    <script type="text/javascript">
                        $(document).ready(function() {
                            $('#origins').DataTable({
                                "columnDefs": [
                                    {
                                        "targets": [0],
                                        "visible":false,
                                        "searchable": false
                                    },
                                    {
                                        "targets": [1,2,3,4,5],
                                        orderable:false,
                                    }
                                ],
                                "aaSorting" : [[0, 'asc']],
                                responsive: true,
                                "language":{"url":"<?php echo APP_URI; ?>/<?php echo ___("package/code"); ?>/datatable/lang.json"}
                            });
                        });
                    </script>

                    <table width="100%" border="0" id="origins">

                        <thead style="background:#ebebeb;">
                        <tr>
                            <th align="left">#</th>
                            <th align="left">Başlık Bilgisi</th>
                            <th align="center">Evraklar</th>
                            <th align="center">Açıklama</th>
                            <th align="center">Durum</th>
                            <th align="center">İşlem</th>
                        </tr>
                        </thead>

                        <tbody align="center" style="border-top:none;" id="origins_body_list">
                        <?php
                            if($origins){
                                foreach($origins AS $i=>$origin){
                                    $attachments = $origin["attachments"];
                                    $ctime       = DateManager::format("Y-m-d H:i",$origin["ctime"]);
                                    $approved    = DateManager::format("Y-m-d H:i",$origin["approved_date"]);
                                    $ctime       = str_replace(" ","T",$ctime);
                                    $approved    = str_replace(" ","T",$approved);
                                    $apped       = substr($origin["approved_date"],0,4)=="1881" ? false : true;
                                    ?>
                                    <tr style="background:none;">
                                        <td align="left"><?php echo $i; ?></td>
                                        <td align="left">
                                            <input type="hidden" id="origin_<?php echo $origin["id"]; ?>_name" value="<?php echo $origin["name"]; ?>">
                                            <input type="hidden" id="origin_<?php echo $origin["id"]; ?>_status" value="<?php echo $origin["status"]; ?>">
                                            <textarea style="display: none;" id="origin_<?php echo $origin["id"]; ?>_status_message"><?php echo $origin["status_message"]; ?></textarea>

                                            <input type="hidden" id="origin_<?php echo $origin["id"]; ?>_cdate" value="<?php echo $ctime; ?>">
                                            <input type="hidden" id="origin_<?php echo $origin["id"]; ?>_approved_date" value="<?php echo $apped ? $approved : ''; ?>">

                                            <strong><?php echo $origin["name"]; ?></strong>
                                        </td>
                                        <td align="center">
                                            <?php
                                                if($attachments){
                                                    foreach($attachments AS $attachment){
                                                        ?>
                                                        <a class="sbtn" href="<?php echo $attachment["link"]; ?>" title="<?php echo $attachment["file_name"]; ?>" target="_blank"><i class="fa fa-link" aria-hidden="true"></i></a>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                            <a class="sbtn blue" href="<?php echo Controllers::$init->AdminCRLink("tools-1",["addons"]); ?>?operation=get_addon_content&module=InteraktifSMS&action=download_origin&id=<?php echo $origin["id"]; ?>" title="Tüm Dosyaları İndir" target="_blank"><i class="fa fa-link" aria-hidden="true"></i></a>
                                        </td>
                                        <td align="center">
                                            <?php echo $origin["status_message"]; ?>
                                        </td>
                                        <td align="center">
                                            <?php echo $origin_situations[$origin["status"]]; ?>
                                        </td>
                                        <td align="center">
                                            <?php if($privOperation && $origin["status"] != "active"): ?>
                                                <a href="javascript:activeOrigin(<?php echo $origin["id"]; ?>);void 0;" data-tooltip="Onayla" class="green sbtn"><i class="fa fa-check" aria-hidden="true"></i></a>
                                            <?php endif; ?>

                                            <?php if($privOperation && $origin["status"] != "inactive"): ?>
                                                <a href="javascript:inactiveOrigin(<?php echo $origin["id"]; ?>);void 0;" data-tooltip="Pasif Et" class="orange sbtn"><i class="fa fa-ban" aria-hidden="true"></i></a>
                                            <?php endif; ?>

                                            <a href="javascript:editOrigin(<?php echo $origin["id"]; ?>);void 0;" data-tooltip="Düzenle" class="sbtn"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                            <?php if($privDelete): ?>
                                                <a href="javascript:deleteOrigin(<?php echo $origin["id"]; ?>);void 0;" data-tooltip="Sil" class="red sbtn"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                            <?php endif; ?>
                                        </td>

                                    </tr>
                                    <?php
                                }
                            }
                        ?>

                        </tbody>
                    </table>

                    <div id="editOrigin" style="display: none;" data-izimodal-title="Başlık Düzenle">
                        <div class="padding20">

                            <form action="<?php echo $links["orders"]; ?>" method="post" id="editOrigin" enctype="multipart/form-data">
                                <input type="hidden" name="operation" value="update_sms_origin">
                                <input type="hidden" name="oid" id="origin_id" value="">

                                <div class="formcon">
                                    <div class="yuzde30">Durum</div>
                                    <div class="yuzde70">

                                        <input type="radio" name="status" value="waiting" class="radio-custom" id="origin_status_waiting">
                                        <label class="radio-custom-label" for="origin_status_waiting" style="margin-right: 15px;">Onay Bekliyor</label>

                                        <input type="radio" name="status" value="active" class="radio-custom" id="origin_status_active">
                                        <label class="radio-custom-label" for="origin_status_active" style="margin-right: 15px;">Aktif</label>
                                        <input type="radio" name="status" value="inactive" class="radio-custom" id="origin_status_inactive">
                                        <label class="radio-custom-label" for="origin_status_inactive" style="margin-right: 15px;">Pasif</label>
                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30">Başlık</div>
                                    <div class="yuzde70">
                                        <input type="text" name="name" value="" id="origin_name">
                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30">Açıklama</div>
                                    <div class="yuzde70">
                                        <select onchange="$('#origin_status_message').val($(this).val());">
                                            <option value="">--Şablon Seçiniz--</option>
                                            <?php
                                                if(___("constants/category-sms/op_notes")){
                                                    foreach(___("constants/category-sms/op_notes") AS $item){
                                                        ?><option value="<?php echo htmlentities($item["description"],ENT_QUOTES); ?>"><?php echo $item["title"];?></option><?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                        <textarea name="status_message" value="" id="origin_status_message"></textarea>
                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30">Evrak Yükle</div>
                                    <div class="yuzde70">
                                        <input id="origin_attachments" name="attachments[]" type="file" multiple>
                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30">Oluşturma Tarihi</div>
                                    <div class="yuzde70">
                                        <input style="width: 200px;" id="origin_cdate" name="cdate" type="datetime-local" placeholder="Yıl-Ay-Gün Saat:Dakika">
                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30">Onaylanma Tarihi</div>
                                    <div class="yuzde70">
                                        <input style="width: 200px;" id="origin_approved_date" name="approwed_date" type="datetime-local" placeholder="Yıl-Ay-Gün Saat:Dakika">
                                    </div>
                                </div>

                                <?php if($privOperation): ?>
                                    <div style="float:right;margin-bottom:20px;" class="guncellebtn yuzde30">
                                        <a id="editOrigin_submit" class="yesilbtn gonderbtn" href="javascript:void(0);"><?php echo __("admin/orders/update-button"); ?></a>
                                    </div>
                                <?php endif; ?>

                            </form>
                            <script type="text/javascript">
                                $(document).ready(function(){

                                    $("#editOrigin_submit").on("click",function(){
                                        MioAjaxElement($(this),{
                                            waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                                            progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                                            result:"editOrigin_handler",
                                        });
                                    });

                                });

                                function editOrigin_handler(result){
                                    if(result != ''){
                                        var solve = getJson(result);
                                        if(solve !== false){
                                            if(solve.status == "error"){
                                                if(solve.for != undefined && solve.for != ''){
                                                    $("#editOrigin "+solve.for).focus();
                                                    $("#editOrigin "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                                    $("#editOrigin "+solve.for).change(function(){
                                                        $(this).removeAttr("style");
                                                    });
                                                }
                                                if(solve.message != undefined && solve.message != '')
                                                    alert_error(solve.message,{timer:5000});
                                            }else if(solve.status == "successful"){
                                                alert_success(solve.message,{timer:2000});
                                                table.ajax.reload();
                                            }
                                        }else
                                            console.log(result);
                                    }
                                }
                            </script>

                        </div>
                    </div>

                    <script type="text/javascript">
                        function editOrigin(id){
                            open_modal("editOrigin");
                            var status          = $("#origin_"+id+"_status").val();
                            var name            = $("#origin_"+id+"_name").val();
                            var status_message  = $("#origin_"+id+"_status_message").val();
                            var cdate           = $("#origin_"+id+"_cdate").val();
                            var approved_date   = $("#origin_"+id+"_approved_date").val();

                            $("#origin_id").val(id);
                            $("#editOrigin input[name=status]").prop("checked",false);
                            $("#origin_status_"+status).prop("checked",true);
                            $("#origin_name").val(name);
                            $("#origin_status_message").val(status_message);
                            $("#origin_cdate").val(cdate);
                            $("#origin_approved_date").val(approved_date);
                        }

                        function deleteOrigin(id){

                            swal({
                                title: 'Başlık Sil',
                                text: "Başlığı gerçekten silmek istiyor musunuz?",
                                type: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Evet',
                                cancelButtonText: 'Hayır'
                            }).then(function(){

                                var request = MioAjax({
                                    action:"<?php echo $links["controller"];?>",
                                    method:"POST",
                                    data:{operation:"status_sms_origin",id:id,status:"delete"}
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
                                                    title: 'Silindi',
                                                    text: 'Başlık başarıyla silinmiştir.',
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

                        function inactiveOrigin(id){

                            swal({
                                title: 'Başlığı Pasif Et',
                                type: 'info',
                                html:
                                '<p>Açıklama: (İsteğe bağlı)</p>'+
                                '<select onchange="$(\'#notu\').val($(this).val());">'+
                                '<option value="">--Şablon Seçiniz--</option>'+
                                <?php
                                    if(___("constants/category-sms/op_notes")){
                                    foreach(___("constants/category-sms/op_notes") AS $item){
                                    ?>'<option value="<?php echo htmlentities($item["description"], ENT_QUOTES); ?>"><?php echo $item["title"];?></option>'+<?php echo "\n";
                                }
                                }
                                ?>
                                '</select>'+
                                '<textarea rows="4" id="notu"></textarea>',
                                showCloseButton: true,
                                showCancelButton: true,
                                focusConfirm: false,
                                confirmButtonText: 'Pasif Et',
                                cancelButtonText: 'İptal',
                            }).then(function(){

                                var notu = $("#notu").val();

                                var request = MioAjax({
                                    action:"<?php echo $links["controller"];?>",
                                    method:"POST",
                                    data:{
                                        operation:"status_sms_origin",
                                        id:id,
                                        status:"inactive",
                                        note:notu,
                                    }
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
                                                    title: 'Pasif Edildi',
                                                    text: 'Başlık başarıyla pasif edilmiştir.',
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

                        function activeOrigin(id){
                            var request = MioAjax({
                                action:"<?php echo $links["controller"];?>",
                                method:"POST",
                                data:{operation:"status_sms_origin",id:id,status:"active"}
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
                                                title: 'Onaylandı',
                                                text: 'Başlık başarıyla onaylanmıştır.',
                                                type: 'success',
                                                showConfirmButton: false,
                                                timer: timer,
                                            });
                                        }
                                    }else
                                        console.log(res);
                                }
                            });
                        }
                    </script>
                    <div class="clear"></div>
                </div><!-- origins tab content end -->


                <div id="content-reports" class="tabcontent"><!-- reports tab content start -->



                    <script type="text/javascript">
                        var table;
                        $(document).ready(function() {

                            table = $('#reports').DataTable({
                                "columnDefs": [
                                    {
                                        "targets": [0],
                                        "visible":false,
                                        "searchable": false
                                    },
                                    {
                                        "targets": [1,2,3,4,5],
                                        orderable:false,
                                    }
                                ],
                                "aaSorting" : [[0, 'asc']],
                                "lengthMenu": [
                                    [10, 25, 50, -1], [10, 25, 50, "<?php echo ___("needs/allOf"); ?>"]
                                ],
                                "bProcessing": true,
                                "bServerSide": true,
                                "sAjaxSource": "<?php echo $links["ajax-reports"]; ?>",
                                responsive: true,
                                "language":{"url":"<?php echo APP_URI; ?>/<?php echo ___("package/code"); ?>/datatable/lang.json"}
                            });
                        });
                    </script>

                    <style>
                        #reports tbody tr td:nth-child(4) { text-align: left;}
                    </style>

                    <table id="reports" width="100%">
                        <thead style="background:#ebebeb;">
                        <tr>
                            <th align="left">#</th>
                            <th align="center"><?php echo __("website/account_products/reports-table-field1"); ?></th>
                            <th align="center"><?php echo __("website/account_products/reports-table-field2"); ?></th>
                            <th align="center">GSM No</th>
                            <th align="left"><?php echo __("website/account_products/reports-table-field4"); ?></th>
                            <th align="center">Toplam Kredi</th>
                            <th align="center"><?php echo __("website/account_products/reports-table-field5"); ?></th>
                        </tr>
                        </thead>
                        <tbody align="center" style="border-top:none;">

                        </tbody>
                    </table>

                    <script type="text/javascript">
                        function showMessage(id){
                            open_modal('showMessage');
                            $("#showText").html($("#show_message_"+id).html());
                        }
                    </script>

                    <div style="display: none;" id="showMessage" data-izimodal-title="<?php echo __("website/account_products/report-message-content"); ?>">
                        <div class="padding20" id="showText">

                        </div>
                    </div>

                    <div id="loading-container" style="display: none;">
                        <div align="center">
                            <h4><img src="<?php echo $sadress; ?>assets/images/loading.gif"><br><?php echo __("website/account_products/loading-report-data"); ?></h4>
                        </div>
                    </div>
                    <div id="getReport" style="display: none;" data-izimodal-title="<?php echo __("website/account_products/status-report"); ?>">
                        <div class="padding20">

                        </div>
                    </div>
                    <div id="ReportTemplate" style="display:none;">
                        <div class="durumraportable">
                            <table width="100%" border="0" align="center">
                                <thead>
                                <tr>
                                    <td width="33%" align="center" bgcolor="#D6FE81" style="color:#4B7001"><strong><?php echo __("website/account_products/report-delivered"); ?> ({delivered_count})</strong></td>
                                    <td width="33%" align="center" bgcolor="#C6FFFF" style="color:#009393"><strong><?php echo __("website/account_products/report-expect"); ?> ({expect_count})</strong></td>
                                    <td width="33%" align="center" bgcolor="#FFCACA" style="color:#970000"><strong><?php echo __("website/account_products/report-incorrect"); ?> ({incorrect_count})</strong></td>
                                </tr>
                                </thead>
                                <tbody>

                                <tr>
                                    <td width="33%" align="center" style="color:#689A01">{conducted_number}</td>
                                    <td width="33%" align="center" style="color:#009393">{waiting_number}</td>
                                    <td width="33%" align="center" style="color:#AE0000">{erroneous_number}</td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <script type="text/javascript">
                        function getReportDetail(id) {
                            $("#getReport .padding20").html($("#loading-container").html());

                            open_modal('getReport');

                            var data = MioAjax({
                                action: "<?php echo $links["controller"]; ?>",
                                method: "POST",
                                data:{
                                    operation:"get_sms_report",
                                    id:id,
                                },
                            },true,true);

                            data.done(function(result){
                                if(result != ''){
                                    var solve = getJson(result);
                                    if(solve !== false){
                                        if(solve.status == "successful"){
                                            var template = $("#ReportTemplate").html();

                                            template = template.replace("{delivered_count}",solve.conducted_count);
                                            template = template.replace("{expect_count}",solve.waiting_count);
                                            template = template.replace("{incorrect_count}",solve.erroneous_count);
                                            var item = $("tbody",template).html(),content,contents = '';
                                            $(solve.items).each(function(k,v){
                                                content = item;
                                                content = content.replace("{conducted_number}",v.conducted);
                                                content = content.replace("{waiting_number}",v.waiting);
                                                content = content.replace("{erroneous_number}",v.erroneous);
                                                contents += content;
                                            });

                                            template = $(template);
                                            $("tbody",template).html(contents);

                                            $("#getReport .padding20").html(template);
                                        }
                                    }else
                                        console.log(result);
                                }else
                                    console.log("result is empty");
                            });
                        }
                    </script>

                    <div class="clear"></div>


                </div><!-- reports tab content end -->

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
                                            <?php echo DateManager::format(
                                                Config::get("options/date-format")." H:i",$row["cdate"])?>
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


            </div><!-- tab wrap content end -->


            <div class="clear"></div>
        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>