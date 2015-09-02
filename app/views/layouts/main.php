<?php

use yii\helpers\Html;
use dee\adminlte\AdminlteAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AdminlteAsset::register($this);
$this->registerJsFile('@web/js/md5.js');
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
            <?= $this->render('header'); ?>
            <?= $this->render('sidebar'); ?>
            <div class="content-wrapper">
                <section class="content-header">
                    <h1 ng-bind="Page.title"><?= Yii::$app->name; ?></h1>
                    <ul class="breadcrumb">
                        <li><a href="#/">Home</a></li>
                        <li ng-repeat="item in Page.breadcrumbs">
                            <a ng-href="{{item.url}}">
                                <i class="fa" ng-class="'fa-'+item.icon" ng-if="!!item.icon"></i>
                                {{item.label}}</a>
                        </li>
                    </ul>
                </section>
                <section class="content">
                    <?= $content ?>
                </section>
            </div>

            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    Version 2.0
                </div>
                <strong>Copyright &copy; 2015 <a href="#">Deesoft</a>.</strong> All rights reserved.
            </footer>
            <?= $this->render('control-sidebar'); ?>
        </div>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
