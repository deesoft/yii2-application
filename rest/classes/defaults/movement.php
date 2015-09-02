<?php
return [
    100 => [
        'name' => 'Purchase',
        'api' => 'purchase',
        'type' => 10,
        'field' => ['qty','total_receive'],
        'model' => 'biz\api\models\purchase\Purchase',
        'value_field' => 'price'
    ],
    200 => [
        'name' => 'Sales',
        'api' => 'sales',
        'type' => 20,
        'field' => ['qty','total_release'],
        'model' => 'biz\api\models\sales\Sales',
    ],
    300 => [
        'name' => 'Stock Transfer',
        'api' => 'transfer',
        'type' => 20,
        'field' => ['qty','total_release'],
        'model' => 'biz\api\models\inventory\Transfer',
    ],
    400 => [
        'name' => 'Stock Receive',
        'api' => 'transfer',
        'type' => 10,
        'field' => ['total_release','total_receive'],
        'branch' => 'branch_dest_id',
        'model' => 'biz\api\models\inventory\Transfer',
    ],
];
