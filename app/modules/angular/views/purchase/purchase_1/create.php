<?php
/* @var $this yii\web\View */
?>
<form name="Form">
    <div class="btn-group">
        <a class="btn btn-primary btn-sm" ng-click="save()">Save</a>
        <a class="btn btn-danger btn-sm" ng-click="discard()">Discard</a>
    </div>
    <div class="box box-primary">
        <?= $this->render('_form_header'); ?>
        <?= $this->render('_form_detail'); ?>
    </div>
</form>
