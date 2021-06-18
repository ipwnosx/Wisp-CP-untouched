<?php
    $processing    = $module->processing();

    if(isset($processing["show_pay_by_subscription"]) && $processing["show_pay_by_subscription"])
    {
        ?>
        <div id="PayOptions" style="text-align: center;margin: 55px 0px;">

            <h5 style="margin-bottom: 25px;font-weight: 600;"><?php echo $module->lang["pay-info1"]; ?></h5>


            <?php
                if(isset($module->config["settings"]["force_subscription"]) && $module->config["settings"]["force_subscription"])
                {
                    ?>
                    <script type="text/javascript">
                        $(document).ready(function(){
                            PayPalRedirect('subscription');
                        });
                    </script>
                    <?php
                }
                else
                {
                    ?>
                    <a class="paypalbtn" href="javascript:void 0;" onclick="PayPalRedirect('normal');"><img src="<?php echo $module->url; ?>images/paypal-checkout.svg" alt="<?php echo $module->lang["pay-with-normal"]; ?>" title="<?php echo $module->lang["pay-with-normal"]; ?>"></a>
                    <?php
                }
            ?>

            <div class="clear"></div>
            <a class="paypalbtn" href="javascript:void 0;" onclick="PayPalRedirect('subscription');"><img title="<?php echo $module->lang["pay-with-subscription"]; ?>" alt="<?php echo $module->lang["pay-with-subscription"]; ?>" src="<?php echo $module->url; ?>images/paypal-subscribe.svg"></a>
            <div class="clear"></div>
            <img src="<?php echo $module->url; ?>images/paypal-accept-methods.svg" style="width:250px;margin-top:50px;">

        </div>

        <style>
            .paypalbtn {
                margin-top: 10px;
                display: inline-block;
                opacity: .8;
            }
            .paypalbtn:hover {opacity:1;}
        </style>
        <script type="text/javascript">
            function PayPalRedirect(type)
            {
                $("#PayOptions").css("display","none");

                $("#RedirectWrap").css("display","block");

                if(type === 'subscription')
                {
                    window.location.href = '<?php echo $module->links["subscription"]; ?>';
                }
                else if(type === 'normal')
                {
                    setTimeout(function(){
                        $("#PayPalRedirect").submit();
                    },2000);
                }
            }
        </script>
        <?php
    }
    else
    {
        ?>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#RedirectWrap").css("display","block");

                setTimeout(function(){
                    $("#PayPalRedirect").submit();
                },2000);

            });
        </script>
        <?php
    }

    ?>
    <form action="https://<?php echo isset($module->config["settings"]["sandbox"]) && $module->config["settings"]["sandbox"] ? 'sandbox' : 'www'; ?>.paypal.com/cgi-bin/webscr" method="POST" id="PayPalRedirect">
        <input type="hidden" name="cmd" value="_xclick">
        <input type="hidden" name="business" value="<?php echo $module->config["settings"]["email"]; ?>">
        <input type="hidden" name="item_number" value="<?php echo $checkout["id"]; ?>">
        <input type="hidden" name="return" value="<?php echo $links["successful-page"]; ?>">
        <input type="hidden" name="cancel_return" value="<?php echo $links["failed-page"]; ?>">
        <input type="hidden" name="amount" value="<?php echo number_format($processing["amount"], 2, '.', ''); ?>">
        <input type="hidden" name="currency_code" value="<?php echo $processing["currency"]; ?>">
        <input type="hidden" name="item_name" value="Checkout <?php echo $checkout["id"]; ?>">
    </form>


    <div align="center" style="display: none;" id="RedirectWrap">
        <div class="progresspayment">

            <div class="lds-ring"><div></div><div></div><div></div><div></div></div>

            <br><h3 id="progressh3"><?php echo $module->lang["redirect-message"]; ?></h3>
            <h4>
                <div class='angrytext'>
                    <strong><?php echo __("website/others/loader-text2"); ?></strong>
                </div>
            </h4>

        </div>
    </div>