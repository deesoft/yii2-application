<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'), 
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-rest',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'rest\controllers',
    'bootstrap' => [
        'log',
    ],
    'components' => [
        'bizConfig' => [
            'class' => 'rest\classes\Config'
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableSession' => false,
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'rules' => [
            ],
        ],
        'request'=>[
            'parsers'=>[
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
    ],
    'as biz' => [
        'class' => 'rest\classes\Hooks',
    ],
    'as cors' => [
        'class' => 'yii\filters\Cors',
        'cors' => ['Origin' => ['*'],
            'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
            'Access-Control-Request-Headers' => ['*'],
            'Access-Control-Allow-Credentials' => null,
            'Access-Control-Max-Age' => 86400,
            'Access-Control-Expose-Headers' => [
                'X-Pagination-Total-Count',
                'X-Pagination-Page-Count',
                'X-Pagination-Current-Page',
                'X-Pagination-Per-Page',
            ],
        ],
    ],
    'as authenticator' => [
        'class' => 'yii\filters\auth\CompositeAuth',
    ],
    'params' => $params,
];
