<?php
use dee\angular\NgView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $widget NgView */

?>

<div class="purchase-update">

    <page title="Update Purchase: {{model.number}}"></page>

    <?= $this->render('_form', [
        'widget' => $widget,
    ]) ?>

</div>