<?php defined('CORE_FOLDER') OR exit('You can not get in here!'); ?><!DOCTYPE html>
<html lang="<?php echo ___("package/code"); ?>">
<head>
    <?php
        $wClient = Config::get("theme/only-panel") && $clientArea_type == 1;
        include __DIR__.DS."inc".DS."main-head.php";
    ?>
</head>

<?php
    if(isset($hoptions["page"]) && $hoptions["page"] == "index"){
        ?><body<?php echo ($header_type == 1) ? ' id="home"' : '';?>><?php
    }elseif(!isset($hoptions["page"])){
        ?><body id="<?php echo $clientArea_type == 1 ? "modernpanel" : "muspanel"; ?>"><?php
    }elseif($wClient){
        ?><body id="modernpanel"><?php
    }else{
        ?><body><?php
    }

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

<?php
    if($wClient){
        ?>
        <a onclick="dashboard_style_toggle();" href="javascript:void 0;"><div class="mobmenuclose"></div></a>

        <div class="rightcontent">
            <div class="rightconhead"><?php include __DIR__.DS."inc".DS."ac-header-1.php"; ?></div>

            <?php
            ?>
            <div class="modernclient-rightcon">

                <?php if(isset($header_title) && $header_title){ ?>
                    <div class="clear"></div>
                    <div id="wrapper">
                        <div class="sayfabaslik">
                            <h1><?php echo $header_title; ?></h1>
                            <?php echo (isset($header_description) && $header_description !='') ? "<a>".$header_description."</a>" : ''; ?>
                            <?php include __DIR__.DS."inc".DS."header-breadcrumb.php"; ?>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <?php if(!isset($page_type) || (isset($page_type) && $page_type != "account")){ ?><div class="headerwhite"></div><?php } ?>
                    <?php if(isset($social_share) && $social_share): ?>
                        <div id="wrapper">
                            <div class="paypasbutonlar">
                                <?php include __DIR__.DS."inc".DS."social_share.php"; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php } ?>

                {get_content}
            </div>
            <?php
                include __DIR__.DS."inc".DS."ac-footer-1.php";

            ?>
        </div>

        <?php include __DIR__.DS."inc".DS."ac-sidebar-1.php"; ?>

        <div class="clear"></div>

        <?php
    }
    else{

        ?>
        <?php include $tpath."inc".DSEPARATOR."main-header-".$header_type.".php"; ?>
        {get_content}
        <?php include __DIR__.DS."inc".DSEPARATOR."main-footer.php"; ?>
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