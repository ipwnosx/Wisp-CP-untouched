<!DOCTYPE html>
<html>
<head>
    <?php
        Utility::sksort($lang_list,"local");
        $privilege      = Admin::isPrivilege(["TICKETS_PREDEFINED_REPLIES"]);
        $plugins        = ['dataTables','tinymce-1'];
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
                responsive: true,
                "language":{"url":"<?php echo APP_URI; ?>/<?php echo ___("package/code"); ?>/datatable/lang.json"}
            });
        });

        function open_my_tab(elem,wrap_id){
            $(elem).addClass('active');
            $('#'+wrap_id+' .tablinks').not(elem).removeClass('active');
            var index = $(elem).parent().index();
            $('#'+wrap_id+' .tabcontent').css('display','none');
            $('#'+wrap_id+' .tabcontent:eq('+index+')').css('display','block');
        }
    </script>

</head>
<body>

<div style="display: none;" id="editCategory" data-izimodal-title="<?php echo __("admin/tickets/predefined-replies-edit-category"); ?>">
    <div class="padding20">
        <form action="<?php echo $links["controller"]; ?>?id=<?php echo $category["id"]; ?>" method="post" id="editCategoryForm">
            <input type="hidden" name="operation" value="edit_predefined_reply_category">

            <ul class="tab">
                <?php
                    foreach($lang_list AS $lang){
                        ?>
                        <li><a href="javascript:void(0);" class="tablinks<?php echo $lang["local"] ? ' active"' : '' ;?>" onclick="open_my_tab(this,'editCategoryForm');"> <?php echo strtoupper($lang["key"]); ?></a></li>
                        <?php
                    }
                ?>
            </ul>

            <?php
                $getCategory = $functions["category"];
                foreach($lang_list AS $lang){
                    $lkey = $lang["key"];
                    $cat  = $getCategory($lkey);
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
                                                foreach($parent_categories AS $cat){
                                                    if($cat["id"] != $category["id"]){
                                                        ?>
                                                        <option<?php echo $category["parent"] == $cat["id"] ? ' selected' : ''; ?> value="<?php echo $cat["id"]; ?>"><?php echo $cat["title"]; ?></option>
                                                        <?php
                                                    }
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
                                <input type="text" name="title[<?php echo $lkey; ?>]" value="<?php echo $cat["title"]; ?>">
                            </div>
                        </div>


                    </div>
                    <?php
                }
            ?>

            <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                <a class="yesilbtn gonderbtn" id="editCategoryForm_submit" href="javascript:void(0);"><?php echo __("admin/tickets/button-save"); ?></a>
            </div>
            <div class="clear"></div>

        </form>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#editCategoryForm_submit").on("click",function(){
                    MioAjaxElement($(this),{
                        waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                        progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                        result:"editCategoryForm_handler",
                    });
                });

                var _delete = _GET("delete");
                if(_delete != '' && _delete){
                    setTimeout(function(){
                        alert_success('<?php echo htmlspecialchars(__("admin/tickets/success11"),ENT_QUOTES); ?>',{timer:2000});
                    },500);
                }

            });

            function editCategoryForm_handler(result){
                if(result != ''){
                    var solve = getJson(result);
                    if(solve !== false){
                        if(solve.status == "error"){
                            if(solve.for != undefined && solve.for != ''){
                                $("#editCategoryForm "+solve.for).focus();
                                $("#editCategoryForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                $("#editCategoryForm "+solve.for).change(function(){
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

            function deleteReply(id){
                if(confirm("<?php echo htmlspecialchars(__("admin/tickets/delete-are-youu-sure"),ENT_QUOTES); ?>")){
                    window.location.href = "<?php echo $links["controller"]; ?>?id=<?php echo $category["id"]; ?>&delete="+id;
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
                    <strong><?php echo __("admin/tickets/page-predefined-replies-edit",['{category}' => $category["title"]]); ?></strong>

                </h1>

                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <a href="<?php echo $links["add-reply"]; ?>" class="green lbtn"><i class="fa fa-plus"></i> <?php echo __("admin/tickets/predefined-replies-add-reply"); ?></a>
            <a href="javascript:open_modal('editCategory');void 0;" class="blue lbtn"><i class="fa fa-pencil-square-o"></i> <?php echo __("admin/tickets/predefined-replies-edit-category"); ?></a>
            <div class="clear"></div>
            <br>




            <div class="clear"></div>
            <br>
            <table width="100%" id="datatable" class="table table-striped table-borderedx table-condensed nowrap">
                <thead style="background:#ebebeb;">
                <tr>
                    <th align="left">#</th>
                    <th align="left" data-orderable="false"><?php echo __("admin/tickets/predefined-replies-th-name"); ?></th>
                    <th align="center" data-orderable="false"></th>
                </tr>
                </thead>
                <tbody align="center" style="border-top:none;">
                <?php
                    if(isset($list) && $list){
                        foreach($list AS $k=>$row){
                            ?>
                            <tr>
                                <td><?php echo $k; ?></td>
                                <td align="left"><?php echo $row["name"]; ?></td>
                                <td align="center">
                                    <a class="sbtn" href="<?php echo $links["edit-reply"].$row["id"]; ?>"><i class="fa fa-pencil"></i></a>
                                    <a class="red sbtn" href="javascript:deleteReply(<?php echo $row["id"]; ?>);void 0;"><i class="fa fa-trash"></i></a>
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