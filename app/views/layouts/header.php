<?php

use yii\web\View;
use dee\adminlte\Nav;
use yii\helpers\ArrayHelper;

/* @var $this View */
if (Yii::$app->user->isGuest) {
    $userItem = [
        'label' => 'User',
        'items' => [
            ['label' => 'Login', 'url' => ['/site/login']],
            ['label' => 'Signup', 'url' => ['/site/signup']],
        ]
    ];
} else {
    $userItem = [
        'label' => Yii::$app->user->identity->username,
        'items' => [
            ['label' => 'Change password', 'url' => ['/site/change-password']],
            [
                'label' => 'Logout',
                'url' => ['/site/logout'],
                'linkOptions' => ['data-method' => 'POST']
            ],
        ]
    ];
}
?>
<header class="main-header">
    <a href="<?= Yii::$app->homeUrl; ?>" class="logo">
        <span class="logo-mini"><?= ArrayHelper::getValue(Yii::$app->params, 'app.name.small', 'App') ?></span>
        <span class="logo-lg"><?= Yii::$app->name ?></span>
    </a>
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <?=
            Nav::widget([
                'options' => ['class' => 'navbar-nav'],
                'items' => [
                    $userItem,
                ]
            ]);
            ?>
        </div>
    </nav>
</header>