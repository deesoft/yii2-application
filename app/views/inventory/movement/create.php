<?php

use yii\helpers\Html;
use app\models\inventory\GoodsMovement;

/* @var $this yii\web\View */
/* @var $model app\models\inventory\GoodsMovement */

$this->title = 'Create Good ' . ($config['type'] == GoodsMovement::TYPE_RECEIVE ? 'Receive' : 'Issue');
$this->params['breadcrumbs'][] = ['label' => 'Good Movements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-lg-12 good-movement-create">
    <?=
    $this->render('_form', [
        'model' => $model,
        'details' => $details,
        'config' => $config,
    ])
    ?>
</div>
