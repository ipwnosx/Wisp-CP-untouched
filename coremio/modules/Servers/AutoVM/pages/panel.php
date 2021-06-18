<?php
    $order          = $module->order;
    $product        = $module->product;
    $LANG           = $module->lang;
    $login          = $module->member_login();

    if($login){
        ?>
        <iframe src="<?php echo $login; ?>" style="border:none;width:100%;height:650px;overflow:auto;"></iframe>
        <?php
    }