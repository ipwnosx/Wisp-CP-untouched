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
                        "targets": [1,2,3,4,5],
                        "orderable": false
                    }
                ],
                "aaSorting" : [[4, 'asc']],
                "lengthMenu": [
                    [10, 25, 50, -1], [10, 25, 50, "<?php echo ___("needs/allOf"); ?>"]
                ],
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": "<?php echo $links["ajax-list"]; ?>",
                responsive: true,
                "oLanguage":<?php include __DIR__.DS."datatable-lang.php"; ?>
            });
        });

        function deleteAddon(id,name){
            var content = "<?php echo __("admin/products/requirement-delete-are-youu-sure"); ?>";
            $("#confirmModal_text").html(content.replace("{name}",name));

            open_modal("ConfirmModal",{
                title:"<?php echo __("admin/products/delete-modal-requirement-title"); ?>"
            });

            $("#delete_ok").click(function(){
                var request = MioAjax({
                    button_element:this,
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    action: "<?php echo $links["controller"]; ?>",
                    method: "POST",
                    data: {operation:"delete_requirement",id:id}
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
    </script>

</head>
<body>


<div id="editCategory" style="display: none;">
    <div class="padding20">

        <script type="text/javascript">

            $(document).ready(function(){
                $("#editForm").bind("keypress", function(e) {
                    if (e.keyCode == 13) $("#editForm_submit").click();
                });

                $("#editForm_submit").on("click",function(){
                    MioAjaxElement($(this),{
                        waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                        progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                        result:"editForm_handler",
                    });
                });
            });

            function editCategory_handler(result){
                if(result != ''){
                    var solve = getJson(result);
                    if(solve !== false){
                        if(solve.status == "error"){
                            if(solve.for != undefined && solve.for != ''){
                                $("#editForm "+solve.for).focus();
                                $("#editForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                $("#editForm "+solve.for).change(function(){
                                    $(this).removeAttr("style");
                                });
                            }
                            if(solve.message != undefined && solve.message != '')
                                alert_error(solve.message,{timer:5000});
                        }else if(solve.status == "successful"){

                            open_modal("editCategory",{
                                title:"<?php echo __("admin/products/edit-requirement-category-modal-title"); ?>"
                            });

                            $("input[name='title']").val(solve.title);
                            $("input[name='id']").val(solve.id);
                        }
                    }else
                        console.log(result);
                }
            }

            function editForm_handler(result){
                if(result != ''){
                    var solve = getJson(result);
                    if(solve !== false){
                        if(solve.status == "error"){
                            if(solve.for != undefined && solve.for != ''){
                                $("#editForm "+solve.for).focus();
                                $("#editForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                $("#editForm "+solve.for).change(function(){
                                    $(this).removeAttr("style");
                                });
                            }
                            if(solve.message != undefined && solve.message != '')
                                alert_error(solve.message,{timer:5000});
                        }else if(solve.status == "successful"){
                            alert_success(solve.message,{timer:3000});
                            close_modal("editCategory");
                            setTimeout(function(){
                                window.location.href = window.location.href;
                            },2000);
                        }
                    }else
                        console.log(result);
                }
            }
        </script>
        <form action="<?php echo $links["controller"]; ?>" method="post" id="editForm">
            <input type="hidden" name="operation" value="edit_requirement_category">
            <input type="hidden" name="id" value="0">

            <div class="formcon">
                <div class="yuzde30"><?php echo __("admin/products/add-requirement-category-title"); ?></div>
                <div class="yuzde70">
                    <input type="text" name="title" value="">
                </div>
            </div>

            <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                <a class="yesilbtn gonderbtn" id="editForm_submit" href="javascript:void(0);"><?php echo __("admin/products/edit-requirement-category-button"); ?></a>
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
                    <strong><?php echo __("admin/products/page-requirements-list"); ?></strong> (<?php echo $category["title"]; ?>)
                    <a href="javascript:void 0;" onclick="editCategory('<?php echo $category["id"]; ?>');" class="sbtn"><i class="fa fa-edit" aria-hidden="true"></i></a>
                </h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <?php if($privOperation): ?>
                <a href="<?php echo $links["add"]; ?>" class="green lbtn"><i class="fa fa-plus"></i> <?php echo __("admin/products/add-new-requirement"); ?></a>
            <?php endif; ?>

            <div class="clear"></div>
            <br>

            <table width="100%" id="datatable" class="table table-striped table-borderedx table-condensed nowrap">
                <thead style="background:#ebebeb;">
                <tr>
                    <th align="left">#</th>
                    <th align="left"><?php echo __("admin/products/requirement-list-name"); ?></th>
                    <th align="center"><?php echo __("admin/products/requirement-list-category"); ?></th>
                    <th align="center"><?php echo __("admin/products/requirement-list-main-category"); ?></th>
                    <th align="center"><?php echo __("admin/products/requirement-list-status"); ?></th>
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