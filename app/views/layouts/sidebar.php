<?php

use yii\web\View;
use dee\adminlte\widgets\Nav;

//use yii\helpers\Html;

/* @var $this View */

$items = [];
if(isset($this->params['menuCallback'])){
    $callback = $this->params['menuCallback'];
}elseif (class_exists('mdm\admin\components\MenuHelper')) {
    $callback = ['mdm\admin\components\MenuHelper','getAssignedMenu'];
}
if(isset($callback) && is_callable($callback)){
    $items = call_user_func($callback, Yii::$app->user->id);
}
?>
<aside class="main-sidebar">
    
    <section class="sidebar">
        <?php
        echo Nav::widget([
            'options' => [
                'class' => 'sidebar-menu',
                'items' => $items,
            ]
        ]);
        ?>
    </section>
</aside>
