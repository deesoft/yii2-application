<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use dee\easyui\EasyuiAsset;
use dee\easyui\NavTree;

/**
 * @var \yii\web\View $this
 * @var string $content
 */
EasyuiAsset::register($this);
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
    </head>
    <?php $this->beginBody() ?>
    <body class="easyui-layout" style="text-align:left">
        <div region="north" border="false" style="background:#666;text-align:center">
        </div>
        <div region="west" split="true" title="Plugins" style="width:250px;padding:5px;">
            <?php
            $items = [];
            ?>
            <?=
            NavTree::widget([
                'items' => $items,
            ]);
            ?>
        </div>
        <div region="center">
            <div class="easyui-layout" data-options="fit:true">
                <div region="north" border="false" style="height: 80px;">
                    <h1>
                        <?= '&nbsp;' . Html::encode($this->title) ?>
                        <small><?php echo \Yii::$app->controller->id . '-' . \Yii::$app->controller->action->id; ?></small>
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
                        'tag' => 'ol',
                        'encodeLabels' => false,
                        'homeLink' => ['label' => '<i class="fa fa-dashboard"></i> Home/Dashboard', 'url' => ['/site/index']],
                        'links' => $breadcrumbs,
                    ])
                    ?>
                </div>
                <div region="center">
                    <?= $content; ?>
                </div>
            </div>
        </div>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
