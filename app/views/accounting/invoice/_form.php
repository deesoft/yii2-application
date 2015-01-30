<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\accounting\Invoice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-warning">
    <?php $form = ActiveForm::begin(); ?>
        <div class="col-lg-6">
            <?= $form->field($model, 'number')->textInput(['readonly' => true]) ?>
            <?=
            $form->field($model, 'Date')->widget('yii\jui\DatePicker', [
                'options' => ['class' => 'form-control']
            ])
            ?>

            <?=
            $form->field($model, 'DueDate')->widget('yii\jui\DatePicker', [
                'options' => ['class' => 'form-control']
            ])
            ?>

            <?= $form->field($model, 'vendor_id')->textInput() ?>
        </div>
        <div class="col-lg-12">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>
</div>
