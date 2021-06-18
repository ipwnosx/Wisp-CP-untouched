<?php
    $inc    = Filter::init("GET/inc","route");
    if($inc){

        if($inc == "groups"){

            if(isset($groups) && $groups){
                foreach($groups AS $k=>$row){
                    ?>
                    <tr id="group-ix-<?php echo $k; ?>">
                        <td align="left">
                            <input type="hidden" name="id[]" value="<?php echo $row["id"]; ?>">
                            <input type="text" name="name[]" value="<?php echo $row["name"]; ?>">
                        </td>
                        <td align="left">
                            <input type="text" name="description[]" value="<?php echo $row["description"]; ?>">
                        </td>
                        <td align="center">
                            <a href="javascript:deleteGroup(<?php echo $k; ?>,<?php echo $row["id"]; ?>);void 0;" class="red sbtn"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php
                }
            }

        }

        die();
    }
?>
<!DOCTYPE html>
<html>
<head>
    <?php
        $privOperation  = Admin::isPrivilege("USERS_OPERATION");
        $privDelete     = Admin::isPrivilege("USERS_DELETE");
        $plugins        = ['dataTables','select2','mio-icons'];
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
                    }
                ],
                "lengthMenu": [
                    [10, 25, 50, -1], [10, 25, 50, "<?php echo ___("needs/allOf"); ?>"]
                ],
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": "<?php echo $links["ajax"]; echo isset($group) ? "&group=".$group["id"] : ''; ?>",
                responsive: true,
                "oLanguage":<?php include __DIR__.DS."datatable-lang.php"; ?>
            });

            $("#group").change(function(){
                var value = $(this).val();

                if(value != '') window.location.href = "<?php echo $links["controller"]; ?>?group="+value;

            });

            setTimeout(function(){
                getGroupList();
            },1000);

            $("#groupManagment").on("click","#manageGroupForm_submit",function(){
                MioAjaxElement($(this),{
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                    result:"manageGroupForm_handler",
                });
            });

        });

        function manageGroupForm_handler(result){
            if(result != ''){
                var solve = getJson(result);
                if(solve !== false){
                    if(solve.status == "error"){
                        if(solve.for != undefined && solve.for != ''){
                            $("#manageGroupForm "+solve.for).focus();
                            $("#manageGroupForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                            $("#manageGroupForm "+solve.for).change(function(){
                                $(this).removeAttr("style");
                            });
                        }
                        if(solve.message != undefined && solve.message != '')
                            alert_error(solve.message,{timer:5000});
                    }else if(solve.status == "successful"){
                        alert_success(solve.message,{timer:2000});
                        getGroupList();
                    }
                }else
                    console.log(result);
            }
        }

        function getGroupList(){
            var request = MioAjax({action:"<?php echo $links["controller"]; ?>?inc=groups"},true,true);
            request.done(function(result){
                $("#getGroupList").html(result);
            });
        }

        function addGroup(){
            var template    = $("#add-group-template").html();
            var lastIndex   = $("#getGroupList tr:last-child").index();
            var newIndex    = lastIndex+1;

            template        = template.replace(/{index}/g,newIndex);

            $("#getGroupList").append(template);

        }

        function deleteGroup(key,id){
            if(id){
                var request = MioAjax({
                    action:"<?php echo $links["controller"]; ?>",
                    method:"POST",
                    data:{
                        operation:"delete_group",
                        id:id,
                    },
                },true,true);

                request.done(function(result){

                    getGroupList();

                });

            }else{
                $("#group-ix-"+key).remove();
            }
        }


        function deleteUser(id){

            $("#password1").val('');

            open_modal("deleteUserModal",{
                title:"<?php echo __("admin/users/detail-summary-delete-everything-about-user"); ?>"
            });

            $("#deleteUserModal .delete_ok").click(function(){
                var password = $('#password1').val();
                var request = MioAjax({
                    button_element:$(this),
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    action: "<?php echo $links["controller"]; ?>",
                    method: "POST",
                    data: {operation:"delete_user",id:id,password:password}
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
                                    table.ajax.reload();
                                }
                            }else
                                console.log(result);
                        }
                    }else console.log(result);
                });

            });

            $("#deleteUserModal .delete_no").on("click",function(){
                close_modal("deleteUserModal");
                $("#password1").val('');
            });

        }

    </script>

</head>
<body>

<div id="deleteUserModal" style="display: none;">
    <div class="padding20">
        <div align="center">

            <p><?php echo __("admin/users/delete-everything-about-user-message"); ?></p>
            <div class="clear"></div>
            <div id="password_wrapper">
                <label><?php echo ___("needs/permission-delete-item-password-desc"); ?><br><br><strong><?php echo ___("needs/permission-delete-item-password"); ?></strong> <br><input type="password" id="password1" value="" placeholder="********"></label>
            </div>

        </div>
    </div>
    <div class="modal-foot-btn">
        <a href="javascript:void(0);" class="delete_ok red lbtn"><?php echo ___("needs/ok"); ?></a>
    </div>
</div>


<table style="display: none;">
    <tbody id="add-group-template">
    <tr id="group-ix-{index}">
        <td align="left">
            <input type="text" name="name[]" value="">
        </td>
        <td align="left">
            <input type="text" name="description[]" value="">
        </td>
        <td align="center">
            <a href="javascript:deleteGroup('{index}');void 0;" class="red sbtn"><i class="fa fa-trash"></i></a>
        </td>
    </tr>
    </tbody>
</table>

<div id="groupManagment" style="display: none;" data-izimodal-title="<?php echo __("admin/users/button-manage-groups"); ?>">
    <div class="padding20">

        <form action="<?php echo $links["controller"]; ?>" method="post" id="manageGroupForm">
            <input type="hidden" name="operation" value="manage_groups">
            <table width="100%" class="table table-striped table-borderedx table-condensed nowrap">
                <thead style="background:#ebebeb;">
                <tr>
                    <th align="left"><?php echo __("admin/users/list-groups-th-name"); ?></th>
                    <th align="left"><?php echo __("admin/users/list-groups-th-desc"); ?></th>
                    <th align="center"></th>
                </tr>
                </thead>
                <tbody align="center" style="border-top:none;" id="getGroupList"></tbody>
            </table>

            <div class="clear"></div>
            <br>

            <a href="javascript:addGroup();void 0;" class="lbtn">+ <?php echo __("admin/users/button-add-group"); ?></a>


            <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                <a class="yesilbtn gonderbtn" id="manageGroupForm_submit" href="javascript:void(0);"><?php echo __("admin/users/button-update"); ?></a>
            </div>
            <div class="clear"></div>

        </form>


    </div>
</div>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1>
                    <strong><?php echo __("admin/users/page-list");?></strong>
                    <?php if(isset($group)): ?>
                        <?php echo "<strong>(".$group["name"].")</strong>"; echo $group["description"] ? " - ".$group["description"] : ''; ?>
                    <?php endif; ?>
                </h1>

                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>


            <div class="userlist-groups" style="float: left;">
                <select id="group" class="width200">
                    <option value=""><?php echo __("admin/users/select-group"); ?></option>
                    <option value="0"><?php echo ___("needs/allOf"); ?></option>
                    <?php
                        if(isset($groups) && $groups){
                            foreach($groups AS $row){
                                ?>
                                <option<?php echo isset($group) && $group["id"] == $row["id"] ? ' selected' : ''; ?> value="<?php echo $row["id"]; ?>"><?php echo $row["name"]; ?></option>
                                <?php
                            }
                        }
                    ?>
                </select>

                <?php if($privOperation): ?>
                    <a class="lbtn" href="javascript:open_modal('groupManagment');void 0;"><?php echo __("admin/users/button-manage-groups"); ?></a>
                <?php endif; ?>
            </div>

            <?php if($privOperation): ?>
                <div align="right">
                    <a class="green lbtn" href="<?php echo $links["create"]; ?>">+ <?php echo __("admin/users/button-create-user"); ?></a>
                </div>
            <?php endif; ?>

            <div class="clear"></div>

            <table width="100%" id="datatable" class="table table-striped table-borderedx table-condensed nowrap">
                <thead style="background:#ebebeb;">
                <tr>
                    <th align="left" data-orderable="false">#</th>
                    <th align="left" data-orderable="false"><?php echo __("admin/users/list-th-name"); ?></th>
                    <th align="center" data-orderable="false"><?php echo __("admin/users/list-th-email"); ?></th>
                    <th align="center" data-orderable="false"><?php echo __("admin/users/list-th-cc-cy"); ?></th>
                    <th align="center" data-orderable="false"><?php echo __("admin/users/list-th-group"); ?></th>
                    <th align="center" data-orderable="false"><?php echo __("admin/users/list-th-date"); ?></th>
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