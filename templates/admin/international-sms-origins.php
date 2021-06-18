<!DOCTYPE html>
<html>
<head>
    <?php
        $privOperation  = Admin::isPrivilege("PRODUCTS_OPERATION");
        $plugins        = ['dataTables'];
        include __DIR__.DS."inc".DS."head.php";
    ?>

    <style type="text/css">
        #datatable tbody tr td:nth-child(1) {text-align: left;}
    </style>
    <script>
        var table;
        $(document).ready(function() {
            table = $('#datatable').DataTable({
                "columnDefs": [
                    {
                        "targets": [0],
                        "visible":false,
                        "searchable": false
                    },
                    {
                        "targets": [1,2,3,4],
                        orderable:false,
                    },
                ],
                "aaSorting" : [[0, 'asc']],
                "lengthMenu": [
                    [10, 25, 50, -1], [10, 25, 50, "<?php echo ___("needs/allOf"); ?>"]
                ],
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": "<?php echo $links["ajax-origins"]; ?>",
                responsive: true,
                "oLanguage":<?php include __DIR__.DS."datatable-lang.php"; ?>
            });
        });
    </script>

</head>
<body>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1>
                    <strong><?php echo __("admin/products/page-intl-sms-origins"); ?></strong>
                </h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="clear"></div>
            <br>

            <div id="editOrigin" style="display: none;" data-izimodal-title="<?php echo __("admin/products/intl-sms-edit-origin"); ?>">
                <div class="padding20">

                    <form action="<?php echo $links["controller"]; ?>" method="post" id="editOrigin">
                        <input type="hidden" name="operation" value="update_intl_sms_origin">
                        <input type="hidden" name="oid" id="origin_id" value="">

                        <div class="formcon">
                            <div class="yuzde30"><?php echo __("admin/products/intl-sms-origin-list-name"); ?></div>
                            <div class="yuzde70">
                                <input type="text" name="name" value="" id="origin_name">
                            </div>
                        </div>

                        <table id="preregs" width="100%" class="table table-striped table-borderedx table-condensed nowrap">
                            <thead style="background:#ebebeb;">
                            <tr>
                                <th align="left"><?php echo __("admin/products/intl-sms-origin-prereg-list-country"); ?></th>
                                <th align="center"><?php echo __("admin/products/intl-sms-origin-prereg-list-attachments"); ?></th>
                                <th align="center"><?php echo __("admin/products/intl-sms-origin-prereg-list-status"); ?></th>
                                <th align="center"><?php echo __("admin/products/intl-sms-origin-prereg-list-status-msg"); ?></th>
                            </tr>
                            </thead>
                            <tbody align="center" style="border-top:none;">

                            </tbody>
                        </table>


                        <?php if($privOperation): ?>
                            <div style="float:right;margin-bottom:20px;" class="guncellebtn yuzde30">
                                <a id="editOrigin_submit" class="yesilbtn gonderbtn" href="javascript:void(0);"><?php echo __("admin/orders/update-button"); ?></a>
                            </div>
                        <?php endif; ?>

                    </form>
                    <script type="text/javascript">
                        $(document).ready(function(){

                            $("#editOrigin_submit").on("click",function(){
                                MioAjaxElement($(this),{
                                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                                    progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                                    result:"editOrigin_handler",
                                });
                            });

                        });

                        function editOrigin_handler(result){
                            if(result != ''){
                                var solve = getJson(result);
                                if(solve !== false){
                                    if(solve.status == "error"){
                                        if(solve.for != undefined && solve.for != ''){
                                            $("#editOrigin "+solve.for).focus();
                                            $("#editOrigin "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                            $("#editOrigin "+solve.for).change(function(){
                                                $(this).removeAttr("style");
                                            });
                                        }
                                        if(solve.message != undefined && solve.message != '')
                                            alert_error(solve.message,{timer:5000});
                                    }else if(solve.status == "successful"){
                                        alert_success(solve.message,{timer:2000});
                                        table.ajax.reload();
                                    }
                                }else
                                    console.log(result);
                            }
                        }
                    </script>

                </div>
            </div>

            <script type="text/javascript">
                function editOrigin(id){
                    open_modal("editOrigin");

                    var origin_name = $("#origin_"+id+"_name").html();

                    $("#origin_id").val(id);
                    $("#origin_name").val(origin_name);
                    $("#preregs tbody").html('');
                    $(".origin-"+id+"-prereg").each(function(){
                        var wrap = $(this);
                        var prereg_id    = $("input[name=prereg_id]",wrap).val();
                        var country_name = $("input[name=country_name]",wrap).val();
                        var attachments  = $(".attachments",wrap).html();
                        var status       = $("input[name=status]",wrap).val();
                        var situations   =
                            '<select name="status['+prereg_id+']">' +
                            '<option value="waiting"><?php echo __("admin/products/status-waiting"); ?></option>' +
                            '<option value="active"><?php echo __("admin/products/status-active"); ?></option>' +
                            '<option value="inactive"><?php echo __("admin/products/status-inactive"); ?></option>' +
                            '</select>' +
                            '';
                            situations   = situations.replace('<option value="'+status+'"','<option selected value="'+status+'"');
                        status           = situations;
                        var statusMsg    = $("textarea[name=status_msg]",wrap).val();
                        var status_msg   = '<input name="status_msg['+prereg_id+']" value="'+statusMsg+'">';
                        var content = '';
                        content += '<tr>';
                        content += '<td align="left">'+country_name+'</td>';
                        content += '<td align="center">'+attachments+'</td>';
                        content += '<td align="center">'+status+'</td>';
                        content += '<td align="center">'+status_msg+'</td>';
                        content +='</tr>';
                        $("#preregs tbody").append(content);
                    });


                }

                function deleteOrigin(id){

                    swal({
                        title: '<?php echo __("admin/products/intl-sms-delete-origin-alert-title"); ?>',
                        text: "<?php echo __("admin/products/intl-sms-delete-origin-alert-body"); ?>",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: '<?php echo __("admin/products/delete-ok"); ?>',
                        cancelButtonText: '<?php echo __("admin/products/delete-no"); ?>'
                    }).then(function(){

                        var request = MioAjax({
                            action:"<?php echo $links["controller"];?>",
                            method:"POST",
                            data:{operation:"delete_intl_sms_origin",id:id}
                        },true,true);

                        request.done(function(res){
                            if(res != ''){
                                var solve = getJson(res);
                                if(solve && typeof solve == "object"){
                                    if(solve.status == "error"){
                                        swal({
                                            title: '<?php echo ___("needs/error"); ?>',
                                            text: solve.message,
                                            type: 'error',
                                            showConfirmButton: false,
                                            timer: 3000,
                                        });
                                    }else if(solve.status == "successful"){
                                        var timer = 1500;
                                        swal({
                                            title: '<?php echo __("admin/products/deleted"); ?>',
                                            text: '<?php echo __("admin/products/success35"); ?>',
                                            type: 'success',
                                            showConfirmButton: false,
                                            timer: timer,
                                        });
                                        table.ajax.reload();
                                    }
                                }else
                                    console.log(res);
                            }
                        });
                    });

                }
            </script>

            <table width="100%" id="datatable" class="table table-striped table-borderedx table-condensed nowrap">
                <thead style="background:#ebebeb;">
                <tr>
                    <th align="left">#</th>
                    <th align="left"><?php echo __("admin/products/intl-sms-origin-list-user"); ?></th>
                    <th align="center"><?php echo __("admin/products/intl-sms-origin-list-name"); ?></th>
                    <th align="center"><?php echo __("admin/products/intl-sms-origin-list-pre-reg-countries"); ?></th>
                    <th align="center"> </th>
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