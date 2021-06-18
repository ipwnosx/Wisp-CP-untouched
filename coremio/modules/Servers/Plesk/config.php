<?php
    return [
        'type' => "hosting",
        'server-info-checker' => true,
        'server-info-port' => true,
        'server-info-not-secure-port' => 8443,
        'server-info-secure-port' => 8443,
        'supported' => [
            'disk-bandwidth-usage',
            'manage-email-account',
            'manage-email-forwards',
            'change-password',
        ],
    ];