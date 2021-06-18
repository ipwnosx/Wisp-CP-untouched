<?php 
return [
    'name'              => 'NameSilo',
    'description'       => '',
    'import-tld-button' => 'Import',
    'fields'            => [
        'api-key'         => 'API Key',
        'api-key-sandbox' => 'Sandbox API Key',
        'payment-id'      => 'Payment ID',
        'coupon'          => 'Coupon Code',
        'test-mode'       => 'Test Mode',
        'auto-renew'      => 'Auto Renew',
        'WHiddenAmount'   => 'WhoIS Protection Fee',
        'adp'             => 'Update pricing automatically',
        'import-tld'      => 'Import Extensions',
    ],
    'desc'              => [
        'api-key'         => 'Can be found in My Account > API Manager',
        'api-key-sandbox' => '',
        'payment-id'      => '',
        'coupon'          => '',
        'test-mode'       => '',
        'auto-renew'      => '',
        'WHiddenAmount'   => '<br> You can charge a fee to hide whois information from your customers.',
        'adp'             => 'Automatically pulls pricing daily and the price is set at the profit rate',
        'import-tld-1'    => 'Automatically import all extensions',
        'import-tld-2'    => 'All domain extensions and costs registered on the API will be imported collectively.',
    ],
    'tab-detail'        => 'API Information',
    'tab-import'        => 'Import',
    'test-button'       => 'Test Connection',
    'import-note'       => 'You can easily transfer the domain names that are already registered in provider\'s system. The imported domain names are created as an addon, domain names that are currently registered in system are marked green.',
    'import-button'     => 'Import',
    'save-button'       => 'Save Settings',
    'error1'            => 'API information is not available',
    'error2'            => 'Domain and TLD information are not present',
    'error3'            => 'There was an error retrieving the personal ID',
    'error4'            => 'Status information could not be retrieved',
    'error5'            => 'No transfer information was received',
    'error6'            => 'Please enter the API information',
    'error7'            => 'Failed to perform import',
    'error8'            => 'Something went wrong',
    'success1'          => 'Settings saved successfully',
    'success2'          => 'Connection test successful',
    'success3'          => 'Import successfully completed',
    'success4'          => 'Extensions successfully imported',
];
