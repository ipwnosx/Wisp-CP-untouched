<!DOCTYPE html>
<html>
<head>
    <?php
        Utility::sksort($lang_list,"local",'select2');
        $plugins    = ['dataTables','select2'];
        include __DIR__.DS."inc".DS."head.php";
    ?>
    <script type="text/javascript">
        var table,select2_element;
        $(document).ready(function(){

            var tab2 = _GET("lang");
            if (tab2 != '' && tab2 != undefined) {
                $("#tab-lang .tablinks[data-tab='" + tab2 + "']").click();
            } else {
                $("#tab-lang .tablinks:eq(0)").addClass("active");
                $("#tab-lang .tabcontent:eq(0)").css("display", "block");
            }

            table = $('#datatable').DataTable({
                "columnDefs": [
                    {
                        "targets": [0],
                        "visible":false,
                    },
                ],
                "lengthMenu": [
                    [10, 25, 50, -1], [10, 25, 50, "<?php echo ___("needs/allOf"); ?>"]
                ],
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": "<?php echo $links["ajax"]; ?>",
                responsive: true,
                "oLanguage":<?php include __DIR__.DS."datatable-lang.php"; ?>
            });

        });

        function addDepartment(){
            open_modal('manageDepartment');

            select2_element = $("#appointees");
            select2_element.select2({width:"100%"});
            $('.select2-container').slice(1).remove();

            $("#manageDepartment input[name=operation]").val('add_department');

            $("#manageDepartment textarea").val('');
            $("#manageDepartment").attr("data-izimodal-title",'<?php echo __("admin/departments/button-add"); ?>');

            $("#manageDepartment select[name='appointees[]'] option").removeAttr("selected").trigger("change");

            $("#manageDepartmentForm_submit").html('<?php echo ___("needs/button-create"); ?>');
        }

        function editDepartment(id){

            $("#manageDepartment").attr("data-izimodal-title",'<?php echo htmlspecialchars(__("admin/departments/edit-department-title"),ENT_QUOTES); ?>');

            $("#manageDepartment input[name=operation]").val('edit_department');
            $("#manageDepartment input[name=id]").val(id);

            $("#manageDepartmentForm_submit").html('<?php echo ___("needs/button-update"); ?>');

            open_modal('manageDepartment');

            select2_element = $("#appointees");
            select2_element.select2({width:"100%"});
            $('.select2-container').slice(1).remove();

            $.get('<?php echo $links["controller"]; ?>?operation=get_department&id='+id,function(result) {
                if(result != ''){
                    var solve = getJson(result);
                    if(solve !== false){

                        $("#manageDepartment input[name=rank]").val(solve.rank);
                        $("#manageDepartment select[name='appointees[]'] option").removeAttr("selected").trigger("change");

                        if(solve.appointees != undefined && solve.appointees){
                            $(solve.appointees).each(function(k,v){
                                $("#manageDepartment select[name='appointees[]'] option[value='"+v+"']").attr("selected",true).trigger("change");
                            });
                        }

                        var values      = solve.values,key;
                        var keys        = Object.keys(values);
                        var size        = keys.length-1;
                        for(var i = 0; i<= size; i++) {
                            key = keys[i];
                            $("#manageDepartment input[name='name["+key+"]']").val(values[key].name);
                            $("#manageDepartment textarea[name='description["+key+"]']").val(values[key].description);
                        }

                    }else
                        console.log(result);
                }
            });

        }

        function deleteDepartment(id){
            var content = "<?php echo __("admin/departments/delete-are-you-sure"); ?>";
            $("#confirmModal_text").html(content);

            open_modal("ConfirmModal",{
                title:"<?php echo __("admin/departments/delete-department-title"); ?>"
            });

            $("#delete_ok").click(function(){
                var request = MioAjax({
                    button_element:$(this),
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    action: "<?php echo $links["controller"]; ?>",
                    method: "POST",
                    data: {operation:"delete_department",id:id}
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
                                    table.ajax.reload();
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

<div id="ConfirmModal" style="display: none;">
    <div class="padding20">
        <p id="confirmModal_text"></p>
    </div>
    <div class="modal-foot-btn">
        <a id="delete_ok" href="javascript:void(0);" class="red lbtn"><?php echo ___("needs/yes"); ?></a>
    </div>
</div>

<div id="manageDepartment" style="display: none;" data-izimodal-title="<?php echo __("admin/departments/button-add"); ?>">
    <div class="padding20">

        <form action="<?php echo $links["controller"]; ?>" method="post" id="manageDepartmentForm">
            <input type="hidden" name="operation" value="add_department">
            <input type="hidden" name="id" value="0">

            <div id="tab-lang"><!-- tab wrap content start -->
                <ul class="tab">
                    <?php
                        foreach($lang_list AS $lang){
                            ?>
                            <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, '<?php echo $lang["key"]; ?>','lang')" data-tab="<?php echo $lang["key"]; ?>"> <?php echo strtoupper($lang["key"]); ?></a></li>
                            <?php
                        }
                    ?>
                </ul>

                <?php
                    foreach($lang_list AS $lang) {
                    $lkey = $lang["key"];

                ?>
                <div id="lang-<?php echo $lkey; ?>" class="tabcontent">

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/departments/manage-name"); ?></div>
                        <div class="yuzde70">
                            <input type="text" name="name[<?php echo $lkey; ?>]" value="">
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/departments/manage-description"); ?></div>
                        <div class="yuzde70">
                            <textarea name="description[<?php echo $lkey; ?>]"></textarea>
                        </div>
                    </div>

                    <?php if($lang["local"]): ?>
                        <div class="formcon">
                            <div class="yuzde30"><?php echo __("admin/departments/manage-appointees"); ?></div>
                            <div class="yuzde70">
                                <select id="appointees" name="appointees[]" multiple style="height: 150px;">
                                    <?php
                                        if($select_admins){
                                            foreach($select_admins AS $admin){
                                                ?>
                                                <option value="<?php echo $admin["id"]; ?>"><?php echo $admin["full_name"]; ?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="formcon">
                            <div class="yuzde30"><?php echo __("admin/departments/manage-rank"); ?></div>
                            <div class="yuzde70">
                                <input style="width: 100px;" type="text" name="rank" value="" onkeypress='return event.charCode>= 48 &&event.charCode<= 57'>
                            </div>
                        </div>
                    <?php endif; ?>


                    <div class="clear"></div>
                </div>
                        <?php
                    }
                ?>
            </div><!-- tab wrap content end -->

            <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                <a class="yesilbtn gonderbtn" id="manageDepartmentForm_submit" href="javascript:void(0);"><?php echo ___("needs/button-create"); ?></a>
            </div>

            <div class="clear"></div>

        </form>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#manageDepartmentForm_submit").on("click",function(){
                    MioAjaxElement($(this),{
                        waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                        progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                        result:"manageDepartmentForm_handler",
                    });
                });
            });

            function manageDepartmentForm_handler(result){
                if(result != ''){
                    var solve = getJson(result);
                    if(solve !== false){
                        if(solve.status == "error"){
                            if(solve.for != undefined && solve.for != ''){
                                $("#manageDepartmentForm "+solve.for).focus();
                                $("#manageDepartmentForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                $("#manageDepartmentForm "+solve.for).change(function(){
                                    $(this).removeAttr("style");
                                });
                            }
                            if(solve.message != undefined && solve.message != '')
                                alert_error(solve.message,{timer:5000});
                        }else if(solve.status == "successful"){
                            alert_success(solve.message,{timer:2000});
                            table.ajax.reload();
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
    </div>
</div>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1><strong><?php echo __("admin/departments/page"); ?></strong></h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <a href="javascript:addDepartment();void 0;" class="green lbtn">+ <?php echo __("admin/departments/button-add"); ?></a>

            <table width="100%" id="datatable" class="table table-striped table-borderedx table-condensed nowrap">
                <thead style="background:#ebebeb;">
                <tr>
                    <th align="left">#</th>
                    <th align="left" data-orderable="false"><?php echo __("admin/departments/th-name"); ?></th>
                    <th align="left" data-orderable="false"><?php echo __("admin/departments/th-appointees"); ?></th>
                    <th align="center" data-orderable="false"> </th>
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