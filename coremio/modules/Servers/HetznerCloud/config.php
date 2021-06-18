<?php
    return [
        'type'                          => "virtualization",
        'access-hash'                   => true,
        'server-info-checker'           => true,
        'server-info-port'              => false,
        'server-info-not-secure-port'   => 80,
        'server-info-secure-port'       => 80,
        'configurable-option-params'    => [
            'backup',
            'volume',
            'snapshots',
            'floating_ips',
            'image',
            'user_data',
            'ssh_key'
        ],
    ];