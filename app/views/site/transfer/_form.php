<?php

use dee\angular\NgView;

/* @var $this yii\web\View */
/* @var $widget NgView */

$widget->renderJs('js/_form.js');
?>

<div class="transfer-form">
    <form name="Form">
        <div class="box box-default">
            <div class="box-header with-border">
                <div class="btn-group">
                    <a class="btn btn-primary btn-sm" ng-click="save()">Save</a>
                    <a class="btn btn-danger btn-sm" ng-click="discard()">Discard</a>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-6">
                        <div class="form-group required" ng-class="{'has-error':errors.branch_id}">
                            <label for="transfer-branch_id" class="control-label">Branch</label>
                            <select id="transfer-branch_id" name="branch_id" class="form-control" ng-model="model.branch_id"
                                    ng-options="branch.id as branch.name for branch in branchs">
                            </select>
                            <div class="help-block">{{errors.branch_id}}</div>
                        </div>
                        <div class="form-group required" ng-class="{'has-error':errors.branch_dest_id}">
                            <label for="transfer-branch_dest_id" class="control-label">Branch Destination</label>
                            <select id="transfer-branch_dest_id" name="branch_dest_id" class="form-control" ng-model="model.branch_dest_id"
                                    ng-options="branch.id as branch.name for branch in branchs">
                            </select>
                            <div class="help-block">{{errors.branch_dest_id}}</div>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group required" ng-class="{'has-error':errors.date}">
                            <label for="transfer-date" class="control-label">Date</label>
                            <p class="input-group" style="width: 50%;">
                                <input id="transfer-date" name="date" type="text" class="form-control"
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

            <?= $this->render('_form_detail', ['widget' => $widget]) ?>
        </div>
    </form>
</div>