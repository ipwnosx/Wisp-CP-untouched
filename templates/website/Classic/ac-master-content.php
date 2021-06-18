<?php defined('CORE_FOLDER') OR exit('You can not get in here!'); ?>
<!DOCTYPE html>
<html lang="<?php echo ___("package/code"); ?>">
<head>
    <?php include __DIR__.DS."inc/ac-head.php"; ?>
</head>

<body id="clean-theme-client">
<?php if($h_contents = Hook::run("ClientAreaBeginBody")) foreach($h_contents AS $h_content) if($h_content) echo $h_content; ?>

<?php
    include __DIR__.DS."inc".DS."demo-views.php";
?>

<?php include __DIR__.DS."inc".DS."lang-currency-modal.php"; ?>

<?php
    include __DIR__.DS."inc".DS."main-header.php";

?>
<div id="wrapper">



    <?php
        if(isset($wide_content) && $wide_content){
            ?>
            <div class="mpanelright" id="bigcontent">
                {get_content}
            </div>
            <?php
        }
        else{
            ?>
            <div id="basic_client_rightcon">

                <?php if($pname == "account_dashboard") include __DIR__.DS."inc".DS."ac-dashboard-statistics.php"; ?>

                <?php
                    if($pname == "account_dashboard")
                    {
                        include __DIR__.DS."inc".DS."ac-dashboard-domain-panel.php";
                        include __DIR__.DS."inc".DS."ac-remind-invoice.php";
                    }
                ?>

                {get_content}

            </div>

            <?php if(!isset($wide_content) || !$wide_content) include __DIR__.DS."inc".DS."ac-sidebar.php"; ?>

            <?php
        }
    ?>

</div>

<div class="clear"></div>

<?php include __DIR__.DS."inc".DS."main-footer.php"; ?>

<?php View::footer_codes(); ?>

<script src="<?php echo $tadress;?>js/aos.js"></script>
<script>
      AOS.init({
        duration: 1500
      });
    </script>

<a href="#0" class="cd-top">Top</a>

<?php if($h_contents = Hook::run("ClientAreaEndBody")) foreach($h_contents AS $h_content) if($h_content) echo $h_content; ?>

</body>
</html>