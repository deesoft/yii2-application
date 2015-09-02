<?php

use dee\angular\NgView;

/* @var $this yii\web\View */
/* @var $widget NgView */

$widget->renderJs('js/_form.js');
?>
<div class="movement-form">
    <form name="Form" d-errors="errors">
        <div class="box box-default">
            <div class="box-header with-border">
                <div class="btn-group">
                    <a class="btn btn-primary btn-sm" ng-click="save()">Save</a>
                    <a class="btn btn-danger btn-sm" ng-click="discard()">Discard</a>
                </div>
            </div>
            <div class="box-body">
                <div ng-if="errors.status">
                    <h1>Error {{errors.status}}: {{errors.text}}</h1>
                    <ul>
                        <li ng-repeat="(field,msg) in errors.data">{{field}}: {{msg}}</li>
                    </ul>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <div class="form-group required" ng-class="{error:errors.type}">
                            <label for="movement-type" class="control-label">{{model.reff_type? model.type_name :'Type'}}</label>
                            <select id="movement-type" name="type" class="form-control" ng-model="model.type" ng-if="!model.reff_type">
                                <option value="10">Goods Receive</option>
                                <option value="20">Goods Issue</option>
                            </select>
                            <span ng-if="model.reff_type" class="form-control">
                                {{model.reff_name}} <a ng-href="#{{model.reff_url}}/{{model.reff_id}}">{{model.reff_number}}</a>
                            </span>
                            <div class="help-block">{{errors.type}}</div>
                        </div>
                        <div class="form-group required" ng-class="{error:errors.date}">
                            <label for="movement-date" class="control-label">Date</label>
                            <p class="input-group" style="width: 50%;">
                                <input id="movement-date" name="date" type="text" class="form-control"
                                       ng-model="model.date" datepicker-popup="dd-MM-yyyy"
                                       is-open="dt.opened" datepicker-options="{}"
                                       ng-focus="dt.open($event)" close-text="Close" />
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default" ng-click="dt.open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
                                </span>
                            </p>
                            <div class="help-block">{{errors.date}}</div>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group" ng-class="{error:errors.branch_id}">
                            <label for="movement-branch_id" class="control-label">Branch ID</label>
                            <select ng-if="!model.reff_type" id="movement-branch_id" name="branch_id" class="form-control" ng-model="model.branch_id"
                                    ng-options="branch.id as branch.name for branch in branchs.asArray()">
                            </select>
                            <span ng-if="model.reff_type" class="form-control" ng-bind="model.branch_name"></span>
                            <div class="help-block">{{errors.branch_id}}</div>
                        </div>
                        <div class="form-group required" ng-class="{error:errors.warehouse_id}">
                            <label for="movement-warehouse_id" class="control-label">Warehouse</label>
                            <select id="movement-warehouse_id" name="warehouse_id" class="form-control" ng-model="model.warehouse_id"
                                   ng-options="warehouse.id as warehouse.name for warehouse in warehouses.get(model.branch_id)">
                            </select>
                            <div class="help-block">{{errors.warehouse_id}}</div>
                        </div>
                    </div>
                </div>
            </div>

            <?= $this->render('_form_detail', ['widget' => $widget]) ?>

    </form>
</div>
</div>