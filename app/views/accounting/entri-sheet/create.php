<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\accounting\EntriSheet */

$this->title = 'Create Entri Sheet';
$this->params['breadcrumbs'][] = ['label' => 'Entri Sheets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="entri-sheet-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
