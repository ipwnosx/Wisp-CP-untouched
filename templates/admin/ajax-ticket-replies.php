<?php
    if(isset($replies) && $replies){

        $privOperation  = Admin::isPrivilege("TICKETS_OPERATION");
        $privDelete     = Admin::isPrivilege("TICKETS_DELETE");
        $privOrder      = Admin::isPrivilege("ORDERS_LOOK");
        $privUser       = Admin::isPrivilege("USERS_LOOK");

        foreach($replies AS $k=>$reply){
            $message    = $reply["message"];
            if(!Validation::isHTML($message)) $message = nl2br($message);
            $message    = Filter::link_convert($message,true);

            ?>
            <div class="<?php echo !$reply["admin"] && $get_last_reply_id > 0 ? 'new-reply ' : ''; ?>destekdetaymsj reply-item-<?php echo $reply["id"]; ?>"<?php echo $reply["admin"] ? ' id="yetkilimsj"' : ''; ?>>
                <div class="destekdetaymsjcon" id="Reply<?php echo $reply["id"]; ?>">
                    <div class="msjyazan">
                        <h4>
                            <?php echo $reply["name"]; ?>

                            <?php if($reply["admin"]): ?>
                                <span><?php echo __("admin/tickets/request-detail-reply-admin"); ?></span>
                            <?php else: ?>
                                <span><?php echo __("admin/tickets/request-detail-reply-user"); ?></span>
                            <?php endif; ?>

                            <?php if($privOperation): ?>
                                <a class="ticketeditbtn" href="javascript:editReply(<?php echo $reply["id"]; ?>);void 0;"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i> <?php echo __("admin/tickets/request-detail-button-edtreply"); ?></a>
                            <?php endif; ?>

                            <?php if($privDelete): ?>
                                <a class="ticketdelbtn" href="javascript:deleteReply(<?php echo $reply["id"]; ?>);void 0;"> <i class="fa fa-trash-o" aria-hidden="true"></i> <?php echo __("admin/tickets/request-detail-button-delreply"); ?></a>
                            <?php endif; ?>

                            <span class="ticketsip">IP: <a style="text-decoration:underline;" referrerpolicy="no-referrer" href="https://check-host.net/ip-info?host=<?php echo $reply["ip"]; ?>" target="_blank"><?php echo $reply["ip"]; ?></a></span>

                        </h4>
                        <h5><?php echo DateManager::format(Config::get("options/date-format")." - H:i",$reply["ctime"]); ?></h5>
                    </div>
                    <div class="clear"></div>
                    <div class="reply-message"><?php echo $message; ?></div>
                    <div class="clear"></div>
                    <div style="display: none;" id="editReply_<?php echo $reply["id"]; ?>">
                        <textarea class="tinymce-1" id="editReply_<?php echo $reply["id"]; ?>_msg"></textarea>
                        <div class="clear"></div>
                        <div style="float:right;margin-top:7px;margin-bottom:40px;">
                            <a href="javascript:void(0);" class="red lbtn edit-btn-cancel"><?php echo __("admin/tickets/button-cancel"); ?></a>
                            <a href="javascript:void(0);" class="blue lbtn edit-btn-ok"><?php echo __("admin/tickets/button-save"); ?></a>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <?php
                        if($reply["attachments"]){
                            ?>
                            <div class="ticketattachments">
                                <?php
                                    foreach($reply["attachments"] AS $attachment){
                                        $link = Controllers::$init->AdminCRLink("download-id",["reply-attachment",$attachment["id"]]);
                                        ?>
                                        <a href="<?php echo $link; ?>" data-balloon-pos="right" data-balloon="<?php echo __("admin/tickets/request-detail-button-rply-atch"); ?>" target="_blank"><i class="fa fa-cloud-download" aria-hidden="true"></i> <?php echo Utility::short_text($attachment["file_name"],0,100,true); ?></a>
                                        <div class="clear"></div>
                                        <?php
                                    }
                                ?>
                            </div>
                            <?php

                        }
                    ?>

                    <?php
                        if($reply["encrypted"])
                        {
                            ?>
                            <div class="securemsj"><i title="<?php echo __("website/account_tickets/encrypt-message-3"); ?>" class="fa fa-shield" aria-hidden="true"></i></div>
                            <?php
                        }
                    ?>

                    <div class="goruldu">
                        <?php if($k == 0 && $reply["admin"]): ?>
                            <?php if($ticket["userunread"]): ?>
                                <i title="<?php echo htmlentities(__("admin/tickets/request-detail-user-viewed"),ENT_QUOTES); ?>" class="ion-android-done-all"></i>
                            <?php else: ?>
                                <i title="<?php echo htmlentities(__("admin/tickets/request-detail-user-unviewed"),ENT_QUOTES); ?>" class="gorulmedi ion-android-done-all"></i>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>

                    <div class="clear"></div>
                </div>
            </div>
            <?php
        }
    }
?>

<script type="text/javascript">
    $(document).ready(function(){
        if(!device_mobile){
            tinymce_init('.tinymce-1');
        }
        $('.new-reply').animate({opacity: 1}, 2000);
    });
</script>