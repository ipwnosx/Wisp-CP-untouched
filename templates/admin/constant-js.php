<script type="text/javascript">
    var APP_URI             = '<?php echo APP_URI; ?>';
    var is_logged           = <?php echo UserManager::LoginCheck("admin") ? "true" : "false"; ?>;
    var update_online_link  = "<?php echo Controllers::$init->AdminCRLink("dashboard"); ?>";

    var warning_modal_title = "<?php echo htmlentities(___("needs/warning-modal-title"),ENT_QUOTES); ?>";
    var success_modal_title = "<?php echo htmlentities(___("needs/success-modal-title"),ENT_QUOTES); ?>";
</script>
<script src="<?php echo $baddress."assets/plugins/iziModal/js/iziModal.min.js?v=".License::get_version(); ?>"></script>
<script src="<?php echo $baddress."assets/plugins/sweetalert2/dist/promise.min.js";?>"></script>
<script src="<?php echo $baddress."assets/plugins/sweetalert2/dist/sweetalert2.min.js";?>"></script>
<script src="<?php echo $baddress."assets/javascript/jquery.form.min.js"; ?>"></script>
<script src="<?php echo $baddress."assets/javascript/admio.js?v=".License::get_version(); ?>"></script>