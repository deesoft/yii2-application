<?php

use yii\web\View;
use dee\angular\NgView;
use app\assets\AppAsset;
use yii\helpers\Url;

//use yii\helpers\Html;

/* @var $this View */
AppAsset::register($this);

$baseApiUrl = Yii::$app->params['rest.baseUrl'];
$this->registerJsFile($baseApiUrl . 'master');
?>
<?=
NgView::widget([
    'requires' => ['ngResource', 'ui.bootstrap', 'dee.ui','dee.rest', 'validation', 'validation.rule', 'biz.input'],
    'routes' => require (__DIR__ . '/_routes.php'),
    'js' => 'app.js',
    'clientOptions' => [
        'loginUrl' => Url::to(['site/login']),
        'baseApiUrl' => $baseApiUrl,
        'token' => Yii::$app->user->isGuest ? null : Yii::$app->user->identity->token,
    ]
])?>