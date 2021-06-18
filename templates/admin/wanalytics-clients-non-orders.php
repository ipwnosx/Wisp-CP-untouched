<!DOCTYPE html>
<html>
<head>
    <?php
        Utility::sksort($lang_list,"local");

        $plugins    = ['dataTables','dataTables-buttons','jquery-ui'];
        include __DIR__.DS."inc".DS."head.php";
    ?>
    <script type="text/javascript">
        var list_table;

        $(document).ready(function(){
            list_table = $('#list_table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                "columnDefs": [
                    {
                        "targets": [0],
                        "visible":false,
                        "searchable": false
                    }
                ],
                paging: true,
                info: true,
                searching: true,
                responsive: true,
                "oLanguage":<?php include __DIR__.DS."datatable-lang.php"; ?>
            });
        });
    </script>
    <style type="text/css">
    </style>

</head>
<body>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">
            <div class="icerikbaslik">
                <h1>
                    <strong><img width="150" src="<?php echo $tadress; ?>images/wanalytics.svg"/></strong>
                </h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="clear"></div>

            <div class="reports">

                <div class="reports-content">

                    <div class="icerikbaslik">
                        <h1>
                            <strong><?php echo $page_title;  ?></strong>
                        </h1>
                        <div class="sayfayolu"><h4><?php echo __("admin/wanalytics/page-clients-non-orders-title"); ?></h4></div>
                    </div>

                    <div class="clear"></div>

                    <div class="reportsinfotitle">
                        <?php echo __("admin/wanalytics/report-note-9"); ?>
                    </div>

                    <div class="reportfoundinfo">
                        <h4><?php echo __("admin/wanalytics/report-note-8",['{count}' => $result_count]); ?></h4>
                    </div>

                    <div class="clear"></div>

                    <table width="100%" id="list_table" class="table table-striped table-borderedx table-condensed nowrap">
                        <thead style="background:#ebebeb;">
                        <tr>
                            <th align="center" style="opacity: 0;">#</th>
                            <th align="center"><?php echo __("admin/wanalytics/list-table-client"); ?></th>
                            <th align="center"><?php echo __("admin/wanalytics/list-table-last-login"); ?></th>
                            <th align="center"></th>
                        </tr>
                        </thead>
                        <tbody align="Center" style="border-top:none;">
                        <?php
                            if(isset($result) && $result){
                                foreach($result AS $k=>$row){
                                    $k +=1;
                                    ?>
                                    <tr>
                                        <td align="center"><?php echo $k; ?></td>
                                        <td align="center"><?php echo $row["name"]; ?></td>
                                        <td align="center"><?php echo $row["last_login_time"]; ?></td>
                                        <td align="center">
                                            <a class="sbtn" href="<?php echo $row["detail_link"]; ?>" target="_blank"><i class="fa fa-search" aria-hidden="true"></i></a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                        ?>
                        </tbody>
                    </table>

                </div>


                <?php include __DIR__.DS."wanalytics-sidebar.php"; ?>
            </div>

            <div class="clear"></div>
        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>