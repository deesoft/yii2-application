<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\accounting\AccPeriode;

/* @var $this yii\web\View */
/* @var $model app\models\accounting\AccPeriode */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-warning">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body">

        <?= $form->field($model, 'name')->textInput(['maxlength' => 32]) ?>

        <?= '' //$form->field($model, 'date_from')->textInput() ?>
        <?=
                $form->field($model, 'DateFrom')
                ->widget('yii\jui\DatePicker', [
                    'options' => ['class' => 'form-control', 'style' => 'width:50%'],
                        //'dateFormat' => 'php:d-m-Y',
        ]);
        ?>

        <?= ''//$form->field($model, 'date_to')->textInput() ?>
        <?=
                $form->field($model, 'DateTo')
                ->widget('yii\jui\DatePicker', [
                    'options' => ['class' => 'form-control', 'style' => 'width:50%'],
                        //'dateFormat' => 'php:d-m-Y',
        ]);
        ?>

        <?= ''//$form->field($model, 'status')->textInput() ?>
        <?php
        $dList = [
            AccPeriode::STATUS_DRAFT => 'Draft',
            AccPeriode::STATUS_ACTIVE => 'Active',
            AccPeriode::STATUS_CLOSE => 'Close',
        ];
        $dataList=ArrayHelper::map($dList, 'status', 'name');
        echo $form->field($model, 'status')->dropDownList($dList);
        ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
