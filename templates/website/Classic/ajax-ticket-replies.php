<?php defined('CORE_FOLDER') OR exit('You can not get in here!');
    if(isset($replies) && is_array($replies)){
        foreach ($replies as $reply) {
            $message    = $reply["message"];
            if(!Validation::isHTML($message)) $message = nl2br($message);
            $message    = Filter::link_convert($message,true);

            if($reply["admin"]==1){
                ?>
                <div class="<?php echo $get_last_reply_id > 0 ? 'new-reply ' : ''; ?>destekdetaymsj" id="yetkilimsj">
                    <div class="destekdetaymsjcon">
                        <div class="msjyazan">

                            <h4><?php echo $reply["name"]; ?> <span><?php echo __("website/account_tickets/authorized"); ?></span></h4><h5><?php echo UserManager::formatTimeZone($reply["ctime"],$zone,Config::get("options/date-format")." - H:i"); ?></h5>
                        </div><div class="clear"></div>
                        <div class="reply-message"><?php echo $message; ?>
                            <div class="clear"></div>

                            <?php
                                if($reply["encrypted"])
                                {
                                    ?>
                                    <div class="securemsj"><i title="<?php echo __("website/account_tickets/encrypt-message-3"); ?>" class="fa fa-shield" aria-hidden="true"></i></div>
                                    <?php
                                }
                            ?>

                            <div class="ticket-attachment-file">
                                <?php
                                    if($reply["attachments"] && is_array($reply["attachments"])){
                                        ?>
                                        <strong><?php echo __("website/account_tickets/file-attachments"); ?></strong><br>
                                        <?php
                                        foreach($reply["attachments"] AS $attachment){
                                            ?>

                                            <a href="<?php echo $attachment["link"]; ?>" target="_blank"><i class="fa fa-cloud-download" aria-hidden="true"></i> <?php echo $attachment["file_name"]; ?></a>

                                            <div class="clear"></div>
                                            <?php
                                        }
                                    }
                                ?>
                            </div>
                            <div class="clear"></div>
                        </div></div>
                </div>
                <?php
            }else{
                ?>
                <div class="<?php echo $reply["admin"] && $get_last_reply_id > 0 ? 'new-reply ' : ''; ?>destekdetaymsj">
                    <div class="destekdetaymsjcon">
                        <div class="msjyazan">
                            <h4><?php echo $reply["name"]; ?> <span><?php echo __("website/account_tickets/customer"); ?></span></h4><h5><?php echo UserManager::formatTimeZone($reply["ctime"],$zone,Config::get("options/date-format")." - H:i"); ?></h5>
                        </div><div class="clear"></div>
                        <div class="reply-message"><?php echo $message; ?>
                            <div class="clear"></div>
                            <?php
                                if($reply["encrypted"])
                                {
                                    ?>
                                    <div class="securemsj"><i title="<?php echo __("website/account_tickets/encrypt-message-3"); ?>" class="fa fa-shield" aria-hidden="true"></i></div>
                                    <?php
                                }
                            ?>
                            <div class="ticket-attachment-file">
                                <?php if(isset($reply["attachments"]) && $reply["attachments"]): ?>
                                    <a class="ticket-attachment-file"><i class="fa fa-cloud-download" aria-hidden="true"></i> <?php echo __("website/account_tickets/file-attached"); ?></a>

                                <?php endif; ?>
                            </div>
                            <div class="clear"></div>
                        </div></div>
                </div>
                <?php
            }
        }
    }
?>
<script type="text/javascript">
    $(document).ready(function(){
        $('.new-reply').animate({opacity: 1}, 2000);
    });
</script>