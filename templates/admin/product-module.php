<!DOCTYPE html>
<html>
<head>
    <?php
        $plugins    = ['jquery-ui','dataTables','select2'];
        include __DIR__.DS."inc".DS."head.php";
    ?>
    <script type="text/javascript">
        var
            waiting_text  = '<?php echo ___("needs/button-waiting"); ?>',
            progress_text = '<?php echo ___("needs/button-uploading"); ?>';
    </script>

    <style>
        .load-wrapp{width:150px;margin:55px auto;text-align:center;color:#607D8B}
        .load-7{display:inline-block;margin-left:-70px}
        .square{width:12px;height:12px;border-radius:4px;background-color:#607D8B}
        .spinner{position:relative;width:45px;height:45px;margin:0 auto}
        .l-1{animation-delay:.48s}
        .l-2{animation-delay:.6s}
        .l-3{animation-delay:.72s}
        .l-4{animation-delay:.84s}
        .l-5{animation-delay:.96s}
        .l-6{animation-delay:1.08s}
        .l-7{animation-delay:1.2s}
        .l-8{animation-delay:1.32s}
        .l-9{animation-delay:1.44s}
        .l-10{animation-delay:1.56s}

        .load-7 .square {animation: loadingG 1.5s cubic-bezier(.17,.37,.43,.67) infinite;}

        @keyframes loadingA {
            50%{height:15px 35px}
            100%{height:15px}
        }
        @keyframes loadingB {
            50%{width:15px 35px}
            100%{width:15px}
        }
        @keyframes loadingC {
            50%{transform:translate(0,0) translate(0,15px)}
            100%{transform:translate(0,0)}
        }
        @keyframes loadingD {
            50%{transform:rotate(0deg) rotate(180deg)}
            100%{transform:rotate(360deg)}
        }
        @keyframes loadingE {
            100%{transform:rotate(0deg) rotate(360deg)}
        }
        @keyframes loadingF {
            0%{opacity:0}
            100%{opacity:1}
        }
        @keyframes loadingG {
            0%{transform:translate(0,0) rotate(0deg)}
            50%{transform:translate(70px,0) rotate(360deg)}
            100%{transform:translate(0,0) rotate(0deg)}
        }
        @keyframes loadingH {
            0%{width:15px}
            50%{width:35px;padding:4px}
            100%{width:15px}
        }
        @keyframes loadingI {
            100%{transform:rotate(360deg)}
        }
        @keyframes bounce {
            0%,100%{transform:scale(0.0)}
            50%{transform:scale(1.0)}
        }
        @keyframes loadingJ {
            0%,100%{transform:translate(0,0)}
            50%{transform:translate(80px,0);background-color:#607D8B;width:25px}
        }
    </style>

</head>
<body>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1><?php echo $page_name; ?></h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>


            <div class="clear"></div>


            <?php
                if($modules && sizeof($modules) > 0)
                {
                    ?>
                    <div class="verticaltabs">
                        <div class="verticaltabscon">

                            <div id="tab-module"><!-- tab wrap content start -->
                                <ul class="tab">
                                    <?php
                                        foreach($modules AS $key=>$item){
                                            $name = isset($item["lang"]["name"]) ? $item["lang"]["name"] : NULL;
                                            ?>
                                            <li><a href="<?php echo $links["controller"]; ?>?module=<?php echo $key; ?>" class="tablinks<?php echo $m_name == $key ? ' active' : ''; ?>"><span><?php echo $name; ?></span></a></li>
                                            <?php
                                        }
                                    ?>
                                </ul>

                                <?php
                                    if($module){
                                        ?>
                                        <div class="tabcontent" style="display: block">
                                            <?php
                                                $name    = isset($m_data["lang"]["name"]) ? $m_data["lang"]["name"] : $m_data["config"]["meta"]["name"];
                                                $logo    = isset($m_data["config"]["meta"]["logo"]) ? $m_data["config"]["meta"]["logo"] : false;
                                                if($logo) $logo = Utility::image_link_determiner($logo,$module_url.$m_name.DS);

                                            ?>

                                            <div class="verticaltabstitle">
                                                <h2><?php echo $name; ?>
                                                    <?php if($logo): ?>
                                                        <img style="float:right" src="<?php echo $logo; ?>" height="35"/>
                                                    <?php endif; ?>
                                                </h2>
                                            </div>
                                            <div class="module-page-content">
                                                <?php echo $m_content; ?>
                                            </div>

                                            <div class="clear"></div>
                                        </div>
                                        <?php
                                    }
                                ?>



                            </div><!-- tab wrap content end -->

                        </div>
                    </div>
                    <?php
                }
                else
                {
                    ?>
                    <div class="noapimodule">
                        <div class="padding20">
                            <i class="fa fa-info-circle"></i>
                            <p><?php echo __("admin/products/no-product-modules"); ?></p>
                        </div>
                    </div>
                    <?php
                }
            ?>



        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>