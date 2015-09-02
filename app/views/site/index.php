<?php

use yii\web\View;
use dee\angular\NgView;

//use yii\helpers\Html;

/* @var $this View */
?>
<?=
NgView::widget([
    'requires' => ['ngResource', 'ui.bootstrap', 'dee', 'validation', 'validation.rule'],
    'routes' => [
        '/' => [
            'redirectTo' => '/index',
        ],
        '/index' => [
            'view' => 'site/index',
            'js' => 'site/js/index.js',
        ],
        '/contact' => [
            'view' => 'site/contact',
        ],
        '/user/login' => [
            'visible' => false,
            'view' => 'user/login',
            'js' => 'user/js/login.js',
            'injection' => ['Auth', '$modalInstance'],
        ],
        '/purchase' => [
            'view' => 'purchase/index',
            'js' => 'purchase/js/index.js',
            'injection' => ['Purchase',],
        ],
        '/purchase/new' => [
            'view' => 'purchase/create',
            'js' => 'purchase/js/create.js',
            'injection' => ['Purchase',],
        ],
        '/purchase/:id/edit' => [
            'view' => 'purchase/update',
            'js' => 'purchase/js/update.js',
            'injection' => ['Purchase',],
        ],
        '/purchase/:id' => [
            'view' => 'purchase/view',
            'js' => 'purchase/js/view.js',
            'injection' => ['Purchase'],
        ],
        '/sales' => [
            'view' => 'sales/index',
            'js' => 'sales/js/index.js',
            'injection' => ['Sales',],
        ],
        '/sales/new' => [
            'view' => 'sales/create',
            'js' => 'sales/js/create.js',
            'injection' => ['Sales',],
        ],
        '/sales/:id/edit' => [
            'view' => 'sales/update',
            'js' => 'sales/js/update.js',
            'injection' => ['Sales',],
        ],
        '/sales/:id' => [
            'view' => 'sales/view',
            'js' => 'sales/js/view.js',
            'injection' => ['Sales',],
        ],
        '/transfer' => [
            'view' => 'transfer/index',
            'js' => 'transfer/js/index.js',
            'injection' => ['Transfer',],
        ],
        '/transfer/new' => [
            'view' => 'transfer/create',
            'js' => 'transfer/js/create.js',
            'injection' => ['Transfer',],
        ],
        '/transfer/:id/edit' => [
            'view' => 'transfer/update',
            'js' => 'transfer/js/update.js',
            'injection' => ['Transfer',],
        ],
        '/transfer/:id' => [
            'view' => 'transfer/view',
            'js' => 'transfer/js/view.js',
            'injection' => ['Transfer'],
        ],
        '/movement' => [
            'view' => 'movement/index',
            'js' => 'movement/js/index.js',
            'injection' => ['Movement',],
        ],
        '/movement/new' => [
            'view' => 'movement/create',
            'js' => 'movement/js/create.js',
            'injection' => ['Movement',],
        ],
        '/movement/new/:reff/:id' => [
            'view' => 'movement/create',
            'js' => 'movement/js/create.js',
            'injection' => ['Movement',],
        ],
        '/movement/:id/edit' => [
            'view' => 'movement/update',
            'js' => 'movement/js/update.js',
            'injection' => ['Movement',],
        ],
        '/movement/:id' => [
            'view' => 'movement/view',
            'js' => 'movement/js/view.js',
            'injection' => ['Movement',],
        ],
        'otherwise' => [
            'view' => 'site/error'
        ],
    ],
    'js' => 'app.js',
    'clientOptions'=>[
        'baseApiUrl'=>'http://api.dee-app.dev/index.php/v1/',
//        'baseApiUrl'=>  '/index.php/api/v1/',
    ]
])?>