<?php
use dee\angular\NgView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $widget NgView */

?>

<div class="product-update">

    <page title="Update Product: {{model.name}}"></page>
    <?= $this->render('_form', [
        'widget' => $widget,
    ]) ?>

</div>