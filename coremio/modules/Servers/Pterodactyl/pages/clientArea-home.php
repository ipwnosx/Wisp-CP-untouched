<br>
<br>
<?php

    if(!isset($hdd_limit)) return false;

    $limit          = $hdd_limit;
    $used           = $hdd_used;
    $percent        = $hdd_limit > 0 ? Utility::getPercent($used,$limit) : 0;
    if($percent > 100) $percent = 100;

?>
<div style="margin:20px;display:inline-block;text-align: center;">
    <h5 style="font-size:16px;"><strong>HDD</strong></h5>
    <div class="clear"></div>
    <div class="progress-circle progress-<?php echo $percent; ?>"><span><?php echo $percent; ?></span></div>
    <div class="clear"></div>
    <h5 style="font-size:16px;"><?php echo $used == 'N' ? '0 MB' : $used.' MB'; ?> / <?php echo $limit > 0 ? $limit.' MB' : '∞'; ?></h5>
</div>

<?php
    $limit          = $ram_limit;
    $used           = $ram_used;
    $percent        = $ram_limit > 0 ? Utility::getPercent($used,$limit) : 0;
    if($percent > 100) $percent = 100;

?>
<div style="margin:20px;display:inline-block;text-align: center;">
    <h5 style="font-size:16px;"><strong>RAM</strong></h5>
    <div class="clear"></div>
    <div class="progress-circle progress-<?php echo $percent; ?>"><span><?php echo $percent; ?></span></div>
    <div class="clear"></div>
    <h5 style="font-size:16px;"><?php echo $used == 'N' ? '0 MB' : $used.' MB'; ?> / <?php echo $limit > 0 ? $limit.' MB' : '∞'; ?></h5>
</div>

<?php
    $limit          = $cpu_limit;
    $used           = $cpu_used;
    $percent        = $cpu_limit > 0 ? Utility::getPercent($used,$limit) : 0;
    if($percent > 100) $percent = 100;

?>
<div style="margin:20px;display:inline-block;text-align: center;">
    <h5 style="font-size:16px;"><strong>CPU</strong></h5>
    <div class="clear"></div>
    <div class="progress-circle progress-<?php echo $percent; ?>"><span><?php echo $percent; ?></span></div>
    <div class="clear"></div>
    <h5 style="font-size:16px;"><?php echo $used.' Mhz'; ?> / <?php echo $limit > 0 ? $limit.' Mhz' : '∞'; ?></h5>
</div>

<br><br>