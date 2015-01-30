<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\inventory\GoodsMovement;
use app\components\Toolbar;

/* @var $this yii\web\View */
/* @var $model GoodsMovement */

$this->title = $model->number;
$this->params['breadcrumbs'][] = ['label' => 'Good Movements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-lg-8 good-movement-view">
    <?php
    echo Toolbar::widget(['items' => [
            ['label' => 'Create', 'url' => ['create'], 'icon' => 'fa fa-plus-square', 'linkOptions' => ['class' => 'btn btn-success btn-sm']],
            //['label' => 'Detail', 'url' => ['view', 'id' => $model->id],'icon' => 'fa fa-search', 'linkOptions' => ['class' => 'btn bg-navy btn-sm']],
            ['label' => 'Update', 'url' => ['update', 'id' => $model->id], 'icon' => 'fa fa-pencil', 'linkOptions' => ['class' => 'btn btn-warning btn-sm']],
            ['label' => 'Delete', 'url' => ['delete', 'id' => $model->id], 'icon' => 'fa fa-trash-o', 'linkOptions' => ['class' => 'btn btn-danger btn-sm', 'data' => ['confirm' => 'Are you sure you want to delete this item?', 'method' => 'post']]],
            ['label' => 'Apply', 'url' => ['apply', 'id' => $model->id], 'icon' => 'fa fa-check', 'linkOptions' => ['class' => 'btn bg-navy btn-sm', 'data' => ['confirm' => 'Are you sure you want to apply this item?', 'method' => 'post']]],
            ['label' => 'List', 'url' => ['index'], 'icon' => 'fa fa-list', 'linkOptions' => ['class' => 'btn btn-info btn-sm']]
    ]]);
    ?>
    <div class="box box-primary">
        <div class="box-body no-padding">
            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'number',
                    'date:date',
                    'nmType',
                    'nmReffType',
                    'reffLink:raw:Reference',
                    'trans_value:currency',
                    'description',
                    'nmStatus',
                ],
            ])
            ?>
        </div>
    </div>
</div>
<div class="col-lg-12">    
    <div class="box box-primary">
        <div class="box-body no-padding">
            <?php
            echo yii\grid\GridView::widget([
                'tableOptions' => ['class' => 'table table-striped'],
                'layout' => '{items}',
                'dataProvider' => new \yii\data\ActiveDataProvider([
                    'query' => $model->getGoodsMovementDtls(),
                    'sort' => false,
                    'pagination' => false,
                        ]),
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'product.name',
                    'qty',
                ]
            ]);
            ?>
        </div>
    </div>
</div>


