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
        #datatable tbody tr td:nth-child(1),#datatable tbody tr td:nth-child(2),#datatable tbody tr td:nth-child(3),#datatable tbody tr td:nth-child(4) {
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

            table = $('#datatable').DataTable({
                "columnDefs": [
                    {
                        "targets": [0<?php echo !$privOperation ? ',1' : ''; ?>],
                        "visible":false,
                        "searchable": false
                    }
                ],
                "aaSorting" : [[0, 'asc']],
                "lengthMenu": [
                    [10, 25, 50, -1], [10, 25, 50, "<?php echo ___("needs/allOf"); ?>"]
                ],
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": "<?php echo $links["ajax-updowngrades"]; ?>",
                responsive: true,
                "oLanguage":<?php include __DIR__.DS."datatable-lang.php"; ?>
            });
        });

        function deleteOrder(id){

            if(typeof id == "object" && id.length>1){
                $("#password_wrapper").css("display","block");
            }else
                $("#password_wrapper").css("display","none");

            $("#password1").val('');
            var content1 = "<?php echo __("admin/orders/delete-are-youu-sure-updowngrades"); ?>";
            $("#deleteModal_text1").html(content1);

            open_modal("deleteModal",{
                title:"<?php echo __("admin/orders/delete-modal-title-updowngrades"); ?>"
            });

            $("#delete_ok").click(function(){
                var password = $('#password1').val();
                var request = MioAjax({
                    button_element:this,
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    action: "<?php echo $links["controller"]; ?>",
                    method: "POST",
                    data: {operation:"apply_operation_updowngrades",type:"delete",id:id,password:password}
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
            $("#OrdersList").addClass("tab-blur-content");
            $("#operation-loading").fadeIn(500,function(){
            });

            var request = MioAjax({
                action: "<?php echo $links["controller"]; ?>",
                method: "POST",
                data: {operation:"apply_operation_updowngrades",type:type,id:id}
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

                if(selection == "completed")
                    applyOperation(selection,values);
                else if(selection == "delete"){
                    deleteOrder(values);
                }
            }
        }

        function details(id){
            open_modal("detailsModal",{title:"<?php echo ___("needs/button-detail"); ?>"});

            var type = $("#row_"+id+"_type").html();

            $("#old_product").html($("#row_"+id+"_old_product").html());
            $("#old_renewaldate").html($("#row_"+id+"_old_renewaldate").html());
            $("#old_duedate").html($("#row_"+id+"_old_duedate").html());
            $("#times_used_day").html($("#row_"+id+"_times_used_day").html());
            $("#times_used_amount").html($("#row_"+id+"_times_used_amount").html());
            $("#remaining_day").html($("#row_"+id+"_remaining_day").html());
            $("#remaining_amount").html($("#row_"+id+"_remaining_amount").html());
            $("#"+type+"_content #new_product").html($("#row_"+id+"_new_product").html());
            $("#old_amount_period").html($("#row_"+id+"_old_amount_period").html());
            $("#"+type+"_content #new_amount_period").html($("#row_"+id+"_new_amount_period").html());
            $("#"+type+"_content #difference_amount").html($("#row_"+id+"_difference_amount").html());
            $("#ctime").html($("#row_"+id+"_ctime").html());
            $("#status").html($("#row_"+id+"_status").html());
            $("#refund").html($("#row_"+id+"_refund").html());
            if($("#row_"+id+"_taxation").html()==1)
                $("#taxation").css("display","inline-block");
            else
                $("#taxation").css("display","none");


            $(".updown-type-cotents").css("display","none");
            $("#"+type+"_content").css("display","block");

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

<div id="detailsModal" style="display: none;">
    <div class="padding20">
        <div align="center">


            <div class="formcon">
                <div class="yuzde30"><?php echo __("admin/orders/updown-statistics"); ?>
                    <div class="clear"></div>
                    <span class="kinfo"><?php echo __("admin/orders/updown-statistics-info"); ?></span>
                </div>
                <div class="yuzde70">

                    <div class="formcon">
                        <span class="updownstitle"><?php echo __("admin/orders/updown-statistics-name"); ?>:</span>
                        <span id="old_product"></span>
                    </div>

                    <div class="formcon">
                        <span class="updownstitle"><?php echo __("admin/orders/updown-upgrade-pricing"); ?>:</span>
                        <span id="old_amount_period"></span>
                    </div>

                    <div class="formcon">
                        <span class="updownstitle"><?php echo __("admin/orders/updown-statistics-renewal-date"); ?>:</span>
                        <span id="old_renewaldate"></span>
                    </div>

                    <div class="formcon">
                        <span class="updownstitle"><?php echo __("admin/orders/updown-statistics-due-date"); ?>:</span>
                        <span id="old_duedate"></span>
                    </div>

                    <div class="formcon">
                        <span class="updownstitle"><?php echo __("admin/orders/updown-statistics-times-used"); ?>:</span>
                        <span id="times_used_day"></span> <?php echo ___("date/day"); ?> (<strong id="times_used_amount"></strong>)
                    </div>

                    <div class="formcon">
                        <span class="updownstitle"><?php echo __("admin/orders/updown-statistics-remaining-day"); ?>:</span>
                        <span id="remaining_day"></span> <?php echo ___("date/day"); ?> (<strong style="color:#f44336;" id="remaining_amount"></strong>)
                    </div>

                </div>
            </div>


            <div id="up_content" class="formcon updown-type-cotents" style="display: none;">

                <div class="formcon">
                <div class="yuzde30"><?php echo __("admin/orders/updown-upgrade-information"); ?></div>
                <div class="yuzde70">

                    <div class="formcon">
                        <span class="updownstitle"><?php echo __("admin/orders/updown-upgrade-product"); ?>:</span>
                        <span id="new_product"></span>
                    </div>


                    <div class="formcon">
                        <span class="updownstitle"><?php echo __("admin/orders/updown-upgrade-pricing"); ?>:</span>
                        <span id="new_amount_period"></span>
                    </div>

                </div>
                </div>



                <div class="formcon">
                <div class="yuzde30"><span><?php echo __("admin/orders/updown-upgrade-difference-amount"); ?>:</span></div>
                <div class="yuzde70">
                	<strong style="color:#4caf50;font-size: 18px;" id="difference_amount"></strong>
                    <span id="taxation" style="display: none;"><?php echo __("admin/orders/updown-upgrade-difference-amount-taxed"); ?></span>
                	<i class="kinfo"><?php echo __("admin/orders/updown-upgrade-difference-amount-info"); ?></i>
                </div>
                </div>

            </div>

            <div id="down_content" class="formcon updown-type-cotents" style="display: none;">

               <div class="formcon">
                <div class="yuzde30"><?php echo __("admin/orders/updown-downgrade-information"); ?></div>
                <div class="yuzde70">

                    <div class="formcon">
                        <span class="updownstitle"><?php echo __("admin/orders/updown-downgrade-product"); ?>:</span>
                        <span id="new_product"></span>
                    </div>


                    <div class="formcon">
                        <span class="updownstitle"><?php echo __("admin/orders/updown-downgrade-pricing"); ?>:</span>
                        <span id="new_amount_period"></span>
                    </div>

                </div>
                </div>



                <div class="formcon">
                <div class="yuzde30"><span><?php echo __("admin/orders/updown-downgrade-difference-amount"); ?>:</span></div>
                <div class="yuzde70">
                	<strong style="color:#f44336;    font-size: 18px;" id="difference_amount"></strong>
                	<span class="kinfo"> <?php echo __("admin/orders/updown-downgrade-difference-amount-info"); ?></span>
                </div>
                </div>

                 <div class="formcon">
                <div class="yuzde30"><span><?php echo __("admin/orders/updown-refund"); ?></span></div>
                <div class="yuzde70">
                	<span id="refund"></span>
                </div>
                </div>

            </div>


            <div class="formcon">
                <div class="yuzde30"><span><?php echo __("admin/orders/list-status"); ?></span></div>
                <div class="yuzde70">
                    <span id="status"></span>
                </div>
            </div>


            <div class="formcon">
                <div class="yuzde30"><span><?php echo __("admin/orders/updowngrades-cdate"); ?></span></div>
                <div class="yuzde70">
                    <span id="ctime"></span>
                </div>
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
                    <strong><?php echo __("admin/orders/page-updowngrades"); ?></strong>
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
                        <option value="completed"><?php echo __("admin/orders/updowngrades-apply-to-selected-complete"); ?></option>
                        <?php if($privDelete): ?>
                            <option value="delete"><?php echo __("admin/orders/updowngrades-apply-to-selected-delete"); ?></option>
                        <?php endif; ?>
                    </select>
                <?php endif; ?>

                <div class="clear"></div>
                <br>

                <table width="100%" id="datatable" class="table table-striped table-borderedx table-condensed nowrap">
                    <thead style="background:#ebebeb;">
                    <tr>
                        <th align="left">#</th>
                        <th data-orderable="false" align="left">
                            <input type="checkbox" class="checkbox-custom" id="allSelect" onchange="$('.selected-item').prop('checked',$(this).prop('checked'));"><label for="allSelect" class="checkbox-custom-label"></label>
                        </th>
                        <th data-orderable="false" align="left"><?php echo __("admin/orders/list-customer-name"); ?></th>
                        <th data-orderable="false" align="left"><?php echo __("admin/orders/updowngrades-old-product"); ?></th>
                        <th data-orderable="false" align="left"><?php echo __("admin/orders/updowngrades-new-product"); ?></th>
                        <th data-orderable="false" align="center"><?php echo __("admin/orders/updowngrades-difference-amount"); ?></th>
                        <th data-orderable="false" align="center"><?php echo __("admin/orders/updowngrades-type"); ?></th>
                        <th data-orderable="false" align="center"><?php echo __("admin/orders/updowngrades-invoice"); ?></th>
                        <th data-orderable="false" align="center"><?php echo __("admin/orders/list-status"); ?></th>
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