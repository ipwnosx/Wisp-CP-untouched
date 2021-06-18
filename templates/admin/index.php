<!DOCTYPE html>
<html>
<head>
    <?php
        $is_dashboard         = true;
        $order_privOperation  = Admin::isPrivilege("ORDERS_OPERATION");
        $order_privDelete     = Admin::isPrivilege("ORDERS_DELETE");
        $plugins    = ['isotope','jquery-ui','dataTables','Sortable'];
        include __DIR__.DS."inc".DS."head.php";
    ?>

    <script type="text/javascript">
        var sortable,dashboardconToggle=false;

        $(document).ready(function(){

            var widget_isotope = <?php echo $widget_isotope ? "true" : "false"; ?>;

            if(widget_isotope){
                $('#widget-items').isotope({itemSelector: 'li'});
                $(".widget-move").css("display","none");
                $(".widget-toggle-status").css("display","none");
            }


            if(!isMobile() && !widget_isotope){
                sortable = Sortable.create(document.getElementById('widget-items'),{
                    sort: true,
                    animation: 150,
                    draggable: "li",
                    handle: ".icerikbaslik",
                    forceFallback: true,
                    onEnd: function (evt){
                        var values = $(".widget-status-input").map(function(){return $(this).data("name"); }).get();

                        var request = MioAjax({
                            action: "<?php echo $links["controller"]; ?>",
                            method: "POST",
                            data:{operation:"change_widgets_rank",values:values}
                        },true,true);

                        request.done(function (result){
                            if(result != ''){
                                var solve = getJson(result);
                                if(solve !== false){
                                    if(solve.status == "error"){
                                        if(solve.message != undefined && solve.message != '')
                                            alert_error(solve.message,{timer:5000});
                                    }
                                }else
                                    console.log(result);
                            }
                        });
                    }
                });
            }
            else
                $(".widget-move").css("display","none");

            $(".widget-toggle-status").click(function(){
                var w_name = $(this).data("name");
                var current_status  = $("input[name='widget["+w_name+"][status]']").val();
                var new_status      = current_status === 'open' ? 'close' : 'open';
                $("#widget-"+w_name).removeClass("widget-open");
                $("#widget-"+w_name).removeClass("widget-close");
                $("#widget-"+w_name+" .widget-toggle-status i").removeClass("fa-window-maximize");
                $("#widget-"+w_name+" .widget-toggle-status i").removeClass("fa-minus");

                $("#widget-"+w_name).addClass("widget-"+new_status);
                $("#widget-"+w_name+" .widget-toggle-status i").addClass(new_status === 'open' ? 'fa-minus' : 'fa-window-maximize');
                $("input[name='widget["+w_name+"][status]']").val(new_status);

                var request = MioAjax({
                    action: "<?php echo $links["controller"]; ?>",
                    method: "POST",
                    data:{operation:"change_widget_status",status:new_status,name:w_name}
                },true,true);

                request.done(function (result){
                    if(result != ''){
                        var solve = getJson(result);
                        if(solve !== false){
                            if(solve.status == "error"){
                                if(solve.message != undefined && solve.message != '')
                                    alert_error(solve.message,{timer:5000});
                            }
                        }else
                            console.log(result);
                    }
                });

            });

            $("#widgetConfigForm").change(function(){
                var request = MioAjax({
                    form:$(this),
                },true,true);
                request.done(function(result){
                    if(result != ''){
                        var solve = getJson(result);
                        if(solve !== false){
                            if(solve.status == "error"){
                                if(solve.message != undefined && solve.message != '')
                                    alert_error(solve.message,{timer:5000});
                            }
                            if(solve.redirect !== undefined && solve.redirect !== false)
                                window.location.href = solve.redirect;
                        }else
                            console.log(result);
                    }
                });
            });

        });

        function dashboardcon_toggle(){
            if(dashboardconToggle){
                $(".dashboardcon").css("right","-284px");
                dashboardconToggle = false;
            }else{
                $(".dashboardcon").css("right","0px");
                dashboardconToggle = true;
            }
        }
    </script>
</head>
<body>

<div class="dashboardcon">
    <a href="javascript:dashboardcon_toggle();void 0;" class="dashboardcoc"><i class="fa fa-filter" aria-hidden="true"></i></a>
    <div class="dashboardcocinfo">
        <div class="padding20">

            <form action="<?php echo $links["controller"]; ?>" method="post" id="widgetConfigForm">
                <input type="hidden" name="operation" value="update_widget_config">
                <div class="formcon">
                    <input<?php echo !$widget_isotope ? ' checked' : ''; ?> type="radio" class="sitemio-checkbox" name="widget_isotope" value="0" id="widget_isotope_close">
                    <label class="sitemio-checkbox-label" for="widget_isotope_close"></label>
                    <span class="kinfo"><?php echo __("admin/index/widget-isotope-disable"); ?></span>
                </div>

                <div class="formcon">
                    <input<?php echo $widget_isotope ? ' checked' : ''; ?> type="radio" class="sitemio-checkbox" name="widget_isotope" value="1" id="widget_isotope_open">
                    <label class="sitemio-checkbox-label" for="widget_isotope_open"></label>
                    <span class="kinfo"><?php echo __("admin/index/widget-isotope-enable"); ?></span>
                </div>

                <?php
                    if(isset($widgets) && $widgets){
                        foreach($widgets AS $widget){
                            if(!$widget["allowed"]) continue;
                            $status       = $widget["status"];
                            $widget_name  = $widget["name"];
                            ?>
                            <div class="formcon">
                                <input type="hidden" name="widgets_names[]" value="<?php echo $widget_name; ?>">
                                <input<?php echo $status !== "disabled" ? ' checked' : ''; ?> type="checkbox" class="sitemio-checkbox" name="widgets[<?php echo $widget_name; ?>][status]" value="1" id="widget-<?php echo $widget_name; ?>-status">
                                <label class="sitemio-checkbox-label" for="widget-<?php echo $widget_name; ?>-status"></label>
                                <span class="kinfo"><?php echo Filter::html_clear($widget["title"]); ?></span>
                            </div>
                            <?php
                        }
                    }
                ?>
            </form>

            <div class="clear"></div>
        </div>
    </div>
</div>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">


    <?php if($statistics): ?>
        <script type="text/javascript">
            $(document).ready(function(){
                setTimeout(function(){
                    reload_dashboard_statistics();
                },100);
            });

            function reload_dashboard_statistics(){
                var result_val;
                var request = MioAjax({
                    action: "<?php echo $links["controller"]; ?>",
                    method: "GET",
                    data:{operation:"get_statistics"}
                },true,true);

                request.done(function(response){
                    if(response){
                        var solve = getJson(response);
                        if(solve){
                            if(solve.status == "successful"){
                                if(solve.results !== undefined){
                                    $(Object.keys(solve.results)).each(function(result_rank,result_key){
                                        result_val = solve.results[result_key];
                                        $("#"+result_key).html(result_val);
                                    });

                                    $("#statistics").animate({opacity:1},300);
                                }
                            }
                        }
                    }
                });
            }

            function clear_vist(){
                var request = MioAjax({
                    action: "<?php echo $links["controller"]; ?>",
                    method: "GET",
                    data:{operation:"clear_vist"}
                },true,true);

                request.done(function (result){
                    if(result != ''){
                        var solve = getJson(result);
                        if(solve !== false){
                            if(solve.status == "error"){
                                if(solve.message != undefined && solve.message != '')
                                    alert_error(solve.message,{timer:5000});
                            }else if(solve.status == "successful"){
                                alert_success(solve.message,{timer:2000});
                                reload_dashboard_statistics();
                            }
                        }else
                            console.log(result);
                    }
                });
            }
        </script>


        <div class="adminbloklar" id="statistics" style="opacity: 0.2;">

        	

            <?php if($statistic_income): ?>
                <div class="adminblok" id="yesilblok">
                    <div class="padding10">

                    <div class="hoverblock">
                        <div class="padding20">

                        <h4>
                            <span><?php echo __("admin/index/monthly-income"); ?></span>
                            <strong id="get_monthly_income">0</strong>
                            <div id="istatisticsbtn" data-balloon-pos="right" data-balloon="<?php echo __("admin/index/statistics-income-monthly"); ?>" data-balloon-pos="down">
                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                            </div>
                        </h4>

                        <h4>
                            <span><?php echo __("admin/index/last-month-income"); ?></span>
                            <strong id="get_last_month_income">0</strong>
                            <div id="istatisticsbtn" data-balloon-pos="right" data-balloon="<?php echo __("admin/index/statistics-income-last-month"); ?>" data-balloon-pos="down">
                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                            </div>
                        </h4>

                        <h4>
                            <span><?php echo __("admin/index/statistics-daily-average"); ?></span>
                            <strong id="get_daily_average_income">0</strong>
                            <div id="istatisticsbtn" data-balloon-pos="right" data-balloon="<?php echo __("admin/index/statistics-income-daily-average"); ?>" data-balloon-pos="down">
                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                            </div>
                        </h4>
                        <h4>
                            <span><?php echo __("admin/index/statistics-month-end-forecast"); ?></span>
                            <strong id="get_month_end_forecast_income">0</strong>
                            <div id="istatisticsbtn" data-balloon-pos="right" data-balloon="<?php echo __("admin/index/statistics-income-month-end-forecast"); ?>" data-balloon-pos="down">
                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                            </div>
                        </h4>
                    </div></div>

                    <div style="display:none" id="istatisticsbtn" class="tooltip-bottom" data-tooltip="<?php echo __("admin/index/income-info"); ?>" data-balloon-pos="down"><i class="fa fa-info-circle" aria-hidden="true"></i></div>
                    <i class="fa fa-money" aria-hidden="true"></i>
                    <h2 id="get_today_income">0</h2>
                    <h4><?php echo __("admin/index/today-income"); ?></h4>
                    <div class="ablokbottom"><span><?php echo __("admin/index/statistics-yesterday"); ?> <strong id="get_yesterday_income">0</strong></span></div>
                </div></div>
            <?php endif; ?>

            <?php if($statistic_cash): ?>
                <a href="<?php echo Controllers::$init->AdminCRLink("invoices-1",["cash"]); ?>">
                    <div class="adminblok" id="turuncublok">
                        <div class="padding10">

                        <div class="hoverblock">
                            <div class="padding20">
                            <h4>
                                <span><?php echo __("admin/index/statistics-today-outgoing"); ?></span>
                                <strong id="get_today_outgoing_cash">0</strong>
                                <div id="istatisticsbtn" data-balloon-pos="right" data-balloon="<?php echo __("admin/index/statistics-cash-today-outgoing"); ?>" data-balloon-pos="down">
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                </div>
                            </h4>
                            <h4>
                                <span><?php echo __("admin/index/statistics-yesterday-outgoing"); ?></span>
                                <strong id="get_yesterday_outgoing_cash">0</strong>
                                <div id="istatisticsbtn" data-balloon-pos="right" data-balloon="<?php echo __("admin/index/statistics-cash-yesterday-outgoing"); ?>" data-balloon-pos="down">
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                </div>
                            </h4>
                            <h4>
                                <span><?php echo __("admin/index/statistics-profit-loss"); ?></span>
                                <strong id="get_profit_loss_cash">0</strong>
                                <div id="istatisticsbtn" data-balloon-pos="right" data-balloon="<?php echo __("admin/index/statistics-cash-profit-loss"); ?>" data-balloon-pos="down">
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                </div>
                            </h4>

                            <h4>
                                <span><?php echo __("admin/index/statistics-previous-month-profit-loss"); ?></span>
                                <strong id="get_previous_month_profit_loss_cash">0</strong>
                                <div id="istatisticsbtn" data-balloon-pos="right" data-balloon="<?php echo __("admin/index/statistics-cash-previous-month-profit-loss"); ?>" data-balloon-pos="down">
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                </div>
                            </h4>
                        </div></div>

                        <div style="display:none" id="istatisticsbtn" class="tooltip-bottom" data-tooltip="<?php echo __("admin/index/cash-status-info"); ?>" data-balloon-pos="down"><i class="fa fa-info-circle" aria-hidden="true"></i></div>
                        <i class="fa fa-university" aria-hidden="true"></i>
                        <h2 id="get_total_cash">0</h2>
                        <h4><?php echo __("admin/index/cash-status"); ?></h4>
                        <div class="ablokbottom"><span><?php echo __("admin/index/cash-this-month-expense"); ?> <strong id="get_this_month_outgoing_cash">0</strong></span></div>
                    </div></div>
                </a>
            <?php endif; ?>



            <?php if($statistic_user): ?>
                <a href="<?php echo Controllers::$init->AdminCRLink("users"); ?>">
                    <div class="adminblok" id="maviblok">
                        <div class="padding10">

                        <div class="hoverblock">
                            <div class="padding20">
                            <h4>
                                <span><?php echo __("admin/index/total-user"); ?></span>
                                <strong id="get_total_user">0</strong>
                                <div id="istatisticsbtn" data-balloon-pos="right" data-balloon="<?php echo __("admin/index/statistics-user-total"); ?>" data-balloon-pos="down">
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                </div>
                            </h4>
                            <!--<h4>
                                <span><?php echo __("admin/index/statistics-yesterday"); ?></span>
                                <strong id="get_yesterday2_user">0</strong>
                                <div id="istatisticsbtn" data-balloon-pos="right" data-balloon="<?php echo __("admin/index/statistics-user-yesterday"); ?>" data-balloon-pos="down"><i class="fa fa-info-circle" aria-hidden="true"></i>
                                </div>
                            </h4>-->
                            <h4>
                                <span><?php echo __("admin/index/statistics-this-month"); ?></span>
                                <strong id="get_this_month_user">0</strong>
                                <div id="istatisticsbtn" data-balloon-pos="right" data-balloon="<?php echo __("admin/index/statistics-user-this-month"); ?>" data-balloon-pos="down">
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                </div>
                            </h4>
                            <h4>
                                <span><?php echo __("admin/index/statistics-previous-month"); ?></span>
                                <strong id="get_previous_month_user">0</strong>
                                <div id="istatisticsbtn" data-balloon-pos="right" data-balloon="<?php echo __("admin/index/statistics-user-previous-month"); ?>" data-balloon-pos="down">
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                </div>
                            </h4>
                        </div></div>

                        <i class="fa fa-users" aria-hidden="true"></i>
                        <h2 id="get_today_user">0</h2>
                        <h4><?php echo __("admin/index/today-total-user"); ?></h4>
                        <div class="ablokbottom"><span><?php echo __("admin/index/yesterday-total-user"); ?> <strong id="get_yesterday_user">0</strong></span></div>
                    </div></div>
                </a>
            <?php endif; ?>

            <?php if($statistic_tickets): ?>
                <a href="<?php echo Controllers::$init->AdminCRLink("tickets"); ?>">
                    <div class="adminblok" id="redblok">
                        <div class="padding10">
                        <div class="hoverblock">
                            <div class="padding20">
                            <h4>
                                <span><?php echo __("admin/index/statistics-today"); ?></span>
                                <strong id="get_today_open_tickets">0</strong>
                                <div id="istatisticsbtn" data-balloon-pos="right" data-balloon="<?php echo __("admin/index/statistics-tickets-today"); ?>" data-balloon-pos="down">
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                </div>
                            </h4>
                            <h4>
                                <span><?php echo __("admin/index/statistics-yesterday"); ?></span>
                                <strong id="get_yesterday_open_tickets">0</strong>
                                <div id="istatisticsbtn" data-balloon-pos="right" data-balloon="<?php echo __("admin/index/statistics-tickets-yesterday"); ?>" data-balloon-pos="down"><i class="fa fa-info-circle" aria-hidden="true"></i></div>
                            </h4>
                            <h4>
                                <span><?php echo __("admin/index/statistics-this-month"); ?></span>
                                <strong id="get_this_month_solved_tickets">0</strong>
                                <div id="istatisticsbtn" data-balloon-pos="right" data-balloon="<?php echo __("admin/index/statistics-tickets-this-month"); ?>" data-balloon-pos="down">
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                </div>
                            </h4>
                            <h4>
                                <span><?php echo __("admin/index/statistics-previous-month"); ?></span>
                                <strong id="get_previous_month_solved_tickets">0</strong>
                                <div id="istatisticsbtn" data-balloon-pos="right" data-balloon="<?php echo __("admin/index/statistics-tickets-previous-month"); ?>" data-balloon-pos="down">
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                </div>
                            </h4>
                        </div></div>
                        <i class="fa fa-life-ring" aria-hidden="true"></i>
                        <h2 id="get_waiting_tickets">0</h2>
                        <h4><?php echo __("admin/index/waiting-tickets"); ?></h4>
                        <div class="ablokbottom"><span><?php echo __("admin/index/total-tickets"); ?> <strong id="get_total_tickets">0</strong></span></div>
                    </div></div>
                </a>
            <?php endif; ?>

            <?php /* if($statistic_visitors): ?>

                <div class="adminblok" id="turquazblok">
                    <div class="padding10">
                    <div class="hoverblock">
                        <div class="padding20">
                        <h4>
                            <span><?php echo __("admin/index/statistics-today"); ?></span>
                            <strong id="get_today_visit">0</strong>
                            <div id="istatisticsbtn" data-balloon-pos="left" data-balloon="<?php echo __("admin/index/statistics-visit-today"); ?>" data-balloon-pos="down">
                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                            </div>
                        </h4>
                        <h4>
                            <span><?php echo __("admin/index/statistics-yesterday"); ?></span>
                            <strong id="get_yesterday2_visit">0</strong>
                            <div id="istatisticsbtn" data-balloon-pos="left" data-balloon="<?php echo __("admin/index/statistics-visit-yesterday"); ?>" data-balloon-pos="down">
                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                            </div>
                        </h4>
                        <h4>
                            <span><?php echo __("admin/index/statistics-this-month"); ?></span>
                            <strong id="get_this_month_visit">0</strong>
                            <div id="istatisticsbtn" data-balloon-pos="left" data-balloon="<?php echo __("admin/index/statistics-visit-this-month"); ?>" data-balloon-pos="down">
                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                            </div>
                        </h4>
                        <h4>
                            <span><?php echo __("admin/index/statistics-previous-month"); ?></span>
                            <strong id="get_previous_month_visit">0</strong>
                            <div id="istatisticsbtn" data-balloon-pos="left" data-balloon="<?php echo __("admin/index/statistics-visit-previous-month"); ?>" data-balloon-pos="down">
                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                            </div>
                        </h4>

                        <h4>

                            <div id="istatisticsbtn" data-balloon-pos="left" data-balloon="<?php echo __("admin/index/clear-vist"); ?>" data-balloon-pos="down">
                                <a href="javascript:clear_vist();void 0;"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </div>
                        </h4>
                    </div></div>


                    <i class="fa fa-bar-chart" aria-hidden="true"></i>
                    <h2 id="get_daily_visit">0</h2>
                    <h4><?php echo __("admin/index/daily-visit"); ?></h4>
                    <div class="ablokbottom"><span><?php echo __("admin/index/yesterday-visit"); ?> <strong id="get_yesterday_visit">0</strong></span></div>
                </div></div>

            <?php endif;*/ ?>

            <?php if(isset($statistic_ovinv) && $statistic_ovinv): ?>
                <a href="<?php echo Controllers::$init->AdminCRLink("invoices-1",["overdue"]); ?>">
                    <div class="adminblok" id="overdue-invoice"><div class="padding10">
                            <i class="ion-ios-alarm-outline" aria-hidden="true"></i>
                            <h2 id="get_total_overdue_invoice_count">0</h2>
                            <h4><?php echo __("admin/index/statistics-overdue-invoice"); ?><span>(<?php echo __("admin/index/invoices-total-amount"); ?> <b id="get_total_overdue_invoice_amount">0</b>)</span></h4>
                            <div class="clear"></div>
                        </div> </div>
                </a>
            <?php endif; ?>



            <?php if(isset($statistic_upds) && $statistic_upds): ?>
                <a href="<?php echo Controllers::$init->AdminCRLink("invoices-1",["upcoming"]); ?>">
                    <div class="adminblok" id="endtimecoming">
                        <div class="padding10">
                            <i class="ion-ios-timer-outline" aria-hidden="true"></i>
                            <h2 id="get_total_upds_count">0</h2>
                            <h4><?php echo __("admin/index/statistics-upcoming-payment-due-service"); ?><span>(<?php echo __("admin/index/invoices-total-amount"); ?> <b id="get_total_upds_amount">0</b> / <?php echo __("admin/index/statistics-upcoming-payment-due-service-2"); ?>)</span></h4>
                            <div class="clear"></div>
                        </div>
                    </div>
                </a>
            <?php endif; ?>

            <?php if(isset($statistic_seps) && $statistic_seps): ?>
                <a href="<?php echo Controllers::$init->AdminCRLink("orders-1",["inprocess"]); ?>">
                    <div class="adminblok" id="order-inprocess"><div class="padding10">

                            <i class="ion-gear-a" aria-hidden="true"></i>
                            <h2 id="get_total_seps_count">0</h2>
                            <h4><?php echo __("admin/index/statistics-service-in-progress"); ?><span>(<?php echo __("admin/index/invoices-total-amount"); ?> <b id="get_total_seps_amount">0</b>)</span></h4>
                            <div class="clear"></div>
                        </div>
                    </div>
                </a>
            <?php endif; ?>


            <?php if(isset($statistic_tyrs) && $statistic_tyrs): ?>
                <a href="<?php echo Controllers::$init->AdminCRLink("tools-1",["reminders"]); ?>">
                    <div class="adminblok" id="todayreminder"><div class="padding10">
                            <i class="ion-pin" aria-hidden="true"></i>
                            <h2 id="get_total_tyrs">0</h2>
                            <h4><?php echo __("admin/index/statistics-tyrs"); ?><span>(<?php echo __("admin/index/statistics-tyrs-2"); ?>)</span></h4>
                            <div class="clear"></div>
                        </div>
                    </div>
                </a>
            <?php endif; ?>


        </div>
    <?php endif; ?>

    <div class="clear"></div>
    <div class="admanabloks" style="margin-bottom: 27px;">
        <?php
            $v_widgets  = $widgets;
            if(isset($widgets) && $widgets){
                foreach($widgets AS $k => $widget){
                    if(!$widget["allowed"] || $widget["status"] == "disabled") continue;
                    $widget_name = $widget["name"];
                    if($widget_name == 'last_orders'){
                        unset($v_widgets[$k]);

                        ?>
                        <div class="icerik-container" id="widget-lastbookings">
                            <div class="icerik">
                                <div class="icerikbaslik">
                                    <h1><strong class="widget-title" id="anablokbaslik"><?php echo $widget["title"]; ?><span class="widget-title-extra"></span></strong></h1>
                                    <?php
                                        if(isset($widget["buttons"]) && $widget["buttons"]){
                                            foreach($widget["buttons"] AS $button){
                                                ?>
                                                <a class="lbtn" href="<?php echo $button["link"]; ?>"><?php echo $button["name"]; ?></a>
                                                <?php
                                            }
                                        }
                                    ?>
                                </div>
                                <div class="widget-content">
                                    <?php
                                        $privOperation  = $order_privOperation;
                                        $privDelete     = false;
                                        $from           = "index";
                                        $situations     = $order_situations;
                                        $list 		    = isset($last_orders) ? $last_orders : [];
                                        $aaData         = $list ? include __DIR__.DS."ajax-orders.php" : [];

                                        if($aaData){
                                            ?>
                                            <table width="100%" border="0">
                                                <thead style="background:#ebebeb;">
                                                <tr>
                                                    <th align="left"><?php echo __("admin/orders/list-customer-name"); ?></th>
                                                    <th align="left"><?php echo __("admin/orders/list-product-name"); ?></th>
                                                    <th align="left"><?php echo __("admin/orders/list-product-group"); ?></th>
                                                    <th align="center"><?php echo __("admin/orders/list-create-date"); ?></th>
                                                    <th align="center"><?php echo __("admin/orders/list-amount-period"); ?></th>
                                                    <th align="center"><?php echo __("admin/orders/list-status"); ?></th>
                                                    <th align="center"> </th>
                                                </tr>
                                                </thead>
                                                <tbody align="Center" style="border-top:none;">
                                                <?php
                                                    if($aaData){
                                                        foreach($aaData AS $row){
                                                            ?>
                                                            <tr>
                                                                <td align="left"><?php echo $row[2]; ?></td>
                                                                <td align="left"><?php echo $row[3]; ?></td>
                                                                <td align="left"><?php echo $row[4]; ?></td>
                                                                <td align="center"><?php echo $row[5]; ?></td>
                                                                <td align="center"><?php echo $row[6]; ?></td>
                                                                <td align="center"><?php echo $row[7]; ?></td>
                                                                <td align="center"><?php echo $row[8]; ?></td>
                                                            </tr>
                                                            <?php
                                                        }
                                                    }
                                                ?>
                                                </tbody>
                                            </table>
                                            <?php
                                        }
                                        else{
                                            ?>
                                            <div class="noconentblock">
                                                <i style="font-size:80px;" class="fa fa-info-circle"></i>
                                                <h4 style="margin-top:15px;font-weight:bold;"><?php echo __("admin/index/no-last-orders-1"); ?></h4>
                                                <h5><?php echo __("admin/index/no-last-orders-2"); ?></h5>
                                            </div>
                                            <?php
                                        }
                                    ?>
                                </div>

                            </div>
                        </div>
                        <?php

                    }
                }
            }

        ?>

        <div class="clear"></div>
        <ul id="widget-items">
            <?php
                if(isset($v_widgets) && $v_widgets){
                    foreach($v_widgets AS $widget){
                        if(!$widget["allowed"] || $widget["status"] == "disabled") continue;
                        $widget_name = $widget["name"];
                        ?>
                        <li>
                            <input type="hidden" name="widget[<?php echo $widget_name; ?>][status]" value="<?php echo $widget["status"]; ?>" class="widget-status-input" data-name="<?php echo $widget_name; ?>">
                            <div class="icerik-container widget-item <?php echo $widget["status"] == "open" ? 'widget-open' : 'widget-close'; ?>" id="widget-<?php echo $widget_name; ?>">
                                <div class="icerik">
                                    <div class="icerikbaslik">
                                        <h1><strong class="widget-title" id="anablokbaslik"><?php echo $widget["title"]; ?><span class="widget-title-extra"></span></strong></h1>

                                        <a class="sbtn widget-move" style="cursor:move;" data-name="<?php echo $widget_name; ?>"><i class="fa fa-arrows-alt"></i></a>
                                        <a class="sbtn widget-toggle-status" style="cursor: pointer;" data-name="<?php echo $widget_name; ?>"><i class="fa <?php echo $widget["status"] == "open" ? 'fa-minus' : 'fa-window-maximize'; ?>"></i></a>
                                        <?php
                                            if(isset($widget["buttons"]) && $widget["buttons"]){
                                                foreach($widget["buttons"] AS $button){
                                                    ?>
                                                    <a class="lbtn" href="<?php echo $button["link"]; ?>"><?php echo $button["name"]; ?></a>
                                                    <?php
                                                }
                                            }
                                        ?>
                                    </div>
                                    <div class="widget-content">
                                        <?php

                                            if($widget_name == 'pending_invoices'){
                                                ?>
                                                <?php if(isset($pending_approval_invoices) && $pending_approval_invoices): ?>
                                                    <table width="100%" border="0" >
                                                        <thead style="background:#ebebeb;">
                                                        <tr>
                                                            <th align="left"><?php echo __("admin/index/invoices-desc"); ?></th>
                                                            <th width="120" align="center"><?php echo __("admin/index/invoices-amount"); ?></th>
                                                            <th align="center"><?php echo __("admin/index/transaction"); ?></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody align="Center" style="border-top:none;">
                                                        <?php
                                                            foreach($pending_approval_invoices AS $row){
                                                                $user_link  = Controllers::$init->AdminCRLink("users-2",["detail",$row["user_id"]]);
                                                                $user_name  = $row["user_name"];
                                                                if($row["user_company_name"])
                                                                    $user_name .= " (".$row["user_company_name"].")";
                                                                $detail_link    = Controllers::$init->AdminCRLink("invoices-2",["detail",$row["id"]]);
                                                                ?>
                                                                <tr>
                                                                    <td align="left">
                                                                        <a href="#"><strong><?php echo __("admin/index/invoices-row-bill"); ?> #<?php echo $row["id"]; ?></strong></a>
                                                                        (<?php echo __("admin/invoices/bills-th-duedate").': '.DateManager::format(Config::get("options/date-format"),$row["duedate"]); ?>)
                                                                        <br>
                                                                        <a href="<?php echo $user_link; ?>" target="_blank"><span class="userinfo"><?php echo $user_name; ?></span></a>
                                                                    </td>
                                                                    <td align="center"><strong><?php echo Money::formatter_symbol($row["total"],$row["currency"]); ?></strong><br>(<?php echo __("admin/index/invoices-total-amount"); ?>)</td>
                                                                    <td align="center">
                                                                        <!-- {width:'800px'} -->
                                                                        <a href="<?php echo $detail_link; ?>" class="sbtn"><i class="fa fa-search" aria-hidden="true"></i></a>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                            }
                                                        ?>
                                                        </tbody>
                                                    </table>
                                                <?php else: ?>
                                                    <div class="noconentblock">
                                                        <i style="font-size:80px;" class="fa fa-thumbs-o-up"></i>
                                                        <h4 style="margin-top:15px;font-weight:bold;"><?php echo __("admin/index/pending-approval-invoices-no-1"); ?></h4>
                                                        <h5><?php echo __("admin/index/pending-approval-invoices-no-2"); ?></h5>
                                                    </div>
                                                <?php endif; ?>
                                                <?php
                                            }

                                            elseif($widget_name == 'pending_tickets'){
                                                ?>
                                                <?php if(isset($pending_replying_tickets) && $pending_replying_tickets): ?>
                                                    <table width="100%" border="0">
                                                        <thead style="background:#ebebeb;">
                                                        <tr>
                                                            <th align="left"><?php echo __("admin/index/tickets-subject"); ?></th>
                                                            <th width="120" align="center"><?php echo __("admin/index/tickets-date"); ?></th>
                                                            <th align="center"><?php echo __("admin/index/transaction"); ?></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody align="Center" style="border-top:none;">
                                                        <?php
                                                            foreach($pending_replying_tickets AS $row){
                                                                $user_link  = Controllers::$init->AdminCRLink("users-2",["detail",$row["user_id"]]);
                                                                $user_name  = $row["user_name"];
                                                                if($row["user_company_name"])
                                                                    $user_name .= " (".$row["user_company_name"].")";
                                                                $detail_link    = Controllers::$init->AdminCRLink("tickets-2",["detail",$row["id"]]);
                                                                ?>
                                                                <tr>
                                                                    <td align="left"><a href="<?php echo $detail_link; ?>"><strong><?php echo Utility::short_text($row["title"],0,40,true); ?></strong></a>
                                                                        <?php echo $ticket_situations[$row["status"]]; ?>
                                                                        <br/>
                                                                        <a href="<?php echo $user_link; ?>" target="_blank"><span class="userinfo"><?php echo $user_name; ?></span></a>
                                                                    </td>
                                                                    <td align="center"><?php echo str_replace(" - ","<br>",DateManager::format(Config::get("options/date-format")." - H:i",$row["ctime"])); ?></td>
                                                                    <td align="center">
                                                                        <a href="<?php echo $detail_link; ?>" class="sbtn" data-tooltip="<?php echo __("admin/index/tickets-quick-reply"); ?>"><i class="fa fa-search" aria-hidden="true"></i></a>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                            }
                                                        ?>
                                                        </tbody>
                                                    </table>
                                                <?php else: ?>
                                                    <div  class="noconentblock">
                                                        <i style="font-size:80px;" class="fa fa-thumbs-o-up"></i>
                                                        <h4 style="margin-top:15px;font-weight:bold;"><?php echo __("admin/index/pending-replying-ticket-requests-1"); ?></h4>
                                                        <h5><?php echo __("admin/index/pending-replying-ticket-requests-2"); ?></h5>
                                                    </div>
                                                <?php endif; ?>
                                                <?php
                                            }

                                            elseif($widget_name == "staff_online"){
                                                ?>
                                                <div id="online_list" style="opacity:0;display:none;"></div>
                                                <div id="online_list_none">
                                                    <div  class="noconentblock">
                                                        <i style="font-size:80px;" class="fa fa-ban"></i>
                                                        <h4 style="margin-top:15px;font-weight:bold;"><?php echo __("admin/index/none-staff-online-1"); ?></h4>
                                                        <h5><?php echo __("admin/index/none-staff-online-2"); ?></h5>
                                                    </div>
                                                </div>
                                                <?php
                                            }

                                            elseif($widget_name == "client_online"){
                                                ?>
                                                <div id="client_online_list" style="opacity:0;display:none;"></div>
                                                <div id="client_online_list_none">
                                                    <div  class="noconentblock">
                                                        <i style="font-size:80px;" class="fa fa-ban"></i>
                                                        <h4 style="margin-top:15px;font-weight:bold;"><?php echo __("admin/index/none-client-online-1"); ?></h4>

                                                        <h5><?php echo __("admin/index/none-client-online-2"); ?></h5>
                                                    </div>
                                                </div>
                                                <?php
                                            }

                                            elseif($widget_name == "notes"){
                                                ?>
                                                <textarea style="font-size:14px;" id="notes" cols="" rows="3" placeholder="<?php echo __("admin/index/admin-notes-input"); ?>"><?php echo $notes; ?></textarea>
                                                <?php
                                            }

                                            elseif($widget_name == "reminders"){
                                                $reminder_modal_create = true;

                                                ?>
                                                <?php if(isset($reminders) && $reminders): ?>
                                                    <table width="100%" border="0">
                                                        <thead style="background:#ebebeb;">
                                                        <tr>
                                                            <th align="left" data-orderable="false"><?php echo __("admin/tools/reminders-note"); ?></th>
                                                            <th align="center" data-orderable="false"><?php echo __("admin/tools/reminders-period"); ?></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody align="Center" style="border-top:none;">
                                                        <?php
                                                            foreach($reminders AS $row){

                                                                $zero_month     = $row["period_month"];
                                                                $zero_day       = $row["period_day"];
                                                                $zero_hour      = $row["period_hour"];
                                                                $zero_minute    = $row["period_minute"];

                                                                if($row["period_month"]>-1 && $row["period_month"] < 10) $zero_month = "0".$row["period_month"];
                                                                if($row["period_day"]>-1 && $row["period_day"] < 10) $zero_day = "0".$row["period_day"];
                                                                if($row["period_hour"]>-1 && $row["period_hour"] < 10) $zero_hour = "0".$row["period_hour"];
                                                                if($row["period_minute"]>-1 && $row["period_minute"] < 10) $zero_minute = "0".$row["period_minute"];

                                                                $period             = __("admin/tools/reminders-period-".$row["period"]);

                                                                if($row["period"] == "onetime"){
                                                                    $period .= "<br>";
                                                                    $period .= DateManager::format(Config::get("options/date-format")." H:i",$row["period_datetime"]);
                                                                }elseif($row["period"] == "recurring"){
                                                                    $period .= "<br>";
                                                                    if($zero_month == -1)
                                                                        $period .= ___("date/every-month");
                                                                    else
                                                                        $period .= DateManager::month_name($zero_month);

                                                                    $period .= " / ";

                                                                    if($zero_day == -1)
                                                                        $period .= ___("date/every-day");
                                                                    else
                                                                        $period .= $zero_day.". ".___("date/day");

                                                                    $period .= " / ";

                                                                    $period .= $zero_hour.":".$zero_minute;

                                                                }

                                                                ?>
                                                                <tr>
                                                                    <td align="left">
                                                                        <span title="<?php echo $row["note"]; ?>"><?php echo Utility::short_text($row["note"],0,40,true); ?></span>
                                                                    </td>
                                                                    <td align="center"><?php echo $period; ?></td>
                                                                </tr>
                                                                <?php
                                                            }
                                                        ?>
                                                        </tbody>
                                                    </table>
                                                <?php else: ?>
                                                    <div  class="noconentblock">
                                                        <i style="font-size:80px;" class="fa fa-thumbs-o-up"></i>
                                                        <h4 style="margin-top:15px;font-weight:bold;"><?php echo __("admin/index/none-reminders-1"); ?></h4>

                                                        <h5><?php echo __("admin/index/none-reminders-2"); ?></h5>
                                                    </div>
                                                <?php endif; ?>
                                                <?php

                                            }

                                            elseif($widget_name == "tasks"){

                                                ?>
                                                <?php if(isset($tasks) && $tasks): ?>
                                                    <table width="100%" border="0">
                                                        <thead style="background:#ebebeb;">
                                                        <tr>
                                                            <th align="left" data-orderable="false"><?php echo __("admin/tools/tasks-title"); ?></th>
                                                            <th align="center" data-orderable="false"><?php echo __("admin/tools/tasks-status"); ?></th>
                                                            <th align="center" data-orderable="false"></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody align="Center" style="border-top:none;">
                                                        <?php
                                                            foreach($tasks AS $row){
                                                                $detail_link        = Controllers::$init->AdminCRLink("tools-2",["tasks","detail"])."?id=".$row["id"];
                                                                ?>
                                                                <tr>
                                                                    <td align="left"><span title="<?php echo htmlentities($row["title"],ENT_QUOTES); ?>"><?php echo Utility::short_text($row["title"],0,40,true); ?></span></td>
                                                                    <td align="center"><?php echo $task_situations[$row["status"]]; ?></td>
                                                                    <td align="center">
                                                                        <a href="<?php echo $detail_link; ?>" data-tooltip="<?php echo ___("needs/view"); ?>" class="sbtn"><i class="fa fa-search"></i></a>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                            }
                                                        ?>
                                                        </tbody>
                                                    </table>
                                                <?php else: ?>
                                                    <div  class="noconentblock">
                                                        <i style="font-size:80px;" class="fa fa-thumbs-o-up"></i>
                                                        <h4 style="margin-top:15px;font-weight:bold;"><?php echo __("admin/index/none-tasks-1"); ?></h4>

                                                        <h5><?php echo __("admin/index/none-tasks-2"); ?></h5>
                                                    </div>
                                                <?php endif; ?>
                                                <?php


                                            }

                                        ?>


                                    </div>

                                </div>
                            </div>
                        </li>
                        <?php

                    }
                }
            ?>
        </ul>
        <div class="clear"></div>
    </div>


</div>

<div class="clear"></div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

<?php
    if(isset($reminder_modal_create) && $reminder_modal_create){
        ?>
        <div id="add_new_reminder" style="display: none;" data-izimodal-title="<?php echo __("admin/tools/reminders-create"); ?>">
            <script type="text/javascript">
                $(document).ready(function(){

                    $("#add_new_reminder_form_submit").on("click",function(){
                        MioAjaxElement($(this),{
                            waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                            progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                            result:"add_new_reminder_form_handler",
                        });
                    });

                });

                function add_new_reminder_form_handler(result){
                    if(result != ''){
                        var solve = getJson(result);
                        if(solve !== false){
                            if(solve.status == "error"){
                                if(solve.for != undefined && solve.for != ''){
                                    $("#manageModal #add_new_reminder_form "+solve.for).focus();
                                    $("#manageModal #add_new_reminder_form "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                    $("#manageModal #add_new_reminder_form "+solve.for).change(function(){
                                        $(this).removeAttr("style");
                                    });
                                }
                                if(solve.message != undefined && solve.message != '')
                                    alert_error(solve.message,{timer:5000});
                            }else if(solve.status == "successful"){
                                alert_success(solve.message,{timer:2000});
                                window.location.href = '<?php echo $links["controller"]; ?>';
                            }
                        }else
                            console.log(result);
                    }
                }
            </script>
            <div class="padding15">

                <div class="adminpagecon">
                    <form id="add_new_reminder_form" action="<?php echo Controllers::$init->AdminCRLink("tools-1",["reminders"]); ?>" method="post">
                        <input type="hidden" name="operation" value="add_new_reminder">
                        <input type="hidden" name="id" value="0">
                        <input type="hidden" name="from" value="index">

                        <div class="formcon">
                            <div class="yuzde30"><?php echo __("admin/tools/reminders-note"); ?></div>
                            <div class="yuzde70">
                                <textarea name="note" rows="5"></textarea>
                            </div>
                        </div>

                        <div class="formcon">
                            <div class="yuzde30"><?php echo __("admin/tools/reminders-status"); ?></div>
                            <div class="yuzde70">
                                <?php
                                    if(isset($reminder_situations) && $reminder_situations){
                                        foreach($reminder_situations AS $key=>$val){
                                            $val = Filter::html_clear($val);
                                            ?>
                                            <input<?php echo $key == "active" ? ' checked' : ''; ?> type="radio" class="radio-custom" id="status_<?php echo $key; ?>" name="status" value="<?php echo $key; ?>">
                                            <label class="radio-custom-label" for="status_<?php echo $key; ?>" style="margin-left:10px;"><?php echo $val; ?></label>
                                            <?php
                                        }
                                    }
                                ?>
                            </div>
                        </div>

                        <div class="formcon">
                            <div class="yuzde30"><?php echo __("admin/tools/reminders-period"); ?></div>
                            <div class="yuzde70">

                                <input checked type="radio" class="radio-custom" name="period" value="onetime" id="period_onetime" onchange="if($(this).prop('checked')) $('.period_contents').css('display','none'),$('#period_onetime_contents').css('display','block');">
                                <label class="radio-custom-label" for="period_onetime" style="margin-left: 10px;"><?php echo __("admin/tools/reminders-period-onetime"); ?></label>

                                <input type="radio" class="radio-custom" name="period" value="recurring" id="period_recurring" onchange="if($(this).prop('checked')) $('.period_contents').css('display','none'),$('#period_recurring_contents').css('display','block');">
                                <label class="radio-custom-label" for="period_recurring" style="margin-left: 10px;"><?php echo __("admin/tools/reminders-period-recurring"); ?></label>

                            </div>
                        </div>

                        <div id="period_onetime_contents" class="period_contents">
                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/tools/reminders-period-datetime"); ?></div>
                                <div class="yuzde70">
                                    <input type="datetime-local" name="period_datetime" value="">
                                </div>
                            </div>
                        </div>

                        <div id="period_recurring_contents" class="period_contents" style="display: none;">
                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/tools/reminders-period-recurring-dhi"); ?></div>
                                <div class="yuzde70">
                                    <select name="period_month" class="yuzde20">
                                        <option value="-1"><?php echo ___("date/every-month"); ?></option>
                                        <?php
                                            foreach(range(1,12) AS $num){
                                                $num_zero   = $num>9 ? $num : "0".$num;
                                                $month_name = DateManager::month_name($num_zero);
                                                ?>
                                                <option value="<?php echo $num; ?>"><?php echo $month_name; ?></option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                    <select name="period_day" class="yuzde20">
                                        <option value="-1"><?php echo ___("date/every-day"); ?></option>
                                        <?php
                                            foreach(range(1,31) AS $num){
                                                ?>
                                                <option value="<?php echo $num; ?>"><?php echo $num; ?></option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                    <input type="time" name="period_hour_minute" value="" class="yuzde20">
                                </div>
                            </div>
                        </div>

                        <div class="clear"></div>


                        <div style="float:right;margin-top:10px; margin-bottom:10px;" class="guncellebtn yuzde30">
                            <a class="yesilbtn gonderbtn" id="add_new_reminder_form_submit" href="javascript:void(0);"><?php echo ___("needs/button-create"); ?></a>
                        </div>

                    </form>
                </div>
                <div class="clear"></div>

            </div>
        </div>
        <?php
    }
?>


<script type="text/javascript">
var list_template1 = false;
var list_template2 = false;
$(document).ready(function(){

    $("#notes").on("change",function(){
        var notes = $("#notes").val();

        var response = MioAjax({
            action: "<?php echo $links["controller"]; ?>?operation=update_notes",
            method: "POST",
            data:{notes:notes}
        },true);

        if(response){
            var solve = getJson(response),content;
            if(solve){
                if(solve.status == "successful"){

                    alert_success("<?php echo __("admin/index/notes-are-saved"); ?>",{timer:2000});
                }else if(solve.status == "error"){
                    alert_error("<?php echo __("admin/index/notes-could-not-be-saved"); ?>",{timer:3000});
                }
            }
        }

    });


    <?php if($panel_onlines): ?>
    online_list();
    setInterval(online_list,5000);
    <?php endif; ?>

    <?php if($panel_client_onlines): ?>
    client_online_list();
    setInterval(client_online_list,5000);
    <?php endif; ?>

});
<?php if($panel_onlines): ?>
function online_list(){
    if(windowActive !== "on") return false;
    list_template1 = '<div class="onlineadmin">\n' +
        '                        <div class="padding15">\n' +
        '                        <img src="{avatar_image}">\n' +
        '                        <h5 style="font-size:15px;font-weight:600;">{name}</h5>\n' +
        '                        <span>{last_visited_page}</span>\n' +
        '                        </div>\n' +
        '                    </div>';

    var request = MioAjax({
        action: "<?php echo $links["controller"]; ?>",
        method: "GET",
        data:{operation:"online_list"}
    },true,true);

    request.done(function(response){
        if(response){
            var solve = getJson(response),content;
            if(solve){
                if(solve.status == "successful"){
                    $("#online_list").html('');
                    var count = 0;
                    $(solve.data).each(function(key,item){
                        content = list_template1;
                        content = content.replace("{name}",item.name);
                        content = content.replace("{group_name}",item.group_name);
                        content = content.replace("{last_visited_page}",item.last_visited_page);
                        content = content.replace("{avatar_image}",item.avatar_image);
                        $("#online_list").append(content);
                        count +=1;
                    });

                    var el1 = $("#online_list");
                    var el2 = $("#online_list_none");

                    if(count > 0){
                        $("#widget-staff_online .widget-title-extra").html(' ('+count+')');
                        if(el2.css("display") === 'block'){
                            el2.animate({opacity:0},{duration:1000,complete:function(){
                                $(this).css({opacity:0,display:'none'});
                                el1.css("display","inline-block");
                                el1.animate({opacity:1},1000);
                            }});
                        }
                    }else{
                        $("#widget-staff_online .widget-title-extra").html('');
                        if(el2.css("display") === 'none'){
                            el1.animate({opacity:0},{duration:1000,complete:function(){
                                $(this).css({opacity:0,display:'none'});
                                el2.css({opacity:0,display:'block'});
                                el2.animate({opacity:1},1000);
                            }});
                        }
                    }
                }
            }
        }
    });
}
<?php endif; ?>

<?php if($panel_client_onlines): ?>
function client_online_list(){
    if(windowActive !== "on") return false;
    list_template2 = '<div class="onlineadmin">\n' +
        '                                                        <div class="padding15">\n' +
        '                                                           <h5 style="font-size:15px;font-weight:600;"><i style="font-size:20px;margin-right:10px;" class="fa fa-user" aria-hidden="true"></i><a href="{link}" target="_blank">{name}</a></h5>\n' +
        '                                                            <span>{last_visited_page}</span>\n' +
        '                                                        </div>\n' +
        '                                                    </div>';

    var request = MioAjax({
        action: "<?php echo $links["controller"]; ?>",
        method: "GET",
        data:{operation:"client_online_list"}
    },true,true);

    request.done(function(response){
        if(response){
            var solve = getJson(response),content;
            if(solve){
                if(solve.status == "successful"){
                    $("#client_online_list").html('');
                    var count = 0;
                    $(solve.data).each(function(key,item){
                        content = list_template2;
                        content = content.replace("{name}",item.name);
                        content = content.replace("{link}",item.link);
                        content = content.replace("{last_visited_page}",item.last_visited_page);
                        content = content.replace("{ip}",item.ip);
                        $("#client_online_list").append(content);
                        count += 1;
                    });

                    var el1 = $("#client_online_list");
                    var el2 = $("#client_online_list_none");

                    if(count > 0){
                        $("#widget-client_online .widget-title-extra").html(' ('+count+')');

                        if(el2.css("display") === 'block'){
                            el2.animate({opacity:0},{duration:1000,complete:function(){
                                $(this).css({opacity:0,display:'none'});
                                el1.css("display","inline-block");
                                el1.animate({opacity:1},1000);
                            }});
                        }
                    }
                    else{
                        $("#widget-client_online .widget-title-extra").html('');

                        if(el2.css("display") === 'none'){
                            el1.animate({opacity:0},{duration:1000,complete:function(){
                                $(this).css({opacity:0,display:'none'});
                                el2.css({opacity:0,display:'block'});
                                el2.animate({opacity:1},1000);
                            }});
                        }

                    }

                }
            }
        }
    });
}
<?php endif; ?>

</script>

</body>
</html>