<?php unset($modules["Free"]);
    $get_module_page = $functions["get_module_page"];
    if(Filter::REQUEST("module_page_settings")){
        echo $get_module_page(Filter::init("POST/module_page_settings","route"),"settings");
        return true;
    }
?>
<!DOCTYPE html>
<html>
<head>
    <?php
        $plugins    = ['jquery-ui','select2'];
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
                if(tab !== "default") moduleActiveTab(tab);
            } else {
                $("#tab-module .tablinks:eq(0)").addClass("active");
                $("#tab-module .tabcontent:eq(0)").css("display", "block");
                var m_key = $("#tab-module .tablinks:eq(0)").data("tab");

                if(m_key !== "default") moduleActiveTab(m_key);
            }

            $("#tab-module .tablinks").click(function(){
                var key = $(this).data("tab");
                if(key === "default") return false;
                moduleActiveTab(key);
            });


            var select2_element = $('#payment-modules');
            select2_element.select2();
            select2_sortable(select2_element);

            $('#card-storage-module').select2({width: '100%'});

        });

        function moduleActiveTab(key){
            $("#module-"+key+" .module-page-loading").css("display","block");
            $("#module-"+key+" .module-page-content").css("display","none");

            var request     = MioAjax({
                action:window.location.href,
                method:"POST",
                data:{module_page_settings:key},
            },true,true);

            request.done(function(result){
                $("#module-"+key+" .module-page-loading").css("display","none");

                $("#module-"+key+" .module-page-content").css("display","block").html(result);
            });
        }
    </script>

    <style>
        .load-wrapp{width:150px;margin:55px auto;text-align:center;color:#607D8B}
        .load-7{display:inline-block;margin-left:-70px}
        .square{width:12px;height:12px;border-radius:4px;background-color:#607D8B}
        .spinner{position:relative;width:45px;height:45px;margin:0 auto}
        .l-1{animation-delay:.48s}
        .l-2{animation-delay:.6s}
        .l-3{animation-delay:.72s}
        .l-4{animation-delay:.84s}
        .l-5{animation-delay:.96s}
        .l-6{animation-delay:1.08s}
        .l-7{animation-delay:1.2s}
        .l-8{animation-delay:1.32s}
        .l-9{animation-delay:1.44s}
        .l-10{animation-delay:1.56s}

        .load-7 .square {animation: loadingG 1.5s cubic-bezier(.17,.37,.43,.67) infinite;}

        @keyframes loadingA {
            50%{height:15px 35px}
            100%{height:15px}
        }
        @keyframes loadingB {
            50%{width:15px 35px}
            100%{width:15px}
        }
        @keyframes loadingC {
            50%{transform:translate(0,0) translate(0,15px)}
            100%{transform:translate(0,0)}
        }
        @keyframes loadingD {
            50%{transform:rotate(0deg) rotate(180deg)}
            100%{transform:rotate(360deg)}
        }
        @keyframes loadingE {
            100%{transform:rotate(0deg) rotate(360deg)}
        }
        @keyframes loadingF {
            0%{opacity:0}
            100%{opacity:1}
        }
        @keyframes loadingG {
            0%{transform:translate(0,0) rotate(0deg)}
            50%{transform:translate(70px,0) rotate(360deg)}
            100%{transform:translate(0,0) rotate(0deg)}
        }
        @keyframes loadingH {
            0%{width:15px}
            50%{width:35px;padding:4px}
            100%{width:15px}
        }
        @keyframes loadingI {
            100%{transform:rotate(360deg)}
        }
        @keyframes bounce {
            0%,100%{transform:scale(0.0)}
            50%{transform:scale(1.0)}
        }
        @keyframes loadingJ {
            0%,100%{transform:translate(0,0)}
            50%{transform:translate(80px,0);background-color:#607D8B;width:25px}
        }
    </style>

</head>
<body>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1><?php echo __("admin/modules/payment-page-name"); ?></h1>
                <?php
                $ui_help_link = 'https://docs.wisecp.com/en/kbc/payment-gateways-docs';
                if($ui_lang == "tr") $ui_help_link = 'https://docs.wisecp.com/tr/kbc/odeme-yontemleri-doc';
                ?>
                <a title="<?php echo __("admin/help/usage-guide"); ?>" target="_blank" class="pagedocslink" href="<?php echo $ui_help_link; ?>"><i class="fa fa-life-ring" aria-hidden="true"></i></a>
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
                                    <p><?php echo __("admin/modules/payment-default-module-desc"); ?></p>
                                </div>
                            </div>

                            <form action="" method="post" id="defaultModule">
                                <input type="hidden" name="operation" value="save_settings">

                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/modules/default-modules-select"); ?></div>
                                    <div class="yuzde70">
                                        <select name="modules[]" id="payment-modules" multiple style="width: 100%;">
                                            <?php
                                                foreach($modules AS $key=>$item) {
                                                    $name       = $item["lang"]["name"];
                                                    $selected   = in_array($key,$default_module);
                                                    if(!$selected){
                                                        ?>
                                                        <option value="<?php echo $key; ?>"><?php echo $name; ?></option>
                                                        <?php
                                                    }
                                                }
                                                foreach($default_module AS $key) {
                                                    $item       = $modules[$key];
                                                    $name       = $item["lang"]["name"];
                                                    ?>
                                                    <option value="<?php echo $key; ?>" selected><?php echo $name; ?></option>
                                                    <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="formcon">
                                    <div class="yuzde30"><?php echo __("admin/modules/card-storage-module"); ?></div>
                                    <div class="yuzde70">
                                        <select name="card-storage-module" id="card-storage-module" style="width: 100%;">
                                            <option value=""><?php echo ___("needs/none"); ?></option>
                                            <?php
                                                foreach($modules AS $key=>$item) {
                                                    $name       = $item["lang"]["name"];
                                                    if(isset($item["config"]["meta"]["card-storage-supported"]) && $item["config"]["meta"]["card-storage-supported"]){
                                                        ?>
                                                        <option<?php echo Config::get("modules/card-storage-module") == $key ? ' selected' : ''; ?> value="<?php echo $key; ?>"><?php echo $name; ?></option>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>


                                <div style="float:right;" class="guncellebtn yuzde30"><a id="defaultModule_submit" href="javascript:void(0);" class="yesilbtn gonderbtn"><?php echo __("admin/modules/save-settings-button"); ?></a></div>



                            </form>
                            <script type="text/javascript">
                                $(document).ready(function(){

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

                                    <div class="module-page-loading">

                                        <div class="load-wrapp">
                                            <p style="margin-bottom:20px;font-size:17px;"><strong><?php echo ___("needs/processing"); ?>...</strong><br><?php echo ___("needs/please-wait"); ?></p>
                                            <div class="load-7">
                                                <div class="square-holder">
                                                    <div class="square"></div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="module-page-content"></div>


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