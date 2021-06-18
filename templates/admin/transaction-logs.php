<!DOCTYPE html>
<html>
<head>
    <?php
        $plugins    = ['dataTables'];
        include __DIR__.DS."inc".DS."head.php";
    ?>
    <script type="text/javascript">
        var actions;
        $(document).ready(function(){

            actions = $('#actionsTable').DataTable({
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
                "sAjaxSource": "<?php echo $links["ajax-actions"]; ?>",
                responsive: true,
                "oLanguage":<?php include __DIR__.DS."datatable-lang.php"; ?>
            });

        });
    </script>
 

    <script type="text/javascript">
        $(document).ready(function(){
            $("#clear_actions").on("click","#ok",function(){
                var date = $("#date").val();
                var psw  = $("#password").val();

                $("#password").val('');

                var request = MioAjax({
                    button_element:this,
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    action: "<?php echo $links["controller"]; ?>",
                    method: "POST",
                    data: {operation:"clear_actions",date:date,password:psw}
                },true,true);

                request.done(function(result){
                    if(result){
                        if(result != ''){
                            var solve = getJson(result);
                            if(solve !== false){
                                if(solve.status == "error"){
                                    if(solve.for != undefined && solve.for != ''){
                                        $("#clear_actions "+solve.for).focus();
                                        $("#clear_actions "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                        $("#clear_actions "+solve.for).change(function(){
                                            $(this).removeAttr("style");
                                        });
                                    }
                                    if(solve.message != undefined && solve.message != '')
                                        alert_error(solve.message,{timer:5000});
                                }else if(solve.status == "successful"){
                                    alert_success(solve.message,{timer:3000});
                                    actions.ajax.reload();
                                }
                            }else
                                console.log(result);
                        }
                    }else console.log(result);
                });

            });

            $("#clear_actions").on("click","#cancel",function(){
                close_modal("clear_actions");
            });


        });
    </script>
</head>
<body>

<div style="display: none;" data-izimodal-title="<?php echo __("admin/tools/actions-button-clear"); ?>" id="clear_actions">
    <div class="padding15">

        <div align="center" style="text-align: center;">
            <p><?php echo __("admin/tools/actions-clear-note"); ?></p>
            <p>
                <input type="date" name="date" id="date" class="width200" value="<?php echo DateManager::old_date(['month' => 1],"Y-m-d"); ?>">
            </p>

            <div id="password_wrapper">
                <label><?php echo ___("needs/permission-delete-item-password-desc"); ?><br><br><strong><?php echo ___("needs/permission-delete-item-password"); ?></strong> <br><input type="password" id="password" value="" placeholder="********"></label>
                <div class="clear"></div>
                <br>
            </div>
            <div class="clear"></div>

            <div class="yuzde50">
                <a href="javascript:void(0);" id="ok" class="gonderbtn redbtn"><i class="fa fa-check"></i> <?php echo ___("needs/ok"); ?></a>
            </div>
            <div class="yuzde50">
                <a href="javascript:void(0);" id="cancel" class="gonderbtn yesilbtn"><i class="fa fa-ban"></i> <?php echo ___("needs/button-cancel"); ?></a>
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
                    <strong><?php echo __("admin/tools/page-actions"); ?></strong>
                </h1>
                <a class="lbtn" href="javascript:void 0;" onclick="open_modal('clear_actions');"><?php echo __("admin/tools/actions-button-clear"); ?></a>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <table width="100%" id="actionsTable" class="table table-striped table-borderedx table-condensed nowrap">
                <thead style="background:#ebebeb;">
                <tr>
                    <th align="left">#</th>
                    <th align="left" data-orderable="false"><?php echo __("admin/tools/actions-user"); ?></th>
                    <th align="left" data-orderable="false"><?php echo __("admin/users/detail-actions-th-description"); ?></th>
                    <th align="center" data-orderable="false"><?php echo __("admin/users/detail-actions-th-date"); ?></th>
                    <th align="center" data-orderable="false"><?php echo __("admin/users/detail-actions-th-ip"); ?></th>
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