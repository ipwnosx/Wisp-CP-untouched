<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title><?php echo $lang["title"]; ?></title>
    <link href="https://fonts.googleapis.com/css?family=Titillium+Web:200,300,400,600,700&amp;subset=latin-ext" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $taddress; ?>css/font-awesome.min.css">
    <link href="<?php echo $taddress; ?>css/style.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="resources/assets/plugins/iziModal/css/iziModal.min.css">

    <!-- Js -->
    <script type="text/javascript">
        var warning_modal_title = '<?php echo $lang["warning"]; ?>';
    </script>
    <script src="<?php echo $taddress; ?>js/jquery-1.11.3.min.js"></script>
    <script src="<?php echo $saddress; ?>assets/plugins/iziModal/js/iziModal.min.js"></script>
    <script src="<?php echo $saddress; ?>assets/plugins/sweetalert2/dist/promise.min.js"></script>
    <script src="<?php echo $saddress; ?>assets/plugins/sweetalert2/dist/sweetalert2.min.js"></script>
    <script src="<?php echo $saddress; ?>assets/javascript/webmio.js"></script>
    <script src="https://use.fontawesome.com/aaf32c1a9b.js"></script>

    <!-- Js -->
</head>
<body>

<div id="wrapper">
    <?php include TEMPLATE_DIR."install-stage".$stage.".php"; ?>
</div>
</body>
</html>