<?php

use dee\angular\NgView;

/* @var $this yii\web\View */
/* @var $widget NgView */

$widget->renderJs('js/_form.js');
?>

<div class="product-form">
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
                        <div class="form-group required" ng-class="{error:errors.code}">
                            <label for="product-code" class="control-label">Code</label>
                            <input id="product-code" name="code" class="form-control" ng-model="model.code">
                            <div class="help-block">{{errors.code}}</div>
                        </div>
                        <div class="form-group required" ng-class="{error:errors.name}">
                            <label for="product-name" class="control-label">Name</label>
                            <input id="product-code" name="name" class="form-control" ng-model="model.name">
                            <div class="help-block">{{errors.name}}</div>
                        </div>
                        <div class="form-group required" ng-class="{error:errors.category_id}">
                            <label for="product-category_id" class="control-label">Category</label>
                            <select id="product-category_id" name="category_id" class="form-control" ng-model="model.category_id"
                                    ng-options="category.id as category.name for category in categories">
                            </select>
                            <div class="help-block">{{errors.category_id}}</div>
                        </div>
                        <div class="form-group required" ng-class="{error:errors.group_id}">
                            <label for="product-group_id" class="control-label">Group</label>
                            <select id="product-group_id" name="group_id" class="form-control" ng-model="model.group_id"
                                    ng-options="group.id as group.name for group in productGroups">
                            </select>
                            <div class="help-block">{{errors.group_id}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>