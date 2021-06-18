<?php
    return [
        'type' => "virtualization",
        'server-info-checker' => true,
        'server-info-port' => true,
        'server-info-not-secure-port' => 5353,
        'server-info-secure-port' => 5656,
        'virtualization-types' => [
            'openvz'    => "OpenVZ",
            'xen'       => "Xen-PV",
            'hvm'       => "Xen-HVM",
            'kvm'       => "KVM",
        ],
        'configurable-option-params' => [
            'type',
            'node',
            'plan',
            'template',
            'randomipv4',
            'ips',
            'customextraip',
        ],
    ];