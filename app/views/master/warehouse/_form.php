<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\master\Branch;

/* @var $this yii\web\View */
/* @var $model app\models\master\Warehouse */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="warehouse-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'branch_id')->dropDownList(Branch::selectOptions()) ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => 4]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 32]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
