<?php include __DIR__.DS."inc_assets.php"; ?>
<script type="text/javascript">
    function generate_product(s_t,el)
    {
        $("#operation-content").fadeOut(500,function(){
            $("#operation-processing").fadeIn(500);
        });

        let request_opt = {
            action: "<?php echo $links["controller"]; ?>",
            method:"POST",
            data:{process: "generate-product",server_type:s_t === false ? "" : s_t},
        };

        if(el !== undefined)
        {
            request_opt.button_element  = el;
            request_opt.waiting_text    = "<?php echo addslashes(___("needs/button-waiting")); ?>";
        }

        let request = MioAjax(request_opt,true,true);
        request.done(function(r){
            $("#operation-processing").fadeOut(500,function(){
                $("#operation-content").fadeIn(250);
            });
            hetzner_rs(r);
        });
    }

    function tr_filter() {
        return $(this).parent().parent().parent().css("display") !== "none" && $(this).parent().parent().parent().parent().css("display") !== "none";
    }

    function updateProfitRates(el)
    {
        let r = $("#profit-rate").val();
        let request = MioAjax({
            button_element: el,
            waiting_text: "<?php echo addslashes(___("needs/button-waiting")); ?>",
            action: "<?php echo $links["controller"]; ?>",
            method: "POST",
            data:{process: "update-profit-rate",rate:r}
        },true,true);
        request.done(hetzner_rs);
    }

    $(document).ready(function(){
        $(".hetznertabbtn").click(function(){
            $(".hetznertabbtn").removeClass("active");
            $(this).addClass('active');

            let type = $(this).data("type");

            $("#slist tbody").css("display","none");
            $("#list-"+type).css("display","table-row-group");

        });

        $("input[name=storage_type]").change(function(){
            $('#list-shared tr').css("display","none");
            $('#list-shared .storage-type-'+$(this).val()).css("display","table-row");
        });

        $("#select_network").change(function(){
            let value = $(this).val();
            if(value !== "none")
            {
                $(".select-network option").filter(tr_filter).removeAttr("selected");
                $(".select-network option[value="+value+"]").filter(tr_filter).attr('selected',true);
            }
            $(this).val('');
        });
        $("#select_location").change(function(){
            let value = $(this).val();
            if(value !== "none")
            {
                $(".select-location option").filter(tr_filter).removeAttr("selected");
                $(".select-location option[value="+value+"]").filter(tr_filter).attr('selected',true);
            }
            $(this).val('');
        });
        $("#select_category").change(function(){
            let value = $(this).val();
            if(value === "none")
            {
                $(".select-category option").filter(tr_filter).removeAttr("selected");
                $(".select-category option[value='']").filter(tr_filter).attr('selected',true);
            }
            else
            {
                $(".select-category option").filter(tr_filter).removeAttr("selected");
                $(".select-category option[value="+value+"]").filter(tr_filter).attr('selected',true);
            }
            $(this).val('');
        });

        $("#updateForm_submit").on("click",function(){
            MioAjaxElement($(this),{
                waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                result:"hetzner_rs",
            });
        });
    });
</script>
<?php
    if(isset($license_data) && !$license_data)
    {
        ?>
        <div class="hetznerneedaction">
            <div class="hetznerneedaction-con">
                <div id="operation-content">
                    <h3><?php echo $_LANG["tx153"]; ?></h3>
                    <h5><?php echo $_LANG["tx154"]; ?></h5>
                    <a href="https://wisecp.com/redirects?lang=<?php echo Bootstrap::$lang->clang; ?>&id=marketplace-HetznerCloud" class="yesilbtn gonderbtn" style="width: 220px;"><?php echo $_LANG["tx155"]; ?></a>
                </div>
            </div>
        </div>
        <?php
        return false;
    }
    if(isset($license_data) && $license_data && isset($is_products) && !$is_products)
    {
        ?>
        <div class="hetznerneedaction">
            <div class="hetznerneedaction-con">

                <div id="operation-content">
                    <h3><?php echo $_LANG["tx1"]; ?></h3>
                    <h5><?php echo $_LANG["tx2"]; ?></h5>
                    <a href="javascript:void 0;" onclick="generate_product(false,this);" class="yesilbtn gonderbtn" style="width: 220px;"><?php echo $_LANG["tx3"]; ?></a>
                </div>
                <div id="operation-processing" style="margin: 0px 50px;display: none;">
                    <div class="load-wrapp">
                        <p style="margin-bottom:20px;font-size:17px;" class="animate-flicker"><strong><?php echo ___("needs/processing"); ?>...</strong><br><?php echo ___("needs/please-wait"); ?></p>
                        <div class="load-7">
                            <div class="square-holder">
                                <div class="square"></div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <?php
        return false;
    }
?>

<div class="hetzner-home">

    <a href="<?php echo $links["configuration"]; ?>" class="lbtn" style="font-size: 16px;font-weight: 500;padding: 7px 20px;"><i class="fa fa-cogs" style="margin-right:5px;"></i> <?php echo $_LANG["tx11"]; ?>
    </a>

    <a data-tooltip="<?php echo $_LANG["tx62"]; ?>" href="<?php echo $links["import"]; ?>" class="lbtn tooltip-right" style="font-size: 16px;font-weight:500;padding:7px 20px;"><i class="fa fa-check-square-o" style="margin-right:5px;"></i> <?php echo $_LANG["tx12"]; ?></a>


    <div class="hetznerbulkupdate" style="">
        <a data-tooltip="<?php echo $_LANG["tx61"]; ?>" style="
    margin-right: 5px;"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
        <?php echo $_LANG["tx13"]; ?> <strong>(%)</strong><input name="profit-rate" id="profit-rate" type="text" placeholder="Ex: 15" onkeypress="return event.charCode>= 48 &amp;&amp; event.charCode<= 57" value="<?php echo $area->configuration["commission_rate"]; ?>"> <a href="javascript:void 0;" onclick="updateProfitRates(this);" class="blue lbtn"><?php echo ___("needs/button-update"); ?></a>
    </div>

    <div class="clear"></div>

    <div class="line"></div>

    <div class="hetznertabbtns">
        <div class="hetznertabbtn active" data-type="shared">
            <div class="padding20">
                <h3><?php echo $_LANG["tx26"]; ?></h3>
                <ul>
                    <li><?php echo $_LANG["tx27"]; ?></li>
                    <li><?php echo $_LANG["tx28"]; ?></li>
                    <li><?php echo $_LANG["tx29"]; ?></li>
                </ul>
            </div>

            <div class="padding20 bottombtns">
                <h5 style="font-size: 14px;font-weight: 600;margin-bottom: 7px;"><?php echo $_LANG["tx30"]; ?></h5>

                <input checked type="radio" name="storage_type" value="local" id="storage-type-local" class="radio-custom">
                <label style="margin-right: 15px;" class="radio-custom-label" for="storage-type-local">
                    <span class=""><?php echo $_LANG["tx31"]; ?></span>
                </label>

                <input type="radio" name="storage_type" value="network" id="storage-type-network" class="radio-custom">
                <label class="radio-custom-label" for="storage-type-network">
                    <span><?php echo $_LANG["tx32"]; ?></span>
                </label>
            </div>

        </div>

        <div class="hetznertabbtn" data-type="dedicated">
            <div class="padding20">
                <h3><?php echo $_LANG["tx33"]; ?></h3>
                <ul>
                    <li><?php echo $_LANG["tx34"]; ?></li>
                    <li><?php echo $_LANG["tx35"]; ?></li>
                </ul>
            </div>
            <div class="padding20 bottombtns">
                <h5 style="font-size: 14px;font-weight: 600;margin-bottom: 7px;"><?php echo $_LANG["tx37"]; ?></h5>
                <label style="margin-right: 15px;" class="radio-custom-label" for="storage-type-local2"><span><?php echo $_LANG["tx31"]; ?></span></label>
            </div>
        </div>


    </div>

    <div class="clear"></div>

    <form action="<?php echo $links["controller"]; ?>" method="post" id="updateForm">
        <input type="hidden" name="process" value="update-products">

        <div class="hetznertable">

            <table width="100%" border="0" cellpadding="0" cellspacing="0" id="slist">
                <thead>
                <tr>
                    <td align="center"><?php echo $_LANG["tx14"]; ?></td>
                    <td align="center"><?php echo $_LANG["tx15"]; ?></td>
                    <td align="center"><?php echo $_LANG["tx16"]; ?></td>
                    <td align="center"><?php echo $_LANG["tx17"]; ?></td>
                    <td align="center"><?php echo $_LANG["tx18"]; ?></td>
                    <td align="center"><?php echo $_LANG["tx19"]; ?><br>
                        <select id="select_network">
                            <option value=""><?php echo ___("needs/select-your"); ?></option>
                            <option value="auto"><?php echo $_LANG["tx25"]; ?></option>
                            <?php
                                if(isset($networks) && $networks)
                                {
                                    foreach($networks AS $n)
                                    {
                                        ?><option value="<?php echo $n["name"]; ?>"><?php echo $n["name"]; ?></option><?php
                                    }
                                }
                            ?>
                        </select>
                    </td>
                    <td align="center"><?php echo $_LANG["tx20"]; ?><br>
                        <select id="select_location">
                            <option value=""><?php echo ___("needs/select-your"); ?></option>
                            <option value="auto"><?php echo $_LANG["tx25"]; ?></option>
                            <?php
                                if(isset($locations) && $locations)
                                {
                                    foreach($locations AS $l)
                                    {
                                        ?><option value="<?php echo $l["name"]; ?>"><?php echo $l["city"]; ?></option><?php
                                    }
                                }
                            ?>
                        </select>
                    </td>
                    <td align="center"><?php echo $_LANG["tx21"]; ?><br>
                        <select id="select_category">
                            <option value=""><?php echo ___("needs/select-your"); ?></option>
                            <option value="none"><?php echo ___("needs/none"); ?></option>
                            <?php
                                if(isset($categories) && $categories)
                                {
                                    foreach($categories AS $cat)
                                    {
                                        ?>
                                        <option value="<?php echo $cat["id"]; ?>"><?php echo substr($cat["title"],4); ?></option>
                                        <?php
                                    }
                                }
                            ?>
                        </select>
                    </td>
                    <td align="center"><?php echo $_LANG["tx22"]; ?></td>
                    <td align="center"><?php echo $_LANG["tx23"]; ?></td>
                    <td><?php echo $_LANG["tx24"]; ?></td>
                </tr>
                </thead>
                <?php
                    foreach($list AS $k => $_list)
                    {
                        ?>
                        <tbody id="list-<?php echo $k; ?>" style="<?php echo $k == "dedicated" ? "display:none" : ''; ?>">
                        <?php
                            foreach($_list AS $p)
                            {
                                ?>
                                <tr class="<?php echo $k == 'shared' ? "storage-type-".$p["storage_type"] : ''; ?>" style="<?php echo $p["storage_type"] == "local" || $k == 'dedicated' ? '' : 'display:none;'; ?>">
                                    <td align="center">
                                        <input<?php echo $p["status"] ===  "no-product" ? ' disabled' : ''; ?> class="hetznertypename" type="text" name="products[<?php echo $p["s_t"]; ?>][name]" value="<?php echo $p["name"]; ?>"></td>
                                    <td align="center"><?php echo $p["cores"]; ?></td>
                                    <td align="center"><?php echo $p["ram"]; ?></td>
                                    <td align="center"><?php echo $p["disk"]; ?></td>
                                    <td align="center">
                                        <input<?php echo $p["status"] ===  "no-product" ? ' disabled' : ''; ?> class="hetznertypename" type="text" name="products[<?php echo $p["s_t"]; ?>][traffic]" value="<?php echo $p["traffic"]; ?>">
                                    </td>
                                    <td align="center">
                                        <select<?php echo $p["status"] ===  "no-product" ? ' disabled' : ''; ?> name="products[<?php echo $p["s_t"]; ?>][network]" class="select-network">
                                            <option value="auto"><?php echo $_LANG["tx25"]; ?></option>
                                            <?php
                                                if(isset($networks) && $networks)
                                                {
                                                    foreach($networks AS $n)
                                                    {
                                                        ?><option<?php echo $n["name"] == $p["network"] ? ' selected' : ''; ?> value="<?php echo $n["name"]; ?>"><?php echo $n["name"]; ?></option><?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </td>
                                    <td align="center">
                                        <select<?php echo $p["status"] ===  "no-product" ? ' disabled' : ''; ?> name="products[<?php echo $p["s_t"]; ?>][location]" class="select-location">
                                            <option value="auto"><?php echo $_LANG["tx25"]; ?></option>
                                            <?php
                                                if(isset($locations) && $locations)
                                                {
                                                    foreach($locations AS $l)
                                                    {
                                                        ?><option<?php echo $l["name"] == $p["location"] ? ' selected' : ''; ?> value="<?php echo $l["name"]; ?>"><?php echo $l["city"]; ?></option><?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </td>
                                    <td align="center">
                                        <select<?php echo $p["status"] ===  "no-product" ? ' disabled' : ''; ?> name="products[<?php echo $p["s_t"]; ?>][category]" class="select-category">
                                            <option value=""><?php echo ___("needs/none"); ?></option>
                                            <?php
                                                if(isset($categories) && $categories)
                                                {
                                                    foreach($categories AS $cat)
                                                    {
                                                        ?>
                                                        <option<?php echo $cat["id"] == $p["category"] ? ' selected' : ''; ?> value="<?php echo $cat["id"]; ?>"><?php echo substr($cat["title"],4); ?></option>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </td>
                                    <td align="center"><?php echo $p["cost"]; ?> / <?php echo $_LANG["tx36"]; ?></td>
                                    <td align="center">
                                        <input<?php echo $p["status"] ===  "no-product" ? ' disabled' : ''; ?> class="hetznerprice" type="text" name="products[<?php echo $p["s_t"]; ?>][sale]" value="<?php echo $p["sale"]; ?>">
                                        / <?php echo $_LANG["tx36"]; ?></td>
                                    <td>
                                        <?php
                                            if($p["status"] ===  "no-product")
                                            {
                                                ?>
                                                <div id="wrap-<?php echo $p["s_t"]; ?>-status">
                                                    <a href="javascript:void 0;" onclick="generate_product('<?php echo $p["s_t"]; ?>',this);" class="lbtn green">
                                                        <i class="fa fa-plus"></i>
                                                        <?php echo ___("needs/button-add"); ?>
                                                    </a>
                                                </div>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <input<?php echo $p["status"] ? ' checked' : ''; ?> type="checkbox" id="p-<?php echo $p["s_t"]; ?>-status" name="products[<?php echo $p["s_t"]; ?>][status]" value="1" class="sitemio-checkbox">
                                                <label style="margin-right: 0px;" class="sitemio-checkbox-label" for="p-<?php echo $p["s_t"]; ?>-status"></label>
                                                <?php
                                            }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        ?>
                        </tbody>
                        <?php
                    }
                ?>
            </table>


        </div>


        <div class="clear"></div>

        <div class="line"></div>

        <a href="javascript:void 0;" id="updateForm_submit" class="yesilbtn gonderbtn" style="    width: 220px;    float: right;"><?php echo ___("needs/button-update"); ?></a>
    </form>


</div>