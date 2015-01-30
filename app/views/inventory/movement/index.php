<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\inventory\GoodsMovement;
use biz\core\base\Configs;
use app\components\Toolbar;
use app\models\master\Warehouse;

/* @var $this yii\web\View */
/* @var $searchModel app\models\inventory\searchs\GoodsMovement */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Good Movements';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="good-movement-index">
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
                <?php
                $filterRef = [];
                foreach (Configs::movement() as $key => $value) {
                    $filterRef[$key] = isset($value['name']) ? $value['name'] : $key;
                }
                ?>
                <?php \yii\widgets\Pjax::begin(['enablePushState' => false]); ?>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'layout' => "{items}\n{pager}",
                    'tableOptions' => ['class' => 'table table-striped'],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'number',
                        'date:date',
                        [
                            'attribute' => 'type',
                            'value' => 'nmType',
                            'filter' => [
                                GoodsMovement::TYPE_RECEIVE => 'Receive',
                                GoodsMovement::TYPE_ISSUE => 'Issue',
                            ]
                        ],
                        [
                            'attribute' => 'reff_type',
                            'value' => 'nmReffType',
                            'filter' => $filterRef,
                        ],
                        [
                            'label' => 'Reference',
                            'value' => 'reffLink',
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'warehouse_id',
                            'value' => 'warehouse.name',
                            'filter' => Warehouse::selectOptions(),
                        ],
                        [
                            'attribute' => 'status',
                            'value' => 'nmStatus',
                            'filter' => [
                                GoodsMovement::STATUS_DRAFT => 'Draft',
                                GoodsMovement::STATUS_PROCESS => 'Proccess',
                                GoodsMovement::STATUS_CLOSE => 'Closed',
                            ]
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{view}{update}{delete}{apply}',
                        ],
                    ],
                ]);
                ?>
                <?php \yii\widgets\Pjax::end(); ?>
            </div>
        </div>
    </div>