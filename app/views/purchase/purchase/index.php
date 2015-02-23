<?php

use app\components\JsBlock;
use yii\web\View;
use dee\angular\AngularRouteAsset;
use dee\angular\AngularBootstrapAsset;

/* @var $this yii\web\View */
AngularRouteAsset::register($this);
AngularBootstrapAsset::register($this);
?>

<div ng-app="dApp"><div ng-view=""></div></div>

<?php JsBlock::widget(['pos' => View::POS_END,'viewFile'=>'_script']) ?>
