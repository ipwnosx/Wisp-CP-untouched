<div class="padding30">
    <h4 class="cleintArea-module-page-title"><strong><?php echo $module->lang["tx86"]; ?></strong></h4>
    <?php
        if($server_detail && $server_detail["backup_window"])
        {
            ?><a style="float:right;" class="clientArea-module-page-btn green" id="create-image" href="javascript:void 0;"><?php echo $module->lang["tx100"]; ?></a><?php
        }
    ?>
    <div class="line"></div>

    <div id="rebuild_image_modal" data-izimodal-headerColor="#f44336" data-izimodal-title="<?php echo $module->lang["tx99"]; ?>" style="display: none;">
        <div class="padding20">

            <div class="red-info">
                <div class="padding20">
                    <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                    <p><?php echo $module->lang["tx85"]; ?></p>
                </div>
            </div>

            <div class="clear"></div>
            <div class="line"></div>

            <div class="guncellebtn yuzde30" style="float: right">
                <a href="javascript:void 0;" class="gonderbtn redbtn" id="rebuild-image"><?php echo $module->lang["tx101"]; ?></a>
            </div>

            <div class="clear"></div>


        </div>
    </div>

    <div class="clear"></div>
    <div class="admin-area-page-list">
        <script type="text/javascript">
            var listTable;
            $(document).ready(function(){
                listTable = $('#tableList').DataTable({
                    "columnDefs": [
                        {
                            "targets": [0],
                            "visible":false,
                        },
                    ],
                    "lengthMenu": [
                        [10, 25, 50, -1], [10, 25, 50, "<?php echo ___("needs/allOf"); ?>"]
                    ],
                    responsive: true,
                    "language":{"url":"<?php echo APP_URI; ?>/<?php echo ___("package/code"); ?>/datatable/lang.json"}
                })
            });
        </script>
        <table width="100%" border="0" cellpadding="0" cellspacing="0" id="tableList">
            <thead>
            <tr>
                <td>#</td>
                <td><?php echo $module->lang["tx93"]; ?></td>
                <td align="center"><?php echo $module->lang["tx94"]; ?></td>
                <td align="center"><?php echo $module->lang["tx95"]; ?></td>
                <td align="center"><?php echo $module->lang["tx96"]; ?></td>
                <td>&nbsp;</td>
            </tr>
            </thead>
            <tbody>
            <?php
                if($result)
                {
                    foreach($result AS $k => $r)
                    {
                        ?>
                        <tr>
                            <td><?php echo $k; ?></td>
                            <td><?php echo $r["description"]; ?></td>
                            <td align="center"><?php echo DateManager::format(Config::get("options/date-format")." - H:i",$r["created"]); ?></td>
                            <td align="center"><?php echo round($r["image_size"],2)." GB"; ?></td>
                            <td align="center">
                                <?php
                                    if($r["status"] == "available")
                                    {
                                        ?><div class="listingstatus"><span class="active"><?php echo $module->lang["tx97"]; ?></span></div><?php
                                    }
                                    elseif($r["status"] == "creating")
                                    {
                                        ?><div class="listingstatus"><span class="process"><?php echo $module->lang["tx98"]; ?></span></div><?php
                                    }
                                    else
                                    {
                                        ?><div class="listingstatus"><span><?php echo ucfirst($r["status"]); ?></span></div><?php
                                    }
                                ?>
                            </td>
                            <td>
                                <?php
                                    if($r["status"] == "available")
                                    {
                                        ?><a data-tooltip="<?php echo $module->lang["tx99"]; ?>" class="sbtn green rebuild-image" href="javascript:void 0;" data-imgid="<?php echo $r["id"]; ?>"><i class="fa fa-upload" aria-hidden="true"></i></a><?php
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
    </div>


    <div class="clear"></div>
    <div class="line"></div>


    <a href="javascript:reload_module_content('home'); void 0;" class="clientArea-module-page-btn"><i class="fa fa-chevron-circle-left"></i> <?php echo $module->lang["turn-back"]; ?></a>

    <script type="text/javascript">
        var image_id = 0,el;
        $(document).ready(function(){
            $('.rebuild-image').click(function(){

                open_modal('rebuild_image_modal');

                el  = $(this);
                image_id  = el.data("imgid");
            });

            $("#rebuild_image_modal").on("click","#rebuild-image",function(){
                el = $(this);

                var request = MioAjax({
                    button_element:el,
                    waiting_text: '<i class="fa fa-spinner" style="-webkit-animation:fa-spin 2s infinite linear;animation: fa-spin 2s infinite linear;"></i>',
                    action: "<?php echo $module->area_link; ?>",
                    method: "POST",
                    data:
                        {
                            inc:"panel_operation_method",
                            method:"rebuild-image",
                            id: image_id,
                        }
                },true,true);
                request.done(t_form_handle);

            });
            $("#create-image").click(function(){
                el = $(this);
                var request = MioAjax({
                    button_element:el,
                    waiting_text: '<i class="fa fa-spinner" style="-webkit-animation:fa-spin 2s infinite linear;animation: fa-spin 2s infinite linear;"></i>',
                    action: "<?php echo $module->area_link; ?>",
                    method: "POST",
                    data:
                        {
                            inc:"panel_operation_method",
                            method:"create-image",
                            type: "backup",
                        }
                },true,true);
                request.done(function(result){
                    var result_x = getJson(result);
                    if(result_x !== false && result_x.status === "successful") reload_module_content("<?php echo $module->page; ?>");
                    t_form_handle(result);
                });

            });

        });
    </script>
    <style>
        .admin-area-page-list table thead {
            background: #ebebeb;
            vertical-align: top;
            font-weight: 600;
        }
    </style>

    <div class="clear"></div>
</div>