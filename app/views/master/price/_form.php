<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;
use yii\jui\AutoComplete;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\master\Price */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-warning price-category-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body">
        <?=
        $form->field($model, 'nmProduct')->widget('yii\jui\AutoComplete', [
            'clientOptions' => [
                'source' => new JsExpression('biz.master.sourceProduct'),
                'search' => new JsExpression('biz.price.onProductSearch'),
                'select' => new JsExpression('biz.price.onProductSelect'),
                ],
            'options' => ['class' => 'form-control']
        ])
        ?>
        <?= $form->field($model, 'price_category_id')->dropDownList(\app\models\master\PriceCategory::selectOptions(), ['style' => 'width:200px;']) ?>
        <?= $form->field($model, 'price')->input('number', ['style' => 'width:150px;']) ?>
    </div>

    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<?php
app\assets\BizWidget::widget([
    'config' => [
        'masters' => ['products']
    ],
    'scripts' => [
        View::POS_END => $this->render('_script')
    ]
]);
