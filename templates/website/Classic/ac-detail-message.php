<?php 
    defined('CORE_FOLDER') OR exit('You can not get in here!');
    $hoptions = ["datatables"];
?>
<div class="mpanelrightcon">

    <div class="mpaneltitle">
        <div class="sayfayolu"><?php include $tpath."inc".DS."panel-breadcrumb.php"; ?></div>
        <h4><strong><i class="fa fa-envelope-o"></i> <?php echo $header_title; ?></strong></h4>
    </div>



    <?php echo $message["content"]; ?>
    <hr>
    <?php echo __("website/account_messages/time-to-send"); ?>: <?php echo $message["date"]; ?><br>
    <?php echo __("website/account_messages/sent-email"); ?>: <?php echo $message["addresses"]; ?>

    <div class="clear"></div>
</div>