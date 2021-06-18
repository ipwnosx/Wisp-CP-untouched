<?php 
    defined('CORE_FOLDER') OR exit('You can not get in here!');
    $hoptions = ['select2']; 
?>
<script type="text/javascript">
        $(document).ready(function(){
            $(".select2-element").select2();
        });
    </script>
<div class="mpanelrightcon">

    <div class="mpaneltitle">
        <div class="sayfayolu"><?php include $tpath."inc".DS."panel-breadcrumb.php"; ?></div>
        <h4><strong><i class="fa fa-life-ring" aria-hidden="true"></i> <?php echo __("website/account_tickets/page-creq-title"); ?></strong></h4>
    </div>

    <div class="destektalebiolustur">

        <form action="<?php echo $links["controller"]; ?>" method="post" id="CreateRequestForm" enctype="multipart/form-data">
            <?php echo Validation::get_csrf_token('account'); ?>

            <?php
                if($h_contents = Hook::run("TicketClientAreaViewCreate"))
                    foreach($h_contents AS $h_content) if($h_content) echo  $h_content;
            ?>

            <div class="ticketinfos">

                <input name="title" type="text" placeholder="<?php echo __("website/account_tickets/creq-title"); ?>">

                <select name="department" id="SelectDepartment">
                    <option value=""><?php echo __("website/account_tickets/department"); ?></option>
                    <?php
                        if(isset($departments) && is_array($departments)){
                            foreach($departments AS $department){
                                ?>
                                <option value="<?php echo $department["id"]; ?>"><?php echo $department["name"];?></option>
                                <?php
                            }
                        }
                    ?>
                </select>

                <select name="service" class="select2-element">
                    <option value=""><?php echo __("website/account_tickets/service"); ?></option>
                    <?php
                        if(isset($services) && $services){
                            foreach($services AS $group){
                                ?>
                                <optgroup label="<?php echo $group["name"]; ?>">
                                    <?php
                                        foreach($group["items"] AS $row){
                                            ?>
                                            <option<?php echo isset($service) && $service["id"] == $row["id"] ? ' selected' : ''; ?> value="<?php echo $row["id"]; ?>"><?php echo $row["name"]; ?></option>
                                            <?php
                                        }
                                    ?>
                                </optgroup>
                                <?php
                            }
                        }
                    ?>
                    <option value=""><?php echo __("website/account_tickets/none"); ?></option>
                </select>

                <select name="priority" >
                    <option value=""><?php echo __("website/account_tickets/priority"); ?></option>
                    <option value="1"><?php echo __("website/account_tickets/priority-low"); ?></option>
                    <option value="2"><?php echo __("website/account_tickets/priority-middle"); ?></option>
                    <option value="3"><?php echo __("website/account_tickets/priority-high"); ?></option>
                </select>
            </div>

            <div class="ticketdetail">
                <textarea name="message" cols="" rows="7" placeholder="<?php echo __("website/account_tickets/message-placeholder"); ?>"></textarea>

                <div id="ticketCustomFields" style="display: none;">
                    <div class="ticketCustomFields-con">
                        <div class="blue-info">
                           <div class="padding20">
                                <i class="fa fa-lock" aria-hidden="true"></i>
                                <p><?php echo __("website/account_tickets/custom-fields-info"); ?></p>
                            </div>
                        </div>
                        <?php
                            if(isset($custom_fields) && $custom_fields){
                                foreach($custom_fields AS $field){
                                    $options    = $field["options"];
                                    $properties = $field["properties"];
                                    $wrap_invisible  = false;

                                    if($options) $options = Utility::jdecode($options,true);
                                    if($properties) $properties = Utility::jdecode($properties,true);
                                    if(isset($properties["wrap_visibility"]) && $properties["wrap_visibility"] == "invisible")
                                        $wrap_invisible = 'style="display:none;"';
                                    ?>
                                    <div class="department-<?php echo $field["did"]; ?>-field department-fields" id="field-<?php echo $field["id"]; ?>-wrap" <?php echo $wrap_invisible; ?>>
                                        <div class="yuzde30">
                                            <?php if(isset($properties["compulsory"]) && $properties["compulsory"]){ ?><span class="zorunlu">*</span><?php } ?>
                                            <label for="field-<?php echo $field["id"]; ?>">
                                                <strong><?php echo $field["name"]; ?></strong>

                                            </label>
                                        </div>
                                        <div class="yuzde70">
                                            <?php
                                                if($field["type"] == "input"){
                                                    ?>
                                                    <input type="text" name="fields[<?php echo $field["id"]; ?>]" id="field-<?php echo $field["id"]; ?>" placeholder="<?php if($field["description"]): ?><?php echo nl2br($field["description"]); ?><?php endif; ?>">
                                                    <?php
                                                }
                                                elseif($field["type"] == "textarea"){
                                                    ?>
                                                    <textarea name="fields[<?php echo $field["id"]; ?>]" id="field-<?php echo $field["id"]; ?>" placeholder="<?php if($field["description"]): ?><?php echo nl2br($field["description"]); ?><?php endif; ?>"></textarea>
                                                    <?php
                                                }
                                                elseif($field["type"] == "radio"){
                                                    foreach ($options AS $k=>$opt){
                                                        ?>
                                                        <input id="field-<?php echo $field["id"]."-".$k; ?>" class="radio-custom" name="fields[<?php echo $field["id"]; ?>]" value="<?php echo $opt["id"]; ?>" type="radio">
                                                        <label style="margin-right:30px;" for="field-<?php echo $field["id"]."-".$k; ?>" class="radio-custom-label"><span class="checktext"><?php echo $opt["name"]; ?></span></label>
                                                        <br>
                                                        <?php
                                                    }
                                                }
                                                elseif($field["type"] == "checkbox"){
                                                    foreach ($options AS $k=>$opt){
                                                        ?>
                                                        <input id="field-<?php echo $field["id"]."-".$k; ?>" class="checkbox-custom" name="fields[<?php echo $field["id"]; ?>][]" value="<?php echo $opt["id"]; ?>" type="checkbox">
                                                        <label style="margin-right:30px;" for="field-<?php echo $field["id"]."-".$k; ?>" class="checkbox-custom-label"><span class="checktext"><?php echo $opt["name"]; ?></span></label>
                                                        <br>
                                                        <?php
                                                    }
                                                }
                                                elseif($field["type"] == "select"){
                                                    ?>
                                                    <select name="fields[<?php echo $field["id"]; ?>]" id="field-<?php echo $field["id"]; ?>">
                                                        <option value=""><?php echo __("website/osteps/select-your-option"); ?></option>
                                                        <?php
                                                            foreach ($options AS $k=>$opt){
                                                                ?>
                                                                <option value="<?php echo $opt["id"]; ?>"><?php echo $opt["name"]; ?></option>
                                                                <?php
                                                            }
                                                        ?>
                                                    </select>
                                                    <?php
                                                }
                                                elseif($field["type"] == "file"){
                                                    ?>
                                                    <input type="file" name="field-<?php echo $field["id"]; ?>[]" id="field-<?php echo $field["id"]; ?>" multiple>
                                                    <?php
                                                }

                                                if(isset($properties["define_end_of_element"]))
                                                    if($properties["define_end_of_element"])
                                                        echo $properties["define_end_of_element"];
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                        ?>
                    </div>
                </div>

                <div class="clear"></div>

                <div class="destekdosyaeki">
                    <label><?php echo __("website/account_tickets/upload-attachment"); ?>: <input name="attachments[]" multiple type="file"><br>
                        <span style="font-size:13px;"><?php echo __("website/account_tickets/attachment-allowed-extensions",['{extensions}' => $atachment_extensions]); ?></span></label>
                    </div>

                <style type="text/css">
                    #encrypt_message_wrap .checkbox-custom+.checkbox-custom-label:before,.radio-custom+.radio-custom-label:before{content:'\f13e';font-family:'FontAwesome';padding:0px;font-size: 17px;border:none;margin-right: 3px;opacity: .3;}
                    #encrypt_message_wrap .checkbox-custom:checked+.checkbox-custom-label:before{content:"\f023";font-family:'FontAwesome';color:#8BC34A;font-size:17px;background:none;border:none;opacity: 1;}
                </style>

                <div class="ticketsendbtn" style="float:right;text-align:right;">
                    <div id="encrypt_message_wrap">
                        <input id="EncryptMessage" class="checkbox-custom" name="encrypt_message" value="1" type="checkbox">
                        <label for="EncryptMessage" class="checkbox-custom-label">
                            <span class="checktext"><strong><?php echo __("website/account_tickets/encrypt-message-1"); ?></strong></span><br><span class="kinfo"><?php echo __("website/account_tickets/encrypt-message-2"); ?></span></label>
                    </div>

                    <div class="clear"></div>
                    <a style="width:80%;text-align:center;" class="yesilbtn gonderbtn" id="SubmitTicketBtn" href="javascript:void(0);"><?php echo __("website/account_tickets/creg-button"); ?></a>

                </div>

            </div>


            <div id="FoundKnowloedgebase" style="display: none;">
                <div class="bilgibankasi">
                    <h5>

                        <strong style="color:#8bc34a;font-size:20px;"><i class="fa fa-info-circle" aria-hidden="true" style="font-size:60px;"></i><br><?php echo __("website/account_tickets/found-knowledgebase-text1"); ?></strong><br><?php echo __("website/account_tickets/found-knowledgebase-text2"); ?></h5>
                    <div id="list"></div>
                </div>

            </div>
        </form>

        <div id="CreateRequestForm_success" style="display:none;">
            <div style="margin-top:30px;margin-bottom:70px;text-align:center;">
                <i style="font-size:70px;" class="fa fa-check"></i>
                <h5><?php echo __("website/account_tickets/creq-has-been-created"); ?></h5>
                <br>
            </div>
        </div>
        <script type="text/javascript">
            function CreateRequestForm_submit(result) {
                if(result != ''){
                    var solve = getJson(result);
                    if(solve !== false){
                        if(solve.status == "error"){
                            if(solve.for != undefined && solve.for != ''){
                                $("#CreateRequestForm "+solve.for).focus();
                                $("#CreateRequestForm "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                                $("#CreateRequestForm "+solve.for).change(function(){
                                    $(this).removeAttr("style");
                                });
                            }

                            if(solve.message != undefined && solve.message != '')
                                alert_error(solve.message,{timer:3000});


                        }else if(solve.status == "successful"){
                            $("#CreateRequestForm").fadeOut(300,function(){
                                $("#CreateRequestForm_success").fadeIn(300);
                                setTimeout(function(){
                                    window.location.href = "<?php echo $links["my-tickets"]; ?>";
                                },1500);
                            });
                        }
                    }else
                        console.log(result);
                }
            }

            function change_department(){
                var el          = $("#SelectDepartment");
                var val         = el.val();

                if(val !== '' && document.getElementsByClassName("department-"+val+"-field").length>0){
                    $(".department-fields").css("display","none");
                    $(".department-" + val + "-field").css("display", "block");
                    $("#ticketCustomFields").slideDown(500);
                }else{
                    $(".department-fields").css("display","none");
                    $("#ticketCustomFields").slideUp(500);
                }
            }

            var kbase_found = false;

            $(document).ready(function(){
                var elem = $("input[name='title']");
                elem.keyup(function (e) {
                    var word = elem.val();
                    var size = word.length;
                    if(size>=3){
                        var request = MioAjax({
                            action: "<?php echo $links["controller"]; ?>?operation=foundKnowledgeBase",
                            method:"POST",
                            data:{"word":word}
                        },true,true);

                        request.done(function(result){
                            if(result != ''){
                                var solve = getJson(result);
                                if(solve !== false){
                                    if(solve.status == "found"){
                                        $("#FoundKnowloedgebase #list").html('');
                                        $("#FoundKnowloedgebase").fadeIn(100);
                                        var list = solve.data;
                                        $(list).each(function(index,elem){
                                            $("#FoundKnowloedgebase #list").append($('<a>', {
                                                target: "_blank",
                                                href: elem.route,
                                                text: elem.title,
                                                class:"btn",
                                            }));
                                        });

                                        if(!kbase_found){
                                            $("html, body").animate({ scrollTop: $('#FoundKnowloedgebase').offset().top},1000);
                                            kbase_found = true;
                                        }

                                    }else{
                                        $("#FoundKnowloedgebase").fadeOut(100);
                                        $("#FoundKnowloedgebase #list").html('');
                                    }
                                }
                            }
                        });
                    }else{
                        $("#FoundKnowloedgebase").fadeOut(100);
                        $("#FoundKnowloedgebase #list").html('');
                    }
                });

                change_department();

                $("#SelectDepartment").change(change_department);

                $("#SubmitTicketBtn").click(function(){
                    MioAjaxElement(this,{
                        "result":"CreateRequestForm_submit",
                        "waiting_text":"<?php echo addslashes(__("website/others/button1-pending")); ?>",
                        "progress_text":"<?php echo addslashes(__("website/others/button1-upload")); ?>",
                    });
                });

            });
        </script>

    </div>



    <div class="clear"></div>
</div>