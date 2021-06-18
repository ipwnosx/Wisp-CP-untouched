<div align="center">
    <div class="progresspayment">
        <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
        <br><h3 id="progressh3" style="font-weight:bold;"><?php echo __("website/others/loader-text1"); ?></h3>
        <h4><?php echo __("website/others/loader-text3"); ?><div class='angrytext'><strong><?php echo __("website/others/loader-text2"); ?></strong></div></h4>

    </div>
</div>

<script type="text/javascript">
    setTimeout(function(){
        window.location.href = "<?php echo $links["callback"]; ?>";
    });
</script>