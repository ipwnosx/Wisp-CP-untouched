<div align="center">
    <?php
        $module->get_iframe($links["successful-page"],$links["failed-page"]);
    ?>
    <?php if(isset($links["back"])){ ?>
        <div class="clear"></div>
        <a class="lbtn" href="<?php echo $links["back"]; ?>"><i class="fa fa-angle-double-left" aria-hidden="true"></i> <?php echo $_LANG["turn-back"]; ?></a>
        <div class="clear"></div>
    <?php } ?>
</div>
<br>