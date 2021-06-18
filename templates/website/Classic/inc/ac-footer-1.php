<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    if(isset($acheader_info) && $acheader_info){
        ?>
        <div class="lastentry">
            <span class="songiris"><?php echo __("website/account/last-login-board",[
                    '{date}' => $acheader_info["last_login_date"],
                    '{IP}' => $acheader_info["last_login_ip"],
                ]); ?>
            </span>
        </div>
        <?php
    }
?>

<div class="clientcopyright"><span><?php echo __("website/index/footer-copyright"); ?></span></div>


<?php View::show_brand(); ?>


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