<!DOCTYPE html>
<html>
<head>
    <?php
        $plugins        = [];
        include __DIR__.DS."inc".DS."head.php";

        if($rate <= 33) $perc_id = '1to33';
        elseif($rate <= 66) $perc_id = '33to66';
        else $perc_id = '66to100';

    ?>
    <script type="text/javascript">
        function loading() {
            document.querySelectorAll(".bar").forEach(function(current) {
                var startWidth = 0;
                const endWidth = current.dataset.size;

                /*
                setInterval() time sholud be set as trasition time / 100.
                In our case, 2 seconds / 100 = 20 milliseconds.
                */
                const interval = setInterval(frame, 25);

                function frame() {
                    if (startWidth >= endWidth) {
                        clearInterval(interval);
                    } else {
                        startWidth++;
                        current.style.width = endWidth+"%";
                        current.firstElementChild.innerText = startWidth+"%";
                    }
                }
            });
        }
        setTimeout(loading, 100);
    </script>

</head>
<body>

<?php include __DIR__.DS."inc/header.php"; ?>

<div id="wrapper">

    <div class="icerik-container">
        <div class="icerik">

            <div class="icerikbaslik">
                <h1>
                    <strong><?php echo __("admin/help/page-health"); ?></strong>
                </h1>
                <?php include __DIR__.DS."inc".DS."breadcrumb.php"; ?>
            </div>


            <div class="systemhealth">

                <div class="systemhealth-con">

                    <div class="systemhealth-status">
                        <div class="systemhealth-status-title">
                            <div class="padding15"><?php echo __("admin/help/health-text1"); ?></div>
                        </div>
                        <div class="padding20">

                            <?php
                                if($rate == 100)
                                {
                                    ?>
                                    <div class="systemhealth-status-block" id="allstatusok">
                                        <h1><i class="ion-checkmark-circled" aria-hidden="true"></i><br><strong><?php echo __("admin/help/health-text5"); ?></strong><br><?php echo __("admin/help/health-text6"); ?></h1>
                                    </div>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <div class="systemhealth-status-block">
                                        <h1><i class="ion-close-circled" aria-hidden="true"></i><br><strong><?php echo $error_count; ?></strong> <?php echo __("admin/help/health-text2"); ?></h1>
                                        <h1><i class="ion-information-circled" aria-hidden="true"></i><br><strong><?php echo $warning_count; ?></strong> <?php echo __("admin/help/health-text3"); ?></h1>
                                        <h1><i class="ion-checkmark-circled" aria-hidden="true"></i><br><strong><?php echo $success_count; ?></strong> <?php echo __("admin/help/health-text4"); ?></h1>
                                    </div>
                                    <?php

                                }
                            ?>

                            <div class="progress-bar" id="perc<?php echo $perc_id; ?>">
                                <div class="bar" data-size="<?php echo $rate; ?>">
                                    <span class="perc"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="systemhealth-status-infos">

                        <?php
                            foreach($items AS $item)
                            {
                                if($item['status'] == 'errors')
                                {
                                    $class = 'shealtherror';
                                    $icon  = 'ion-close-circled';
                                }
                                elseif($item['status'] == 'warnings')
                                {
                                    $class = 'shealthinfo';
                                    $icon  = 'ion-information-circled';
                                }
                                else
                                {
                                    $class = 'shealthok';
                                    $icon  = 'ion-checkmark-circled';
                                }

                                $replaces   = [];

                                if($item['key'] == 'session') $replaces['{directory}'] = $item['data'];
                                elseif($item['key'] == 'full-disk-space' && $item["data"])
                                    $replaces = [
                                        '{free}'   => FileManager::formatByte(isset($item["data"]["free"]) ? $item["data"]["free"] : 1),
                                        '{total}'   => FileManager::formatByte(isset($item["data"]["total"]) ? $item["data"]["total"] : 1),
                                    ];
                                elseif($item['key'] == 'sql-mode')
                                    $replaces = [
                                        '{modes}'   => $item["data"]["modes"],
                                    ];

                                $title      = __("admin/help/health-".$item['key']);
                                $info       = __("admin/help/health-".$item['status']."-".$item['key'],$replaces);
                                if(!$title) $title = $item['key'];
                                if(!$info) $info = $item['status'].'-'.$item['key'];
                                $ul_items   = [];

                                if($item['key'] == 'extensions')
                                    $ul_items = array_values($item['data']);
                                elseif($item['key'] == 'file-permission')
                                    $ul_items = array_values($item['data']);
                                ?>
                                <div class="systemhealth-info-con <?php echo $class; ?>">
                                    <div class="systemhealth-status-title-info">
                                        <div class="padding15">
                                            <i class="<?php echo $icon; ?>"></i>
                                            <?php echo $title; ?>
                                        </div>
                                    </div>
                                    <div class="padding20">
                                        <?php echo $info; ?>
                                        <?php
                                            if($item['key'] == 'limits' && $item['status'] == 'errors')
                                            {
                                                ?>
                                                <br><br>
                                                <?php echo __("admin/help/health-must-be"); ?>
                                                <ul>
                                                    <?php
                                                        if(isset($item["data"]["memory_limit"]))
                                                        {
                                                            ?>
                                                            <li><strong>memory_limit = <?php echo $suggested_memory_limit; ?>M</strong></li>
                                                            <?php
                                                        }

                                                        if(isset($item["data"]["max_execution_time"]))
                                                        {
                                                            ?>
                                                            <li><strong>max_execution_time = <?php echo $suggested_execution_time; ?></strong></li>
                                                            <?php
                                                        }
                                                    ?>
                                                </ul>

                                                <br>
                                                <?php echo __("admin/help/health-limits-server-values"); ?>
                                                <ul>
                                                    <?php
                                                        if(isset($item["data"]["memory_limit"]))
                                                        {
                                                            ?>
                                                            <li><strong>memory_limit = <?php echo $item["data"]["memory_limit"]; ?></strong></li>
                                                            <?php
                                                        }
                                                        if(isset($item["data"]["max_execution_time"]))
                                                        {
                                                            ?>
                                                            <li><strong>max_execution_time = <?php echo $item["data"]["max_execution_time"]; ?></strong></li>
                                                            <?php
                                                        }
                                                    ?>
                                                </ul>
                                                <?php
                                            }

                                            if($ul_items)
                                            {
                                                ?>
                                                <ul>
                                                    <?php
                                                        foreach($ul_items AS $ul_item)
                                                        {
                                                            ?>
                                                            <li><strong><?php echo $ul_item; ?></strong></li>
                                                            <?php
                                                        }
                                                    ?>
                                                </ul>
                                                <?php
                                            }
                                        ?>
                                    </div>
                                </div>
                                <?php
                            }
                        ?>


                    </div>


                </div>

            </div>


            <div class="clear"></div>

        </div>
    </div>


</div>

<?php include __DIR__.DS."inc".DS."footer.php"; ?>

</body>
</html>