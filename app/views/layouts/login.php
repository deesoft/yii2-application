<?php

use yii\helpers\Html;
use dee\adminlte\AdminlteAsset;

/**
 * @var \yii\web\View $this
 * @var string $content
 */
AdminlteAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <?php $this->beginBody() ?>
    <body class="bg-black">
        <div class="form-box" id="login-box">
            <div class="header"><?= Html::encode($this->title) ?></div>
            <?= $content ?>
        </div>
    </body>
    <?php $this->endBody() ?>
</html>
<?php $this->endPage() ?>
