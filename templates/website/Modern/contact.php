<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    $hoptions = [
        'page' => "contact",
        'intlTelInput',
    ];
?>
<script>
    $(document).ready(function(){

        var telInput = $("#phone");

        telInput.intlTelInput({
            geoIpLookup: function(callback) {
                callback('<?php if($ipInfo = UserManager::ip_info()) echo $ipInfo["countryCode"]; else echo 'us'; ?>');
            },
            autoPlaceholder: "on",
            formatOnDisplay: true,
            initialCountry: "auto",
            hiddenInput: "phone",
            nationalMode: false,
            placeholderNumberType: "MOBILE",
            preferredCountries: ['us', 'gb', 'ch', 'ca', 'de', 'it'],
            separateDialCode: true,
            utilsScript: "<?php echo $sadress;?>assets/plugins/phone-cc/js/utils.js"
        });
    });
</script>

<div id="wrapper">

    <div class="iletisimpage">

        <h4 class="iletisimslogan"><?php echo __("website/contact/slogan"); ?></h4>

        <?php if(isset($informations) && $informations):?>
            <div class="iletisimblok" id="compnayinfo">

                <h3><?php echo __("website/contact/block-1"); ?></h3>
                <?php
                    $infos  = explode("\n",$informations);
                    foreach($infos AS $info){
                        ?>
                        <span><?php echo $info; ?></span>
                        <?php
                    }
                ?>
            </div>
        <?php endif; ?>

        <?php if(isset($pnumbers) && $pnumbers):?>
            <div class="iletisimblok">
                <i class="fa fa-phone" aria-hidden="true"></i>
                <h3><?php echo __("website/contact/block-2"); ?></h3>
                <?php foreach($pnumbers AS $k=>$v): ?>
                    <span><?php echo (!is_int($k)) ? $k.": " : false;  echo $v; ?></span>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if(isset($eaddresses) && $eaddresses):?>
            <div class="iletisimblok">
                <i class="fa fa-envelope-o" aria-hidden="true"></i>
                <h3><?php echo __("website/contact/block-3"); ?></h3>
                <?php foreach($eaddresses AS $k=>$v): ?>
                    <span><?php echo (!is_int($k)) ? $k.": " : false;  echo $v; ?></span>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if(isset($address) && $address):?>
            <div class="iletisimblok" style="border:none;">
                <i class="fa fa-map-marker" aria-hidden="true"></i>
                <h3><?php echo __("website/contact/block-4"); ?></h3>
                <span><?php echo $address; ?></span>
            </div>
        <?php endif; ?>

        <?php if((isset($contact_form_status) && $contact_form_status) || (isset($contact_map_status) && $contact_map_status)): ?>
            <div class="line" style="margin:40px 0px;"></div>
            <?php
                $auto_style = ($contact_map_status && !$contact_form_status) || ($contact_form_status && !$contact_map_status) ? ' style="margin:auto; float:none;"' : '';
            ?>

            <?php if(isset($contact_map_status) && $contact_map_status): ?>
                <div class="googlemap"<?php echo $auto_style; ?>>
                    <h4 class="iletisimtitle">
                        <?php echo __("website/contact/maps"); ?>
                        <a target="_blank" href="https://maps.google.com/maps/?q=<?php echo $maps["latitude"]; ?>,<?php echo $maps["longitude"]; ?>" class="bigmaplink"><?php echo __("website/contact/big-map-link"); ?></a>
                    </h4>
                    <?php if($maps["iframe-src"]!=NULL): ?>
                        <iframe src="<?php echo $maps["iframe-src"]; ?>" width="100%" height="320" frameborder="0" style="border:0" allowfullscreen></iframe>
                    <?php else: ?>
                        <div id="map" style="width: 100%; height: 320px;"></div>
                    <input type="hidden" value="<?php echo $maps["latitude"]; ?>" id="g_lat">
                    <input type="hidden" value="<?php echo $maps["longitude"]; ?>" id="g_lng">

                        <script type="text/javascript">
                            function initMap() {
                                var g_lat = parseFloat(document.getElementById("g_lat").value);
                                var g_lng = parseFloat(document.getElementById("g_lng").value);
                                var map = new google.maps.Map(document.getElementById('map'), {
                                    zoom: 17,
                                    center: {lat:g_lat,lng:g_lng}
                                });
                                var geocoder = new google.maps.Geocoder();

                                var marker = new google.maps.Marker({
                                    position:{
                                        lat:g_lat,
                                        lng:g_lng
                                    },
                                    map:map
                                });

                            }
                        </script>
                        <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo Config::get("contact/google-api-key"); ?>&callback=initMap"></script>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if(isset($contact_form_status) && $contact_form_status): ?>
                <div class="iletisimformu"<?php echo $auto_style; ?>>

                    <form action="<?php echo $contact_link;?>" method="POST" id="ContactForm">
                        <?php echo Validation::get_csrf_token('contact'); ?>
                        <h4 class="iletisimtitle"><?php echo __("website/contact/form-title"); ?></h4>
                        <input name="full_name" type="text" placeholder="<?php echo __("website/contact/form-full_name"); ?>">
                        <input name="email" type="text" placeholder="<?php echo __("website/contact/form-email"); ?>">
                        <input id="phone" type="text" placeholder="<?php echo __("website/contact/form-phone"); ?>" onkeypress="return event.charCode>= 48 &amp;&amp;event.charCode<= 57">
                        <textarea name="message" cols="" rows="5" placeholder="<?php echo __("website/contact/form-message"); ?>"></textarea>

                        <?php if(isset($captcha) && $captcha): ?>
                            <div style="float:left;margin-right:10px;    margin-top: 15px;"><?php echo $captcha->getOutput(); ?></div>
                            <?php if($captcha->input): ?>
                                <input id="requiredinput" style="width:130px;" name="<?php echo $captcha->input_name; ?>" type="text" placeholder="<?php echo ___("needs/form-captcha-label"); ?>">
                            <?php endif; ?>
                        <?php endif; ?>

                        <a style="width:200px;float: right;" class="yesilbtn gonderbtn mio-ajax-submit" mio-ajax-options='{"waiting_text":"<?php echo addslashes(__("website/others/button2-pending")); ?>","result":"contact_form_submit"}' style="float:right;" href="javascript:void(0);"><i class="fa fa-paper-plane-o" aria-hidden="true"></i> <?php echo __("website/contact/form-submit"); ?></a>
                    </form>
                    <script type="text/javascript">
                        function contact_form_submit(result){
                            <?php if(isset($captcha)) echo $captcha->submit_after_js(); ?>
                            if(result != ''){
                                var solve = getJson(result);
                                if(solve !== false){
                                    if(solve.status == "error"){
                                        if(solve.for != undefined && solve.for != ''){
                                            $("#ContactForm "+solve.for).focus();
                                            $("#ContactForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                            $("#ContactForm "+solve.for).change(function(){
                                                $(this).removeAttr("style");
                                            });
                                        }
                                        alert_error(solve.message,{timer:3000});
                                    }else if(solve.status == "successful"){
                                        $("#ContactForm").slideUp(500,function(){
                                            $("#ContactForm_Success").slideDown(500);
                                        })
                                    }
                                }else
                                    console.log(result);
                            }
                        }
                    </script>

                    <div id="ContactForm_Success" style="display: none;">
                        <div style="margin-top:30px;margin-bottom:70px;text-align:center;">
                            <i style="font-size:80px;" class="fa fa-check"></i>
                            <h4 style="font-weight:bold;"><?php echo __("website/contact/successful-title"); ?></h4>
                            <br>
                            <h5><?php echo __("website/contact/successful-content"); ?></h5>
                        </div>
                    </div>

                </div>
            <?php endif; ?>

        <?php endif; ?>


    </div>


</div>

<style>
    #requiredinput {width:130px;}
</style>


<div class="clear"></div>