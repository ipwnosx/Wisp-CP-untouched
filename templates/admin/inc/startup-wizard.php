<script src="<?php echo $tadress; ?>js/core.js"></script>
<?php
    $new_established    = false;
    $established_co     = Config::get("general/established-date");
    $established_n      = DateManager::strtotime(DateManager::next_date([$established_co,'day' => 1]));
    if($established_n > DateManager::strtotime()) $new_established = true;
    $new_established_c  = Cookie::get("wbot_welcome_dont_show");


    if($ui_lang == "tr")
        include __DIR__.DS."startup-wizard-tr.php";
    else
        include __DIR__.DS."startup-wizard-en.php";
?>