<!DOCTYPE html>
<html>
<head>
    <?php

        $plugins    = ['dataTables'];
        include __DIR__.DS."inc".DS."head.php";
    ?>
    <script type="text/javascript">
        var table;
        $(document).ready(function(){

            table = $('#tasksTable').DataTable({
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
                "sAjaxSource": "<?php echo $links["ajax-tasks"]; ?>",
                responsive: true,
                "oLanguage":<?php include __DIR__.DS."datatable-lang.php"; ?>
            });

        });
    </script>
 

    <script type="text/javascript">
        $(document).ready(function(){

        });

        function deleteTask(id){

            if(typeof id == "object" && id.length>1){
                $("#password_wrapper").css("display","block");
            }else
                $("#password_wrapper").css("display","none");

            $("#password1").val('');

            open_modal("deleteModal",{
                title:"<?php echo ___("needs/button-delete"); ?>"
            });

            $("#delete_ok").click(function(){
                var password = $('#password1').val();
                var request = MioAjax({
                    button_element:this,
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    action: "<?php echo $links["controller"]; ?>",
                    method: "POST",
                    data: {operation:"task_apply_operation",from:"list",type:"delete",id:id,password:password}
                },true,true);

                request.done(function(result){
                    if(result){
                        if(result != ''){
                            var solve = getJson(result);
                            if(solve !== false){
                                if(solve.status == "error"){
                                    $("#password1").val('');
                                    if(solve.message != undefined && solve.message != '')
                                        alert_error(solve.message,{timer:5000});
                                }else if(solve.status == "successful"){
                                    $("#password1").val('');
                                    alert_success(solve.message,{timer:3000});
                                    close_modal("deleteModal");
                                    table.ajax.reload();
                                }
                            }else
                                console.log(result);
                        }
                    }else console.log(result);
                });

            });

            $("#delete_no").click(function(){
                close_modal("deleteModal");
                $("#password1").val('');
            });
        }
        function applyOperation(elem,type){
            var id = $(elem).data("id");

            if(type === 'delete') return deleteTask(id);

            $("#tableList").addClass("tab-blur-content");
            $("#operation-loading").fadeIn(500);

            var request = MioAjax({
                action: "<?php echo $links["controller"]; ?>",
                method: "POST",
                data: {operation:"task_apply_operation",from:"list",type:type,id:id}
            },true,true);

            request.done(function(result){

                $("#operation-loading").fadeOut(500,function(){
                    $("#tableList").removeClass("tab-blur-content");
                });

                if(result){
                    if(result != ''){
                        var solve = getJson(result);
                        if(solve !== false){
                            if(solve.status == "error"){
                                if(solve.message != undefined && solve.message != '')
                                    alert_error(solve.message,{timer:5000});
                                table.ajax.reload();
                            }else if(solve.status == "successful"){

                                table.ajax.reload();

                                alert_success(solve.message,{timer:3000});
                            }
                        }else
                            console.log(result);
                    }
                }else console.log(result);
            });

        }
    </script>
</head>
<body>

<div id="deleteModal" style="display: none;">
    <div class="padding20">
        <div align="center">

            <p><?php echo ___("needs/delete-are-you-sure"); ?></p>

            <div id="password_wrapper" style="display: none;">
                <label><?php echo ___("needs/permission-delete-item-password-desc"); ?><br><br><strong><?php echo ___("needs/permission-delete-item-password"); ?></strong> <br><input type="password" id="password1" value="" placeholder="********"></label>
                <div class="clear"></div>
                <br>
            </div>

        </div>

    </div>
    <div class="modal-foot-btn">
        <a href="javascript:void(0);" id="delete_ok" class="red lbtn"><?php echo __("admin/orders/delete-ok"); ?></a>
    </div>
</div>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1>
                    <strong><?php echo __("admin/tools/page-tasks"); ?></strong>
                </h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="green-info">
                <div class="padding15">
                    <i class="fa fa-info-circle"></i>
                    <p><?php echo __("admin/tools/tasks-desc"); ?></p>
                </div>
            </div>

            <a href="<?php echo $links["create"]; ?>" class="green lbtn">+ <?php echo __("admin/tools/tasks-create"); ?></a>

            <div class="clear"></div>
            <br>

            <div id="operation-loading" class="blur-text" style="display: none">
                <i class="fa fa-cog loadingicon" aria-hidden="true"></i>
                <div class="clear"></div>
                <strong><?php echo __("admin/orders/list-row-operation-processing"); ?></strong>
            </div>

            <div id="tableList">
                <table width="100%" id="tasksTable" class="table table-striped table-borderedx table-condensed nowrap">
                    <thead style="background:#ebebeb;">
                    <tr>
                        <th align="left">#</th>
                        <th align="left" data-orderable="false"><?php echo __("admin/tools/tasks-title"); ?></th>
                        <th align="left" data-orderable="false"><?php echo __("admin/tools/tasks-admin"); ?></th>
                        <th align="left" data-orderable="false"><?php echo __("admin/tools/tasks-user"); ?></th>
                        <th align="center" data-orderable="false"><?php echo __("admin/tools/tasks-date"); ?> / <?php echo __("admin/tools/tasks-duedate"); ?></th>
                        <th align="center" data-orderable="false"><?php echo __("admin/tools/tasks-status"); ?></th>
                        <th align="center" data-orderable="false"></th>
                    </tr>
                    </thead>
                    <tbody align="center" style="border-top:none;"></tbody>
                </table>
            </div>


        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>