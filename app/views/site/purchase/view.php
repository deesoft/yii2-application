<?php

use dee\angular\NgView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $widget NgView */

?>

<div class="purchase-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="box box-default">
        <div class="box-header with-border">
            <div class="btn-group">
                <a ng-href="#/purchase/" class="btn btn-success btn-sm">Index</a>
            </div>
            <div class="btn-group" ng-if="model.status == 10">
                <a ng-href="#/purchase/{{paramId}}/edit" class="btn btn-primary btn-sm">Update</a>
                <a href="javascript:;" ng-click="deleteModel()"class="btn btn-danger btn-sm">Delete</a>
            </div>
            <div class="btn-group">
                <a class="btn btn-primary btn-sm" ng-click="confirm()" ng-if="model.status == 10">Confirm</a>
                <a class="btn btn-danger btn-sm" ng-click="reject()" ng-if="model.status == 20">Reject</a>
                <a class="btn btn-success btn-sm"
                   ng-href="#/movement/new/100/{{paramId}}"
                   ng-if="model.status == 20">Create GR</a>
            </div>
        </div>
        <div class="box-body">
            <table class="table table-striped table-bordered detail-view">
                <tr><th>ID</th><td>{{model.id}}</td></tr>
                <tr><th>Number</th><td>{{model.number}}</td></tr>
                <tr><th>Supplier</th><td>{{model.supplier.name}}</td></tr>
                <tr><th>Branch</th><td>{{model.branch.name}}</td></tr>
                <tr><th>Date</th><td>{{model.date| date:'dd-MM-yyyy'}}</td></tr>
                <tr><th>Value</th><td>{{model.value}}</td></tr>
                <tr><th>Discount</th><td>{{model.discount}}</td></tr>
                <tr><th>Status</th><td>{{model.nmStatus}}</td></tr>
            </table>
        </div>
        <div class="box-footer">
            <tabset>
                <tab heading="Items">
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="tabular table-striped col-lg-12">
                                <thead style="background-color: #9d9d9d;">
                                    <tr>
                                        <th class="col-lg-4" style="text-align: left;">Product</th>
                                        <th class="col-lg-1" style="text-align: right;">Qty</th>
                                        <th class="col-lg-1" style="text-align: right;">Received</th>
                                        <th class="col-lg-2" style="text-align: left;">Uom</th>
                                        <th class="col-lg-2" style="text-align: right;">@Price</th>

                                        <th class="col-lg-2" style="text-align: right;">Sub Total</th>
                                    </tr>
                                </thead>
                                <tbody id="item-grid">
                                    <tr ng-repeat="(idx,item) in model.items" data-key="{{idx}}">
                                        <td >{{item.product.name}}</td>
                                        <td  style="text-align: right;">{{item.qty}}</td>
                                        <td  style="text-align: right;">{{item.total_receive}}</td>
                                        <td >{{item.uom.name}}</td>
                                        <td style="text-align: right;">{{item.price| number}}</td>
                                        <td style="text-align: right;">{{item.price * item.qty| number}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </tab>
                <tab heading="Receives" ng-if="model.status > 10">
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="tabular table-striped col-lg-12">
                                <thead style="background-color: #9d9d9d;">
                                    <tr>
                                        <th style="text-align: left;">Number</th>
                                        <th style="text-align: left;">Warehouse</th>
                                        <th style="text-align: left;">Status</th>
                                        <th width="80px"></th>
                                    </tr>
                                </thead>
                                <tbody id="item-grid">
                                    <tr ng-repeat="(idx,item) in receives" data-key="{{idx}}">
                                        <td >{{item.number}}</td>
                                        <td >{{item.warehouse.name}}</td>
                                        <td >{{item.nmStatus}}</td>
                                        <td >
                                            <a ng-href="#/movement/{{item.id}}" title="View"><span class="glyphicon glyphicon-eye-open"></span></a>
                                            <a ng-href="#/movement/{{item.id}}/edit" title="Update" ng-if="item.status == 10"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <a href ng-click="applyGR(item)" title="Apply" ng-if="item.status == 10"><span class="glyphicon glyphicon-ok-sign"></span></a>
                                            <a href ng-click="rejectGR(item)" title="Reject" ng-if="item.status == 20"><span class="glyphicon glyphicon-minus-sign"></span></a>
                                            <a href ng-click="deleteGR(item)" title="Delete" ng-if="item.status == 10"><span class="glyphicon glyphicon-trash"></span></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </tab>
            </tabset>
        </div>
    </div>

</div>