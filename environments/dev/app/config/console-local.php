<?php

return[
    'controllerMap' => [
        'migrate' => [
            'class' => 'dee\console\MigrateController',
            'migrationLookup' => [
                '@yii/rbac/migrations',
                '@mdm/admin/migrations',
            ]
        ],
        'sample-data' => [
            'class' => 'dee\console\SampleDataController',
            'samples' => '@app/command/samples.php'
        ]
    ],
];
