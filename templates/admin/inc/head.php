<?php
    if(isset($meta) && !is_array($meta)) $meta = ['title' => $meta];
?>
<!-- Meta Tags -->
<title><?php echo isset($meta) && isset($meta["title"]) ? $meta["title"] : NULL; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="robots" content="none" />
<link rel="icon" type="image/x-icon" href="<?php echo $favicon_link; ?>" />
<link rel="canonical" href="<?php echo $canonical_link; ?>" />
<meta name="theme-color" content="#2c5062">
<?php if($h_contents = Hook::run("AdminAreaHeadMetaTags")) foreach($h_contents AS $h_content) if($h_content) echo $h_content; ?>
<!-- Meta Tags -->

<!-- CSS -->
<link rel="stylesheet" href="<?php echo $tadress;?>css/admio.css?v=<?php echo License::get_version(); ?>"/>

<link rel="stylesheet" href="<?php echo $tadress; ?>css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo $tadress; ?>css/ionicons.min.css">
<link href="https://fonts.googleapis.com/css?family=Titillium+Web:200,300,500,400,600,700&amp;subset=latin-ext" rel="stylesheet">
<?php
    View::admin_main_style();
?>

<?php if(isset($plugins)): ?>

    <?php if(in_array("mio-icons",$plugins)): ?>
        <link rel="stylesheet" href="<?php echo $tadress; ?>css/ionicons.min.css">
    <?php endif; ?>
    <?php if(in_array("highlightjs",$plugins)): ?>
        <link rel="stylesheet" href="<?php echo $sadress; ?>assets/plugins/highlightjs/styles/zenburn.css">
    <?php endif; ?>
    <?php if(in_array("jquery-ui",$plugins)): ?>
        <link rel="stylesheet" href="<?php echo $sadress; ?>assets/plugins/css/jquery-ui.css">
    <?php endif; ?>

    <?php if(in_array("intlTelInput",$plugins)): ?>
        <link rel="stylesheet" href="<?php echo $sadress; ?>assets/plugins/phone-cc/css/intlTelInput.css">
    <?php endif; ?>
    <?php if(in_array("dataTables",$plugins)): ?>
        <link rel="stylesheet" href="<?php echo $sadress; ?>assets/plugins/dataTables/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="<?php echo $sadress; ?>assets/plugins/dataTables/css/dataTables.responsive.min.css">
    <?php endif; ?>

    <?php if(in_array("dataTables-buttons",$plugins)): ?>
        <link rel="stylesheet" href="<?php echo $sadress; ?>assets/plugins/dataTables/css/buttons.dataTables.min.css">
    <?php endif; ?>
    <?php if(in_array("select2",$plugins)): ?>
        <link rel="stylesheet" href="<?php echo $sadress; ?>assets/plugins/select2/css/select2.min.css">
    <?php endif; ?>
    <?php if(in_array("jQtags",$plugins)): ?>
        <link rel="stylesheet" href="<?php echo $sadress; ?>assets/plugins/tags/jquery.tagsinput.min.css">
    <?php endif; ?>

    <?php if(in_array("spectrum-color",$plugins)): ?>
        <link rel="stylesheet" href="<?php echo $sadress; ?>assets/plugins/css/spectrum-color.css">
    <?php endif; ?>

    <?php if(isset($plugins) && in_array("ion.rangeSlider",$plugins)): ?>
        <link rel="stylesheet" href="<?php echo $sadress; ?>assets/plugins/ion.rangeSlider/css/ion.rangeSlider.min.css">
    <?php endif; ?>


<?php endif; ?>

<?php if(___("package/rtl")): ?><link rel="stylesheet" href="<?php echo $tadress;?>css/admio-rtl.css?v=<?php echo License::get_version(); ?>"/><?php endif; ?>

<!-- CSS -->

<!-- JS -->
<script src="<?php echo $tadress; ?>js/jquery-3.2.0.min.js"></script>
<script src="<?php echo $tadress; ?>js/admio.js?v=<?php echo License::get_version(); ?>"></script>
<?php
    View::admin_main_script();
?>

<?php if(isset($plugins)): ?>

    <?php if(in_array("jscolor",$plugins)): ?>
        <script src="<?php echo $sadress; ?>assets/plugins/js/jscolor.min.js"></script>
    <?php endif; ?>

    <?php if(in_array("spectrum-color",$plugins)): ?>
        <script src="<?php echo $sadress; ?>assets/plugins/js/spectrum-color.js"></script>
    <?php endif; ?>


    <?php if(in_array("highlightjs",$plugins)): ?>
        <script src="<?php echo $sadress; ?>assets/plugins/highlightjs/highlight.pack.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('pre code').each(function(i, block) {
                    hljs.highlightBlock(block);
                });
            });
        </script>
    <?php endif; ?>

    <?php if(in_array("jquery-ui",$plugins)): ?>
        <script src="<?php echo $sadress; ?>assets/plugins/js/jquery-ui.js"></script>
        <script type="text/javascript" src="<?php echo $sadress;?>assets/plugins/js/i18n/datepicker-<?php echo ___("package/code"); ?>.js"></script>
    <?php endif; ?>

    <?php if(in_array("intlTelInput",$plugins)): ?>
        <script src="<?php echo $sadress; ?>assets/plugins/phone-cc/js/intlTelInput.js"></script>
    <?php endif; ?>

    <?php if(in_array("dataTables",$plugins)): ?>
        <script src="<?php echo $sadress; ?>assets/plugins/dataTables/js/jquery.dataTables.min.js"></script>
        <script src="<?php echo $sadress; ?>assets/plugins/dataTables/js/dataTables.responsive.min.js"></script>
    <?php endif; ?>

    <?php if(in_array("dataTables-buttons",$plugins)): ?>
        <script src="<?php echo $sadress; ?>assets/plugins/dataTables/js/dataTables.buttons.min.js"></script>
        <script src="<?php echo $sadress; ?>assets/plugins/dataTables/js/buttons.flash.min.js"></script>
        <script src="<?php echo $sadress; ?>assets/plugins/dataTables/js/jszip.min.js"></script>
        <script src="<?php echo $sadress; ?>assets/plugins/dataTables/js/pdfmake.min.js"></script>
        <script src="<?php echo $sadress; ?>assets/plugins/dataTables/js/vfs_fonts.js"></script>
        <script src="<?php echo $sadress; ?>assets/plugins/dataTables/js/buttons.html5.min.js"></script>
        <script src="<?php echo $sadress; ?>assets/plugins/dataTables/js/buttons.print.min.js"></script>
    <?php endif; ?>

    <?php if(in_array("select2",$plugins)): ?>
        <script src="<?php echo $sadress; ?>assets/plugins/select2/js/select2.min.js"></script>
        <script src="<?php echo $sadress; ?>assets/plugins/select2/js/i18n/<?php echo ___("package/code"); ?>.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $.fn.select2.defaults.set("language", "<?php echo ___("package/code"); ?>");
            });
        </script>
    <?php endif; ?>

    <?php if(in_array("isotope",$plugins)): ?>
        <script src="<?php echo $sadress; ?>assets/plugins/js/isotope.pkgd.min.js"></script>
    <?php endif; ?>

    <?php if(in_array("jQtags",$plugins)): ?>
        <script src="<?php echo $sadress; ?>assets/plugins/tags/jquery.tagsinput.min.js"></script>
    <?php endif; ?>

    <?php if(in_array("voucher_codes",$plugins)): ?>
        <script src="<?php echo $sadress; ?>assets/plugins/js/voucher_codes.js"></script>
    <?php endif; ?>

    <?php if(in_array("Sortable",$plugins)): ?>
        <script src="<?php echo $sadress; ?>assets/plugins/js/Sortable.min.js"></script>
    <?php endif; ?>


    <?php if(in_array("drag-sort",$plugins)): ?>
        <script src="<?php echo $sadress; ?>assets/plugins/js/drag-sort.js"></script>
    <?php endif; ?>

    <?php if(in_array("jquery-nestable",$plugins)): ?>
        <script src="<?php echo $sadress; ?>assets/plugins/js/jquery.nestable.js"></script>
    <?php endif; ?>

    <?php if(in_array("tinymce-1",$plugins)): ?>
        <?php
        $tinymce_options = isset($plugins["tinymce"]) ? $plugins["tinymce"] : [];
        $height  = isset($tinymce_options["height"]) ? $tinymce_options["height"] : 300;
        $lkey = strlen($lang_key)==5 ? str_replace("-","_",$lang_key) : $lang_key;
        ?>
        <script src="<?php echo $sadress; ?>assets/plugins/tinymce/tinymce.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                tinymce_init('.tinymce-1');
            });

            function tinymce_init(selector){
                tinymce.init({
                    selector: selector,
                    height: "<?php echo $height; ?>",
                    entity_encoding : "raw",
                    language:'<?php echo $lkey; ?>',
                    setup: function (editor) {
                        editor.on('change', function () {
                            tinymce.triggerSave();
                        });
                    },
                    <?php if(Admin::isPrivilege(["UPLOAD_EDITOR_PICTURE"])): ?>

                    remove_script_host : false,
                    convert_urls : false,
                    images_upload_url: '<?php echo APP_URI."/".ADMINISTRATOR."/tinymce-upload"; ?>',
                    automatic_uploads: true,

                    <?php endif; ?>

                    <?php if(___("package/rtl")): ?>
                    directionality : "rtl",
                    <?php endif; ?>

                    plugins: [
                        "advlist autolink lists link image charmap print preview anchor",
                        "searchreplace visualblocks code fullscreen",
                        "insertdatetime media table contextmenu paste imagetools wordcount textcolor colorpicker textpattern"
                    ],
                    toolbar: "styleselect fontselect fontsizeselect | bold italic underline forecolor backcolor colorpicker | link image | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat code",
                    content_css: [
                        '//fonts.googleapis.com/css?family=Titillium+Web:200,300,500,400,600,700&subset=latin-ext',
                        '<?php echo $sadress."assets/plugins/tinymce/mio-style.css"; ?>'
                    ]
                });
            }
        </script>
    <?php endif; ?>

    <?php if(isset($plugins) && in_array("ion.rangeSlider",$plugins)): ?>
        <script src="<?php echo $sadress; ?>assets/plugins/ion.rangeSlider/js/ion.rangeSlider.min.js"></script>
    <?php endif; ?>



<?php endif; ?>

<!-- JS -->