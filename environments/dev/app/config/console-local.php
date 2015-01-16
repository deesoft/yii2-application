<?php

return[
    'controllerMap' => [
        'migrate' => [
            'class' => 'mdm\console\MigrateController',
            'migrationLookup' => [
                '@yii/rbac/migrations',
                '@mdm/admin/migrations',
            ]
        ],
        'sample-data' => [
            'class' => 'mdm\console\SampleDataController',
            'samples' => '@app/command/samples.php'
        ]
    ],
];
