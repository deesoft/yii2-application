<?php
use yii\web\JsExpression;
$func = <<<FUNC
function(param){
    return 'template/' + param.page;
}
FUNC;

return [
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
    '/page/:page' => [
        'templateUrl' => new JsExpression($func),
    ],
    '/user/login' => [
        'visible' => false,
        'view' => 'user/login',
        'js' => 'user/js/login.js',
        'injection' => ['$modalInstance','$http'],
    ],
    '/user/signup' => [
        'view' => 'user/signup',
        'js' => 'user/js/signup.js',
        'injection' => ['$http'],
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
    '/product'=>[
        'view'=>'product/index',
        'js'=>'product/js/index.js',
        'injection'=>['Product'],
    ],
    '/product/new'=>[
        'view'=>'product/create',
        'js'=>'product/js/create.js',
        'injection'=>['Product'],
    ],
    '/product/:id/edit'=>[
        'view'=>'product/update',
        'js'=>'product/js/update.js',
        'injection'=>['Product'],
    ],
    '/product/:id'=>[
        'view'=>'product/view',
        'js'=>'product/js/view.js',
        'injection'=>['Product'],
    ],
    'otherwise' => [
        'view' => 'site/error'
    ],
];
