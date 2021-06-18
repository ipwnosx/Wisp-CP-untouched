<!DOCTYPE html>
<html>
<head>
    <?php
        $plugins    = ['dataTables'];
        include __DIR__.DS."inc".DS."head.php";
    ?>
    <script type="text/javascript">
        var table;
        $(document).ready(function(){

            table = $('#listTable').DataTable({
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
    </script>
  

    <script type="text/javascript">
        $(document).ready(function(){
            $("#listTable").on("click",".view-numbers",function(){
                var id = $(this).data("id");
                open_modal("view_numbers_modal",{width:'300px'});

                $("#get_numbers").html($("#numbers_"+id).html());

            });

            $("#listTable").on("click",".view-message",function(){
                var id = $(this).data("id");
                open_modal("view_message_modal",{width:'400px'});

                $("#get_message").html($("#message_"+id).html());

            });
        });
    </script>
</head>
<body>

<div id="view_numbers_modal" data-izimodal-title="<?php echo ___("needs/allOf"); ?>" style="display: none;">
    <div class="padding20">

        <div id="get_numbers" style="text-align: center;"></div>

        <div class="clear"></div>
    </div>
</div>
<div id="view_message_modal" data-izimodal-title="<?php echo __("admin/tools/sms-logs-th-content"); ?>" style="display: none;">
    <div class="padding20">

        <div id="get_message" style="text-align: center;word-wrap: break-word;"></div>

        <div class="clear"></div>
    </div>
</div>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1>
                    <strong><?php echo __("admin/tools/page-sms-logs"); ?></strong>
                </h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <table width="100%" id="listTable" class="table table-striped table-borderedx table-condensed nowrap">
                <thead style="background:#ebebeb;">
                <tr>
                    <th align="left">#</th>
                    <th align="left" data-orderable="false"><?php echo __("admin/tools/sms-logs-th-title"); ?></th>
                    <th align="left" data-orderable="false"><?php echo __("admin/tools/sms-logs-th-content"); ?></th>
                    <th align="center" data-orderable="false"><?php echo __("admin/tools/sms-logs-th-numbers"); ?></th>
                    <th align="center" data-orderable="false"><?php echo __("admin/tools/sms-logs-th-date"); ?></th>
                    <th align="center" data-orderable="false"><?php echo __("admin/tools/sms-logs-th-ip"); ?></th>
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