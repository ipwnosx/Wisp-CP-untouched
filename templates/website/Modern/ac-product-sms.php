<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    $wide_content   = true;

    $support_api    = Config::get("options/sms-api-service");

    $cancel_link_text = "";
    if(isset($options["config"]["show_cancel_link"]) && $options["config"]["show_cancel_link"]){
        $cancel_link_text = "\n\n".$cancel_text." ";
    }

    include $tpath."common-needs.php";
    $hoptions = ["datatables","jquery-ui","counterup","iziModal"];

?>
<style type="text/css"></style>
<script type="text/javascript">
    function openTab(evt, tabName) {
        var rank,link,tab;
        $(".tabcontent").css("display","none");
        $(".tablinks").removeClass("active");
        $("#"+tabName).css("display","block");
        $(evt).addClass("active");
        rank     = $(evt).attr("data-rank");
        link     = window.location.href;
        tab      = gGET("tab");
        if(tab || (!tab && rank >1)){
            link = sGET("tab",rank);
        }
        window.history.pushState("object or string", $("title").html(),link);
    }

    $(document).ready(function(){
        var tab = gGET("tab");
        if(tab == '' || tab == undefined){
            var tab_eq = 0;
            $(".tablinks:eq("+tab_eq+")").click();
        }else{
            var tab_eq = tab-1;
            $(".tablinks").removeAttr("id");
            $(".tablinks:eq("+tab_eq+")").click();
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
    });

    $(document).ready(function(){

        setTimeout(function(){
            var result = MioAjax({
                action: "<?php echo $links["controller"]; ?>",
                method: "POST",
                data: {operation:"get_credit"}
            },true,true);

            result.success(function(res){
                if(res && res != ''){
                    solve = getJson(res);
                    if(solve && typeof solve == "object"){
                        if(solve.status == "successful")
                            $("#getCredit").html(solve.balance).counterUp({delay: 10,time:3000});
                        else
                            console.log(solve.message);
                    }
                }
            });
        },500);

        $("#show_cancel_link").change(function(){
            var value = $("#show_cancel_link:checked").val();
            var stat  = 0;
            if(value == undefined){
                $("#cancel_link").fadeOut(300);
                stat = 0;
            }else{
                stat = 1;
                $("#cancel_link").fadeIn(300);
            }

            var result = MioAjax({
                action: "<?php echo $links["controller"]; ?>",
                method: "POST",
                data: {operation:"update_cancel_link",status:stat}
            },true,true);

            result.success(function(res){
                if(res && res != ''){
                    solve = getJson(res);
                    if(solve && typeof solve == "object")
                        if(solve.status != "successful") console.log(solve.message);
                }
            });

        });

    });
</script>
<div class="mpanelrightcon">

    <div class="mpaneltitle">
        <div class="sayfayolu"><?php include $tpath."inc".DS."panel-breadcrumb.php"; ?></div>
        <h4><strong><i class="fa fa-globe" aria-hidden="true"></i> <?php echo $proanse["name"]; ?></strong></h4>
    </div>


    <ul class="tab">
        <li><a href="javascript:void(0)" class="tablinks" onclick="openTab(this, 'ozet')" data-rank="1"><i class="fa fa-info" aria-hidden="true"></i> <?php echo __("website/account_products/tab-detail"); ?></a></li>
        <li><a href="javascript:void(0)" class="tablinks" onclick="openTab(this, 'smsgonder')" data-rank="2"><i class="fa fa-paper-plane-o" aria-hidden="true"></i> <?php echo __("website/account_products/tab-send"); ?></a></li>
        <li><a href="javascript:void(0)" class="tablinks" onclick="openTab(this, 'baslikislemleri')" data-rank="3"><i class="fa fa-id-card-o" aria-hidden="true"></i> <?php echo __("website/account_products/tab-origins"); ?></a></li>
        <li><a href="javascript:void(0)" class="tablinks" onclick="openTab(this, 'rehber')" data-rank="4"><i class="fa fa-address-book-o" aria-hidden="true"></i> <?php echo __("website/account_products/tab-contact"); ?></a></li>
        <li><a href="javascript:void(0)" class="tablinks" onclick="openTab(this, 'raporlar')" data-rank="5"><i class="fa fa-bar-chart" aria-hidden="true"></i> <?php echo __("website/account_products/tab-reports"); ?></a></li>

        <?php if($proanse["status"] == "active" && $ctoc_service_transfer): ?>
            <li><a href="javascript:void(0)" class="tablinks" onclick="openTab(this, 'transfer-service')" data-rank="6"><i class="fa fa-exchange" aria-hidden="true"></i> <?php echo __("website/account_products/transfer-service"); ?></a></li>
        <?php endif; ?>

        <div class="orderidno"><span><?php echo __("website/account_products/table-ordernum"); ?></span><strong>#<?php echo $proanse["id"]; ?></strong></div>
    </ul>


    <div id="ozet" class="smshzmblok tabcontent">

        <div class="hizmetblok" style="border:none;min-height: 250px;<?php echo $support_api ? '' : ' width:48%;'; ?>">
            <div class="service-first-block" style="    min-height: auto;">
                 <div id="order_image" style="display: inline-block;margin-right: 32px;">
                        <img style="width:110px;" src="<?php echo $tadress."images/smscover.svg"; ?>" width="auto" height="auto">
                    </div>
                    <div style="display: inline-block;vertical-align: top;margin-top: 16px;">
                <h4 style="    font-size: 24px;"><strong><?php echo $proanse["name"]; ?></strong></h4>
                <h4 style="margin-bottom:10px;"><?php echo __("website/account_products/current-credit"); ?>: <strong id="getCredit"><i class="fa fa-spinner" style="font-size:20px; -webkit-animation:fa-spin 2s infinite linear;animation: fa-spin 2s infinite linear;"></i></strong></h4>
                </div>
                <?php if($proanse["status"] == "active" && (!isset($proanse["disable_renewal"]) || !$proanse["disable_renewal"]) && (!isset($proanse["options"]["disable_renewal"]) || !$proanse["options"]["disable_renewal"])){ ?>
                    <div id="credit_list" style="display:none;">
                        <select id="selection_credit">
                            <option value=""><?php echo __("website/account_products/renewal-credit-list-option"); ?></option>
                            <?php
                                if(isset($credit_list) && $credit_list){
                                    foreach($credit_list AS $item){
                                        ?>
                                        <option value="<?php echo $item["id"]; ?>"><?php echo $item["title"]; ?> (<?php echo Money::formatter_symbol($item["price"]["amount"],$item["price"]["cid"],true); ?>)</option>
                                        <?php
                                    }
                                }
                            ?>
                        </select>
                        <script type="text/javascript">
                            $(document).ready(function(){
                                $("#selection_credit").change(function(){
                                    var selection = $(this).val();
                                    if(selection != ''){
                                        var result = MioAjax({
                                            action: "<?php echo $links["controller"]; ?>",
                                            method: "POST",
                                            data:{operation:"sms_credit_renewal",pid:selection}
                                        },true,true);

                                        result.success(function (res) {
                                            if(res){
                                                var solve = getJson(res);
                                                if(solve){
                                                    if(solve.status == "successful"){
                                                        window.location.href = solve.redirect;
                                                    }
                                                }
                                            }
                                        });
                                    }
                                });
                            });
                        </script>
                    </div>
                    <div id="order-service-detail-btns" style="margin-top:15px;">

                        <a href="javascript:$('a[data-rank=2]').click();void 0;" class="yesilbtn gonderbtn"><i class="fa fa-paper-plane-o" aria-hidden="true"></i> <?php echo __("website/account_products/tab-send"); ?></a>

                    <a href="javascript:$('#credit_list').slideToggle(400);void 0;" class="mavibtn gonderbtn"><i class="fa fa-refresh"></i> <?php echo __("website/account_products/add-credit"); ?></a>

                    

                <?php }else{ ?>
                    <a class="graybtn gonderbtn" style="cursor:no-drop;"><?php echo __("website/account_products/add-credit"); ?></a>
                <?php } ?>
                </div>
            </div>
        </div>

        <div class="hizmetblok" style="<?php echo $support_api ? '' : 'width:48%;' ?>">
            <table width="100%" border="0">
                <tr>
                    <td colspan="2" bgcolor="#ebebeb">
                        <strong style="float: left;"><?php echo __("website/account_products/general-info"); ?></strong>
                        <?php
                            if(isset($invoice) && $invoice)
                            {
                                ?>
                                <span style="float:right;"><?php echo __("website/account_invoices/invoice-num"); ?> <a href="<?php echo $invoice["detail_link"]; ?>" target="_blank"><strong><?php echo $invoice["number"] ? $invoice["number"] : "#".$invoice["id"]; ?></strong></a></span>
                                <?php
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><strong><?php echo __("website/account_products/service-group"); ?></strong></td>
                    <td><?php echo $proanse["options"]["group_name"]; ?></td>
                </tr>
                <tr>
                    <td><strong><?php echo __("website/account_products/service-name"); ?></strong></td>
                    <td><?php echo $proanse["name"]; ?></td>
                </tr>
                <tr>
                    <td><strong><?php echo __("website/account_products/service-status"); ?></strong></td>
                    <td><?php echo $product_situations[$proanse["status"]]; ?></td>
                </tr>
                <tr>
                    <td><strong><?php echo __("website/account_products/purchase-date"); ?></strong></td>
                    <td><?php echo DateManager::format(Config::get("options/date-format"),$proanse["cdate"]); ?></td>
                </tr>
                </tr>
                <tr align="center" class="tutartd">
                    <td colspan="2"><strong><?php echo __("website/account_products/amount"); ?> : <?php echo $amount; ?></strong></td>
                </tr>
            </table>
        </div>

        <?php if($support_api): ?>
            <div class="hizmetblok">
                <table width="100%" border="0">
                    <tr>
                        <td colspan="2" bgcolor="#ebebeb" ><strong><?php echo __("website/account_products/api-informations"); ?></strong> <a href="#!"  data-tooltip="<?php echo htmlentities(__("website/account_sms/api-informations-description"),ENT_QUOTES); ?>" data-balloon-pos="up"><i class="fa fa-info-circle" aria-hidden="true"></i></a></td>
                    </tr>

                    <tr>
                        <td><strong><?php echo __("website/account_products/api-address"); ?></strong></td>
                        <td><a href="<?php echo $links["api_link"]; ?>" target="_blank"><?php echo $links["api_link"]; ?></a></td>
                    </tr>

                    <?php
                        if(isset($secret_key)){
                            ?>
                            <tr>
                                <td><strong>Secret Key</strong></td>
                                <td><?php echo $secret_key; ?></td>
                            </tr>
                            <?php
                        }
                    ?>

                    <tr>
                        <td><strong><?php echo __("website/account_products/show-cancel-link"); ?></strong></td>
                        <td>
                            <input id="show_cancel_link" class="checkbox-custom" name="show_cancel_link" value="1"<?php echo isset($options["config"]["show_cancel_link"]) && $options["config"]["show_cancel_link"] ? " checked" : '' ?> type="checkbox" style="float:left;width:20px;">
                            <label for="show_cancel_link" class="checkbox-custom-label" style="float:left;"><span id="cancel_link"<?php echo !isset($options["config"]["show_cancel_link"]) || !$options["config"]["show_cancel_link"] ? ' style="display:none"' : ''; ?>><a href="<?php echo $links["cancel_link"]; ?>" target="_blank"><?php echo $links["cancel_link"]; ?></a></span></label></td>
                    </tr>
                </table>

            </div>
        <?php endif; ?>


        <div class="hizmetblok">
            <table width="100%" border="0">
                <tr>
                    <td colspan="2" bgcolor="#ebebeb"><strong>Kimlik Bilgileri</strong></td>
                </tr>

                <tr>
                    <td><strong>Adı Soyadı</strong></td>
                    <td><?php echo isset($options["name"]) ? $options["name"] : ''; ?></td>
                </tr>

                <tr>
                    <td><strong>Doğum Tarihi</strong></td>
                    <td><?php echo isset($options["birthday"]) ? DateManager::format(Config::get("options/date-format"),$options["birthday"]) : ''; ?></td>
                </tr>

                <tr>
                    <td><strong>T.C Kimlik No</strong></td>
                    <td><?php echo isset($options["identity"]) ? $options["identity"] : ''; ?></td>
                </tr>
            </table>

        </div>


    </div>
    <div id="smsgonder" class="tabcontent">
        <div class="tabcontentcon">
            <br><br>

            <form id="SubmitSMS" action="<?php echo $links["controller"]; ?>" method="post">
                <input type="hidden" name="operation" value="submit_sms">

                <div id="FormLayout">


                    <label class="yuzde25"><strong><?php echo __("website/account_products/select-origin"); ?>:</strong></label>
                    <select class="yuzde25" name="origin" >
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
                    <a class="lbtn" href="javascript:$('a[data-rank=3]').click();void 0;"><?php echo __("website/account_products/add-new-origin"); ?></a>
                    <div class="clear"></div><br>

                    <?php if(isset($groups) && is_array($groups) && sizeof($groups)>0): ?>
                        <label class="yuzde25"><strong><?php echo __("website/account_products/select-group"); ?></strong></label>
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
                        <label><strong><?php echo __("website/account_products/message-text"); ?></strong> (<span id="charNum">0</span> <?php echo __("website/account_products/dimension-character"); ?> - <span id="Credit">1</span> <?php echo __("website/account_products/dimension-credit"); ?>)</label>
                        <textarea rows="6" onkeyup="countChar(this);" name="message" id="message" placeholder="<?php echo __("website/account_products/message-placeholder"); ?>"><?php echo $cancel_link_text; ?></textarea>
                    </div>

                    <div class="yuzde50">
                        <label><strong><?php echo __("website/account_products/sent-numbers"); ?></strong> (<span id="NumbersCount">0</span> <?php echo __("website/account_products/count"); ?>)</label>
                        <textarea name="numbers" id="numbers" style="resize:vertical" rows="6" placeholder="<?php echo __("website/account_products/group-numbers-placeholder"); ?>"></textarea><br>
                    </div>


                    <div class="clear"></div><br>

                    <?php if(isset($dimensions) && is_array($dimensions) && sizeof($dimensions)): ?>
                        <table width="100%" border="0" class="smsucretleri">
                            <thead>
                            <tr><th align="left"><?php echo __("website/account_products/dimension-character"); ?></th>
                                <th align="center" ><?php echo __("website/account_products/dimension-size"); ?></th>
                                <th align="center"><?php echo __("website/account_products/dimension-credit"); ?></th>
                            </tr></thead>
                            <tbody>
                            <?php foreach($dimensions AS $dimension): ?>
                                <tr>
                                    <td><?php echo $dimension["start"]; ?> - <?php echo $dimension["end"]; ?> <?php echo __("website/account_products/dimension-character"); ?></td>
                                    <td align="center"><?php echo $dimension["credit"];?> SMS</td>
                                    <td align="center"><?php echo $dimension["credit"];?> <?php echo __("website/account_products/dimension-credit"); ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>

                    <div class="line"></div>
                    <a href="javascript:void(0);" onclick="previewButton();" class="yesilbtn gonderbtn"><?php echo __("website/account_products/preview-button"); ?></a>
                </div>

                <div id="preview" style="display:none;">
                    <!-- GÖNDERİM ÖN İZLEME -->
                    <h5 style="color:#8bc34a"><strong><?php echo __("website/account_products/preview-title"); ?></strong></h5><br>
                    <div class="msjonizleme">

                        <div class="smspreviewinfo">
                            <div class="yuzde30"><strong><?php echo __("website/account_products/preview-number-count"); ?></strong></div>
                            <div class="yuzde70" id="previewC_1">0</div>
                        </div>

                        <div class="smspreviewinfo">
                            <div class="yuzde30"><strong><?php echo __("website/account_products/preview-character-count"); ?></strong></div>
                            <div class="yuzde70"><span id="previewC_2">0</span> <?php echo __("website/account_products/dimension-character"); ?> (<span id="previewC_3">1</span> SMS)</div>
                        </div>

                        <div class="smspreviewinfo">
                            <div class="yuzde30"><strong><?php echo __("website/account_products/preview-total-credit"); ?></strong></div>
                            <div class="yuzde70" id="previewC_4" style="font-weight: bold;">1</div>
                        </div>

                        <div class="smspreviewinfo">
                            <div class="yuzde30"><strong><?php echo __("website/account_products/preview-origin"); ?></strong></div>
                            <div class="yuzde70" id="previewC_5">NONE</div>
                        </div>

                        <div class="smspreviewinfo">
                            <div class="yuzde30"><strong><?php echo __("website/account_products/preview-message-text"); ?></strong></div>
                            <div class="yuzde70" id="previewC_6"></div>
                        </div>

                        <div class="yuzde30"><a href="javascript:void(0);" onclick="turnBack();" class="mavibtn gonderbtn"><i class="fa fa-angle-double-left" aria-hidden="true"></i> <?php echo __("website/account_products/preview-turn-back"); ?></a></div>
                        <div class="yuzde70"><a href="javascript:void(0);" class="yesilbtn gonderbtn mio-ajax-submit" mio-ajax-options='{"result":"SendSMS","waiting_text":"<?php echo addslashes(__("website/others/button5-pending")); ?>"}'><i class="fa fa-paper-plane-o" aria-hidden="true"></i> <?php echo __("website/account_products/preview-send-sms"); ?></a></div>
                    </div>
                    <!-- GÖNDERİM ÖN İZLEME -->
                </div>

                <div class="clear"></div>
                <div id="result" class="error" style="display:none; text-align: center;"></div>
            </form>

            <div id="sentSMS" style="display: none;">
                <div style="margin-top:30px;margin-bottom:70px;text-align:center;">
                    <i style="font-size:80px;" class="fa fa-check"></i><br>
                    <?php echo __("website/account_products/sent-sms"); ?>
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
                                    $("#SubmitSMS #result").fadeIn(700).html(solve.message);
                                else
                                    $("#SubmitSMS #result").fadeOut(700).html('');
                            }else if(solve.status == "successful"){
                                $("#SubmitSMS").fadeOut(500,function(){
                                    $("html,body").animate({scrollTop:150},700);
                                    $("#sentSMS").fadeIn(700);
                                    setTimeout(function(){
                                        window.location.href = sGET("tab",5);
                                    },4000);
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
                            title:'<?php echo __("website/account_products/modal-error-title"); ?>',
                            text:'<?php echo __("website/account_products/preview-error1"); ?>',
                            type:"error"
                        });
                        return false;
                    }
                    var origin_text = $("#SubmitSMS select[name=origin] option[value='"+origin+"']").text();

                    var count   = $("#NumbersCount").html();
                    count       = parseInt(count);

                    if(count < 1){
                        swal({
                            title:'<?php echo __("website/account_products/modal-error-title"); ?>',
                            text:'<?php echo __("website/account_products/preview-error2"); ?>',
                            type:"error"
                        });
                        return false;
                    }

                    var credit          = parseInt($("#Credit").html());
                    var total_credit    = credit * count;
                    var message         = $("#message").val();
                    var message_length  = message.length;

                    if(message_length < 1){
                        swal({
                            title:'<?php echo __("website/account_products/modal-error-title"); ?>',
                            text:'<?php echo __("website/account_products/preview-error3"); ?>',
                            type:"error"
                        });
                        return false;
                    }


                    $("#previewC_1").html(count);
                    $("#previewC_2").html(message_length);
                    $("#previewC_3").html(credit);
                    $("#previewC_4").html(+total_credit);
                    $("#previewC_5").html(origin_text);
                    $("#previewC_6").html(message);

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

                function countChar(val) {
                    $(val).val(transliterate($(val).val()));
                    var len = val.value.length;

                    <?php if(!empty($last_end)): ?>
                    if (len >= <?php echo $last_end; ?>) {
                        val.value = val.value.substring(0, <?php echo $last_end; ?>);
                        $('#charNum').text(<?php echo $last_end; ?>);
                        return true;
                    }
                    <?php endif; ?>

                    $('#charNum').text(len);

                    <?php
                    if($dimensions && is_array($dimensions) && sizeof($dimensions)>0){
                        $i = 0;
                        foreach($dimensions AS $dimension){
                            $i+=1;
                            if($i == 1){
                                echo 'if(len >= '.$dimension["start"].' && len <= '.$dimension["end"].'){'.EOL;
                                echo '                                    $("#Credit").text('.$dimension["credit"].');'.EOL;
                                echo '                                } ';
                            }elseif($i == $size){
                                echo 'else if(len >= '.$dimension["start"].' && len <= '.$dimension["end"].'){'.EOL;
                                echo '                                    $("#Credit").text('.$dimension["credit"].');'.EOL;
                                echo '                                } else {'.EOL;
                                echo '                                    $("#Credit").text('.$last["credit"].');'.EOL;
                                echo '                                }';
                            }else{
                                echo 'else if(len >= '.$dimension["start"].' && len <= '.$dimension["end"].'){'.EOL;
                                echo '                                    $("#Credit").text('.$dimension["credit"].');'.EOL;
                                echo '                                } ';
                            }
                        }
                    }
                    ?>

                }


                function numbersCount(elem){
                    var value = $(elem).val();
                    var exps  = value.split("\n");
                    var nums  = Array();
                    $(exps).each(function(key,item){
                        item = item.substring(0,20);
                        if(isNaN(item)) item = item.replace(/[^0-9]+/g, '');
                        if(!in_array([item],nums)) nums.push(item);
                    });
                    var count = nums.length;
                    if(count == 1 && nums[0] == '') count = 0;
                    var numbers = nums.join("\n");
                    $("#numbers").val(numbers);
                    $("#NumbersCount").html(count);
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
                    $("#numbers").keyup(function(){
                        numbersCount(this);
                    });

                });
            </script>


        </div>
    </div>
    <div id="baslikislemleri" class="tabcontent">
        <div class="tabcontentcon">
            <h5 style="margin:20px 0px;">

                <form id="OriginRequest" action="<?php echo $links["controller"]; ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="operation" value="new_origin_request">

                    <table width="100%" border="0" align="center">
                        <tbody>
                        <tr>
                            <td colspan="2"><span style="font-size:15px; color:red"><?php echo __("website/account_products/origin-reqest-desc"); ?></span></td>
                        </tr>

                        <tr>
                            <td width="30%"><span class="zorunlu">*</span> <?php echo __("website/account_products/sender-origin"); ?></td>
                            <td><input class="notr" name="origin" type="text" placeholder="<?php echo __("website/account_products/origin-max-character"); ?>" size="11" maxlength="11"></td>
                        </tr>

                        <script type="text/javascript">
                            $(".notr").on("ready load keyup keydown keypress change", function () {
                                var baslik = $(this).val().substr(0, 11).replace(/ö/g, "o").replace(/ç/g, "c").replace(/ş/g, "s").replace(/ğ/g, "g").replace(/ü/g, "u").replace(/Ö/g, "O").replace(/Ç/g, "C").replace(/Ş/g, "S").replace(/İ/g, "I").replace(/Ğ/g, "G").replace(/Ü/g, "U").replace(/([^a-zA-Z0-9 \.\-_])/g, "");
                                $(this).val(baslik);
                            });
                        </script>

                        <tr>
                            <td width="30%"><span class="zorunlu">*</span> <?php echo __("website/account_products/origin-documents"); ?></td>
                            <td><input style="font-size:15px;" name="attachments[]" type="file" multiple>
                                <span style="font-size:14px; color:green"><?php echo __("website/account_products/origin-document-desc"); ?></span>
                            </td>
                        </tr>

                        </tbody></table>

                    <a href="javascript:void(0);" class="yesilbtn gonderbtn mio-ajax-submit" mio-ajax-options='{"result":"OriginRequest_submit","waiting_text":"<?php echo addslashes(__("website/others/button1-pending")); ?>","progress_text":"<?php echo addslashes(__("website/others/button1-upload")); ?>"}'><?php echo __("website/account_products/origin-request-send-button"); ?></a>

                    <div id="result" class="error" style="text-align: center; margin-top:5px;"></div>
                </form>
                <div id="OriginRequest_success" style="display: none;">
                    <div style="margin-top:30px;margin-bottom:70px;text-align:center;">
                        <i style="font-size:80px;" class="fa fa-check"></i><br>
                        <?php echo __("website/account_products/sent-origin-request"); ?>
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
                                        alert_error(solve.message,{timer:5000});
                                }else if(solve.status == "successful"){
                                    $("#OriginRequest").fadeOut(700,function(){
                                        $("html,body").animate({scrollTop:100},300);
                                        $("#OriginRequest_success").fadeIn(700);
                                        setTimeout(function(){
                                            window.location.href = window.location.href;
                                        },3000);
                                    });
                                }
                            }else
                                console.log(result);
                        }

                    }
                </script>

                <div class="clear"></div>
                <div style="margin:40px 0px;" class="line"></div>

                <h4 style="margin-bottom:7px;    font-size: 18px;"><strong><?php echo __("website/account_products/current-origins"); ?></strong></h4>

                <?php if(isset($origins) && is_array($origins) && sizeof($origins)>0): ?>
                    <table class="" width="100%" border="0">
                        <thead style="background:#ebebeb;">
                        <tr>
                            <th align="left"><?php echo __("website/account_products/origin-information"); ?></th>
                            <th align="center" id="nomobil">Oluşturma Tarihi</th>
                            <th align="center"><?php echo __("website/account_products/origin-status"); ?></th>
                            <th align="center"> </th>
                        </tr>
                        </thead>

                        <tbody align="Center" style="border-top:none;">
                        <?php
                            $rank = 0;
                            foreach($origins AS $origin){
                                $rank +=1;
                                $color = "";
                                $color = $origin["status"] == "active" ? "#8bc34a" : $color;
                                $color = $origin["status"] == "inactive" ? "#f44336" : $color;
                                $color = $origin["status"] == "waiting" ? "black" : $color;
                                ?>
                                <tr style="background:none;">
                                    <td align="left">
                                        <strong><?php echo $origin["name"]; ?></strong>
                                        <?php if($origin["status_message"] != ''){ ?><br><span style="color:<?php echo $color; ?>"><?php echo __("website/account_products/operator-note"); ?>:</span> <?php echo $origin["status_message"]; } ?>
                                    </td>
                                    <td align="center" id="nomobil"><?php echo DateManager::format(Config::get("options/date-format")." - H:i",$origin["ctime"]); ?></td>
                                    <td align="center" width="130">
                                        <?php echo $origin_situations[$origin["status"]]; ?>
                                    </td>
                                    <td align="center" width="140">
                                        <a href="javascript:evrak_yukle(<?php echo $origin["id"]; ?>); void 0" class="lbtn"><i class="fa fa-cloud-upload"></i> Evrak Yükle</a>
                                    </td>
                                </tr>
                                <?php
                            }
                        ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="error"><?php echo __("website/account_products/no-origins"); ?></div>
                <?php endif; ?>

        </div>
    </div>
    <div id="rehber" class="tabcontent">
        <div class="tabcontentcon">
            <h5 style="margin:20px 0px;">


                <div id="accordion" style="margin-top:25px;">

                    <h3><?php echo __("website/account_products/add-new-sms-group"); ?></h3>
                    <div>
                        <form action="<?php echo $links["controller"]; ?>" method="post" id="addNewGroup">
                            <input type="hidden" name="operation" value="add_new_group">
                            <label style="float:left;" class="yuzde25"><strong><?php echo __("website/account_products/new-sms-group-name"); ?>:</strong></label>
                            <div class="yuzde75">
                                <input name="name" type="text" placeholder="<?php echo __("website/account_products/new-sms-group-name-placeholder"); ?>">
                                <a class="yuzde25 mavibtn gonderbtn mio-ajax-submit" mio-ajax-options='{"result":"addNewGroup_submit"}' href="javascript:void(0);"><?php echo __("website/account_products/add-sms-group-button"); ?></a>
                            </div>
                            <div class="clear"></div>
                            <div id="result" style="display: none; text-align: center; margin-top:5px;" class="error"></div>
                        </form>
                        <div id="addNewGroup_success" style="display: none;">
                            <div style="margin-top:30px;margin-bottom:70px;text-align:center;">
                                <i style="font-size:80px;" class="fa fa-check"></i>
                                <h4 style="font-weight:bold;"><?php echo __("website/account_products/added-sms-group"); ?></h4>
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
                                                $("#addNewGroup #result").fadeIn(700).html(solve.message);
                                            else
                                                $("#addNewGroup #result").fadeOut(700).html('');
                                        }else if(solve.status == "successful"){
                                            $("#addNewGroup").fadeOut(700,function(){
                                                $("#addNewGroup_success").fadeIn(700);
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

                    <h3><?php echo __("website/account_products/group-management"); ?></h3>
                    <div>

                        <form id="ChangeGroupNumbers" action="<?php echo $links["controller"]; ?>" method="post">
                            <input type="hidden" name="operation" value="change_group_numbers">

                            <?php if(isset($groups) && is_array($groups) && sizeof($groups)>0){
                                ?>
                                <label style="float:left;" class="yuzde25"><strong><?php echo __("website/account_products/select-group"); ?></strong></label>
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
                                <div class="error" style=""><?php echo __("website/account_products/sms-group-none"); ?></div>
                                <?php
                            }
                            ?>

                            <div id="if_selected" style="display: none">
                                <div class="line"></div>
                                <div class="clear"></div>

                                <label><strong><?php echo __("website/account_products/group-number-add-or-delete"); ?></strong>
                                    <textarea disabled name="numbers" cols="" rows="" placeholder="<?php echo __("website/account_products/group-numbers-placeholder"); ?>"></textarea></label>

                                <div class="yuzde100">
                                    <a class="mavibtn gonderbtn mio-ajax-submit" mio-ajax-options='{"result":"ChangeGroupNumbers_submit"}' href="javascript:void(0);"><?php echo __("website/account_products/change-group-button"); ?></a>
                                    <div id="result" class="yuzde100 error" style="text-align:center; margin-top:5px;display:none;"></div>
                                    <a class="redbtn gonderbtn" href="javascript:void(0);" id="deleteGroup"><?php echo __("website/account_products/delete-group-button"); ?></a>
                                </div>
                            </div>

                        </form>
                        <div id="ChangeGroupNumbers_success" style="display: none;">
                            <div style="margin-top:30px;margin-bottom:70px;text-align:center;">
                                <i style="font-size:80px;" class="fa fa-check"></i>
                                <h4 style="font-weight:bold;"><?php echo __("website/account_products/changed-group-numbers"); ?></h4>
                                <br>
                            </div>
                        </div>
                        <script type="text/javascript">
                            var groups = getJson('<?php echo Utility::jencode($groups); ?>');
                            var blackl = getJson('<?php echo Utility::jencode($black_list); ?>');
                            function getGroup(id) {
                                var found=false;
                                $(groups).each(function(key,item){
                                    if(item.id == id) {
                                        found = item;
                                    }
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
                                                $("#ChangeGroupNumbers #result").fadeIn(700).html(solve.message);
                                            else
                                                $("#ChangeGroupNumbers #result").fadeOut(700).html('');
                                        }else if(solve.status == "successful"){
                                            $("#ChangeGroupNumbers").fadeOut(700,function(){
                                                $("#ChangeGroupNumbers_success").fadeIn(700);
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
                                        title: '<?php echo __("website/account_products/delete-group-modal-title"); ?>',
                                        text: "<?php echo __("website/account_products/delete-group-modal-desc"); ?>",
                                        type: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: '<?php echo __("website/account_products/delete-group-modal-ok"); ?>',
                                        cancelButtonText: '<?php echo __("website/account_products/delete-group-modal-no"); ?>'
                                    }).then(function(){

                                        var group_id = $("input[name=group]:checked").val();
                                        var result = MioAjax({
                                            action:"<?php echo $links["controller"];?>",
                                            method:"POST",
                                            data:{operation:"delete_group",id:group_id}
                                        },true,true);

                                        result.success(function (res) {
                                            if(res != ''){
                                                var solve = getJson(res);
                                                if(solve && typeof solve == "object"){
                                                    if(solve.status == "error"){
                                                        swal({
                                                            title: '<?php echo __("website/account_products/delete-group-modal-error") ?>',
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
                                                            title: '<?php echo __("website/account_products/delete-group-modal-deleted") ?>',
                                                            text: '<?php echo __("website/account_products/delete-group-modal-successful"); ?>',
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

                    </div>


                    <h3><?php echo __("website/account_products/black-list"); ?></h3>
                    <div>

                        <form id="UpdateBlackList" action="<?php echo $links["controller"]; ?>" method="post">
                            <input type="hidden" name="operation" value="update_black_list">
                            <h5><?php echo __("website/account_products/black-list-desc"); ?></h5><br>
                            <label><strong><?php echo __("website/account_products/group-number-add-or-delete"); ?></strong>
                                <textarea name="numbers" cols="" rows="" placeholder="<?php echo __("website/account_products/group-numbers-placeholder"); ?>"><?php echo str_replace(",","\n",isset($options["black_list"]) ? $options["black_list"] : NULL); ?></textarea>
                            </label>
                            <a class="yuzde25 redbtn gonderbtn mio-ajax-submit" mio-ajax-options='{"result":"UpdateBlackList_submit"}' href="javascript:void(0);"><?php echo __("website/account_products/black-list-update-button"); ?></a>
                            <div id="result" class="error" style="display: none;text-align: center;"></div>
                        </form>
                        <div id="UpdateBlackList_success" style="display: none;">
                            <div style="margin-top:30px;margin-bottom:70px;text-align:center;">
                                <i style="font-size:80px;" class="fa fa-check"></i>
                                <h4 style="font-weight:bold;"><?php echo __("website/account_products/updated-black-list-successful"); ?></h4>
                                <br>
                            </div>
                        </div>
                        <script type="text/javascript">
                            function UpdateBlackList_submit(result) {
                                if(result != ''){
                                    var solve = getJson(result);
                                    if(solve !== false){
                                        if(solve.status == "error"){
                                            if(solve.for != undefined && solve.for != ''){
                                                $("#UpdateBlackList "+solve.for).focus();
                                                $("#UpdateBlackList "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                                $("#UpdateBlackList "+solve.for).change(function(){
                                                    $(this).removeAttr("style");
                                                });
                                            }
                                            if(solve.message != undefined && solve.message != '')
                                                $("#UpdateBlackList #result").fadeIn(700).html(solve.message);
                                            else
                                                $("#UpdateBlackList #result").fadeOut(700).html('');
                                        }else if(solve.status == "successful"){
                                            $("#UpdateBlackList").fadeOut(700,function(){
                                                $("#UpdateBlackList_success").fadeIn(700);
                                                setTimeout(function(){
                                                    var link = sGET("accordion",3);
                                                    window.location.href = link;
                                                },1500);
                                            });
                                        }
                                    }else
                                        console.log(result);
                                }
                            }
                        </script>

                    </div>


                </div>
        </div>
    </div>
    <div id="raporlar" class="tabcontent">


        <?php if(isset($reports) && is_array($reports) && sizeof($reports)>0): ?>
            <div class="mobiltable">
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
                            "oLanguage":<?php include __DIR__.DS."datatable-lang.php"; ?>
                        });

                    });
                </script>
                <table id="reports" width="100%">
                    <thead style="background:#ebebeb;">
                    <tr>
                        <th align="center">#</th>
                        <th align="center"><?php echo __("website/account_products/reports-table-field1"); ?></th>
                        <th align="center"><?php echo __("website/account_products/reports-table-field2"); ?></th>
                        <th align="center">Gsm No</th>
                        <th align="left"><?php echo __("website/account_products/reports-table-field4"); ?></th>
                        <th align="center">Toplam Kredi</th>
                        <th align="center"><?php echo __("website/account_products/reports-table-field5"); ?></th>
                    </tr>
                    </thead>

                    <tbody align="Center" style="border-top:none;">
                    <?php $rank=0; foreach($reports AS $report):
                        $rank +=1;
                        ?>
                        <tr>
                            <td align="center"><?php echo $rank; ?></td>
                            <td align="center"><?php echo $report["ctime"]; ?></td>
                            <td align="center"><?php echo $report["title"]; ?></td>
                            <td align="center"><?php echo $report["data"]["count"]; ?></td>

                            <td align="left"><?php echo $report["short_content"]; if($report["content"] != ''): ?><span class="tooltip-bottom" data-tooltip="<?php echo htmlspecialchars($report["content"],ENT_QUOTES); ?>"> <i class="fa fa-angle-double-right" aria-hidden="true"></i> <?php echo __("website/account_products/report-message-content"); ?></span><?php endif; ?>
                                (<?php echo $report["data"]["length"]; ?> Karakter - <?php echo $report["data"]["credit"]; ?> Kredi)

                            </td>
                            <td align="center"><?php echo $report["data"]["total_credit"]; ?></td>
                            <td align="center">
                                <a href="javascript:getReportDetail(<?php echo $report["id"]; ?>);void 0;" class="lbtn"><i class="fa fa-search"></i> <?php echo __("website/account_products/get-sms-detail-report"); ?></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div style="text-align:center;margin:40px;">
                <i style="font-size:84px;" class="fa fa-info-circle" aria-hidden="true"></i><br><br>
                <?php echo __("website/account_products/no-reports"); ?>
            </div>
        <?php endif; ?>

        <div class="clear"></div>
    </div>
    <?php if($proanse["status"] == "active" && $ctoc_service_transfer): ?>
        <div id="transfer-service" class="tabcontent">
            <div class="tabcontentcon">
                <div class="blue-info" style="margin-bottom:20px;">
                    <div class="padding15">
                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                        <p><?php echo __("website/account_products/transfer-service-desc"); ?></p>
                    </div>
                </div>

                <?php
                    if(isset($ctoc_limit) && strlen($ctoc_limit) > 0){
                        ?>
                        <div class="formcon">
                            <div class="yuzde30"><?php echo __("website/account_products/limit-info"); ?></div>
                            <div class="yuzde70" style="color: #F44336;"><?php echo ($ctoc_limit - $ctoc_used); ?></div>
                        </div>
                        <?php
                    }
                ?>

                <div id="TransferService_wrap" style="<?php echo $ctoc_has_expired ? 'display:none;' : ''; ?>">

                    <form action="<?php echo $links["controller"]; ?>" method="post" id="TransferService">
                        <input type="hidden" name="operation" value="transfer_service">

                        <input type="text" name="email" placeholder="<?php echo __("website/account_products/transfer-service-client-email"); ?>">

                        <input type="password" name="password" placeholder="<?php echo __("website/account_products/transfer-service-your-account-password"); ?>">

                        <a href="javascript:void(0);" class="yesilbtn gonderbtn mio-ajax-submit" mio-ajax-options='{"result":"TransferService_handle","waiting_text":"<?php echo addslashes(__("website/others/button5-pending")); ?>"}'><?php echo __("website/account_products/transfer-button"); ?></a>
                        <div class="clear"></div>
                    </form>


                    <h4 style="margin-bottom:7px;    font-size: 18px;"><strong><?php echo __("website/account_products/transfer-service-pending-list"); ?></strong></h4>

                    <table id="ctoc_s_t_list" width="100%" border="0" style="<?php echo isset($ctoc_s_t_list) && is_array($ctoc_s_t_list) && sizeof($ctoc_s_t_list)>0 ? '' : 'display:none;'; ?>">
                        <thead>
                        <tr>
                            <th align="left"><?php echo __("website/account_products/transfer-service-list-th-user"); ?></th>
                            <th align="center"><?php echo __("website/account_products/transfer-service-list-th-email"); ?></th>
                            <th align="center"><?php echo __("website/account_products/transfer-service-list-th-date"); ?></th>
                            <th align="center"> </th>
                        </tr>
                        </thead>

                        <tbody align="center" style="border-top:none;">
                        <?php
                            if(isset($ctoc_s_t_list) && is_array($ctoc_s_t_list) && sizeof($ctoc_s_t_list)>0){
                                foreach($ctoc_s_t_list AS $ctoc_s_t_r){
                                    $ctoc_s_t_r["data"]     = Utility::jdecode($ctoc_s_t_r["data"],true);
                                    $evt_data               = $ctoc_s_t_r["data"];
                                    $full_name              = $evt_data["to_full_name"];
                                    $name_length            = Utility::strlen($full_name);
                                    $name_length            -= 2;
                                    $full_name              = Utility::substr($full_name,0,2).str_repeat("*",$name_length);
                                    ?>
                                    <tr style="background:none;" id="ctoc_s_t_<?php echo $ctoc_s_t_r["id"]; ?>">
                                        <td align="left"><?php echo $full_name; ?></td>
                                        <td align="center"><?php echo $evt_data["to_email"]; ?></td>
                                        <td align="center"><?php echo DateManager::format(Config::get("options/date-format")." H:i",$ctoc_s_t_r["cdate"]); ?></td>
                                        <td align="center" width="140">
                                            <a href="javascript:void 0;" onclick="remove_ctoc_s_t(<?php echo $ctoc_s_t_r["id"]; ?>,this);" class="sbtn red" data-tooltip="<?php echo ___("needs/button-delete"); ?>"><i class="fa fa-times"></i></a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                        ?>
                        </tbody>
                    </table>
                    <div id="ctoc_s_t_no_list" class="error" style="<?php echo !(isset($ctoc_s_t_list) && is_array($ctoc_s_t_list) && sizeof($ctoc_s_t_list)>0) ? '' : 'display:none;' ?>"><?php echo __("website/account_products/transfer-service-no-list"); ?></div>


                </div>
                <div id="TransferService_success" style="display: none;">
                    <div style="margin-top:30px;margin-bottom:70px;text-align:center;">
                        <i style="font-size:80px;" class="fa fa-check"></i>
                        <h4><?php echo __("website/account_products/transfer-service-successful"); ?></h4>
                        <br>
                    </div>
                </div>
                <script type="text/javascript">
                    function TransferService_handle(result){
                        if(result != ''){
                            var solve = getJson(result);
                            if(solve !== false){
                                if(solve.status == "error"){
                                    if(solve.for != undefined && solve.for != ''){
                                        $("#TransferService "+solve.for).focus();
                                        $("#TransferService "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                        $("#TransferService "+solve.for).change(function(){
                                            $(this).removeAttr("style");
                                        });
                                    }
                                    if(solve.message != undefined && solve.message != '')
                                        alert_error(solve.message,{timer:3000});
                                }else if(solve.status == "successful"){
                                    $("#TransferService_wrap").fadeOut(400,function(){
                                        $("#TransferService_success").fadeIn(400);
                                        $("html,body").animate({scrollTop:200},600);
                                    });
                                    if(solve.reload !== undefined){
                                        setTimeout(function(){
                                            location.href = '<?php echo $links["controller"]; ?>?tab=transfer-service';
                                        },3000);
                                    }
                                }
                            }else
                                console.log(result);
                        }
                    }
                    function remove_ctoc_s_t(id,btn){
                        swal({
                            title: '<?php echo ___("needs/delete-are-you-sure"); ?>',
                            text: "",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: '<?php echo __("website/others/notification-confirm"); ?>',
                            cancelButtonText: '<?php echo __("website/others/notification-cancel"); ?>',
                        }).then(function(value){
                            if(value){
                                var request = MioAjax({
                                    waiting_text: '<i style="-webkit-animation:fa-spin 2s infinite linear;animation: fa-spin 2s infinite linear;" class="fa fa-spinner" aria-hidden="true"></i>',
                                    button_element: btn,
                                    action: "<?php echo $links["controller"]; ?>",
                                    method: "POST",
                                    data:{
                                        operation: "remove_transfer_service",
                                        id: id
                                    },
                                },true,true);
                                request.done(function(result){
                                    if(result !== ''){
                                        var solve = getJson(result);
                                        if(solve.status === 'error')
                                            Swal.fire(
                                                '<?php echo __("website/others/notification-error"); ?>',
                                                solve.message,
                                                'error'
                                            );
                                        else if(solve.status === 'successful'){
                                            swal(
                                                '<?php echo __("website/others/notification-success"); ?>',
                                                solve.message,
                                                'success'
                                            );
                                            $(btn).parent().parent().remove();
                                            if($("#ctoc_s_t_list tbody tr").length < 1){
                                                $("#ctoc_s_t_list").css("display","none");
                                                $("#ctoc_s_t_no_list").css("display","block");
                                            }
                                        }
                                    }
                                });
                            }
                        });
                    }
                </script>
            </div>
        </div>
    <?php endif; ?>

</div>
<div id="loading-container" style="display: none;">
    <div align="center">
        <h4><img src="<?php echo $sadress; ?>assets/images/loading.gif"><br><?php echo __("website/account_products/loading-report-data"); ?></h4>
    </div>
</div>
<div id="getReport" style="display: none;">
    <div class="padding20">

    </div>
</div>
<div id="ReportTemplate" style="display:none;">
    <div class="durumraportable">
        <table width="100%" border="0" align="center">
            <thead>
            <tr>
                <td width="33%" align="center" bgcolor="#D6FE81" style="color:#4B7001"><strong><?php echo __("website/account_products/report-delivered"); ?> ({delivered_count})</strong></td>
                <td width="33%" align="center" bgcolor="#C6FFFF" style="color:#009393"><strong><?php echo __("website/account_products/report-expect"); ?> ({expect_count})</strong></td>
                <td width="33%" align="center" bgcolor="#FFCACA" style="color:#970000"><strong><?php echo __("website/account_products/report-incorrect"); ?> ({incorrect_count})</strong></td>
            </tr>
            </thead>
            <tbody>

            <tr>
                <td width="33%" align="center" style="color:#689A01">{conducted_number}</td>
                <td width="33%" align="center" style="color:#009393">{waiting_number}</td>
                <td width="33%" align="center" style="color:#AE0000">{erroneous_number}</td>
            </tr>

            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $("#getReport").iziModal({
            title: "<?php echo __("website/account_products/status-report"); ?>",
            width: 700,
            transitionIn: 'fadeInDown',
            transitionOut: 'fadeOutDown',
            bodyOverflow: true,
            history:false,
        });
    });

    function getReportDetail(id) {
        $("#getReport .padding20").html($("#loading-container").html());

        $("#getReport").iziModal('open');

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
<script type="text/javascript">
    function evrak_yukle(id) {
        open_modal('evrak_yukle_modal');
        $("#uploadAttachments input[name=id]").val(id);
        return true;
    }

    function change_files(e){
        e = e.files;

        if(e.length>0){
            $("#select_label").html(e.length > 1 ? e.length+" adet dosya seçildi." : e[0].name);
            $("#continue_div").css("display","block");
        }
        else {
            $("#continue_div").css("display","none");
            $("#select_label").html('Evrakları yüklemek için tıklayınız.');
        }

    }

    function detailForm_handler(result){
        if(result != ''){
            var solve = getJson(result);
            if(solve !== false){
                if(solve.status == "error"){
                    if(solve.message != undefined && solve.message != '') alert_error(solve.message,{timer:5000});
                }else if(solve.status == "successful"){
                    if(solve.message != undefined && solve.message != '') alert_success(solve.message);
                    if(solve.redirect != undefined && solve.redirect != '') window.location.href = solve.redirect;
                }
            }else
                console.log(result);
        }
    }

    $(document).ready(function(){

        $("#evrak_yukle_modal").on("click","#add_attachment_submit",function(){
            MioAjaxElement($(this),{
                waiting_text: '<?php echo addslashes(__("website/others/button1-pending")); ?>',
                progress_text: '<?php echo addslashes(__("website/others/button1-upload")); ?>',
                result:"detailForm_handler",
            });
        });

    });
</script>
<div id="evrak_yukle_modal" data-izimodal-title="Evrak Yükle" style="display: none; cursor: pointer;">
    <div class="padding20">
        <form action="<?php echo $links["controller"]; ?>" method="post" enctype="multipart/form-data" id="uploadAttachments">
            <input type="hidden" name="operation" value="add_attachment">
            <input type="hidden" name="id" value="0">

            <input type="file" name="files[]" onchange="change_files(this);" multiple id="files" style="display: none;">

            <span id="select_label" onclick="$('#files').click();" style="display:block;border: dotted 2px #CCC; padding: 10px; font-size:20px; text-align: center;">Evrakları yüklemek için tıklayınız.</span>

            <div id="continue_div" style="display: none;">
                <div style="float: right;width: 170px;">
                    <a href="javascript:void(0);" id="add_attachment_submit" class="gonderbtn yesilbtn">Yükle</a>
                </div>
            </div>

            <div class="clear"></div>


        </form>

    </div>
</div>