<div class="padding30">
    <h4 class="cleintArea-module-page-title"><strong><?php echo $module->lang["tx84"]; ?></strong></h4>

    <?php
        if($remaining > 0)
        {
            ?>
            <a style="float:right;" class="clientArea-module-page-btn green" href="javascript:open_modal('add_floating_ip_modal');">+ <?php echo $module->lang["tx92"]; ?></a>
            <?php
        }
        else
        {
            ?>
            <a style="float:right;" class="clientArea-module-page-btn green" href="<?php echo $module->area_link; ?>?tab=addons">+ <?php echo $module->lang["tx148"]; ?></a>
            <?php
        }
    ?>

    <div class="clear"></div>
    <div class="line"></div>


    <div id="add_floating_ip_modal" style="display: none;" data-izimodal-title="<?php echo $module->lang["tx92"]; ?>">
        <div class="padding20">
            <div class="clear"></div>

            <div class="formcon">
                <div class="yuzde30"><?php echo $module->lang["tx145"]; ?> / <?php echo $module->lang["tx146"]; ?></div>
                <div class="yuzde70">
                    <?php
                        echo $remaining . " / ".$limit;
                    ?>
                </div>
            </div>

            <div class="formcon">
                <div class="yuzde30"><?php echo $module->lang["tx147"]; ?></div>
                <div class="yuzde70">
                    <select id="select_ip_type" style="width: 200px;">
                        <option value=""><?php echo ___("needs/select-your"); ?></option>
                        <option value="ipv4">IPv4</option>
                        <option value="ipv6">IPv6</option>
                    </select>
                </div>
            </div>


            <div class="guncellebtn yuzde30" style="float: right; margin-top: 10px;">
                <?php

                ?>
                <a href="javascript:void 0;" class="gonderbtn yesilbtn" id="add_floating_ip_btn"><?php echo ___("needs/button-create"); ?></a>
            </div>
            <div class="clear"></div>
        </div>
    </div>

    <div class="clear"></div>

    <div class="reserve-dns-list">
        <script type="text/javascript">
            var listTable;
            $(document).ready(function(){
                listTable = $('#FloatingIPs_list').DataTable({
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

        <table width="100%" border="0" cellpadding="0" cellspacing="0" id="FloatingIPs_list">
            <thead>
            <tr>
                <td>#</td>
                <td><?php echo $module->lang["tx142"]; ?></td>
                <td>IP</td>
                <td><?php echo $module->lang["tx143"]; ?></td>
                <td>&nbsp;</td>
            </tr>
            </thead>
            <tbody>

            <?php
                if($result)
                {
                    foreach($result AS $k => $r)
                    {
                        $id             = isset($r["id"]) ? $r["id"] : 0;
                        $ptr            = $r["dns_ptr"];
                        $ptr_ip         = $r["ip"];

                        if(is_array($ptr))
                        {
                            if($ptr)
                            {
                                $ptr        = current($ptr);
                                $ptr_ip     = $ptr["ip"];
                                $ptr        = $ptr["dns_ptr"];
                            }
                            else
                                $ptr = '';
                        }

                        ?>
                        <tr>
                            <td><?php echo $k; ?></td>
                            <td><?php echo $r['type'] == "ipv4" ? "IPv4" : "IPv6"; ?></td>
                            <td><?php echo $r["ip"]; ?></td>
                            <td><span class="showing-ptr"><?php echo $ptr ? $ptr : $module->lang["tx91"]; ?></span><input style="display: none;" class="editing-ptr" type="text" value="<?php echo $ptr; ?>"></td>
                            <td><a style="display: none;" class="sbtn green save-ptr" href="javascript:void 0;" data-fid="<?php echo $id; ?>" data-ip="<?php echo $ptr_ip; ?>"><i class="fa fa-check" aria-hidden="true"></i></a> <a class="sbtn edit-ptr" href="javascript:void 0;"><i class="fa fa-pencil" aria-hidden="true"></i></a> <a class="sbtn red delete-ip" href="javascript:void 0;" data-fid="<?php echo $id; ?>" data-ip="<?php echo $ptr_ip; ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>
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


    <a href="javascript:reload_module_content('home'); void 0;" class="clientArea-module-page-btn
"><i class="fa fa-chevron-circle-left"></i> <?php echo $module->lang["turn-back"]; ?></a>

    <style>
        .reserve-dns-list table thead {
            background: #ebebeb;
            vertical-align: top;
            font-weight: 600;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){

            $('#add_floating_ip_modal').on('click','#add_floating_ip_btn',function(){
                var _type = $("#select_ip_type").val();
                var el    = $(this);
                var request = MioAjax({
                    button_element:el,
                    waiting_text: "<?php echo __("website/others/button1-pending"); ?>",
                    action: "<?php echo $module->area_link; ?>",
                    method: "POST",
                    data:
                        {
                            inc:"panel_operation_method",
                            method:"add-fip",
                            type: _type,
                        }
                },true,true);
                request.done(t_form_handle);

            });

            $('.delete-ip').click(function(){

                if(!confirm("<?php echo ___("needs/delete-are-you-sure"); ?>")) return false;

                let el  = $(this);
                let ip  = el.data("ip");
                let id  = el.data("fid");

                let request = MioAjax({
                    button_element:el,
                    waiting_text: '<i class="fa fa-spinner" style="-webkit-animation:fa-spin 2s infinite linear;animation: fa-spin 2s infinite linear;"></i>',
                    action: "<?php echo $module->area_link; ?>",
                    method: "POST",
                    data:{
                        inc:"panel_operation_method",
                        method:"delete-fip",
                        fid: id,
                        ip: ip,
                    }
                },true,true);
                request.done(function(result)
                {
                    let result_x = getJson(result);
                    if(result_x !== false)
                    {
                        if(result_x.status === "successful")
                            listTable.row(el.parent().parent()).remove().draw();
                    }
                    t_form_handle(result);
                });

            });

            $('.save-ptr').click(function(){
                let el  = $(this);
                let ip  = el.data("ip");
                let id  = el.data("fid");
                let ptr = $('.editing-ptr',el.parent().parent()).val();

                let request = MioAjax({
                    button_element:el,
                    waiting_text: '<i class="fa fa-spinner" style="-webkit-animation:fa-spin 2s infinite linear;animation: fa-spin 2s infinite linear;"></i>',
                    action: "<?php echo $module->area_link; ?>",
                    method: "POST",
                    data:{
                        inc:"panel_operation_method",
                        method:"save-ptr",
                        fid: id,
                        ip: ip,
                        ptr: ptr,
                    }
                },true,true);
                request.done(function(result)
                {
                    let result_x = getJson(result);
                    if(result_x !== false)
                    {
                        if(result_x.status === "successful")
                        {
                            $('.editing-ptr',el.parent().parent()).css("display","none");
                            $('.save-ptr',el.parent().parent()).css("display","none");
                            $('.showing-ptr',el.parent().parent()).css("display","block").html(ptr);
                        }
                    }
                    t_form_handle(result);
                });

            });

            $('.showing-ptr').click(function(){
                $('.edit-ptr',$(this).parent().parent()).click();
            });

            $('.edit-ptr').click(function(){
                let el = $(this);

                if($('.save-ptr',el.parent()).css("display") === "none")
                {
                    $('.editing-ptr').css("display","none");
                    $('.save-ptr').css("display","none");
                    $('.showing-ptr').css("display","block");


                    $('.save-ptr',el.parent()).css("display","inline-block");
                    $('.editing-ptr',el.parent().parent()).css('display','block').focus();
                    $('.showing-ptr',el.parent().parent()).css('display','none');
                }
                else
                {
                    $('.save-ptr',el.parent()).css("display","none");
                    $('.editing-ptr',el.parent().parent()).css('display','none').val($('.showing-ptr',el.parent().parent()).text());
                    $('.showing-ptr',el.parent().parent()).css('display','block');
                }

            });

        });
    </script>


    <div class="clear"></div>
</div>