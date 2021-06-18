<?php
    return [
        'type' => "hosting",
        'access-hash'         => true,
        'server-info-checker' => true,
        'server-info-port' => true,
        'server-info-not-secure-port' => 9715,
        'server-info-secure-port' => 9715,
        'supported' => [
            'manage-email-account',
            'disk-bandwidth-usage',
            'change-password',
        ],
    ];