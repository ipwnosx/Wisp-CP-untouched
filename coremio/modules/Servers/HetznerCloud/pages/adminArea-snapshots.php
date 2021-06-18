<h4 style="float:left;"><strong><?php echo $module->lang["tx87"]; ?></strong></h4>
<a style="float:right;" data-tooltip="<?php echo $module->lang["tx73"]; ?>" class="lbtn green tooltip-left" id="create-image" href="javascript:void 0;"><?php echo $module->lang["tx102"]; ?></a>

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
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <thead>
        <tr>
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
                foreach($result AS $r)
                {
                    ?>
                    <tr>
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
                                    ?><a data-tooltip="<?php echo $module->lang["tx107"]; ?>" class="lbtn green rebuild-image" href="javascript:void 0;" data-imgid="<?php echo $r["id"]; ?>"><i class="fa fa-upload" aria-hidden="true"></i></a> <a data-tooltip="<?php echo ___("needs/button-delete"); ?>" class="lbtn red delete-image" href="javascript:void 0;" data-imgid="<?php echo $r["id"]; ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a><?php
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
                        operation:"operation_server_automation",
                        use_method:"rebuild-image",
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
                        operation:"operation_server_automation",
                        use_method:"create-image",
                        type: "snapshot",
                    }
            },true,true);
            request.done(function(result){
                var result_x = getJson(result);
                if(result_x !== false && result_x.status === "successful") open_m_page("<?php echo $module->page; ?>");
                t_form_handle(result);
            });

        });
        $(".delete-image").click(function(){
            if(!confirm("<?php echo ___("needs/delete-are-you-sure"); ?>")) return false;

            let el  = $(this);
            let _id  = el.data("imgid");

            let request = MioAjax({
                button_element:el,
                waiting_text: '<i class="fa fa-spinner" style="-webkit-animation:fa-spin 2s infinite linear;animation: fa-spin 2s infinite linear;"></i>',
                action: "<?php echo $module->area_link; ?>",
                method: "POST",
                data:{
                    operation:"operation_server_automation",
                    use_method:"delete-image",
                    id: _id,
                }
            },true,true);
            request.done(function(result)
            {
                let result_x = getJson(result);
                if(result_x !== false)
                {
                    if(result_x.status === "successful")
                        open_m_page("<?php echo $module->page; ?>");
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