<?php 
return [
    'period-extend-order'  => [
        'content'   => '{name}  ({start} - {end})',
        'variables' => '{name},{period}',
    ],
    'period-extend-addon'  => [
        'content'   => '{order_name} - {addon_name}: {option_name} ({start} - {end})',
        'variables' => '{order_name},{addon_name},{option_name},{period}',
    ],
    'period-extend-domain' => [
        'content'   => '{domain} ({start} - {end})',
        'variables' => '{domain},{year}',
    ],
];
