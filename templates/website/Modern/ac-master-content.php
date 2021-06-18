<?php defined('CORE_FOLDER') OR exit('You can not get in here!'); ?>
<!DOCTYPE html>
<html lang="<?php echo ___("package/code"); ?>">
<head>
    <?php include __DIR__.DS."inc/ac-head.php"; ?>
</head>

<body id="<?php echo $clientArea_type == 1 ? "modernpanel" : "muspanel"; ?>">
<?php if($h_contents = Hook::run("ClientAreaBeginBody")) foreach($h_contents AS $h_content) if($h_content) echo $h_content; ?>

<?php
    include __DIR__.DS."inc".DS."demo-views.php";
?>

<?php include __DIR__.DS."inc".DS."lang-currency-modal.php"; ?>

<?php
    if($clientArea_type == 1){
        ?>
        <a onclick="dashboard_style_toggle();" href="javascript:void 0;"><div class="mobmenuclose"></div></a>

        <div class="rightcontent">

            <div class="rightconhead">
                <?php include __DIR__.DS."inc".DS."ac-header-1.php"; ?>
            </div>

            <?php
                if(isset($pname) && $pname == "account_dashboard"){
                    include __DIR__.DS."inc".DS."ac-dashboard-statistics.php";
                    include __DIR__.DS."inc".DS."ac-dashboard-domain-panel.php";

                    ?>
                    <div class="padding20">

                        <?php include __DIR__.DS."inc".DS."ac-remind-invoice.php"; ?>

                        {get_content}
                        <?php include __DIR__.DS."inc".DS."ac-footer-1.php"; ?>
                    </div>
                    <?php

                }else{

                    ?>
                    <div class="modernclient-rightcon">
                        {get_content}
                    </div>

                    <?php include __DIR__.DS."inc".DS."ac-footer-1.php"; ?>
                    <?php
                }
            ?>

        </div>

        <?php include __DIR__.DS."inc".DS."ac-sidebar-1.php"; ?>

        <div class="clear"></div>
        <?php
    }
    elseif($clientArea_type == 2){

        include $tpath."inc".DSEPARATOR."main-header-".$header_type.".php";

        if(isset($pname) && $pname) include __DIR__.DS."inc".DS."ac-header-2.php";
        else $pname = false;

        ?>
        <div id="wrapper">

            <?php if($pname == "account_dashboard") include __DIR__.DS."inc".DS."ac-dashboard-statistics.php"; ?>

            <?php if($pname == "account_dashboard") include __DIR__.DS."inc".DS."ac-remind-invoice.php"; ?>

            <?php
                if(isset($wide_content) && $wide_content){
                    ?>
                    <div class="mpanelright" id="bigcontent">
                        {get_content}
                    </div>
                    <?php
                }else{
                    ?>
                    <div id="basic_client_rightcon">

                        {get_content}

                    </div>

                    <?php include __DIR__.DS."inc".DS."ac-sidebar-2.php"; ?>

                    <?php
                }
            ?>

        </div>

        <div class="clear"></div>

        <?php include __DIR__.DS."inc".DS."ac-footer-2.php"; ?>
        <?php


    }
?>

<?php View::footer_codes(); ?>

<script src="<?php echo $tadress;?>js/aos.js"></script>
<script type="text/javascript">
    AOS.init({
        easing: 'ease-out-back',
        duration: 1000
    });
</script>

<a href="#0" class="cd-top">Top</a>

<?php if($h_contents = Hook::run("ClientAreaEndBody")) foreach($h_contents AS $h_content) if($h_content) echo $h_content; ?>

</body>
</html>