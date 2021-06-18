<?php
    if(!defined("CORE_FOLDER")) die();
    $LANG       = $module->lang;
    $CONFIG     = $module->config;
    $images_url = RESOURCE_DIR."uploads".DS."modules".DS."Payment".DS."BankTransfer".DS;
    $lang_list  = Bootstrap::$lang->rank_list();
    Utility::sksort($lang_list,"local");

?>

<form action="<?php echo Controllers::$init->getData("links")["controller"]; ?>" method="post" id="BankTransfer" enctype="multipart/form-data">
    <input type="hidden" name="operation" value="module_controller">
    <input type="hidden" name="module" value="BankTransfer">
    <input type="hidden" name="controller" value="settings">

    <ul class="banktransfer-lang">
        <?php
            foreach($lang_list AS $k=>$lang) {
                $lkey = $lang["key"];
                ?>
                <li><a<?php echo $lang["local"] ? ' id="banktransfer-lang-active"' : ''; ?> href="javascript:banktransfer_open_lang_tab('<?php echo $lkey; ?>');" data-lang="<?php echo $lkey; ?>"><?php echo strtoupper($lkey); ?></a></li>
                <?php
            }
        ?>
    </ul>

    <?php
        foreach($lang_list AS $k=>$lang) {
            $lkey = $lang["key"];

            $accounts   = dirname(__DIR__).DS."bank-accounts-".$lkey.".json";
            $accounts   = FileManager::file_read($accounts);
            if($accounts) $accounts   = Utility::jdecode($accounts,true);
            else $accounts = [];
            ?>
            <div id="banktransfer-<?php echo $lkey; ?>" class="banktransfer-lang-content" <?php echo $k == 0 ? '' : 'style="display: none;"'; ?>>

                <div class="deleted" style="display:none;"></div>

                <div class="clear"></div>

                <div class="empty-account" id="empty-account-<?php echo $lkey; ?>" style="<?php echo $accounts ? 'display:none;' : ''; ?>">
                    <div class="padding20">
                        <i class="fa fa-info-circle" aria-hidden="true"></i><br>
                        <?php echo $LANG["empty-account"]; ?>
                    </div>
                </div>
                <ul class="accounts">
                    <?php
                        foreach ($accounts AS $account){
                            $image  = NULL;
                            if($account["image"]) $image  = Utility::image_link_determiner($account["image"],$images_url);
                            if(!$image) $image  = Utility::image_link_determiner("default.jpg",$images_url);
                            ?>
                            <li style="background:#FFFFFF;" data-id="<?php echo $account["id"]; ?>" data-lang="<?php echo $lkey; ?>">
                                <input type="hidden" name="type[<?php echo $lkey; ?>][<?php echo $account["id"]; ?>]" value="current">
                                <div class="formcon">

                                    <div class="delmovebtns">
                                    <a style="cursor:move;" class="bearer"><i class="fa fa-arrows-alt"></i></a>
                                    <a href="javascript:void(0);" data-id="<?php echo $account["id"]; ?>" data-lang="<?php echo $lkey; ?>" class="delete-faq-item delete-account"><i class="fa fa-trash"></i></a>
                                   </div>

                                    <div class="yuzde30"><?php echo $LANG["account-status"]; ?></div>
                                    <div class="yuzde60">
                                        <input<?php echo $account["status"] ? ' checked' : ''; ?> type="checkbox" class="sitemio-checkbox" id="<?php echo $lkey; ?>-account_status_<?php echo $account["id"]; ?>" value="1" name="status[<?php echo $lkey; ?>][<?php echo $account["id"]; ?>]">
                                        <label for="<?php echo $lkey; ?>-account_status_<?php echo $account["id"]; ?>" class="sitemio-checkbox-label"></label>
                                    </div>


                                    <div class="yuzde30"><?php echo $LANG["account-name"]; ?></div>
                                    <div class="yuzde60">
                                        <input type="text" name="name[<?php echo $lkey; ?>][<?php echo $account["id"]; ?>]" value="<?php echo $account["name"]; ?>">
                                    </div>

                                    <div class="yuzde30"><?php echo $LANG["account-swift"]; ?></div>
                                    <div class="yuzde60">
                                        <input type="text" name="swiftc[<?php echo $lkey; ?>][<?php echo $account["id"]; ?>]" value="<?php echo isset($account["swiftc"]) ? $account["swiftc"] : ''; ?>">
                                    </div>


                                    <div class="yuzde30"><?php echo $LANG["account-iban"]; ?></div>
                                    <div class="yuzde60">
                                        <input type="text" name="iban[<?php echo $lkey; ?>][<?php echo $account["id"]; ?>]" value="<?php echo $account["iban"]; ?>">
                                    </div>

                                    <div class="yuzde30"><?php echo $LANG["account-number"]; ?></div>
                                    <div class="yuzde60">
                                        <input type="text" name="account_number[<?php echo $lkey; ?>][<?php echo $account["id"]; ?>]" value="<?php echo $account["account_number"]; ?>">
                                    </div>

                                    <div class="yuzde30"><?php echo $LANG["account-buyer-name"]; ?></div>
                                    <div class="yuzde60">
                                        <input type="text" name="buyer_name[<?php echo $lkey; ?>][<?php echo $account["id"]; ?>]" value="<?php echo $account["buyer_name"]; ?>">
                                    </div>

                                    <div class="yuzde30"><?php echo $LANG["account-branch-nc"]; ?></div>
                                    <div class="yuzde60">
                                        <input type="text" name="branch_nc[<?php echo $lkey; ?>][<?php echo $account["id"]; ?>]" value="<?php echo $account["branch_nc"]; ?>">
                                    </div>

                                    <div class="yuzde30"><?php echo $LANG["account-image"]; ?></div>
                                    <div class="yuzde60">
                                        <img src="<?php echo $image; ?>" width="100" id="<?php echo $lkey; ?>-acpreview_<?php echo $account["id"]; ?>">
                                        <input type="file" name="<?php echo $lkey; ?>-image-<?php echo $account["id"]; ?>" onchange="read_image_file(this,'<?php echo $lkey; ?>-acpreview_<?php echo $account["id"]; ?>')">
                                    </div>


                                </div>
                            </li>
                            <?php
                        }
                    ?>
                </ul>

                <div class="clear"></div>
                <br>
                <a href="javascript:addAccount('<?php echo $lkey; ?>');" class="lbtn"><i class="fa fa-plus"></i> <?php echo $LANG["add-account"]; ?></a>
                <div class="clear"></div>


                <div class="clear"></div>
            </div>
            <?php
        }
    ?>

    <div class="clear"></div>

    <div style="float:right;" class="guncellebtn yuzde30"><a id="BankTransfer_submit" href="javascript:void(0);" class="yesilbtn gonderbtn"><?php echo $LANG["save-button"]; ?></a></div>

</form>


<ul id="account-item-template" style="display: none;">
    <li style="background:#FFFFFF;" data-id="{id}" data-lang="{lang}">
        <input type="hidden" name="type[{lang}][{id}]" value="new">
        <div class="formcon">

            <div class="delmovebtns">
            <a style="cursor:move;" class="bearer"><i class="fa fa-arrows-alt"></i></a>
            <a href="javascript:void(0);" class="delete-account delete-faq-item" data-id="{id}"><i class="fa fa-trash"></i></a>
            </div>

            
            <div class="yuzde30"><?php echo $LANG["account-status"]; ?></div>
            <div class="yuzde60">
                <input checked type="checkbox" class="sitemio-checkbox" id="{lang}-account_status_{id}" value="1" name="status[{lang}][{id}]">
                <label for="{lang}-account_status_{id}" class="sitemio-checkbox-label"></label>
            </div>


            <div class="yuzde30"><?php echo $LANG["account-name"]; ?></div>
            <div class="yuzde60">
                <input type="text" name="name[{lang}][{id}]" value="">
            </div>

            <div class="yuzde30"><?php echo $LANG["account-swift"]; ?></div>
            <div class="yuzde60">
                <input type="text" name="swiftc[{lang}][{id}]" value="">
            </div>

            <div class="yuzde30"><?php echo $LANG["account-iban"]; ?></div>
            <div class="yuzde60">
                <input type="text" name="iban[{lang}][{id}]" value="">
            </div>

            <div class="yuzde30"><?php echo $LANG["account-number"]; ?></div>
            <div class="yuzde60">
                <input type="text" name="account_number[{lang}][{id}]" value="">
            </div>

            <div class="yuzde30"><?php echo $LANG["account-buyer-name"]; ?></div>
            <div class="yuzde60">
                <input type="text" name="buyer_name[{lang}][{id}]" value="">
            </div>

            <div class="yuzde30"><?php echo $LANG["account-branch-nc"]; ?></div>
            <div class="yuzde60">
                <input type="text" name="branch_nc[{lang}][{id}]" value="">
            </div>

            <div class="yuzde30"><?php echo $LANG["account-image"]; ?></div>
            <div class="yuzde60">
                <img src="<?php echo Utility::image_link_determiner("default.jpg",$images_url); ?>" width="100" id="{lang}-acpreview_{id}">
                <input type="file" name="{lang}-image-{id}" onchange="read_image_file(this,'{lang}-acpreview_{id}')">
            </div>

        </div>
    </li>
</ul>

<style type="text/css">
    .account-highlight {background: #FFFFFF; min-height:380px;}
</style>
<script type="text/javascript">
    var accounts = $(".accounts");
    $(document).ready(function(){

        accounts.sortable({
            placeholder: "account-highlight",
            handle:".bearer",
        }).disableSelection();

        $("#BankTransfer_submit").click(function(){
            MioAjaxElement($(this),{
                waiting_text:waiting_text,
                progress_text:progress_text,
                result:"BankTransfer_handler",
            });
        });

        $('.accounts').on('click', 'a.delete-account', function(events){
            var li      = $(this).parent().parent().parent();
            var id      = li.data("id");
            var lang    = li.data("lang");

            var type    = $("input[type='hidden']:eq(0)",li).val();
            if(type == "current") $("#banktransfer-"+lang+" .deleted").append('<input type="hidden" name="deleted['+lang+'][]" value="'+id+'">');
            li.remove();

            var count   = $("#banktransfer-"+lang+" .accounts li").length;
            if(count == 0 || count == '' || count == undefined){
                $("#empty-account-"+lang).css("display","block");
            }
            accounts.sortable("refresh");

        });
    });

    function addAccount(lang) {
        var template = $("#account-item-template").html();
        var lastID   = $("#banktransfer-"+lang+" .accounts li:last-child").data("id");
        if(lastID == undefined || !lastID) lastID = 0;
        var loop     = true;
        while(loop){
            if($("#banktransfer-"+lang+" .accounts li[data-id='"+lastID+"']").length == 0) loop = false;
            else lastID++;
        }
        var newID    = lastID;

        template = template.replace(/{id}/g,newID);
        template = template.replace(/{lang}/g,lang);

        $("#banktransfer-"+lang+" .accounts").append(template);

        accounts.sortable("refresh");

        $("#empty-account-"+lang).css("display","none");
    }

    function banktransfer_open_lang_tab(lang){
        $(".banktransfer-lang li a").removeAttr("id");
        $(".banktransfer-lang-content").css("display","none");
        $("#banktransfer-"+lang).css("display","block");
        $(".banktransfer-lang li a[data-lang="+lang+"]").attr("id","banktransfer-lang-active");
    }

    function BankTransfer_handler(result){
        if(result != ''){
            var solve = getJson(result);
            if(solve !== false){
                if(solve.status == "error"){
                    if(solve.for != undefined && solve.for != ''){
                        $("#BankTransfer "+solve.for).focus();
                        $("#BankTransfer "+solve.for).attr("style","border-bottom:2px solid red; color:red;");
                        $("#BankTransfer "+solve.for).change(function(){
                            $(this).removeAttr("style");
                        });
                    }
                    if(solve.message != undefined && solve.message != '')
                        alert_error(solve.message,{timer:5000});
                }else if(solve.status == "successful"){
                    $("#accounts li input[type='hidden']:eq(0)").val("current");
                    $("#deleted").html('');
                    alert_success(solve.message,{timer:2500});
                }
            }else
                console.log(result);
        }
    }
</script>