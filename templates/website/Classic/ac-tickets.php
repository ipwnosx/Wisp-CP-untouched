<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    $hoptions = ["datatables"];
?>

<script type="text/javascript">
    $(document).ready(function(){
        $('#tickets').DataTable({
            "columnDefs": [
                {
                    "targets": [0],
                    "visible":false,
                    "searchable":false,
                }

            ],
            "aaSorting" : [[0, 'asc']],
            responsive: true,
            "oLanguage":<?php include __DIR__.DS."datatable-lang.php"; ?>
        });
    });
</script>
<div class="mpanelrightcon">

    <div class="mpaneltitle">
        <h4><strong><i class="fa fa-life-ring" aria-hidden="true"></i> <?php echo __("website/account_tickets/page-title"); ?></strong></h4>
        <a href="<?php echo $links["create-request"]; ?>" class="green destekolsbtn lbtn"><?php echo __("website/account_tickets/create-request"); ?></a>
        <div class="sayfayolu"><?php include $tpath."inc".DS."panel-breadcrumb.php"; ?></div>

    </div>

    <div class="desteksistemi">

        <div class="clear"></div>
        <?php
            if($h_contents = Hook::run("TicketClientAreaViewList"))
                foreach($h_contents AS $h_content) if($h_content) echo  $h_content;
        ?>
        <div class="clear"></div>

        <table width="100%" id="tickets">
            <thead style="background:#ebebeb;">
            <tr>
                <th align="left" data-visible="false" style="display: none;">#</th>
                <th align="center"><?php echo __("website/account_tickets/table-id"); ?></th>
                <th data-orderable="false" align="left"><?php echo __("website/account_tickets/table-field1"); ?></th>
                <th data-orderable="false" align="center"><?php echo __("website/account_tickets/table-field2"); ?></th>
                <th align="center"><?php echo __("website/account_tickets/table-field3"); ?></th>
                <th data-orderable="false" align="center"><?php echo __("website/account_tickets/table-field4"); ?></th>
            </tr>
            </thead>
            <tbody align="center" style="border-top:none;">

            <?php
                if(isset($list) && $list){
                    $zone = User::getLastLoginZone();
                    foreach($list AS $k=>$row){
                        $title  = $row["userunread"] ? $row["title"] : '<strong>'.$row["title"].'</strong>';
                        ?>
                        <tr>
                            <td align="left"><?php echo $k; ?></td>
                            <td align="center"><?php echo $row["id"]; ?></td>
                            <td align="left">
                                <?php echo '<a href="'.$row["detail_link"].'">'.$title.'</a>'; ?>
                                <?php
                                    if($row["service"]){
                                        ?>
                                        <br>
                                        <span class="productinfo"><?php echo $row["service"]; ?></span>
                                        <?php
                                    }
                                ?>
                            </td>
                            <td align="center"><?php echo UserManager::formatTimeZone($row["ctime"],$zone,Config::get("options/date-format")." - H:i"); ?></td>
                            <td align="center"><?php echo $situations[$row["status"]]; ?></td>
                            <td align="center"><?php echo '<a href="'.$row["detail_link"].'" class="incelebtn"><i class="fa fa-search" aria-hidden="true"></i> '.__("website/account_products/view-button").'</a>'; ?></td>
                        </tr>
                        <?php
                    }
                }
            ?>


            </tbody>
        </table>
    </div>



    <div class="clear"></div>

</div>