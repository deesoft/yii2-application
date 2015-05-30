<?php

use yii\helpers\Html;
use dee\adminlte\AdminlteAsset;
use dee\adminlte\widgets\Nav;
use yii\widgets\Breadcrumbs;
use mdm\admin\components\MenuHelper;

/* @var $this \yii\web\View */
/* @var $content string */

AdminlteAsset::register($this);
$breadcrumbs = isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [];

$menuCallback = function($menu) {
        $item = [
            'label' => $menu['name'],
            'url' => MenuHelper::parseRoute($menu['route']),
        ];
        if (!empty($menu['data'])) {
            $item['icon'] = $menu['data'];
        } else {
            $item['icon'] = 'angle-double-right';
        }
        if ($menu['children'] != []) {
            $item['items'] = $menu['children'];
        }
        return $item;
    };

    $items = MenuHelper::getAssignedMenu(Yii::$app->user->id, null, $menuCallback);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <?php $this->beginBody() ?>
    <body class="skin-blue sidebar-mini">
        <div class="wrapper">

            <!-- Main Header -->
            <header class="main-header">

                <!-- Logo -->
                <a href="<?= Yii::$app->homeUrl; ?>" class="logo">
                    <span class="logo-mini"><b>D</b>ee</span>
                    <span class="logo-lg"><?= Yii::$app->name ?></span>
                </a>

                <!-- Header Navbar -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    <!-- Navbar Right Menu -->
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!--                <li ...-->
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">

                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar Menu -->
                    <?php
                    echo Nav::widget([
                        'options' => [
                            'class' => 'sidebar-menu',
                        ],
                        'items' => $items,
                    ]);
                    ?>
                    <!-- /.sidebar-menu -->
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        <?= $this->title; ?>
                    </h1>
                    <?=
                    Breadcrumbs::widget([
                        'tag' => 'ol',
                        'encodeLabels' => false,
                        'homeLink' => ['label' => '<i class="fa fa-dashboard"></i> Home/Dashboard', 'url' => ['/site/index']],
                        'links' => $breadcrumbs,
                    ])
                    ?>
                </section>

                <!-- Main content -->
                <section class="content">
                    <?= $content ?>
                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->

            <!-- Main Footer -->
            <footer class="main-footer">
                <!-- To the right -->
                <div class="pull-right hidden-xs">
                    Anything you want
                </div>
                <!-- Default to the left -->
                <strong>Copyright &copy; 2015 <a href="#">Deesoft</a>.</strong> All rights reserved.
            </footer>
        </div><!-- ./wrapper -->
        <?php $this->endBody() ?>
    </body>

</html>
<?php $this->endPage() ?>
