<!DOCTYPE html>
<html>
<head>
    <?php
        Utility::sksort($lang_list,"local");
        $plugins    = ['select2'];
        include __DIR__.DS."inc".DS."head.php";
    ?>

    <script type="text/javascript">
        $(document).ready(function(){

            $("#editForm_submit").on("click",function(){
                MioAjaxElement($(this),{
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                    result:"editForm_handler",
                });
            });

            $("#select-user").select2({
                placeholder: "<?php echo __("admin/orders/create-select-user"); ?>",
                ajax: {
                    url: '<?php echo $links["select-users.json"]; ?>',
                    dataType: 'json',
                    data: function (params) {
                        var query = {
                            search: params.term,
                            type: 'public'
                        }
                        return query;
                    }
                }
            });

        });

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
                        alert_success(solve.message,{timer:2000});
                        if(solve.redirect != undefined && solve.redirect != ''){
                            setTimeout(function(){
                                window.location.href = solve.redirect;
                            },2000);
                        }
                    }
                }else
                    console.log(result);
            }
        }
    </script>

</head>
<body>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1><strong><?php echo $task["title"]; ?></strong></h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="clear"></div>

            <form action="<?php echo $links["controller"]; ?>" method="post" id="editForm" style="margin-top: 5px;">
                <input type="hidden" name="operation" value="edit_task">
                <input type="hidden" name="id" value="<?php echo $task["id"]; ?>">


                <div class="adminpagecon">

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/tools/tasks-title"); ?><br><span class="kinfo"><?php echo __("admin/tools/tasks-title-desc"); ?></span></div>
                        <div class="yuzde70">
                            <input type="text" name="title" value="<?php echo $task["title"]; ?>">
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/tools/tasks-description"); ?><br><span class="kinfo"><?php echo __("admin/tools/tasks-description-info"); ?></span></div>
                        <div class="yuzde70">
                            <textarea rows="5" name="description"><?php echo $task["description"]; ?></textarea>
                        </div>
                    </div>

                    <?php
                        if(isset($is_full_admin) && $is_full_admin){
                            ?>
                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/tools/tasks-assignment"); ?><br><span class="kinfo"><?php echo __("admin/tools/tasks-assignment-desc"); ?></span></div>
                                <div class="yuzde70">
                                    <input<?php echo $task["departments"] || (!$task["admin_id"] && !$task["departments"]) ? ' checked' : ''; ?> type="radio" class="radio-custom" id="assignment_department" name="assignment" value="department">
                                    <label class="radio-custom-label" style="margin-left: 10px;" for="assignment_department"><?php echo __("admin/tools/tasks-department"); ?></label>

                                    <input<?php echo $task["admin_id"] ? ' checked' : ''; ?> type="radio" class="radio-custom" id="assignment_personal" name="assignment" value="personal">
                                    <label class="radio-custom-label" style="margin-left: 10px;" for="assignment_personal"><?php echo __("admin/tools/tasks-personal"); ?></label>

                                    <div class="clear"></div>

                                    <div id="personal_selection" class="tasks_assignment" style="<?php echo $task["admin_id"] ? '' : 'display:none;'; ?>">
                                        <br>
                                        <select name="admin">
                                            <option value=""><?php echo ___("needs/select-your"); ?></option>
                                            <option value="0"><?php echo ___("needs/none"); ?></option>
                                            <?php
                                                if(isset($admins) && $admins){
                                                    foreach($admins AS $admin){
                                                        ?><option<?php echo $task["admin_id"] == $admin["id"] ? ' selected' : ''; ?> value="<?php echo $admin["id"]; ?>"><?php echo $admin["full_name"]; ?></option><?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>

                                    <div id="department_selection" style="<?php echo $task["departments"] || (!$task["admin_id"] && !$task["departments"]) ? '' : 'display:none;'; ?>" class="tasks_assignment">
                                        <br>
                                        <select name="department[]" multiple >
                                            <?php
                                                $task_departments = $task["departments"] ? explode(",",$task["departments"]) : [];
                                                if(isset($departments) && $departments){
                                                    foreach($departments AS $department){
                                                        ?><option<?php echo in_array($department["id"],$task_departments) ? ' selected' : ''; ?> value="<?php echo $department["id"]; ?>"><?php echo $department["name"]; ?></option><?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>

                                    <script type="text/javascript">
                                        $(document).ready(function(){
                                            $("input[name=assignment]").change(function(){
                                                var val = $(this).val();

                                                $(".tasks_assignment").css("display","none");
                                                $("#"+val+"_selection").css("display","block");
                                                $("#"+val+"_selection select option").prop("selected",false);
                                            });
                                        });
                                    </script>

                                </div>
                            </div>
                            <?php
                        }
                    ?>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/tools/tasks-user"); ?><br><span class="kinfo"><?php echo __("admin/tools/tasks-user-desc"); ?></span></div>
                        <div class="yuzde70">
                            <select name="user" id="select-user">
                                <?php
                                    if(isset($user) && $user){
                                        ?>
                                        <option value="<?php echo $user["id"]; ?>"><?php echo $user["full_name"]; echo $user["company_name"] ? " - ".$user["company_name"] : ''; ?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/tools/tasks-date"); ?> / <?php echo __("admin/tools/tasks-duedate"); ?></div>
                        <div class="yuzde70">
                            <input type="date" name="c_date" value="<?php echo $task["c_date"]; ?>" style="width: 150px;">
                            <input type="date" name="due_date" value="<?php echo substr($task["due_date"],0,4) == "1881" ? '' : $task["due_date"]; ?>" style="width: 150px;">
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/tools/tasks-status"); ?></div>
                        <div class="yuzde70">
                            <?php
                                if(isset($situations) && $situations){
                                    foreach($situations AS $key => $val){
                                        $val = Filter::html_clear($val);
                                        ?>
                                        <input<?php echo $task["status"] == $key ? ' checked' : ''; ?> value="<?php echo $key; ?>" class="radio-custom" id="status_<?php echo $key; ?>" name="status" type="radio">
                                        <label class="radio-custom-label" for="status_<?php echo $key; ?>" style="margin-left: 10px;"><?php echo $val; ?></label>
                                        <?php
                                    }
                                }
                            ?>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/tools/tasks-status-note"); ?><br><span class="kinfo"><?php echo __("admin/tools/tasks-status-note-desc"); ?></span></div>
                        <div class="yuzde70">
                            <textarea name="status_note" rows="5"><?php echo $task["status_note"]; ?></textarea>
                        </div>
                    </div>


                    <div class="clear"></div>


                    <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                        <a class="yesilbtn gonderbtn" id="editForm_submit" href="javascript:void(0);"><?php echo ___("needs/button-update"); ?></a>
                    </div>

                    <div class="clear"></div>

                </div>

                <div class="clear"></div>
            </form>


            <div class="clear"></div>
        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>