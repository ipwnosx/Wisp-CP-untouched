<!DOCTYPE html>
<html>
<head>
    <?php
        Utility::sksort($lang_list,"local");
        $privilege      = Admin::isPrivilege(["TICKETS_PREDEFINED_REPLIES"]);
        $plugins        = ['dataTables','tinymce-1'];
        include __DIR__.DS."inc".DS."head.php";
    ?>
    <script>
        function deleteReply(id){
            if(confirm("<?php echo htmlspecialchars(__("admin/tickets/delete-are-youu-sure"),ENT_QUOTES); ?>")){
                window.location.href = "<?php echo $links["controller"]; ?>?delete="+id;
            }
        }

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
    </script>

</head>
<body>



<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1>
                    <strong><?php echo __("admin/tickets/page-predefined-replies"); ?></strong>

                </h1>

                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <a href="<?php echo $links["add-reply"]; ?>" class="green lbtn"><i class="fa fa-plus"></i> <?php echo __("admin/tickets/predefined-replies-add-reply"); ?></a>

            <a href="<?php echo $links["categories"]; ?>" class="blue lbtn"><i class="fa fa-pencil-square-o"></i> <?php echo __("admin/tickets/button-categories"); ?></a>
            <div class="clear"></div>
            <br>




            <div class="clear"></div>
            <br>
            <table width="100%" id="datatable" class="table table-striped table-borderedx table-condensed nowrap">
                <thead style="background:#ebebeb;">
                <tr>
                    <th align="left">#</th>
                    <th align="left" data-orderable="false"><?php echo __("admin/tickets/predefined-replies-th-name"); ?></th>
                    <th align="left" data-orderable="false"><?php echo __("admin/tickets/predefined-replies-th-category"); ?></th>
                    <th align="center" data-orderable="false"></th>
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
                                <td align="left"><?php echo $row["category_name"]; ?></td>
                                <td align="center">
                                    <a class="sbtn" href="<?php echo $links["edit-reply"].$row["id"]; ?>"><i class="fa fa-pencil"></i></a>
                                    <a class="red sbtn" href="javascript:deleteReply(<?php echo $row["id"]; ?>);void 0;"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                ?>
                </tbody>
            </table>

            <div class="clear"></div>

        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>