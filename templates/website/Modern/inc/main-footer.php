<?php defined('CORE_FOLDER') OR exit('You can not get in here!'); ?><div class="clear"></div>
<br>

<?php View::show_brand(); ?>

<?php
    if(isset($hoptions["page"]) && $hoptions["page"] == "index"){
        if($footlogos){
            ?>
            <div class="footlogos" data-aos="fade-in">
                <img src="<?php echo $tadress; ?>images/CPanel_logo.png" width="120" height="auto" alt="cPanel" title="cPanel">
                <img src="<?php echo $tadress; ?>images/plesk-logo.png" width="120" height="auto" alt="Plesk" title="Plesk">
                <img src="<?php echo $tadress; ?>images/LiteSpeed-logo.png" width="120" height="auto" alt="Litespeed" title="Litespeed">
                <img src="<?php echo $tadress; ?>images/CL_company_final.png" width="120" height="auto" alt="Cloudlinux" title="Cloudlinux">
                <img src="<?php echo $tadress; ?>images/microsoft.png" width="120" height="auto" alt="Microsoft.net" title="Microsoft.net">
                <img src="<?php echo $tadress; ?>images/Comodo-Logo.jpg" width="120" height="auto" alt="Comodo" title="Comodo">
                <img src="<?php echo $tadress; ?>images/visa-mastercard-logos.png" width="120" height="auto" alt="Visa/Master" title="Visa/Master">
            </div>
            <?php
        }

        if($newsletter_email){
            ?>
            <div class="clear"></div>
            <div class="ebulten" data-aos="fade-in">
                <div class="ebultencont">
                    <form action="<?php echo $newsletter_action;?>" method="POST" id="newsletter_email" onsubmit="newsletter_submit(); return false;">
                        <?php echo Validation::get_csrf_token('newsletter'); ?>

                        <i class="fa fa-envelope-o" aria-hidden="true"></i>
                        <input name="email" type="text" placeholder="<?php echo __("website/newsletter/form-email-placeholder"); ?>">
                        <a id="newsletter_submit" href="javascript:newsletter_submit();void 0;" class="gonderbtn aboneolbtn"><?php echo __("website/newsletter/form-submit"); ?></a>
                    </form>
                    <script type="text/javascript">
                        function newsletter_submit() {
                            var email = $("#newsletter_email input[name='email']").val();
                            <?php if(isset($captcha_newsletter)): ?>
                            window.open("<?php echo $newsletter_action; ?>?email="+email, "newsletter", "top=200,left=500,width=400,height=400");
                            <?php else: ?>
                            MioAjaxElement($("#newsletter_submit"),{
                                waiting_text:"<?php echo addslashes(__("website/others/button3-pending")); ?>",
                                result:"newsletter_result",
                            });
                            <?php endif; ?>
                        }
                        function newsletter_result(result) {
                            if(result != ''){
                                var solve = getJson(result);
                                if(solve !==false && solve != undefined && typeof(solve) == "object"){
                                    if(solve.status == "error"){
                                        $("#newsletter_email input[name='email']").focus();
                                        swal({
                                            type: 'error',
                                            title: "<?php echo  __("website/others/notification-error"); ?>",
                                            text: solve.message,
                                            timer: 2500,
                                            confirmButtonText: "<?php echo  __("website/others/notification-confirm"); ?>",
                                        }).then(function () {
                                            $("#newsletter_email input[name='email']").focus();
                                        });
                                    }else if(solve.status == "successful"){
                                        swal("<?php echo __("website/newsletter/form-output-success-title"); ?>", "<?php echo __("website/newsletter/form-output-success"); ?>","success");
                                        $("#newsletter_email input[name='email']").val('');
                                    }
                                }else
                                    console.log(result);
                            }
                        }
                    </script>
                </div>
            </div>
            <?php
        }
    }
?>


<div class="footer">
    <div id="wrapper">
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
            <span><?php echo __("website/index/footer-copyright",['2019' => DateManager::Now("Y")]); ?></span>
            <div class="clear"></div>

            <h4><?php echo isset($eaddresses[0]) ? $eaddresses[0] : ''; ?></h4>
            <h5><?php echo $address; ?></h5>

            <div class="clear"></div>

            <img class="gprimage" src="<?php echo $tadress; ?>images/gdpr.png" alt="This site is GDPR compliant." title="This site is GDPR compliant." width="auto" height="35"/><div class="clearmob">
            </div>

        </div>

        <?php
            footer_menu_walk($footer_menus,false);
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
        ?>

        <?php if($socialsc>0 && is_array($socials)){ ?>
            <div class="line"></div>
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


    </div>
</div>