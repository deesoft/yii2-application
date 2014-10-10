<?php

$config = [
    'modules' => [
    ],
    'components' => [
        'assetManager' => [
            'forceCopy' => true,
        ],
        'request' => [
            'cookieValidationKey' => '',
        ],
        'session' => [
            'cookieParams' => ['httponly' => true, 'path' => '/']
        ],
        'urlManager' => [
            'enablePrettyUrl' => false,
            'enableStrictParsing' => true,
            'showScriptName' => true,
            'rules' => [
            ],
        ]
    ]
];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
