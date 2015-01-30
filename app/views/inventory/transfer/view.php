<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\inventory\Transfer;

/* @var $this yii\web\View */
/* @var $model Transfer */

$this->title = $model->number;
$this->params['breadcrumbs'][] = ['label' => 'Sales', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-lg-12">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1-1" data-toggle="tab">Header</a></li>
            <li><a href="#tab_2-2" data-toggle="tab"><i class="fa fa-money"></i> Finance & Costing</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1-1" style="min-height: 10em;">
                <?php
                echo DetailView::widget([
                    'options' => ['class' => 'table table-striped detail-view'],
                    'model' => $model,
                    'attributes' => [
                        'number',
                        'branch.name',
                        'date:date',
                        'nmStatus',
                    ],
                ]);
                ?>
                <?php
                if ($model->status == Transfer::STATUS_DRAFT) {
                    echo Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) . ' ';
                    echo Html::a('Delete', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data-confirm' => Yii::t('app', 'Are you sure to delete this item?'),
                        'data-method' => 'post',
                    ]) . ' ';
                }
                echo Html::a('Release', ['release', 'id' => $model->id], [
                    'class' => 'btn btn-success',
                ]);
                ?>
            </div> 
            <div class="tab-pane" id="tab_2-2">
                Shipping Cost, dll.
            </div>
        </div>
    </div>
</div>   

<div class="col-lg-12">
    <div class="box box-info">
        <div class="box-body no-padding">
            <?php
            echo yii\grid\GridView::widget([
                'tableOptions' => ['class' => 'table table-striped'],
                'layout' => '{items}',
                'dataProvider' => new \yii\data\ActiveDataProvider([
                    'query' => $model->getTransferDtls(),
                    'sort' => false,
                    'pagination' => false,
                    ]),
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'product.name',
                    'qty',
                    'total_release',
                    'total_receive',
                    'uom.name',
                ]
            ]);
            ?>
        </div>
    </div>
</div>

