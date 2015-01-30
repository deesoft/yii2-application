<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\accounting\Coa;
use yii\web\JsExpression;
use yii\jui\AutoComplete;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\accounting\Coa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-warning">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body">

        <?= $form->field($model, 'type')->dropDownList(Coa::selectGroup()); ?>

        <?=
        $form->field($model, 'nmParent')->widget('yii\jui\AutoComplete', [
            'clientOptions' => [
                'source' => new JsExpression('biz.master.sourceCoa'),
                'select' => new JsExpression('biz.coa.onParentSelect'),
                'search' => new JsExpression('biz.coa.onParentSearch'),
            ],
            'options' => ['class' => 'form-control']
        ])
        ?>

        <?= $form->field($model, 'parent_id')->hiddenInput()->label(false) ?>
        <br>
        <?= $form->field($model, 'code')->textInput(['maxlength' => 16], ['style' => 'width:200px;']) ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => 64]) ?>

        <?= $form->field($model, 'normal_balance')->dropDownList(['D' => 'Debit', 'K' => 'Kredit'], ['style' => 'width:120px;']); ?>

        <?= ''//$form->field($model, 'normal_balance')->textInput(['maxlength' => 1]) ?>

    </div>
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<?php
app\assets\BizWidget::widget([
    'config' => [
        'masters' => ['coa']
    ],
    'scripts' => [
        View::POS_END => $this->render('_script')
    ]
]);
