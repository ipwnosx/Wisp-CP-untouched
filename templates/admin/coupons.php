<!DOCTYPE html>
<html>
<head>
    <?php
        $plugins    = ['dataTables','voucher_codes'];
        include __DIR__.DS."inc".DS."head.php";
    ?>

    <script>
        $(document).ready(function() {
            $('#datatable').DataTable({
                "columnDefs": [
                    {
                        "targets": [0],
                        "visible":false,
                        "searchable": false
                    }
                ],
                responsive: true,
                "oLanguage":<?php include __DIR__.DS."datatable-lang.php"; ?>
            });
        });


        function deleteCoupon(id){
            var content = $("#ConfirmModal").html();
            $("#ConfirmModal").html(content.replace("{name}",name));

            open_modal("ConfirmModal",{
                title:"<?php echo __("admin/financial/delete-modal-title"); ?>"
            });

            $("#delete_ok").click(function(){
                var result = MioAjax({
                    button_element:this,
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    action: "<?php echo $links["controller"]; ?>",
                    method: "POST",
                    data: {operation:"delete_coupon",id:id}
                },true);
                if(result){
                    if(result != ''){
                        var solve = getJson(result);
                        if(solve !== false){
                            if(solve.status == "error"){
                                if(solve.message != undefined && solve.message != '')
                                    alert_error(solve.message,{timer:5000});
                            }else if(solve.status == "successful"){
                                alert_success(solve.message,{timer:3000});
                                var table = $('#datatable').DataTable();
                                table.row($("#row_"+id)).remove().draw();
                            }
                        }else
                            console.log(result);
                    }
                }else console.log(result);
            });

            $("#delete_no").click(function(){
                close_modal("ConfirmModal");
            });

        }

    </script>

</head>
<body>

<div id="ConfirmModal" style="display: none;">
    <div class="padding20">
        <p class="confirmModal_text"><?php echo __("admin/financial/delete-are-you-sure"); ?></p>
    </div>
    <div class="modal-foot-btn">
        <a id="delete_ok" href="javascript:void(0);" class="red lbtn"><?php echo __("admin/financial/delete-ok"); ?></a>
    </div>
</div>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1><strong><?php echo __("admin/financial/page-coupons"); ?></strong></h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <a href="<?php echo $links["controller"]; ?>?page=add" class="green lbtn">+ <?php echo __("admin/financial/add-new-coupon"); ?></a>

            <div class="clear"></div>
            <br>

            <table width="100%" id="datatable" class="table table-striped table-borderedx table-condensed nowrap">
                <thead style="background:#ebebeb;">
                <tr>
                    <th align="left">#</th>
                    <th align="center"><?php echo __("admin/financial/coupons-list-code"); ?></th>
                    <th align="center"><?php echo __("admin/financial/coupons-list-type"); ?></th>
                    <th align="center"><?php echo __("admin/financial/coupons-list-value"); ?></th>
                    <th align="center"><?php echo __("admin/financial/coupons-list-uses"); ?></th>
                    <th align="center"><?php echo __("admin/financial/coupons-list-start-date"); ?></th>
                    <th align="center"><?php echo __("admin/financial/coupons-list-end-date"); ?></th>
                    <th align="center"><?php echo __("admin/financial/coupons-list-status"); ?></th>
                    <th align="center"></th>
                </tr>
                </thead>
                <tbody align="Center" style="border-top:none;">
                <?php
                    if(isset($list) && $list){
                        $size = sizeof($list)-1;
                        for($i=0;$i<=$size;$i++){
                            $row = $list[$i];
                            ?>
                            <tr id="row_<?php echo $row["id"]; ?>">
                                <td><?php echo $i; ?></td>
                                <td align="center"><?php echo $row["code"]; ?></td>
                                <td align="center"><?php echo __("admin/financial/new-coupon-type-".$row["type"]); ?></td>
                                <td align="center">
                                    <?php
                                        if($row["type"] == "percentage"){
                                            echo "%".$row["rate"];
                                        }else{
                                            echo Money::formatter_symbol($row["amount"],$row["currency"]);
                                        }
                                    ?>
                                </td>
                                <td align="center">
                                    <?php
                                        echo $row["uses"];
                                        echo " / ";
                                        echo $row["maxuses"] == 0 ? '∞' : $row["maxuses"];
                                    ?>
                                </td>
                                <td align="center"><?php echo DateManager::format(Config::get("options/date-format"),$row["cdate"]); ?></td>
                                <td align="center"><?php echo $row["duedate"] != "1881-05-19 00:00:00" ? DateManager::format(Config::get("options/date-format"),$row["duedate"]) : __("admin/financial/coupons-list-indefinite"); ?></td>
                                <td align="center">
                                    <?php
                                        if($row["maxuses"] != 0 && $row["uses"] == $row["maxuses"])
                                            echo '<span>'.__("admin/financial/coupons-list-status-exhausted").'</span>';
                                        elseif($row["duedate"] != "1881-05-19 00:00:00" && $row["duedate"] < DateManager::Now())
                                            echo '<span><i class="fa fa-clock-o"></i> '.__("admin/financial/coupons-list-status-expired").'</span>';
                                        elseif($row["status"] == "active")
                                            echo '<span style="color:green;"><i class="fa fa-check"></i> '.__("admin/financial/coupons-list-status-active").'</span>';
                                        elseif($row["status"] == "inactive")
                                            echo '<span><i class="fa fa-power-off"></i> '.__("admin/financial/coupons-list-status-inactive").'</span>';
                                    ?>
                                </td>
                                <td align="center">
                                    <a href="<?php echo $links["controller"]."?page=edit&id=".$row["id"]; ?>" title="<?php echo __("admin/financial/edit"); ?>" class="sbtn"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                    <a href="javascript:deleteCoupon(<?php echo $row["id"]; ?>);void 0;" title="<?php echo __("admin/financial/delete"); ?>" class="red sbtn"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                ?>



                </tbody>
            </table>


        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>