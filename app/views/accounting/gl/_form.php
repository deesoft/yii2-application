<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\accounting\GlHeader */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-warning gl-header-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body">
        <?= $form->field($model, 'number')->textInput(['maxlength' => 16]) ?>

        <?= $form->field($model, 'date')->textInput() ?>

        <?= $form->field($model, 'periode_id')->textInput() ?>

        <?= $form->field($model, 'branch_id')->textInput() ?>

        <?= $form->field($model, 'reff_type')->textInput() ?>

        <?= $form->field($model, 'reff_id')->textInput() ?>

        <?= $form->field($model, 'description')->textInput(['maxlength' => 255]) ?>

        <?= $form->field($model, 'status')->textInput() ?>
    </div>
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

