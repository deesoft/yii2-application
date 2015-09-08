<?php

use yii\web\View;
use dee\angular\NgView;
use yii\helpers\Url;

//use yii\helpers\Html;

/* @var $this View */

$baseApiUrl = Yii::$app->params['rest.baseUrl'];
$this->registerJsFile($baseApiUrl . 'master');
$this->registerJsFile('@web/js/md5.js');

$this->params['sideMenu'] = require (__DIR__ . '/_menu.php');
?>
<?=
NgView::widget([
    'name' => 'dApp',
    'useNgApp' => false,
    'requires' => ['ngResource', 'ui.bootstrap', 'dee.ui', 'dee.rest', 'validation', 'validation.rule'],
    'routes' => require (__DIR__ . '/_routes.php'),
    'js' => ['_js/app.js', '_js/model.js', '_js/input.js'],
    'clientOptions' => [
        'loginUrl' => Url::to(['site/login']),
        'baseApiUrl' => $baseApiUrl,
        'token' => Yii::$app->user->isGuest ? null : Yii::$app->user->identity->token,
    ],
    'injection' => ['$scope', '$injector'],
//    'remote'=>true,
])?>