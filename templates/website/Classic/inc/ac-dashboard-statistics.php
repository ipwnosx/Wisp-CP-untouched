<?php defined('CORE_FOLDER') OR exit('You can not get in here!'); ?><div class="muspanelbloks">

    <div class="mpanelblok" id="green">
            <a href="<?php echo $acsidebar_links["menu-2"]; ?>"><div class="mpanelblokicon"><i class="fa fa-rocket"></i></div>
            <h1><?php echo $statistic1; ?></h1>
            <h2><?php echo __("website/account/statistic-1-name"); ?></h2>
            <div class="mblokbtn"><div class="padding10"><?php echo __("website/account/statistic-1-link"); ?></div></div>
        </a></div>

    <?php if($pg_activation["domain"]): ?>
        <div class="mpanelblok" id="blue">
                <a href="<?php echo $acsidebar_links["menu-3"]; ?>">
                <div class="mpanelblokicon"><i class="fa fa-globe"></i></div>
                <h1><?php echo $statistic2; ?></h1>
                <h2><?php echo __("website/account/statistic-2-name"); ?></h2>
                <div class="mblokbtn"><div class="padding10"><?php echo __("website/account/statistic-2-link"); ?></div></div>
                </a></div>
    <?php endif; ?>

    <?php if($visibility_invoice): ?>
        <div class="mpanelblok" id="red">
            <a href="<?php echo $acsidebar_links["menu-4"]; ?>">
                <div class="mpanelblokicon"><i class="fa fa-file-text-o" aria-hidden="true"></i></div>
                <h1><?php echo $statistic3; ?></h1>
                <h2><?php echo __("website/account/statistic-3-name"); ?></h2>
                <div class="mblokbtn"><div class="padding10"><?php echo __("website/account/statistic-3-link"); ?></div></div>
            </a></div>
    <?php endif; ?>

    <?php if($visibility_ticket): ?>
        <div class="mpanelblok" id="gray">
            
                <div class="mpanelblokicon"><i class="fa fa-life-ring"></i></div>
               <a href="<?php echo $acsidebar_links["menu-1"]; ?>"> <h1><?php echo $statistic4; ?></h1>
                <h2><?php echo __("website/account/statistic-4-name"); ?></h2></a>
               <a href="<?php echo $links["create-ticket-request"]; ?>"> <div class="mblokbtn"><div class="padding10"><?php echo __("website/account/statistic-4-link"); ?></div></div></a>
            </div>
    <?php endif; ?>
</div>