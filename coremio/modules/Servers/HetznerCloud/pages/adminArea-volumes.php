<h4 style="float:left;"><strong><?php echo $module->lang["tx117"]; ?></strong></h4>
<a style="float:right;" data-tooltip="<?php echo $module->lang["tx118"]; ?>" class="lbtn green tooltip-left" href="javascript:open_modal('create_volume_modal'); void 0;"><?php echo $module->lang["tx119"]; ?></a>

<div class="line"></div>

<div id="create_volume_modal" data-izimodal-title="<?php echo $module->lang["tx119"]; ?>" style="display: none;">
    <div class="padding20">

        <div class="blue-info">
            <div class="padding10">
                <i style="font-size: 26px;" class="fa fa-info-circle"></i>
                <p><?php echo $module->lang["tx118"]; ?></p>
            </div>
        </div>

        <div class="clear"></div>

        <div class="formcon">
            <div class="yuzde30"><?php echo $module->lang["tx124"]; ?> (GB)</div>
            <div class="yuzde70">
                <input type="number" style="height: 40px; width: 80px;" id="create-volume-size" min="10" value="10">
            </div>
        </div>

        <div class="formcon">
            <div class="yuzde30"><?php echo $module->lang["tx128"]; ?></div>
            <div class="yuzde70">
                <input checked type="radio" class="radio-custom" name="format" value="ext4" id="format-ext4">
                <label for="format-ext4" class="radio-custom-label" style="margin-right: 10px;">EXT4</label>

                <input type="radio" class="radio-custom" name="format" value="xfs" id="format-xfs">
                <label for="format-xfs" class="radio-custom-label">XFS</label>
            </div>
        </div>


        <div class="clear"></div>
        <div class="line"></div>

        <div class="guncellebtn yuzde30" style="float: right">
            <a href="javascript:void 0;" class="gonderbtn yesilbtn" id="create-volume"><?php echo $module->lang["tx119"]; ?></a>
        </div>

        <div class="clear"></div>


    </div>
</div>


<div id="delete_volume_modal" data-izimodal-headerColor="#f44336" data-izimodal-title="<?php echo $module->lang["tx120"]; ?>" style="display: none;">
    <div class="padding20">

        <div class="red-info">
            <div class="padding20">
                <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                <p><?php echo $module->lang["tx121"]; ?></p>
            </div>
        </div>

        <div class="clear"></div>
        <div class="line"></div>

        <div class="guncellebtn yuzde30" style="float: right">
            <a href="javascript:void 0;" class="gonderbtn redbtn" id="delete-volume"><?php echo $module->lang["tx120"]; ?></a>
        </div>

        <div class="clear"></div>


    </div>
</div>

<div id="resize_volume_modal" data-izimodal-title="<?php echo $module->lang["tx126"]; ?>" style="display: none;">
    <div class="padding20">

        <div class="blue-info">
            <div class="padding10">
                <i style="font-size: 26px;" class="fa fa-info-circle"></i>
                <p><?php echo $module->lang["tx127"]; ?></p>
            </div>
        </div>

        <div class="clear"></div>

        <div class="formcon">
            <div class="yuzde30"><?php echo $module->lang["tx124"]; ?> (GB)</div>
            <div class="yuzde70">
                <input type="number" style="height: 40px; width: 80px;" id="resize-volume-size" min="10" value="10">
            </div>
        </div>

        <div class="clear"></div>

        <div class="line"></div>

        <div class="guncellebtn yuzde30" style="float: right">
            <a href="javascript:void 0;" class="gonderbtn yesilbtn" id="resize-volume"><?php echo $module->lang["tx126"]; ?></a>
        </div>

        <div class="clear"></div>


    </div>
</div>

<div class="clear"></div>
<div class="admin-area-page-list">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <thead>
        <tr>
            <td><?php echo $module->lang["tx122"]; ?></td>
            <td align="left"><?php echo $module->lang["tx123"]; ?></td>
            <td align="center"><?php echo $module->lang["tx124"]; ?></td>
            <td align="center"><?php echo $module->lang["tx125"]; ?></td>
            <td align="center">&nbsp;</td>
        </tr>
        </thead>
        <tbody>
        <?php
            if($result)
            {
                foreach($result AS $r)
                {
                    if($r["server"] != $module->config[$module->entity_id_name]) continue;
                    ?>
                    <tr>
                        <td><?php echo $r["id"]; ?></td>
                        <td align="left"><?php echo $r["name"]; ?></td>
                        <td align="center"><?php echo $r["size"]." GB"; ?></td>
                        <td align="center"><?php echo DateManager::format(Config::get("options/date-format")." - H:i",$r["created"]); ?></td>
                        <td align="center">
                            <a class="sbtn resize-volume" data-size="<?php echo $r["size"]; ?>" data-id="<?php echo $r["id"]; ?>" data-tooltip="<?php echo $module->lang["tx126"]; ?>"><i class="fa fa-pencil"></i></a>
                            <a class="sbtn red delete-volume" data-id="<?php echo $r["id"]; ?>" data-tooltip="<?php echo $module->lang["tx120"]; ?>"><i class="fa fa-trash-o"></i></a>
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
    var volume_id = 0,el;
    $(document).ready(function(){
        $('.delete-volume').click(function(){
            open_modal('delete_volume_modal');
            el  = $(this);
            volume_id  = el.data("id");
        });
        $('.resize-volume').click(function(){
            el  = $(this);
            volume_id                   = el.data("id");
            var volume_size            = el.data("size");
            open_modal('resize_volume_modal');

            $("#resize-volume-size").val(volume_size);
        });
        $("#delete_volume_modal").on("click","#delete-volume",function(){
            el = $(this);

            var request = MioAjax({
                button_element:el,
                waiting_text: '<i class="fa fa-spinner" style="-webkit-animation:fa-spin 2s infinite linear;animation: fa-spin 2s infinite linear;"></i>',
                action: "<?php echo $module->area_link; ?>",
                method: "POST",
                data:
                    {
                        operation:"operation_server_automation",
                        use_method:"delete-volume",
                        id: volume_id,
                    }
            },true,true);
            request.done(t_form_handle);

        });
        $("#resize_volume_modal").on("click","#resize-volume",function(){
            el = $(this);
            var volume_size = $("#resize-volume-size").val();
            var request = MioAjax({
                button_element:el,
                waiting_text: '<i class="fa fa-spinner" style="-webkit-animation:fa-spin 2s infinite linear;animation: fa-spin 2s infinite linear;"></i>',
                action: "<?php echo $module->area_link; ?>",
                method: "POST",
                data:
                    {
                        operation:"operation_server_automation",
                        use_method:"resize-volume",
                        id: volume_id,
                        size : volume_size,
                    }
            },true,true);
            request.done(t_form_handle);

        });
        $("#create_volume_modal").on("click","#create-volume",function(){
            var _size        = $("#create-volume-size").val();
            var _format      = $('input[name=format]').val();
            el               = $(this);

            var request = MioAjax({
                button_element:el,
                waiting_text: '<?php echo __("website/others/button1-pending"); ?>',
                action: "<?php echo $module->area_link; ?>",
                method: "POST",
                data:
                    {
                        operation:"operation_server_automation",
                        use_method:"create-volume",
                        size: _size,
                        format: _format
                    }
            },true,true);
            request.done(t_form_handle);

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