<?php
    $privOperation  = Admin::isPrivilege("INVOICES_OPERATION");
    $privDelete     = Admin::isPrivilege("INVOICES_DELETE");

    $bring  = Filter::init("GET/bring","route");
    if($bring){

        if($bring == "amount-statistics"){

            if(isset($start)){ ?>
                <h5><?php echo __("admin/invoices/cash-selected-between-amount"); ?></h5>
                <h5><?php echo __("admin/invoices/cash-row-type-income"); ?>: <strong style="color: #81c04e;"><?php echo $income_amount; ?></strong></h5>
                <h5><?php echo __("admin/invoices/cash-row-type-expense"); ?>: <strong style="color: red;"><?php echo $expense_amount; ?></strong></h5>

            <?php }elseif($search){ ?>

            <?php }else{ ?>
                <h5><?php echo __("admin/invoices/cash-this-month-income-amount"); ?>: <strong style="color:#81c04e;"><?php echo $income_amount; ?></strong></h5>
                <h5><?php echo __("admin/invoices/cash-this-month-expense-amount"); ?>: <strong style="color:red;"><?php echo $expense_amount; ?></strong></h5>
            <?php }
        }
        elseif($bring == "this-amount"){
            echo $thisAmount;
        }
        elseif($bring == "periodic-outgoings"){
            if(isset($periodicOutgoings) && $periodicOutgoings){
                foreach($periodicOutgoings AS $row){
                    $period_day             = $row["period_day"];
                    $row["period_hour"]     = $row["period_hour"] > 9 ? $row["period_hour"] : "0".$row["period_hour"];
                    $row["period_minute"]   = $row["period_minute"] > 9 ? $row["period_minute"] : "0".$row["period_minute"];
                    $short_desc             = Utility::short_text($row["description"],0,18,true);
                    $show_period            = __("admin/invoices/periodic-outgoings-pshow",[
                        '{day}' => $period_day,
                        '{time}' => $row["period_hour"].":".$row["period_minute"],
                    ]);
                    ?>
                    <tr>
                        <td align="left">

                            <form id="outgoing_<?php echo $row["id"]; ?>" style="display: none">
                                <textarea name="description"><?php echo $row["description"]; ?></textarea>
                                <input type="hidden" name="amount" value="<?php echo Money::formatter($row["amount"],$row["currency"]); ?>">
                                <input type="hidden" name="currency" value="<?php echo $row["currency"]; ?>">
                                <input type="hidden" name="period_day" value="<?php echo $period_day; ?>">
                                <input type="hidden" name="period_hour" value="<?php echo $row["period_hour"]; ?>">
                                <input type="hidden" name="period_minute" value="<?php echo $row["period_minute"]; ?>">
                            </form>
                            <span title="<?php echo htmlentities($row["description"],ENT_QUOTES); ?>"><?php echo $short_desc; ?></span>
                        </td>
                        <td align="center">
                            <?php echo $show_period; ?>
                        </td>
                        <td align="center"><?php echo Money::formatter_symbol($row["amount"],$row["currency"]); ?></td>
                        <?php if($privOperation): ?>
                            <td align="center">
                                <a href="javascript:editOutgoing(<?php echo $row["id"]; ?>);void 0;" class="sbtn"><i class="fa fa-pencil-square-o"></i></a>
                                <a class="red sbtn" href="javascript:void 0;" onclick="deleteOutgoing(<?php echo $row["id"]; ?>,this);"><i class="fa fa-trash-o"></i></a>
                            </td>
                        <?php endif; ?>
                    </tr>
                    <?php
                }
            }else{
                ?>
                <tr>
                    <td colspan="3" align="center">
                        <span class="error"><?php echo __("admin/invoices/periodic-outgoings-none"); ?></span>
                    </td>
                </tr>
                <?php
            }
        }

        die();
    }
?>
<!DOCTYPE html>
<html>
<head>
    <?php
        if(!isset($search)) $search = false;
        $search_query   = [];
        if(isset($search) && $search){
            $search_query["search"] = "true";
            if(isset($word) && $word) $search_query["word"] = $word;
            if(isset($start) && $start) $search_query["start"] = $start;
            if(isset($end) && $end) $search_query["end"] = $end;
        }
        $search_query   = http_build_query($search_query);

        $plugins    = ['dataTables'];
        include __DIR__.DS."inc".DS."head.php";
    ?>
    <script type="text/javascript">
        var table;
        $(document).ready(function(){

            table = $('#datatable').DataTable({
                "columnDefs": [
                    {
                        "targets": [0],
                        "visible":false,
                    },
                ],
                "pageLength": 30,
                "bLengthChange" : false,
                "bInfo":false,
                "searching": false,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": "<?php echo $links["ajax"]; echo $search_query ?  "?".$search_query : ''; ?>",
                responsive: true,
                "oLanguage":<?php include __DIR__.DS."datatable-lang.php"; ?>
            });

        });

        function addCash(){
            open_modal('manageCash');
            $("#manageForm input[name=operation]").val('add_cash');
            $("#manageForm input[name=amount]").val('');
            $("#manageForm select[name=currency] option").removeAttr("selected");
            $("#manageForm input[name=type]").prop("checked",false);
            $("#manageForm input[name=type]:eq(0)").prop("checked",true);
            $("#manageForm textarea").val('');
            $("#manageForm_submit").html('<?php echo ___("needs/button-add"); ?>');
        }

        function editCash(id){
            open_modal('manageCash');

            var amount          = $("#manage_"+id+" input[name=amount]").val();
            var currency        = $("#manage_"+id+" input[name=currency]").val();
            var type            = $("#manage_"+id+" input[name=type]").val();
            var description     = $("#manage_"+id+" textarea[name=description]").val();
            var cdate           = $("#manage_"+id+" input[name=cdate]").val();
            var ctime           = $("#manage_"+id+" input[name=ctime]").val();

            $("#manageForm input[name=operation]").val('edit_cash');
            $("#manageForm input[name=id]").val(id);
            $("#manageForm input[name=amount]").val(amount);
            $("#manageForm select[name=currency] option").removeAttr("selected");
            $("#manageForm select[name=currency] option[value='"+currency+"']").attr("selected",true);
            $("#manageForm input[name=type]").prop("checked",false);
            $("#manageForm #type_"+type).prop("checked",true);
            $("#manageForm textarea").val(description);
            $("#manageForm input[name=cdate]").val(cdate);
            $("#manageForm input[name=ctime]").val(ctime);
            $("#manageForm_submit").html('<?php echo ___("needs/button-save"); ?>');
        }

        function deleteCash(id){
            open_modal("ConfirmModal",{
                title:"<?php echo __("admin/invoices/delete-modal-title-cash"); ?>"
            });

            $("#delete_ok").click(function(){
                var request = MioAjax({
                    button_element:$(this),
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    action: "<?php echo $links["controller"]; ?>",
                    method: "POST",
                    data: {operation:"delete_cash",id:id}
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
                                    alert_success(solve.message,{timer:3000});
                                    reload_amount_statistics();
                                    close_modal("ConfirmModal");
                                    var elem  = $("#delete_"+id).parent().parent();
                                    table.row(elem).remove().draw();
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
    </script>
</head>
<body>

<div id="ConfirmModal" style="display: none;">
    <div class="padding20">
        <p id="confirmModal_text"><?php echo __("admin/invoices/delete-are-you-sure"); ?></p>
    </div>
    <div class="modal-foot-btn">
        <a id="delete_ok" href="javascript:void(0);" class="red lbtn"><?php echo ___("needs/yes"); ?></a>
    </div>
</div>

<div id="manageCash" style="display: none;" data-izimodal-title="<?php echo __("admin/invoices/add-cash-button"); ?>">
    <div class="padding20">

        <form action="<?php echo $links["controller"]; ?>" method="post" id="manageForm">
            <input type="hidden" name="operation" value="add_cash">
            <input type="hidden" name="id" value="0">

            <div class="formcon">
                <div class="yuzde30"><?php echo __("admin/invoices/cash-manage-amount"); ?></div>
                <div class="yuzde70">
                    <input class="yuzde30" type="text" name="amount" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57'>
                    <select name="currency" class="yuzde40">
                        <?php
                            foreach(Money::getCurrencies() AS $row){
                                ?>
                                <option value="<?php echo $row["id"]; ?>"><?php echo $row["name"]." (".$row["code"].")"; ?></option>
                                <?php
                            }
                        ?>
                    </select>
                </div>
            </div>


            <div class="formcon">
                <div class="yuzde30"><?php echo __("admin/invoices/cash-manage-type"); ?></div>
                <div class="yuzde70">
                    <input checked class="radio-custom" type="radio" name="type" value="income" id="type_income">
                    <label for="type_income" class="radio-custom-label" style="margin-right: 10px;color:green;"><?php echo __("admin/invoices/cash-row-type-income"); ?></label>

                    <input class="radio-custom" type="radio" name="type" value="expense" id="type_expense">
                    <label for="type_expense" class="radio-custom-label" style="margin-right: 10px;color:red;"><?php echo __("admin/invoices/cash-row-type-expense"); ?></label>
                </div>
            </div>

            <div class="formcon">
                <div class="yuzde30"><?php echo __("admin/invoices/cash-manage-description"); ?></div>
                <div class="yuzde70">
                    <textarea name="description"></textarea>
                </div>
            </div>

            <div class="formcon">
                <div class="yuzde30"><?php echo __("admin/invoices/cash-manage-date"); ?></div>
                <div class="yuzde70">
                    <input type="date" name="cdate" value="<?php echo DateManager::Now("Y-m-d"); ?>" style="width: 150px;">
                    <input type="time" name="ctime" value="<?php echo DateManager::Now("H:i"); ?>" style="width: 150px;">
                </div>
            </div>

            <div class="clear"></div>

            <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                <a class="yesilbtn gonderbtn" id="manageForm_submit" href="javascript:void(0);"><?php echo ___("needs/button-add"); ?></a>
            </div>

        </form>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#manageForm_submit").on("click",function(){
                    MioAjaxElement($(this),{
                        waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
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
                                $("#manageForm "+solve.for).focus();
                                $("#manageForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                $("#manageForm "+solve.for).change(function(){
                                    $(this).removeAttr("style");
                                });
                            }
                            if(solve.message != undefined && solve.message != '')
                                alert_error(solve.message,{timer:5000});
                        }else if(solve.status == "successful"){
                            alert_success(solve.message,{timer:2000});
                            reload_amount_statistics();
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

            function reload_amount_statistics(){
                $.get("<?php echo $links["controller"]; ?>?bring=amount-statistics&<?php echo $search_query; ?>",function(result){
                    $("#amount_statistics").html(result);
                });

                $.get("<?php echo $links["controller"]; ?>?bring=this-amount&<?php echo $search_query; ?>",function(result){
                    $("#this_amount").html(result);
                });
            }

            function auto_periodic_outgoings(){
                open_modal("auto_periodic_outgoings_modal");
            }
        </script>

        <div class="clear"></div>
    </div>
</div>

<div style="display: none;" id="auto_periodic_outgoings_modal" data-izimodal-title="<?php echo __("admin/invoices/auto-periodic-outgoings-button"); ?>">
    <div class="padding20">

        <script type="text/javascript">
            $(document).ready(function(){

                $("#addOutgoingForm_submit").on("click",function(){
                    MioAjaxElement($(this),{
                        waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                        result:"addOutgoingForm_handler",
                    });
                });

                $("#editOutgoingForm_submit").on("click",function(){
                    MioAjaxElement($(this),{
                        waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                        result:"editOutgoingForm_handler",
                    });
                });

            });

            function addOutgoingForm_handler(result){
                if(result != ''){
                    var solve = getJson(result);
                    if(solve !== false){
                        if(solve.status == "error"){
                            if(solve.for != undefined && solve.for != ''){
                                $("#addOutgoingForm "+solve.for).focus();
                                $("#addOutgoingForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                $("#addOutgoingForm "+solve.for).change(function(){
                                    $(this).removeAttr("style");
                                });
                            }
                            if(solve.message != undefined && solve.message != '')
                                alert_error(solve.message,{timer:5000});
                        }else if(solve.status == "successful"){

                            $.get("<?php echo $links["controller"]."?bring=periodic-outgoings"; ?>", function( data ) {
                                $( "#periodicOutgoings" ).html( data );

                                $("#addOutgoingForm select option").prop("selected",false);
                                $("#addOutgoingForm input[type=text]").val('');
                                $("#addOutgoingForm input[type=time]").val('');
                                $("#addOutgoingForm textarea").val('');

                            });

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

            function editOutgoingForm_handler(result){
                if(result != ''){
                    var solve = getJson(result);
                    if(solve !== false){
                        if(solve.status == "error"){
                            if(solve.for != undefined && solve.for != ''){
                                $("#editOutgoingForm "+solve.for).focus();
                                $("#editOutgoingForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                $("#editOutgoingForm "+solve.for).change(function(){
                                    $(this).removeAttr("style");
                                });
                            }
                            if(solve.message != undefined && solve.message != '')
                                alert_error(solve.message,{timer:5000});
                        }else if(solve.status == "successful"){

                            $.get("<?php echo $links["controller"]."?bring=periodic-outgoings"; ?>", function( data ) {
                                $( "#periodicOutgoings" ).html( data );
                                $("#editOutgoingForm").css("display","none");
                                $("#addOutgoingForm").css("display","block");
                            });

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

            function deleteOutgoing(id,elem){
                var request = MioAjax({
                    button_element:elem,
                    waiting_text:'<i class="fa fa-spinner" style="-webkit-animation:fa-spin 2s infinite linear;animation: fa-spin 2s infinite linear;"></i>',
                    action:"<?php echo $links["controller"]; ?>",
                    method:"POST",
                    data:{operation:"delete_outgoing",id:id}
                },true,true);

                request.done(function (result){
                    if(result != ''){
                        var solve = getJson(result);
                        if(solve !== false){
                            if(solve.status == "error"){
                                if(solve.message != undefined && solve.message != '')
                                    alert_error(solve.message,{timer:5000});
                            }else if(solve.status == "successful"){
                                $.get("<?php echo $links["controller"]."?bring=periodic-outgoings"; ?>", function( data ) {
                                    $( "#periodicOutgoings" ).html( data );
                                    $("#addOutgoingForm").css("display","block");
                                    $("#editOutgoingForm").css("display","none");
                                });

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

            function editOutgoing(id){
                var description     = $("#outgoing_"+id+" textarea[name=description]").val();
                var amount          = $("#outgoing_"+id+" input[name=amount]").val();
                var currency        = $("#outgoing_"+id+" input[name=currency]").val();
                var period_day      = $("#outgoing_"+id+" input[name=period_day]").val();
                var period_hour     = $("#outgoing_"+id+" input[name=period_hour]").val();
                var period_minute   = $("#outgoing_"+id+" input[name=period_minute]").val();
                var hour_minute     = period_hour+":"+period_minute;


                $("#editOutgoingForm input[name=id]").val(id);
                $("#editOutgoingForm textarea[name=description]").val(description);
                $("#editOutgoingForm input[name=amount]").val(amount);
                $("#editOutgoingForm select[name=currency]").prop("selected",false);
                $("#editOutgoingForm select[name=currency] option[value="+currency+"]").prop("selected",true);

                $("#editOutgoingForm select[name=period_day]").prop("selected",false);
                $("#editOutgoingForm select[name=period_day] option[value="+period_day+"]").prop("selected",true);

                $("#editOutgoingForm input[name=period_hour_minute]").val(hour_minute);

                $("#addOutgoingForm").css("display","none");
                $("#editOutgoingForm").css("display","block");

            }
        </script>

        <?php if($privOperation): ?>
            <form action="<?php echo $links["controller"]; ?>" method="post" id="addOutgoingForm">
                <input type="hidden" name="operation" value="add_periodic_outgoing">

                <div class="green-info">
                    <div class="padding15">
                        <i class="fa fa-info-circle"></i>
                        <p><?php echo __("admin/invoices/periodic-outgoings-info"); ?></p>
                    </div>
                </div>

                <div class="formcon">
                    <div class="yuzde30"><?php echo __("admin/invoices/cash-manage-amount"); ?></div>
                    <div class="yuzde70">
                        <input class="yuzde30" type="text" name="amount" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57'>
                        <select name="currency" class="yuzde40">
                            <?php
                                foreach(Money::getCurrencies() AS $row){
                                    ?>
                                    <option value="<?php echo $row["id"]; ?>"><?php echo $row["name"]." (".$row["code"].")"; ?></option>
                                    <?php
                                }
                            ?>
                        </select>
                    </div>
                </div>

           

                <div class="formcon">
                    <div class="yuzde30"><?php echo __("admin/invoices/cash-manage-description"); ?></div>
                    <div class="yuzde70">
                        <textarea name="description"></textarea>
                    </div>
                </div>

                <div class="formcon">
                    <div class="yuzde30"><?php echo __("admin/invoices/periodic-outgoings-period"); ?></div>
                    <div class="yuzde70">
                        <select name="period_day" class="yuzde20">
                            <option value="-1"><?php echo ___("date/day"); ?></option>
                            <?php
                                foreach(range(1,31) AS $num){
                                    ?>
                                    <option value="<?php echo $num; ?>"><?php echo $num; ?></option>
                                    <?php
                                }
                            ?>
                        </select>
                        <input type="time" name="period_hour_minute" value="" class="yuzde20">
                        <br><span class="kinfo"><?php echo __("admin/invoices/periodic-outgoings-dhm"); ?></span>
                    </div>
                </div>

                <div class="clear"></div>

                <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                    <a class="yesilbtn gonderbtn" id="addOutgoingForm_submit" href="javascript:void(0);"><?php echo ___("needs/button-create"); ?></a>
                </div>
                <div class="clear"></div>
                <br>
            </form>
            <form action="<?php echo $links["controller"]; ?>" method="post" id="editOutgoingForm" style="display: none;">
                <input type="hidden" name="operation" value="edit_periodic_outgoing">
                <input type="hidden" name="id" value="0">

                <div class="formcon">
                    <div class="yuzde30"><?php echo __("admin/invoices/cash-manage-amount"); ?></div>
                    <div class="yuzde70">
                        <input class="yuzde30" type="text" name="amount" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57'>
                         <select name="currency" class="yuzde40">
                            <?php
                                foreach(Money::getCurrencies() AS $row){
                                    ?>
                                    <option value="<?php echo $row["id"]; ?>"><?php echo $row["name"]." (".$row["code"].")"; ?></option>
                                    <?php
                                }
                            ?>
                        </select>
                    </div>
                </div>


                <div class="formcon">
                    <div class="yuzde30"><?php echo __("admin/invoices/cash-manage-description"); ?></div>
                    <div class="yuzde70">
                        <textarea name="description"></textarea>
                    </div>
                </div>

                <div class="formcon">
                    <div class="yuzde30"><?php echo __("admin/invoices/periodic-outgoings-period"); ?></div>
                    <div class="yuzde70">
                        <select name="period_day" class="yuzde20">
                            <option value="-1"><?php echo ___("date/day"); ?></option>
                            <?php
                                foreach(range(1,31) AS $num){
                                    ?>
                                    <option value="<?php echo $num; ?>"><?php echo $num; ?></option>
                                    <?php
                                }
                            ?>
                        </select>
                        <input type="time" name="period_hour_minute" value="" class="yuzde20">
                        <br><span class="kinfo"><?php echo __("admin/invoices/periodic-outgoings-dhm"); ?></span>
                    </div>
                </div>

                <div class="clear"></div>

                <div style="float:left;margin-top:10px;" class="guncellebtn yuzde30">
                    <a class="redbtn gonderbtn" id="editOutgoingForm_cancel" href="javascript:$('#editOutgoingForm').css('display','none'),$('#addOutgoingForm').css('display','block');void 0;"><?php echo __("admin/users/button-cancel"); ?></a>
                </div>

                <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                    <a class="yesilbtn gonderbtn" id="editOutgoingForm_submit" href="javascript:void(0);"><?php echo ___("needs/button-update"); ?></a>
                </div>
                <div class="clear"></div>
                <br>
            </form>
        <?php endif; ?>
        <div class="clear"></div>

        <table width="100%" class="table table-striped table-borderedx table-condensed nowrap">
            <thead style="background:#ebebeb;">
            <tr>
                <th align="left"><?php echo __("admin/invoices/periodic-outgoings-description"); ?></th>
                <th align="center"><?php echo __("admin/invoices/periodic-outgoings-period"); ?></th>
                <th align="center"><?php echo __("admin/invoices/periodic-outgoings-amount"); ?></th>
                <?php if($privOperation): ?>
                    <th align="center"> </th>
                <?php endif; ?>
            </tr>
            </thead>
            <tbody align="center" style="border-top:none;" id="periodicOutgoings">
            <?php
                if(isset($periodicOutgoings) && $periodicOutgoings){
                    foreach($periodicOutgoings AS $row){
                        $period_day             = $row["period_day"];
                        $row["period_hour"]     = $row["period_hour"] > 9 ? $row["period_hour"] : "0".$row["period_hour"];
                        $row["period_minute"]   = $row["period_minute"] > 9 ? $row["period_minute"] : "0".$row["period_minute"];
                        $short_desc             = Utility::short_text($row["description"],0,18,true);
                        $show_period            = __("admin/invoices/periodic-outgoings-pshow",[
                                '{day}' => $period_day,
                                '{time}' => $row["period_hour"].":".$row["period_minute"],
                        ]);
                        ?>
                        <tr>
                            <td align="left">

                                <form id="outgoing_<?php echo $row["id"]; ?>" style="display: none">
                                    <textarea name="description"><?php echo $row["description"]; ?></textarea>
                                    <input type="hidden" name="amount" value="<?php echo Money::formatter($row["amount"],$row["currency"]); ?>">
                                    <input type="hidden" name="currency" value="<?php echo $row["currency"]; ?>">
                                    <input type="hidden" name="period_day" value="<?php echo $period_day; ?>">
                                    <input type="hidden" name="period_hour" value="<?php echo $row["period_hour"]; ?>">
                                    <input type="hidden" name="period_minute" value="<?php echo $row["period_minute"]; ?>">
                                </form>
                                <span title="<?php echo htmlentities($row["description"],ENT_QUOTES); ?>"><?php echo $short_desc; ?></span>
                            </td>
                            <td align="center">
                                <?php echo $show_period; ?>
                            </td>
                            <td align="center"><?php echo Money::formatter_symbol($row["amount"],$row["currency"]); ?></td>
                            <?php if($privOperation): ?>
                                <td align="center">
                                    <a href="javascript:editOutgoing(<?php echo $row["id"]; ?>);void 0;" class="sbtn"><i class="fa fa-pencil-square-o"></i></a>
                                    <a class="red sbtn" href="javascript:void 0;" onclick="deleteOutgoing(<?php echo $row["id"]; ?>,this);"><i class="fa fa-trash-o"></i></a>
                                </td>
                            <?php endif; ?>
                        </tr>
                        <?php
                    }
                }else{
                    ?>
                    <tr>
                        <td colspan="3" align="center">
                            <span class="error"><?php echo __("admin/invoices/periodic-outgoings-none"); ?></span>
                        </td>
                    </tr>
                    <?php
                }
            ?>
            </tbody>
        </table>

    </div>

</div>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1><strong><?php echo __("admin/invoices/page-cash"); ?></strong></h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>


            <div class="faturalinks">

            	<span class="currentcash"><?php echo __("admin/invoices/cash-status"); ?>
                    <strong id="this_amount"><?php echo $thisAmount; ?></strong>
                </span>

                <?php if($privOperation): ?>
                    <a href="javascript:addCash();void 0;" class="green lbtn">+ <?php echo __("admin/invoices/add-cash-button"); ?></a>

                <?php endif; ?>

                <div class="cashotherbtn">
                    <?php if($privOperation): ?>
                        <a href="javascript:auto_periodic_outgoings();void 0;" class="lbtn" style="margin-right: 5px;"><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo __("admin/invoices/auto-periodic-outgoings-button"); ?></a>
                    <?php endif; ?>

                    <a href="javascript:$('#advanced-search').slideToggle();void 0;" id="gelarama" class="lbtn"><i class="fa fa-search" aria-hidden="true"></i> <?php echo __("admin/invoices/advanced-search-button"); ?></a>
                </div>

            </div>

            <div class="clear"></div>

            <div id="advanced-search" style="<?php echo $search ? '' : 'display:none;'; ?>float:left;width:100%;padding:5px 0px;    margin-top: 10px;border-top:1px solid #eee; transition-property: all; transition-duration: 0s; transition-timing-function: ease; opacity: 1;">
                <form action="<?php echo $links["controller"]; ?>" method="get" id="searchForm">
                    <input type="hidden" name="search" value="true">
                    <input class="width200" name="word" type="search" placeholder="<?php echo __("admin/invoices/bills-search-word"); ?>" value="<?php echo isset($word) ? htmlentities($word,ENT_QUOTES) : ''; ?>">

                    <?php echo __("admin/invoices/bills-search-start-date"); ?>
                    <input class="width200" name="start" type="date" value="<?php echo isset($start) ? $start : ''; ?>">
                    <?php echo __("admin/invoices/bills-search-end-date"); ?>
                    <input class="width200" name="end" type="date" value="<?php echo isset($end) ? $end : ''; ?>">

                    <a href="javascript:$('#searchForm').submit();void 0;" title="<?php echo __("admin/invoices/bills-search-find"); ?>" class="sbtn"><i class="fa fa-search" aria-hidden="true"></i></a>
                </form>
            </div>

            <div class="kdvinfo" id="amount_statistics">
                <?php if(isset($start)): ?>
                    <h5><?php echo __("admin/invoices/cash-selected-between-amount"); ?></h5>
                    <h5><?php echo __("admin/invoices/cash-row-type-income"); ?>: <strong style="color: #81c04e;"><?php echo $income_amount; ?></strong></h5>
                    <h5><?php echo __("admin/invoices/cash-row-type-expense"); ?>: <strong style="color: red;"><?php echo $expense_amount; ?></strong></h5>
                <?php elseif($search): ?>

                <?php else: ?>
                    <h5><?php echo __("admin/invoices/cash-this-month-income-amount"); ?>: <strong style="color:#81c04e;"><?php echo $income_amount; ?></strong></h5>
                    <h5><?php echo __("admin/invoices/cash-this-month-expense-amount"); ?>: <strong style="color:red;"><?php echo $expense_amount; ?></strong></h5>
                <?php endif; ?>
            </div>

            <table width="100%" id="datatable" class="table table-striped table-borderedx table-condensed nowrap">
                <thead style="background:#ebebeb;">
                <tr>
                    <th align="left">#</th>
                    <th align="center" data-orderable="false"><?php echo __("admin/invoices/cash-th-desc"); ?></th>
                    <th align="center" data-orderable="false"><?php echo __("admin/invoices/cash-th-type"); ?></th>
                    <th align="center" data-orderable="false"><?php echo __("admin/invoices/bills-th-amount"); ?></th>
                    <th align="center" data-orderable="false"><?php echo __("admin/invoices/bills-th-date"); ?></th>
                    <th align="center" data-orderable="false"></th>
                </tr>
                </thead>
                <tbody align="center" style="border-top:none;"></tbody>
            </table>


        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>