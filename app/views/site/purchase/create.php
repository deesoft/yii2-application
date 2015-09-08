<?php
use dee\angular\NgView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $widget NgView */

?>

<div class="purchase-create">

    <page title="New Purchase"></page>

    <?= $this->render('_form', [
        'widget' => $widget,
    ]) ?>

</div>