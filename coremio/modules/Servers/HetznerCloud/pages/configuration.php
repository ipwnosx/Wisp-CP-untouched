<?php include __DIR__.DS."inc_assets.php"; ?>
<div class="hetzner-settings">
    <script type="text/javascript">
        $(document).ready(function(){
            let element1 = $("#client_available_isos");
            element1.select2();
            select2_sortable(element1);

            let element2 = $("#client_available_images");
            element2.select2();
            select2_sortable(element2);


            $("#updateForm_submit").on("click",function(){
                MioAjaxElement($(this),{
                    waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                    progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                    result:"hetzner_rs",
                });
            });
        });
    </script>
    <form action="<?php echo $links["controller"]; ?>" method="post" id="updateForm">

        <div class="adminpagecon">


            <div class="biggroup">
                <div class="padding20">
                    <h4 class="biggrouptitle"><?php echo $_LANG["tx39"]; ?></h4>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo $_LANG["tx42"]; ?></div>
                        <div class="yuzde70">
                            <input<?php echo $area->configuration["hide_out_of_stock"] ? ' checked' : ''; ?> type="checkbox" name="hide_out_of_stock" value="1" id="hide_out_of_stock" class="sitemio-checkbox">
                            <label class="sitemio-checkbox-label" for="hide_out_of_stock"></label>
                            <span class="kinfo"><?php echo $_LANG["tx43"]; ?></span>
                        </div>
                    </div>


                    <div class="formcon">
                        <div class="yuzde30"><?php echo $_LANG["tx44"]; ?></div>
                        <div class="yuzde70">
                            <input<?php echo $area->configuration["order_step_backup"] ? ' checked' : ''; ?> type="checkbox" name="order_step_backup" value="1" id="order_step_backup" class="sitemio-checkbox">
                            <label class="sitemio-checkbox-label" for="order_step_backup"></label>
                            <span class="kinfo"><?php echo $_LANG["tx45"]; ?></span>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo $_LANG["tx114"]; ?></div>
                        <div class="yuzde70">
                            <input<?php echo $area->configuration["order_step_volume"] ? ' checked' : ''; ?> type="checkbox" name="order_step_volume" value="1" id="order_step_volume" class="sitemio-checkbox">
                            <label class="sitemio-checkbox-label" for="order_step_volume"></label>
                            <span class="kinfo"><?php echo $_LANG["tx115"]; ?></span>
                        </div>
                    </div>


                    <div class="formcon">
                        <div class="yuzde30"><?php echo $_LANG["tx46"]; ?></div>
                        <div class="yuzde70">
                            <input<?php echo $area->configuration["order_step_snapshots"] ? ' checked' : ''; ?> type="checkbox" name="order_step_snapshots" value="1" id="order_step_snapshots" class="sitemio-checkbox">
                            <label class="sitemio-checkbox-label" for="order_step_snapshots"></label>
                            <span class="kinfo"><?php echo $_LANG["tx47"]; ?></span>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo $_LANG["tx48"]; ?></div>
                        <div class="yuzde70">
                            <input<?php echo $area->configuration["order_step_floating_ips"] ? ' checked' : ''; ?> type="checkbox" name="order_step_floating_ips" value="1" id="order_step_floating_ips" class="sitemio-checkbox">
                            <label class="sitemio-checkbox-label" for="order_step_floating_ips"></label>
                            <span class="kinfo"><?php echo $_LANG["tx49"]; ?></span>
                        </div>
                    </div>




                    <div class="clear"></div>
                </div>
            </div>


            <div class="biggroup">
                <div class="padding20">
                    <h4 class="biggrouptitle"><?php echo $_LANG["tx50"]; ?></h4>


                    <div class="formcon">
                        <div class="yuzde30"><?php echo $_LANG["tx51"]; ?></div>
                        <div class="yuzde70">
                            <input<?php echo $area->configuration["client_rebuild"] ? ' checked' : ''; ?> type="checkbox" name="client_rebuild" value="1" id="client_rebuild" class="sitemio-checkbox">
                            <label class="sitemio-checkbox-label" for="client_rebuild"></label>
                            <span class="kinfo"><?php echo $_LANG["tx52"]; ?></span>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo $_LANG["tx55"]; ?></div>
                        <div class="yuzde70">
                            <input<?php echo $area->configuration["client_console"] ? ' checked' : ''; ?> type="checkbox" name="client_console" value="1" id="client_console" class="sitemio-checkbox">
                            <label class="sitemio-checkbox-label" for="client_console"></label>
                            <span class="kinfo"><?php echo $_LANG["tx56"]; ?></span>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo $_LANG["tx53"]; ?></div>
                        <div class="yuzde70">
                            <input<?php echo $area->configuration["client_reverse_dns"] ? ' checked' : ''; ?> type="checkbox" name="client_reverse_dns" value="1" id="client_reverse_dns" class="sitemio-checkbox">
                            <label class="sitemio-checkbox-label" for="client_reverse_dns"></label>
                            <span class="kinfo"><?php echo $_LANG["tx54"]; ?></span>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo $_LANG["tx88"]; ?></div>
                        <div class="yuzde70">
                            <input<?php echo $area->configuration["client_iso"] ? ' checked' : ''; ?> type="checkbox" name="client_iso" value="1" id="client_iso" class="sitemio-checkbox">
                            <label class="sitemio-checkbox-label" for="client_iso"></label>
                            <span class="kinfo"><?php echo $_LANG["tx141"]; ?></span>
                        </div>
                    </div>


                    <div class="formcon">
                        <div class="yuzde30"><?php echo $_LANG["tx57"]; ?></div>
                        <div class="yuzde70">
                            <select name="client_available_isos[]" id="client_available_isos" multiple>
                                <?php
                                    $selected_items         = [];
                                    $unselected_items       = [];
                                    if(isset($isos) && $isos)
                                    {
                                        foreach($isos AS $i)
                                        {
                                            if(in_array($i["name"],$area->configuration["client_available_isos"]))
                                                $selected_items[$i["name"]] = '<option selected value="'.$i["name"].'">'.$i["description"].'</option>';
                                            else
                                                $unselected_items[$i["name"]] = '<option value="'.$i["name"].'">'.$i["description"].'</option>';
                                        }
                                    }
                                    if($area->configuration["client_available_isos"])
                                    {
                                        foreach($area->configuration["client_available_isos"] AS $i)
                                            echo isset($selected_items[$i]) ? $selected_items[$i] : '';
                                    }
                                    foreach($unselected_items AS $i)
                                        echo $i;
                                ?>
                            </select>
                            <span class="kinfo"><?php echo $_LANG["tx58"]; ?></span>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo $_LANG["tx59"]; ?></div>
                        <div class="yuzde70">
                            <select name="client_available_images[]" id="client_available_images" multiple>
                                <?php
                                    $selected_items         = [];
                                    $unselected_items       = [];
                                    if(isset($images) && $images)
                                    {
                                        foreach($images AS $i)
                                        {
                                            if(in_array($i["name"],$area->configuration["client_available_images"]))
                                                $selected_items[$i["name"]] = '<option selected value="'.$i["name"].'">'.$i["description"].'</option>';
                                            else
                                                $unselected_items[$i["name"]] = '<option value="'.$i["name"].'">'.$i["description"].'</option>';
                                        }
                                    }
                                    if($area->configuration["client_available_images"])
                                    {
                                        foreach($area->configuration["client_available_images"] AS $i)
                                            echo isset($selected_items[$i]) ? $selected_items[$i] : '';
                                    }
                                    foreach($unselected_items AS $i)
                                        echo $i;
                                ?>
                            </select>
                            <span class="kinfo"><?php echo $_LANG["tx60"]; ?></span>
                        </div>
                    </div>



                    <div class="clear"></div>
                </div>
            </div>



        </div>

        <div class="line"></div>

        <a href="<?php echo $links["home"]; ?>" class="mavibtn gonderbtn" style="width: 220px;float: left;"><?php echo $_LANG["turn-back"]; ?></a>

        <a id="updateForm_submit" href="javascript:void 0;" class="yesilbtn gonderbtn" style="width: 220px;float:right;"><?php echo ___("needs/button-update"); ?></a>

    </form>

</div>