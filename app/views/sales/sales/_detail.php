<?php

use yii\web\JsExpression;
use yii\jui\AutoComplete;
use yii\helpers\Html;
use app\models\sales\SalesDtl;
use mdm\widgets\TabularInput;

/* @var $details SalesDtl[] */
/* @var $model app\models\sales\Sales */
/* @var $this yii\web\View */
?>
<div class="box box-info">
    <div class="box-body no-padding">
        <div class="row" style="padding: 10px;">
            <div class="col-xs-8">
                Product :
                <?php
                echo AutoComplete::widget([
                    'name' => 'product',
                    'id' => 'product',
                    'clientOptions' => [
                        'source' => new JsExpression('biz.master.sourceProduct'),
                        'select' => new JsExpression('biz.sales.onProductSelect'),
                        'delay' => 100,
                    ], 'options' => ['class' => 'form-control'],
                ]);
                ?>
            </div>
            <div class="col-xs-4">
                Item Discount:
                <?= Html::activeTextInput($model, 'discount', [ 'id' => 'item-discount', 'class' => 'form-control']); ?>
            </div>
        </div> 
        <table class="tabular table-striped">
            <thead>
            <th class="col-lg-4">Product</th>
            <th class="col-lg-1">Qty</th>
            <th class="col-lg-2">Uom</th>
            <th class="col-lg-2">@Price</th>
            <th class="col-lg-2">Sub Total</th>
            <th class="col-lg-1">&nbsp;</th>
            </thead>
            <?=
            TabularInput::widget([
                'id' => 'detail-grid',
                'allModels' => $details,
                'modelClass' => SalesDtl::className(),
                'options' => ['tag' => 'tbody'],
                'itemOptions' => ['tag' => 'tr'],
                'itemView' => '_item_detail',
                'clientOptions' => [
                ]
            ])
            ?>
        </table>
    </div>
    <div class="box-footer"> 
        <?= Html::activeHiddenInput($model, 'value', ['id' => 'sales-value']); ?>
        <h4 id="bfore" style="display: none;">Rp <span id="sales-val">0</span>-<span id="disc-val">0</span></h4>         
        <h2>Rp <span id="total-price"></span></h2>
    </div>
</div>  