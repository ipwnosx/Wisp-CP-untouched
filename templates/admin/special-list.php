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
            var content = "<?php echo __("admin/products/special-product-delete-are-youu-sure"); ?>";
            $("#confirmModal_text").html(content.replace("{name}",name));

            open_modal("ConfirmModal",{
                title:"<?php echo __("admin/products/delete-modal-special-product-title"); ?>"
            });

            $("#ConfirmModal .delete_ok").click(function(){
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

            $("#ConfirmModal .delete_no").click(function(){
                close_modal("ConfirmModal");
            });

        }

        function deleteGroup(id,name){

            $("#password1").val('');

            open_modal("deleteGroupModal",{
                title:"<?php echo __("admin/products/delete-modal-group-title"); ?>"
            });

            $("#deleteGroupModal .delete_ok").click(function(){
                var password = $('#password1').val();
                var request = MioAjax({
                    button_element:this,
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    action: "<?php echo $links["controller"]; ?>",
                    method: "POST",
                    data: {operation:"delete_group",id:id,password:password}
                },true,true);

                request.done(function(result){
                    if(result){
                        if(result != ''){
                            var solve = getJson(result);
                            if(solve !== false){
                                if(solve.status == "error"){
                                    $("#password1").val('');

                                    if(solve.for != undefined && solve.for != ''){
                                        $(solve.for).focus();
                                        $(solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                        $(solve.for).change(function(){
                                            $(this).removeAttr("style");
                                        });
                                    }

                                    if(solve.message != undefined && solve.message != '')
                                        alert_error(solve.message,{timer:5000});
                                }else if(solve.status == "successful"){
                                    $("#password1").val('');
                                    alert_success(solve.message,{timer:3000});
                                    close_modal("deleteGroupModal");
                                    setTimeout(function(){
                                        window.location.href = '<?php echo $dashboard_link; ?>';
                                    },3000);
                                }
                            }else
                                console.log(result);
                        }
                    }else console.log(result);
                });

            });

            $("#deleteGroupModal .delete_no").on("click",function(){
                close_modal("deleteGroupModal");
                $("#password1").val('');
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

        <div align="center">
            <div class="yuzde50">
                <a href="javascript:void(0);" class="delete_ok gonderbtn redbtn"><i class="fa fa-check"></i> <?php echo __("admin/products/delete-ok"); ?></a>
            </div>
            <div class="yuzde50">
                <a href="javascript:void(0);" class="delete_no gonderbtn yesilbtn"><i class="fa fa-ban"></i> <?php echo __("admin/products/delete-no"); ?></a>
            </div>
        </div>
    </div>
</div>

<div id="deleteGroupModal" style="display: none;">
    <div class="padding20">

        <p><?php echo Utility::text_replace(__("admin/products/group-delete-are-youu-sure"),[
                '{name}' => $group["title"],
            ]); ?></p>

        <div align="center" id="password_wrapper">
            <label><?php echo ___("needs/permission-delete-item-password-desc"); ?><br><br><strong><?php echo ___("needs/permission-delete-item-password"); ?></strong> <br><input type="password" id="password1" value="" placeholder="********"></label>
<div class="clear"></div><br>
            <div class="yuzde50">
                <a href="javascript:void(0);" class="delete_ok gonderbtn redbtn"><i class="fa fa-check"></i> <?php echo __("admin/products/delete-ok"); ?></a>
            </div>
            <div class="yuzde50">
                <a href="javascript:void(0);" class="delete_no gonderbtn yesilbtn"><i class="fa fa-ban"></i> <?php echo __("admin/products/delete-no"); ?></a>
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
                    <strong><?php echo __("admin/products/page-special-list",['{group-name}' => $group["title"]]); ?></strong>
                    <a href="<?php echo $links["special-group-redirect"]; ?>" target="_blank" class="sbtn"><i class="fa fa-external-link" aria-hidden="true"></i></a>
                </h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <?php if($privOperation): ?>
                <a href="<?php echo $links["add-new-product"]; ?>" class="green lbtn"><i class="fa fa-plus"></i> <?php echo __("admin/products/add-new-product2"); ?></a>
            <?php endif; ?>

            <a href="<?php echo $links["product-categories"]; ?>" class="blue lbtn"><i class="fa fa-table"></i> <?php echo __("admin/products/categories-button"); ?></a>

            <a href="<?php echo $links["settings"]; ?>" class="lbtn"><i class="fa fa-cog"></i> <?php echo __("admin/products/category-group-settings-button"); ?></a>

            <a href="javascript:deleteGroup(<?php echo $group["id"]; ?>,'<?php echo $group["title"]; ?>');void 0;" class="red lbtn" style="float:right;"><i class="fa fa-trash"></i> <?php echo __("admin/products/delete-group"); ?></a>

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