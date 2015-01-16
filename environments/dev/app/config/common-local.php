<?php

return[
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=yii2_app',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            //'enableSchemaCache' => true,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager'
        ]
    ],
];
