<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\accounting\EntriSheet */

$this->title = 'Update Entri Sheet: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Entri Sheets', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="entri-sheet-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
