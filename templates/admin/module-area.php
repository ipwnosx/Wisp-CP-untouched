<!DOCTYPE html>
<html>
<head>
    <?php
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
                    <strong><?php echo $page_title; ?></strong>
                </h1>
                <?php if(property_exists($area,'page_title_after_html') && $area->page_title_after_html) echo $area->page_title_after_html; ?>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="clear"></div>

            <?php
                if(property_exists($area,'view') && $area->view) include $area->view.".php";
            ?>

            <div class="clear"></div>
        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>