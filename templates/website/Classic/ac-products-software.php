<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    include $tpath."common-needs.php";
    $hoptions = ["datatables"];
?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#products').DataTable({
            "columnDefs": [
                {
                    "targets": [ 0 ],
                    "visible": false,
                    "searchable": false
                },
            ],
            "lengthMenu": [
                [10, 25, 50, -1], [10, 25, 50, "<?php echo __("website/others/datatable-all"); ?>"]
            ],
            responsive: true,
            "oLanguage":<?php include __DIR__.DS."datatable-lang.php"; ?>
        });
    });
</script>
<style type="text/css">
    #products tbody tr td:nth-child(2) {
        text-align: left;
    }
</style>
<div class="mpanelrightcon">

    <div class="mpaneltitle">
        <div class="sayfayolu"><?php include $tpath."inc".DS."panel-breadcrumb.php"; ?></div>
        <h4><strong><i class="fa fa-cube"></i> <?php echo $page_title; ?></strong></h4>
    </div>


    <?php if($list): ?>
        <table width="100%" class="table table-striped table-borderedx table-condensed nowrap" id="products">
            <thead style="background:#ebebeb;">
            <tr>
                <th align="left">#</th>
                <th align="center"><?php echo __("website/account_products/table-ordernum"); ?></th>
                <th align="left"><?php echo __("website/account_products/table-field1"); ?></th>
                <th align="center"><?php echo __("website/account_products/table-field2"); ?></th>
                <th align="center"><?php echo __("website/account_products/table-field3"); ?></th>
                <th align="center"><?php echo __("website/account_products/table-field4"); ?></th>
                <th align="center"><?php echo __("website/account_products/table-field5"); ?></th>
            </tr>
            </thead>
            <tbody align="center" style="border-top:none;">
            <?php
                if($list){
                    foreach($list AS $r=>$row){
                        $amount = Money::formatter_symbol($row["amount"],$row["amount_cid"]);
                        $period = View::period($row["period_time"],$row["period"]);
                        $duedate = $row["duedate"];
                        if(in_array(substr($duedate,0,4),['1881','1970'])) $duedate = '1970';
                        $duedate_format = $duedate == "1970" ? ' - ' : DateManager::format(Config::get("options/date-format"),$duedate);
                        ?>
                        <tr>
                            <td align="left"><?php echo $r; ?></td>
                            <td align="center"><?php echo $row["id"]; ?></td>
                            <td align="left">
                                <strong><?php echo $row["name"]; ?></strong>
                                <?php
                                    if(isset($row["options"]["domain"]) && $row["options"]["domain"])
                                        echo "<br>".$row["options"]["domain"];
                                    if(isset($row["options"]["code"]) && $row["options"]["code"])
                                        echo "<br>".$row["options"]["code"];
                                ?>
                            </td>
                            <td align="center">
                                <?php echo $amount; ?> <?php echo $period; ?>
                            </td>
                            <td align="center">
                                <span style="display: none;"><?php echo DateManager::format("Y-m-d",$duedate); ?></span>
                                <?php echo $duedate_format; ?>
                            </td>
                            <td align="center"><?php echo $situations[$row["status"]]; ?></td>
                            <td align="center">
                                <?php
                                    if($row["status"] == "waiting" || $row["status"] == "inprocess" || $row["status"] == "cancelled"){
                                        ?>
                                        <a title="<?php echo __("website/account_products/manage"); ?>" style="-webkit-filter:grayscale(100%);filter: grayscale(100%);color: #777;opacity: 0.5;filter: alpha(opacity=50);" class="incelebtn"><i class="fa fa-cog" aria-hidden="true"></i> <?php echo __("website/account_products/manage"); ?></a>
                                        <?php
                                    }else{
                                        ?>
                                        <a href="<?php echo $row["detail_link"]; ?>" title="<?php echo __("website/account_products/manage"); ?>" class="incelebtn"><i class="fa fa-cog" aria-hidden="true"></i> <?php echo __("website/account_products/manage"); ?></a>
                                        <?php
                                    }
                                ?>
                            </td>
                        </tr>
                        <?php
                    }
                }
            ?>
            </tbody>
        </table>
    <?php else: ?>
        <div id="orders-none">
            <?php echo __("website/account_products/empty-list-software"); ?>
        </div>
    <?php endif; ?>

    <div class="clear"></div>
</div>