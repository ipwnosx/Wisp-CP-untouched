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
    <style>
        #actionsTable tbody tr td:nth-child(1){
            text-align: left;
        }
        #actionsTable tbody tr td:nth-child(2){
            text-align: left;
        }
        #actionsTable tbody tr td:nth-child(3){
            text-align: left;
        }
    </style>

    <script type="text/javascript">
        $(document).ready(function(){

            $("#error-log-status,#error-debug-status,#development-status").on("change",function(){
                var request = MioAjax({
                    action:"<?php echo $links["controller"]; ?>",
                    method: "POST",
                    data:{
                        operation:"change_error_log_situations",
                        error_log   : $("#error-log-status").prop('checked') ? 1 : 0,
                        error_debug : $("#error-debug-status").prop('checked') ? 1 : 0,
                        development : $("#development-status").prop('checked') ? 1 : 0,
                    }
                },true,true);
            });
        });

        function details(id){
            open_modal("DetailsModal",{width:'1050px'});
            $("#details_con").html($("#detail_con_"+id).html());
        }
    </script>
</head>
<body>

<div style="display: none;" data-izimodal-title="<?php echo __("admin/tools/actions-details"); ?>" id="DetailsModal">
    <div class="padding20">

        <div id="details_con">
        </div>

    </div>
</div>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1>
                    <strong><?php echo __("admin/tools/page-actions-error-log"); ?></strong>
                </h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="clear"></div>

            <div class="formcon">

                <div style="margin-right: 30px; float: left;">
                    <input<?php echo ERROR_DEBUG ? ' checked' : ''; ?> type="checkbox" id="error-debug-status" value="1" class="sitemio-checkbox">
                    <label class="sitemio-checkbox-label" for="error-debug-status"></label>
                    <span class="kinfo"><?php echo __("admin/tools/actions-error-debug-status"); ?></span>
                </div>

                <div style="margin-right: 30px; float: left;">
                    <input<?php echo DEVELOPMENT ? ' checked' : ''; ?> type="checkbox" id="development-status" value="1" class="sitemio-checkbox">
                    <label class="sitemio-checkbox-label" for="development-status"></label>
                    <span class="kinfo"><?php echo __("admin/tools/actions-development-status"); ?></span>
                </div>

                <div style="margin-right: 30px; float: left;">
                    <input<?php echo LOG_SAVE ? ' checked' : ''; ?> type="checkbox" id="error-log-status" value="1" class="sitemio-checkbox">
                    <label class="sitemio-checkbox-label" for="error-log-status"></label>
                    <span class="kinfo"><?php echo __("admin/tools/actions-error-log-status"); ?></span>
                </div>

            </div>
            <div class="clear"></div>
            <br>

            <table width="100%" id="actionsTable" class="table table-striped table-borderedx table-condensed nowrap">
                <thead style="background:#ebebeb;">
                <tr>
                    <th align="left">#</th>
                    <th align="left" data-orderable="false"><?php echo __("admin/tools/actions-type"); ?></th>
                    <th align="left" data-orderable="false"><?php echo __("admin/tools/actions-err-type"); ?></th>
                    <th align="left" data-orderable="false"><?php echo __("admin/tools/actions-err-file"); ?></th>
                    <th align="center" data-orderable="false"><?php echo __("admin/users/detail-actions-th-date"); ?></th>
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