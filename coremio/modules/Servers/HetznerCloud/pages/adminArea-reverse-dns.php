<h4><strong><?php echo $module->lang["tx83"]; ?></strong></h4>
<div class="line"></div>

<div class="clear"></div>

<div class="reserve-dns-list">
    <script type="text/javascript">
        $('#reverseDnsList').DataTable({
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
        });
    </script>

    <table width="100%" border="0" cellpadding="0" cellspacing="0" id="reverseDnsList">
        <thead>
        <tr>
            <td>#</td>
            <td>Type</td>
            <td>IP</td>
            <td>Reserve DNS</td>
            <td>&nbsp;</td>
        </tr>
        </thead>
        <tbody>

        <?php
            if($result)
            {
                foreach($result AS $k => $r)
                {
                    if($r['server'] != $module->config[$module->entity_id_name]) continue;

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
                        <td><?php
                                if(isset($r["primary"]))
                                {
                                    ?><strong><?php echo $r["ip"]; ?> [<?php echo $module->lang["tx90"]; ?>]</strong><?php
                                }
                                else
                                {
                                    echo $r["ip"];
                                }
                            ?></td>
                        <td><span class="showing-ptr"><?php echo $ptr ? $ptr : $module->lang["tx91"]; ?></span><input style="display: none;" class="editing-ptr" type="text" value="<?php echo $ptr; ?>"></td>
                        <td><a style="display: none;" class="lbtn green save-ptr" href="javascript:void 0;" data-fid="<?php echo $id; ?>" data-ip="<?php echo $ptr_ip; ?>"><i class="fa fa-check" aria-hidden="true"></i></a> <a class="lbtn edit-ptr" href="javascript:void 0;"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
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

<style>
    .reserve-dns-list table thead {
        background: #ebebeb;
        vertical-align: top;
        font-weight: 600;
    }
</style>
<script type="text/javascript">
    $(document).ready(function(){

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
                    operation:"operation_server_automation",
                    use_method:"save-ptr",
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