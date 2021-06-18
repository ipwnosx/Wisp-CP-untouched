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

            <div class="adminpagecon">

                <div class="formcon">
                    <div class="yuzde30"><?php echo __("admin/tools/tasks-title"); ?></div>
                    <div class="yuzde70">
                        <?php echo $task["title"]; ?>
                    </div>
                </div>

                <div class="formcon">
                    <div class="yuzde30"><?php echo __("admin/tools/tasks-description"); ?></div>
                    <div class="yuzde70">
                        <?php echo nl2br($task["description"]); ?>
                    </div>
                </div>

                <div class="formcon">
                    <div class="yuzde30"><?php echo __("admin/tools/tasks-user"); ?></div>
                    <div class="yuzde70">
                        <?php echo $user["full_name"]; echo $user["company_name"] ? " - ".$user["company_name"] : ''; ?>
                    </div>
                </div>

                <div class="formcon">
                    <div class="yuzde30"><?php echo __("admin/tools/tasks-date"); ?> / <?php echo __("admin/tools/tasks-duedate"); ?></div>
                    <div class="yuzde70">
                        <?php echo DateManager::format(Config::get("options/date-format"),$task["c_date"]); ?>
                        <?php echo substr($task["due_date"],0,4) == "1881" ? ' / '.___("needs/none") : ' / '.DateManager::format(Config::get("options/date-format"),$task["due_date"]); ?>
                    </div>
                </div>

                <form action="<?php echo $links["controller"]; ?>" method="post" id="editForm" style="margin-top: 5px;">
                    <input type="hidden" name="operation" value="edit_task">
                    <input type="hidden" name="id" value="<?php echo $task["id"]; ?>">

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
                        <div class="yuzde30"><?php echo __("admin/tools/tasks-status-note"); ?></div>
                        <div class="yuzde70">
                            <textarea name="status_note" rows="3"><?php echo $task["status_note"]; ?></textarea>
                        </div>
                    </div>

                    <div class="clear"></div>


                    <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                        <a class="yesilbtn gonderbtn" id="editForm_submit" href="javascript:void(0);"><?php echo ___("needs/button-update"); ?></a>
                    </div>

                </form>




            </div>


            <div class="clear"></div>
        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>