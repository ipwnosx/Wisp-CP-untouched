<!DOCTYPE html>
<html>
<head>
    <?php
        $plugins    = ['jquery-ui'];
        include __DIR__.DS."inc".DS."head.php";
    ?>
    <script type="text/javascript">
        $(document).ready(function(){

        });
    </script>
</head>
<body>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1><strong><?php echo __("admin/automation/page-settings"); ?></strong></h1>
                <?php
                $ui_help_link = 'https://docs.wisecp.com/en/kb/cronjob-automation';
                if($ui_lang == "tr") $ui_help_link = 'https://docs.wisecp.com/tr/kb/cronjob-ve-otomasyon';
                ?>
                <a title="<?php echo __("admin/help/usage-guide"); ?>" target="_blank" class="pagedocslink" href="<?php echo $ui_help_link; ?>"><i class="fa fa-life-ring" aria-hidden="true"></i></a>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>

            <div class="adminpagecon">

                <div class="green-info" style="margin-bottom:20px;">
                    <div class="padding15">
                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                        <p><?php echo __("admin/automation/settings-info"); ?></p>
                    </div>
                </div>


                <div class="formcon">
                    <div class="yuzde30"><?php echo __("admin/automation/settings-cron-commands"); ?></div>
                    <div class="yuzde70">
                        <div class="yuzde70">
                            <span class="croncommand">php -q <?php echo CORE_DIR."cronjobs.php"; ?></span>
                            <br><span class="kinfo"><?php echo __("admin/automation/settings-minute-cron-info"); ?></span>
                        </div>
                    </div>
                </div>

                <div class="formcon" style="display:none">
                    <div class="yuzde30"><?php echo __("admin/automation/settings-example-cron"); ?></div>
                    <div class="yuzde70">
                        <div class="yuzde70">
                            <a target="_blank" href="<?php echo $tadress; ?>/images/cronset.jpg"><?php echo __("admin/automation/settings-image-cron"); ?></a>
                        </div>
                    </div>
                </div>

                <div class="formcon">
                    <div class="yuzde30"><?php echo __("admin/automation/settings-last-run-time"); ?></div>
                    <div class="yuzde70">
                        <div class="yuzde70">
                            <?php
                                echo substr($crons["last-run-time"],0,4) == "0000" ? __("admin/automation/never-worked") : DateManager::format(Config::get("options/date-format")." - H:i",$crons["last-run-time"]);
                            ?>
                        </div>
                    </div>
                </div>

                <form action="<?php echo $links["controller"]; ?>" method="post" id="settingsForm">
                    <input type="hidden" name="operation" value="update_settings">


                    <div class="formcon"  style="margin-bottom:25px;">
                        <div class="yuzde30">
                            <?php echo __("admin/automation/settings-time-to-process"); ?>
                        </div>
                        <div class="yuzde70">
                            <div id="processingtimerange">
                            <?php
                                echo __("admin/automation/between",[
                                    '{start}' => '<input type="time" name="time-to-process[start]" placeholder="HH:MM" value="'.$crons["time-to-process"]["start"].'" class="yuzde20">',
                                    '{end}' => '<input type="time" name="time-to-process[end]" placeholder="HH:MM" value="'.$crons["time-to-process"]["end"].'" class="yuzde20">',
                                ]);
                            ?>
                            </div>
                            <div class="clear"></div>
                            <span class="kinfo"><?php echo __("admin/automation/settings-time-to-process-info"); ?></span>
                        </div>
                    </div>

                    <div class="crongroup">
                        <div class="padding30">
                            <h4><?php echo __("admin/automation/settings-invoice-settings"); ?></h4>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/automation/settings-invoice-create"); ?>
                                    <br><span class="kinfo"><?php echo __("admin/automation/settings-inactive-info"); ?></span>
                                </div>
                                <div class="yuzde70">
                                    <input class="crongroupinput" onkeypress="return event.charCode>= 48 && event.charCode<= 57" name="invoice-create[than-one-month]" type="text" value="<?php echo $crons["tasks"]["invoice-create"]["settings"]["than-one-month"]; ?>">
                                    <span class="kinfo"> <?php echo __("admin/automation/settings-invoice-create-than-one-month"); ?></span><br>
                                    <input class="crongroupinput" onkeypress="return event.charCode>= 48 && event.charCode<= 57" name="invoice-create[month]" type="text" value="<?php echo $crons["tasks"]["invoice-create"]["settings"]["month"]; ?>">
                                    <span class="kinfo"> <?php echo __("admin/automation/settings-invoice-create-month"); ?></span>
                                </div>
                            </div>


                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/automation/settings-innvoice-reminder"); ?>
                                    <br><span class="kinfo"><?php echo __("admin/automation/settings-inactive-info"); ?></span>
                                </div>
                                <div class="yuzde70">
                                    <input class="crongroupinput" onkeypress="return event.charCode>= 48 && event.charCode<= 57" name="invoice-reminder[first]" type="text" value="<?php echo $crons["tasks"]["invoice-reminder"]["settings"]["first"]; ?>">
                                    <span class="kinfo"><?php echo __("admin/automation/settings-invoice-reminder-first"); ?></span><br>
                                    <input class="crongroupinput" onkeypress="return event.charCode>= 48 && event.charCode<= 57" name="invoice-reminder[second]" type="text" value="<?php echo $crons["tasks"]["invoice-reminder"]["settings"]["second"]; ?>">
                                    <span class="kinfo"><?php echo __("admin/automation/settings-invoice-reminder-second"); ?></span><br>
                                    <input class="crongroupinput" onkeypress="return event.charCode>= 48 && event.charCode<= 57" name="invoice-reminder[third]" type="text" value="<?php echo $crons["tasks"]["invoice-reminder"]["settings"]["third"]; ?>">
                                    <span class="kinfo"><?php echo __("admin/automation/settings-invoice-reminder-third"); ?></span><br>
                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/automation/settings-invoice-overdue"); ?>
                                    <br><span class="kinfo"><?php echo __("admin/automation/settings-inactive-info"); ?></span>
                                </div>
                                <div class="yuzde70">
                                    <input class="crongroupinput" onkeypress="return event.charCode>= 48 && event.charCode<= 57" name="invoice-overdue[first]" type="text" value="<?php echo $crons["tasks"]["invoice-overdue"]["settings"]["first"]; ?>">
                                    <span class="kinfo"><?php echo __("admin/automation/settings-invoice-overdue-first"); ?></span><br>
                                    <input class="crongroupinput" onkeypress="return event.charCode>= 48 && event.charCode<= 57" name="invoice-overdue[second]" type="text" value="<?php echo $crons["tasks"]["invoice-overdue"]["settings"]["second"]; ?>">
                                    <span class="kinfo"><?php echo __("admin/automation/settings-invoice-overdue-second"); ?></span><br>
                                    <input class="crongroupinput" onkeypress="return event.charCode>= 48 && event.charCode<= 57" name="invoice-overdue[third]" type="text" value="<?php echo $crons["tasks"]["invoice-overdue"]["settings"]["third"]; ?>">
                                    <span class="kinfo"><?php echo __("admin/automation/settings-invoice-overdue-third"); ?></span><br>
                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/automation/settings-invoice-cancellation"); ?>
                                    <br><span class="kinfo"><?php echo __("admin/automation/settings-inactive-info"); ?></span>
                                </div>
                                <div class="yuzde70">                                 
                                    <input class="crongroupinput" onkeypress="return event.charCode>= 48 && event.charCode<= 57" name="invoice-cancellation[day]" type="text" value="<?php echo $crons["tasks"]["invoice-cancellation"]["settings"]["day"]; ?>">
                                    <span class="kinfo"><?php echo __("admin/automation/settings-invoice-cancellation-day-info"); ?></span>
                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/automation/settings-invoice-deletion"); ?>
                                    <br><span class="kinfo"><?php echo __("admin/automation/settings-inactive-info"); ?></span>
                                </div>
                                <div class="yuzde70">                                 
                                    <input class="crongroupinput" onkeypress="return event.charCode>= 48 && event.charCode<= 57" name="invoice-deletion[day]" type="text" value="<?php echo $crons["tasks"]["invoice-deletion"]["settings"]["day"]; ?>">
                                    <span class="kinfo"><?php echo __("admin/automation/settings-invoice-deletion-day-info"); ?></span>
                                </div>
                            </div>



                            <div class="clear"></div>
                        </div>
                    </div>

                    <div class="crongroup">
                        <div class="padding30">
                            <h4><?php echo __("admin/automation/settings-order-settings"); ?></h4>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/automation/settings-order-suspend-status"); ?></div>
                                <div class="yuzde70">
                                    <input<?php echo $crons["tasks"]["order-suspend"]["status"] ? ' checked' : ''; ?> id="order-suspend-status" class="checkbox-custom" name="order-suspend[status]" value="1" type="checkbox" onchange="if($(this).prop('checked')) $('#order-suspend-day-wrap').slideDown(300); else $('#order-suspend-day-wrap').slideUp(300);">
                                    <label for="order-suspend-status" class="checkbox-custom-label" style="margin-right: 28px;"><span class="kinfo"><?php echo __("admin/automation/settings-order-suspend-status-info"); ?></span></label>
                                </div>
                            </div>

                            <div class="formcon" id="order-suspend-day-wrap"<?php echo $crons["tasks"]["order-suspend"]["status"] ? '' : ' style="display:none;"'; ?>>
                                <div class="yuzde30"><?php echo __("admin/automation/settings-order-suspend-day"); ?></div>
                                <div class="yuzde70">
                                    <input class="crongroupinput" onkeypress="return event.charCode>= 48 &amp;&amp;event.charCode<= 57" name="order-suspend[day]" type="text" value="<?php echo $crons["tasks"]["order-suspend"]["settings"]["day"]; ?>">
                                    <span class="kinfo"><?php echo __("admin/automation/settings-order-suspend-day-info"); ?></span><br>
                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/automation/settings-order-cancel-status"); ?></div>
                                <div class="yuzde70">
                                    <input<?php echo $crons["tasks"]["order-cancel"]["status"] ? ' checked' : ''; ?> id="order-cancel-status" class="checkbox-custom" name="order-cancel[status]" value="1" type="checkbox" onchange="if($(this).prop('checked')) $('#order-cancel-day-wrap').slideDown(300); else $('#order-cancel-day-wrap').slideUp(300);">
                                    <label for="order-cancel-status" class="checkbox-custom-label" style="margin-right: 28px;"><span class="kinfo"><?php echo __("admin/automation/settings-order-cancel-status-info"); ?></span></label>
                                </div>
                            </div>

                            <div class="formcon" id="order-cancel-day-wrap"<?php echo $crons["tasks"]["order-cancel"]["status"] ? '' : ' style="display:none;"'; ?>>
                                <div class="yuzde30"><?php echo __("admin/automation/settings-order-cancel-day"); ?></div>
                                <div class="yuzde70">
                                    <input class="crongroupinput" onkeypress="return event.charCode>= 48 &amp;&amp;event.charCode<= 57" name="order-cancel[day]" type="text" value="<?php echo $crons["tasks"]["order-cancel"]["settings"]["day"]; ?>">
                                    <span class="kinfo"><?php echo __("admin/automation/settings-order-cancel-day-info"); ?></span><br>
                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/automation/settings-order-terminate-status"); ?></div>
                                <div class="yuzde70">
                                    <input<?php echo $crons["tasks"]["order-terminate"]["status"] ? ' checked' : ''; ?> id="order-terminate-status" class="checkbox-custom" name="order-terminate[status]" value="1" type="checkbox" onchange="if($(this).prop('checked')) $('#order-terminate-day-wrap').slideDown(300); else $('#order-terminate-day-wrap').slideUp(300);">
                                    <label for="order-terminate-status" class="checkbox-custom-label" style="margin-right: 28px;"><span class="kinfo"><?php echo __("admin/automation/settings-order-terminate-status-info"); ?></span></label>
                                </div>
                            </div>


                            <div class="formcon" id="order-terminate-day-wrap"<?php echo $crons["tasks"]["order-terminate"]["status"] ? '' : ' style="display:none;"'; ?>>
                                <div class="yuzde30"><?php echo __("admin/automation/settings-order-terminate-day"); ?></div>
                                <div class="yuzde70">
                                    <input class="crongroupinput" onkeypress="return event.charCode>= 48 &amp;&amp;event.charCode<= 57" name="order-terminate[day]" type="text" value="<?php echo $crons["tasks"]["order-terminate"]["settings"]["day"]; ?>">
                                    <span class="kinfo"><?php echo __("admin/automation/settings-order-terminate-day-info"); ?></span>
                                </div>
                            </div>

                             <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/automation/settings-pending-order-deletion"); ?>
                                    <br><span class="kinfo"><?php echo __("admin/automation/settings-inactive-info"); ?></span>
                                </div>
                                <div class="yuzde70">                                 
                                    <input class="crongroupinput" onkeypress="return event.charCode>= 48 && event.charCode<= 57" name="pending-order-deletion[day]" type="text" value="<?php echo $crons["tasks"]["pending-order-deletion"]["settings"]["day"]; ?>">
                                    <span class="kinfo"><?php echo __("admin/automation/settings-pending-order-deletion-day-info"); ?></span>
                                </div>
                            </div>

                             <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/automation/settings-pending-order-cancellation"); ?>
                                    <br><span class="kinfo"><?php echo __("admin/automation/settings-inactive-info"); ?></span>
                                </div>
                                <div class="yuzde70">
                                    <input class="crongroupinput" onkeypress="return event.charCode>= 48 && event.charCode<= 57" name="pending-order-cancellation[day]" type="text" value="<?php echo $crons["tasks"]["pending-order-cancellation"]["settings"]["day"]; ?>">
                                    <span class="kinfo"><?php echo __("admin/automation/settings-pending-order-cancellation-day-info"); ?></span>
                                </div>
                            </div>


                            <div class="clear"></div>
                        </div>
                    </div>

                    <div class="crongroup">
                        <div class="padding30">
                            <h4><?php echo __("admin/automation/settings-ticket-settings"); ?></h4>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/automation/settings-ticket-close-status"); ?></div>
                                <div class="yuzde70">
                                    <input<?php echo $crons["tasks"]["ticket-close"]["status"] ? ' checked' : ''; ?> id="ticket-close-status" class="checkbox-custom" name="ticket-close[status]" value="1" type="checkbox" onchange="if($(this).prop('checked')) $('#ticket-close-day-wrap').slideDown(300); else $('#ticket-close-day-wrap').slideUp(300);">
                                    <label for="ticket-close-status" class="checkbox-custom-label" style="margin-right: 28px;"><span class="kinfo"><?php echo __("admin/automation/settings-ticket-close-status-info"); ?></span></label>
                                </div>
                            </div>

                            <div class="formcon" id="ticket-close-day-wrap"<?php echo $crons["tasks"]["ticket-close"]["status"] ? '' : ' style="display:none;"'; ?>>
                                <div class="yuzde30"><?php echo __("admin/automation/settings-ticket-close-day"); ?></div>
                                <div class="yuzde70">
                                    <input class="crongroupinput" onkeypress="return event.charCode>= 48 &amp;&amp;event.charCode<= 57" name="ticket-close[day]" type="text" value="<?php echo $crons["tasks"]["ticket-close"]["settings"]["day"]; ?>">
                                    <span class="kinfo"><?php echo __("admin/automation/settings-ticket-close-day-info"); ?></span>
                                </div>
                            </div>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/automation/settings-ticket-lock-status"); ?></div>
                                <div class="yuzde70">
                                    <input<?php echo $crons["tasks"]["ticket-lock"]["status"] ? ' checked' : ''; ?> id="ticket-lock-status" class="checkbox-custom" name="ticket-lock[status]" value="1" type="checkbox" onchange="if($(this).prop('checked')) $('#ticket-lock-day-wrap').slideDown(300); else $('#ticket-lock-day-wrap').slideUp(300);">
                                    <label for="ticket-lock-status" class="checkbox-custom-label" style="margin-right: 28px;"><span class="kinfo"><?php echo __("admin/automation/settings-ticket-lock-status-info"); ?></span></label>
                                </div>
                            </div>


                            <div class="formcon" id="ticket-lock-day-wrap"<?php echo $crons["tasks"]["ticket-lock"]["status"] ? '' : ' style="display:none;"'; ?>>
                                <div class="yuzde30"><?php echo __("admin/automation/settings-ticket-lock-day"); ?></div>
                                <div class="yuzde70">
                                    <input class="crongroupinput" onkeypress="return event.charCode>= 48 &amp;&amp;event.charCode<= 57" name="ticket-lock[day]" type="text" value="<?php echo $crons["tasks"]["ticket-lock"]["settings"]["day"]; ?>">
                                    <span class="kinfo"><?php echo __("admin/automation/settings-ticket-lock-day-info"); ?></span>
                                </div>
                            </div>

                            <div class="clear"></div>
                        </div>
                    </div>

                    <div class="crongroup">
                        <div class="padding30">
                            <h4><?php echo __("admin/automation/settings-other-settings"); ?></h4>

                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/automation/settings-clear-logs-status"); ?></div>
                                <div class="yuzde70">
                                    <input<?php echo $crons["tasks"]["clear-logs"]["status"] ? ' checked' : ''; ?> id="clear-logs-status" class="checkbox-custom" name="clear-logs[status]" value="1" type="checkbox" onchange="if($(this).prop('checked')) $('#clear-logs-day-wrap').slideDown(300); else $('#clear-logs-day-wrap').slideUp(300);">
                                    <label for="clear-logs-status" class="checkbox-custom-label" style="margin-right: 28px;"><span class="kinfo"><?php echo __("admin/automation/settings-clear-logs-status-info"); ?></span></label>
                                </div>
                            </div>

                            <div class="formcon" id="clear-logs-day-wrap"<?php echo $crons["tasks"]["clear-logs"]["status"] ? '' : ' style="display:none;"'; ?>>
                                <div class="yuzde30"><?php echo __("admin/automation/settings-clear-logs-day"); ?></div>
                                <div class="yuzde70">
                                    <input class="crongroupinput" onkeypress="return event.charCode>= 48 &amp;&amp;event.charCode<= 57" name="clear-logs[day]" type="text" value="<?php echo $crons["tasks"]["clear-logs"]["settings"]["day"]; ?>">
                                    <span class="kinfo"><?php echo __("admin/automation/settings-clear-logs-day-info"); ?></span>
                                </div>
                            </div>


                            <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/automation/settings-unverified-accounts-deletion"); ?>
                                    <a style="font-weight:normal;width:180px;" href="#!" data-tooltip="<?php echo __("admin/automation/settings-unverified-accounts-deletion-info"); ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
                                    <br><span class="kinfo"><?php echo __("admin/automation/settings-inactive-info"); ?></span>
                                </div>
                                <div class="yuzde70">
                                    <input class="crongroupinput" onkeypress="return event.charCode>= 48 &amp;&amp;event.charCode<= 57" name="unverified-accounts-deletion[day]" type="text" value="<?php echo $crons["tasks"]["unverified-accounts-deletion"]["settings"]["day"]; ?>">
                                    <span class="kinfo"><?php echo __("admin/automation/settings-unverified-accounts-deletion-day-info"); ?></span>
                                </div>
                            </div>


                             <div class="formcon">
                                <div class="yuzde30"><?php echo __("admin/automation/settings-non-order-accounts-deletion"); ?>
                                    <br><span class="kinfo"><?php echo __("admin/automation/settings-inactive-info"); ?></span>
                                </div>
                                <div class="yuzde70">
                                    <input class="crongroupinput" onkeypress="return event.charCode>= 48 &amp;&amp;event.charCode<= 57" name="non-order-accounts-deletion[day]" type="text" value="<?php echo $crons["tasks"]["non-order-accounts-deletion"]["settings"]["day"]; ?>">
                                    <span class="kinfo"><?php echo __("admin/automation/settings-non-order-accounts-deletion-day-info"); ?></span>
                                </div>
                            </div>



                            <div class="clear"></div>
                        </div>
                    </div>


                    <div class="clear"></div>

                    <div style="float:right;margin-top:10px;" class="guncellebtn yuzde30">
                        <a class="yesilbtn gonderbtn" id="settingsForm_submit" href="javascript:void(0);"><?php echo ___("needs/button-update"); ?></a>
                    </div>
                    <div class="clear"></div>

                </form>
                <script type="text/javascript">
                    $(document).ready(function(){
                        $("#settingsForm_submit").on("click",function(){
                            MioAjaxElement($(this),{
                                waiting_text: '<?php echo ___("needs/button-waiting"); ?>',
                                progress_text: '<?php echo ___("needs/button-uploading"); ?>',
                                result:"settingsForm_handler",
                            });
                        });
                    });

                    function settingsForm_handler(result){
                        if(result != ''){
                            var solve = getJson(result);
                            if(solve !== false){
                                if(solve.status == "error"){
                                    if(solve.for != undefined && solve.for != ''){
                                        $("#settingsForm "+solve.for).focus();
                                        $("#settingsForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                        $("#settingsForm "+solve.for).change(function(){
                                            $(this).removeAttr("style");
                                        });
                                    }
                                    if(solve.message != undefined && solve.message != '')
                                        alert_error(solve.message,{timer:5000});
                                }else if(solve.status == "successful"){
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
                </script>

            </div>


        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>