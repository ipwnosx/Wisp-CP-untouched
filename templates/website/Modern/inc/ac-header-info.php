<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    if(!isset($ac_header_info_inc)){
        $ac_header_info_inc = true;
        ?>
        <div class="mpanelinfo">
            <div id="wrapper">
        <span><?php echo __("website/account/welcome-board",[
                '{name}' => $acheader_info["name"],
                '{surname}' => $acheader_info["surname"],
                '{full_name}' => $acheader_info["full_name"],
            ]); ?></span>


                <?php
                    if(isset($acheader_info["dealership"]["status"]) && $acheader_info["dealership"]["status"] == "active"){
                        ?>
                        <a id="resellertooltip" class="tooltip-right" data-tooltip="<?php echo __("website/account/active-reseller"); ?>" href="<?php echo Controllers::$init->CRLink("reseller"); ?>"><img class="resellericon" height="25" src="<?php echo $tadress; ?>images/dealership.svg"></a>
                        <?php
                    }
                ?>


                <div class="clearmob"></div>

                <span class="songiris"><?php echo __("website/account/last-login-board",[
                        '{date}' => $acheader_info["last_login_date"],
                        '{IP}' => $acheader_info["last_login_ip"],
                    ]); ?></span>
            </div>
        </div>
        <?php
    }
?>