<?php

use yii\helpers\Html;
use app\components\Toolbar;

/* @var $this yii\web\View */
/* @var $model app\models\master\Price */

$this->title = 'Update Price: ' . ' ' . $model->product->name;
$this->params['breadcrumbs'][] = ['label' => 'Prices', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->product_id, 'url' => ['view', 'product_id' => $model->product_id, 'price_category_id' => $model->price_category_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="col-lg-8 price-update">
    <?php
    echo Toolbar::widget(['items' => [
    ['label' => 'Create', 'url' => ['create'], 'icon' => 'fa fa-plus-square', 'linkOptions' => ['class' => 'btn btn-success btn-sm']],
    ['label' => 'Detail', 'url' => ['view', 'product_id' => $model->product_id, 'price_category_id'=>$model->price_category_id], 'icon' => 'fa fa-search', 'linkOptions' => ['class' => 'btn bg-navy btn-sm']],
    //['label' => 'Update', 'url' => ['update', 'product_id' => $model->product_id, 'price_category_id'=>$model->price_category_id], 'icon' => 'fa fa-pencil', 'linkOptions' => ['class' => 'btn btn-warning btn-sm']],
    ['label' => 'Delete', 'url' => ['delete', 'product_id' =>$model->product_id, 'price_category_id'=>$model->price_category_id], 'icon' => 'fa fa-trash-o', 'linkOptions' => ['class' => 'btn btn-danger btn-sm', 'data' => ['confirm' => 'Are you sure you want to delete this item?', 'method' => 'post']]],
    ['label' => 'List', 'url' => ['index'], 'icon' => 'fa fa-list', 'linkOptions' => ['class' => 'btn btn-info btn-sm']]
    ]]);
    ?>
    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
