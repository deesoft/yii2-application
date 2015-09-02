<?php

use dee\angular\NgView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $widget NgView */

?>

<div class="movement-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="box box-primary">
        <div class="box-header with-border">
            <div class="btn-group">
                <a ng-href="#/movement" class="btn btn-success btn-sm">Index</a>
            </div>
            <div class="btn-group" ng-if="model.status == 10">
                <a ng-href="#/movement/{{paramId}}/edit" class="btn btn-primary btn-sm">Update</a>
                <a href="javascript:;" ng-click="deleteModel()"class="btn btn-danger btn-sm">Delete</a>
            </div>
            <div class="btn-group">
                <a class="btn btn-primary btn-sm" ng-click="apply()" ng-if="model.status == 10">Apply</a>
                <a class="btn btn-danger btn-sm" ng-click="reject()" ng-if="model.status == 20">Reject</a>
            </div>
        </div>
        <div class="box-body">
            <table class="table table-striped table-bordered detail-view">
                <tr><th>Number</th><td>{{model.number}}</td></tr>
                <tr><th>Type</th><td>{{model.type==10?'Goods Receive':'Goods Issue'}}</td></tr>
                <tr ng-if="model.reff_type">
                    <th>Reference</th>
                    <td>{{model.reff_name}} <a ng-href="#{{model.reff_url}}/{{model.reff_id}}">{{model.reff_number}}</a></td>
                </tr>
                <tr><th>Branch</th><td>{{model.branch.name}}</td></tr>
                <tr><th>Warehouse</th><td>{{model.warehouse.name}}</td></tr>
                <tr><th>Date</th><td>{{model.date| date:'dd-MM-yyyy'}}</td></tr>
                <tr><th>Status</th><td>{{model.nmStatus}}</td></tr>
            </table>
        </div>
        <div class="box-footer">
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
                            <tr ng-repeat="(idx,item) in model.items" data-key="{{idx}}">
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