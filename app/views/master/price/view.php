<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\components\Toolbar;

/* @var $this yii\web\View */
/* @var $model app\models\master\Price */

$this->title = 'Detail Price: ' . ' ' . $model->product->name;
$this->params['breadcrumbs'][] = ['label' => 'Prices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-lg-8 price-view">
    <?php
    echo Toolbar::widget(['items' => [
    ['label' => 'Create', 'url' => ['create'], 'icon' => 'fa fa-plus-square', 'linkOptions' => ['class' => 'btn btn-success btn-sm']],
    //['label' => 'Detail', 'url' => ['view', 'product_id' => $model->product_id, 'price_category_id'->$model->price_category_id], 'icon' => 'fa fa-search', 'linkOptions' => ['class' => 'btn bg-navy btn-sm']],
    ['label' => 'Update', 'url' => ['update', 'product_id' => $model->product_id, 'price_category_id'=>$model->price_category_id], 'icon' => 'fa fa-pencil', 'linkOptions' => ['class' => 'btn btn-warning btn-sm']],
    ['label' => 'Delete', 'url' => ['delete', 'product_id' => $model->product_id, 'price_category_id'=>$model->price_category_id], 'icon' => 'fa fa-trash-o', 'linkOptions' => ['class' => 'btn btn-danger btn-sm', 'data' => ['confirm' => 'Are you sure you want to delete this item?', 'method' => 'post']]],
    ['label' => 'List', 'url' => ['index'], 'icon' => 'fa fa-list', 'linkOptions' => ['class' => 'btn btn-info btn-sm']]
    ]]);
    ?>

    <div class="box box-info orgn-view">
        <div class="box-body no-padding">
            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    //'product_id',
                    'product.code',
                    'product.name',
                    //'price_category_id',
                    'priceCategory.name',
                    'price',
                    'created_at',
                    'created_by',
                    'updated_at',
                    'updated_by',
                ],
            ])
            ?>
        </div>
    </div>
</div>
