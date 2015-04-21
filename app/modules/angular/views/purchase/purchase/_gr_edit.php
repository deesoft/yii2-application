<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\master\Warehouse;
use yii\helpers\ArrayHelper;
use app\models\inventory\GoodsMovementDtl;

/* @var $this yii\web\View */
/* @var $grModel app\models\inventory\GoodsMovement */
/* @var $model app\models\purchase\Purchase */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(); ?>
<div class="box box-warning orgn-form">
    <div class="box-body">
        <?= $form->field($grModel, 'number')->textInput(['readonly' => true]) ?>
        <?= $form->field($grModel, 'warehouse_id')->dropDownList(ArrayHelper::map(Warehouse::find()->all(), 'id', 'name')) ?>
        <?=
            $form->field($grModel, 'Date')
            ->widget('yii\jui\DatePicker', [
                'options' => ['class' => 'form-control'],
        ]);
        ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
</div>
<div>
    <?php
    $grDtls = ArrayHelper::index($grModel->goodsMovementDtls, 'product_id');
    $i = 1;
    ?>
    <table class="table table-striped">
        <tbody>
            <?php foreach ($model->purchaseDtls as $pchDtl) { ?>
                <?php
                $grDtl = isset($grDtls[$pchDtl->product_id]) ? $grDtls[$pchDtl->product_id] : new GoodsMovementDtl([
                    'product_id' => $pchDtl->product_id,
                ]);
                ?>
                <tr>
                    <td width="50px"><?= $i++ ?><?= Html::activeHiddenInput($grDtl, 'product_id') ?></td>
                    <td width="250px"><?= $pchDtl->product->name; ?></td>
                    <td width="50px"><?= $pchDtl->qty ?></td>
                    <td width="50px"><?= Html::activeTextInput($grDtl, 'qty'); ?></td>
                </tr>
            <?php } ?>            
        </tbody>
    </table>
</div>
<?php ActiveForm::end(); ?>
