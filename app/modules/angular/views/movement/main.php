<?php

use dee\angular\Angular;
use app\angular\ModuleAsset;
use app\angular\components\Helper;
use yii\helpers\Json;

/* @var $this yii\web\View */

ModuleAsset::register($this);
?>
<?=
Angular::widget([
    'requires' => ['app.angular', 'ui.bootstrap',],
    'routes' => [
        '/' => [
            'view' => 'index',
            'di' => ['Movement'],
        ],
        '/view/:id' => [
            'view' => 'view',
            'di' => ['Movement'],
        ],
        '/update/:id' => [
            'view' => 'update',
            'di' => ['Movement'],
        ],
        '/create/:reff/:id' => [
            'view' => 'create',
            'di' => ['Movement'],
        ],
    ],
    'jsFile' => 'js/main.js'
]);
?>