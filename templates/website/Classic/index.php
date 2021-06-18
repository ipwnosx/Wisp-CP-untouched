<?php
    defined('CORE_FOLDER') OR exit('You can not get in here!');

    $hoptions = [
        'page' => "index",
        'counterup',
        'aos',
        'dataTables',
    ];
    include __DIR__.DS."ac-index.php";
?>