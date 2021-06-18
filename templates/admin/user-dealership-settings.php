<!DOCTYPE html>
<html>
<head>
    <?php
        $local_l            = Config::get("general/local");

        $plugins            = ['dataTables','select2','tinymce-1'];
        Utility::sksort($lang_list,'local');
        include __DIR__.DS."inc".DS."head.php";
    ?>
</head>
<body>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1>
                    <strong><?php echo __("admin/users/page-dealership-settings");?></strong>
                </h1>

                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="adminpagecon">


                <div class="clear"></div>

                <script type="text/javascript">
                    $(document).ready(function(){
                        $("#DealershipSettingsForm_submit").on("click",function(){
                            MioAjaxElement($(this),{
                                waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                                progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                                result:"DealershipSettingsForm_handler",
                            });
                        });

                        var selected = $("#selectProductItem").val();
                        if($("tbody[data-key='"+selected+"'] tr").length < 1) add_new_rate();

                        $("#selectProductItem").change(function(){
                            var selected = $(this).val();

                            $(".tbody-rates").css("display","none");
                            $("tbody[data-key='"+selected+"']").css("display","table-row-group");

                            if($("tbody[data-key='"+selected+"'] tr").length < 1) add_new_rate();
                        });

                        $(".rates-from-el").change(function(){
                            var val = parseInt($(this).val());
                            if($("#activation-auto").prop('checked') && (isNaN(val) || val < 2))
                            {
                                $(this).val('2');
                                alert("<?php echo __("admin/users/dealership-warning1"); ?>");
                            }
                        });


                    });

                    function DealershipSettingsForm_handler(result){
                        if(result !== ''){
                            var solve = getJson(result);
                            if(solve !== false){
                                if(solve.status == "error"){
                                    if(solve.for != undefined && solve.for != ''){
                                        $("#DealershipSettingsForm "+solve.for).focus();
                                        $("#DealershipSettingsForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                        $("#DealershipSettingsForm "+solve.for).change(function(){
                                            $(this).removeAttr("style");
                                        });
                                    }
                                    if(solve.message != undefined && solve.message != '')
                                        alert_error(solve.message,{timer:5000});
                                }else if(solve.status == "successful"){
                                    alert_success(solve.message,{timer:2000});
                                    if(solve.redirect != undefined && solve.redirect != ''){
                                        setTimeout(function(){
                                            window.location.href = solve.redirect;
                                        },2000);
                                    }
                                }
                            }else
                                console.log(result);
                        }
                    }

                    function add_new_rate(){
                        var selected    = $("#selectProductItem").val();
                        var template    = $("#template-rate-item").html();
                        template = template.replace(/\[x\]/g,"["+selected+"]");
                        $("tbody[data-key='"+selected+"']").append(template);
                    }

                </script>

                <table style="display: none">
                    <tbody id="template-rate-item">
                    <tr>
                        <td align="center">
                            <input type="text" name="rates[x][from][]" value="" onkeypress='return event.charCode>= 48 &&event.charCode<= 57'>
                        </td>
                        <td align="center">
                            <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                        </td>
                        <td align="center">
                            <input type="text" name="rates[x][to][]" value="" onkeypress='return event.charCode>= 48 &&event.charCode<= 57'>
                        </td>
                        <td align="center">
                            <?php echo __("admin/users/dealership-discount-between"); ?>
                        </td>
                        <td align="center">
                            <input type="text" name="rates[x][rate][]" value="" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57'>
                        </td>
                        <td align="center">
                            <a class="sbtn red" onclick="$(this).parent().parent().remove();">
                                <i class="fa fa-times"></i>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <form action="<?php echo $links["controller"]; ?>" method="post" id="DealershipSettingsForm">
                    <input type="hidden" name="operation" value="update_dealership_settings">


                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/users/dealership-status"); ?></div>
                        <div class="yuzde70">
                            <input<?php echo Config::get("options/dealership/status") ? ' checked' : ''; ?> type="checkbox" name="status" value="1" id="dealership-status" class="sitemio-checkbox">
                            <label for="dealership-status" class="sitemio-checkbox-label"></label>
                            <span class="kinfo"><?php echo __("admin/users/dealership-status-desc"); ?></span>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/users/dealership-activation"); ?></div>
                        <div class="yuzde70">

                            <input<?php echo Config::get("options/dealership/activation") == 'manuel' ? ' checked' : ''; ?> type="radio" name="activation" value="manuel" id="activation-manuel" class="radio-custom">
                            <label class="radio-custom-label" for="activation-manuel" style="margin-right: 10px;"><?php echo __("admin/users/dealership-activation-manuel"); ?></label>

                            <input<?php echo Config::get("options/dealership/activation") == 'auto' ? ' checked' : ''; ?> type="radio" name="activation" value="auto" id="activation-auto" class="radio-custom">
                            <label class="radio-custom-label" for="activation-auto" style="margin-right: 10px;"><?php echo __("admin/users/dealership-activation-auto"); ?></label>

                            <div class="clear"></div>
                            <span class="kinfo"><?php echo __("admin/users/dealership-activation-desc"); ?></span>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/users/dealership-view-without-membership"); ?></div>
                        <div class="yuzde70">
                            <input<?php echo Config::get("options/dealership/view-without-membership") ? ' checked' : ''; ?> type="checkbox" name="view-without-membership" value="1" id="dealership-view-without-membership" class="sitemio-checkbox">
                            <label for="dealership-view-without-membership" class="sitemio-checkbox-label"></label>
                            <span class="kinfo"><?php echo __("admin/users/dealership-view-without-membership-desc"); ?></span>
                        </div>
                    </div>


                    <div class="formcon">
                        <div class="yuzde30">
                            <?php echo __("admin/users/dealership-conditions"); ?>
                            <div class="clear"></div>
                            <span class="kinfo"><?php echo __("admin/users/dealership-conditions-desc"); ?></span>
                        </div>
                        <div class="yuzde70">
                            <div class="formcon">
                                <?php
                                    $dp         = Config::get("options/dealership");
                                    $require_min_credit_amount  = isset($dp["require_min_credit_amount"]) && $dp["require_min_credit_amount"] ? Money::formatter($dp["require_min_credit_amount"],$dp["require_min_credit_cid"]) : '';
                                    $require_min_credit_cid  = isset($dp["require_min_credit_cid"]) ? $dp["require_min_credit_cid"] : 0;
                                    $input  = '<input style="width:80px;" name="dp_require_min_credit_amount" type="text" placeholder="'.___("needs/example1").':750" value="'.$require_min_credit_amount.'">';
                                    $input .= '<select name="dp_require_min_credit_cid" style="width:200px;">';
                                    foreach(Money::getCurrencies() AS $row){
                                        $checked = $require_min_credit_cid == $row["id"] ? ' selected' : '';
                                        $input .= '<option'.$checked.' value="'.$row["id"].'">'.$row["name"].' ('.$row["code"].')</option>';
                                    }
                                    $input .= '</select>';

                                    echo __("admin/users/detail-info-dp-cdt-oblign-min-credit",['{input}' => $input]);
                                ?>
                            </div>

                            <div class="formcon">

                                <?php
                                    $require_min_discount_amount  = isset($dp["require_min_discount_amount"]) && $dp["require_min_discount_amount"] ? Money::formatter($dp["require_min_discount_amount"],$dp["require_min_discount_cid"]) : '';
                                    $require_min_discount_cid  = isset($dp["require_min_discount_cid"]) ? $dp["require_min_discount_cid"] : 0;
                                    $input  = '<input style="width:80px;" name="dp_require_min_discount_amount" type="text" placeholder="'.___("needs/example1").':100" value="'.$require_min_discount_amount.'">';
                                    $input .= '<select name="dp_require_min_discount_cid" style="width:200px;">';
                                    foreach(Money::getCurrencies() AS $row){
                                        $checked = $require_min_discount_cid == $row["id"] ? ' selected' : '';
                                        $input .= '<option'.$checked.' value="'.$row["id"].'">'.$row["name"].' ('.$row["code"].')</option>';
                                    }
                                    $input .= '</select>';

                                    echo __("admin/users/detail-info-dp-cdt-oblign-min-discount",['{input}' => $input]);
                                ?>
                            </div>

                            <div class="formcon">
                                <input<?php echo isset($dp["only_credit_paid"]) && $dp["only_credit_paid"] ? ' checked' : ''; ?> id="only_credit_paid" class="checkbox-custom" name="only_credit_paid" value="1" type="checkbox" >
                                <label for="only_credit_paid" class="checkbox-custom-label" style="margin-right: 28px;"><?php echo __("admin/users/detail-info-dp-only-credit-paid"); ?></label>
                            </div>
                        </div>
                    </div>

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/users/dealership-rates"); ?>
                            <div class="clear"></div>
                            <span class="kinfo"><?php echo __("admin/users/dealership-rates-desc"); ?></span>

                        </div>
                        <div class="yuzde70">
                            <?php
                                $items  = Config::get("options/dealership/rates");
                            ?>
                            <select id="selectProductItem">
                                <option value="default"><?php echo __("admin/users/dealership-default"); ?></option>
                                <?php
                                    if(isset($products) && $products)
                                    {
                                        foreach($products AS $g_k => $g)
                                        {
                                            $gk             = '';
                                            $gk_split       = explode("-",$g_k);
                                            $gk_0           = isset($gk_split[0]) ? $gk_split[0] : '';
                                            $gk_1           = isset($gk_split[1]) ? $gk_split[1] : '';

                                            if(Validation::isInt($gk_0) && $gk_1 == 0)
                                                $gk = "special/".$gk_0;
                                            elseif(Validation::isInt($gk_0))
                                                $gk = "special/".$gk_1;
                                            elseif($gk_1 == 0)
                                                $gk = $gk_0;
                                            else
                                                $gk = $gk_0."/".$gk_1;
                                            if(!isset($items[$gk])) $items[$gk] = Config::get("options/dealership/rates/".$gk);
                                            ?>
                                            <option style="font-weight: bold;" value="<?php echo $gk; ?>"><?php echo $g['name']; ?></option>
                                            <?php

                                            $_products      = $g["products"];

                                            if($_products)
                                            {
                                                foreach($_products AS $_p)
                                                {
                                                    $pk         = $_p['type']."-".$_p["id"];
                                                    if(!isset($items[$pk]))
                                                        $items[$pk] = Config::get("options/dealership/rates/".$pk);
                                                    ?>
                                                    <option value="<?php echo $pk; ?>">&nbsp;&nbsp;<?php echo $_p["title"]; ?></option>
                                                    <?php
                                                }
                                            }
                                        }
                                    }
                                ?>
                            </select>

                            <table class="resellerdiscounts" width="100%" border="0" cellpadding="0" cellspacing="0">
                                <thead>
                                <tr>
                                    <th colspan="3" bgcolor="#eee"><?php echo __("admin/users/dealership-order-quantity"); ?></th>
                                    <th bgcolor="#eee"> </th>
                                    <th bgcolor="#eee"><?php echo __("admin/users/dealership-discount-rate"); ?></th>
                                    <th bgcolor="#eee"></th>
                                </tr>
                                </thead>
                                <?php
                                    foreach($items AS $k=>$rates)
                                    {
                                        ?>
                                        <tbody class="tbody-rates" data-key="<?php echo $k; ?>" style="<?php echo $k == 'default' ? '' : 'display:none;'; ?>">
                                        <?php
                                            if($rates)
                                            {
                                                foreach($rates AS $row)
                                                {
                                                    ?>
                                                    <tr>
                                                        <td align="center">
                                                            <input type="text" name="rates[<?php echo $k; ?>][from][]" value="<?php echo $row["from"]; ?>" onkeypress='return event.charCode>= 48 &&event.charCode<= 57' class="rates-from-el">
                                                        </td>
                                                        <td align="center">
                                                            <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                                                        </td>
                                                        <td align="center">
                                                            <input type="text" name="rates[<?php echo $k; ?>][to][]" value="<?php echo $row["to"]; ?>" onkeypress='return event.charCode>= 48 &&event.charCode<= 57'>
                                                        </td>
                                                        <td align="center">
                                                            <?php echo __("admin/users/dealership-discount-between"); ?>
                                                        </td>
                                                        <td align="center">
                                                            <input type="text" name="rates[<?php echo $k; ?>][rate][]" value="<?php echo $row["rate"]; ?>" onkeypress='return event.charCode==44 || event.charCode==46 || event.charCode>= 48 &&event.charCode<= 57'>
                                                        </td>
                                                        <td align="center">
                                                            <a class="sbtn red" onclick="$(this).parent().parent().remove();">
                                                                <i class="fa fa-times"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                        ?>
                                        </tbody>
                                        <?php
                                    }
                                ?>
                                <tbody>
                                <tr>
                                    <td colspan="6"><a class="sbtn" onclick="add_new_rate();"><i class="fa fa-plus"></i></a></td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>



                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("admin/users/dealership-api"); ?></div>
                        <div class="yuzde70">
                            <input<?php echo Config::get("options/dealership/api") ? ' checked' : ''; ?> type="checkbox" name="api" value="1" id="dealership-api" class="sitemio-checkbox">
                            <label for="dealership-api" class="sitemio-checkbox-label"></label>
                            <span class="kinfo"><?php echo __("admin/users/dealership-api-desc"); ?></span>
                        </div>
                    </div>




                    <div class="clear"></div>

                    <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                        <a class="yesilbtn gonderbtn" id="DealershipSettingsForm_submit" href="javascript:void(0);"><?php echo ___("needs/button-update"); ?></a>
                    </div>
                    <div class="clear"></div>


                </form>

            </div>
            <div class="clear"></div>

        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>