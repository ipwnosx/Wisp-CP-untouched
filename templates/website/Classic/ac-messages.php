<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    $hoptions = ["datatables"];
?>
<style type="text/css">
    #messages tbody tr td:nth-child(2) {
        text-align: left;
    }
</style>
<script type="text/javascript">
    $(document).ready(function(){
        $('#messages').DataTable({
            "columnDefs": [
                {
                    "targets": [0],
                    "orderable": false,
                    "searchable": false
                }
            ],
            "lengthMenu": [
                [10, 25, 50, -1], [10, 25, 50, "<?php echo __("website/others/datatable-all"); ?>"]
            ],
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "<?php echo $links["ajax"]; ?>",
            responsive: true,
            "oLanguage":<?php include __DIR__.DS."datatable-lang.php"; ?>
        });
    });
</script>
<div class="mpanelrightcon">

    <div class="mpaneltitle">
        <h4><strong><i class="fa fa-envelope-o"></i> <?php echo __("website/account_messages/page-title"); ?></strong></h4>
    </div>


    <div class="faturalarim">
        <table id="messages">
            <thead style="background:#ebebeb;">
            <tr>
                <th>#</th>
                <th align="left"><?php echo __("website/account_messages/table-column1"); ?></th>
                <th align="center"><?php echo __("website/account_messages/table-column2"); ?></th>
                <th></th>
            </tr>
            </thead>

            <tbody align="center" style="border-top:none;"></tbody>
        </table>
    </div>
    <div class="clear"></div>
</div>