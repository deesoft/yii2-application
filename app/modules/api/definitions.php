<?php

return [
    'BizTimestampBehavior' => [
        'class' => 'yii\behaviors\TimestampBehavior',
        'createdAtAttribute' => 'created_at',
        'updatedAtAttribute' => 'updated_at',
        'value' => new \yii\db\Expression('NOW()')
    ],
    'BizBlameableBehavior' => [
        'class' => 'yii\behaviors\BlameableBehavior',
        'createdByAttribute' => 'created_by',
        'updatedByAttribute' => 'updated_by',
    ],
    'BizStatusConverter' => [
        'class' => 'mdm\converter\EnumConverter',
        'attributes' => [
            'nmStatus' => 'status'
        ],
        'enumPrefix' => 'STATUS_'
    ],
];
