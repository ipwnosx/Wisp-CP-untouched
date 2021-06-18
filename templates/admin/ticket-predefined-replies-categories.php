<!DOCTYPE html>
<html>
<head>
    <?php
        Utility::sksort($lang_list,"local");

        $langJson = [];
        foreach($lang_list AS $lang) $langJson[] = $lang["key"];
        $langJson = Utility::jencode($langJson);

        $privilege      = Admin::isPrivilege(["TICKETS_PREDEFINED_REPLIES"]);
        $plugins        = ['dataTables','tinymce-1'];
        include __DIR__.DS."inc".DS."head.php";
    ?>
    <script>
        var table,langObj = <?php echo $langJson; ?>;
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
                responsive: true,
                "oLanguage":<?php include __DIR__.DS."datatable-lang.php"; ?>
            });
        });

        function open_my_tab(elem){
            $(elem).addClass('active');
            $('#manageCategory .tablinks').not(elem).removeClass('active');
            var index = $(elem).parent().index();
            $('#manageCategory .tabcontent').css('display','none');
            $('#manageCategory .tabcontent:eq('+index+')').css('display','block');
        }

        function deleteCategory(id){
            if(confirm("<?php echo htmlspecialchars(__("admin/tickets/delete-are-youu-sure"),ENT_QUOTES); ?>")){
                window.location.href = "<?php echo $links["controller"]; ?>?delete="+id;
            }
        }

        function add_category(){

            $("#manageCategory").attr("data-izimodal-title","<?php echo __("admin/tickets/category-button-add"); ?>");

            open_modal('manageCategory');

            $("#manageCategory input[name=operation]").val("add_predefined_reply_category");
            $("#manageCategory #modifyForm_submit").html('<?php echo ___("needs/button-create"); ?>');

            $("#manageCategory select[name='parent'] option").removeAttr("selected");

        }

        function edit_category(id){
            $("#manageCategory").attr("data-izimodal-title","<?php echo __("admin/tickets/category-button-edit"); ?>");

            open_modal('manageCategory');

            $("#manageCategory input[name=operation]").val("edit_predefined_reply_category");
            $("#manageCategory input[name=id]").val(id);
            $("#manageCategory #modifyForm_submit").html('<?php echo ___("needs/button-save"); ?>');

            var parent  = $("#row_"+id+"_parent").val();

            $("#manageCategory select[name='parent'] option").removeAttr("selected");
            $("#manageCategory select[name='parent'] option[value='"+parent+"']").attr("selected",true);

            $(langObj).each(function(k,v){
                var title = $("#row_"+id+"_"+v+"_title").val();
                $("#manageCategory input[name='title["+v+"]']").val(title);
            });


        }
    </script>

</head>
<body>

<div id="manageCategory" style="display:none;" data-izimodal-title="<?php echo __("admin/tickets/category-button-add"); ?>">
    <div class="padding20">

        <form action="<?php echo $links["controller"]; ?>" method="post" id="modifyForm">
            <input type="hidden" name="operation" value="add_predefined_reply_category">
            <input type="hidden" name="id" value="0">

            <ul class="tab">
                <?php
                    foreach($lang_list AS $lang){
                        ?>
                        <li><a href="javascript:void(0);" class="tablinks<?php echo $lang["local"] ? ' active"' : '' ;?>" onclick="open_my_tab(this);"> <?php echo strtoupper($lang["key"]); ?></a></li>
                        <?php
                    }
                ?>
            </ul>

            <?php
                foreach($lang_list AS $lang){
                    $lkey = $lang["key"];
                    ?>
                    <div<?php echo $lang["local"] ? ' style="display:block;"' : '' ;?> id="lang-<?php echo $lang["key"]; ?>" class="tabcontent">

                        <?php if($lang["local"]): ?>
                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/tickets/category-th-parent"); ?></div>
                                <div class="yuzde70">
                                    <select name="parent">
                                        <option value="0"><?php echo ___("needs/none"); ?></option>
                                        <?php
                                            if($parent_categories){
                                                foreach($parent_categories AS $category){
                                                    ?>
                                                    <option value="<?php echo $category["id"]; ?>"><?php echo $category["title"]; ?></option>
                                                    <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="formcon">
                            <div class="yuzde30"><?php echo __("admin/tickets/category-th-name"); ?></div>
                            <div class="yuzde70">
                                <input type="text" name="title[<?php echo $lkey; ?>]" value="">
                            </div>
                        </div>


                    </div>
                    <?php
                }
            ?>


            <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                <a class="yesilbtn gonderbtn" id="modifyForm_submit" href="javascript:void(0);"><?php echo ___("needs/button-create"); ?></a>
            </div>
            <div class="clear"></div>

        </form>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#modifyForm_submit").on("click",function(){
                    MioAjaxElement($(this),{
                        waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                        result:"modifyForm_handler",
                    });
                });

            });

            function modifyForm_handler(result){
                if(result != ''){
                    var solve = getJson(result);
                    if(solve !== false){
                        if(solve.status == "error"){
                            if(solve.for != undefined && solve.for != ''){
                                $("#modifyForm "+solve.for).focus();
                                $("#modifyForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                $("#modifyForm "+solve.for).change(function(){
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

    </div>
</div>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1>
                    <strong><?php echo __("admin/tickets/page-predefined-replies-categories"); ?></strong>

                </h1>

                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <a href="javascript:add_category();void 0;" class="green lbtn"><i class="fa fa-plus"></i> <?php echo __("admin/tickets/category-button-add"); ?></a>
            <div class="clear"></div>
            <br>

            <table width="100%" id="datatable" class="table table-striped table-borderedx table-condensed nowrap">
                <thead style="background:#ebebeb;">
                <tr>
                    <th align="left">#</th>
                    <th align="left" data-orderable="false"><?php echo __("admin/tickets/category-th-name"); ?></th>
                    <th align="left" data-orderable="false"><?php echo __("admin/tickets/category-th-parent"); ?></th>
                    <th align="center" data-orderable="false"></th>
                </tr>
                </thead>
                <tbody align="center" style="border-top:none;">
                <?php
                    if($list){
                        foreach($list AS $k=>$row){
                            ?>
                            <tr>
                                <td><?php echo $k; ?></td>
                                <td align="left"><?php echo $row["title"]; ?></td>
                                <td align="left"><?php echo $row["parent_title"]; ?></td>
                                <td align="center">
                                    <input type="hidden" id="row_<?php echo $row["id"]; ?>_parent" value="<?php echo $row["parent"]; ?>">
                                    <?php
                                        foreach($lang_list AS $lang){
                                            $ldata  = $get_cat_lang_data($row["id"],$lang["key"]);
                                            ?>
                                            <input type="hidden" id="row_<?php echo $row["id"]; ?>_<?php echo $lang["key"]; ?>_title" value="<?php echo isset($ldata["title"]) ? $ldata["title"] : false; ?>">
                                            <?php
                                        }
                                    ?>

                                    <a class="sbtn" href="javascript:edit_category(<?php echo $row["id"]; ?>);void 0;"><i class="fa fa-pencil"></i></a>
                                    <a class="red sbtn" href="javascript:deleteCategory(<?php echo $row["id"]; ?>);void 0;"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                ?>
                </tbody>
            </table>

            <div class="clear"></div>

        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>