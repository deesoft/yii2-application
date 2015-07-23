<?php

use yii\web\View;
use dee\adminlte\Nav;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this View */
if (Yii::$app->user->isGuest) {
    $userItem = [
        'icon' => 'user-times',
        'items' => [
            ['label' => 'Login', 'url' => ['/user/login']],
            'icon' => 'sign-in',
            ['label' => 'Signup', 'url' => ['/user/signup']],
        ]
    ];
} else {
    /* @var $user app\models\ar\User */
    $user = Yii::$app->user->identity;
    $name = $user->profile ? $user->profile->fullname : $user->username;
    $label = Html::img(['/file','id'=>$user->profile ? $user->profile->photo_id : null], ['class' => 'user-image']) .
        Html::tag('span', $name, ['class' => 'hidden-xs']);
    $userItem = [
        'label' => $label,
        'icon' => 'user',
        'options' => ['class' => 'user user-menu'],
        'url' => '#',
        'items' => [
            ['label' => 'Change password', 'url' => ['/user/change-password']],
            [
                'label' => 'Logout',
                'icon' => 'sign-out',
                'url' => ['/user/logout'],
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
                    ['icon' => 'gears', 'options' => ['data-toggle' => 'control-sidebar']]
                ]
            ]);
            ?>
        </div>
    </nav>
</header>