<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'dee.migration.path'=>[
        '@yii/rbac/migrations',
        '@mdm/admin/migrations',
        '@mdm/autonumber/migrations',
    ]
];
