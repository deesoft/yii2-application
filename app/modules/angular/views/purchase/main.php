<?php
use yii\helpers\Url;
use dee\angular\Angular;

/* @var $this yii\web\View */

Angular::renderScript('js/main.js');
?>
<?=
Angular::widget([
    'requires' => ['ngResource','ui.bootstrap',],
    'routes' => [
        '/' => [
            'view' => 'index',
            'di' => ['Purchase',],
        ],
        '/view/:id' => [
            'view' => 'view',
            'di' => ['Purchase',],
        ],
        '/update/:id' => [
            'view' => 'update',
            'di' => ['Purchase',],
        ],
        '/create' => [
            'view' => 'create',
            'di' => ['Purchase',],
        ],
    ],
    'resources' => [
        'Purchase' => [
            'url' => Url::to(['api/purchase']),
            'actions' =>[
                'update' => [
                    'method' => 'PUT',
                ],
            ]
        ]
    ]
]);?>