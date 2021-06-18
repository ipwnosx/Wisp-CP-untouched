<?php
    return [
        'type'                          => "hosting",
        'access-hash'                   => true,
        'server-info-checker'           => true,
        'server-info-port'              => true,
        'server-info-not-secure-port'   => 2082,
        'server-info-secure-port'       => 2083,
        'supported' => [
            'change-password',
            'disk-bandwidth-usage',
        ],
        'configurable-option-params'    => [],
    ];