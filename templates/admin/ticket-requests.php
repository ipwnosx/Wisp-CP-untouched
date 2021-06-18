<!DOCTYPE html>
<html>
<head>
    <?php
        $privOperation  = Admin::isPrivilege("TICKETS_OPERATION");
        $privDelete     = Admin::isPrivilege("TICKETS_DELETE");
        $plugins        = ['dataTables','select2','mio-icons'];
        include __DIR__.DS."inc".DS."head.php";
    ?>


    <script>
        var table,s_auto_refresh,auto_refresh;
        $(document).ready(function() {

            table = $('#datatable').DataTable({
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
                "sAjaxSource": "<?php echo $links["ajax"]; ?>",
                responsive: true,
                "oLanguage":<?php include __DIR__.DS."datatable-lang.php"; ?>
            });

            s_auto_refresh = localStorage.getItem('ticket_request_list_auto_refresh');

            if(s_auto_refresh !== null && s_auto_refresh !== false && s_auto_refresh !== 'false'){
                $("#auto_refresh_every_minute").prop('checked',true);
                auto_refresh = setInterval(_auto_refresh,(1000 * 60));
            }

            $("#auto_refresh_every_minute").change(function(){
                localStorage.setItem('ticket_request_list_auto_refresh',$(this).prop('checked'));
                s_auto_refresh = localStorage.getItem('ticket_request_list_auto_refresh');

                if(s_auto_refresh === 'true')
                    auto_refresh = setInterval(_auto_refresh,(1000 * 60));
                else
                    clearInterval(auto_refresh);
            });

        });

        function _auto_refresh(){
            table.ajax.reload();
        }
        function deleteRequest(id){
            open_modal("ConfirmModal");

            $("#delete_ok").click(function(){
                var request = MioAjax({
                    button_element:$("#delete_ok"),
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    action: "<?php echo $links["controller"]; ?>",
                    method: "POST",
                    data: {operation:"delete_request",id:id}
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
                                    close_modal("ConfirmModal");
                                    table.ajax.reload();
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

<div id="ConfirmModal" style="display: none;" data-izimodal-title="<?php echo __("admin/tickets/requests-td-delete-title"); ?>">
    <div class="padding20" align="center">
        <p><?php echo __("admin/tickets/delete-are-youu-sure"); ?></p>
    </div>
    <div class="modal-foot-btn">
        <a id="delete_ok" href="javascript:void(0);" class="red lbtn"><?php echo __("admin/orders/delete-ok"); ?></a>
    </div>
</div>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1>
                    <strong><?php echo $status ? __("admin/tickets/page-requests-".$status) : __("admin/tickets/page-requests"); ?></strong>
                </h1>
                <div id="auto_refresh_every_minute_wrap">
                    <input type="checkbox" id="auto_refresh_every_minute" class="checkbox-custom">
                    <label for="auto_refresh_every_minute" class="checkbox-custom-label"><span class="kinfo"><?php echo __("admin/tickets/auto-refresh-every-minute"); ?></span></label>
                </div>

                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="clear"></div>
            <?php
                if($h_contents = Hook::run("TicketAdminAreaViewList"))
                    foreach($h_contents AS $h_content)
                        if($h_content) echo $h_content;
            ?>
            <div class="clear"></div>

            <div id="Requests">

                <table width="100%" id="datatable" class="table table-striped table-borderedx table-condensed nowrap">
                    <thead style="background:#ebebeb;">
                    <tr>
                        <th align="left">#</th>
                        <th align="left" data-orderable="false"><?php echo __("admin/tickets/requests-th-user"); ?></th>
                        <th align="left" data-orderable="false"><?php echo __("admin/tickets/requests-th-subject"); ?></th>
                        <th align="center" data-orderable="false"><?php echo __("admin/tickets/requests-th-department"); ?></th>
                        <th align="center" data-orderable="false"><?php echo __("admin/tickets/requests-th-assigned"); ?></th>
                        <th align="center" data-orderable="false"><?php echo __("admin/tickets/requests-th-cdate"); ?></th>
                        <th align="center" data-orderable="false"><i class="ion-android-done-all"></i></th>
                        <th align="center" data-orderable="false"><?php echo __("admin/tickets/requests-th-status"); ?></th>
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