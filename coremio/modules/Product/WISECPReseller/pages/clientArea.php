<?php
    $change_domain                  = isset($detail["change_domain"]) ? $detail["change_domain"] : false;
    $change_domain_limit            = isset($detail["change_domain_limit"]) ? $detail["change_domain_limit"] : '';
    $change_domain_used             = isset($detail["change_domain_used"]) ? $detail["change_domain_used"] : '';
    $change_domain_has_expired      = isset($detail["change_domain_has_expired"]) ? $detail["change_domain_has_expired"] : false;
    if($change_domain){
        ?>
        <div class="clear"></div>
        <div class="block_module_details" style="text-align:left;">
            <div class="hizmetblok" id="block_module_details_con">
                <div class="block_module_details-title formcon">
                    <h4><?php echo __("website/account_products/block-change-domain"); ?></h4>
                </div>

                <?php
                    if(isset($change_domain_limit) && strlen($change_domain_limit) > 0){
                        ?>
                        <div class="clear"></div>
                        <div class="formcon">
                            <div class="yuzde30"><?php echo __("website/account_products/limit-info"); ?></div>
                            <div class="yuzde70" style="color: #F44336;"><?php echo ($change_domain_limit - $change_domain_used); ?></div>
                        </div>
                        <div class="clear"></div>
                        <?php
                    }
                ?>

                <form action="<?php echo $module->area_link; ?>" method="post" id="changeDomainForm" onsubmit="$('#changeDomainForm_btn').click(); return false;" style="<?php echo $change_domain_has_expired ? 'display:none;' : ''; ?>">
                    <input type="hidden" name="action" value="use_method">
                    <input type="hidden" name="method" value="change_domain">

                    <div class="formcon">
                        <div class="yuzde30"><?php echo __("website/account_products/block-change-domain-define-new-domain"); ?></div>
                        <div class="yuzde70">
                            <input type="text" name="domain" placeholder="example.com">
                        </div>
                    </div>

                    <div class="clear"></div>
                    <a class="gonderbtn yesilbtn" href="javascript:void 0;" onclick=' MioAjaxElement($(this),{"result":"t_form_handle", "waiting_text":"<?php echo addslashes(__("website/others/button5-pending")); ?>"});'><?php echo ___("needs/button-apply"); ?></a>
                </form>


            </div>
        </div>
        <?php
    }
