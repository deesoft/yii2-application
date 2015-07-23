<?php

use yii\web\View;
use yii\helpers\Html;

/* @var $this View */
$this->title = 'Profile';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-profile">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>User profile:</p>
    <?= Html::img(['/file','id'=>$model->photo_id])?>
</div>