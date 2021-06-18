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
        #datatable tbody tr td:last-child{ text-align: center;}
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
                        "targets": [1],
                        "orderable": false
                    }
                ],
                //"aaSorting" : [[3, 'asc']],
                "lengthMenu": [
                    [10, 25, 50, -1], [10, 25, 50, "<?php echo ___("needs/allOf"); ?>"]
                ],
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": "<?php echo $links["ajax-category-list"]; ?>",
                responsive: true,
                "oLanguage":<?php include __DIR__.DS."datatable-lang.php"; ?>
            });
        });

        function addCategory(){
            open_modal("addNewCategory",{
                title:"<?php echo __("admin/products/add-requirement-category-modal-title"); ?>"
            });
        }

        function editCategory(id){

            var request = MioAjax({
                action:"<?php echo $links["controller"]; ?>",
                method:"POST",
                data:{operation:"get_requirement_category",id:id},
            },true,true);

            request.done(function (result){
                editCategory_handler(result);
            });
        }

        function deleteCategory(id,name){
            var content = "<?php echo __("admin/products/requirement-category-delete-are-youu-sure"); ?>";
            $("#confirmModal_text").html(content.replace("{name}",name));

            open_modal("ConfirmModal",{
                title:"<?php echo __("admin/products/delete-modal-requirement-category-title"); ?>"
            });

            $("#delete_ok").click(function(){
                var request = MioAjax({
                    button_element:this,
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    action: "<?php echo $links["controller"]; ?>",
                    method: "POST",
                    data: {operation:"delete_requirement_category",id:id}
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

<div id="addNewCategory" style="display: none;">
    <div class="padding20">

        <script type="text/javascript">

            $(document).ready(function(){
                $("#addNewForm").bind("keypress", function(e) {
                    if (e.keyCode == 13) $("#addNewForm_submit").click();
                });

                $("#addNewForm_submit").on("click",function(){
                    MioAjaxElement($(this),{
                        waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                        progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                        result:"addNewForm_handler",
                    });
                });
            });

            function addNewForm_handler(result){
                if(result != ''){
                    var solve = getJson(result);
                    if(solve !== false){
                        if(solve.status == "error"){
                            if(solve.for != undefined && solve.for != ''){
                                $("#addNewForm "+solve.for).focus();
                                $("#addNewForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                $("#addNewForm "+solve.for).change(function(){
                                    $(this).removeAttr("style");
                                });
                            }
                            if(solve.message != undefined && solve.message != '')
                                alert_error(solve.message,{timer:5000});
                        }else if(solve.status == "successful"){
                            alert_success(solve.message,{timer:2000});
                            table.ajax.reload();
                            close_modal("addNewCategory");
                        }
                    }else
                        console.log(result);
                }
            }
        </script>
        <form action="<?php echo $links["controller"]; ?>" method="post" id="addNewForm">
            <input type="hidden" name="operation" value="add_new_requirement_category">

            <div class="formcon">
                <div class="yuzde30"><?php echo __("admin/products/add-requirement-category-title"); ?></div>
                <div class="yuzde70">
                    <input type="text" name="title" value="">
                </div>
            </div>

            <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                <a class="yesilbtn gonderbtn" id="addNewForm_submit" href="javascript:void(0);"><?php echo __("admin/products/new-requirement-category-button"); ?></a>
            </div>
            <div class="clear"></div>

        </form>
        <div class="clear"></div>
    </div>
</div>

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
                    <strong><?php echo __("admin/products/page-requirement-categories"); ?></strong>

                </h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

             <div class="green-info" style="margin-bottom:20px;">
                                        <div class="padding15">
                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                            <p><?php echo __("admin/products/add-requirement-desc"); ?></p>
                                        </div>
                                    </div>

            <?php if($privOperation): ?>
                <a href="javascript:addCategory();void 0;" class="green lbtn"><i class="fa fa-plus"></i> <?php echo __("admin/products/add-new-requirement-category"); ?></a>
            <?php endif; ?>

            <?php if($privOperation): ?>
                <a href="<?php echo $links["add"]; ?>" class="blue lbtn"><i class="fa fa-plus"></i> <?php echo __("admin/products/add-new-requirement"); ?></a>
            <?php endif; ?>


            <div class="clear"></div>
            <br>

            <table width="100%" id="datatable" class="table table-striped table-borderedx table-condensed nowrap">
                <thead style="background:#ebebeb;">
                <tr>
                    <th align="left">#</th>
                    <th align="left"><?php echo __("admin/products/requirement-category-list-name"); ?></th>
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