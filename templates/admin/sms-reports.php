<!DOCTYPE html>
<html>
<head>
    <?php
        $privOperation  = Admin::isPrivilege("PRODUCTS_OPERATION");
        $plugins        = ['dataTables'];
        include __DIR__.DS."inc".DS."head.php";
    ?>

    <style type="text/css">
        #reports tbody tr td:nth-child(1),#reports tbody tr td:nth-child(6) {text-align: left;}
    </style>
    <script>
        var table;
        $(document).ready(function() {
            table = $('#reports').DataTable({
                "columnDefs": [
                    {
                        "targets": [0],
                        "visible":false,
                        "searchable": false
                    },
                    {
                        "targets": [1,2,3,4,5,6,7,8],
                        "orderable": false
                    }
                ],
                "aaSorting" : [[0, 'asc']],
                "lengthMenu": [
                    [10, 25, 50, -1], [10, 25, 50, "<?php echo ___("needs/allOf"); ?>"]
                ],
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": "<?php echo $links["ajax-reports"]; ?>",
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
                    <strong><?php echo __("admin/products/page-sms-reports"); ?></strong>
                </h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="clear"></div>
            <br>



            <script type="text/javascript">
                function showMessage(id){
                    open_modal('showMessage');
                    $("#showText").html($("#show_message_"+id).html());
                }
            </script>

            <div style="display: none;" id="showMessage" data-izimodal-title="<?php echo __("website/account_products/report-message-content"); ?>">
                <div class="padding20" id="showText">

                </div>
            </div>

            <div id="loading-container" style="display: none;">
                <div align="center">
                    <h4><img src="<?php echo $sadress; ?>assets/images/loading.gif"><br><?php echo __("website/account_products/loading-report-data"); ?></h4>
                </div>
            </div>
            <div id="getReport" style="display: none;" data-izimodal-title="<?php echo __("website/account_products/status-report"); ?>">
                <div class="padding20">

                </div>
            </div>
            <div id="ReportTemplate" style="display:none;">
                <div class="durumraportable">
                    <table width="100%" border="0" align="center">
                        <thead>
                        <tr>
                            <td width="33%" align="center" bgcolor="#D6FE81" style="color:#4B7001"><strong><?php echo __("website/account_products/report-delivered"); ?> ({delivered_count})</strong></td>
                            <td width="33%" align="center" bgcolor="#C6FFFF" style="color:#009393"><strong><?php echo __("website/account_products/report-expect"); ?> ({expect_count})</strong></td>
                            <td width="33%" align="center" bgcolor="#FFCACA" style="color:#970000"><strong><?php echo __("website/account_products/report-incorrect"); ?> ({incorrect_count})</strong></td>
                        </tr>
                        </thead>
                        <tbody>

                        <tr>
                            <td width="33%" align="center" style="color:#689A01">{conducted_number}</td>
                            <td width="33%" align="center" style="color:#009393">{waiting_number}</td>
                            <td width="33%" align="center" style="color:#AE0000">{erroneous_number}</td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>

            <script type="text/javascript">
                function getReportDetail(id,link) {
                    $("#getReport .padding20").html($("#loading-container").html());

                    open_modal('getReport');

                    var data = MioAjax({
                        action: link,
                        method: "POST",
                        data:{
                            operation:"get_sms_report",
                            id:id,
                        },
                    },true,true);

                    data.done(function(result){
                        if(result != ''){
                            var solve = getJson(result);
                            if(solve !== false){
                                if(solve.status == "successful"){
                                    var template = $("#ReportTemplate").html();

                                    template = template.replace("{delivered_count}",solve.conducted_count);
                                    template = template.replace("{expect_count}",solve.waiting_count);
                                    template = template.replace("{incorrect_count}",solve.erroneous_count);
                                    var item = $("tbody",template).html(),content,contents = '';
                                    $(solve.items).each(function(k,v){
                                        content = item;
                                        content = content.replace("{conducted_number}",v.conducted);
                                        content = content.replace("{waiting_number}",v.waiting);
                                        content = content.replace("{erroneous_number}",v.erroneous);
                                        contents += content;
                                    });

                                    template = $(template);
                                    $("tbody",template).html(contents);

                                    $("#getReport .padding20").html(template);
                                }
                            }else
                                console.log(result);
                        }else
                            console.log("result is empty");
                    });
                }
            </script>

            <table width="100%" id="reports" class="table table-striped table-borderedx table-condensed nowrap">
                <thead style="background:#ebebeb;">
                <tr>
                    <th align="left">#</th>
                    <th align="left">Müşteri</th>
                    <th align="center">Sipariş</th>
                    <th align="center"><?php echo __("website/account_products/reports-table-field1"); ?></th>
                    <th align="center"><?php echo __("website/account_products/reports-table-field2"); ?></th>
                    <th align="center">GSM No</th>
                    <th align="left"><?php echo __("website/account_products/reports-table-field4"); ?></th>
                    <th align="center">Toplam Kredi</th>
                    <th align="center"><?php echo __("website/account_products/reports-table-field5"); ?></th>
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