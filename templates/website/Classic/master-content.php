<?php defined('CORE_FOLDER') OR exit('You can not get in here!'); ?><!DOCTYPE html>
<html lang="<?php echo ___("package/code"); ?>">
<head>
    <?php include __DIR__.DS."inc".DS."main-head.php"; ?>
</head>

<?php
    ?><body id="clean-theme-client"><?php

    if($h_contents = Hook::run("ClientAreaBeginBody")) foreach($h_contents AS $h_content) if($h_content) echo $h_content;

    echo EOL;
    include __DIR__.DS."inc".DS."demo-views.php";

    if(Session::get("preview_theme")){
        ?>
        <div class="themepreview">
            <h5><?php echo __("website/index/theme-preview-text1",['{name}' => '<strong>'.$_theme_display_name.'</strong>']); ?></h5>
            <a href="<?php echo APP_URI."/index?close_theme_preview=true"; ?>" class="lbtn"><?php echo __("website/index/theme-preview-text2"); ?></a>
        </div>
        <?php
    }


?>

<?php
    if(isset($hoptions["page"]) && $hoptions["page"] == "index"){
        ?>
        <div id="wisecp" style="background-color:#ffffff;width:100%;height:100%;padding-top:20%;" class="hbcne hgchd">
            <div align="center"><a style="font-size:19px;color:#ff0000;"></a><br/><br/>
                <img style="padding:0px;margin:0px;background-color:transparent;border:none;" src="<?php echo $tadress; ?>images/loading.svg" alt="Loading..." title="Loading..." width="78" height="78"/></div></div>
        <?php
    }
?>

<?php include __DIR__.DS."inc".DS."lang-currency-modal.php"; ?>

<?php include __DIR__.DS."inc".DSEPARATOR."main-header.php"; ?>
{get_content}
<?php include __DIR__.DS."inc".DSEPARATOR."main-footer.php"; ?>


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