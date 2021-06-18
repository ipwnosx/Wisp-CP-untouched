<?php
    $inc    = Filter::init("GET/bring","route");
    if($inc){

        die();
    }
?>
<!DOCTYPE html>
<html>
<head>
    <?php
        $privOperation  = Admin::isPrivilege("MANAGE_WEBSITE_OPERATION");
        $privDelete     = Admin::isPrivilege("MANAGE_WEBSITE_DELETE");
        $plugins        = ['dataTables'];
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
                "sAjaxSource": "<?php echo $links["ajax"]; ?>",
                responsive: true,
                "oLanguage":<?php include __DIR__.DS."datatable-lang.php"; ?>
            });

        });

        function deletePage(id,name){
            var content = "<?php echo __("admin/manage-website/delete-are-you-sure"); ?>";
            $("#confirmModal_text").html(content.replace("{name}",name));

            open_modal("ConfirmModal",{
                title:"<?php echo __("admin/manage-website/delete-blog-title"); ?>"
            });

            $("#delete_ok").click(function(){
                var request = MioAjax({
                    button_element:$(this),
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    action: "<?php echo $links["controller"]; ?>",
                    method: "POST",
                    data: {operation:"delete_page",id:id}
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

<div id="settingsModal" style="display: none" data-izimodal-title="<?php echo __("admin/manage-website/button-settings"); ?>">
    <div class="padding20">

        <form action="<?php echo $links["controller"]; ?>" method="post" id="settingsForm">
            <input type="hidden"  name="operation" value="settings_blog">

            <div class="formcon">

                <?php echo __("admin/manage-website/settings-comment-embed-code"); ?>
                <div class="clear"></div>


                <textarea placeholder="<?php echo __("admin/manage-website/settings-comment-embed-code-i"); ?>" name="comment_embed_code" rows="5"><?php echo $settings["comment-embed-code"]; ?></textarea>
                <span class="kinfo">{SITE-URL}, {REQUEST-URL}</span>
            </div>

            <div class="guncellebtn yuzde30" style="float: right;">
                <a id="settingsForm_submit" href="javascript:void(0);" class="yesilbtn gonderbtn"><?php echo ___("needs/button-update"); ?></a>
            </div>

        </form>
        <script>
            $(document).ready(function(){

                $("#settingsForm_submit").on("click",function(){
                    MioAjaxElement($(this),{
                        waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                        progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                        result:"settingsForm_handler",
                    });
                });
            });

            function settingsForm_handler(result){
                if(result != ''){
                    var solve = getJson(result);
                    if(solve !== false){
                        if(solve.status == "error"){
                            if(solve.for != undefined && solve.for != ''){
                                $("#settingsForm "+solve.for).focus();
                                $("#settingsForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                $("#settingsForm "+solve.for).change(function(){
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

        <div class="clear"></div>
    </div>
</div>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1>
                    <strong><?php echo __("admin/manage-website/page-blogs-list");?></strong>
                </h1>

                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <?php if($privOperation): ?>
                <div style="float: left; margin-right: 5px;">
                    <a class="green lbtn" href="<?php echo $links["create"]; ?>">+ <?php echo __("admin/manage-website/button-add-blog-page"); ?></a>
                </div>
            <?php endif; ?>

            <div style="float: left;">
                <a class="blue lbtn" href="<?php echo $links["categories"]; ?>"><?php echo __("admin/manage-website/button-categories"); ?></a>
            </div>

            <div style="float: right;">
                <a class="lbtn" href="javascript:open_modal('settingsModal');void 0;"><i class="fa fa-cog"></i> <?php echo __("admin/manage-website/button-settings"); ?></a>
            </div>

            <div class="clear"></div>
            <br>

            <table width="100%" id="datatable" class="table table-striped table-borderedx table-condensed nowrap">
                <thead style="background:#ebebeb;">
                <tr>
                    <th align="left" data-orderable="false">#</th>
                    <th align="left" data-orderable="false"><?php echo __("admin/manage-website/list-th-title"); ?></th>
                    <th align="left" data-orderable="false"><?php echo __("admin/manage-website/list-th-url-address"); ?></th>
                    <th align="center" data-orderable="false"><?php echo __("admin/manage-website/list-th-category"); ?></th>
                    <th align="center" data-orderable="false"><?php echo __("admin/manage-website/list-th-cdate"); ?></th>
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