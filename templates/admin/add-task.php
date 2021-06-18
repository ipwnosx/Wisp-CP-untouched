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

            $("#addNewForm_submit").on("click",function(){
                MioAjaxElement($(this),{
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                    result:"addNewForm_handler",
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
                <h1><strong><?php echo __("admin/tools/tasks-create"); ?></strong></h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="clear"></div>

            <form action="<?php echo $links["controller"]; ?>" method="post" id="addNewForm" style="margin-top: 5px;">
                <input type="hidden" name="operation" value="add_new_task">


                <div class="adminpagecon">

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/tools/tasks-title"); ?><br><span class="kinfo"><?php echo __("admin/tools/tasks-title-desc"); ?></span></div>
                        <div class="yuzde70">
                            <input type="text" name="title" value="">
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/tools/tasks-description"); ?><br><span class="kinfo"><?php echo __("admin/tools/tasks-description-info"); ?></span></div>
                        <div class="yuzde70">
                            <textarea rows="5" name="description"></textarea>
                        </div>
                    </div>

                    <?php
                        if(isset($is_full_admin) && $is_full_admin){
                            ?>
                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/tools/tasks-assignment"); ?><br><span class="kinfo"><?php echo __("admin/tools/tasks-assignment-desc"); ?></span></div>
                                <div class="yuzde70">
                                    <input checked type="radio" class="radio-custom" id="assignment_department" name="assignment" value="department">
                                    <label class="radio-custom-label" style="margin-left: 10px;" for="assignment_department"><?php echo __("admin/tools/tasks-department"); ?></label>


                                    <input type="radio" class="radio-custom" id="assignment_personal" name="assignment" value="personal">
                                    <label class="radio-custom-label" style="margin-left: 10px;" for="assignment_personal"><?php echo __("admin/tools/tasks-personal"); ?></label>


                                    <div class="clear"></div>

                                    <div id="personal_selection" style="display: none;" class="tasks_assignment">
                                        <br>
                                        <select name="admin">
                                            <option value=""><?php echo ___("needs/select-your"); ?></option>
                                            <option value="0"><?php echo ___("needs/none"); ?></option>
                                            <?php
                                                if(isset($admins) && $admins){
                                                    foreach($admins AS $admin){
                                                        ?><option value="<?php echo $admin["id"]; ?>"><?php echo $admin["full_name"]; ?></option><?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>

                                    <div id="department_selection" style="" class="tasks_assignment">
                                        <br>
                                        <select name="department[]" multiple>
                                            <?php
                                                if(isset($departments) && $departments){
                                                    foreach($departments AS $department){
                                                        ?><option value="<?php echo $department["id"]; ?>"><?php echo $department["name"]; ?></option><?php
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
                            <select name="user" id="select-user"></select>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/tools/tasks-date"); ?> / <?php echo __("admin/tools/tasks-duedate"); ?></div>
                        <div class="yuzde70">
                            <input type="date" name="c_date" value="<?php echo DateManager::format("Y-m-d"); ?>" style="width: 150px;">
                            <input type="date" name="due_date" value="<?php echo DateManager::next_date(['day' =>10],"Y-m-d"); ?>" style="width: 150px;">


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
                                        <input<?php echo $key == "waiting" ? ' checked' : ''; ?> value="<?php echo $key; ?>" class="radio-custom" id="status_<?php echo $key; ?>" name="status" type="radio">
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
                            <textarea name="status_note" rows="5"></textarea>
                        </div>
                    </div>

                    <?php
                        if(isset($is_full_admin) && $is_full_admin){
                            ?>
                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/tools/tasks-notification"); ?></div>
                                <div class="yuzde70">
                                    <input type="checkbox" name="notification" value="1" class="checkbox-custom" id="notification">
                                    <label class="checkbox-custom-label" for="notification"><span class="kinfo"><?php echo __("admin/tools/tasks-notification-desc"); ?></span></label>
                                </div>
                            </div>
                            <?php
                        }
                    ?>



                    <div class="clear"></div>


                    <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                        <a class="yesilbtn gonderbtn" id="addNewForm_submit" href="javascript:void(0);"><?php echo ___("needs/button-create"); ?></a>
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