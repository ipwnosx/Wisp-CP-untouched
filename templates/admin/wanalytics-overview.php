<!DOCTYPE html>
<html>
<head>
    <?php
        $lang       = ___("package/code");
        $region     = ___("package/country-code");
        if(!$region) $region = "US";
        $plugins    = ['dataTables','jquery-ui'];
        include __DIR__.DS."inc".DS."head.php";
    ?>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo Config::get("contact/google-api-key"); ?>&language=<?php echo $lang; ?>&region=<?php echo $region; ?>"></script>
    <script type="text/javascript">
        var user_list=[],list_table;
        var r_statistics=false;
        var currently_online=0;

        /* Map Variables */
        var map,country_markers=[],map_center;
        var map_markers = [];
        var currentPopup;

        $(document).ready(function(){
            list_table = $('#list_table').DataTable({
                "columnDefs": [
                    {
                        "targets": [0],
                        "visible":false,
                        "searchable": false
                    }
                ],
                paging: true,
                info: true,
                searching: true,
                responsive: true,
                "oLanguage":<?php include __DIR__.DS."datatable-lang.php"; ?>
            });

            reload_statistics();

            setInterval(reload_statistics,5000);

        });

        function setup_map(zoom){
            map = new google.maps.Map(document.getElementById('chartdiv'),{
                zoom: zoom,
                center: new google.maps.LatLng(0, 0),
                styles:[
                    {
                        "elementType": "labels",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "administrative.land_parcel",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "administrative.neighborhood",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "poi",
                        "elementType": "labels.text",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "poi.business",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "road",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "road",
                        "elementType": "labels.icon",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "transit",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    }
                ],
                disableDefaultUI: true,
                zoomControl:true,
                fullscreenControl:true,
            });

            map.controls[google.maps.ControlPosition.TOP_RIGHT].clear();
        }
        function set_markers(items){
            if(map_markers.length>0) deleteMarkers();
            $(items).each(function(){
                addMarker(this);
            });
        }
        function addMarker(info) {
            var pt      = new google.maps.LatLng(info.latitude, info.longitude);

            // ,new google.maps.Size(50,50), new google.maps.Point(0, 0),new google.maps.Point(50, 50)
            var marker = new google.maps.Marker({
                position: pt,
                map: map
            });

            var content =
                '<div id="map_info_window">'+
                '<h1>'+info.country+'</h1>'+
                '<h2>'+info.city+'</h2>'+
                '<h3><?php echo __("admin/wanalytics/overview-map-info-window-count"); ?>: <strong>'+info.count+'</strong></h3>'+
                '</div>'
            ;
            content += '</div>';
            var info_window =  new google.maps.InfoWindow({
                content: content,
                Width: 200,
                map: map
            });

            google.maps.event.addListener(marker, 'mouseover', function() {
                info_window.open(map, this);
            });

            google.maps.event.addListener(marker, 'mouseout', function() {
                info_window.close();
            });

            map_markers.push(marker);
        }
        function setMapOnAll(map) {
            for (var i = 0; i < map_markers.length; i++) {
                map_markers[i].setMap(map);
            }
        }
        function clearMarkers() {
            setMapOnAll(null);
        }
        function deleteMarkers() {
            clearMarkers();
            map_markers = [];
        }
        function map_moveToLocation(lat,lng){
            map.panTo(new google.maps.LatLng(lat, lng));
        }
        function reload_statistics(){
            if(r_statistics) return false;
            r_statistics = true;

            var request = MioAjax({
                action:"<?php echo $links["base"]."overview/action/statistics.json"; ?>",
                method:"GET",
            },true,true);

            request.done(function(response){
                r_statistics = false;

               if(!map) setup_map(response.map_center.zoom);
               if(!$.compare(response.map_center,map_center)){
                   if(response.map_center.lat !== undefined)
                       map_moveToLocation(response.map_center.lat,response.map_center.lng);

                   map_center = response.map_center;
               }

               if(!$.compare(response.country_markers,country_markers)){
                   set_markers(response.country_markers);
                   country_markers = response.country_markers;
               }

                if(response.country_markers !== undefined && !$.compare(response.country_markers,country_markers))
                    set_markers(response.country_markers);


                if(response.online !== undefined && response.online !== currently_online){
                    var counter_type = 'up', counter_number = 0,counter_speed=2500;
                    if (response.online > currently_online) {
                        counter_type = 'up';
                        counter_number = response.online - currently_online;
                    } else if (response.online < currently_online) {
                        counter_type = 'down';
                        counter_number = currently_online - response.online;
                    }

                    if(counter_number < 10) counter_speed = 250;


                    $('#get_online_count').each(function(){
                        var $this = $(this),
                            countTo = response.online;
                        $({countNum: currently_online}).animate({countNum: countTo},
                            {duration: counter_speed,easing:'linear',
                                step: function() {
                                    $this.text(Math.floor(this.countNum));
                                },
                                complete: function() {
                                    $this.text(this.countNum);
                                }
                            });
                    });
                    currently_online = response.online;
                }



                if(response.user_list !== undefined && response.user_list.length > 0){
                    if(!$.compare(response.user_list,user_list)){
                        list_table.clear().draw();

                        $(response.user_list).each(function(k){
                            var set_data = [
                                k,
                                '<a href="'+this.detail_link+'" target="_blank">'+this.name+'</a>'+"<span style='display: none;' id='row_"+this.id+"'></span>",
                                this.on_page,
                                this.country+" / "+this.city,
                                '<a href="'+this.detail_link+'" target="_blank" class="sbtn"><i class="fa fa-search"></i></a>'
                            ];
                            list_table.row.add(set_data).draw(false);
                        });

                        user_list = response.user_list;
                    }
                }
                else{
                    if(list_table.rows().count()>0) list_table.clear().draw();
                    user_list = [];
                }
            });
        }
    </script>
    <style type="text/css">
        #list_table tbody tr td:nth-child(1) {
            text-align: left;
        }
    </style>

</head>
<body>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">
            <div class="icerikbaslik">
                <h1>
                    <strong><img width="150" src="<?php echo $tadress; ?>images/wanalytics.svg"/></strong>
                </h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="clear"></div>

            <div class="reports">
                <div class="reports-content">

                    <div class="icerikbaslik">
                        <h1>
                            <strong><?php echo __("admin/wanalytics/overview-real-time"); ?></strong>
                        </h1>

                        <div class="sayfayolu"><h4><?php echo __("admin/wanalytics/overview-online-clients"); ?></h4></div>
                    </div>



                    <div class="onlineclientsblock">
                        <?php echo __("admin/wanalytics/currently-online",['{count}' => '<span id="get_online_count">0</span>' ]); ?>
                    </div>

                    <div class="onlinemaps">
                        <div id="chartdiv">
                            <div align="center">
                                <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
                            </div>
                        </div>
                    </div>

                    <table width="100%" id="list_table" class="table table-striped table-borderedx table-condensed nowrap">
                        <thead style="background:#ebebeb;">
                        <tr>
                            <th align="left" style="opacity: 0;">#</th>
                            <th align="left"><?php echo __("admin/wanalytics/list-table-client"); ?></th>
                            <th align="center"><?php echo __("admin/wanalytics/list-table-on-page"); ?></th>
                            <th align="center"><?php echo __("admin/wanalytics/list-table-country-city"); ?></th>
                            <th align="center"></th>
                        </tr>
                        </thead>
                        <tbody align="Center" style="border-top:none;"></tbody>
                    </table>
                </div>
                <?php include __DIR__.DS."wanalytics-sidebar.php"; ?>
            </div>

            <div class="clear"></div>
        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>