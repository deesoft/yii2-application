<?php
$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            //'showScriptName' => false,
            'rules' => [
                'page/<view:\w+>'=>'site/page',
            ],
        ],
    ],
];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'generators' => [
            'crud' => ['class' => 'dee\gii\generators\crud\Generator'],
            'migration' => ['class' => 'dee\gii\generators\migration\Generator'],
//            'angular' => ['class' => 'dee\gii\generators\angular\Generator'],
//            'mvc' => ['class' => 'dee\gii\generators\mvc\Generator'],
        ],
    ];
}

return $config;
