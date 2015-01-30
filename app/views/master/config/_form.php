<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $schema array */
/* @var $model app\models\master\GlobalConfig */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-warning config-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'name')->textInput(['maxlength' => 32]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => 255]) ?>

    <?php foreach ($schema as $col): ?>
        <?= $form->field($model, $col)->textInput() ?>
    <?php endforeach; ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
