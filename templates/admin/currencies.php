<!DOCTYPE html>
<html>
<head>
    <?php
        $plugins    = ['dataTables','mio-icons','select2'];
        include __DIR__.DS."inc".DS."head.php";
    ?>

    <script>
        var
            waiting_text  = '<?php echo ___("needs/button-waiting"); ?>',
            progress_text = '<?php echo ___("needs/button-uploading"); ?>';

        $(document).ready(function() {
            $('#datatable').DataTable({
                "columnDefs": [
                    {
                        "targets": [0],
                        "visible":false,
                        "searchable": false
                    },
                    {
                        "targets": [1,2,3,4,6,8],
                        "orderable": false
                    }
                ],
                responsive: true,
                "oLanguage":<?php include __DIR__.DS."datatable-lang.php"; ?>
            });


            $("#setCurrenciesRate_button").click(function(){
                MioAjaxElement($(this),{
                    form:$("#setCurrenciesRate_form"),
                    waiting_text: waiting_text,
                    progress_text: progress_text,
                    result:"setCurrenciesRate_handler",
                });
            });

            $("#CurrenciesSettings").on("click","#CurrenciesSettingsForm_submit",function(){
                MioAjaxElement($(this),{
                    waiting_text: waiting_text,
                    progress_text: progress_text,
                    result:"CurrenciesSettingsForm_handler",
                });
            });

            $("#editForm").bind("keypress", function(e) {
                if (e.keyCode == 13) $("#editForm_submit").click();
            });

        });

        function setCurrenciesRate_handler(result){
            if(result != ''){
                var solve = getJson(result);
                if(solve !== false){
                    if(solve.status == "successful"){
                        alert_success(solve.message,{timer:3000});
                        setTimeout(function(){
                            window.location.href = "<?php echo $links["controller"]; ?>";
                        },3000);
                    }else{
                        alert_error(solve.message,{timer:5000});
                    }
                }else
                    console.log(result);
            }
        }

        function CurrenciesSettingsForm_handler(result){
            if(result != ''){
                var solve = getJson(result);
                if(solve !== false){
                    if(solve.status == "successful"){
                        close_modal("CurrenciesSettings");
                        alert_success(solve.message,{timer:3000});
                    }else{
                        alert_error(solve.message,{timer:5000});
                    }
                }else
                    console.log(result);
            }
        }



        function updateStatus(element,id){
            var status = $(element).prop("checked");

            var request = MioAjax({
                action:"<?php echo $links["controller"]; ?>",
                method:"POST",
                data:{operation:"change_currecy_status",status:status,id:id}
            },true,true);
            request.done(function(result){
                if(result != ''){
                    var solve = getJson(result);
                    if(solve !== false){
                        if(solve.status == "successful"){
                            if(status){
                                $("#row_"+id).removeClass("currency-inactive");
                                $("#row_"+id+" .rate-item").html(solve.rate);
                            }else{
                                $("#row_"+id).addClass("currency-inactive");
                            }
                            alert_success(solve.message,{timer:2000});
                        }else if(solve.status == "error"){
                            if(solve.for != undefined && solve.for == "local"){
                                $(element).prop("checked",true);
                                alert_error(solve.message,{timer:5000});
                            }
                        }
                    }else
                        console.log(result);
                }
            });

        }
    </script>

</head>
<body>

<form id="setCurrenciesRate_form" action="<?php echo $links["controller"]; ?>" method="post"><input type="hidden" name="operation" value="set_currencies_rate"></form>

<div id="EditCurrency" style="display: none;">
    <div class="padding20">

        <script type="text/javascript">
            $(document).ready(function(){

                $("#editForm_submit").on("click",function(){
                    MioAjaxElement($(this),{
                        waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                        progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                        result:"editForm_handler",
                    });
                });
            });

            function editForm_handler(result){
                if(result != ''){
                    var solve = getJson(result);
                    if(solve !== false){
                        if(solve.status == "error"){
                            if(solve.for != undefined && solve.for != ''){
                                $("#editForm "+solve.for).focus();
                                $("#editForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                $("#editForm "+solve.for).change(function(){
                                    $(this).removeAttr("style");
                                });
                            }
                            if(solve.message != undefined && solve.message != '')
                                $("#result").fadeIn(100).html(solve.message);
                        }else if(solve.status == "successful"){
                            $("#editForm #result").fadeOut(100).html('');
                            alert_success(solve.message,{timer:2000});
                            if(solve.redirect != undefined && solve.redirect != ''){
                                setTimeout(function(){
                                    window.location.href = solve.redirect;
                                },2000);
                            }
                        }
                    }else
                        console.log(result);
                }
            }

            function EditCurrency(id){
                var request = MioAjax({
                    action:"<?php echo $links["controller"]; ?>",
                    method:"POST",
                    data:{operation:"get_currency",id:id}
                },true,true);

                request.done(function(result){
                    if(result != ''){
                        var solve = getJson(result);
                        if(solve !== false){
                            if(solve.status == "error"){
                                alert_error(solve.message,{timer:4000});
                            }else if(solve.status == "successful"){
                                var title   = "<?php echo __("admin/financial/edit-currency")?>";
                                title       = title.replace("{name}",solve.data.name);

                                open_modal("EditCurrency",{
                                    title:title,
                                });

                                $("#result").fadeOut(1).html('');

                                $("input[name='id']").val(solve.data.id);
                                $("input[name='name']").val(solve.data.name);
                                $("input[name='prefix']").val(solve.data.prefix);
                                $("input[name='suffix']").val(solve.data.suffix);
                                $("input[name='rate']").val(solve.data.rate);
                                if(solve.data.local==1) $("input[name='local']").prop("checked",true);
                                else $("input[name='local']").prop("checked",false);

                                if(solve.data.countries != undefined){

                                    var countries = '<select name="countries[]" multiple>';
                                    $(solve.data.countries).each(function(k,i){
                                        countries += '<option value="'+i.code+'"';
                                        countries += i.selected == 1 ?' selected' : '';
                                        countries += '>'+i.name+'</option>';
                                    });
                                    countries += '</select>';

                                    $("#countries_select_content").html(countries);
                                    $("#countries_select_content select").select2();
                                }else{
                                    $("#countries_select_content").html('');
                                }

                            }
                        }else
                            console.log(result);
                    }
                });
            }
        </script>
        <form action="<?php echo $links["controller"]; ?>" method="post" id="EditForm">
            <input type="hidden" name="operation" value="change_currency">
            <input type="hidden" name="id" value="">

            <div class="formcon">
                <div class="yuzde30"><?php echo __("admin/financial/currencies-list-name"); ?></div>
                <div class="yuzde70">
                    <input type="text" name="name" value="">
                    <span class="kinfo"><?php echo __("admin/financial/currencies-list-name-desc"); ?></span>
                </div>
            </div>

            <div class="formcon">
                <div class="yuzde30"><?php echo __("admin/financial/currencies-list-pre-suf-fix"); ?></div>
                <div class="yuzde70">
                    <input style="width:50px;" type="text" name="prefix" value="" placeholder="Örn:$"> / 
                    <input  style="width:50px;" type="text" name="suffix" value="" placeholder="Örn:€"><br>
                    <span class="kinfo"><?php echo __("admin/financial/currencies-list-pre-suf-fix-desc"); ?></span>
                </div>
               
            </div>

            <div class="formcon">
                <div class="yuzde30"><?php echo __("admin/financial/currencies-list-rate"); ?></div>
                <div class="yuzde70">
                    <input type="text" name="rate" value="">
                    <span class="kinfo"><?php echo __("admin/financial/currencies-list-rate-desc"); ?></span>
                </div>
            </div>

            <div class="formcon">
                <div class="yuzde30"><?php echo __("admin/financial/currencies-list-local"); ?></div>
                <div class="yuzde70">
                    <input type="checkbox" class="sitemio-checkbox" name="local" value="1" id="local" onchange="if(!$(this).prop('checked')) $(this).prop('checked',true);">
                    <label class="sitemio-checkbox-label" for="local"></label>
                    <span class="kinfo"><?php echo __("admin/financial/currencies-list-local-desc"); ?></span>
                </div>
            </div>

            <div class="formcon">
                <div class="yuzde30"><?php echo __("admin/financial/currencies-list-countries"); ?></div>
                <div class="yuzde70">
                    <div id="countries_select_content">
                    </div>
                    <span class="kinfo"><?php echo __("admin/financial/currencies-list-countries-desc"); ?></span>
                </div>
            </div>

            <div class="error" id="result" style="float: left;"></div>

            <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                <a class="yesilbtn gonderbtn" id="editForm_submit" href="javascript:void(0);"><?php echo __("admin/financial/save-settings"); ?></a>
            </div>
            <div class="clear"></div>


        </form>

    </div>
</div>

<div id="CurrenciesSettings" style="display: none;" data-izimodal-title="<?php echo __("admin/financial/currencies-settings-button"); ?>">
    <div class="padding20">
        <div class="">
            <form action="<?php echo $links["controller"]; ?>" method="post" id="CurrenciesSettingsForm">
                <input type="hidden" name="operation" value="currencies_settings">

                <?php
                    if(isset($modules) && $modules){
                        ?>
                        <div class="formcon">
                            <div class="yuzde40"><?php echo __("admin/financial/currencies-settings-module"); ?></div>
                            <div class="yuzde60">
                                <script type="text/javascript">
                                    function change_module(el){
                                        $('.module-page').slideUp(100);
                                        $('#module-help-link').attr('href',$("option:selected",el).data('help-link'));

                                        if($('option:selected',el).data('ipaid-field') === 'true')
                                            $('#ipaid-subscription-wrap').css("display","block");
                                        else
                                            $('#ipaid-subscription-wrap').css("display","none");

                                        if($('#ipaid-subscription').prop('checked') || $(el).val() == 'currencylayer')
                                            $('#module-'+$(el).val()).slideDown(100);
                                    }
                                </script>
                                <select name="module" id="module" onchange="change_module(this);">
                                    <?php
                                        $pages  = [];
                                        foreach($modules AS $key=>$module){
                                            $spage = Modules::getPage("Currency",$key,"settings");
                                            if($spage) $pages[$key] = $spage;
                                            ?>
                                            <option<?php echo $settings["module"] == $key ? ' selected' : ''; ?> value="<?php echo $key; ?>" data-help-link="<?php echo $module["config"]["help-link"]; ?>" data-ipaid-field="<?php echo isset($module["config"]["ipaid-subscription"]) ? 'true' : 'false'; ?>"><?php echo $module["lang"]["name"]; ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                                <span class="kinfo"><a id="module-help-link" target="_blank" href="<?php echo $modules[$settings["module"]]["config"]["help-link"]; ?>"><?php echo __("admin/financial/help-link"); ?></a></span>
                            </div>
                        </div>
                <?php
                    }
                ?>

                <div class="formcon">
                    <div class="yuzde40"><?php echo __("admin/financial/auto-currencies-rate"); ?></div>
                    <div class="yuzde60">
                        <input<?php echo $settings["cron"]["status"] ? ' checked' : ''; ?> type="checkbox" class="sitemio-checkbox" id="auto_currencies_rate" name="auto_currencies_rate" value="1">
                        <label for="auto_currencies_rate" class="sitemio-checkbox-label"></label>
                    </div>
                </div>

                <div class="formcon">
                    <div class="yuzde40"><?php echo __("admin/financial/currency-update"); ?></div>
                    <div class="yuzde60">
                        <input type="text" name="update_time" value="<?php echo $settings["cron"]["time"]; ?>" style="width:100px;" onkeypress="return event.charCode>= 48 &amp;&amp;event.charCode<= 57">

                        <select name="update_period" style="width:100px;">
                            
                            <option<?php echo $settings["cron"]["period"] == "hour" ? ' selected' : ''; ?> value="hour"><?php echo ___("date/hour"); ?></option>
                        </select>

                        <div id="ipaid-subscription-wrap" style="<?php echo isset($modules[$settings["module"]]["config"]["ipaid-subscription"]) ? '' : 'display:none;' ?>">
                            <input<?php echo isset($modules[$settings["module"]]["config"]["ipaid-subscription"]) && $modules[$settings["module"]]["config"]["ipaid-subscription"] ? ' checked' : ''; ?> type="checkbox" class="checkbox-custom" id="ipaid-subscription" name="ipaid-subscription" value="1" onchange="if($(this).prop('checked')) $('#module-'+$('select[name=module]').val()).slideDown(100); else if($('select[name=module]').val() != 'currencylayer') $('#module-'+$('select[name=module]').val()).slideUp(100);">
                            <label style="margin-right: 15px;margin-top:10px;font-size:13px;" class="checkbox-custom-label" for="ipaid-subscription"><strong><?php echo __("admin/financial/ipaid-subscription"); ?></label>
                        </div>
                    </div>
                </div>

                <?php
                    if(isset($pages) && $pages){
                        foreach($pages AS $key=>$content){
                            ?>
                            <div class="module-page" id="module-<?php echo $key; ?>" <?php echo $settings["module"] == $key && $modules[$settings["module"]]["config"]["ipaid-subscription"] ? '' : 'style="display:none;"'; ?>>
                                <?php echo $content; ?>
                            </div>
                            <?php
                        }
                    }
                ?>


                <div class="clear"></div>

                <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                    <a class="yesilbtn gonderbtn" id="CurrenciesSettingsForm_submit" href="javascript:void(0);"><?php echo __("admin/financial/save-settings"); ?></a>
                </div>
                <div class="clear"></div>

            </form>

        </div>
    </div>
</div>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1><strong><?php echo __("admin/financial/page-currencies"); ?></strong></h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="clear"></div>

            <div class="green-info">
                <div class="padding20">
                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                    <?php echo __("admin/financial/currencies-desc"); ?>
                </div>
            </div>
            <div class="clear"></div>
            <br>

            <a href="javascript:open_modal('CurrenciesSettings');void 0;" class="green lbtn"><i class="fa fa-edit"></i> <?php echo __("admin/financial/currencies-settings-button"); ?></a>

            <a href="javascript:void(0);" class="blue lbtn" id="setCurrenciesRate_button"><i class="fa fa-refresh"></i> <?php echo __("admin/financial/update-currencies-rate"); ?></a>


            <div style="float: right;text-align:right;">
                <span style="font-weight: 600;"><?php echo __("admin/financial/auto-currencies-rate"); ?></span> :
                <?php if($settings["cron"]["status"]): ?>
                    <strong style="color:#4caf50"><?php echo __("admin/financial/status-active"); ?></strong> (<?php echo $settings["cron"]["time"]." ".___("date/".$settings["cron"]["period"]); ?>)<br>
                <?php else: ?>
                <strong style="color:red"><?php echo __("admin/financial/status-inactive"); ?></strong> (<?php echo $settings["cron"]["time"]." ".___("date/".$settings["cron"]["period"]); ?>)<br>
                <?php endif; ?>
                <span style="font-size:13px;"><?php echo __("admin/financial/last-update"); ?>: <?php echo strstr($settings["cron"]["last-run-time"],"0000") ? ___("needs/none") : DateManager::format(Config::get("options/date-format")." - H:i",$settings["cron"]["last-run-time"]); ?> </span>
            </div>

            <div class="clear"></div>
            <br>

            <table width="100%" id="datatable" class="table table-striped table-borderedx table-condensed nowrap">
                <thead style="background:#ebebeb;">
                <tr>
                    <th align="left">#</th>
                    <th align="left"><?php echo __("admin/financial/currencies-list-country"); ?></th>
                    <th align="center"><?php echo __("admin/financial/currencies-list-name"); ?></th>
                    <th align="center"><?php echo __("admin/financial/currencies-list-code"); ?></th>
                    <th align="center"><?php echo __("admin/financial/currencies-list-pre-suf-fix"); ?></th>
                    <th align="center"><?php echo __("admin/financial/currencies-list-rate"); ?></th>
                    <th align="center"><?php echo __("admin/financial/currencies-list-local"); ?></th>
                    <th align="center"><?php echo __("admin/financial/currencies-list-status"); ?></th>
                    <th align="center"> </th>
                </tr>
                </thead>
                <tbody align="Center" style="border-top:none;">
                <?php
                    if(isset($list) && $list){
                        $i=0;
                        foreach($list AS $row){
                            $i++;
                            $flag        = explode("_",$row["country"]);
                            $flag        = isset($flag[1]) ? $flag[1] : false;
                            $flag_src    = $sadress."assets/images/flags/".strtolower($flag).".svg";

                            $pre_suf_fix = NULL;
                            $pre_suf_fix .= $row["prefix"] == '' ? '-' : $row["prefix"];
                            $pre_suf_fix .= " / ";
                            $pre_suf_fix .= $row["suffix"] == '' ? '-' : $row["suffix"];
                            ?>
                            <tr id="row_<?php echo $row["id"]; ?>" class="<?php echo $row["status"] != "active" ? 'currency-inactive' : ''; ?>">
                                <td><?php echo $i; ?></td>

                                <td align="left">
                                    <img src="<?php echo $flag_src; ?>" height="15" style="float: left;margin-top:5px;margin-right: 5px;height:15px;width: 18px;">
                                    <?php echo $flag; ?>
                                </td>
                                <td align="center"><?php echo $row["name"]; ?></td>
                                <td align="center"><?php echo $row["code"]; ?></td>
                                <td align="center"><?php echo $pre_suf_fix; ?></td>
                                <td align="center" class="rate-item"><?php echo $row["rate"]; ?></td>
                                <td align="center">
                                    <?php if($row["local"]): ?>
                                        <span style="font-size: 24px;color: #81c04e;"><i class="ion-android-checkmark-circle"></i></span>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td align="center">
                                    <input<?php echo $row["status"] == "active" ? ' checked' : ''; ?> type="checkbox" class="sitemio-checkbox" id="currency_<?php echo $row["id"]; ?>_status" onchange="updateStatus(this,<?php echo $row["id"]; ?>);">
                                    <label  for="currency_<?php echo $row["id"]; ?>_status" class="sitemio-checkbox-label"></label>
                                </td> 
                                <td align="center">
                                    <a href="javascript:EditCurrency(<?php echo $row["id"]; ?>);void 0;" class="sbtn"><i class="fa fa-edit"></i></a>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                ?>



                </tbody>
            </table>




        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>