<!DOCTYPE html>
<html>
<head>
    <?php
        $plugins        = ['dataTables','jquery-ui'];
        include __DIR__.DS."inc".DS."head.php";
    ?>
</head>
<body>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1>
                    <strong><?php echo __("admin/products/page-api"); ?></strong>
                </h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div id="prodcut_api_list">

                <div class="addonlist" id="group_ssl">
                    <div class="addonimage">
                        <img height="75" width="150" src="<?php echo $tadress; ?>images/product-ssl.svg"/>
                    </div>
                    <div class="addoninfo">
                        <h4 class="addon-name"><?php echo __("admin/products/api-manage-group-ssl"); ?></h4>
                        <p><?php echo __("admin/products/api-manage-group-ssl-desc"); ?></p>
                    </div>
                    <div class="addoncontrol">
                        <a href="<?php echo $links["group-ssl"]; ?>" class="lbtn"><i class="fa fa-cog" aria-hidden="true"></i> <?php echo ___("needs/manage"); ?></a>
                    </div>
                </div>

                <div class="addonlist" id="group_software_license">
                    <div class="addonimage">
                        <img height="75" width="150" src="<?php echo $tadress; ?>images/product-license.svg"/>
                    </div>
                    <div class="addoninfo">
                        <h4 class="addon-name"><?php echo __("admin/products/api-manage-group-license"); ?></h4>
                        <p><?php echo __("admin/products/api-manage-group-license-desc"); ?></p>
                    </div>
                    <div class="addoncontrol">
                        <a href="<?php echo $links["group-license"]; ?>" class="lbtn"><i class="fa fa-cog" aria-hidden="true"></i> <?php echo ___("needs/manage"); ?></a>
                    </div>
                </div>

                <div class="addonlist" id="group_other">
                    <div class="addonimage">
                        <img height="75" width="150" src="<?php echo $tadress; ?>images/product-other.svg"/>
                    </div>
                    <div class="addoninfo">
                        <h4 class="addon-name"><?php echo __("admin/products/api-manage-group-other"); ?></h4>
                        <p><?php echo __("admin/products/api-manage-group-other-desc"); ?></p>
                    </div>
                    <div class="addoncontrol">
                        <a href="<?php echo $links["group-other"]; ?>" class="lbtn"><i class="fa fa-cog" aria-hidden="true"></i> <?php echo ___("needs/manage"); ?></a>
                    </div>
                </div>

            </div>



        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>