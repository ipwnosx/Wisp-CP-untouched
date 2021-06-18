<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    if(isset($acheader_info) && $acheader_info) $notifications  = User::getNotifications();
    if(!isset($gtype)) $gtype = false;
    if(!isset($pname)) $pname = false;
    if(!isset($acheader_info)){
        $statistic1 = 0;
    }
    if(class_exists("Products")) Helper::Load(["Products"]);

    $menu_links = [
        'menu-0' => Controllers::$init->CRLink("my-account"),
        'menu-1' => Controllers::$init->CRLink("ac-ps-tickets"),
        'menu-2' => Controllers::$init->CRLink("ac-ps-products"),
        'menu-2-0' => Controllers::$init->CRLink("ac-ps-products-t",["software"]),
        'menu-2-1' => Controllers::$init->CRLink("ac-ps-products-t",["sms"]),
        'menu-2-2' => Controllers::$init->CRLink("ac-ps-products-t",["hosting"]),
        'menu-2-3' => Controllers::$init->CRLink("ac-ps-products-t",["server"]),
        'menu-2-4' => Controllers::$init->CRLink("ac-ps-products-t",["special"]),
        'menu-3' => Controllers::$init->CRLink("ac-ps-products-t",["domain"]),
        'menu-4' => Controllers::$init->CRLink("ac-ps-invoices"),
        'menu-5' => Controllers::$init->CRLink("ac-ps-info"),
        'menu-6' => Controllers::$init->CRLink("ac-ps-messages"),
        'balance-link' => Controllers::$init->CRLink("ac-ps-balance"),
        'menu-sms' => Controllers::$init->CRLink("ac-ps-sms"),
        'buy-domain'  => Controllers::$init->CRLink("domain"),
        'buy-hosting' => Controllers::$init->CRLink("products",["hosting"]),
        'buy-server'  => Controllers::$init->CRLink("products",["server"]),
        'buy-software' => Controllers::$init->CRLink("softwares"),
        'buy-sms'      => Controllers::$init->CRLink("products",["sms"]),
    ];


function clientArea_menu_walk($list=[],$children=false,$opt=[]){
    $pname                  = isset($opt['pname']) ? $opt["pname"] : '';
    $gtype                  = isset($opt['gtype']) ? $opt["gtype"] : '';
    $acheader_info          = isset($opt['acheader_info']) ? $opt["acheader_info"] : '';
    $menu_links             = isset($opt['menu_links']) ? $opt["menu_links"] : '';
    $visibility_ticket      = isset($opt['visibility_ticket']) ? $opt["visibility_ticket"] : '';
    $visibility_invoice     = isset($opt['visibility_invoice']) ? $opt["visibility_invoice"] : '';
    $domain_total           = isset($opt['domain_total']) ? $opt["domain_total"] : 0;
    $software_total         = isset($opt['software_total']) ? $opt["software_total"] : 0;
    $sms_total              = isset($opt['sms_total']) ? $opt["sms_total"] : 0;
    $hosting_total          = isset($opt['hosting_total']) ? $opt["hosting_total"] : 0;
    $server_total           = isset($opt['server_total']) ? $opt["server_total"] : 0;
    $special_total          = isset($opt['special_total']) ? $opt["special_total"] : 0;
    $special_list           = isset($opt['special_list']) ? $opt["special_list"] : [];
    $category               = isset($opt['category']) ? $opt["category"] : [];
    $ul_active              = isset($opt['active']) ? $opt['active'] : false;
    $_theme                 = isset($opt['_theme']) ? $opt['_theme'] : false;

    if($children){
        echo '<ul';
        echo ' class="inner"';
        echo ' style="background:#'.$_theme->config["settings"]["color1"].'"';
        echo '>';
    }

    foreach ($list AS $menu){

        if($menu['page'] == 'ca-tickets' && !$visibility_ticket) continue;
        if($menu['page'] == 'ca-invoices' && !$visibility_invoice) continue;
        if($menu['onlyCa'] && !$acheader_info) continue;
        if($menu['page'] == 'create-account' && $acheader_info) continue;
        if($menu['page'] == 'login-account' && $acheader_info) continue;
        if($menu['page'] == 'product-group/domain' && !Config::get("options/pg-activation/domain")) continue;
        if($menu['page'] == 'product-group/hosting' && !Config::get("options/pg-activation/hosting")) continue;
        if($menu['page'] == 'product-group/server' && !Config::get("options/pg-activation/server")) continue;
        if($menu['page'] == 'product-group/software' && !Config::get("options/pg-activation/software")) continue;
        if($menu['page'] == 'product-group/sms' && !Config::get("options/pg-activation/sms")) continue;
        if(($menu['page'] == 'product-group/international-sms' || $menu['page'] == 'ca-intl-sms') && !Config::get("options/pg-activation/international-sms")) continue;
        if($menu['page'] == 'ca-affiliate' && !Config::get("options/affiliate/status")) continue;
        if($menu['page'] == 'ca-reseller' && !Config::get("options/dealership/status")) continue;
        if($menu['page'] == 'ca-reseller' && !Config::get("options/dealership/view-without-membership") && isset($acheader_info["dealership"]["status"]) && $acheader_info["dealership"]["status"] == 'inactive')
            continue;
        if($menu['page'] == 'ca-domains' && !Config::get("options/pg-activation/domain") && $domain_total < 1)
            continue;


        if(!$children && $menu["page"] == "ca-intl-sms") continue;
        if(!$children && $menu["page"] == "ca-dashboard") continue;
        if(!$children && $menu["page"] == "ca-domains") continue;


        if($menu['page'] == 'ca-orders' && !$menu['children']){

            if(isset($domain_total) && $domain_total > 0)
                $menu['children'][] = [
                    'id' => 'domain',
                    'parent' => $menu['id'],
                    'icon' => '',
                    'rank' => 0,
                    'target' => 0,
                    'status' => 'active',
                    'page'   => 'ca-domains',
                    'onlyCa' => 1,
                    'link' => $menu_links['menu-3'],
                    'title' => __("website/account/sidebar-menu-3"),
                    'children' => [],
                ];

            if($hosting_total>0)
                $menu['children'][] = [
                    'id' => 'hosting',
                    'parent' => $menu['id'],
                    'icon' => '',
                    'rank' => 0,
                    'target' => 0,
                    'status' => 'active',
                    'page'   => 'ca-order-group',
                    'onlyCa' => 1,
                    'link' => $menu_links['menu-2-2'],
                    'title' => __("website/account/sidebar-menu-2-sub-hosting"),
                    'children' => [],
                ];

            if($server_total>0)
                $menu['children'][] = [
                    'id' => 'server',
                    'parent' => $menu['id'],
                    'icon' => '',
                    'rank' => 0,
                    'target' => 0,
                    'status' => 'active',
                    'page'   => 'ca-order-group',
                    'onlyCa' => 1,
                    'link' => $menu_links['menu-2-3'],
                    'title' => __("website/account/sidebar-menu-2-sub-server"),
                    'children' => [],
                ];
            if($software_total>0)
                $menu['children'][] = [
                    'id' => 'software',
                    'parent' => $menu['id'],
                    'icon' => '',
                    'rank' => 0,
                    'target' => 0,
                    'status' => 'active',
                    'page'   => 'ca-order-group',
                    'onlyCa' => 1,
                    'link' => $menu_links['menu-2-0'],
                    'title' => __("website/account/sidebar-menu-2-sub-software"),
                    'children' => [],
                ];
            if($sms_total>0)
                $menu['children'][] = [
                    'id' => 'sms',
                    'parent' => $menu['id'],
                    'icon' => '',
                    'rank' => 0,
                    'target' => 0,
                    'status' => 'active',
                    'page'   => 'ca-order-group',
                    'onlyCa' => 1,
                    'link' => $menu_links['menu-2-1'],
                    'title' => __("website/account/sidebar-menu-2-sub-sms"),
                    'children' => [],
                ];

            if(isset($hosting_total) && Config::get("options/pg-activation/international-sms"))
                $menu['children'][] = [
                    'id' => 'intl-sms',
                    'parent' => $menu['id'],
                    'icon' => '',
                    'rank' => 0,
                    'target' => 0,
                    'status' => 'active',
                    'page'   => 'ca-intl-sms',
                    'onlyCa' => 1,
                    'link' => Models::$init->link_detector("ca-intl-sms"),
                    'title' => __("website/account/sidebar-menu-sms"),
                    'children' => [],
                ];

            if($special_total>0 && $special_list)
            {
                foreach($special_list AS $group)
                {
                    if($group["parent"] != 0) continue;
                    $menu['children'][] = [
                        'id' => 'special-'.$group['id'],
                        'parent' => $menu['id'],
                        'icon' => '',
                        'rank' => 0,
                        'target' => 0,
                        'status' => 'active',
                        'page'   => 'ca-order-group',
                        'onlyCa' => 1,
                        'link' => $menu_links['menu-2-4'].'?category='.$group["id"],
                        'title' => $group["name"],
                        'children' => [],
                    ];
                }
            }

        }
        elseif($menu['page'] == 'ca-addons' && !$menu['children']){
            $addons = Modules::Load("Addons","All",true,true);
            if($addons){
                $addon_menus = [];
                foreach($addons AS $k => $v){
                    if(!isset($v["config"]["show_on_clientArea"]) || !$v["config"]["show_on_clientArea"]) continue;
                    $addon_menus[] = [
                        'id' => $k,
                        'parent' => 0,
                        'icon' => $menu['icon'],
                        'rank' => 0,
                        'target' => 0,
                        'status' => 'active',
                        'page'   => 'addon',
                        'onlyCa' => 1,
                        'link' => Utility::link_determiner("addon/".$k."/client"),
                        'title' => $v["lang"]["meta"]["name"],
                        'children' => [],
                    ];
                }
                if($addon_menus) clientArea_menu_walk($addon_menus,false,$opt);
            }
            continue;
        }

        $active             = false;

        if(
            ($pname == 'account_dashboard' && $menu['page'] == 'ca-dashboard') ||
            ($pname == 'account_tickets' && $menu['page'] == 'ca-tickets') ||
            ($pname == 'account_products' && $gtype == 'domain' && $menu['page'] == 'ca-domains') ||
            ($pname == 'account_products' && $gtype != 'domain' && $menu['page'] == 'ca-orders') ||
            ($pname == 'account_sms' && $menu['page'] == 'ca-intl-sms') ||
            ($pname == 'account_invoices' && $menu['page'] == 'ca-invoices') ||
            ($pname == 'account_info' && $menu['page'] == 'ca-ac-information') ||
            ($pname == 'account_messages' && $menu['page'] == 'ca-messages') ||
            ($menu['page'] == 'ca-order-group' && $category && 'special-'.$category["id"] == $menu['id']) ||
            ($menu['page'] == 'ca-order-group' && $gtype == $menu['id']) ||
            ($menu['page'] == 'addon' && $pname == $menu['id']) ||
            ($menu['page'] == 'ca-affiliate' && $pname == "affiliate") ||
            ($menu['page'] == 'ca-reseller' && $pname == "reseller")
        ) $active = true;


        if($menu["children"]) $menu["link"] = "javascript:void 0;";
        echo '<li';

        if(stristr($menu['icon'],'shopping-cart'))
            echo ' class="neworderbtn"';

        echo '>';

        echo '<a href="'.$menu["link"].'"';

        if($menu["target"]) echo ' target="_blank"';

        echo ' class="toggle"';

        if($active) echo ' id="active"';

        echo '>';

        echo '<span>';

        echo ($menu["icon"]) ? '<i class="'.$menu["icon"].'" aria-hidden="true"></i>' : '';

        echo $menu["title"];

        echo '</span>';

        echo '</a>';

        if($menu["children"]){
            $_opt = $opt;
            $_opt['active'] = $active;
            clientArea_menu_walk($menu["children"],true,$_opt);
        }

        echo '</li>'.PHP_EOL;
    }
    echo ($children) ? '</ul>'.PHP_EOL : '';
}


?>
<div class="clean-theme-header">

    <div id="wrapper">
        <div class="clean-theme-header-logo">
            <a href="<?php echo isset($acheader_info) && $acheader_info ? $my_account_link : $home_link; ?>"><img title="Logo" alt="Logo" src="<?php echo $header_logo_link;?>" width="240" height="auto"></a>

            <div class="clean-theme-mobile-btn"><a href="javascript:$('#mobmenu').slideToggle();void 0;"><i class="fa fa-bars" aria-hidden="true"></i></a></div>
        </div>

        <div class="clean-theme-header-right">

            <div class="clean-theme-header-right-btns">

                <ul>

                    <?php

                        if($lang_count>1){
                            ?>
                            <li id="clean-theme-lang-btn"><a class="clean-theme-header-ac-btn" href="javascript:open_modal('selectLang',{overlayColor: 'rgba(0, 0, 0, 0.85)'}); void 0;" title="<?php echo __("website/index/select-your-language"); ?>"><img height="20" title="<?php echo $selected_l["cname"]." (".$selected_l["name"].")"; ?>" alt="<?php echo $selected_l["cname"]." (".$selected_l["name"].")"; ?>" src="<?php echo $selected_l["flag-img"]; ?>"> </a></li>
                            <?php
                        }

                        if($currencies_count>1){
                            ?>
                            <li id="clean-theme-curr-btn"><a class="clean-theme-header-ac-btn" style="float: left;" href="javascript:open_modal('selectCurrency',{overlayColor: 'rgba(0, 0, 0, 0.85)'}); void 0;" title="<?php echo __("website/index/select-your-currency"); ?>"><?php echo $selected_c['code']; ?></a></li>


                            <?php
                        }
                    ?>

                    <li><a href="javascript:$('#clean-theme-header-right-sub-btns').slideToggle();void 0" class="clean-theme-header-ac-btn"><i class="fa fa-user" aria-hidden="true"></i></a>
                        <ul>

                            <?php if($login_check): ?>

                                <li><a href="<?php echo $menu_links['menu-5']; ?>?tab=1"><span>» <?php echo __("website/account_info/info-tab1"); ?></span></a></li>
                                <li><a href="<?php echo $menu_links['menu-5']; ?>?tab=2"><span>» <?php echo __("website/account_info/info-tab2"); ?></span></a></li>
                                <li><a href="<?php echo $menu_links['menu-5']; ?>?tab=3"><span>» <?php echo __("website/account_info/info-tab3"); ?></span></a></li>
                                <li><a href="<?php echo $menu_links['menu-5']; ?>?tab=4"><span>» <?php echo __("website/account_info/info-tab4"); ?></span></a></li>
                                <li><a href="<?php echo $logout_link; ?>"><span>» <?php echo __("website/sign/out");?></span></a></li>
                            <?php else: ?>
                                <?php if($sign_in): ?>
                                    <li><a href="<?php echo $login_link; ?>"><span>» <?php echo __("website/sign/in");?></span></a></li>
                                <?php endif; ?>
                                <?php if($sign_up && !Config::get("options/crtacwshop")): ?>
                                    <li><a href="<?php echo $register_link; ?>"><span>» <?php echo __("website/sign/up");?></span></a></li>
                                <?php endif; ?>
                            <?php endif; ?>
                        </ul>
                    </li>

                    <?php
                        if(isset($acheader_info) && $acheader_info)
                        {
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
                            <?php
                        }
                    ?>

                    <?php if($visibility_basket): ?>
                        <li> <a title="<?php echo __("website/checkout/basket-name");?>" class="clean-theme-header-ac-btn" href="<?php echo $basket_link; ?>"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span class="clean-theme-cart-qty"><?php echo $basket_count; ?></span></a></li>
                    <?php endif; ?>



                </ul>


            </div>

        </div>
    </div>
    <div class="menu" style="background:#<?php echo $_theme->config["settings"]["color1"]; ?>">

        <div id="wrapper">


            <ul>
                <?php
                    Hook::run("ClientAreaMenus",$clientArea_menus);
                    clientArea_menu_walk($clientArea_menus,false,[
                        'pname'             => $pname,
                        'gtype'             => $gtype,
                        'acheader_info'     => isset($acheader_info) ? $acheader_info : [],
                        'menu_links'        => isset($menu_links) ? $menu_links : [],
                        'visibility_ticket' => $visibility_ticket,
                        'visibility_invoice' => $visibility_invoice,
                        'domain_total'       => isset($statistic2) ? $statistic2 : 0,
                        'software_total'     => isset($software_total) ? $software_total : 0,
                        'sms_total'          => isset($sms_total) ? $sms_total: 0,
                        'hosting_total'      => isset($hosting_total) ? $hosting_total : 0,
                        'server_total'       => isset($server_total) ? $server_total : 0,
                        'special_total'      => isset($special_total) ? $special_total : 0,
                        'special_list'       => isset($special_list) ? $special_list : 0,
                        'category'           => isset($category) ? $category : false,
                        '_theme'             => $_theme,
                    ]);

                ?>
            </ul>
        </div>
    </div>
</div>

<div id="mobmenu" style="display:none;<?php echo Config::get("theme/only-panel") ? : ''; ?>">
<a href="javascript:$('#mobmenu').slideToggle();void 0;" class="menuAc"><i class="fa fa-close" aria-hidden="true"></i></a>

<div id="mobmenu_wrap">
    <ul>
    <?php
        clientArea_menu_walk($clientArea_menus,false,[
            'pname'             => $pname,
            'gtype'             => $gtype,
            'acheader_info'     => isset($acheader_info) ? $acheader_info : [],
            'menu_links'        => isset($menu_links) ? $menu_links : [],
            'visibility_ticket' => $visibility_ticket,
            'visibility_invoice' => $visibility_invoice,
            'domain_total'       => isset($statistic2) ? $statistic2 : 0,
            'software_total'     => isset($software_total) ? $software_total : 0,
            'sms_total'          => isset($sms_total) ? $sms_total: 0,
            'hosting_total'      => isset($hosting_total) ? $hosting_total : 0,
            'server_total'       => isset($server_total) ? $server_total : 0,
            'special_total'      => isset($special_total) ? $special_total : 0,
            'special_list'       => isset($special_list) ? $special_list : 0,
            'category'           => isset($category) ? $category : false,
            '_theme'             => $_theme,
        ]);
    ?>
    </ul>
</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
    $('#mobmenu_wrap .toggle').click(function(e)
    {
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