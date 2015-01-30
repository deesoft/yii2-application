<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model yii\base\DynamicModel */
/* @var $schema array */


$this->title = 'Create '.$group;
$this->params['breadcrumbs'][] = ['label' => $group, 'url' => ['index','group'=>$group]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="global-config-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    $this->render('_form', [
        'model' => $model,
        'group' => $group,
        'schema' => $schema
    ])
    ?>

</div>
