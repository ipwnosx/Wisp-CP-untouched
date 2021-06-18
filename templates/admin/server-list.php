<!DOCTYPE html>
<html>
<head>
    <?php
        $privOperation  = Admin::isPrivilege("PRODUCTS_OPERATION");
        $privGroupLook  = Admin::isPrivilege("PRODUCTS_GROUP_LOOK");
        $plugins        = ['dataTables'];
        include __DIR__.DS."inc".DS."head.php";
    ?>

   
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
                "sAjaxSource": "<?php echo $links["ajax-product-list"]; ?>",
                responsive: true,
                "oLanguage":<?php include __DIR__.DS."datatable-lang.php"; ?>
            });
        });

        function deleteProduct(id,name){
            var content = "<?php echo __("admin/products/server-product-delete-are-youu-sure"); ?>";
            $("#confirmModal_text").html(content.replace("{name}",name));

            open_modal("ConfirmModal",{
                title:"<?php echo __("admin/products/delete-modal-server-product-title"); ?>"
            });

            $("#delete_ok").click(function(){
                var request = MioAjax({
                    button_element:this,
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    action: "<?php echo $links["controller"]; ?>",
                    method: "POST",
                    data: {operation:"delete_product",id:id}
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

        function copyProduct(id){
            var request = MioAjax({
                button_element:$("#copy_"+id),
                waiting_text: '<i class="fa fa-spinner" style="-webkit-animation:fa-spin 2s infinite linear;animation: fa-spin 2s infinite linear;"></i>',
                action: "<?php echo $links["controller"]; ?>",
                method: "POST",
                data: {operation:"copy_product",id:id}
            },true,true);

            request.done(function(result){
                if(result){
                    if(result != ''){
                        var solve = getJson(result);
                        if(solve !== false){
                            if(solve.status == "error"){
                                if(solve.message != undefined && solve.message != '')
                                    alert_error(solve.message,{timer:5000});
                            }else if(solve.status == "successful") table.ajax.reload();
                        }else
                            console.log(result);
                    }
                }else console.log(result);
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
                    <strong><?php echo __("admin/products/page-server-list"); ?></strong>
                    <a href="<?php echo $links["server-group-redirect"]; ?>" target="_blank" class="sbtn"><i class="fa fa-external-link" aria-hidden="true"></i></a>
                </h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <?php if($privOperation): ?>
                <a href="<?php echo $links["add-new-product"]; ?>" class="green lbtn"><i class="fa fa-plus"></i> <?php echo __("admin/products/add-new-product"); ?></a>
            <?php endif; ?>

            <a href="<?php echo $links["product-categories"]; ?>" class="blue lbtn"><i class="fa fa-table"></i> <?php echo __("admin/products/categories-button"); ?></a>

            <a href="<?php echo $links["settings"]; ?>" class="lbtn"><i class="fa fa-cog"></i> <?php echo __("admin/products/category-group-settings-button"); ?></a>

            <a href="<?php echo $links["shared-servers"]; ?>" style="float: right;" class="lbtn"><i class="fa fa-server"></i> <?php echo __("admin/products/shared-hosting-server-button"); ?></a>

            <div class="clear"></div>
            <br>

            <table width="100%" id="datatable" class="table table-striped table-borderedx table-condensed nowrap">
                <thead style="background:#ebebeb;">
                <tr>
                    <th align="left">#</th>
                    <th align="left"><?php echo __("admin/products/list-name"); ?></th>
                    <th align="center"><?php echo __("admin/products/list-category"); ?></th>
                    <th align="center"><?php echo __("admin/products/list-amount"); ?></th>
                    <th align="center"><?php echo __("admin/products/list-status"); ?></th>
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