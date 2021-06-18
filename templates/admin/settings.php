<?php
    $themeConfigure         = Admin::isPrivilege(['SETTINGS_THEME_CONFIGURE']);
    $localizationConfigure  = Admin::isPrivilege(['SETTINGS_LOCALIZATION_CONFIGURE']);
    $InformationsConfigure  = Admin::isPrivilege(['SETTINGS_INFORMATIONS_CONFIGURE']);
    $seoConfigure           = Admin::isPrivilege(['SETTINGS_SEO_CONFIGURE']);
    $membershipConfigure    = Admin::isPrivilege(['SETTINGS_MEMBERSHIP_CONFIGURE']);
    $otherConfigure         = Admin::isPrivilege(['SETTINGS_OTHER_CONFIGURE']);
?>
<!DOCTYPE html>
<html>
<head>
    <?php
        $plugins    = ['jquery-ui','jscolor','select2','jQtags'];
        include __DIR__.DS."inc".DS."head.php";
    ?>
    <script type="text/javascript">
        var
            waiting_text  = '<?php echo ___("needs/button-waiting"); ?>',
            progress_text = '<?php echo ___("needs/button-uploading"); ?>';


        function delete_background_video(lang,key){
            var request = MioAjax({
                button_element:$("#block_background_video_remove_"+lang+"_"+key),
                waiting_text:'<i class="fa fa-spinner" style="-webkit-animation:fa-spin 2s infinite linear;animation: fa-spin 2s infinite linear;"></i>',
                action:"<?php echo $links["controller"]; ?>",
                method:"POST",
                data:{
                    "operation":"delete_block_background_video",
                    "lang":lang,
                    "key":key
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
                            $("#block_background_video_play_"+lang+"_"+key).remove();
                            $("#block_background_video_remove_"+lang+"_"+key).remove();
                        }

                    }else
                        console.log(result);
                }
            });

        }

    </script>

</head>
<body>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1><?php echo __("admin/settings/page-general-name"); ?></h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>
            <script type="text/javascript">
                $(document).ready(function(){
                    $(".select2").select2({width: '100%'});
                    $(".extension-tags").tagsInput({
                        'width':'100%',
                        'height': '50px',
                        'interactive':true,
                        'defaultText':'<?php echo __("admin/settings/add-file-extension"); ?>',
                        'removeWithBackspace' : true,
                        'placeholderColor' : '#007a7a'
                    });

                    var tab = _GET("group");
                    if(tab != '' && tab != undefined){
                        $("#tab-group .tablinks[data-tab='"+tab+"']").click();
                    }else{
                        $("#tab-group .tablinks:eq(0)").addClass("active");
                        $("#tab-group .tabcontent:eq(0)").css("display","block");
                    }
                });
            </script>

            <div id="tab-group">
                <ul class="tab">

                    <?php if($InformationsConfigure): ?>
                        <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'informations','group')" data-tab="informations"> <?php echo __("admin/settings/tab-informations"); ?></a></li>
                    <?php endif; ?>

                    <?php if($seoConfigure): ?>
                        <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'seo','group')" data-tab="seo"> <?php echo __("admin/settings/tab-seo"); ?></a></li>
                    <?php endif; ?>

                    <?php if($localizationConfigure): ?>
                        <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'localization','group')" data-tab="localization"> <?php echo __("admin/settings/tab-localization"); ?></a></li>
                    <?php endif; ?>

                    <?php if($membershipConfigure): ?>
                        <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'membership','group')" data-tab="membership"> <?php echo __("admin/settings/tab-membership"); ?></a></li>
                    <?php endif; ?>

                    <?php if($otherConfigure): ?>
                        <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'other','group')" data-tab="other"> <?php echo __("admin/settings/tab-other"); ?></a></li>
                    <?php endif; ?>
                </ul>

                <?php if($InformationsConfigure): ?>
                    <div id="group-informations" class="tabcontent"><!-- tab start -->

                        <div class="adminuyedetay">
                            <form action="<?php echo $links["controller"]; ?>" method="post" enctype="multipart/form-data" id="informationsForm">
                                <input type="hidden" name="operation" value="update_informations_settings">


                                <div class="formcon">
                                    <div class="yuzde30">
                                        <?php echo __("admin/settings/contact-company-informations"); ?><br>
                                        <span style="font-size:13px;font-weight:normal;"><?php echo __("admin/settings/contact-company-informations-desc");?></span>
                                        <br>
                                        <?php
                                            foreach($lang_list AS $k=>$lang){
                                                $lkey = $lang["key"];
                                                ?>
                                                <a<?php echo $k==0 ? ' id="informations-lang-button-active"' : ''; ?> class="informations-lang-button lbtn" href="javascript:void(0);" onclick="$('.informations-lang-button').removeAttr('id'),$(this).attr('id','informations-lang-button-active'),$('.informationg-area').css('display','none'),$('#informations_area_<?php echo $lkey; ?>').css('display','block');"><?php echo strtoupper($lkey); ?></a>
                                                <?php
                                            }
                                        ?>
                                    </div>
                                    <div class="yuzde70">
                                        <?php
                                            foreach($lang_list AS $k=>$lang){
                                                $lkey = $lang["key"];
                                                ?>
                                                <textarea<?php echo $k==0 ? '' : ' style="display:none;"'; ?> rows="5" name="informations[<?php echo $lkey; ?>]" class="informationg-area" id="informations_area_<?php echo $lkey; ?>"><?php echo ___("constants/informations",false,$lkey); ?></textarea>
                                                <?php
                                            }
                                        ?>
                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/settings/contact-address"); ?></div>
                                    <div class="yuzde70">
                                        <input type="text" name="address" value="<?php echo $settings["contact"]["address"]; ?>">
                                        <span class="kinfo"><?php echo __("admin/settings/contact-address-desc"); ?></span>
                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/settings/contact-email-addresses"); ?></div>
                                    <div class="yuzde70">
                                        <input class="options-tags" type="text" name="email_addresses" value="<?php echo implode(",",$settings["contact"]["email-addresses"]); ?>">
                                        <span class="kinfo"><?php echo __("admin/settings/contact-email-addresses-desc"); ?></span>
                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/settings/contact-phone-numbers"); ?></div>
                                    <div class="yuzde70">
                                        <input class="options-tags" type="text" name="phone_numbers" value="<?php echo implode(",",$settings["contact"]["phone-numbers"]); ?>">
                                        <span class="kinfo"><?php echo __("admin/settings/contact-phone-numbers-desc"); ?></span>
                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/settings/contact-form-status"); ?></div>
                                    <div class="yuzde70">
                                        <input type="checkbox" class="sitemio-checkbox" id="contact_form_status" name="contact_form_status" value="1"<?php echo $settings["options"]["contact_form_status"] ? ' checked' : NULL; ?>>
                                        <label class="sitemio-checkbox-label" for="contact_form_status"></label>
                                        <span class="kinfo"><?php echo __("admin/settings/contact-form-status-desc"); ?></span>

                                        <div class="clear"></div>
                                        <br>

                                        <input type="checkbox" class="sitemio-checkbox" id="contact_form_mandatory_phone" name="contact_form_mandatory_phone" value="1"<?php echo $settings["options"]["contact_form_mandatory_phone"] ? ' checked' : NULL; ?>>
                                        <label class="sitemio-checkbox-label" for="contact_form_mandatory_phone"></label>
                                        <span class="kinfo"><?php echo __("admin/settings/contact-form-mandatory-phone"); ?></span>



                                    </div>
                                </div>


                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/settings/contact-map-status"); ?></div>
                                    <div class="yuzde70">
                                        <input type="checkbox" class="sitemio-checkbox" id="contact_map_status" name="contact_map_status" value="1"<?php echo $settings["options"]["contact_map_status"] ? ' checked' : NULL; ?>>
                                        <label class="sitemio-checkbox-label" for="contact_map_status"></label>
                                        <span class="kinfo"><?php echo __("admin/settings/contact-map-status-desc"); ?></span>
                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30">
                                        <?php echo __("admin/settings/contact-map"); ?><br>
                                        <span style="font-size:13px;font-weight:normal;"><?php echo __("admin/settings/contact-map-desc");?></span>
                                    </div>
                                    <div class="yuzde70">
                                        <input type="hidden" name="map_latitude" value="<?php echo $settings["contact"]["maps"]["latitude"]; ?>">
                                        <input type="hidden" name="map_longitude" value="<?php echo $settings["contact"]["maps"]["longitude"]; ?>">
                                        <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo $settings["contact"]["google-api-key"]; ?>&callback=initMap"></script>
                                        <script type="text/javascript">
                                            function initMap(lat,lng) {
                                                var g_lat = parseFloat($("#informationsForm input[name='map_latitude']").val());
                                                var g_lng = parseFloat($("#informationsForm input[name='map_longitude']").val());
                                                var map = new google.maps.Map(document.getElementById('map'), {
                                                    dragable:true,
                                                    zoom: 17,
                                                    center: {lat:g_lat,lng:g_lng}
                                                });
                                                var geocoder = new google.maps.Geocoder();

                                                var marker = new google.maps.Marker({
                                                    position:{
                                                        lat:g_lat,
                                                        lng:g_lng
                                                    },
                                                    map:map,
                                                    draggable:true
                                                });

                                                $("#informationsForm input[name='map_address']").change(function(){
                                                    var address = ($(this).val());
                                                    geocodeAddress(marker,geocoder, map,address);
                                                });

                                                google.maps.event.addListener(marker,'dragend',function(){
                                                    dragend(marker);
                                                });

                                            }

                                            function geocodeAddress(marker,geocoder, resultsMap,address) {
                                                if(address){
                                                    geocoder.geocode({'address': address}, function(results, status) {
                                                        if (status === 'OK') {
                                                            resultsMap.setCenter(results[0].geometry.location);
                                                            marker.setMap(resultsMap);
                                                            marker.setPosition(results[0].geometry.location);
                                                            dragend(marker);
                                                        } else {
                                                            console.log('Geocode was not successful for the following reason: ' + status+" word: "+address);
                                                        }
                                                    });
                                                }
                                            }

                                            function dragend(marker){
                                                var lat = marker.getPosition().lat();
                                                var lng = marker.getPosition().lng();
                                                $("#informationsForm input[name='map_latitude']").val(lat);
                                                $("#informationsForm input[name='map_longitude']").val(lng);
                                            }
                                        </script>
                                        <div id="map" style="width: 100%; height: 300px"></div>
                                        <input type="text" class="form-control" name="map_address" placeholder="<?php echo __("admin/settings/contact-map-search"); ?>">
                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/settings/google-api-key"); ?></div>
                                    <div class="yuzde70">
                                        <input type="text" name="google_api_key" value="<?php echo $settings["contact"]["google-api-key"]; ?>">
                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30">
                                        <?php echo __("admin/settings/analytics-code"); ?>
                                        <div class="clear"></div>
                                        <span class="kinfo"><?php echo __("admin/settings/analytics-code-info"); ?></span>
                                    </div>
                                    <div class="yuzde70">
                                        <textarea name="analytics-code" rows="3"><?php echo Config::get("info/analytics-code"); ?></textarea>
                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30">
                                        <?php echo __("admin/settings/support-code"); ?>
                                        <div class="clear"></div>
                                        <span class="kinfo"><?php echo __("admin/settings/support-code-info"); ?></span>
                                    </div>
                                    <div class="yuzde70">
                                        <textarea name="support-code" rows="3"><?php echo Config::get("info/support-code"); ?></textarea>
                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30">
                                        <?php echo __("admin/settings/webmaster-tools-code"); ?>
                                        <div class="clear"></div>
                                        <span class="kinfo"><?php echo __("admin/settings/webmaster-tools-code-info"); ?></span>
                                    </div>
                                    <div class="yuzde70">
                                        <textarea name="webmaster-tools-code" rows="3"><?php echo Config::get("info/webmaster-tools-code"); ?></textarea>
                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30">
                                        <?php echo __("admin/settings/external-embed-code"); ?>
                                        <div class="clear"></div>
                                        <span class="kinfo"><?php echo __("admin/settings/external-embed-code-info"); ?></span>
                                    </div>
                                    <div class="yuzde70">
                                        <textarea name="external-embed-code" rows="3"><?php echo Config::get("info/external-embed-code"); ?></textarea>
                                    </div>
                                </div>

                                <script type="text/javascript">
                                    $(document).ready(function(){
                                        $("#social_links").sortable({
                                            handle: ".link-bearer",
                                            placeholder: "mio-state-highlight2",
                                        }).disableSelection();

                                        $("#social_links").on("click",".social-link-delete",function(){
                                            var li = $(this).closest("li");
                                            $(li).remove();
                                            $("#social_links").sortable("refresh");
                                        });

                                    });

                                    function social_add() {
                                        var template = $("#social-link-template").html();
                                        $("#social_links").append(template);
                                        $("#social_links").sortable("refresh");
                                    }
                                </script>

                                <div class="formcon">
                                    <div class="yuzde30">
                                        <?php echo __("admin/settings/social-links"); ?><br>
                                        <span style="font-size:13px;font-weight:normal;"><?php echo ___("needs/select-icon-help"); ?></span>
                                    </div>
                                    <div class="yuzde70">

                                        <ul id="social_links" style="padding:0;">
                                            <?php
                                                if($settings["contact"]["social-links"]){
                                                    foreach($settings["contact"]["social-links"] AS $social){
                                                        ?>
                                                        <li>
                                                            <div class="yuzde25">
                                                                <input type="text" name="social_links[icon][]" placeholder="<?php echo __("admin/settings/social-link-icon"); ?>" value="<?php echo $social["icon"]; ?>">
                                                            </div>
                                                            <div class="yuzde25">
                                                                <input type="text" name="social_links[name][]" placeholder="<?php echo __("admin/settings/social-link-name"); ?>" value="<?php echo $social["name"]; ?>">
                                                            </div>
                                                            <div class="yuzde40">
                                                                <input type="text" name="social_links[url][]" placeholder="<?php echo __("admin/settings/social-link-url"); ?>" value="<?php echo $social["url"]; ?>">
                                                            </div>
                                                            <div class="yuzde10">
                                                                <a style="cursor:move;display:inline-block;font-size: 20px;color: #ccc;line-height: 40px;margin-left: 10px;" class="link-bearer"><i class="fa fa-arrows-alt"></i></a>
                                                                <a style="cursor:pointer;display:inline-block;font-size: 20px;color: #ccc;line-height: 40px;margin-left: 10px;" class="social-link-delete"><i class="fa fa-trash"></i></a>
                                                            </div>
                                                        </li>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                        </ul>

                                        <a href="javascript:social_add();void 0;" class="lbtn"><i class="fa fa-plus"></i></a>

                                    </div>
                                </div>


                                <div style="float:right;" class="guncellebtn yuzde30"><a id="informations_submit" href="javascript:void(0);" class="yesilbtn gonderbtn"><?php echo __("admin/settings/update-button1"); ?></a></div>

                            </form>

                            <ul id="social-link-template" style="display:none;">
                                <li>
                                    <div class="yuzde25">
                                        <input type="text" name="social_links[icon][]" placeholder="<?php echo __("admin/settings/social-link-icon"); ?>">
                                    </div>
                                    <div class="yuzde25">
                                        <input type="text" name="social_links[name][]" placeholder="<?php echo __("admin/settings/social-link-name"); ?>">
                                    </div>
                                    <div class="yuzde40">
                                        <input type="text" name="social_links[url][]" placeholder="<?php echo __("admin/settings/social-link-url"); ?>">
                                    </div>
                                    <div class="yuzde10">
                                        <a style="cursor:move;display:inline-block;font-size: 20px;color: #ccc;line-height: 40px;margin-left: 10px;" class="link-bearer"><i class="fa fa-arrows-alt"></i></a>
                                        <a style="cursor:pointer;display:inline-block;font-size: 20px;color: #ccc;line-height: 40px;margin-left: 10px;" class="social-link-delete"><i class="fa fa-trash"></i></a>
                                    </div>
                                </li>
                            </ul>

                        </div>

                        <script type="text/javascript">
                            $(document).ready(function(){
                                /*$("#informationsForm").bind("keypress", function(e) {
                                    if (e.keyCode == 13) $("#informations_submit").click();
                                });*/

                                $("#informations_submit").on("click",function(){
                                    MioAjaxElement($(this),{
                                        waiting_text: waiting_text,
                                        progress_text: progress_text,
                                        result:"informations_submit_handler",
                                    });
                                });
                            });

                            function informations_submit_handler(result){
                                if(result != ''){
                                    var solve = getJson(result);
                                    if(solve !== false){
                                        if(solve.status == "error"){
                                            if(solve.for != undefined && solve.for != ''){
                                                $("#informationsForm "+solve.for).focus();
                                                $("#informationsForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                                $("#informationsForm "+solve.for).change(function(){
                                                    $(this).removeAttr("style");
                                                });
                                            }
                                            if(solve.message != undefined && solve.message != '')
                                                alert_error(solve.message,{timer:5000});
                                        }else if(solve.status == "successful"){
                                            if(solve.redirect != undefined) window.location.href = solve.redirect;
                                            alert_success(solve.message,{timer:2000});
                                        }
                                    }else
                                        console.log(result);
                                }
                            }
                        </script>

                        <div class="clear"></div>
                    </div><!-- tab end -->
                <?php endif; ?>


                <?php if($seoConfigure): ?>
                    <div id="group-seo" class="tabcontent"><!-- tab start -->

                        <div style="margin:15px;display:none;">
                            <div class="green-info" >

                                <div class="padding15">
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                    <p><?php echo __("admin/settings/seo-management-desc"); ?></p>
                                </div>
                            </div></div>


                        <div id="tab-lseo">
                            <ul class="tab">
                                <?php
                                    foreach($lang_list AS $lang){
                                        $lkey = $lang["key"];
                                        ?>
                                        <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, '<?php echo $lang["key"]; ?>','lseo')" data-tab="<?php echo $lang["key"]; ?>"> <?php echo strtoupper($lkey); ?></a></li>
                                        <?php
                                    }
                                ?>
                            </ul>

                            <?php
                                foreach($lang_list AS $lang){
                                    $lkey = $lang["key"];
                                    ?>
                                    <div id="lseo-<?php echo $lkey; ?>" class="tabcontent">

                                        <form action="<?php echo $links["controller"]; ?>" method="post" enctype="multipart/form-data" id="seoForm_<?php echo $lkey; ?>">
                                            <input type="hidden" name="operation" value="update_seo_settings">
                                            <input type="hidden" name="lang" value="<?php echo $lkey; ?>">

                                            <div class="adminuyedetay">
                                                <div class="formcon">
                                                    <div class="yuzde30"><?php echo __("admin/settings/seo-title"); ?></div>
                                                    <div class="yuzde70">
                                                        <input type="text" name="title" value="<?php echo __("website/index/meta/title",false,$lkey); ?>">
                                                        <span class="kinfo"><?php echo __("admin/settings/seo-title-desc"); ?></span>
                                                    </div>
                                                </div>

                                                <div class="formcon">
                                                    <div class="yuzde30"><?php echo __("admin/settings/seo-keywords"); ?></div>
                                                    <div class="yuzde70">
                                                        <input type="text" class="options-tags" name="keywords" value="<?php echo __("website/index/meta/keywords",false,$lkey); ?>">
                                                        <span class="kinfo"><?php echo __("admin/settings/seo-keywords-desc"); ?></span>
                                                    </div>
                                                </div>

                                                <div class="formcon">
                                                    <div class="yuzde30"><?php echo __("admin/settings/seo-description"); ?></div>
                                                    <div class="yuzde70">
                                                        <textarea rows="3" name="description"><?php echo __("website/index/meta/description",false,$lkey); ?></textarea>
                                                        <span class="kinfo"><?php echo __("admin/settings/seo-description-desc"); ?></span>
                                                    </div>
                                                </div>

                                                <div class="formcon">
                                                    <div class="yuzde30"><?php echo __("admin/settings/seo-permalink"); ?></div>
                                                    <div class="yuzde70">
                                                        <input<?php echo ___("package/permalink") ? ' checked' : NULL; ?> type="checkbox" name="permalink" value="1" class="sitemio-checkbox" id="permalink_<?php echo $lkey; ?>">
                                                        <label class="sitemio-checkbox-label" for="permalink_<?php echo $lkey; ?>"></label>
                                                        <span class="kinfo"><?php echo __("admin/settings/seo-permalink-desc"); ?></span>
                                                    </div>
                                                </div>

                                                <div class="formcon">
                                                    <div class="yuzde30"><?php echo __("admin/settings/seo-sitemap"); ?></div>
                                                    <div class="yuzde70">
                                                        <a target="_blank" href="<?php echo APP_URI."/".$lkey."/sitemap.xml"; ?>"><?php echo APP_URI."/".$lkey."/sitemap.xml"; ?></a>
                                                    </div>
                                                </div>

                                                <div class="formcon">
                                                    <div class="yuzde30"><?php echo __("admin/settings/website-routes"); ?></div>
                                                    <div class="yuzde70">
                                                        <a class="lbtn" href="javascript:open_modal('<?php echo $lkey; ?>_routes_configure');void 0;"><i class="fa fa-cog"></i> <?php echo __("admin/settings/website-routes-open-modal"); ?></a>
                                                    </div>
                                                </div>


                                                <div style="float:right;" class="guncellebtn yuzde30"><a id="seo_submit_<?php echo $lkey; ?>" href="javascript:void(0);" class="yesilbtn gonderbtn"><?php echo __("admin/settings/update-button1"); ?></a></div>


                                            </div>

                                        </form>
                                        <script type="text/javascript">
                                            $(document).ready(function(){
                                                $("#seo_submit_<?php echo $lkey; ?>").on("click",function(){
                                                    MioAjaxElement($(this),{
                                                        waiting_text: waiting_text,
                                                        progress_text: progress_text,
                                                        result:"seo_submit_handler",
                                                    });
                                                });
                                            });
                                        </script>

                                        <div class="clear"></div>
                                    </div>
                                    <?php
                                }
                            ?>

                        </div>

                        <script type="text/javascript">
                            $(function() {
                                var tab = _GET("lseo");
                                if (tab != '' && tab != undefined) {
                                    $("#tab-lseo .tablinks[data-tab='" + tab + "']").click();
                                } else {
                                    $("#tab-lseo .tablinks:eq(0)").addClass("active");
                                    $("#tab-lseo .tabcontent:eq(0)").css("display", "block");
                                }
                            });
                            function seo_submit_handler(result){
                                if(result != ''){
                                    var solve = getJson(result);
                                    if(solve !== false){
                                        if(solve.status == "error"){
                                            if(solve.for != undefined && solve.for != ''){
                                                $("#seoForm "+solve.for).focus();
                                                $("#seoForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                                $("#seoForm "+solve.for).change(function(){
                                                    $(this).removeAttr("style");
                                                });
                                            }
                                            if(solve.message != undefined && solve.message != '')
                                                alert_error(solve.message,{timer:5000});
                                        }else if(solve.status == "successful"){
                                            if(solve.redirect != undefined) window.location.href = solve.redirect;
                                            alert_success(solve.message,{timer:2000});
                                        }
                                    }else
                                        console.log(result);
                                }
                            }
                        </script>

                        <div class="clear"></div>
                    </div><!-- tab end -->
                <?php endif; ?>

                <?php if($localizationConfigure): ?>
                    <div id="group-localization" class="tabcontent"><!-- tab start -->

                        <div class="adminuyedetay">
                            <form action="<?php echo $links["controller"]; ?>" method="post" enctype="multipart/form-data" id="localizationForm">
                                <input type="hidden" name="operation" value="update_localization_settings">

                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/settings/default-language"); ?></div>
                                    <div class="yuzde70">
                                        <select name="default_language" class="select2">
                                            <option value="auto"><?php echo __("admin/settings/default-language-auto"); ?></option>
                                            <?php
                                                foreach($lang_list AS $lang){
                                                    ?>
                                                    <option value="<?php echo $lang["key"]; ?>"<?php echo $lang["key"] == $settings["other"]["default_language"] ? ' selected' : NULL; ?>><?php echo ___("package/name",false,$lang["key"])." (".$lang["name"].")"; ?></option>
                                                    <?php
                                                }
                                            ?>
                                        </select>
                                        <span class="kinfo"><?php echo __("admin/settings/default-language-desc"); ?></span>
                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/settings/local"); ?></div>
                                    <div class="yuzde70">
                                        <select name="local" class="select2">
                                            <?php
                                                if($lang_list){
                                                    foreach($lang_list AS $row){
                                                        $code = $row["key"];
                                                        ?>
                                                        <option value="<?php echo $code; ?>"<?php echo $code == $settings["other"]["local"] ? ' selected' : NULL; ?>><?php echo ___("package/name",false,$code)." (".strtoupper($code).")"; ?></option>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                        <span class="kinfo"><?php echo __("admin/settings/local-desc"); ?></span>
                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/settings/local-currency"); ?></div>
                                    <div class="yuzde70">
                                        <select name="currency" class="select2">
                                            <?php
                                                foreach($settings["other"]["currencies"] AS $currency){
                                                    ?>
                                                    <option value="<?php echo $currency["id"]; ?>"<?php echo $currency["id"] == $settings["other"]["currency"] ? ' selected' : NULL; ?>><?php echo $currency["name"]." (".$currency["code"].")"; ?></option>
                                                    <?php
                                                }
                                            ?>
                                        </select>
                                        <span class="kinfo"><?php echo __("admin/settings/local-currency-desc"); ?></span>
                                    </div>
                                </div>


                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/settings/local-country"); ?></div>
                                    <div class="yuzde70">
                                        <select name="country" class="select2">
                                            <?php
                                                $countryList = $functions["get_countries"];
                                                $countryList = $countryList();
                                                if($countryList){
                                                    foreach($countryList AS $row){
                                                        $code = strtolower($row["a2_iso"]);
                                                        ?>
                                                        <option value="<?php echo $code; ?>"<?php echo $code == $settings["other"]["country"] ? ' selected' : NULL; ?>><?php echo $row["name"]." (".$row["a2_iso"].")"; ?></option>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                        <span class="kinfo"><?php echo __("admin/settings/local-country-desc"); ?></span>
                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/settings/date-format"); ?></div>
                                    <div class="yuzde70">
                                        <select name="date-format">
                                            <?php
                                                $formats = [
                                                    'd/m/Y' => "DD/MM/YYYY",
                                                    'd.m.Y' => "DD.MM.YYYY",
                                                    'd-m-Y' => "DD-MM-YYYY",
                                                    'm/d/Y' => "MM/DD/YYYY",
                                                    'Y/m/d' => "YYYY/MM/DD",
                                                    'Y-m-d' => "YYYY-MM-DD",
                                                ];
                                                foreach($formats AS $k=>$v)
                                                {
                                                    ?>
                                                    <option<?php echo Config::get("options/date-format") == $k ? ' selected' : ''; ?> value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                                    <?php
                                                }
                                            ?>
                                        </select>
                                        <span class="kinfo"><?php echo __("admin/settings/timezone-desc"); ?></span>
                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/settings/timezone"); ?></div>
                                    <div class="yuzde70">
                                        <select name="timezone" class="select2">
                                            <?php
                                                foreach($settings["other"]["timezones"] AS $key=>$val){
                                                    ?>
                                                    <option value="<?php echo $key; ?>"<?php echo $key == $settings["other"]["timezone"] ? ' selected' : NULL; ?>><?php echo $val; ?></option>
                                                    <?php
                                                }
                                            ?>
                                        </select>
                                        <span class="kinfo"><?php echo __("admin/settings/timezone-desc"); ?></span>
                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30">
                                        <?php echo __("admin/settings/ip-api"); ?>
                                        <div class="clear"></div>
                                        <span class="kinfo">
                                            <?php echo __("admin/settings/ip-api-desc"); ?>
                                        </span>
                                    </div>
                                    <div class="yuzde70">
                                        <script type="text/javascript">
                                            $(document).ready(function(){
                                                change_ip_api(document.getElementById("SelectipApi"));

                                                $("#SelectipApi").change(function(){
                                                    change_ip_api(this);
                                                });
                                            });

                                            function change_ip_api(el){
                                                var val = $(el).val();

                                                $("#ip_api_configs").fadeOut(250);

                                                var request = MioAjax({
                                                    action:"<?php echo $links["controller"]; ?>",
                                                    method: "GET",
                                                    data:{
                                                        operation:"get_ip_api_configs",
                                                        module:val,
                                                    },
                                                },true,true);

                                                request.done(function(result){
                                                    $("#ip_api_configs").html(result).fadeIn(250);
                                                });
                                            }
                                        </script>
                                        <select name="ip_api" id="SelectipApi">
                                            <?php
                                                if(isset($ip_modules) && $ip_modules){
                                                    foreach($ip_modules AS $k=>$v){
                                                        ?>
                                                        <option<?php echo $settings["ip-api"] == $k ? ' selected' : ''; ?> value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                        <div class="clear"></div>
                                        <div id="ip_api_configs" style="display: none;"></div>

                                    </div>
                                </div>


                                <div style="float:right;" class="guncellebtn yuzde30"><a id="localization_submit" href="javascript:void(0);" class="yesilbtn gonderbtn"><?php echo __("admin/settings/update-button1"); ?></a></div>

                            </form>
                        </div>

                        <script type="text/javascript">
                            $(document).ready(function(){
                                /*$("#localizationForm").bind("keypress", function(e) {
                                    if (e.keyCode == 13) $("#localization_submit").click();
                                });*/

                                $("#localization_submit").on("click",function(){
                                    MioAjaxElement($(this),{
                                        waiting_text: waiting_text,
                                        progress_text: progress_text,
                                        result:"localization_submit_handler",
                                    });
                                });
                            });

                            function localization_submit_handler(result){
                                if(result != ''){
                                    var solve = getJson(result);
                                    if(solve !== false){
                                        if(solve.status == "error"){
                                            if(solve.for != undefined && solve.for != ''){
                                                $("#localizationForm "+solve.for).focus();
                                                $("#localizationForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                                $("#localizationForm "+solve.for).change(function(){
                                                    $(this).removeAttr("style");
                                                });
                                            }
                                            if(solve.message != undefined && solve.message != '')
                                                alert_error(solve.message,{timer:5000});
                                        }else if(solve.status == "successful"){
                                            if(solve.redirect != undefined) window.location.href = solve.redirect;
                                            alert_success(solve.message,{timer:2000});
                                        }
                                    }else
                                        console.log(result);
                                }
                            }
                        </script>

                        <div class="clear"></div>
                    </div><!-- tab content end -->
                <?php endif; ?>

                <?php if($membershipConfigure): ?>
                    <script type="text/javascript">
                        $(document).ready(function(){
                            var accordionName = "accordion_membership";
                            var accordion     = $("#"+accordionName);
                            var accordion_g   = _GET(accordionName);
                            if(accordion_g != null) accordion_g = parseInt(accordion_g);

                            accordion.accordion({
                                heightStyle: "content",
                                active: accordion_g != null ? accordion_g : 0,
                                collapsible: true,
                                activate: function( event, ui ) {
                                    var active = accordion.accordion( "option","active");
                                    if(active == false && active !== 0){
                                        var link = unset_GET(accordionName);
                                    }else if(active == 0 || active){
                                        var link    = set_GET(accordionName,active);
                                    }

                                    window.history.pushState("object or string", $("title").html(),link);
                                }
                            });

                        });
                    </script>

                    <div id="group-membership" class="tabcontent"><!-- tab start -->

                        <div id="accordion_membership" class="mio-accordion" style="margin-top:15px;">

                            <h3><strong><?php echo __("admin/settings/accordion-membership-settings"); ?></strong> <span style="font-size:16px;"><?php echo __("admin/settings/accordion-membership-settings-subtitle"); ?></span></h3>
                            <div><!-- accordion item start -->

                                <form action="<?php echo $links["controller"]; ?>" method="post" id="membershipSettings">
                                    <input type="hidden" name="operation" value="save_membership_settings">

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/settings/crtacwshop"); ?></div>
                                        <div class="yuzde70">
                                            <input type="checkbox" class="sitemio-checkbox" id="crtacwshop" name="crtacwshop" value="1"<?php echo $settings["options"]["crtacwshop"] ? ' checked' : NULL; ?>>
                                            <label class="sitemio-checkbox-label" for="crtacwshop"></label>
                                            <span class="kinfo"><?php echo __("admin/settings/crtacwshop-desc"); ?></span>
                                        </div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/settings/sign-settings"); ?></div>
                                        <div class="yuzde60">

                                            <input type="checkbox" class="checkbox-custom" id="sign_in_status" name="sign_in_status" value="1"<?php echo $settings["options"]["sign"]["in"]["status"] ? ' checked' : NULL; ?>>
                                            <label style="margin-bottom:5px; font-size:13px;" class="checkbox-custom-label" for="sign_in_status"><?php echo __("admin/settings/sign-in-status"); ?></label>

                                            <br>

                                            <input type="checkbox" class="checkbox-custom" id="sign_up_status" name="sign_up_status" value="1"<?php echo $settings["options"]["sign"]["up"]["status"] ? ' checked' : NULL; ?>>
                                            <label style="margin-bottom:5px; font-size:13px;" class="checkbox-custom-label" for="sign_up_status"><?php echo __("admin/settings/sign-up-status"); ?></label>

                                        </div>
                                    </div>


                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/settings/sign-editable-full_name"); ?></div>
                                        <div class="yuzde70">
                                            <input type="checkbox" class="sitemio-checkbox" id="sign_editable_full_name" name="sign_editable_full_name" value="1"<?php echo $settings["options"]["sign"]["editable"]["full_name"] ? ' checked' : NULL; ?>>
                                            <label class="sitemio-checkbox-label" for="sign_editable_full_name"></label>
                                            <span class="kinfo"><?php echo __("admin/settings/sign-editable-full_name-desc"); ?></span>
                                        </div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/settings/smart-naming"); ?></div>
                                        <div class="yuzde70">
                                            <input type="checkbox" class="sitemio-checkbox" id="smart-naming" name="smart-naming" value="1"<?php echo Config::get("options/smart-naming") ? ' checked' : NULL; ?>>
                                            <label class="sitemio-checkbox-label" for="smart-naming"></label>
                                            <span class="kinfo"><?php echo __("admin/settings/smart-naming-desc"); ?></span>
                                        </div>
                                    </div>


                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/settings/sign-email-settings"); ?></div>
                                        <div class="yuzde60">

                                            <input type="checkbox" class="checkbox-custom" id="sign_up_email_verify_status" name="sign_up_email_verify_status" value="1"<?php echo $settings["options"]["sign"]["up"]["email"]["verify"] ? ' checked' : NULL; ?>>
                                            <label style="margin-bottom: 5px; font-size:13px;" class="checkbox-custom-label" for="sign_up_email_verify_status"><?php echo __("admin/settings/sign-up-email-verify-status"); ?></label>
                                            <br/>

                                            <input type="checkbox" class="checkbox-custom" id="sign_editable_email" name="sign_editable_email" value="1"<?php echo $settings["options"]["sign"]["editable"]["email"] ? ' checked' : NULL; ?>>
                                            <label style="margin-right: 15px; font-size:13px;" class="checkbox-custom-label" for="sign_editable_email"><?php echo __("admin/settings/sign-editable-email"); ?></label>

                                        </div>
                                    </div>


                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/settings/sign-gsm-settings"); ?></div>
                                        <div class="yuzde60">


                                            <input type="checkbox" class="checkbox-custom" id="sign_up_gsm_status" name="sign_up_gsm_status" value="1"<?php echo $settings["options"]["sign"]["up"]["gsm"]["status"] ? ' checked' : NULL; ?>>
                                            <label style="margin-bottom: 5px; font-size:13px;" class="checkbox-custom-label" for="sign_up_gsm_status"><?php echo __("admin/settings/sign-up-gsm-status"); ?></label>

                                            <br/>


                                            <input type="checkbox" class="checkbox-custom" id="sign_up_gsm_verify" name="sign_up_gsm_verify" value="1"<?php echo $settings["options"]["sign"]["up"]["gsm"]["verify"] ? ' checked' : NULL; ?>>
                                            <label style="margin-bottom:5px; font-size:13px;" class="checkbox-custom-label" for="sign_up_gsm_verify"><?php echo __("admin/settings/sign-up-gsm-verify"); ?></label>

                                            <br/>

                                            <input type="checkbox" class="checkbox-custom" id="sign_up_gsm_required" name="sign_up_gsm_required" value="1"<?php echo $settings["options"]["sign"]["up"]["gsm"]["required"] ? ' checked' : NULL; ?>>
                                            <label style="margin-bottom: 5px; font-size:13px;" class="checkbox-custom-label" for="sign_up_gsm_required"><?php echo __("admin/settings/sign-up-gsm-required"); ?></label>

                                            <br/>

                                            <input type="checkbox" class="checkbox-custom" id="sign_editable_gsm" name="sign_editable_gsm" value="1"<?php echo $settings["options"]["sign"]["editable"]["gsm"] ? ' checked' : NULL; ?>>
                                            <label style="margin-bottom: 5px; font-size:13px;" class="checkbox-custom-label" for="sign_editable_gsm"><?php echo __("admin/settings/sign-editable-gsm"); ?></label>

                                            <br/>


                                            <input type="checkbox" class="checkbox-custom" id="sign_up_gsm_checker" name="sign_up_gsm_checker" value="1"<?php echo $settings["options"]["sign"]["up"]["gsm"]["checker"] ? ' checked' : NULL; ?>>
                                            <label style="margin-bottom: 5px; font-size:13px;" class="checkbox-custom-label" for="sign_up_gsm_checker"><?php echo __("admin/settings/sign-up-gsm-checker"); ?></label>

                                        </div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/settings/sign-landline-phone-settings"); ?></div>
                                        <div class="yuzde60">

                                            <input type="checkbox" class="checkbox-custom" id="sign_up_landline_phone_status" name="sign_up_landline_phone_status" value="1"<?php echo $settings["options"]["sign"]["up"]["landline-phone"]["status"] ? ' checked' : NULL; ?>>
                                            <label style="margin-bottom:5px; font-size:13px;" class="checkbox-custom-label" for="sign_up_landline_phone_status"><?php echo __("admin/settings/sign-up-landline-phone-status"); ?></label>

                                            <br>


                                            <input type="checkbox" class="checkbox-custom" id="sign_up_landline_phone_required" name="sign_up_landline_phone_required" value="1"<?php echo $settings["options"]["sign"]["up"]["landline-phone"]["required"] ? ' checked' : NULL; ?>>
                                            <label style="margin-bottom:5px; font-size:13px;" class="checkbox-custom-label" for="sign_up_landline_phone_required"><?php echo __("admin/settings/sign-up-landline-phone-required"); ?></label>

                                            <br>


                                            <input type="checkbox" class="checkbox-custom" id="sign_up_landline_phone_checker" name="sign_up_landline_phone_checker" value="1"<?php echo $settings["options"]["sign"]["up"]["landline-phone"]["checker"] ? ' checked' : NULL; ?>>
                                            <label style="margin-bottom:5px; font-size:13px;" class="checkbox-custom-label" for="sign_up_landline_phone_checker"><?php echo __("admin/settings/sign-up-landline-phone-checker"); ?></label>

                                            <br>

                                            <input type="checkbox" class="checkbox-custom" id="sign_editable_landline_phone" name="sign_editable_landline_phone" value="1"<?php echo $settings["options"]["sign"]["editable"]["landline_phone"] ? ' checked' : NULL; ?>>
                                            <label style="margin-bottom:5px; font-size:13px;" class="checkbox-custom-label" for="sign_editable_landline_phone"><?php echo __("admin/settings/sign-editable-landline_phone"); ?></label>


                                        </div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/settings/sign-security-question-settings"); ?></div>
                                        <div class="yuzde60">


                                            <input type="checkbox" class="checkbox-custom" id="security_question_status" name="security_question_status" value="1"<?php echo $settings["options"]["sign"]["security-question"]["status"] ? ' checked' : NULL; ?>>
                                            <label style="margin-bottom: 5px; font-size:13px;" class="checkbox-custom-label" for="security_question_status"><?php echo __("admin/settings/sign-security-question-status"); ?></label>

                                            <br/>

                                            <input type="checkbox" class="checkbox-custom" id="security_question_required" name="security_question_required" value="1"<?php echo $settings["options"]["sign"]["security-question"]["required"] ? ' checked' : NULL; ?>>
                                            <label style="margin-bottom: 5px; font-size:13px;" class="checkbox-custom-label" for="security_question_required"><?php echo __("admin/settings/sign-security-question-required"); ?></label>

                                        </div>
                                    </div>


                                    <div class="formcon"<?php echo Config::get("general/country") != "tr" ? ' style="display:none;"' : NULL; ?>>
                                        <div class="yuzde30"><?php echo __("admin/settings/sign-identity-settings"); ?></div>
                                        <div class="yuzde60">


                                            <input type="checkbox" class="checkbox-custom" id="sign_up_identity_status" name="sign_up_identity_status" value="1"<?php echo $settings["options"]["sign"]["up"]["kind"]["individual"]["identity"]["status"] ? ' checked' : NULL; ?>>
                                            <label style="margin-bottom:5px; font-size:13px;" class="checkbox-custom-label" for="sign_up_identity_status"><?php echo __("admin/settings/sign-up-identity-status"); ?></label>

                                            <br>


                                            <input type="checkbox" class="checkbox-custom" id="sign_up_identity_required" name="sign_up_identity_required" value="1"<?php echo $settings["options"]["sign"]["up"]["kind"]["individual"]["identity"]["required"] ? ' checked' : NULL; ?>>
                                            <label style="margin-bottom:5px; font-size:13px;" class="checkbox-custom-label" for="sign_up_identity_required"><?php echo __("admin/settings/sign-up-identity-required"); ?></label>

                                            <br>


                                            <input onclick="if($(this).prop('checked')) $('#sign_birthday_status,#sign_birthday_required').prop('checked',true);" type="checkbox" class="checkbox-custom" id="sign_up_identity_checker" name="sign_up_identity_checker" value="1"<?php echo $settings["options"]["sign"]["up"]["kind"]["individual"]["identity"]["checker"] ? ' checked' : NULL; ?>>
                                            <label style="margin-bottom:5px; font-size:13px;" class="checkbox-custom-label" for="sign_up_identity_checker"><?php echo __("admin/settings/sign-up-identity-checker"); ?></label>

                                            <br>

                                            <input type="checkbox" class="checkbox-custom" id="sign_editable_identity" name="sign_editable_identity" value="1"<?php echo $settings["options"]["sign"]["editable"]["identity"] ? ' checked' : NULL; ?>>
                                            <label style="margin-bottom:5px; font-size:13px;" class="checkbox-custom-label" for="sign_editable_identity"><?php echo __("admin/settings/sign-editable-identity"); ?></label>


                                        </div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/settings/sign-birthday-settings"); ?></div>
                                        <div class="yuzde60">

                                            <input type="checkbox" class="checkbox-custom" id="sign_birthday_status" name="sign_birthday_status" value="1"<?php echo $settings["options"]["sign"]["birthday"]["status"] ? ' checked' : NULL; ?>>
                                            <label style="margin-bottom:5px; font-size:13px;" class="checkbox-custom-label" for="sign_birthday_status"><?php echo __("admin/settings/sign-birthday-status"); ?></label>
                                            <br>

                                            <input type="checkbox" class="checkbox-custom" id="sign_birthday_required" name="sign_birthday_required" value="1"<?php echo $settings["options"]["sign"]["birthday"]["required"] ? ' checked' : NULL; ?>>
                                            <label style="margin-bottom:5px; font-size:13px;" class="checkbox-custom-label" for="sign_birthday_required"><?php echo __("admin/settings/sign-birthday-required"); ?></label>
                                            <br>

                                            <input type="checkbox" class="checkbox-custom" id="sign_birthday_adult_verify" name="sign_birthday_adult_verify" value="1"<?php echo isset($settings["options"]["sign"]["birthday"]["adult_verify"]) && $settings["options"]["sign"]["birthday"]["adult_verify"] ? ' checked' : NULL; ?>>
                                            <label style="margin-bottom:5px; font-size:13px;" class="checkbox-custom-label" for="sign_birthday_adult_verify"><?php echo __("admin/settings/sign-birthday-adult-verify"); ?></label>
                                            <br>

                                            <input type="checkbox" class="checkbox-custom" id="sign_editable_birthday" name="sign_editable_birthday" value="1"<?php echo $settings["options"]["sign"]["editable"]["birthday"] ? ' checked' : NULL; ?>>
                                            <label style="margin-right: 15px; font-size:13px;" class="checkbox-custom-label" for="sign_editable_birthday"><?php echo __("admin/settings/sign-editable-birthday"); ?></label>


                                        </div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/settings/sign-kind-settings"); ?></div>
                                        <div class="yuzde60">

                                            <input type="checkbox" class="checkbox-custom" id="sign_up_kind_status" name="sign_up_kind_status" value="1"<?php echo $settings["options"]["sign"]["up"]["kind"]["status"] ? ' checked' : NULL; ?>>
                                            <label style="margin-bottom:5px; font-size:13px;" class="checkbox-custom-label" for="sign_up_kind_status"><?php echo __("admin/settings/sign-up-kind-status"); ?></label>
                                            <br>

                                            <input type="checkbox" class="checkbox-custom" id="sign_editable_kind" name="sign_editable_kind" value="1"<?php echo $settings["options"]["sign"]["editable"]["kind"] ? ' checked' : NULL; ?>>
                                            <label style="margin-right: 15px; font-size:13px;" class="checkbox-custom-label" for="sign_editable_kind"><?php echo __("admin/settings/sign-editable-kind"); ?></label>


                                        </div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/settings/corporate-tax-office"); ?></div>
                                        <div class="yuzde60">

                                            <input type="checkbox" class="checkbox-custom" name="company_tax_office_status" value="1" id="company_tax_office_status" <?php echo Config::get("options/sign/up/kind/corporate/company_tax_office") ? ' checked' : ''; ?>>
                                            <label class="checkbox-custom-label" for="company_tax_office_status"><span class="kinfo"><?php echo __("admin/settings/corporate-tax-office-status"); ?></span></label>
                                            <br>

                                            <input type="checkbox" class="checkbox-custom" name="company_tax_office_required" value="1" id="company_tax_office_required" <?php echo Config::get("options/sign/up/kind/corporate/company_tax_office/required") ? ' checked' : ''; ?>>
                                            <label class="checkbox-custom-label" for="company_tax_office_required"><span class="kinfo"><?php echo __("admin/settings/corporate-tax-office-required"); ?></span></label>
                                            
                                        </div>
                                    </div>

                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/settings/corporate-tax-number"); ?></div>
                                        <div class="yuzde60">

                                            <input type="checkbox" class="checkbox-custom" name="company_tax_number_status" value="1" id="company_tax_number_status" <?php echo Config::get("options/sign/up/kind/corporate/company_tax_number") ? ' checked' : ''; ?>>
                                            <label for="company_tax_number_status" class="checkbox-custom-label"><span class="kinfo"><?php echo __("admin/settings/corporate-tax-number-status"); ?></span></label>
                                            <br>
                                            <input type="checkbox" class="checkbox-custom" name="company_tax_number_required" value="1" id="company_tax_number_required" <?php echo Config::get("options/sign/up/kind/corporate/company_tax_number/required") ? ' checked' : ''; ?>>
                                            <label class="checkbox-custom-label" for="company_tax_number_required"><span class="kinfo"><?php echo __("admin/settings/corporate-tax-number-required"); ?></span></label>

                                        </div>
                                    </div>


                                    <div style="float:right;" class="guncellebtn yuzde30"><a id="membershipSettings_submit" href="javascript:void(0);" class="yesilbtn gonderbtn"><?php echo __("admin/settings/update-button1"); ?></a></div>

                                </form>
                                <script type="text/javascript">
                                    $(document).ready(function(){
                                        /*$("#membershipSettings").bind("keypress", function(e) {
                                            if (e.keyCode == 13) $("#membershipSettings_submit").click();
                                        });*/

                                        $("#membershipSettings_submit").click(function(){
                                            MioAjaxElement($(this),{
                                                waiting_text: waiting_text,
                                                progress_text: progress_text,
                                                result:"membership_settings_handler",
                                            });
                                        });
                                    });

                                    function membership_settings_handler(result) {
                                        if(result != ''){
                                            var solve = getJson(result);
                                            if(solve !== false){
                                                if(solve.status == "error"){
                                                    if(solve.message != undefined && solve.message != '')
                                                        alert_error(solve.message,{timer:5000});
                                                }else if(solve.status == "successful"){
                                                    if(solve.redirect != undefined) window.location.href = solve.redirect;
                                                    alert_success(solve.message,{timer:2000});
                                                }
                                            }else
                                                console.log(result);
                                        }
                                    }
                                </script>


                            </div><!-- accordion item end -->


                            <h3><strong><?php echo __("admin/settings/accordion-membership-fields"); ?></strong> <span style="font-size:16px;"><?php echo __("admin/settings/accordion-membership-fields-subtitle"); ?></span></h3>
                            <div><!-- accordion item start -->


                                <script type="text/javascript">
                                    $(document).ready(function(){

                                        $(window).on("beforeunload", function(){
                                            var emptyList = [];
                                            $(".custom-fields .field-name-change-trigger").each(function(k,v){
                                                if($(v).val().length<1){
                                                    var id = $(v).closest("tr[data-type='new']").attr("data-id");
                                                    emptyList.push(id);
                                                }
                                            });

                                            var result = MioAjax({
                                                action: "<?php echo $links["controller"]; ?>",
                                                method: "POST",
                                                data:{
                                                    operation:"delete_user_custom_field",
                                                    ids:emptyList
                                                },
                                            },true);
                                        });

                                        $(".custom-fields").on("keyup",".field-name-change-trigger",function(){
                                            var el = $(this).closest("tr");
                                            var el_id = el.attr("data-id");
                                            $(this).trigger("change");
                                            $("#field_"+el_id+"_name").html($(this).val());
                                        });

                                        $(".options-tags").tagsInput({
                                            'width':'100%',
                                            'height': '55px',
                                            'defaultText':'<?php echo __("admin/settings/add-option"); ?>',
                                            'interactive':true,
                                            'removeWithBackspace' : true,
                                        });


                                        var tab = _GET("fieldsl");
                                        if(tab != '' && tab != undefined){
                                            $("#tab-fieldsl .tablinks[data-tab='"+tab+"']").click();
                                        }else{
                                            $("#tab-fieldsl .tablinks:eq(0)").addClass("active");
                                            $("#tab-fieldsl .tabcontent:eq(0)").css("display","block");
                                        }

                                        var sortable = ".custom-fields";
                                        $(sortable).sortable({
                                            handle:'.bearerx',
                                            placeholder: "mio-state-highlight2",
                                            update: function(event, ui) {
                                                var lang = $(ui.item[0]).attr("data-lang");
                                                var ranking = $("#fieldsl-"+lang+" .custom-fields input.fields-ranking").map(function(){return $(this).val();}).get();
                                                var result = MioAjax({
                                                    action:"<?php echo $links["controller"]; ?>",
                                                    method:"POST",
                                                    data:{
                                                        lang:lang,
                                                        operation:"update_users_custom_fields_ranking",
                                                        ranking:ranking,
                                                    },
                                                },true);
                                                if(result != ''){
                                                    var solve = getJson(result);
                                                    if(solve !== false){
                                                        if(solve.status == "error"){
                                                            if(solve.message != undefined && solve.message != '')
                                                                alert_error(solve.message,{timer:5000});
                                                        }else if(solve.status == "successful"){
                                                            //alert_success(solve.message,{timer:3000});
                                                        }
                                                    }else
                                                        console.log(result);
                                                }
                                            },
                                        }).disableSelection();
                                    });


                                    function addCustomField(lang){
                                        var result = MioAjax({
                                            action: "<?php echo $links["controller"]; ?>",
                                            method: "POST",
                                            data:{
                                                operation:"add_user_custom_field",
                                                lang:lang
                                            },
                                        },true);
                                        if(result != ''){
                                            var solve = getJson(result);
                                            if(solve !== false){
                                                if(solve.status == "successful"){
                                                    var data = $("#custom-field-template").html();
                                                    var variables = {
                                                        id:solve.id,
                                                        lang:lang,
                                                        tags_class:"options-tags",
                                                    };

                                                    var data = data.replace(/{(\w+)}/g, function(_,k){
                                                        return variables[k];
                                                    });

                                                    $("#fieldsl-"+lang+" .custom-fields").append(data);

                                                    $(".options-tags").tagsInput({
                                                        'width':'100%',
                                                        'height': '30px',
                                                        'defaultText':'<?php echo __("admin/settings/add-option"); ?>',
                                                        'interactive':true,
                                                        'removeWithBackspace' : true,
                                                    });

                                                    $("#fieldsl-"+lang+" .custom-fields").sortable('refresh');

                                                }
                                            }else
                                                console.log(result);
                                        }
                                    }

                                    function deleteCustomField(id){
                                        if(confirm('<?php echo __("admin/settings/delete-custom-field-are-you-sure"); ?>')){
                                            var result = MioAjax({
                                                action: "<?php echo $links["controller"]; ?>",
                                                method: "POST",
                                                data:{
                                                    operation:"delete_user_custom_field",
                                                    id:id
                                                },
                                            },true);
                                            if(result != ''){
                                                var solve = getJson(result);
                                                if(solve !== false){
                                                    if(solve.status == "successful"){

                                                        var lang = $("#field-item-"+id).data("lang");

                                                        $("#field-item-"+id).remove();

                                                        $("#fieldsl-"+lang+" .custom-fields").sortable('refresh');

                                                        alert_success(solve.message,{timer:2000});

                                                    }
                                                }else
                                                    console.log(result);
                                            }
                                        }

                                    }

                                    function save_fields_handler(result){
                                        if(result != ''){
                                            var solve = getJson(result);
                                            if(solve !== false){
                                                if(solve.status == "error"){
                                                    if(solve.message != undefined && solve.message != '')
                                                        alert_error(solve.message,{timer:5000});
                                                }else if(solve.status == "successful"){
                                                    if(solve.redirect != undefined) window.location.href = solve.redirect;
                                                    alert_success(solve.message,{timer:2000});
                                                }
                                            }else
                                                console.log(result);
                                        }
                                    }
                                </script>

                                <div id="tab-fieldsl">

                                    <table id="custom-field-template" style="display: none;">
                                        <tr style="background:none;" id="field-item-{id}" data-id="{id}" data-lang="{lang}" data-type="new">
                                            <td>
                                                <strong id="field_{id}_name"></strong>

                                                <div style="float: right;">
                                                    <a class="lbtn" onclick="deleteCustomField('{id}');" title="<?php echo __("admin/settings/field-item-delete"); ?>" href="javascirpt:void(0);"><i class="fa fa-trash"></i></a>
                                                </div>

                                                <div class="clear"></div>
                                                <div class="edit_content" id="edit_content_{id}">
                                                    <input type="hidden" class="fields-ranking" value="{id}">
                                                    <div class="formcon">

                                                        <div class="yuzde35"><strong><?php echo __("admin/settings/field-item-name"); ?>:</strong>
                                                            <input name="fields[{id}][name]" class="field-name-change-trigger" type="text" value="" placeholder="<?php echo __("admin/settings/field-item-name-placeholder"); ?>" style="margin-bottom: 5px;">

                                                            <input id="field-{id}-status" type="checkbox" class="checkbox-custom" name="fields[{id}][status]" value="1">
                                                            <label style="margin-right: 15px; font-size: 13px;" class="checkbox-custom-label" for="field-{id}-status"><?php echo __("admin/settings/field-item-visible"); ?></label>

                                                            <input id="field-{id}-required" type="checkbox" class="checkbox-custom" name="fields[{id}][required]" value="1">
                                                            <label style="margin-right: 15px; font-size: 13px;" class="checkbox-custom-label" for="field-{id}-required"><?php echo __("admin/settings/field-item-required"); ?></label>

                                                            <input id="field-{id}-uneditable" type="checkbox" class="checkbox-custom" name="fields[{id}][uneditable]" value="1">
                                                            <label style="margin-right: 15px; font-size: 13px;" class="checkbox-custom-label" for="field-{id}-uneditable"><?php echo __("admin/settings/field-item-uneditable"); ?></label>


                                                        </div>
                                                        <div class="yuzde60" style="float:right;"><strong style="margin-right: 10px;"><?php echo __("admin/settings/field-item-answer-type"); ?>:</strong>
                                                            <input checked id="field-type-{id}-text" class="radio-custom" name="fields[{id}][type]" value="text" type="radio" onchange="$('#field-{id}-options').fadeOut();">
                                                            <label style="margin-right:10px;" for="field-type-{id}-text" class="radio-custom-label"><span class="checktext"><?php echo __("admin/settings/field-item-answer-type-text"); ?></span></label>

                                                            <input id="field-type-{id}-textarea" class="radio-custom" name="fields[{id}][type]" value="textarea" type="radio" onchange="$('#field-{id}-options').fadeOut();">
                                                            <label style="margin-right:10px;" for="field-type-{id}-textarea" class="radio-custom-label"><span class="checktext"><?php echo __("admin/settings/field-item-answer-type-textarea"); ?></span></label>

                                                            <input id="field-type-{id}-select" class="radio-custom" name="fields[{id}][type]" value="select" type="radio" onchange="$('#field-{id}-options').fadeIn();">
                                                            <label style="margin-right:10px;" for="field-type-{id}-select" class="radio-custom-label"><span class="checktext"><?php echo __("admin/settings/field-item-answer-type-selectbox"); ?></span></label>

                                                            <input id="field-type-{id}-checkbox" class="radio-custom" name="fields[{id}][type]" value="checkbox" type="radio" onchange="$('#field-{id}-options').fadeIn();">
                                                            <label style="margin-right:10px;" for="field-type-{id}-checkbox" class="radio-custom-label"><span class="checktext"><?php echo __("admin/settings/field-item-answer-type-checkbox"); ?></span></label>

                                                            <input id="field-type-{id}-radio" class="radio-custom" name="fields[{id}][type]" value="radio" type="radio" onchange="$('#field-{id}-options').fadeIn();">
                                                            <label style="margin-right:10px;" for="field-type-{id}-radio" class="radio-custom-label"><span class="checktext"><?php echo __("admin/settings/field-item-answer-type-radio"); ?></span></label>

                                                            <div class="clear"></div>
                                                            <div id="field-{id}-options" style="display:none;margin-top:5px;width:90%;">
                                                                <input  class="{tags_class} yuzde100" name="fields[{id}][options]" type="text" placeholder="" value="">
                                                                <span style="font-size: 13px;"><?php echo __("admin/settings/add-option-info"); ?></span>
                                                            </div>
                                                            <div class="clear"></div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>


                                    <ul class="tab">
                                        <?php
                                            foreach($lang_list AS $lang){
                                                $lkey = $lang["key"];
                                                ?>
                                                <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, '<?php echo $lang["key"]; ?>','fieldsl')" data-tab="<?php echo $lang["key"]; ?>"> <?php echo strtoupper($lkey); ?></a></li>
                                                <?php
                                            }
                                        ?>
                                    </ul>

                                    <?php
                                        $getCsFieldS    = $functions["users_custom_fields"];
                                        foreach($lang_list AS $lang){
                                            ?>
                                            <script type="text/javascript">
                                                $(document).ready(function(){

                                                    $("#saveFieldButton_<?php echo $lang["key"]; ?>").on("click",function(){
                                                        MioAjaxElement($(this),{
                                                            waiting_text: waiting_text,
                                                            progress_text: progress_text,
                                                            result:"save_fields_handler",
                                                        });
                                                    });
                                                });
                                            </script>
                                            <div id="fieldsl-<?php echo $lang["key"]; ?>" class="tabcontent">


                                                <form action="<?php echo $links["controller"]; ?>" method="post" id="fieldsForm<?php echo $lang["key"]; ?>">
                                                    <input type="hidden" name="operation" value="save_custom_fields">
                                                    <table style="width: 100%;" class="table table-striped table-borderedx table-condensed nowrap">
                                                        <tbody class="custom-fields">
                                                        <?php
                                                            if($fieldList = $getCsFieldS($lang["key"])){
                                                                foreach($fieldList AS $field){
                                                                    ?>
                                                                    <tr style="background:none;" id="field-item-<?php echo $field["id"]; ?>" data-id="<?php echo $field["id"]; ?>" data-lang="<?php echo $lang["key"]; ?>">
                                                                        <td>
                                                                            <strong id="field_<?php echo $field["id"]; ?>_name"><?php echo $field["name"]; ?></strong>


                                                                            <div style="float: right;">
                                                                                <a href="javascript:$('.edit_content').not('#edit_content_<?php echo $field["id"]; ?>').hide(1),$('#edit_content_<?php echo $field["id"]; ?>').fadeToggle();void 0;" class="lbtn"><i class="fa fa-edit"></i></a>
                                                                                <a class="bearerx lbtn" title="<?php echo __("admin/settings/field-item-move"); ?>" href="javascript:void(0);"><i class="fa fa-arrows-alt"></i></a>
                                                                                <a class="lbtn" onclick="deleteCustomField('<?php echo $field["id"]; ?>');" title="<?php echo __("admin/settings/field-item-delete"); ?>" href="javascirpt:void(0);"><i class="fa fa-trash"></i></a>
                                                                            </div>

                                                                            <div class="clear"></div>
                                                                            <div class="edit_content" id="edit_content_<?php echo $field["id"]; ?>" style="display:none;">
                                                                                <input type="hidden" class="fields-ranking" value="<?php echo $field["id"]; ?>">

                                                                                <div class="formcon">

                                                                                    <div class="yuzde35"><strong><?php echo __("admin/settings/field-item-name"); ?>:</strong>
                                                                                        <input class="field-name-change-trigger" name="fields[<?php echo $field["id"]; ?>][name]" type="text" value="<?php echo $field["name"]; ?>" placeholder="<?php echo __("admin/settings/field-item-name-placeholder"); ?>" style="margin-bottom: 5px;">

                                                                                        <input id="field-<?php echo $field["id"]; ?>-status" type="checkbox" class="checkbox-custom" name="fields[<?php echo $field["id"]; ?>][status]" value="1"<?php echo $field["status"] == "active" ? ' checked' : NULL; ?>>
                                                                                        <label style="margin-right: 15px; font-size: 13px;" class="checkbox-custom-label" for="field-<?php echo $field["id"]; ?>-status"><?php echo __("admin/settings/field-item-visible"); ?></label>

                                                                                        <input id="field-<?php echo $field["id"]; ?>-required" type="checkbox" class="checkbox-custom" name="fields[<?php echo $field["id"]; ?>][required]" value="1"<?php echo $field["required"] ? ' checked' : NULL; ?>>
                                                                                        <label style="margin-right: 15px; font-size: 13px;" class="checkbox-custom-label" for="field-<?php echo $field["id"]; ?>-required"><?php echo __("admin/settings/field-item-required"); ?></label>

                                                                                        <input id="field-<?php echo $field["id"]; ?>-uneditable" type="checkbox" class="checkbox-custom" name="fields[<?php echo $field["id"]; ?>][uneditable]" value="1"<?php echo $field["uneditable"] ? ' checked' : NULL; ?>>
                                                                                        <label style="margin-right: 15px; font-size: 13px;" class="checkbox-custom-label" for="field-<?php echo $field["id"]; ?>-uneditable"><?php echo __("admin/settings/field-item-uneditable"); ?></label>


                                                                                    </div>
                                                                                    <div class="yuzde60" style="float:right;"><strong style="margin-right: 10px;"><?php echo __("admin/settings/field-item-answer-type"); ?>:</strong>
                                                                                        <input<?php echo $field["type"] == "text" ? ' checked' : NULL; ?> id="field-type-<?php echo $field["id"]; ?>-text" class="radio-custom" name="fields[<?php echo $field["id"]; ?>][type]" value="text" type="radio" onchange="$('#field-<?php echo $field["id"]; ?>-options').fadeOut();">
                                                                                        <label style="margin-right:10px;" for="field-type-<?php echo $field["id"]; ?>-text" class="radio-custom-label"><span class="checktext"><?php echo __("admin/settings/field-item-answer-type-text"); ?></span></label>

                                                                                        <input<?php echo $field["type"] == "textarea" ? ' checked' : NULL; ?> id="field-type-<?php echo $field["id"]; ?>-textarea" class="radio-custom" name="fields[<?php echo $field["id"]; ?>][type]" value="textarea" type="radio" onchange="$('#field-<?php echo $field["id"]; ?>-options').fadeOut();">
                                                                                        <label style="margin-right:10px;" for="field-type-<?php echo $field["id"]; ?>-textarea" class="radio-custom-label"><span class="checktext"><?php echo __("admin/settings/field-item-answer-type-textarea"); ?></span></label>

                                                                                        <input<?php echo $field["type"] == "select" ? ' checked' : NULL; ?> id="field-type-<?php echo $field["id"]; ?>-select" class="radio-custom" name="fields[<?php echo $field["id"]; ?>][type]" value="select" type="radio" onchange="$('#field-<?php echo $field["id"]; ?>-options').fadeIn();">
                                                                                        <label style="margin-right:10px;" for="field-type-<?php echo $field["id"]; ?>-select" class="radio-custom-label"><span class="checktext"><?php echo __("admin/settings/field-item-answer-type-selectbox"); ?></span></label>

                                                                                        <input<?php echo $field["type"] == "checkbox" ? ' checked' : NULL; ?> id="field-type-<?php echo $field["id"]; ?>-checkbox" class="radio-custom" name="fields[<?php echo $field["id"]; ?>][type]" value="checkbox" type="radio" onchange="$('#field-<?php echo $field["id"]; ?>-options').fadeIn();">
                                                                                        <label style="margin-right:10px;" for="field-type-<?php echo $field["id"]; ?>-checkbox" class="radio-custom-label"><span class="checktext"><?php echo __("admin/settings/field-item-answer-type-checkbox"); ?></span></label>

                                                                                        <input<?php echo $field["type"] == "radio" ? ' checked' : NULL; ?> id="field-type-<?php echo $field["id"]; ?>-radio" class="radio-custom" name="fields[<?php echo $field["id"]; ?>][type]" value="radio" type="radio" onchange="$('#field-<?php echo $field["id"]; ?>-options').fadeIn();">
                                                                                        <label style="margin-right:10px;" for="field-type-<?php echo $field["id"]; ?>-radio" class="radio-custom-label"><span class="checktext"><?php echo __("admin/settings/field-item-answer-type-radio"); ?></span></label>

                                                                                        <div class="clear"></div>
                                                                                        <div id="field-<?php echo $field["id"]; ?>-options" style="margin-top:5px;width:90%;<?php echo $field["type"] == 'text' || $field["type"] == 'textarea' ? 'display:none;' : NULL; ?>">
                                                                                            <input  class="options-tags yuzde100" name="fields[<?php echo $field["id"]; ?>][options]" type="text" placeholder="" value="<?php echo $field["options"]; ?>">
                                                                                            <span style="font-size: 13px;"><?php echo __("admin/settings/add-option-info"); ?></span>
                                                                                        </div>
                                                                                        <div class="clear"></div>

                                                                                    </div>
                                                                                </div>

                                                                            </div>

                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                            }
                                                        ?>
                                                        </tbody>
                                                    </table>

                                                    <div class="clear"></div>


                                                    <a onclick="addCustomField('<?php echo $lang["key"];?>');" style="margin-top: 20px;float: left;" href="javascript:void(0);" class="lbtn">+ <?php echo __("admin/settings/add-new-field"); ?></a>

                                                    <div style="float:right;" class="guncellebtn yuzde30"><a id="saveFieldButton_<?php echo $lang["key"];?>" href="javascript:void(0);" class="yesilbtn gonderbtn"><?php echo __("admin/settings/update-button1"); ?></a></div>

                                                </form>


                                                <div class="clear"></div>

                                            </div>
                                            <?php
                                        }
                                    ?>


                                </div><!-- tab fields language end -->


                            </div><!-- accordion item end -->

                        </div><!-- accordion end -->

                    </div><!-- tab end -->
                <?php endif; ?>

                <?php if($otherConfigure): ?>
                    <!-- tab1 start -->
                    <div id="group-other" class="tabcontent">

                        <div class="adminuyedetay">
                            <form action="<?php echo $links["controller"]; ?>" method="post" enctype="multipart/form-data" id="otherForm">
                                <input type="hidden" name="operation" value="update_other_settings">

                                <div class="formcon">
                                    <div class="yuzde30">
                                        <?php echo __("admin/settings/product-group-activation"); ?>
                                        <br>
                                        <span class="kinfo" style="font-weight: normal;"><?php echo __("admin/settings/product-group-activation-desc"); ?></span>
                                    </div>
                                    <div class="yuzde70">

                                        <?php
                                            foreach($settings["options"]["pg-activation"] AS $k=>$v){
                                                if($settings["other"]["country"] == "tr" || ($settings["other"]["country"] != "tr" && $k != "sms")){
                                                    ?>
                                                    <input<?php echo $v ? ' checked' : ''; ?> type="checkbox" name="pg-activation[<?php echo $k; ?>]" value="1" class="sitemio-checkbox" id="pg-activation-<?php echo $k; ?>">
                                                    <label class="sitemio-checkbox-label" for="pg-activation-<?php echo $k; ?>"></label>
                                                    <span class="kinfo" style="font-weight: bold;"><?php echo __("admin/settings/product-group-activation-".$k); ?></span>
                                                    <div class="clear"></div>
                                                    <br>
                                                    <?php
                                                }
                                            }
                                        ?>

                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/settings/easy-order"); ?></div>
                                    <div class="yuzde70">
                                        <input<?php echo Config::get("options/easy-order") ? ' checked' : ''; ?> type="checkbox" class="sitemio-checkbox" name="easy-order" value="1" id="easy-order">
                                        <label class="sitemio-checkbox-label" for="easy-order"></label>
                                        <span class="kinfo"><?php echo __("admin/settings/easy-order-info"); ?></span>

                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/settings/order-renewal-type"); ?></div>
                                    <div class="yuzde70">

                                        <input<?php echo Config::get("options/order-renewal-type") == 'duedate' ? ' checked' : ''; ?> type="radio" name="order-renewal-type" value="duedate" id="order-renewal-type-duedate" class="radio-custom">
                                        <label style="margin-right: 10px;" class="radio-custom-label" for="order-renewal-type-duedate"><span class="kinfo"><?php echo __("admin/settings/order-renewal-type-duedate"); ?></span></label>

                                        <input<?php echo Config::get("options/order-renewal-type") == 'datepaid' ? ' checked' : ''; ?> type="radio" name="order-renewal-type" value="datepaid" id="order-renewal-type-datepaid" class="radio-custom">
                                        <label style="margin-right: 10px;" class="radio-custom-label" for="order-renewal-type-datepaid"><span class="kinfo"><?php echo __("admin/settings/order-renewal-type-datepaid"); ?></span></label>
                                        <div class="clear"></div>
                                        <span class="kinfo"><?php echo __("admin/settings/order-renewal-type-desc"); ?></span>
                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/settings/ctoc-service-transfer"); ?></div>
                                    <div class="yuzde70">
                                        <input<?php echo Config::get("options/ctoc-service-transfer/status") ? ' checked' : ''; ?> type="checkbox" class="sitemio-checkbox" name="ctoc-service-transfer" value="1" id="ctoc-service-transfer">
                                        <label class="sitemio-checkbox-label" for="ctoc-service-transfer"></label>
                                        <span class="kinfo"><?php echo __("admin/settings/ctoc-service-transfer-info"); ?></span>

                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/settings/cookie-policy"); ?></div>
                                    <div class="yuzde70">
                                        <input<?php echo Config::get("options/cookie-policy/status") ? ' checked' : ''; ?> type="checkbox" class="sitemio-checkbox" name="cookie-policy-status" value="1" id="cookie-policy-status" onchange="if($(this).prop('checked')) $('#cookie_policy_page').css('display','block'); else $('#cookie_policy_page').css('display','none');">
                                        <label class="sitemio-checkbox-label" for="cookie-policy-status"></label>
                                        <span class="kinfo"><?php echo __("admin/settings/cookie-policy-desc"); ?></span>
                                        <div class="clear"></div>
                                        <div id="cookie_policy_page" style="<?php echo Config::get("options/cookie-policy/status") ? '' : 'display:none;'; ?>">
                                            <div class="formcon">
                                                <div class="yuzde30"><?php echo __("admin/manage-website/create-menus-page"); ?></div>
                                               <div class="yuzde70">
                                                   <select name="cookie-policy-page" class="select2">
                                                       <option value="0"><?php echo __("admin/manage-website/create-menus-select-page"); ?></option>
                                                       <?php
                                                           if(isset($page_list) && $page_list)
                                                           {
                                                               foreach($page_list AS $page)
                                                               {
                                                                   ?>
                                                                   <option<?php echo Config::get("options/cookie-policy/page") == $page['id'] ? ' selected' : ''; ?> value="<?php echo $page['id']; ?>"><?php echo $page['title']; ?></option>
                                                                   <?php
                                                               }
                                                           }
                                                       ?>
                                                   </select>
                                               </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/settings/auto-redirect-https"); ?></div>
                                    <div class="yuzde70">
                                        <input<?php echo Config::get("options/redirect-https") ? ' checked' : ''; ?> type="checkbox" class="sitemio-checkbox" name="redirect-https" value="1" id="redirect-https">
                                        <label class="sitemio-checkbox-label" for="redirect-https"></label>
                                        <span class="kinfo"><?php echo __("admin/settings/auto-redirect-https-desc"); ?></span>
                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/settings/auto-redirect-www"); ?></div>
                                    <div class="yuzde70">
                                        <input<?php echo Config::get("options/redirect-www") ? ' checked' : ''; ?> type="checkbox" class="sitemio-checkbox" name="redirect-www" value="1" id="redirect-www">
                                        <label class="sitemio-checkbox-label" for="redirect-www"></label>
                                        <span class="kinfo"><?php echo __("admin/settings/auto-redirect-www-desc"); ?></span>
                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/settings/ticket-system-status"); ?></div>
                                    <div class="yuzde70">
                                        <input<?php echo Config::get("options/ticket-system") ? ' checked' : ''; ?> type="checkbox" class="sitemio-checkbox" name="ticket-system" value="1" id="ticket-system-status" onchange="if($(this).prop('checked')) $('#nsricwv_wrap,#ticket-assignable_wrap').css('display','block'); else $('#nsricwv_wrap,#ticket-assignable_wrap').css('display','none');">
                                        <label class="sitemio-checkbox-label" for="ticket-system-status"></label>
                                        <span class="kinfo"><?php echo __("admin/settings/ticket-system-status-desc"); ?></span>
                                    </div>
                                </div>

                                <div class="formcon" id="nsricwv_wrap" style="<?php echo Config::get("options/ticket-system") ? '' : 'display:none;'; ?>">
                                    <div class="yuzde30"><?php echo __("admin/settings/nsricwv"); ?></div>
                                    <div class="yuzde70">
                                        <input<?php echo Config::get("options/nsricwv") ? ' checked' : ''; ?> type="checkbox" class="sitemio-checkbox" name="nsricwv" value="1" id="nsricwv">
                                        <label class="sitemio-checkbox-label" for="nsricwv"></label>
                                        <span class="kinfo"><?php echo __("admin/settings/nsricwv-desc"); ?></span>
                                    </div>
                                </div>

                                <div class="formcon" id="ticket-assignable_wrap" style="<?php echo Config::get("options/ticket-system") ? '' : 'display:none;'; ?>">
                                    <div class="yuzde30"><?php echo __("admin/settings/ticket-assignable"); ?></div>
                                    <div class="yuzde70">
                                        <input<?php echo Config::get("options/ticket-assignable") ? ' checked' : ''; ?> type="checkbox" class="sitemio-checkbox" name="ticket-assignable" value="1" id="ticket-assignable">
                                        <label class="sitemio-checkbox-label" for="ticket-assignable"></label>
                                        <span class="kinfo"><?php echo __("admin/settings/ticket-assignable-desc"); ?></span>
                                    </div>
                                </div>


                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/settings/kbase-system-status"); ?></div>
                                    <div class="yuzde70">
                                        <input<?php echo Config::get("options/kbase-system") ? ' checked' : ''; ?> type="checkbox" class="sitemio-checkbox" name="kbase-system" value="1" id="kbase-system-status">
                                        <label class="sitemio-checkbox-label" for="kbase-system-status"></label>
                                        <span class="kinfo"><?php echo __("admin/settings/kbase-system-status-desc"); ?></span>
                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/settings/voice-notification"); ?></div>
                                    <div class="yuzde70">
                                        <input<?php echo Config::get("options/voice-notification") ? ' checked' : ''; ?> type="checkbox" class="sitemio-checkbox" name="voice-notification" value="1" id="voice-notification" onchange="if($(this).prop('checked')) $('#voice-notification-wrap').css('display','block'); else $('#voice-notification-wrap').css('display','none');">
                                        <label class="sitemio-checkbox-label" for="voice-notification"></label>
                                        <span class="kinfo"><?php echo __("admin/settings/voice-notification-info"); ?></span>

                                        <div class="clear"></div>
                                        <div id="voice-notification-wrap" style="<?php echo Config::get("options/voice-notification") ? '' : 'display:none;'; ?>">
                                            <div class="formcon">
                                                <div class="yuzde30" style="width: 50px;">MP3</div>
                                                <div class="yuzde70">
                                                    <input type="file" name="voice-notification-mp3" style="width:200px;">
                                                    <a href="<?php echo $sadress."assets/sounds/bubble.mp3?_=".time(); ?>" target="_blank" class="sbtn blue"><i class="fa fa-play"></i></a>
                                                </div>
                                            </div>
                                            <div class="formcon">
                                                <div class="yuzde30" style="width: 50px;">OGG</div>
                                                <div class="yuzde70">
                                                    <input type="file" name="voice-notification-ogg" style="width:200px;">
                                                    <a href="<?php echo $sadress."assets/sounds/bubble.ogg?_=".time(); ?>" target="_blank" class="sbtn blue"><i class="fa fa-play"></i></a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="formcon" style="display: none;">
                                    <div class="yuzde30"><?php echo __("admin/settings/invoice-system-status"); ?></div>
                                    <div class="yuzde70">
                                        <input<?php echo Config::get("options/invoice-system") ? ' checked' : ''; ?> type="checkbox" class="sitemio-checkbox" name="invoice-system" value="1" id="invoice-system-status">
                                        <label class="sitemio-checkbox-label" for="invoice-system-status"></label>
                                        <span class="kinfo"><?php echo __("admin/settings/invoice-system-status-desc"); ?></span>
                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/settings/invoice-num-format"); ?></div>
                                    <div class="yuzde70">
                                        <input type="text" name="invoice-num-format" value="<?php echo Config::get("options/invoice-num-format"); ?>" style="width: 20%;">
                                        <span class="kinfo"><?php echo __("admin/settings/invoice-num-format-desc"); ?></span>
                                    </div>
                                </div>


                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/settings/invoice-show-requires-login"); ?></div>
                                    <div class="yuzde70">
                                        <input<?php echo Config::get("options/invoice-show-requires-login") ? ' checked' : ''; ?> type="checkbox" class="sitemio-checkbox" name="invoice-show-requires-login" value="1" id="invoice-show-requires-login">
                                        <label class="sitemio-checkbox-label" for="invoice-show-requires-login"></label>
                                        <span class="kinfo"><?php echo __("admin/settings/invoice-show-requires-login-desc"); ?></span>
                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/settings/delete-invoice-item-aoc"); ?></div>
                                    <div class="yuzde70">
                                        <input<?php echo Config::get("options/delete-invoice-item-aoc") ? ' checked' : ''; ?> type="checkbox" class="sitemio-checkbox" name="delete-invoice-item-aoc" value="1" id="delete-invoice-item-aoc">
                                        <label class="sitemio-checkbox-label" for="delete-invoice-item-aoc"></label>
                                        <span class="kinfo"><?php echo __("admin/settings/delete-invoice-item-aoc-desc"); ?></span>
                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/settings/detect-auto-price-on-invoice"); ?></div>
                                    <div class="yuzde70">
                                        <input<?php echo Config::get("options/detect-auto-price-on-invoice") ? ' checked' : ''; ?> type="checkbox" class="sitemio-checkbox" name="detect-auto-price-on-invoice" value="1" id="detect-auto-price-on-invoice">
                                        <label class="sitemio-checkbox-label" for="detect-auto-price-on-invoice"></label>
                                        <span class="kinfo"><?php echo __("admin/settings/detect-auto-price-on-invoice-desc"); ?></span>
                                    </div>
                                </div>


                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/settings/basket-system-status"); ?></div>
                                    <div class="yuzde70">
                                        <input<?php echo Config::get("options/basket-system") ? ' checked' : ''; ?> type="checkbox" class="sitemio-checkbox" name="basket-system" value="1" id="basket-system-status">
                                        <label class="sitemio-checkbox-label" for="basket-system-status"></label>
                                        <span class="kinfo"><?php echo __("admin/settings/basket-system-status-desc"); ?></span>
                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/settings/visitors-will-see-basket"); ?></div>
                                    <div class="yuzde70">
                                        <input type="checkbox" class="sitemio-checkbox" id="viwseebasket" name="viwseebasket" value="1"<?php echo $settings["options"]["viwseebasket"] ? ' checked' : NULL; ?>>
                                        <label class="sitemio-checkbox-label" for="viwseebasket"></label>
                                        <span class="kinfo"><?php echo __("admin/settings/visitors-will-see-basket-desc"); ?></span>
                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/settings/clear-end-two-zero-money"); ?></div>
                                    <div class="yuzde70">
                                        <input type="checkbox" class="sitemio-checkbox" id="cletwzmoy" name="cletwzmoy" value="1"<?php echo $settings["options"]["cletwzmoy"] ? ' checked' : NULL; ?>>
                                        <label class="sitemio-checkbox-label" for="cletwzmoy"></label>
                                        <span class="kinfo"><?php echo __("admin/settings/clear-end-two-zero-money-desc"); ?></span>
                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/settings/use-coupon"); ?></div>
                                    <div class="yuzde70">
                                        <input type="checkbox" class="sitemio-checkbox" id="use_coupon" name="use_coupon" value="1"<?php echo $settings["options"]["use_coupon"] ? ' checked' : NULL; ?>>
                                        <label class="sitemio-checkbox-label" for="use_coupon"></label>
                                        <span class="kinfo"><?php echo __("admin/settings/use-coupon-desc"); ?></span>
                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30">
                                        <?php echo __("admin/settings/starting-id-numbers"); ?>
                                        <div class="clear"></div>
                                        <span class="kinfo">
                                            <?php echo __("admin/settings/starting-id-numbers-desc"); ?>
                                        </span>
                                    </div>
                                    <div class="yuzde70">

                                        <span style="width:120px; display:inline-block;"><?php echo __("admin/settings/starting-id-number-users"); ?></span> #<input type="text" maxlength="5" name="users_auto_increment" value="<?php echo isset($users_auto_increment) ? $users_auto_increment : 1; ?>" style="width: 100px;">
                                        <div class="clear"></div>

                                        <span style="width:120px; display:inline-block;"><?php echo __("admin/settings/starting-id-number-orders"); ?></span> #<input type="text" name="orders_auto_increment" maxlength="5" value="<?php echo isset($orders_auto_increment) ? $orders_auto_increment : 1; ?>" style="width: 100px;">
                                        <div class="clear"></div>

                                        <span style="width:120px; display:inline-block;"><?php echo __("admin/settings/starting-id-number-invoices"); ?></span> #<input type="text" name="invoices_auto_increment" maxlength="5" value="<?php echo isset($invoices_auto_increment) ? $invoices_auto_increment : 1; ?>" style="width: 100px;">
                                        <div class="clear"></div>

                                        <span style="width:120px; display:inline-block;"><?php echo __("admin/settings/starting-id-number-tickets"); ?></span> #<input type="text" maxlength="5" name="tickets_auto_increment" value="<?php echo isset($tickets_auto_increment) ? $tickets_auto_increment : 1; ?>" style="width: 100px;">

                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/settings/pagination-ranks"); ?></div>
                                    <div class="yuzde70">
                                        <input style="width:40px;" type="text" name="pagination_ranks" value="<?php echo $settings["options"]["pagination_ranks"]; ?>">
                                        <span class="kinfo"><?php echo __("admin/settings/pagination-ranks-desc"); ?></span>
                                    </div>
                                </div>


                                <div class="formcon" style="display:none;">
                                    <div class="yuzde30"><?php echo __("admin/settings/news-limit"); ?></div>
                                    <div class="yuzde70">
                                        <input style="width:40px;" type="text" name="limit_news" value="<?php echo $settings["options"]["limits"]["news"]; ?>">
                                        <span class="kinfo"><?php echo __("admin/settings/news-limit-desc"); ?></span>
                                    </div>
                                </div>

                                <div class="formcon" style="display:none;">
                                    <div class="yuzde30"><?php echo __("admin/settings/articles-limit"); ?></div>
                                    <div class="yuzde70">
                                        <input style="width:40px;" type="text" name="limit_articles" value="<?php echo $settings["options"]["limits"]["articles"]; ?>">
                                        <span class="kinfo"><?php echo __("admin/settings/articles-limit-desc"); ?></span>
                                    </div>
                                </div>

                                <div class="formcon" style="display:none;">
                                    <div class="yuzde30"><?php echo __("admin/settings/sidebar-categories-limit"); ?></div>
                                    <div class="yuzde70">
                                        <input style="width:40px;" type="text" name="limit_sidebar-categories" value="<?php echo $settings["options"]["limits"]["sidebar-categories"]; ?>">
                                        <span class="kinfo"><?php echo __("admin/settings/sidebar-categories-limit-desc"); ?></span>
                                    </div>
                                </div>


                                <div class="formcon" style="display:none;">
                                    <div class="yuzde30"><?php echo __("admin/settings/sidebar-articles-most-read-limit"); ?></div>
                                    <div class="yuzde70">
                                        <input style="width:40px;" type="text" name="limit_sidebar-articles-most-read" value="<?php echo $settings["options"]["limits"]["sidebar-articles-most-read"]; ?>">
                                        <span class="kinfo"><?php echo __("admin/settings/sidebar-articles-most-read-limit-desc"); ?></span>
                                    </div>
                                </div>


                                <div class="formcon" style="display:none;">
                                    <div class="yuzde30"><?php echo __("admin/settings/sidebar-news-most-read-limit"); ?></div>
                                    <div class="yuzde70">
                                        <input style="width:40px;" type="text" name="limit_sidebar-news-most-read" value="<?php echo $settings["options"]["limits"]["sidebar-news-most-read"]; ?>">
                                        <span class="kinfo"><?php echo __("admin/settings/sidebar-news-most-read-limit-desc"); ?></span>
                                    </div>
                                </div>

                                <div class="formcon" style="display:none;">
                                    <div class="yuzde30"><?php echo __("admin/settings/sidebar-normal-most-read-limit"); ?></div>
                                    <div class="yuzde70">
                                        <input style="width:40px;" type="text" name="limit_sidebar-normal-most-read" value="<?php echo $settings["options"]["limits"]["sidebar-normal-most-read"]; ?>">
                                        <span class="kinfo"><?php echo __("admin/settings/sidebar-normal-most-read-limit-desc"); ?></span>
                                    </div>
                                </div>

                                <div class="formcon" style="display:none;">
                                    <div class="yuzde30"><?php echo __("admin/settings/knowledgebase-limit"); ?></div>
                                    <div class="yuzde70">
                                        <input style="width:40px;" type="text" name="limit_knowledgebase" value="<?php echo $settings["options"]["limits"]["knowledgebase"]; ?>">
                                        <span class="kinfo"><?php echo __("admin/settings/knowledgebase-limit-desc"); ?></span>
                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/settings/softwares-limit"); ?></div>
                                    <div class="yuzde70">
                                        <input style="width:40px;" type="text" name="limit_softwares" value="<?php echo $settings["options"]["limits"]["softwares"]; ?>">
                                        <span class="kinfo"><?php echo __("admin/settings/softwares-limit-desc"); ?></span>
                                    </div>
                                </div>

                                <div class="formcon" style="display:none;">
                                    <div class="yuzde30"><?php echo __("admin/settings/most-popular-softwares-limit"); ?></div>
                                    <div class="yuzde70">
                                        <input style="width:40px;" type="text" name="limit_most-popular-softwares" value="<?php echo $settings["options"]["limits"]["most-popular-softwares"]; ?>">
                                        <span class="kinfo"><?php echo __("admin/settings/most-popular-softwares-limit-desc"); ?></span>
                                    </div>
                                </div>


                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/settings/account-dashboard-news-limit"); ?></div>
                                    <div class="yuzde70">
                                        <input style="width:40px;" type="text" name="limit_account-dashboard-news" value="<?php echo $settings["options"]["limits"]["account-dashboard-news"]; ?>">
                                        <span class="kinfo"><?php echo __("admin/settings/account-dashboard-news-limit-desc"); ?></span>
                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/settings/account-dashboard-activity-limit"); ?></div>
                                    <div class="yuzde70">
                                        <input style="width:40px;" type="text" name="limit_account-dashboard-activity" value="<?php echo $settings["options"]["limits"]["account-dashboard-activity"]; ?>">
                                        <span class="kinfo"><?php echo __("admin/settings/account-dashboard-activity-limit-desc"); ?></span>
                                    </div>
                                </div>

                                <div style="float:right;" class="guncellebtn yuzde30"><a id="otherForm_submit" href="javascript:void(0);" class="yesilbtn gonderbtn"><?php echo __("admin/settings/update-button1"); ?></a></div>

                            </form>
                        </div>

                        <script type="text/javascript">
                            $(document).ready(function(){
                                /*$("#otherForm").bind("keypress", function(e) {
                                    if (e.keyCode == 13) $("#otherForm_submit").click();
                                });*/

                                $("#otherForm_submit").on("click",function(){
                                    MioAjaxElement($(this),{
                                        waiting_text: waiting_text,
                                        progress_text: progress_text,
                                        result:"otherForm_handler",
                                    });
                                });
                            });

                            function otherForm_handler(result){
                                if(result != ''){
                                    var solve = getJson(result);
                                    if(solve !== false){
                                        if(solve.status == "error"){
                                            if(solve.for != undefined && solve.for != ''){
                                                $("#form1 "+solve.for).focus();
                                                $("#form1 "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                                $("#form1 "+solve.for).change(function(){
                                                    $(this).removeAttr("style");
                                                });
                                            }
                                            if(solve.message != undefined && solve.message != '')
                                                alert_error(solve.message,{timer:5000});
                                        }else if(solve.status == "successful"){
                                            if(solve.redirect != undefined) window.location.href = solve.redirect;
                                            alert_success(solve.message,{timer:2000});
                                        }
                                    }else
                                        console.log(result);
                                }
                            }
                        </script>


                        <div class="clear"></div>
                    </div><!-- tab end content -->
                <?php endif; ?>

            </div>


        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>



<?php if($seoConfigure): ?>
    <?php
    foreach($lang_list AS $x=>$lang){
        $lkey = $lang["key"];
        ?>
        <div id="<?php echo $lkey; ?>_routes_configure" style="display: none;" data-iziModal-title="<?php echo __("admin/settings/routes-configure-modal-title",['{name}' => $lang["name"]]); ?>" data-iziModal-subtitle="<?php echo __("admin/settings/routes-configure-modal-subtitle"); ?>">

            <form action="<?php echo $links["controller"]; ?>" method="post" id="seoFormRoutes_<?php echo $lkey; ?>">
                <input type="hidden" name="operation" value="update_seo_routes_settings">
                <input type="hidden" name="lang" value="<?php echo $lkey; ?>">

                <div class="adminuyedetay">

                    <?php
                        $routes = ___("website-routes/website-routes",false,$lkey);
                        foreach($routes AS $k=>$v){
                            ?>
                            <div class="yuzde25"><?php echo $k; ?></div>
                            <div class="yuzde75">
                                <input type="text" name="routes[<?php echo $k; ?>]" value="<?php echo $v[0]; ?>">
                            </div>
                            <?php
                        }
                    ?>

                    <div style="float:left;" class="guncellebtn yuzde40"><a id="seo_submit_default_route_<?php echo $lkey; ?>" href="javascript:void(0);" class="lbtn gonderbtn"><?php echo __("admin/settings/restore-default-settings-button"); ?></a></div>

                    <div style="float:right;" class="guncellebtn yuzde30"><a id="seo_submit_route_<?php echo $lkey; ?>" href="javascript:void(0);" class="yesilbtn gonderbtn"><?php echo __("admin/settings/update-button1"); ?></a></div>


                </div>
            </form>
            <script type="text/javascript">
                function seo_submit_handler_<?php echo $x; ?>(result){
                    if(result != ''){
                        var solve = getJson(result);
                        if(solve !== false){
                            if(solve.status == "error"){
                                if(solve.for != undefined && solve.for != ''){
                                    $("#seoForm "+solve.for).focus();
                                    $("#seoForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                    $("#seoForm "+solve.for).change(function(){
                                        $(this).removeAttr("style");
                                    });
                                }
                                if(solve.message != undefined && solve.message != '')
                                    alert_error(solve.message,{timer:5000});
                            }else if(solve.status == "successful"){
                                if(solve.redirect != undefined) window.location.href = solve.redirect;
                                close_modal("<?php echo $lkey; ?>_routes_configure");
                                alert_success(solve.message,{timer:2000});
                            }
                        }else
                            console.log(result);
                    }
                }
                $(document).ready(function(){
                    $("#seo_submit_route_<?php echo $lkey; ?>").on("click",function(){
                        MioAjaxElement($(this),{
                            waiting_text: waiting_text,
                            progress_text: progress_text,
                            result:"seo_submit_handler_<?php echo $x; ?>",
                        });
                    });

                    $("#seo_submit_default_route_<?php echo $lkey; ?>").on("click",function(){
                        MioAjax({
                            action:"<?php echo $links["controller"]; ?>",
                            method:"POST",
                            data:{
                                operation:"restore_default_seo_routes_settings",
                                lang:"<?php echo $lkey; ?>",
                            },
                            output:"seo_submit_handler_<?php echo $x; ?>",
                        });
                    });

                });
            </script>

            <div class="clear"></div>
            <br>
        </div>
        <?php
    }
    ?>
<?php endif; ?>

<style type="text/css">
    .mio-state-highlight { background: #EEEEEE;}
    .custom-fields tr td{float:left;width:100%;background:white;}
    .mio-state-highlight2 { background: #EEEEEE; width:100%;min-height:55px;float:left;}
</style>
</body>
</html>