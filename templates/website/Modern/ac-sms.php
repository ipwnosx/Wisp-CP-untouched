<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    $wide_content   = true;
    $support_api    = Config::get("options/sms-api-service");

    include $tpath."common-needs.php";
    $hoptions = ["datatables","jquery-ui","counterup","iziModal"];
?>
<script type="text/javascript">
        function openTab(evt, tabName) {
            var gtab,dtab,link,tab;
            $(".tabcontent").css("display","none");
            $(".tablinks").removeClass("active");
            $("#"+tabName).css("display","block");
            $(evt).addClass("active");
            gtab     = gGET("tab");
            dtab     = $(evt).attr("data-tab");
            if((gtab == '' || gtab == null || gtab == undefined) && dtab == 1){
                link    = window.location.href;
            }else{
                link     = sGET("tab",dtab);
            }
            window.history.pushState("object or string", $("title").html(),link);
        }

        $(document).ready(function(){
            var tab = gGET("tab");
            if(tab == '' || tab == undefined){
                $(".tablinks:eq(0)").click();
            }else{
                $(".tablinks[data-tab='"+tab+"']").click();
            }

            var accordionx = gGET("accordion");
            if(accordionx == null){
                accordionx = false;
            }else
                accordionx -=1;

            $( "#accordion" ).accordion({
                heightStyle: "content",
                active:accordionx,
                collapsible: true,
            });

            var request = MioAjax({
                action:"<?php echo $links["controller"]; ?>",
                method:"POST",
                data:{operation:"get-statistics"}
            },true,true);

            request.success(function (result){
                if(result != ''){
                    var solve = getJson(result);
                    if(solve !== false){
                        if(solve.status == "successful"){
                            if(solve.credit != undefined && solve.credit != ''){
                                $("#currency_prefix").html(solve.currency.prefix);
                                $("#currency_suffix").html(solve.currency.suffix);
                                $("#get_credit").html(solve.credit);
                            }

                            if(solve.statistic_today !== undefined)
                                $("#get_statistic_today").html(solve.statistic_today);
                            if(solve.statistic_yesterday !== undefined)
                                $("#get_statistic_yesterday").html(solve.statistic_yesterday);
                            if(solve.statistic_month !== undefined)
                                $("#get_statistic_month").html(solve.statistic_month);
                            if(solve.statistic_total !== undefined)
                                $("#get_statistic_total").html(solve.statistic_total).counterUp({delay: 10,time:1000});

                        }
                    }else
                        console.log(result);
                }
            });

        });
    </script>
<div class="mpanelrightcon">

        <div class="mpaneltitle">
            <div class="sayfayolu"><?php include $tpath."inc".DS."panel-breadcrumb.php"; ?></div>
            <h4><strong><i class="fa fa-globe" aria-hidden="true"></i> <?php echo __("website/account_sms/page-title"); ?></strong></h4>
        </div>


        <ul class="tab">
            <li><a href="javascript:void(0)" class="tablinks" onclick="openTab(this, 'ozet')" data-tab="1"><i class="fa fa-info" aria-hidden="true"></i> <?php echo __("website/account_sms/tab-detail"); ?></a></li>
            <li><a href="javascript:void(0)" class="tablinks" onclick="openTab(this, 'smsgonder')" data-tab="send"><i class="fa fa-paper-plane-o" aria-hidden="true"></i> <?php echo __("website/account_sms/tab-send"); ?></a></li>
            <li><a href="javascript:void(0)" class="tablinks" onclick="openTab(this, 'baslikislemleri')" data-tab="origins"><i class="fa fa-id-card-o" aria-hidden="true"></i> <?php echo __("website/account_sms/tab-origins"); ?></a></li>
            <li><a href="javascript:void(0)" class="tablinks" onclick="openTab(this, 'rehber')" data-tab="contact"><i class="fa fa-address-book-o" aria-hidden="true"></i> <?php echo __("website/account_sms/tab-contact"); ?></a></li>
            <li><a href="javascript:void(0)" class="tablinks" onclick="openTab(this, 'raporlar')" data-tab="reports"><i class="fa fa-bar-chart" aria-hidden="true"></i> <?php echo __("website/account_sms/tab-reports"); ?></a></li>
        </ul>


        <div id="ozet" class="smshzmblok tabcontent">

            <div class="hizmetblok" >
                <div class="service-first-block" style="border:none;min-height:auto">
                    <div id="order_image" style="display: inline-block;margin-right: 32px;">
                        <img style="width:130px;" src="<?php echo $tadress."images/smscover.svg"; ?>" width="auto" height="auto">
                    </div>
                    <div style="display: inline-block;vertical-align: top;margin-top: 30px;">
                    <h4 style="font-size: 25px;">
                        <strong id="currency_prefix"></strong><strong id="get_credit"><img src="<?php echo $sadress; ?>assets/images/loading.gif" width="30"></strong> <strong id="currency_suffix"></strong>
                    </h4>
                    <h4 style=" font-size: 18px;"><?php echo __("website/account_sms/detail-current-credit"); ?></h4>
                    </div>
                   
                </div>
            </div>

              <div class="hizmetblok" style="border:none;min-height:auto">
                 <div id="order-service-detail-btns">
                     <a href="javascript:$('a[data-tab=send]').click();void 0;" class="yesilbtn gonderbtn"><i class="fa fa-paper-plane-o" aria-hidden="true"></i> <?php echo __("website/account_sms/send-sms"); ?></a>
                    <a href="<?php echo $links["buy-credit"]; ?>" class="mavibtn gonderbtn"><i class="fa fa-refresh"></i> <?php echo __("website/account_sms/add-credit"); ?></a>
                </div>
              </div>

            <div class="hizmetblok">
                <table width="100%" border="0">
                    <tr>
                        <td colspan="2" bgcolor="#ebebeb" ><strong><?php echo __("website/account_sms/detail-statistics-info"); ?></strong></td>
                    </tr>

                    <tr>
                        <td><strong><?php echo __("website/account_sms/detail-statistic-today"); ?></strong></td>
                        <td>
                            <?php
                                $variable = "<strong id=\"get_statistic_today\"><img src=\"".$sadress."assets/images/loading.gif\" width=\"30\"></strong>";
                                echo __("website/account_sms/statistic-sms-desc",['{quantity}' => $variable]);
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td><strong><?php echo __("website/account_sms/detail-statistic-yesterday"); ?></strong></td>
                        <td>
                            <?php
                                $variable = "<strong id=\"get_statistic_yesterday\"><img src=\"".$sadress."assets/images/loading.gif\" width=\"30\"></strong>";
                                echo __("website/account_sms/statistic-sms-desc",['{quantity}' => $variable]);
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td><strong><?php echo __("website/account_sms/detail-statistic-month"); ?></strong></td>
                        <td>
                            <?php
                                $variable = "<strong id=\"get_statistic_month\"><img src=\"".$sadress."assets/images/loading.gif\" width=\"30\"></strong>";
                                echo __("website/account_sms/statistic-sms-desc",['{quantity}' => $variable]);
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td><strong><?php echo __("website/account_sms/detail-statistic-total"); ?></strong></td>
                        <td>
                            <?php
                                $variable = "<strong id=\"get_statistic_total\"><img src=\"".$sadress."assets/images/loading.gif\" width=\"30\"></strong>";
                                echo __("website/account_sms/statistic-sms-desc",['{quantity}' => $variable]);
                            ?>
                        </td>
                    </tr>
                </table>
            </div>

            <?php if($support_api): ?>
                <div class="hizmetblok">
                    <table width="100%" border="0">
                        <tr>
                            <td colspan="2" bgcolor="#ebebeb" ><strong><?php echo __("website/account_sms/api-informations"); ?></strong></td>
                        </tr>

                        <tr>
                            <td colspan="2" style="font-size:14px;"><?php echo __("website/account_sms/api-informations-description"); ?></td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <strong><?php echo __("website/account_sms/api-address"); ?></strong><br>
                                <a href="<?php echo APP_URI."/api/international-sms"; ?>" target="_blank"><?php echo APP_URI."/api/international-sms"; ?></a>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2"><strong>User Token</strong> <span class="selectalltext"><?php echo $user_token; ?></span></td>

                        </tr>

                    </table>

                </div>
            <?php endif; ?>

        </div>



        <div id="smsgonder" class="tabcontent">
            <div class="tabcontentcon">


                <form id="SubmitSMS" action="<?php echo $links["controller"]; ?>" method="post">
                    <input type="hidden" name="operation" value="submit_sms">

                    <div id="FormLayout">

                        <br>
                        <div class="smsaccountbalanceinfo blue-info">
                            

                            <div class="padding20">

                            	<i style="    font-size: 35px;    margin: 0;" class="fa fa-info-circle" aria-hidden="true"></i>
                            	<p><?php echo __("website/account_sms/accountbalanceinfo"); ?>
                                <strong><?php echo $user_balance; ?></strong></p>
                            </div>
                        </div>
                        <div class="clear"></div>
                        <br>

                        <label class="yuzde25"><strong><?php echo __("website/account_sms/select-origin"); ?>:</strong></label>
                        <select class="yuzde25" name="origin" >
                            <option value=""><?php echo __("website/account_sms/select-option"); ?></option>
                            <?php
                                if(isset($origins) && is_array($origins)){
                                    foreach($origins AS $origin){
                                        if($origin["status"] == "active"){
                                            ?>
                                            <option value="<?php echo $origin["id"]; ?>"><?php echo $origin["name"]; ?></option>
                                            <?php
                                        }
                                    }
                                }
                            ?>
                        </select>
                        <a class="lbtn" href="javascript:$('a[data-tab=origins]').trigger('click');void 0;"><?php echo __("website/account_sms/add-new-origin"); ?></a>

                        <div class="clear"></div><br>

                        <div class="line"></div>


                        <?php if(isset($groups) && is_array($groups) && sizeof($groups)>0): ?>
                            <label class="yuzde25"><strong><?php echo __("website/account_sms/select-group"); ?></strong></label>
                            <div class="yuzde75">

                                <?php
                                    foreach ($groups as $group) {
                                        $count = sizeof($group["numbers"]);
                                        ?>
                                        <input id="select-group-<?php echo $group["id"]; ?>" class="checkbox-custom" name="groups" value="<?php echo $group["id"]; ?>" type="checkbox" >
                                        <label for="select-group-<?php echo $group["id"]; ?>" class="checkbox-custom-label"><span class="checktext"><?php echo $group["name"]; ?> (<?php echo $count; ?>)</span></label>
                                        <?php
                                    }
                                ?>

                            </div>
                            <div class="line"></div>
                            <div class="clear"></div>
                        <?php endif; ?>

                        <div class="yuzde50">
                            <label><strong><?php echo __("website/account_sms/message-text"); ?></strong> (<span id="charNum">0</span> <?php echo __("website/account_sms/dimension-character"); ?> - <span id="SmsCount">1</span> <?php echo __("website/account_sms/dimension-sms"); ?>)</label>
                            <textarea rows="6" onkeyup="countChar(this);" name="message" id="message" placeholder="<?php echo __("website/account_sms/message-placeholder"); ?>"></textarea>
                        </div>

                        <div class="yuzde50">
                            <label><strong><?php echo __("website/account_sms/sent-numbers"); ?></strong> (<span id="NumbersCount">0</span> <?php echo __("website/account_sms/count"); ?>)</label>
                            <textarea name="numbers" id="numbers" style="resize:vertical" rows="6" placeholder="<?php echo __("website/account_sms/group-numbers-placeholder"); ?>"></textarea><br>
                        </div>


                        <div class="clear"></div>



                        <a href="javascript:void(0);" onclick="previewButton();" class="yesilbtn gonderbtn"><?php echo __("website/account_sms/preview-button"); ?></a>

                        <div class="clear"></div><br>

                        <?php if(isset($dimensions) && is_array($dimensions) && sizeof($dimensions)): ?>
                            <table width="100%" border="0" class="smsucretleri">
                                <thead>
                                <tr>
                                    <th align="left"><?php echo __("website/account_sms/dimension-character"); ?></th>
                                    <th align="center"><?php echo __("website/account_sms/dimension-size"); ?></th>
                                </tr></thead>
                                <tbody>
                                <?php foreach($dimensions AS $dimension): ?>
                                    <tr>
                                        <td><?php echo $dimension["start"]; ?> - <?php echo $dimension["end"]; ?> <?php echo __("website/account_sms/dimension-character"); ?></td>
                                        <td align="center"><?php echo $dimension["part"];?> SMS</td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>


                    </div>

                    <div id="preview" style="display: none;margin-top:35px">

                        <h5 style="color:#8bc34a"><strong><?php echo __("website/account_sms/preview-title"); ?></strong></h5><br>
                        <div class="msjonizleme">



                            <div class="smspreviewinfo">
                                <div class="yuzde30"><strong><?php echo __("website/account_sms/preview-character-count"); ?></strong></div>
                                <div class="yuzde70"><span id="preview_gMessageLength">0</span> <?php echo __("website/account_sms/dimension-character"); ?> (<span id="preview_MessageCountSMS">1</span> SMS)</div>
                            </div>


                            <div class="smspreviewinfo">
                                <div class="yuzde30"><strong><?php echo __("website/account_sms/preview-origin"); ?></strong></div>
                                <div class="yuzde70" id="preview_OriginName">NONE</div>
                            </div>



                            <div class="smspreviewinfo">
                                <div class="yuzde30" style="vertical-align:top;"><strong><?php echo __("website/account_sms/preview-message-text"); ?></strong></div>
                                <div class="yuzde70" id="preview_MessageText" style="font-size:14px;"></div>
                            </div>

                        </div>



                        <table class="sendsmstableinfo">
                            <thead>
                            <tr>
                                <th align="left"><?php echo __("website/account_sms/sending-table-field-country"); ?></th>
                                <th align="center"><?php echo __("website/account_sms/sending-table-field-number"); ?></th>
                                <th align="center">SMS</th>
                                <th align="center"><?php echo __("website/account_sms/sending-table-field-amount"); ?></th>
                                <th align="center"> </th>
                            </tr>
                            </thead>
                            <tbody id="numberList"></tbody>
                        </table>


                        <div id="PnResult">
                            <span><?php echo __("website/account_sms/total-sent-number"); ?>: <strong id="total_sent_number">1</strong> <strong><?php echo __("website/account_sms/count"); ?></strong></span><br>
                            <span><?php echo __("website/account_sms/total-sent-sms"); ?>: <strong id="total_sent_sms">1</strong> <strong><?php echo __("website/account_sms/count"); ?></strong></span><br>
                            <span><?php echo __("website/account_sms/total-falling-loan-amount"); ?>: <strong id="total_falling_loan_amount">0</strong></span>
                        </div>
                        <div class="line"></div>
                        <div class="clear"></div>
                        <a href="javascript:void(0);" onclick="turnBack();" class="lbtn"><i class="fa fa-angle-double-left" aria-hidden="true"></i> <?php echo __("website/account_sms/preview-turn-back"); ?></a>

                        <a  class="yesilbtn gonderbtn" id="block_btn" style="display: none;cursor:no-drop; background-color:#CCCCCC;"><i class="fa fa-paper-plane-o" aria-hidden="true"></i> <?php echo __("website/account_sms/preview-send-sms"); ?></a>

                        <a href="javascript:void(0);" id="send_btn" style="display: none;" class="yesilbtn gonderbtn mio-ajax-submit" mio-ajax-options='{"result":"SendSMS","waiting_text":"<?php echo addslashes(__("website/others/button5-pending")); ?>"}'><i class="fa fa-paper-plane-o" aria-hidden="true"></i> <?php echo __("website/account_sms/preview-send-sms"); ?></a>

                        <div class="clear"></div>


                    </div>

                    <div class="clear"></div>
                    <div id="xresult" class="error" style="display:none; text-align: center;"></div>
                </form>

                <div id="sentSMS" style="display: none;">
                    <div style="margin-top:30px;text-align:center;">
                        <i style="font-size:80px;" class="fa fa-check"></i>
                        <h5><?php echo __("website/account_sms/sent-sms"); ?></h5>
                        <br>
                    </div>
                </div>


                <?php
                    $last     = end($dimensions);
                    $last_end = $last["end"];
                    $size     = sizeof($dimensions);
                ?>
                <script type="text/javascript">
                    function SendSMS(result){
                        if(result != ''){
                            var solve = getJson(result);
                            if(solve !== false){
                                if(solve.status == "error"){
                                    if(solve.for != undefined && solve.for != ''){
                                        $("#SubmitSMS "+solve.for).focus();
                                        $("#SubmitSMS "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                        $("#SubmitSMS "+solve.for).change(function(){
                                            $(this).removeAttr("style");
                                        });
                                    }
                                    if(solve.message != undefined && solve.message != '')
                                        $("#xresult").fadeIn(300).html(solve.message);
                                    else
                                        $("#xresult").fadeOut(300).html('');
                                }else if(solve.status == "successful"){
                                    $("#xresult").fadeOut(300).html('');
                                    $("#SubmitSMS").fadeOut(400,function(){
                                        $("html,body").animate({scrollTop:200},600);
                                        $("#sentSMS").fadeIn(400);
                                        setTimeout(function (){
                                            window.location.href = '<?php echo $links["controller"]; ?>?tab=reports';
                                        },3000);
                                    });
                                }
                            }else
                                console.log(result);
                        }
                    }

                    function previewButton(){
                        var origin = $("#SubmitSMS select[name=origin]").val();
                        if(origin == undefined || origin == ''){
                            swal({
                                title:'<?php echo __("website/account_sms/modal-error-title"); ?>',
                                text:'<?php echo __("website/account_sms/preview-error1"); ?>',
                                type:"error"
                            });
                            return false;
                        }
                        var origin_text = $("#SubmitSMS select[name=origin] option[value='"+origin+"']").text();

                        var count   = parseInt($("#NumbersCount").html());
                        var mcount  = parseInt($("#charNum").html());
                        var mSmsC   = parseInt($("#SmsCount").html());
                        var message = $("#message").val();

                        if(count < 1){
                            swal({
                                title:'<?php echo __("website/account_sms/modal-error-title"); ?>',
                                text:'<?php echo __("website/account_sms/preview-error2"); ?>',
                                type:"error"
                            });
                            return false;
                        }


                        if(mcount < 1){
                            swal({
                                title:'<?php echo __("website/account_sms/modal-error-title"); ?>',
                                text:'<?php echo __("website/account_sms/preview-error3"); ?>',
                                type:"error"
                            });
                            return false;
                        }

                        var numbers;
                        numbers         = $("#numbers").val();
                        numbers         = numbers.split("\n");

                        var request = MioAjax({
                            action:"<?php echo $links["controller"];?>",
                            method:"POST",
                            data:{
                                operation: "check_phone_numbers",
                                origin_id: origin,
                                numbers: numbers,
                                message: message,
                            }
                        },true,true);

                        request.done(function (res) {
                            if(res){
                                var solve = getJson(res),content;
                                if(solve){
                                    $("#numberList").html('');
                                    if(solve.countries != undefined){
                                        $(solve.countries).each(function(key,item){
                                            content = '<tr id="country_'+item.code+'">';
                                            content += '<td align="left">';
                                            content += '<img src="<?php echo $sadress; ?>assets/images/flags/'+item.code+'.svg" width="20" height="auto">';
                                            content += ''+item.name+'';
                                            content += '</td>';
                                            content += '<td align="center">'+item.count+' <?php echo __("website/account_sms/count"); ?></td>';
                                            content += '<td align="center">'+mSmsC+' SMS</td>';
                                            content += '<td align="center"><strongg>'+item.total_price_symbol+'</strongg></td>';
                                            content += '<td align="center">';

                                            content += '<input checked type="checkbox" name="selected_countries[]" id="checkbox_country_'+item.code+'" class="checkbox-custom" value="'+item.code+'">';
                                            content += '<label class="checkbox-custom-label" for="checkbox_country_'+item.code+'"><?php echo __("website/account_sms/select"); ?></label>';
                                            if(item.prereg_required != undefined && item.prereg_required && item.prereg_status != undefined && item.prereg_status != "approved"){
                                                content += '<a href="javascript:void(0);" data-tooltip="<?php echo __("website/account_sms/preregisterrequirement"); ?>" class="prereg-warning"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></a>';
                                            }

                                            content += '</td>';

                                            content += '</tr>';
                                            $("#numberList").append(content);
                                        });
                                    }

                                    if(solve.unknowns != undefined && solve.total_quantity_nsent){
                                        content = '<tr id="country_unknown">';
                                        content += '<td>';
                                        content += '<i style="font-size: 24px; color: #777; margin-right: 5px;    float: left;" class="fa fa-ban" aria-hidden="true"></i>';
                                        content += '<?php echo __("website/account_sms/unknown-numbers"); ?>';
                                        content += '</td>';
                                        content += '<td   align="center">'+solve.total_quantity_nsent+' <?php echo __("website/account_sms/count"); ?></td>';
                                        content += '<td  colspan="3" align="center"></td>';

                                        content += '</tr>';
                                        $("#numberList").append(content);
                                    }

                                    if(solve.total_quantity_sent != undefined){
                                        if(solve.total_quantity_sent>0){
                                            $("#block_btn").fadeOut(300,function(){
                                                $("#send_btn").fadeIn(300);
                                            });
                                        }else{
                                            $("#send_btn").fadeOut(300,function(){
                                                $("#block_btn").fadeIn(300);
                                            });
                                        }
                                        $("#total_sent_number").html(solve.total_quantity_sent);
                                    }
                                    if(solve.total_quantity_sent_sms != undefined)
                                        $("#total_sent_sms").html(solve.total_quantity_sent_sms);
                                    if(solve.total_price_symbol != undefined)
                                        $("#total_falling_loan_amount").html(solve.total_price_symbol);


                                }else console.log(res);
                            }else
                                console.log(res);
                        });

                        $("#preview #numberList").on("change","input[type='checkbox']",function(){
                            var selectedcs = $("input[name='selected_countries[]']:checked").map(function(){return $(this).val();}).get();
                            if(selectedcs.length == 0){
                                $(this).prop("checked",true);
                                return false;
                            }

                            var request = MioAjax({
                                action:"<?php echo $links["controller"];?>",
                                method:"POST",
                                data:{
                                    operation:"check_phone_numbers",
                                    origin_id:origin,
                                    numbers:numbers,
                                    message: message,
                                    selected_countries:selectedcs
                                }
                            },true,true);

                            request.done(function(resx){
                                if(resx){
                                    var solvex = getJson(resx),content;
                                    if(solvex){


                                        if(solvex.total_quantity_sent != undefined){
                                            if(solvex.total_quantity_sent>0){
                                                $("#block_btn").fadeOut(300,function(){
                                                    $("#send_btn").fadeIn(300);
                                                });
                                            }else{
                                                $("#send_btn").fadeOut(300,function(){
                                                    $("#block_btn").fadeIn(300);
                                                });
                                            }
                                            $("#total_sent_number").html(solvex.total_quantity_sent);
                                        }
                                        if(solvex.total_quantity_sent_sms != undefined)
                                            $("#total_sent_sms").html(solvex.total_quantity_sent_sms);
                                        if(solvex.total_price_symbol != undefined)
                                            $("#total_falling_loan_amount").html(solvex.total_price_symbol);

                                    }else console.log(resx);
                                }else
                                    console.log(resx);
                            });

                        });


                        $("#preview_gMessageLength").html(mcount);
                        $("#preview_MessageCountSMS").html(mSmsC);
                        $("#preview_OriginName").html(origin_text);
                        $("#preview_MessageText").html(message);

                        $("#FormLayout").fadeOut(400,function(){
                            $("html,body").animate({scrollTop:200},600);
                            $("#preview").fadeIn(400);
                        });

                    }

                    function turnBack() {
                        $("#preview").fadeOut(400,function(){
                            $("html,body").animate({scrollTop:200},600);
                            $("#FormLayout").fadeIn(400);
                        });
                    }

                    function countChar(elem) {
                        var value = transliterate($(elem).val());
                        $(elem).val(value);

                        var len = $(elem).val().length;

                        <?php if(isset($dimension) && !empty($last_end)): ?>
                        if (len >= <?php echo $last_end; ?>) {
                            elem.value = elem.value.substring(0, <?php echo $last_end; ?>);
                            $('#charNum').text(<?php echo $last_end; ?>);
                            return true;
                        }
                        <?php endif; ?>

                        $('#charNum').text(len);

                        <?php
                        if(isset($dimension) && $dimensions && is_array($dimensions) && $size){
                            $i = 0;
                            foreach($dimensions AS $dimension){
                                $i+=1;
                                if($i == 1){
                                    echo 'if(len >= '.$dimension["start"].' && len <= '.$dimension["end"].'){'.EOL;
                                    echo '                                    $("#SmsCount").text('.$dimension["part"].');'.EOL;
                                    echo '                                } ';
                                }elseif($i == $size){
                                    echo 'else if(len >= '.$dimension["start"].' && len <= '.$dimension["end"].'){'.EOL;
                                    echo '                                    $("#SmsCount").text('.$dimension["part"].');'.EOL;
                                    echo '                                } else {'.EOL;
                                    echo '                                    $("#SmsCount").text('.$last["part"].');'.EOL;
                                    echo '                                }';
                                }else{
                                    echo 'else if(len >= '.$dimension["start"].' && len <= '.$dimension["end"].'){'.EOL;
                                    echo '                                    $("#SmsCount").text('.$dimension["part"].');'.EOL;
                                    echo '                                } ';
                                }
                            }
                        }
                        ?>

                    }

                    function numbersCount(elem){
                        var value = $(elem).val();
                        if(value != null && value != ''){
                            var exps  = value.split("\n");
                            var nums  = Array();
                            $(exps).each(function(key,item){
                                item = item.substring(0,20);
                                var myregex = 1;
                                if(isNaN(item)) item = item.replace(/[^0-9\+]+/g, '');
                                if(item.substring(0,1) != "+" && item.length >=1) item = "+"+item;
                                if(!in_array([item],nums)) nums.push(item);
                            });
                            var count = nums.length;
                            if(count == 1 && nums[0] == '') count = 0;
                            var numbers = nums.join("\n");
                            $(elem).val(numbers);
                            $("#NumbersCount").html(count);
                        }else{
                            $(elem).val('');
                            $("#NumbersCount").html('0');
                        }
                    }

                    $(document).ready(function(){
                        countChar(document.getElementById("message"));
                        $("#SubmitSMS input[name=groups]").change(function(){
                            var numbers = "";
                            $("#SubmitSMS input[name=groups]:checked").each(function(){
                                var number = getGroup($(this).val()).numbers;
                                if(number && number != ''){
                                    numbers += number.join("\n")+"\n";
                                }
                            });
                            numbers = numbers.rtrim('\n');
                            var elem = $("#SubmitSMS #numbers");
                            elem.val(numbers);
                            numbersCount(elem);
                        });

                        numbersCount($("#SubmitSMS #numbers"));
                        $("#numbers").on("keyup keydown change",function(){
                            numbersCount(this);
                        });

                    });
                </script>


            </div>
        </div>



        <div id="baslikislemleri" class="tabcontent">
            <div class="tabcontentcon">
                <h5 style="margin:20px 0px;">

                    <form id="OriginRequest" action="<?php echo $links["controller"]; ?>" method="post">
                        <input type="hidden" name="operation" value="add_new_origin">

                        <table width="100%" border="0" align="center">
                            <tbody>

                            <tr>
                                <td width="30%"><span class="zorunlu">*</span> <strong><?php echo __("website/account_sms/sender-origin"); ?></strong> </td>
                                <td><input class="notr" name="origin" type="text" placeholder="<?php echo __("website/account_sms/origin-max-character"); ?>" size="11" maxlength="11" style="text-transform:uppercase"></td>
                            </tr>

                            <script type="text/javascript">
                                $(".notr").on("ready load keyup keydown keypress change", function () {
                                    var baslik = $(this).val().substr(0, 11).toUpperCase().replace(/Ö/g, "O").replace(/Ç/g, "C").replace(/Ş/g, "S").replace(/İ/g, "i").replace(/Ğ/g, "G").replace(/Ü/g, "U").replace(/([^a-zA-Z0-9 \.\-_])/g, "");
                                    $(this).val(baslik);
                                    if (baslik.length > 3) {
                                        $("li.baslikkarakter i").removeClass("fa-dot-circle-o").addClass("fa-check");
                                    }else {
                                        $("li.baslikkarakter i").removeClass("fa-check").addClass("fa-dot-circle-o");
                                    }
                                    if (baslik.replace(/([0-9]+)/, "").length != 0) {
                                        $("li.baslikrakam i").removeClass("fa-dot-circle-o").addClass("fa-check");
                                        titleInNumber = false;
                                    }else {
                                        $("li.baslikrakam i").removeClass("fa-check").addClass("fa-dot-circle-o");
                                        titleInNumber = true;
                                    }
                                    $(".total").html(11 - baslik.length);
                                });
                            </script>

                            <tr>
                                <td colspan="2">
                                    <input type="checkbox" class="checkbox-custom" name="origin_legal_acept" value="1" id="ola">
                                    <label class="checkbox-custom-label" for="ola"><?php echo __("website/account_sms/origin-legal-acept"); ?></label>
                                </td>
                            </tr>

                            </tbody></table>

                        <a href="javascript:void(0);" class="yesilbtn gonderbtn mio-ajax-submit" mio-ajax-options='{"result":"OriginRequest_submit","waiting_text":"<?php echo addslashes(__("website/others/button1-pending")); ?>","progress_text":"<?php echo addslashes(__("website/others/button1-upload")); ?>"}'><?php echo __("website/account_sms/origin-request-send-button"); ?></a>

                        <div id="result" class="error" style="text-align: left; margin-top:5px;"></div>
                    </form>
                    <div id="OriginRequest_success" style="display: none;">
                        <div style="margin-top:30px;text-align:center;">
                            <i style="font-size:80px;" class="fa fa-check"></i>
                            <h4><?php echo __("website/account_sms/sent-origin-request"); ?></h4>
                            <br>
                        </div>
                    </div>
                    <script type="text/javascript">
                        function OriginRequest_submit(result) {
                            if(result != ''){
                                var solve = getJson(result);
                                if(solve !== false){
                                    if(solve.status == "error"){
                                        if(solve.for != undefined && solve.for != ''){
                                            $("#OriginRequest "+solve.for).focus();
                                            $("#OriginRequest "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                            $("#OriginRequest "+solve.for).change(function(){
                                                $(this).removeAttr("style");
                                            });
                                        }
                                        if(solve.message != undefined && solve.message != '')
                                            $("#OriginRequest #result").fadeIn(300).html(solve.message);
                                        else
                                            $("#OriginRequest #result").fadeOut(300).html('');
                                    }else if(solve.status == "successful"){
                                        $("#OriginRequest").fadeOut(400,function(){
                                            $("html,body").animate({scrollTop:200},600);
                                            $("#OriginRequest_success").fadeIn(400);
                                            setTimeout(function(){
                                                window.location.href = window.location.href;
                                            },1000);
                                        });
                                    }
                                }else
                                    console.log(result);
                            }

                        }
                    </script>

                    <div class="clear"></div>
                    <div style="margin:40px 0px;" class="line"></div>

                    <h4 style="margin-bottom:7px;    font-size: 18px;"><strong><?php echo __("website/account_sms/current-origins"); ?></strong></h4>

                    <?php if(isset($origins) && is_array($origins) && sizeof($origins)>0): ?>
                        <table class="datatable3" width="100%" border="0">
                            <thead style="background:#ebebeb;">
                            <tr>
                                <th align="left" data-orderable="false" data-visible="false">#</th>
                                <th align="left" data-orderable="false"><?php echo __("website/account_sms/origin-information"); ?></th>
                                <th data-orderable="false" align="center"><?php echo __("website/account_sms/origin-prereg"); ?>
                                    <a style="font-weight:400" href="javascript:void(0);" data-tooltip="<?php echo __("website/account_sms/pregisterinfo"); ?>"><i class="fa fa-question-circle-o" aria-hidden="true"></i></a></th>
                                <!--th> </th-->
                            </tr>
                            </thead>
                            <tbody align="center" style="border-top:none;" id="SenderIDList">
                            <?php
                                $rank = 0;
                                $prereg_data = [];
                                foreach($origins AS $origin){
                                    $rank +=1;
                                    ?>
                                    <tr style="background:none;">
                                        <td><?php echo $rank; ?></td>
                                        <td align="left"><strong><?php echo $origin["name"]; ?></strong></td>
                                        <td align="center">
                                            <a href="javascript:void(0);" onclick="addPreRegisterCountry(<?php echo $origin["id"]; ?>,'<?php echo $origin["name"]; ?>');" class="lbtn"><?php echo __("website/account_sms/add-prereg-button"); ?></a>
                                            <?php
                                                if(isset($origin["prereg"]) && $origin["prereg"]){
                                                    $prereg_data[$origin["id"]] = $origin["prereg"];
                                                    ?>
                                                    <script type="text/javascript">
                                                        $(document).ready(function(){
                                                            $("#prereg_<?php echo $origin["id"]; ?>").iziModal({
                                                                title:'<?php echo __("website/account_sms/prereg-modal-title",['{title}' => $origin["name"]]); ?>',
                                                                zindex: 99999,
                                                                closeButton:true
                                                            });
                                                        });
                                                    </script>
                                                    <a href="#prereg_<?php echo $origin["id"]; ?>" class="lbtn prereg-trigger"><?php echo __("website/account_sms/preregister-detail"); ?></a><?php

                                                }
                                            ?>
                                        </td>
                                        <!--td><a href="javascript:void(0);" class="lbtn" onclick="deleteOrigin(<?php echo $origin["id"]; ?>);"><i class="fa fa-trash-o"></i></a></td-->
                                    </tr>
                                    <?php
                                }
                            ?>
                            </tbody>
                        </table>

                        <script type="text/javascript">
                            function deleteOrigin(id){

                                swal({
                                    title: '<?php echo __("website/account_sms/delete-origin-modal-title"); ?>',
                                    text: "<?php echo __("website/account_sms/delete-origin-modal-desc"); ?>",
                                    type: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: '<?php echo __("website/account_sms/delete-origin-modal-ok"); ?>',
                                    cancelButtonText: '<?php echo __("website/account_sms/delete-origin-modal-no"); ?>'
                                }).then(function(){

                                    var request = MioAjax({
                                        action:"<?php echo $links["controller"];?>",
                                        method:"POST",
                                        data:{operation:"delete_origin",id:id}
                                    },true,true);

                                    request.done(function(res){
                                        if(res != ''){
                                            var solve = getJson(res);
                                            if(solve && typeof solve == "object"){
                                                if(solve.status == "error"){
                                                    swal({
                                                        title: '<?php echo __("website/account_sms/delete-origin-modal-error") ?>',
                                                        text: solve.message,
                                                        type: 'error',
                                                        showConfirmButton: false,
                                                        timer: 3000,
                                                    });
                                                }else if(solve.status == "successful"){
                                                    var timer = 1500;
                                                    setTimeout(function(){
                                                        var link = sGET("tab","origins");
                                                        window.location.href = link;
                                                    },timer);
                                                    swal({
                                                        title: '<?php echo __("website/account_sms/delete-origin-modal-deleted") ?>',
                                                        text: '<?php echo __("website/account_sms/delete-origin-modal-successful"); ?>',
                                                        type: 'success',
                                                        showConfirmButton: false,
                                                        timer: timer,
                                                    });
                                                }
                                            }else
                                                console.log(res);
                                        }
                                    });

                                });

                            }
                        </script>

                    <?php else: ?>
                        <div style="text-align:center;">
                            <i style="font-size:84px;" class="fa fa-info-circle" aria-hidden="true"></i><br><br>
                            <strong><?php echo __("website/account_sms/no-origins"); ?></strong></div>
                    <?php endif; ?>


            </div>
        </div>



        <div id="rehber" class="tabcontent">
            <div class="tabcontentcon">
                <h5 style="margin:20px 0px;">


                    <div id="accordion" style="margin-top:25px;">

                        <h3><?php echo __("website/account_sms/add-new-sms-group"); ?></h3>
                        <div>
                            <form action="<?php echo $links["controller"]; ?>" method="post" id="addNewGroup">
                                <input type="hidden" name="operation" value="add_new_group">
                                <label style="float:left;" class="yuzde25"><strong><?php echo __("website/account_sms/new-sms-group-name"); ?>:</strong></label>
                                <div class="yuzde75">
                                    <input name="name" type="text" placeholder="<?php echo __("website/account_sms/new-sms-group-name-placeholder"); ?>">
                                    <a style="float:right;width:200px;" class="mavibtn gonderbtn mio-ajax-submit" mio-ajax-options='{"result":"addNewGroup_submit"}' href="javascript:void(0);"><?php echo __("website/account_sms/add-sms-group-button"); ?></a>
                                </div>
                                <div class="clear"></div>
                                <div id="result" style="display: none; text-align: center; margin-top:5px;" class="error"></div>
                            </form>
                            <div id="addNewGroup_success" style="display: none;">
                                <div style="margin-top:30px;text-align:center;">
                                    <i style="font-size:80px;color:green;" class="fa fa-check"></i>
                                    <h4 style="color:green;font-weight:bold;"><?php echo __("website/account_sms/added-sms-group"); ?></h4>
                                    <br>
                                </div>
                            </div>
                            <script type="text/javascript">
                                function addNewGroup_submit(result) {
                                    if(result != ''){
                                        var solve = getJson(result);
                                        if(solve !== false){
                                            if(solve.status == "error"){
                                                if(solve.for != undefined && solve.for != ''){
                                                    $("#addNewGroup "+solve.for).focus();
                                                    $("#addNewGroup "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                                    $("#addNewGroup "+solve.for).change(function(){
                                                        $(this).removeAttr("style");
                                                    });
                                                }
                                                if(solve.message != undefined && solve.message != '')
                                                    $("#addNewGroup #result").fadeIn(300).html(solve.message);
                                                else
                                                    $("#addNewGroup #result").fadeOut(300).html('');
                                            }else if(solve.status == "successful"){
                                                $("#addNewGroup").fadeOut(200,function(){
                                                    $("#addNewGroup_success").fadeIn(100);
                                                    setTimeout(function(){
                                                        var link = sGET("accordion",2);
                                                        window.location.href = link;
                                                    },1000);
                                                });
                                            }
                                        }else
                                            console.log(result);
                                    }
                                }
                            </script>

                        </div>

                        <h3><?php echo __("website/account_sms/group-management"); ?></h3>
                        <div>

                            <form id="ChangeGroupNumbers" action="<?php echo $links["controller"]; ?>" method="post">
                                <input type="hidden" name="operation" value="change_group_numbers">

                                <?php if(isset($groups) && is_array($groups) && sizeof($groups)>0){
                                    ?>
                                    <label style="float:left;" class="yuzde25"><strong><?php echo __("website/account_sms/select-group"); ?></strong></label>
                                    <div style="float:right;" class="yuzde75">
                                        <?php
                                            if(isset($groups) && is_array($groups) && sizeof($groups)>0){
                                                foreach ($groups AS $group){
                                                    $count = sizeof($group["numbers"]);
                                                    ?>
                                                    <input id="group-<?php echo $group["id"]; ?>" class="checkbox-custom" name="group" value="<?php echo $group["id"]; ?>" type="radio" >
                                                    <label for="group-<?php echo $group["id"]; ?>" class="checkbox-custom-label"><span class="checktext"><?php echo $group["name"]; ?> <strong id="group_count_<?php echo $group["id"]; ?>">(<?php echo $count; ?>)</strong></span></label>
                                                    <?php
                                                }
                                            }
                                        ?>
                                    </div>
                                    <?php
                                }else{
                                    ?>
                                    <div class="error" style=""><?php echo __("website/account_sms/sms-group-none"); ?></div>
                                    <?php
                                }
                                ?>

                                <div id="if_selected" style="display: none">
                                    <div class="line"></div>
                                    <div class="clear"></div>

                                    <label><strong><?php echo __("website/account_sms/group-number-add-or-delete"); ?></strong>
                                        <textarea disabled name="numbers" cols="" rows="" placeholder="<?php echo __("website/account_sms/group-numbers-placeholder"); ?>"></textarea></label>


                                    <a style="float:right;width:200px;" class="mavibtn gonderbtn mio-ajax-submit" mio-ajax-options='{"result":"ChangeGroupNumbers_submit"}' href="javascript:void(0);"><?php echo __("website/account_sms/change-group-button"); ?></a>
                                    <div id="result" class="yuzde100 error" style="text-align:center; margin-top:5px;display:none;"></div>
                                    <a style="float:left;width:200px;" class="redbtn gonderbtn" href="javascript:void(0);" id="deleteGroup"><?php echo __("website/account_sms/delete-group-button"); ?></a>

                                </div>

                            </form>
                            <div id="ChangeGroupNumbers_success" style="display: none;">
                                <div style="margin-top:30px;text-align:center;">
                                    <i style="font-size:80px;color:green;" class="fa fa-check"></i>
                                    <h4 style="color:green;font-weight:bold;"><?php echo __("website/account_sms/changed-group-numbers"); ?></h4>
                                    <br>
                                </div>
                            </div>
                            <script type="text/javascript">
                                var groups = getJson('<?php echo isset($groups) ? Utility::jencode($groups) : NULL; ?>');
                                function getGroup(id) {
                                    var found=false;
                                    $(groups).each(function(key,item){
                                        if(item.id == id) found = item;
                                    });
                                    return found;
                                }
                                function ChangeGroupNumbers_submit(result) {
                                    if(result != ''){
                                        var solve = getJson(result);
                                        if(solve !== false){
                                            if(solve.status == "error"){
                                                if(solve.for != undefined && solve.for != ''){
                                                    $("#ChangeGroupNumbers "+solve.for).focus();
                                                    $("#ChangeGroupNumbers "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                                    $("#ChangeGroupNumbers "+solve.for).change(function(){
                                                        $(this).removeAttr("style");
                                                    });
                                                }
                                                if(solve.message != undefined && solve.message != '')
                                                    $("#ChangeGroupNumbers #result").fadeIn(300).html(solve.message);
                                                else
                                                    $("#ChangeGroupNumbers #result").fadeOut(300).html('');
                                            }else if(solve.status == "successful"){
                                                $("#ChangeGroupNumbers").fadeOut(200,function(){
                                                    $("#ChangeGroupNumbers_success").fadeIn(100);
                                                    setTimeout(function(){
                                                        var link = sGET("accordion","2");
                                                        window.location.href = link;
                                                    },800);
                                                });
                                            }
                                        }else
                                            console.log(result);
                                    }
                                }

                                $(document).ready(function(){

                                    $("#deleteGroup").click(function(){


                                        swal({
                                            title: '<?php echo __("website/account_sms/delete-group-modal-title"); ?>',
                                            text: "<?php echo __("website/account_sms/delete-group-modal-desc"); ?>",
                                            type: 'warning',
                                            showCancelButton: true,
                                            confirmButtonColor: '#3085d6',
                                            cancelButtonColor: '#d33',
                                            confirmButtonText: '<?php echo __("website/account_sms/delete-group-modal-ok"); ?>',
                                            cancelButtonText: '<?php echo __("website/account_sms/delete-group-modal-no"); ?>'
                                        }).then(function(){

                                            var group_id = $("input[name=group]:checked").val();
                                            var request = MioAjax({
                                                action:"<?php echo $links["controller"];?>",
                                                method:"POST",
                                                data:{operation:"delete_group",id:group_id}
                                            },true);

                                            request.done(function(res){
                                                if(res != ''){
                                                    var solve = getJson(res);
                                                    if(solve && typeof solve == "object"){
                                                        if(solve.status == "error"){
                                                            swal({
                                                                title: '<?php echo __("website/account_sms/delete-group-modal-error") ?>',
                                                                text: solve.message,
                                                                type: 'error',
                                                                showConfirmButton: false,
                                                                timer: 3000,
                                                            });
                                                        }else if(solve.status == "successful"){
                                                            var timer = 1500;
                                                            setTimeout(function(){
                                                                var link = sGET("accordion",2);
                                                                window.location.href = link;
                                                            },timer);
                                                            swal({
                                                                title: '<?php echo __("website/account_sms/delete-group-modal-deleted") ?>',
                                                                text: '<?php echo __("website/account_sms/delete-group-modal-successful"); ?>',
                                                                type: 'success',
                                                                showConfirmButton: false,
                                                                timer: timer,
                                                            });
                                                        }
                                                    }else
                                                        console.log(res);
                                                }
                                            });


                                        });



                                    });

                                    $("input[name=group]").change(function(){
                                        var id = $(this).val();
                                        var group = getGroup(id);
                                        if(group){
                                            var numbers = group.numbers;
                                            if(numbers.length>0){
                                                numbers = numbers.join("\n");
                                            }
                                            $("#if_selected").fadeIn(250);
                                            $("#if_selected textarea").removeAttr("disabled").html(numbers);
                                        }
                                    });
                                });
                            </script>
                            <div class="clear"></div>

                        </div>


                    </div>
            </div>
        </div>



        <div id="raporlar" class="tabcontent">

            <script type="text/javascript">
                function showMessage(id){
                    open_modal('showMessage');
                    $("#showText").html($("#show_message_"+id).html());
                }
            </script>

            <div style="display: none;" id="showMessage" data-izimodal-title="<?php echo __("website/account_sms/report-message-content"); ?>">
                <div class="padding20" id="showText">

                </div>
            </div>

            <?php if(isset($reports) && is_array($reports) && $reports): ?>
                <div>
                    <script type="text/javascript">
                        $(document).ready(function(){
                            $('#reports').DataTable({
                                "columnDefs": [
                                    {
                                        "targets": [0],
                                        visible:false,
                                        "orderable": false,
                                        "searchable": false
                                    }

                                ],
                                responsive: true,
                                "language":{
                                    "url":"<?php echo APP_URI."/".___("package/code")."/datatable/lang.json";?>"
                                }
                            });

                        });
                    </script>
                    <table id="reports" width="100%">
                        <thead style="background:#ebebeb;">
                        <tr>
                            <th align="left">#</th>
                            <th align="center"><?php echo __("website/account_sms/reports-table-field1"); ?></th>
                            <th align="center"><?php echo __("website/account_sms/reports-table-field2"); ?></th>
                            <th align="center"><?php echo __("website/account_sms/reports-table-field4"); ?></th>
                            <th align="center"><?php echo __("website/account_sms/reports-table-field3"); ?></th>
                            <th align="center"><?php echo __("website/account_sms/reports-table-field5"); ?></th>
                            <th align="left"><?php echo __("website/account_sms/reports-table-field6"); ?></th>
                            <th align="center"><?php echo __("website/account_sms/reports-table-field7"); ?></th>
                        </tr>
                        </thead>

                        <tbody align="center" style="border-top:none;">
                        <?php
                            Money::$digit=4;
                            $rank=0;
                            foreach($reports AS $report){
                                $rank++;
                                ?>
                                <tr>
                                    <td align="left"><?php echo $rank; ?></td>
                                    <td align="center"><?php echo $report["ctime"]; ?></td>
                                    <td align="center"><?php echo $report["title"]; ?></td>
                                    <td align="center">
                                        <p style="display: none" id="show_message_<?php echo $report["id"]; ?>">
                                            <?php echo $report["content"]; ?>
                                        </p>
                                        <a class="lbtn" href="javascript:showMessage(<?php echo $report["id"]; ?>);void 0;"><?php echo __("website/account_sms/report-message-content"); ?></a><br>
                                        (<?php echo $report["data"]["part"]; ?> SMS - <?php echo $report["data"]["length"]; ?> <?php echo __("website/account_sms/dimension-character"); ?>)
                                    </td>
                                    <td align="center"><?php echo isset($report["data"]["count"]) ? $report["data"]["count"] : __("website/others/none"); ?></td>
                                    <td align="center">
                                        <?php echo Money::formatter_symbol($report["data"]["total_credit"],$report["data"]["credit_cid"]); ?>
                                    </td>
                                    <td align="left">
                                        <?php
                                            if(isset($report["data"]["countries"]) && $report["data"]["countries"]){
                                                foreach($report["data"]["countries"] AS $country){
                                                    ?>
                                                    <img src="<?php echo $sadress; ?>assets/images/flags/<?php echo $country["code"]; ?>.svg" width="20" style="float: left;"> (<?php echo $country["total_part"]; ?> SMS - <?php echo Money::formatter_symbol($country["total_price"],$report["data"]["credit_cid"]); ?>)<br>
                                                    <?php
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td align="center">

                                        <a href="javascript:getReportDetail(<?php echo $report["id"]; ?>);void 0;" class="lbtn"><i class="fa fa-search"></i></a>

                                    </td>
                                </tr>
                                <?php
                            }
                        ?>

                        </tbody>
                    </table>
                </div>

            <?php else: ?>
                <div style="text-align:center;margin:40px;">	<i style="font-size:84px;" class="fa fa-info-circle" aria-hidden="true"></i><br><br>
                    <?php echo __("website/account_sms/no-reports"); ?></div>
            <?php endif; ?>

            <div class="clear"></div>
        </div>

    </div>
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('click', '.prereg-trigger', function(event) {
            event.preventDefault();
            $($(this).attr("href")).iziModal('open');
        });
    });
</script>
<?php
    if(isset($prereg_data) && $prereg_data){
        foreach($prereg_data AS $key=>$registers){
            ?>
            <div id="prereg_<?php echo $key; ?>" style="display: none;">
                <div class="padding20">
                    <table width="100%" border="0">
                        <thead style="background:#ebebeb;">
                        <tr>
                            <th align="center"><?php echo __("website/account_sms/prereg-table-country"); ?></th>
                            <th align="center"><?php echo __("website/account_sms/prereg-table-status"); ?></th>
                            <th align="center"><?php echo __("website/account_sms/prereg-table-description"); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            foreach($registers AS $reg){
                                ?>
                                <tr>
                                    <td align="center"><?php echo $reg["cname"]; ?></td>
                                    <td align="center"><?php echo $origin_prereg_situations[$reg["status"]]; ?></td>
                                    <td align="center"><?php echo $reg["status_msg"]; ?></td>
                                </tr>
                                <?php
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php
        }
    }
?>
<div id="addPreRegisterCountry" style="display: none;">
    <div class="padding20">
        <form action="<?php echo $links["controller"]; ?>" method="post" id="addNewPreRegisterCountry" enctype="multipart/form-data">
            <input type="hidden" name="operation" value="add_new_pre_register_country">
            <input type="hidden" name="origin_id" value="" id="add_origin_id">

            <table width="100%" border="0" align="center">
                <tbody>

                <tr>
                    <td colspan="2" id="pre-register-countries"></td>
                </tr>


                <tr>
                    <td width="30%"><span class="zorunlu">*</span> <strong><?php echo __("website/account_products/origin-documents"); ?>:</strong></td>
                    <td><input style="font-size:15px;" name="attachments[]" type="file" multiple>
                        <span style="font-size:14px; color:green"><?php echo __("website/account_sms/origin-document-desc"); ?></span>
                    </td>
                </tr>


                </tbody>
            </table>

            <a href="javascript:void(0);" onclick="addPreRegisterButton(this);" class="yesilbtn gonderbtn"><?php echo __("website/account_sms/origin-prereg-add-button"); ?></a>
            <script type="text/javascript">
                function addPreRegisterButton(element){
                    MioAjaxElement(
                        element,
                        {
                            result:"addNewPreRegisterCountry_submit",
                            waiting_text:"<?php echo addslashes(__("website/others/button1-pending")); ?>",
                            progress_text:"<?php echo addslashes(__("website/others/button1-upload")); ?>"
                        });
                }
            </script>

            <div id="result" class="error" style="text-align: center; margin-top:5px;"></div>
        </form>
    </div>
    <div class="clear"></div><br>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        setTimeout(function(){
            var request = MioAjax({
                action:"<?php echo $links["controller"];?>",
                method:"POST",
                data:{operation:"get_pre_register_countries"}
            },true,true);

            request.success(function (res) {
                if(res != ''){
                    var solve = getJson(res),content;
                    if(solve && typeof solve == "object" && solve.data != undefined){
                        $("#pre-register-countries").html('');
                        $(solve.data).each(function(key,item){
                            content = '<input type="checkbox" class="checkbox-custom" name="countries[]" value="'+item.code+'" id="country-'+item.id+'">';
                            content += '<label class="checkbox-custom-label" for="country-'+item.id+'">'+item.name+'</label>';
                            $("#pre-register-countries").append(content);
                        });
                    }else
                        console.log(res);
                }
            });

        },1000);

        $("#addPreRegisterCountry").iziModal({
            title:"<?php echo str_replace(EOL,"",__("website/account_sms/add-new-prereg-header-title")); ?>",
            zindex: 99999,
            closeButton:true,
        });
    });

    function addPreRegisterCountry(origin_id,title){
        $("#add_origin_id").val(origin_id);
        $("#ModalOriginName").html(title);
        $("#addPreRegisterCountry").iziModal('open');

    }
    function addNewPreRegisterCountry_submit(result) {
        if(result != ''){
            var solve = getJson(result);
            if(solve !== false){
                if(solve.status == "error"){
                    if(solve.for != undefined && solve.for != ''){
                        $("#addNewPreRegisterCountry "+solve.for).focus();
                        $("#addNewPreRegisterCountry "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                        $("#addNewPreRegisterCountry "+solve.for).change(function(){
                            $(this).removeAttr("style");
                        });
                    }
                    if(solve.message != undefined && solve.message != '')
                        $("#addNewPreRegisterCountry #result").fadeIn(300).html(solve.message);
                    else
                        $("#addNewPreRegisterCountry #result").fadeOut(300).html('');
                }else if(solve.status == "successful"){
                    window.location.href = "<?php echo $links["controller"]; ?>?tab=origins";
                }
            }else
                console.log(result);
        }

    }
</script>
<div id="loading-container" style="display: none;">
    <div align="center">
        <h4><img src="<?php echo $sadress; ?>assets/images/loading.gif"><br><?php echo __("website/account_sms/loading-report-data"); ?></h4>
    </div>
</div>
<div id="getReport" style="display: none;" data-izimodal-title="<?php echo __("website/account_sms/status-report"); ?>">
    <div class="padding20">

    </div>
</div>
<div id="ReportTemplate" style="display:none;">
    <div class="durumraportable">
        <table width="100%" border="0" align="center">
            <thead>
            <tr>
                <th width="33%" align="center" bgcolor="#D6FE81" style="color:#4B7001"><strong><?php echo __("website/account_sms/report-delivered"); ?> ({delivered_count})</strong></td>
                <th width="33%" align="center" bgcolor="#C6FFFF" style="color:#009393"><strong><?php echo __("website/account_sms/report-expect"); ?> ({expect_count})</strong></td>
                <th width="33%" align="center" bgcolor="#FFCACA" style="color:#970000"><strong><?php echo __("website/account_sms/report-incorrect"); ?> ({incorrect_count})</strong></td>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td width="33%" align="center" style="color:#689A01;padding:0px">{conducted_number}</td>
                <td width="33%" align="center" style="color:#009393;padding:0px">{waiting_number}</td>
                <td width="33%" align="center" style="color:#AE0000;padding:0px">{erroneous_number}</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    function getReportDetail(id) {
        $("#getReport .padding20").html($("#loading-container").html());

        open_modal('getReport');

        var data = MioAjax({
            action: "<?php echo $links["controller"]; ?>",
            method: "POST",
            data:{
                operation:"get_sms_report",
                id:id,
            },
        },true,true);

        data.success(function(result){
            if(result != ''){
                var solve = getJson(result);
                if(solve !== false){
                    if(solve.status == "successful"){
                        var template = $("#ReportTemplate").html();


                        template = template.replace("{delivered_count}",solve.conducted_count);
                        template = template.replace("{expect_count}",solve.waiting_count);
                        template = template.replace("{incorrect_count}",solve.erroneous_count);
                        var item = $("tbody",template).html(),content,contents = '';
                        $(solve.items).each(function(k,v){
                            content = item;
                            content = content.replace("{conducted_number}",v.conducted);
                            content = content.replace("{waiting_number}",v.waiting);
                            content = content.replace("{erroneous_number}",v.erroneous);
                            contents += content;
                        });

                        template = $(template);
                        $("tbody",template).html(contents);

                        $("#getReport .padding20").html(template);
                    }
                }else
                    console.log(result);
            }else
                console.log("result is empty");
        });
    }
</script>