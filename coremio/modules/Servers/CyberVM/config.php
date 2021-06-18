<?php
    return [
        'type' => "virtualization",
        'server-info-checker' => true,
        'server-info-port' => true,
        'server-info-not-secure-port' => 873,
        'server-info-secure-port' => 873,
        'os-list' => [
            'dos' => 'MS-DOS',
            'winXPPro' => 'Windows Xp Profesional 32bit',
            'winXPPro-64' => 'Windows Xp Profesional 64bit',
            'winVista' => 'Windows Vista 32bit',
            'winVista-64' => 'Windows Vista 64bit',
            'windows7' => 'Windows 7 32bit',
            'windows7-64' => 'Windows 7 64bit',
            'windows8' => 'Windows 8/10 32bit',
            'windows8-64' => 'Windows 8/10 64bit',
            'winNetEnterprise' => 'Windows Server 2003 32bit',
            'winNetEnterprise-64' => 'Windows Server 2003 64bit',
            'longhorn' => 'Windows Server 2008/2012/2016/2019 32bit',
            'longhorn-64' => 'Windows Server 2008/2012/2016/2019 64bit',
            'centos' => 'CentOS Linux 4/5/6/7 32bit',
            'centos-64' => 'CentOS Linux 4/5/6/7 64bit',
            'rhel5' => 'Red Hat Linux 32bit',
            'rhel5-64' => 'Red Hat Linux 64bit',
            'sles' => 'SUSE Linux 32bit',
            'sles-64' => 'SUSE Linux 64bit',
            'debian5' => 'Debian Linux 32bit',
            'debian5-64' => 'Debian Linux 64bit',
            'ubuntu' => 'Ubuntu Linux 32bit',
            'ubuntu-64' => 'Ubuntu Linux 64bit',
            'linux' => 'Other Linux 32bit',
            'linux-64' => 'Other Linux 64bit',
            'darwin' => 'Aplle Mac OS 32bit',
            'darwin-64' => 'Aplle Mac OS 64bit',
            'freebsd' => 'Free BSD 32bit',
            'freebsd-64' => 'Free BSD 64bit',
        ],
        'configurable-option-params' => [
            'server',
            'ram',
            'space',
            'bandwidth',
            'cpu',
            'vnc',
            'datastore',
            'os',
            'core',
            'osreinstall',
            'iso',
        ],
    ];