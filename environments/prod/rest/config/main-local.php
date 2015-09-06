<?php
return [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '',
        ],
    ],
    'as authenticator' => [
        'class' => 'yii\filters\auth\CompositeAuth',
        'authMethods' => [
//            'yii\filters\auth\HttpBearerAuth',
//            'dee\rest\GuestAuth',
        ],
        'except'=>[],
    ],
];
