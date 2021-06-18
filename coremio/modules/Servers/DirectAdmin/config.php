<?php
    return [
        'type' => "hosting",
        'access-hash'         => false,
        'server-info-checker' => true,
        'server-info-port' => true,
        'server-info-not-secure-port' => 2222,
        'server-info-secure-port' => 2222,
        'supported' => [
            'disk-bandwidth-usage',
            'change-password',
        ],
    ];