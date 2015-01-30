<?php

use yii\helpers\Html;
use app\components\Toolbar;
use app\models\inventory\GoodsMovement;

/* @var $this yii\web\View */
/* @var $model GoodsMovement */

$type = $config['type'] == GoodsMovement::TYPE_RECEIVE ? 'Receive' : 'Issue';
$this->title = "Update Good {$type}: {$model->number}";
$this->params['breadcrumbs'][] = ['label' => 'Good ' . $type, 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->number, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="col-lg-12 good-movement-update">
    <?php
    echo Toolbar::widget(['items' => [
            ['label' => 'Create', 'url' => ['create'], 'icon' => 'fa fa-plus-square', 'linkOptions' => ['class' => 'btn btn-success btn-sm']],
            ['label' => 'Detail', 'url' => ['view', 'id' => $model->id], 'icon' => 'fa fa-search', 'linkOptions' => ['class' => 'btn bg-navy btn-sm']],
            //['label' => 'Update', 'url' => ['update', 'id' => $model->id],'icon' => 'fa fa-pencil', 'linkOptions' => ['class' => 'btn btn-warning btn-sm']],
            ['label' => 'Delete', 'url' => ['delete', 'id' => $model->id], 'icon' => 'fa fa-trash-o', 'linkOptions' => ['class' => 'btn btn-danger btn-sm', 'data' => ['confirm' => 'Are you sure you want to delete this item?', 'method' => 'post']]],
            ['label' => 'List', 'url' => ['index'], 'icon' => 'fa fa-list', 'linkOptions' => ['class' => 'btn btn-info btn-sm']]
    ]]);
    ?>
    <?=
    $this->render('_form', [
        'model' => $model,
        'details' => $details,
        'config'=>$config,
    ])
    ?>

</div>
