<!DOCTYPE html>
<html>
<head>
    <?php

        $plugins    = ['dataTables'];
        include __DIR__.DS."inc".DS."head.php";
    ?>
    <script type="text/javascript">
        var table;
        $(document).ready(function(){

            table = $('#remindersTable').DataTable({
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
                "sAjaxSource": "<?php echo $links["ajax-reminders"]; ?>",
                responsive: true,
                "oLanguage":<?php include __DIR__.DS."datatable-lang.php"; ?>
            });

        });
    </script>


    <script type="text/javascript">
        $(document).ready(function(){

            $("#manageModal").on("click","#manageForm_submit",function(){
                MioAjaxElement($(this),{
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                    result:"manageForm_handler",
                });
            });

        });

        function manageForm_handler(result){
            if(result != ''){
                var solve = getJson(result);
                if(solve !== false){
                    if(solve.status == "error"){
                        if(solve.for != undefined && solve.for != ''){
                            $("#manageModal #manageForm "+solve.for).focus();
                            $("#manageModal #manageForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                            $("#manageModal #manageForm "+solve.for).change(function(){
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

        function deleteReminder(id){

            if(typeof id == "object" && id.length>1){
                $("#password_wrapper").css("display","block");
            }else
                $("#password_wrapper").css("display","none");

            $("#password1").val('');

            open_modal("deleteModal",{
                title:"<?php echo ___("needs/button-delete"); ?>"
            });

            $("#delete_ok").click(function(){
                var password = $('#password1').val();
                var request = MioAjax({
                    button_element:this,
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    action: "<?php echo $links["controller"]; ?>",
                    method: "POST",
                    data: {operation:"delete_reminder",id:id,password:password}
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

        function create_modal(){

            open_modal("manageModal",{
                title: '<?php echo __("admin/tools/reminders-create"); ?>',
            });

            $("#manageForm_submit").html('<?php echo ___("needs/button-create"); ?>');

            $("#manageModal input[name=id]").val('0');
            $("#manageModal input[name=operation]").val("add_new_reminder");
            $("#manageModal textarea[name=note]").val('');
            $("#manageModal input[name=period]").prop("checked",false);
            $("#manageModal #period_onetime").prop("checked",true);
            $("#manageModal .period_contents").css("display","none");
            $("#manageModal #period_onetime_contents").css("display","block");
            $("#manageModal input[name=period_datetime]").val('');
            $("#manageModal input[name=period_hour_minute]").val('');
            $("#manageModal select[name=period_month] option").prop('selected',false);
            $("#manageModal select[name=period_day] option").prop('selected',false);
            $("#manageModal input[name=status]").prop('checked',false);
            $("#manageModal #status_active").prop('checked',true);

        }
        function detail_reminder(id){

            open_modal("manageModal",{
                title: '<?php echo __("admin/tools/reminders-view"); ?>',
            });

            $("#manageForm_submit").html('<?php echo ___("needs/button-update"); ?>');

            $("#manageModal input[name=period_datetime]").val('');
            $("#manageModal input[name=period_hour_minute]").val('');
            $("#manageModal select[name=period_month] option").prop('selected',false);
            $("#manageModal select[name=period_day] option").prop('selected',false);
            $("#manageModal input[name=status]").prop('checked',false);
            $("#manageModal #status_active").prop('checked',true);

            $("#manageModal input[name=operation]").val("edit_reminder");
            $("#manageModal input[name=id]").val(id);
            $("#manageModal textarea[name=note]").val($("#row_"+id+" textarea[name=note]").val());
            $("#manageModal input[name=period]").prop("checked",false);
            $("#manageModal #period_"+$("#row_"+id+" input[name=period]").val()).prop("checked",true).trigger("change");

            $("#manageModal input[name=period_datetime]").val($("#row_"+id+" input[name=period_datetime]").val());
            $("#manageModal input[name=period_hour_minute]").val($("#row_"+id+" input[name=period_hour_minute]").val());

            if($("#row_"+id+" input[name=period_day]").val() > -1)
                $("#manageModal select[name=period_day] option[value="+$("#row_"+id+" input[name=period_day]").val()+"]").prop('selected',true);

            if($("#row_"+id+" input[name=period_month]").val() > -1)
                $("#manageModal select[name=period_month] option[value="+$("#row_"+id+" input[name=period_month]").val()+"]").prop('selected',true);

            $("#manageModal input[name=status]").prop('checked',false);
            $("#manageModal #status_"+$("#row_"+id+" input[name=status]").val()).prop('checked',true);

        }
    </script>
</head>
<body>

<div id="deleteModal" style="display: none;">
    <div class="padding20">
        <div align="center">

            <p><?php echo ___("needs/delete-are-you-sure"); ?></p>

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

<div id="manageModal" style="display: none;">
    <div class="padding15">

        <div class="adminpagecon">
            <form id="manageForm" action="<?php echo $links["controller"]; ?>" method="post">
                <input type="hidden" name="operation" value="add_new_reminder">
                <input type="hidden" name="id" value="0">

                <div class="formcon">
                    <div class="yuzde30"><?php echo __("admin/tools/reminders-note"); ?></div>
                    <div class="yuzde70">
                        <textarea name="note" rows="5"></textarea>
                    </div>
                </div>

                <div class="formcon">
                    <div class="yuzde30"><?php echo __("admin/tools/reminders-status"); ?></div>
                    <div class="yuzde70">
                        <?php
                            if(isset($situations) && $situations){
                                foreach($situations AS $key=>$val){
                                    $val = Filter::html_clear($val);
                                    ?>
                                    <input<?php echo $key == "active" ? ' checked' : ''; ?> type="radio" class="radio-custom" id="status_<?php echo $key; ?>" name="status" value="<?php echo $key; ?>">
                                    <label class="radio-custom-label" for="status_<?php echo $key; ?>" style="margin-left:10px;"><?php echo $val; ?></label>
                                    <?php
                                }
                            }
                        ?>
                    </div>
                </div>

                <div class="formcon">
                    <div class="yuzde30"><?php echo __("admin/tools/reminders-period"); ?></div>
                    <div class="yuzde70">

                        <input checked type="radio" class="radio-custom" name="period" value="onetime" id="period_onetime" onchange="if($(this).prop('checked')) $('.period_contents').css('display','none'),$('#period_onetime_contents').css('display','block');">
                        <label class="radio-custom-label" for="period_onetime" style="margin-left: 10px;"><?php echo __("admin/tools/reminders-period-onetime"); ?></label>

                        <input type="radio" class="radio-custom" name="period" value="recurring" id="period_recurring" onchange="if($(this).prop('checked')) $('.period_contents').css('display','none'),$('#period_recurring_contents').css('display','block');">
                        <label class="radio-custom-label" for="period_recurring" style="margin-left: 10px;"><?php echo __("admin/tools/reminders-period-recurring"); ?></label>

                    </div>
                </div>

                <div id="period_onetime_contents" class="period_contents">
                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/tools/reminders-period-datetime"); ?></div>
                        <div class="yuzde70">
                            <input type="datetime-local" name="period_datetime" value="">
                        </div>
                    </div>
                </div>

                <div id="period_recurring_contents" class="period_contents" style="display: none;">
                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/tools/reminders-period-recurring-dhi"); ?></div>
                        <div class="yuzde70">
                            <select name="period_month" class="yuzde20">
                                <option value="-1"><?php echo ___("date/every-month"); ?></option>
                                <?php
                                    foreach(range(1,12) AS $num){
                                        $num_zero   = $num>9 ? $num : "0".$num;
                                        $month_name = DateManager::month_name($num_zero);
                                        ?>
                                        <option value="<?php echo $num; ?>"><?php echo $month_name; ?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                           <select name="period_day" class="yuzde20">
                               <option value="-1"><?php echo ___("date/every-day"); ?></option>
                               <?php
                                   foreach(range(1,31) AS $num){
                                       ?>
                                       <option value="<?php echo $num; ?>"><?php echo $num; ?></option>
                                       <?php
                                   }
                               ?>
                           </select>
                            <input type="time" name="period_hour_minute" value="" class="yuzde20">
                        </div>
                    </div>
                </div>

                <div class="clear"></div>


                <div style="float:right;margin-top:10px; margin-bottom:10px;" class="guncellebtn yuzde30">
                    <a class="yesilbtn gonderbtn" id="manageForm_submit" href="javascript:void(0);"><?php echo ___("needs/button-create"); ?></a>
                </div>

            </form>
        </div>
        <div class="clear"></div>

    </div>
</div>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1>
                    <strong><?php echo __("admin/tools/page-reminders"); ?></strong>
                </h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="green-info">
                <div class="padding15">
                    <i class="fa fa-info-circle"></i>
                    <p><?php echo __("admin/tools/reminders-desc"); ?></p>
                </div>
            </div>

            <a href="javascript:create_modal(); void 0;" class="green lbtn">+ <?php echo __("admin/tools/reminders-create"); ?></a>

            <div class="clear"></div>
            <br>

            <div id="operation-loading" class="blur-text" style="display: none">
                <i class="fa fa-cog loadingicon" aria-hidden="true"></i>
                <div class="clear"></div>
                <strong><?php echo __("admin/orders/list-row-operation-processing"); ?></strong>
            </div>

            <div id="tableList">
                <table width="100%" id="remindersTable" class="table table-striped table-borderedx table-condensed nowrap">
                    <thead style="background:#ebebeb;">
                    <tr>
                        <th align="left">#</th>
                        <th align="left" data-orderable="false"><?php echo __("admin/tools/reminders-note"); ?></th>
                        <th align="left" data-orderable="false"><?php echo __("admin/tools/reminders-creation-date"); ?></th>
                        <th align="left" data-orderable="false"><?php echo __("admin/tools/reminders-period"); ?></th>
                        <th align="center" data-orderable="false"><?php echo __("admin/tools/reminders-status"); ?></th>
                        <th align="center" data-orderable="false"></th>
                    </tr>
                    </thead>
                    <tbody align="center" style="border-top:none;"></tbody>
                </table>
            </div>


        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>