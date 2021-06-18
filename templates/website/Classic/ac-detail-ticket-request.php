<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    $priorities = [
        0 => __("website/others/none"),
        1 => __("website/account_tickets/priority-low"),
        2 => __("website/account_tickets/priority-middle"),
        3 => __("website/account_tickets/priority-high"),
    ];
    $zone = User::getLastLoginZone();
?>
<style type="text/css">
    .new-reply{ opacity: 0;}
</style>
<script type="text/javascript">
    var last_reply_id = 0;
    var auto_save_msg_key = 'ticket_<?php echo $ticket["id"]; ?>';
    var awaiting_auto_saved=false;
    var user_is_typing='';

    function ReplyForm_submit(result){
        if(result != ''){
            var solve = getJson(result);
            if(solve !== false){
                if(solve.status == "error"){
                    if(solve.for != undefined && solve.for != ''){
                        $("#ReplyForm "+solve.for).focus();
                        $("#ReplyForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                        $("#ReplyForm "+solve.for).change(function(){
                            $(this).removeAttr("style");
                        });
                    }
                    if(solve.message != undefined && solve.message !== '') alert_error(solve.message,{timer:3000});

                }else if(solve.status == "successful"){
                    $("#attachment_files").val('');
                    alert_success("<?php echo htmlentities(__("website/account_tickets/reply-successful"),ENT_QUOTES); ?>",{timer:3000});
                    reply_toggle();
                }
            }else
                console.log(result);
        }

    }
    function get_replies(){
        if(windowActive !== "on") return false;
        var request = MioAjax({
            action:"<?php echo $links["controller"];?>",
            method:"POST",
            data:{
                operation:"get-replies",
                last_reply_id:last_reply_id,
                message: user_is_typing,
            },
        },true,true);
        request.done(function(result){
            if(result !== ''){
                user_is_typing = '';
                var solve = getJson(result);
                if(solve !== false){
                    if(solve.content !== undefined && solve.content !== ''){
                        $("#get_status").html(solve.status);
                        $("#get_lastreply").html(solve.lastreply);

                        setTimeout(function(){
                            $(".new-reply").removeClass('new-reply');
                        },5000);

                        if(last_reply_id > 0){
                            $("#detailTicketReplies").prepend(solve.content);
                            $("html, body").animate({ scrollTop: $("#detailTicketReplies").offset().top - 300},1000);
                        }
                        else{
                            $("#detailTicketReplies").animate({opacity:0}, 500,function(){
                                $("#detailTicketReplies").html(solve.content);
                                $("#detailTicketReplies").animate({opacity: 1}, 500);
                            });
                        }
                        last_reply_id = solve.last_reply_id;
                    }
                }
            }
        });
    }
    function reply_toggle(){
        var el = $('.ticketdetail');

        if(el.css("display") === "none"){
            el.slideDown();
        }else{
            el.slideUp();
            $("textarea[name=message]").val('');
            localStorage.removeItem(auto_save_msg_key);
        }
    }

    $(document).ready(function(){
        $("#ticket_solved_button").on("click",function(){
            var request = MioAjax({
                button_element:$(this),
                action:'<?php echo $links["controller"] ?>?stage=solved',
                method:"POST",
                waiting_text: "<?php echo addslashes(__("website/others/button1-pending")); ?>",
            },true,true);

            request.done(function(result){
                if(result != ''){
                    var solve = getJson(result);
                    if(solve !== false){

                        $(".ticketdetail").fadeOut(300,function(){
                            $("#Solved_success").fadeIn(300);
                            setTimeout(function(){
                                window.location.href = window.location.href;
                            },3000);
                        });

                    }else
                        console.log(result);
                }
            });
        });
        get_replies();
        setInterval(get_replies,3000);

        var auto_save_msg = localStorage.getItem(auto_save_msg_key);

        if(auto_save_msg !== undefined && auto_save_msg !== '' && auto_save_msg !== false && strip_tags(auto_save_msg) !== ''){
            $(".ticketdetail").css("display","block");
            $("textarea[name=message]").val(auto_save_msg);
        }


        $("textarea[name=message]").keyup(function(e){
            var value = $(this).val();
            user_is_typing = value;
            localStorage.setItem(auto_save_msg_key,value);
            var auto_saved_el = $("#auto_saved");
            if(!awaiting_auto_saved){
                awaiting_auto_saved = true;
                auto_saved_el.css("opacity","1").fadeIn(500,function(){
                    auto_saved_el.animate({opacity:0},{duration:3000,complete:function(){
                        auto_saved_el.css("display","none");
                        awaiting_auto_saved = false;
                    }});
                });
            }

        });

    });
    </script>
<div class="mpanelrightcon">

    <div class="mpaneltitle">
        <div class="sayfayolu"><?php include $tpath."inc".DS."panel-breadcrumb.php"; ?></div>
        <h4>
            <strong><i class="fa fa-life-ring" aria-hidden="true"></i> <?php echo $ticket["title"]; ?></strong>
            (#<?php echo $ticket["id"]; ?>)
        </h4>
    </div>

    <div class="clear"></div>
    <?php
        if($h_contents = Hook::run("TicketClientAreaViewDetailTop",$ticket))
            foreach($h_contents AS $h_content) if($h_content) echo  $h_content;
    ?>
    <div class="clear"></div>

    <div class="ticketinfos"<?php echo $ticket["locked"] ? ' id="ticketfixed"' : ''; ?>>
        <div align="center">
            <div class="destekinfo">
                <div class="destekinfocon">
                    <h5><strong><?php echo __("website/account_tickets/department"); ?></strong></h5>
                    <h4><?php echo isset($department) && is_array($department) ? $department["name"] : __("website/others/none"); ?></h4>
                </div>
            </div>

            <div class="destekinfo">
                <div class="destekinfocon">
                    <h5><strong><?php echo __("website/account_tickets/last-update"); ?></strong></h5>
                    <h4 id="get_lastreply"><?php echo UserManager::formatTimeZone($ticket["lastreply"],$zone,Config::get("options/date-format")." - H:i"); ?></h4>
                </div>
            </div>

            <div class="destekinfo">
                <div class="destekinfocon">
                    <h5><strong><?php echo __("website/account_tickets/status"); ?></strong></h5>
                    <h4 id="get_status"><?php echo $situations[$ticket["status"]]; ?></h4>
                </div>
            </div> 

            <div class="destekinfo">
                <div class="destekinfocon">
                    <h5><strong><?php echo __("website/account_tickets/priority"); ?></strong></h5>
                    <h4><?php echo $priorities[$ticket["priority"]]; ?></h4>
                </div>
            </div>

        </div>
    </div>

    <?php if(!$ticket["locked"]): ?>
        <div class="ticketstatusbtn">
            <?php if($ticket["status"] == 'solved'): ?>
                <a class="graybtn gonderbtn" style="opacity: 0.4;filter:alpha(opacity=40);"><?php echo __("website/account_tickets/status-solved"); ?></a>
            <?php else: ?>
                <a class="graybtn gonderbtn" id="ticket_solved_button" href="javascript:void(0);"><?php echo __("website/account_tickets/solved-button"); ?></a>
            <?php endif; ?>

            <a href="javascript:void 0;" onclick="reply_toggle();" class="mavibtn gonderbtn"><?php echo __("website/account_tickets/send-reply"); ?></a>

        </div>
    <?php endif; ?>

    <div class="ticketdetail" style="display:none;">
        <div class="destekdetayright" id="destekcvpyaz">
            <form action="<?php echo $links["controller"]; ?>?stage=reply" method="post" id="ReplyForm" enctype="multipart/form-data">
                <?php echo Validation::get_csrf_token('account'); ?>

                <textarea style="width:100%;border-top:1px solid #ebebeb;" name="message" cols="" rows="7" placeholder="<?php echo __("website/account_tickets/message-placeholder"); ?>"></textarea>
                <div class="autosave"> <span id="auto_saved" style="display: none;"><?php echo __("website/account_tickets/auto-saved"); ?></span></div>

                <div id="result" style="display: none;    float: left;    margin-bottom: 10px;    width: 100%;" class="error"></div>
                <div class="destekdosyaeki">
                    <label><?php echo __("website/account_tickets/upload-attachment"); ?>: <input name="attachments[]" type="file" multiple id="attachment_files"><span style="font-size:13px;"><?php echo __("website/account_tickets/attachment-allowed-extensions",['{extensions}' => $atachment_extensions]); ?></span></label></div>


                <div style="float:right;" class="yuzde40" class="guncellebtn yuzde30">

                    <style type="text/css">
                        #encrypt_message_wrap .checkbox-custom+.checkbox-custom-label:before,.radio-custom+.radio-custom-label:before{content:'\f13e';font-family:'FontAwesome';padding:0px;font-size: 17px;border:none;margin-right: 3px;opacity: .3;}
                        #encrypt_message_wrap .checkbox-custom:checked+.checkbox-custom-label:before{content:"\f023";font-family:'FontAwesome';color:#8BC34A;font-size:17px;background:none;border:none;opacity: 1;}
                    </style>

                    <div id="encrypt_message_wrap" style="text-align:right;">
                        <input id="EncryptMessage" class="checkbox-custom" name="encrypt_message" value="1" type="checkbox">
                        <label for="EncryptMessage" class="checkbox-custom-label">
                            <span class="checktext"><strong><?php echo __("website/account_tickets/encrypt-message-1"); ?></strong></span><br><span class="kinfo"><?php echo __("website/account_tickets/encrypt-message-2"); ?></span></label>
                    </div>

                   
                    <a style="width:100%;" class="yesilbtn gonderbtn mio-ajax-submit" mio-ajax-options='{"result":"ReplyForm_submit","waiting_text":"<?php echo addslashes(__("website/others/button1-pending")); ?>","progress_text":"<?php echo addslashes(__("website/others/button1-upload")); ?>"}' href="javascript:void(0);"><?php echo __("website/account_tickets/reply-button"); ?></a>
                </div>



            </form>
        </div>
    </div>

    <div class="clear"></div>
    <div id="Solved_success" style="display: none;">
        <div style="margin-top:30px;margin-bottom:70px;text-align:center;">
            <i style="font-size:80px;" class="fa fa-check"></i>
            <h4><?php echo __("website/account_tickets/solved-successful"); ?></h4>
            <br>
        </div>
    </div>

    <?php
        if($h_contents = Hook::run("TicketClientAreaViewDetail",$ticket))
            foreach($h_contents AS $h_content) if($h_content) echo  $h_content;
    ?>

    <div class="destekdetayleft" id="detailTicketReplies">

        <div align="center">
            <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
        </div>

    </div>

    <div class="clear"></div>
</div>