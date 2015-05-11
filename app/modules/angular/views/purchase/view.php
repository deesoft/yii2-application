<?php
use dee\angular\Angular;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $angular Angular */

Angular::renderScript('js/view.js');
?>

<div class="purchase-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <a ng-href="#/update/{{paramId}}" class="btn btn-primary">Update</a>
        <a href="javascript:;" ng-click="deleteModel()"class="btn btn-danger">Delete</a>
    </p>

    <table class="table table-striped table-bordered detail-view">
        <tr><th>ID</th><td>{{model.id}}</td></tr>
        <tr><th>Number</th><td>{{model.number}}</td></tr>
        <tr><th>Supplier ID</th><td>{{model.supplier_id}}</td></tr>
        <tr><th>Branch ID</th><td>{{model.branch_id}}</td></tr>
        <tr><th>Date</th><td>{{model.date}}</td></tr>
        <tr><th>Value</th><td>{{model.value}}</td></tr>
        <tr><th>Discount</th><td>{{model.discount}}</td></tr>
        <tr><th>Status</th><td>{{model.status}}</td></tr>
    </table>
</div>