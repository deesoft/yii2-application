<?php

use dee\angular\NgView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $widget NgView */
?>

<div class="purchase-index">
    <page title="Product"></page>
    <p>
        <?= Html::a('Create', '#/product/new', ['class' => 'btn btn-success']) ?>
    </p>
    <div class="grid-view">
        <table class="table">
            <tr>
                <td width='20px'>&nbsp;</td>
                <td class="col-lg-4">
                    <input class="form-control" placeholder="Search" ng-model="q"
                           ng-change="provider.search()" ng-model-options="{updateOn:'blur change'}"></td>
                <td>&nbsp;</td>
            </tr>
        </table>
        <table class="table table-striped table-bordered">
            <thead>
                <tr d-sort ng-model="provider.sort" ng-change="provider.sorting()">
                    <th>#</th>
                    <th><a href sort-field="id">Id</a></th>
                    <th><a href sort-field="code">Code</a></th>
                    <th><a href sort-field="name">Name</a></th>
                    <th><a href sort-field="category_id">Category</a></th>
                    <th><a href sort-field="group_id">Group</a></th>
                    <!--
                                        <th><a href="javascript:;" d-sort-provider="provider" sort-field="created_at">Created_at</a></th>
                                        <th><a href="javascript:;" d-sort-provider="provider" sort-field="created_by">Created_by</a></th>
                                        <th><a href="javascript:;" d-sort-provider="provider" sort-field="updated_at">Updated_at</a></th>
                                        <th><a href="javascript:;" d-sort-provider="provider" sort-field="updated_by">Updated_by</a></th>
                    -->
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="model in rows">
                    <td>{{(provider.page - 1) * provider.itemPerPage + $index + 1}}</td>
                    <td>{{model.id}}</td>
                    <td>{{model.code}}</td>
                    <td>{{model.name}}</td>
                    <td>{{model.category.name}}</td>
                    <td>{{model.group.name}}</td>
                    <!--
                                        <td>{{model.created_at}}</td>
                                        <td>{{model.created_by}}</td>
                                        <td>{{model.updated_at}}</td>
                                        <td>{{model.updated_by}}</td>
                    -->
                    <td>
                        <a ng-href="#/product/{{model.id}}"><span class="glyphicon glyphicon-eye-open"></span></a>
                        <a ng-href="#/product/{{model.id}}/edit" ><span class="glyphicon glyphicon-pencil"></span></a>
                        <a href ng-click="deleteModel(model)"><span class="glyphicon glyphicon-trash"></span></a>
                    </td>
                </tr>
            </tbody>
        </table>
        <pagination total-items="provider.totalItems" ng-model="provider.page"
                    max-size="5" items-per-page="provider.itemPerPage"
                    ng-change="provider.paging()"
                    class="pagination-sm" boundary-links="true"></pagination>
    </div>
</div>
