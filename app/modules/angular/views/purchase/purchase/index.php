<?php

use yii\web\View;
use yii\helpers\Url;
use dee\angular\AngularAsset;
use dee\angular\AngularBootstrapAsset;
use dee\angular\AngucompleteAsset;

/* @var $this View */
AngularAsset::register($this);
AngularBootstrapAsset::register($this);
AngucompleteAsset::register($this);

$this->registerJsFile(Url::to(['index','view'=>'masters']),['depends'=>'dee\angular\AngularAsset']);
$this->registerJsFile(Url::to(['index','view'=>'app.js']),['depends'=>'dee\angular\AngularAsset']);
?>

<div ng-app="dApp" ng-view=""></div>
