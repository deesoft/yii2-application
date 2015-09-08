<?php

use dee\angular\NgView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $widget NgView */
?>

<div class="product-view">
    <page title="Product: {{model.name}}"></page>

    <div class="box box-default">
        <div class="box-header with-border">
            <div class="btn-group">
                <a ng-href="#/product/" class="btn btn-success btn-sm">Index</a>
            </div>
            <div class="btn-group" ng-if="model.status == 10">
                <a ng-href="#/product/{{paramId}}/edit" class="btn btn-primary btn-sm">Update</a>
                <a href ng-click="deleteModel()"class="btn btn-danger btn-sm">Delete</a>
            </div>
        </div>
        <div class="box-body">
            <table class="table table-striped table-bordered detail-view">
                <tr><th>ID</th><td>{{model.id}}</td></tr>
                <tr><th>Code</th><td>{{model.code}}</td></tr>
                <tr><th>Name</th><td>{{model.name}}</td></tr>
                <tr><th>Category</th><td>{{model.category.name}}</td></tr>
                <tr><th>Group</th><td>{{model.group.name}}</td></tr>
            </table>
        </div>
    </div>
</div>
