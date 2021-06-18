<div align="center">
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

<script type="text/javascript">
    setTimeout(function(){
        $("#PerfectMoneyRedirect").submit();
    },2000);
</script>
<form action="https://perfectmoney.is/api/step1.asp" method="post" id="PerfectMoneyRedirect">
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