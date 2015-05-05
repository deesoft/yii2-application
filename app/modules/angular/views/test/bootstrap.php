<?php
use dee\angular\Angular;

/* @var $this yii\web\View */
?>

<?=Angular::widget([
    'routes'=>[
        '/'=>[
            'view'=>'index',
            'controller'=>'Index',
        ],
        '/view/:id'=>[
            'view'=>'view',
            'controller'=>'View',
            'di'=>[],
        ],
        '/edit/:id'=>[
            'view'=>'edit',
            'controller'=>'Edit',
            'di'=>[],
        ],
        '/create'=>[
            'view'=>'create',
            'controller'=>'Create',
            'di'=>[],
        ],
    ],
    'jsFile' => 'script'
])?>