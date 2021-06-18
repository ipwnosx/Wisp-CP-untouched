<?php if($h_contents = Hook::run("AdminAreaBeginBody")) foreach($h_contents AS $h_content) if($h_content) echo $h_content; ?>
<audio hidden id="notice_audio" preload="none">
    <source src="<?php echo APP_URI; ?>/resources/assets/sounds/bubble.mp3" type="audio/mpeg">
    <source src="<?php echo APP_URI; ?>/resources/assets/sounds/bubble.ogg" type="audio/ogg">
</audio>

<?php
    if(Admin::isPrivilege(["HELP_UPDATES_LOOK"])){
        if($new_version = Updates::check_new_version()){

            if(isset($new_version["status"]) && $new_version["status"] == "error"){
                ?>
                <div class="nocron critical-update-notification" id="version_notification_bar" style="display: none;">
                    <?php echo $new_version["message"]; ?>
                </div>
                <script type="text/javascript">
                    $(document).ready(function(){
                        $("#version_notification_bar").slideDown(600);
                    });
                </script>
                <?php
            }else{
                $perma_version = Filter::permalink($new_version["version"]);
                if(!Cookie::get("version-".$perma_version)){
                    ?>
                    <div class="critical-update-notification" id="version_notification_bar" style="display: none;">
                        <strong><?php echo __("admin/help/version-update-notification-text1",['{version}' => "V".$new_version["version"].(isset($new_version["type"]) && $new_version["type"] == "Beta" ? " ".$new_version["type"] : '') ]); ?></strong> <?php echo __("admin/help/version-update-notification-text2"); ?>
                        <a href="<?php echo Controllers::$init->AdminCRLink("help-1",["updates"]); ?>" class="versiyoninfo"><?php echo __("admin/help/version-update-notification-text3"); ?></a>
                        <a href="javascript:showLater();void 0" class="versiyoninfo"><?php echo __("admin/help/version-update-notification-text4"); ?></a>
                    </div>

                    <script type="text/javascript">
                        $(document).ready(function(){
                            $("#version_notification_bar").slideDown(600);
                        });

                        function showLater(){
                            $("#version_notification_bar").slideUp(600);
                            setCookie("version-<?php echo $perma_version; ?>",1,7);
                        }
                    </script>
                    <?php
                }
            }
        }
    }
?>
<script type="text/javascript">
    var critical_notifications_bar = false;
</script>
<div style="display:none;font-size:13px;" id="transaction" data-iziModal-title="<?php echo __("admin/index/critical-transaction-notifications"); ?>">
    <div class="padding20">

        <?php
            if(isset($critical_transaction_notifications) && $critical_transaction_notifications){
                $first_unread_transaction_notifications = [];
                $other_transaction_notifications = [];

                foreach($critical_transaction_notifications AS $k=>$row){
                    if(!$row["unread"]) $first_unread_transaction_notifications[$k] = $row;
                    else $other_transaction_notifications[$k] = $row;
                }

                if(sizeof($first_unread_transaction_notifications) >= 2)
                {
                    ?>
                    <div align="left">
                        <a href="<?php echo Controllers::$init->AdminCRLink("dashboard"); ?>?operation=clear_transaction_notifications" class="lbtn"><?php echo __("website/account/text4"); ?></a>
                    </div>
                    <br>
                    <?php
                }

                foreach(array_merge($first_unread_transaction_notifications,$other_transaction_notifications) AS $k=>$row)
                {
                    ?>
                    <div class="formcon<?php echo !$row["unread"] ? ' unread-event' : ''; ?>" style="<?php echo $row["unread"] ? 'opacity:0.5; filter:alpha(opacity=50);' : ''; ?>"<?php echo !isset($row["non-unread"]) ? ' id="event_'.$row["id"].'"' : ''; ?>>
                        <div class="notificon">
                            <?php
                                if($row["icon"] == "info"){
                                    ?><i class="fa fa-info-circle" aria-hidden="true"></i><?php
                                }elseif($row["icon"] == "error"){
                                    ?><i class="fa fa-exclamation-triangle" aria-hidden="true"></i><?php
                                }elseif($row["icon"] == "security"){
                                    ?><i class="fa fa-shield" aria-hidden="true"></i><?php
                                }elseif($row["icon"] == "support"){
                                    ?><i class="fa fa-life-ring" aria-hidden="true"></i><?php
                                }
                            ?>
                        </div>

                        <div class="notifiright">
                            <?php echo is_array($row["message"]) ? print_r($row["message"],true) : $row["message"]; ?>
                            <div class="clear"></div>

                            <span class="notification-date"><i class="fa fa-calendar"></i> &nbsp;<?php echo DateManager::format(Config::get("options/date-format")." H:i",$row["cdate"])?> &nbsp;</span>
                            <?php
                                if($row["buttons"]){
                                    foreach($row["buttons"] AS $button){
                                        ?><a class="notifibtn" href="<?php echo $button["link"]; ?>"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <?php echo $button["name"]; ?></a><?php
                                    }
                                }
                            ?>

                            <?php if(!$row["unread"] && !isset($row["non-unread"])): ?>
                                <a class="notifibtn read_event_<?php echo $row["id"]; ?>_button" href="javascript:readEvent(<?php echo $row["id"]; ?>);void 0;"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <?php echo __("admin/index/critical-transaction-notifications-3"); ?></a>
                            <?php endif; ?>

                        </div>
                    </div>
                    <?php
                }

            }else{
                ?>
                <div style="margin-top:30px;margin-bottom:30px;text-align:center;">
                    <i style="font-size:80px;" class="fa fa-check"></i>
                    <h4 style="font-weight:bold;"><?php echo __("admin/index/critical-transaction-notifications-1"); ?></h4>
                    <br/>
                    <h5><?php echo __("admin/index/critical-transaction-notifications-2"); ?></h5>
                </div>
                <?php
            }
        ?>

        <script type="text/javascript">
            function readEvent(id){
                $("#event_"+id).css({
                    opacity:"0.5",
                    filter:"alpha(opacity=50)",
                }).removeClass("unread-event");

                $(".read_event_"+id+"_button").remove();

                var count = $(".unread-event").length;

                if(count==0) $(".notifiballon").removeAttr("id");

                $("#critical_notifications_bar").slideUp(600);

                check_critical_notifications_bar();

                var request = MioAjax({
                    action:"<?php echo Controllers::$init->AdminCRLink("dashboard"); ?>",
                    method:"GET",
                    data:{
                        operation: "read_event",
                        id:id,
                    }
                },true,true);

                request.done(function(result){
                    if(result != ''){
                        var solve = getJson(result);
                        if(solve !== false){
                            if(solve.status == "error"){
                                if(solve.message != undefined && solve.message != '')
                                    alert_error(solve.message,{timer:5000});
                            }else if(solve.status == "successful"){
                                if(solve.message != undefined && solve.message != '')
                                    alert_success(solve.message,{timer:2000});
                                if(solve.redirect != undefined && solve.redirect != ''){
                                    setTimeout(function(){
                                        window.location.href = solve.redirect;
                                    },2000);
                                }
                            }
                        }
                    }
                });
            }
        </script>


        <div class="clear"></div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        check_critical_notifications_bar();
    });

    function check_critical_notifications_bar(){
        var is_have = false;
        $(".unread-event").each(function(k,v){
            if(k == 0){
                var template = $(".notifiright",this).html();
                template     = template.replace('<div class="clear"></div>','');
                $("#critical_notifications_bar").html(template);
                is_have = true;
            }
        });

        if(is_have)
            $("#critical_notifications_bar").slideDown(600);
        else
            $("#critical_notifications_bar").slideUp(600);

        return is_have;
    }
</script>
<?php
    if(!DEMO_MODE){
        ?>
        <div class="nocron" id="critical_notifications_bar" style="display: none;"></div>
        <?php
    }
?>


<script type="text/javascript">
    $(document).ready(function(){
        $('.toggle').click(function(e){
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

<?php
    $menus  = Admin::getMenus();
    if(!function_exists("menu_walk")){
        function menu_walk($list=[],$children=false,$opt=[]){
            $mobile = $opt["mobile"];

            echo ($children) ? PHP_EOL.'<ul'.($mobile && $children ? ' class="inner"' : '').'>'.PHP_EOL : '';
            if(is_array($list) && $list)
            {
                foreach ($list AS $k => $menu){
                    if(!isset($menu["children"])) $menu["children"] = [];

                    if($mobile && $menu["children"]) $menu["link"] = "javascript:void 0;";
                    if($menu["link"] == '') $menu["link"] = "javascript:void 0;";

                    echo '<li>';
                    echo '<a href="'.$menu["link"].'"';
                    echo (isset($menu["target"]) && $menu["target"] != '') ? ' target="'.$menu["target"].'"' : '';
                    if($mobile && $menu["children"]) echo ' class="toggle"';
                    echo '>';
                    echo (isset($menu["icon"]) && !empty($menu["icon"])) ? '<i class="'.$menu["icon"].'" aria-hidden="true"></i>' : '';
                    echo $menu["name"];
                    if($mobile && $menu["children"]) echo ' <i class="fa fa-caret-down" aria-hidden="true"></i>';
                    echo ' <span class="ballon menu_'.$k.'_bubble"'.(isset($menu["bubble_count"]) && $menu["bubble_count"] ? '' : ' style="display:none;"').'>'.(isset($menu["bubble_count"]) && $menu["bubble_count"] ? $menu["bubble_count"] : 0).'</span>';
                    echo '</a>';
                    (isset($menu["children"]) && $menu["children"]) ? menu_walk($menu["children"],true,$opt) : '';
                    echo '</li>'.PHP_EOL;
                }
            }
            echo ($children) ? '</ul>'.PHP_EOL : '';
        }
    }
?>


<script type="text/javascript">
    var search_term;
    var SearchButton_waiting_text = '<div class="spinnerx"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>';
    $(document).ready(function(){

        $("#SearchButton").click(function(){
            submit_search(this);
        });

        $("#MobSearchButton").click(function(){
            submit_search(this,true);
        });

        $("#SearchTerm").keyup(function(e){
            if(e.keyCode == 13) $("#SearchButton").trigger("click");
        });

        $("#MobSearchTerm").keyup(function(e){
            if(e.keyCode == 13) $("#MobSearchButton").trigger("click");
        });

        $("#SmartSearch_overlay").click(smartSearch_overlay_close);
        $(document).keyup(function(e){
            if($("#SmartSearch_overlay").css("display") === "block" && e.keyCode === 27) smartSearch_overlay_close();
        });

        $(".searchResult-groups a").on("click",function(){
            var el = $(this);
            var group = el.data("group");
            if(el.hasClass("active")) return false;

            $(".searchResult-groups a").removeClass("active");
            el.addClass("active");

            if(document.getElementsByClassName("searchResult-group-"+group+"-items").length > 0){
                $(".smartSearch-result-items ul,.smartSearch-no-result-content")
                    .not(".searchResult-group-"+group+"-items")
                    .animate({opacity:0},100,function(){
                        $(this).css("display","none");
                        $(".searchResult-group-"+group+"-items")
                            .css("display","block")
                            .animate({opacity:1},100);
                    });
            }else{
                $(".smartSearch-result-items ul")
                    .not(".searchResult-group-"+group+"-items")
                    .animate({opacity:0},100,function(){
                        $(this).css("display","none");
                        $(".smartSearch-no-result-content").animate({opacity:1},100,function(){
                            $(this).css("display","block");
                        });
                    });
            }

        });

    });

    function smartSearch_overlay_close(){
        var overlay_el = $("#SmartSearch_overlay");
        if(overlay_el.css("display") == "none") return false;

        if(isMobile()){
            $("#MobSearchResultContent").css("display","none").fadeOut(500);
        }else{
            $("#SearchResultContent").css("display","none").fadeOut(500);
        }
        overlay_el.fadeOut(500);
    }
    function submit_search(btn_el,mobile=false){
        var SearchTerm_input    = mobile ? $("#MobSearchTerm") : $("#SearchTerm");
        var SearchButton        = $(btn_el);
        var SearchResultContent = mobile ? $("#MobSearchResultContent") : $("#SearchResultContent");
        search_term             = SearchTerm_input.val();

        if(search_term.length < 1) return smartSearch_overlay_close();

        $("#SmartSearch_overlay").css("display","block");

        var request             = MioAjax({
            waiting_text        : SearchButton_waiting_text,
            button_element      : SearchButton,
            action              : "<?php echo $dashboard_link; ?>",
            method              : "POST",
            data                : {
                operation       : "smartSearch",
                term            : search_term
            },
        },true,true);

        request.done(function(result){
            if(result !== ''){
                var solve = getJson(result);
                if(solve !== false){
                    if(solve.status === "successful" && solve.data !== undefined){

                        var groups          = solve.data;
                        var groups_keys     = Object.keys(groups);
                        var active_group    = false;
                        var result_count    = 0;


                        $(".smartSearch-result-items").html('');
                        $(".searchResult-groups a").removeClass("active");

                        $(groups_keys).each(function(k1,v1){
                            var group   = groups[v1];
                            var items   = group.items;
                            var context = '';
                            var x_display = '';
                            if(active_group === false && items.length > 0){
                                $(".searchResult-group-"+v1).addClass("active");
                                x_display = '';
                                active_group = v1;
                            }else
                                x_display = 'display:none;opacity:0;';
                            $(".searchResult-group-"+v1+"-count").html('('+items.length+')');
                            result_count += items.length;

                            if(items.length > 0){
                                context += '<ul class="searchResult-group-'+v1+'-items" style="'+x_display+'">';

                                $(items).each(function(k2,v2){
                                    context += '<li><a href="'+v2.url+'">'+v2.name+'</a></li>';
                                });
                                context += '</ul>';

                                $(".smartSearch-result-items").append(context);
                            }

                        });

                        if(result_count === 0) $('.smartSearch-no-result-content').fadeIn(100);
                        else $('.smartSearch-no-result-content').fadeOut(100);

                    }

                    SearchResultContent.fadeIn(100);

                }else
                    console.log(result);
            }
        });

    }
</script>

<div class="header">

    <div id="SmartSearch_overlay" style="display: none;"></div>

    <div id="wrapper">

    <div class="logo">
        <a href="<?php echo $dashboard_link; ?>"><img src="<?php echo Utility::image_link_determiner("resources/uploads/logo/admin-logo.svg"); ?>?v=1.6" width="250" height="auto"></a>
    </div>

    <div class="smartsearch" id="SearchWrap">
        <input id="SearchTerm" type="text" value="" placeholder="<?php echo __("admin/index/search-term-placeholder"); ?>">
        <a href="javascript:void 0;" id="SearchButton"><i class="fa fa-search" aria-hidden="true"></i></a>

        <div class="smartsearch-info" id="SearchResultContent" style="display: none;">

            <i class="fa fa-caret-up" aria-hidden="true"></i>
            <div class="smartsearch-info-con">

                <div class="smartsleft searchResult-groups">
                    <a data-group="users" href="javascript:void 0;" class="searchResult-group-users"><span><i class="fa fa-user" aria-hidden="true"></i><?php echo __("admin/index/search-result-users"); ?> <strong class="searchResult-group-users-count">(0)</strong></span></a>
                    <a data-group="orders" href="javascript:void 0;" class="searchResult-group-orders"><span><i class="fa fa-rocket" aria-hidden="true"></i><?php echo __("admin/index/search-result-orders"); ?> <strong class="searchResult-group-orders-count">(0)</strong></span></a>
                    <a data-group="domains" href="javascript:void 0;" class="searchResult-group-domains"><span><i class="fa fa-globe" aria-hidden="true"></i><?php echo __("admin/index/search-result-domains"); ?> <strong class="searchResult-group-domains-count">(0)</strong></span></a>
                    <a data-group="invoices" href="javascript:void 0;" class="searchResult-group-invoices"><span><i class="fa fa-file-text-o" aria-hidden="true"></i><?php echo __("admin/index/search-result-invoices"); ?> <strong class="searchResult-group-invoices-count">(0)</strong></span></a>
                    <a data-group="tickets" href="javascript:void 0;" class="searchResult-group-tickets"><span><i class="fa fa-life-ring" aria-hidden="true"></i><?php echo __("admin/index/search-result-tickets"); ?> <strong class="searchResult-group-tickets-count">(0)</strong></span></a>
                </div>

                <div class="smartsright">
                    <div class="smartSearch-no-result-content" style="display: none;">
                        <i class="fa fa-info-circle" aria-hidden="true"></i><h5><?php echo __("admin/index/search-no-result"); ?></h5>
                    </div>
                    <div class="smartSearch-result-items"></div>
                </div>

            </div>
        </div>

    </div>

    <div class="yonetici">

        <div class="smartsearch" id="MobSearchWrap">
            <input id="MobSearchTerm" type="text" value="" placeholder="<?php echo __("admin/index/search-term-placeholder"); ?>">
            <a href="javascript:void 0;" id="MobSearchButton"><i class="fa fa-search" aria-hidden="true"></i></a>

            <div class="smartsearch-info" id="MobSearchResultContent" style="display: none;">

                <i class="fa fa-caret-up" aria-hidden="true"></i>
                <div class="smartsearch-info-con">

                    <div class="smartsleft searchResult-groups">
                        <a data-group="users" href="javascript:void 0;" class="searchResult-group-users"><span><i class="fa fa-user" aria-hidden="true"></i><?php echo __("admin/index/search-result-users"); ?> <strong class="searchResult-group-users-count">(0)</strong></span></a>
                        <a data-group="orders" href="javascript:void 0;" class="searchResult-group-orders"><span><i class="fa fa-rocket" aria-hidden="true"></i><?php echo __("admin/index/search-result-orders"); ?> <strong class="searchResult-group-orders-count">(0)</strong></span></a>
                        <a data-group="domains" href="javascript:void 0;" class="searchResult-group-domains"><span><i class="fa fa-globe" aria-hidden="true"></i><?php echo __("admin/index/search-result-domains"); ?> <strong class="searchResult-group-domains-count">(0)</strong></span></a>
                        <a data-group="invoices" href="javascript:void 0;" class="searchResult-group-invoices"><span><i class="fa fa-file-text-o" aria-hidden="true"></i><?php echo __("admin/index/search-result-invoices"); ?> <strong class="searchResult-group-invoices-count">(0)</strong></span></a>
                        <a data-group="tickets" href="javascript:void 0;" class="searchResult-group-tickets"><span><i class="fa fa-life-ring" aria-hidden="true"></i><?php echo __("admin/index/search-result-tickets"); ?> <strong class="searchResult-group-tickets-count">(0)</strong></span></a>
                    </div>

                    <div class="smartsright">
                        <div class="smartSearch-no-result-content" style="display: none;">
                            <i class="fa fa-info-circle" aria-hidden="true"></i><h5><?php echo __("admin/index/search-no-result"); ?></h5>
                        </div>
                        <div class="smartSearch-result-items"></div>
                    </div>

                </div>
            </div>

        </div>
        <div class="yoneticiimg">
            <a href="javascript:void 0;" onclick="open_modal('transaction',{width:'800px'});" class="notifiballon"<?php echo $critical_transaction_notifications_count ? ' id="notifiballonalert"' : ''; ?>><i class="fa fa-bell" aria-hidden="true"></i></a>

            <?php if(Admin::isPrivilege("EDIT_YOUR_ACCOUNT")): ?>
                <a href="<?php echo $account_settings_link; ?>">
                    <img src="<?php echo isset($account_info["avatar_image"]) ? $account_info["avatar_image"] : $tadress."images/yonetici.jpg"; ?>" width="80" height="80">
                </a>
            <?php else: ?>
                <img src="<?php echo isset($account_info["avatar_image"]) ? $account_info["avatar_image"] : $tadress."images/yonetici.jpg"; ?>" width="80" height="80">
            <?php endif; ?>
        </div>

        <div class="yoneticinfos">
            <h4><?php echo __("admin/index/welcome"); ?> <strong><?php echo $account_info["full_name"]; ?></strong></h4>
            <?php if(Admin::isPrivilege("EDIT_YOUR_ACCOUNT")): ?>
                <a href="<?php echo $account_settings_link; ?>"><i class="fa fa-user" aria-hidden="true"></i><?php echo __("admin/index/header-button-settings"); ?></a>
            <?php endif; ?>
            <a href="<?php echo $admin_logout_link; ?>"><i class="fa fa-power-off" aria-hidden="true"></i><?php echo __("admin/index/header-button-logout"); ?></a><div class="clearmob"></div>
            <a href="<?php echo APP_URI; ?>" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i><?php echo __("admin/index/header-button-view-site"); ?></a>
        </div>

    </div>
        
    </div>

    <div class="menu">
        <div id="wrapper">

            <div id="mobnotifibtn"><a href="javascript:void(0);" onclick="open_modal('transaction',{width:'800px'});" class="notifiballon"<?php echo $critical_transaction_notifications_count ? ' id="notifiballonalert"' : ''; ?>><i class="fa fa-bell" aria-hidden="true"></i></a></div>

            <a href="javascript:$('.mobmenu').slideToggle();void 0;" class="menuAc"><i class="fa fa-bars" aria-hidden="true"></i></a>
            <a class="mobyonbtn sbtn" href="javascript:$('.yonetici').slideToggle();void 0;"><i class="fa fa-cog" aria-hidden="true"></i></a>
            <ul class="mobmenus" style="transition-property: all; transition-duration: 0s; transition-timing-function: ease; opacity: 1;">
                <?php
                menu_walk($menus,false,['mobile' => false]);
                ?>
            </ul>
        </div>
    </div>

    <div class="mobmenu">
        <ul>
            <?php
            menu_walk($menus,false,['mobile' => true]);
            ?>
        </ul>
    </div>



</div>


<?php include __DIR__.DS."startup-wizard.php"; ?>