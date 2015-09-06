<?php
return [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '',
        ],
        'urlManager' => [
            'rules' => [
                [
                    'class' => 'dee\rest\UrlRule',
                    'controller' => [
                        'v<version:\d+>/<controller>' => 'v<version>/<controller>'
                    ]
                ],
            ]
        ],
    ],
    'as authenticator' => [
        'authMethods' => [
//            'yii\filters\auth\QueryParamAuth',
//            'yii\filters\auth\HttpBearerAuth',
//            'dee\rest\GuestAuth',
        ],
        'except' => ['v1/master/index'],
    ],
];
