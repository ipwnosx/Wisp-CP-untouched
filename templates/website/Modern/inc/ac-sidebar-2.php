<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    if(!isset($gtype)) $gtype = false;
?><div class="mpanelleft">

    <?php
        if(isset($visibility_invoice) && $visibility_invoice && $statistic3>0 && $pname != "account_dashboard" && !isset($unpaid_invoices)){
            if(!isset($get_unpaid_invoice_total)){
                Helper::Load(["Invoices","Money"]);
                $u_data = UserManager::LoginData("member");
                $get_unpaid_invoice_total  = Invoices::get_total_unpaid_invoices_amount($u_data["id"]);
            }
            ?>
            <style>
                .invoicereminleft{color:#F44336;margin-bottom:15px;position:relative;overflow:hidden;}
                .invoicereminleft h4{font-size:16px;font-weight:700;margin-bottom:5px}
                .invoicereminleft span{font-weight:300}
                .invoicereminleft .lbtn{margin-top:15px;color:#F44336;border:1px solid #F44336;font-weight:400;font-size:14px}
                .invoicereminleft .lbtn:hover {background:#F44336;color:white;}
                .invoicereminleft img {height: 170px;position:absolute;right: -45px;bottom: -30px;opacity: 0.2;filter: alpha(opacity=20);}
            </style>

            <div class="invoicereminleft">
                <img src="https://image.flaticon.com/icons/svg/179/179386.svg">
                <div class="padding20">
                    <h4><?php echo __("website/account/remind-invoice-text5"); ?></h4>
                    <span><?php echo __("website/account/remind-invoice-text6",[
                            '{count}' => $statistic3,
                            '{total}' => Money::formatter_symbol($get_unpaid_invoice_total,Money::getUCID()),
                        ]); ?></span><div class="clear"></div>
                    <a href="<?php echo Controllers::$init->CRLink("ac-ps-invoices-p",["bulk-payment"]); ?>" class="lbtn"><?php echo $statistic3>1 ? __("website/account/remind-invoice-text3") : __("website/account/remind-invoice-text4"); ?></a>
                </div>
            </div>
            <?php
        }
    ?>


    <script type="text/javascript">
        $(document).ready(function(){
            $('.toggle').click(function(e) {
                var href = $(this).attr("href");
                if(href === 'javascript:void 0;' || href === '')
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

            $('#clientAreaMenus-2 a').each(function(){
                var el = $(this);
                if($(el).attr("id") !== 'active'){
                    $('ul li a',el.parent()).each(function(){
                        if($(this).attr("id") === "active")
                            $(el).attr("id","active").parent().find("ul").css("display","block").addClass('show');
                    });
                }
            });

        });
    </script>

    <div class="mpanelbtns">
        <ul id="clientAreaMenus-2">
            <?php
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

                    if($children){
                        echo '<ul';
                        echo ' class="inner'.($ul_active ? ' show' : '').'"';
                        if($ul_active)
                            echo ' style="display:block;"';
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
                        if( ($menu['page'] == 'product-group/international-sms' || $menu['page'] == 'ca-intl-sms') && !Config::get("options/pg-activation/international-sms")) continue;
                        if($menu['page'] == 'ca-affiliate' && !Config::get("options/affiliate/status")) continue;
                        if($menu['page'] == 'ca-reseller' && !Config::get("options/dealership/status")) continue;
                        if($menu['page'] == 'ca-reseller' && !Config::get("options/dealership/view-without-membership") && isset($acheader_info["dealership"]["status"]) && $acheader_info["dealership"]["status"] == 'inactive')
                            continue;
                        if($menu['page'] == 'ca-domains' && !Config::get("options/pg-activation/domain") && $domain_total < 1)
                            continue;


                        if($menu['page'] == 'ca-orders' && !$menu['children']){
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
                        echo (!$menu["icon"] && $children) ? '<i class="fa fa-angle-double-right" aria-hidden="true"></i>' : '';

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
                ]);
            ?>
        </ul>
    </div>
</div>