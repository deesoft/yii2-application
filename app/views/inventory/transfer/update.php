<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\sales\Sales */

$this->title = 'Update Sales: ' . ' ' . $model->number;
$this->params['breadcrumbs'][] = ['label' => 'Sales', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->number, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="purchase-update">
    <?= $this->render('_form', [
        'model' => $model,
        'details' => $details,
    ]) ?>

</div>
