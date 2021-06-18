<!DOCTYPE html>
<html>
<head>
    <?php
        $privOperation  = Admin::isPrivilege("PRODUCTS_OPERATION");
        $privGroupLook  = Admin::isPrivilege("PRODUCTS_GROUP_LOOK");
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
                ],
                "lengthMenu": [
                    [10, 25, 50, -1], [10, 25, 50, "<?php echo ___("needs/allOf"); ?>"]
                ],
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": "<?php echo $links["ajax-list"]; ?>",
                responsive: true,
                "language":{"url":"<?php echo APP_URI; ?>/<?php echo ___("package/code"); ?>/datatable/lang.json"}
            });
        });

        function deleteError(id,name){
            var content = "<?php echo ___("needs/delete-are-you-sure"); ?>";
            $("#confirmModal_text").html(content);

            open_modal("ConfirmModal",{
                title:"<?php echo __("admin/products/delete-modal-software-license-error-title"); ?>"
            });

            $("#delete_ok").click(function(){
                var request = MioAjax({
                    button_element:this,
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    action: "<?php echo $links["controller"]; ?>",
                    method: "POST",
                    data: {operation:"delete_software_license_error",id:id}
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

        <div align="center">
            <div class="yuzde50">
                <a id="delete_ok" href="javascript:void(0);" class="gonderbtn redbtn"><i class="fa fa-check"></i> <?php echo __("admin/products/delete-ok"); ?></a>
            </div>
            <div class="yuzde50">
                <a id="delete_no" href="javascript:void(0);" class="gonderbtn yesilbtn"><i class="fa fa-ban"></i> <?php echo __("admin/products/delete-no"); ?></a>
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
                    <strong><?php echo __("admin/products/page-software-license-errors"); ?></strong>
                </h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="clear"></div>
            <br>

            <table width="100%" id="datatable" class="table table-striped table-borderedx table-condensed nowrap">
                <thead style="background:#ebebeb;">
                <tr>
                    <th align="left">#</th>
                    <th align="left" data-orderable="false"><?php echo __("admin/products/license-errors-domain"); ?></th>
                    <th align="center" data-orderable="false"><?php echo __("admin/products/license-errors-directory"); ?></th>
                    <th align="center" data-orderable="false"><?php echo __("admin/products/license-errors-product"); ?></th>
                    <th align="center" data-orderable="false"><?php echo __("admin/products/license-errors-ip"); ?></th>
                    <th align="center" data-orderable="false"><?php echo __("admin/products/license-errors-date"); ?></th>
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