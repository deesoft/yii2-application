<?php

use dee\angular\Angular;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $angular Angular */

$angular->renderJs('js/view.js');
?>

<div class="movement-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="box box-primary">
        <div class="btn-group">
            <a ng-href="#/" class="btn btn-success btn-sm">Index</a>
        </div>
        <div class="btn-group" ng-if="model.status == 10">
            <a ng-href="#/update/{{paramId}}" class="btn btn-primary btn-sm">Update</a>
            <a href="javascript:;" ng-click="deleteModel()"class="btn btn-danger btn-sm">Delete</a>
        </div>
        <div class="btn-group">
            <a class="btn btn-primary btn-sm" ng-click="apply()" ng-if="model.status == 10">Apply</a>
            <a class="btn btn-danger btn-sm" ng-click="reject()" ng-if="model.status == 20">Reject</a>
        </div>
        <div class="box box-body">
            <table class="table table-striped table-bordered detail-view">
                <tr><th>ID</th><td>{{model.id}}</td></tr>
                <tr><th>Number</th><td>{{model.number}}</td></tr>
                <tr><th>Branch</th><td>{{model.branch.name}}</td></tr>
                <tr><th>Warehouse</th><td>{{model.warehouse.name}}</td></tr>
                <tr><th>Date</th><td>{{model.date}}</td></tr>
                <tr><th>Status</th><td>{{model.nmStatus}}</td></tr>
            </table>
        </div>
        <div class="box box-footer">
            <div class="row">
                <div class="col-lg-12">
                    <table class="tabular table-striped col-lg-12">
                        <thead style="background-color: #9d9d9d;">
                            <tr>
                                <th class="col-lg-4" style="text-align: left;">Product</th>
                                <th class="col-lg-1" style="text-align: right;">Qty</th>
                                <th class="col-lg-2" style="text-align: left;">Uom</th>
                            </tr>
                        </thead>
                        <tbody id="item-grid">
                            <tr ng-repeat="(idx,item) in items" data-key="{{idx}}">
                                <td >{{item.product.name}}</td>
                                <td  style="text-align: right;">{{item.qty}}</td>
                                <td >{{item.uom.name}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>