<!DOCTYPE html>
<html>
<head>
    <?php
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
                    }
                ],
                "lengthMenu": [
                    [10, 25, 50, -1], [10, 25, 50, "<?php echo ___("needs/allOf"); ?>"]
                ],
                responsive: true,
                "oLanguage":<?php include __DIR__.DS."datatable-lang.php"; ?>
            });
        });

        function deleteCustomField(id){
            var content = "<?php echo htmlspecialchars(__("admin/tickets/delete-are-youu-sure"),ENT_QUOTES); ?>";
            $("#confirmModal_text").html(content);

            open_modal("ConfirmModal",{
                title:"<?php echo ___("needs/button-delete"); ?>"
            });

            $("#delete_ok").click(function(){
                window.location.href = "<?php echo $links["controller"]; ?>?delete="+id;
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
                    <strong><?php echo __("admin/tickets/page-custom-fields"); ?></strong>
                </h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <a href="<?php echo $links["add"]; ?>" class="green lbtn"><i class="fa fa-plus"></i> <?php echo __("admin/tickets/add-new-custom-field"); ?></a>

            <div class="clear"></div>
            <br>

            <table width="100%" id="datatable" class="table table-striped table-borderedx table-condensed nowrap">
                <thead style="background:#ebebeb;">
                <tr>
                    <th align="left">#</th>
                    <th align="left"><?php echo __("admin/tickets/custom-fields-th-name"); ?></th>
                    <th align="center"><?php echo __("admin/tickets/custom-fields-th-department"); ?></th>
                    <th align="center"><?php echo __("admin/tickets/custom-fields-th-status"); ?></th>
                    <th align="center"></th>
                </tr>
                </thead>
                <tbody align="center" style="border-top:none;">
                <?php
                    if(isset($list) && $list){
                        foreach($list AS $k=>$row){
                            ?>
                            <tr>
                                <td><?php echo $k; ?></td>
                                <td align="left"><?php echo $row["name"]; ?></td>
                                <td align="left"><?php echo $row["department_name"]; ?></td>
                                <td align="center"><?php echo $situations[$row["status"]]; ?></td>
                                <td align="center">
                                    <a class="sbtn" href="<?php echo $links["edit"].$row["id"]; ?>" data-tooltip="<?php echo ___("needs/button-edit"); ?>"><i class="fa fa-pencil"></i></a>
                                    <a class="sbtn red" href="javascript:deleteCustomField(<?php echo $row["id"]; ?>); void 0;" data-tooltip="<?php echo ___("needs/button-delete"); ?>"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>