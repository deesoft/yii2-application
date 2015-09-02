<?php

use dee\angular\NgView;

/* @var $this yii\web\View */
/* @var $widget NgView */

$widget->renderJs('js/_form.js');
?>

<div class="sales-form">
    <form name="Form" d-errors="errors">
        <div class="box box-default">
            <div class="box-header with-border">
                <div class="btn-group">
                    <a class="btn btn-primary btn-sm" ng-click="save()">Save</a>
                    <a class="btn btn-danger btn-sm" ng-click="discard()">Discard</a>
                </div>
                <div ng-if="errors.status">
                    <h1>Error {{errors.status}}: {{errors.text}}</h1>
                    <ul>
                        <li ng-repeat="(field,msg) in errors.data">{{field}}: {{msg}}</li>
                    </ul>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-6">
                        <div class="form-group required" ng-class="{error:errors.supplier_id}">
                            <label for="sales-supplier_id" class="control-label">Supplier</label>
                            <input id="sales-supplier_id" name="supplier_id" class="form-control" ng-model="model.supplier"
                                   typeahead="supplier as supplier.name for supplier in suppliers.asArray() | filter:$viewValue | limitTo:8">
                            <div class="help-block">{{errors.supplier_id}}</div>
                        </div>
                        <div class="form-group required" ng-class="{error:errors.branch_id}">
                            <label for="sales-branch_id" class="control-label">Branch</label>
                            <select id="sales-branch_id" name="branch_id" class="form-control" ng-model="model.branch_id"
                                    ng-options="branch.id as branch.name for branch in branchs.asArray()">
                            </select>
                            <div class="help-block">{{errors.branch_id}}</div>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group required" ng-class="{error:errors.date}">
                            <label for="sales-date" class="control-label">Date</label>
                            <p class="input-group" style="width: 50%;">
                                <input id="sales-date" name="date" type="text" class="form-control"
                                       ng-model="model.date" datepicker-popup="dd-MM-yyyy"
                                       is-open="dt.opened" datepicker-options="{}"
                                       ng-focus="dt.open($event)" close-text="Close" />
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default" ng-click="dt.open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                </span>
                            </p>
                            <div class="help-block">{{errors.date}}</div>
                        </div>
                        <div class="form-group" ng-class="{error:errors.discount}">
                            <label for="sales-discount" class="control-label">Discount</label>
                            <input id="sales-discount" name="discount" class="form-control" ng-model="model.discount">
                            <div class="help-block">{{errors.discount}}</div>
                        </div>
                    </div>
                </div>
            </div>

            <?= $this->render('_form_detail', ['widget' => $widget]) ?>
        </div>
    </form>
</div>