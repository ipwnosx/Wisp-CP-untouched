<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    $wide_content = true;
    $hoptions = ["datatables","iziModal","select2"];
?>
<div class="mpanelrightcon">

    <div class="mpaneltitle">
        <div class="sayfayolu"><?php include $tpath."inc".DS."panel-breadcrumb.php"; ?></div>
        <h4><strong><i class="fa fa-handshake-o" aria-hidden="true"></i> <?php echo $header_title; ?></strong></h4>
        <?php
            if($aff)
            {
                if($rates_conditions)
                {
                    ?>
                    <a id="affiliate-paym-info" href="<?php echo $links["controller"]; ?>"><i class="fa fa-angle-double-left" aria-hidden="true"></i> <?php echo __("website/account/affiliate-tx19"); ?></a>
                    <?php
                }else
                {
                    ?>
                    <div class="clearmob"></div>
                    <a id="affiliate-paym-info" href="javascript:void 0;" onclick="open_modal('YourPaymentInfo');"><i class="fa fa-university" aria-hidden="true"></i> <?php echo __("website/account/affiliate-tx17"); ?></a>
                    <a id="affiliate-paym-info" href="<?php echo $links["rates-conditions"]; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i> <?php echo __("website/account/affiliate-tx18"); ?></a>
                    <?php
                }
            }
        ?>
    </div>

    <?php
        if($aff && !$rates_conditions)
        {
            ?>

            <div id="YourPaymentInfo" style="display: none;" data-izimodal-title="<?php echo __("website/account/affiliate-tx17"); ?>">
                <script type="text/javascript">
                    $(document).ready(function(){

                        $("#YourPaymentInfo_submit").click(function(){
                            MioAjaxElement(this,{
                                waiting_text: "<?php echo addslashes(__("website/others/button1-pending")); ?>",
                                result:"YourPaymentInfo_handler",
                            });
                        });

                    });

                    function YourPaymentInfo_handler(result){
                        if(result !== ''){
                            var solve = getJson(result);
                            if(solve !== false){
                                if(solve.status === "error"){
                                    if(solve.message != undefined && solve.message != '')
                                        alert_error(solve.message,{timer:3000});
                                }
                                else if(solve.status === "successful")
                                {
                                    alert_success(solve.message,{timer:3000});
                                    setTimeout(function(){
                                        location.href   = window.location.href;
                                    },3000);
                                }
                            }else
                                console.log(result);
                        }
                    }
                </script>
                <div class="padding20">

                    <form action="<?php echo $links["payment-information"]; ?>" method="post" id="PaymentInfoForm">

                        <?php
                            if(!$transaction_list)
                            {
                                ?>
                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("website/account_info/select-currency"); ?></div>
                                    <div class="yuzde70">
                                        <select name="currency">
                                            <?php
                                                if($currencies = Money::getCurrencies()){
                                                    foreach($currencies AS $currency){
                                                        ?><option value="<?php echo $currency["id"]; ?>"<?php echo $currency["id"] == $aff["currency"] ? " selected" : ''; ?>><?php echo $currency["name"]." (".$currency["code"].")"; ?></option><?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                        <span class="kinfo"><?php echo __("website/account/affiliate-tx58"); ?></span>
                                    </div>
                                </div>
                                <?php
                            }
                        ?>

                        <?php
                            if($gateways)
                            {
                                foreach($gateways AS $k => $gateway)
                                {
                                    ?>
                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo $gateway; ?></div>
                                        <div class="yuzde70">
                                            <textarea name="values[<?php echo $k; ?>]"><?php echo isset($aff['payment_information'][$k]) ? $aff['payment_information'][$k] :  ''; ?></textarea>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                        ?>

                        <div class="clear"></div>

                        <div style="float: right;" class="yuzde30">
                            <a href="javascript:void(0);" id="YourPaymentInfo_submit" class="yesilbtn gonderbtn"><?php echo ___("needs/button-update"); ?></a>
                        </div>

                    </form>
                    <div class="clear"></div>

                </div>
            </div>
            <div id="withdrawal_modal" style="display: none;" data-izimodal-title="<?php echo __("website/account/affiliate-tx24"); ?>">
                <div class="padding20">

                    <form action="<?php echo $links["withdrawal"]; ?>" method="post" id="WithdrawalForm">
                        <div class="formcon">
                            <div class="yuzde30"><?php echo __("website/account/affiliate-tx65"); ?></div>
                            <div class="yuzde70">
                                <strong><?php echo $total_balance; ?></strong>
                            </div>
                        </div>

                        <div class="formcon">
                            <div class="yuzde30"><?php echo __("website/account/affiliate-tx66"); ?></div>
                            <div class="yuzde70">
                                <select name="gateway" onchange="$($(this).parent()).find('textarea').val($('option:selected',$(this)).data('content')).trigger('change');">
                                    <option value=""><?php echo ___("needs/select-your"); ?></option>
                                    <?php
                                        foreach($gateways AS $k => $v)
                                        {
                                            $_con = '';
                                            if(isset($aff['payment_information'][$k]))
                                                $_con = $aff['payment_information'][$k];
                                            ?>
                                            <option data-content="<?php echo htmlspecialchars($_con,ENT_QUOTES); ?>" value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                                <div class="clear"></div>
                                <span class="kinfo"><?php echo __("website/account/affiliate-tx68"); ?></span>
                                <div class="clear"></div>
                                <textarea name="gateway_info" placeholder="<?php echo __("website/account/affiliate-tx67"); ?>"></textarea>
                                <input type="checkbox" id="save_as_default_gateway_info" class="checkbox-custom" value="1" name="save_as_default_gateway_info">
                                <label class="checkbox-custom-label" for="save_as_default_gateway_info"><span class="kinfo"><?php echo __("website/account/affiliate-tx69"); ?></span></label>
                            </div>
                        </div>

                        <div class="clear"></div>

                        <div style="float: right;" class="yuzde30">
                            <a href="javascript:void(0);" id="WithdrawalForm_submit" class="yesilbtn gonderbtn"><?php echo ___("needs/button-submit"); ?></a>
                        </div>
                    </form>
                    <script type="text/javascript">
                        $(document).ready(function(){
                            $("#WithdrawalForm_submit").click(function(){
                                MioAjaxElement(this,{
                                    waiting_text: "<?php echo addslashes(__("website/others/button1-pending")); ?>",
                                    result:"WithdrawalForm_handler",
                                });
                            });
                        });
                        function WithdrawalForm_handler(result){
                            if(result !== ''){
                                var solve = getJson(result);
                                if(solve !== false){
                                    if(solve.status === "error"){
                                        if(solve.for != undefined && solve.for != ''){
                                            $("#WithdrawalForm "+solve.for).focus();
                                            $("#WithdrawalForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                            $("#WithdrawalForm "+solve.for).change(function(){
                                                $(this).removeAttr("style");
                                            });
                                        }

                                        if(solve.message != undefined && solve.message != '')
                                            alert_error(solve.message,{timer:3000});
                                    }
                                    else if(solve.status === "successful")
                                    {
                                        alert_success(solve.message,{timer:3000});
                                        if(solve.redirect != undefined)
                                        {
                                            setTimeout(function(){
                                                window.location.href   = solve.redirect;
                                            },3000);
                                        }
                                    }
                                }else
                                    console.log(result);
                            }
                        }
                    </script>


                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </div>

            <div class="affiliate">

                <div class="dashboardboxs">

                    <div class="dashboardbox" id="turuncublok">
                        <div class="padding10">
                            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                            <h2><?php echo $pending_balance_today; ?>
                                <a class="dashboardbox-info tooltip-top" data-tooltip="<?php echo __("website/account/affiliate-tx21"); ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
                            </h2>
                            <h4><?php echo __("website/account/affiliate-tx22"); ?></h4>
                            <div class="ablokbottom"><span><?php echo __("website/account/affiliate-tx23"); ?> <strong><?php echo $pending_balance_total; ?></strong></span></div>
                        </div>
                    </div>

                    <div class="dashboardbox" id="yesilblok">
                        <?php
                            $available_balance = $aff['balance'] >= Money::exChange(Config::get("options/affiliate/min-payment-amount"),Config::get("general/currency"),$aff['currency']);
                            if($available_balance)
                            {
                                ?>
                                <a class="withdrawal-request pulsate-fwd" href="javascript:void 0;" onclick="open_modal('withdrawal_modal');">+ <?php echo __("website/account/affiliate-tx24"); ?></a>
                                <?php
                            }
                            else
                            {
                                ?>
                                <a class="withdrawal-request">+ <?php echo __("website/account/affiliate-tx24"); ?></a>
                                <?php
                            }
                        ?>

                        <div class="padding10">
                            <?php
                                if($available_balance)
                                {
                                    ?>
                                    <i class="ion-happy-outline" style="line-height: 105px;" aria-hidden="true"></i>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <i class="fa fa-meh-o" style="line-height: 100px;" aria-hidden="true"></i>
                                    <?php
                                }
                            ?>
                            <h2><?php echo $total_balance; ?>
                                <a class="dashboardbox-info tooltip-top" data-tooltip="<?php echo __("website/account/affiliate-tx25"); ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
                            </h2>
                            <h4><?php echo __("website/account/affiliate-tx26"); ?></h4>
                            <div class="ablokbottom"><span><?php echo __("website/account/affiliate-tx27"); ?> <strong><?php echo  $total_withdrawals; ?></strong></span></div>
                        </div>
                    </div>

                    <div class="dashboardbox" id="redblok">
                        <div class="padding10">
                            <i class="fa fa-users" aria-hidden="true"></i>
                            <h2><?php echo $references_today; ?>
                                <a class="dashboardbox-info tooltip-top" data-tooltip="<?php echo __("website/account/affiliate-tx28"); ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
                            </h2>
                            <h4><?php echo __("website/account/affiliate-tx29"); ?></h4>
                            <div class="ablokbottom"><span><?php echo __("website/account/affiliate-tx30"); ?> <strong><?php echo $references_total; ?></strong></span></div>
                        </div>
                    </div>

                    <div class="dashboardbox" id="maviblok">
                        <div class="padding10">
                            <i class="ion-earth" style="line-height: 20px;" aria-hidden="true"></i>
                            <h2><?php echo $hits_today; ?>
                                <a class="dashboardbox-info tooltip-top" data-tooltip="<?php echo __("website/account/affiliate-tx31"); ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
                            </h2>
                            <h4><?php echo __("website/account/affiliate-tx32"); ?></h4>
                            <div class="ablokbottom"><span><?php echo __("website/account/affiliate-tx30"); ?> <strong><?php echo $hits_total; ?></strong></span></div>
                        </div>
                    </div>
                </div>

                <div class="refererurl">
                    <h4><?php echo __("website/account/affiliate-tx33"); ?></h4>
                    <h5><?php echo __("website/account/affiliate-tx34"); ?></h5>
                    <h2><?php echo $links["tracking"]; ?></h2>
                </div>

                <script type="text/javascript">
                    $(document).ready(function(){
                        var tab = gGET("group");
                        if (tab != '' && tab != undefined) {
                            $("#tab-group .tablinks[data-tab='" + tab + "']").click();
                        } else {
                            $("#tab-group .tablinks:eq(0)").addClass("active");
                            $("#tab-group .tabcontent:eq(0)").css("display", "block");
                        }

                        $('#table_transactions,#table_withdrawals,#table_hits').DataTable({
                            "columnDefs": [
                                {
                                    "targets": [0],
                                    "visible":false,
                                    "searchable": false
                                }
                            ],
                            "lengthMenu": [
                                [10, 25, 50, -1], [10, 25, 50, "<?php echo ___("needs/allOf"); ?>"]
                            ],
                            responsive: true,
                            "language":{"url":"<?php echo APP_URI; ?>/<?php echo ___("package/code"); ?>/datatable/lang.json"}
                        });

                    });
                </script>
                <div id="tab-group" class="affilia-tablelist dataTables_wrapper no-footer">

                    <ul class="tab">
                        <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'transactions','group')" data-tab="transactions"><?php echo __("website/account/affiliate-tx35"); ?></a></li>

                        <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'withdrawals','group')" data-tab="withdrawals"><?php echo __("website/account/affiliate-tx36"); ?></a></li>

                        <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'hits','group')" data-tab="hits"><?php echo __("website/account/affiliate-tx37"); ?></a></li>

                        <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'banners','group')" data-tab="banners"><?php echo __("website/account/affiliate-tx38"); ?></a></li>
                    </ul>


                    <div id="group-transactions" class="tabcontent">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" id="table_transactions">
                            <thead style="background:#ebebeb;">
                            <tr>
                                <th align="center">#</th>
                                <th align="center" data-orderable="false"><?php echo __("website/account/affiliate-tx39"); ?></th>
                                <th align="center" data-orderable="false"><?php echo __("website/account/affiliate-tx40"); ?></th>
                                <th align="center" data-orderable="false"><?php echo __("website/account/affiliate-tx41"); ?></th>
                                <th align="center" data-orderable="false"><?php echo __("website/account/affiliate-tx42"); ?></th>
                                <th align="center" data-orderable="false"><?php echo __("website/account/affiliate-tx43"); ?></th>
                                <th align="center" data-orderable="false"><?php echo __("website/account/affiliate-tx44"); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                if($transaction_list)
                                {
                                    foreach($transaction_list AS $k => $row)
                                    {
                                        $rate = $row["rate"];
                                        $rate_split = explode(".",$rate);
                                        if(isset($rate_split[1]) && $rate_split[1] < 01)
                                            $rate = $rate_split[0];
                                        ?>
                                        <tr>
                                            <td align="center"><?php echo $k; ?></td>
                                            <td align="center"><?php echo DateManager::format(Config::get("options/date-format")." H:i",$row['clicked_ctime']); ?></td>
                                            <td align="center"><strong><?php echo $row["full_name"]; ?></strong><br>(<?php echo in_array($row['status'],['invalid','invalid-another']) ? __("website/account/affiliate-tx46") : __("website/account/affiliate-tx45"); ?>)</td>
                                            <td align="center"><?php echo $row['order_name'] ? $row["order_name"] : __("website/account/affiliate-tx59"); ?></td>
                                            <td align="center"><?php echo Money::formatter_symbol($row["amount"],$row["currency"]); ?></td>
                                            <td align="center">
                                                <strong><?php echo Money::formatter_symbol($row["commission"],$aff["currency"]); ?></strong> (%<?php echo $rate; ?>)
                                                <?php
                                                    if($row["exchange"] > 0.00)
                                                    {
                                                        ?>
                                                        <br>(<?php echo __("website/account/affiliate-tx51")." ".Money::formatter($row["exchange"],$aff["currency"]); ?>)
                                                        <?php
                                                    }
                                                ?>
                                            </td>
                                            <td align="center">

                                                <div class="listingstatus">
                                                    <?php echo $transaction_situations[$row["status"]]; ?>
                                                    <?php
                                                        if(in_array($row["status"],['approved','completed']))
                                                        {
                                                            ?>
                                                            <br>(<?php echo DateManager::format(Config::get("options/date-format"),$row["ctime"]); ?>)
                                                            <a class="dashboardbox-info tooltip-top" data-tooltip="<?php echo __("website/account/affiliate-tx48",['{date}' => DateManager::format(Config::get("options/date-format"),$row["clearing_date"])]); ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
                                                            <?php
                                                        }
                                                        elseif($row["status"] == "invalid")
                                                        {
                                                            ?>
                                                            <a class="dashboardbox-info tooltip-top" data-tooltip="<?php echo __("website/account/affiliate-tx47"); ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
                                                            <?php
                                                        }
                                                        elseif($row["status"] == "invalid-another")
                                                        {
                                                            ?>
                                                            <a class="dashboardbox-info tooltip-top" data-tooltip="<?php echo __("website/account/affiliate-tx60"); ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
                                                            <?php
                                                        }
                                                    ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                            ?>
                            </tbody>
                        </table>

                    </div>

                    <div id="group-withdrawals" class="tabcontent">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" id="table_withdrawals">
                            <thead style="background:#ebebeb;">
                            <tr>
                                <th align="center">#</th>
                                <th align="center" data-orderable="false"><?php echo __("website/account/affiliate-tx52"); ?></th>
                                <th align="center" data-orderable="false"><?php echo __("website/account/affiliate-tx53"); ?></th>
                                <th align="center" data-orderable="false"><?php echo __("website/account/affiliate-tx54"); ?></th>
                                <th align="center" data-orderable="false"><?php echo __("website/account/affiliate-tx55"); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                if($withdrawals_list)
                                {
                                    foreach($withdrawals_list AS $row)
                                    {
                                        ?>
                                        <tr>
                                            <td align="center"><?php echo $k; ?></td>
                                            <td align="center">
                                                <?php echo DateManager::format(Config::get("options/date-format")." H:i",$row["ctime"]); ?>
                                            </td>
                                            <td align="center">
                                                <?php echo isset($gateways[$row["gateway"]]) ? $gateways[$row["gateway"]] : ___("needs/unknown"); ?> <a class="dashboardbox-info tooltip-top" data-tooltip="<?php echo str_replace('"','\"',$row["gateway_info"]  ? $row["gateway_info"] : __("website/account/affiliate-tx64")); ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></a></td>
                                            <td align="center"><strong><?php echo Money::formatter_symbol($row["amount"],$row["currency"]); ?></strong></td>
                                            <td align="center">
                                                <div class="listingstatus">
                                                    <?php
                                                        echo $withdrawal_situations[$row["status"]];

                                                        if($row["status"] == "completed")
                                                        {
                                                            ?>
                                                            <br>
                                                            (<?php echo DateManager::format(Config::get("options/date-format")." H:i",$row["completed_time"]); ?>)
                                                            <?php
                                                        }
                                                        if($row["status_msg"])
                                                        {
                                                            ?>
                                                            <br>
                                                            <?php echo $row["status_msg"]; ?>
                                                            <?php
                                                        }
                                                    ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>

                    <div id="group-hits" class="tabcontent">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" id="table_hits">
                            <thead style="background:#ebebeb;">
                            <tr>
                                <th align="center">#</th>
                                <th data-orderable="false" align="left"><?php echo __("website/account/affiliate-tx56"); ?></th>
                                <th align="center"><?php echo __("website/account/affiliate-tx57"); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                if($referrer_list)
                                {
                                    foreach($referrer_list AS $k => $row)
                                    {
                                        ?>
                                        <tr>
                                            <td align="center"><?php echo $k; ?></td>
                                            <td align="left">
                                                <?php
                                                    if($row["referrer"]){
                                                        ?>
                                                        <a target="_blank" referrerpolicy="no-referrer" href="<?php echo $row["referrer"]; ?>"><?php echo $row["referrer"]; ?></a>
                                                        <?php
                                                    }
                                                    else
                                                    {
                                                        echo ___("needs/none");
                                                    }
                                                ?>
                                            </td>
                                            <td align="center"><?php echo $row["hits"]; ?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>

                    <div id="group-banners" class="tabcontent">
                        <?php echo $banner_content; ?>
                    </div>

                </div>

            </div>
            <?php
        }
        else
        {
            ?>
            <div class="affiliate">
                <div class="affiliate-getstarted">

                    <?php
                        if(!$rates_conditions)
                        {
                            ?>
                            <div class="green-info" style="margin-bottom:25px;">
                                <div class="padding20">
                                    <i class="ion-trophy" aria-hidden="true"></i>
                                    <p><?php echo __("website/account/affiliate-tx1"); ?></p>
                                </div>
                            </div>
                            <?php
                        }
                    ?>


                    <h5><strong><?php echo __("website/account/affiliate-tx2"); ?></strong></h5>
                    <ul>

                        <li><?php echo __("website/account/affiliate-tx3"); ?></li>
                        <?php if(Config::get("options/affiliate/commission-period") == 'lifetime'): ?>
                            <li><?php echo __("website/account/affiliate-tx4"); ?></li>
                        <?php endif; ?>

                        <li><?php echo __("website/account/affiliate-tx5"); ?></li>
                        <li>
                            <?php
                                echo __("website/account/affiliate-tx6",[
                                    '{cookie_duration}' => Config::get("options/affiliate/cookie-duration"),
                                ]);
                            ?>
                        </li>
                        <li>
                            <?php
                                echo __("website/account/affiliate-tx7",[
                                    '{amount}' => $min_p_a,
                                ]);
                            ?>
                        </li>
                        <li>
                            <?php
                                echo __("website/account/affiliate-tx15",[
                                    '{commission_delay}' => Config::get("options/affiliate/commission-delay"),
                                ]);
                            ?>
                        </li>
                        <li>
                            <?php
                                echo __("website/account/affiliate-tx8",[
                                    '{gateways}' => implode(", ",$gateways),
                                ]);
                            ?>
                        </li>
                        <li><?php echo __("website/account/affiliate-tx9"); ?></li>
                    </ul>

                    <?php if(Config::get("options/affiliate/show-p-commission-rates")): ?>
                        <div class="commission-rates">

                            <div class="commission-rates-block">
                                <div class="padding20">
                                    <h5><strong><?php echo __("website/account/affiliate-tx11"); ?></strong></h5>
                                    <h5 style="margin-top:15px;"><?php echo __("website/account/affiliate-tx12",['{rate}' => $c_rate]); ?></h5>
                                    <?php if($product_commissions): ?>
                                        <p><?php echo __("website/account/affiliate-tx13"); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <?php if($product_commissions): ?>
                                <div class="commission-rates-block">
                                    <div class="padding20">
                                        <h5><strong><?php echo __("website/account/affiliate-tx14"); ?></strong></h5>
                                        <div id="commission-rates-select">
                                            <select onchange="show_product_commission();" id="select-product" class="select2">
                                                <?php
                                                    foreach($product_commissions AS $cat)
                                                    {
                                                        ?>
                                                        <optgroup label="<?php echo $cat["name"]; ?>">
                                                            <?php
                                                                foreach($cat['products'] AS $product)
                                                                {
                                                                    ?>
                                                                    <option data-rate="<?php echo $product["affiliate_rate"]; ?>"><?php echo $product['title']; ?></option>
                                                                    <?php
                                                                }
                                                            ?>
                                                        </optgroup>
                                                        <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <script type="text/javascript">
                                            $(document).ready(function(){
                                                $(".select2").select2({width:'100%'});
                                                show_product_commission();
                                            });
                                            function show_product_commission(){
                                                var el      = $("#select-product");
                                                el          = $("option:selected",el);
                                                var text    = '<?php echo __("website/account/affiliate-tx16"); ?>';
                                                text        = text.replace("{name}",el.val());
                                                text        = text.replace("{rate}",el.data("rate"));

                                                $("#show_product_commission").html(text);

                                            }
                                        </script>

                                        <h4 id="show_product_commission">?</h4>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php
                        if(!$aff){
                            ?>
                            <div align="center">
                                <a href="<?php echo $links["activate"]; ?>" class="yesilbtn gonderbtn"><?php echo __("website/account/affiliate-tx10"); ?></a>
                            </div>
                            <?php
                        }
                    ?>

                </div>
            </div>
            <?php
        }
    ?>


    <div class="clear"></div>
</div>