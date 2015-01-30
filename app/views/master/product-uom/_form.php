<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\master\Uom;

/* @var $this yii\web\View */
/* @var $model app\models\master\ProductUom */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-uom-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'product_id')->textInput() ?>

    <?= $form->field($model, 'uom_id')->dropDownList(Uom::selectOptions()) ?>

    <?= $form->field($model, 'isi')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
