<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    if(!isset($hoptions)) $hoptions = [];
    if(isset($hoptions["page"]) && $hoptions["page"] != "index" && isset($meta["title"]))
        $meta["title"] .= " - ".__("website/index/meta/title");
?>
<!-- Meta Tags -->
<title><?php echo isset($meta["title"]) ? $meta["title"] : NULL; ?></title>
<meta name="keywords" content="<?php echo isset($meta["keywords"]) ? $meta["keywords"] : NULL;?>" />
<meta name="description" content="<?php echo isset($meta["description"]) ? $meta["description"] : NULL;?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="robots" content="<?php echo isset($meta["robots"]) ? $meta["robots"] : NULL; ?>" />
<?php View::main_meta(); ?>
<link rel="canonical" href="<?php echo $canonical_link;?>" />
<link rel="icon" type="image/x-icon" href="<?php echo $favicon_link;?>" />
<meta name="theme-color" content="<?php echo $meta_color; ?>">

<?php
    if(isset($lang_list) && $lang_list){
        foreach($lang_list AS $l_row){
            $l_link = $l_row["link"];
            $l_link = str_replace(["?chl=true","&chl=true"],"",$l_link);
            ?><link rel="alternate" hreflang="<?php echo $l_row["key"]; ?>" href="<?php echo $l_link; ?>" /><?php
            echo EOL;
        }
    }
?>

<!-- Meta Tags -->

<!-- Css -->
<?php
    View::main_style();
?>

<link rel="stylesheet" href="<?php echo $tadress;?>css/wisecp.css?v=<?php echo License::get_version(); ?>"/>

<link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,700,800|Titillium+Web:200,300,400,600,700&amp;subset=latin-ext" rel="stylesheet">
<link rel="stylesheet" href="<?php echo $tadress;?>css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo $tadress;?>css/ionicons.min.css"/>
<link rel="stylesheet" href="<?php echo $tadress;?>css/animate.css" media="none" onload="if(media!='all')media='all'">
<link rel="stylesheet" href="<?php echo $tadress;?>css/aos.css" />


<?php if(isset($hoptions) && in_array("aos",$hoptions)): ?>
<?php endif; ?>
<?php if(in_array("highlightjs",$hoptions)): ?>
    <link rel="stylesheet" href="<?php echo $sadress; ?>assets/plugins/highlightjs/styles/zenburn.css">
<?php endif; ?>
<?php if(in_array("jquery-ui",$hoptions)): ?>
    <link rel="stylesheet" href="<?php echo $sadress; ?>assets/plugins/css/jquery-ui.css">
<?php endif; ?>
<?php if(in_array("intlTelInput",$hoptions)): ?>
    <link rel="stylesheet" href="<?php echo $sadress; ?>assets/plugins/phone-cc/css/intlTelInput.css">
<?php endif; ?>
<?php if(in_array("dataTables",$hoptions)): ?>
    <link rel="stylesheet" href="<?php echo $sadress; ?>assets/plugins/dataTables/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="<?php echo $sadress; ?>assets/plugins/dataTables/css/dataTables.responsive.min.css">
<?php endif; ?>
<?php if(in_array("select2",$hoptions)): ?>
    <link rel="stylesheet" href="<?php echo $sadress; ?>assets/plugins/select2/css/select2.min.css">
<?php endif; ?>
<?php if(in_array("jQtags",$hoptions)): ?>
    <link rel="stylesheet" href="<?php echo $sadress; ?>assets/plugins/tags/jquery.tagsinput.min.css">
<?php endif; ?>
<?php if(in_array("ion.rangeSlider",$hoptions)): ?>
    <link rel="stylesheet" href="<?php echo $sadress; ?>assets/plugins/ion.rangeSlider/css/ion.rangeSlider.min.css">
<?php endif; ?>

<?php if(___("package/rtl")): ?><link rel="stylesheet" href="<?php echo $sadress."assets/style/theme-rtl.css?v=".License::get_version();?>&lang=<?php echo Bootstrap::$lang->clang; ?>"><?php endif; ?>

<!-- Css -->

<!-- Js -->

<script>
    var template_address = "<?php echo $tadress;?>";
</script>
<script src="<?php echo $tadress;?>js/jquery-1.11.3.min.js"></script>

<?php if(isset($hoptions["page"]) && $hoptions["page"] == "index"): ?>

    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {setTimeout('document.getElementById("wisecp").style.display="none"', 100);});
    </script>
    <script>(function(){"use strict";var c=[],f={},a,e,d,b;if(!window.jQuery){a=function(g){c.push(g)};f.ready=function(g){a(g)};e=window.jQuery=window.$=function(g){if(typeof g=="function"){a(g)}return f};window.checkJQ=function(){if(!d()){b=setTimeout(checkJQ,100)}};b=setTimeout(checkJQ,100);d=function(){if(window.jQuery!==e){clearTimeout(b);var g=c.shift();while(g){jQuery(g);g=c.shift()}b=f=a=e=d=window.checkJQ=null;return true}return false}}})();</script>
    <style type="text/css">div.hbcne{position:fixed;z-index:4000;}div.hgchd{top:0px;left:0px;} div.hbcne{_position:absolute;}div.hgchd{_bottom:auto;_top:expression(ie6=(document.documentElement.scrollTop+document.documentElement.clientHeight – 52)+"px") );}</style>


    <?php if($header_type==1): ?>

        <!-- REVO SLIDER -->

        <link rel="stylesheet" type="text/css" href="<?php echo $tadress; ?>fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $tadress; ?>fonts/font-awesome/css/font-awesome.css">

        <!-- REVOLUTION STYLE SHEETS -->
        <link rel="stylesheet" type="text/css" href="<?php echo $tadress; ?>css/settings.css">
        <!-- REVOLUTION LAYERS STYLES -->

        <style type="text/css"> #rev_slider_57_1_wrapper .tp-loader.spinner2{ background-color: #FFFFFF !important; } </style>
        <style type="text/css">.tiny_bullet_slider .tp-bullet:before{content:" ";  position:absolute;  width:100%;  height:25px;  top:-12px;  left:0px;  background:transparent}</style>
        <style type="text/css">.bullet-bar.tp-bullets{}.bullet-bar.tp-bullets:before{content:" ";position:absolute;width:100%;height:100%;background:transparent;padding:10px;margin-left:-10px;margin-top:-10px;box-sizing:content-box}.bullet-bar .tp-bullet{width:60px;height:3px;position:absolute;background:#aaa;  background:rgba(204,204,204,0.5);cursor:pointer;box-sizing:content-box}.bullet-bar .tp-bullet:hover,.bullet-bar .tp-bullet.selected{background:rgba(204,204,204,1)}.bullet-bar .tp-bullet-image{}.bullet-bar .tp-bullet-title{}</style>


        <!-- ADD-ONS CSS FILES -->

        <!-- ADD-ONS JS FILES -->
        <script type="text/javascript" src="<?php echo $tadress; ?>js/revolution.addon.slicey.min.js"></script>

        <!-- REVOLUTION JS FILES -->
        <script type="text/javascript" src="<?php echo $tadress; ?>js/jquery.themepunch.tools.min.js"></script>
        <script type="text/javascript" src="<?php echo $tadress; ?>js/jquery.themepunch.revolution.min.js"></script>


        <!-- SLIDER REVOLUTION 5.0 EXTENSIONS  (Load Extensions only on Local File Systems !  The following part can be removed on Server for On Demand Loading) -->
        <script type="text/javascript" src="<?php echo $tadress; ?>js/extensions/revolution.extension.actions.min.js"></script>
        <script type="text/javascript" src="<?php echo $tadress; ?>js/extensions/revolution.extension.carousel.min.js"></script>
        <script type="text/javascript" src="<?php echo $tadress; ?>js/extensions/revolution.extension.kenburn.min.js"></script>
        <script type="text/javascript" src="<?php echo $tadress; ?>js/extensions/revolution.extension.layeranimation.min.js"></script>
        <script type="text/javascript" src="<?php echo $tadress; ?>js/extensions/revolution.extension.migration.min.js"></script>
        <script type="text/javascript" src="<?php echo $tadress; ?>js/extensions/revolution.extension.navigation.min.js"></script>
        <script type="text/javascript" src="<?php echo $tadress; ?>js/extensions/revolution.extension.parallax.min.js"></script>
        <script type="text/javascript" src="<?php echo $tadress; ?>js/extensions/revolution.extension.slideanims.min.js"></script>
        <script type="text/javascript" src="<?php echo $tadress; ?>js/extensions/revolution.extension.video.min.js"></script>


        <script type="text/javascript">function setREVStartSize(e){
                try{ e.c=jQuery(e.c);var i=jQuery(window).width(),t=9999,r=0,n=0,l=0,f=0,s=0,h=0;
                    if(e.responsiveLevels&&(jQuery.each(e.responsiveLevels,function(e,f){f>i&&(t=r=f,l=e),i>f&&f>r&&(r=f,n=e)}),t>r&&(l=n)),f=e.gridheight[l]||e.gridheight[0]||e.gridheight,s=e.gridwidth[l]||e.gridwidth[0]||e.gridwidth,h=i/s,h=h>1?1:h,f=Math.round(h*f),"fullscreen"==e.sliderLayout){var u=(e.c.width(),jQuery(window).height());if(void 0!=e.fullScreenOffsetContainer){var c=e.fullScreenOffsetContainer.split(",");if (c) jQuery.each(c,function(e,i){u=jQuery(i).length>0?u-jQuery(i).outerHeight(!0):u}),e.fullScreenOffset.split("%").length>1&&void 0!=e.fullScreenOffset&&e.fullScreenOffset.length>0?u-=jQuery(window).height()*parseInt(e.fullScreenOffset,0)/100:void 0!=e.fullScreenOffset&&e.fullScreenOffset.length>0&&(u-=parseInt(e.fullScreenOffset,0))}f=u}else void 0!=e.minHeight&&f<e.minHeight&&(f=e.minHeight);e.c.closest(".rev_slider_wrapper").css({height:f})
                }catch(d){console.log("Failure at Presize of Slider:"+d)}
            };</script>
        <!-- REVO SLIDER END -->

    <?php elseif($header_type==2): ?>

        <!-- REVO SLIDER -->

        <link rel="stylesheet" type="text/css" href="<?php echo $tadress; ?>fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $tadress; ?>fonts/font-awesome/css/font-awesome.css">

        <!-- REVOLUTION STYLE SHEETS -->
        <link rel="stylesheet" type="text/css" href="<?php echo $tadress; ?>css/settings.css">
        <!-- REVOLUTION LAYERS STYLES -->

        <style type="text/css"> #rev_slider_58_1_wrapper .tp-loader.spinner2{ background-color: #FFFFFF !important; } </style>
        <style type="text/css">.tiny_bullet_slider .tp-bullet:before{content:" ";  position:absolute;  width:100%;  height:25px;  top:-12px;  left:0px;  background:transparent}</style>
        <style type="text/css">.bullet-bar.tp-bullets{}.bullet-bar.tp-bullets:before{content:" ";position:absolute;width:100%;height:100%;background:transparent;padding:10px;margin-left:-10px;margin-top:-10px;box-sizing:content-box}.bullet-bar .tp-bullet{width:60px;height:3px;position:absolute;background:#aaa;  background:rgba(204,204,204,0.5);cursor:pointer;box-sizing:content-box}.bullet-bar .tp-bullet:hover,.bullet-bar .tp-bullet.selected{background:rgba(204,204,204,1)}.bullet-bar .tp-bullet-image{}.bullet-bar .tp-bullet-title{}</style>


        <!-- ADD-ONS CSS FILES -->

        <!-- ADD-ONS JS FILES -->
        <script type="text/javascript" src="<?php echo $tadress; ?>js/revolution.addon.slicey.min.js"></script>

        <!-- REVOLUTION JS FILES -->
        <script type="text/javascript" src="<?php echo $tadress; ?>js/jquery.themepunch.tools.min.js"></script>
        <script type="text/javascript" src="<?php echo $tadress; ?>js/jquery.themepunch.revolution.min.js"></script>


        <!-- SLIDER REVOLUTION 5.0 EXTENSIONS  (Load Extensions only on Local File Systems !  The following part can be removed on Server for On Demand Loading) -->
        <script type="text/javascript" src="<?php echo $tadress; ?>js/extensions/revolution.extension.actions.min.js"></script>
        <script type="text/javascript" src="<?php echo $tadress; ?>js/extensions/revolution.extension.carousel.min.js"></script>
        <script type="text/javascript" src="<?php echo $tadress; ?>js/extensions/revolution.extension.kenburn.min.js"></script>
        <script type="text/javascript" src="<?php echo $tadress; ?>js/extensions/revolution.extension.layeranimation.min.js"></script>
        <script type="text/javascript" src="<?php echo $tadress; ?>js/extensions/revolution.extension.migration.min.js"></script>
        <script type="text/javascript" src="<?php echo $tadress; ?>js/extensions/revolution.extension.navigation.min.js"></script>
        <script type="text/javascript" src="<?php echo $tadress; ?>js/extensions/revolution.extension.parallax.min.js"></script>
        <script type="text/javascript" src="<?php echo $tadress; ?>js/extensions/revolution.extension.slideanims.min.js"></script>
        <script type="text/javascript" src="<?php echo $tadress; ?>js/extensions/revolution.extension.video.min.js"></script>


        <script type="text/javascript">function setREVStartSize(e){
                try{ e.c=jQuery(e.c);var i=jQuery(window).width(),t=9999,r=0,n=0,l=0,f=0,s=0,h=0;
                    if(e.responsiveLevels&&(jQuery.each(e.responsiveLevels,function(e,f){f>i&&(t=r=f,l=e),i>f&&f>r&&(r=f,n=e)}),t>r&&(l=n)),f=e.gridheight[l]||e.gridheight[0]||e.gridheight,s=e.gridwidth[l]||e.gridwidth[0]||e.gridwidth,h=i/s,h=h>1?1:h,f=Math.round(h*f),"fullscreen"==e.sliderLayout){var u=(e.c.width(),jQuery(window).height());if(void 0!=e.fullScreenOffsetContainer){var c=e.fullScreenOffsetContainer.split(",");if (c) jQuery.each(c,function(e,i){u=jQuery(i).length>0?u-jQuery(i).outerHeight(!0):u}),e.fullScreenOffset.split("%").length>1&&void 0!=e.fullScreenOffset&&e.fullScreenOffset.length>0?u-=jQuery(window).height()*parseInt(e.fullScreenOffset,0)/100:void 0!=e.fullScreenOffset&&e.fullScreenOffset.length>0&&(u-=parseInt(e.fullScreenOffset,0))}f=u}else void 0!=e.minHeight&&f<e.minHeight&&(f=e.minHeight);e.c.closest(".rev_slider_wrapper").css({height:f})
                }catch(d){console.log("Failure at Presize of Slider:"+d)}
            };</script>
        <!-- REVO SLIDER END -->

    <?php endif; ?>

    <script src="<?php echo $tadress; ?>js/jquery.carouFredSel-6.2.1-packed.js"></script>

    <script src="<?php echo $tadress; ?>js/index-setting.js"></script>

<?php endif; ?>

<?php if(isset($hoptions) && in_array("counterup",$hoptions)): ?>
    <script src="<?php echo $tadress;?>js/jquery.counterup.min.js"></script>
    <script src="<?php echo $tadress;?>js/waypoints.min.js"></script>
<?php endif; ?>
<?php if(in_array("highlightjs",$hoptions)): ?>
    <script src="<?php echo $sadress; ?>assets/plugins/highlightjs/highlight.pack.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('pre code').each(function(i, block) {
                hljs.highlightBlock(block);
            });
        });
    </script>
<?php endif; ?>
<?php if(in_array("jquery-ui",$hoptions)): ?>
    <script src="<?php echo $sadress; ?>assets/plugins/js/jquery-ui.js"></script>
    <script type="text/javascript" src="<?php echo $sadress;?>assets/plugins/js/i18n/datepicker-<?php echo ___("package/code"); ?>.js"></script>
<?php endif; ?>
<?php if(in_array("intlTelInput",$hoptions)): ?>
    <script src="<?php echo $sadress; ?>assets/plugins/phone-cc/js/intlTelInput.js"></script>
<?php endif; ?>
<?php if(in_array("dataTables",$hoptions)): ?>
    <script src="<?php echo $sadress; ?>assets/plugins/dataTables/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo $sadress; ?>assets/plugins/dataTables/js/dataTables.responsive.min.js"></script>
<?php endif; ?>
<?php if(in_array("select2",$hoptions)): ?>
    <script src="<?php echo $sadress; ?>assets/plugins/select2/js/select2.min.js"></script>
<?php endif; ?>
<?php if(in_array("isotope",$hoptions)): ?>
    <script src="<?php echo $sadress; ?>assets/plugins/js/isotope.pkgd.min.js"></script>
<?php endif; ?>
<?php if(in_array("jQtags",$hoptions)): ?>
    <script src="<?php echo $sadress; ?>assets/plugins/tags/jquery.tagsinput.min.js"></script>
<?php endif; ?>
<?php if(in_array("voucher_codes",$hoptions)): ?>
    <script src="<?php echo $sadress; ?>assets/plugins/js/voucher_codes.js"></script>
<?php endif; ?>
<?php if(in_array("Sortable",$hoptions)): ?>
    <script src="<?php echo $sadress; ?>assets/plugins/js/Sortable.min.js"></script>
<?php endif; ?>
<?php if(in_array("jquery-nestable",$hoptions)): ?>
    <script src="<?php echo $sadress; ?>assets/plugins/js/jquery.nestable.js"></script>
<?php endif; ?>
<?php if(in_array("jquery.countdown",$hoptions)): ?>
    <script src="<?php echo $sadress; ?>assets/plugins/js/jquery.countdown.min.js"></script>
<?php endif; ?>
<?php if(in_array("ion.rangeSlider",$hoptions)): ?>
    <script src="<?php echo $sadress; ?>assets/plugins/ion.rangeSlider/js/ion.rangeSlider.min.js"></script>
<?php endif; ?>
<?php View::main_script(); ?>

<!-- Js -->