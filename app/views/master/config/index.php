<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $schema app\models\master\GlobalConfig */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $group;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="global-config-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create ' . $group, ['create', 'group' => $group], ['class' => 'btn btn-success']) ?>
    </p>
    <?php
    $columns = [
        ['class' => 'yii\grid\SerialColumn'],
        'name',
        'description',
    ];
    $i = 1;
    foreach ($schema as $col) {
        $columns[] = $col;
        $i++;
        if ($i > 5) {
            break;
        }
    }
    $columns[] = ['class' => 'yii\grid\ActionColumn'];
    ?>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $columns,
    ]);
    ?>

</div>
