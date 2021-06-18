<h4><strong><?php echo $module->lang["tx104"]; ?></strong></h4>
<div class="line"></div>

<div class="blue-info">
    <div class="padding20">
        <i class="fa fa-info-circle" aria-hidden="true"></i>
        <p><?php echo $module->lang["tx105"]; ?></p>
    </div>
</div>

<div class="line"></div>

<div class="clear"></div>

<div class="admin-area-page-list">
    <script type="text/javascript">
        $('#isoList').DataTable({
            "lengthMenu": [
                [10, 25, 50, -1], [10, 25, 50, "<?php echo ___("needs/allOf"); ?>"]
            ],
            responsive: true,
            "language":{"url":"<?php echo APP_URI; ?>/<?php echo ___("package/code"); ?>/datatable/lang.json"}
        });
    </script>

    <table width="100%" border="0" cellpadding="0" cellspacing="0" id="isoList">
        <thead>
        <tr>
            <td><?php echo $module->lang["tx106"]; ?></td>
            <td>&nbsp;</td>
        </tr>
        </thead>
        <tbody>
        <?php
            if(isset($result) && $result)
            {
                foreach($result AS $r)
                {
                    ?>
                    <tr>
                        <td><?php
                                if($mounted_iso == $r["id"])
                                {
                                    ?><span style="display: none;">0</span><strong>[MOUNTED] <?php echo $r["description"]; ?></strong><?php
                                }
                                else
                                {
                                    ?><span style="display: none;">1</span><?php echo $r["description"]; ?><?php
                                }
                            ?></td>
                        <td>
                            <?php
                                if($mounted_iso == $r["id"])
                                {
                                    ?><a class="lbtn red change-iso" data-id="<?php echo $r["id"]; ?>" data-type="unmount" href="javascript:void 0;"><i class="fa fa-times" aria-hidden="true"></i> UNMOUNT</a><?php
                                }
                                else
                                {
                                    ?><a class="lbtn green change-iso" data-id="<?php echo $r["id"]; ?>" data-type="mount" href="javascript:void 0;"><i class="fa fa-check" aria-hidden="true"></i> MOUNT</a><?php
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


<a href="javascript:open_m_page('home'); void 0;" class="hostbtn"><i class="fa fa-chevron-circle-left"></i> <?php echo $module->lang["turn-back"]; ?></a>

<script type="text/javascript">
    $(document).ready(function(){
        $('.change-iso').click(function(){

            let el      = $(this);
            let _id     = el.data("id");
            let _type   = el.data("type");

            let request = MioAjax({
                button_element:el,
                waiting_text: '<i class="fa fa-spinner" style="-webkit-animation:fa-spin 2s infinite linear;animation: fa-spin 2s infinite linear;"></i>',
                action: "<?php echo $module->area_link; ?>",
                method: "POST",
                data:{
                    operation:"operation_server_automation",
                    use_method:"change-iso",
                    id: _id,
                    type: _type
                }
            },true,true);
            request.done(function(result)
            {
                let result_x = getJson(result);
                if(result_x !== false)
                {
                    if(result_x.status === "successful")
                    {
                        open_m_page("<?php echo $module->page; ?>");
                    }
                }
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