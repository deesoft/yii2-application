<?php
use dee\angular\NgView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $widget NgView */

?>

<div class="product-create">

    <page title="New Product"></page>

    <?= $this->render('_form', [
        'widget' => $widget,
    ]) ?>

</div>