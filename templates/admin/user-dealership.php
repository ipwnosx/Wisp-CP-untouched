<!DOCTYPE html>
<html>
<head>
    <?php
        $plugins            = ['dataTables','select2'];
        Utility::sksort($lang_list,'local');
        include __DIR__.DS."inc".DS."head.php";
    ?>
    <script type="text/javascript">
        var table1;

        $(document).ready(function(){
            table1 = $('#dealerships').DataTable({
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
                "sAjaxSource": "<?php echo $links["ajax-dealerships"]; ?>",
                responsive: true,
                "oLanguage":<?php include __DIR__.DS."datatable-lang.php"; ?>
            });

        });
    </script>
    <style type="text/css">
        #dealerships tbody tr td:nth-child(1) {text-align: left;}
    </style>

</head>
<body>
<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1>
                    <strong><?php echo __("admin/users/page-dealership");?></strong>
                </h1>

                <div align="left">
                    <a class="lbtn" href="<?php echo $links["settings"]; ?>"><i class="fa fa-cogs"></i> <?php echo __("admin/users/blacklist-settings-btn"); ?></a>
                </div>

                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="green-info">
                <div class="padding20">
                    <i class="fa fa-info-circle"></i>
                    <p><?php echo __("admin/users/dealership-info"); ?></p>
                </div>
            </div>
            <div class="clear"></div>

            <table width="100%" id="dealerships" class="table table-striped table-borderedx table-condensed nowrap">
                <thead style="background:#ebebeb;">
                <tr>
                    <th align="left" data-orderable="false">#</th>
                    <th align="left" data-orderable="false"><?php echo __("admin/users/dealership-user"); ?></th>
                    <th align="center" data-orderable="false"><?php echo __("admin/users/dealership-ctime"); ?></th>
                    <th align="center" data-orderable="false"><?php echo __("admin/users/dealership-turnover"); ?></th>
                    <th align="center" data-orderable="false"><?php echo __("admin/users/dealership-total-discount"); ?></th>
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