<?php

use yii\web\View;
use dee\adminlte\widgets\Menu;

//use yii\helpers\Html;

/* @var $this View */
?>
<aside class="main-sidebar">
    <section class="sidebar">
        <?php
        echo Menu::widget([
            'options' => [
                'class' => 'sidebar-menu',
                'items' => [
                ]
            ]
        ]);
        ?>
    </section>
</aside>
