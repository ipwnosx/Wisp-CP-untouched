<!DOCTYPE html>
<html>
<head>
    <?php
        $plugins            = ['dataTables','select2'];
        Utility::sksort($lang_list,'local');
        include __DIR__.DS."inc".DS."head.php";
    ?>
    <script type="text/javascript">
        var table1,table2,table3;

        $(document).ready(function(){
            table1 = $('#affiliates').DataTable({
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
                "sAjaxSource": "<?php echo $links["ajax-affiliates"]; ?>",
                responsive: true,
                "oLanguage":<?php include __DIR__.DS."datatable-lang.php"; ?>
            });
            table3 = $('#withdrawals').DataTable({
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
                "sAjaxSource": "<?php echo $links["ajax-withdrawals"]; ?>",
                responsive: true,
                "oLanguage":<?php include __DIR__.DS."datatable-lang.php"; ?>
            });

            var tab1 = _GET("group");
            if (tab1 != '' && tab1 != undefined) {
                $("#tab-group .tablinks[data-tab='" + tab1 + "']").click();
            } else {
                $("#tab-group .tablinks:eq(0)").addClass("active");
                $("#tab-group .tabcontent:eq(0)").css("display", "block");
            }

            $("#detail_withdrawal_modal").on("click","#updateWithdrawalForm_submit",function(){
                MioAjaxElement($(this),{
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                    result:"updateWithdrawalForm_handler",
                });
            });

        });

        function updateWithdrawalForm_handler(result){
            if(result != ''){
                var solve = getJson(result);
                if(solve !== false){
                    if(solve.status == "error"){
                        if(solve.for != undefined && solve.for != ''){
                            $("#updateWithdrawalForm "+solve.for).focus();
                            $("#updateWithdrawalForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                            $("#updateWithdrawalForm "+solve.for).change(function(){
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
                        table3.ajax.reload();
                    }
                }else
                    console.log(result);
            }
        }

        function detail_withdrawal(id){
            var affiliate           = $("#withdrawal_"+id+" .wl-affiliate").html();
            var ctime               = $("#withdrawal_"+id+" .wl-ctime").html();
            var gateway             = $("#withdrawal_"+id+" .wl-gateway").html();
            var gateway_info        = $("#withdrawal_"+id+" .wl-gateway-info").html();
            var amount              = $("#withdrawal_"+id+" .wl-amount").html();
            var status              = $("#withdrawal_"+id+" .wl-status").html();
            var status_msg          = $("#withdrawal_"+id+" .wl-status_msg").html();

            open_modal('detail_withdrawal_modal');

            $("#wl-id").val(id);
            $("#wl-affiliate").html(affiliate);
            $("#wl-ctime").html(ctime);
            $("#wl-gateway").html(gateway);
            $("#wl-gateway-info").html(gateway_info);
            $("#wl-amount").html(amount);
            $("#wl-status").val(status);
            $("#wl-status_msg").val(status_msg);

        }

        function delete_withdrawal(id){
            open_modal("delete_withdrawal_modal",{
                title:"<?php echo ___("needs/button-delete"); ?>"
            });

            $("#delete_withdrawal_modal .delete_ok").click(function(){
                var password = $('#password1').val();
                var request = MioAjax({
                    button_element:$(this),
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    action: "<?php echo $links["controller"]; ?>",
                    method: "POST",
                    data: {operation:"delete_withdrawal",id:id}
                },true,true);

                request.done(function(result){
                    if(result){
                        if(result !== ''){
                            var solve = getJson(result);
                            if(solve !== false){
                                if(solve.status == "error"){
                                    if(solve.message != undefined && solve.message != '')
                                        alert_error(solve.message,{timer:5000});
                                }else if(solve.status == "successful"){
                                    alert_success(solve.message,{timer:3000});
                                    table3.ajax.reload();
                                }
                            }else
                                console.log(result);
                        }
                    }else console.log(result);
                });
            });

            $("#delete_withdrawal_modal .delete_no").on("click",function(){
                close_modal("delete_withdrawal_modal");
            });
        }

    </script>
    <style type="text/css">
        #affiliates tbody tr td:nth-child(1) { text-align: left;}
        #withdrawals tbody tr td:nth-child(1) { text-align: left;}
    </style>

</head>
<body>
<?php include __DIR__.DS."inc/header.php"; ?>

<div id="delete_withdrawal_modal" style="display: none;">
    <div class="padding20">
        <div align="center">

            <p><?php echo ___("needs/delete-are-you-sure"); ?></p>
            <div class="clear"></div><br>
            <div class="yuzde50">
                <a href="javascript:void(0);" class="delete_ok gonderbtn redbtn"><i class="fa fa-check"></i> <?php echo ___("needs/ok"); ?></a>
            </div>
            <div class="yuzde50">
                <a href="javascript:void(0);" class="delete_no gonderbtn yesilbtn"><i class="fa fa-ban"></i> <?php echo ___("needs/no"); ?></a>
            </div>
        </div>
    </div>
</div>

<div id="detail_withdrawal_modal" style="display: none;" data-izimodal-title="<?php echo ___("needs/button-detail"); ?>">
    <div class="padding20">

        <form action="<?php echo $links["controller"]; ?>" method="post" id="updateWithdrawalForm">
            <input type="hidden" name="operation" value="update_withdrawal">
            <input type="hidden" name="id" value="0" id="wl-id">

            <div class="formcon">
                <div class="yuzde30"><?php echo __("admin/users/list-th-affiliate"); ?></div>
                <div class="yuzde70" id="wl-affiliate">?</div>
            </div>

            <div class="formcon">
                <div class="yuzde30"><?php echo __("admin/users/list-th-withdrawal-ctime"); ?></div>
                <div class="yuzde70" id="wl-ctime">00/00/0000 00:00</div>
            </div>

            <div class="formcon">
                <div class="yuzde30"><?php echo __("admin/users/list-th-withdrawal-gateway"); ?></div>
                <div class="yuzde70">
                    <strong id="wl-gateway"></strong>
                    <div class="clear"></div>
                    <span id="wl-gateway-info"></span>
                </div>
            </div>

            <div class="formcon">
                <div class="yuzde30"><?php echo __("admin/users/list-th-withdrawal-amount"); ?></div>
                <div class="yuzde70">
                    <strong id="wl-amount"></strong>
                </div>
            </div>

            <div class="formcon">
                <div class="yuzde30"><?php echo __("admin/users/list-th-withdrawal-status"); ?></div>
                <div class="yuzde70">
                    <select name="status" id="wl-status">
                        <?php
                            foreach(__("admin/users/affiliate-withdrawal-situations") AS $k=>$v)
                            {
                                ?>
                                <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                <?php
                            }
                        ?>
                    </select>
                    <div class="clear"></div>
                    <textarea name="status_msg" id="wl-status_msg" placeholder="<?php echo __("admin/users/affiliate-withdrawal-status-msg"); ?>"></textarea>
                </div>
            </div>

            <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                <a class="yesilbtn gonderbtn" id="updateWithdrawalForm_submit" href="javascript:void(0);"><?php echo ___("needs/button-update"); ?></a>
            </div>
            <div class="clear"></div>

        </form>

        <div class="clear"></div>
    </div>
</div>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1>
                    <strong><?php echo __("admin/users/page-affiliate");?></strong>
                </h1>

                <div align="left">
                    <a class="lbtn" href="<?php echo $links["settings"]; ?>"><i class="fa fa-cogs"></i> <?php echo __("admin/users/blacklist-settings-btn"); ?></a>
                </div>

                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="green-info">
                <div class="padding20">
                    <i class="fa fa-info-circle"></i>
                    <p><?php echo __("admin/users/affiliate-info"); ?></p>
                </div>
            </div>
            <div class="clear"></div>

            <div id="tab-group">

                <ul class="tab">
                    <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'affiliates','group')" data-tab="affiliates"><?php echo __("admin/users/affiliate-affiliates"); ?></a></li>
                    <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'withdrawals','group')" data-tab="withdrawals"><?php echo __("admin/users/affiliate-withdrawals"); ?></a>
                    </li>
                </ul>

                <div id="group-affiliates" class="tabcontent">
                    <table width="100%" id="affiliates" class="table table-striped table-borderedx table-condensed nowrap">
                        <thead style="background:#ebebeb;">
                        <tr>
                            <th align="left" data-orderable="false">#</th>
                            <th align="left" data-orderable="false"><?php echo __("admin/users/list-th-affiliate"); ?></th>
                            <th align="center" data-orderable="false"><?php echo __("admin/users/list-th-affiliate-ctime"); ?></th>
                            <th align="center" data-orderable="false"><?php echo __("admin/users/list-th-affiliate-users"); ?></th>
                            <th align="center" data-orderable="false"><?php echo __("admin/users/list-th-affiliate-hits"); ?></th>
                            <th align="center" data-orderable="false"><?php echo __("admin/users/list-th-affiliate-balance"); ?></th>
                            <th align="center" data-orderable="false"><?php echo __("admin/users/list-th-affiliate-withdrawals"); ?></th>
                            <th align="center" data-orderable="false"></th>
                        </tr>
                        </thead>
                        <tbody align="center" style="border-top:none;"></tbody>
                    </table>
                </div>

                <div id="group-withdrawals" class="tabcontent">
                    <table width="100%" id="withdrawals" class="table table-striped table-borderedx table-condensed nowrap">
                        <thead style="background:#ebebeb;">
                        <tr>
                            <th align="left" data-orderable="false">#</th>
                            <th align="left" data-orderable="false"><?php echo __("admin/users/list-th-affiliate"); ?></th>
                            <th align="center" data-orderable="false"><?php echo __("admin/users/list-th-withdrawal-ctime"); ?></th>
                            <th align="center" data-orderable="false"><?php echo __("admin/users/list-th-withdrawal-gateway"); ?></th>
                            <th align="center" data-orderable="false"><?php echo __("admin/users/list-th-withdrawal-amount"); ?></th>
                            <th align="center" data-orderable="false"><?php echo __("admin/users/list-th-withdrawal-status"); ?></th>
                            <th align="center" data-orderable="false"></th>
                        </tr>
                        </thead>
                        <tbody align="center" style="border-top:none;"></tbody>
                    </table>
                </div>
            </div>


            <div class="clear"></div>

        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>