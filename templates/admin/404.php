<!DOCTYPE html>
<html>
<head>
    <?php
        include __DIR__.DS."inc".DS."head.php";
    ?>
</head>
<body>


<div id="wrapper">

    <div class="admio404" style="text-align:center;margin:10% 0px;float:left;width:100%;">
        <div  style="width: 100px; height: 50px; display: block; margin-left: auto; margin-right: auto;    margin-bottom: 55px;" >
            <img src="<?php echo $tadress; ?>images/404.jpg" width="100">
        </div>
        <br><h3 style="color:#e23e3d;"><?php echo __("admin/404/name"); ?></h3><br><br>
        <h4><?php echo __("admin/404/description"); ?></h4><br><br>
        <a href="<?php echo $dashboard_link; ?>" class="lbtn"><?php echo __("admin/404/home-button"); ?></a>
    </div>

</div>


</body>
</html>