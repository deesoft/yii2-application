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
        '/'=>[
            'view'=>'index'
        ],
        '/purchase' => [
            'view' => 'purchase/index',
            'di' => ['Purchase',],
        ],
        '/purchase/view/:id' => [
            'view' => 'purchase/view',
            'di' => ['Purchase',],
        ],
        '/purchase/update/:id' => [
            'view' => 'purchase/update',
            'di' => ['Purchase',],
        ],
        '/purchase/create' => [
            'view' => 'purchase/create',
            'di' => ['Purchase',],
        ],
        '/movement' => [
            'view' => 'movement/index',
            'di' => ['Movement',],
        ],
        '/movement/view/:id' => [
            'view' => 'movement/view',
            'di' => ['Movement',],
        ],
        '/movement/update/:id' => [
            'view' => 'movement/update',
            'di' => ['Movement',],
        ],
        '/movement/create' => [
            'view' => 'movement/create',
            'di' => ['Movement',],
        ],
    ],
    'jsFile' => 'main.js'
]);
?>