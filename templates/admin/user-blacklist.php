<!DOCTYPE html>
<html>
<head>
    <?php
        $plugins        = ['dataTables','select2'];
        include __DIR__.DS."inc".DS."head.php";
    ?>
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

        function deleteBlackList(id){
            $("#remove_ids").val(id);
            open_modal("deleteBlackListModal");

            $("#delete_ok").click(function(){
                var request = MioAjax({
                    button_element:$(this),
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    action: "<?php echo $links["controller"]; ?>",
                    method: "POST",
                    data: {operation:"delete_blacklist",id:id}
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
                                    close_modal("deleteBlackListModal");
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
                close_modal("deleteBlackListModal");
            });

        }

        function readMsg(id){
            open_modal('readMsg_Modal');
            var content = $("#reason_"+id).html();
            $("#msg_content").html(content);
        }
    </script>

</head>
<body>

<div id="readMsg_Modal" style="display: none;" data-izimodal-title="<?php echo __("admin/users/list-th-blacklist-reason"); ?>">
    <div class="padding20">

        <div align="center">
            <p id="msg_content"></p>
        </div>

    </div>
</div>

<div id="deleteBlackListModal" style="display: none;" data-izimodal-title="<?php echo ___("needs/button-delete"); ?>">
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
                    <strong><?php echo __("admin/users/page-blacklist");?></strong>
                </h1>

                <div align="left">
                    <a class="lbtn" href="<?php echo $links["settings"]; ?>"><i class="fa fa-cogs"></i> <?php echo __("admin/users/blacklist-settings-btn"); ?></a>
                </div>

                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="green-info">
                <div class="padding20">
                    <i class="fa fa-info-circle"></i>
                    <p><?php echo __("admin/users/blacklist-info"); ?></p>
                </div>
            </div>
            <div class="clear"></div>

            <table width="100%" id="datatable" class="table table-striped table-borderedx table-condensed nowrap">
                <thead style="background:#ebebeb;">
                <tr>
                    <th align="left" data-orderable="false">#</th>
                    <th align="left" data-orderable="false"><?php echo __("admin/users/list-th-name"); ?></th>
                    <th align="center" data-orderable="false"><?php echo __("admin/users/list-th-email"); ?></th>
                    <th align="center" data-orderable="false"><?php echo __("admin/users/list-th-blacklist-by-admin"); ?></th>
                    <th align="center" data-orderable="false"><?php echo __("admin/users/list-th-blacklist-time"); ?></th>
                    <th align="center" data-orderable="false"><?php echo __("admin/users/list-th-blacklist-reason"); ?></th>
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