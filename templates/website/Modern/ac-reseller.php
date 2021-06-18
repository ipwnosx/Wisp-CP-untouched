<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
$wide_content   = true;
$hoptions = ["datatables","iziModal","select2"];
?>
<div class="mpanelrightcon">

    <div class="mpaneltitle">
        <div class="sayfayolu"><?php include $tpath."inc".DS."panel-breadcrumb.php"; ?></div>
        <h4><strong><i class="ion-ribbon-b" aria-hidden="true"></i> <?php echo $header_title; ?></strong></h4>
        <?php
        if($status && $rates_conditions)
        {
            ?>
            <a id="affiliate-paym-info" href="<?php echo $links["controller"]; ?>"><i class="fa fa-angle-double-left" aria-hidden="true"></i> <?php echo __("website/account/reseller-tx21"); ?></a>
            <?php
        }
        elseif($status)
        {
            ?>
            <div class="clearmob"></div>
            <a id="affiliate-paym-info" href="<?php echo $links["rates-conditions"]; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i> <?php echo __("website/account/reseller-tx20"); ?></a>

            <?php
            if(Config::get("options/dealership/api"))
            {
                ?>
                <a id="affiliate-paym-info" href="javascript:void 0;" onclick="open_modal('api_access');"><i class="fa fa-code" aria-hidden="true"></i> <?php echo __("website/account/reseller-tx35"); ?></a>
                <?php
            }
            ?>
            <?php
        }
        ?>
    </div>

    <br>

    <?php
    if($status && !$rates_conditions)
    {
        if(Config::get("options/dealership/api"))
        {
            ?>
            <div id="api_access" style="display: none;" data-izimodal-title="<?php echo __("website/account/reseller-tx35"); ?>">
                <div class="padding20">

                    <div class="green-info">
                        <div class="padding20">
                            <i class="fa fa-info-circle"></i>
                            <?php echo __("website/account/reseller-tx36"); ?>
                        </div>
                    </div>

                    <div class="refererurl">
                        <h4><?php echo __("website/account/reseller-tx37"); ?></h4>
                        <h2><?php echo $api_url; ?></h2>
                    </div>

                    <div class="refererurl">
                        <h4><?php echo __("website/account/reseller-tx38"); ?></h4>
                        <h2><?php echo $api_key; ?></h2>
                    </div>

                    <div class="refererurl">
                        <h4><?php echo __("website/account/reseller-tx39"); ?></h4>
                        <h2><a href="<?php echo Models::$init->link_detector("kbase"); ?>" target="_blank"><i class="fa fa-book"></i> <?php echo __("website/account/reseller-tx40"); ?></a></h2>
                    </div>


                </div>
            </div>
            <?php
        }
        ?>

        <div class="reseller-client-con">

            <div class="dashboardboxs">

                <div class="dashboardbox" id="turuncublok">
                    <div class="padding10">
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                        <h2><?php echo Money::formatter_symbol($statistics["turnover_today"],$statistics["currency"],true); ?>
                        </h2>
                        <h4><?php echo __("website/account/reseller-tx22"); ?></h4>
                        <div class="ablokbottom"><span><?php echo __("website/account/reseller-tx23"); ?> <strong><?php echo Money::formatter_symbol($statistics["turnover"],$statistics["currency"],true); ?></strong></span></div>
                    </div>
                </div>

                <div class="dashboardbox" id="redblok">
                    <div class="padding10">
                        <i class="ion-bag" style="line-height: 105px;" aria-hidden="true"></i>
                        <h2><?php echo $statistics["total_sales_today"]; ?></h2>
                        <h4><?php echo __("website/account/reseller-tx24"); ?></h4>
                        <div class="ablokbottom"><span><?php echo __("website/account/reseller-tx25"); ?> <strong><?php echo $statistics["total_sales"]; ?></strong></span></div>
                    </div>
                </div>

                <div class="dashboardbox" id="yesilblok">
                    <div class="padding10">
                        <i class="ion-happy-outline" style="line-height: 105px;" aria-hidden="true"></i>
                        <h2><?php echo Money::formatter_symbol($statistics["discounts_today"],$statistics["currency"],true); ?></h2>
                        <h4><?php echo __("website/account/reseller-tx26"); ?></h4>
                        <div class="ablokbottom"><span><?php echo __("website/account/reseller-tx27"); ?> <strong><?php echo Money::formatter_symbol($statistics["discounts"],$statistics["currency"],true); ?></strong></span></div>
                    </div>
                </div>
            </div>

            <div class="clear"></div>
            <ul class="tab">
                <li><a href="javascript:void 0;" class="tablinks active"><strong><?php echo __("website/account/reseller-tx34"); ?></strong></a></li>
            </ul>
            <div class="clear"></div>
            <script type="text/javascript">
                $(document).ready(function(){
                    $('#table_sales').DataTable({
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

            <table width="100%" border="0" cellpadding="0" cellspacing="0" id="table_sales">
                <thead style="background:#ebebeb;">
                <tr>
                    <th align="center">#</th>
                    <th align="center" data-orderable="false"><?php echo __("website/account/reseller-tx28"); ?></th>
                    <th align="center" data-orderable="false"><?php echo __("website/account/reseller-tx29"); ?></th>
                    <th align="center" data-orderable="false"><?php echo __("website/account/reseller-tx30"); ?></th>
                    <th align="center" data-orderable="false"><?php echo __("website/account/reseller-tx31"); ?></th>
                    <th align="center" data-orderable="false"><?php echo __("website/account/reseller-tx32"); ?></th>
                    <th align="center" data-orderable="false"><?php echo __("website/account/reseller-tx33"); ?></th>
                    <th align="center" data-orderable="false"></th>
                </tr>
                </thead>
                <tbody>
                <?php
                if(isset($statistics['orders']) && $statistics['orders'])
                {
                    $i = 0;
                    foreach($statistics['orders'] AS $row)
                    {
                        $i++;
                        $amount         = Money::formatter_symbol($row["amount"],$row["amount_cid"]);
                        $discount       = $row["discount"];
                        $link           = Controllers::$init->CRLink("ac-ps-product",[$row["id"]]);
                        ?>
                        <tr>
                            <td align="center"><?php echo $i; ?></td>
                            <td align="center">#<?php echo $row["id"]; ?></td>
                            <td align="center">
                                <strong><?php echo $row["name"]; ?></strong>
                                <?php echo $row["type"] != "domain" && isset($row["options"]["domain"]) ? "<br>".$row["options"]["domain"] : ''; ?>
                                <?php
                                if($row["type"] == "sms"){
                                    echo "<br>".$row["options"]["name"]; ?> - <?php echo $row["options"]["identity"];
                                }elseif($row["type"] == "special"){
                                    if(isset($row["options"]["domain"]) && $row["options"]["domain"])
                                        echo " - ";
                                    else
                                        echo "<br>";

                                    if(isset($row["options"]["category_name"]) && $row["options"]["category_name"])
                                        echo $row["options"]["category_name"];
                                    else
                                        echo $row["options"]["group_name"];
                                }
                                ?>

                                <?php if(isset($row["options"]["hostname"]) && $row["options"]["hostname"]): ?>
                                    <?php echo "<br>".$row["options"]["hostname"]; ?>

                                    <?php if(isset($row["options"]["ip"]) && $row["options"]["ip"]): ?>
                                        - <?php echo $row["options"]["ip"]; ?>
                                    <?php endif; ?>

                                <?php elseif(isset($row["options"]["ip"]) && $row["options"]["ip"]): ?>
                                    <?php echo "<br>".$row["options"]["ip"]; ?>
                                <?php endif; ?>

                            </td>
                            <td align="center"><?php echo $amount; ?></td>
                            <td align="center">
                                <?php
                                if($discount)
                                {
                                    ?>
                                    <strong><?php echo Money::formatter_symbol($discount["amountd"],$row["inv_curr"],$row["amount_cid"]); ?></strong> (%<?php echo $discount["rate"]; ?>)
                                    <?php
                                }
                                ?>
                            </td>
                            <td align="center">
                                <?php
                                if($row["period"] == "none")
                                    echo ___("date/period-none");
                                else
                                    echo DateManager::format(Config::get("options/date-format")." H:i",$row["duedate"]);
                                ?>
                            </td>
                            <td align="center"><?php echo $situations[$row["status"]]; ?></td>
                            <td align="center">
                                <?php
                                if(isset($row["options"]["block_access"])){

                                }
                                elseif($row["status"] == "waiting" || $row["status"] == "inprocess" || $row["status"] == "cancelled"){
                                    ?>
                                    <a title="<?php echo __("website/account_products/manage"); ?>" style="-webkit-filter:grayscale(100%);filter: grayscale(100%);color: #777;opacity: 0.5;filter: alpha(opacity=50);" class="incelebtn"><i class="fa fa-cog" aria-hidden="true"></i> <?php echo __("website/account_products/manage"); ?></a>
                                    <?php
                                }
                                else{
                                    ?>
                                    <a href="<?php echo $link; ?>" title="<?php echo __("website/account_products/manage"); ?>" class="incelebtn"><i class="fa fa-cog" aria-hidden="true"></i> <?php echo __("website/account_products/manage"); ?></a>
                                    <?php
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
        <?php
    }
    else
    {
        ?>
        <div class="affiliate-getstarted" id="reseller-getstarted">

            <div class="green-info" style="margin-bottom:25px;">
                <div class="padding20">
                    <i class="ion-ribbon-b" aria-hidden="true"></i>
                    <p><strong><?php echo __("website/account/reseller-tx1"); ?></strong><br><?php echo __("website/account/reseller-tx2"); ?></p>
                </div>
            </div>


            <h5><strong><?php echo __("website/account/reseller-tx3"); ?></strong></h5>
            <ul>

                <li><?php echo __("website/account/reseller-tx4"); ?></li>
                <li><?php echo __("website/account/reseller-tx5"); ?></li>
                <li><?php echo __("website/account/reseller-tx6"); ?></li>
                <?php

                if(Config::get("options/dealership/api"))
                {
                    ?>
                    <li><?php echo __("website/account/reseller-tx7"); ?></li>
                    <?php
                }

                if(isset($require_min_credit_amount) && $require_min_credit_amount)
                {
                    ?>
                    <li><?php echo __("website/account/reseller-tx8",['{amount}' => $require_min_credit_amount]); ?></li>
                    <?php
                }

                if(isset($require_min_discount_amount) && $require_min_discount_amount)
                {
                    ?>
                    <li><?php echo __("website/account/reseller-tx9",['{amount}' => $require_min_discount_amount]); ?></li>
                    <?php
                }

                if(isset($info["only_credit_paid"]) && $info["only_credit_paid"])
                {
                    ?>
                    <li><?php echo __("website/account/reseller-tx10"); ?></li>
                    <?php
                }
                ?>
                <li><?php echo __("website/account/reseller-tx11"); ?></li>
            </ul>

            <?php
            if(isset($rates) && $rates)
            {
                ?>
                <div class="commission-rates">

                    <?php
                    if(isset($rates['default']) && $rates["default"])
                    {
                        $_rates = $rates["default"];
                        unset($rates["default"]);
                        if(!is_array(current($rates))) $rates = [];
                        ?>
                        <div class="commission-rates-block">
                            <div class="padding20">
                                <h5><strong><?php echo __("website/account/reseller-tx13"); ?></strong></h5>
                                <h5 style="margin-top:15px;"><?php echo __("website/account/reseller-tx14"); ?></h5>
                                <?php
                                if($rates)
                                {
                                    ?>
                                    <p><?php echo __("website/account/reseller-tx15"); ?></p>
                                    <?php
                                }
                                ?>

                                <table class="resellerdiscounts" width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th colspan="3" bgcolor="#eee"><?php echo __("website/account/reseller-tx16"); ?></th>
                                        <th bgcolor="#eee"></th>
                                        <th bgcolor="#eee"><?php echo __("website/account/reseller-tx17"); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach($_rates AS $row)
                                    {
                                        $_rate      = $row["rate"];
                                        $r_s        = explode(".",$_rate);
                                        if(isset($r_s[1]) && $r_s[1] < 01) $_rate = $r_s[0];
                                        ?>
                                        <tr>
                                            <td align="center"><?php echo $row["from"]; ?></td>
                                            <td align="center">
                                                <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                                            </td>
                                            <td align="center"><?php echo $row["to"]; ?></td>
                                            <td align="center">
                                                <?php echo __("website/account/reseller-tx18"); ?>        </td>
                                            <td align="center"><strong>%<?php echo $_rate; ?></strong></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                        <?php
                    }

                    if($rates && isset($products) && $products)
                    {
                        ?>
                        <div class="commission-rates-block">
                            <div class="padding20">
                                <h5><strong><?php echo __("website/account/reseller-tx19"); ?></strong></h5>
                                <div id="commission-rates-select">
                                    <script type="text/javascript">
                                        $(document).ready(function(){
                                            $(".select2").select2({width:'100%'});
                                            show_product_commission();
                                        });
                                        function show_product_commission(){
                                            var selected = $("#select-product").val();

                                            $(".table-rates").css("display","none");
                                            $("table[data-key='"+selected+"']").css("display","table");

                                        }
                                    </script>
                                    <select onchange="show_product_commission();" id="select-product" class="select2">
                                        <?php
                                        $items = [];
                                        foreach($products AS $g_k => $g)
                                        {
                                            $gk             = '';
                                            $gk_split       = explode("-",$g_k);

                                            if(Validation::isInt($gk_split[0]) && $gk_split[1] == 0)
                                                $gk = "special/".$gk_split[0];
                                            elseif(Validation::isInt($gk_split[0]))
                                                $gk = "special/".$gk_split[1];
                                            elseif($gk_split[1] == 0)
                                                $gk = $gk_split[0];
                                            else
                                                $gk = $gk_split[0]."/".$gk_split[1];
                                            if(!isset($items[$gk]) && isset($rates[$gk]) && is_array($rates[$gk]))
                                                $items[$gk] = $rates[$gk];
                                            $prefix_name = $g["name"]." --> ";
                                            if(isset($rates[$gk]) && is_array($rates[$gk]))
                                            {
                                                ?>
                                                <option value="<?php echo $gk; ?>"><?php echo $g['name']; ?></option>
                                                <?php
                                            }

                                            $_products      = $g["products"];

                                            if($_products)
                                            {
                                                foreach($_products AS $_p)
                                                {
                                                    $pk         = $_p['type']."-".$_p["id"];
                                                    if(!isset($items[$pk]) && isset($rates[$pk]) && is_array($rates[$pk]))
                                                        $items[$pk] = $rates[$pk];
                                                    if(isset($rates[$pk]) && is_array($rates[$pk]))
                                                    {
                                                        ?>
                                                        <option value="<?php echo $pk; ?>"><?php echo $prefix_name.$_p["title"]; ?></option>
                                                        <?php
                                                    }
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                                <?php
                                if($items)
                                {
                                    foreach($items AS $k => $rows)
                                    {
                                        if(!is_array($rows)) continue;
                                        ?>
                                        <table class="resellerdiscounts table-rates" data-key="<?php echo $k ?>" width="100%" border="0" cellpadding="0" cellspacing="0" style="display: none;">
                                            <thead>
                                            <tr>
                                                <th colspan="3" bgcolor="#eee"><?php echo __("website/account/reseller-tx16"); ?></th>
                                                <th bgcolor="#eee"></th>
                                                <th bgcolor="#eee"><?php echo __("website/account/reseller-tx17"); ?></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach($rows AS $row)
                                            {
                                                $_rate = $row["rate"];
                                                $r_s   = explode(".",$_rate);
                                                if(isset($r_s[1]) && $r_s[1] < 01) $_rate = $r_s[0];
                                                ?>
                                                <tr>
                                                    <td align="center"><?php echo $row["from"]; ?></td>
                                                    <td align="center">
                                                        <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                                                    </td>
                                                    <td align="center"><?php echo $row["to"]; ?></td>
                                                    <td align="center">
                                                        <?php echo __("website/account/reseller-tx18"); ?>        </td>
                                                    <td align="center"><strong>%<?php echo $_rate; ?></strong></td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <?php

                    }
                    ?>
                </div>
                <?php
            }
            ?>

            <?php
            if(!$status && !$rates_conditions)
            {
                ?>
                <div align="center">
                    <a href="<?php echo $contact_link; ?>" class="yesilbtn gonderbtn"><?php echo __("website/account/reseller-tx12"); ?></a>
                </div>
                <?php
            }
            ?>

        </div>
        <?php
    }
    ?>
    <div class="clear"></div>
</div>