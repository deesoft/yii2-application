<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\components\Toolbar;
use app\models\master\Branch;

/* @var $this yii\web\View */
/* @var $searchModel app\models\purchase\searchs\Purchase */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sales';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchase-index">
    <?php
    echo Toolbar::widget(['items' => [
            ['label' => 'Create', 'url' => ['create'], 'icon' => 'fa fa-plus-square', 'linkOptions' => ['class' => 'btn btn-success btn-sm']],
        //['label' => 'Detail', 'url' => ['view', 'id' => $model->id],'icon' => 'fa fa-search', 'linkOptions' => ['class' => 'btn bg-navy btn-sm']],
        //['label' => 'Update', 'url' => ['update', 'id' => $model->id],'icon' => 'fa fa-pencil', 'linkOptions' => ['class' => 'btn btn-warning btn-sm']],
        //['label' => 'Delete', 'url' => ['delete', 'id' => $model->id],'icon' => 'fa fa-trash-o', 'linkOptions' => ['class' => 'btn btn-danger btn-sm', 'data' => ['confirm' => 'Are you sure you want to delete this item?', 'method' => 'post']]],
        //['label' => 'List', 'url' => ['index'],'icon' => 'fa fa-list', 'linkOptions' => ['class' => 'btn btn-info btn-sm']]
    ]]);
    ?>
    <div class="box box-info">
        <div class="box-body no-padding">
            <?php \yii\widgets\Pjax::begin(['enablePushState'=>false]); ?>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'layout' => "{items}\n{pager}",
                'tableOptions' => ['class' => 'table table-striped'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'number',
                    [
                        'attribute' => 'branch_id',
                        'value' => 'branch.name',
                        'filter' => Branch::selectOptions(),
                    ],
                    [
                        'attribute' => 'branch_dest_id',
                        'value' => 'destBranch.name',
                        'filter' => Branch::selectOptions(),
                    ],
                    'date:date',
                    [
                        'attribute' => 'status',
                        'value' => 'nmStatus'
                    ],
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]);
            ?>
            <?php \yii\widgets\Pjax::end(); ?>
        </div>
    </div>
</div>

