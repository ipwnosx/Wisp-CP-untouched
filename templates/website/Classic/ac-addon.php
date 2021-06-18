<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    $hoptions = ["datatables","iziModal"];
?>
<div class="mpanelrightcon">

    <div class="mpaneltitle">
        <div class="sayfayolu"><?php include $tpath."inc".DS."panel-breadcrumb.php"; ?></div>
        <h4><strong><i class="fa fa-star" aria-hidden="true"></i> <?php echo $header_title; ?></strong></h4>
    </div>

    <br>

    <?php echo $module_content; ?>


    <div class="clear"></div>
</div>