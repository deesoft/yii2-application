<?php

return [
    'yii\behaviors\TimestampBehavior' => [
        'class' => 'yii\behaviors\TimestampBehavior',
        'value' => new \yii\db\Expression('NOW()')
    ],
];
