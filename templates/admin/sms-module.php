<?php
    $get_module_page = $functions["get_module_page"];
    $intstat         = Config::get("options/international-sms-service");
    $trsmsstat       = Config::get("options/turkey-sms-service");
    $smsapiser       = Config::get("options/sms-api-service");
?>
<!DOCTYPE html>
<html>
<head>
    <?php
        $plugins    = ['jquery-ui'];
        include __DIR__.DS."inc".DS."head.php";
    ?>
    <script type="text/javascript">
        var
            waiting_text  = '<?php echo ___("needs/button-waiting"); ?>',
            progress_text = '<?php echo ___("needs/button-uploading"); ?>';
    </script>

    <script type="text/javascript">
        $(function(){

            var tab = _GET("module");
            if (tab != '' && tab != undefined) {
                $("#tab-module .tablinks[data-tab='" + tab + "']").click();
            } else {
                $("#tab-module .tablinks:eq(0)").addClass("active");
                $("#tab-module .tabcontent:eq(0)").css("display", "block");
            }

        });
    </script>

</head>
<body>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1><?php echo __("admin/modules/sms-page-name"); ?></h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>


            <div class="clear"></div>

            <div class="verticaltabs">
                <div class="verticaltabscon">

                    <div id="tab-module"><!-- tab wrap content start -->
                        <ul class="tab">

                            <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, 'default','module')" data-tab="default"><span><?php echo __("admin/modules/default-module"); ?></span></a></li>
                            <span style="float: left;margin:15px 0px;font-weight: bold;"><?php echo __("admin/modules/modulestitle"); ?></span>
                            <div class="modulescroll">
                                <?php
                                    foreach($modules AS $key=>$item){
                                        $name = isset($item["lang"]["name"]) ? $item["lang"]["name"] : NULL;
                                        ?>
                                        <li><a href="javascript:void(0)" class="tablinks" onclick="open_tab(this, '<?php echo $key; ?>','module')" data-tab="<?php echo $key; ?>"><span><?php echo $name; ?></span></a></li>
                                        <?php
                                    }
                                ?>
                            </div>
                        </ul>

                        <div id="module-default" class="tabcontent"><!-- tab item start -->
                            <div class="verticaltabstitle">
                                <h2><?php echo __("admin/modules/default-module"); ?></h2>
                            </div>

                            <div class="green-info" style="margin-bottom:20px;">
                                <div class="padding15">
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                    <p><?php echo __("admin/modules/sms-default-module-desc"); ?></p>
                                </div>
                            </div>



                            <form action="" method="post" id="defaultModule">
                                <input type="hidden" name="operation" value="save_settings">

                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/modules/default-module-sms-select"); ?></div>
                                    <div class="yuzde70">
                                        <select name="module">
                                            <option value=""><?php echo ___("needs/none"); ?></option>
                                            <?php
                                                foreach($modules AS $key=>$item) {
                                                    $name       = $item["lang"]["name"];
                                                    $selected   = $key==$default_module;
                                                    $module     = new $key();
                                                    if(isset($item["config"]["meta"]["website"]))
                                                        $name .= " - ".$item["config"]["meta"]["website"];
                                                    ?>
                                                    <option value="<?php echo $key; ?>"<?php echo $selected ? ' selected' : NULL; ?>><?php echo $name; ?></option>
                                                    <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/modules/default-module-sms-intl-select"); ?></div>
                                    <div class="yuzde70">
                                        <select name="module-intl" id="selectModule">
                                            <option value=""><?php echo ___("needs/none"); ?></option>
                                            <?php
                                                $showInternational = false;
                                                foreach($modules AS $key=>$item) {
                                                    $module     = new $key();
                                                    if($module->international){
                                                        $name       = $item["lang"]["name"];
                                                        $selected   = $key==$default_module_intl;
                                                        $module     = new $key();
                                                        if($selected) $showInternational = true;
                                                        if(isset($item["config"]["meta"]["website"]))
                                                            $name .= " - ".$item["config"]["meta"]["website"];
                                                        ?>
                                                        <option value="<?php echo $key; ?>"<?php echo $selected ? ' selected' : NULL; ?>><?php echo $name; ?></option>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>


                                <div id="international-content"<?php echo $showInternational ? '' : 'style="display:none;"'; ?>>
                                    <div class="formcon">

                                        <div class="blue-info" style="margin-bottom:20px;">
                                            <div class="padding15">
                                                <p> <?php echo __("admin/modules/international-sms-service-description"); ?></p>
                                            </div>
                                        </div>

                                        <div id="informations" data-iziModal-title="<?php echo __("admin/modules/informationstitle"); ?>" style="display:none">
                                            <div class="padding20"><p><?php echo __("admin/modules/international-sms-service-description2"); ?></p></div>
                                        </div>

                                        <div class="clear"></div>
                                        <div class="yuzde30"><?php echo __("admin/modules/international-sms-service"); ?></div>
                                        <div class="yuzde70">
                                            <input type="checkbox" class="sitemio-checkbox" id="intsmsser" name="intsmsser" value="1"<?php echo $intstat ? ' checked' : NULL; ?>>
                                            <label class="sitemio-checkbox-label" for="intsmsser"></label>
                                            <span class="kinfo"><?php echo __("admin/modules/international-sms-service-desc"); ?></span>
                                        </div>
                                    </div>
                                </div>

                                <?php if(Config::get("general/country") == "tr"): ?>
                                    <div class="formcon">
                                        <div class="yuzde30"><?php echo __("admin/modules/turkey-sms-service"); ?></div>
                                        <div class="yuzde70">
                                            <input<?php echo $trsmsstat ? ' checked' : ''; ?> type="checkbox" id="turkey_sms_service" name="trsmsser" value="1" class="sitemio-checkbox">
                                            <label for="turkey_sms_service" class="sitemio-checkbox-label"></label>
                                            <span class="kinfo"><?php echo __("admin/modules/turkey-sms-service-desc"); ?></span>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/modules/sms-api-service"); ?></div>
                                    <div class="yuzde70">
                                        <input<?php echo $smsapiser ? ' checked' : ''; ?> type="checkbox" name="sms-api-service" value="1" class="sitemio-checkbox" id="api_service">
                                        <label for="api_service" class="sitemio-checkbox-label"></label>
                                        <span class="kinfo"><?php echo __("admin/modules/sms-api-service-desc"); ?></span>
                                    </div>
                                </div>


                                <div style="float:right;" class="guncellebtn yuzde30"><a id="defaultModule_submit" href="javascript:void(0);" class="yesilbtn gonderbtn"><?php echo __("admin/modules/save-settings-button"); ?></a></div>



                            </form>
                            <script type="text/javascript">
                                $(document).ready(function(){
                                    $("#selectModule").change(function(){
                                        var val = $(this).val();
                                        if(val == ''){
                                            $("#international-content").fadeOut(200);
                                            $("#intsmsser").prop("checked",false);
                                        } else
                                            $("#international-content").fadeIn(200);
                                    });

                                    $("#defaultModule_submit").click(function(){
                                        MioAjaxElement($(this),{
                                            waiting_text:waiting_text,
                                            progress_text:progress_text,
                                            result:"defaultModule_handler",
                                        });
                                    });
                                });

                                function defaultModule_handler(result){
                                    if(result != ''){
                                        var solve = getJson(result);
                                        if(solve !== false){
                                            if(solve.status == "error"){
                                                if(solve.for != undefined && solve.for != ''){
                                                    $("#defaultModule "+solve.for).focus();
                                                    $("#defaultModule "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                                    $("#defaultModule "+solve.for).change(function(){
                                                        $(this).removeAttr("style");
                                                    });
                                                }
                                                if(solve.message != undefined && solve.message != '')
                                                    alert_error(solve.message,{timer:5000});
                                            }else if(solve.status == "successful")
                                                alert_success(solve.message,{timer:2500});
                                        }else
                                            console.log(result);
                                    }
                                }
                            </script>

                            <div class="clear"></div>
                        </div><!-- tab item end -->

                        <?php
                            foreach($modules AS $key=>$item){
                                $name    = $item["lang"]["name"];
                                $version = isset($item["config"]["meta"]["version"]) ? $item["config"]["meta"]["version"] : false;
                                $logo = isset($item["config"]["meta"]["logo"]) ? $item["config"]["meta"]["logo"] : false;
                                if($logo) $logo = Utility::image_link_determiner($logo,$module_url.$key.DS);
                                $page   = $get_module_page($key,"settings");
                                ?>
                                <div id="module-<?php echo $key; ?>" class="tabcontent"><!-- tab item start -->

                                    <div class="verticaltabstitle">
                                        <h2><?php echo $name; ?>
                                            <?php if($logo): ?>
                                                <img style="float:right" src="<?php echo $logo; ?>" height="35"/>
                                            <?php endif; ?>
                                        </h2>
                                    </div>

                                    <?php
                                        if($page){

                                            echo $page;

                                        }else{
                                            ?>
                                            <div class="error"><?php echo __("admin/modules/settings-page-not-found"); ?></div>
                                            <?php
                                        }
                                    ?>
                                    <div class="clear"></div>
                                </div><!-- tab item end -->
                                <?php
                            }
                        ?>


                    </div><!-- tab wrap content end -->

                </div>
            </div>



        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>