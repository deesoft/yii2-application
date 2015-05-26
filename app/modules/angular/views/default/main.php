<?php

use dee\angular\Angular;
use app\angular\ModuleAsset;

/* @var $this yii\web\View */

ModuleAsset::register($this);

?>
<?=
Angular::widget([
    'requires' => ['app.angular', 'ui.bootstrap',],
    'routes' => [
        '/purchase' => [
            'view' => 'index',
            'di' => ['Purchase',],
        ],
        '/purchase/view/:id' => [
            'view' => 'view',
            'di' => ['Purchase',],
        ],
        '/purchase/update/:id' => [
            'view' => 'update',
            'di' => ['Purchase',],
        ],
        '/purchase/create' => [
            'view' => 'create',
            'di' => ['Purchase',],
        ],
        '/movement' => [
            'view' => 'index',
            'di' => ['Purchase',],
        ],
        '/movement/view/:id' => [
            'view' => 'view',
            'di' => ['Purchase',],
        ],
        '/movement/update/:id' => [
            'view' => 'update',
            'di' => ['Purchase',],
        ],
        '/movement/create' => [
            'view' => 'create',
            'di' => ['Purchase',],
        ],
    ],
    'jsFile' => 'main.js'
]);
?>