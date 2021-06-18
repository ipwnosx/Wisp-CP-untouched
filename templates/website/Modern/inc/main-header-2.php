<?php defined('CORE_FOLDER') OR exit('You can not get in here!'); ?><style>
.menu_tag{ background-color:#4CAF50;color:#fff;padding:2px 7px;font-size:13px;border-radius:3px;text-align:center;font-weight:300;margin-top:-10px;float:right;margin-left:-100px;margin-right:20px;}@media only screen and (min-width:320px) and (max-width:1023px){.menu_tag{margin-top:13px;position:relative;margin-bottom:-50px;margin-left: 0px;}}
</style>

<?php include __DIR__.DS."lang-currency-modal.php"; ?>

<div class="header" id="fullwidth"<?php echo (isset($header_background) && $header_background) ? ' style="background-image: url('.$header_background.');"' : '';?>>

    <div class="fullwidthhead">
        <div id="wrapper">
            <a href="<?php echo $home_link;?>"><img class="logo" title="Logo" alt="Logo" src="<?php echo $header_logo_link;?>" width="269" height="auto"></a>
            <div class="headbutonlar">

                <?php
                    if($login_check){
                        ?>
                        <a class="borderedbtn" href="<?php echo $my_account_link;?>"><i class="fa fa-user" aria-hidden="true"></i> <?php echo __("website/account/my-account"); ?></a>
                        <a href="<?php echo $logout_link;?>"><i class="fa fa-sign-out"></i> <?php echo __("website/sign/out");?></a>
                    <?php }else{ ?>
                        <?php if($sign_in): ?>
                            <a href="<?php echo $login_link; ?>"><i class="fa fa-sign-in"></i> <?php echo __("website/sign/in");?></a>
                        <?php endif; ?>
                        <?php if($sign_up && !Config::get("options/crtacwshop")): ?>
                            <a class="borderedbtn" href="<?php echo $register_link; ?>"><i class="fa fa-user-plus" aria-hidden="true"></i> <?php echo __("website/sign/up");?></a>
                        <?php endif; ?>
                    <?php } ?>

                <?php if($sign_in): ?>
                    <?php if($visibility_ticket): ?>
                        <a id="headicon" href="<?php echo $tickets_link; ?>"><i class="fa fa-life-ring" aria-hidden="true"></i></a>
                    <?php endif; ?>
                <?php endif; ?>

                <?php
                    if($currencies_count>1){
                        ?>
                        <a class="scurrencyicon" href="javascript:open_modal('selectCurrency',{overlayColor: 'rgba(0, 0, 0, 0.85)'}); void 0;" title="<?php echo __("website/index/select-your-currency"); ?>"><?php echo $selected_c['code']; ?></a>
                        <?php
                    }

                    if($lang_count>1){
                        ?>
                        <a class="langflagicon" href="javascript:open_modal('selectLang',{overlayColor: 'rgba(0, 0, 0, 0.85)'}); void 0;" title="<?php echo __("website/index/select-your-language"); ?>">
                            <img title="<?php echo $selected_l["cname"]." (".$selected_l["name"].")"; ?>" alt="<?php echo $selected_l["cname"]." (".$selected_l["name"].")"; ?>" src="<?php echo $selected_l["flag-img"]; ?>">
                        </a>
                        <?php
                    }
                ?>

            </div>
        </div>
    </div>

    <div class="menu">
        <div class="menucolor"></div>
        <div id="wrapper">
            <a href="javascript:$('#mobmenu').slideToggle();void 0;" class="menuAc"><i class="fa fa-bars" aria-hidden="true"></i></a>

            <?php
                if(!Config::get("theme/only-panel")){

                    function header_menu_walk($list=[],$children=false,$opt=[]){
                        $mobile = isset($opt["mobile"]) && $opt["mobile"];

                        if($children){
                            echo '<ul';
                            if($mobile)
                                echo ' class="inner"';
                            echo '>';
                        }

                        foreach ($list AS $menu){
                            $mega   = false;
                            $tag    = false;
                            if(isset($menu["extra"]["mega"]["header_".$opt["header_type"]]))
                                $mega = $menu["extra"]["mega"]["header_".$opt["header_type"]];

                            if(isset($menu["extra"]["tag"])) $tag = $menu["extra"]["tag"];

                            if($menu["children"] || $mega) $menu["link"] = "javascript:void 0;";

                            echo '<li';

                            if(!$mobile){
                                if(!$children && $mega) echo ' id="megamenuli"';
                                elseif(!$children && $menu["children"]) echo ' id="noborder"';
                            }

                            echo '>';

                            if($tag)
                                echo "<span class='menu_tag' style='background-color:".$tag["color"].";'>".$tag["name"]."</span> ";

                            echo '<a href="'.$menu["link"].'"';

                            if($menu["target"]) echo ' target="_blank"';

                            if($mobile && ($menu["children"] || $mega)) echo  ' class="toggle"';

                            echo '>';

                            if(isset($opt["span"])) echo '<span>';

                            echo ($menu["icon"]) ? '<i class="'.$menu["icon"].'" aria-hidden="true"></i> ' : '';
                            echo $menu["title"];

                            if($menu["children"] || $mega) echo ' <i class="fa fa-caret-down" aria-hidden="true"></i>';

                            if(isset($opt["span"])) echo '</span>';

                            echo '</a>';

                            if(!$children && $mega){

                                echo '<ul id="megamenu"';
                                if($mobile) echo  ' class="inner"';
                                echo '>';
                                echo Utility::text_replace($mega,[
                                    '{SITE_URL}' => APP_URI."/",
                                    '{TEMPLATE_URL}' => View::$init->get_template_url(),
                                ]);
                                echo '</ul>';
                            }

                            if($menu["children"] && !$mega)
                                header_menu_walk($menu["children"],true,$opt);

                            echo '</li>'.PHP_EOL;
                        }
                        echo ($children) ? '</ul>'.PHP_EOL : '';
                    }

                    ?>
                    <ul id="mobsabitmenus">
                        <li><a href="<?php echo $home_link; ?>"><span><i class="fa fa-home" aria-hidden="true"></i></span></a></li>
                        <?php
                            header_menu_walk($header_menus,false,[
                                'mobile'            => false,
                                'span'              => true,
                                'template_address'  => $tadress,
                                'header_type'       => $header_type,
                            ]);
                        ?>
                    </ul>
                    <?php
                }
            ?>

            <?php if($visibility_basket): ?>
                <a title="<?php echo __("website/checkout/basket-name");?>" id="sepeticon" href="<?php echo $basket_link; ?>"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span class="basket-count"><?php echo $basket_count; ?></span></a>
            <?php endif; ?>


        </div>

    </div>

    <div id="mobmenu" style="display:none">

        <div class="headbutonlar">

            <?php
                if($login_check){
                    ?>
                    <a href="<?php echo $my_account_link;?>"><i class="fa fa-user" aria-hidden="true"></i> <?php echo __("website/account/my-account"); ?></a>
                    <a href="<?php echo $logout_link;?>"><i class="fa fa-sign-out"></i> <?php echo __("website/sign/out");?></a>
                <?php }else{ ?>
                    <?php if($sign_in): ?>
                        <a href="<?php echo $login_link; ?>"><i class="fa fa-sign-in"></i> <?php echo __("website/sign/in");?></a>
                    <?php endif; ?>
                    <?php if($sign_up && !Config::get("options/crtacwshop")): ?>
                        <a href="<?php echo $register_link; ?>"><i class="fa fa-user-plus" aria-hidden="true"></i> <?php echo __("website/sign/up");?></a>
                    <?php endif; ?>
                <?php } ?>

            <?php if($sign_in): ?>
                <?php if($visibility_ticket): ?>
                    <a class="nomobilbtn" href="<?php echo $tickets_link; ?>"><i class="fa fa-life-ring" aria-hidden="true"></i> <?php echo __("website/account/tickets-button"); ?></a>
                <?php endif; ?>
            <?php endif; ?>

        </div>

        <div id="mobmenu_wrap">
            <?php
                if(!Config::get("theme/only-panel")){
                    ?>
                    <ul>
                        <?php
                            header_menu_walk($mobile_menus ? $mobile_menus : $header_menus,false,[
                                'mobile'            => true,
                                'span'              => true,
                                'template_address'  => $tadress,
                                'header_type'       => $header_type,
                            ]);
                        ?>
                    </ul>
                    <?php
                }
            ?>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $('#mobmenu_wrap .toggle').click(function(e){
                e.preventDefault();

                var $this = $(this);

                if ($this.next().hasClass('show')) {
                    $this.next().removeClass('show');
                    $this.next().slideUp(350);
                } else {
                    $this.parent().parent().find('li .inner').removeClass('show');
                    $this.parent().parent().find('li .inner').slideUp(350);
                    $this.next().toggleClass('show');
                    $this.next().slideToggle(350);
                }
            });
        });
    </script>

</div>
<div class="clear"></div>

<?php if(isset($header_title) && $header_title){ ?>
    <div class="sayfaustheader" id="header2"<?php echo (isset($header_background) && $header_background) ? ' style="background-image: url('.$header_background.');"' : '';?>>
        <div id="wrapper">
            <div class="sayfabaslik">
                <h1><?php echo $header_title; ?></h1>
                <?php echo (isset($header_description) && $header_description !='') ? "<a>".$header_description."</a>" : ''; ?>
                <?php include __DIR__.DS."header-breadcrumb.php"; ?>
            </div>
        </div>

        <div class="headerwhite"></div>
        <div class="clear"></div>
        <?php if(isset($social_share) && $social_share): ?>
            <div id="wrapper">
                <div class="paypasbutonlar">
                    <a id="facepaylas" onclick="NewWindow(this.href,'<?php echo addslashes(__("website/others/share-page")); ?>','545','600','no','center');return false" onfocus="this.blur()" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($canonical_link);?>&display=popup&ref=plugin&src=share_button"><i class="fa fa-facebook" aria-hidden="true"></i></a>

                    <a id="twitpaylas" onclick="NewWindow(this.href,'<?php echo addslashes(__("website/others/share-page")); ?>','545','600','no','center');return false" onfocus="this.blur()" target="_blank" href="https://twitter.com/intent/tweet?text=<?php echo urlencode($canonical_link);?>"><i class="fa fa-twitter" aria-hidden="true"></i></a>

                    <a id="googlepaylas" onclick="NewWindow(this.href,'<?php echo addslashes(__("website/others/share-page")); ?>','545','600','no','center');return false" onfocus="this.blur()" target="_blank" href="https://plus.google.com/share?url=<?php echo urlencode($canonical_link);?>"><i class="fa fa-google-plus" aria-hidden="true"></i></a>

                    <a id="linkedpaylas" onclick="NewWindow(this.href,'<?php echo addslashes(__("website/others/share-page")); ?>','545','600','no','center');return false" onfocus="this.blur()" target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode($canonical_link);?>&title=&summary=&source="><i class="fa fa-linkedin" aria-hidden="true"></i></a>

                    <script language="javascript" type="text/javascript">
                        var win=null;
                        function NewWindow(mypage,myname,w,h,scroll,pos){
                            if(pos=="random"){LeftPosition=(screen.width)?Math.floor(Math.random()*(screen.width-w)):100;TopPosition=(screen.height)?Math.floor(Math.random()*((screen.height-h)-75)):100;}
                            if(pos=="center"){LeftPosition=(screen.width)?(screen.width-w)/2:100;TopPosition=(screen.height)?(screen.height-h)/2:100;}
                            else if((pos!="center" && pos!="random") || pos==null){LeftPosition=0;TopPosition=20}
                            settings='width='+w+',height='+h+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no';
                            win=window.open(mypage,myname,settings);}
                    </script>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php } ?>

<?php
    if(isset($slider) && $slider==1 && $slides){

        ?>
        <!-- SLIDER -->

        <div id="rev_slider_58_1_wrapper" class="rev_slider_wrapper fullwidthbanner-container" data-alias="wisecp-fullwidth-slider" data-source="gallery" style="margin:0px auto;background:#000000;padding:0px;margin-top:0px;margin-bottom:0px;">
            <!-- START REVOLUTION SLIDER 5.4.8.1 fullwidth mode -->
            <div id="rev_slider_58_1" class="rev_slider fullwidthabanner" style="display:none;" data-version="5.4.8.1">


                <ul>
                    <?php
                        foreach ($slides AS $k=>$slide){
                            $extra      = isset($slide["extra"]) ? $slide["extra"] : [];
                            $is_video   = isset($extra["video"]) && $extra["video"];

                            if($is_video){
                                $video          = $extra["video"];
                                $duration_ms    = $video["duration"] * 1000;
                                $video_link     = $sadress."uploads/slides/".$video["file"];
                                ?>
                                <!-- SLIDE -->
                                <li data-index="rs-<?php echo $k; ?>" data-transition="slidingoverlayleft" data-slotamount="default" data-hideafterloop="0" data-hideslideonmobile="off"  data-easein="default" data-easeout="default" data-masterspeed="default"  data-thumb="<?php echo $slide['thumb_image']; ?>"  data-delay="<?php echo $duration_ms; ?>"  data-rotate="0"  data-saveperformance="off"  data-title="Slide" data-param1="" data-param2="" data-param3="" data-param4="" data-param5="" data-param6="" data-param7="" data-param8="" data-param9="" data-param10="" data-description="" data-slicey_shadow="0px 0px 0px 0px transparent">
                                    <!-- MAIN IMAGE -->
                                    <img src="<?php echo $slide['image']; ?>"  alt=""  data-bgposition="center center" data-bgfit="cover" class="rev-slidebg" data-no-retina>
                                    <!-- LAYERS -->

                                    <!-- BACKGROUND VIDEO LAYER -->
                                    <div class="rs-background-video-layer"
                                         data-forcerewind="on"
                                         data-videowidth="100%"
                                         data-videoheight="100%"
                                         data-videomp4="<?php echo $video_link; ?>"
                                         data-videopreload="auto"
                                         data-volume="0"
                                         data-videoloop="none"
                                         data-forceCover="1"
                                         data-aspectratio="16:9"
                                         data-autoplay="true"
                                         data-autoplayonlyfirsttime="false"
                                         data-nextslideatend="false"
                                    ></div>
                                    <!-- LAYER NR. 1 -->
                                    <div class="tp-caption tp-shape tp-shapewrapper tp-slicey  tp-resizeme"
                                         id="slide-180-layer-9"
                                         data-x="['center','center','center','center']" data-hoffset="['-112','-43','-81','44']"
                                         data-y="['middle','middle','middle','middle']" data-voffset="['-219','-184','-185','182']"
                                         data-width="['250','250','150','150']"
                                         data-height="['150','150','100','100']"
                                         data-whitespace="nowrap"

                                         data-type="shape"
                                         data-slicey_offset="250"
                                         data-slicey_blurstart="0"
                                         data-slicey_blurend="20"
                                         data-responsive_offset="on"

                                         data-frames='[{"delay":300,"speed":1000,"frame":"0","from":"rX:0deg;rY:0deg;rZ:0deg;sX:1;sY:1;opacity:0;fb:20px;","to":"o:1;fb:0;","ease":"Power3.easeInOut"},{"delay":"+3700","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]'
                                         data-textAlign="['inherit','inherit','inherit','inherit']"
                                         data-paddingtop="[0,0,0,0]"
                                         data-paddingright="[0,0,0,0]"
                                         data-paddingbottom="[0,0,0,0]"
                                         data-paddingleft="[0,0,0,0]"

                                         style="z-index: 5;background-color:rgba(0,0,0,0.5);"> </div>

                                    <!-- LAYER NR. 2 -->
                                    <div class="tp-caption tp-shape tp-shapewrapper tp-slicey  tp-resizeme"
                                         id="slide-180-layer-10"
                                         data-x="['center','center','center','center']" data-hoffset="['151','228','224','117']"
                                         data-y="['middle','middle','middle','middle']" data-voffset="['-212','-159','71','-222']"
                                         data-width="['150','150','100','100']"
                                         data-height="['200','150','150','150']"
                                         data-whitespace="nowrap"

                                         data-type="shape"
                                         data-slicey_offset="250"
                                         data-slicey_blurstart="0"
                                         data-slicey_blurend="20"
                                         data-responsive_offset="on"

                                         data-frames='[{"delay":350,"speed":1000,"frame":"0","from":"sX:1;sY:1;opacity:0;fb:20px;","to":"o:1;fb:0;","ease":"Power3.easeInOut"},{"delay":"+3650","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]'
                                         data-textAlign="['inherit','inherit','inherit','inherit']"
                                         data-paddingtop="[0,0,0,0]"
                                         data-paddingright="[0,0,0,0]"
                                         data-paddingbottom="[0,0,0,0]"
                                         data-paddingleft="[0,0,0,0]"

                                         style="z-index: 6;background-color:rgba(0,0,0,0.5);"> </div>

                                    <!-- LAYER NR. 3 -->
                                    <div class="tp-caption tp-shape tp-shapewrapper tp-slicey  tp-resizeme"
                                         id="slide-180-layer-29"
                                         data-x="['center','center','center','center']" data-hoffset="['339','-442','104','-159']"
                                         data-y="['middle','middle','middle','middle']" data-voffset="['2','165','-172','219']"
                                         data-width="['250','250','150','150']"
                                         data-height="['150','150','100','100']"
                                         data-whitespace="nowrap"

                                         data-type="shape"
                                         data-slicey_offset="250"
                                         data-slicey_blurstart="0"
                                         data-slicey_blurend="20"
                                         data-responsive_offset="on"

                                         data-frames='[{"delay":400,"speed":1000,"frame":"0","from":"sX:1;sY:1;opacity:0;fb:20px;","to":"o:1;fb:0;","ease":"Power3.easeInOut"},{"delay":"+3600","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]'
                                         data-textAlign="['inherit','inherit','inherit','inherit']"
                                         data-paddingtop="[0,0,0,0]"
                                         data-paddingright="[0,0,0,0]"
                                         data-paddingbottom="[0,0,0,0]"
                                         data-paddingleft="[0,0,0,0]"

                                         style="z-index: 7;background-color:rgba(0,0,0,0.5);"> </div>

                                    <!-- LAYER NR. 4 -->
                                    <div class="tp-caption tp-shape tp-shapewrapper tp-slicey  tp-resizeme"
                                         id="slide-180-layer-12"
                                         data-x="['center','center','center','center']" data-hoffset="['162','216','-239','193']"
                                         data-y="['middle','middle','middle','middle']" data-voffset="['195','245','6','146']"
                                         data-width="['250','250','100','100']"
                                         data-height="150"
                                         data-whitespace="nowrap"

                                         data-type="shape"
                                         data-slicey_offset="250"
                                         data-slicey_blurstart="0"
                                         data-slicey_blurend="20"
                                         data-responsive_offset="on"

                                         data-frames='[{"delay":450,"speed":1000,"frame":"0","from":"opacity:0;fb:20px;","to":"o:1;fb:0;","ease":"Power3.easeInOut"},{"delay":"+3550","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]'
                                         data-textAlign="['inherit','inherit','inherit','inherit']"
                                         data-paddingtop="[0,0,0,0]"
                                         data-paddingright="[0,0,0,0]"
                                         data-paddingbottom="[0,0,0,0]"
                                         data-paddingleft="[0,0,0,0]"

                                         style="z-index: 8;background-color:rgba(0,0,0,0.5);"> </div>

                                    <!-- LAYER NR. 5 -->
                                    <div class="tp-caption tp-shape tp-shapewrapper tp-slicey  tp-resizeme"
                                         id="slide-180-layer-34"
                                         data-x="['center','center','center','center']" data-hoffset="['-186','-119','273','-223']"
                                         data-y="['middle','middle','middle','middle']" data-voffset="['269','217','-121','69']"
                                         data-width="['300','300','150','150']"
                                         data-height="['200','200','150','150']"
                                         data-whitespace="nowrap"

                                         data-type="shape"
                                         data-slicey_offset="250"
                                         data-slicey_blurstart="0"
                                         data-slicey_blurend="20"
                                         data-responsive_offset="on"

                                         data-frames='[{"delay":500,"speed":1000,"frame":"0","from":"sX:1;sY:1;opacity:0;fb:20px;","to":"o:1;fb:0;","ease":"Power3.easeInOut"},{"delay":"+3500","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]'
                                         data-textAlign="['inherit','inherit','inherit','inherit']"
                                         data-paddingtop="[0,0,0,0]"
                                         data-paddingright="[0,0,0,0]"
                                         data-paddingbottom="[0,0,0,0]"
                                         data-paddingleft="[0,0,0,0]"

                                         style="z-index: 9;background-color:rgba(0,0,0,0.5);"> </div>

                                    <!-- LAYER NR. 6 -->
                                    <div class="tp-caption tp-shape tp-shapewrapper tp-slicey  tp-resizeme"
                                         id="slide-180-layer-11"
                                         data-x="['center','center','center','center']" data-hoffset="['-325','292','162','-34']"
                                         data-y="['middle','middle','middle','middle']" data-voffset="['3','55','-275','-174']"
                                         data-width="150"
                                         data-height="['250','150','50','50']"
                                         data-whitespace="nowrap"

                                         data-type="shape"
                                         data-slicey_offset="250"
                                         data-slicey_blurstart="0"
                                         data-slicey_blurend="20"
                                         data-responsive_offset="on"

                                         data-frames='[{"delay":550,"speed":1000,"frame":"0","from":"opacity:0;fb:20px;","to":"o:1;fb:0;","ease":"Power3.easeInOut"},{"delay":"+3450","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]'
                                         data-textAlign="['inherit','inherit','inherit','inherit']"
                                         data-paddingtop="[0,0,0,0]"
                                         data-paddingright="[0,0,0,0]"
                                         data-paddingbottom="[0,0,0,0]"
                                         data-paddingleft="[0,0,0,0]"

                                         style="z-index: 10;background-color:rgba(0,0,0,0.5);"> </div>

                                    <!-- LAYER NR. 7 -->
                                    <div class="tp-caption tp-shape tp-shapewrapper tp-slicey  tp-resizeme"
                                         id="slide-180-layer-27"
                                         data-x="['center','center','center','center']" data-hoffset="['-429','523','-190','-306']"
                                         data-y="['middle','middle','middle','middle']" data-voffset="['-327','173','181','480']"
                                         data-width="['250','250','150','150']"
                                         data-height="['300','300','150','150']"
                                         data-whitespace="nowrap"

                                         data-type="shape"
                                         data-slicey_offset="300"
                                         data-slicey_blurstart="0"
                                         data-slicey_blurend="20"
                                         data-responsive_offset="on"

                                         data-frames='[{"delay":320,"speed":1000,"frame":"0","from":"sX:1;sY:1;opacity:0;fb:20px;","to":"o:1;fb:0;","ease":"Power3.easeInOut"},{"delay":"+3680","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]'
                                         data-textAlign="['inherit','inherit','inherit','inherit']"
                                         data-paddingtop="[0,0,0,0]"
                                         data-paddingright="[0,0,0,0]"
                                         data-paddingbottom="[0,0,0,0]"
                                         data-paddingleft="[0,0,0,0]"

                                         style="z-index: 11;background-color:rgba(0,0,0,0.5);"> </div>

                                    <!-- LAYER NR. 8 -->
                                    <div class="tp-caption tp-shape tp-shapewrapper tp-slicey  tp-resizeme"
                                         id="slide-180-layer-28"
                                         data-x="['center','center','center','center']" data-hoffset="['422','-409','208','225']"
                                         data-y="['middle','middle','middle','middle']" data-voffset="['-245','-72','294','-14']"
                                         data-width="['300','300','150','150']"
                                         data-height="['250','250','100','100']"
                                         data-whitespace="nowrap"

                                         data-type="shape"
                                         data-slicey_offset="300"
                                         data-slicey_blurstart="0"
                                         data-slicey_blurend="20"
                                         data-responsive_offset="on"

                                         data-frames='[{"delay":360,"speed":1000,"frame":"0","from":"sX:1;sY:1;opacity:0;fb:20px;","to":"o:1;fb:0;","ease":"Power3.easeInOut"},{"delay":"+3640","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]'
                                         data-textAlign="['inherit','inherit','inherit','inherit']"
                                         data-paddingtop="[0,0,0,0]"
                                         data-paddingright="[0,0,0,0]"
                                         data-paddingbottom="[0,0,0,0]"
                                         data-paddingleft="[0,0,0,0]"

                                         style="z-index: 12;background-color:rgba(0,0,0,0.5);"> </div>

                                    <!-- LAYER NR. 9 -->
                                    <div class="tp-caption tp-shape tp-shapewrapper tp-slicey  tp-resizeme"
                                         id="slide-180-layer-30"
                                         data-x="['center','center','center','center']" data-hoffset="['549','-445','28','58']"
                                         data-y="['middle','middle','middle','middle']" data-voffset="['236','400','316','287']"
                                         data-width="['300','300','150','200']"
                                         data-height="['250','250','150','50']"
                                         data-whitespace="nowrap"

                                         data-type="shape"
                                         data-slicey_offset="300"
                                         data-slicey_blurstart="0"
                                         data-slicey_blurend="20"
                                         data-responsive_offset="on"

                                         data-frames='[{"delay":400,"speed":1000,"frame":"0","from":"sX:1;sY:1;opacity:0;fb:20px;","to":"o:1;fb:0;","ease":"Power3.easeInOut"},{"delay":"+3600","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]'
                                         data-textAlign="['inherit','inherit','inherit','inherit']"
                                         data-paddingtop="[0,0,0,0]"
                                         data-paddingright="[0,0,0,0]"
                                         data-paddingbottom="[0,0,0,0]"
                                         data-paddingleft="[0,0,0,0]"

                                         style="z-index: 13;background-color:rgba(0,0,0,0.5);"> </div>

                                    <!-- LAYER NR. 10 -->
                                    <div class="tp-caption tp-shape tp-shapewrapper tp-slicey  tp-resizeme"
                                         id="slide-180-layer-31"
                                         data-x="['center','center','center','center']" data-hoffset="['-522','492','-151','262']"
                                         data-y="['middle','middle','middle','middle']" data-voffset="['339','-180','330','-141']"
                                         data-width="['300','300','150','150']"
                                         data-height="['250','250','100','100']"
                                         data-whitespace="nowrap"

                                         data-type="shape"
                                         data-slicey_offset="300"
                                         data-slicey_blurstart="0"
                                         data-slicey_blurend="20"
                                         data-responsive_offset="on"

                                         data-frames='[{"delay":440,"speed":1000,"frame":"0","from":"sX:1;sY:1;opacity:0;fb:20px;","to":"o:1;fb:0;","ease":"Power3.easeInOut"},{"delay":"+3560","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]'
                                         data-textAlign="['inherit','inherit','inherit','inherit']"
                                         data-paddingtop="[0,0,0,0]"
                                         data-paddingright="[0,0,0,0]"
                                         data-paddingbottom="[0,0,0,0]"
                                         data-paddingleft="[0,0,0,0]"

                                         style="z-index: 14;background-color:rgba(0,0,0,0.5);"> </div>

                                    <!-- LAYER NR. 11 -->
                                    <div class="tp-caption tp-shape tp-shapewrapper tp-slicey  tp-resizeme"
                                         id="slide-180-layer-32"
                                         data-x="['center','center','center','center']" data-hoffset="['-588','-375','-253','-207']"
                                         data-y="['middle','middle','middle','middle']" data-voffset="['72','-328','-172','-111']"
                                         data-width="['300','300','150','150']"
                                         data-height="['200','200','150','150']"
                                         data-whitespace="nowrap"

                                         data-type="shape"
                                         data-slicey_offset="300"
                                         data-slicey_blurstart="0"
                                         data-slicey_blurend="20"
                                         data-responsive_offset="on"

                                         data-frames='[{"delay":480,"speed":1000,"frame":"0","from":"sX:1;sY:1;opacity:0;fb:20px;","to":"o:1;fb:0;","ease":"Power3.easeInOut"},{"delay":"+3520","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]'
                                         data-textAlign="['inherit','inherit','inherit','inherit']"
                                         data-paddingtop="[0,0,0,0]"
                                         data-paddingright="[0,0,0,0]"
                                         data-paddingbottom="[0,0,0,0]"
                                         data-paddingleft="[0,0,0,0]"

                                         style="z-index: 15;background-color:rgba(0,0,0,0.5);"> </div>

                                    <!-- LAYER NR. 12 -->
                                    <div class="tp-caption tp-shape tp-shapewrapper tp-slicey  tp-resizeme"
                                         id="slide-180-layer-33"
                                         data-x="['center','center','center','center']" data-hoffset="['-37','73','-76','-100']"
                                         data-y="['middle','middle','middle','middle']" data-voffset="['-401','-340','-293','-246']"
                                         data-width="['450','400','250','250']"
                                         data-height="['100','100','50','50']"
                                         data-whitespace="nowrap"

                                         data-type="shape"
                                         data-slicey_offset="250"
                                         data-slicey_blurstart="0"
                                         data-slicey_blurend="20"
                                         data-responsive_offset="on"

                                         data-frames='[{"delay":310,"speed":1000,"frame":"0","from":"sX:1;sY:1;opacity:0;fb:20px;","to":"o:1;fb:0;","ease":"Power3.easeInOut"},{"delay":"+3690","speed":430,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]'
                                         data-textAlign="['inherit','inherit','inherit','inherit']"
                                         data-paddingtop="[0,0,0,0]"
                                         data-paddingright="[0,0,0,0]"
                                         data-paddingbottom="[0,0,0,0]"
                                         data-paddingleft="[0,0,0,0]"

                                         style="z-index: 16;background-color:rgba(0,0,0,0.5);"> </div>

                                    <!-- LAYER NR. 13 -->
                                    <div class="tp-caption tp-shape tp-shapewrapper tp-slicey  tp-resizeme"
                                         id="slide-180-layer-35"
                                         data-x="['center','center','center','center']" data-hoffset="['186','38','116','17']"
                                         data-y="['middle','middle','middle','middle']" data-voffset="['363','402','190','395']"
                                         data-width="['350','400','250','250']"
                                         data-height="['100','100','50','50']"
                                         data-whitespace="nowrap"

                                         data-type="shape"
                                         data-slicey_offset="250"
                                         data-slicey_blurstart="0"
                                         data-slicey_blurend="20"
                                         data-responsive_offset="on"

                                         data-frames='[{"delay":340,"speed":1000,"frame":"0","from":"sX:1;sY:1;opacity:0;fb:20px;","to":"o:1;fb:0;","ease":"Power3.easeInOut"},{"delay":"+3660","speed":450,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]'
                                         data-textAlign="['inherit','inherit','inherit','inherit']"
                                         data-paddingtop="[0,0,0,0]"
                                         data-paddingright="[0,0,0,0]"
                                         data-paddingbottom="[0,0,0,0]"
                                         data-paddingleft="[0,0,0,0]"

                                         style="z-index: 17;background-color:rgba(0,0,0,0.5);"> </div>

                                    <!-- LAYER NR. 14 -->
                                    <div class="tp-caption tp-shape tp-shapewrapper "
                                         id="slide-180-layer-1"
                                         data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']"
                                         data-y="['middle','middle','middle','middle']" data-voffset="['0','0','0','0']"
                                         data-width="full"
                                         data-height="full"
                                         data-whitespace="nowrap"

                                         data-type="shape"
                                         data-basealign="slide"
                                         data-responsive_offset="off"
                                         data-responsive="off"
                                         data-frames='[{"delay":10,"speed":500,"frame":"0","from":"opacity:0;","to":"o:1;","ease":"Power4.easeOut"},{"delay":"wait","speed":590,"frame":"999","to":"opacity:0;","ease":"Power2.easeIn"}]'
                                         data-textAlign="['inherit','inherit','inherit','inherit']"
                                         data-paddingtop="[0,0,0,0]"
                                         data-paddingright="[0,0,0,0]"
                                         data-paddingbottom="[0,0,0,0]"
                                         data-paddingleft="[0,0,0,0]"

                                         style="z-index: 18;background-color:rgba(0,0,0,0.5);"> </div>

                                    <?php
                                        if(!empty($slide['title'])){
                                            ?>
                                            <!-- LAYER NR. 15 -->
                                            <div class="tp-caption   tp-resizeme" 
             id="slide-180-layer-2" 
             data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']" 
             data-y="['middle','middle','middle','middle']" data-voffset="['-101','-85','-94','-104']" 
                        data-fontsize="['45','45','36','32']"
            data-lineheight="['50','50','50','37']"
            data-width="['90%','90%','95%','95%']"
            data-height="none"
            data-whitespace="normal"
 
            data-type="text" 
            data-responsive_offset="on" 

            data-frames='[{"delay":1000,"speed":2000,"frame":"0","from":"sX:0.9;sY:0.9;opacity:0;fb:20px;","to":"o:1;fb:0;","ease":"Power3.easeInOut"},{"delay":"wait","speed":540,"frame":"999","to":"sX:0.9;sY:0.9;opacity:0;fb:20px;","ease":"Power3.easeInOut"}]'
            data-textAlign="['center','center','center','center']"
            data-paddingtop="[0,0,0,0]"
            data-paddingright="[0,0,0,0]"
            data-paddingbottom="[0,0,0,0]"
            data-paddingleft="[0,0,0,0]"

            style="z-index: 19; min-width: 90%; max-width: 90%; white-space: normal; font-size: 45px; line-height: 50px; font-weight: 800; color: #ffffff; letter-spacing: -2px;font-family:Raleway;"><?php echo $slide['title']; ?> </div>
                                            <?php
                                        }
                                    ?>

                                    <?php
                                        if(!empty($slide['description'])){
                                            ?>
                                            <!-- LAYER NR. 16 -->
                                            <div class="tp-caption   tp-resizeme" 
             id="slide-180-layer-3" 
             data-x="['center','center','center','center']" data-hoffset="['0','0','0','-1']" 
             data-y="['middle','middle','middle','middle']" data-voffset="['-12','-3','-1','-8']" 
                        data-fontsize="['20','20','20','17']"
            data-lineheight="['35','35','26','25']"
            data-fontweight="['300','300','300','400']"
            data-width="['90%','90%','90%','95%']"
            data-height="none"
            data-whitespace="normal"
 
            data-type="text" 
            data-responsive_offset="on" 

            data-frames='[{"delay":1000,"speed":2000,"frame":"0","from":"sX:0.9;sY:0.9;opacity:0;fb:20px;","to":"o:1;fb:0;","ease":"Power3.easeInOut"},{"delay":"wait","speed":560,"frame":"999","to":"sX:0.9;sY:0.9;opacity:0;fb:20px;","ease":"Power3.easeInOut"}]'
            data-textAlign="['center','center','center','center']"
            data-paddingtop="[0,0,0,0]"
            data-paddingright="[0,0,0,0]"
            data-paddingbottom="[0,0,0,0]"
            data-paddingleft="[0,0,0,0]"

            style="z-index: 20; min-width: 90%; max-width: 90%; white-space: normal; font-size: 20px; line-height: 35px; font-weight: 300; color: #ffffff; letter-spacing: 0px;font-family:Raleway;"><?php echo $slide['description']; ?> </div>
                                            <?php
                                        }
                                    ?>

                                    <?php
                                        if(!empty($slide['link'])){
                                            ?>
                                            <!-- LAYER NR. 17 -->
                                            <a class="tp-caption rev-btn  tp-resizeme"
                                               href="<?php echo $slide['link']; ?>" target="_blank" id="slide-180-layer-7"
                                               data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']" 
             data-y="['middle','middle','middle','middle']" data-voffset="['75','75','85','86']" 
                        data-width="none"
            data-height="none"
            data-whitespace="nowrap"
 
            data-type="button" 
            data-actions=''
            data-responsive_offset="on" 

            data-frames='[{"delay":1000,"speed":2000,"frame":"0","from":"sX:0.9;sY:0.9;opacity:0;fb:20px;","to":"o:1;fb:0;","ease":"Power3.easeInOut"},{"delay":"wait","speed":570,"frame":"999","to":"sX:0.9;sY:0.9;opacity:0;fb:20px;","ease":"Power3.easeInOut"},{"frame":"hover","speed":"300","ease":"Power1.easeOut","to":"o:1;rX:0;rY:0;rZ:0;z:0;fb:0;","style":"c:rgb(0,0,0);bg:rgb(255,255,255);"}]'
            data-textAlign="['center','center','center','center']"
            data-paddingtop="[0,0,0,0]"
            data-paddingright="[50,50,50,50]"
            data-paddingbottom="[0,0,0,0]"
            data-paddingleft="[50,50,50,50]"

            style="z-index: 21; white-space: nowrap; font-size: 16px; line-height: 50px; font-weight: 300; color: #ffffff; letter-spacing: ;font-family:Raleway;background-color:rgba(87,202,133,0);border-color:rgb(255,255,255);border-style:solid;border-width:2px 2px 2px 2px;border-radius:30px 30px 30px 30px;outline:none;box-shadow:none;box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;cursor:pointer;text-decoration: none;"><?php echo __("website/index/slider-button-text"); ?> </a>
                                            <?php
                                        }
                                    ?>

                                </li>
                                <!-- SLIDE -->
                                <?php
                            }
                            else{
                                ?>
                                <!-- SLIDE -->
                                <li data-index="rs-<?php echo $k; ?>" data-transition="fade" data-slotamount="default" data-hideafterloop="0" data-hideslideonmobile="off"  data-easein="default" data-easeout="default" data-masterspeed="600"  data-thumb="<?php echo $tadress; ?>assets/transparent.png"  data-delay="7320"  data-rotate="0"  data-saveperformance="off"  data-title="Slide" data-param1="" data-param2="" data-param3="" data-param4="" data-param5="" data-param6="" data-param7="" data-param8="" data-param9="" data-param10="" data-description="" data-slicey_shadow="0px 0px 0px 0px transparent">
                                    <!-- MAIN IMAGE -->
                                    <img src="<?php echo $slide['image']; ?>"  alt=""  width="1920" height="1080" data-bgposition="center center" data-kenburns="on" data-duration="5000" data-ease="Power2.easeInOut" data-scalestart="100" data-scaleend="150" data-rotatestart="0" data-rotateend="0" data-blurstart="20" data-blurend="0" data-offsetstart="0 0" data-offsetend="0 0" class="rev-slidebg" data-no-retina>
                                    <!-- LAYERS -->

                                    <!-- LAYER NR. 18 -->
                                    <div class="tp-caption tp-shape tp-shapewrapper tp-slicey  tp-resizeme"
                                         id="slide-181-layer-9"
                                         data-x="['center','center','center','center']" data-hoffset="['-112','-43','-81','44']"
                                         data-y="['middle','middle','middle','middle']" data-voffset="['-219','-184','-185','182']"
                                         data-width="['250','250','150','150']"
                                         data-height="['150','150','100','100']"
                                         data-whitespace="nowrap"

                                         data-type="shape"
                                         data-slicey_offset="250"
                                         data-slicey_blurstart="0"
                                         data-slicey_blurend="20"
                                         data-responsive_offset="on"

                                         data-frames='[{"delay":300,"speed":1000,"frame":"0","from":"rX:0deg;rY:0deg;rZ:0deg;sX:1;sY:1;opacity:0;fb:20px;","to":"o:1;fb:0;","ease":"Power3.easeInOut"},{"delay":"+3700","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]'
                                         data-textAlign="['inherit','inherit','inherit','inherit']"
                                         data-paddingtop="[0,0,0,0]"
                                         data-paddingright="[0,0,0,0]"
                                         data-paddingbottom="[0,0,0,0]"
                                         data-paddingleft="[0,0,0,0]"

                                         style="z-index: 5;background-color:rgba(0,0,0,0.5);"> </div>

                                    <!-- LAYER NR. 19 -->
                                    <div class="tp-caption tp-shape tp-shapewrapper tp-slicey  tp-resizeme"
                                         id="slide-181-layer-10"
                                         data-x="['center','center','center','center']" data-hoffset="['151','228','224','117']"
                                         data-y="['middle','middle','middle','middle']" data-voffset="['-212','-159','71','-222']"
                                         data-width="['150','150','100','100']"
                                         data-height="['200','150','150','150']"
                                         data-whitespace="nowrap"

                                         data-type="shape"
                                         data-slicey_offset="250"
                                         data-slicey_blurstart="0"
                                         data-slicey_blurend="20"
                                         data-responsive_offset="on"

                                         data-frames='[{"delay":350,"speed":1000,"frame":"0","from":"sX:1;sY:1;opacity:0;fb:20px;","to":"o:1;fb:0;","ease":"Power3.easeInOut"},{"delay":"+3650","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]'
                                         data-textAlign="['inherit','inherit','inherit','inherit']"
                                         data-paddingtop="[0,0,0,0]"
                                         data-paddingright="[0,0,0,0]"
                                         data-paddingbottom="[0,0,0,0]"
                                         data-paddingleft="[0,0,0,0]"

                                         style="z-index: 6;background-color:rgba(0,0,0,0.5);"> </div>

                                    <!-- LAYER NR. 20 -->
                                    <div class="tp-caption tp-shape tp-shapewrapper tp-slicey  tp-resizeme"
                                         id="slide-181-layer-29"
                                         data-x="['center','center','center','center']" data-hoffset="['339','-442','104','-159']"
                                         data-y="['middle','middle','middle','middle']" data-voffset="['2','165','-172','219']"
                                         data-width="['250','250','150','150']"
                                         data-height="['150','150','100','100']"
                                         data-whitespace="nowrap"

                                         data-type="shape"
                                         data-slicey_offset="250"
                                         data-slicey_blurstart="0"
                                         data-slicey_blurend="20"
                                         data-responsive_offset="on"

                                         data-frames='[{"delay":400,"speed":1000,"frame":"0","from":"sX:1;sY:1;opacity:0;fb:20px;","to":"o:1;fb:0;","ease":"Power3.easeInOut"},{"delay":"+3600","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]'
                                         data-textAlign="['inherit','inherit','inherit','inherit']"
                                         data-paddingtop="[0,0,0,0]"
                                         data-paddingright="[0,0,0,0]"
                                         data-paddingbottom="[0,0,0,0]"
                                         data-paddingleft="[0,0,0,0]"

                                         style="z-index: 7;background-color:rgba(0,0,0,0.5);"> </div>

                                    <!-- LAYER NR. 21 -->
                                    <div class="tp-caption tp-shape tp-shapewrapper tp-slicey  tp-resizeme"
                                         id="slide-181-layer-12"
                                         data-x="['center','center','center','center']" data-hoffset="['162','216','-239','193']"
                                         data-y="['middle','middle','middle','middle']" data-voffset="['195','245','6','146']"
                                         data-width="['250','250','100','100']"
                                         data-height="150"
                                         data-whitespace="nowrap"

                                         data-type="shape"
                                         data-slicey_offset="250"
                                         data-slicey_blurstart="0"
                                         data-slicey_blurend="20"
                                         data-responsive_offset="on"

                                         data-frames='[{"delay":450,"speed":1000,"frame":"0","from":"opacity:0;fb:20px;","to":"o:1;fb:0;","ease":"Power3.easeInOut"},{"delay":"+3550","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]'
                                         data-textAlign="['inherit','inherit','inherit','inherit']"
                                         data-paddingtop="[0,0,0,0]"
                                         data-paddingright="[0,0,0,0]"
                                         data-paddingbottom="[0,0,0,0]"
                                         data-paddingleft="[0,0,0,0]"

                                         style="z-index: 8;background-color:rgba(0,0,0,0.5);"> </div>

                                    <!-- LAYER NR. 22 -->
                                    <div class="tp-caption tp-shape tp-shapewrapper tp-slicey  tp-resizeme"
                                         id="slide-181-layer-34"
                                         data-x="['center','center','center','center']" data-hoffset="['-186','-119','273','-223']"
                                         data-y="['middle','middle','middle','middle']" data-voffset="['269','217','-121','69']"
                                         data-width="['300','300','150','150']"
                                         data-height="['200','200','150','150']"
                                         data-whitespace="nowrap"

                                         data-type="shape"
                                         data-slicey_offset="250"
                                         data-slicey_blurstart="0"
                                         data-slicey_blurend="20"
                                         data-responsive_offset="on"

                                         data-frames='[{"delay":500,"speed":1000,"frame":"0","from":"sX:1;sY:1;opacity:0;fb:20px;","to":"o:1;fb:0;","ease":"Power3.easeInOut"},{"delay":"+3500","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]'
                                         data-textAlign="['inherit','inherit','inherit','inherit']"
                                         data-paddingtop="[0,0,0,0]"
                                         data-paddingright="[0,0,0,0]"
                                         data-paddingbottom="[0,0,0,0]"
                                         data-paddingleft="[0,0,0,0]"

                                         style="z-index: 9;background-color:rgba(0,0,0,0.5);"> </div>

                                    <!-- LAYER NR. 23 -->
                                    <div class="tp-caption tp-shape tp-shapewrapper tp-slicey  tp-resizeme"
                                         id="slide-181-layer-11"
                                         data-x="['center','center','center','center']" data-hoffset="['-325','292','162','-34']"
                                         data-y="['middle','middle','middle','middle']" data-voffset="['3','55','-275','-174']"
                                         data-width="150"
                                         data-height="['250','150','50','50']"
                                         data-whitespace="nowrap"

                                         data-type="shape"
                                         data-slicey_offset="250"
                                         data-slicey_blurstart="0"
                                         data-slicey_blurend="20"
                                         data-responsive_offset="on"

                                         data-frames='[{"delay":550,"speed":1000,"frame":"0","from":"opacity:0;fb:20px;","to":"o:1;fb:0;","ease":"Power3.easeInOut"},{"delay":"+3450","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]'
                                         data-textAlign="['inherit','inherit','inherit','inherit']"
                                         data-paddingtop="[0,0,0,0]"
                                         data-paddingright="[0,0,0,0]"
                                         data-paddingbottom="[0,0,0,0]"
                                         data-paddingleft="[0,0,0,0]"

                                         style="z-index: 10;background-color:rgba(0,0,0,0.5);"> </div>

                                    <!-- LAYER NR. 24 -->
                                    <div class="tp-caption tp-shape tp-shapewrapper tp-slicey  tp-resizeme"
                                         id="slide-181-layer-27"
                                         data-x="['center','center','center','center']" data-hoffset="['-429','523','-190','-306']"
                                         data-y="['middle','middle','middle','middle']" data-voffset="['-327','173','181','480']"
                                         data-width="['250','250','150','150']"
                                         data-height="['300','300','150','150']"
                                         data-whitespace="nowrap"

                                         data-type="shape"
                                         data-slicey_offset="300"
                                         data-slicey_blurstart="0"
                                         data-slicey_blurend="20"
                                         data-responsive_offset="on"

                                         data-frames='[{"delay":320,"speed":1000,"frame":"0","from":"sX:1;sY:1;opacity:0;fb:20px;","to":"o:1;fb:0;","ease":"Power3.easeInOut"},{"delay":"+3680","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]'
                                         data-textAlign="['inherit','inherit','inherit','inherit']"
                                         data-paddingtop="[0,0,0,0]"
                                         data-paddingright="[0,0,0,0]"
                                         data-paddingbottom="[0,0,0,0]"
                                         data-paddingleft="[0,0,0,0]"

                                         style="z-index: 11;background-color:rgba(0,0,0,0.5);"> </div>

                                    <!-- LAYER NR. 25 -->
                                    <div class="tp-caption tp-shape tp-shapewrapper tp-slicey  tp-resizeme"
                                         id="slide-181-layer-28"
                                         data-x="['center','center','center','center']" data-hoffset="['422','-409','208','225']"
                                         data-y="['middle','middle','middle','middle']" data-voffset="['-245','-72','294','-14']"
                                         data-width="['300','300','150','150']"
                                         data-height="['250','250','100','100']"
                                         data-whitespace="nowrap"

                                         data-type="shape"
                                         data-slicey_offset="300"
                                         data-slicey_blurstart="0"
                                         data-slicey_blurend="20"
                                         data-responsive_offset="on"

                                         data-frames='[{"delay":360,"speed":1000,"frame":"0","from":"sX:1;sY:1;opacity:0;fb:20px;","to":"o:1;fb:0;","ease":"Power3.easeInOut"},{"delay":"+3640","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]'
                                         data-textAlign="['inherit','inherit','inherit','inherit']"
                                         data-paddingtop="[0,0,0,0]"
                                         data-paddingright="[0,0,0,0]"
                                         data-paddingbottom="[0,0,0,0]"
                                         data-paddingleft="[0,0,0,0]"

                                         style="z-index: 12;background-color:rgba(0,0,0,0.5);"> </div>

                                    <!-- LAYER NR. 26 -->
                                    <div class="tp-caption tp-shape tp-shapewrapper tp-slicey  tp-resizeme"
                                         id="slide-181-layer-30"
                                         data-x="['center','center','center','center']" data-hoffset="['549','-445','28','58']"
                                         data-y="['middle','middle','middle','middle']" data-voffset="['236','400','316','287']"
                                         data-width="['300','300','150','200']"
                                         data-height="['250','250','150','50']"
                                         data-whitespace="nowrap"

                                         data-type="shape"
                                         data-slicey_offset="300"
                                         data-slicey_blurstart="0"
                                         data-slicey_blurend="20"
                                         data-responsive_offset="on"

                                         data-frames='[{"delay":400,"speed":1000,"frame":"0","from":"sX:1;sY:1;opacity:0;fb:20px;","to":"o:1;fb:0;","ease":"Power3.easeInOut"},{"delay":"+3600","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]'
                                         data-textAlign="['inherit','inherit','inherit','inherit']"
                                         data-paddingtop="[0,0,0,0]"
                                         data-paddingright="[0,0,0,0]"
                                         data-paddingbottom="[0,0,0,0]"
                                         data-paddingleft="[0,0,0,0]"

                                         style="z-index: 13;background-color:rgba(0,0,0,0.5);"> </div>

                                    <!-- LAYER NR. 27 -->
                                    <div class="tp-caption tp-shape tp-shapewrapper tp-slicey  tp-resizeme"
                                         id="slide-181-layer-31"
                                         data-x="['center','center','center','center']" data-hoffset="['-522','492','-151','262']"
                                         data-y="['middle','middle','middle','middle']" data-voffset="['339','-180','330','-141']"
                                         data-width="['300','300','150','150']"
                                         data-height="['250','250','100','100']"
                                         data-whitespace="nowrap"

                                         data-type="shape"
                                         data-slicey_offset="300"
                                         data-slicey_blurstart="0"
                                         data-slicey_blurend="20"
                                         data-responsive_offset="on"

                                         data-frames='[{"delay":440,"speed":1000,"frame":"0","from":"sX:1;sY:1;opacity:0;fb:20px;","to":"o:1;fb:0;","ease":"Power3.easeInOut"},{"delay":"+3560","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]'
                                         data-textAlign="['inherit','inherit','inherit','inherit']"
                                         data-paddingtop="[0,0,0,0]"
                                         data-paddingright="[0,0,0,0]"
                                         data-paddingbottom="[0,0,0,0]"
                                         data-paddingleft="[0,0,0,0]"

                                         style="z-index: 14;background-color:rgba(0,0,0,0.5);"> </div>

                                    <!-- LAYER NR. 28 -->
                                    <div class="tp-caption tp-shape tp-shapewrapper tp-slicey  tp-resizeme"
                                         id="slide-181-layer-32"
                                         data-x="['center','center','center','center']" data-hoffset="['-588','-375','-253','-207']"
                                         data-y="['middle','middle','middle','middle']" data-voffset="['72','-328','-172','-111']"
                                         data-width="['300','300','150','150']"
                                         data-height="['200','200','150','150']"
                                         data-whitespace="nowrap"

                                         data-type="shape"
                                         data-slicey_offset="300"
                                         data-slicey_blurstart="0"
                                         data-slicey_blurend="20"
                                         data-responsive_offset="on"

                                         data-frames='[{"delay":480,"speed":1000,"frame":"0","from":"sX:1;sY:1;opacity:0;fb:20px;","to":"o:1;fb:0;","ease":"Power3.easeInOut"},{"delay":"+3520","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]'
                                         data-textAlign="['inherit','inherit','inherit','inherit']"
                                         data-paddingtop="[0,0,0,0]"
                                         data-paddingright="[0,0,0,0]"
                                         data-paddingbottom="[0,0,0,0]"
                                         data-paddingleft="[0,0,0,0]"

                                         style="z-index: 15;background-color:rgba(0,0,0,0.5);"> </div>

                                    <!-- LAYER NR. 29 -->
                                    <div class="tp-caption tp-shape tp-shapewrapper tp-slicey  tp-resizeme"
                                         id="slide-181-layer-33"
                                         data-x="['center','center','center','center']" data-hoffset="['-37','73','-76','-100']"
                                         data-y="['middle','middle','middle','middle']" data-voffset="['-401','-340','-293','-246']"
                                         data-width="['450','400','250','250']"
                                         data-height="['100','100','50','50']"
                                         data-whitespace="nowrap"

                                         data-type="shape"
                                         data-slicey_offset="250"
                                         data-slicey_blurstart="0"
                                         data-slicey_blurend="20"
                                         data-responsive_offset="on"

                                         data-frames='[{"delay":310,"speed":1000,"frame":"0","from":"sX:1;sY:1;opacity:0;fb:20px;","to":"o:1;fb:0;","ease":"Power3.easeInOut"},{"delay":"+3690","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]'
                                         data-textAlign="['inherit','inherit','inherit','inherit']"
                                         data-paddingtop="[0,0,0,0]"
                                         data-paddingright="[0,0,0,0]"
                                         data-paddingbottom="[0,0,0,0]"
                                         data-paddingleft="[0,0,0,0]"

                                         style="z-index: 16;background-color:rgba(0,0,0,0.5);"> </div>

                                    <!-- LAYER NR. 30 -->
                                    <div class="tp-caption tp-shape tp-shapewrapper tp-slicey  tp-resizeme"
                                         id="slide-181-layer-35"
                                         data-x="['center','center','center','center']" data-hoffset="['186','38','116','17']"
                                         data-y="['middle','middle','middle','middle']" data-voffset="['363','402','190','395']"
                                         data-width="['350','400','250','250']"
                                         data-height="['100','100','50','50']"
                                         data-whitespace="nowrap"

                                         data-type="shape"
                                         data-slicey_offset="250"
                                         data-slicey_blurstart="0"
                                         data-slicey_blurend="20"
                                         data-responsive_offset="on"

                                         data-frames='[{"delay":340,"speed":1000,"frame":"0","from":"sX:1;sY:1;opacity:0;fb:20px;","to":"o:1;fb:0;","ease":"Power3.easeInOut"},{"delay":"+3660","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]'
                                         data-textAlign="['inherit','inherit','inherit','inherit']"
                                         data-paddingtop="[0,0,0,0]"
                                         data-paddingright="[0,0,0,0]"
                                         data-paddingbottom="[0,0,0,0]"
                                         data-paddingleft="[0,0,0,0]"

                                         style="z-index: 17;background-color:rgba(0,0,0,0.5);"> </div>

                                    <!-- LAYER NR. 31 -->
                                    <div class="tp-caption tp-shape tp-shapewrapper "
                                         id="slide-181-layer-1"
                                         data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']"
                                         data-y="['middle','middle','middle','middle']" data-voffset="['0','0','0','0']"
                                         data-width="full"
                                         data-height="full"
                                         data-whitespace="nowrap"

                                         data-type="shape"
                                         data-basealign="slide"
                                         data-responsive_offset="off"
                                         data-responsive="off"
                                         data-frames='[{"delay":10,"speed":500,"frame":"0","from":"opacity:0;","to":"o:1;","ease":"Power4.easeOut"},{"delay":"wait","speed":1070,"frame":"999","to":"opacity:0;","ease":"Power4.easeOut"}]'
                                         data-textAlign="['inherit','inherit','inherit','inherit']"
                                         data-paddingtop="[0,0,0,0]"
                                         data-paddingright="[0,0,0,0]"
                                         data-paddingbottom="[0,0,0,0]"
                                         data-paddingleft="[0,0,0,0]"

                                         style="z-index: 18;background-color:rgba(0,0,0,0.5);"> </div>

                                    <?php
                                        if(!empty($slide['title'])){
                                            ?>
                                            <!-- LAYER NR. 32 -->
                                            <div class="tp-caption   tp-resizeme" 
             id="slide-180-layer-2" 
             data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']" 
             data-y="['middle','middle','middle','middle']" data-voffset="['-101','-85','-94','-104']" 
                        data-fontsize="['45','45','36','32']"
            data-lineheight="['50','50','50','37']"
            data-width="['90%','90%','95%','95%']"
            data-height="none"
            data-whitespace="normal"
 
            data-type="text" 
            data-responsive_offset="on" 

            data-frames='[{"delay":1000,"speed":2000,"frame":"0","from":"sX:0.9;sY:0.9;opacity:0;fb:20px;","to":"o:1;fb:0;","ease":"Power3.easeInOut"},{"delay":"wait","speed":540,"frame":"999","to":"sX:0.9;sY:0.9;opacity:0;fb:20px;","ease":"Power3.easeInOut"}]'
            data-textAlign="['center','center','center','center']"
            data-paddingtop="[0,0,0,0]"
            data-paddingright="[0,0,0,0]"
            data-paddingbottom="[0,0,0,0]"
            data-paddingleft="[0,0,0,0]"

            style="z-index: 19; min-width: 90%; max-width: 90%; white-space: normal; font-size: 45px; line-height: 50px; font-weight: 800; color: #ffffff; letter-spacing: -2px;font-family:Raleway;"><?php echo $slide['title']; ?> </div>
                                            <?php
                                        }
                                    ?>

                                    <?php
                                        if(!empty($slide['description'])){
                                            ?>
                                            <!-- LAYER NR. 33 -->
                                            <div class="tp-caption   tp-resizeme" 
             id="slide-180-layer-3" 
             data-x="['center','center','center','center']" data-hoffset="['0','0','0','-1']" 
             data-y="['middle','middle','middle','middle']" data-voffset="['-12','-3','-1','-8']" 
                        data-fontsize="['20','20','20','17']"
            data-lineheight="['35','35','26','25']"
            data-fontweight="['300','300','300','400']"
            data-width="['90%','90%','90%','95%']"
            data-height="none"
            data-whitespace="normal"
 
            data-type="text" 
            data-responsive_offset="on" 

            data-frames='[{"delay":1000,"speed":2000,"frame":"0","from":"sX:0.9;sY:0.9;opacity:0;fb:20px;","to":"o:1;fb:0;","ease":"Power3.easeInOut"},{"delay":"wait","speed":560,"frame":"999","to":"sX:0.9;sY:0.9;opacity:0;fb:20px;","ease":"Power3.easeInOut"}]'
            data-textAlign="['center','center','center','center']"
            data-paddingtop="[0,0,0,0]"
            data-paddingright="[0,0,0,0]"
            data-paddingbottom="[0,0,0,0]"
            data-paddingleft="[0,0,0,0]"

            style="z-index: 20; min-width: 90%; max-width: 90%; white-space: normal; font-size: 20px; line-height: 35px; font-weight: 300; color: #ffffff; letter-spacing: 0px;font-family:Raleway;"><?php echo $slide['description']; ?> </div>
                                            <?php
                                        }
                                    ?>

                                    <?php
                                        if(!empty($slide['link'])){
                                            ?>
                                            <!-- LAYER NR. 34 -->
                                            <a class="tp-caption rev-btn  tp-resizeme"
                                               href="<?php echo $slide['link']; ?>" target="_blank" id="slide-181-layer-7"
                                               data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']" 
             data-y="['middle','middle','middle','middle']" data-voffset="['75','75','85','86']" 
                        data-width="none"
            data-height="none"
            data-whitespace="nowrap"
 
            data-type="button" 
            data-actions=''
            data-responsive_offset="on" 

            data-frames='[{"delay":1000,"speed":2000,"frame":"0","from":"sX:0.9;sY:0.9;opacity:0;fb:20px;","to":"o:1;fb:0;","ease":"Power3.easeInOut"},{"delay":"wait","speed":570,"frame":"999","to":"sX:0.9;sY:0.9;opacity:0;fb:20px;","ease":"Power3.easeInOut"},{"frame":"hover","speed":"300","ease":"Power1.easeOut","to":"o:1;rX:0;rY:0;rZ:0;z:0;fb:0;","style":"c:rgb(0,0,0);bg:rgb(255,255,255);"}]'
            data-textAlign="['center','center','center','center']"
            data-paddingtop="[0,0,0,0]"
            data-paddingright="[50,50,50,50]"
            data-paddingbottom="[0,0,0,0]"
            data-paddingleft="[50,50,50,50]"

            style="z-index: 21; white-space: nowrap; font-size: 16px; line-height: 50px; font-weight: 300; color: #ffffff; letter-spacing: ;font-family:Raleway;background-color:rgba(87,202,133,0);border-color:rgb(255,255,255);border-style:solid;border-width:2px 2px 2px 2px;border-radius:30px 30px 30px 30px;outline:none;box-shadow:none;box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;cursor:pointer;text-decoration: none;"><?php echo __("website/index/slider-button-text"); ?> </a>
                                            <?php
                                        }
                                    ?>
                                </li>
                                <!-- SLIDE -->

                                <?php
                            }
                            ?>
                            <?php
                        }
                    ?>
                </ul>
                <div class="tp-bannertimer tp-bottom" style="visibility: hidden !important;"></div> </div>
        </div><!-- END REVOLUTION SLIDER -->
        <script type="text/javascript">
            var revapi58,
                tpj;
            (function() {
                if (!/loaded|interactive|complete/.test(document.readyState)) document.addEventListener("DOMContentLoaded",onLoad); else onLoad();

                function onLoad() {
                    if (tpj===undefined) { tpj = jQuery; if("off" == "on") tpj.noConflict();}
                    if(tpj("#rev_slider_58_1").revolution == undefined){
                        revslider_showDoubleJqueryError("#rev_slider_58_1");
                    }else{
                        revapi58 = tpj("#rev_slider_58_1").show().revolution({
                            sliderType:"standard",
                            jsFileLocation:"",
                            sliderLayout:"fullwidth",
                            dottedOverlay:"none",
                            delay:9000,
                            navigation: {
                                keyboardNavigation:"off",
                                keyboard_direction: "horizontal",
                                mouseScrollNavigation:"off",
                                mouseScrollReverse:"default",
                                onHoverStop:"off",
                                bullets: {
                                    enable:true,
                                    hide_onmobile:false,
                                    style:"bullet-bar",
                                    hide_onleave:false,
                                    direction:"horizontal",
                                    h_align:"center",
                                    v_align:"bottom",
                                    h_offset:0,
                                    v_offset:50,
                                    space:5,
                                    tmp:''
                                }
                            },
                            responsiveLevels:[1240,1024,778,480],
                            visibilityLevels:[1240,1024,778,480],
                            gridwidth:[1240,1024,778,480],
                            gridheight:[500,400,400,450],
                            lazyType:"none",
                            shadow:0,
                            spinner:"spinner2",
                            stopLoop:"off",
                            stopAfterLoops:-1,
                            stopAtSlide:-1,
                            shuffle:"off",
                            autoHeight:"off",
                            disableProgressBar:"on",
                            hideThumbsOnMobile:"off",
                            hideSliderAtLimit:0,
                            hideCaptionAtLimit:0,
                            hideAllCaptionAtLilmit:0,
                            debugMode:false,
                            fallbacks: {
                                simplifyAll:"off",
                                nextSlideOnWindowFocus:"off",
                                disableFocusListener:false,
                            }
                        });
                        revapi58.bind("revolution.slide.onloaded",function (e) {
                            revapi58.addClass("tiny_bullet_slider");
                        });    }; /* END OF revapi call */

                    if(revapi58) revapi58.revSliderSlicey();

                    if(typeof ExplodingLayersAddOn !== "undefined") ExplodingLayersAddOn(tpj, revapi58);
                }; /* END OF ON LOAD FUNCTION */
            }()); /* END OF WRAPPING FUNCTION */
        </script>

        <!-- SLIDER END -->
        <?php
    }
?>
<div class="clear"></div>