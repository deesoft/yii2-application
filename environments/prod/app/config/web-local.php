<?php

$config = [
    'modules' => [
        'admin' => 'mdm\admin\Module'
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => '',
        ],
        'session' => [
            'cookieParams' => ['httponly' => true, 'path' => '/']
        ],
        'urlManager' => [
            'enablePrettyUrl' => false,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ]
    ]
];

return $config;
