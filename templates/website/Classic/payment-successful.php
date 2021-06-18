<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    $hoptions = [
        'page' => "payment-successful",
        'aos',
    ];
?>
<style type="text/css">
    .header {
        z-index:99;
    }
</style>
<div align="center">
    <div class="progresspayment" style="    padding: 0px;       margin-bottom: 100px;">
        <div data-aos="zoom-in-up" style="width: 100px; height: 50px; display: block; margin-left: auto; margin-right: auto;    margin-bottom: 25px;">
            <img src="<?php echo $tadress;?>/images/green.png" width="100"/>
        </div>
        <br><h3><?php echo __("website/payment/success-text1"); ?></h3>
        <h4><?php echo __("website/payment/success-text2"); ?></h4>
        <a href="<?php echo $links["products"]; ?>" class="lbtn"><?php echo __("website/payment/success-button1"); ?></a>
    </div>
</div>