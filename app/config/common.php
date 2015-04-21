<?php
return[
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'aliases' => [
        'app/api' => '@app/modules/api',
        'app/angular' => '@app/modules/angular',
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
