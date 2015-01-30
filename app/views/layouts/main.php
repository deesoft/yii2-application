<?php

use yii\helpers\Html;
use dee\easyui\EasyuiAsset;
use dee\easyui\NavTree;

/* @var $this \yii\web\View */
/* @var $content string */

EasyuiAsset::register($this);
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
    <body class="easyui-layout" style="background: #eee;text-align:left;">
        <div region="north" border="false" style="background:#3c8dbc;height: 70px;">
            <h2>
                <?= Html::a(Yii::$app->name, Yii::$app->homeUrl) ?>
            </h2>
        </div>
        <div region="west" title="Nav" style="width:250px;padding:5px;">
            <?php
            $items = [
                'satu',
                [
                    'label' => 'dua',
                    'items' => [
                        'dua-satu',
                        'dua-dua'
                    ]
                ],
                [
                    'label' => 'tiga',
                    'url' => ['tiga']
                ]
            ];
            ?>
            <?=
            NavTree::widget([
                'items' => $items,
            ]);
            ?>
        </div>
        <div region="center" style="padding-left: 20px;padding-top: 10px;">
            <?= $content; ?>
        </div>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
