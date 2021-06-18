<?php
    $code       = $exception->getCode();
    $message    = $exception->getMessage();
    $file       = $exception->getFile();
    $line       = $exception->getLine();

    if($code >= 1000 && $code < 1049){
        ?>
        <html>
        <head>
            <!-- Meta Tags -->
            <title>Database Error</title>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="robots" content="noindex">
            <!-- Meta Tags -->
            <!-- Css -->
            <link rel="stylesheet" href="<?PHP echo APP_URI; ?>/templates/system/css/stylex.css">
            <link rel="stylesheet" href="<?PHP echo APP_URI; ?>/templates/system/css/ionicons.min.css">
            <link href="https://fonts.googleapis.com/css?family=Titillium+Web:200,400,600,700&subset=latin-ext" rel="stylesheet">
            <!-- Css -->

            <!-- Js -->
            <script src="<?PHP echo APP_URI; ?>/templates/system/js/jquery-1.11.3.min.js"></script>
            <script src="https://use.fontawesome.com/aaf32c1a9b.js"></script>
            <!-- Js -->
        </head>
        <body>

        <div id="wrapper" style="text-align:center;">
            <div class="setupbg">
                <div class="padding15">
                    <div class="clear"></div>
                    <br><br>
                    <i style="font-size:70px;margin-bottom:25px;" class="fa fa-database" aria-hidden="true"></i><br>
                    <h4><strong>Database Error</strong></h4>
                   <div style="text-align: left;">
                       <h5 style="font-weight:400;margin-top:15px;">Code: <strong><?php echo $code; ?><strong></strong></strong></h5>
                       <h5 style="font-weight:400;margin-top:15px;">File: <strong><?php echo $file; ?><strong></strong></strong></h5>

                       <div class="line" style="margin:10px 0px;"></div>
                       <?php echo $message; ?>
                       <br><br>

                   </div>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        </body>
        </html>
        <?php
    }
    else{
        echo "Database Error: ".$message;
    }