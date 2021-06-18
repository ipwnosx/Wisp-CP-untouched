<!DOCTYPE html>
<html>
<head>
    <?php
        $privOperation  = Admin::isPrivilege("PRODUCTS_OPERATION");
        $plugins        = ['dataTables'];
        include __DIR__.DS."inc".DS."head.php";
    ?>

    <style type="text/css">
        #datatable tbody tr td:first-child{ text-align: left;}
    </style>
    <script>
        var table;
        $(document).ready(function() {
            table = $('#datatable').DataTable({
                "columnDefs": [
                    {
                        "targets": [0],
                        "visible":false,
                        "searchable": false
                    },
                    {
                        "targets": [1,2,3],
                        "orderable": false
                    }
                ],
                "aaSorting" : [[4, 'asc']],
                "lengthMenu": [
                    [10, 25, 50, -1], [10, 25, 50, "<?php echo ___("needs/allOf"); ?>"]
                ],
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": "<?php echo $links["ajax-shared-server-list"]; ?>",
                responsive: true,
                "oLanguage":<?php include __DIR__.DS."datatable-lang.php"; ?>
            });
        });

        function deleteServer(id,name){
            var content = "<?php echo __("admin/products/hosting-shared-servers-delete-are-youu-sure"); ?>";
            $("#confirmModal_text").html(content.replace("{name}",name));

            open_modal("ConfirmModal",{
                title:"<?php echo __("admin/products/delete-modal-hosting-shared-server-title"); ?>"
            });

            $("#delete_ok").click(function(){
                var request = MioAjax({
                    button_element:this,
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    action: "<?php echo $links["controller"]; ?>",
                    method: "POST",
                    data: {operation:"delete_shared_server",id:id}
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
        <p id="confirmModal_text"></p>
    </div>
    <div class="modal-foot-btn">
        <a id="delete_ok" href="javascript:void(0);" class="red lbtn"><?php echo __("admin/products/delete-ok"); ?></a>
    </div>
</div>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1>
                    <strong><?php echo __("admin/products/page-hosting-shared-servers"); ?></strong>
                </h1>
                <?php
                $ui_help_link = 'https://docs.wisecp.com/en/kb/shared-server-settings';
                if($ui_lang == "tr") $ui_help_link = 'https://docs.wisecp.com/tr/kb/paylasimli-sunucu-ayarlari';
                ?>
                <a title="<?php echo __("admin/help/usage-guide"); ?>" target="_blank" class="pagedocslink" href="<?php echo $ui_help_link; ?>"><i class="fa fa-life-ring" aria-hidden="true"></i></a>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <a href="<?php echo $links["add-shared-server"]; ?>" class="green lbtn"><i class="fa fa-plus"></i> <?php echo __("admin/products/add-new-hosting-shared-server-button"); ?></a>

            <div class="clear"></div>
            <br>

            <table width="100%" id="datatable" class="table table-striped table-borderedx table-condensed nowrap">
                <thead style="background:#ebebeb;">
                <tr>
                    <th align="left">#</th>
                    <th align="left"><?php echo __("admin/products/hosting-shared-servers-table-name"); ?></th>
                    <th align="center"><?php echo __("admin/products/hosting-shared-servers-table-ip"); ?></th>
                    <th align="center"><?php echo __("admin/products/hosting-shared-servers-table-type"); ?></th>
                    <th align="center"><?php echo __("admin/products/hosting-shared-servers-table-status"); ?></th>
                    <th align="center"></th>
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