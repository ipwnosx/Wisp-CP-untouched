<!DOCTYPE html>
<html>
<head>
    <?php
        $plugins        = ['dataTables','select2'];
        include __DIR__.DS."inc".DS."head.php";
    ?>

    <!--style type="text/css">
        #datatable tbody tr td:nth-child(1),#datatable tbody tr td:nth-child(2) {
            text-align: left;
        }
    </style-->
    <script type="text/javascript">
        var table;
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
        });

        function deleteFilter(id){
            $("#remove_ids").val(id);
            open_modal("deleteFilterModal");

            $("#delete_ok").click(function(){
                var request = MioAjax({
                    button_element:$(this),
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    action: "<?php echo $links["controller"]; ?>",
                    method: "POST",
                    data: {operation:"delete_document_filter",id:id}
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
                                    close_modal("deleteFilterModal");
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
                close_modal("deleteFilterModal");
            });

        }
    </script>

</head>
<body>

<div id="deleteFilterModal" style="display: none;" data-izimodal-title="<?php echo ___("needs/button-delete"); ?>">
    <div class="padding20">
        <div align="center">
            <p><?php echo ___("needs/delete-are-you-sure"); ?></p>
        </div>
    </div>
    <div class="modal-foot-btn">
        <a id="delete_ok" href="javascript:void(0);" class="red lbtn"><?php echo ___("needs/yes"); ?></a>
    </div>
</div>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1>
                    <strong><?php echo __("admin/users/page-document-filter-list");?></strong>
                </h1>

                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="green-info">
                <div class="padding20">
                    <i class="fa fa-info-circle"></i>
                    <p><?php echo __("admin/users/document-filters-info"); ?></p>
                </div>
            </div>
            <div class="clear"></div>

            <div align="left">
                <a class="green lbtn" href="<?php echo $links["add"]; ?>">+ <?php echo __("admin/users/page-add-document-filter"); ?></a>
            </div>


            <div class="clear"></div>

            <table width="100%" id="datatable" class="table table-striped table-borderedx table-condensed nowrap">
                <thead style="background:#ebebeb;">
                <tr>
                    <th align="left" data-orderable="false">#</th>
                    <th align="center" data-orderable="false"><?php echo __("admin/users/document-filter-list-th-name"); ?></th>
                    <th align="center" data-orderable="false"><?php echo __("admin/users/list-th-status"); ?></th>
                    <th align="center" data-orderable="false"></th>
                </tr>
                </thead>
                <tbody align="center" style="border-top:none;"></tbody>
            </table>


            <div class="clear"></div>

        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>