<?php

use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\widgets\Breadcrumbs;
use app\components\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

app\assets\AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <style>
            .breadcrumb {
                background-color: #f5f5f5;
                border-radius: 4px;
                list-style: outside none none;
                margin-bottom: 20px;
                padding: 8px 15px;
            }
        </style>
    </head>
    <?php $this->beginBody() ?>
    <body class="skin-blue sidebar-mini">
        <div class="wrapper">
        <header class="main-header">
            <?php echo $this->render('heading'); ?>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <aside class="right-side">
                <section class="content-header">
                    <h1>
                        <?= '&nbsp;' . Html::encode($this->title) ?>
                        <small></small>
                    </h1>
                    <?php
                    $breadcrumbs = isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [];
                    foreach (Yii::$app->controller->modules as $module) {
                        if ($module != Yii::$app) {
                            array_unshift($breadcrumbs, ['label' => Inflector::camel2words($module->id), 'url' => ['/' . $module->uniqueId]]);
                        }
                    }
                    ?>
                    <?=
                    Breadcrumbs::widget([
                        'tag'=>'ol',
                        'encodeLabels'=>false,
                        'homeLink'=>['label'=>'<i class="fa fa-dashboard"></i> Home/Dashboard','url'=>['/site/index']],
                        'links' => $breadcrumbs,
                    ])
                    ?>
                </section>
                <section class="content">
                    <?= Alert::widget() ?>
                    <?= $content ?>
                </section>
            </aside>            
            <aside class="left-side sidebar-offcanvas">
                <?php echo $this->render('sidebar'); ?>
            </aside>
        </div>
            </div>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
