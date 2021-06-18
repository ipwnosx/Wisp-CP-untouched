<?php defined('CORE_FOLDER') OR exit('You can not get in here!'); View::show_brand(); ?>
<div class="footer">
    <div id="wrapper">
        <?php
            if(!Config::get("theme/only-panel")){
                ?>
                <div class="footslogan">
                    <div id="wrapper">
                        <h4><?php echo __("website/index/footer-slogan"); ?> </h4>
                        <?php echo $pnumbers ? '<h2 data-aos="zoom-in"><a href="tel:'.$pnumbers[0].'">'.$pnumbers[0].'</a></h2>' : ''; ?>
                    </div>
                </div>

                <div class="line"></div>

                <div class="footinfos footcopyright">
                    <img class="footlogo" src="<?php echo $footer_logo_link;?>" width="245" height="auto" alt="logo" title="logo">
                    <div class="clear"></div>
                    <span><?php echo __("website/index/footer-copyright"); ?></span>
                    <div class="clear"></div>

                    <h4><?php echo isset($eaddresses[0]) ? $eaddresses[0] : ''; ?></h4>
                    <h5><?php echo $address; ?></h5>

                    <div class="clear"></div>

                    <img class="gprimage" src="<?php echo $tadress; ?>images/gdpr.png" alt="This site is GDPR compliant." title="This site is GDPR compliant." width="auto" height="35"/><div class="clearmob">
                    </div>

                </div>

                <?php

                if(!function_exists("footer_menu_walk")){
                    function footer_menu_walk($list=[],$children=false,$opt=[]){
                        foreach ($list AS $menu){
                            echo (!$children) ? '<div class="footblok">' : '';
                            echo '<a';
                            echo (!$children) ? ' style="padding-left:0px;color:white;"' : '';
                            if($menu["link"]!=''){
                                echo ' href="'.$menu["link"].'"';
                                echo ($menu["target"]) ? ' target="_blank"' : '';
                            }
                            echo '>';
                            echo (!$children) ? EOL.'<h3>' : '';
                            echo (!empty($menu["icon"])) ? '<i class="'.$menu["icon"].'" aria-hidden="true"></i>' : '';
                            echo $menu["title"];
                            echo (!$children) ? '</h3>'.EOL : '';
                            echo '</a>'.EOL;
                            ($menu["children"]) ? footer_menu_walk($menu["children"],true,$opt) : '';
                            echo (!$children) ? '</div>'.EOL : '';
                        }
                    }
                }
                footer_menu_walk($footer_menus,false);
                ?>
                <div class="line"></div>
                <?php
            }
        ?>

        <?php if($socialsc>0 && is_array($socials)){ ?>
            <div class="footsosyal">
                <?php
                    foreach($socials AS $row){
                        if($row["url"] != ''){
                            echo '<a href="'.$row["url"].'" target="_blank" title="'.$row["name"].'"><i class="'.$row["icon"].'" aria-hidden="true"></i></a>';
                        }
                    }
                ?>
            </div>
        <?php } ?>

        <?php
            if(Config::get("theme/only-panel")){
                ?>
                <div style="color: rgba(255, 255, 255, 0.34);text-align:center;width:100%;"><?php echo __("website/index/footer-copyright"); ?></div>
                <?php
            }
        ?>


    </div>
</div>