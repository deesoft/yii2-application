<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\sales\SalesDtl */
/* @var $key string */
?>    
<td class="col-lg-4">
    <span class="product"></span>
</td>
<td class="col-lg-1">
    <?= Html::activeTextInput($model, "[$key]qty", ['data-field' => 'qty', 'size' => 5, 'id' => false,  'class'=>'form-control','required' => true]) ?>
</td>
<td class="col-lg-2">
    <?= Html::activeDropDownList($model, "[$key]uom_id", [], ['data-field' => 'uom_id', 'id' => false, 'class'=>'form-control', 'style' => 'height:32px;']) ?>
</td>
<td class="col-lg-2">
    <?= Html::activeTextInput($model, "[$key]price", ['data-field' => 'price', 'size' => 16, 'id' => false, 'required' => true]) ?>
</td>
<td  class="col-lg-2">
    <input type="hidden" data-field="total_price"><span class="total-price"></span>
</td>
<td  class="col-lg-1" style="text-align: center">
    <a data-action="delete" title="Delete" href="#"><span class="glyphicon glyphicon-trash"></span></a>
    <?= Html::activeHiddenInput($model, "[$key]product_id", ['data-field' => 'product_id', 'id' => false]) ?>
    <?= Html::activeHiddenInput($model, "[$key]uom_id", ['data-field' => 'sel_uom_id', 'id' => false, 'name' => false]) ?>
</td>

