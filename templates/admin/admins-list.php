<!DOCTYPE html>
<html>
<head>
    <?php
        $needs      = include __DIR__.DS."common-needs.php";
        $situations = $needs["admins"];
        $plugins    = ['dataTables'];
        include __DIR__.DS."inc".DS."head.php";
    ?>

    <script>
        $(document).ready(function() {
            $('#datatable').DataTable({
                "columnDefs": [
                    {
                        "targets": [0],
                        "visible":false,
                        "searchable": false
                    },
                    {
                        "targets": [1,2,3,4,5,6],
                        "orderable": false
                    }
                ],
                paging: true,
                info: true,
                searching: true,
                responsive: true,
                "oLanguage":<?php include __DIR__.DS."datatable-lang.php"; ?>
            });
        });

        function deleteAdmin(id,name){
            var content = $("#ConfirmModal").html();
            $("#ConfirmModal").html(content.replace("{name}",name));

            open_modal("ConfirmModal",{
                title:"<?php echo __("admin/admins/delete-modal-title"); ?>"
            });

            $("#delete_ok").click(function(){
                var result = MioAjax({
                    action: "<?php echo $links["controller"]; ?>",
                    method: "POST",
                    data: {operation:"delete",id:id}
                },true);
                if(result){
                    if(result != ''){
                        var solve = getJson(result);
                        if(solve !== false){
                            if(solve.status == "error"){
                                if(solve.message != undefined && solve.message != '')
                                    alert_error(solve.message,{timer:5000});
                            }else if(solve.status == "successful"){
                                alert_success(solve.message,{timer:3000});
                                var table = $('#datatable').DataTable();
                                table.row($("#row_"+id)).remove().draw();
                            }
                        }else
                            console.log(result);
                    }
                }else console.log(result);
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
        <p class="confirmModal_text"><?php echo __("admin/admins/delete-are-youu-sure"); ?></p>
    </div>
    <div class="modal-foot-btn">
        <a id="delete_ok" href="javascript:void(0);" class="red lbtn"><?php echo __("admin/admins/delete-ok"); ?></a>
    </div>
</div>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1><strong><?php echo __("admin/admins/list-page-name"); ?></strong></h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <a href="<?php echo $links["add-new-admin"]; ?>" class="green lbtn">+ <?php echo __("admin/admins/add-new-admin"); ?></a>

            <div class="clear"></div>
            <br>

            <table width="100%" id="datatable" class="table table-striped table-borderedx table-condensed nowrap">
                <thead style="background:#ebebeb;">
                <tr>
                    <th align="left">#</th>
                    <th align="left"><?php echo __("admin/admins/list-field-name"); ?></th>
                    <th align="center"><?php echo __("admin/admins/list-field-email"); ?></th>
                    <th align="center"><?php echo __("admin/admins/list-field-privilege"); ?></th>
                    <th align="center"><?php echo __("admin/admins/list-field-departments"); ?></th>
                    <th align="center"><?php echo __("admin/admins/list-field-status"); ?></th>
                    <th align="center"></th>
                </tr>
                </thead>
                <tbody align="Center" style="border-top:none;">
                <?php
                    if(isset($list) && $list){
                        $size = sizeof($list)-1;
                        for($i=0;$i<=$size;$i++){
                            $row = $list[$i];
                            ?>
                            <tr id="row_<?php echo $row["id"]; ?>">
                                <td><?php echo $i; ?></td>
                                <td align="left">
                                    <a href="<?php echo $row["edit_link"]; ?>">
                                        <?php echo $row["full_name"]; ?>
                                    </a>
                                </td>
                                <td align="center"><?php echo $row["email"]; ?></td>
                                <td align="center"><?php echo $row["privilege_name"]; ?></td>
                                <td align="center">
                                    <?php
                                        if(isset($row["departments"]) && $row["departments"]){
                                            $departments = explode(",",$row["departments"]);
                                            foreach($departments AS $department){
                                                echo $department."<br>";
                                            }
                                        }else echo ___("needs/none");
                                    ?>
                                </td>
                                <td><?php echo $situations[$row["status"]]; ?></td>
                                <td align="center">
                                    <a href="<?php echo $row["edit_link"]; ?>" title="<?php echo __("admin/admins/edit"); ?>" class="sbtn"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                    <?php
                                        if($row["id"]!=1 && !isset($row["appointees"])){
                                            ?>
                                            <a href="javascript:deleteAdmin(<?php echo $row["id"]; ?>,'<?php echo $row["full_name"]; ?>');void 0;" title="<?php echo __("admin/privileges/delete"); ?>" class="red sbtn"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                            <?php
                                        }
                                    ?>
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