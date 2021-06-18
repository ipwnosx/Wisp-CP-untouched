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
    <style>
        #listTable tbody tr td:nth-child(1){
            text-align: left;
        }
        #listTable tbody tr td:nth-child(2){
            text-align: left;
        }
    </style>

    <script type="text/javascript">
        $(document).ready(function(){
            $("#listTable").on("click",".view-addresses",function(){
                var id = $(this).data("id");
                open_modal("view_addresses_modal",{width:'300px'});

                $("#get_addresses").html($("#addresses_"+id).html());

            });

            $("#listTable").on("click",".view-message",function(){
                var id       = $(this).data("id");
                var subject  = $(this).data("subject");
                open_modal("view_message_modal",{width:'1024px'});

                $("#view_message_modal").attr("data-izimodal-title",subject);
                $("#get_message").html('');
                var content = $("#message_"+id).html();
                document.getElementById('get_message').src = "data:text/html;charset=utf-8," + encodeURIComponent(content);
            });
        });
    </script>
</head>
<body>

<div id="view_addresses_modal" data-izimodal-title="<?php echo ___("needs/allOf"); ?>" style="display: none;">
    <div class="padding20">

        <div id="get_addresses" style="text-align: center;"></div>

        <div class="clear"></div>
    </div>
</div>
<div id="view_message_modal" data-izimodal-title="<?php echo __("admin/tools/mail-logs-th-content"); ?>" style="display: none;">
    <div class="padding20">
        <iframe id="get_message" style="width:100%; height:700px;border:none;"></iframe>
        <div class="clear"></div>
    </div>
</div>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1>
                    <strong><?php echo __("admin/tools/page-mail-logs"); ?></strong>
                </h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <table width="100%" id="listTable" class="table table-striped table-borderedx table-condensed nowrap">
                <thead style="background:#ebebeb;">
                <tr>
                    <th align="left">#</th>
                    <th align="left" data-orderable="false"><?php echo __("admin/tools/mail-logs-th-subject"); ?></th>
                    <th align="left" data-orderable="false"><?php echo __("admin/tools/mail-logs-th-content"); ?></th>
                    <th align="center" data-orderable="false"><?php echo __("admin/tools/mail-logs-th-addresses"); ?></th>
                    <th align="center" data-orderable="false"><?php echo __("admin/tools/mail-logs-th-date"); ?></th>
                    <th align="center" data-orderable="false"><?php echo __("admin/tools/mail-logs-th-ip"); ?></th>
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