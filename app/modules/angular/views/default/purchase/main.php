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
    'jsFile' => 'js/main.js'
]);
?>