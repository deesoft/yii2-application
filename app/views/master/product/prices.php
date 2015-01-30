<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\master\ProductGroup;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $searchModel app\models\master\searchs\Product */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'=>'group_id',
                'label'=>'Group',
                'filter'=> ArrayHelper::map(ProductGroup::find()->all(), 'id', 'name'),
                'value'=>'group.name'
            ],
            'category.name',
            'code',
            'name',
            'prices.priceCategory.name',
            'prices.price',
            // 'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
