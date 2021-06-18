<span><?php echo __("website/account_products/subscription-enabled",['{module}' => '<strong>'.$subscription["module"].'</strong>' ]); ?></span>

<div class="clear"></div>
<a href="javascript:void 0;" class="red sbtn" id="cancel_subscription_btn" onclick="cancel_subscription(this);"><?php echo __("admin/orders/subscription-cancel-btn"); ?></a>


<script type="text/javascript">
    function cancel_subscription(el)
    {
        if(!confirm("<?php echo ___("needs/apply-are-you-sure"); ?>")) return false;
        var request = MioAjax({
            button_element:el,
            waiting_text: "<?php echo __("website/others/button1-pending"); ?>",
            action: "<?php echo $links["controller"]; ?>",
            method: "POST",
            data:{operation: "cancel_subscription"}
        },true,true);
        request.done(function(result){
            var solve = getJson(result);
            if(solve !== undefined && solve !== false)
            {
                if(solve.status === "error")
                    alert_error(solve.message,{timer:4000});
                else if(solve.status === "successful")
                {
                    window.location.href = '<?php echo $links["controller"]; ?>';
                }
            }
        });
    }
</script>
