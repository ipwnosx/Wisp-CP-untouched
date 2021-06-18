<?php 
return [
    'name'        => 'OnlineNIC',
    'description' => '',
    'fields'      => [
        'username'      => 'Account ID',
        'password'      => 'Password',
        'test-mode'     => 'Test Mode',
        'WHiddenAmount' => 'WhoIS Protection Fee',
    ],
    'desc'        => [
        'WHiddenAmount' => '<br> You can charge a fee to hide whois information from your customers.',
        'test-mode'     => ' ',
    ],
    'test-button' => 'Test Connection',
    'save-button' => 'Save Settings',
    'error1'      => 'API information is not available',
    'error2'      => 'Domain and TLD information are not present',
    'error3'      => 'There was an error retrieving the person ID',
    'error4'      => 'Status information could not be retrieved',
    'error5'      => 'No transfer information was received',
    'error6'      => 'After processing on the API provider, you can activate the status of the order',
    'error7'      => 'Enter API Information',
    'success1'    => 'Settings Saved Successfully',
    'success2'    => 'Connection test successful',
];
