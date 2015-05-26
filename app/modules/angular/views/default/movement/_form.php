<?php

use dee\angular\Angular;

/* @var $this yii\web\View */
/* @var $angular Angular */

$angular->renderJs('js/form.js');
?>

<div class="movement-form">
    <form name="Form" d-errors="errors">
        <div ng-if="errors.status">
            <h1>Error {{errors.status}}: {{errors.text}}</h1>
            <ul>
                <li ng-repeat="(field,msg) in errors.data">{{field}}: {{msg}}</li>
            </ul>
        </div>
        <div class="btn-group">
            <a class="btn btn-primary btn-sm" ng-click="save()">Save</a>
            <a class="btn btn-danger btn-sm" ng-click="discard()">Discard</a>
        </div>
        <div class="box box-body">
            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group required" ng-class="{error:errors.branch_id}">
                        <label for="movement-branch_id" class="control-label">Branch ID</label>
                        <input id="movement-branch_id" name="branch_id" class="form-control" ng-model="model.branch_id">
                        <div class="help-block">{{errors.branch_id}}</div>
                    </div>
                    <div class="form-group required" ng-class="{error:errors.warehouse_id}">
                        <label for="movement-warehouse_id" class="control-label">Warehouse</label>
                        <input id="movement-supplier_id" name="warehouse_id" class="form-control" ng-model="model.warehouse"
                               typeahead="warehouse as warehouse.name for warehouse in warehouses.asArray() | filter:$viewValue | limitTo:8">
                        <div class="help-block">{{errors.warehouse_id}}</div>
                    </div>
                </div>
                <div class="col-xs-6">
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
            </div>
        </div>

        <?= $this->render('_form_detail', ['angular' => $angular]) ?>

    </form>
</div>