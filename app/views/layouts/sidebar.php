<?php

use yii\web\View;
use dee\adminlte\SideNav;
use yii\helpers\ArrayHelper;

//use yii\helpers\Html;

/* @var $this View */

$items = ArrayHelper::getValue($this->params, 'sideMenu', []);
?>
<aside class="main-sidebar">
    <section class="sidebar">
        <?php
        echo SideNav::widget([
            'options' => [
                'class' => 'sidebar-menu',
                'nav-menu' => 'active',
            ],
            'items' => $items,
        ]);
        ?>
    </section>
</aside>
