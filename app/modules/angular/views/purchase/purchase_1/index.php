<?php

use yii\web\View;
use yii\helpers\Url;
use app\angular\ModuleAsset;

/* @var $this View */

ModuleAsset::register($this);
$this->registerJsFile(Url::to(['index', 'view' => 'masters']), ['depends' => 'app\angular\ModuleAsset']);
$this->registerJsFile(Url::to(['index', 'view' => 'app.js']), ['depends' => 'app\angular\ModuleAsset']);
?>

<div ng-app="dApp" ng-view=""></div>
