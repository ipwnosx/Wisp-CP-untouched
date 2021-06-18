<?php
    return [
        'type'                          => "hosting",
        'access-hash'                   => true,
        'server-info-checker'           => true,
        'server-info-port'              => false,
        'server-info-not-secure-port'   => 80,
        'server-info-secure-port'       => 80,
        'supported' => [
            'manage-email-account',
            'manage-email-forwards',
            'change-password',
        ],
        'configurable-option-params'    => [
            'IP',
            'IPv6'
        ],
    ];