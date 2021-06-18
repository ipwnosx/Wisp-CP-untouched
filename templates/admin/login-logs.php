<!DOCTYPE html>
<html>
<head>
    <?php
        $plugins    = ['dataTables'];
        include __DIR__.DS."inc".DS."head.php";
    ?>
    <script type="text/javascript">
        var table1,table2;
        $(document).ready(function(){

            var tab1 = _GET("type");
            if (tab1 != '' && tab1 != undefined) {
                $("#tab-type .tablinks[data-tab='" + tab1 + "']").click();
            } else {
                $("#tab-type .tablinks:eq(0)").addClass("active");
                $("#tab-type .tabcontent:eq(0)").css("display", "block");
            }

            table1 = $('#listTable1').DataTable({
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
                "sAjaxSource": "<?php echo $links["ajax-actions"]; ?>&type=client",
                responsive: true,
                "oLanguage":<?php include __DIR__.DS."datatable-lang.php"; ?>
            });
            table2 = $('#listTable2').DataTable({
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
                "sAjaxSource": "<?php echo $links["ajax-actions"]; ?>&type=admin",
                responsive: true,
                "oLanguage":<?php include __DIR__.DS."datatable-lang.php"; ?>
            });

        });
    </script>
    <style type="text/css">
        table tbody tr td {text-align: left;}
    </style>
</head>
<body>
<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1>
                    <strong><?php echo __("admin/tools/page-actions-login-log"); ?></strong>
                </h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>


            <div id="tab-type">
                <ul class="tab">
                    <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'client','type')" data-tab="client"><?php echo __("admin/tools/actions-user-member"); ?></a></li>
                    <li>
                        <a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'admin','type')" data-tab="admin"><?php echo __("admin/tools/actions-user-admin"); ?></a>
                    </li>
                </ul>


                <div class="tabcontent" id="type-client">
                    <table width="100%" id="listTable1" class="table table-striped table-borderedx table-condensed nowrap">
                        <thead style="background:#ebebeb;">
                        <tr>
                            <th align="left">#</th>
                            <th align="left"><?php echo __("admin/tools/actions-user"); ?></th>
                            <th align="left"><?php echo __("admin/users/detail-info-login-logs-date"); ?></th>
                            <th align="left"><?php echo __("admin/users/detail-info-login-logs-platform"); ?></th>
                            <th align="left"><?php echo __("admin/users/detail-info-login-logs-browser"); ?></th>
                            <th align="left"><?php echo __("admin/users/detail-info-login-logs-ip"); ?></th>
                            <th align="left"><?php echo __("admin/users/detail-info-login-logs-country"); ?></th>
                            <th align="left"><?php echo __("admin/users/detail-info-login-logs-city"); ?></th>
                        </tr>
                        </thead>
                        <tbody align="center" style="border-top:none;"></tbody>
                    </table>
                </div>

                <div class="tabcontent" id="type-admin">
                    <table width="100%" id="listTable2" class="table table-striped table-borderedx table-condensed nowrap">
                        <thead style="background:#ebebeb;">
                        <tr>
                            <th align="left">#</th>
                            <th align="left"><?php echo __("admin/tools/actions-user"); ?></th>
                            <th align="left"><?php echo __("admin/users/detail-info-login-logs-date"); ?></th>
                            <th align="left"><?php echo __("admin/users/detail-info-login-logs-platform"); ?></th>
                            <th align="left"><?php echo __("admin/users/detail-info-login-logs-browser"); ?></th>
                            <th align="left"><?php echo __("admin/users/detail-info-login-logs-ip"); ?></th>
                            <th align="left"><?php echo __("admin/users/detail-info-login-logs-country"); ?></th>
                            <th align="left"><?php echo __("admin/users/detail-info-login-logs-city"); ?></th>
                        </tr>
                        </thead>
                        <tbody align="center" style="border-top:none;"></tbody>
                    </table>
                </div>

            </div>


        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>