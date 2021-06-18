<?php
    return [
        'type' => "hosting",
        'access-hash'         => false,
        'server-info-checker' => true,
        'server-info-port' => true,
        'server-info-not-secure-port' => 8083,
        'server-info-secure-port' => 8083,
        'supported' => [
            'disk-bandwidth-usage',
            'change-password',
        ],
    ];