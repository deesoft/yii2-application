<?php
return [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '',
        ],
    ],
    'as authenticator' => [
        'authMethods' => [
//            'yii\filters\auth\QueryParamAuth',
//            'yii\filters\auth\HttpBearerAuth',
//            'dee\rest\GuestAuth',
        ],
        'except'=>['v1/master/index'],
    ],
];
