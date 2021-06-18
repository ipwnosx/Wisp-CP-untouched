<?php defined('CORE_FOLDER') OR exit('You can not get in here!'); ?>
<script type="text/javascript">
    var update_online_link  = "<?php echo Controllers::$init->CRLink("my-account"); ?>";
    var is_logged = <?php echo UserManager::LoginCheck("member") ? "true" : "false"; ?>;
    var warning_modal_title = "<?php echo ___("needs/warning-modal-title",['"' => '\"']); ?>";
    var success_modal_title = "<?php echo ___("needs/success-modal-title",['"' => '\"']); ?>";
<?php
    if(Config::get("options/cookie-policy/status"))
    {
        ?>
            var ckplcy_cookie_popup_html = '<div id="mio-cookie-popup">\n' +
                '  <div class="mio-cookie-popup__c-p-card mio-cookie-popup__card">\n' +
                '    <div class="mio-cookie-popup__content">\n' +
                '      <h3><?php echo str_replace("'",'&#x27;',__("website/index/cookie-policy-1")); ?></h3>\n' +
                '      <p><?php echo str_replace("'",'&#x27;',__("website/index/cookie-policy-2",['{page_link}' => Models::$init->link_detector('pages/'.Config::get("options/cookie-policy/page"))])); ?></p>\n' +
                '      <button class="mio-cookie-popup__c-p-button"><?php echo str_replace("'",'&#x27;',__("website/index/cookie-policy-3")); ?></button>\n' +
                '    </div>\n' +
                '  </div>\n' +
                '</div>';
            setTimeout(function(){
                ckplcyCheckCookie();
            },1000);
        <?php
    }
?>
</script>
<script src="<?php echo $baddress."assets/plugins/iziModal/js/iziModal.min.js?v=".License::get_version();?>"></script>
<script src="<?php echo $baddress."assets/plugins/sweetalert2/dist/promise.min.js";?>"></script>
<script src="<?php echo $baddress."assets/plugins/sweetalert2/dist/sweetalert2.min.js";?>"></script>
<script src="<?php echo $baddress."assets/javascript/jquery.form.min.js"; ?>"></script>
<script src="<?php echo $baddress."assets/javascript/webmio.js?v=".License::get_version(); ?>"></script>