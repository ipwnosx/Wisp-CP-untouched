<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    $notifications  = User::getNotifications();
?>
<div class="mpanelinfo">
    <div id="wrapper">

        <script type="text/javascript">
            var dashboard_styleToggle=false;
            function dashboard_style_toggle(){
                if(dashboard_styleToggle){
                    $(".leftbar").css({'margin-left':'-80%'});
                    $("#button_close").css("display","none");
                    $(".mobmenuclose").css("display","none");
                    $("body").css("overflow","auto");
                    $("#dashboard_button_open").fadeIn(0);
                    dashboard_styleToggle = false;
                }else{
                    $(".leftbar").css({'margin-left':'0px'});
                    $(".mobmenuclose").css("display","block");
                    $("body").css("overflow","hidden");

                    $("#dashboard_button_close").fadeIn(100);
                    dashboard_styleToggle = true;
                }
            }

            function read_all_notifications(btn_el){
                var request = MioAjax({
                    button_element:btn_el,
                    waiting_text:'<i class="loadingicon fa fa-spinner" aria-hidden="true"></i> <?php echo ___("needs/please-wait"); ?>',
                    action: "<?php echo Controllers::$init->CRLink("my-account"); ?>",
                    method: "POST",
                    data:{operation:"read_all_notifications"},
                },true,true);
                request.done(function(result){
                    if(result){
                        result = getJson(result);
                        if(result !== "false"){
                            if(result.status == "successful"){
                                $("#read_all_notifications").css("display","none");
                                $(".notification-item").not(".read").addClass("read");
                                $("#notification_bubble_count").css("display","none");
                                $("#notifications_count").html('0');
                            }
                        }else
                            console.log(result);
                    }
                });
            }

        </script>

        <a onclick="dashboard_style_toggle();" href="javascript:void 0;" id="dashboard_button_open" class="mclientmobbtn" style=""><i class="fa fa-bars" aria-hidden="true"></i></a>

        <?php
            if(isset($acheader_info) && $acheader_info){
                ?>
                <span class="wclientwelcome"><?php echo __("website/account/welcome-board",[
                        '{name}' => $acheader_info["name"],
                        '{surname}' => $acheader_info["surname"],
                        '{full_name}' => $acheader_info["full_name"],
                    ]); ?></span>
                <?php
                if(Config::get("options/dealership/status") && isset($acheader_info["dealership"]["status"]) && $acheader_info["dealership"]["status"] == "active"){
                    ?>
                    <a id="resellertooltip" class="tooltip-right" data-tooltip="<?php echo __("website/account/active-reseller"); ?>" href="<?php echo Controllers::$init->CRLink("reseller"); ?>"><img class="resellericon" height="25" src="<?php echo $tadress; ?>images/dealership.svg"></a>
                    <?php
                }
                ?>
                <?php
            }
        ?>

        <div class="headbutonlar">


            <?php

                if($lang_count>1){
                    ?>
                    <a class="langflagicon" style="float: left;" href="javascript:open_modal('selectLang',{overlayColor: 'rgba(0, 0, 0, 0.85)'}); void 0;" title="<?php echo __("website/index/select-your-language"); ?>">
                        <img title="<?php echo $selected_l["cname"]." (".$selected_l["name"].")"; ?>" alt="<?php echo $selected_l["cname"]." (".$selected_l["name"].")"; ?>" src="<?php echo $selected_l["flag-img"]; ?>">
                    </a>
                    <?php
                }

                if($currencies_count>1){
                    ?>
                    <a class="scurrencyicon" style="float: left;" href="javascript:open_modal('selectCurrency',{overlayColor: 'rgba(0, 0, 0, 0.85)'}); void 0;" title="<?php echo __("website/index/select-your-currency"); ?>"><?php echo $selected_c['code']; ?></a>
                    <?php
                }
            ?>

            <?php if($visibility_basket): ?>
                <a title="<?php echo __("website/checkout/basket-name");?>" id="sepeticon" href="<?php echo $basket_link; ?>"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span class="basket-count"><?php echo $basket_count; ?></span></a>
            <?php endif; ?>

            <?php
                if(isset($acheader_info) && $acheader_info){
                    ?>
                    <!-- Notifications -->
                    <div class="wclientnotifi">
                        <a class="wnotifitibtn" href="javascript:void 0;"><i class="fa fa-bell-o" aria-hidden="true"></i><?php if($notifications["bubble_count"]): ?><span class="notifi-count" id="notification_bubble_count"><?php echo $notifications["bubble_count"]; ?></span><?php endif; ?>
                        </a>
                        <div class="wclientnotification">

                            <div class="wnotifititle" style="background-color:#<?php echo Config::get("theme/color2"); ?>;">
                                <div class="padding30">
                                    <h3><?php echo __("website/account/text2",['{count}' => '<span id="notifications_count">'.$notifications["bubble_count"].'</span>']); ?></h3>
                                    <h5><?php echo __("website/account/text3"); ?></h5>
                                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                </div>
                            </div>

                            <div class="padding30">

                                <div class="wnotificontent">

                                    <?php
                                        if($notifications["items"]){
                                            foreach($notifications["items"] AS $row){
                                                $icon = "fa fa-info-circle";

                                                if($row["icon"] == "check"){
                                                    $icon = "fa fa-check-circle-o";
                                                }elseif($row["icon"] == "warning"){
                                                    $icon = "fa fa-exclamation-circle";
                                                }
                                                ?>
                                                <div class="<?php echo $row["unread"] ? 'read ' : ''; ?>wnotifilist notification-item">
                                                    <div class="wnotifilisticon"><i class="<?php echo $icon;?>" aria-hidden="true"></i></div>
                                                    <div class="wnotifilistcon">
                                                        <h5>
                                                            <?php echo $row["message"]; ?>
                                                        </h5>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        }
                                        else{
                                            ?>
                                            <div class="nonotification">
                                                <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
                                                <h3><?php echo __("website/account/text22"); ?></h3>
                                                <h5><?php echo __("website/account/text23"); ?></h5>
                                            </div>
                                            <?php
                                        }
                                    ?>
                                </div>

                                <?php
                                    if($notifications["bubble_count"]){
                                        ?>
                                        <div class="allread" id="read_all_notifications"><a href="javascript:void 0;" onclick="read_all_notifications(this)"><?php echo __("website/account/text4"); ?></a></div>
                                        <?php
                                    }
                                ?>



                            </div>
                        </div>

                    </div>

                    <!-- Profile Card -->
                    <div class="wclientnotifi">
                        <a class="wnotifitibtn" href="javascript:void 0;"><i class="fa fa-user" aria-hidden="true"></i></a>
                        <div class="wclientnotification">

                            <div class="wnotifititle" style="background-color:#<?php echo Config::get("theme/color2"); ?>;">
                                <div class="padding30">
                                    <h3><?php echo $acheader_info["full_name"]; ?></h3>
                                    <h5><?php echo __("website/account/text1"); ?></h5>
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                </div>
                            </div>

                            <div class="padding30">

                                <div class="wnotificontent" style="height:auto;">

                                    <div class="wnotifilist">
                                        <div class="wnotifilisticon"><i class="fa fa-info" aria-hidden="true"></i></div>
                                        <div class="wnotifilistcon"><h5><a href="<?php echo $acsidebar_links['menu-5']; ?>?tab=1"><strong><?php echo __("website/account_info/info-tab1"); ?></strong></a></h5></div>
                                    </div>

                                    <div class="wnotifilist">
                                        <div class="wnotifilisticon"><i class="fa fa-file-text-o" aria-hidden="true"></i></div>
                                        <div class="wnotifilistcon"><h5><a href="<?php echo $acsidebar_links['menu-5']; ?>?tab=2"><strong><?php echo __("website/account_info/info-tab2"); ?></strong></a></h5></div>
                                    </div>

                                    <div class="wnotifilist">
                                        <div class="wnotifilisticon"><i class="fa fa-star-o" aria-hidden="true"></i></div>
                                        <div class="wnotifilistcon"><h5><a href="<?php echo $acsidebar_links['menu-5']; ?>?tab=3"><strong><?php echo __("website/account_info/info-tab3"); ?></strong></a></h5></div>
                                    </div>

                                    <div class="wnotifilist">
                                        <div class="wnotifilisticon"><i class="fa fa-key" aria-hidden="true"></i></div>
                                        <div class="wnotifilistcon"><h5><a href="<?php echo $acsidebar_links['menu-5']; ?>?tab=4"><strong><?php echo __("website/account_info/info-tab4"); ?></strong></a></h5></div>
                                    </div>


                                </div>


                                <div class="allread"><a href="<?php echo $logout_link; ?>"><?php echo __("website/sign/out");?></a></div>


                            </div>
                        </div>
                    </div>
                    <?php
                }
                elseif($sign_in || ($sign_up && !Config::get("options/crtacwshop"))){
                    ?>
                    <div class="wclientnotifi">
                        <a class="wnotifitibtn" href="javascript:void 0;"><i class="fa fa-user" aria-hidden="true"></i></a>
                        <div class="wclientnotification">

                            <div class="wnotifititle" style="background-color:#<?php echo Config::get("theme/color2"); ?>;">
                                <div class="padding30">
                                    <h3><?php echo __("website/account/text24"); ?></h3>
                                    <h5><?php echo __("website/account/text25"); ?></h5>
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                </div>
                            </div>

                            <div class="padding30">

                                <div class="wnotificontent" style="height:auto;">

                                    <?php if($sign_in): ?>
                                        <div class="wnotifilist">
                                            <div class="wnotifilisticon"><i class="fa fa-sign-in" aria-hidden="true"></i></div>
                                            <div class="wnotifilistcon"><h5><a href="<?php echo $login_link; ?>"><strong><?php echo __("website/sign/in");?></strong></a></h5></div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if($sign_up && !Config::get("options/crtacwshop")): ?>
                                        <div class="wnotifilist">
                                            <div class="wnotifilisticon"><i class="fa fa-user-plus" aria-hidden="true"></i></div>
                                            <div class="wnotifilistcon"><h5><a href="<?php echo $register_link; ?>"><strong><?php echo __("website/sign/up");?></strong></a></h5></div>
                                        </div>
                                    <?php endif; ?>

                                </div>

                            </div>

                        </div>
                    </div>

                    <?php

                }
            ?>

        </div>

    </div>
</div>