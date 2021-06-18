<div align="center">
    <div class="progresspayment">
        <div style="width: 100px; height: 50px; display: block; margin-left: auto; margin-right: auto;    margin-bottom: 20px;">
            <div data-aos="zoom-in-up" class="cssload-hourglass"></div>
        </div>
        <br><h3 id="progressh3" style="font-weight:bold;"><?php echo $module->lang["redirect-message"]; ?></h3>
        <h4>
            <div class='angrytext'>
                <strong><?php echo __("website/others/loader-text2"); ?></strong>
            </div>
        </h4>

    </div>
</div>

<script type="text/javascript">
    setTimeout(function(){
        $("#SkrillRedirect").submit();
    },2000);
</script>
<form action="https://pay.skrill.com" method="post" id="SkrillRedirect">
    <?php
        $fields = $module->get_fields($links["successful-page"],$links["failed-page"]);
        if($fields){
            foreach($fields AS $k=>$v){
                ?>
                <input type="hidden" name="<?php echo $k; ?>" value="<?php echo htmlspecialchars($v); ?>">
                <?php
            }
        }
    ?>
</form>