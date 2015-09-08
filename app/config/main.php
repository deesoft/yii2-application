<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-main',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'admin'],
    'controllerNamespace' => 'app\controllers',
    'modules'=>[
        'api'=>[
            'class'=>'rest\Module',
        ],
        'admin'=>[
            'class'=>'mdm\admin\Module',
        ]
    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'request'=>[
            'parsers'=>[
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'rules' => [
                ''=>'site/index',
                'template/<view>' => 'site/template'
            ],
        ],
        'authManager'=>[
            'class' => 'yii\rbac\DbManager',
        ]
//        'errorHandler' => [
//            'errorAction' => 'site/error',
//        ],
    ],
    'params' => $params,
];
