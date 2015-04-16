<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\purchase\Purchase;
use app\models\inventory\GoodsMovement;

/* @var $this yii\web\View */
/* @var $model Purchase */
/* @var $grModel GoodsMovement */

$this->title = $model->number;
$this->params['breadcrumbs'][] = ['label' => 'Purchase', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="col-lg-12" style="padding-left: 0px;">
    <div class="panel panel-primary">
        <?php
        echo DetailView::widget([
            'options' => ['class' => 'table table-striped detail-view', 'style' => 'padding:0px;'],
            'model' => $model,
            'attributes' => [
                'number',
                'nmSupplier',
                'Date',
                'value',
                'nmStatus',
            ],
        ]);
        ?>
    </div>
</div>
<div class="col-lg-12">
    <?php
    echo yii\grid\GridView::widget([
        'tableOptions' => ['class' => 'table table-striped'],
        'layout' => '{items}',
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'number',
            'date',
        ]
    ]);
    ?>
</div>
<?php if ($grModel->status == GoodsMovement::STATUS_OPEN) {
    echo $this->render('_gr_edit', [
        'model'=>$model,
        'grModel'=>$grModel,
    ]);
}  else {
    echo $this->render('_gr_view', [
        'model'=>$model,
        'grModel'=>$grModel,
    ]);
}
?>
